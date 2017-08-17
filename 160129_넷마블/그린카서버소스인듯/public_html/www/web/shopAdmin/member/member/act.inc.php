<?
	
	require_once MALL_CONF_LIB."MemberAdmMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";
	$memberMgr = new MemberMgr();
	$siteMgr = new SiteMgr();

	require_once "basic.param.inc.php";
	
	/*##################################### Parameter 셋팅 #####################################*/
	$strM_PASS				= $_POST["pwd"]				? $_POST["pwd"]				: $_REQUEST["pwd"];
	$strM_MAIL				= $_POST["mail"]			? $_POST["mail"]			: $_REQUEST["mail"];
	$strM_ADDR				= $_POST["addr1"]			? $_POST["addr1"]			: $_REQUEST["addr1"];
	$strM_ADDR2				= $_POST["addr2"]			? $_POST["addr2"]			: $_REQUEST["addr2"];
	$strM_SMSYN				= $_POST["smsYN"]			? $_POST["smsYN"]			: $_REQUEST["smsYN"];
	$strM_MAILYN			= $_POST["mailYN"]			? $_POST["mailYN"]			: $_REQUEST["mailYN"];
	$strM_GROUP				= $_POST["group"]			? $_POST["group"]			: $_REQUEST["group"];

	$strM_COUNTRY			= $_POST["country"]			? $_POST["country"]			: $_REQUEST["country"];
	$strM_CITY				= $_POST["city"]			? $_POST["city"]			: $_REQUEST["city"];
	$strM_STATE1			= $_POST["state_1"]			? $_POST["state_1"]			: $_REQUEST["state_1"];
	$strM_STATE2			= $_POST["state_2"]			? $_POST["state_2"]			: $_REQUEST["state_2"];
	$strM_STATE = $strM_STATE1;
	if ($strM_COUNTRY == "US") $strM_STATE = $strM_STATE2;

	$strM_PHONE1			= $_POST["phone1"]			? $_POST["phone1"]			: $_REQUEST["phone1"];
	$strM_PHONE2			= $_POST["phone2"]			? $_POST["phone2"]			: $_REQUEST["phone2"];
	$strM_PHONE3			= $_POST["phone3"]			? $_POST["phone3"]			: $_REQUEST["phone3"];
	$strM_PHONE				= $strM_PHONE1;
	if ($strM_PHONE2) $strM_PHONE .= "-".$strM_PHONE2;
	if ($strM_PHONE3) $strM_PHONE .= "-".$strM_PHONE3;
	
	$strM_HP1				= $_POST["hp1"]				? $_POST["hp1"]				: $_REQUEST["hp1"];
	$strM_HP2				= $_POST["hp2"]				? $_POST["hp2"]				: $_REQUEST["hp2"];
	$strM_HP3				= $_POST["hp3"]				? $_POST["hp3"]				: $_REQUEST["hp3"];
	$strM_HP				= $strM_HP1;
	if ($strM_HP2) $strM_HP .= "-".$strM_HP2;
	if ($strM_HP3) $strM_HP .= "-".$strM_HP3;
	
	$strM_ZIP1				= $_POST["zip1"]			? $_POST["zip1"]			: $_REQUEST["zip1"];
	$strM_ZIP2				= $_POST["zip2"]			? $_POST["zip2"]			: $_REQUEST["zip2"];
	$strM_ZIP				= $strM_ZIP1;
	if ($strM_ZIP2) $strM_ZIP .= "-".$strM_ZIP2;

	$strM_TM_ID				= $_POST["tm_id"]			? $_POST["tm_id"]			: $_REQUEST["tm_id"];

	/* 선택 */
	$aryChkNo				= $_POST["chkNo"]			? $_POST["chkNo"]				: $_REQUEST["chkNo"];
	
	/* 그룹변경 */
	$strChangeGroup			= $_POST["changeGroup"]		? $_POST["changeGroup"]			: $_REQUEST["changeGroup"];
    
    
    /* 사업자 정보 */
	$strM_BUSI_NM		= $_POST["busi_nm"]			? $_POST["busi_nm"]			: $_REQUEST["busi_nm"];
	
	$strM_BUSI_NUM1		= $_POST["busi_num1"]		? $_POST["busi_num1"]		: $_REQUEST["busi_num1"];
	$strM_BUSI_NUM2		= $_POST["busi_num2"]		? $_POST["busi_num2"]		: $_REQUEST["busi_num2"];
	$strM_BUSI_NUM3		= $_POST["busi_num3"]		? $_POST["busi_num3"]		: $_REQUEST["busi_num3"];
	$strM_BUSI_NUM		= $strM_BUSI_NUM1;
	if ($strM_BUSI_NUM2) $strM_BUSI_NUM .= "-".$strM_BUSI_NUM2;
	if ($strM_BUSI_NUM3) $strM_BUSI_NUM .= "-".$strM_BUSI_NUM3;
	
	$strM_BUSI_UPJ		= $_POST["busi_upj"]		? $_POST["busi_upj"]		: $_REQUEST["busi_upj"];
	$strM_BUSI_UTE		= $_POST["busi_ute"]		? $_POST["busi_ute"]		: $_REQUEST["busi_ute"];
	
	$strM_BUSI_ZIP1		= $_POST["busi_zip1"]		? $_POST["busi_zip1"]		: $_REQUEST["busi_zip1"];
	$strM_BUSI_ZIP2		= $_POST["busi_zip2"]		? $_POST["busi_zip2"]		: $_REQUEST["busi_zip2"];
	$strM_BUSI_ZIP		= $strM_BUSI_ZIP1;
	if ($strM_BUSI_ZIP2) $strM_BUSI_ZIP .= "-".$strM_BUSI_ZIP2;
	$strM_BUSI_ADDR1 = $_POST["busi_addr1"]		? $_POST["busi_addr1"]			: $_REQUEST["busi_addr1"];
	$strM_BUSI_ADDR2 = $_POST["busi_addr2"]		? $_POST["busi_addr2"]			: $_REQUEST["busi_addr2"];
	/*##################################### Parameter 셋팅 #####################################*/

	if (!$strM_SMSYN) $strM_SMSYN = "N";
	if (!$strM_MAILYN) $strM_MAILYN = "N";

	$memberMgr->setM_NO($intM_NO);	
	$memberMgr->setM_MAIL($strM_MAIL);
	$memberMgr->setM_PHONE($strM_PHONE);
	$memberMgr->setM_HP($strM_HP);
	$memberMgr->setM_ZIP($strM_ZIP);
	$memberMgr->setM_ADDR($strM_ADDR);
	$memberMgr->setM_ADDR2($strM_ADDR2);
	$memberMgr->setM_SMSYN($strM_SMSYN);
	$memberMgr->setM_MAILYN($strM_MAILYN);
	$memberMgr->setM_GROUP($strM_GROUP);	
	$memberMgr->setM_COUNTRY($strM_COUNTRY);
	$memberMgr->setM_CITY($strM_CITY);
	$memberMgr->setM_STATE($strM_STATE);	
	$memberMgr->setM_MOD_NO($a_admin_no);
	$memberMgr->setM_TM_ID($strM_TM_ID);	
    
	$memberMgr->setM_BUSI_NM($strM_BUSI_NM);
	$memberMgr->setM_BUSI_NUM($strM_BUSI_NUM);
	$memberMgr->setM_BUSI_UPJ($strM_BUSI_UPJ);
	$memberMgr->setM_BUSI_UTE($strM_BUSI_UTE);
	$memberMgr->setM_BUSI_ZIP($strM_BUSI_ZIP);
	$memberMgr->setM_BUSI_ADDR1($strM_BUSI_ADDR1);
	$memberMgr->setM_BUSI_ADDR2($strM_BUSI_ADDR2);

			
	switch ($strAct) {
		case "memberReportModify":
			// 상담관리 수정

			## 모듈 설정
			$objBoardDataModule			= new BoardDataModule($db);
			$objBoardAddFieldModule		= new BoardAddFieldModule($db);

			## 기본설정
			$intUB_NO					= $_POST['ub_no'];
			$intUB_BC_NO				= $_POST['ub_bc_no'];
			$strUB_TEXT					= $_POST['ub_text'];
			$strB_CODE					= $_POST['b_code'];
			$strAD_TEMP1				= $_POST['ad_temp1'];
			$intMemberNo				= $_SESSION['ADMIN_NO'];

			## 유효성 체크
			if(!$intMemberNo):
				echo "로그인이 필요합니다.";
				exit;
			endif;
			if(!$intUB_NO):
				echo "수정할 데이터가 필요합니다.";
				exit;
			endif;
			if(!$strB_CODE):
				echo "수정할 게시판이 없습니다.";
				exit;
			endif;

			## 데이터 등록
			$param						= "";
			$param['B_CODE']			= $strB_CODE;
			$param['UB_NO']				= $intUB_NO;
			$param['UB_TEXT']			= $strUB_TEXT;
			$param['UB_BC_NO']			= $intUB_BC_NO;
			$param['UB_MOD_DT']			= "NOW()";
			$param['UB_MOD_NO']			= $intMemberNo;
			$re							= $objBoardDataModule->getBoardDataReportUpdateEx($param);

			## 데이터 등록(추가필드)
			$param						= "";
			$param['B_CODE']			= $strB_CODE;
			$param['AD_UB_NO']			= $intUB_NO;
			$param['AD_TEMP1']			= $strAD_TEMP1;
			$re							= $objBoardAddFieldModule->getBoardAddFieldReportUpdateEx($param);

			## 이동
			$strUrl			= $_SERVER['HTTP_REFERER'];
			$aryUrlParse	= parse_url($strUrl);
			$strUrlQuery	= $aryUrlParse['query'];
			$queryString	= explode("&", $strUrlQuery);
			$memLinkPage	= "";
			foreach($queryString as $string):
				list($key,$val)		= explode("=", $string);
				if($key == "tab") { $string = "{$key}=memberProdReportList"; }
				if($memLinkPage)		{ $memLinkPage .= "&"; }
				$memLinkPage	.= $string;
			endforeach;

			$strMsg				= "수정되었습니다.";
			$strUrl				= "./?{$memLinkPage}";
		
		break;
		case "memberCateJoinDelete":
			// 회원에 소속 정보 삭제
			
			## 설정
			require_once MALL_CONF_LIB."memberCateMgr.php";
			$memberCateMgr			= new MemberCateMgr();

			## delete
			$param					= "";
			$param['MC_NO']			= $_POST['mc_no'];
			$memberCateMgr->getMemberCateJoinDeleteEx($db, $param);

			$strMsg		= "삭제되었습니다.";
			$strUrl		= $_SERVER['HTTP_REFERER'];
		break;

		case "memberCateJoinWrite":
			// 회원에 소속 정보 등록

			## 회원 카테고리 코드 설정
			$c_code		= "";
			if($_POST['c_cate_1']) { $c_code = $_POST['c_cate_1']; }
			if($_POST['c_cate_2']) { $c_code = $_POST['c_cate_2']; }
			if($_POST['c_cate_3']) { $c_code = $_POST['c_cate_3']; }
			if($_POST['c_cate_4']) { $c_code = $_POST['c_cate_4']; }
			
			if(!$c_code):
				echo "처리하세요. 카테고리 코드 정보가 없습니다.";
				exit;
			endif;
			
			## 설정
			require_once MALL_CONF_LIB."memberCateMgr.php";
			$memberCateMgr			= new MemberCateMgr();

			## 등록된 데이터인지 체크
			$param					= "";
			$param['C_CODE']		= $c_code;
			$param['M_NO']			= $_POST['memberNo'];
			$memberCateJoinCount	= $memberCateMgr->getMemberCateJoinListEx($db, "OP_COUNT", $param);
			if($memberCateJoinCount > 0):
				$strMsg		= "이미 등록된 소속입니다.";
				$strUrl		= $_SERVER['HTTP_REFERER'];
				break;
			endif;

			## insert
			$param					= "";
			$param['C_CODE']		= $c_code;
			$param['M_NO']			= $_POST['memberNo'];
			$memberCateMgr->getMemberCateJoinInsertEx($db, $param);
			
			## 이동
			$strMsg		= "등록되었습니다.";
			$strUrl		= $_SERVER['HTTP_REFERER'];
		break;
		case "memberReportWrite":
			// 상담관리 글등록

			## STEP 1.
			## 선언
			require_once MALL_HOME . "/modules/community/data/basic.1.0/community.data.controller.php";
			require_once MALL_HOME . "/classes/client/client.info.class.php";
			$dataController				= new CommunityDataController($db, $_POST);
			$client						= new ClientInfo();	
			
			## STEP 2.
			## 회원 정보
			$m_no						= $_POST['memberNo'];
			$memberMgr->setM_NO($m_no);
			$memberRow					= $memberMgr->getMemberView($db);

			## STEP 2.
			## 등록
			$param['b_code']			= "USER_REPORT";	
			$param['ub_name']			= $memberRow['M_L_NAME']; /** 이름 부분은 추후 체크 필요함. **/
			if($memberRow['M_F_NAME']) { $param['ub_name'] .= " " . $memberRow['M_F_NAME']; }
			$param['ub_m_no']			= $memberRow['M_NO'];
			$param['ub_m_id']			= $memberRow['M_ID'];
			$param['ub_mail']			= $memberRow['M_MAIL'];
			$param['ub_title']			= $LNG_TRANS_CHAR["MW00100"]; //"상담내역";
			$param['ub_text']			= $_POST['ub_text'];
			$param['ub_func']			= "NNNNNNNNNN";
			$param['ub_ip']				= $client->getClientIP();
			$param['ub_read']			= 0;
			$param['ub_bc_no']			= $_POST['ub_bc_no'];
			$param['ub_lng']			= $S_SITE_LNG;
			$param['ub_reg_no']			= $a_admin_no;
			$param['ub_mod_no']			= $a_admin_no;
			$param['ub_no']				= $dataController->getWriteEx($param);		
			$param['ub_ans_no']			= $param['ub_no'];
			$dataController->getAnsNoUpdateEx($param);

			## STEP 3.
			## 이동
			$strMsg = $LNG_TRANS_CHAR["CS00003"]; //"등록되었습니다.";
			$strUrl = "./?menuType={$_POST['menuType']}&mode=popMemberCrmView&tab={$_POST['tab']}&memberNo={$_POST['memberNo']}{$strLinkPage}";
		break;
		case "memberAuth":

			$memberMgr->getMemberAuth($db);

			/** 메일 전송 **/
			$row = $memberMgr->getMemberView($db);
			$aryTAG_LIST['{{__받는사람이름__}}']	= $row['M_NAME'];
			$aryTAG_LIST['{{__받는사람메일__}}']	= $row['M_MAIL'];
			$aryTAG_LIST['{{__회원명__}}']			= $row['M_NAME'];
			goSendMail("002");
			/** 메일 전송 **/	

			$strLinkPage .= "&searchOut=$strSearchOut&searchField=$strSearchField&searchKey=$strSearchKey";
			$strLinkPage .= "&searchRegStartDt=$strSearchRegStartDt&searchRegEndDt=$strSearchRegEndDt";
			$strLinkPage .= "&searchOutStartDt=$strSearchOutStartDt&searchOutEndDt=$strSearchOutEndDt";
			$strLinkPage .= "&searchGroup=$strSearchGroup&page=$intPage";
			
			$strMsg = $LNG_TRANS_CHAR["CS00010"]; //승인되었습니다.
			$strUrl = "./?menuType=".$strMenuType."&mode=memberList".$strLinkPage;
		break;

		case "memberModify":
			
			/* 이메일 중복 체크 */
			$intCount = $memberMgr->getMemberMailCheck($db);
			if ($intCount > 0){
				goErrMsg($LNG_TRANS_CHAR["MS00027"]);
				exit;
			}

			$memberMgr->getMemberUpdate($db);
            $memberMgr->getMemberAddUpdate($db);
            
			if ($strM_PASS){
				$memberMgr->setM_PASS($strM_PASS);
				$memberMgr->getMemberPwdUpdate($db);
				
				/** 메일 전송 **/
				$row = $memberMgr->getMemberView($db);
				$aryTAG_LIST['{{__받는사람이름__}}']	= $row['M_NAME'];
				$aryTAG_LIST['{{__받는사람메일__}}']	= $row['M_MAIL'];
				$aryTAG_LIST['{{__임시비밀번호__}}']	= $strM_PASS;
				$aryTAG_LIST['{{__회원명__}}']			= $row['M_NAME'];
				
				goSendMail("004",$row['M_LNG']);
				/** 메일 전송 **/
				
				/* 이전 암호화 비밀번호인경우 방문자수를 update 해야 함 */
				if (!$row["M_VISIT_CNT"]){
					$memberMgr->setM_NO($row["M_NO"]);
					$memberMgr->getMemberVisitUpdate($db);
				}
			}

			$strLinkPage .= "&searchOut=$strSearchOut&searchField=$strSearchField&searchKey=$strSearchKey";
			$strLinkPage .= "&searchRegStartDt=$strSearchRegStartDt&searchRegEndDt=$strSearchRegEndDt";
			$strLinkPage .= "&searchOutStartDt=$strSearchOutStartDt&searchOutEndDt=$strSearchOutEndDt";
			$strLinkPage .= "&searchGroup=$strSearchGroup&page=$intPage";
			
			$strMsg = $LNG_TRANS_CHAR["CS00004"]; //정보수정완료
			$strUrl = "./?menuType=".$strMenuType."&mode=popMemberCrmView&tab=memberModify&memberNo=".$intM_NO.$strLinkPage;
		break;

		case "memberDelete";
			// 회원 탈퇴
			
			$memberMgr->getMemberOut($db);

			/** 메일 전송 **/
			$row = $memberMgr->getMemberView($db);
			$aryTAG_LIST['{{__받는사람이름__}}']	= $row['M_NAME'];
			$aryTAG_LIST['{{__받는사람메일__}}']	= $row['M_MAIL'];
			$aryTAG_LIST['{{__회원명__}}']			= $row['M_NAME'];
			goSendMail("006");
			/** 메일 전송 **/

			$result_array = array();
			$result[0][MSG]			= $LNG_TRANS_CHAR["MS00001"]; //선택하신 회원님이 탈퇴/삭제 되었습니다.
			$result[0][RET]			= "Y";

			$result_array = json_encode($result);
			
			$db->disConnect();
			echo $result_array;
			exit;
		break;

		case "memberAllDelete":
		
			if (is_array($aryChkNo)){
				for($p=0;$p<sizeof($aryChkNo);$p++){

					if ($aryChkNo[$p]) {
						$memberMgr->setM_NO($aryChkNo[$p]);

						$memberMgr->getMemberOut($db);

						/** 메일 전송 **/
						$row = $memberMgr->getMemberView($db);
						$aryTAG_LIST['{{__받는사람이름__}}']	= $row['M_NAME'];
						$aryTAG_LIST['{{__받는사람메일__}}']	= $row['M_MAIL'];
						$aryTAG_LIST['{{__회원명__}}']			= $row['M_NAME'];
						goSendMail("006");
						/** 메일 전송 **/	
					}
				}
			}

			$result_array = array();
			$result[0][MSG]			= $LNG_TRANS_CHAR["CS00016"]; //선택하신 데이터가 삭제되었습니다.
			$result[0][RET]			= "Y";

			$result_array = json_encode($result);
			
			$db->disConnect();
			echo $result_array;
			exit;
		break;

		case "memberRecovery":
			$memberMgr->getMemberRecovery($db);
			
			$result_array = array();
			$result[0][MSG]			= $LNG_TRANS_CHAR["MS00002"]; //선택하신 회원님이 복원 되었습니다.
			$result[0][RET]			= "Y";

			$result_array = json_encode($result);
			
			$db->disConnect();
			echo $result_array;
			exit;

		break;

		case "memberGroupChange":
			
			$memberMgr->setM_GROUP($strChangeGroup);

			if (is_array($aryChkNo)){
				for($p=0;$p<sizeof($aryChkNo);$p++){

					if ($aryChkNo[$p]) {
						$memberMgr->setM_NO($aryChkNo[$p]);
						$memberMgr->getMemberGroupChange($db);
					}
				}
			}

			$result_array = array();
			$result[0][MSG]			= $LNG_TRANS_CHAR["MS00011"]; //선택하신 회원님의 그룹이 변경되었습니다.
			$result[0][RET]			= "Y";

			$result_array = json_encode($result);
			
			$db->disConnect();
			echo $result_array;
			exit;

		break;
		
		case "memberMailSend":
			

		break;
	}

?>