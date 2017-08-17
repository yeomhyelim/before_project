<?
	require_once MALL_CONF_LIB."CateMgr.php";
	require_once MALL_CONF_LIB."ProductAdmMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";
	require_once MALL_CONF_LIB."MemberAdmMgr.php";
	
	$cateMgr = new CateMgr();		
	$productMgr = new ProductAdmMgr();		
	$siteMgr = new SiteMgr();		
	$memberMgr = new MemberMgr();

	require_once MALL_HOME."/web/shopAdmin/basic/_function.lib.inc.php";

	/*##################################### Parameter 셋팅 #####################################*/
	$strSearchField = $_POST["searchField"]		? $_POST["searchField"]		: $_REQUEST["searchField"];
	$strSearchKey	= $_POST["searchKey"]		? $_POST["searchKey"]		: $_REQUEST["searchKey"];
	$intPage		= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];
	$intPageLine	= $_POST["pageLine"]		? $_POST["pageLine"]		: $_REQUEST["pageLine"];

	/* 설정관리 */
	$strS_GIFT_USE			= $_POST["gift_use"]				? $_POST["gift_use"]			: $_REQUEST["gift_use"];
	$strS_MULTI_GIFT_USE	= $_POST["multi_gift_use"]			? $_POST["multi_gift_use"]		: $_REQUEST["multi_gift_use"];
	$strS_GIFT_SETTLE		= $_POST["gift_settle"]				? $_POST["gift_settle"]			: $_REQUEST["gift_settle"];
	$strS_GIFT_PRICE		= $_POST["gift_price"]				? $_POST["gift_price"]			: $_REQUEST["gift_price"];
	
	/* 사은품 등록 */
	$intCG_NO			= $_POST["no"]					? $_POST["no"]					: $_REQUEST["no"];
	$strCG_EACH_USE		= $_POST["each_use"]			? $_POST["each_use"]			: $_REQUEST["each_use"];
	$strCG_FIRST_GIFT	= $_POST["first_gift"]			? $_POST["first_gift"]			: $_REQUEST["first_gift"];
	$strCG_QTY_USE		= $_POST["qty_use"]				? $_POST["qty_use"]				: $_REQUEST["qty_use"];
	$intCG_ST_PRICE		= $_POST["startPrice"]			? $_POST["startPrice"]			: $_REQUEST["startPrice"];
	$intCG_END_PRICE	= $_POST["endPrice"]			? $_POST["endPrice"]			: $_REQUEST["endPrice"];
	$strCG_PRICE_TYPE	= $_POST["price_type"]			? $_POST["price_type"]			: $_REQUEST["price_type"];
	$strCG_STOCK		= $_POST["stock_use"]			? $_POST["stock_use"]			: $_REQUEST["stock_use"];
	$intCG_QTY			= $_POST["qty"]					? $_POST["qty"]					: $_REQUEST["qty"];
	$strCG_LIMIT		= $_POST["limit_use"]			? $_POST["limit_use"]			: $_REQUEST["limit_use"];
	$intCG_LIMIT_QTY	= $_POST["limit_qty"]			? $_POST["limit_qty"]			: $_REQUEST["limit_qty"];
	$strCG_VIEW			= $_POST["view"]				? $_POST["view"]				: $_REQUEST["view"];	

	$strGiftLng			= $_POST["giftLng"]				? $_POST["giftLng"]				: $_REQUEST["giftLng"];
	$aryChkNo			= $_POST["chkNo"]				? $_POST["chkNo"]				: $_REQUEST["chkNo"];

	$strC_HCODE1		= $_POST["cateHCode1"]			? $_POST["cateHCode1"]		: $_REQUEST["cateHCode1"];
	$strC_HCODE2		= $_POST["cateHCode2"]			? $_POST["cateHCode2"]		: $_REQUEST["cateHCode2"];
	$strC_HCODE3		= $_POST["cateHCode3"]			? $_POST["cateHCode3"]		: $_REQUEST["cateHCode3"];
	$strC_HCODE4		= $_POST["cateHCode4"]			? $_POST["cateHCode4"]		: $_REQUEST["cateHCode4"];

	if (!$intCG_ST_PRICE) $intCG_ST_PRICE = 0;
	if (!$intCG_END_PRICE) $intCG_END_PRICE = 0;
	if (!$intCG_QTY) $intCG_QTY = 0;
	if (!$intCG_LIMIT_QTY) $intCG_LIMIT_QTY = 0;

	$strCG_EASH_USE		= strTrim($strCG_EACH_USE,1);
	$strCG_FIRST_GIFT	= strTrim($strCG_FIRST_GIFT,1);
	$strCG_QTY_USE		= strTrim($strCG_QTY_USE,1);
	$strCG_PRICE_TYPE	= strTrim($strCG_PRICE_TYPE,1);
	$strCG_STOCK		= strTrim($strCG_STOCK,1);
	$strCG_LIMIT		= strTrim($strCG_LIMIT,1);

	$productMgr->setCG_NO($intCG_NO);
	$productMgr->setCG_EACH_USE($strCG_EACH_USE);
	$productMgr->setCG_FIRST_GIFT($strCG_FIRST_GIFT);
	$productMgr->setCG_QTY_USE($strCG_QTY_USE);
	$productMgr->setCG_ST_PRICE($intCG_ST_PRICE);
	$productMgr->setCG_END_PRICE($intCG_END_PRICE);
	$productMgr->setCG_PRICE_TYPE($strCG_PRICE_TYPE);
	$productMgr->setCG_STOCK($strCG_STOCK);
	$productMgr->setCG_QTY($intCG_QTY);
	$productMgr->setCG_LIMIT($strCG_LIMIT);
	$productMgr->setCG_LIMIT_QTY($intCG_LIMIT_QTY);
	$productMgr->setCG_FILE($strCG_FILE);
	$productMgr->setCG_VIEW($strCG_VIEW);
	$productMgr->setCG_REG_NO($a_admin_no);
	$productMgr->setCG_MOD_NO($a_admin_no);

	/*##################################### Parameter 셋팅 #####################################*/

	$strLinkPage = "";
	
	switch ($strAct) {
		case "giftSetting":

			$aryData[0]["column"]	= "S_GIFT_USE";
			$aryData[0]["value"]	= $strS_GIFT_USE;

			$aryData[1]["column"]	= "S_MULTI_GIFT_USE";
			$aryData[1]["value"]	= $strS_MULTI_GIFT_USE;

			$aryData[2]["column"]	= "S_GIFT_SETTLE";
			$aryData[2]["value"]	= $strS_GIFT_SETTLE;

			$aryData[3]["column"]	= "S_GIFT_PRICE";
			$aryData[3]["value"]	= $strS_GIFT_PRICE;

			shopInfoInsertUpdate($siteMgr,$aryData);						
			$strMsg = $LNG_TRANS_CHAR["CS00002"]; //"저장되었습니다.";

			include MALL_HOME."/web/shopAdmin/basic/shopMakeFile.php";


			$strUrl = "./?menuType=".$strMenuType."&mode=gift";
		
		break;

		case "giftWrite":
			
			/* 이미지 등록 */
			if ($_FILES["gift_file"][name]){
				if (!getAllowImgFileExt($_FILES["gift_file"][name])){

					goErrMsg($LNG_TRANS_CHAR["CS00009"]); //첨부하신 파일은 확장자가 금지된 파일입니다.
					exit;
				}
				
				$strFileName	= $_FILES["gift_file"][name];
				$strFileTmpName = $_FILES["gift_file"][tmp_name];
				$intFileSize	= $_FILES["gift_file"][size];
				$strFileType	= $_FILES["gift_file"][type];
				
				$fres = $fh->doUpload("","../upload/gift",$strFileName,$strFileTmpName,$intFileSize,$strFileType);

				if($fres) {
					$productMgr->setCG_FILE("/upload/gift/".$fres[file_real_name]);
				}
			}

			$productMgr->getGiftInsert($db);
			$intCG_NO = $db->getLastInsertID();

			$siteRow = $siteMgr->getSiteInfoView($db);
			$aryUseLng = explode("/",$siteRow[S_USE_LNG]);

			$strCG_NAME			= $_POST["name"];
			$strCG_OPT_NM1		= $_POST["opt_nm1"];
			$strCG_OPT_NM2		= $_POST["opt_nm2"];
			$strCG_OPT_ATTR1	= $_POST["opt_attr1"];
			$strCG_OPT_ATTR2	= $_POST["opt_attr2"];

			for($i=0;$i<sizeof($aryUseLng);$i++){
				$strGiftLng = STRTOLOWER($aryUseLng[$i]);
				$productMgr->setCG_NO($intCG_NO);
				$productMgr->setCG_LNG($aryUseLng[$i]);
				$productMgr->setCG_NAME($strCG_NAME);
				$productMgr->setCG_OPT_NM1($strCG_OPT_NM1);
				$productMgr->setCG_OPT_NM2($strCG_OPT_NM2);
				$productMgr->setCG_OPT_ATTR1($strCG_OPT_ATTR1);
				$productMgr->setCG_OPT_ATTR2($strCG_OPT_ATTR2);
				$productMgr->getGiftLngInsert($db);
			}

			$strUrl = "./?menuType=".$strMenuType."&mode=gift";

		break;

		case "giftModify":
			
			$row = $productMgr->getGiftView($db);
			/* 이미지 등록 */
			if ($_FILES["gift_file"][name]){
				if (!getAllowImgFileExt($_FILES["gift_file"][name])){

					goErrMsg($LNG_TRANS_CHAR["CS00009"]); //첨부하신 파일은 확장자가 금지된 파일입니다.
					exit;
				}
				
				$strFileName	= $_FILES["gift_file"][name];
				$strFileTmpName = $_FILES["gift_file"][tmp_name];
				$intFileSize	= $_FILES["gift_file"][size];
				$strFileType	= $_FILES["gift_file"][type];
				
				$fres = $fh->doUpload("","../upload/gift",$strFileName,$strFileTmpName,$intFileSize,$strFileType);

				if($fres) {
					$productMgr->setCG_FILE("/upload/gift/".$fres[file_real_name]);
				}

				if ($row[CG_FILE]){
					$fh->fileDelete("../upload/gift/".$row[CG_FILE]);
				}
			} else {
				$productMgr->setCG_FILE($row[CG_FILE]);
			}
			$productMgr->getGiftUpdate($db);

			$strCG_NAME			= $_POST["name"];
			$strCG_OPT_NM1		= $_POST["opt_nm1"];
			$strCG_OPT_NM2		= $_POST["opt_nm2"];
			$strCG_OPT_ATTR1	= $_POST["opt_attr1"];
			$strCG_OPT_ATTR2	= $_POST["opt_attr2"];
				
			$productMgr->setCG_NO($intCG_NO);
			$productMgr->setCG_LNG($strGiftLng);
			$productMgr->setCG_NAME($strCG_NAME);
			$productMgr->setCG_OPT_NM1($strCG_OPT_NM1);
			$productMgr->setCG_OPT_NM2($strCG_OPT_NM2);
			$productMgr->setCG_OPT_ATTR1($strCG_OPT_ATTR1);
			$productMgr->setCG_OPT_ATTR2($strCG_OPT_ATTR2);
			$productMgr->getGiftLngUpdate($db);
			
			$strUrl = "./?menuType=".$strMenuType."&mode=popGiftModify&no=".$intCG_NO."&giftLng=".$strGiftLng;

		break;

		case "giftFileDel":
			$row = $productMgr->getGiftView($db);
			if ($row[CG_FILE]){
				$fh->fileDelete("../upload/gift/".$row[CG_FILE]);
				$productMgr->getGiftFileUpdate($db);
			}

			$strUrl = "./?menuType=".$strMenuType."&mode=popGiftModify&no=".$intCG_NO."&giftLng=".$strGiftLng;

		break;

		case "giftDelete":
			$row = $productMgr->getGiftView($db);

			$productMgr->setP_LNG($strStLng);
			
			if ($row[CG_EACH_USE] == "Y"){
				$intTotal	= $productMgr->getProdGiftTotal($db);
				if ($intTotal > 0) {
					goErrMsg($LNG_TRANS_CHAR["PS00023"]);
					$db->disConnect();
					exit;
				}
			}

			if ($row[CG_FILE]){
				$fh->fileDelete("../upload/gift/".$row[CG_FILE]);
				$productMgr->getGiftFileUpdate($db);
			}

			$productMgr->getGiftDelete($db);

			$strUrl  = "?menuType=product&mode=gift&searchField=$strSearchField&searchKey=$strSearchKey";
			$strUrl .= "&page=$intPage";

		break;

		case "prodGiftCateAllReg":
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
					$productMgr->getProdGiftProdApply($db);
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

		case "prodGiftProductReg":
			
			$result_array = array();
			
			if (is_array($aryChkNo)){
				
				for($p=0;$p<sizeof($aryChkNo);$p++){

					if ($aryChkNo[$p]) {
						$productMgr->setP_CODE($aryChkNo[$p]);
						$productMgr->getProdGiftProdApply($db);
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

		case "prodGiftProductDelete":
			
			if (is_array($aryChkNo)){
				
				for($p=0;$p<sizeof($aryChkNo);$p++){
					if ($aryChkNo[$p]) {
						$productMgr->setP_CODE($aryChkNo[$p]);
						$productMgr->getProdGitfProductDelete($db);
					}
				}
			} 

			$strUrl = "./?menuType=".$strMenuType."&mode=popProdGiftList&no=".$intCG_NO;

		break;
	}	
?>