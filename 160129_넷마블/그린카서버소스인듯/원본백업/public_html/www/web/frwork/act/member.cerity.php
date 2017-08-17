<?
	$sSiteCode		= "N671";					// NICE신용평가정보로부터 부여받은 사이트 코드
    $sSitePassword	= "17867672";					// NICE신용평가정보로부터 부여받은 사이트 패스워드

    $cb_encode_path = MALL_HOME."/web/frwork/cerity/CPClient";			// NICE신용평가정보로부터 받은 암호화 프로그램의 위치 (절대경로+모듈명)

    $enc_data		= $_POST["enc_data"];								// 암호화된 결과 데이타
  	//////////////////////////////////////////////// 문자열 점검///////////////////////////////////////////////
	if(preg_match("/[#\&\\-%@\\\:;,\.\'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", $enc_data, $match)) {echo "문자열 점검오류 : ".$match[0]; exit;}
	///////////////////////////////////////////////////////////////////////////////////////////////////////////    
       
    if ($enc_data != "") {

        $plaindata = `$cb_encode_path DEC $sSiteCode $sSitePassword $enc_data`;		// 암호화된 결과 데이터의 복호화
        
        if ($plaindata == -1){
            $returnMsg  = "암/복호화 시스템 오류";
        }else if ($plaindata == -4){
            $returnMsg  = "복호화 처리 오류";
        }else if ($plaindata == -5){
            $returnMsg  = "HASH값 불일치 - 복호화 데이터는 리턴됨";
        }else if ($plaindata == -6){
            $returnMsg  = "복호화 데이터 오류";
        }else if ($plaindata == -9){
            $returnMsg  = "입력값 오류";
        }else if ($plaindata == -12){
            $returnMsg  = "사이트 비밀번호 오류";
        }else{
            
            // 복호화가 정상적일 경우 데이터를 파싱합니다.
            $returnMsg  = "본인인증이 확인되었습니다.";
            $ciphertime = `$cb_encode_path CTS $sSiteCode $sSitePassword $enc_data`;	// 암호화된 결과 데이터 검증 (복호화한 시간획득)
        	
            $sRequestNO = GetValue($plaindata , "REQ_SEQ");
            $sResult = GetValue($plaindata , "NC_RESULT");
            
            echo "[실명확인결과 : ".$sResult."]<br>"; 
            echo "[이름 : ".GetValue($plaindata , "NAME")."]<br>"; 
            echo "[안심KEY : ".GetValue($plaindata , "SAFEID")."]<br>"; 
            echo "[요청고유번호 : ".$sRequestNO."]<br>"; 
            echo "[IPIN_DI : ".GetValue($plaindata , "IPIN_DI")."]<br>"; 
            echo "[IPIN_CI : ".GetValue($plaindata , "IPIN_CI")."]<br>"; 
            echo "[RESERVED1 : ".GetValue($plaindata , "RESERVED1")."]<br>"; 
            echo "[RESERVED2 : ".GetValue($plaindata , "RESERVED2")."]<br>"; 
            echo "[RESERVED3 : ".GetValue($plaindata , "RESERVED3")."]<br>"; 
                        
            if(strcmp($_SESSION["REQ_SEQ"] , $sRequestNO) )
            {
            	echo "세션값이 다릅니다. 올바른 경로로 접근하시기 바랍니다.<br>";
                $sRequestNO = "";
                
            }
        }
    }
?>

<?
    function GetValue($str , $name)
    {
        $pos1 = 0;  //length의 시작 위치
        $pos2 = 0;  //:의 위치

        while( $pos1 <= strlen($str) )
        {
            $pos2 = strpos( $str , ":" , $pos1);
            $len = substr($str , $pos1 , $pos2 - $pos1);
            $key = substr($str , $pos2 + 1 , $len);
            $pos1 = $pos2 + $len + 1;
            if( $key == $name )
            {
                $pos2 = strpos( $str , ":" , $pos1);
                $len = substr($str , $pos1 , $pos2 - $pos1);
                $value = substr($str , $pos2 + 1 , $len);
                return $value;
            }
            else
            {
                // 다르면 스킵한다.
                $pos2 = strpos( $str , ":" , $pos1);
                $len = substr($str , $pos1 , $pos2 - $pos1);
                $pos1 = $pos2 + $len + 1;
            }            
        }
    }
?>

<html>
<head>
    <title>NICE신용평가정보 - NiceID 안심실명인증 테스트</title>
</head>
<body>
    <center>
    <p><p><p><p>
    <table width=500 border=1>
        <tr>
            <td>결과</td>
            <td><?= $returnMsg ?></td>
        </tr>
        <tr>
            <td>리턴코드값</td>
            <td><?= $sResult ?></td>
        </tr>
        <tr>
            <td>복호화한 시간</td>
            <td><?= $ciphertime ?> (YYMMDDHHMMSSSSS)</td>
        </tr>
        <tr>
            <td>요청 번호</td>
            <td><?= $sRequestNO ?></td>
        </tr>            
        
    </table>
    </center>
</body>
</html>