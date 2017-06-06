<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/6
 * Time: 14:08
 */

namespace App\Model;

use Com\Factory;
use Com\JWT;

class AdminModel
{
	//判断用户名是否存在
	public function ad_uname_is_exist($check_arr){
		$db = Factory::getClassDbApi('slave1');
		$dbRes = $db->check_one_exist($check_arr);
		return $dbRes;
	}
	//登录接口
	public function login($data_arr){
		//检测用户名的密码是否正确
		$db = Factory::getClassDbApi('slave1');
		$ad_pwd_arr = $db->get_sdk_table_single('slave1','t_admin','ad_uname',$data_arr['ad_uname'],array('ad_pwd'));
		if(isset($ad_pwd_arr['ad_pwd'])){
			$ad_pwd = $ad_pwd_arr['ad_pwd'];
			if($data_arr['ad_pwd']!=$ad_pwd){
				//用户密码错误
				throw Factory::getCoreException('CODE_FAIL_PWD');
			}else{
				//创建一个token 并且 返回
				return Factory::getJwt()->createToken($data_arr);
			}
		}else{
			//数据库语句执行失败
			throw Factory::getCoreException('CODE_DB_EXCUTE_ERROR');
		}
	}
}
?>