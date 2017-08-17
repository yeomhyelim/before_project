
	<table>
		<tr>
			<th>게시판명</th>
			<td>
				<input type="text" id="b_name" name="b_name" value="<?=$boardSelectRow['B_NAME']?>"/>
				<div class="helpTxt">
					* 만들고자 하는 게시판의 이름을 등록해 주세요. 예) 공지사항
				</div>
			</td>
		</tr>
		<tr>
			<th>게시판코드</th>
			<td>
				<input type="text" id="b_code" name="b_code" value="<?=$boardSelectRow['B_CODE']?>" readOnly/>
				<div class="helpTxt">
					* 코드명을 입력해 주세요. 영문,숫자만 사용가능합니다. 예) notice
				</div>
			</td>
		</tr>
		<tr>
			<th>게시판 그룹</th>
			<td>
				<?include_once "{$_REQUEST['S_DOCUMENT_ROOT']}{$_REQUEST['S_SHOP_HOME']}/conf/community/groupList.info.php";?>
				<select name="b_bg_no" id="b_bg_no">
					<option value="-1"<?if($boardSelectRow['B_BG_NO']=="-1"){echo " selected";}?>>사용안함</option>
					<? foreach($GROUP_LIST as $key => $vel): ?>
					<option value="<?=$key?>"<?if($boardSelectRow['B_BG_NO']==$key){echo " selected";}?>><?=$vel['bg_name']?></option>
					<? endforeach; ?>
				</script>
			</td>
		</tr>
		<? $b_kind_skin = "{$boardSelectRow['B_KIND']}_{$boardSelectRow['B_SKIN']}"; ?>
		<?if(in_array($b_kind_skin, array("data_basic", "data_gallery", "data_blog", "data_consult", "event_line", "talk_comment", "data_faq"))):?>
		<tr>
			<th>게시판종류</th>
			<td>
				<ul class="designType">
					<li>
						<img src="/shopAdmin/himg/layout/sample/board_type_data_basic.gif"/>
						<span><input type="radio" name="b_kind_skin" id="b_kind_skin" value="data_basic"<?if($boardSelectRow['B_KIND']!="data"){echo " disabled";} ?><?if($b_kind_skin=="data_basic"){ echo " checked"; }?>/>일반게시판</span>
					</li>
					<li>
						<img src="/shopAdmin/himg/layout/sample/board_type_data_gallery.gif"/>
						<span><input type="radio" name="b_kind_skin" id="b_kind_skin" value="data_gallery"<?if($boardSelectRow['B_KIND']!="data"){echo " disabled";} ?><?if($b_kind_skin=="data_gallery"){ echo " checked"; }?>/>갤러리형</span>
					</li>
					<li>
						<img src="/shopAdmin/himg/layout/sample/board_type_event_line.gif"/>
						<span><input type="radio" name="b_kind_skin" id="b_kind_skin" value="event_line"<?if($boardSelectRow['B_KIND']!="event"){echo " disabled";} ?><?if($b_kind_skin=="event_line"){ echo " checked"; }?>/>이벤트게시판</span>
					</li>
					<li>
						<img src="/shopAdmin/himg/layout/sample/board_type_data_blog.gif"/>
						<span><input type="radio" name="b_kind_skin" id="b_kind_skin" value="data_blog"<?if($boardSelectRow['B_KIND']!="data"){echo " disabled";} ?><?if($b_kind_skin=="data_blog"){ echo " checked"; }?>/>블러그형</span>
					</li>
					<li>
						<img src="/shopAdmin/himg/layout/sample/board_type_talk_comment.gif"/>
						<span><input type="radio" name="b_kind_skin" id="b_kind_skin" value="talk_comment"<?if($boardSelectRow['B_KIND']!="talk"){echo " disabled";} ?><?if($b_kind_skin=="talk_comment"){ echo " checked"; }?>/>토크(Talk)게시판</span>
					</li>
					<!--li>
						<img src="/shopAdmin/himg/layout/sample/board_type_data_basic.gif"/>
						<span><input type="radio" name="b_kind_skin" id="b_kind_skin" value="data_basic"<?if($boardSelectRow['B_KIND']!="data"){echo " disabled";} ?><?if($b_kind_skin=="data_basic"){ echo " checked"; }?>/>일반게시판</span>
					</li>
					<li>
						<img src="/shopAdmin/himg/layout/sample/board_type_data_gallery.gif"/>
						<span><input type="radio" name="b_kind_skin" id="b_kind_skin" value="data_gallery"<?if($boardSelectRow['B_KIND']!="data"){echo " disabled";} ?><?if($b_kind_skin=="data_gallery"){ echo " checked"; }?>/>갤러리형</span>
					</li>
					<li>
						<img src="/shopAdmin/himg/layout/sample/board_type_data_blog.gif"/>
						<span><input type="radio" name="b_kind_skin" id="b_kind_skin" value="data_blog"<?if($boardSelectRow['B_KIND']!="data"){echo " disabled";} ?><?if($b_kind_skin=="data_blog"){ echo " checked"; }?>/>블러그형</span>
					</li>
					<li>
						<img src="/shopAdmin/himg/layout/sample/board_type_data_consult.gif"/>
						<span><input type="radio" name="b_kind_skin" id="b_kind_skin" value="data_consult"<?if($boardSelectRow['B_KIND']!="data"){echo " disabled";} ?><?if($b_kind_skin=="data_consult"){ echo " checked"; }?>/>상담게시판</span>
					</li>
					<li>
						<img src="/shopAdmin/himg/layout/sample/board_type_event_line.gif"/>
						<span><input type="radio" name="b_kind_skin" id="b_kind_skin" value="event_line"<?if($boardSelectRow['B_KIND']!="event"){echo " disabled";} ?><?if($b_kind_skin=="event_line"){ echo " checked"; }?>/>이벤트게시판</span>
					</li>
					<li>
						<img src="/shopAdmin/himg/layout/sample/board_type_talk_comment.gif"/>
						<span><input type="radio" name="b_kind_skin" id="b_kind_skin" value="talk_comment"<?if($boardSelectRow['B_KIND']!="talk"){echo " disabled";} ?><?if($b_kind_skin=="talk_comment"){ echo " checked"; }?>/>토크(Talk)게시판</span>
					</li>
					<li>
						<img src="/shopAdmin/himg/layout/sample/board_type_data_basic.gif"/>
						<span><input type="radio" name="b_kind_skin" id="b_kind_skin" value="data_faq"<?if($boardSelectRow['B_KIND']!="data"){echo " disabled";} ?><?if($b_kind_skin=="data_faq"){ echo " checked"; }?>/>FAQ형게시판</span>
					</li-->
				</ul>
			</td>
		</tr>
		<?else:?>
		<input type="hidden" name="b_kind_skin" id="b_kind_skin" value="<?=$b_kind_skin?>"/>
		<?endif;?>
		<?if($_REQUEST['admin_mode']):?>
		<tr>
			<th>게시판종류(상세)</th>
			<td>
				<select name="b_kind_admin" id="b_kind_admin" style="width:300px;">
					<option value="data"<?if($boardSelectRow['B_KIND']=="data"){echo " selected"; }?>>일반게시판</option>
					<option value="product"<?if($boardSelectRow['B_KIND']=="product"){echo " selected"; }?>>상품게시판</option>
					<option value="event"<?if($boardSelectRow['B_KIND']=="event"){echo " selected"; }?>>이벤트게시판</option>
					<option value="talk"<?if($boardSelectRow['B_KIND']=="talk"){echo " selected"; }?>>토크게시판</option>
					<option value="mypage"<?if($boardSelectRow['B_KIND']=="mypage"){echo " selected"; }?>>회원게시판</option>
				</select>
				<select name="b_skin_admin" id="b_skin_admin" style="width:300px;">
					<option value="basic"<?if($boardSelectRow['B_SKIN']=="basic"){echo " selected"; }?>>basic</option>
					<option value="gallery"<?if($boardSelectRow['B_SKIN']=="gallery"){echo " selected"; }?>>gallery</option>
					<option value="line"<?if($boardSelectRow['B_SKIN']=="line"){echo " selected"; }?>>line</option>
					<option value="comment"<?if($boardSelectRow['B_SKIN']=="comment"){echo " selected"; }?>>comment</option>
					<option value="blog"<?if($boardSelectRow['B_SKIN']=="blog"){echo " selected"; }?>>blog</option>
					<option value="answer"<?if($boardSelectRow['B_SKIN']=="answer"){echo " selected"; }?>>answer</option>
					<option value="user"<?if($boardSelectRow['B_SKIN']=="user"){echo " selected"; }?>>user</option>
					<option value="review"<?if($boardSelectRow['B_SKIN']=="review"){echo " selected"; }?>>product_review</option>
					<option value="qna"<?if($boardSelectRow['B_SKIN']=="qna"){echo " selected"; }?>>product_qna</option>
					<option value="qna"<?if($boardSelectRow['B_SKIN']=="qna"){echo " selected"; }?>>mypage_qna</option>
				</select>
				<input type="hidden" name="admin_mode" id="admin_mode" value="1"/>
			</td>
		</tr>
		<?endif;?>
		<tr>
			<th>스킨설정</th>
			<td>
				<select name="b_css" id="b_css">
					<option value="basicCss1"<?if($boardSelectRow['B_CSS']=="basicCss1"){echo " selected";}?>>기본형</option>
					<option value="basicCss2"<?if($boardSelectRow['B_CSS']=="basicCss2"){echo " selected";}?>>그레이스킨</option>
					<option value="basicCss3"<?if($boardSelectRow['B_CSS']=="basicCss3"){echo " selected";}?>>그린스킨</option>
				</select>
			</td>
		</tr>
		<tr>
			<th>SNS설정</th>
			<td>
				<input type="checkbox" name="bi_dataview_facebook_use" value="Y"<?if($boardInfoAry['BI_DATAVIEW_FACEBOOK_USE']=="Y"){echo " checked";}?>>Facebook
				<input type="checkbox" name="bi_dataview_twitter_use"  value="Y"<?if($boardInfoAry['BI_DATAVIEW_TWITTER_USE']=="Y"){echo " checked";}?>>Twitter
				<input type="checkbox" name="bi_dataview_m2day_use"    value="Y"<?if($boardInfoAry['BI_DATAVIEW_M2DAY_USE']=="Y"){echo " checked";}?>>M2day
			</td>
		</tr>
		<tr>
			<th>목록수</th>
			<td>
				<!-- 갤러리인 경우보여짐 <input type="input" name="bi_column_default" value='<?=$boardInfoAry['BI_COLUMN_DEFAULT']?>" class="_w50"/> 칸 -->
				<input type="input" name="bi_column_default" value="<?=$boardInfoAry['BI_COLUMN_DEFAULT']?>" class="_w50"/> 칸
				<input type="input" name="bi_list_default" class="_w50" value="<?=$boardInfoAry['BI_LIST_DEFAULT']?>"/> 라인
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
			</td>
		</tr>
		<tr>
			<th>작성자 표시방법</th>
			<td>
				<input type="checkbox" name="bi_datalist_writer_show[0]" value="Y" <?if($boardInfoAry['BI_DATALIST_WRITER_SHOW_0']=="Y"){echo " checked";}?>/>성명 
				<input type="checkbox" name="bi_datalist_writer_show[1]" value="Y" <?if($boardInfoAry['BI_DATALIST_WRITER_SHOW_1']=="Y"){echo " checked";}?>/>아이디 
				-  작성자명 <input type="input" name="bi_datalist_writer_hidden" class="_w50" value="<?=$boardInfoAry['BI_DATALIST_WRITER_HIDDEN']?>"/>자리외 **** 표시
				<div class="helpTxt">
					* 등록한 글자수외 표시는 별표(****)로 표시됩니다. 예) 홍길***
				</div>
			</td>
		</tr>
		<tr>
			<th>시작페이지</th>
			<td><input type="radio" name="bi_start_mode" value="dataList"<?if($boardInfoAry['BI_START_MODE']=="dataList"){echo " checked";}?>/>목록화면	
				<input type="radio" name="bi_start_mode" value="dataWrite"<?if($boardInfoAry['BI_START_MODE']=="dataWrite"){echo " checked";}?>/>글쓰기화면	
				<input type="radio" name="bi_start_mode" value="dataView"<?if($boardInfoAry['BI_START_MODE']=="dataView"){echo " checked";}?>/>상세보기화면</td>
		</tr>
		<tr>
			<th>글쓰기후이동</th>
			<td><input type="radio" name="bi_datawrite_end_move" value="dataList"<?if($boardInfoAry['BI_DATAWRITE_END_MOVE']=="dataList"){echo " checked";}?>/>목록화면	
				<input type="radio" name="bi_datawrite_end_move" value="dataWrite"<?if($boardInfoAry['BI_DATAWRITE_END_MOVE']=="dataWrite"){echo " checked";}?>/>글쓰기화면	
				<input type="radio" name="bi_datawrite_end_move" value="dataView"<?if($boardInfoAry['BI_DATAWRITE_END_MOVE']=="dataView"){echo " checked";}?>/>상세보기화면</td>
		</tr>
		<!-- tr>
			<th>목록 옵션</th>
			<td><input type="radio"/>	<input type="radio"/>	<input type="radio"/></td>
		</tr -->
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
			<th>비밀글기능</th>
			<td>
				<input type="checkbox" name="bi_datawrite_lock_use" value="C"<?if($boardInfoAry['BI_DATAWRITE_LOCK_USE']=="C"){echo " checked";}?>> 비밀글 사용
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
					<option value="file"<?if($boardInfoAry["BI_ATTACHEDFILE_KEY_{$i}"]=="file"){echo " selected";}?>>설정없음</option>
					<option value="listImage"<?if($boardInfoAry["BI_ATTACHEDFILE_KEY_{$i}"]=="listImage"){echo " selected";}?>>리스트이미지</option>
					<option value="bigImage"<?if($boardInfoAry["BI_ATTACHEDFILE_KEY_{$i}"]=="bigImage"){echo " selected";}?>>큰이미지</option>
					<option value="image"<?if($boardInfoAry["BI_ATTACHEDFILE_KEY_{$i}"]=="image"){echo " selected";}?>>이미지</option>
					<option value="movie"<?if($boardInfoAry["BI_ATTACHEDFILE_KEY_{$i}"]=="movie"){echo " selected";}?>>동영상</option>
				</select>
			</td>
		</tr>
		<?endfor;?>
	</table>

	<input type="hidden" name="b_use" id="b_use" value="<?=$boardSelectRow['B_USE']?>"/>