<?php

namespace App\Http\Controllers;

use DB;
use App\SlackToken;
use App\SlackWorkspace;
use Illuminate\Http\Request;
use \Lisennk\Laravel\SlackWebApi\SlackApi;
use \Lisennk\Laravel\SlackWebApi\Exceptions\SlackApiException;
use App\User;
use App\Project;
use App\Allocation;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class SlackController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        date_default_timezone_set('US/Eastern');
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $data = [];
        $day = date('w');
        $week_start = date('Y-m-d', strtotime('-'.($day-1).' days'));
        $week_end = date('Y-m-d', strtotime('+'.(7-$day).' days'));

        try {

            $users = User::with(['userinfo' => function($query) {
                $query->where('channel_id','<>', '');            

            }])->where('slack_user_id','<>' ,'')
                ->where('workspace_id', '<>','')
                ->where('level', '=',11)
                ->paginate(100);

            $user_list = array();
            foreach ($users as $user){
                //Get time doctor user_id from time doctor email.
                $headers = [
                   'Content-Type' => 'application/json',
                   'Authorization' => 'Bearer '.env("TD_TOKEN"),
                ];

                $client = new Client(['headers' => $headers]);
                $response1 = $client->request('GET', "https://webapi.timedoctor.com/v1.1/companies/".env("TD_COMPANYID")."/users?emails=".$user['userinfo']->time_doctor_email, []);
                $TD_userInfo = json_decode($response1->getBody(), true);
                $TD_userid= $TD_userInfo['users'][0]['user_id'];

                //Get week worklog

                $response2 = $client->request('GET', "https://webapi.timedoctor.com/v1.1/companies/".env("TD_COMPANYID")."/worklogs?start_date=".$week_start."&end_date=".$week_end."&offset=0&limit=300&user_ids=".$TD_userid, []);
                $week_worklogs = json_decode($response2->getBody(), true);
                $week_hours = $week_worklogs['total'];

                //Get today worklog 

                $response3 = $client->request('GET', "https://webapi.timedoctor.com/v1.1/companies/".env("TD_COMPANYID")."/worklogs?start_date=".date("Y-m-d")."&end_date=".date("Y-m-d")."&offset=0&limit=100&user_ids=".$TD_userid, []);
                
                $today_worklogs = json_decode($response3->getBody(), true);

                $token = SlackToken::where('workspace_id', $user->workspace_id)->get()->first();

                if($token) {
                    $api = new SlackApi($token->token);

                    $project = Project::find($user->userinfo['project_id']);
                    $projects = Allocation::where('user_id', '=', $user->id)
                        ->where('is_delete', '=', '0')->pluck('project_id');

                    $project_names = Project::whereIn('id', $projects)->get()->pluck('p_name');
                    $responce = $api->execute('users.info', ['user' => $user->slack_user_id]);

                    $user_list[] = array_merge($today_worklogs['worklogs'], $responce['user'], array(
                            'week_hours' => $week_hours,
                            'avatar' => $responce['user']['profile']['image_512'],
                            'type' => '2',
                            'status' => "away",
                            'display_name' => (isset($responce['user']['profile']['display_name']) && !empty($responce['user']['profile']['display_name']))
                                ? $responce['user']['profile']['display_name'] : ( isset( $responce['user']['real_name'] ) ? $responce['user']['real_name'] : '' ) ,
                            'workspace_id' => $user->workspace_id,
                            'project' => $project_names !== null ? $project_names : [],
                            'project_id' => $project !== null ? $project->id : '',
                            'projects' => $projects !== null ? $projects: []
                        )
                    );

                }
            }

        } catch (SlackApiException $e) {

        }

        $projects = Project::all();
        return view('slack/index', ['data' => $user_list, 'projects' => $projects]);
    }

    public function updateUserStatuses_ajax(Request $request){

        $day = date('w');
        $week_start = date('Y-m-d', strtotime('-'.($day-1).' days'));
        $week_end = date('Y-m-d', strtotime('+'.(7-$day).' days'));

        $search_project = $request->input('project');
        $search_type = $request->input('type');
        $search_status = $request->input('user_status');

        if(!$search_project) $search_project = "";
        if(!$search_type) $search_type = "";
        if(!$search_status) $search_status = "";

        if ($search_type == '2' || $search_type == ''){
            $developers = User::with(['userinfo' => function($query){
                $query->where('channel_id','<>', '');
            }])->where('slack_user_id','<>' , '')
                ->where('workspace_id', '<>', '')
                ->where('type', '=', 2)
                ->where('level', '=', 11)
                ->get();
        } else {
            $developers = [];
        }

        $user_list = [];

        foreach ($developers as $developer){

            try {

                $token = SlackToken::where('workspace_id', $developer->workspace_id)->get()->first();

                if($token) {

                    $projects = Allocation::where('user_id', '=', $developer->id)->where('is_delete', '=', '0')->pluck('project_id');

                    $idx = 0;
                    $searched = false;
                    for($idx = 0; $idx < count($projects); $idx++) {
                        if(intval($search_project) == $projects[$idx]) {
                            $searched = true;
                            break;
                        }
                    }

                    if ($search_project == '' || ($search_project != '' && $searched)){
                        $api = new SlackApi($token->token);
                        $response = $api->execute('users.getPresence', ['user' => $developer['slack_user_id']]);
                        $user_status = "away";

                        if ($response['ok']) {
                            // $data[$developer['slack_id']] = $response['presence'];
                            $user_status = $response['presence'];

                            if ($search_status == '' || ($search_status != '' && $search_status == $user_status)){

                                $headers = [
                                   'Content-Type' => 'application/json',
                                   'Authorization' => 'Bearer '.env("TD_TOKEN"),
                                ];

                                $client = new Client(['headers' => $headers]);
                                $response1 = $client->request('GET', "https://webapi.timedoctor.com/v1.1/companies/".env("TD_COMPANYID")."/users?emails=".$developer['userinfo']->time_doctor_email, []);
                                $TD_userInfo = json_decode($response1->getBody(), true);
                                $TD_userid= $TD_userInfo['users'][0]['user_id'];

                                $response2 = $client->request('GET', "https://webapi.timedoctor.com/v1.1/companies/".env("TD_COMPANYID")."/worklogs?start_date=".$week_start."&end_date=".$week_end."&offset=0&limit=300&user_ids=".$TD_userid, []);
                                $week_worklogs = json_decode($response2->getBody(), true);
                                $week_hours = $week_worklogs['total'];
                                
                                $response3 = $client->request('GET', "https://webapi.timedoctor.com/v1.1/companies/".env("TD_COMPANYID")."/worklogs?start_date=".date("Y-m-d")."&end_date=".date("Y-m-d")."&offset=0&limit=100&user_ids=".$TD_userid, []);
                
                                $today_worklogs = json_decode($response3->getBody(), true);

                                $res_user_info = $api->execute('users.info', ['user' => $developer->slack_user_id]);
                                $project_names = Project::whereIn('id', $projects)->get()->pluck('p_name');
                                
                                $user_list[] = array_merge($today_worklogs['worklogs'], $res_user_info['user'], array(
                                    'week_hours' => $week_hours,
                                    'avatar' => $res_user_info['user']['profile']['image_512'],
                                    'type' => '2',
                                    'slack_user_id' => $response['presence'],
                                    'status' => $user_status,
                                    'display_name' => (isset($res_user_info['user']['profile']['display_name']) && !empty($res_user_info['user']['profile']['display_name']))
                                        ? $res_user_info['user']['profile']['display_name'] : ( isset( $res_user_info['user']['real_name'] ) ? $res_user_info['user']['real_name'] : '' ) ,
                                    'workspace_id' => $developer->workspace_id,
                                    'project_names' => $project_names !== null ? $project_names : [],
                                    'projects' => $projects !== null ? $projects: []
                                    )
                                );
                            }
                        }
                    }
                }
            } catch (SlackApiException $e) {
                return response()->json(['developer_list' => $user_list]);
            }
        }
        return response()->json(['developer_list' => $user_list]);
    }

    public function sendMessage(Request $request){
        $data = array(
            'error' => false,
            'message' => 'sent succesfull',
            'response' => []
        );
        try {
            $api = new SlackApi(env('SLACK_API_TOKEN'));

            $response = $api->execute('chat.postMessage', [
                'channel' => $request->get('channel'),
                'text' => $request->get('message'),
                'as_user' =>true
            ]);
            $data['response'] = $this->getCannelList();

        } catch (SlackApiException $e) {
            $data = array(
                'error' => true,
                'message' => $e->getMessage(),
                'response' => []
            );
        }
        return view('slack/index', ['data' => $data]);
    }

    private function getCannelList(){
        $api = new SlackApi(env('SLACK_API_TOKEN'));

        $channel = $api->execute('channels.list');

        $data = [];
        if($channel['ok']){
            foreach ($channel['channels'] as $channel){
                $data[$channel['id']]['name'] = $channel['name'];

                foreach ($channel['members'] as $member){
                    $user = $api->execute('users.info',['user' => $member]);
                    $presence = $api->execute('users.getPresence',['user' => $member]);
                    $data[$channel['id']]['members'][] = array(
                        'name' => $user['user']['profile']['real_name'],
                        'avatar' => $user['user']['profile']['image_512'],
                        'status' => isset($presence['presence']) ? $presence['presence'] : 'away'
                    );

                }
            }
        }

        return $data;
    }
}
