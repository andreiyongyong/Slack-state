<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AwsMaster extends Model
{
    protected $table = 'awsmaster';

    protected $fillable = [ 'aws_client','aws_url', 'aws_username','aws_password' ];

    public function awsinstance()
    {
        return $this->hasOne('App\AwsInstance','aws_mid','id');
    }
}
