<?php
error_reporting(0);
date_default_timezone_set("Asia/Shanghai");
$_DocumentPath = $_SERVER['DOCUMENT_ROOT'];
$_RequestUri = $_SERVER['REQUEST_URI'];
$_UrlPath = $_RequestUri;
$_FilePath = __FILE__;
$_AppPath = str_replace($_DocumentPath, '', $_FilePath);    //==>routerindex.php
$_AppPathArr = explode(DIRECTORY_SEPARATOR, $_AppPath);
//var_dump($_AppPathArr);
echo (json_encode($_SERVER,true));exit();
echo '<br>';
echo '<br>';
for ($i = 0; $i < count($_AppPathArr); $i++) {
	$p = $_AppPathArr[$i];
	if ($p) {
		$_UrlPath = preg_replace('/^/' . $p . '//', '/', $_UrlPath, 1);
	}
}
$_UrlPath = preg_replace('/^//', '', $_UrlPath, 1);
$_AppPathArr = explode("/", $_UrlPath);
$_AppPathArr_Count = count($_AppPathArr);
$arr_url = array(
	'controller' => 'sharexie/test',
	'method' => 'index',
	'parms' => array()
);
$arr_url['controller'] = $_AppPathArr[0];
$arr_url['method'] = $_AppPathArr[1];
if ($_AppPathArr_Count > 2 and $_AppPathArr_Count % 2 != 0) {
	die('参数错误');
} else {
	for ($i = 2; $i < $_AppPathArr_Count; $i += 2) {
		$arr_temp_hash = array(strtolower($_AppPathArr[$i]) => $_AppPathArr[$i + 1]);
		$arr_url['parms'] = array_merge($arr_url['parms'], $arr_temp_hash);
	}
}
var_dump($arr_url['controller']);
$module_name = $arr_url['controller'];
$module_file = $module_name . '.class.php';
$method_name = $arr_url['method'];
if (file_exists($module_file)) {
	include $module_file;
	$obj_module = new $module_name();
	if (!method_exists($obj_module, $method_name)) {
		die("要调用的方法不存在");
	} else {
		if (is_callable(array($obj_module, $method_name))) {
			$obj_module->$method_name($module_name, $arr_url['parms']);
			$obj_module->printResult();
		}
	}
} else {
	die("定义的模块不存在");
}
?>