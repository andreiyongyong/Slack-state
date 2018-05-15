<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ResourceDetails extends Model
{
    protected $table = 'resource_details';

    static function update_resource_meta($resource_id, $resource_key, $resource_value){
        $query = DB::table('resource_details')->where('resource_id', $resource_id)->where('meta_key', $resource_key)->first();

        if( $query === null ) {
            DB::table('resource_details')->insert([
                'resource_id' => $resource_id,
                'meta_key'    => $resource_key,
                'meta_value'  => $resource_value
                ]
            );
        } else {
            DB::table('resource_details')
                ->where('resource_id', $resource_id)
                ->where('meta_key', $resource_key)
                ->update([ 'meta_value'  => $resource_value ]
            );
        }
    }
}
