<?php

namespace App;
use App\Options;

use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
	protected $table = 'pages';

	public static function getpagename($id){
		$record=Pages::find($id);
		if(count($record)==1){
			$name=$record->pageName;
			if($name=='class'){
				return Options::getvalue('lable1');
			}elseif($name=='subject'){
				return Options::getvalue('lable2');
			}else{
				return $name;
			}
		}
		return '';
	}

}
