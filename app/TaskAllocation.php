<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskAllocation extends Model
{
    protected $table = 'task_allocation';

    protected $fillable = [
        'is_delete',
        'task_id',
        'userid',
        'id'
    ];
}
