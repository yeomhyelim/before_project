<?
	require_once MALL_CONF_LIB."ReservationMgr.php";

	$reservationMgr = new ReservationMgr();

	$resultAdd  = $reservationMgr->getRoomSetEtcAll($db);
	$resultComm = $reservationMgr->getRoomSetFixView3($db);
	$resultRoom = $reservationMgr->getRoomBasicAll($db);
	$intRoomTt  = $reservationMgr->getRoomCount($db);

	$intNumber = $_GET['no'];

	$resultRoomModify	= $reservationMgr->getRoomBasicSelect($db,$intNumber);
	$resultRBasic		= $reservationMgr->getRoomBasicSetSelect($db,$intNumber);

	$strBasic			= explode(',',$resultRBasic['R_SET']);
	$intBasic			= count($strBasic);
?>
