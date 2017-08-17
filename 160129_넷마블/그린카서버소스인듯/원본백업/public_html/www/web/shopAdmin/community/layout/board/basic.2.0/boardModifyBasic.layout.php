<?php
	## 기본 설정
	$strAdminMode = $_REQUEST['admin_mode'];
	$strB_NAME = $boardSelectRow['B_NAME'];
	$strB_CODE = $boardSelectRow['B_CODE'];
	$intB_BG_NO = $boardSelectRow['B_BG_NO'];
	$strB_KIND = $boardSelectRow['B_KIND'];
	$strB_SKIN = $boardSelectRow['B_SKIN'];
	$strB_CSS = $boardSelectRow['B_CSS'];
	$strBI_DATAVIEW_FACEBOOK_USE = $boardInfoAry['BI_DATAVIEW_FACEBOOK_USE'];
	$strBI_DATAVIEW_TWITTER_USE = $boardInfoAry['BI_DATAVIEW_TWITTER_USE'];
	$intBI_COLUMN_DEFAULT = $boardInfoAry['BI_COLUMN_DEFAULT'];
	$intBI_LIST_DEFAULT = $boardInfoAry['BI_LIST_DEFAULT'];
	$strBI_SMS_USE = $boardInfoAry['BI_SMS_USE'];
	$strBI_SMS_HP_LIST = $boardInfoAry['BI_SMS_HP_LIST'];
	$strBI_SMS_TEXT = $boardInfoAry['BI_SMS_TEXT'];
	$strB_KIND_SKIN = $strB_KIND . "_" . $strB_SKIN;
	if(!$strBI_SMS_USE) {$strBI_SMS_USE = "N"; }
	$aryBI_SMS_HP_LIST = explode(",", $strBI_SMS_HP_LIST);

	## 게시판 그룹 리스트 불러오기
	include_once  MALL_SHOP . "/conf/community/groupList.info.php";

	## 목록수 칸/라인 설정
	$strListCntColumnHide = "";
	if($b_kind_skin!="data_gallery") { $strListCntColumnHide = " hide"; }
	
	## script 설정
	$aryScriptEx[] = "./common/js/community/communityBoardModify.js";
?>
<div class="contentTop">
	<h2>커뮤니티 설정 (<?php echo $strB_NAME;?>)</h2>
	<div class="clr"></div>
</div>

<br>

<div class="tabImgWrap">
<?php include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/board/basic.2.0/modify.tabMenu.skin.php" ?>
</div>

<br>

<!-- 언어 선택 탭 -->
	<?php include "{$_REQUEST['S_DOCUMENT_ROOT']}{$S_SHOP_HOME}/shopAdmin/include/tab_language.inc.php";?>
<!-- 언어 선택 탭-->

<br>

<div class="tableForm">
	<table>
		<tr>
			<th>게시판명</th>
			<td>
				<input type="text" id="b_name" name="b_name" value="<?php echo $strB_NAME;?>"/>
				<div class="helpTxt">
					* 만들고자 하는 게시판의 이름을 등록해 주세요. 예) 공지사항
				</div>
			</td>
		</tr>
		<tr>
			<th>게시판코드</th>
			<td>
				<input type="text" id="b_code" name="b_code" value="<?php echo $strB_CODE;?>" readOnly/>
				<div class="helpTxt">
					* 코드명을 입력해 주세요. 영문,숫자만 사용가능합니다. 예) notice
				</div>
			</td>
		</tr>
		<tr>
			<th>게시판 그룹</th>
			<td>
				<select name="b_bg_no" id="b_bg_no">
					<option value="-1"<?php if($intB_BG_NO == -1){echo " selected";}?>>사용안함</option>
					<?php foreach($GROUP_LIST as $key => $vel):?>
					<option value="<?php echo $key;?>"<?php if($intB_BG_NO == $key){echo " selected";}?>><?php echo $vel['bg_name'];?></option>
					<?php endforeach;?>
				</script>
			</td>
		</tr>
		<?php if(in_array($strB_KIND_SKIN, array("data_basic", "data_blog", "data_gallery"))):?>
		<tr>
			<th>게시판종류</th>
			<td>
				<ul class="designType">
					<li>
						<img src="/shopAdmin/himg/layout/sample/board_type_data_basic.gif"/>
						<span><input type="radio" name="b_kind_skin" id="b_kind_skin" value="data_basic"<?php if($strB_KIND_SKIN=="data_basic"){ echo " checked"; }?>/>일반게시판</span>
					</li>
					<li>
						<img src="/shopAdmin/himg/layout/sample/board_type_data_gallery.gif"/>
						<span><input type="radio" name="b_kind_skin" id="b_kind_skin" value="data_gallery"<?php if($strB_KIND_SKIN=="data_gallery"){ echo " checked"; }?>/>갤러리형</span>
					</li>
					<li>
						<img src="/shopAdmin/himg/layout/sample/board_type_data_blog.gif"/>
						<span><input type="radio" name="b_kind_skin" id="b_kind_skin" value="data_blog"<?php if($strB_KIND_SKIN=="data_blog"){ echo " checked"; }?>/>블러그형</span>
					</li>
				</ul>
			</td>
		</tr>
		<?php else:?>
		<input type="hidden" name="b_kind_skin" id="b_kind_skin" value="<?php echo $strB_KIND_SKIN?>"/>
		<?php endif;?>
		<?php if($strAdminMode):?>
		<tr>
			<th>게시판종류(상세)</th>
			<td>
				<select name="b_kind_admin" id="b_kind_admin" style="width:300px;">
					<option value="data"<?php if($strB_KIND=="data"){echo " selected"; }?>>일반게시판</option>
					<option value="product"<?php if($strB_KIND=="product"){echo " selected"; }?>>상품게시판</option>
					<option value="event"<?php if($strB_KIND=="event"){echo " selected"; }?>>이벤트게시판</option>
					<option value="talk"<?php if($strB_KIND=="talk"){echo " selected"; }?>>토크게시판</option>
					<option value="mypage"<?php if($strB_KIND=="mypage"){echo " selected"; }?>>회원게시판</option>
				</select>
				<select name="b_skin_admin" id="b_skin_admin" style="width:300px;">
					<option value="basic"<?php if($strB_SKIN=="basic"){echo " selected"; }?>>basic</option>
					<option value="gallery"<?php if($strB_SKIN=="gallery"){echo " selected"; }?>>gallery</option>
					<option value="line"<?php if($strB_SKIN=="line"){echo " selected"; }?>>line</option>
					<option value="comment"<?php if($strB_SKIN=="comment"){echo " selected"; }?>>comment</option>
					<option value="blog"<?php if($strB_SKIN=="blog"){echo " selected"; }?>>blog</option>
					<option value="answer"<?php if($strB_SKIN=="answer"){echo " selected"; }?>>answer</option>
					<option value="user"<?php if($strB_SKIN=="user"){echo " selected"; }?>>user</option>
					<option value="review"<?php if($strB_SKIN=="review"){echo " selected"; }?>>product_review</option>
					<option value="qna"<?php if($strB_SKIN=="qna"){echo " selected"; }?>>product_qna</option>
					<option value="qna"<?php if($strB_SKIN=="qna"){echo " selected"; }?>>mypage_qna</option>
				</select>
				<input type="hidden" name="admin_mode" id="admin_mode" value="1"/>
			</td>
		</tr>
		<?php endif;?>
		<tr>
			<th>스킨설정</th>
			<td>
				<select name="b_css" id="b_css">
					<option value="basicCss1"<?php if($strB_CSS=="basicCss1"){echo " selected";}?>>기본형</option>
					<option value="basicCss2"<?php if($strB_CSS=="basicCss2"){echo " selected";}?>>그레이스킨</option>
					<option value="basicCss3"<?php if($strB_CSS=="basicCss3"){echo " selected";}?>>그린스킨</option>
				</select>
			</td>
		</tr>
		<tr>
			<th>SNS설정</th>
			<td>
				<input type="checkbox" name="bi_dataview_facebook_use" value="Y"<?php if($strBI_DATAVIEW_FACEBOOK_USE=="Y"){echo " checked";}?>>Facebook
				<input type="checkbox" name="bi_dataview_twitter_use"  value="Y"<?php if($strBI_DATAVIEW_TWITTER_USE=="Y"){echo " checked";}?>>Twitter
			</td>
		</tr>
		<tr>
			<th>목록수</th>
			<td>
				<span class="listCntColumn<?php echo $strListCntColumnHide;?>"><input type="input" name="bi_column_default" value="<?php echo $intBI_COLUMN_DEFAULT;?>" class="_w50"/> 칸</span>
				<span class="listCntLine"><input type="input" name="bi_list_default" class="_w50" value="<?php echo $intBI_LIST_DEFAULT;?>"/> 라인</span>
			</td>
		</tr>
		<tr>
			<th>타이틀 표시방법</th>
			<td>
				<input type="input" name="bi_datalist_title_len" class="_w50" value="<?=$boardInfoAry['BI_DATALIST_TITLE_LEN']?>"/>자리 표시
			</td>
		</tr>
		<tr>
			<th>목록항목</th>
			<td>
				<input type="checkbox" name="bi_datalist_field_use[0]"  value="Y" <?if($boardInfoAry['BI_DATALIST_FIELD_USE_0']=="Y"){echo " checked";}?>/>번호 
				<input type="checkbox" name="bi_datalist_field_use[1]"  value="Y" <?if($boardInfoAry['BI_DATALIST_FIELD_USE_1']=="Y"){echo " checked";}?>/>작성자
				<input type="checkbox" name="bi_datalist_field_use[2]"  value="Y" <?if($boardInfoAry['BI_DATALIST_FIELD_USE_2']=="Y"){echo " checked";}?>/>등록일 
				<input type="checkbox" name="bi_datalist_field_use[3]"  value="Y" <?if($boardInfoAry['BI_DATALIST_FIELD_USE_3']=="Y"){echo " checked";}?>/>조회수
				<input type="checkbox" name="bi_datalist_field_use[4]"  value="Y" <?if($boardInfoAry['BI_DATALIST_FIELD_USE_4']=="Y"){echo " checked";}?>/>점수
				<input type="checkbox" name="bi_datalist_field_use[5]"  value="Y" <?if($boardInfoAry['BI_DATALIST_FIELD_USE_5']=="Y"){echo " checked";}?>/>카테고리
			</td>
		</tr>
		<tr>
			<th>작성자 표시방법</th>
			<td>
				<input type="checkbox" name="bi_datalist_writer_show[0]" value="Y" <?if($boardInfoAry['BI_DATALIST_WRITER_SHOW_0']=="Y"){echo " checked";}?>/>성명 
				<input type="checkbox" name="bi_datalist_writer_show[1]" value="Y" <?if($boardInfoAry['BI_DATALIST_WRITER_SHOW_1']=="Y"){echo " checked";}?>/>아이디
				<input type="checkbox" name="bi_datalist_writer_show[2]" value="Y" <?if($boardInfoAry['BI_DATALIST_WRITER_SHOW_2']=="Y"){echo " checked";}?>/>닉네임
				-  작성자명 <input type="input" name="bi_datalist_writer_hidden" class="_w50" value="<?=$boardInfoAry['BI_DATALIST_WRITER_HIDDEN']?>"/>자리외 **** 표시
				<div class="helpTxt">
					* 등록한 글자수외 표시는 별표(****)로 표시됩니다. 예) 홍길***
				</div>
			</td>
		</tr>
		<tr>
			<th>리스트 정렬 설정</th>
			<td>
				<select name="bi_datalist_orderby">
					<option value=""<?if($boardInfoAry['BI_DATALIST_ORDERBY']==""){echo " selected";}?>>기본정렬</option>
					<option value="reg_dt_asc"<?if($boardInfoAry['BI_DATALIST_ORDERBY']=="reg_dt_asc"){echo " selected";}?>>등록날짜 오름차순</option>
					<option value="reg_dt_desc"<?if($boardInfoAry['BI_DATALIST_ORDERBY']=="reg_dt_desc"){echo " selected";}?>>등록날짜 내림차순</option>
				</select>
				<div class="helpTxt">
					* 정렬 기능 사용시 답변형 게시판을 사용 할 수 없습니다.
				</div>
			</td>
		</tr>
		<tr>
			<th>시작페이지</th>
			<td><input type="radio" name="bi_start_mode" value="dataList"<?if($boardInfoAry['BI_START_MODE']=="dataList"){echo " checked";}?>/>목록화면	
				<input type="radio" name="bi_start_mode" value="dataWrite"<?if($boardInfoAry['BI_START_MODE']=="dataWrite"){echo " checked";}?>/>글쓰기화면	
			</td>
		</tr>
		<tr>
			<th>글쓰기후이동</th>
			<td><input type="radio" name="bi_datawrite_end_move" value="dataList"<?if($boardInfoAry['BI_DATAWRITE_END_MOVE']=="dataList"){echo " checked";}?>/>목록화면	
				<input type="radio" name="bi_datawrite_end_move" value="dataWrite"<?if($boardInfoAry['BI_DATAWRITE_END_MOVE']=="dataWrite"){echo " checked";}?>/>글쓰기화면	
				<input type="radio" name="bi_datawrite_end_move" value="dataView"<?if($boardInfoAry['BI_DATAWRITE_END_MOVE']=="dataView"){echo " checked";}?>/>상세보기화면</td>
		</tr>
		<tr>
			<th>목록권한</th>
			<td>
				<input type="radio" name="bi_datalist_use" value="A"<?if($boardInfoAry['BI_DATALIST_USE']=="A"){echo " checked";}?>/>모든회원/비회원
				<input type="radio" name="bi_datalist_use" value="M"<?if($boardInfoAry['BI_DATALIST_USE']=="M"){echo " checked";}?>/>회원전용
				[<?$intCnt=0;foreach($S_MEMBER_GROUP as $key => $group):?>
				<input type="checkbox" name="bi_datalist_member_auth[<?=$intCnt?>]" value="<?=$key?>"<?if($boardInfoAry["BI_DATALIST_MEMBER_AUTH_{$intCnt}"]==$key){echo " checked";}?>/><?print_r($group['NAME'])?>
				<?$intCnt++;endforeach;?>]
			</td>
		</tr>
		<tr>
			<th>글보기권한</th>
			<td> 
				<input type="radio" name="bi_dataview_use" value="A"<?if($boardInfoAry['BI_DATAVIEW_USE']=="A"){echo " checked";}?>/>모든회원/비회원
				<input type="radio" name="bi_dataview_use" value="M"<?if($boardInfoAry['BI_DATAVIEW_USE']=="M"){echo " checked";}?>/>회원전용
				[<?$intCnt=0;foreach($S_MEMBER_GROUP as $key => $group):?>
				<input type="checkbox" name="bi_dataview_member_auth[<?=$intCnt?>]" value="<?=$key?>"<?if($boardInfoAry["BI_DATAVIEW_MEMBER_AUTH_{$intCnt}"]==$key){echo " checked";}?>/><?print_r($group['NAME'])?>
				<?$intCnt++;endforeach;?>]
			</td>
		</tr>
		<tr>
			<th>글쓰기권한</th>
			<td>
				<input type="radio" name="bi_datawrite_use" value="A"<?if($boardInfoAry['BI_DATAWRITE_USE']=="A"){echo " checked";}?>/>모든회원/비회원
				<input type="radio" name="bi_datawrite_use" value="M"<?if($boardInfoAry['BI_DATAWRITE_USE']=="M"){echo " checked";}?>/>회원전용
				[<?$intCnt=0;foreach($S_MEMBER_GROUP as $key => $group):?>
				<input type="checkbox" name="bi_datawrite_member_auth[<?=$intCnt?>]" value="<?=$key?>"<?if($boardInfoAry["BI_DATAWRITE_MEMBER_AUTH_{$intCnt}"]==$key){echo " checked";}?>/><?print_r($group['NAME'])?>
				<?$intCnt++;endforeach;?>]
			</td>
		</tr>
		<tr>
			<th>답변권한</th>
			<td>
				<input type="radio" name="bi_dataanswer_use" value="A"<?if($boardInfoAry['BI_DATAANSWER_USE']=="A"){echo " checked";}?>/>모든회원/비회원
				<input type="radio" name="bi_dataanswer_use" value="M"<?if($boardInfoAry['BI_DATAANSWER_USE']=="M"){echo " checked";}?>/>회원전용
				[<?$intCnt=0;foreach($S_MEMBER_GROUP as $key => $group):?>
				<input type="checkbox" name="bi_dataanswer_member_auth[<?=$intCnt?>]" value="<?=$key?>"<?if($boardInfoAry["BI_DATAANSWER_MEMBER_AUTH_{$intCnt}"]==$key){echo " checked";}?>/><?print_r($group['NAME'])?>
				<?$intCnt++;endforeach;?>]
				<input type="radio" name="bi_dataanswer_use" value="N"<?if($boardInfoAry['BI_DATAANSWER_USE']=="N"){echo " checked";}?>/>사용안함
			</td>
		</tr>
		<tr>
			<th>댓글권한</th><!-- 코멘트 기능을 말함. -->
			<td>
				<input type="radio" name="bi_comment_use" value="A"<?if($boardInfoAry['BI_COMMENT_USE']=="A"){echo " checked";}?>/>모든회원/비회원
				<input type="radio" name="bi_comment_use" value="M"<?if($boardInfoAry['BI_COMMENT_USE']=="M"){echo " checked";}?>/>회원전용
				[<?$intCnt=0;foreach($S_MEMBER_GROUP as $key => $group):?>
				<input type="checkbox" name="bi_comment_member_auth[<?=$intCnt?>]" value="<?=$key?>"<?if($boardInfoAry["BI_COMMENT_MEMBER_AUTH_{$intCnt}"]==$key){echo " checked";}?>/><?print_r($group['NAME'])?>
				<?$intCnt++;endforeach;?>]
				<input type="radio" name="bi_comment_use" value="N"<?if($boardInfoAry['BI_COMMENT_USE']=="N"){echo " checked";}?>/>사용안함
			</td>
		</tr>
		<tr>
			<th>글보기 네비게이션</th>
			<td>
				<input type="checkbox" name="bi_dataview_nextprve_use" value="Y"<?if($boardInfoAry['BI_DATAVIEW_NEXTPRVE_USE']=="Y"){echo " checked";}?>> 이전/다음 사용
			</td>
		</tr>
		<tr>
			<th>비밀글기능</th>
			<td>
				<input type="radio" name="bi_datawrite_lock_use" value="C"<?if($boardInfoAry['BI_DATAWRITE_LOCK_USE']=="C"){echo " checked";}?>> 사용(사용자 선택)
				<input type="radio" name="bi_datawrite_lock_use" value="E"<?if($boardInfoAry['BI_DATAWRITE_LOCK_USE']=="E"){echo " checked";}?>> 사용(무조건)
			</td>
		</tr>
		<tr>
			<th>에디터사용</th>
			<td>
				<input type="radio" name="bi_datawrite_form" value="textWrite"<?if($boardInfoAry['BI_DATAWRITE_FORM']=="textWrite"){echo " checked";}?>> 텍스트 글쓰기
				<input type="radio" name="bi_datawrite_form" value="higheditor_full"<?if($boardInfoAry['BI_DATAWRITE_FORM']=="higheditor_full"){echo " checked";}?>> 에디터 글쓰기
			</td>
		</tr>
		<tr>
			<th>관리자 메인화면 표시 여부</th>
			<td>
				<input type="radio" name="bi_admin_main_show" value="N"<?if($boardInfoAry['BI_ADMIN_MAIN_SHOW']=="N"){echo " checked";}?>> 표시 안함
				<input type="radio" name="bi_admin_main_show" value="Y"<?if($boardInfoAry['BI_ADMIN_MAIN_SHOW']=="Y"){echo " checked";}?>> 표시함
				(순위 : <input type="text"  name="bi_admin_main_sort" value="<?=$boardInfoAry['BI_ADMIN_MAIN_SORT']?>">)
			</td>
		</tr>
		<tr>
			<th>첨부파일</th>
			<td>
				<select name="bi_attachedfile_use" id="bi_attachedfile_use">
					<option value="0"<?if($boardInfoAry['BI_ATTACHEDFILE_USE']=="0"){echo " selected";}?>>사용안함</option>
					<option value="1"<?if($boardInfoAry['BI_ATTACHEDFILE_USE']=="1"){echo " selected";}?>>1개</option>
					<option value="2"<?if($boardInfoAry['BI_ATTACHEDFILE_USE']=="2"){echo " selected";}?>>2개</option>
					<option value="3"<?if($boardInfoAry['BI_ATTACHEDFILE_USE']=="3"){echo " selected";}?>>3개</option>
					<option value="4"<?if($boardInfoAry['BI_ATTACHEDFILE_USE']=="4"){echo " selected";}?>>4개</option>
					<option value="5"<?if($boardInfoAry['BI_ATTACHEDFILE_USE']=="5"){echo " selected";}?>>5개</option>
				</select>
			</td>
		</tr>
		<?for($i=0;$i<5;$i++):?>
		<tr id="attachedfile_name_field" style="<?if($boardInfoAry['BI_ATTACHEDFILE_USE']<=$i){echo "display:none";}?>">
			<th>첨부파일<?=$i+1?> 이름</th>
			<td>
				<input type="text" name="bi_attachedfile_name[<?=$i?>]" id="" value="<?=$boardInfoAry["BI_ATTACHEDFILE_NAME_{$i}"]?>" style="width:200px" />
			</td>
		</tr>
		<tr id="attachedfile_key_field" style="<?if($boardInfoAry['BI_ATTACHEDFILE_USE']<=$i){echo "display:none";}?>">
			<th>첨부파일<?=$i+1?> 형식</th>
			<td>
				<select name="bi_attachedfile_key[<?=$i?>]" id="" style="width:200px">
					<option value="file"<?if($boardInfoAry["BI_ATTACHEDFILE_KEY_{$i}"]=="file"){echo " selected";}?>>첨부파일</option>
					<option value="listImage"<?if($boardInfoAry["BI_ATTACHEDFILE_KEY_{$i}"]=="listImage"){echo " selected";}?>>리스트이미지</option>
					<option value="bigImage"<?if($boardInfoAry["BI_ATTACHEDFILE_KEY_{$i}"]=="bigImage"){echo " selected";}?>>큰이미지</option>
					<option value="image"<?if($boardInfoAry["BI_ATTACHEDFILE_KEY_{$i}"]=="image"){echo " selected";}?>>이미지</option>
					<option value="movie"<?if($boardInfoAry["BI_ATTACHEDFILE_KEY_{$i}"]=="movie"){echo " selected";}?>>동영상</option>
				</select>
				<p class="attachedText hide">* 리스트 이미지를 선택하시면 목록에 이미지가 보여지는 게시판입니다.</p>
			</td>
		</tr>
		<?endfor;?>
		<?php if($S_SMS_USE == "Y"):?>
		<tr>
			<th>SMS 설정</th>
			<td>
				<input type="radio" name="bi_sms_use" value="Y"<?php if($strBI_SMS_USE == "Y") {echo " checked";}?>>사용
				<input type="radio" name="bi_sms_use" value="N"<?php if($strBI_SMS_USE == "N") {echo " checked";}?>>사용안함 
				<p class="helpTxt">* 해당 게시판에 게시물 등록시, 등록된 연락처로 SMS를 발송하는 기능입니다.</p>
				<p class="helpTxt">* 건당 사용 요금이 발생합니다.</p>
				<div class="smsInfo">
					<div>
						<input type="text" id="sms_hp_1" maxlength="3" style="width:60px"> -
						<input type="text" id="sms_hp_2" maxlength="4" style="width:60px"> -
						<input type="text" id="sms_hp_3" maxlength="4" style="width:60px">
						<a href="javascript:goCommunityBoardWriteSmsInsert()" class="btn_sml"><span>등록</span></a>
						<p class="helpTxt">* SMS을 전송받을 연락처를 등록해 주세요.</p>
						<p class="helpTxt">* 최대 5명까지 입력이 가능합니다.</p>
					</div>
					<div>
						<input type="hidden" name="bi_sms_hp_list" value="">
						<select id="sms_hp_list" multiple style="width:300px;height:50px;">
							<?php foreach($aryBI_SMS_HP_LIST as $key => $data):?>
							<option value="<?php echo $data;?>"><?php echo $data;?></option>
							<?php endforeach;?>
						</select>
						<a href="javascript:goCommunityBoardWriteSmsDelete()" class="btn_sml"><span>삭제</span></a>
						<p class="helpTxt">* 등록된 연락처를 선택 후 삭제할 수 있습니다.</p>
					</div>
					<div class="smsFormWrap">
						<textarea name="bi_sms_text"><?php echo $strBI_SMS_TEXT;?></textarea><p>
						<strong>25/80</strong> Byte</p>
					</div>
				</div>
			</td>
		</tr>
		<?php endif;?>
	</table>

	<input type="hidden" name="b_use" id="b_use" value="<?=$boardSelectRow['B_USE']?>"/>
</div>

<br>

<div class="button">
	<a class="btn_big" href="javascript:goCommunityBoardModifyActEvent();" id="menu_auth_m" style="display:none"><strong>설정 변경</strong></a>
	<a class="btn_big" href="javascript:goCommunityBoardModifyCancelMoveEvent();"><strong>목록</strong></a>
</div>

<input type="hidden" name="b_no" value="<?=$boardSelectRow['B_NO']?>"/>