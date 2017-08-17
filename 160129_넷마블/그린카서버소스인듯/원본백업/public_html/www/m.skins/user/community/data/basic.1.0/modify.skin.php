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
			<th><?=$LNG_TRANS_CHAR["CW00053"] //작성자?></th>
			<td>
				<?if($dataSelectRow['UB_M_ID']):	// 회원이 작성한 글			?>
				<?//=$dataSelectRow['UB_NAME']?>
				<input type="text" <?=$nBox?>  style="width:300px;" id="ub_name" name="ub_name" value="<?=$dataSelectRow['UB_NAME']?>" alt="작성자" check="Y" maxlength="10"/>
				<?else:								// 비회원이 작성한 글		?>
				<input type="text" <?=$nBox?>  style="width:300px;" id="ub_name" name="ub_name" value="<?=$dataSelectRow['UB_NAME']?>" alt="작성자" check="Y" maxlength="10"/>
				<?endif;?>
			</td>
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["MW00010"] //이메일?></th>
			<td>
				<? if($_REQUEST['member_login']):	// 회원   ?>
				<input type="text" <?=$nBox?>  style="width:300px;" id="ub_mail" name="ub_mail" value="<?=$dataSelectRow['UB_MAIL']?>" alt="이메일" check="Y" maxlength="30"/>
				<? else:							// 비회원 ?>
				<input type="text" <?=$nBox?>  style="width:300px;" id="ub_mail" name="ub_mail" value="<?=$dataSelectRow['UB_MAIL']?>" alt="이메일" check="Y" maxlength="30"/>
				<? endif; ?>
			</td>
		</tr>
		<?if($_REQUEST['BOARD_INFO']['bi_userfield_use'] == "Y"): // 추가 필드 사용 할 때?>
		<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/user/community/data/basic.1.0/userfield.modify.skin.php" ?>
		<?endif;?>
		<?if(($_REQUEST['BOARD_INFO']['bi_datawrite_lock_use']=="C") || ($_REQUEST['BOARD_INFO']['bi_datawrite_notice_use']=="Y")):?>
		<!--tr>
			<th>옵션</th>
			<td>
				<?if($_REQUEST['BOARD_INFO']['bi_datawrite_notice_use']=="Y"):?>
				<input type="checkbox" id="ub_func_notice" name="ub_func_notice" value="Y"<?if($dataSelectRow['UB_FUNC_NOTICE']=="Y"){echo " checked";}?>/> 공지글
				<?endif;?>
				<?if($_REQUEST['BOARD_INFO']['bi_datawrite_lock_use']=="C"):?>
				<input type="checkbox" id="ub_func_lock"   name="ub_func_lock"   value="Y"<?if($dataSelectRow['UB_FUNC_LOCK']=="Y"){echo " checked";}?>/> 비밀글
				<?endif;?>
			</td>
		</tr-->
		<?endif;?>
		<tr>
			<th><?=$LNG_TRANS_CHAR["CW00062"] //제목?></th>
			<td>
				<input type="text" <?=$nBox?> id="ub_title" name="ub_title" value="<?=stripslashes($dataSelectRow['UB_TITLE'])?>" alt="제목" check="Y" maxlength="50" style="width:98%;"/>
				<?if($_REQUEST['BOARD_INFO']['bi_datawrite_notice_use']=="Y" && $_REQUEST['member_group']=="001"):?>
				<span class="boardTxtInfo">
				<input type="checkbox" id="ub_func_notice" name="ub_func_notice" value="Y"<?if($dataSelectRow['UB_FUNC']['UB_FUNC_NOTICE']=="Y"){echo " checked";}?>/> 공지글
				</span>
				<?endif;?>
				<?if($_REQUEST['BOARD_INFO']['bi_widget_icon_use']=="Y"):?>
					<span class="boardTxtInfo">
						<input type="checkbox" id="ub_func_icon_widget" name="ub_func_icon_widget" value="Y"<?if($dataSelectRow['UB_FUNC']['UB_FUNC_ICON_WIDGET']=="Y"){echo " checked";}?>/> 위젯글
					</span>
				<?endif;?>
				<?if($_REQUEST['BOARD_INFO']['bi_datawrite_lock_use']=="C"):?>
				<span class="boardTxtInfo">
				<input type="checkbox" id="ub_func_lock"   name="ub_func_lock"   value="Y"<?if($dataSelectRow['UB_FUNC']['UB_FUNC_LOCK']=="Y"){echo " checked";}?>/> 비밀글
				(체크후 작성시 운영자와 등록자만 조회 가능합니다.)
				</span>
				<?endif;?>
			</td>
		</tr>
		<!--평점-->
		<?if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][4]=="Y"):?>
		<tr>
			<td colspan="2" class="alignCenter">
				<input type="radio" name="ub_p_grade" id="ub_p_grade" value="1"<?if($dataSelectRow['UB_P_GRADE'] == 1){ echo " checked";}?>/> <img src="/himg/board/icon/icon_star_1.png"/>
				<input type="radio" name="ub_p_grade" id="ub_p_grade" value="2"<?if($dataSelectRow['UB_P_GRADE'] == 2){ echo " checked";}?>/> <img src="/himg/board/icon/icon_star_2.png"/>
				<input type="radio" name="ub_p_grade" id="ub_p_grade" value="3"<?if($dataSelectRow['UB_P_GRADE'] == 3){ echo " checked";}?>/> <img src="/himg/board/icon/icon_star_3.png"/>
				<input type="radio" name="ub_p_grade" id="ub_p_grade" value="4"<?if($dataSelectRow['UB_P_GRADE'] == 4){ echo " checked";}?>/> <img src="/himg/board/icon/icon_star_4.png"/>
				<input type="radio" name="ub_p_grade" id="ub_p_grade" value="5"<?if($dataSelectRow['UB_P_GRADE'] == 5){ echo " checked";}?>/> <img src="/himg/board/icon/icon_star_5.png"/>
			</td>
		</tr>
		<?endif;?>
		<tr>
			<th><?=$LNG_TRANS_CHAR["CW00063"] //내용?></th>
			<td>
				<textarea style="width:100%;height:300px" id="ub_text" name="ub_text" title="<?=$strDataWriteForm?>" alt="내용" check="Y"><?=stripslashes($dataSelectRow['UB_TEXT'])?></textarea>
			</td>
		</tr>
		<?if($_REQUEST['BOARD_INFO']['bi_attachedfile_use']):?>
		<tr>
			<th><?=$LNG_TRANS_CHAR["CW00058"] //첨부파일?></th>
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
			<th><?=$LNG_TRANS_CHAR["MW00002"] //비밀번호?></th>
			<td>
				<input type="password" <?=$nBox?>  style="width:200px;" id="ub_pass" name="ub_pass" alt="<?=$LNG_TRANS_CHAR["MW00002"] //비밀번호?>" check="Y"/>
			</td>
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["MW00003"] //비밀번호?></th>
			<td>
				<input type="password" <?=$nBox?>  style="width:200px;" id="ub_pass1" name="ub_pass1" alt="<?=$LNG_TRANS_CHAR["MW00003"] //비밀번호?>" check="Y"/>
			</td>
		</tr>
		<? endif; ?>
	</table>

