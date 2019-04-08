<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Studenttracker extends Model
{
    protected $table = 'studenttracker';

    public function getTask(){
    	 return $this->belongsTo('App\Dailytaskstracker', 'taskId', 'id');
    }

    public function getStudent(){
    	 return $this->belongsTo('App\Students', 'studentId', 'id');
    }

    public function getOption(){
    	 return $this->belongsTo('App\Dailytasksmetatracker', 'optionId', 'id');
    }
   	

}
