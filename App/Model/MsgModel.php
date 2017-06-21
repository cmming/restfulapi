<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/1
 * Time: 19:14
 */

namespace App\Model;

use Com\Factory;

class MsgModel
{
	public function getMsglist($con_arr = array(), $cp_arr, $extra_arr = array())
	{
		//调用数据库
		$db = Factory::getClassDbApi();
		$dbRes = $db->search_sdk_cp_table('slave1', 't_msg_list', 'id', array(), $con_arr, $cp_arr, $extra_arr);

		return $dbRes;
	}

	public function updateMsg($data_arr)
	{
		//调用数据库
		$db = Factory::getClassDbApi();
		$result = false;
		if ($db->set_db_link('slave1') && is_array($data_arr) && !empty($data_arr)) {
			$upd_flag = $data_arr['upd_flag'];
			//如果是更新 upd_flag =1
			if ($upd_flag) {
				$id = $data_arr['update_id'];
				$check_arr = array('host'=>'slave1','tb_name' => 't_msg_list', 'cond_col' => array('id=' => $id));
				$is_exist = $db->check_one_exist($check_arr);
				if ($is_exist) {
					unset($data_arr['update_id']);
					unset($data_arr['upd_flag']);
					$update_arg = array('tb_name' => 't_msg_list', 'record_arr' => $data_arr, 'cond_col' => array('id=' => $id));
					if ($db->mysql_update_query($update_arg, $db->get_link()))
						$result = true;
				} else {
					//数据不存在
					throw Factory::getCoreException('CODE_DATA_NO_EXIST');
				}
			} else {
				unset($data_arr['upd_flag']);
				$insert_arg = array('tb_name' => 't_msg_list', 'record_arr' => $data_arr);
				$result = $db->mysql_insert_query($insert_arg, $db->get_link());
			}
		}
		return $result;
	}

	public function deleteMsg($delete_id)
	{
		//调用数据库
		$db = Factory::getClassDbApi();
		$result = false;
		$check_arr = array('host'=>'slave1','tb_name' => 't_msg_list', 'cond_col' => array('id=' => $delete_id));
		$is_exist = $db->check_one_exist($check_arr);
		if($is_exist){
			if ($db->set_db_link('slave1')) {
				$query_arr = array('tb_name' => 't_msg_list', 'cond_col' => array('id=' => $delete_id));
				$result = $db->mysql_delete_query($query_arr, $db->get_link());
			}
		}else{
			throw Factory::getCoreException('CODE_DATA_NO_EXIST');
		}
		return $result;
	}
	//根据用户的id获取信息
	public function getMsgById($id){
		//调用数据库
		$db = Factory::getClassDbApi();
		$check_arr = array('host'=>'slave1','tb_name' => 't_msg_list', 'cond_col' => array('id=' => $id));
		$is_exist = $db->check_one_exist($check_arr);
		if($is_exist){
			$result = $db->get_sdk_table_single('slave1', 't_msg_list', 'id', $id);
		}else{
			throw Factory::getCoreException('CODE_UNABLE_DATA');
		}
		return $result;
	}

}

?>