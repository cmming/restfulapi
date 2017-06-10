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
	public function addDecorator($key ,demoInterface $decorator)
	{
		$this->decorators[$key] = $decorator;
	}
	//删除一个装饰器
	public function removeDecorator($key){
		//寻找 要删除的装饰器的位置 返回false 就表示不存在
//		$key = array_search($decorator,$this->decorators);
//		if($key){
//			array_splice($this->decorators,$key,1);
//		}
		if(isset($this->decorators[$key])){
			unset($this->decorators[$key]);
		}
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
		//先运行完所有的before 然后运行完所有的end函数
		$this->at_before();
		$this->at_end();
	}

}

?>