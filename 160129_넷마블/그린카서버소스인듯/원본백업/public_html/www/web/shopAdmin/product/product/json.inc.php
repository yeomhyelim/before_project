<?
	require_once MALL_CONF_LIB."CateMgr.php";
	require_once MALL_CONF_LIB."ProductAdmMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";
	require_once MALL_CONF_LIB."MemberMgr.php";
	require_once MALL_CONF_LIB."DesignSetMgr.php";


	$cateMgr = new CateMgr();
	$productMgr = new ProductAdmMgr();
	$siteMgr = new SiteMgr();
	$memberMgr = new MemberMgr();
	$designSetMgr = new DesignSetMgr();

	/*##################################### Parameter 셋팅 #####################################*/
	$intC_LEVEL			= $_POST["cateLevel"]		? $_POST["cateLevel"]			: $_REQUEST["cateLevel"];
	$strC_HCODE			= $_POST["cateHCode"]		? $_POST["cateHCode"]			: $_REQUEST["cateHCode"];
	$strC_VIEW_YN		= $_POST["cateView"]		? $_POST["cateView"]			: $_REQUEST["cateView"];
	$strC_LNG			= $_POST["cateLng"]			? $_POST["cateLng"]				: $_REQUEST["cateLng"];

	$strC_HCODE1		= $_POST["lcate"]			? $_POST["lcate"]				: $_REQUEST["lcate"];
	$strC_HCODE2		= $_POST["mcate"]			? $_POST["mcate"]				: $_REQUEST["mcate"];
	$strC_HCODE3		= $_POST["scate"]			? $_POST["scate"]				: $_REQUEST["scate"];
	$strC_HCODE4		= $_POST["fcate"]			? $_POST["fcate"]				: $_REQUEST["fcate"];
	$strSearchField		= $_POST["searchField"]		? $_POST["searchField"]			: $_REQUEST["searchField"];
	$strSearchKey		= $_POST["searchKey"]		? $_POST["searchKey"]			: $_REQUEST["searchKey"];

	$intC_LEVEL			= IM_IsBlank($intC_LEVEL,"1");
	$strC_VIEW_YN		= IM_IsBlank($strC_VIEW_YN,"N");

	if(!$strJsonMode) { $strJsonMode = $strAct; }

	switch ($strJsonMode){

		case "productNotifyCommLoad":

			## 상품고시정보
			include MALL_ADMIN."/product/product.notify.info.inc.php";
			$param				= array
			(
				'PN_CODE'	=> $_POST['code'] ,
				'P_CODE'	=> $_POST['prodCode']
			) ;

			$strHtml				= "";

			foreach($arrProdNotiItem[$param['PN_CODE']]['ITEM'] as $key => $strItemName):

				$strProdNotifyItemText	= "";
				$intProdNotifyItemNo	= "";
				if ( ! empty ( $param['P_CODE'] ) )
				{
					$param['PN_NAME']	= $strItemName ;
					$prodNotifyRow		= $productMgr->getProdNotifySelectEx ( $db , $param ) ;
					$intProdNotifyItemNo	= $key ;
					if ($prodNotifyRow)
					{
						$intProdNotifyItemNo	= $prodNotifyRow['PN_NO'];
						$strProdNotifyItemText	= $prodNotifyRow['PN_TEXT'];
					}
				}
				$strHtml .= "
				<colgroup>
					<col width=\"200\"/>
					<col/>
				</colgroup>
				<tr>
					<th>{$strItemName}</th>
					<td>";

				$strHtml .= "<input type=\"hidden\" name=\"prodNotifyItemNo[]\" id=\"prodNotifyItemNo[]\" value=\"{$intProdNotifyItemNo}\">";
				$strHtml .= "
						<input type=\"hidden\" name=\"prodNotifyItemName[]\" id=\"prodNotifyItemName[]\" value=\"{$strItemName}\">
						<input type=\"text\" class=\"nbox\"  style=\"width:98%;\" id=\"prodNotifyItemText[]\" name=\"prodNotifyItemText[]\" value=\"{$strProdNotifyItemText}\"/>
					</td>
				</tr>";

			endforeach;

			echo $strHtml;
			exit;
		break;

		case "prodShopModify":
			// 상품 입점사 변경

			## 모듈 설정
			$objProductMgrModule = new ProductMgrModule($db);

			## 기본설정
			$strPCodeList = $_POST['pCodeList'];
			$intShopNo = $_POST['shopNo'];

			## 체크
			if(!$strPCodeList):
				$result['__STATE__'] = "NO_P_CODE";
				$result['__MSG__'] = "변경할 상품 정보가 없습니다.";
				break;
			endif;

			## 임점사 정보가 없으면 본사(0)로 설정합니다.
			if(!$intShopNo) { $intShopNo = 0; }

			## 상품 배열로 변경
			$aryPCodeList = explode(",", $strPCodeList);

			## 상품별 입점사 변경
			foreach($aryPCodeList as $key => $code):

				## 입점사 변경
				$param							= "";
				$param['P_CODE']				= $code;
				$param['P_SHOP_NO']				= $intShopNo;
				$param['P_MOD_DT']				= "NOW()";
				$param['P_MOD_NO']				= $a_admin_no;
				$objProductMgrModule->getProductMgrShopUpdateEx($param);

			endforeach;

			## 마무리
			$result['__STATE__'] = "SUCCESS";
		break;
		case "productViewModify":
			// 상품 출력 여부 변경

			## 모듈 설정
			$objProductMgrModule = new ProductMgrModule($db);
			$objProductInfoModule = new ProductInfoModule($db);

			## 기본설정
			$strPCode = $_POST['prodCode'];
			$strViewMode = $_POST['viewMode'];
			$strLang = $_POST['lang'];

			## 체크
			if(!$strPCode):
				$result['__STATE__'] = "NO_P_CODE";
				$result['__MSG__'] = "변경할 게시판 코드가 없습니다.";
				break;
			endif;
			if(!$strViewMode):
				$result['__STATE__'] = "NO_VIEW_MODE";
				$result['__MSG__'] = "변경할 뷰 모드 값이 없습니다.";
				break;
			endif;
			if(!$strLang):
				$result['__STATE__'] = "NO_LANG";
				$result['__MSG__'] = "변경할 언어 코드가 없습니다.";
				break;
			endif;

			## 기존에 등록된 데이터 불러오기(PRODUCT_MGR)
			$param = "";
			$param['P_CODE'] = $strPCode;
			$param['LNG'] = $strLang;
			$aryProductRow = $objProductMgrModule->getProductMgrSelectEx("OP_SELECT", $param);
			$strP_WEB_VIEW = $aryProductRow['P_WEB_VIEW'];
			$strP_MOB_VIEW = $aryProductRow['P_MOB_VIEW'];
			if(!$aryProductRow):
				$result['__STATE__'] = "NO_DATA";
				$result['__MSG__'] = "변경할 데이터가 없습니다.";
				break;
			endif;

			## 상품출력 값 변경(PRODUCT_INFO)
			## Y -> N 으로 변경
			## N -> Y 으로 변경
			$strWebView = $strP_WEB_VIEW;
			$strMobView = $strP_MOB_VIEW;
			if($strViewMode == "web"):
				if($strWebView == "Y") { $strWebView = "N"; }
				else { $strWebView = "Y"; };
			else:
				if($strMobView == "Y") { $strMobView = "N"; }
				else { $strMobView = "Y"; };
			endif;

			## 데이터 변경(PRODUCT_INFO)
			$param = "";
			$param['P_CODE'] = $strPCode;
			$param['P_WEB_VIEW'] = $strWebView;
			$param['P_MOB_VIEW'] = $strMobView;
			$objProductMgrModule->getProductMgrViewUpdateEx($param);


//			## 2014.09.05 kim hee sung
//			## 언어별로 상품출력을 관리 하는줄 알고 개발을 먼저 함.
//			## 기존에 등록된 데이터 불러오기(PRODUCT_INFO)
//			$param = "";
//			$param['P_CODE'] = $strPCode;
//			$param['LNG'] = $strLang;
//			$aryProductRow = $objProductInfoModule->getProductInfoSelectEx("OP_SELECT", $param);
//			$strP_WEB_VIEW = $aryProductRow['P_WEB_VIEW'];
//			$strP_MOB_VIEW = $aryProductRow['P_MOB_VIEW'];
//			if(!$aryProductRow):
//				$result['__STATE__'] = "NO_DATA";
//				$result['__MSG__'] = "변경할 데이터가 없습니다.";
//				break;
//			endif;
//
//			## 상품출력 값 변경(PRODUCT_INFO)
//			## Y -> N 으로 변경
//			## N -> Y 으로 변경
//			$strWebView = $strP_WEB_VIEW;
//			$strMobView = $strP_MOB_VIEW;
//			if($strViewMode == "web"):
//				if($strWebView == "Y") { $strWebView = "N"; }
//				else { $strWebView = "Y"; };
//			else:
//				if($strMobView == "Y") { $strMobView = "N"; }
//				else { $strMobView = "Y"; };
//			endif;
//
//			## 데이터 변경(PRODUCT_INFO)
//			$param = "";
//			$param['LNG'] = $strLang;
//			$param['P_CODE'] = $strPCode;
//			$param['P_WEB_VIEW'] = $strWebView;
//			$param['P_MOB_VIEW'] = $strMobView;
//			$objProductInfoModule->getProductInfoViewUpdateEx($param);

			## 마무리
			$result['__DATA__']['P_WEB_VIEW'] = $strWebView;
			$result['__DATA__']['P_MOB_VIEW'] = $strMobView;
			$result['__STATE__'] = "SUCCESS";


		break;

		case "cateLevelList":
			$strCateType		= $_POST["cateType"];
			$strCateVersion		= $_POST["version"];

			//$arySiteUseLng		= explode("/",$S_USE_LNG);
			//if (!in_array($a_admin_lng,$arySiteUseLng)){
				//넘어오는 $strC_LNG 값으로 언어설정되게 변경 2015.05.13
				//$strC_LNG = $S_ST_LNG;
			//}

			//카테고리 언어 셋팅 ($strC_LNG : 상품 탭 언어,$S_ST_LNG: 사이트 언어) 남덕희
			$cateMgr->setCL_LNG($strC_LNG);
			$cateMgr->setC_LEVEL($intC_LEVEL);
			$cateMgr->setC_HCODE($strC_HCODE);
			$cateMgr->setC_VIEW_YN($strC_VIEW_YN);
			$cateMgr->setC_TYPE($strCateType); //기획전 구분값(나중에 다른 카테고리 종류가 필요할때 값을 따로 주면 됨

			$array = $cateMgr->getCateLevelAry($db);
			$result_array = json_encode($array);

			if ($strProductVersion == "v2.0" && $strCateVersion == "2"){

				if ($intC_LEVEL == 1) $strProdCateTransCharCode = "PW00013";
				if ($intC_LEVEL == 2) $strProdCateTransCharCode = "PW00014";
				if ($intC_LEVEL == 3) $strProdCateTransCharCode = "PW00015";
				if ($intC_LEVEL == 4) $strProdCateTransCharCode = "PW00016";

				$strProdCateOptionHtml = "<option value=''>{$LNG_TRANS_CHAR[$strProdCateTransCharCode]}</option>"; // 카테고리
				foreach($array as $key => $data){
					$strProdCateOptionHtml .= "<option value='{$strC_HCODE}{$data['CATE_CODE']}'>{$data['CATE_NAME']}</option>";
				}
				echo $strProdCateOptionHtml;
			} else {
				echo $result_array;
			}
		break;

		case "cateProdShareInfo":
			$productMgr->setP_CODE($strP_CODE);
			$productMgr->setP_CATE($strP_CATE);


			if ($productMgr->getProdShareDupCount($db) > 0){

				$result[0][RET] = "N";
				$result_array = json_encode($result);
				echo $result_array;
			} else {

				$productMgr->setP_CODE($strP_CODE);
				$result = $productMgr->getProdInfoJson($db);
				$result[0][RET] = "Y";
				$result_array = json_encode($result);
				echo $result_array;
			}
		break;

		case "cateUpdateProdList":
			$strProdCodeList	= $_POST["prodCode"]		? $_POST["prodCode"]		: $_REQUEST["prodCode"];
			$aryProdCodeList	= explode(",",$strProdCodeList);

			$strHtml = "<tr><th>".$LNG_TRANS_CHAR["CW00009"]."</th><th>".$LNG_TRANS_CHAR["PS00029"]."</th></tr>";
			if (is_array($aryProdCodeList)){
				for($i=0;$i<sizeof($aryProdCodeList);$i++){
					$productMgr->setP_LNG($strStLng);
					$productMgr->setP_CODE($aryProdCodeList[$i]);

					$prodRow = $productMgr->getProdView($db);

					$strHtml .= "<input type=\"hidden\" name=\"chkNo[]\" value=\"".$aryProdCodeList[$i]."\">";
					$strHtml .= "<tr><td>".($i+1)."</td><td>".$prodRow[P_NAME]."</td></tr>";

				}
			}

			echo $strHtml;
			$db->disConnect();
			exit;

		break;

		case "productSiteCommLoad":
			## 공통리스트 내용 가져오기

			## 모듈 설정
			require_once MALL_HOME . "/module2/SiteComm.module.php";
			$siteComm						= new SiteCommModule($db);

			## 변수 초기화
			$result							= "";
			$result['__STATE__']			= "SUCCESS";

			## POST 설정
			$scNo							= $_POST['no'];


			## 체크
			if(!$scNo):
				$result['__STATE__']		= "FAIL";
				echo json_encode($result);
				exit;
			endif;

			## 공통관리 데이터
			$param							= "";
			$param['SC_NO']					= $scNo;
			$siteCommRow					= $siteComm->getSiteCommSelectEx("OP_SELECT", $param);

			if(!$siteCommRow):
				$result['__STATE__']		= "FAIL";
				echo json_encode($result);
				exit;
			endif;

			## 데이터 만들기
			$aryData						= "";
			$aryDAta['TEXT']				= $siteCommRow['SC_TEXT'];


			$result['DATA']					= $aryDAta;
			echo json_encode($result);
			exit;
		break;


		case "productAppr":
			## 공통리스트 내용 가져오기

			## 기본설정


			## 모듈 설정


			## 변수 초기화
			$result							= "";
			$result['__STATE__']			= "SUCCESS";

			## POST 설정
			$strPCode		= $_POST['prodCode'];
			$strState		= $_POST['state'];
			//$strLang		= $_POST['lang'];


			## 체크
			if(!$strPCode):
				$result['__STATE__'] = "NO_P_CODE";
				$result['__MSG__'] = "변경할 상품코드가 없습니다.";
				echo json_encode($result);
				break;
			endif;
			if(!$strState):
				$result['__STATE__'] = "NO_STATE";
				$result['__MSG__'] = "변경할 값이 없습니다.";
				echo json_encode($result);
				break;
			endif;

			## 공통관리 데이터
			$productMgr->setP_CODE($strPCode);
			$productMgr->setP_APPR($strState);

			$productMgr->getProdApprUpdate($db);


			## 데이터 만들기
			$aryData						= "";
			$aryDAta['TEXT']				= "완료";


			$result['DATA']					= $aryDAta;
			echo json_encode($result);
			exit;
		break;

		case "prodOrderUpdate":
			// 상품우선순위수정
			## 모듈 설정
			require_once MALL_HOME . "/module2/ProductMgr.module.php";
			$productMgr						= new ProductMgrModule($db);

			## 기본 설정
			$aryChkNo						= $_POST['chkNo'];

			## 기본 설정 체크
			if(!$aryChkNo || !is_array($aryChkNo)):
				$result['__STATE__']		= "NO_DATA";
				break;
			endif;
			if(!$a_admin_no):
				$result['__STATE__']		= "NO_ADMIN_NO";
				break;
			endif;

			## 상품우선순위 수정
			foreach($aryChkNo as $key => $strProdCode):
				$param						= "";
				$param['P_CODE']			= $strProdCode;
				$param['P_ORDER']			= $_POST['order_'.$strProdCode];
				$param['P_MOD_DT']			= "NOW()";
				$param['P_MOD_NO']			= $a_admin_no;
				$productMgr->getProductMgrOrderUpdateEx($param);
			endforeach;

			## 마무리
			$result['__STATE__']			= "SUCCESS";

			echo json_encode($result);
			exit;
		break;
	}


	switch($strAct):
	case "productRelatedList":
		// 2014.04.16 kim hee sung

	/**
	 * 모듈 설정
	 */
	require_once MALL_HOME . "/config/product.func.php";
	$objProductMgrModule		= new ProductMgrModule($db);

	/**
	 * 기본 설정
	 */
	$intAppID						= $_POST['appID'];
	$intPageLine					= $_POST['pageLine'];
	$strOrderBy						= $_POST['orderBy'];
	$intPage						= $_POST['page'];
	$intPNameCut					= $_POST['pNameCut'];
	$strLang						= $_POST['lang'];
	$strSearchKey					= $_POST['searchKey'];
	$strMoneyIconLeft				= $S_ARY_MONEY_ICON[$strAppLang]["L"];
	$strMoneyIconRight				= $S_ARY_MONEY_ICON[$strAppLang]["R"];
	if(!$intAppPNameCut) { $intAppPNameCut = 1000; }
	if(!$strAppLang) { $strAppLang = $S_SITE_LNG; }
	if($strSearchKey) { $strSearchKeyParam = "%{$strSearchKey}%"; }


	/**
	 * 데이터 불러오기
	 */
	$param								= "";
	$param['LNG']						= $strLang;
	$param['PRODUCT_INFO_JOIN']			= "Y";
	$param['PRODUCT_IMG_JOIN']			= "Y";
	$param['searchKey']					= $strSearchKeyParam;
	$intTotal							= $objProductMgrModule->getProductMgrSelectEx("OP_COUNT", $param);					// 데이터 전체 개수
	$intPageLine						= ( $intPageLine )		? $intPageLine	: 10;										// 리스트 개수
	$intPage							= ( $intPage )			? $intPage		: 1;
	$intFirst							= ( $intTotal == 0 )	? 0				: $intPageLine * ( $intPage - 1 );

	$param['ORDER_BY']					= $strOrderBy;
	$param['LIMIT']						= "{$intFirst},{$intPageLine}";
	$resResult							= $objProductMgrModule->getProductMgrSelectEx("OP_LIST", $param);
	$intPageBlock						= 10;																				// 블럭 개수
	$intListNum							= $intTotal - ( $intPageLine * ( $intPage - 1 ) );									// 번호
	$intTotPage							= ceil( $intTotal / $intPageLine );
//		$result = $db->query;
//		break;

	/**
	 * paging 설정
	 */
	$intPage				= $intPage;									// 현재 페이지
	$intTotPage				= $intTotPage;								// 전체 페이지 수
	$intTotBlock			= ceil($intTotPage / $intPageBlock);		// 전체 블럭 수
	$intBlock				= ceil($intPage / $intPageBlock);			// 현재 블럭
	$intPrevBlock			= (($intBlock - 2) * $intPageBlock) + 1;	// 이전 블럭
	$intNextBlock			= ($intBlock * $intPageBlock) + 1;			// 다음 블럭
	$intFirstBlock			= (($intBlock - 1) * $intPageBlock) + 1;	// 현재 블럭 시작 시저
	$intLastBlock			= $intBlock * $intPageBlock;				// 현재 블럭 종료 시점
	if($intFirstBlock <= 0) { $intFirstBlock	= 1; }
	if($intPrevBlock  <= 0) { $intPrevBlock		= 1; }
	if($intNextBlock >= $intTotPage) { $intNextBlock	= $intTotPage; }
	if($intLastBlock >= $intTotPage) { $intLastBlock	= $intTotPage; }

	## 전달 데이터 만들기
	$aryResultData				= "";
	$i							= 0;
	if($intTotal):
		while($row = mysql_fetch_array($resResult)):

			## 기본설정
			$strP_CODE			= $row['P_CODE'];
			$strP_NAME			= $row['P_NAME'];
			$intP_SALE_PRICE	= $row['P_SALE_PRICE'];
			$strPM_REAL_NAME	= $row['PM_REAL_NAME'];

			## 상품명 설정
			$strP_NAME			= strHanCutUtf($strP_NAME, $intAppPNameCut);

			## 판매 금액 설정
			$strP_SALE_PRICE	= getCurToPrice($intP_SALE_PRICE, $strLang);
			$strP_SALE_PRICE	= "{$strMoneyIconLeft}{$strP_SALE_PRICE}{$strMoneyIconRight}";

		//	## 이미지 체크
			if(!$strPM_REAL_NAME) { $strPM_REAL_NAME = "/himg/product/A0001/no_img.gif"; }

			$aryResultData[$i]['P_CODE']			= $strP_CODE;
			$aryResultData[$i]['P_NAME']			= $strP_NAME;
			$aryResultData[$i]['P_SALE_PRICE']		= $strP_SALE_PRICE;
			$aryResultData[$i]['PM_REAL_NAME']		= $strPM_REAL_NAME;
			$i++;
		endwhile;
	endif;

	## 전달 페이지 만들기
	$aryPage							= "";
	$aryPage['total']					= $intTotal;
	$aryPage['listNum']					= $intListNum;
	$aryPage['page']					= $intPage;
	$aryPage['prevBlock']				= $intPrevBlock;
	$aryPage['nextBlock']				= $intNextBlock;
	$aryPage['firstBlock']				= $intFirstBlock;
	$aryPage['lastBlock']				= $intLastBlock;

	## 마무리
	$result['__STATE__']				= "SUCCESS";
	$result['__APP_ID__']				= $intAppID;
	$result['__DATA__']					= $aryResultData;
	$result['__PAGE__']					= $aryPage;

	break;

	case "popProdList":

		## STEP 1.
		## 설정
		$productMgr->setP_LNG($strC_LNG);
		$productMgr->setSearchHCode1($strC_HCODE1);
		$productMgr->setSearchHCode2($strC_HCODE2);
		$productMgr->setSearchHCode3($strC_HCODE3);
		$productMgr->setSearchHCode4($strC_HCODE4);
		$productMgr->getSearchField($strSearchField);
		$productMgr->getSearchKey($strSearchKey);
		$productMgr->setLimitFirst(0);
		$productMgr->setPageLine(1000);

		## STEP 2.
		## 상품정보 SELECT
		$prodResult = $productMgr->getProdList($db);

		## STEP 3.
		## RETURN 할 데이터 정리
		$data		= "";
		$intCnt		= 0;
		while($row = mysql_fetch_array($prodResult)) :
			$data[$intCnt]['P_CODE']			= $row['P_CODE'];
			$data[$intCnt]['P_NAME']			= $row['P_NAME'];
			$data[$intCnt]['P_BRAND_NAME']		= $row['P_BRAND_NAME'];
			$data[$intCnt]['P_SALE_PRICE']		= $row['P_SALE_PRICE'];
			$data[$intCnt]['PM_REAL_NAME']		= $row['PM_REAL_NAME'];
			$intCnt++;
		endwhile;

		## STEP 4.
		## 마무리.
		$result['mode']		= 1;
		$result['data']		= $data;
		$result_array		= json_encode($result);
		echo $result_array;

	break;

	endswitch;

	if(in_array($strJsonMode, array('productViewModify','prodShopModify'))):
		if(!$result) { $result = print_r($_POST, true); }
		echo json_encode($result);
		exit;
	endif;
?>