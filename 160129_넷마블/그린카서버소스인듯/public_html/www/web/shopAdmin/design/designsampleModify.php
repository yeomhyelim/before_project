<div class="contentTop">
	<h2>디자인 관리</h2>
</div>
<br/>
<!-- ******** 컨텐츠 ********* -->
<div class="tableForm">
	<table>
		<colgroup>
			<col/>
			<col/>
		</colgroup>
		<tr>
			<th>디자인그룹</th>
			<td>
				<select id="dm_design_group" name="dm_design_group" value="<?=$row[DM_DESIGN_GROUP]?>">
					<option value="main">main</option>
					<option value="prodlist">prodlist</option>
					<option value="prodview">prodview</option>
					<option value="new">new</option>
					<option value="recommend">recommend</option>slider
					<option value="customerInfo">customerInfo</option>
					<option value="topArea">topArea</option>
					<option value="bottomArea">bottomArea</option>
				</select>
			</td>
		</tr>
		<tr>
			<th>디자인타입</th>
			<td><input type="text" name="dm_design_type" value="<?=$row[DM_DESIGN_TYPE]?>" id="dm_design_type" <?=$nBox?>  style="width:100px;"/></td>
		</tr>
		<tr>
			<th>디자인코드</th>
			<td><input type="text" name="dm_design_code" id="dm_design_code" value="<?=$row[DM_DESIGN_CODE]?>" <?=$nBox?>  style="width:100px;"/></td>
		</tr>
		<tr>
			<th>디자인명</th>
			<td><input type="text" name="dm_design_title" id="dm_design_title" value="<?=$row[DM_DESIGN_TITLE]?>" <?=$nBox?>  style="width:600px;"/></td>
		</tr>
		<tr>
			<th>샘플 URL</th>
			<td><input type="text" name="dm_sample_link" id="dm_sample_link" value="<?=$row[DM_SAMPLE_LINK]?>" <?=$nBox?>  style="width:600px;"/></td>
		</tr>
		<tr>
			<th>샘플 작은이미지</th>
			<td><input type="file" name="dm_sample_image_1" id="dm_sample_image_1" value="<?=$row[DM_SAMPLE_IMAGE_1]?>" <?=$nBox?>  style="width:300px;height:20px;"/></td>
		</tr>
		<tr>
			<th>샘플 큰이미지</th>
			<td><input type="file" name="dm_sample_image_2" id="dm_sample_image_2" value="<?=$row[DM_SAMPLE_IMAGE_2]?>" <?=$nBox?>  style="width:300px;height:20px;"/></td>
		</tr>
		<tr>
			<th>설명</th>
			<td><textarea style="width:100%;height:50px;" name="cp_page_text" value="<?=$row[CP_PAGE_TEXT]?>" id="cp_page_text"></textarea></td>
		</tr>
	</table>
	
	<div class="buttonWrap">
		<a class="btn_blue_big" href="javascript:goDesignsampleAct('designsampleModify');" id="menu_auth_w"><strong>디자인 수정</strong></a>
		<a class="btn_big" href="javascript:C_getMoveUrl('designsampleList','get','<?=$PHP_SELF?>');"><strong>목록</strong></a>
	</div>
</div><!-- tableForm -->
