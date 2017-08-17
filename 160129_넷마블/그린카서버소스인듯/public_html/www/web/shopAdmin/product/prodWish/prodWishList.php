<div id="contentArea">
	<div class="contentTop">
		<h2>Wish/Cart</h2>
		<div class="clr"></div>
	</div>

	<!-- ******** 컨텐츠 ********* -->
	<div class="searchTableWrap">
		<?include "search.skin.{$strProductVersion}.inc.php";?>
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
				<col style="width:60px;"/>
				<col style="width:60px;"/>
				<col/>
				<?if($S_PROD_MANY_LANG_VIEW=="Y"){?><col style="width:150px;"/><?}?>
				<col style="width:150px;"/>
				<col style="width:150px;"/>
				<col style="width:150px;"/>
			</colgroup>
			<tr>
				<th rowspan="2" class="lowTh"><?=$LNG_TRANS_CHAR["CW00009"] //번호?></th>
				<th colspan="2" rowspan="2" class="lowTh"><?=$LNG_TRANS_CHAR["PW00002"] //상품명?><a href="javascript:goOrderSort('PN','desc');"><span>▲</span></a><a href="javascript:goOrderSort('PN','asc');"><span>▼</span></a></th>
				<?if($S_PROD_MANY_LANG_VIEW=="Y"){?><th rowspan="2"><?=$LNG_TRANS_CHAR["PW00010"] //상품출력?></th><?}?>
				<!-- th rowspan="2" class="lowTh"><?=$LNG_TRANS_CHAR["PW00121"] //수량?><a href="javascript:goOrderSort('PQ','desc');"><span>▲</span></a><a href="javascript:goOrderSort('PQ','asc');">▼</a></th -->
				<th><?=$LNG_TRANS_CHAR["PW00228"] //담아두기 총수량?> <a href="javascript:goOrderSort('WQ','desc');"><span>▲</span></a><a href="javascript:goOrderSort('WQ','asc');"><span>▼</span></a></th>
				<th><?=$LNG_TRANS_CHAR["PW00229"] //담아두기한 총인원?> <a href="javascript:goOrderSort('WP','desc');"><span>▲</span></a><a href="javascript:goOrderSort('WP','asc');"><span>▼</span></a></th>
				<th><?=$LNG_TRANS_CHAR["PW00230"] //담아두기한 회원?> <a href="javascript:goOrderSort('WM','desc');"><span>▲</span></a><a href="javascript:goOrderSort('WM','asc');"><span>▼</span></a></th>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00231"] //쇼핑카트담기 총수량?> <a href="javascript:goOrderSort('CQ','desc');"><span>▲</span></a><a href="javascript:goOrderSort('CQ','asc');"><span>▼</span></a></th>
				<th><?=$LNG_TRANS_CHAR["PW00232"] //쇼핑카트담기한 총인원?> <a href="javascript:goOrderSort('CP','desc');"><span>▲</span></a><a href="javascript:goOrderSort('CP','asc');"><span>▼</span></a></th>
				<th><?=$LNG_TRANS_CHAR["PW00233"] //쇼핑카트담기한 회원?> <a href="javascript:goOrderSort('CM','desc');"><span>▲</span></a><a href="javascript:goOrderSort('CM','asc');"><span>▼</span></a></th>				
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
				<td rowspan="2"><?=$intListNum?></td>
				<td rowspan="2" style="width:50px;"><a href="javascript:goOpenWindow('<?=$row[P_CODE]?>')"><img src="<?=$row[PM_REAL_NAME]?>" class="prodPhoto"></a></td>
				<td rowspan="2" class="prodListInfo">					
					<ul>
						<li class="title"><?=$row[P_NAME]?></li>
						<li><span><?=$LNG_TRANS_CHAR["PW00021"] //카테고리?>:</span><?=getCateName($row[P_CATE],$strStLng)?></li>
						<li><span><?=$LNG_TRANS_CHAR["PW00176"] //상품번호?>:</span><?=$row[P_CODE]?></li>
						<li><span><?=$LNG_TRANS_CHAR["PW00003"] //상품코드?>:</span><?=$row[P_NUM]?></li>
					</ul>
					<div class="clr"></div>
				</td>
				<?if($S_PROD_MANY_LANG_VIEW=="Y"){?>
				<td rowspan="2">
					<ul>
					<?
						foreach($aryUseLng as $lngKey => $lngVal){
							$strUseLngText = $strWebUseChecked = $strMobUseChecked = $strUseLngViewText = "";
							if ($row['P_WEB_VIEW_'.$lngVal] == "Y") $strWebUseChecked = "checked";
							if ($row['P_MOB_VIEW_'.$lngVal] == "Y") $strMobUseChecked = "checked";
							
							$strUseLngViewText = "View";
							if ($strWebUseChecked == "checked") $strUseLngViewText = "<strong>View</strong>";
							
							if ($intUseLngCount > 1) $strUseLngText = "<span>$lngVal</span>:";
							echo "<li class='nation_{$lngVal}'>{$strUseLngText}{$strUseLngViewText}</li>";
						}
					?>
					</ul>
				</td>
				<?}?>
				<!-- td rowspan="2"><?=NUMBER_FORMAT($row[P_QTY])?></td -->
				<td><?=NUMBER_FORMAT($row[W_QTY])?></td>
				<td><?=NUMBER_FORMAT($row[W_CNT])?></td>
				<td><?=NUMBER_FORMAT($row[W_MEM_CNT])?></td>
			</tr>
			<tr>
				<td><?=NUMBER_FORMAT($row[B_QTY])?></td>
				<td><?=NUMBER_FORMAT($row[B_CNT])?></td>
				<td><?=NUMBER_FORMAT($row[B_MEM_CNT])?></td>
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
</div>
<!-- ******** 컨텐츠 ********* -->