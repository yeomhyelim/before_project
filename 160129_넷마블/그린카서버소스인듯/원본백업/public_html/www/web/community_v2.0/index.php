<?php
	/**
	 * eumshop community
	 *
	 * eumshop app application development framework for PHP 5.1.6 or newer
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 2.0
	 * @filesource	/www/web/community_v2.0/index.php
 	 * @note		1. 소스를 정리한다.
	 *				2. 다국어 버전을 지원한다.
	 * @history
	 *				2014.07.14 kim hee sung - dev
	 */

	## 액션
	if($strMode == "act" || $strMode == "json"):
		include dirname(__FILE__) . "/{$strMode}.php";
		exit;
	endif;

	## 기본 설정
	$strMode = $_GET['mode'];
	$strBCode = $_GET['b_code'];
	$strPCode = $_GET['p_code'];
	$intUbNo = $_GET['ubNo'];
	$strMyTarget = $_GET['myTarget']; // mypage
	$strLayout = $_GET['layout'];
	$strLang = $S_SITE_LNG;
	$strLangS = $S_ST_LNG;
	$strLangLower = strtolower($strLang);
	$strLangSLower = strtolower($strLangS);
	$strCommunityConfDir = MALL_SHOP . "/conf/community";
	$strCommunityConfFile = "board.{$strBCode}.info.php";
	$intMemberNo = $g_member_no;
	if(!$intUbNo) { $intUbNo = $_GET['ub_no']; } // 구버전에서 ub_no로 사용을합니다.(communityWidget);

	## 체크
	if(!$strBCode):
		goUrl($LNG_TRANS_CHAR["MS00100"], "/"); // 잘못된 경로입니다. 메인으로 이동합니다.
		exit;
	endif;

	## myTarget 이 mypage 이면, 자신의 글만 가져옵니다.
	if($strMyTarget == "mypage") { $intAnsMemberNo = $intMemberNo; }

	## 커뮤니티 설정 파일
	include_once "{$strCommunityConfDir}/{$strLangLower}/{$strCommunityConfFile}";
	$aryBoardInfo = $BOARD_INFO[$strBCode];
	include_once "{$strCommunityConfDir}/{$strLangSLower}/{$strCommunityConfFile}";
	$aryBoardInfoS = $BOARD_INFO[$strBCode];
	foreach($aryBoardInfoS as $key => $data):
		$strTemp = $aryBoardInfo[$key];
		if($strTemp) { continue; }
		$aryBoardInfo[$key] = $data;
	endforeach;
	$strBI_START_MODE	= empty ( $aryBoardInfo['BI_START_MODE'] ) ? 'dataList' : $aryBoardInfo['BI_START_MODE']  ;
	$strB_KIND_SKIN		= $aryBoardInfo['B_KIND_SKIN'];
// 2014.12.22 kim hee sung 이곳에 리스트 개수값을 추가하면, 관리자페이지에서 설정값을 사용할수 없습니다.
//	$aryBoardInfo['BI_LIST_DEFAULT'] = 1 ;
	$strB_NAME			= $aryBoardInfo['B_NAME'];



	## 스킨 설정
	list($strKind, $strSkin) = explode("_", $strB_KIND_SKIN);
	$strSkinName = $strKind . ucfirst($strSkin) . "Skin";

	## 시작 페이지 설정
	if(!$strMode) { $strMode = $strBI_START_MODE; }

	## 페이지 분류
	$aryIncludeFolder = array(   "dataList"				=> "data",
								 "dataWrite"			=> "data",
								 "dataView"				=> "data",
								 "dataModify"			=> "data",
								 "dataPassword"			=> "data",
								 "dataAnswer"			=> "data",

						);

	## include file 설정
	$includeFile = MALL_HOME . "/web/community_v2.0/{$aryIncludeFolder[$strMode]}/{$strMode}.php";
//	echo $includeFile;

	## layout 설정
	if(!$strLayout) { $strLayout = "default"; }
	include_once "layout-{$strLayout}.php";
