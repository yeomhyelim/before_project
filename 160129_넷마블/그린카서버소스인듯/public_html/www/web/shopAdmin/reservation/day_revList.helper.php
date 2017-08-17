<?php
	require_once MALL_CONF_LIB."ReservationMgr.php";

	$reservationMgr = new ReservationMgr();

	$intPage = $_GET['page'];
	$strType = $_GET['type'];

	$strSearchField		= $_GET['searchField'];
	$strSearchKey		= $_GET['searchKey'];
	$strSearchGroup		= $_GET['searchGroup'];
	$strSearchSDt		= $_GET['searchRegStartDt'];
	$strSearchEDt		= $_GET['searchRegEndDt'];

	$strGroup			= explode(",",$strSearchGroup);

	if($strSearchField==""){
	$intResrvCount = $reservationMgr->getRservCount($db);
	}else{
		if($strSearchField=="all"){
			if($strSearchSDt){
				if($strSearchGroup){
					//검색필드는 전체이며, 검색시간 조건이 있으며, 예약상태가 있는 경우
					$intResrvCount   = $reservationMgr->getRservCount5($db,$strSearchSDt,$strSearchEDt,$strSearchGroup,$strSearchKey);
				}else{
					//검색필드는 전체이며, 검색시간 조건이 있으며, 예약상태는 없는 경우
					$intResrvCount   = $reservationMgr->getRservCount4($db,$strSearchSDt,$strSearchEDt,$strSearchKey);
				}
			}else{
				if($strSearchGroup){
					//검색필드는 전체이며, 검색시간 조건이 없으며, 예약상태가 있는 경우
					$intResrvCount   = $reservationMgr->getRservCount3($db,$strSearchGroup);
				}else{
					//검색필드는 전체이며, 검색시간 조건이 없으며, 예약상태가 없는 경우
					$intResrvCount = $reservationMgr->getRservCount6($db,$intStartNo,$intEndNo,$strSearchKey);
				}
			}

		}else{
			if($strSearchSDt){
				if($strSearchGroup){
					//검색필드는 특정된것이고, 검색시간 조건이 있으며, 예약상태는 있는 경우
					$intResrvCount   = $reservationMgr->getRservCount7($db,$strSearchSDt,$strSearchEDt,$strSearchGroup,$strSearchKey,$strSearchField);
				}else{
					//검색필드는 특정된것이고, 검색시간 조건이 있으며, 예약상태는 없는 경우
					$intResrvCount   = $reservationMgr->getRservCount8($db,$strSearchSDt,$strSearchEDt,$strSearchKey,$strSearchField);
				}
			}else{
				if($strSearchGroup){
					//검색필드는 특정된것이고, 검색시간 조건이 없으며, 예약상태는 있는 경우
					$intResrvCount   = $reservationMgr->getRservCount9($db,$strSearchGroup,$strSearchKey,$strSearchField,$strSearchField);
				}else{
					//검색필드는 특정된것이고, 검색시간 조건이 없으며, 예약상태는 없는 경우
					$intResrvCount   = $reservationMgr->getRservCount10($db,$intStartNo,$intEndNo,$strSearchKey,$strSearchField);
				}
			}
		}
	}


	$intTotal						= $intResrvCount;
	$intPageLine					= ( $intPageLine )			? $intPageLine		: 10;								// 리스트 개수
	$intPage						= ( $intPage )				? $intPage			: 1;
	$intFirst						= ( $intTotal == 0 )		? 0					: $intPageLine * ( $intPage - 1 );

	$intPageBlock					= $strPageBlock;																	// 블럭 개수
	$intListNum						= $intTotal - ( $intPageLine * ( $intPage - 1 ) );									// 번호
	$intTotPage						= ceil( $intTotal / $intPageLine );


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

	$intStartNo = ($intPage -1)*$intPageLine ;
	$intEndNo   = $intPage*$intPageLine;

	## 페이지 시작/마지막 번호 설정
	$intFirstNo			= ($intPage <= 1) ? $intPage : (($intPage - 1) * $intPageLine);
	$intLastNo			= $intPage * $intPageLine;
	if(!$intFirstNo) { $intFirstNo = ""; }
	if($intLastNo > $intTotal) { $intLastNo = $intTotal; }

	## 페이징 링크 주소
	$queryString	= explode("&", $_SERVER['QUERY_STRING']);
	$linkPage		= "";
	foreach($queryString as $string):
		list($key,$val)		= explode("=", $string);
		if($key == "page")	{ continue; }
		if($linkPage)		{ $linkPage .= "&"; }
		$linkPage		   .= $string;
	endforeach;

	$linkPage		= "./?{$linkPage}&page=";

	if($strSearchField==""){
	$resultResrv   = $reservationMgr->getRserv($db,$intStartNo,$intEndNo);
	}else{
		if($strSearchField=="all"){
			if($strSearchSDt){
				if($strSearchGroup){
					//검색필드는 전체이며, 검색시간 조건이 있으며, 예약상태가 있는 경우
					$resultResrv   = $reservationMgr->getRserv5($db,$strSearchSDt,$strSearchEDt,$strSearchGroup,$strSearchKey);
				}else{
					//검색필드는 전체이며, 검색시간 조건이 있으며, 예약상태는 없는 경우
					$resultResrv   = $reservationMgr->getRserv4($db,$strSearchSDt,$strSearchEDt,$strSearchKey);
				}
			}else{
				if($strSearchGroup){
					//검색필드는 전체이며, 검색시간 조건이 없으며, 예약상태가 있는 경우
					$resultResrv   = $reservationMgr->getRserv3($db,$strSearchGroup,$strSearchKey);
				}else{
					//검색필드는 전체이며, 검색시간 조건이 없으며, 예약상태가 없는 경우
					$resultResrv   = $reservationMgr->getRserv6($db,$intStartNo,$intEndNo,$strSearchKey);
				}
			}

		}else{
			if($strSearchSDt){
				if($strSearchGroup){
					//검색필드는 특정된것이고, 검색시간 조건이 있으며, 예약상태는 있는 경우
					$resultResrv   = $reservationMgr->getRserv7($db,$strSearchSDt,$strSearchEDt,$strSearchGroup,$strSearchKey,$strSearchField);
				}else{
					//검색필드는 특정된것이고, 검색시간 조건이 있으며, 예약상태는 없는 경우
					$resultResrv   = $reservationMgr->getRserv8($db,$strSearchSDt,$strSearchEDt,$strSearchKey,$strSearchField);
				}
			}else{
				if($strSearchGroup){
					//검색필드는 특정된것이고, 검색시간 조건이 없으며, 예약상태는 있는 경우
					$resultResrv   = $reservationMgr->getRserv9($db,$strSearchGroup,$strSearchKey,$strSearchField);
				}else{
					//검색필드는 특정된것이고, 검색시간 조건이 없으며, 예약상태는 없는 경우
					$resultResrv   = $reservationMgr->getRserv10($db,$intStartNo,$intEndNo,$strSearchKey,$strSearchField);
				}
			}
		}
	}

?>