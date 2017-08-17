<?php

	switch($strMode):
	
	case "sliderBannerList":
		// 움직이는 배너 리스트
		
		## 모듈 설정
		$objDesignSliderBannerModule = new DesignSliderBannerModule($db);

		## 기본 설정
		$strLang = $strStLng;
		$intPage = $_GET['page'];
		$strOrderBy = $_GET['orderBy'];
		$strLangLower = strtolower($strLang);
//		$strWebDir = "/upload/community/group";
		
		## 데이터 불러오기
		$param							= "";
		$intTotal						= $objDesignSliderBannerModule->getDesignSliderBannerSelectEx("OP_COUNT", $param);	// 데이터 전체 개수 
		$intPageLine					= ( $intPageLine )			? $intPageLine		: 10;								// 리스트 개수 
		$intPage						= ( $intPage )				? $intPage			: 1;
		$intFirst						= ( $intTotal == 0 )		? 0					: $intPageLine * ( $intPage - 1 );

		$param['ORDER_BY']				= $strOrderBy;
		$param['LIMIT']					= "{$intFirst},{$intPageLine}";
		$resResult						= $objDesignSliderBannerModule->getDesignSliderBannerSelectEx("OP_LIST", $param);
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
		$intNextBlock		= ($intBlock * $intPageBlock) + 1;		// 다음 블럭
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

		## 링크타입 설정
		$aryLinkType = "";
		$aryLinkType['M'] = "현재 페이지 열기";
		$aryLinkType['B'] = "새창으로 열기";
		$aryLinkType['N'] = "연결 없음";
	break;

	case "sliderBannerModify":
		// 움직이는 배너 수정

		## 모듈 설정
		$objDesignSliderBannerModule = new DesignSliderBannerModule($db);
		$objDesignSliderBannerImgModule = new DesignSliderBannerImgModule($db);

		## 기본 설정
		$strLang = $_GET['lang'];
		$intPage = $_GET['page'];
		$intSbNo = $_GET['sb_no'];
		$strOrderBy = $_GET['orderBy'];
		if(!$strLang) { $strLang = $S_ST_LNG; }
		$strLangLower = strtolower($strLang);
		$strWebDir = "/upload/slider";
		$intIdx = 0;

		## 체크
		if(!$intSbNo):
			echo "수정할 정보가 없습니다.";
			break;
		endif;
		if(!$strLang):
			echo "수정할 언어가 없습니다.";
			break;
		endif;

		## 데이터 불러오기(슬라이더 정보)
		$param = "";
		$param['SB_NO'] = $intSbNo;
		$aryRow = $objDesignSliderBannerModule->getDesignSliderBannerSelectEx("OP_SELECT", $param);


		## 체크
		if(!$aryRow):
			echo "수정할 정보가 없습니다.";
			break;
		endif;

		## 기본 설정
		$intSB_NO				= $aryRow['SB_NO'];
		$strSB_CODE				= $aryRow['SB_CODE'];
		$strSB_COMMENT			= $aryRow['SB_COMMENT'];
		$strSB_LINK_TYPE		= $aryRow['SB_LINK_TYPE'];
		$intSB_REG_DT			= $aryRow['SB_REG_DT'];

		## 데이터 불러오기(이미지 리스트)
		$param = "";
		$param['SB_NO'] = $intSbNo;
		$param['SI_LNG'] = $strLang;
		$param['ORDER_BY'] = "noAsc";
		$aryImageRow = $objDesignSliderBannerImgModule->getDesignSliderBannerImgSelectEx("OP_ARYTOTAL", $param);
		$intImageCnt = sizeof($aryImageRow);
//		echo $db->query;

		## 관리자 메뉴 관리
		$strTopMenuCode = "002";
		$strLeftMenuCode01 = "001";
		$strLeftMenuCode02 = "005";
	break;

	endswitch;