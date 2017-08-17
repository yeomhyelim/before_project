<?php
    /**
     * /home/shop_eng/www/classes/file/file.handler.class.php
     * @author eumshop(thav@naver.com)
     * file handler class
     * **/

	class FileHandler {

		var $gMimeTypes		= array(
									'png'	=> 'image/png',
									'jpe'	=> 'image/jpeg',
									'jpeg'	=> 'image/jpeg',
									'jpg'	=> 'image/jpeg',
									'gif'	=> 'image/gif',
									'bmp'	=> 'image/bmp',
									'ico'	=> 'image/vnd.microsoft.icon',
									'tiff'	=> 'image/tiff',
									'tif'	=> 'image/tiff',
									'svg'	=> 'image/svg+xml',
									'svgz'	=> 'image/svg+xml',
									'swf'	=> 'application/x-shockwave-flash',
								);

		function __construct() {

		}

		function getMessage() {
			echo "file handler class";
		}

		/**
		 * getFileUpload(&$aryUpLoadInfo)
		 * 클라이언트 파일을($_FILES) 서버로 복사
		 * **/
		function getFileUpload(&$aryUpLoadInfo) {

			$inputName			= $aryUpLoadInfo['F_NAME'];			// input tag name
			$extFilter			= $aryUpLoadInfo['F_FILTER'];		// 업로그 가능한 확장자 설정
			$sPath				= $aryUpLoadInfo['F_SPATH'];		// 서버에 저장할 폴더 경로(절대 경로) // ex. {$this->field['S_DOCUMENT_ROOT']}{$this->field['S_SHOP_HOME']}/upload/community/temp/
			$serverFileName		= $aryUpLoadInfo['F_SFNAME'];		// 파일명( 없는 경우 자동 생성 :년월일시분초_파일명.확장자) 
			$section			= $aryUpLoadInfo['F_SECTION'];		// 파일명 생성시 추가 부분
			$num				= $aryUpLoadInfo['F_NUM'];			// 파일 배열 선택

			if(is_array($_FILES[$inputName]['name'])):
				$error			= $_FILES[$inputName]['error'][$num];
				$tmp_name		= $_FILES[$inputName]['tmp_name'][$num];
				$name			= $_FILES[$inputName]['name'][$num];
			else:
				$error			= $_FILES[$inputName]['error'];
				$tmp_name		= $_FILES[$inputName]['tmp_name'];
				$name			= $_FILES[$inputName]['name'];
			endif;

			if(!$_FILES[$inputName])										{ return -1; } // 업데이트 할 파일이 없으면 return
			if($error != 0)													{ return -2; } // 오류 발생 하면 return
			if(!$this->user_ch_file_extension($tmp_name, $extFilter))		{ return -3; } // 지정된 파일이 아니라면 return
//			if(!$this->user_ch_file_extension2($name, $extFilter))			{ return -3; } // 지정된 파일이 아니라면 return

			/* 파일명 생성 */
			if(!$serverFileName):
				for($i=0;$i<=10;$i++):
					$rand				= rand(1000,9999);//난수(4자리)
					$serverFileName		= date("YmdHis") . "_" . $section . $rand . "_" . $name;
					if(is_file($sPath . $serverFileName)) { continue; }
					$aryUpLoadInfo['F_SFNAME'] = $serverFileName;
					break;
				endfor;
			else:
				/** 2013.04.27 확장자 자동 설정 추가 **/
				$fileinfo			= pathinfo($name);
				$ext				= $fileinfo['extension'];
				
				// 2013.04.30 확장자 체크 
				$fileinfoTemp		= pathinfo($serverFileName);
				if(!$fileinfoTemp['extension']):
				$serverFileName    .= "." . $ext;
				endif;

				$aryUpLoadInfo['F_SFNAME'] = $serverFileName;
				/** 2013.04.27 확장자 자동 설정 추가 **/
			endif;
			/* 파일명 생성 */	

			$re = move_uploaded_file($tmp_name, $sPath . $serverFileName);
			if($re):
				@chmod($sPath . $serverFileName, 0707);
				return $re;
			endif;
			return;
		}

		/**
		 * user_ch_file_extension($tmp_name, $extFilter)
		 * 확장자 체크
		 * ($tmp_name) 파일명의 확장자가 ($extFilter) 포함 되어 있으면 1, 포함 되지 않으면 0
		 * $extFilter 형식은 "jpg;gif;png" 형태로 사용 가능
		 * **/
		function user_ch_file_extension($tmp_name, $extFilter, $num) {
			if($extFilter):
				$strMimeType	= mime_content_type($tmp_name);
				$aryExt			= explode(";", $extFilter);
				foreach($aryExt as $ext):
					if($strMimeType == $this->gMimeTypes[$ext]):
						return 1;
					endif;
				endforeach;
				return;
			endif;
			return 1;
		}

		/**
		 * user_ch_file_extension2($fileName, $extFilter)
		 * 확장자 체크
		 * ($fileName) 파일명의 확장자가 ($extFilter) 포함 되어 있으면 1, 포함 되지 않으면 0
		 * $extFilter 형식은 "jpg;gif;png" 형태로 사용 가능
		 * **/
		function user_ch_file_extension2($fileName, $extFilter) {
			if($extFilter):
				$path		= pathinfo($fileName);		
				$fileExt	= strtolower($path['extension']);	
				$aryExt		= explode(";", $extFilter);
				if(!in_array($fileExt, $aryExt)):
					return;
				endif;
			endif;
			return 1;
		}

		/**
		 * fileWrite($fileName, $data)
		 * 파일에 데이터 쓰기(파일이 없으면 자동 생성)
		 * $fileName 은 절대 경로를 포함한 파일명
		 * **/
		function fileWrite($fileName, $data) {

			if(!$this->makeFile($fileName)) { return; }

			$file = fopen ( $fileName, "w" );

			if ( !$file ) { return; } /* 파일 생성이 안되거나 쓰기 권한이 없는 경우 */
			
			fputs($file, $data);	
		
			fclose($file);

			@chmod( $fileName , 0707 );

			return 1;
		}

		/**
		 * fileDelete($fileName)
		 * 파일 삭제
		 * $fileName 은 절대 경로를 포함한 파일명
		 * **/
		function fileDelete($fileName) {
			if ( file_exists( $fileName ) ) :
				return unlink($fileName);
			endif;
		}

		/**
		 * makeFile($fileName)
		 * 파일 생성
		 * $fileName 은 절대 경로를 포함한 파일명
		 * **/
		function makeFile($fileName) {

			if ( !file_exists( $fileName ) ) :
				$file = fopen ( $fileName, "w" );
				fclose($file);
				@chmod( $fileName , 0707 );
			endif;

			return file_exists( $fileName );
		}


		/**
		 * makeFolder($dir)
		 * 폴더 생성
		 * $dir 은 절대 경로를 포함한 폴더명
		 * **/
		function makeFolder($dir) {
		
			$aryDir		= explode("/",$dir);
			$folder		= "";

			foreach($aryDir as $dirName):
				if(!$dirName) { continue; }
				$folder .= "/" . $dirName;
				if(!is_dir($folder)):
					@mkdir($folder,0707);
					@chmod($folder,0707);
				endif;
			endforeach;

			if(!is_dir($dir)):
				return;
			endif;

			return 1;
		}

		/**
		 * getMadeInfo($fileName, $data, $area)
		 * 설정 파일 만들기
		 * $fileName 은 절대 경로를 포함한 파일명
		 * $data 은 저장할 데이터
		 * $area 저장할 데이터에서 업데이터 할 부분
		 * **/
		function getMadeInfo($fileName, $data, $area) {

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

		function fileContents($fileName) {
			if(file_exists($fileName)):
				return file_get_contents($fileName);
			endif;
		}

		/**
		 * dirDelete($path)
		 * 하위 디렉토리까지 삭제
		 * **/
		function dirDelete($path) {
			$directory			= dir($path); 
			if ( $directory ) :
				while ( $entry = $directory->read() ) :
					if ( $entry != "." && $entry != ".." ) :
		//				echo $path . "/" . $entry . "<br>";
						if ( is_dir ( $path . "/" . $entry ) ) :
							$this->dirDelete ( $path . "/" . $entry ) ;
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
		 * fileList($dir)
		 * 파일 리스트
		 * **/
		function fileList($dir) {
			$fileList = scandir($dir) or die("scandir failed");
			foreach ($fileList as $file):
				if( is_file("$dir/$file") && $file != '.' && $file != '..'):
					$aryFile[] = $file;
				endif;
			endforeach;

			return $aryFile;
		}
	}


?>
