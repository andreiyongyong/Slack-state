<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use App\Project;
use Illuminate\Support\Facades\DB;


class ProjectController extends Controller
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
        $data = array();
        $projects = Project::get();
        foreach ($projects as $key => $project) {
            $data[$key]['id'] = $project->id;
           $data[$key]['p_name'] = $project->p_name;
           if($project->hot == "Hot") $data[$key]['hot'] = 'red';
           if($project->hot == "Normal") $data[$key]['hot'] = 'green';
           if($project->hot == "Loose") $data[$key]['hot'] = 'grey';
           $data[$key]['p_client'] = $project->p_client;

           $dev = "";
           $developers =  DB::table('allocation')
                            ->join('users', 'allocation.user_id','=','users.id')
                            ->join('project', 'allocation.project_id','=','project.id')
                            ->select('users.username', 'allocation.user_id','allocation.project_id')
                            ->where([
                                ['project_id','=', $project->id],
                                ['is_delete','=', '0']
                            ])->get();
            foreach ($developers as $developer) {
                $dev .= ($developer->username." ,");
            }
            if(strlen($dev) != 0) $dev = substr($dev, 0 ,strlen($dev)-1);
            $data[$key]['developer'] = $dev;

            $task = Task::where('project_id',$project->id)
                        ->orderBy('created_at', 'asc')->first();
            if(!is_object($task)) $data[$key]['task'] = "";
            else $data[$key]['task'] = $task->task_name;
            $data[$key]['status'] = $project->status;
        }
       
        return view('project/index', ['projects' => $data]);
    }


    public function getfromstatus(Request $request){
        $status = $request['status'];
        if($status == 'All'){
            $projects = Project::get();
        }else{
            $projects = Project::where('status', $status)->get();
        }
         foreach ($projects as $key => $project) {
            $data[$key]['id'] = $project->id;
           $data[$key]['p_name'] = $project->p_name;
           if($project->hot == "Hot") $data[$key]['hot'] = 'red';
           if($project->hot == "Normal") $data[$key]['hot'] = 'green';
           if($project->hot == "Loose") $data[$key]['hot'] = 'grey';
           $data[$key]['p_client'] = $project->p_client;

           $dev = "";
           $developers =  DB::table('allocation')
                            ->join('users', 'allocation.user_id','=','users.id')
                            ->join('project', 'allocation.project_id','=','project.id')
                            ->select('users.username', 'allocation.user_id','allocation.project_id')
                            ->where([
                                ['project_id','=', $project->id],
                                ['is_delete','=', '0']
                            ])->get();
            foreach ($developers as $developer) {
                $dev .= ($developer->username." ,");
            }
            if(strlen($dev) != 0) $dev = substr($dev, 0 ,strlen($dev)-1);
            $data[$key]['developer'] = $dev;

            $task = Task::where('project_id',$project->id)
                        ->orderBy('created_at', 'asc')->first();
            if(!is_object($task)) $data[$key]['task'] = "";
            else $data[$key]['task'] = $task->task_name;
            $data[$key]['status'] = $project->status;
        }

        if($request->ajax())
        {
            $response['status'] = 'success';
            $response['string'] = $data;
        }
        else{
            $response['error'] = 'error';
        }
        return response()->json($response) ;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('project/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Project::create([
            'p_name' => $request['p_name'],
            'p_client' => $request['p_client'],
            'level' => $request['level'],
            'status' => $request['status'],
            'hot' => $request['hot']
        ]);

        // return redirect()->intended('/project');
        if($request->ajax())
        {
            $response['status'] = 'success';
            
        }
        else{
            $response['error'] = 'error';
        }
        return response()->json($response) ;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ResourceManagement  $resourcesManagement
     * @return \Illuminate\Http\Response
     */
    public function show(ResourceManagement $resourcesManagement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ResourceManagement  $resourcesManagement
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::find($id);
        // Redirect to user list if updating user wasn't existed
        if ($project == null || $project->count() == 0) {
            return redirect()->intended('/project');
        }

        $tasks = Task::where('project_id',$id)->get();
        return view('project/edit', compact('project', 'tasks'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ResourceManagement  $resourcesManagement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)

    {
        Project::findOrFail($id);
        $input = [
            'p_name' => $request['p_name'],
            'p_client' => $request['p_client'],
            'meet_time' => $request['meet_time']
        ]; 

        Project::where('id', $id)
            ->update($input);

        return redirect()->intended('/project');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        Project::where('id', $id)->delete();
        return redirect()->intended('/project');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function addTask(Request $request) {

        Task::create([
            'task_name' => $request->get('t_name'),
            'project_id' =>$request->get('id'),
            'price' => $request->get('t_price')
        ]);
        $tasks = Task::get();
        return redirect()->back()->withTasks($tasks);
    }

    
}
