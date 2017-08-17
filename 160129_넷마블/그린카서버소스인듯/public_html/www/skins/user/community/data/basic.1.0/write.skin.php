<?
	## 설정
	## 목록 설명
	## 커뮤니티 리스트 목록 설정(번호=0,작성자=1,등록일=2,조회수=3,점수=4)
	## 로그인 회원이 관리자인 경우 textarea(내용)가 에디터박스 편집창으로 변경
	$strDataWriteForm = $_REQUEST['BOARD_INFO']['bi_datawrite_form'];
	if($_REQUEST['member_group'] == "001") { $strDataWriteForm = "higheditor_full"; }
	
	if ($_REQUEST['BOARD_INFO']['bi_datalist_writer_show'][0]=="Y"):
		$strMemberName = $_REQUEST['member_name'];
	elseif ($_REQUEST['BOARD_INFO']['bi_datalist_writer_show'][1]=="Y"):
		$strMemberName = $_REQUEST['member_id'];
	elseif ($_REQUEST['BOARD_INFO']['bi_datalist_writer_show'][2]=="Y"):
		$strMemberName = $_REQUEST['member_nickname'];
	endif;
	if (!$strMemberName) $strMemberName = $_REQUEST['member_name'];
?>

	<table class="tableForm">
		<colgroup>
			<col width="150"/>
			<col/>
		</colgroup>
		<?if($_REQUEST['BOARD_INFO']['bi_category_use']=="Y"): // 카테고리 사용?>
		<tr>
			<th class="cate"><?=$LNG_TRANS_CHAR["CW00064"] //카테고리?></th>
			<td><? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/user/community/category/include.1.0/combobox.write.inc.skin.php" ?></td>
		</tr>
		<?endif;?>
		<tr>
			<th class="name"><?=$LNG_TRANS_CHAR["CW00053"] //작성자?></th>
			<td>
				<? if($_REQUEST['member_login']):	// 회원   ?>
					<input type="text" id="ub_name" name="ub_name" value="<?=$_REQUEST['member_name'];?>" alt="작성자" check="write" maxlength="10" class="_w300" readonly/>
				<? else:				// 비회원 ?>
					<input type="text" <?=$nBox?>  id="ub_name" name="ub_name"  alt="작성자" check="write" maxlength="10" class="_w300"/>
				<? endif; ?>
			</td>
		</tr>
		<tr>
			<th class="mail"><?=$LNG_TRANS_CHAR["MW00010"] //이메일?></th>
			<td>
				<? if($_REQUEST['member_login']):	// 회원   ?>
					<input type="text"  id="ub_mail" name="ub_mail" value="<?=$_REQUEST['member_mail'];?>"  alt="이메일" check="write" maxlength="30" class="_w300"/>
				<? else:				// 비회원 ?>
					<input type="text" <?=$nBox?>  style="width:300px;" id="ub_mail" name="ub_mail"  alt="이메일" check="write" maxlength="30" class="_w300"/>
				<? endif; ?>
			</td>
		</tr>
		<? include "userfield.write.skin.php" ?>
		<tr>
			<th class="tit"><?=$LNG_TRANS_CHAR["CW00062"] //제목?></th>
			<td>
				<input type="text" <?=$nBox?> id="ub_title" name="ub_title" alt="제목" check="write" style="width:98%;" maxlength="50"/>
				<?if($_REQUEST['BOARD_INFO']['bi_datawrite_notice_use']=="Y" && $_REQUEST['member_group']=="001"):?>
					<span class="boardTxtInfo">
						<input type="checkbox" id="ub_func_notice" name="ub_func_notice" value="Y"/> <?=$LNG_TRANS_CHAR["CW00068"] //공지글?>
					</span>
				<?endif;?>
				<?if($_REQUEST['BOARD_INFO']['bi_widget_icon_use']=="Y"):?>
					<span class="boardTxtInfo">
						<input type="checkbox" id="ub_func_icon_widget" name="ub_func_icon_widget" value="Y"/> <?=$LNG_TRANS_CHAR["CW00069"] //위젯글?>
					</span>
				<?endif;?>
				<?if($_REQUEST['BOARD_INFO']['bi_datawrite_lock_use']=="C"):?>
						<span class="boardTxtInfo">
							<input type="checkbox" id="ub_func_lock"   name="ub_func_lock"   value="Y"<?if($dataSelectRow['UB_FUNC']['UB_FUNC_LOCK']=="Y"){ echo " checked"; }?>/> <?=$LNG_TRANS_CHAR["CW00070"] //비밀글?>
							(<?=$LNG_TRANS_CHAR["CW00071"] //체크후 작성시 운영자와 등록자만 조회 가능합니다.?>)
						</span>
				<?elseif($_REQUEST['BOARD_INFO']['bi_datawrite_lock_use']=="E"):?>
							<input type="checkbox" id="ub_func_lock"   name="ub_func_lock"   value="Y" checked style="display:none"/>
				<?endif;?>
			</td>
		</tr>
		<!--평점-->
		<?if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][4]=="Y"):?>
		<tr>
			<th class="rate"><?=$LNG_TRANS_CHAR["CW00056"] //평점?></th>
			<td>
				<input type="radio" name="ub_p_grade" id="ub_p_grade" value="1"/> <img src="/himg/board/icon/icon_star_1.png"/>
				<input type="radio" name="ub_p_grade" id="ub_p_grade" value="2"/> <img src="/himg/board/icon/icon_star_2.png"/>
				<input type="radio" name="ub_p_grade" id="ub_p_grade" value="3"/> <img src="/himg/board/icon/icon_star_3.png"/>
				<input type="radio" name="ub_p_grade" id="ub_p_grade" value="4"/> <img src="/himg/board/icon/icon_star_4.png"/>
				<input type="radio" name="ub_p_grade" id="ub_p_grade" value="5" checked/> <img src="/himg/board/icon/icon_star_5.png"/>
			</td>
		</tr>
		<?endif;?>
		<tr>
			<th><?=$LNG_TRANS_CHAR["CW00063"] //내용?></th>
			<td>
				<textarea style="width:100%;height:300px;" id="ub_text" name="ub_text" title="<?=$strDataWriteForm?>" check="write"></textarea>
			</td>
		</tr>
		<?if($_REQUEST['BOARD_INFO']['bi_attachedfile_use']):?>
		<tr>
			<th><?=$LNG_TRANS_CHAR["CW00058"] //첨부파일?></th>
			<td>
				<a class="btn_sml" href="javascript:goAttachedfileOpen();" id="menu_auth_w" style=""><strong><?=$LNG_TRANS_CHAR["CW00058"] //파일선택?></strong></a>
				<div id="fileList">
				</div>
				<textarea id="fileList_form" style="display:none">
					<li id="" style="float:left;display: inline-block;">
						<span></span>
						<img src="" style="width:50px;height:50px;"/>
						<input type="hidden" name="fl_temp_file[]" id="fl_temp_file" value=""/>
						<input type="hidden" name="fl_temp_key[]"  id="fl_temp_key"  value=""/>
						<a href="">[X]</a>
					</li>
				</textarea>
			</td>
		</tr>
		<?endif;?>
		<?if($_REQUEST['member_login']):	//회원?>
		<input type="hidden" name="ub_m_id" id="ub_m_id" value="<?=$_REQUEST['member_id']?>">
		<?else:				// 비회원 ?>
		<tr>
			<th><?=$LNG_TRANS_CHAR["MW00002"] //비밀번호?></th>
			<td>
				<input type="password" <?=$nBox?>  style="width:200px;" id="ub_pass" name="ub_pass" check="write"/>
			</td>
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["MW00003"] //비밀번호확인?></th>
			<td>
				<input type="password" <?=$nBox?>  style="width:200px;" id="ub_pass1" name="ub_pass1" check="write"/>
			</td>
		</tr>
		<?endif; ?>
	</table>