	<table>
		<tr>
			<th>커뮤니티 코드</th>
			<td>
				<input type="text" <?=$nBox?>  style="width:300px;" id="b_code" name="b_code"/>
			</td>
		</tr>
		<tr>
			<th>커뮤니티 이름</th>
			<td>
				<input type="text" <?=$nBox?>  style="width:300px;" id="b_name" name="b_name"/>
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
			<th>(개발자전용설정)</th>
			<td>
				<select name="b_menuType" id="b_menuType" style="width:300px;">
					<option value="community"<?if($boardSelectRow['B_MENUTYPE']=="community"){echo " selected"; }?>>커뮤니티관련</option>
					<option value="seller"<?if($boardSelectRow['B_MENUTYPE']=="seller"){echo " selected"; }?>>입점사관련</option>
					<option value="product"<?if($boardSelectRow['B_MENUTYPE']=="product"){echo " selected"; }?>>상품관련</option>
				</select>
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
					<option value="basic">basic</option>
					<option value="gallery">gallery</option>
					<option value="blog">blog</option>
					<option value="answer">answer</option>
					<option value="line">line</option>
					<option value="comment">comment</option>
				</select>
			</td>
		</tr>
		<tr>
			<th>커뮤니티 CSS</th>
			<td>
				<select name="b_css" id="b_css" style="width:300px;">
					<option value="basicCss1" selected>기본 CSS1</option>
					<option value="basicCss2">기본 CSS2</option>
				</select>
			</td>
		</tr>
	</table>