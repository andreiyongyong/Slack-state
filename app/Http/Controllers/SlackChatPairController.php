<?php

namespace App\Http\Controllers;

use App\ForbiddenKeywords;
use App\SlackChatPair;
use FontLib\EOT\File;
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
            'user_id_1' => $request['userid_1'] ,
            'admin_id_1'=>$request['admin_id_1'] ,
            'workspace_id_2' => $request['workspace_id_2'] ,
            'user_id_2' => $request['userid_2'] ,
            'admin_id_2'=>$request['admin_id_2'] ,
        ]);
        return redirect()->intended('/slack-chat-pair');
    }

    public function slackChat($id){
        $keywords = ForbiddenKeywords::get();
        $projects = Project::get();
        $pair = SlackChatPair::where('id', $id)->with(['project'])->with(['workspace_1'])->with(['user_1'])->with(['admin_1'])->with(['workspace_2'])->with(['user_2'])->with(['admin_2'])->get()->first();
        return view('slack-chat/pair-chat', ['projects' => $projects, 'pair' => $pair, 'keywords' => $keywords]);
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

        $users = [];

        $data = [
            'user_1' => [],
            'user_2' => []
        ];

        try {
            $token = SlackToken::where('workspace_id', $user_1['workspace_id'])->where('user_id', $user_1['admin_id'])->get()->first();
            if($token) {
                $api = new SlackApi($token->token);
                
                $message_sections = $api->execute('im.list');
                $message_id = '';
                foreach ($message_sections['ims'] as $section){
                    if($user_1['slack_id'] == $section['user']){
                        $message_id = $section['id'];
                    }
                }

                $response = $api->execute('im.history', ['channel' => $message_id, 'inclusive' => true, 'count' => 12]);

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

                        $message['tsi'] = (float)$message['ts'];
                        $message['ts'] = date('Y/m/d H:i:s', (int)$message['ts']);
                        $message['type'] = 'text';

                        $message['text'] = $this->cutString($message['text'], '<@', '>');
                        $file_link = '';
                        $file_name = '';
                        if(isset($message['subtype']) && $message['subtype'] = 'file_share' && isset($message['file'])){
                            $message['user'] = $users[$message['file']['user']];
                            $file_link = $message['file']['url_private_download'];
                            $file_name = $message['file']['name'];
                            $message['type'] = 'file';
                        }

                        $message['text'] = $this->filter_urls($message['text'], $file_link, $file_name);

                        $data['user_1'][] = $message;
                    }
                    $data['user_1'] = array_reverse($data['user_1']);
                }
            }
        } catch (SlackApiException $e) {
            $data['user_1'] = [];
        }
        try {

                $token = SlackToken::where('workspace_id', $user_2['workspace_id'])->where('user_id', $user_2['admin_id'])->get()->first();
            $users = [];
                if($token) {
                    $api = new SlackApi($token->token);
                    $message_sections = $api->execute('im.list');
                    $message_id = '';
                    foreach ($message_sections['ims'] as $section){
                        if($user_2['slack_id'] == $section['user']){
                            $message_id = $section['id'];
                        }
                    }

                    $response = $api->execute('im.history', ['channel' => $message_id, 'inclusive' => true, 'count' => 12]);

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
                            $message['tsi'] = (float)$message['ts'];
                            $message['ts'] = date('Y/m/d H:i:s', (int)$message['ts']);
                            $message['type'] = 'text';

                            $message['text'] = $this->cutString($message['text'], '<@', '>');
                            $file_link = '';
                            $file_name = '';
                            if(isset($message['subtype']) && $message['subtype'] = 'file_share' && isset($message['file'])){
                                $message['user'] = $users[$message['file']['user']];
                                $file_link = $message['file']['url_private_download'];
                                $file_name = $message['file']['name'];
                                $message['type'] = 'file';
                            }

                            $message['text'] = $this->filter_urls($message['text'], $file_link, $file_name);
                            $data['user_2'][] = $message;
                        }
                        $data['user_2'] = array_reverse($data['user_2']);
                    }
                }
        } catch (SlackApiException $e) {
            $data['user_2'] = [];
        }
        return response()->json(['data' => $data]);
    }

    private function uploadFile($id, $link, $token){
        $ch = curl_init();
        $authorization = 'Authorization: Bearer '.$token;
        curl_setopt($ch, CURLOPT_URL, $link);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array( $authorization ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        $link_arr = explode('.', $link);
        file_put_contents(public_path('image/slack/'.$id.'.'.end($link_arr)), $result);
    }
    private function filter_urls($string, $file_link = '' , $file_name = ''){
        preg_match_all("~\<(.*?)\>~",$string,$matches);
        $urls = [];
        if(isset($matches[1])) {
            $urls = $matches[1];
        }

        foreach ($urls as $key => $url){
            if($file_link != '' && $key == 0){
                $string = str_replace('<'.$url.'>','<a href="'.$file_link.'">'.$file_name.'</a>', $string);
                continue;
            }

            $string = str_replace('<'.$url.'>','<a href="'.$url.'" target="_blank">'.$url.'</a>', $string);
        }

        return $string;

    }

    private function cutString($string, $firstChar, $secondChar, $replace = '', $recurse = true){
        $result = $string;

        $firstPos = strpos($string, $firstChar);
        
        if($firstPos !== false){
            $result = substr($string, 0, $firstPos);
            $string = substr($string, $firstPos);

            $secondPos = strpos($string, $secondChar);
            if($secondPos !== false){
                $result .= $replace.substr($string, $secondPos + 1);
            } else {
                return $result.$string;
            }
        }
        if(strpos($result, $firstChar) !== false && $recurse){
            return $this->cutString($result, $firstChar, $secondChar );
        }
        return $result;
    }

    public function sendSlackMessage_ajax(Request $request){

        $developer = $request['developer'];
        $message = $request['message'];

        try {
            $token = SlackToken::where('workspace_id', $developer['workspace_id'])->where('user_id', $developer['admin_id'])->get()->first();

            if($token) {
                $api = new SlackApi($token->token);

                $response = $api->execute('chat.postMessage', [
                    'channel' => $developer['slack_id'],
                    'text' => $message,
                    'as_user' => true
                ]);

                if($response['ok']){
                    $message = $response['message'];

                    $result = $api->execute('users.info', ['user' => $message['user']]);
                    if ($result['ok']) {
                        $message['user'] = $result['user'];
                    }

                    $message['tsi'] = (float)$message['ts'];
                    $message['ts'] = date('Y/m/d H:i:s', (int)$message['ts']);

                    $message['text'] = $this->cutString($message['text'], '<@', '>');
                    $message['text'] = $this->filter_urls($message['text']);
                }
            }

        } catch (SlackApiException $e) {
            $message = $e->getMessage();
        }

        return response()->json(['data' => $message]);
    }
    
    public function uploadFile_ajax(Request $request){
        
        $action = $request['action'];
        $developer = json_decode($request['user'], true);
        $message = 'error';

        try {
            $token = SlackToken::where('workspace_id', $developer['workspace_id'])->where('user_id', $developer['admin_id'])->get()->first();
            $api = new SlackApi($token->token);
            if($token) {
                if ($action == 'auto') {
                    $file = json_decode($request['attach'], true);

                    $this->uploadFile($file['id'], $file['url_private_download'], $token->token);

                    $name_arr = explode('.', $file['name']);

                    $comment = isset($file['initial_comment']) ? ' -F initial_comment='.$file['initial_comment']['comment']: '';

                    if(strpos($comment, '<') !== false){
                        $comment = str_replace('<','',$comment);
                        $comment = str_replace('>','',$comment);
                    }

                    $response = exec('curl -F file=@' . public_path('image/slack/' . $file['id'] . '.' . end($name_arr)) .$comment. ' -F channels=' . $developer['slack_id'] . ' -F filename=' .  (($file['name']=escapeshellarg($file['name']))? $file['name'] : "''"). ' -F token=' . $token->token . ' https://slack.com/api/files.upload');
                } else {
                    $file = $request->file('attach');
                    $response = exec('curl -F file=@' . $file->getRealPath() . ' -F channels=' . $developer['slack_id'] . ' -F filename=' . $file->getClientOriginalName() . ' -F token=' . $token->token . ' https://slack.com/api/files.upload');
                }

                $response = json_decode($response, true);
                if (isset($response['ok']) && $response['ok']) {
                    $result = $api->execute('im.history', ['channel' => $response['file']['ims'][0], 'inclusive' => true, 'count' => 1]);

                    if (isset($result['ok']) && $result['ok']) {

                        $message = $result['messages'][0];

                        $result = $api->execute('users.info', ['user' => $message['user']]);

                        $message['tsi'] = (float)$message['ts'];
                        $message['ts'] = date('Y/m/d H:i:s', (int)$message['ts']);

                        $message['text'] = $this->cutString($message['text'], '<@', '>');

                        $message['user'] = $result['user'];
                        $file_link = $message['file']['url_private_download'];
                        $file_name = $message['file']['name'];
                        $message['type'] = 'file';

                        $message['text'] = $this->filter_urls($message['text'], $file_link, $file_name);
                    }

                }
            }

        }catch (SlackApiException $e) {
            $message = 'error';
        }

        return response()->json([$message]);
    }

    public function destroy($id){
        SlackChatPair::find($id)->delete();
        return redirect()->intended('/slack-chat-pair');
    }

}
