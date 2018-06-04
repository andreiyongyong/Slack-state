<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ResourceDetails extends Model
{
    protected $table = 'resource_details';

    static function update_resource_meta($resource_id, $resource_key, $resource_value = '', $meta_type = ''){
        $query = DB::table('resource_details')->where('resource_id', $resource_id)->where('meta_key', $resource_key)->first();
        $file_name = '';
        $file_content = '';

        if($meta_type == 'file'){
            $file_name = $resource_value['file_name'];
            $file_content = $resource_value['file_content'];
            $resource_value = $resource_value['value'];
        }

        if( $query === null ) {
            DB::table('resource_details')->insert([
                'resource_id' => $resource_id,
                'meta_key'    => $resource_key,
                'meta_value'  => $resource_value == null ? '' : $resource_value,
                'meta_type'   => $meta_type == null ? '' : $meta_type,
                'file_content' => $file_content,
                'file_name' => $file_name
                ]
            );
        } else {
            DB::table('resource_details')
                ->where('resource_id', $resource_id)
                ->where('meta_key', $resource_key)
                ->update([
                    'meta_value'  => $resource_value == null ? '' : $resource_value,
                    'meta_type'  => $meta_type == null ? '' : $meta_type,
                    'file_content' => $file_content,
                    'file_name' => $file_name
                ]);
        }
    }

    static function delete_resource_meta($resource_id, $resource_key){
        $query = DB::table('resource_details')->where('resource_id', $resource_id)->where('meta_key', $resource_key)->first();

        if( $query !== null ) {
            DB::table('resource_details')
                ->where('resource_id', $resource_id)
                ->where('meta_key', $resource_key)
                ->delete();
        }
    }

    static function get_resource_meta($resource_id, $resource_key){
        $query = DB::table('resource_details')->where('resource_id', $resource_id)->where('meta_key', $resource_key)->first();

        if( $query !== null ) {
            return $query->meta_value;
        } else{
            return null;
        }
    }

    static function get_metas_by_resource_id($resource_id, $type = ''){

        if($type != ''){
            $query = DB::table('resource_details')->where('resource_id', $resource_id)->where('meta_type', $type)->get();
        }else{
            $query = DB::table('resource_details')->where('resource_id', $resource_id)->get();
        }

        if( $query !== null ) {
            $metas = [];
            foreach ($query as $meta){
                $metas[] = array(
                    'id' => $meta->id,
                    'key' => $meta->meta_key,
                    'value' => $meta->meta_value,
                    'type' => $meta->meta_type,
                    'file_name' => $meta->file_name,
                    'file_content' => $meta->file_content,
                );
            }

            return $metas;
            
        } else{
            return [];
        }
    }
}
