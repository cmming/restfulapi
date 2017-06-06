<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/2
 * Time: 12:16
 */

$api_root_path = realpath(dirname(__FILE__)) . '/../';

$ConstConfig = array(
	//api 根目录
	'api_root_path'=>realpath(dirname(__FILE__)) . '/../',
	//日志相关的配置
	'log_path'=>array(
		'path_sys_log'=>$api_root_path."logs/sys_log/",
		'path_sys_data'=>$api_root_path."logs/Data_sys/",
	),
);

return $ConstConfig;
?>