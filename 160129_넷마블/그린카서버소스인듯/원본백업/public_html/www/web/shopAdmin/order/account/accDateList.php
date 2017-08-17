<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["OW00094"]?></h2>
		<div class="clr"></div>
	</div>
	<div class="tabImgWrap mt10">
		<a href="javascript:javascript:goInitMoveUrl('accList','<?=$strSearchAccStatus?>');" <?=($strMode=="accList")?"class=\"selected\"":"";?>>주문별</a>	
		<a href="javascript:javascript:goInitMoveUrl('accPeriodList','<?=$strSearchAccStatus?>');" <?=($strMode=="accPeriodList")?"class=\"selected\"":"";?>>주문기간별</a>
		<a href="javascript:javascript:goInitMoveUrl('accDateList','');" <?=($strMode=="accDateList")?"class=\"selected\"":"";?>>구매일자별</a>
	</div>

	<!-- ******** 컨텐츠 ********* -->
	<div class="searchTableWrap">
		<div class="searchFormWrap">
			<select name="searchField" id="searchField">
				<option value="K" <?=($strSearchField=="K")?"selected":"";?>><?=$LNG_TRANS_CHAR["OW00002"] //주문번호?></option>
				<option value="N" <?=($strSearchField=="N")?"selected":"";?>>상품명</option>
			</select>
			<input type="text" id="searchKey" name="searchKey" value="<?=$strSearchKey?>" <?=$nBox?>/>
			
		</div><!-- searchFormWrap -->
		<table>
			<tr>
				<th>구매일자</th>
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
				</td>
			</tr>
			<?if ($a_admin_type == "A"){?>
			<tr>
				<th><?=$LNG_TRANS_CHAR["OW00096"] //업체명?></th>
				<td>
					<?=drawSelectBoxMore("searchCompany",$aryShopList,$strSearchCompany,$design ="",$onchange="",$etc="",$LNG_TRANS_CHAR["OW00100"],$html="N")?>
				</td>
			</tr>
			<?}?>
			<tr>
				<th><?=$LNG_TRANS_CHAR["OW00006"] //결제방법?></th>
				<td>
					<?foreach($S_ARY_SETTLE_TYPE as $key => $value):
						if (in_array($key,$arySiteSettle) || in_array($key,$arySiteForSettle) || in_array($key,array("B","P"))){ 
					?>
					<input type="checkbox" id="searchSettleType" name="searchSettleType[]" value="<?=$key?>"<?if(in_array($key, $arySearchSettleType)){echo " checked";}?>><?=$value?> 
					<?	}?>
					<?endforeach;?>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="padding-top:10px;text-align:center;">
					<a class="btn_search" href="javascript:goSearch('accDateList');" style="width:400px;"><strong class="ico_search"><?=$LNG_TRANS_CHAR["CW00027"]?></strong></a>
					<a class="btn_excel_big" href="javascript:goExcel('excelAccDateList');" id="menu_auth_e" style="display:none:"><strong>Excel Download</strong></a>
				</td>
			</tr>
		</table>
	</div>
	<div class="tableFormWrap mt10">
		<table class="tableForm">
			<colgroup>
				<col width="100">
				<col/>
				<col width="100">
				<col/>
			</colgroup>
			<tr>
				<th>총입고금액</th>
				<td><?=getFormatPrice($accSumRow[TOT_STOCK_PRICE])?></td>
				<th>총판매금액</th>
				<td><?=getFormatPrice($accSumRow[TOT_SALE_PRICE])?></td>
			</tr>
		</table>
	</div>	

	<div class="tableList mt10">
		<table style="border-left:1px solid #D2D0D0">
			<colgroup>
				<col width=40/>
				<col width=150/>
				<col width=100/>
				<col />
				<col />
				<col width=50/>
				<col width=100/>
				<col width=100/>
				<col width=100/>
				<col width=80/>
			</colgroup>
			<tr>
				<th><?=$LNG_TRANS_CHAR["CW00009"] //번호?></th>
				<th><?=$LNG_TRANS_CHAR["OW00002"] //주문번호?>/<?=$LNG_TRANS_CHAR["OW00074"] //주문일시?></th>
				<th><?="결제방법" //결제방법?></th>
				<th><?=$LNG_TRANS_CHAR["OW00096"] //업체명?></th>
				<th>상품명</th>
				<th>수량</th>
				<th><?=$LNG_TRANS_CHAR["OW00097"] //입고가격?></th>
				<th><?=$LNG_TRANS_CHAR["OW00098"] //판매가격?></th>
				<th><?="추가가격" //추가가격?></th>
				<th>과세/비과세</th>
			</tr>
			<?if ($intTotal == 0){?>
			<tr>
				<td colspan="11"><?=$LNG_TRANS_CHAR["CS00001"]?></td>
			</tr>
			<?}else{
				while($row = mysql_fetch_array($result)){
					
					$strProdShopName = $aryShopList[$row['P_SHOP_NO']]; 
					if (!$strProdShopName) $strProdShopName = "본사";

					/* 주문내역 가지고 오기*/
					$accMgr->setO_NO($row[O_NO]);
					$accMgr->setSH_NO($row[SH_NO]);
					$aryOrderCartList = $accMgr->getOrderCartList($db);
					
					$strOrderSettle = $S_ARY_SETTLE_TYPE[$row['O_SETTLE']];		// 결제방법	

					$strCartOptAttrVal = "";
					for($kk=1;$kk<=10;$kk++){
						if ($row["OC_OPT_ATTR".$kk]){
							$strCartOptAttrVal .= "/".$row["OC_OPT_ATTR".$kk];
						}
					}
					$strCartOptAttrVal = SUBSTR($strCartOptAttrVal,1);
				?>
			<tr>
				<td><?=$intListNum?></td>
				<td>
					<span><a href="javascript:goOrderView(<?=$row['O_NO']?>,<?=$row['P_SHOP_NO']?>);"><?=$row[O_KEY]?></a></span><br>
					<span class="orderDate">[<?=$row[O_REG_DT]?>]</span>
				</td>
				<td><?=$strOrderSettle?></td>
				<td><?=$strProdShopName?></td>
				<td style="text-align:left"><?=$row[OC_P_NAME]?><?=($strCartOptAttrVal)?"({$strCartOptAttrVal})":"";?></td>
				<td><?=$row[OC_QTY]?></td>
				<td><?=getFormatPrice($row[OC_STOCK_CUR_PRICE])?></td>
				<td><?=getFormatPrice($row[OC_CUR_PRICE])?></td>
				<td><?=getFormatPrice($row[OC_OPT_ADD_CUR_PRICE])?></td>
				<td><?=($row['P_TAX']=="Y")?"과세":"비과세";?></td>
			</tr>
			<?
					$intListNum--;
				}
			}
			?>
		</table>
	</div>
	<!-- tableList -->

	<!-- Pagenate object --> 
	<div class="paginate mt10">  
		<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?> 
	</div>  
	<!-- Pagenate object --> 	
</div>
