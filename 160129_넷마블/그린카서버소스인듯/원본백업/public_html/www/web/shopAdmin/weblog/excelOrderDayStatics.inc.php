		<table>
			<tr>
				<th><?=$LNG_TRANS_CHAR["CW00012"] //연도?></th>
				<th><?=$LNG_TRANS_CHAR["CW00013"] //월?></th>
				<th><?=$LNG_TRANS_CHAR["CW00014"] //일?></th>
				<th><?=$LNG_TRANS_CHAR["EW00059"] //결제금액?></th>
				<th><?="사용포인트" //사용포인트?></th>
				<th><?="쿠폰금액" //쿠폰금액?></th>
				<th><?="할인금액" //할인금액?></th>
				<th><?="배송비" //배송비?></th>
				<th><?=$LNG_TRANS_CHAR["EW00060"] //매출금액?></th>
			</tr>
			<?
			if (is_array($aryOrderSaleList)){
				$intTotSprice = $intTotUsePoint = $intTotCouponPrice = $intTotMemDiscountPrice = $intTotDeliveryPrice = $intTotPrice = 0;
				for($i=0;$i<sizeof($aryOrderSaleList);$i++){

					$intTotSprice			+= $aryOrderSaleList[$i][S_TOT_SPRICE];
					$intTotUsePoint			+= $aryOrderSaleList[$i][S_TOT_USE_POINT];
					$intTotCouponPrice		+= $aryOrderSaleList[$i][S_TOT_COUPON];
					$intTotMemDiscountPrice += $aryOrderSaleList[$i][S_TOT_MEM_DISCOUNT_PRICE];
					$intTotDeliveryPrice	+= $aryOrderSaleList[$i][S_TOT_DELIVERY_PRICE];
					$intTotPrice			+= $aryOrderSaleList[$i][S_TOT_PRICE];
					?>
			<tr>
				<td><?=SUBSTR($aryOrderSaleList[$i][S_DATE],0,4)?></td>
				<td><?=SUBSTR($aryOrderSaleList[$i][S_DATE],5,2)?></th>
				<td><?=SUBSTR($aryOrderSaleList[$i][S_DATE],8,2)?></th>
				<td><?=getFormatPrice($aryOrderSaleList[$i][S_TOT_SPRICE],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][S_TOT_USE_POINT],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][S_TOT_COUPON],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][S_TOT_MEM_DISCOUNT_PRICE],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][S_TOT_DELIVERY_PRICE],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][S_TOT_PRICE],2,$S_ST_CUR)?></td>
			</tr>
					<?
				}
			}
			?>
			<tr>
				<td></td>
				<td></td>
				<td><?=$LNG_TRANS_CHAR["EW00079"] //합계?></td>
				<td><?=getFormatPrice($intTotSprice,2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($intTotUsePoint,2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($intTotCouponPrice,2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($intTotMemDiscountPrice,2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($intTotDeliveryPrice,2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($intTotPrice,2,$S_ST_CUR)?></td>
			</tr>
		</table>