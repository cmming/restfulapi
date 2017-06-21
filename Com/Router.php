<?php
/**
 * 路由的抽象类
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/8
 * Time: 14:26
 *
 * 根据RouterConfig 中的数据进行快速匹配
 */

namespace Com;

class Router
{
	/**
	 * @var 钩子函数
	 */
	private $hook;

	/**
	 * 添加一个路由
	 * @param $path 对应的命名空间
	 * @param $ctr 对应的方法
	 * @param $dataform 对应的参数
	 */
	public function addRouter($path,$ctr,$dataform)
	{
		$this->before();
		Factory::getController($path)->$ctr($dataform);
		$this->after();
	}

	//添加 装饰器函数，添加钩子函数
	public function addHook($key,$obj){
		if(!isset($this->hook[$key])){
			$this->hook[$key] = $obj;
		}
	}

	/**
	 * @param $key 要删除的过滤器
	 */
	public function removeHook($key){
		if(isset($this->hook[$key])){
			unset($this->hook[$key]);
		}
	}

	/**
	 * 遍历钩子函数中的所有 逻辑接口
	 */
	private function before(){
		if($this->hook){
			foreach($this->hook as $hookItem){
				if(method_exists($hookItem,'before')){
					$hookItem->before();
				}
			}
		}
	}

	/**
	 * 遍历执行所有的路由 函数
	 */
	private function after(){
		if($this->hook){
			foreach($this->hook as $hookItem){
				if(method_exists($hookItem,'after')){
					$hookItem->after();
				}
			}
		}
	}

}

?>