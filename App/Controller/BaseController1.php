<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/1
 * Time: 14:43
 */

namespace App\Controller;

use Com\Factory;

use Com\Register;

//use App\Base;

class BaseController
{
	public $response = null;
	//获取错误码
	public function getErrorCode($code){
//		return Factory::getCoreException($code)->getErrorCode($code);
		var_dump(Register::get('getModel'));exit();
		return Register::get('CoreLogger')->getErrorCode($code);
	}
	//获取错误信息
	public function getErrorMsg($code){
//		return Factory::getCoreException($code)->getErrorDes($code);
		return Register::get('CoreLogger')->getErrorDes($code);
	}

	//获取模型
	public function getModel($modelName){
		return Register::get('getModel');
	}
	//获取验证类
	public function validate(){
		return Register::get('validate');
	}

	public function class_db_api(){
		return Register::get('class_db_api');
	}
	public function core_exception($code){
		return Register::get('core_exception',$code);
	}




//	public function response(){
//		return Register::get('response');
//	}

}
?>