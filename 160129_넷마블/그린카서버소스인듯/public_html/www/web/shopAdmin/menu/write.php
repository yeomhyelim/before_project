<div id="contentArea">
<div class="contentTop">
	<h2>Menu Insert</h2>
</div>
<br>
<!-- ******** 컨텐츠 ********* -->
<div class="tableForm">
	<table>
		<tr>
			<th>메뉴레벨</th>
			<td>
				<input type="radio" name="mn_level" id="mn_level" value="1" checked onclick="javascript:goMnLevelChk(1);">1차
				<input type="radio" name="mn_level" id="mn_level" value="2" onclick="javascript:goMnLevelChk(2);">2차
				<input type="radio" name="mn_level" id="mn_level" value="3" onclick="javascript:goMnLevelChk(3);">3차
			</td>
		</tr>
		<tr id="trHighMenu" style="display:none">
			<th>상위메뉴</th>
			<td>
				<?=drawSelectBoxMore("mn_high_01",$menuAry01,$selected ="",$design ="",$onchange="javascript:goMnHigh(this);",$etc="",$firstItem=":::Select:::",$html="N")?>
				<div id="divHighMenu">
				</div>
			</td>
		</tr>
		<tr>
			<th>메뉴명</th>
			<td>
				<table>
				<?
					for($i=0;$i<sizeof($aryUseLng);$i++){
				?>
					<tr>	
						<td style="width:150px"><?=$aryUseLng[$i]?>(<?=$S_ARY_COUNTRY[$aryUseLng[$i]]?>)</td>
						<td>
							<input type="text" style="width:250px;"  name="mn_name_<?=strtolower($aryUseLng[$i])?>" id="mn_name_<?=strtolower($aryUseLng[$i])?>"/>
						</td>
					</tr>
				<?}?>
				</table>
			</td>
		</tr>
		<tr>
			<th>메뉴URL</th>
			<td><input type="text" style="width:550px;"  name="mn_url" id="mn_url"/></td>
		</tr>
		<tr>
			<th>권한</th>
			<td>
				<input type="checkbox" name="mn_auth_l" id="mn_auth_l" value="Y" >목록
				<input type="checkbox" name="mn_auth_w" id="mn_auth_w" value="Y" >등록
				<input type="checkbox" name="mn_auth_m" id="mn_auth_m" value="Y" >수정
				<input type="checkbox" name="mn_auth_d" id="mn_auth_d" value="Y" >삭제
				<input type="checkbox" name="mn_auth_e" id="mn_auth_e" value="Y" >엑셀
				<input type="checkbox" name="mn_auth_e" id="mn_auth_c" value="Y" >정산
				<input type="checkbox" name="mn_auth_s" id="mn_auth_s" value="Y" >SMS
				<input type="checkbox" name="mn_auth_u" id="mn_auth_u" value="Y" >업로드
				<input type="checkbox" name="mn_auth_p" id="mn_auth_p" value="Y" >포인트
				<input type="checkbox" name="mn_auth_e1" id="mn_auth_e1" value="Y">기타기능1
				<input type="checkbox" name="mn_auth_e2" id="mn_auth_e2" value="Y">기타기능2
				<input type="checkbox" name="mn_auth_e3" id="mn_auth_e3" value="Y">기타기능3
				<input type="checkbox" name="mn_auth_e4" id="mn_auth_e4" value="Y">기타기능4
				<input type="checkbox" name="mn_auth_e5" id="mn_auth_e5" value="Y">기타기능5

			</td>
		</tr>
		<tr>
			<th>메뉴순서</th>
			<td>
				<input type="text" style="width:50px;"  name="mn_order" id="mn_order"/>
			</td>
		</tr>
		<tr>
			<th>사용여부</th>
			<td>
				<input type="checkbox" name="mn_use" id="mn_use" value="Y" >사용
			</td>
		</tr>
	</table>
	
</div>

<div class="buttonWrap">
	<a class="btn_blue_big" href="javascript:goAct('write');" id="menu_auth_m"><strong>등록</strong></a>
	<a class="btn_big" href="javascript:goMoveUrl('list');"><strong>취소</strong></a>
</div>
<!-- ******** 컨텐츠 ********* -->