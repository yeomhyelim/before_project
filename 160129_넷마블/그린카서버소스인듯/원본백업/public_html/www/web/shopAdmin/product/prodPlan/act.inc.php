<?
	require_once MALL_CONF_LIB."ProductPlanMgr.php";
	
	$planMgr = new ProductPlanMgr();		

	/*##################################### Parameter 셋팅 #####################################*/
	$strSearchField		= $_POST["searchField"]		? $_POST["searchField"]		: $_REQUEST["searchField"];
	$strSearchKey		= $_POST["searchKey"]		? $_POST["searchKey"]		: $_REQUEST["searchKey"];
	$intPage			= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];
	$intPageLine		= $_POST["pageLine"]		? $_POST["pageLine"]		: $_REQUEST["pageLine"];

	$strSearchStartDt	= $_POST["searchStartDt"]	? $_POST["searchStartDt"]	: $_REQUEST["searchStartDt"];
	$strSearchEndDt		= $_POST["searchEndDt"]		? $_POST["searchEndDt"]		: $_REQUEST["searchEndDt"];
	$strSearchViewY		= $_POST["searchViewY"]		? $_POST["searchViewY"]		: $_REQUEST["searchViewY"];
	$strSearchViewN		= $_POST["searchViewN"]		? $_POST["searchViewN"]		: $_REQUEST["searchViewN"];
	
	$strPlanStartDt = $_POST['pp_start_dt'];
	$strPlanEndDt	= $_POST['pp_end_dt'];
	$strPlanView	= $_POST['pp_view'];

	$strPlanName	= strTrim($_POST['pp_title'],"");
	$strPlanHtml	= strTrim($_POST['pp_html'],"");


	/*##################################### PRODUCT    #####################################*/

	$strLinkPage = "";
	$arySiteUseLng = explode("/", $S_USE_LNG);


	$strLinkPage  = "searchField=$strSearchField&searchKey=$strSearchKey&lang={$strStLng}";
	$strLinkPage .= "&searchStartDt=".$strSearchStartDt;
	$strLinkPage .= "&searchEndDt=".$strSearchEndDt;
	$strLinkPage .= "&searchViewY=".$strSearchViewY;
	$strLinkPage .= "&searchViewN=".$strSearchViewN;	

	switch ($strAct) {
		case "prodPlanWrite":
			
			$param['PLAN_START_DT'] = $strPlanStartDt." 00:00:00";
			$param['PLAN_END_DT']	= $strPlanEndDt." 23:59:59";
			$param['PLAN_VIEW']		= IM_IsBlank($strPlanView,'N');
			$param['PLAN_REG_NO']	= $a_admin_no;
			$intPL_NO				= $planMgr->getProdPlanInsert($db,$param);

			if ($intPL_NO > 0){

				$param['PLAN_NO']	= $intPL_NO;
				for($j=0;$j<sizeof($arySiteUseLng);$j++){
					if ($arySiteUseLng[$j]){
						
						$param['PLAN_LNG']	= $arySiteUseLng[$j];
						$param['PLAN_NAME']	= $strPlanName;
						$param['PLAN_HTML']	= $strPlanHtml;
						$planMgr->getProdPlanLngInsert($db,$param);
					}
				}

				$aryProdCateList = $_POST["prodCateCode"];
				if (is_array($aryProdCateList)){
					foreach ($aryProdCateList as $key => $val){
						
						$param['PLAN_P_CATE'] = pushBackZero($val,12);
						
						$aryCateProdCodeList = $_POST["prodCode_".$val]; 
						
						if (is_array($aryCateProdCodeList)){
						
							foreach ($aryCateProdCodeList as $key2 => $val2){
								
								$param['PLAN_P_CODE'] = $val2;
								$planMgr->getProdPlanProductInsert($db,$param);

							}
						}
					}
				}
			}
			
			$strUrl = "./?menuType=".$strMenuType."&mode=prodPlanList&".$strLinkPage;

		break;

		case "prodPlanModify":
			$intPL_NO				= $_POST['planNo'];

			$param['PLAN_NO']		= $intPL_NO;
			$param['PLAN_START_DT'] = $strPlanStartDt." 00:00:00";
			$param['PLAN_END_DT']	= $strPlanEndDt." 23:59:59";
			$param['PLAN_VIEW']		= IM_IsBlank($strPlanView,'N');
			$param['PLAN_MOD_NO']	= $a_admin_no;
			$planMgr->getProdPlanModify($db,$param);

			if ($intPL_NO > 0){
						
				$param['PLAN_LNG']	= $strStLng;
				$param['PLAN_NAME']	= $strPlanName;
				$param['PLAN_HTML']	= $strPlanHtml;
				$planMgr->getProdPlanLngModify($db,$param);

				$strProdPlanCateList		= "";
				$strProdPlanCateProdList	= "";
				$aryProdCateList = $_POST["prodCateCode"];
				if (is_array($aryProdCateList)){
					foreach ($aryProdCateList as $key => $val){

						$param['PLAN_P_CATE'] = pushBackZero($val,12);
						$strProdPlanCateList .= "'".$param['PLAN_P_CATE']."',";
						
						$aryCateProdCodeList = $_POST["prodCode_".$val]; 
						if (is_array($aryCateProdCodeList)){
							foreach ($aryCateProdCodeList as $key2 => $val2){
								
								$param['PLAN_P_CODE'] = $val2;
								$intPPL_NO = $planMgr->getProdPlanProdNo($db,$param);
								if (!$intPPL_NO){
									$intPPL_NO = $planMgr->getProdPlanProductInsert($db,$param);
								}
								$strProdPlanCateProdList .= $intPPL_NO.",";
							}
						}
					}

					/* 카테고리에 속하지 않는 상품 삭제 */
					if ($strProdPlanCateProdList){
						$strProdPlanCateProdList = substr($strProdPlanCateProdList,0,strlen($strProdPlanCateProdList)-1);
						$param['PPL_NO_LIST'] = $strProdPlanCateProdList;
						$planMgr->getProdPlanCateProdDelete($db,$param);
					}

					/* 카테고리에 속하지 않는 카테고리 삭제 */
					if ($strProdPlanCateList){
						$param['PPL_NO_LIST']	= "";
						$strProdPlanCateList	= substr($strProdPlanCateList,0,strlen($strProdPlanCateList)-1);
						$param['PL_P_CATE_LIST'] = $strProdPlanCateList;
						//$planMgr->getProdPlanCateProdDelete($db,$param);
					}
				}
			}
			
			$strUrl = "./?menuType=".$strMenuType."&mode=prodPlanModify&page=$intPage&planNo=$intPL_NO&".$strLinkPage;
		break;

		case "prodPlanDelete":
			$intPL_NO				= $_POST['planNo'];

			
			if ($intPL_NO > 0){
				$param['PLAN_NO']		= $intPL_NO;
				$planMgr->getProdPlanCateProdDelete($db,$param);

				$planMgr->getProdPlanLngDelete($db,$param);
				$planMgr->getProdPlanDelete($db,$param);
			}

			$strUrl = "./?menuType=".$strMenuType."&mode=prodPlanList&".$strLinkPage;

		break;
	}	


?>