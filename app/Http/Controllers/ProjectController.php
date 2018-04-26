<?php

namespace App\Http\Controllers;

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
            'task' => $request['task'],
            'price' => $request['price'],
            'developer' => $request['developer'] , 
            'meet_time' => $request['meet_time'] , 
            'mode' => $request['mode'] 
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

        return view('project/edit', ['project' => $project]);
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
            'task' => $request['task'],
            'price' => $request['price'],
            'developer' => $request['developer'] , 
            'meet_time' => $request['meet_time'] , 
            'mode' => $request['mode']  
        ]; 

        Project::where('id', $id)
            ->update($input);

        return redirect()->intended('/project');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ResourceManagement  $resourcesManagement
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Project::where('id', $id)->delete();
        return redirect()->intended('/project');
    }

    
}
