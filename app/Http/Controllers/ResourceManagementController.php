<?php

namespace App\Http\Controllers;

use App\ResourceManagement;
use Illuminate\Http\Request;

class ResourceManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resources = ResourceManagement::paginate(5);

        return view('resources-mgmt/index', ['resources' => $resources]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('resources-mgmt/create');
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
            'title' => $request['title'],
            'url' => $request['url'],
            'content' => $request['content'],
            'type' => $request['type'],
            'level' => $request['level']
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
        // Redirect to user list if updating user wasn't existed
        if ($resource == null || $resource->count() == 0) {
            return redirect()->intended('/resource-management');
        }

        return view('resources-mgmt/edit', ['resource' => $resource]);
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
            'title' => 'required|max:100',
            'url'=> 'required|max:191',
            'content' => 'required'
        ];

        $input = [
            'title' => $request['title'],
            'url' => $request['url'],
            'content' => $request['content'],
            'type' => $request['type'],
            'level' => $request['level']
        ];
//        $this->validate($input, $constraints);
        ResourceManagement::where('id', $id)
            ->update($input);

        return redirect()->intended('/resource-management');
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
