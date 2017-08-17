<?
	
	require_once MALL_CONF_LIB."MemberAdmMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";
	require_once MALL_CONF_LIB."CateMgr.php";
	require_once MALL_CONF_LIB."ProductAdmMgr.php";

	$memberMgr = new MemberMgr();
	$siteMgr = new SiteMgr();
	$cateMgr = new CateMgr();	
	$productMgr = new ProductAdmMgr();

	require_once "basic.param.inc.php";
	
	/*##################################### Parameter 셋팅 #####################################*/
	$strG_NAME					= $_POST["name"]				? $_POST["name"]				: $_REQUEST["name"];
	$strG_SHOW					= $_POST["show"]				? $_POST["show"]				: $_REQUEST["show"];
	$strG_APPLY					= $_POST["apply"]				? $_POST["apply"]				: $_REQUEST["apply"];
	$aryG_SETTLE				= $_POST["settle"]				? $_POST["settle"]				: $_REQUEST["settle"];

	$strG_PRICE_ST				= $_POST["price_st"]			? $_POST["price_st"]			: $_REQUEST["price_st"];
	$intG_PRICE_MIN				= $_POST["price_min"]			? $_POST["price_min"]			: $_REQUEST["price_min"];
	$intG_PRICE_MAX				= $_POST["price_max"]			? $_POST["price_max"]			: $_REQUEST["price_max"];
	$intG_BUY_CNT				= $_POST["buy_cnt"]				? $_POST["buy_cnt"]				: $_REQUEST["buy_cnt"];
	$intG_PRODUCT_CNT			= $_POST["product_cnt"]			? $_POST["product_cnt"]			: $_REQUEST["product_cnt"];
	$strG_DISCOUNT_ST			= $_POST["discount_st"]			? $_POST["discount_st"]			: $_REQUEST["discount_st"];
	$intG_DISCOUNT_PRICE		= $_POST["discount_price"]		? $_POST["discount_price"]		: $_REQUEST["discount_price"];
	$intG_DISCOUNT_RATE			= $_POST["discount_rate"]		? $_POST["discount_rate"]		: $_REQUEST["discount_rate"];
	$strG_DISCOUNT_UNIT			= $_POST["discount_unit"]		? $_POST["discount_unit"]		: $_REQUEST["discount_unit"];
	$strG_DISCOUNT_POINT		= $_POST["discount_point"]		? $_POST["discount_point"]		: $_REQUEST["discount_point"];
	$strG_DISCOUNT_OFF			= $_POST["discount_off"]		? $_POST["discount_off"]		: $_REQUEST["discount_off"];
	$intG_POINT_PRICE			= $_POST["point_price"]			? $_POST["point_price"]			: $_REQUEST["point_price"];
	$intG_POINT_RATE			= $_POST["point_rate"]			? $_POST["point_rate"]			: $_REQUEST["point_rate"];
	$strG_POINT_UNIT			= $_POST["point_unit"]			? $_POST["point_unit"]			: $_REQUEST["point_unit"];
	$strG_POINT_POINT			= $_POST["point_point"]			? $_POST["point_point"]			: $_REQUEST["point_point"];
	$strG_POINT_OFF				= $_POST["point_off"]			? $_POST["point_off"]			: $_REQUEST["point_off"];

	$strG_ADD_DISCOUNT			= $_POST["add_discount"]		? $_POST["add_discount"]		: $_REQUEST["add_discount"];
	$intG_ADD_DISCOUNT_PRICE	= $_POST["add_discount_price"]	? $_POST["add_discount_price"]	: $_REQUEST["add_discount_price"];
	$intG_ADD_DISCOUNT_RATE		= $_POST["add_discount_rate"]	? $_POST["add_discount_rate"]	: $_REQUEST["add_discount_rate"];
	$strG_ADD_DISCOUNT_UNIT		= $_POST["add_discount_unit"]	? $_POST["add_discount_unit"]	: $_REQUEST["add_discount_unit"];
	$strG_ADD_DISCOUNT_OFF		= $_POST["add_discount_off"]	? $_POST["add_discount_off"]	: $_REQUEST["add_discount_off"];
	$strG_ADD_DISCOUNT_POINT	= $_POST["add_discount_point"]	? $_POST["add_discount_point"]	: $_REQUEST["add_discount_point"];

	$strG_MEMO					= $_POST["memo"]				? $_POST["memo"]				: $_REQUEST["memo"];
	$aryG_EXP_CATEGORY			= $_POST["categoryExpCode"]		? $_POST["categoryExpCode"]		: $_REQUEST["categoryExpCode"];
	$aryG_EXP_PRODUCT			= $_POST["productExpCode"]		? $_POST["productExpCode"]		: $_REQUEST["productExpCode"];

	/* 할인예외상품코드 */
	$strP_CODE					= $_POST["prodCode"]			? $_POST["prodCode"]			: $_REQUEST["prodCode"];
	/*##################################### Parameter 셋팅 #####################################*/

	$strG_NAME					= strTrim($strG_NAME,50);
	$strG_SHOW					= strTrim($strG_SHOW,1);
	$strG_APPLY					= strTrim($strG_APPLY,1);
	$strG_PRICE_ST				= strTrim($strG_PRICE_ST,1);
	$strG_ICON					= strTrim($strG_ICON,100);
	$strG_DISCOUNT_ST			= strTrim($strG_DISCOUNT_ST,1);
	$strG_DISCOUNT_UNIT			= strTrim($strG_DISCOUNT_UNIT,1);
	$strG_DISCOUNT_POINT		= strTrim($strG_DISCOUNT_POINT,1);
	$strG_POINT_UNIT			= strTrim($strG_POINT_UNIT,1);
	$strG_POINT_POINT			= strTrim($strG_POINT_POINT,1);
	$strG_ADD_DISCOUNT			= strTrim($strG_ADD_DISCOUNT,1);
	$strG_ADD_DISCOUNT_UNIT		= strTrim($strG_ADD_DISCOUNT_UNIT,1);
	$strG_ADD_DISCOUNT_POINT	= strTrim($strG_ADD_DISCOUNT_POINT,1);
	$strG_IMG					= strTrim($strG_IMG,100);
	$strG_FILE					= strTrim($strG_FILE,100);
	$strG_MEMO					= strTrim($strG_MEMO,"","N");

	if (is_array($aryG_SETTLE)){
		for($i=0;$i<sizeof($aryG_SETTLE);$i++){
			$strG_SETTLE .= "/".$aryG_SETTLE[$i];	
		}
	}

	if (is_array($aryG_EXP_CATEGORY)){
		for($i=0;$i<sizeof($aryG_EXP_CATEGORY);$i++){
			$strG_EXP_CATEGORY .= "/".$aryG_EXP_CATEGORY[$i];	
		}
	}
	
	if (is_array($aryG_EXP_PRODUCT)){
		for($i=0;$i<sizeof($aryG_EXP_PRODUCT);$i++){
			$strG_EXP_PRODUCT .= "/".$aryG_EXP_PRODUCT[$i];	
		}
	}

	if (!$intG_PRICE_MIN) $intG_PRICE_MIN = 0;
	if (!$intG_PRICE_MAX) $intG_PRICE_MAX = 0;
	if (!$intG_BUY_CNT) $intG_BUY_CNT = 0;
	if (!$intG_PRODUCT_CNT) $intG_PRODUCT_CNT = 0;
	if (!$intG_DISCOUNT_PRICE) $intG_DISCOUNT_PRICE = 0;
	if (!$intG_DISCOUNT_RATE) $intG_DISCOUNT_RATE = 0;
	if (!$intG_POINT_PRICE) $intG_POINT_PRICE = 0;
	if (!$intG_POINT_RATE) $intG_POINT_RATE = 0;
	if (!$intG_ADD_DISCOUNT_PRICE) $intG_ADD_DISCOUNT_PRICE = 0;
	if (!$intG_ADD_DISCOUNT_RATE) $intG_ADD_DISCOUNT_RATE = 0;

	$memberMgr->setG_CODE($strG_CODE);
	$memberMgr->setG_NAME($strG_NAME);
	$memberMgr->setG_SHOW($strG_SHOW);
	$memberMgr->setG_APPLY($strG_APPLY);
	$memberMgr->setG_SETTLE($strG_SETTLE);
	$memberMgr->setG_PRICE_ST($strG_PRICE_ST);
	$memberMgr->setG_LEVEL($intG_LEVEL);
	$memberMgr->setG_PRICE_MIN($intG_PRICE_MIN);
	$memberMgr->setG_PRICE_MAX($intG_PRICE_MAX);
	$memberMgr->setG_BUY_CNT($intG_BUY_CNT);
	$memberMgr->setG_PRODUCT_CNT($intG_PRODUCT_CNT);
	$memberMgr->setG_DISCOUNT_ST($strG_DISCOUNT_ST);
	$memberMgr->setG_DISCOUNT_PRICE($intG_DISCOUNT_PRICE);
	$memberMgr->setG_DISCOUNT_RATE($intG_DISCOUNT_RATE);
	$memberMgr->setG_DISCOUNT_UNIT($strG_DISCOUNT_UNIT);
	$memberMgr->setG_DISCOUNT_OFF($strG_DISCOUNT_OFF);
	$memberMgr->setG_DISCOUNT_POINT($strG_DISCOUNT_POINT);
	$memberMgr->setG_POINT_PRICE($intG_POINT_PRICE);
	$memberMgr->setG_POINT_RATE($intG_POINT_RATE);
	$memberMgr->setG_POINT_UNIT($strG_POINT_UNIT);
	$memberMgr->setG_POINT_OFF($strG_POINT_OFF);
	$memberMgr->setG_POINT_POINT($strG_POINT_POINT);
	$memberMgr->setG_ADD_DISCOUNT($strG_ADD_DISCOUNT);
	$memberMgr->setG_ADD_DISCOUNT_PRICE($intG_ADD_DISCOUNT_PRICE);
	$memberMgr->setG_ADD_DISCOUNT_RATE($intG_ADD_DISCOUNT_RATE);
	$memberMgr->setG_ADD_DISCOUNT_UNIT($strG_ADD_DISCOUNT_UNIT);
	$memberMgr->setG_ADD_DISCOUNT_OFF($strG_ADD_DISCOUNT_OFF);
	$memberMgr->setG_ADD_DISCOUNT_POINT($strG_ADD_DISCOUNT_POINT);
	$memberMgr->setG_MEMO($strG_MEMO);
	$memberMgr->setG_EXP_CATEGORY($strG_EXP_CATEGORY);
	$memberMgr->setG_EXP_PRODUCT($strG_EXP_PRODUCT);
	$memberMgr->setG_REG_NO($a_admin_no);
	$memberMgr->setG_MOD_NO($a_admin_no);

	$strGroupImgPath = "upload/icon/memberGroup";
			
	switch ($strAct) {
		case "groupAdd":
			
			## 모듈 설정
			$objMemberGroupMgrModule = new MemberGroupMgrModule($db); 

			$strG_CODE = $memberMgr->getGroupCode($db);
			$memberMgr->setG_CODE($strG_CODE);
				
			for($i = 1; $i <= 3; $i++){
				$strInputFileName = "iconImg".$i;
				
				if ($_FILES[$strInputFileName][name]){
					if (!getAllowImgFileExt($_FILES[$strInputFileName][name])){
						goErrMsg($LNG_TRANS_CHAR["CS00009"]); //첨부하신 파일은 확장자가 금지된 파일입니다.
						exit;
					}
					
					$strFileName	= $_FILES[$strInputFileName][name];
					$strFileTmpName = $_FILES[$strInputFileName][tmp_name];
					$intFileSize	= $_FILES[$strInputFileName][size];
					$strFileType	= $_FILES[$strInputFileName][type];
					
					$fres = $fh->doUpload($strG_CODE."_".$i,"../".$strGroupImgPath,$strFileName,$strFileTmpName,$intFileSize,$strFileType);
				
					if($fres) {
						if ($i == "1") {
							$memberMgr->setG_ICON($fres[file_real_name]);
						} else if ($i == "2"){
							$memberMgr->setG_IMG($fres[file_real_name]);
						} else if ($i == "3"){
							$memberMgr->setG_FILE($fres[file_real_name]);
						}
					} else {
						if ($i == "1") {
							$memberMgr->setG_ICON("");
						} else if ($i == "2"){
							$memberMgr->setG_IMG("");
						} else if ($i == "3"){
							$memberMgr->setG_FILE("");
						}
					}
				}
			}
			$memberMgr->getGroupInsert($db);
			
			## 최소구매금액 설정
			$param = '';
			$param['G_CODE'] = $strG_CODE;
			$param['G_MIN_BUY_PRICE'] = $intMinBuyPrice;
			$objMemberGroupMgrModule->getMemberGroupMgrMinBuyPriceUpdateEx($param);

			/* 파일 생성 */
			include MALL_HOME."/web/shopAdmin/basic/shopMakeFile.php";
			/* 파일 생성 */
			
			$strUrl = "./?menuType=".$strMenuType."&mode=group&".$strLinkPage;
		break;

		case "groupModify":

			## 모듈 설정
			$objMemberGroupMgrModule = new MemberGroupMgrModule($db); 

			## 기본설정
			$intMinBuyPrice = $_POST['min_buy_price'];


			$memberMgr->setG_CODE($strG_CODE);
			$row = $memberMgr->getGroupView($db);
			
			$memberMgr->setG_LEVEL($row[G_LEVEL]);

			for($i = 1; $i <= 3; $i++){
				$strInputFileName = "iconImg".$i;
				
				if ($_FILES[$strInputFileName][name]){
					if (!getAllowImgFileExt($_FILES[$strInputFileName][name])){
						goErrMsg($LNG_TRANS_CHAR["CS00009"]); //첨부하신 파일은 확장자가 금지된 파일입니다.
						exit;
					}
					
					$strFileName	= $_FILES[$strInputFileName][name];
					$strFileTmpName = $_FILES[$strInputFileName][tmp_name];
					$intFileSize	= $_FILES[$strInputFileName][size];
					$strFileType	= $_FILES[$strInputFileName][type];
					
					$fres = $fh->doUpload($strG_CODE."_".$i,"../".$strGroupImgPath,$strFileName,$strFileTmpName,$intFileSize,$strFileType);
				
					if($fres) {
						if ($i == "1") {
							$memberMgr->setG_ICON($fres[file_real_name]);
							$strCol = "G_ICON";
						} else if ($i == "2"){
							$memberMgr->setG_IMG($fres[file_real_name]);
							$strCol = "G_IMG";
						} else if ($i == "3"){
							$memberMgr->setG_FILE($fres[file_real_name]);
							$strCol = "G_FILE";
						}

						if ($row[$strCol]){
							$fh->fileDelete("../".$strGroupImgPath."/".$row[$strCol]);
						}
					} else {
						if ($i == "1") {
							$memberMgr->setG_ICON("");
						} else if ($i == "2"){
							$memberMgr->setG_IMG("");
						} else if ($i == "3"){
							$memberMgr->setG_FILE("");
						}
					}
				}
			}
			$memberMgr->getGroupUpdate($db);

			## 최소구매금액 설정
			$param = '';
			$param['G_CODE'] = $strG_CODE;
			$param['G_MIN_BUY_PRICE'] = $intMinBuyPrice;
			$objMemberGroupMgrModule->getMemberGroupMgrMinBuyPriceUpdateEx($param);
			
			/* 파일 생성 */
			include MALL_HOME."/web/shopAdmin/basic/shopMakeFile.php";
			/* 파일 생성 */
			
			$strUrl = "./?menuType=".$strMenuType."&mode=group&groupCode=".$strG_CODE;
		break;

		case "groupView":
		case "groupWrite":

			$btnGroupRegText = $LNG_TRANS_CHAR["CW00002"];
			$btnGroupJsMode  = "groupAdd";
			if ($strG_CODE){
				$memberMgr->setG_CODE($strG_CODE);
				$row = $memberMgr->getGroupView($db);
				$btnGroupRegText = $LNG_TRANS_CHAR["CW00003"];
				$btnGroupJsMode  = "groupModify";
			}
			/* 등급 노출 여부*/
			$strGroupShopT = ($row[G_SHOW] == "T") ? "checked" : "";
			$strGroupShopI = (!$row[G_SHOW] || $row[G_SHOW] == "I") ? "checked" : "";
			
			/* 등급적용방법 */
			$strGroupApplyA = ($row[G_APPLY] == "A") ? "checked" : "";
			$strGroupApplyS = (!$row[G_APPLY] || $row[G_APPLY] == "S") ? "checked" : "";

			/* 등급기준 */
			$strGroupPriceP = ($row[G_PRICE_ST] == "P") ? "checked" : "";
			$strGroupPriceS = (!$row[G_PRICE_ST] || $row[G_PRICE_ST] == "S") ? "checked" : "";

			/* 등급혜택 */
			$strGroupDiscountSt1 = (!$row[G_DISCOUNT_ST] || $row[G_DISCOUNT_ST] == "1") ? "checked" : "";
			$strGroupDiscountSt2 = ($row[G_DISCOUNT_ST] == "2") ? "checked" : "";
			$strGroupDiscountSt3 = ($row[G_DISCOUNT_ST] == "3") ? "checked" : "";
			$strGroupDiscountSt4 = ($row[G_DISCOUNT_ST] == "4") ? "checked" : "";
			
			$strDivDiscountPrice = $strDivDiscountPoint = "display:none";
			if ($row[G_DISCOUNT_ST] == "2" || $row[G_DISCOUNT_ST] == "4") $strDivDiscountPrice = "";
			if ($row[G_DISCOUNT_ST] == "3" || $row[G_DISCOUNT_ST] == "4") $strDivDiscountPoint = "";
			
			$strGroupDiscountUnit1 = ($row[G_DISCOUNT_UNIT] == "1") ? "selected":"";
			$strGroupDiscountUnit2 = ($row[G_DISCOUNT_UNIT] == "2") ? "selected":"";

			$strGroupDiscountPoint1 = ($row[G_DISCOUNT_POINT] == "1") ? "selected":"";
			$strGroupDiscountPoint2 = ($row[G_DISCOUNT_POINT] == "2") ? "selected":"";

			$strGroupDiscountOff1 = ($row[G_DISCOUNT_OFF] == "1") ? "selected":"";
			$strGroupDiscountOff2 = ($row[G_DISCOUNT_OFF] == "2") ? "selected":"";

			$strGroupPointUnit1 = ($row[G_POINT_UNIT] == "1") ? "selected":"";
			$strGroupPointUnit2 = ($row[G_POINT_UNIT] == "2") ? "selected":"";

			$strGroupPointPoint1 = ($row[G_POINT_POINT] == "1") ? "selected":"";
			$strGroupPointPoint2 = ($row[G_POINT_POINT] == "2") ? "selected":"";

			$strGroupPointOff1 = ($row[G_POINT_OFF] == "1") ? "selected":"";
			$strGroupPointOff2 = ($row[G_POINT_OFF] == "2") ? "selected":"";

			$strGroupAddDiscountN = (!$row[G_ADD_DISCOUNT] || $row[G_ADD_DISCOUNT] == "N") ? "checked":"";
			$strGroupAddDiscountY = ($row[G_ADD_DISCOUNT] == "Y") ? "checked":"";

			$strGroupAddDiscountPoint1 = ($row[G_ADD_DISCOUNT_POINT] == "1") ? "selected":"";
			$strGroupAddDiscountPoint2 = ($row[G_ADD_DISCOUNT_POINT] == "2") ? "selected":"";

			$strGroupAddDiscountOff1 = ($row[G_ADD_DISCOUNT_OFF] == "1") ? "selected":"";
			$strGroupAddDiscountOff2 = ($row[G_ADD_DISCOUNT_OFF] == "2") ? "selected":"";

			$strDivAddDiscountPrice = "display:none";
			if ($row[G_ADD_DISCOUNT] == "Y") $strDivAddDiscountPrice = "";

			$strGroupAddDiscountUnit1 = ($row[G_ADD_DISCOUNT_UNIT] == "1") ? "selected":"";
			$strGroupAddDiscountUnit2 = ($row[G_ADD_DISCOUNT_UNIT] == "2") ? "selected":"";
			
			$aryGroupSettle  = explode("/",$row[G_SETTLE]);
			$strGroupSettleB = in_array("B", $aryGroupSettle)?"checked":"";
			$strGroupSettleC = in_array("C", $aryGroupSettle)?"checked":"";
			$strGroupSettleA = in_array("A", $aryGroupSettle)?"checked":"";
			$strGroupSettleT = in_array("T", $aryGroupSettle)?"checked":"";
			$strGroupSettleM = in_array("M", $aryGroupSettle)?"checked":"";

			$aryGroupExpCategory  = explode("/",$row[G_EXP_CATEGORY]);
			$aryGroupExpProduct  = explode("/",$row[G_EXP_PRODUCT]);
		
			if (is_array($aryGroupExpCategory)){
				for($i=0;$i<sizeof($aryGroupExpCategory);$i++){
					
					if ($aryGroupExpCategory[$i]){
						$cateMgr->setCL_LNG($strAdmSiteLng);
						$cateMgr->setC_CODE($aryGroupExpCategory[$i]);
						$cateRow = $cateMgr->getView($db);
						$strGroupExpCategoryHtml .= "<li>";
						$strGroupExpCategoryHtml .= "<input type=\"hidden\" name=\"categoryExpCode[]\" id=\"categoryExpCode[]\" value=\"".$aryGroupExpCategory[$i]."\">";
						$strGroupExpCategoryHtml .= $cateRow[CL_NAME]."<a class=\"btn_sml\" onClick=\"goGroupExpCategoryDelete(this);\"><strong>삭제</strong></a></li>";
					}
				}
			}
			
			if (is_array($aryGroupExpProduct)){
				for($i=0;$i<sizeof($aryGroupExpProduct);$i++){
					if ($aryGroupExpProduct[$i]){
						$productMgr->setP_LNG($S_SITE_LNG);
						$productMgr->setP_CODE($aryGroupExpProduct[$i]);
						$productRow = $productMgr->getProdView($db);
						$strGroupExpProductHtml .= "<li>";
						$strGroupExpProductHtml .= "<input type=\"hidden\" name=\"productExpCode[]\" id=\"productExpCode[]\" value=\"".$aryGroupExpProduct[$i]."\">";
						$strGroupExpProductHtml .= "<img src=\"..".$productRow[PROD_LIST_IMG]."\" style=\"width:50px;height:50px;\">".$productRow[P_NAME];
						$strGroupExpProductHtml .= "</li>";
					}
				}
			}
			
			/* 현재 쇼핑몰에서 사용하고 있는 결제방법 */
			$arySettle = explode("/",$S_SETTLE);
			if (is_array($arySettle)){
				for($i=0;$i<sizeof($arySettle);$i++){
					if ($arySettle[$i] == "B") $strSettleB = "Y";
					if ($arySettle[$i] == "C") $strSettleC = "Y";
					if ($arySettle[$i] == "A") $strSettleA = "Y";
					if ($arySettle[$i] == "T") $strSettleT = "Y";
					if ($arySettle[$i] == "M") $strSettleM = "Y";
				}
			}

			## 최소구매금액 설정
			$intMinBuyPrice = $row['G_MIN_BUY_PRICE'];
//			$intMinBuyPrice = number_format($intMinBuyPrice);

			/*
				$LNG_TRANS_CHAR["MW00033"] : 등급표시
				$LNG_TRANS_CHAR["MW00036"] : 이상
				$LNG_TRANS_CHAR["MW00037"] : 미만
				$LNG_TRANS_CHAR["MW00029"] : 구매횟수
				$LNG_TRANS_CHAR["MW00030"] : 상품후기 횟수
				$LNG_TRANS_CHAR["MW00031"] : 할인율
				$LNG_TRANS_CHAR["CW00034"] : 포인트
				$LNG_TRANS_CHAR["MW00031"] : 할인율
				$LNG_TRANS_CHAR["MW00031"] : 할인율

				$LNG_TRANS_CHAR["MS00003"] : 입력하신 금액 이상일때 할인 혜택 제공
				$LNG_TRANS_CHAR["MS00004"] : 입력하신 금액 이상일때 추가 적립 제공

			*/
			$strHtml = "
			<div class=\"tableForm\">
				<table>
					<tr>
						<th>등급명</th>
						<td>
							<input type=\"text\" $nBox  style=\"width:300px;\" id=\"name\" name=\"name\" value=\"".$row[G_NAME]."\"/>
						</td>
					</tr>
					<tr>
						<th>등급설명</th>
						<td>
							<input type=\"text\" $nBox  style=\"width:300px;\" id=\"memo\" name=\"memo\" value=\"".$row[G_MEMO]."\"/>
						</td>
					</tr>
					<tr>
						<th>".$LNG_TRANS_CHAR["MW00033"]."</th>
						<td>
							<input type=\"radio\" id=\"show\" name=\"show\" value=\"T\" ".$strGroupShopT.">노출함
							<input type=\"radio\" id=\"show\" name=\"show\" value=\"I\" ".$strGroupShopI.">노출안함
							<div class=\"helpTxtGray\">
								* 추가할인이 있는경우 \"VIP회원(10%할인적용)\"형식으로 보여집니다.
							</div>
						</td>
					</tr>
					<tr>
						<th>적용방법</th>
						<td>
							<input type=\"radio\" id=\"apply\" name=\"apply\" value=\"A\" ".$strGroupApplyA.">자동적용
							<input type=\"radio\" id=\"apply\" name=\"apply\" value=\"S\" ".$strGroupApplyS.">수동적용
							<div class=\"helpTxtGray\">
								* [자동적용] : 기준에 자동 적용됩니다.<br>
								* [수동적용] : 관리자의 등급 변경을 통해 적용됩니다.
							</div>
						</td>
					</tr>
					<tr>
						<th>결제방법</th>
						<td>";
							if ($strSettleB == "Y"){
								$strHtml .= "<input type=\"checkbox\" id=\"settle[]\" name=\"settle[]\" value=\"B\" ".$strGroupSettleB.">무통장입금";
							}
							if ($strSettleC == "Y"){
								$strHtml .= "<input type=\"checkbox\" id=\"settle[]\" name=\"settle[]\" value=\"C\" ".$strGroupSettleC.">카드";
							}
							if ($strSettleA == "Y"){
								$strHtml .= "<input type=\"checkbox\" id=\"settle[]\" name=\"settle[]\" value=\"A\" ".$strGroupSettleA.">계좌이체";
							}
							if ($strSettleT == "Y"){
								$strHtml .= "<input type=\"checkbox\" id=\"settle[]\" name=\"settle[]\" value=\"T\" ".$strGroupSettleT.">가상계좌";
							}
							if ($strSettleM == "Y"){
								$strHtml .= "<input type=\"checkbox\" id=\"settle[]\" name=\"settle[]\" value=\"M\" ".$strGroupSettleT.">휴대폰";
							}
							$strHtml .= "
							<div class=\"helpTxtGray\">
								* 결제방법은 해외는 적용되지 않습니다.
							</div>
						</td>
					</tr>
					<tr>
						<th>최소구매금액</th>
						<td><input type=\"text\" name=\"min_buy_price\" value=\"{$intMinBuyPrice}\"> 원 이상</td>
					</tr>
					<tr>
						<th>등급기준</th>
						<td>
							<input type=\"radio\" id=\"price_st\" name=\"price_st\" value=\"P\" ".$strGroupPriceP.">주문금액
							<input type=\"radio\" id=\"price_st\" name=\"price_st\" value=\"S\" ".$strGroupPriceS.">결제금액
							<div class=\"helpTxtGray\">
								* 주문금액 : 각종할인(쿠폰/적립금/할인금액등) 금액을 제외하지 않고 주문이 발생한 총 누적금액<br>
								* 결제금액 : 각종할인(쿠폰/적립금/할인금액등) 금액을 제외한 실제 고객이 결제한 총 금액<br>
								* 실제 고객이 결제한 총 금액 기준을 추천합니다.
							</div>
						</td>
					</tr>
					<tr>
						<th>등급조건</th>
						<td>
							구매금액 : <input type=\"text\" $nBox  style=\"width:100px;\" id=\"price_min\" name=\"price_min\" value=\"".getPriceToCur($row[G_PRICE_MIN])."\"/> ".$LNG_TRANS_CHAR["MW00036"]." ~ <input type=\"text\" $nBox  style=\"width:100px;\" id=\"price_max\" name=\"price_max\" value=\"".getPriceToCur($row[G_PRICE_MAX])."\"/>".$LNG_TRANS_CHAR["MW00037"]." <br>".
							$LNG_TRANS_CHAR["MW00029"]." : <input type=\"text\" $nBox  style=\"width:100px;\" id=\"buy_cnt\" name=\"buy_cnt\" value=\"".$row[G_BUY_CNT]."\"/> ".$LNG_TRANS_CHAR["MW00036"]."  <br>".
							$LNG_TRANS_CHAR["MW00030"]." : <input type=\"text\" $nBox  style=\"width:72px;\" id=\"product_cnt\" name=\"product_cnt\" value=\"".$row[G_PRODUCT_CNT]."\"/> ".$LNG_TRANS_CHAR["MW00036"]." 
						</td>
					</tr>
					<tr>
						<th>등급혜택</th>
						<td>
							<input type=\"radio\" id=\"discount_st\" name=\"discount_st\" value=\"1\" ".$strGroupDiscountSt1." onclick=\"javascript:goGroupDistcountSt();\">추가적립금 없음
							<!--input type=\"radio\" id=\"discount_st\" name=\"discount_st\" value=\"2\" ".$strGroupDiscountSt2." onclick=\"javascript:goGroupDistcountSt();\">추가할인//-->
							<input type=\"radio\" id=\"discount_st\" name=\"discount_st\" value=\"3\" ".$strGroupDiscountSt3." onclick=\"javascript:goGroupDistcountSt();\">추가적립금 지급
							<!--input type=\"radio\" id=\"discount_st\" name=\"discount_st\" value=\"4\" ".$strGroupDiscountSt4." onclick=\"javascript:goGroupDistcountSt();\">추가할인/추가적립 동시적용//-->
							
							<div id=\"divDiscountPrice\" style=\"".$strDivDiscountPrice."\">
							<br>
							".$S_ST_CUR." <input type=\"text\" $nBox  style=\"width:100px;\" id=\"discount_price\" name=\"discount_price\" value=\"".getPriceToCur($row[G_DISCOUNT_PRICE])."\"/>  / ".$LNG_TRANS_CHAR["MW00031"]." <input type=\"text\" $nBox  style=\"width:50px;\" id=\"discount_rate\" name=\"discount_rate\" value=\"".$row[G_DISCOUNT_RATE]."\"/>
							<select name=\"discount_unit\" id=\"discount_unit\">
								<option value=\"1\" ".$strGroupDiscountUnit1.">%</option>
								<option value=\"2\" ".$strGroupDiscountUnit2.">".$S_ST_CUR."</option> 
							</select>
							<select name=\"discount_point\" id=\"discount_point\">
								<option value=\"1\" ".$strGroupDiscountPoint1.">1자리</option>
								<option value=\"2\" ".$strGroupDiscountPoint2.">2자리</option> 
							</select>
							<select name=\"discount_off\" id=\"discount_ff\">
								<option value=\"1\" ".$strGroupDiscountOff1.">절삭</option>
								<option value=\"2\" ".$strGroupDiscountOff2.">반올림</option> 
							</select>
							(".$LNG_TRANS_CHAR["MS00003"].")
							</div>
							<div id=\"divDiscountPoint\" style=\"".$strDivDiscountPoint."\">
							<br>
							".$S_ST_CUR." <input type=\"text\" $nBox  style=\"width:100px;\" id=\"point_price\" name=\"point_price\" value=\"".getPriceToCur($row[G_POINT_PRICE])."\"/> / ".$LNG_TRANS_CHAR["CW00034"]." <input type=\"text\" $nBox  style=\"width:50px;\" id=\"point_rate\" name=\"point_rate\" value=\"".$row[G_POINT_RATE]."\"/>
							<select name=\"point_unit\" id=\"point_unit\">
								<option value=\"1\" ".$strGroupPointUnit1.">%</option>
								<option value=\"2\" ".$strGroupPointUnit2.">".$S_ST_CUR."</option> 
							</select>
							<select name=\"point_point\" id=\"point_point\">
								<option value=\"\">0자리</option>
								<option value=\"1\" ".$strGroupPointPoint1.">1자리</option>
								<option value=\"2\" ".$strGroupPointPoint2.">2자리</option> 
							</select>
							<select name=\"point_off\" id=\"point_off\">
								<option value=\"1\" ".$strGroupPointOff1.">절삭</option>
								<option value=\"2\" ".$strGroupPointOff2.">반올림</option> 
							</select>
							(".$LNG_TRANS_CHAR["MS00004"].")
							</div>
						</td>
					</tr>
					<tr>
						<th>추가혜택</th>
						<td>
							<input type=\"radio\" id=\"add_discount\" name=\"add_discount\" value=\"N\" ".$strGroupAddDiscountN." onclick=\"javascript:goGroupAddDistcount();\">가격할인 없음
							<input type=\"radio\" id=\"add_discount\" name=\"add_discount\" value=\"Y\" ".$strGroupAddDiscountY." onclick=\"javascript:goGroupAddDistcount();\">가격할인
							<div id=\"divAddDiscountPrice\" style=\"".$strDivAddDiscountPrice."\">
							<br>
							".$S_ST_CUR." <input type=\"text\" $nBox  style=\"width:100px;\" id=\"add_discount_price\" name=\"add_discount_price\" value=\"".getPriceToCur($row[G_ADD_DISCOUNT_PRICE])."\"/>  / ".$LNG_TRANS_CHAR["MW00031"]." <input type=\"text\" $nBox  style=\"width:50px;\" id=\"add_discount_rate\" name=\"add_discount_rate\" value=\"".$row[G_ADD_DISCOUNT_RATE]."\"/>
							<select name=\"add_discount_unit\" id=\"add_discount_unit\">
								<option value=\"1\" ".$strGroupAddDiscountUnit1.">%</option>
								<option value=\"2\" ".$strGroupAddDiscountUnit2.">".$S_ST_CUR."</option> 
							</select>
							<select name=\"add_discount_off\" id=\"add_discount_off\">
								<option value=\"1\" ".$strGroupAddDiscountPoint1.">1자리</option>
								<option value=\"2\" ".$strGroupAddDiscountPoint2.">2자리</option> 
							</select>
							<select name=\"add_discount_off\" id=\"add_discount_ff\">
								<option value=\"1\" ".$strGroupAddDiscountOff1.">절사</option>
								<option value=\"2\" ".$strGroupAddDiscountOff2.">반올림</option> 
							</select>
							(".$LNG_TRANS_CHAR["MS00003"].")
							</div>
							<div class=\"helpTxtGray\">
								* 상품리스트에 할인된 가격으로 보여집니다.
							</div>
						</td>
					</tr>
					<tr>
						<th>할인예외카테고리</th>
						<td>
							<select id=\"cateHCode1\" name=\"cateHCode1\">
								<option value=\"\">".$LNG_TRANS_CHAR["PW00013"]."</option>
							</select>
							<select id=\"cateHCode2\" name=\"cateHCode2\" >
								<option value=\"\">".$LNG_TRANS_CHAR["PW00014"]."</option>
							</select>
							<select id=\"cateHCode3\" name=\"cateHCode3\" >
								<option value=\"\">".$LNG_TRANS_CHAR["PW00015"]."</option>
							</select>
							<!--select id=\"cateHCode4\" name=\"cateHCode4\">
								<option value=\"\">".$LNG_TRANS_CHAR["PW00016"]."</option>
							</select-->
							<a class=\"btn_sml\" href=\"javascript:goGroupExpCateogryInsert();\"><strong>적용</strong></a>
							<br>
							<ul id=\"ulExpCate\">".$strGroupExpCategoryHtml."
							</ul>
						</td>
					</tr>
					<tr>
						<th>할인예외상품</th>
						<td>
							<a class=\"btn_sml\" href=\"javascript:goGroupExpProductSearch();\"><strong>상품검색</strong></a>
							<ul id=\"ulExpProd\">".$strGroupExpProductHtml."
							</ul>
						</td>
					</tr>
					<tr>
						<th>등급아이콘</th>
						<td>
							<input type=\"file\" style=\"width:300px;\" id=\"iconImg1\" name=\"iconImg1\"/>";

					if ($row[G_ICON]){
					$strHtml .= "<img src=\"../upload/icon/memberGroup/".$row[G_ICON]."\" border=\"0\">
							<a href=\"javascript:goGroupIconDel(1);\">[x]</a>";
					}
					$strHtml .= "
						</td>
					</tr>
						
					<tr>
						<th>등급이미지</th>
						<td>
							<input type=\"file\" style=\"width:300px;\" id=\"iconImg2\" name=\"iconImg2\"/>";
					if ($row[G_IMG]){
					$strHtml .= "<img src=\"../upload/icon/memberGroup/".$row[G_IMG]."\" border=\"0\">
							<a href=\"javascript:goGroupIconDel(2);\">[x]</a>";
					}
					$strHtml .= "
						</td>
					</tr>
					<tr>
						<th>할인혜택</th>
						<td>
							<input type=\"file\" style=\"width:300px;\" id=\"iconImg3\" name=\"iconImg3\"/>";
					if ($row[G_FILE]){
					$strHtml .= "<img src=\"../upload/icon/memberGroup/".$row[G_FILE]."\" border=\"0\">
							<a href=\"javascript:goGroupIconDel(3);\">[x]</a>";
					}
					$strHtml .= "
						</td>
					</tr>
				</table>
			</div>

			<div class=\"buttonWrap\">
				<a class=\"btn_big\" href=\"javascript:goGroupAct('".$btnGroupJsMode."');\" id=\"menu_auth_m\"><strong>".$btnGroupRegText."</strong></a>
				<a class=\"btn_big\" href=\"javascript:goGroupCancel();\"><strong>".$LNG_TRANS_CHAR["CW00008"]."</strong></a>
			</div>";
			
			$db->disConnect();
			echo $strHtml;
			exit;

		break;

		case "groupProdSearch":
			
			$productMgr->setP_LNG($strAdmSiteLng);
			$productMgr->setP_CODE($strP_CODE);
			$result = $productMgr->getProdInfoJson($db);
			$result[0][RET] = "Y";
			$result_array = json_encode($result);
			
			$db->disConnect();
			echo $result_array;	
			exit;

		break;

		case "groupIconDel":
		case "groupImgDel":
		case "groupFileDel":

			$row = $memberMgr->getGroupView($db);
			
			if ($strAct == "groupIconDel"){
				if ($row[G_ICON]){
					$fh->fileDelete("../".$strGroupImgPath."/".$row[G_ICON]);
				}

				$memberMgr->getGroupIconUpdate($db);
			}

			if ($strAct == "groupImgDel"){
				if ($row[G_IMG]){
					$fh->fileDelete("../".$strGroupImgPath."/".$row[G_IMG]);
				}

				$memberMgr->getGroupImgUpdate($db);
			}

			if ($strAct == "groupFileDel"){
				if ($row[G_FILE]){
					$fh->fileDelete("../".$strGroupImgPath."/".$row[G_FILE]);
				}

				$memberMgr->getGroupFileUpdate($db);
			}
			
			/* 파일 생성 */
			include MALL_HOME."/web/shopAdmin/basic/shopMakeFile.php";
			/* 파일 생성 */	

			$result_array = array();
			$result[0][MSG]			= $LNG_TRANS_CHAR["CS00018"]; //파일이 삭제되었습니다.
			$result[0][RET]			= "Y";

			$result_array = json_encode($result);
			
			$db->disConnect();
			echo $result_array;
			exit;

		break;

		case "groupDelete":

			//회원테이블에서 삭제할 그룹으로 등록된 회원이 존재하는지 확인 후 삭제
			//나중 확인 쿼리 추가(아직 회원테이블이 생성되어 있지 않음)

			$row = $memberMgr->getGroupView($db);

			if ($row[G_ICON]){
				$fh->fileDelete("../".$strGroupImgPath."/".$row[G_ICON]);
			}

			if ($row[G_IMG]){
				$fh->fileDelete("../".$strGroupImgPath."/".$row[G_IMG]);
			}

			if ($row[G_FILE]){
				$fh->fileDelete("../".$strGroupImgPath."/".$row[G_FILE]);
			}

			$memberMgr->getGroupDelete($db);

			/* 파일 생성 */
			include MALL_HOME."/web/shopAdmin/basic/shopMakeFile.php";
			/* 파일 생성 */	
			
			$strUrl = "./?menuType=".$strMenuType."&mode=group".$strLinkPage;

		break;

	}

?>