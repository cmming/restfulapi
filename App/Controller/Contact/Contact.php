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
		$validate_role = array(
			'name' => array(
				'user_account' => true,
			)
		);
		$rt = Factory::getValidate()->verify($formdata, $validate_role);

		if ($rt === true) {
			//搜索的参数
			$check_arr = array('host' => 'slave1', 'tb_name' => 't_contacts_list', 'cond_col' => array('name=' => $formdata['name']));

			//调用数据层
			$modelRes = Factory::getModel('ContactModel')->checkOneExist($check_arr);
			if ($modelRes) {
				$code = parent::getErrorCode('CODE_UNAME_EXISTS');
				$msg = parent::getErrorMsg('CODE_UNAME_EXISTS');
			} else {
				$code = parent::getErrorCode('CODE_DEAL_OK');
				$msg = parent::getErrorMsg('CODE_DEAL_OK');
			}
		} else {
			$code = parent::getErrorCode('CODE_DEAL_FAIL');
			$msg = $rt;
			$modelRes = array();
		}
		return Factory::getResponse()->show($code, $msg, $modelRes);
	}

	public function getContacts($formdata)
	{
		//数据 要求
		$validate_role = array(
			'cur_page' => array(
				'number' => true,
			)
		);
		$rt = Factory::getValidate()->verify($formdata, $validate_role);

		if ($rt === true) {
			//搜索的参数
			$con_arr = array();
			//分页的初始化参数
			$cp_arr = array('rec_num' => '10', 'cur_page' => $formdata['cur_page']);
			//排序的初始化
			$extra_arr = array('order' => '', 'order_by' => '');
			//调用数据层
			$modelRes = Factory::getModel('ContactModel')->getContacts(array(), $cp_arr);
			//数据解析
			foreach ($modelRes['cp_data'] as $key => $item) {
				foreach ($item as $kk => $vv) {
					if ($kk == 'recvid') {
						$modelRes['cp_data'][$key][$kk] = explode('|', $vv);
					}
				}
			}
			$code = parent::getErrorCode('CODE_DEAL_OK');
			$msg = parent::getErrorMsg('CODE_DEAL_OK');
		} else {
			$code = parent::getErrorCode('CODE_DEAL_FAIL');
			$msg = $rt;
			$modelRes = array();
		}
		return Factory::getResponse()->show($code, $msg, $modelRes);
	}

	//跟新消息
	public function updateContact($formdata)
	{
		//数据 要求
		$validate_role = array(
			'name' => array(
				'required' => true,
				'user_account' => true
			),
			'recvid' => array(
				'required' => true,
			),
			'upd_flag' => array(
				'required' => true,
				'number' => true
			)
		);
		$rt = Factory::getValidate()->verify($formdata, $validate_role);

		if ($rt === true) {
			//调用数据层
			$modelRes = Factory::getModel('ContactModel')->updateContact($formdata);

			$code = parent::getErrorCode('CODE_DEAL_OK');
			$msg = parent::getErrorMsg('CODE_DEAL_OK');
		} else {
			$code = parent::getErrorCode('CODE_DEAL_FAIL');
			$msg = $rt;
			$modelRes = array();
		}
		return Factory::getResponse()->show($code, $msg, $modelRes);
	}

	public function deleteContact($formdata)
	{

		//数据 要求  数字而且不能为空
		$validate_role = array(
			'delete_id' => array(
				'required' => true,
				'number' => true
			),
		);
		$Validate = Factory::getValidate();
		$rt = $Validate->verify($formdata, $validate_role);
		if ($rt === true) {
			//调用数据层
			$model = Factory::getModel('ContactModel');
			$modelRes = $model->deleteContact($formdata['delete_id']);

			$code = parent::getErrorCode('CODE_DEAL_OK');
			$msg = parent::getErrorMsg('CODE_DEAL_OK');
		} else {
			$code = parent::getErrorCode('CODE_DEAL_FAIL');
			$msg = $rt;
			$modelRes = array();
		}
		return Factory::getResponse()->show($code, $msg, $modelRes);
	}

}

?>