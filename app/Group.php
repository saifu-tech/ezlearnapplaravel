<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';

    public static function autogeneratecode(){
    	$count=Group::count()+1001;
    	$code='GR'.$count;
    	return $code;
    }

    public static function getgroupname($id){
    	$record=Group::find($id);
    	if(count($record)==1){
    		return $record->group_name;
    	}
    	return '';
    }
}
