1	<table>
		<?if($_REQUEST['BOARD_INFO']['bi_category_use']=="Y"): // 카테고리 사용?>
		<tr>
			<th>카테고리</th>
			<td><? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/user/community/category/basic.1.0/index.code.php" ?></td>
		</tr>
		<?endif;?>
		<tr>
			<th>작성자</th>
			<td>
				<? if($_REQUEST['member_login']):	// 회원   ?>
				<input type="text" id="ub_name" name="ub_name" value="<?=$_REQUEST['member_name'];?>" alt="작성자" check="Y" maxlength="10"/>
				<? else:				// 비회원 ?>
				<input type="text" <?=$nBox?>  id="ub_name" name="ub_name"  alt="작성자" check="Y" maxlength="10"/>
				<? endif; ?>
			</td>
		</tr>
		<tr>
			<th>이메일</th>
			<td>
				<? if($_REQUEST['member_login']):	// 회원   ?>
				<input type="text" style="width:300px;"  id="ub_mail" name="ub_mail" value="<?=$_REQUEST['member_mail'];?>"  alt="이메일" check="Y" maxlength="30"/>
				<? else:				// 비회원 ?>
				<input type="text" <?=$nBox?>  style="width:300px;" id="ub_mail" name="ub_mail"  alt="이메일" check="Y" maxlength="30"/>
				<? endif; ?>
			</td>
		</tr>
		<?if($_REQUEST['BOARD_INFO']['bi_userfield_use'] == "Y"): // 추가 필드 사용 할 때?>
		<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/user/community/data/basic.1.0/userfield.write.skin.php" ?>
		<?endif;?>
		<?if(($_REQUEST['BOARD_INFO']['bi_datawrite_lock_use']=="C") || ($_REQUEST['BOARD_INFO']['bi_datawrite_notice_use']=="Y")):?>
		<!--tr>
			<th>옵션</th>
			<td>
				<?if($_REQUEST['BOARD_INFO']['bi_datawrite_lock_use']=="C"):?>
				<input type="checkbox" id="ub_func_lock"   name="ub_func_lock"   value="Y"/> 비밀글
				<?endif;?>
				<?if($_REQUEST['BOARD_INFO']['bi_datawrite_notice_use']=="Y"):?>
				<input type="checkbox" id="ub_func_notice" name="ub_func_notice" value="Y"/> 공지글
				<?endif;?>
			</td>
		</tr-->
		<?endif;?>
		<tr>
			<th>제목</th>
			<td>
				<input type="text" <?=$nBox?>  style="width:90%;" id="ub_title" name="ub_title" alt="제목" check="Y" maxlength="50"/>
				<?if($_REQUEST['BOARD_INFO']['bi_datawrite_lock_use']=="C"):?>
				<input type="checkbox" id="ub_func_lock"   name="ub_func_lock"   value="Y"/> 비밀글
				<?endif;?>
			</td>
		</tr>
		<!--평점-->
		<tr>
			<td colspan="2" class="alignCenter">
				<input type="radio" name="ub_p_grade" id="ub_p_grade" value="1"/> <img src="/himg/board/icon/icon_star_1.png"/>
				<input type="radio" name="ub_p_grade" id="ub_p_grade" value="2"/> <img src="/himg/board/icon/icon_star_2.png"/>
				<input type="radio" name="ub_p_grade" id="ub_p_grade" value="3" checked/> <img src="/himg/board/icon/icon_star_3.png"/>
				<input type="radio" name="ub_p_grade" id="ub_p_grade" value="4"/> <img src="/himg/board/icon/icon_star_4.png"/>
				<input type="radio" name="ub_p_grade" id="ub_p_grade" value="5"/> <img src="/himg/board/icon/icon_star_5.png"/>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<textarea style="width:100%;height:300px" id="ub_text" name="ub_text" title="<?=$_REQUEST['BOARD_INFO']['bi_datawrite_form']?>" alt="내용" check="Y"></textarea>
			</td>
		</tr>
		<?if($_REQUEST['BOARD_INFO']['bi_attachedfile_use']):?>
		<tr>
			<th>첨부파일</th>
			<td>
				<a class="btn_sml" href="javascript:goAttachedfileOpen();" id="menu_auth_w" style=""><strong>파일선택</strong></a>
				<div id="fileList">
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
		<?if($_REQUEST['member_login']):	// 회원   ?>
		<input type="hidden" name="ub_m_id" id="ub_m_id" value="<?=$_REQUEST['member_id']?>">
		<?else:				// 비회원 ?>
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
		<?endif; ?>
	</table>