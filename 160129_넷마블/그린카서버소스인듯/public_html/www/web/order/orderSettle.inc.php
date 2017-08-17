<input type="hidden" name="payPg" id="payPg" value="<?=$S_PG?>">

<?
    /* = -------------------------------------------------------------------------- = */
    /* =   1. 주문 정보 입력 END                                                    = */
    /* ============================================================================== */
?>
<input type="hidden" name="pay_method" id="pay_method" value="100000000000">
<input type="hidden" name="ordr_idxx" id="ordr_idxx" maxlength="40" value=""/>
<input type="hidden" name="good_name" value=""/>
<?if ($S_SHOP_ID=="1ehanaclub" || ($S_SHOP_HOME=="demo2" && $g_member_id == "devAdmin")){?>
<input type="text" name="good_mny" id="good_mny" value="<?=getCurToPriceSave($intCartPriceEndTotal)?>" size="10" maxlength="9"/>
<?}else{?>
<input type="hidden" name="good_mny" id="good_mny" value="<?=getCurToPriceSave($intCartPriceEndTotal)?>" size="10" maxlength="9"/>
<?}?>
<input type="hidden" name="order_no" value=""/>
<input type="hidden" name="good_delivery" id="good_delivery" value="<?=getCurToPriceSave($intDeliveryTotal)?>"/>
<input type="hidden" name="good_point_use" id="good_point_use" value="<?=getCurToPriceSave($intCartPointUsePrice)?>"/>
<input type="hidden" name="good_point_no_use_cnt" id="good_point_no_use_cnt" value="<?=$intCartPointNoUseCnt?>"/>
<input type="hidden" name="good_point_no_use" id="good_point_no_use" value="<?=getCurToPriceSave($intCartPointNoUsePrice)?>"/>
<input type="hidden" name="orderCartPriceTotal" id="orderCartPriceTotal" value="<?=getCurToPriceSave($intCartPriceTotal)?>">
<input type="hidden" name="orderCartProdCouponUsePriceTotal" id="orderCartProdCouponUsePriceTotal" value="<?=getCurToPriceSave($intCartProdCouponUsePriceTotal)?>">
<?
	switch ($S_PG){
		case "K":
			include "orderSettle.kcp.inc.php";
		break;
		case "A":
			include "orderSettle.ags.inc.php";
		break;
		case "N":
			include "orderSettle.ksnet.inc.php";
		break;
		case "I":
			// INIpay50
			include MALL_SHOP . "/_INIescrow50/source/orderSettle.iniescrow.inc.php";		
		break;
	}

?>


