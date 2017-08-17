<?php
    /**
     * /home/shop_eng/www/classes/image/image.func.class.php
     * @author eumshop(thav@naver.com)
     * image func class
     * **/

//	require_once "{$S_DOCUMENT_ROOT}www/classes/file/file.handler.class.php";

	class ImageFunc {

		function __construct() {
			
		}

		function getMessage() {
			echo "image func class";
		}

		/**
		 * getImageResize($filename, $newFilename, $sizeW, $sizeH )
		 * 이미지 사이즈 변경후 저장
		 * **/
		function getImageResize($filename, $newFilename, $sizeW, $sizeH ) {

			## STEP 1.
			## 이미지 정보 가져오기.
//			$strMimeType			= mime_content_type($filename);	/** 2013.11.25 kim hee sung 특정 서버에서 작동 안됨. **/
			$aryImageInfo			= getimagesize($filename);	
			if(!$aryImageInfo) { return; }

			$strMimeType			= $aryImageInfo['mime'];						
			list($width, $height)	= getimagesize($filename);
			$newImgBuffer			= imagecreatetruecolor($sizeW, $sizeH);
			if($strMimeType == "image/gif")			{ $source = imagecreatefromgif($filename); }
			else if($strMimeType == "image/jpeg")	{ $source = imagecreatefromjpeg($filename); }
			else if($strMimeType == "image/png")	{ $source = imagecreatefrompng($filename); }
			else									{ return; }	

			## STEP 2.
			## 이미지 리사이즈
			//imagecopyresized($newImgBuffer, $source, 0, 0, 0, 0, $sizeW, $sizeH, $width, $height);
			imagecopyresampled($newImgBuffer, $source, 0, 0, 0, 0, $sizeW, $sizeH, $width, $height);

			## STEP 3.
			## 이미지 생성
			if($strMimeType == "image/gif")			{ imagegif($newImgBuffer, $newFilename, 100); }
			else if($strMimeType == "image/jpeg")	{ imagejpeg($newImgBuffer, $newFilename, 100); }
			else if($strMimeType == "image/png")	{ imagejpeg($newImgBuffer, $newFilename, 100); }
			else									{ return; }

			## STEP 4.
			## free from memory
			imagedestroy($newImgBuffer);

			return 1;
		}

		/**
		 * getImageSizeRate($fileName, $sizeW, $sizeH)
		 * 이미지 사이즈, 비율 변경 후 리턴
		 * **/
		function getImageSizeRate($fileName, $sizeW, $sizeH) {

			list($width, $height)	= getimagesize($fileName);
			$x_ratio				= $sizeW / $width;
			$y_ratio				= $sizeH / $height;

			if(($width <= $sizeW) && ($height <= $sizeH)):
				$sizeW = $width;
				$sizeH = $height;
			elseif(($x_ratio*$height) < $sizeH):
				$sizeH = ceil($x_ratio * $height);
				$sizeW = $sizeW;
			else:
				$sizeW = ceil($y_ratio * $width);
				$sizeH = $sizeH;
			endif;

			return array($sizeW, $sizeH);
		}

		/**
		 * getFindImage($fileName)
		 * 확장자 제거하고 jpg, png, gif 확장자 이미지 검색 후, 있으면 해당 확장자 리턴
		 * **/
		function getFindImage($fileName) {
			$fileInfo			= pathinfo($fileName);
			$ext				=$fileInfo['extension'];
			if(!$ext) { return; }
			$fileInfo['name']	= str_replace(".{$ext}", "", $fileInfo['basename']);
			$checkFile			= "{$fileInfo['dirname']}/{$fileInfo['name']}.jpg";
			if(is_file($checkFile)){ return "jpg"; }
			$checkFile			= "{$fileInfo['dirname']}/{$fileInfo['name']}.gif";
			if(is_file($checkFile)){ return "gif"; }
			$checkFile			= "{$fileInfo['dirname']}/{$fileInfo['name']}.png";
			if(is_file($checkFile)){ return "png"; }

//			$checkFile			= "{$fileInfo['dirname']}/{$fileInfo['name']}.JPG";
//			if(is_file($checkFile)){ return "JPG"; }
//			$checkFile			= "{$fileInfo['dirname']}/{$fileInfo['name']}.GIF";
//			if(is_file($checkFile)){ return "GIF"; }
//			$checkFile			= "{$fileInfo['dirname']}/{$fileInfo['name']}.PNG";
//			if(is_file($checkFile)){ return "PNG"; }
		}

		/**
		 * getPathInfo($fileName)
		 * 파일 정보 가져오기
		 * **/
		function getPathInfo($fileName) {
			$fileInfo			= pathinfo($fileName);
			$ext				=$fileInfo['extension'];
			$fileInfo['name']	= str_replace(".{$ext}", "", $fileInfo['basename']);
			return $fileInfo;
		}
	}


?>
