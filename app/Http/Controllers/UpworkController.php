<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Upwork;

class UpworkController extends Controller
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
        $upwork = Upwork::paginate(10);

        return view('upwork/index', ['upworks' => $upwork]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('upwork/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {     
        Upwork::create([
            'date' => $request['date'],
            'country' => $request['country'],
            'upwork_name' => $request['upwork_name'],
            'upwork_id' => $request['upwork_id'],
            'email' => $request['email'] , 
            'password' => $request['password'] , 
            'rising_talent' => $request['rising_talent'] , 
            'test' => $request['test'] , 
            'bid_date' => $request['bid_date'] , 
            'lancer_type' => $request['lancer_type'] , 
            'security_question' => $request['security_question'] , 
            'security_answer' => $request['security_answer'] ,
            'series' => $request['series']   
        ]);

        return redirect()->intended('/upwork');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ResourceManagement  $resourcesManagement
     * @return \Illuminate\Http\Response
     */
    public function show(ResourceManagement $resourcesManagement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ResourceManagement  $resourcesManagement
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $upwork = Upwork::find($id);
        // Redirect to user list if updating user wasn't existed
        if ($upwork == null || $upwork->count() == 0) {
            return redirect()->intended('/upwork');
        }

        return view('upwork/edit', ['upwork' => $upwork]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ResourceManagement  $resourcesManagement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {  
        Upwork::findOrFail($id);
        $input = [
            'date' => $request['date'],
            'country' => $request['country'],
            'upwork_name' => $request['upwork_name'],
            'upwork_id' => $request['upwork_id'],
            'email' => $request['email'] , 
            'password' => $request['password'] , 
            'rising_talent' => $request['rising_talent'] , 
            'test' => $request['test'] , 
            'bid_date' => $request['bid_date'] , 
            'lancer_type' => $request['lancer_type'] , 
            'security_question' => $request['security_question'] , 
            'security_answer' => $request['security_answer'] ,
            'series' => $request['series'] 
        ]; 

        Upwork::where('id', $id)
            ->update($input);

        return redirect()->intended('/upwork');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ResourceManagement  $resourcesManagement
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Upwork::where('id', $id)->delete();
        return redirect()->intended('/upwork');
    }
}
