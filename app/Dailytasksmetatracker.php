<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dailytasksmetatracker extends Model
{
    protected $table = 'dailytasksmetatracker';

    public static function getoptionname($id){
    	$record=Dailytasksmeta::find($id);
    	if(count($record)==1){
    		return $record->optionName;
    	}
    	return '';
    }
}
