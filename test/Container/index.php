<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/8
 * Time: 17:29
 * 装饰器模式
 */


define('BASEDIR', __DIR__);

include BASEDIR . '/../Com/Loader.php';

spl_autoload_register('\\Com\\Loader::autoload');

header("Content-Type:text/html;charset=utf8");
//class A{
//	public $name;
//	public $age;
//	public function __construct($name=""){
//		$this->name = $name;
//	}
//}
////创建一个容器类
//$di = new test\Di();
////匿名函数方式注册一个名为a1的服务
//$di->setShared('a1',function($name=""){
//	return new A($name);
//});
////直接以类名方式注册
//$di->set('a2','A');
////直接传入实例化的对象
//$di->set('a3',new A("小唐"));
//
//$a1 = $di->get('a1',array("小李"));
//echo $a1->name."<br/>";//小李
//
//$a1_1 = $di->get('a1',array("小王"));
//echo $a1->name."<br/>";//小李
//echo $a1_1->name."<br/>";//小李
//
//$a2 = $di->get('a2',array("小张"));
//echo $a2->name."<br/>";//小张
//$a2_1 = $di->get('a2',array("小徐"));
//echo $a2->name."<br/>";//小张
//echo $a2_1->name."<br/>";//小徐
//
//$a3 = $di['a3'];//可以直接通过数组方式获取服务对象
//echo $a3->name."<br/>";//小唐
//
//
//$di->set('a4', 'A');//可以直接通过数组方式获取服务对象
//$a4 = $di->get('a4',array('陈明'));
//
//
//var_dump($a4);
//echo $a4->name."<br/>";//小唐


class demo1
{
	public function getData(){
		echo 'demo1<br>';
	}
}

class demo2
{
	public function getData(){
		echo 'demo2<br>';
	}
}

//创建一个类容器
$di =new \test\Di();

//注册一个服务
$di->set('demo1','demo1');
$di->set('demo2','demo2');

//实例化一次demo类
$di->get('demo1')->getData();
$di->get('demo2')->getData();

?>