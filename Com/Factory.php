<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/31
 * Time: 18:53
 */

namespace Com;


//创建 工厂类 用来创建各种类
class Factory
{
	//日志类 对于单例类，没有必要封装，或者将其转换为非单例模式
	static function getCoreLogger($filename = '')
	{
//		var_dump($filename);
		$filename = preg_replace("/[^A-Za-z]/", "-", $filename);
//		var_dump($filename);
		$key = 'com_core_logger' . $filename;
		$core_logger = Register::get($key);
		if (!$core_logger) {
			$core_logger = \Com\CoreLogger::getInstance();
			if (!empty($filename)) {
				$core_logger->setLogFileName($filename);
			}
			Register::set($key, $core_logger);
		}
		return $core_logger;
	}

	//错误信息类 对于单例类，没有必要封装，或者将其转换为非单例模式(修改)
	static function getCoreException($code = '')
	{
		$key = 'com_core_exception';
		$core_exception = Register::get($key);
		if (!$core_exception) {
			$core_exception = new \Com\CoreException($code);
			Register::set($key, $core_exception);
		}
		return $core_exception;
	}

	//验证类
	static function getValidate()
	{
		$key = 'com_validate';
		$validate = Register::get($key);
		if (!$validate) {
			$validate = new \Com\Validate();
			Register::set($key, $validate);
		}
		return $validate;
	}
	//封装的数据库类
	//通过接受参数 可以创建不同的连接
	static function getClassDbApi($db_name = '')
	{
		if (empty($db_name)) {
			$db_name = 'slave1';
		}
		$key = 'com_class_db_api_' . $db_name;
		$class_db_api = Register::get($key);
		if (!$class_db_api) {
//			var_dump($db_name,1);
			$class_db_api = new \Com\ClassDbApi($db_name);
			Register::set($key, $class_db_api);
		}
		return $class_db_api;
	}

	//获取model
	static function getModel($name)
	{
		$key = 'app_model_' . $name;
		$model = Register::get($key);
		if (!$model) {
			$class = '\\App\\Model\\' . ucwords($name);
			$model = new $class;
			Register::set($key, $model);
		}
		return $model;
	}

	//获取model
	static function getResponse()
	{
		$key = 'com_response';
		$response = Register::get($key);
		if (!$response) {
			$response = new \Com\Response();
			Register::set($key, $response);
		}
		return $response;
	}

	//获取model
	static function getBaseModel()
	{
		$key = 'com_base_model';
		$base_model = Register::get($key);
		if (!$base_model) {
			$base_model = new \App\Model\BaseModel();
			Register::set($key, $base_model);
		}
		return $base_model;
	}

	//获取控制器 对象
	static function getController($controllerClass)
	{
		$key = 'controller_name' . $controllerClass;
		$controller_name = Register::get($key);
		if (!$controller_name) {
			$class = '\\App\\Controller\\' . ucwords($controllerClass);
			$controller_name = new $class;
			Register::set($key, $controller_name);
		}
		return $controller_name;
	}
	//创建 获取token 对象
	static function getJwt(){
		$key = 'controller_auth';
		$controller_auth = Register::get($key);
		if (!$controller_auth) {
			$controller_auth = new \App\Controller\Auth\Auth();
			Register::set($key, $controller_auth);
		}
		return $controller_auth;
	}
	static function getMiddelWare($mideleware_name){
		$key = 'middelware'.$mideleware_name;
		$mideleware = Register::get($key);
		if (!$mideleware) {
			$class = '\\App\\Middleware\\' . ucwords($mideleware_name);
			$mideleware = new $class;
			Register::set($key, $mideleware);
		}
		return $mideleware;
	}
	//创建路由类
	static function getRouter($type,$dataform){
		$key = 'router_'.$type;
		$router = Register::get($key);
		if (!$router) {
			$router = new Router($type,$dataform);
			Register::set($key, $router);
		}
		return $router;
	}
}

?>