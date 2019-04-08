<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classname extends Model
{
    protected $table = 'class_name';

    public static function autogeneratecode(){
    	$count=Classname::count()+1001;
    	$code='CL'.$count;
    	return $code;
    }

    public static function getclssname($id){
    	$record=Classname::find($id);
    	if(count($record)==1){
    		return $record->class_name;
    	}
    	return '';
    }
}
