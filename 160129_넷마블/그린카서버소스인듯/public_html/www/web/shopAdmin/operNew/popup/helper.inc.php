<?
	switch($strMode):
	case "popupList":
		// 팝업 리스트

		## 정렬 설정
		$arySortType['NO_DESC']			= "PO.PO_NO DESC";
		$arySortType['NO_ASC']			= "PO.PO_NO ASC";
		$arySortType['STATE_DESC']		= "PO.PO_NO DESC";
		$arySortType['STATE_ASC']		= "PO.PO_NO ASC";
		$arySortType['TITLE_DESC']		= "PO.PO_TITLE DESC";
		$arySortType['TITLE_ASC']		= "PO.PO_TITLE ASC";
		$arySortType['START_DT_DESC']	= "PO.PO_START_DT DESC";
		$arySortType['START_DT_ASC']	= "PO.PO_START_DT ASC";
		$arySortType['END_DESC']		= "PO.PO_END_DT DESC";
		$arySortType['END_ASC']			= "PO.PO_END_DT ASC";

		$sortType						= $_REQUEST['sortType'];
		if(!$sortType) { $sortType = "PO.PO_NO DESC"; }

		## 설정
		require_once MALL_CONF_LIB."PopupMgr.php";
		$popupMgr				= new PopupMgr();

		## 리스트
		$intTotal				= $popupMgr->getPopupListEx($db, "OP_COUNT", $param);						// 데이터 전체 개수 
		$intPageLine			= 10;																		// 리스트 개수 
		$intPage				= ( $intPage )				? $intPage		: 1;
		$intFirst				= ( $intTotal == 0 )		? 0				: $intPageLine * ( $intPage - 1 );

		$param					= "";
		$param['ORDER_BY']		= $arySortType[$sortType];
		$param['LIMIT']			= "{$intFirst},{$intPageLine}";
		$popupResult			= $popupMgr->getPopupListEx($db, "OP_LIST", $param);

		$intPageBlock			= 10;																		// 블럭 개수 
		$intListNum				= $intTotal - ( $intPageLine * ( $intPage - 1 ) );							// 번호
		$intTotPage				= ceil( $intTotal / $intPageLine );

	break;
	case "popupModify":
		// 팝업 수정

		## 설정
		require_once MALL_CONF_LIB."PopupMgr.php";
		$popupMgr				= new PopupMgr();

		## 내용 
		$param					= "";
		$param['PO_NO']			= $_REQUEST['po_no'];
		$popupRow				= $popupMgr->getPopupListEx($db, "OP_SELECT", $param);
	break;
	endswitch;

?>