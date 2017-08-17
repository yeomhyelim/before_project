<?
	## 2014.09.01 kim hee sung, 내용 추가
	if(in_array($strMode, array("eumEditor2Image"))):
		include "{$strMode}.inc.php";
		exit;
	endif;
	if(in_array($strAct, array("eumEditor2Image"))):
		include "{$strAct}.inc.php";
		exit;
	endif;

	require_once MALL_CONF_LIB."CateMgr.php";
	require_once MALL_CONF_LIB."ProductMgr.php";
	require_once MALL_CONF_LIB."BoardMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";
	require_once MALL_CONF_LIB."MemberMgr.php";
	require_once MALL_CONF_LIB."DesignSetMgr.php";
	
	$memberMgr	= new MemberMgr();
	$boardMgr		= new BoardMgr();
	$designSetMgr		= new CateMgr();		
	$productMgr		= new ProductMgr();	
	$siteMgr		= new SiteMgr();
	$designSetMgr = new DesignSetMgr();	




	$siteRow = $siteMgr->getSiteInfo($db);
	$arySiteUseLng = explode("/",$siteRow[S_USE_LNG]);


	switch ($strMode){

		case "product":

			$query =  "SELECT A.* FROM PRODUCT_MGR A WHERE A.P_CODE NOT IN ('201208101218534','201203081644585')";
			$result = $db->getResult($query);

			$i = 1;
			while($row = mysql_fetch_array($result[result])){
					
				echo $row[P_CODE]."<BR>";
				
				$query = "UPDATE PRODUCT_MGR SET P_ADD_OPT = 'Y' WHERE P_CODE = '".$row[P_CODE]."'";
				//$db->getExecSql($query);
				
				$productMgr->setP_CODE($row[P_CODE]);
				$productMgr->setPO_NAME1("왕복운임비<BR/>(택배, 퀵, 화물차)");
				$productMgr->setPO_NAME2("");
				$productMgr->setPO_NAME3("");
				$productMgr->setPO_NAME4("");
				$productMgr->setPO_NAME5("");
				$productMgr->setPO_NAME6("");
				$productMgr->setPO_NAME7("");
				$productMgr->setPO_NAME8("");
				$productMgr->setPO_NAME9("");
				$productMgr->setPO_NAME10("");
				$productMgr->setPO_TYPE("A");
				$productMgr->setPO_ESS("N");
				//$productMgr->getProdOptInsert($db);
				//$intPO_NO = $db->getLastInsertID();
				//$productMgr->setPO_NO($intPO_NO);

				$query  = "INSERT INTO PRODUCT_ADD_OPT ";
				$query .= "SELECT                ";
				$query .= "     ''               ";
				$query .= "    ,".$intPO_NO."    ";
				$query .= "    ,PAO_NAME         ";
				$query .= "    ,PAO_PRICE        ";
				$query .= "FROM PRODUCT_ADD_OPT  ";
				$query .= "WHERE PO_NO = 23      ";
				//$db->getExecSql($query);

				echo "ok<br>";
			}
		break;

		case "category":

	$designSetMgr->setC_LEVEL(1);
	$designSetMgr->setC_HCODE("");
	$designSetMgr->setC_VIEW_YN("");
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

			$strConfCateList .= "\$S_ARY_CATE1[".$i."]['CODE'] = \"".$strCateCode01."\";\n";
			$strConfCateList .= "\$S_ARY_CATE1[".$i."]['NAME'] = \"".$aryCate01[$i][CATE_NAME]."\";\n";
			$strConfCateList .= "\$S_ARY_CATE1[".$i."]['IMG1'] = \"".$aryCate01[$i][CATE_IMG1]."\";\n";
			$strConfCateList .= "\$S_ARY_CATE1[".$i."]['IMG2'] = \"".$aryCate01[$i][CATE_IMG2]."\";\n";

			$strConfCateList .= "\$S_ARY_CATE_IMG['".$strCateCode01."']['TOP_IMG'] = \"".$aryCate01[$i][PL_TOP_IMG]."\";\n";
			$strConfCateList .= "\$S_ARY_CATE_HTML['".$strCateCode01."']['TOP_HTML'] = \"".$aryCate01[$i][PL_TOP_HTML]."\";\n";

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

					$strConfCateList .= "\$S_ARY_CATE2[".$i."][".$ii."]['CODE'] = \"".$strCateCode02."\";\n";
					$strConfCateList .= "\$S_ARY_CATE2[".$i."][".$ii."]['NAME'] = \"".$aryCate02[$ii][CATE_NAME]."\";\n";
					$strConfCateList .= "\$S_ARY_CATE2[".$i."][".$ii."]['IMG1'] = \"".$aryCate02[$ii][CATE_IMG1]."\";\n";
					$strConfCateList .= "\$S_ARY_CATE2[".$i."][".$ii."]['IMG2'] = \"".$aryCate02[$ii][CATE_IMG2]."\";\n";
					$strConfCateList .= "\$S_ARY_CATE_IMG['".$strCateCode02."']['TOP_IMG'] = \"".$aryCate02[$ii][PL_TOP_IMG]."\";\n";
					$strConfCateList .= "\$S_ARY_CATE_HTML['".$strCateCode02."']['TOP_HTML'] = \"".$aryCate02[$ii][PL_TOP_HTML]."\";\n";
												

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
							

							$strConfCateList .=  "\$S_ARY_CATE3[".$i."][".$ii."][".$iii."]['CODE'] = \"".$strCateCode03."\";\n";
							$strConfCateList .=  "\$S_ARY_CATE3[".$i."][".$ii."][".$iii."]['NAME'] = \"".$aryCate03[$iii][CATE_NAME]."\";\n";
							$strConfCateList .=  "\$S_ARY_CATE3[".$i."][".$ii."][".$iii."]['IMG1'] = \"".$aryCate03[$iii][CATE_IMG1]."\";\n";
							$strConfCateList .=  "\$S_ARY_CATE3[".$i."][".$ii."][".$iii."]['IMG2'] = \"".$aryCate03[$iii][CATE_IMG2]."\";\n";
							$strConfCateList .= "\$S_ARY_CATE_IMG['".$strCateCode03."']['TOP_IMG'] = \"".$aryCate03[$iii][PL_TOP_IMG]."\";\n";
							$strConfCateList .= "\$S_ARY_CATE_HTML['".$strCateCode03."']['TOP_HTML'] = \"".$aryCate03[$iii][PL_TOP_HTML]."\";\n";

							if (is_array($aryCate04)){
								for($iiii=0;$iiii<sizeof($aryCate04);$iiii++){
									$strCateCode04  = $aryCate01[$i][CATE_CODE];
									$strCateCode04 .= $aryCate02[$ii][CATE_CODE];
									$strCateCode04 .= $aryCate03[$iii][CATE_CODE];
									$strCateCode04 .= $aryCate04[$iiii][CATE_CODE];

									$strConfCateList .= "\$S_ARY_CATE4[".$i."][".$ii."][".$iii."][".$iiii."]['CODE'] = \"".$strCateCode04."\";\n";
									$strConfCateList .= "\$S_ARY_CATE4[".$i."][".$ii."][".$iii."][".$iiii."]['NAME'] = \"".$aryCate04[$iiii][CATE_NAME]."\";\n";
									$strConfCateList .= "\$S_ARY_CATE4[".$i."][".$ii."][".$iii."][".$iiii."]['IMG1'] = \"".$aryCate04[$iiii][CATE_IMG1]."\";\n";
									$strConfCateList .= "\$S_ARY_CATE4[".$i."][".$ii."][".$iii."][".$iiii."]['IMG2'] = \"".$aryCate04[$iiii][CATE_IMG2]."\";\n";

									$strConfCateList .= "\$S_ARY_CATE_IMG['".$strCateCode04."']['TOP_IMG'] = \"".$aryCate04[$iiii][PL_TOP_IMG]."\";\n";
									$strConfCateList .= "\$S_ARY_CATE_HTML['".$strCateCode04."']['TOP_HTML'] = \"".$aryCate04[$iiii][PL_TOP_HTML]."\";\n";

								}
							}
						}
					}
				}
			}

		}
	}
	
	$strConfCateList = "<?\n".$strConfCateList."?>\n";
	$file = "../conf/category.inc.php";
	@chmod($file,0755);
	$fw = fopen($file, "w");
	fputs($fw,$strConfCateList, strlen($strConfCateList));
	fclose($fw);


			echo "성공";


		break;
	}


?>