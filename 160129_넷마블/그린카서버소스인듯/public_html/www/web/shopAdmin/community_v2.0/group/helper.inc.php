<?php

	switch($strMode):
	
	case "groupList":
		// 커뮤니티 그룹 리스트
		
		## 모듈 설정
		$objBoardGroupNewModule = new BoardGroupNewModule($db);

		## 기본 설정
		$strLang = $strStLng;
		$intPage = $_GET['page'];
		$strStLang = $S_ST_LNG;
		$strOrderBy = $_GET['orderBy'];
		$strLangLower = strtolower($strLang);
		$strWebDir = "/upload/community/group";
		if(!$strOrderBy) { $strOrderBy = "sortAsc"; }
		
		## 데이터 불러오기
		$param								= "";
		$param['LNG']					= $strLang;
		$param['S_ST_LNG']				= $strStLang;
		$intTotal						= $objBoardGroupNewModule->getBoardGroupNewLngSelectEx("OP_COUNT", $param);			// 데이터 전체 개수 
		$intPageLine					= ( $intPageLine )		? $intPageLine	: 100;										// 리스트 개수 
		$intPage						= ( $intPage )			? $intPage		: 1;
		$intFirst						= ( $intTotal == 0 )		? 0					: $intPageLine * ( $intPage - 1 );

		$param['ORDER_BY']				= $strOrderBy;
		$param['LIMIT']					= "{$intFirst},{$intPageLine}";
		$resResult						= $objBoardGroupNewModule->getBoardGroupNewLngSelectEx("OP_LIST", $param);
		$intPageBlock					= $strPageBlock;																	// 블럭 개수 
		$intListNum						= $intTotal - ( $intPageLine * ( $intPage - 1 ) );									// 번호
		$intTotPage						= ceil( $intTotal / $intPageLine );
//		echo $db->query;

		## paging 설정
		$intPage			= $intPage;									// 현재 페이지
		$intTotPage			= $intTotPage;								// 전체 페이지 수
		$intTotBlock		= ceil($intTotPage / $intPageBlock);		// 전체 블럭 수
		$intBlock			= ceil($intPage / $intPageBlock);			// 현재 블럭
		$intPrevBlock		= (($intBlock - 2) * $intPageBlock) + 1;	// 이전 블럭
		$intNextBlock		= ($intBlock * $intPageBlock) + 1;			// 다음 블럭
		$intFirstBlock		= (($intBlock - 1) * $intPageBlock) + 1;	// 현재 블럭 시작 시저
		$intLastBlock		= $intBlock * $intPageBlock;				// 현재 블럭 종료 시점
		if($intFirstBlock <= 0) { $intFirstBlock	= 1; }
		if($intPrevBlock  <= 0) { $intPrevBlock		= 1; }
		if($intNextBlock >= $intTotPage) { $intNextBlock	= $intTotPage; }
		if($intLastBlock >= $intTotPage) { $intLastBlock	= $intTotPage; }

		## 페이지 시작/마지막 번호 설정
		$intFirstNo			= ($intPage <= 1) ? $intPage : (($intPage - 1) * $intPageLine);
		$intLastNo			= $intPage * $intPageLine;
		if(!$intFirstNo) { $intFirstNo = ""; }
		if($intLastNo > $intTotal) { $intLastNo = $intTotal; }
	break;

	endswitch;