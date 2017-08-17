<?php

	switch($strAct):

	case "skinRestore":
		// 스킨 복구
		// 스킨을 복구할때, 기존에 적용된 데이터는 삭제됩니다. 심성일 이사님 요청사항


		## 모듈 설정
		$objSiteInfoModule = new SiteInfoModule($db);

		## 기본 설정
		$strSkinBak = $_POST['skinBak'];
		$strMallHome = MALL_HOME;
		$strMallShop = MALL_SHOP;
		$strLayoutBakFolder = "{$strMallShop}/layout/layout-bak";
		$strLayoutBakFolderTarget = "{$strLayoutBakFolder}/{$strSkinBak}";
		list($strSkinBakDate, $strSkinBakCode) = explode("@", $strSkinBak, 2);

		## 복구할 폴더 설정
		$aryFolderList[] = "/layout/html";
		$aryFolderList[] = "/layout/css";
		$aryFolderList[] = "/upload/skin";

		## 체크
		if(!$strSkinBak):
			$result['__STATE__'] = "NO_SKIN_BAK";
			$result['__MSG__'] = "백업 정보가 없습니다.";
			break;
		endif;
		if(!$strSkinBakDate):
			$result['__STATE__'] = "NO_SKIN_BAK_DATE";
			$result['__MSG__'] = "지정된 형식이 아닙니다. 관리자에게 문의하세요.";
			break;
		endif;
		if(!$strSkinBakCode):
			$result['__STATE__'] = "NO_SKIN_BAK_CODE";
			$result['__MSG__'] = "지정된 형식이 아닙니다. 관리자에게 문의하세요.";
			break;
		endif;
		if(!$strMallHome || $strMallHome == "MALL_HOME"):
			$result['__STATE__'] = "NO_MALL_HOME";
			$result['__MSG__'] = "홈디렉토리 정보가 없습니다. 관리자에게 문의하세요.";
			break;
		endif;
		if(!$strMallShop || $strMallShop == "MALL_SHOP"):
			$result['__STATE__'] = "NO_MALL_SHOP";
			$result['__MSG__'] = "샵디렉토리 정보가 없습니다. 관리자에게 문의하세요.";
			break;
		endif;
		if(!is_dir($strLayoutBakFolderTarget)):
			$result['__STATE__'] = "NO_BACKUP_FOLDER";
			$result['__MSG__'] = "선택한 백업 정보가 없습니다. 관리자에게 문의하세요.";
			break;
		endif;

		## 기존 데이터 삭제
		foreach($aryFolderList as $strFolder):

			## 기본 설정
			$strFolderName = "{$strMallShop}{$strFolder}";

			## 체크
			if(!is_dir($strFolderName)) { continue; }

			## 폴더 삭제
			FileDevice::dirDelete($strFolderName);

		endforeach;


		## 데이터 복구(복사가 아님)
		foreach($aryFolderList as $strFolder):

			## 기본 설정
			$strOldName = "{$strLayoutBakFolderTarget}{$strFolder}";
			$strNewName = "{$strMallShop}{$strFolder}";

			## 체크
			if(!is_dir($strOldName)) { continue; }

			## 백업할 폴더 생성
			FileDevice::makeFolder($strNewName);

			## 폴더 변경
			rename($strOldName, $strNewName);
//			FileDevice::getCopyDir($strOldName, $strNewName);
	
			## 권한 변경
			exec("chmod 707 -R {$strNewName}");

		endforeach;

		## 복구된 백업 폴더 삭제
		FileDevice::dirDelete($strLayoutBakFolderTarget);

		## 사용중인 스킨 삭제
		$param = "";
		$param['COL'] = 'S_SKIN_CODE';
		$objSiteInfoModule->getSiteInfoDeleteEx($param);
		
		## 사용 스킨 데이터베이스 변경
		$param = "";
		$param['COL']			= 'S_SKIN_CODE';
		$param['VAL']			= $strSkinBakCode;
		$param['VIEW']			= "Y";
		$param['MEMO']			= "사용중인 스킨 코드입니다.";
		$param['REG_DT']		= "NOW()";
		$param['REG_NO']		= $intMemberNo;
		$param['MOD_DT']		= "NOW()";
		$param['MOD_NO']		= $intMemberNo;
		$objSiteInfoModule->getSiteInfoInsertEx($param);

		## 마무리
		$result['__STATE__'] = "SUCCESS";
	
	break;

	case "skinModify":
		// 스킨 수정

		## 모듈 설정
		$objSiteInfoModule = new SiteInfoModule($db);

		## 기본 설정
		$strSmCode = $_POST['smCode'];
		$strMallHome = MALL_HOME;
		$strMallShop = MALL_SHOP;
		$strLayoutBakFolder = "{$strMallShop}/layout/layout-bak";
		$strLayoutSkinFolder = "/home/shop_eng/_skin/{$strSmCode}";
		$intMemberNo = $a_admin_no;

		## 복사할 폴더 설정
		$aryFolderList[] = "/layout/html";
		$aryFolderList[] = "/layout/css";
		$aryFolderList[] = "/upload/skin";

		## 체크
		if(!$strSmCode):
			$result['__STATE__'] = "NO_SKIN_CODE";
			$result['__MSG__'] = "스킨코드 정보가 없습니다.";
			break;
		endif;
		if(!$strMallHome || $strMallHome == "MALL_HOME"):
			$result['__STATE__'] = "NO_MALL_HOME";
			$result['__MSG__'] = "홈디렉토리 정보가 없습니다. 관리자에게 문의하세요.";
			break;
		endif;
		if(!$strMallShop || $strMallShop == "MALL_SHOP"):
			$result['__STATE__'] = "NO_MALL_SHOP";
			$result['__MSG__'] = "샵디렉토리 정보가 없습니다. 관리자에게 문의하세요.";
			break;
		endif;
		if(!is_dir($strLayoutSkinFolder)):
			$result['__STATE__'] = "NO_SKIN_FOLDER";
			$result['__MSG__'] = "선택한 스킨 정보가 없습니다. 관리자에게 문의하세요.";
			break;
		endif;

		## 사용중인 스킨 정보 불러오기
		$param = "";
		$param['COL'] = 'S_SKIN_CODE';
		$arySiteInfo = $objSiteInfoModule->getSiteInfoSelectEx("OP_SELECT", $param);
		$strSmCodeOld = $arySiteInfo['VAL'];

		## 백업 대상 폴더 설정
		if(!$strSmCodeOld) { $strSmCodeOld = "noNameSkin"; }
		$strLayoutBakFolderTarget = "{$strLayoutBakFolder}/" . date("YmdHis") . "@{$strSmCodeOld}";

		## 백업폴더 체크 및 생성
		if(!is_dir($strLayoutBakFolderTarget)):
			 FileDevice::makeFolder($strLayoutBakFolderTarget);
			if(!is_dir($strLayoutBakFolderTarget)):
				$result['__STATE__'] = "NO_BAKUP_FOLDER";
				$result['__MSG__'] = "백업 폴더를 생성 할 수 없습니다. 관리자에게 문의하세요.";
				break;
			endif;
		endif;

		## 기존 데이터 백업
		foreach($aryFolderList as $strFolder):

			## 기본 설정
			$strOldName = "{$strMallShop}{$strFolder}";
			$strNewName = "{$strLayoutBakFolderTarget}{$strFolder}";

			## 체크
			if(!is_dir($strOldName)) { continue; }

			## 백업할 폴더 생성
			FileDevice::makeFolder($strNewName);

			## 폴더 변경
			rename($strOldName, $strNewName);

			## 권한 변경
			## 권한을 변경하지 않으면 데이터 수정을 수동으로 할 수없음. 
			exec("chmod 707 -R {$strNewName}");

		endforeach;

		## 선택한 데이터 복사
		foreach($aryFolderList as $strFolder):

			## 기본 설정
			$strOldName = "{$strLayoutSkinFolder}{$strFolder}";
			$strNewName = "{$strMallShop}{$strFolder}";

			## 체크
			if(!is_dir($strOldName)) { continue; }

			## 백업할 폴더 생성
			FileDevice::makeFolder($strNewName);

			## 폴더 변경
//			copy($strOldName, $strNewName);
//			exec("cp -r -a -v -p {$strOldName} {$strNewName}");
//			$a = "cp -r -a -v -p {$strOldName} {$strNewName}";
			FileDevice::getCopyDir($strOldName, $strNewName);
		endforeach;

		## 사용중인 스킨 삭제
		$param = "";
		$param['COL'] = 'S_SKIN_CODE';
		$objSiteInfoModule->getSiteInfoDeleteEx($param);
		
		## 사용 스킨 데이터베이스 변경
		$param = "";
		$param['COL']			= 'S_SKIN_CODE';
		$param['VAL']			= $strSmCode;
		$param['VIEW']			= "Y";
		$param['MEMO']			= "사용중인 스킨 코드입니다.";
		$param['REG_DT']		= "NOW()";
		$param['REG_NO']		= $intMemberNo;
		$param['MOD_DT']		= "NOW()";
		$param['MOD_NO']		= $intMemberNo;
		$objSiteInfoModule->getSiteInfoInsertEx($param);

		## 마무리
		$result['__STATE__'] = "SUCCESS";	

	break;

	endswitch;


