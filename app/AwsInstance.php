<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AwsInstance extends Model
{
    protected $table = 'awsinstance';
    protected $fillable = [ 'aws_mid','country','purpose','ip', 'pem_file','aws_password'];
}
