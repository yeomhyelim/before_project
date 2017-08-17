<?

#/*====================================================================*/#
#|화일명	: mail.func.php												|#
#|작성자	: 김희성													|#
#|작성일	: 2012.11.21												|#
#|수정일	: 2013.12.26 - 소스 정리 및 관리자에게도 메일이 가도록 수정	|#
#|작성내용	: 메일함수													|#
#/*====================================================================*/#

		## 테그 설정
		$aryTAG_DEFINE								= "";
		$aryTAG_DEFINE['{{__사이트이름__}}']		= $S_SITE_NM;
		$aryTAG_DEFINE['{{__회원명__}}']			= $g_member_name;
		$aryTAG_DEFINE['{{__회사명__}}']			= $S_COM_NM;
		$aryTAG_DEFINE['{{__대표자명__}}']			= $S_REP_NM;
		$aryTAG_DEFINE['{{__통신번호__}}']			= $S_COM_NUM1;
		$aryTAG_DEFINE['{{__통신번호__}}']			= $S_COM_NUM2;
		$aryTAG_DEFINE['{{__전화번호__}}']			= $S_COM_PHONE;
		$aryTAG_DEFINE['{{__개인정보_담당자__}}']	= $S_PIM_NAME;
		$aryTAG_DEFINE['{{__개인정보_이메일__}}']	= $S_PIM_MAIL;
		$aryTAG_DEFINE['{{__사이트주소__}}']		= $S_SITE_URL;
		$aryTAG_DEFINE['{{__사업자번호__}}']		= $S_COM_NUM1;
		$aryTAG_DEFINE['{{__오늘날짜__}}']			= date("Y년m월d일");
		$aryTAG_DEFINE['{{__사이트로고__}}']		= "";
		$aryTAG_DEFINE['{{__회사주소__}}']			= $S_COM_ADDR;


		function goSendMail($strCode, $strLng="")
		{
			global $aryTAG_DEFINE, $aryTAG_LIST, $S_SITE_LNG, $S_EMAIL_USE;

			## 모듈 설정
			require_once MALL_HOME . "/classes/email/email.class.php";
			require_once MALL_HOME . "/classes/file/file.handler.class.php";
			$objEmailInfo							= new EmailInfo();
			$objFile								= new FileHandler();

			## 설정 파일 설정
			include SHOP_HOME . "/layout/mail/_config.inc.php";
			$strEmSendCode							= $strCode;
			$strEmLng								= $S_SITE_LNG;
			$strEmLngLower							= strtolower($strEmLng);
			$strEmAuto								= $EM_SETTING_DATA[$strEmLng][$strEmSendCode]['EM_AUTO'];
			$strSendEmail							= $EM_SETTING_DATA[$strEmLng][$strEmSendCode]['EM_SENDER'];
			$strReceiveEmail						= $EM_SETTING_DATA[$strEmLng][$strEmSendCode]['EM_RECIPIENT'];
			$strTitle								= $EM_SETTING_DATA[$strEmLng][$strEmSendCode]['EM_TITLE'];

			## 설정 체크
			if(!$strCode) { return; }

			## 태그 재정의
			foreach($aryTAG_LIST as $key => $data):
				$aryTAG_DEFINE[$key]		= $data;
			endforeach;

			## 메일 전송 체크
			if($S_EMAIL_USE != "Y") { return; }

			## 자동 전송 유무 체크
			if($strEmAuto != "Y") { return; }

			## 2014.08.01 kim hee sung,
			## {{__받는사람메일__}} 기본으로 추가합니다.
			if($strReceiveEmail) { $strReceiveEmail .= ";"; }
			$strReceiveEmail .= "{{__받는사람메일__}}";


			## 메일 내용 설정
			$strEmailTextFile				= SHOP_HOME . "/layout/mail/mailContents_{$strEmLngLower}_{$strEmSendCode}.html";
			$strText						= $objFile->fileContents($strEmailTextFile);

			## 테그 변환
			foreach($aryTAG_DEFINE as $key => $data):
				//echo $key . ' -> ' . $data ;
				$strSendEmail				= str_replace($key, $data, $strSendEmail);
				$strReceiveEmail			= str_replace($key, $data, $strReceiveEmail);
				$strTitle					= str_replace($key, $data, $strTitle);
				$strText					= str_replace($key, $data, $strText);
			endforeach;
			$aryReceiveEmail				= explode(";", $strReceiveEmail);
			$aryReceiveEmail				= array_unique($aryReceiveEmail); // 중복제거

			## 메일 전송
			foreach($aryReceiveEmail as $data):

				## 기본 체크
				if(!$data) { continue; }

				## 메일 전송
				$param						= "";
				$param['SEND_EMAIL']		= $strSendEmail;
				$param['RECEIVE_EMAIL']		= $data;
				$param['TITLE']				= $strTitle;
				$param['TEXT']				= $strText;
				$objEmailInfo->goSendEmail($param);
			endforeach;


		}

