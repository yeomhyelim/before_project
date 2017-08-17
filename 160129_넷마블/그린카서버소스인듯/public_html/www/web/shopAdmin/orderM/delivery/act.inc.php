<?

	require_once MALL_CONF_LIB."OrderAdmMgr.php";
	require_once MALL_CONF_LIB."ProductAdmMgr.php";
	require_once MALL_CONF_LIB."MemberAdmMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";
	require_once MALL_CONF_LIB."CouponMgr.php";
	require_once MALL_CONF_LIB."ShopOrderNewMgr.php";
	require_once MALL_CONF_LIB."ShopMgr.php";

	$orderMgr = new OrderMgr();
	$productMgr = new ProductAdmMgr();
	$memberMgr = new MemberMgr();
	$siteMgr = new SiteMgr();
	$couponMgr = new CouponMgr();
	$shopOrderMgr = new ShopOrderMgr();
	$shopMgr		= new ShopMgr();

	/*##################################### Parameter 셋팅 #####################################*/
	$intPage	= $_POST["page"] ? $_POST["page"]	: $_REQUEST["page"];
	/*##################################### Parameter 셋팅 #####################################*/

	$siteRow = $siteMgr->getSiteInfo($db);

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
	//$aryDeliveryCom = getCommCodeList("DELIVERY","Y");
	
	switch ($strAct) {
		
		case "orderDeliveryExcelUpdate":
			// 배송정보 엑셀 파일로 일괄 수정
			
			## STEP 1.
			## 파일 체크
			$_FILE		= $_FILES['excelFile'];
			if($_FILE['error'] > 0) :
				// error 처리
				$strUrl = $_SERVER['HTTP_REFERER'];
				$strMsg	= "파일 업로드시 오류가 발생했습니다. 잠시후에 다시 시도하시기 바랍니다.";
				goErrMsg($strUrl,$strMsg);
				break;
				exit;
			endif;
			if(!$_FILE['name']):
				// 파일명이 없을 때 처리.
				$strUrl = $_SERVER['HTTP_REFERER'];
				$strMsg	= "등록된 파일이 없습니다.";
				goErrMsg($strUrl,$strMsg);
				break;
				exit;
			endif;
			$fileInfo = pathinfo($_FILE['name']);
			if($fileInfo['extension'] != "xls"):
				// 엑셀 파일이 아닌 경우
				$strUrl = $_SERVER['HTTP_REFERER'];
				$strMsg	= "지정된 파일이 아닙니다.";
				goErrMsg($strUrl,$strMsg);
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
				goErrMsg($strUrl,$strMsg);
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
				goErrMsg($strUrl,$strMsg);
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
				if(!$data[$cellCode]) { continue; } /** 주문 장바구니 번호가 없는 경우 변경 불가 **/

				$strDeliveryCom					= $data[$cellDeliveryCom];		// 배송 회사 번호
				$strDeliveryStatus				= "I";							// 배송중
				$strDeliveryNum					= $data[$cellDeliveryNum];
				if(!$data[$cellDeliveryCom] || !$data[$cellDeliveryNum]) { $strDeliveryStatus ="B"; } // 배송준비중
				
				## update 
				$param							= "";
				$param["O_NO"]					= "";
				$param["OC_NO"]					= $data[$cellCode];
				$param["OC_DELIVERY_STATUS"]	= $strDeliveryStatus;
				$param["OC_DELIVERY_COM"]		= $aryDeliveryComName[$strDeliveryCom];
				$param["OC_DELIVERY_NUM"]		= $strDeliveryNum;
				$param["OC_MOD_NO"]				= $a_admin_no;
				$param["OC_REG_NO"]				= $a_admin_no;

				if ($strDeliveryStatus == "I") {
					$param["OC_DELIVERY_ST_DT"]	= $S_NOW_TIME_FORMAT2;
				}
				$shopOrderMgr->getOrderCartStatusUpdate($db,$param);

				$intO_NO						= $shopOrderMgr->getOrderNo($db,$param);
				$param["O_NO"]					= $intO_NO;
				if ($intO_NO > 0){
					
					/* 이메일 발송 내역 */
					if ($strDeliveryStatus == "I") 
					{
						/* 주문 내역 */
						if (is_array($arrOrderSendMail)) array_push($arrOrderSendMail, $intO_NO);
						else $arrOrderSendMail = array($intO_NO);
						
						/* 주문 장바구니 내역 */
						if (is_array($arrOrderCartSendMail[$intO_NO])) {
							if (!in_array($data[$cellCode],$arrOrderCartSendMail[$intO_NO])) array_push($arrOrderCartSendMail[$intO_NO], $data[$cellCode]);
						}else $arrOrderCartSendMail[$intO_NO] = array($data[$cellCode]);
					}
					/* 이메일 발송 내역 */
										
					$orderMgr->setO_NO($intO_NO);
					$orderRow			= $orderMgr->getOrderView($db);
					$strOrderPrevStatus	= $orderRow["O_STATUS"];

					$shopOrderMgr->getOrderStatusAllUpdate($db,$param);	
					
					/* 마스터 주문상태가 변경되었을때 포인트/쿠폰 작업을 진행한다*/
					include MALL_WEB_PATH."shopAdmin/orderM/list/orderMallStatusUpdate.php";
				}

			endforeach;

			
			/* 이메일 발송하기 */
			if (is_array($arrOrderSendMail)){
				$arrOrderSendMail = array_unique($arrOrderSendMail);
				foreach($arrOrderSendMail as $key => $val){
					
					$intO_NO			= $val;
					$strOrderCartNo		= "";
					foreach($arrOrderCartSendMail[$intO_NO] as $cartKey => $cartVal){
						$strOrderCartNo .= $cartVal.",";
					}
					if ($strOrderCartNo) $strOrderCartNo = substr($strOrderCartNo,0,strlen($strOrderCartNo)-1);
					
					if ($intO_NO > 0 && $strOrderCartNo){
						
						/** 메일 전송 - 고객 주문 배송 메일 **/
						$orderMgr->setO_NO($intO_NO);
						$orderRow = $orderMgr->getOrderView($db);
						
						$param				= "";
						$param["O_NO"]		= $intO_NO;
						$param["O_USE_LNG"] = $orderRow["O_USE_LNG"];
						$param["OC_NO"]		= "";
						$param["IN_OC_NO"]	= $strOrderCartNo;				
						$param["O_SHOP_NO"]	= -1;
						$cartResult			= $shopOrderMgr->getOrderCartList($db,"OP_RESULT",$param);
						$intCartTotal		= $cartResult["cnt"];

						if ($S_MALL_TYPE != "R"){
							$param['O_NO']		= $intO_NO;
							$aryCartShopInfo	= $shopOrderMgr->getOrderCartShopInfo($db,$param);
						}

						/** 메일 전송 - 고객 주문 배송 메일 **/
						$strMailSendMode	= "adm";
						$strMailMode		= "orderDeliverySend";
						include WEB_FRWORK_ACT."orderCartMailForm.v2.0.inc.php";
						
						$aryTAG_LIST['{{__받는사람이름__}}']	= $orderRow['O_J_NAME'];
						$aryTAG_LIST['{{__받는사람메일__}}']	= $orderRow['O_J_MAIL'];
						$aryTAG_LIST['{{__회원명__}}']			= $orderRow['O_J_NAME'];
						$aryTAG_LIST['{{__주문번호__}}']		= $orderRow['O_KEY'];
						$aryTAG_LIST['{{__주문상품내역__}}']	= $strOrderCartHtml;
						$aryTAG_LIST['{{__주문배송정보__}}']	= $strOrderInfoHtml;
						$aryTAG_LIST['{{__배송사__}}']			= "";
						$aryTAG_LIST['{{__운송장번호__}}']		= "";
						$aryTAG_LIST['{{__주문일자__}}']		= SUBSTR($orderRow['O_REG_DT'],0,10);
						
						goSendMail("013");
						/** 메일 전송 - 고객 주문 배송 메일 **/
					}
				}
			}

			## STEP 5.
			## 업로드 파일 삭제
			$fh->fileDelete($strFileInServer);
			
			$strUrl = $_SERVER['HTTP_REFERER'];
			$strMsg	= "송장엑셀파일 데이터가 일괄수정 되었습니다.";
			
			echo "<script>alert('{$strMsg}');parent.location.reload();</script>";
			exit;		

		break;
	}


?>