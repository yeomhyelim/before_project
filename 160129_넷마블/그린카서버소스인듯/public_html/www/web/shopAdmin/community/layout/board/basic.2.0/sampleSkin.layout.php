<div id="contentArea">
	<div class="contentTop">
		<h2>커뮤니티 추가</h2>
		<div class="clr"></div>
	</div>
</div>


<div class="tableForm mt20">
	<div class="tabImgWrap">
		<a href="javascript:goBoardModifyBasicMove()">기본설정</a>	
		<a href="javascript:goBoardModifyScriptMove()">카테고리설정</a>	
		<a href="javascript:goBoardModifyScriptMove()">포인트/쿠폰 설정</a>
		<a href="javascript:goBoardModifyCategoryMove()">추가필드</a>	
		<a href="javascript:goBoardModifyListMove()">HTML편집</a>	
	</div>
	<table>
		<tr>
			<th>게시판명</th>
			<td>
				<input type="inpyt" name="">
				<div class="helpTxt">
					* 만들고자 하는 게시판의 이름을 등록해 주세요. 예) 공지사항
				</div>
			</td>
		</tr>
		<tr>
			<th>게시판코드</th>
			<td>
				<input type="inpyt" name="">
				<div class="helpTxt">
					* 코드명을 입력해 주세요. 영문,숫자만 사용가능합니다. 예) notice
				</div>
			</td>
		</tr>
		<tr>
			<th>게시판 그룹</th>
			<td>
				<select>
					<option></option>
				</select>
			</td>
		</tr>
		<tr>
			<th>게시판종류</th>
			<td>
				<ul class="designType">
					<li>
						<img src="/shopAdmin/himg/layout/sample/board_type_1.gif"/>
						<span><input type="radio" name=""/>일반게시판</span>
					</li>
					<li>
						<img src="/shopAdmin/himg/layout/sample/board_type_2.gif"/>
						<span><input type="radio" name=""/>갤러리형</span>
					</li>
					<li>
						<img src="/shopAdmin/himg/layout/sample/board_type_3.gif"/>
						<span><input type="radio" name=""/>블러그형</span>
					</li>
					<li>
						<img src="/shopAdmin/himg/layout/sample/board_type_4.gif"/>
						<span><input type="radio" name=""/>상담게시판</span>
					</li>
					<li>
						<img src="/shopAdmin/himg/layout/sample/board_type_5.gif"/>
						<span><input type="radio" name=""/>이벤트게시판</span>
					</li>
					<li>
						<img src="/shopAdmin/himg/layout/sample/board_type_6.gif"/>
						<span><input type="radio" name=""/>토크(Talk)게시판</span>
					</li>
				</ul>
			</td>
		</tr>
		<tr>
			<th>스킨설정</th>
			<td>
				<select>
					<option>기본형</option>
					<option>그레이스킨</option>
				</select>
			</td>
		</tr>
		<tr>
			<th>SNS설정</th>
			<td>
				<input type="checkbox"/>Facebook
				<input type="checkbox"/>Twitter
				<input type="checkbox"/>M2day
			</td>
		</tr>
		<tr>
			<th>목록수</th>
			<td>
				<!-- 갤러리인 경우보여짐 <input type="input" name="" class="_w50"/> 칸 -->
				<input type="input" name="" class="_w50"/> 라인
			</td>
		</tr>
		<tr>
			<th>목록항목</th>
			<td>
				<input type="checkbox" checked/>번호 <input type="checkbox"checked/>작성자 <input type="checkbox"checked/>등록일 <input type="checkbox"checked/>조회수
			</td>
		</tr>
		<tr>
			<th>작성자 표시방법</th>
			<td>
				<input type="checkbox" checked/>성명 <input type="checkbox"checked/>아이디 
				-  작성자명 <input type="input" class="_w50"/>자리외 **** 표시
				<div class="helpTxt">
					* 등록한 글자수외 표시는 별표(****)로 표시됩니다. 예) 홍길***
				</div>
			</td>
		</tr>
		<tr>
			<th>시작페이지</th>
			<td><input type="radio"/>목록화면	<input type="radio"/>글쓰기화면	<input type="radio"/>상세보기화면</td>
		</tr>
		<tr>
			<th>글쓰기후이동</th>
			<td><input type="radio"/>목록화면	<input type="radio"/>글쓰기화면	<input type="radio"/>상세보기화면</td>
		</tr>
		<!-- tr>
			<th>목록 옵션</th>
			<td><input type="radio"/>	<input type="radio"/>	<input type="radio"/></td>
		</tr -->
		<tr>
			<th>목록권한</th>
			<td>
				<input type="radio"/>모든회원/비회원
				<input type="radio"/>회원전용
				[<input type="checkbox"/>일반회원 <input type="checkbox"/>관리자회원 <input type="checkbox"/>공급사회원]
			</td>
		</tr>
		<tr>
			<th>글보기권한</th>
			<td>
				<input type="radio"/> 모든회원/비회원	
				<input type="radio"/> 회원전용
				[<input type="checkbox"/>일반회원 <input type="checkbox"/>관리자회원 <input type="checkbox"/>공급사회원]
			</td>
		</tr>
		<tr>
			<th>글쓰기권한</th>
			<td>
				<input type="radio"/>모든회원/비회원	
				<input type="radio"/>회원전용
				[<input type="checkbox"/>일반회원 <input type="checkbox"/>관리자회원 <input type="checkbox"/>공급사회원]
			</td>
		</tr>
		<tr>
			<th>비밀글기능</th>
			<td><input type="checkbox"/> 비밀글 사용</td>
		</tr>
		<tr>
			<th>에디터사용</th>
			<td><input type="checkbox"/> 에디터사용</td>
		</tr>
		<tr>
			<th>첨부파일</th>
			<td>
				<input type="checkbox"/> 첨부파일 사용
				<select>
					<option>1개</option>
				</select>
			</td>
		</tr>
		<tr>
			<th>답변기능</th>
			<td><input type="checkbox"/> 답변기능 사용</td>
		</tr>
		<tr>
			<th>댓글기능</th>
			<td><input type="checkbox"/> 댓글기능 사용</td>
		</tr>
	</table>
</div>


<div class="tableForm mt20">
* 탭버튼 카테고리 메뉴입니다. 
	<table>
		<tr>
			<th>카테고리 사용</th>
			<td><input type="checkbox"/> 사용함</td>
		</tr>
		<tr>
			<th>카테고리노출</th>
			<td><input type="radio"/>콤보박스 <input type="radio"/>텍스트  <input type="radio"/>이미지  </td>
		</tr>
	</table>

	<h3>카테고리 등록</h3>
	<table>
		<tr>
			<th>카테고리명</th>
			<td>
				<input type="input"/> <input type="checkbox" checked/> 화면보임
			</td>
		</tr>
		<tr>
			<th>정렬순서</th>
			<td><input type="input"/></td>
		</tr>
		<tr>
			<th>이미지1</th>
			<td><input type="file"/></td>
		</tr>
		<tr>
			<th>이미지2</th>
			<td><input type="file"/></td>
		</tr>
	</table>
</div>


<div class="tableForm mt20">
* 탭버튼 포인트 메뉴입니다. (단 이벤트 게시판은 각 이벤트등록 글에 따라 아래 설정이 적용됩니다.)
	<table>
		<tr>
			<th>포인트정책</th>
			<td><input type="checkbox"/> 사용함</td>
		</tr>
		<tr>
			<th>글쓰기시 포인트정책</th>
			<td>
				<input type="radio"/>사용안함 
				<input type="radio"/>사용함 (<input type="radio"/>자동포인트지급  <input type="radio"/>수동포인트지급  <input type="radio"/>멀티 차등포인트지급)
			</td>
		</tr>
		<tr>
			<th>글쓰기시 포인트설정</th>
			<td><input type="input" class="_w50"/>포인트 자동지급</td>
		</tr>
		<tr>
			<th>차등포인트 지급</th>
			<td>
				<ul>
					<li>1) <input type="input" class="_w50"/>명에게 <input type="input" class="_w50"/>이란 제목으로 <input type="input" class="_w50"/>포인트 지급</li>
					<li>2) <input type="input" class="_w50"/>명에게 <input type="input" class="_w50"/>이란 제목으로 <input type="input" class="_w50"/>포인트 지급</li>
					<li>3) <input type="input" class="_w50"/>명에게 <input type="input" class="_w50"/>이란 제목으로 <input type="input" class="_w50"/>포인트 지급 
						<a href="#" class="btn_blue_sml"><span>+추가</span></a><a href="#" class="btn_sml"><span>-삭제</span></a>
					</li>
				</ul>
			</td>
		</tr>
		<tr>
			<th>글쓰기시 쿠폰정책</th>
			<td>
				<input type="radio"/>사용안함 
				<input type="radio"/>사용함 (<input type="radio"/>자동쿠폰지급  <input type="radio"/>수동쿠폰지급  <input type="radio"/>멀티 차등쿠폰지급)
			</td>
		</tr>
		<tr>
			<th>글쓰기시 쿠폰설정</th>
			<td><input type="input" class="_w50"/>쿠폰 관리자 확인 후 지급</td>
		</tr>
		<tr>
			<th>댓글</th>
			<td>
				<input type="radio"/>사용안함 
				<input type="radio"/>사용함 (<input type="radio"/>자동포인트지급  <input type="radio"/>수동포인트지급  <input type="radio"/>멀티 차등포인트지급)
			</td>
		</tr>
		<tr>
			<th>댓글작성시 포인트설정</th>
			<td><input type="input" class="_w50"/>포인트 자동지급</td>
		</tr>
		<tr>
			<th>댓글작성시 쿠폰정책</th>
			<td>
				<input type="radio"/>사용안함 
				<input type="radio"/>사용함 (<input type="radio"/>자동쿠폰지급  <input type="radio"/>수동쿠폰지급  <input type="radio"/>멀티 차등쿠폰지급)
			</td>
		</tr>
		<tr>
			<th>댓글장성시 쿠폰설정</th>
			<td><input type="input" class="_w50"/>쿠폰 관리자 확인 후 지급</td>
		</tr>
	</table>

	
</div>