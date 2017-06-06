<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/3
 * Time: 16:01
 */

namespace App;
use \Com\Factory;

class base
{
	public function getErrorCode($code){
		return Factory::getCoreException($code)->getErrorCode($code);
	}

	public function getErrorMsg(){
		return Factory::getCoreException('CODE_UNAME_EXISTS')->getErrorDes('CODE_UNAME_EXISTS');
	}
}
?>