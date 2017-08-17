<? 
	## 설정
	$tableName						= "DataMgr"; 

	## 선택항목 삭제 버튼 설정
	$select_list_del_btn_use		= "Y";
	
	## 글등록 버튼 설정
	$write_btn_use					= "Y";

	## 게시판 복사 필드 설정
	$copy_field_use					= "Y";

	## 입점사 로그인일때 설정
	## 2014.04.28 kim hee sung 입점사업체문의사항(S_REQ) 게시판은 등록수정삭제 기능이 되도록 변경함
	if($_REQUEST['member_type'] == "S" && $_REQUEST['b_code'] != "S_REQ"):
		$select_list_del_btn_use		= "";
		$write_btn_use					= "";
		$copy_field_use					= "";
	endif;

	$intPage = $_REQUEST['page'];
	if(!$intPage) { $intPage = 1; }
	$intPage = number_format($intPage);
?>

<div class="contentTop">
	<h2>커뮤니티 내용 (<?=$_REQUEST['BOARD_INFO']['b_name']?>)</h2>
	<div class="clr"></div>
</div>

<div class="tabImgWrap">
<?php include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/board/basic.2.0/modify.tabMenu.skin.php" ?>
</div>

<?if(in_array($_REQUEST['BOARD_INFO']['bi_category_use'], array("Y","A")) && $_REQUEST['b_code'] != "USER_REPORT"): // 카테고리 사용?>
<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/category/include.1.0/text.inc.skin.php" ?>
<?endif;?>

<br>

<?if($_REQUEST['BOARD_INFO']['bi_point_use'] == "Y"): //포인트 기능 사용 ?>
<div class="tableForm" alt="이벤트 스킨(정보)">
<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/eventInfo/include.1.0/pointView.inc.skin.php" ?>
</div>
<?endif;?>

<br>


<div class="searchTableWrap mt20" style="margin:0 10px 0 10px;">
<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/common/search.1.0/dataSearch.skin.php" ?>
</div>
<br>
<div class="tableList">
<strong><?=NUMBER_FORMAT($_REQUEST['result']['DataMgr']['pageResult']['list_total'])// 총 데이터 수?></strong>(<?=$intPage // 현재 페이지?>/<?=$_REQUEST['result']['DataMgr']['pageResult']['page_total'] // 총 페이지 수?>Page)
<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/common/listCnt.1.0/dataListCnt.skin.php" ?>
<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/data/basic.1.0/list.skin.php" ?>
</div>

<br>

<?if($_REQUEST['BOARD_INFO']['bi_point_use'] == "Y"): //포인트 기능 사용 ?>
<div class="tableForm" alt="이벤트 스킨(발급)">
<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/eventInfo/include.1.0/pointSet.inc.skin.php" ?>
</div>
<?endif;?>

<br>

<div class="paginate mt20">
<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/common/page.1.0/list.page.skin.php" ?>
</div>


<div class="button">
	<?if($select_list_del_btn_use == "Y"):?>
	<a class="btn_big" href="javascript:goDataDeleteMultiActEvent();" id="menu_auth_d" style="display:none"><strong>선택항목 삭제</strong></a>	
	<?endif;?>
	<?if($write_btn_use == "Y"):?>
	<a class="btn_big" href="javascript:goDataWriteMove();" id="menu_auth_w" style="display:none"><strong>등록</strong></a>
	<?endif;?>
	<?if($copy_field_use == "Y"):?>
	<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/common/dataTransfer.1.0/dataTransfer.inc.skin.php" ?>
	<?endif;?>
	<?if($S_BOARD_ICON_USE == "Y"):?>
	<select id="iconName">
		<option value="">선택하세요.</option>
		<?foreach($S_BOARD_ICON_LIST as $data):?>
		<option value="<?=$data?>"><?=$data?></option>
		<?endforeach;?>
	</select>
	<a class="btn_big" href="javascript:goDataIconWriteActEvent();" id="menu_auth_d" style="display:none"><strong>아이콘 설정</strong></a>	
	<?endif;?>
</div>


<input type="hidden" name="b_code" id="b_code" value="<?=$_REQUEST['b_code']?>">
<input type="hidden" name="ub_no"  id="ub_no"  value="">