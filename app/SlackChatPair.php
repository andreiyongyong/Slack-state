<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SlackChatPair extends Model
{
    protected $table = 'slack_chat_pair';
    protected $fillable = ['user_id_1', 'workspace_id_1', 'project_id', 'user_id_2', 'workspace_id_2','admin_id_1', 'admin_id_2'];

    function project(){
        return $this->hasOne('App\Project','id','project_id');
    }

    function workspace_1(){
        return $this->hasOne('App\SlackWorkspace','id','workspace_id_1');
    }
    function user_1(){
        return $this->hasOne('App\User','id','user_id_1');
    }

    function admin_1(){
        return $this->hasOne('App\User','id','admin_id_1');
    }

    function workspace_2(){
        return $this->hasOne('App\SlackWorkspace','id','workspace_id_2');
    }
    function user_2(){
        return $this->hasOne('App\User','id','user_id_2');
    }

    function admin_2(){
        return $this->hasOne('App\User','id','admin_id_2');
    }

}
