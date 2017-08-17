<?php
	require_once MALL_CONF_LIB."ReservationMgr.php";

	$reservationMgr = new ReservationMgr();

	$strDate		= $_GET['d'];
	$intStay		= $_GET['stay'];
	$strAlist		= $_GET['alist'];
	$strBlist		= $_GET['blist'];
	$strClist		= $_GET['clist'];
	$strDlist		= $_GET['dlist'];

	$strAlist		= substr($strAlist,0,strlen($strAlist)-1);
	$strBlist		= substr($strBlist,0,strlen($strBlist)-1);
	$strClist		= substr($strClist,0,strlen($strClist)-1);
	$strDlist		= substr($strDlist,0,strlen($strDlist)-1);

	$addNo			= explode(",",$strAlist);
	$addUnit		= explode(",",$strBlist);
	$roomNo			= explode(",",$strClist);
	$roomUnit		= explode(",",$strDlist);
?>