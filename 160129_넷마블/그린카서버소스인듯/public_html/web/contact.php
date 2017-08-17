<?php
//$dbc = mysqli_connect('localhost', 'goodpsw', 'ledmir01', 'goodpsw');

$preg_email = '/^([0-9a-zA-Z_-]+)@([0-9a-zA-Z_-]+)(\.[0-9a-zA-Z_-]+){1,2}$/';

$specialcha = array("%","&","+","<",">","\r\n","'","\"");
$specialcha_hex = array("%25","%26","%2B","%3c","%3e","%0A","&#39","&#34");


if(empty($strName)){
	echo '&result=name_blank';
}elseif(empty($strEmail)){
	echo '&result=email_blank';
}elseif(!empty($strEmail) && !preg_match($preg_email,$strEmail)){
	echo '&result=email_error';
}elseif(empty($strBody)){
	echo '&result=body_blank';
}else{
	if(empty($strCorporate)){
		echo $strCorporate = "";
	}
	if(empty($strPhone)){
		echo $strPhone="";
	}
	
	$aPIC = array('info@seagullcoms.com','kkot@seagullcoms.com');
	
	for ($i=0;$i<count($aPIC);$i++){
		//error_reporting(E_ALL); // 에러 검증 모드
		$charset = 'UTF-8'; // 문자셋 : UTF-8
		if(!empty($strCorporate)){
			$subject = '[문의 via web] '.$strName."_".$strCorporate; // 제목
		}else{
			$subject = '[문의 via web] '.$strName; // 제목
		}
		$toName = 'SeaGullComs';
		$toEmail = $aPIC[$i];
		$fromName = $strName; // 보내는이 이름
		$fromEmail = $strEmail; // 보내는이 이메일주소
		$body= "<html><body>".
			"<p><span>이름: </span><span>".$strName."</span></p>".
			"<p><span>회사: </span><span>".$strCorporate."</span></p>".
			"<p><span>이메일: </span><span>".$strEmail."</span></p>".
			"<p><span>전화번호: </span><span>".$strPhone."</span></p>".
			"<p><span>문의 내용: </span><span>".$strBody."</span></p>".
			/*"<p><span>DB LINK: </span><span><a href='http://uwa64-033.cafe24.com/WebMysql/index.php?db=viies&table=battle&target=sql.php&token=520fc163424d9d907a53d28ad7b31ae8'>http://uwa64-033.cafe24.com/WebMysql/index.php?db=viies&table=battle&target=sql.php&token=520fc163424d9d907a53d28ad7b31ae8</a><span></p>".*/
			"</body></html>";
		$encoded_subject="=?".$charset."?B?".base64_encode($subject)."?=\n"; // 인코딩된 제목
		$to = "\"=?".$charset."?B?".base64_encode($toName)."?=\" <".$toEmail.">" ; // 인코딩된 받는이
		$from = "\"=?".$charset."?B?".base64_encode($fromName)."?=\" <".$fromEmail.">" ; // 인코딩된 보내는이
		$headers="MIME-Version: 1.0\n".
			"Content-Type: text/html;charset=".$charset.";format=flowed\n".
			//"To: ". $to ."\n".
			"From: ".$from."\n".
			//"Return-Path: ".$from."\n".
			"Content-Transfer-Encoding: 8bit\n"; // 헤더 설정						
		mail($to , $encoded_subject , $body , $headers); // 메일 보내기
	}
	
	echo '&result=success';
	
}
	


//mysql_close($db);
?>