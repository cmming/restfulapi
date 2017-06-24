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
		if (file_exists($file)){
			require $file;
		}else{
			throw new \Exception($file.'文件不存在');
		}
	}
	//
	public function load(){
		spl_autoload_register('\\Com\\Loader::autoload');
	}
}
?>