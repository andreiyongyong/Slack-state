<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SlackToken extends Model
{
    protected $table = 'slack_tokens';
    protected $fillable = ['user_id', 'workspace_id', 'token'];
}
