<?php
//异常处理类
namespace Com;

use Exception;

class CoreException extends Exception
{


	private $CODE_DEAL_FAIL = '100';
	private $CODE_DEAL_OK = '200';
	private $CODE_FORBIDDEN = '403';

	private $CODE_BAD_PARAM = '3001';
	private $CODE_BAD_ACTION = '3002';
	private $CODE_BAD_SIGN = '3003';
	private $CODE_NO_DATA = '3004';
	private $CODE_UNABLE_DATA = '3005';
	private $CODE_EXPIRES_SIGN = '3006';
	private $CODE_NO_SIGN = '3007';

	private $CODE_FAILED_CREATE_OBJ = '3008';
	private $CODE_DB_CONNECT_ERROR = '3009';
	private $CODE_DB_EXCUTE_ERROR = '3010';
	private $CODE_ERROR_PARAM = '3011';
	private $CODE_NO_POWER = '3012';

	private $CODE_USER_UNKNOW_ERROR = '3030';
	private $CODE_USER_NOT_EXIST = '3031';
	private $CODE_USER_DISABLED = '3032';
	private $CODE_USER_NOT_LOGIN = '3033';
	private $CODE_USER_TOKEN_ERR = '3034';
	private $CODE_REGISTRY_DEVID_EXIST = '3035';
	private $CODE_REGISTRY_NICK_EXIST = '3036';
	private $CODE_FAIL_PWD = '3037';

	private $CODE_SHARE_SAVE_ERROR = '3051';
	private $CODE_SHARE_NO_PRIV = '3052';
	private $CODE_SHARE_FILE_TOO_BIG = '3053';
	private $CODE_SHARE_NO_PIC_AND_LINK = '3054';

	private $CODE_PINGLUN_FAIL = '3071';
	private $CODE_NOZAN_VAL = '3072';

	private $CODE_BAD_PAYTYPE = '4001';
	private $CODE_REMOTE_API_FAIL = '4002';

	private $CODE_NO_GOODS = '5001';

	private $CODE_UNKNOW_ERROR = '800000';
	private $CODE_DEAL_FAILED = '800001';
	private $CODE_FUNC_FORBIDDEN = '800002';
	private $CODE_SYS_UPGRADE = '800003';
	private $CODE_FUNC_BUILDING = '800004';

	private $CODE_INSERT_FAIL = '2001';
	private $CODE_UNAME_EXISTS = '2002';

	private $CODE_SP_UNAME_EXISTS = '2003';

	private $CODE_UPLOAD_ERROR = '2004';
	private $CODE_UPDATE_GAME_USER_INFO_FAIL = '2005';
	private $CODE_SP_CASH_NOT_ENOUGH = '2006';
	private $CODE_NET_ERROR = '2007';
	private $CODE_GET_SP_OPENID_FAIL = '2008';
	private $CODE_SP_GET_CASH_FAIL = '2009';
	private $CODE_ADD_APPLY_RECORD_FAIL = '2010';
	private $CODE_CANNOT_GET_CASH = '2011';
	private $CODE_SP_NOT_FIT_MIN_MONEY = '2012';
	private $CODE_SP_NOT_EXIST = '2013';
	private $CODE_GAME_COIN_ERROR = '2014';
	private $CODE_SP_NOT_AGENT = '2015';
	private $CODE_BUY_COIN_FAIL = '2016';
	private $CODE_BUY_COIN_SUCCESS = '2017';
	private $CODE_ERROR_ORDER = '2018';
	private $CODE_QUIE_PAY_ERROR = '2019';
	private $CODE_APPLY_BILL_ERROR = '2020';
	private $CODE_HAS_CLOSE_ORDER = '2021';
	private $CODE_RECOMID_ORDER = '2022';
	private $CODE_NO_USE_BILL_BUY_COIN = '2023';
	private $CODE_CANT_RECHARGE_BY_SELF_ORDER = '2024';
	private $DATA_REPEAT = '2025';


	private static $_MESSAGE_MAP = array(
		'100' => 'FAIL',
		'200' => 'OK',
		'403' => '禁止访问',

		'2001' => '插入数据表失败',
		'2002' => '登录名已经存在',
		'2003' => '手机已经注册',
		'2004' => '图片上传失败',
		'2005' => '修改游戏用户信息失败',
		'2006' => '代理提现金额不足',
		'2007' => '网络错误，请稍后重试',
		'2008' => '获得代理的openid失败',
		'2009' => '代理提现失败',
		'2010' => '写入提现记录失败',
		'2011' => '无法提现，请将平台房卡补齐',
		'2012' => '无法提现，没有达到最低提现门槛',
		'2013' => '转冲的代理不存在',
		'2014' => '游戏道具异常',
		'2015' => '代理没有该游戏的代理权',
		'2016' => '购卡失败',
		'2017' => '购卡成功',
		'2018' => '异常订单',
		'2019' => '放弃付款失败',
		'2020' => '异常提现申请',
		'2021' => '订单已关闭',
		'2022' => '推荐id不合法',
		'2023' => '无法使用余额购卡，请将平台房卡补齐',
		'2024' => '不能为自己转房卡',
		'2025' => '有重复数据',

		'3001' => '传入参数不完整',
		'3002' => '错误的动作请求',
		'3003' => '数据签名错误',
		'3004' => '没有数据',
		'3005' => '不合法',
		'3006' => '签名过期',
		'3007' => '没有签名',

		'3008' => '创建对象失败',
		'3009' => '数据库连接失败',
		'3010' => '数据库语句执行失败',
		'3011' => '参数不合法',
		'3012' => '此权限还未开通',

		'3030' => '用户登陆未知错误',
		'3031' => '用户不存在',
		'3032' => '帐号被禁用',
		'3033' => '用户未登陆',
		'3034' => '令牌错误',
		'3035' => '要注册的用户设备已存在',
		'3036' => '昵称已存在',
		'3037' => '用户密码错误',

		'3051' => '分享信息保存出错',
		'3052' => '没有权限分享',
		'3053' => '分享的文件过大',
		'3054' => '我为人人，人人为我，图片和链接至少分享一个吧！',

		'3071' => '评论失败',
		'3072' => '点赞失败，赞力值不够',

		'4001' => '支付类型错误',
		'4002' => '远程接口调用失败',

		'5001' => '套餐不存在',

		'800000' => '未知错误，请检查',
		'800001' => '处理业务失败',
		'800002' => '功能被禁止使用',
		'800003' => '系统维护中，暂停服务',
		'800004' => '功能开发中，暂未开放',
	);

	public function __construct($code, $message = '')
	{
		$code = $this->$code;

		if (isset(self::$_MESSAGE_MAP[$code])) {
			//$message = "[err:".$code."]".self::$_MESSAGE_MAP[$code].$message;
			$message = self::$_MESSAGE_MAP[$code] . $message;
		}
		parent::__construct($message, $code);
	}

	public function getErrorDes($code)
	{
		$code = $this->$code;
		if (isset(self::$_MESSAGE_MAP[$code])) {
			return self::$_MESSAGE_MAP[$code];
		}
		return "";
	}

	public function getErrorCode($code)
	{
		if (isset($this->$code)) {
			return $this->$code;
		}
		return "";
	}

}
