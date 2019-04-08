<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
	protected $table = 'privilege';
	public $timestamps=false;

	public static function getprivilegestatus($pageId,$userId,$key){
		$record=Privilege::where('pageId',$pageId)->where('userId',$userId)->first();
		if($record){
			$val=$record->$key;
			if($val==1){
				return 'yes';
			}else{
				return 'no';
			}
		}else{
			return 'no';
		}
	}


	public static function getprivilegearraystatus($pageIds,$userId){
		$record=Privilege::whereIn('pageId',$pageIds)->where('userId',$userId)->where('viewStatus',1)->count();
		if($record>0){
			return 'yes';
		}
		return 'no';
	}
}
