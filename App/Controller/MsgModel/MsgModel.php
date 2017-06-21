<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/2
 * Time: 14:50
 */

namespace App\Controller\MsgModel;

use App\Controller\BaseController;
use Com\Factory;

class MsgModel extends BaseController
{
	public function getMsgModels($formdata)
	{
		//数据 要求
		$validate_role = array(
			'cur_page' => array(
				'number' => 1,
			)
		);
		$rt = Factory::getValidate()->verify($formdata, $validate_role);

		if ($rt['result'] === true) {
			$formdata = $rt['data'];
			//搜索的参数
			$con_arr = array();
			//分页的初始化参数
			$cp_arr = array('rec_num' => '10', 'cur_page' => $formdata['cur_page']);
			//排序的初始化
			$extra_arr = array('order' => '', 'order_by' => '');

			//调用数据层
			$modelRes = Factory::getModel('MsgModelModel')->getMsgModels(array(), $cp_arr);

			$code = parent::getErrorCode('CODE_DEAL_OK');
			$msg = parent::getErrorMsg('CODE_DEAL_OK');
		} else {
			$code = parent::getErrorCode('CODE_DEAL_FAIL');
			$msg = $rt['message'];
			$modelRes = array();
		}
		return Factory::getResponse()->show($code, $msg, $modelRes);
	}

	//跟新消息
	public function updateMsgModel($formdata)
	{
		//数据 要求
		$validate_role = array(
			'title' => array(
				'required' => true,
			),
			'upd_flag' => array(
				'required' => true,
				'number' => true
			),
			'update_id' => array(
				'number' => true
			)
		);
		$rt = Factory::getValidate()->verify($formdata, $validate_role);

		if ($rt['result'] === true) {
			$formdata = $rt['data'];

			//调用数据层
			$model = Factory::getModel('MsgModelModel');
			$modelRes = $model->updateMsgModel($formdata);

			$code = parent::getErrorCode('CODE_DEAL_OK');
			$msg = parent::getErrorMsg('CODE_DEAL_OK');
		} else {
			$code = parent::getErrorCode('CODE_DEAL_FAIL');
			$msg = $rt['message'];
			$modelRes = array();
		}
		return Factory::getResponse()->show($code, $msg, $modelRes);
	}

	public function deleteMsgModel($formdata)
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
		if ($rt['result'] === true) {
			$formdata = $rt['data'];
			//调用数据层
			$model = Factory::getModel('MsgModelModel');
			$modelRes = $model->deleteMsgModel($formdata['delete_id']);

			$code = parent::getErrorCode('CODE_DEAL_OK');
			$msg = parent::getErrorMsg('CODE_DEAL_OK');
		} else {
			$code = parent::getErrorCode('CODE_DEAL_FAIL');
			$msg = $rt['message'];
			$modelRes = array();
		}
		return Factory::getResponse()->show($code, $msg, $modelRes);
	}

}

?>