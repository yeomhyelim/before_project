<?php
	require_once MALL_CONF_LIB."ReservationMgr.php";

	$reservationMgr = new ReservationMgr();


	$year			= $_GET['y'];
	$month			= $_GET['m'];
	$day			= $_GET['d'];
	$intRoomNo		= $_GET['r_no'];
	$strTimeStat	= $_GET['s'];
	$strDayWeek		= $_GET['e'];
	$strChkDt		= $_GET['dt'];
	$strOption		= $_GET['o'];

	$result			= $reservationMgr->getRoomBasic($db);
	$resultRoomEtc	= $reservationMgr->getRoomSetEtcAll($db);
	$resultGetTime  = $reservationMgr->getTimeData2($db);
	$resultGetTime2  = $reservationMgr->getTimeData1($db);


	$days			= date("t",mktime(0,0,0,$month,1,$year));
	$dayofweek		= date("w",mktime(0,0,0,$month,1,$year));

	$num			= 0;

	if($month==12 && $day==31){$year1 = $year+1;}else{$year1 = $year;}
	if($day!=$days){$month1= $month;}else if($month!=12){$month1 = $month+1;}else{$month1 = 1;}
	if($day!=$days){$day1 = $day+1;}else{$day1 = 1;}

	$strEndDt1 = $year1 ."-". $month1 ."-". $day1;

	if($month==12){
		if($day+2>$days){
			$year2=$year + 1;
		}
	}else{$year2=$year;}
	if($day+2 < $days){$month2 = $month;}else if($month!=12){$month2 = $month+1;}else{$month2 = 1;}
	if($day+2<$days){$day2 = $day + 2;}else{$day2=$day+2-$days;}

	$strEndDt2 = $year2 ."-". $month2 ."-". $day2;

	if($month==12){
		if($day+3>$days){
			$year3=$year + 1;
		}
	}else{$year3=$year;}
	if($day+3 < $days){$month3 = $month;}else if($month!=12){$month3 = $month+1;}else{$month3 = 1;}
	if($day+3<$days){$day3 = $day + 3;}else{$day3=$day+3-$days;}

	$strEndDt3 = $year3 ."-". $month3 ."-". $day3;
?>