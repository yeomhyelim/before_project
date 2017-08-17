<?php 
	## include 설정
	include_once WEB_FRWORK_HELP . "member.php";

	## 이전 사이트 주소 설정
	$http_referef = $_SERVER['HTTP_REFERER'];
	if($_REQUEST['http_referer']) { $http_referef = $_REQUEST['http_referer']; }
?>

<form name="form" method="post" id="form">
<input type="hidden" name="menuType" value="<?=$strMenuType?>">
<input type="hidden" name="mode" value="<?=$strMode?>">
<input type="hidden" name="act" value="<?=$strMode?>">
<input type="hidden" name="target" value="<?=$strPageTarget?>">
<input type="hidden" name="clickType" value="<?=$strLayerClickType?>">
<input type="hidden" name="basketDirect" value="">
<input type="hidden" name="http_referer" value="<?=$http_referef?>">
	<?php
	## 회원가입 신청
	//include_once MALL_HOME . "/mobile/member/member_MI0001.inc.php";
	include_once MALL_HOME . "/mobile/member/member_joinStep_form.inc.php";
	?>
</form>