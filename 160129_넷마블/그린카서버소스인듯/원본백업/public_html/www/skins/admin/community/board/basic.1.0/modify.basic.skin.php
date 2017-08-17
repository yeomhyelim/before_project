<!-- ******** 컨텐츠 ********* -->
<div class="tableForm">
	<h3>커뮤니티 기본옵션</h3>
	<table>
		<tr>
			<th>커뮤니티 코드</th>
			<td>
				<input type="text" <?=$nBox?>  style="width:300px;" id="b_code" name="b_code" value="<?=$boardSelectRow['B_CODE']?>"/>
			</td>
		</tr>
		<tr>
			<th>커뮤니티 이름</th>
			<td>
				<input type="text" <?=$nBox?>  style="width:300px;" id="b_name" name="b_name" value="<?=$boardSelectRow['B_NAME']?>"/>
			</td>
		</tr>
		<tr>
			<th>커뮤니티 그룹</th>
			<td>
				<select name="b_bg_no" id="b_bg_no" style="width:300px;">
					<option value="-1"<?if($boardSelectRow['B_BG_NO']=="-1"){echo " selected";}?>>사용안함</option>
					<? foreach($groupList2 as $key => $vel): ?>
					<option value="<?=$key?>"<?if($boardSelectRow['B_BG_NO']==$key){echo " selected";}?>><?=$vel?></option>
					<? endforeach; ?>
				</script>
			</td>
		</tr>
		<tr>
			<th>커뮤니티 종류</th>
			<td>
				<select name="b_kind" id="b_kind" style="width:300px;">
					<option value="data"<?if($boardSelectRow['B_KIND']=="data"){echo " selected"; }?>>일반게시판</option>
					<option value="event"<?if($boardSelectRow['B_KIND']=="event"){echo " selected"; }?>>이벤트게시판</option>
					<option value="talk"<?if($boardSelectRow['B_KIND']=="talk"){echo " selected"; }?>>토크게시판</option>
				</select>
			</td>
		</tr>
		<tr>
			<th>커뮤니티 스킨</th>
			<td>
				<select name="b_skin" id="b_skin" style="width:300px;">
					<option value="basic"<?if($boardSelectRow['B_SKIN']=="basic"){echo " selected"; }?>>basic</option>
					<option value="gallery"<?if($boardSelectRow['B_SKIN']=="gallery"){echo " selected"; }?>>gallery</option>
					<option value="line"<?if($boardSelectRow['B_SKIN']=="line"){echo " selected"; }?>>line</option>
					<option value="comment"<?if($boardSelectRow['B_SKIN']=="comment"){echo " selected"; }?>>comment</option>
					<option value="blog"<?if($boardSelectRow['B_SKIN']=="blog"){echo " selected"; }?>>blog</option>
					<option value="answer"<?if($boardSelectRow['B_SKIN']=="answer"){echo " selected"; }?>>answer</option>
					<option value="user"<?if($boardSelectRow['B_SKIN']=="user"){echo " selected"; }?>>user</option>
				</select>
			</td>
			<!--td>
				<a href="javascript:goBoardDesignListMove()" class="btn_sml"><span>디자인선택</span></a>
				<input type="text" id="skin" name="b_skin" value="<?=$boardSelectRow['B_SKIN']?>" >
			</td-->
		</tr>
		<tr>
			<th>커뮤니티 CSS</th>
			<td>
				<select name="b_css" id="b_css" style="width:300px;">
					<option value="basicCss1"<?if($boardSelectRow['B_CSS']=="basicCss1"){echo " selected"; }?>>기본 CSS1</option>
					<option value="basicCss2"<?if($boardSelectRow['B_CSS']=="basicCss2"){echo " selected"; }?>>기본 CSS2</option>
					<option value="basicCss3"<?if($boardSelectRow['B_CSS']=="basicCss3"){echo " selected"; }?>>기본 CSS3</option>
					<option value="basicCss4"<?if($boardSelectRow['B_CSS']=="basicCss4"){echo " selected"; }?>>기본 CSS4</option>
				</select>
			</td>
			<!--td>
				<a href="javascript:goBoardDesignListMove()" class="btn_sml"><span>디자인선택</span></a>
				<input type="text" id="skin" name="b_skin" value="<?=$boardSelectRow['B_SKIN']?>" >
			</td-->
		</tr>
		<tr>
			<th>커뮤니티 시작 페이지</th>
			<td>
				<input type="radio" name="bi_start_mode" value="dataList"<?if($boardInfoAry['BI_START_MODE']=="dataList"){echo " checked";}?>> 리스트 화면
				<input type="radio" name="bi_start_mode" value="dataView"<?if($boardInfoAry['BI_START_MODE']=="dataView"){echo " checked";}?>> 보기   화면
				<input type="radio" name="bi_start_mode" value="dataWrite"<?if($boardInfoAry['BI_START_MODE']=="dataWrite"){echo " checked";}?>> 글쓰기 화면
			</td>
		</tr>
		<tr>
			<th>커뮤니티 관리자 명칭</th>
			<td>
				<input type="text" style="width:300px" name="bi_admin_nickname" value="<?=$boardInfoAry['BI_ADMIN_NICKNAME']?>">
			</td>
		</tr>
	</table>
</div>

<input type="hidden" name="b_use" value="<?=$boardSelectRow['B_USE']?>" alt="사용유무">
<!-- ******** 컨텐츠 ********* -->

