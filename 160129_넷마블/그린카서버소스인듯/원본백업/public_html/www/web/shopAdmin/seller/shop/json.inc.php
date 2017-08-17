<?php


	switch($strAct):

	case "shopPolicyModify":
		// 입점사 약관관리 수정

		## 모듈 설정
		$objSiteTextModule = new SiteTextModule($db);

		## 기본설정
		$strLang = $_POST['lang'];
		$strLang = strtoupper($strLang);
		$strLangLower = strtolower($strLang);
		$strPolicy = $_POST['policy'];
		$strCOL_NAME = "S_SHOP_POLICY_{$strLang}";
		$intMemberNo = $a_admin_no;

		## 체크
		if(!$strLang):
			$result['__STATE__'] = "NO_LANG";
			$result['__MSG__'] = "선택된 언어가 없습니다.";
			break;	
		endif;

		## 기존에 등록된 내용 삭제
		$param = "";
//		$param['NO']			= "";
		$param['COL']			= $strCOL_NAME;
		$re						= $objSiteTextModule->getSiteTextColDeleteEx($param);
		
		## 데이터 등록
		$param = "";
//		$param['NO']			= "";
		$param['COL']			= $strCOL_NAME;
		$param['VAL']			= $strPolicy;
		$param['REG_DT']		= "NOW()";
		$param['REG_NO']		= $intMemberNo;
		$param['MOD_DT']		= "NOW()";
		$param['MOD_NO']		= $intMemberNo;
		$intNo					= $objSiteTextModule->getSiteTextInsertEx($param);
		if(!$intNo || $intNo <= 0):
			$result['__STATE__'] = "NO_INSERT";
			$result['__MSG__'] = "등록 실패되었습니다. 관리자에게 문의하세요.";
			break;	
		endif;

		## 태그 치환
		$strPolicy = str_replace("{{__회사명__}}", $S_SITE_NM, $strPolicy);
		$strPolicy = str_replace("{{__운영쇼핑몰명__}}", $S_SITE_ENG_NM, $strPolicy);

		## 파일 생성
		$strPolicyFile = MALL_SHOP . "/conf/policy.shop.{$strLangLower}.inc.php";
		FileDevice::fileWrite($strPolicyFile, $strPolicy);

		## 마무리
		$result['__STATE__'] = "SUCCESS";
	break;

	endswitch;

	## database DisConnect
	$db->disConnect();

	## 체크
	if(!$result) { $result = print_r($_POST, true); }

	## 출력
	echo json_encode($result);

	exit;