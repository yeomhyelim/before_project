<?php
	switch($strMode):
	case "popupWrite":
		// 팝업관리 쓰기

		/* 관리자 Sub Menu 권한 설정 */
		$strLeftMenuCode01				= "001";
		$strLeftMenuCode02				= "001";
		/* 관리자 Sub Menu 권한 설정 */
		
		## 사용언어 설정
		$aryUseLanguage					= explode("/", $S_USE_LNG);
	
	break;
	case "popupModify":
		// 팝업관리 수정

		/* 관리자 Sub Menu 권한 설정 */
		$strLeftMenuCode01 = "001";
		$strLeftMenuCode02 = "001";
		/* 관리자 Sub Menu 권한 설정 */

		## 모듈설정
		$objPopupMgrModule				= new PopupMgrModule($db);

		## 기본설정
		$intPoNo						= $_GET['po_no'];

		## 데이터 불러오기
		$aryParam						= "";
		$aryParam['PO_NO']				= $intPoNo;
		$aryPopupRow					= $objPopupMgrModule->getPopupMgrSelectEx("OP_SELECT", $aryParam);

		$strPoTitle						= $aryPopupRow['PO_TITLE'];
		$strPoStyle						= $aryPopupRow['PO_STYLE'];
		$strPoLink						= $aryPopupRow['PO_LINK'];
		$strPoLinkType					= $aryPopupRow['PO_LINK_TYPE'];
		$intPoLeft						= $aryPopupRow['PO_LEFT'];
		$intPoTop						= $aryPopupRow['PO_TOP'];
		$strPoFile						= $aryPopupRow['PO_FILE'];
		$strPoLang						= $aryPopupRow['PO_LANG'];
		$strPoStartDT					= $aryPopupRow['PO_START_DT'];
		$strPoEndDT						= $aryPopupRow['PO_END_DT'];
		$strPoUse						= $aryPopupRow['PO_USE'];

/*
2015.03.18 bdcho
:팝업 관리 항목 추가
{{
*/
		$strPoSection					= $aryPopupRow['PO_IS_WEB'];
/*
}}
2015.03.18 bdcho
:팝업 관리 항목 추가
*/

		## 사용언어 설정
		$aryPoLang						= explode(",", $strPoLang);
		$aryUseLanguage					= explode("/", $S_USE_LNG);

		## 예약시간 설정
		$strPoStartDT					= date("Y-m-d", strtotime($strPoStartDT));
		$strPoEndDT						= date("Y-m-d", strtotime($strPoEndDT));

		## 이미지파일 설정
		$webFolder						= "/upload/popup/";
		if($strPoFile):
			$strPoFile					= $webFolder . $strPoFile;
		endif;

	break;
	case "popupList":

		// 팝업관리 리스트

		/* 관리자 Sub Menu 권한 설정 */
		$strLeftMenuCode01				= "001";
		$strLeftMenuCode02				= "001";
		/* 관리자 Sub Menu 권한 설정 */

		## 모듈설정
		$objPopupMgrModule				= new PopupMgrModule($db);

		## 기본설정
		$webFolder						= "/upload/popup/";

		## 데이터 리스트
		$aryParam						= "";
		$intTotal						= $objPopupMgrModule->getPopupMgrSelectEx("OP_COUNT", $aryParam);				// 데이터 전체 개수 
		$intPageLine					= 10;																		// 리스트 개수 
		$intPage						= ( $intPage )				? $intPage		: 1;
		$intFirst						= ( $intTotal == 0 )		? 0				: $intPageLine * ( $intPage - 1 );

		$aryParam['LIMIT']				= "{$intFirst},{$intPageLine}";
		$objPopupResult					= $objPopupMgrModule->getPopupMgrSelectEx("OP_LIST", $aryParam);

		$intPageBlock					= 10;																		// 블럭 개수 
		$intListNum						= $intTotal - ( $intPageLine * ( $intPage - 1 ) );							// 번호
		$intTotPage						= ceil( $intTotal / $intPageLine );


		## 정렬 설정
		$sortPO_NO						= "NO_DESC";
		$sortPO_STATE					= "STATE_DESC";
		$sortPO_TITLE					= "TITLE_DESC";
		$sortPO_START_DT				= "START_DT_DESC";
		$sortPO_END_DT					= "END_DESC";

			 if($_REQUEST['sortType'] == "NO_DESC")			{ $sortPO_NO		= "NO_ASC";			}
		else if($_REQUEST['sortType'] == "STATE_DESC")		{ $sortPO_STATE		= "STATE_ASC";		}
		else if($_REQUEST['sortType'] == "TITLE_DESC")		{ $sortPO_TITLE		= "TITLE_ASC";		}
		else if($_REQUEST['sortType'] == "START_DT_DESC")	{ $sortPO_START_DT	= "START_DT_ASC";	}
		else if($_REQUEST['sortType'] == "END_DESC")		{ $sortPO_END_DT	= "END_ASC";		}
		else												{										}

	break;
	endswitch;