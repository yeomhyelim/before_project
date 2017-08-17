<table border="1">
	<tr>
		<th><?=iconv("utf-8","euc-kr","순번")?></th>
		<th><?=iconv("utf-8","euc-kr","고객명")?></th>
		<th><?=iconv("utf-8","euc-kr","전화번호1")?></th>
		<th><?=iconv("utf-8","euc-kr","전화번호2")?></th>
		<th><?=iconv("utf-8","euc-kr","우편번호")?></th>
		<th><?=iconv("utf-8","euc-kr","주소")?></th>
		<th><?=iconv("utf-8","euc-kr","품목명1")?></th>
		<th><?=iconv("utf-8","euc-kr","품목명2")?></th>
		<th><?=iconv("utf-8","euc-kr","메모")?></th>
	</tr>
	<?if ($intTotal == 0){?>
	<tr>
		<td colspan="9"><?=iconv("utf-8","euc-kr","주문된 내역이 없습니다.")?></td>
	</tr>
	<?}else{
		$index = 1;
		while($row = mysql_fetch_array($result)){
			
			$strProdName = $strProdOptAttr = $strProdAddOptAttr = "";
			$intProdQty  = 0;

			$orderMgr->setO_NO($row[O_NO]);
			$cartResult = $orderMgr->getOrderCartList($db);			
			while ($cartRow = mysql_fetch_array($cartResult)){

				$orderMgr->setOC_NO($cartRow[OC_NO]);
				$aryProdCartAddOptList = $orderMgr->getOrderCartAddList($db);
				
				$intProdQty	  = $intProdQty + $cartRow[OC_QTY];
				$strProdName .= iconv("utf-8","euc-kr",$cartRow[P_NAME])." ".number_format($cartRow[OC_QTY]).iconv("utf-8","euc-kr","개").":";
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

			if ($strProdName) $strProdName				= str_replace(":","<br>",substr($strProdName,0,strlen($strProdName)-1));
			if ($strProdOptAttr) $strProdOptAttr		= str_replace(":","<br>",substr($strProdOptAttr,0,strlen($strProdOptAttr)-1));
			if ($strProdAddOptAttr) $strProdAddOptAttr	= "<br>".str_replace(":","<br>",substr($strProdAddOptAttr,0,strlen($strProdAddOptAttr)-1));

		?>
	<tr>
		<td><?=iconv("utf-8","euc-kr",$index)?></td>
		<td><?=iconv("utf-8","euc-kr",$row[O_B_NAME])?></td>
		<td><?=iconv("utf-8","euc-kr",$row[O_B_HP])?></td>
		<td><?=iconv("utf-8","euc-kr",$row[O_B_PHONE])?></td>		
		<td><?=iconv("utf-8","euc-kr",$row[O_B_ZIP])?></td>
		<td><?=iconv("utf-8","euc-kr",$row[O_B_ADDR1])?> <?=iconv("utf-8","euc-kr",$row[O_B_ADDR2])?></td>
		<td><?=$strProdName?></td>
		<td><?=$strProdOptAttr?><?=$strProdAddOptAttr?></td>	
		<td><?=iconv("utf-8","euc-kr",$row[O_B_MEMO])?></td>
	</tr>
	<?$index++;}}?>
</table>
