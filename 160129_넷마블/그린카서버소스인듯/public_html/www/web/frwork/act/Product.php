<?
	require_once MALL_CONF_LIB."CateMgr.php";
	require_once MALL_CONF_LIB."ProductMgr.php";
	require_once MALL_CONF_LIB."OrderMgr.php";
	require_once "../conf/order.inc.php";
	
	/*상품함수관련*/
	require_once MALL_PROD_FUNC;

	$cateMgr = new CateMgr();		
	$productMgr = new ProductMgr();
	$orderMgr = new OrderMgr();

	$strP_CODE				= $_POST["prodCode"]			? $_POST["prodCode"]			: $_REQUEST["prodCode"];

	$strUB_TITLE				= $_POST["ub_title"]				? $_POST["ub_title"]				: $_REQUEST["ub_title"];
	$strUB_TEXT				= $_POST["ub_text"]				? $_POST["ub_text"]				: $_REQUEST["ub_text"];
	$strProtQty				= $_POST["protQty"]				? $_POST["protQty"]				: $_REQUEST["protQty"];
	$strProdUnit			= $_POST["prodUnit"]			? $_POST["prodUnit"]			: $_REQUEST["prodUnit"];

	
	$intCartQty				= $_POST["cartQty"]				? $_POST["cartQty"]				: $_REQUEST["cartQty"];
	$strCartDelivery		= $_POST["cartDelivery"]		? $_POST["cartDelivery"]		: $_REQUEST["cartDelivery"];
	$strCartDeliveryExp		= $_POST["cartDeliveryExp"]		? $_POST["cartDeliveryExp"]		: $_REQUEST["cartDeliveryExp"];
	
	$strSearchHCode1		= $_POST["lcate"]				? $_POST["lcate"]				: $_REQUEST["lcate"];
	$strSearchHCode2		= $_POST["mcate"]				? $_POST["mcate"]				: $_REQUEST["mcate"];
	$strSearchHCode3		= $_POST["scate"]				? $_POST["scate"]				: $_REQUEST["scate"];
	$strSearchHCode4		= $_POST["fcate"]				? $_POST["fcate"]				: $_REQUEST["fcate"];

	$intPR_NO				= $_POST["pr_no"]				? $_POST["pr_no"]				: $_REQUEST["pr_no"];

	$strLinkPage  = "&lcate=$strSearchHCode1&mcate=$strSearchHCode2";			
	$strLinkPage .= "&scate=$strSearchHCode3&fcate=$strSearchHCode4&pr_no=$intPR_NO";

	if(!$g_cart_prikey){
		$prikey = md5(uniqid(rand()));
		
		setCookie("COOKIE_CART_PRIKEY",$prikey,0,"/");
		$g_cart_prikey = $prikey;
	}	

	$productMgr->setP_LNG($S_SITE_LNG);
	$cateMgr->setCL_LNG($S_SITE_LNG);

	switch ($strAct) {
		case "cart":
		case "cartOrder":
		case "cartWish":

			/* 상품정보 */
			$productMgr->setP_CODE($strP_CODE);
			$prodRow = $productMgr->getProdView($db);

			/* 품절 체크 */
			if ($prodRow[P_STOCK_OUT] == "Y"){
				goErrMsg($LNG_TRANS_CHAR["PS00007"]); //이미 품절된 상품입니다.
				exit;
			}

			/* 수량 확인*/
			if ($intCartQty	<= 0){
				goErrMsg($LNG_TRANS_CHAR["PS00008"]); //상품수량이 존재하지 않습니다.
				exit;
			}
			
			/* 필수사항 체크 */			
			/* 상품 옵션 */
			$productMgr->setPO_TYPE("O");
			$aryProdOpt = $productMgr->getProdOpt($db);
			if (is_array($aryProdOpt)){
				for($i=0;$i<sizeof($aryProdOpt);$i++){
					if ($aryProdOpt[$i][PO_NO] > 0){

						$intPO_NO = $aryProdOpt[$i][PO_NO];
						
						for($kk=1;$kk<=10;$kk++){
						
							if ($aryProdOpt[$i]["PO_NAME".$kk]){
								$strProdCartOptAttr = $_POST["cartOpt".$kk."_".$intPO_NO]			? $_POST["cartOpt".$kk."_".$intPO_NO]			: $_REQUEST["cartOpt".$kk."_".$intPO_NO];	
								
								if (!$strProdCartOptAttr){
									goErrMsg($LNG_TRANS_CHAR["PS00009"]); //하나 이상의 필수 선택을 선택해주세요.
									exit;
								}

								
								${"strProdOptAttr".$kk} = $strProdCartOptAttr;
								if ($prodRow[P_OPT] == "2" && $kk == 1){
									break;
								}
							}
						}

						$productMgr->setPOA_ATTR1($strProdOptAttr1);
						$productMgr->setPOA_ATTR2($strProdOptAttr2);
						$productMgr->setPOA_ATTR3($strProdOptAttr3);
						$productMgr->setPOA_ATTR4($strProdOptAttr4);
						$productMgr->setPOA_ATTR5($strProdOptAttr5);
						$productMgr->setPOA_ATTR6($strProdOptAttr6);
						$productMgr->setPOA_ATTR7($strProdOptAttr7);
						$productMgr->setPOA_ATTR8($strProdOptAttr8);
						$productMgr->setPOA_ATTR9($strProdOptAttr9);
						$productMgr->setPOA_ATTR10($strProdOptAttr10);

						/* 상품 옵션정보 담기*/
						$productMgr->setPO_NO($intPO_NO);
						if ($prodRow[P_OPT] == "2") {
							$productMgr->setPOA_NO($strProdOptAttr1);
							$aryProdOptAttr = $productMgr->getProdOptAttr($db);
						} else {

							$aryProdOptAttr = $productMgr->getProdOptAttrNo($db);
							$productMgr->setPOA_NO($aryProdOptAttr[0][POA_NO]);
						}
						
						/* 수량 체크(무제한상품이 아닐경우) */
						if ($prodRow[P_STOCK_LIMIT] == "N"){
							if ($prodRow[P_QTY] > 0 && $aryProdOptAttr[0][POA_STOCK_QTY] < $intCartQty){
								goErrMsg($LNG_TRANS_CHAR["PS00010"]); //선택하신 옵션 상품 수량이 존재하지 않습니다.
								exit;
							}
						}

						/* 가격 체크 */
						if ($prodRow[P_OPT] == "1") {
							if ($prodRow[P_SALE_PRICE] == 0){
								goErrMsg($LNG_TRANS_CHAR["PS00011"]); //선택하신 옵션 상품은 가격 미정인 상품입니다.
								exit;
							}
						} else {
							if ($aryProdOptAttr[0][POA_SALE_PRICE] == 0){
								goErrMsg($LNG_TRANS_CHAR["PS00011"]); //선택하신 옵션 상품은 가격 미정인 상품입니다.
								exit;
							}
						}

						$aryProdCartOpt[$i][NO]				= $productMgr->getPOA_NO();
						$aryProdCartOpt[$i][NAME1]			= $aryProdOpt[$i][PO_NAME1];
						$aryProdCartOpt[$i][NAME2]			= $aryProdOpt[$i][PO_NAME2];
						$aryProdCartOpt[$i][NAME3]			= $aryProdOpt[$i][PO_NAME3];
						$aryProdCartOpt[$i][NAME4]			= $aryProdOpt[$i][PO_NAME4];
						$aryProdCartOpt[$i][NAME5]			= $aryProdOpt[$i][PO_NAME5];
						$aryProdCartOpt[$i][NAME6]			= $aryProdOpt[$i][PO_NAME6];
						$aryProdCartOpt[$i][NAME7]			= $aryProdOpt[$i][PO_NAME7];
						$aryProdCartOpt[$i][NAME8]			= $aryProdOpt[$i][PO_NAME8];
						$aryProdCartOpt[$i][NAME9]			= $aryProdOpt[$i][PO_NAME9];
						$aryProdCartOpt[$i][NAME10]			= $aryProdOpt[$i][PO_NAME10];

						$aryProdCartOpt[$i][ATTR1]			= $aryProdOptAttr[0][POA_ATTR1];
						$aryProdCartOpt[$i][ATTR2]			= $aryProdOptAttr[0][POA_ATTR2];
						$aryProdCartOpt[$i][ATTR3]			= $aryProdOptAttr[0][POA_ATTR3];
						$aryProdCartOpt[$i][ATTR4]			= $aryProdOptAttr[0][POA_ATTR4];
						$aryProdCartOpt[$i][ATTR5]			= $aryProdOptAttr[0][POA_ATTR5];
						$aryProdCartOpt[$i][ATTR6]			= $aryProdOptAttr[0][POA_ATTR6];
						$aryProdCartOpt[$i][ATTR7]			= $aryProdOptAttr[0][POA_ATTR7];
						$aryProdCartOpt[$i][ATTR8]			= $aryProdOptAttr[0][POA_ATTR8];
						$aryProdCartOpt[$i][ATTR9]			= $aryProdOptAttr[0][POA_ATTR9];
						$aryProdCartOpt[$i][ATTR10]			= $aryProdOptAttr[0][POA_ATTR10];

						if ($prodRow[P_OPT] == "1") $aryProdCartOpt[$i][PRICE]			= $prodRow[P_SALE_PRICE];
						else $aryProdCartOpt[$i][PRICE]			= $aryProdOptAttr[0][POA_SALE_PRICE];

						/*입고가격*/
						if ($prodRow[P_OPT] == "1") $aryProdCartOpt[$i][STOCK_PRICE]	= $prodRow[P_STOCK_PRICE];
						else $aryProdCartOpt[$i][STOCK_PRICE]			= $aryProdOptAttr[0][POA_STOCK_PRICE];

						/* 이벤트 할인가 적용 (2012.09.13) */
						if ($prodRow[P_EVENT_UNIT] && $prodRow[P_EVENT]){
							//$aryProdCartOpt[$i][PRICE] = getProdEventPrice($aryProdCartOpt[$i][PRICE],$prodRow[P_EVENT_UNIT],$prodRow[P_EVENT]);
						}

						/* 회원 등급별 추가할인혜택적용 */
						$aryProdCartOpt[$i][PRICE]		= getProdDiscountPrice($prodRow,"2",$aryProdCartOpt[$i][PRICE]);

						/* 적립금 */
						$intProdPoint = getProdPoint($aryProdCartOpt[$i][PRICE], $aryProdOptAttr[0][POA_POINT], $prodRow[P_POINT_TYPE], $prodRow[P_POINT_OFF1], $prodRow[P_POINT_OFF2]);
						//if ($prodRow[P_OPT] == "1"){
							/* 다중가격 사용안할때 */
							//$intProdPoint = getProdPoint($prodRow[P_SALE_PRICE], $prodRow[P_POINT], $prodRow[P_POINT_TYPE], $prodRow[P_POINT_OFF1], $prodRow[P_POINT_OFF2]);
						//}

						$aryProdCartOpt[$i][POINT]			= $intProdPoint;
						/* 상품 옵션정보 담기*/
					}
				}

			} else {
				/* 상품 옵션이 없을 경우 */
								
				/* 수량 체크(무제한상품이 아닐 경우) */
				if ($prodRow[P_STOCK_LIMIT] == "N"){
					if ($prodRow[P_QTY] > 0 && $prodRow[P_QTY] < $intCartQty){
						goErrMsg($LNG_TRANS_CHAR["PS00010"]); //선택하신 옵션 상품 수량이 존재하지 않습니다.
						exit;
					}
				}

				/* 가격 체크 */
				if ($prodRow[P_SALE_PRICE] == 0){
					goErrMsg($LNG_TRANS_CHAR["PS00011"]); //"선택하신 옵션 상품은 가격 미정인 상품입니다."
					exit;
				}

				/* 이벤트 할인가 적용 (2012.09.13) */
				if ($prodRow[P_EVENT_UNIT] && $prodRow[P_EVENT]){
					//$prodRow[P_SALE_PRICE] = getProdEventPrice($prodRow[P_SALE_PRICE],$prodRow[P_EVENT_UNIT],$prodRow[P_EVENT]);
				}
				
				$intProdPoint = getProdPoint(getProdDiscountPrice($prodRow,"2"), $prodRow[P_POINT], $prodRow[P_POINT_TYPE], $prodRow[P_POINT_OFF1], $prodRow[P_POINT_OFF2]);
				
				$aryProdCartOpt[0][NO]				= 0;
				$aryProdCartOpt[0][NAME1]			= "";
				$aryProdCartOpt[0][NAME2]			= "";
				$aryProdCartOpt[$i][NAME3]			= "";
				$aryProdCartOpt[$i][NAME4]			= "";
				$aryProdCartOpt[$i][NAME5]			= "";
				$aryProdCartOpt[$i][NAME6]			= "";
				$aryProdCartOpt[$i][NAME7]			= "";
				$aryProdCartOpt[$i][NAME8]			= "";
				$aryProdCartOpt[$i][NAME9]			= "";
				$aryProdCartOpt[$i][NAME10]			= "";
				$aryProdCartOpt[0][ATTR1]			= "";
				$aryProdCartOpt[0][ATTR2]			= "";
				$aryProdCartOpt[$i][ATTR3]			= "";
				$aryProdCartOpt[$i][ATTR4]			= "";
				$aryProdCartOpt[$i][ATTR5]			= "";
				$aryProdCartOpt[$i][ATTR6]			= "";
				$aryProdCartOpt[$i][ATTR7]			= "";
				$aryProdCartOpt[$i][ATTR8]			= "";
				$aryProdCartOpt[$i][ATTR9]			= "";
				$aryProdCartOpt[$i][ATTR10]			= "";
				$aryProdCartOpt[0][PRICE]			= getProdDiscountPrice($prodRow,"2"); //$prodRow[P_SALE_PRICE]
				$aryProdCartOpt[0][STOCK_PRICE]		= $prodRow[P_STOCK_PRICE];
				$aryProdCartOpt[0][POINT]			= $intProdPoint;
			}

			/* 상품 추가 옵션*/
			if ($prodRow[P_ADD_OPT] == "Y"){
				$productMgr->setPO_TYPE("A");
				$aryProdAddOpt = $productMgr->getProdOpt($db);
				if (is_array($aryProdAddOpt)){

					$intProdAddOptPriceTotal = 0;
					for($i=0;$i<sizeof($aryProdAddOpt);$i++){
						if ($aryProdAddOpt[$i][PO_NO] > 0){
							$intPO_NO = $aryProdAddOpt[$i][PO_NO];
							$productMgr->setPO_NO($intPO_NO);

							$intProdAddCartOpt	= $_POST["cartAddOpt_".$intPO_NO]			? $_POST["cartAddOpt_".$intPO_NO]			: $_REQUEST["cartAddOpt_".$intPO_NO];	
							if (!$intProdAddCartOpt){
								goErrMsg($LNG_TRANS_CHAR["PS00012"]); //하나 이상의 추가필수 선택을 선택해주세요.
								exit;
							}

							/* 상품 추가 옵션정보 담기*/
							$productMgr->setPO_NO($intPO_NO);
							$productMgr->setPAO_NO($intProdAddCartOpt);
							
							$aryProdAddOptAttr = $productMgr->getProdAddOpt($db);

							$aryProdAddCartOpt[$i][NO]				= $productMgr->getPAO_NO();
							$aryProdAddCartOpt[$i][NAME]			= $aryProdAddOptAttr[0][PAO_NAME];
							$aryProdAddCartOpt[$i][PRICE]			= $aryProdAddOptAttr[0][PAO_PRICE];
							
							$intProdAddOptPriceTotal = $intProdAddOptPriceTotal + $aryProdAddOptAttr[0][PAO_PRICE];
							/* 상품 추가 옵션정보 담기*/
						}
					}
				}
			}


			if ($g_member_no) $productMgr->setM_NO($g_member_no);
			else $productMgr->setM_NO(0);

			if ($strAct == "cartWish"){
				$productMgr->setPW_OPT_NO($aryProdCartOpt[0][NO]);
				$productMgr->setPW_OPT_NM1($aryProdCartOpt[0][NAME1]);
				$productMgr->setPW_OPT_NM2($aryProdCartOpt[0][NAME2]);
				$productMgr->setPW_OPT_NM3($aryProdCartOpt[0][NAME3]);
				$productMgr->setPW_OPT_NM4($aryProdCartOpt[0][NAME4]);
				$productMgr->setPW_OPT_NM5($aryProdCartOpt[0][NAME5]);
				$productMgr->setPW_OPT_NM6($aryProdCartOpt[0][NAME6]);
				$productMgr->setPW_OPT_NM7($aryProdCartOpt[0][NAME7]);
				$productMgr->setPW_OPT_NM8($aryProdCartOpt[0][NAME8]);
				$productMgr->setPW_OPT_NM9($aryProdCartOpt[0][NAME9]);
				$productMgr->setPW_OPT_NM10($aryProdCartOpt[0][NAME10]);
				$productMgr->setPW_OPT_ATTR1($aryProdCartOpt[0][ATTR1]);
				$productMgr->setPW_OPT_ATTR2($aryProdCartOpt[0][ATTR2]);
				$productMgr->setPW_OPT_ATTR3($aryProdCartOpt[0][ATTR3]);
				$productMgr->setPW_OPT_ATTR4($aryProdCartOpt[0][ATTR4]);
				$productMgr->setPW_OPT_ATTR5($aryProdCartOpt[0][ATTR5]);
				$productMgr->setPW_OPT_ATTR6($aryProdCartOpt[0][ATTR6]);
				$productMgr->setPW_OPT_ATTR7($aryProdCartOpt[0][ATTR7]);
				$productMgr->setPW_OPT_ATTR8($aryProdCartOpt[0][ATTR8]);
				$productMgr->setPW_OPT_ATTR9($aryProdCartOpt[0][ATTR9]);
				$productMgr->setPW_OPT_ATTR10($aryProdCartOpt[0][ATTR10]);
				$productMgr->setPW_QTY($intCartQty);
				$productMgr->setPW_STOCK_PRICE($aryProdCartOpt[0][STOCK_PRICE]);
				$productMgr->setPW_PRICE($aryProdCartOpt[0][PRICE]);
				$productMgr->setPW_POINT($aryProdCartOpt[0][POINT]);
				$productMgr->setPW_DELIVERY_TYPE($strCartDelivery);
				$productMgr->setPW_DELIVERY_PRICE(0);
				$productMgr->setPW_DELIVERY_EXP($strCartDeliveryExp);
				$productMgr->setPW_ADD_OPT_PRICE($intProdAddOptPriceTotal);
				$productMgr->getProductWishInsertUpdate($db);
				$intWishNo = $db->getLastInsertID();
				if(!$intWishNo) {
					$intWishNo = $productMgr->getProductWishNo($db);
				}
				$productMgr->setPW_NO($intWishNo);
				for($i=0;$i<sizeof($aryProdAddCartOpt);$i++){
					$productMgr->setPW_NO($intWishNo);
					$productMgr->setPWA_OPT_NO($aryProdAddCartOpt[$i][NO]);
					$productMgr->setPWA_OPT_NM($aryProdAddCartOpt[$i][NAME]);
					$productMgr->setPWA_OPT_PRICE($aryProdAddCartOpt[$i][PRICE]);
					$productMgr->setPWA_OPT_QTY(1);
					
					$productMgr->getProductWishAddInsertUpdate($db);
				}
				
				
				$strUrl = "./?menuType=order&mode=cart".$strLinkPage;

			} else{
				$productMgr->setPB_KEY($g_cart_prikey);
				
				$productMgr->setPB_OPT_NO($aryProdCartOpt[0][NO]);
				$productMgr->setPB_OPT_NM1($aryProdCartOpt[0][NAME1]);
				$productMgr->setPB_OPT_NM2($aryProdCartOpt[0][NAME2]);
				$productMgr->setPB_OPT_NM3($aryProdCartOpt[0][NAME3]);
				$productMgr->setPB_OPT_NM4($aryProdCartOpt[0][NAME4]);
				$productMgr->setPB_OPT_NM5($aryProdCartOpt[0][NAME5]);
				$productMgr->setPB_OPT_NM6($aryProdCartOpt[0][NAME6]);
				$productMgr->setPB_OPT_NM7($aryProdCartOpt[0][NAME7]);
				$productMgr->setPB_OPT_NM8($aryProdCartOpt[0][NAME8]);
				$productMgr->setPB_OPT_NM9($aryProdCartOpt[0][NAME9]);
				$productMgr->setPB_OPT_NM10($aryProdCartOpt[0][NAME10]);

				$productMgr->setPB_OPT_ATTR1($aryProdCartOpt[0][ATTR1]);
				$productMgr->setPB_OPT_ATTR2($aryProdCartOpt[0][ATTR2]);
				$productMgr->setPB_OPT_ATTR3($aryProdCartOpt[0][ATTR3]);
				$productMgr->setPB_OPT_ATTR4($aryProdCartOpt[0][ATTR4]);
				$productMgr->setPB_OPT_ATTR5($aryProdCartOpt[0][ATTR5]);
				$productMgr->setPB_OPT_ATTR6($aryProdCartOpt[0][ATTR6]);
				$productMgr->setPB_OPT_ATTR7($aryProdCartOpt[0][ATTR7]);
				$productMgr->setPB_OPT_ATTR8($aryProdCartOpt[0][ATTR8]);
				$productMgr->setPB_OPT_ATTR9($aryProdCartOpt[0][ATTR9]);
				$productMgr->setPB_OPT_ATTR10($aryProdCartOpt[0][ATTR10]);

				$productMgr->setPB_QTY($intCartQty);
				$productMgr->setPB_STOCK_PRICE($aryProdCartOpt[0][STOCK_PRICE]);
				$productMgr->setPB_PRICE($aryProdCartOpt[0][PRICE]);
				$productMgr->setPB_POINT($aryProdCartOpt[0][POINT]);
				$productMgr->setPB_DELIVERY_TYPE($strCartDelivery);
				$productMgr->setPB_DELIVERY_EXP($strCartDeliveryExp);
				$productMgr->setPB_ADD_OPT_PRICE($intProdAddOptPriceTotal);
				$productMgr->getProdBasketInsertUpdate($db);
				$intBasketNo = $db->getLastInsertID();
				if (!$intBasketNo){
					$intBasketNo = $productMgr->getProdBasketNo($db);
				}
				$productMgr->setPB_NO($intBasketNo);
				for($i=0;$i<sizeof($aryProdAddCartOpt);$i++){
					
					$productMgr->setPB_NO($intBasketNo);
					$productMgr->setPBA_OPT_NO($aryProdAddCartOpt[$i][NO]);
					$productMgr->setPBA_OPT_NM($aryProdAddCartOpt[$i][NAME]);
					$productMgr->setPBA_OPT_PRICE($aryProdAddCartOpt[$i][PRICE]);
					$productMgr->setPBA_OPT_QTY(1);
					$productMgr->getProdBasketAddOptInsertUpdate($db);
				}
			
				if ($strAct == "cartOrder"){
					
					//바로 주문하기 페이지로 이동
					$strCartParamList .= "<input type=\"hidden\" name=\"cartNo[]\" value=\"".$intBasketNo."\">";

					$db->disConnect();

					if ($g_member_no){
						$aryForm["menuType"] = "order";
						$aryForm["mode"] = "order";
						$aryForm["act"] = "./";			
					} else {
						$aryForm["menuType"] = "member";
						$aryForm["mode"] = "login";
						$aryForm["act"] = "./";								
					}
					
					drawPageRedirect("frmAct","./index.php",$aryForm,$strCartParamList);
					
					exit;
				} else {
					//장바구니 페이지로 이동
					$strUrl = "./?menuType=order&mode=cart".$strLinkPage;
				}
			}
		break;

		case "prodLargeBuyWrite":
			/* 상품대량구매요청 게시판 insert(BOARD_UB_PROD_BUY) */
			
			$strProdCode				= $_POST['prodCode'];

			$param						= "";
			$param['P_LNG']				= $S_SITE_LNG;
			$param['P_CODE']			= $strProdCode;
			$param['PROD_INFO_JOIN']	= "Y";
			$prodRow					= $productMgr->getProdListEx($db, "OP_SELECT", $param);
			
			if (!$prodRow){
				$db->disConnect();
				goClose($LNG_TRANS_CHAR["PS00001"]); //등록된 상품이 존재하지 않습니다.
				exit;
			}
			
			
			## 파라미터 셋팅
			$strUB_NAME				= strTrim($_POST['name'],50);
			$strUB_PASS				= strTrim($_POST['pass'],50);
			$strUB_TILE				= strTrim($_POST['subj'],100);
			$intUB_P_CODE			= $strProdCode;
			$strUB_TEXT				= strTrim($_POST['contents'],"",true);

			$param					= "";
			$param['UB_NAME']		= $strUB_NAME;
			$param['UB_PASS']		= $strUB_PASS;
			$param['UB_M_NO']		= $g_member_no;
			$param['UB_M_ID']		= $g_member_id;
			$param['UB_M_MAIL']		= $g_member_mail;
			$param['UB_TITLE']		= $strUB_TILE;
			$param['UB_TEXT']		= $strUB_TEXT;
			$param['UB_P_CODE']		= $intUB_P_CODE;
			$param['UB_P_GRADE']	= 0;
			$param['UB_REG_NO']		= $g_member_no;			
			$param['UB_MOD_NO']		= $g_member_no;
			$param['UB_IP']			= $S_REMOTE_ADDR;
			$result					= $productMgr->getProdLargeBuyInsert($db,$param);
			$intUB_NO				= $db->getLastInsertID();
			if ($intUB_NO > 0){
				$param['UB_NO']		= $intUB_NO;
				$productMgr->getProdLargeBuyReplyUpdate($db,$param);
			}

			goClose($LNG_TRANS_CHAR["CW00077"]);
			exit;
					
		break;

		case "prodInquiryWrite":
			## 모듈 설정
			//$objBoardDataModule = new BoardDataModule($db);

	


			$param['B_CODE']			= "PROD_QNA";
			$param['UB_NAME']			= $g_member_name;
			$param['UB_M_NO']			= $g_member_no;
			$param['UB_M_ID']			= $g_member_id;
			$param['UB_PASS']			= $this->db->getSQLString($param['UB_PASS']);
			$param['UB_MAIL']			= $this->db->getSQLString($param['UB_MAIL']);
			$param['UB_URL']			= $this->db->getSQLString($param['UB_URL']);
			$param['UB_TITLE']			= $strUB_TITLE;
			$param['UB_TEXT']			= $strUB_TEXT;
			$param['UB_TEXT_MOBILE']	= $this->db->getSQLString($param['UB_TEXT_MOBILE']);
			$param['UB_FUNC']			= $this->db->getSQLString($param['UB_FUNC']);
			$param['UB_IP']				= $strClientIP;
			$param['UB_READ']			= 0;
			$param['UB_BC_NO']			= $this->db->getSQLInteger($param['UB_BC_NO']);
			$param['UB_LNG']			= $this->db->getSQLString($param['UB_LNG']);
			$param['UB_ANS_NO']			= "";
			$param['UB_ANS_STEP']		= "";
			$param['UB_ANS_M_NO']		= "";
			$param['UB_PT_NO']			= "";
			$param['UB_CI_NO']			= "";
			$param['UB_WINNER']			= "";
			$param['UB_P_CODE']			= $strP_CODE;
			$param['UB_P_GRADE']		= $this->db->getSQLInteger($param['UB_P_GRADE']);
			$param['UB_REG_DT']			= "NOW()";
			$param['UB_REG_NO']			= $this->db->getSQLInteger($param['UB_REG_NO']);
			$param['UB_MOD_DT']			= "NOW()";
			$param['UB_MOD_NO']			= $this->db->getSQLInteger($param['UB_MOD_NO']);

//$objBoardDataModule = getBoardDataInsertEx($param);
			
			
			$intB_NO = $boardMgr->getDataInsert($db);

			/* 파일 업로드 */
			$tableName		= $boardMgr->getTable();
			 for ( $i=0; $i < $aryBoardSet[0][B_FILE_CNT]; $i++ ) : 
				$fileName		= sprintf( "file%d", $i );
				$uploadPath		= sprintf("/upload/data/%s/file%d", strtolower($tableName), $i + 1 );
				uploadFileModule( $tableName , $intB_NO, $i + 1, $fileName, ".", $uploadPath , $i );
//				echo  $fileName . "<br>";
			endfor;	
			/* 파일 업로드 */

			$strMsg = "게시글이 등록되었습니다.";

			if(!$intPOPUP) {
				$strUrl = "./?menuType=".$strMenuType."&mode=list&bCode=".$strB_CODE.$strLinkPage;
			}
			else
			{
				$db->disConnect();
				goClose($strMsg);
				exit;
			}


		break;

		
	}

	$db->disConnect();
	
	goUrl($strMsg,$strUrl);
?>