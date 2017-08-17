<?php

	switch($strAct):

	case "skinSave":
		// 세부페이지 설정 저장

		## 모듈 설정
		$objDesignSetModule = new DesignSetModule($db);

		## 데이터 저장



	break;

	case "prodDisplayModify":
		// 진열장 관리 수정
		// MAIN OR SUB
	
		## 모듈 설정
		$objIconMgrModule = new IconMgrModule($db);
	
		## 기본설정
		$intMemberNo = $a_admin_no;	
		$strSubPageCode = $_POST['subPageCode'];

		## MAIN or SUB 설정
		$strIC_TYPE = "MAIN";
		if($strSubPageCode == "PL0001") { $strIC_TYPE = "SUB"; }

		## MAIN 불러오기
		$param = "";
		$param['IC_TYPE'] = $strIC_TYPE;
		$param['ORDER_BY'] = "icCodeAsc";
		$aryIconList = $objIconMgrModule->getIconMgrSelectEx("OP_ARYTOTAL", $param);
		$aryIconInfo = "";
		foreach($aryIconList as $key => $data):
			## 기본설정
			$intIC_NO = $data['IC_NO'];
			$intIC_CODE = $data['IC_CODE'];
			$strIC_NAME = $data['IC_NAME'];
			$strIC_IMG = $data['IC_IMG'];
			$strIC_USE = $data['IC_USE'];

			## 사용유무 설정
			if(!$strIC_USE) { $strIC_USE = "N"; }

			## 만들기	
			$aryIconInfo[$intIC_CODE]['IC_NO'] = $intIC_NO;
			$aryIconInfo[$intIC_CODE]['NAME'] = $strIC_NAME;
			$aryIconInfo[$intIC_CODE]['IMG'] = $strIC_IMG;
			$aryIconInfo[$intIC_CODE]['USE'] = $strIC_USE;
		endforeach;

		## MAIN ICON 등록
		for($i=1;$i<=5;$i++):
			$strNAME = $_POST["name_{$i}"];
			$intIC_NO = $aryIconInfo[$i]['IC_NO'];
//			$strNAME = $aryIconInfo[$i]['NAME'];
			$strIMG = $aryIconInfo[$i]['IMG'];
			$strUSE = $aryIconInfo[$i]['USE'];

			## 파일명이 없으면 사용안함.
			if(!$strNAME) { $strUSE = "N"; }

			if(!$intIC_NO):
				## 신규 등록
				$param						= "";
				$param['IC_TYPE']			= $strIC_TYPE;
				$param['IC_CODE']			= $i;
				$param['IC_NAME']			= $strNAME;
				$param['IC_IMG']			= $strIMG;
				$param['IC_USE']			= $strUSE;
				$param['IC_REG_DT']			= "NOW()";
				$param['IC_REG_NO']			= $intMemberNo;
				$param['IC_MOD_DT']			= "NOW()";
				$param['IC_MOD_NO']			= $intMemberNo;
				$objIconMgrModule->getIconMgrInsertEx($param);
			else:
				## 업데이트
				$param						= "";
				$param['IC_NO']				= $intIC_NO;
				$param['IC_TYPE']			= $strIC_TYPE;
				$param['IC_CODE']			= $i;
				$param['IC_NAME']			= $strNAME;
				$param['IC_IMG']			= $strIMG;
				$param['IC_USE']			= $strUSE;
				$param['IC_MOD_DT']			= "NOW()";
				$param['IC_MOD_NO']			= $intMemberNo;
				$objIconMgrModule->getIconMgrUpdateEx($param);
			endif;
		endfor;

		## 파일 만들기
		include MALL_ADMIN . "/product/prodDisplay/prodListIconMakeFile.php";

		## 마무리
		$result['__STATE__'] = "SUCCESS";

	break;

	case "skinSavePL":
		// 상품리스트

		## 모듈 설정
		$objIconMgrModule = new IconMgrModule($db);
		$objDesignSetModule = new DesignSetModule($db);

		## 기본설정
		$strPL_TOP_USE_OP_Y = $_POST['PL_TOP_USE_OP_Y'];
		$strPL_SUB_CATE_USE = $_POST['PL_SUB_CATE_USE'];
		$intMemberNo = $a_admin_no;

		## DESIGN_SET 데이터 설정
		$aryDesignSet['PL_TOP_USE_OP_Y'] = $strPL_TOP_USE_OP_Y;
		$aryDesignSet['PL_SUB_CATE_USE'] = $strPL_SUB_CATE_USE;

		## DESIGN_SET 데이터 수정
		foreach($aryDesignSet as $strDS_CODE => $strDS_VAL):

			## 메인 이미지 사용 유무 저장
			$param = "";
			$param['DS_CODE'] = $strDS_CODE;
			$row = $objDesignSetModule->getDesignSetSelectEx("OP_SELECT", $param);
			$intDS_NO = $row['DS_NO'];
			if(!$intDS_NO):
				## 신규 등록
				$param						= "";
				$param['DS_TYPE']			= "SKIN_PL";
				$param['DS_CODE']			= $strDS_CODE;
				$param['DS_VAL']			= $strDS_VAL;
				$param['DS_REG_DT']			= "NOW()";
				$param['DS_REG_NO']			= $intMemberNo;
				$param['DS_MOD_DT']			= "NOW()";
				$param['DS_MOD_NO']			= $intMemberNo;
				$row = $objDesignSetModule->getDesignSetInsertEx($param);
			else:
				## 업데이트
				$param						= "";
				$param['DS_NO']				= $intDS_NO;
				$param['DS_VAL']			= $strDS_VAL;
				$param['DS_MOD_DT']			= "NOW()";
				$param['DS_MOD_NO']			= $intMemberNo;
				$row = $objDesignSetModule->getDesignSetUpdateEx($param);
			endif;

		endforeach;

		## SUB 불러오기
		$param = "";
		$param['IC_TYPE'] = "SUB";
		$param['ORDER_BY'] = "icCodeAsc";
		$arySubList = $objIconMgrModule->getIconMgrSelectEx("OP_ARYTOTAL", $param);
		$arySubInfo = "";
		foreach($arySubList as $key => $data):
			## 기본설정
			$intIC_NO = $data['IC_NO'];
			$intIC_CODE = $data['IC_CODE'];
			$strIC_NAME = $data['IC_NAME'];
			$strIC_IMG = $data['IC_IMG'];
			$strIC_USE = $data['IC_USE'];

			## 사용유무 설정
			if(!$strIC_USE) { $strIC_USE = "N"; }

			## 만들기	
			$arySubInfo[$intIC_CODE]['IC_NO'] = $intIC_NO;
			$arySubInfo[$intIC_CODE]['NAME'] = $strIC_NAME;
			$arySubInfo[$intIC_CODE]['IMG'] = $strIC_IMG;
			$arySubInfo[$intIC_CODE]['USE'] = $strIC_USE;
		endforeach;

		## SUB ICON 등록
		for($i=1;$i<=5;$i++):
			$strUse = $_POST["use_{$i}"];
			$intIC_NO = $arySubInfo[$i]['IC_NO'];
			$strNAME = $arySubInfo[$i]['NAME'];
			$strIMG = $arySubInfo[$i]['IMG'];
			if(!$intIC_NO):
				## 신규 등록
				$param						= "";
				$param['IC_TYPE']			= "SUB";
				$param['IC_CODE']			= $i;
				$param['IC_NAME']			= $strNAME;
				$param['IC_IMG']			= $strIMG;
				$param['IC_USE']			= $strUse;
				$param['IC_REG_DT']			= "NOW()";
				$param['IC_REG_NO']			= $intMemberNo;
				$param['IC_MOD_DT']			= "NOW()";
				$param['IC_MOD_NO']			= $intMemberNo;
				$objIconMgrModule->getIconMgrInsertEx($param);
			else:
				## 업데이트
				$param						= "";
				$param['IC_NO']				= $intIC_NO;
				$param['IC_TYPE']			= "SUB";
				$param['IC_CODE']			= $i;
				$param['IC_NAME']			= $strNAME;
				$param['IC_IMG']			= $strIMG;
				$param['IC_USE']			= $strUse;
				$param['IC_MOD_DT']			= "NOW()";
				$param['IC_MOD_NO']			= $intMemberNo;
				$objIconMgrModule->getIconMgrUpdateEx($param);
			endif;
		endfor;

		## 파일 만들기
		include MALL_ADMIN . "/product/prodDisplay/prodListIconMakeFile.php";
		include MALL_ADMIN . "/layout/shopSkinMakeFile.php";

		## 마무리
		$result['__STATE__'] = "SUCCESS";

	break;

	case "skinSaveZL":
		// 샵메인 세부페이지 설정 저장

		## 모듈 설정
		$objIconMgrModule = new IconMgrModule($db);
		$objDesignSetModule = new DesignSetModule($db);

		## 기본설정
		$strZL_SLIDER_USE = $_POST['ZL_SLIDER_USE'];
		$intMemberNo = $a_admin_no;

		## 메인 이미지 사용 유무 저장
		$param = "";
		$param['DS_CODE'] = 'ZL_SLIDER_USE';
		$row = $objDesignSetModule->getDesignSetSelectEx("OP_SELECT", $param);
		$intDS_NO = $row['DS_NO'];
		if(!$intDS_NO):
			## 신규 등록
			$param						= "";
			$param['DS_TYPE']			= "SKIN_ZL";
			$param['DS_CODE']			= "ZL_SLIDER_USE";
			$param['DS_VAL']			= $strZL_SLIDER_USE;
			$param['DS_REG_DT']			= "NOW()";
			$param['DS_REG_NO']			= $intMemberNo;
			$param['DS_MOD_DT']			= "NOW()";
			$param['DS_MOD_NO']			= $intMemberNo;
			$row = $objDesignSetModule->getDesignSetInsertEx($param);
		else:
			## 업데이트
			$param						= "";
			$param['DS_NO']				= $intDS_NO;
			$param['DS_VAL']			= $strZL_SLIDER_USE;
			$param['DS_MOD_DT']			= "NOW()";
			$param['DS_MOD_NO']			= $intMemberNo;
			$row = $objDesignSetModule->getDesignSetUpdateEx($param);
		endif;
		
		## MAIN 불러오기
		$param = "";
		$param['IC_TYPE'] = "MAIN";
		$param['ORDER_BY'] = "icCodeAsc";
		$aryMainList = $objIconMgrModule->getIconMgrSelectEx("OP_ARYTOTAL", $param);
		$aryMainInfo = "";
		foreach($aryMainList as $key => $data):
			## 기본설정
			$intIC_NO = $data['IC_NO'];
			$intIC_CODE = $data['IC_CODE'];
			$strIC_NAME = $data['IC_NAME'];
			$strIC_IMG = $data['IC_IMG'];
			$strIC_USE = $data['IC_USE'];

			## 사용유무 설정
			if(!$strIC_USE) { $strIC_USE = "N"; }

			## 만들기	
			$aryMainInfo[$intIC_CODE]['IC_NO'] = $intIC_NO;
			$aryMainInfo[$intIC_CODE]['NAME'] = $strIC_NAME;
			$aryMainInfo[$intIC_CODE]['IMG'] = $strIC_IMG;
			$aryMainInfo[$intIC_CODE]['USE'] = $strIC_USE;
		endforeach;

		## MAIN ICON 등록
		for($i=1;$i<=5;$i++):
			$strUse = $_POST["use_{$i}"];
			$intIC_NO = $aryMainInfo[$i]['IC_NO'];
			$strNAME = $aryMainInfo[$i]['NAME'];
			$strIMG = $aryMainInfo[$i]['IMG'];
			if(!$intIC_NO):
				## 신규 등록
				$param						= "";
				$param['IC_TYPE']			= "MAIN";
				$param['IC_CODE']			= $i;
				$param['IC_NAME']			= $strNAME;
				$param['IC_IMG']			= $strIMG;
				$param['IC_USE']			= $strUse;
				$param['IC_REG_DT']			= "NOW()";
				$param['IC_REG_NO']			= $intMemberNo;
				$param['IC_MOD_DT']			= "NOW()";
				$param['IC_MOD_NO']			= $intMemberNo;
				$objIconMgrModule->getIconMgrInsertEx($param);
			else:
				## 업데이트
				$param						= "";
				$param['IC_NO']				= $intIC_NO;
				$param['IC_TYPE']			= "MAIN";
				$param['IC_CODE']			= $i;
				$param['IC_NAME']			= $strNAME;
				$param['IC_IMG']			= $strIMG;
				$param['IC_USE']			= $strUse;
				$param['IC_MOD_DT']			= "NOW()";
				$param['IC_MOD_NO']			= $intMemberNo;
				$objIconMgrModule->getIconMgrUpdateEx($param);
			endif;
		endfor;

		## 파일 만들기
		include MALL_ADMIN . "/product/prodDisplay/prodListIconMakeFile.php";

		## 마무리
		$result['__STATE__'] = "SUCCESS";
	break;

	endswitch;


