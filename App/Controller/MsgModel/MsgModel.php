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
			$modelRes = Factory::getModel('MsgModelModel')->getMsgModels(array(), $cp_arr);

			$code = parent::getErrorCode('CODE_DEAL_OK');
			$msg = parent::getErrorMsg('CODE_DEAL_OK');
		}else{
			$code = parent::getErrorCode('CODE_DEAL_FAIL');
			$msg = $rt;
			$modelRes = array();
		}
		return Factory::getResponse()->show($code, $msg, $modelRes);
	}

	//跟新消息
	public function updateMsgModel($formdata)
	{
		//调用数据验证
		$data = json_decode($formdata, true);

		//数据 要求
		$validate_role = array(
			'recvid' => array(
				'required' => true,
			),
			'title' => array(
				'required' => true,
			)
		);
		$rt = Factory::getValidate()->verify($data, $validate_role);

		if ($rt === true) {

			//调用数据层
			$model = Factory::getModel('MsgModelModel');
			$modelRes = $model->updateMsgModel($data);

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