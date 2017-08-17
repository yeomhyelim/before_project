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
			$aryDeliveryCom = getCommCodeList("DELIVERY","Y");
			$aryDeliveryUrl = getDeliveryUrlList();

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
				$intCartCnt = $intCartPrice = $intCartPriceTotal = $intCartPointTotal = 0;
				while ($cartRow = mysql_fetch_array($cartResult["result"])){
					
					if ($cartRow["SOC_STATUS"] != "C"){
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
						if ($cartRow[SOC_D_COM] && $cartRow[SOC_D_NUM]){
							$strDeliveryCom		 = trim($cartRow[SOC_D_COM]);
							$strOrderDeliveryUrl = str_replace("{dev_no}",$cartRow[SOC_D_NUM],$aryDeliveryUrl[$strDeliveryCom]);
						}

						/* 상품에 착불가격이 있는 경우 */
						## P_BAESONG_TYPE = 1 : 기본 배송
						## P_BAESONG_TYPE = 2 : 무료 배송
						## P_BAESONG_TYPE = 3 : 고정 배송		배송비 보임
						## P_BAESONG_TYPE = 4 : 수량별 배송		배송비 보임
						## P_BAESONG_TYPE = 5 : 착불 배송		배송비 보임
						if($S_SITE_LNG == "KR"):
							$strBaesongPrice			= "";
								if($cartRow['P_BAESONG_TYPE'] == 1):
							elseif($cartRow['P_BAESONG_TYPE'] == 2):
							elseif($cartRow['P_BAESONG_TYPE'] == 3):
								$strBaesongPrice		= $cartRow['P_BAESONG_PRICE'];
								$strBaesongPrice		= "(고정배송비:" . getCurMark() . getCurToPrice($strBaesongPrice) . getCurMark2() . ")";
							elseif($cartRow['P_BAESONG_TYPE'] == 4):
								$strBaesongPrice		= $cartRow['P_BAESONG_PRICE'];
								$strBaesongPrice		= "(수량별배송비:" . getCurMark() . getCurToPrice($strBaesongPrice) . getCurMark2() . ")";
							elseif($cartRow['P_BAESONG_TYPE'] == 5):
								$strBaesongPrice		= $cartRow['P_BAESONG_PRICE'];
								$strBaesongPrice		= "(착불:" . getCurMark() . getCurToPrice($strBaesongPrice) . getCurMark2() . ")";
							endif;
						endif;

						$strOrderCartHtml .= "	<tr>";
						$strOrderCartHtml .= "		<td class=\"prodInfo\" style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">";
						$strOrderCartHtml .= "			<img src=\"".$S_SITE_URL.$cartRow[PM_REAL_NAME]."\" style=\"width:50px;\"/>";
						$strOrderCartHtml .= "			<ul>";
						$strOrderCartHtml .= "				<li>".$cartRow[P_NAME].$strProdEventText.$strBaesongPrice."</li>";
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
						
						$strOrderCartHtml .= "		<br><a href=\"".$strOrderDeliveryUrl."\" target=\"_blank\">".$LNG_TRANS_CHAR["OW00109"]."</a>";
						$strOrderCartHtml .= "		</td>";
						if ($intCartCnt == 0){
							$strOrderCartHtml .= "		<td style=\"padding: 5px;border:1px solid #c5c5c5\" rowspan=\"".$intCartTotal."\">".getCurMark($orderRow[O_USE_CUR]).getCurToPrice($aryShopInfo['SHOP_DELIVERY_PRICE'],$orderRow[O_USE_LNG]).getCurMark($orderRow[O_USE_CUR]);
							if ($aryShopInfo[0]['SH_NO']>0){
								$strOrderCartHtml .= "<br>(".$aryShopInfo[0]['SH_COM_NAME'].")";
							}
							$strOrderCartHtml .= "		</td>";
						}
						$strOrderCartHtml .= "	</tr>";
			
						$intCartCnt++;
					}
				}
			}
			$strOrderCartHtml .= "</table>";
//			echo $strOrderCartHtml;

			$strOrderInfoHtml = "<br><br>";

			$strOrderInfoHtml .= "<table style=\"width:100%;margin:0 auto;border-collapse: collapse;\">";
			$strOrderInfoHtml .= "	<tr>";
			$strOrderInfoHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00017"]."</th>";
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

			if ($orderRow["O_USE_LNG"] == "KR"){
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
			
//			echo $strOrderInfoHtml;
		break;

	}
?>