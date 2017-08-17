<?php
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2013-11-12												|# 
#|작성내용	: sms 전송 클레스											|# 
#/*====================================================================*/# 
# www/web/shopAdmin/member/member/json.inc.php 에서만 사용

class SmsFunc2 extends MySQL {

	function initConfig() {
		
	}

	function __construct() {

		global $DB_PATH;

		## 기본 설정
		//$dbSmsPath					= WEB_CONF_DB_SMS;
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

		## 모듈 설정
		require_once MALL_HOME . "/module2/EmTran.module.php";
		$emTran					= new EmTranModule($this);	

		## 기본 설정
		$tranPhone						= $paramData['phone'];
		$tranCallback					= $paramData['callBack'];
		$tranMsg						= $paramData['msg'];
		$tranType						= $paramData['type'];
		$tranEtc1						= $paramData['siteName'];

		## 기본 설정 체크
		if(!$tranPhone):
			return;
		endif;

		if(!$tranCallback):
			return;
		endif;
		
		if(!$tranMsg):
			return;
		endif;
		
		if(!$tranType) { $tranType = 4; }


		## 데이터 등록
		$param							= "";
//		$param['tran_pr']				= $tranPr;				// 자동 증가하는 것으로 em_tran의 primary key가 된다.
		$param['tran_refkey']			= $tranRefkey;			// 참조용으로 사용되는 것으로 메시지 전송시에는 사용되지 않는다.
		$param['tran_id']				= $tranId;				// 참조용으로 사용되는 것으로 메시지 전송시에는 사용되지 않는다.
		$param['tran_phone']			= $tranPhone;			// 수신자 전화번호
		$param['tran_callback']			= $tranCallback;		// 송신자 전화번호 (생략가능)
		$param['tran_status']			= 1;					// 메시지 상태 (1. 전송요구, 2.SMSG에 전송됨, 결과 대기중, SMSG에 서 결과 받음)
		$param['tran_date']				= "NOW()";				// 메시지 접수시간
		$param['tran_rsltdate']			= $tranReltdate;		// 핸드폰에 전달된 시간 (망사업자가 보내오는)
		$param['tran_reportdate']		= $tranReportdate;		// 결과 수신 시간
		$param['tran_rslt']				= $tranRslt;			// 전송결과 (결과코드는 아래 표 참조)
		$param['tran_net']				= $tranNet;				// 전송 메시지
		$param['tran_msg']				= $tranMsg;				// 사용자 임의로 사용할 수 있는 필드. SMS 전송 시에는 전혀 사용되지 않음.
		$param['tran_etc1']				= $tranEtc1;			// 사용자 임의로 사용할 수 있는 필드. SMS 전송 시에는 전혀 사용되지 않음. MMS 전송 시에는, tran_seq 가 들어간다. (사이트 기본정보)
		$param['tran_etc2']				= $tranEtc2;			// 
		$param['tran_etc3']				= $tranEtc3;			// 
		$param['tran_etc4']				= $tranEtc4;			// 
		$param['tran_type']				= $tranType;			// URL전송, 메시지 전송 등의 SMS형태를 구분하기 위한 필드. (4: SMS 전송 ,  5:  URL 전송 ,  6: MMS전송)
		$emTran->getEmTranInsertEx($param);

		## DB 종료
		$this->disConnect();
	}

	function getLogSelectEx($op, $param) {

		## DB 연결
		$this->connectEx();

		## 모듈 설정
		require_once MALL_HOME . "/module2/EmTran.module.php";
		$emTran					= new EmTranModule($this);	
		
		## 데이터 불러오기
		$result					= $emTran->getEmTranSelectEx($op, $param);

		## DB 종료
		$this->disConnect();
		
		## 리턴
		return $result;
	}
}