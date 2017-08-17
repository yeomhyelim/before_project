<?
	require_once MALL_CONF_LIB."CateMgr.php";
	require_once MALL_CONF_LIB."ProductAdmMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";
	require_once MALL_CONF_LIB."MemberAdmMgr.php";
	
	$cateMgr = new CateMgr();		
	$productMgr = new ProductAdmMgr();		

	$siteMgr = new SiteMgr();		
	$memberMgr = new MemberMgr();

	/*##################################### Parameter 셋팅 #####################################*/
	$strSearchField = $_POST["searchField"]		? $_POST["searchField"]		: $_REQUEST["searchField"];
	$strSearchKey	= $_POST["searchKey"]		? $_POST["searchKey"]		: $_REQUEST["searchKey"];
	$intPage		= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];
	$intPageLine	= $_POST["pageLine"]		? $_POST["pageLine"]		: $_REQUEST["pageLine"];

	$strGb			= $_POST["gb"]				? $_POST["gb"]				: $_REQUEST["gb"];

	$intSE_NO			= $_POST["no"]					? $_POST["no"]				: $_REQUEST["no"];
	$strSE_TYPE			= $_POST["type"]				? $_POST["type"]			: $_REQUEST["type"];
	$strSE_TITLE		= $_POST["title"]				? $_POST["title"]			: $_REQUEST["title"];
	$strSE_DAY_TIME		= $_POST["day_time"]			? $_POST["day_time"]		: $_REQUEST["day_time"];
	$strSE_DAY_TYPE		= $_POST["day_type"]			? $_POST["day_type"]		: $_REQUEST["day_type"];
	$intSE_DAY			= $_POST["day"]					? $_POST["day"]				: $_REQUEST["day"];
	$intSE_PRICE		= $_POST["price"]				? $_POST["price"]			: $_REQUEST["price"];
	$strSE_PRICE_TYPE	= $_POST["price_type"]			? $_POST["price_type"]		: $_REQUEST["price_type"];
	$strSE_PRICE_OFF	= $_POST["price_off"]			? $_POST["price_off"]		: $_REQUEST["price_off"];
	$strSE_SELL_AUTH	= $_POST["sell_auth"]			? $_POST["sell_auth"]		: $_REQUEST["sell_auth"];
	$strSE_GIVE_POINT	= $_POST["give_point"]			? $_POST["give_point"]		: $_REQUEST["give_point"];
	$strSE_COUPON_USE	= $_POST["coupon_use"]			? $_POST["coupon_use"]		: $_REQUEST["coupon_use"];
	$strSE_DISCOUNT_USE	= $_POST["discount_use"]		? $_POST["discount_use"]	: $_REQUEST["discount_use"];
	$strSE_MSG			= $_POST["msg"]					? $_POST["msg"]				: $_REQUEST["msg"];

	$strSE_PRICE_MARK	= $_POST["price_mark"]			? $_POST["price_mark"]		: $_REQUEST["price_mark"];
	$arySE_PRICE_TEXT	= $_POST["price_text"]			? $_POST["price_text"]		: $_REQUEST["price_text"];

	$strSE_START_DT1	= $_POST["eventStartDt"]		? $_POST["eventStartDt"]	: $_REQUEST["eventStartDt"];
	$strSE_START_DT2	= $_POST["eventStartHour"]		? $_POST["eventStartHour"]	: $_REQUEST["eventStartHour"];
	$strSE_START_DT3	= $_POST["eventStartMin"]		? $_POST["eventStartMin"]	: $_REQUEST["eventStartMin"];
	$strSE_START_DT		= $strSE_START_DT1." ".$strSE_START_DT2.":".$strSE_START_DT3.":00";

	$strSE_END_DT1		= $_POST["eventEndDt"]			? $_POST["eventEndDt"]		: $_REQUEST["eventEndDt"];
	$strSE_END_DT2		= $_POST["eventEndHour"]		? $_POST["eventEndHour"]	: $_REQUEST["eventEndHour"];
	$strSE_END_DT3		= $_POST["eventEndMin"]			? $_POST["eventEndMin"]	: $_REQUEST["eventEndMin"];
	$strSE_END_DT		= $strSE_END_DT1." ".$strSE_END_DT2.":".$strSE_END_DT3.":00";
	
	/* 이벤트별 상품 적용하기 */
	$strC_HCODE1		= $_POST["cateHCode1"]			? $_POST["cateHCode1"]		: $_REQUEST["cateHCode1"];
	$strC_HCODE2		= $_POST["cateHCode2"]			? $_POST["cateHCode2"]		: $_REQUEST["cateHCode2"];
	$strC_HCODE3		= $_POST["cateHCode3"]			? $_POST["cateHCode3"]		: $_REQUEST["cateHCode3"];
	$strC_HCODE4		= $_POST["cateHCode4"]			? $_POST["cateHCode4"]		: $_REQUEST["cateHCode4"];

	$strSearchField		= $_POST["searchField"]			? $_POST["searchField"]		: $_REQUEST["searchField"];
	$strSearchKey		= $_POST["searchKey"]			? $_POST["searchKey"]		: $_REQUEST["searchKey"];
	
	$aryChkNo			= $_POST["chkNo"]				? $_POST["chkNo"]				: $_REQUEST["chkNo"];

	$strSE_TYPE			= strTrim($strSE_TYPE,1);
	$strSE_TITLE		= strTrim($strSE_TITLE,200);
	$strSE_DAY_TIME		= strTrim($strSE_DAY_TIME,1);
	$strSE_DAY_TYPE		= strTrim($strSE_DAY_TYPE,1);
	$strSE_PRICE_TYPE	= strTrim($strSE_PRICE_TYPE,1);
	$strSE_PRICE_OFF	= strTrim($strSE_PRICE_OFF,1);
	$strSE_SELL_AUTH	= strTrim($strSE_SELL_AUTH,1);
	$strSE_GIVE_POINT	= strTrim($strSE_GIVE_POINT,1);
	$strSE_COUPON_USE	= strTrim($strSE_COUPON_USE,1);
	$strSE_DISCOUNT_USE	= strTrim($strSE_DISCOUNT_USE,1);
	$strSE_MSG			= strTrim($strSE_MSG,"","N");
	
	if (!$intSE_DAY) $intSE_DAY = 0;
	
	$productMgr->setSE_NO($intSE_NO);
	$productMgr->setSE_TYPE($strSE_TYPE);
	$productMgr->setSE_TITLE($strSE_TITLE);
	$productMgr->setSE_DAY_TIME($strSE_DAY_TIME);
	$productMgr->setSE_DAY_TYPE($strSE_DAY_TYPE);
	$productMgr->setSE_DAY($intSE_DAY);
	$productMgr->setSE_START_DT($strSE_START_DT);
	$productMgr->setSE_END_DT($strSE_END_DT);
	$productMgr->setSE_PRICE($intSE_PRICE);
	$productMgr->setSE_PRICE_TYPE($strSE_PRICE_TYPE);
	$productMgr->setSE_PRICE_OFF($strSE_PRICE_OFF);
	$productMgr->setSE_SELL_AUTH($strSE_SELL_AUTH);
	$productMgr->setSE_GIVE_POINT($strSE_GIVE_POINT);
	$productMgr->setSE_COUPON_USE($strSE_COUPON_USE);
	$productMgr->setSE_DISCOUNT_USE($strSE_DISCOUNT_USE);
	$productMgr->setSE_MSG($strSE_MSG);
	$productMgr->setSE_PRICE_MARK($strSE_PRICE_MARK);
	$productMgr->setSE_REG_NO($a_admin_no);
	$productMgr->setSE_MOD_NO($a_admin_no);

	/*##################################### PRODUCT    #####################################*/

	$strLinkPage = "";

	switch ($strAct) {
		case "prodEventWrite":
			
			$strEventPriceText = "";
			$arySiteUseLng = explode("/",$S_USE_LNG);
			if (is_array($arySiteUseLng)){
				for($i=0;$i<sizeof($arySiteUseLng);$i++){
					$strEventPriceText .= $arySiteUseLng[$i].":".$arySE_PRICE_TEXT[$i]."/";
				}
			}

			$productMgr->setSE_PRICE_TEXT($strEventPriceText);
			$productMgr->getProdEventInsert($db);

			$strUrl = "./?menuType=".$strMenuType."&mode=prodEvent";
		
		break;
		case "prodEventModify":
			
			$strEventPriceText = "";
			$arySiteUseLng = explode("/",$S_USE_LNG);
			if (is_array($arySiteUseLng)){
				for($i=0;$i<sizeof($arySiteUseLng);$i++){
					$strEventPriceText .= $arySiteUseLng[$i].":".$arySE_PRICE_TEXT[$i]."/";
				}
			}

			$productMgr->setSE_PRICE_TEXT($strEventPriceText);

			$productMgr->setSE_NO($intSE_NO);
			$productMgr->getProdEventUpdate($db);

			$strUrl = "./?menuType=".$strMenuType."&mode=popProdEvent&no=".$intSE_NO;
		
		break;		

		case "prodEventDelete":
			
			$productMgr->setSE_NO($intSE_NO);
			$productMgr->getProdEventDelete($db);
			
			$productMgr->getProdEventProductAllDelete($db);
			$strUrl = "./?menuType=".$strMenuType."&mode=prodEvent&gb=".$strGb;
		
		break;		

		case "prodEventCateAllReg":
			$result_array = array();

			if ($strC_HCODE1) {
				$productMgr->setP_LNG($strStLng);

				$productMgr->setSearchHCode1($strC_HCODE1);
				$productMgr->setSearchHCode2($strC_HCODE2);
				$productMgr->setSearchHCode3($strC_HCODE3);
				$productMgr->setSearchHCode4($strC_HCODE4);

				$intPageBlock	= 10;
				
				$intTotal	= $productMgr->getProdTotal($db);
				$productMgr->setPageLine($intTotal);
				$productMgr->setLimitFirst(0);

				$result = $productMgr->getProdList($db);

				while($row = mysql_fetch_array($result)){
					
					$productMgr->setP_CODE($row[P_CODE]);
					$productMgr->setP_EVENT($intSE_NO);
					$productMgr->getProdEventProdApply($db);
				}

				$jsonResult[0][RET] = "Y";
			} else {
				$jsonResult[0][RET] = "N";
			}
			
			$result_array = json_encode($jsonResult);
			echo $result_array;		
			$db->disConnect();
			exit;			

		break;

		case "prodEventProductReg":
			$result_array = array();
			
			if (is_array($aryChkNo)){
				
				for($p=0;$p<sizeof($aryChkNo);$p++){

					if ($aryChkNo[$p]) {
						$productMgr->setP_CODE($aryChkNo[$p]);
						$productMgr->setP_EVENT($intSE_NO);
						$productMgr->getProdEventProdApply($db);
					}
				}

				$result[0][RET] = "Y";
			} else {
				$result[0][RET] = "N";
			}
			
			$result_array = json_encode($result);
			echo $result_array;		
			$db->disConnect();
			exit;			

		break;

		case "prodEventProductDelete":
			if (is_array($aryChkNo)){
				
				for($p=0;$p<sizeof($aryChkNo);$p++){
					if ($aryChkNo[$p]) {
						$productMgr->setP_CODE($aryChkNo[$p]);
						$productMgr->getProdEventProductDelete($db);
					}
				}
			} 

			$strUrl = "./?menuType=".$strMenuType."&mode=popProdEventList&no=".$intSE_NO;

		break;
	}	

	include MALL_HOME."/web/shopAdmin/basic/shopMakeFile.php";

?>