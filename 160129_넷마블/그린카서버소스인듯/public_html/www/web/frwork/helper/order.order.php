<?
	switch ($strMode)
	{
		case "cart":
			include WEB_FRWORK_HELP."order.cart.inc.php";
		break;

		case "order":
			// 주문 페이지
			
			## 2015.02.09 kim hee sung
			## 상품가격 출력 설정
			##  관리자페이지 > 기본설정 > 주문및결제관리 > 상품가격노출 사용시 해당 그룹 회원에게만 가격 노출합니다.
			if($isPriceHide):
				if(!$g_member_no) goUrl('로그인이 필요합니다.', './?menuType=member&mode=login');
				else goUrl('권한이 없습니다.', './');
			endif;


			/* 주문 번호 */
			$aryCartNo			= $_POST["cartNo"]			? $_POST["cartNo"]			: $_REQUEST["cartNo"];
			$strBasketDirect	= $_POST["basketDirect"]	? $_POST["basketDirect"]	: $_REQUEST["basketDirect"];
			/* 주문 번호 */

			/* 구매 번호 "번호,번호" 형식으로 설정 */
			$strAllCartNo = "";
			if ( is_array ( $aryCartNo ) ) :
				for ( $i = 0 ; $i < sizeof ( $aryCartNo ) ; $i++ ) :
					$strAllCartNo .= $aryCartNo[$i] . ",";
				endfor;
			else :
				goErrMsg($LNG_TRANS_CHAR["OS00024"]); //"주문하실 상품이 존재하지 않습니다."
				exit;
			endif;
			
			if ( $strAllCartNo ) :
				$strAllCartNo = SUBSTR ( $strAllCartNo, 0, STRLEN ( $strAllCartNo ) - 1 );		// 마지막 콤마(,) 제거
				$productMgr->setPB_ALL_NO( $strAllCartNo );
			endif;

			/* 구매 번호 "번호,번호," 형식으로 설정 */	
			$productMgr->setPB_DIRECT($strBasketDirect);
			$productMgr->setSearchField($strSearchField);
			$productMgr->setSearchKey($strSearchKey);
			$productMgr->setPB_KEY($g_cart_prikey);
			$productMgr->setM_NO($g_member_no);
			
			$intCartTotal			= $productMgr->getProdBasketTotal($db);
			$cartResult				= $productMgr->getProdBasketList($db);
			
			/* 입점몰/프랜차이즈몰 */
			if ($S_MALL_TYPE != "R" && $S_SITE_LNG == "KR"){
				$productMgr->setPB_ALL_NO($strAllCartNo);
				$aryProdBasketShopList = $productMgr->getProdBasketShopList($db);
				
				$intProdBasketDeliveryTotal = 0;
				if (is_array($aryProdBasketShopList)){
					foreach ($aryProdBasketShopList as $key => $value){
						for($i=1;$i<=5;$i++){
							$aryDeliveryPrice[$i] = 0;
						}

						$aryProdShopRow = $value;					
						$productMgr->setP_SHOP_NO($key);
						$productMgr->setLimitFirst(0);
						$productMgr->setPageLine($aryProdShopRow[BASKET_CNT]);
						$prodBasketRet = $productMgr->getProdBasketList($db);
						
						$intProdBasketDeliveryPrice = 0;
						$aryDeliveryPrice = null;
						while($prodBasketRow = mysql_fetch_array($prodBasketRet)){

							$intProdBasketPrice = ($prodBasketRow[PB_PRICE] * $prodBasketRow[PB_QTY]) + $prodBasketRow[PB_ADD_OPT_PRICE];
							$intProdBasketDeliveryPrice = getProdDeliveryPrice($prodBasketRow,$SHOP_ARY_DELIVERY,$intProdBasketPrice,$prodBasketRow[PB_QTY],$value);
							
							if($S_SITE_LNG == "KR"){
								/* 고정배송비일경우 옵션/수량/금액에 상관없이 무조건 고정배송비 */
								if ($prodBasketRow['P_BAESONG_TYPE'] == "3"){
									if (is_array($aryDeliveryFixProduct)) {
										 if (!in_array($prodBasketRow[P_CODE],$aryDeliveryFixProduct)) {
											$aryDeliveryFixProduct = array_push($aryDeliveryFixProduct, $prodBasketRow[P_CODE]);
										 } else {
											$intProdBasketDeliveryPrice = 0;
										 }
									} else $aryDeliveryFixProduct = array($prodBasketRow[P_CODE]);
								}
							}
							
							$aryDeliveryPrice[$prodBasketRow[P_BAESONG_TYPE]] += $intProdBasketDeliveryPrice;

							/* 착불배송비 설정 (14.09.03)*/
							if ($prodBasketRow['P_BAESONG_TYPE'] == "5") {
								$aryProdBasketShopList[$key]['AFTER_CHARGE_CNT'] += 1;
							}
						}
										
						$intProdBasketShopDeliveryTotal = getCartDeliveryPrice($aryDeliveryPrice,$value[BASKET_PRICE],$SHOP_ARY_DELIVERY,$value);
						$aryProdBasketShopList[$key][DELIVERY_PRICE] = $intProdBasketShopDeliveryTotal;
						$intProdBasketDeliveryTotal = $intProdBasketDeliveryTotal + $intProdBasketShopDeliveryTotal; 
					}
				}
			}
			$aryHp					= getCommCodeList("HP");
			$aryPhone				= getCommCodeList("PHONE");
			$aryBank				= getCommCodeList("BANK");
			
			/* 구매자 정보, 회원인 경우만 */
			$intMemberUsePointTotal			= 0;			//사용가능한 포인트액
			$intMemberOrderJumunCnt			= 0;			//첫주문수(주문기준)
			$intMemberOrderDeliveryCnt		= 0;			//첫주문수(배송기준-구매완료)
			if ( $g_member_no ) :
				$memberMgr->setM_NO($g_member_no);
				$memberRow	= $memberMgr->getMemberView($db);

				if ( $memberRow ) :
					$strJName		= str_replace(" " ,"",$memberRow[M_NAME]);
				    $strJFName		= $memberRow[M_F_NAME];
					$strJLName		= $memberRow[M_L_NAME];

					$strJPhone		= $memberRow[M_PHONE];
					$strJHp			= $memberRow[M_HP];
					$strJMail		= $memberRow[M_MAIL];
					
					$strBName		= str_replace(" " ,"",$memberRow[M_NAME]);
					$strBPhone		= $memberRow[M_PHONE];
					$strBHp			= $memberRow[M_HP];
					
					$strJZip		= $memberRow[M_ZIP];
					$strJAddr1		= $memberRow[M_ADDR];
					$strJAddr2		= $memberRow[M_ADDR2];
					$strJCountry	= $memberRow[M_COUNTRY];
					$strJCity		= $memberRow[M_CITY];
					$strJState		= $memberRow[M_STATE];

					if ($strJPhone){
						$aryJPhone	= explode("-",$strJPhone);
						$strJPhone1	= $aryJPhone[0];
						$strJPhone2	= $aryJPhone[1];
						$strJPhone3	= $aryJPhone[2];
					}

					if ($strJHp){
						$aryJHp  = explode("-",$strJHp);
						$strJHp1 = $aryJHp[0];
						$strJHp2 = $aryJHp[1];
						$strJHp3 = $aryJHp[2];
					}

					if ($strJZip){
						$aryJZip  = explode("-",$strJZip);
						$strJZip1 = $aryJZip[0];
						$strJZip2 = $aryJZip[1];
					}

					$intMemberUsePointTotal = $memberRow[M_POINT];
					
					/*첫구매고객인지확인*/
					$memberOrderRow = $memberMgr->getMemberOrderCount($db);
					if ($memberOrderRow){
						$intMemberOrderJumunCnt = $memberOrderRow[JUMUN_CNT];
						$intMemberOrderDeliveryCnt = $memberOrderRow[DELIVERY_CNT];
					}
					
					/* 기본배송지 확인 */
					$aryMemberAddrList = $memberMgr->getMemberAddrList($db);

					## 2015.01.20 kim hee sung, 회원가입후, 배송지 정보가 없는 경우 가입정보가 출력되도록 추가함.
					## 2015.01.20 kim hee sung, '주문고객 정보와 동일합니다' 옵션으로 변경함.
//					if(!$aryMemberAddrList):
//						$aryMemberAddrList[0]['MA_TYPE'] = '1';
//						$aryMemberAddrList[0]['MA_NAME'] = $memberRow['M_NAME'];
//						$aryMemberAddrList[0]['MA_PHONE'] = $memberRow['M_PHONE'];
//						$aryMemberAddrList[0]['MA_HP'] = $memberRow['M_HP'];
//						$aryMemberAddrList[0]['MA_ZIP'] = $memberRow['M_ZIP'];
//						$aryMemberAddrList[0]['MA_ADDR1'] = $memberRow['M_ADDR'];
//						$aryMemberAddrList[0]['MA_ADDR2'] = $memberRow['M_ADDR2'];
//						$aryMemberAddrList[0]['MA_COUNTRY'] = $memberRow['M_COUNTRY'];
//						$aryMemberAddrList[0]['MA_CITY'] = $memberRow['M_CITY'];
//						$aryMemberAddrList[0]['MA_STATE'] = $memberRow['M_STATE'];
//					endif;
					
					if (is_array($aryMemberAddrList)){
						for($i=0;$i<sizeof($aryMemberAddrList);$i++){
							if ($aryMemberAddrList[$i][MA_TYPE] == "1"){
								$strBName			= $aryMemberAddrList[$i][MA_NAME];
								$strBPhone			= $aryMemberAddrList[$i][MA_PHONE];
								$strBHp				= $aryMemberAddrList[$i][MA_HP];
								$strJZip			= $aryMemberAddrList[$i][MA_ZIP];
								$strJAddr1			= $aryMemberAddrList[$i][MA_ADDR1];
								$strJAddr2			= $aryMemberAddrList[$i][MA_ADDR2];
								$strJCountry		= $aryMemberAddrList[$i][MA_COUNTRY];
								$strJCity			= $aryMemberAddrList[$i][MA_CITY];
								$strJState			= $aryMemberAddrList[$i][MA_STATE];
								
								if ($strBPhone){
									$aryBPhone	= explode("-",$strBPhone);
									$strBPhone1	= $aryBPhone[0];
									$strBPhone2	= $aryBPhone[1];
									$strBPhone3	= $aryBPhone[2];
								}

								if ($strBHp){
									$aryBHp  = explode("-",$strBHp);
									$strBHp1 = $aryBHp[0];
									$strBHp2 = $aryBHp[1];
									$strBHp3 = $aryBHp[2];
								}

								if ($strJZip){
									$aryJZip  = explode("-",$strJZip);
									$strJZip1 = $aryJZip[0];
									$strJZip2 = $aryJZip[1];
								}
							}
						}
					}
				endif;
			endif;
			/* 구매자 정보, 회원인 경우만 */

			/* 주문 결제 방법 */
			if ($S_SETTLE || $S_FOR_PG){
				
				/* 그룹별 결제방법 적용 */
				/* 그룹별 결제방법 주석 처리. 남덕희
				if ($g_member_login && $g_member_no){
					if ($S_MEMBER_GROUP[$g_member_group]["SETTLE"]){
						$S_SETTLE = $S_MEMBER_GROUP[$g_member_group]["SETTLE"];
					}
				}
				*/
									
				$arySiteSettle = explode("/",$S_SETTLE);
				if (is_array($arySiteSettle)){
					$intSiteSettleB = $intSiteSettleA = $intSiteSettleC = $intSiteSettleT = $intSiteSettleM = $intSiteSettleX = "";
					for($z=0;$z<sizeof($arySiteSettle);$z++){
						if ($arySiteSettle[$z] == "B"){
							$intSiteSettleB = "Y";
						}

						if ($arySiteSettle[$z] == "C"){
							$intSiteSettleC = "Y";
						}

						if ($arySiteSettle[$z] == "A"){
							$intSiteSettleA = "Y";
						}

						if ($arySiteSettle[$z] == "T"){
							$intSiteSettleT = "Y";
						}

						if ($arySiteSettle[$z] == "M"){
							$intSiteSettleM = "Y";
						}
					}
				}
				
				if ($S_SITE_LNG != "KR"){
					$arySiteForSettle = explode("/",$S_FOR_PG);
					if (is_array($arySiteForSettle)){
						$intSiteSettleX = $intSiteSettleR = $intSiteSettleY = "";
						for($z=0;$z<sizeof($arySiteForSettle);$z++){
							if ($arySiteForSettle[$z] == "Y"){
								$intSiteSettleY = "Y";	//->해외결제(페이팔)
							}
							
							if ($arySiteForSettle[$z] == "X"){
								$intSiteSettleX = "Y"; //->해외결제(엑심베이)
							}

							if ($arySiteForSettle[$z] == "R"){
								$intSiteSettleR = "Y"; //->해외결제(알리페이)
							}

							if ($arySiteForSettle[$z] == "B"){
								$intSiteSettleForB = "Y";
							}
						}
					}
				}
				
				if ($S_SITE_LNG == "KR" && $S_PG == "X"){
					$intSiteSettleX = "Y";
				}
			}

			/* 무통장 입금시 입금은행 */
			$arySiteSettleBank		= explode("/",$S_BANK);
			$arySiteForSettleBank	= explode("/",$S_FOR_BANK);

			/* 배송비 및 배송방법 */
			if ($S_SITE_LNG == "KR" && $S_DELIVERY_MTH != "N"){
				$orderMgr->setDA_TYPE($S_DELIVERY_MTH);
				
				if ($S_DELIVERY_MTH == "G"){
					$aryDeliveryGroupPriceList = $orderMgr->getOrderDelvieryGroupList($db);
				}
			} else {
				
				/* 무게 배송 */
				if ($S_DELIVERY_FOR_MTH == "W"){
				}
			}

			
			if ($S_SITE_LNG != "KR"){
				/* 국가 리스트 */
				//$aryCountryList		= getCountryList();			
				
				/* 20150725 add 기본 설정 언어가 중문일때  입점사 나라 영어로 셋팅 */
				if($S_SITE_LNG == "CN"){
					$S_SITE_LNG = "US";
					$S_SITE_LNG_P = "CN";
				}
				$aryCountryList		= getCountryList();
			
				if($S_SITE_LNG_P == "CN"){
					$S_SITE_LNG = "CN";
					$S_SITE_LNG_P = "";
				}
				
				$aryCountryState	= getCommCodeList("STATE","");
				/* 국가 리스트 */

				/* 배송국가가 고정일때 사용 */
				if ($S_DELIVERY_FOR_NAT_FIX && !$strJCountry) $strJCountry = $S_DELIVERY_FOR_NAT_FIX;
			}

			$strForSettleCur	= $S_SITE_CUR;
			$strForSettleLang	= $S_SITE_LNG;
			if ($S_SITE_CUR == "IDR" || $S_SITE_CUR == "CNY" || $S_SITE_CUR == "TWD") $strForSettleCur = "USD";
			if ($S_SITE_LNG == "ID" || $S_SITE_LNG == "US") $strForSettleLang = "EN";
			else if ($S_SITE_LNG == "TW") $strForSettleLang = "CN";

			/* 포인트 사용 가능 금액 */
			$intMemberUserAblePoint		= getCurToPriceSave($intMemberUsePointTotal);	//회원보유포인트
			$intUseMaxPoint				= getCurToPriceSave($S_POINT_MAX);				//최대사용포인트

			include WEB_FRWORK_HELP."order.order.cart.inc.php";

		break;
	}
?>