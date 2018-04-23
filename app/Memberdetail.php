<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Memberdetail extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'memberdetail';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */ 
    protected $fillable = [
         'm_id' , 'task_' , 'track_' , 'update_' , 'screen_'
    ];
     
}
