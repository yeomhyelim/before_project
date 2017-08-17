<?
	$strAppBCode = $_GET['b_code'];
	## 언어 설정
	$strLang = $S_SITE_LNG;
	$strLangS = $S_ST_LNG;
	$strLangLower = strtolower($strLang);
	$strLangSLower = strtolower($strLangS);

	## 커뮤니티 보드 설정
	$aryAppBoardInfo = $EUMSHOP_APP_INFO['boardInfo'];
	if(!$aryAppBoardInfo):
		include_once rtrim(MALL_SHOP, '/') . "/conf/community/{$strLangLower}/board.{$strAppBCode}.info.php";
		$aryAppBoardInfo = $BOARD_INFO[$strAppBCode];
		include_once rtrim(MALL_SHOP, '/') . "/conf/community/{$strLangSLower}/board.{$strAppBCode}.info.php";
		$aryAppBoardInfoS = $BOARD_INFO[$strAppBCode];
		foreach($aryAppBoardInfoS as $key => $data):
			$strTemp = $aryAppBoardInfo[$key];
			if($strTemp) { continue; }
			$aryAppBoardInfo[$key] = $data;
		endforeach;
	endif;
	## 기본설정
	$strAppB_NAME				=  $aryAppBoardInfo['B_NAME'];
?>

<div class="communityArea">
	<h2 class="app-title"><?php echo $strAppB_NAME;?></h2>
	<!--h2 class="app-title" appID="COMMUNITY_WRITE"></h2-->
	<?php
	$EUMSHOP_APP_INFO				= "";
	$EUMSHOP_APP_INFO['appID']		= "COMMUNITY_WRITE";
	$EUMSHOP_APP_INFO['name']		= "커뮤니티작성페이지";
	$EUMSHOP_APP_INFO['mode']		= "communityWrite";
	$EUMSHOP_APP_INFO['skin']		= "mobileSkin";
	$EUMSHOP_APP_INFO['b_code']		= $_GET['b_code'];
	include "{$S_DOCUMENT_ROOT}www/web/app/index.php";	
	?>
</div>