<?
	## 상품평 리스트 불러오기
	require_once MALL_HOME . "/modules/community/data/basic.1.0/community.data.view.php";
	$dataView														= new CommunityDataView($db,  $_REQUEST);
	$param															= "";
	$param['b_code']												= "PROD_REVIEW";
	$param['ub_no']													= $_REQUEST['ub_no'];
	$_REQUEST['result']["DataMgr"]									= $dataView->getListEx("OP_SELECT", $param);

	## 첨부파일 필드
	require_once MALL_HOME . "/modules/community/attachedfile/basic.1.0/community.attachedfile.view.php";
	$attachedfileView												= new CommunityAttachedfileView($db,  $_REQUEST);
	$param															= "";
	$param['b_code']												= "PROD_REVIEW";
	$param['ub_no']													= $_REQUEST['ub_no'];
	$_REQUEST['result']['AttachedfileMgr']							= $attachedfileView->getListNoPageEx("OP_SELECT", $param);

	## 설정 정보
	include_once "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/community/board.PROD_REVIEW.info.php";
	$_REQUEST['BOARD_INFO']											= $BOARD_INFO['PROD_REVIEW'];

	## 권한 설정
	// 수정, 삭제
	$tempAuth = 1;
	if($_REQUEST['member_login'] == 1):
		// 로그인 OK
		if($_REQUEST['result']["DataMgr"]['UB_M_NO'] > 0):
			// 회원 글
			if($_REQUEST['result']["DataMgr"]['UB_M_NO'] == $_REQUEST['member_no']) { $tempAuth = 1; } // 작성된 글과 로그인 한 회원이 같은 경우.
			else { $tempAuth = 0; } // 작성된 글과 로그인 한 회원이 다른 경우.
		else:
			// 비회원 글
			$tempAuth = 0;
		endif;
	else:
		// 로그인 NO
		if($_REQUEST['result']["DataMgr"]['UB_M_NO'] > 0) { $tempAuth = 0; } // 회원 글
		else { $tempAuth = 1; } // 비회원 글
	endif;

	$_REQUEST['buttonLock']['dataModify'] = $tempAuth;  // 수정
?>
<?include "top.inc.php"; ?>
	<input type="hidden" name="ub_no" value="<?=$_REQUEST['result']["DataMgr"]['UB_NO']?>">
	<input type="hidden" name="b_code" value="PROD_REVIEW">
	<!-- start: contentArea -->
	<div id="minishopContentArea">		
		<div id="minishopContentWrap">
			<div class="tableForm">
				<? include "{$S_DOCUMENT_ROOT}www/skins/user/community/data/basic.1.0/modify.skin.php" ?>
			</div>
			<div class="btnCenter">
				<?if($_REQUEST['buttonLock']['dataModify']): //수정권한 ?>
				<a href="javascript:goDataModifyActEvent();" id="menu_auth_w" class="btn_board_modify"><strong><?=$LNG_TRANS_CHAR["OW00072"] //글쓰기?></strong></a>
				<?endif;?>
				<a href="javascript:goDataModifyCancelMoveEvent();"   id="menu_auth_w" class="btn_board_cancel"><strong><?=$LNG_TRANS_CHAR["MW00044"] //취소?></strong></a>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<!-- end: contentArea -->

