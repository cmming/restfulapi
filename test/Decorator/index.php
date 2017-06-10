<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/8
 * Time: 17:29
 * 装饰器模式
 */


define('BASEDIR',__DIR__);

include BASEDIR.'/../Com/Loader.php';

spl_autoload_register('\\Com\\Loader::autoload');

$demo = new \test\UseDecorator();
$dmeo1 =  new \test\DemoDecorator();
$dmeo2 =  new \test\DemoDecorator();

$demo->addDecorator('d1', $dmeo1);
$demo->addDecorator('d2',$dmeo2);


$demo->useDecorator();
$demo->removeDecorator('d1');
echo '<br>';

$demo->useDecorator();

?>