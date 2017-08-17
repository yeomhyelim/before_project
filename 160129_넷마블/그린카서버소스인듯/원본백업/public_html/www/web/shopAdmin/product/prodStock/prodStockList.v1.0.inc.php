<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["MM00050"] //일시/품절상품관리?></h2>
		<div class="clr"></div>
	</div>

	<!-- ******** 컨텐츠 ********* -->
	<div class="searchTableWrap">
		<?include "search.skin.v1.0.inc.php";?>
	</div>
	<br>
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

	<div>
		<table class="tableList">
			<colgroup>
				<col style="width:40px;"/>
				<col style="width:60px;"/>
				<col style="width:60px;"/>
				<col/>
				<col style="width:100px;"/>
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
					while($row = mysql_fetch_array($result))		{	
						$row[P_NUM]  = (!$row[P_NUM]) ? $LNG_TRANS_CHAR["PW00019"] : $row[P_NUM];
						$strProdView = 	($row[P_WEB_VIEW] == "Y" || $row[P_MOBILE_VIEW] == "Y") ? "Yes":"No"; 
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
				<td><?=$strProdView?></td>
				<td>
					<input type="checkbox" name="prodStock1_<?=$row[P_CODE]?>" id="prodStock1_<?=$row[P_CODE]?>" value="Y" <?=($row[P_STOCK_OUT]=="Y") ? "checked":""; ?> onclick="javascript:goStockClick('1','<?=$row[P_CODE]?>');"><?=$LNG_TRANS_CHAR["PW00041"]?><br>
					<input type="checkbox" name="prodStock2_<?=$row[P_CODE]?>" id="prodStock2_<?=$row[P_CODE]?>" value="Y" <?=($row[P_RESTOCK]=="Y") ? "checked":""; ?> ><?=$LNG_TRANS_CHAR["PW00042"]?><br>
					<input type="checkbox" name="prodStock3_<?=$row[P_CODE]?>" id="prodStock3_<?=$row[P_CODE]?>" value="Y" <?=($row[P_STOCK_LIMIT]=="Y") ? "checked":""; ?> onclick="javascript:goStockClick('3','<?=$row[P_CODE]?>');"><?=$LNG_TRANS_CHAR["PW00043"]?>
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
	<div class="tableForm mt20">
		<table>
			<tr>
				<td>
					<a class="btn_big" href="javascript:goAutoStockUpdate();" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["PS00039"] //입력하신 상품의 재고 수량을 변경하시려면 클릭해주세요.?></strong></a>
				</td>
			</tr>
			<tr>
				<td>
					<select name="stockStatus" id="stockStatus">
						<option value="">:::<?=$LNG_TRANS_CHAR["OW00159"] //재고상태?> :::</option>
						<option value="1"><?=$LNG_TRANS_CHAR["PW00041"]//품절?></option>
						<option value="2"><?=$LNG_TRANS_CHAR["PW00042"]//재입고?></option>
						<option value="3"><?=$LNG_TRANS_CHAR["PW00043"]//무제한?></option>
					</select>
					
					<a class="btn_big" href="javascript:goStockStatusChoick();" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["OW00160"] //선택수정?></strong></a>
					<!--<a class="btn_big" href="javascript:goStockStatusAll();"><strong>일괄수정</strong></a>//-->

					<select name="viewStatus" id="viewStatus">
						<option value="">:::<?=$LNG_TRANS_CHAR["PW00010"]?>:::</option>
						<?if($a_admin_type != "S"){?><option value="Y">Yes</option><?}?>
						<option value="N">No</option>
					</select>
					
					<a class="btn_big" href="javascript:goViewStatusChoick();" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["OW00160"]//선택수정?></strong></a>
				</td>
			</tr>
		</table>
	</div>
</div>
<!-- ******** 컨텐츠 ********* -->