<?php

$DatabaseConfig = array(
	/**
	 * 一种功能配置在 多个服务器上
	 * slave:功能  （写数据。。）
	 * slave1：该功能的一个服务器
	 */
	'slave' => array(
		'slave1' => array(
			'host' => 'bjwebdb',
			'user' => 'sdk_user',
			'password' => 'outstandingbull',
			'dbname' => 'db_plat_center',
		),
		'slave2' => array(
			'host' => 'localhost',
			'user' => 'root',
			'password' => '123456',
			'dbname' => 'db_plat_center',
		),
	),
);
return $DatabaseConfig;

?>