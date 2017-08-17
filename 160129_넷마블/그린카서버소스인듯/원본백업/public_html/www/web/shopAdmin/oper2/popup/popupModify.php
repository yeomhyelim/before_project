<?php
	## 스크립트 설정
	$aryScriptEx[] = "./common/js/oper2/oper2.popupModify.js";
?>
<div class="contentTop">
	<h2>팝업수정</h2>
	<div class="clr"></div>
</div>

<form name="popupModify" id="popupModify" method="post" enctype="multipart/form-data">
<input type="hidden" name="menuType" value="oper2">
<input type="hidden" name="mode" value="json">
<input type="hidden" name="act" value="popupModify">
<input type="hidden" name="po_no" value="<?=$intPoNo?>">
<input type="hidden" name="po_style" value="layer">
	<div class="tableFormWrap">
		<table class="tableForm">
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00005"] //팝업타이틀?></th>
				<td><input type="text" name="po_title" style="width:500px;" value="<?=$strPoTitle?>"/></td>
			</tr>
			<!-- tr>
				<th>팝업종류</th>
				<td><select name="po_style" data-select="<?=$strPoStyle?>">
						<option value="">선택하세요.</option>
						<option value="basic">일반팝업</option>
						<option value="layer">레이어팝업</option>
					</select></td>
			</tr //-->
<!-- {{ 2015.03.18 bdcho ;팝업 구분(웹/모바일) 추가 -->
			<tr>
				<th>팝업구분</th>
				<td>
					<input type="radio" id="po_section" name="po_section" value="1" <?= $strPoSection == "1" ? "checked" : ""; ?>>웹&nbsp;
					<input type="radio" id="po_section" name="po_section" value="2" <?= $strPoSection == "2" ? "checked" : ""; ?>>모바일
				</td>
			</tr>
<!-- }} 2015.03.18 bdcho ;팝업 구분(웹/모바일) 추가 -->
			<tr>
				<th>사용언어</th>
				<td>
					<?foreach($aryUseLanguage as $data):
						$strLangLower	= strtolower($data);
						$strName		= $S_ARY_COUNTRY[$data];
						
						## selected 설정
						$strChecked	= "";
						if(in_array($data, $aryPoLang)) { $strChecked = " checked"; }		?>
					<input type="checkbox" name="po_lang_<?=$strLangLower?>" value="<?=$data?>"<?=$strChecked?>> <?=$strName?>
					<?endforeach;?>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00006"] //보여주기?></th>
				<td>
					<input type="radio" name="po_view" value="Y"<?if($strPoUse=="Y"){echo " checked";}?>/>Yes
					<input type="radio" name="po_view" value="N"<?if($strPoUse=="N"){echo " checked";}?>/>No
				</td>
			</tr>
			<tr>
				<th>예약</th>
				<td>
					<input type="text"name="po_start_dt" value="<?=$strPoStartDT?>" style="width:100px;" readOnly data-simple-datepicker/> -
					<input type="text"name="po_end_dt" value="<?=$strPoEndDT?>" style="width:100px;" readOnly data-simple-datepicker/>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00008"] //링크페이지?></th>
				<td><input type="text" name="po_link" value="<?=$strPoLink?>" style="width:500px;"/></td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00009"] //링크열기?></th>
				<td>
					<input type="radio" name="po_link_type" value="" checked/><?=$LNG_TRANS_CHAR["EW00012"] //링크없음?>
					<input type="radio" name="po_link_type" value="_blank"<?if($strPoLinkType=="_blank"){echo " checked";}?>/><?=$LNG_TRANS_CHAR["EW00010"] //새창에서 열기?>
					<input type="radio" name="po_link_type" value="_parent"<?if($strPoLinkType=="_parent"){echo " checked";}?>/><?=$LNG_TRANS_CHAR["EW00011"] //부모창에서 열기?>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00014"] //LEFT위치?></th>
				<td><input type="text" name="po_left" value="<?=$intPoLeft?>"  style="width:50px; IME-MODE:disabled;" maxlength="4"/> Pixel</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00013"] //TOP위치?></th>
				<td><input type="text" name="po_top" value="<?=$intPoTop?>"  style="width:50px; IME-MODE:disabled;" maxlength="4"/> Pixel</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00015"] //팝업이미지?></th>
				<td><input type="file" name="po_file"/>
					<?if($strPoFile):?>
					<input type="checkbox" name="po_file_delete" value="Y"> 이미지 삭제<br>
					<img src="<?=$strPoFile?>" style="width:60px;height:60px">
					<?endif?></td>
			</tr>
		</table>
	</div>
</form>

<div class="buttonBoxWrap">
	<a class="btn_new_blue" href="javascript:goOper2PopupModifyActEvent();"><strong class="ico_write">수정</strong></a>
	<a class="btn_new_gray" href="javascript:C_getGoBack();"><strong class="ico_list"><?=$LNG_TRANS_CHAR["CW00001"] //목록?></strong></a>
</div>