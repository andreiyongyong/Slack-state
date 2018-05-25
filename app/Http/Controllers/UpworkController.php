<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\market;

class marketController extends Controller
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
        $market = market::paginate(10);

        return view('market/index', ['markets' => $market]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('market/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {     
        market::create([
            'date' => $request['date'],
            'country' => $request['country'],
            'market_name' => $request['market_name'],
            'market_id' => $request['market_id'],
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

        return redirect()->intended('/market');
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
        $market = market::find($id);
        // Redirect to user list if updating user wasn't existed
        if ($market == null || $market->count() == 0) {
            return redirect()->intended('/market');
        }

        return view('market/edit', ['market' => $market]);
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
        market::findOrFail($id);
        $input = [
            'date' => $request['date'],
            'country' => $request['country'],
            'market_name' => $request['market_name'],
            'market_id' => $request['market_id'],
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

        market::where('id', $id)
            ->update($input);

        return redirect()->intended('/market');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ResourceManagement  $resourcesManagement
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        market::where('id', $id)->delete();
        return redirect()->intended('/market');
    }
}
