<?php

	## 커뮤니티 설정
	$strAppLang = $S_SITE_LNG;
	$strBI_USERFIELD_USE = $aryAppBoardInfo['BI_USERFIELD_USE']; // 추가필드 사용 - 사용 = Y, 사용안함 = N

	## 추가필드 사용유무 설정
	if($strBI_USERFIELD_USE != "Y") { return; }

	## 추가필드 배열 만들기
	$aryUserfieldSort = "";
	$aryUserfieldList = "";
	foreach($aryAppBoardInfo as $key => $data):
		
		## 기본설정
		$aryTemp = "";
		$aryTemp = explode("_", $key);
		$intTempCnt = sizeof($aryTemp);
		if($intTempCnt == 4): 
			$strTemp1 = $aryTemp[0];
			$strTemp2 = $aryTemp[1];
			$strTemp3 = $aryTemp[2];
			$strTemp4 = $aryTemp[3];
		elseif($intTempCnt == 5):
			$strTemp1 = $aryTemp[0];
			$strTemp2 = $aryTemp[1];
			$strTemp3 = $aryTemp[2];
			$strTemp4 = "{$aryTemp[3]}_{$aryTemp[4]}";
		endif;

		## 체크
		if($key == "BI_USERFIELD_USE") { continue; }
		if($strTemp2 != "AD") { continue; }
		

		## 추가필드 배열 만들기
		$aryUserfieldList[$strTemp3][$strTemp4] = $data;

		## 정렬 설정
		if($strTemp4 != "SORT") { continue; }
		$aryUserfieldSort[$strTemp3] = $data;

	endforeach;

	## 정렬
	asort($aryUserfieldSort);

?>
<?php foreach($aryUserfieldSort as $key => $data):

		## 기본 설정
		$strKeyLower =strtolower($key);
		$aryData = $aryUserfieldList[$key];
		$strESSENTIAL = $aryData['ESSENTIAL']; // 필수 입력
		$strKIND = $aryData['KIND'];
		$strNAME = $aryData['NAME'];
		$strONLYADMIN = $aryData['ONLYADMIN'];
		$strUSE = $aryData['USE'];
		$strKIND_DATA = $aryData['KIND_DATA'];
		$strKIND_DEFAULT = $aryData['KIND_DEFAULT'];
		$aryCheck = "";

		## 체크
		if($strUSE != "Y") { continue; }
		if($strONLYADMIN == "Y") { continue; }

		## select 데이터 만들기
		if(in_array($strKIND, array("select","radio"))):
			$aryKindData = explode(";", $strKIND_DATA);
		endif;

		## 필수 항목 설정
		if($strESSENTIAL == "Y") { $aryCheck[] = "empty"; }


		## check 설정
		$strCheck = implode("|", $aryCheck);

?>
<tr>
	<th class="name"><?php echo $strNAME;?><?php if(in_array("empty", $aryCheck)){echo "*";}?></th>
	<td>
		<?php if($strKIND == "text"):?>
			<input type="text" style="width:400px" name="<?php echo $strKeyLower;?>" check="<?php echo $strCheck;?>" alt="<?php echo $strNAME;?>">
		<?php elseif($strKIND == "select"):?>
			<?if($aryKindData):?>
			<select name="<?php echo $strKeyLower;?>" check="<?php echo $strCheck;?>" alt="<?php echo $strNAME;?>">
				<option value="">선택하세요.</option>
				<?foreach($aryKindData as $key2 => $data2):
					
					## 기본 설정
					list($strVal, $strValName) = explode("=", $data2);
					if(!$strValName) { $strValName = $strVal; }

					## 기본 선택 설정
					$strChecked = "";
					if($strKIND_DEFAULT == $strVal) { $strChecked = " selected"; }
				?>
				<option value="<?=$strVal?>"<?php echo $strChecked;?>><?=$strValName?></option>
				<?endforeach;?>
			</select>
			<?endif;?>
		<?php elseif($strKIND == "radio"):?>
			<?if($aryKindData):?>
				<?foreach($aryKindData as $key2 => $data2):
					
					## 기본 설정
					list($strVal, $strValName) = explode("=", $data2);
					if(!$strValName) { $strValName = $strVal; }

					## 기본 선택 설정
					$strChecked = "";
					if($strKIND_DEFAULT == $strVal) { $strChecked = " checked"; }
					
				?>
				<input type="radio" name="<?php echo $strKeyLower;?>" value="<?php echo $strVal;?>" check="<?php echo $strCheck;?>" alt="<?php echo $strNAME;?>"<?php echo $strChecked;?>><?php echo $strValName;?>
				<?endforeach;?>
			<?php endif;?>
		<?php elseif($strKIND == "address"):?>
			<?php if($strAppLang == "KR"):?>
			<p><input type="text" style="width:50px" name="<?php echo $strKeyLower;?>_zip1" maxlength="3" check="<?php echo $strCheck;?>" alt="<?php echo $strNAME;?>"> - 
			   <input type="text" style="width:50px" name="<?php echo $strKeyLower;?>_zip2" maxlength="3" check="<?php echo $strCheck;?>" alt="<?php echo $strNAME;?>"></p>
			<p><input type="text" style="width:400px" name="<?php echo $strKeyLower;?>_1" maxlength="100" check="<?php echo $strCheck;?>" alt="<?php echo $strNAME;?>"></p>
			<p><input type="text" style="width:400px" name="<?php echo $strKeyLower;?>_2" maxlength="100" check="<?php echo $strCheck;?>" alt="<?php echo $strNAME;?>"></p>
			<?php else:?>
			<p><input type="text" style="width:100px" name="<?php echo $strKeyLower;?>_zip" maxlength="3" check="<?php echo $strCheck;?>" alt="<?php echo $strNAME;?>">
			<p><input type="text" style="width:400px" name="<?php echo $strKeyLower;?>_1" maxlength="100" check="<?php echo $strCheck;?>" alt="<?php echo $strNAME;?>"></p>
			<p><input type="text" style="width:400px" name="<?php echo $strKeyLower;?>_2" maxlength="100" check="<?php echo $strCheck;?>" alt="<?php echo $strNAME;?>"></p>
			<?php endif;?>
		<?php elseif($strKIND == "phone"):?>
			<?php if($strAppLang == "KR"):?>
			<input type="text" style="width:30px" name="<?php echo $strKeyLower;?>_1" maxlength="3" check="<?php echo $strCheck;?>" alt="<?php echo $strNAME;?>"> - 
			<input type="text" style="width:50px" name="<?php echo $strKeyLower;?>_2" maxlength="4" check="<?php echo $strCheck;?>" alt="<?php echo $strNAME;?>"> - 
			<input type="text" style="width:50px" name="<?php echo $strKeyLower;?>_3" maxlength="4" check="<?php echo $strCheck;?>" alt="<?php echo $strNAME;?>">
			<?php else:?>
			<input type="text" style="width:400px" name="<?php echo $strKeyLower;?>" check="<?php echo $strCheck;?>" alt="<?php echo $strNAME;?>">
			<?php endif;?>
		<?php elseif($strKIND == "textarea"):?>
			<textarea name="<?php echo $strKeyLower;?>" style="width:98%;height:200px;" check="<?php echo $strCheck;?>" alt="<?php echo $strNAME;?>"></textarea>
		<?php elseif($strKIND == "wysiwyg"):?>
			<textarea name="<?php echo $strKeyLower;?>" id="<?php echo $strKeyLower;?>" title="higheditor_full" style="width:98%;height:200px;" check="<?php echo $strCheck;?>" alt="<?php echo $strNAME;?>"></textarea>
		<?php endif;?>
	</td>
</tr>
<?php endforeach;?>