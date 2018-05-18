<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Project;
use App\User;

class AllocateProjectsController extends Controller
{
    private $client;

    private $username;
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = User::paginate(10);
        $projects = Project::paginate(10);
       
        return view('allocateprojects/index', ['projects' => $projects, 'users' => $users]);
    }

    public function ajaxprofromuser(Request $request){
        
        $userid = $request->userid;
        $uproject = DB::table('project')
                            ->join('allocation', 'project.id','=','allocation.project_id')
                            ->select('project.p_name', 'allocation.user_id','allocation.project_id')
                            ->where([
                                ['user_id','=', $userid],
                                ['is_delete','=', '0']
                            ])->get();

        if($request->ajax())
        {
            return response()->json($uproject) ;
        }
        else{
            return "not found";
        } 
    }

    public function updateproj(Request $request){

        $projname = array();
        $projname = $request->proj_id;
        $userid = $request->userid;

        for($i=0; $i<count($projname); $i++){
            $proj_count = DB::table('allocation')->where([
                ['user_id','=', $userid],
                ['project_id', '=', $projname[$i]],
            ])->count();
            if($proj_count==0) DB::table('allocation')->insert([
                ['user_id' => $userid, 'project_id'=> $projname[$i]],
            ]);
        }

        $updateData = DB::table('project')
            ->join('allocation', 'project.id', '=', 'allocation.project_id')
            ->select('project.p_name','allocation.user_id','allocation.project_id')
            ->where([
                ['user_id','=', $userid],
                ['is_delete','=', '0']
            ])->get();

        if($request->ajax())
        {
            //$data['msg'] = 'success';
            return response()->json($updateData);
        }
        else{
            return "Not found";
        } 
    }

    public function delproj(Request $request){

        $delproj = array();
        $delproj = $request->del_proj_id;
        $userid = $request->userid;
        for($i = 0; $i<count($delproj); $i++){
            DB::table('allocation')->where([
                ['user_id', '=' , $userid],
                ['project_id', '=' , $delproj[$i]]
            ])->update(['is_delete' => '1']);
        }

        $result = DB::table('project')
            ->join('allocation', 'project.id', '=', 'allocation.project_id')
            ->select('project.p_name','allocation.user_id','allocation.project_id')
            ->where([
                ['user_id','=', $userid],
                ['is_delete','=', '0']
            ])->get();
        return response()->json($result);
    }
}
