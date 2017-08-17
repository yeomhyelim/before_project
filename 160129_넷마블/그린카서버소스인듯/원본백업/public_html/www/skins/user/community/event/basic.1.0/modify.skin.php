	<table>
		<tr>
			<th>작성자</th>
			<td>
				<?if($dataSelectRow['UB_M_ID']):	// 회원이 작성한 글			?>
				<?=$dataSelectRow['UB_NAME']?>
				<input type="text" id="ub_name" name="ub_name" value="<?=$_REQUEST['member_name'];?>" alt="작성자" check="Y" maxlength="10"/>
				<?else:								// 비회원이 작성한 글		?>
				<input type="text" <?=$nBox?>  style="width:300px;" id="ub_name" name="ub_name" value="<?=$dataSelectRow['UB_NAME']?>" alt="작성자" check="Y" maxlength="10"/>
				<?endif;?>
			</td>
		</tr>
		<tr>
			<th>이메일</th>
			<td>
				<? if($auth['LOGIN']):	// 회원   ?>
				<input type="text" style="width:300px;" id="ub_mail" name="ub_mail" value="<?=$_REQUEST['member_mail'];?>"  alt="이메일" check="Y" maxlength="30"/>
				<? else:				// 비회원 ?>
				<input type="text" <?=$nBox?>  style="width:300px;" id="ub_mail" name="ub_mail" value="<?=$dataSelectRow['UB_MAIL']?>" alt="이메일" check="Y" maxlength="30"/>
				<? endif; ?>
			</td>
		</tr>
		<tr>
			<th>기간</th>
			<td>
				<input type="text" name="ub_event_s_dt" id="ub_event_s_dt" style="width:100px;" value="<?=date("Y-m-d", strtotime($dataSelectRow['UB_EVENT_S_DT']));?>" maxlength="10"> 부터
				<input type="text" name="ub_event_e_dt" id="ub_event_e_dt" style="width:100px;" value="<?=date("Y-m-d", strtotime($dataSelectRow['UB_EVENT_E_DT']));?>" maxlength="10"> 까지
			</td>
		</tr>
		<?if(($_REQUEST['BOARD_INFO']['bi_datawrite_lock_use']=="C") || ($_REQUEST['BOARD_INFO']['bi_datawrite_notice_use']=="Y")):?>
		<tr>
			<th>옵션</th>
			<td>
				<?if($_REQUEST['BOARD_INFO']['bi_datawrite_notice_use']=="Y"):?>
				<input type="checkbox" id="ub_func_notice" name="ub_func_notice" value="Y"<?if($dataSelectRow['UB_FUNC_NOTICE']=="Y"){echo " checked";}?>/> 공지글
				<?endif;?>
				<?if($_REQUEST['BOARD_INFO']['bi_datawrite_lock_use']=="C"):?>
				<input type="checkbox" id="ub_func_lock"   name="ub_func_lock"   value="Y"<?if($dataSelectRow['UB_FUNC_LOCK']=="Y"){echo " checked";}?>/> 비밀글
				<?endif;?>
			</td>
		</tr>
		<?endif;?>
		<tr>
			<th>제목</th>
			<td>
				<input type="text" <?=$nBox?>  style="width:100%;" id="ub_title" name="ub_title" value="<?=stripslashes($dataSelectRow['UB_TITLE'])?>" alt="제목" check="Y" maxlength="50"/>
			</td>
		</tr>
		<tr>
			<th>간략설명</th>
			<td>
				<textarea style="width:100%;height:50px" id="ub_explain" name="ub_explain"><?=stripslashes($dataSelectRow['UB_EXPLAIN'])?></textarea>
			</td>
		</tr>
		<tr>
			<th>내용</th>
			<td>
				<textarea style="width:100%;height:300px" id="ub_text" name="ub_text" title="<?=$_REQUEST['BOARD_INFO']['bi_datawrite_form']?>" alt="내용" check="Y"><?=stripslashes($dataSelectRow['UB_TEXT'])?></textarea>
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
		<? if($_REQUEST['member_login']):	// 회원   ?>
		<input type="hidden" name="ub_m_id" id="ub_m_id" value="<?=$auth['M_ID']?>">
		<? else:				// 비회원 ?>
		<tr>
			<th>비밀번호</th>
			<td>
				<input type="text" <?=$nBox?>  style="width:200px;" id="ub_pass" name="ub_pass"/>
			</td>
		</tr>
		<tr>
			<th>비밀번호(확인)</th>
			<td>
				<input type="text" <?=$nBox?>  style="width:200px;" id="ub_pass1" name="ub_pass1"/>
			</td>
		</tr>
		<? endif; ?>
	</table>

