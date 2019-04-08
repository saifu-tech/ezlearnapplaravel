<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table = 'staff';

    public static function autogeneratecode(){
    	$count=Staff::count()+1001;
    	$code='SF'.$count;
    	return $code;
    }

    public static function getstaffcountry($id){
        $record=Staff::find($id);
        if(count($record)==1){
            return $record->countryId;
        }
        return '';
    }
}
