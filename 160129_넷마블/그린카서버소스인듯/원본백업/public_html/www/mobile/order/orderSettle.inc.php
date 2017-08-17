<input type="hidden" name="payPg" id="payPg" value="<?=$S_PG?>">

<input type="hidden" name="pay_method" id="pay_method" value="100000000000">
<input type="hidden" name="ordr_idxx" id="ordr_idxx" maxlength="40" value=""/>
<input type="hidden" name="good_name" value=""/>
<input type="hidden" name="good_mny" id="good_mny" value="<?=getCurToPriceSave($intCartPriceEndTotal)?>" size="10" maxlength="9"/>
<input type="hidden" name="order_no" value=""/>
<input type="hidden" name="good_delivery" id="good_delivery" value="<?=getCurToPriceSave($intDeliveryTotal)?>"/>
<input type="hidden" name="good_point_use" id="good_point_use" value="<?=getCurToPriceSave($intCartPointUsePrice)?>"/>
<input type="hidden" name="good_point_no_use_cnt" id="good_point_no_use_cnt" value="<?=$intCartPointNoUseCnt?>"/>
<input type="hidden" name="good_point_no_use" id="good_point_no_use" value="<?=getCurToPriceSave($intCartPointNoUsePrice)?>"/>

<input type="hidden" name="nextStep" id="nextStep" value="orderStep2"/>
<input type="hidden" name="good_cart" id="good_cart" value=""/>

<input type="hidden" name="req_tx"          value="pay" />
<?
	switch ($S_PG){
		case "K":
			include "orderSettle.kcp.inc.php";
		break;
	}
?>