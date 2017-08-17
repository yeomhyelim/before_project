<?
	switch($strAct):
	case "popupWrite":
		// 팝업 등록

		## 파일 복사
		require_once "{$S_DOCUMENT_ROOT}www/classes/file/file.handler.class.php";
		$file							= new FileHandler();
		$folder							= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/upload/popup/";
		$aryUpLoadInfo					= "";
		$aryUpLoadInfo['F_NAME']		= "po_file";		// input tag name
		$aryUpLoadInfo['F_FILTER']		= "gif;jpg;png";	// 업로드 가능한 확장자 설정
		$aryUpLoadInfo['F_SPATH']		= $folder;			// 서버에 저장할 폴더 경로(절대 경로) // ex. {$this->field['S_DOCUMENT_ROOT']}{$this->field['S_SHOP_HOME']}/upload/community/temp/
		$aryUpLoadInfo['F_SFNAME']		= "";				// 파일명( 없는 경우 자동 생성 :년월일시분초_파일명.확장자) 
		$aryUpLoadInfo['F_SECTION']		= "";				// 파일명 생성시 추가 부분
		$aryUpLoadInfo['F_NUM']			= "";				// 파일 배열 선택
		$re								= $file->getFileUpload($aryUpLoadInfo);
		$poFile							= $aryUpLoadInfo['F_SFNAME'];
		
		## 설정
		require_once MALL_CONF_LIB."PopupMgr.php";
		$popupMgr	= new PopupMgr();

		## insert
		$param					= "";
		$param['PO_TYPE']		= $_POST['po_type'];
		$param['P_NO']			= 0;
		$param['PO_LINK']		= $_POST['po_link'];
		$param['PO_TITLE']		= $_POST['po_title'];
		$param['PO_LEFT']		= $_POST['po_left'];
		$param['PO_TOP']		= $_POST['po_top'];
		$param['PO_FILE']		= $poFile;
		$param['PO_START_DT']	= $_POST['po_start_dt'];
		$param['PO_END_DT']		= $_POST['po_end_dt'];
		$param['PO_VIEW']		= $_POST['po_view'];
		$re						= $popupMgr->getPopupInsertEx($db, $param);

		## 이동
		$strUrl					= "./?menuType=operNew&mode=popupList";
	break;
	case "popupModify":
		// 팝업 수정
		
		## 파일 복사
		require_once "{$S_DOCUMENT_ROOT}www/classes/file/file.handler.class.php";
		$file							= new FileHandler();
		$folder							= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/upload/popup/";
		$aryUpLoadInfo					= "";
		$aryUpLoadInfo['F_NAME']		= "po_file";		// input tag name
		$aryUpLoadInfo['F_FILTER']		= "gif;jpg;png";	// 업로드 가능한 확장자 설정
		$aryUpLoadInfo['F_SPATH']		= $folder;			// 서버에 저장할 폴더 경로(절대 경로) // ex. {$this->field['S_DOCUMENT_ROOT']}{$this->field['S_SHOP_HOME']}/upload/community/temp/
		$aryUpLoadInfo['F_SFNAME']		= "";				// 파일명( 없는 경우 자동 생성 :년월일시분초_파일명.확장자) 
		$aryUpLoadInfo['F_SECTION']		= "";				// 파일명 생성시 추가 부분
		$aryUpLoadInfo['F_NUM']			= "";				// 파일 배열 선택
		$re								= $file->getFileUpload($aryUpLoadInfo);
		$poFile							= $aryUpLoadInfo['F_SFNAME'];

		## 설정
		require_once MALL_CONF_LIB."PopupMgr.php";
		$popupMgr	= new PopupMgr();

		## 체크
		if(!$_POST['po_no']):
			echo "변경할 대상자가 없습니다.";
			exit;
		endif;

		## 기존 자료 불러오기
		$param					= "";
		$param['PO_NO']			= $_POST['po_no'];
		$popupRow				= $popupMgr->getPopupListEx($db, "OP_SELECT", $param);

		## 파일 삭제
		$folder					= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/upload/popup/";
		if($popupRow['PO_FILE']):
			if($_POST['po_file_delete'] == "Y" || $poFile):
				unlink("{$folder}{$popupRow['PO_FILE']}");
			else:
				$poFile = $popupRow['PO_FILE'];
			endif;
		endif;

		## update
		$param					= "";
		$param['PO_NO']			= $_POST['po_no'];
		$param['PO_TYPE']		= $_POST['po_type'];
		$param['P_NO']			= 0;
		$param['PO_LINK']		= $_POST['po_link'];
		$param['PO_TITLE']		= $_POST['po_title'];
		$param['PO_LEFT']		= $_POST['po_left'];
		$param['PO_TOP']		= $_POST['po_top'];
		$param['PO_FILE']		= $poFile;
		$param['PO_START_DT']	= $_POST['po_start_dt'];
		$param['PO_END_DT']		= $_POST['po_end_dt'];
		$param['PO_VIEW']		= $_POST['po_view'];
		$re						= $popupMgr->getPopupUpdateEx($db, $param);
	
		## 이동
		$strUrl					= "?menuType=operNew&mode=popupModify&po_no={$_POST['po_no']}";
	break;
	case "popupDelete":
		// 삭제

		## 설정
		require_once MALL_CONF_LIB."PopupMgr.php";
		$popupMgr	= new PopupMgr();

		## 기존 자료 불러오기
		$param					= "";
		$param['PO_NO']			= $_POST['po_no'];
		$popupRow				= $popupMgr->getPopupListEx($db, "OP_SELECT", $param);
		
		## 파일 삭제
		$folder					= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/upload/popup/";
		if($popupRow['PO_FILE']):
			unlink("{$folder}{$popupRow['PO_FILE']}");
		endif;

		## 삭제
		$param					= "";
		$param['PO_NO']			= $_POST['po_no'];
		$re						= $popupMgr->gePopuptDeleteEx($db, $param);

		## 이동
		$strUrl					= "./?menuType=operNew&mode=popupList";
	break;
	endswitch;	
?>