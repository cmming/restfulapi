<?php
namespace Com;

class Register
{
	//保存所有的对象
	protected static $app;

	static function set($alias, $object)
	{
		self::$app[$alias] = $object;
	}

	static function get($key)
	{
		if (!isset(self::$app[$key])) {
			return false;
		}
		return self::$app[$key];
	}

	static function _unset($alias)
	{
		unset(self::$app[$alias]);
	}
}

?>