<script language="JavaScript" type="text/javascript" src="../common/eumEditor/highgardenEditor.js"></script>
<script type="text/javascript">
//<![CDATA[
	 /** 자바 스크립트 전역변수 설정 **/
	var rootDir 	= "../../common/eumEditor/highgardenEditor";
	var uploadImg 	= "/upload/editor";
	var uploadFile 	= "../index.php";
	var htmlYN		= "Y";
//]]>
</script>

	
	<div class="contentTop">
		<h2>서브페이지 이미지관리</h2>
	</div>
	<br>
	<!-- ******** 컨텐츠 ********* -->
	<div class="tableForm">
		<table>
			<tr>
				<th>적용분야</th>
				<td>
					<input type="radio" name="" value="" checked/>상품 카테고리
				</td>
			</tr>
			<tr>
				<th>카테고리</th>
				<td>
					<select id="cateHCode1" name="cateHCode1">
						<option value="">1차 카테고리 선택</option>
					</select>
					<select id="cateHCode2" name="cateHCode2" >
						<option value="">2차 카테고리 선택</option>
					</select>
					<select id="cateHCode3" name="cateHCode3" >
						<option value="">3차 카테고리 선택</option>
					</select>
					<select id="cateHCode4" name="cateHCode4">
						<option value="">4차 카테고리 선택</option>
					</select>
				</td>
			</tr>
			<tr>
				<th>상단영역 이미지</th>
				<td>
					<input type="file" name="ti_top_image" <?=$nBox?>  style="width:300px;height:20px"/>
				</td>
			</tr>
			<tr>
				<th>좌측메뉴영역 이미지</th>
				<td>
					<input type="file" name="ti_left_image" <?=$nBox?>  style="width:300px;height:20px"/>
				</td>
			</tr>
			<tr>
				<th>HTML</th>
				<td><textarea name="ti_html_top" id="ti_html_top" title="higheditor_full" style="width:100%;height:200px;"></textarea></td>
			</tr>
			<!-- tr>
				<th>하단 HTML</th>
				<td><textarea style="width:100%;height:200px;" name="contentBottomText" id="contentBottomText" title="higheditor_full"></textarea></td>
			</tr -->
		</table>
		<div class="buttonWrap">
			<a class="btn_blue_big" href="javascript:goSubtopAct('subtopWrite');" id="menu_auth_m"><strong>설정 저장</strong></a>
		</div>
	</div>

