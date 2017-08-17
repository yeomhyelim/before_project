<?
	$result_array = array();
	/*##################################### Parameter 셋팅 #####################################*/
	$strJsonMode					= $_POST["jsonMode"]							? $_POST["jsonMode"]					: $_REQUEST["jsonMode"];

	$strDM_DESIGN_TYPE			= $_POST["dm_design_type"]					? $_POST["dm_design_type"]			: $_REQUEST["dm_design_type"];				// 타입코드(DESIGN_MGR)
	$strDM_DESIGN_GROUP		= $_POST["dm_design_group"]					? $_POST["dm_design_group"]			: $_REQUEST["dm_design_group"];				// 디자인 그룹(DESIGN_MGR)
	
	$strBI_GROUP 					= $_POST["bi_group"]							? $_POST["bi_group"]					: $_REQUEST["bi_group"];						// 디자인 그룹(DESIGN_BTN_IMAGES)
	
	/* 카테고리 */
	$intC_LEVEL					= $_POST["cateLevel"]							? $_POST["cateLevel"]					: $_REQUEST["cateLevel"];
	$strC_HCODE					= $_POST["cateHCode"]							? $_POST["cateHCode"]					: $_REQUEST["cateHCode"];
	$strC_VIEW_YN					= $_POST["cateView"]							? $_POST["cateView"]					: $_REQUEST["cateView"];	
	
	$intC_LEVEL					= IM_IsBlank($intC_LEVEL,"1");
	$strC_VIEW_YN					= IM_IsBlank($strC_VIEW_YN,"N");
	/* 카테고리 */
	/*##################################### Parameter 셋팅 #####################################*/

	/* TEST */
//	$result[0][RET]			= "Y";
//	$result[0][MSG]		= $strC_HCODE;
//	$strJsonMode			= "!";
	/* TEST */
	
	switch ( $strJsonMode )		{
		case "cateLevelList":
		// 디자인관리 / 서브탑이미지 -> 등록하기 버튼 글릭시
		// 카테고리 선택시 해당 부모의 자식 카테고리 변경
		
			$cateMgr->setC_LEVEL($intC_LEVEL);
			$cateMgr->setC_HCODE($strC_HCODE);
			$cateMgr->setC_VIEW_YN($strC_VIEW_YN);
			$result = $cateMgr->getCateLevelAry($db);
		break;
					
		case "designTypeChange":
		// 관리자 페이지 / 디자인 관리 / 레이아웃 설정 -> 타입 변경시
		// 해당하는 타입의 샘플 이미지 파일을 반환

			$designMgr->setDM_DESIGN_GROUP($strDM_DESIGN_GROUP);
			$designMgr->setDM_DESIGN_TYPE($strDM_DESIGN_TYPE);
			$sampleRow = $designMgr->getDesignMgrList($db);

			$i = 0;
			while($row = mysql_fetch_array($sampleRow))		{
				if ( $row[DM_SAMPLE_IMAGE_1] ){
					$result[$i][DM_SAMPLE_IMAGE_1]					= DESIGN_LAYOUT_HOME . $row[DM_SAMPLE_IMAGE_1];
					$result[$i][DM_DESIGN_TYPE]						= $row[DM_DESIGN_TYPE];
					$result[$i][DM_DESIGN_CODE]						= $row[DM_DESIGN_CODE];
					$i++;
				}
			}

			if ( $i <= 0 ) {
				$result[0][RET]		= "N";
			} else {
				$result[0][RET]		= "Y";
			}

		break;
		
		case "imageListRefresh":
		// 디자인관리 / 이미지관리 / 커뮤니티 => 디자인선택 버튼 클릭으로 새창 뛰어서 선택된 값 리턴시 수행
		// 리턴받은 값(버튼 그룹)에 해당하는 이미지 리스트 그리기 

			// 이미지 그룹 ID 저장
			$designMgr->setDM_DESIGN_GROUP($strDM_DESIGN_GROUP);
			$designMgr->setBI_GROUP($strBI_GROUP);
			$designMgr->getDesignLayoutIDUpdate($db);
			
			// 이미지 그룹 이름 가져오기
//			$designMgr->setDM_NO($strBI_GROUP);
//			$designRow 				= $designMgr->getDesignMgrView($db);
						
			/* 페이지 시작 시점 지정 및 리스트 개수 지정  */
			$intPageBlock				= 10;
			$intPageLine				= 20;
				
			$designMgr->setPageLine($intPageLine);
				
			$designMgr->setBI_GROUP($strBI_GROUP);
				
			$intTotal 					= $designMgr->getDesignBtnImageTotal($db);
			
			$intTotPage				= ceil($intTotal / $designMgr->getPageLine());
				
			$intPage					= (!$intPage) ? 1 : $intPage;
				
			if ($intTotal==0) :
				$intFirst				= 1;
				$intLast				= 0;
			else :
				$intFirst				= $intPageLine * ($intPage - 1);
				$intLast				= $intPageLine * $intPage;
			endif;
				
			$designMgr->setLimitFirst($intFirst);
			/* 페이지 시작 시점 지정 및 리스트 개수 지정  */
			
			$resultRow					= $designMgr->getDesignBtnImageList($db);
			$intListNum 				= $intTotal - ($intPageLine *($intPage-1));
														
			$responseText 		= "<table>\n";
			$responseText		.= "<colgroup>\n";
			$responseText		.= "<col style=\"width:50px;\"/>\n";
			$responseText		.= "<col style=\"width:200px;\"/>\n";
			$responseText		.= "<col />\n";
			$responseText		.= "<col style=\"width:200px;\" />\n";
			$responseText		.= "</colgroup>\n";
			$responseText		.= "<tr>\n";
			$responseText		.= "<th>번호</th>\n";
			$responseText		.= "<th>타입</th>\n";
			$responseText		.= "<th>이미지(한국어)</th>\n";
			$responseText		.= "<th>관리</th>\n";
			$responseText		.= "</tr>\n";
			
			if($intTotal=="0") :
				$responseText		.= "<tr>\n";
				$responseText		.= "<td colspan=\"4\">등록된 데이터가 없습니다.</td>\n";
				$responseText		.= "</tr>\n";
			endif;
			
			while($row = mysql_fetch_array($resultRow)) :
				if ( $row['BI_IMAGE_FILE_1'] ) :
					$strBI_IMAGE_FILE_1 		= "<img src='"  . "/upload/communitybtnimg/" . $row['BI_IMAGE_FILE_1'] . "' />";
				endif;
			
				$responseText		.= "<tr>\n";
				$responseText		.= "<td>" . $intListNum . "</td>\n";
				$responseText		.= "<td>" . $row['BI_IMAGE_GUBUN'] . "</td>\n";
				$responseText		.= "<td>" . $strBI_IMAGE_FILE_1 . "</td>\n";
				$responseText		.= "<td>\n";
				$responseText 		.= "<a class=\"btn_blue_sml\" href=\"javascript:goMoveUrl('imgStyle2Modify', " .  $row['BI_NO'] . ")\"  ><strong>수정</strong></a>";
				$responseText 		.= "<a href=\"javascript:goMoveUrl('imgStyle2Delete', " . $row['BI_NO'] . ")\" class=\"btn_sml\"><strong>삭제</strong></a>";
				$responseText		.= "</td>\n";
				$responseText		.= "</tr>\n";	
				$intListNum--;
			endwhile;
			
			$responseText		.= "</table>\n";
				
					
			$result[0][DATA_LIST] 						= $responseText;
			$result[0][BI_GROUP_TEMP]				= $strBI_GROUP; 
//			$result[0][DM_DESIGN_TITLE]				= $designRow['DM_DESIGN_TITLE'];
			

		
		break;
		
		default :
			$result[0][RET]			= "N";
			$result[0][MSG]		= "등록된 jsonMode 값이 없습니다.";		
	}



	$db->disConnect();
	$result_array = json_encode($result);
	echo $result_array;			
?>