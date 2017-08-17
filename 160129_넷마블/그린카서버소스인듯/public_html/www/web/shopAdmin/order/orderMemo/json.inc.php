<?php

	switch($strAct):
	case "orderMemoWrite":
		// 상품주문 / 메모 등록

		## 모듈 설정
		require_once MALL_HOME . "/module/ShopOrderMgr.php";
		require_once MALL_HOME . "/module2/BoardData.module.php";
		require_once MALL_HOME . "/module2/BoardAddField.module.php";
		require_once MALL_HOME . "/module2/MemberMgr.module.php";
		require_once MALL_HOME . "/classes/client/ClientInfo.class.php";
		$boardData						= new BoardDataModule($db);
		$boardAddField					= new BoardAddFieldModule($db);
		$memberMgr						= new MemberMgrModule($db);
		$shopOrderMgr					= new ShopOrderMgr();

		## 기본 설정
		$memberLogin					= $_SESSION['member_login'];
		$bCode							= "USER_REPORT";
		$orderNo						= $_POST['oNo'];
		$title							= "주문관리 메모 등록";
		$lng							= $S_SITE_LNG;
		$bcNo							= 25;
		$text							= $_POST['ub_text'];
		$regDt							= "NOW()";
		$regNo							= $_SESSION['ADMIN_NO'];
		$modDt							= "NOW()";
		$modNo							= $_SESSION['ADMIN_NO'];
		$ansMemberNo					= $_POST['mNo'];
		$pCode							= $_POST['ub_p_code'];
		$func							= "NNNNNNNNNN";
		$ip								= ClientInfo::getClientIP();


		## 기본 설정 체크
		if(!$orderNo):
			$result['__STATE__']	= "NO_ORDER_NO";
			$result['__MSG__']		= "주문번호가 없습니다.";
			break;
		endif;
		if(!$text):
			$result['__STATE__']	= "NO_TEXT";
			$result['__MSG__']		= "내용을 입력하세요.";
			break;
		endif;

		## 주문 데이터 불러오기
		$param					= "";
		$param['o_no']			= $orderNo;
		$shopOrderRow			= $shopOrderMgr->getOrderListEx($db, "OP_SELECT", $param);

		## 주문 데이터 설정
		$memberNo				= $shopOrderRow['M_NO'];
		$ansMemberNo			= $shopOrderRow['M_NO'];
		$name					= $shopOrderRow['O_J_NAME'];
		$email					= $memberMgrRow['O_J_MAIL'];

		## 회원 정보 설정
		if(!$memberNo):
			## 비회원 주문
			$memberNo						= -1;
			$ansMemberNo					= -1;
		else:
			## 회원 정보 불러오기
			$param							= "";
			$param['M_NO']					= $memberNo;
			$memberMgrRow					= $memberMgr->getMemberMgrSelectEx("OP_SELECT", $param);

			## 회원 정보 체크
			if($memberNo && !$memberMgrRow):
				$result['__STATE__']	= "NO_MEMBER";
				break;
			endif;

			## 회원 정보 설정
			$fName						= $memberMgrRow['M_F_NAME'];
			$lName						= $memberMgrRow['M_L_NAME'];
			$memberId					= $memberMgrRow['M_ID'];
			$email						= $memberMgrRow['M_MAIL'];

			## 이름 만들기
			$name						= "";
			if($fName):
				$name					= $fName; 
			endif;

			if($lName):
				if(!$name) {	$name	.= " ";			}
								$name	.= $lName;
			endif;
		endif;


		## 데이터 등록
		$param							= "";
		$param['B_CODE']				= $bCode;
//		$param['UB_NO']					= "";
		$param['UB_NAME']				= $name;
		$param['UB_M_NO']				= $memberNo;
		$param['UB_M_ID']				= $memberId;
		$param['UB_PASS']				= $pass;
		$param['UB_MAIL']				= $email;
		$param['UB_URL']				= $url;
		$param['UB_TITLE']				= $title;
		$param['UB_TEXT']				= $text;
		$param['UB_TEXT_MOBILE']		= $textMobile;
		$param['UB_FUNC']				= $func;
		$param['UB_IP']					= $ip;
		$param['UB_READ']				= $read;
		$param['UB_BC_NO']				= $bcNo;
		$param['UB_LNG']				= $lng;
		$param['UB_ANS_NO']				= $ansNo;
		$param['UB_ANS_STEP']			= $ansStep;
		$param['UB_ANS_M_NO']			= $ansMemberNo;
		$param['UB_PT_NO']				= $ptNo;
		$param['UB_CI_NO']				= $ciNo;
		$param['UB_WINNER']				= $winner;
		$param['UB_P_CODE']				= $pCode;
		$param['UB_P_GRADE']			= $pGrade;
		$param['UB_REG_DT']				= $regDt;
		$param['UB_REG_NO']				= $regNo;
		$param['UB_MOD_DT']				= $modDt;
		$param['UB_MOD_NO']				= $modNo;
		
		$re								= $boardData->getBoardDataInsertEx($param);

		## 데이터 등록 체크
		if(!$re):
			$result['__STATE__']		= "FAIL";
			break;
		endif;

		## 답변형 컬럼 업데이트
		$param							= "";
		$param['B_CODE']				= $bCode;
		$param['UB_NO']					= $re;
		$param['UB_ANS_NO']				= $re;
		$param['UB_ANS_STEP']			= $ansStep;
		$param['UB_ANS_M_NO']			= $ansMemberNo;
		$boardData->getBoardDataAnsUpdateEx($param);

		## 추가 컬럼 등록
		$param							= "";
		$param['B_CODE']				= $bCode;
		$param['AD_UB_NO']				= $re;
		$param['AD_PHONE1']				= "";
		$param['AD_PHONE2']				= "";
		$param['AD_PHONE3']				= "";
		$param['AD_ZIP']				= "";
		$param['AD_ADDR1']				= "";
		$param['AD_ADDR2']				= "";
		$param['AD_COMPANY']			= "";
		$param['AD_TEMP1']				= "";
		$param['AD_TEMP2']				= $orderNo;	// 주문번호 입력
		$param['AD_TEMP3']				= "";
		$param['AD_TEMP4']				= "";
		$param['AD_TEMP5']				= "";
		$param['AD_TEMP6']				= "";
		$param['AD_TEMP7']				= "";
		$param['AD_TEMP8']				= "";
		$param['AD_TEMP9']				= "";
		$param['AD_TEMP10']				= "";
		$param['AD_TEMP11']				= "";
		$param['AD_TEMP12']				= "";
		$param['AD_TEMP13']				= "";
		$param['AD_TEMP14']				= "";
		$param['AD_TEMP15']				= "";
		$param['AD_TEMP16']				= "";
		$param['AD_TEMP17']				= "";
		$param['AD_TEMP18']				= "";
		$param['AD_TEMP19']				= "";
		$param['AD_TEMP20']				= "";
		$re								= $boardAddField->getBoardAddFieldInsertEx($param);

		## 마무리
		$result['__STATE__']			= "SUCCESS";		

	break;
	
	case "orderMemoModify":
		// 상품주문 / 메모 수정

		## 모듈 설정
		require_once MALL_HOME . "/module/ShopOrderMgr.php";
		require_once MALL_HOME . "/module2/BoardData.module.php";
		require_once MALL_HOME . "/module2/BoardAddField.module.php";
		require_once MALL_HOME . "/module2/MemberMgr.module.php";
		require_once MALL_HOME . "/classes/client/ClientInfo.class.php";
		$boardData						= new BoardDataModule($db);
		$boardAddField					= new BoardAddFieldModule($db);
		$memberMgr						= new MemberMgrModule($db);
		$shopOrderMgr					= new ShopOrderMgr();

		## 기본 설정
		$memberLogin					= $_SESSION['member_login'];
		$bCode							= "USER_REPORT";
		$intUbNo						= $_POST['ub_no'];
		$title							= "주문관리 메모 등록";
		$lng							= $S_SITE_LNG;
		$bcNo							= 8;
		$text							= $_POST['ub_text'];
		$regDt							= "NOW()";
		$regNo							= $_SESSION['ADMIN_NO'];
		$modDt							= "NOW()";
		$modNo							= $_SESSION['ADMIN_NO'];
		$ansMemberNo					= $_POST['mNo'];
		$pCode							= $_POST['ub_p_code'];
		$func							= "NNNNNNNNNN";
		$ip								= ClientInfo::getClientIP();

		## 기본 설정 체크
		if(!$intUbNo):
			$result['__STATE__']	= "NO_UB_NO";
			$result['__MSG__']		= "수정 정보를 찾을수 없습니다.";
			break;
		endif;
		if(!$text):
			$result['__STATE__']	= "NO_TEXT";
			$result['__MSG__']		= "내용을 입력하세요.";
			break;
		endif;

		## 메모 데이터 불러오기
		$param					= "";
		$param['UB_NO']			= $intUbNo;
		$param['B_CODE']		= $bCode;
		$boardDataRow			= $boardData->getBoardDataSelectEx("OP_SELECT", $param);

		## 메모 데이터 체크
		if(!$boardDataRow):
			$result['__STATE__']	= "NO_DATA_NO";
			$result['__MSG__']		= "수정 정보를 찾을수 없습니다.";
			break;
		endif;

		## 데이터 수정
		$param					= $boardDataRow;
		$param['B_CODE']		= $bCode;
		$param['UB_TEXT']		= $text;
		$param['UB_P_CODE']		= $pCode;
		$boardData->getBoardDataUpdateEx($param);

		## 마무리
		$result['__STATE__']			= "SUCCESS";	
	break;

	endswitch;

	if(!$result):
		$result = print_r($_POST, true);
	endif;

	$db->disConnect();
	echo json_encode($result);
	exit;