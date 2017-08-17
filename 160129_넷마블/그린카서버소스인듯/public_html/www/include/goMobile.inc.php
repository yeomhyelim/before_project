<?php

	## 기본 설정
	$strHttpHost = $_SERVER['HTTP_HOST'];
	$aryHttpHost = explode(".", $strHttpHost);
	$strTemp = "web";

	## 모바일인지 체크
	if($aryHttpHost[0] == "m") { $strTemp = "mobile"; }
	$mobilechk = '/(iPod|iPhone|Android|BlackBerry|SymbianOS|SCH-M\d+|Opera Mini|Windows CE|Nokia|SonyEricsson|webOS|PalmOS)/i';
	if(preg_match($mobilechk, $_SERVER['HTTP_USER_AGENT'])) { $strTemp = "mobile"; }
	
	## 모바일 체크
	if($strTemp == "web") { return; }
	
?>
<!--<a href="javascript:C_getHostTypeChangeActEvent('mobile')" target="_blank" class="btn_go_mobile">모바일 버전</a>-->
<style>
	.button {margin-top:10px;padding:0;text-align:center;}
</style>
<div class="button">
	<span >
			접속하신 단말/브라우저에서 Fingbook가 제공하는 일부 기능이 작동하지 않을 수 있다는 점 양해부탁드립니다.
	</span>
	
	<div>
		<br />
		<a href="javascript:C_getHostTypeChangeActEvent('mobile')" target="_blank" class="btnProdWish_new">모바일 버전</a>
	</div>
	<br />

</div>