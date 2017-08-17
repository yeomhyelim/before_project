	<table>
		<tr>
			<th>게시판명</th>
			<td>
				<input type="text" id="b_name" name="b_name" alt="게시판명" check="write"/>
				<div class="helpTxt">
					* 만들고자 하는 게시판의 이름을 등록해 주세요. 예) 공지사항
				</div>
			</td>
		</tr>
		<tr>
			<th>게시판코드</th>
			<td>
				<input type="text" id="b_code" name="b_code" alt="게시판코드" check="write"/>
				<div class="helpTxt">
					* 코드명을 입력해 주세요. 영문,숫자만 사용가능합니다. 예) notice
				</div>
			</td>
		</tr>
		<tr>
			<th>게시판 그룹</th>
			<td>
				<select name="b_bg_no" id="b_bg_no">
					<option value="-1">사용안함</option>
					<? foreach($groupList2 as $key => $vel): ?>
					<option value="<?=$key?>"><?=$vel?></option>
					<? endforeach; ?>
				</script>
			</td>
		</tr>
		<?if(!$_REQUEST['admin_mode']):?>
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
					<li>
						<img src="/shopAdmin/himg/layout/sample/board_type_data_blog.gif"/>
						<span><input type="radio" name="b_kind_skin" id="b_kind_skin" value="data_blog"/>블러그형</span>
					</li>
					<li>
						<img src="/shopAdmin/himg/layout/sample/board_type_data_consult.gif"/>
						<span><input type="radio" name="b_kind_skin" id="b_kind_skin" value="data_consult"/>상담게시판</span>
					</li>
					<li>
						<img src="/shopAdmin/himg/layout/sample/board_type_event_line.gif"/>
						<span><input type="radio" name="b_kind_skin" id="b_kind_skin" value="event_line"/>이벤트게시판</span>
					</li>
					<li>
						<img src="/shopAdmin/himg/layout/sample/board_type_talk_comment.gif"/>
						<span><input type="radio" name="b_kind_skin" id="b_kind_skin" value="talk_comment"/>토크(Talk)게시판</span>
					</li>
					<li>
						<img src="/shopAdmin/himg/layout/sample/board_type_data_basic.gif"/>
						<span><input type="radio" name="b_kind_skin" id="b_kind_skin" value="data_faq"/>FAQ형게시판</span>
					</li>
				</ul>
			</td>
		</tr>
		<?else:?>
		<tr>
			<th>게시판종류(상세)</th>
			<td>
				<select name="b_kind_admin" id="b_kind_admin" style="width:300px;">
					<option value="data">일반게시판</option>
					<option value="product">상품게시판</option>
					<option value="event">이벤트게시판</option>
					<option value="talk">토크게시판</option>
					<option value="mypage">회원게시판</option>
				</select>
				<select name="b_skin_admin" id="b_skin_admin" style="width:300px;">
					<option value="basic">basic</option>
					<option value="gallery">gallery</option>
					<option value="line">line</option>
					<option value="comment">comment</option>
					<option value="blog">blog</option>
					<option value="answer">answer</option>
					<option value="user">user</option>
					<option value="review">product_review</option>
					<option value="qna">product_qna</option>
					<option value="qna">mypage_qna</option>
				</select>
				<input type="hidden" name="admin_mode" id="admin_mode" value="1"/>
			</td>
		</tr>
		<?endif;?>
		<tr>
			<th>스킨설정</th>
			<td>
				<select name="b_css" id="b_css">
					<option value="basicCss1" selected>기본형</option>
					<option value="basicCss2">그레이스킨</option>
					<option value="basicCss3">그린스킨</option>
				</select>
			</td>
		</tr>
		<tr>
			<th>SNS설정</th>
			<td>
				<input type="checkbox" name="bi_dataview_facebook_use"  value="Y">Facebook
				<input type="checkbox" name="bi_dataview_twitter_use"  value="Y">Twitter
				<input type="checkbox" name="bi_dataview_m2day_use"  value="Y">M2day
			</td>
		</tr>
		<tr>
			<th>목록수</th>
			<td>
				<!-- 갤러리인 경우보여짐 <input type="input" name="bi_column_default" class="_w50"/> 칸 -->
				<input type="input" name="bi_list_default" class="_w50" value="10"/> 라인
			</td>
		</tr>
		<tr>
			<th>타이틀 표시방법</th>
			<td>
				<input type="input" name="bi_datalist_title_len" class="_w50" value=""/>자리 표시
			</td>
		</tr>
		<tr>
			<th>목록항목</th>
			<td>
				<input type="checkbox" name="bi_datalist_field_use[0]"  value="Y" checked/>번호 
				<input type="checkbox" name="bi_datalist_field_use[1]"  value="Y" checked/>작성자 
				<input type="checkbox" name="bi_datalist_field_use[2]"  value="Y" checked/>등록일 
				<input type="checkbox" name="bi_datalist_field_use[3]"  value="Y" checked/>조회수
				<input type="checkbox" name="bi_datalist_field_use[4]"  value="Y" checked/>점수
			</td>
		</tr>
		<tr>
			<th>작성자 표시방법</th>
			<td>
				<input type="checkbox" name="bi_datalist_writer_show[0]" value="Y" checked/>성명 
				<input type="checkbox" name="bi_datalist_writer_show[1]" value="Y" checked/>아이디 
				-  작성자명 <input type="input" name="bi_datalist_writer_hidden" class="_w50"/>자리외 **** 표시
				<div class="helpTxt">
					* 등록한 글자수외 표시는 별표(****)로 표시됩니다. 예) 홍길***
				</div>
			</td>
		</tr>
		<tr>
			<th>시작페이지</th>
			<td><input type="radio" name="bi_start_mode" value="dataList" checked/>목록화면	
				<input type="radio" name="bi_start_mode" value="dataWrite"/>글쓰기화면	
				<input type="radio" name="bi_start_mode" value="dataView"/>상세보기화면</td>
		</tr>
		<tr>
			<th>글쓰기후이동</th>
			<td><input type="radio" name="bi_datawrite_end_move" value="dataList" checked/>목록화면	
				<input type="radio" name="bi_datawrite_end_move" value="dataWrite"/>글쓰기화면	
				<input type="radio" name="bi_datawrite_end_move" value="dataView"/>상세보기화면</td>
		</tr>
		<!-- tr>
			<th>목록 옵션</th>
			<td><input type="radio"/>	<input type="radio"/>	<input type="radio"/></td>
		</tr -->
		<tr>
			<th>목록권한</th>
			<td>
				<input type="radio" name="bi_datalist_use" value="A" checked/>모든회원/비회원
				<input type="radio" name="bi_datalist_use" value="M"/>회원전용
			   [<input type="checkbox" name="bi_datalist_member_auth[0]" value="Y"/>일반회원 
				<input type="checkbox" name="bi_datalist_member_auth[1]" value="Y"/>관리자회원 
				<input type="checkbox" name="bi_datalist_member_auth[2]" value="Y"/>공급사회원]
			</td>
		</tr>
		<tr>
			<th>글보기권한</th>
			<td> 
				<input type="radio" name="bi_dataview_use" value="A" checked/>모든회원/비회원
				<input type="radio" name="bi_dataview_use" value="M"/>회원전용
			   [<input type="checkbox" name="bi_dataview_member_auth[0]" value="Y"/>일반회원 
				<input type="checkbox" name="bi_dataview_member_auth[1]" value="Y"/>관리자회원 
				<input type="checkbox" name="bi_dataview_member_auth[2]" value="Y"/>공급사회원]
			</td>
		</tr>
		<tr>
			<th>글쓰기권한</th>
			<td>
				<input type="radio" name="bi_datawrite_use" value="A"/>모든회원/비회원
				<input type="radio" name="bi_datawrite_use" value="M" checked/>회원전용
			   [<input type="checkbox" name="bi_datawrite_member_auth[0]" value="Y" checked/>일반회원 
				<input type="checkbox" name="bi_datawrite_member_auth[1]" value="Y" checked/>관리자회원 
				<input type="checkbox" name="bi_datawrite_member_auth[2]" value="Y"/>공급사회원]
			</td>
		</tr>
		<tr>
			<th>답변권한</th>
			<td>
				<input type="radio" name="bi_dataanswer_use" value="A"/>모든회원/비회원
				<input type="radio" name="bi_dataanswer_use" value="M" checked/>회원전용
			   [<input type="checkbox" name="bi_dataanswer_member_auth[0]" value="Y" checked/>일반회원 
				<input type="checkbox" name="bi_dataanswer_member_auth[1]" value="Y" checked/>관리자회원 
				<input type="checkbox" name="bi_dataanswer_member_auth[2]" value="Y"/>공급사회원]
				<input type="radio" name="bi_dataanswer_use" value="N"/>사용안함
			</td>
		</tr>
		<tr>
			<th>댓글기능</th><!-- 코멘트 기능을 말함. -->
			<td>
				<input type="radio" name="bi_comment_use" value="A"/>모든회원/비회원
				<input type="radio" name="bi_comment_use" value="M"/>회원전용
			   [<input type="checkbox" name="bi_comment_member_auth[0]" value="Y"/>일반회원 
				<input type="checkbox" name="bi_comment_member_auth[1]" value="Y"/>관리자회원 
				<input type="checkbox" name="bi_comment_member_auth[2]" value="Y"/>공급사회원]
				<input type="radio" name="bi_comment_use" value="N" checked/>사용안함
			</td>
		</tr>
		<tr>
			<th>비밀글기능</th>
			<td>
				<input type="checkbox" name="bi_datawrite_lock_use" value="C"> 비밀글 사용
			</td>
		</tr>
		<tr>
			<th>에디터사용</th>
			<td>
				<input type="radio" name="bi_datawrite_form" value="textWrite" checked> 텍스트 글쓰기
				<input type="radio" name="bi_datawrite_form" value="higheditor_full"> 에디터 글쓰기
			</td>
		</tr>
		<tr>
			<th>첨부파일</th>
			<td>
				<select name="bi_attachedfile_use" id="bi_attachedfile_use">
					<option value="0">사용안함</option>
					<option value="1">1개</option>
					<option value="2">2개</option>
					<option value="3">3개</option>
					<option value="4">4개</option>
					<option value="5">5개</option>
				</select>
			</td>
		</tr>
		<?for($i=0;$i<5;$i++):?>
		<tr id="attachedfile_name_field" style="display:none">
			<th>첨부파일<?=$i+1?> 이름</th>
			<td>
				<input type="text" name="bi_attachedfile_name[<?=$i?>]" id="" value="<?=$boardInfoAry["BI_ATTACHEDFILE_NAME_{$i}"]?>" style="width:200px" />
			</td>
		</tr>
		<tr id="attachedfile_key_field" style="display:none">
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