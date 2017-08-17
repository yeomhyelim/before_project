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
			<td><?=$strKind?></td>
		</tr>
		<tr>
			<th>제목</th>
			<td><?=$strTitle?></td>
		</tr>
		<tr>
			<th>요약</th>
			<td><?=$strSummary?></td>
		</tr>
		<tr>
			<th>미리보기</th>
			<td><?=$strPreview?></td>
		</tr>
		<tr>
			<th>내용</th>
			<td><?=$strText?></td>
		</tr>
		<tr>
			<th>키워드</th>
			<td><?=$strKeyword?></td>
		</tr>
		<tr>
			<th>리스트 이미지</th>
			<td>
				<?if($strImage1):?>
				<a href="<?=$strImage1?>" target="_blank">이미지 보기</a>
				<?endif;?>
			</td>
		</tr>
		<tr>
			<th>뷰화면 이미지</th>
			<td>
				<?if($strImage2):?>
				<a href="<?=$strImage2?>" target="_blank">이미지 보기</a>
				<?endif;?>
			</td>
		</tr>
	</table>
</div>

<br>

<div class="button">
	<a href="javascript:goCeosbInterviewModifyMoveEvent();" class="btn_big" id="menu_auth_m" style=""><strong>수정</strong></a>
	<a href="javascript:goCeosbInterviewDeleteActEvent('<?=$strICCode?>');" class="btn_big" id="menu_auth_m" style=""><strong>삭제</strong></a>
	<a href="javascript:goCeosbInterviewListMoveEvent();" class="btn_big" id="menu_auth_m" style=""><strong>목록</strong></a>
</div>

