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
        'username' , 'email' , 'room' , 'country' , 'age' , 'github_id', 'channel_id', 'project_id', 'skypeid', 'workspace_id'
   ];

    function userinfo(){
        return $this->hasOne('App\UserInfo','user_id','id');
    }

    public function resources(){
        return $this->belongsToMany('App\ResourceManagement','user_resource_rel','user_id','resource_id');
    }
}
