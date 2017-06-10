<?php

define('BASEDIR',__DIR__);

include BASEDIR.'/../Com/Loader.php';
include "./test/router.php";

spl_autoload_register('\\Com\\Loader::autoload');

$_DocumentPath = $_SERVER['DOCUMENT_ROOT'];
$_RequestUri = $_SERVER['REQUEST_URI'];
$_FilePath = __FILE__;
$_AppPath = str_replace($_DocumentPath, '', $_FilePath);

//请求方式
//$method = $_SERVER['REQUEST_METHOD'];
//请求的 根路径
//echo $_SERVER['REQUEST_URI'];


//var_dump($_DocumentPath);
//$params1 = $_REQUEST;



?>