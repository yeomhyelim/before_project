<?php
	## 스크립트 설정 
	$aryScriptEx[] = "./common/js/community_v2.0/board/boardModifyBasic.js";
?>
<div class="contentTop">
	<h2>커뮤니티 설정 (<?php echo $strB_NAME;?>)</h2>
	<div class="clr"></div>
</div>

<br>

<div class="tabImgWrap">
<?php include MALL_HOME . "/skins/admin/community/board/basic.2.0/modify.tabMenu.skin.php" ?>
</div>

<br>

<!-- 언어 선택 탭 -->
<?php include MALL_HOME . "/web/shopAdmin/include/tab_language.inc.php";?>
<!-- 언어 선택 탭-->


<div class="tableForm">
	<form name="form" id="form">
	<input type="hidden" name="menuType" id="menuType" value="community_v2.0">
	<input type="hidden" name="mode" id="mode" value="">
	<input type="hidden" name="act" id="act" value="">
	<input type="hidden" name="b_code" id="b_code" value="<?php echo $strB_CODE;?>">
	<input type="hidden" name="lang" id="lang" value="<?php echo $strLang;?>">
	<input type="hidden" name="bi_datawrite_form" value="higheditor_full">
	<input type="hidden" name="bi_datadelete_after" value="hide">
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
				<?php echo $strB_CODE;?>
				<div class="helpTxt">
					* 코드명을 입력해 주세요. 영문,숫자만 사용가능합니다. 예) notice
				</div>
			</td>
		</tr>
		<tr>
			<th>게시판 그룹</th>
			<td>
				<select name="b_bg_no" id="b_bg_no"<?php echo $strDisabled;?>>
					<option value="-1"<?php if($intB_BG_NO == -1){echo " selected";}?>>사용안함</option>
					<?php foreach($GROUP_LIST as $key => $vel):?>
					<option value="<?php echo $key;?>"<?php if($intB_BG_NO == $key){echo " selected";}?>><?php echo $vel['bg_name'];?></option>
					<?php endforeach;?>
				</script>
			</td>
		</tr>
		<?php if(in_array($strB_KIND_SKIN, array("data_basic", "data_gallery", "data_specReview"))):?>
		<tr>
			<th>게시판종류</th>
			<td>
				<ul class="designType">
					<li>
						<img src="/shopAdmin/himg/layout/sample/board_type_data_basic.gif"/>
						<span><input type="radio" name="b_kind_skin" id="b_kind_skin" value="data_basic"<?php if($strB_KIND_SKIN=="data_basic"){ echo " checked"; }?><?php echo $strDisabled;?>/>일반게시판</span>
					</li>
					<li>
						<img src="/shopAdmin/himg/layout/sample/board_type_data_gallery.gif"/>
						<span><input type="radio" name="b_kind_skin" id="b_kind_skin" value="data_gallery"<?php if($strB_KIND_SKIN=="data_gallery"){ echo " checked"; }?><?php echo $strDisabled;?>/>갤러리형</span>
					</li>
					<li>
						<img src="/shopAdmin/himg/layout/sample/board_type_data_gallery.gif"/>
						<span><input type="radio" name="b_kind_skin" id="b_kind_skin" value="data_specReview"<?php if($strB_KIND_SKIN=="data_specReview"){ echo " checked"; }?><?php echo $strDisabled;?>/>스페셜 리뷰형</span>
					</li>
					<!-- li>
						<img src="/shopAdmin/himg/layout/sample/board_type_data_blog.gif"/>
						<span><input type="radio" name="b_kind_skin" id="b_kind_skin" value="data_blog"<?php if($strB_KIND_SKIN=="data_blog"){ echo " checked"; }?><?php echo $strDisabled;?>/>블러그형</span>
					</li //-->
				</ul>
			</td>
		</tr>
		<?php else:?>
		<input type="hidden" name="b_kind_skin" id="b_kind_skin" value="<?php echo $strB_KIND_SKIN?>"<?php echo $strDisabled;?>/>
		<?php endif;?>
		<?php if($strAdminMode):?>
		<tr>
			<th>게시판종류(상세)</th>
			<td>
				<select name="b_kind_admin" id="b_kind_admin" style="width:300px;"<?php echo $strDisabled;?>>
					<option value="data"<?php if($strB_KIND=="data"){echo " selected"; }?>>일반게시판</option>
					<option value="product"<?php if($strB_KIND=="product"){echo " selected"; }?>>상품게시판</option>
					<option value="event"<?php if($strB_KIND=="event"){echo " selected"; }?>>이벤트게시판</option>
					<option value="talk"<?php if($strB_KIND=="talk"){echo " selected"; }?>>토크게시판</option>
					<option value="mypage"<?php if($strB_KIND=="mypage"){echo " selected"; }?>>회원게시판</option>
				</select>
				<select name="b_skin_admin" id="b_skin_admin" style="width:300px;"<?php echo $strDisabled;?>>
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
				<select name="b_css" id="b_css"<?php echo $strDisabled;?>>
					<option value="basicCss1"<?php if($strB_CSS=="basicCss1"){echo " selected";}?>>기본형</option>
					<option value="basicCss2"<?php if($strB_CSS=="basicCss2"){echo " selected";}?>>그레이스킨</option>
					<option value="basicCss3"<?php if($strB_CSS=="basicCss3"){echo " selected";}?>>그린스킨</option>
				</select>
			</td>
		</tr>
		<!--
		<tr>
			<th>SNS설정</th>
			<td>
				<input type="checkbox" name="bi_dataview_facebook_use" value="Y"<?php if($strBI_DATAVIEW_FACEBOOK_USE=="Y"){echo " checked";}?><?php echo $strDisabled;?>>Facebook
				<input type="checkbox" name="bi_dataview_twitter_use"  value="Y"<?php if($strBI_DATAVIEW_TWITTER_USE=="Y"){echo " checked";}?><?php echo $strDisabled;?>>Twitter
			</td>
		</tr>
		-->
		<tr>
			<th>목록수</th>
			<td>
				<span class="listCntColumn<?php echo $strListCntColumnHide;?>"><input type="input" name="bi_column_default" value="<?php echo $intBI_COLUMN_DEFAULT;?>" class="_w50"<?php echo $strDisabled;?>/> 칸</span>
				<span class="listCntLine"><input type="input" name="bi_list_default" class="_w50" value="<?php echo $intBI_LIST_DEFAULT;?>"<?php echo $strDisabled;?>/> 라인</span>
			</td>
		</tr>
		<tr>
			<th>타이틀 표시방법</th>
			<td>
				<input type="input" name="bi_datalist_title_len" class="_w50" value="<?php echo $intBI_DATALIST_TITLE_LEN;?>"<?php echo $strDisabled;?>/>자리 표시
			</td>
		</tr>
		<tr>
			<th>목록항목</th>
			<td>
				<input type="checkbox" name="bi_datalist_field_use[0]"  value="Y" <?php if($strBI_DATALIST_FIELD_USE_0=="Y"){echo " checked";}?><?php echo $strDisabled;?>/>번호 
				<input type="checkbox" name="bi_datalist_field_use[1]"  value="Y" <?php if($strBI_DATALIST_FIELD_USE_1=="Y"){echo " checked";}?><?php echo $strDisabled;?>/>작성자
				<input type="checkbox" name="bi_datalist_field_use[2]"  value="Y" <?php if($strBI_DATALIST_FIELD_USE_2=="Y"){echo " checked";}?><?php echo $strDisabled;?>/>등록일 
				<input type="checkbox" name="bi_datalist_field_use[3]"  value="Y" <?php if($strBI_DATALIST_FIELD_USE_3=="Y"){echo " checked";}?><?php echo $strDisabled;?>/>조회수
				<input type="checkbox" name="bi_datalist_field_use[4]"  value="Y" <?php if($strBI_DATALIST_FIELD_USE_4=="Y"){echo " checked";}?><?php echo $strDisabled;?>/>점수
				<input type="checkbox" name="bi_datalist_field_use[5]"  value="Y" <?php if($strBI_DATALIST_FIELD_USE_5=="Y"){echo " checked";}?><?php echo $strDisabled;?>/>카테고리
				<input type="checkbox" name="bi_datalist_field_use[6]"  value="Y" <?php if($strBI_DATALIST_FIELD_USE_6=="Y"){echo " checked";}?><?php echo $strDisabled;?>/>리스트 이미지
				<input type="checkbox" name="bi_datalist_field_use[7]"  value="Y" <?php if($strBI_DATALIST_FIELD_USE_7=="Y"){echo " checked";}?><?php echo $strDisabled;?>/>상품 이미지
			</td>
		</tr>
		<tr>
			<th>작성자 표시방법</th>
			<td>
				<input type="checkbox" name="bi_datalist_writer_show[0]" value="Y" <?php if($strBI_DATALIST_WRITER_SHOW_0=="Y"){echo " checked";}?><?php echo $strDisabled;?>/>성명 
				<input type="checkbox" name="bi_datalist_writer_show[1]" value="Y" <?php if($strBI_DATALIST_WRITER_SHOW_1=="Y"){echo " checked";}?><?php echo $strDisabled;?>/>아이디
				<input type="checkbox" name="bi_datalist_writer_show[2]" value="Y" <?php if($strBI_DATALIST_WRITER_SHOW_2=="Y"){echo " checked";}?><?php echo $strDisabled;?>/>닉네임
				-  작성자명 <input type="input" name="bi_datalist_writer_hidden" class="_w50" value="<?php echo $intBI_DATALIST_WRITER_HIDDEN;?>"<?php echo $strDisabled;?>/>자리외 **** 표시
				<div class="helpTxt">
					* 등록한 글자수외 표시는 별표(****)로 표시됩니다. 예) 홍길***
				</div>
			</td>
		</tr>
		<tr>
			<th>리스트 정렬 설정</th>
			<td>
				<select name="bi_datalist_orderby"<?php echo $strDisabled;?>>
					<option value=""<?php if($strBI_DATALIST_ORDERBY==""){echo " selected";}?>>기본정렬</option>
					<option value="reg_dt_asc"<?php if($strBI_DATALIST_ORDERBY=="reg_dt_asc"){echo " selected";}?>>등록날짜 오름차순</option>
					<option value="reg_dt_desc"<?php if($strBI_DATALIST_ORDERBY=="reg_dt_desc"){echo " selected";}?>>등록날짜 내림차순</option>
				</select>
				<div class="helpTxt">
					* 정렬 기능 사용시 답변형 게시판을 사용 할 수 없습니다.
				</div>
			</td>
		</tr>
		<tr>
			<th>시작페이지</th>
			<td><input type="radio" name="bi_start_mode" value="dataList"<?php if($strBI_START_MODE=="dataList"){echo " checked";}?><?php echo $strDisabled;?>/>목록화면	
				<input type="radio" name="bi_start_mode" value="dataWrite"<?php if($strBI_START_MODE=="dataWrite"){echo " checked";}?><?php echo $strDisabled;?>/>글쓰기화면	
			</td>
		</tr>
		<tr>
			<th>글쓰기후이동</th>
			<td><input type="radio" name="bi_datawrite_end_move" value="dataList"<?php if($strBI_DATAWRITE_END_MOVE=="dataList"){echo " checked";}?><?php echo $strDisabled;?>/>목록화면	
				<input type="radio" name="bi_datawrite_end_move" value="dataWrite"<?php if($strBI_DATAWRITE_END_MOVE=="dataWrite"){echo " checked";}?><?php echo $strDisabled;?>/>글쓰기화면	
				<input type="radio" name="bi_datawrite_end_move" value="dataView"<?php if($strBI_DATAWRITE_END_MOVE=="dataView"){echo " checked";}?><?php echo $strDisabled;?>/>상세보기화면</td>
		</tr>
		<tr>
			<th>목록권한</th>
			<td>
				<input type="radio" name="bi_datalist_use" value="A"<?php if($strBI_DATALIST_USE=="A"){echo " checked";}?><?php echo $strDisabled;?>/>모든회원/비회원
				<input type="radio" name="bi_datalist_use" value="M"<?php if($strBI_DATALIST_USE=="M"){echo " checked";}?><?php echo $strDisabled;?>/>회원전용
				[<?php	$intCnt = 0;
						foreach($S_MEMBER_GROUP as $key => $group):

							## 기본 설정
							$strNAME = $group['NAME'];
							$strAuth = $aryBI_DATALIST_MEMBER_AUTH[$intCnt];
				 ?>
				<input type="checkbox" name="bi_datalist_member_auth[<?php echo $intCnt;?>]" value="<?php echo $key;?>"<?php if($strAuth==$key){echo " checked";}?><?php echo $strDisabled;?>/><?php echo $strNAME;?>
				<?php	$intCnt++;
						endforeach;?>]
			</td>
		</tr>
		<tr>
			<th>글보기권한</th>
			<td> 
				<input type="radio" name="bi_dataview_use" value="A"<?php if($strBI_DATAVIEW_USE=="A"){echo " checked";}?><?php echo $strDisabled;?>/>모든회원/비회원
				<input type="radio" name="bi_dataview_use" value="M"<?php if($strBI_DATAVIEW_USE=="M"){echo " checked";}?><?php echo $strDisabled;?>/>회원전용
				[<?php	$intCnt = 0;
						foreach($S_MEMBER_GROUP as $key => $group):

							## 기본 설정
							$strNAME = $group['NAME'];
							$strAuth = $aryBI_DATAVIEW_MEMBER_AUTH[$intCnt];
				 ?>
				<input type="checkbox" name="bi_dataview_member_auth[<?php echo $intCnt;?>]" value="<?php echo $key;?>"<?php if($strAuth==$key){echo " checked";}?><?php echo $strDisabled;?>/><?php echo $strNAME;?>
				<?php	$intCnt++;
						endforeach;?>]
			</td>
		</tr>
		<tr>
			<th>글쓰기권한</th>
			<td>
				<input type="radio" name="bi_datawrite_use" value="A"<?php if($strBI_DATAWRITE_USE=="A"){echo " checked";}?><?php echo $strDisabled;?>/>모든회원/비회원
				<input type="radio" name="bi_datawrite_use" value="M"<?php if($strBI_DATAWRITE_USE=="M"){echo " checked";}?><?php echo $strDisabled;?>/>회원전용
				[<?php	$intCnt = 0;
						foreach($S_MEMBER_GROUP as $key => $group):

							## 기본 설정
							$strNAME = $group['NAME'];
							$strAuth = $aryBI_DATAWRITE_MEMBER_AUTH[$intCnt];
				 ?>
				<input type="checkbox" name="bi_datawrite_member_auth[<?php echo $intCnt;?>]" value="<?php echo $key;?>"<?php if($strAuth==$key){echo " checked";}?><?php echo $strDisabled;?>/><?php echo $strNAME;?>
				<?php	$intCnt++;
						endforeach;?>]
			</td>
		</tr>
		<tr>
			<th>답변권한</th>
			<td>
				<input type="radio" name="bi_dataanswer_use" value="A"<?php if($strBI_DATAANSWER_USE=="A"){echo " checked";}?><?php echo $strDisabled;?>/>모든회원/비회원
				<input type="radio" name="bi_dataanswer_use" value="M"<?php if($strBI_DATAANSWER_USE=="M"){echo " checked";}?><?php echo $strDisabled;?>/>회원전용
				[<?php	$intCnt = 0;
						foreach($S_MEMBER_GROUP as $key => $group):

							## 기본 설정
							$strNAME = $group['NAME'];
							$strAuth = $aryBI_DATAANSWER_MEMBER_AUTH[$intCnt];
				 ?>
				<input type="checkbox" name="bi_dataanswer_member_auth[<?php echo $intCnt;?>]" value="<?php echo $key;?>"<?php if($strAuth==$key){echo " checked";}?><?php echo $strDisabled;?>/><?php echo $strNAME;?>
				<?php	$intCnt++;
						endforeach;?>]
				<input type="radio" name="bi_dataanswer_use" value="N"<?php if($strBI_DATAANSWER_USE=="N"){echo " checked";}?>/>사용안함
			</td>
		</tr>
		<tr>
			<th>댓글권한</th><!-- 코멘트 기능을 말함. -->
			<td>
				<input type="radio" name="bi_comment_use" value="A"<?php if($strBI_COMMENT_USE=="A"){echo " checked";}?><?php echo $strDisabled;?>/>모든회원/비회원
				<input type="radio" name="bi_comment_use" value="M"<?php if($strBI_COMMENT_USE=="M"){echo " checked";}?><?php echo $strDisabled;?>/>회원전용
				[<?php	$intCnt = 0;
						foreach($S_MEMBER_GROUP as $key => $group):

							## 기본 설정
							$strNAME = $group['NAME'];
							$strAuth = $aryBI_COMMENT_MEMBER_AUTH[$intCnt];
				 ?>
				<input type="checkbox" name="bi_comment_member_auth[<?php echo $intCnt;?>]" value="<?php echo $key;?>"<?php if($strAuth==$key){echo " checked";}?><?php echo $strDisabled;?>/><?php echo $strNAME;?>
				<?php	$intCnt++;
						endforeach;?>]
				<input type="radio" name="bi_comment_use" value="N"<?php if($strBI_COMMENT_USE=="N"){echo " checked";}?><?php echo $strDisabled;?>/>사용안함
			</td>
		</tr>
		<tr>
			<th>글보기 네비게이션</th>
			<td>
				<input type="checkbox" name="bi_dataview_nextprve_use" value="Y"<?php if($strBI_DATAVIEW_NEXTPRVE_USE=="Y"){echo " checked";}?><?php echo $strDisabled;?>> 이전/다음 사용
			</td>
		</tr>
		<tr>
			<th>비밀글기능</th>
			<td>
				<input type="radio" name="bi_datawrite_lock_use" value="C"<?php if($strBI_DATAWRITE_LOCK_USE=="C"){echo " checked";}?><?php echo $strDisabled;?>> 사용(사용자 선택)
				<input type="radio" name="bi_datawrite_lock_use" value="E"<?php if($strBI_DATAWRITE_LOCK_USE=="E"){echo " checked";}?><?php echo $strDisabled;?>> 사용(무조건)
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
				<input type="radio" name="bi_admin_main_show" value="N"<?php if($strBI_ADMIN_MAIN_SHOW=="N"){echo " checked";}?><?php echo $strDisabled;?>> 표시 안함
				<input type="radio" name="bi_admin_main_show" value="Y"<?php if($strBI_ADMIN_MAIN_SHOW=="Y"){echo " checked";}?><?php echo $strDisabled;?>> 표시함
				(순위 : <input type="text"  name="bi_admin_main_sort" value="<?php echo $intBI_ADMIN_MAIN_SORT;?>">)
			</td>
		</tr>
		<!-- tr><?php // 2015.01.16 kim hee sung 사용안함?>
			<th>삭제글설정</th>
			<td>
				<input type="radio" name="bi_datadelete_after" value="hide"<?php if($strBI_DATADELETE_AFTER=="hide"){echo " checked";}?><?php echo $strDisabled;?>> 삭제후 숨김
				<input type="radio" name="bi_datadelete_after" value="text"<?php if($strBI_DATADELETE_AFTER=="text"){echo " checked";}?><?php echo $strDisabled;?>> 삭제후 알림
			</td>
		</tr //-->
		<tr>
			<th>첨부파일</th>
			<td>
				<select name="bi_attachedfile_use" id="bi_attachedfile_use"<?php echo $strDisabled;?>>
					<option value="0"<?php if($intBI_ATTACHEDFILE_USE==0){echo " selected";}?>>사용안함</option>
					<option value="1"<?php if($intBI_ATTACHEDFILE_USE==1){echo " selected";}?>>1개</option>
					<option value="2"<?php if($intBI_ATTACHEDFILE_USE==2){echo " selected";}?>>2개</option>
					<option value="3"<?php if($intBI_ATTACHEDFILE_USE==3){echo " selected";}?>>3개</option>
					<option value="4"<?php if($intBI_ATTACHEDFILE_USE==4){echo " selected";}?>>4개</option>
					<option value="5"<?php if($intBI_ATTACHEDFILE_USE==5){echo " selected";}?>>5개</option>
				</select>
			</td>
		</tr>
		<?php for($i=0;$i<5;$i++):?>
		<tr id="attachedfile_name_field" style="<?php if($intBI_ATTACHEDFILE_USE<=$i){echo "display:none";}?>">
			<th>첨부파일<?php echo ($i+1);?> 이름</th>
			<td>
				<input type="text" name="bi_attachedfile_name[<?php echo $i;?>]" id="" value="<?php echo $aryBI_ATTACHEDFILE_NAME[$i];?>" style="width:200px" />
			</td>
		</tr>
		<tr id="attachedfile_key_field" style="<?php if($intBI_ATTACHEDFILE_USE<=$i){echo "display:none";}?>">
			<th>첨부파일<?php echo ($i+1);?> 형식</th>
			<td>
				<select name="bi_attachedfile_key[<?php echo $i;?>]" id="" style="width:200px"<?php echo $strDisabled;?>>
					<option value="file"<?php if($aryBI_ATTACHEDFILE_KEY[$i]=="file"){echo " selected";}?>>첨부파일</option>
					<option value="listImage"<?php if($aryBI_ATTACHEDFILE_KEY[$i]=="listImage"){echo " selected";}?>>리스트이미지</option>
					<!-- option value="bigImage"<?php if($aryBI_ATTACHEDFILE_KEY[$i]=="bigImage"){echo " selected";}?>>큰이미지</option //-->
					<option value="image"<?php if($aryBI_ATTACHEDFILE_KEY[$i]=="image"){echo " selected";}?>>이미지</option>
					<!-- option value="movie"<?php if($aryBI_ATTACHEDFILE_KEY[$i]=="movie"){echo " selected";}?>>동영상</option //-->
				</select>
				<p class="attachedText hide">* 리스트 이미지를 선택하시면 목록에 이미지가 보여지는 게시판입니다.</p>
			</td>
		</tr>
		<?php endfor;?>

	</table>
	</form>
</div>

<br>

<div class="buttonBoxWrap">
	<a class="btn_new_blue" href="javascript:void(0);" onclick="javascript:goCommunityBoardModifyBasicModifyActEvent();" id="menu_auth_m"><strong class="ico_write">설정 변경</strong></a>
	<a class="btn_new_gray" href="javascript:void(0);" onclick="javascript:goCommunityBoardModifyBasicListMoveEvent();"><strong class="ico_list">목록</strong></a>
</div>
