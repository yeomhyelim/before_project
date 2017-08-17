<?
	## 설정
	$tableName			= "DataMgr";
	$prveRow			= $_REQUEST['result'][$tableName]['prveRow'];
	$nextRow			= $_REQUEST['result'][$tableName]['nextRow'];	
	
	/** 이전글 **/
	$aryFunc			= $dataView->getUB_FUNC_DECODER($prveRow);
	$lock				= $dataView->getLockAuthCheck($prveRow);
	/* 링크 권한 설정*/
	$linkModePrve = "1";
	if($_REQUEST['BOARD_INFO']['bi_dataview_use'] == "A"):			// 모든회원/비회원=A
		if($aryFunc['UB_FUNC_LOCK'] == "Y"): // 비밀글 인경우
			if($lock['member'] == "1" && $lock['check'] == "1")			{ $linkModePrve = "1"; }
			else if($lock['member'] == "1" && $lock['check'] == "0")	{ $linkModePrve = "2"; }
			else														{ $linkModePrve = "0"; }; 
			## 관리자회원은 페이지 이동
			if($_REQUEST['member_group'] == "001")						{ $linkModePrve = "1"; }
		endif;
	elseif($_REQUEST['BOARD_INFO']['bi_dataview_use'] == "M"):		// 회원전용=M
		## 회원 전용 페이지에서 로그인을 하지 않은 회원은 로그인 페이지로 이동
		if(!$_REQUEST['member_login']) { $linkModePrve = "2"; }
		else {
			## 비밀글이라면 메시지 출력
			if($aryFunc['UB_FUNC_LOCK'] == "Y") { $linkModePrve = "3"; }
			## 나의 글이라면 페이지 이동
			if($lock['check'] == 1) { $linkModePrve = "1"; }
			## 관리자회원은 페이지 이동
			if($_REQUEST['member_group'] == "001") { $linkModePrve = "1"; }
		}
	endif;
	/* 링크 권한 설정*/

	/** 다음글 **/
	$aryFunc			= $dataView->getUB_FUNC_DECODER($nextRow);
	$lock				= $dataView->getLockAuthCheck($nextRow);
	/* 링크 권한 설정*/
	$linkModeNext = "1";
	if($_REQUEST['BOARD_INFO']['bi_dataview_use'] == "A"):			// 모든회원/비회원=A
		if($aryFunc['UB_FUNC_LOCK'] == "Y"): // 비밀글 인경우
			if($lock['member'] == "1" && $lock['check'] == "1")			{ $linkModeNext = "1"; }
			else if($lock['member'] == "1" && $lock['check'] == "0")	{ $linkModeNext = "2"; }
			else														{ $linkModeNext = "0"; }; 
			## 관리자회원은 페이지 이동
			if($_REQUEST['member_group'] == "001")						{ $linkModeNext = "1"; }
		endif;
	elseif($_REQUEST['BOARD_INFO']['bi_dataview_use'] == "M"):		// 회원전용=M
		## 회원 전용 페이지에서 로그인을 하지 않은 회원은 로그인 페이지로 이동
		if(!$_REQUEST['member_login']) { $linkModeNext = "2"; }
		else {
			## 비밀글이라면 메시지 출력
			if($aryFunc['UB_FUNC_LOCK'] == "Y") { $linkModeNext = "3"; }
			## 나의 글이라면 페이지 이동
			if($lock['check'] == 1) { $linkModeNext = "1"; }
			## 관리자회원은 페이지 이동
			if($_REQUEST['member_group'] == "001") { $linkModeNext = "1"; }
		}
	endif;
	/* 링크 권한 설정*/

?>

<div class="nextTextWrap">
	<ul>
		<?if($prveRow['UB_NO']):?>
		<li class="prveList"><strong><?=$LNG_TRANS_CHAR["MW00052"] //이전?></strong><span>
			<?if($linkModePrve==0):?>
			<img src="/himg/board/A0001/icon_bbs_lock.png"> <a onClick="goDataViewPassMoveEvent('<?=$prveRow['UB_NO']?>')" ><?=strHanCutUtf2($prveRow['UB_TITLE'],$_REQUEST['BOARD_INFO']['bi_datalist_title_len'],'N')?></a>
			<?elseif($linkModePrve==1):?>
			<a href="javascript:goDataViewMoveEvent('<?=$prveRow['UB_NO']?>')"><?=strHanCutUtf2($prveRow['UB_TITLE'],$_REQUEST['BOARD_INFO']['bi_datalist_title_len'],'N')?></a>
			<?elseif($linkModePrve==2):?>
			<img src="/himg/board/A0001/icon_bbs_lock.png"> <a onClick="goLoginPageMoveEvent('<?=$S_MAIN_LAYERPOP_LOGIN_USE?>')"><?=strHanCutUtf2($prveRow['UB_TITLE'],$_REQUEST['BOARD_INFO']['bi_datalist_title_len'],'N')?></a>
			<?elseif($linkModePrve==3):?>
			<img src="/himg/board/A0001/icon_bbs_lock.png"> <a onClick="goSecretTextMoveEvent()"><?=strHanCutUtf2($prveRow['UB_TITLE'],$_REQUEST['BOARD_INFO']['bi_datalist_title_len'],'N')?></a>
			<?endif;?>
		</span></li>
		<?endif;?>
		<?if($nextRow['UB_NO']):?>
		<li class="nextList"><strong><?=$LNG_TRANS_CHAR["MW00043"] //다음?></strong><span>
			<?if($linkModeNext==0):?>
			<img src="/himg/board/A0001/icon_bbs_lock.png"> <a onClick="goDataViewPassMoveEvent('<?=$nextRow['UB_NO']?>')" ><?=strHanCutUtf2($nextRow['UB_TITLE'],$_REQUEST['BOARD_INFO']['bi_datalist_title_len'],'N')?></a>
			<?elseif($linkModeNext==1):?>
			<a href="javascript:goDataViewMoveEvent('<?=$nextRow['UB_NO']?>')"><?=strHanCutUtf2($nextRow['UB_TITLE'],$_REQUEST['BOARD_INFO']['bi_datalist_title_len'],'N')?></a>
			<?elseif($linkModeNext==2):?>
			<img src="/himg/board/A0001/icon_bbs_lock.png"> <a onClick="goLoginPageMoveEvent('<?=$S_MAIN_LAYERPOP_LOGIN_USE?>')"><?=strHanCutUtf2($nextRow['UB_TITLE'],$_REQUEST['BOARD_INFO']['bi_datalist_title_len'],'N')?></a>
			<?elseif($linkModeNext==3):?>
			<img src="/himg/board/A0001/icon_bbs_lock.png"> <a onClick="goSecretTextMoveEvent()"><?=strHanCutUtf2($nextRow['UB_TITLE'],$_REQUEST['BOARD_INFO']['bi_datalist_title_len'],'N')?></a>
			<?endif;?>
		</span></li>
		<?endif;?>
	</ul>
</div>