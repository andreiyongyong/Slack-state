<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    
    protected $table = 'users';
    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = ['remember_token'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    protected $fillable = [
        'username' , 'email' , 'country' , 'age' , 'github_id', 'channel_id', 'workspace_id', 'slack_user_id',
        'time_doctor_email', 'time_doctor_password' ,'time_doctor_token', 'type', 'level'
   ];

    function userinfo(){
        return $this->hasOne('App\UserInfo','user_id','id');
    }

    public function allocation() {
        return $this->hasMany('App\Allocation', 'user_id', 'id');
    }

    public function task_allocation() {
        return $this->hasMany('App\TaskAllocation', 'user_id', 'id');
    }

    public function resources(){
        return $this->belongsToMany('App\ResourceManagement','user_resource_rel','user_id','resource_id');
    }
}
