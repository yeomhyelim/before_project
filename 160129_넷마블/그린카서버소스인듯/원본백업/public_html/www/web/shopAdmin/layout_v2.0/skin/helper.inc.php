<?php

	switch($strMode):
	
	case "skinList":
		// 스킨 리스트

		## 모듈 설정
		$objSiteInfoModule = new SiteInfoModule($db);

		## 기본설정
		$strMallShop = MALL_SHOP;
		$strLayoutBakFolder = "{$strMallShop}/layout/layout-bak";
		$aryLayoutBakList = scandir($strLayoutBakFolder, 1);
		
		## 특정값 삭제
		if(is_array($aryLayoutBakList)):
			$key = array_search(".", $aryLayoutBakList);
			if($key !== false) { unset($aryLayoutBakList[$key]); }
			$key = array_search("..", $aryLayoutBakList);
			if($key !== false) { unset($aryLayoutBakList[$key]); }
		endif;


		## 사용중인 스킨 삭제
		$param = "";
		$param['COL'] = 'S_SKIN_CODE';
		$arySkinInfoRow = $objSiteInfoModule->getSiteInfoSelectEx("OP_SELECT", $param);
		$strSkinCodeSelect = $arySkinInfoRow['VAL'];

	break;

	endswitch;