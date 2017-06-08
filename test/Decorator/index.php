<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/8
 * Time: 17:29
 */


define('BASEDIR',__DIR__);

include BASEDIR.'/../Com/Loader.php';

spl_autoload_register('\\Com\\Loader::autoload');

$demo = new \test\UseDecorator();

$demo->addDecorator(new \test\DemoDecorator());

$demo->useDecorator();
?>