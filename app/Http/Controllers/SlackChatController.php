<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Lisennk\Laravel\SlackWebApi\SlackApi;
use \Lisennk\Laravel\SlackWebApi\Exceptions\SlackApiException;
use App\Project;
use App\Task;
use App\User;

class SlackChatController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $slackApi;

    public function __construct()
    {
        $this->slackApi = new SlackApi(env('SLACK_API_TOKEN'));

        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $data = $this->slackRequest('users.list');
        
        $data['projects'] = Project::with('tasks')->get();
        $data['developers'] = User::with('userinfo')->get();

//dd($data);
        return view('slack-chat.index', ['data' => $data]);
    }

    private function slackRequest($method, $params = [], $successMsg = ''){
        $data = array(
            'status'   => true,
            'message'  => $successMsg,
            'response' => []
        );

        try {
            $response       = $this->slackApi->execute($method, $params);
            $data['status'] = $response['ok'];

            if ($response['ok']) {
                unset($response['ok']);
                $data['response'] = $response;
            } else {
                $data['message'] = $response['error'];
            }

        } catch (SlackApiException $e) {
            $data['status'] = false;
            $data['message'] = $e->getMessage();
        }

        return $data;
    }
}
