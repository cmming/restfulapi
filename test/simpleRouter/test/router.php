<?php

namespace test;
/**
 * Class router
 * 通过请求方式，请求的路径 去匹配相应的控制器
 *
 */
class router
{
	/**
	 * @var 请求的方法
	 */
	private $method;

	/**
	 * @var 路由的路径
	 */
	private $resouce_path;

	/**
	 * @var 对应的控制器以及方法
	 */
	private $controler_name;

	/**
	 * @var 钩子函数
	 */
	private $hook;

	//将数据填进来
	public function __construct()
	{
	}

	/**
	 * 添加一个路由:根据这几个参数跳转到不同的 控制器方法里
	 * @param $method
	 * @param $resouce_path
	 * @param $controler_name
	 * @param $callBack 回调函数
	 */
	public function addRouter($method,$resouce_path,$controler_name,$callBack){
		$this->before();
		$this->getResoucePath();
		echo $method.$resouce_path.$controler_name;
		$this->after();
		$callBack();
	}
	//添加 装饰器函数，添加钩子函数
	public function addHook($key,$obj){
		if(!isset($this->hook[$key])){
			$this->hook[$key] = $obj;
		}
	}

	public function removeHook($key){
		if(isset($this->hook[$key])){
			unset($this->hook[$key]);
		}
	}

	private function before(){
		if($this->hook){
			foreach($this->hook as $hookItem){
				if(method_exists($hookItem,'before')){
					$hookItem->before();
				}
			}
		}
	}

	private function after(){
		if($this->hook){
			foreach($this->hook as $hookItem){
				if(method_exists($hookItem,'after')){
					$hookItem->after();
				}
			}
		}
	}

	/**
	 * 获取当前接口的 资源路径
	 * 目前不支持 嵌套！！！
	 */
	private function getResoucePath()
	{
		date_default_timezone_set("Asia/Shanghai");
		//主页的地址
		$root_path = $_SERVER['SCRIPT_NAME'];
		// 如果有，就说明是重定向过的
		$api_path = $_SERVER['REDIRECT_URL'];
		//请求地址，不管是否经过重定向 都会有
		$uri = $_SERVER['REQUEST_URI'];
		//重定向
		$api_root = str_replace('index.php', '', $root_path);
		//处理后的资源路径
		$resouce_path = str_replace($api_root, '', $api_path);
		//开始匹配
		echo $resouce_path.'<br>';
	}
}



?>