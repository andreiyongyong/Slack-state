<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SlackWorkspace extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'slack_workspaces';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'token' , 'workspace_id', 'name', 'domain', 'id_'
    ];
}
