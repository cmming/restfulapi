<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/2
 * Time: 12:22
 */

namespace App\Controller\Contact;

use App\Controller\BaseController;
use Com\Factory;

class Contact extends BaseController
{
	public function checkContactName($formdata)
	{
		$data = json_decode($formdata, true);
		$validate_role = array(
			'name' => array(
				'user_account' => true,
			)
		);
		$rt = Factory::getValidate()->verify($data, $validate_role);

		if ($rt === true) {
			//搜索的参数
			$check_arr = array('host'=>'slave1', 'tb_name' => 't_contacts_list', 'cond_col' => array('name=' => $data['name']));

			//调用数据层
			$modelRes = Factory::getModel('ContactModel')->checkOneExist($check_arr);
			if($modelRes){
				$code = parent::getErrorCode('CODE_UNAME_EXISTS');
				$msg = parent::getErrorMsg('CODE_UNAME_EXISTS');
			}else{
				$code = parent::getErrorCode('CODE_DEAL_OK');
				$msg = parent::getErrorMsg('CODE_DEAL_OK');
			}
		}else{
			$code = parent::getErrorCode('CODE_DEAL_FAIL');
			$msg = $rt;
			$modelRes = array();
		}
		return Factory::getResponse()->show($code, $msg, $modelRes);
	}

	public function getContacts($formdata)
	{
		//调用数据验证
		$data = json_decode($formdata, true);
		//数据 要求
		$validate_role = array(
			'cur_page' => array(
				'number' => true,
			)
		);
		$rt = Factory::getValidate()->verify($data, $validate_role);

		if ($rt === true) {
			//搜索的参数
			$con_arr = array();
			//分页的初始化参数
			$cp_arr = array('rec_num' => '10', 'cur_page' => $data['cur_page']);
			//排序的初始化
			$extra_arr = array('order' => '', 'order_by' => '');

			//调用数据层
			$modelRes = Factory::getModel('ContactModel')->getContacts(array(), $cp_arr);

			$code = parent::getErrorCode('CODE_DEAL_OK');
			$msg = parent::getErrorMsg('CODE_DEAL_OK');
		}else{
			$code =parent::getErrorCode('CODE_DEAL_FAIL');
			$msg = $rt;
			$modelRes = array();
		}
		return Factory::getResponse()->show($code, $msg, $modelRes);
	}

	//跟新消息
	public function updateContact($formdata)
	{
		//调用数据验证
		$data = json_decode($formdata, true);

		//数据 要求
		$validate_role = array(
			'name' => array(
				'required' => true,
				'user_account' => true
			),
			'recvid' => array(
				'required' => true,
			)
		);
		$rt = Factory::getValidate()->verify($data, $validate_role);

		if ($rt === true) {
			//调用数据层
			$modelRes = Factory::getModel('ContactModel')->updateContact($data);

			$code = parent::getErrorCode('CODE_DEAL_OK');
			$msg = parent::getErrorMsg('CODE_DEAL_OK');
		}else{
			$code = parent::getErrorCode('CODE_DEAL_FAIL');
			$msg = $rt;
			$modelRes = array();
		}
		return Factory::getResponse()->show($code, $msg, $modelRes);
	}

}

?>