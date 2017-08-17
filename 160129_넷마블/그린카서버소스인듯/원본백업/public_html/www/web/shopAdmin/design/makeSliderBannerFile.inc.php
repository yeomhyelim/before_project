<?
	
	function makeSliderBannerFile()
	{

		global $db, $sliderbannerMgr;

		/* 기본 설정값 호출 */

		$sbRow = $sliderbannerMgr->getSliderView($db);
		
			

			$intSB_NO				= $sbRow[SB_NO];
			$intSB_GROUP			= $sbRow[SB_GROUP];
			$intSB_IMAGE_FILE_1		= $sbRow[SB_IMAGE_FILE_1];
			$intSB_IMAGE_FILE_2		= $sbRow[SB_IMAGE_FILE_2];
			$intSB_IMAGE_FILE_3		= $sbRow[SB_IMAGE_FILE_3];
			$intSB_IMAGE_FILE_4		= $sbRow[SB_IMAGE_FILE_4];
			$intSB_IMAGE_FILE_5		= $sbRow[SB_IMAGE_FILE_5];
			$intSB_IMAGE_FILE_6		= $sbRow[SB_IMAGE_FILE_6];
			$intSB_IMAGE_FILE_7		= $sbRow[SB_IMAGE_FILE_7];
			$intSB_IMAGE_FILE_8		= $sbRow[SB_IMAGE_FILE_8];
			$intSB_IMAGE_FILE_9		= $sbRow[SB_IMAGE_FILE_9];
			$intSB_IMAGE_FILE_10	= $sbRow[SB_IMAGE_FILE_10];

			$responseText .= "<img id='slide-img-1' src='/upload/slider/".$intSB_IMAGE_FILE_1."'  class='slide'/>\n";
			$responseText .= "<img id='slide-img-2' src='/upload/slider/".$intSB_IMAGE_FILE_2."'  class='slide'/>\n";
			$responseText .= "<img id='slide-img-3' src='/upload/slider/".$intSB_IMAGE_FILE_3."'  class='slide'/>\n";
			$responseText .= "<img id='slide-img-4' src='/upload/slider/".$intSB_IMAGE_FILE_4."'  class='slide'/>\n";
			$responseText .= "<img id='slide-img-5' src='/upload/slider/".$intSB_IMAGE_FILE_5."'  class='slide'/>\n";






		/* make the file */
		$file = "../layout/slider/slider_banner.inc.php";
		@chmod($file,0707);
		$fw = fopen($file, "w");
		fwrite($fw, $responseText);	
		fclose($fw);
		/* 파일 생성 */			
		
	}
	?>