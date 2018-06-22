<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserResourceRel extends Model
{
    protected $table = 'user_resource_rel';
    protected $fillable = ['user_id', 'resource_id'];
}
