<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/6
 * Time: 15:16
 */

namespace App\Controller\Auth;

use Com\JWT;

class Auth
{
	//解密的秘匙，不会传到前端保证安全
	private $key = "apikey";
	private $token = array("iss" => '', "iat" => '', "nbf" => '', "exp" => '',);

	//创建一个token 登录时用
	public function createToken($data_arr)
	{
		//用户登录成功 进行创建token
		//使用一个生成的随机数作为每个key的唯一表示
		$this->token['iss'] =generate_decode(10);
		//token 的创建时间
		$this->token['iat'] = time();
		//设置token的时效为2小时
		$this->token['exp'] = time()+(60*60*2);

		$jwt = JWT::encode($this->token, $this->key);
		$data ['token'] = $jwt;
		//expired_at 过期时间
		$data ['expired_at'] = date("Y-m-d h:i:s", $this->token['exp']);
		//refresh_expired_at 刷新过期时间
		$data ['refresh_expired_at'] = date("Y-m-d h:i:s", $this->token['exp'] - (60*60));
		return $data;
	}

	//删除一个token 退出登录的时候
	public function deleteToken()
	{

	}

	//更新token    当token快过期 用户登录了 才具有该权限
	public function refreshToken()
	{
		//再次修改token 的过期时间
		$this->token['exp'] = time()+(60*60*2);
		$jwt = JWT::encode($this->token, $this->key);
		return $jwt;
	}
	//解析toke 相当于解析器
	public function dealToken($jwt){
		//解密
		$decoded = JWT::decode($jwt, $this->key, array('HS256'));
		//$decoded 能正常解析就说明token 有效（失效性里面已经过期了），同时也可以 验证里面的其它信息
		$data = (array)$decoded;
		if(empty((array)$decoded)){
			\Com\CoreLogger::getInstance()->writeLog(__METHOD__ . ":" . __LINE__, Factory::getCoreException('CODE_BAD_SIGN')->getErrorDes('CODE_BAD_SIGN'), \Com\CoreLogger::LOG_LEVL_ERROR);
			//抛出异常，告知用户同时写入日志
			throw Factory::getCoreException('CODE_BAD_SIGN');
		}
		return !empty((array)$decoded);
	}
}