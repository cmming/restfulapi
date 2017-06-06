<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/27
 * Time: 15:34
 */

namespace Com;



class Loader
{
	static function autoload($class){
		$file = BASEDIR.'/'.str_replace('\\','/',$class).'.php';
		require $file;
	}
}
?>