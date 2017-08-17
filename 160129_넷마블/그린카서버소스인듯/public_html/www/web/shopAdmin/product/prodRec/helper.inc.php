<?
	require_once MALL_CONF_LIB."CateMgr.php";
	
	$cateMgr = new CateMgr();		


	switch($strMode){

		case "prodRecList":

			/* 리스트 페이지 라인 쿠키 설정 */
			if (!$intPageLine){
				$intPageLine = $_COOKIE["COOKIE_ADM_PROD_REC_LINE"] ? $_COOKIE["COOKIE_ADM_PROD_REC_LINE"] : 50;
			} else {
				setCookie("COOKIE_ADM_PROD_REC_LINE",$intPageLine,time()+(86400 * 30),"/shopAdmin");
			}
			/* 리스트 페이지 라인 쿠키 설정 */

			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "";
			$strLeftMenuCode02 = "";
			/* 관리자 Sub Menu 권한 설정 */
		
			include $strIncludePath.$aryIncludeFolder[$strMode]."/helper.prodRecList.".$strProductVersion.".inc.php";
		break;
	}
?>
