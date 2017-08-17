<?
	
	require_once MALL_CONF_LIB."MemberAdmMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";
	require_once MALL_CONF_LIB."CateMgr.php";
	require_once MALL_CONF_LIB."CouponMgr.php";
	require_once MALL_CONF_LIB."ProductAdmMgr.php";

	$memberMgr = new MemberMgr();
	$siteMgr = new SiteMgr();
	$cateMgr = new CateMgr();	
	$couponMgr = new CouponMgr();
	$productMgr = new ProductAdmMgr();

	require_once "basic.param.inc.php";
	
	/*##################################### Parameter 셋팅 #####################################*/
	$strCU_NAME			= $_POST["name"]			? $_POST["name"]			: $_REQUEST["name"];
	$strCU_TEXT			= $_POST["memo"]			? $_POST["memo"]			: $_REQUEST["memo"];
	$strCU_TYPE			= $_POST["type"]			? $_POST["type"]			: $_REQUEST["type"];
	$strCU_ISSUE		= $_POST["issue"]			? $_POST["issue"]			: $_REQUEST["issue"];
	$intCU_PRICE		= $_POST["price"]			? $_POST["price"]			: $_REQUEST["price"];
	$strCU_PRICE_OFF	= $_POST["price_off"]		? $_POST["price_off"]		: $_REQUEST["price_off"];
	$strCU_USE			= $_POST["use"]				? $_POST["use"]				: $_REQUEST["use"];
	$strCU_IMG_MTH		= $_POST["img_mth"]			? $_POST["img_mth"]			: $_REQUEST["img_mth"];
	$strCU_IMG_PATH		= $_POST["img_path"]		? $_POST["img_path"]		: $_REQUEST["img_path"];
	$strCU_PERIOD		= $_POST["period"]			? $_POST["period"]			: $_REQUEST["period"];
	$strCU_START_DT		= $_POST["start_dt"]		? $_POST["start_dt"]		: $_REQUEST["start_dt"];
	$strCU_END_DT		= $_POST["end_dt"]			? $_POST["end_dt"]			: $_REQUEST["end_dt"];
	$intCU_USE_DAY		= $_POST["use_day"]			? $_POST["use_day"]			: $_REQUEST["use_day"];
	$intCU_LIMIT_PRICE	= $_POST["limit_price"]		? $_POST["limit_price"]		: $_REQUEST["limit_price"];
	$strCU_LIMIT_SETTLE = $_POST["limit_settle"]	? $_POST["limit_settle"]	: $_REQUEST["limit_settle"];
	$strCU_LIMIT_MEMBER = $_POST["limit_member"]	? $_POST["limit_member"]	: $_REQUEST["limit_member"];
	$strCU_USEYN		= $_POST["useYN"]			? $_POST["useYN"]			: $_REQUEST["useYN"];
	$intCU_CNT			= $_POST["issue_cnt"]		? $_POST["issue_cnt"]		: $_REQUEST["issue_cnt"];

	/* 할인예외상품코드 */
	$strP_CODE			= $_POST["prodCode"]		? $_POST["prodCode"]		: $_REQUEST["prodCode"];

	$aryG_EXP_CATEGORY	= $_POST["categoryExpCode"]	? $_POST["categoryExpCode"]	: $_REQUEST["categoryExpCode"];
	$aryG_EXP_PRODUCT	= $_POST["productExpCode"]	? $_POST["productExpCode"]	: $_REQUEST["productExpCode"];

	/*##################################### Parameter 셋팅 #####################################*/

	/* 쿠폰 관리 */
	$strCU_NAME				= strTrim($strCU_NAME,100);
	$strCU_TEXT				= strTrim($strCU_TEXT,250);
	$strCU_TYPE				= strTrim($strCU_TYPE,1);
	$strCU_ISSUE			= strTrim($strCU_ISSUE,1);
	$strCU_PRICE_OFF		= strTrim($strCU_PRICE_OFF,1);
	$strCU_USE				= strTrim($strCU_USE,1);
	$strCU_IMG_MTH			= strTrim($strCU_IMG_MTH,1);
	$strCU_IMG_PATH			= strTrim($strCU_IMG_PATH,100);
	$strCU_PERIOD			= strTrim($strCU_PERIOD,1);
	$strCU_LIMIT_SETTLE		= strTrim($strCU_LIMIT_SETTLE,1);
	$strCU_LIMIT_MEMBER		= strTrim($strCU_LIMIT_MEMBER,1);
	
	if ($strCU_START_DT == "0000-00-00") $strCU_START_DT = "";
	if ($strCU_END_DT == "0000-00-00") $strCU_END_DT = "";
	
	$couponMgr->setCU_NO($intCU_NO);
	$couponMgr->setCU_NAME($strCU_NAME);
	$couponMgr->setCU_TEXT($strCU_TEXT);
	$couponMgr->setCU_TYPE($strCU_TYPE);
	$couponMgr->setCU_ISSUE($strCU_ISSUE);
	$couponMgr->setCU_PRICE($intCU_PRICE);
	$couponMgr->setCU_PRICE_OFF($strCU_PRICE_OFF);
	$couponMgr->setCU_USE($strCU_USE);
	$couponMgr->setCU_IMG_MTH($strCU_IMG_MTH);
	$couponMgr->setCU_IMG_PATH($strCU_IMG_PATH);
	$couponMgr->setCU_PERIOD($strCU_PERIOD);
	$couponMgr->setCU_START_DT($strCU_START_DT);
	$couponMgr->setCU_END_DT($strCU_END_DT);
	$couponMgr->setCU_USE_DAY($intCU_USE_DAY);
	$couponMgr->setCU_LIMIT_PRICE($intCU_LIMIT_PRICE);
	$couponMgr->setCU_LIMIT_SETTLE($strCU_LIMIT_SETTLE);
	$couponMgr->setCU_LIMIT_MEMBER($strCU_LIMIT_MEMBER);
	$couponMgr->setCU_USEYN($strCU_USEYN);
	$couponMgr->setCU_CNT($intCU_CNT);
	$couponMgr->setCU_REG_NO($a_admin_no);
	$couponMgr->setCU_MOD_NO($a_admin_no);
			
	switch ($strAct) {

		case "couponProdSearch":
			
			$productMgr->setP_LNG($strAdmSiteLng);
			$productMgr->setP_CODE($strP_CODE);
			$result = $productMgr->getProdInfoJson($db);
			$result[0][RET] = "Y";
			$result_array = json_encode($result);
			
			$db->disConnect();
			echo $result_array;	
			exit;

		break;
		case "couponWrite":

			if ($_FILES["img_file"][name]){
				if (!getAllowImgFileExt($_FILES["img_file"][name])){
					goErrMsg($LNG_TRANS_CHAR["CS00009"]); //첨부하신 파일은 확장자가 금지된 파일입니다.
					exit;
				}
				
				$strFileName	= $_FILES["img_file"][name];
				$strFileTmpName = $_FILES["img_file"][tmp_name];
				$intFileSize	= $_FILES["img_file"][size];
				$strFileType	= $_FILES["img_file"][type];
				
				$fres = $fh->doUpload("","../upload/coupon",$strFileName,$strFileTmpName,$intFileSize,$strFileType);
			
				if($fres) {
					$couponMgr->setCU_IMG_PATH($fres[file_real_name]);
					
				} else {
					$couponMgr->setCU_IMG_PATH("");
				}
			}

			$couponMgr->getInsert($db);
			$intCU_NO = $db->getLastInsertID();
			$couponMgr->setCU_NO($intCU_NO);
			
			if ($intCU_NO > 0){
				/* 특정 카테고리 */
				if (is_array($aryG_EXP_CATEGORY)){
					for($i=0;$i<sizeof($aryG_EXP_CATEGORY);$i++){
						$couponMgr->setCUA_CODE(pushBackZero($aryG_EXP_CATEGORY[$i],12));
						$couponMgr->getApplyInsert($db);
					}
				}
				
				/* 특정 상품 */
				if (is_array($aryG_EXP_PRODUCT)){
					for($i=0;$i<sizeof($aryG_EXP_PRODUCT);$i++){
						$couponMgr->setCUA_CODE($aryG_EXP_PRODUCT[$i]);
						$couponMgr->getApplyInsert($db);
					}
				}
			}
			
			/* 오프라인 발급이고 쿠폰수가 있을때 쿠폰바로발급 */
			if ($strCU_ISSUE == "6" && $intCU_CNT > 0){

				for($i=1;$i<=$intCU_CNT;$i++){

					$strCouponCode = $intCU_NO.strtoupper(getCode(10));
					$couponMgr->setCI_CODE($strCouponCode);
					$intDupCnt = $couponMgr->getCouponCodeDupCnt($db);
					if ($intDupCnt > 0){
						$strFlag = false;

						while($strFlag == false){

							$strCouponCode = $intCU_NO.strtoupper(getCode(10));
							$couponMgr->setCI_CODE($strCouponCode);
							$intDupCnt = $couponMgr->getCouponCodeDupCnt($db);
							
							if($intDupKeyCnt=="0"){
								$strFlag = true;
								break;
							}
						}
					}
				
					$couponMgr->setM_NO(0);
					$couponMgr->getIssueInsert($db);

				}
			}
			/* 오프라인 발급이고 쿠폰수가 있을때 쿠폰바로발급 */
			
			$strUrl = "./?menuType=".$strMenuType."&mode=couponList";
			$strMsg = $LNG_TRANS_CHAR["MS00030"]; //"쿠폰이 생성되었습니다.";


		break;

			
		case "couponModify":
			
			$couponMgr->setCU_NO($intCU_NO);
			$row = $couponMgr->getCouponView($db);

			if ($_FILES["img_file"][name]){
				if (!getAllowImgFileExt($_FILES["img_file"][name])){
					goErrMsg($LNG_TRANS_CHAR["CS00009"]); //첨부하신 파일은 확장자가 금지된 파일입니다.
					exit;
				}
				
				$strFileName	= $_FILES["img_file"][name];
				$strFileTmpName = $_FILES["img_file"][tmp_name];
				$intFileSize	= $_FILES["img_file"][size];
				$strFileType	= $_FILES["img_file"][type];
				
				$fres = $fh->doUpload("","../upload/coupon",$strFileName,$strFileTmpName,$intFileSize,$strFileType);
			
				if($fres) {
					$couponMgr->setCU_IMG_PATH($fres[file_real_name]);

					if ($row[CU_IMG_PATH]){
						$fh->fileDelete("../upload/coupon/".$row[CU_IMG_PATH]);
					}
				} else {
					$couponMgr->setCU_IMG_PATH($row[CU_IMG_PATH]);
				}
			} else {
				$couponMgr->setCU_IMG_PATH($row[CU_IMG_PATH]);
			}

			$couponMgr->getUpdate($db);
			
			if ($intCU_NO > 0){

				/* 특정 카테고리 */
				if (is_array($aryG_EXP_CATEGORY)){
					$strCouponApplyNoList = "";
					for($i=0;$i<sizeof($aryG_EXP_CATEGORY);$i++){
						$couponMgr->setCU_USE("2");
						$couponMgr->setCUA_CODE(pushBackZero($aryG_EXP_CATEGORY[$i],12));
						
						$couponMgr->getApplyInsert($db);
						
						$strCouponApplyNoList .= "'".pushBackZero($aryG_EXP_CATEGORY[$i],12)."',";
					}
					
					if ($strCouponApplyNoList) {
						$strCouponApplyNoList = SUBSTR($strCouponApplyNoList,0,STRLEN($strCouponApplyNoList)-1);
						$couponMgr->setCU_USE("2");
						$couponMgr->setCUA_NO_ALL($strCouponApplyNoList);
						$couponMgr->getCouponApplyAllDelete($db);
					}

					$strCouponApplyNoList = "";
				} else {
					$couponMgr->setCU_USE("2");
					$couponMgr->getCouponApplyAllDelete($db);
				}

				/* 특정 상품 */
				if (is_array($aryG_EXP_PRODUCT)){
					$strCouponApplyNoList = "";
					for($i=0;$i<sizeof($aryG_EXP_PRODUCT);$i++){
						$couponMgr->setCU_USE("3");
						$couponMgr->setCUA_CODE($aryG_EXP_PRODUCT[$i]);
						$couponMgr->getApplyInsert($db);

						$strCouponApplyNoList .= "'".$aryG_EXP_PRODUCT[$i]."',";
					}

					if ($strCouponApplyNoList) {
						$strCouponApplyNoList = SUBSTR($strCouponApplyNoList,0,STRLEN($strCouponApplyNoList)-1);
						$couponMgr->setCU_USE("3");
						$couponMgr->setCUA_NO_ALL($strCouponApplyNoList);
						$couponMgr->getCouponApplyAllDelete($db);
					}
				} else {
					$couponMgr->setCU_USE("3");
					$couponMgr->getCouponApplyAllDelete($db);
				}
			}

			if ($strCU_USE == "1"){
				
				$couponMgr->setCU_USE("2");
				$couponMgr->getCouponApplyAllDelete($db);

				$couponMgr->setCU_USE("3");
				$couponMgr->getCouponApplyAllDelete($db);
			}

			if ($strCU_PERIOD == "3") {
				$couponMgr->getCouponIssueDateUpdate($db);
			}

			/* 사용기간수정 */
			if ($row['CU_PERIOD'] != $strCU_PERIOD || ($strCU_START_DT != $row['CU_START_DT']) || ($strCU_END_DT != $row['CU_END_DT']) || ($intCU_USE_DAY != $row['CU_USE_DAY']))
			{
				$param					= "";
				$param['CU_NO']			= $intCU_NO;
				$param['CU_START_DT']	= $strCU_START_DT;
				$param['CU_END_DT']		= $strCU_END_DT;
				$param['CU_USE_DAY']	= $intCU_USE_DAY;
				$param['CU_PERIOD']		= $strCU_PERIOD;
				$couponMgr->getCouponIssueUpdate($db,$param);
			}

			$strLinkPage  = "&searchField=$strSearchField&searchKey=$strSearchKey";
			$strLinkPage .= "&searchCouponIssue=$strSearchCouponIssue";
			$strLinkPage .= "&searchCouponUse=$strSearchCouponUse&page=$intPage";

			$strUrl = "./?menuType=".$strMenuType."&mode=couponModify&cuNo=$intCU_NO".$strLinkPage;
			$strMsg = $LNG_TRANS_CHAR["MS00031"]; //"쿠폰이 수정되었습니다.";

		break;	

		case "couponDelete":
			
			$couponMgr->setCU_NO($intCU_NO);
			$row = $couponMgr->getCouponView($db);

			/* 쿠폰 발행 사용유무 */
			$intCouponUseCnt = $couponMgr->getCouponIsUse($db);
			if ($intCouponUseCnt > 0) {
				goErrMsg($LNG_TRANS_CHAR["MS00032"]); //"이미 사용된 쿠폰이 존재합니다.삭제하실 수 없습니다. 
				exit;
			}

			/* 특정상품/카테고리 쿠폰 삭제 */
			$couponMgr->getCouponApplyDelete($db);
			
			/* 쿠폰 삭제 */
			$couponMgr->getDelete($db);
			
			if ($row[CU_IMG_PATH]){
				$fh->fileDelete("../upload/coupon/".$row[CU_IMG_PATH]);
			}
			
			/* 발행쿠폰 삭제 */
			$couponMgr->getCouponIssueDelete($db);

			$strLinkPage  = "&searchField=$strSearchField&searchKey=$strSearchKey";
			$strLinkPage .= "&searchCouponIssue=$strSearchCouponIssue";
			$strLinkPage .= "&searchCouponUse=$strSearchCouponUse&page=$intPage";

			$strUrl = "./?menuType=".$strMenuType."&mode=couponList".$strLinkPage;
			$strMsg = $LNG_TRANS_CHAR["MS00033"]; //"쿠폰이 삭제되었습니다.";

		break;

		case "couponMemberChoiceCreate":
			/* 쿠폰 생성 */
			$couponMgr->setCI_REG_NO($a_admin_no);
			$couponMgr->setCU_NO($intCU_NO);
			$row = $couponMgr->getCouponView($db);

			if (is_array($aryChkNo)){
				for($i=0;$i<sizeof($aryChkNo);$i++){
					
					$strCouponCode = $intCU_NO.strtoupper(getCode(10));
					$couponMgr->setCI_CODE($strCouponCode);
					$intDupCnt = $couponMgr->getCouponCodeDupCnt($db);
					if ($intDupCnt > 0){
						$strFlag = false;

						while($strFlag == false){

							$strCouponCode = $intCU_NO.strtoupper(getCode(10));
							$couponMgr->setCI_CODE($strCouponCode);
							$intDupCnt = $couponMgr->getCouponCodeDupCnt($db);
							
							if($intDupKeyCnt=="0"){
								$strFlag = true;
								break;
							}
						}
					}
				
					$couponMgr->setM_NO($aryChkNo[$i]);
					$couponMgr->getIssueInsert($db);
				}
			}
				
			$result[0][RET] = "Y";
			$result_array = json_encode($result);
			
			$db->disConnect();
			echo $result_array;	

			exit;
			
		break;

		case "couponMemberAllCreate":
			
			/* 전체쿠폰생성 */
			$couponMgr->setCI_REG_NO($a_admin_no);
			$couponMgr->setCU_NO($intCU_NO);
			$row = $couponMgr->getCouponView($db);

			$memberMgr->setSearchField("N");
			$memberMgr->setSearchKey($strSearchKey);
			$memberMgr->setSearchGroup($strSearchGroup);
			
			//회원정보
			$intTotal = $memberMgr->getMemberTotal($db);						
			$memberMgr->setLimitFirst(0);
			$memberMgr->setPageLine($intTotal);
			$memberResult = $memberMgr->getMemberList($db);
			
			while($memberRow = mysql_fetch_array($memberResult)){
				
				$strCouponCode = $intCU_NO.strtoupper(getCode(10));
				$couponMgr->setCI_CODE($strCouponCode);
				$intDupCnt = $couponMgr->getCouponCodeDupCnt($db);
				if ($intDupCnt > 0){
					$strFlag = false;

					while($strFlag == false){

						$strCouponCode = $intCU_NO.strtoupper(getCode(10));
						$couponMgr->setCI_CODE($strCouponCode);
						$intDupCnt = $couponMgr->getCouponCodeDupCnt($db);
						
						if($intDupKeyCnt=="0"){
							$strFlag = true;
							break;
						}
					}
				}
				$couponMgr->setM_NO($memberRow[M_NO]);
				$couponMgr->getIssueInsert($db);
			}

			$result[0][RET] = "Y";
			$result_array = json_encode($result);
			
			$db->disConnect();
			echo $result_array;	

			exit;

		break;

		case "couponIssueDelete":
			
			$couponMgr->setCI_NO($intCI_NO);
			$couponMgr->setCU_NO("");
			$couponMgr->getCouponIssueDelete($db);

			$strLinkPage  = "&searchField=$strSearchField&searchKey=$strSearchKey";
			$strLinkPage .= "&searchCouponIssue=$strSearchCouponIssue";
			$strLinkPage .= "&searchCouponUse=$strSearchCouponUse&page=$intPage&cuNo=$intCU_NO";

			$strUrl = "./?menuType=".$strMenuType."&mode=couponView".$strLinkPage;
			$strMsg = $LNG_TRANS_CHAR["MS00034"]; //"쿠폰발급정보가 삭제되었습니다.";

		break;

		case "couponImgDel":
			$couponMgr->setCU_NO($intCU_NO);
			$row = $couponMgr->getCouponView($db);

			if ($row[CU_IMG_PATH]){
				$fh->fileDelete("../upload/coupon/".$row[CU_IMG_PATH]);
			}

			$couponMgr->getCouponImgUpdate($db);

			$strLinkPage  = "&searchField=$strSearchField&searchKey=$strSearchKey";
			$strLinkPage .= "&searchCouponIssue=$strSearchCouponIssue";
			$strLinkPage .= "&searchCouponUse=$strSearchCouponUse&page=$intPage&cuNo=$intCU_NO";

			$strUrl = "./?menuType=".$strMenuType."&mode=couponModify".$strLinkPage;
			$strMsg = $LNG_TRANS_CHAR["MS00035"]; //"쿠폰 이미지가 삭제되었습니다.";
		break;
	}

?>