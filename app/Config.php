<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
	protected $table = 'configuration';

    public function getValue($key){
    	return Config::where('name',$key)->first()->value;
    }
}
