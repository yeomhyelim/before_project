<?
	require_once MALL_CONF_LIB."SiteMgr.php";
	require_once MALL_CONF_LIB."ReservationMgr.php";

	require_once MALL_HOME."/web/shopAdmin/basic/_function.lib.inc.php";

	$siteMgr = new SiteMgr();
	$reservationMgr = new ReservationMgr();

	/*############################################# Parameter 셋팅 #############################################*/
	$strAmRanking			= $_POST["am_ranking"]			? $_POST["am_ranking"]			: $_REQUEST["am_ranking"];
	$strAmName				= $_POST["am_name"]				? $_POST["am_name"]				: $_REQUEST["am_name"];
	$strAmPrice				= $_POST["am_price"]			? $_POST["am_price"]			: $_REQUEST["am_price"];
	$strAmUnit				= $_POST["am_unit"]				? $_POST["am_unit"]				: $_REQUEST["am_unit"];
	$strAmMemo				= $_POST["am_memo"]				? $_POST["am_memo"]				: $_REQUEST["am_memo"];

	$strAmRanking2			= $_POST["am_ranking2"]			? $_POST["am_ranking2"]			: $_REQUEST["am_ranking2"];
	$strAmName2				= $_POST["am_name2"]			? $_POST["am_name2"]			: $_REQUEST["am_name2"];
	/*############################################# Parameter 셋팅 #############################################*/


	switch($strAct){

		case "roomSetEtcWrite":

			$param				= "";
			$param['AM_ORDER']	= $strAmRanking;
			$param['AM_TYPE']	= "부대시설";
			$param['AM_PRICE']	= $strAmPrice;
			$param['AM_UNIT']	= $strAmUnit;
			$param['AM_MEMO']	= $strAmMemo;
			$param['AM_DEV']	= $strAmName;
			$param['AM_REG_DT']	= date("Y-m-d");
			$param['AM_REG_NO']	= $a_admin_no;

			$reservationMgr->getRoomSetEtcInsert($db,$param);

			$strMsg = $LNG_TRANS_CHAR["CS00002"]; //"저장되었습니다.";

			$strUrl = "./?menuType=".$strMenuType."&mode=roomSetEtc";

			echo "<script language='javascript'>alert('부대시설 등록이 완료되었습니다.');parent.location.reload();</script>";
			exit;
		break;

		case "roomTypeSetWrite":

			$param				= "";
			$param['AM_ORDER']	= $strAmRanking2;
			$param['AM_TYPE']	= "객실유형";
			$param['AM_DEV']	= $strAmName2;
			$param['AM_REG_DT']	= date("Y-m-d");
			$param['AM_REG_NO']	= $a_admin_no;

			$reservationMgr->getRoomSetEtcInsert2($db,$param);

			$strMsg = $LNG_TRANS_CHAR["CS00002"]; //"저장되었습니다.";

			echo "<script language='javascript'>alert('객실유형 등록이 완료되었습니다.');parent.location.reload();</script>";
			exit;

		break;

		case "roomSetEtcModify":

			$intNo				= $_POST['no'];

			$param				= "";
			$param['AM_NO']		= $intNo;
			$param['AM_ORDER']	= $strAmRanking;
			$param['AM_TYPE']	= "부대시설";
			$param['AM_PRICE']	= $strAmPrice;
			$param['AM_UNIT']	= $strAmUnit;
			$param['AM_MEMO']	= $strAmMemo;
			$param['AM_DEV']	= $strAmName;
			$param['AM_MOD_DT']	= date("Y-m-d");
			$param['AM_MOD_NO']	= $a_admin_no;

			$reservationMgr->getRoomSetEtcUpdate($db,$param);

			$strMsg = $LNG_TRANS_CHAR["CS00002"]; //"저장되었습니다.";

			$strUrl = "./?menuType=".$strMenuType."&mode=roomSetEtc";

			echo "<script language='javascript'>alert('부대시설 수정이 완료되었습니다.');parent.location.reload();</script>";
			exit;
		break;

		case "poproomTypeSetModify":

			$intNo				= $_POST['no'];

			$param				= "";
			$param['AM_NO']		= $intNo;
			$param['AM_ORDER']	= $strAmRanking2;
			$param['AM_TYPE']	= "객실유형";
			$param['AM_DEV']	= $strAmName2;
			$param['AM_MOD_DT']	= date("Y-m-d");
			$param['AM_MOD_NO']	= $a_admin_no;

			$reservationMgr->getRoomSetEtcUpdate2($db,$param);

			$strMsg = $LNG_TRANS_CHAR["CS00002"]; //"저장되었습니다.";

			$strUrl = "./?menuType=".$strMenuType."&mode=roomSetEtc";

			echo "<script language='javascript'>alert('객실유형 수정이 완료되었습니다.');parent.location.reload();</script>";
			exit;
		break;

		case "addsetDelete":

			$param				= "";
			$param['AM_NO']		= $_POST['no'];

			$reservationMgr->getAddSetDelete($db,$param);

			$strMsg = "시설 데이터가 삭제되었습니다.";
			$strUrl = "./?menuType=reservation&mode=roomSetEtc";

		break;

		$db->disConnect();

		goUrl($strMsg,$strUrl);
	}
?>