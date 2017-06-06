<?php
namespace App\Controller\Index;

use App\Controller\BaseController;

use App\Model\BaseModel;
use Com\Factory;

class Index extends BaseController
{

	public function test($formdata){

		//调用数据验证
		$data = json_decode($formdata,true);
		//数据 要求
		$validate_role = array(
				'cur_page' => array(
						'number' => true,
				)
		);
		$rt = Factory::getValidate()->verify($data, $validate_role);
		if ($rt === true){
			//调用数据层
			$modelRes = Factory::getModel('IndexModel')->indexData($data['cur_page']);
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