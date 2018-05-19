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
            

	    } catch (\RuntimeException $e) {
	      $this->handleAPIException($e);
	    }
        
        if($request->ajax())
        {
            // return response()->json($repos) ;
        }
        else{
            return "not found";
        } 
    }

    public function updaterepos(Request $request){

        $reposname = array();
        $reposname = $request->proj_id;
        $gitname = $request->userid;

        for($i = 0; $i < count($reposname); $i++){
            $repo_count = DB::table('repository_allocation')->where([
                ['git_username','=', $gitname],
                ['repository', '=', $reposname[$i]]
            ])->count();
            if($repo_count == 0) DB::table('repository_allocation')->insert([
                ['git_username' => $gitname, 'repository'=> $reposname[$i]]
            ]);

            // $this->client->api('organizations')->members()->add($reposname[$i], $gitname);
//         $repos = $this->client->api('repo')->collaborators();
// var_dump($repos);exit;
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_USERAGENT => "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13",
                CURLOPT_URL => "https://api.github.com/repos/jangjinming311/sdsad/collaborators/LiZheng51",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "PUT",
                CURLOPT_POSTFIELDS => "{\n\t\"permission\": \"admin\"\n}",
                CURLOPT_HTTPHEADER => array(
                    "Authorization: Bearer f233bae5d68b1c625e9c065c7eaa0cfa6e17d206",
                    "Cache-Control: no-cache",
                    "Content-Type: application/json"
                ),
            ));



            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
            echo "cURL Error #:" . $err;
            } else {
            echo $response;
            }

        }

        // $updateData = DB::table('project')
        //     ->join('allocation', 'project.id', '=', 'allocation.project_id')
        //     ->select('project.p_name','allocation.user_id','allocation.project_id')
        //     ->where([
        //         ['user_id','=', $userid],
        //         ['is_delete','=', '0']
        //     ])->get();

        if($request->ajax())
        {
            //$data['msg'] = 'success';
            // return response()->json($updateData);
        }
        else{
            return "Not found";
        } 
    }

}