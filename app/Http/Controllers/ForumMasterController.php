<?php

namespace App\Http\Controllers;

use App\ForumMaster;
use App\Task;
use App\ForumInstance;
use Illuminate\Http\Request;

class ForumMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $forummaster = ForumMaster::paginate(5);

        return view('forummaster/index', ['forummaster' => $forummaster]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tasks = Task::with('project')->get();

        $projects = [];

        foreach($tasks as $task){
            $projects[$task->project['id']] = $task->project['p_name'];
        }

        return view('forummaster/create',['projects'=>$projects,'tasks'=>$tasks]);
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
            'posted_date' => $request['posted_date']
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
        $forums = ForumInstance::with('user')->where('forum_mid',2)->get();

        return view('forummaster/show', ['forums' => $forums]);

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
        // Redirect to user list if updating user wasn't existed
        if ($forum == null || $forum->count() == 0) {
            return redirect()->intended('/forum-master');
        }

        return view('forummaster/edit', ['forum' => $forum]);
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
}
