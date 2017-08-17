<? 
	## 모듈 설정
	$objAdminMgrModule = new AdminMgrModule($db);

	## 설명
	## 2013.07.02, kim hee sung, 상품 뷰페이지에서 사용후기에서 카테고리가 나오는데, 숨김 처리. iframe 으로 구분하였는데 나중에 review 게시판으로 고정시킬수 있음.
	## 설정
	$tableName		= "DataMgr"; 
	$list_total		= $_REQUEST['result'][$tableName]['pageResult']['list_total'];
	$page			= $_REQUEST['result'][$tableName]['pageResult']['page'];
	$page_total		= $_REQUEST['result'][$tableName]['pageResult']['page_total'];
	$target			= $_REQUEST['myTarget'];
	
	## 해당 상품을 구매한 회원인지 확인
	$intMemberProductOrderCnt = $_REQUEST['result']['member_product_order_cnt'];
	
	## 최고 관리자는 글을 작성할수 있도록 합니다.
	if($_SESSION['member_no']):
		$param = "";
		$param['M_NO'] = $_SESSION['member_no'];
		$intAdminCnt = $objAdminMgrModule->getAdminMgrSelectEx("OP_COUNT", $param);
		if($intAdminCnt) { $intMemberProductOrderCnt = 1; }
	endif;

	## 글쓰기 권한 설정
	$isWriteBtnShow				= false;

?>

<?if($_REQUEST['BOARD_INFO']['bi_category_list_use'] == "Y" && in_array($_REQUEST['BOARD_INFO']['bi_category_use'], array("Y","A"))):?>
<?if($target != "iframe"):?>
<div class="tabBtnWrap">
	<?include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/user/community/category/include.1.0/{$_REQUEST['BOARD_INFO']['bi_category_skin']}.inc.skin.php";?>
</div>
<?endif;?>
<?endif;?>

<div class="tableList">
	<div class="boardTopWrap">
		<?if($target != "iframe"):?>
		<div class="boardCntWrap"><strong><?=NUMBER_FORMAT($list_total)// 총 데이터 수?></strong>(<?=$page // 현재 페이지?>/<?=$page_total // 총 페이지 수?>Page)</div>
		<div class="boardTopSearchWrap"><? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/user/community/common/search.1.0/search.skin.php" ?></div>
		<div class="clear"></div>
		<?endif;?>
	</div>
	<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/user/community/data/basic.1.0/list.skin.php" ?>
</div>

<?php if(!($target != "iframe" && $_REQUEST['b_code'] == "PROD_QNA")):?>
<?if($_REQUEST['buttonLock']['dataWrite']==1): //글쓰기권한 ?>
<div class="btnRight<?if(in_array($_REQUEST['buttonLock']['dataWrite'], array(1,2))){echo " right";}?>">
	<?if($_REQUEST['BOARD_INFO']['b_code'] == "PROD_REVIEW"  && $intMemberProductOrderCnt == 0){?>
	<a href="javascript:goDataWriteAuthMove();" id="menu_auth_w" class="btn_board_write"><strong><?=$LNG_TRANS_CHAR["CW00052"]//글쓰기?></strong></a>
	<?}elseif($_REQUEST['BOARD_INFO']['b_code'] == "PROD_REVIEW"  && $intMemberProductOrderCnt > 0){?>
	<a href="javascript:goDataWriteMoveEvent();" id="menu_auth_w" class="btn_board_write"><strong><?=$LNG_TRANS_CHAR["CW00052"]//글쓰기?></strong></a>
	<?}else{?>
	<a href="javascript:goDataWriteMoveEvent();" id="menu_auth_w" class="btn_board_write"><strong><?=$LNG_TRANS_CHAR["CW00052"]//글쓰기?></strong></a>
	<?}?>
</div>

<?elseif($_REQUEST['buttonLock']['dataWrite']==2):?>
<div class="btnRight<?if(in_array($_REQUEST['buttonLock']['dataWrite'], array(1,2))){echo " right";}?>">
	<a href="javascript:goLoginPageMoveEvent('<?=$S_MAIN_LAYERPOP_LOGIN_USE?>')" id="menu_auth_w"  class="btn_board_write"><strong><?=$LNG_TRANS_CHAR["CW00052"]//글쓰기?></strong></a>
</div>
<?endif;?>
<?php endif;?>


<div class="paginate<?if(in_array($_REQUEST['buttonLock']['dataWrite'], array(1,2))){echo "_left";}?>">
<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/user/community/common/page.1.0/list.page.skin.php" ?>
</div>
<div class="clear"></div>

<input type="hidden" name="b_code" id="b_code" value="<?=$_REQUEST['b_code']?>">
<input type="hidden" name="ub_no"  id="ub_no"  value="">
<input type="hidden" name="ub_bc_no"  id="ub_bc_no"  value="<?=$_REQUEST['ub_bc_no']?>">
<input type="hidden" name="ub_p_code"  id="ub_p_code"  value="<?=$_REQUEST['ub_p_code']?>">