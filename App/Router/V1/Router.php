<?php
/**
 * 路由的逻辑类
 * 添加各种装饰器 处理各种路由的权限问题和一些要处理的 公共方法
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/19
 * Time: 14:25
 */

namespace App\Router\V1;
use Com\Factory;

class Router
{
	public function __construct($type, $dataform)
	{
		$router = new \Com\Router();
		//获取路由配置
		$array = Factory::getConfigAutoReload('\\Configs\\')['RouterConfig'];
		$isDefined = array_key_exists($type, $array);
		//判断是否定义
		if ($isDefined) {
			//是否需要登录的权限
			$isJwt = $array[$type]['isJwt'];
			$path = $array[$type]['path'];
			$ctr = $array[$type]['ctr'];

			//需要登录验证
			if($isJwt){
				//为路由对象添加过滤器
				$router->addHook('isLogin',Factory::getMiddelWare('Jwt\Jwt'));
			}
			//权限验证
			$router->addHook('checkUserRights',Factory::getMiddelWare('UserRights\UserRights',$type));
			// 创建路由
			$router->addRouter($path, $ctr, $dataform);
		}else{
			//错误的请求动作
			throw Factory::getCoreException('CODE_BAD_ACTION');
		}

	}

}
?>