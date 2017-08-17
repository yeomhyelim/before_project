<?include "reservation.helper2.inc.php";?>
<?include "reservation.script.inc.php";?>
<form name="form" name="form" id="form" >
<input type="hidden" name="menuType" value="reservation">
<input type="hidden" name="mode" value="">
<input type="hidden" name="act" value="">
<div class="subLeftMenuWrap">
				<h3><img src="/upload/images/tit_sub02.gif" alt="알토란체험"></h3>
				<div class="subLeftMenu">
					<ul>
						<li><a href="./?menuType=community&amp;b_code=EXPERINFO">체험안내</a></li>
						<li><a href="./?menuType=community&amp;b_code=REVIEW">체험후기</a></li>
                                                <li><a href="./?menuType=reservation">예약안내</a></li>
                                                <li><a href="./?menuType=reservation&mode=start" class="on">실시간예약하기</a></li>
                                                <li><a href="./?menuType=reservation&mode=inquiry">예약조회</a></li>
                                                <li><a href="./?menuType=reservation&mode=rule">환불및유의사항</a></li>
					</ul>
				</div><!--// subLeftMenu -->
			</div><!--// subLeftMenuWrap -->

			<div class="subContent">
				<div class="locationWrap">
					<h3>실시간예약하기</h3>
					<div class="location">
						<ul>
							<li class="icon_home"><img src="/upload/images/icon_home.gif" alt="HOME"></li>
							<li>알토란체험</li>
							<li class="location_end">실시간예약하기</li>
						</ul>
					</div>
					<div class="clr"></div>
				</div><!--// locationWrap -->

				<div class="content">
					<div class="calendarWrap">
					<?for($i=0;$i<$strStayTime;$i++){?>
					<?if($dayofweek[$i]==6 || $dayofweek[$i]==0){$strWeekend = "주말";}else{$strWeekend = "평일";}?>
					<?$strSta = "비수기"?>
					<?while($rowTime = mysql_fetch_array($resultTime)){?>
						<?if($rowTime['T_START_DT']<$strEndDt[$i] && $strEndDt[$i]<$rowTime['T_END_DT']){$strSta = "준성수기";}?>
					<?}?>
					<?while($rowTime2 = mysql_fetch_array($resultTime2)){?>
						<?if($rowTime2['T_START_DT']<$strEndDt[$i] && $strEndDt[$i]<$rowTime2['T_END_DT']){$strSta = "준성수기";}?>
					<?}?>
					*객실,예약정보 확인(<?echo $i+1;?>)
						<table class="calendarTable reservationTable">
							<tr class="timeBox">
								<th width="120px">객실명</th>
								<td><font color="red"><?echo $result['R_NAME'];?></font>(<?echo $result['R_TYPE'];?>/<?echo $result['R_AREA'];?>평:<?echo $result['R_AREA']*3.3;?>㎡)</td>
							</tr>
							<tr class="timeBox">
								<th>
									이용기간
								</th>
								<td>
									<?echo $strEndDt[$i];?> 오후 3시 부터 ~ <?echo $strEndDt[$i+1];?> 오전 12시 까지 <font color="gray">=><?echo $strStayTime;?>박<?echo $strStayTime+1;?>일</font>
								</td>
							</tr>
							<tr class="timeBox">
								<th>
									요금적용
								</th>
								<td>
									<?if($strSta=="성수기" && $strWeekend=="주말"){?>
									<?$roomPay = $result['R_S_WPRICE'];$priceRoomTotal +=$result['R_S_WPRICE'];?>
									<?}?>
									<?if($strSta=="성수기" && $strWeekend=="평일"){?>
									<?$roomPay = $result['R_S_MPRICE'];$priceRoomTotal +=$result['R_S_MPRICE'];?>
									<?}?>
									<?if($strSta=="준성수기" && $strWeekend=="주말"){?>
									<?$roomPay = $result['R_Z_WPRICE'];$priceRoomTotal +=$result['R_Z_WPRICE'];?>
									<?}?>
									<?if($strSta=="준성수기" && $strWeekend=="평일"){?>
									<?$roomPay = $result['R_Z_MPRICE'];$priceRoomTotal +=$result['R_Z_MPRICE'];?>
									<?}?>
									<?if($strSta=="비수기" && $strWeekend=="주말"){?>
									<?$roomPay = $result['R_B_WPRICE'];$priceRoomTotal +=$result['R_B_WPRICE'];?>
									<?}?>
									<?if($strSta=="비수기" && $strWeekend=="평일"){?>
									<?$roomPay = $result['R_B_MPRICE'];$priceRoomTotal +=$result['R_B_MPRICE'];?>
									<?}?>
									<?echo number_format($roomPay)?>원 <font color="gray">=><?echo $strSta;?>,<?echo $strWeekend;?> 이용요금 적용</font>
								</td>
							</tr>
							<tr class="timeBox">
								<th>
									인원수
								</th>
								<td>
									<?echo $intPeople;?>명 <font color="gray">=>기준인원:<?echo $result['R_ST_PER'];?>명</font>
								</td>
							</tr>
							<tr class="timeBox">
								<th>
									객실요금 합계
								</th>
								<td>
									<font color="red"><?echo number_format($roomPay);?>원</font>
								</td>
							</tr>
						</table>
						<br>
						<?}?>
						<br>
						*기타요금 및 이용요금 합게
						<table class="calendarTable reservationTable">

							<?for($i=0;$i<count($list);$i++){?>
							<?$param = "";?>
							<?$param['AM_NO'] = $list[$i];?>
							<?$rowAddSet = $reservationMgr->getRoomSetEtcView($db,$param);?>
							<tr class="timeBox">
								<th width="120px">부대시설 이용요금</th>
								<td><?echo $rowAddSet['AM_DEV'];?> <?echo $list2[$i];?><?echo $rowAddSet['AM_UNIT'];?>(<?echo number_format($rowAddSet['AM_PRICE']);$priceAddTotal += $rowAddSet['AM_PRICE']*$list2[$i];?>원)</td>
							</tr>
							<?}?>
							<tr class="timeBox">
								<th>
									전체요금합계
								</th>
								<td>
									<?echo number_format($priceRoomTotal);?>원(객실요금) + <?echo number_format($priceAddTotal);?>원(부대시설) <font color="red">=<?echo number_format($priceRoomTotal + $priceAddTotal);?>원</font>
								</td>
							</tr>
						</table>
						<br>
						*예약자 정보
						<table class="calendarTable reservationTable">
							<tr class="timeBox">
								<th width="120px">예약자 성명</th>
								<td><input type="text" name="resrvName" value="랭크업"></td>
							</tr>
							<tr class="timeBox">
								<th>
									휴대폰번호
								</th>
								<td>
									<input type="text" name="resrvPhone" value="010-3333-3040">
								</td>
							</tr>
							<tr class="timeBox">
								<th>
									이메일
								</th>
								<td>
									<input type="text" name="resrvEmail" value="adsfk@daum.net">
								</td>
							</tr>
							<tr class="timeBox">
								<th>
									요청사항
								</th>
								<td>
									<textarea name="resrvRequest"></textarea>
								</td>
							</tr>
						</table>
						<br>
						*결제 정보
						<table class="calendarTable reservationTable">
							<tr class="timeBox">
								<th width="120px">결제요금선택</th>
								<td><input type="radio" name="radio_cash" value="완납">완납<input type="radio" name="radio_cash" value="계약금">계약금(40%)</td>
							</tr>
							<tr class="timeBox">
								<th>
									결제요금
								</th>
								<td>
									<font color="red"><?echo number_format($priceRoomTotal + $priceAddTotal);?>원</font>
									<input type="text" value="<?echo $strStayTime;?>" name="rsvStay" style="display:none">
									<input type="text" value="<?echo $year;?>" name="year" style="display:none">
									<input type="text" value="<?echo $month;?>" name="month" style="display:none">
									<input type="text" value="<?echo $day;?>" name="day" style="display:none">
									<input type="text" value="<?echo $priceAddTotal+$priceRoomTotal;?>" name="pay_cash" style="display:none">
									<input type="text" value="<?echo $intRoomNo;?>" name="roomNo" style="display:none">
									<input type="text" value="<?echo $priceRoomTotal;?>" name="roomPay" style="display:none">
									<input type="text" value="<?echo $priceAddTotal;?>" name="AddPay" style="display:none">
									<input type="text" value="<?echo $strAddlist;?>" name="AddList" style="display:none">
									<input type="text" value="<?echo $strAddlist2;?>" name="BddList" style="display:none">
								</td>
							</tr>
							<tr class="timeBox">
								<th>
									결제방법선택
								</th>
								<td>
									<input type="radio" name="bankbook">무통장입금
								</td>
							</tr>
						</table>
						<div class="buttonWrap">
							<a href="javascript:goAct2();">예약하기</a><a href="javascript:history.back(-1);"><button>취소</button></a>
						</div>
					</div>
				</div><!--// content -->

			</div><!--// subContent -->

			<div class="clr"></div>