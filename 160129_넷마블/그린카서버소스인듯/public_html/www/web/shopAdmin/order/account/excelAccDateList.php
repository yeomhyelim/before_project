
		<table border="1">
			<tr>
				<th><?=$LNG_TRANS_CHAR["OW00002"] //주문번호?></th>
				<th><?=$LNG_TRANS_CHAR["OW00074"] //주문일시?></th>
				<th><?="결제방법" //결제방법?></th>
				<th><?=$LNG_TRANS_CHAR["OW00096"] //업체명?></th>
				<th>상품명</th>
				<th>수량</th>
				<th><?=$LNG_TRANS_CHAR["OW00097"] //입고가격?></th>
				<th><?=$LNG_TRANS_CHAR["OW00098"] //판매가격?></th>
				<th><?="추가가격" //추가가격?></th>
				<th>과세/면세</th>
			</tr>
			<?
				while($row = mysql_fetch_array($result)){
					
					$strProdShopName = $aryShopList[$row['P_SHOP_NO']]; 
					if (!$strProdShopName) $strProdShopName = "본사";

					/* 주문내역 가지고 오기*/
					$accMgr->setO_NO($row[O_NO]);
					$accMgr->setSH_NO($row[SH_NO]);
					$aryOrderCartList = $accMgr->getOrderCartList($db);
					
					$strOrderSettle = $S_ARY_SETTLE_TYPE[$row['O_SETTLE']];		// 결제방법	

					$strCartOptAttrVal = "";
					for($kk=1;$kk<=10;$kk++){
						if ($row["OC_OPT_ATTR".$kk]){
							$strCartOptAttrVal .= "/".$row["OC_OPT_ATTR".$kk];
						}
					}
					$strCartOptAttrVal = SUBSTR($strCartOptAttrVal,1);
				?>
			<tr>
				<td><?=$row[O_KEY]?></td>
				<td><?=$row[O_REG_DT]?></td>
				<td><?=$strOrderSettle?></td>
				<td><?=$strProdShopName?></td>
				<td style="text-align:left"><?=$row[OC_P_NAME]?><?=($strCartOptAttrVal)?"({$strCartOptAttrVal})":"";?></td>
				<td><?=$row[OC_QTY]?></td>
				<td><?=getFormatPrice($row[OC_STOCK_CUR_PRICE])?></td>
				<td><?=getFormatPrice($row[OC_CUR_PRICE])?></td>
				<td><?=getFormatPrice($row[OC_OPT_ADD_CUR_PRICE])?></td>
				<td><?=($row['P_TAX']=="Y")?"과세":"면세";?></td>
			</tr>
			<?
				}
			?>
		</table>
