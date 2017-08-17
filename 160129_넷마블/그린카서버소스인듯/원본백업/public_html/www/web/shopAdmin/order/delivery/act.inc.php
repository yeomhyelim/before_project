<?
	require_once MALL_CONF_LIB."OrderAdmMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";
	require_once MALL_CONF_LIB."MemberAdmMgr.php";
	require_once MALL_CONF_LIB."ProductAdmMgr.php";
	require_once MALL_CONF_LIB."CouponMgr.php";

	$orderMgr = new OrderMgr();
	$siteMgr = new SiteMgr();
	$memberMgr = new MemberMgr();
	$productMgr = new ProductAdmMgr();
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

	/*배송회사*/
	$aryDeliveryCom = getCommCodeList("DELIVERY");

	switch ($strAct) {
		case "orderDeliveryUpdate":
			
			if (is_array($aryChkNo)){
				for($i=0;$i<sizeof($aryChkNo);$i++){
				
					if ($aryChkNo[$i] > 0){
						$intO_NO = $aryChkNo[$i];
						$orderMgr->setO_NO($intO_NO);
						$orderRow = $orderMgr->getOrderView($db);
						
						$strO_DELIVERY_COM	= $_POST["deliveryCom_".$intO_NO];
						$strO_DELIVERY_NUM	= $_POST["deliveryComNum_".$intO_NO];
						$orderMgr->setO_DELIVERY_COM($strO_DELIVERY_COM);
						$orderMgr->setO_DELIVERY_NUM($strO_DELIVERY_NUM);

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
					}
				}
			}

			$strMsg = $LNG_TRANS_CHAR["OS00006"]; //배송정보가 변경되었습니다.
			$strUrl = "./?menuType=".$strMenuType."&mode=deliveryFastInput";

		break;


		case "orderDeliveryExcelUpdate":
			
			$_FILE		= $_FILES['excelFile'];
			
			if($_FILE['error'] > 0) :
				// error 처리
				echo "업로드 오류 처리 하세요...";
				break;
			endif;
			
			if(!$_FILE['name']):
				// 파일명이 없을 때 처리.
				echo "파일명 설정이 안되어 있습니다. 처리하세요...";
				break;
			endif;

			// 파일 업로드
			$uid	 			= "deliveryExcelUpload_".date("YmdHis");	// 파일업로드명의 구분자
			$upload_dir			= WEB_UPLOAD_PATH . "/temp" ;				// 업로드할 폴더명
			$file_name			= $_FILE['name'];							// 파일명
			$file_tmp_name		= $_FILE['tmp_name'];						// 업로드할 임시 파일명
			$file_size			= $_FILE['size'];							// 업로드할 파일 크기
			$file_type			= $_FILE['type'];							// 업로드할 파일 타입

			$fres 				= $fh->doUpload($uid, $upload_dir, $file_name, $file_tmp_name, $file_size, $file_type);
			
			if(!$fres) :
				// 업로드 실패 처리
				echo "업로드 실패 영역 처리 하세요...";
				break;
			endif;
			
			$strFileInServer	= $fres['upload_dir'] . "/" . $fres['file_real_name'];
			@chmod($strFileInServer , 0707);	// 권한 변경
			

			/* Excel 영역 */
			require_once MALL_EXCEL_READER;
			$data = new Spreadsheet_Excel_Reader();
			$data->setOutputEncoding('utf-8');
			$data->read($strFileInServer);
			error_reporting(E_ALL ^ E_NOTICE);
			
			$aryDeliveryComAll = getCommCodeList("DELIVERY","Y");

			for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) :
				
				$strOrderKey		= $data->sheets[0]['cells'][$i][1];		//주문번호
				$strDeliveryCom		= $data->sheets[0]['cells'][$i][2];		//배송회사
				$strDeliveryNum		= $data->sheets[0]['cells'][$i][3];		//송장번호
								
				$orderMgr->setO_KEY($strOrderKey);
				$intO_NO = $orderMgr->getOrderNo($db);
				$orderMgr->setO_NO($intO_NO);
				$orderRow = $orderMgr->getOrderView($db);
								
				$strO_DELIVERY_NUM	= $strDeliveryNum;				
				while(list($key,$val) = each($aryDeliveryComAll)){
					if ($val == $strDeliveryCom) {
						$strO_DELIVERY_COM	= $key;
					}
				}
				$orderMgr->setO_DELIVERY_COM($strO_DELIVERY_COM);
				$orderMgr->setO_DELIVERY_NUM($strO_DELIVERY_NUM);

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

			endfor;
			/* Excel 영역 */

			// 파일 삭제
			$fh->fileDelete($strFileInServer);

			echo "
				<script language='javascript'>
				alert('".$LNG_TRANS_CHAR["OS00006"]."');
				parent.goPopClose();
				</script>
			";
			exit;
		break;

		case "orderDeliveryStatusUpdate":

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
						$strOrderStatus = $_POST["orderDeliveryStatus"]	? $_POST["orderDeliveryStatus"]	: $_REQUEST["orderDeliveryStatus"];
	
						switch($strOrderStatus){

							case "B":
								//배송준비중


							break;

							case "I":
								//배송중
							break;

							case "D":
								// 배송완료
								
								
								/* 적립금 지급 유무 상태가 배송완료일때 */

								/* 포인트 적립(적립금관리사용유무) */
								if ($siteRow[S_POINT_USE1] == "Y"){

									if (($orderRow[O_USE_POINT] > 0 && $siteRow[S_POINT_USE2] == "Y") || $orderRow[O_USE_POINT] == 0) {

										if ($siteRow[S_POINT_ORDER_STATUS] == "D"){
									
											/* 사용포인트가 있고 적립금 사용시 상품적립금 지급 유무(Y) , 사용포인트가 없을 경우 단(포인트지급유무 주문상태는 결제완료)*/
											if ($orderRow[O_TOT_POINT] > 0 && $orderRow[M_NO] > 0){
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
									if ($orderRow[M_NO] > 0 && $siteRow[S_POINT_ORDER_STATUS] == "D")
									{
											
										$memberMgr->setM_NO($orderRow[M_NO]);
										$memberOrderRow = $memberMgr->getMemberOrderCount($db);
										$intMemberOrderJumunCnt = 99999;
										if ($memberOrderRow){
											$intMemberOrderJumunCnt = $memberOrderRow[JUMUN_CNT];
											$intMemberOrderDeliveryCnt = $memberOrderRow[DELIVERY_CNT];
										}
										
										if ((int)$S_POINT_ORDER_GIVE > 0 && $intMemberOrderJumunCnt == 1 && $intOrderProdNoPointUseCnt == 0)
										{
											$strOrderFirstPointGiveYN = "Y";
											if (($orderRow[O_USE_POINT] > 0 && $S_POINT_USE2 != "Y") || $orderRow["O_FIRST_YN"] == "Y"){
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
								
								
								/** 메일 전송 - 물품 발송 후 메일 **/
								$aryTAG_LIST['{{__받는사람이름__}}']	= $orderRow['O_B_NAME'];
								$aryTAG_LIST['{{__받는사람메일__}}']	= $orderRow['O_B_MAIL'];
								$aryTAG_LIST['{{__회원명__}}']			= $orderRow['O_B_NAME'];
								$aryTAG_LIST['{{__주문번호__}}']		= $orderRow['O_KEY'];
								goSendMail("013");
								/** 메일 전송 **/	
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
											$couponMgr->setCI_USE_O_NO($orderRow['O_NO']);
											$couponMgr->getIssueInsert($db);
										}
									}
								}
								/* 구매 완료시 쿠폰 자동발급 데이터가 있으면 회원일때 쿠폰 발급 */

								/* 포인트 적립(적립금관리사용유무) */
								if ($siteRow[S_POINT_USE1] == "Y"){

									if (($orderRow[O_USE_POINT] > 0 && $siteRow[S_POINT_USE2] == "Y") || $orderRow[O_USE_POINT] == 0) {

										if ($siteRow[S_POINT_ORDER_STATUS] == "E"){
									
											/* 사용포인트가 있고 적립금 사용시 상품적립금 지급 유무(Y) , 사용포인트가 없을 경우 단(포인트지급유무 주문상태는 결제완료)*/
											if ($orderRow[O_TOT_POINT] > 0 && $orderRow[M_NO] > 0 && $orderRow[O_ADD_POINT] != "Y"){
												$memberMgr->setM_NO($orderRow[M_NO]);
												$memberMgr->setM_POINT($orderRow[O_TOT_CUR_POINT]);
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
											
											if ($strOrderFirstPointGiveYN == "Y" && $orderRow['O_FIRST_YN'] != "Y"){
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

							break;

							case "R":
								//반품완료
							break;

							case "T":
								//환불완료
								/** 메일 전송 - 환불완료 **/
								$aryTAG_LIST['{{__받는사람이름__}}']	= $orderRow['O_B_NAME'];
								$aryTAG_LIST['{{__받는사람메일__}}']	= $orderRow['O_B_MAIL'];
								$aryTAG_LIST['{{__회원명__}}']			= $orderRow['O_B_NAME'];
								$aryTAG_LIST['{{__주문번호__}}']		= $orderRow['O_KEY'];
								goSendMail("016");
								/** 메일 전송 **/								
							break;


						}

						
						/*주문상태변경*/
						$orderMgr->setO_STATUS($strOrderStatus);
						$orderMgr->getOrderStatusUpdate($db);

						## 구매건수 , 구매금액 업데이트
						if ($orderRow['M_NO']){
							$memberMgr->setM_NO($orderRow['M_NO']);	
							$memberMgr->getMemberBuyUpdate($db);
						}
						
					}
				}
			}
						
			$strUrl = "./?menuType=".$strMenuType."&mode=deliveryList&".$strLinkPage;
		break;
	}
?>