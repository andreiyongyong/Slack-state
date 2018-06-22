<?php

namespace App\Http\Controllers;

use App\User;
use Dompdf\Exception;
use Illuminate\Http\Request;
use App\SlackToken;
use \Lisennk\Laravel\SlackWebApi\SlackApi;
use \Lisennk\Laravel\SlackWebApi\Exceptions\SlackApiException;

class HelperController extends Controller
{
    public static function getAvatar($slack_id, $workspace_id){

        try{
            $token = SlackToken::where('workspace_id', $workspace_id)->get()->first();
            if(isset($token->token)){
                $token = $token->token;
            }else{
                return '/image/user_temp.jpg';
            }

            $api = new SlackApi($token);
            $result = $api->execute('users.info', ['user' => $slack_id]);
            if($result['ok']){
                return $result['user']['profile']['image_512'];
            }else{
                return '/image/user_temp.jpg';

            }
        }catch (SlackApiException $e){
            return '/image/user_temp.jpg';
        }
    }
}
