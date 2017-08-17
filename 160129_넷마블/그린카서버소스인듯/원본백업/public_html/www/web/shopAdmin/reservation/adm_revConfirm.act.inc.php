<?echo
	require_once MALL_CONF_LIB."ReservationMgr.php";

	$reservationMgr = new ReservationMgr();
echo "ok33";
	/*############################################# Parameter 셋팅 #############################################*/

	$strResrvName			= "관리자";
	$strResrvPhone			= "010-5151-5252";
	$strResrvEmail			= "eum@eumshop.co.kr";
	$strResrvRequest		= "관리자님께서 예약하신 정보입니다.";

	$strRsvStay				= $_POST["selectDay"]			? $_POST["selectDay"]			: $_REQUEST["selectDay"];
	$strTime				= $_POST["StartDt"]				? $_POST["StartDt"]				: $_REQUEST["StartDt"];

	$strPayCash				= $_POST["pay_cash"]			? $_POST["pay_cash"]			: $_REQUEST["pay_cash"];
//	$strRoomNo				= $_POST["roomNo"]				? $_POST["roomNo"]				: $_REQUEST["roomNo"];
	$strRoomPay				= $_POST["roomPay"]				? $_POST["roomPay"]				: $_REQUEST["roomPay"];
	$strAddPay				= $_POST["AddPay"]				? $_POST["AddPay"]				: $_REQUEST["AddPay"];

	$strAddList				= $_POST["roomList"]			? $_POST["roomList"]			: $_REQUEST["roomList"];
	$strBddList				= $_POST["peoList"]				? $_POST["peoList"]				: $_REQUEST["peoList"];

	$strCddList				= $_POST["addList"]				? $_POST["addList"]				: $_REQUEST["addList"];
	$strDddList				= $_POST["noList"]				? $_POST["noList"]				: $_REQUEST["noList"];

	$strRadioCash			= $_POST["radio_cash"]			? $_POST["radio_cash"]			: $_REQUEST["radio_cash"];
	$strBankBook			= $_POST["bankbook"]			? $_POST["bankbook"]			: $_REQUEST["bankbook"];

	/*############################################# Parameter 셋팅 #############################################*/

	$strDt = date($strTime);
	$strEndDt = date('Y-m-d',strtotime($strDt.'+1 day'));

	$strRoomNo = explode(',',substr($strAddList,0,strlen($strAddList)-1));
	$loop = count($strRoomNo);

	switch($strAct){

		case "admRsvWrite":

			for($m=0;$m<$loop;$m++){

			$param							= "";
			$param['RS_NUMBER']				= "RS".date("YmdHis");
			$param['RS_NAME']				= $strResrvName;
			$param['RS_EMAIL']				= $strResrvEmail;
			$param['RS_REQUEST']			= $strResrvRequest;
			$param['RS_PAYCASH']			= $strPayCash;
			$param['RS_R_NO']				= $strRoomNo[$m];
			$param['RS_R_PAY']				= $strRoomPay;
			$param['RS_A_PAY']				= $strAddPay;
			$param['RS_PAY_TP']				= $strRadioCash;
			$param['RS_BBOOK']				= "무통장입금";
			$param['RS_REG_DT']				= date("Y-m-d");
			$param['RS_ADD_LIST']			= $strCddList;
			$param['RS_BDD_LIST']			= $strDddList;

			for($i=0;$i<$strRsvStay;$i++){

				$param['RS_S_DT']				= $strDt;
				$param['RS_E_DT']				= $strEndDt;

				$reservationMgr->getReservationInsert($db,$param);

				$strDt						= date('Y-m-d',strtotime($strDt.'+1 day'));
				$strEndDt					= date('Y-m-d',strtotime($strDt.'+1 day'));
			}
			$strDt = date($strTime);
			$strEndDt = date('Y-m-d',strtotime($strDt.'+1 day'));

			}

//


			$strMsg = "예약이 성공적으로 완료되었습니다.";

			$strUrl = "./?menuType=reservation&mode=month_revList";

//			echo "<script language='javascript'>alert('객실시설 등록이 완료되었습니다.');parent.location.reload();</script>";
//			exit;
			goUrl($strMsg,$strUrl);
		break;

		$db->disConnect();


	}
?>