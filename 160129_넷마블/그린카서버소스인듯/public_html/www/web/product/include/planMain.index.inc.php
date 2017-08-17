<?

	require_once MALL_CONF_LIB."ProductPlanMgr.php";	
	$planMgr = new ProductPlanMgr();		

	$no				= 1;

	/* 정의 */
	if (!$intWSize) $intWSize 			= $S_PRODLIST_IMG_SIZE_W;
	if (!$intHSize) $intHSize			= $S_PRODLIST_IMG_SIZE_H;
	if (!$intWList) $intWList 			= $S_PRODLIST_IMG_VIEW_W;
	if (!$intHList) $intHList			= $S_PRODLIST_IMG_VIEW_H;
	$strWAlign							= $S_PRODLIST_WORD_ALIGN;
	$strMoney							= $S_PRODLIST_MONEY_TYPE;
	$strMoneyIcon						= $S_PRODLIST_MONEY_ICON;
	$strShow1							= $S_PRODLIST_SHOW_1;
	$strShow2							= $S_PRODLIST_SHOW_2;
	$strShow3							= $S_PRODLIST_SHOW_3;
	$strShow4							= $S_PRODLIST_SHOW_4;
	$strShow5							= $S_PRODLIST_SHOW_5;
	$strShow6							= $S_PRODLIST_SHOW_6;
	$strShow7							= $S_PRODLIST_SHOW_7;
	$strShow8							= $S_PRODLIST_SHOW_8;
	$strColor1							= $S_PRODLIST_COLOR_1;
	$strColor2							= $S_PRODLIST_COLOR_2;
	$strColor3							= $S_PRODLIST_COLOR_3;
	$strColor4							= $S_PRODLIST_COLOR_4;
	$strColor5							= $S_PRODLIST_COLOR_5;
	$strTitleShow						= $S_PRODLIST_TITLE_SHOW_USE;
	$strTitleFile						= $S_PRODLIST_TITLE_FILE_NAME;
	$strNaviUse							= $S_PRODUCT_NAVI_USE_OP;
	$intTitleMaxsize					= $S_PRODLIST_TITLE_MAXSIZE;
	
	/* 통화 */
	$strMoneyIconL		= "";
	$strMoneyIconR		= "";
	if($strMoney == "sign" || $strMoney == "won"){ 
		if ($S_SITE_LNG != "KR" && $S_SITE_LNG != "JP" && $S_SITE_LNG != "RU"){
			if ($S_SITE_LNG == "ES") $strMoneyIconL = $S_SITE_CUR_MARK1;
			else $strMoneyIconL = $S_SITE_CUR_MARK2." ";
		} else {
			if ($S_SITE_LNG == "JP") $strMoneyIconR = $S_SITE_CUR_MARK1;
			else if ($S_SITE_LNG == "RU") $strMoneyIconR = $S_SITE_CUR_MARK1;
			else $strMoneyIconR = $S_SITE_CUR_MARK2;
		}
	} 
	else if($strMoney =="icon")	{ $strMoneyIconL = sprintf(" <img src='/himg/icon/%s'>", $strMoneyIcon); } 
	else						{ $strMoneyIcon = ""; }


	$strProdListAllSortNotView		= "Y"; //상품리스트화면에서 정렬부분이 보이지 않게 처리(기획전에서 처리)
	
	/* 상품 포인트 보여줄때 특정 그룹만 보여주는지에 대한 처리 */
	$strProdPointViewSpecGroupYN = "N";
	if ($strShow3 == "Y"){
		if (is_array($S_FIX_PROD_POINT_VIEW_SPEC_GROUP_LIST)){
			if ($g_member_login && in_array($g_member_group,$S_FIX_PROD_POINT_VIEW_SPEC_GROUP_LIST)){
				$strProdPointViewSpecGroupYN = "Y";
			}
		} else {
			$strProdPointViewSpecGroupYN = "Y";
		}
	}

	/* 기획전번호 */
	$intProdPlanNo	= $_REQUEST['planNo'];
	if (!$intProdPlanNo){
		goErrMsg("등록된 기획전이 없습니다.");
		exit;
	}

	$param['PL_LNG']			= $S_SITE_LNG;
	$param['PL_NO']				= $intProdPlanNo;
	$param['SEARCH_START_DT']	= date("Y-m-d h:i:s");
	$param['SEARCH_END_DT']		= date("Y-m-d h:i:s");
	$param['SEARCH_VIEW_Y']		= "Y";
	
	$prodPlanRow	= $planMgr->getProdPlanQry($db,"OP_SELECT",$param);
	if (!$prodPlanRow){
		goErrMsg("기획전이 종료되었거나 등록되지 않은 기획전입니다.");
		exit;
	}

	//$linkPage  = "?menuType=$strMenuType&mode=$strMode&planNo=$intProdPlanNo";

	/* 기획전 카테고리 리스트 */
	$aryProdPlanCateList = $planMgr->getProdPlanCateList($db,$param);


	include "planMain.skin.html.php";
?>

