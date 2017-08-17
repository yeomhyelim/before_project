<form name="form" name="form" id="form" >
<input type="hidden" name="menuType" value="reservation">
<input type="hidden" name="mode" value="">
<input type="hidden" name="act" value="">

<div id="contentArea">
	<div class="contentTop">
		<h2>환경설정</h2>
		<div class="clr"></div>
	</div>
	<br>
	<div class="tabRevNav">
		<a href="./?menuType=reservation&mode=basicSet" class="selected">기본환경설정</a>
		<a href="./?menuType=reservation&mode=roomSetEtc">부대시설설정</a>
		<a href="./?menuType=reservation&mode=roomSetFix">객실시설설정</a>
		<a href="./?menuType=reservation&mode=roomSetPolicy">예약규정설정</a>
	</div>
	<!-- ******** 컨텐츠 ********* -->

	<div class="tableFo,rWrap">
		<h3>예약환경설정</h3>
		<table class="tableForm">
			<tr>
				<th>예약중지 설정</th>
				<td><?php $row=$reservationMgr->getFromServerInfo($db,"S_REV_SERVICE");if($row['VAL']=="1"){?>
					<input type="radio" name="serviceon" value="1" checked="checked"> 예약중
					<input type="radio" name="serviceon" value="2""> 예약중지
					<?}else{?>
					<input type="radio" name="serviceon" value="1"> 예약중
					<input type="radio" name="serviceon" value="2" checked="checked"> 예약중지
					<?}?>
				</td>
			</tr>
<!--			<tr>
				<th>예약자동취소</th>
				<td><input type="checkbox" name="checkbox1" checked="<?php $row=$reservationMgr->getFromServerInfo($db,"S_REV_CANCLE");echo $row['VAL'];if($row['VAL']=="on")echo "checked";?>">사용함 - 예약대기 상태에서 <input type="text" name="hour" class="_w30" value="<?php $row=$reservationMgr->getFromServerInfo($db,"S_REV_HOUR");echo $row['VAL'];?>">시간이 지나면 자동으로 예약 취소</td>
			</tr>-->
			<tr>
				<th>계약금 결제</th>
				<td><input type="checkbox" name="checkbox2" checked="<?php $row=$reservationMgr->getFromServerInfo($db,"S_REV_PAY");echo $row['VAL'];if($row['VAL']=="on")echo "checked";?>"> 사용함 - 결제금액의 <input type="text" name="percent" class="_w30" value="<?php $row=$reservationMgr->getFromServerInfo($db,"S_REV_PERCENT");echo $row['VAL'];?>">% 를 계약금으로 결제</td>
			</tr>
			<tr>
				<th>입퇴실 시간</th>
				<td>
					예약당일
					<select name="checkin"><?php $row=$reservationMgr->getFromServerInfo($db,"S_REV_CHECKIN");if($row['VAL']=="2"){?>
						<option value="2" selected>오후</option>
						<option value="1">오전</option>
						<?}else{?>
						<option value="2">오후</option>
						<option value="1" selected>오전</option>
						<?}?>
					</select>
					<input type="text" name="intime" class="_w30" value="<?php $row=$reservationMgr->getFromServerInfo($db,"S_REV_INTIME");echo $row['VAL'];?>"> 시 부터 ~
					<select name="checkout"><?php $row=$reservationMgr->getFromServerInfo($db,"S_REV_CHECKOUT");if($row['VAL']=="2"){?>
						<option value="2" selected>오후</option>
						<option value="1">오전</option>
						<?}else{?>
						<option value="2">오후</option>
						<option value="1" selected>오전</option>
						<?}?>
					</select>
					<input type="text" name="outtime" class="_w30" value="<?php $row=$reservationMgr->getFromServerInfo($db,"S_REV_OUTTIME");echo $row['VAL'];?>"> 시 까지
				</td>
			</tr>
		</table>

		<h3 class="mt30">예약기간설정</h3>
		<table class="tableForm">
			<tr>
				<th>예약가능 개월수</th>
				<td>오늘부터 <input type="text" name="reser_days" width="5" value="<?php $row=$reservationMgr->getFromServerInfo($db,"S_REV_DAYS");echo $row['VAL'];?>">개월 이내의 날짜만 예약가능</td>
			</tr>
			<tr>
				<th>예약가능 일수</th>
				<td>최대 <select name="check_days"><?php $row=$reservationMgr->getFromServerInfo($db,"S_REV_CHECKDAYS");$days = $row['VAL'];?>
							<option value="1" <?if($days=="1"){echo "selected";}?>>1일</option>
							<option value="2" <?if($days=="2"){echo "selected";}?>>2일</option>
							<option value="3" <?if($days=="3"){echo "selected";}?>>3일</option>
							<option value="4" <?if($days=="4"){echo "selected";}?>>4일</option>
							<option value="5" <?if($days=="5"){echo "selected";}?>>5일</option>
							<option value="6" <?if($days=="6"){echo "selected";}?>>6일</option>
							<option value="7" <?if($days=="7"){echo "selected";}?>>7일</option>
							<option value="8" <?if($days=="8"){echo "selected";}?>>8일</option>
							<option value="9" <?if($days=="9"){echo "selected";}?>>9일</option>
							<option value="10" <?if($days=="10"){echo "selected";}?>>10일</option>
						</select>까지 예약가능 <font color="blue"> 예)4일인 경우 3박4일까지 예약가능</font></td>
			</tr>
			<tr>
				<th>주말적용 설정</th>
				<td><input type="checkbox" name="checkbox3" <?php $row=$reservationMgr->getFromServerInfo($db,"S_REV_FRIDAY");if($row['VAL']=="on")echo "checked";?>>금<input type="checkbox" name="checkbox4" <?php $row=$reservationMgr->getFromServerInfo($db,"S_REV_SATURDAY");if($row['VAL']=="on")echo "checked";?>>토<input type="checkbox" name="checkbox5" <?php $row=$reservationMgr->getFromServerInfo($db,"S_REV_SUNDAY");if($row['VAL']=="on")echo "checked";?>>일 <font color="blue">+1개 이상은 꼭 체크해주시기 바랍니다. </font></td>
			</tr>
			<tr style="display:none">
				<th>준성수기 설정</th>
				<td>
					<input type="radio" name="use" value="1"> 사용
					<input type="radio" name="use" value="2"> 미사용 <font color="blue"> +미사용 체크시 준성수기간 비수기요금으로 자동설정됩니다.</font>
				</td>
			</tr>
			<tr>
				<th>준성수기기간 </th>
				<td>
				<?while($rowTime=mysql_fetch_array($resultTime)){?>
					<ul>
						<li>
					<input type="text" name="searchRegStartDt[]" class="_w100" value="<?echo substr($rowTime['T_START_DT'],0,10);?>" readonly> ~ <input type="text" name="searchRegEndDt[]" class="_w100" value="<?echo substr($rowTime['T_END_DT'],0,10);?>" readonly><input type="text" name="hiddenNo[]" value="<?echo $rowTime['T_NO'];?>" style="display:none"><a href="javascript:goTimeDelete(<?echo $rowTime['T_NO'];?>);"  class="btn_sml"><span>-삭제</span></a>
						</li>
					</ul>
				<?}?>
					<ul>
						<li>
					<input type="text" name="searchRegStartDt[]" class="_w100" readonly> ~ <input type="text" name="searchRegEndDt[]" class="_w100" readonly>
					<a href="javascript:void(0);" onclick="goAddFormEvent(this);" class="btn_blue_sml"><span>+추가</span></a>
						</li>
					</ul>
				</td>
			</tr>

			<tr>
				<th>성수기기간 </th>
				<td>
				<?while($rowTime2=mysql_fetch_array($resultTime2)){?>
					<ul>
						<li>
					<input type="text" name="searchRegStart_Dt[]" class="_w100" value="<?echo substr($rowTime2['T_START_DT'],0,10);?>" readonly> ~ <input type="text" name="searchRegEnd_Dt[]" class="_w100" value="<?echo substr($rowTime2['T_END_DT'],0,10);?>" readonly><input type="text" name="hidden_No[]" value="<?echo $rowTime2['T_NO'];?>" style="display:none"><a href="javascript:goTimeDelete(<?echo $rowTime2['T_NO'];?>);"  class="btn_sml"><span>-삭제</span></a>
						</li>
					</ul>
				<?}?>
					<ul>
						<li>
					<input type="text" name="searchRegStart_Dt[]" class="_w100" readonly> ~ <input type="text" name="searchRegEnd_Dt[]" class="_w100" readonly>
					<a href="javascript:void(0);" onclick="goAddFormEvent(this);" class="btn_blue_sml"><span>+추가</span></a>
						</li>
					</ul>
				</td>
			</tr>
		</table>
	</div>


	    <div class="buttonBoxWrap">
			<a class="btn_new_blue" href="javascript:goAct()"><strong class="ico_write"><?=$LNG_TRANS_CHAR["CW00002"] //등록?></strong></a>
		</div>
</div>
</form>
