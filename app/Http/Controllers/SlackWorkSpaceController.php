<?php

namespace App\Http\Controllers;

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

        $users      = User::where('slack_user_id', '')->orWhere('workspace_id', '')->get();
        $workspaces = SlackWorkspace::get();
        foreach ($workspaces as $workspace){
            $slackApi = new SlackApi($workspace->token);

            $responce = $slackApi->execute('users.list');
            foreach ($responce['members'] as $member) {
                foreach ($users as $user){
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('slack-workspace/create');
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
                SlackWorkspace::create([
                    'token' => $request['token'],
                    'workspace_id' => $responce['team']['id'],
                    'name' => $responce['team']['name'],
                    'domain' => $responce['team']['domain'],
                    'id_' => $request['id_']
                ]);
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
            return view('slack-workspace/create', ['message'=> $data['message']]);
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
        $workspace = SlackWorkspace::find($id);

        if ($workspace == null || $workspace->count() == 0) {
            return redirect()->intended('/workspaces');
        }

        return view('slack-workspace/edit', ['workspace' => $workspace]);
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

        $data = array(
            'error' => false,
            'message' => '',
        );

        try{
            $api = new SlackApi($request['token']);

            $responce = $api->execute('team.info');

            if($responce['ok']){
                SlackWorkspace::where('id', $id)->update([
                    'token' => $request['token'],
                    'workspace_id' => $responce['team']['id'],
                    'name' => $responce['team']['name'],
                    'domain' => $responce['team']['domain'],
                    'id_' => $request['id_']
                ]);
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
            $workspace = SlackWorkspace::find($id);
            return view('slack-workspace/edit', ['message'=> $data['message'], 'workspace' => $workspace]);
        }

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
        return redirect()->intended('/workspaces');
    }
}
