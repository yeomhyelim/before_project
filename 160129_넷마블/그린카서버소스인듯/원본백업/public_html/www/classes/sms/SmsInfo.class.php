<?php
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2013-11-12												|# 
#|작성내용	: sms 전송 클레스											|# 
#/*====================================================================*/# 

class SmsInfo extends MySQL {

	private $siteDB				= null;

	function initConfig() {
	}

	function __construct($db) {

		global $DB_PATH;

		## site db connect
		$this->siteDB				= $db;		

		## 기본 설정
		//$dbSmsPath					= "/home/wjholdings/public_html/config/db.php";
		$dbSmsPath					= $DB_PATH;

		## sms 모듈 체크
		if(!$dbSmsPath):
			return;
		endif;

		if(!is_file($dbSmsPath)):
			return;
		endif;

		## config 파일 설정
		$conf_set = parse_ini_file("$dbSmsPath");
		@extract($conf_set);

		## 서버 정보 설정
		$this->host			= $db_host;
		$this->db			= $db_name;
		$this->user			= $db_user;
		$this->password		= $db_pass;
	}

	function goSendSms($paramData) {
		
		## DB 연결
		$this->connectEx();

		## 기본 설정
		$strPhone						= $paramData['phone'];
		$strCallBack					= $paramData['callBack'];
		$strMsg							= $paramData['msg'];
		$intType						= $paramData['type'];
		$strSiteName					= $paramData['siteName'];

		## 기본 설정 체크
		if(!$this->getCheckSmsMoney()) { return; }
		if(!$strPhone) { return; }
		if(!$strCallBack) { return; }		
		if(!$strMsg) { return; }
		if(!$strSiteName) { return; }

		## 초기화
		if(!$intType) { $intType = 4; }
//		$strMsg = iconv('CP949','UTF-8', strHanCut(iconv('UTF-8','CP949',$strMsg), 80));
//iconv시 문자 사라짐 2015.06.10 kjp
//		$strMsg = iconv('CP949','UTF-8//IGNORE', strHanCutUtf(iconv('UTF-8','CP949//IGNORE',$strMsg), 80));

		## 등록
		$param['Phone_No']		= $this->getSQLString($strPhone);
		$param['Callback_No']	= $this->getSQLString($strCallBack);
		$param['Sms_Msg']		= $this->getSQLString($strMsg);
		$param['Send_Time']		= $this->getSQLDatetime('NOW()');
		$param['Save_Time']		= $this->getSQLDatetime('NOW()');
		$param['Tran_Time']		= $this->getSQLDatetime('NOW()');
		$param['Msg_Type']		= $this->getSQLInteger($intType);
		$param['Etc1']			= $this->getSQLString($strSiteName);
		$param['Status']		= $this->getSQLString(0);
		$this->getInsertParam("Oneshot_Tran", $param);

		## 차감
		$this->getSmsMoneyMinusUpdate();

		## DB 종료
		$this->disConnect();
	}


	function getLogSelectEx($op, $param) {

		## DB 연결
		$this->connectEx();

		## 모듈 설정
		$emTran					= new EmTranModule($this);	
		
		## 데이터 불러오기
		$result					= $emTran->getEmTranSelectEx($op, $param);

		## DB 종료
		$this->disConnect();
		
		## 리턴
		return $result;
	}

	function getCheckSmsMoney() {

		global $S_SMS_USE, $S_SITE_LNG;

		## 유효성 체크
		if($S_SMS_USE != "Y") { return false; }
		if($S_SITE_LNG != "KR") {return false; }

		$smsMoney = $this->getSmsMoneySelect(); // 머니 체크

		if($smsMoney['VAL'] <= 0) { return false; }

		return true;
	}

	/**
	 * getSmsMoneySelect(&$db)
	 * 사이트 SMS 건수 가져오기
	 * **/
	function getSmsMoneySelect() {
		$query = "SELECT VAL FROM SITE_INFO WHERE COL = 'S_SMS_MONEY'";

		return $this->siteDB->getSelect($query);
	}

	/**
	 * getSmsMoneyMinusUpdate(&$db)
	 * 사이트 SMS 건수 차감.
	 * **/
	function getSmsMoneyMinusUpdate() {
		$query = "UPDATE SITE_INFO SET VAL = VAL - 1 WHERE COL = 'S_SMS_MONEY'";
		return $this->siteDB->getSelect($query);
	}

	function getSmsInfo($no, $param) {

		include SHOP_HOME . "/conf/shop.inc.php";
		include SHOP_HOME . "/conf/smsInfo.conf.inc.php";

		## 기본 설정
		if(!$param['{{상점명}}']) { $param['{{상점명}}'] = $S_SITE_KNAME; }

		## 문자 설정
		$strText								= $SMS_TEXT_LIST[$no]['SM_TEXT'];
		foreach($param as $key => $data):
			$strText							= str_replace($key, $data, $strText);
		endforeach;
		$SMS_TEXT_LIST[$no]['SM_TEXT']			= $strText;
		$SMS_TEXT_LIST[$no]['SITE_NAME']		= $S_SITE_KNAME;
		$SMS_TEXT_LIST[$no]['COM_PHONE']		= $S_COM_PHONE;
		$SMS_TEXT_LIST[$no]['S_COM_HP']			= $S_COM_HP;

		return $SMS_TEXT_LIST[$no];

	}
}