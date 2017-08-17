<?
	require_once MALL_CONF_LIB."ProductMgr.php";
	require_once MALL_CONF_LIB."OrderMgr.php";
	require_once MALL_CONF_LIB."MemberMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";

	require_once MALL_SHOP . "/conf/order.inc.php";
	
	/*상품함수관련*/
	require_once MALL_PROD_FUNC;

	if(is_file("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/shop.manual.inc.php")):
		require_once "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/shop.manual.inc.php";
	endif;	

	$orderMgr = new OrderMgr();
	$productMgr = new ProductMgr();
	$memberMgr = new MemberMgr();
	$siteMgr = new SiteMgr();

	$aryCartNo				= $_POST["cartNo"]			? $_POST["cartNo"]			: $_REQUEST["cartNo"];
	
	$intNo					= $_POST["no"]				? $_POST["no"]				: $_REQUEST["no"];

	$strSearchHCode1		= $_POST["lcate"]				? $_POST["lcate"]				: $_REQUEST["lcate"];
	$strSearchHCode2		= $_POST["mcate"]				? $_POST["mcate"]				: $_REQUEST["mcate"];
	$strSearchHCode3		= $_POST["scate"]				? $_POST["scate"]				: $_REQUEST["scate"];
	$strSearchHCode4		= $_POST["fcate"]				? $_POST["fcate"]				: $_REQUEST["fcate"];

	$strO_J_NAME			= $_POST["jname"]			? $_POST["jname"]			: $_REQUEST["jname"];
	$strO_J_PHONE1			= $_POST["jphone1"]			? $_POST["jphone1"]			: $_REQUEST["jphone1"];
	$strO_J_PHONE2			= $_POST["jphone2"]			? $_POST["jphone2"]			: $_REQUEST["jphone2"];
	$strO_J_PHONE3			= $_POST["jphone3"]			? $_POST["jphone3"]			: $_REQUEST["jphone3"];
	$strO_J_PHONE			= $strO_J_PHONE1."-".$strO_J_PHONE2."-".$strO_J_PHONE3;
	
	$strO_J_HP1				= $_POST["jhp1"]			? $_POST["jhp1"]			: $_REQUEST["jhp1"];
	$strO_J_HP2				= $_POST["jhp2"]			? $_POST["jhp2"]			: $_REQUEST["jhp2"];
	$strO_J_HP3				= $_POST["jhp3"]			? $_POST["jhp3"]			: $_REQUEST["jhp3"];
	$strO_J_HP				= $strO_J_HP1."-".$strO_J_HP2."-".$strO_J_HP3;
	
	$strO_J_MAIL			= $_POST["jmail"]			? $_POST["jmail"]			: $_REQUEST["jmail"];

	$strO_B_NAME			= $_POST["bname"]			? $_POST["bname"]			: $_REQUEST["bname"];

	$strO_B_PHONE1			= $_POST["bphone1"]			? $_POST["bphone1"]			: $_REQUEST["bphone1"];
	$strO_B_PHONE2			= $_POST["bphone2"]			? $_POST["bphone2"]			: $_REQUEST["bphone2"];
	$strO_B_PHONE3			= $_POST["bphone3"]			? $_POST["bphone3"]			: $_REQUEST["bphone3"];
	$strO_B_PHONE			= $strO_B_PHONE1."-".$strO_B_PHONE2."-".$strO_B_PHONE3;

	$strO_B_HP1				= $_POST["bhp1"]			? $_POST["bhp1"]			: $_REQUEST["bhp1"];
	$strO_B_HP2				= $_POST["bhp2"]			? $_POST["bhp2"]			: $_REQUEST["bhp2"];
	$strO_B_HP3				= $_POST["bhp3"]			? $_POST["bhp3"]			: $_REQUEST["bhp3"];
	$strO_B_HP				= $strO_B_HP1."-".$strO_B_HP2."-".$strO_B_HP3;
	
	$strO_B_MAIL			= $_POST["bmail"]			? $_POST["bmail"]			: $_REQUEST["bmail"];
	$strO_B_ZIP1			= $_POST["bzip1"]			? $_POST["bzip1"]			: $_REQUEST["bzip1"];
	$strO_B_ZIP2			= $_POST["bzip2"]			? $_POST["bzip2"]			: $_REQUEST["bzip2"];
	$strO_B_ZIP				= $strO_B_ZIP1."-".$strO_B_ZIP2;

	$strO_B_ADDR1			= $_POST["baddr1"]				? $_POST["baddr1"]				: $_REQUEST["baddr1"];
	$strO_B_ADDR2			= $_POST["baddr2"]				? $_POST["baddr2"]				: $_REQUEST["baddr2"];
	$strO_SETTLE			= $_POST["settle"]				? $_POST["settle"]				: $_REQUEST["settle"];
	$strO_BANK_NAME			= $_POST["input_bank_name"]		? $_POST["input_bank_name"]		: $_REQUEST["input_bank_code"];
	$strO_BANK				= $_POST["input_bank_code"]		? $_POST["input_bank_code"]		: $_REQUEST["babk_code"];
	$intO_USE_POINT			= $_POST["use_point"]			? $_POST["use_point"]			: $_REQUEST["use_point"];
	$strO_USE_COUPON_NUM	= $_POST["use_coupon_num"]		? $_POST["use_coupon_num"]		: $_REQUEST["use_coupon_num"];

	$strReturnMenu			= $_POST["returnMenu"]		? $_POST["returnMenu"]		: $_REQUEST["returnMenu"];
	$strReturnMode			= $_POST["returnMode"]		? $_POST["returnMode"]		: $_REQUEST["returnMode"];

	if (!$intO_USE_POINT) $intO_USE_POINT	= 0;
	if (!$g_member_no) $orderMgr->setM_NO(0);
	else $orderMgr->setM_NO($g_member_no);
		
	$orderMgr->setO_J_NAME($strO_J_NAME);
	$orderMgr->setO_J_PHONE($strO_J_PHONE);
	$orderMgr->setO_J_HP($strO_J_HP);
	$orderMgr->setO_J_MAIL($strO_J_MAIL);
	$orderMgr->setO_B_NAME($strO_B_NAME);
	$orderMgr->setO_B_PHONE($strO_B_PHONE);
	$orderMgr->setO_B_HP($strO_B_HP);
	$orderMgr->setO_B_MAIL($strO_B_MAIL);
	$orderMgr->setO_B_ZIP($strO_B_ZIP);
	$orderMgr->setO_B_ADDR1($strO_B_ADDR1);
	$orderMgr->setO_B_ADDR2($strO_B_ADDR2);
	$orderMgr->setO_SETTLE($strO_SETTLE);
	$orderMgr->setO_BANK_NAME($strO_BANK_NAME);
	$orderMgr->setO_BANK($strO_BANK);
	$orderMgr->setO_USE_POINT($intO_USE_POINT);
	$orderMgr->setO_USE_COUPON_NUM($strO_USE_COUPON_NUM);
	$orderMgr->setO_USE_COUPON($intO_USE_COUPON);
	
	$strLinkPage  = "&lcate=$strSearchHCode1&mcate=$strSearchHCode2";			
	$strLinkPage .= "&scate=$strSearchHCode3&fcate=$strSearchHCode4";
			
	if(!$g_cart_prikey){
		$prikey = md5(uniqid(rand()));
		
		setCookie("COOKIE_CART_PRIKEY",$prikey,0,"/");
		$g_cart_prikey = $prikey;
	}	
	
	/* 여기에 추가되어야 함(메일관련) */
	require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/layout/mail/_config.inc.php";
	require_once $S_DOCUMENT_ROOT."www/config/mail.func.php";	
	/* 여기에 추가되어야 함(메일관련) */

	/* 여기에 추가되어야 함(문자관련) 2013.04.18 */
// 2015.01.15 kim hee sung sms v2.0 에서는 사용을 안합니다.
//	$smsConfFile = "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/smsInfo.conf.inc.php";
//	if(is_file($smsConfFile)):
//		require_once $smsConfFile;
//		require_once "{$S_DOCUMENT_ROOT}www/classes/sms/sms.func.class.php";
//		$smsFunc = new SmsFunc();
//	endif;

	/* 여기에 추가되어야 함(문자관련) 2013.04.18 */
	switch ($strAct) {
		case "order1":
			/* 선택한 상품 주문하기 페이지 이동시 체크 */

			$productMgr->setP_LNG($S_SITE_LNG);
			/* 장바구니 정보 */
			if (is_array($aryCartNo)){
				$strCartParamList	= "";
				
				$aryCartProdQty		= "";
				for($i=0;$i<sizeof($aryCartNo);$i++){
					
					if ($aryCartNo[$i] > 0){
					
						$orderMgr->setPB_NO($aryCartNo[$i]);
						$cartRow = $orderMgr->getOrderBasketView($db);

						if ($cartRow)
						{
							if (!$aryCartProdQty[$cartRow['P_CODE']]) $aryCartProdQty[$cartRow['P_CODE']] =  $cartRow['PB_QTY'];
							else $aryCartProdQty[$cartRow['P_CODE']] = $aryCartProdQty[$cartRow['P_CODE']] + $cartRow['PB_QTY'];
						}
					}
				}
				
				$cartRow = "";
				for($i=0;$i<sizeof($aryCartNo);$i++){
					
					if ($aryCartNo[$i] > 0){
						
						$orderMgr->setPB_NO($aryCartNo[$i]);
						$cartRow = $orderMgr->getOrderBasketView($db);

						if (!$cartRow)
						{
							 goErrMsg($LNG_TRANS_CHAR["OS00024"]); //"선택하신 상품의 정보가 존재하지 않습니다."
							 break;
							 exit;
						}
						
						/* 해당 카테고리에 속한 상품은 해당 사용 언어에서만 주문이 가능함 */
						if (is_array($S_FIX_ORDER_DELIVERY_USE_LNG) && !in_array($S_SITE_LNG,$S_FIX_ORDER_DELIVERY_USE_LNG)){
							if (is_array($S_FIX_ORDER_DELIVERY_PROD_CATE)){
								if (in_array(substr($cartRow['P_CATE'],0,3),$S_FIX_ORDER_DELIVERY_PROD_CATE)){
									$strOrderDeliveryUseLng = "";
									foreach($S_FIX_ORDER_DELIVERY_USE_LNG as $uselngKey => $uselngVal){
										$strOrderDeliveryUseLng .= $uselngVal.",";
									}
									$strOrderDeliveryUseLng = substr($strOrderDeliveryUseLng,0,strlen($strOrderDeliveryUseLng)-1);
									$strErrMsg = callLangTrans($LNG_TRANS_CHAR["OS00088"],array($cartRow['P_NAME'],$strOrderDeliveryUseLng));
									goErrMsg($strErrMsg); //"해당상품은 현재 언어팩에서 주문불가"
									break;
									exit;
								}
							}
						}	
						
						if ($cartRow[P_STOCK_OUT] == "Y"){
							goErrMsg($LNG_TRANS_CHAR["OS00028"]); //"[".$cartRow[P_NAME]."] 상품은 품절된 상품입니다."
							exit;
						}
						
						/* 주문수량의 상품의 전체합계에서 최대구매수량 제한 */
						if ($cartRow['P_MAX_QTY'] > 0 && ($aryCartProdQty[$cartRow['P_CODE']] > $cartRow['P_MAX_QTY'])){
							goErrMsg(callLangTrans($LNG_TRANS_CHAR["PS00021"],array($cartRow["P_MAX_QTY"]))); //"선택하신 상품 수량은 {{단어1}} 이상 구매하실 수 없습니다.";
							exit;
						}

						/* 상품 옵션 확인 */
						if ($cartRow[PB_OPT_NO]){
									
							$productMgr->setP_CODE($cartRow[P_CODE]);
							$productMgr->setPOA_NO($cartRow[PB_OPT_NO]);
							$aryProdOptAttr = $productMgr->getProdOptAttr($db);
							
							$intProdOptAttrStock = ($aryProdOptAttr[0][POA_STOCK_QTY])?$aryProdOptAttr[0][POA_STOCK_QTY]:0;

							if ($cartRow[P_STOCK_LIMIT] == "N" || !$cartRow[P_STOCK_LIMIT]){
								if (($cartRow[P_QTY] > 0 && ($intProdOptAttrStock < $cartRow[PB_QTY])) || ($intProdOptAttrStock <= 0)){
									//goErrMsg("[".$cartRow[P_NAME]."] 상품의 재고량(".$aryProdOptAttr[0][POA_STOCK_QTY]."개)보다 주문수량이 많습니다.");
									goErrMsg($LNG_TRANS_CHAR["OS00029"]);
									break;
									exit;
								}
							}

							if (($cartRow[P_OPT] == "1" && !$cartRow[P_SALE_PRICE]) || ($cartRow[P_OPT] != "1" && !$aryProdOptAttr[0][POA_SALE_PRICE])){
								//goErrMsg("[".$cartRow[P_NAME]."] 상품은 가격미정 상품입니다.");
								goErrMsg($LNG_TRANS_CHAR["OS00030"]);
								exit;
							}
							
							/* 이전에 담아둔 장바구니 금액과 현재 등록된 상품의 금액이 틀릴 경우 현재의 금액으로 UPDATE */
							if (($cartRow[P_OPT] == "1" && $cartRow[P_SALE_PRICE] != $cartRow[PB_PRICE]) || ($cartRow[P_OPT] != "1" && $aryProdOptAttr[0][POA_SALE_PRICE] != $cartRow[PB_PRICE])){
								
								$intProdPrice = $intProdStockPrice = 0;
								if ($cartRow[P_OPT] == "1") {
									$intProdPrice		= $cartRow[P_SALE_PRICE];
									$intProdStockPrice	= $cartRow[P_STOCK_PRICE];
								} else {
									$intProdPrice		= $aryProdOptAttr[0][POA_SALE_PRICE];
									$intProdStockPrice	= $aryProdOptAttr[0][POA_STOCK_PRICE];
								}
								/* 이벤트 할인가 적용 (2012.09.13) */
								if ($cartRow[P_EVENT_UNIT] && $cartRow[P_EVENT]){
									//$aryProdCartOpt[$i][PRICE] = getProdEventPrice($aryProdCartOpt[$i][PRICE],$prodRow[P_EVENT_UNIT],$prodRow[P_EVENT]);
								}

								/* 회원 등급별 추가할인혜택적용 */
								//$intProdPrice = getProdDiscountPrice($cartRow,"2",$intProdPrice);
								
								/* 적립금 */
								$intProdPoint = getProdPoint($intProdPrice, ($cartRow[P_OPT]=="1")?$cartRow[P_POINT]:$aryProdOptAttr[0][POA_POINT], $cartRow[P_POINT_TYPE], $cartRow[P_POINT_OFF1], $cartRow[P_POINT_OFF2]);
								/* 상품 옵션정보 담기*/
								
								$productMgr->setPB_NO($cartRow[PB_NO]);
								$productMgr->setPB_STOCK_PRICE($intProdStockPrice);
								$productMgr->setPB_PRICE($intProdPrice);
								$productMgr->setPB_POINT($intProdPoint);
								$productMgr->getProdBasketPriceUpdate($db);
							}

						} else {
							/* 수량 체크 */
							if ($cartRow[P_STOCK_LIMIT] == "N" || !$cartRow[P_STOCK_LIMIT]){
								if (($cartRow[P_QTY] > 0 && $cartRow[P_QTY] < $cartRow[PB_QTY]) || ($cartRow[P_QTY] <= 0)){
									goErrMsg($LNG_TRANS_CHAR["PS00010"]); //"선택하신 옵션 상품 수량이 존재하지 않습니다."
									exit;
								}
							}

							/* 가격 체크 */
							if ($cartRow[P_SALE_PRICE] == 0){
								goErrMsg($LNG_TRANS_CHAR["OS00046"]); //"선택하신 옵션 상품은 가격 미정인 상품입니다."
								exit;
							}

							/* 이전에 담아둔 장바구니 금액과 현재 등록된 상품의 금액이 틀릴 경우 현재의 금액으로 UPDATE */
							if ($cartRow[P_SALE_PRICE] != $cartRow[PB_PRICE]){
								
								$intProdPrice		= $intProdStockPrice = 0;
								$intProdPrice		= $cartRow[P_SALE_PRICE];
								$intProdStockPrice	= $cartRow[P_STOCK_PRICE];
								
								/* 이벤트 할인가 적용 (2012.09.13) */
								if ($cartRow[P_EVENT_UNIT] && $cartRow[P_EVENT]){
									//$aryProdCartOpt[$i][PRICE] = getProdEventPrice($aryProdCartOpt[$i][PRICE],$prodRow[P_EVENT_UNIT],$prodRow[P_EVENT]);
								}

								/* 회원 등급별 추가할인혜택적용 */
								//$intProdPrice = getProdDiscountPrice($cartRow,"2",$intProdPrice);
								
								/* 적립금 */
								$intProdPoint = getProdPoint($intProdPrice, $cartRow[P_POINT], $cartRow[P_POINT_TYPE], $cartRow[P_POINT_OFF1], $cartRow[P_POINT_OFF2]);
								/* 상품 옵션정보 담기*/
								
								$productMgr->setPB_NO($cartRow[PB_NO]);
								$productMgr->setPB_STOCK_PRICE($intProdStockPrice);
								$productMgr->setPB_PRICE($intProdPrice);
								$productMgr->setPB_POINT($intProdPoint);
								$productMgr->getProdBasketPriceUpdate($db);
							}
						}

						/* 상품 추가옵션 확인*/
						$productMgr->setP_CODE($cartRow[P_CODE]);
						$productMgr->setPB_NO($cartRow[PB_NO]);
						$aryProdAddAttrOpt = $productMgr->getProdBasketAddList($db);
						
						if (is_array($aryProdAddAttrOpt)){
							for($j=0;$j<sizeof($aryProdAddAttrOpt);$j++){
								
								if ($aryProdAddAttrOpt[$j] > 0)
								{
									$productMgr->setP_CODE($cartRow[P_CODE]);
									$productMgr->setPAO_NO($aryProdAddAttrOpt[$j][PBA_OPT_NO]);
									$aryProdAddOptAttr = $productMgr->getProdAddOpt($db);

									/* 추가옵션도 재고 관리가 되어야 함 */
								}
							}
						}
						
						$strCartParamList .= "<input type=\"hidden\" name=\"cartNo[]\" value=\"".$aryCartNo[$i]."\">";
					}
				}
			}
			
			$db->disConnect();

			$aryForm["menuType"] = "order";
			$aryForm["mode"] = "order";
			$aryForm["act"] = "./";			
			
			drawPageRedirect("frmAct","./index.php",$aryForm,$strCartParamList);
			
			exit;

		break;
		

		case "cartDel":

			$intPB_NO = $intNo;
			$productMgr->setPB_NO($intPB_NO);
			$productMgr->getProductBasketAddDelete($db);

			if ($S_SHOP_PROD_ADD_ITEM_VERSION == "V2.O"){
				$productMgr->getProductBasketItemDelete($db);
			}

			$productMgr->getProductBasketDelete($db);

//			$strUrl = $_SERVER['HTTP_REFERER'];
			$strUrl = "?menuType=order&mode=cart".$strLinkPage;
		break;

		case "cartAllDel":
			
			if (is_array($aryCartNo)){
				for($i=0;$i<sizeof($aryCartNo);$i++){
					$intPB_NO = $aryCartNo[$i];
					$productMgr->setPB_NO($intPB_NO);
					$productMgr->getProductBasketAddDelete($db);
					$productMgr->getProductBasketDelete($db);
				}
			}

			$strUrl = "?menuType=order&mode=cart".$strLinkPage;
			if ($strReturnMenu && $strReturnMode){
				$strUrl = "./?menuType=$strReturnMenu&mode=$strReturnMode";
			}
		break;


		
		case "moveWish":
			
			if ($intNo > 0){
				$intPB_NO = $intNo;
				
				$productMgr->setPB_ALL_NO($intPB_NO);
				$productMgr->setPB_ALL_SORT("Y");

				$aryProdBasketList = $productMgr->getProdBasketList($db);
				if (is_array($aryProdBasketList)){
					for($i=0;$i<sizeof($aryProdBasketList);$i++){

						$orderMgr->setPB_NO($aryProdBasketList[$i][PB_NO]);
						$orderMgr->setP_CODE($aryProdBasketList[$i][P_CODE]);
						$orderMgr->setPB_OPT_NO($aryProdBasketList[$i][PB_OPT_NO]);
						$orderMgr->setM_NO($g_member_no);
						$intWishCount = $orderMgr->getCartWishCount($db);

						if ($intWishCount == 0){
							$orderMgr->getCartWishInsert($db);
							$intPW_NO = $db->getLastInsertID();

							if ($intPW_NO > 0){
								$orderMgr->setPW_NO($intPW_NO);
								$orderMgr->getCartWishAddInsert($db);

								if ($S_SHOP_PROD_ADD_ITEM_VERSION == "V2.O"){
									$orderMgr->getCartWishItemInsert($db);
								}
							}
						}
						
						/* CART 삭제 */
						$productMgr->setPB_NO($aryProdBasketList[$i][PB_NO]);
						$productMgr->getProductBasketAddDelete($db);

						if ($S_SHOP_PROD_ADD_ITEM_VERSION == "V2.O"){
							$productMgr->getProductBasketItemDelete($db);
						}

						$productMgr->getProductBasketDelete($db);
					}
				}
			} else {

				if (is_array($aryCartNo)){

					for($k=0;$k<sizeof($aryCartNo);$k++){
						$intPB_NO = $aryCartNo[$k];
				
						$productMgr->setPB_ALL_NO($intPB_NO);
						$productMgr->setPB_ALL_SORT("Y");

						$aryProdBasketList = $productMgr->getProdBasketList($db);
						if (is_array($aryProdBasketList)){
							for($i=0;$i<sizeof($aryProdBasketList);$i++){

								$orderMgr->setPB_NO($aryProdBasketList[$i][PB_NO]);
								$orderMgr->setP_CODE($aryProdBasketList[$i][P_CODE]);
								$orderMgr->setPB_OPT_NO($aryProdBasketList[$i][PB_OPT_NO]);
								$orderMgr->setM_NO($g_member_no);
								$intWishCount = $orderMgr->getCartWishCount($db);
								if ($intWishCount == 0){
									$orderMgr->getCartWishInsert($db);
									$intPW_NO = $db->getLastInsertID();

									if ($intPW_NO > 0){
										$orderMgr->setPW_NO($intPW_NO);
										$orderMgr->getCartWishAddInsert($db);

										if ($S_SHOP_PROD_ADD_ITEM_VERSION == "V2.O"){
											$orderMgr->getCartWishItemInsert($db);
										}
									}
								}
								
								/* CART 삭제 */
								$productMgr->setPB_NO($aryProdBasketList[$i][PB_NO]);
								$productMgr->getProductBasketAddDelete($db);

								if ($S_SHOP_PROD_ADD_ITEM_VERSION == "V2.O"){
									$productMgr->getProductBasketItemDelete($db);
								}

								$productMgr->getProductBasketDelete($db);
							}
						}
					}
				}
			}

			## 2015.01.20 kim hee sung 모바일에서 '나중에주문' 버튼을 누르면, 뷰페이지로 이동되는 문제 수정.
			if($strDevice == 'mobile')
				$strUrl = '/?menuType=mypage&mode=cartMyList';
			else
				$strUrl = $_SERVER['HTTP_REFERER'];


		break;

		case "moveBasket":
			if ($intNo > 0){
				$intPW_NO = $intNo;

				$productMgr->setPW_ALL_NO($intPW_NO);
				$productMgr->setPW_ALL_SORT("Y");

				$aryProdWishtList = $productMgr->getProdWishList($db);


				if (is_array($aryProdWishtList)){
					for($i=0;$i<sizeof($aryProdWishtList);$i++){

						$orderMgr->setPW_NO($aryProdWishtList[$i][PW_NO]);
						$orderMgr->setPB_KEY($g_cart_prikey);
						$orderMgr->setP_CODE($aryProdWishtList[$i][P_CODE]);
						
						$orderMgr->setPW_OPT_NO($aryProdWishtList[$i][PW_OPT_NO]);				
						$intCartCount = $orderMgr->getWishCartCount($db);
						
						if ($intCartCount == 0){
							$orderMgr->getWishCartInsert($db);
							$intPB_NO = $db->getLastInsertID();
							
							if ($intPB_NO > 0){
								$orderMgr->setPB_NO($intPB_NO);
								$orderMgr->getWishCartAddInsert($db);

								if ($S_SHOP_PROD_ADD_ITEM_VERSION == "V2.O"){
									$orderMgr->getWishCartItemInsert($db);
								}
							}						
						}
						
						/* WISH 삭제 */
						$productMgr->setPW_NO($aryProdWishtList[$i][PW_NO]);
						$productMgr->getProductWishAddDelete($db);
						$productMgr->getProductWishItemDelete($db);
						$productMgr->getProductWishDelete($db);
					}
				}
			} else {

				if (is_array($aryCartNo)){

					for($k=0;$k<sizeof($aryCartNo);$k++){
						$intPW_NO = $aryCartNo[$k];
				
						$productMgr->setPW_ALL_NO($intPW_NO);
						$productMgr->setPW_ALL_SORT("Y");

						$aryProdWishtList = $productMgr->getProdWishList($db);


						if (is_array($aryProdWishtList)){
							for($i=0;$i<sizeof($aryProdWishtList);$i++){

								$orderMgr->setPW_NO($aryProdWishtList[$i][PW_NO]);
								$orderMgr->setPB_KEY($g_cart_prikey);
								$orderMgr->setP_CODE($aryProdWishtList[$i][P_CODE]);
								
								$orderMgr->setPW_OPT_NO($aryProdWishtList[$i][PW_OPT_NO]);				
								$intCartCount = $orderMgr->getWishCartCount($db);
								
								if ($intCartCount == 0){
									$orderMgr->getWishCartInsert($db);
									$intPB_NO = $db->getLastInsertID();
									
									if ($intPB_NO > 0){
										$orderMgr->setPB_NO($intPB_NO);
										$orderMgr->getWishCartAddInsert($db);

										if ($S_SHOP_PROD_ADD_ITEM_VERSION == "V2.O"){
											$orderMgr->getWishCartItemInsert($db);
										}
									}						
								}
								
								/* WISH 삭제 */
								$productMgr->setPW_NO($aryProdWishtList[$i][PW_NO]);
								$productMgr->getProductWishAddDelete($db);
								$productMgr->getProductWishItemDelete($db);
								$productMgr->getProductWishDelete($db);
							}
						}
					}
				}
			}
			
			$strUrl = $_SERVER['HTTP_REFERER'];
//			$strUrl = "?menuType=order&mode=cart".$strLinkPage;
		break;
		
		case "wishDel":
			if ($intNo > 0){

				$intPW_NO = $intNo;
				$productMgr->setPW_NO($intPW_NO);
				$productMgr->getProductWishAddDelete($db);
				
				if ($S_SHOP_PROD_ADD_ITEM_VERSION == "V2.O"){
					$productMgr->getProductWishItemDelete($db);
				}

				$productMgr->getProductWishDelete($db);

			} else {

				if (is_array($aryCartNo)){

					for($k=0;$k<sizeof($aryCartNo);$k++){
						$intPW_NO = $aryCartNo[$k];
				
						$productMgr->setPW_NO($intPW_NO);
						$productMgr->getProductWishAddDelete($db);
						
						if ($S_SHOP_PROD_ADD_ITEM_VERSION == "V2.O"){
							$productMgr->getProductWishItemDelete($db);
						}

						$productMgr->getProductWishDelete($db);
					}
				}
			}

			$strUrl = $_SERVER['HTTP_REFERER'];
//			$strUrl = "?menuType=order&mode=cart".$strLinkPage;
		break;

		case "orderCancel":
			
			$intO_NO	= $_POST["oNo"]				? $_POST["oNo"]				: $_REQUEST["oNo"];
			if (!$intO_NO) {
				$intO_NO = $_POST["order_no"] ? $_POST["order_no"]	: $_REQUEST["order_no"];
			}
			$strModType = $_POST["mod_type"];
			
			$orderMgr->setO_NO($intO_NO);
			$orderRow = $orderMgr->getOrderView($db);

			/* 무통장 입금 취소 */
			if ($orderRow[O_SETTLE] == "B" || $orderRow[O_SETTLE] == "P")
			{
				/* 무통장 입금 취소시에는 주문완료/입금확인중/결제완료시에만 취소가 가능하다
				   그 외에는 관리자에게 취소 문의를 해야하면 결제완료시 취소시에는 환불계좌를 받아
				   입금 후 취소처리를 완료를 해주어야 취소완료가 된다
				*/
				if ($orderRow[O_STATUS] == "J" || $orderRow[O_STATUS] == "O" || $orderRow[O_STATUS] == "A")
				{
					$strOrderSettleCelNo = "C".date("Ymd").STRTOUPPER(getCode(5));
					$orderMgr->setO_CEL_NO($strOrderSettleCelNo);
					$orderMgr->setO_STATUS("C");
					$intDupCelNoCnt = $orderMgr->getOrderDupCancelNo($db);
					
					if ($intDupCelNoCnt > 0){
						$strFlag = false;

						while($strFlag == false){

							$strOrderSettleCelNo = "C".date("Ymd").STRTOUPPER(getCode(5));
							$orderMgr->setO_CEL_NO($strOrderSettleCelNo);
							$intDupCelNoCnt = $orderMgr->getOrderDupCancelNo($db);
							
							if($intDupCelNoCnt=="0"){
								$strFlag = true;
								break;
							}
						}			
					}

					$orderMgr->setO_CEL_NO($strOrderSettleCelNo);
					$orderMgr->setO_CEL_MEMO($_POST["mod_desc"]);
					$orderMgr->setO_RETURN_BANK($_POST[ "returnBank"      ]);
					$orderMgr->setO_RETURN_ACC($_POST[ "returnAcc" ]);
					$orderMgr->setO_RETURN_NAME($_POST[ "returnName"      ]);
					
					if ($orderRow[O_STATUS] == "A") {
						$strModType = "STSC";
						$orderMgr->setO_CEL_STATUS("Y");
					} else {
						$orderMgr->setO_CEL_STATUS("Y");

						//$orderMgr->setOS_APPR_NO($orderRow[O_APPR_NO]);
						//$orderMgr->setOS_CEL_NO($strOrderSettleCelNo);
						//$orderMgr->getOrderSettleUpdate($db);
						
						$orderMgr->setOS_APPR_NO($orderRow[O_APPR_NO]);
						$orderMgr->setOS_STATUS("C");
						$orderMgr->setOS_TITLE($orderRow[O_J_TITLE]);
						$orderMgr->setOS_USE_POINT($orderRow[O_USE_POINT]);
						$orderMgr->setOS_USE_COUPON($orderRow[O_USE_COUPON]);
						$orderMgr->setOS_TOT_PRICE($orderRow[O_TOT_PRICE]);
						$orderMgr->setOS_TOT_DELIVERY_PRICE($orderRow[O_TOT_DELIVERY_PRICE]);
						$orderMgr->setOS_TOT_TAX_PRICE($orderRow[O_TAX_PRICE]);
						$orderMgr->setOS_TOT_SPRICE($orderRow[O_TOT_SPRICE]);
						if ($orderMgr->getO_ADD_POINT() == "Y") $orderMgr->setOS_TOT_POINT($orderRow[O_TOT_POINT]);				
						else  $orderMgr->setOS_TOT_POINT(0);
						$orderMgr->setOS_SETTLE($orderRow[O_SETTLE]);
						$orderMgr->getOrderSettleInsert($db);

						$orderMgr->setOS_CEL_NO($strOrderSettleCelNo);
						$orderMgr->getOrderSettleUpdate($db);

						/* 사용포인트 적립 복원*/
						if ($orderRow[O_USE_POINT] > 0){
							$memberMgr->setM_NO($orderRow[M_NO]);
							$memberMgr->setM_POINT($orderRow[O_USE_POINT]);
							$memberMgr->getMemberPointUpdate($db);

							/* 포인트 히스토리 추가해야 함*/
							/* 포인트 관리 데이터 INSERT */
							$orderMgr->setM_NO($orderRow[M_NO]);
							$orderMgr->setB_NO(0);
							$orderMgr->setPT_TYPE('003');
							$orderMgr->setPT_POINT($memberMgr->getM_POINT());
							$orderMgr->setPT_MEMO($LNG_TRANS_CHAR["OW00060"]."[".$orderRow[O_KEY]."]"); //포인트사용취소
							$orderMgr->setPT_START_DT(date("Y-m-d"));
							$orderMgr->setPT_END_DT(date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")+$S_POINT_USE_YEAR)));
							$orderMgr->setPT_REG_IP($S_REOMTE_ADDR);
							$orderMgr->setPT_ETC('');
							$orderMgr->setPT_REG_NO(1);
							$orderMgr->getOrderPointInsert($db);
						}

						/* 쿠폰 사용 복원 */
						if ($orderRow[O_USE_COUPON] > 0){
							$orderMgr->getOrderCouponUseCancelUpdate($db);
						}

						$strModType = "9999";
					}
					$orderMgr->getOrderCancelUpdate($db);

					$orderRow[O_CEL_NO] = $strOrderSettleCelNo;
				}
			}
			
			
			/* 신용카드,무통장입금 취소/ 즉시취소 */

			if ($strModType != "STE3" && $strModType != "9999")
			{
				
				/* 사용자단에서 취소시에는 바로 취소처리는 결제상태가 완료일때만 발생한다. */
				$orderMgr->setOC_LIST_ARY("Y");
				$aryOrderCartList = $orderMgr->getOrderCartList($db);
				
				/* 주문대기/입금대기중 상태일때는 상품수와 포인트 적립 취소를 하지 않는다. */
				if ($orderRow[O_STATUS] != "J" && $orderRow[O_STATUS] != "O"){
					
					/* 결제완료된 주문인지 아닌지 확인 */
					$orderMgr->setOS_APPR_NO($orderRow[O_APPR_NO]);
					$intOrderSettleCount = $orderMgr->getOrderDupApprNo($db);
					
					if ($intOrderSettleCount == 1){

						if (is_array($aryOrderCartList)){
							for($j=0;$j<sizeof($aryOrderCartList);$j++){
								$strProdCode  = $aryOrderCartList[$j][P_CODE];
								$intOC_OPT_NO = $aryOrderCartList[$j][OC_OPT_NO];
								$intOC_QTY    = $aryOrderCartList[$j][OC_QTY];
								
								if ($aryOrderCartList[$j][P_STOCK_LIMIT] != "Y"){
									/* 옵션별 수량 조절 */
									if ($intOC_OPT_NO > 0){
										$productMgr->setPOA_STOCK_QTY($intOC_QTY);
										$productMgr->setPOA_NO($intOC_OPT_NO);
										$productMgr->getProdOptQtyUpdate($db);
									}

									/* 상품전체 수량 조절 */
									if ($strProdCode)
									{
										$productMgr->setP_QTY($intOC_QTY);
										$productMgr->setP_CODE($strProdCode);
										$productMgr->getProdQtyUpdate($db);
									}
								}
							}
						}

						/* 포인트 적립 취소 */
						if ($orderRow[O_TOT_POINT] > 0 && $orderRow[M_NO] > 0 && $orderRow[O_ADD_POINT] == "Y"){
							$memberMgr->setM_NO($orderRow[M_NO]);
							$memberMgr->setM_POINT(-$orderRow[O_TOT_POINT]);
							$memberMgr->getMemberPointUpdate($db);

							/* 포인트 히스토리 추가해야 함*/
							/* 포인트 관리 데이터 INSERT */
								$orderMgr->setM_NO($orderRow[M_NO]);
								$orderMgr->setB_NO(0);
								$orderMgr->setPT_TYPE('009');
								$orderMgr->setPT_POINT($memberMgr->getM_POINT());
								$orderMgr->setPT_MEMO($LNG_TRANS_CHAR["OW00061"]."[".$orderRow[O_KEY]."]"); //구매포인트적립취소
								$orderMgr->setPT_START_DT(date("Y-m-d"));
								$orderMgr->setPT_END_DT(date("Y-m-d"));
								$orderMgr->setPT_REG_IP($S_REOMTE_ADDR);
								$orderMgr->setPT_ETC('');
								$orderMgr->setPT_REG_NO(1);
								$orderMgr->getOrderPointInsert($db);

						}

						/* 첫상품구매 포인트 적립 취소 */
						if ($orderRow[O_FIRST_YN] == "Y"){
							$orderMgr->setM_NO($orderRow[M_NO]);
							$intOrderFirstPoint = $orderMgr->getOrderFirstPoint($db);
							if ($intOrderFirstPoint > 0){
								$memberMgr->setM_NO($orderRow[M_NO]);
								$memberMgr->setM_POINT(-$intOrderFirstPoint);
								$memberMgr->getMemberPointUpdate($db);

								/* 포인트 히스토리 추가해야 함*/
								/* 포인트 관리 데이터 INSERT */
									$orderMgr->setM_NO($orderRow[M_NO]);
									$orderMgr->setB_NO(0);
									$orderMgr->setPT_TYPE('005');
									$orderMgr->setPT_POINT($memberMgr->getM_POINT());
									$orderMgr->setPT_MEMO($LNG_TRANS_CHAR["OW00105"]."[".$orderRow[O_KEY]."]"); //구매포인트적립취소
									$orderMgr->setPT_START_DT(date("Y-m-d"));
									$orderMgr->setPT_END_DT(date("Y-m-d"));
									$orderMgr->setPT_REG_IP($S_REOMTE_ADDR);
									$orderMgr->setPT_ETC('');
									$orderMgr->setPT_REG_NO(1);
									$orderMgr->getOrderPointInsert($db);
								/* 포인트 관리 데이터 INSERT */
							}
						}
					} else {

						/* 가상계좌일 경우*/
						if ($orderRow[O_SETTLE] == "T" && $intOrderSettleCount == 0){
							
							$orderMgr->setOS_APPR_NO($orderRow[O_APPR_NO]);
							$orderMgr->setOS_STATUS("C");
							$orderMgr->setOS_TITLE($orderRow[O_J_TITLE]);
							$orderMgr->setOS_USE_POINT($orderRow[O_USE_POINT]);
							$orderMgr->setOS_USE_COUPON($orderRow[O_USE_COUPON]);
							$orderMgr->setOS_TOT_PRICE($orderRow[O_TOT_PRICE]);
							$orderMgr->setOS_TOT_DELIVERY_PRICE($orderRow[O_TOT_DELIVERY_PRICE]);
							$orderMgr->setOS_TOT_TAX_PRICE($orderRow[O_TAX_PRICE]);
							$orderMgr->setOS_TOT_SPRICE($orderRow[O_TOT_SPRICE]);
							if ($orderMgr->getO_ADD_POINT() == "Y") $orderMgr->setOS_TOT_POINT($orderRow[O_TOT_POINT]);				
							else  $orderMgr->setOS_TOT_POINT(0);
							$orderMgr->setOS_SETTLE($orderRow[O_SETTLE]);
							$orderMgr->getOrderSettleInsert($db);
						}
					}
				}

				/* 사용포인트 적립 복원*/
				if ($orderRow[O_USE_POINT] > 0){
					$memberMgr->setM_NO($orderRow[M_NO]);
					$memberMgr->setM_POINT($orderRow[O_USE_POINT]);
					$memberMgr->getMemberPointUpdate($db);

					/* 포인트 히스토리 추가해야 함*/
					/* 포인트 관리 데이터 INSERT */
					$orderMgr->setM_NO($orderRow[M_NO]);
					$orderMgr->setB_NO(0);
					$orderMgr->setPT_TYPE('003');
					$orderMgr->setPT_POINT($memberMgr->getM_POINT());
					$orderMgr->setPT_MEMO($LNG_TRANS_CHAR["OW00060"]."[".$orderRow[O_KEY]."]"); //포인트사용취소
					$orderMgr->setPT_START_DT(date("Y-m-d"));
					$orderMgr->setPT_END_DT(date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")+$S_POINT_USE_YEAR)));
					$orderMgr->setPT_REG_IP($S_REOMTE_ADDR);
					$orderMgr->setPT_ETC('');
					$orderMgr->setPT_REG_NO(1);
					$orderMgr->getOrderPointInsert($db);
				}

				/* 쿠폰 사용 복원 */
				if ($orderRow[O_USE_COUPON] > 0){
					$orderMgr->getOrderCouponUseCancelUpdate($db);
				}

				/* 취소정보 INSERT */
				$orderMgr->setOS_APPR_NO($orderRow[O_APPR_NO]);
				if (!$orderMgr->getOS_CEL_NO()) $orderMgr->setOS_CEL_NO($orderRow[O_CEL_NO]);
				$orderMgr->getOrderSettleUpdate($db);
			
				$strMsg = $LNG_TRANS_CHAR["OS00045"]; //"주문취소가 완료 되었습니다.";

				$strSmsSendCode = "016";
			
			} else {
				
				/* 취소정보 INSERT */
				$orderMgr->setOS_APPR_NO($orderRow[O_APPR_NO]);
				if (!$orderMgr->getOS_CEL_NO()) $orderMgr->setOS_CEL_NO($orderRow[O_CEL_NO]);
				$orderMgr->getOrderSettleUpdate($db);

				$strMsg = $LNG_TRANS_CHAR["OS00045"]; //"주문취소가 완료 되었습니다.";
				$strSmsSendCode = "016";
								
				if ($strModType != "9999") {
					if ($orderRow['O_PG'] == "A" && ($orderRow['O_SETTLE'] == 'A' || $orderRow['O_SETTLE'] == 'T') && $strModType == "STE3"){
						$strSmsSendCode = "";
						$strMsg = $LNG_TRANS_CHAR["OS00078"]; //"주문취소 신청되었습니다. 환불은 취소요청일로 부터 2~3일 이내 환불됩니다.";
					
					} else {
						$strMsg = $LNG_TRANS_CHAR["OS00047"]; //"주문취소 신청되었습니다. 반품이 완료 후 주문취소가 완료됩니다.";
						$strSmsSendCode = "014";
					}
				}
			}

			if($strMsg) :

				
				if ($S_SHOP_ORDER_VERSION == "V2.0")
				{
					require_once MALL_CONF_LIB."ShopOrderNewMgr.php";
					$shopOrderMgr = new ShopOrderMgr();

					/* 해당 주문취소건에 대한 상품 구매상태 변경 */
					$param						=		 "";
					$param['O_NO']				= $orderRow['O_NO'];
					if ($strModType != "9999" && $strModType != "STE3") $param['OC_ORDER_STATUS']	= "C1";
					else $param['OC_ORDER_STATUS']	= "C2";

					$param['OC_MOD_NO']			= $g_member_no;
					$param["OC_UPDATE_TYPE"]	= "All";
					$shopOrderMgr->getOrderCartReturnUpdate($db,$param);
					
					/* 해당 주문취소건에 대한 입점사 구매상태 변경 */
					if ($S_MALL_TYPE == "M"){
						$param["SO_ORDER_STATUS"] = "C";
						$shopOrderMgr->goOrderShopStatusUpdate($db,$param);
					}
					
					/* 주문상태 history 담기 */
					$historyParam				= "";
					$historyParam['m_no']		= $g_member_no;
					$historyParam['h_tab']		= TBL_ORDER_MGR;
					$historyParam['h_key']		= $orderRow['O_NO'];
					$historyParam['h_code']		= "001"; //주문상태
					$historyParam['h_memo']		= "주문상태변경";
					$historyParam['h_text']		= "C";
					$historyParam['h_reg_no']	= $g_member_no;
					$historyParam['h_adm_no']	= $g_member_no;
					$orderMgr->getOrderStatusHistoryUpdate($db,$historyParam);

				} else {
				
					/* 몰인몰형태일때 몰인몰 관련 데이터 취소로 변경(2013.06.27) */
					if ($S_MALL_TYPE == "M"){
						$param				= "";
						$param['o_no']		= $orderRow['O_NO'];
						$param['o_status']	= "C";
						$param['o_reg_no']	= $g_member_no;
						$orderMgr->getOrderStatusAllProcessUpdate($db,$param);

						$param				= "";
						$param['m_no']		= $g_member_no;
						$param['h_tab']		= TBL_ORDER_MGR;
						$param['h_key']		= $orderRow['O_NO'];
						$param['h_code']	= "001"; //주문상태
						$param['h_memo']	= "주문상태변경";
						$param['h_text']	= "C";
						$param['h_reg_no']	= $g_member_no;
						$param['h_adm_no']	= $g_member_no;
						$orderMgr->getOrderStatusHistoryUpdate($db,$param);
					}
					/* 몰인몰형태일때 몰인몰 관련 데이터 취소로 변경(2013.06.27) */
				}

				/** 메일 전송 - 고객 주문 취소 메일 **/
				$aryTAG_LIST['{{__받는사람이름__}}']	= $orderRow['O_J_NAME'];
				$aryTAG_LIST['{{__받는사람메일__}}']	= $orderRow['O_J_MAIL'];
				$aryTAG_LIST['{{__회원명__}}']			= $orderRow['O_J_NAME'];
				$aryTAG_LIST['{{__주문번호__}}']		= $orderRow['O_KEY'];
				$aryTAG_LIST['{{__주문상태표시__}}']	= $strMsg;
				$aryTAG_LIST['{{__주문상품명__}}']		= $orderRow['O_J_TITLE'];
				$aryTAG_LIST['{{__주문취소일자__}}']	= date("Y-m-d");
				//goSendMail("010");
				/** 메일 전송 **/
			
				## 2015.01.15 kim hee sung SMS 모듈 V2.0
				## 한국어 전용
				## 관리자페이지에서 SMS 사용함 설정된 경우

				## 설정파일 불러오기
				include_once rtrim(MALL_SHOP, '/') . '/conf/smsInfo.conf.inc.php';

				if($S_SITE_LNG == "KR" && $SMS_INFO['S_SMS_USE']=="Y"):

					## 사용자 SMS
					## 모듈 설정
					$objSmsInfo = new SmsInfo($db);

					## 코드 설정
					$strSmsCode = $strSmsSendCode; // 014 - 고객 주문취소(고객용)
												   // 016 - 관리자 주문취소(고객용)

					if($SMS_TEXT_LIST && $SMS_TEXT_LIST[$strSmsCode] && $SMS_TEXT_LIST[$strSmsCode]['SM_AUTO'] == "Y"):

						## 문자 설정
						$strSmsMsg			= $SMS_TEXT_LIST[$strSmsCode]['SM_TEXT'];
						$strSmsMsg			= str_replace("{{상점명}}", $S_SITE_KNAME, $strSmsMsg);
						$strSmsMsg			= str_replace("{{고객명}}", $orderRow['O_J_NAME'], $strSmsMsg);

						## SMS 전송
						$param = '';
						$param['phone']			= $orderRow['O_J_HP'];		
						$param['callBack']		= $S_COM_PHONE;	
						$param['msg']			= $strSmsMsg;
						$param['siteName']		= $S_SITE_KNAME;
						$objSmsInfo->goSendSms($param);

					endif;

					## 관리자 SMS
					## 코드 설정
					if ($strSmsCode == "014") $strSmsCode = "015"; // 고객 주문취소(관리자용)
					if ($strSmsCode == "016") $strSmsCode = "017"; // 관리자 주문취소(관리자용)

					if($SMS_TEXT_LIST && $SMS_TEXT_LIST[$strSmsCode] && $SMS_TEXT_LIST[$strSmsCode]['SM_AUTO'] == "Y"):

						## 문자 설정
						$strSmsMsg			= $SMS_TEXT_LIST[$strSmsCode]['SM_TEXT'];
						$strSmsMsg			= str_replace("{{상점명}}", $S_SITE_KNAME, $strSmsMsg);
						$strSmsMsg			= str_replace("{{고객명}}", $orderRow['O_J_NAME'], $strSmsMsg);

						## SMS 전송
						$param = '';
						$param['phone']			= $orderRow['O_J_HP'];		
						$param['callBack']		= $S_COM_PHONE;	
						$param['msg']			= $strSmsMsg;
						$param['siteName']		= $S_SITE_KNAME;
						$objSmsInfo->goSendSms($param);

					endif;
				endif;	
			
				/** 2013.04.18 SMS 전송 모듈 추가 **/
				## SMS 사용 , 한국어 페이지 인 경우 SMS 전송 실행
// 2015.01.15 kim hee sung 소스 정리 및 sms 작동 오류 수정
//				if($SMS_INFO['S_SMS_USE']=="Y" && $S_SITE_LNG == "KR" && $strSmsSendCode):
//					$smsMoney = $smsFunc->getSmsMoneySelect($db); // 머니 체크
//					if($smsMoney['VAL'] > 0):
//						$smsCode			= $strSmsSendCode;
//						$smsPhone			= str_replace("-","",$orderRow['O_J_HP']);		
//						$smsCallBackPhone	= $S_COM_PHONE;
//						$smsMsg				= $SMS_TEXT_LIST[$smsCode]['SM_TEXT'];
//						$smsMsg				= str_replace("{{상점명}}", $S_SITE_KNAME, $smsMsg);
//						$smsMsg				= str_replace("{{고객명}}", $orderRow['O_J_NAME'], $smsMsg);
//						if($SMS_TEXT_LIST[$smsCode]['SM_AUTO'] == "Y"): //  자동발송 사용..
//							$smsFunc->goSendSms($smsPhone, $smsCallBackPhone, $smsMsg);
//							$smsFunc->getSmsMoneyMinusUpdate($db); // 머니 -1
//						endif;
//					else:
//						// sms 머니 부족.. 부분 처리..
//					endif;
//					
//					/* 관리자 SMS 전송 */
//					if ($strSmsSendCode == "014") $strSmsSendCode = "015";
//					if ($strSmsSendCode == "016") $strSmsSendCode = "017";
//					
//					$smsMoney = $smsFunc->getSmsMoneySelect($db); // 머니 체크
//					if($smsMoney['VAL'] > 0):
//						/* 관리자용 */
//						$smsCode			= $strSmsSendCode;
//						$smsPhone			= str_replace("-","",$S_COM_HP);		
//						$smsCallBackPhone	= $S_COM_PHONE;
//						$smsMsg				= $SMS_TEXT_LIST[$smsCode]['SM_TEXT'];
//						$smsMsg				= str_replace("{{상점명}}", $S_SITE_KNAME, $smsMsg);
//						$smsMsg				= str_replace("{{고객명}}", $orderRow['O_J_NAME'], $smsMsg);
//						if($SMS_TEXT_LIST[$smsCode]['SM_AUTO'] == "Y"): //  자동발송 사용..
//							$smsFunc->goSendSms($smsPhone, $smsCallBackPhone, $smsMsg);
//							$smsFunc->getSmsMoneyMinusUpdate($db); // 머니 -1
//						endif;
//					endif;
//
//				endif;
//				/** 2013.04.18 SMS 전송 모듈 추가 **/
			endif;

			/* 구매건수 , 구매금액 업데이트 */
			if ($orderRow['M_NO']){
				$memberMgr->setM_NO($orderRow['M_NO']);					// 회원번호
				$memberMgr->getMemberBuyUpdate($db);
			}
			/* 구매건수 , 구매금액 업데이트 */

			$db->disConnect();
			goPopReflash($strMsg);
			exit;

		break;

		case "orderSend":

				$strMailMode = "orderSend";

				$intO_NO = 57;
				$orderMgr->setO_NO($intO_NO);
				$orderRow = $orderMgr->getOrderView($db);
				
				include WEB_FRWORK_ACT."orderMailForm.inc.php";
				
				echo $strOrderCartHtml."<Br>";
				echo $strOrderCartPriceHtml."<br>";
				echo $strOrderInfoHtml;
				exit;
		break;

		case "orderEstimate":
			/** 견적하기 **/			
			$aryChkNo = $_POST["chkNo"];
			if (is_array($aryChkNo)){
				foreach($aryChkNo as $key => $val){
					echo $key.":".$val."<Br>";
				}
			}
		
			exit;
			
		break;
	}

	$db->disConnect();
	
	goUrl($strMsg,$strUrl);

	function rand_code($nc, $a='ABCDEFGHIJKLMNOPQRSTUVWXYZ') {
		 $l = strlen($a) - 1; $r = '';
		 while($nc-->0) $r .= $a{mt_rand(0,$l)};
		 return $r;
	}
?>