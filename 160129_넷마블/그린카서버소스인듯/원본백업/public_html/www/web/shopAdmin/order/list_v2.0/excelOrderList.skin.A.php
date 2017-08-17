<table border="1">
	<tr>
		<th><?=$LNG_TRANS_CHAR["CW00009"] //번호?></th>
		<th><?=$LNG_TRANS_CHAR["OW00002"] //주문번호?></th>
		<th><?=$LNG_TRANS_CHAR["OW00074"] //주문일시?></th>
		<th><?="회원ID"?></th>
		<?if($S_FIX_MEMBER_CATE_USE_YN == "Y"){?>
		<th><?="소속1"?></th>
		<th><?="소속2"?></th>
		<?}?>
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

		<th><?="과세"?></th>
		<th><?="비과세"?></th>
		<th><?="마진금액"?></th>

		<th><?="추가금액"?></th>
		<th><?="상품수량"?></th>
		<th><?="상품배송방법"?></th>
		<th><?="배송회사"?></th>
		<th><?="배송번호"?></th>
		<?if ($S_MALL_TYPE != "R"){?><th><?="상품별배송비"?></th><?}?>
		<th><?="배송비"?></th>
		<th><?="배송상태"?></th>
		<th><?="배송시작일"?></th>
		<th><?="배송완료일"?></th>
		<th><?="구매상태"?></th>

		<th><?="사용포인트"?></th>
		<th><?="총주문금액"?></th>
		<th><?="총배송비"?></th>
		<th><?="총결제금액"?></th>
		<th><?="총적립액"?></th>
		<th><?="결제방법"?></th>
		<th><?="결제승인번호"?></th>
		<th><?="결제승인일자"?></th>
		<th><?="주문상태"?></th>
		<th><?="무통장입금자명"?></th>
		<th><?="무통장입금은행"?></th>
		<th><?="무통장입금계좌번호"?></th>

		<th><?="가상계좌은행"?></th>
		<th><?="가상계좌번호"?></th>
		<th><?="가상계좌마감시간"?></th>

		<th><?="통관정보"?></th>

		<th><?="환불은행"?></th>
		<th><?="환불계좌번호"?></th>
		<th><?="환불예금주"?></th>
		<th><?="취소사유"?></th>
		<th><?="취소처리여부"?></th>
	</tr>
	<?
	$index = 1;
	while($row = mysql_fetch_array($orderListResult)): // 주문 리스트
		$strOrderSettleStatus	= $strOrderStatus = $strOrderBankName = $strOrderBank = $strOrderBankAcc = "";
		$strOrderVirtualBank	= $strOrderVirtualBankAcc = "";
		$intProdShopNo			= "";

		/* 무통장 입금 정보 */
		$strOrderBankName	= $row['O_BANK_NAME'];
		$strOrderBank		= $aryBank1[$row['O_BANK']];
		$strOrderBankAcc	= $arySiteSettleBank[$row['O_BANK_ACC']];

		/* 가상계좌 입금 */
		if ($row['O_SETTLE'] == "T"){
			$strOrderVirtualBank	= $aryBank2[$row['O_BANK']];
			$strOrderVirtualBankAcc	= $row['O_BANK_ACC'];
		}

		/* 주문상태 */
		if ($row[O_STATUS] == "J" || $row[O_STATUS] == "O"){
			$strOrderStatusText = $LNG_TRANS_CHAR["OW00079"];
		} else {
			$strOrderStatusText = $S_ARY_SETTLE_STATUS[$row[O_STATUS]];
		}

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

		/* 주문 입점사별 리스트 */
		$param				= "";
		$param['O_NO']		= $row['O_NO'];
		$param["O_USE_LNG"] = $S_SITE_LNG;

		if ($S_MALL_TYPE != "R"){
			## 주문 입점사별 정보
			$param['O_SHOP_NO']	= "-1";

			if ($_REQUEST['searchShop'] && $_REQUEST['searchShop'] != "undefined"){
				$param['O_SHOP_NO'] = $_REQUEST['searchShop'];
			}

			## 영업사용/관리 입점몰 사용여부
			if ($ADMIN_SHOP_SELECT_USE == "Y")
			{
				if ($a_admin_tm == "Y" && $a_admin_shop_list) {
					/* 영업사원이며 tm 입점사관리 기능이 있을 경우 */
					$param['O_SHOP_NO'] = $a_admin_shop_list;
				}
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
		$strCartDeliveryTypeName	= "";
		$intCartDeliveryTypePrice	= 0;
		switch($aryOrderCartList[0]['OC_P_BAESONG_TYPE']){
			case "1":
				$strCartDeliveryTypeName	= "기본배송";
				$intCartDeliveryTypePrice	= 0;
			break;
			case "2":
				$strCartDeliveryTypeName	= "무료배송";
				$intCartDeliveryTypePrice	= 0;
			break;
			case "3":
				$strCartDeliveryTypeName	= "고정배송비";
				$strCartDeliveryTypeName   .= "(".getCurMark($S_ST_CUR).getFormatPrice($aryOrderCartList[0]['OC_DELIVERY_CUR_PRICE'],2).getCurMark2($S_ST_CUR).")";
				$intCartDeliveryTypePrice	= $aryOrderCartList[0]['OC_DELIVERY_CUR_PRICE'];
			break;
			case "4":
				$strCartDeliveryTypeName	= "수량별배송";
				$intCartDeliveryTypePrice	= $aryOrderCartList[0]['OC_DELIVERY_CUR_PRICE'];
			break;
			case "5":
				$strCartDeliveryTypeName	 = "착불";
				$strCartDeliveryTypeName	.= "(".getCurMark($S_ST_CUR).getFormatPrice($aryOrderCartList[0]['OC_DELIVERY_CUR_PRICE'],2).getCurMark2($S_ST_CUR).")";
				$intCartDeliveryTypePrice	 = 0;
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

		## 과세/비과세/마진금액
		$intProdTaxPrice = $intProdNoTaxPrice = $intProdProfitPrice = 0;
		if ($aryOrderCartList[0]['P_TAX'] == "Y") $intProdTaxPrice = $aryOrderCartList[0]['OC_CUR_PRICE'];
		if ($aryOrderCartList[0]['P_TAX'] == "N") $intProdNoTaxPrice = $aryOrderCartList[0]['OC_CUR_PRICE'];
		$intProdProfitPrice = $aryOrderCartList[0]['OC_CUR_PRICE'] - $aryOrderCartList[0]['OC_STOCK_CUR_PRICE'];

		## 입점사의 상품번호
		if (!in_array(substr($aryOrderCartList[0]['OC_ORDER_STATUS'],0,1),array("C","R","T"))){
			$intProdShopNo = $aryOrderCartList[0][P_SHOP_NO];
		}
	?>
	<tr>
		<td><?=$index?></td>
		<td><?=$row['O_KEY']?></td>
		<td><?=$row['O_REG_DT']?></td>
		<td><?=$row['M_ID']?><?=(!$row['M_ID'])?"(".$row['M_NAME'].")":"";?></td>
		<?if($S_FIX_MEMBER_CATE_USE_YN == "Y"){?>
		<td><?=$strMemberCateList0?></td>
		<td><?=$strMemberCateList1?></td>
		<?}?>
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

		<td><?=getFormatPrice($intProdTaxPrice, 2)?></td>
		<td><?=getFormatPrice($intProdNoTaxPrice, 2)?></td>
		<td><?=getFormatPrice($intProdProfitPrice, 2)?></td>

		<td><?=getFormatPrice($aryOrderCartList[0]['OC_OPT_ADD_CUR_PRICE'], 2)?></td>

		<td><?=$aryOrderCartList[0]['OC_QTY']?></td>
		<td><?=$strCartDeliveryTypeName . $strCartDeliveryPayMthName?></td>
		<td><?=$aryDeliveryComAll[$aryOrderCartList[0]['OC_DELIVERY_COM']]?></td>
		<td style='mso-number-format:"\@";' ><?=$aryOrderCartList[0]['OC_DELIVERY_NUM']?></td>
		<?if ($S_MALL_TYPE != "R"){?>
		<td><?=getFormatPrice($intCartDeliveryTypePrice,2)?></td>
		<?}?>
		<td>
			<?if (!in_array(substr($aryOrderCartList[0]['OC_ORDER_STATUS'],0,1),array("C","R","T"))){?>
			<?=getFormatPrice($aryOrderCartShopList[$aryOrderCartList[0][P_SHOP_NO]]['SO_TOT_DELIVERY_CUR_PRICE'],2)?>
			<?}?>
		</td>
		<td><?=$S_ARY_DELIVERY_STATUS[$aryOrderCartList[0]['OC_DELIVERY_STATUS']]?></td>
		<td><?=$aryOrderCartList[0]['OC_DELIVERY_ST_DT']?></td>
		<td><?=$aryOrderCartList[0]['OC_DELIVERY_END_DT']?></td>
		<td><?=$strCartOrderCartStatus?></td>

		<td><?=getFormatPrice($row['O_USE_POINT'],2)?></td>
		<td><?=getFormatPrice($row['O_TOT_PRICE'],2)?></td>
		<td><?=getFormatPrice($row['O_TOT_DELIVERY_PRICE'],2)?></td>
		<td><?=getFormatPrice($row['O_TOT_SPRICE'],2)?></td>
		<td><?=getFormatPrice($row['O_TOT_POINT'],2)?></td>
		<td><?=$S_ARY_SETTLE_TYPE[$row['O_SETTLE']]?></td>
		<td style='mso-number-format:"\@";' ><?=sprintf("%s", $row['O_APPR_NO'])?></td>
		<td><?=$row['O_APPR_DT']?></td>
		<td><?=$strOrderStatusText?></td>

		<td><?=$strOrderBankName?></td>
		<td><?=$strOrderBank?></td>
		<td style='mso-number-format:"\@";'><?=$strOrderBankAcc?></td>
		<td><?=$strOrderVirtualBank?></td>
		<td style='mso-number-format:"\@";'><?=$strOrderVirtualBankAcc?></td>
		<td style='mso-number-format:"\@";'><?=$row['O_BANK_VALID_DT']?></td>
		<td><?=$row['O_SHIPPING_NO2'];?>

		<td><?=$aryBank2["BK".$row['O_RETURN_BANK']]?></td>
		<td><?=$row['O_RETURN_ACC']?></td>
		<td><?=$row['O_RETURN_NAME']?></td>
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
				$strCartDeliveryTypeName	= "";
				$intCartDeliveryTypePrice	= 0;
				switch($aryOrderCartList[$j]['OC_P_BAESONG_TYPE']){
					case "1":
						$strCartDeliveryTypeName	= "기본배송";
						$intCartDeliveryTypePrice	= 0;
					break;
					case "2":
						$strCartDeliveryTypeName	= "무료배송";
						$intCartDeliveryTypePrice	= 0;
					break;
					case "3":
						$strCartDeliveryTypeName	= "고정배송비";
						$strCartDeliveryTypeName   .= "(".getCurMark($S_ST_CUR).getFormatPrice($aryOrderCartList[$j]['OC_DELIVERY_CUR_PRICE'],2).getCurMark2($S_ST_CUR).")";
						$intCartDeliveryTypePrice	= $aryOrderCartList[$j]['OC_DELIVERY_CUR_PRICE'];
					break;
					case "4":
						$strCartDeliveryTypeName	= "수량별배송";
						$intCartDeliveryTypePrice	= $aryOrderCartList[$j]['OC_DELIVERY_CUR_PRICE'];
					break;
					case "5":
						$strCartDeliveryTypeName	 = "착불";
						$strCartDeliveryTypeName	.= "(".getCurMark($S_ST_CUR).getFormatPrice($aryOrderCartList[$j]['OC_DELIVERY_CUR_PRICE'],2).getCurMark2($S_ST_CUR).")";
						$intCartDeliveryTypePrice	= 0;
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

				## 과세/비과세/마진금액
				$intProdTaxPrice = $intProdNoTaxPrice = $intProdProfitPrice = 0;
				if ($aryOrderCartList[$j]['P_TAX'] == "Y") $intProdTaxPrice = $aryOrderCartList[$j]['OC_CUR_PRICE'];
				if ($aryOrderCartList[$j]['P_TAX'] == "N") $intProdNoTaxPrice = $aryOrderCartList[$j]['OC_CUR_PRICE'];
				$intProdProfitPrice = $aryOrderCartList[$j]['OC_CUR_PRICE'] - $aryOrderCartList[$j]['OC_STOCK_CUR_PRICE'];

				?>
	<tr>
		<td><?=$index?></td>
		<td><?=$row['O_KEY']?></td>
		<td><?=$row['O_REG_DT']?></td>
		<td><?=$row['M_ID']?><?=(!$row['M_ID'])?"(".$row['M_NAME'].")":"";?></td>
		<?if($S_FIX_MEMBER_CATE_USE_YN == "Y"){?>
		<td><?=$strMemberCateList0?></td>
		<td><?=$strMemberCateList1?></td>
		<?}?>
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
		<td><?=getFormatPrice($intProdTaxPrice, 2)?></td>
		<td><?=getFormatPrice($intProdNoTaxPrice, 2)?></td>
		<td><?=getFormatPrice($intProdProfitPrice, 2)?></td>
		<td><?=getFormatPrice($aryOrderCartList[$j]['OC_OPT_ADD_CUR_PRICE'], 2)?></td>
		<td><?=$aryOrderCartList[$j]['OC_QTY']?></td>
		<td><?=$strCartDeliveryTypeName?></td>
		<td><?=$aryDeliveryComAll[$aryOrderCartList[$j]['OC_DELIVERY_COM']]?></td>
		<td style='mso-number-format:"\@";' ><?=$aryOrderCartList[$j]['OC_DELIVERY_NUM']?></td>
		<?if ($S_MALL_TYPE != "R"){?>
		<td><?=getFormatPrice($intCartDeliveryTypePrice,2)?></td>
		<?}?>
		<td><?if($intProdShopNo != $aryOrderCartList[$j][P_SHOP_NO]){echo getFormatPrice($aryOrderCartShopList[$aryOrderCartList[$j][P_SHOP_NO]]['SO_TOT_DELIVERY_CUR_PRICE'],2);}?></td>
		<td><?=$S_ARY_DELIVERY_STATUS[$aryOrderCartList[$j]['OC_DELIVERY_STATUS']]?></td>
		<td><?=$aryOrderCartList[$j]['OC_DELIVERY_ST_DT']?></td>
		<td><?=$aryOrderCartList[$j]['OC_DELIVERY_END_DT']?></td>
		<td><?=$strCartOrderCartStatus?></td>

		<td><?=getFormatPrice($row['O_USE_POINT'],2)?></td>
		<td><?=getFormatPrice($row['O_TOT_PRICE'],2)?></td>
		<td><?=getFormatPrice($row['O_TOT_DELIVERY_PRICE'],2)?></td>
		<td><?=getFormatPrice($row['O_TOT_SPRICE'],2)?></td>
		<td><?=getFormatPrice($row['O_TOT_POINT'],2)?></td>
		<td><?=$S_ARY_SETTLE_TYPE[$row['O_SETTLE']]?></td>
		<td style='mso-number-format:"\@";' ><?=sprintf("%s", $row['O_APPR_NO'])?></td>
		<td><?=$row['O_APPR_DT']?></td>
		<td><?=$strOrderStatusText?></td>
		<td><?=$strOrderBankName?></td>
		<td><?=$strOrderBank?></td>
		<td style='mso-number-format:"\@";'><?=$strOrderBankAcc?></td>
		<td><?=$strOrderVirtualBank?></td>
		<td style='mso-number-format:"\@";'><?=$strOrderVirtualBankAcc?></td>
		<td style='mso-number-format:"\@";'><?=$row['O_BANK_VALID_DT']?></td>
		
		<td><?=$row['O_SHIPPING_NO2'];?>

		<td><?=$aryBank2["BK".$row['O_RETURN_BANK']]?></td>
		<td><?=$row['O_RETURN_ACC']?></td>
		<td><?=$row['O_RETURN_NAME']?></td>
		<td><?=$row['O_CEL_MEMO']?></td>
		<td><?=$row['O_CEL_STATUS']?></td>
	</tr>
				<?

				if ($intProdShopNo != $aryOrderCartList[$j][P_SHOP_NO]){
					$intProdShopNo = $aryOrderCartList[$j][P_SHOP_NO];
				}
			}
		}
	?>
	<?$index++;?>
<?endwhile;?>
</table>
