<?
	## 설정
	$http_referef = $_SERVER['HTTP_REFERER'];
	if($_REQUEST['http_referer']) { $http_referef = $_REQUEST['http_referer']; }

	
	#ie 에서의 문제로 인해 강제로 이동페이지 지정 2015.07.08 kjp
	if(strpos($http_referef,"prodCompare")){
		$http_referef = './?menuType=product&mode=list&lcate=001';
	}
	## 비밀번호 찾기,로그인 페이지 불러올때는 
//	if(eregi("menuType=member&mode=findIdPwd", $http_referef)) { $http_referef = "./"; }
//	else if(eregi("menuType=member&mode=login", $http_referef)) { $http_referef = "./"; }
?>

<form name="form" method="post" id="form">
<input type="hidden" name="menuType" value="<?=$strMenuType?>">
<input type="hidden" name="mode" value="<?=$strMode?>">
<input type="hidden" name="act" value="<?=$strMode?>">
<input type="hidden" name="target" value="<?=$strPageTarget?>">
<input type="hidden" name="clickType" value="<?=$strLayerClickType?>">

<input type="hidden" name="sRequestName" value="<?=$strRequestName?>">
<input type="hidden" name="sRequestNO" value="<?=$strRequestNo?>">
<input type="hidden" name="sSafeId" value="<?=$strRequestSafeId?>">
<input type="hidden" name="sEnctype" value="<?=$strRequestEncType?>">
<input type="hidden" name="basketDirect" value="">
<input type="hidden" name="http_referer" value="<?=$http_referef?>">
<input type="hidden" name="joinType" value="<?=$strMemberJoinType?>">