<div id="contentArea">
<div class="contentTop">
	<h2><?=$LNG_TRANS_CHAR["EW00001"] //팝업관리?></h2>
	<div class="clr"></div>
</div>


<!-- ******** 컨텐츠 ********* -->

	<div class="tableForm">
		<table>
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00005"] //팝업타이틀?></th>
				<td><input type="text" id="po_title" name="po_title" <?=$nBox?>  style="width:500px;" value="<?=$row["PO_TITLE"]?>"/></td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00006"] //보여주기?></th>
				<td>
					<input type="radio" id="po_view" name="po_view" value="Y" <?=($row["PO_VIEW"]=="Y")?"checked":"";?>/>Yes
					<input type="radio" id="po_view" name="po_view" value="N" <?=($row["PO_VIEW"]=="N")?"checked":"";?>/>No
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00007"] //팝업기간?></th>
				<td>
					<input type="text" <?=$nBox?> style="width:100px;" id="po_start_dt" name="po_start_dt" value="<?=substr($row["PO_START_DT"],0,10)?>"/>
					<!--a href="#"><img src="../aimg/icon_cld.gif" style="vertical-align:middle;margin-right:10px;"/></a--> -
					<input type="text" <?=$nBox?> style="width:100px;" id="po_end_dt" name="po_end_dt" value="<?=substr($row["PO_END_DT"],0,10)?>"/>
					<!--a href="#"><img src="../aimg/icon_cld.gif" style="vertical-align:middle;margin-right:10px;"/></a-->
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00008"] //링크페이지?></th>
				<td><input type="text" <?=$nBox?> id="po_link" name="po_link"  style="width:500px;" value="<?=$row["PO_LINK"]?>"/></td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00009"] //링크열기?></th>
				<td>
					<input type="radio" id="po_type" name="po_type" value="1" <?=($row["PO_TYPE"]=="1")?"checked":"";?>/><?=$LNG_TRANS_CHAR["EW00010"] //새창에서 열기?>
					<input type="radio" id="po_type" name="po_type" value="2" <?=($row["PO_TYPE"]=="2")?"checked":"";?>/><?=$LNG_TRANS_CHAR["EW00011"] //부모창에서 열기?>
					<input type="radio" id="po_type" name="po_type" value="3" <?=($row["PO_TYPE"]=="3")?"checked":"";?>/><?=$LNG_TRANS_CHAR["EW00012"] //링크없음?>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00013"] //TOP위치?></th>
				<td><input type="text" <?=$nBox?> id="po_top" name="po_top"  style="width:50px; IME-MODE:disabled;" value="<?=$row["PO_TOP"]?>"/>&nbsp;&nbsp;Pixel</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00014"] //LEFT위치?></th>
				<td><input type="text" <?=$nBox?> id="po_left" name="po_left"  style="width:50px; IME-MODE:disabled;" value="<?=$row["PO_LEFT"]?>"/>&nbsp;&nbsp;Pixel</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00015"] //팝업이미지?></th>
				<td>
					<input type="file" <?=$nBox?> id="b_file" name="b_file" style="width:300px;height:20px;"/>
					<input type="hidden" id="p_file" name="p_file" style="border:0px solid #FFFFFF;" value="<?=$row["PO_FILE"]?>">
					<div class="attachImg">
						<a href="../upload/popup/<?=$row["PO_FILE"]?>" target="_blank"><img src="../upload/popup/<?=$row["PO_FILE"]?>"/></a>
					</div>
				</td>
			</tr>
		</table>
	</div><!-- tableList -->

	<div class="buttonWrap">
		<a class="btn_blue_big" href="javascript:goPopupAct('popupModify');" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00003"] //수정?></strong></a>
		<a class="btn_big" href="javascript:goMoveUrl('popupList');"><strong><?=$LNG_TRANS_CHAR["CW00008"] //취소?></strong></a>
	</div>
<!-- ******** 컨텐츠 ********* -->