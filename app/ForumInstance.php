<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumInstance extends Model
{
    protected $table = 'foruminstance';

    public function forum()
    {
        return $this->hasOne('App\ForumMaster','id','forum_mid');
    }

    public function user()
    {
        return $this->hasOne('App\User','id','userid');
    }
}
