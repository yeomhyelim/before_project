<?

	if($strSmsMode)
	{
		switch ($strSmsMode){
			case "searchPwdSms":										/* 비밀번호 찾기(고객용) */
			
					$strM_Name			= $row[M_NAME];					// 고객명
					$strM_ID				= $row[M_ID];					// 고객아이디
					$strTmpPass			= $strTmpPass;					// 변경된 비밀번호
					$strTranPhone		= $row[M_HP];					// 고객연락처
					$strTranCallBack	= $S_SITE_COM_PHONE;		// 송신자 전화번호(생략가능)

					$smsMgr->setCC_NAME("비밀번호 찾기(고객용)");
			break;

			case "guestRequestSms":
			// 고객(비회원 포함)의 요청으로 전화 상담시 문자 발송

				$strM_Name				= "guest";
				$strM_ID					= "noID";
				$strTranPhone			= $S_SITE_COM_PHONE;
				$strTranCallBack		= $strHP;							// 송신자 전화번호(생략가능)

				$smsMgr->setCC_NAME("무료문자상담하기(관리자용)");
			break;

			case "example":
		
			break;
		}

		$arySmsRow	= $smsMgr->getSmsText($db);			// SMS 문자 메시지
		$strTranMsg	= $arySmsRow[SM_TEXT];				// ~

		$strSiteComName		= $S_SITE_COM_NAME;			// 상점명

		$strTranMsg = STR_REPLACE("{{상점명}}",$strSiteComName, $strTranMsg);			// 상점명
		$strTranMsg = STR_REPLACE("{{고객명}}",$strM_Name, $strTranMsg);				// 고객명
		$strTranMsg = STR_REPLACE("{{아이디}}",$strM_ID, $strTranMsg);					// 고객아이디
		$strTranMsg = STR_REPLACE("{{변경된비밀번호}}",$strTmpPass, $strTranMsg);		// 변경된비밀번호
		$strTranMsg = STR_REPLACE("{{결제금액}}",$strO_TopSprice, $strTranMsg);			// 결제금액
		$strTranMsg = STR_REPLACE("{{배송사}}",$strO_DeliveryCom, $strTranMsg);			// 배송회사
		$strTranMsg = STR_REPLACE("{{운송장번호}}",$strO_DeliveryNum, $strTranMsg);		// 배송번호
		$strTranMsg = STR_REPLACE("{{게시판}}",$strB_Title, $strTranMsg);				// 게시판 이름
		$strTranMsg = STR_REPLACE("{{적립금}}",$strPT_Momo, $strTranMsg);				// 적립금
		$strTranMsg = STR_REPLACE("{{적립금명}}",$intPT_Point, $strTranMsg);			// 적립금명

		$strTranEtc1		= $S_SHOP_HOME;				// 회사 폴더(회사구분)

		$sms = new Sms();
		$sms->setTranPhone($strTranPhone);
		$sms->setTranCallBack($strTranCallBack);
		$sms->setTranMsg($strTranMsg);
		$sms->setTranEtc1($strTranEtc1);
		if($sms->smsSend() != 0)
		{
			$msg = "죄송합니다. 관리자에게 문의해 주세요.";
		}
		else
		{
			$siteMgr->getSmsMoneyUpdate($db);
		}

		$smsMgr->setSM_NO($arySmsRow['SM_NO']);
		$smsMgr->setM_NO($row['M_NO']);
		$smsMgr->setMS_SEND_NO($strTranPhone);
		$smsMgr->setMS_SEND_MSG($strTranMsg);
		$smsMgr->setMS_SEND_STATUS('Y');
		$smsMgr->setMS_SEND_DT();

		$smsMgr->getSmsLogInsert($db);
	}





?>
