<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    protected $table = 'students';

    public static function autogeneratecode(){
    	$count=Students::count()+1001;
    	$code='ST'.$count;
    	return $code;
    }

    public static function getstudentname($id){
    	$record=Students::find($id);
    	if(count($record)==1){
    		return $record->fullname;
    	}
    	return '';
    }

    // public static function getstudentnamealternative($id,$tracker){
    //     $record=dailytasksstudent::where('trackerId',$tracker)->where('studentId',$id)->get();
    //     if(count($record)==1){
    //         return $record->alternative_name;
    //     }
    //     return '';
    // }

    public static function getstudentemail($id){
    	$record=Students::find($id);
    	if(count($record)==1){
    		return $record->email;
    	}
    	return '';
    }

    public static function getstudentcountry($id){
        $record=Students::find($id);
        if(count($record)==1){
            return $record->countryId;
        }
        return '';
    }
}
