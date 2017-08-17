	<table>
		<?if(($_REQUEST['BOARD_INFO']['bi_datawrite_lock_use']=="C") || ($_REQUEST['BOARD_INFO']['bi_datawrite_notice_use']=="Y") || ($_REQUEST['BOARD_INFO']['bi_datawrite_icon_use']=="Y")):?>
		<tr>
			<th>옵션</th>
			<td>
				<?if($_REQUEST['BOARD_INFO']['bi_datawrite_lock_use']=="C"):?>
				<input type="checkbox" id="ub_func_lock"   name="ub_func_lock"   value="Y"/> 비밀글
				<?endif;?>
				<?if($_REQUEST['BOARD_INFO']['bi_datawrite_notice_use']=="Y"):?>
				<input type="checkbox" id="ub_func_notice" name="ub_func_notice" value="Y"/> 공지글
				<?endif;?>
				<?if($_REQUEST['BOARD_INFO']['bi_datawrite_icon_use']=="Y"):?>
				<input type="checkbox" id="ub_func_icon" name="ub_func_icon" value="Y"/> 아이콘
				<?endif;?>
			</td>
		</tr>
		<?endif;?>
		<tr>
			<th>작성자</th>
			<td>
				<input type="text" <?=$nBox?>  style="width:10%;" id="ub_name" name="ub_name" alt="작성자" check="Y" value="<?=$S_SITE_ENG_NM?>" maxlength="10"/>
			</td>
		</tr>
		<tr>
			<th>이메일</th>
			<td>
				<input type="text" <?=$nBox?>  style="width:200px;" id="ub_mail" name="ub_mail" value="<?=$dataSelectRow['UB_MAIL']?>" maxlength="30"/>
			</td>
		</tr>
		<tr>
			<th>내용</th>
			<td>
				<textarea style="width:100%;height:300px" id="ub_talk" name="ub_talk" title="<?=$_REQUEST['BOARD_INFO']['bi_datawrite_form']?>" alt="내용" check="Y"></textarea>
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
	</table>