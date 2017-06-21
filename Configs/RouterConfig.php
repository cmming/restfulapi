<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/8
 * Time: 14:17
 */


$RouterConfig = array(
	//登录
	'login' =>
		array('path' => 'Admin\Admin', 'ctr' => 'login', 'isJwt' => false),
	//注册接口
	'addAdmin' =>
		array('path' => 'Admin\Admin', 'ctr' => 'addAdmin', 'isJwt' => false),
	//退出登录
	'signUp' =>
		array('path' => 'Admin\Admin', 'ctr' => 'signUp', 'isJwt' => true),
	//更新token
	'updateToken' =>
		array('path' => 'Admin\Admin', 'ctr' => 'updateToken', 'isJwt' => true),
	//消息
	'getMsg' =>
		array('path' => 'Msg\Msg', 'ctr' => 'getMsg', 'isJwt' => true),
	'getMsgById' =>
		array('path' => 'Msg\Msg', 'ctr' => 'getMsgById', 'isJwt' => true),
	//更新或者添加消息
	'updateMsg' =>
		array('path' => 'Msg\Msg', 'ctr' => 'updateMsg', 'isJwt' => true),
	//删除
	'deleteMsg' =>
		array('path' => 'Msg\Msg', 'ctr' => 'deleteMsg', 'isJwt' => true),
	//联系人
	'getContacts' =>
		array('path' => 'Contact\Contact', 'ctr' => 'getContacts', 'isJwt' => true),
	'getContactById' =>
		array('path' => 'Contact\Contact', 'ctr' => 'getContactById', 'isJwt' => true),
	'updateContact' =>
		array('path' => 'Contact\Contact', 'ctr' => 'updateContact', 'isJwt' => true),
	//检测用户的名字是否唯一
	'checkContactName' =>
		array('path' => 'Contact\Contact', 'ctr' => 'checkContactName', 'isJwt' => true),
	//删除联系人
	'deleteContact' =>
		array('path' => 'Contact\Contact', 'ctr' => 'deleteContact', 'isJwt' => true),
	//消息模版
	'getMsgModels' =>
		array('path' => 'MsgModel\MsgModel', 'ctr' => 'getMsgModels', 'isJwt' => true),
	//更新
	'updateMsgModel' =>
		array('path' => 'MsgModel\MsgModel', 'ctr' => 'updateMsgModel', 'isJwt' => true),
	//删除
	'deleteMsgModel' =>
		array('path' => 'MsgModel\MsgModel', 'ctr' => 'deleteMsgModel', 'isJwt' => true),

	//文件上传
	'uploadFile' =>
		array('path' => 'UploadFile\UploadFile', 'ctr' => 'UploadFile', 'isJwt' => false),
);

return $RouterConfig;
?>