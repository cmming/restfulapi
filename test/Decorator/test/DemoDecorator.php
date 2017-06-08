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
	public function at_before()
	{
		// TODO: Implement at_before() method.
		echo 'at_before<br>';
	}
	public function  at_end()
	{
		// TODO: Implement at_end() method.
		echo 'at_end<br>';
	}
}