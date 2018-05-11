<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\UserInfo;
use App\SlackWorkspace;

class ApplicantsController extends Controller
{
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/applicants';

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
        $users = User::with(['userinfo' => function($query){
            $query->where('approved', 0);
        }])->paginate(5);

        return view('users-apct/index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $workspaces = SlackWorkspace::get();
        return view('users-apct/create', ['workspaces' => $workspaces]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $image = $request->file('image');
        $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('/image');

        $image->move($destinationPath, $input['imagename']);

        $last_inserted_id = User::create([
            'username' => $request['username'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'firstname' => $request['firstname'],
            'lastname' => $request['lastname'],
            'type' => $request['type'],
            'level' => $request['level'],
            'image' => $input['imagename'],
            'slack_user_id'=> '',
            'workspace_id'=> ''
        ])->id;
        UserInfo::create([
            'user_id' => $last_inserted_id,
            'stack' => $request['stack'] ,
            'skypeid'=>$request['skypeid'] ,
            'room' => $request['room'] ,
            'country'=>$request['country'] ,
            'age' => $request['age'] ,
            'notes' => $request['notes'] ,
            'called'=>$request['called'] ,
            'approved' => $request['approved'] ,
            'time_doctor_email' => $request['time_doctor_email'] ,
            'time_doctor_password' => $request['time_doctor_password'],
            'channel_id' => $request['channel_id']
        ]);
        return redirect()->intended('/applicants');
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
        // Redirect to user list if updating user wasn't existed
        if ($user == null || $user->count() == 0) {
            return redirect()->intended('/applicants');
        }

        return view('users-apct/edit', ['user' => $user, 'workspaces' => $workspaces]);
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

        $input = [
            'username' => $request['username'],
            'firstname' => $request['firstname'],
            'lastname' => $request['lastname'],
            'type' => $request['type'],
            'level' => $request['level'],
            'image' => ''
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
            'channel_id' => $request['channel_id']
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::where('id', $id)->delete();
        return redirect()->intended('/applicants');
    }

    /**
     * Search user from database base on some specific constraints
     *
     * @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $constraints = [
            'username' => $request['username'],
            'firstname' => $request['firstname'],
            'lastname' => $request['lastname'],
            'department' => $request['department']
        ];

        $users = $this->doSearchingQuery($constraints);
        return view('users-apct/index', ['users' => $users, 'searchingVals' => $constraints]);
    }

    private function doSearchingQuery($constraints) {
        $query = User::query();
        $fields = array_keys($constraints);
        $index = 0;
        foreach ($constraints as $constraint) {
            if ($constraint != null) {
                $query = $query->where( $fields[$index], 'like', '%'.$constraint.'%');
            }

            $index++;
        }
        return $query->paginate(5);
    }

    private function validateInput($request) {
        $this->validate($request, [
            'username' => 'required|max:20',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'firstname' => 'required|max:60',
            'lastname' => 'required|max:60'
        ]);
    }
}
