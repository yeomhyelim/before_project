<?php

	## 모듈 설정
	$objIconMgrModule = new IconMgrModule($db);

	## 기본설정
	$strConfFile = MALL_SHOP . "/conf/product.inc.php";
	
	## 기존에 등록된 파일 삭제
	FileDevice::fileDelete($strConfFile);

	## ICON 불러오기
	$param = "";
	$param['IC_TYPE'] = "ICON";
	$aryIconList = $objIconMgrModule->getIconMgrSelectEx("OP_ARYTOTAL", $param);

	## 데이터 만들기
	$strConfData = "";
	if($aryIconList):
		foreach($aryIconList as $key => $data):
			## 기본설정
			$intIC_NO = $data['IC_NO'];
			$strIC_IMG = $data['IC_IMG'];
			$intIC_CODE = $data['IC_CODE'];
			$strTemp = "\$S_ARY_PRODUCT_LIST_ICON[{$intIC_CODE}] = \"<img src='{$strIC_IMG}'/>\";";

			## 만들기
			if($strConfData) { $strConfData .= "\n"; }
			$strConfData .= $strTemp;

		endforeach;

		FileDevice::getMadeInfo($strConfFile, $strConfData, "## icon");
	endif;

	## MAIN 불러오기
	$param = "";
	$param['IC_TYPE'] = "MAIN";
	$param['ORDER_BY'] = "icCodeAsc";
	$aryMainList = $objIconMgrModule->getIconMgrSelectEx("OP_ARYTOTAL", $param);

	## 데이터 만들기
	$strConfData = "";
	if($aryMainList):
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
			$strTemp  = "";
			$strTemp .= "\$S_ARY_PRODUCT_LIST_MAIN[{$intIC_CODE}]['NAME'] = \"{$strIC_NAME}\";\n";
			$strTemp .= "\$S_ARY_PRODUCT_LIST_MAIN[{$intIC_CODE}]['IMG'] = \"{$strIC_IMG}\";\n";
			$strTemp .= "\$S_ARY_PRODUCT_LIST_MAIN[{$intIC_CODE}]['USE'] = \"{$strIC_USE}\";";

			## 마무리
			if($strConfData) { $strConfData .= "\n\n"; }
			$strConfData .= $strTemp;

		endforeach;

		FileDevice::getMadeInfo($strConfFile, $strConfData, "## main");
	endif;

	## SUB 불러오기
	$param = "";
	$param['IC_TYPE'] = "SUB";
	$param['ORDER_BY'] = "icCodeAsc";
	$arySubList = $objIconMgrModule->getIconMgrSelectEx("OP_ARYTOTAL", $param);

	## 데이터 만들기
	$strConfData = "";
	if($arySubList):
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
			$strTemp  = "";
			$strTemp .= "\$S_ARY_PRODUCT_LIST_SUB[{$intIC_CODE}]['NAME'] = \"{$strIC_NAME}\";\n";
			$strTemp .= "\$S_ARY_PRODUCT_LIST_SUB[{$intIC_CODE}]['IMG'] = \"{$strIC_IMG}\";\n";
			$strTemp .= "\$S_ARY_PRODUCT_LIST_SUB[{$intIC_CODE}]['USE'] = \"{$strIC_USE}\";";

			## 마무리
			if($strConfData) { $strConfData .= "\n\n"; }
			$strConfData .= $strTemp;

		endforeach;

		FileDevice::getMadeInfo($strConfFile, $strConfData, "## sub");
	endif;


##  2014.08.26 kim hee sung 소스 정리 old style
/*
	$cateMgr->setIC_TYPE("ICON");
	$aryProdIconDisplayList = $cateMgr->getProdDisplayList($db);

	$strConfProdIconList = "";
	for($i=0;$i<sizeof($aryProdIconDisplayList);$i++){
		$strConfProdIconList .= "\$S_ARY_PRODUCT_LIST_ICON[".$aryProdIconDisplayList[$i][IC_NO]."] = \"<img src='".$aryProdIconDisplayList[$i][IC_IMG]."'>\";\n";		
	}
	
	$strConfProdIconList = "<?\n".$strConfProdIconList."?>\n";

	$file = "../conf/product.inc.php";
	@chmod($file,0755);
	$fw = fopen($file, "w");
	fputs($fw,$strConfProdIconList, strlen($strConfProdIconList));
	fclose($fw);
*/