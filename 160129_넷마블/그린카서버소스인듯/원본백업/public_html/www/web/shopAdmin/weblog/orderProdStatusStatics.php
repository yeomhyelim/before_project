<?
/*
	if (is_array($aryOrderSaleList)){
				
		for($i=0;$i<sizeof($aryOrderSaleList);$i++){
			$strY .= STR_REPLACE(",","",NUMBER_FORMAT($aryOrderSaleList[$i][S_TOT_SPRICE])).",";
			$strX .= "'".$aryOrderSaleList[$i][O_REG_DT]."',";
		}

		$strY = SUBSTR($strY,0,STRLEN($strY)-1);
		$strX = SUBSTR($strX,0,STRLEN($strX)-1);
	} else {
		$strY = 0;
		$strX = "0";	
	}
*/	
?>
<script type="text/javascript">
<!--
	$(document).ready(function(){
		
		$('input[name=searchRegStartDt]').simpleDatepicker();
		$('input[name=searchRegEndDt]').simpleDatepicker();
		
		/*
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
                }
            },
            highlighter: { show: false }
        });
    
        $('#chart1').bind('jqplotDataClick', 
            function (ev, seriesIndex, pointIndex, data) {
                //$('#info1').html('series: '+seriesIndex+', point: '+pointIndex+', data: '+data);
            }
        );
		*/
	});

	function goExcelDownload() {
		var data = new Array(5);
		data['mode']				= "excel";
		data['act']					= "excelOrderProdStatusStatics";
		data['searchRegStartDt']	= $("#searchRegStartDt").val();
		data['searchRegEndDt']		= $("#searchRegEndDt").val();

		C_getAddLocationUrl(data);
	}


//-->
</script>
<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["EW00093"] //상품별주문통계?></h2>
		<div class="clr"></div>
	</div>

	<!-- ******** 컨텐츠 ********* -->
		<!-- 그래프 -->
			<div class="logGraphWrap mt30" style="width:100%;height:300px;display:none" id="chart1"></div>
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
						<a class="btn_blue_big" href="javascript:goSearch();"><strong><?=$LNG_TRANS_CHAR["CW00027"] //검색?></strong></a>
					</span>
				</td>
			</tr>
			<tr>
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
					
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00021"] //카테고리선택?></th>
				<td>
					<select id="searchCateHCode1" name="searchCateHCode1">
						<option value=""><?=$LNG_TRANS_CHAR["PW00013"] //1차 카테고리 선택?></option>
					</select>
					<select id="searchCateHCode2" name="searchCateHCode2" >
						<option value=""><?=$LNG_TRANS_CHAR["PW00014"] //2차 카테고리 선택?></option>
					</select>
					<select id="searchCateHCode3" name="searchCateHCode3" >
						<option value=""><?=$LNG_TRANS_CHAR["PW00015"] //3차 카테고리 선택?></option>
					</select>
					<!--
					<select id="searchCateHCode4" name="searchCateHCode4">
						<option value=""><?=$LNG_TRANS_CHAR["PW00016"] //4차 카테고리 선택?></option>
					</select>
					-->
				</td>
			</tr>
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
						<option value=""<?if($_REQUEST['searchCate1'] == ""){ echo " selected";}?>>1차 소속</option>
						<?foreach($MEMBER_CATE as $code => $data):
							if($data['C_LEVEL'] != 1) { continue; } 
							if($aryMemberCate && !in_array($code, $aryMemberCate)) { continue; } ?>
						<option nation="<?=$data['C_NATION']?>" value="<?=$code?>"<?if($_REQUEST['searchCate1'] == $code){ echo " selected";}?>><?=$data['C_NAME']?></option>
						<?endforeach;?>
					</select>
					<select name="searchCate2" id="c_cate" no="2">
						<option value=""<?if($_REQUEST['searchCate2'] == ""){ echo " selected";}?>>2차 소속</option>
						<?foreach($MEMBER_CATE as $code => $data):
							if($data['C_LEVEL'] != 2) { continue; }	
							if($aryMemberCate && !in_array($code, $aryMemberCate)) { continue; } ?>
						<option nation="<?=$data['C_NATION']?>" value="<?=$code?>"<?if($_REQUEST['searchCate2'] == $code){ echo " selected";}?>><?=$data['C_NAME']?></option>
						<?endforeach;?>
					</select>
					<select name="searchCate3" id="c_cate" no="3">
						<option value=""<?if($_REQUEST['searchCate3'] == ""){ echo " selected";}?>>3차 소속</option>
						<?foreach($MEMBER_CATE as $code => $data):
							if($data['C_LEVEL'] != 3) { continue; }
							if($aryMemberCate && !in_array($code, $aryMemberCate)) { continue; } ?>
						<option nation="<?=$data['C_NATION']?>" value="<?=$code?>"<?if($_REQUEST['searchCate3'] == $code){ echo " selected";}?>><?=$data['C_NAME']?></option>
						<?endforeach;?>
					</select>
					<select name="searchCate4" id="c_cate" no="4">
						<option value=""<?if($_REQUEST['searchCate4'] == ""){ echo " selected";}?>>4차 소속</option>
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
				<col />
				<col />				
				<col />
				<col />
				<col />
				<col />
				<col />
				<col />
				<col />
			</colgroup>
			<tr>
				<th rowspan="2" class="lowTh">
					<?=$LNG_TRANS_CHAR["EW00077"] //상품명?>
					<a href="javascript:goStaticOrderBy('prodNameDesc');"><font color="#ffffff">▲</font></a>
					<a href="javascript:goStaticOrderBy('prodNameAsc');"><font color="#ffffff">▼</font></a>
				</th>
				<th rowspan="2" class="lowTh">
					<?=$LNG_TRANS_CHAR["EW00147"] //금액?>
					<a href="javascript:goStaticOrderBy('prodPriceDesc');"><font color="#ffffff">▲</font></a>
					<a href="javascript:goStaticOrderBy('prodPriceAsc');"><font color="#ffffff">▼</font></a>
				</th>
				<th>
					<?=$LNG_TRANS_CHAR["OW00059"] //총수량?>
					<a href="javascript:goStaticOrderBy('totCntDesc');"><font color="#ffffff">▲</font></a>
					<a href="javascript:goStaticOrderBy('totCntAsc');"><font color="#ffffff">▼</font></a>
				</th>
				<th>
					<?=$S_ARY_SETTLE_STATUS["J"] //주문완료?>(<?= $LNG_TRANS_CHAR["EW00146"]; //건수 ?>)
					<a href="javascript:goStaticOrderBy('orderCntJDesc');"><font color="#ffffff">▲</font></a>
					<a href="javascript:goStaticOrderBy('orderCntJAsc');"><font color="#ffffff">▼</font></a>
				</th>
				<th>
					<?=$LNG_TRANS_CHAR["EW00148"] //결제완료?>(<?= $LNG_TRANS_CHAR["EW00146"]; //건수 ?>)
					<a href="javascript:goStaticOrderBy('orderCntADesc');"><font color="#ffffff">▲</font></a>
					<a href="javascript:goStaticOrderBy('orderCntAAsc');"><font color="#ffffff">▼</font></a>
				</th>
				<th>
					<?=$LNG_TRANS_CHAR["EW00149"] //배송준비중?>(<?= $LNG_TRANS_CHAR["EW00146"]; //건수 ?>)
					<a href="javascript:goStaticOrderBy('orderCntBDesc');"><font color="#ffffff">▲</font></a>
					<a href="javascript:goStaticOrderBy('orderCntBAsc');"><font color="#ffffff">▼</font></a>
				</th>
				<th>
					<?=$LNG_TRANS_CHAR["EW00150"] //배송중?>(<?= $LNG_TRANS_CHAR["EW00146"]; //건수 ?>)
					<a href="javascript:goStaticOrderBy('orderCntIDesc');"><font color="#ffffff">▲</font></a>
					<a href="javascript:goStaticOrderBy('orderCntIAsc');"><font color="#ffffff">▼</font></a>	
				</th>
				<th>
					<?=$LNG_TRANS_CHAR["EW00151"] //배송완료?>(<?= $LNG_TRANS_CHAR["EW00146"]; //건수 ?>)
					<a href="javascript:goStaticOrderBy('orderCntDDesc');"><font color="#ffffff">▲</font></a>
					<a href="javascript:goStaticOrderBy('orderCntDAsc');"><font color="#ffffff">▼</font></a>	
				</th>
				<th>
					<?=$LNG_TRANS_CHAR["EW00152"] //구매완료?>(<?= $LNG_TRANS_CHAR["EW00146"]; //건수 ?>)
					<a href="javascript:goStaticOrderBy('orderCntEDesc');"><font color="#ffffff">▲</font></a>
					<a href="javascript:goStaticOrderBy('orderCntEAsc');"><font color="#ffffff">▼</font></a>
				</th>
				<th>
					<?=$LNG_TRANS_CHAR["EW00153"] //주문취소?>(<?= $LNG_TRANS_CHAR["EW00146"]; //건수 ?>)
					<a href="javascript:goStaticOrderBy('orderCntCDesc');"><font color="#ffffff">▲</font></a>
					<a href="javascript:goStaticOrderBy('orderCntCAsc');"><font color="#ffffff">▼</font></a>
				</th>
			</tr>
			<tr>
				<th>
					총금액
					<a href="javascript:goStaticOrderBy('totPriceDesc');"><font color="#ffffff">▲</font></a>
					<a href="javascript:goStaticOrderBy('totPriceAsc');"><font color="#ffffff">▼</font></a>
				</th>
				<th>
					<?=$S_ARY_SETTLE_STATUS["J"] //주문완료?>(<?= $LNG_TRANS_CHAR["EW00147"]; //금액 ?>)
					<a href="javascript:goStaticOrderBy('orderPriceJDesc');"><font color="#ffffff">▲</font></a>
					<a href="javascript:goStaticOrderBy('orderPriceJAsc');"><font color="#ffffff">▼</font></a>
				</th>
				<th>
					<?=$LNG_TRANS_CHAR["EW00148"] //결제완료?>(<?= $LNG_TRANS_CHAR["EW00147"]; //금액 ?>)
					<a href="javascript:goStaticOrderBy('orderPriceADesc');"><font color="#ffffff">▲</font></a>
					<a href="javascript:goStaticOrderBy('orderPriceAAsc');"><font color="#ffffff">▼</font></a>
				</th>
				<th>
					<?=$LNG_TRANS_CHAR["EW00149"] //배송준비중?>(<?= $LNG_TRANS_CHAR["EW00147"]; //금액 ?>)
					<a href="javascript:goStaticOrderBy('orderPriceBDesc');"><font color="#ffffff">▲</font></a>
					<a href="javascript:goStaticOrderBy('orderPriceBAsc');"><font color="#ffffff">▼</font></a>
				</th>
				<th>
					<?=$LNG_TRANS_CHAR["EW00150"] //배송중?>(<?= $LNG_TRANS_CHAR["EW00147"]; //금액 ?>)
					<a href="javascript:goStaticOrderBy('orderPriceIDesc');"><font color="#ffffff">▲</font></a>
					<a href="javascript:goStaticOrderBy('orderPriceIAsc');"><font color="#ffffff">▼</font></a>
				</th>
				<th>
					<?=$LNG_TRANS_CHAR["EW00151"] //배송완료?>(<?= $LNG_TRANS_CHAR["EW00147"]; //금액 ?>)
					<a href="javascript:goStaticOrderBy('orderPriceDDesc');"><font color="#ffffff">▲</font></a>
					<a href="javascript:goStaticOrderBy('orderPriceDAsc');"><font color="#ffffff">▼</font></a>
				</th>
				<th>
					<?=$LNG_TRANS_CHAR["EW00152"] //구매완료?>(<?= $LNG_TRANS_CHAR["EW00147"]; //금액 ?>)
					<a href="javascript:goStaticOrderBy('orderPriceEDesc');"><font color="#ffffff">▲</font></a>
					<a href="javascript:goStaticOrderBy('orderPriceEAsc');"><font color="#ffffff">▼</font></a>
				</th>
				<th>
					<?=$LNG_TRANS_CHAR["EW00153"] //주문취소?>(<?= $LNG_TRANS_CHAR["EW00147"]; //금액 ?>)
					<a href="javascript:goStaticOrderBy('orderPriceCDesc');"><font color="#ffffff">▲</font></a>
					<a href="javascript:goStaticOrderBy('orderPriceCAsc');"><font color="#ffffff">▼</font></a>
				</th>
			</tr>
			<?
			if (is_array($aryOrderSaleList)){
				
				for($i=0;$i<=7;$i++){
					$aryOrderStatus[$i]["CNT"]		= 0;
					$aryOrderStatus[$i]["PRICE"]	= 0;
				}
				
				$intTotProdSalePrice = 0;
				for($i=0;$i<sizeof($aryOrderSaleList);$i++){
					
					$aryOrderSaleList[$i]["O_STATUS_CNT"] = ($aryOrderSaleList[$i]["O_STATUS_CNT1"] + $aryOrderSaleList[$i]["O_STATUS_CNT2"] + $aryOrderSaleList[$i]["O_STATUS_CNT3"] + $aryOrderSaleList[$i]["O_STATUS_CNT4"] + $aryOrderSaleList[$i]["O_STATUS_CNT5"] + $aryOrderSaleList[$i]["O_STATUS_CNT6"] + $aryOrderSaleList[$i]["O_STATUS_CNT7"]);
					for($j=0;$j<=7;$j++){
						$intOrderStatusCnt				= ($j == 0) ? $aryOrderSaleList[$i]["O_STATUS_CNT"]		: $aryOrderSaleList[$i]["O_STATUS_CNT".$j];
						$intOrderStatusPrice			= ($j == 0) ? $aryOrderSaleList[$i]["O_STATUS_PRICE"]	: $aryOrderSaleList[$i]["O_STATUS_PRICE".$j];

						$aryOrderStatus[$j]["CNT"]		= $aryOrderStatus[$j]["CNT"]	+ $intOrderStatusCnt;
						$aryOrderStatus[$j]["PRICE"]	= $aryOrderStatus[$j]["PRICE"]  + $intOrderStatusPrice;
					}

					$intTotProdSalePrice += $aryOrderSaleList[$i][P_SALE_PRICE];
					?>
			<tr>
				<td style="text-align:left" rowspan="2">
					<img src="<?=$aryOrderSaleList[$i][P_IMG_PATH]?>" style="width:50px;height:50px">
					<?=$aryOrderSaleList[$i][P_NAME]?>
				</td>
				<td rowspan="2"><?=NUMBER_FORMAT($aryOrderSaleList[$i][P_SALE_PRICE])?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][O_STATUS_CNT])?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][O_STATUS_CNT1])?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][O_STATUS_CNT2])?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][O_STATUS_CNT3])?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][O_STATUS_CNT4])?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][O_STATUS_CNT5])?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][O_STATUS_CNT6])?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][O_STATUS_CNT7])?></td>
			</tr>
			<tr>
				<td><?=getFormatPrice($aryOrderSaleList[$i][O_STATUS_PRICE],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][O_STATUS_PRICE1],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][O_STATUS_PRICE2],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][O_STATUS_PRICE3],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][O_STATUS_PRICE4],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][O_STATUS_PRICE5],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][O_STATUS_PRICE6],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][O_STATUS_PRICE7],2,$S_ST_CUR)?></td>
			</tr>

					<?
				}
			}
			?>
			<tr class="totRow">
				<td rowspan="2" class="txtCenter">
					<?=$LNG_TRANS_CHAR["EW00079"] //합계?>
				</td>
				<td rowspan="2">
					<?=NUMBER_FORMAT($intTotProdSalePrice)?>
				</td>
				<td><?=NUMBER_FORMAT($aryOrderStatus[0]["CNT"])?></td>
				<td><?=NUMBER_FORMAT($aryOrderStatus[1]["CNT"])?></td>
				<td><?=NUMBER_FORMAT($aryOrderStatus[2]["CNT"])?></td>
				<td><?=NUMBER_FORMAT($aryOrderStatus[3]["CNT"])?></td>
				<td><?=NUMBER_FORMAT($aryOrderStatus[4]["CNT"])?></td>
				<td><?=NUMBER_FORMAT($aryOrderStatus[5]["CNT"])?></td>
				<td><?=NUMBER_FORMAT($aryOrderStatus[6]["CNT"])?></td>
				<td><?=NUMBER_FORMAT($aryOrderStatus[7]["CNT"])?></td>
			</tr>
			<tr class="totRow2">
				<td><?=getFormatPrice($aryOrderStatus[0]["PRICE"],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderStatus[1]["PRICE"],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderStatus[2]["PRICE"],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderStatus[3]["PRICE"],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderStatus[4]["PRICE"],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderStatus[5]["PRICE"],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderStatus[6]["PRICE"],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderStatus[7]["PRICE"],2,$S_ST_CUR)?></td>
			</tr>
		</table>
	</div>
	<!-- tableList -->

		<div class="noticeInfoWrap">
		<ul>
			<!--
			<li>* 주문에 관련한 통계는 구매확정을 기준으로 만들어 집니다.  배송완료건에 대해 구매확정이 되었는지 확인 필요합니다.</li>
			<li>* 통계의 기준은 주문일자를 기준으로 리스트됩니다.</li>
			-->
			<li>* <?= $LNG_TRANS_CHAR["EM00001"]; //주문에 관련한 통계는 구매확정을 기준으로 만들어 집니다.  배송완료건에 대해 구매확정이 되었는지 확인 필요합니다. ?></li>
			<li>* <?= $LNG_TRANS_CHAR["EM00002"]; //통계의 기준은 주문일자를 기준으로 리스트됩니다. ?></li>
			<!--
			<li>* 상품별 주문통계는 상품의 수량 기준이며 추가옵션 상품은 금액만 합산되며 수량에서는 제외됩니다.</li>
			<li>* 상품별 주문통계는 <strong>배송비 제외금액</strong>입니다.</li>
			<li class="topLine">- <span class="tit">금액</span>: 해당 상품의 현재 판매가입니다.</li>
			-->
			<li>* <?= $LNG_TRANS_CHAR["EM00011"]; //상품별 주문통계는 상품의 수량 기준이며 추가옵션 상품은 금액만 합산되며 수량에서는 제외됩니다. ?></li>
			<li>* <?= $LNG_TRANS_CHAR["EM00012"]; //상품별 주문통계는 <strong>배송비 제외금액</strong>입니다. ?></li>
			<li class="topLine">- <?= $LNG_TRANS_CHAR["EM00013"]; //<span class="tit">금액</span>: 해당 상품의 현재 판매가입니다. ?></li>
			<!--
			<li>- <span class="tit">총매출액</span>: "결제완료 + 배송준비중 + 배송중 + 배송완료 + 구매완료"의 합산금액입니다.</li>
			<li>- <span class="tit">주문완료</span>: "무통장 및 가상계좌" 등 으로 주문된 결제 확인전 주문목록 입니다.</li>
			<li>- <span class="tit">결제완료</span>:  실제 결제가 완료된 주문</li>
			<li>- <span class="tit">배송중</span>: 송장번호가 입력되어 배송 진행중인 목록</li>
			<li>- <span class="tit">배송완료</span>: 배송이 완료된 상태이며 택배사 API가 연동되지 않은경우는 관리자가 직접 배송완료 상태로 변경해 주셔야 합니다.</li>
			<li>- <span class="tit">구매완료</span>: 구매자 또는 관리자가 구매확정으로 변경한 상태입니다.</li>
			<li>- <span class="tit">주문취소</span>: 주문취소 및 반품 합산 금액</li>
			-->
			<li>- <?= $LNG_TRANS_CHAR["EM00003"]; //<span class="tit">총매출액</span>: "결제완료 + 배송준비중 + 배송중 + 배송완료 + 구매완료"의 합산금액입니다. ?></li>
			<li>- <?= $LNG_TRANS_CHAR["EM00005"]; //<span class="tit">주문완료</span>: "무통장 및 가상계좌" 등 으로 주문된 결제 확인전 주문목록 입니다.?></li>
			<li>- <?= $LNG_TRANS_CHAR["EM00006"]; //<span class="tit">결제완료</span>:  실제 결제가 완료된 주문 ?></li>
			<li>- <?= $LNG_TRANS_CHAR["EM00007"]; //<span class="tit">배송중</span>: 송장번호가 입력되어 배송 진행중인 목록 ?></li>
			<li>- <?= $LNG_TRANS_CHAR["EM00008"]; //<span class="tit">배송완료</span>: 배송이 완료된 상태이며 택배사 API가 연동되지 않은경우는 관리자가 직접 배송완료 상태로 변경해 주셔야 합니다. ?></li>
			<li>- <?= $LNG_TRANS_CHAR["EM00009"]; //<span class="tit">구매완료</span>: 구매자 또는 관리자가 구매확정으로 변경한 상태입니다. ?></li>
			<li>- <?= $LNG_TRANS_CHAR["EM00010"]; //<span class="tit">주문취소</span>: 주문취소 및 반품 합산 금액 ?></li>
		</ul>
	</div>
</div>
