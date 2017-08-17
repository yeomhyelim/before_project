<?
	//require_once MALL_CONF_LIB."MobileMgr.php";
	//모바일 App관련 설정 하나로 묶음
	include	MALL_SHOP."/include/mobileApp.inc.php";

	$MobileMgr = new MobileMgr();
	

	/*##################################### Parameter 셋팅 #####################################*/
	$strDeviceKey	= $_POST["DeviceKey"]		? $_POST["DeviceKey"]		: $_REQUEST["DeviceKey"];
	$intPage		= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];

	if($intM_NO)
	{
		$MobileMgr->setM_NO($intM_NO);
	}
	//$MobileMgr->setM_NO(1);
	//$MobileMgr->setMOBILE_KEY($strApiKey);
	


	## 모바일 OS확인
	$strUserAgent = $_SERVER['HTTP_USER_AGENT'];
	$aryIos = array('iPod','iPhone');
	$aryAndroid = array('Android');

	if(in_array($strUserAgent,$aryIos))
	{
		$strMobileDeviceOs = 'A';
	}
	elseif(in_array($strUserAgent,$aryIos))
	{
		$strMobileDeviceOs = 'G';
	}

	$MobileMgr->setMOBILE_DEVICE_OS($strMobileDeviceOs);//디바이스OS
	$MobileMgr->setMOBILE_DEVICE_KEY($strDeviceKey);//디바이스 고유키
	$apiKey= $MobileMgr->getMobileKeyInsert($db);

	setcookie('device_id', $strDeviceKey, time() + (86400 * 15), "/"); // 86400 = 1 day


	//print_r($apiKey);
	//ECHO "<BR><bR><bR>";
	//$cc= $MobileMgr->getMobileKeyInsert($db);

	//$AndPush = new GCMPushMessage($apiKey[MOBILE_KEY]);
	//$AndPush->setDevices($apiKey[MOBILE_DEVICES]);
	//$response = $AndPush->send($message);


?>