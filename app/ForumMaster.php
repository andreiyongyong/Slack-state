<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumMaster extends Model
{
    protected $table = 'forummaster';

    protected $fillable = [ 'project','task', 'question','posted_date'];

}
