<?
	## 모듈 설정
	require_once MALL_HOME . "/module2/BoardInfoMgr.module.php";
	require_once MALL_HOME . "/module2/BoardAddField.module.php";
	$boardAddField			= new BoardAddFieldModule($db);

	## 기본 설정
	$strBCode						= $_GET['b_code'];
	$intUbNo						= $_GET['ub_no'];
	$aryBoardInfo					= $BOARD_INFO[$strBCode];
	$strUserfieldUse				= $aryBoardInfo['bi_userfield_use'];
	$aryUserfieldSort				= "";

	## 추가 필드 데이터 가져오기
	$param							= "";
	$param['B_CODE']				= $strBCode;
	$param['AD_UB_NO']				= $intUbNo;
	$boardAddFieldRow				= $boardAddField->getBoardAddFieldSelectEx("OP_SELECT", $param);

	## 정렬 만들기
	if($strUserfieldUse == "Y"):
		foreach($G_USERFIELD_INFO as $key => $data):

			## 기본 설정
			$strColumnName		= $data['columnName'];
			$strColumnNameLower	= strtolower($strColumnName);
//			$strKind			= $aryBoardInfo["bi_{$strColumnNameLower}_kind"];
//			$strKindData		= $aryBoardInfo["bi_{$strColumnNameLower}_kind_data"];
//			$strOnlyadmin		= $aryBoardInfo["bi_{$strColumnNameLower}_onlyadmin"];
//			$strEssential		= $aryBoardInfo["bi_{$strColumnNameLower}_essential"];
//			$strName			= $aryBoardInfo["bi_{$strColumnNameLower}_name"];
			$strSort			= $aryBoardInfo["bi_{$strColumnNameLower}_sort"];
			$strUse				= $aryBoardInfo["bi_{$strColumnNameLower}_use"];

			if($strUse != "Y") { continue; }

			$aryUserfieldSort[$strColumnName]	= $strSort;
		
		endforeach;
	endif;

	## 정렬
	asort($aryUserfieldSort);

	
?>


<?if($strUserfieldUse == "Y"):?>
	<?foreach($aryUserfieldSort as $key => $data):

		## 기본 설정
		$strColumnName			= $key;
		$strColumnNameLower		= strtolower($strColumnName);
		$strFieldName			= $aryBoardInfo["bi_{$strColumnNameLower}_name"];
		$strFieldKind			= $aryBoardInfo["bi_{$strColumnNameLower}_kind"];
		$strFieldKindData		= $aryBoardInfo["bi_{$strColumnNameLower}_kind_data"];
		$aryFieldKindData		= explode(";", $strFieldKindData);
		$strEssential			= $aryBoardInfo["bi_{$strColumnNameLower}_essential"];
		$strFieldData			= $boardAddFieldRow[$strColumnName];
		$aryFieldData			= "";
		$strFieldUse			= $aryBoardInfo["bi_{$strColumnNameLower}_use"];
		
		if($strFieldUse != "Y") { continue; }	

		if(in_array($strFieldKind, array("zip","phone"))):
			$aryFieldData			= explode("-", $strFieldData);
		endif;			?>
	<tr>
		<th><?=$strFieldName?></th>
		<td>
			<?if($strFieldKind == "text"):?>
				<input type="text" style="width:400px" name="<?=$strColumnNameLower?>" value="<?=$strFieldData?>" alt="<?=$strFieldName?>" check="<?if($strEssential=="Y"){echo "write";}?>">
			<?elseif($strFieldKind == "select"):?>
				<?if($strFieldKindData):?>
				<select name="<?=$strColumnNameLower?>" alt="<?=$strFieldName?>" check="<?if($strEssential=="Y"){echo "write";}?>">
					<option value="">선택하세요.</option>
					<?foreach($aryFieldKindData as $key2 => $data2):?>
					<option value="<?=$data2?>"<?if($strFieldData==$data2){echo " selected";}?>><?=$data2?></option>
					<?endforeach;?>
				</select>
				<?endif;?>
			<?elseif($strFieldKind == "address"):?>
				<input type="text" style="width:400px" name="<?=$strColumnNameLower?>" value="<?=$strFieldData?>" alt="<?=$strFieldName?>" check="<?if($strEssential=="Y"){echo "write";}?>" maxlength="100">
			<?elseif($strFieldKind == "zip"):?>
				<input type="text" style="width:50px" name="<?=$strColumnNameLower?>[]" value="<?=$aryFieldData[0]?>" alt="<?=$strFieldName?>" check="<?if($strEssential=="Y"){echo "write";}?>" maxlength="3"> - 
				<input type="text" style="width:50px" name="<?=$strColumnNameLower?>[]" value="<?=$aryFieldData[1]?>" alt="<?=$strFieldName?>" check="<?if($strEssential=="Y"){echo "write";}?>" maxlength="3"> 
			<?elseif($strFieldKind == "phone"):?>
				<input type="text" style="width:30px" name="<?=$strColumnNameLower?>[]" value="<?=$aryFieldData[0]?>" alt="<?=$strFieldName?>" check="<?if($strEssential=="Y"){echo "write";}?>" maxlength="3"> - 
				<input type="text" style="width:50px" name="<?=$strColumnNameLower?>[]" value="<?=$aryFieldData[1]?>" alt="<?=$strFieldName?>" check="<?if($strEssential=="Y"){echo "write";}?>" maxlength="4"> - 
				<input type="text" style="width:50px" name="<?=$strColumnNameLower?>[]" value="<?=$aryFieldData[2]?>" alt="<?=$strFieldName?>" check="<?if($strEssential=="Y"){echo "write";}?>" maxlength="4">
			<?endif;?>
		</td>
	</tr>	
	<?endforeach;?>
<?endif;?>