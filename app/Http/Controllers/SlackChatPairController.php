<?php

namespace App\Http\Controllers;

use App\SlackChatPair;
use Illuminate\Http\Request;

use App\User;
use App\SlackWorkspace;
use App\Project;
use App\SlackToken;
use \Lisennk\Laravel\SlackWebApi\SlackApi;
use \Lisennk\Laravel\SlackWebApi\Exceptions\SlackApiException;

class SlackChatPairController extends Controller
{
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/slack-chat-pair';

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
        $pairs = SlackChatPair::with(['project'])->with(['workspace_1'])->with(['user_1'])->with(['admin_1'])->with(['workspace_2'])->with(['user_2'])->with(['admin_2'])->get();

        return view('slack-chat-pair/index', ['pairs' => $pairs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects = Project::get();
        $workspaces = SlackWorkspace::get();
        $users = User::where('type', '=',2)
            ->where('level', '=',11)
            ->get();

        $admins = User::where('type', '=',0)->get();

        return view('slack-chat-pair/create', ['workspaces' => $workspaces, 'projects' => $projects, 'users' => $users, 'admins' => $admins]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        SlackChatPair::create([
            'name' => $request['name'],
            'project_id' => $request['project_id'] ,
            'workspace_id_1'=>$request['workspace_id_1'] ,
            'user_id_1' => $request['user_id_1'] ,
            'admin_id_1'=>$request['admin_id_1'] ,
            'workspace_id_2' => $request['workspace_id_2'] ,
            'user_id_2' => $request['user_id_2'] ,
            'admin_id_2'=>$request['admin_id_2'] ,
        ]);
        return redirect()->intended('/slack-chat-pair');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $projects = Project::get();
        $workspaces = SlackWorkspace::get();
        $users = User::where('type', '=',2)
            ->where('level', '=',11)
            ->get();

        $admins = User::where('type', '=',0)->get();
        $pair = SlackChatPair::where('id', $id)->with(['project'])->with(['workspace_1'])->with(['user_1'])->with(['admin_1'])->with(['workspace_2'])->with(['user_2'])->with(['admin_2'])->get()->first();

        if ($pair == null || $pair->count() == 0) {
            return redirect()->intended('/slack-chat-pair');
        }

        return view('slack-chat-pair/edit', ['workspaces' => $workspaces, 'projects' => $projects, 'users' => $users, 'admins' => $admins, 'pair' => $pair]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        SlackChatPair::find($id)->update([
            'name' => $request['name'],
            'project_id' => $request['project_id'] ,
            'workspace_id_1'=>$request['workspace_id_1'] ,
            'user_id_1' => $request['user_id_1'] ,
            'admin_id_1'=>$request['admin_id_1'] ,
            'workspace_id_2' => $request['workspace_id_2'] ,
            'user_id_2' => $request['user_id_2'] ,
            'admin_id_2'=>$request['admin_id_2'] ,
        ]);
        return redirect()->intended('/slack-chat-pair');
    }

    public function slackChat(){
        $projects = Project::get();
        $pairs = SlackChatPair::get();
        $pair = SlackChatPair::with(['project'])->with(['workspace_1'])->with(['user_1'])->with(['admin_1'])->with(['workspace_2'])->with(['user_2'])->with(['admin_2'])->get()->first();
        return view('slack-chat/pair-chat', ['projects' => $projects, 'pair' => $pair, 'pairs' => $pairs]);
    }

    public function selectPair_ajax(Request $request){
        $pair = SlackChatPair::where('id', $request['id_'])->with(['project'])->with(['workspace_1'])->with(['user_1'])->with(['admin_1'])->with(['workspace_2'])->with(['user_2'])->with(['admin_2'])->get()->first();
        return response()->json($pair);
    }

    public function updateUserStatuses_ajax(Request $request){
        $user_1 = $request['user_1'];
        $user_2 = $request['user_2'];
        $data = [];

            try {

                $token = SlackToken::where('workspace_id', $user_1['workspace_id'])->get()->first();
                if($token) {
                    $api = new SlackApi($token->token);

                    $response = $api->execute('users.getPresence', ['user' => $user_1['slack_id']]);

                    if ($response['ok']) {
                        $data['user_1'] = $response['presence'];
                    }
                }

                $token = SlackToken::where('workspace_id', $user_2['workspace_id'])->get()->first();
                if($token) {
                    $api = new SlackApi($token->token);

                    $response = $api->execute('users.getPresence', ['user' => $user_2['slack_id']]);

                    if ($response['ok']) {
                        $data['user_2'] = $response['presence'];
                    }
                }
            } catch (SlackApiException $e) {
                return response()->json(['data' => $data]);
            }

        return response()->json(['data' => $data]);
    }



    public function getChannelChat_ajax(Request $request){

        $user_1 = $request['user_1'];
        $user_2 = $request['user_2'];

        $channelId_1 = $user_1['channel_id'];
        $channelId_2 = $user_2['channel_id'];
        $users = [];

        $data = [
            'user_1' => [],
            'user_2' => []
        ];

        try {
            $token = SlackToken::where('workspace_id', $user_1['workspace_id'])->get()->first();

            if($token) {
                $api = new SlackApi($token->token);
                $response = $api->execute('channels.history', ['channel' => $channelId_1, 'inclusive' => true]);

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
                        $data['user_1'][] = $message;
                    }
                    $data['user_1'] = array_reverse($data['user_1']);
                }
            }
                $token = SlackToken::where('workspace_id', $user_2['workspace_id'])->get()->first();
            $users = [];

                if($token) {
                    $api = new SlackApi($token->token);
                    $response = $api->execute('channels.history', ['channel' => $channelId_2, 'inclusive' => true]);

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
                            $data['user_2'][] = $message;
                        }
                        $data['user_2'] = array_reverse($data['user_2']);
                    }
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
            $token = SlackToken::where('workspace_id', $developer['workspace_id'])->where('user_id', $developer['admin_id'])->get()->first();

            if($token) {
                $api = new SlackApi($token->token);

                $response = $api->execute('chat.postMessage', [
                    'channel' => $channelId,
                    'text' => $message,
                    'as_user' => true
                ]);

            }

        } catch (SlackApiException $e) {
            $error = true;
        }

        return response()->json(['error' => $error]);
    }

    public function destroy($id){
        SlackChatPair::find($id)->delete();
        return redirect()->intended('/slack-chat-pair');
    }

}
