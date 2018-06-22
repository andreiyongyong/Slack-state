<?php

namespace App\Http\Controllers;

use App\Template;
use Dompdf\Exception;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $templates = Template::get();
        return view('template/index', ['templates' => $templates]);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [
            'error' => false,
            'msg'   => 'Successfully Created'
        ];
        try{
            Template::create([
                'title' => $request['title'],
                'content' => ''
            ]);
        }catch (Exception $e){
            $data = [
                'error' => true,
                'msg'   => $e->getMessage()
            ];
        }

        return response()->json($data);
    }

    public function getTemplates()
    {
        $templates = Template::get();

        return response()->json($templates != null ? $templates : []);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = [
            'error' => false,
            'msg'   => 'Successfully Deleted'
        ];
        try{
            Template::find($id)->delete();
        }catch (Exception $e){
            $data = [
                'error' => true,
                'msg'   => $e->getMessage()
            ];
        }

        return response()->json($data);
    }

    public function getContent($id)
    {
        return response()->json(Template::find($id)->content);
    }

    public function saveContent(Request $request)
    {
        $data = [
            'error' => false,
            'msg'   => 'Successfully Updated'
        ];
        try{
            Template::find($request['id'])->update([
                'content' => $request['content']
            ]);
        }catch (Exception $e){
            $data = [
                'error' => true,
                'msg'   => $e->getMessage()
            ];
        }

        return response()->json($data);
    }
}
