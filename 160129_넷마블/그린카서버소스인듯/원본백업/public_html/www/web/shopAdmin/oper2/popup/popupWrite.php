<?php
	## 스크립트 설정
	$aryScriptEx[] = "./common/js/oper2/oper2.popupWrite.js";
?>
<div class="contentTop">
	<h2>팝업쓰기</h2>
	<div class="clr"></div>
</div>

<form name="popupWrite" id="popupWrite" method="post" enctype="multipart/form-data">
<input type="hidden" name="menuType" value="oper2">
<input type="hidden" name="mode" value="json">
<input type="hidden" name="act" value="popupWrite">
<input type="hidden" name="po_style" value="layer">
	<div class="tableFormWrap">
		<table class="tableForm">
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00005"] //팝업타이틀?></th>
				<td><input type="text" name="po_title" style="width:500px;" data-auto-focus/></td>
			</tr>
			<!-- tr>
				<th>팝업종류</th>
				<td><select name="po_style">
						<option value="">선택하세요.</option>
						<option value="basic">일반팝업</option>
						<option value="layer">레이어팝업</option>
					</select></td>
			</tr //-->
<!-- {{ 2015.03.18 bdcho ;팝업 구분(웹/모바일) 추가 -->
			<tr>
				<th>팝업구분</th>
				<td>
					<input type="radio" id="po_section" name="po_section" value="1" checked>웹&nbsp;
					<input type="radio" id="po_section" name="po_section" value="2" >모바일
				</td>
			</tr>
<!-- }} 2015.03.18 bdcho ;팝업 구분(웹/모바일) 추가 -->
			<tr>
				<th>사용언어</th>
				<td>
					<?foreach($aryUseLanguage as $data):
						$strLangLower	= strtolower($data);
						$strName		= $S_ARY_COUNTRY[$data];	?>
					<input type="checkbox" name="po_lang_<?=$strLangLower?>" value="<?=$data?>"> <?=$strName?>
					<?endforeach;?>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00006"] //보여주기?></th>
				<td>
					<input type="radio" name="po_view" value="Y" checked/>Yes
					<input type="radio" name="po_view" value="N"/>No
				</td>
			</tr>
			<tr>
				<th>예약</th>
				<td>
					<input type="text"name="po_start_dt" style="width:100px;" value="<?=date("Y-m-d")?>" readOnly data-simple-datepicker/> -
					<input type="text"name="po_end_dt" style="width:100px;" value="<?=date("Y-m-d")?>" readOnly data-simple-datepicker/>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00008"] //링크페이지?></th>
				<td><input type="text" name="po_link"  style="width:500px;"/></td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00009"] //링크열기?></th>
				<td>
					<input type="radio" name="po_link_type" value="" checked/><?=$LNG_TRANS_CHAR["EW00012"] //링크없음?>
					<input type="radio" name="po_link_type" value="_blank"/><?=$LNG_TRANS_CHAR["EW00010"] //새창에서 열기?>
					<input type="radio" name="po_link_type" value="_parent"/><?=$LNG_TRANS_CHAR["EW00011"] //부모창에서 열기?>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00014"] //LEFT위치?></th>
				<td><input type="text" name="po_left"  style="width:50px; IME-MODE:disabled;" maxlength="4"/> Pixel</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00013"] //TOP위치?></th>
				<td><input type="text" name="po_top"  style="width:50px; IME-MODE:disabled;" maxlength="4"/> Pixel</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00015"] //팝업이미지?></th>
				<td><input type="file" name="po_file"/></td>
			</tr>
		</table>
	</div>
</form>

<div class="buttonBoxWrap">
	<a class="btn_new_blue" href="javascript:goOper2PopupWriteActEvent();"><strong class="ico_write"><?=$LNG_TRANS_CHAR["CW00002"] //등록?></strong></a>
	<a class="btn_new_gray" href="javascript:C_getGoBack();"><strong class="ico_list"><?=$LNG_TRANS_CHAR["CW00001"] //목록?></strong></a>
</div>