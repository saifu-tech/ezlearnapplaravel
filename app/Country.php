<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'country';
    public static function getcountryname($id){
        $record=Country::find($id);
        if(count($record)==1){
            return $record->name;
        }
        return '';
    }

}
