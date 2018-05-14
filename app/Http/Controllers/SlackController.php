<?php

namespace App\Http\Controllers;

use App\SlackWorkspace;
use Illuminate\Http\Request;
use \Lisennk\Laravel\SlackWebApi\SlackApi;
use \Lisennk\Laravel\SlackWebApi\Exceptions\SlackApiException;
use App\User;

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

            $users = User::with(['userinfo' => function($query){
                $query->where('channel_id','<>', '');
            }])->where('slack_user_id','<>' ,'')
                ->where('workspace_id', '<>','')
                ->where('type', '=',2)
                ->where('level', '=',11)
                ->paginate(100);
            
            foreach ($users as $user){
                $token = SlackWorkspace::find($user->workspace_id)->token;

                $api = new SlackApi($token);

                $responce = $api->execute('users.info', ['user' => $user->slack_user_id]);
                $data[] = array_merge($responce['user'], array(
                        'avatar'=>$responce['user']['profile']['image_512'],
                        'display_name' => (isset($responce['user']['profile']['display_name']) && !empty($responce['user']['profile']['display_name']))
                            ? $responce['user']['profile']['display_name'] : $responce['user']['real_name']
                    )
                );
            }

        } catch (SlackApiException $e) {

        }
        return view('slack/index', ['data' => $data]);
    }

    public function updateUserStatuses_ajax(){

        $developers = User::with(['userinfo' => function($query){
            $query->where('channel_id','<>', '');
        }])->where('slack_user_id','<>' ,'')
            ->where('workspace_id', '<>','')
            ->where('type', '=',2)
            ->where('level', '=',11)
            ->get();

        $data = [];
        foreach ($developers as $developer){
            try {
                $api = new SlackApi(SlackWorkspace::find($developer->workspace_id)->token);

                $response = $api->execute('users.getPresence', ['user' => $developer->slack_user_id]);

                if ($response['ok']) {
                    $data[$developer->slack_user_id] = $response['presence'];
                }
            } catch (SlackApiException $e) {
                return response()->json(['data' => $data]);
            }
        }
        return response()->json(['data' => $data]);
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

    private function getUsers(){
        $api = new SlackApi(env('SLACK_API_TOKEN'));

        $members = $api->execute('users.list');
        $data = [];
        if($members['ok']){
            foreach ($members['members'] as $member){
                $result = $api->execute('users.getPresence');
                $data[] = array_merge($member, array('presence' => $result['presence']));
            }
        }

        return $data;
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
