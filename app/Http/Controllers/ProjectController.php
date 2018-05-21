<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use App\Project;

class ProjectController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        $projects = Project::paginate(10);

        return view('project/index', ['projects' => $projects]);
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
            'meet_time' => $request['meet_time']
        ]);

        return redirect()->intended('/project');
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
