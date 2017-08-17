<?
	## 모듈 설정
	require_once MALL_HOME . "/module2/BoardInfoMgr.module.php";
	$objBoardAddField				= new BoardAddFieldModule($db);

	## 기본 설정
	$strAppBCode					= $EUMSHOP_APP_INFO['b_code'];
	$strAppUBNo						= $EUMSHOP_APP_INFO['ub_no'];

	## 설정 파일 불러오기
	include_once MALL_SHOP . "/conf/community/board.{$strAppBCode}.info.php";

	$aryAppBoardInfo				= $BOARD_INFO[$strAppBCode];
	$strAppUserfieldUse				= $aryAppBoardInfo['bi_userfield_use'];
	$aryAppUserfieldSort			= "";

	## 추가 필드 데이터 가져오기
	$param							= "";
	$param['B_CODE']				= $strAppBCode;
	$param['AD_UB_NO']				= $strAppUBNo;
	$aryBoardAddFieldRow			= $objBoardAddField->getBoardAddFieldSelectEx("OP_SELECT", $param);

	## 정렬 만들기
	if($strAppUserfieldUse == "Y"):
		foreach($G_USERFIELD_INFO as $key => $data):

			## 기본 설정
			$strColumnName		= $data['columnName'];
			$strColumnNameLower	= strtolower($strColumnName);
//			$strKind			= $aryAppBoardInfo["bi_{$strColumnNameLower}_kind"];
//			$strKindData		= $aryAppBoardInfo["bi_{$strColumnNameLower}_kind_data"];
			$strOnlyadmin		= $aryAppBoardInfo["bi_{$strColumnNameLower}_onlyadmin"];
//			$strEssential		= $aryAppBoardInfo["bi_{$strColumnNameLower}_essential"];
//			$strName			= $aryAppBoardInfo["bi_{$strColumnNameLower}_name"];
			$strSort			= $aryAppBoardInfo["bi_{$strColumnNameLower}_sort"];
			$strUse				= $aryAppBoardInfo["bi_{$strColumnNameLower}_use"];

			if($strUse != "Y") { continue; }
			if($strOnlyadmin == "Y") { continue; }

			$aryAppUserfieldSort[$strColumnName]	= $strSort;
		
		endforeach;
	endif;

	## 정렬
	asort($aryAppUserfieldSort);

?>

<?if($strAppUserfieldUse == "Y"):?>
<ul class="addTableInfo">
	<?foreach($aryAppUserfieldSort as $key => $data):

		## 기본 설정
		$strColumnName			= $key;
		$strColumnNameLower		= strtolower($strColumnName);
		$strFieldName			= $aryAppBoardInfo["bi_{$strColumnNameLower}_name"];
		$strFieldKind			= $aryAppBoardInfo["bi_{$strColumnNameLower}_kind"];
		$strFieldKindData		= $aryAppBoardInfo["bi_{$strColumnNameLower}_kind_data"];
		$aryFieldKindData		= explode(";", $strFieldKindData);
		$strEssential			= $aryAppBoardInfo["bi_{$strColumnNameLower}_essential"];
		$strFieldData			= $aryBoardAddFieldRow[$strColumnName];
		$strFieldUse			= $aryAppBoardInfo["bi_{$strColumnNameLower}_use"];
		
		if($strFieldUse != "Y") { continue; }				?>
	<?php if($strFieldKind =="phone"):?>
	<li class="<?php echo $strFieldKind;?>"><span><?=$strFieldName?></span><a href="tel:<?=$strFieldData?>"><?=$strFieldData?></a></li>	
	<?php else:?>
	<li><span><?=$strFieldName?></span><?=$strFieldData?></li>	
	<?php endif;?>
	<?endforeach;?>
</ul>
<?endif;?>