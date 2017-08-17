<?
	$strMakeFileText  = "";
	
	$arySiteInfo = $siteMgr->getSiteInfoArr($db);
	if (is_array($arySiteInfo)){
		for($i=0;$i<sizeof($arySiteInfo);$i++){
			
			if ($arySiteInfo[$i][COL] != "S_PROD_DELIVERY" && $arySiteInfo[$i][COL] != "S_PROD_RETURN"){

				if ($arySiteInfo[$i][COL] == "S_SITE_NM"){
					$strMakeFileText .= "\$S_SITE_KNAME = \"".$arySiteInfo[$i][VAL]."\"; \n";
				}
				
				$strMakeFileText .= "\$".$arySiteInfo[$i][COL]." = \"".$arySiteInfo[$i][VAL]."\"; \n";
			}
		}
	}

	$aryMemberGroupInfo = $memberMgr->getGroupList($db);

	if (is_array($aryMemberGroupInfo)){
		for($i=0;$i<sizeof($aryMemberGroupInfo);$i++){
			
			$strGroupExpCategoryList	= "";
			$strGroupExpProductList		= "";

			$aryGroupExpCategory	= explode("/",$aryMemberGroupInfo[$i][G_EXP_CATEGORY]);
			$aryGroupExpProduct		= explode("/",$aryMemberGroupInfo[$i][G_EXP_PRODUCT]);
			
			if (is_array($aryGroupExpCategory)){
				for($j=0;$j<sizeof($aryGroupExpCategory);$j++){
					
					if ($aryGroupExpCategory[$j]){
						$strGroupExpCategoryList .= "'".$aryGroupExpCategory[$j]."',";
					}
				}
				
				$strGroupExpCategoryList = SUBSTR($strGroupExpCategoryList,0,STRLEN($strGroupExpCategoryList)-1);
			}

			if (is_array($aryGroupExpProduct)){
				for($j=0;$j<sizeof($aryGroupExpProduct);$j++){
					
					if ($aryGroupExpProduct[$j]){
						$strGroupExpProductList .= "'".$aryGroupExpProduct[$j]."',";
					}
				}
				
				$strGroupExpProductList = SUBSTR($strGroupExpProductList,0,STRLEN($strGroupExpProductList)-1);
			}

	
			$strMakeFileText .= "\$S_MEMBER_GROUP[\"".$aryMemberGroupInfo[$i][G_CODE]."\"][\"NAME\"] = \"".$aryMemberGroupInfo[$i][G_NAME]."\"; \n";
			$strMakeFileText .= "\$S_MEMBER_GROUP[\"".$aryMemberGroupInfo[$i][G_CODE]."\"][\"VIEW\"] = \"".$aryMemberGroupInfo[$i][G_SHOW]."\"; \n";
			$strMakeFileText .= "\$S_MEMBER_GROUP[\"".$aryMemberGroupInfo[$i][G_CODE]."\"][\"APPLY\"] = \"".$aryMemberGroupInfo[$i][G_APPLY]."\"; \n";
			$strMakeFileText .= "\$S_MEMBER_GROUP[\"".$aryMemberGroupInfo[$i][G_CODE]."\"][\"SETTLE\"] = \"".$aryMemberGroupInfo[$i][G_SETTLE]."\"; \n";
			$strMakeFileText .= "\$S_MEMBER_GROUP[\"".$aryMemberGroupInfo[$i][G_CODE]."\"][\"PRICE_ST\"] = \"".$aryMemberGroupInfo[$i][G_PRICE_ST]."\"; \n";
			$strMakeFileText .= "\$S_MEMBER_GROUP[\"".$aryMemberGroupInfo[$i][G_CODE]."\"][\"ICON\"] = \"".$aryMemberGroupInfo[$i][G_ICON]."\"; \n";
			$strMakeFileText .= "\$S_MEMBER_GROUP[\"".$aryMemberGroupInfo[$i][G_CODE]."\"][\"LEVEL\"] = \"".$aryMemberGroupInfo[$i][G_LEVEL]."\"; \n";
			$strMakeFileText .= "\$S_MEMBER_GROUP[\"".$aryMemberGroupInfo[$i][G_CODE]."\"][\"G_MIN_BUY_PRICE\"] = \"".$aryMemberGroupInfo[$i][G_MIN_BUY_PRICE]."\"; \n";
			$strMakeFileText .= "\$S_MEMBER_GROUP[\"".$aryMemberGroupInfo[$i][G_CODE]."\"][\"PRICE_MIN\"] = \"".$aryMemberGroupInfo[$i][G_PRICE_MIN]."\"; \n";
			$strMakeFileText .= "\$S_MEMBER_GROUP[\"".$aryMemberGroupInfo[$i][G_CODE]."\"][\"PRICE_MAX\"] = \"".$aryMemberGroupInfo[$i][G_PRICE_MAX]."\"; \n";
			$strMakeFileText .= "\$S_MEMBER_GROUP[\"".$aryMemberGroupInfo[$i][G_CODE]."\"][\"BUY_CNT\"] = \"".$aryMemberGroupInfo[$i][G_BUY_CNT]."\"; \n";
			$strMakeFileText .= "\$S_MEMBER_GROUP[\"".$aryMemberGroupInfo[$i][G_CODE]."\"][\"PROD_CNT\"] = \"".$aryMemberGroupInfo[$i][G_PRODUCT_CNT]."\"; \n";
			$strMakeFileText .= "\$S_MEMBER_GROUP[\"".$aryMemberGroupInfo[$i][G_CODE]."\"][\"DISCOUNT_ST\"] = \"".$aryMemberGroupInfo[$i][G_DISCOUNT_ST]."\"; \n";
			$strMakeFileText .= "\$S_MEMBER_GROUP[\"".$aryMemberGroupInfo[$i][G_CODE]."\"][\"DISCOUNT_PRICE\"] = \"".$aryMemberGroupInfo[$i][G_DISCOUNT_PRICE]."\"; \n";
			$strMakeFileText .= "\$S_MEMBER_GROUP[\"".$aryMemberGroupInfo[$i][G_CODE]."\"][\"DISCOUNT_RATE\"] = \"".$aryMemberGroupInfo[$i][G_DISCOUNT_RATE]."\"; \n";
			$strMakeFileText .= "\$S_MEMBER_GROUP[\"".$aryMemberGroupInfo[$i][G_CODE]."\"][\"DISCOUNT_UNIT\"] = \"".$aryMemberGroupInfo[$i][G_DISCOUNT_UNIT]."\"; \n";
			$strMakeFileText .= "\$S_MEMBER_GROUP[\"".$aryMemberGroupInfo[$i][G_CODE]."\"][\"DISCOUNT_OFF\"] = \"".$aryMemberGroupInfo[$i][G_DISCOUNT_OFF]."\"; \n";
			$strMakeFileText .= "\$S_MEMBER_GROUP[\"".$aryMemberGroupInfo[$i][G_CODE]."\"][\"DISCOUNT_POINT\"] = \"".$aryMemberGroupInfo[$i][G_DISCOUNT_POINT]."\"; \n";
			$strMakeFileText .= "\$S_MEMBER_GROUP[\"".$aryMemberGroupInfo[$i][G_CODE]."\"][\"POINT_PRICE\"] = \"".$aryMemberGroupInfo[$i][G_POINT_PRICE]."\"; \n";
			$strMakeFileText .= "\$S_MEMBER_GROUP[\"".$aryMemberGroupInfo[$i][G_CODE]."\"][\"POINT_RATE\"] = \"".$aryMemberGroupInfo[$i][G_POINT_RATE]."\"; \n";
			$strMakeFileText .= "\$S_MEMBER_GROUP[\"".$aryMemberGroupInfo[$i][G_CODE]."\"][\"POINT_UNIT\"] = \"".$aryMemberGroupInfo[$i][G_POINT_UNIT]."\"; \n";
			$strMakeFileText .= "\$S_MEMBER_GROUP[\"".$aryMemberGroupInfo[$i][G_CODE]."\"][\"POINT_OFF\"] = \"".$aryMemberGroupInfo[$i][G_POINT_OFF]."\"; \n";
			$strMakeFileText .= "\$S_MEMBER_GROUP[\"".$aryMemberGroupInfo[$i][G_CODE]."\"][\"POINT_POINT\"] = \"".$aryMemberGroupInfo[$i][G_POINT_POINT]."\"; \n";
			$strMakeFileText .= "\$S_MEMBER_GROUP[\"".$aryMemberGroupInfo[$i][G_CODE]."\"][\"ADD_DISCOUNT\"] = \"".$aryMemberGroupInfo[$i][G_ADD_DISCOUNT]."\"; \n";
			$strMakeFileText .= "\$S_MEMBER_GROUP[\"".$aryMemberGroupInfo[$i][G_CODE]."\"][\"ADD_DISCOUNT_PRICE\"] = \"".$aryMemberGroupInfo[$i][G_ADD_DISCOUNT_PRICE]."\"; \n";
			$strMakeFileText .= "\$S_MEMBER_GROUP[\"".$aryMemberGroupInfo[$i][G_CODE]."\"][\"ADD_DISCOUNT_RATE\"] = \"".$aryMemberGroupInfo[$i][G_ADD_DISCOUNT_RATE]."\"; \n";
			$strMakeFileText .= "\$S_MEMBER_GROUP[\"".$aryMemberGroupInfo[$i][G_CODE]."\"][\"ADD_DISCOUNT_UNIT\"] = \"".$aryMemberGroupInfo[$i][G_ADD_DISCOUNT_UNIT]."\"; \n";
			$strMakeFileText .= "\$S_MEMBER_GROUP[\"".$aryMemberGroupInfo[$i][G_CODE]."\"][\"ADD_DISCOUNT_OFF\"] = \"".$aryMemberGroupInfo[$i][G_ADD_DISCOUNT_OFF]."\"; \n";
			$strMakeFileText .= "\$S_MEMBER_GROUP[\"".$aryMemberGroupInfo[$i][G_CODE]."\"][\"ADD_DISCOUNT_POINT\"] = \"".$aryMemberGroupInfo[$i][G_ADD_DISCOUNT_POINT]."\"; \n";
			$strMakeFileText .= "\$S_MEMBER_GROUP[\"".$aryMemberGroupInfo[$i][G_CODE]."\"][\"IMG\"] = \"".$aryMemberGroupInfo[$i][G_IMG]."\"; \n";
			$strMakeFileText .= "\$S_MEMBER_GROUP[\"".$aryMemberGroupInfo[$i][G_CODE]."\"][\"FILE\"] = \"".$aryMemberGroupInfo[$i][G_FILE]."\"; \n";
			$strMakeFileText .= "\$S_MEMBER_GROUP[\"".$aryMemberGroupInfo[$i][G_CODE]."\"][\"NAME_MEMO\"] = \"".$aryMemberGroupInfo[$i][G_MEMO]."\"; \n";
			
			if ($strGroupExpCategoryList) {
				$strMakeFileText .= "\$S_MEMBER_GROUP[\"".$aryMemberGroupInfo[$i][G_CODE]."\"][\"EXP_CATE\"] = array(".$strGroupExpCategoryList."); \n";
			}
			if ($strGroupExpProductList) {
				$strMakeFileText .= "\$S_MEMBER_GROUP[\"".$aryMemberGroupInfo[$i][G_CODE]."\"][\"EXP_PROD\"] = array(".$strGroupExpProductList."); \n";
			}
		}
	}
	
	$arySiteUseLng = explode("/",$S_USE_LNG);
	$aryShopEventList = $siteMgr->getSiteEventList($db);
	if (is_array($aryShopEventList)){
		for($i=0;$i<sizeof($aryShopEventList);$i++){
			$strMakeFileText .= "\$S_EVENT_INFO[".$aryShopEventList[$i][SE_NO]."][\"TYPE\"] = \"".$aryShopEventList[$i][SE_TYPE]."\"; \n";
			$strMakeFileText .= "\$S_EVENT_INFO[".$aryShopEventList[$i][SE_NO]."][\"TITLE\"] = \"".$aryShopEventList[$i][SE_TITLE]."\"; \n";
			$strMakeFileText .= "\$S_EVENT_INFO[".$aryShopEventList[$i][SE_NO]."][\"DAY_TIME\"] = \"".$aryShopEventList[$i][SE_DAY_TIME]."\"; \n";
			$strMakeFileText .= "\$S_EVENT_INFO[".$aryShopEventList[$i][SE_NO]."][\"DAY_TYPE\"] = \"".$aryShopEventList[$i][SE_DAY_TYPE]."\"; \n";
			$strMakeFileText .= "\$S_EVENT_INFO[".$aryShopEventList[$i][SE_NO]."][\"DAY\"] = \"".$aryShopEventList[$i][SE_DAY]."\"; \n";
			$strMakeFileText .= "\$S_EVENT_INFO[".$aryShopEventList[$i][SE_NO]."][\"START_DT\"] = \"".$aryShopEventList[$i][SE_START_DT]."\"; \n";
			$strMakeFileText .= "\$S_EVENT_INFO[".$aryShopEventList[$i][SE_NO]."][\"END_DT\"] = \"".$aryShopEventList[$i][SE_END_DT]."\"; \n";
			$strMakeFileText .= "\$S_EVENT_INFO[".$aryShopEventList[$i][SE_NO]."][\"PRICE\"] = \"".$aryShopEventList[$i][SE_PRICE]."\"; \n";
			$strMakeFileText .= "\$S_EVENT_INFO[".$aryShopEventList[$i][SE_NO]."][\"PRICE_TYPE\"] = \"".$aryShopEventList[$i][SE_PRICE_TYPE]."\"; \n";
			$strMakeFileText .= "\$S_EVENT_INFO[".$aryShopEventList[$i][SE_NO]."][\"PRICE_OFF\"] = \"".$aryShopEventList[$i][SE_PRICE_OFF]."\"; \n";
			$strMakeFileText .= "\$S_EVENT_INFO[".$aryShopEventList[$i][SE_NO]."][\"SELL_AUTH\"] = \"".$aryShopEventList[$i][SE_SELL_AUTH]."\"; \n";
			$strMakeFileText .= "\$S_EVENT_INFO[".$aryShopEventList[$i][SE_NO]."][\"GIVE_POINT\"] = \"".$aryShopEventList[$i][SE_GIVE_POINT]."\"; \n";
			$strMakeFileText .= "\$S_EVENT_INFO[".$aryShopEventList[$i][SE_NO]."][\"COUPON_USE\"] = \"".$aryShopEventList[$i][SE_COUPON_USE]."\"; \n";
			$strMakeFileText .= "\$S_EVENT_INFO[".$aryShopEventList[$i][SE_NO]."][\"DISCOUNT_USE\"] = \"".$aryShopEventList[$i][SE_DISCOUNT_USE]."\"; \n";
			$strMakeFileText .= "\$S_EVENT_INFO[".$aryShopEventList[$i][SE_NO]."][\"PRICE_MARK\"] = \"".$aryShopEventList[$i][SE_PRICE_MARK]."\"; \n";
		
			$aryUsePriceText = explode("/",$aryShopEventList[$i][SE_PRICE_TEXT]);
			for($j=0;$j<sizeof($arySiteUseLng);$j++){
				$aryPriceText = explode(":",$aryUsePriceText[$j]);
				if ($arySiteUseLng[$j] == $aryPriceText[0]){
					$strMakeFileText .= "\$S_EVENT_INFO[".$aryShopEventList[$i][SE_NO]."][\"PRICE_TEXT\"][\"".$arySiteUseLng[$j]."\"] = \"".$aryPriceText[1]."\"; \n";
				}
			}
		}
	}
	$strMakeFileText = "<?\n".$strMakeFileText."?>\n";
	$file = $_SERVER['DOCUMENT_ROOT'] . "/conf/shop.inc.php";

	

	@chmod($file,0755);
	$fw = fopen($file, "w");
	fputs($fw,$strMakeFileText, strlen($strMakeFileText));
	fclose($fw);
?>