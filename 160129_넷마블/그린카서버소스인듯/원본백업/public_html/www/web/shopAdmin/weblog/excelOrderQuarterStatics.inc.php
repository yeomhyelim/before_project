		<table border="1">
			<tr>
				<th><?=$LNG_TRANS_CHAR["CW00012"] //연도?></th>
				<th><?="분기" //분기?></th>
				<th><?=$LNG_TRANS_CHAR["EW00059"] //결제금액?></th>
				<th><?="사용포인트" //사용포인트?></th>
				<th><?="쿠폰금액" //쿠폰금액?></th>
				<th><?="할인금액" //할인금액?></th>
				<th><?="배송비" //배송비?></th>
				<th><?=$LNG_TRANS_CHAR["EW00060"] //매출금액?></th>
			</tr>
			<?
			if (is_array($aryOrderSaleList)){

				$intTotSprice		= $intTotUsePoint		= $intTotCouponPrice		= $intTotMemDiscountPrice		= $intTotDeliveryPrice		= $intTotPrice = 0;
				$intTotYearSprice	= $intTotYearUsePoint	= $intTotYearCouponPrice	= $intTotYearMemDiscountPrice	= $intTotYearDeliveryPrice	= $intTotYearPrice = 0;

				for($i=0;$i<sizeof($aryOrderSaleList);$i++){
					$intTotYearSprice			 = $intTotYearUsePoint	= $intTotYearCouponPrice	= $intTotYearMemDiscountPrice	= $intTotYearDeliveryPrice	= $intTotYearPrice = 0;

					$intTotYearSprice			+= ($aryOrderSaleList[$i][S_TOT_SPRICE1] + $aryOrderSaleList[$i][S_TOT_SPRICE2] + $aryOrderSaleList[$i][S_TOT_SPRICE3] + $aryOrderSaleList[$i][S_TOT_SPRICE4]);
					$intTotYearUsePoint			+= ($aryOrderSaleList[$i][S_TOT_USE_POINT1] + $aryOrderSaleList[$i][S_TOT_USE_POINT2] + $aryOrderSaleList[$i][S_TOT_USE_POINT3] + $aryOrderSaleList[$i][S_TOT_USE_POINT4]);
					$intTotYearCouponPrice		+= ($aryOrderSaleList[$i][S_TOT_COUPON1]+$aryOrderSaleList[$i][S_TOT_COUPON2]+$aryOrderSaleList[$i][S_TOT_COUPON3]+$aryOrderSaleList[$i][S_TOT_COUPON4]);
					$intTotYearMemDiscountPrice += ($aryOrderSaleList[$i][S_TOT_MEM_DISCOUNT_PRICE1] + $aryOrderSaleList[$i][S_TOT_MEM_DISCOUNT_PRICE2] + $aryOrderSaleList[$i][S_TOT_MEM_DISCOUNT_PRICE3] + $aryOrderSaleList[$i][S_TOT_MEM_DISCOUNT_PRICE4]);
					$intTotYearDeliveryPrice	+= ($aryOrderSaleList[$i][S_TOT_DELIVERY_PRICE1] + $aryOrderSaleList[$i][S_TOT_DELIVERY_PRICE2]+$aryOrderSaleList[$i][S_TOT_DELIVERY_PRICE3]+$aryOrderSaleList[$i][S_TOT_DELIVERY_PRICE4]);
					$intTotYearPrice			+= ($aryOrderSaleList[$i][S_TOT_PRICE1] + $aryOrderSaleList[$i][S_TOT_PRICE2] + $aryOrderSaleList[$i][S_TOT_PRICE3] + $aryOrderSaleList[$i][S_TOT_PRICE4]);

					$intTotSprice			+= $intTotYearSprice;
					$intTotUsePoint			+= $intTotYearUsePoint;
					$intTotCouponPrice		+= $intTotYearCouponPrice;
					$intTotMemDiscountPrice += $intTotYearMemDiscountPrice;
					$intTotDeliveryPrice	+= $intTotYearDeliveryPrice;
					$intTotPrice			+= $intTotYearPrice;
					?>
			<tr>
				<td rowspan="5"><?=$aryOrderSaleList[$i][S_DATE]?></td>
				<td><?=$LNG_TRANS_CHAR["EW00063"] //1분기?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][S_TOT_SPRICE1],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][S_TOT_USE_POINT1],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][S_TOT_COUPON1],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][S_TOT_MEM_DISCOUNT_PRICE1],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][S_TOT_DELIVERY_PRICE1],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][S_TOT_PRICE1],2,$S_ST_CUR)?></td>
			</tr>
			<tr>
				<td><?=$LNG_TRANS_CHAR["EW00064"] //2분기?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][S_TOT_SPRICE2],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][S_TOT_USE_POINT2],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][S_TOT_COUPON2],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][S_TOT_MEM_DISCOUNT_PRICE2],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][S_TOT_DELIVERY_PRICE2],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][S_TOT_PRICE2],2,$S_ST_CUR)?></td>
			</tr>
			<tr>
				<td><?=$LNG_TRANS_CHAR["EW00065"] //3분기?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][S_TOT_SPRICE3],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][S_TOT_USE_POINT3],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][S_TOT_COUPON3],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][S_TOT_MEM_DISCOUNT_PRICE3],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][S_TOT_DELIVERY_PRICE3],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][S_TOT_PRICE3],2,$S_ST_CUR)?></td>
			</tr>
			<tr>
				<td><?=$LNG_TRANS_CHAR["EW00066"] //4분기?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][S_TOT_SPRICE4],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][S_TOT_USE_POINT4],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][S_TOT_COUPON4],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][S_TOT_MEM_DISCOUNT_PRICE4],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][S_TOT_DELIVERY_PRICE4],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][S_TOT_PRICE4],2,$S_ST_CUR)?></td>
			</tr>
			<tr>
				<td>총분기(Sum)</td>
				<td><?=getFormatPrice($intTotYearSprice,2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($intTotYearUsePoint,2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($intTotYearCouponPrice,2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($intTotYearMemDiscountPrice,2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($intTotYearDeliveryPrice,2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($intTotYearPrice,2,$S_ST_CUR)?></td>
			</tr>

					<?
				}
			}
			?>
			<tr>
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