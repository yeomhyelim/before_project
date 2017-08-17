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
		case "setting":
			
			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "003";
			$strLeftMenuCode02 = "001";
			/* 관리자 Sub Menu 권한 설정 */
			$row = $memberMgr->getSettingView($db);
			$aryMemberGroup = $memberMgr->getGroupList($db);

		break;

		case "joinItem":
			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "";
			$strLeftMenuCode02 = "";
			/* 관리자 Sub Menu 권한 설정 */

			/* 사용자 항목 */
			$memberMgr->setJI_GB("U");
			$aryUserItemList = $memberMgr->getJoinItemList($db);
			
			/* 사업자 항목 */
			$memberMgr->setJI_GB("S");
			$aryBusiItemList = $memberMgr->getJoinItemList($db);

			/* 추가 항목 */
			$memberMgr->setJI_GB("A");
			$aryAddItemList = $memberMgr->getJoinItemList($db);

			/* 사용자생성 임시 항목 */
			$memberMgr->setJI_GB("T");
			$aryTempItemList = $memberMgr->getJoinItemList($db);

			/* 외국인 항목 */
			$memberMgr->setJI_GB("F");
			$aryForItemList = $memberMgr->getJoinItemList($db);
			
			/* 회원그룹 */
			$aryMemberGroup = $memberMgr->getGroupList($db);

			/* 사용중인 나라 */
			$aryUseLng = explode("/",$siteRow[S_USE_LNG]);

		break;


	}
?>