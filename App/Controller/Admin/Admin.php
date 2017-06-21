<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/6
 * Time: 12:30
 */

namespace App\Controller\Admin;


use App\Controller\BaseController;
use Com\Factory;

class Admin extends BaseController
{
	public function login($formdata)
	{
		//验证数据的有效性
		$validate_role = array(
			"ad_uname" => array(
				'required' => true
			),
			"ad_pwd" => array(
				'required' => true
			),
		);
		$Validate = Factory::getValidate();
		$rt = $Validate->verify($formdata, $validate_role);
		if ($rt['result'] === true) {
			$formdata = $rt['data'];
			//检测用户名是否存在
			$check_arr = array('host' => 'slave1', 'tb_name' => 't_admin', 'cond_col' => array('ad_uname=' => $formdata['ad_uname']));
			$ad_uname_is_exist = Factory::getModel('AdminModel')->ad_uname_is_exist($check_arr);
			if ($ad_uname_is_exist) {
				$modelRes = Factory::getModel('AdminModel')->login($formdata);
				$code = parent::getErrorCode('CODE_DEAL_OK');
				$msg = parent::getErrorCode('CODE_DEAL_OK');
			} else {
				throw Factory::getCoreException('CODE_USER_NOT_EXIST');
			}

		}else {
			$code = parent::getErrorCode('CODE_DEAL_FAIL');
			$msg = $rt['message'];
			$modelRes = array();
		}
		return Factory::getResponse()->show($code, $msg, $modelRes);
	}

	public function addAdmin($formdata)
	{
		$validate_role = array(
			"ad_uname" => array("required" => true),
			"ad_pwd" => array("required" => true),
			"ad_nick" => array("required" => true),
		);

		$Validate = Factory::getValidate();
		$rt = $Validate->verify($formdata, $validate_role);
		if ($rt['result'] === true) {
			$formdata = $rt['data'];
			//检测用户名是否存在
			$check_arr = array('host' => 'slave1', 'tb_name' => 't_admin', 'cond_col' => array('ad_uname=' => $formdata['ad_uname']));
			$ad_uname_is_exist = Factory::getModel('AdminModel')->ad_uname_is_exist($check_arr);
			if (!$ad_uname_is_exist) {
				$modelRes = Factory::getModel('AdminModel')->addAdmin($formdata);
				$code = parent::getErrorCode('CODE_DEAL_OK');
				$msg = parent::getErrorCode('CODE_DEAL_OK');
			} else {
				throw Factory::getCoreException('DATA_REPEAT');
			}
		}else {
			$code = parent::getErrorCode('CODE_DEAL_FAIL');
			$msg = $rt['message'];
			$modelRes = array();
		}
		return Factory::getResponse()->show($code, $msg, $modelRes);
	}

	public function updateToken()
	{
		$modelRes = Factory::getJwt()->createToken();
		$code = parent::getErrorCode('CODE_DEAL_OK');
		$msg = parent::getErrorCode('CODE_DEAL_OK');
		return Factory::getResponse()->show($code, $msg, $modelRes);
	}

	//退出登录
	public function signUp()
	{
		unset($_SESSION['PLAT_CENTER']);
		session_destroy();
	}

}

?>