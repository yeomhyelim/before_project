<?php
	## 스크립트 설정 
	$aryScriptEx[] = "/common/eumEditor2/js/eumEditor2.js";
	$aryScriptEx[] = "./common/js/product/brand/prodBrandWrite.js";

	## 에디터 사진 저장 경로 설정
	$strEditorDir = "product/brand"; 

?>
<script language="JavaScript" type="text/javascript" src="../common/eumEditor/highgardenEditor.js"></script>
<script type="text/javascript">
//<![CDATA[
	 /** 자바 스크립트 전역변수 설정 **/
	var rootDir 	= "../../common/eumEditor/highgardenEditor";
	var uploadImg 	= "/editor/brand";
	var uploadFile 	= "../kr/index.php";
	var htmlYN		= "Y";
//]]>
</script>

<input type="hidden"  style="width:300px;" id="pr_m_no" name="pr_m_no" />

<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["MM00063"] //브랜드관리?></h2>
		<div class="clr"></div>
	</div>
	
	<!-- ******** 컨텐츠 ********* -->
	<div class="tableFormWrap">
		<table class="tableForm">
			<tr>
				<th><?=$LNG_TRANS_CHAR["MM00064"] //브랜드명?></th>
				<td colspan="3">
					<input type="text" <?=$nBox?>  style="width:600px;" id="pr_name" name="pr_name" maxlength="25" />
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00199"] //브랜드 담당자?></th>
				<td colspan="3">
					<input type="text" <?=$nBox?>  style="width:300px;" id="pr_m_id" name="pr_m_id" maxlength="25" readOnly />
					<a class="btn_big" href="javascript:goSearchBrandManager();"><strong>검색</strong></a>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00200"] //브랜드 정렬?></th>
				<td colspan="3">
					<input type="text" <?=$nBox?>  style="width:300px;" id="pr_align" name="pr_align" maxlength="25" value=""  />
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00201"] //브랜드 목록이미지?></th>
				<td colspan="3">
					<input type="file" <?=$nBox?>  id="pr_list_img" name="pr_list_img"/>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00202"] //브랜드 타이틀이미지?></th>
				<td colspan="3">
					<input type="file" <?=$nBox?>  id="pr_title_img" name="pr_title_img"/>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00203"] //브랜드 상세이미지?></th>
				<td colspan="3">
					<input type="file" <?=$nBox?>  id="pr_view_img" name="pr_view_img"/>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00204"] //브랜드 추가이미지?></th>
				<td colspan="3">
					<input type="file" <?=$nBox?>  id="pr_add_img" name="pr_add_img"/>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00205"] //간략설명?></th>
				<td colspan="3">
					<textarea style="width:100%;height:100px;" id="pr_comment" name="pr_comment" maxlength="500"></textarea>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00206"] //설명(HTML)?></th>
				<td colspan="3">
					<?php include MALL_SHOP . "/common/eumEditor2/editor1.php";?>
					<textarea name="pr_html" style="display:none"></textarea>
				</td>
			</tr>
		</table>
	</div>
	<div class="buttonBoxWrap">
		<a class="btn_new_blue" href="javascript:void(0);" onclick="goProductBrandWriteActEvent();" id="menu_auth_w"><strong class="ico_write"><?=$LNG_TRANS_CHAR["CW00002"]	//등록?></strong></a>
		<a class="btn_new_gray" href="javascript:goMoveUrl('prodBrandList','');"><strong class="ico_cancel"><?=$LNG_TRANS_CHAR["CW00008"]	//취소?></strong></a>
	</div>
</div>
</body>
</html>