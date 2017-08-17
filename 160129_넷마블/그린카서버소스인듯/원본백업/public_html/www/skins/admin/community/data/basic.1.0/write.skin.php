<?
	## 설정
	// 2013.06.18 kim hee sung 입점몰 추가로 인한 작성자명 변경.
//	$ub_name		= $S_SITE_ENG_NM;
	$ub_name		= $_REQUEST['member_name'];
	$isNoticeOption = true;

	## 기본 설정
	$aryUseLng = explode("/", $S_USE_LNG);
	$intUseLng = sizeof($aryUseLng);

	## 입점사 로그인일때 설정
	## 2014.04.28 kim hee sung 입점사업체문의사항(S_REQ) 게시판은 등록수정삭제 기능이 되도록 변경함
	if($_REQUEST['member_type'] == "S" && $_REQUEST['b_code'] == "S_REQ"):
		$isNoticeOption = false;
	endif;

	## 관리자는 무조건 에디터 박스 사용
//	$strDataWriteForm = $_REQUEST['BOARD_INFO']['bi_datawrite_form'];
	$strDataWriteForm = "higheditor_full";
?>
	<table>
		<tr>
			<th>언어</th>
			<td><select name="ub_lng">
					<option>언어선택</option>
					<?php foreach($aryUseLng as $lng):
							
							## 기본 설정
							$strLngName = $S_ARY_COUNTRY[$lng];
					?>
					<option value="<?php echo $lng;?>"><?php echo $strLngName;?></option>
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
		<tr>
			<th>작성자</th>
			<td>
				<input type="text" <?=$nBox?>  style="width:10%;" id="ub_name" name="ub_name" alt="작성자" check="write" value="<?=$ub_name?>" maxlength="10" readOnly/>
			</td>
		</tr>
		<tr>
			<th>제목</th>
			<td>
				<input type="text" <?=$nBox?>  style="width:99%;" id="ub_title" name="ub_title" alt="제목" check="write" maxlength="100"/>
			</td>
		</tr>
		<?if(($_REQUEST['BOARD_INFO']['bi_datawrite_lock_use']=="C") || ($_REQUEST['BOARD_INFO']['bi_datawrite_notice_use']=="Y") || ($_REQUEST['BOARD_INFO']['bi_datawrite_icon_use']=="Y")):?>
		<?php if($isNoticeOption):?>
		<tr>
			<th>옵션</th>
			<td>
				<?if($_REQUEST['BOARD_INFO']['bi_datawrite_lock_use']=="C"):?>
				<input type="checkbox" id="ub_func_lock"   name="ub_func_lock" value="Y"<?if($dataSelectRow['UB_FUNC']['UB_FUNC_LOCK']=="Y"){ echo " checked"; }?>/> 비밀글
				<?endif;?>
				<?if($_REQUEST['BOARD_INFO']['bi_datawrite_notice_use']=="Y"):?>
				<input type="checkbox" id="ub_func_notice" name="ub_func_notice" value="Y"/> 공지글
				<?endif;?>
				<?if($_REQUEST['BOARD_INFO']['bi_datawrite_icon_use']=="Y"):?>
				<input type="checkbox" id="ub_func_icon" name="ub_func_icon" value="Y"/> 아이콘
				<?endif;?>
				<?if($_REQUEST['BOARD_INFO']['bi_widget_icon_use']=="Y"):?>
				<input type="checkbox" id="ub_func_icon_widget" name="ub_func_icon_widget" value="Y"/> 위젯글
				<?endif;?>
			</td>
		</tr>
		<?php endif;?>
		<?endif;?>
		<? include "userfield.write.skin.php" ?>
		<tr>
			<th>링크</th>
			<td>
				<input type="text" <?=$nBox?>  style="width:99%;" id="ub_url" name="ub_url" value="http://" maxlength="100"/>
			</td>
		</tr>
		<!--평점-->
		<?if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][4]!="N"):?>
		<tr id="editWeb" group="edit">
			<td colspan="2" class="alignCenter">
				<input type="radio" name="ub_p_grade" id="ub_p_grade" value="1"/> <img src="/himg/board/icon/icon_star_1.png"/>
				<input type="radio" name="ub_p_grade" id="ub_p_grade" value="2"/> <img src="/himg/board/icon/icon_star_2.png"/>
				<input type="radio" name="ub_p_grade" id="ub_p_grade" value="3" checked/> <img src="/himg/board/icon/icon_star_3.png"/>
				<input type="radio" name="ub_p_grade" id="ub_p_grade" value="4"/> <img src="/himg/board/icon/icon_star_4.png"/>
				<input type="radio" name="ub_p_grade" id="ub_p_grade" value="5"/> <img src="/himg/board/icon/icon_star_5.png"/>
			</td>
		</tr>
		<?endif;?>
		<tr>
			<th></th>
			<td>
				<a data-mouseEnter-show2="writeEditWeb" class="open">웹편집</a>
				<a data-mouseEnter-show2="writeEditMobile">모바일편집</a>
			</td>
		</tr>
		<tr id="writeEditWeb" group="writeEdit">
			<th>내용</th>
			<td>
				<textarea style="width:100%;height:300px" id="ub_text" name="ub_text" title="<?php echo $strDataWriteForm;?>" alt="내용" check="write"></textarea>
			</td>
		</tr>
		<tr id="writeEditMobile" group="writeEdit" style="display:none">
			<th>내용(모바일)</th>
			<td>
				<!--span style=""><a class="btn_sml" href="javascript:goDataWriteMobileAreaShowEvent();" id="menu_auth_w" style=""><strong>펼침</strong></a></span-->
				<span style="" id="mobileArea">
					<textarea style="width:100%;height:300px;" id="ub_text_mobile" name="ub_text_mobile" title="<?php echo $strDataWriteForm;?>" alt="내용(모바일)" check=""></textarea>
				</span>
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