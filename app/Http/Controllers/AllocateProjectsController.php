<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Project;
use App\User;

class AllocateProjectsController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
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
                            ->select("*")
                            ->where('developer', $userid)
                            ->get();
        
        if($request->ajax())
        {
            return response()->json($uproject) ;
        }
        else{
            return "not found";
        } 
    }
}
