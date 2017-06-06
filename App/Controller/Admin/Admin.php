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
	public function login($formdata){
		//验证数据的有效性
		$data =json_decode($formdata,true);
		$validate_role =array(
			"ad_uname"=>array(
				'required'=>true
			),
			"ad_pwd"=>array(
				'required'=>true
			),
		);

		$rt =Factory::getValidate($data,$validate_role);

		if($rt){
			//检测用户名是否存在
			$check_arr =  array('host'=>'slave1', 'tb_name' => 't_admin', 'cond_col' => array('ad_uname=' => $data['ad_uname']));
			$ad_uname_is_exist = Factory::getModel('AdminModel')->ad_uname_is_exist($check_arr);
			if($ad_uname_is_exist){
				$modelRes = Factory::getModel('AdminModel')->login($data);
				$code = parent::getErrorCode('CODE_DEAL_OK');
				$msg = parent::getErrorCode('CODE_DEAL_OK');
				return Factory::getResponse()->show($code, $msg, $modelRes);
			}else{
				throw Factory::getCoreException('CODE_USER_NOT_EXIST');
			}

		}


	}

}
?>