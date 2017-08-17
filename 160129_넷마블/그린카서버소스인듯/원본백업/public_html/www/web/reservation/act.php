<?echo
	require_once MALL_CONF_LIB."ReservationMgr.php";

	$reservationMgr = new ReservationMgr();

	/*############################################# Parameter 셋팅 #############################################*/

	$strResrvName			= $_POST["resrvName"]			? $_POST["resrvName"]			: $_REQUEST["resrvName"];
	$strResrvPhone			= $_POST["resrvPhone"]			? $_POST["resrvPhone"]			: $_REQUEST["resrvPhone"];
	$strResrvEmail			= $_POST["resrvEmail"]			? $_POST["resrvEmail"]			: $_REQUEST["resrvEmail"];
	$strResrvRequest		= $_POST["resrvRequest"]		? $_POST["resrvRequest"]		: $_REQUEST["resrvRequest"];

	$strRsvStay				= $_POST["rsvStay"]				? $_POST["rsvStay"]				: $_REQUEST["rsvStay"];
	$strYear				= $_POST["year"]				? $_POST["year"]				: $_REQUEST["year"];
	$strMonth				= $_POST["month"]				? $_POST["month"]				: $_REQUEST["month"];
	$strDay					= $_POST["day"]					? $_POST["day"]					: $_REQUEST["day"];
	$strPayCash				= $_POST["pay_cash"]			? $_POST["pay_cash"]			: $_REQUEST["pay_cash"];
	$strRoomNo				= $_POST["roomNo"]				? $_POST["roomNo"]				: $_REQUEST["roomNo"];
	$strRoomPay				= $_POST["roomPay"]				? $_POST["roomPay"]				: $_REQUEST["roomPay"];
	$strAddPay				= $_POST["AddPay"]				? $_POST["AddPay"]				: $_REQUEST["AddPay"];
	$strAddList				= $_POST["AddList"]				? $_POST["AddList"]				: $_REQUEST["AddList"];
	$strBddList				= $_POST["BddList"]				? $_POST["BddList"]				: $_REQUEST["BddList"];

	$strRadioCash			= $_POST["radio_cash"]			? $_POST["radio_cash"]			: $_REQUEST["radio_cash"];
	$strBankBook			= $_POST["bankbook"]			? $_POST["bankbook"]			: $_REQUEST["bankbook"];

	$strSrchName			= $_POST["searchOrderName"]		? $_POST["searchOrderName"]		: $_REQUEST["searchOrderName"];
	$strSrchOdKey			= $_POST["searchOrderKey"]		? $_POST["searchOrderKey"]		: $_REQUEST["searchOrderKey"];

	/*############################################# Parameter 셋팅 #############################################*/

	$strDt = date($strYear."-".$strMonth."-".$strDay);
	$strEndDt = date('Y-m-d',strtotime($strDt.'+1 day'));

	switch($strAct){

		case "reservWrite":

			$param							= "";
			$param['RS_NUMBER']				= "RS".date("YmdHis");
			$param['RS_NAME']				= $strResrvName;
			$param['RS_EMAIL']				= $strResrvEmail;
			$param['RS_REQUEST']			= $strResrvRequest;
			$param['RS_PAYCASH']			= $strPayCash;
			$param['RS_R_NO']				= $strRoomNo;
			$param['RS_R_PAY']				= $strRoomPay;
			$param['RS_A_PAY']				= $strAddPay;
			$param['RS_PAY_TP']				= $strRadioCash;
			$param['RS_BBOOK']				= "무통장입금";
			$param['RS_REG_DT']				= date("Y-m-d");
			$param['RS_ADD_LIST']			= $strAddList;
			$param['RS_BDD_LIST']			= $strBddList;

			for($i=0;$i<$strRsvStay;$i++){

				$param['RS_S_DT']				= $strDt;
				$param['RS_E_DT']				= $strEndDt;

				$reservationMgr->getReservationInsert($db,$param);

				$strDt						= date('Y-m-d',strtotime($strDt.'+1 day'));
				$strEndDt					= date('Y-m-d',strtotime($strDt.'+1 day'));
			}

//


			$strMsg = "성공적으로 무통장결제 신청이 접수 되었습니다."; //"저장되었습니다.";

			$strUrl = "./?menuType=".$strMenuType."&mode=result&no=".$param['RS_NUMBER']."&name=".$strResrvName;

//			echo "<script language='javascript'>alert('객실시설 등록이 완료되었습니다.');parent.location.reload();</script>";
//			exit;
			goUrl($strMsg,$strUrl);
		break;

		case "resvSearch":

			$strUrl = "./?menuType=".$strMenuType."&mode=result2&no=".$strSrchOdKey."&name=".$strSrchName;

			goUrl("",$strUrl);
		break;

		case "reservWrite2":
echo "ok";exit;
			$param							= "";
			$param['RS_NUMBER']				= "RS".date("YmdHis");
			$param['RS_NAME']				= $strResrvName;
			$param['RS_EMAIL']				= $strResrvEmail;
			$param['RS_REQUEST']			= $strResrvRequest;
			$param['RS_PAYCASH']			= $strPayCash;
			$param['RS_R_NO']				= $strRoomNo;
			$param['RS_R_PAY']				= $strRoomPay;
			$param['RS_A_PAY']				= $strAddPay;
			$param['RS_PAY_TP']				= $strRadioCash;
			$param['RS_BBOOK']				= "무통장입금";
			$param['RS_REG_DT']				= date("Y-m-d");
			$param['RS_ADD_LIST']			= $strAddList;
			$param['RS_BDD_LIST']			= $strBddList;

			for($i=0;$i<$strRsvStay;$i++){

				$param['RS_S_DT']				= $strDt;
				$param['RS_E_DT']				= $strEndDt;

				$reservationMgr->getReservationInsert($db,$param);

				$strDt						= date('Y-m-d',strtotime($strDt.'+1 day'));
				$strEndDt					= date('Y-m-d',strtotime($strDt.'+1 day'));
			}

//


			$strMsg = "성공적으로 무통장결제 신청이 접수 되었습니다."; //"저장되었습니다.";

			$strUrl = "./?menuType=".$strMenuType."&mode=result&no=".$param['RS_NUMBER']."&name=".$strResrvName;

//			echo "<script language='javascript'>alert('객실시설 등록이 완료되었습니다.');parent.location.reload();</script>";
//			exit;
			goUrl($strMsg,$strUrl);
		break;

		$db->disConnect();


	}
?>