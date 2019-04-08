<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dailytasksstatus extends Model
{
    protected $table = 'dailytasksstatus';

    public static function getstatusname($id){
    	$record=Dailytasksstatus::find($id);
    	if(count($record)==1){
    		return $record->name;
    	}
    	return '';
    }
}
