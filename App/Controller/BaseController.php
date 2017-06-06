<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/1
 * Time: 14:43
 */

namespace App\Controller;

use Com\Factory;

//use App\Base;

class BaseController
{
	//获取错误码
	public function getErrorCode($code){
		return Factory::getCoreException($code)->getErrorCode($code);
	}
	//获取错误信息
	public function getErrorMsg($code){
		return Factory::getCoreException($code)->getErrorDes($code);
	}

}
?>