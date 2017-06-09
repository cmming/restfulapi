<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/31
 * Time: 14:42
 * help: http://blog.csdn.net/php_897721669/article/details/8965811
 */
//$data = array(
//		"username"=>'ningofaura@gmail.com',
//		"qq"=>'593084029',
//		"nickname"=>'张海宁',
//		"id"=>'24',
//);
//$validate_role = array(
//		'username'=>array(
//				'required'=>true,
//				'email'=>true,
//		),
//		'qq'=>array(
//				'required'=>true,
//				'qq'=>true,
//		),
//		'nickname'=>array(
//				'required'=>true,
//		),
//		'id'=>array(
//				'required'=>true,
//				'number'=>true,
//		),
//);
//
//$validate_err_msg = array(
//		'username'=>array(
//				'required'=>"用户名不能为空",
//				'email'=>"邮箱格式不正确",
//		),
//		'qq'=>array(
//				'required'=>"qq不能为空",
//				'qq'=>"qq格式不正确",
//		),
//		'nickname'=>array(
//				'required'=>"昵称不能为空",
//		),
//		'id'=>array(
//				'required'=>"id不能为空",
//				'number'=>"不是数字",
//		),
//);
//$Validate = new Validate();
//$rt = $Validate->verify($data, $validate_role, $validate_err_msg);
//if ($rt !== true){
//	echo $rt;
//	exit;
//}
//添加默认的错误消息 同时支持自定义错误信息
namespace Com;


class Validate
{
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
	 * @param  [array] $data                [用户要验证的数据]
	 * @param  [array] $validate_role       [验证规则]
	 * @param  [array] $validate_err_msg    [错误信息提示]
	 * @return [bool]                       [成功返回true, 失败返回错误信息]
	 */
	public function verify($data, $validate_role, $validate_err_msg = array())
	{
		if (empty($data)) return false;
		if (empty($validate_role)) return false;
		foreach ($data as $key => $value) {
			$key = strtolower($key);
			foreach ($validate_role as $kk => $vv) {
				$kk = strtolower($kk);
				if ($key == $kk) {
					foreach ($vv as $k => $v) {
						$k = strtolower($k);
						if (!in_array($k, $this->role_name)) return 'role name "' . $k . '" is not found!';
						if ($v == true) {
							if (!$this->$k($value)) {
								if (!isset($validate_err_msg[$kk][$k])){
									$resMsg = $this->err_msg_default[$k];
								}else{
									$resMsg = $validate_err_msg[$kk][$k];
								}
//									return 'var ' . $key . ' in ' . $k . ' of regular validation failure!';
								//不满足要求可以输出 warning 日志
								\Com\CoreLogger::getInstance()->writeLog(__METHOD__.":".__LINE__,$data[$key]."->".$resMsg,\Com\CoreLogger::LOG_LEVL_WARNING);
								return $resMsg;
							}
						}
					}
				}
			}
		}
		return true;
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
		if (preg_match("/^[0-9]+$/", $str)) return true;
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