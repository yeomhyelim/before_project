<?
	
	function makeDesignFirstFile()
	{
		global $db, $designMgr;

		$dlRow = $designMgr->getDesignLayoutView($db);

		$responseText .= "<? \n \n";
		$responseText .= "	/**** 기본 디자인 설정값 *********************/\n";
		$responseText .= "\$D_LAYOUT		= \"" . $dlRow['DL_CODE'] . "\";							//레이아웃\n";
		$responseText .= "\$D_SKIN			= \"" . $dlRow['DL_DESIGN_CODE'] . "\";				//스킨정보\n";
		$responseText .= "\n";
		$responseText .= "\n";  
		$responseText .= "\$D_LAYOUT_FIRST_PAGE		= \"" . $dlRow['DL_FIRST_PAGE'] . "\";			//첫 페이지 구성(일반/폐쇠/성인)\n";
		$responseText .= "\$D_LAYOUT_FIRST_USE			= \"" . $dlRow['DL_FIRST_USE'] . "\";			//인트로 사용여부\n";		
		$responseText .= "\n";  
		$responseText .= "\$D_LAYOUT_BG_CSS				= \"style=\\\"background: " . $dlRow['DL_BG_COLOR'];
		$responseText .=  $dlRow['DL_BG_IMAGE'] == "" ?  "" : " url(" . $dlRow['DL_BG_IMAGE'] . ")";
		$responseText .= " " . $dlRow['DL_BG_IMG_DIR_H'] . " " . $dlRow['DL_BG_IMG_DIR_V'] . " " . $dlRow['DL_BG_REPEAT'] . "\\\"\"  //배경 CSS \n\n";
		$responseText .= "?>";

		/* make the file */
		$file = "../conf/layout.inc.php";
		@chmod($file,0707);
		$fw = fopen($file, "w");
		fwrite($fw, $responseText);	
		fclose($fw);
		/* 파일 생성 */	
		
	}

?>