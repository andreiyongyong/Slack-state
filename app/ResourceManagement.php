<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResourceManagement extends Model
{
    protected $table = 'resources';
    protected $fillable = ['title', 'url', 'content','type','level','user_id'];
}
