<?php
	/**
	 * 根據列表文件，拷貝文件
	 */
	class StatusCode
	{
		const SUCCESS = 0;//正確執行

		const ERROR_PARAM_IS_INVALID = 1;//參數不合法

		const ERROR_LIST_FILE_NOT_EXIST = 2;//列表文件不存在

		const ERROR_LIST_FILE_UNREADABLE = 3;//列表文件不可讀

		const ERROR_FILE_NOT_EXIST = 4;//指定文件不存在
	}

	class Copyphp 
	{
		/**
		 * 列表文件
		 * @var string
		 */
		private $_list_file = '';

		/**
		 * 目標文件夾路徑
		 * @var string
		 */
		private $_dest_dir_path = '';

		/**
		 * 項目root目錄
		 * @var string
		 */
		private $_root_path = './';

		function __construct($conf='')
		{
			if($conf!=''){
				if(is_array($conf)){
					foreach ($conf as $k => $v) {
						isset($this->$k) && $this->$k = $v;
					}
				}
			}
		}

		public static function load($conf=''){
			return new self($conf);
		}

		/**
		 * 拷貝
		 * @param  string $_list_file     [description]
		 * @param  string $_dest_dir_path [description]
		 * @return integer                [description]
		 */
		public function copy($_list_file='',$_dest_dir_path=''){
			if($_list_file != ''){
				$this->_list_file = $_list_file;
			}
			if($_dest_dir_path != ''){
				$this->_dest_dir_path = $_dest_dir_path;
			}
			if($this->_list_file == '' || $this->_dest_dir_path == ''){
				return StatusCode::ERROR_PARAM_IS_INVALID;
			}
			if(!file_exists($this->_list_file)){
				return StatusCode::ERROR_LIST_FILE_NOT_EXIST;
			}
			if(!is_readable($this->_list_file)){
				return StatusCode::ERROR_LIST_FILE_UNREADABLE;
			}
			$fp = fopen($this->_list_file, "r");
			while(($line=fgets($fp)) != false){
				$line = trim($line);
				$filepath = $this->_root_path.'/'.$line;
				if(!file_exists($filepath)){
					echo 'ERROR file not exist:'.$line.'\n';
					continue;
				}
				$destpath = rtrim($this->_dest_dir_path,"/").'/'.$line;
				$destpath = str_replace("\\", "/", $destpath);
				$dest_dir = rtrim(substr($destpath, 0,strrpos($destpath, "/")),"/").'/';
				// echo $dest_dir;
				// echo $destpath;
				if(!is_dir($dest_dir)){
					mkdir($dest_dir,0444,true);
				}
				copy($filepath, $destpath);
			}
			fclose($fp);
			return StatusCode::SUCCESS;
		}

	}

 ?>