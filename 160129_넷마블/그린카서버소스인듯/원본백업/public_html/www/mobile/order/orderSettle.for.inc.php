<input type="hidden" name="payPg" id="payPg" value="<?=$S_FOR_PG?>">
<input type="hidden" name="pay_method" id="pay_method" value="">
<input type="hidden" name="deliveryWeight" id="deliveryWeight" value="<?=$intCartProdWeight?>">
<input type="hidden" name="good_mny" id="good_mny" value="<?=getCurToPriceSave($intCartPriceEndTotal)?>" size="10" maxlength="9"/>
<input type="hidden" name="good_delivery" id="good_delivery" value="<?=getCurToPriceSave($intDeliveryTotal)?>"/>
<input type="hidden" name="good_point_use" id="good_point_use" value="<?=getCurToPriceSave($intCartPointUsePrice)?>"/>
<input type="hidden" name="good_point_no_use_cnt" id="good_point_no_use_cnt" value="<?=$intCartPointNoUseCnt?>"/>
<input type="hidden" name="good_point_no_use" id="good_point_no_use" value="<?=getCurToPriceSave($intCartPointNoUsePrice)?>"/>

