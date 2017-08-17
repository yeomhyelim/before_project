<?php

	## 모듈 설정
	$objBoardAddFieldModule = new BoardAddFieldModule($db);

	## 기본설정
	$strBCode = $_GET['b_code'];
	$strUbNo = $_GET['ubNo'];

	## 체크
	if(!$strBCode) { return; }
	if(!$strUbNo) { return; }

	## 커뮤니티 설정
	$strLang = $S_SITE_LNG;
	$strBI_USERFIELD_USE = $aryBoardInfo['BI_USERFIELD_USE']; // 추가필드 사용 - 사용 = Y, 사용안함 = N

	## 추가필드 사용유무 설정
	if($strBI_USERFIELD_USE != "Y") { return; }
	if(!$aryBoardInfo) { return; }

	## 데이터 불러오기
	$param = "";
	$param['B_CODE'] = $strBCode;
	$param['AD_UB_NO'] = $strUbNo;
	$aryBoardAddDataRow = $objBoardAddFieldModule->getBoardAddFieldSelectEx("OP_SELECT", $param);

	## 추가필드 배열 만들기
	$aryUserfieldSort = "";
	$aryUserfieldList = "";
	foreach($aryBoardInfo as $key => $data):
		
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
		$isUserAddField = false;

		## 체크
		if($strUSE != "Y") { continue; }
		if($strONLYADMIN == "Y") { continue; }

		## 데이터 불러오기
		if($key != "ADDR1"):
			$strValue = $aryBoardAddDataRow["AD_{$key}"];
			if($strValue) { $isUserAddField = true; };
		else:
			$strZip = $aryBoardAddDataRow["AD_ZIP"];
			$strAddr1 = $aryBoardAddDataRow["AD_ADDR1"];
			$strAddr2 = $aryBoardAddDataRow["AD_ADDR2"];	
			if($strZip && $strAddr1 && $strAddr2) { $isUserAddField = true; };
		endif;

		## 출력 여부 설정
		if(!$isUserAddField) { continue; }
?>
<tr>
	<th class="name"><?php echo $strNAME;?></th>
	<td colspan="3"><?php if($key != "ADDR1"):?>
		<?php echo $strValue;?>
		<?php else:?>
		<p><?php echo $strZip;?></p>
		<p><?php echo $strAddr1;?></p>
		<p><?php echo $strAddr2;?></p>
		<?php endif;?>
	</td>
</tr>
<?php endforeach;?>