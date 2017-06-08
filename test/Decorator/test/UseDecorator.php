<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/8
 * Time: 17:49
 */

namespace test;


class UseDecorator
{
	private $decorators =array();

	//添加一个装饰器
	public function addDecorator(demoInterface $decorator)
	{
		$this->decorators[] = $decorator;
	}
	//删除一个装饰器
	public function removeDecorator(){
		$this->decorators[] = 
	}
	public function at_end()
	{
		// TODO: Implement at_end() method.
		$decorators = array_reverse($this->decorators);
		foreach($this->decorators as $decorator)
		{
			$decorator->at_end();
		}

	}

	public function at_before()
	{
		// TODO: Implement at_before() method.
		foreach($this->decorators as $decorator)
		{
			$decorator->at_before();
		}
	}

	public function useDecorator(){
		$this->at_before();
		$this->at_end();
	}

}

?>