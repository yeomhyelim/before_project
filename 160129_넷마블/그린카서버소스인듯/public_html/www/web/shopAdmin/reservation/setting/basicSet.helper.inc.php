<?
	require_once MALL_CONF_LIB."ReservationMgr.php";

	$reservationMgr = new ReservationMgr();

	$resultTime  = $reservationMgr->getTimdDt($db);
	$resultTime2 = $reservationMgr->getTimdDt2($db);

?>
