<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/16
 * Time: 11:44
 */

namespace App\Controller\UploadFile;


class UploadFile
{
	public function UploadFile(){
		$upload_obj = new \Com\FileUpload(); // 文件上传对象
		$upload_obj->InputName = 'imgs'; // 文件上传域控件名
		$upload_obj->FileType = array('image/jpeg', 'image/png'); // 允许上传的文件类型
		$upload_obj->FileMaxSize =array('image' => 1024 * 1024, 'audio' => 2 * 1024 * 1024, 'video' => 2 * 1024 * 1024);
		$upload_obj->FileSavePath = array('upload/files/s/', 'upload/files/z/');
		$file_save_full_name = $upload_obj->UploadFile();
	}

}
?>