<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/16
 * Time: 11:29
 */

namespace Com;


class FileUpload
{
	//上传控件的name 获取文件的各种数据
	public $InputName;
	/**
	 * 允许上传的文件类型
	 * 形式为 array('image/jpeg', 'image/png', 'image/gif') 或包含此类数组的数组（与每个上传域控件对应）
	 */
	public $FileType;

	/**
	 * 最大上传文件大小（单位：byte）
	 * 形式为 array('image' => $size, 'audio' => $size)（表示每种应用文件类型所对应的上传大小） 或包含此类数组的数组（与每个上传域控件对应）或一数值（表示所有上传文件均限制在此大小之下）
	 */
	public $FileMaxSize;

	public $FileSavePath;  // 文件保存路径（可为数组形式，表示不同上传域上传文件到不同的路径）
	public $FileSaveName;  // 文件保存名（不包含后缀名）（可为数组形式，表示不同上传域上传文件保存的不同名称）

	public $NoteFileFalse = '文件错误'; // 文件错误提示
	public $NoteFileType = '文件类型不符';  // 文件类型不符提示
	public $NoteFileSize = '文件大小超出'; // 文件大小超出提示

	//初始化类的时候对类的属性进行初始化
//	public function __construct($InputName,$FileType,$FileMaxSize,$FileSavePath,$FileSaveName)
//	{
//		$this->InputName = $InputName;
//		$this->FileType = $FileType;
//		$this->FileMaxSize = $FileMaxSize;
//		$this->FileSavePath = $FileSavePath;
//		$this->FileSaveName = $FileSaveName;
//	}

	/* 上传文件并返回文件名信息（包含后缀名） */
	public function UploadFile()
	{
		$this->CheckFile(); // 检验文件
		$file = $_FILES[$this->InputName];
		$file_save_full_name = array(); // 文件保存名（包含后缀名）

		foreach ($file['name'] as $key => $name)
		{
			if (!empty($name)) // 文件不为空
			{
				//上传路径如果 设置为数组，则表示上传的路径是依据 上传文件队列而设置的
				if (is_array($this->FileSavePath))
				{
					$file_save_path = BASEDIR.'\\'.$this->FileSavePath[$key];
				}
				//否则直接 等于字符串的位置
				else
				{
					$file_save_path = BASEDIR.'\\'.$this->FileSavePath;
				}

				/* 确定文件保存名（不包含后缀名） */
				if (is_array($this->FileSaveName))
				{
					$file_save_name = $this->FileSaveName[$key];
				}
				else
				{
					$file_save_name = $this->FileSaveName;
				}
				//配置文件的保存名称为文件的md5
				$file_save_name = md5_file($file['tmp_name'][$key]);
				/* 开始保存 */
				$this->CreatePath($file_save_path); // 如果路径不存在则创建路径
				move_uploaded_file($file["tmp_name"][$key], $file_save_path . $file_save_name . $this->GetSuffix($file['name'][$key]));
				$file_save_full_name[] = $file_save_name . $this->GetSuffix($file['name'][$key]);
			}
			else
			{
				$file_save_full_name[] = null;
			}
		}
		//unlink($file);

		/* 如果只有一个文件，则返回单个文件名 */
		if (count($file_save_full_name) == 1)
		{
			$file_save_full_name = $file_save_full_name[0];
		}

		return $file_save_full_name;
	}

	/* 检验文件 */
	private function CheckFile()
	{
		$file = $_FILES[$this->InputName];
		//获取上传文件队列中的文件信息
		foreach ($file['name'] as $key => $name)
		{
			// 文件不为空
			if (!empty($name))
			{
				//获取文件的类型
				$type  = $file['type'][$key];
				//文件大小
				$size  = $file['size'][$key];
				//文件上传错误码
				$error = $file['error'][$key];

				/* 确定允许上传文件类型列表，让上传文件限制支持数组配置 */
				//如果配置是二维数组则表示，需要一个个的配置上传文件的类型
				if (is_array($this->FileType[0]))
				{
					$file_type = $this->FileType[$key];
				}
				else
				{
					$file_type = $this->FileType;
				}
				/* 1.文件类型不符 */
				if (!in_array($type, $file_type))
				{
					die($name . $this->NoteFileType);
				}

				/* 确定最大上传文件大小，可以配置多个，这个和文件的上传个数无关 */
				if (is_array($this->FileMaxSize))
				{
					//获取上传文件的类型
					$file_max_size_key = explode('/', $type);
					$file_max_size_key = $file_max_size_key[0];
					//支持为每个序号文件单独设置大小限制
					if (isset($this->FileMaxSize[0]))
					{
						$file_max_size = $this->FileMaxSize[$key][$file_max_size_key];
					}
					//根据文件的类型 获取文件的限制大小
					else
					{
						$file_max_size = $this->FileMaxSize[$file_max_size_key];
					}
				}
				else
				{
					$file_max_size = $this->FileMaxSize;
				}

				/* 文件错误 */
				if ($error > 0)
				{
					die($name . $this->NoteFileFalse);
				}

				/* 文件大小超过最大上传文件大小 */
				if ((!is_null($file_max_size) && $size > $file_max_size) || ($size == 0))
				{
					die($name . $this->NoteFileSize);
				}

			}
		}
	}

	/* 获取文件后缀名 */
	private function GetSuffix($fileName)
	{
		return substr($fileName, strrpos($fileName, "."));
	}

	/* 如果路径不存在则创建路径 */
	private function CreatePath($filePath)
	{
		if (!file_exists($filePath))
		{
			mkdir($filePath);
		}
	}
}
?>