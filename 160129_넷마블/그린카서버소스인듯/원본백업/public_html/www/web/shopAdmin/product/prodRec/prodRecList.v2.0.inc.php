<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["MM00056"]//추천상품관리?></h2>
		<div class="clr"></div>
	</div>

	<!-- ******** 컨텐츠 ********* -->
	<div class="searchTableWrap">
		<? include "search.skin.v2.0.inc.php";?>
	</div>
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
				<input type="hidden" name="order" id="order" value="<?=$strProdOrder?>">
			</div>
		<div class="clear"></div>
	</div>
	<div>
		<a class="btn_big" href="javascript:goAutoRecUpdate();" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["PW00192"]//상품진열정보변경?></strong></a>
		<a class="btn_big" href="javascript:goRecUpdate();" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["MM00131"]//일괄수정?></strong></a>
	</div>
	<div>
		<table class="tableList">
			<colgroup>
				<col style="width:40px;"/>
				<col style="width:60px;"/>
				<col style="width:50px;"/>
				<col/>
				<col/>
				<col/>
				<?
					if (is_array($aryProdMainDisplayList)){	
						for($i=0;$i<sizeof($aryProdMainDisplayList);$i++){
							if ($aryProdMainDisplayList[$i][IC_USE] == "Y"){
					?>
				<col/>
					<?		}
						}
					}
				?>
				<?
					if (is_array($aryProdSubDisplayList)){
						for($i=0;$i<sizeof($aryProdSubDisplayList);$i++){
							if ($aryProdSubDisplayList[$i][IC_USE] == "Y"){
					?>
				<col/>
				<?
							}
						}
					}
				?>
			</colgroup>
			<tr>
				<th><input type="checkbox" name="chkAll" value="Y" onclick="javascript:C_getCheckAll(this.checked)"/></th>
				<th><?=$LNG_TRANS_CHAR["CW00009"] //번호?></th>
				<th colspan="2"><?=$LNG_TRANS_CHAR["PW00002"] //상품명?>
					<a href="javascript:goOrderEvent('ND');" class="btn_up"><span>▲</span></a>
					<a href="javascript:goOrderEvent('NA');" class="btn_down"><span>▼</span></a></th>
				<th>
					<?=$LNG_TRANS_CHAR["PW00026"] //상품우선순위?>
					<a href="javascript:goOrderEvent('PSD');" class="btn_up"><span>▲</span></a>
					<a href="javascript:goOrderEvent('PSA');" class="btn_down"><span>▼</span></a>
				</th>
				<th>
					<?=$LNG_TRANS_CHAR["PW00010"] //상품출력?>
					<a href="javascript:goOrderEvent('PVD');" class="btn_up"><span>▲</span></a>
					<a href="javascript:goOrderEvent('PVA');" class="btn_down"><span>▼</span></a>
				</th>
				<?
					if (is_array($aryProdMainDisplayList)){	
						for($i=0;$i<sizeof($aryProdMainDisplayList);$i++){
							if ($aryProdMainDisplayList[$i][IC_USE] == "Y"){
					?>
				<th><?=$aryProdMainDisplayList[$i][IC_NAME]?></th>
					<?		}
						}
					}
				?>
				<?
					if (is_array($aryProdSubDisplayList)){
						for($i=0;$i<sizeof($aryProdSubDisplayList);$i++){
							if ($aryProdSubDisplayList[$i][IC_USE] == "Y"){
					?>
				<th><?=$aryProdSubDisplayList[$i][IC_NAME]?></th>
				<?
							}
						}
					}
				?>
			</tr>
			<?if ($intTotal == 0){?>
			<tr>
				<td colspan="30"><?=$LNG_TRANS_CHAR["CS00001"]?></td>
			</tr>
			<?	
				/* PHP CODE */
				}else{		
					while($row = mysql_fetch_array($result))		{	
						$param					= "";

						## 기본 설정
						$strProdCode			= $row['P_CODE'];
						$strProdName			= $row['P_NAME'];
						$strProdNum				= $row['P_NUM'];
						$strProdShopName		= $row['SH_COM_NAME'];
						$strProdImageName		= $row['PM_REAL_NAME'];
						$strProdCate			= $row['P_CATE'];
						$strProdWebView			= $row['P_WEB_VIEW'];
						$strProdMobView			= $row['P_MOB_VIEW'];
						$strProdStockOut		= $row['P_STOCK_OUT'];
						$strProdStockLimit		= $row['P_STOCK_LIMIT'];
						$strProdRepDt			= $row['P_REP_DT'];

						$strMoneyIconLeft		= $S_ARY_MONEY_ICON[$S_ST_LNG]["L"];
						$strMoneyIconRight		= $S_ARY_MONEY_ICON[$S_ST_LNG]["R"];
						
						$intProdSalePrice		= getCurToPrice($row['P_SALE_PRICE'], $S_ST_LNG);
						$intProdStockPrice		= getCurToPrice($row['P_STOCK_PRICE'],$S_ST_LNG);
						$intProdConsumerPrice	= getCurToPrice($row['P_CONSUMER_PRICE'],$S_ST_LNG);
						$intProdPoint			= getCurToPrice($row['P_POINT'],$S_ST_LNG);
						$intProdCommisionPrice	= $row['P_COMMISION_PRICE'];
						$intProdCommisionRate	= $row['P_COMMISION_RATE'];
						$intProdQty				= $row['P_QTY'];
						$intProdOrder			= $row['P_ORDER'];
						
						## 입범몰이 없는 경우
						if(!$strProdShopName) { $strProdShopName= "본사"; }

						## 상품 이미지가 없는 경우
						if(!$strProdImageName) { $strProdImageName = "/upload/images/prodListNoImage.png"; }
						
						## 상품번호가 없을 경우
						if (!$strProdNum) { $strProdNum = $LNG_TRANS_CHAR["PW00019"];}

						$bolDiscountShow	= true;
						$intEvent			= $row['P_EVENT'];
						$strEventInfo		= getProdEventInfo($row,"Y");
						$strEventTitle		= $aryShopEventInfo[$row['P_EVENT']]['TITLE'];
						## 할인상품 표시 여부
						if($strEventInfo != "Y")	{ $bolDiscountShow = false; }
						if($intEvent >= 0)			{ $bolDiscountShow = false; }
						
						## 상품공유카테고리리스트
						##$aryProdShareList	= $objProductListModule->getProductShareListSelectEx("OP_ARYTOTAL",$param);			
						
						## 상품출력 설정
						$strProdWebViewIcon		= "/shopAdmin/himg/common/ico_w_view_N.gif";
						$strProdMobViewIcon		= "/shopAdmin/himg/common/ico_m_view_N.gif";
						if($strProdWebView == "Y") { $strProdWebViewIcon = "/shopAdmin/himg/common/ico_w_view_Y.gif"; }
						if($strProdMobView == "Y") { $strProdMobViewIcon = "/shopAdmin/himg/common/ico_m_view_Y.gif"; }

						## 상품수량	
						$strProdQty			= number_format($intProdQty);
						if ($strProdStockOut == "Y"){
							$strProdQty = $LNG_TRANS_CHAR["PW00041"]; // 품절	
						}

						if ($strProdStockLimit == "Y"){
							$strProdQty = $LNG_TRANS_CHAR["PW00043"]; //무제한
						}
						
						## 재고 수정 유무
						$strProdQtyReadOnly		= "";
						if($strProdStockLimit == "Y" || $strProdStockOut == "Y"):
							$strProdQtyReadOnly = " disabled";
						endif;

			?>
			<tr>
				<td><input type="checkbox" id="chkNo" name="chkNo[]" value="<?=$strProdCode?>"></td>
				<td><?=$intListNum?></td>
				<td><a href="javascript:goOpenWindow('<?=$strProdCode?>')"><img src="<?=$strProdImageName?>" class="prodPhoto"></a></td>
				<td class="prodListInfo">					
					<ul>
						<li class="title"><?=$strProdName?></li>
						<li><span><?=$LNG_TRANS_CHAR["PW00021"] //카테고리?>:</span><?=getCateName($strProdCate,$strStLng)?></li>
						<li><span><?=$LNG_TRANS_CHAR["PW00176"] //상품번호?>:</span><?=$strProdCode?></li>
						<li><span><?=$LNG_TRANS_CHAR["PW00003"] //상품코드?>:</span><?=$strProdNum?></li>
						<?if($bolDiscountShow):?>
						<li><span>할인상품:</span><?=$strEventTitle?></li>
						<?endif;?>
					</ul>
					<div class="clear"></div>
				</td>
				<td><?=$intProdOrder?></td>
				<td>
					
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
				<?
				if (is_array($aryProdMainDisplayList)){
					for($i=0;$i<sizeof($aryProdMainDisplayList);$i++){
						if ($aryProdMainDisplayList[$i][IC_USE] == "Y"){
							$strIconName = "prodIcon".($i+1)."_".$row[P_CODE];
					?>
					<td>
						<input type="checkbox" id="<?=$strIconName?>" name="<?=$strIconName?>" value="Y" <?=($row["ICON".($i+1)] == "Y") ? "checked":""; ?>>
					</td>
				<?}}}?>
				<?
				if (is_array($aryProdSubDisplayList)){
					for($i=0;$i<sizeof($aryProdSubDisplayList);$i++){
						if ($aryProdSubDisplayList[$i][IC_USE] == "Y"){
							$strIconName = "prodIcon".($i+6)."_".$row[P_CODE];
					?>
					<td>
						<input type="checkbox" id="<?=$strIconName?>" name="<?=$strIconName?>" value="Y" <?=($row["ICON".($i+6)] == "Y") ? "checked":""; ?>>
					</td>
				<?}}}?>
			</tr>
			<?
					$intListNum--;
				}
			}
			?>
		</table>
	</div>
	<div class="paginate">
		<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?>
	</div>
	<div>
		<a class="btn_big" href="javascript:goAutoRecUpdate();" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["PW00192"]//상품진열정보변경?></strong></a>
		<a class="btn_big" href="javascript:goRecUpdate();" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["MM00131"]//일괄수정?></strong></a>
	</div>


</div>
<!-- ******** 컨텐츠 ********* -->