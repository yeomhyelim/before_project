<table border="1">
	<tr>
		<th><?=getEuckrString($LNG_TRANS_CHAR["CW00009"]) //번호?></th>
		<th><?=getEuckrString($LNG_TRANS_CHAR["OW00002"]) //주문번호?></th>
		<th><?=getEuckrString($LNG_TRANS_CHAR["OW00074"]) //주문일시?></th>
		<th>상품구매완료시간</th>
		<th>결제방법</th>
		<th>상품과세여부</th>
		<th>주문자</th>
		<th>주문자연락처</th>
		<th>주문자핸드폰</th>
		<th>주문자메일</th>
		<th>받는사람명</th>
		<th>받는사람연락처</th>
		<th>받는사람핸드폰</th>
		<th>받는사람메일</th>
		<th>받는사람주소</th>
		<th>받는사람메모</th>

		<th><?=getEuckrString($LNG_TRANS_CHAR["OW00010"]) //주문상태?></th>
		<th><?=getEuckrString($LNG_TRANS_CHAR["OW00096"]) //업체명?></th>
		
		<th>상품명</th>
		<th>상품옵션</th>
		<th>상품수량</th>
		<th>상품입고가</th>
		<th>상품판매가</th>
		<!--<th>총판매가</th>
        <th>총입고가</th>//-->
		<th>총배송비</th>
		<th>총정산금액</th>
		<th>aaaa</th>
		<th>총수수료</th>
		<th>과세/면세</th>



	</tr>
	<?if ($intTotal == 0){?>
	<tr>
		<td colspan="11"><?=getEuckrString($LNG_TRANS_CHAR["CS00001"])?></td>
	</tr>
	<?}else{
		$intTotOrderAccPrice2 = 0;
		while($row = mysql_fetch_array($result)){
		$intTotOrderAccPrice2 = 0;

			/* 주문내역 가지고 오기*/
			$accMgr->setO_NO($row[O_NO]);
			$accMgr->setSH_NO($row[SH_NO]);
			$param = "";
			$param['OC_ORDER_STATUS'] = "E";
			$aryOrderCartList = $accMgr->getOrderCartList($db,$param);
			
			if (!$row['SH_COM_NAME']) $row['SH_COM_NAME'] = "본사";
			
			$strOrderSettle = $S_ARY_SETTLE_TYPE[$row['O_SETTLE']];		// 결제방법	

			/* 과세/비과세 확인 */
			$intOrderNoTaxCnt	= $intOrderTaxCnt = 0;
			if (is_array($aryOrderCartList)){
				for($i=0;$i<sizeof($aryOrderCartList);$i++){

					if ($aryOrderCartList[$i]['P_TAX'] == "Y") {
						$intOrderTaxCnt++;
					} else if ($aryOrderCartList[$i]['P_TAX'] == "N") {
						$intOrderNoTaxCnt++;
					}
				}
			}
			
			$strOrderComplexTax = "";
			if ($intOrderNoTaxCnt > 0 && $intOrderTaxCnt == 0){
				$strOrderComplexTax = "면세";
			} else if ($intOrderNoTaxCnt == 0 && $intOrderTaxCnt > 0) {
				$strOrderComplexTax = "과세";
			} else if ($intOrderNoTaxCnt > 0 && $intOrderTaxCnt > 0) {
				$strOrderComplexTax = "복합";
			}

			$strCartOptAttrVal = "";
			for($kk=1;$kk<=10;$kk++){
				if ($aryOrderCartList[0]["OC_OPT_ATTR".$kk]){
					$strCartOptAttrVal .= "/".$aryOrderCartList[0]["OC_OPT_ATTR".$kk];
				}
			}
			$strCartOptAttrVal = SUBSTR($strCartOptAttrVal,1);
			
			#정산금액
			if (!$row[SO_TOT_DELIVERY_CUR_PRICE]) $row[SO_TOT_DELIVERY_CUR_PRICE] = 0;
			$intTotOrderAccPrice	= ($aryOrderCartList[0]['OC_STOCK_CUR_PRICE'] * $aryOrderCartList[0][OC_QTY]) + $row[SO_TOT_DELIVERY_CUR_PRICE];
			$intTotOrderAccPrice2   = $intTotOrderAccPrice2 + $intTotOrderAccPrice;
			
			$intTotOrderAccPrice1	= ($row[SO_TOT_CUR_APRICE]) + $row[SO_TOT_DELIVERY_CUR_PRICE];
			#수수료
			$intTotOrderAccFeePrice = ($aryOrderCartList[0]['OC_CUR_PRICE'] * $aryOrderCartList[0][OC_QTY]) - ($aryOrderCartList[0]['OC_STOCK_CUR_PRICE'] * $aryOrderCartList[0][OC_QTY]);
		?>
	<tr>
		<td><?=$intListNum?></td>
		<td><?=$row[O_KEY]?></td>
		<td><?=$row[O_REG_DT]?></td>
		<td><?=$aryOrderCartList[0][OC_E_REG_DT]?></td>
		<td><?=getEuckrString($strOrderSettle)?></td>
		<td><?=($aryOrderCartList[0]['P_TAX'] == "Y")?"과세":"면세";?></td>

		<td><?=getEuckrString($row['O_J_NAME'])?></td>
		<td><?=getEuckrString($row['O_J_PHONE'])?></td>
		<td><?=getEuckrString($row['O_J_HP'])?></td>
		<td><?=getEuckrString($row['O_J_MAIL'])?></td>
		<td><?=getEuckrString($row['O_B_NAME'])?></td>
		<td><?=getEuckrString($row['O_B_PHONE'])?></td>
		<td><?=getEuckrString($row['O_B_HP'])?></td>
		<td><?=getEuckrString($row['O_B_MAIL'])?></td>
		<td>[<?=getEuckrString($row['O_B_ZIP'])?>] <?=getEuckrString($row['O_B_ADDR1'])?> <?=getEuckrString($row['O_B_ADDR2'])?></td>
		<td><?=getEuckrString($row['O_B_MEMO'])?></td>

		<td><?=getEuckrString($S_ARY_SHOP_ORDER_STATUS[$row[SO_ORDER_STATUS]])?></td>

		<td><?=getEuckrString($row[SH_COM_NAME])?></td>
		
		<td><?=getEuckrString($aryOrderCartList[0][P_NAME])?></td>
		<td><?=getEuckrString($strCartOptAttrVal)?></td>
		<td><?=$aryOrderCartList[0][OC_QTY]?></td>
		<td><?=getFormatPrice($aryOrderCartList[0]['OC_STOCK_CUR_PRICE'])?></td>
		<td><?=getFormatPrice($aryOrderCartList[0]['OC_CUR_PRICE'])?></td>

		<!--<td><?=getFormatPrice($row[SO_TOT_CUR_SPRICE])?></td>
        <td><?=getFormatPrice($row[SO_TOT_CUR_PRICE])?></td>//-->
		<td><?=getFormatPrice($row[SO_TOT_DELIVERY_CUR_PRICE])?></td>
		<td><?=getFormatPrice($intTotOrderAccPrice)?></td>
		<td><?=getFormatPrice($intTotOrderAccPrice1)?>
		</td>
		<td><?=getFormatPrice($intTotOrderAccFeePrice)?></td>
		<td><?=$strOrderComplexTax?></td>
	</tr>
	<?	
		if (is_array($aryOrderCartList)){
			for($i=1;$i<sizeof($aryOrderCartList);$i++){

				$strCartOptAttrVal = "";
				for($kk=1;$kk<=10;$kk++){
					if ($aryOrderCartList[$i]["OC_OPT_ATTR".$kk]){
						$strCartOptAttrVal .= "/".$aryOrderCartList[$i]["OC_OPT_ATTR".$kk];
					}
				}
				$strCartOptAttrVal = SUBSTR($strCartOptAttrVal,1);

				#정산금액
				$intTotOrderAccPrice	= ($aryOrderCartList[$i]['OC_STOCK_CUR_PRICE'] * $aryOrderCartList[$i][OC_QTY]);
				
				#수수료
				$intTotOrderAccFeePrice = ($aryOrderCartList[$i]['OC_CUR_PRICE'] * $aryOrderCartList[$i][OC_QTY]) - $intTotOrderAccPrice;
				$intTotOrderAccPrice2   = $intTotOrderAccPrice2 + $intTotOrderAccPrice;

				?>
	<tr>
		<td><?=$intListNum?></td>
		<td><?=$row[O_KEY]?></td>
		<td><?=$row[O_REG_DT]?></td>
		<td><?=$aryOrderCartList[$i][OC_E_REG_DT]?></td>
		<td><?=getEuckrString($strOrderSettle)?></td>
		<td><?=($aryOrderCartList[$i]['P_TAX'] == "Y")?"과세":"면세";?></td>
		<td><?=getEuckrString($row['O_J_NAME'])?></td>
		<td><?=getEuckrString($row['O_J_PHONE'])?></td>
		<td><?=getEuckrString($row['O_J_HP'])?></td>
		<td><?=getEuckrString($row['O_J_MAIL'])?></td>
		<td><?=getEuckrString($row['O_B_NAME'])?></td>
		<td><?=getEuckrString($row['O_B_PHONE'])?></td>
		<td><?=getEuckrString($row['O_B_HP'])?></td>
		<td><?=getEuckrString($row['O_B_MAIL'])?></td>
		<td>[<?=getEuckrString($row['O_B_ZIP'])?>] <?=getEuckrString($row['O_B_ADDR1'])?> <?=getEuckrString($row['O_B_ADDR2'])?></td>
		<td><?=getEuckrString($row['O_B_MEMO'])?></td>
		
		<td><?=getEuckrString($S_ARY_SHOP_ORDER_STATUS[$row[SO_ORDER_STATUS]])?></td>
		<td><?=getEuckrString($row[SH_COM_NAME])?></td>
		
		<td><?=getEuckrString($aryOrderCartList[$i][P_NAME])?></td>
		<td><?=getEuckrString($strCartOptAttrVal)?></td>
		<td><?=$aryOrderCartList[$i][OC_QTY]?></td>
		<td><?=getFormatPrice($aryOrderCartList[$i]['OC_STOCK_CUR_PRICE'])?></td>
		<td><?=getFormatPrice($aryOrderCartList[$i]['OC_CUR_PRICE'])?></td>
		<!--
		<td><?=getFormatPrice($row[SO_TOT_CUR_SPRICE])?></td>
        <td><?=getFormatPrice($row[SO_TOT_CUR_PRICE])?></td>//-->
		<td></td>
		<td><?=getFormatPrice($intTotOrderAccPrice)?></td>
		<td></td>
		<td><?=getFormatPrice($intTotOrderAccFeePrice)?></td>
		<td><?=$strOrderComplexTax?></td>


	</tr>
				<?
		
				}
			}
			?>

	<tr>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		
		<td></td>
		<td></td>
		
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<!--
		<td><?=getFormatPrice($row[SO_TOT_CUR_SPRICE])?></td>
        <td><?=getFormatPrice($row[SO_TOT_CUR_PRICE])?></td>//-->
		<td></td>
		<td bgcolor="#cc00ff"></td>
		<td bgcolor="<?=($intTotOrderAccPrice2 != $intTotOrderAccPrice1) ? "#cc00ff":"";?>"><?=getFormatPrice($intTotOrderAccPrice1)?></td>
		<td><?=getFormatPrice($intTotOrderAccFeePrice)?></td>
		<td><?=$strOrderComplexTax?></td>


	</tr>
			<?
			$intListNum++;
		}
	}
	?>
</table>