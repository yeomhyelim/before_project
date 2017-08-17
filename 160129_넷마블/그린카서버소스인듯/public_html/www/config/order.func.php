<?
#/*====================================================================*/# 
#|화일명	: order.func.php											|#
#|작성자	: 박영미													|#
#|작성일	: 2013.07.04												|#
#|작성내용	: 주문에 관련된 함수										|#
#/*====================================================================*/# 


##############################################################
# 주문시 지급되어야 할 포인트 및											 #	
##############################################################


function getOrderMemberGivePoint($param){
	
	global $S_POINT_USE1;
	global $S_POINT_ST;
	global $S_POINT_ST_PRICE;
	global $S_POINT_USE2;
	global $S_POINT_COUPON_USE;	
	
	$intOrderTotalPrice		= $param["orderTotalPrice"];				//주문총상품금액
	$intOrderTotalSPrice	= $param["orderTotalSPrice"];				//주문금액(실제결제금액)
	$intO_USE_POINT			= $param["orderUsePoint"];					//주문시 사용된 포인트
	$intO_USE_COUPON		= $param["orderUseCoupon"];					//주문시 사용된 쿠폰 금액
	$intMemberGradeAddPoint	= $param["orderMemberGradeAddPoint"];		//회원등급별 추가된 포인트 금액
	
	$strO_SETTLE			= $param["orderSettle"];					//주문결제방법
	
	$intOrderTotalPoint = 0;
	/* 적립금 지급 기준에 따른 포인트 */
	if ($S_POINT_USE1 == "Y") {
		
		if ($S_POINT_ST == "P") {
			/* 판매가 기준 */
			if ($intOrderTotalPrice < $S_POINT_ST_PRICE){
				$intOrderTotalPoint = 0;
			}
		} else {
			/* 결제가격 기준/ 결제방법이 포인트가 아니면 */
			if ($strO_SETTLE != "P"){
				if ($intOrderTotalSPrice < $S_POINT_ST_PRICE){
					$intOrderTotalPoint = 0;
				} 					
			} else {
				$intOrderTotalPoint = 0;
			}
		}

		/* 적립금을 사용한 주문은 상품적립금을 지급하지 않음 */
		if ($intO_USE_POINT > 0 && $S_POINT_USE2 == "N") {
			$intOrderTotalPoint = 0;
		}
	} else {
		/* 적림금 관리를 사용하지 않음 */
		$intOrderTotalPoint = 0;
	}
	
	/* 쿠폰사용금액이 있을 경우 적립금 사용유무 */
	if ($intO_USE_COUPON > 0 && $S_POINT_COUPON_USE == "N"){
		$intOrderTotalPoint = 0;
	}

	/* 회원 등급별 추가 적립금 지급 */
	if ($intMemberGradeAddPoint > 0) {
		$intOrderTotalPoint = $intOrderTotalPoint + $intMemberGradeAddPoint;
	}

	return $intOrderTotalPoint;
}


function getOrderMemberGradeDiscount($param)
{	
	global $S_MEMBER_GROUP;
	global $S_ST_CUR;

	$intM_NO					= $param["M_NO"];
	$strM_GROUP					= $param["M_GROUP"];

	$intOrderTotalPrice			= $param["orderTotalPrice"];				//주문총상품금액
	$intOrderTaxTotal			= $param["orderTotTaxPrice"];				//주문시과세금액
	$intOrderTotalDeliveryPrice = $param["orderTotalDeliveryPrice"];		//주문시배송총금액
	$intOrderPgCommissionTotal  = $param["orderTotPgCommissionPrice"];		//주문시수수료
	if (!$intOrderPgCommissionTotal) $intOrderPgCommissionTotal = 0;

	$intOrderTotalSPrice		= $param["orderTotalSPrice"];				//주문금액(실제결제금액)
	$intO_USE_POINT				= $param["orderUsePoint"];					//주문시 사용된 포인트
	$intO_USE_COUPON			= $param["orderUseCoupon"];					//주문시 사용된 쿠폰 금액
	
	$strMoneyCurStType			= $param["orderMoneyCurStType"];			//주문시 기준통화("Y")/언어통화("N")

	$intMemberGradeDiscountPrice = $intMemberGradeAddPoint = 0;
	if(($intM_NO > 0) && ($S_MEMBER_GROUP[$strM_GROUP]["DISCOUNT_ST"] != "1"))
	{
		/* 등급기준 : 주문금액 */
		$intMemberGradeOrderTotalPrice = 0;
		if ($S_MEMBER_GROUP[$strM_GROUP]["PRICE_ST"] == "P"){
			$intMemberGradeOrderTotalPrice = $intOrderTotalPrice + $intOrderTaxTotal + $intOrderTotalDeliveryPrice + $intOrderPgCommissionTotal; //총주문금액 : 기준통화
		}

		if ($S_MEMBER_GROUP[$strM_GROUP]["PRICE_ST"] == "S"){
			$intMemberGradeOrderTotalPrice = getPriceToCur($intOrderTotalSPrice); //총결제금액 : 기준통화
			if ($strMoneyCurStType == "Y"){
				$intMemberGradeOrderTotalPrice = getPriceToCur($intOrderTotalSPrice,$S_ST_CUR); //총결제금액 : 기준통화
			}
		}


		/* 추가할인 */
		if ($S_MEMBER_GROUP[$strM_GROUP]["DISCOUNT_ST"] == "2" || $S_MEMBER_GROUP[$strM_GROUP]["DISCOUNT_ST"] == "4"){
			if ($intMemberGradeOrderTotalPrice >= $S_MEMBER_GROUP[$strM_GROUP]["DISCOUNT_PRICE"]){
				
				/* 할인혜택 단위 - % */
				if ($S_MEMBER_GROUP[$strM_GROUP]["DISCOUNT_UNIT"] == "1"){
					$intMemberGradeDiscountPrice = ($intMemberGradeOrderTotalPrice * ($S_MEMBER_GROUP[$strM_GROUP]["DISCOUNT_RATE"]/100));
				}

				/* 할인혜택 단위 - 원 */
				if ($S_MEMBER_GROUP[$strM_GROUP]["DISCOUNT_UNIT"] == "2"){
					$intMemberGradeDiscountPrice = $S_MEMBER_GROUP[$strM_GROUP]["DISCOUNT_RATE"];
				}
				
				/* 할인혜택 단위 (절삭)*/
				if ($S_MEMBER_GROUP[$strM_GROUP]["DISCOUNT_OFF"] == 1) {
					if (!$S_MEMBER_GROUP[$strM_GROUP]["DISCOUNT_POINT"]) $S_MEMBER_GROUP[$strM_GROUP]["DISCOUNT_POINT"] = "1";

					if ($S_ST_CUR == "KRW") {
						$intMemberGradeDiscountPrice = getTruncateDown($intMemberGradeDiscountPrice,$S_MEMBER_GROUP[$strM_GROUP]["DISCOUNT_POINT"]);
					} else {
						$intMemberGradeDiscountPrice = getTruncateDown($intMemberGradeDiscountPrice,-$S_MEMBER_GROUP[$strM_GROUP]["DISCOUNT_POINT"]);
					}
				}

				/* 할인혜택 단위 (반올림)*/
				if ($S_MEMBER_GROUP[$strM_GROUP]["DISCOUNT_OFF"] == 2) {
					if (!$S_MEMBER_GROUP[$strM_GROUP]["DISCOUNT_POINT"]) $S_MEMBER_GROUP[$strM_GROUP]["DISCOUNT_POINT"] = "1";
					if ($S_ST_CUR == "KRW") {
						$intMemberGradeDiscountPrice = round($intMemberGradeDiscountPrice,-$S_MEMBER_GROUP[$strM_GROUP]["DISCOUNT_POINT"]);
					} else {
						$intMemberGradeDiscountPrice = round($intMemberGradeDiscountPrice,$S_MEMBER_GROUP[$strM_GROUP]["DISCOUNT_POINT"]);
					}
				}
			} 
		}

		/* 추가포인트 적립 */
		if ($S_MEMBER_GROUP[$strM_GROUP]["DISCOUNT_ST"] == "3" || $S_MEMBER_GROUP[$strM_GROUP]["DISCOUNT_ST"] == "4"){
			if ($intMemberGradeOrderTotalPrice >= $S_MEMBER_GROUP[$strM_GROUP]["POINT_PRICE"]){
				
				/* 추가포인트 단위 - % */
				if ($S_MEMBER_GROUP[$strM_GROUP]["POINT_UNIT"] == "1"){
					$intMemberGradeAddPoint = $intMemberGradeOrderTotalPrice * ($S_MEMBER_GROUP[$strM_GROUP]["POINT_RATE"]/100);
				}

				/* 추가포인트 단위 - 원 */
				if ($S_MEMBER_GROUP[$strM_GROUP]["POINT_UNIT"] == "2"){
					$intMemberGradeAddPoint = $S_MEMBER_GROUP[$strM_GROUP]["POINT_RATE"];
				}
				
				/* 추가포인트 단위 (절삭)*/
				if ($S_MEMBER_GROUP[$strM_GROUP]["POINT_OFF"] == 1) {
					if (!$S_MEMBER_GROUP[$strM_GROUP]["POINT_POINT"]) $S_MEMBER_GROUP[$strM_GROUP]["POINT_POINT"] = "0";
					if ($S_ST_CUR == "KRW") {
						$intMemberGradeAddPoint = getTruncateDown($intMemberGradeAddPoint,$S_MEMBER_GROUP[$strM_GROUP]["POINT_POINT"]);
					} else {
						$intMemberGradeAddPoint = getTruncateDown($intMemberGradeAddPoint,-$S_MEMBER_GROUP[$strM_GROUP]["POINT_POINT"]);
					}
				}

				/* 추가포인트 단위 (반올림)*/
				if ($S_MEMBER_GROUP[$strM_GROUP]["POINT_OFF"] == 2) {
					if (!$S_MEMBER_GROUP[$strM_GROUP]["POINT_POINT"]) $S_MEMBER_GROUP[$strM_GROUP]["POINT_POINT"] = "0";
					if ($S_ST_CUR == "KRW") {
						$intMemberGradeAddPoint = round($intMemberGradeAddPoint,-$S_MEMBER_GROUP[$strM_GROUP]["POINT_POINT"]);
					} else {
						$intMemberGradeAddPoint = round($intMemberGradeAddPoint,$S_MEMBER_GROUP[$strM_GROUP]["POINT_POINT"]);
					}
				}
			} 
		}
	}


	$aryMemberDiscountGradeInfo["DISCOUNT_PRICE"]	= $intMemberGradeDiscountPrice;
	$aryMemberDiscountGradeInfo["ADD_POINT"]		= $intMemberGradeAddPoint;

	return $aryMemberDiscountGradeInfo;
}
?>