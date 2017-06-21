<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/31
 * Time: 14:42
 * help: http://blog.csdn.net/php_897721669/article/details/8965811
 */

//添加默认的错误消息 同时支持自定义错误信息
namespace Com;


class Validate
{
	private $no_data = '验证数据为空';
	private $no_data_role = '验证规则缺失';
	// 验证规则
	private $role_name = array(
		// 验证是否为空
		'required',

		// 匹配邮箱
		'email',

		// 匹配身份证
		'idcode',

		// 匹配数字
		'number',

		// 匹配http地址
		'http',

		// 匹配qq号
		'qq',

		//匹配中国邮政编码
		'postcode',

		//匹配ip地址
		'ip',

		//匹配电话格式
		'telephone',

		// 匹配手机格式
		'mobile',

		//匹配26个英文字母
		'en_word',

		// 匹配只有中文
		'cn_word',

		// 验证账户(字母开头，由字母数字下划线组成，4-20字节)
		'user_account',
		'max_length',
	);
	protected $err_msg_default = array('required' => '不能为空',
		'email' => '邮箱格式不正确',
		'idcode' => '身份证信息不正确',
		'number' => '必须为数字',
		'http' => '网址不正确',
		'telephone' => '电话格式不正确',
		'mobile' => '手机格式不正确',
		'en_word' => '只能是英文',
		'cn_word' => '只能是中文',
		'user_account' => '验证账户(字母开头，由字母数字下划线组成，4-20字节)',
	);

	/**
	 * [验证函数]
	 * @param $data       				[用户要验证的数据]
	 * @param $validate_role			[验证规则]
	 * @param array $validate_err_msg	[错误信息提示]
	 * @return array					['result'=>bool,'message'=>错误信息,'data'=>修改后的数据]
	 * @throws Core_Exception			抛出的错误
	 */

	public function verify($data, $validate_role, $validate_err_msg = array())
	{
		//返回值
		$resArr = array();
		//遍历每一个验证角色
		foreach ($validate_role as $kk => $vv) {
			//将所有待验证的字符转换为小写
			$kk = strtolower($kk);
			//如果待验证数据的关键字 等于 验证角色的关键字
			//遍历该验证角色
			foreach ($vv as $k => $v) {
				//将所有的关键字进行 转换为小写 $key 表示要验证的函数名
				$k = strtolower($k);
				//判断验证所支持的关键字是否存在于已经定义的字段中 ;内部错误
				if (!in_array($k, $this->role_name)) return 'role name "' . $k . '" is not found!';
				//如果该验证种类的值为true  (后面支持，该字段可以设置默认值的种类)
				//if ($v == true) {
				$value = isset($data[$kk]) ? $data[$kk] : '';
				//分别带入各个函数进行验证
				if (!$this->$k($value)) {
					if (!isset($validate_err_msg[$kk][$k])) {
						$resMsg = $kk . $this->err_msg_default[$k];
					} else {
						$resMsg = $kk . $validate_err_msg[$kk][$k];
					}
					$resArr['result'] = false;
					$resArr['message'] = $resMsg;
//									return 'var ' . $key . ' in ' . $k . ' of regular validation failure!';
					//不满足要求可以输出 warning 日志
					\Com\CoreLogger::getInstance()->writeLog(__METHOD__ . ":" . __LINE__, $value . "->" . $resMsg, \Com\CoreLogger::LOG_LEVL_WARNING);
					return $resArr;
				} else {
					$resArr['result'] = true;
					$resArr['message'] = 'ok';
				}
				//为data 设置默认值
				if ((!isset($data[$kk])||$data[$kk]=='')&&$v !== true) {
					$data[$kk] = $this->set_data_default($v);
				}
			}
		}
		$resArr['data'] = $data;
		return $resArr;
	}
	//为data 设置默认值
	public function set_data_default($v){
		if($v == 'number'){
			return '0';
		}else{
			return $v;
		}
	}

	// 获取规则数组
	public function get_role_name()
	{
		return $this->role_name;
	}

	// 设置属性规则
	public function set_role_name($arr)
	{
		$this->role_name = array_merge($this->role_name, $arr);
	}

	// 验证是否为空
	public function required($str)
	{
		if (trim($str) != "") return true;
		return false;
	}

	// 验证邮件格式
	public function email($str)
	{
		if (preg_match("/^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/", $str)) return true;
		else return false;
	}

	// 验证身份证
	public function idcode($str)
	{
		if (preg_match("/^\d{14}(\d{1}|\d{4}|(\d{3}[xX]))$/", $str)) return true;
		else return false;
	}

	// 验证http地址
	public function http($str)
	{
		if (preg_match("/[a-zA-Z]+:\/\/[^\s]*/", $str)) return true;
		else return false;
	}

	//匹配QQ号(QQ号从10000开始)
	public function qq($str)
	{
		if (preg_match("/^[1-9][0-9]{4,}$/", $str)) return true;
		else return false;
	}

	//匹配中国邮政编码
	public function postcode($str)
	{
		if (preg_match("/^[1-9]\d{5}$/", $str)) return true;
		else return false;
	}

	//匹配ip地址
	public function ip($str)
	{
		if (preg_match("/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/", $str)) return true;
		else return false;
	}

	// 匹配电话格式
	public function telephone($str)
	{
		if (preg_match("/^\d{3}-\d{8}$|^\d{4}-\d{7}$/", $str)) return true;
		else return false;
	}

	// 匹配手机格式
	public function mobile($str)
	{
		if (preg_match("/^(13[0-9]|15[0-9]|18[0-9])\d{8}$/", $str)) return true;
		else return false;
	}

	// 匹配26个英文字母
	public function en_word($str)
	{
		if (preg_match("/^[A-Za-z]+$/", $str)) return true;
		else return false;
	}

	// 匹配只有中文
	public function cn_word($str)
	{
		if (preg_match("/^[\x80-\xff]+$/", $str)) return true;
		else return false;
	}

	// 验证账户(字母开头，由字母数字下划线组成，4-20字节)
	public function user_account($str)
	{
		if (preg_match("/^[a-zA-Z][a-zA-Z0-9_]{3,19}$/", $str)) return true;
		else return false;
	}

	// 验证数字
	public function number($str)
	{
		//if (preg_match("/^[0-9]+$/", $str)) return true;
		if (preg_match("/^(0|[1-9][0-9]*)?$/", $str)) return true;
		else return false;
	}

	// 验证长度
	public function max_length($str)
	{
		$strArr = explode('|', $str);
		if (isset($strArr[0]{$strArr[1]})) return true;
		else return false;
	}

}

?>