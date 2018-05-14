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

    private $slackApi;

    public function __construct()
    {
        $this->slackApi = new SlackApi(env('SLACK_API_TOKEN'));

        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array(
            'error' => false,
            'message' => '',
            'response' => []
        );
        try {

            $users = User::get();
            
            foreach ($users as $user){
                if($user->workspace_id != '' && $user->slack_user_id != ''){
                    $token = SlackWorkspace::find($user->workspace_id)->token;
                   
                    $api = new SlackApi($token);

                    $responce = $api->execute('users.info', ['user' => $user->slack_user_id]);
                    $result = $api->execute('users.getPresence', ['user' => $responce['user']['id']]);
                    $data['response'][] = array_merge($responce['user'], array(
                        'presence' => $result['presence'], 
                        'avatar'=>isset($responce['user']['profile']['image_original']) ? $responce['user']['profile']['image_original'] : '',
                        'display_name' => (isset($responce['user']['profile']['display_name']) && !empty($responce['user']['profile']['display_name']))
                            ? $responce['user']['profile']['display_name'] : $responce['user']['real_name']
                        )
                    );
                }
            }

        } catch (SlackApiException $e) {
            $data = array(
                'error' => true,
                'message' => $e->getMessage(),
                'response' => []
            );
        }
        return view('slack/index', ['data' => $data]);
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
                        'avatar' => isset($user['user']['profile']['image_original']) ? $user['user']['profile']['image_original'] : '',
                        'status' => isset($presence['presence']) ? $presence['presence'] : 'away'
                    );

                }
            }
        }

        return $data;
    }

    private function slackRequest($method, $params = [], $successMsg = ''){
        $data = array(
            'status'   => true,
            'message'  => $successMsg,
            'response' => []
        );

        try {
            $response       = $this->slackApi->execute($method, $params);
            $data['status'] = $response['ok'];

            if ($response['ok']) {
                unset($response['ok']);
                $data['response'] = $response;
            } else {
                $data['message'] = $response['error'];
            }

        } catch (SlackApiException $e) {
            $data['status'] = false;
            $data['message'] = $e->getMessage();
        }

        return $data;
    }

}
