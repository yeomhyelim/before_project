<?
	## 설정
	$dataSelectRow					= $_REQUEST['result']['DataMgr'];
	$attachedfileViewListResult		= $_REQUEST['result']['AttachedfileMgr'];
	## 목록 설명
	## 커뮤니티 리스트 목록 설정(번호=0,작성자=1,등록일=2,조회수=3,점수=4)
	## 로그인 회원이 관리자인 경우 textarea(내용)가 에디터박스 편집창으로 변경
	$strDataWriteForm = $dataSelectRow['UB_FUNC']['bi_datawrite_form'];
	if($_REQUEST['member_group'] == "001") { $strDataWriteForm = "higheditor_full"; }
?>
	<table>
		<tr>
			<th>기간</th>
			<td>
				<input type="text" name="ub_event_s_dt" id="ub_event_s_dt" style="width:100px;" value="<?=SUBSTR($dataSelectRow['UB_EVENT_S_DT'],0,10)?>"> 부터
				<input type="text" name="ub_event_e_dt" id="ub_event_e_dt" style="width:100px;" value="<?=SUBSTR($dataSelectRow['UB_EVENT_E_DT'],0,10)?>"> 까지
			</td>
		</tr>
		<tr>
			<th>작성자</th>
			<td>
				<input type="text" <?=$nBox?>  style="width:10%;" id="ub_name" name="ub_name" alt="작성자" check="Y" value="<?=$S_SITE_ENG_NM?>" value="<?=$dataSelectRow['UB_NAME']?>" maxlength="10"/>
			</td>
		</tr>
		<tr>
			<th>제목</th>
			<td>
				<input type="text" <?=$nBox?>  style="width:100%;" id="ub_title" name="ub_title" alt="제목" check="Y" maxlength="50" value="<?=$dataSelectRow['UB_TITLE']?>"/>
				<input type="checkbox" name="ub_func_webUse" value="Y"<?if($dataSelectRow['UB_FUNC']['UB_FUNC_WEBUSE']=="Y"){ echo " checked";}?>> 웹 페이지
				<input type="checkbox" name="ub_func_mobileUse" value="Y"<?if($dataSelectRow['UB_FUNC']['UB_FUNC_MOBILEUSE']=="Y"){ echo " checked";}?>> 모바일 페이지
			</td>
		</tr>
		<tr>
			<th>간략설명</th>
			<td>
				<textarea style="width:100%;height:50px" id="ub_explain" name="ub_explain" ><?=$dataSelectRow['UB_EXPLAIN']?></textarea>
			</td>
		</tr>
		<tr>
			<th>내용(웹)</th>
			<td>
				<textarea style="width:100%;height:300px" id="ub_text" name="ub_text" title="<?=$_REQUEST['BOARD_INFO']['bi_datawrite_form']?>" alt="내용"><?=$dataSelectRow['UB_TEXT']?></textarea>
			</td>
		</tr>
		<tr>
			<th>내용(모바일)</th>
			<td>
				<textarea style="width:100%;height:300px" id="ub_text_mobile" name="ub_text_mobile" title="<?=$_REQUEST['BOARD_INFO']['bi_datawrite_form']?>" alt="내용"><?=$dataSelectRow['UB_TEXT_MOBILE']?></textarea>
			</td>
		</tr>
		<?if($_REQUEST['BOARD_INFO']['bi_attachedfile_use']):?>
		<tr>
			<th>첨부파일</th>
			<td>
				<a class="btn_sml" href="javascript:goAttachedfileOpen();" id="menu_auth_w" style=""><strong>파일선택</strong></a>
				<div id="fileList">
				<? while($row = mysql_fetch_array($attachedfileViewListResult)) : ?>
				<li id="fl_file_<?=$row['FL_NO']?>" style="float:left;display: inline-block;">
					<img src="<?=$row['FL_DIR'].$row['FL_NAME']?>" style="width:50px;height:50px" />
					<input type="hidden" name="fl_no[]" id="fl_no" value="<?=$row['FL_NO']?>"/>
					<a href="javascript:goAttachedfileDelete('<?=$row['FL_NO']?>')">[X]</a>
				</li>
				<? endwhile; ?>
				</div>
				<textarea id="fileList_form" style="display:none" alt="파일폼">
					<li id="" style="float:left;display: inline-block;">
						<img src="" style="width:50px;height:50px;"/>
						<input type="hidden" name="fl_temp_file[]" id="fl_temp_file" value=""/>
						<input type="hidden" name="fl_temp_key[]"  id="fl_temp_key"  value=""/>
						<a href="">[X]</a>
					</li>
				</textarea>
			</td>
		</tr>
		<?endif;?>
	</table>