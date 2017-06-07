<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/5
 * Time: 12:13
 * 配置文件的自动加载：将一个配置文件
 * 传入参数为：配置文件的目录，然后通过key 读取到文件->文件中的数组key
 */

namespace Com;


class ConfigAutoReload implements \ArrayAccess
{
	//配置文件的路径
	protected $path;
	//存储配置文件中的数据
	protected $configs = array();
	//用来保存实例
	protected static $instance;

	private function __construct($path)
	{
		$this->path = BASEDIR . $path;
	}

	public static function getInstance($base_dir = '')
	{
		if (empty(self::$instance)) {
			self::$instance = new self($base_dir);
		}
		return self::$instance;
	}

	//获取一个偏移位置的值
	public function offsetGet($key)
	{
		if (empty($this->configs[$key])) {
			$file_path = $this->path . '/' . $key . '.php';
			$config = require $file_path;
			$this->configs[$key] = $config;
		}
		return $this->configs[$key];
	}

	//设置一个偏移位置的值
	public function offsetSet($key, $value)
	{
		throw new \Exception("读取文件错误");
	}

	//检查一个偏移位置是否存在
	public function offsetExists($key)
	{
		return isset($this->configs[$key]);
	}

	//复位一个偏移位置的值
	public function offsetUnset($key)
	{
		unset($this->configs[$key]);
	}

}

?>