<?php

namespace App\Http\Controllers;

use DB;
use App\SlackToken;
use App\SlackWorkspace;
use App\Task;
use Illuminate\Http\Request;
use \Lisennk\Laravel\SlackWebApi\SlackApi;
use \Lisennk\Laravel\SlackWebApi\Exceptions\SlackApiException;
use App\User;
use App\Project;
use App\Allocation;

class SlackController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
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
        
        try {

            $users = User::with(['userinfo' => function($query) {
                $query->where('channel_id','<>', '');            

            }, 'allocation' => function($query) {
                $query->where('is_delete', '=', '0');

            }, 'task_allocation' => function($query) {
                $query->where('is_delete', '=', '0');

            }])->where('slack_user_id','<>' ,'')
               ->where('workspace_id', '<>','')
               ->where('level', '=',11)
               ->orderBy('workspace_id', 'asc')
               ->get();

            $workspaces = DB::select('SELECT A.token , A.workspace_id FROM slack_tokens A '.
                                        'LEFT JOIN ('.
                                        'SELECT workspace_id FROM users WHERE workspace_id <> "" GROUP BY workspace_id'.
                                        ') B ON A.workspace_id = B.workspace_id '.
                                        'WHERE A.token <> ""');
                               
            $user_list = array();
            $slackUsers = array();
            foreach ($workspaces as $workspace) {
                $api = new SlackApi($workspace->token);
                $response = $api->execute('users.list');

                if (!$response['ok']) continue;
                $members = $response['members'];
                for ($i = 0; $i < count($members); $i++) {
                    array_push($slackUsers, $members[$i]);
                }
            }

            foreach ($users as $user) {
                foreach($slackUsers as $slack_member) {

                    if ($slack_member['id'] != $user->slack_user_id) continue;

                    $user_list[] = array_merge($slack_member, array(
                        'avatar' => $slack_member['profile']['image_512'],
                        'type' => '2',
                        'status' => "away",
                        'display_name' => (isset($slack_member['profile']['display_name']) && !empty($slack_member['profile']['display_name']))
                            ? $slack_member['profile']['display_name'] : ( isset( $slack_member['real_name'] ) ? $slack_member['real_name'] : '' ) ,
                        'workspace_id' => $user->workspace_id,
                        'projects' => $user->allocation,
                        'tasks' => $user->task_allocation
                        
                    ));

                    break;
                }
            }

        } catch (SlackApiException $e) {

        }
        $projects = Project::all();
        $tasks = Task::all();
        return view('slack/index', ['data' => $user_list, 'projects' => $projects, 'tasks' => $tasks]);
    }
/*
    public function index()
    {
        
        $data = [];
        
        try {

            $users = User::with(['userinfo' => function($query) {
                $query->where('channel_id','<>', '');            

            }])->where('slack_user_id','<>' ,'')
                ->where('workspace_id', '<>','')
                ->where('level', '=',11)
                ->paginate(100);
            
            $user_list = array();
            foreach ($users as $user){
            
                $token = SlackToken::where('workspace_id', $user->workspace_id)->get()->first();

                if($token) {
                    $api = new SlackApi($token->token);
                    $project = Project::find($user->userinfo['project_id']);
                    $projects = Allocation::where('user_id', '=', $user->id)
                        ->where('is_delete', '=', '0')->pluck('project_id');
                    $project_names = Project::whereIn('id', $projects)->get()->pluck('p_name');
                    $responce = $api->execute('users.info', ['user' => $user->slack_user_id]);
                    
                    $user_list[] = array_merge($responce['user'], array(
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
*/
    public function updateUserStatuses_ajax(Request $request){

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
                                $res_user_info = $api->execute('users.info', ['user' => $developer->slack_user_id]);
                                $project_names = Project::whereIn('id', $projects)->get()->pluck('p_name');
                                $user_list/* [$index] */[] = array_merge($res_user_info['user'], array(
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
