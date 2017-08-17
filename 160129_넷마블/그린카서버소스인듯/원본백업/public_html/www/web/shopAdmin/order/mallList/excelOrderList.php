
<table border="1">
	<tr>
		<th><?=getEuckrString($LNG_TRANS_CHAR["CW00009"]) //번호?></th>
		<th><?=getEuckrString($LNG_TRANS_CHAR["OW00002"]) //주문번호?></th>
		<th><?=getEuckrString($LNG_TRANS_CHAR["OW00074"]) //주문일시?></th>
		<th><?=getEuckrString("회원ID")?></th>
		<?if($S_FIX_MEMBER_CATE_USE_YN == "Y"){?>
		<th><?=getEuckrString("소속1")?></th>
		<th><?=getEuckrString("소속2")?></th>
		<?}?>
		<th><?=getEuckrString("주문자")?></th>
		<th><?=getEuckrString("주문자연락처")?></th>
		<th><?=getEuckrString("주문자핸드폰")?></th>
		<th><?=getEuckrString("주문자메일")?></th>
		<th><?=getEuckrString("받는사람명")?></th>
		<th><?=getEuckrString("받는사람연락처")?></th>
		<th><?=getEuckrString("받는사람핸드폰")?></th>
		<th><?=getEuckrString("받는사람메일")?></th>
		<th><?=getEuckrString("받는사람주소")?></th>
		<th><?=getEuckrString("받는사람메모")?></th>

		<th><?=getEuckrString("입점사명")?></th>
		<th><?=getEuckrString("상품명")?></th>
		<th><?=getEuckrString("상품옵션")?></th>
		<th><?=getEuckrString("추가상품")?></th>
		<th><?=getEuckrString("입고가격")?></th>
		<th><?=getEuckrString("판매가격")?></th>
		<th><?=getEuckrString("상품수량")?></th>
		<th><?=getEuckrString("상품배송방법")?></th>
		<th><?=getEuckrString("배송비")?></th>
		<th><?=getEuckrString("배송회사")?></th>
		<th><?=getEuckrString("배송번호")?></th>
		<th><?=getEuckrString("배송상태")?></th>
		<th><?=getEuckrString("구매상태")?></th>

		<!--<th colspan="10"><?=getEuckrString("상품정보")?></th>//-->
		<th><?=getEuckrString("사용포인트")?></th>
		<th><?=getEuckrString("총주문금액")?></th>
		<th><?=getEuckrString("총배송비")?></th>
		<th><?=getEuckrString("총결제금액")?></th>
		<th><?=getEuckrString("총적립액")?></th>
		<th><?=getEuckrString("결제방법")?></th>
		<th><?=getEuckrString("결제상태")?></th>
		<th><?=getEuckrString("결제승인번호")?></th>
		<th><?=getEuckrString("결제승인일자")?></th>
		<th><?=getEuckrString("무통장입금자명")?></th>
		<th><?=getEuckrString("무통장입금은행")?></th>
		<th><?=getEuckrString("무통장입금계좌번호")?></th>
		<th><?=getEuckrString("가상계좌입금마감시간")?></th>	
		<th><?=getEuckrString("환불은행")?></th>
		<th><?=getEuckrString("환불계좌번호")?></th>
		<th><?=getEuckrString("환불예금주")?></th>
		<th><?=getEuckrString("취소사유")?></th>
		<th><?=getEuckrString("취소처리여부")?></th>
	</tr>
	<?
	$index = 1;
	while($row = mysql_fetch_array($orderListResult)): // 주문 리스트 
		$strOrderSettle = $strOrderBankName = $strOrderBank = $strOrderBankAcc = "";
		
		/* 회원 소속 */
		$strMemberCateList = $strMemberCateList0 = $strMemberCateList1 = "";
		if ($S_FIX_MEMBER_CATE_USE_YN  == "Y"){

			$param								= "";
			$param['M_NO']						= $row['M_NO'];
			$param['ORDER_BY']					= "C.C_CODE ASC";
			$param['MEMBER_CATE_MGR_JOIN']		= "Y";
			$aryMemberCateList					= $memberCateMgr->getMemberCateJoinListEx($db, "OP_ARYTOTAL", $param);
			
			if (is_array($aryMemberCateList)){
				foreach($aryMemberCateList as $key => $memberCateRow){
					//if ($key > 0) continue;
					$intMemberCateLevel	= strlen($memberCateRow['C_CODE']) / 3;
					$strMemberCateList	= $strMemberCateName_1 = $strMemberCateName_2 = $strMemberCateName_3 = "";
					for($i = 1; $i<=3; $i++):
						if($intMemberCateLevel >= $i):
							$strCateCode		 = substr($memberCateRow['C_CODE'], 0, $i*3);
							${"strMemberCateName_".$i} = $MEMBER_CATE[$strCateCode]['C_NAME'];
						endif;
					endfor;

					$strMemberCateList .= $strMemberCateName_1;
					$strMemberCateList .= ($strMemberCateName_2)? " > {$strMemberCateName_2}":"";
					$strMemberCateList .= ($strMemberCateName_3)? " > {$strMemberCateName_3}":"";
					${"strMemberCateList".$key} = $strMemberCateList;
				}
			}				
		}
		/* 회원 소속 */


		/* 결제방법 */
		$strOrderSettle = $S_ARY_SETTLE_TYPE[$row['O_SETTLE']];		
		
		/* 무통장 입금 정보 */
		$strOrderBankName	= $row['O_BANK_NAME'];
		$strOrderBank		= $aryBank1[$row['O_BANK']];
		$strOrderBankAcc	= $arySiteSettleBank[$row['O_BANK_ACC']];
		
		/* 가상계좌 입금 */
		if ($row['O_SETTLE'] == "T"){
			$strOrderBank		= $aryBank2[$row['O_BANK']];
			$strOrderBankAcc	= $row['O_BANK_ACC'];
		}
				
		/* 주문된 상품 수 */
		$param								= "";
		$param['o_no']						= $row["O_NO"];
		if (in_array($strSearchOrderStatus,array("E","C","R","T"))){
			$param["in_soc_status"] = "'".$strSearchOrderStatus."'";
			if ($strSearchOrderStatus == "R"){
				$param["in_soc_status"] = "'R','S'";
			}
		}
		$param['p_shop_no']					= $a_admin_shop_no;
		$intOrderRowSpanCnt					= $orderMgr->getOrderCartCnt($db,$param);
		$strOrderRosSpanText				= ($intOrderRowSpanCnt > 1) ? "rowpsan=\"".$intOrderRowSpanCnt."\"":"";
		/* SHOP 정보 리스트 */
		$param								= "";
		$param['searchField']				= $_REQUEST['searchField'];
		$param['searchKey']					= $_REQUEST['searchKey'];
		$param['searchDeliveryStatus']		= $_REQUEST['searchDeliveryStatus'];
		$param['searchDeliveryCom']			= $_REQUEST['searchDeliveryCom'];
		$param['searchShopNo']				= $strOrderInfoShopNo;
		$param['o_no']						= $row['O_NO'];
		$param['order_by']					= "SO.SH_NO ASC";
		$intShopOrderListTotal				= $orderMgr->getShopOrderListEx($db, "OP_COUNT", $param);
		$aryShopOrderList					= $orderMgr->getShopOrderListEx($db, "OP_ARYTOTAL", $param);
		
		if($intShopOrderListTotal <= 0 ) { continue; } /* 2013.06.28 kim hee sung 입점사에서 상품 구매 정보가 없으면 표시 안함(검색에서 유용하게 사용중..) */
		
		$strShopName			= $aryShopOrderList[0]['ST_NAME'];
		if (!$strShopName) $strShopName = "본사";

		$intShopDeliveryPrice	= $aryShopOrderList[0]['SO_TOT_DELIVERY_CUR_PRICE'];
		$strShopDeliveryNum		= $aryShopOrderList[0]['SO_DELIVERY_NUM'];
		$strShopDeliveryCom		= $aryShopOrderList[0]['SO_DELIVERY_COM'];
		
		/* SHOP CART 리스트 */
		$param								= "";
		$param['o_no']						= $row['O_NO'];
		$param['p_shop_no']					= $aryShopOrderList[0]['SH_NO'];
		$param['order_by']					= "OC.OC_NO ASC";
		if (in_array($strSearchOrderStatus,array("E","C","R","T"))){
			$param["in_soc_status"] = "'".$strSearchOrderStatus."'";
			if ($strSearchOrderStatus == "R"){
				$param["in_soc_status"] = "'R','S'";
			}
		}
		$intShopOrderCartListTotal			= $orderMgr->getOrderCartListEx($db, "OP_COUNT", $param);
		$aryShopOrderCartList				= $orderMgr->getOrderCartListEx($db, "OP_ARYTOTAL", $param);
		
		if($intShopOrderCartListTotal <= 0 ) { continue; } /* 2013.06.28 kim hee sung 입점사에서 상품 구매 정보가 없으면 표시 안함(검색에서 유용하게 사용중..) */

		/* SHOP CART별 구매상태 */
		$strShopOrderCartStatus1			= $aryShopOrderCartList[0]['SOC_STATUS'];
		$strShopOrderCartStatus2			= $aryShopOrderCartList[0]['SOC_'.$strShopOrderCartStatus1.'_STATUS'];

		$strShopOrderCartStatus				= $S_ARY_SETTLE_ORDER_STATUS[$strShopOrderCartStatus1.$strShopOrderCartStatus2];
		if ($strShopOrderCartStatus1.$strShopOrderCartStatus2 == "E") $strShopOrderCartStatus = "구매완료";
		
		$strDeliveryTypeName = $strCartOptAttrVal = "";
		if ($aryShopOrderCartList[0]['P_BAESONG_TYPE'] == "2") $strDeliveryTypeName = "무료배송";
		else if ($aryShopOrderCartList[0]['P_BAESONG_TYPE'] == "3") $strDeliveryTypeName = "배송비고정";
		else if ($aryShopOrderCartList[0]['P_BAESONG_TYPE'] == "4") $strDeliveryTypeName = "수령별배송";
		else if ($aryShopOrderCartList[0]['P_BAESONG_TYPE'] == "5") $strDeliveryTypeName = "착불";
		else $strDeliveryTypeName = "기본배송";
		
		$param = "";
		$param["oc_no"] = $aryShopOrderCartList[0]['OC_NO'];
		$aryProdCartAddOptList = $orderMgr->getOrderCartAddList($db,$param);
		
		$strCartOptAttrVal = "";
		for($kk=1;$kk<=10;$kk++){
			if ($aryShopOrderCartList[0]["OC_OPT_ATTR".$kk]){
				$strCartOptAttrVal .= "/".$aryShopOrderCartList[0]["OC_OPT_ATTR".$kk];
			}
		}
		$strCartOptAttrVal = SUBSTR($strCartOptAttrVal,1);
	?>
	<tr>
		<td><?=getEuckrString($index)?></td>
		<td><?=getEuckrString($row['O_KEY'])?></td>
		<td><?=getEuckrString($row['O_REG_DT'])?></td>
		<td><?=getEuckrString($row['M_ID'])?><?=(!$row['M_ID'])?"(".getEuckrString($row['M_NAME']).")":"";?></td>
		<?if($S_FIX_MEMBER_CATE_USE_YN == "Y"){?>
		<td><?=getEuckrString($strMemberCateList0)?></td>
		<td><?=getEuckrString($strMemberCateList1)?></td>
		<?}?>
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

		<td><?=getEuckrString($strShopName)?></td>
		<td><?=getEuckrString($aryShopOrderCartList[0]['P_NAME'])?></td>
		<td><?=getEuckrString($strCartOptAttrVal)?></td>
		<td>
			<?if (is_array($aryProdCartAddOptList)){
				for($k=0;$k<sizeof($aryProdCartAddOptList);$k++){?>
				<?=getEuckrString($LNG_TRANS_CHAR["OW00046"]) //추가선택?> : <?=getEuckrString($aryProdCartAddOptList[$k][OCA_OPT_NM])?><br>
			<?}}?>
		</td>
		<td><?=getFormatPrice($aryShopOrderCartList[0]['OC_STOCK_CUR_PRICE'], 2)?></td>
		<td><?=getFormatPrice($aryShopOrderCartList[0]['OC_CUR_PRICE'], 2)?></td>
		<td><?=$aryShopOrderCartList[0]['OC_QTY']?></td>
		<td><?=getEuckrString($strDeliveryTypeName)?></td>
		<td><?=getFormatPrice($intShopDeliveryPrice,2)?></td>
		<td><?=getEuckrString($aryDeliveryComAll[$strShopDeliveryCom])?></td>
		<td style='mso-number-format:"\@";' ><?=getEuckrString($strShopDeliveryNum)?></td>
		<td><?=getEuckrString($S_ARY_DELIVERY_STATUS[$aryShopOrderList[0]['SO_DELIVERY_STATUS']])?></td>
		<td><?=getEuckrString($strShopOrderCartStatus)?></td>

		<td><?=getEuckrString(getFormatPrice($row['O_USE_POINT'],2))?></td>
		<td><?=getEuckrString(getFormatPrice($row['O_TOT_PRICE'],2))?></td>
		<td><?=getEuckrString(getFormatPrice($row['O_TOT_DELIVERY_PRICE'],2))?></td>
		<td><?=getEuckrString(getFormatPrice($row['O_TOT_SPRICE'],2))?></td>
		<td><?=getEuckrString(getFormatPrice($row['O_TOT_POINT'],2))?></td>
		<td><?=getEuckrString($strOrderSettle)?></td>
		<td><?=getEuckrString($S_ARY_SETTLE_STATUS[$row['O_STATUS']])?></td>
		<td style='mso-number-format:"\@";' ><?=getEuckrString(sprintf("%s", $row['O_APPR_NO']))?></td>
		<td><?=getEuckrString($row['O_APPR_DT'])?></td>
		<td><?=getEuckrString($strOrderBankName)?></td>
		<td><?=getEuckrString($strOrderBank)?></td>
		<td style='mso-number-format:"\@";'><?=getEuckrString($strOrderBankAcc)?></td>
		<td style='mso-number-format:"\@";'><?=getEuckrString($row['O_BANK_VALID_DT'])?></td>
		<td><?=getEuckrString($aryBank2["BK".$row['O_RETURN_BANK']])?></td>
		<td><?=getEuckrString($row['O_RETURN_ACC'])?></td>
		<td><?=getEuckrString($row['O_RETURN_NAME'])?></td>
		<td><?=getEuckrString($row['O_CEL_MEMO'])?></td>
		<td><?=getEuckrString($row['O_CEL_STATUS'])?></td>
	</tr>
	<?
		if (is_array($aryShopOrderCartList)){
			for($j=1;$j<sizeof($aryShopOrderCartList);$j++){
				
				$strShopOrderCartStatus1			= $aryShopOrderCartList[$j]['SOC_STATUS'];
				$strShopOrderCartStatus2			= $aryShopOrderCartList[$j]['SOC_'.$strShopOrderCartStatus1.'_STATUS'];

				$strShopOrderCartStatus				= $S_ARY_SETTLE_ORDER_STATUS[$strShopOrderCartStatus1.$strShopOrderCartStatus2];
				if ($strShopOrderCartStatus1.$strShopOrderCartStatus2 == "E") $strShopOrderCartStatus = "구매완료";

				$strDeliveryTypeName = "";
				if ($aryShopOrderCartList[$j]['P_BAESONG_TYPE'] == "2") $strDeliveryTypeName = "무료배송";
				else if ($aryShopOrderCartList[$j]['P_BAESONG_TYPE'] == "3") $strDeliveryTypeName = "배송비고정";
				else if ($aryShopOrderCartList[$j]['P_BAESONG_TYPE'] == "4") $strDeliveryTypeName = "수령별배송";
				else if ($aryShopOrderCartList[$j]['P_BAESONG_TYPE'] == "5") $strDeliveryTypeName = "착불";
				else $strDeliveryTypeName = "기본배송";

				$param = "";
				$param["oc_no"] = $aryShopOrderCartList[$j]['OC_NO'];
				$aryProdCartAddOptList = $orderMgr->getOrderCartAddList($db,$param);
				

				$strCartOptAttrVal = "";
				for($kk=1;$kk<=10;$kk++){
					if ($aryShopOrderCartList[$j]["OC_OPT_ATTR".$kk]){
						$strCartOptAttrVal .= "/".$aryShopOrderCartList[$j]["OC_OPT_ATTR".$kk];
					}
				}
				$strCartOptAttrVal = SUBSTR($strCartOptAttrVal,1);
				
				

				?>
	<tr>
		<td><?=getEuckrString($index)?></td>
		<td><?=getEuckrString($row['O_KEY'])?></td>
		<td><?=getEuckrString($row['O_REG_DT'])?></td>
		<td><?=getEuckrString($row['M_ID'])?><?=(!$row['M_ID'])?"(".getEuckrString($row['M_NAME']).")":"";?></td>
		<?if($S_FIX_MEMBER_CATE_USE_YN == "Y"){?>
		<td><?=getEuckrString($strMemberCateList0)?></td>
		<td><?=getEuckrString($strMemberCateList1)?></td>
		<?}?>
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

		<td><?=getEuckrString($strShopName)?></td>

		<td><?=getEuckrString($aryShopOrderCartList[$j]['P_NAME'])?></td>
		<td><?=getEuckrString($strCartOptAttrVal)?></td>
		<td>
			<?if (is_array($aryProdCartAddOptList)){
				for($k=0;$k<sizeof($aryProdCartAddOptList);$k++){?>
				<?=getEuckrString($LNG_TRANS_CHAR["OW00046"]) //추가선택?> : <?=getEuckrString($aryProdCartAddOptList[$k][OCA_OPT_NM])?><br>
			<?}}?>	
		</td>
		<td><?=getFormatPrice($aryShopOrderCartList[$j]['OC_STOCK_CUR_PRICE'], 2)?></td>
		<td><?=getFormatPrice($aryShopOrderCartList[$j]['OC_CUR_PRICE'], 2)?></td>
		<td><?=$aryShopOrderCartList[$j]['OC_QTY']?></td>
		<td><?=getEuckrString($strDeliveryTypeName)?></td>
		<td><?=getFormatPrice($intShopDeliveryPrice,2)?></td>
		<td><?=getEuckrString($aryDeliveryComAll[$strShopDeliveryCom])?></td>
		<td style='mso-number-format:"\@";' ><?=getEuckrString($strShopDeliveryNum)?></td>
		<td><?=getEuckrString($S_ARY_DELIVERY_STATUS[$aryShopOrderList[0]['SO_DELIVERY_STATUS']])?></td>
		<td><?=getEuckrString($strShopOrderCartStatus)?></td>
		<td><?=getEuckrString(getFormatPrice($row['O_USE_POINT'],2))?></td>
		<td><?=getEuckrString(getFormatPrice($row['O_TOT_PRICE'],2))?></td>
		<td><?=getEuckrString(getFormatPrice($row['O_TOT_DELIVERY_PRICE'],2))?></td>
		<td><?=getEuckrString(getFormatPrice($row['O_TOT_SPRICE'],2))?></td>
		<td><?=getEuckrString(getFormatPrice($row['O_TOT_POINT'],2))?></td>
		<td><?=getEuckrString($strOrderSettle)?></td>
		<td><?=getEuckrString($S_ARY_SETTLE_STATUS[$row['O_STATUS']])?></td>
		<td style='mso-number-format:"\@";' ><?=getEuckrString(sprintf("%s", $row['O_APPR_NO']))?></td>
		<td><?=getEuckrString($row['O_APPR_DT'])?></td>
		<td><?=getEuckrString($strOrderBankName)?></td>
		<td><?=getEuckrString($strOrderBank)?></td>
		<td style='mso-number-format:"\@";'><?=getEuckrString($strOrderBankAcc)?></td>
		<td style='mso-number-format:"\@";'><?=getEuckrString($row['O_BANK_VALID_DT'])?></td>
		<td><?=getEuckrString($aryBank2["BK".$row['O_RETURN_BANK']])?></td>
		<td><?=getEuckrString($row['O_RETURN_ACC'])?></td>
		<td><?=getEuckrString($row['O_RETURN_NAME'])?></td>
		<td><?=getEuckrString($row['O_CEL_MEMO'])?></td>
		<td><?=getEuckrString($row['O_CEL_STATUS'])?></td>
	</tr>

				<?
			}
		}
		
		$aryShopOrderCartList = "";
		if (is_array($aryShopOrderList)){
			for($i=1;$i<sizeof($aryShopOrderList);$i++){

				$strShopName			= $aryShopOrderList[$i]['ST_NAME'];
				if (!$strShopName) $strShopName = "본사";

				$intShopDeliveryPrice	= $aryShopOrderList[$i]['SO_TOT_DELIVERY_CUR_PRICE'];
				$strShopDeliveryNum		= $aryShopOrderList[$i]['SO_DELIVERY_NUM'];
				$strShopDeliveryCom		= $aryShopOrderList[$i]['SO_DELIVERY_COM'];

				/* SHOP CART 리스트 */
				$param								= "";
				$param['o_no']						= $row['O_NO'];
				$param['p_shop_no']					= $aryShopOrderList[$i]['SH_NO'];
				$param['order_by']					= "OC.OC_NO ASC";
				if (in_array($strSearchOrderStatus,array("E","C","R","T"))){
					$param["in_soc_status"] = "'".$strSearchOrderStatus."'";
					if ($strSearchOrderStatus == "R"){
						$param["in_soc_status"] = "'R','S'";
					}
				}
				$intShopOrderCartListTotal			= $orderMgr->getOrderCartListEx($db, "OP_COUNT", $param);
				$aryShopOrderCartList				= $orderMgr->getOrderCartListEx($db, "OP_ARYTOTAL", $param);

				if (is_array($aryShopOrderCartList)){

					$strShopOrderCartStatus1			= $aryShopOrderCartList[0]['SOC_STATUS'];
					$strShopOrderCartStatus2			= $aryShopOrderCartList[0]['SOC_'.$strShopOrderCartStatus1.'_STATUS'];

					$strShopOrderCartStatus				= $S_ARY_SETTLE_ORDER_STATUS[$strShopOrderCartStatus1.$strShopOrderCartStatus2];
					if ($strShopOrderCartStatus1.$strShopOrderCartStatus2 == "E") $strShopOrderCartStatus = "구매완료";

					$strDeliveryTypeName = "";
					if ($aryShopOrderCartList[0]['P_BAESONG_TYPE'] == "2") $strDeliveryTypeName = "무료배송";
					else if ($aryShopOrderCartList[0]['P_BAESONG_TYPE'] == "3") $strDeliveryTypeName = "배송비고정";
					else if ($aryShopOrderCartList[0]['P_BAESONG_TYPE'] == "4") $strDeliveryTypeName = "수령별배송";
					else if ($aryShopOrderCartList[0]['P_BAESONG_TYPE'] == "5") $strDeliveryTypeName = "착불";
					else $strDeliveryTypeName = "기본배송";

					$param = "";
					$param["oc_no"] = $aryShopOrderCartList[0]['OC_NO'];
					$aryProdCartAddOptList = $orderMgr->getOrderCartAddList($db,$param);
					

					$strCartOptAttrVal = "";
					for($kk=1;$kk<=10;$kk++){
						if ($aryShopOrderCartList[0]["OC_OPT_ATTR".$kk]){
							$strCartOptAttrVal .= "/".$aryShopOrderCartList[0]["OC_OPT_ATTR".$kk];
						}
					}
					$strCartOptAttrVal = SUBSTR($strCartOptAttrVal,1);


				?>
	<tr>
		<td><?=getEuckrString($index)?></td>
		<td><?=getEuckrString($row['O_KEY'])?></td>
		<td><?=getEuckrString($row['O_REG_DT'])?></td>
		<td><?=getEuckrString($row['M_ID'])?><?=(!$row['M_ID'])?"(".getEuckrString($row['M_NAME']).")":"";?></td>
		<?if($S_FIX_MEMBER_CATE_USE_YN == "Y"){?>
		<td><?=getEuckrString($strMemberCateList0)?></td>
		<td><?=getEuckrString($strMemberCateList1)?></td>
		<?}?>
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

		<td><?=getEuckrString($strShopName)?></td>
		<td><?=getEuckrString($aryShopOrderCartList[0]['P_NAME'])?></td>
		<td><?=getEuckrString($strCartOptAttrVal)?></td>
		<td>
			<?if (is_array($aryProdCartAddOptList)){
				for($k=0;$k<sizeof($aryProdCartAddOptList);$k++){?>
				<?=getEuckrString($LNG_TRANS_CHAR["OW00046"]) //추가선택?> : <?=getEuckrString($aryProdCartAddOptList[$k][OCA_OPT_NM])?><br>
			<?}}?>
		</td>
		<td><?=getFormatPrice($aryShopOrderCartList[0]['OC_STOCK_CUR_PRICE'], 2)?></td>
		<td><?=getFormatPrice($aryShopOrderCartList[0]['OC_CUR_PRICE'], 2)?></td>
		<td><?=$aryShopOrderCartList[0]['OC_QTY']?></td>
		<td><?=getEuckrString($strDeliveryTypeName)?></td>
		<td><?=getFormatPrice($intShopDeliveryPrice,2)?></td>
		<td><?=getEuckrString($aryDeliveryComAll[$strShopDeliveryCom])?></td>
		<td style='mso-number-format:"\@";' ><?=getEuckrString($strShopDeliveryNum)?></td>
		<td><?=getEuckrString($S_ARY_DELIVERY_STATUS[$aryShopOrderList[$i]['SO_DELIVERY_STATUS']])?></td>
		<td><?=getEuckrString($strShopOrderCartStatus)?></td>

		<td><?=getEuckrString(getFormatPrice($row['O_USE_POINT'],2))?></td>
		<td><?=getEuckrString(getFormatPrice($row['O_TOT_PRICE'],2))?></td>
		<td><?=getEuckrString(getFormatPrice($row['O_TOT_DELIVERY_PRICE'],2))?></td>
		<td><?=getEuckrString(getFormatPrice($row['O_TOT_SPRICE'],2))?></td>
		<td><?=getEuckrString(getFormatPrice($row['O_TOT_POINT'],2))?></td>
		<td><?=getEuckrString($strOrderSettle)?></td>
		<td><?=getEuckrString($S_ARY_SETTLE_STATUS[$row['O_STATUS']])?></td>
		<td style='mso-number-format:"\@";' ><?=getEuckrString(sprintf("%s", $row['O_APPR_NO']))?></td>
		<td><?=getEuckrString($row['O_APPR_DT'])?></td>
		<td><?=getEuckrString($strOrderBankName)?></td>
		<td><?=getEuckrString($strOrderBank)?></td>
		<td style='mso-number-format:"\@";'><?=getEuckrString($strOrderBankAcc)?></td>
		<td style='mso-number-format:"\@";'><?=getEuckrString($row['O_BANK_VALID_DT'])?></td>
		<td><?=getEuckrString($aryBank2["BK".$row['O_RETURN_BANK']])?></td>
		<td><?=getEuckrString($row['O_RETURN_ACC'])?></td>
		<td><?=getEuckrString($row['O_RETURN_NAME'])?></td>
		<td><?=getEuckrString($row['O_CEL_MEMO'])?></td>
		<td><?=getEuckrString($row['O_CEL_STATUS'])?></td>
	</tr>
				<?

						for($j=1;$j<sizeof($aryShopOrderCartList);$j++){

							$strShopOrderCartStatus1			= $aryShopOrderCartList[$j]['SOC_STATUS'];
							$strShopOrderCartStatus2			= $aryShopOrderCartList[$j]['SOC_'.$strShopOrderCartStatus1.'_STATUS'];

							$strShopOrderCartStatus				= $S_ARY_SETTLE_ORDER_STATUS[$strShopOrderCartStatus1.$strShopOrderCartStatus2];
							if ($strShopOrderCartStatus1.$strShopOrderCartStatus2 == "E") $strShopOrderCartStatus = "구매완료";

							$strDeliveryTypeName = "";
							if ($aryShopOrderCartList[$j]['P_BAESONG_TYPE'] == "2") $strDeliveryTypeName = "무료배송";
							else if ($aryShopOrderCartList[$j]['P_BAESONG_TYPE'] == "3") $strDeliveryTypeName = "배송비고정";
							else if ($aryShopOrderCartList[$j]['P_BAESONG_TYPE'] == "4") $strDeliveryTypeName = "수령별배송";
							else if ($aryShopOrderCartList[$j]['P_BAESONG_TYPE'] == "5") $strDeliveryTypeName = "착불";
							else $strDeliveryTypeName = "기본배송";

							$param = "";
							$param["oc_no"] = $aryShopOrderCartList[$j]['OC_NO'];
							$aryProdCartAddOptList = $orderMgr->getOrderCartAddList($db,$param);
							

							$strCartOptAttrVal = "";
							for($kk=1;$kk<=10;$kk++){
								if ($aryShopOrderCartList[$j]["OC_OPT_ATTR".$kk]){
									$strCartOptAttrVal .= "/".$aryShopOrderCartList[$j]["OC_OPT_ATTR".$kk];
								}
							}
							$strCartOptAttrVal = SUBSTR($strCartOptAttrVal,1);


							?>
				<tr>
					<td><?=getEuckrString($index)?></td>
					<td><?=getEuckrString($row['O_KEY'])?></td>
					<td><?=getEuckrString($row['O_REG_DT'])?></td>
					<td><?=getEuckrString($row['M_ID'])?><?=(!$row['M_ID'])?"(".getEuckrString($row['M_NAME']).")":"";?></td>
					<?if($S_FIX_MEMBER_CATE_USE_YN == "Y"){?>
					<td><?=getEuckrString($strMemberCateList0)?></td>
					<td><?=getEuckrString($strMemberCateList1)?></td>
					<?}?>
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
					<td><?=getEuckrString($strShopName)?></td>

					<td><?=getEuckrString($aryShopOrderCartList[$j]['P_NAME'])?></td>
					<td><?=getEuckrString($strCartOptAttrVal)?></td>
					<td>
						<?if (is_array($aryProdCartAddOptList)){
							for($k=0;$k<sizeof($aryProdCartAddOptList);$k++){?>
							<?=getEuckrString($LNG_TRANS_CHAR["OW00046"]) //추가선택?> : <?=getEuckrString($aryProdCartAddOptList[$k][OCA_OPT_NM])?><br>
						<?}}?>
					</td>
					<td><?=getFormatPrice($aryShopOrderCartList[$j]['OC_STOCK_CUR_PRICE'], 2)?></td>
					<td><?=getFormatPrice($aryShopOrderCartList[$j]['OC_CUR_PRICE'], 2)?></td>
					<td><?=$aryShopOrderCartList[$j]['OC_QTY']?></td>
					<td><?=getEuckrString($strDeliveryTypeName)?></td>
					<td><?=getFormatPrice($intShopDeliveryPrice,2)?></td>
					<td><?=getEuckrString($aryDeliveryComAll[$strShopDeliveryCom])?></td>
					<td style='mso-number-format:"\@";' ><?=getEuckrString($strShopDeliveryNum)?></td>
					<td><?=getEuckrString($S_ARY_DELIVERY_STATUS[$aryShopOrderList[$i]['SO_DELIVERY_STATUS']])?></td>
					<td><?=getEuckrString($strShopOrderCartStatus)?></td>
					<td><?=getEuckrString(getFormatPrice($row['O_USE_POINT'],2))?></td>
					<td><?=getEuckrString(getFormatPrice($row['O_TOT_PRICE'],2))?></td>
					<td><?=getEuckrString(getFormatPrice($row['O_TOT_DELIVERY_PRICE'],2))?></td>
					<td><?=getEuckrString(getFormatPrice($row['O_TOT_SPRICE'],2))?></td>
					<td><?=getEuckrString(getFormatPrice($row['O_TOT_POINT'],2))?></td>
					<td><?=getEuckrString($strOrderSettle)?></td>
					<td><?=getEuckrString($S_ARY_SETTLE_STATUS[$row['O_STATUS']])?></td>
					<td style='mso-number-format:"\@";' ><?=getEuckrString(sprintf("%s", $row['O_APPR_NO']))?></td>
					<td><?=getEuckrString($row['O_APPR_DT'])?></td>
					<td><?=getEuckrString($strOrderBankName)?></td>
					<td><?=getEuckrString($strOrderBank)?></td>
					<td style='mso-number-format:"\@";'><?=getEuckrString($strOrderBankAcc)?></td>
					<td style='mso-number-format:"\@";'><?=getEuckrString($row['O_BANK_VALID_DT'])?></td>
					<td><?=getEuckrString($aryBank2["BK".$row['O_RETURN_BANK']])?></td>
					<td><?=getEuckrString($row['O_RETURN_ACC'])?></td>
					<td><?=getEuckrString($row['O_RETURN_NAME'])?></td>
					<td><?=getEuckrString($row['O_CEL_MEMO'])?></td>
					<td><?=getEuckrString($row['O_CEL_STATUS'])?></td>
				</tr>

							<?
						}
					}
			}
		}
		
		
	?>
	<?$index++;?>
<?endwhile;?>
</table>
