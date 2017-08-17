<?
	/********************************************************************************************************************************************
		NICE신용평가정보 Copyright(c) KOREA INFOMATION SERVICE INC. ALL RIGHTS RESERVED
		
		서비스명 : 가상주민번호서비스 (IPIN) 서비스
		페이지명 : 가상주민번호서비스 (IPIN) 호출 페이지
	*********************************************************************************************************************************************/

	$sSiteIpinCode				= $settingRow["J_IPIN_SITE_CODE"];			// IPIN 서비스 사이트 코드		(NICE신용평가정보에서 발급한 사이트코드)
	$sSiteIpinPw				= $settingRow["J_IPIN_SITE_PASS"];			// IPIN 서비스 사이트 패스워드	(NICE신용평가정보에서 발급한 사이트패스워드)

	$sModulePath				= MALL_HOME."/web/frwork/cerity/IPINClient";			// 하단내용 참조
//	$sReturnURL					= "http://ivenet.eumshop.co.kr/kr/nice.ipinCheck.return.php";			// 하단내용 참조
	
	if ($strDevice == "m") $sReturnURL= "http://".$S_HTTP_HOST."/nice.ipinCheck.return.php";
	else $sReturnURL = "http://".$S_HTTP_HOST."/kr/nice.ipinCheck.return.php";			// 하단내용 참조
	
	$sCPRequest					= "";			// 하단내용 참조
		
	// 실행방법은 싱글쿼터(`) 외에도, 'exec(), system(), shell_exec()' 등등 귀사 정책에 맞게 처리하시기 바랍니다.
	$sCPRequest = `$sModulePath SEQ $sSiteIpinCode`;
	
	// 현재 예제로 저장한 세션은 ipin_result.php 페이지에서 데이타 위변조 방지를 위해 확인하기 위함입니다.
	// 필수사항은 아니며, 보안을 위한 권고사항입니다.
	$_SESSION['CPREQUEST'] = $sCPRequest;
    
    $sEncData					= "";			// 암호화 된 데이타
	$sRtnMsg					= "";			// 처리결과 메세지
	
    // 리턴 결과값에 따라, 프로세스 진행여부를 파악합니다.
    // 실행방법은 싱글쿼터(`) 외에도, 'exec(), system(), shell_exec()' 등등 귀사 정책에 맞게 처리하시기 바랍니다.
    $sEncData2	= `$sModulePath REQ $sSiteIpinCode $sSiteIpinPw $sCPRequest $sReturnURL`;
    
    // 리턴 결과값에 따른 처리사항
    if ($sEncData2 == -9)
    {
    	$sRtnMsg = "입력값 오류 : 암호화 처리시, 필요한 파라미터값의 정보를 정확하게 입력해 주시기 바랍니다.";
    } else {
    	$sRtnMsg = "$sEncData 변수에 암호화 데이타가 확인되면 정상, 정상이 아닌 경우 리턴코드 확인 후 NICE신용평가정보 개발 담당자에게 문의해 주세요.";
    }


	

?>