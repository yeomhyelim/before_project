<?
	
	function makeEditLayerFile()
	{
		global $db, $maindesignMgr;

		/* 상품리스트 설정값 호출 */
		$setingRow = $maindesignMgr->getMaindesignList($db);

		
		while($aRow = mysql_fetch_array($setingRow))
		{		
			$intDE_NO				= $aRow[DE_NO];
			$intDE_CODE				= $aRow[DE_CODE];
			$intDE_EDIT_GROUP		= $aRow[DE_EDIT_GROUP];
			$intDE_EDIT_SECTION		= $aRow[DE_EDIT_SECTION];	
			$intDE_EDIT_TEXT		= $aRow[DE_EDIT_TEXT];	
			
			$responseText = "";
			switch($intDE_EDIT_SECTION){

				//메인 페이지 디자인
				case "main":
					$responseText .= $intDE_EDIT_TEXT;
				break;

				//영역별 레이아웃(인크르드 파일 생성)
				case "topArea":
					$responseText .= $intDE_EDIT_TEXT;
				break;

				case "leftArea":
					$responseText .= $intDE_EDIT_TEXT;
				break;

				case "bodyArea":
					$responseText .= $intDE_EDIT_TEXT;
				break;

				case "rightArea":
					$responseText .= $intDE_EDIT_TEXT;
				break;

				case "bottomArea":
					$responseText .= $intDE_EDIT_TEXT;
				break;

				//서브페이지 기본 레이아웃
				case "layout":
					$responseText .= $intDE_EDIT_TEXT;
				break;

				//각 페이지별 레이아웃
				case "prodlist":
					$responseText .= $intDE_EDIT_TEXT;
				break;

				case "prodview":
					$responseText .= $intDE_EDIT_TEXT;
				break;

				case "login":
					$responseText .= $intDE_EDIT_TEXT;
				break;

				case "join":
					$responseText .= $intDE_EDIT_TEXT;
				break;				
			}


			/* make the file */
			$file = "../layout/html/".$intDE_EDIT_GROUP."_".$intDE_EDIT_SECTION.".inc.php";
			@chmod($file,0707);
			$fw = fopen($file, "w");
			fwrite($fw, $responseText);	
			fclose($fw);
			/* 파일 생성 */	

		}//while

		
		
	}
	?>