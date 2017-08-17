<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["MM00050"] //일시/품절상품관리?></h2>
		<div class="clr"></div>
	</div>

	<!-- 검색 -->
	<div class="searchTableWrap">
		<?include "search.skin.v2.0.inc.php";?>
	</div>
	<!-- ******** 컨텐츠 ********* -->

	<div class="tableListWrap">
		<div class="tableListTopWrap">
			<span class="listCntNum">* <?=callLangTrans($LNG_TRANS_CHAR["PS00028"],array($intTotal))?><!--총 <strong><?=$intListNum?>개</strong>의 상품이 있습니다.//--></span>
			<div class="selectedSort">
				<span class="spanTitle mt5"><?=$LNG_TRANS_CHAR["PW00117"] //목록수?>:</span>
				<select name="pageLine" style="vertical-align:middle;" onchange="javascript:C_getMoveUrl('<?=$strMode?>','get','<?=$PHP_SELF?>');">
					<option value="10" <? if($intPageLine==10) echo 'selected';?>>10</option>
					<option value="20" <? if($intPageLine==20) echo 'selected';?>>20</option>
					<option value="30" <? if($intPageLine==30) echo 'selected';?>>30</option>
					<option value="40" <? if($intPageLine==40) echo 'selected';?>>40</option>
					<option value="50" <? if($intPageLine==50) echo 'selected';?>>50</option>
					<option value="60" <? if($intPageLine==60) echo 'selected';?>>60</option>
					<option value="70" <? if($intPageLine==70) echo 'selected';?>>70</option>
					<option value="80" <? if($intPageLine==80) echo 'selected';?>>80</option>
					<option value="90" <? if($intPageLine==90) echo 'selected';?>>90</option>
					<option value="100" <? if($intPageLine==100) echo 'selected';?>>100</option>
					<option value="200" <? if($intPageLine==200) echo 'selected';?>>200</option>
				</select>
			</div>
		<div class="clr"></div>
	</div>
	<!--  버튼영역 -->
		<div class="listSortBtnWrap">
			<div class="left">
				<a class="btn_big" href="javascript:goProdStockUpdate();" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["PW00190"]//재고상태변경?></strong></a>
				<a class="btn_big" href="javascript:goAutoStockUpdate();" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["PW00189"]//재고수량변경?></strong></a>
				<a class="btn_big" href="javascript:goAutoViewUpdate();" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["PW00191"]//상품출력변경?></strong></a>
			</div>
			<div class="clr"></div>
		</div>
	<!--  버튼영역 -->
	<div>
		<table class="tableList">
			<colgroup>
				<col style="width:40px;"/>
				<col style="width:60px;"/>
				<col style="width:60px;"/>
				<col/>
				<col style="width:150px;"/>
				<col style="width:150px;"/>
				<col style="width:150px;"/>
				<col style="width:80px;"/>
			</colgroup>
			<tr>
				<th><input type="checkbox" name="chkAll" value="Y" onclick="javascript:C_getCheckAll(this.checked)"/></th>
				<th><?=$LNG_TRANS_CHAR["CW00009"] //번호?></th>
				<th colspan="2"><?=$LNG_TRANS_CHAR["PW00002"] //상품명?></th>
				<th><?=$LNG_TRANS_CHAR["PW00010"] //상품출력?></th>
				<th><?=$LNG_TRANS_CHAR["PW00017"] //재고?></th>
				<th><?=$LNG_TRANS_CHAR["PW00121"] //수량?></th>
				<th><?=$LNG_TRANS_CHAR["PW00118"] //옵션재고?></th>
			</tr>
			<?if ($intTotal == 0){?>
			<tr>
				<td colspan="8"><?=$LNG_TRANS_CHAR["CS00001"]?></td>
			</tr>
			<?	
				/* PHP CODE */
				}else{				
					while($row = mysql_fetch_array($result))		
					{	
						$strProdCode = $row['P_CODE'];
						$row[P_NUM]  = (!$row[P_NUM]) ? $LNG_TRANS_CHAR["PW00019"] : $row[P_NUM];
				/* PHP CODE */
			?>
			<tr>
				<td><input type="checkbox" id="chkNo[]" name="chkNo[]" value="<?=$row[P_CODE]?>"></td>
				<td><?=$intListNum?></td>
				<td style="width:50px;"><a href="javascript:goOpenWindow('<?=$row[P_CODE]?>')"><img src="..<?=$row[PM_REAL_NAME]?>" class="prodPhoto"></a></td>
				<td class="prodListInfo">					
					<ul>
						<li class="title"><?=$row[P_NAME]?></li>
						<li><span><?=$LNG_TRANS_CHAR["PW00021"] //카테고리?>:</span><?=getCateName($row[P_CATE],$strStLng)?></li>
						<li><span><?=$LNG_TRANS_CHAR["PW00176"] //상품번호?>:</span><?=$row[P_CODE]?></li>
						<li><span><?=$LNG_TRANS_CHAR["PW00003"] //상품코드?>:</span><?=$row[P_NUM]?></li>
					</ul>
					<div class="clr"></div>
				</td>
				<td>
					<ul class="langViewType">
					<?
						foreach($aryUseLng as $lngKey => $lngVal){
							$strUseLngText = $strWebUseChecked = $strMobUseChecked = $strUseLngViewText = "";
							if ($row['P_WEB_VIEW_'.$lngVal] == "Y") $strWebUseChecked = "checked";
							if ($row['P_MOB_VIEW_'.$lngVal] == "Y") $strMobUseChecked = "checked";
							
							$strUseLngViewText = "View";
							if ($strWebUseChecked == "checked") $strUseLngViewText = "<strong>View</strong>";
							
							if ($intUseLngCount > 1) $strUseLngText = "<span>$lngVal</span>:";
							echo "<li class='nation_{$lngVal}'>{$strUseLngText}<input type='checkbox' name='prodWebView{$lngVal}_{$strProdCode}' value='Y' {$strWebUseChecked}>{$strUseLngViewText}</li>";
						}
					?>
					</ul>
				</td>
				<td>
					<ul>
						<li>
							<input type="checkbox" name="prodStock1_<?=$row[P_CODE]?>" id="prodStock1_<?=$row[P_CODE]?>" value="Y" <?=($row[P_STOCK_OUT]=="Y") ? "checked":""; ?> onclick="javascript:goStockClick('1','<?=$row[P_CODE]?>');" disabled><?=$LNG_TRANS_CHAR["PW00041"]?>
						</li>
						<li>
							<input type="checkbox" name="prodStock2_<?=$row[P_CODE]?>" id="prodStock2_<?=$row[P_CODE]?>" value="Y" <?=($row[P_RESTOCK]=="Y") ? "checked":""; ?> disabled><?=$LNG_TRANS_CHAR["PW00042"]?>
						</li>
						<li>
							<input type="checkbox" name="prodStock3_<?=$row[P_CODE]?>" id="prodStock3_<?=$row[P_CODE]?>" value="Y" <?=($row[P_STOCK_LIMIT]=="Y") ? "checked":""; ?> onclick="javascript:goStockClick('3','<?=$row[P_CODE]?>');" disabled><?=$LNG_TRANS_CHAR["PW00043"]?>
						</li>
					</ul>
				</td>
				<td><input type="input" name="prodQty_<?=$row[P_CODE]?>" id="prodQty_<?=$row[P_CODE]?>" value="<?=$row[P_QTY]?>" <?=$nBox?> style="width:80px;text-align:right;" <?=($row[P_OPT]!="1")?"readonly":"";?>/></td>
				<td>
					<?if($row[P_OPT] != "1"){?>
					<a class="btn_blue_sml" href="javascript:goProdOptStock('<?=$row[P_CODE]?>');" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["PW00118"] //옵션재고?></strong></a>
					<?}?>
				</td>
			</tr>
			<?
					$intListNum--;
				}
			}
			?>
		</table>
	</div>
	<div class="paginate mt20">
		<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?>
	</div>
	<div>
		<a class="btn_big" href="javascript:goProdStockUpdate();" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["PW00190"]//재고상태변경?></strong></a>
		<a class="btn_big" href="javascript:goAutoStockUpdate();" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["PW00189"]//재고수량변경?></strong></a>
		<a class="btn_big" href="javascript:goAutoViewUpdate();" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["PW00191"]//상품출력변경?></strong></a>
	</div>

</div>
<!-- ******** 컨텐츠 ********* -->