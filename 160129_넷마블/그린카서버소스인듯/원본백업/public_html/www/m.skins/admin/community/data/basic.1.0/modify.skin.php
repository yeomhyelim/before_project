	<table>
		<?if($_REQUEST['BOARD_INFO']['bi_category_use']=="Y"): // 카테고리 사용?>
		<tr>
			<th>카테고리</th>
			<td><? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/category/include.1.0/combobox.write.inc.skin.php" ?></td>
		</tr>
		<?endif;?>
		<?if(($_REQUEST['BOARD_INFO']['bi_datawrite_lock_use']=="C") || ($_REQUEST['BOARD_INFO']['bi_datawrite_notice_use']=="Y") || ($_REQUEST['BOARD_INFO']['bi_datawrite_icon_use']=="Y")):?>
		<tr>
			<th>옵션</th>
			<td>
				<?if($_REQUEST['BOARD_INFO']['bi_datawrite_lock_use']=="C"):?>
				<input type="checkbox" id="ub_func_lock"   name="ub_func_lock" value="Y"<?if($dataSelectRow['UB_FUNC']['UB_FUNC_LOCK']=="Y"){ echo " checked";}?>/> 비밀글
				<?endif;?>
				<?if($_REQUEST['BOARD_INFO']['bi_datawrite_notice_use']=="Y"):?>
				<input type="checkbox" id="ub_func_notice" name="ub_func_notice" value="Y"<?if($dataSelectRow['UB_FUNC']['UB_FUNC_NOTICE']=="Y"){ echo " checked";}?>/> 공지글
				<?endif;?>
				<?if($_REQUEST['BOARD_INFO']['bi_datawrite_icon_use']=="Y"):?>
				<input type="checkbox" id="ub_func_icon" name="ub_func_icon" value="Y"<?if($dataSelectRow['UB_FUNC']['UB_FUNC_ICON']=="Y"){ echo " checked";}?>/> 아이콘
				<?endif;?>
				<?if($_REQUEST['BOARD_INFO']['bi_widget_icon_use']=="Y"):?>
				<input type="checkbox" id="ub_func_icon_widget" name="ub_func_icon_widget" value="Y"<?if($dataSelectRow['UB_FUNC']['UB_FUNC_ICON_WIDGET']=="Y"){ echo " checked";}?>/> 위젯글
				<?endif;?>
			</td>
		</tr>
		<?endif;?>
		<tr>
			<th>작성일</th>
			<td>
				<?=date("Y-m-d H:i:d", strtotime($dataSelectRow['UB_REG_DT']))?>
			</td>
		</tr>
		<tr>
			<th>작성자</th>
			<td>
				<input type="text" <?=$nBox?>  style="width:200px;" id="ub_name" name="ub_name" alt="작성자" check="Y" value="<?=$dataSelectRow['UB_NAME']?>" maxlength="10"/>
			</td>
		</tr>
		<tr>
			<th>이메일</th>
			<td>
				<input type="text" <?=$nBox?>  style="width:200px;" id="ub_mail" name="ub_mail" value="<?=$dataSelectRow['UB_MAIL']?>" maxlength="30"/>
			</td>
		</tr>
		<?if($_REQUEST['BOARD_INFO']['bi_userfield_use'] == "Y"): // 추가 필드 사용 할 때?>
		<? include "userfield.modify.skin.php" ?>
		<?endif;?>
		<tr>
			<th>링크</th>
			<td>
				<input type="text" <?=$nBox?>  style="width:99%;" id="ub_url" name="ub_url" value="<?=$dataSelectRow['UB_URL']?>" />
			</td>
		</tr>
		<tr>
			<th>제목</th>
			<td>
				<input type="text" <?=$nBox?>  style="width:99%;" id="ub_title" name="ub_title" value="<?=$dataSelectRow['UB_TITLE']?>" alt="제목" check="Y"/>
			</td>
		</tr>
		<!--평점-->
		<?if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][4]!="N"):?>
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
			<th>내용</th>
			<td>
				<textarea style="width:100%;height:300px" id="ub_text" name="ub_text" title="<?=$_REQUEST['BOARD_INFO']['bi_datawrite_form']?>" alt="내용" check="Y"><?=$dataSelectRow['UB_TEXT']?></textarea>
			</td>
		</tr>
		<tr>
			<th>아이피</th>
			<td>
				<?=$dataSelectRow['UB_IP']?>
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

