<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    public static function autogeneratecode(){
    	$count=Category::count()+1001;
    	$code='CA'.$count;
    	return $code;
    }

    public static function getcategoryname($id){
    	$record=Category::find($id);
    	if(count($record)==1){
    		return $record->category_name;
    	}
    	return '';
    }
}
