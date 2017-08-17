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
		case "orderSend":
						
			$orderMgr->setOC_LIST_ARY("N");
			$orderMgr->setO_NO($intO_NO);
			$orderRow = $orderMgr->getOrderView($db);
			
			$intCartTotal= $orderMgr->getOrderCartTotal($db);
			$orderMgr->setPageLine($intCartTotal);
			$orderMgr->setLimitFirst(0);

			$cartResult = $orderMgr->getOrderCartList($db);

			/* 가상계좌 은행명 */
			if ($orderRow['O_USE_LNG'] == "KR"){
				if ($orderRow['O_PG'] == "K"){
					$aryTBank = getCommCodeList("BANK2");
					
					$strReturnBankName = $aryTBank[$orderRow['O_BANK']];
				}

				if ($orderRow['O_PG'] == "A"){
					$strReturnBankName = $S_ARY_RETURN_BANK[$orderRow['O_BANK']];
				}
			}
			/* 가상계좌 은행명 */
			$aryBank = getCommCodeList("BANK");

			if ($S_SITE_LNG != "KR"){
				$aryCountryList		= getCountryList();			
				$aryCountryState	= getCommCodeList("STATE","");
				$strDeliveryState	= $orderRow[O_B_STATE];
				if ($orderRow[O_B_COUNTRY] == "US") $strDeliveryState = $aryCountryList[$orderRow[O_B_STATE]];
			}		

			$strOrderCartHtml  = "";
			$strOrderCartHtml .= "<table style=\"width:100%;margin:0 auto;border-collapse: collapse;\">\r\n";
			$strOrderCartHtml .= "	<tr>\r\n";
			$strOrderCartHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00001"]."</th>\r\n";
			$strOrderCartHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00002"]."</th>\r\n";
			$strOrderCartHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00003"]."</th>\r\n";
			$strOrderCartHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00004"]."</th>\r\n";
			$strOrderCartHtml .= "	</tr>\r\n";
			
			
			if ($intCartTotal == 0){
				$strOrderCartHtml .= "<tr>\r\n";
				$strOrderCartHtml .= "		<td colspan=\"4\">".$LNG_TRANS_CHAR["OS00001"]."</td>\r\n";
				$strOrderCartHtml .= "</tr>\r\n";
			} else {
				$intCartPrice = $intCartPriceTotal = $intCartPointTotal = 0;
				while ($cartRow = mysql_fetch_array($cartResult)){
					
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


					//$strProdEventText = "";							
					//if ($cartRow[P_EVENT_UNIT] && $cartRow[P_EVENT]){
					//	if ($cartRow[P_EVENT_UNIT] == "%") $strProdEventText = "(".callLangTrans($LNG_TRANS_CHAR["OS00002"],array($cartRow[P_EVENT],"%")).")";
					//	else $strProdEventText = "(".$S_SITE_CUR." ".callLangTrans($LNG_TRANS_CHAR["OS00002"],array($cartRow[P_EVENT],"")).")";
					//}
											
					if (substr($cartRow[PM_REAL_NAME],0,4) == "http") $strProdImgUrl = $cartRow[PM_REAL_NAME];
					else $strProdImgUrl = $S_SITE_URL.$cartRow[PM_REAL_NAME];

					$strOrderCartHtml .= "	<tr>\r\n";
					$strOrderCartHtml .= "		<td class=\"prodInfo\" style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">\r\n";
					$strOrderCartHtml .= "			<img src=\"".$strProdImgUrl."\" style=\"width:50px;\"/>\r\n"; //상품이미지
					$strOrderCartHtml .= "			<ul>\r\n";
					$strOrderCartHtml .= "				<li>".$cartRow[P_NAME].$strProdEventText.$strBaesongPrice."</li>\r\n"; // 
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
						$strOrderCartHtml .= "			".getCurMark("USD")." <strong class=\"priceBoldGray\">".getCurToPrice($cartRow[OC_CUR_PRICE],"US")."</strong>\r\n";
						$strOrderCartHtml .= "(".$S_SITE_CUR_MARK1.getCurToPrice($cartRow[OC_CUR_PRICE],$orderRow[O_USE_LNG]).")";
					} else {
						$strOrderCartHtml .= "			".getCurMark($orderRow[O_USE_CUR])." <strong class=\"priceBoldGray\">".getCurToPrice($cartRow[OC_CUR_PRICE],$orderRow[O_USE_LNG])."</strong>\r\n";
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
						$strOrderCartHtml .= getCurMark("USD")." <strong class=\"priceOrange\">".getCurToPrice($intCartPrice,"US")."</strong>\r\n";
						$strOrderCartHtml .= "(".$S_SITE_CUR_MARK1.getCurToPrice($intCartPrice,$orderRow[O_USE_LNG]).")";
					} else {
						$strOrderCartHtml .= getCurMark($orderRow[O_USE_CUR])." <strong class=\"priceOrange\">".getCurToPrice($intCartPrice,$orderRow[O_USE_LNG])."</strong>\r\n";
					}
					
					$strOrderCartHtml .= "		</td>\r\n";
					$strOrderCartHtml .= "	</tr>\r\n";
				}
			}
			$strOrderCartHtml .= "</table>\r\n";

			$strOrderCartPriceHtml  = "";
			if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){
				$strOrderCartPriceHtml .= "<span>".$LNG_TRANS_CHAR["OW00002"].":</span> ".getCurMark("USD")." <strong class=\"priceBoldGray\">".getCurToPrice($orderRow[O_TOT_CUR_PRICE],"US")."</strong>\r\n";
				$strOrderCartPriceHtml .= "(".$S_SITE_CUR_MARK1.getCurToPrice($orderRow[O_TOT_CUR_PRICE],$orderRow[O_USE_LNG]).")";
				
				if ($S_SITE_TAX == "Y"){
					$strOrderCartPriceHtml .= " + <span>".$LNG_TRANS_CHAR["OW00008"].":</span> ".getCurMark("USD")." <strong class=\"priceBoldGray\">".getCurToPrice($orderRow[O_TAX_CUR_PRICE],"US")."</strong>\r\n";

					$strOrderCartPriceHtml .= "(".$S_SITE_CUR_MARK1.getCurToPrice($orderRow[O_TAX_CUR_PRICE],$orderRow[O_USE_LNG]).")";
				}
				
				if ($S_PG_COMMISSION == "Y"){
					if ($orderRow['O_TOT_PG_COMMISSION'] > 0){
						$strOrderCartPriceHtml .= " + <span>".$LNG_TRANS_CHAR["OW00112"].":</span> ".getCurMark("USD")." <strong class=\"priceBoldGray\">".getCurToPrice($orderRow[O_TOT_PG_CUR_COMMISSION],"US")."</strong>";

						$strOrderCartPriceHtml .= "(".$S_SITE_CUR_MARK1.getCurToPrice($orderRow[O_TOT_PG_CUR_COMMISSION],$orderRow[O_USE_LNG]).")\r\n";
					}
				}

				$strOrderCartPriceHtml .= " + <span>".$LNG_TRANS_CHAR["PW00012"].":</span> ".getCurMark("USD")." <strong class=\"priceBoldGray\">".getCurToPrice($orderRow[O_TOT_DELIVERY_CUR_PRICE],"US")."</strong>\r\n";
				
				$strOrderCartPriceHtml .= "(".$S_SITE_CUR_MARK1.getCurToPrice($orderRow[O_TOT_DELIVERY_CUR_PRICE],$orderRow[O_USE_LNG]).")";


				if ($orderRow[O_TOT_MEM_DISCOUNT_PRICE] > 0 ){
					$strOrderCartPriceHtml .= "	- <span>".$LNG_TRANS_CHAR["OW00070"].":</span> ".getCurMark("USD")." <strong class=\"priceBoldGray\">".getCurToPrice($orderRow[O_TOT_MEM_DISCOUNT_CUR_PRICE],"US")."</strong>\r\n";

					$strOrderCartPriceHtml .= "(".$S_SITE_CUR_MARK1.getCurToPrice($orderRow[O_TOT_MEM_DISCOUNT_CUR_PRICE],$orderRow[O_USE_LNG]).")";
				}
				
				if ($orderRow[O_USE_POINT] > 0){
					$strOrderCartPriceHtml .= "	- <span>".$LNG_TRANS_CHAR["OW00045"].":</span> <strong class=\"priceBoldGray\">".getCurToPrice($orderRow[O_USE_CUR_POINT],$orderRow[O_USE_LNG])."</strong>\r\n";
				}

				if ($orderRow[O_USE_COUPON] > 0){
					$strOrderCartPriceHtml .= "	- <span>".$LNG_TRANS_CHAR["OW00081"].":</span> ".getCurMark("USD")." <strong class=\"priceBoldGray\">".getCurToPrice($orderRow[O_USE_CUR_COUPON],"US")."</strong>\r\n";

					$strOrderCartPriceHtml .= "(".$S_SITE_CUR_MARK1.getCurToPrice($orderRow[O_USE_CUR_COUPON],$orderRow[O_USE_LNG]).")";
				}

				$strOrderCartPriceHtml .= "	= <span>".$LNG_TRANS_CHAR["OW00009"].":</span> ".getCurMark("USD")." <strong class=\"priceOrange\">".getCurToPrice($orderRow[O_TOT_CUR_SPRICE],"US")."</strong>\r\n";

				$strOrderCartPriceHtml .= "(".$S_SITE_CUR_MARK1.getCurToPrice($orderRow[O_TOT_CUR_SPRICE],$orderRow[O_USE_LNG]).")";


			} else {
				$strOrderCartPriceHtml .= "<span>".$LNG_TRANS_CHAR["OW00002"].":</span> ".getCurMark($orderRow[O_USE_CUR])." <strong class=\"priceBoldGray\">".getCurToPrice($orderRow[O_TOT_CUR_PRICE],$orderRow[O_USE_LNG])."</strong>\r\n";
				
				if ($S_SITE_TAX == "Y"){
					$strOrderCartPriceHtml .= " + <span>".$LNG_TRANS_CHAR["OW00008"].":</span> ".getCurMark($orderRow[O_USE_CUR])." <strong class=\"priceBoldGray\">".getCurToPrice($orderRow[O_TAX_CUR_PRICE],$orderRow[O_USE_LNG])."</strong>\r\n";
				}

				if ($S_PG_COMMISSION == "Y"){
					if ($orderRow['O_TOT_PG_COMMISSION'] > 0){
						$strOrderCartPriceHtml .= " + <span>".$LNG_TRANS_CHAR["OW00112"].":</span> ".getCurMark($orderRow[O_USE_CUR])." <strong class=\"priceBoldGray\">".getCurToPrice($orderRow[O_TOT_PG_CUR_COMMISSION],$orderRow[O_USE_LNG])."</strong>\r\n";
					}
				}
				
				$strOrderCartPriceHtml .= " + <span>".$LNG_TRANS_CHAR["PW00012"].":</span> ".getCurMark($orderRow[O_USE_CUR])." <strong class=\"priceBoldGray\">".getCurToPrice($orderRow[O_TOT_DELIVERY_CUR_PRICE],$orderRow[O_USE_LNG])."</strong>\r\n";
				
				if ($orderRow[O_TOT_MEM_DISCOUNT_PRICE] > 0 ){
					$strOrderCartPriceHtml .= "	- <span>".$LNG_TRANS_CHAR["OW00070"].":</span> ".getCurMark($orderRow[O_USE_CUR])." <strong class=\"priceBoldGray\">".getCurToPrice($orderRow[O_TOT_MEM_DISCOUNT_CUR_PRICE],$orderRow[O_USE_LNG])."</strong>\r\n";
				}
				
				if ($orderRow[O_USE_POINT] > 0){
					$strOrderCartPriceHtml .= "	- <span>".$LNG_TRANS_CHAR["OW00045"].":</span> <strong class=\"priceBoldGray\">".getCurToPrice($orderRow[O_USE_CUR_POINT],$orderRow[O_USE_LNG])."</strong>\r\n";
				}

				if ($orderRow[O_USE_COUPON] > 0){
					$strOrderCartPriceHtml .= "	- <span>".$LNG_TRANS_CHAR["OW00081"].":</span> ".getCurMark($orderRow[O_USE_CUR])." <strong class=\"priceBoldGray\">".getCurToPrice($orderRow[O_USE_CUR_COUPON],$orderRow[O_USE_LNG])."</strong>\r\n";
				}

				$strOrderCartPriceHtml .= "	= <span>".$LNG_TRANS_CHAR["OW00009"].":</span> ".getCurMark($orderRow[O_USE_CUR])." <strong class=\"priceOrange\">".getCurToPrice($orderRow[O_TOT_CUR_SPRICE],$orderRow[O_USE_LNG])."</strong>\r\n";
			}
			

			$strOrderInfoHtml = "<br><br>\r\n";

			$strOrderInfoHtml .= "<table style=\"width:100%;margin:0 auto;border-collapse: collapse;\">\r\n";
			$strOrderInfoHtml .= "	<tr>\r\n";
			$strOrderInfoHtml .= "		<th style=\"width:200px;padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00015"]."</th>\r\n";
			$strOrderInfoHtml .= "		<td style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">".$orderRow[O_J_NAME]."</td>\r\n";
			$strOrderInfoHtml .= "	</tr>\r\n";
			$strOrderInfoHtml .= "	<tr>\r\n";
			$strOrderInfoHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00016"]."</th>\r\n";
			$strOrderInfoHtml .= "		<td style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">".$orderRow[O_J_PHONE]."</td>\r\n";
			$strOrderInfoHtml .= "	</tr>\r\n";
			$strOrderInfoHtml .= "	<tr>\r\n";
			$strOrderInfoHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00010"]."</th>\r\n";
			$strOrderInfoHtml .= "		<td style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">".$orderRow[O_J_HP]."</td>\r\n";
			$strOrderInfoHtml .= "	</tr>\r\n";
			$strOrderInfoHtml .= "	<tr>\r\n";
			$strOrderInfoHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00011"]."</th>\r\n";
			$strOrderInfoHtml .= "		<td style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">".$orderRow[O_J_MAIL]."</td>\r\n";
			$strOrderInfoHtml .= "	</tr>\r\n";
			$strOrderInfoHtml .= "</table>\r\n";
			$strOrderInfoHtml .= "<br>\r\n";
			$strOrderInfoHtml .= "<table style=\"width:100%;margin:0 auto;border-collapse: collapse;\">\r\n";
			$strOrderInfoHtml .= "	<tr>\r\n";
			$strOrderInfoHtml .= "		<th style=\"width:200px;padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00017"]."</th>\r\n";
			$strOrderInfoHtml .= "		<td style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">".$orderRow[O_B_NAME]."</td>\r\n";
			$strOrderInfoHtml .= "	</tr>\r\n";
			$strOrderInfoHtml .= "	<tr>\r\n";
			$strOrderInfoHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00018"]."</th>\r\n";
			$strOrderInfoHtml .= "		<td style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">".$orderRow[O_B_PHONE]."</td>\r\n";
			$strOrderInfoHtml .= "	</tr>\r\n";
			$strOrderInfoHtml .= "	<tr>\r\n";
			$strOrderInfoHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00019"]."</th>\r\n";
			$strOrderInfoHtml .= "		<td style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">".$orderRow[O_B_HP]."</td>\r\n";
			$strOrderInfoHtml .= "	</tr>\r\n";
			//$strOrderInfoHtml .= "	<tr>\r\n";
			//$strOrderInfoHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00020"]."</th>\r\n";
			//$strOrderInfoHtml .= "		<td style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">".$orderRow[O_B_MAIL]."</td>\r\n";
			//$strOrderInfoHtml .= "	</tr>\r\n";

			if ($S_SITE_LNG == "KR"){
				$strOrderInfoHtml .= "	<tr>\r\n";
				$strOrderInfoHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00022"]."</th>\r\n";
				$strOrderInfoHtml .= "		<td style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">[".$orderRow[O_B_ZIP]."] ".$orderRow[O_B_ADDR1]." ".$orderRow[O_B_ADDR2]."</td>\r\n";
				$strOrderInfoHtml .= "	</tr>\r\n";
			} else {
				$strOrderInfoHtml .= "	<tr>\r\n";
				$strOrderInfoHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00012"]."</th>\r\n";
				$strOrderInfoHtml .= "		<td style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">".$orderRow[O_B_ZIP]."</td>\r\n";
				$strOrderInfoHtml .= "	</tr>\r\n";
				$strOrderInfoHtml .= "	<tr>\r\n";
				$strOrderInfoHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00022"]."</th>\r\n";
				$strOrderInfoHtml .= "		<td style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">".$orderRow[O_B_ADDR1]." ".$orderRow[O_B_ADDR2]." ".$orderRow[O_B_CITY]." ".$strDeliveryState." ".$aryCountryList[$orderRow[O_B_COUNTRY]]."</td>\r\n";
				$strOrderInfoHtml .= "	</tr>\r\n";			
			}

			if ($orderRow[O_B_MEMO]){
				$strOrderInfoHtml .= "	<tr>\r\n";
				$strOrderInfoHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00028"]."</th>\r\n";
				$strOrderInfoHtml .= "		<td style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">".$orderRow[O_B_MEMO]."</td>\r\n";
				$strOrderInfoHtml .= "	</tr>\r\n";
			}

			$strOrderInfoHtml .= "</table>\r\n";
			$strOrderInfoHtml .= "<br>\r\n";
			$strOrderInfoHtml .= "<table style=\"width:100%;margin:0 auto;border-collapse: collapse;\">\r\n";
			$strOrderInfoHtml .= "	<tr>\r\n";
			$strOrderInfoHtml .= "		<th style=\"width:200px;padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00030"]."</th>\r\n";
			$strOrderInfoHtml .= "		<td style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">".$S_ARY_SETTLE_TYPE[$orderRow[O_SETTLE]]."</td>\r\n";
			$strOrderInfoHtml .= "	</tr>\r\n";

			//포인트 사용안함 2014.06.10
		   // if ($orderRow[M_NO]){
			//	$strOrderInfoHtml .= "	<tr>\r\n";
			//	$strOrderInfoHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00032"]."</th>\r\n";
			//	$strOrderInfoHtml .= "		<td style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\"><strong //class=\"priceBoldGray\">".getCurToPrice($orderRow[O_TOT_POINT],$orderRow[O_USE_LNG])."</strong></td>\r\n";
			//	$strOrderInfoHtml .= "	</tr>\r\n";
			//}
			$strOrderInfoHtml .= "	<tr>\r\n";
			$strOrderInfoHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00046"]."</th>\r\n";
			$strOrderInfoHtml .= "		<td style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">".$S_ARY_SETTLE_STATUS[$orderRow[O_STATUS]]."</td>\r\n";
			$strOrderInfoHtml .= "	</tr>\r\n";
			
			if ($orderRow[O_SETTLE] == "T" && $orderRow[O_STATUS] == "J"){
				$strOrderInfoHtml .= "	<tr>\r\n";
				$strOrderInfoHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00035"]."</th>\r\n";
				$strOrderInfoHtml .= "		<td style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">\r\n";
				$strOrderInfoHtml .= "			[".$strReturnBankName."] ".$orderRow[O_BANK_ACC]."";
				$strOrderInfoHtml .= "			입금마감시간 : .".SUBSTR($orderRow[O_BANK_VALID_DT],0,4)."/ ".SUBSTR($orderRow[O_BANK_VALID_DT],4,2)."/ "; 
				$strOrderInfoHtml .= SUBSTR($orderRow[O_BANK_VALID_DT],6,2)."/"; 
				$strOrderInfoHtml .= "		</td>\r\n";
				$strOrderInfoHtml .= "	</tr>\r\n";
			}
			
			if ($orderRow[O_SETTLE] == "B"){
				$strOrderInfoHtml .= "	<tr>\r\n";
				$strOrderInfoHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00111"]."</th>\r\n";
				$strOrderInfoHtml .= "		<td style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">\r\n";
				$strOrderInfoHtml .= "			".$LNG_TRANS_CHAR["OW00036"]." : ".$orderRow[O_BANK_ACC]."";
				$strOrderInfoHtml .= "			<BR> ".$LNG_TRANS_CHAR["OW00024"]." : ".$orderRow[O_BANK_NAME];
				$strOrderInfoHtml .= "		</td>\r\n";
				$strOrderInfoHtml .= "	</tr>\r\n";
			}

				
			$strOrderInfoHtml .= "</table>\r\n";
		break;		
		
		case "orderDeliverySend":
			/*배송회사*/
			$aryDeliveryCom = getCommCodeList("DELIVERY","Y");
			$aryDeliveryUrl = getDeliveryUrlList();
			if ($shopOrderRow[SO_DELIVERY_NUM] && $shopOrderRow[SO_DELIVERY_COM]){
				$strOrderDeliveryUrl = str_replace("{dev_no}",$shopOrderRow[SO_DELIVERY_NUM],$aryDeliveryUrl[$shopOrderRow[SO_DELIVERY_COM]]);
			}

			if ($S_SITE_LNG != "KR"){
				$aryCountryList		= getCountryList();			
				$aryCountryState	= getCommCodeList("STATE","");
				$strDeliveryState	= $orderRow[O_B_STATE];
				if ($orderRow[O_B_COUNTRY] == "US") $strDeliveryState = $aryCountryList[$orderRow[O_B_STATE]];
			}		

			$strOrderCartHtml  = "";
			$strOrderCartHtml .= "<table style=\"width:100%;margin:0 auto;border-collapse: collapse;\">\r\n";
			$strOrderCartHtml .= "	<tr>\r\n";
			$strOrderCartHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00001"]."</th>\r\n";
			$strOrderCartHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00002"]."</th>\r\n";
			$strOrderCartHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00003"]."</th>\r\n";
			$strOrderCartHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00004"]."</th>\r\n";
			$strOrderCartHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["PW00012"]."</th>\r\n";
			$strOrderCartHtml .= "	</tr>\r\n";
			
			
			if ($intCartTotal == 0){
				$strOrderCartHtml .= "<tr>\r\n";
				$strOrderCartHtml .= "		<td colspan=\"5\">".$LNG_TRANS_CHAR["OS00001"]."</td>\r\n";
				$strOrderCartHtml .= "</tr>\r\n";
			} else {
				$intCartCnt = $intCartPrice = $intCartPriceTotal = $intCartPointTotal = 0;
				while ($cartRow = mysql_fetch_array($cartResult["result"])){
					
					if ($cartRow["SOC_STATUS"] != "C"){
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

						$strOrderCartHtml .= "	<tr>\r\n";
						$strOrderCartHtml .= "		<td class=\"prodInfo\" style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">\r\n";
						$strOrderCartHtml .= "			<img src=\"".$S_SITE_URL.$cartRow[PM_REAL_NAME]."\" style=\"width:50px;\"/>\r\n";
						$strOrderCartHtml .= "			<ul>\r\n";
						$strOrderCartHtml .= "				<li>".$cartRow[P_NAME].$strProdEventText."</li>\r\n";
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
							$strOrderCartHtml .= "			".getCurMark("USD")." <strong class=\"priceBoldGray\">".getCurToPrice($cartRow[OC_CUR_PRICE],"US")."</strong>\r\n";
							$strOrderCartHtml .= "(".$S_SITE_CUR_MARK1.getCurToPrice($cartRow[OC_CUR_PRICE],$orderRow[O_USE_LNG]).")";
						} else {
							$strOrderCartHtml .= "			".getCurMark($orderRow[O_USE_CUR])." <strong class=\"priceBoldGray\">".getCurToPrice($cartRow[OC_CUR_PRICE],$orderRow[O_USE_LNG])."</strong>\r\n";
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
							$strOrderCartHtml .= getCurMark("USD")." <strong class=\"priceOrange\">".getCurToPrice($intCartPrice,"US")."</strong>\r\n";
							$strOrderCartHtml .= "(".$S_SITE_CUR_MARK1.getCurToPrice($intCartPrice,$orderRow[O_USE_LNG]).")";
						} else {
							$strOrderCartHtml .= getCurMark($orderRow[O_USE_CUR])." <strong class=\"priceOrange\">".getCurToPrice($intCartPrice,$orderRow[O_USE_LNG])."</strong>\r\n";
						}
						
						$strOrderCartHtml .= "		</td>\r\n";
						if ($intCartCnt == 0){
							$strOrderCartHtml .= "		<td style=\"padding: 5px;border:1px solid #c5c5c5\" rowspan=\"".$intCartTotal."\">".getCurMark($orderRow[O_USE_CUR]).getCurToPrice($cartRow['SO_TOT_DELIVERY_CUR_PRICE'],$orderRow[O_USE_LNG]).getCurMark($orderRow[O_USE_CUR]);
							$strOrderCartHtml .= "		</td>\r\n";
						}
						$strOrderCartHtml .= "	</tr>\r\n";
			
						$intCartCnt++;
					}
				}
			}
			$strOrderCartHtml .= "</table>\r\n";


			$strOrderInfoHtml = "<br><br>\r\n";

			$strOrderInfoHtml .= "<table style=\"width:100%;margin:0 auto;border-collapse: collapse;\">\r\n";
			$strOrderInfoHtml .= "	<tr>\r\n";
			$strOrderInfoHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00098"]."/".$LNG_TRANS_CHAR["OW00099"]."</th>\r\n";
			$strOrderInfoHtml .= "		<td style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">".$aryDeliveryCom[$shopOrderRow['SO_DELIVERY_COM']]."/<a href=\"".$strOrderDeliveryUrl."\" target=\"_blank\">".$shopOrderRow['SO_DELIVERY_NUM']."</a></td>\r\n";
			$strOrderInfoHtml .= "	</tr>\r\n";

			$strOrderInfoHtml .= "	<tr>\r\n";
			$strOrderInfoHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00017"]."</th>\r\n";
			$strOrderInfoHtml .= "		<td style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">".$orderRow[O_B_NAME]."</td>\r\n";
			$strOrderInfoHtml .= "	</tr>\r\n";
			$strOrderInfoHtml .= "	<tr>\r\n";
			$strOrderInfoHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00018"]."</th>\r\n";
			$strOrderInfoHtml .= "		<td style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">".$orderRow[O_B_PHONE]."</td>\r\n";
			$strOrderInfoHtml .= "	</tr>\r\n";
			$strOrderInfoHtml .= "	<tr>\r\n";
			$strOrderInfoHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00019"]."</th>\r\n";
			$strOrderInfoHtml .= "		<td style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">".$orderRow[O_B_HP]."</td>\r\n";
			$strOrderInfoHtml .= "	</tr>\r\n";

			if ($orderRow["O_USE_LNG"] == "KR"){
				$strOrderInfoHtml .= "	<tr>\r\n";
				$strOrderInfoHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00022"]."</th>\r\n";
				$strOrderInfoHtml .= "		<td style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">[".$orderRow[O_B_ZIP]."] ".$orderRow[O_B_ADDR1]." ".$orderRow[O_B_ADDR2]."</td>\r\n";
				$strOrderInfoHtml .= "	</tr>\r\n";
			} else {
				$strOrderInfoHtml .= "	<tr>\r\n";
				$strOrderInfoHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00012"]."</th>\r\n";
				$strOrderInfoHtml .= "		<td style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">".$orderRow[O_B_ZIP]."</td>\r\n";
				$strOrderInfoHtml .= "	</tr>\r\n";
				$strOrderInfoHtml .= "	<tr>\r\n";
				$strOrderInfoHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00022"]."</th>\r\n";
				$strOrderInfoHtml .= "		<td style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">".$orderRow[O_B_ADDR1]." ".$orderRow[O_B_ADDR2]." ".$orderRow[O_B_CITY]." ".$strDeliveryState." ".$aryCountryList[$orderRow[O_B_COUNTRY]]."</td>\r\n";
				$strOrderInfoHtml .= "	</tr>\r\n";			
			}

			if ($orderRow[O_B_MEMO]){
				$strOrderInfoHtml .= "	<tr>\r\n";
				$strOrderInfoHtml .= "		<th style=\"padding: 5px;border:1px solid #c5c5c5;background: #f7f7f7;\">".$LNG_TRANS_CHAR["OW00028"]."</th>\r\n";
				$strOrderInfoHtml .= "		<td style=\"padding: 5px;text-align:left;border:1px solid #c5c5c5\">".$orderRow[O_B_MEMO]."</td>\r\n";
				$strOrderInfoHtml .= "	</tr>\r\n";
			}

			$strOrderInfoHtml .= "</table>\r\n";

		break;

	}
?>