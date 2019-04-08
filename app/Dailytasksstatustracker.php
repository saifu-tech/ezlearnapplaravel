<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dailytasksstatustracker extends Model
{
    protected $table = 'dailytasksstatustracker';

    public function getTracker(){
    	 return $this->belongsTo('App\Dailytaskstracker', 'trackerId', 'id');
    }

    public function getStudent(){
    	 return $this->belongsTo('App\Students', 'studentId', 'id');
    }

    public function getOption(){
    	 return $this->belongsTo('App\Dailytasksmetatracker', 'optionId', 'id');
    }

}
