<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Upwork extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'upwork';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */ 
    protected $fillable = [
        'date' , 'country' , 'upwork_name', 'upwork_id', 'email', 'pssword', 'rising_talent' , 'test' , 'bid_date' , 'lancer_type' , 'security_question' , 'security_answer' , 'series'
   ];
}
