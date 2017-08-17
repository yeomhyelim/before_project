<table border="1">
	<tr>
		<th><?=iconv("utf-8","euc-kr","받는분성명")?></th>
		<th><?=iconv("utf-8","euc-kr","받는분전화번호")?></th>
		<th><?=iconv("utf-8","euc-kr","받는분기타연락처")?></th>
		<th><?=iconv("utf-8","euc-kr","받는분우편번호")?></th>
		<th><?=iconv("utf-8","euc-kr","받는분주소(전체,분할)")?></th>
		<th><?=iconv("utf-8","euc-kr","배송메세지1")?></th>
		<th><?=iconv("utf-8","euc-kr","품목명")?></th>
		<th><?=iconv("utf-8","euc-kr","품목명")?></th>
		<th><?=iconv("utf-8","euc-kr","기본운임")?></th>
		<th><?=iconv("utf-8","euc-kr","박스수량")?></th>
	</tr>
	<?if ($intTotal == 0){?>
	<tr>
		<td colspan="10"><?=iconv("utf-8","euc-kr","주문된 내역이 없습니다.")?></td>
	</tr>
	<?}else{
		$index = 1;
		while($row = mysql_fetch_array($result)){
			
			$strProdName = $strProdOptAttr = $strProdAddOptAttr = "";
			
			$orderMgr->setO_NO($row[O_NO]);
			$cartResult = $orderMgr->getOrderCartList($db);			
			while ($cartRow = mysql_fetch_array($cartResult)){

				$orderMgr->setOC_NO($cartRow[OC_NO]);
				$aryProdCartAddOptList = $orderMgr->getOrderCartAddList($db);
				
				$strProdName .= iconv("utf-8","euc-kr",$cartRow[P_NAME]).":";
				$strCartOptAttrVal = "";
				for($kk=1;$kk<=10;$kk++){
					if ($cartRow["OC_OPT_ATTR".$kk]){
						$strCartOptAttrVal .= "/".$cartRow["OC_OPT_ATTR".$kk];
					}
				}
				$strProdOptAttr .= iconv("utf-8","euc-kr",$strCartOptAttrVal).":";

				$strCartOptAttrVal = SUBSTR($strCartOptAttrVal,1);
				if (is_array($aryProdCartAddOptList)){
					for($k=0;$k<sizeof($aryProdCartAddOptList);$k++){
						$strProdAddOptAttr .= iconv("utf-8","euc-kr",$aryProdCartAddOptList[$k][OCA_OPT_NM]).":";
					}
				}
			}

			if ($strProdName) $strProdName				= str_replace(":","",substr($strProdName,0,strlen($strProdName)-1));
			if ($strProdOptAttr) $strProdOptAttr		= str_replace(":","",substr($strProdOptAttr,0,strlen($strProdOptAttr)-1));
			if ($strProdAddOptAttr) $strProdAddOptAttr	= "".str_replace(":","",substr($strProdAddOptAttr,0,strlen($strProdAddOptAttr)-1));

		?>
	<tr>
		<td><?=iconv("utf-8","euc-kr",$row[O_B_NAME])?></td>
		<td><?=iconv("utf-8","euc-kr",$row[O_B_HP])?></td>
		<td><?=iconv("utf-8","euc-kr",$row[O_B_PHONE])?></td>		
		<td><?=iconv("utf-8","euc-kr",$row[O_B_ZIP])?></td>
		<td><?=iconv("utf-8","euc-kr",$row[O_B_ADDR1])?> <?=iconv("utf-8","euc-kr",$row[O_B_ADDR2])?></td>
		<td><?=iconv("utf-8","euc-kr",$row[O_B_MEMO])?></td>
		<td><?=$strProdName?></td>
		<td><?=$strProdOptAttr?><?=$strProdAddOptAttr?></td>	
		<td></td>
		<td></td>
	</tr>
	<?$index++;}}?>
</table>
