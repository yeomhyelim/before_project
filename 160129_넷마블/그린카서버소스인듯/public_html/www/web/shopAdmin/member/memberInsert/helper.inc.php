<?

	/*##################################### Parameter 셋팅 #####################################*/
	/*##################################### Parameter 셋팅 #####################################*/
	switch($strMode){
		case "memberInsertWrite":
			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "";
			$strLeftMenuCode02 = "";
			/* 관리자 Sub Menu 권한 설정 */

			$aryHp		= getCommCodeList("HP");
			$aryPhone	= getCommCodeList("PHONE");
			$aryJob		= getCommCodeList("JOB");
			$aryConcern	= getCommCodeList("CONCERN");

			/* 국가 리스트 */
			if ($S_SITE_LNG != "KR"){
				$aryCountryList		= getCountryList();			
				$aryCountryState	= getCommCodeList("STATE","");
			}		

		break;
	}
?>