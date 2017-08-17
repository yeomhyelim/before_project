<?
	DEFINE('TRACE_LEVEL_NORM', 100, true);								// 함수 시작과 종료 로그 (정상)
	DEFINE('TRACE_LEVEL_FAIL', 105, true);									// 함수 시작과 종료 로그 (실패)
	DEFINE('TRACE_LEVEL_DEFAULT', 0, true);
	DEFINE('TRACE_HTML_CODE', 200, true);								// SNOOPY 사용 후 HTML 스크립트
	

	DEFINE('TRACE_LEVEL_PREG_MATCH_ALL'							,  500, true);
	DEFINE('TRACE_LEVEL_STRIPTEXT'										,  510, true);
	DEFINE('TRACE_LEVEL_EREG_REPLACE'								,  520, true);
	DEFINE('TRACE_LEVEL_SPLIT'											,  530, true);
	DEFINE('TRACE_LEVEL_R_L_TRIM_EX'									,  540, true);
	DEFINE('TRACE_LEVEL_SAVE_DATA_IN_ARRAY'					,  550, true);
	DEFINE('TRACE_LEVEL_SIZE_OF'											,  560, true);
	DEFINE('TRACE_LEVEL_PLUS'												,  570, true);
	DEFINE('TRACE_LEVEL_ADD_DATA_IN_ARRAY'					,  580, true);
	DEFINE('TRACE_LEVEL_ADD_STRING_FRONT'						,  590, true);
	DEFINE('TRACE_LEVEL_ADD_ARRAY_FRONT'						,  600, true);
	DEFINE('TRACE_LEVEL_PI_NAME'										,  610, true);
	DEFINE('TRACE_LEVEL_HTTP_URL_A'									,  620, true);
	


	class HS_Trace
	{
		private $path =  "/scraping/log/log.txt";

		public function HS_Trace()
		{
			$this->path = MALL_HOME . $this->path;
		}

		public function trace($txt,  $level = 1)
		{
			if($level == 0) { return; }
//			if($level >= 500 && $level <= 600) { return; }

			$this->setFileWrite($type, $txt);
		}

		/* write the txt in log file */
		private function setFileWrite($type, $txt)
		{
			$fp = fopen($this->path, "a+");
			
			if(!$fp) 
			{
				echo "Error! Can't make the file";
				return;
			}

			$msg =  sprintf("[%s][%s][%s] %s\n", date("Y-m-d H:i:s"), $this->getFileName(), $type, $txt);

			fwrite($fp, $msg);

			fclose($fp);

			return;
		}


	##############################################################
	# 
	# 
	##############################################################
		private $fileName = "";
		private function getFileName()
		{
			if($this->fileName == "")	{			$result = $_SERVER[PHP_SELF];						}
			else								{			$result = $this->fileName;								}
			return $result;
		}

		public function setFileName($name)	{			$this->fileName = $name;					}

	}

?>

