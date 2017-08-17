<?php
    /**
     * /home/shop_eng/www/classes/file/FileDevice.class.php
     * @author eumshop(thav@naver.com)
     * file Device class
	 * $file = new FileDevice();	
     */
	class FileDevice {
		/**
		 * __construct()
		 * 생성자
		 */
		function __construct() {

		}
		/**
		 * makeFile($fileName)
		 * 파일 생성
		 * $fileName 은 절대 경로를 포함한 파일명
		 */
		static function makeFile($fileName) {

			if(!file_exists($fileName)) {
				$fileName = str_replace('/',DIRECTORY_SEPARATOR, $fileName);

				$file				= fopen($fileName, "w");
				fclose($file);
				@chmod( $fileName , 0707 );
			}

			return file_exists( $fileName );
		}
		/**
		 * FileDevice::makeFolder($dir)
		 * 폴더 생성
		 * $dir 은 절대 경로를 포함한 폴더명
		 */
		static function makeFolder($dir) {
			if(!$dir) return false;

			$dir = str_replace('/',DIRECTORY_SEPARATOR,$dir);

			## 폴더가 존재하면 종료
			if(is_dir($dir)) {
				return true;
			}else{
				@mkdir($dir,0707,true);
				@chmod($dir,0707);
			}


//			## 기본 설정
//			$aryDir		= explode("/",$dir);
//			$folder		= "";
//
//			## 폴더 검색 및 생성
//			foreach($aryDir as $dirName) {
//				if(!$dirName) { continue; }
//				$folder = "{$folder}/{$dirName}";
//				if(!is_dir($folder)) {
//					@mkdir($folder,0707);
//					@chmod($folder,0707);
//				}
//			}


			## 폴더가 존재하면 종료
			if(is_dir($dir)) { return 1; }

			## 폴더가 없으면 종료
			return false;
		}
		/**
		 * FileDevice::getUniqueFileName($strDir, $strParam)
		 * 유니크한 파일명 만들기
		 * $strDir 은 절대 경로를 포함한 폴더명
		 * $strFormat 은 파일명,%s가 포함되어 중복시 증가값으로 설정
		 */
		static function getUniqueFileName($strDir, $strFormat) {

			for($i=0;$i<=100;$i++) {
				$strTemp	= sprintf($strFormat, $i);
				if(!is_file("{$strDir}/{$strTemp}")) {
					return $strTemp;
				}
			}

			return;
		}
		/**
		 * FileDevice::upload($strInputName, $strSaveFileName)
		 * 파일 업로드
		 * $strInputName		: input name
		 * $strSaveFileName		: 서버에 저장할 파일명(절대경로 포함).
		 */
		static function upload($strInputName, $strSaveFileName) {

			## 기본 설정
			$strTmpName			= $_FILES[$strInputName]['tmp_name'];

			## 파일 업로드
			$re = move_uploaded_file($strTmpName, $strSaveFileName);
			if(!$re) { return; }

			## 권한 설정
			@chmod($strSaveFileName, 0707);
			
			## 마무리
			return 1;
		}
		/**
		 * FileDevice::fileWrite($fileName, $data)
		 * 파일에 데이터 쓰기(파일이 없으면 자동 생성)
		 * $fileName 은 절대 경로를 포함한 파일명
		 * **/
		static function fileWrite($fileName, $data) {

			if(!FileDevice::makeFile($fileName)) { return; }

			$file = fopen ( $fileName, "w" );

			if ( !$file ) { return; } /* 파일 생성이 안되거나 쓰기 권한이 없는 경우 */
			
			fputs($file, $data);	
		
			fclose($file);

			@chmod( $fileName , 0707 );

			return 1;
		}
		/**
		 * FileDevice::fileDelete($fileName)
		 * 파일 삭제
		 * $fileName 은 절대 경로를 포함한 파일명
		 * **/
		static function fileDelete($strFileName) {

			if (file_exists($strFileName)) { return unlink($strFileName); }
		}
		/**
		 * fileList($dir)
		 * 파일 리스트
		 * **/
		function fileList($dir, $type="file") {
			$fileList = scandir($dir) or die("scandir failed");
			foreach ($fileList as $file):
				if($file == '.' || $file == '..') { continue; }
				if($type == "file" && is_file("$dir/$file")) { $aryFile[] = $file; }
				else if($type == "dir" && is_dir("$dir/$file")) { $aryFile[] = $file; }
				else if($type == "both") { $aryFile[] = $file;  }
			endforeach;

			return $aryFile;
		}
		/**
		 * FileDevice::getMadeInfo($fileName, $data, $area)
		 * 설정 파일 만들기
		 * $fileName 은 절대 경로를 포함한 파일명
		 * $data 은 저장할 데이터
		 * $area 저장할 데이터에서 업데이터 할 부분
		 * **/
		static function getMadeInfo($fileName, $data, $area) {

			## STEP 1.
			## 파일 있는지 체크하고 없으면 생성
			if(!FileDevice::makeFile($fileName)) { return; }

			## STEP 2.
			## 파일 내용 가져오기.
			$fileData	= file_get_contents($fileName);
			$data		= "{$area}\n{$data}\n{$area}";

			if($fileData):
				$fileData		= str_replace("\r\n","\n",$fileData);
				$fileData		= str_replace("<?\n","",$fileData);
				$fileData		= str_replace("\n?>\n","",$fileData);
				$aryFileData	= explode($area, $fileData);
				if(sizeof($aryFileData) == 1) { $data = "\n{$data}"; }
				$aryFileData[1]	= $data;
				$data			= implode($aryFileData);
			endif;	
	
			## STEP 3.
			## 파일 내용 저장.			
			$data		= str_replace("\r\n","\n",$data);
			$data			= "<?\n{$data}\n?>\n";
			FileDevice::fileWrite($fileName, $data);

			return 1;
		}
		/**
		 * FileDevice::getContents($fileName)
		 * 파일 내용 가져오기
		 * $fileName 은 절대 경로를 포함한 파일명
		 * **/
		static function getContents($fileName) {
			
			if(!is_file($fileName)) { return; }

			return file_get_contents($fileName);
		}
		/**
		 * FileDevice::getCopyDir($source_dir, $target_dir, $filter = null, $type = null)
		 * 파일 하위 디렉토리까지
		 * **/
		static function getCopyDir($source_dir, $target_dir, $filter = null, $type = null)
		{
			## 파일 체크
			if(!is_dir($source_dir))
			{
				return;
			}

			// generate when no target exists
			self::makeFolder($target_dir);

			if(substr($source_dir, -1) != DIRECTORY_SEPARATOR)
			{
				$source_dir .= DIRECTORY_SEPARATOR;
			}

			if(substr($target_dir, -1) != DIRECTORY_SEPARATOR)
			{
				$target_dir .= DIRECTORY_SEPARATOR;
			}

			$oDir = dir($source_dir);
			while($file = $oDir->read())
			{
				if($file{0} == '.')
				{
					continue;
				}

				if($filter && preg_match($filter, $file))
				{
					continue;
				}

				if(is_dir($source_dir . $file))
				{
					self::getCopyDir($source_dir . $file, $target_dir . $file, $type);
				}
				else
				{
					if($type == 'force')
					{
						@unlink($target_dir . $file);
					}
					else
					{
						if(!file_exists($target_dir . $file))
						{
							@copy($source_dir . $file, $target_dir . $file);
							@chmod($target_dir . $file, 0707);
						}
					}
				}
			}
			$oDir->close();

			return true;
		}

		/**
		 * FileDevice::dirDelete($path)
		 * 하위 디렉토리까지 삭제
		 * **/
		static function dirDelete($path) 
		{
			$directory			= dir($path); 
			if ( $directory ) :
				while ( $entry = $directory->read() ) :
					if ( $entry != "." && $entry != ".." ) :
		//				echo $path . "/" . $entry . "<br>";
						if ( is_dir ( $path . "/" . $entry ) ) :
							FileDevice::dirDelete ( $path . "/" . $entry ) ;
						else :
							unLink ( $path . "/" . $entry );
						endif;
					endif;
				endwhile;
				$directory->close();
				rmdir($path);
			endif;
		}

		/**
		 * FileDevice::orderWriteLog($data)
		 * 하위 디렉토리까지 삭제
		 * **/	
		static function orderWriteLog($aryData, $strTailFile = '_order')
		{
			if(!$aryData) return;
			if(!is_array($aryData)) $aryData = array($aryData);

			$fileName = rtrim(MALL_SHOP, '/') . '/logs/' . date("Ymd") . $strTailFile . '.log';

			if(!FileDevice::makeFile($fileName)) { return; }

			$file = fopen ( $fileName, "a" );

			if ( !$file ) { return; } /* 파일 생성이 안되거나 쓰기 권한이 없는 경우 */
			
			fputs($file, "[" . date('Y-m-d H:i:s') . "][start]------------------------------------\n");
			
			foreach($aryData as $key => $data):
				fputs($file, $data . "\n");
			endforeach;
			
			fputs($file, "[" . date('Y-m-d H:i:s') . "][end]------------------------------------\n");
				
			fputs($file, "\n");	
			fclose($file);

			@chmod( $fileName , 0707 );

			return 1;
		}

		/**
		 * FileDevice::my_mime_content_type($filename)
		 * mime_content_type
		 * **/
		static function my_mime_content_type($filename) {

			$mime_types = array(

				'txt' => 'text/plain',
				'htm' => 'text/html',
				'html' => 'text/html',
				'php' => 'text/html',
				'css' => 'text/css',
				'js' => 'application/javascript',
				'json' => 'application/json',
				'xml' => 'application/xml',
				'swf' => 'application/x-shockwave-flash',
				'flv' => 'video/x-flv',

				// images
				'png' => 'image/png',
				'jpe' => 'image/jpeg',
				'jpeg' => 'image/jpeg',
				'jpg' => 'image/jpeg',
				'gif' => 'image/gif',
				'bmp' => 'image/bmp',
				'ico' => 'image/vnd.microsoft.icon',
				'tiff' => 'image/tiff',
				'tif' => 'image/tiff',
				'svg' => 'image/svg+xml',
				'svgz' => 'image/svg+xml',

				// archives
				'zip' => 'application/zip',
				'rar' => 'application/x-rar-compressed',
				'exe' => 'application/x-msdownload',
				'msi' => 'application/x-msdownload',
				'cab' => 'application/vnd.ms-cab-compressed',

				// audio/video
				'mp3' => 'audio/mpeg',
				'qt' => 'video/quicktime',
				'mov' => 'video/quicktime',

				// adobe
				'pdf' => 'application/pdf',
				'psd' => 'image/vnd.adobe.photoshop',
				'ai' => 'application/postscript',
				'eps' => 'application/postscript',
				'ps' => 'application/postscript',

				// ms office
				'doc' => 'application/msword',
				'rtf' => 'application/rtf',
				'xls' => 'application/vnd.ms-excel',
				'ppt' => 'application/vnd.ms-powerpoint',

				// open office
				'odt' => 'application/vnd.oasis.opendocument.text',
				'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
			);

			$ext = strtolower(array_pop(explode('.',$filename)));
			if (array_key_exists($ext, $mime_types)) {
				return $mime_types[$ext];
			}
			elseif (function_exists('finfo_open')) {
				$finfo = finfo_open(FILEINFO_MIME);
				$mimetype = finfo_file($finfo, $filename);
				finfo_close($finfo);
				return $mimetype;
			}
			else {
				return 'application/octet-stream';
			}
		}
	}

