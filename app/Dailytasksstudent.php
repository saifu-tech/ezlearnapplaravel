<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dailytasksstudent extends Model
{
    protected $table = 'dailytasksstudent';

     public  function getstudent(){
        return $this->hasMany('App\Students', 'id', 'studentId');
    }

    //  public static function getstudentnamealternative($id,$tracker){
    //     $record=Dailytasksstudent::where('trackerId',$tracker)->whereIn('studentId',$id)->get();
    //     if(count($record)==1){
    //         return $record->alternative_name;
    //     }
    //     return '';
    // }
    public function getstudenttask(){
        return $this->hasMany('App\Dailytaskstracker','id','trackerId');
    }
}