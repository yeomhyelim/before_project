<style>
<!--
br{mso-data-placement:same-cell;}
td{mso-number-format:"\@";}
-->
</style>
<table border="1">
	<tr>
		<th><?=getEuckrString($LNG_TRANS_CHAR["CW00009"]) //��ȣ?></th>
		<th><?=getEuckrString($LNG_TRANS_CHAR["OW00002"]) //�ֹ���ȣ?></th>
		<th><?=getEuckrString($LNG_TRANS_CHAR["OW00074"]) //�ֹ��Ͻ�?></th>
		<th>��ǰ���ſϷ�ð�</th>
		<th>�������</th>
		<th>��ǰ��������</th>
		<th>�ֹ���</th>
		<th>�ֹ��ڿ���ó</th>
		<th>�ֹ����ڵ���</th>
		<th>�ֹ��ڸ���</th>
		<th>�޴»����</th>
		<th>�޴»������ó</th>
		<th>�޴»���ڵ���</th>
		<th>�޴»������</th>
		<th>�޴»���ּ�</th>
		<th>�޴»���޸�</th>

		<th><?=getEuckrString($LNG_TRANS_CHAR["OW00010"]) //�ֹ�����?></th>
		<th><?=getEuckrString($LNG_TRANS_CHAR["OW00096"]) //��ü��?></th>
		
		<th>��ǰ�ڵ�</th>
		<th>��ǰ��</th>
		<th>��ǰ�ɼ�</th>
		<th>��ǰ����</th>
		<th>��ǰ�԰�</th>
		<th>��ǰ�ǸŰ�</th>
		<!--<th>���ǸŰ�</th>
        <th>���԰�</th>//-->
		<th>�ѹ�ۺ�</th>
		<th>������ݾ�</th>
		<th>�Ѽ�����</th>
		<th>����/�鼼</th>



	</tr>
	<?if ($intTotal == 0){?>
	<tr>
		<td colspan="11"><?=getEuckrString($LNG_TRANS_CHAR["CS00001"])?></td>
	</tr>
	<?}else{
		while($row = mysql_fetch_array($result)){

			/* �ֹ����� ������ ����*/
			$accMgr->setO_NO($row[O_NO]);
			$accMgr->setSH_NO($row[SH_NO]);
			$param = "";
			$param['OC_ORDER_STATUS'] = "E";
			$aryOrderCartList = $accMgr->getOrderCartList($db,$param);
			
			if (!$row['SH_COM_NAME']) $row['SH_COM_NAME'] = "����";
			
			$strOrderSettle = $S_ARY_SETTLE_TYPE[$row['O_SETTLE']];		// �������	

			/* ����/����� Ȯ�� */
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
				$strOrderComplexTax = "�鼼";
			} else if ($intOrderNoTaxCnt == 0 && $intOrderTaxCnt > 0) {
				$strOrderComplexTax = "����";
			} else if ($intOrderNoTaxCnt > 0 && $intOrderTaxCnt > 0) {
				$strOrderComplexTax = "����";
			}

			$strCartOptAttrVal = "";
			for($kk=1;$kk<=10;$kk++){
				if ($aryOrderCartList[0]["OC_OPT_ATTR".$kk]){
					$strCartOptAttrVal .= "/".$aryOrderCartList[0]["OC_OPT_ATTR".$kk];
				}
			}
			$strCartOptAttrVal = SUBSTR($strCartOptAttrVal,1);
			
			#����ݾ�
			if (!$row[SO_TOT_DELIVERY_CUR_PRICE]) $row[SO_TOT_DELIVERY_CUR_PRICE] = 0;
			$intTotOrderAccPrice	= ($aryOrderCartList[0]['OC_STOCK_CUR_PRICE'] * $aryOrderCartList[0][OC_QTY]) + $row[SO_TOT_DELIVERY_CUR_PRICE];
			
			#������
			$intTotOrderAccFeePrice = ($aryOrderCartList[0]['OC_CUR_PRICE'] * $aryOrderCartList[0][OC_QTY]) - ($aryOrderCartList[0]['OC_STOCK_CUR_PRICE'] * $aryOrderCartList[0][OC_QTY]);
		?>
	<tr>
		<td><?=$intListNum?></td>
		<td><?=$row[O_KEY]?></td>
		<td><?=$row[O_REG_DT]?></td>
		<td><?=$aryOrderCartList[0][OC_E_REG_DT]?></td>
		<td><?=getEuckrString($strOrderSettle)?></td>
		<td><?=($aryOrderCartList[0]['P_TAX'] == "Y")?"����":"�鼼";?></td>

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
		
		<td><?=getEuckrString($aryOrderCartList[0][P_CODE])?></td>
		<td><?=getEuckrString($aryOrderCartList[0][P_NAME])?></td>
		<td><?=getEuckrString($strCartOptAttrVal)?></td>
		<td><?=$aryOrderCartList[0][OC_QTY]?></td>
		<td><?=getFormatPrice($aryOrderCartList[0]['OC_STOCK_CUR_PRICE'])?></td>
		<td><?=getFormatPrice($aryOrderCartList[0]['OC_CUR_PRICE'])?></td>

		<!--<td><?=getFormatPrice($row[SO_TOT_CUR_SPRICE])?></td>
        <td><?=getFormatPrice($row[SO_TOT_CUR_PRICE])?></td>//-->
		<td><?=getFormatPrice($row[SO_TOT_DELIVERY_CUR_PRICE])?></td>
		<td><?=getFormatPrice($intTotOrderAccPrice)?></td>
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

				#����ݾ�
				$intTotOrderAccPrice	= ($aryOrderCartList[$i]['OC_STOCK_CUR_PRICE'] * $aryOrderCartList[$i][OC_QTY]);
				
				#������
				$intTotOrderAccFeePrice = ($aryOrderCartList[$i]['OC_CUR_PRICE'] * $aryOrderCartList[$i][OC_QTY]) - $intTotOrderAccPrice;

				?>
	<tr>
		<td><?=$intListNum?></td>
		<td><?=$row[O_KEY]?></td>
		<td><?=$row[O_REG_DT]?></td>
		<td><?=$aryOrderCartList[$i][OC_E_REG_DT]?></td>
		<td><?=getEuckrString($strOrderSettle)?></td>
		<td><?=($aryOrderCartList[$i]['P_TAX'] == "Y")?"����":"�鼼";?></td>
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
		
		<td><?=getEuckrString($aryOrderCartList[$i][P_CODE])?></td>
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
		<td><?=getFormatPrice($intTotOrderAccFeePrice)?></td>
		<td><?=$strOrderComplexTax?></td>


	</tr>
				<?
		
				}
			}
			$intListNum++;
		}
	}
	?>
</table>