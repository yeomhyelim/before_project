<?
	require_once MALL_CONF_LIB."SiteMgr.php";
	require_once MALL_CONF_LIB."ReservationMgr.php";

	require_once MALL_HOME."/web/shopAdmin/basic/_function.lib.inc.php";

	$siteMgr = new SiteMgr();
	$reservationMgr = new ReservationMgr();



	/*############################################ Parameter 셋팅 #################################################*/
	$strRName				= $_POST["r_name"]				? $_POST["r_name"]				: $_REQUEST["r_name"];
	$strRMemo				= $_POST["r_memo"]				? $_POST["r_memo"]				: $_REQUEST["r_memo"];
	$strRType				= $_POST["r_type"]				? $_POST["r_type"]				: $_REQUEST["r_type"];
	$strRArea				= $_POST["area2"]				? $_POST["area2"]				: $_REQUEST["area2"];
	$strRStPer				= $_POST["r_st_per"]			? $_POST["r_st_per"]			: $_REQUEST["r_st_per"];
	$strRMaxPer				= $_POST["r_max_per"]			? $_POST["r_max_per"]			: $_REQUEST["r_max_per"];
	$strBasicSet			= $_POST["BasicSet"]			? $_POST["BasicSet"]			: $_REQUEST["BasicSet"];
	$strRPrint				= $_POST["r_print"]				? $_POST["r_print"]				: $_REQUEST["r_print"];
	$strROrder				= $_POST["r_order"]				? $_POST["r_order"]				: $_REQUEST["r_order"];
	$strRBMprice			= $_POST["r_b_mprice"]			? $_POST["r_b_mprice"]			: $_REQUEST["r_b_mprice"];
	$strRBWprice			= $_POST["r_b_wprice"]			? $_POST["r_b_wprice"]			: $_REQUEST["r_b_wprice"];
	$strRBSprice			= $_POST["r_b_sprice"]			? $_POST["r_b_sprice"]			: $_REQUEST["r_b_sprice"];
	$strRZMprice			= $_POST["r_z_mprice"]			? $_POST["r_z_mprice"]			: $_REQUEST["r_z_mprice"];
	$strRZWprice			= $_POST["r_z_wprice"]			? $_POST["r_z_wprice"]			: $_REQUEST["r_z_wprice"];
	$strRZSprice			= $_POST["r_z_sprice"]			? $_POST["r_z_sprice"]			: $_REQUEST["r_z_sprice"];
	$strRSMprice			= $_POST["r_s_mprice"]			? $_POST["r_s_mprice"]			: $_REQUEST["r_s_mprice"];
	$strRSWprice			= $_POST["r_s_wprice"]			? $_POST["r_s_wprice"]			: $_REQUEST["r_s_wprice"];
	$strRSSprice			= $_POST["r_s_sprice"]			? $_POST["r_s_sprice"]			: $_REQUEST["r_s_sprice"];
	$strRBprice1			= $_POST["r_b1_price"]			? $_POST["r_b1_price"]			: $_REQUEST["r_b1_price"];
	$strRZprice2			= $_POST["r_z1_price"]			? $_POST["r_z1_price"]			: $_REQUEST["r_z1_price"];
	$strRSprice3			= $_POST["r_s1_price"]			? $_POST["r_s1_price"]			: $_REQUEST["r_s1_price"];
//	$strRImage				= $_POST["r_image"]				? $_POST["r_image"]				: $_REQUEST["r_image"];

	/*############################################## Parameter 셋팅 #################################################*/

$strBasicSet = substr($strBasicSet,0,strlen($strBasicSet)-1);

	switch($strAct){

		case "roomDataWrite":

			$param					= "";
			$param['R_NAME']		= $strRName;
			$param['R_MEMO']		= $strRMemo;
			$param['R_TYPE']		= $strRType;
			$param['R_AREA']		= $strRArea;
			$param['R_ST_PER']		= $strRStPer;
			$param['R_MAX_PER']		= $strRMaxPer;
			$param['R_PRINT']		= $strRPrint;
			$param['R_ORDER']		= $strROrder;
			$param['R_B_MPRICE']	= $strRBMprice;
			$param['R_B_WPRICE']	= $strRBWprice;
			$param['R_B_SPRICE']	= $strRBSprice;
			$param['R_Z_MPRICE']	= $strRZMprice;
			$param['R_Z_WPRICE']	= $strRZWprice;
			$param['R_Z_SPRICE']	= $strRZSprice;
			$param['R_S_MPRICE']	= $strRSMprice;
			$param['R_S_WPRICE']	= $strRSWprice;
			$param['R_S_SPRICE']	= $strRSSprice;
			$param['R_BI_MPRICE']	= $strRBprice1;
			$param['R_ZI_MPRICE']	= $strRZprice2;
			$param['R_SI_MPRICE']	= $strRSprice3;
			$param['R_REG_DT']		= date("Y-m-d");
			$param['R_REG_NO']		= $a_admin_no;
//
//			이미지 업로드
			$strR_IMAGE			= "";

			if ($_FILES["r_listimage"][name])
			{
				if (!getAllowImgFileExt($_FILES["r_listimage"][name])){
					goErrMsg($LNG_TRANS_CHAR["CS00009"]); //"첨부하신 파일은 확장자가 금지된 파일입니다."
					exit;
				}

				$filename = $_FILES["r_listimage"][name];
				$tmpname  = $_FILES["r_listimage"][tmp_name];
				$filesize = $_FILES["r_listimage"][size];
				$filetype = $_FILES["r_listimage"][type];

				$number = date("YmdHis");		//파일명 숫자로 변경
				$fres = $fh->doUpload("$number","../upload/images",$filename,$tmpname,$filesize,$filetype);
				if($fres) {
					$strR_IMAGE = $fres[file_real_name];
				}else{
					goErrMsg("이미지 등록시 에러가 발생하였습니다.");
					exit;
				}
			}

			$param['R_LIST_IMAGE'] = $strR_IMAGE;
//
			$key = $reservationMgr->getRoomBasicInsert($db,$param);

			$param['R_NO']		= $key;
			$param['R_SET']		= $strBasicSet;

			$reservationMgr->getRoomBasicSetInsert($db,$param);

			$strUrl = "./?menuType=".$strMenuType."&mode=roomList".$strLinkPage;
		break;

		case "roomDataModify":

			$param					= "";
			$param['R_NO']			= $_GET['no'];
			$param['R_NAME']		= $strRName;
			$param['R_MEMO']		= $strRMemo;
			$param['R_TYPE']		= $strRType;
			$param['R_AREA']		= $strRArea;
			$param['R_ST_PER']		= $strRStPer;
			$param['R_MAX_PER']		= $strRMaxPer;
			$param['R_PRINT']		= $strRPrint;
			$param['R_ORDER']		= $strROrder;
			$param['R_B_MPRICE']	= $strRBMprice;
			$param['R_B_WPRICE']	= $strRBWprice;
			$param['R_B_SPRICE']	= $strRBSprice;
			$param['R_Z_MPRICE']	= $strRZMprice;
			$param['R_Z_WPRICE']	= $strRZWprice;
			$param['R_Z_SPRICE']	= $strRZSprice;
			$param['R_S_MPRICE']	= $strRSMprice;
			$param['R_S_WPRICE']	= $strRSWprice;
			$param['R_S_SPRICE']	= $strRSSprice;
			$param['R_BI_MPRICE']	= $strRBprice1;
			$param['R_ZI_MPRICE']	= $strRZprice2;
			$param['R_SI_MPRICE']	= $strRSprice3;
			$param['R_MOD_DT']		= date("Y-m-d");
			$param['R_MOD_NO']		= $a_admin_no;
//			$param['R_IMAGE']		= $strRImage;

			$strR_IMAGE			= "";
			if ($_FILES["r_listimage"][name])
			{
				if (!getAllowImgFileExt($_FILES["r_listimage"][name])){
					goErrMsg($LNG_TRANS_CHAR["CS00009"]); //"첨부하신 파일은 확장자가 금지된 파일입니다."
					exit;
				}

				$filename = $_FILES["r_listimage"][name];
				$tmpname  = $_FILES["r_listimage"][tmp_name];
				$filesize = $_FILES["r_listimage"][size];
				$filetype = $_FILES["r_listimage"][type];

				$number = date("YmdHis");		//파일명 숫자로 변경
				$fres = $fh->doUpload("$number","../upload/images",$filename,$tmpname,$filesize,$filetype);
				if($fres) {
					if ($row['R_LIST_IMAGE']){
						$fh->fileDelete("../upload/images/".$row['R_LIST_IMAGE']);
					}
					$strR_IMAGE = $fres[file_real_name];
				}else{
					goErrMsg("이미지 등록시 에러가 발생하였습니다.");
					exit;
				}
			}
			$param['R_LIST_IMAGE']	= $strR_IMAGE;

			$reservationMgr->getRoomBasicUpdate($db,$param);

			$param['R_SET']	= $strBasicSet;

			$reservationMgr->getRoomBasicSetUpdate($db,$param);

			$strMsg = "객실정보가 수정되었습니다.";

			$strUrl = "./?menuType=".$strMenuType."&mode=roomList".$strLinkPage;
		break;

		case "roomBasicDelete":

			$param					= "";
			$param['R_NO']			= $_POST['no'];


			$reservationMgr->getRoomBasicDelete($db,$param);

			$strUrl = "./?menuType=".$strMenuType."&mode=roomList".$strLinkPage;
		break;
	}

	$db->disConnect();

	goUrl($strMsg,$strUrl);
?>