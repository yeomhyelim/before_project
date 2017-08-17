<?
	## helper 설정
	include WEB_FRWORK_HELP."mypage.php";
?>


<form name="form" method="post" id="form">
<input type="hidden" name="menuType" value="<?=$strMenuType?>">
<input type="hidden" name="mode" value="<?=$strMode?>">
<input type="hidden" name="act" value="<?=$strMode?>">
<input type="hidden" name="page" value="<?=$intPage?>">
<input type="hidden" name="no" id="no" value="">
<input type="hidden" name="cartPage" value="<?=$intCartPage?>">
<input type="hidden" name="wishPage" value="<?=$intWishPage?>">
<input type="hidden" name="searchField" value="<?=$strSearchField?>">
<input type="hidden" name="searchKey" value="<?=$strSearchKey?>">
<input type="hidden" name="searchOrderStatus" value="<?=$strSearchOrderStatus?>">
<input type="hidden" name="searchOrderKey" value="<?=$strSearchOrderKey?>">
<input type="hidden" name="searchOrderName" value="<?=$strSearchOrderName?>">
<input type="hidden" name="lcate" value="<?=$strSearchHCode1?>">
<input type="hidden" name="mcate" value="<?=$strSearchHCode2?>">
<input type="hidden" name="scate" value="<?=$strSearchHCode3?>">
<input type="hidden" name="fcate" value="<?=$strSearchHCode4?>">
<input type="hidden" name="oNo" value="<?=$intO_NO?>">
<input type="hidden" name="returnMenu" value="">
<input type="hidden" name="returnMode" value="">
<input type="hidden" name="pr_no" id="pr_no" value="<?=$intPR_NO?>">

<?php
	## 주문관리
	include_once MALL_HOME . "/mobile/mypage/order_buyView.inc.php";
?>

</form>