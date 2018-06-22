<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Project;
use App\User;
use App\Task;

class TaskAllocationController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = User::where('type','=', 2)->orderBy('workspace_id', 'asc')->get();
        $projects = Project::get();
        $tasks = Task::get();

        return view('allocatetask/index', ['projects' => $projects, 'users' => $users, 'tasks'=> $tasks]);
    }

    public function taskfromuser(Request $request){
        
        $userid = $request->userid;
        $utask = DB::table('tasks')
                            ->join('task_allocation', 'tasks.id','=','task_allocation.task_id')
                            ->select('tasks.task_name', 'task_allocation.user_id','task_allocation.task_id')
                            ->where([
                                ['user_id','=', $userid],
                                ['is_delete','=', '0']
                            ])->get();

        
        if($request->ajax())
        {
            return response()->json($utask) ;
        }
        else{
            return "not found";
        } 
    }

    public function updatetask(Request $request){

        $taskids = array();
        $taskids = $request->task_ids;
        $userid = $request->userid;

        for($i=0; $i<count($taskids); $i++){
            $task_count = DB::table('task_allocation')->where([
                ['user_id','=', $userid],
                ['task_id', '=', $taskids[$i]],
            ])->count();
            if($task_count==0) 
                    DB::table('task_allocation')->insert([
                    ['user_id' => $userid, 'task_id'=> $taskids[$i] ,'is_delete'=> 0]
                ]);
            else{
                DB::table('task_allocation')
                    ->where([['user_id','=', $userid],['task_id', '=', $taskids[$i]]])
                    ->update(['is_delete' => 0]);
            }
        }

        $updateData = DB::table('tasks')
            ->join('task_allocation', 'tasks.id', '=', 'task_allocation.task_id')
            ->select('tasks.task_name','task_allocation.user_id','task_allocation.task_id')
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

    public function deltask(Request $request){

        $deltask = array();
        $deltask = $request->del_task_ids;
        $userid = $request->userid;
        for($i = 0; $i < count($deltask); $i++){
            DB::table('task_allocation')->where([
                ['user_id', '=' , $userid],
                ['task_id', '=' , $deltask[$i]]
            ])->update(['is_delete' => '1']);
        }

        $result = DB::table('tasks')
            ->join('task_allocation', 'tasks.id', '=', 'task_allocation.task_id')
            ->select('tasks.task_name','task_allocation.user_id','task_allocation.task_id')
            ->where([
                ['user_id','=', $userid],
                ['is_delete','=', '0']
            ])->get();
        return response()->json($result);
    }

    public function taskfromproj(Request $request){
        $project = $request->project;
        if($project == "0"){
            $task_name = Task::get();
        }else{
            $task_name = Task::where('project_id',$project)
                        ->get();
        }

        if($request->ajax())
        {
            return response()->json($task_name) ;
        }
        else{
            return "not found";
        } 
        

    }        
}
