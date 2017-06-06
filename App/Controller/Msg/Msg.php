<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/1
 * Time: 19:13
 */

namespace App\Controller\Msg;

use App\Controller\BaseController;
use Com\Factory;

class Msg extends BaseController
{
	public function getMsg($formdata)
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
			$cp_arr = array('cur_page' => $data['cur_page']);
			//排序的初始化
			$extra_arr = array('order' => '', 'order_by' => '');

			//调用数据层
			$model = Factory::getModel('MsgModel');
			$modelRes = $model->getMsglist(array(), $cp_arr);

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
	public function updateMsg($formdata){
		//调用数据验证
		$data = json_decode($formdata, true);

		//数据 要求
		$validate_role = array(
				'recvid' => array(
						'required' => true,
				),
				'title' => array(
						'required' =>true,
				)
		);
		$Validate = Factory::getValidate();
		$rt = $Validate->verify($data, $validate_role);
		if ($rt === true) {
			//调用数据层
			$model = Factory::getModel('MsgModel');
			$modelRes = $model->updateMsg($data);

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