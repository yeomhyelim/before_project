<?
	require_once MALL_CONF_LIB."MemberAdmMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";
	require_once MALL_CONF_LIB."CouponMgr.php";
	require_once MALL_CONF_LIB."ProductAdmMgr.php";
	require_once MALL_CONF_LIB."CateMgr.php";

	$memberMgr = new MemberMgr();
	$siteMgr = new SiteMgr();
	$couponMgr = new CouponMgr();

	$cateMgr = new CateMgr();		
	$productMgr = new ProductAdmMgr();		
	/*##################################### Parameter 셋팅 #####################################*/
	require_once "basic.param.inc.php";

	$siteRow = $siteMgr->getSiteInfo($db);
	/*##################################### Parameter 셋팅 #####################################*/

	switch($strMode){
		case "couponList":
			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "003";
			$strLeftMenuCode02 = "003";
			/* 관리자 Sub Menu 권한 설정 */

			/* 검색부분 */
			$couponMgr->setSearchField($strSearchField);
			$couponMgr->setSearchKey($strSearchKey);
			$couponMgr->setSearchCouponIssue($strSearchCouponIssue);
			$couponMgr->setSearchCouponUse($strSearchCouponUse);
			/* 검색부분 */

			$intPageBlock	= 10;
			//$intPageLine	= 10;
			if(!$intPageLine) $intPageLine = 10;	
			$couponMgr->setPageLine($intPageLine);

			$intTotal	= $couponMgr->getCouponTotal($db);
			$intTotPage	= ceil($intTotal / $couponMgr->getPageLine());

			if(!$intPage)	$intPage =1;

			if ($intTotal==0) {
				$intFirst	= 1;
				$intLast	= 0;			
			} else {
				$intFirst	= $intPageLine *($intPage -1);
				$intLast	= $intPageLine * $intPage;
			}
			$couponMgr->setLimitFirst($intFirst);

			$result = $couponMgr->getCouponList($db);
			$intListNum = $intTotal - ($intPageLine *($intPage-1));	
			
			$linkPage  = "?menuType=$strMenuType&mode=$strMode";
			$linkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
			$linkPage .= "&searchCouponIssue=$strSearchCouponIssue";
			$linkPage .= "&searchCouponUse=$strSearchCouponUse&page=";
		break;

		case "couponModify":
			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "003";
			$strLeftMenuCode02 = "003";
			/* 관리자 Sub Menu 권한 설정 */
			
			$couponMgr->setCU_NO($intCU_NO);
			$row = $couponMgr->getCouponView($db);

			$strCouponExpCategoryHtml = $strCouponExpProductHtml = "";
			$aryCouponApplyList = $couponMgr->getCouponApplyList($db);

			if ($row[CU_USE] == "2" || $row[CU_USE] == "3"){
				
				if (is_array($aryCouponApplyList)){
					for($i=0;$i<sizeof($aryCouponApplyList);$i++){
						
						if ($aryCouponApplyList[$i][CUA_CODE] && $aryCouponApplyList[$i][CUA_TYPE] == "C"){
							
							$cateMgr->setCL_LNG($strAdmSiteLng);
							//$strProdCate = pushBackZero($aryCouponApplyList[$i][CUA_PROD_CATE],12);
							$strProdCate = $aryCouponApplyList[$i][CUA_CODE];
							$cateMgr->setC_CODE($strProdCate);
							$cateRow = $cateMgr->getCouponView($db);
							
							$strCouponExpCategoryHtml .= "<li>";
							$strCouponExpCategoryHtml .= "<input type=\"hidden\" name=\"categoryExpCode[]\" id=\"categoryExpCode[]\" value=\"".$aryCouponApplyList[$i][CUA_CODE]."\">";
							$strCouponExpCategoryHtml .= $cateRow[CL_NAME]."<a class=\"btn_sml\" onClick=\"goCouponExpCategoryDelete(this);\"><strong>삭제</strong></a></li>";
							
						}
						
						if ($aryCouponApplyList[$i][CUA_CODE] && $aryCouponApplyList[$i][CUA_TYPE] == "P"){
							$productMgr->setP_LNG($strAdmSiteLng);
							$productMgr->setP_CODE($aryCouponApplyList[$i][CUA_CODE]);
							$productRow = $productMgr->getProdView($db);
							$strCouponExpProductHtml .= "<li class=\"ExpProdLine\">";
							$strCouponExpProductHtml .= "<input type=\"hidden\" name=\"productExpCode[]\" id=\"productExpCode[]\" value=\"".$aryCouponApplyList[$i][CUA_CODE]."\">";
							$strCouponExpProductHtml .= "<img src=\"".$productRow[PROD_LIST_IMG]."\" style=\"width:50px;height:50px;\"><span>" . $productRow[P_NAME] . '</span>';
							$strCouponExpProductHtml .= "</li>";
						}
						
					}
				}
			}

		break;
		case "couponView":
			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "003";
			$strLeftMenuCode02 = "003";
			/* 관리자 Sub Menu 권한 설정 */
			
			$couponMgr->setCU_NO($intCU_NO);
			$row = $couponMgr->getCouponView($db);


			/* 쿠폰 발급 목록 */
			$intPageBlock	= 10;
			//$intPageLine	= 10;
			if(!$intPageLine) $intPageLine = 10;	
			$couponMgr->setPageLine($intPageLine);

			$intTotal	= $couponMgr->getCouponIssueTotal($db);
			$intTotPage	= ceil($intTotal / $couponMgr->getPageLine());

			if(!$intPage)	$intPage =1;

			if ($intTotal==0) {
				$intFirst	= 1;
				$intLast	= 0;			
			} else {
				$intFirst	= $intPageLine *($intPage -1);
				$intLast	= $intPageLine * $intPage;
			}
			$couponMgr->setLimitFirst($intFirst);

			$result = $couponMgr->getCouponIssueList($db);
			$intListNum = $intTotal - ($intPageLine *($intPage-1));	
			
			$linkPage  = "?menuType=$strMenuType&mode=$strMode";
			$linkPage .= "&cuNo=$intCU_NO&page=";
		break;


	}
?>