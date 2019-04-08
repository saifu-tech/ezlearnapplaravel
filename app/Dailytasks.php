<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dailytasks extends Model
{
    protected $table = 'dailytasks';

    public static function getgroupname($id){
    	$record=Dailytasks::where('serialNo',$id)->first();
    	if(count($record)==1){
    		return $record->groupName;
    	}
    	return '';
    }

    public  static function getserialno($increment = 1){
    	$record = Dailytasks::orderBy('serialNo', 'DESC')->first();
    	$serialNo = 1;
    	if($record){
    		$serialNo = $record->serialNo+$increment;
    	}
    	$count = Dailytasks::where('serialNo', $serialNo)->count();
    	if($count > 0){
    		return Dailytasks::getserialno(++$increment);
    	}
    	return $serialNo;
    }
}
