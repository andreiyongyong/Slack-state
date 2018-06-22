<?php

namespace App\Http\Controllers;

use App\ForbiddenKeywords;
use Illuminate\Http\Request;

class ForbiddenKeywordsController extends Controller
{

    protected $redirectTo = '/keywords';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keywords = ForbiddenKeywords::get();

        return view('keywords/index', ['keywords' => $keywords]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('keywords/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        ForbiddenKeywords::create([
            'keyword' => $request['keyword'] === null ? '' : $request['keyword']
        ]);
        return redirect()->intended('/keywords');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ForbiddenKeywords::where('id', $id)->delete();
        return redirect()->intended('/keywords');
    }
}
