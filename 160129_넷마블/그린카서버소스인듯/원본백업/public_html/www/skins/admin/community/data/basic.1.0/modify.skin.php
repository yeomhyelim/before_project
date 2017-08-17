<?
	## 설정
	$dataSelectRow					= $_REQUEST['result']['DataMgr'];
	$attachedfileViewListResult		= $_REQUEST['result']['AttachedfileMgr'];
	$isNoticeOption					= true;

	## 기본 설정
	$strUB_LNG = $dataSelectRow['UB_LNG'];
	$no = $dataSelectRow['UB_NO'];
	$aryUseLng = explode("/", $S_USE_LNG);
	$intUseLng = sizeof($aryUseLng);

	## 목록 설명
	## 커뮤니티 리스트 목록 설정(번호=0,작성자=1,등록일=2,조회수=3,점수=4)
	## 로그인 회원이 관리자인 경우 textarea(내용)가 에디터박스 편집창으로 변경
	$strDataWriteForm = $dataSelectRow['UB_FUNC']['bi_datawrite_form'];
	if($_REQUEST['member_group'] == "001") { $strDataWriteForm = "higheditor_full"; }

	## USER_REPORT는 아이디 필드를 숨김 처리 한다.
	$isIDUse		= false;
	if($_REQUEST['b_code'] != "USER_REPORT"):
		$isIDUse		= true;
	endif;

	## 입점사 로그인일때 설정
	## 2014.04.28 kim hee sung 입점사업체문의사항(S_REQ) 게시판은 등록수정삭제 기능이 되도록 변경함
	if($_REQUEST['member_type'] == "S" && $_REQUEST['b_code'] == "S_REQ"):
		$isNoticeOption = false;
	endif;

	## 관리자는 무조건 에디터 박스 사용
//	$strDataWriteForm = $_REQUEST['BOARD_INFO']['bi_datawrite_form'];
	$strDataWriteForm = "higheditor_full";

?>
	No.<?=$no?>
	<table>
		<tr>
			<th>언어</th>
			<td><select name="ub_lng">
					<option>언어선택</option>
					<?php foreach($aryUseLng as $lng):
							
							## 기본 설정
							$strLngName = $S_ARY_COUNTRY[$lng];
					?>
					<option value="<?php echo $lng;?>"<?php if($strUB_LNG==$lng){echo " selected";}?>><?php echo $strLngName;?></option>
					<?php endforeach;?>
				</select>					
			</td>
		</tr>
		<?if(in_array($_REQUEST['BOARD_INFO']['bi_category_use'], array("Y","A"))): // 카테고리 사용?>
		<tr>
			<th>카테고리</th>
			<td><? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/category/include.1.0/combobox.write.inc.skin.php" ?></td>
		</tr>
		<?endif;?>
		<?if(($_REQUEST['BOARD_INFO']['bi_datawrite_lock_use']=="C") || ($_REQUEST['BOARD_INFO']['bi_datawrite_notice_use']=="Y") || ($_REQUEST['BOARD_INFO']['bi_datawrite_icon_use']=="Y")):?>
		<?php if($isNoticeOption):?>
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
		<?php endif;?>
		<?endif;?>
		<tr>
			<th>작성일</th>
			<td>
				<input type="text" <?=$nBox?> style="width:200px" id="ub_reg_dt" name="ub_reg_dt" alt="작성일자" check="Y" maxlength="19" value="<?=date("Y-m-d H:i:d", strtotime($dataSelectRow['UB_REG_DT']))?>"/>
				(예제)<?=date("Y-m-d H:i:d")?>
			</td>
		</tr>
		<?if($isIDUse):?>
		<tr>
			<th>아이디</th>
			<td>
				<input type="text" <?=$nBox?>  style="width:200px;" id="ub_name" name="ub_m_id" alt="아이디" check="Y" value="<?=$dataSelectRow['UB_M_ID']?>" maxlength="10"/>
			</td>
		</tr>
		<?endif;?>
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
		<? include "userfield.modify.skin.php" ?>
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
			<th></th>
			<td>
				<a data-mouseEnter-show2="modifyEditWeb" class="open">웹편집</a>
				<a data-mouseEnter-show2="modifyEditMobile">모바일편집</a>
			</td>
		</tr>
		<tr id="modifyEditWeb" group="modifyEdit">
			<th>내용</th>
			<td>
				<textarea style="width:100%;height:300px" id="ub_text" name="ub_text" title="<?php echo $strDataWriteForm;?>" alt="내용" check="Y"><?=$dataSelectRow['UB_TEXT']?></textarea>
			</td>
		</tr>
		<tr id="modifyEditMobile" group="modifyEdit" style="display:none">
			<th>내용(모바일)</th>
			<td>
				<textarea style="width:100%;height:300px" id="ub_text_mobile" name="ub_text_mobile" title="<?php echo $strDataWriteForm;?>" alt="내용" check=""><?=$dataSelectRow['UB_TEXT_MOBILE']?></textarea>
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
					<?if($row['FL_KEY']=="file"):?>
					<span><?=$row['FL_NAME']?></span>
					<?else:?>
					<img src="<?=$row['FL_DIR'].$row['FL_NAME']?>" style="width:50px;height:50px" />
					<?endif;?>
					<input type="hidden" name="fl_no[]" id="fl_no" value="<?=$row['FL_NO']?>"/>
					<a href="javascript:goAttachedfileDelete('<?=$row['FL_NO']?>')">[X]</a>
				</li>
				<? endwhile; ?>
				</div>
				<textarea id="fileList_form" style="display:none" alt="파일폼">
					<li id="" style="float:left;display: inline-block;">
						<img src="" style="width:50px;height:50px;"/>
						<span></span>
						<input type="hidden" name="fl_temp_file[]" id="fl_temp_file" value=""/>
						<input type="hidden" name="fl_temp_key[]"  id="fl_temp_key"  value=""/>
						<a href="">[X]</a>
					</li>
				</textarea>
			</td>
		</tr>
		<?endif;?>
	</table>

