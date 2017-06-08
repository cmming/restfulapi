<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/8
 * Time: 15:57
 */

namespace test;

//事件产生者 抽象类

abstract class EventGenerator
{
	//保存所有 添加的观察者 （对于事件发生者不可见）
	private $observers = array();
	//添加观察者
	public function addObserver(Observer $observer){
		$this->observers[] = $observer;
	}
	//发送通知 添加了观察者的对象发送通知（让其执行相应的函数）
	public function notify(){
		foreach($this->observers as $observer)
		{
			$observer->update();
		}
	}

}