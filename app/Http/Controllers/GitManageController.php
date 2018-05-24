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
        foreach ($users as $user) {
           
        }
    	try {
            $repos = $this->client->api('current_user')->repositories();
            
            return view('gitmanage/index' , ['users'=>$users, 'repos' => $repos ]);
          
	    } 
        catch (\RuntimeException $e) {
	        
            $this->handleAPIException($e);

	    }
    }

    public function ajaxrepofromuser(Request $request){
        
        $resp = array();
        $gitname = $request->git_username;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_USERAGENT => "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13",
            CURLOPT_URL => "https://api.github.com/users/".$gitname."/repos?type=all",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Cache-Control: no-cache",
                "Authorization: Bearer ".env("GITHUB_TOKEN")
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $data = json_decode($response);

        if ($err) {
            $resp['status'] = 'error';
            $resp['string'] = "cURL Error #:" . $err;
        }elseif(strlen($response) == 117) {
            $resp['status'] = "success";
            $resp['string'] = "notfound";

        }
        else {
            $data = json_decode($response);
            
            for( $i = 0; $i < count($data); $i++){

               if($data[$i]->owner->login != env('GITHUB_USERNAME'))  continue;
                
                $repo_count = DB::table('repository_allocation')->where([
                    ['git_username','=', $gitname],
                    ['repository', '=', $data[$i]->name]
                ])->count();

                if($repo_count == 0 )
                    DB::table('repository_allocation')->insert([
                        ['git_username' => $gitname, 'repository'=> $data[$i]->name, 'is_delete'=> 0, 'invite_id' => $data[$i]->owner->id]
                ]);
            }
            
            $resp['status'] = "success";
            $resp['string'] = $response;

        }
        echo json_encode($resp);

    }

    public function updaterepos(Request $request){
        $data = array();
        $reposname = array();
        $reposname = $request->repos_name;
        $gitname = $request->git_username;
        
        for($i = 0; $i < count($reposname); $i++){

            $repo_count = DB::table('repository_allocation')->where([
                    ['git_username','=', $gitname],
                    ['repository', '=', $reposname[$i]]
                ])->count();
           
            if($repo_count != 0) continue; // if gitusername is invited with repos, not send

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_USERAGENT => "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13",
                CURLOPT_URL => "https://api.github.com/repos/".env('GITHUB_USERNAME')."/".$reposname[$i]."/collaborators/".$gitname,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "PUT",
                CURLOPT_POSTFIELDS => "{\n\t\"permission\": \"admin\"\n}",
                CURLOPT_HTTPHEADER => array(
                    "Authorization: Bearer ".env("GITHUB_TOKEN"),
                    "Cache-Control: no-cache",
                    "Content-Type: application/json"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                $resp['status'] = "error";
                $resp['string'] = "cURL Error #:" . $err;
                echo json_encode($resp);
                return;
            } 

            array_push($data, $response); 
        // have to confirm to invite accept status    
            // DB::table('repository_allocation')->insert([
            //         ['git_username' => $gitname, 'repository'=> $reposname[$i]]
            // ]);
        
        }
        
        // $updateData = DB::table('repository_allocation')
        //     ->select('repository')
        //     ->where([
        //         ['user_id','=', $userid],
        //         ['git_username','=', $gitname],
        //         ['is_delete','=', '0']
        //     ])->get();

        if($request->ajax())
        {
            $resp['status'] = "success";
            $resp['string'] = $data;
        }
        else{
            $resp['status'] = "error";
            $resp['string'] = "cURL Error #:" . $err;
        } 

        echo json_encode($resp);
    }

    public function delinvite(Request $request){
        $delinvite = array();
        $delinvite = $request->del_invite;
        $gitname = $request->git_username;
     
        for($i = 0; $i<count($delinvite); $i++){
            DB::table('repository_allocation')->where([
                ['git_username' ,'=', $gitname],
                ['invite_id','=', $delinvite[$i]]
            ])->update(['is_delete' => '1']);
        }

        $result = DB::table('repository_allocation')->where([
                ['git_username' ,'=', $gitname],
                ['is_delete','=', '0']
            ])->get();
        echo json_encode($result);
    }
}