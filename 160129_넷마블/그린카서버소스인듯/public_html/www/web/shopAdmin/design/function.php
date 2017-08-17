<div class="contentTop">
	<h2>버튼 및 아이콘 관리</h2>
</div>
<br/>
<!-- ******** 컨텐츠 ********* -->
<? include "./include/tab_function.inc.php"?>
<div class="tableForm mt20">
	<table>
		<tr>
			<th>퀵메뉴 사용여부</th>
			<td><input type="checkbox" name="" checked/> 우측오늘본상품 <input type="checkbox" name="" style="margin-left:10px;"/> 좌측 퀵배너</td>
		</tr>
		<tr>
			<th>디자인타입</th>
			<td>기본타입 <a href="#" class="btn_sml ml10"><span>디자인선택</span></a></td>
		</tr>
		<tr>
			<th>기능</th>
			<td><input type="radio" name="" checked/>고정 <input type="radio" name="" style="margin-left:10px;"/>스크룰</td>
		</tr>
		<tr>
			<th>위치 및 속도</th>
			<td>
				<span class="spanTitle">탑위치</span> <input type="text" name="" <?=$nBox?>  style="width:40px;"/> px <span class="blank ml20"></span>
				<span class="spanTitle">우측위치</span> <input type="text" name="" <?=$nBox?>  style="width:40px;"/> px <span class="blank ml20"></span>
				<span class="spanTitle">스크룰속도</span> 
				<select name="">
					<option>1</option>
					<option>2</option>
					<option value="3" selected>3</option>
					<option>4</option>
					<option>5</option>
				</select>
			</td>
		</tr>
	</table>
	<div class="buttonWrap">
		<a class="btn_blue_big" href="javascript:goInfoModify();" id="menu_auth_m"><strong>설정 저장</strong></a>
	</div>