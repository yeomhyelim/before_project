<?php

	switch($strAct):
	
	case "boardIconWrite":
		// 아이콘 등록

		## 모듈 설정
		$objBoardIcon	= new BoardIconModule($db);
		
		## 기본 설정
		$strB_CODE		= $_POST['b_code'];
		$strIconName	= $_POST['iconName'];
		$strCheck		= $_POST['check'];

		## 기본 설정 체크
		if(!$strB_CODE):
			$result['__STATE__']		= "NO_B_CODE";
			$result['__MSG__']			= "선택된 게시판이 없습니다.";
			break;			
		endif;
		if(!$strIconName):
			$result['__STATE__']		= "NO_ICON_NAME";
			$result['__MSG__']			= "아이콘 정보가 없습니다.";
			break;			
		endif;
		if(!$strCheck):
			$result['__STATE__']		= "NO_CHECK";
			$result['__MSG__']			= "저장할 게시글이 없습니다.";
			break;			
		endif;

		## 데이터 저장
		$aryCheck						= explode(",", $strCheck);
		foreach($aryCheck as $intUB_NO):
			
			## 등록된 데이터 개수 체크 
			$param						= "";
			$param['BI_ICON']			= $strIconName;
			$param['BI_B_CODE']			= $strB_CODE;
			$param['BI_UB_NO']			= $intUB_NO;
			$intTotal					= $objBoardIcon->getBoardIconSelectEx("OP_COUNT", $param);
			if($intTotal > 0) { continue; }

			## 저장
			$param						= "";
			$param['BI_ICON']			= $strIconName;
			$param['BI_B_CODE']			= $strB_CODE;
			$param['BI_UB_NO']			= $intUB_NO;
			$param['BI_SORT']			= "10000";
			$objBoardIcon->getBoardIconInsertEx($param);
		endforeach;

		## 마무리
		$result['__STATE__']			= "SUCCESS";
	break;

	case "boardIconDelete":
		// 아이콘 삭제

		## 모듈 설정
		$objBoardIcon	= new BoardIconModule($db);
		
		## 기본 설정
		$intNo			= $_POST['no'];

		## 기본 설정 체크
		if(!$intNo):
			$result['__STATE__']		= "NO_NO";
			$result['__MSG__']			= "삭제할 정보가 없습니다.";
			break;			
		endif;

		## 데이터 삭제
		$param						= "";
		$param['BI_NO']				= $intNo;
		$objBoardIcon->getBoardIconDeleteEx($param);

		## 마무리
		$result['__STATE__']			= "SUCCESS";

	break;

	endswitch;