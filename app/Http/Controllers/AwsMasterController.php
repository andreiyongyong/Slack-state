<?php

namespace App\Http\Controllers;

use App\AwsMaster;
use App\AwsInstance;
use Illuminate\Http\Request;

class AwsMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aws = AwsMaster::paginate(5);

        return view('awsmaster/index', ['aws' => $aws]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('awsmaster/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $file = $request->file('pem_file');
        $input['pem_file'] = time().'.'.$file->getClientOriginalExtension();
        $destinationPath = public_path('/files');

        $file->move($destinationPath, $input['pem_file']);

       $last_insert_id = AwsMaster::create([
            'aws_client' => $request['aws_client'],
            'aws_url' => $request['aws_url'],
            'aws_username' => $request['aws_username'],
            'aws_password' => $request['aws_password']
        ])->id;
        AwsInstance::create([
            'aws_mid' => $last_insert_id,
            'purpose' => $request['purpose'],
            'country' => $request['country'],
            'ip' => $request->ip(),
            'pem_file' => $input['pem_file']
        ]);


        return redirect()->intended('/aws-master');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AwsMaster  $awsMaster
     * @return \Illuminate\Http\Response
     */
    public function show(AwsMaster $awsMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AwsMaster  $awsMaster
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $aws = AwsMaster::with('awsinstance')->find($id);
        // Redirect to user list if updating user wasn't existed
        if ($aws == null || $aws->count() == 0) {
            return redirect()->intended('/aws-master');
        }

        return view('awsmaster/edit', ['aws' => $aws]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AwsMaster  $awsMaster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($request->file('pem_file')){
            $pem_file = $request->file('pem_file');
            $aws_instance['pem_file'] = time().'.'.$pem_file->getClientOriginalExtension();
            $destinationPath = public_path('/files');

            $pem_file->move($destinationPath, $aws_instance['pem_file']);
        }

        $aws_master = [
            'aws_client' => $request['aws_client'],
            'aws_url' => $request['aws_url'],
            'aws_username' => $request['aws_username'],
            'aws_password' => $request['aws_password']
        ];
        $aws_instance = [
            'purpose' => $request['purpose'],
            'country' => $request['aws_url'],
            'ip' => $request->ip()
        ];
        AwsMaster::where('id', $id)
            ->update($aws_master);

        AwsInstance::where('aws_mid', $id)
            ->update($aws_instance);


        return redirect()->intended('/aws-master');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AwsMaster  $awsMaster
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        AwsMaster::where('id', $id)->delete();
        AwsInstance::where('aws_mid', $id)->delete();
        return redirect()->intended('/aws-master');
    }
}
