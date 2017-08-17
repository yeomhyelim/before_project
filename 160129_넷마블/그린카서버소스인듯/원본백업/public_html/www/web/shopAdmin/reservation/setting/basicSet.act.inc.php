<?
	require_once MALL_CONF_LIB."SiteMgr.php";
	require_once MALL_CONF_LIB."ReservationMgr.php";

	require_once MALL_HOME."/web/shopAdmin/basic/_function.lib.inc.php";

	$siteMgr = new SiteMgr();
	$reservationMgr = new ReservationMgr();

	$intNum = $_POST['no'];

	/*############################################ Parameter 셋팅 #################################################*/
	$strServiceOn			= $_POST["serviceon"]			? $_POST["serviceon"]			: $_REQUEST["serviceon"];
	$strReserDays			= $_POST["reser_days"]			? $_POST["reser_days"]			: $_REQUEST["reser_days"];
	$strHour				= $_POST["hour"]				? $_POST["hour"]				: $_REQUEST["hour"];
	$strPercent				= $_POST["percent"]				? $_POST["percent"]				: $_REQUEST["percent"];
	$strCheckbox1			= $_POST["checkbox1"]			? $_POST["checkbox1"]			: $_REQUEST["checkbox1"];
	$strCheckbox2			= $_POST["checkbox2"]			? $_POST["checkbox2"]			: $_REQUEST["checkbox2"];
	$strCheckin				= $_POST["checkin"]				? $_POST["checkin"]				: $_REQUEST["checkin"];
	$strCheckOut			= $_POST["checkout"]			? $_POST["checkout"]			: $_REQUEST["checkout"];
	$strIntime				= $_POST["intime"]				? $_POST["intime"]				: $_REQUEST["intime"];
	$strOuttime				= $_POST["outtime"]				? $_POST["outtime"]				: $_REQUEST["outtime"];
	$strReser_days			= $_POST["reser_days"]			? $_POST["reser_days"]			: $_REQUEST["reser_days"];
	$strCheck_days			= $_POST["check_days"]			? $_POST["check_days"]			: $_REQUEST["check_days"];
	$strCheckbox3			= $_POST["checkbox3"]			? $_POST["checkbox3"]			: $_REQUEST["checkbox3"];
	$strCheckbox4			= $_POST["checkbox4"]			? $_POST["checkbox4"]			: $_REQUEST["checkbox4"];
	$strCheckbox5			= $_POST["checkbox5"]			? $_POST["checkbox5"]			: $_REQUEST["checkbox5"];
	$strUse					= $_POST["use"]					? $_POST["use"]					: $_REQUEST["use"];

	/*############################################## Parameter 셋팅 #################################################*/



	switch($strAct){

		case "basicSetSave":

			// 관리자 페이지 -> 기본정보 -> 데이터 수정(업데이트) 작업 진행
			$aryData[0]["column"]	= "S_REV_SERVICE";
			$aryData[0]["value"]	= $strServiceOn;

			$aryData[1]["column"]	= "S_REV_RESDAYS";
			$aryData[1]["value"]	= $strReserDays;

			$aryData[2]["column"]	= "S_REV_HOUR";
			$aryData[2]["value"]	= $strHour;

			$aryData[3]["column"]	= "S_REV_PERCENT";
			$aryData[3]["value"]	= $strPercent;

			$aryData[4]["column"]	= "S_REV_CANCLE";
			$aryData[4]["value"]	= $strCheckbox1;

			$aryData[5]["column"]	= "S_REV_PAY";
			$aryData[5]["value"]	= $strCheckbox2;

			$aryData[6]["column"]	= "S_REV_CHECKIN";
			$aryData[6]["value"]	= $strCheckin;

			$aryData[6]["column"]	= "S_REV_CHECKOUT";
			$aryData[6]["value"]	= $strCheckOut;

			$aryData[7]["column"]	= "S_REV_INTIME";
			$aryData[7]["value"]	= $strIntime;

			$aryData[8]["column"]	= "S_REV_OUTTIME";
			$aryData[8]["value"]	= $strOuttime;

			$aryData[9]["column"]	= "S_REV_DAYS";
			$aryData[9]["value"]	= $strReser_days;

			$aryData[10]["column"]	= "S_REV_CHECKDAYS";
			$aryData[10]["value"]	= $strCheck_days;

			$aryData[11]["column"]	= "S_REV_FRIDAY";
			$aryData[11]["value"]	= $strCheckbox3;

			$aryData[12]["column"]	= "S_REV_SATURDAY";
			$aryData[12]["value"]	= $strCheckbox4;

			$aryData[13]["column"]	= "S_REV_SUNDAY";
			$aryData[13]["value"]	= $strCheckbox5;

			$aryData[14]["column"]	= "S_REV_USE";
			$aryData[14]["value"]	= $strUse;

			shopInfoInsertUpdate($siteMgr,$aryData); //서버 정보를 입력

			$strTNoList = "";

			foreach($_POST['searchRegStartDt'] as $Key => $data){

				$hiddenNo												= $_POST['hiddenNo'][$Key];
				$strStartDt												= $_POST['searchRegStartDt'][$Key];
				$strEndDt												= $_POST['searchRegEndDt'][$Key];

				if($data){

				$param													= "";
				$param['T_START_DT']									= $strStartDt;
				$param['T_END_DT']										= $strEndDt;
				$param['T_REG_DT']										= date("Y-m-d H:i:s");
				$param['T_REG_NO']										= $a_admin_no;
				$param['T_TYPE']										= "2";

				if(!$hiddenNo){
				$reservationMgr->getInsertTime($db,$param);
				}
				if($hiddenNo){

				$param['T_NO']											= $hiddenNo;
				$param['T_MOD_DT']										= date("Y-m-d H:i:s");
				$param['T_MOD_NO']										= $a_admin_no;

				$reservationMgr->getUpdateTime($db,$param);
				}

				}
			}

			foreach($_POST['searchRegStart_Dt'] as $Key => $data){

				$hidden_No												= $_POST['hidden_No'][$Key];
				$strStartDt												= $_POST['searchRegStart_Dt'][$Key];
				$strEndDt												= $_POST['searchRegEnd_Dt'][$Key];

				if($data){

				$param													= "";
				$param['T_START_DT']									= $strStartDt;
				$param['T_END_DT']										= $strEndDt;
				$param['T_REG_DT']										= date("Y-m-d H:i:s");
				$param['T_REG_NO']										= $a_admin_no;
				$param['T_TYPE']										= "1";

				if(!$hidden_No){
				$reservationMgr->getInsertTime($db,$param);
				}
				if($hidden_No){

				$param['T_NO']											= $hidden_No;
				$param['T_MOD_DT']										= date("Y-m-d H:i:s");
				$param['T_MOD_NO']										= $a_admin_no;

				$reservationMgr->getUpdateTime2($db,$param);
				}

				}
			}

//			include MALL_HOME."/web/shopAdmin/basic/shopMakeFile.php";

			$strMsg = $LNG_TRANS_CHAR["CS00002"]; //"저장되었습니다.";

			$strUrl = "./?menuType=".$strMenuType."&mode=basicSet".$strLinkPage;

		break;

		case "timeDelete":

			$param				= "";
			$param['T_NO']		= $intNum;

			$reservationMgr->getTimeDelete($db,$param);

			$strUrl = "./?menuType=".$strMenuType."&mode=basicSet".$strLinkPage;
		break;
	}

	$db->disConnect();

	goUrl($strMsg,$strUrl);
?>