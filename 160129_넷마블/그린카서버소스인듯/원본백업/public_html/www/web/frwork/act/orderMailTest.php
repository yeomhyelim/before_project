<?
	$intO_NO = 58;

	$orderMgr->setP_LNG("KR");
	$orderMgr->setP_SHOP_NO(2);
	$orderMgr->setO_NO($intO_NO);
	$orderRow = $orderMgr->getOrderView($db);
	
	$cartResult = $orderMgr->getShopOrderCartList($db);
	$intCartTotal= $cartResult["cnt"];
	$orderMgr->setPageLine($intCartTotal);
	$orderMgr->setLimitFirst(0);
	
	$param["so_no"] = 63;
	$shopOrderRow = $orderMgr->getShopOrderView($db,$param);
	
	/*배송회사*/
	$aryDeliveryCom = getCommCodeList("DELIVERY","Y");
	$aryDeliveryUrl = getDeliveryUrlList();
	if ($shopOrderRow[SO_DELIVERY_NUM] && $shopOrderRow[SO_DELIVERY_COM]){
		$strOrderDeliveryUrl = str_replace("{dev_no}",$shopOrderRow[SO_DELIVERY_NUM],$aryDeliveryUrl[$shopOrderRow[SO_DELIVERY_COM]]);
	}

	if ($S_SITE_LNG != "KR"){
		$aryCountryList		= getCountryList();			
		$aryCountryState	= getCommCodeList("STATE","");
		$strDeliveyState	= $orderRow[O_B_STATE];
		if ($orderRow[O_B_COUNTRY] == "US") $strDeliveyState = $aryCountryList[$orderRow[O_B_STATE]];
	}		

	$strOrderCartHtml  = "";
	$strOrderCartHtml .= "<table style=\"width:100%;margin:0 auto;border-collapse: collapse;\">";
	$strOrderCartHtml .= "	<tr>";
	$strOrderCartHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00001"]."</th>";
	$strOrderCartHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00002"]."</th>";
	$strOrderCartHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00003"]."</th>";
	$strOrderCartHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00004"]."</th>";
	$strOrderCartHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["PW00012"]."</th>";
	$strOrderCartHtml .= "	</tr>";
	
	
	if ($intCartTotal == 0){
		$strOrderCartHtml .= "<tr>";
		$strOrderCartHtml .= "		<td colspan=\"5\">".$LNG_TRANS_CHAR["OS00001"]."</td>";
		$strOrderCartHtml .= "</tr>";
	} else {
		$intCartPrice = $intCartPriceTotal = $intCartPointTotal = 0;
		while ($cartRow = mysql_fetch_array($cartResult["result"])){
			
			$intCartPrice = ($cartRow[OC_CUR_PRICE] * $cartRow[OC_QTY]) + $cartRow[OC_OPT_ADD_CUR_PRICE];
			$intCartPriceTotal += $intCartPrice;
			
			$orderMgr->setOC_NO($cartRow[OC_NO]);
			$aryProdCartAddOptList = $orderMgr->getOrderCartAddList($db);

			$strCartOptAttrVal = "";
			for($kk=1;$kk<=10;$kk++){
				if ($cartRow["OC_OPT_ATTR".$kk]){
					$strCartOptAttrVal .= "/".$cartRow["OC_OPT_ATTR".$kk];
				}
			}
			$strCartOptAttrVal = SUBSTR($strCartOptAttrVal,1);

			$strOrderCartHtml .= "	<tr>";
			$strOrderCartHtml .= "		<td class=\"prodInfo\" style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">";
			$strOrderCartHtml .= "			<img src=\"".$S_SITE_URL.$cartRow[PM_REAL_NAME]."\" style=\"width:50px;\"/>";
			$strOrderCartHtml .= "			<ul>";
			$strOrderCartHtml .= "				<li>".$cartRow[P_NAME].$strProdEventText."</li>";
			if ($strCartOptAttrVal){
				$strOrderCartHtml .= "				<li>".$strCartOptAttrVal."</li>";
			}

			if (is_array($aryProdCartAddOptList)){
				for($k=0;$k<sizeof($aryProdCartAddOptList);$k++){
					$strOrderCartHtml .= "<li>".$LNG_TRANS_CHAR["OW00006"]." : ".$aryProdCartAddOptList[$k][OCA_OPT_NM]."</li>";
				}
			}

			$strOrderCartHtml .= "			</ul>";
			$strOrderCartHtml .= "			<div class=\"clear\"></div>";
			$strOrderCartHtml .= "		</td>";
			$strOrderCartHtml .= "		<td style=\"padding: 5px;border:1px solid #c5c5c5\">";
			
			if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){
				$strOrderCartHtml .= "			".getCurMark("USD")." <strong class=\"priceBoldGray\">".getCurToPrice($cartRow[OC_CUR_PRICE],"US")."</strong>";
				$strOrderCartHtml .= "(".$S_SITE_CUR_MARK1.getCurToPrice($cartRow[OC_CUR_PRICE],$orderRow[O_USE_LNG]).")";
			} else {
				$strOrderCartHtml .= "			".getCurMark($orderRow[O_USE_CUR])." <strong class=\"priceBoldGray\">".getCurToPrice($cartRow[OC_CUR_PRICE],$orderRow[O_USE_LNG])."</strong>";
			}
			if ($cartRow[OC_OPT_ADD_PRICE] > 0){
				if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){
					$strOrderCartHtml .= "<br>".$LNG_TRANS_CHAR["OW00007"].":".getCurMark("USD")." ".getCurToPrice($cartRow[OC_OPT_ADD_CUR_PRICE],"US");
					$strOrderCartHtml .= "(".$S_SITE_CUR_MARK1.getCurToPrice($cartRow[OC_OPT_ADD_CUR_PRICE],$orderRow[O_USE_LNG]).")";
				}else{
					$strOrderCartHtml .= "<br>".$LNG_TRANS_CHAR["OW00007"].":".getCurMark($orderRow[O_USE_CUR])." ".getCurToPrice($cartRow[OC_OPT_ADD_CUR_PRICE],$orderRow[O_USE_LNG]);
				}
			}
			
			$strOrderCartHtml .= "		</td>";
			$strOrderCartHtml .= "		<td style=\"padding: 5px;border:1px solid #c5c5c5\">";
			$strOrderCartHtml .= "			".$cartRow[OC_QTY]."";
			$strOrderCartHtml .= "		</td>";
			$strOrderCartHtml .= "		<td style=\"padding: 5px;border:1px solid #c5c5c5\">";
			if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){
				$strOrderCartHtml .= getCurMark("USD")." <strong class=\"priceOrange\">".getCurToPrice($intCartPrice,"US")."</strong>";
				$strOrderCartHtml .= "(".$S_SITE_CUR_MARK1.getCurToPrice($intCartPrice,$orderRow[O_USE_LNG]).")";
			} else {
				$strOrderCartHtml .= getCurMark($orderRow[O_USE_CUR])." <strong class=\"priceOrange\">".getCurToPrice($intCartPrice,$orderRow[O_USE_LNG])."</strong>";
			}
			
			$strOrderCartHtml .= "		</td>";
			$strOrderCartHtml .= "		<td style=\"padding: 5px;border:1px solid #c5c5c5\" rowspan=\"".$intCartTotal."\">".getCurMark($orderRow[O_USE_CUR]).getCurToPrice($cartRow['SO_TOT_DELIVERY_CUR_PRICE'],$orderRow[O_USE_LNG]).getCurMark($orderRow[O_USE_CUR]);
			$strOrderCartHtml .= "		</td>";
			$strOrderCartHtml .= "	</tr>";
		}
	}
	$strOrderCartHtml .= "</table>";


	$strOrderInfoHtml = "<br><br>";

	$strOrderInfoHtml .= "<table style=\"width:100%;margin:0 auto;border-collapse: collapse;\">";
	$strOrderInfoHtml .= "	<tr>";
	$strOrderInfoHtml .= "		<th style=\"width:200px;padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00098"]."/".$LNG_TRANS_CHAR["OW00099"]."</th>";
	$strOrderInfoHtml .= "		<td style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">".$aryDeliveryCom[$shopOrderRow['SO_DELIVERY_COM']]."/<a href=\"".$strOrderDeliveryUrl."\" target=\"_blank\">".$shopOrderRow['SO_DELIVERY_NUM']."</a></td>";
	$strOrderInfoHtml .= "	</tr>";

	$strOrderInfoHtml .= "	<tr>";
	$strOrderInfoHtml .= "		<th style=\"width:200px;padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00017"]."</th>";
	$strOrderInfoHtml .= "		<td style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">".$orderRow[O_B_NAME]."</td>";
	$strOrderInfoHtml .= "	</tr>";
	$strOrderInfoHtml .= "	<tr>";
	$strOrderInfoHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00018"]."</th>";
	$strOrderInfoHtml .= "		<td style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">".$orderRow[O_B_PHONE]."</td>";
	$strOrderInfoHtml .= "	</tr>";
	$strOrderInfoHtml .= "	<tr>";
	$strOrderInfoHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00019"]."</th>";
	$strOrderInfoHtml .= "		<td style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">".$orderRow[O_B_HP]."</td>";
	$strOrderInfoHtml .= "	</tr>";

	if ($S_SITE_LNG == "KR"){
		$strOrderInfoHtml .= "	<tr>";
		$strOrderInfoHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00022"]."</th>";
		$strOrderInfoHtml .= "		<td style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">[".$orderRow[O_B_ZIP]."] ".$orderRow[O_B_ADDR1]." ".$orderRow[O_B_ADDR2]."</td>";
		$strOrderInfoHtml .= "	</tr>";
	} else {
		$strOrderInfoHtml .= "	<tr>";
		$strOrderInfoHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00012"]."</th>";
		$strOrderInfoHtml .= "		<td style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">".$orderRow[O_B_ZIP]."</td>";
		$strOrderInfoHtml .= "	</tr>";
		$strOrderInfoHtml .= "	<tr>";
		$strOrderInfoHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00022"]."</th>";
		$strOrderInfoHtml .= "		<td style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">".$orderRow[O_B_ADDR1]." ".$orderRow[O_B_ADDR2]." ".$orderRow[O_B_CITY]." ".$strDeliveryState." ".$aryCountryList[$orderRow[O_B_COUNTRY]]."</td>";
		$strOrderInfoHtml .= "	</tr>";			
	}

	if ($orderRow[O_B_MEMO]){
		$strOrderInfoHtml .= "	<tr>";
		$strOrderInfoHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00028"]."</th>";
		$strOrderInfoHtml .= "		<td style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">".$orderRow[O_B_MEMO]."</td>";
		$strOrderInfoHtml .= "	</tr>";
	}

	$strOrderInfoHtml .= "</table>";

		
?>