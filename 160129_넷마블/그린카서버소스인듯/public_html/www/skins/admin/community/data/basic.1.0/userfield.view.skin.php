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
		$strFieldUse			= $aryBoardInfo["bi_{$strColumnNameLower}_use"];
		
		if($strFieldUse != "Y") { continue; }				?>
	<tr>
		<th><?=$strFieldName?></th>
		<td><?=$strFieldData?></td>
	</tr>	
	<?endforeach;?>
<?endif;?>