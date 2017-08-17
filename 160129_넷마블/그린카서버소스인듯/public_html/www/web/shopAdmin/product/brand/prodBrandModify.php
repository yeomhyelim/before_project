<?php 
	## 스크립트 설정 
	$aryScriptEx[] = "/common/eumEditor2/js/eumEditor2.js";
	$aryScriptEx[] = "./common/js/product/brand/prodBrandModify.js";
	
	## 언어 설정
	$strLang = $_GET['lang'];
	if(!$strLang) { $strLang = $S_ST_LNG; }

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

<input type="hidden" name="pr_img_type" id="pr_img_type" value="">
<input type="hidden"  style="width:300px;" id="pr_m_no" name="pr_m_no" value="<?=$brandRow['PR_M_NO']?>">
<input type="hidden" name="lang" value="<?php echo $strLang;?>" />

<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["MM00063"] //브랜드관리?></h2>
		<div class="clr"></div>
	</div>
	
<!-- 언어 선택 탭 -->
	<?include "./include/tab_language.inc.php";?>
<!-- 언어 선택 탭-->
	
	<!-- ******** 컨텐츠 ********* -->
	<div class="tableFormWrap">
		<table class="tableForm">
			<tr>
				<th><?=$LNG_TRANS_CHAR["MM00064"] //브랜드명?></th>
				<td colspan="3">
					<input type="text" <?=$nBox?>  style="width:600px;" id="pr_name" name="pr_name" maxlength="25" value="<?=$brandRow['PR_NAME']?>" />
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00199"] //브랜드 담당자?></th>
				<td colspan="3">
					<input type="text" <?=$nBox?>  style="width:300px;" id="pr_m_id" name="pr_m_id" maxlength="25" value="<?=$brandRow['PR_M_ID']?>" readOnly />
					<a class="btn_big" href="javascript:goSearchBrandManager();"><strong>검색</strong></a>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00200"] //브랜드 정렬?></th>
				<td colspan="3">
					<input type="text" <?=$nBox?>  style="width:300px;" id="pr_align" name="pr_align" maxlength="25" value="<?=$brandRow['PR_ALIGN']?>"  />
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00201"] //브랜드 목록이미지?></th>
				<td colspan="3">
					<input type="file" <?=$nBox?>  id="pr_list_img" name="pr_list_img"/> 
					<? if($brandRow['PR_LIST_IMG']) : ?>
					<btn id="LIST">
						<div class="mt5">
							<img src="<?=$brandRow['PR_LIST_IMG']?>"/>
							<a href="javascript:goDeleteImg('LIST')">[삭제]</a>
						</div>
					</btn>
					<? endif; ?>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00202"] //브랜드 타이틀이미지?></th>
				<td colspan="3">
					<input type="file" <?=$nBox?>  id="pr_title_img" name="pr_title_img"/>
					<? if($brandRow['PR_TITLE_IMG']) : ?>
					<btn id="TITLE">
						<div class="mt5">
							<img src="<?=$brandRow['PR_TITLE_IMG']?>"/>
							<a href="javascript:goDeleteImg('TITLE')">[삭제]</a>
						</div>
					</btn>
					<? endif; ?>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00203"] //브랜드 상세이미지?></th>
				<td colspan="3">
					<input type="file" <?=$nBox?>  id="pr_view_img" name="pr_view_img"/>
					<? if($brandRow['PR_VIEW_IMG']) : ?>
					<btn id="VIEW">
						<div class="mt5">
							<img src="<?=$brandRow['PR_VIEW_IMG']?>"/>
							<a href="javascript:goDeleteImg('VIEW')">[삭제]</a>
						</div>
					</btn>
					<? endif; ?>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00204"] //브랜드 추가이미지?></th>
				<td colspan="3">
					<input type="file" <?=$nBox?>  id="pr_add_img" name="pr_add_img"/>
					<? if($brandRow['PR_ADD_IMG']) : ?>
					<btn id="ADD">
						<div class="mt5">
							<img src="<?=$brandRow['PR_ADD_IMG']?>"/>
							<a href="javascript:goDeleteImg('ADD')">[삭제]</a>
						</div>
					</btn>
					<? endif; ?>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00205"] //간략설명?></th>
				<td colspan="3">
					<textarea style="width:100%;height:100px;" id="pr_comment" name="pr_comment" maxlength="500"><?=$brandRow['PR_COMMENT']?></textarea>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00206"] //설명(HTML)?></th>
				<td colspan="3">
					<?php include MALL_SHOP . "/common/eumEditor2/editor1.php";?>
					<textarea name="pr_html" style="display:none"><?=$brandRow['PR_HTML']?></textarea>
				</td>
			</tr>
		</table>
	</div>
	<div class="buttonBoxWrap">
		<a class="btn_new_blue" href="javascript:void(0);" onclick="goProductBrandModifyActEvent();" id="menu_auth_m"><strong class="ico_modify">수정</strong></a>
		<a class="btn_new_gray" href="javascript:goMoveUrl('prodBrandList','');"><strong class="ico_list">목록</strong></a>
	</div>
</div>
</body>
</html>