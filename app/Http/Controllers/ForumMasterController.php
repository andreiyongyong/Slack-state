<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\ForumMaster;
use App\ForumInstance;
use App\Project;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ForumMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $forummaster = DB::table('forummaster')
                ->join('project', 'forummaster.project', '=', 'project.id')
                ->join('tasks', 'forummaster.task', '=', 'tasks.id')
                ->select('forummaster.id as id', 'project.p_name', 'tasks.task_name', 'forummaster.question', 'forummaster.posted_date')
                ->get();
        return view('forummaster/index', ['forummaster' => $forummaster]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $projects = Project::get();
        $project = Project::first()->pluck('id');
        $tasks = DB::table('tasks')->where('project_id', '=', $project)
                    ->get();
        return view('forummaster/create', ['projects' => $projects, 'tasks' => $tasks]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        ForumMaster::create([
            'project' => $request['project'],
            'task' => $request['task'],
            'question' => $request['question'],
            'posted_date' => $request['posted_date'],
            'project_id' => $request['project']
        ]);

        return redirect()->intended('/forum-master');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ForumMaster  $forumMaster
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $forums = ForumInstance::with('user')->where('forum_mid',$id)->get();

        return view('forummaster/show', ['forums' => $forums,'forum_mid'=>$id]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ForumMaster  $forumMaster
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $forum = ForumMaster::find($id);
        $projects = Project::get();
        $project = $forum['project'];
        $tasks = DB::table('tasks')->where('project_id', '=', $project)
                ->get();
        // Redirect to user list if updating user wasn't existed
        if ($forum == null || $forum->count() == 0) {
            return redirect()->intended('/forum-master');
        }

        return view('forummaster/edit', ['forum' => $forum, 'projects' => $projects, 'tasks' => $tasks]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ForumMaster  $forumMaster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $constraints = [
            'project' => 'required|max:100',
            'task'=> 'required|max:191',
            'question' => 'required',
            'posted_date' => 'required'
        ];

        $input = [
            'project' => $request['project'],
            'task' => $request['task'],
            'question' => $request['question'],
            'posted_date' => $request['posted_date']
        ];
//        $this->validate($input, $constraints);
        ForumMaster::where('id', $id)
            ->update($input);

        return redirect()->intended('/forum-master');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ForumMaster  $forumMaster
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ForumMaster::where('id', $id)->delete();
        return redirect()->intended('/forum-master');
    }

    public function addForumAnswer(Request $request){
        ForumInstance::create([
            'forum_mid' => $request['forum_mid'],
            'userid' => $request['userid'],
            'reply_time' => Carbon::now()->toDateTimeString(),
            'answer' => $request['answer']
        ]);
        return redirect()->intended('/forum-master/'.$request['forum_mid']);
    }

    public function taskfromproj(Request $request){
        $project = $request['project'];
        $tasks = DB::table('tasks')->where('project_id', '=', $project)
                     ->get();
        
        if($request->ajax()){
            return response()->json($tasks);
        } else {
            return "not found";
        }
    }
}

