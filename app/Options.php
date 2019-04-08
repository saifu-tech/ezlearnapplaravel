<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Options extends Model
{
    protected $table = 'options';

    public static function getvalue($key)
	{
		$check = Options::where('key','=',$key)->first();
		if($check)
		{
			return $check->value;
		}
		else
		{
			return '';
		}
	}
}
