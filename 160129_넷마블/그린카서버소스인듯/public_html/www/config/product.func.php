<?
#/*====================================================================*/#
#|화일명	: product.func.php											|#
#|작성자	: 박영미													|#
#|작성일	: 2011.02.09												|#
#|작성내용	: 상품함수													|#
#/*====================================================================*/#


##############################################################
# 상품 포인트 함수											 #
##############################################################
function getProdPoint($intPrice, $intPoint, $strPointType, $intPointOff1, $strPointOff2)
{
	global $S_ST_CUR;

	$intProdPoint = 0;

	if ($strPointType == "1" && $intPoint > 0){
		/* 가격의 % 포인트 */
		$intProdPoint = ($intPrice * ($intPoint/100));

		$intPointOff1 = IM_IsBlank($intPointOff1,0);
		if ($strPointOff2 == "1"){
			if ($S_ST_CUR == "KRW" || $S_ST_CUR == "RUB" || $S_ST_CUR == "JPY"){
				$intProdPoint = getTruncateDown($intProdPoint,$intPointOff1);
			} else {
				$intProdPoint = getTruncateDown($intProdPoint,-$intPointOff1);
			}
		} else {
			if ($S_ST_CUR == "KRW" || $S_ST_CUR == "RUB" || $S_ST_CUR == "JPY"){
				$intProdPoint = round($intProdPoint,-$intPointOff1);
			} else {
				$intProdPoint = round($intProdPoint,$intPointOff1);
			}
		}

	} else {
		$intProdPoint = $intPoint;
	}

	return $intProdPoint;
}

##############################################################
# 상품 배송비 함수											 #
##############################################################
function getProdDeliveryPrice($cartRow,$SHOP_ARY_DELIVERY,$intCartPrice, $intProdCnt , $shopRow = null)
{
	$intDeliveryPrice = 0;

//	global $cartRow;
	global $SHOP_ARY_DELIVERY;
	global $S_DELIVERY_MTH;
	global $S_DELIVERY_FOR_MTH;
	global $S_MALL_TYPE;
	global $S_SITE_LNG;

	$intShopDeliveryExpPrice	= $SHOP_ARY_DELIVERY["SHOP_DELIVERY_EXP_PRICE"]; //예외지역배송비
	$intShopDeliveryStPrice		= $SHOP_ARY_DELIVERY["SHOP_DELIVERY_ST_PRICE"];
	$intShopDeliveryPrice		= $SHOP_ARY_DELIVERY["SHOP_DELIVERY_PRICE"];

	if ($S_SITE_LNG != "KR"){
		/* 해외배송일때 */
		$intShopDeliveryStPrice		= $SHOP_ARY_DELIVERY["SHOP_DELIVERY_ST_FOR_PRICE"];
		$intShopDeliveryPrice		= $SHOP_ARY_DELIVERY["SHOP_DELIVERY_FOR_PRICE"];
	}

	if ($cartRow[P_SHOP_NO] > 0){
		/* 입점몰이고 샵인 경우 (국내배송일경우만 샵 배송비가 적용)*/
		if ($S_MALL_TYPE != "R" && $shopRow["SH_COM_DELIVERY"] != "C"  && $S_SITE_LNG == "KR"){
			$intShopDeliveryStPrice		= $shopRow["SH_COM_DELIVERY_ST_PRICE"];
			$intShopDeliveryExpPrice	= 0;
			$intShopDeliveryPrice		= $shopRow["SH_COM_DELIVERY_PRICE"];
		}
	}

	if ($cartRow[P_BAESONG_TYPE] == "1"){

		//기본배송비정책
		//주문시바로결제
		if ($S_SITE_LNG == "KR"){
			if (!$S_DELIVERY_MTH || $S_DELIVERY_MTH == "N"){
				if ($cartRow[PB_DELIVERY_TYPE] == "1" && $intCartPrice < $intShopDeliveryStPrice){
					if ($cartRow[PB_DELIVERY_EXP] == "Y"){
						$intDeliveryPrice = $intShopDeliveryExpPrice;
					} else {
						$intDeliveryPrice = $intShopDeliveryPrice;
					}
				}
			} else {
				/* 그룹배송*/
				if ($intCartPrice < $intShopDeliveryStPrice){
					$intDeliveryPrice = $intShopDeliveryPrice;
				}
			}
		} else {

			/* 그룹배송이거나 해외배송일때 */
			if ($intCartPrice < $intShopDeliveryStPrice){
				$intDeliveryPrice = $intShopDeliveryPrice;
			}
		}

	} else if ($cartRow[P_BAESONG_TYPE] == "2"){
		//무료배송
		$intDeliveryPrice = 0;
	} else if ($cartRow[P_BAESONG_TYPE] == "3"){

		$intDeliveryPrice = $cartRow[P_BAESONG_PRICE];

	} else if ($cartRow[P_BAESONG_TYPE] == "4"){

		//$intDeliveryPrice = $cartRow[P_BAESONG_PRICE] * $intProdCnt ;
		if (!$intProdCnt) $intProdCnt = $cartRow['PB_QTY'];
		$intDeliveryPrice = $cartRow[P_BAESONG_PRICE] * ceil($intProdCnt / $cartRow["P_MIN_QTY"]) ;

		/*if ($cartRow[PB_DELIVERY_EXP] == "Y"){
			$intDeliveryPrice = $SHOP_ARY_DELIVERY["SHOP_DELIVERY_EXP_PRICE"] * $intProdCnt;
		} else {
			$intDeliveryPrice = $SHOP_ARY_DELIVERY["SHOP_DELIVERY_PRICE"] * $intProdCnt;
		}*/

		/* 해외배송일때 해외배송방법을 'B'로 사용할 경우 기본배송배 + ((수량-1) * 수량별배송비비용) 계산 */
		if ($S_SITE_LNG != "KR"){
			if ($S_DELIVERY_FOR_MTH == "B"){
				$intDeliveryPrice = $cartRow[P_BAESONG_PRICE] * $intProdCnt ;

				if ($cartRow['CART_COUNT'] == 1){
					$intDeliveryPrice = $intShopDeliveryPrice + ($cartRow[P_BAESONG_PRICE] * ($intProdCnt - 1)) ;
				}
			}
		}

	} else if ($cartRow[P_BAESONG_TYPE] == "5"){
			//착불배송비
		$intDeliveryPrice = $cartRow[P_BAESONG_PRICE];
	}

	return $intDeliveryPrice;
}

function getCartDeliveryPrice($aryDelvieryPrice,$intProdTotalPrice,&$SHOP_ARY_DELIVERY,$shopRow = null)
{

	$intDeliveryTotal = 0;

	global $aryDeliveryPrice;
//	global $SHOP_ARY_DELIVERY;
	global $S_SITE_LNG;
	global $S_MALL_TYPE;

	$intShopDeliveryStPrice		= $SHOP_ARY_DELIVERY["SHOP_DELIVERY_ST_PRICE"];
	$intShopDeliveryExpPrice	= $SHOP_ARY_DELIVERY["SHOP_DELIVERY_EXP_PRICE"];
	$intShopDeliveryPrice		= $SHOP_ARY_DELIVERY["SHOP_DELIVERY_PRICE"];

	if ($S_SITE_LNG != "KR"){
		/* 해외배송일때 */
		$intShopDeliveryStPrice		= $SHOP_ARY_DELIVERY["SHOP_DELIVERY_ST_FOR_PRICE"];
		$intShopDeliveryPrice		= $SHOP_ARY_DELIVERY["SHOP_DELIVERY_FOR_PRICE"];
	}

	if ($shopRow[P_SHOP_NO] > 0){
		if ($S_MALL_TYPE != "R" && $shopRow["SH_COM_DELIVERY"] != "C" && $S_SITE_LNG == "KR"){
			$intShopDeliveryStPrice		= $shopRow["SH_COM_DELIVERY_ST_PRICE"];
			$intShopDeliveryExpPrice	= 0;
			$intShopDeliveryPrice		= $shopRow["SH_COM_DELIVERY_PRICE"];
		}
	}

	/* 배송비 고정은 무조건 포함 됨(2013.08.05) */
	if ($intProdTotalPrice >= $intShopDeliveryStPrice){
		$intDeliveryTotal = 0 + $aryDeliveryPrice[3];
	} else {
		if ($aryDeliveryPrice[1] > 0){
			$intDeliveryTotal += $intShopDeliveryPrice;
		}

		if ($aryDeliveryPrice[3] > 0){
			$intDeliveryTotal += $aryDeliveryPrice[3];
		}

		if ($aryDeliveryPrice[4] > 0){
			$intDeliveryTotal += $aryDeliveryPrice[4];
		}
	}
	return $intDeliveryTotal;
}



##############################################################
# 상품 이벤트 가격								 #
##############################################################

function getProdEventPrice($intPrice, $strUnit, $intEventPrice,$strOff)
{
	global $S_ST_CUR;

	$intSalePrice = $intPrice;

	if ($strUnit == "1"){
		$intSalePrice = ($intSalePrice - ($intSalePrice * ($intEventPrice/100)));
	} else if ($strUnit == "2"){
		$intSalePrice = ($intSalePrice - $intEventPrice);
	}

	if ($strOff == "1"){
		if ($S_ST_CUR == "KRW") {
			$intSalePrice = getRoundUp($intSalePrice,0);
		} else {
			$intSalePrice = getRoundUp($intSalePrice,2);
		}
	}

	if ($strOff == "2"){
		if ($S_ST_CUR == "KRW") {
			$intSalePrice = round($intSalePrice,0);
		} else {
			$intSalePrice = round($intSalePrice,2);
		}
	}

	return $intSalePrice;
}

##############################################################
# 상품 통화별 셋팅											 #
##############################################################
/* 현지 통화로 변경 (기준 -> 언어별 통화) */
function getCurToPrice($price, $lang = "",$curRate = 0)
{
	global $S_SITE_LNG;
	global $S_SITE_CUR;
	global $S_ARY_CUR;
	global $S_ARY_NAT_CUR;
	global $S_ARY_NAT_USER_CUR;
	global $S_ST_CUR;

	$strSiteLng = $lang;
	if ($lang == ""){
		$strSiteLng = $S_SITE_LNG;
	}

	$strSiteCur		= $S_ARY_NAT_CUR[$strSiteLng];
	if (is_array($S_ARY_NAT_USER_CUR)){
		$strSiteCur	= $S_ARY_NAT_USER_CUR[$strSiteLng];
	}

	$intCurPrice	= $price;

	$intCurRate		= $S_ARY_CUR[$strSiteLng][$strSiteCur][0];
	if ($curRate > 0) $intCurRate = $curRate;

	if ($S_ARY_CUR[$strSiteLng][$strSiteCur][0] != 1) {
		//$intCurPrice = getRoundDown(($price * $S_ARY_CUR[$strSiteLng][$strSiteCur][0]),2);
		if ($strSiteCur == "IDR") $intCurPrice = getRoundUp(($price / $intCurRate) * 100,2);
		else if ($strSiteCur == "RUB") $intCurPrice = getRoundUp(($price / $intCurRate),0);
		else $intCurPrice = getRoundUp(($price / $intCurRate),2);
	}

	$strCurPrice = number_format($intCurPrice,2);
	if ($strCurPrice == 0.00) $strCurPrice = 0;
	if ($strSiteCur == "KRW" || $strSiteCur == "JPY" || $strSiteCur == "RUB") {
		if ($S_ST_CUR != $strSiteCur) $strCurPrice = number_format(getRoundWonUp($intCurPrice));
		else $strCurPrice = number_format($intCurPrice);
	}

	return $strCurPrice;
}


/* 현지 통화로 변경 (기준 -> 언어별 통화) */
// FOB, EXW 반영으로 새로 만듬.
function getCurToPriceFilter($price, $lang = "",$curRate = 0, $FT)
{
	global $S_SITE_LNG;
	global $S_SITE_CUR;
	global $S_ARY_CUR;
	global $S_ARY_NAT_CUR;
	global $S_ARY_NAT_USER_CUR;
	global $S_ST_CUR;

	//소수점 표시
	$decimals = 2;

	$strSiteLng = $lang;
	if ($lang == ""){
		$strSiteLng = $S_SITE_LNG;
	}

	$strSiteCur		= $S_ARY_NAT_CUR[$strSiteLng];
	if (is_array($S_ARY_NAT_USER_CUR)){
		$strSiteCur	= $S_ARY_NAT_USER_CUR[$strSiteLng];
	}


	//$intCurRate 쇼핑몰 환율
	$intCurRate		= $S_ARY_CUR[$strSiteLng][$strSiteCur][0];
	if ($curRate > 0) $intCurRate = $curRate;


	if($FT == 'FOB'){
		if($strSiteLng=='CN'){ // USD를 인민화로 변환.
			$wonPrice = $price * $S_ARY_CUR["US"]["USD"][0];
			//return getRoundUp(($wonPrice / $intCurRate),2);
			return number_format($wonPrice / $intCurRate,$decimals);
		}else{ //US, KR
			return number_format($price,$decimals);
		}

	}else{ //EXW
		if($strSiteLng=='KR'){
			//return number_format($price,$decimals);
			return number_format($price);
		}else{//US,CN
			//return getRoundUp(($price / $intCurRate),2);
			return number_format($price / $intCurRate,$decimals);
		}
	}

}


/* 현지 통화로 변경 (기준 -> 언어별 통화 : DB 저장될때 사용 ',' 제거) */
function getCurToPriceSave($price, $lang = "")
{
	global $S_SITE_LNG;
	global $S_SITE_CUR;
	global $S_ARY_CUR;
	global $S_ARY_NAT_CUR;
	global $S_ARY_NAT_USER_CUR;
	global $S_ST_CUR;

	$strSiteLng = $lang;
	if ($lang == ""){
		$strSiteLng = $S_SITE_LNG;
	}
	$strSiteCur = $S_ARY_NAT_CUR[$strSiteLng];
	if (is_array($S_ARY_NAT_USER_CUR)){
		$strSiteCur	= $S_ARY_NAT_USER_CUR[$strSiteLng];
	}
	$intCurPrice = $price;

	if ($S_ARY_CUR[$strSiteLng][$strSiteCur][0] != 1) {
		//$intCurPrice = ceil(($price * $S_ARY_CUR[$S_SITE_LNG][$S_SITE_CUR][0]) * 100)/100;
		//$intCurPrice = getRoundDown($price * $S_ARY_CUR[$S_SITE_LNG][$S_SITE_CUR][0],2);

		if ($strSiteCur == "IDR") $intCurPrice = getRoundUp(($price / $S_ARY_CUR[$strSiteLng][$strSiteCur][0]) * 100,2);
		else if ($strSiteCur == "RUB") $intCurPrice = getRoundUp(($price / $S_ARY_CUR[$strSiteLng][$strSiteCur][0]),0);
		else $intCurPrice = getRoundUp(($price / $S_ARY_CUR[$strSiteLng][$strSiteCur][0]),2);
	}

	$intCurPrice = str_replace(",","",number_format($intCurPrice,2));
	if ($strSiteCur == "KRW" || $strSiteCur == "JPY" || $strSiteCur == "RUB") {
		if ($S_ST_CUR != $strSiteCur) {
			$intCurPrice = str_replace(",","",number_format(getRoundWonUp($intCurPrice)));
		} else $intCurPrice = str_replace(",","",number_format($intCurPrice));
	}
	return $intCurPrice;
}

/* 스크랩핑에 사용(한국 통화 -> 기준통화로 변경 / DB 저장될때 사용 ',' 제거) */
function getScrPriceToCur($price)
{
	global $S_ARY_CUR;

	$intCurPrice = $price;
	if ($S_ARY_CUR["KR"]["KRW"][0] != 1) {
		//$intCurPrice = getRoundDown(($price * $S_ARY_CUR["KR"]["KRW"][0]),2);
		$intCurPrice = getRoundUp(($price / $S_ARY_CUR["KR"]["KRW"][0]),2);
	}

	$intCurPrice = str_replace(",","",number_format($intCurPrice,2));
	if ($S_SITE_CUR == "KRW" || $S_SITE_CUR == "JPY" || $S_SITE_CUR == "RUB") {
		$intCurPrice = str_replace(",","",number_format($intCurPrice));
	}
	return $intCurPrice;
}

/* 결제시 현재 결제한 통화코드로 결제할 수 없을 경우 USD 통화로 변경 */
function getPriceToUsd($price,$lang="")
{
	global $S_ARY_CUR;
	global $S_SITE_LNG;
	global $S_SITE_CUR;

	$strSiteLng = $lang;
	if (!$strSiteLng) $strSiteLng = $S_SITE_LNG;

	$intCurPrice = $price;
	if ($S_ARY_CUR[$strSiteLng][$S_SITE_CUR][0] != 1) {
		$intCurPrice = getRoundUp($price / $S_ARY_CUR["US"]["USD"][0],2);
	}

	$intCurPrice = str_replace(",","",number_format($intCurPrice,2));
	return $intCurPrice;
}


/* 국가별 통화에서 기준통화로 금액 변경 */
function getPriceToCur($price,$siteCur = "")
{
	global $S_SITE_LNG;
	global $S_SITE_CUR;
	global $S_ARY_CUR;

	$strSiteCur = $S_SITE_CUR;
	if ($siteCur) $strSiteCur = $siteCur;

	$intCurPrice = $price;
	if ($S_ARY_CUR[$S_SITE_LNG][$strSiteCur][0] != 1) {
		$intCurPrice = getRoundUp($price * $S_ARY_CUR[$S_SITE_LNG][$strSiteCur][0]);
	}

	if ($S_SITE_CUR == "KRW"  || $S_SITE_CUR == "RUB" || $S_SITE_CUR == "JPY") {
		$intCurPrice = str_replace(",","",number_format((float)$intCurPrice,0));
	} else {
		$intCurPrice = str_replace(",","",number_format((float)$intCurPrice,2));
	}

	return $intCurPrice;
}

/* 금액 표기 */
function getFormatPrice($price,$point,$siteCur = "")
{
	global $S_SITE_CUR;

	$strSiteCur = $S_SITE_CUR;
	if ($siteCur) $strSiteCur = $siteCur;
	if ($price > 0 || $price < 0) {
		$strFormatPrice = NUMBER_FORMAT($price,$point);
		if ($strSiteCur == "KRW" || $strSiteCur == "JPY" || $strSiteCur == "RUB") {
			//if ($strSiteCur == "KRW") $strFormatPrice = NUMBER_FORMAT(getTruncateDown($price,2));
			//else $strFormatPrice = NUMBER_FORMAT($price);
			$strFormatPrice = NUMBER_FORMAT($price);
		}
	} else {
		$strFormatPrice = 0;
	}

	return $strFormatPrice;
}

/* 현지 통화로 계산 */
function getPriceCal($price, $siteCur = "")
{
	global $S_SITE_CUR;
	global $S_ST_CUR;

	$strSiteCur = $S_SITE_CUR;
	if ($siteCur) $strSiteCur = $siteCur;

	if ($price > 0) {
		if (in_array($strSiteCur,array("KRW","JPY","RUB"))) $price = getRoundWonUp($price);
		else $price = getRoundUp($price,2);
	}

	return $price;
}

function getProdEventInfo($row,$admType="N")
{
	global $S_EVENT_INFO;

	$no = $row[P_EVENT];

	if ($no > 0){

		if ($S_EVENT_INFO[$no]["TITLE"]){

			$arySiteEventInfo = $S_EVENT_INFO[$no];

			if ($arySiteEventInfo["TYPE"] == "N"){
				if ($arySiteEventInfo["DAY_TIME"] == "1") {
					if ($arySiteEventInfo["DAY_TYPE"] == "1"){
						//->신상품/일
						$eventEnd = date( 'Y-m-d H:i:s' , strtotime ( $row['P_REG_DT'] ) + ( 86400 * $arySiteEventInfo["DAY"] ) ) ;
						if (date("Y-m-d H:i:s")< $eventEnd )
							$strSiteEventYN = "Y";
					}

					if ($arySiteEventInfo["DAY_TYPE"] == "2"){
						$eventEnd = date( 'Y-m-d H:i:s' , strtotime ( $row['P_REG_DT'] ) + ( 3600 * $arySiteEventInfo["DAY"] ) ) ;
						if (date("Y-m-d H:i:s")< $eventEnd )
							$strSiteEventYN = "Y";
					}
				}
				$S_EVENT_INFO[$row[P_EVENT]]['START_DT'] 	= $row['P_REG_DT'] ;
				$S_EVENT_INFO[$row[P_EVENT]]['END_DT'] 		= $eventEnd ;
			} else {
				if (date("Y-m-d H:i:s") >= $arySiteEventInfo["START_DT"] && date("Y-m-d H:i:s") <= $arySiteEventInfo["END_DT"]){
					$strSiteEventYN = "Y";
				}
			}

			/* 관리자호출인경우에는 할인구매권한을 확인하지 않는다 */
			if ($admType == "N"){
				if ($strSiteEventYN == "Y" && $arySiteEventInfo["SELL_AUTH"] == "2" && (!$g_member_login || !$g_member_no)){
					$strSiteEventYN = "N";
				}
			}
		}
	}

	return $strSiteEventYN;
}

/*
	설명 : 회원별 상품별 판매가격 변경
*/
function getProdDiscountPrice($row,$priceType="1",$price=0,$lang="")
{
	global $db;

	global $g_member_login;
	global $g_member_no;
	global $g_member_group;
	global $S_MEMBER_GROUP;
	global $S_SITE_CUR;
	global $S_EVENT_INFO;
	global $S_ST_CUR;
	global $S_ARY_NAT_CUR;
	global $S_SHOP_HOME;
	if ($price > 0) $intProdPrice = $price;
	else $intProdPrice = $row[P_SALE_PRICE];

	$strSiteCur	= $S_ST_CUR;
	if ($lang) {
		$strSiteCur	= $S_ARY_NAT_CUR[$lang];
	}

	$strSiteEventYN = "N"; //이벤트 상품 유무
	if ($row[P_EVENT] > 0){
		if ($S_EVENT_INFO[$row[P_EVENT]]["TITLE"]){

			$arySiteEventInfo = $S_EVENT_INFO[$row[P_EVENT]];

			if ($arySiteEventInfo["TYPE"] == "N"){
				if ($arySiteEventInfo["DAY_TIME"] == "1") {
					if ($arySiteEventInfo["DAY_TYPE"] == "1"){
						//->신상품/일
						$eventEnd = date( 'Y-m-d H:i:s' , strtotime ( $row['P_REG_DT'] ) + ( 86400 * $arySiteEventInfo["DAY"] ) ) ;
						if (date("Y-m-d H:i:s")< $eventEnd )
							$strSiteEventYN = "Y";
					}

					if ($arySiteEventInfo["DAY_TYPE"] == "2"){
						$eventEnd = date( 'Y-m-d H:i:s' , strtotime ( $row['P_REG_DT'] ) + ( 3600 * $arySiteEventInfo["DAY"] ) ) ;
						if (date("Y-m-d H:i:s")< $eventEnd )
							$strSiteEventYN = "Y";
					}
				}
				$S_EVENT_INFO[$row[P_EVENT]]['START_DT'] 	= $row['P_REG_DT'] ;
				$S_EVENT_INFO[$row[P_EVENT]]['END_DT'] 		= $eventEnd ;
			} else {
				if (date("Y-m-d H:i:s") >= $arySiteEventInfo["START_DT"] && date("Y-m-d H:i:s") <= $arySiteEventInfo["END_DT"]){
					$strSiteEventYN = "Y";
				}
			}

			if ($strSiteEventYN == "Y" && $arySiteEventInfo["SELL_AUTH"] == "2" && (!$g_member_login || !$g_member_no)){
				$strSiteEventYN = "N";
			}
		}
	}

	if ($g_member_login && $g_member_no){

		/* 상품 기간/할인 상품*/
		if ($strSiteEventYN == "Y"){
			$intProdPrice = getProdEventPrice($intProdPrice, $arySiteEventInfo["PRICE_TYPE"], $arySiteEventInfo["PRICE"], $arySiteEventInfo["PRICE_OFF"]);
			if ($arySiteEventInfo["DISCOUNT_USE"] == "N"){
				if ($priceType == "1") return getCurToPrice($intProdPrice,$lang);
				else return $intProdPrice;
			}
		}

		/* 할인 제외 상품 유무 */
		if (is_array($S_MEMBER_GROUP[$g_member_group]["EXP_PROD"]) && in_array($row[P_CODE], $S_MEMBER_GROUP[$g_member_group]["EXP_PROD"])){

			if ($priceType == "1") return getCurToPrice($intProdPrice,$lang);
			else return $intProdPrice;
		}

		/* 할인 제외 카테고리 유무 */
		if (is_array($S_MEMBER_GROUP[$g_member_group]["EXP_CATE"])){
			if (in_array(SUBSTR($row[P_CATE],0,3), $S_MEMBER_GROUP[$g_member_group]["EXP_CATE"]) || in_array(SUBSTR($row[P_CATE],0,6), $S_MEMBER_GROUP[$g_member_group]["EXP_CATE"]) || in_array(SUBSTR($row[P_CATE],0,9), $S_MEMBER_GROUP[$g_member_group]["EXP_CATE"]) || in_array(SUBSTR($row[P_CATE],0,12), $S_MEMBER_GROUP[$g_member_group]["EXP_CATE"])){

				if ($priceType == "1") return getCurToPrice($intProdPrice,$lang);
				else return $intProdPrice;
			}
		}

		/* 추가할인혜택 유무 */
		if ($S_MEMBER_GROUP[$g_member_group]["ADD_DISCOUNT"] == "Y" && $intProdPrice >= $S_MEMBER_GROUP[$g_member_group]["ADD_DISCOUNT_PRICE"]){
			/* 추가할인혜택 단위 - % */
			if ($S_MEMBER_GROUP[$g_member_group]["ADD_DISCOUNT_UNIT"] == "1"){
				$intProdPrice = $intProdPrice - ($intProdPrice * ($S_MEMBER_GROUP[$g_member_group]["ADD_DISCOUNT_RATE"]/100));
			}

			/* 추가할인혜택 단위 - 원 */
			if ($S_MEMBER_GROUP[$g_member_group]["ADD_DISCOUNT_UNIT"] == "2"){
				$intProdPrice = $intProdPrice - $S_MEMBER_GROUP[$g_member_group]["ADD_DISCOUNT_RATE"];
			}


			/* 추가할인혜택 단위 (절삭)(2013.08.01 - 절삭자리수수정)*/
			if ($S_MEMBER_GROUP[$g_member_group]["ADD_DISCOUNT_OFF"] == 1) {
				if (!$S_MEMBER_GROUP[$g_member_group]["ADD_DISCOUNT_POINT"]) $S_MEMBER_GROUP[$g_member_group]["ADD_DISCOUNT_POINT"] = "1";

				if ($strSiteCur == "KRW") {
					$intProdPrice = getTruncateDown($intProdPrice,$S_MEMBER_GROUP[$g_member_group]["ADD_DISCOUNT_POINT"]);
				} else {
					$intProdPrice = getTruncateDown($intProdPrice,-$S_MEMBER_GROUP[$g_member_group]["ADD_DISCOUNT_POINT"]);
				}
			}

			/* 추가할인혜택 단위 (반올림)*/
			if ($S_MEMBER_GROUP[$g_member_group]["ADD_DISCOUNT_OFF"] == 2) {
				if (!$S_MEMBER_GROUP[$g_member_group]["ADD_DISCOUNT_POINT"]) $S_MEMBER_GROUP[$g_member_group]["ADD_DISCOUNT_POINT"] = "1";

				if ($strSiteCur == "KRW") {
					$intProdPrice = round($intProdPrice,-$S_MEMBER_GROUP[$g_member_group]["ADD_DISCOUNT_POINT"]);
				} else {
					$intProdPrice = round($intProdPrice,$S_MEMBER_GROUP[$g_member_group]["ADD_DISCOUNT_POINT"]);
				}
			}
		}

		if ($priceType == "1") return getCurToPrice($intProdPrice,$lang);
		else if ($priceType == "2") return getCurToPriceSave($intProdPrice,$lang);
		else return $intProdPrice;

	} else {

		/* 상품 기간/할인 상품*/
		if ($strSiteEventYN == "Y"){
			$intProdPrice = getProdEventPrice($intProdPrice, $S_EVENT_INFO[$row[P_EVENT]]["PRICE_TYPE"], $S_EVENT_INFO[$row[P_EVENT]]["PRICE"], $S_EVENT_INFO[$row[P_EVENT]]["PRICE_OFF"]);

			if ($priceType == "1") return getCurToPrice($intProdPrice,$lang);
			else return getCurToPriceSave($intProdPrice,$lang);

		}

		if ($priceType == "1") return getCurToPrice($intProdPrice,$lang);
		else if ($priceType == "2") return getCurToPriceSave($intProdPrice,$lang);
		else return $intProdPrice;
	}
}

/*
	설명 : 통합수랑별할인적용
*/
function getProdAllDiscount($price,$qty)
{
	global $S_ALL_DISCOUNT_USE;
	global $S_ALL_DISCOUNT_VAL;
	global $S_SITE_CUR;

	$intPrice	= $price;
	$intQty		= $qty;

	if ($S_ALL_DISCOUNT_USE == "Y")
	{

		/* 통화별 올림 자리수 지정 */
		$intDiscountPos	= 2;
		if ($S_SITE_CUR == 'KRW' || $S_SITE_CUR == 'RUB'){
			$intDiscountPos = 0;
		}

		$arrAllDiscountInfo = explode("/",$S_ALL_DISCOUNT_VAL);
		foreach($arrAllDiscountInfo as $key => $val){
			if ($val)
			{
				$arrDiscountInfo	= explode(":",$val);
				$arrDiscountQty		= explode("~",$arrDiscountInfo[0]);
				$intDiscountMinQty	= ($arrDiscountQty[0]) ? $arrDiscountQty[0] : 0;
				$intDiscountMaxQty	= ($arrDiscountQty[1]) ? $arrDiscountQty[1] : 999999999999;
				$intDiscountRate	= $arrDiscountInfo[1];

				$intDiscountPrice	= 0;

				if ($intQty >= $intDiscountMinQty && $intQty <= $intDiscountMaxQty)
				{

					if ($intDiscountPos == 0) $intDiscountPrice	= getRoundWonUp($price * ($intDiscountRate/100),2);
					else $intDiscountPrice	= getRoundUp($price * ($intDiscountRate/100),2);
					$intPrice			= $price - $intDiscountPrice;
					break;
				}
			}
		}
	}

	return $intPrice;
}

/*
 ** 설명 : 총주문합의 할인적용
 */
function getProdTotalPriceAllDiscount($price,$rate)
{
	global $S_FIX_ORDER_TOTAL_DISCOUNT_USE;

	$intPrice	= $price;
	$intRate	= $rate;

	if ($S_FIX_ORDER_TOTAL_DISCOUNT_USE == "Y"){

		/* 통화별 올림 자리수 지정 */
		$intDiscountPos	= 2;
		if ($S_SITE_CUR == 'KRW' || $S_SITE_CUR == 'RUB'){
			$intDiscountPos = 0;
		}

		if ($intDiscountPos == 0) $intDiscountPrice	= getRoundWonUp($price * ($intRate/100),2);
		else $intDiscountPrice	= getRoundUp($price * ($intRate/100),2);
	}

	return $intDiscountPrice;
}

/*
 ** 설명 : 화페단위표시
 */
function getCurUnitMark()
{
	global $S_SITE_LNG;
	global $S_SITE_CUR_MARK1;
	global $S_SITE_CUR_MARK2;

	$strMoneyIconL	= "";
	$strMoneyIconR	= "";
	if (!in_array($S_SITE_LNG,array("KR","JP","RU"))){
		$strMoneyIconL = $S_SITE_CUR_MARK1;
	} else {
		if ($S_SITE_LNG == "JP") $strMoneyIconR = $S_SITE_CUR_MARK1;
		else if ($S_SITE_LNG == "RU") $strMoneyIconR = $S_SITE_CUR_MARK1;
		else $strMoneyIconR = $S_SITE_CUR_MARK2;
	}

	$array["L"] = $strMoneyIconL;
	$array["R"] = $strMoneyIconR;

	return $array;
}
?>