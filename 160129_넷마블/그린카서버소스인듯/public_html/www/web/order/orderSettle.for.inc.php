<input type="hidden" name="payPg" id="payPg" value="<?=$S_FOR_PG?>">
<input type="hidden" name="pay_method" id="pay_method" value="">
<input type="hidden" name="deliveryWeight" id="deliveryWeight" value="<?=$intCartProdWeight?>">

<?if ($S_SHOP_HOME=="demo1" || ($S_SHOP_HOME=="demo2" && $g_member_id == "devAdmin")){?>
<input type="text" name="good_mny" id="good_mny" value="<?=getCurToPriceSave($intCartPriceEndTotal)?>" size="10" maxlength="9"/>
<?}else{?>
<input type="hidden" name="good_mny" id="good_mny" value="<?=getCurToPriceSave($intCartPriceEndTotal)?>" size="10" maxlength="9"/>
<?}?>
<input type="hidden" name="good_delivery" id="good_delivery" value="<?=getCurToPriceSave($intDeliveryTotal)?>"/>
<input type="hidden" name="good_point_use" id="good_point_use" value="<?=getCurToPriceSave($intCartPointUsePrice)?>"/>
<input type="hidden" name="good_point_no_use_cnt" id="good_point_no_use_cnt" value="<?=$intCartPointNoUseCnt?>"/>
<input type="hidden" name="good_point_no_use" id="good_point_no_use" value="<?=getCurToPriceSave($intCartPointNoUsePrice)?>"/>


<input type="hidden" name="orderCartPriceTotal" id="orderCartPriceTotal" value="<?=getCurToPriceSave($intCartPriceTotal)?>">

<input type="hidden" name="orderCartDeliveryProdCnt" id="orderCartDeliveryProdCnt" value="<?=$intForDeliveryPriceProdCnt?>">
<input type="hidden" name="orderCartProdCouponUsePriceTotal" id="orderCartProdCouponUsePriceTotal" value="<?=getCurToPriceSave($intCartProdCouponUsePriceTotal)?>">
<input type="hidden" name="orderCartProdCouponUsePriceUsdTotal" id="orderCartProdCouponUsePriceUsdTotal" value="<?=$intCartProdCouponUsePriceUsdTotal?>">
