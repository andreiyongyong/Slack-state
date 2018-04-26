<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumMaster extends Model
{
    protected $table = 'forummaster';

    protected $fillable = [ 'task', 'question','posted_date'];

    public function project()
    {
        return $this->hasOne('App\ForumMaster','id','project_id');
    }
}
