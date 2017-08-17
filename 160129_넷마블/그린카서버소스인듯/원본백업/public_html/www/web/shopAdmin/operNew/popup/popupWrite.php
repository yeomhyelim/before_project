<div class="contentTop">
	<h2>팝업쓰기</h2>
	<div class="clr"></div>
</div>

<div class="tableForm">
	<table>
		<tr>
			<th><?=$LNG_TRANS_CHAR["EW00005"] //팝업타이틀?></th>
			<td><input type="text" name="po_title" style="width:500px;" data-auto-focus/></td>
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["EW00006"] //보여주기?></th>
			<td>
				<input type="radio" name="po_view" value="Y" checked/>Yes
				<input type="radio" name="po_view" value="N"/>No
			</td>
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["EW00007"] //팝업기간?></th>
			<td>
				<input type="text"name="po_start_dt" style="width:100px;" readOnly data-simple-datepicker/> -
				<input type="text"name="po_end_dt" style="width:100px;" readOnly data-simple-datepicker/>
			</td>
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["EW00008"] //링크페이지?></th>
			<td><input type="text" name="po_link"  style="width:500px;"/></td>
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["EW00009"] //링크열기?></th>
			<td>
				<input type="radio" name="po_type" value="1" checked/><?=$LNG_TRANS_CHAR["EW00010"] //새창에서 열기?>
				<input type="radio" name="po_type" value="2"/><?=$LNG_TRANS_CHAR["EW00011"] //부모창에서 열기?>
				<input type="radio" name="po_type" value="3"/><?=$LNG_TRANS_CHAR["EW00012"] //링크없음?>
			</td>
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["EW00013"] //TOP위치?></th>
			<td><input type="text" name="po_top"  style="width:50px; IME-MODE:disabled;" maxlength="4"/> Pixel</td>
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["EW00014"] //LEFT위치?></th>
			<td><input type="text" name="po_left"  style="width:50px; IME-MODE:disabled;" maxlength="4"/> Pixel</td>
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["EW00015"] //팝업이미지?></th>
			<td><input type="file" name="po_file"/></td>
		</tr>
	</table>
</div>

<div class="buttonWrap">
	<a class="btn_blue_big" href="javascript:goPopupWriteActEvent();"><strong><?=$LNG_TRANS_CHAR["CW00002"] //등록?></strong></a>
	<a class="btn_big" href="javascript:goPopupWriteCancelEvent();"><strong><?=$LNG_TRANS_CHAR["CW00008"] //취소?></strong></a>
</div>