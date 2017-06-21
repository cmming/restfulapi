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
	//更新或者添加消息
	'updateMsg' =>
		array('path' => 'Msg\Msg', 'ctr' => 'updateMsg', 'isJwt' => true),
	//删除
	'deleteMsg' =>
		array('path' => 'Msg\Msg', 'ctr' => 'deleteMsg', 'isJwt' => true),
	//联系人
	'getContacts' =>
		array('path' => 'Contact\Contact', 'ctr' => 'getContacts', 'isJwt' => true),
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
	//改进型 一级key 表示 资源对象表示 二级key 表示对资源进行的一系列操作
	'Demo' =>
		array(
			//从服务器取出资源
			'GET' => array('uses' => 'Msg\Msg@getMsg', 'isJwt' => false),
			//在服务器新建一个资源
			'POST' => array(),
			//全部更新
			'PUT' =>array(),
			//部分更新
			'PATCH' =>array(),
			//从服务器删除资源
			'DELETE' =>array(),
			//获取资源的元数据
			'HEAD' =>array(),
			//获取信息，关于资源的哪些属性是客户端可以改变的
			'OPTIONS' =>array()

		),
	'Admin' =>
		array(
			//从服务器取出资源
			'GET' => array('uses' => 'Admin\Admin@login', 'isJwt' => false),
			//登录
			'POST' => array('uses' => 'Admin\Admin@login', 'isJwt' => false),
			//全部更新
			'PUT' =>array(),
			//部分更新
			'PATCH' =>array(),
			//从服务器删除资源
			'DELETE' =>array(),
			//获取资源的元数据
			'HEAD' =>array(),
			//获取信息，关于资源的哪些属性是客户端可以改变的
			'OPTIONS' =>array()

		),
);

return $RouterConfig;
?>