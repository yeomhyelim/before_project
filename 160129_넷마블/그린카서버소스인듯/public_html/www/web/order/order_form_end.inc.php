</form>
<!-- Eximbay Settle -->
<?if ($intSiteSettleX == "Y"){?>
<form name="regForm" method="post">
<input type="hidden" name="ver" id="ver" value="140">
<input type="hidden" name="mid" id="mid" value="<?=${"S_EXIMBAY_".$strForSettleLang."_MID"}?>">
<input type="hidden" name="ref" id="ref" value="">
<input type="hidden" name="fgkey" id="fgkey" value="">
<input type="hidden" name="cur" id="cur" value="<?=$strForSettleCur?>">
<input type="hidden" name="amt" id="amt" value="">
<input type="hidden" name="product" id="product" value="">
<input type="hidden" name="param1" id="param1" value="">
<input type="hidden" name="param2" id="param2" value="">
<input type="hidden" name="param3" id="param3" value="">
<input type="hidden" name="buyer" id="buyer" value="">
<input type="hidden" name="tel" id="tel" value="">
<input type="hidden" name="email" id="email" value="">
<input type="hidden" name="shop" id="shop" value="">
<input type="hidden" name="lang" id="lang" value="<?=$strForSettleLang?>">
<input type="hidden" name="returnurl" id="returnurl" value="<?=$S_SITE_URL?>/common/eximbay/return.php">
<input type="hidden" name="statusurl" id="statusurl" value="<?=$S_SITE_URL?>/common/eximbay/status.php">
<input type="hidden" name="directToReturn" id="directToReturn" value="N">
<input type="hidden" name="rescode">
<input type="hidden" name="resmsg">
<input type="hidden" name="authcode">
<input type="hidden" name="cardco">
<input type="hidden" name="txntype" value="SALE">

<input type="hidden" name="payFlag" value="">
<input type="hidden" name="order_no" value="">
<input type="hidden" name="menuType" value="">
<input type="hidden" name="mode" value="">


</form>
<?}?>
<!-- Eximbay Settle -->