<?php

namespace App\Http\Controllers;

use App\SlackChatPair;
use Illuminate\Http\Request;

use App\User;
use App\SlackWorkspace;
use App\Project;

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
        $user = User::with('userinfo')->find($id);
        $workspaces = SlackWorkspace::get();
        $projects = Project::get();
        // Redirect to user list if updating user wasn't existed
        if ($user == null || $user->count() == 0) {
            return redirect()->intended('/applicants');
        }

        return view('slack-chat-pair/edit', ['user' => $user, 'workspaces' => $workspaces, 'projects' => $projects]);
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
        $constraints = [
            'username' => 'required|max:20',
            'firstname'=> 'required|max:60',
            'lastname' => 'required|max:60'
        ];
        if($request->file('image')){
            $image = $request->file('image');
            $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/image');

            $image->move($destinationPath, $input['imagename']);
        }

        $slack_user_id = '';
        if($request['workspace'] != ''){
            try {
                $token = SlackToken::where('workspace_id', $request['workspace'])->get()->first();
                if($token) {
                    $api = new SlackApi($token->token);
                    $user = User::find($id);
                    $response = $api->execute('users.list');
                    foreach ($response['members'] as $member) {
                        if (isset($member['profile']['email']) && $member['profile']['email'] == $user->email) {
                            $slack_user_id = $member['id'];
                            break;
                        }
                    }
                }
            } catch (SlackApiException $e) {
                $slack_user_id = '';
            }
        }

        $input = [
            'username' => $request['username'],
            'firstname' => $request['firstname'],
            'lastname' => $request['lastname'],
            'type' => $request['type'],
            'level' => $request['level'],
            'image' => '',
            'workspace_id' => $request['workspace'] === null ? '' : $request['workspace'],
            'slack_user_id' => $slack_user_id
        ];
        $input_info = [
            'stack' => $request['stack'] ,
            'skypeid'=>$request['skypeid'] ,
            'room' => $request['room'] ,
            'country'=>$request['country'] ,
            'age' => $request['age'] ,
            'notes' => $request['notes'] ,
            'called'=> isset($request['called']) ? 1 : 0 ,
            'approved' => isset($request['approved']) ? 1 : 0 ,
            'time_doctor_email' => $request['time_doctor_email'] ,
            'time_doctor_password' => $request['time_doctor_password'],
            'channel_id' => $request['channel_id'],
            'project_id'=> $request['project'] === null ? '' : $request['project']
        ];
        if ($request['password'] != null && strlen($request['password']) > 0) {
            $constraints['password'] = 'required|min:6|confirmed';
            $input['password'] =  bcrypt($request['password']);
        }
        //$this->validate($request, $constraints);
        User::where('id', $id)
            ->update($input);
        UserInfo::where('user_id', $id)
            ->update($input_info);


        return redirect()->intended('/applicants');
    }
}
