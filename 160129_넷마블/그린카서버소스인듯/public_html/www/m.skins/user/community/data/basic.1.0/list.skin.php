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
	<table>
		<? if($list_total <= 0) : ?>
		<tr>
			<td colspan="7" class="noListWrap"><?=$LNG_TRANS_CHAR["CS00001"] //등록된 내용이 없습니다.?></td>
		</tr>
		<? else: 
		   while($row = mysql_fetch_array($result)) :
			   $aryFunc			= $dataView->getUB_FUNC_DECODER($row);
			   $lock			= $dataView->getLockAuthCheck($row);
			   $intHidden		= $_REQUEST['BOARD_INFO']['bi_datalist_writer_hidden'];
			   if($intHidden && ($_REQUEST['member_group'] != "001")):
				   $row['UB_NAME']	= mb_substr($row['UB_NAME'], 0, $intHidden, "UTF-8");
				   for($i=0;$i<3;$i++) { $row['UB_NAME'] .= "*"; }
				   $row['UB_M_ID']	= mb_substr($row['UB_M_ID'], 0, $intHidden, "UTF-8");
				   for($i=0;$i<3;$i++) { $row['UB_M_ID'] .= "*"; }
			   endif;
			   /*답변 관련*/
//			   if($_REQUEST['buttonLock']['dataAnswer']):
				   $step = "";
				   if($row['UB_ANS_STEP']):
					   $step = explode(",", $row['UB_ANS_STEP']);
					   $step = sizeof($step);
					   $step = str_pad("", $step, " ", STR_PAD_LEFT);	
					   $step = str_replace(" ", "&nbsp;", $step);
				   endif;
//				endif;
			   /*답변 관련*/
			   /* 링크 권한 설정*/
			   $linkMode = "1";
			   if($_REQUEST['BOARD_INFO']['bi_dataview_use'] == "A"):			// 모든회원/비회원=A
					if($aryFunc['UB_FUNC_LOCK'] == "Y"): // 비밀글 인경우
						if($lock['member'] == "1" && $lock['check'] == "1")			{ $linkMode = "1"; }
						else if($lock['member'] == "1" && $lock['check'] == "0")	{ $linkMode = "2"; }
						else														{ $linkMode = "0"; }; 
						## 관리자회원은 페이지 이동
						if($_REQUEST['member_group'] == "001")						{ $linkMode = "1"; }
					endif;
			   elseif($_REQUEST['BOARD_INFO']['bi_dataview_use'] == "M"):		// 회원전용=M
					## 회원 전용 페이지에서 로그인을 하지 않은 회원은 로그인 페이지로 이동
					if(!$_REQUEST['member_login']) { $linkMode = "2"; }
					else {
						## 비밀글이라면 메시지 출력
						if($aryFunc['UB_FUNC_LOCK'] == "Y") { $linkMode = "3"; }
						## 나의 글이라면 페이지 이동
						if($lock['check'] == 1) { $linkMode = "1"; }
						## 관리자회원은 페이지 이동
						if($_REQUEST['member_group'] == "001") { $linkMode = "1"; }
					}
			   endif;
			   /* 링크 권한 설정*/

		?>
		<tr>
			<td class="boardList">
			
					<?if($listImg):?>
						<img src="<?=$row['FL_DIR'].$row['FL_NAME']?>" alt="list image" class="imgBoardList">
					<?endif;?>

					<span class="numDiv"><?//=$list_num--?></span>
					<?if($step): // 답변깊이?><?=$step?><span class="replyIcon"> -▶RE:<span><?endif;?>
					<?if($aryFunc['UB_FUNC_NOTICE']=="Y"): // 공지글?><span class="noticeIcon">공지사항</span><?endif;?>
					<?if($linkMode==0):?>
						<span class="icon_notice">Lock</span>
						<a onClick="goDataViewPassMoveEvent('<?=$row['UB_NO']?>')" class="listTitle"><?=strHanCutUtf2($row['UB_TITLE'],$_REQUEST['BOARD_INFO']['bi_datalist_title_len'],'N')?></a>
					<?elseif($linkMode==1):?>
						<a href="javascript:goDataViewMoveEvent('<?=$row['UB_NO']?>')" class="listTitle"><?=strHanCutUtf2($row['UB_TITLE'],$_REQUEST['BOARD_INFO']['bi_datalist_title_len'],'N')?></a>
					<?elseif($linkMode==2):?>
						<span class="icon_notice">Lock</span>
						<a onClick="goLoginPageMoveEvent('<?=$S_MAIN_LAYERPOP_LOGIN_USE?>')" class="listTitle"><?=strHanCutUtf2($row['UB_TITLE'],$_REQUEST['BOARD_INFO']['bi_datalist_title_len'],'N')?></a>
					<?elseif($linkMode==3):?>
						<span class="icon_notice">Lock</span> 
						<a onClick="goSecretTextMoveEvent()" class="listTitle"><?=strHanCutUtf2($row['UB_TITLE'],$_REQUEST['BOARD_INFO']['bi_datalist_title_len'],'N')?></a>
					<?endif;?>

				<div class="writeInfo">
					<div class="left">
						<?if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][1]!="N"):?>
							<?if($_REQUEST['BOARD_INFO']['bi_datalist_writer_show'][0]=="Y"):?>
								<?=$row['UB_NAME'] //성명?>
							<?endif;?>
							<?if($_REQUEST['BOARD_INFO']['bi_datalist_writer_show'][1]=="Y"):?>
								<?=$row['UB_M_ID'] //아이디?>
							<?endif;?>
								<?=date("Y-m-d", strtotime($row['UB_REG_DT'])) //작성일?>
						<?endif;?>
					</div>
					<?if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][3]!="N"):?>
						<span class="readCnt"><?//=NUMBER_FORMAT($row['UB_READ']) //조회수?></span>
					<?endif;?>
					<div class="clr"></div>
				</div>
				
				<div class="clear"></div>
			</td>
			
			<?if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][4]=="Y"):?>
				<td><?=$row['UB_P_GRADE'] //평점?></td>
			<?endif;?>
			
			
		</tr>
		<? endwhile; 
		   endif; ?>
	</table>

	<textarea id="passwordForm" alt="비밀번호 입력폼" style="display:none;">
		<div id="passwordForm" alt="비밀번호 입력폼" style="position:absolute;left:0px;top:0px;">
			<ul>
				<li class="title">비밀번호를 입력해 주세요.</li>
				<li><input type="password" name="pass_ub_pass" id="pass_ub_pass" alt="비밀번호" check="password"/>
					<a href="javascript:goDataViewPassActEvent();" id="menu_auth_w" class="btnLayerOk"><span>확인</span></a>
					<a href="javascript:goDataViewPassCancelMoveEvent();" id="menu_auth_w" class="btnLayerClose"><span>취소</span></a></li>
			</ul>
			<input type="hidden" name="pass_ub_no" id="pass_ub_no">
		</div>
	</textarea>

	<textarea id="secretTextForm" alt="본인의 글만 조회 가능합니다." style="display:none">
		<div id="secretTextForm" alt="본인의 글만 조회 가능합니다." style="position:absolute;left:0px;top:0px;">
			<ul>
				<li>
					본인의 글만 조회 가능합니다.
					<a href="javascript:goSecretTextCancelMoveEvent();" id="menu_auth_w" class="btnLayerClose"><span>확인</span></a>
				</li>
			</ul>
		</div>
	</textarea>
