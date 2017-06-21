<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/1
 * Time: 14:03
 * Help:http://blog.csdn.net/jia28970475/article/details/52296989
 */

namespace Com;

use Com\Factory;

Class Response
{
//返回数据
	public function show($code,$message='',$data='',$type = 'json',$callback='')
	{
		if($type=='json')
		{
			echo     self::jsonEncode($code,$message,$data);
		}elseif($type == 'xml')
		{
			echo     self::xmlEncode($code,$message,$data);
		}elseif($type == 'jsonp')
		{
			echo    $callback.'('.self::jsonEncode($code,$message,$data).')';
		}
	}

//json接口
	public function jsonEncode($code,$message='',$data='')
	{
		if(!is_numeric($code))
		{
			return '';
		}

		$result = array(
			'code' => $code,
			'message' => $message,
			'data' => $data,
		);
		$time = time()-60; // or filemtime($fn), etc
		header('Last-Modified: '.date("Y-m-d h:i:s",time()));
		header("Content-type:text/json;chaset=utf-8");
		return json_encode($result);
	}
//xml接口
	public function xmlEncode($code,$message,$data=array())
	{
		if(!is_numeric($code))
		{
			return '';
		}

		$result = array(
			'code' => $code,
			'message' => $message,
			'data' => $data,
		);

		header("Content-type:text/xml;chaset=utf-8");
		$xml = "<?xml version='1.0' encoding='utf-8'  ?>\n";
		$xml .= "<root>\n";
		$xml .= self::xmlToEncode($result);
		$xml .=    "</root>\n";

		return $xml;

	}

	//xml内容循环
	public function xmlToEncode($data)
	{
		if(empty($data))
		{
			return '';
		}
		$xml = $attr = '';
		foreach ($data as $key => $value)
		{
			if(is_numeric($key))
			{
				$attr = "id='{$key}'";
				$key = "item";
			}
			$xml .= "<{$key} {$attr}>";
			$xml .= is_array($value) ? self::xmlToEncode($value) : $value ;
			$xml .= "</{$key}>\n";
		}

		return $xml;
	}
}
?>