<table border="1">
	<tr>
		<th><?=$LNG_TRANS_CHAR["CW00009"]; //번호?></th>
		<th><?=$LNG_TRANS_CHAR["OW00002"]; //주문번호?></th>
		<th><?=$LNG_TRANS_CHAR["OW00074"]; //주문일시?></th>
		<th><?="결제상태"; //결제상태?></th>
		<th><?="결제일시"; //결제일시?></th>
		<?if($S_MALL_TYPE!="R"){?><th><?="입점사"; //입점사?></th><?}?>

		<th><?="주문자"; //주문자명?></th>
		<th><?="주문자연락처1"; //주문자연락처1?></th>
		<th><?="주문자연락처2"; //주문자연락처2?></th>
		<th><?="받는사람"; //받는사람?></th>
		<th><?="받는사람연락처1"; //받는사람연락처1?></th>
		<th><?="받는사람연락처2"; //받는사람연락처2?></th>
		<th><?="우편번호"; //우편번호?></th>
		<th><?="주소"; //주소?></th>


		<th><?="상품번호"; //상품번호?></th>
		<th><?="상품명"; //상품명?></th>
		<th><?="상품옵션"; //상품옵션?></th>
		<th><?="추가상품"; //추가상품?></th>
		<th><?="상품수량"; //상품수량?></th>
		<th><?="상품공급가"; //상품입고가?></th>
		<th><?="상품금액"; //상품금액?></th>
		<th><?="추가금액"; //추가상품금액?></th>
		<th><?="상품배송방법"; //상품배송방법?></th>
		<th><?="배송회사"; //배송회사?></th>
		<th><?="송장번호"; //송장번호?></th>
		<?if($S_MALL_TYPE!="R"){?><th><?="총배송비"; //총배송비?></th><?}?>
		<th><?="배송상태"; //배송상태?></th>
		<th><?="배송완료일자"; //배송완료일자?></th>
		<th><?="구매상태"; //구매상태?></th>
		<th><?="관리자메모"; //관리자메모?></th>

	</tr>
	<?
		while($row = mysql_fetch_array($orderDeliveryListResult)): // 배송 리스트

			/* 결제 상태 */
			$strOrderSettleStatusText = "";
			if ($row[O_STATUS] == "J" || $row[O_STATUS] == "O"){
				$strOrderSettleStatusText = $LNG_TRANS_CHAR["OW00079"]; //입금확인전
			} else {
				if (in_array($row[O_STATUS],array("A","B","I","D","E"))){
					$strOrderSettleStatusText	= $LNG_TRANS_CHAR["OW00080"]; //"결제완료";
				} else if (in_array($row[O_STATUS],array("C","S","R","T"))){
					$strOrderSettleStatusText	= $S_ARY_SHOP_ORDER_STATUS[$row[O_STATUS]];
				}
			}

			/* 주문 입점사별 리스트 */
			if ($S_MALL_TYPE != "R"){
				$param					= "";
				$param['O_NO']			= $row['O_NO'];
				$param["O_USE_LNG"]		= $S_SITE_LNG;
				$param['O_SHOP_NO']		= $row['P_SHOP_NO'];

				if ($_REQUEST['searchOrderStatus'] && in_array($_REQUEST['searchOrderStatus'],array('B','I','D'))){
					$param['OC_DELIVERY_STATUS']	= $_REQUEST['searchOrderStatus'];
				}

				$aryOrderCartShopList	= $shopOrderMgr->getOrderCartShopInfo($db,$param);
			}

			$param['OC_DELIVERY_STATUS']= $_REQUEST['searchOrderStatus'];
			if (!$param['searchOrderStatus'] && in_array($param['searchDeliveryStatus'],array('B','I','D'))){
				$param['OC_DELIVERY_STATUS'] = $param['searchDeliveryStatus'];
			}
			$param['OC_ORDER_STATUS_NOT_IN']		    = "'C1','S1','R1','T1','E','C2','S2','R2','T2'";
			$aryOrderCartList			= $shopOrderMgr->getOrderCartList($db,"OP_ARYTOTAL",$param);

			if (is_array($aryOrderCartList))
			{
				for($i=0;$i<sizeof($aryOrderCartList);$i++){

					$intCartShopNo			= $aryOrderCartList[$i]["P_SHOP_NO"];
					## 추가상품정보
					if ($aryOrderCartList[$i]["OC_OPT_ADD_CUR_PRICE"] > 0)
					{
						$param				= "";
						$param['OC_NO']		= $aryOrderCartList[$i]["OC_NO"];
						$aryProdCartAddOptList = $shopOrderMgr->getOrderCartAddList($db,"OP_ARYTOTAL",$param);
					}

					## 상품옵션정보
					$strCartOptAttrVal = "";
					for($kk=1;$kk<=10;$kk++){
						if ($aryOrderCartList[$i]["OC_OPT_ATTR".$kk]){
							$strCartOptAttrVal .= "/".$aryOrderCartList[$i]["OC_OPT_ATTR".$kk];
						}
					}
					$strCartOptAttrVal = SUBSTR($strCartOptAttrVal,1);

					## 상품배송정보
					$strCartDeliveryTypeName = "";
					switch($aryOrderCartList[$i]['OC_P_BAESONG_TYPE']){
						case "1":
							$strCartDeliveryTypeName	 = "기본배송";
						break;
						case "2":
							$strCartDeliveryTypeName	 = "무료배송";
						break;
						case "3":
							$strCartDeliveryTypeName	 = "고정배송비";
							$strCartDeliveryTypeName	.= "(".getCurMark($S_ST_CUR).getFormatPrice($aryOrderCartList[$i]['OC_DELIVERY_CUR_PRICE'],2).getCurMark2($S_ST_CUR).")";

						break;
						case "4":
							$strCartDeliveryTypeName	 = "수량별배송";
						break;
						case "5":
							$strCartDeliveryTypeName	 = "착불";
							$strCartDeliveryTypeName	.= "(".getCurMark($S_ST_CUR).getFormatPrice($aryOrderCartList[$i]['OC_DELIVERY_CUR_PRICE'],2).getCurMark2($S_ST_CUR).")";
						break;
					}

					## 배송비지불방법
					$strCartDeliveryPayMthName	= "";
					if ($aryOrderCartList[$i]['OC_BAESONG_TYPE'] == "1") $strCartDeliveryPayMthName = "(주문시결제)";
					else if ($aryOrderCartList[$i]['OC_BAESONG_TYPE'] == "2") $strCartDeliveryPayMthName = "(착불)";

					$temp							= explode(",", $S_DELIVERY_COM);
					if ($row['P_SHOP_NO'] > 0) {
						$temp						= explode(",", $aryOrderCartShopList[$intCartShopNo]['SH_COM_DELIVERY_COR']);
					}

					$aryDeliveryCom					= "";
					foreach($temp as $key):
						$aryDeliveryCom[$key]		= $aryDeliveryComAll[$key];
					endforeach;

					## 구매상태
					$strCartOrderCartStatus = "";
					if ($aryOrderCartList[0]['OC_ORDER_STATUS'] == "E") $strCartOrderCartStatus = $LNG_TRANS_CHAR["OW00139"];
					else {
						$strCartOrderCartStatus = $S_ARY_SETTLE_ORDER_STATUS[$aryOrderCartList[0]['OC_ORDER_STATUS']];
					}

					?>
	<tr>
		<td><?=$aryOrderCartList[$i]['OC_NO']?></td>
		<td><?=$row['O_KEY']?></td>
		<td><?=$row['O_REG_DT']?></td>
		<td><?=$strOrderSettleStatusText;?></td>
		<td><?=$row['O_APPR_DT']?></td>
		<?if($S_MALL_TYPE!="R"){?><td><?=$aryOrderCartShopList[$aryOrderCartList[$i]['P_SHOP_NO']]['SH_COM_NAME']?></td><?}?>

		<td><?=$row['O_J_NAME']?></td>
		<td><?=$row['O_J_PHONE']?></td>
		<td><?=$row['O_J_HP']?></td>
		<td><?=$row['O_B_NAME']?></td>
		<td><?=$row['O_B_PHONE']?></td>
		<td><?=$row['O_B_HP']?></td>
		<td><?=$row['O_B_ZIP']?></td>
		<td><?=$row['O_B_ADDR1']?> <?=$row['O_B_ADDR2']?></td>

		<td style='mso-number-format:"\@";' ><?=$aryOrderCartList[$i]['P_CODE']?></td>
		<td><?=$aryOrderCartList[$i]['OC_P_NAME']?></td>
		<td><?=$strCartOptAttrVal?></td>
		<td>
			<?if (is_array($aryProdCartAddOptList)){
				for($k=0;$k<sizeof($aryProdCartAddOptList);$k++){
				?>
				<?=$aryProdCartAddOptList[$k][OCA_OPT_NM]?><br>
			<?}}?>
		</td>
		<td><?=$aryOrderCartList[$i]['OC_QTY']?></td>
		<td><?=getFormatPrice($aryOrderCartList[$i]['OC_STOCK_CUR_PRICE'], 2)?></td>
		<td><?=getFormatPrice($aryOrderCartList[$i]['OC_CUR_PRICE'], 2)?></td>
		<td><?=getFormatPrice($aryOrderCartList[$i][OC_OPT_ADD_CUR_PRICE],2)?></td>
		<td><?=$strCartDeliveryTypeName?></td>
		<td><?=$aryDeliveryCom[$aryOrderCartList[$i][OC_DELIVERY_COM]];?></td>
		<td><?=$aryOrderCartList[$i]['OC_DELIVERY_NUM'];?></td>
		<?if($S_MALL_TYPE!="R"){?><td><?=getFormatPrice($aryOrderCartShopList[$aryOrderCartList[$i]['P_SHOP_NO']]['SO_TOT_DELIVERY_CUR_PRICE'],2)?></td><?}?>
		<td><?=$S_ARY_DELIVERY_STATUS[$aryOrderCartList[$i]['OC_DELIVERY_STATUS']];?></td>
		<td><?=$aryOrderCartList[$i]['OC_DELIVERY_END_DT'];?></td>
		<td><?=$strCartOrderCartStatus;?></td>

		<td><?=$row['O_B_MEMO'];?></td>
	</tr>

					<?

				}
			}
		?>
	<?endwhile;?>
</table>