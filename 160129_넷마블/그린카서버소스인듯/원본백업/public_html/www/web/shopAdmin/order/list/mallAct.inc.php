<?
	require_once MALL_CONF_LIB."OrderAdmMgr.php";
	require_once MALL_CONF_LIB."ProductAdmMgr.php";
	require_once MALL_CONF_LIB."MemberAdmMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";
	require_once MALL_CONF_LIB."CouponMgr.php";

	$orderMgr = new OrderMgr();
	$productMgr = new ProductAdmMgr();
	$memberMgr = new MemberMgr();
	$siteMgr = new SiteMgr();
	$couponMgr = new CouponMgr();

	/*##################################### Parameter 셋팅 #####################################*/
	$strSearchField				= $_POST["searchField"]				? $_POST["searchField"]				: $_REQUEST["searchField"];
	$strSearchKey				= $_POST["searchKey"]				? $_POST["searchKey"]				: $_REQUEST["searchKey"];
	$strSearchDay				= $_POST["searchDay"]				? $_POST["searchDay"]				: $_REQUEST["searchDay"];

	$strSearchOrderStatus		= $_POST["searchOrderStatus"]		? $_POST["searchOrderStatus"]		: $_REQUEST["searchOrderStatus"];
	$strSearchSettleType		= $_POST["searchSettleType"]		? $_POST["searchSettleType"]		: $_REQUEST["searchSettleType"];			// 결제방법
	$strSearchMemberType		= $_POST["searchMemberType"]		? $_POST["searchMemberType"]		: $_REQUEST["searchMemberType"];			// 회원구분(전체, 회원, 비회원)
	$arySearchDeliveryCom		= $_POST["searchDeliveryCom"]		? $_POST["searchDeliveryCom"]		: $_REQUEST["searchDeliveryCom"];			// 택배회사
	if($arySearchDeliveryCom):
		$strSearchDeliveryCom	= implode($arySearchDeliveryCom, "','");
		$strSearchDeliveryCom	= "'{$strSearchDeliveryCom}'";
	endif;
	
	$strSearchRegStartDt	= $_POST["searchRegStartDt"]	? $_POST["searchRegStartDt"]	: $_REQUEST["searchRegStartDt"];
	$strSearchRegEndDt		= $_POST["searchRegEndDt"]		? $_POST["searchRegEndDt"]		: $_REQUEST["searchRegEndDt"];

	$strSearchSettleC		= $_POST["searchSettleC"]		? $_POST["searchSettleC"]		: $_REQUEST["searchSettleC"];
	$strSearchSettleA		= $_POST["searchSettleA"]		? $_POST["searchSettleA"]		: $_REQUEST["searchSettleA"];
	$strSearchSettleT		= $_POST["searchSettleT"]		? $_POST["searchSettleT"]		: $_REQUEST["searchSettleT"];
	$strSearchSettleB		= $_POST["searchSettleB"]		? $_POST["searchSettleB"]		: $_REQUEST["searchSettleB"];
	
	$intPage				= $_POST["page"]				? $_POST["page"]				: $_REQUEST["page"];
	$intO_NO				= $_POST["oNo"]					? $_POST["oNo"]					: $_REQUEST["oNo"];

	$aryChkNo				= $_POST["chkNo"]				? $_POST["chkNo"]				: $_REQUEST["chkNo"];
	$aryOrderStatus			= $_POST["orderStatus"]			? $_POST["orderStatus"]			: $_REQUEST["orderStatus"];

	$strO_DELIVERY_COM		= $_POST["deliveryCom"]			? $_POST["deliveryCom"]			: $_REQUEST["deliveryCom"];
	$strO_DELIVERY_NUM		= $_POST["deliveryNo"]			? $_POST["deliveryNo"]			: $_REQUEST["deliveryNo"];
	
	$strO_RETURN_BANK		= $_POST["returnBank"]			? $_POST["returnBank"]			: $_REQUEST["returnBank"];
	$strO_RETURN_ACC		= $_POST["returnAcc"]			? $_POST["returnAcc"]			: $_REQUEST["returnAcc"];
	$strO_RETURN_NAME		= $_POST["returnName"]			? $_POST["returnName"]			: $_REQUEST["returnName"];
	/*##################################### Parameter 셋팅 #####################################*/

	$strO_DELIVERY_COM		= strTrim($strO_DELIVERY_COM,10);
	$strO_DELIVERY_NUM		= strTrim($strO_DELIVERY_NUM,20);
	$strO_RETURN_BANK		= strTrim($strO_RETURN_BANK,10);
	$strO_RETURN_ACC		= strTrim($strO_RETURN_ACC,20);
	$strO_RETURN_NAME		= strTrim($strO_RETURN_NAME,20);
	
	$orderMgr->setO_DELIVERY_COM($strO_DELIVERY_COM);
	$orderMgr->setO_DELIVERY_NUM($strO_DELIVERY_NUM);
	$orderMgr->setO_RETURN_BANK($strO_RETURN_BANK);
	$orderMgr->setO_RETURN_ACC($strO_RETURN_ACC);
	$orderMgr->setO_RETURN_NAME($strO_RETURN_NAME);

	$siteRow = $siteMgr->getSiteInfo($db);

	$strLinkPage  = "searchField=$strSearchField&searchKey=$strSearchKey";
	$strLinkPage .= "&searchRegStartDt=$strSearchRegStartDt&searchRegEndDt=$strSearchRegEndDt";
	$strLinkPage .= "&searchSettleC=$strSearchSettleC&searchSettleA=$strSearchSettleA";
	$strLinkPage .= "&searchSettleT=$strSearchSettleT&searchSettleB=$strSearchSettleB";
	$strLinkPage .= "&searchOrderStatus=$strSearchOrderStatus";
	$strLinkPage .= "&page=$intPage";

	/* 여기에 추가되어야 함(메일관련) */
	require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/layout/mail/_config.inc.php";
	require_once $S_DOCUMENT_ROOT."www/config/mail.func.php";	
	/* 여기에 추가되어야 함(메일관련) */

	/* 여기에 추가되어야 함(문자관련) 2013.04.18 */
//	$smsConfFile = "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/smsInfo.conf.inc.php";
//	if(is_file($smsConfFile)):
//		require_once $smsConfFile;
//		require_once "{$S_DOCUMENT_ROOT}www/classes/sms/sms.func.class.php";
//		$smsFunc = new SmsFunc();
//	endif;
	/* 여기에 추가되어야 함(문자관련) 2013.04.18 */

	/*배송회사*/
	$aryDeliveryCom = getCommCodeList("DELIVERY","Y");
			
	switch ($strAct) {
		case "orderStatus":
		
			/** 2013.06.24 kim hee sung 신규 버전에서 추가됨. **/
			$arrChkNo = $_POST['chkNo'];

			if (!is_array($arrChkNo) && $intO_NO){
				$aryChkNo = array($intO_NO);
			}
			
			if (is_array($aryChkNo)){
				for($i=0;$i<sizeof($aryChkNo);$i++){
				
					if ($aryChkNo[$i] > 0){
						$intO_NO = $aryChkNo[$i];
						$orderMgr->setO_NO($intO_NO);
						
						$orderRow = $orderMgr->getOrderView($db);
						//$strOrderStatus = $aryOrderStatus[$i];
						$strOrderStatus = $_POST["orderStatus_".$intO_NO]		? $_POST["orderStatus_".$intO_NO]			: $_REQUEST["orderStatus_".$intO_NO];
	
						switch($strOrderStatus){
							case "A":
								/* 결제완료 */
								$intOrderProdNoPointUseCnt = 0; //포인트사용금지상품수

								$orderMgr->setOC_LIST_ARY("Y");
								$aryOrderCartList = $orderMgr->getOrderCartList($db);
								if (is_array($aryOrderCartList)){
									for($j=0;$j<sizeof($aryOrderCartList);$j++){
										$strProdCode  = $aryOrderCartList[$j][P_CODE];
										$intOC_OPT_NO = $aryOrderCartList[$j][OC_OPT_NO];
										$intOC_QTY    = $aryOrderCartList[$j][OC_QTY];
										
										/*
										if ($aryOrderCartList[$j][P_STOCK_LIMIT] != "Y"){
											//옵션별 수량 조절 
											if ($intOC_OPT_NO > 0){
												$productMgr->setPOA_STOCK_QTY(-$intOC_QTY);
												$productMgr->setPOA_NO($intOC_OPT_NO);
												$productMgr->getProdOptQtyUpdate($db);
											}

											//상품전체 수량 조절
											if ($strProdCode)
											{
												$productMgr->setP_QTY(-$intOC_QTY);
												$productMgr->setP_CODE($strProdCode);
												$productMgr->getProdQtyUpdate($db);
											}
										}*/

										if ($aryOrderCartList[$j]["P_POINT_NO_USE"] == "Y"){
											$intOrderProdNoPointUseCnt++;
										}
									}
								}
								
								
								/* 포인트 적립(적립금관리사용유무) */
								if ($siteRow[S_POINT_USE1] == "Y"){

									if (($orderRow[O_USE_POINT] > 0 && $siteRow[S_POINT_USE2] == "Y") || $orderRow[O_USE_POINT] == 0) {

										if ($siteRow[S_POINT_ORDER_STATUS] == "S"){
									
											/* 사용포인트가 있고 적립금 사용시 상품적립금 지급 유무(Y) , 사용포인트가 없을 경우 단(포인트지급유무 주문상태는 결제완료)*/
											if ($orderRow[O_TOT_POINT] > 0 && $orderRow[M_NO] > 0 && $orderRow[O_ADD_POINT] != "Y"){
												$memberMgr->setM_NO($orderRow[M_NO]);
												$memberMgr->setM_POINT($orderRow[O_TOT_POINT]);
												$result = $memberMgr->getMemberPointUpdate($db);
												
												/* 포인트 관리 데이터 INSERT */
												$orderMgr->setM_NO($orderRow[M_NO]);
												$orderMgr->setB_NO(0);
												$orderMgr->setPT_TYPE('002');
												$orderMgr->setPT_POINT($memberMgr->getM_POINT());
												$orderMgr->setPT_MEMO("구매포인트적립[".$orderRow[O_KEY]."]");
												$orderMgr->setPT_START_DT(date("Y-m-d"));
												$orderMgr->setPT_END_DT(date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")+$siteRow[S_POINT_USE_YEAR])));
												$orderMgr->setPT_REG_IP($S_REOMTE_ADDR);
												$orderMgr->setPT_ETC('');
												$orderMgr->setPT_REG_NO(1);
												$orderMgr->getOrderPointInsert($db);

												$orderMgr->setO_ADD_POINT("Y");
												$result = $orderMgr->getOrderAddPointUpdate($db);

												/* 포인트 히스토리 추가해야 함*/
											}
										}
									}
									/* 첫구매 포인트 지급 확인(적립금 사용시 적립금 지급 유무에 따라 지급됨) */
									if ($orderRow[M_NO] > 0 && $siteRow[S_POINT_ORDER_STATUS] == "S"){
										$memberMgr->setM_NO($orderRow[M_NO]);
										$memberOrderRow = $memberMgr->getMemberOrderCount($db);
										$intMemberOrderJumunCnt = 99999;
										if ($memberOrderRow){
											$intMemberOrderJumunCnt = $memberOrderRow[JUMUN_CNT];
											$intMemberOrderDeliveryCnt = $memberOrderRow[DELIVERY_CNT];
										}

										if ((int)$S_POINT_ORDER_GIVE > 0 && $intMemberOrderJumunCnt == 1 && $intOrderProdNoPointUseCnt == 0){
											$strOrderFirstPointGiveYN = "Y";
											if ($orderRow[O_USE_POINT] > 0 && $S_POINT_USE2 != "Y"){
												$strOrderFirstPointGiveYN = "N";
											}
											
											if ($strOrderFirstPointGiveYN == "Y"){
												$memberMgr->setM_NO($orderRow[M_NO]);
												$memberMgr->setM_POINT($S_POINT_ORDER_GIVE);
												$memberMgr->getMemberPointUpdate($db);
												
												/* 포인트 관리 데이터 INSERT */
												$orderMgr->setM_NO($orderRow[M_NO]);
												$orderMgr->setB_NO(0);
												$orderMgr->setPT_TYPE('004');
												$orderMgr->setPT_POINT($memberMgr->getM_POINT());
												$orderMgr->setPT_MEMO($LNG_TRANS_CHAR["OW00118"]."[".$orderRow["O_KEY"]."]"); //첫구매포인트적립
												$orderMgr->setPT_START_DT(date("Y-m-d"));
												$orderMgr->setPT_END_DT(date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")+$S_POINT_USE_YEAR)));
												$orderMgr->setPT_REG_IP($S_REOMTE_ADDR);
												$orderMgr->setPT_ETC('FIRST');
												$orderMgr->setPT_REG_NO(1);
												$orderMgr->getOrderPointInsert($db);
												
												/* 첫구매 여부 update */
												$orderMgr->getOrderFirstUpdate($db,"Y");
											}
										}
									}
									/* 첫구매 포인트 지급 확인(적립금 사용시 적립금 지급 유무에 따라 지급됨) */
								}
								
								
								/*사은품 수량 체크 */
								$aryOrderGiftList = $orderMgr->getOrderGiftList($db);
								if (is_array($aryOrderGiftList)){
									for($i=0;$i<sizeof($aryOrderGiftList);$i++){
										
										if ($aryOrderGiftList[$i][CG_STOCK] != "N" && $aryOrderGiftList[$i][CG_QTY] > 0){
											
											$orderMgr->setGIFT_NO($aryOrderGiftList[$i][CG_NO]);
											if ($aryOrderGiftList[$i][CG_QTY] >= $aryOrderGiftList[$i][OG_QTY])  $orderMgr->setGIFT_QTY($aryOrderGiftList[$i][OG_QTY]);
											else $orderMgr->setGIFT_QTY(0);
											$orderMgr->getOrderGiftQtyUpdate($db);
										}
									}
								}

								/* 승인데이터 INSERT */
								$orderMgr->setOS_STATUS("A");
								$orderMgr->setOS_APPR_NO($orderRow[O_APPR_NO]);
								$orderMgr->setOS_TITLE($orderRow[O_J_TITLE]);
								$orderMgr->setOS_USE_POINT($orderRow[O_USE_POINT]);
								$orderMgr->setOS_USE_COUPON($orderRow[O_USE_COUPON]);
								$orderMgr->setOS_TOT_PRICE($orderRow[O_TOT_PRICE]);
								$orderMgr->setOS_TOT_DELIVERY_PRICE($orderRow[O_TOT_DELIVERY_PRICE]);
								$orderMgr->setOS_TOT_TAX_PRICE($orderRow[O_TAX_PRICE]);
								$orderMgr->setOS_TOT_SPRICE($orderRow[O_TOT_SPRICE]);
								
								/* 적립포인트가 지급되지 않았을때에는 결제관리테이블에 적립포인트를 '0' 으로 입력 */
								if ($orderMgr->getO_ADD_POINT() == "Y") $orderMgr->setOS_TOT_POINT($orderRow[O_TOT_POINT]);	else  $orderMgr->setOS_TOT_POINT(0);	

								$orderMgr->setOS_SETTLE($orderRow[O_SETTLE]);
								$orderMgr->getOrderSettleInsert($db);

								if ($orderRow[O_SETTLE] == "B"){
									/** 메일 전송 - 입금확인(무통장 입금) **/
									$strMailSendMode = "adm";
									$strMailMode = "orderSend";
									include WEB_FRWORK_ACT."orderMailForm.inc.php";

									/** 메일 전송 - 고객 주문 취소 메일 **/
									$aryTAG_LIST['{{__받는사람이름__}}']	= $orderRow['O_J_NAME'];
									$aryTAG_LIST['{{__받는사람메일__}}']	= $orderRow['O_J_MAIL'];
									$aryTAG_LIST['{{__회원명__}}']			= $orderRow['O_J_NAME'];
									$aryTAG_LIST['{{__주문번호__}}']		= $orderRow['O_KEY'];
									$aryTAG_LIST['{{__주문상품내역__}}']	= $strOrderCartHtml;
									$aryTAG_LIST['{{__주문금액정보__}}']	= $strOrderCartPriceHtml;
									$aryTAG_LIST['{{__주문내역__}}']		= $strOrderInfoHtml;
									goSendMail("008");
									/** 메일 전송 **/



									## 2015.01.15 kim hee sung SMS 모듈 V2.0
									## 한국어 전용
									## 관리자페이지에서 SMS 사용함 설정된 경우

									## 설정파일 불러오기
									include_once rtrim(MALL_SHOP, '/') . '/conf/smsInfo.conf.inc.php';
						
									if($S_SITE_LNG == "KR" && $SMS_INFO['S_SMS_USE']=="Y"):

										## 사용자 SMS
										## 모듈 설정
										$objSmsInfo = new SmsInfo($db);

										## 코드 설정
										$strSmsCode = "010"; // 010 입금확인(고객용)


										if($SMS_TEXT_LIST && $SMS_TEXT_LIST[$strSmsCode] && $SMS_TEXT_LIST[$strSmsCode]['SM_AUTO'] == "Y"):

											## 문자 설정
											$strSmsMsg			= $SMS_TEXT_LIST[$strSmsCode]['SM_TEXT'];
											$strSmsMsg			= str_replace("{{상점명}}", $S_SITE_KNAME, $strSmsMsg);
											$strSmsMsg			= str_replace("{{결제금액}}", getCurToPrice($orderRow['O_TOT_CUR_SPRICE'],$orderRow['O_USE_LNG']), $strSmsMsg);

											## SMS 전송
											$param = '';
											$param['phone']			= $orderRow['O_J_HP'];		
											$param['callBack']		= $S_COM_PHONE;	
											$param['msg']			= $strSmsMsg;
											$param['siteName']		= $S_SITE_KNAME;
											$objSmsInfo->goSendSms($param);

										endif;

										## 관리자 SMS
										## 필요시 추가하세요..

									endif;

									/** 2013.04.18 SMS 전송 모듈 추가 **/
									## SMS 사용 , 한국어 페이지 인 경우 SMS 전송 실행
//									if($SMS_INFO['S_SMS_USE']=="Y" && $orderRow['O_USE_LNG'] == "KR"):
//										$smsMoney = $smsFunc->getSmsMoneySelect($db); // 머니 체크
//										if($smsMoney['VAL'] > 0):
//											$smsCode			= "010";
//											$smsPhone			= str_replace("-","",$orderRow['O_J_HP']);		
//											$smsCallBackPhone	= $S_COM_PHONE;
//											$smsMsg				= $SMS_TEXT_LIST[$smsCode]['SM_TEXT'];
//											$smsMsg				= str_replace("{{상점명}}", $S_SITE_KNAME, $smsMsg);
//											$smsMsg				= str_replace("{{결제금액}}", getCurToPrice($orderRow['O_TOT_CUR_SPRICE'],$orderRow['O_USE_LNG']), $smsMsg);
//											if($SMS_TEXT_LIST[$smsCode]['SM_AUTO'] == "Y"): //  자동발송 사용..
//												$smsFunc->goSendSms($smsPhone, $smsCallBackPhone, $smsMsg);
//												$smsFunc->getSmsMoneyMinusUpdate($db); // 머니 -1
//											endif;
//										else:
//											// sms 머니 부족.. 부분 처리..
//										endif;
//									endif;
									/** 2013.04.18 SMS 전송 모듈 추가 **/

								}
								
							break;

							case "B":
								//배송준비중


							break;

							case "I":
								//배송중
								/** 메일 전송 - 배송중 **/
								$strMailSendMode = "adm";
								$strMailMode = "orderSend";
								include WEB_FRWORK_ACT."orderMailForm.inc.php";

								/** 메일 전송 - 고객 주문 취소 메일 **/
								$aryTAG_LIST['{{__받는사람이름__}}']	= $orderRow['O_J_NAME'];
								$aryTAG_LIST['{{__받는사람메일__}}']	= $orderRow['O_J_MAIL'];
								$aryTAG_LIST['{{__회원명__}}']			= $orderRow['O_J_NAME'];
								$aryTAG_LIST['{{__주문번호__}}']		= $orderRow['O_KEY'];
								$aryTAG_LIST['{{__주문상품내역__}}']	= $strOrderCartHtml;
								$aryTAG_LIST['{{__주문금액정보__}}']	= $strOrderCartPriceHtml;
								$aryTAG_LIST['{{__주문내역__}}']		= $strOrderInfoHtml;
								goSendMail("013");
								/** 메일 전송 **/
							break;

							case "D":
								
								// 배송완료
								$intOrderProdNoPointUseCnt = 0; //포인트사용금지상품수
								$orderMgr->setOC_LIST_ARY("Y");
								$aryOrderCartList = $orderMgr->getOrderCartList($db);
								if (is_array($aryOrderCartList)){
									for($j=0;$j<sizeof($aryOrderCartList);$j++){
										if ($aryOrderCartList[$j]["P_POINT_NO_USE"] == "Y"){
											$intOrderProdNoPointUseCnt++;
										}
									}
								}
								
								/* 적립금 지급 유무 상태가 배송완료일때 */

								/* 포인트 적립(적립금관리사용유무) */
								if ($siteRow[S_POINT_USE1] == "Y"){

									if (($orderRow[O_USE_POINT] > 0 && $siteRow[S_POINT_USE2] == "Y") || $orderRow[O_USE_POINT] == 0) {

										if ($siteRow[S_POINT_ORDER_STATUS] == "D"){
									
											/* 사용포인트가 있고 적립금 사용시 상품적립금 지급 유무(Y) , 사용포인트가 없을 경우 단(포인트지급유무 주문상태는 결제완료)*/
											if ($orderRow[O_TOT_POINT] > 0 && $orderRow[M_NO] > 0 && $orderRow[O_ADD_POINT] != "Y"){
												$memberMgr->setM_NO($orderRow[M_NO]);
												$memberMgr->setM_POINT($orderRow[O_TOT_POINT]);
												$result = $memberMgr->getMemberPointUpdate($db);
												
												/* 포인트 관리 데이터 INSERT */
												$orderMgr->setM_NO($orderRow[M_NO]);
												$orderMgr->setB_NO(0);
												$orderMgr->setPT_TYPE('002');
												$orderMgr->setPT_POINT($memberMgr->getM_POINT());
												$orderMgr->setPT_MEMO("구매포인트적립[".$orderRow[O_KEY]."]");
												$orderMgr->setPT_START_DT(date("Y-m-d"));
												$orderMgr->setPT_END_DT(date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")+$siteRow[S_POINT_USE_YEAR])));
												$orderMgr->setPT_REG_IP($S_REOMTE_ADDR);
												$orderMgr->setPT_ETC('');
												$orderMgr->setPT_REG_NO(1);
												$orderMgr->getOrderPointInsert($db);

												$orderMgr->setO_ADD_POINT("Y");
												$result = $orderMgr->getOrderAddPointUpdate($db);

												/* 포인트 히스토리 추가해야 함*/
											}
										}
									}
									
									
									/* 첫구매 포인트 지급 확인(적립금 사용시 적립금 지급 유무에 따라 지급됨) */
									if ($orderRow[M_NO] > 0 && $siteRow[S_POINT_ORDER_STATUS] == "D"){
										
										$memberMgr->setM_NO($orderRow[M_NO]);
										$memberOrderRow = $memberMgr->getMemberOrderCount($db);
										$intMemberOrderJumunCnt = 99999;
										if ($memberOrderRow){
											$intMemberOrderJumunCnt = $memberOrderRow[JUMUN_CNT];
											$intMemberOrderDeliveryCnt = $memberOrderRow[DELIVERY_CNT];
										}
										
										if ((int)$S_POINT_ORDER_GIVE > 0 && $intMemberOrderJumunCnt == 1 && $intOrderProdNoPointUseCnt == 0){
											$strOrderFirstPointGiveYN = "Y";
											if ($orderRow[O_USE_POINT] > 0 && $S_POINT_USE2 != "Y"){
												$strOrderFirstPointGiveYN = "N";
											}
											
											if ($strOrderFirstPointGiveYN == "Y"){
												$memberMgr->setM_NO($orderRow[M_NO]);
												$memberMgr->setM_POINT($S_POINT_ORDER_GIVE);
												$memberMgr->getMemberPointUpdate($db);
												
												/* 포인트 관리 데이터 INSERT */
												$orderMgr->setM_NO($orderRow[M_NO]);
												$orderMgr->setB_NO(0);
												$orderMgr->setPT_TYPE('004');
												$orderMgr->setPT_POINT($memberMgr->getM_POINT());
												$orderMgr->setPT_MEMO($LNG_TRANS_CHAR["OW00118"]."[".$orderRow["O_KEY"]."]"); //첫구매포인트적립
												$orderMgr->setPT_START_DT(date("Y-m-d"));
												$orderMgr->setPT_END_DT(date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")+$S_POINT_USE_YEAR)));
												$orderMgr->setPT_REG_IP($S_REOMTE_ADDR);
												$orderMgr->setPT_ETC('FIRST');
												$orderMgr->setPT_REG_NO(1);
												$orderMgr->getOrderPointInsert($db);
												
												/* 첫구매 여부 update */
												$orderMgr->getOrderFirstUpdate($db,"Y");
											}
										}
									}
									/* 첫구매 포인트 지급 확인(적립금 사용시 적립금 지급 유무에 따라 지급됨) */
								}
								
								/* 적립금 지급 유무 상태가 배송완료일때 */

								/* AGS 결제이고 에스크로 결제일때 */
								if ($orderRow['O_PG'] == "A" && $orderRow['O_ESCROW'] == "Y"){
									$TrCode = "E100";
									$userPage = "A";
									include MALL_HOME."/web/frwork/act/agsPay/AGS_escrow_ing.php";
								}
								/* AGS 결제이고 에스크로 결제일때 */
								
								
							break;

							case "E":	
								
								/* 구매 완료시 쿠폰 자동발급 데이터가 있으면 회원일때 쿠폰 발급 */
								if ($orderRow[M_NO] > 0){
									$couponMgr->setSearchCouponIssue("4");
									$couponMgr->setSearchCouponUse("Y");			
									$intCouponTotal = $couponMgr->getCouponTotal($db);
									$couponMgr->setLimitFirst(0);
									$couponMgr->setPageLine($intCouponTotal);
									
									if ($intCouponTotal > 0){
										$couponRet = $couponMgr->getCouponList($db);
										while($couponRow = mysql_fetch_array($couponRet)){
											$couponMgr->setCU_NO($couponRow[CU_NO]);

											$strCouponCode = $couponRow[CU_NO].strtoupper(getCode(10));
											$couponMgr->setCI_CODE($strCouponCode);
											$intDupCnt = $couponMgr->getCouponCodeDupCnt($db);
											if ($intDupCnt > 0){
												$strFlag = false;

												while($strFlag == false){

													$strCouponCode = $couponRow[CU_NO].strtoupper(getCode(10));
													$couponMgr->setCI_CODE($strCouponCode);
													$intDupCnt = $couponMgr->getCouponCodeDupCnt($db);
													
													if($intDupKeyCnt=="0"){
														$strFlag = true;
														break;
													}
												}
											}
											
											$couponMgr->setCU_NO($couponRow[CU_NO]);
											$couponMgr->setM_NO($orderRow[M_NO]);
											$couponMgr->setCI_REG_NO($a_admin_no);
											$couponMgr->getIssueInsert($db);
										}
									}
								}
								/* 구매 완료시 쿠폰 자동발급 데이터가 있으면 회원일때 쿠폰 발급 */

							break;

							case "R":
								//반품완료
							break;

							case "T":
								//환불완료


								## 2015.01.15 kim hee sung SMS 모듈 V2.0
								## 한국어 전용
								## 관리자페이지에서 SMS 사용함 설정된 경우

								## 설정파일 불러오기
								include_once rtrim(MALL_SHOP, '/') . '/conf/smsInfo.conf.inc.php';
					
								if($S_SITE_LNG == "KR" && $SMS_INFO['S_SMS_USE']=="Y"):

									## 사용자 SMS
									## 모듈 설정
									$objSmsInfo = new SmsInfo($db);

									## 코드 설정
									$strSmsCode = "018"; // 018 환불완료(고객용)


									if($SMS_TEXT_LIST && $SMS_TEXT_LIST[$strSmsCode] && $SMS_TEXT_LIST[$strSmsCode]['SM_AUTO'] == "Y"):

										## 문자 설정
										$strSmsMsg			= $SMS_TEXT_LIST[$strSmsCode]['SM_TEXT'];
										$strSmsMsg			= str_replace("{{상점명}}", $S_SITE_KNAME, $strSmsMsg);
										$strSmsMsg			= str_replace("{{고객명}}", $orderRow['O_J_NAME'], $strSmsMsg);

										## SMS 전송
										$param = '';
										$param['phone']			= $orderRow['O_J_HP'];		
										$param['callBack']		= $S_COM_PHONE;	
										$param['msg']			= $strSmsMsg;
										$param['siteName']		= $S_SITE_KNAME;
										$objSmsInfo->goSendSms($param);

									endif;

									## 관리자 SMS
									## 필요시 추가하세요..

								endif;

								/** 2013.04.18 SMS 전송 모듈 추가 **/
								## SMS 사용 , 한국어 페이지 인 경우 SMS 전송 실행
//								if($SMS_INFO['S_SMS_USE']=="Y" && $orderRow['O_USE_LNG'] == "KR"):
//									$smsMoney = $smsFunc->getSmsMoneySelect($db); // 머니 체크
//									if($smsMoney['VAL'] > 0):
//										$smsCode			= "018";
//										$smsPhone			= str_replace("-","",$orderRow['O_J_HP']);		
//										$smsCallBackPhone	= $S_COM_PHONE;
//										$smsMsg				= $SMS_TEXT_LIST[$smsCode]['SM_TEXT'];
//										$smsMsg				= str_replace("{{상점명}}", $S_SITE_KNAME, $smsMsg);
//										$smsMsg				= str_replace("{{고객명}}", $orderRow['O_J_NAME'], $smsMsg);
//
//										if($SMS_TEXT_LIST[$smsCode]['SM_AUTO'] == "Y"): //  자동발송 사용..
//											$smsFunc->goSendSms($smsPhone, $smsCallBackPhone, $smsMsg);
//											$smsFunc->getSmsMoneyMinusUpdate($db); // 머니 -1
//										endif;
//									else:
//										// sms 머니 부족.. 부분 처리..
//									endif;
//								endif;
								/** 2013.04.18 SMS 전송 모듈 추가 **/							
							break;

						}

						/*주문상태변경*/
						$orderMgr->setO_STATUS($strOrderStatus);
						$orderMgr->getOrderStatusUpdate($db);
						
						/* 구매건수 , 구매금액 업데이트 */
						if ($orderRow['M_NO']){
							$memberMgr->setM_NO($orderRow['M_NO']);					// 회원번호
							$memberMgr->getMemberBuyUpdate($db);
						}
						/* 구매건수 , 구매금액 업데이트 */
						
					}
				}
			}
						
			$strUrl = "./?menuType=".$strMenuType."&mode=list&".$strLinkPage;
		break;

		case "orderDelvieryIinput":

			$orderMgr->setO_NO($intO_NO);
			$orderRow = $orderMgr->getOrderView($db);
			$deli_corp	= $aryDeliveryCom[$strO_DELIVERY_COM];
			
			if ($orderRow[O_ESCROW] == "Y"){
				
				switch ($orderRow[O_PG]){
					case "K":
						
						$tno		= $orderRow[O_APPR_NO];
						$req_tx		= "mod_escrow";
						$mod_type	= "STE1";
						$deli_corp	= $aryDeliveryCom[$strO_DELIVERY_COM];
						$deli_numb	= $strO_DELIVERY_NUM;

						include MALL_HOME."/web/frwork/act/pp_ax_hub_adm.php";
					
						if ($res_cd == "0000" && $bSucc == "false"){
							$db->disConnect();
							goErrMsg($LNG_TRANS_CHAR["OS00005"]); //배송정보 입력 중 에러가 발생하였습니다.
							exit;
						}
					break;
				}
			}

			$orderMgr->getOrderDeliveryUpdate($db);

			$strMsg = $LNG_TRANS_CHAR["OS00006"]; //배송정보가 변경되었습니다.
			$strUrl = "./?menuType=".$strMenuType."&mode=popOrderDeliveryInput&no=".$intO_NO;
			
			if ($orderRow[O_STATUS] != "I"){
				/** 메일 전송 - 배송중 **/
				$strMailSendMode = "adm";
				$strMailMode = "orderSend";
				include WEB_FRWORK_ACT."orderMailForm.inc.php";

				/** 메일 전송 - 고객 주문 취소 메일 **/
				$aryTAG_LIST['{{__받는사람이름__}}']	= $orderRow['O_J_NAME'];
				$aryTAG_LIST['{{__받는사람메일__}}']	= $orderRow['O_J_MAIL'];
				$aryTAG_LIST['{{__회원명__}}']			= $orderRow['O_J_NAME'];
				$aryTAG_LIST['{{__주문번호__}}']		= $orderRow['O_KEY'];
				$aryTAG_LIST['{{__주문상품내역__}}']	= $strOrderCartHtml;
				$aryTAG_LIST['{{__주문금액정보__}}']	= $strOrderCartPriceHtml;
				$aryTAG_LIST['{{__주문내역__}}']		= $strOrderInfoHtml;
				$aryTAG_LIST['{{__배송사__}}']			= $deli_corp;
				$aryTAG_LIST['{{__운송장번호__}}']		= $strO_DELIVERY_NUM;
				
				goSendMail("013");
				/** 메일 전송 **/


				## 2015.01.15 kim hee sung SMS 모듈 V2.0
				## 한국어 전용
				## 관리자페이지에서 SMS 사용함 설정된 경우

				## 설정파일 불러오기
				include_once rtrim(MALL_SHOP, '/') . '/conf/smsInfo.conf.inc.php';
	
				if($S_SITE_LNG == "KR" && $SMS_INFO['S_SMS_USE']=="Y"):

					## 사용자 SMS
					## 모듈 설정
					$objSmsInfo = new SmsInfo($db);

					## 코드 설정
					$strSmsCode = "020"; // 020 배송완료(고객용)


					if($SMS_TEXT_LIST && $SMS_TEXT_LIST[$strSmsCode] && $SMS_TEXT_LIST[$strSmsCode]['SM_AUTO'] == "Y"):

						## 문자 설정
						$strSmsMsg			= $SMS_TEXT_LIST[$strSmsCode]['SM_TEXT'];
						$strSmsMsg			= str_replace("{{상점명}}", $S_SITE_KNAME, $strSmsMsg);
						$strSmsMsg			= str_replace("{{배송사}}", $deli_corp, $strSmsMsg);
						$strSmsMsg			= str_replace("{{운송장번호}}", $strO_DELIVERY_NUM, $strSmsMsg);

						## SMS 전송
						$param = '';
						$param['phone']			= $orderRow['O_J_HP'];		
						$param['callBack']		= $S_COM_PHONE;	
						$param['msg']			= $strSmsMsg;
						$param['siteName']		= $S_SITE_KNAME;
						$objSmsInfo->goSendSms($param);

					endif;

					## 관리자 SMS
					## 필요시 추가하세요..

				endif;

				/** 2013.04.18 SMS 전송 모듈 추가 **/
				## SMS 사용 , 한국어 페이지 인 경우 SMS 전송 실행
//				if($SMS_INFO['S_SMS_USE']=="Y" && $orderRow['O_USE_LNG'] == "KR"):
//					$smsMoney = $smsFunc->getSmsMoneySelect($db); // 머니 체크
//					if($smsMoney['VAL'] > 0):
//						$smsCode			= "020";
//						$smsPhone			= str_replace("-","",$orderRow['O_J_HP']);		
//						$smsCallBackPhone	= $S_COM_PHONE;
//						$smsMsg				= $SMS_TEXT_LIST[$smsCode]['SM_TEXT'];
//						$smsMsg				= str_replace("{{상점명}}", $S_SITE_KNAME, $smsMsg);
//						$smsMsg				= str_replace("{{배송사}}", $deli_corp, $smsMsg);
//						$smsMsg				= str_replace("{{운송장번호}}", $strO_DELIVERY_NUM, $smsMsg);
//						if($SMS_TEXT_LIST[$smsCode]['SM_AUTO'] == "Y"): //  자동발송 사용..
//							$smsFunc->goSendSms($smsPhone, $smsCallBackPhone, $smsMsg);
//							$smsFunc->getSmsMoneyMinusUpdate($db); // 머니 -1
//						endif;
//					else:
//						// sms 머니 부족.. 부분 처리..
//					endif;
//				endif;
				/** 2013.04.18 SMS 전송 모듈 추가 **/
			}

		break;

		case "orderCancel":

			
			$intO_NO		= $_POST["oNo"]				? $_POST["oNo"]				: $_REQUEST["oNo"];
			$orderMgr->setO_NO($intO_NO);
			$orderRow = $orderMgr->getOrderView($db);
			
			/* 무통장 입금 취소 */
			if ($orderRow[O_SETTLE] == "B" || $orderRow[O_SETTLE] == "P")
			{
				/* 무통장 입금 취소시에는 주문완료/입금확인중/결제완료시에만 취소가 가능하다
				   그 외에는 관리자에게 취소 문의를 해야하면 결제완료시 취소시에는 환불계좌를 받아
				   입금 후 취소처리를 완료를 해주어야 취소완료가 된다
				*/
				$strOrderSettleCelNo = "C".date("Ymd").STRTOUPPER(getCode(5));
				$orderMgr->setO_CEL_NO($strOrderSettleCelNo);
				$orderMgr->setO_STATUS("C");
				$intDupCelNoCnt = $orderMgr->getOrderDupCancelNo($db);
			
				if ($intDupCelNoCnt > 0){
					$strFlag = false;

					while($strFlag == false){

						$strOrderSettleCelNo = "C".date("Ymd").STRTOUPPER(getCode(5));
						$orderMgr->setO_CEL_NO($strOrderSettleCelNo);
						$intDupCelNoCnt = $orderMgr->getOrderDupCancelNo($db);
						
						if($intDupCelNoCnt=="0"){
							$strFlag = true;
							break;
						}
					}			
				}

				$orderMgr->setO_CEL_NO($strOrderSettleCelNo);
				$orderMgr->setO_CEL_MEMO($_POST["mod_desc"]);
				$orderMgr->setO_RETURN_BANK($_POST[ "returnBank"      ]);
				$orderMgr->setO_RETURN_ACC($_POST[ "returnAcc" ]);
				$orderMgr->setO_RETURN_NAME($_POST[ "returnName"      ]);
				
				if ($orderRow[O_STATUS] == "J" || $orderRow[O_STATUS] == "O") {
					/* 입금전은 바로 취소 */
					$mod_type = "9999";
					$orderMgr->setO_CEL_STATUS("Y");

					$orderMgr->setOS_APPR_NO($orderRow[O_APPR_NO]);
					$orderMgr->setOS_STATUS("C");
					$orderMgr->setOS_TITLE($orderRow[O_J_TITLE]);
					$orderMgr->setOS_USE_POINT($orderRow[O_USE_POINT]);
					$orderMgr->setOS_USE_COUPON($orderRow[O_USE_COUPON]);
					$orderMgr->setOS_TOT_PRICE($orderRow[O_TOT_PRICE]);
					$orderMgr->setOS_TOT_DELIVERY_PRICE($orderRow[O_TOT_DELIVERY_PRICE]);
					$orderMgr->setOS_TOT_TAX_PRICE($orderRow[O_TAX_PRICE]);
					$orderMgr->setOS_TOT_SPRICE($orderRow[O_TOT_SPRICE]);
					if ($orderMgr->getO_ADD_POINT() == "Y") $orderMgr->setOS_TOT_POINT($orderRow[O_TOT_POINT]);				
					else  $orderMgr->setOS_TOT_POINT(0);
					$orderMgr->setOS_SETTLE($orderRow[O_SETTLE]);
					$orderMgr->getOrderSettleInsert($db);

					$orderMgr->setOS_CEL_NO($strOrderSettleCelNo);
					$orderMgr->getOrderSettleUpdate($db);

					/* 사용포인트 적립 복원*/
					if ($orderRow[O_USE_POINT] > 0){
						$memberMgr->setM_NO($orderRow[M_NO]);
						$memberMgr->setM_POINT($orderRow[O_USE_POINT]);
						$memberMgr->getMemberPointUpdate($db);

						/* 포인트 관리 데이터 INSERT */
						$orderMgr->setM_NO($orderRow[M_NO]);
						$orderMgr->setB_NO(0);
						$orderMgr->setPT_TYPE('003');
						$orderMgr->setPT_POINT($memberMgr->getM_POINT());
						$orderMgr->setPT_MEMO("포인트사용취소[".$orderRow[O_KEY]."]");
						$orderMgr->setPT_START_DT(date("Y-m-d"));
						$orderMgr->setPT_END_DT(date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")+$siteRow[S_POINT_USE_YEAR])));
						$orderMgr->setPT_REG_IP($S_REOMTE_ADDR);
						$orderMgr->setPT_ETC('');
						$orderMgr->setPT_REG_NO(1);
						$orderMgr->getOrderPointInsert($db);

						/* 포인트 히스토리 추가해야 함*/
					}

					/* 쿠폰 사용 복원 */
					if ($orderRow[O_USE_COUPON] > 0){
						$orderMgr->getOrderCouponUseCancelUpdate($db);
					}

				} else if ($orderRow[O_STATUS] == "A"){
					/* 입금 후이고 배송전이로 바로 취소지만 이미 지급된 포인트 및 상품갯수는 다시 update */
					$orderMgr->setO_CEL_STATUS("Y");
					$mod_type = "STSC";

				} else {
					/* 상품은 반품 받은 후 확인 후 취소처리 */
					$mod_type = "STE3";
					$orderMgr->setO_CEL_STATUS("N");

					$orderMgr->setOS_APPR_NO($orderRow[O_APPR_NO]);
					$orderMgr->setOS_CEL_NO($strOrderSettleCelNo);
					$orderMgr->getOrderSettleUpdate($db);
				}
				$orderMgr->getOrderCancelUpdate($db);

				$orderRow[O_CEL_NO] = $strOrderSettleCelNo;
			} else {
				
				if ($orderRow[O_ESCROW] != "Y") {

					$req_tx = "mod";
					$mod_type = "STSC";
						
					if ($orderRow[O_STATUS] == "J" || $orderRow[O_STATUS] == "O" || $orderRow[O_STATUS] == "A") {
						
						/* ASG 결제이면서 계좌이체/가상계좌이체-> 바로취소가 되지 않음*/
						if ($orderRow['O_PG'] == "A" && ($orderRow['O_SETTLE'] == "A" || $orderRow['O_SETTLE'] == "T")){
							$mod_type = "STE3";
						}

					} else {
						$mod_type = "STE3";
					}
					
					if ($mod_type == "STE3"){
						$strOrderSettleCelNo = "C".date("Ymd").STRTOUPPER(getCode(5));
						$orderMgr->setO_CEL_NO($strOrderSettleCelNo);
						$orderMgr->setO_STATUS("C");
						$intDupCelNoCnt = $orderMgr->getOrderDupCancelNo($db);
					
						if ($intDupCelNoCnt > 0){
							$strFlag = false;

							while($strFlag == false){

								$strOrderSettleCelNo = "C".date("Ymd").STRTOUPPER(getCode(5));
								$orderMgr->setO_CEL_NO($strOrderSettleCelNo);
								$intDupCelNoCnt = $orderMgr->getOrderDupCancelNo($db);
								
								if($intDupCelNoCnt=="0"){
									$strFlag = true;
									break;
								}
							}			
						}
						
						$orderMgr->setO_CEL_NO($strOrderSettleCelNo);
						$orderMgr->setO_CEL_MEMO($_POST["mod_desc"]);
						$orderMgr->setO_RETURN_BANK($_POST[ "returnBank"      ]);
						$orderMgr->setO_RETURN_ACC($_POST[ "returnAcc" ]);
						$orderMgr->setO_RETURN_NAME($_POST[ "returnName"      ]);
						$orderMgr->setO_CEL_STATUS("N");
						$orderMgr->getOrderCancelUpdate($db);

						$orderMgr->setOS_APPR_NO($orderRow[O_APPR_NO]);
						$orderMgr->setOS_CEL_NO($strOrderSettleCelNo);
						$orderMgr->getOrderSettleUpdate($db);
						
						$mod_type = "STE3";
					}
					
				} else {
				
					/* KCP 연동 */
					if ($orderRow[O_STATUS] == "J" || $orderRow[O_STATUS] == "O" || $orderRow[O_STATUS] == "A" ){
						
						/*즉시취소*/
						$req_tx = "mod_escrow";
						$mod_type = "STE2";
						
						if ($orderRow[O_SETTLE] == "T" || $orderRow[O_SETTLE] == "A"){
							if ($orderRow[O_STATUS] != "A" && $orderRow['O_PG'] == "K"){
								$mod_type = "STE5"; //->입금전 구매취소
							}
						}
					
					} else if ($orderRow[O_STATUS] == "B" || $orderRow[O_STATUS] == "I" || $orderRow[O_STATUS] == "D") {
						
						/*정산보류(배송준비중/배송중/배송완료/구매취소)*/
						$req_tx = "mod_escrow";
						$mod_type = "STE3";

						if ($orderRow[O_SETTLE] == "T" || $orderRow[O_SETTLE] == "A") $vcnt_yn = "Y";
					
					} else {
						
						/* 취소 */
						$req_tx = "mod_escrow";
						$mod_type = "STE4";

						if ($orderRow[O_SETTLE] == "T" || $orderRow[O_SETTLE] == "A") $vcnt_yn = "Y";
					}
				}
				
				$tno = $orderRow[O_APPR_NO];
				if ($req_tx){
					switch ($orderRow[O_PG]){
						case "K":
							include MALL_HOME."/web/frwork/act/pp_ax_hub_adm.php";
							
							if ($res_cd != "0000" || $bSucc == "false"){
								$db->disConnect();
								goErrMsg($LNG_TRANS_CHAR["OS00007"]); //주문취소 중 에러가 발생하였습니다.
								exit;
							}
						break;

						case "A":
							$userPage = "A";

							if ($orderRow['O_SETTLE'] == "C"){
								include MALL_HOME."/web/frwork/act/agsPay/AGS_cancel_ing.php";
							} else {
								/* 에스크로 결제(STE2: 결제후취소/STE5:결제전취소)*/
								if ($orderRow['O_ESCROW'] == "Y" && ($mod_type == "STE2" || $mod_type == "STE5"))
								{
									$TrCode = "E400";
									
									include MALL_HOME."/web/frwork/act/agsPay/AGS_escrow_ing.php";
								}
							}

							if ($res_cd != "0000" || $bSucc == "false"){
								$db->disConnect();
								goErrMsg($LNG_TRANS_CHAR["OS00007"]); //주문취소 중 에러가 발생하였습니다.
								exit;
							}
						break;						
					}
				}

			}

			/* 신용카드,무통장입금 취소/ 즉시취소 */
			if ($mod_type != "9999" && $mod_type != "STE3")
			{
				$orderMgr->setOC_LIST_ARY("Y");
				$aryOrderCartList = $orderMgr->getOrderCartList($db);
				
				/* 결제완료된 주문인지 아닌지 확인 */
				$orderMgr->setOS_APPR_NO($orderRow[O_APPR_NO]);
				$intOrderSettleCount = $orderMgr->getOrderDupApprNo($db);
				
				if ($intOrderSettleCount == 1){
					if (is_array($aryOrderCartList)){
						for($j=0;$j<sizeof($aryOrderCartList);$j++){
							$strProdCode  = $aryOrderCartList[$j][P_CODE];
							$intOC_OPT_NO = $aryOrderCartList[$j][OC_OPT_NO];
							$intOC_QTY    = $aryOrderCartList[$j][OC_QTY];
							
							if ($aryOrderCartList[$j][P_STOCK_LIMIT] != "Y"){
								/* 옵션별 수량 조절 */
								if ($intOC_OPT_NO > 0){
									$productMgr->setPOA_STOCK_QTY($intOC_QTY);
									$productMgr->setPOA_NO($intOC_OPT_NO);
									$productMgr->getProdOptQtyUpdate($db);
								}

								/* 상품전체 수량 조절 */
								if ($strProdCode)
								{
									$productMgr->setP_QTY($intOC_QTY);
									$productMgr->setP_CODE($strProdCode);
									$productMgr->getProdQtyUpdate($db);
								}
							}
						}
					}

					/* 포인트 적립 취소 */
					if ($orderRow[O_TOT_POINT] > 0 && $orderRow[M_NO] > 0 && $orderRow[O_ADD_POINT] == "Y"){
						$memberMgr->setM_NO($orderRow[M_NO]);
						$memberMgr->setM_POINT(-$orderRow[O_TOT_POINT]);
						$memberMgr->getMemberPointUpdate($db);

						/* 포인트 히스토리 추가해야 함*/
						/* 포인트 관리 데이터 INSERT */
						$orderMgr->setM_NO($orderRow[M_NO]);
						$orderMgr->setB_NO(0);
						$orderMgr->setPT_TYPE('009');
						$orderMgr->setPT_POINT($memberMgr->getM_POINT());
						$orderMgr->setPT_MEMO("포인트사용취소[".$orderRow[O_KEY]."]");
						$orderMgr->setPT_START_DT(date("Y-m-d"));
						$orderMgr->setPT_END_DT(date("Y-m-d"));
						$orderMgr->setPT_REG_IP($S_REOMTE_ADDR);
						$orderMgr->setPT_ETC('');
						$orderMgr->setPT_REG_NO(1);
						$orderMgr->getOrderPointInsert($db);
					}

					/* 첫상품구매 포인트 적립 취소 */
					if ($orderRow[O_FIRST_YN] == "Y"){
						$orderMgr->setM_NO($orderRow[M_NO]);
						$intOrderFirstPoint = $orderMgr->getOrderFirstPoint($db);
						if ($intOrderFirstPoint > 0){
							$memberMgr->setM_NO($orderRow[M_NO]);
							$memberMgr->setM_POINT(-$intOrderFirstPoint);
							$memberMgr->getMemberPointUpdate($db);

							/* 포인트 히스토리 추가해야 함*/
							/* 포인트 관리 데이터 INSERT */
								$orderMgr->setM_NO($orderRow[M_NO]);
								$orderMgr->setB_NO(0);
								$orderMgr->setPT_TYPE('005');
								$orderMgr->setPT_POINT($memberMgr->getM_POINT());
								$orderMgr->setPT_MEMO($LNG_TRANS_CHAR["OW00119"]."[".$orderRow[O_KEY]."]"); //구매포인트적립취소
								$orderMgr->setPT_START_DT(date("Y-m-d"));
								$orderMgr->setPT_END_DT(date("Y-m-d"));
								$orderMgr->setPT_REG_IP($S_REOMTE_ADDR);
								$orderMgr->setPT_ETC('');
								$orderMgr->setPT_REG_NO(1);
								$orderMgr->getOrderPointInsert($db);
							/* 포인트 관리 데이터 INSERT */
						}
					}

				}  else {

					/* 가상계좌일 경우*/
					if ($orderRow[O_SETTLE] == "T" && $intOrderSettleCount == 0){
						
						$orderMgr->setM_NO($orderRow[M_NO]);
						$orderMgr->setOS_APPR_NO($orderRow[O_APPR_NO]);
						$orderMgr->setOS_STATUS("C");
						$orderMgr->setOS_TITLE($orderRow[O_J_TITLE]);
						$orderMgr->setOS_USE_POINT($orderRow[O_USE_POINT]);
						$orderMgr->setOS_USE_COUPON($orderRow[O_USE_COUPON]);
						$orderMgr->setOS_TOT_PRICE($orderRow[O_TOT_PRICE]);
						$orderMgr->setOS_TOT_DELIVERY_PRICE($orderRow[O_TOT_DELIVERY_PRICE]);
						$orderMgr->setOS_TOT_TAX_PRICE($orderRow[O_TAX_PRICE]);
						$orderMgr->setOS_TOT_SPRICE($orderRow[O_TOT_SPRICE]);
						if ($orderMgr->getO_ADD_POINT() == "Y") $orderMgr->setOS_TOT_POINT($orderRow[O_TOT_POINT]);				
						else  $orderMgr->setOS_TOT_POINT(0);
						$orderMgr->setOS_SETTLE($orderRow[O_SETTLE]);
						$orderMgr->getOrderSettleInsert($db);
					}
				}

				
				/* 사용포인트 적립 복원*/
				if ($orderRow[O_USE_POINT] > 0){
					$memberMgr->setM_NO($orderRow[M_NO]);
					$memberMgr->setM_POINT($orderRow[O_USE_POINT]);
					$memberMgr->getMemberPointUpdate($db);

					/* 포인트 관리 데이터 INSERT */
					$orderMgr->setM_NO($orderRow[M_NO]);
					$orderMgr->setB_NO(0);
					$orderMgr->setPT_TYPE('003');
					$orderMgr->setPT_POINT($memberMgr->getM_POINT());
					$orderMgr->setPT_MEMO("포인트사용취소[".$orderRow[O_KEY]."]");
					$orderMgr->setPT_START_DT(date("Y-m-d"));
					$orderMgr->setPT_END_DT(date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")+$siteRow[S_POINT_USE_YEAR])));
					$orderMgr->setPT_REG_IP($S_REOMTE_ADDR);
					$orderMgr->setPT_ETC('');
					$orderMgr->setPT_REG_NO(1);
					$orderMgr->getOrderPointInsert($db);
				}

				/* 쿠폰 사용 복원 */
				if ($orderRow[O_USE_COUPON] > 0){
					$orderMgr->getOrderCouponUseCancelUpdate($db);
				}
				
				/* 취소정보 INSERT */
				$orderRow = $orderMgr->getOrderView($db);
				$orderMgr->setOS_APPR_NO($orderRow[O_APPR_NO]);
				$orderMgr->setOS_CEL_NO($orderRow[O_CEL_NO]);
				$orderMgr->getOrderSettleUpdate($db);

				$strMsg = $LNG_TRANS_CHAR["OS00008"]; //주문취소가 완료 되었습니다.
				$strSmsSendCode = "016";

			} else {
				
				$orderRow = $orderMgr->getOrderView($db);
				
				/* 취소정보 INSERT */
				$orderMgr->setOS_APPR_NO($orderRow[O_APPR_NO]);
				if (!$orderMgr->getOS_CEL_NO()) $orderMgr->setOS_CEL_NO($orderRow[O_CEL_NO]);
				$orderMgr->getOrderSettleUpdate($db);

				$strMsg = $LNG_TRANS_CHAR["OS00008"]; //주문취소가 완료 되었습니다.
				$strSmsSendCode = "016";
				if ($mod_type != "9999"){
					
					if ($orderRow['O_PG'] == "A" && ($orderRow['O_SETTLE'] == 'A' || $orderRow['O_SETTLE'] == 'T') && $strModType == "STE3"){
						$strSmsSendCode = "";
						$strMsg = $LNG_TRANS_CHAR["OS00021"]; //"주문취소 신청되었습니다. 환불은 취소요청일로 부터 2~3일 이내 환불됩니다.";
					
					} else {
						$strMsg = $LNG_TRANS_CHAR["OS00009"]; //주문취소 신청되었습니다. 반품이 완료 후 주문취소가 완료됩니다.
						$strSmsSendCode = "014";	
					}		
				}
			}
			
			if($strMsg) :
				/** 메일 전송 - 고객 주문 취소 메일 **/
				$aryTAG_LIST['{{__받는사람이름__}}']	= $orderRow['O_J_NAME'];
				$aryTAG_LIST['{{__받는사람메일__}}']	= $orderRow['O_J_MAIL'];
				$aryTAG_LIST['{{__회원명__}}']			= $orderRow['O_J_NAME'];
				$aryTAG_LIST['{{__주문번호__}}']		= $orderRow['O_KEY'];
				$aryTAG_LIST['{{__주문상태표시__}}']	= $strMsg;
				$aryTAG_LIST['{{__주문상품명__}}']		= $orderRow['O_J_TITLE'];
				$aryTAG_LIST['{{__주문취소일자__}}']	= date("Y-m-d");
				goSendMail("011");
				/** 메일 전송 **/


				## 2015.01.15 kim hee sung SMS 모듈 V2.0
				## 한국어 전용
				## 관리자페이지에서 SMS 사용함 설정된 경우

				## 설정파일 불러오기
				include_once rtrim(MALL_SHOP, '/') . '/conf/smsInfo.conf.inc.php';

				if($S_SITE_LNG == "KR" && $SMS_INFO['S_SMS_USE']=="Y"):

					## 사용자 SMS
					## 모듈 설정
					$objSmsInfo = new SmsInfo($db);

					## 코드 설정
					$strSmsCode = $strSmsSendCode; // 014 - 고객 주문취소(고객용)
												   // 016 - 관리자 주문취소(고객용)

					if($SMS_TEXT_LIST && $SMS_TEXT_LIST[$strSmsCode] && $SMS_TEXT_LIST[$strSmsCode]['SM_AUTO'] == "Y"):

						## 문자 설정
						$strSmsMsg			= $SMS_TEXT_LIST[$strSmsCode]['SM_TEXT'];
						$strSmsMsg			= str_replace("{{상점명}}", $S_SITE_KNAME, $strSmsMsg);
						$strSmsMsg			= str_replace("{{고객명}}", $orderRow['O_J_NAME'], $strSmsMsg);

						## SMS 전송
						$param = '';
						$param['phone']			= $orderRow['O_J_HP'];		
						$param['callBack']		= $S_COM_PHONE;	
						$param['msg']			= $strSmsMsg;
						$param['siteName']		= $S_SITE_KNAME;
						$objSmsInfo->goSendSms($param);

					endif;

					## 관리자 SMS
					## 코드 설정
					if ($strSmsCode == "014") $strSmsCode = "015"; // 고객 주문취소(관리자용)
					if ($strSmsCode == "016") $strSmsCode = "017"; // 관리자 주문취소(관리자용)

					if($SMS_TEXT_LIST && $SMS_TEXT_LIST[$strSmsCode] && $SMS_TEXT_LIST[$strSmsCode]['SM_AUTO'] == "Y"):

						## 문자 설정
						$strSmsMsg			= $SMS_TEXT_LIST[$strSmsCode]['SM_TEXT'];
						$strSmsMsg			= str_replace("{{상점명}}", $S_SITE_KNAME, $strSmsMsg);
						$strSmsMsg			= str_replace("{{고객명}}", $orderRow['O_J_NAME'], $strSmsMsg);

						## SMS 전송
						$param = '';
						$param['phone']			= $orderRow['O_J_HP'];		
						$param['callBack']		= $S_COM_PHONE;	
						$param['msg']			= $strSmsMsg;
						$param['siteName']		= $S_SITE_KNAME;
						$objSmsInfo->goSendSms($param);

					endif;
				endif;	

				/** 2013.04.18 SMS 전송 모듈 추가 **/
				## SMS 사용 , 한국어 페이지 인 경우 SMS 전송 실행
//				if($SMS_INFO['S_SMS_USE']=="Y" && $orderRow['O_USE_LNG'] == "KR" && $strSmsSendCode):
//					$smsMoney = $smsFunc->getSmsMoneySelect($db); // 머니 체크
//					if($smsMoney['VAL'] > 0):
//						$smsCode			= $strSmsSendCode;
//						$smsPhone			= str_replace("-","",$orderRow['O_J_HP']);		
//						$smsCallBackPhone	= $S_COM_PHONE;
//						$smsMsg				= $SMS_TEXT_LIST[$smsCode]['SM_TEXT'];
//						$smsMsg				= str_replace("{{상점명}}", $S_SITE_KNAME, $smsMsg);
//						$smsMsg				= str_replace("{{고객명}}", $orderRow['O_J_NAME'], $smsMsg);
//						if($SMS_TEXT_LIST[$smsCode]['SM_AUTO'] == "Y"): //  자동발송 사용..
//							$smsFunc->goSendSms($smsPhone, $smsCallBackPhone, $smsMsg);
//							$smsFunc->getSmsMoneyMinusUpdate($db); // 머니 -1
//						endif;
//					else:
//						// sms 머니 부족.. 부분 처리..
//					endif;
//				endif;
				/** 2013.04.18 SMS 전송 모듈 추가 **/
			endif;

			/* 구매건수 , 구매금액 업데이트 */
			if ($orderRow['M_NO']){
				$memberMgr->setM_NO($orderRow['M_NO']);					// 회원번호
				$memberMgr->getMemberBuyUpdate($db);
			}
			/* 구매건수 , 구매금액 업데이트 */

			$db->disConnect();
			//goPopReflash($strMsg);
			echo "<script language='javascript'>parent.goPopClose();</script>";
			exit;
		break;
		
		case "orderCancelUpdate":
			
			$intO_NO		= $_POST["oNo"]				? $_POST["oNo"]				: $_REQUEST["oNo"];
			$orderMgr->setO_NO($intO_NO);
			$orderRow = $orderMgr->getOrderView($db);
			
			/* KCP 연동 */
			if ($orderRow['O_ESCROW'] == "Y"){
				
				/* 취소 */
				$req_tx = "mod_escrow";
				$mod_type = "STE4";

				if ($orderRow[O_SETTLE] == "T") $vcnt_yn = "Y";
				
				$strReturnBank	= $orderRow[O_RETURN_BANK];
				$strReturnName	= $orderRow[O_RETURN_NAME];
				$strReturnAcc	= $orderRow[O_RETURN_ACC];
				$tno = $orderRow[O_APPR_NO];
				
				switch ($orderRow[O_PG]){
					case "K":
						include MALL_HOME."/web/frwork/act/pp_ax_hub_adm.php";
					
						if ($res_cd != "0000" || $bSucc == "false"){
							$db->disConnect();
							goErrMsg($LNG_TRANS_CHAR["OS00007"]); //주문취소 중 에러가 발생하였습니다.
							exit;
						}
					break;

					case "A":
						$userPage = "A";

						$TrCode = "E400";
						include MALL_HOME."/web/frwork/act/agsPay/AGS_escrow_ing.php";
							
						if ($res_cd != "0000" || $bSucc == "false"){
							$db->disConnect();
							goErrMsg($LNG_TRANS_CHAR["OS00007"]); //주문취소 중 에러가 발생하였습니다.
							exit;
						}
					break;		
				}

			} else {
				$res_cd = "0000";
				$bSucc = "";
			}
			
			if ($res_cd == "0000" && $bSucc != "false"){

				$orderMgr->setOC_LIST_ARY("Y");
				$aryOrderCartList = $orderMgr->getOrderCartList($db);
				
				if (is_array($aryOrderCartList)){
					for($j=0;$j<sizeof($aryOrderCartList);$j++){
						$strProdCode  = $aryOrderCartList[$j][P_CODE];
						$intOC_OPT_NO = $aryOrderCartList[$j][OC_OPT_NO];
						$intOC_QTY    = $aryOrderCartList[$j][OC_QTY];
						
						if ($aryOrderCartList[$j][P_STOCK_LIMIT] != "Y"){
							/* 옵션별 수량 조절 */
							if ($intOC_OPT_NO > 0){
								$productMgr->setPOA_STOCK_QTY($intOC_QTY);
								$productMgr->setPOA_NO($intOC_OPT_NO);
								$productMgr->getProdOptQtyUpdate($db);
							}

							/* 상품전체 수량 조절 */
							if ($strProdCode)
							{
								$productMgr->setP_QTY($intOC_QTY);
								$productMgr->setP_CODE($strProdCode);
								$productMgr->getProdQtyUpdate($db);
							}
						}
					}
				}
				
				
				/* 포인트 적립 취소 */
				if ($orderRow[O_TOT_POINT] > 0 && $orderRow[M_NO] > 0 && $orderRow[O_ADD_POINT] == "Y"){
					$memberMgr->setM_NO($orderRow[M_NO]);
					$memberMgr->setM_POINT(-$orderRow[O_TOT_POINT]);
					$memberMgr->getMemberPointUpdate($db);

					/* 포인트 히스토리 추가해야 함*/
					/* 포인트 관리 데이터 INSERT */
					$orderMgr->setM_NO($orderRow[M_NO]);
					$orderMgr->setB_NO(0);
					$orderMgr->setPT_TYPE('009');
					$orderMgr->setPT_POINT($memberMgr->getM_POINT());
					$orderMgr->setPT_MEMO("구매포인트적립취소[".$orderRow[O_KEY]."]");
					$orderMgr->setPT_START_DT(date("Y-m-d"));
					$orderMgr->setPT_END_DT(date("Y-m-d"));
					$orderMgr->setPT_REG_IP($S_REOMTE_ADDR);
					$orderMgr->setPT_ETC('');
					$orderMgr->setPT_REG_NO(1);
					$orderMgr->getOrderPointInsert($db);
				}

				/* 첫상품구매 포인트 적립 취소 */
				if ($orderRow[O_FIRST_YN] == "Y"){
					$orderMgr->setM_NO($orderRow[M_NO]);
					$intOrderFirstPoint = $orderMgr->getOrderFirstPoint($db);
					if ($intOrderFirstPoint > 0){
						$memberMgr->setM_NO($orderRow[M_NO]);
						$memberMgr->setM_POINT(-$intOrderFirstPoint);
						$memberMgr->getMemberPointUpdate($db);

						/* 포인트 히스토리 추가해야 함*/
						/* 포인트 관리 데이터 INSERT */
							$orderMgr->setM_NO($orderRow[M_NO]);
							$orderMgr->setB_NO(0);
							$orderMgr->setPT_TYPE('005');
							$orderMgr->setPT_POINT($memberMgr->getM_POINT());
							$orderMgr->setPT_MEMO($LNG_TRANS_CHAR["OW00119"]."[".$orderRow[O_KEY]."]"); //구매포인트적립취소
							$orderMgr->setPT_START_DT(date("Y-m-d"));
							$orderMgr->setPT_END_DT(date("Y-m-d"));
							$orderMgr->setPT_REG_IP($S_REOMTE_ADDR);
							$orderMgr->setPT_ETC('');
							$orderMgr->setPT_REG_NO(1);
							$orderMgr->getOrderPointInsert($db);
						/* 포인트 관리 데이터 INSERT */
					}
				}

				/* 사용포인트 적립 */
				if ($orderRow[O_USE_POINT] > 0){
					$memberMgr->setM_NO($orderRow[M_NO]);
					$memberMgr->setM_POINT($orderRow[O_USE_POINT]);
					$memberMgr->getMemberPointUpdate($db);

					/* 포인트 관리 데이터 INSERT */
					$orderMgr->setM_NO($orderRow[M_NO]);
					$orderMgr->setB_NO(0);
					$orderMgr->setPT_TYPE('003');
					$orderMgr->setPT_POINT($memberMgr->getM_POINT());
					$orderMgr->setPT_MEMO("포인트사용취소[".$orderRow[O_KEY]."]");
					$orderMgr->setPT_START_DT(date("Y-m-d"));
					$orderMgr->setPT_END_DT(date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")+$siteRow[S_POINT_USE_YEAR])));
					$orderMgr->setPT_REG_IP($S_REOMTE_ADDR);
					$orderMgr->setPT_ETC('');
					$orderMgr->setPT_REG_NO(1);
					$orderMgr->getOrderPointInsert($db);
				}
				
				/* 쿠폰 사용 복원 */
				if ($orderRow[O_USE_COUPON] > 0){
					$orderMgr->getOrderCouponUseCancelUpdate($db);
				}

				/* 취소정보 INSERT */
				$orderMgr->setOS_APPR_NO($orderRow[O_APPR_NO]);
				$orderMgr->setOS_CEL_NO($orderRow[O_CEL_NO]);
				$orderMgr->getOrderSettleUpdate($db);

				/* 취소 상태 변경 */
				$orderMgr->setO_CEL_STATUS("Y");
				$orderMgr->getOrderCancelStatusUpdate($db);

			}
			
			$strMsg = $LNG_TRANS_CHAR["OS00008"];//주문취소 완료되었습니다.
			$strUrl = "./?menuType=".$strMenuType."&mode=list&".$strLinkPage;			


			## 2015.01.15 kim hee sung SMS 모듈 V2.0
			## 한국어 전용
			## 관리자페이지에서 SMS 사용함 설정된 경우

			## 설정파일 불러오기
			include_once rtrim(MALL_SHOP, '/') . '/conf/smsInfo.conf.inc.php';

			if($S_SITE_LNG == "KR" && $SMS_INFO['S_SMS_USE']=="Y"):

				## 사용자 SMS
				## 모듈 설정
				$objSmsInfo = new SmsInfo($db);

				## 코드 설정
				$strSmsCode = "016";	// 016 관리자 주문취소(고객용)

				if($SMS_TEXT_LIST && $SMS_TEXT_LIST[$strSmsCode] && $SMS_TEXT_LIST[$strSmsCode]['SM_AUTO'] == "Y"):

					## 문자 설정
					$strSmsMsg			= $SMS_TEXT_LIST[$strSmsCode]['SM_TEXT'];
					$strSmsMsg			= str_replace("{{상점명}}", $S_SITE_KNAME, $strSmsMsg);
					$strSmsMsg			= str_replace("{{고객명}}", $orderRow['O_J_NAME'], $strSmsMsg);

					## SMS 전송
					$param = '';
					$param['phone']			= $orderRow['O_J_HP'];		
					$param['callBack']		= $S_COM_PHONE;	
					$param['msg']			= $strSmsMsg;
					$param['siteName']		= $S_SITE_KNAME;
					$objSmsInfo->goSendSms($param);

				endif;

				## 관리자 SMS
				## 필요시 추가하세요..

			endif;	
			
			/** 2013.04.18 SMS 전송 모듈 추가 **/
			## SMS 사용 , 한국어 페이지 인 경우 SMS 전송 실행
//			if($SMS_INFO['S_SMS_USE']=="Y" && $orderRow['O_USE_LNG'] == "KR"):
//				$smsMoney = $smsFunc->getSmsMoneySelect($db); // 머니 체크
//				if($smsMoney['VAL'] > 0):
//					$smsCode			= "016";
//					$smsPhone			= str_replace("-","",$orderRow['O_J_HP']);		
//					$smsCallBackPhone	= $S_COM_PHONE;
//					$smsMsg				= $SMS_TEXT_LIST[$smsCode]['SM_TEXT'];
//					$smsMsg				= str_replace("{{상점명}}", $S_SITE_KNAME, $smsMsg);
//					$smsMsg				= str_replace("{{고객명}}", $orderRow['O_J_NAME'], $smsMsg);
//					if($SMS_TEXT_LIST[$smsCode]['SM_AUTO'] == "Y"): //  자동발송 사용..
//						$smsFunc->goSendSms($smsPhone, $smsCallBackPhone, $smsMsg);
//						$smsFunc->getSmsMoneyMinusUpdate($db); // 머니 -1
//					endif;
//				else:
//					// sms 머니 부족.. 부분 처리..
//				endif;
//			endif;
			/** 2013.04.18 SMS 전송 모듈 추가 **/
		
			/* 구매건수 , 구매금액 업데이트 */
			if ($orderRow['M_NO']){
				$memberMgr->setM_NO($orderRow['M_NO']);					// 회원번호
				$memberMgr->getMemberBuyUpdate($db);
			}
			/* 구매건수 , 구매금액 업데이트 */

			$db->disConnect();
			//goPopReflash($strMsg);
			echo "<script language='javascript'>parent.goPopClose();</script>";
			exit;

		break;

		case "orderDelete":
			$orderMgr->setO_NO($intO_NO);
			$orderRow = $orderMgr->getOrderView($db);
			$orderMgr->getOrderDelete($db);

			/* 구매건수 , 구매금액 업데이트 */
			if ($orderRow['M_NO']){
				$memberMgr->setM_NO($orderRow['M_NO']);					// 회원번호
				$memberMgr->getMemberBuyUpdate($db);
			}
			/* 구매건수 , 구매금액 업데이트 */

			$strMsg = "주문이 삭제되었습니다.";//주문취소 완료되었습니다.
			$strUrl = "./?menuType=".$strMenuType."&mode=list&".$strLinkPage;
		
		break;

		case "shopOrderReturnStatusUpdate":

			$strOrderReturnStatus1 = SUBSTR($_POST["shopOrderReturnStatus"],0,1);
			$strOrderReturnStatus2 = SUBSTR($_POST["shopOrderReturnStatus"],1);

			$intOC_NO				= $_POST["ocNo"];
		
			if ($intOC_NO > 0){

				$param["OC_NO"]			= $intOC_NO;
				$param["OC_STATUS1"]	= $strOrderReturnStatus1;
				$param["OC_STATUS2"]	= $strOrderReturnStatus2;
				$param["OC_REG_NO"]		= $a_admin_no;
				
				//$orderMgr->getOrderMallReturnUpdate($db,$param);
			}

		break;
	}
?>