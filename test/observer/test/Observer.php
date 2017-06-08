<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/8
 * Time: 16:00
 */

namespace test;


interface Observer
{
	//接受参数保存事件的默认信息
	public function update($event_info = null);
}