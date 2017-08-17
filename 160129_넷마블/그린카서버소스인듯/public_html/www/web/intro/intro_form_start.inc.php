<?
	## 설정
	$http_referef = $_SERVER['HTTP_REFERER'];
	if($_REQUEST['http_referer']) { $http_referef = $_REQUEST['http_referer']; }
?>

<form name="form" method="post" id="form">
<input type="hidden" name="menuType" value="<?=$strMenuType?>">
<input type="hidden" name="mode" value="<?=$strMode?>">
<input type="hidden" name="act" value="<?=$strMode?>">
<input type="hidden" name="target" value="<?=$strPageTarget?>">
<input type="hidden" name="http_referer" value="<?=$http_referef?>">