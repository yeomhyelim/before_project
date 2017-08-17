<?php 
	## 스크립트 설정 
	$aryScriptEx[] = "/common/eumEditor2/js/eumEditor2.js";
	$aryScriptEx[] = "./common/js/productEtc/delRetHelp.js";


?>

<div id="contentArea">
<div class="contentTop">
	<h2><?=$LNG_TRANS_CHAR["PW00080"] //배송/반품교환 안내?></h2>
	<div class="clr"></div>
</div>


<!-- 언어 선택 탭 -->
	<?include "./include/tab_language.inc.php";?>
<!-- 언어 선택 탭-->

<!-- ******** 컨텐츠 ********* -->
<div class="tableFormWrap">
	<h3><?=$LNG_TRANS_CHAR["PW00081"] //배송 안내?></h3>
	<table class="tableForm">
		<tr>
			<td>
				<?php include MALL_SHOP . "/common/eumEditor2/editor1.php";?>
				<textarea name="s_prod_delivery" style="display:none"><?=$row["S_PROD_DELIVERY_{$strLang}"]?></textarea>
			</td>
		</tr>
	</table>
	
	<h3><?=$LNG_TRANS_CHAR["PW00082"] //반품 교환?></h3>
	<table class="tableForm">
		<tr>
			<td>
				<?php include MALL_SHOP . "/common/eumEditor2/editor2.php";?>
				<textarea name="s_prod_return" style="display:none"><?=$row["S_PROD_RETURN_{$strLang}"]?></textarea>
			</td>
		</tr>
	</table>
</div>

<div class="buttonBoxWrap">
	<a class="btn_new_blue" href="javascript:void(0);" onclick="goProductEtcDelRetHelpModifyActEvent();" id="menu_auth_m" style="display:none:"><strong class="ico_write"><?=$LNG_TRANS_CHAR["CW00002"] //등록?></strong></a>
	<a class="btn_new_gray" href="javascript:history.back();"><strong class="ico_cancel"><?=$LNG_TRANS_CHAR["CW00008"] //취소?></strong></a>
</div>
<!-- ******** 컨텐츠 ********* -->