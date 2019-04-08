<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    protected $table = 'sub_categories';

    public static function getsubcategoryname($id){
    	$check = Subcategory::find($id);
    	if(count($check) == 1){
    		return $check->name;
    	}
    	return "";
    }

    public static function autogeneratecode(){
    	$count=Subcategory::count()+1001;
    	$code='SCA'.$count;
    	return $code;
    }
}
