<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberLog extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'member_logs';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */ 
    protected $fillable = [
        'userid' , 'task' , 'url' , 'track_hour' , 'log_date' , 'summary' , 'validated' , 'penalty'
   ];
}
