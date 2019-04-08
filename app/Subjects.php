<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subjects extends Model
{
    protected $table = 'subjects';

    public static function getsubjectname($id){
    	$record=Subjects::find($id);
    	if(count($record)==1){
    		return $record->name;
    	}
    	return '';
    }

    public static function autogeneratecode(){
    	$count=Subjects::count()+1001;
    	$code='SU'.$count;
    	return $code;
    }
}
