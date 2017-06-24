<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/21
 * Time: 18:16
 * 程序初始化
 */

/**
 * 加载自动加载类
 */
require_once __DIR__.'/../Com/Loader.php';

include __DIR__.'/../Com/func.php';



(new \Com\Loader())->load();


use Com\CoreException;

use Com\Factory;
use Com\Register;

//spl_autoload_register('\\Com\\Loader::autoload');


/**
 * 创建一个容器类，将需要的服务注册进去
 */

/**
 * 注册服务
 */

//路由类 支持参数
Register::setShared('CoreLogger',function(){
	new \Com\CoreLogger();
});
//路由类 支持参数
Register::set('router',function($type = '',$dataform = ''){
	new \App\Router\V1\Router($type,$dataform);
});

//响应类
Register::set('response','\Com\Response');

//错误异常类
Register::set('core_exception',function($code = ''){
	new \Com\CoreException($code);
});

//验证类
Register::set('validate','\Com\Validate');

//数据库类
Register::setShared('class_db_api', function($db_name = 'slave1'){
	new \Com\ClassDbApi($db_name);
});

//获取 控制器
Register::set('getController',function($controllerClass){
	$class = '\\App\\Controller\\' . ucwords($controllerClass);
	new $class;
});

//获取一个Model
Register::set('getModel',function($modelName = ''){
	$class = '\\App\\Model\\' . ucwords($modelName);
	$model = new $class;
});

//获取一个Model
Register::set('configAutoReload',function($path = ''){
	$router = Com\ConfigAutoReload::getInstance($path);
});




/**
 * 启动路由
 */

try
{
	//测试时接受参数
	$type = Request('type');
	$dataform =Request('dataform',true);

	//上线时用的接收参数方法
//	$type = FrameworkRequest('type');
//	$dataform =FrameworkRequest('dataform',true);
	Factory::getCoreLogger($type)->writeLog(__METHOD__.":".__LINE__,"收到数据IP=[".getip_str()."] data=".json_encode($_REQUEST),\Com\CoreLogger::LOG_LEVL_DEBUG);

	//根据路由的配置文件进行自动跳转
	Register::get('router',array($type,$dataform));

}
//异常捕获
catch ( CoreException $e)
{
	$out_data['code'] = $e->getCode();
	$out_data['msg'] = $e->getMessage();
	\Com\CoreLogger::getInstance()->writeLog(__METHOD__.":".__LINE__,$out_data['msg'],\Com\CoreLogger::LOG_LEVL_WARNING);
	Factory::getResponse()->show($out_data['code'],$out_data['msg']);
}







?>