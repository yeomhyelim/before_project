<?php

	switch($strAct):
	
	case "sliderBannerDelete":
		// 움직이는 배너 삭제

		## 모듈 설정
		$objDesignSliderBannerModule = new DesignSliderBannerModule($db);
		$objDesignSliderBannerImgModule = new DesignSliderBannerImgModule($db);


		## 기본 설정
		$intSbNo = $_POST['sb_no'];
		$strWebDir = "/upload/slider";
		$strDefaultDir = MALL_SHOP . $strWebDir;
		$strConfFileDir = MALL_SHOP . "/conf/sliderBanner";

		## 체크
		if(!$intSbNo):
			$result['__STATE__'] = "NO_SB_NO";
			$result['__MSG__'] = "삭제할 번호가 없습니다.";
			break;
		endif;

		## 데이터 불러오기(슬라이더 정보)
		$param = "";
		$param['SB_NO'] = $intSbNo;
		$aryRow = $objDesignSliderBannerModule->getDesignSliderBannerSelectEx("OP_SELECT", $param);

		## 데이터 불러오기(이미지 리스트)
		$param = "";
		$param['SB_NO'] = $intSbNo;
		$param['ORDER_BY'] = "noAsc";
		$aryImageRow = $objDesignSliderBannerImgModule->getDesignSliderBannerImgSelectEx("OP_ARYTOTAL", $param);

		## 이미지/데이터 삭제(이미지 리스트)
		if($aryImageRow):
			foreach($aryImageRow as $key => $row):
				
				## 기본정보
				$intSI_NO = $row['SI_NO'];
				$strSI_IMG = $row['SI_IMG'];

				## 삭제
				FileDevice::fileDelete("{$strDefaultDir }/{$strSI_IMG}");

				## 데이터 삭제
				$param = "";
				$param['SI_NO'] = $intSI_NO;
				$objDesignSliderBannerImgModule->getDesignSliderBannerImgDeleteEx($param);
			endforeach;
		endif;

		## 데이터 삭제(슬라이더 정보)
		$param = "";
		$param['SB_NO'] = $intSbNo;
		$objDesignSliderBannerModule->getDesignSliderBannerDeleteEx($param);

		## 마무리
		$result['__STATE__'] = "SUCCESS";
	
	break;
	
	case "sliderBannerWrite":
		// 움직이는 배너 등록

		## 모듈 설정
		$objDesignSliderBannerModule = new DesignSliderBannerModule($db);
		$objDesignSliderBannerImgModule = new DesignSliderBannerImgModule($db);

		## 기본 설정
		$strSbCode = $_POST['sb_code'];
		$intSbImagesCnt = $_POST['sb_images_cnt'];
		$strSbComment = $_POST['sb_comment'];
		$strSbLinkType = $_POST['sb_link_type'];
		$arySiNoBak = $_POST['si_no_bak'];
		$arySiText = $_POST['si_text'];
		$arySiLink = $_POST['si_link'];
		$intMemberNo = $_SESSION['ADMIN_NO'];
		$strWebDir = "/upload/slider";
		$strDefaultDir = MALL_SHOP . $strWebDir;
		$strConfFileDir = MALL_SHOP . "/conf/sliderBanner";

		## 언어 설정
		$strLang = $_POST['lang'];
		if(!$strLang) { $strLang = $strStLng; }
		$strLangLower = strtolower($strLang);

		## 코드 설정
		$strSbCode = strtoupper($strSbCode);

		## 체크
		if(!$strSbCode):
			$result['__STATE__'] = "NO_SB_CODE";
			$result['__MSG__'] = "코드 값은 반드시 필요합니다.";
			break;
		endif;
		if(!$strLang):
			$result['__STATE__'] = "NO_LANG";
			$result['__MSG__'] = "수정할 언어가 없습니다.";
			break;
		endif;
		if(!$intSbImagesCnt):
			$result['__STATE__'] = "NO_IMAGE_CNT";
			$result['__MSG__'] = "업로드할 이미지가 없습니다.";
			break;
		endif;

		## 중복 코드 체크
		## 데이터 불러오기
		$param = "";
		$param['SB_CODE'] = $strSbCode;
		$intCnt = $objDesignSliderBannerModule->getDesignSliderBannerSelectEx("OP_COUNT", $param);
		if($intCnt):
			$result['__STATE__'] = "HAVE_CODE";
			$result['__MSG__'] = "사용중인 코드값입니다.";
			break;
		endif;


		## 폴더 체크 및 생성
		if(!is_dir("{$strConfFileDir}/{$strLangLower}")):
			FileDevice::makeFolder("{$strConfFileDir}/{$strLangLower}");
			if(!is_dir("{$strConfFileDir}/{$strLangLower}")):
				$result['__STATE__'] = "NO_MAKE_DIR";
				$result['__MSG__'] = "폴더를 생성 할 수 없습니다.";
				break;
			endif;
		endif;

		## 슬라이더 정보
		## 등록
		$param						= "";
		$param['SB_CODE']			= $strSbCode;
		$param['SB_COMMENT']		= $strSbComment;
		$param['SB_W_SIZE']			= 0;
		$param['SB_H_SIZE']			= 0;
		$param['SB_LINK_TYPE']		= $strSbLinkType;
		$param['SB_REG_DT']			= "NOW()";
		$param['SB_REG_NO']			= $intMemberNo;
		$param['SB_MOD_DT']			= "NOW()";
		$param['SB_MOD_NO']			= $intMemberNo;
		$intSbNo					= $objDesignSliderBannerModule->getDesignSliderBannerInsertEx($param);

		## 체크
		if(!$intSbNo):
			$result['__STATE__'] = "NO_WRITE";
			$result['__MSG__'] = "등록 할 수 없습니다. 관리자에게 문의하세요.";
			break;
		endif;

		## 파일 업로드
		if($_FILES):

			## 그룹 폴더 만들기
			if(!FileDevice::makeFolder($strDefaultDir)):
				$result['__STATE__'] = "NO_DIR";
				$result['__MSG__'] = "그룹 폴더를 생성할 수 없습니다.";
				break;
			endif;
			
			foreach($_FILES as $key => $data):
				
				## 기본설정
				$strName = $data['name'];
				$strType = $data['type'];
				$intSize = $data['size'];
				$strError = $data['error'];
				$strSaveFileName = FileDevice::getUniqueFileName($strDefaultDir, date("YmdHis") . "_{$strSB_CODE}_%s_@_" . $strName);

				## 체크
				if($strError) { continue; }
				if(!$strSaveFileName) { continue; }

				## 파일 업로드
				$re = FileDevice::upload($key, "{$strDefaultDir}/{$strSaveFileName}");

				## 결과 저장
				if($re) { $_FILES[$key]['saveFileName'] = $strSaveFileName; }

			endforeach;
		endif;	
	
		## 이미지 리스트 
		## 등록
		for($intIdx=0;$intIdx<$intSbImagesCnt;$intIdx++):

			## 기본 설정
			$strSiLink = $arySiLink[$intIdx];
			$strSiText = $arySiText[$intIdx];
			$strSiImg = $_FILES["si_img_{$intIdx}"]['saveFileName'];
			
			## 체크
			if(!$strSiImg) { continue; }

			## 이미지 등록
			$param = "";
			$param['SB_NO']				= $intSbNo;
			$param['SI_IMG']			= $strSiImg;
			$param['SI_LINK']			= $strSiLink;
			$param['SI_TEXT']			= $strSiText;
			$param['SI_LNG']			= $strLang;
			$param['SI_REG_DT']			= "NOW()";
			$param['SI_REG_NO']			= $intMemberNo;
			$param['SI_MOD_DT']			= "NOW()";
			$param['SI_MOD_NO']			= $intMemberNo;
			$objDesignSliderBannerImgModule->getDesignSliderBannerImgInsertEx($param);

		endfor;

		## 움직이는 배너 파일로 만들기
		## 슬라이더 정보
		## 데이터 불러오기
		$param = "";
		$param['SB_NO'] = $intSbNo;
		$aryRow = $objDesignSliderBannerModule->getDesignSliderBannerSelectEx("OP_SELECT", $param);
		
		## 체크
		if(!$aryRow):
			$result['__STATE__'] = "NO_DATA";
			$result['__MSG__'] = "수정할 정보가 없습니다.";
			break;
		endif;

		## 기본 설정
		$intSB_NO				= $aryRow['SB_NO'];
		$strSB_CODE				= $aryRow['SB_CODE'];
		$strSB_COMMENT			= $aryRow['SB_COMMENT'];
		$strSB_LINK_TYPE		= $aryRow['SB_LINK_TYPE'];
		$intSB_REG_DT			= $aryRow['SB_REG_DT'];
		$strConfFileName		= "sliderBanner_{$strSB_CODE}.conf.inc.php";

		## 파일 만들기
		$strConfData = "";
		$strConfData .= "\$S_SLIDER_INFO['SB_NO'] = {$intSB_NO};\n";
		$strConfData .= "\$S_SLIDER_INFO['SB_CODE'] = '{$strSB_CODE}';\n";
		$strConfData .= "\$S_SLIDER_INFO['SB_LINK_TYPE'] = '{$strSB_LINK_TYPE}';\n";

		## 이미지 리스트
		## 데이터 불러오기
		$param = "";
		$param['SB_NO'] = $intSbNo;
		$param['SI_LNG'] = $strLang;
		$param['ORDER_BY'] = "noAsc";
		$aryImageRow = $objDesignSliderBannerImgModule->getDesignSliderBannerImgSelectEx("OP_ARYTOTAL", $param);

		if($aryImageRow):
			foreach($aryImageRow as $key => $data):
				
				## 기본설정
				$strSI_IMG = $data['SI_IMG'];
				$strSI_LINK= $data['SI_LINK'];
				$strSI_TEXT = $data['SI_TEXT'];
				
				## 파일 만들기
				$strConfData .= "\$S_SLIDER_INFO['SI_IMG'][] = '{$strSI_IMG}';\n";
				$strConfData .= "\$S_SLIDER_INFO['SI_LINK'][] = '{$strSI_LINK}';\n";
				$strConfData .= "\$S_SLIDER_INFO['SI_TEXT'][] = '{$strSI_TEXT}';\n";

			endforeach;
		endif;

		## 파일 만들기
		FileDevice::getMadeInfo("{$strConfFileDir}/{$strLangLower}/{$strConfFileName}", $strConfData, "## SLIDER");

		## 마무리
		$result['__STATE__'] = "SUCCESS";

	break;

	case "sliderBannerModify":
		// 움직이는 배너 수정

		## 모듈 설정
		$objDesignSliderBannerModule = new DesignSliderBannerModule($db);
		$objDesignSliderBannerImgModule = new DesignSliderBannerImgModule($db);

		## 기본 설정
		$intSbNo = $_POST['sb_no'];
		$strSbComment = $_POST['sb_comment'];
		$strSbLinkType = $_POST['sb_link_type'];
		$arySiNoBak = $_POST['si_no_bak'];
		$arySiText = $_POST['si_text'];
		$arySiLink = $_POST['si_link'];
		$intMemberNo = $_SESSION['ADMIN_NO'];
		$strLang = $strStLng;
		$strLangLower = strtolower($strLang);
		$strWebDir = "/upload/slider";
		$strDefaultDir = MALL_SHOP . $strWebDir;
		$strConfFileDir = MALL_SHOP . "/conf/sliderBanner";

		## 체크
		if(!$intSbNo):
			$result['__STATE__'] = "NO_SB_NO";
			$result['__MSG__'] = "수정할 정보가 없습니다.";
			break;
		endif;
		if(!$strLang):
			$result['__STATE__'] = "NO_LANG";
			$result['__MSG__'] = "수정할 언어가 없습니다.";
			break;
		endif;

		## 폴더 체크 및 생성
		if(!is_dir("{$strConfFileDir}/{$strLangLower}")):
			FileDevice::makeFolder("{$strConfFileDir}/{$strLangLower}");
			if(!is_dir("{$strConfFileDir}/{$strLangLower}")):
				$result['__STATE__'] = "NO_MAKE_DIR";
				$result['__MSG__'] = "폴더를 생성 할 수 없습니다.";
				break;
			endif;
		endif;

		## 슬라이더 정보
		## 데이터 불러오기
		$param = "";
		$param['SB_NO'] = $intSbNo;
		$aryRow = $objDesignSliderBannerModule->getDesignSliderBannerSelectEx("OP_SELECT", $param);

		## 체크
		if(!$aryRow):
			$result['__STATE__'] = "NO_DATA";
			$result['__MSG__'] = "수정할 정보가 없습니다.";
			break;
		endif;

		## 기본 설정
		$intSB_NO				= $aryRow['SB_NO'];
		$strSB_CODE				= $aryRow['SB_CODE'];
		$strSB_COMMENT			= $aryRow['SB_COMMENT'];
		$strSB_LINK_TYPE		= $aryRow['SB_LINK_TYPE'];
		$intSB_REG_DT			= $aryRow['SB_REG_DT'];

		## 업데이트
		$param						= "";
		$param['SB_NO']				= $intSbNo;
		$param['SB_COMMENT']		= $strSbComment;
		$param['SB_LINK_TYPE']		= $strSbLinkType;
		$param['SB_MOD_DT']			= "NOW()";
		$param['SB_MOD_NO']			= $intMemberNo;
		$objDesignSliderBannerModule->getDesignSliderBannerUpdateEx($param);

		## 이미지 리스트
		## 데이터 불러오기
		$param = "";
		$param['SB_NO'] = $intSbNo;
		$param['SI_LNG'] = $strLang;
		$param['ORDER_BY'] = "noAsc";
		$aryImageRow = $objDesignSliderBannerImgModule->getDesignSliderBannerImgSelectEx("OP_ARYTOTAL", $param);

		## 삭제된 데이터 체크
		if($aryImageRow):
			foreach($aryImageRow as $key => $data):
				
				## 기본설정
				$intSI_NO = $data['SI_NO'];
				$strSI_IMG = $data['SI_IMG'];

				## 삭제된 데이터 체크
				if(!in_array($intSI_NO, $arySiNoBak)):
					
					## 이미지 체크
					if($strSI_IMG) { $strSI_IMG = "{$strDefaultDir}/{$strSI_IMG}"; }

					## 삭제
					if(is_file($strSI_IMG)) { unlink($strSI_IMG); }

					## 데이터베이스 삭제
					$param = "";
					$param['SI_NO'] = $intSI_NO;
					$objDesignSliderBannerImgModule->getDesignSliderBannerImgDeleteEx($param);

				endif;

			endforeach;
		endif;

		## 파일 업로드
		if($_FILES):

			## 그룹 폴더 만들기
			if(!FileDevice::makeFolder($strDefaultDir)):
				$result['__STATE__'] = "NO_DIR";
				$result['__MSG__'] = "그룹 폴더를 생성할 수 없습니다.";
				break;
			endif;
			
			foreach($_FILES as $key => $data):
				
				## 기본설정
				$strName = $data['name'];
				$strType = $data['type'];
				$intSize = $data['size'];
				$strError = $data['error'];
				$strSaveFileName = FileDevice::getUniqueFileName($strDefaultDir, date("YmdHis") . "_{$strSB_CODE}_%s_@_" . $strName);

				## 체크
				if($strError) { continue; }
				if(!$strSaveFileName) { continue; }

				## 파일 업로드
				$re = FileDevice::upload($key, "{$strDefaultDir}/{$strSaveFileName}");

				## 결과 저장
				if($re) { $_FILES[$key]['saveFileName'] = $strSaveFileName; }

			endforeach;
		endif;	

		## 수정 및 신규 이미지 등록
		if($arySiNoBak):
			foreach($arySiNoBak as $intIdx => $intSiNo):
				
				## 기본 설정
				$strSiLink = $arySiLink[$intIdx];
				$strSiText = $arySiText[$intIdx];
				$strSiImg = $_FILES["si_img_{$intIdx}"]['saveFileName'];
				
				if($intSiNo == -1):
					## 신규 등록
					
					$param = "";
					$param['SB_NO']				= $intSbNo;
					$param['SI_IMG']			= $strSiImg;
					$param['SI_LINK']			= $strSiLink;
					$param['SI_TEXT']			= $strSiText;
					$param['SI_LNG']			= $strLang;
					$param['SI_REG_DT']			= "NOW()";
					$param['SI_REG_NO']			= $intMemberNo;
					$param['SI_MOD_DT']			= "NOW()";
					$param['SI_MOD_NO']			= $intMemberNo;
					$objDesignSliderBannerImgModule->getDesignSliderBannerImgInsertEx($param);

				else:
					## 수정

					## 이미지 업데이트시 기존 이미지 삭제
					## 이미지 업데이트가 없다면, 기존 이미지 사용.
					foreach($aryImageRow as $row):
					
						## 기본설정
						$intSI_NO = $row['SI_NO'];
						$strSI_IMG = $row['SI_IMG'];

						## 체크
						if(!$strSI_IMG) { continue; }
						if($intSI_NO != $intSiNo) { continue; }

						if(!$strSiImg):
							$strSiImg = $strSI_IMG;
							break;
						endif;
							
						## 이미지 체크
						if($strSI_IMG) { $strSI_IMG = "{$strDefaultDir}/{$strSI_IMG}"; }

						## 삭제
						if(is_file($strSI_IMG)) { unlink($strSI_IMG); }

						break;

					endforeach;

					## 업데이트
					$param = "";
					$param['SI_NO']				= $intSiNo;
					$param['SI_IMG']			= $strSiImg;
					$param['SI_LINK']			= $strSiLink;
					$param['SI_TEXT']			= $strSiText;
					$param['SI_MOD_DT']			= "NOW()";
					$param['SI_MOD_NO']			= $intMemberNo;
					$objDesignSliderBannerImgModule->getDesignSliderBannerImgUpdateEx($param);

				endif;

			endforeach;
		endif;

		## 움직이는 배너 파일로 만들기
		## 슬라이더 정보
		## 데이터 불러오기
		$param = "";
		$param['SB_NO'] = $intSbNo;
		$aryRow = $objDesignSliderBannerModule->getDesignSliderBannerSelectEx("OP_SELECT", $param);
		
		## 체크
		if(!$aryRow):
			$result['__STATE__'] = "NO_DATA";
			$result['__MSG__'] = "수정할 정보가 없습니다.";
			break;
		endif;

		## 기본 설정
		$intSB_NO				= $aryRow['SB_NO'];
		$strSB_CODE				= $aryRow['SB_CODE'];
		$strSB_COMMENT			= $aryRow['SB_COMMENT'];
		$strSB_LINK_TYPE		= $aryRow['SB_LINK_TYPE'];
		$intSB_REG_DT			= $aryRow['SB_REG_DT'];
		$strConfFileName		= "sliderBanner_{$strSB_CODE}.conf.inc.php";

		## 파일 만들기
		$strConfData = "";
		$strConfData .= "\$S_SLIDER_INFO['SB_NO'] = {$intSB_NO};\n";
		$strConfData .= "\$S_SLIDER_INFO['SB_CODE'] = '{$strSB_CODE}';\n";
		$strConfData .= "\$S_SLIDER_INFO['SB_LINK_TYPE'] = '{$strSB_LINK_TYPE}';\n";

		## 이미지 리스트
		## 데이터 불러오기
		$param = "";
		$param['SB_NO'] = $intSbNo;
		$param['SI_LNG'] = $strLang;
		$param['ORDER_BY'] = "noAsc";
		$aryImageRow = $objDesignSliderBannerImgModule->getDesignSliderBannerImgSelectEx("OP_ARYTOTAL", $param);

		if($aryImageRow):
			foreach($aryImageRow as $key => $data):
				
				## 기본설정
				$strSI_IMG = $data['SI_IMG'];
				$strSI_LINK= $data['SI_LINK'];
				$strSI_TEXT = $data['SI_TEXT'];
				
				## 파일 만들기
				$strConfData .= "\$S_SLIDER_INFO['SI_IMG'][] = '{$strSI_IMG}';\n";
				$strConfData .= "\$S_SLIDER_INFO['SI_LINK'][] = '{$strSI_LINK}';\n";
				$strConfData .= "\$S_SLIDER_INFO['SI_TEXT'][] = '{$strSI_TEXT}';\n";

			endforeach;
		endif;

		## 파일 만들기
		FileDevice::getMadeInfo("{$strConfFileDir}/{$strLangLower}/{$strConfFileName}", $strConfData, "## SLIDER");

		## 마무리
		$result['__STATE__'] = "SUCCESS";
	break;

	endswitch;


