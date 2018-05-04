<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    protected $table = 'user_infos';
    protected $fillable = ['user_id','stack' , 'skypeid' , 'room', 'country', 'age', 'notes', 'called', 'approved', 'time_doctor_email', 'time_doctor_password'];
}
