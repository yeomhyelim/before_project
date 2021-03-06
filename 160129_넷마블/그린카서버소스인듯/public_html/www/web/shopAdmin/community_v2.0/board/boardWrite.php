<?php
	## 스크립트 설정 
	$aryScriptEx[] = "./common/js/community_v2.0/board/boardWrite.js";
?>
<div class="contentTop">
	<h2>커뮤니티 생성</h2>
	<div class="clr"></div>
</div>

<br>

<div class="tableForm">
	<form name="form" id="form">
	<input type="hidden" name="menuType" id="menuType" value="community_v2.0">
	<input type="hidden" name="mode" id="mode" value="">
	<input type="hidden" name="act" id="act" value="">
	<input type="hidden" name="bi_datawrite_form" value="higheditor_full">
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
				<input type="text" name="b_code" id="b_code" value="">
				<div class="helpTxt">
					* 코드명을 입력해 주세요. 영문,숫자만 사용가능합니다. 예) notice
				</div>
			</td>
		</tr>
		<tr>
			<th>게시판 그룹</th>
			<td>
				<select name="b_bg_no" id="b_bg_no"<?php echo $strDisabled;?>>
					<option value="-1">사용안함</option>
					<?php foreach($GROUP_LIST as $key => $vel):?>
					<option value=""<?php if($intB_BG_NO == $key){echo " selected";}?>><?php echo $vel['bg_name'];?></option>
					<?php endforeach;?>
				</script>
			</td>
		</tr>
		<tr>
			<th>게시판종류</th>
			<td>
				<ul class="designType">
					<li>
						<img src="/shopAdmin/himg/layout/sample/board_type_data_basic.gif"/>
						<span><input type="radio" name="b_kind_skin" id="b_kind_skin" value="data_basic" checked/>일반게시판</span>
					</li>
					<li>
						<img src="/shopAdmin/himg/layout/sample/board_type_data_gallery.gif"/>
						<span><input type="radio" name="b_kind_skin" id="b_kind_skin" value="data_gallery"/>갤러리형</span>
					</li>
					<!-- li>
						<img src="/shopAdmin/himg/layout/sample/board_type_data_blog.gif"/>
						<span><input type="radio" name="b_kind_skin" id="b_kind_skin" value="data_blog"<?php if($strB_KIND_SKIN=="data_blog"){ echo " checked"; }?><?php echo $strDisabled;?>/>블러그형</span>
					</li //-->
				</ul>
			</td>
		</tr>
		<tr>
			<th>스킨설정</th>
			<td>
				<select name="b_css" id="b_css">
					<option value="basicCss1">기본형</option>
					<option value="basicCss2">그레이스킨</option>
					<option value="basicCss3">그린스킨</option>
				</select>
			</td>
		</tr>
		<!--
		<tr>
			<th>SNS설정</th>
			<td>
				<input type="checkbox" name="bi_dataview_facebook_use" value="Y">Facebook
				<input type="checkbox" name="bi_dataview_twitter_use"  value="Y">Twitter
			</td>
		</tr>
		-->
		<tr>
			<th>목록수</th>
			<td>
				<span class="listCntColumn hide"><input type="input" name="bi_column_default" value="5" class="_w50"/> 칸</span>
				<span class="listCntLine"><input type="input" name="bi_list_default" class="_w50" value="10"/> 라인</span>
			</td>
		</tr>
		<tr>
			<th>타이틀 표시방법</th>
			<td>
				<input type="input" name="bi_datalist_title_len" class="_w50" value="50"/>자리 표시
			</td>
		</tr>
		<tr>
			<th>목록항목</th>
			<td>
				<input type="checkbox" name="bi_datalist_field_use[0]"  value="Y" checked/>번호 
				<input type="checkbox" name="bi_datalist_field_use[1]"  value="Y" checked/>작성자
				<input type="checkbox" name="bi_datalist_field_use[2]"  value="Y" checked/>등록일 
				<input type="checkbox" name="bi_datalist_field_use[3]"  value="Y" checked/>조회수
				<input type="checkbox" name="bi_datalist_field_use[4]"  value="Y"/>점수
				<input type="checkbox" name="bi_datalist_field_use[5]"  value="Y"/>카테고리
				<input type="checkbox" name="bi_datalist_field_use[6]"  value="Y"/>리스트 이미지
				<input type="checkbox" name="bi_datalist_field_use[7]"  value="Y"/>상품 이미지
			</td>
		</tr>
		<tr>
			<th>작성자 표시방법</th>
			<td>
				<input type="checkbox" name="bi_datalist_writer_show[0]" value="Y"/>성명 
				<input type="checkbox" name="bi_datalist_writer_show[1]" value="Y"/>아이디
				<input type="checkbox" name="bi_datalist_writer_show[2]" value="Y"/>닉네임
				-  작성자명 <input type="input" name="bi_datalist_writer_hidden" class="_w50" value=""/>자리외 **** 표시
				<div class="helpTxt">
					* 등록한 글자수외 표시는 별표(****)로 표시됩니다. 예) 홍길***
				</div>
			</td>
		</tr>
		<tr>
			<th>리스트 정렬 설정</th>
			<td>
				<select name="bi_datalist_orderby">
					<option value="">기본정렬</option>
					<option value="reg_dt_asc">등록날짜 오름차순</option>
					<option value="reg_dt_desc">등록날짜 내림차순</option>
				</select>
				<div class="helpTxt">
					* 정렬 기능 사용시 답변형 게시판을 사용 할 수 없습니다.
				</div>
			</td>
		</tr>
		<tr>
			<th>시작페이지</th>
			<td><input type="radio" name="bi_start_mode" value="dataList" checked/>목록화면	
				<input type="radio" name="bi_start_mode" value="dataWrite"/>글쓰기화면	
			</td>
		</tr>
		<tr>
			<th>글쓰기후이동</th>
			<td><input type="radio" name="bi_datawrite_end_move" value="dataList" checked/>목록화면	
				<input type="radio" name="bi_datawrite_end_move" value="dataWrite"/>글쓰기화면	
				<input type="radio" name="bi_datawrite_end_move" value="dataView"/>상세보기화면</td>
		</tr>
		<tr>
			<th>목록권한</th>
			<td>
				<input type="radio" name="bi_datalist_use" value="A" checked/>모든회원/비회원
				<input type="radio" name="bi_datalist_use" value="M"/>회원전용
				[<?php	$intCnt = 0;
						foreach($S_MEMBER_GROUP as $key => $group):

							## 기본 설정
							$strNAME = $group['NAME'];
							$strAuth = $aryBI_DATALIST_MEMBER_AUTH[$intCnt];
				 ?>
				<input type="checkbox" name="bi_datalist_member_auth[<?php echo $intCnt;?>]" value="<?php echo $key;?>"/><?php echo $strNAME;?>
				<?php	$intCnt++;
						endforeach;?>]
			</td>
		</tr>
		<tr>
			<th>글보기권한</th>
			<td> 
				<input type="radio" name="bi_dataview_use" value="A" checked/>모든회원/비회원
				<input type="radio" name="bi_dataview_use" value="M"/>회원전용
				[<?php	$intCnt = 0;
						foreach($S_MEMBER_GROUP as $key => $group):

							## 기본 설정
							$strNAME = $group['NAME'];
							$strAuth = $aryBI_DATAVIEW_MEMBER_AUTH[$intCnt];
				 ?>
				<input type="checkbox" name="bi_dataview_member_auth[<?php echo $intCnt;?>]" value="<?php echo $key;?>"/><?php echo $strNAME;?>
				<?php	$intCnt++;
						endforeach;?>]
			</td>
		</tr>
		<tr>
			<th>글쓰기권한</th>
			<td>
				<input type="radio" name="bi_datawrite_use" value="A"/>모든회원/비회원
				<input type="radio" name="bi_datawrite_use" value="M" checked/>회원전용
				[<?php	$intCnt = 0;
						foreach($S_MEMBER_GROUP as $key => $group):

							## 기본 설정
							$strNAME = $group['NAME'];
							$strAuth = $aryBI_DATAWRITE_MEMBER_AUTH[$intCnt];

							## 사용권한 설정
							$strChecked = ""; 
							if($intCnt == 0) { $strChecked = " checked"; }
				 ?>
				<input type="checkbox" name="bi_datawrite_member_auth[<?php echo $intCnt;?>]" value="<?php echo $key;?>"<?php echo $strChecked;?>/><?php echo $strNAME;?>
				<?php	$intCnt++;
						endforeach;?>]
			</td>
		</tr>
		<tr>
			<th>답변권한</th>
			<td>
				<input type="radio" name="bi_dataanswer_use" value="A"/>모든회원/비회원
				<input type="radio" name="bi_dataanswer_use" value="M"/>회원전용
				[<?php	$intCnt = 0;
						foreach($S_MEMBER_GROUP as $key => $group):

							## 기본 설정
							$strNAME = $group['NAME'];
							$strAuth = $aryBI_DATAANSWER_MEMBER_AUTH[$intCnt];
				 ?>
				<input type="checkbox" name="bi_dataanswer_member_auth[<?php echo $intCnt;?>]" value="<?php echo $key;?>"/><?php echo $strNAME;?>
				<?php	$intCnt++;
						endforeach;?>]
				<input type="radio" name="bi_dataanswer_use" value="N" checked/>사용안함
			</td>
		</tr>
		<tr>
			<th>댓글권한</th><!-- 코멘트 기능을 말함. -->
			<td>
				<input type="radio" name="bi_comment_use" value="A"/>모든회원/비회원
				<input type="radio" name="bi_comment_use" value="M"/>회원전용
				[<?php	$intCnt = 0;
						foreach($S_MEMBER_GROUP as $key => $group):

							## 기본 설정
							$strNAME = $group['NAME'];
							$strAuth = $aryBI_COMMENT_MEMBER_AUTH[$intCnt];
				 ?>
				<input type="checkbox" name="bi_comment_member_auth[<?php echo $intCnt;?>]" value="<?php echo $key;?>"/><?php echo $strNAME;?>
				<?php	$intCnt++;
						endforeach;?>]
				<input type="radio" name="bi_comment_use" value="N" checked/>사용안함
			</td>
		</tr>
		<tr>
			<th>글보기 네비게이션</th>
			<td>
				<input type="checkbox" name="bi_dataview_nextprve_use" value="Y"> 이전/다음 사용
			</td>
		</tr>
		<tr>
			<th>비밀글기능</th>
			<td>
				<input type="radio" name="bi_datawrite_lock_use" value="C" checked> 사용(사용자 선택)
				<input type="radio" name="bi_datawrite_lock_use" value="E"> 사용(무조건)
			</td>
		</tr>
		<!-- tr>
			<th>에디터사용</th>
			<td>
				<input type="radio" name="bi_datawrite_form" value="textWrite"<?php if($strBI_DATAWRITE_FORM=="textWrite"){echo " checked";}?><?php echo $strDisabled;?>> 텍스트 글쓰기
				<input type="radio" name="bi_datawrite_form" value="higheditor_full"<?php if($strBI_DATAWRITE_FORM=="higheditor_full"){echo " checked";}?><?php echo $strDisabled;?>> 에디터 글쓰기
			</td>
		</tr //-->
		<tr>
			<th>관리자 메인화면 표시 여부</th>
			<td>
				<input type="radio" name="bi_admin_main_show" value="N" checked> 표시 안함
				<input type="radio" name="bi_admin_main_show" value="Y"> 표시함
				(순위 : <input type="text"  name="bi_admin_main_sort" value="">)
			</td>
		</tr>
		<tr>
			<th>삭제글설정</th>
			<td>
				<input type="radio" name="bi_datadelete_after" value="hide"> 삭제후 숨김
				<input type="radio" name="bi_datadelete_after" value="text" checked> 삭제후 알림
			</td>
		</tr>
		<tr>
			<th>첨부파일</th>
			<td>
				<select name="bi_attachedfile_use" id="bi_attachedfile_use">
					<option value="0" selected>사용안함</option>
					<option value="1">1개</option>
					<option value="2">2개</option>
					<option value="3">3개</option>
					<option value="4">4개</option>
					<option value="5">5개</option>
				</select>
			</td>
		</tr>
		<?php for($i=0;$i<5;$i++):?>
		<tr id="attachedfile_name_field" style="display:none">
			<th>첨부파일<?php echo ($i+1);?> 이름</th>
			<td>
				<input type="text" name="bi_attachedfile_name[<?php echo $i;?>]" id="" value="<?php echo $aryBI_ATTACHEDFILE_NAME[$i];?>" style="width:200px" />
			</td>
		</tr>
		<tr id="attachedfile_key_field" style="display:none">
			<th>첨부파일<?php echo ($i+1);?> 형식</th>
			<td>
				<select name="bi_attachedfile_key[<?php echo $i;?>]" id="" style="width:200px">
					<option value="file" selected>첨부파일</option>
					<option value="listImage">리스트이미지</option>
					<!-- option value="bigImage">큰이미지</option //-->
					<option value="image">이미지</option>
					<!-- option value="movie">동영상</option //-->
				</select>
				<p class="attachedText hide">* 리스트 이미지를 선택하시면 목록에 이미지가 보여지는 게시판입니다.</p>
			</td>
		</tr>
		<?php endfor;?>
		<?php if($S_SMS_USE == "Y"):?>
		<tr>
			<th>SMS 설정</th>
			<td>
				<input type="radio" name="bi_sms_use" value="Y">사용
				<input type="radio" name="bi_sms_use" value="N" checked>사용안함 
				<p class="helpTxt">* 해당 게시판에 게시물 등록시, 등록된 연락처로 SMS를 발송하는 기능입니다.</p>
				<p class="helpTxt">* 건당 사용 요금이 발생합니다.</p>
				<div class="smsInfo hide">
					<div>
						<input type="text" id="sms_hp_1" maxlength="3" style="width:60px"> -
						<input type="text" id="sms_hp_2" maxlength="4" style="width:60px"> -
						<input type="text" id="sms_hp_3" maxlength="4" style="width:60px">
						<a href="javascript:void(0)" onclick="goCommunityBoardWriteSmsInsert();"class="btn_sml"><span>등록</span></a>
						<p class="helpTxt">* SMS을 전송받을 연락처를 등록해 주세요.</p>
						<p class="helpTxt">* 최대 5명까지 입력이 가능합니다.</p>
					</div>
					<div>
						<input type="hidden" name="bi_sms_hp_list" value="">
						<select id="sms_hp_list" multiple style="width:300px;height:50px;">
						</select>
						<a href="javascript:void(0)" onclick="goCommunityBoardWriteSmsDelete();" class="btn_sml"><span>삭제</span></a>
						<p class="helpTxt">* 등록된 연락처를 선택 후 삭제할 수 있습니다.</p>
					</div>
					<div class="smsFormWrap">
						<textarea name="bi_sms_text"></textarea><p>
						<strong>0/80</strong> Byte</p>
					</div>
				</div>
			</td>
		</tr>
		<?php endif;?>
	</table>
	</form>
</div>

<br>

<div class="buttonBoxWrap">
	<a class="btn_new_blue" href="javascript:void(0);" onclick="javascript:goCommunityBoardWriteActEvent();" id="menu_auth_m"><strong class="ico_write">커뮤니티 생성</strong></a>
	<a class="btn_new_gray" href="javascript:void(0);" onclick="javascript:goCommunityBoardWriteListMoveEvent();"><strong class="ico_list">목록</strong></a>
</div>
