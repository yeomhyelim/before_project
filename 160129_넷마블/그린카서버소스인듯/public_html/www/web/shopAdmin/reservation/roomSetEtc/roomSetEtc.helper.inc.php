<?
	require_once MALL_CONF_LIB."ReservationMgr.php";

	$reservationMgr = new ReservationMgr();

	$result = $reservationMgr->getRoomSetEtcAll($db);
	$result2 = $reservationMgr->getRoomSetEtcAll($db);

?>
