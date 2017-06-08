<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/8
 * Time: 16:34
 */

define('BASEDIR',__DIR__);

include BASEDIR.'/../Com/Loader.php';

spl_autoload_register('\\Com\\Loader::autoload');

//添加 被监视者
$event = new \test\Event();

//添加观察者
$event->addObserver(new \test\Observer1());
$event->addObserver(new \test\Observer2());

//时间发生者 一旦发生事件 就会激活观察者的时间
$event->tigger();

?>