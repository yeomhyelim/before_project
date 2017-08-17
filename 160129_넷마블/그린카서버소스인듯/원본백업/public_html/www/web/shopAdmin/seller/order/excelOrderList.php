<table border="1">
	<tr>
		<th><?=iconv("utf-8","euc-kr",$LNG_TRANS_CHAR["CW00009"]) //번호?></th>
		<th><?=iconv("utf-8","euc-kr",$LNG_TRANS_CHAR["OW00002"]) //주문번호?></th>
		<th><?=iconv("utf-8","euc-kr",$LNG_TRANS_CHAR["OW00074"]) //주문일시?></th>
		<th><?=iconv("utf-8","euc-kr",$LNG_TRANS_CHAR["SW00057"]) //주문자?></th>
		<th><?=iconv("utf-8","euc-kr",$LNG_TRANS_CHAR["OW00075"]) //총주문금액?></th>
		<th><?=iconv("utf-8","euc-kr",$LNG_TRANS_CHAR["SW00062"]) //총정산금액?></th>
		<th><?=iconv("utf-8","euc-kr",$LNG_TRANS_CHAR["OW00027"]) //배송비?></th>
		<th><?=iconv("utf-8","euc-kr",$LNG_TRANS_CHAR["OW00038"]) //결제상태?></th>
		<th><?=iconv("utf-8","euc-kr",$LNG_TRANS_CHAR["SW00042"]) //배송업체?></th>
		<th><?=iconv("utf-8","euc-kr",$LNG_TRANS_CHAR["SW00056"]) //배송번호?></th>
		<th><?=iconv("utf-8","euc-kr",$LNG_TRANS_CHAR["SW00074"]) //배송상태?></th>
		<th><?=iconv("utf-8","euc-kr",$LNG_TRANS_CHAR["SW00075"]) //주문상태?></th>
	</tr>
	<?if ($intTotal == 0){?>
	<tr>
		<td colspan="12"><?=iconv("utf-8","euc-kr",$LNG_TRANS_CHAR["CS00001"])?></td>
	</tr>
	<?}else{
		$intListNum = 1;
		while($row = mysql_fetch_array($result)){

			/* 결제 상태 */
			$strOrderSettleStatusText = "";
			if ($row[O_STATUS] == "J" || $row[O_STATUS] == "O"){
				$strOrderSettleStatusText = iconv("utf-8","euc-kr",$LNG_TRANS_CHAR["OW00079"]); //입금확인전
			} else {
				$strOrderSettleStatusText = iconv("utf-8","euc-kr",$LNG_TRANS_CHAR["OW00080"]); //"결제완료";
			}

			/* 주문내역 가지고 오기*/
			$shopMgr->setO_NO($row[O_NO]);
			$shopMgr->setSH_NO($row[SH_NO]);
			$aryOrderCartList = $shopMgr->getShopOrderCartList($db);
			
			$strM_ID = ($S_MEM_CERITY=="1")?$row[M_ID]:$row[M_MAIL];
		?>
	<tr>
		<td><?=$intListNum?></td>
		<td><?=$row[O_KEY]?></td>
		<td><?=$row[O_REG_DT]?></td>
		<td>
			<?=iconv("utf-8","euc-kr",$row[O_J_NAME])?><?=($row[M_NO])? "(".$strM_ID.")":"";?>
			<br><?=iconv("utf-8","euc-kr",$row[O_B_NAME])?> <?=iconv("utf-8","euc-kr",$row[O_B_ADDR1])?> <?=iconv("utf-8","euc-kr",$row[O_B_ADDR2])?>
		</td>
		<td><?=getFormatPrice($row[SO_TOT_CUR_SPRICE],2)?></td>
		<td><?=getFormatPrice($row[SO_TOT_CUR_APRICE],2)?></td>
		<td><?=getFormatPrice($row[SO_TOT_DELIVERY_CUR_PRICE],2)?></td>			
		<td><?=$strOrderSettleStatusText?></td>
		<td>
			<?=iconv("utf-8","euc-kr",$aryDeliveryCom[$row[SO_DELIVERY_COM]])?>
		</td>
		<td><?=$row[SO_DELIVERY_NUM]?></td>
		<td><?=iconv("utf-8","euc-kr",$S_ARY_DELIVERY_STATUS[$row[SO_DELIVERY_STATUS]])?></td>
		<td><?=iconv("utf-8","euc-kr",$S_ARY_SETTLE_ORDER_STATUS[$row[SO_ORDER_STATUS]])?></td>
	</tr>
	<tr>
		<td colspan="12">
			<!-- 상품목록 -->
			<table border="1">
				<tr>
					<th colspan="2"><?=iconv("utf-8","euc-kr",$LNG_TRANS_CHAR["SW00058"]) //주문상품?></th>
					<th><?=iconv("utf-8","euc-kr",$LNG_TRANS_CHAR["SW00059"]) //수량?></th>
					<th><?=iconv("utf-8","euc-kr",$LNG_TRANS_CHAR["SW00060"]) //판매가?></th>
					<th><?=iconv("utf-8","euc-kr",$LNG_TRANS_CHAR["SW00061"]) //입고가?></th>			
				</tr>
				<?
				if (is_array($aryOrderCartList)){
					for($i=0;$i<sizeof($aryOrderCartList);$i++){
					
						$shopMgr->setOC_NO($aryOrderCartList[$i][OC_NO]);
						$aryProdCartAddOptList = $shopMgr->getShopOrderCartAddList($db);

						$strCartOptAttrVal = "";
						for($kk=1;$kk<=10;$kk++){
							if ($aryOrderCartList[$i]["OC_OPT_ATTR".$kk]){
								$strCartOptAttrVal .= $aryOrderCartList[$i]["OC_OPT_NM".$kk].":".$aryOrderCartList[$i]["OC_OPT_ATTR".$kk]."/";
							}
						}
						$strCartOptAttrVal = SUBSTR($strCartOptAttrVal,0,STRLEN($strCartOptAttrVal)-1);
				?>
				<tr>
					<td>
						<img src="<?=$S_SITE_URL?><?=$aryOrderCartList[$i][PM_REAL_NAME]?>" width="50" height="50"/>
					</td>
					<td align="left">										
						<?=iconv("utf-8","euc-kr",$aryOrderCartList[$i][P_NAME])?><br>
						<?=iconv("utf-8","euc-kr",$strCartOptAttrVal)?>

							<?if (is_array($aryProdCartAddOptList)){
								for($k=0;$k<sizeof($aryProdCartAddOptList);$k++){
								?>
								<br><?=iconv("utf-8","euc-kr",$LNG_TRANS_CHAR["OW00046"]) //추가선택?> : <?=iconv("utf-8","euc-kr",$aryProdCartAddOptList[$k][OCA_OPT_NM])?>
							<?}}?>
						</ul>
						<div class="clr"></div>
					</td>
					<td><?=$aryOrderCartList[$i][OC_QTY]?></td>
					<td><?=getFormatPrice($aryOrderCartList[$i][OC_CUR_PRICE],2)?></td>
					<td><?=getFormatPrice($aryOrderCartList[$i][OC_PRICE],2)?></td>
				</tr>
				<?}}?>
			</table>
			<!-- 상품목록 -->
		</td>
	</tr>
	<?
			$intListNum++;
		}
	}
	?>
</table>

