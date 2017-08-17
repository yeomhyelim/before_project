<?
	require_once MALL_CONF_LIB."MemberMgr.php";	
	require_once MALL_CONF_LIB."ProductMgr.php";	
//	require_once MALL_CONF_LIB."SmsMgr.php";

	require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/conf/member.inc.php";
	require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/conf/site_skin_member.conf.inc.php";
	
	$memberMgr	= new MemberMgr();
	$productMgr = new ProductMgr();
//	$smsMgr		= new SmsMgr();

	$strM_ID			= $_POST["id"]				? $_POST["id"]				: $_REQUEST["id"];
	
	$aryCartNo			= $_POST["cartNo"]			? $_POST["cartNo"]			: $_REQUEST["cartNo"];

	$strReturnMenu		= $_POST["returnMenu"]		? $_POST["returnMenu"]		: $_REQUEST["returnMenu"];
	$strReturnMode		= $_POST["returnMode"]		? $_POST["returnMode"]		: $_REQUEST["returnMode"];
	$strReturnParam		= $_POST["returnParam"]		? $_POST["returnParam"]		: $_REQUEST["returnParam"];

	/* 레이어 팝업에서 로그인일때 */
	$strLayerClickType	= $_POST["clickType"]		? $_POST["clickType"]		: $_REQUEST["clickType"];

	switch ($strMode)
	{

		case "login":

			if ($g_member_no)
			{
				goUrl("","./");
				exit;
			}

			$strInputCartHtml = "";
			if (is_array($aryCartNo)){
				for($i=0;$i<sizeof($aryCartNo);$i++){
					$strInputCartHtml .= "<input type=\"hidden\" name=\"cartNo[]\" value=\"".$aryCartNo[$i]."\">";
				}
			}

			$strAutoLoginId = $_COOKIE["COOKIE_AUTO_LOGIN"] ? $_COOKIE["COOKIE_AUTO_LOGIN"] : "";

		break;
	}
?>
<script type="text/javascript">
<!--
	var strIdChkFlag		= "N";
	var strNickNameChkFlag	= "N";
	$(document).ready(function(){
		

		
		<?if ($strMode == "login"){?>
		
		$('#login_pwd').alphanumeric({allow:"!,*&^%$#@~;`-+:?/<>{}[]\\=."});
		$("#login_pwd").css("ime-mode", "disabled"); 
		
		$("#login_id").focus();

		<?}?>
	});
	

//-->
</script>