
<!--h2>
	<span><?php echo $strB_NAME;?></span>
</h2-->

<?php
$EUMSHOP_APP_INFO = "";
$EUMSHOP_APP_INFO['name'] = "커뮤니티_비밀번호";
$EUMSHOP_APP_INFO['mode'] = "communityPassword";
$EUMSHOP_APP_INFO['skin'] = "dataBasicSkin";
$EUMSHOP_APP_INFO['bCode'] = $strBCode;
$EUMSHOP_APP_INFO['ubNo'] = $intUbNo;
$EUMSHOP_APP_INFO['next'] = $_GET['next'];
$EUMSHOP_APP_INFO['boardInfo'] = $aryBoardInfo;
include MALL_HOME . "/web/app/index.php";
?>
