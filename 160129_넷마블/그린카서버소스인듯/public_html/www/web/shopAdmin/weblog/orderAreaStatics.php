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
		data['act']					= "excelOrderAreaStatics";
		data['searchRegStartDt']	= $("#searchRegStartDt").val();
		data['searchRegEndDt']		= $("#searchRegEndDt").val();

		C_getAddLocationUrl(data);
	}
//-->
</script>
<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["EW00091"] //지역별주문통계?></h2>
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
					</span>
					<a class="btn_blue_big" href="javascript:goSearch();"><strong><?=$LNG_TRANS_CHAR["CW00027"] //검색?></strong></a>

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
				<col style="width:80px;"/>				
				<col />
				<col style="background-color:#f1f7f9" />
				<col />
				<col style="background-color:#f1f7f9" />
				<col />
				<col style="background-color:#f1f7f9" />
				<col />
				<col style="background-color:#f1f7f9" />
				<col />
				<col style="background-color:#f1f7f9" />
				<col />
				<col style="background-color:#f1f7f9" />
				<col />
				<col style="background-color:#f1f7f9" />
				<col />
				<col style="background-color:#f1f7f9" />
				<col />
				<col style="background-color:#f1f7f9" />
				<col />
				<col style="background-color:#f1f7f9" />
				<col />
				<col style="background-color:#f1f7f9" />
				<col />
				<col style="background-color:#f1f7f9" />
				<col />
				<col style="background-color:#f1f7f9" />
				<col />
				<col style="background-color:#f1f7f9" />
				<col />
				<col style="background-color:#f1f7f9" />
				<col />
				<col style="background-color:#f1f7f9" />
			</colgroup>
			<tr>
				<th rowspan="2" class="lowTh"><?=$LNG_TRANS_CHAR["EW00073"] //일별?></th>
				<th colspan="2">강원</th>
				<th colspan="2">경기</th>
				<th colspan="2">경남</th>
				<th colspan="2">경북</th>
				<th colspan="2">광주</th>
				<th colspan="2">대구</th>
				<th colspan="2">대전</th>
				<th colspan="2">부산</th>
				<th colspan="2">서울</th>
				<th colspan="2">울산</th>
				<th colspan="2">인천</th>
				<th colspan="2">전남</th>
				<th colspan="2">전북</th>
				<th colspan="2">제주</th>
				<th colspan="2">충남</th>
				<th colspan="2">충북</th>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00089"] //건수?></th>
				<th><?=$LNG_TRANS_CHAR["EW00090"] //금액?></th>
				<th><?=$LNG_TRANS_CHAR["EW00089"] //건수?></th>
				<th><?=$LNG_TRANS_CHAR["EW00090"] //금액?></th>
				<th><?=$LNG_TRANS_CHAR["EW00089"] //건수?></th>
				<th><?=$LNG_TRANS_CHAR["EW00090"] //금액?></th>
				<th><?=$LNG_TRANS_CHAR["EW00089"] //건수?></th>
				<th><?=$LNG_TRANS_CHAR["EW00090"] //금액?></th>
				<th><?=$LNG_TRANS_CHAR["EW00089"] //건수?></th>
				<th><?=$LNG_TRANS_CHAR["EW00090"] //금액?></th>
				<th><?=$LNG_TRANS_CHAR["EW00089"] //건수?></th>
				<th><?=$LNG_TRANS_CHAR["EW00090"] //금액?></th>
				<th><?=$LNG_TRANS_CHAR["EW00089"] //건수?></th>
				<th><?=$LNG_TRANS_CHAR["EW00090"] //금액?></th>
				<th><?=$LNG_TRANS_CHAR["EW00089"] //건수?></th>
				<th><?=$LNG_TRANS_CHAR["EW00090"] //금액?></th>
				<th><?=$LNG_TRANS_CHAR["EW00089"] //건수?></th>
				<th><?=$LNG_TRANS_CHAR["EW00090"] //금액?></th>
				<th><?=$LNG_TRANS_CHAR["EW00089"] //건수?></th>
				<th><?=$LNG_TRANS_CHAR["EW00090"] //금액?></th>
				<th><?=$LNG_TRANS_CHAR["EW00089"] //건수?></th>
				<th><?=$LNG_TRANS_CHAR["EW00090"] //금액?></th>
				<th><?=$LNG_TRANS_CHAR["EW00089"] //건수?></th>
				<th><?=$LNG_TRANS_CHAR["EW00090"] //금액?></th>
				<th><?=$LNG_TRANS_CHAR["EW00089"] //건수?></th>
				<th><?=$LNG_TRANS_CHAR["EW00090"] //금액?></th>
				<th><?=$LNG_TRANS_CHAR["EW00089"] //건수?></th>
				<th><?=$LNG_TRANS_CHAR["EW00090"] //금액?></th>
				<th><?=$LNG_TRANS_CHAR["EW00089"] //건수?></th>
				<th><?=$LNG_TRANS_CHAR["EW00090"] //금액?></th>
				<th><?=$LNG_TRANS_CHAR["EW00089"] //건수?></th>
				<th><?=$LNG_TRANS_CHAR["EW00090"] //금액?></th>

			</tr>
			<?
			if (is_array($aryOrderSaleList)){

				for($i=1;$i<=16;$i++){
					$arrOrderArea[$i]["CNT"]		= 0;
					$arrOrderArea[$i]["PRICE"]	= 0;
				}

				for($i=0;$i<sizeof($aryOrderSaleList);$i++){

					for($j=1;$j<=16;$j++){
						$arrOrderArea[$j]["CNT"]	= $arrOrderArea[$j]["CNT"]	+ $aryOrderSaleList[$i]["M_ORDER_CNT".$j];
						$arrOrderArea[$j]["PRICE"]	= $arrOrderArea[$j]["PRICE"] + $aryOrderSaleList[$i]["M_ORDER_PRICE".$j];
					}
					?>
			<tr>
				<td><?=$aryOrderSaleList[$i][O_REG_DT]?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][M_ORDER_CNT1])?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][M_ORDER_PRICE1],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][M_ORDER_CNT2])?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][M_ORDER_PRICE2],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][M_ORDER_CNT3])?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][M_ORDER_PRICE3],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][M_ORDER_CNT4])?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][M_ORDER_PRICE4],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][M_ORDER_CNT5])?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][M_ORDER_PRICE5],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][M_ORDER_CNT6])?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][M_ORDER_PRICE6],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][M_ORDER_CNT7])?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][M_ORDER_PRICE7],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][M_ORDER_CNT8])?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][M_ORDER_PRICE8],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][M_ORDER_CNT9])?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][M_ORDER_PRICE9],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][M_ORDER_CNT10])?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][M_ORDER_PRICE10],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][M_ORDER_CNT11])?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][M_ORDER_PRICE11],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][M_ORDER_CNT12])?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][M_ORDER_PRICE12],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][M_ORDER_CNT13])?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][M_ORDER_PRICE13],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][M_ORDER_CNT14])?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][M_ORDER_PRICE14],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][M_ORDER_CNT15])?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][M_ORDER_PRICE15],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][M_ORDER_CNT16])?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][M_ORDER_PRICE16],2,$S_ST_CUR)?></td>
			
			</tr>
					<?
				}
			}
			?>
			<tr>
				<td><?=$LNG_TRANS_CHAR["EW00079"] //합계?></td>
				<?for($i=1;$i<=16;$i++){?>
				<td><?=NUMBER_FORMAT($arrOrderArea[$i]["CNT"])?></td>
				<td><?=getFormatPrice($arrOrderArea[$i]["PRICE"],2,$S_ST_CUR)?></td>
				<?}?>
			</tr>
		</table>
	</div>
	<!-- tableList -->

	
</div>
