<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';

    protected $fillable = [
        'task_name',
        'project_id',
        'price',
        'id',
        'created_at'
    ];
    public function project()
    {
        return $this->hasOne('App\Project','id','project_id');
    }

}
