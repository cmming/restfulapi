<?php

$DatabaseConfig = array(
	/**
	 *
	 * slave1：该功能的一个服务器
	 */
		'slave2' => array(
			'host' => 'bjwebdb',
			'user' => 'sdk_user',
			'password' => 'outstandingbull',
			'dbname' => 'db_plat_center',
		),
		'slave1' => array(
			'host' => '192.168.0.88',
			'user' => 'root',
			'password' => '123456',
			'dbname' => 'db_plat_center',
		),
		'slave3' => array(
				'host' => '192.168.0.88',
				'user' => 'root',
				'password' => '123456',
				'dbname' => 'db_vr_center',
		),
);
return $DatabaseConfig;

?>