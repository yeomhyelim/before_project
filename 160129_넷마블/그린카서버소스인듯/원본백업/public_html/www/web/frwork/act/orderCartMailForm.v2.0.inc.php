<?
	/* 관리자로 전송시 언어팩 확인 */
	if ($strMailSendMode == "adm"){
		if ($orderRow[O_USE_LNG] == "KR"){
			include_once MALL_CONF_LANG_KR;
		} else if ($orderRow[O_USE_LNG] == "US"){
			include_once MALL_CONF_LANG_US;		
		} else if ($orderRow[O_USE_LNG] == "CN"){
			include_once MALL_CONF_LANG_CN;		
		} else if ($orderRow[O_USE_LNG] == "JP"){
			include_once MALL_CONF_LANG_JP;		
		} 
	}

	switch ($strMailMode){
		case "orderDeliverySend":
			
			if ($S_SITE_LNG != "KR")
			{
				$aryCountryList		= getCountryList();			
				$aryCountryState	= getCommCodeList("STATE","");
				$strDeliveyState	= $orderRow[O_B_STATE];
				if ($orderRow[O_B_COUNTRY] == "US") $strDeliveyState = $aryCountryList[$orderRow[O_B_STATE]];
			}		
		
			/*배송회사*/
			$aryDeliveryCom			= getCommCodeList("DELIVERY","Y");
			$aryDeliveryUrl			= getDeliveryUrlList();

			$strOrderCartHtml		= "";
			$strOrderCartHtml	   .= "<table style=\"width:100%;margin:0 auto;border-collapse: collapse;\">\r\n";
			$strOrderCartHtml	   .= "	<tr>\r\n";
			$strOrderCartHtml	   .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00001"]."</th>\r\n";
			$strOrderCartHtml	   .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00002"]."</th>\r\n";
			$strOrderCartHtml	   .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00003"]."</th>\r\n";
			$strOrderCartHtml      .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00004"]."</th>\r\n";
			$strOrderCartHtml      .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["PW00012"]."</th>\r\n";
			$strOrderCartHtml      .= "	</tr>\r\n";

			if ($intCartTotal == 0){
				$strOrderCartHtml .= "<tr>\r\n";
				$strOrderCartHtml .= "		<td colspan=\"5\">".$LNG_TRANS_CHAR["OS00001"]."</td>\r\n";
				$strOrderCartHtml .= "</tr>\r\n";
			} else {

				$intCartCnt = $intCartPrice = $intCartPriceTotal = $intCartPointTotal = 0;
				while ($cartRow = mysql_fetch_array($cartResult["result"])){
					
					if (SUBSTR($cartRow["OC_ORDER_STATUS"],0,1) != "C")
					{
						$intCartPrice		= ($cartRow[OC_CUR_PRICE] * $cartRow[OC_QTY]) + $cartRow[OC_OPT_ADD_CUR_PRICE];
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
						
						/* 배송추적 */
						if ($cartRow[OC_DELIVERY_COM] && $cartRow[OC_DELIVERY_NUM])
						{
							$strDeliveryCom		 = trim($cartRow[OC_DELIVERY_COM]);
							$strOrderDeliveryUrl = str_replace("{dev_no}",$cartRow[OC_DELIVERY_NUM],$aryDeliveryUrl[$strDeliveryCom]);
						}
						
						## 상품배송정보
						$strCartDeliveryTypeName = "";
						switch($cartRow['OC_P_BAESONG_TYPE']){
							case "1":
								$strCartDeliveryTypeName	 = "기본배송";
							break;
							case "2":
								$strCartDeliveryTypeName	 = "무료배송";
							break;
							case "3":
								$strCartDeliveryTypeName	 = "고정배송비";
								$strCartDeliveryTypeName	.= "(".getCurMark().getCurToPrice($aryOrderCartList[$i]['OC_DELIVERY_CUR_PRICE'],2).getCurMark2().")";

							break;
							case "4":
								$strCartDeliveryTypeName	 = "수량별배송";
							break;
							case "5":
								$strCartDeliveryTypeName	 = "착불";
								if ($aryOrderCartList[$i]['OC_DELIVERY_CUR_PRICE'] > 0){
									$strCartDeliveryTypeName	.= "(".getCurMark().getCurToPrice($aryOrderCartList[$i]['OC_DELIVERY_CUR_PRICE'],2).getCurMark2().")";
								}
							break;
						}

						$strOrderCartHtml .= "	<tr>\r\n";
						$strOrderCartHtml .= "		<td class=\"prodInfo\" style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">\r\n";
						$strOrderCartHtml .= "			<img src=\"".$S_SITE_URL.$cartRow[PM_REAL_NAME]."\" style=\"width:50px;\"/>\r\n";
						$strOrderCartHtml .= "			<ul>\r\n";
						$strOrderCartHtml .= "				<li>".$cartRow[OC_P_NAME]."</li>\r\n";
						if ($strCartOptAttrVal){
							$strOrderCartHtml .= "				<li>".$strCartOptAttrVal."</li>\r\n";
						}

						if (is_array($aryProdCartAddOptList)){
							for($k=0;$k<sizeof($aryProdCartAddOptList);$k++){
								$strOrderCartHtml .= "<li>".$LNG_TRANS_CHAR["OW00006"]." : ".$aryProdCartAddOptList[$k][OCA_OPT_NM]."</li>\r\n";
							}
						}

						$strOrderCartHtml .= "			</ul>\r\n";
						$strOrderCartHtml .= "			<div class=\"clear\"></div>\r\n";
						$strOrderCartHtml .= "		</td>\r\n";
						$strOrderCartHtml .= "		<td style=\"padding: 5px;border:1px solid #c5c5c5\">\r\n";
						
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
						
						$strOrderCartHtml .= "		</td>\r\n";
						$strOrderCartHtml .= "		<td style=\"padding: 5px;border:1px solid #c5c5c5\">\r\n";
						$strOrderCartHtml .= "			".$cartRow[OC_QTY]."";
						$strOrderCartHtml .= "		</td>\r\n";
						$strOrderCartHtml .= "		<td style=\"padding: 5px;border:1px solid #c5c5c5\">\r\n";
						if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){
							$strOrderCartHtml .= getCurMark("USD")." <strong class=\"priceOrange\">".getCurToPrice($intCartPrice,"US")."</strong>";
							$strOrderCartHtml .= "(".$S_SITE_CUR_MARK1.getCurToPrice($intCartPrice,$orderRow[O_USE_LNG]).")";
						} else {
							$strOrderCartHtml .= getCurMark($orderRow[O_USE_CUR])." <strong class=\"priceOrange\">".getCurToPrice($intCartPrice,$orderRow[O_USE_LNG])."</strong>";
						}
						
						$strOrderCartHtml .= "		</td>\r\n";
						
						$strOrderCartHtml .= "		<td style=\"padding: 5px;border:1px solid #c5c5c5\">\r\n";
						$strOrderCartHtml .= $strCartDeliveryTypeName;
						//if ($cartRow['P_SHOP_NO']>0){
						//	$strOrderCartHtml .= "<br>(".$aryCartShopInfo[$cartRow['P_SHOP_NO']]['ST_NAME'].")";
						//}
						$strOrderCartHtml .= "		<br><a href=\"".$strOrderDeliveryUrl."\" target=\"_blank\">".$LNG_TRANS_CHAR["OW00109"]."</a>";
						$strOrderCartHtml .= "		</td>\r\n";

						$strOrderCartHtml .= "	</tr>\r\n";
			
						$intCartCnt++;
					}
				}
			}
			$strOrderCartHtml .= "</table>\r\n";
//			echo $strOrderCartHtml;

			$strOrderInfoHtml = "<br><br>\r\n";

			$strOrderInfoHtml .= "<table style=\"width:100%;margin:0 auto;border-collapse: collapse;\">\r\n";
			$strOrderInfoHtml .= "	<tr>\r\n";
			$strOrderInfoHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">\r\n".$LNG_TRANS_CHAR["OW00017"]."</th>\r\n";
			$strOrderInfoHtml .= "		<td style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">\r\n".$orderRow[O_B_NAME]."</td>\r\n";
			$strOrderInfoHtml .= "	</tr>\r\n";
			$strOrderInfoHtml .= "	<tr>\r\n";
			$strOrderInfoHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">\r\n".$LNG_TRANS_CHAR["OW00018"]."</th>\r\n";
			$strOrderInfoHtml .= "		<td style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">\r\n".$orderRow[O_B_PHONE]."</td>\r\n";
			$strOrderInfoHtml .= "	</tr>\r\n";
			$strOrderInfoHtml .= "	<tr>\r\n";
			$strOrderInfoHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">\r\n".$LNG_TRANS_CHAR["OW00019"]."</th>\r\n";
			$strOrderInfoHtml .= "		<td style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">\r\n".$orderRow[O_B_HP]."</td>\r\n";
			$strOrderInfoHtml .= "	</tr>\r\n";

			if ($orderRow["O_USE_LNG"] == "KR"){
				$strOrderInfoHtml .= "	<tr>\r\n";
				$strOrderInfoHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">\r\n".$LNG_TRANS_CHAR["OW00022"]."</th>\r\n";
				$strOrderInfoHtml .= "		<td style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">\r\n"."[".$orderRow[O_B_ZIP]."] ".$orderRow[O_B_ADDR1]." ".$orderRow[O_B_ADDR2]."</td>\r\n";
				$strOrderInfoHtml .= "	</tr>\r\n";
			} else {
				$strOrderInfoHtml .= "	<tr>\r\n";
				$strOrderInfoHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">\r\n".$LNG_TRANS_CHAR["OW00012"]."</th>\r\n";
				$strOrderInfoHtml .= "		<td style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">\r\n".$orderRow[O_B_ZIP]."</td>";
				$strOrderInfoHtml .= "	</tr>\r\n";
				$strOrderInfoHtml .= "	<tr>\r\n";
				$strOrderInfoHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">\r\n".$LNG_TRANS_CHAR["OW00022"]."</th>\r\n";
				$strOrderInfoHtml .= "		<td style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">\r\n".$orderRow[O_B_ADDR1]." ".$orderRow[O_B_ADDR2]." ".$orderRow[O_B_CITY]." ".$strDeliveryState." ".$aryCountryList[$orderRow[O_B_COUNTRY]]."</td>\r\n";
				$strOrderInfoHtml .= "	</tr>\r\n";			
			}

			if ($orderRow[O_B_MEMO]){
				$strOrderInfoHtml .= "	<tr>\r\n";
				$strOrderInfoHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">\r\n".$LNG_TRANS_CHAR["OW00028"]."</th>\r\n";
				$strOrderInfoHtml .= "		<td style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">\r\n".$orderRow[O_B_MEMO]."</td>\r\n";
				$strOrderInfoHtml .= "	</tr>\r\n";
			}

			$strOrderInfoHtml .= "</table>\r\n";
			
//			echo $strOrderInfoHtml;
		break;

	}
?>