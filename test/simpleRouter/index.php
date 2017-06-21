<?php

define('BASEDIR',__DIR__);

include BASEDIR.'/../Com/Loader.php';
include "./test/router.php";

spl_autoload_register('\\Com\\Loader::autoload');



$router = new test\router();

//为路由添加过滤器 将所有的逻辑分开，过滤器执行的顺序为 before -> after(将所有的befor 执行完后在执行after方法)
class hook{
	public function before(){
		echo '<br>before<br>';
	}
	public function after(){
		echo '<br>after<br>';
	}
}

$router->addHook('ok',new hook());

//匿名函数的回调 ，实现起来麻烦；最简便的方式就是通过装饰漆的方式向，一个类的方法中 添加函数

$router->addRouter('get','/sd/sd','sdds',function(){
	echo 'callback1';
});


//移除
$router->removeHook('ok');


//$router->addRouter('get','\sd\sd','sdds');



?>