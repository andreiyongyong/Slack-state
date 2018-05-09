<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Lisennk\Laravel\SlackWebApi\SlackApi;
use \Lisennk\Laravel\SlackWebApi\Exceptions\SlackApiException;

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
        $data = array(
            'error' => false,
            'message' => '',
            'response' => []
        );
        try {

            $data['response'] = $this->getCannelList();
//echo "<pre>";
//print_r($data);
//die;
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

}
