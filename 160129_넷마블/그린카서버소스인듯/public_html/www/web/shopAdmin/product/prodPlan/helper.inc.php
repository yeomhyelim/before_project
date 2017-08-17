<?
	require_once MALL_CONF_LIB."ProductPlanMgr.php";
	
	$planMgr = new ProductPlanMgr();		

	/*##################################### Parameter 셋팅 #####################################*/
	$strSearchField = $_POST["searchField"]		? $_POST["searchField"]		: $_REQUEST["searchField"];
	$strSearchKey	= $_POST["searchKey"]		? $_POST["searchKey"]		: $_REQUEST["searchKey"];
	$intPage		= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];
	$intPageLine	= $_POST["pageLine"]		? $_POST["pageLine"]		: $_REQUEST["pageLine"];

	
	/*##################################### Parameter 셋팅 #####################################*/
	
	switch($strMode){
		case "prodPlanList":
			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "006";
			$strLeftMenuCode02 = "";			
			/* 관리자 Sub Menu 권한 설정 */
			$param['PL_LNG'] = $strStLng;
			$intPageBlock	= 10;
			if(!$intPageLine) $intPageLine = 10;			
			
			$param['SEARCH_FILED']		= $_REQUEST['searchField'];
			$param['SEARCH_KEY']		= $_REQUEST['searchKey'];
			$param['SEARCH_START_DT']	= $_REQUEST['searchStartDt'];
			$param['SEARCH_END_DT']		= $_REQUEST['searchEndDt'];
			$param['SEARCH_VIEW_Y']		= $_REQUEST['searchViewY'];
			$param['SEARCH_VIEW_N']		= $_REQUEST['searchViewN'];

			$intTotal	= $planMgr->getProdPlanQry($db,"OP_COUNT",$param);
			$intTotPage	= ceil($intTotal / $intPageLine);

			if(!$intPage)	$intPage =1;

			if ($intTotal==0) {
				$intFirst	= 1;
				$intLast	= 0;			
			} else {
				$intFirst	= $intPageLine *($intPage -1);
				$intLast	= $intPageLine * $intPage;
			}
			
			$param['ORDER_BY']	= "N";
			$param['LIMIT']		= "$intFirst,$intLast";
			
			$result = $planMgr->getProdPlanQry($db,"OP_LIST",$param);
			$intListNum = $intTotal - ($intPageLine *($intPage-1));	
			
			## 페이징 링크 주소
			$queryString	= explode("&", $_SERVER['QUERY_STRING']);
			$linkPage		= "";
			foreach($queryString as $string):
				list($key,$val)		= explode("=", $string);
				if($key == "page")	{ continue; }
				if($linkPage)		{ $linkPage .= "&"; }
				$linkPage		   .= $string;
			endforeach;

			$linkPage		= "./?{$linkPage}&page=";

		break;

		case "prodPlanModify":
			$intPL_NO				= $_REQUEST['planNo'];

			$param['PL_LNG']		= $strStLng;
			$param['PL_NO']			= $intPL_NO;

			$row					= $planMgr->getProdPlanQry($db,"OP_SELECT",$param);
			
			/* 기획전별 카테고리 리스트 */
			$aryProdPlanCateList	= $planMgr->getProdPlanCateList($db,$param);
			foreach($aryProdPlanCateList as $key => $data){
				
				$strProdPlanCateCode	= $data['PL_P_CATE'];
				$strCateCode1			= SUBSTR($strProdPlanCateCode,0,3);
				$strCateCode2			= SUBSTR($strProdPlanCateCode,3,3);
				$strCateCode3			= SUBSTR($strProdPlanCateCode,6,3);
				$strCateCode4			= SUBSTR($strProdPlanCateCode,9,3);
				
				if ($strCateCode1 == "000") $strCateCode1 = "";
				if ($strCateCode2 == "000") $strCateCode2 = "";
				if ($strCateCode3 == "000") $strCateCode3 = "";
				if ($strCateCode4 == "000") $strCateCode4 = "";
				
				$param['C_CODE']		= $strCateCode1;
				$strCateCodeName1		= $planMgr->getProdPlanCateName($db,$param);

				if ($strCateCode2){
					$param['C_CODE']	= $strCateCode1.$strCateCode2;
					$strCateCodeName2	= $planMgr->getProdPlanCateName($db,$param);
				}

				if ($strCateCode3){
					$param['C_CODE']	= $strCateCode1.$strCateCode2.$strCateCode3;
					$strCateCodeName3	= $planMgr->getProdPlanCateName($db,$param);
				}

				if ($strCateCode4){
					$param['C_CODE']	= $strCateCode1.$strCateCode2.$strCateCode3.$strCateCode4;
					$strCateCodeName4	= $planMgr->getProdPlanCateName($db,$param);
				}

				$strProdPlanCateCodeName	= $strCateCodeName1;
				if ($strCateCodeName2) $strProdPlanCateCodeName .= " > ".$strCateCodeName2;
				if ($strCateCodeName3) $strProdPlanCateCodeName .= " > ".$strCateCodeName3;
				if ($strCateCodeName4) $strProdPlanCateCodeName .= " > ".$strCateCodeName4;
				
				$aryProdPlanCateList[$key]['PL_P_CATE_NAME'] = $strProdPlanCateCodeName;
				$aryProdPlanCateList[$key]['PL_P_CATE_CODE'] = $strCateCode1.$strCateCode2.$strCateCode3.$strCateCode4;
				
				/* 카테고리별 상품 리스트 */
				$param['PL_P_CATE'] = $data['PL_P_CATE'];
				$param['ORDER_BY']	= "N";
				$aryProdPlanCateProdList= $planMgr->getProdPlanCateProdList($db,"OP_ARYTOTAL",$param);
				
				$aryProdPlanCateList[$key]['PL_P_CATE_PRODUCT'] = $aryProdPlanCateProdList;
			}
		
		break;
	}
?>
