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
        $workspaces = SlackWorkspace::paginate(10);

        return view('slack-workspace/index', ['workspaces' => $workspaces]);
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
                    'domain' => $responce['team']['domain']
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
                    'domain' => $responce['team']['domain']
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

    public function connection($id)
    {
        $data = ['error' => false];

        $data['user'] = User::find($id);

        if($data['user']->workspace_id == '' && $data['user']->slack_user_id == ''){
            $data['workspaces'] = SlackWorkspace::get();
            $data['view'] = 'no_invited';
        }elseif($data['user']->workspace_id != '' && $data['user']->slack_user_id == ''){
            $data['workspace'] = SlackWorkspace::find($data['user']->workspace_id);

            $api = new SlackApi($data['workspace']->token);
            $responce = $api->execute('users.list');
            foreach ($responce['members'] as $member) {
                if (isset($member['profile']['email']) && $member['profile']['email'] == $data['user']->email) {
                    User::where('id', $id)->update([
                        'slack_user_id' => $member['id']
                    ]);
                    $data['view'] = 'invited_success';

                    $result = $api->execute('users.getPresence', ['user' => $member['id']]);

                    $data['user']->presence = $result['presence'];
                    $data['user']->display_name = $member['profile']['display_name'];
                    $data['user']->avatar = isset($member['profile']['image_original']) ? $member['profile']['image_original'] : '';

                    return view('slack-connection/index', ['data' => $data]);
                }
            }
            
            $data['view'] = 'invited_sent';
            
        }else{
            $data['workspace'] = SlackWorkspace::find($data['user']->workspace_id);
            $api = new SlackApi($data['workspace']->token);
            
            $responce = $api->execute('users.info', ['user' => $data['user']->slack_user_id]);


            $result = $api->execute('users.getPresence', ['user' => $responce['user']['id']]);

            $data['user']->presence = $result['presence'];
            $data['user']->display_name = $responce['user']['profile']['display_name'];
            $data['user']->avatar = isset($responce['user']['profile']['image_original']) ? $responce['user']['profile']['image_original'] : '';

            $data['view'] = 'invited_success';
        }

        return view('slack-connection/index', ['data'=> $data]);
    }

    public function invite(Request $request)
    {
        $data = array(
            'error' => false,
            'message' => ''
        );

        try{
            $data['user'] = User::find($request['user_id']);
            $data['workspace'] = SlackWorkspace::find($request['workspace_id']);

            $api = new SlackApi($data['workspace']->token);

            $responce = $api->execute('users.admin.invite', ['email' => $data['user']->email]);

            if($responce['ok']){
                User::where('id', $request['user_id'])->update([
                    'workspace_id' => $data['workspace']->id,
                ]);
            }
        }catch (SlackApiException $e){
            if($e->getMessage() == 'already_invited' || $e->getMessage() == 'already_in_team'){
                $responce = $api->execute('users.list');

                if($responce['ok']){
                    foreach ($responce['members'] as $member){

                        if(isset($member['profile']['email']) && $member['profile']['email'] == $data['user']->email){
                            User::where('id', $request['user_id'])->update([
                                'workspace_id' => $data['workspace']->id,
                                'slack_user_id' => $member['id'],
                            ]);
                            $data['view'] = 'invited_success';

                            $result = $api->execute('users.getPresence', ['user' => $member['id']]);

                            $data['user']->presence = $result['presence'];
                            $data['user']->display_name = $member['profile']['display_name'];
                            $data['user']->avatar = isset($member['profile']['image_original']) ? $member['profile']['image_original'] : '';

                            return view('slack-connection/index', ['data'=> $data]);
                        }
                    }
                }

                $data['view'] = 'invited_sent';
                User::where('id', $request['user_id'])->update([
                    'workspace_id' => $data['workspace']->id
                ]);
                return view('slack-connection/index', ['data'=> $data]);
            }

            $data['error'] = true;
            $data['message'] = $e->getMessage();
        }

        if($data['error']){
            $data['workspaces'][0] = $data['workspace'];
            unset($data['workspace']);
            $data['view'] = 'no_invited';
            return view('slack-connection/index', ['data'=> $data]);
        }

        $data['view'] = 'invited_sent';

        return view('slack-connection/index', ['data'=> $data]);
    }
}
