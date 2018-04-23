<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

      /**
     * Show the user profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('profile');
    }

    // /**
    //  * update the user profile 
    //  * 
    //  * @param Request $request
    //  * @return Response
    //  */
    // public function update(Request $request){
    //     $request->user();
    // }
}
