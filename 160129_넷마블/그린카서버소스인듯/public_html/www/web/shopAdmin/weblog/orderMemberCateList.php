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
		data['act']					= "excelOrderMemberCateList";
		data['searchRegStartDt']	= $("#searchRegStartDt").val();
		data['searchRegEndDt']		= $("#searchRegEndDt").val();

		C_getAddLocationUrl(data);
	}

	function goOrderDetailList(status,level,code)
	{
		var data = new Array(5);
		data['menuType']			= "order";
		data['mode']				= "list";
		data['searchRegStartDt']	= $("#searchRegStartDt").val();
		data['searchRegEndDt']		= $("#searchRegEndDt").val();
		data['searchNation']		= "KR";
		
		if (level == 1)
		{
			data['searchCate1']		= code;
		}

		if (level == 2)
		{
			data['searchCate1']		= code.substring(0,3);
			data['searchCate2']		= code;
		}
		data['searchOrderStatus']	= status;
		data['_target']				= "_blank";
		C_getSelfMove(data);
	}

	/* 소속 구매 내역 */
	function goMemberCateOrderList(status,code,level)
	{
		var strParam = "";
		strParam += "&cateCode="+code;
		strParam += "&cateLevel="+level;
		strParam += "&orderStatus="+status;
		strParam += "&searchRegStartDt="+$("#searchRegStartDt").val();	
		strParam += "&searchRegEndDt="+$("#searchRegEndDt").val();
		
		$.smartPop.open({  bodyClose: false, width: 700, height: 600, url: './?menuType=member&mode=popMemberCateOrderList'+strParam, closeImg: {width:23, height:23, src:'/shopAdmin/himg/common/btn_pop_close.png'} });
	}
//-->
</script>
<div id="contentArea">
	<div class="contentTop">
		<h2>소속별주문통계</h2>
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
						<a class="btn_sml" href="javascript:C_getSearchDay('A','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00022"]?></strong></a>
						<a class="btn_blue_big" href="javascript:goSearch();"><strong><?=$LNG_TRANS_CHAR["CW00027"] //검색?></strong></a>
					</span>
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
					<!--<select name="searchCate2" id="c_cate" no="2">
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
					</select>//-->
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
				<col style="width:200px;"/>	
				<col style="background-color:#f1f7f9" />
				<col style="min-width:200px;"/>
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
				<th rowspan="2">소속</th>
				<th rowspan="2">총매출액</th>
				<th colspan="2">주문완료</th>
				<th colspan="2">결제완료</th>
				<th colspan="2">배송준비중</th>
				<th colspan="2">배송중</th>
				<th colspan="2">배송완료</th>
				<th colspan="2">구매완료</th>
				<th colspan="2">주문취소</th>
			</tr>
			<tr>
				<th>건수</th>
				<th>금액</th>
				<th>건수</th>
				<th>금액</th>
				<th>건수</th>
				<th>금액</th>
				<th>건수</th>
				<th>금액</th>
				<th>건수</th>
				<th>금액</th>
				<th>건수</th>
				<th>금액</th>
				<th>건수</th>
				<th>금액</th>
			</tr>
			<?
			if (is_array($aryOrderSaleList)){

				$aryOrderStatus['J']['CNT']		= 0;
				$aryOrderStatus['J']['PRICE']	= 0;

				$aryOrderStatus['A']['CNT']		= 0;
				$aryOrderStatus['A']['PRICE']	= 0;

				$aryOrderStatus['B']['CNT']		= 0;
				$aryOrderStatus['B']['PRICE']	= 0;

				$aryOrderStatus['I']['CNT']		= 0;
				$aryOrderStatus['I']['PRICE']	= 0;

				$aryOrderStatus['D']['CNT']		= 0;
				$aryOrderStatus['D']['PRICE']	= 0;

				$aryOrderStatus['E']['CNT']		= 0;
				$aryOrderStatus['E']['PRICE']	= 0;

				$aryOrderStatus['C']['CNT']		= 0;
				$aryOrderStatus['C']['PRICE']	= 0;

				$intOrderAllTotalPrice			= 0;

				for($i=0;$i<sizeof($aryOrderSaleList);$i++){

					$intOrderTotalPrice				= 0;
					$intOrderTotalPrice				= ($aryOrderSaleList[$i][O_STATUS_PRICE2] + $aryOrderSaleList[$i][O_STATUS_PRICE3] +
						$aryOrderSaleList[$i][O_STATUS_PRICE4] + $aryOrderSaleList[$i][O_STATUS_PRICE5] + $aryOrderSaleList[$i][O_STATUS_PRICE6]);

					if ($aryOrderSaleList[$i][C_LEVEL] > 1) {

						$intOrderAllTotalPrice		   += ($aryOrderSaleList[$i][O_STATUS_PRICE2] + $aryOrderSaleList[$i][O_STATUS_PRICE3] +
						$aryOrderSaleList[$i][O_STATUS_PRICE4] + $aryOrderSaleList[$i][O_STATUS_PRICE5] + $aryOrderSaleList[$i][O_STATUS_PRICE6]);
					
						$aryOrderStatus['J']['CNT']		= $aryOrderStatus['J']['CNT']   + $aryOrderSaleList[$i][O_STATUS_CNT1];
						$aryOrderStatus['J']['PRICE']	= $aryOrderStatus['J']['PRICE'] + $aryOrderSaleList[$i][O_STATUS_PRICE1];

						$aryOrderStatus['A']['CNT']		= $aryOrderStatus['A']['CNT']   + $aryOrderSaleList[$i][O_STATUS_CNT2];
						$aryOrderStatus['A']['PRICE']	= $aryOrderStatus['A']['PRICE'] + $aryOrderSaleList[$i][O_STATUS_PRICE2];

						$aryOrderStatus['B']['CNT']		= $aryOrderStatus['B']['CNT']   + $aryOrderSaleList[$i][O_STATUS_CNT3];
						$aryOrderStatus['B']['PRICE']	= $aryOrderStatus['B']['PRICE'] + $aryOrderSaleList[$i][O_STATUS_PRICE3];

						$aryOrderStatus['I']['CNT']		= $aryOrderStatus['I']['CNT']   + $aryOrderSaleList[$i][O_STATUS_CNT4];
						$aryOrderStatus['I']['PRICE']	= $aryOrderStatus['I']['PRICE'] + $aryOrderSaleList[$i][O_STATUS_PRICE4];

						$aryOrderStatus['D']['CNT']		= $aryOrderStatus['D']['CNT']   + $aryOrderSaleList[$i][O_STATUS_CNT5];
						$aryOrderStatus['D']['PRICE']	= $aryOrderStatus['D']['PRICE'] + $aryOrderSaleList[$i][O_STATUS_PRICE5];

						$aryOrderStatus['E']['CNT']		= $aryOrderStatus['E']['CNT']   + $aryOrderSaleList[$i][O_STATUS_CNT6];
						$aryOrderStatus['E']['PRICE']	= $aryOrderStatus['E']['PRICE'] + $aryOrderSaleList[$i][O_STATUS_PRICE6];

						$aryOrderStatus['C']['CNT']		= $aryOrderStatus['C']['CNT']   + $aryOrderSaleList[$i][O_STATUS_CNT7];
						$aryOrderStatus['C']['PRICE']	= $aryOrderStatus['C']['PRICE'] + $aryOrderSaleList[$i][O_STATUS_PRICE7];
					}

					$strCateCode					= $aryOrderSaleList[$i][C_CODE];
					$intCateLevel					= $aryOrderSaleList[$i][C_LEVEL];
					$strStep						= $aryOrderSaleList[$i][C_LEVEL];
					$strStep						= "cate{$strStep}";


					?>
			<tr>
				<td style="text-align:left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="<?=$strStep?>"><?=$aryOrderSaleList[$i][C_NAME]?></span></td>
				<td><?=getFormatPrice($intOrderTotalPrice,2,$S_ST_CUR)?></td>
				<td><a href="javascript:goMemberCateOrderList('J','<?=$strCateCode?>','<?=$intCateLevel?>');"><?=NUMBER_FORMAT($aryOrderSaleList[$i][O_STATUS_CNT1])?></a></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][O_STATUS_PRICE1],2,$S_ST_CUR)?></td>
				<td><a href="javascript:goMemberCateOrderList('A','<?=$strCateCode?>','<?=$intCateLevel?>');"><?=NUMBER_FORMAT($aryOrderSaleList[$i][O_STATUS_CNT2])?></a></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][O_STATUS_PRICE2],2,$S_ST_CUR)?></td>
				<td><a href="javascript:goMemberCateOrderList('B','<?=$strCateCode?>','<?=$intCateLevel?>');"><?=NUMBER_FORMAT($aryOrderSaleList[$i][O_STATUS_CNT3])?></a></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][O_STATUS_PRICE3],2,$S_ST_CUR)?></td>
				<td><a href="javascript:goMemberCateOrderList('I','<?=$strCateCode?>','<?=$intCateLevel?>');"><?=NUMBER_FORMAT($aryOrderSaleList[$i][O_STATUS_CNT4])?></a></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][O_STATUS_PRICE4],2,$S_ST_CUR)?></td>
				<td><a href="javascript:goMemberCateOrderList('D','<?=$strCateCode?>','<?=$intCateLevel?>');"><?=NUMBER_FORMAT($aryOrderSaleList[$i][O_STATUS_CNT5])?></a></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][O_STATUS_PRICE5],2,$S_ST_CUR)?></td>
				<td><a href="javascript:goMemberCateOrderList('E','<?=$strCateCode?>','<?=$intCateLevel?>');"><?=NUMBER_FORMAT($aryOrderSaleList[$i][O_STATUS_CNT6])?></a></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][O_STATUS_PRICE6],2,$S_ST_CUR)?></td>
				<td><a href="javascript:goMemberCateOrderList('C','<?=$strCateCode?>','<?=$intCateLevel?>');"><?=NUMBER_FORMAT($aryOrderSaleList[$i][O_STATUS_CNT7])?></a></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][O_STATUS_PRICE7],2,$S_ST_CUR)?></td>
			</tr>
					<?
				}
			}
			?>
			<tr class="totRow">
				<td class="txtCenter"><?=$LNG_TRANS_CHAR["EW00079"] //합계?></td>
				<td><?=getFormatPrice($intOrderAllTotalPrice,2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderStatus['J']['CNT'])?></td>
				<td><?=getFormatPrice($aryOrderStatus['J']['PRICE'],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderStatus['A']['CNT'])?></td>
				<td><?=getFormatPrice($aryOrderStatus['A']['PRICE'],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderStatus['B']['CNT'])?></td>
				<td><?=getFormatPrice($aryOrderStatus['B']['PRICE'],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderStatus['I']['CNT'])?></td>
				<td><?=getFormatPrice($aryOrderStatus['I']['PRICE'],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderStatus['D']['CNT'])?></td>
				<td><?=getFormatPrice($aryOrderStatus['D']['PRICE'],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderStatus['E']['CNT'])?></td>
				<td><?=getFormatPrice($aryOrderStatus['E']['PRICE'],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderStatus['C']['CNT'])?></td>
				<td><?=getFormatPrice($aryOrderStatus['C']['PRICE'],2,$S_ST_CUR)?></td>	
			</tr>
		</table>
	</div>
	<!-- tableList -->

		<div class="noticeInfoWrap">
		<ul>
			<li>* 주문에 관련한 통계는 구매확정을 기준으로 만들어 집니다.  배송완료건에 대해 구매확정이 되었는지 확인 필요합니다.</li>
			<li>* 통계의 기준은 주문일자를 기준으로 리스트됩니다.</li>
			<li class="topLine">- <span class="tit">총매출액</span>: "결제완료 + 배송준비중 + 배송중 + 배송완료 + 구매완료"의 합산금액입니다.</li>
			<li>- <span class="tit">주문완료</span>: "무통장 및 가상계좌" 등 으로 주문된 결제 확인전 주문목록 입니다.</li>
			<li>- <span class="tit">결제완료</span>:  실제 결제가 완료된 주문</li>
			<li>- <span class="tit">배송중</span>: 송장번호가 입력되어 배송 진행중인 목록</li>
			<li>- <span class="tit">배송완료</span>: 배송이 완료된 상태이며 택배사 API가 연동되지 않은경우는 관리자가 직접 배송완료 상태로 변경해 주셔야 합니다.</li>
			<li>- <span class="tit">구매완료</span>: 구매자 또는 관리자가 구매확정으로 변경한 상태입니다.</li>
			<li>- <span class="tit">주문취소</span>: 주문취소 및 반품 합산 금액</li>
		</ul>
	</div>

</div>
