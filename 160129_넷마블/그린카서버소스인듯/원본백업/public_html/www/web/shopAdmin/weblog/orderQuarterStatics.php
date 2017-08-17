<?
	if (is_array($aryOrderSaleList)){
		for($i=0;$i<sizeof($aryOrderSaleList);$i++){
			$strY .= STR_REPLACE(",","",getFormatPrice($aryOrderSaleList[$i][S_TOT_PRICE1],2,$S_ST_CUR)).",";
			$strY .= STR_REPLACE(",","",getFormatPrice($aryOrderSaleList[$i][S_TOT_PRICE2],2,$S_ST_CUR)).",";
			$strY .= STR_REPLACE(",","",getFormatPrice($aryOrderSaleList[$i][S_TOT_PRICE3],2,$S_ST_CUR)).",";
			$strY .= STR_REPLACE(",","",getFormatPrice($aryOrderSaleList[$i][S_TOT_PRICE4],2,$S_ST_CUR)).",";
						
			$strX .= "'".$aryOrderSaleList[$i][S_DATE]."-".$LNG_TRANS_CHAR["EW00063"]."',";
			$strX .= "'".$aryOrderSaleList[$i][S_DATE]."-".$LNG_TRANS_CHAR["EW00064"]."',";
			$strX .= "'".$aryOrderSaleList[$i][S_DATE]."-".$LNG_TRANS_CHAR["EW00065"]."',";
			$strX .= "'".$aryOrderSaleList[$i][S_DATE]."-".$LNG_TRANS_CHAR["EW00066"]."',";

		}

		$strY = SUBSTR($strY,0,STRLEN($strY)-1);
		$strX = SUBSTR($strX,0,STRLEN($strX)-1);
	} else {
		$strY = 0;
		$strX = "0";	
	}
	
?>
<script type="text/javascript">
<!--
	$(document).ready(function(){
		
		$('input[name=searchRegStartDt]').simpleDatepicker();
		$('input[name=searchRegEndDt]').simpleDatepicker();
		
		$.jqplot.config.enablePlugins = true;
        var s1 = [<?=$strY?>];
        var ticks = [<?=$strX?>];
        
        plot1 = $.jqplot('chart1', [s1], {
            // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
            animate: !$.jqplot.use_excanvas,
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
                pointLabels: { show: true }
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks
                },
				yaxis:{
					tickOptions:{
						formatString:"%'d"
					}
				}
            },
            highlighter: { show: false }
        });
    
        $('#chart1').bind('jqplotDataClick', 
            function (ev, seriesIndex, pointIndex, data) {
                //$('#info1').html('series: '+seriesIndex+', point: '+pointIndex+', data: '+data);
            }
        );	
	});

	function goExcelDownload() {
		var data = new Array(5);
		data['mode']				= "excel";
		data['act']					= "excelOrderQuarterStatics";
		data['searchRegStartDt']	= $("#searchRegStartDt").val();
		data['searchRegEndDt']		= $("#searchRegEndDt").val();

		C_getAddLocationUrl(data);
	}
//-->
</script>
<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["EW00062"] //분기별매출통계?></h2>
		<div class="clr"></div>
	</div>

	<!-- ******** 컨텐츠 ********* -->
		<!-- 그래프 -->
			<div class="logGraphWrap mt30" style="width:100%;height:300px;" id="chart1"></div>
		<!-- 그래프 -->
	<div class="searchTableWrap">
		<table>
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00057"] //주문일?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:80px;" id="searchRegStartDt" name="searchRegStartDt" maxlength="10" value="<?=$strSearchRegStartDt?>"//>
					~
					<input type="text" <?=$nBox?>  style="width:80px;" id="searchRegEndDt" name="searchRegEndDt" maxlength="10" value="<?=$strSearchRegEndDt?>"//>
					<span class="searchWrapImg">
						<a class="btn_sml" href="javascript:C_getSearchDay('T','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00017"]?></strong></a>
						<a class="btn_sml" href="javascript:C_getSearchDay('1','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00018"]?></strong></a>
						<a class="btn_sml" href="javascript:C_getSearchDay('2','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00019"]?></strong></a>
						<a class="btn_sml" href="javascript:C_getSearchDay('1M','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00020"]?></strong></a>
						<a class="btn_sml" href="javascript:C_getSearchDay('2M','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00021"]?></strong></a>
						<a class="btn_sml" href="#"><strong><?=$LNG_TRANS_CHAR["CW00022"]?></strong></a>
					</span>
					<a class="btn_blue_big" href="javascript:goSearch();"><strong><?=$LNG_TRANS_CHAR["CW00027"] //검색?></strong></a>
				</td>
			</tr>
			<!--<tr>
				<th><?=$LNG_TRANS_CHAR["EW00058"] //결제방법?></th>
				<td>
					<?if ($intSiteSettleC == "Y"){?>
					<input type="checkbox" id="searchSettleC" name="searchSettleC" value="Y" <?=($strSearchSettleC=="Y")?"checked":"";?>><?=$S_ARY_SETTLE_TYPE["C"] ///신용카드?>
					<?}?>
					<?if ($intSiteSettleA == "Y"){?>
					<input type="checkbox" id="searchSettleA" name="searchSettleA" value="Y" <?=($strSearchSettleA=="Y")?"checked":"";?>><?=$S_ARY_SETTLE_TYPE["A"] ///계좌이체?>
					<?}?>
					<?if ($intSiteSettleT == "Y"){?>
					<input type="checkbox" id="searchSettleT" name="searchSettleT" value="Y" <?=($strSearchSettleT=="Y")?"checked":"";?>><?=$S_ARY_SETTLE_TYPE["T"] ///가상계좌?>
					<?}?>
					<?if ($intSiteSettleB == "Y"){?>
					<input type="checkbox" id="searchSettleB" name="searchSettleB" value="Y"<?=($strSearchSettleB=="Y")?"checked":"";?>><?=$S_ARY_SETTLE_TYPE["B"] ///무통장입금?>
					<?}?>
					<?if ($intSiteSettleY == "Y"){?>
					<input type="checkbox" id="searchSettleY" name="searchSettleY" value="Y"<?=($strSearchSettleY=="Y")?"checked":"";?>>Paypal
					<?}?>
					<?if ($intSiteSettleX == "Y"){?>
					<input type="checkbox" id="searchSettleX" name="searchSettleX" value="Y"<?=($strSearchSettleX=="Y")?"checked":"";?>>EximBay
					<?}?>
					<a class="btn_blue_big" href="javascript:goSearch();"><strong><?=$LNG_TRANS_CHAR["CW00027"] //검색?></strong></a>
				</td>
			</tr>//-->
			<?if($a_admin_type != "S" && is_array($aryShopList)):?>
			<tr>
				<th>입점사</th>
				<td>
					<select name="searchShop" id="searchShop" style="width:200px">
						<option value=""<?if($_REQUEST["searchShop"] == ""){ echo " selected";}?>>전체</option>
						<?foreach($aryShopList as $key => $data): ?>
						<option value="<?=$key?>"<?if($_REQUEST["searchShop"] == "{$key}"){ echo " selected";}?>><?=$data?></option>
						<?endforeach;?>
					</select>
				</td>
			</tr>
			<?endif;?>
			<?	if ($S_FIX_MEMBER_CATE_USE_YN  == "Y" && $a_admin_type != "S"){?>
			<tr>
				<th>소속</th>
				<td>
					<select name="searchNation" id="c_nation">
						<option value=""<?if($_REQUEST['searchNation'] == ""){ echo " selected";}?>>전체</option>
						<?foreach($aryUseLng as $key => $lng):?>
						<option value="<?=$lng?>"<?if($_REQUEST['searchNation'] == $lng){ echo " selected";}?>><?=$S_ARY_COUNTRY[$lng]?></option>
						<?endforeach;?>
					</select>
					<select name="searchCate1" id="c_cate" no="1">
						<option value=""<?if($_REQUEST['searchCate1'] == ""){ echo " selected";}?>>1차 카테고리</option>
						<?foreach($MEMBER_CATE as $code => $data):
							if($data['C_LEVEL'] != 1) { continue; } 
							if($aryMemberCate && !in_array($code, $aryMemberCate)) { continue; } ?>
						<option nation="<?=$data['C_NATION']?>" value="<?=$code?>"<?if($_REQUEST['searchCate1'] == $code){ echo " selected";}?>><?=$data['C_NAME']?></option>
						<?endforeach;?>
					</select>
					<select name="searchCate2" id="c_cate" no="2">
						<option value=""<?if($_REQUEST['searchCate2'] == ""){ echo " selected";}?>>2차 카테고리</option>
						<?foreach($MEMBER_CATE as $code => $data):
							if($data['C_LEVEL'] != 2) { continue; }	
							if($aryMemberCate && !in_array($code, $aryMemberCate)) { continue; } ?>
						<option nation="<?=$data['C_NATION']?>" value="<?=$code?>"<?if($_REQUEST['searchCate2'] == $code){ echo " selected";}?>><?=$data['C_NAME']?></option>
						<?endforeach;?>
					</select>
					<select name="searchCate3" id="c_cate" no="3">
						<option value=""<?if($_REQUEST['searchCate3'] == ""){ echo " selected";}?>>3차 카테고리</option>
						<?foreach($MEMBER_CATE as $code => $data):
							if($data['C_LEVEL'] != 3) { continue; }
							if($aryMemberCate && !in_array($code, $aryMemberCate)) { continue; } ?>
						<option nation="<?=$data['C_NATION']?>" value="<?=$code?>"<?if($_REQUEST['searchCate3'] == $code){ echo " selected";}?>><?=$data['C_NAME']?></option>
						<?endforeach;?>
					</select>
					<select name="searchCate4" id="c_cate" no="4">
						<option value=""<?if($_REQUEST['searchCate4'] == ""){ echo " selected";}?>>4차 카테고리</option>
						<?foreach($MEMBER_CATE as $code => $data):
							if($data['C_LEVEL'] != 4) { continue; }
							if($aryMemberCate && !in_array($code, $aryMemberCate)) { continue; } ?>
						<option nation="<?=$data['C_NATION']?>" value="<?=$code?>"<?if($_REQUEST['searchCate4'] == $code){ echo " selected";}?>><?=$data['C_NAME']?></option>
						<?endforeach;?>
					</select>
				</td>
			</tr>
			<?}?>
		</table>
	</div>
	<div class="right mt10">
		<a class="btn_excel_big" href="javascript:goExcelDownload();" id="menu_auth_e" style="display:none:"><strong>Excel Down</strong></a>
	</div>
	<div class="tableList mt30">
		<table>
			<colgroup>
				<col/>
				<col/>
				<col/>
				<col/>
				<col/>
				<col/>
				<col/>
				<col style="background-color:#f1f7f9" />
			</colgroup>
			<tr>
				<th><?=$LNG_TRANS_CHAR["CW00012"] //연도?></th>
				<th><?="분기" //분기?></th>
				<th><?="실결제금액" //결제금액?></th>
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
			<tr class="totRow">
				<td colspan="2"><?=$LNG_TRANS_CHAR["EW00079"] //합계?></td>
				<td><?=getFormatPrice($intTotSprice,2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($intTotUsePoint,2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($intTotCouponPrice,2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($intTotMemDiscountPrice,2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($intTotDeliveryPrice,2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($intTotPrice,2,$S_ST_CUR)?></td>
			</tr>
		</table>
	</div>
	<!-- tableList -->

	
</div>
