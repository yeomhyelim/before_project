<?
	## 기본 설정
	$aryPageLineList		= array(10, 20, 30, 40, 50, 60, 70, 80, 90, 100, 200);
	$bolProdShopShow		= false;

	## 쇼핑몰 타입이 입점몰일때 입점사명 표시
	if($S_MALL_TYPE == "M") { $bolProdShopShow = true; }

?>
<script type="text/javascript">
<!--

	$(document).ready(function(){
		$("select[name=pageLine]").change(function() {
			var data							= new Array(30);
			data['pageLine']					= $(this).val();
			data['page']						= 1;
			C_getAddLocationUrl(data);	
		});
	});

//-->
</script>
<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["MM00051"] //상품출력관리?></h2>
		<div class="clr"></div>
	</div>

	<!-- 언어탭 -->
	
	<!-- 검색 -->
	<div class="searchTableWrap">
		<?include "{$S_DOCUMENT_ROOT}www/web/shopAdmin/product/product/search.skin.v2.0.inc.php";?>
	</div>

	<!-- 목록수 -->
	<div class="tableList mt20">
		<div class="tableListTopWrap">
			<span class="listCntNum">* <?=callLangTrans($LNG_TRANS_CHAR["PS00028"],array($intTotal))?><!--총 <strong><?=$intListNum?>개</strong>의 상품이 있습니다.//--></span>
			<div class="selectedSort">
				<span class="spanTitle mt5"><?=$LNG_TRANS_CHAR["PW00117"] //목록수?>:</span>
				<select name="pageLine" style="vertical-align:middle;" onchange="javascript:goSearch();">
					<?foreach($aryPageLineList as $intData):?>
					<option value="<?=$intData?>"<?if($intPageLine==$intData){echo " selected";}?>><?=$intData?></option>
					<?endforeach;?>
				</select>
			</div>
		<div class="clr"></div>
	</div>
	<div>
		<a class="btn_big" href="javascript:goAutoViewUpdate();" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["PW00191"]//상품출력변경?></strong></a>
		<a class="btn_big" href="javascript:goProdOrderUpdate();" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["OW00161"]//상품우선순위수정?></strong></a>

	</div>

	<!-- 상품 리스트 -->
	<div>
		<table>
			<colgroup>
				<col style="width:60px;"/>
				<col style="width:60px;"/>
				<col style="width:60px;"/>
				<col/>
				<?if($bolProdShopShow):?>
				<col style="width:150px;"/>
				<?endif;?>
				<col style="width:200px;"/>
				<col style="width:120px;"/>
				<col style="width:100px;"/>
				<col style="width:150px;"/>
				<col style="width:120px;"/>
				<col style="width:130px;"/>


			</colgroup>
			<tr>
				<th><input type="checkbox" name="chkAll" value="Y" onclick="javascript:C_getCheckAll(this.checked)"/></th>
				<th><?=$LNG_TRANS_CHAR["CW00009"] //번호?></th>
				<th colspan="2"><?=$LNG_TRANS_CHAR["PW00002"] //상품명?>
					<a href="javascript:goOrderEvent('ND');" class="btn_up"><span>▲</span></a>
					<a href="javascript:goOrderEvent('NA');" class="btn_down"><span>▼</span></a></th>
				<?if($bolProdShopShow):?>
				<th>입점사명
					<a href="javascript:goOrderEvent('SD');" class="btn_up"><span>▲</span></a>
					<a href="javascript:goOrderEvent('SA');" class="btn_down"><span>▼</span></a></th>
				<?endif;?>
				<th><?=$LNG_TRANS_CHAR["BW00054"] //판매가?>
					<a href="javascript:goOrderEvent('RD');" class="btn_up"><span>▲</span></a>
					<a href="javascript:goOrderEvent('RA');" class="btn_down"><span>▼</span></a></th>
				<th><?=$LNG_TRANS_CHAR["OW00099"] //수수료?>
					<a href="javascript:goOrderEvent('PCRD');" class="btn_up"><span>▲</span></a>
					<a href="javascript:goOrderEvent('PCRA');" class="btn_down"><span>▼</span></a></th>

				<th><?=$LNG_TRANS_CHAR["PW00017"] //재고?>
					<a href="javascript:goOrderEvent('PQD');" class="btn_up"><span>▲</span></a>
					<a href="javascript:goOrderEvent('PQA');" class="btn_down"><span>▼</span></a></th>
				<th><?=$LNG_TRANS_CHAR["PW00010"] //상품출력?></th>
				<th><?=$LNG_TRANS_CHAR["PW00026"] //상품우선순위?>
					<a href="javascript:goOrderEvent('PSD');" class="btn_up"><span>▲</span></a>
					<a href="javascript:goOrderEvent('PSA');" class="btn_down"><span>▼</span></a></th>
				<th><?=$LNG_TRANS_CHAR["CW00026"] //등록일?>
					<a href="javascript:goOrderEvent('TD');" class="btn_up"><span>▲</span></a>
					<a href="javascript:goOrderEvent('TA');" class="btn_down"><span>▼</span></a></th>
			</tr>
			<?if ($intTotal == 0){?>
			<tr>
				<td colspan="14"><?=$LNG_TRANS_CHAR["CS00001"]?></td>
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
						$aryProdShareList	= $objProductListModule->getProductShareListSelectEx("OP_ARYTOTAL",$param);			
						
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

						## 수수료
//						$intAccPrice	= $intAccRate = 0;
//						$intAccRate		= getRoundUp((($row['P_SALE_PRICE'] - $row['P_STOCK_PRICE'])/$row['P_SALE_PRICE']) * 100,0);
//						$intAccPrice	= getCurToPrice($row['P_SALE_PRICE'] - $row['P_STOCK_PRICE'],$S_ST_LNG);
			?>
			<tr id="trProdInfo_<?=$strProdCode?>">
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
					<div class="clr"></div>
				</td>
				<?if($bolProdShopShow):?>
				<td><?=$strProdShopName?></td>
				<?endif;?>
				<td class="txtRight">
					<ul class="prod_price_info">
						<li><?=$LNG_TRANS_CHAR["PW00036"] //소비자가?> : <span><?=$strMoneyIconLeft?> <?=$intProdConsumerPrice?><?=$strMoneyIconRight?></span></li>
						<li><?=$LNG_TRANS_CHAR["PW00115"] //판매가?>   : <span><?=$strMoneyIconLeft?> <?=$intProdSalePrice?><?=$strMoneyIconRight?></span></li>
						<li><?=$LNG_TRANS_CHAR["PW00037"] //입고가?>   : <span><?=$strMoneyIconLeft?> <?=$intProdStockPrice?><?=$strMoneyIconRight?></span></li>
					</ul>
				</td>
				<td>
					<span><?=$strMoneyIconLeft?> <strong><?=getCurToPrice($intProdCommisionPrice,$S_ST_LNG)?></strong> <?=$strMoneyIconRight?><?=($intProdCommisionRate > 0) ? "(<strong>".$intProdCommisionRate."</strong>%)":"";?>
				</td>
				
				<td><?=$strProdQty?></td>
				
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
							echo "<li class='nation_{$lngVal}'>{$strUseLngText}<input type='checkbox' name='prodWebView{$lngVal}_{$strProdCode}' value='Y' {$strWebUseChecked}>{$strUseLngViewText}</li>";
						}
					?>
					</ul>
				</td>
				<td><input type="text" id="prodOrder" value="<?=$intProdOrder?>" style="width:80px;text-align:right" ></td>
				<td><?=$strProdRepDt?></td>
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
	<div style="text-align:left;margin-top:3px;">
		<a class="btn_big" href="javascript:goAutoViewUpdate();" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["PW00191"]//상품출력변경?></strong></a>
		<a class="btn_big" href="javascript:goProdOrderUpdate();" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["OW00161"]//상품우선순위수정?></strong></a>
	</div>
</div>

<!-- ******** 컨텐츠 ********* -->