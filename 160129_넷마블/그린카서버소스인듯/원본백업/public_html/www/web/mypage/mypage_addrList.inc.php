<?php
	## 2014.06.27 kim hee sung 소스 정리

	## 기본 정보
	$intMemberAddrCnt = 0;
	if($aryMemberAddrList) { $intMemberAddrCnt = sizeof($aryMemberAddrList); }


?>

<h4><?=$LNG_TRANS_CHAR["OW00085"] //주소록?></h4>

<div class="addr_wrap">
	<div class="btnRight">		
		<a href="javascript:goPopMemberWrite(0);" class="addrAddBtn"><?=$LNG_TRANS_CHAR["OW00083"] //배송지추가?></a>
	</div>
	<?php if(!$intMemberAddrCnt):?>
	<div class="noData"><?= $LNG_TRANS_CHAR["OS00098"]; //저장 된 주소가 없습니다. ?></div>
	<?php else:?>
	<div class="tableList">
	<?php foreach($aryMemberAddrList as $key => $row):
	
			## 기본 설정
			$intMA_NO = $row['MA_NO'];
			$strMA_STATE = $row['MA_STATE'];
			$strMA_COUNTRY = $row['MA_COUNTRY'];
			$strMA_STATE = $row['MA_STATE'];
			$strMA_TYPE = $row['MA_TYPE'];
			$strMA_NAME = $row['MA_NAME'];
			$strMA_PHONE = $row['MA_PHONE'];
			$strMA_HP = $row['MA_HP'];
			$strMA_ZIP = $row['MA_ZIP'];
			$strMA_ADDR1 = $row['MA_ADDR1'];
			$strMA_ADDR2 = $row['MA_ADDR2'];
			$strMA_CITY = $row['MA_CITY'];
			$strMA_STATE = $row['MA_STATE'];

			## 미국 주소에서 "주" 설정
			$strAddrState = "";
			if($strMA_COUNTRY == "US") { $strMA_STATE = $aryCountryState[$strMA_STATE]; }

			## 기본배송지 아이콘 설정
			$strDefaultAddrIcon = "";
			if($strMA_TYPE == "1") { $strDefaultAddrIcon = "[{$LNG_TRANS_CHAR['OW00086']}]"; }

			## 주소명 설정
			$strAddrName = "";
			if($strMA_ZIP) { $strAddrName .= "[{$strMA_ZIP}]"; }
			if($strMA_COUNTRY) { $strAddrName .= $strMA_COUNTRY; }
			if($strMA_ADDR1) { $strAddrName .= $strMA_ADDR1; }
			if($strMA_ADDR2) { 
				if($strAddrName) { $strAddrName .= " "; }
				$strAddrName .= $strMA_ADDR2;
			}
			if($strMA_CITY) { $strAddrName .= $strMA_CITY; }
			if($strMA_STATE) { $strAddrName .= $strMA_STATE; }

	?>
		<table>
			<colgroup>
				<col style="width:100px;"/>
				<col/>
			</colgroup>
			<tr>
				<th><?=$LNG_TRANS_CHAR["OW00017"] //주문자명?></th>
				<td><?php echo $strDefaultAddrIcon;?><?php echo $strMA_NAME;?></td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["OW00016"] //전화번호?></th>
				<td><?php echo $strMA_PHONE;?></td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["OW00010"] //핸드폰?></th>
				<td><?php echo $strMA_HP;?></td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["OW00022"] //주소?> </th>
				<td><?php echo $strAddrName;?></td>
			</tr>
		</table>
		<div class="btnRight">		
			<a href="javascript:goPopMemberWrite(<?php echo $intMA_NO;?>);" class="addrModBtn"><?=$LNG_TRANS_CHAR["OW00072"] //수정?></a>
			<a href="javascript:goMemberAddrDelete(<?php echo $intMA_NO;?>);" class="addrDelBtn"><?=$LNG_TRANS_CHAR["CW00036"] //삭제?></a>
		</div>
	<?php endforeach;?>
	</div>
	<?php endif;?>
</div>