<?php

define('BASEDIR',__DIR__);

include BASEDIR.'/../Com/Loader.php';
include "./test/router.php";

spl_autoload_register('\\Com\\Loader::autoload');



$router = new test\router();


class hook{
	public function before(){
		echo '<br>before<br>';
	}
	public function after(){
		echo '<br>after<br>';
	}
}

$router->addHook('ok',new hook());

$router->addRouter('get','\sd\sd','sdds',function(){
	echo 'callback';
});


//移除
$router->removeHook('ok');


//$router->addRouter('get','\sd\sd','sdds');



?>