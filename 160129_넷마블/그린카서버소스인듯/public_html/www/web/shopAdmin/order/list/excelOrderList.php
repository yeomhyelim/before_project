<table border="1">
	<tr>
		<th><?=iconv("utf-8","euc-kr","번호")?></th>
		<th><?=iconv("utf-8","euc-kr","주문번호")?></th>
		<th><?=iconv("utf-8","euc-kr","주문일시")?></th>
		<th><?=iconv("utf-8","euc-kr","회원ID")?></th>
		<th><?=iconv("utf-8","euc-kr","상품명")?></th>
		<th><?=iconv("utf-8","euc-kr","주문자")?></th>
		<th><?=iconv("utf-8","euc-kr","주문자연락처")?></th>
		<th><?=iconv("utf-8","euc-kr","주문자핸드폰")?></th>
		<th><?=iconv("utf-8","euc-kr","주문자메일")?></th>
		<th><?=iconv("utf-8","euc-kr","받는사람명")?></th>
		<th><?=iconv("utf-8","euc-kr","받는사람연락처")?></th>
		<th><?=iconv("utf-8","euc-kr","받는사람핸드폰")?></th>
		<th><?=iconv("utf-8","euc-kr","받는사람메일")?></th>
		<th><?=iconv("utf-8","euc-kr","받는사람주소")?></th>
		<th><?=iconv("utf-8","euc-kr","사용포인트")?></th>
		<th><?=iconv("utf-8","euc-kr","총수량")?></th>
		<th><?=iconv("utf-8","euc-kr","총주문금액")?></th>
		<th><?=iconv("utf-8","euc-kr","총배송비")?></th>
		<th><?=iconv("utf-8","euc-kr","총결제금액")?></th>
		<th><?=iconv("utf-8","euc-kr","총적립액")?></th>
		<th><?=iconv("utf-8","euc-kr","결제방법")?></th>
		<th><?=iconv("utf-8","euc-kr","결제상태")?></th>
		<th><?=iconv("utf-8","euc-kr","결제승인번호")?></th>
		<th><?=iconv("utf-8","euc-kr","무통장입금자명")?></th>
		<th><?=iconv("utf-8","euc-kr","무통장입금은행")?></th>
		<th><?=iconv("utf-8","euc-kr","무통장입금계좌번호")?></th>
		<th><?=iconv("utf-8","euc-kr","가상계좌입금마감시간")?></th>	
		<th><?=iconv("utf-8","euc-kr","배송회사")?></th>
		<th><?=iconv("utf-8","euc-kr","배송번호")?></th>
		<th><?=iconv("utf-8","euc-kr","환불은행")?></th>
		<th><?=iconv("utf-8","euc-kr","환불계좌번호")?></th>
		<th><?=iconv("utf-8","euc-kr","환불예금주")?></th>
		<th><?=iconv("utf-8","euc-kr","취소사유")?></th>
		<th><?=iconv("utf-8","euc-kr","취소처리여부")?></th>
		<th><?=iconv("utf-8","euc-kr","메모")?></th>
	</tr>
	<?if ($intTotal == 0){?>
	<tr>
		<td colspan="35"><?=iconv("utf-8","euc-kr","주문된 내역이 없습니다.")?></td>
	</tr>
	<?}else{
		$index = 1;
		while($row = mysql_fetch_array($result)){
			$strOrderSettle = $strOrderBankName = $strOrderBank = $strOrderBankAcc = "";

			if ($row[O_SETTLE] == "C") $strOrderSettle = iconv("utf-8","euc-kr","신용카드");
			else if ($row[O_SETTLE] == "A") $strOrderSettle = iconv("utf-8","euc-kr","계좌이체");
			else if ($row[O_SETTLE] == "T") $strOrderSettle = iconv("utf-8","euc-kr","가상계좌");
			else if ($row[O_SETTLE] == "B") $strOrderSettle = iconv("utf-8","euc-kr","무통장입금");		
			else if ($row[O_SETTLE] == "P") $strOrderSettle = iconv("utf-8","euc-kr","포인트/쿠폰");
			
			$strOrderBankName = $row[O_BANK_NAME];
			$strOrderBank = $aryBank1[$row[O_BANK]];
			$strOrderBankAcc = $arySiteSettleBank[$row[O_BANK_ACC]];

			if ($row[O_SETTLE] == "T"){
				$strOrderBank		= $aryBank2[$row[O_BANK]];
				$strOrderBankAcc	= $row[O_BANK_ACC];
			}
			
			$orderMgr->setO_NO($row[O_NO]);
			$cartResult = $orderMgr->getOrderCartList($db);
		?>
	<tr>
		<td><?=iconv("utf-8","euc-kr",$index)?></td>
		<td><?=iconv("utf-8","euc-kr",$row[O_KEY])?></td>
		<td><?=iconv("utf-8","euc-kr",$row[O_REG_DT])?></td>
		<td><?=iconv("utf-8","euc-kr",$row[M_ID])?></td>
		<td>
			<?
			$intProdQty = 0;
			while ($cartRow = mysql_fetch_array($cartResult)){

				$orderMgr->setOC_NO($cartRow[OC_NO]);
				$aryProdCartAddOptList = $orderMgr->getOrderCartAddList($db);

				$strCartOptAttrVal = "";
				for($kk=1;$kk<=10;$kk++){
					if ($cartRow["OC_OPT_ATTR".$kk]){
						$strCartOptAttrVal .= "/".$cartRow["OC_OPT_ATTR".$kk];
					}
				}
				$strCartOptAttrVal = SUBSTR($strCartOptAttrVal,1);

				$intProdQty	  = $intProdQty + $cartRow[OC_QTY];
											
			?>
			<?=iconv("utf-8","euc-kr",$cartRow[P_NAME])?> <?=iconv("utf-8","euc-kr",$strCartOptAttrVal)?>
			<?if (is_array($aryProdCartAddOptList)){
				for($k=0;$k<sizeof($aryProdCartAddOptList);$k++){
				?>
				/<?=iconv("utf-8","euc-kr","추가선택")?> : <?=iconv("utf-8","euc-kr",$aryProdCartAddOptList[$k][OCA_OPT_NM])?>
			<?}}?>
				
			<?}?>
		</td>
		<td><?=iconv("utf-8","euc-kr",$row[O_J_NAME])?></td>
		<td><?=iconv("utf-8","euc-kr",$row[O_J_PHONE])?></td>
		<td><?=iconv("utf-8","euc-kr",$row[O_J_HP])?></td>
		<td><?=iconv("utf-8","euc-kr",$row[O_J_MAIL])?></td>
		<td><?=iconv("utf-8","euc-kr",$row[O_B_NAME])?></td>
		<td><?=iconv("utf-8","euc-kr",$row[O_B_PHONE])?></td>
		<td><?=iconv("utf-8","euc-kr",$row[O_B_HP])?></td>
		<td><?=iconv("utf-8","euc-kr",$row[O_B_MAIL])?></td>
		<td>[<?=iconv("utf-8","euc-kr",$row[O_B_ZIP])?>] <?=iconv("utf-8","euc-kr",$row[O_B_ADDR1])?> <?=iconv("utf-8","euc-kr",$row[O_B_ADDR2])?></td>
		<td><?=iconv("utf-8","euc-kr",$row[O_USE_POINT])?></td>
		<td><?=iconv("utf-8","euc-kr",$intProdQty)?></td>
		<td><?=iconv("utf-8","euc-kr",$row[O_TOT_PRICE])?></td>
		<td><?=iconv("utf-8","euc-kr",$row[O_TOT_DELIVERY_PRICE])?></td>
		<td><?=iconv("utf-8","euc-kr",$row[O_TOT_SPRICE])?></td>
		<td><?=iconv("utf-8","euc-kr",$row[O_TOT_POINT])?></td>
		<td><?=$strOrderSettle?></td>
		<td><?=iconv("utf-8","euc-kr",$S_ARY_SETTLE_STATUS[$row[O_STATUS]])?></td>
		<td style='mso-number-format:"\@";' ><?=iconv("utf-8","euc-kr",sprintf("%s", $row[O_APPR_NO]))?></td>
		<td><?=iconv("utf-8","euc-kr",$strOrderBankName)?></td>
		<td><?=iconv("utf-8","euc-kr",$strOrderBank)?></td>
		<td><?=iconv("utf-8","euc-kr",$strOrderBankAcc)?></td>
		<td><?=iconv("utf-8","euc-kr",$row[O_BANK_VALID_DT])?></td>
		<td><?=iconv("utf-8","euc-kr",$aryDeliveryCom[$row[O_DELIVERY_COM]])?></td>
		<td style='mso-number-format:"\@";'><?=iconv("utf-8","euc-kr",sprintf("%s", $row[O_DELIVERY_NUM]))?></td>
		<td><?=iconv("utf-8","euc-kr",$aryBank2["BK".$row[O_RETURN_BANK]])?></td>
		<td><?=iconv("utf-8","euc-kr",$row[O_RETURN_ACC])?></td>
		<td><?=iconv("utf-8","euc-kr",$row[O_RETURN_NAME])?></td>
		<td><?=iconv("utf-8","euc-kr",$row[O_CEL_MEMO])?></td>
		<td><?=iconv("utf-8","euc-kr",$row[O_CEL_STATUS])?></td>
		<td><?=iconv("utf-8","euc-kr",$row[O_B_MEMO])?></td>
	</tr>
	<?$index++;}}?>
</table>