<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForbiddenKeywords extends Model
{
    protected $table = 'forbidden_keywords';
    protected $fillable = ['keyword'];
}
