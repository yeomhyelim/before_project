<? include "roomSetPolicy.helper.inc.php"?>
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
		<a href="./?menuType=reservation&mode=basicSet">기본환경설정</a>
		<a href="./?menuType=reservation&mode=roomSetEtc">부대시설설정</a>
		<a href="./?menuType=reservation&mode=roomSetFix">객실시설설정</a>
		<a href="./?menuType=reservation&mode=roomSetPolicy" class="selected">예약규정설정</a>
	</div>
	<!-- ******** 컨텐츠 ********* -->



	<div class="tableFo,rWrap">
		<h3>객실이용중 유의사항</h3>
		<table class="tableForm">
			<tr>
				<td><textarea name="rev_care" style="width:100%;height:150px;"><?php $row=$reservationMgr->getFromServerText($db,"S_REV_CARE");echo $row['VAL'];?></textarea></td>
			</tr>
		</table>

		<h3 class="mt30">이용요금규정</h3>
		<table class="tableForm">
			<tr>
				<td><textarea name="rev_price" style="width:100%;height:150px;"><?php $row=$reservationMgr->getFromServerText($db,"S_REV_PRICE");echo $row['VAL'];?></textarea></td>
			</tr>
		</table>

		<h3 class="mt30">취소환불규정</h3>
		<table class="tableForm">
			<tr>
				<td><textarea name="rev_refund" style="width:100%;height:150px;"><?php $row=$reservationMgr->getFromServerText($db,"S_REV_REFUND");echo $row['VAL'];?></textarea></td>
			</tr>
		</table>

		<h3 class="mt30">환불수수료설정</h3>
		<table class="tableForm">
			<tr>
				<th>이용 7일전취소</th>
				<td><input type="text" name="rev_ref_7" class="_w50" value="<?php $row=$reservationMgr->getFromServerInfo($db,"S_REV_REF7");echo $row['VAL'];?>">%</td>
			</tr>
			<tr>
				<th>이용 6일전취소</th>
				<td><input type="text" name="rev_ref_6" class="_w50" value="<?php $row=$reservationMgr->getFromServerInfo($db,"S_REV_REF6");echo $row['VAL'];?>">%</td>
			</tr>
			<tr>
				<th>이용 5일전취소</th>
				<td><input type="text" name="rev_ref_5" class="_w50" value="<?php $row=$reservationMgr->getFromServerInfo($db,"S_REV_REF5");echo $row['VAL'];?>">%</td>
			</tr>
			<tr>
				<th>이용 4일전취소</th>
				<td><input type="text" name="rev_ref_4" class="_w50" value="<?php $row=$reservationMgr->getFromServerInfo($db,"S_REV_REF4");echo $row['VAL'];?>">%</td>
			</tr>
			<tr>
				<th>이용 3일전취소</th>
				<td><input type="text" name="rev_ref_3" class="_w50" value="<?php $row=$reservationMgr->getFromServerInfo($db,"S_REV_REF3");echo $row['VAL'];?>">%</td>
			</tr>
			<tr>
				<th>이용 2일전취소</th>
				<td><input type="text" name="rev_ref_2" class="_w50" value="<?php $row=$reservationMgr->getFromServerInfo($db,"S_REV_REF2");echo $row['VAL'];?>">%</td>
			</tr>
			<tr>
				<th>이용 1일전취소</th>
				<td><input type="text" name="rev_ref_1" class="_w50" value="<?php $row=$reservationMgr->getFromServerInfo($db,"S_REV_REF1");echo $row['VAL'];?>">%</td>
			</tr>
			<tr>
				<th>이용 당일전취소</th>
				<td><input type="text" name="rev_ref_0" class="_w50" value="<?php $row=$reservationMgr->getFromServerInfo($db,"S_REV_REF0");echo $row['VAL'];?>">%</td>
			</tr>
		</table>
	</div>


	    <div class="buttonBoxWrap">
			<a class="btn_new_blue" href="javascript:void(0)" onclick="goAct()"><strong class="ico_write"><?=$LNG_TRANS_CHAR["CW00002"] //등록?></strong></a>
		</div>
</div>
