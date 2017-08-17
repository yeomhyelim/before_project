<?

	//require_once MALL_CONF_LIB."MobileMgr.php";
	//모바일 App관련 설정 하나로 묶음
	//include	MALL_SHOP."/include/mobileApp.inc.php";
	
	//$strAndroidApiKey = "AIzaSyDH0GbiklmX4Qeu_tX1FhajiFMojLx8oeM";
	$strAndroidApiKey = "AIzaSyDeNgfzGDq3cngOUUaBJsRwjVaquXP5jFk";
	
	
	include MALL_CONF_LIB."MobileMgr.php";
	include MALL_CONF_LIB."mobileAndMgr.php";
	include MALL_CONF_LIB."mobileIOSMgr.php";
	
	$MobileMgr = new MobileMgr();

	/*##################################### Parameter 셋팅 #####################################*/
	$strDeviceKey	= $_POST["DeviceKey"]		? $_POST["DeviceKey"]		: $_REQUEST["DeviceKey"];
	$intPage		= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];
	$strM_ID	= $_POST["M_ID"]		? $_POST["M_ID"]		: $_REQUEST["M_ID"]; // 로그인ID 추가
	
	if($intM_NO)
	{
		$MobileMgr->setM_NO($intM_NO);
	}
	//$MobileMgr->setM_NO(1);
	//$MobileMgr->setMOBILE_KEY($strApiKey);


	## 모바일 OS확인
	$strUserAgent = $_SERVER['HTTP_USER_AGENT'];
	//$aryIos = array('iPod','iPhone');
	//$aryAndroid = array('Android');

//

	if( stristr($_SERVER['HTTP_USER_AGENT'],'ipad') ) {
			$strMobileDeviceOs = "A";
		} else if( stristr($_SERVER['HTTP_USER_AGENT'],'iphone') || strstr($_SERVER['HTTP_USER_AGENT'],'iphone') ) {
			$strMobileDeviceOs = "A";
		} else if( stristr($_SERVER['HTTP_USER_AGENT'],'blackberry') ) {
			$strMobileDeviceOs = "A";
		} else if( stristr($_SERVER['HTTP_USER_AGENT'],'android') ) {
			$strMobileDeviceOs = "G";
		}else{
			$strMobileDeviceOs = "A";
			}
	
//
/*
	if(in_array($strUserAgent,$aryIos))
	{
		$strMobileDeviceOs = 'A';
	}
	elseif(in_array($strUserAgent,$aryAndroid))
	{
		$strMobileDeviceOs = 'G';
	}
	*/
	
		//$MobileMgr->setM_ID($strM_ID);
		//$apiKey= $MobileMgr->getMobileKey($db);
		
		//print_r("MOBILE_DEVICE_OS ::".$apiKey[MOBILE_DEVICE_OS]);
		
		//exit;
		
		//if($apiKey[MOBILE_DEVICE_OS] == 'G')
		//{
	
	//if(!$appKey[0][MOBILE_DEVICE_KEY]){
		$MobileMgr->setM_ID($strM_ID);
		$apiKey= $MobileMgr->getMobileKeyDelete2($db);	
		
		
	//	$MobileMgr->setMOBILE_DEVICE_OS($strMobileDeviceOs);//디바이스OS
	//	$MobileMgr->setMOBILE_DEVICE_KEY($strDeviceKey);//디바이스 고유키
	//	$apiKey= $MobileMgr->getMobileKeyUpdate2($db);	
	//}eles{
		$MobileMgr->setMOBILE_DEVICE_OS($strMobileDeviceOs);//디바이스OS
		$MobileMgr->setMOBILE_DEVICE_KEY($strDeviceKey);//디바이스 고유키
		$MobileMgr->setM_ID($strM_ID);//
		$apiKey= $MobileMgr->getMobileKeyInsert($db);	
	//}
	
	

	//$MobileMgr->setM_ID($strM_ID);						
	//$MobileMgr->getMobileKeyUpdate($db);

	setcookie('device_id', $strDeviceKey, time() + (86400 * 15), "/"); // 86400 = 1 day


	//print_r($apiKey);
	//ECHO "<BR><bR><bR>";
	//$cc= $MobileMgr->getMobileKeyInsert($db);

	//$AndPush = new GCMPushMessage($apiKey[MOBILE_KEY]);
	//$AndPush->setDevices($apiKey[MOBILE_DEVICES]);
	//$response = $AndPush->send($message);


?>
