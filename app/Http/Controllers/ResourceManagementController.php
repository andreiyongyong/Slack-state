<?php

namespace App\Http\Controllers;

use App\Project;
use App\ResourceManagement;
use App\User;
use Illuminate\Http\Request;
use App\ResourceDetails;

class ResourceManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resources = ResourceManagement::with('project_info')->get();

        return view('resources-mgmt/index', ['resources' => $resources]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects = Project::get();
        return view('resources-mgmt/create', ['projects' => $projects]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        ResourceManagement::create([
            'name' => $request['name'],
            'content' => $request['content'],
            'type' => $request['type'],
            'level' => $request['level'],
            'project_id' => $request['project'],
            'user_id' => -1
        ]);

        return redirect()->intended('/resource-management');
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
        $resource = ResourceManagement::find($id);
        $resource_details = ResourceDetails::get_metas_by_resource_id($id);
        $projects = Project::get();

        if ($resource == null || $resource->count() == 0) {
            return redirect()->intended('/resource-management');
        }

        return view('resources-mgmt/edit', ['resource' => $resource, 'projects' => $projects, 'details' => $resource_details === null ? [] : $resource_details]);
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
        ResourceManagement::findOrFail($id);
        $constraints = [
            'name' => 'required|max:100',
            'content' => 'required'
        ];

        $input = [
            'name' => $request['name'],
            'content' => $request['content'],
            'type' => $request['type'],
            'level' => $request['level'],
            'project_id' => $request['project']
        ];
//        $this->validate($input, $constraints);
        ResourceManagement::where('id', $id)
            ->update($input);

        return redirect()->intended('/resource-management');
    }

    public function addResourceDetail(Request $request)
    {
        $id = $request['_id'];

        if($request['type'] == 'file'){
            $image = $request->file('value');

            $value = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/resources/files');

            $image->move($destinationPath, $value);
        } else {
            $value = $request['value'];
        }

        ResourceDetails::update_resource_meta($id, $request['key'], $value, $request['type']);

        return redirect()->intended('/resource-management/'.$id.'/edit');
    }

    public function deleteResourceDetail($id)
    {
        $detail = ResourceDetails::find($id);
        ResourceDetails::where('id', $id)->delete();

        return redirect()->intended('/resource-management/'.$detail->resource_id.'/edit');
    }

    public function editResourceDetail(Request $request)
    {

        if($request['type'] == 'file'){
            $image = $request->file('value');

            $value = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/resources/files');

            $image->move($destinationPath, $value);
        } else {
            $value = $request['value'];
        }

        ResourceDetails::update_resource_meta($request['id'], $request['key'], $value, $request['type']);

        return redirect()->intended('/resource-management/'.$request['id'].'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ResourceManagement  $resourcesManagement
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ResourceManagement::where('id', $id)->delete();
        return redirect()->intended('/resource-management');
    }
}
