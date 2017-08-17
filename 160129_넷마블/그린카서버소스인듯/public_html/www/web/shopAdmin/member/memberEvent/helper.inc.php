<?
	require_once MALL_CONF_LIB."MemberAdmMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";

	$memberMgr = new MemberMgr();
	$siteMgr = new SiteMgr();

	/*##################################### Parameter 셋팅 #####################################*/
	require_once "basic.param.inc.php";

	$siteRow = $siteMgr->getSiteInfo($db);
	/*##################################### Parameter 셋팅 #####################################*/

	switch($strMode){
		case "memberEvent":

			$row = $siteMgr->getSiteInfoView($db);
			
		break;


	}
?>