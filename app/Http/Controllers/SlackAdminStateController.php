<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SlackWorkspace;
use App\SlackToken;
use App\User;

use \Lisennk\Laravel\SlackWebApi\SlackApi;
use \Lisennk\Laravel\SlackWebApi\Exceptions\SlackApiException;

class SlackAdminStateController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource
     */

     public function index(Request $request)
    {
        $id = $request->id;
        $users = User::where('type', '=', 0)->get();
        
        if (count($users) && !isset($id)) 
        {
            $id = $users[0]->id;
        }
        
        $workspaces = SlackWorkspace::leftJoin('slack_tokens', 'slack_workspaces.id', '=', 'slack_tokens.workspace_id')
        ->join('users', 'users.id', '=', 'slack_tokens.user_id')
        ->where('users.id', '=', $id)
        ->select('slack_workspaces.*', 'slack_tokens.token', 'slack_tokens.id as slack_tokens_id')
        ->get();

        foreach ( $workspaces as &$workspace) {
            try {
                $api = new SlackApi(env('SLACK_API_TOKEN'));
                $api->setToken( $workspace->token);
                $response = $api->execute('users.getPresence');
                if($response['ok']){
                    $workspace->presence = $response['presence'];
                } else {
                    $workspace->presence = 'away';
                }    
            } catch (SlackApiException $e) {
                $workspace->presence = 'away';
            }
        }
        return view('slack-admin-state/index', ['workspaces' => $workspaces, 'users' => $users, 'id'=>$id]);
    }

    public function activeState(Request $request)
    {
        $id = $request['id'];
        $active = 'away';
        if ( $request['active'] == 'Active' || 
            $request['active'] == 'All active') 
        {
            $active = 'auto';
        }
        $workspace_id = $request['workspace_id'];

        $workspaces = SlackWorkspace::leftJoin('slack_tokens', 'slack_workspaces.id', '=', 'slack_tokens.workspace_id')
        ->join('users', 'users.id', '=', 'slack_tokens.user_id')
        ->where('users.id', '=', $id);

        if ($workspace_id != 'all') 
        {
            $workspaces->where('slack_workspaces.id', '=', $workspace_id);
        }
        $workspaces = $workspaces->get();
        foreach ( $workspaces as &$workspace) {
            try {
                $api = new SlackApi(env('SLACK_API_TOKEN'));
                $api->setToken( $workspace->token);
                $response = $api->execute('users.setPresence', [
                    'presence' => $active,
                ]);
                if($response['ok']){
                } else {
                }    
            } catch (SlackApiException $e) {
            }
        }
        
        return redirect()->intended('/slack-admin-state?id='.$id);        
    }
}