<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/6
 * Time: 17:48
 */

namespace App\middleware\Jwt;

use Com\Factory;

class Jwt
{
	public function checkToken(){
		//是否有签名
		if(!isset(apache_request_headers()['x-access-token'])){
			throw Factory::getCoreException('CODE_NO_SIGN');
		}else{
			//获取请求头部的 验证签名
			$token = apache_request_headers()['x-access-token'];
			//将token进行验证
			Factory::getController('Auth\Auth')->dealToken($token);
		}
	}

}
?>