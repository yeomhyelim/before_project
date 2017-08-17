<?
	require_once MALL_CONF_LIB."MemberAdmMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";
	require_once MALL_CONF_LIB."CateMgr.php";
	require_once MALL_CONF_LIB."ProductAdmMgr.php";

	$memberMgr = new MemberMgr();
	$siteMgr = new SiteMgr();
	$cateMgr = new CateMgr();
	$productMgr = new ProductAdmMgr();		

	/*##################################### Parameter 셋팅 #####################################*/
	require_once "basic.param.inc.php";

	/* 리스트 페이지 라인 쿠키 설정 */

	$siteRow = $siteMgr->getSiteInfo($db);
	/*##################################### Parameter 셋팅 #####################################*/

	switch($strMode){
		case "group":

			## 모듈 설정
			$objMemberGroupMgrModule = new MemberGroupMgrModule($db); 
			
			## DB 업데이트 체크
			$objMemberGroupMgrModule->getMemberGroupMgrAlter();


			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "002";
			$strLeftMenuCode02 = "001";
			/* 관리자 Sub Menu 권한 설정 */
			$aryGroupList = $memberMgr->getGroupList($db);
//			echo $db->query;

			$memberMgr->setG_CODE($strG_CODE);
			$row = $memberMgr->getGroupView($db);

			$aryGroupSettle  = explode("/",$row[G_SETTLE]);

			$aryGroupExpCategory  = explode("/",$row[G_EXP_CATEGORY]);
			$aryGroupExpProduct  = explode("/",$row[G_EXP_PRODUCT]);

			if (is_array($aryGroupExpCategory)){
				for($i=0;$i<sizeof($aryGroupExpCategory);$i++){

					if ($aryGroupExpCategory[$i]){
						$cateMgr->setCL_LNG($strAdmSiteLng);
						$cateMgr->setC_CODE($aryGroupExpCategory[$i]);
						$cateRow = $cateMgr->getView($db);
						$strGroupExpCategoryHtml .= "<li>";
						$strGroupExpCategoryHtml .= "<input type=\"hidden\" name=\"categoryExpCode[]\" id=\"categoryExpCode[]\" value=\"".$aryGroupExpCategory[$i]."\">";
						$strGroupExpCategoryHtml .= $cateRow[CL_NAME]."<a class=\"btn_sml\" onClick=\"goGroupExpCategoryDelete(this);\"><strong>삭제</strong></a></li>";
					}
				}
			}
			
			if (is_array($aryGroupExpProduct)){
				for($i=0;$i<sizeof($aryGroupExpProduct);$i++){
					if ($aryGroupExpProduct[$i]){
						$productMgr->setP_LNG($S_SITE_LNG);
						$productMgr->setP_CODE($aryGroupExpProduct[$i]);
						$productRow = $productMgr->getProdView($db);
						$strGroupExpProductHtml .= "<li>";
						$strGroupExpProductHtml .= "<input type=\"hidden\" name=\"productExpCode[]\" id=\"productExpCode[]\" value=\"".$aryGroupExpProduct[$i]."\">";
						$strGroupExpProductHtml .= "<img src=\"..".$productRow[PROD_LIST_IMG]."\" style=\"width:50px;height:50px;\">".$productRow[P_NAME];
						$strGroupExpProductHtml .= "</li>";
					}
				}
			}
			
			/*결제방법은 기본정보에서 선택된 결제방법만 보여짐*/
			$arySettle = explode("/",$S_SETTLE);
			if (is_array($arySettle)){
				for($i=0;$i<sizeof($arySettle);$i++){
					if ($arySettle[$i] == "B") $strSettleB = "Y";
					if ($arySettle[$i] == "C") $strSettleC = "Y";
					if ($arySettle[$i] == "A") $strSettleA = "Y";
					if ($arySettle[$i] == "T") $strSettleT = "Y";
					if ($arySettle[$i] == "M") $strSettleT = "Y";
				}
			}
			
			## 최소구매금액 설정
			$intMinBuyPrice = $row['G_MIN_BUY_PRICE'];
//			$intMinBuyPrice = number_format($intMinBuyPrice);

		break;

	}
?>