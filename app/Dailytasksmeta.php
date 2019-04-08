<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dailytasksmeta extends Model
{
    protected $table = 'dailytasksmeta';

    public static function getoptionname($id){
    	$record=Dailytasksmeta::find($id);
    	if(count($record)==1){
    		return $record->optionName;
    	}
    	return '';
    }
}
