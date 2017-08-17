<?
	require_once MALL_CONF_LIB."OrderAdmMgr.php";
	require_once MALL_CONF_LIB."ProductAdmMgr.php";
	require_once MALL_CONF_LIB."MemberAdmMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";
	require_once MALL_CONF_LIB."CouponMgr.php";
	require_once MALL_CONF_LIB."ShopOrderMgr.php";
	require_once MALL_CONF_LIB."ShopMgr.php";

	$orderMgr = new OrderMgr();
	$productMgr = new ProductAdmMgr();
	$memberMgr = new MemberMgr();
	$siteMgr = new SiteMgr();
	$couponMgr = new CouponMgr();
	$shopOrderMgr = new ShopOrderMgr();
	$shopMgr		= new ShopMgr();
		
	/* 여기에 추가되어야 함(메일관련) */
	require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/layout/mail/_config.inc.php";
	require_once $S_DOCUMENT_ROOT."www/config/mail.func.php";	
	/* 여기에 추가되어야 함(메일관련) */

	/* 여기에 추가되어야 함(문자관련) 2013.04.18 */
	$smsConfFile = "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/smsInfo.conf.inc.php";
	if(is_file($smsConfFile)):
		require_once $smsConfFile;
		require_once "{$S_DOCUMENT_ROOT}www/classes/sms/sms.func.class.php";
		$smsFunc = new SmsFunc();
	endif;
	/* 여기에 추가되어야 함(문자관련) 2013.04.18 */

	/*배송회사*/
	$aryDeliveryCom = getCommCodeList("DELIVERY","Y");

	$siteRow = $siteMgr->getSiteInfo($db);

	switch($strAct):
	case "orderDeliveryExcelUpdate":
		// 배송정보 엑셀 파일로 일괄 수정

		## STEP 1.
		## 파일 체크
		$_FILE		= $_FILES['excelFile'];
		if($_FILE['error'] > 0) :
			// error 처리
			$strUrl = $_SERVER['HTTP_REFERER'];
			$strMsg	= "파일 업로드시 오류가 발생했습니다. 잠시후에 다시 시도하시기 바랍니다.";
			break;
			exit;
		endif;
		if(!$_FILE['name']):
			// 파일명이 없을 때 처리.
			$strUrl = $_SERVER['HTTP_REFERER'];
			$strMsg	= "등록된 파일이 없습니다.";
			break;
			exit;
		endif;
		$fileInfo = pathinfo($_FILE['name']);
		if($fileInfo['extension'] != "xls"):
			// 엑셀 파일이 아닌 경우
			$strUrl = $_SERVER['HTTP_REFERER'];
			$strMsg	= "지정된 파일이 아닙니다.";
			break;
			exit;
		endif;

		## STEP 2.
		## 파일 업로드
		$uid	 			= "deliveryExcelUpload_".date("YmdHis");	// 파일업로드명의 구분자
		$upload_dir			= WEB_UPLOAD_PATH . "/temp" ;				// 업로드할 폴더명
		$file_name			= $_FILE['name'];							// 파일명
		$file_tmp_name		= $_FILE['tmp_name'];						// 업로드할 임시 파일명
		$file_size			= $_FILE['size'];							// 업로드할 파일 크기
		$file_type			= $_FILE['type'];							// 업로드할 파일 타입
		$fres 				= $fh->doUpload($uid, $upload_dir, $file_name, $file_tmp_name, $file_size, $file_type);
		if(!$fres) :
			// 업로드 실패 처리
			$strUrl = $_SERVER['HTTP_REFERER'];
			$strMsg	= "파일을 업로드 할 수 없습니다.";
			break;
			exit;
		endif;
		$strFileInServer	= $fres['upload_dir'] . "/" . $fres['file_real_name'];
		@chmod($strFileInServer , 0707);	// 권한 변경

		## STEP 3.
		## 엑셀 파일 불러오기
		require_once MALL_EXCEL_READER;
		$data = new Spreadsheet_Excel_Reader();
		$data->setOutputEncoding('utf-8');
		$data->read($strFileInServer);
		error_reporting(E_ALL ^ E_NOTICE);

		foreach($data->sheets[0]['cells'][2] as $key => $name):
			$cellName[$name] = $key;
		endforeach;
		
		if(!$cellName['__CODE__'] || !$cellName['__DELIVERY_COM__'] || !$cellName['__DELIVERY_NUM__']):
			$fh->fileDelete($strFileInServer);
			$strUrl = $_SERVER['HTTP_REFERER'];
			$strMsg	= "기본 코드값이 없습니다.";
			break;
			exit;
		endif;
		
		## STEP 4.
		## 배송 정보 설정


		/** 배송 회사 리스트 **/
		if(!$aryDeliveryComAll):
		$aryDeliveryComAll = getCommCodeList("DELIVERY", "Y");
		endif;
		$aryDeliveryComName ="";
		foreach($aryDeliveryComAll as $key => $value):
			$aryDeliveryComName[$value] = $key;
		endforeach;

		## STEP 5.
		## 배송 정보 업데이트
		$cellCode			= $cellName['__CODE__'];
		$cellDeliveryCom	= $cellName['__DELIVERY_COM__'];
		$cellDeliveryNum	= $cellName['__DELIVERY_NUM__'];
		foreach($data->sheets[0]['cells'] as $key => $data):
			if($key <= 2) { continue; }
			if(!$data[$cellCode]) { continue; } /** 입점사 주문 번호가 없는 경우 변경 불가 **/

			$deliveryCom					= $data[$cellDeliveryCom];		// 배송 회사 번호
			$deliveryStatus					= "I";							// 배송중
			if(!$data[$cellDeliveryCom] || !$data[$cellDeliveryNum]) { $deliveryStatus ="B"; } // 배송준비중

			/** 업데이트 **/
			$param['so_no']					= $data[$cellCode];
			$param['so_delivery_com']		= $aryDeliveryComName[$deliveryCom];
			$param['so_delivery_num']		= $data[$cellDeliveryNum];
			$param['so_delivery_status']	= $deliveryStatus;

			if($_SESSION['ADMIN_TYPE'] == "S"):
				// 입점몰인 경우
				$param['sh_no']						= $_SESSION['ADMIN_SHOP_NO'];
				if(!$param['sh_no']):
					echo "입점몰 정보가 없습니다.";
					exit;
				endif;
			endif;

			$re								= $shopMgr->getDeliveryUpdateEx($db, $param);


			$intO_NO						= $shopOrderMgr->getOrderNo($db,$param);
			
			if ($intO_NO > 0){
				$orderMgr->setO_NO($intO_NO);
				$orderRow = $orderMgr->getOrderView($db);
				$strPreOrderStatus = $orderRow['O_STATUS'];
				
				$shopOrderMgr->getOrderStatusAllUpdate($db,$param);	
				if ($orderRow["O_USE_LNG"] == "KR"){
					/* 마스터 주문상태가 변경되었을때 포인트/쿠폰 작업을 진행한다*/
					include MALL_WEB_PATH."shopAdmin/order/mallList/orderMallStatusUpdate.php";
				}
			}

			/* HISTORY INSERT */
			$strOrderStatusMemo = "배송상태변경";
			$strOrderStatusText	= $param["so_no"]."/".$param['so_delivery_status'];

			$param['m_no']		= $a_admin_no;
			$param['h_tab']		= TBL_ORDER_MGR;
			$param['h_key']		= $intO_NO;
			$param['h_code']	= "003"; //배송상태
			$param['h_memo']	= $strOrderStatusMemo;
			$param['h_text']	= $strOrderStatusText;
			$param['h_reg_no']	= $a_admin_no;
			$param['h_adm_no']	= $a_admin_no;
			
			$shopOrderMgr->getOrderStatusHistoryUpdate($db,$param);
			/* HISTORY INSERT */

			/** 메일 전송 - 배송중 **/
			if ($param['so_delivery_status'] == "I"){
				/* 입점사별 정보 */
				$shopOrderRow = $shopOrderMgr->getShopOrderView($db,$param);
				
				/* 주문정보 */
				$intO_NO = $shopOrderRow["O_NO"];
				$orderMgr->setO_NO($intO_NO);
				$orderRow = $orderMgr->getOrderView($db);
				
				$param["o_use_lng"] = $orderRow["O_USE_LNG"];
				$param["shop_no"]	= $shopOrderRow["SH_NO"];
				$param["op"]		= "result";
				$param["o_no"]		= $intO_NO;
				$cartResult = $shopOrderMgr->getOrderCartList($db,$param);
				$intCartTotal= $cartResult["cnt"];

				$strMailSendMode = "adm";
				$strMailMode = "orderDeliverySend";
				include WEB_FRWORK_ACT."orderMailForm.inc.php";

				/** 메일 전송 - 고객 주문 배송 메일 **/
				$aryTAG_LIST['{{__받는사람이름__}}']	= $orderRow['O_J_NAME'];
				$aryTAG_LIST['{{__받는사람메일__}}']	= $orderRow['O_J_MAIL'];
				$aryTAG_LIST['{{__회원명__}}']			= $orderRow['O_J_NAME'];
				$aryTAG_LIST['{{__주문번호__}}']		= $orderRow['O_KEY'];
				$aryTAG_LIST['{{__주문상품내역__}}']	= $strOrderCartHtml;
				$aryTAG_LIST['{{__주문배송정보__}}']	= $strOrderInfoHtml;
				$aryTAG_LIST['{{__배송사__}}']			= $aryDeliveryCom[$shopOrderRow['SO_DELIVERY_COM']];
				$aryTAG_LIST['{{__운송장번호__}}']		= $shopOrderRow['SO_DELIVERY_NUM'];
				$aryTAG_LIST['{{__주문일자__}}']		= SUBSTR($orderRow['O_REG_DT'],0,10);
				
				/** 메일전송이 한번만 되게 **/
				if ($shopOrderRow['SO_DELIVERY_STATUS'] != "I"){
					goSendMail("013");
				}
			}
			/** 메일 전송 **/
		endforeach;

		## STEP 5.
		## 업로드 파일 삭제
		$fh->fileDelete($strFileInServer);

		$strUrl = $_SERVER['HTTP_REFERER'];
		$strMsg	= "엑셀파일 일괄수정 되었습니다.";
		
		echo "<script>alert('{$strMsg}');parent.location.reload();</script>";
		exit;		

	break;
	endswitch;
?>