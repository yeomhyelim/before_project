<?
	## 설정
	## 배송회사 리스트
	if(!$aryDeliveryComAll):
	$aryDeliveryComAll = getCommCodeList("DELIVERY", "Y");
	endif;
	$aryDeliveryCom		= "";
	$temp				= explode(",", $S_DELIVERY_KR_COM);
	foreach($temp as $key):
		$aryDeliveryCom[$key] = $aryDeliveryComAll[$key];
	endforeach;

	## 금액 표시
	$moneyMarkL		= getCurMark($S_ST_CUR);
	$moneyMarkR		= getCurMark2($S_ST_CUR);
?>
<table border="1">
	<tr>
		<th><?=getEuckrString($LNG_TRANS_CHAR["CW00009"]); //번호?></th>
		<th><?=getEuckrString($LNG_TRANS_CHAR["OW00002"]); //주문번호?></th>
		<th><?=getEuckrString($LNG_TRANS_CHAR["OW00074"]); //주문일시?></th>
		<th><?=getEuckrString("결제일시"); //결제일시?></th>
		<th><?=getEuckrString("입점사"); //입점사?></th>

		<th><?=getEuckrString("구매자명"); //구매자명?></th>
		<th><?=getEuckrString("구매자연락처1"); //구매자연락처1?></th>
		<th><?=getEuckrString("구매자연락처2"); //구매자연락처2?></th>
		<th><?=getEuckrString("수령인명"); //수령인명?></th>
		<th><?=getEuckrString("수령인연락처1"); //수령인연락처1?></th>
		<th><?=getEuckrString("수령인연락처2"); //수령인연락처2?></th>
		<th><?=getEuckrString("우편번호"); //우편번호?></th>
		<th><?=getEuckrString("주소"); //주소?></th>
				
		<th><?=getEuckrString("주문금액"); //주문금액?></th>
		<th><?=getEuckrString("배송비"); //배송비?></th>
		
		<th><?=getEuckrString("상품번호"); //상품번호?></th>
		<th><?=getEuckrString("상품명"); //상품명?></th>
		<th><?=getEuckrString("상품옵션"); //상품옵션?></th>
		<th><?=getEuckrString("상품수량"); //상품수량?></th>
		<th><?=getEuckrString("상품금액"); //상품금액?></th>
		<th><?=getEuckrString("상품배송방법"); //상품배송방법?></th>
		<th><?=getEuckrString("배송회사"); //배송회사?></th>
		<th><?=getEuckrString("송장번호"); //송장번호?></th>
		<th><?=getEuckrString("결제상태"); //결제상태?></th>
		<th><?=getEuckrString("배송상태"); //배송상태?></th>
		<th><?=getEuckrString("구매상태"); //구매상태?></th>
		<th><?=getEuckrString("관리자메모"); //관리자메모?></th>
	</tr>
	<tr>
		<td><?=getEuckrString("__CODE__"); //번호?></td>
		<td><?=getEuckrString(""); //주문번호?></td>
		<td><?=getEuckrString(""); //주문일시?></td>
		<td><?=getEuckrString(""); //결제일시?></td>
		<td><?=getEuckrString(""); //입점사?></td>

		<td><?=getEuckrString(""); //구매자명?></td>
		<td><?=getEuckrString(""); //구매자연락처1?></td>
		<td><?=getEuckrString(""); //구매자연락처2?></td>
		<td><?=getEuckrString(""); //수령인명?></td>
		<td><?=getEuckrString(""); //수령인연락처1?></td>
		<td><?=getEuckrString(""); //수령인연락처2?></td>
		<td><?=getEuckrString(""); //우편번호?></td>
		<td><?=getEuckrString(""); //주소?></td>

		<td><?=getEuckrString(""); //주문금액?></td>
		<td><?=getEuckrString(""); //배송비?></td>
		<td><?=getEuckrString(""); //상품번호?></td>
		<td><?=getEuckrString(""); //상품명?></td>
		<td><?=getEuckrString(""); //상품옵션?></td>
		<td><?=getEuckrString(""); //상품수량?></td>
		<td><?=getEuckrString(""); //상품금액?></td>
		<td><?=getEuckrString(""); //상품배송방법?></td>
		<td><?=getEuckrString("__DELIVERY_COM__"); //배송회사?></td>
		<td><?=getEuckrString("__DELIVERY_NUM__"); //송장번호?></td>
		<td><?=getEuckrString(""); //결제상태?></td>
		<td><?=getEuckrString(""); //배송상태?></td>
		<td><?=getEuckrString(""); //구매상태?></td>
		<td><?=getEuckrString(""); //관리자메모?></td>

	</tr>
	<?while($row = mysql_fetch_array($deliveryResult)): // 배송 리스트

		  // 배송회사 설정
		  $deliveryCom						= $aryDeliveryCom;
		  if($row['SH_COM_DELIVERY_COR']):								
			  $temp								= explode(",", $row['SH_COM_DELIVERY_COR']);
			  $deliveryCom						= "";
			  foreach($temp as $key):
				$deliveryCom[$key]				= $aryDeliveryComAll[$key];
			  endforeach;
		  endif;
		  $deliveryComName						= $deliveryCom[$row['SO_DELIVERY_COM']];

		  // 주문금액
		  $orderPrice	= $row['SO_TOT_CUR_SPRICE'];
		  $orderPrice	= getFormatPrice($orderPrice, 2);
		  $orderPrice	= "{$moneyMarkL} {$orderPrice} {$moneyMarkR}";

		  // 배송금액
		  $deliveryprice	= $row['SO_TOT_DELIVERY_CUR_PRICE'];
		  $deliveryprice	= getFormatPrice($deliveryprice, 2);
		  $deliveryprice	= "{$moneyMarkL} {$deliveryprice} {$moneyMarkR}";	
		  
		  // 결제상태, 배송상태, 구매상태
		  $settleStatus			= $S_ARY_SETTLE_STATUS[$row['O_STATUS']];
		  $deliveryStatus		= $S_ARY_DELIVERY_STATUS[$row['SO_DELIVERY_STATUS']];
		  $orderStatus			= $S_ARY_SETTLE_ORDER_STATUS[$row['SO_ORDER_STATUS']];
		  
		  if(!$settleStatus)	{ $settleStatus = "-"; }

			/* SHOP CART 리스트 */
			$param								= "";
			$param['o_no']						= $row['O_NO'];
			$param['p_shop_no']					= $row['SH_NO'];
			$param['order_by']					= "OC.OC_NO ASC";
			if (in_array($strSearchOrderStatus,array("E","C","R","T"))){
				$param["in_soc_status"] = "'".$strSearchOrderStatus."'";
				if ($strSearchOrderStatus == "R"){
					$param["in_soc_status"] = "'R','S'";
				}
			}
			$intShopOrderCartListTotal			= $shopOrderMgr->getOrderCartListEx($db, "OP_COUNT", $param);
			$aryShopOrderCartList				= $shopOrderMgr->getOrderCartListEx($db, "OP_ARYTOTAL", $param);

			if($intShopOrderCartListTotal <= 0 ) { continue; } /* 2013.06.28 kim hee sung 입점사에서 상품 구매 정보가 없으면 표시 안함(검색에서 유용하게 사용중..) */

			if ($intShopOrderCartListTotal > 0){
				$param = "";
				$param["oc_no"] = $aryShopOrderCartList[0]['OC_NO'];
				$aryProdCartAddOptList = $shopOrderMgr->getOrderCartAddList($db,$param);

				$strCartOptAttrVal = "";
				for($kk=1;$kk<=10;$kk++){
					if ($ocRow["OC_OPT_ATTR".$kk]){
						$strCartOptAttrVal .= "/".$aryShopOrderCartList[0]["OC_OPT_ATTR".$kk];
					}
				}
				$strCartOptAttrVal = SUBSTR($strCartOptAttrVal,1);

				$strDeliveryTypeName = "";
				if (is_array($aryShopOrderCartList[0])){
					if ($aryShopOrderCartList[0]['P_BAESONG_TYPE'] == "2") $strDeliveryTypeName = "무료배송";
					else if ($aryShopOrderCartList[0]['P_BAESONG_TYPE'] == "3") $strDeliveryTypeName = "배송비고정";
					else if ($aryShopOrderCartList[0]['P_BAESONG_TYPE'] == "4") $strDeliveryTypeName = "수량별배송";
					else if ($aryShopOrderCartList[0]['P_BAESONG_TYPE'] == "5") {
						$strDeliveryTypeName = "착불";
						if ($aryShopOrderCartList[0]['P_BAESONG_PRICE'] > 0) $strDeliveryTypeName .= "(".getFormatPrice($aryShopOrderCartList[0]['P_BAESONG_PRICE'],2).")";
					}
				}
			}
	?>
	<tr id="shop_order_<?=getEuckrString($row['SO_NO']);?>">
		<td rowspan="<?=$intShopOrderCartListTotal?>" alt="<?=getEuckrString("번호");?>"><?=getEuckrString($row['SO_NO']);?></td>
		<td rowspan="<?=$intShopOrderCartListTotal?>" alt="<?=getEuckrString("주문번호");?>"><?=getEuckrString($row['O_KEY']);?></td>
		<td rowspan="<?=$intShopOrderCartListTotal?>" alt="<?=getEuckrString("주문일시");?>"><?=getEuckrString($row['O_REG_DT']);?></td>
		<td rowspan="<?=$intShopOrderCartListTotal?>" alt="<?=getEuckrString("결제일시");?>"><?=getEuckrString($row['O_APPR_DT']);?></td>
		<td rowspan="<?=$intShopOrderCartListTotal?>" alt="<?=getEuckrString("입점사");?>"><?=getEuckrString($row['ST_NAME']);?></td>
		
		<td rowspan="<?=$intShopOrderCartListTotal?>" alt="<?=getEuckrString("구매자명");?>"><?=getEuckrString($row['O_J_NAME']);?></td>
		<td rowspan="<?=$intShopOrderCartListTotal?>" alt="<?=getEuckrString("구매자연락처1");?>"><?=getEuckrString($row['O_J_PHONE']);?></td>
		<td rowspan="<?=$intShopOrderCartListTotal?>" alt="<?=getEuckrString("구매자연락처2");?>"><?=getEuckrString($row['O_J_HP']);?></td>
		<td rowspan="<?=$intShopOrderCartListTotal?>" alt="<?=getEuckrString("수령인명");?>"><?=getEuckrString($row['O_B_NAME']);?></td>
		<td rowspan="<?=$intShopOrderCartListTotal?>" alt="<?=getEuckrString("수령인연락처1");?>"><?=getEuckrString($row['O_B_PHONE']);?></td>
		<td rowspan="<?=$intShopOrderCartListTotal?>" alt="<?=getEuckrString("수령인연락처2");?>"><?=getEuckrString($row['O_B_HP']);?></td>
		<td rowspan="<?=$intShopOrderCartListTotal?>" alt="<?=getEuckrString("우편번호");?>"><?=getEuckrString($row['O_B_ZIP']);?></td>
		<td rowspan="<?=$intShopOrderCartListTotal?>" alt="<?=getEuckrString("주소");?>"><?=getEuckrString($row['O_B_ADDR1']);?> <?=getEuckrString($row['O_B_ADDR2']);?></td>

		<td rowspan="<?=$intShopOrderCartListTotal?>" alt="<?=getEuckrString("주문금액");?>"><?=getEuckrString($orderPrice);?></td>
		<td rowspan="<?=$intShopOrderCartListTotal?>" alt="<?=getEuckrString("배송비");?>"><?=getEuckrString($deliveryprice);?></td>
		
		<td style='mso-number-format:"\@";' ><?=getEuckrString($aryShopOrderCartList[0]['P_CODE'])?></td>
		<td><?=getEuckrString($aryShopOrderCartList[0]['P_NAME'])?></td>
		<td><?=getEuckrString($strCartOptAttrVal)?></td>
		<td><?=$aryShopOrderCartList[0]['OC_QTY']?></td>
		<td><?=getFormatPrice($aryShopOrderCartList[0]['OC_CUR_PRICE'], 2)?></td>
		<td><?=getEuckrString($strDeliveryTypeName)?></td>
		<td rowspan="<?=$intShopOrderCartListTotal?>" alt="<?=getEuckrString("배송회사");?>"><?=getEuckrString($deliveryComName);?></td>
		<td rowspan="<?=$intShopOrderCartListTotal?>" alt="<?=getEuckrString("송장번호");?>"><?=getEuckrString($row['SO_DELIVERY_NUM']);?></td>
		<td rowspan="<?=$intShopOrderCartListTotal?>" alt="<?=getEuckrString("결제상태");?>"><?=getEuckrString($settleStatus);?></td>
		<td rowspan="<?=$intShopOrderCartListTotal?>" alt="<?=getEuckrString("배송상태");?>"><?=getEuckrString($deliveryStatus);?></td>
		<td rowspan="<?=$intShopOrderCartListTotal?>" alt="<?=getEuckrString("구매상태");?>"><?=getEuckrString($orderStatus);?></td>
		<td rowspan="<?=$intShopOrderCartListTotal?>" alt="<?=getEuckrString("관리자메모");?>"><?=getEuckrString($row['O_B_MEMO']);?></td>
	</tr>
	<?
		if (is_array($aryShopOrderCartList)){
			for($j=1;$j<sizeof($aryShopOrderCartList);$j++){	
				
				$param = "";
				$param["oc_no"] = $aryShopOrderCartList[$j]['OC_NO'];
				$aryProdCartAddOptList = $shopOrderMgr->getOrderCartAddList($db,$param);

				$strCartOptAttrVal = "";
				for($kk=1;$kk<=10;$kk++){
					if ($ocRow["OC_OPT_ATTR".$kk]){
						$strCartOptAttrVal .= "/".$ocRow["OC_OPT_ATTR".$kk];
					}
				}
				$strCartOptAttrVal = SUBSTR($strCartOptAttrVal,1);

				$strDeliveryTypeName = "";
				if (is_array($aryShopOrderCartList[$j])){
					if ($aryShopOrderCartList[$j]['P_BAESONG_TYPE'] == "2") $strDeliveryTypeName = "무료배송";
					else if ($aryShopOrderCartList[$j]['P_BAESONG_TYPE'] == "3") $strDeliveryTypeName = "배송비고정";
					else if ($aryShopOrderCartList[$j]['P_BAESONG_TYPE'] == "4") $strDeliveryTypeName = "수량별배송";
					else if ($aryShopOrderCartList[$j]['P_BAESONG_TYPE'] == "5") $strDeliveryTypeName = "착불";
					if ($aryShopOrderCartList[$j]['P_BAESONG_PRICE'] > 0) $strDeliveryTypeName .= "(".getFormatPrice($aryShopOrderCartList[$j]['P_BAESONG_PRICE'],2).")";

				}
				?>
	<tr>
		<td style='mso-number-format:"\@";' ><?=getEuckrString($aryShopOrderCartList[$j]['P_CODE'])?></td>
		<td><?=getEuckrString($aryShopOrderCartList[$j]['P_NAME'])?></td>
		<td><?=getEuckrString($strCartOptAttrVal)?></td>
		<td><?=$aryShopOrderCartList[$j]['OC_QTY']?></td>
		<td><?=getFormatPrice($aryShopOrderCartList[$j]['OC_CUR_PRICE'], 2)?></td>
		<td><?=getEuckrString($strDeliveryTypeName)?></td>
	</tr>

				<?
			}
		}
	  endwhile;?>
</table>