<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dailytaskstracker extends Model
{
    protected $table = 'dailytaskstracker';

    public function getstudentdata(){
         return $this->hasMany('App\Dailytasksstudent', 'trackerId', 'id');
    }

    public function getoption(){
        return $this->hasMany('App\Dailytasksmetatracker','trackerId','id');
    }
    public function getstatus(){
          return $this->hasMany('App\Dailytasksstatustracker','trackerId','id');
    }

}
