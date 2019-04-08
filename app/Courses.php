<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    protected $table = 'courses';

    public static function autogeneratecode(){
    	$count=Courses::count()+1001;
    	$code='CU'.$count;
    	return $code;
    }

    public static function getcoursename($id){
    	$record=Courses::find($id);
    	if(count($record)==1){
    		return $record->name;
    	}
    	return '';
    }
}
