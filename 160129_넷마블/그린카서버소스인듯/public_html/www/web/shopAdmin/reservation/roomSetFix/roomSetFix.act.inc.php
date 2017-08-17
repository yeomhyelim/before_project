<?
	require_once MALL_CONF_LIB."SiteMgr.php";
	require_once MALL_CONF_LIB."ReservationMgr.php";

	require_once MALL_HOME."/web/shopAdmin/basic/_function.lib.inc.php";

	$siteMgr = new SiteMgr();
	$reservationMgr = new ReservationMgr();

	/*############################################# Parameter 셋팅 #############################################*/

	$strCgSort				= $_POST["cg_sort"]				? $_POST["cg_sort"]				: $_REQUEST["cg_sort"];
	$strCgName				= $_POST["cg_name"]				? $_POST["cg_name"]				: $_REQUEST["cg_name"];
	$strCgCord				= $_POST["cg_cord"]				? $_POST["cg_cord"]				: $_REQUEST["cg_cord"];
	$strCgUse				= $_POST["cg_use"]				? $_POST["cg_use"]				: $_REQUEST["cg_use"];

	$strCcSort				= $_POST["cc_sort"]				? $_POST["cc_sort"]				: $_REQUEST["cc_sort"];
	$strCcName				= $_POST["cc_name_kr"]			? $_POST["cc_name_kr"]			: $_REQUEST["cc_name_kr"];
	$strCcCode				= $_POST["cc_code"]				? $_POST["cc_code"]				: $_REQUEST["cc_code"];
	$strCcUse				= $_POST["cc_use"]				? $_POST["cc_use"]				: $_REQUEST["cc_use"];
	$strCgno				= $_POST["cg_no"]				? $_POST["cg_no"]				: $_REQUEST["cg_no"];

	/*############################################# Parameter 셋팅 #############################################*/


	switch($strAct){

		case "roomSetFixWrite":

			$param				= "";
			$param['CG_SORT']	= $strCgSort;
			$param['CG_NAME']	= $strCgName;
			$param['CG_CODE']	= $strCgCord;
			$param['CG_USE']	= $strCgUse;
			$param['CG_TYPE']	= "U";

			$reservationMgr->getRoomSetFixInsert($db,$param);


			$strMsg = $LNG_TRANS_CHAR["CS00002"]; //"저장되었습니다.";

			$strUrl = "./?menuType=".$strMenuType."&mode=roomSetFix";

			echo "<script language='javascript'>alert('객실시설 등록이 완료되었습니다.');parent.location.reload();</script>";
			exit;
		break;

		case "roomSetFixWrite2":

			$param					= "";
			$param['CC_SORT']		= $strCcSort;
			$param['CC_NAME_KR']	= $strCcName;
			$param['CC_CODE']		= $strCcCode;
			$param['CC_USE']		= $strCcUse;
			$param['CG_NO']			= $strCgno;

			$reservationMgr->getRoomSetFixInsert2($db,$param);


			$strMsg = $LNG_TRANS_CHAR["CS00002"]; //"저장되었습니다.";

			$strUrl = "./?menuType=".$strMenuType."&mode=roomSetFix";

			echo "<script language='javascript'>alert('하위시설 등록이 완료되었습니다.');parent.location.reload();</script>";
			exit;
		break;

		case "roomSetFixModify":

			$intNo				= $_POST['no'];

			$param				= "";
			$param['CG_NO']		= $intNo;
			$param['CG_SORT']	= $strCgSort;
			$param['CG_NAME']	= $strCgName;
			$param['CG_USE']	= $strCgUse;
			$param['CG_TYPE']	= "U";

			$reservationMgr->getRoomSetFixUpdate($db,$param);

			$strMsg = $LNG_TRANS_CHAR["CS00002"]; //"저장되었습니다.";

			$strUrl = "./?menuType=".$strMenuType."&mode=roomSetFix";

			echo "<script language='javascript'>alert('객실시설 수정이 완료되었습니다.');parent.location.reload();</script>";
			exit;
		break;

		case "roomSetFixModify2":

			$intNo				= $_POST['no'];

			$param				= "";
			$param['CC_NO']		= $intNo;
			$param['CC_SORT']	= $strCcSort;
			$param['CC_NAME_KR']= $strCcName;
			$param['CC_USE']	= $strCcUse;
			$param['CG_NO']		= $strCgno;

			$reservationMgr->getRoomSetFixUpdate2($db,$param);

			$strMsg = $LNG_TRANS_CHAR["CS00002"]; //"저장되었습니다.";

			$strUrl = "./?menuType=".$strMenuType."&mode=roomSetFix";

			echo "<script language='javascript'>alert('하위시설 수정이 완료되었습니다.');parent.location.reload();</script>";
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

		case "FixDelete":

			$param				= "";
			$param['CG_NO']		= $_POST['no'];

			$reservationMgr->getFixDelete($db,$param);
			$reservationMgr->getFixDelete2($db,$param);

			$strMsg = "시설 데이터가 삭제되었습니다.";
			$strUrl = "./?menuType=reservation&mode=roomSetFix";

		break;

		case "FixDelete2":

			$param				= "";
			$param['CC_NO']		= $_POST['no'];

			$reservationMgr->getFixDelete3($db,$param);

			$strMsg = "하위시설 데이터가 삭제되었습니다.";
			$strUrl = "./?menuType=reservation&mode=roomSetFix";

		break;

		$db->disConnect();

		goUrl($strMsg,$strUrl);
	}
?>