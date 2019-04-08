<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;

class Trackerpercentage extends Model
{
    protected $table = 'trackerpercentage';
    
    public static function getcolor($trackerId, $trackerType, $value){ //value = 110

    	//1st Method  start = 70  end = 95
    	$select = DB::table('trackerpercentage')->where('tracker_id', $trackerId)->where('tracker_type', $trackerType)->where('start_value', '<', $value)->where('end_value', '>=', $value)->first();
		if($select){
			return $select->colour;
		}

		//2nd Method  start = ''  end = 70
		$select = DB::table('trackerpercentage')->where('tracker_id', $trackerId)->where('tracker_type', $trackerType)->where('start_value', 0)->where('end_value', '>=', $value)->first();
		if($select){
			return $select->colour;
		}

		//3rd Method  start = 95  end = ''
		$select = DB::table('trackerpercentage')->where('tracker_id', $trackerId)->where('tracker_type', $trackerType)->where('start_value', '<', $value)->where('end_value', 100)->first();
		if($select){
			return $select->colour;
		}

		return 'pink';

    }	
}