<?php 

	/* 레이아웃 include 파일 경로 */
	$incFile 		= sprintf( "./include/design/design_type_%s_%s.inc.php", $strLayoutPage, $layoutRow['DL_CODE'] );
	
	// 레이아웃 이미지 영역 클릭시 이동되는 경로
	$layoutToHref 	= sprintf( "./?menuType=design&mode=maindesignModify&layoutPage=%s&layoutView=%s", $strLayoutPage, $strLayoutView );
	
	// 원본 소스의 config 파일 경로
	$configFile 		= sprintf( "%swww/html/%s%s/config.inc.php" , $S_DOCUMENT_ROOT, $layoutRow['DL_CODE'], $layoutRow['DL_DESIGN_CODE'] );
	
	// 편집화면 버튼을 클릭 했을때, 이동 경로
	$editToHref	= sprintf( "./?menuType=design&mode=maindesignModify&layoutPage=%s&editPage=%s&layoutView=%s&de_no=1", $strLayoutPage, $strEditPage, "edit" );
	
	// 원본화면 버튼을 클릭 했을때, 이동 경로
	$originalToHref	= sprintf( "./?menuType=design&mode=maindesignModify&layoutPage=%s&editPage=%s&layoutView=%s&de_no=1", $strLayoutPage, $strEditPage, "original" );
	
	if ( $strLayoutView == "edit" ) :
		// 현재 적용된 소스, 수정되어진 소스
		$userEditFile	= sprintf( "%s%s/layout/html/tag_%s_%s.inc.php", $S_DOCUMENT_ROOT, $S_SHOP_HOME, $strLayoutPage, $strEditPage );
	else :
		// 원본 소스, 관리자가 처음 레이아웃 잡은 소스
		$userEditFile	= sprintf( "%swww/html/%s%s/%s_%s.inc.php", $S_DOCUMENT_ROOT, $layoutRow['DL_CODE'], $layoutRow['DL_DESIGN_CODE'], $strLayoutPage, $strEditPage );
	endif;
	

	include $configFile;

?>

<input type="hidden" name="layoutPage" value="<?= $strLayoutPage ?>" />
<input type="hidden" name="editPage" value="<?= $strEditPage ?>" />
<input type="hidden" name="layoutView" value="<?= $strLayoutView ?>" />
<input type="hidden" name="dl_code" value="<?= $layoutRow['DL_CODE'] ?>" />
<input type="hidden" name="dl_design_code" value="<?= $layoutRow['DL_DESIGN_CODE'] ?>" />

<script language=javascript>
	function layout_over(obj)
	{
		var layout_ = obj.src.split('.gif');
		obj.src = layout_[0] + '_on.gif';
	}

	function layout_out(obj)
	{
		var layout_ = obj.src.split('_on.gif');
		obj.src = layout_[0] + '.gif';
	}
</script>

<div class="contentTop">
	<h2>페이지 디자인 설정</h2>
</div>
<br>
<!-- ******** 컨텐츠 ********* -->
<?include "./include/tab_shopListType.inc.php";?>
<input type="hidden" name="de_edit_group" value="<?=$row[DE_EDIT_GROUP]?>"/>
<input type="hidden" name="de_edit_section" value="<?=$row[DE_EDIT_SECTION]?>"/>
<div class="tableForm mt20">
	<table>
		<tr>
			<th>레이아웃</th>
			<td><?	include $incFile;	?></td>
		</tr>
		<tr>
			<th>디자인선택</th>
			<td><input type="radio" name="" checked/>HTML</td>
		</tr>
	</table>
	<div class="designEditerWrap">
		<div class="tabBtnWrap">
			<div class="tabBtnLeft">
				<a href="<?= $editToHref ?>" class="btn_blue_big"><strong>편집화면</strong></a>
				<a href="<?= $originalToHref ?>" class="btn_big"><strong>원본화면</strong></a>
				<a href="javascript:goOpenWin('designTagList')" class="btn_big"><strong>예약어</strong></a>
				<strong class="editInfoTxt"><?=$row[DE_EDIT_GROUP]?> -> <span><?=$row[DE_EDIT_SECTION]?></span> 편집 중</strong>
			</div>
			<div class="btnRight">
				<a href="#" class="btn_blue_sml"><span>늘리기</span></a>
				<a href="#" class="btn_sml"><span>줄이기</span></a>
			</div>
			<div class="clear"></div>
		</div>
		<textarea name="de_edit_text" class="designEditForm"><? include $userEditFile?></textarea>
	</div><!-- designEditerWrap -->
	<div class="buttonWrap">
		<a class="btn_blue_big" href="javascript:goAction('maindesignModify');" id="menu_auth_w"><strong>바로적용하기</strong></a>
	</div>
</div><!-- tableForm -->

