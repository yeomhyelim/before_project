<?
			if($S_ALL_DISCOUNT_USE == "Y"):
				$strProdAllDiscount		= $S_ALL_DISCOUNT_VAL;
				$aryProdAllDiscount		= "";
				$aryTemp				= explode("/", $strProdAllDiscount);
				foreach($aryTemp as $key => $data):
					list($strVal1, $strPrice)	= explode(":", $data);
					list($strStart, $strEnd)	= explode("~", $strVal1);
					
					if(!$strStart)	{ $strStart	= 0;		}
					if(!$strEnd)	{ $strEnd	= 9999999;	}

					$aryProdAllDiscount[$key]['rate']	= $strPrice;
					$aryProdAllDiscount[$key]['start']	= $strStart;
					$aryProdAllDiscount[$key]['end']	= $strEnd;
				endforeach;
			endif;

			$strCartProdListHtml = "";
			$strCartProdDiscountHtml = "";
			if ($S_FIX_PRODUCT_CART_POP_USE == "Y"){
				
				$productMgr->setM_NO($g_member_no);
				$productMgr->setPB_KEY($g_cart_prikey);
				
				$intCartTotal	= $productMgr->getProdBasketTotal($db);
				$productMgr->setPageLine($intCartTotal);

				$productMgr->setLimitFirst(0);
				$cartResult = $productMgr->getProdBasketList($db);
				
				$intCartCount = 0;
				$intCartPrice = $intCartPriceTotal = $intCartDeliveryPriceTotal = 0;
				for($i=1;$i<=5;$i++){
					$aryDeliveryPrice[$i] = 0;
				}

				while ($cartRow = mysql_fetch_array($cartResult)){
					/* 2013.06.12 할인가격 보여주기 */
					$cartRow[PB_PRICE] = getProdDiscountPrice($cartRow,"2",$cartRow['PB_PRICE']);
					/* 2013.06.12 할인가격 보여주기 */

					/* 통합수량할인적용 */
					if ($S_ALL_DISCOUNT_USE == "Y"){
						$cartRow[PB_PRICE]	= getProdAllDiscount($cartRow[PB_PRICE],$cartRow[PB_QTY]);
					}
						
					$intCartPrice		= ($cartRow[PB_PRICE] * $cartRow[PB_QTY]) + $cartRow[PB_ADD_OPT_PRICE];
					$intCartPriceTotal += $intCartPrice;
					if ($S_DELIVERY_MTH == "G" && $cartRow[P_BAESONG_TYPE] != "2"){
						$intCartDeliveryPriceTotal += $intCartPrice;
					}
					$productMgr->setPB_NO($cartRow[PB_NO]);
					$aryProdCartAddOptList = $productMgr->getProdBasketAddList($db);

					/* 해외배송 : 수량별배송을 사용할 경우 맨처음 주문 상품의 배송비에 기본배송비를 더하기 위해 CART_COUNT를 배열 삽입 */
					if ($S_SITE_LNG != "KR"){
						if ($S_DELIVERY_FOR_MTH == "B"){
							if ($cartRow['P_BAESONG_TYPE'] == "4"){
								$cartRow['CART_COUNT'] = $intCartCount + 1;		
							}
						}
					}
					
					/* 배송비설정*/
					$intDeliveryPrice = getProdDeliveryPrice($cartRow,$SHOP_ARY_DELIVERY,$intCartPrice,$cartRow[PB_QTY],$aryProdBasketShopList[$cartRow[P_SHOP_NO]]);
					$aryDeliveryPrice[$cartRow[P_BAESONG_TYPE]] += $intDeliveryPrice;

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
					else:
						if ($S_DELIVERY_FOR_MTH == "B"){
							if ($cartRow['P_BAESONG_TYPE'] == "4"){
								$strBaesongPrice = $LNG_TRANS_CHAR["PW00012"]." : ".getCurMark()." ".getCurToPrice($intDeliveryPrice).getCurMark2();
							}
						}
					endif;

					$strCartOptAttrVal = "";
					for($kk=1;$kk<=10;$kk++){
						if ($cartRow["PB_OPT_ATTR".$kk]){
							$strCartOptAttrVal .= "/".$cartRow["PB_OPT_ATTR".$kk];
						}
					}
					$strCartOptAttrVal = SUBSTR($strCartOptAttrVal,1);
												
					$strProdEventText = "";							
					if ($cartRow[P_EVENT_UNIT] && $cartRow[P_EVENT]){
						if ($cartRow[P_EVENT_UNIT] == "%") $strProdEventText = "(".callLangTrans($LNG_TRANS_CHAR["OS00002"],array($cartRow[P_EVENT],"%")).")";
						else $strProdEventText = "(".$S_SITE_CUR." ".callLangTrans($LNG_TRANS_CHAR["OS00002"],array($cartRow[P_EVENT],"")).")";
					}
					
					$strCartProdAddOptName = "";
					if (is_array($aryProdCartAddOptList)){
						for($k=0;$k<sizeof($aryProdCartAddOptList);$k++){
							$strCartProdAddOptName .= $aryProdCartAddOptList[$k]['PBA_OPT_NM']."/";
						}
						
						if ($strCartProdAddOptName) $strCartProdAddOptName = substr($strCartProdAddOptName,0,strlen($strCartProdAddOptName)-1);
					}

					$strCartProdPrice = getCurMark()." ".getCurToPrice($cartRow[PB_PRICE]).getCurMark2();
					if ($cartRow[PB_ADD_OPT_PRICE] > 0){
						$strCartProdPrice .= "<br>".$LNG_TRANS_CHAR['OW00007'].":".getCurMark()." ".getCurToPrice($cartRow[PB_ADD_OPT_PRICE]).getCurMark2();
					}
					
					$strCartProdQty = " ".$cartRow['PB_QTY'].$LNG_TRANS_CHAR["CW00078"];
					if ($S_ALL_DISCOUNT_USE == "Y"){
						foreach($aryProdAllDiscount as $key => $data){
							if ($cartRow[PB_QTY] >= $data['start'] && $cartRow[PB_QTY] <= $data['end']){
								$strCartProdQty .= " {$data['rate']}% OFF";
								break;
							}
						}
					}
					
					if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){
						$strCartProdPrice  = getCurMark("USD")." ".getCurToPrice($cartRow[PB_PRICE],"US").getCurMark2("USD");
						$strCartProdPrice .= "(".$S_SITE_CUR_MARK1." ".getCurToPrice($cartRow[PB_PRICE]).")";
						
						if ($cartRow[PB_ADD_OPT_PRICE] > 0){
							$strCartProdPrice .= "<br>".$LNG_TRANS_CHAR['OW00007'].":".getCurMark("USD")." ".getCurToPrice($cartRow[PB_ADD_OPT_PRICE],"US").getCurMark2("USD");
							$strCartProdPrice .= "(".$S_SITE_CUR_MARK1." ".getCurToPrice($cartRow[PB_ADD_OPT_PRICE]).")";
						}
					}

					$strCartProdListHtml .=" 
						<tr>
							<td><input type=\"checkbox\" id=\"popCartNo[]\" name=\"popCartNo[]\" value=\"{$cartRow[PB_NO]}\"/></td>
							<td class=\"prodImg\">
								<img src=\"{$cartRow['PM_REAL_NAME']}\" alt=\"product_images\"/>
							</td>
							<td class=\"prodInfo\">
								<p class=\"title\">{$cartRow['P_NAME']}{$strProdEventText} {$strCartOptAttrVal} {$strCartProdAddOptName}</p>
								<p class=\"qty\">
									<dl>
										<dd><input type=\"input\" id=\"cartQty{$cartRow[PB_NO]}\" name=\"cartQty{$cartRow[PB_NO]}\" value=\"{$cartRow[PB_QTY]}\"  style=\"text-align:center;\"/></dd>
										<dd>
											<a href=\"javascript:goPopCartQtyUpMinus('cart',1,{$cartRow[PB_NO]});\" class=\"btnUp\"><img src=\"/himg/product/A0001/btn_prod_cnt_up.gif\"/></a>
											<a href=\"javascript:goPopCartQtyUpMinus('cart',-1,{$cartRow[PB_NO]});\" class=\"btnDown\" ><img src=\"/himg/product/A0001/btn_prod_cnt_down.gif\"/></a>
										</dd>
										<dd><a href=\"javascript:goPopCartDel({$cartRow[PB_NO]});\" class=\"btnDel\">[x]</a></dd>
									</dl>
								</p>
								<p class=\"price\">{$strCartProdPrice}</p>
							</td>
						</tr>";
					
					if ($S_FIX_ORDER_TOTAL_DISCOUNT_USE == "Y"){
						$strCartProdDiscountHtml .= " 
							<li>
								<input type='hidden' name='discountCartNo[]' id='discountCartNo[]' value='{$cartRow['PB_NO']}'>
								{$cartRow['PB_QTY']}ea.- {$cartRow['P_NAME']}
							</li>";
					}
				}

				/* 배송비설정 */
				if ($S_DELIVERY_MTH == "G") $intDeliveryTotal = 0;
				else $intDeliveryTotal = getCartDeliveryPrice($aryDeliveryPrice,$intCartPriceTotal,$SHOP_ARY_DELIVERY);
				
				if ($S_MALL_TYPE != "R" && $S_SITE_LNG == "KR"){
					$intDeliveryTotal = $intProdBasketDeliveryTotal;
				}
				
				/*부과세포함*/
				$intCartPriceEndTotal = $intCartPriceTotal;
				if ($S_SITE_TAX == "Y"){
					$intCartPriceEndTotal = $intCartPriceEndTotal + ($intCartPriceTotal*0.1);
				}

				$strCartPopTopHtml = "<div class=\"closeWrap\">
						<div class=\"total\">subtotal : ".getCurMark()." ".getCurToPrice($intCartPriceEndTotal).getCurMark2()."</div>
						<div class=\"close\"><a href=\"javascript:goPopCartClose();\">CLOSE</a></div>";
				/*$strCartPopTopHtml .= "
						<div class=\"btnWrap\">
							<a href=\"javascript:goPopCartJumun();\">CheckOut</a>
							<a href=\"javascript:goPopCartDel();\">Delete</a>
						</div>";*/
				
				$strCartPopTopHtml .= "
					</div>";

				$strCartPopHtml  = $strCartPopTopHtml;
				$strCartPopHtml .= "<div class=\"cartTableWrap\">
					<table summary=\"장바구니 상품\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
						<caption>장바구니 상품</caption>
						<colgroup>
							<col width=\"\" />
							<col width=\"\"/>
							<col width=\"\"/>
						</colgroup>
						<tbody>".$strCartProdListHtml."</tbody>
					</table>
				</div>";
				$strCartPopHtml  .= $strCartPopTopHtml;

				if ($S_FIX_ORDER_TOTAL_DISCOUNT_USE == "Y"){
					
					$param						= "";
					$param['PROD_TOTAL_PRICE']	= $intCartPriceTotal;
					$intCartPriceDiscountRate	= $productMgr->getProdTotalPriceMaxDiscountRate($db,$param);
					$intCartPriceDiscountPrice	= getProdTotalPriceAllDiscount($intCartPriceTotal,$intCartPriceDiscountRate);
					
					if ($intCartPriceDiscountPrice >= 0){
						$param									= "";
						$param['PROD_TOTAL_DISCOUNT_RDATE']		= $intCartPriceDiscountRate;
						$prodTotalNextDiscountInfoRow			= $productMgr->getProdTotalPriceMaxNextDiscountInfo($db,$param);
						
						if ($prodTotalNextDiscountInfoRow){
							$intProdTotalMaxNextAddPrice		= $prodTotalNextDiscountInfoRow['SD_ST_PRICE'] - $intCartPriceTotal;
							$intProdTotalMaxNextAddRate			= $prodTotalNextDiscountInfoRow['SD_RATE'];
						}
						$intCartPriceTotal = $intCartPriceTotal - $intCartPriceDiscountPrice;
					}
					
					$strOrderTotalDiscountHtml = "
						<div class=\"prodInfo\">
							<ul>
								{$strCartProdDiscountHtml}
							</ul>
						</div>
						<div class=\"prodPrice\">
							<p class=\"price\">$".getCurToPrice($intCartPriceEndTotal)."</p>
							<p class=\"priceD\">Discount : $".getCurToPrice($intCartPriceDiscountPrice)."</p>
							<p class=\"priceT\">Total : $".getCurToPrice($intCartPriceTotal)."</p>
						</div>
						";
					if ($intProdTotalMaxNextAddRate > 0){
						$strOrderTotalDiscountHtml .= "
							<div class=\"discount\">
								".callLangTrans($LNG_TRANS_CHAR["OS00087"],array(getCurToPrice($intProdTotalMaxNextAddPrice),$intProdTotalMaxNextAddRate,"$"))."
							</div>";
					}
				}
			}
?>