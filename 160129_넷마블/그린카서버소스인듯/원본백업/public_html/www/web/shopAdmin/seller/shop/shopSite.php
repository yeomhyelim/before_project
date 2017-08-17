<?
	## 스크립트 설정 
	$aryScriptEx[] = "/common/eumEditor2/js/eumEditor2.js";
	$aryScriptEx[] = "./common/js/seller/shop/shopSite.js";

	## 파일 경로 설정
	if($storeRow['ST_LOGO'])		{ 	$st_logo		= "/upload/shop/store_{$storeRow['SH_NO']}/design/{$storeRow['ST_LOGO']}"; }
	if($storeRow['ST_IMG'])			{ 	$st_img			= "/upload/shop/store_{$storeRow['SH_NO']}/design/{$storeRow['ST_IMG']}"; }
	if($storeRow['ST_THUMB_IMG'])	{	$st_thumb_img	= "/upload/shop/store_{$storeRow['SH_NO']}/design/{$storeRow['ST_THUMB_IMG']}"; }
?>
<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["SW00024"] //상점 정보?></h2>
		<div class="clr"></div>
	</div>
	<div class="tabImgWrap mt10">
		<a href="javascript:javascript:goMoveUrl('shopModify','<?=$intSU_NO?>');">기본정보</a>			
		<a href="javascript:javascript:goMoveUrl('shopSetting','<?=$intSU_NO?>');">배송설정</a>
		<a href="javascript:javascript:goMoveUrl('shopUser','<?=$intSU_NO?>');">관리자등록</a>
		<a href="javascript:javascript:goMoveUrl('shopSite','<?=$intSU_NO?>');"  class="selected">기타설정</a>	
	</div>
	<!-- ******** 컨텐츠 ********* -->
	<div class="tableFormWrap">
		<!--  ****************  -->
		<h3 class="mt30"><?=$LNG_TRANS_CHAR["SW00027"] //기본정보?></h3>
		<table class="tableForm">
			<tr>
				<th><span class="mustItem"><?=$LNG_TRANS_CHAR["SW00028"] //이름?></span></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:300px;" id="store_name" name="store_name" value="<?=$storeRow[ST_NAME]?>"/>
				</td>
				<th><?=$LNG_TRANS_CHAR["SW00072"] //영문상점명?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:300px;" id="store_name_eng" name="store_name_eng" value="<?=$storeRow[ST_NAME_ENG]?>"/>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["SW00029"] //간략설명?></th>
				<td colspan="3">
					<input type="text" <?=$nBox?>  style="width:300px;" id="store_text" name="store_text" value="<?=$storeRow[ST_TEXT]?>"/>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["SW00031"] //상점 로고?></th>
				<td colspan="3">
					<?if($st_logo):?>
						<div class="thumbViewImg">
							<img src="<?=$st_logo?>" style="width:70px;height:70px">
							<input type="checkbox" name="store_logo_del" value="<?=$storeRow['ST_LOGO']?>"/> <?=$LNG_TRANS_CHAR["CW00004"]	//삭제?>
						</div>
					<?endif;?>
					<input type="file" <?=$nBox?>  id="store_logo" name="store_logo"/>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["SW00032"] //상점 이미지?></th>
				<td colspan="3">
					<?if($st_img):?>
						<div class="thumbViewImg">
							<img src="<?=$st_img?>">
							<input type="checkbox" name="store_img_del" value="<?=$storeRow['ST_IMG']?>"/> <?=$LNG_TRANS_CHAR["CW00004"]	//삭제?>
						</div>
					<?endif;?>
					<input type="file" <?=$nBox?>  id="store_img" name="store_img"/>
					
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["SW00033"] //상점 썸네일?></th>
				<td colspan="3">
					<?if($st_thumb_img):?>
						<div class="thumbViewImg">
							<img src="<?=$st_thumb_img?>">
							<input type="checkbox" name="store_thumb_img_del" value="<?=$storeRow['ST_THUMB_IMG']?>"/> <?=$LNG_TRANS_CHAR["CW00004"]	//삭제?>
						</div>
					<?endif;?>
					<input type="file" <?=$nBox?>  id="store_thumb_img" name="store_thumb_img"/>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["SW00030"] //설명?></th>
				<td colspan="3">
					<?php include MALL_SHOP . "/common/eumEditor2/editor1.php";?>
					<textarea name="store_memo" style="display:none"><?=$storeRow['ST_MEMO']?></textarea>
				</td>
			</tr>

		</table>
	</div>

	<div class="buttonBoxWrap">
		<a class="btn_new_blue" href="javascript:void(0);" onclick="goSellerShopSiteModifyActEvent()" id="menu_auth_m"><strong class="ico_modify"><?=$LNG_TRANS_CHAR["CW00003"] //수정?></strong></a>
		<?if($a_admin_type != "S"): // 입점몰 로그인은 목록 페이지 없음 ?>
		<a class="btn_new_gray" href="javascript:goMoveUrl('shopList','');"><strong class="ico_cancel"><?=$LNG_TRANS_CHAR["CW00001"] //취소?></strong></a>
		<?endif;?>
	</div>
</div>
<!-- ******** 컨텐츠 ********* -->