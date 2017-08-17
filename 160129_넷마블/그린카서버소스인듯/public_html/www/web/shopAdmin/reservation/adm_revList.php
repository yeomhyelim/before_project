<?include "adm_revList.helper.php";?>
<?include "adm_revList.script.php";?>
<? include "./include/header.inc.php"?>
<form name="form" name="form" id="form" >
<input type="hidden" name="menuType" value="reservation">
<input type="hidden" name="mode" value="">
<input type="hidden" name="act" value="">
<div id="contentArea">
	<div class="contentTop">
		<h2>관리자예약관리</h2>
		<div class="clr"></div>
	</div>
	<br>



	<!-- ******** 컨텐츠 ********* -->
	<h3>객실이용일 및 기간선택</h3>
	<div class="searchTableWrap">
		<input type="text" name="StartDt" value="<?echo $strChkDt;?>" readonly>부터
		<select name="selectDay">
			<option value="1">1박 2일</option>
			<option value="2">2박 3일</option>
			<option value="3">3박 4일</option>
		</select>
		<a href="javascript:goConfirm();">예약확인</a><input type="text" name="hiddenOption" value="<?echo $strOption;?>" style="display:none"><input type="text" name="roomList" style="display:none"><input type="text" name="peoList" style="display:none">
	</div>




	<div class="tableListWrap mt20">
		<div class="calendarTop">
			<h3>객실선택</h3>
			<div class="revIcoList">
				<ul>
					<li><span class="ico_red">		가능</span> 예약가능</li>
					<li><span class="ico_org">		대기</span> 예약대기</li>
					<li><span class="ico_green">	완료</span> 예약완료</li>
					<li><span class="ico_gray">		문의</span> 전화문의</li>
				<ul>
			</div>
			<div class="clr"></div>
		</div>
		<table class="tableList">
			<colgroup>
				<col width=""/>
				<col/>
				<col/>
				<col/>
				<col/>
				<col/>
				<col/>
			</colgroup>
			<tr>
				<th>객실명</th>
				<th>객실정보</th>
				<th>수용인원</th>
				<th>인원</th>
				<th>비수기객실요금</th>
				<th>준성수기객실요금</th>
				<th>성수기객실요금</th>
			</tr>
			<?while($row = mysql_fetch_array($result)){$k++;?>
			<!--출력여부를 판단하여 방 정보를 노출-->
			<?if($row['R_PRINT']=="on"){?>
			<tr>
				<td>

							<?$strIcon = "ico_red";$strPos = "가능";?>
							<?if(!$strChkDt){$strIcon = "ico_gray";$strPos = "문의";}?>
							<?if($strChkDt){?>
								<?$resultStatus = $reservationMgr->getRoomStatus($db,$strChkDt);?>

								<?while($rowStatus = mysql_fetch_array($resultStatus)){?>
									<?
										if($rowStatus['RS_R_NO']==$row['R_NO']){$strIcon = "ico_green";$strPos = "완료";}
									?>
								<?}?>
							<?}?>
								<?if($strPos=="가능"){?>
									<input type="checkbox" name="checkRoomNo[]" value="<?echo $row['R_NO'];?>">
								<?}?>
								<?echo $row['R_NAME'];?>(<?echo $row['R_TYPE'];?>)
								<span class="<?echo $strIcon;?>"><?echo $strPos;?></span>
				</td>
				<td class="alignLeft">
					<ul class="revInfoList">
						<li><span>객실면적</span>: <?echo $row['R_AREA'];?>평(<?echo $row['R_AREA']*3.3;?>㎡)</li>
						<li><span>객실유형</span>: <?echo $row['R_TYPE'];?></li>
					</ul>
				</td>
				<td class="alignLeft">
					<ul class="revInfoList">
						<li><span>수용인원</span>: <?echo $row['R_ST_PER'];?>명</li>
						<li><span>최대인원</span>: <?echo $row['R_MAX_PER'];?>명</li>
					</ul>
				</td>
				<td>
					<select name="selectPeo[]">
						<option value="">선택</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>
						<option value="7">7</option>
						<option value="8">8</option>
						<option value="9">9</option>
					</select>
				</td>
				<td class="alignLeft">
					<ul class="revInfoList">
						<li><span>주중</span>:		<?echo number_format($row['R_B_MPRICE']);?>원</li>
						<li><span>주말</span>:		<?echo number_format($row['R_B_WPRICE']);?>원</li>
						<li><span>휴일</span>:		<?echo number_format($row['R_B_SPRICE']);?>원</li>
						<li><span>인원추가</span>:	<?echo number_format($row['R_BI_PRICE']);?>원/1인</li>
					</ul>
				</td>
				<td class="alignLeft">
					<ul class="revInfoList">
						<li><span>주중</span>:		<?echo number_format($row['R_Z_MPRICE']);?>원</li>
						<li><span>주말</span>:		<?echo number_format($row['R_Z_WPRICE']);?>원</li>
						<li><span>휴일</span>:		<?echo number_format($row['R_Z_SPRICE']);?>원</li>
						<li><span>인원추가</span>:	<?echo number_format($row['R_ZI_PRICE']);?>원/1인</li>
					</ul>
				</td>
				<td class="alignLeft">
					<ul class="revInfoList">
						<li><span>주중</span>:		<?echo number_format($row['R_S_MPRICE']);?>원</li>
						<li><span>주말</span>:		<?echo number_format($row['R_S_WPRICE']);?>원</li>
						<li><span>휴일</span>:		<?echo number_format($row['R_S_SPRICE']);?>원</li>
						<li><span>인원추가</span>:	<?echo number_format($row['R_SI_PRICE']);?>원/1인</li>
					</ul>
				</td>
			</tr>
			<?}?>
			<?}?>
		</table>

		<div class="revInfoTxt mt30">
			<ul>
				<li><span>성수기 안내</span> <?while($rowTime1 = mysql_fetch_array($resultGetTime)){echo substr($rowTime1['T_START_DT'],0,10)."~".substr($rowTime1['T_END_DT'],0,10).",";}?></li>
				<li><span>준성수기 안내</span> <?while($rowTime2 = mysql_fetch_array($resultGetTime2)){echo substr($rowTime2['T_START_DT'],0,10)."~".substr($rowTime2['T_END_DT'],0,10).",";}?></li>
				<li><span>주중/주말 안내</span>금,토요일은 주말요금이 적용됩니다.(일~목요일은 주중요금)</li>
				<li><span>휴일 안내</span> 법정공휴일은 휴일요금이 적용됩니다.</li>
			<ul>
		</div>


		<h3 class="mt30">부대시설 선택</h3>
			<table class="tableList">
				<colgroup>
					<col width=""/>
					<col/>
					<col/>
					<col/>
					<col/>
					<col/>
					<col/>
				</colgroup>
				<tr>
					<th>이용부대시설</th>
					<th>이용가격</th>
					<th>이용객수</th>
					<th>비고</th>
				</tr>
				<?while($rowRoomEtc = mysql_fetch_array($resultRoomEtc)){?>
								<?if($rowRoomEtc['AM_TYPE']=="부대시설"){?>
							<tr>
								<td>
									<input type="checkbox" name="checkAdd[]" value=""><?echo $rowRoomEtc['AM_DEV'];?><input name="addNolist" type="text" style="display:none" value="<?echo $rowRoomEtc['AM_NO'];?>">
								</td>
								<td align="right">
									<?echo number_format($rowRoomEtc['AM_PRICE']);?>원/<?echo $rowRoomEtc['AM_UNIT'];?>
								</td>
								<td>
									<input type="text" name="Nolist[]" class="wt20"><?echo $rowRoomEtc['AM_UNIT'];?>
								</td>
								<td>
									<?echo $rowRoomEtc['AM_MEMO'];?>
								</td>
							</tr>
								<?}?>
							<?}?>
			</table>
	</div>
	    <div class="buttonBoxWrap">
			<a class="btn_new_blue" href="javascript:goAct2(<?echo $strOption?>);"><strong class="ico_write"><?=$LNG_TRANS_CHAR["CW00002"] //등록?></strong></a>
			<a class="btn_new_gray" href="./?menuType=reservation&mode=month_revList"><strong class="ico_list"><?=$LNG_TRANS_CHAR["CW00001"] //목록?></strong></a>
		</div>
</div>
