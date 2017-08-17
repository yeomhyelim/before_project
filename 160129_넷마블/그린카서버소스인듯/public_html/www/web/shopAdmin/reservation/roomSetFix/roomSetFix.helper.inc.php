<?
	require_once MALL_CONF_LIB."ReservationMgr.php";

	$reservationMgr				 = new ReservationMgr();

	$intNumber					 = $reservationMgr->getCmCodeNumber($db);
	$result						 = $reservationMgr->getRoomAdd($db);
	$result2					 = $reservationMgr->getRoomAdd($db);
?>
