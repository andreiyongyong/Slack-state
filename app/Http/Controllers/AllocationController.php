<?php

namespace App\Http\Controllers;

use App\Project;
use App\ResourceManagement;
use App\User;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Resource;

class AllocationController extends Controller
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

    public function index()
    {
        $users = User::where('type', '=',2)->where('level', '=',11)->get();
        $projects = Project::get();

        $user_res = [];
        if($users){
            $user_res = $this->getResourcesByUser($users[0]->id);
        }

        $project_res = [];
        if($projects){
            $project_res = $this->getResourcesByProject($projects[0]->id);
        }

        return view('allocation/index', ['users' => $users, 'projects' => $projects, 'user_res' => $user_res, 'project_res' => $project_res]);
    }

    public function getResourcesByUser($user_id){
        $resources = ResourceManagement::where('user_id', $user_id)->get();
        
        if(!$resources){
            return [];
        }
        
        foreach ($resources as $key => $resource){
            $project = Project::find($resource->project_id);
            if($project){
                $project_name = $project->p_name;
                $resources[$key]->pr_name = $project_name;
            }else{
                unset($resources[$key]);
            }
        }
        return $resources;
    }

    public function getResourcesByProject($project_id){
        $resources = ResourceManagement::where('project_id', $project_id)->where('user_id', -1)->get();
        if(!$resources){
            return [];
        }

        foreach ($resources as $key => $resource){
            $project = Project::find($resource->project_id);
            if($project){
                $project_name = $project->p_name;
                $resources[$key]->pr_name = $project_name;
            }else{
                unset($resources[$key]);
            }
        }

        return $resources;
    }

    public function getResourcesByUser_ajax($id){
        $user_res = $this->getResourcesByUser($id);

        return response()->json($user_res);
    }

    public function getResourcesByProject_ajax($id){
        $project_res = $this->getResourcesByProject($id);

        return response()->json($project_res);
    }

    public function updateUserResources_ajax(Request $request){
        $id = $request['id'];
        $user_id = $request['user_id'];
        $resource = ResourceManagement::find($id);
        $resource->user_id = $user_id;
        $resource->save();
    }

    public function updateProjectResources_ajax(Request $request){
        $id = $request['id'];
        $resource = ResourceManagement::find($id);
        $resource->user_id = -1;
        $resource->save();
    }
}
