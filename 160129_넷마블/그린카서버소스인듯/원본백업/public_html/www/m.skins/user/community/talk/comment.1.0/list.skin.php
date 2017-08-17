<?
	## 설정
	$listImg		= "";
	$result			= $_REQUEST['result'][$tableName]['listResult'];
	$list_total		= $_REQUEST['result'][$tableName]['pageResult']['list_total'];
	$list_num		= $_REQUEST['result'][$tableName]['pageResult']['list_num'];
	if($_REQUEST['BOARD_INFO']['bi_attachedfile_use']):
		if(in_array("listImage", $_REQUEST['BOARD_INFO']['bi_attachedfile_key'])) { $listImg = 1; } /* 리스트 이미지 사용 할 때 */
	endif;
?>

<div id="talkList_Table">
		<? if($list_total <= 0) : ?>
		<? else: 
		   while($row = mysql_fetch_array($result)) : ?>
		<div class="talkList" id="talk_<?=$row['UB_NO']?>">
			<ul class="talkDate">
				<li class="photoImg"></li>
				<li class="title" id="talkUbTalk"><?=str_replace("\r\n","<br>",$row['UB_TALK'])?></li>
				<li class="writer" id="talkUbName"><?=$row['UB_NAME']?>**</li>
				<!-- li class="date">13.03.18</li -->
			</ul>
			<div class="btnWrap">
				<?if($row['UB_M_NO']): // 회원글 ?>
				<?if($_REQUEST['member_no'] == $row['UB_M_NO']):	// 글 작성자와 회원이 같은 경우. ?>
				<!-- a id="talkModify" class="btnTalkModify" href="javascript:goTalkModifyEvent('<?=$row['UB_NO']?>')">수정</a>
				<a id="talkDelete" class="btnTalkDel" href="javascript:goTalkDeleteEvent('<?=$row['UB_NO']?>')">삭제</a -->
				<?else: /// 글 작성자와 회원이 같은 경우.?>
				<!-- 수정 버튼 -->
				<!-- 삭제 버튼 -->
				<?endif;?>
				<?else: //비회원글 ?>
				<a id="talkModify" class="btnTalkModify" href="javascript:goPassFormForModify('<?=$row['UB_NO']?>')">수정</a>
				<a id="talkDelete" class="btnTalkDel" href="javascript:goPassFormForDelete('<?=$row['UB_NO']?>')">삭제</a>
				<?endif;?>
			</div>
			<div class="clear"></div>
		</div>
		<? endwhile; 
		   endif; ?>
	</div>

	<textarea id="insert_form" style="display:none;" alt="등록후폼">
	<div class="talkList" id="talk_">
		<ul class="talkDate">
			<li class="photoImg"></li>
			<li class="title" id="talkUbTalk"></li>
			<li class="writer" id="talkUbName"></li>
			<li class="date"></li>
		</ul>
		<div class="btnWrap">
			<a id="talkModify" href="javascript:goPassFormForModify('')"></a>
			<a id="talkDelete" href="javascript:goPassFormForDelete('')"></a>
		</div>
		<div class="clear"></div>
	</div>
	</textarea>

	<textarea id="password_form" style="display:none;" alt="비밀번호폼">
	<div class="talkList">
		<ul class="talkDate">
			<li class="password"><input type="text" name="ub_pass_check" id="ub_pass_check" style="width:100px"></li>
		</ul>
		<div class="btnWrap">
			<a id="passwordOk"></a>
			<a id="passwordCancel"></a>
		</div>
		<div class="clear"></div>
	</div>
	</textarea>


	<textarea id="modify_form" style="display:none" alt="수정폼">
	<div class="talkList">
		<ul class="talkDate">
			<li class="photoImg"></li>
			<li class="title" id="talkUbTalk"><textarea style="width:100%;height:100px" name="ub_talk_modify" id="ub_talk_modify">&lt;textarea></li>
			<li class="writer" id="talkUbName"></li>
			<li class="date"></li>
		</ul>
		<div class="btnWrap">
			<a id="talkModify"></a>
			<a id="talkModifyCancel"></a>
		</div>
		<div class="clear"></div>
	</div>
	</textarea>

	

