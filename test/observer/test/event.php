<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/8
 * Time: 15:53
 */

namespace test;

//被观察者
class Event extends EventGenerator
{
	public function tigger(){
		echo 'event<br>';
		//接受通知
		$this->notify();
	}
}
//观察者
class Observer1 implements Observer{
	public function update($event_info = null){
		echo 'Observer1<br>';
	}
}
class Observer2 implements Observer{
	public function update($event_info = null){
		echo 'Observer2<br>';
	}
}

?>

