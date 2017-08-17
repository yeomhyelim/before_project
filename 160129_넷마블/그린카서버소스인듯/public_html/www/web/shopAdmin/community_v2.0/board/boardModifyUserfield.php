<?php
	## 스크립트 설정 
	$aryScriptEx[] = "./common/js/community_v2.0/board/boardModifyUserfield.js";
?>
<div class="contentTop">
	<h2>커뮤니티 설정 (<?php echo $strB_NAME;?>)</h2>
	<div class="clr"></div>
</div>

<br>

<div class="tabImgWrap">
<?php include MALL_HOME . "/skins/admin/community/board/basic.2.0/modify.tabMenu.skin.php";?>
</div>

<br>

<!-- 언어 선택 탭 -->
<?php include MALL_HOME . "/web/shopAdmin/include/tab_language.inc.php";?>
<!-- 언어 선택 탭-->

<form name="form" id="form">
<input type="hidden" name="menuType" id="menuType" value="community_v2.0">
<input type="hidden" name="mode" id="mode" value="">
<input type="hidden" name="act" id="act" value="">
<input type="hidden" name="b_code" id="b_code" value="<?php echo $strB_CODE;?>">
<input type="hidden" name="lang" id="lang" value="<?php echo $strLang;?>">
<div class="tableForm">
	<h3>커뮤니티 추가필드 옵션</h3>
	<table>
		<tr>
			<th>추가필드 사용 유무</th>
			<td>
				<input type="radio" name="bi_userfield_use" value="Y"<?php if($strBI_USERFIELD_USE=="Y"){echo " checked";}?><?php echo $strDisabled;?>> 사용
				<input type="radio" name="bi_userfield_use" value="N"<?php if($strBI_USERFIELD_USE=="N"){echo " checked";}?><?php echo $strDisabled;?>> 사용안함
			</td>
		</tr>
	</table>
	<br>
</div>

<div class="tableList">
	<table>
		<tr>
			<th style="width:50px"><input type="checkbox"></th>
			<th style="width:100px">이름</th>
			<th>필드이름</th>
			<th style="width:100px">정렬</th>
			<th style="width:100px">설명</th>
			<th style="width:150px">설정</th>
		</tr>
		<?php foreach($G_USERFIELD_INFO as $key => $data):

			## 기본 설정
			$strComment				= $data['comment'];
			$strColumnName			= $data['columnName'];
			$strColumnType			= $data['columnType'];
			$strColumnSize			= $data['columnSize'];
			$aryKindList			= explode(";", $data['kindList']);
			$strColumnNameLower		= strtolower($strColumnName);
			$strFieldName			= $aryData["BI_{$strColumnName}_NAME"];
			$strFieldKind			= $aryData["BI_{$strColumnName}_KIND"];
			$strFieldData			= $aryData["BI_{$strColumnName}_KIND_DATA"];
			$strFieldDefault		= $aryData["BI_{$strColumnName}_KIND_DEFAULT"];
			$strOnlyAdmin			= $aryData["BI_{$strColumnName}_ONLYADMIN"];
			$strEssential			= $aryData["BI_{$strColumnName}_ESSENTIAL"];
			$strColumnNameData		= $aryData["BI_{$strColumnName}_NAME"];
			$strcolumnSortData		= $aryData["BI_{$strColumnName}_SORT"];
			$strColumnUseData		= $aryData["BI_{$strColumnName}_USE"];

			## 필드 종류 사용유무 설정
			$isPhoneShow			= false;
			$isZipShow				= false;
			$isTextShow				= false;
			$isSelectShow			= false;
			$isRadioShow			= false;
			$isTextareaShow			= false;
			$isAddressShow			= false;
			$isWysiwygShow			= false;
			if(in_array("phone", $aryKindList))		{ $isPhoneShow		= true; }
			if(in_array("zip", $aryKindList))		{ $isZipShow		= true; }
			if(in_array("text", $aryKindList))		{ $isTextShow		= true; }
			if(in_array("select", $aryKindList))	{ $isSelectShow		= true; }
			if(in_array("radio", $aryKindList))		{ $isRadioShow		= true; }
			if(in_array("textarea", $aryKindList))	{ $isTextareaShow	= true; }
			if(in_array("address", $aryKindList))	{ $isAddressShow	= true; }
			if(in_array("wysiwyg", $aryKindList))	{ $isWysiwygShow	= true; }

			## 필드 데이터 사용유무 설정
			$isKindDataShow = false;
			if($isSelectShow || $isRadioShow) { $isKindDataShow = true; }

			## columnInfo 설정
			$strColumnInfo				= $strColumnType;
			if($strColumnSize)			{ $strColumnInfo		= "{$strColumnInfo}({$strColumnSize})";	}
			
			## 정렬 데이터 설정
			if(!$strcolumnSortData)	{ $strcolumnSortData	= "100000"; }

			## 사용유무 데이터 설정
			if(!$strColumnUseData)		{ $strColumnUseData	= "N"; }							
		?>
		<tr idx="<?php echo $key;?>">
			<td><input type="checkbox"></td>
			<td><?php echo $strComment;?></td>
			<td style="text-align:left">
				<ul>
					<li id="fieldKind">
						<div class="left" style=width:100px;">필드 종류</div>
						<div  class="left"> : 
							<select name="bi_<?php echo $strColumnNameLower;?>_kind" id="fieldKindSelect" onchange="goCommunityBoardModifyUserfieldFieldKindChangeEvent(<?php echo $key;?>);"<?php echo $strDisabled;?>>
									<?php if($isPhoneShow):?>
									<option value="phone"<?php if($strFieldKind=="phone"){echo " selected";}?>>연락처</option>
									<?php endif;?>
									<?php if($isZipShow):?>
									<option value="zip"<?php if($strFieldKind=="zip"){echo " selected";}?>>우편번호</option>
									<?php endif;?>
									<?php if($isTextShow):?>
									<option value="text"<?php if($strFieldKind=="text"){echo " selected";}?>>입력박스</option>
									<?php endif;?>
									<?php if($isSelectShow):?>
									<option value="select"<?php if($strFieldKind=="select"){echo " selected";}?>>선택박스</option>
									<?php endif;?>
									<?php if($isRadioShow):?>
									<option value="radio"<?php if($strFieldKind=="radio"){echo " selected";}?>>라디오박스</option>
									<?php endif;?>
									<?php if($isTextareaShow):?>
									<option value="textarea"<?php if($strFieldKind=="textarea"){echo " selected";}?>>에디터박스</option>
									<?php endif;?>
									<?php if($isAddressShow):?>
									<option value="address"<?php if($strFieldKind=="address"){echo " selected";}?>>주소</option>
									<?php endif;?>
									<?php if($isWysiwygShow):?>
									<option value="wysiwyg"<?php if($strFieldKind=="wysiwyg"){echo " selected";}?>>위즈윅박스</option>
									<?php endif;?>
								</select>
						</div>
						<div class="clr"></div>
					</li>
					<li id="fieldOnlyadmin">
						<div class="left" style=width:100px;">관리자 옵션</div>
						<div  class="left"> : 
							<input type="checkbox" name="bi_<?php echo $strColumnNameLower;?>_onlyadmin" value="Y"<?php if($strOnlyAdmin=="Y"){echo " checked";}?><?php echo $strDisabled;?>> 관리자 전용
						</div>
						<div class="clr"></div>
					</li>
					<li id="fieldEssential">
						<div class="left" style=width:100px;">필수 옵션</div>
						<div  class="left"> : 
							<input type="checkbox" name="bi_<?php echo $strColumnNameLower;?>_essential" value="Y"<?php if($strEssential=="Y"){echo " checked";}?><?php echo $strDisabled;?>> 필수 입력 받음
						</div>
						<div class="clr"></div>
					</li>
					<li id="fieldName">
						<div class="left" style=width:100px;">필드명</div>
						<div  class="left"> : 
							<input type="text" name="bi_<?php echo $strColumnNameLower;?>_name" style="width:100px;" value="<?php echo $strFieldName;?>">
						</div>
						<div class="clr"></div>
					</li>
					<?php if($isKindDataShow):?>
					<li id="fieldKindData" class="<?php if(!in_array($strFieldKind, array("select","radio"))){echo " hide";}?>">
						<div class="left" style=width:100px;">필드 데이터</div>
						<div  class="left"> : 
							<input type="text" name="bi_<?php echo $strColumnNameLower;?>_kind_data" style="width:400px" value="<?php echo $strFieldData;?>">
						</div>
						<div class="clr"></div>
					</li>
					<li id="fieldKindDefault" class="<?php if(!in_array($strFieldKind, array("select","radio"))){echo " hide";}?>">
						<div class="left" style=width:100px;">필드 기본값</div>
						<div  class="left"> : 
							<input type="text" name="bi_<?php echo $strColumnNameLower;?>_kind_default" style="width:400px" value="<?php echo $strFieldDefault;?>">
						</div>
						<div class="clr"></div>
					</li>
					<?php endif;?>
				</ul>
			</td>
			<td><input type="text" name="bi_<?php echo $strColumnNameLower;?>_sort" value="<?php echo $strcolumnSortData;?>" style="width:50px"<?php echo $strDisabled;?>></td>
			<td><?php echo $strColumnInfo;?></td>
			<td><input type="radio" name="bi_<?php echo $strColumnNameLower;?>_use" value="Y"<?php if($strColumnUseData=="Y"){echo "checked";};?><?php echo $strDisabled;?>> 사용
				<input type="radio" name="bi_<?php echo $strColumnNameLower;?>_use" value="N"<?php if($strColumnUseData=="N"){echo "checked";};?><?php echo $strDisabled;?>> 사용안함
			</td>
		</tr>
		<?php endforeach;;?>
	</table>
</div>
</form>

<br>

<div class="button">
	<a class="btn_big" href="javascript:void(0);" onclick="goCommunityBoardModifyUserfieldModifyActEvent();" id="menu_auth_m" style=""><strong>설정 변경</strong></a>
	<a class="btn_big" href="javascript:void(0);" onclick="goCommunityBoardModifyUserfieldListMoveEvent();"><strong>목록</strong></a>
</div>