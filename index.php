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
	//接受参数，并判断参数的合法性
	//$request_data = array();
	//$request_data = array('type'=>'index');
	//if(!CheckParm($_POST,$request_data))
	if(0)
	{
//		\Com\CoreLogger::getInstance()->writeLog(__METHOD__ . ":" . __LINE__, CoreException::getErrorDes(CoreException::CODE_BAD_PARAM), \Com\CoreLogger::LOG_LEVL_ERROR);
		\Com\CoreLogger::getInstance()->writeLog(__METHOD__ . ":" . __LINE__, Factory::getCoreException('CODE_BAD_PARAM')->getErrorDes('CODE_BAD_PARAM'), \Com\CoreLogger::LOG_LEVL_ERROR);
		//抛出异常，告知用户同时写入日志
		throw Factory::getCoreException('CODE_BAD_PARAM');
	}
	$type = Request('type');
	$dataform =Request('dataform',true);
//	$type = FrameworkRequest('type');
//	$dataform =FrameworkRequest('dataform',true);
	//验证通过了后，设置日志的文件名称
//	Factory::getCoreLogger($type);
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