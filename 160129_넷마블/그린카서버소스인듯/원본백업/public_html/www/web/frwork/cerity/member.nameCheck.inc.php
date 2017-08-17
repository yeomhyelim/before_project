<?
    $sSiteCode		= $settingRow["J_JUMIN_SITE_CODE"];					// NICE신용평가정보로부터 부여받은 사이트 코드
    $sSitePassword	= $settingRow["J_JUMIN_SITE_PASS"];					// NICE신용평가정보로부터 부여받은 사이트 패스워드
    
   //아이핀연계정보는 별도 계약 입니다. 계약 확인후 진행해 주세요.
    //$sIPINSiteCode	= $settingRow["J_IPIN_SITE_CODE"];					// NICE신용평가정보로부터 부여받은 아이핀사이트 코드?DI/CI 응답이 필요한 경우 사용)
    //$sIPINPassword	= $settingRow["J_IPIN_SITE_PASS"];					// NICE신용평가정보로부터 부여받은 아이핀사이트 패스워드
    
	if ($strDevice == "m") $sReturnURL = "http://".$S_HTTP_HOST."/nice.nameCheck.return.php";	
	else $sReturnURL = "http://".$S_HTTP_HOST."/kr/nice.nameCheck.return.php";						//결과 수신 URL
    
	$sRequestNO		= "";												//요청 번호, 이는 성공/실패후에 같은 값으로 되돌려주게 되므로 필요시 사용
    $sBGType		= "";												//서비스 화면 색상 선택
    $sClientImg		= "";												//서비스 화면 로고 선택(full 도메인 입력해주세요.)
    
    $cb_encode_path = MALL_HOME."/web/frwork/cerity/CPClient";			// NICE신용평가정보로부터 받은 암호화 프로그램의 위치 (절대경로+모듈명)_Linux ..
    
    $sReserved1		= "";
    $sReserved2		= "";
    $sReserved3		= "";
    
    $sRequestNO = `$cb_encode_path SEQ $sSiteCode`;		//요청고유번호 / 비정상적인 접속 차단을 위해 필요

	$_SESSION["REQ_SEQ"] = $sRequestNO;					//해킹등의 방지를 위하여 세션을 쓴다면, 세션에 요청번호를 넣는다.

	//echo "sRequestNO : ".$sRequestNO."<br>";
	
    // 입력될 plain 데이타를 만든다.
    $plaindata =  "7:RTN_URL" . strlen($sReturnURL) . ":" . $sReturnURL.
    			  "7:REQ_SEQ" . strlen($sRequestNO) . ":" . $sRequestNO.
    			  "7:BG_TYPE" . strlen($sBGType) . ":" . $sBGType.
    			  "7:IMG_URL" . strlen($sClientImg) . ":" . $sClientImg;

	$plaindata1 = "7:RTN_URL" . strlen($sReturnURL) . ":" . $sReturnURL.
    			  "7:REQ_SEQ" . strlen($sRequestNO) . ":" . $sRequestNO.
    			  "7:BG_TYPE" . strlen($sBGType) . ":" . $sBGType.
    			  "7:IMG_URL" . strlen($sClientImg) . ":" . $sClientImg.
    			  "9:RESERVED1" . strlen($sReserved1) . ":" . $sReserved1.
    			  "9:RESERVED2" . strlen($sReserved2) . ":" . $sReserved2.
    			  "9:RESERVED3" . strlen($sReserved3) . ":" . $sReserved3;
    
	$plaindata2 = "7:RTN_URL" . strlen($sReturnURL) . ":" . $sReturnURL.
    			  "7:REQ_SEQ" . strlen($sRequestNO) . ":" . $sRequestNO.
    			  "7:BG_TYPE" . strlen($sBGType) . ":" . $sBGType.
    			  "7:IMG_URL" . strlen($sClientImg) . ":" . $sClientImg.
    			  "13:IPIN_SITECODE" . strlen($sIPINSiteCode) . ":" . $sIPINSiteCode.
    			  "17:IPIN_SITEPASSWORD" . strlen($sIPINPassword) . ":" . $sIPINPassword;

	$sEncData1 = `$cb_encode_path ENC $sSiteCode $sSitePassword $plaindata`;
 
 	//echo $sEncData."<br>";
 
    if( $sEncData1 == -1 )
    {
        $returnMsg = "암/복호화 시스템 오류입니다.";
    }
    else if( $sEncData1== -2 )
    {
        $returnMsg = "암호화 처리 오류입니다.";
    }
    else if( $sEncData1== -3 )
    {
        $returnMsg = "암호화 데이터 오류 입니다.";
    }
    else if( $sEncData1== -9 )
    {
        $returnMsg = "입력값 오류 입니다.";
    }
?>