<?php

namespace App\Http\Controllers;

use App\SlackWorkspace;
use Illuminate\Http\Request;
use \Lisennk\Laravel\SlackWebApi\SlackApi;
use \Lisennk\Laravel\SlackWebApi\Exceptions\SlackApiException;
use App\Project;
use App\Task;
use App\User;
use App\SlackToken;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SlackChatController extends Controller
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
        $data['developers'] = DB::table('users')
            ->join('slack_tokens', 'slack_tokens.workspace_id','=','users.workspace_id')
            ->select('users.id', 'users.username', 'users.slack_user_id', 'users.channel_id', 'slack_tokens.token')
            ->where([
                ['slack_tokens.user_id','=', Auth::user()->id]
            ])->get();

        foreach ($data['developers'] as $key => $developer){
            try {
                $api = new SlackApi($developer->token);
                $response = $api->execute('users.getPresence', ['user' => $developer->slack_user_id]);
                if ($response['ok']) {
                    $data['developers'][$key]->status = $response['presence'];
                }
            } catch (SlackApiException $e) {
                $data['developers'][$key]->status = 'away';
            }
        }

        return view('slack-chat.index', ['data' => $data]);
    }

    public function groupMessage(){
        $developers =  DB::table('users')
            ->join('slack_tokens', 'slack_tokens.workspace_id','=','users.workspace_id')
            ->select('users.id', 'users.username', 'users.slack_user_id', 'slack_tokens.token')
            ->where([
                ['slack_tokens.user_id','=', Auth::user()->id]
            ])->get();
        return view('slack-chat.group', ['developers' => $developers]);
    }
    
    public function sendGroupMessage_ajax(Request $request){
        $developers = json_decode($request['developers'], true);
        $message    = $request['message'];
        $file       = $request->file('attach');
        $data = [
            'error' => false,
            'msg'   => 'Successfully Sent'
        ];
        if(!empty($developers)) {
            try {
                foreach ($developers as $developer) {
                    $api = new SlackApi($developer['token']);

                    if($message != ''){
                        $response = $api->execute('chat.postMessage', [
                            'channel' => $developer['slack_user_id'],
                            'text' => $message,
                            'as_user' => true
                        ]);
                    }
                    if ($file !== null) {
                        $response = exec('curl -F file=@' . $file->getRealPath() . ' -F channels=' . $developer['slack_user_id'] . ' -F filename=' . $file->getClientOriginalName() . ' -F token=' . $developer['token'] . ' https://slack.com/api/files.upload');
                    }
                }
            } catch (SlackApiException $e) {
                $data = [
                    'error' => true,
                    'msg' => $e->getMessage()
                ];
            }
        }else{
            $data = [
                'error' => true,
                'msg' => 'Select user to send'
            ];
        }

        return response()->json($data);
    }

    public function updateUserStatuses_ajax(Request $request){
        $developers = $request['developers'];
        $data = [];
        foreach ($developers as $developer){
            try {
                $api = new SlackApi($developer['token']);

                $response = $api->execute('users.getPresence', ['user' => $developer['slack_id']]);

                if ($response['ok']) {
                    $data[$developer['slack_id']] = $response['presence'];
                }
            } catch (SlackApiException $e) {
                return response()->json(['data' => $data]);
            }
        }
        return response()->json(['data' => $data]);
    }



    public function getChannelChat_ajax(Request $request){

        $developer = $request['developer'];
        $channelId = $developer['channel_id'];
        $users = [];
        $data = [];

            try {
                $api = new SlackApi($developer['token']);
                $response = $api->execute('channels.history', ['channel' => $channelId, 'inclusive' => true]);

                if ($response['ok']) {
                    $userIds = array_filter(array_unique(array_pluck($response['messages'], 'user')), function ($val) {
                        return $val !== null;
                    });

                    foreach ($userIds as $userId) {
                        $result = $api->execute('users.info', ['user' => $userId]);
                        if ($result['ok']) {
                            $users[$result['user']['id']] = $result['user'];
                        }
                    }

                    foreach ($response['messages'] as $message) {
                        if (isset($message['user'])) {
                            $message['user'] = $users[$message['user']];
                        }
                        $message['ts'] = date('Y/m/d H:i:s', (int)$message['ts']);
                        $data[] = $message;
                    }
                    $data = array_reverse($data);
                }

            } catch (SlackApiException $e) {
                return response()->json(['data' => $data]);
            }
        return response()->json(['data' => $data]);
    }

    public function sendSlackMessage_ajax(Request $request){

        $developer = $request['developer'];
        $channelId = $developer['channel_id'];
        $message = $request['message'];
        $error = false;

        try {
            $api = new SlackApi($developer['token']);

            $response = $api->execute('chat.postMessage', [
                'channel' => $channelId,
                'text' => $message,
                'as_user' => true
            ]);
        } catch (SlackApiException $e) {
                $error = true;
        }

        return response()->json(['error' => $error]);
    }
}
