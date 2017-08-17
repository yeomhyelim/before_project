<?
	require_once "./config.inc.php";	
	require_once "./conf/shop.inc.php";
	require_once "./conf/site_skin.conf.inc.php";

	require_once MALL_CONF_MYSQL;
	require_once MALL_CONF_FILE;
	require_once MALL_COMM_LIB;
	require_once MALL_CONF_TBL;
	require_once MALL_CONF_SESS;
	require_once MALL_CONF_COOKIE;

	$db->connect();

	/**
	 * 웹/모바일 설정
	 */
	$strHttpHost = $_SERVER['HTTP_HOST'];
	$aryHttpHost = explode(".", $strHttpHost);
	$strHostType = "web";
	
	if($aryHttpHost[0] == "m") { $strHostType = "mobile"; }
	//$mobilechk = '/(iPod|iPhone|Android|BlackBerry|SymbianOS|SCH-M\d+|Opera Mini|Windows CE|Nokia|SonyEricsson|webOS|PalmOS)/i';
	$mobilechk = '/(iPod|iPhone|BlackBerry|SymbianOS|SCH-M\d+|Opera Mini|Windows CE|Nokia|SonyEricsson|webOS|PalmOS|CFNetwork|Dalvik|Darwin)/i';
	if(preg_match($mobilechk, $_SERVER['HTTP_USER_AGENT'])) { $strHostType = "mobile"; }
	if($_SESSION['HOST_TYPE']) { $strHostType = $_SESSION['HOST_TYPE']; }
//	$_SESSION['HOST_TYPE'] = "";

	if($strHostType == "mobile"):
		include_once "mobile/mobileApiIndex.php";
		$db->disConnect();
		exit;
	endif;
exit;
	/* 국가별 IP 대역 */
	$aryRemoteAddr		= explode(".",$S_REMOTE_ADDR);
	$intRemoteAddrWide	= ($aryRemoteAddr[0]*16777216) + ($aryRemoteAddr[1]*65536) + ($aryRemoteAddr[2]*256) + $aryRemoteAddr[3];
	$strCountryCode		= callCountryIpCode($intRemoteAddrWide,$S_USE_LNG,$S_ST_LNG);
	/* 국가별 IP 대역 */
	$db->disConnect();

	if (!$strCountryCode) $strCountryCode = "kr";
	$strIncludePath = "./".$strCountryCode."/";		
	
	if ($S_DESIGN_INTRO == "I") {
		if ($S_DESIGN_AUTO == "Y"){
			$strIncludePath = "./".$strCountryCode."/?menuType=intro&mode=intro";		
		}
	}
	
?>
<script type="text/javascript">
<!--
	location.href = "<?=$strIncludePath?>";
//-->
</script>