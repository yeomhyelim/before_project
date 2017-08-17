<?

#/*====================================================================*/#
#|화일명	: mail.func.php												|#
#|작성자	: 김희성													|#
#|작성일	: 2012.11.21												|#
#|작성내용	: 메일함수													|#
#/*====================================================================*/#

$aryTAG_LIST = array (	"{{__사이트이름__}}" => $S_SITE_NM,
						"{{__회원명__}}" => $g_member_name,
						"{{__회사명__}}" => $S_COM_NM,
						"{{__대표자명__}}" => $S_REP_NM,
						"{{__사업자번호__}}" => $S_COM_NUM1,
						"{{__통신번호__}}" => $S_COM_NUM2,
						"{{__전화번호__}}" => $S_COM_PHONE,
						"{{__개인정보_담당자__}}" => $S_PIM_NAME,
						"{{__개인정보_이메일__}}" => $S_PIM_MAIL,
						"{{__사이트주소__}}" => $S_SITE_URL,
						"{{__오늘날짜__}}" => date("Y년m월d일"),
						"{{__사이트로고__}}" => "",
						"{{__회사주소__}}" => $S_COM_ADDR	);

function goSendMail($strCode,$strLng="")
{
	global $aryTAG_LIST, $EM_SETTING_USE, $EM_SETTING_DATA, $S_DOCUMENT_ROOT, $S_SHOP_HOME, $S_SITE_NAME;
	global $S_SITE_LNG;
	require_once MALL_HOME . "/classes/email/email.class.php";
	$emailInfo	= new EmailInfo ;
	if($EM_SETTING_USE == "N") :
		// 메일 전체 사용 안함.
		return;
	endif;

	if (!$strLng) $strLng = $S_SITE_LNG;
	$aryTAG_LIST['{{__보내는사람이름__}}']		= $aryTAG_LIST['{{__사이트이름__}}'];
	$aryTAG_LIST['{{__보내는사람메일__}}']		= $EM_SETTING_DATA[$strLng][$strCode]['EM_SENDER'];
	$aryTAG_LIST['{{__메일제목__}}']			= $EM_SETTING_DATA[$strLng][$strCode]['EM_TITLE'];

	if( $EM_SETTING_DATA[$strLng][$strCode]['EM_AUTO'] == "Y" ) :

		// 메일 보내기 실행
		$strMailFromName		= $aryTAG_LIST['{{__보내는사람이름__}}'];
		$strMailFromAddr		= $aryTAG_LIST['{{__보내는사람메일__}}'];
		$strMailTitle			= $aryTAG_LIST['{{__메일제목__}}'];
		$strMailToName			= $aryTAG_LIST['{{__받는사람이름__}}'];
		$strMailToAddr			= $aryTAG_LIST['{{__받는사람메일__}}'];

		if (!$strLng) $strLng = "KR";
		$strMailContentsFile	= sprintf("%s%s/layout/mail/mailContents_%s_%s.html", $S_DOCUMENT_ROOT, $S_SHOP_HOME, strtolower($strLng),$strCode);
		$strContents			= file_get_contents($strMailContentsFile);

		foreach($aryTAG_LIST as $key => $value) :
			$strContents	= str_replace($key, $value, $strContents);
			$strMailTitle	= str_replace($key, $value, $strMailTitle);
		endforeach;


		## 기본 설정
		$memberNo					= $_POST['memberNo'];
		$sendName					= $_POST['sendName'];
		$sendEmail					= $_POST['sendEmail'];
		$receiveName				= $_POST['receiveName'];
		$receiveEmail				= $_POST['receiveEmail'];
		$title						= $_POST['title'];
		$text						= $_POST['text'];

		$param							= array () ;
		$param['SEND_NAME']				= $strMailFromName;
		$param['SEND_EMAIL']			= $strMailFromAddr;
		$param['RECEIVE_NAME']			= $strMailToName;
		$param['RECEIVE_EMAIL']			= $strMailToAddr;
		$param['TITLE']					= $strMailTitle;
		$param['TEXT']					= $strContents;
		return $emailInfo->goSendEmail($param);
		//sendMail($strMailFromName, $strMailFromAddr, $strMailTitle, $strContents,"Y", $strMailToName, $strMailToAddr,"UTF-8");

	endif;
}

function goSendMail2($strCode,$strLng="")
{
	global $aryTAG_LIST, $EM_SETTING_USE, $EM_SETTING_DATA, $S_DOCUMENT_ROOT, $S_SHOP_HOME, $S_SITE_NAME;
	global $S_SITE_LNG;

	if($EM_SETTING_USE == "N") :
		// 메일 전체 사용 안함.
		return;
	endif;

	if (!$strLng) $strLng = $S_SITE_LNG;
	$aryTAG_LIST['{{__보내는사람이름__}}']		= $aryTAG_LIST['{{__사이트이름__}}'];
	$aryTAG_LIST['{{__보내는사람메일__}}']		= $EM_SETTING_DATA[$strLng][$strCode]['EM_SENDER'];
	$aryTAG_LIST['{{__메일제목__}}']			= $EM_SETTING_DATA[$strLng][$strCode]['EM_TITLE'];

	if( $EM_SETTING_DATA[$strLng][$strCode]['EM_AUTO'] == "Y" ) :

		// 메일 보내기 실행
		$strMailFromName		= $aryTAG_LIST['{{__보내는사람이름__}}'];
		$strMailFromAddr		= $aryTAG_LIST['{{__보내는사람메일__}}'];
		$strMailTitle			= $aryTAG_LIST['{{__메일제목__}}'];
		$strMailToName			= $aryTAG_LIST['{{__받는사람이름__}}'];
		$strMailToAddr			= $aryTAG_LIST['{{__받는사람메일__}}'];

		if (!$strLng) $strLng = "KR";
		$strMailContentsFile	= sprintf("%s%s/layout/mail/mailContents_%s_%s.html", $S_DOCUMENT_ROOT, $S_SHOP_HOME, strtolower($strLng),$strCode);
		$strContents			= file_get_contents($strMailContentsFile);

		foreach($aryTAG_LIST as $key => $value) :
			$strContents	= str_replace($key, $value, $strContents);
			$strMailTitle	= str_replace($key, $value, $strMailTitle);
		endforeach;

		//sendMail($strMailFromName, $strMailFromAddr, $strMailTitle, $strContents,"Y", $strMailToName, $strMailToAddr,"UTF-8");

		require_once('/home/shop_eng/demo2/php_mail/class.phpmailer.php');

		$mail             = new PHPMailer();

		$body             = $strContents;
		$body             = eregi_replace("[\]",'',$body);

		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->Host       = "127.0.0.1"; // SMTP server
//		$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
												   // 1 = errors and messages
												   // 2 = messages only
		$mail->SMTPAuth   = false;                  // enable SMTP authentication
		$mail->Host       = "127.0.0.1"; // sets the SMTP server
		$mail->Port       = 25;                    // set the SMTP port for the GMAIL server
		//$mail->Username   = "yourname@yourdomain"; // SMTP account username
		//$mail->Password   = "yourpassword";        // SMTP account password

		$mail->SetFrom($strMailFromAddr, $strMailFromName);

		//$mail->AddReplyTo("name@yourdomain.com","First Last");

		$mail->Subject    = $strMailTitle;
		$mail->MsgHTML($body);
		$address = $strMailToAddr;
		$mail->AddAddress($address, $strMailToName);
		$mail->Send();
//
//		if(!$mail->Send()) {
//		  echo "Mailer Error: " . $mail->ErrorInfo;
//		} else {
//		  echo "Message sent!";
//		}
	endif;
}
?>