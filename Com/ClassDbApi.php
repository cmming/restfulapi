<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/31
 * Time: 16:23
 */

namespace Com;

use Com\Factory;

class ClassDbApi extends MysqlDb
{
	private $links = array('ope' => NULL);

	public function get_link()
	{
		return $this->links['ope'];
	}

//	//user's main info
//	function __construct($db_name = '')
//	{
//		$this->set_db_link($db_name);
//	}

//	//设置数据库链接
//	public function set_db_link($db_name = '')
//	{
//		var_dump(is_string($db_name) && $db_name);
//		if (is_string($db_name) && $db_name) {
//			if (!isset($this->links[$db_name]) || !is_resource($this->links[$db_name])) {
//				$res_link = NULL;
//				switch ($db_name) {
//					case DB_HOST_NAME:
//						$res_link = parent::mysql_db_connect(DB_HOST_IP, DB_HOST_ROOT, DB_HOST_PWD, DB_HOST_NAME);
//						break;
//				}
//				is_resource($res_link) && $this->links[$db_name] = $res_link;
//			}
////			if (!is_resource($this->links['ope'])) {
//			if (!is_resource($res_link)) {
//				Factory::getCoreLogger()->writeLog(__METHOD__ . ":" . __LINE__, "连接数据库失败", \Com\CoreLogger::LOG_LEVL_ERROR);
//				//抛出异常，告知用户同时写入日志
//				throw Factory::getCoreException('CODE_DB_CONNECT_ERROR');
//			}
//			//当前链接不为设定链接时赋值
//			isset($this->links[$db_name]) && $this->links['ope'] != $this->links[$db_name] && $this->links['ope'] = $this->links[$db_name];
//		}
//		return is_resource($this->links['ope']) ? true : false;
//	}
	function __construct($dbConfig = '')
	{
		$this->set_db_link($dbConfig);
	}
	//设置数据库链接
	/**
	 * @param string $con 数据库配置的key， 不同的key 会有不同的配置
	 * @return bool
	 * @throws CoreException
	 * @throws bool
	 */
	public function set_db_link($con)
	{
		$dbConfig = ConfigAutoReload::getInstance('\\Configs\\')['DatabaseConfig'][$con];
		if (is_array($dbConfig) && $dbConfig) {
			$res_link = parent::mysql_db_connect($dbConfig['host'], $dbConfig['user'], $dbConfig['password'], $dbConfig['dbname']);
			is_resource($res_link) && ($this->links[$dbConfig['host']] = $res_link);
			if (!is_resource($res_link)) {
				Factory::getCoreLogger()->writeLog(__METHOD__ . ":" . __LINE__, "连接数据库失败", \Com\CoreLogger::LOG_LEVL_ERROR);
				//抛出异常，告知用户同时写入日志
				throw Factory::getCoreException('CODE_DB_CONNECT_ERROR');
			}
			//当前链接不为设定链接时赋值  ???
			isset($this->links[$dbConfig['host']]) && $this->links['ope'] != $this->links[$dbConfig['host']] && ($this->links['ope'] = $this->links[$dbConfig['host']]);
		}
		return is_resource($this->links['ope']) ? true : false;
	}

	//更新sdk模块数据表（更新操作包含插入操作）
	//参数 $db_key 为数据库关键字           参数 $tb_name 为需要操作的表       参数 $prim_key 为表的主键
	//参数 $record_arr 为数据数组          参数 $back_id 为是否在插入记录时返回自增主键id
	//参数 $insert_only 为是否只允许插入操作（针对记录表等不可修改的数据表）
	public function update_sdk_table($db_key = '', $tb_name = '', $prim_key = '', $record_arr = array(), $back_id = false, $insert_only = false)
	{
		$result = false;
		if ($db_key && $tb_name && $prim_key && self::set_db_link($db_key) && is_array($record_arr) && !empty($record_arr)) {
			$check = false;
			if (!isset($record_arr[$prim_key]) || $insert_only)
				$check = false;
			else {
				$pri_key_id = intval($record_arr[$prim_key]);
				$cond_col = array($prim_key . '=' => $pri_key_id);
				$arg = array('tb_name' => $tb_name, 'cond_col' => $cond_col);
				$check = parent::mysql_select_query($arg, 'Bool', $this->links['ope']);
			}
			if ($check) {
				unset($record_arr[$prim_key]);
				$update_arg = array('tb_name' => $tb_name, 'record_arr' => $record_arr, 'cond_col' => $cond_col);
				if (parent::mysql_update_query($update_arg, $this->links['ope']))
					$result = true;
			} else {
				$insert_arg = array('tb_name' => $tb_name, 'record_arr' => $record_arr);
				$back_id = parent::mysql_insert_query_backid($insert_arg, $this->links['ope']);
				$result = $back_id ? $back_id : (boolean)$back_id;
			}
		}
		return $result;
	}
	//获取sdk模块数据表
	//参数 $db_key 为数据库关键字           参数 $tb_name 为需要操作的表       参数 $prim_key 为表的主键
	//参数 $result_col 为结果数组          参数 $cond_col 为条件控制数组		参数 $extra_str 为额外查询条件
	//参数 $out_put 为输出结果类型
	public function get_sdk_table($db_key = '', $tb_name = '', $result_col = array(), $cond_col = array(), $extra_str = '', $out_put = 'Array')
	{
		$result = false;
		if ($db_key && $tb_name && self::set_db_link($db_key) && is_string($extra_str)) {
			$query_arr = array('tb_name' => $tb_name, 'result_col' => $result_col, 'cond_col' => $cond_col, 'extra_str' => $extra_str);
			$result = parent::mysql_select_query($query_arr, $out_put, $this->links['ope']);
		}
		return $result;
	}
	//获取sdk模块数据表单条记录，仅接受主键为控制条件
	//参数 $db_key 为数据库关键字           参数 $tb_name 为需要操作的表       参数 $prim_key 为表的主键
	//参数 $result_col 为结果数组
	public function get_sdk_table_single($db_key = '', $tb_name = '', $pri_key = '', $pk_id = 0, $result_col = array())
	{
		$result = false;
		if ($db_key && $tb_name && $pri_key && $pk_id && self::set_db_link($db_key)) {
			$query_arr = array('tb_name' => $tb_name, 'cond_col' => array($pri_key . '=' => $pk_id));
			$result_col && $query_arr['result_col'] = $result_col;
			$result = parent::mysql_select_query($query_arr, 'Single', $this->links['ope']);
			//echo  parent::mysql_select_query($query_arr, 'Sql', $this->links['ope']);exit();
		}
		return $result;
	}
	//获取sp模块数据表搜索分页记录
	//参数 $db_key 为数据库关键字           参数 $tb_name 为需要操作的表       参数 $prim_key 为表的主键
	//参数 $result_col 为结果字段数组       参数 $search_arr 为搜索条件数组		参数 $cp_arr 为分页控制数组
	//参数 $extra_arr 为排序控制数组
	public function search_sdk_cp_table($db_key = '', $tb_name = '', $pri_key = '', $result_col = array(), $search_arr = array(), $cp_arr = array(), $extra_arr = array())
	{
		$result = array('cp_data' => array(), 'page_sum' => '', 'cur_page' => '');
//		$result = array('cp_data' => array(), 'cp_str' => '');
		//初始化参数
		if ($db_key && $tb_name && $pri_key && self::set_db_link($db_key) && is_array($search_arr) && is_array($cp_arr) && !empty($cp_arr) && is_array($extra_arr)) {
			$def_extra_arg = array(
				'order_by' => $pri_key,
				'order' => 'desc',
			);
			$extra_arg = parent::arg_ini($def_extra_arg, $extra_arr);
			$def_cp_arg = array(
//				'max_pages' => 10,
				'rec_num' => 10,
				'cur_page' => 0,
//				'control_word' => array('首页', '上一页', '下一页', '尾页')
			);
			$cp_arg = parent::arg_ini($def_cp_arg, $cp_arr);
			$def_arg = array('tb_name' => $tb_name);
			if (!empty($search_arr)) {
				$def_arg['cond_col'] = $search_arr;
			}
			$record_num = parent::mysql_select_query($def_arg, 'Num', $this->links['ope']);
			$page_sum = $record_num % $cp_arg['rec_num'] == 0 ? $record_num / $cp_arg['rec_num'] : floor($record_num / $cp_arg['rec_num']) + 1;
			$result['page_sum'] = $page_sum;
			$result['cur_page'] = $cp_arg['cur_page'];
			//目前输出是一些标签，可以直接生成
//			$result['cp_str'] = create_classpage_str($cp_arg['max_pages'], $page_sum, $cp_arg['cur_page'], 'cp', $cp_arg['control_word']);
			$lim_start = $cp_arg['rec_num'] * ($cp_arg['cur_page'] - 1);
			$extra_str = 'order by ' . $extra_arg['order_by'] . ' ' . $extra_arg['order'];
			$extra_str .= ' limit ' . $lim_start . ',' . $cp_arg['rec_num'];
			$cp_def_arg = array('tb_name' => $def_arg['tb_name'], 'cond_col' => $search_arr, 'extra_str' => $extra_str);
			$result_col && $cp_def_arg['result_col'] = $result_col;
			$result['cp_data'] = parent::mysql_select_query($cp_def_arg, 'Array', $this->links['ope']);
		}
		return $result;
	}

	//根据查询条件检查该项是否存在
	public function check_one_exist($check_arr = array())
	{
		if(!isset($check_arr['host'])){
			throw Factory::getCoreException('CODE_UNABLE_DATA');
			Factory::getCoreLogger()->writeLog(__METHOD__.":".__LINE__,"没有配置数据库",\Com\CoreLogger::LOG_LEVL_ERROR);
		}
		$result = false;
		if ($this->set_db_link($check_arr['host']) && $check_arr) {
			$arg = array('tb_name' => $check_arr['tb_name'], 'cond_col' => $check_arr['cond_col']);
			$result = parent::mysql_select_query($arg, 'Bool', $this->links['ope']);
		}
		return $result;
	}

}

?>