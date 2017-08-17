<?include "month_revList.helper.php";?>
<script>
	function goMessege(){
	alert("예약정보가 없습니다.");
}
</script>
<div id="contentArea">
	<div class="contentTop">
		<h2>월간예약현황</h2>
		<div class="clr"></div>
	</div>
	<br>



	<!-- ******** 컨텐츠 ********* -->
	<div class="searchTableWrap">

	</div>




	<div class="tableListWrap mt20">
		<div class="infoTopTxt">
			* 날짜를 클릭 하시면 해당 일의 모든 예약 정보를 확인하실 수 있습니다.<br>
			* 완료 또는 대기 중인 객실을 클릭하시면 각각의 예약 정보를 확인하실 수 있습니다.

		</div>
		<div class="calendarTop">
			<div class="dayList">
				<a href="" class="btnCPrev">이전</a>
					<strong><?echo $currentDate;?></strong>
				<a href="" class="btnCNext">다음</a>
			</div>
			<div class="revIcoList">
				<ul>
						<li><span class="ico_red">가능</span> 예약가능</li>
						<li><span class="ico_org">대기</span> 예약대기</li>
						<li><span class="ico_green">완료</span> 예약완료</li>
						<li><span class="ico_gray">문의</span> 전화문의</li>
				<ul>
			</div>
			<div class="clr"></div>
		</div>
		<table class="tableList">
			<tr>
				<th class="sun">일</th>
				<th>월</th>
				<th>화</th>
				<th>수</th>
				<th>목</th>
				<th>금</th>
				<th class="sat">토</th>
			</tr>
			<tr class="deliveryWrap">
				<!--1일이 일요일이 아닌경우 앞 부분 채우기-->
				<?if($dayofweek%7!=0){?>
					<?for($i=0;$i<$dayofweek;$i++){?>
					<td></td>
					<?$num++;}?>
				<?}?>
				<!--1일부터 마지막 날자까지 표시-->
								<?for($i=1;$i<=$days;$i++){?>
									<?if($month<10){$dtMakeDate=$year."0".$month;$dtMakeDate2=$year."-0".$month;}else{$dtMakeDate = $year.$month;$dtMakeDate2 = $year."-".$month;}?>
									<?if($i<10){$dtMakeDate .= "0".$i;$dtMakeDate2 .= "-0".$i;}else{$dtMakeDate .= $i;$dtMakeDate2 .= "-".$i;}?>
									<?$strDayofWeek = "평일";?>
									<!--준성수기 판단-->
									<?if($intCountTime1){?>
										<?for($k=1;$k<=$intCountTime1;$k++){?>
											<?if($dtYear1[$k]==$year){if($dtMonth1[$k]==$month){if($dtDay1[$k]==$i){$strTime = "준성수기";}}}?>
											<?if($dtYear2[$k]==$year){if($dtMonth2[$k]==$month){if($dtDay2[$k]==$i-1){$strTime = "비수기";}}}?>
										<?}?>
										<?for($l=1;$l<=$intCountTime2;$l++){?>
											<?if($dtYear3[$l]==$year){if($dtMonth3[$l]==$month){if($dtDay3[$l]==$i){$strTime = "성수기";}}}?>
											<?if($dtYear4[$l]==$year){if($dtMonth4[$l]==$month){if($dtDay4[$l]==$i-1){$strTime = "비수기";}}}?>
										<?}?>
									<?}?>
									<!--주말판단-->
									<?if($resultFri['VAL']=="on" && $num%7==5){$strDayofWeek = "주말";}?>
									<?if($resultSat['VAL']=="on" && $num%7==6){$strDayofWeek = "주말";}?>
									<?if($resultSun['VAL']=="on" && $num%7==0){$strDayofWeek = "주말";}?>
									<?if($now<=$dtMakeDate){?>

									<?if($num%7==0){?>
										</tr><tr>
									<?}?>

								<td>
									<span class="<?if($num%7==0){echo 'dateNo sun';}else if($num%7==6){echo 'dateNo sat';}else{echo 'dateNo';}?>"><?echo $i;?></span>
									<span><?echo $strTime;?>/<?echo $strDayofWeek;?></span>
									<ul>
									<?foreach($arrRoom as $codeKey => $codeData){?>
									<?$resultStatus = $reservationMgr->getRoomStatus($db,$dtMakeDate2);?>
									<?$strIcon = "ico_red";$strPos = "가능"?>
									<?while($rowStatus = mysql_fetch_array($resultStatus)){?>
									<?
										if($rowStatus['RS_R_NO']==$codeData['R_NO']){$strIcon = "ico_green";$strPos = "완료";}
									?>
									<?}?>
										<?	if($strPos=="완료"){?>
											<li><a href="./?menuType=reservation&mode=day_revList2&searchField=all&searchRegStartDt=<?echo $dtMakeDate2?>&searchRegEndDt=<?echo $dtMakeDate2?>&page=1"><span class="<?echo $strIcon;?>"><?echo $strPos;?></span><?echo $codeData['R_NAME'];?>(<?echo $codeData['R_TYPE'];?>)</a></li>
										<?}else{?>
											<li><a href="javascript:goMessege();"><span class="<?echo $strIcon;?>"><?echo $strPos;?></span><?echo $codeData['R_NAME'];?>(<?echo $codeData['R_TYPE'];?>)</a></li>
										<?}?>
									<?}?>
									</ul>
								</td><?$num++;?>
								<?}else{?>
								<td>
									<span class="<?if($num%7==0){echo 'dateNo sun';}else if($num%7==6){echo 'dateNo sat';}else{echo 'dateNo';}?>"><?echo $i;?></span>
								</td>
								<?$num++;?>
								<?if($num%7==0){?>
										</tr><tr>
									<?}?>
								<?}?>
								<?}?>
			</tr>
		</table>
	</div>
</div>
