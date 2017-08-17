<?
	require_once MALL_CONF_LIB."MemberAdmMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";
	require_once MALL_CONF_LIB."memberCateMgr.php";

	$memberMgr = new MemberMgr();
	$siteMgr = new SiteMgr();
	$memberCateMgr = new MemberCateMgr();

	## 언어 설정
	$aryUseLng			= explode("/", $S_USE_LNG);

	/*##################################### Parameter 셋팅 #####################################*/

	$siteRow = $siteMgr->getSiteInfo($db);
	/*##################################### Parameter 셋팅 #####################################*/

	switch($strMode){


	}
?>