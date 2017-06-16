<?php
/**
 * 入口文件
 */

//设置市区为北京时间
date_default_timezone_set('PRC');

define('BASEDIR',__DIR__);
include BASEDIR.'/Com/Loader.php';
include BASEDIR.'/Com/func.php';
spl_autoload_register('\\Com\\Loader::autoload');

use Com\CoreException;

use Com\Factory;

//设置日志输出级别
//\Com\CoreLogger->setLogLevel(\Com\CoreLogger::LOG_LEVL_NO);		//无日志
\Com\CoreLogger::getInstance()->setLogFileName(basename(__FILE__));
\Com\CoreLogger::getInstance()->setLogLevel(\Com\CoreLogger::LOG_LEVL_DEBUG|\Com\CoreLogger::LOG_LEVL_ERROR|\Com\CoreLogger::LOG_LEVL_WARNING|\Com\CoreLogger::LOG_LEVL_DATA);

//接受参数的日志 打印所有的请求，包含 请求参数错误的
\Com\CoreLogger::getInstance()->writeLog(__METHOD__.":".__LINE__,"收到数据IP=[".getip_str()."] data=".json_encode($_REQUEST),\Com\CoreLogger::LOG_LEVL_DEBUG);

try
{
	//测试时接受参数
	$type = Request('type');
	$dataform =Request('dataform',true);
	//上线时用的接收参数方法
	//$type = FrameworkRequest('type');
	//$dataform =FrameworkRequest('dataform',true);
	Factory::getCoreLogger($type)->writeLog(__METHOD__.":".__LINE__,"收到数据IP=[".getip_str()."] data=".json_encode($_REQUEST),\Com\CoreLogger::LOG_LEVL_DEBUG);

	//根据路由的配置文件进行自动跳转
	Factory::getRouter($type,$dataform);

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