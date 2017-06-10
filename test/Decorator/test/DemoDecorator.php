<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/8
 * Time: 17:40
 */

namespace test;
//实现一个装饰器

class DemoDecorator implements demoInterface
{
	//相当于闭包中的变量
	protected static $num = 1;
	public function at_before()
	{
		// TODO: Implement at_before() method.
		self::$num+=1;
		echo 'at_before'.self::$num.'<br>';
	}
	public function  at_end()
	{
		// TODO: Implement at_end() method.
		self::$num+=1;
		echo 'at_end'.self::$num.'<br>';
	}
}