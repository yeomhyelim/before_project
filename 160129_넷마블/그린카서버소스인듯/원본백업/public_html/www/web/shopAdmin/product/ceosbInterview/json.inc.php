<?php
	switch($strAct):
	case "ceosbInterviewWrite":
		// ceosb 인터뷰 컬럼 쓰기

		## 모듈 설정
		require_once MALL_HOME . "/module2/CeosbInterviewColumn.module.php";
		require_once MALL_HOME . "/classes/file/file.handler.class.php";
		require_once MALL_HOME . "/classes/image/image.func.class.php";
		$ceosbInterviewColumn			= new CeosbInterviewColumnModule($db);
		$file							= new FileHandler();
		$image							= new ImageFunc();	

		## 기본 설정
		$intKind						= $_POST['kind'];
		$strTitle						= $_POST['title'];
		$strSummary						= $_POST['summary'];
		$strReview						= $_POST['review'];
		$strText						= $_POST['text'];
		$strKeyword						= $_POST['keyword'];
//		$strListImage					= $_POST['listImage'];
//		$strViewImage					= $_POST['viewImage'];
		$strAdminLogin					= $_SESSION['ADMIN_LOGIN'];
		$strAdminNo						= $_SESSION['ADMIN_NO'];

		$aryImageSizeDefault['listImage'] = array("width" => "85", "height" => "85");
		$aryImageSizeDefault['viewImage'] = array("width" => "400", "height" => "350");


		## 기본 설정 체크
		if(!$strTitle):
			$result['__STATE__']	= "NO_TITLE";
			$result['__MSG__']		= "제목이 없습니다.";
			break;
		endif;

		if(!$strAdminLogin):
			$result['__STATE__']	= "NO_LOGIN";
			$result['__MSG__']		= "글작성 권한이 없습니다.";
			break;
		endif;

		if(!$strAdminNo):
			$result['__STATE__']	= "NO_LOGIN";
			$result['__MSG__']		= "글작성 권한이 없습니다.";
			break;
		endif;

		## 코드 생성
		$strIcCode								="";	
		for($i=0;$i<10;$i++):
			$strIcCode							= date("ym") . rand();
			$strIcCode							= substr($strIcCode, 0, 15);

			$param								= "";
			$param['IC_CODE']					= $strIcCode;
			$re									= $ceosbInterviewColumn->getCeosbInterviewColumnSelectEx("OP_COUNT", $param);

			if($re == 0) { break; }
			
			$strIcCode							= "";
		endfor;

		if(!$strIcCode):
			$result['__STATE__']	= "NO_CODE";
			$result['__MSG__']		= "신규 코드를 생성하지 못하였습니다. 잠시후에 다시 등록하시기 바랍니다.";
			break;
		endif;

		## 파일 업로드

		if($_FILES):
			## 기본설정
			$tempDir								= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/upload/ceosbInterview/" . date("Ym");
			$tempWebDir								= "/upload/ceosbInterview/" . date("Ym");
			$aryTempFile							= array();
			$state									= 1;

			## 폴더 만들기
			$file->makeFolder($tempDir);

			## 파일 생성
			foreach($_FILES as $key => $data):
				$name				= $key;
				if($name):
					$aryUpLoadInfo					= "";
					$aryUpLoadInfo['F_NAME']		= $name;
					$aryUpLoadInfo['F_FILTER']		= "jpg;gif;png";
					$aryUpLoadInfo['F_SPATH']		= "{$tempDir}/";
					$aryUpLoadInfo['F_SFNAME']		= date("YmdHis") . "_" . $key;
					$re								= $file->getFileUpload($aryUpLoadInfo);
					$aryTempFile[$name]['name']		= $aryUpLoadInfo['F_SFNAME'];
					$aryTempFile[$name]['state']	= $re;
					if($state):
						$state						= $re;
						$filename					= "{$tempDir}/{$aryUpLoadInfo['F_SFNAME']}";
						$newFilename				= "{$tempDir}/{$aryUpLoadInfo['F_SFNAME']}";
						$width						= $aryImageSizeDefault[$key]['width'];
						$height						= $aryImageSizeDefault[$key]['height'];
						$image->getImageResize($filename, $newFilename, $width, $height);
					endif;
				endif;
			endforeach;
			## 파일명 설정
			foreach($aryTempFile as $key => $data):
				${$key}					= "{$tempWebDir}/{$data['name']}";
			endforeach;
		endif;

		## 글등록
		$param['IC_CODE']				= $strIcCode;
		$param['IC_TITLE']				= $strTitle;
		$param['IC_KIND']				= $intKind;
		$param['IC_SUMMARY']			= $strSummary;
		$param['IC_PREVIEW']			= $strReview;
		$param['IC_TEXT']				= $strText;
		$param['IC_KEYWORD']			= $strKeyword;
//		$param['IC_VISIT_CNT']			= "";
		$param['IC_IMAGE1']				= $listImage;
		$param['IC_IMAGE2']				= $viewImage;
		$param['IC_IMAGE3']				= "";
//		$param['IC_USE']				= "";
		$param['IC_REG_DT']				= "NOW()";
		$param['IC_REG_NO']				= $strAdminNo;
		$param['IC_MOD_DT']				= "NOW()";
		$param['IC_MOD_NO']				= $strAdminNo;
		$ceosbInterviewColumn->getCeosbInterviewColumnInsertEx($param);

		// 마무리
		$result['__STATE__']		= "SUCCESS";
		
	break;

	case "ceosbInterviewModify":
		// ceosb 인터뷰 컬럼 수정

		## 모듈 설정
		require_once MALL_HOME . "/module2/CeosbInterviewColumn.module.php";
		require_once MALL_HOME . "/classes/file/file.handler.class.php";
		require_once MALL_HOME . "/classes/image/image.func.class.php";
		$ceosbInterviewColumn			= new CeosbInterviewColumnModule($db);
		$file							= new FileHandler();
		$image							= new ImageFunc();	

		## 기본 설정
		$strIcCode						= $_POST['icCode'];
		$strTitle						= $_POST['title'];
		$intKind						= $_POST['kind'];
		$strSummary						= $_POST['summary'];
		$strReview						= $_POST['review'];
		$strText						= $_POST['text'];
		$strKeyword						= $_POST['keyword'];
		$strUse							= $_POST['use'];
//		$strListImage					= $_POST['listImage'];
//		$strViewImage					= $_POST['viewImage'];
//		$strListImageDel				= $_POST['listImageDel'];
//		$strViewImageDel				= $_POST['viewImageDel'];
		$strAdminLogin					= $_SESSION['ADMIN_LOGIN'];
		$strAdminNo						= $_SESSION['ADMIN_NO'];


		$aryImageSizeDefault['listImage'] = array("width" => "85", "height" => "85");
		$aryImageSizeDefault['viewImage'] = array("width" => "400", "height" => "350");

		## 기본 설정 체크
		if(!$strTitle):
			$result['__STATE__']	= "NO_TITLE";
			$result['__MSG__']		= "제목이 없습니다.";
			break;
		endif;

		if(!$strIcCode):
			$result['__STATE__']	= "NO_CODE";
			$result['__MSG__']		= "수정코드가 없습니다.";
			break;
		endif;

		if(!$strAdminLogin):
			$result['__STATE__']	= "NO_LOGIN";
			$result['__MSG__']		= "글작성 권한이 없습니다.";
			break;
		endif;

		if(!$strAdminNo):
			$result['__STATE__']	= "NO_LOGIN";
			$result['__MSG__']		= "글작성 권한이 없습니다.";
			break;
		endif;

		## 내용 가져오기
		$param							= "";
		$param['IC_CODE']				= $strIcCode;
		$ceosbInterviewColumnRow		= $ceosbInterviewColumn->getCeosbInterviewColumnSelectEx("OP_SELECT", $param);	

		## 내용 설정
		$strImage1						= $ceosbInterviewColumnRow['IC_IMAGE1'];
		$strImage2						= $ceosbInterviewColumnRow['IC_IMAGE2'];

		## 내용 체크
		if(!$ceosbInterviewColumnRow):
			echo "내용이 없습니다.";
			exit;
		endif;

		## 파일 업로드
		if($_FILES):
			## 기본설정
			$tempDir								= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/upload/ceosbInterview/" . date("Ym");
			$tempWebDir								= "/upload/ceosbInterview/" . date("Ym");
			$aryTempFile							= array();
			$state									= 1;

			## 폴더 만들기
			$file->makeFolder($tempDir);

			## 파일 생성
			foreach($_FILES as $name => $data):

				if(!$data['name']) { continue; }
				if(!$name) { continue; }

				$aryUpLoadInfo					= "";
				$aryUpLoadInfo['F_NAME']		= $name;
				$aryUpLoadInfo['F_FILTER']		= "jpg;gif;png";
				$aryUpLoadInfo['F_SPATH']		= "{$tempDir}/";
				$aryUpLoadInfo['F_SFNAME']		= date("YmdHis") . "_" . $name;
				$state							= $file->getFileUpload($aryUpLoadInfo);
				$aryTempFile[$name]['name']		= $aryUpLoadInfo['F_SFNAME'];
				$aryTempFile[$name]['state']	= $state;
				if($state):
					$filename					= "{$tempDir}/{$aryUpLoadInfo['F_SFNAME']}";
					$newFilename				= "{$tempDir}/{$aryUpLoadInfo['F_SFNAME']}";
					$width						= $aryImageSizeDefault[$name]['width'];
					$height						= $aryImageSizeDefault[$name]['height'];
					$image->getImageResize($filename, $newFilename, $width, $height);
				endif;

			endforeach;
			## 파일명 설정
			foreach($aryTempFile as $key => $data):
				${$key}					= "{$tempWebDir}/{$data['name']}";
				$_POST["{$key}Del"]		= "Y";
			endforeach;
		endif;

		## 파일 삭제
		$strListImageDel				= $_POST['listImageDel'];
		$strViewImageDel				= $_POST['viewImageDel'];

		if($strListImageDel == "Y") { $file->fileDelete("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/{$strImage1}"); }
		else						{ $listImage	= $strImage1; }
		if($strViewImageDel == "Y") { $file->fileDelete("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/{$strImage2}"); }
		else						{ $viewImage	= $strImage2; }

		## 글수정
		$param['IC_CODE']				= $strIcCode;
		$param['IC_TITLE']				= $strTitle;
		$param['IC_KIND']				= $intKind;
		$param['IC_SUMMARY']			= $strSummary;
		$param['IC_PREVIEW']			= $strReview;
		$param['IC_TEXT']				= $strText;
		$param['IC_KEYWORD']			= $strKeyword;
//		$param['IC_VISIT_CNT']			= "";
		$param['IC_IMAGE1']				= $listImage;
		$param['IC_IMAGE2']				= $viewImage;
//		$param['IC_IMAGE3']				= "";
		$param['IC_USE']				= $strUse;
//		$param['IC_REG_DT']				= "NOW()";
//		$param['IC_REG_NO']				= $strAdminNo;
		$param['IC_MOD_DT']				= "NOW()";
		$param['IC_MOD_NO']				= $strAdminNo;
		$ceosbInterviewColumn->getCeosbInterviewColumnUpdateEx($param);

		// 마무리
		$result['__STATE__']		= "SUCCESS";
	break;

	case "ceosbInterviewDelete":
		// ceosb 인터뷰 컬럼 삭제

		## 모듈 설정
		require_once MALL_HOME . "/module2/CeosbInterviewColumn.module.php";
		require_once MALL_HOME . "/module2/BoardData.module.php";
		$ceosbInterviewColumn			= new CeosbInterviewColumnModule($db);
		$boardData						= new BoardDataModule($db);

		## 기본 설정
		$strIcCode						= $_POST['icCode'];

		## 기본 설정 체크
		if(!$strIcCode):
			$result['__STATE__']		= "NO_CODE";
			$result['__MSG__']			= "삭제코드가 없습니다.";
			break;
		endif;

		## 상품 리뷰 갯수가 1개 이상인경우 삭제 방지.
		$param							= "";
		$param['B_CODE']				= "PROD_REVIEW";
		$param['UB_P_CODE']				= $strIcCode;
		$intTotalCnt					= $boardData->getBoardDataSelectEx("OP_COUNT", $param);

		## 상품 리뷰 개수 체크
		if($intTotalCnt > 0):
			$result['__STATE__']		= "HAVE_PROD_REVIEW_DATA";
			$result['__MSG__']			= "리뷰글이 있는경우 삭제할수 없습니다.";
			break;
		endif;

		## 내용 가져오기
		$param							= "";
		$param['IC_CODE']				= $strIcCode;
		$ceosbInterviewColumnRow		= $ceosbInterviewColumn->getCeosbInterviewColumnSelectEx("OP_SELECT", $param);	

		## 내용 설정
		$strImage1						= $ceosbInterviewColumnRow['IC_IMAGE1'];
		$strImage2						= $ceosbInterviewColumnRow['IC_IMAGE2'];

		## 내용 체크
		if(!$ceosbInterviewColumnRow):
			$result['__STATE__']		= "NO_DATA";
			$result['__MSG__']			= "삭제데이터가 없습니다.";
			exit;
		endif;

		## 이미지 파일 삭제
		if($strImage1) { unlink(SHOP_HOME . $strImage1); }
		if($strImage2) { unlink(SHOP_HOME . $strImage2); }

		## 데이터 삭제
		$param							= "";
		$param['IC_CODE']				= $strIcCode;
		$ceosbInterviewColumn->getCeosbInterviewColumnDeleteEx($param);

		// 마무리
		$result['__STATE__']			= "SUCCESS";
	break;

	endswitch;

