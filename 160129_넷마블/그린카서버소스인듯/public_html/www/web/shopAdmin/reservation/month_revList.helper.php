<?
		require_once MALL_CONF_LIB."ReservationMgr.php";

		$reservationMgr = new ReservationMgr();

		//주말적용여부를 판단하기 위한 검색
		$resultFri		= $reservationMgr->getBasicSetting($db,"S_REV_FRIDAY");
		$resultSat		= $reservationMgr->getBasicSetting($db,"S_REV_SATURDAY");
		$resultSun		= $reservationMgr->getBasicSetting($db,"S_REV_SUNDAY");

		//객실 리스트 가져오기
		$arrRoom			= $reservationMgr->getRoomBasic2($db);

		//성수기 , 준성수기 적용여부를 판단하기 위한 검색
		$resultTime1	= $reservationMgr->getTimeData1($db);
		$resultTime2	= $reservationMgr->getTimeData2($db);

		while($rowTime1=mysql_fetch_array($resultTime1)){
				$intCountTime1 = 0;
				$intCountTime1 ++;
				$dtTime1[$intCountTime1]			= $rowTime1['T_START_DT'];
				$dtTime2[$intCountTime1]			= $rowTime1['T_END_DT'];

				$dtYear1[$intCountTime1]			= intval(substr($dtTime1[$intCountTime1],0,4));
				$dtYear2[$intCountTime1]			= substr($dtTime2[$intCountTime1],0,4)*1;
				$dtMonth1[$intCountTime1]			= substr($dtTime1[$intCountTime1],5,2)*1;
				$dtMonth2[$intCountTime1]			= substr($dtTime2[$intCountTime1],5,2)*1;
				$dtDay1[$intCountTime1]				= substr($dtTime1[$intCountTime1],8,2)*1;
				$dtDay2[$intCountTime1]				= substr($dtTime2[$intCountTime1],8,2)*1;



		}

		while($rowTime2=mysql_fetch_array($resultTime2)){
				$intCountTime2 = 0;
				$intCountTime2 ++;
				$dtTime3[$intCountTime2]			= $rowTime2['T_START_DT'];
				$dtTime4[$intCountTime2]			= $rowTime2['T_END_DT'];

				$dtYear3[$intCountTime2]			= substr($dtTime3[$intCountTime2],0,4)*1;
				$dtYear4[$intCountTime2]			= substr($dtTime4[$intCountTime2],0,4)*1;
				$dtMonth3[$intCountTime2]			= substr($dtTime3[$intCountTime2],5,2)*1;
				$dtMonth4[$intCountTime2]			= substr($dtTime4[$intCountTime2],5,2)*1;
				$dtDay3[$intCountTime2]				= substr($dtTime3[$intCountTime2],8,2)*1;
				$dtDay4[$intCountTime2]				= substr($dtTime4[$intCountTime2],8,2)*1;
		}


				$strTime = "비수기";
				$strDayofWeek = "평일";
	//달력을 만들기 위한 날자 계산

		$year			=	 isset($_GET["y"])?$_GET["y"]:date("Y");
		$month			=	 isset($_GET["m"])?$_GET["m"]:date("m");
		if ($month>12){//12월에서 넘어설때

		$month			=1;
		$year++;

		}
		if ($month<1){//1월보다 작을때

		$month			=12;
		$year--;

		}

		$currentDate	= $year.'년'.$month.'월';
		$days			= date("t",mktime(0,0,0,$month,1,$year));
		$dayofweek		= date("w",mktime(0,0,0,$month,1,$year));

		$num			= 0;
?>