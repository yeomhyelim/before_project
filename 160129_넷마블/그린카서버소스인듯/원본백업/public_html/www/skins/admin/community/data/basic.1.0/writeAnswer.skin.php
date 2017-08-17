<?
	## 설정
	// 2013.06.18 kim hee sung 입점몰 추가로 인한 작성자명 변경.
//	$ub_name		= $S_SITE_ENG_NM;
	$ub_name		= $_REQUEST['member_name'];

	## 설정
	$dataSelectRow					= $_REQUEST['result']['DataMgr'];
	$attachedfileViewListResult		= $_REQUEST['result']['AttachedfileMgr'];

	## 기본 설정
	$no								= $dataSelectRow['UB_NO'];

	## 카테고리 필드 설정
	$category_field_use = "";
	if(in_array($_REQUEST['BOARD_INFO']['bi_category_use'], array("Y","A"))) { $category_field_use = "Y"; }

	## 추가 필드 설정
	$user_field_use = "";
	if($_REQUEST['BOARD_INFO']['bi_userfield_use'] == "Y") { $user_field_use = "Y"; }

	## 링크 필드 설정
	$like_field_use = "";
	if($dataSelectRow['UB_URL'] && $dataSelectRow['UB_URL'] != "http://") { $link_field_use = "Y"; }

	## 평점 필드 설정
	$average_field_use = "";
	if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][4] == "Y") { $average_field_use = "Y"; }

	## 웹 글 필드 설정
	$web_text_field_use = "";
	if($dataSelectRow['UB_TEXT']) { $web_text_field_use = "Y"; }

	## 모바일 글 필드 설정
	$mobile_text_field_use = "";
	if($dataSelectRow['UB_TEXT_MOBILE']) { $mobile_text_field_use = "Y"; }

	## 첨부파일 필드 설정
	$attachedfile_field_use = "";
	if($_REQUEST['list_total']['AttachedfileMgr']) { $attachedfile_field_use = "Y"; }

//	print_r($_REQUEST);

	## 카테고리 내용 설정
	if($category_field_use == "Y"):
		include_once "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/community/category/category.{$_REQUEST['b_code']}.info.php";
		$ub_bc_no		= $dataSelectRow['UB_BC_NO'];
		$category_text	= $CATEGORY_LIST[$ub_bc_no]['bc_name'];
	endif;

	## 작성일 내용 설정
	$reg_dt_text		= date("Y-m-d H:i:d", strtotime($dataSelectRow['UB_REG_DT']));

	## 작성자 내용 설정
	$writer_text		= $dataSelectRow['UB_NAME'];
	if($dataSelectRow['UB_M_ID']):
		if($writer_text)	{ $writer_text = "{$writer_text}({$dataSelectRow['UB_M_ID']})";		}
		else				{ $writer_text = $dataSelectRow['UB_M_ID'];							}
	endif;
	## 2014.08.28 kim hee sung
	## 입점사는 작성자를  숨김 처리합니다.
	if($strMemberType == "S"):
		$intCnt	= mb_strlen($writer_text, "UTF-8");
		$writer_text = mb_substr($writer_text, 0, 1, "UTF-8");
		for($i=0;$i<3;$i++) { $writer_text .= "*"; }
	endif;

	## 제목 내용 설정
	$title_text			= stripslashes($dataSelectRow['UB_TITLE']);
//	if($dataSelectRow['UB_FUNC']['UB_FUNC_NOTICE'] == "Y")	{ $title_text = "[공지사항]{$title_text}";	}
//	if($dataSelectRow['UB_FUNC']['UB_FUNC_LOCK']=="Y")		{ $title_text = "{$title_text} <img src=\"/himg/board/A0001/icon_bbs_lock.png\">";	}
//	if($dataSelectRow['UB_FUNC']['UB_FUNC_ICON']=="Y")		{ $title_text = "{$title_text} {아이콘]";	}
	
	$title_text			= "{$title_text}";

	## 웹 내용 설정
//	if($web_text_field_use == "Y"):
//		$type = "Y";
////		if($_REQUEST['BOARD_INFO']['bi_datawrite_form'] == "higheditor_full") { $type = "N"; }
//		if($dataSelectRow['UB_M_NO'] != 1) { $type = "N"; }
//
//		if(substr_count($dataSelectRow['UB_TEXT'], "<P>") > 0)				{ $type = "Y"; }
//		if(substr_count($dataSelectRow['UB_TEXT'], "<p>") > 0)				{ $type = "Y"; }
//		if(substr_count($dataSelectRow['UB_TEXT'], "<DIV>") > 0)			{ $type = "Y"; }
//		if(substr_count($dataSelectRow['UB_TEXT'], "<div>") > 0)				{ $type = "Y"; }
//		if(substr_count($dataSelectRow['UB_TEXT'], "&nbsp;") > 0)			{ $type = "Y"; }
//		if(substr_count($dataSelectRow['UB_TEXT'], "<img") > 0)				{ $type = "Y"; }
//		if(substr_count($dataSelectRow['UB_TEXT'], "<embed ") > 0)		{ $type = "Y"; }
//
//		$web_text = strConvertCut($dataSelectRow['UB_TEXT'],0,$type);
//	endif;

	if($_REQUEST['BOARD_INFO']['bi_datawrite_form'] == "textWrite"):
		$web_text		= $dataSelectRow['UB_TEXT'];
		$web_text		= "\n\n\n\n\n\n-----Original Message-----\n\n{$web_text}";
	else:
		$web_text		= $dataSelectRow['UB_TEXT'];
		$web_text		= "<br><br><br>-----Original Message-----<br><br>{$web_text}";
	endif;

	## 모바일 내용 설정
	if($mobile_text_field_use == "Y"):
		$type = "Y";
		if($_REQUEST['BOARD_INFO']['bi_datawrite_form'] == "higheditor_full") { $type = "N"; }
		$mobile_text = strConvertCut($dataSelectRow['UB_TEXT_MOBILE'],0,$type);
	endif;

	## 관리자는 무조건 에디터 박스 사용
//	$strDataWriteForm = $_REQUEST['BOARD_INFO']['bi_datawrite_form'];
	$strDataWriteForm = "higheditor_full";

?>
	<script type="text/javascript">



	

	</script>
	<table>
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
				<input type="text" <?=$nBox?>  style="width:99%;" id="ub_title" name="ub_title" alt="제목" value="<?=$title_text?>" check="write" maxlength="100"/>
			</td>
		</tr>
		<?if(($_REQUEST['BOARD_INFO']['bi_datawrite_lock_use']=="C") || ($_REQUEST['BOARD_INFO']['bi_datawrite_notice_use']=="Y") || ($_REQUEST['BOARD_INFO']['bi_datawrite_icon_use']=="Y")):?>
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
		<tr>
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
				<a data-mouseEnter-show2="writeAnswerEditWeb" class="open">웹편집</a>
				<a data-mouseEnter-show2="writeAnswerEditMobile">모바일편집</a>
			</td>
		</tr>
		<tr id="writeAnswerEditWeb" group="writeAnswerEdit">
			<th>내용</th>
			<td>
				<textarea style="width:100%;height:300px" id="ub_text" name="ub_text" title="<?php echo $strDataWriteForm;?>" alt="내용" check="write"><?=$web_text?></textarea>
			</td>
		</tr>
		<tr id="writeAnswerEditMobile" group="writeAnswerEdit" style="display:none">
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