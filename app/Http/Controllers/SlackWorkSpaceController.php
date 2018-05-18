<?php

namespace App\Http\Controllers;

use App\SlackToken;
use Illuminate\Http\Request;
use App\SlackWorkspace;
use \Lisennk\Laravel\SlackWebApi\SlackApi;
use \Lisennk\Laravel\SlackWebApi\Exceptions\SlackApiException;
use App\User;

class SlackWorkSpaceController extends Controller
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
        $workspaces = SlackWorkspace::get();

        return view('slack-workspace/index', ['workspaces' => $workspaces]);
    }

    public function updateUsers_cron(){
        try {
            $users = User::where('slack_user_id', '')->orWhere('workspace_id', '')->get();
            $workspaces = SlackWorkspace::get();
            foreach ($workspaces as $workspace) {

                $token = SlackToken::where('workspace_id', $workspace->id)->get()->first();

                if($token) {
                    $slackApi = new SlackApi($token->token);
                    $responce = $slackApi->execute('users.list');
                    foreach ($responce['members'] as $member) {
                        foreach ($users as $user) {
                            if (isset($member['profile']['email']) && $member['profile']['email'] == $user->email) {
                                User::where('id', $user->id)->update([
                                    'slack_user_id' => $member['id'],
                                    'workspace_id' => $workspace->id
                                ]);
                                break;
                            }
                        }
                    }
                }
            }
        }catch (SlackApiException $e){

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('type', '=', 0)->get();
        return view('slack-workspace/create',['users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = array(
            'error' => false,
            'message' => '',
        );

        try{
            $api = new SlackApi($request['token']);

            $responce = $api->execute('team.info');

            if($responce['ok']){
                if(SlackWorkspace::where('workspace_id',$responce['team']['id'] )->get()->first() === null){
                    $workspace = SlackWorkspace::create([
                        'workspace_id' => $responce['team']['id'],
                        'id_' => $request['id_'],
                        'workspace_number' => $request['workspace_number'],
                        'domain' => $responce['team']['domain'],
                    ]);

                    SlackToken::create([
                        'user_id' => $request['user'],
                        'workspace_id' => $workspace->id,
                        'token' => $request['token']
                    ]);

                }else{
                    $data = array(
                        'error' => true,
                        'message' => 'Workspace with this token already exist',
                    );
                }
            }else{
                $data = array(
                    'error' => true,
                    'message' => $request['error'],
                );
            }
        }catch (SlackApiException $e){
            $data = array(
                'error' => true,
                'message' => $e->getMessage(),
            );
        }

        if($data['error']){
            $users = User::where('type', '=', 0)->get();
            return view('slack-workspace/create', ['message'=> $data['message'], 'users' => $users]);
        }

        return redirect()->intended('/workspaces');
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
        $workspace = SlackWorkspace::with(['tokens'])->find($id);
        $userIds = [];

        if($workspace->tokens){
            foreach ($workspace->tokens as $token){
                $userIds[] = $token['user_id'];
            }
        }

        $users = User::where('type', '=', 0)->whereNotIn('id', $userIds)->get();

        if ($workspace == null || $workspace->count() == 0) {
            return redirect()->intended('/workspaces');
        }

        return view('slack-workspace/edit', ['users' => $users, 'workspace' => $workspace]);
    }

    public function addToken(Request $request){

        $workspace_id = $request['_id'];

        SlackToken::create([
            'user_id' => $request['user_id'],
            'workspace_id' => $workspace_id,
            'token' => $request['token']
        ]);

        return redirect()->intended('/workspaces/'.$workspace_id.'/edit');
    }

    public function deleteToken($id){

        $token = SlackToken::find($id);
        SlackToken::where('id', $id)->delete();

        return redirect()->intended('/workspaces/'.$token->workspace_id.'/edit');
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
        SlackWorkspace::where('id',$id)->update([
            'id_' => $request['id_'],
            'workspace_number' => $request['workspace_number'],
        ]);
        return redirect()->intended('/workspaces');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        SlackWorkspace::where('id', $id)->delete();
        SlackToken::where('workspace_id', $id)->delete();

        return redirect()->intended('/workspaces');
    }
}
