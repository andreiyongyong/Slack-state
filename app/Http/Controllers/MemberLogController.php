<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;  
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\support\Symfony\Component\HttpFoundation\File\UploadedFile;

use Response;

use Validator;

use App\MemberLog;
use App\Memberdetail;
use App\Picture;

class MemberLogController extends Controller
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
        $member_logs = DB::table('member_logs')  
        ->select('member_logs.*')
        ->paginate(50);

        return view('member-log/index', ['member_logs' => $member_logs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $id = DB::table('member_logs')->insertGetId(
            [
                'userid'    => Auth::id()  
            ]
        );  
        return view('member-log/create', ['memberid' => $id] );  
    } 
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {     
        $input['userid'] = Auth::id(); 
        $keys = ['task', 'url', 'track_hour', 'log_date', 'summary' , 'validated' , 'penalty'];
        $input = $this->createQueryInput($keys, $request);  

        MemberLog::where('id',$request['member_id'])
            ->update($input); 

        return redirect()->intended('/member-log');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $member_log_temp = [];
        $logdetails     = DB::select('select * from memberdetail where m_id = ?', [$id]);

        $member_logs = MemberLog::find($id); 

        if ($member_logs == null || count($member_logs) == 0) {
            return redirect()->intended('/member-log');
        }  
        $member_log_temp['tot_task']   = '';
        $member_log_temp['tot_update'] = '';
        $member_log_temp['tot_track']  = 0;

        foreach($logdetails as $logdetail){
            $member_log_temp['tot_task']   = $member_log_temp['tot_task']." ".$logdetail->task_; 
            $member_log_temp['tot_update']   = $member_log_temp['tot_update']." ".$logdetail->update_; 
            $member_log_temp['tot_track']   = $member_log_temp['tot_track'] + $logdetail->track_;  
        }  

        return view('member-log/edit', ['member_logs' => $member_logs , 'logdetails' => $logdetails , 'member_log_temps' => $member_log_temp ]);
         
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    { 
        $input['userid'] = Auth::id(); 
        $keys = ['task', 'url', 'track_hour', 'log_date', 'summary' , 'validated' , 'penalty'];
        $input = $this->createQueryInput($keys, $request);  

        MemberLog::where('id',$id)
            ->update($input);  

        return redirect()->intended('/member-log');  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::delete('delete from member_logs where id = ?', [$id]); 
        DB::delete('delete from memberdetail where m_id = ?', [$id]); 

         return redirect()->intended('/member-log');
    }   

    private function createQueryInput($keys, $request) {
        $queryInput = [];
        for($i = 0; $i < sizeof($keys); $i++) {
            $key = $keys[$i];
            $queryInput[$key] = $request[$key];
        }  
        return $queryInput;
    }
 
    /**
     * Search department from database base on some specific constraints
     *
     * @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\Response
     */ 
    public function log_detail_delete(Request $request){
            DB::delete('delete from memberdetail where id = ?', [$request['id']]);
    return response("yes");
    }


    /**
     * Show the application ajaxImageUploadPost.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxImageUpload(Request $request)
    {
        $validator = Validator::make($request->all(), [  
            'task_' => 'required' ,
            'track_'=> 'required' , 
            'update_' => 'required' , 
            'screen_' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]); 

        if ($validator->passes()) { 

            $input = $request->all();
            $input['screen_'] = time().'.'.$request->screen_->getClientOriginalExtension();
            $request->screen_->move(public_path('upload_img'), $input['screen_']); 
            $id = Memberdetail::create($input)->id; 
            $mem_id = $request['m_id']; 
            return redirect()->intended('member-log/'.$mem_id.'/edit'); 
        } 
        return response()->json(['error'=>$validator->errors()->all()]);
    }
}
