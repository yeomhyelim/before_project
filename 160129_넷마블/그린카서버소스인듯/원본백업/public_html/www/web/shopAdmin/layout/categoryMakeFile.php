<?
	## 수정 내용
	## 수정자		: kim hee sung
	## 수정일		: 2013.06.10 파일 경로 수정
	## 내용			: $S_SITE_LNG_PATH => strtolower($strStLng) 으로 변경함.
	## 이유			: 카테고리 변경시, 요청한 언어별로 저장이 되어야 하는데 기준언어로 저장이 되고 있었음.
	## 참고 사항	: strtolower($strStLng) 을 수정하고자 한다면 카테고리 소스를 체크 바람.

	$designSetMgr->setC_LEVEL(1);
	$designSetMgr->setC_HCODE("");
	$designSetMgr->setC_VIEW_YN("");
	$designSetMgr->setC_LNG($strStLng);
	$aryCate01 = $designSetMgr->getCateLevelAry($db);

	$strConfCateList = "";
	if (is_array($aryCate01)){
	
		for($i=0;$i<sizeof($aryCate01);$i++){
			$aryCate02 = $aryCate03 = $aryCate04 = "";
									
			$strCateCode01  = $aryCate01[$i][CATE_CODE];
			if ($aryCate01[$i][CATE_LOW_YN] == "Y"){
				$designSetMgr->setC_LEVEL(2);
				$designSetMgr->setC_HCODE($aryCate01[$i][CATE_CODE]);
				$designSetMgr->setC_VIEW_YN("");
				$aryCate02 = $designSetMgr->getCateLevelAry($db);
			}
			
			$strCateImg1_1 = $strCateImg1_2 = "";
			if ($aryCate01[$i][CATE_IMG1]){
				$strCateImg1_1 = "/upload/category/" . strtolower($strStLng) . "/".$aryCate01[$i][CATE_IMG1];
			}

			if ($aryCate01[$i][CATE_IMG2]){
				$strCateImg1_2 = "/upload/category/" . strtolower($strStLng) . "/".$aryCate01[$i][CATE_IMG2];
			}

			$strConfCateList .= "\$S_ARY_CATE1[".$i."]['CODE'] = \"".$strCateCode01."\";\n";
			$strConfCateList .= "\$S_ARY_CATE1[".$i."]['NAME'] = \"".$aryCate01[$i][CATE_NAME]."\";\n";
			$strConfCateList .= "\$S_ARY_CATE1[".$i."]['IMG1'] = \"".$strCateImg1_1."\";\n";
			$strConfCateList .= "\$S_ARY_CATE1[".$i."]['IMG2'] = \"".$strCateImg1_2."\";\n";
			$strConfCateList .= "\$S_ARY_CATE1[".$i."]['SHARE'] = \"".$aryCate01[$i][CATE_SHARE]."\";\n";
			$strConfCateList .= "\$S_ARY_CATE1[".$i."]['VIEW'] = \"".$aryCate01[$i][CATE_VIEW]."\";\n";
			$strConfCateList .= "\$S_ARY_CATE1[".$i."]['LOW_CNT'] = \"".sizeof($aryCate02)."\";\n";

			$strConfCateList .= "\$S_ARY_CATE_IMG['".$strCateCode01."']['TOP_IMG'] = \"".$aryCate01[$i][PL_TOP_IMG]."\";\n";
			$strConfCateList .= "\$S_ARY_CATE_HTML['".$strCateCode01."']['TOP_HTML'] = \"".$aryCate01[$i][PL_TOP_HTML]."\";\n";
			$strConfCateList .= "\$S_ARY_CATE_NAME['".$strCateCode01."']['CATE_NM'] = \"".$aryCate01[$i][CATE_NAME]."\";\n";
			$strConfCateList .= "\$S_ARY_CATE_NAME['".$strCateCode01."']['CATE_LOW_CNT'] = \"".sizeof($aryCate02)."\";\n";
			
			if (is_array($aryCate02)){
	
				for($ii=0;$ii<sizeof($aryCate02);$ii++){
					
					$aryCate03 = $aryCate04 = "";

					$strCateCode02  = $aryCate01[$i][CATE_CODE];
					$strCateCode02 .= $aryCate02[$ii][CATE_CODE];

					if ($aryCate02[$ii][CATE_LOW_YN] == "Y"){
						$designSetMgr->setC_LEVEL(3);
						$designSetMgr->setC_HCODE($aryCate01[$i][CATE_CODE].$aryCate02[$ii][CATE_CODE]);
						$designSetMgr->setC_VIEW_YN("");
						$aryCate03 = $designSetMgr->getCateLevelAry($db);
					}

					$strCateImg2_1 = $strCateImg2_2 = "";
					if ($aryCate02[$ii][CATE_IMG1]){
						$strCateImg2_1 = "/upload/category/" . strtolower($strStLng) . "/".$aryCate02[$ii][CATE_IMG1];
					}

					if ($aryCate02[$ii][CATE_IMG2]){
						$strCateImg2_2 = "/upload/category/" . strtolower($strStLng) . "/".$aryCate02[$ii][CATE_IMG2];
					}

					$strConfCateList .= "\$S_ARY_CATE2[".$i."][".$ii."]['CODE'] = \"".$strCateCode02."\";\n";
					$strConfCateList .= "\$S_ARY_CATE2[".$i."][".$ii."]['NAME'] = \"".strConvertCut2($aryCate02[$ii][CATE_NAME],0,"N")."\";\n";
					$strConfCateList .= "\$S_ARY_CATE2[".$i."][".$ii."]['IMG1'] = \"".$strCateImg2_1."\";\n";
					$strConfCateList .= "\$S_ARY_CATE2[".$i."][".$ii."]['IMG2'] = \"".$strCateImg2_2."\";\n";
					$strConfCateList .= "\$S_ARY_CATE2[".$i."][".$ii."]['SHARE'] = \"".$aryCate02[$ii][CATE_SHARE]."\";\n";
					$strConfCateList .= "\$S_ARY_CATE2[".$i."][".$ii."]['VIEW'] = \"".$aryCate02[$ii][CATE_VIEW]."\";\n";
					$strConfCateList .= "\$S_ARY_CATE2[".$i."][".$ii."]['LOW_CNT'] = \"".sizeof($aryCate03)."\";\n";

					$strConfCateList .= "\$S_ARY_CATE_IMG['".$strCateCode02."']['TOP_IMG'] = \"".$aryCate02[$ii][PL_TOP_IMG]."\";\n";
					$strConfCateList .= "\$S_ARY_CATE_HTML['".$strCateCode02."']['TOP_HTML'] = \"".$aryCate02[$ii][PL_TOP_HTML]."\";\n";
					$strConfCateList .= "\$S_ARY_CATE_NAME['".$strCateCode02."']['CATE_NM'] = \"".strConvertCut2($aryCate02[$ii][CATE_NAME],0,"N")."\";\n";
					$strConfCateList .= "\$S_ARY_CATE_NAME['".$strCateCode02."']['CATE_LOW_CNT'] = \"".sizeof($aryCate03)."\";\n";
												

					if (is_array($aryCate03)){
			
						for($iii=0;$iii<sizeof($aryCate03);$iii++){
							$aryCate04 = "";

							$strCateCode03  = $aryCate01[$i][CATE_CODE];
							$strCateCode03 .= $aryCate02[$ii][CATE_CODE];
							$strCateCode03 .= $aryCate03[$iii][CATE_CODE];

							if ($aryCate03[$iii][CATE_LOW_YN] == "Y"){
								$designSetMgr->setC_LEVEL(4);
								$designSetMgr->setC_HCODE($aryCate01[$i][CATE_CODE].$aryCate02[$ii][CATE_CODE].$aryCate03[$iii][CATE_CODE]);
								$designSetMgr->setC_VIEW_YN("");
								$aryCate04 = $designSetMgr->getCateLevelAry($db);
							}
							
							$strCateImg3_1 = $strCateImg3_2 = "";
							if ($aryCate03[$iii][CATE_IMG1]){
								$strCateImg3_1 = "/upload/category/" . strtolower($strStLng) . "/".$aryCate03[$iii][CATE_IMG1];
							}

							if ($aryCate03[$iii][CATE_IMG2]){
								$strCateImg3_2 = "/upload/category/" . strtolower($strStLng) . "/".$aryCate03[$iii][CATE_IMG2];
							}

							$strConfCateList .=  "\$S_ARY_CATE3[".$i."][".$ii."][".$iii."]['CODE'] = \"".$strCateCode03."\";\n";
							$strConfCateList .=  "\$S_ARY_CATE3[".$i."][".$ii."][".$iii."]['NAME'] = \"".$aryCate03[$iii][CATE_NAME]."\";\n";
							$strConfCateList .=  "\$S_ARY_CATE3[".$i."][".$ii."][".$iii."]['IMG1'] = \"".$strCateImg3_1."\";\n";
							$strConfCateList .=  "\$S_ARY_CATE3[".$i."][".$ii."][".$iii."]['IMG2'] = \"".$strCateImg3_2."\";\n";
							$strConfCateList .=  "\$S_ARY_CATE3[".$i."][".$ii."][".$iii."]['SHARE'] = \"".$aryCate03[$iii][CATE_SHARE]."\";\n";
							$strConfCateList .=  "\$S_ARY_CATE3[".$i."][".$ii."][".$iii."]['VIEW'] = \"".$aryCate03[$iii][CATE_VIEW]."\";\n";
							$strConfCateList .=  "\$S_ARY_CATE3[".$i."][".$ii."][".$iii."]['LOW_CNT'] = \"".sizeof($aryCate04)."\";\n";

							$strConfCateList .= "\$S_ARY_CATE_IMG['".$strCateCode03."']['TOP_IMG'] = \"".$aryCate03[$iii][PL_TOP_IMG]."\";\n";
							$strConfCateList .= "\$S_ARY_CATE_HTML['".$strCateCode03."']['TOP_HTML'] = \"".$aryCate03[$iii][PL_TOP_HTML]."\";\n";
							$strConfCateList .= "\$S_ARY_CATE_NAME['".$strCateCode03."']['CATE_NM'] = \"".$aryCate03[$iii][CATE_NAME]."\";\n";
							$strConfCateList .= "\$S_ARY_CATE_NAME['".$strCateCode03."']['CATE_LOW_CNT'] = \"".sizeof($aryCate04)."\";\n";

							if (is_array($aryCate04)){
								for($iiii=0;$iiii<sizeof($aryCate04);$iiii++){
									$strCateCode04  = $aryCate01[$i][CATE_CODE];
									$strCateCode04 .= $aryCate02[$ii][CATE_CODE];
									$strCateCode04 .= $aryCate03[$iii][CATE_CODE];
									$strCateCode04 .= $aryCate04[$iiii][CATE_CODE];

									$strCateImg4_1 = $strCateImg4_2 = "";
									if ($aryCate04[$iiii][CATE_IMG1]){
										$strCateImg4_1 = "/upload/category/" . strtolower($strStLng) . "/".$aryCate04[$iiii][CATE_IMG1];
									}

									if ($aryCate04[$iiii][CATE_IMG2]){
										$strCateImg4_2 = "/upload/category/" . strtolower($strStLng) . "/".$aryCate04[$iiii][CATE_IMG2];
									}

									$strConfCateList .= "\$S_ARY_CATE4[".$i."][".$ii."][".$iii."][".$iiii."]['CODE'] = \"".$strCateCode04."\";\n";
									$strConfCateList .= "\$S_ARY_CATE4[".$i."][".$ii."][".$iii."][".$iiii."]['NAME'] = \"".$aryCate04[$iiii][CATE_NAME]."\";\n";
									$strConfCateList .= "\$S_ARY_CATE4[".$i."][".$ii."][".$iii."][".$iiii."]['IMG1'] = \"".$strCateImg4_1."\";\n";
									$strConfCateList .= "\$S_ARY_CATE4[".$i."][".$ii."][".$iii."][".$iiii."]['IMG2'] = \"".$strCateImg4_2."\";\n";
									$strConfCateList .= "\$S_ARY_CATE4[".$i."][".$ii."][".$iii."][".$iiii."]['SHARE'] = \"".$aryCate04[$iiii][CATE_SHARE]."\";\n";
									$strConfCateList .= "\$S_ARY_CATE4[".$i."][".$ii."][".$iii."][".$iiii."]['VIEW'] = \"".$aryCate04[$iiii][CATE_VIEW]."\";\n";

									$strConfCateList .= "\$S_ARY_CATE_IMG['".$strCateCode04."']['TOP_IMG'] = \"".$aryCate04[$iiii][PL_TOP_IMG]."\";\n";
									$strConfCateList .= "\$S_ARY_CATE_HTML['".$strCateCode04."']['TOP_HTML'] = \"".$aryCate04[$iiii][PL_TOP_HTML]."\";\n";
									$strConfCateList .= "\$S_ARY_CATE_NAME['".$strCateCode04."']['CATE_NM'] = \"".$aryCate04[$iiii][CATE_NAME]."\";\n";

								}
							}
						}
					}
				}
			}

		}
	}


	$strConfCateColorList = $strConfCateSizeList = "";
	if ($S_SHOP_HOME == "demo1" || $S_SHOP_HOME == "linksday" || $S_SHOP_HOME == "bejewel" || $S_SHOP_HOME == "amanoled"){
	
		/* COLOR */
		$strCgCode = "COLOR";
		$designSetMgr->setCG_CODE($strCgCode);
		$aryCateColorList = $designSetMgr->getCateColorSizeList($db);
		if (is_array($aryCateColorList)){
			for($j=0;$j<sizeof($aryCateColorList);$j++){
				$strConfCateColorList .= "\$S_ARY_PROD_COLOR[".$j."]['CODE'] = \"".$aryCateColorList[$j][CC_CODE]."\";\n";
				$strConfCateColorList .= "\$S_ARY_PROD_COLOR[".$j."]['NAME'] = \"".$aryCateColorList[$j][CC_NAME_KR]."\";\n";
				$strConfCateColorList .= "\$S_ARY_PROD_COLOR[".$j."]['USE']  = \"".$aryCateColorList[$j][CC_USE]."\";\n";
				$strConfCateColorList .= "\$S_ARY_PROD_COLOR[".$j."]['IMG']  = \"".$aryCateColorList[$j][CC_IMG1]."\";\n";
			}
		}

		$strCgCode = "SIZE";
		$designSetMgr->setCG_CODE($strCgCode);
		$aryCateSizeList = $designSetMgr->getCateColorSizeList($db);
		if (is_array($aryCateSizeList)){
			for($j=0;$j<sizeof($aryCateSizeList);$j++){
				$strConfCateSizeList .= "\$S_ARY_PROD_SIZE[".$j."]['CODE'] = \"".$aryCateSizeList[$j][CC_CODE]."\";\n";
				$strConfCateSizeList .= "\$S_ARY_PROD_SIZE[".$j."]['NAME'] = \"".$aryCateSizeList[$j][CC_NAME_KR]."\";\n";
				$strConfCateSizeList .= "\$S_ARY_PROD_SIZE[".$j."]['USE']  = \"".$aryCateSizeList[$j][CC_USE]."\";\n";
				$strConfCateSizeList .= "\$S_ARY_PROD_SIZE[".$j."]['IMG']  = \"".$aryCateSizeList[$j][CC_IMG1]."\";\n";
			}
		}
			
			
		/*
		if (is_array($aryCate01)){
			for($i=0;$i<sizeof($aryCate01);$i++){
				
				$strCateCode = $aryCate01[$i][CATE_CODE];
				
			}
		}*/

		$strConfCateList .= $strConfCateColorList;
		$strConfCateList .= $strConfCateSizeList;
	}
	

	$strConfCateList = "<?\n".$strConfCateList."?>\n";
	$file = "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/category.".strtolower($strStLng).".inc.php";

	$fw = fopen($file, "w");
	fputs($fw,$strConfCateList, strlen($strConfCateList));
	fclose($fw);
	@chmod($file,0707);

	$file = "../conf/category.inc.php";
	@chmod($file,0707);
	$fw = fopen($file, "w");
	fputs($fw,$strConfCateList, strlen($strConfCateList));
	fclose($fw);





	## 2014-06-16 kim hee sung 모바일 작업하면서 추가함
	## 모듈 설정
	$objCateMgrModule = new CateMgrModule($db);

	## 기본설정
	$strStLngLower = strtolower($strStLng);

	## 카테고리 리스트 불러오기
	$param = "";
	$param['ORDER_BY'][] = "levelAsc";
	$param['ORDER_BY'][] = "orderAsc";
	$param['ORDER_BY'][] = "codeAsc";
	$param['CL_VIEW_YN'] = "Y";
	$param['C_SHARE'] = "N";
	$param['C_TYPE_NULL'] = "Y";
	$param['LNG'] = $strStLng;
	$aryCateList = $objCateMgrModule->getCateMgrSelectEx("OP_ARYTOTAL", $param);

	## 파일 만들기
	if($aryCateList):
		$strText = "";
		foreach($aryCateList as $row):
		
			## 기본 설정
			$strTemp = "";
			$strC_CODE = $row['C_CODE']; 
			$intC_LEVEL = $row['C_LEVEL']; 
			$strCL_NAME = $row['CL_NAME'];
			$strCL_IMG1 = $row['CL_IMG1'];
			$strCL_IMG2 = $row['CL_IMG2'];
			$strCL_NAME = str_replace("'","\'", $strCL_NAME);
			$strCate1 = substr($strC_CODE, 0, 3);
			$strCate2 = substr($strC_CODE, 3, 3);
			$strCate3 = substr($strC_CODE, 6, 3);
			$strCate4 = substr($strC_CODE, 9, 3);

			if($intC_LEVEL == 1):
				$strTemp .= "\$S_CATE_MENU1['{$strCate1}']['CODE'] = '{$strC_CODE}';\n";
				$strTemp .= "\$S_CATE_MENU1['{$strCate1}']['NAME'] = '{$strCL_NAME}';\n";	
				$strTemp .= "\$S_CATE_MENU1['{$strCate1}']['IMG1'] = '{$strCL_IMG1}';\n";	
				$strTemp .= "\$S_CATE_MENU1['{$strCate1}']['IMG2'] = '{$strCL_IMG2}';";	
			elseif($intC_LEVEL == 2):
				$strTemp .= "\$S_CATE_MENU2['{$strCate1}']['{$strCate2}']['CODE'] = '{$strC_CODE}';\n";
				$strTemp .= "\$S_CATE_MENU2['{$strCate1}']['{$strCate2}']['NAME'] = '{$strCL_NAME}';\n";	
				$strTemp .= "\$S_CATE_MENU2['{$strCate1}']['{$strCate2}']['IMG1'] = '{$strCL_IMG1}';\n";	
				$strTemp .= "\$S_CATE_MENU2['{$strCate1}']['{$strCate2}']['IMG2'] = '{$strCL_IMG2}';";	
			elseif($intC_LEVEL == 3):
				$strTemp .= "\$S_CATE_MENU3['{$strCate1}']['{$strCate2}']['{$strCate3}']['CODE'] = '{$strC_CODE}';\n";	
				$strTemp .= "\$S_CATE_MENU3['{$strCate1}']['{$strCate2}']['{$strCate3}']['NAME'] = '{$strCL_NAME}';\n";	
				$strTemp .= "\$S_CATE_MENU3['{$strCate1}']['{$strCate2}']['{$strCate3}']['IMG1'] = '{$strCL_IMG1}';\n";	
				$strTemp .= "\$S_CATE_MENU3['{$strCate1}']['{$strCate2}']['{$strCate3}']['IMG2'] = '{$strCL_IMG2}';";	
			elseif($intC_LEVEL == 4):
				$strTemp .= "\$S_CATE_MENU4['{$strCate1}']['{$strCate2}']['{$strCate3}']['{$strCate4}']['CODE'] = '{$strC_CODE}';\n";	
				$strTemp .= "\$S_CATE_MENU4['{$strCate1}']['{$strCate2}']['{$strCate3}']['{$strCate4}']['NAME'] = '{$strCL_NAME}';\n";	
				$strTemp .= "\$S_CATE_MENU4['{$strCate1}']['{$strCate2}']['{$strCate3}']['{$strCate4}']['IMG1'] = '{$strCL_IMG1}';\n";
				$strTemp .= "\$S_CATE_MENU4['{$strCate1}']['{$strCate2}']['{$strCate3}']['{$strCate4}']['IMG2'] = '{$strCL_IMG2}';";	
			endif;
			
			if($strText) { $strText .= "\n"; }
			$strText .= $strTemp;

		endforeach;

		## 파일 생성
		$strFileName = MALL_SHOP . "/conf/category.menu.{$strStLngLower}.inc.php";
		FileDevice::getMadeInfo($strFileName, $strText, "## 카테고리 메뉴");
	endif;
?>