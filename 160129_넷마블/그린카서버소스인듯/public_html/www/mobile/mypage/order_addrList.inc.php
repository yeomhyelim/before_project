	<div class="btnRight">		
		<a href="javascript:goPopMemberWrite(0);" class="nextBigBtn"><?=$LNG_TRANS_CHAR["OW00083"] //배송지추가?></a>
	</div>
	<?
	if (is_array($aryMemberAddrList)){
		for($i=0;$i<sizeof($aryMemberAddrList);$i++){

			$strAddrState = $aryMemberAddrList[$i][MA_STATE];
			if ($aryMemberAddrList[$i][MA_COUNTRY] == "US") $strAddrState = $aryCountryState[$aryMemberAddrList[$i][MA_STATE]];
	?>
	<div class="tableList">
		<table>
			<colgroup>
				<col style="width:100px;"/>
				<col/>
			</colgroup>
			<tr>
				<th><?=$LNG_TRANS_CHAR["OW00017"] //주문자명?></th>
				<td><?=($aryMemberAddrList[$i][MA_TYPE]=="1")? "[".$LNG_TRANS_CHAR["OW00086"]."]":"";?><?=$aryMemberAddrList[$i][MA_NAME]?></td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["OW00016"] //전화번호?></th>
				<td><?=$aryMemberAddrList[$i][MA_PHONE]?></td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["OW00010"] //핸드폰?></th>
				<td><?=$aryMemberAddrList[$i][MA_HP]?></td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["OW00022"] //주소?> </th>
				<td>
					[<?=$aryMemberAddrList[$i][MA_ZIP]?>]<?if ($aryMemberAddrList[$i][MA_COUNTRY]) {echo $aryCountryList[$aryMemberAddrList[$i][MA_COUNTRY]];}?>
					<?=$aryMemberAddrList[$i][MA_ADDR1]?> <?=$aryMemberAddrList[$i][MA_ADDR2]?>
					<?if ($aryMemberAddrList[$i][MA_CITY]) {echo $aryMemberAddrList[$i][MA_CITY];}?>
					<?if ($aryMemberAddrList[$i][MA_STATE]) {echo $strAddrState;}?>
				</td>
			</tr>
		</table>
	</div>
	<div class="btnRight">		
		<a href="javascript:goPopMemberWrite(<?=$aryMemberAddrList[$i][MA_NO]?>);" class="cancelBigBtn"><?=$LNG_TRANS_CHAR["OW00072"] //수정?></a>
		<a href="javascript:goMemberAddrDelete(<?=$aryMemberAddrList[$i][MA_NO]?>);" class="nextBigBtn"><?=$LNG_TRANS_CHAR["CW00036"] //삭제?></a>
	</div>
	<?
	}}
	?>