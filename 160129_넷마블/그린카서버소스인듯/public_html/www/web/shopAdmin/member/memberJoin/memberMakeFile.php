<?
	$strMakeFileText  = "";
	
	$aryUseLng = explode("/",$S_USE_LNG);
	$aryItemList = $memberMgr->getJoinItemList($db);
	if (is_array($aryItemList)){
		for($i=0;$i<sizeof($aryItemList);$i++){

			$strJoinUse		= ($aryItemList[$i][JI_USE]=="N") ? "N":"Y";
			$strJoinGrade	= $aryItemList[$i][JI_GRADE];
			
			if ($strJoinGrade){
				$aryJoinGrade = explode("/",$strJoinGrade);
				
				$strJoinGradeArrList = "";
				for($k=0;$k<sizeof($aryJoinGrade);$k++){
					$strJoinGradeArrList .= "'".$aryJoinGrade[$k]."',";
				}
				
				$strJoinGrade = SUBSTR($strJoinGradeArrList,0,STRLEN($strJoinGradeArrList)-1);
			}
			
			if ($aryItemList[$i][JI_USE] == "N"){
				$aryItemList[$i][JI_JOIN] = "N";
				$aryItemList[$i][JI_MYPAGE] = "N";
			}
			
			$strMakeFileText .= "/* ".$aryItemList[$i][JI_NAME]." 항목 설정 */ \n";
			$strMakeFileText .= "\$S_JOIN_".$aryItemList[$i][JI_CODE]."[\"NES\"] = \"".$aryItemList[$i][JI_NES]."\"; \n";
			$strMakeFileText .= "\$S_JOIN_".$aryItemList[$i][JI_CODE]."[\"TYPE\"] = \"".$aryItemList[$i][JI_TYPE]."\"; \n";
			$strMakeFileText .= "\$S_JOIN_".$aryItemList[$i][JI_CODE]."[\"TYPE_VAL\"] = \"".$aryItemList[$i][JI_TYPE_VAL]."\"; \n";
			$strMakeFileText .= "\$S_JOIN_".$aryItemList[$i][JI_CODE]."[\"JOIN\"] = \"".$aryItemList[$i][JI_JOIN]."\"; \n";
			$strMakeFileText .= "\$S_JOIN_".$aryItemList[$i][JI_CODE]."[\"MYPAGE\"] = \"".$aryItemList[$i][JI_MYPAGE]."\"; \n";
			$strMakeFileText .= "\$S_JOIN_".$aryItemList[$i][JI_CODE]."[\"USE\"] = \"".$strJoinUse."\"; \n";
			
			/*나라별 항목명 */
			for($j=0;$j<sizeof($aryUseLng);$j++){			
				$strMakeFileText .= "\$S_JOIN_".$aryItemList[$i][JI_CODE]."[\"NAME_".$aryUseLng[$j]."\"] = \"".$aryItemList[$i]["JI_NAME_".$aryUseLng[$j]]."\"; \n";
			}

			if ($strJoinGrade) {
				$strMakeFileText .= "\$S_JOIN_".$aryItemList[$i][JI_CODE]."[\"GRADE\"] = array(".$strJoinGrade."); \n";
			} else {
				$strMakeFileText .= "\$S_JOIN_".$aryItemList[$i][JI_CODE]."[\"GRADE\"] = \"\"; \n";
			}
		}
	}
	
	$strMakeFileText = "<?\n".$strMakeFileText."?>\n";
	$file = "../conf/member.inc.php";
	@chmod($file,0755);
	$fw = fopen($file, "w");
	fputs($fw,$strMakeFileText, strlen($strMakeFileText));
	fclose($fw);
?>