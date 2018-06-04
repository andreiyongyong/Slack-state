<?php

namespace App\Http\Controllers;

use App\Project;
use App\ResourceDetails;
use App\ResourceManagement;
use App\SlackToken;
use App\User;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Resource;
use \Lisennk\Laravel\SlackWebApi\SlackApi;
use \Lisennk\Laravel\SlackWebApi\Exceptions\SlackApiException;
use Illuminate\Support\Facades\Auth;

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
        $user = User::where('id',$user_id)->with('resources')->get();

        if(isset($user[0])){
            $resources = $user[0]->resources;
        }else{
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
        $resources = ResourceManagement::where('project_id', $project_id)->get();
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
        $allow = true;

        $user = User::find($request['user_id']);
        $relatedIds = $user->resources()->allRelatedIds()->toArray();

        if (in_array($id, $relatedIds)) {
            $allow = false;
        } else {
            $newIds = array_unique(array_merge($relatedIds, [$request['id']]));
            $user->resources()->sync($newIds);
        }

        if($allow){
            try {
                $token = SlackToken::where('workspace_id', $user->workspace_id)->where('user_id', Auth::user()->id)->get()->first();

                if($token) {
                    $api = new SlackApi($token->token);
                    $resource = ResourceManagement::find($id);

                    $message = 'Resource : '.$resource->name."\n";
                    $message .= 'Content : '.$resource->content."\n";

                    $metas = ResourceDetails::get_metas_by_resource_id($id);
                    if(!empty($metas)){
                        $message .= "Details` \n";

                        foreach ($metas as $meta){
                            if($meta['type'] != 'file'){
                                $message .= '    '.$meta['key'].' : '.$meta['value']."\n";
                            }
                        }
                    }

                    $response = $api->execute('chat.postMessage', [
                        'channel' => $user->channel_id,
                        'text' => $message,
                        'as_user' => true
                    ]);

                   foreach ($metas as $file){
                       if($file['type'] == 'file'){
                           $response = exec('curl -F file=@' . public_path('/resources/files/') . $file['value']. ' -F channels=' . $user->channel_id . ' -F filename=' . $file['value'] . ' -F token=' . $token->token . ' https://slack.com/api/files.upload');                       }
                   }

                }

            } catch (SlackApiException $e) {}
        }

        return response()->json($allow);
    }

    public function deleteUserResource_ajax(Request $request){

        $user = User::find($request['user_id']);
        $user->resources()->detach($request['id']);
    }
}
