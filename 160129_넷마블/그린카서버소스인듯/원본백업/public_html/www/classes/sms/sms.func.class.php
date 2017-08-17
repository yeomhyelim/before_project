<?php
    /**
     * /home/shop_eng/www/classes/sms/sms.func.class.php
     * @author eumshop(thav@naver.com)
     * sms func class
     * **/

//	require_once "{$S_DOCUMENT_ROOT}www/classes/sms/sms.func.class.php";

	class SmsFunc {

		/** db info **/
		var $sms_db_host	= "localhost";
		var $sms_db_port	= "3306";
		var $sms_db_user	= "webbania_mall2";
		var $sms_db_pass	= "dndwls9123";
		var $sms_db_name	= "webbania_mall2";

		var $aryTagList		= "";

		function __construct() {

		}

		function getMessage() {
			echo "sms func class";
		}

		/**
		 * goSendSms($phone, $callbackPhone, $msg)
		 * SMS 문자 발송
		 * **/
		function goSendSms($phone, $callbackPhone, $msg) {
			
			## STEP 1. 
			## DB연결
			$smsDB					= new MySQL();
			$smsDB->host			= $this->sms_db_host . ":" . $this->sms_db_port;
			$smsDB->db				= $this->sms_db_name;
			$smsDB->user			= $this->sms_db_user;
			$smsDB->password		= $this->sms_db_pass;
			$smsDB->connectEx();

			## STEP 2.
			## 전송
			$param['tran_phone']		= $phone;
			$param['tran_callback']		= $callbackPhone;
			$param['tran_status']		= "1";
			$param['tran_date']			= "now()";
			$param['tran_msg']			= $msg;
			$param['tran_type']			= "4";

			$this->getSmsSendInsert($smsDB, $param);

			## STEP 10.
			## DB 종료
			$smsDB->disConnect();
		}


		## query

		/**
		 * getSmsSendInsert($db, $param)
		 * SMS 문자 발송 db에 데이터 등록
		 * **/
		function getSmsSendInsert($db, $param) {

			## sample
			## Insert into em_tran (tran_phone, tran_callback, tran_status, tran_date, tran_msg , tran_type) values ('010-000-0000', '010-000-0000', '1', sysdate(), 'Test Message입니다' ,4);";
			
			## Insert Into Oneshot_Tran (Status, Phone_No, Callback_No, Sms_Msg,Send_Time, Save_Time, Tran_Time, Msg_Type) Values	(0, '010-0000-0000', '0222688875', '발송 테스트',Now(), Now(), Now(), 4);
			$paramData					= "";
			$paramData['Status']		= $this->getSQLString("0");
			$paramData['Phone_No']		= $this->getSQLString($param['tran_phone']);
			$paramData['Callback_No']	= $this->getSQLString($param['tran_callback']);
			$paramData['Sms_Msg']		= $this->getSQLString($param['tran_msg']);
			$paramData['Send_Time']		= $this->getSQLFunction($param['tran_date']);
			$paramData['Save_Time']		= $this->getSQLFunction($param['tran_date']);
			$paramData['Tran_Time']		= $this->getSQLFunction($param['tran_date']);
			$paramData['Msg_Type']		= $this->getSQLInteger($param['tran_type']);

//			$param['tran_phone']	= $this->getSQLString($param['tran_phone']);
//			$param['tran_callback']	= $this->getSQLString($param['tran_callback']);
//			$param['tran_status']	= $this->getSQLString($param['tran_status']);
//			$param['tran_date']		= $this->getSQLFunction($param['tran_date']);
//			$param['tran_msg']		= $this->getSQLString($param['tran_msg']);
//			$param['tran_type']		= $this->getSQLInteger($param['tran_type']);

			return $db->getInsertParam("Oneshot_Tran", $paramData);
		}

		/**
		 * getSmsMoneySelect($db)
		 * 사이트 SMS 건수 가져오기
		 * **/
		function getSmsMoneySelect($db) {
			$query = "SELECT VAL FROM SITE_INFO WHERE COL = 'S_SMS_MONEY'";
			return $db->getSelect($query);
		}

		/**
		 * getSmsMoneyMinusUpdate($db)
		 * 사이트 SMS 건수 차감.
		 * **/
		function getSmsMoneyMinusUpdate($db) {
			$query = "UPDATE SITE_INFO SET VAL = VAL - 1 WHERE COL = 'S_SMS_MONEY'";
			return $db->getSelect($query);
		}


		## function

		/**
		 * getSQLString($str)
		 * SQL 문자형으로 형변환	ex) text => "text"
		 * **/		
		function getSQLString($str) {
			$str	= addslashes($str);
			return "\"{$str}\"";
		}

		/**
		 * getSQLString($str)
		 * SQL 정수형으로 형변환	ex) "" => 0
		 * **/		
		function getSQLInteger($int) {
			if($int) { return $int; }
			return 0;
		}

		/**
		 * getSQLFunction($str)
		 * MYSQL 함수명으로 사용
		 * **/	
		function getSQLFunction($str) {
			return $str;
		}
	}


//	/** 2013.04.18 sms send sample(상단) **/
//	/** 2013.04.18 여기에 추가되어야 함(문자관련) **/
//	$smsConfFile = "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/smsInfo.conf.inc.php";
//	if(is_file($smsConfFile)):
//		require_once $smsConfFile;
//		require_once "{$S_DOCUMENT_ROOT}www/classes/sms/sms.func.class.php";
//		$smsFunc = new SmsFunc();
//	endif;
//	/** 2013.04.18 여기에 추가되어야 함(문자관련) **/


//			/** 2013.04.18 sms send sample **/
//			/** 2013.04.18 SMS 전송 모듈 추가 **/
//			## SMS 사용 , 한국어 페이지 인 경우 SMS 전송 실행
//			if($SMS_INFO['S_SMS_USE']=="Y" && $S_SITE_LNG == "KR"):
//				$smsMoney = $smsFunc->getSmsMoneySelect($db); // 머니 체크
//				if($smsMoney['VAL'] > 0):
//					$smsCode			= "001";
//					$smsPhone			= "{$_POST['hp1']}{$_POST['hp2']}{$_POST['hp3']}";		
//					$smsCallBackPhone	= $S_COM_PHONE;
//					$smsMsg				= $SMS_TEXT_LIST[$smsCode]['SM_TEXT'];
//					$smsMsg				= str_replace("{{상점명}}", $S_SITE_KNAME, $smsMsg);
//					$smsMsg				= str_replace("{{고객명}}", $_POST['l_name'], $smsMsg);
//					if($SMS_TEXT_LIST[$smsCode]['SM_AUTO']): //  자동발송 사용..
//						$smsFunc->goSendSms($smsPhone, $smsCallBackPhone, $smsMsg);
//						$smsFunc->getSmsMoneyMinusUpdate($db); // 머니 -1
//					endif;
//				else:
//					// sms 머니 부족.. 부분 처리..
//				endif;
//			endif;
//			/** 2013.04.18 SMS 전송 모듈 추가 **/

?>
