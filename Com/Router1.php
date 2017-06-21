<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/8
 * Time: 14:26
 *
 * 根据RouterConfig 中的数据进行快速匹配
 */

namespace Com;

class Router1
{
	public function __construct($dataform)
	{
		//获取请求的资源地址
		$rootUrl = $this->getResoucePath($dataform);
		//获取请求的方法
		$request_method = $_SERVER['REQUEST_METHOD'];
		//获取配置文件
		$routerConfigArray = ConfigAutoReload::getInstance('\\Configs\\')['RouterConfig'];
		//判断资源地址是否在路由中存在
		$isDefined = array_key_exists($rootUrl, $routerConfigArray);
		//判断是否定义
		if ($isDefined) {
			//获取路由中 指向那个那种请求类型
			$isGoodMethod = array_key_exists($request_method, $routerConfigArray[$rootUrl]);
			if ($isGoodMethod) {
				//获取资源的请求地址
				$resouceSetting = $routerConfigArray[$rootUrl][$request_method];
				$resouceSettingArray = explode('@', $resouceSetting['uses']);

				$isJwt = isset($resouceSetting['isJwt']) ? $resouceSetting['isJwt'] : false;
				if ($isJwt) {
					if (Factory::getMiddelWare('Jwt\Jwt')->checkToken()) {
						Factory::getController($resouceSettingArray[0])->$resouceSettingArray[1]($dataform);
					} else {
						//让前端重定向到登录页面
						throw Factory::getCoreException('CODE_USER_NOT_LOGIN');
					}
				} else {
					Factory::getController($resouceSettingArray[0])->$resouceSettingArray[1]($dataform);
				}
			} else {
				//错误的请求方式
				throw Factory::getCoreException('CODE_BAD_SIGN');
			}
		}

	}

	/**
	 * 获取当前接口的 资源路径
	 * 目前不支持 嵌套！！！
	 */
	private function getResoucePath()
	{
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
		return $resouce_path;
	}

}

?>