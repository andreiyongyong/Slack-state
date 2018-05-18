<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Github\Client;

class GitManageController extends Controller
{
	    /**
     * Create a new controller instance.
     *
     * @return void
     */
	private $client;

	private $username;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	// $this->client = $client;
    	// $this->username = env('GITHUB_USERNAME');

    	$users = User::paginate(10);

    // 	try {
	   //    $repos = $this->client->api('current_user')->repositories();

		  
		  // // return View::make('repos', ['repos' => $repos]);
	   //  } catch (\RuntimeException $e) {
	   //    $this->handleAPIException($e);
	   //  }

    	return view('gitmanage/index' , ['users'=>$users]);
    }

    public function ajaxrepofromuser(Request $request){
        
        $userid = $request->userid;
        
        if($request->ajax())
        {
            // return response()->json($uproject) ;
        }
        else{
            return "not found";
        } 
    }

}