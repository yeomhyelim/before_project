<script type="text/javascript">
<!--
	var rootDir 		= "/common/eumEditor/highgardenEditor";
	var uploadImg 		= "/editor/ceoInterview";
	var uploadFile		= "/kr/";
	var htmlYN			= "Y";
//-->
</script>

<div class="contentTop">
	<h2 class="left">
		감성 인터뷰 칼럼
	</h2>
	<div class="clr"></div>
</div>

<br>

<div class="tableForm">
	<table>
		<tr>
			<th>종류</th>
			<td><select name="kind">
					<?foreach($aryKind as $idx => $name):?>
					<option value="<?=$idx?>"><?=$name?></option>
					<?endforeach;?>
				</select>
			</td>
		</tr>
		<tr>
			<th>제목</th>
			<td><input type="text" name="title" style="width:100%"></td>
		</tr>
		<tr>
			<th>요약</th>
			<td><textarea  name="summary" style="width:700px;height:50px;"></textarea></td>
		</tr>
		<tr>
			<th>미리보기</th>
			<td><div style="width:700px;"><textarea  name="review" id="review" style="width:700px;height:300px;" title="higheditor_full"></textarea></div></td>
		</tr>
		<tr>
			<th>내용</th>
			<td><div style="width:700px;"><textarea  name="text" id="text" style="width:700px;height:300px;" title="higheditor_full"></textarea></div></td>
		</tr>
		<tr>
			<th>키워드</th>
			<td><input name="keyword" type="text" style="width:100%"></td>
		</tr>
		<tr>
			<th>리스트 이미지</th>
			<td><input name="listImage" type="file">
				<p>* 리스트 이미지 사이즈는 가로(80px) X 세로(80px) 자동 설정됩니다.</p></td>
		</tr>
		<tr>
			<th>뷰화면 이미지</th>
			<td><input name="viewImage" type="file">
				<p>* 뷰화면 이미지 사이즈는 가로(400px) X 세로(350px) 자동 설정됩니다.</p></td>
		</tr>
	</table>
</div>

<br>

<div class="button">
	<a href="javascript:goCeosbInterviewWriteActEvent();" class="btn_big" id="menu_auth_m" style=""><strong>등록</strong></a>
	<a href="javascript:goCeosbInterviewCancelMoveEvent();" class="btn_big" id="menu_auth_m" style=""><strong>취소</strong></a>
</div>