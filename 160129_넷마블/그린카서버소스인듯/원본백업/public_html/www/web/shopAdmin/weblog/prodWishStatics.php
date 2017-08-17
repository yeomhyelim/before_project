<?
	if (is_array($aryOrderProdList)){
		for($i=0;$i<sizeof($aryOrderProdList);$i++){
			$strY .= STR_REPLACE(",","",NUMBER_FORMAT($aryOrderProdList[$i][P_PRICE])).",";
			$strX .= "'".$aryOrderProdList[$i][P_NAME]."',";
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
		data['act']					= "excelProdWishStatics";
		data['searchRegStartDt']	= $("#searchRegStartDt").val();
		data['searchRegEndDt']		= $("#searchRegEndDt").val();

		data['searchCateHCode1']	= $("#searchCateHCode1").val();
		data['searchCateHCode2']	= $("#searchCateHCode2").val();
		data['searchCateHCode3']	= $("#searchCateHCode3").val();
		data['searchCateHCode4']	= $("#searchCateHCode4").val();

		C_getAddLocationUrl(data);
	}
//-->
</script>
<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["EW00097"] //상품보관함분석?></h2>
		<div class="clr"></div>
	</div>

	<!-- ******** 컨텐츠 ********* -->
		<!-- 그래프 -->
		<div class="logGraphWrap mt30" style="width:100%;height:300px;display:none" id="chart1" ></div>
		<!-- 그래프 -->
	<div class="searchTableWrap">
		<table>
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00068"] //카테고리선택?></th>
				<td>
					<select id="searchCateHCode1" name="searchCateHCode1">
						<option value=""><?=$LNG_TRANS_CHAR["EW00069"] //1차 카테고리선택?></option>
					</select>
					<select id="searchCateHCode2" name="searchCateHCode2" >
						<option value=""><?=$LNG_TRANS_CHAR["EW00070"] //2차 카테고리선택?></option>
					</select>
					<select id="searchCateHCode3" name="searchCateHCode3" >
						<option value=""><?=$LNG_TRANS_CHAR["EW00071"] //3차 카테고리선택?></option>
					</select>
					<!--
					<select id="searchCateHCode4" name="searchCateHCode4">
						<option value=""><?=$LNG_TRANS_CHAR["EW00072"] //4차 카테고리선택?></option>
					</select>
					-->
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00073"] //일자별?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:80px;" id="searchRegStartDt" name="searchRegStartDt" maxlength="10" value="<?=$strSearchRegStartDt?>"//>
					~
					<input type="text" <?=$nBox?>  style="width:80px;" id="searchRegEndDt" name="searchRegEndDt" maxlength="10" value="<?=$strSearchRegEndDt?>"//>
					<span class="searchWrapImg">
						<a href="javascript:C_getSearchDay('T','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><img src="/shopAdmin/himg/common/btn_sort_today.gif"/></a>
						<a href="javascript:C_getSearchDay('1','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><img src="/shopAdmin/himg/common/btn_sort_week.gif"/></a>
						<a href="javascript:C_getSearchDay('2','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><img src="/shopAdmin/himg/common/btn_sort_15.gif"/></a>
						<a href="javascript:C_getSearchDay('1M','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><img src="/shopAdmin/himg/common/btn_sort_month.gif"/></a>
						<a href="javascript:C_getSearchDay('2M','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><img src="/shopAdmin/himg/common/btn_sort_2month.gif"/></a>
						<a href="#"><img src="/shopAdmin/himg/common/btn_sort_all.gif"/></a>
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
				<col style="width:40%;"/>				
				<col style="width:20%;"/>
				<col style="background-color:#f1f7f9" />
			</colgroup>
			<tr>
				<th>
					<?=$LNG_TRANS_CHAR["EW00077"] //상품명?>
					<a href="javascript:goStaticOrderBy('prodNameDesc');"><font color="#ffffff">▲</font></a>
					<a href="javascript:goStaticOrderBy('prodNameAsc');"><font color="#ffffff">▼</font></a>				
				</th>
				<th>
					<?="수량" //수량?>
					<a href="javascript:goStaticOrderBy('orderQtyDesc');"><font color="#ffffff">▲</font></a>
					<a href="javascript:goStaticOrderBy('orderQtyAsc');"><font color="#ffffff">▼</font></a>
				</th>
				<th>
					<?=$LNG_TRANS_CHAR["EW00060"] //매출금액?>
					<a href="javascript:goStaticOrderBy('orderPriceDesc');"><font color="#ffffff">▲</font></a>
					<a href="javascript:goStaticOrderBy('orderPriceAsc');"><font color="#ffffff">▼</font></a>									
				</th>
			</tr>
			<?
			$intTotal = $intProdQty = 0;
			if (is_array($aryOrderProdList)){
				
				for($i=0;$i<sizeof($aryOrderProdList);$i++){
					$intProdQty += $aryOrderProdList[$i][P_QTY];
					$intTotal += $aryOrderProdList[$i][P_PRICE];
					?>
			<tr>
				<td style="text-align:left">
					<a href="../<?=strtolower($S_ST_LNG)?>/?menuType=product&mode=view&prodCode=<?=$aryOrderProdList[$i][P_CODE]?>" target="_blank"><img src="<?=$aryOrderProdList[$i][P_IMG_PATH]?>" style="width:50px;height:50px"></a>
					<a href="../<?=strtolower($S_ST_LNG)?>/?menuType=product&mode=view&prodCode=<?=$aryOrderProdList[$i][P_CODE]?>" target="_blank"><?=$aryOrderProdList[$i][P_NAME]?></a>
				</td>
				<td><?=NUMBER_FORMAT($aryOrderProdList[$i][P_QTY])?></td>
				<td><?=getFormatPrice($aryOrderProdList[$i][P_PRICE],2,$S_ST_CUR)?></td>
			</tr>
					<?
				}
			}
			?>
			<tr class="totRow">
				<td><?=$LNG_TRANS_CHAR["EW00079"] //합계?></td>
				<td><?=NUMBER_FORMAT($intProdQty)?></td>
				<td><?=getFormatPrice($intTotal,2,$S_ST_CUR)?></td>
			</tr>
		</table>
	</div>
	<!-- tableList -->

	
</div>
