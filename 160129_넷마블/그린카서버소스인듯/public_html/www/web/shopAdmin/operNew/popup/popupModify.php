<?
	## 설정
	$startDate		= date("Y-m-d", strtotime($popupRow['PO_START_DT']));
	$endDate		= date("Y-m-d", strtotime($popupRow['PO_END_DT']));

	## 파일 설정
	$webFolder		= "/upload/popup/";
	$imgFile		= "";
	if($popupRow['PO_FILE']):
	$imgFile		= "{$webFolder}{$popupRow['PO_FILE']}";
	endif;
?>

<div class="contentTop">
	<h2>팝업수정</h2>
	<div class="clr"></div>
</div>

<input type="hidden" name="po_no" value="<?=$popupRow['PO_NO']?>"/>
<div class="tableForm">
	<table>
		<tr>
			<th><?=$LNG_TRANS_CHAR["EW00005"] //팝업타이틀?></th>
			<td><input type="text" name="po_title" value="<?=$popupRow['PO_TITLE']?>" style="width:500px;"/></td>
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["EW00006"] //보여주기?></th>
			<td>
				<input type="radio" name="po_view" value="Y"<?if($popupRow['PO_VIEW']=="Y"){echo " checked";}?>/>Yes
				<input type="radio" name="po_view" value="N"<?if($popupRow['PO_VIEW']=="N"){echo " checked";}?>/>No
			</td>
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["EW00007"] //팝업기간?></th>
			<td>
				<input type="text"name="po_start_dt" style="width:100px;" value="<?=$startDate?>" readOnly data-simple-datepicker/> -
				<input type="text"name="po_end_dt" style="width:100px;" value="<?=$endDate?>" readOnly data-simple-datepicker/>
			</td>
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["EW00008"] //링크페이지?></th>
			<td><input type="text" name="po_link" value="<?=$popupRow['PO_LINK']?>"  style="width:500px;"/></td>
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["EW00009"] //링크열기?></th>
			<td>
				<input type="radio" name="po_type" value="1"<?if($popupRow['PO_TYPE']=="1"){echo " checked";}?>/><?=$LNG_TRANS_CHAR["EW00010"] //새창에서 열기?>
				<input type="radio" name="po_type" value="2"<?if($popupRow['PO_TYPE']=="2"){echo " checked";}?>/><?=$LNG_TRANS_CHAR["EW00011"] //부모창에서 열기?>
				<input type="radio" name="po_type" value="3"<?if($popupRow['PO_TYPE']=="3"){echo " checked";}?>/><?=$LNG_TRANS_CHAR["EW00012"] //링크없음?>
			</td>
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["EW00013"] //TOP위치?></th>
			<td><input type="text" name="po_top" value="<?=$popupRow['PO_TOP']?>"  style="width:50px; IME-MODE:disabled;" maxlength="4"/> Pixel</td>
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["EW00014"] //LEFT위치?></th>
			<td><input type="text" name="po_left" value="<?=$popupRow['PO_LEFT']?>"  style="width:50px; IME-MODE:disabled;" maxlength="4"/> Pixel</td>
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["EW00015"] //팝업이미지?></th>
			<td><input type="file" name="po_file"/>
				<?if($imgFile):?>
				<input type="checkbox" name="po_file_delete" value="Y"> 이미지 삭제<br>
				<img src="<?=$imgFile?>" style="width:60px;height:60px">
				<?endif?></td>
		</tr>
	</table>
</div>

<div class="buttonWrap">
	<a class="btn_blue_big" href="javascript:goPopupModifyActEvent();"><strong>수정</strong></a>
	<a class="btn_big" href="javascript:goPopupModifyCancelEvent();"><strong><?=$LNG_TRANS_CHAR["CW00008"] //취소?></strong></a>
</div>