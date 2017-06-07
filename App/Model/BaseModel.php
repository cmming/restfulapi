<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/1
 * Time: 15:57
 */

namespace App\Model;

use Com\Factory;

class BaseModel
{
	//获取错误码
	public function getErrorCode($code){
		return Factory::getCoreException($code)->getErrorCode($code);
	}
	//获取错误信息
	public function getErrorMsg($code){
		return Factory::getCoreException($code)->getErrorDes($code);
	}
	/**
	 * 检测一个数据是否存在
	 * $check_arr = array('databaseKey'=>'slave1', 'tb_name' => 't_contacts_list', 'cond_col' => array('name=' => $data_arr['name']));
	 * if(!$this->checkOneExist($check_arr))
	 * @param $check_arr
	 * @return array|bool|string
	 */
	public function checkOneExist($check_arr)
	{
		//分离数据
		if(isset($check_arr['databaseKey'])){
			$db_key =  $check_arr['databaseKey'];
			unset($check_arr['databaseKey']);
		}else{
			throw Factory::getCoreException('CODE_BAD_PARAM');
			Factory::getCoreLogger()->writeLog(__METHOD__.":".__LINE__,"没有配置数据库",\Com\CoreLogger::LOG_LEVL_ERROR);
		}
		//调用数据库
		$db = Factory::getClassDbApi($db_key);
		$dbRes = $db->check_one_exist($check_arr);
		return $dbRes;
	}
}

?>