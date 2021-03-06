<?php

use Com\Factory;
/**
 * 普通的接收参数的函数
 * @param $params 参数的类型
 * @param bool|false $is_json_decode 是否将该参数的值转换为json对象 默认不转换
 * @return mixed|string
 */
function Request($params, $is_json_decode = false)
{
	//进行错误处理
	if(isset($_REQUEST[$params])){
		$result = $_REQUEST[$params];
		if ($is_json_decode) {
			return json_decode($result, true);
		} else {
			return $result;
		}
	}else{
		throw Factory::getCoreException('CODE_BAD_PARAM');
	}
}

/**
 * 前端使用框架的话，使用该方法的（vue angular都是这样）
 * @param $params 参数的字段
 * @param bool|false $is_json_decode 是否进行json转换，默认不转换
 * @return mixed|string
 */
function FrameworkRequest($params, $is_json_decode = false)
{
	$request_data = file_get_contents('php://input', true);
	$request_data = json_decode($request_data, true);
	if(isset($request_data[$params])){
		$result = $request_data[$params];
		if ($is_json_decode) {
			return json_decode($result, true);
		} else {
			return $result;
		}
	}else{
		throw Factory::getCoreException('CODE_BAD_PARAM');
	}
}

/**
 * @param $max_pages
 * @param $page_sum
 * @param $cur_page
 * @param $linkarg
 * @param array $control_word
 * @return string
 */
function create_classpage_str($max_pages, $page_sum, $cur_page, $linkarg, $control_word = array())
{
	$result = '';
	$max_pages = $max_pages ? $max_pages : 10;
	//获取当前页
	if ($page_sum > 1) {
		//控制按钮文字
		$top_str = $end_str = '';
		$c_page = $cur_page ? $cur_page : 0;
		$linkarg = $linkarg ? $linkarg : 'cp';
		if ($c_page != 0 && $page_sum > $max_pages)
			$top_str .= '<a href="?' . $linkarg . '=0" class="c-top">' . $control_word[0] . '</a><a href="?' . $linkarg . '=' . ($c_page - 1) . '" class="c-pre">' . $control_word[1] . '</a>';
		if ($c_page != ($page_sum - 1) && $page_sum > $max_pages)
			$end_str .= '<a href="?' . $linkarg . '=' . ($c_page + 1) . '" class="c-next">' . $control_word[2] . '</a><a href="?' . $linkarg . '=' . ($page_sum - 1) . '" class="c-end">' . $control_word[3] . '</a>';
		//计算当前显示的页面开始值
		$float_page_start = floor($max_pages / 2);
		//计算页码显示的开始值
		$p_index_start = ($c_page > $float_page_start && $page_sum > $max_pages) ? ($c_page - $float_page_start) : 0;
		$p_index_start = ($p_index_start > ($page_sum - $max_pages) && $page_sum > $max_pages) ? ($page_sum - $max_pages) : $p_index_start;
		$a_sum = ($page_sum > $max_pages) ? $max_pages : $page_sum;
		//生成页码字符串
		$pages_str = '';
		for ($i = 0; $i < $a_sum; $i++) {
			$cur_class = ($p_index_start + $i) == $c_page ? 'class="cur-page"' : '';
			$pages_str .= '<a href="?' . $linkarg . '=' . ($p_index_start + $i) . '" ' . $cur_class . '>' . ($p_index_start + $i + 1) . '</a>';
		}
		//生成分页字符串
		$result = $top_str . $pages_str . $end_str;
	}
	return $result;
}

/////////////////////////////////////////////////
//功　　能：获取当前访问IP
//入口参数：
//返 回 值：[xxx.xxx.xxx.xxx]格式IP地址
/////////////////////////////////////////////////
function getip_str()
{
	if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && ($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		return $_SERVER['HTTP_X_FORWARDED_FOR'];
	} elseif (isset($_SERVER['HTTP_CLIENT_IP']) && ($_SERVER['HTTP_CLIENT_IP'])) {
		return $_SERVER['HTTP_CLIENT_IP'];
	} else {
		return $_SERVER['REMOTE_ADDR'];
	}
}

/**
 * 生成一个长度为 $length 的随机数
 * @param $length
 * @return int
 */
function generate_decode($length)
{
	return rand(pow(10, ($length - 1)), pow(10, $length) - 1);
}

?>