<?php

	switch($strAct):
	case "popupWrite":
		// 팝업관리 등록

		## 모듈 선언
		$objPopupMgrModule			= new PopupMgrModule($db);

		## 기본설정
		$strPoTitle					= $_POST['po_title'];
		$strPoStyle					= $_POST['po_style'];
		$strPoUse					= $_POST['po_view'];
		$strPoStartDT				= $_POST['po_start_dt'];
		$strPoEndDT					= $_POST['po_end_dt'];
		$strPoLink					= $_POST['po_link'];
		$strPoLinkType				= $_POST['po_link_type'];
		$strPoTop					= $_POST['po_top'];
		$strPoLeft					= $_POST['po_left'];

/*
2015.03.18 bdcho
:팝업 관리 항목 추가
{{
*/
		$strPoSection				= $_POST['po_section'];
/*
}}
2015.03.18 bdcho
:팝업 관리 항목 추가
*/	

		$strPoLang					= "";
		$strPoFile					= "";
		$strDefaultDir				= MALL_SHOP . "/upload/popup";
		$strWebDir					= "/upload/popup";
		$intRegNO					= $_SESSION['ADMIN_NO'];

		## 시작일,종료일 설정
		if($strPoStartDT):
			$strPoStartDT			= date("Y-m-d 00:00:00", strtotime($strPoStartDT));
		endif;
		if($strPoEndDT):
			$strPoEndDT				= date("Y-m-d 23:59:59", strtotime($strPoEndDT));
		endif;

		## 사용 언어 설정
		$aryUseLng					= explode("/", $S_USE_LNG);
		foreach($aryUseLng as $strLng):
			$strLngLower			= strtolower($strLng);
			$strPoLangTemp			= $_POST["po_lang_{$strLngLower}"];
			if($strPoLangTemp):
				if($strPoLang) { $strPoLang .= ","; }
				$strPoLang			.= $strPoLangTemp;
			endif;
		endforeach;

		## 파일 업로드
		$strName = $_FILES['po_file']['name'];
		$strType = $_FILES['po_file']['type'];
		$intSize = $_FILES['po_file']['size'];
		if($_FILES && $strName):
			$strSaveFileName = FileDevice::getUniqueFileName($strDefaultDir, date("YmdHis") . "_po_file_%s_@_" . $strName);
			if(!$strSaveFileName):
				$result['__STATE__']	= "NO_SAVE_FILE_NAME";
				$result['__MSG__']		= "파일명을 생성할 수 없습니다.";
				break;
			endif;

			$re = FileDevice::upload("po_file", $strDefaultDir . "/" . $strSaveFileName);
			if(!$re):
				$result['__STATE__']	= "CANNOT_UPLOAD";
				$result['__MSG__']		= "파일을 업로드 할 수없습니다. 잠시후에 다시 시도 하시기 바랍니다.";
				break;
			endif;

			$strPoFile = $strSaveFileName;
		endif;

		## 팝업쓰기
		$aryParam						= "";
		$aryParam['PO_TITLE']			= $strPoTitle;	
		$aryParam['PO_STYLE']			= $strPoStyle;
		$aryParam['PO_LINK']			= $strPoLink;
		$aryParam['PO_LINK_TYPE']		= $strPoLinkType;
		$aryParam['PO_LEFT']			= $strPoLeft;
		$aryParam['PO_TOP']				= $strPoTop;
		$aryParam['PO_FILE']			= $strPoFile;
		$aryParam['PO_LANG']			= $strPoLang;
		$aryParam['PO_START_DT']		= $strPoStartDT;
		$aryParam['PO_END_DT']			= $strPoEndDT;
		$aryParam['PO_USE']				= $strPoUse;
		$aryParam['PO_REG_DT']			= "NOW()";
		$aryParam['PO_REG_NO']			= $intRegNO;
		$aryParam['PO_MOD_DT']			= "NOW()";
		$aryParam['PO_MOD_NO']			= $intRegNO;

/*
2015.03.18 bdcho
:팝업 관리 항목 추가
{{
*/
		$aryParam['PO_IS_WEB']			= ($strPoSection == "") ? "1" : $strPoSection;
/*
}}
2015.03.18 bdcho
:팝업 관리 항목 추가
*/	

		$re								= $objPopupMgrModule->getPopupMgrInsertEx($aryParam);
		
		## 마무리
		$result['__STATE__']			= "SUCCESS";
		
	break;

	case "popupModify":
		// 팝업관리 수정

		## 모듈 선언
		$objPopupMgrModule			= new PopupMgrModule($db);

		## 기본설정
		$intPoNo					= $_POST['po_no'];
		$strPoTitle					= $_POST['po_title'];
		$strPoStyle					= $_POST['po_style'];
		$strPoUse					= $_POST['po_view'];
		$strPoStartDT				= $_POST['po_start_dt'];
		$strPoEndDT					= $_POST['po_end_dt'];
		$strPoLink					= $_POST['po_link'];
		$strPoLinkType				= $_POST['po_link_type'];
		$strPoTop					= $_POST['po_top'];
		$strPoLeft					= $_POST['po_left'];

/*
2015.03.18 bdcho
:팝업 관리 항목 추가
{{
*/
		$strPoSection				= $_POST['po_section'];
		$strSearchWelfare			= $_POST['po_welfare'];
/*
}}
2015.03.18 bdcho
:팝업 관리 항목 추가
*/	

		$strPoLang					= "";
		$strPoFile					= "";
		$strPoFileDelete			= $_POST['po_file_delete'];
		$strDefaultDir				= MALL_SHOP . "/upload/popup";
		$strWebDir					= "/upload/popup";
		$intModNO					= $_SESSION['ADMIN_NO'];


		## 시작일,종료일 설정
		if($strPoStartDT):
			$strPoStartDT			= date("Y-m-d 00:00:00", strtotime($strPoStartDT));
		endif;
		if($strPoEndDT):
			$strPoEndDT				= date("Y-m-d 23:59:59", strtotime($strPoEndDT));
		endif;

		## 사용 언어 설정
		$aryUseLng					= explode("/", $S_USE_LNG);
		foreach($aryUseLng as $strLng):
			$strLngLower			= strtolower($strLng);
			$strPoLangTemp			= $_POST["po_lang_{$strLngLower}"];
			if($strPoLangTemp):
				if($strPoLang) { $strPoLang .= ","; }
				$strPoLang			.= $strPoLangTemp;
			endif;
		endforeach;

		## 데이터 불러오기
		$aryParam						= "";
		$aryParam['PO_NO']				= $intPoNo;
		$aryPopupRow					= $objPopupMgrModule->getPopupMgrSelectEx("OP_SELECT", $aryParam);
		$strOrgPoFile					= $aryPopupRow['PO_FILE'];

		## 파일 업로드
		$strName = $_FILES['po_file']['name'];
		$strType = $_FILES['po_file']['type'];
		$intSize = $_FILES['po_file']['size'];
		if($_FILES && $strName):
			$strSaveFileName = FileDevice::getUniqueFileName($strDefaultDir, date("YmdHis") . "_po_file_%s_@_" . $strName);
			if(!$strSaveFileName):
				$result['__STATE__']	= "NO_SAVE_FILE_NAME";
				$result['__MSG__']		= "파일명을 생성할 수 없습니다.";
				break;
			endif;

			$re = FileDevice::upload("po_file", $strDefaultDir . "/" . $strSaveFileName);
			if(!$re):
				$result['__STATE__']	= "CANNOT_UPLOAD";
				$result['__MSG__']		= "파일을 업로드 할 수없습니다. 잠시후에 다시 시도 하시기 바랍니다.";
				break;
			endif;

			$strPoFile = $strSaveFileName;
			$strPoFileDelete = "Y";
		endif;

		## 파일 삭제
		$strDeleteFile					= $strOrgPoFile;
		$strDeleteFile					= "{$strDefaultDir}/{$strDeleteFile}";
		if($strPoFileDelete == "Y"):
			FileDevice::fileDelete($strDeleteFile);
		else:
			$strPoFile					= $strOrgPoFile;
		endif;

		## 팝업수정
		$aryParam						= "";
		$aryParam['PO_NO']				= $intPoNo;	
		$aryParam['PO_TITLE']			= $strPoTitle;	
		$aryParam['PO_STYLE']			= $strPoStyle;
		$aryParam['PO_LINK']			= $strPoLink;
		$aryParam['PO_LINK_TYPE']		= $strPoLinkType;
		$aryParam['PO_LEFT']			= $strPoLeft;
		$aryParam['PO_TOP']				= $strPoTop;
		$aryParam['PO_FILE']			= $strPoFile;
		$aryParam['PO_LANG']			= $strPoLang;
		$aryParam['PO_START_DT']		= $strPoStartDT;
		$aryParam['PO_END_DT']			= $strPoEndDT;
		$aryParam['PO_USE']				= $strPoUse;
		$aryParam['PO_MOD_DT']			= "NOW()";
		$aryParam['PO_MOD_NO']			= $intModNO;

/*
2015.03.18 bdcho
:팝업 관리 항목 추가
{{
*/
		$aryParam['PO_IS_WEB']			= ($strPoSection == "") ? "1" : $strPoSection;
/*
}}
2015.03.18 bdcho
:팝업 관리 항목 추가
*/	

		$re								= $objPopupMgrModule->getPopupMgrUpdateEx($aryParam);

		## 마무리
		$result['__STATE__']			= "SUCCESS";
	break;

	case "popupDelete":
		// 팝업관리 삭제

		## 모듈 선언
		$objPopupMgrModule			= new PopupMgrModule($db);

		## 기본설정
		$intPoNo					= $_POST['po_no'];
		$strDefaultDir				= SHOP_HOME . "/upload/popup";
		$strWebDir					= "/upload/popup";

		## 데이터 불러오기
		$aryParam						= "";
		$aryParam['PO_NO']				= $intPoNo;
		$aryPopupRow					= $objPopupMgrModule->getPopupMgrSelectEx("OP_SELECT", $aryParam);
		$strOrgPoFile					= $aryPopupRow['PO_FILE'];

		## 파일 삭제
		$strDeleteFile					= $strOrgPoFile;
		$strDeleteFile					= "{$strDefaultDir}/{$strDeleteFile}";
		FileDevice::fileDelete($strDeleteFile);

		## 데이터 삭제
		$aryParam						= "";
		$aryParam['PO_NO']				= $intPoNo;
		$re								= $objPopupMgrModule->getPopupMgrDeleteEx($aryParam);

		## 마무리
		$result['__STATE__']			= "SUCCESS";
	break;
	endswitch;