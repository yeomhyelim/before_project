<?
	require_once MALL_CONF_LIB."SiteMgr.php";
	require_once MALL_CONF_LIB."ReservationMgr.php";

	require_once MALL_HOME."/web/shopAdmin/basic/_function.lib.inc.php";

	$siteMgr = new SiteMgr();
	$reservationMgr = new ReservationMgr();

	/*############################################ Parameter 셋팅 #################################################*/
	$strRevCare				= $_POST["rev_care"]			? $_POST["rev_care"]			: $_REQUEST["rev_care"];
	$strRevPrice			= $_POST["rev_price"]			? $_POST["rev_price"]			: $_REQUEST["rev_price"];
	$strRevRefund			= $_POST["rev_refund"]			? $_POST["rev_refund"]			: $_REQUEST["rev_refund"];
	$strRevRef7				= $_POST["rev_ref_7"]			? $_POST["rev_ref_7"]			: $_REQUEST["rev_ref_7"];
	$strRevRef6				= $_POST["rev_ref_6"]			? $_POST["rev_ref_6"]			: $_REQUEST["rev_ref_6"];
	$strRevRef5				= $_POST["rev_ref_5"]			? $_POST["rev_ref_5"]			: $_REQUEST["rev_ref_5"];
	$strRevRef4				= $_POST["rev_ref_4"]			? $_POST["rev_ref_4"]			: $_REQUEST["rev_ref_4"];
	$strRevRef3				= $_POST["rev_ref_3"]			? $_POST["rev_ref_3"]			: $_REQUEST["rev_ref_3"];
	$strRevRef2				= $_POST["rev_ref_2"]			? $_POST["rev_ref_2"]			: $_REQUEST["rev_ref_2"];
	$strRevRef1				= $_POST["rev_ref_1"]			? $_POST["rev_ref_1"]			: $_REQUEST["rev_ref_1"];
	$strRevRef0				= $_POST["rev_ref_0"]			? $_POST["rev_ref_0"]			: $_REQUEST["rev_ref_0"];

	/*############################################## Parameter 셋팅 #################################################*/



	switch($strAct){

		case "roomSetPolicyWrite":

			// 예약규정설정 -> 규정정보 -> 데이터 수정(업데이트) 작업 진행

			$aryData[0]["column"]	= "S_REV_REF7";
			$aryData[0]["value"]	= $strRevRef7;

			$aryData[1]["column"]	= "S_REV_REF6";
			$aryData[1]["value"]	= $strRevRef6;

			$aryData[2]["column"]	= "S_REV_REF5";
			$aryData[2]["value"]	= $strRevRef5;

			$aryData[3]["column"]	= "S_REV_REF4";
			$aryData[3]["value"]	= $strRevRef4;

			$aryData[4]["column"]	= "S_REV_REF3";
			$aryData[4]["value"]	= $strRevRef3;

			$aryData[5]["column"]	= "S_REV_REF2";
			$aryData[5]["value"]	= $strRevRef2;

			$aryData[6]["column"]	= "S_REV_REF1";
			$aryData[6]["value"]	= $strRevRef1;

			$aryData[7]["column"]	= "S_REV_REF0";
			$aryData[7]["value"]	= $strRevRef0;

			shopInfoInsertUpdate($siteMgr,$aryData);

			$param = "";
			$param['VAL']			= $strRevCare;
			$param['S_REV_PRICE']	= $strRevPrice;
			$param['S_REV_REFUND']	= $strRevRefund;

			$reservationMgr->getSetPolicyUpdate($db,$param);
			$reservationMgr->getSetPolicyUpdate2($db,$param);
			$reservationMgr->getSetPolicyUpdate3($db,$param);

//			include MALL_HOME."/web/shopAdmin/basic/shopMakeFile.php";

			$strMsg = $LNG_TRANS_CHAR["CS00002"]; //"저장되었습니다.";

			$strUrl = "./?menuType=".$strMenuType."&mode=roomSetPolicy".$strLinkPage;

		break;
	}

	$db->disConnect();

	goUrl($strMsg,$strUrl);
?>