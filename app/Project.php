<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'project';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */ 
    protected $fillable = [
        'p_name' , 'p_client' , 'price' , 'meet_time' ,'id'
   ];

    function tasks(){
        return $this->hasMany('App\Task','project_id','id');
    }
}
