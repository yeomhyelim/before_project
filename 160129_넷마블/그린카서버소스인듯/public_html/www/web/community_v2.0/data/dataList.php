<?php
	$EUMSHOP_APP_INFO = "";
	$EUMSHOP_APP_INFO['name'] = "커뮤니티_리스트";
	$EUMSHOP_APP_INFO['mode'] = "communityList";
	$EUMSHOP_APP_INFO['appID'] = "COMMUNITY_LIST";
	$EUMSHOP_APP_INFO['skin'] = $strSkinName;
	$EUMSHOP_APP_INFO['bCode'] = $strBCode;
	$EUMSHOP_APP_INFO['pCode'] = $strPCode;
	$EUMSHOP_APP_INFO['ansMemberNo'] = $intAnsMemberNo;
	$EUMSHOP_APP_INFO['boardInfo'] = $aryBoardInfo;
	include MALL_HOME . "/web/app/index.php";
?>