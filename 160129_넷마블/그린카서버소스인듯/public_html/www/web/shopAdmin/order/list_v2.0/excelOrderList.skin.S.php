
<table border="1">
	<tr>
		<th><?=$LNG_TRANS_CHAR["CW00009"] //번호?></th>
		<th><?=$LNG_TRANS_CHAR["OW00002"] //주문번호?></th>
		<th><?=$LNG_TRANS_CHAR["OW00074"] //주문일시?></th>
		<th><?="회원ID"?></th>
		<th><?="주문자"?></th>
		<th><?="주문자연락처"?></th>
		<th><?="주문자핸드폰"?></th>
		<th><?="주문자메일"?></th>
		<th><?="받는사람명"?></th>
		<th><?="받는사람연락처"?></th>
		<th><?="받는사람핸드폰"?></th>
		<th><?="받는사람메일"?></th>
		<th><?="받는사람우편번호"?></th>
		<th><?="받는사람주소"?></th>
		<th><?="받는사람메모"?></th>

		<?if ($S_MALL_TYPE != "R"){?><th><?="입점사명"?></th><?}?>

		<th><?="상품번호"?></th>
		<th><?="상품명"?></th>
		<th><?="상품옵션"?></th>
		<th><?="추가상품"?></th>
		<th><?="입고가격"?></th>
		<th><?="판매가격"?></th>
		<th><?="추가금액"?></th>
		<th><?="상품수량"?></th>
		<th><?="상품배송방법"?></th>
		<th><?="배송회사"?></th>
		<th><?="배송번호"?></th>
		<?if ($S_MALL_TYPE != "R"){?><th><?="총배송비"?></th><?}?>

		<th><?="배송상태"?></th>
		<th><?="배송시작일"?></th>
		<th><?="배송완료일"?></th>
		<th><?="구매상태"?></th>
		<th><?="통관정보"?></th>

		<th><?="취소사유"?></th>
		<th><?="취소처리여부"?></th>
	</tr>
	<?
	$index = 1;
	while($row = mysql_fetch_array($orderListResult)): // 주문 리스트
		$strOrderSettleStatus = $strOrderStatus = $strOrderBankName = $strOrderBank = $strOrderBankAcc = "";
		$strOrderVirtualBank  = $strOrderVirtualBankAcc = "";

		/* 무통장 입금 정보 */
		$strOrderBankName	= $row['O_BANK_NAME'];
		$strOrderBank		= $aryBank1[$row['O_BANK']];
		$strOrderBankAcc	= $arySiteSettleBank[$row['O_BANK_ACC']];

		/* 가상계좌 입금 */
		if ($row['O_SETTLE'] == "T"){
			$strOrderVirtualBank	= $aryBank2[$row['O_BANK']];
			$strOrderVirtualBankAcc	= $row['O_BANK_ACC'];
		}

		/* 결제상태 */
		if ($row[O_STATUS] == "J" || $row[O_STATUS] == "O"){
			$strOrderSettleStatus = $LNG_TRANS_CHAR["OW00079"];
		} else {
			if (in_array($row[O_STATUS],array("A","B","I","D","E","C","S","R","T"))){
				$strOrderSettleStatus = $LNG_TRANS_CHAR["OW00080"]; //"결제완료";
			}
		}

		/* 주문 상태 */
		$strOrderStatus = "";
		if (in_array($row[O_STATUS],array("B","I","D","E","C","S","R","T"))){
			$strOrderStatus = $S_ARY_SHOP_ORDER_STATUS[$row[O_STATUS]];
			if (!$strOrderStatusText) $strOrderStatus = $S_ARY_DELIVERY_STATUS[$row[O_STATUS]];
		}

		/* 주문 입점사별 리스트 */
		$param				= "";
		$param['O_NO']		= $row['O_NO'];
		$param["O_USE_LNG"] = $S_SITE_LNG;

		if ($S_MALL_TYPE != "R"){
			## 주문 입점사별 정보
			$param['O_SHOP_NO']	= "-1";
			if ($a_admin_type == "S" && $a_admin_shop_no){
				$param['O_SHOP_NO'] = $a_admin_shop_no;
			}

			$aryOrderCartShopList	= $shopOrderMgr->getOrderCartShopInfo($db,$param);
		}

		/* 사은품 내역 가지고 오기*/
		$aryOrderGiftList = $shopOrderMgr->getOrderGiftList($db,$param);

		/* 해당 주문 상품 정보 가지고 오기 */
		$aryOrderCartList = $shopOrderMgr->getOrderCartList($db,"OP_ARYTOTAL",$param);

//		if (!is_array($aryOrderCartList)) continue;
		## 추가상품정보
		$aryProdCartAddOptList  = "";
		if ($aryOrderCartList[0]["OC_OPT_ADD_CUR_PRICE"] >= 0)
		{
			$param				= "";
			$param['OC_NO']		= $aryOrderCartList[0]["OC_NO"];
			$aryProdCartAddOptList = $shopOrderMgr->getOrderCartAddList($db,"OP_ARYTOTAL",$param);
		}

		## 상품옵션정보
		$strCartOptAttrVal = "";
		for($kk=1;$kk<=10;$kk++){
			if ($aryOrderCartList[0]["OC_OPT_ATTR".$kk]){
				$strCartOptAttrVal .= "/".$aryOrderCartList[0]["OC_OPT_ATTR".$kk];
			}
		}
		$strCartOptAttrVal = SUBSTR($strCartOptAttrVal,1);

		## 상품배송정보
		$strCartDeliveryTypeName = "";
		switch($aryOrderCartList[0]['OC_P_BAESONG_TYPE']){
			case "1":
				$strCartDeliveryTypeName	= "기본배송";
			break;
			case "2":
				$strCartDeliveryTypeName	= "무료배송";
			break;
			case "3":
				$strCartDeliveryTypeName	= "고정배송비";
				$strCartDeliveryTypeName   .= "(".getCurMark($S_ST_CUR).getFormatPrice($aryOrderCartList[0]['OC_DELIVERY_CUR_PRICE'],2).getCurMark2($S_ST_CUR).")";
			break;
			case "4":
				$strCartDeliveryTypeName	= "수량별배송";
			break;
			case "5":
				$strCartDeliveryTypeName	 = "착불";
				$strCartDeliveryTypeName	.= "(".getCurMark($S_ST_CUR).getFormatPrice($aryOrderCartList[0]['OC_DELIVERY_CUR_PRICE'],2).getCurMark2($S_ST_CUR).")";
			break;
		}

		## 배송비지불방법
		$strCartDeliveryPayMthName	= "";
		if ($aryOrderCartList[0]['OC_DELIVERY_TYPE'] == "1") $strCartDeliveryPayMthName = "(주문시결제)";
		else if ($aryOrderCartList[0]['OC_DELIVERY_TYPE'] == "2") $strCartDeliveryPayMthName = "(착불)";

		## 구매상태
		$strCartOrderCartStatus = "";
		if ($aryOrderCartList[0]['OC_ORDER_STATUS'] == "E") $strCartOrderCartStatus = $LNG_TRANS_CHAR["OW00139"];
		else {
			$strCartOrderCartStatus = $S_ARY_SETTLE_ORDER_STATUS[$aryOrderCartList[0]['OC_ORDER_STATUS']];
		}
	?>
	<tr>
		<td><?=$index?></td>
		<td><?=$row['O_KEY']?></td>
		<td><?=$row['O_REG_DT']?></td>
		<td><?=$row['M_ID']?><?=(!$row['M_ID'])?"(".$row['M_NAME'].")":"";?></td>
		<td><?=$row['O_J_NAME']?></td>
		<td><?=$row['O_J_PHONE']?></td>
		<td><?=$row['O_J_HP']?></td>
		<td><?=$row['O_J_MAIL']?></td>
		<td><?=$row['O_B_NAME']?></td>
		<td><?=$row['O_B_PHONE']?></td>
		<td><?=$row['O_B_HP']?></td>
		<td><?=$row['O_B_MAIL']?></td>
		<td><?=$row['O_B_ZIP']?></td>
		<td><?=$row['O_B_ADDR1']?> <?=$row['O_B_ADDR2']?></td>
		<td><?=$row['O_B_MEMO']?></td>

		<?if ($S_MALL_TYPE != "R"){?>
		<td><?=$aryOrderCartShopList[$aryOrderCartList[0][P_SHOP_NO]]['ST_NAME']?></td>
		<?}?>

		<td style='mso-number-format:"\@";'><?=$aryOrderCartList[0]['P_CODE']?></td>
		<td><?=$aryOrderCartList[0]['OC_P_NAME']?></td>
		<td><?=$strCartOptAttrVal?></td>
		<td>
			<?if (is_array($aryProdCartAddOptList)){
				for($k=0;$k<sizeof($aryProdCartAddOptList);$k++){?>
				<?=$aryProdCartAddOptList[$k][OCA_OPT_NM]?> * <?=$aryProdCartAddOptList[$k][OCA_OPT_QTY]?>
			<?}}?>
		</td>
		<td><?=getFormatPrice($aryOrderCartList[0]['OC_STOCK_CUR_PRICE'], 2)?></td>
		<td><?=getFormatPrice($aryOrderCartList[0]['OC_CUR_PRICE'], 2)?></td>
		<td><?=getFormatPrice($aryOrderCartList[0]['OC_OPT_ADD_CUR_PRICE'], 2)?></td>

		<td><?=$aryOrderCartList[0]['OC_QTY']?></td>
		<td><?=$strCartDeliveryTypeName . $strCartDeliveryPayMthName?></td>
		<td><?=$aryDeliveryComAll[$aryOrderCartList[0]['OC_DELIVERY_COM']]?></td>
		<td style='mso-number-format:"\@";' ><?=$aryOrderCartList[0]['OC_DELIVERY_NUM']?></td>
		<?if ($S_MALL_TYPE != "R"){?>
		<td><?=getFormatPrice($aryOrderCartShopList[$aryOrderCartList[0][P_SHOP_NO]]['SO_TOT_DELIVERY_CUR_PRICE'],2)?></td>
		<?}?>

		<td><?=$S_ARY_DELIVERY_STATUS[$aryOrderCartList[0]['OC_DELIVERY_STATUS']]?></td>
		<td><?=$aryOrderCartList[0]['OC_DELIVERY_ST_DT']?></td>
		<td><?=$aryOrderCartList[0]['OC_DELIVERY_END_DT']?></td>
		<td><?=$strCartOrderCartStatus?></td>

		<td><?=$row['O_SHIPPING_NO2'];?>
		<td><?=$row['O_CEL_MEMO']?></td>
		<td><?=$row['O_CEL_STATUS']?></td>
	</tr>
	<?
		if (is_array($aryOrderCartList)){
			for($j=1;$j<sizeof($aryOrderCartList);$j++){

				## 추가상품정보
				$aryProdCartAddOptList  = "";
				if ($aryOrderCartList[$j]["OC_OPT_ADD_CUR_PRICE"] >= 0)
				{
					$param				= "";
					$param['OC_NO']		= $aryOrderCartList[$j]["OC_NO"];
					$aryProdCartAddOptList = $shopOrderMgr->getOrderCartAddList($db,"OP_ARYTOTAL",$param);
				}

				## 상품옵션정보
				$strCartOptAttrVal = "";
				for($kk=1;$kk<=10;$kk++){
					if ($aryOrderCartList[$j]["OC_OPT_ATTR".$kk]){
						$strCartOptAttrVal .= "/".$aryOrderCartList[$j]["OC_OPT_ATTR".$kk];
					}
				}
				$strCartOptAttrVal = SUBSTR($strCartOptAttrVal,1);

				## 상품배송정보
				$strCartDeliveryTypeName = "";
				switch($aryOrderCartList[$j]['OC_P_BAESONG_TYPE']){
					case "1":
						$strCartDeliveryTypeName	= "기본배송";
					break;
					case "2":
						$strCartDeliveryTypeName	= "무료배송";
					break;
					case "3":
						$strCartDeliveryTypeName	= "고정배송비";
						$strCartDeliveryTypeName   .= "(".getCurMark($S_ST_CUR).getFormatPrice($aryOrderCartList[$j]['OC_DELIVERY_CUR_PRICE'],2).getCurMark2($S_ST_CUR).")";
					break;
					case "4":
						$strCartDeliveryTypeName	= "수량별배송";
					break;
					case "5":
						$strCartDeliveryTypeName	 = "착불";
						$strCartDeliveryTypeName	.= "(".getCurMark($S_ST_CUR).getFormatPrice($aryOrderCartList[$j]['OC_DELIVERY_CUR_PRICE'],2).getCurMark2($S_ST_CUR).")";
					break;
				}

				## 배송비지불방법
				$strCartDeliveryPayMthName	= "";
				if ($aryOrderCartList[$j]['OC_BAESONG_TYPE'] == "1") $strCartDeliveryPayMthName = "(주문시결제)";
				else if ($aryOrderCartList[$j]['OC_BAESONG_TYPE'] == "2") $strCartDeliveryPayMthName = "(착불)";

				## 구매상태
				$strCartOrderCartStatus = "";
				if ($aryOrderCartList[$j]['OC_ORDER_STATUS'] == "E") $strCartOrderCartStatus = $LNG_TRANS_CHAR["OW00139"];
				else {
					$strCartOrderCartStatus = $S_ARY_SETTLE_ORDER_STATUS[$aryOrderCartList[$j]['OC_ORDER_STATUS']];
				}

				?>
	<tr>
		<td><?=$index?></td>
		<td><?=$row['O_KEY']?></td>
		<td><?=$row['O_REG_DT']?></td>
		<td><?=$row['M_ID']?><?=(!$row['M_ID'])?"(".$row['M_NAME'].")":"";?></td>
		<td><?=$row['O_J_NAME']?></td>
		<td><?=$row['O_J_PHONE']?></td>
		<td><?=$row['O_J_HP']?></td>
		<td><?=$row['O_J_MAIL']?></td>
		<td><?=$row['O_B_NAME']?></td>
		<td><?=$row['O_B_PHONE']?></td>
		<td><?=$row['O_B_HP']?></td>
		<td><?=$row['O_B_MAIL']?></td>
		<td><?=$row['O_B_ZIP']?></td>
		<td><?=$row['O_B_ADDR1']?> <?=$row['O_B_ADDR2']?></td>
		<td><?=$row['O_B_MEMO']?></td>

		<?if ($S_MALL_TYPE != "R"){?>
		<td><?=$aryOrderCartShopList[$aryOrderCartList[$j][P_SHOP_NO]]['ST_NAME']?></td>
		<?}?>
		<td style='mso-number-format:"\@";'><?=$aryOrderCartList[$j]['P_CODE']?></td>
		<td><?=$aryOrderCartList[$j]['OC_P_NAME']?></td>
		<td><?=$strCartOptAttrVal?></td>
		<td>
			<?if (is_array($aryProdCartAddOptList)){
				for($k=0;$k<sizeof($aryProdCartAddOptList);$k++){?>
				<?=$aryProdCartAddOptList[$k][OCA_OPT_NM]?> * <?=$aryProdCartAddOptList[$k][OCA_OPT_QTY]?>
			<?}}?>
		</td>
		<td><?=getFormatPrice($aryOrderCartList[$j]['OC_STOCK_CUR_PRICE'], 2)?></td>
		<td><?=getFormatPrice($aryOrderCartList[$j]['OC_CUR_PRICE'], 2)?></td>
		<td><?=getFormatPrice($aryOrderCartList[$j]['OC_OPT_ADD_CUR_PRICE'], 2)?></td>
		<td><?=$aryOrderCartList[$j]['OC_QTY']?></td>
		<td><?=$strCartDeliveryTypeName?></td>
		<td><?=$aryDeliveryComAll[$aryOrderCartList[$j]['OC_DELIVERY_COM']]?></td>
		<td style='mso-number-format:"\@";' ><?=$aryOrderCartList[$j]['OC_DELIVERY_NUM']?></td>
		<?if ($S_MALL_TYPE != "R"){?>
		<td><?=getFormatPrice($aryOrderCartShopList[$aryOrderCartList[$j][P_SHOP_NO]]['SO_TOT_DELIVERY_CUR_PRICE'],2)?></td>
		<?}?>

		<td><?=$S_ARY_DELIVERY_STATUS[$aryOrderCartList[$j]['OC_DELIVERY_STATUS']]?></td>
		<td><?=$aryOrderCartList[$j]['OC_DELIVERY_ST_DT']?></td>
		<td><?=$aryOrderCartList[$j]['OC_DELIVERY_END_DT']?></td>
		<td><?=$strCartOrderCartStatus?></td>

		<td><?=$row['O_SHIPPING_NO2'];?>
		<td><?=$row['O_CEL_MEMO']?></td>
		<td><?=$row['O_CEL_STATUS']?></td>
	</tr>
				<?
			}
		}
	?>
	<?$index++;?>
<?endwhile;?>
</table>
