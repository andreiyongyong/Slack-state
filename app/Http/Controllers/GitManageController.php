<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;

class GitManageController extends Controller
{
	    /**
     * Create a new controller instance.
     *
     * @return void
     */
	private $client;

	private $username;

	private function handleAPIException($e)
    {
        // error processing

    }

    public function __construct(\Github\Client $client)
    {
        $this->middleware('auth');

        $this->client = $client;
        $this->username = env('GITHUB_USERNAME');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
    	$users = User::where('type', 2)->orderBy('workspace_id', 'asc')->get();

    	try {
            $repos = $this->client->api('current_user')->repositories();

            return view('gitmanage/index' , ['users'=>$users, 'repos' => $repos ]);
          
	    } 
        catch (\RuntimeException $e) {
	        
            $this->handleAPIException($e);

	    }
    }

    public function updateinfo() {
        try {
            $paginator = new \Github\ResultPager($this->client);
            $repos = $paginator->fetchAll(
                $this->client->api('current_user'),
                'repositories',
                []
            );
        }
        catch (\RuntimeException $e){
            $this->handleAPIException($e);
        }

//        foreach ($repos as $repo ){
//            print_r($repo['name']);
//            print_r('<br>');
//        }
//        print_r(count($repos));exit;

        DB::table('repository_allocation')->delete();
        foreach ($repos as $repo ){
            $collaborators = array();
            try {
                $collaborators = $this->client->api('repo')->collaborators()->all(
                    env("GITHUB_USERNAME"),
                    $repo['name']
                );
            }
            catch (\RuntimeException $e){
                $this->handleAPIException($e);
            }

            foreach ($collaborators as $key => $res){

                $gitUsername = empty($res['login']) ? '' : $res['login'];
                $repoName = empty($repo['name']) ? '' : $repo['name'];
                $repoId = empty($res['id']) ? '' : $res['id'];

                DB::table('repository_allocation')->insert([
                    ['git_username' => $gitUsername,
                        'repository'=> $repoName,
                        'is_delete'=> 0,
                        'invite_id' => $repoId
                    ]
                ]);
            }
        }

        return redirect()->intended('/git-manage');
    }

//    public function updateinfo_1(){
//        try {
//            $repos = $this->client->api('current_user')->repositories();
//        }
//        catch (\RuntimeException $e){
//            $this->handleAPIException($e);
//        }
//        DB::table('repository_allocation')->delete();
//        foreach ($repos as $repo ){
//
//            $curl = curl_init();
//
//            curl_setopt_array($curl, array(
//                CURLOPT_USERAGENT => "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13",
//                CURLOPT_URL => "https://api.github.com/repos/".env("GITHUB_USERNAME")."/".$repo['name']."/collaborators",
//                CURLOPT_RETURNTRANSFER => true,
//                CURLOPT_ENCODING => "",
//                CURLOPT_MAXREDIRS => 10,
//                CURLOPT_TIMEOUT => 30,
//                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//                CURLOPT_CUSTOMREQUEST => "GET",
//                CURLOPT_HTTPHEADER => array(
//                    "Authorization: Bearer ".env("GITHUB_TOKEN"),
//                    "Cache-Control: no-cache"
//                ),
//            ));
//
//            $response = curl_exec($curl);
//            $err = curl_error($curl);
//
//            curl_close($curl);
//
//            if ($err) {
//                echo "cURL Error #:" . $err;
//            } else {
//                $resp = json_decode($response, true);
//                foreach ($resp as $key => $res){
//
//                    // http://php.net/manual/en/function.array-key-exists.php
//                    if (array_key_exists('login', $res) && array_key_exists('id', $res)) {
//                        DB::table('repository_allocation')->insert([
//                            ['git_username' => $res['login'], 'repository'=> $repo['name'], 'is_delete'=> 0, 'invite_id' => $res['id']]
//                        ]);
//                    }
//                }
//            }
//        }
//        return redirect()->intended('/git-manage');
//    }

    public function ajaxrepofromuser(Request $request){
        
        $gitname = $request->git_username;

        $repos = DB::table('repository_allocation')
            ->where([
                ['git_username','=', $gitname],
                ['is_delete','=', '0']
            ])->get();

        if($request->ajax())
        {
            return response()->json($repos) ;
        }
        else{
            return "not found";
        }

//        $curl = curl_init();
//        curl_setopt_array($curl, array(
//            CURLOPT_USERAGENT => "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13",
//            CURLOPT_URL => "https://api.github.com/users/".$gitname."/repos?type=all",
//            CURLOPT_RETURNTRANSFER => true,
//            CURLOPT_ENCODING => "",
//            CURLOPT_MAXREDIRS => 10,
//            CURLOPT_TIMEOUT => 30,
//            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//            CURLOPT_CUSTOMREQUEST => "GET",
//            CURLOPT_HTTPHEADER => array(
//                "Cache-Control: no-cache",
//                "Authorization: Bearer ".env("GITHUB_TOKEN")
//            ),
//        ));
//
//        $response = curl_exec($curl);
//        $err = curl_error($curl);
//
//        curl_close($curl);
//
//        if ($err) {
//            $resp['status'] = 'error';
//            $resp['string'] = "cURL Error #:" . $err;
//        }elseif(strlen($response) == 117) {
//            $resp['status'] = "success";
//            $resp['string'] = "notfound";
//
//        } else {
//            $data = json_decode($response);
//
//            for( $i = 0; $i < count($data); $i++){
//
//               if($data[$i]->owner->login != env('GITHUB_USERNAME'))  continue;
//
//                $repo_count = DB::table('repository_allocation')->where([
//                    ['git_username','=', $gitname],
//                    ['repository', '=', $data[$i]->name]
//                ])->count();
//
//                if($repo_count == 0 )
//                    DB::table('repository_allocation')->insert([
//                        ['git_username' => $gitname, 'repository'=> $data[$i]->name, 'is_delete'=> 0, 'invite_id' => $data[$i]->owner->id]
//                ]);
//            }
//
//            $resp['status'] = "success";
//            $resp['string'] = $response;
//
//        }
//        echo json_encode($resp);


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
        $delrepos = array();
        $delrepos = $request->del_repos;
        $gitname = $request->git_username;
     
        for($i = 0; $i<count($delrepos); $i++){
            DB::table('repository_allocation')->where([
                ['git_username' ,'=', $gitname],
                ['repository','=', $delrepos[$i]]
            ])->update(['is_delete' => '1']);

            $curl = curl_init();

			curl_setopt_array($curl, array(
              CURLOPT_USERAGENT => "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13",
			  CURLOPT_URL => "https://api.github.com/repos/".env('GITHUB_USERNAME')."/".$delrepos[$i]."/collaborators/".$gitname,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "DELETE",
			  CURLOPT_HTTPHEADER => array(
			    "Authorization: Bearer ".env("GITHUB_TOKEN"),
			    "Cache-Control: no-cache"
			  ),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);

			if ($err) {
			  echo "cURL Error #:" . $err;
			} else {
//			  echo $response;
			}
        }

        $result = DB::table('repository_allocation')->where([
                ['git_username' ,'=', $gitname],
                ['is_delete','=', '0']
            ])->get();
        echo json_encode($result);
    }
}