<?
	## 설정
	$lng = $_REQUEST['lang'];
	$lng = strtolower($lng);
	
?>
<!-- ******** 컨텐츠 ********* -->
<div class="tableForm">
	<h3>커뮤니티 Widget 설정</h3>
	<table>
		<tr>
			<th>스킨설정</th>
			<td>
				<select name="bi_widget_skin" id="bi_widget_skin">
					<option value="basic"<?if($boardInfoAry['BI_WIDGET_SKIN']=="basic"){echo " selected";}?>>기본스킨1</option>
					<option value="basic2"<?if($boardInfoAry['BI_WIDGET_SKIN']=="basic2"){echo " selected";}?>>기본스킨2</option>
					<option value="basic3"<?if($boardInfoAry['BI_WIDGET_SKIN']=="basic3"){echo " selected";}?>>기본스킨3</option>
					<option value="open"<?if($boardInfoAry['BI_WIDGET_SKIN']=="open"){echo " selected";}?>>펼침스킨</option>
					<option value="review"<?if($boardInfoAry['BI_WIDGET_SKIN']=="review"){echo " selected";}?>>상품리뷰스킨</option>
					<option value="qna"<?if($boardInfoAry['BI_WIDGET_SKIN']=="qna"){echo " selected";}?>>상품QNA스킨</option>
					<option value="gallery"<?if($boardInfoAry['BI_WIDGET_SKIN']=="gallery"){echo " selected";}?>>겔러리스킨1</option>
				</select>
			</td>
		</tr>
		<tr>
			<th>목록수</th>
			<td>
				<!-- 갤러리인 경우보여짐 <input type="input" name="bi_column_default" value='<?=$boardInfoAry['BI_COLUMN_DEFAULT']?>" class="_w50"/> 칸 -->
				<input type="input" name="bi_widget_column_default" value="<?=$boardInfoAry['BI_WIDGET_COLUMN_DEFAULT']?>" class="_w50"/> 칸
				<input type="input" name="bi_widget_list_default" class="_w50" value="<?=$boardInfoAry['BI_WIDGET_LIST_DEFAULT']?>"/> 라인
			</td>
		</tr>
		<tr>
			<th>목록항목</th>
			<td>
				<input type="checkbox" name="bi_widget_datalist_field_use[0]"  value="Y" <?if($boardInfoAry['BI_WIDGET_DATALIST_FIELD_USE_0']=="Y"){echo " checked";}?>/>번호 
				<input type="checkbox" name="bi_widget_datalist_field_use[1]"  value="Y" <?if($boardInfoAry['BI_WIDGET_DATALIST_FIELD_USE_1']=="Y"){echo " checked";}?>/>작성자 
				<input type="checkbox" name="bi_widget_datalist_field_use[2]"  value="Y" <?if($boardInfoAry['BI_WIDGET_DATALIST_FIELD_USE_2']=="Y"){echo " checked";}?>/>등록일 
				<input type="checkbox" name="bi_widget_datalist_field_use[3]"  value="Y" <?if($boardInfoAry['BI_WIDGET_DATALIST_FIELD_USE_3']=="Y"){echo " checked";}?>/>조회수
				<input type="checkbox" name="bi_widget_datalist_field_use[4]"  value="Y" <?if($boardInfoAry['BI_WIDGET_DATALIST_FIELD_USE_4']=="Y"){echo " checked";}?>/>점수
			</td>
		</tr>
		<tr>
			<th>위젯추천</th>
			<td>
				<input type="checkbox" name="bi_widget_icon_use"  value="Y" <?if($boardInfoAry['BI_WIDGET_ICON_USE']=="Y"){echo " checked";}?>/>사용
			</td>
		</tr>
		<tr>
			<th>글쓰기후이동</th>
			<td>
				<input type="radio" name="bi_widget_datawrite_end_move" id="bi_widget_datawrite_end_move" value="dataList"<?if($boardInfoAry['BI_WIDGET_DATAWRITE_END_MOVE']=="dataList"){echo " checked";}?>/> 목록화면
				<input type="radio" name="bi_widget_datawrite_end_move" id="bi_widget_datawrite_end_move" value="windowClose"<?if($boardInfoAry['BI_WIDGET_DATAWRITE_END_MOVE']=="windowClose"){echo " checked";}?>/> 닫기
			</td>
		</tr>
		<tr>
			<th>타이틀 표시방법</th>
			<td>
				<input type="input" name="bi_widget_datalist_title_len" class="_w50" value="<?=$boardInfoAry['BI_WIDGET_DATALIST_TITLE_LEN']?>"/>자리 표시
			</td>
		</tr>
		<tr>
			<th>카테고리 표시 여부</th>
			<td>
				<input type="radio" name="bi_widget_category_show" value="Y"<?if($boardInfoAry['BI_WIDGET_CATEGORY_SHOW']=="Y"){echo " checked";}?>/>표시
				<input type="radio" name="bi_widget_category_show" value="N"<?if($boardInfoAry['BI_WIDGET_CATEGORY_SHOW']=="N"){echo " checked";}?>/>숨김
			</td>
		</tr>
	</table>
</div>
<div class="tableForm">
	<h3>커뮤니티 Widget 스크립트 옵션</h3>
	<table>
		<tr>
			<th>스크립트</th>
			<td>
				<textarea name="bi_datascript_widget_data" id="bi_datascript_widget_data" style="width:100%;height:500px"><?include "{$_REQUEST['S_DOCUMENT_ROOT']}{$_REQUEST['S_SHOP_HOME']}/layout/html/community/{$lng}/widget.{$_REQUEST['b_code']}.script.tag.php"?></textarea>				
			</td>
		</tr>
	</table>
</div>
<!-- ******** 컨텐츠 ********* -->