<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/22
 * Time: 14:33
 * 检测用户接口权限
 */

namespace App\Middleware\UserRights;

use Com\Factory;


class UserRights
{
	private $type = '';

	public function __construct($type)
	{
		$this->type = $type;
	}

	public function CheckUserRights($type)
	{
		//获取该用户的权限配置文件
		$userRights = Factory::getConfigAutoReload('\\Resource\\AdminInfo\\')['1'];
		if (!in_array($type, $userRights)) {
			//用户没有权限
			throw Factory::getCoreException('CODE_NO_POWER');
		}
	}

	public function before()
	{
		$type = $this->type;
		$this->CheckUserRights($type);
	}

}

?>