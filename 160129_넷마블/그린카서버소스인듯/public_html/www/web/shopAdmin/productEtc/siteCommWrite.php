<?php 
	## 스크립트 설정 
	$aryScriptEx[] = "/common/eumEditor2/js/eumEditor2.js";
	$aryScriptEx[] = "./common/js/productEtc/siteCommWrite.js";
?>
<div id="contentArea">
<div class="contentTop">
	<h2><?=$LNG_TRANS_CHAR["PW00105"] //공통관리?></h2>
	<div class="clr"></div>
</div>


<!-- ******** 컨텐츠 ********* -->

	<div class="tableForm">
		<table>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00106"] //제목?></th>
				<td><input type="text" <?=$nBox?> name="sc_title" id="sc_title" style="width:98%;"></td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00107"] //내용?></th>
				<td>
					<?php include MALL_SHOP . "/common/eumEditor2/editor1.php";?>
					<textarea name="sc_text" style="display:none"></textarea>
				</td>
			</tr>
		</table>
	</div><!-- tableList -->

	<div class="buttonBoxWrap">
		<a class="btn_new_blue" href="javascript:goProductEtcSiteCommWriteActEvent();" id="menu_auth_w" style="display:none:"><strong class="ico_write"><?=$LNG_TRANS_CHAR["CW00002"] //등록?></strong></a>
		<a class="btn_new_gray" href="javascript:goMoveUrl('siteCommList','')"><strong class="ico_cancel"><?=$LNG_TRANS_CHAR["CW00008"] //취소?></strong></a>
	</div>
<!-- ******** 컨텐츠 ********* -->
