<?
	require_once MALL_CONF_LIB."ProductAdmMgr.php";
	
	$productMgr = new ProductAdmMgr();
	
	/*##################################### Parameter 셋팅 #####################################*/
	$strSearchField = $_POST["searchField"]		? $_POST["searchField"]		: $_REQUEST["searchField"];
	$strSearchKey	= $_POST["searchKey"]		? $_POST["searchKey"]		: $_REQUEST["searchKey"];
	$intPage		= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];
	$intPageLine	= $_POST["pageLine"]		? $_POST["pageLine"]		: $_REQUEST["pageLine"];

	$intPR_NO		= $_POST["brandNo"]			? $_POST["brandNo"]			: $_REQUEST["brandNo"];	
	/*##################################### Parameter 셋팅 #####################################*/

	switch ($strMode){

		case "prodBrandList":

			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "004";
			$strLeftMenuCode02 = "001";
			/* 관리자 Sub Menu 권한 설정 */

			/* 데이터 리스트 */
			$intTotal								= $productMgr->getProdBrandList( $db, "OP_COUNT" );								// 데이터 전체 개수 
	
			$intPageLine							= 5;																				// 리스트 개수 
			$intPage								= ( $intPage )				? $intPage		: 1;
			$intFirst								= ( $intTotal == 0 )		? 0				: $intPageLine * ( $intPage - 1 );
			$productMgr->setLimitFirst($intFirst);
			$productMgr->setPageLine($intPageLine);

			$prodBrandResult						= $productMgr->getProdBrandList( $db, "OP_LIST" );
			$intPageBlock							= 10;																		// 블럭 개수 
			$intListNum								= $intTotal - ( $intPageLine * ( $intPage - 1 ) );							// 번호
			$intTotPage								= ceil( $intTotal / $intPageLine );
			/* 데이터 리스트 */

			$linkPage  = "?menuType=product&mode=prodBrandList&page=";
		break;

		case "prodBrandModify":

			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "004";
			$strLeftMenuCode02 = "001";
			/* 관리자 Sub Menu 권한 설정 */

			$productMgr->setPR_NO($intPR_NO);
			$brandRow = $productMgr->getProdBrandList($db, "OP_SELECT");

			/** 2013.04.26 다국어 버전 추가 **/
			$strPL_LNG = ($strStLng) ? $strStLng : $S_ST_LNG;
			$productMgr->setPL_PR_NO($intPR_NO);
			$productMgr->setPL_LNG($strPL_LNG);
			$brandRowLng = $productMgr->getProdBrandLngList($db, "OP_SELECT");

			$brandRow['PR_HTML'] = $brandRowLng['PL_PR_HTML'];
		break;
	}
?>