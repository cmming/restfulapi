<?php
namespace Com;
/**
 * A class for get or update user's information
 *
 */
use Com\Factory;
class MysqlDb
{
    //user's main info
    var $dbhost = '';
    var $dbuser = '';
    var $dbpwd = '';
    var $dbname = '';

    //check whether the mysql server can connect
    public function mysql_connect_try($host_ip, $db_user, $db_pwd)
    {
        if ($link = @mysql_connect($host_ip, $db_user, $db_pwd, true))
            return $link;
        else
            return false;
    }

    //check whether the mysql server db exsit
    public function check_mysql_db_exsit($db_name, $link = NULL)
    {
        return ($link ? mysql_select_db($db_name, $link) : mysql_select_db($db_name));
    }

    //connect a mysql server and select a db
    public function mysql_db_connect($host_ip, $db_user, $db_pwd, $db_name)
    {
        if ($link = $this->mysql_connect_try($host_ip, $db_user, $db_pwd)) {
			//add by bull 
			$this->dbhost = $host_ip;
			$this->dbuser = $db_user;
			$this->dbpwd = $db_pwd;
			$this->dbname = $db_name;
            if ($this->check_mysql_db_exsit($db_name, $link))
                return $link;
            else
                return false;
        } else
            return false;
    }

    //get the resource result of mysql_query operation
    private function mysql_query_res($sql, $link = NULL)
    {
        $res = $link ? mysql_query($sql, $link) : mysql_query($sql);

		//add by bull 
		if(!$res)
		{
            $Core_Logger =Factory::getCoreLogger();
            $Core_Logger->writeLog($this->dbhost.":".$this->dbname." :".$this->dbuser."DB_Oper","[err=".mysql_errno().'-'.mysql_error()."]sql=".$sql,$Core_Logger::LOG_LEVL_DBDATA);
		}else{
            //正确的操作日志
            $Core_Logger =Factory::getCoreLogger();
            $Core_Logger->writeLog($this->dbhost.":".$this->dbname.":".$this->dbuser."DB_Oper","[err=0-]sql=".$sql,$Core_Logger::LOG_LEVL_DBDATA);
		}
        return $res;
    }

    //create database if not exist ,else return fasle;
    public function creat_mysql_db($db_name, $link)
    {
        $result = false;
        if (!$this->check_mysql_db_exsit($db_name, $link)) {
            $sql = 'create database ' . $db_name;
            if ($this->mysql_operate_check($sql, $link))
                $result = true;
        }
        return $result;
    }

    //check whether a table has exsit in one used db
    public function check_mysql_tb_exsit($db_name = NULL, $tb_name, $link = NULL)
    {
        $result = false;
        if (is_string($tb_name)) {
            $db_name_str = is_string($db_name) && $db_name ? 'from ' . $db_name : '';
            $sql = 'show tables ' . $db_name_str . ' like ' . $this->sql_value_escape($tb_name);
            if ($this->get_one_res($this->mysql_query_res($sql)))
                $result = true;
        }
        return $result;
    }

    //check mysql_query operation
    public function mysql_operate_check($sql, $link = NULL)
    {
        if ($this->mysql_query_res($sql, $link))
            return true;
        else {
            return false;
        }
    }

    //create a table by use a sql sting
    public function create_mysql_tb($sql, $link = NULL)
    {
        $result = false;
        if ($sql) {
            $safe_sql = mysql_escape_string($sql);
            if ($this->mysql_operate_check($safe_sql, $link))
                $result = true;
        }
        return $result;
    }

    //select result from table
    private function mysql_select_record($sql, $link = NULL)
    {
        $result = false;
        if ($sql) {
            if ($res = $this->mysql_query_res($sql, $link))
                $result = $res;
        }
        return $result;
    }

    //return the different type of result from select resource
    private function mysql_resource_output($res, $type = NULL)
    {
        $result = false;
        if (is_resource($res)) {
            $type = is_string($type) && $type ? $type : 'Num';
            if ($type == 'Bool') {
                $res_arr = mysql_fetch_row($res);
                if (!empty($res_arr))
                    $result = true;
            } else if ($type == 'Num') {
                $num = mysql_fetch_row($res);
                $result = $num ? $num[0] : false;
            } else if ($type == 'Array') {
                $result = array();
                while ($row = mysql_fetch_assoc($res)) {
                    $result[] = $row;
                }
            } else if ($type == 'Value') {
                $result = $this->get_one_res($res);
            } else if ($type == 'Single') {
                $result = mysql_fetch_assoc($res);
            }
        }
        return $result;
    }

    public function mysql_select_query($query_arr = array(), $output = NULL, $link = NULL)
    {
        $result = false;
        $default_arg = array(
            'tb_name' => '',
            'result_col' => array(),
            'cond_col' => array(),
            'extra_str' => '');
        $arg_arr = $this->arg_ini($default_arg, $query_arr);
        if ($arg_arr['tb_name'] && is_array($arg_arr['cond_col']) && is_array($arg_arr['result_col'])) {
            $output = $output ? $output : 'Bool';
            //初始化字符串
            $cond_str = '';
            $result_col_str = '*';
            $extra_str = $arg_arr['extra_str'];
            //判读是否有结果集数列约束
            if (!empty($arg_arr['result_col']))
                $result_col_str = join(',', $arg_arr['result_col']);
            //判读是否有查询条件约束
            if (!empty($arg_arr['cond_col'])) {
                $cond_str = ' where ';
                $i = 0;
                foreach ($arg_arr['cond_col'] as $cond_key => $cond_col_item) {
                    if ($cond_key == "special") {
                        $cond_str .= '1=1 ' . $cond_col_item;
                    } else {
                        $cond_str .= $cond_key . $this->sql_value_escape($cond_col_item);
                        if ($i != count($arg_arr['cond_col']) - 1)
                            $cond_str .= ' and ';
                    }
                    $i++;
                }
            }
            //根据输出结果重新约束查询结果
            if ($output == 'Num') {
                $result_col_str = 'count(*)';
                $sql = 'select ' . $result_col_str . ' from ' . $arg_arr['tb_name'] . ' ' . $cond_str . ' ' . $extra_str;
                $result = is_resource($res = $this->mysql_select_record($sql, $link)) ? $this->mysql_resource_output($res, $output) : '';
            } else if ($output == 'Sql') {
                $result = 'select ' . $result_col_str . ' from ' . $arg_arr['tb_name'] . ' ' . $cond_str . ' ' . $extra_str;
            } else {
                $sql = 'select ' . $result_col_str . ' from ' . $arg_arr['tb_name'] . ' ' . $cond_str . ' ' . $extra_str;
                $res = $this->mysql_select_record($sql, $link);
                if ($res) {
                    $result = $this->mysql_resource_output($res, $output);
                }
            }
//             var_dump($sql);exit();
        }
        return $result;
    }

    //do a insert query
    public function mysql_insert_query($query_arr = array(), $link = NULL, $outsql = false)
    {
        $result = false;
        $default_arg = array(
            'tb_name' => '',
            'record_arr' => array());
        $arg_arr = $this->arg_ini($default_arg, $query_arr);
        if ($arg_arr['tb_name'] && is_array($arg_arr['record_arr'])) {
            $c_sql = 'insert into ' . $arg_arr['tb_name'] . ' (';
            $val_str = '';
            $i = 0;
            foreach ($arg_arr['record_arr'] as $key => $data_item) {
                $c_sql .= $key;
                $val_str .= $this->sql_value_escape($data_item);
                if ($i != (count($arg_arr['record_arr']) - 1)) {
                    $c_sql .= ',';
                    $val_str .= ',';
                }
                $i++;
            }
            $c_sql .= ') value (' . $val_str . ')';
            $result = $outsql ? $c_sql : $this->mysql_operate_check($c_sql, $link);
        }
        return $result;
    }

    //do a insert query
    public function mysql_insert_query_backid($query_arr = array(), $link = NULL)
    {
        $result = false;
        if ($this->mysql_insert_query($query_arr, $link))
            $result = mysql_insert_id();
        return $result;
    }

    //do a update query
    public function mysql_update_query($query_arr = array(), $link = NULL, $outsql = false)
    {
        $result = false;
        $default_arg = array(
            'tb_name' => '',
            'record_arr' => array(),
            'cond_col' => array());
        $arg_arr = $this->arg_ini($default_arg, $query_arr);
        if ($arg_arr['tb_name'] && is_array($arg_arr['record_arr']) && is_array($arg_arr['cond_col'])) {
            $c_sql = 'update ' . $arg_arr['tb_name'] . ' set ';
            $i = 0;
            foreach ($arg_arr['record_arr'] as $key => $data_item) {
                $c_sql .= $data_item !== NULL ? $key . '=' . $this->sql_value_escape($data_item) : $key;
                if ($i != (count($arg_arr['record_arr']) - 1))
                    $c_sql .= ',';
                $i++;
            }
            $cond_str = '';
            //判读是否有查询条件约束
            if (!empty($arg_arr['cond_col'])) {
                $cond_str = ' where ';
                $i = 0;
                foreach ($arg_arr['cond_col'] as $cond_key => $cond_col_item) {
                    $cond_str .= $cond_key . $this->sql_value_escape($cond_col_item);
                    if ($i != count($arg_arr['cond_col']) - 1)
                        $cond_str .= ' and ';
                    $i++;
                }
            }
            $c_sql .= $cond_str;
            $result = $outsql ? $c_sql : $this->mysql_operate_check($c_sql, $link);
        }
        return $result;
    }

    //do a delete query
    public function mysql_delete_query($query_arr = array(), $link = NULL)
    {
        $result = false;
        $default_arg = array(
            'tb_name' => '',
            'cond_col' => array());
        $arg_arr = $this->arg_ini($default_arg, $query_arr);
        if ($arg_arr['tb_name'] && is_array($arg_arr['cond_col'])) {
            $c_sql = 'delete from ' . $arg_arr['tb_name'];
            $cond_str = '';
            //判读是否有查询条件约束
            if (!empty($arg_arr['cond_col'])) {
                $cond_str = ' where ';
                $i = 0;
                foreach ($arg_arr['cond_col'] as $cond_key => $cond_col_item) {
                    $cond_str .= $cond_key . $this->sql_value_escape($cond_col_item);
                    if ($i != count($arg_arr['cond_col']) - 1)
                        $cond_str .= ' and ';
                    $i++;
                }
            }
            $c_sql .= $cond_str;
            $result = $this->mysql_operate_check($c_sql, $link);
        }
        return $result;
    }
    //create database table if not exist ,if the arguments $force is true ,while drop the same name db then
    //create a new one;
    private function drop_mysql_tb($link, $db_name)
    {
        if (check_mysql_db_exsit($link, $db_name)) {
            $sql = '';
        }
        mysql_select_db($db_name, $link);
    }

    //get the value of
    private function get_one_res($resource)
    {
        $result = false;
        if (is_resource($resource)) {
            if (mysql_num_rows($resource) == 1) {
                $arr = (mysql_num_fields($resource) == 1) ? mysql_fetch_row($resource) : mysql_fetch_assoc($resource);
                $result = (mysql_num_fields($resource) == 1) ? $arr[0] : $arr;
            }
        }
        return $result;
    }

    public function arg_ini($def_arg, $new_arg)
    {
        $arg_arr = array();
        foreach ($def_arg as $key => $item) {
            $arg_arr[$key] = array_key_exists($key, $new_arg) ? $new_arg[$key] : $item;
        }
        return $arg_arr;
    }

    private function sql_value_escape($string)
    {
        $result = '';
        if (is_string($string) || is_numeric($string)) {
            $result = is_numeric($string) ? $string : '"' . mysql_real_escape_string($string) . '"';
        }
        return $result;
    }

    public function sql_close_link($link)
    {
        if (is_resource($link)) {
            mysql_close($link);
            $ret = true;
        }
    }

    // affected nums
    public function get_the_num_of_res($resource)
    {
        $num = 0;
        if (is_resource($resource)) {
            $num = mysql_num_rows($resource);
        }
        return $num;
    }
}

//global $db_obj;
//$db_obj = new MysqlDb();
?>