<?include "adm_revConfirm.helper.php";?>
<?include "adm_revConfirm.script.php";?>
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
	<div class="tableListWrap mt20">
	<?$roomTotalPrice = 0;?>
	<?$strDate		= date("Y-m-d",strtotime($strDate));$k=1?>
	<?for($i=0;$i<count($roomNo);$i++){?>
	<?$strDate1		= date("Y-m-d",strtotime($strDate));?>
		<?for($l=0;$l<$intStay;$l++){?>
		<div class="calendarTop">
			<h3>객실예약정보(<?echo $k;?>)</h3>
			<div class="clr"></div>
		</div>
		<?$result		= $reservationMgr->getRoomBasic3($db,$roomNo[$i])?>

		<?$strDate2		= date("Y-m-d",strtotime($strDate1.'+1 day'));?>
		<table class="tableList2" border="1">
			<colgroup>
				<col width="150"/>
				<col/>
			</colgroup>
			<tr>
				<th>객실명</th>
				<td><?echo $result['R_NAME']."(".$result['R_TYPE'].")";?></td>
			</tr>
			<tr>
				<th>이용기간</th>
				<td><?echo $strDate1 . "~". $strDate2 ;?></td>
			</tr>
			<tr>
				<th>요금적용</th>
				<td><?echo $result['R_B_MPRICE']."원";?></td>
			</tr>
			<tr>
				<th>인원수</th>
				<td><?echo $roomUnit[$i];?></td>
			</tr>
			<tr>
				<th>객실요금합계</th>
				<td><?echo $result['R_B_MPRICE']."원";?><?$roomTotalPrice += $result['R_B_MPRICE'];?></td>
			</tr>
		</table>
		<?$strDate1 = date("Y-m-d",strtotime($strDate1.'+1 day'));?>
		<?$k++?>
		<?}?>
		<?}?>
			<h3>부대시설정보</h3>
			<div class="clr"></div>
		</div>
		<table class="tableList2" border="1">
			<colgroup>
				<col width="150"/>
				<col/>
			</colgroup>
			<?$addTotalPrice = 0;?>
			<?for($i=0;$i<count($addNo);$i++){?>
			<?$result = $reservationMgr->getRoomSetEtcView($db,$addNo[$i]);?>
			<tr>
				<th>부대시설및요금</th>
				<td><?echo $result['AM_DEV']."(".number_format($result['AM_PRICE'])."원*)".$addUnit[$i].$result['AM_UNIT'];$addTotalPrice += $result['AM_PRICE']*$addUnit[$i];?></td>
			</tr>
			<?}?>
			<tr>
				<th>총합계요금</th>
				<td><?echo number_format($roomTotalPrice)."+".number_format($addTotalPrice)."=".number_format($roomTotalPrice+$addTotalPrice);?></td>
			</tr>
		</table>
		<h3>예약자정보</h3>
			<div class="clr"></div>

		<table class="tableList2" border="1">
			<colgroup>
				<col width="150"/>
				<col/>
			</colgroup>
			<tr>
				<th>예약자성함</th>
				<td>관리자</td>
			</tr>
			<tr>
				<th>예약자연락처</th>
				<td>eum@eumshop.co.kr</td>
			</tr>
			<tr>
				<th>예약자전화번호</th>
				<td>010-5151-5252</td>
			</tr>
		</table>
		<input type="hidden" name="selectDay" value="<?echo $intStay;?>">
		<input type="hidden" name="StartDt"  value="<?echo $strDate;?>">
		<input type="hidden" name="pay_cash" value="<?echo $roomTotalPrice+$addTotalPrice;?>">
		<input type="hidden" name="roomPay" value="<?echo $roomTotalPrice;?>">
		<input type="hidden" name="AddPay" value="<?echo $addTotalPrice;?>">
		<input type="hidden" name="roomList" value="<?echo $strClist;?>">
		<input type="hidden" name="peoList" value="<?echo $strDlist;?>">
		<input type="hidden" name="addList" value="<?echo $strAlist;?>">
		<input type="hidden" name="noList" value="<?echo $strBlist;?>">
	</div>
	    <div class="buttonBoxWrap">
			<a class="btn_new_blue" href="javascript:goAct();"><strong class="ico_write"><?=$LNG_TRANS_CHAR["CW00006"] //승인?></strong></a>
		</div>
</div>
