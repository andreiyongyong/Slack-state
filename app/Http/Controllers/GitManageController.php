<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Github\Api\Repository\Collaborators;


class GitManageController extends Controller
{
	    /**
     * Create a new controller instance.
     *
     * @return void
     */
	private $client;

	private $username;

    public function __construct(\Github\Client $client)
    {
        $this->middleware('auth');

        $this->client = $client;
        $this->username = env('GITHUB_USERNAME');
    }

    public function index()
    {
    	$users = User::paginate(10);

    	try {
            $repos = $this->client->api('current_user')->repositories();
            // /user/repos
            
            return view('gitmanage/index' , ['users'=>$users, 'repos' => $repos ]);
          
	    } catch (\RuntimeException $e) {
	      $this->handleAPIException($e);
	    }
    }

    public function ajaxrepofromuser(Request $request){
        
        $gitname = $request->userid;

        try {
             // $repos = $this->client->api('current_user')->repositories("githubZheng");
            // /users/:username/repos

            $repos = $this->client->api("resp")->collaborators();
            //  // GET /repos/:owner/:repo/collaborators/:username
            // var_dump($repos);exit;
	    } catch (\RuntimeException $e) {
	      $this->handleAPIException($e);
	    }
        
        if($request->ajax())
        {
            return response()->json($repos) ;
        }
        else{
            return "not found";
        } 
    }

}