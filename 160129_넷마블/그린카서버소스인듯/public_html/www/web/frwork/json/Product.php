<?

//	require_once MALL_CLASS_SMS;												// sms
	require_once MALL_CONF_LIB."CateMgr.php";
	require_once MALL_CONF_LIB."ProductMgr.php";
	require_once MALL_CONF_LIB."OrderMgr.php";
	require_once MALL_CONF_LIB."SmsMgr.php";							// sms 문자
	require_once MALL_CONF_LIB."SiteMgr.php";							// sms 문자 전송후 money 업데이트

	require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/conf/order.inc.php";

	if(is_file("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/shop.manual.inc.php")):
		require_once "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/shop.manual.inc.php";
	endif;

	/*상품함수관련*/
	require_once MALL_PROD_FUNC;

	$cateMgr = new CateMgr();
	$productMgr = new ProductMgr();
	$orderMgr = new OrderMgr();
	$smsMgr			= new SmsMgr();
	$siteMgr		= new SiteMgr();

	$strP_CODE				= $_POST["prodCode"]			? $_POST["prodCode"]			: $_REQUEST["prodCode"];

	$intPO_NO				= $_POST["optNo"]				? $_POST["optNo"]				: $_REQUEST["optNo"];
	$strAttr1				= $_POST["optAttr1"]			? $_POST["optAttr1"]			: $_REQUEST["optAttr1"];
	$strAttr2				= $_POST["optAttr2"]			? $_POST["optAttr2"]			: $_REQUEST["optAttr2"];
	$strAttr3				= $_POST["optAttr3"]			? $_POST["optAttr3"]			: $_REQUEST["optAttr3"];
	$strAttr4				= $_POST["optAttr4"]			? $_POST["optAttr4"]			: $_REQUEST["optAttr4"];
	$strAttr5				= $_POST["optAttr5"]			? $_POST["optAttr5"]			: $_REQUEST["optAttr5"];
	$strAttr6				= $_POST["optAttr6"]			? $_POST["optAttr6"]			: $_REQUEST["optAttr6"];
	$strAttr7				= $_POST["optAttr7"]			? $_POST["optAttr7"]			: $_REQUEST["optAttr7"];
	$strAttr8				= $_POST["optAttr8"]			? $_POST["optAttr8"]			: $_REQUEST["optAttr8"];
	$strAttr9				= $_POST["optAttr9"]			? $_POST["optAttr9"]			: $_REQUEST["optAttr9"];
	$strAttr10				= $_POST["optAttr10"]			? $_POST["optAttr10"]			: $_REQUEST["optAttr10"];
	$intAttrSort			= $_POST["optAttrSort"]			? $_POST["optAttrSort"]			: $_REQUEST["optAttrSort"];

	$strHP					= $_POST["hp"]					? $_POST["hp"]					: $_REQUEST["hp"];						// 휴대폰 번호

	$strCartDelivery		= $_POST["cartDelivery"]		? $_POST["cartDelivery"]		: $_REQUEST["cartDelivery"];
	$strCartDeliveryExp		= $_POST["cartDeliveryExp"]		? $_POST["cartDeliveryExp"]		: $_REQUEST["cartDeliveryExp"];
	if (!$strCartDelivery) $strCartDelivery = "1";
	$result_array = array();

	$productMgr->setP_LNG($S_SITE_LNG);

	switch ($strAct){
		case "productRelatedList":
			// 2014.04.16 kim hee sung
			// 관리자 페이지용으로 제작되었습니다.


		break;

		case "productListLoad":
			// 2014.01.23 kim hee sung
			// app - productAuto 에서 사용

			## 모듈 설정
			$objProductMgr				= new ProductMgrModule($db);


			## 상품 정보 불러오기
			$aryParam							= "";
			$aryParam['LIMIT_END']				= 10;
			$aryParam['LNG']					= $S_SITE_LNG;
			$aryParam['PRODUCT_IMG_JOIN']		= "Y";
			$resProductList						= $objProductMgr->getProductMgrSelectEx("OP_LIST", $aryParam);

			## 데이터 만들기
			$aryData							= "";
			if($resProductList):
				while($row = mysql_fetch_array($resProductList)):
					$aryData[]					= $row;
				endwhile;
			endif;

			$result['__STATE__']				= "SUCCESS";
			$result['DATA']						= $aryData;

		break;

		case "cateLevelList":
			// 2012.09.11
			// http://dalin-car.co.kr/?menuType=product&mode=list (국산차 찾기 리스트 페이지) 에서 모델검색 부분에 카테고리 부분

			$cateMgr->setC_LEVEL($intC_LEVEL);
			$cateMgr->setC_HCODE($strC_HCODE);
			$cateMgr->setC_VIEW_YN($strC_VIEW_YN);
			$array = $cateMgr->getCateLevelAry($db);
			$result_array = json_encode($array);

		break;
		case "prodOpt":

			$productMgr->setPO_TYPE("O");
			$productMgr->setP_CODE($strP_CODE);
			$aryProdOpt = $productMgr->getProdOpt($db);


			if (is_array($aryProdOpt)){

				for($i=0;$i<sizeof($aryProdOpt);$i++){

					$result[$aryProdOpt[$i][PO_NO]][PO_NAME1]					= $aryProdOpt[$i][PO_NAME1];
					$result[$aryProdOpt[$i][PO_NO]][PO_NAME2]					= $aryProdOpt[$i][PO_NAME2];
					$result[$aryProdOpt[$i][PO_NO]][PO_NAME3]					= $aryProdOpt[$i][PO_NAME3];
					$result[$aryProdOpt[$i][PO_NO]][PO_NAME4]					= $aryProdOpt[$i][PO_NAME4];
					$result[$aryProdOpt[$i][PO_NO]][PO_NAME5]					= $aryProdOpt[$i][PO_NAME5];
					$result[$aryProdOpt[$i][PO_NO]][PO_NAME6]					= $aryProdOpt[$i][PO_NAME6];
					$result[$aryProdOpt[$i][PO_NO]][PO_NAME7]					= $aryProdOpt[$i][PO_NAME7];
					$result[$aryProdOpt[$i][PO_NO]][PO_NAME8]					= $aryProdOpt[$i][PO_NAME8];
					$result[$aryProdOpt[$i][PO_NO]][PO_NAME9]					= $aryProdOpt[$i][PO_NAME9];
					$result[$aryProdOpt[$i][PO_NO]][PO_NAME10]					= $aryProdOpt[$i][PO_NAME10];
					$result[$aryProdOpt[$i][PO_NO]][PO_ESS]						= $aryProdOpt[$i][PO_ESS];
				}
			}

			$result_array = json_encode($result);

		break;

		case "prodOptAttr":

			$productMgr->setP_CODE($strP_CODE);
			$prodRow = $productMgr->getProdView($db);

			$aryProdOptAttr = $productMgr->getProdOptAttr($db);

			if (is_array($aryProdOptAttr)){

				for($i=0;$i<sizeof($aryProdOptAttr);$i++){

					$result[$aryProdOptAttr[$i][POA_NO]][PO_NO]					= $aryProdOptAttr[$i][PO_NO];
					$result[$aryProdOptAttr[$i][POA_NO]][POA_ATTR1]				= $aryProdOptAttr[$i][POA_ATTR1];
					$result[$aryProdOptAttr[$i][POA_NO]][POA_ATTR2]				= $aryProdOptAttr[$i][POA_ATTR2];
					$result[$aryProdOptAttr[$i][POA_NO]][POA_ATTR3]				= $aryProdOptAttr[$i][POA_ATTR3];
					$result[$aryProdOptAttr[$i][POA_NO]][POA_ATTR4]				= $aryProdOptAttr[$i][POA_ATTR4];
					$result[$aryProdOptAttr[$i][POA_NO]][POA_ATTR5]				= $aryProdOptAttr[$i][POA_ATTR5];
					$result[$aryProdOptAttr[$i][POA_NO]][POA_ATTR6]				= $aryProdOptAttr[$i][POA_ATTR6];
					$result[$aryProdOptAttr[$i][POA_NO]][POA_ATTR7]				= $aryProdOptAttr[$i][POA_ATTR7];
					$result[$aryProdOptAttr[$i][POA_NO]][POA_ATTR8]				= $aryProdOptAttr[$i][POA_ATTR8];
					$result[$aryProdOptAttr[$i][POA_NO]][POA_ATTR9]				= $aryProdOptAttr[$i][POA_ATTR9];
					$result[$aryProdOptAttr[$i][POA_NO]][POA_ATTR10]			= $aryProdOptAttr[$i][POA_ATTR10];
					$result[$aryProdOptAttr[$i][POA_NO]][POA_CONSUMER_PRICE]	= $aryProdOptAttr[$i][POA_CONSUMER_PRICE];
					$result[$aryProdOptAttr[$i][POA_NO]][POA_STOCK_PRICE]		= $aryProdOptAttr[$i][POA_STOCK_PRICE];
					$result[$aryProdOptAttr[$i][POA_NO]][POA_POINT]				= $aryProdOptAttr[$i][POA_POINT];
					$result[$aryProdOptAttr[$i][POA_NO]][POA_STOCK_QTY]			= $aryProdOptAttr[$i][POA_STOCK_QTY];

					$result[$aryProdOptAttr[$i][POA_NO]][PO_NAME1]				= $aryProdOptAttr[$i][PO_NAME1];
					$result[$aryProdOptAttr[$i][POA_NO]][PO_NAME2]				= $aryProdOptAttr[$i][PO_NAME2];
					$result[$aryProdOptAttr[$i][POA_NO]][PO_NAME3]				= $aryProdOptAttr[$i][PO_NAME3];
					$result[$aryProdOptAttr[$i][POA_NO]][PO_NAME4]				= $aryProdOptAttr[$i][PO_NAME4];
					$result[$aryProdOptAttr[$i][POA_NO]][PO_NAME5]				= $aryProdOptAttr[$i][PO_NAME5];
					$result[$aryProdOptAttr[$i][POA_NO]][PO_NAME6]				= $aryProdOptAttr[$i][PO_NAME6];
					$result[$aryProdOptAttr[$i][POA_NO]][PO_NAME7]				= $aryProdOptAttr[$i][PO_NAME7];
					$result[$aryProdOptAttr[$i][POA_NO]][PO_NAME8]				= $aryProdOptAttr[$i][PO_NAME8];
					$result[$aryProdOptAttr[$i][POA_NO]][PO_NAME9]				= $aryProdOptAttr[$i][PO_NAME9];
					$result[$aryProdOptAttr[$i][POA_NO]][PO_NAME10]				= $aryProdOptAttr[$i][PO_NAME10];


					$result[$aryProdOptAttr[$i][POA_NO]][POA_SALE_PRICE]		= getProdDiscountPrice($prodRow,"1",$aryProdOptAttr[$i][POA_SALE_PRICE]);
					$result[$aryProdOptAttr[$i][POA_NO]]['POA_SALE_PRICE_USD']	= getProdDiscountPrice($prodRow,"1",$aryProdOptAttr[$i][POA_SALE_PRICE],"US");

					if ($prodRow[P_EVENT_UNIT] && $prodRow[P_EVENT]){

						$result[$aryProdOptAttr[$i][POA_NO]][POA_SALE_PRICE_TAX]		= getProdDiscountPrice($prodRow,"1",$aryProdOptAttr[$i][POA_SALE_PRICE]) - (getProdDiscountPrice($prodRow,"1",$aryProdOptAttr[$i][POA_SALE_PRICE])*0.1);

						$result[$aryProdOptAttr[$i][POA_NO]]['POA_SALE_PRICE_TAX_USD']	= getProdDiscountPrice($prodRow,"1",$aryProdOptAttr[$i][POA_SALE_PRICE],"US") - (getProdDiscountPrice($prodRow,"1",$aryProdOptAttr[$i][POA_SALE_PRICE],"US")*0.1);

					} else {
						$result[$aryProdOptAttr[$i][POA_NO]][POA_SALE_PRICE_TAX]		= 0;
						$result[$aryProdOptAttr[$i][POA_NO]]['POA_SALE_PRICE_TAX_USD']	= 0;
					}
				}
			}


			$result_array = json_encode($result);
		break;

		case "prodOptAttr2":
			$productMgr->setPO_TYPE("O");
			$productMgr->setP_CODE($strP_CODE);

			$productMgr->setPO_NO($intPO_NO);
			$productMgr->setPOA_ATTR1($strAttr1);
			$productMgr->setPOA_ATTR2($strAttr2);
			$productMgr->setPOA_ATTR3($strAttr3);
			$productMgr->setPOA_ATTR4($strAttr4);
			$productMgr->setPOA_ATTR5($strAttr5);
			$productMgr->setPOA_ATTR6($strAttr6);
			$productMgr->setPOA_ATTR7($strAttr7);
			$productMgr->setPOA_ATTR8($strAttr8);
			$productMgr->setPOA_ATTR9($strAttr9);

			$productMgr->setPOA_ATTR_GROUP($intAttrSort);

			$result[$intPO_NO][$intAttrSort] = $productMgr->getProdOptAttrGroupDetail($db);


			$result_array = json_encode($result);
		break;

		case "prodOptAttrNo":

			$productMgr->setP_CODE($strP_CODE);
			$prodRow = $productMgr->getProdView($db);

			$productMgr->setPO_TYPE("O");

			$productMgr->setPO_NO($intPO_NO);
			$productMgr->setPOA_ATTR1($strAttr1);
			$productMgr->setPOA_ATTR2($strAttr2);
			$productMgr->setPOA_ATTR3($strAttr3);
			$productMgr->setPOA_ATTR4($strAttr4);
			$productMgr->setPOA_ATTR5($strAttr5);
			$productMgr->setPOA_ATTR6($strAttr6);
			$productMgr->setPOA_ATTR7($strAttr7);
			$productMgr->setPOA_ATTR8($strAttr8);
			$productMgr->setPOA_ATTR9($strAttr9);

			$result = $productMgr->getProdOptAttrNo($db);

			/* 상품 할인 적용 */
			//if ($prodRow[P_EVENT] > 0 && getProdEventInfo($prodRow) == 'Y'){
			$intProdPrice						= $result[0]['POA_SALE_PRICE'];
			//상품 json 옵션값 변경. 남덕희
//			$result[0]['POA_SALE_PRICE']		= getProdDiscountPrice($prodRow,1,$result[0]['POA_SALE_PRICE']);
//			$result[0]['POA_SALE_PRICE_USD']	= getProdDiscountPrice($prodRow,"1",$intProdPrice,"US");
			$result[0]['POA_SALE_PRICE']		= getCurToPriceFilter($intProdPrice,'','',$prodRow['P_PRICE_FILTER']);
			$result[0]['POA_SALE_PRICE_USD']	= getCurToPriceFilter($intProdPrice,'US','',$prodRow['P_PRICE_FILTER']);


			//}
			/* 상품 할인 적용 */

			$result_array = json_encode($result);
		break;

		case "prodAddOpt":

			$productMgr->setPO_TYPE("A");
			$productMgr->setP_CODE($strP_CODE);
			$aryProdOpt = $productMgr->getProdOpt($db);


			if (is_array($aryProdOpt)){

				for($i=0;$i<sizeof($aryProdOpt);$i++){

					$result[$aryProdOpt[$i][PO_NO]][PO_NAME1]					= $aryProdOpt[$i][PO_NAME1];
					$result[$aryProdOpt[$i][PO_NO]][PO_NAME2]					= $aryProdOpt[$i][PO_NAME2];
					$result[$aryProdOpt[$i][PO_NO]][PO_ESS]						= $aryProdOpt[$i][PO_ESS];
				}
			}

			$result_array = json_encode($result);

		break;

		case "prodAddOptAttr":

			$productMgr->setP_CODE($strP_CODE);
			$aryProdAddOptAttr = $productMgr->getProdAddOpt($db);

			if (is_array($aryProdAddOptAttr)){

				for($i=0;$i<sizeof($aryProdAddOptAttr);$i++){

					$result[$aryProdAddOptAttr[$i][PAO_NO]][PAO_NO]					= $aryProdAddOptAttr[$i][PAO_NO];
					$result[$aryProdAddOptAttr[$i][PAO_NO]][PAO_NAME]				= $aryProdAddOptAttr[$i][PAO_NAME];
					$result[$aryProdAddOptAttr[$i][PAO_NO]][PAO_PRICE]				= getCurToPriceSave($aryProdAddOptAttr[$i][PAO_PRICE]);
					$result[$aryProdAddOptAttr[$i][PAO_NO]]['PAO_PRICE_USD']		= getCurToPriceSave($aryProdAddOptAttr[$i][PAO_PRICE],"US");
				}
			}
			$result_array = json_encode($result);
		break;

		case "prodDataDel":
			$result[0][RET] = "Y";
			$result_array = json_encode($result);
		break;

		case "sendSMS":
			// dalin-car.co.kr&menuType=product&mode=view&act=list
			// 상품보기 페이지에서 "문자 상담하기" 버튼 클릭시 실행
			$strSmsMode			= "guestRequestSms";
			$msg				= "접수가 완료되었습니다. 잠시만 기다려주십시요.";
			include WEB_FRWORK_ACT."Sms.php";
			$result[0][RET] =$msg;
			$result_array = json_encode($result);

		break;

		case "cart":
		case "cartOrder":
		case "cartWish":

			if(!$g_cart_prikey){
				$prikey = md5(uniqid(rand()));

				setCookie("COOKIE_CART_PRIKEY",$prikey,0,"/");
				$g_cart_prikey = $prikey;
			}

			$cateMgr->setCL_LNG($S_SITE_LNG);

			/* 상품정보 */
			$productMgr->setP_CODE($strP_CODE);
			$prodRow = $productMgr->getProdView($db);


				$result[0][RET] = "N";
			/* 품절 체크 */
			if ($prodRow[P_STOCK_OUT] == "Y"){
				$result[0][MSG] = $LNG_TRANS_CHAR["PS00007"]; //이미 품절된 상품입니다.
				$result[0][RET] = "N";
				$result_array = json_encode($result);
				$db->disConnect();
				echo $result_array;
				exit;
			}

			/* 필수사항 체크 */
			/* 상품 옵션 */
			$productMgr->setPO_TYPE("O");
			$aryProdOpt = $productMgr->getProdOpt($db);


			$aryProdOptAttrNo = $_POST["cartOptNo"];
			if (is_array($aryProdOptAttrNo)){

				$intCartTotalQty = 0;
				for($i=0;$i<sizeof($aryProdOptAttrNo);$i++){
					$intProdOptAttrNo = $aryProdOptAttrNo[$i];
					$intCartQty = $_POST[$intProdOptAttrNo."_cartQty"];
					$intCartTotalQty = $intCartTotalQty + $intCartQty;
				}

				/* 전체 총 수량 확인 */
				if ($prodRow["P_MAX_QTY"] > 0 && $prodRow["P_MAX_QTY"] < $intCartTotalQty){
					$result[0][MSG] = callLangTrans($LNG_TRANS_CHAR["PS00021"],array($prodRow["P_MAX_QTY"])); //"선택하신 상품 수량은 {{단어1}} 이상 구매하실 수 없습니다.";
					$result[0][RET] = "N";

					$result_array = json_encode($result);
					$db->disConnect();
					echo $result_array;
					exit;
				}

				if ( $prodRow["P_MIN_QTY"] > 0 && $prodRow["P_MIN_QTY"] > $intCartTotalQty){
					$result[0][MSG] = callLangTrans($LNG_TRANS_CHAR["PS00020"],array($prodRow["P_MIN_QTY"])); //"선택하신 상품 수량은 최소 {{단어1}} 이상 입력하셔야 합니다.";
					$result[0][RET] = "N";

					$result_array = json_encode($result);
					$db->disConnect();
					echo $result_array;
					exit;
				}

				$strCartParamList = "";
				for($i=0;$i<sizeof($aryProdOptAttrNo);$i++){
					$productMgr->setPO_NO(0);

					$intProdOptAttrNo = $aryProdOptAttrNo[$i];
					$intCartQty = $_POST[$intProdOptAttrNo."_cartQty"];


					if ($prodRow["P_MAX_QTY"] > 0 && $prodRow["P_MAX_QTY"] < $intCartQty){
						$result[0][MSG] = callLangTrans($LNG_TRANS_CHAR["PS00021"],array($prodRow["P_MAX_QTY"])); //"선택하신 상품 수량은 {{단어1}} 이상 구매하실 수 없습니다.";
						$result[0][RET] = "N";

						$result_array = json_encode($result);
						$db->disConnect();
						echo $result_array;
						exit;
					}

					if ($intProdOptAttrNo > 0){
						$productMgr->setPOA_NO($intProdOptAttrNo);
						$aryProdOptAttr = $productMgr->getProdOptAttr($db);

						if ($intCartQty	<= 0){
							$result[0][MSG] = $LNG_TRANS_CHAR["PS00008"]; //상품수량이 존재하지 않습니다.
							$result[0][RET] = "N";
							$result_array = json_encode($result);
							$db->disConnect();
							echo $result_array;
							exit;
						}

						/* 수량 체크(무제한상품이 아닐경우) */
						if ($prodRow[P_STOCK_LIMIT] != "Y"){
							if (($prodRow[P_QTY] > 0 && $aryProdOptAttr[0][POA_STOCK_QTY] < $intCartQty) || ($aryProdOptAttr[0][POA_STOCK_QTY] <= 0)){
								$result[0][MSG] = $LNG_TRANS_CHAR["PS00010"]; //선택하신 옵션 상품 수량이 존재하지 않습니다.
								$result[0][RET] = "N";
								$result_array = json_encode($result);
								$db->disConnect();
								echo $result_array;
								exit;
							}
						}

						/* 가격 체크 */
						if ($prodRow[P_OPT] == "1") {
							if ($prodRow[P_SALE_PRICE] == 0){
								$result[0][MSG] = $LNG_TRANS_CHAR["PS00011"]; //선택하신 옵션 상품은 가격 미정인 상품입니다.
								$result[0][RET] = "N";
								$result_array = json_encode($result);
								$db->disConnect();
								echo $result_array;
								exit;
							}
						} else {
							if ($aryProdOptAttr[0][POA_SALE_PRICE] == 0){
								$result[0][MSG] = $LNG_TRANS_CHAR["PS00011"]; //선택하신 옵션 상품은 가격 미정인 상품입니다.
								$result[0][RET] = "N";
								$result_array = json_encode($result);
								$db->disConnect();
								echo $result_array;
								exit;
							}
						}


						$aryProdCartOpt[$i][NO]				= $productMgr->getPOA_NO();
						$aryProdCartOpt[$i][NAME1]			= $aryProdOpt[$i][PO_NAME1];
						$aryProdCartOpt[$i][NAME2]			= $aryProdOpt[$i][PO_NAME2];
						$aryProdCartOpt[$i][NAME3]			= $aryProdOpt[$i][PO_NAME3];
						$aryProdCartOpt[$i][NAME4]			= $aryProdOpt[$i][PO_NAME4];
						$aryProdCartOpt[$i][NAME5]			= $aryProdOpt[$i][PO_NAME5];
						$aryProdCartOpt[$i][NAME6]			= $aryProdOpt[$i][PO_NAME6];
						$aryProdCartOpt[$i][NAME7]			= $aryProdOpt[$i][PO_NAME7];
						$aryProdCartOpt[$i][NAME8]			= $aryProdOpt[$i][PO_NAME8];
						$aryProdCartOpt[$i][NAME9]			= $aryProdOpt[$i][PO_NAME9];
						$aryProdCartOpt[$i][NAME10]			= $aryProdOpt[$i][PO_NAME10];

						$aryProdCartOpt[$i][ATTR1]			= $aryProdOptAttr[0][POA_ATTR1];
						$aryProdCartOpt[$i][ATTR2]			= $aryProdOptAttr[0][POA_ATTR2];
						$aryProdCartOpt[$i][ATTR3]			= $aryProdOptAttr[0][POA_ATTR3];
						$aryProdCartOpt[$i][ATTR4]			= $aryProdOptAttr[0][POA_ATTR4];
						$aryProdCartOpt[$i][ATTR5]			= $aryProdOptAttr[0][POA_ATTR5];
						$aryProdCartOpt[$i][ATTR6]			= $aryProdOptAttr[0][POA_ATTR6];
						$aryProdCartOpt[$i][ATTR7]			= $aryProdOptAttr[0][POA_ATTR7];
						$aryProdCartOpt[$i][ATTR8]			= $aryProdOptAttr[0][POA_ATTR8];
						$aryProdCartOpt[$i][ATTR9]			= $aryProdOptAttr[0][POA_ATTR9];
						$aryProdCartOpt[$i][ATTR10]			= $aryProdOptAttr[0][POA_ATTR10];

						if ($prodRow[P_OPT] == "1") $aryProdCartOpt[$i][PRICE]			= $prodRow[P_SALE_PRICE];
						else $aryProdCartOpt[$i][PRICE]			= $aryProdOptAttr[0][POA_SALE_PRICE];

						/*입고가격*/
						if ($prodRow[P_OPT] == "1") $aryProdCartOpt[$i][STOCK_PRICE]	= $prodRow[P_STOCK_PRICE];
						else $aryProdCartOpt[$i][STOCK_PRICE]			= $aryProdOptAttr[0][POA_STOCK_PRICE];

						/* 회원 등급별 추가할인혜택적용 중복할인으로 인해 삭제
						$aryProdCartOpt[$i][PRICE]		= getProdDiscountPrice($prodRow,"2",$aryProdCartOpt[$i][PRICE]);
						*/

						/* 적립금 */
						$intProdPoint = getProdPoint($aryProdCartOpt[$i][PRICE], $aryProdOptAttr[0][POA_POINT], $prodRow[P_POINT_TYPE], $prodRow[P_POINT_OFF1], $prodRow[P_POINT_OFF2]);
						$aryProdCartOpt[$i][POINT]		= $intProdPoint;
						/* 상품 옵션정보 담기*/

						/* 상품 포인트를 특정 그룹에만 부여한다.(2013.08.22 : 애협) */
						if (is_array($S_FIX_PROD_POINT_VIEW_SPEC_GROUP_LIST)){
							if (!$g_member_login || !in_array($g_member_group,$S_FIX_PROD_POINT_VIEW_SPEC_GROUP_LIST)){
								$aryProdCartOpt[$i][POINT]		= 0;
							}
						}

					} else {
						/* 수량 체크(무제한상품이 아닐 경우) */
						if ($prodRow[P_STOCK_LIMIT] != "Y"){
							if (($prodRow[P_QTY] > 0 && $prodRow[P_QTY] < $intCartQty) || ($prodRow[P_QTY] <= 0)){

								$result[0][MSG] = $LNG_TRANS_CHAR["PS00010"]; //선택하신 옵션 상품 수량이 존재하지 않습니다.
								$result[0][RET] = "N";
								$result_array = json_encode($result);
								$db->disConnect();
								echo $result_array;
								exit;
							}
						}

						/* 가격 체크 */
						if ($prodRow[P_SALE_PRICE] == 0){
							$result[0][MSG] = $LNG_TRANS_CHAR["PS00011"]; //"선택하신 옵션 상품은 가격 미정인 상품입니다."
							$result[0][RET] = "N";
							$result_array = json_encode($result);
							$db->disConnect();
							echo $result_array;
							exit;
						}

						//$intProdPoint = getProdPoint(getProdDiscountPrice($prodRow,"2"), $prodRow[P_POINT], $prodRow[P_POINT_TYPE], $prodRow[P_POINT_OFF1], $prodRow[P_POINT_OFF2]);
						$intProdPoint = getProdPoint($prodRow[P_SALE_PRICE], $prodRow[P_POINT], $prodRow[P_POINT_TYPE], $prodRow[P_POINT_OFF1], $prodRow[P_POINT_OFF2]);

						$aryProdCartOpt[$i][NO]				= 0;
						$aryProdCartOpt[$i][NAME1]			= "";
						$aryProdCartOpt[$i][NAME2]			= "";
						$aryProdCartOpt[$i][NAME3]			= "";
						$aryProdCartOpt[$i][NAME4]			= "";
						$aryProdCartOpt[$i][NAME5]			= "";
						$aryProdCartOpt[$i][NAME6]			= "";
						$aryProdCartOpt[$i][NAME7]			= "";
						$aryProdCartOpt[$i][NAME8]			= "";
						$aryProdCartOpt[$i][NAME9]			= "";
						$aryProdCartOpt[$i][NAME10]			= "";
						$aryProdCartOpt[$i][ATTR1]			= "";
						$aryProdCartOpt[$i][ATTR2]			= "";
						$aryProdCartOpt[$i][ATTR3]			= "";
						$aryProdCartOpt[$i][ATTR4]			= "";
						$aryProdCartOpt[$i][ATTR5]			= "";
						$aryProdCartOpt[$i][ATTR6]			= "";
						$aryProdCartOpt[$i][ATTR7]			= "";
						$aryProdCartOpt[$i][ATTR8]			= "";
						$aryProdCartOpt[$i][ATTR9]			= "";
						$aryProdCartOpt[$i][ATTR10]			= "";
						$aryProdCartOpt[$i][PRICE]			= $prodRow[P_SALE_PRICE]; //getProdDiscountPrice($prodRow,"2")
						$aryProdCartOpt[$i][STOCK_PRICE]	= $prodRow[P_STOCK_PRICE];
						$aryProdCartOpt[$i][POINT]			= $intProdPoint;

						/* 상품 포인트를 특정 그룹에만 부여한다.(2013.08.22 : 애협) */
						if($S_FIX_PROD_POINT_VIEW_SPEC_GROUP_LIST){
							if (!$g_member_login || !in_array($g_member_group,$S_FIX_PROD_POINT_VIEW_SPEC_GROUP_LIST)){
								$aryProdCartOpt[0][POINT]		= 0;
							}
						}

					} //->opt체크

					/* 상품 추가 옵션*/
					if ($prodRow[P_ADD_OPT] == "Y"){
						$productMgr->setPO_TYPE("A");
						$aryProdAddOpt = $productMgr->getProdOpt($db);
						if (is_array($aryProdAddOpt)){

							$intProdAddOptPriceTotal = 0;

							for($k=0;$k<sizeof($aryProdAddOpt);$k++){
								if ($aryProdAddOpt[$k][PO_NO] > 0){
									$intPO_NO = $aryProdAddOpt[$k][PO_NO];
									$productMgr->setPO_NO($intPO_NO);

									$aryPostProdAddCartOpt		= $_POST[$intProdOptAttrNo."cartAddOptNo_no_".$intPO_NO];
									$aryPostProdAddCartOptQty	= $_POST[$intProdOptAttrNo."cartAddOptNo_qty_".$intPO_NO];

									for($n=0;$n<sizeof($aryPostProdAddCartOpt);$n++){
										$intProdAddCartOpt		= $aryPostProdAddCartOpt[$n];
										$intProdAddCartOptQty	= $aryPostProdAddCartOptQty[$n];

										if (!$intProdAddCartOpt){
											$result[0][MSG] = $LNG_TRANS_CHAR["PS00012"]; //하나 이상의 추가필수 선택을 선택해주세요.
											$result[0][RET] = "N";
											$result_array = json_encode($result);
											$db->disConnect();
											echo $result_array;
											exit;
										}

										/* 상품 추가 옵션정보 담기*/
										$productMgr->setPO_NO($intPO_NO);
										$productMgr->setPAO_NO($intProdAddCartOpt);
										$aryProdAddOptAttr = $productMgr->getProdAddOpt($db);


										$aryProdAddCartOpt[$k][$n][NO]				= $productMgr->getPAO_NO();
										$aryProdAddCartOpt[$k][$n][NAME]			= $aryProdAddOptAttr[0][PAO_NAME];
										$aryProdAddCartOpt[$k][$n][PRICE]			= $aryProdAddOptAttr[0][PAO_PRICE];
										$aryProdAddCartOpt[$k][$n][QTY]				= $intProdAddCartOptQty;

										$intProdAddOptPriceTotal = $intProdAddOptPriceTotal + ($intProdAddCartOptQty * $aryProdAddOptAttr[0][PAO_PRICE]);
										/* 상품 추가 옵션정보 담기*/

									}
								}
							}
						}
					}
					/* 상품 추가 옵션*/

					/* 상품 추가 항목 */

					if ($S_SHOP_PROD_ADD_ITEM_VERSION == "V2.O"){
						$aryProdItem = $productMgr->getProdItem($db);
						if (is_array($aryProdItem)){
							$intProdItemCnt = 0;
							for($n=0;$n<sizeof($aryProdItem);$n++){
								$intProdItemNo			= $aryProdItem[$n]['PI_NO'];
								$strProdItemType		= (!$aryProdItem[$n]['PI_TYPE']) ? "B":$aryProdItem[$n]['PI_TYPE'];
								$strProdItemName		= $aryProdItem[$n]['PI_NAME'];

								if ($strProdItemType != "B"){
									$strProdItemVal		= $_POST["cartAddItem".$intProdItemNo];
									if ($strProdItemVal){
										$aryProdCartItem[$intProdItemCnt]['ITEM_NM']	= $strProdItemName;
										$aryProdCartItem[$intProdItemCnt]['ITEM_VAL']	= $strProdItemVal;

										$intProdItemCnt++;
									}
								}
							}
						}
					}
					/* 상품 추가 항목 */

					if ($g_member_no) $productMgr->setM_NO($g_member_no);
					else $productMgr->setM_NO(0);

					if ($strAct == "cartWish"){
						/* 0 으로 고정해 놔서 한개만 계속 들어갔음. 수정. 남덕희
						$productMgr->setPW_OPT_NO($aryProdCartOpt[0][NO]);
						$productMgr->setPW_OPT_NM1($aryProdCartOpt[0][NAME1]);
						$productMgr->setPW_OPT_NM2($aryProdCartOpt[0][NAME2]);
						$productMgr->setPW_OPT_NM3($aryProdCartOpt[0][NAME3]);
						$productMgr->setPW_OPT_NM4($aryProdCartOpt[0][NAME4]);
						$productMgr->setPW_OPT_NM5($aryProdCartOpt[0][NAME5]);
						$productMgr->setPW_OPT_NM6($aryProdCartOpt[0][NAME6]);
						$productMgr->setPW_OPT_NM7($aryProdCartOpt[0][NAME7]);
						$productMgr->setPW_OPT_NM8($aryProdCartOpt[0][NAME8]);
						$productMgr->setPW_OPT_NM9($aryProdCartOpt[0][NAME9]);
						$productMgr->setPW_OPT_NM10($aryProdCartOpt[0][NAME10]);
						$productMgr->setPW_OPT_ATTR1($aryProdCartOpt[0][ATTR1]);
						$productMgr->setPW_OPT_ATTR2($aryProdCartOpt[0][ATTR2]);
						$productMgr->setPW_OPT_ATTR3($aryProdCartOpt[0][ATTR3]);
						$productMgr->setPW_OPT_ATTR4($aryProdCartOpt[0][ATTR4]);
						$productMgr->setPW_OPT_ATTR5($aryProdCartOpt[0][ATTR5]);
						$productMgr->setPW_OPT_ATTR6($aryProdCartOpt[0][ATTR6]);
						$productMgr->setPW_OPT_ATTR7($aryProdCartOpt[0][ATTR7]);
						$productMgr->setPW_OPT_ATTR8($aryProdCartOpt[0][ATTR8]);
						$productMgr->setPW_OPT_ATTR9($aryProdCartOpt[0][ATTR9]);
						$productMgr->setPW_OPT_ATTR10($aryProdCartOpt[0][ATTR10]);
						$productMgr->setPW_QTY($intCartQty);
						$productMgr->setPW_STOCK_PRICE($aryProdCartOpt[0][STOCK_PRICE]);
						$productMgr->setPW_PRICE($aryProdCartOpt[0][PRICE]);
						$productMgr->setPW_POINT($aryProdCartOpt[0][POINT]);
						$productMgr->setPW_DELIVERY_TYPE($strCartDelivery);
						$productMgr->setPW_DELIVERY_PRICE(0);
						*/
						$productMgr->setPW_OPT_NO($aryProdCartOpt[$i][NO]);
						$productMgr->setPW_OPT_NM1($aryProdCartOpt[$i][NAME1]);
						$productMgr->setPW_OPT_NM2($aryProdCartOpt[$i][NAME2]);
						$productMgr->setPW_OPT_NM3($aryProdCartOpt[$i][NAME3]);
						$productMgr->setPW_OPT_NM4($aryProdCartOpt[$i][NAME4]);
						$productMgr->setPW_OPT_NM5($aryProdCartOpt[$i][NAME5]);
						$productMgr->setPW_OPT_NM6($aryProdCartOpt[$i][NAME6]);
						$productMgr->setPW_OPT_NM7($aryProdCartOpt[$i][NAME7]);
						$productMgr->setPW_OPT_NM8($aryProdCartOpt[$i][NAME8]);
						$productMgr->setPW_OPT_NM9($aryProdCartOpt[$i][NAME9]);
						$productMgr->setPW_OPT_NM10($aryProdCartOpt[$i][NAME10]);
						$productMgr->setPW_OPT_ATTR1($aryProdCartOpt[$i][ATTR1]);
						$productMgr->setPW_OPT_ATTR2($aryProdCartOpt[$i][ATTR2]);
						$productMgr->setPW_OPT_ATTR3($aryProdCartOpt[$i][ATTR3]);
						$productMgr->setPW_OPT_ATTR4($aryProdCartOpt[$i][ATTR4]);
						$productMgr->setPW_OPT_ATTR5($aryProdCartOpt[$i][ATTR5]);
						$productMgr->setPW_OPT_ATTR6($aryProdCartOpt[$i][ATTR6]);
						$productMgr->setPW_OPT_ATTR7($aryProdCartOpt[$i][ATTR7]);
						$productMgr->setPW_OPT_ATTR8($aryProdCartOpt[$i][ATTR8]);
						$productMgr->setPW_OPT_ATTR9($aryProdCartOpt[$i][ATTR9]);
						$productMgr->setPW_OPT_ATTR10($aryProdCartOpt[$i][ATTR10]);
						$productMgr->setPW_QTY($intCartQty);
						$productMgr->setPW_STOCK_PRICE($aryProdCartOpt[$i][STOCK_PRICE]);
						$productMgr->setPW_PRICE($aryProdCartOpt[$i][PRICE]);
						$productMgr->setPW_POINT($aryProdCartOpt[$i][POINT]);
						$productMgr->setPW_DELIVERY_TYPE($strCartDelivery);
						$productMgr->setPW_DELIVERY_PRICE(0);
						$productMgr->setPW_DELIVERY_EXP($strCartDeliveryExp);
						$productMgr->setPW_ADD_OPT_PRICE($intProdAddOptPriceTotal);
						$productMgr->getProductWishInsertUpdate($db);
						$intWishNo = $db->getLastInsertID();
						if(!$intWishNo) {
							$intWishNo = $productMgr->getProductWishNo($db);
						}
						$productMgr->setPW_NO($intWishNo);

						if ($prodRow[P_ADD_OPT] == "Y"){
							$productMgr->setPO_TYPE("A");
							$aryProdAddOpt = $productMgr->getProdOpt($db);
							if (is_array($aryProdAddOpt)){

								for($k=0;$k<sizeof($aryProdAddOpt);$k++){

									if ($aryProdAddOpt[$k][PO_NO] > 0){
										$intPO_NO = $aryProdAddOpt[$k][PO_NO];

										$aryPostProdAddCartOpt		= $_POST[$intProdOptAttrNo."cartAddOptNo_no_".$intPO_NO];

										for($n=0;$n<sizeof($aryPostProdAddCartOpt);$n++){

											$productMgr->setPW_NO($intWishNo);
											$productMgr->setPWA_OPT_NO($aryProdAddCartOpt[$k][$n][NO]);
											$productMgr->setPWA_OPT_NM($aryProdAddCartOpt[$k][$n][NAME]);
											$productMgr->setPWA_OPT_PRICE($aryProdAddCartOpt[$k][$n][PRICE]);
											$productMgr->setPWA_OPT_QTY($aryProdAddCartOpt[$k][$n][QTY]);
											if ($aryProdAddCartOpt[$k][$n][NO] > 0){
												$productMgr->getProductWishAddInsertUpdate($db);
											}
										}
									}
								}
							}
						}

						/* 상품 추가 항목 */
						if ($S_SHOP_PROD_ADD_ITEM_VERSION == "V2.O"){
							if (is_array($aryProdCartItem)){

								for($n=0;$n<sizeof($aryProdCartItem);$n++){
									if ($aryProdCartItem[$n]['ITEM_NM'] && $aryProdCartItem[$n]['ITEM_VAL']){
										$paramWishItemData					= "";
										$paramWishItemData['PW_NO']			= $intWishNo;
										$paramWishItemData['PWI_ITEM_NM']		= $aryProdCartItem[$n]['ITEM_NM'];
										$paramWishItemData['PWI_ITEM_VAL']	= $aryProdCartItem[$n]['ITEM_VAL'];
										$productMgr->getProdWishItemInsert($db,$paramWishItemData);
									}
								}
							}
						}
						/* 상품 추가 항목 */

					} else{
						$productMgr->setPB_KEY($g_cart_prikey);

						$productMgr->setPB_OPT_NO($aryProdCartOpt[$i][NO]);
						$productMgr->setPB_OPT_NM1($aryProdCartOpt[$i][NAME1]);
						$productMgr->setPB_OPT_NM2($aryProdCartOpt[$i][NAME2]);
						$productMgr->setPB_OPT_NM3($aryProdCartOpt[$i][NAME3]);
						$productMgr->setPB_OPT_NM4($aryProdCartOpt[$i][NAME4]);
						$productMgr->setPB_OPT_NM5($aryProdCartOpt[$i][NAME5]);
						$productMgr->setPB_OPT_NM6($aryProdCartOpt[$i][NAME6]);
						$productMgr->setPB_OPT_NM7($aryProdCartOpt[$i][NAME7]);
						$productMgr->setPB_OPT_NM8($aryProdCartOpt[$i][NAME8]);
						$productMgr->setPB_OPT_NM9($aryProdCartOpt[$i][NAME9]);
						$productMgr->setPB_OPT_NM10($aryProdCartOpt[$i][NAME10]);

						$productMgr->setPB_OPT_ATTR1($aryProdCartOpt[$i][ATTR1]);
						$productMgr->setPB_OPT_ATTR2($aryProdCartOpt[$i][ATTR2]);
						$productMgr->setPB_OPT_ATTR3($aryProdCartOpt[$i][ATTR3]);
						$productMgr->setPB_OPT_ATTR4($aryProdCartOpt[$i][ATTR4]);
						$productMgr->setPB_OPT_ATTR5($aryProdCartOpt[$i][ATTR5]);
						$productMgr->setPB_OPT_ATTR6($aryProdCartOpt[$i][ATTR6]);
						$productMgr->setPB_OPT_ATTR7($aryProdCartOpt[$i][ATTR7]);
						$productMgr->setPB_OPT_ATTR8($aryProdCartOpt[$i][ATTR8]);
						$productMgr->setPB_OPT_ATTR9($aryProdCartOpt[$i][ATTR9]);
						$productMgr->setPB_OPT_ATTR10($aryProdCartOpt[$i][ATTR10]);

						$productMgr->setPB_QTY($intCartQty);
						$productMgr->setPB_STOCK_PRICE($aryProdCartOpt[$i][STOCK_PRICE]);
						$productMgr->setPB_PRICE($aryProdCartOpt[$i][PRICE]);
						$productMgr->setPB_POINT($aryProdCartOpt[$i][POINT]);
						$productMgr->setPB_DELIVERY_TYPE($strCartDelivery);
						$productMgr->setPB_DELIVERY_EXP($strCartDeliveryExp);
						$productMgr->setPB_ADD_OPT_PRICE($intProdAddOptPriceTotal);

						if ($strAct == "cartOrder") $productMgr->setPB_DIRECT("Y");
						else  $productMgr->setPB_DIRECT("N");

						$productMgr->getProdBasketInsertUpdate($db);
						$intBasketNo = $db->getLastInsertID();
						if (!$intBasketNo){
							$intBasketNo = $productMgr->getProdBasketNo($db);
						}
						$productMgr->setPB_NO($intBasketNo);

						if ($prodRow[P_ADD_OPT] == "Y"){
							$productMgr->setPO_TYPE("A");
							$aryProdAddOpt = $productMgr->getProdOpt($db);
							if (is_array($aryProdAddOpt)){

								for($k=0;$k<sizeof($aryProdAddOpt);$k++){

									if ($aryProdAddOpt[$k][PO_NO] > 0){
										$intPO_NO = $aryProdAddOpt[$k][PO_NO];

										$aryPostProdAddCartOpt		= $_POST[$intProdOptAttrNo."cartAddOptNo_no_".$intPO_NO];

										for($n=0;$n<sizeof($aryPostProdAddCartOpt);$n++){

											$productMgr->setPB_NO($intBasketNo);
											$productMgr->setPBA_OPT_NO($aryProdAddCartOpt[$k][$n][NO]);
											$productMgr->setPBA_OPT_NM($aryProdAddCartOpt[$k][$n][NAME]);
											$productMgr->setPBA_OPT_PRICE($aryProdAddCartOpt[$k][$n][PRICE]);
											$productMgr->setPBA_OPT_QTY($aryProdAddCartOpt[$k][$n][QTY]);
											if ($aryProdAddCartOpt[$k][$n][NO] > 0){
												$productMgr->getProdBasketAddOptInsertUpdate($db);
											}
										}
									}
								}
							}
						}

						/* 상품 추가 항목 */
						if ($S_SHOP_PROD_ADD_ITEM_VERSION == "V2.O"){
							if (is_array($aryProdCartItem)){

								for($n=0;$n<sizeof($aryProdCartItem);$n++){
									if ($aryProdCartItem[$n]['ITEM_NM'] && $aryProdCartItem[$n]['ITEM_VAL']){
										$paramBasketItemData					= "";
										$paramBasketItemData['PB_NO']			= $intBasketNo;
										$paramBasketItemData['PBI_ITEM_NM']		= $aryProdCartItem[$n]['ITEM_NM'];
										$paramBasketItemData['PBI_ITEM_VAL']	= $aryProdCartItem[$n]['ITEM_VAL'];
										$productMgr->getProdBasketItemInsert($db,$paramBasketItemData);
									}
								}
							}
						}
						/* 상품 추가 항목 */

						$strCartParamList .= "<input type=\"hidden\" name=\"cartNo[]\" value=\"".$intBasketNo."\">";
					}

				}
			}

			if ($strAct == "cartOrder"){
				$strCartParamList .= "<input type=\"hidden\" name=\"basketDirect\" value=\"Y\">";
			}

			/* 상품 장바구니 팝업 사용 */
			include WEB_FRWORK_JSON."/product.basket.popup.php";
			/* 상품 장바구니 팝업 사용 */

			$result[0][MSG]			= $strAct;
			$result[0][RET]			= "Y";
			$result[0][HTML]		= $strCartParamList;
			$result[0]['POP_HTML']	= $strCartPopHtml;

			if ($S_FIX_ORDER_TOTAL_DISCOUNT_USE == "Y"){
				$result[0]['ORDER_TOTAL_DISCOUNT_HTML']	= $strOrderTotalDiscountHtml;
			}

			$result_array = json_encode($result);

		break;

		case "prodAllDiscount":
			/* 통합 수량 할인 */
			if ($S_ALL_DISCOUNT_USE == "Y")
			{
				$arrAllDiscountInfo = explode("/",$S_ALL_DISCOUNT_VAL);
				$i = 0;
				foreach($arrAllDiscountInfo as $key => $val){
					if ($val)
					{
						$arrDiscountInfo	= explode(":",$val);
						$arrDiscountQty		= explode("~",$arrDiscountInfo[0]);
						$intDiscountMinQty	= ($arrDiscountQty[0]) ? $arrDiscountQty[0] : 0;
						$intDiscountMaxQty	= ($arrDiscountQty[1]) ? $arrDiscountQty[1] : 0;
						$intDiscountPrice	= $arrDiscountInfo[1];
						$intDiscountRate	= $arrDiscountInfo[1];

						$result[$i]['MIN_QTY']				= $intDiscountMinQty;
						$result[$i]['MAX_QTY']				= $intDiscountMaxQty;
						//$result[$i]['DISCOUNT_PRICE']		= getCurToPriceSave($intDiscountPrice);
						//$result[$i]['DISCOUNT_USD_PRICE']	= getCurToPriceSave($intDiscountPrice,"US");
						$result[$i]['DISCOUNT_RATE']		= $intDiscountRate;

						$i++;
					}
				}
			}

			$result_array = json_encode($result);

		break;

		case "cartDel":

			$aryCartNo = $_POST["cartNo"];

			if (is_array($aryCartNo)){
				for($i=0;$i<sizeof($aryCartNo);$i++){
					$intPB_NO = $aryCartNo[$i];
					$productMgr->setPB_NO($intPB_NO);
					$productMgr->getProductBasketAddDelete($db);
					$productMgr->getProductBasketDelete($db);
				}
			}

			/* 상품 장바구니 팝업 사용 */
			include WEB_FRWORK_JSON."/product.basket.popup.php";
			/* 상품 장바구니 팝업 사용 */

			$result[0][MSG]			= "";
			$result[0][RET]			= "Y";
			$result[0]['POP_HTML']	= $strCartPopHtml;

			$result_array = json_encode($result);

		break;

		case "prodLikeUpdate":
			/* 상품 좋아요 클릭 */

			if (!$g_member_no || !$g_member_login){
				$result[0][MSG]	= "NO_MEMBER_LOGIN";
				$result[0][RET]	= "N";
				echo json_encode($result);
				exit;
			}


			$param					= "";
			$param['M_NO']			= $g_member_no;
			$param['P_CODE']		= $strP_CODE;
			$intCount				= $productMgr->getProdLikeList($db,"OP_COUNT",$param);

			$param['LIKE_TYPE']		= "Y";
			if ($intCount > 0){
				$param['LIKE_TYPE'] = "N";
			}
			$result = $productMgr->getProdLikeUpdateDelete($db,$param);
			if (!$result){
				$result[0][MSG]	= "QUERY_ERROR";
				$result[0][RET]	= "N";
				echo json_encode($result);
				exit;
			}

			$result					= "";
			$result[0]['P_CODE']	= $strP_CODE;
			$result[0]['LIKE_TYPE']	= $param['LIKE_TYPE'];
			$result[0][MSG]			= "";
			$result[0][RET]			= "Y";
			$result_array = json_encode($result);

		break;

		case "prodLikeAllDelete":
			if (!$g_member_no || !$g_member_login){
				$result[0][MSG]	= "NO_MEMBER_LOGIN";
				$result[0][RET]	= "N";
				echo json_encode($result);
				exit;
			}

			$param					= "";
			$param['M_NO']			= $g_member_no;
			$result = $productMgr->getProdLikeAllDelete($db,$param);
			if (!$result){
				$result[0][MSG]	= "QUERY_ERROR";
				$result[0][RET]	= "N";
				echo json_encode($result);
				exit;
			}

			$result					= "";
			$result[0][MSG]			= "";
			$result[0][RET]			= "Y";
			$result_array = json_encode($result);

		break;

		case "prodAddCartHtml":
			## 상품 ADD CART 사용시 레이어 화면 그리기

			$strAppId				= $_POST["appId"];
			$strAppCallPage			= $_POST["callPage"];

			$strCallFuncName		= "ProductListDefaultSkin";
			if ($strAppCallPage == "main") $strCallFuncName = "";
			$productMgr->setP_CODE($strP_CODE);
			$prodRow = $productMgr->getProdView($db);

			/* 상품 옵션 */
			$productMgr->setPO_TYPE("O");
			$aryProdOpt = $productMgr->getProdOpt($db);
			$aryProdOptJson = "";
			if (is_array($aryProdOpt)){
				for($i=0;$i<sizeof($aryProdOpt);$i++){
					if ($aryProdOpt[$i][PO_NO] > 0){
						$productMgr->setPO_NO($aryProdOpt[$i][PO_NO]);

						/* 다중가격사용안함.다중가격분리형 */
						$aryProdOpt[$i]["OPT_ATTR1"] = $productMgr->getProdOptAttrGroup($db);

						/* 다중각격분리형 */
						$aryProdOpt[$i]["OPT_ATTR_ALL"] = $productMgr->getProdOptAttr($db);

						$aryProdOptJson[$aryProdOpt[$i][PO_NO]][PO_NAME1]					= $aryProdOpt[$i][PO_NAME1];
						$aryProdOptJson[$aryProdOpt[$i][PO_NO]][PO_NAME2]					= $aryProdOpt[$i][PO_NAME2];
						$aryProdOptJson[$aryProdOpt[$i][PO_NO]][PO_NAME3]					= $aryProdOpt[$i][PO_NAME3];
						$aryProdOptJson[$aryProdOpt[$i][PO_NO]][PO_NAME4]					= $aryProdOpt[$i][PO_NAME4];
						$aryProdOptJson[$aryProdOpt[$i][PO_NO]][PO_NAME5]					= $aryProdOpt[$i][PO_NAME5];
						$aryProdOptJson[$aryProdOpt[$i][PO_NO]][PO_NAME6]					= $aryProdOpt[$i][PO_NAME6];
						$aryProdOptJson[$aryProdOpt[$i][PO_NO]][PO_NAME7]					= $aryProdOpt[$i][PO_NAME7];
						$aryProdOptJson[$aryProdOpt[$i][PO_NO]][PO_NAME8]					= $aryProdOpt[$i][PO_NAME8];
						$aryProdOptJson[$aryProdOpt[$i][PO_NO]][PO_NAME9]					= $aryProdOpt[$i][PO_NAME9];
						$aryProdOptJson[$aryProdOpt[$i][PO_NO]][PO_NAME10]					= $aryProdOpt[$i][PO_NAME10];
						$aryProdOptJson[$aryProdOpt[$i][PO_NO]][PO_ESS]						= $aryProdOpt[$i][PO_ESS];
					}
				}
			}


			/* 상품 추가 옵션*/
			if ($prodRow[P_ADD_OPT] == "Y"){
				$productMgr->setPO_TYPE("A");
				$aryProdAddOpt = $productMgr->getProdOpt($db);
				if (is_array($aryProdAddOpt)){
					for($i=0;$i<sizeof($aryProdAddOpt);$i++){
						if ($aryProdAddOpt[$i][PO_NO] > 0){
							$productMgr->setPO_NO($aryProdAddOpt[$i][PO_NO]);

							$aryProdAddOpt[$i][OPT_ATTR] = $productMgr->getProdAddOpt($db);
						}
					}
				}
			}

			## 상품옵션그리기
			$strProdOptHtml = "";
			if ($prodRow[P_OPT] == "1" || $prodRow[P_OPT] == "3")
			{
				if (is_array($aryProdOpt))
				{
					$i=0;
					for($kk=1;$kk<=10;$kk++)
					{
						$strProdOptName				= $aryProdOpt[$i]['PO_NAME'.$kk];		//옵션명
						$intProdOptNo				= $aryProdOpt[$i][PO_NO];				//옵션번호
						$strProdOptSelectName		= $kk."_".$intProdOptNo;				//옵션박스이름정의
						$strProdOptSelectJavascript = "onchange=\"javascript:go".$strCallFuncName."AddCartSelectEvent('{$strAppId}','{$strP_CODE}','cartOpt{$kk}_{$intProdOptNo}',{$kk});\"";
						$strProdOptSelectDefault	= ($aryProdOpt[$i][PO_ESS]=="Y")?$LNG_TRANS_CHAR["PW00009"]:$LNG_TRANS_CHAR["PW00010"];

						$aryProdOptAttrSelectList	= $aryProdOpt[$i]["OPT_ATTR".$kk];		//옵션박스 option list
						$strProdOptAttrSelectDraw	= "";
						if ($strProdOptName)
						{
							for($j=0;$j<sizeof($aryProdOptAttrSelectList);$j++){
								$strProdOptAttrSelectDraw .= "<option value=\"".$aryProdOptAttrSelectList[$j]['POA_ATTR1']."\">".$aryProdOptAttrSelectList[$j]['POA_ATTR1']."</option>";
							}

							$strProdOptHtml .= "
								<tr>
									<th>".$strProdOptName."</th>
									<td>
										<select id=\"cartOpt{$strProdOptSelectName}\" name=\"cartOpt{$strProdOptSelectName}\" ".$strProdOptSelectJavascript.">
										<option value=\"\">".$strProdOptSelectDefault."</option>
										".$strProdOptAttrSelectDraw."
										</select>
									</td>
								</tr>";

						} //->if
					} //->for
				} //->if
			} else if ($prodRow[P_OPT] == "2"){
				if (is_array($aryProdOpt))
				{
					$i=0;
					$strProdOptName					= "";
					$intProdOptNo					= $aryProdOpt[$i][PO_NO];					//옵션번호

					for($kk=1;$kk<=10;$kk++)
					{
						if ($aryProdOpt[$i]['PO_NAME'.$kk]){
							$strProdOptName		   .= $aryProdOpt[$i]['PO_NAME'.$kk]."/";		//옵션명
						}
					} //->for

					if ($strProdOptName){

						$strProdOptName				= substr($strProdOptName,0,strlen($strProdOptName)-1);
						$strProdOptSelectName		= "1_".$intProdOptNo;					//옵션박스이름정의

						$aryProdOptAttrSelectList	= $aryProdOpt[$i]["OPT_ATTR_ALL"];		//옵션박스 option list
						$strProdOptSelectJavascript = "onchange=\"javascript:go".$strCallFuncName."AddCartSelectEvent('{$strAppId}','{$strP_CODE}','cartOpt{$strProdOptSelectName}',1);\"";
						$strProdOptSelectDefault	= ($aryProdOpt[$i][PO_ESS]=="Y")?$LNG_TRANS_CHAR["PW00009"]:$LNG_TRANS_CHAR["PW00010"];
						$strProdOptAttrSelectDraw	= "";
						if ($strProdOptName)
						{
							for($j=0;$j<sizeof($aryProdOptAttrSelectList);$j++){
								$strProdOptAttr = "";
								for($kk=1;$kk<=10;$kk++){
									if ($aryProdOpt[$i]["PO_NAME".$kk]){
										$strProdOptAttr .= "/".$aryProdOpt[$i][OPT_ATTR_ALL][$j]["POA_ATTR".$kk];
									}
								}
								$strProdOptAttr = SUBSTR($strProdOptAttr,1);

								$strProdOptAttrSelectDraw .= "<option value=\"".$aryProdOptAttrSelectList[$j]['POA_NO']."\">".$strProdOptAttr."</option>";
							}

							$strProdOptHtml .= "
								<tr>
									<th>".$strProdOptName."</th>
									<td>
										<select id=\"cartOpt{$strProdOptSelectName}\" name=\"cartOpt{$strProdOptSelectName}\" ".$strProdOptSelectJavascript.">
										<option value=\"\">".$strProdOptSelectDefault."</option>
										".$strProdOptAttrSelectDraw."
										</select>
									</td>
								</tr>";

						} //->if
					}
				} //->if
			}

			/* 상품 추가 옵션*/
			if ($prodRow[P_ADD_OPT] == "Y"){
				$productMgr->setPO_TYPE("A");
				$aryProdAddOpt = $productMgr->getProdOpt($db);
				if (is_array($aryProdAddOpt)){
					for($i=0;$i<sizeof($aryProdAddOpt);$i++){
						if ($aryProdAddOpt[$i][PO_NO] > 0){
							$productMgr->setPO_NO($aryProdAddOpt[$i][PO_NO]);

							$aryProdAddOpt[$i][OPT_ATTR] = $productMgr->getProdAddOpt($db);

							$strProdAddOptDefault = ($aryProdAddOpt[$i][PO_ESS]=="Y") ? $LNG_TRANS_CHAR["PW00009"]:$LNG_TRANS_CHAR["PW00010"];

							$strProdAddOptAttrSelectDraw = "";
							for($j=0;$j<sizeof($aryProdAddOpt[$i][OPT_ATTR]);$j++){
								$strProdAddOptAttrSelectDraw .= "<option value=".$aryProdAddOpt[$i][OPT_ATTR][$j][PAO_NO].">".$aryProdAddOpt[$i][OPT_ATTR][$j][PAO_NAME]."</option>";
							}

							$strProdOptHtml .= "
								<tr>
									<th>".$aryProdAddOpt[$i][PO_NAME1]."</th>
									<td>
										<select id=\"cartAddOpt_".$aryProdAddOpt[$i][PO_NO]."\" name=\"cartAddOpt_".$aryProdAddOpt[$i][PO_NO]."\" onchange=\"javascript:go".$strCallFuncName."AddCartAddSelectEvent('{$strAppId}','{$strP_CODE}',this,".$aryProdAddOpt[$i][PO_NO].");\">
										<option value=\"\">".$strProdAddOptDefault."</option>
										".$strProdAddOptAttrSelectDraw."
										</select>
									</td>
								</tr>";
						}
					}
				}
			}

			$strProdOptHtml					= "<table class=\"optionTable\"><tbody>".$strProdOptHtml."</tbody></table>";

			$prodRow['P_SALE_PRICE']		= getProdDiscountPrice($prodRow,1,$prodRow['P_SALE_PRICE']);
			$prodRow['P_SALE_PRICE_USD']	= getProdDiscountPrice($prodRow,1,$prodRow['P_SALE_PRICE'],"US");

			## 다중가격사용
			$productMgr->setPO_NO(0);
			$aryProdOptAttr					= $productMgr->getProdOptAttr($db);
			if (is_array($aryProdOptAttr)){

				for($i=0;$i<sizeof($aryProdOptAttr);$i++){

					$aryProdOptAttrJson[$aryProdOptAttr[$i][POA_NO]][PO_NO]					= $aryProdOptAttr[$i][PO_NO];
					$aryProdOptAttrJson[$aryProdOptAttr[$i][POA_NO]][POA_ATTR1]				= $aryProdOptAttr[$i][POA_ATTR1];
					$aryProdOptAttrJson[$aryProdOptAttr[$i][POA_NO]][POA_ATTR2]				= $aryProdOptAttr[$i][POA_ATTR2];
					$aryProdOptAttrJson[$aryProdOptAttr[$i][POA_NO]][POA_ATTR3]				= $aryProdOptAttr[$i][POA_ATTR3];
					$aryProdOptAttrJson[$aryProdOptAttr[$i][POA_NO]][POA_ATTR4]				= $aryProdOptAttr[$i][POA_ATTR4];
					$aryProdOptAttrJson[$aryProdOptAttr[$i][POA_NO]][POA_ATTR5]				= $aryProdOptAttr[$i][POA_ATTR5];
					$aryProdOptAttrJson[$aryProdOptAttr[$i][POA_NO]][POA_ATTR6]				= $aryProdOptAttr[$i][POA_ATTR6];
					$aryProdOptAttrJson[$aryProdOptAttr[$i][POA_NO]][POA_ATTR7]				= $aryProdOptAttr[$i][POA_ATTR7];
					$aryProdOptAttrJson[$aryProdOptAttr[$i][POA_NO]][POA_ATTR8]				= $aryProdOptAttr[$i][POA_ATTR8];
					$aryProdOptAttrJson[$aryProdOptAttr[$i][POA_NO]][POA_ATTR9]				= $aryProdOptAttr[$i][POA_ATTR9];
					$aryProdOptAttrJson[$aryProdOptAttr[$i][POA_NO]][POA_ATTR10]			= $aryProdOptAttr[$i][POA_ATTR10];
					$aryProdOptAttrJson[$aryProdOptAttr[$i][POA_NO]][POA_CONSUMER_PRICE]	= $aryProdOptAttr[$i][POA_CONSUMER_PRICE];
					$aryProdOptAttrJson[$aryProdOptAttr[$i][POA_NO]][POA_STOCK_PRICE]		= $aryProdOptAttr[$i][POA_STOCK_PRICE];
					$aryProdOptAttrJson[$aryProdOptAttr[$i][POA_NO]][POA_POINT]				= $aryProdOptAttr[$i][POA_POINT];
					$aryProdOptAttrJson[$aryProdOptAttr[$i][POA_NO]][POA_STOCK_QTY]			= $aryProdOptAttr[$i][POA_STOCK_QTY];

					$aryProdOptAttrJson[$aryProdOptAttr[$i][POA_NO]][POA_SALE_PRICE]		= getProdDiscountPrice($prodRow,"1",$aryProdOptAttr[$i][POA_SALE_PRICE]);
					$aryProdOptAttrJson[$aryProdOptAttr[$i][POA_NO]]['POA_SALE_PRICE_USD']	= getProdDiscountPrice($prodRow,"1",$aryProdOptAttr[$i][POA_SALE_PRICE],"US");

					if ($prodRow[P_EVENT_UNIT] && $prodRow[P_EVENT]){

						$aryProdOptAttrJson[$aryProdOptAttr[$i][POA_NO]][POA_SALE_PRICE_TAX]= getProdDiscountPrice($prodRow,"1",$aryProdOptAttr[$i][POA_SALE_PRICE]) - (getProdDiscountPrice($prodRow,"1",$aryProdOptAttr[$i][POA_SALE_PRICE])*0.1);

						$aryProdOptAttrJson[$aryProdOptAttr[$i][POA_NO]]['POA_SALE_PRICE_TAX_USD']	= getProdDiscountPrice($prodRow,"1",$aryProdOptAttr[$i][POA_SALE_PRICE],"US") - (getProdDiscountPrice($prodRow,"1",$aryProdOptAttr[$i][POA_SALE_PRICE],"US")*0.1);

					} else {
						$aryProdOptAttrJson[$aryProdOptAttr[$i][POA_NO]][POA_SALE_PRICE_TAX]		= 0;
						$aryProdOptAttrJson[$aryProdOptAttr[$i][POA_NO]]['POA_SALE_PRICE_TAX_USD']	= 0;
					}
				}
			}

			## 추가옵션
			$productMgr->setPO_TYPE("A");
			$productMgr->setP_CODE($strP_CODE);
			$aryProdOpt = $productMgr->getProdOpt($db);

			$aryProdAddOptJson = "";
			if (is_array($aryProdOpt)){
				for($i=0;$i<sizeof($aryProdOpt);$i++){
					$aryProdAddOptJson[$aryProdOpt[$i][PO_NO]][PO_NAME1]					= $aryProdOpt[$i][PO_NAME1];
					$aryProdAddOptJson[$aryProdOpt[$i][PO_NO]][PO_NAME2]					= $aryProdOpt[$i][PO_NAME2];
					$aryProdAddOptJson[$aryProdOpt[$i][PO_NO]][PO_ESS]						= $aryProdOpt[$i][PO_ESS];
				}
			}

			$aryProdAddOptAttrJson = "";
			$productMgr->setPO_NO(0);
			$aryProdAddOptAttr = $productMgr->getProdAddOpt($db);

			if (is_array($aryProdAddOptAttr)){
				for($i=0;$i<sizeof($aryProdAddOptAttr);$i++){
					$aryProdAddOptAttrJson[$aryProdAddOptAttr[$i][PAO_NO]][PAO_NO]				= $aryProdAddOptAttr[$i][PAO_NO];
					$aryProdAddOptAttrJson[$aryProdAddOptAttr[$i][PAO_NO]][PAO_NAME]			= $aryProdAddOptAttr[$i][PAO_NAME];
					$aryProdAddOptAttrJson[$aryProdAddOptAttr[$i][PAO_NO]][PAO_PRICE]			= getCurToPriceSave($aryProdAddOptAttr[$i][PAO_PRICE]);
					$aryProdAddOptAttrJson[$aryProdAddOptAttr[$i][PAO_NO]]['PAO_PRICE_USD']		= getCurToPriceSave($aryProdAddOptAttr[$i][PAO_PRICE],"US");
				}
			}

			$prodOptJson						= json_encode($aryProdOptJson);
			$prodRow							= json_encode($prodRow);
			$prodOptAttrJson					= json_encode($aryProdOptAttrJson);

			$prodAddOptJson						= json_encode($aryProdAddOptJson);
			$prodAddOptAttrJson					= json_encode($aryProdAddOptAttrJson);

			$result								= "";
			$result[0][RET]						= "Y";
			$result[0]['HTML']					= $strProdOptHtml;
			$result[0]['PROD_OPT_JSON']			= $prodOptJson;
			$result[0]['PROD_ROW_JSON']			= $prodRow;
			$result[0]['PROD_OPT_ATTR_JSON']	= $aryProdOptAttrJson;

			$result[0]['PROD_ADD_OPT_JSON']		= $prodAddOptJson;
			$result[0]['PROD_ADD_OPT_ATTR_JSON']= $prodAddOptAttrJson;

			$result_array						= json_encode($result);

		break;

		case "prodAuctionApply":

			$intAucPrice					= $_POST['aucPrice'];

			if (!$strP_CODE){
				$result						= "";
				$result[0][RET]				= "N";
				$result[0][MSG]				= $LNG_TRANS_CHAR["PS00025"];
				$result_array				= json_encode($result);
				$db->disConnect();
				echo $result_array;
				exit;
			}

			## 클래스 설정
			$objProductAuctionModule		= new ProductAuctionModule($db);

			## 로그인 체크
			if (!$g_member_no){
				$result						= "";
				$result[0][RET]				= "N";
				$result[0][MSG]				= $LNG_TRANS_CHAR["OS00014"];  //로그인을 하신 후 이용하세요.
				$result_array				= json_encode($result);
				$db->disConnect();
				echo $result_array;
				exit;
			}

			## 입찰정보
			$param							= "";
			$param['P_CODE']				= $strP_CODE;
			$param['P_LNG']					= $S_SITE_LNG;
			$param['P_AUC_STATUS']			= 2;
			$prodAucRow						= $objProductAuctionModule->getProductAuctionViewEx($param);

			if (!$prodAucRow){
				$result						= "";
				$result[0][RET]				= "N";
				$result[0][MSG]				= $LNG_TRANS_CHAR["PS00025"];
				$result_array				= json_encode($result);
				$db->disConnect();
				echo $result_array;
				exit;
			}

			## 현재최고가
			$intProdAucMaxPrice				= ($prodAucRow['P_AUC_BEST_PRICE']) ? $prodAucRow['P_AUC_BEST_PRICE'] : $prodAucRow['P_AUC_ST_PRICE'];
			$intProdAucMaxCurPrice			= getCurToPriceSave($intProdAucMaxPrice);

			## 즉시구매가
			$intProdAucRightCurPrice		= getCurToPriceSave($prodAucRow['P_AUC_RIGHT_PRICE']);

			## 단위
			$intProdAucPriceUnit			= getCurToPriceSave(1000);

			$strPriceLeftMark				= getCurMark();
			if ($strPriceLeftMark) $strPriceLeftMark .= " ";
			$strPriceRightMark				= getCurMark2();

			$strProdAucPriceUnit		    = $strPriceLeftMark.getCurToPrice(1000).$strPriceRightMark;
			$strProdAucPriceUnitStep	    = $strPriceLeftMark.getCurToPrice(1000).$strPriceRightMark;
			$strProdAucPriceUnitStep       .= ",".$strPriceLeftMark.getCurToPrice(2000).$strPriceRightMark;
			$strProdAucPriceUnitStep       .= ",".$strPriceLeftMark.getCurToPrice(3000).$strPriceRightMark;

			if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){
				$intProdAucMaxCurPrice		= getCurToPriceSave($intProdAucMaxPrice,"US");
				$intProdAucRightCurPrice	= getCurToPriceSave($prodAucRow['P_AUC_RIGHT_PRICE'],"US");
				$intProdAucPriceUnit		= getCurToPriceSave(1000,"US");

				$strPriceUsdMark			= getCurMark("USD")." ";

				$strProdAucPriceUnit		= $strPriceUsdMark.getCurToPrice(1000,"US");
				$strProdAucPriceUnitStep	= $strPriceUsdMark.getCurToPrice(1000,"US");
				$strProdAucPriceUnitStep   .= ",".$strPriceUsdMark.getFormatPrice(getCurToPriceSave(1000,"US") * 2,2);
				$strProdAucPriceUnitStep   .= ",".$strPriceUsdMark.getFormatPrice(getCurToPriceSave(1000,"US") * 3,2);
			}

			$strProdAucText					= callLangTrans($LNG_TRANS_CHAR["PS00027"],array($strProdAucPriceUnit,$strProdAucPriceUnitStep));

			## 1.현재최고가 체크
			if ($intAucPrice <= $intProdAucMaxPrice){
				$result						= "";
				$result[0][RET]				= "N";
				$result[0][MSG]				= $LNG_TRANS_CHAR["PS00028"];
				$result_array				= json_encode($result);
				$db->disConnect();
				echo $result_array;
				exit;
			}

			## 2.즉시구매가 체크
			if ($intAucPrice >= $intProdAucRightCurPrice){
				$result						= "";
				$result[0][RET]				= "N";
				$result[0][MSG]				= $LNG_TRANS_CHAR["PS00029"];
				$result_array				= json_encode($result);
				$db->disConnect();
				echo $result_array;
				exit;
			}

			## 3.단위체크
			if ($intAucPrice % $intProdAucPriceUnit != 0){
				$result						= "";
				$result[0][RET]				= "N";
				$result[0][MSG]				= $strProdAucText;
				$result_array				= json_encode($result);
				$db->disConnect();
				echo $result_array;
				exit;
			}

			## 4.금액중복확인
			$param							= "";
			$param['P_CODE']				= $strP_CODE;
			$param['P_AUC_PRICE']			= getPriceToCur($intAucPrice);
			$param['P_AUC_CUR_PRICE']		= $intAucPrice;
			$param['P_AUC_LNG']				= $S_SITE_LNG;
			$param['P_AUC_CUR']				= $S_SITE_CUR;

			## 5.이미 등록된 입찰금액이 있는지 확인
			$intAucDupCnt					= $objProductAuctionModule->getProductAuctionDupCheck($param);
			if ($intAucDupCnt > 0){
				$result						= "";
				$result[0][RET]				= "N";
				$result[0][MSG]				= $LNG_TRANS_CHAR["PS00030"];
				$result_array				= json_encode($result);
				$db->disConnect();
				echo $result_array;
				exit;
			}

			## 등록
			$param['M_NO']					= $g_member_no;
			$param['P_AUC_STATUS']			= "1";
			$intProdAucApplyNo				= $objProductAuctionModule->getProductAuctionInsertEx($param);

			if ($intProdAucApplyNo <= 0){
				$result						= "";
				$result[0][RET]				= "N";
				$result[0][MSG]				= $LNG_TRANS_CHAR["PS00031"];
				$result_array				= json_encode($result);
				$db->disConnect();
				echo $result_array;
				exit;
			}

			## 최고가 update
			$result							= $objProductAuctionModule->getProductAuctionMaxPriceUpdateEx($param);
			if (!$result){
				$result						= "";
				$result[0][RET]				= "N";
				$result[0][MSG]				= $LNG_TRANS_CHAR["PS00031"];
				$result_array				= json_encode($result);
				$db->disConnect();
				echo $result_array;
				exit;
			}

			$result							= "";
			$result[0][RET]					= "Y";
			$result[0][MSG]					= "success";
			$result_array					= json_encode($result);

		break;

		case "auctionOrder":

			/* 로그인체크 */
			if (!$g_member_no){
				$result			= "";
				$result[0][MSG] = $LNG_TRANS_CHAR["OS00014"];  //로그인을 하신 후 이용하세요.
				$result[0][RET] = "N";

				$result_array = json_encode($result);
				$db->disConnect();
				echo $result_array;
				exit;
			}

			/* 상품정보 */
			$productMgr->setP_CODE($strP_CODE);
			$prodRow = $productMgr->getProdView($db);

			if ($S_PRODUCT_AUCTION_USE != "Y"){
				$result			= "";
				$result[0][MSG] = $LNG_TRANS_CHAR["PS00025"]; //해당입찰정보가 없음
				$result[0][RET] = "N";

				$result_array = json_encode($result);
				$db->disConnect();
				echo $result_array;
				exit;
			}

			/* 경매 정보 확인 */
			if ($S_PRODUCT_AUCTION_USE == "Y")
			{
				$auctionParam				= "";
				$auctionParam['P_CODE']		= $strP_CODE;
				$prodAucRow					= $productMgr->getProdAuctionView($db,$auctionParam);

				if (!$prodAucRow){
					$result			= "";
					$result[0][MSG] = $LNG_TRANS_CHAR["PS00025"]; //해당입찰정보가 없음
					$result[0][RET] = "N";

					$result_array = json_encode($result);
					$db->disConnect();
					echo $result_array;
					exit;
				}

				if ($prodAucRow['P_AUC_STATUS'] != "2"){
					if ($prodAucRow['P_AUC_ORDER'] == "Y"){
						$result			= "";
						$result[0][MSG] = $LNG_TRANS_CHAR["PS00033"]; //해당 경매상품 종료/완료 메세지
						$result[0][RET] = "N";

						$result_array = json_encode($result);
						$db->disConnect();
						echo $result_array;
						exit;
					}
				}

				$i									= 0;
				$aryProdCartOpt[$i][NO]				= 0;
				$aryProdCartOpt[$i][NAME1]			= "";
				$aryProdCartOpt[$i][NAME2]			= "";
				$aryProdCartOpt[$i][NAME3]			= "";
				$aryProdCartOpt[$i][NAME4]			= "";
				$aryProdCartOpt[$i][NAME5]			= "";
				$aryProdCartOpt[$i][NAME6]			= "";
				$aryProdCartOpt[$i][NAME7]			= "";
				$aryProdCartOpt[$i][NAME8]			= "";
				$aryProdCartOpt[$i][NAME9]			= "";
				$aryProdCartOpt[$i][NAME10]			= "";
				$aryProdCartOpt[$i][ATTR1]			= "";
				$aryProdCartOpt[$i][ATTR2]			= "";
				$aryProdCartOpt[$i][ATTR3]			= "";
				$aryProdCartOpt[$i][ATTR4]			= "";
				$aryProdCartOpt[$i][ATTR5]			= "";
				$aryProdCartOpt[$i][ATTR6]			= "";
				$aryProdCartOpt[$i][ATTR7]			= "";
				$aryProdCartOpt[$i][ATTR8]			= "";
				$aryProdCartOpt[$i][ATTR9]			= "";
				$aryProdCartOpt[$i][ATTR10]			= "";

				$aryProdCartOpt[$i][STOCK_PRICE]	= $prodRow[P_STOCK_PRICE];
				$aryProdCartOpt[$i][POINT]			= 0;

				## 즉시구매일때는 즉시구매가/ 낙찰구매일때는 낙찰금액
				if ($prodAucRow['P_AUC_STATUS'] == "2"){
					$aryProdCartOpt[$i][PRICE]			= $prodAucRow['P_AUC_RIGHT_PRICE'];
				} else if ($prodAucRow['P_AUC_STATUS'] == "4" || $prodAucRow['P_AUC_STATUS'] == "5"){
					$aryProdCartOpt[$i][PRICE]			= $prodAucRow['P_AUC_SUC_PRICE'];
				}

				if ($g_member_no) $productMgr->setM_NO($g_member_no);

				$productMgr->setPB_KEY("");
				$productMgr->setPB_OPT_NO($aryProdCartOpt[$i][NO]);
				$productMgr->setPB_OPT_NM1($aryProdCartOpt[$i][NAME1]);
				$productMgr->setPB_OPT_NM2($aryProdCartOpt[$i][NAME2]);
				$productMgr->setPB_OPT_NM3($aryProdCartOpt[$i][NAME3]);
				$productMgr->setPB_OPT_NM4($aryProdCartOpt[$i][NAME4]);
				$productMgr->setPB_OPT_NM5($aryProdCartOpt[$i][NAME5]);
				$productMgr->setPB_OPT_NM6($aryProdCartOpt[$i][NAME6]);
				$productMgr->setPB_OPT_NM7($aryProdCartOpt[$i][NAME7]);
				$productMgr->setPB_OPT_NM8($aryProdCartOpt[$i][NAME8]);
				$productMgr->setPB_OPT_NM9($aryProdCartOpt[$i][NAME9]);
				$productMgr->setPB_OPT_NM10($aryProdCartOpt[$i][NAME10]);
				$productMgr->setPB_OPT_ATTR1($aryProdCartOpt[$i][ATTR1]);
				$productMgr->setPB_OPT_ATTR2($aryProdCartOpt[$i][ATTR2]);
				$productMgr->setPB_OPT_ATTR3($aryProdCartOpt[$i][ATTR3]);
				$productMgr->setPB_OPT_ATTR4($aryProdCartOpt[$i][ATTR4]);
				$productMgr->setPB_OPT_ATTR5($aryProdCartOpt[$i][ATTR5]);
				$productMgr->setPB_OPT_ATTR6($aryProdCartOpt[$i][ATTR6]);
				$productMgr->setPB_OPT_ATTR7($aryProdCartOpt[$i][ATTR7]);
				$productMgr->setPB_OPT_ATTR8($aryProdCartOpt[$i][ATTR8]);
				$productMgr->setPB_OPT_ATTR9($aryProdCartOpt[$i][ATTR9]);
				$productMgr->setPB_OPT_ATTR10($aryProdCartOpt[$i][ATTR10]);

				$productMgr->setPB_QTY(1);
				$productMgr->setPB_STOCK_PRICE($aryProdCartOpt[$i][STOCK_PRICE]);
				$productMgr->setPB_PRICE($aryProdCartOpt[$i][PRICE]);
				$productMgr->setPB_POINT($aryProdCartOpt[$i][POINT]);
				$productMgr->setPB_DELIVERY_TYPE("1");
				$productMgr->setPB_DELIVERY_EXP("");
				$productMgr->setPB_ADD_OPT_PRICE(0);
				$productMgr->setPB_DIRECT("Y");

				$productMgr->getProdBasketInsertUpdate($db);
				$intBasketNo = $db->getLastInsertID();

				$strCartParamList .= "<input type=\"hidden\" name=\"cartNo[]\" value=\"".$intBasketNo."\">";
				$strCartParamList .= "<input type=\"hidden\" name=\"basketDirect\" value=\"Y\">";

				$result					= "";
				$result[0][MSG]			= $strAct;
				$result[0][RET]			= "Y";
				$result[0][HTML]		= $strCartParamList;

				$result_array = json_encode($result);

			}
		break;
	}

	if(in_array($strAct, array("productListLoad", "productRelatedList"))):
		$db->disConnect();
		if(!$result) { $result = print_r($_POST, true); }
		echo json_encode($result);
		exit;
	endif;

	$db->disConnect();

	echo $result_array;


//if($strDebug):
//$result = print_r($_POST, true);
//endif;
//if($strDebug):
//$result_array = json_encode($result);
//echo $result_array;
//exit;
//endif;
?>