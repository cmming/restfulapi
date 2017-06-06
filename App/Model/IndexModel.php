<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/31
 * Time: 10:07
 */

namespace App\Model;

use Com\Factory;

class IndexModel extends BaseModel
{
	public function indexData($page)
	{
		$db =Factory::getClassDbApi('slave1');
		$con_arr=array();
		//分页的初始化参数
		$cp_arr=array('max_pages'=>10,'rec_num'=>'10','cur_page'=>$page);
		//排序的初始化
		$extra_arr=array('order'=>'','order_by'=>'');

		$dbRes = $db->search_sdk_cp_table('slave1', 't_msg_list', 'id', array(), $con_arr,$cp_arr);

		return $dbRes;
	}
}

?>