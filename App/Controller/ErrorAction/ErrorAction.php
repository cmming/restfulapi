<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/2
 * Time: 15:04
 */

namespace App\Controller\ErrorAction;

use App\Controller\BaseController;
use Com\Factory;
class ErrorAction extends BaseController
{
	public function errorAction(){


		$code = parent::getErrorCode('CODE_BAD_ACTION');
		$msg = parent::getErrorMsg('CODE_BAD_ACTION');

		return Factory::getResponse()->show($code, $msg);
	}
}
?>