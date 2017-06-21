<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/21
 * Time: 14:37
 *准备一个盒子(容器)，事先将项目中可能用到的类扔进去，在项目中直接从容器中拿，也就是避免了直接在项目中到处new，
 * 造成大量耦合。取而代之的是在项目类里面增设 setDi()和getDi()方法，通过Di同一管理类。取代之前的工厂类
 *
 * 支持的注册方式 set
 * 		类型：共享模式和非共享共享模式
 * 		共享模式   存放在实例数组中 相当于单例模式
 * 		非共享模式 存放在服务列表中，并没有被实例化
 * 		方式：1.闭包形式。2.字符串形式（类的名称）。3实例化对象形式
 *
 * 实例化之前注册的服务 get
 * 		种类：实例化共享模式的，只会被注册一次，以第一次实例化为准；非共享模式，支持多次实例化
 */

namespace Com;


class Di implements \ArrayAccess{
	/**
	 * @var array 服务列表
	 */
	private $_bindings = array();
	/**
	 * @var array 已经实例化的服务 单例对象数组
	 */
	private $_instances = array();

	/**
	 * 获取服务
	 * @param $name 服务的关键字
	 * @param array $params
	 * @return mixed|null|object
	 */
	public function get($name,$params=array()){
		//先从已经实例化的列表中查找
		if(isset($this->_instances[$name])){
			return $this->_instances[$name];
		}

		//检测有没有注册该服务
		if(!isset($this->_bindings[$name])){
			return null;
		}

		$concrete = $this->_bindings[$name]['class'];//对象具体注册内容

		$obj = null;
		//之前注册的服务是匿名函数方式
		if($concrete instanceof \Closure){
			$obj = call_user_func_array($concrete,$params);
		}
		//字符串方式（类的名字）
		elseif(is_string($concrete)){
			//不带参数的实例化
			if(empty($params)){
				$obj = new $concrete;
			}else{
				//带参数的类实例化，用ReflectionClass得到$concrete的反射类对象
				$class = new \ReflectionClass($concrete);
				//通过newInstanceArgs创建的一个新的A类的实例
				$obj = $class->newInstanceArgs($params);
			}
		}
		//如果是共享服务，则写入_instances列表，下次直接取回
		if($this->_bindings[$name]['shared'] == true && $obj){
			$this->_instances[$name] = $obj;
		}

		return $obj;
	}

	//检测是否已经绑定
	public function has($name){
		return isset($this->_bindings[$name]) or isset($this->_instances[$name]);
	}

	//卸载服务
	public function remove($name){
		unset($this->_bindings[$name],$this->_instances[$name]);
	}

	//设置服务
	public function set($name,$class){
		$this->_registerService($name, $class);
	}

	//设置共享服务 会让该服务成为单例形式
	public function setShared($name,$class){
		$this->_registerService($name, $class, true);
	}

	//注册服务
	private function _registerService($name,$class,$shared=false){
		//移除之前同名的函数
		$this->remove($name);
		// 通过匿名函数的方式注入服务，直接将其存储在已经注册的列表
		if(!($class instanceof \Closure) && is_object($class)){
			$this->_instances[$name] = $class;
		}else{
			//添加到服务列表
			$this->_bindings[$name] = array("class"=>$class,"shared"=>$shared);
		}
	}

	//ArrayAccess接口,检测服务是否存在
	public function offsetExists($offset) {
		return $this->has($offset);
	}

	//ArrayAccess接口,以$di[$name]方式获取服务
	public function offsetGet($offset) {
		return $this->get($offset);
	}

	//ArrayAccess接口,以$di[$name]=$value方式注册服务，非共享
	public function offsetSet($offset, $value) {
		return $this->set($offset,$value);
	}

	//ArrayAccess接口,以unset($di[$name])方式卸载服务
	public function offsetUnset($offset) {
		return $this->remove($offset);
	}
}

?>