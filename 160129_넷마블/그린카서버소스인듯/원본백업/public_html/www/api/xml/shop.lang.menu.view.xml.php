<?
	require_once	"../../webmall.inc.php";	

	//여기 INCLUDE 할 클래스 파일을 추가하세요
	require_once WEB_CONF_LIB."ShopLangMenu.php";

	//여기 클래스를 선언하세요.
	$menuMgr = new menuMgr();

	require_once WEB_CONF_MYSQL;
	require_once WEB_CONF_FILE;
	require_once WEB_COMM_LIB;
	require_once WEB_CONF_TBL;
	require_once WEB_CONF_SESS;

	$db->connect();

	$no	= $_POST["no"]	? $_POST["no"]	: $_REQUEST["no"];
	
	echo '<?xml version="1.0" encoding="utf-8"?>';
	echo '<data>';

	$menuMgr->setMN_NO($no);
	$row		= $menuMgr->getView($db);	
	
	echo "<ITEM>";
	echo "	<MN_NO>".$row[MN_NO]."</MN_NO>";
	echo "	<MN_CODE>".$row[MN_CODE]."</MN_CODE>";
	echo "	<MN_NAME_KR><![CDATA[".$row[MN_NAME_KR]."]]></MN_NAME_KR>";
	echo "	<MN_NAME_US><![CDATA[".$row[MN_NAME_US]."]]></MN_NAME_US>";
	echo "	<MN_NAME_CN><![CDATA[".$row[MN_NAME_CN]."]]></MN_NAME_CN>";
	echo "	<MN_NAME_JP><![CDATA[".$row[MN_NAME_JP]."]]></MN_NAME_JP>";
	echo "	<MN_NAME_ID><![CDATA[".$row[MN_NAME_ID]."]]></MN_NAME_ID>";
	echo "	<MN_NAME_FR><![CDATA[".$row[MN_NAME_FR]."]]></MN_NAME_FR>";
	echo "	<MN_LEVEL>".$row[MN_LEVEL]."</MN_LEVEL>";
	echo "	<MN_HIGH_01>".$row[MN_HIGH_01]."</MN_HIGH_01>";
	echo "	<MN_HIGH_02>".$row[MN_HIGH_02]."</MN_HIGH_02>";
	echo "	<MN_URL><![CDATA[".$row[MN_URL]."]]></MN_URL>";
	echo "	<MN_USE>".$row[MN_USE]."</MN_USE>";
	echo "	<MN_ORDER>".$row[MN_ORDER]."</MN_ORDER>";
	echo "	<MN_AUTH_L>".$row[MN_AUTH_L]."</MN_AUTH_L>";
	echo "	<MN_AUTH_W>".$row[MN_AUTH_W]."</MN_AUTH_W>";
	echo "	<MN_AUTH_M>".$row[MN_AUTH_M]."</MN_AUTH_M>";
	echo "	<MN_AUTH_D>".$row[MN_AUTH_D]."</MN_AUTH_D>";
	echo "	<MN_AUTH_E>".$row[MN_AUTH_E]."</MN_AUTH_E>";
	echo "	<MN_AUTH_C>".$row[MN_AUTH_C]."</MN_AUTH_C>";
	echo "	<MN_AUTH_S>".$row[MN_AUTH_S]."</MN_AUTH_S>";
	echo "	<MN_AUTH_U>".$row[MN_AUTH_U]."</MN_AUTH_U>";
	echo "	<MN_AUTH_P>".$row[MN_AUTH_P]."</MN_AUTH_P>";
	echo "	<MN_AUTH_E1>".$row[MN_AUTH_E1]."</MN_AUTH_E1>";
	echo "	<MN_AUTH_E2>".$row[MN_AUTH_E2]."</MN_AUTH_E2>";
	echo "	<MN_AUTH_E3>".$row[MN_AUTH_E3]."</MN_AUTH_E3>";
	echo "	<MN_AUTH_E4>".$row[MN_AUTH_E4]."</MN_AUTH_E4>";
	echo "	<MN_AUTH_E5>".$row[MN_AUTH_E5]."</MN_AUTH_E5>";				
	echo "</ITEM>";

	$db->disConnect();

	echo '</data>';
	exit;

?>