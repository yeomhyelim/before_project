<?
	## 기본 설정
	$bolProdShopShow		= false;

	## 쇼핑몰 타입이 입점몰일때 입점사명 표시
	if($S_MALL_TYPE == "M") { $bolProdShopShow = true; }
?>
<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["MM00051"]//상품출력관리?></h2>
		<div class="clr"></div>
	</div>

	<!-- ******** 컨텐츠 ********* -->
	<div class="searchTableWrap">
	<?include "search.skin.inc.php";?>
	</div>
	
	<div class="tableList mt20">
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
		<table>
			<colgroup>
				<col style="width:60px;"/>
				<col style="width:60px;"/>
				<col style="width:60px;"/>
				<col/>
				<?if($bolProdShopShow):?>
				<col style="width:150px;"/>
				<?endif;?>
				<col style="width:180px;"/>
				<col style="width:120px;"/>
				<col style="width:100px;"/>
				<col style="width:120px;"/>
				<col style="width:120px;"/>
				<col style="width:150px;"/>
			</colgroup>
			<tr>
				<th><input type="checkbox" name="chkAll" value="Y" onclick="javascript:C_getCheckAll(this.checked)"/></th>
				<th><?=$LNG_TRANS_CHAR["CW00009"] //번호?></th>
				<th colspan="2"><?=$LNG_TRANS_CHAR["PW00002"] //상품명?>
					<a href="javascript:goOrderEvent('productNameDesc');" class="btn_up"><span>▲</span></a>
					<a href="javascript:goOrderEvent('productNameAsc');" class="btn_down"><span>▼</span></a></th>
				<?if($bolProdShopShow):?>
				<th>입점사명
					<a href="javascript:goOrderEvent('productShopNoDesc');" class="btn_up"><span>▲</span></a>
					<a href="javascript:goOrderEvent('productShopNoAsc');" class="btn_down"><span>▼</span></a></th>
				<?endif;?>
				<th><?=$LNG_TRANS_CHAR["BW00054"] //판매가?>
					<a href="javascript:goOrderEvent('productSalePriceDesc');" class="btn_up"><span>▲</span></a>
					<a href="javascript:goOrderEvent('productSalePriceAsc');" class="btn_down"><span>▼</span></a></th>
				<th><?=$LNG_TRANS_CHAR["OW00099"] //수수료?>
					<a href="javascript:goOrderEvent('productCommisionRateDesc');" class="btn_up"><span>▲</span></a>
					<a href="javascript:goOrderEvent('productCommisionRateAsc');" class="btn_down"><span>▼</span></a></th>

				<th><?=$LNG_TRANS_CHAR["PW00017"] //재고?>
					<a href="javascript:goOrderEvent('productQtyDesc');" class="btn_up"><span>▲</span></a>
					<a href="javascript:goOrderEvent('productQtyAsc');" class="btn_down"><span>▼</span></a></th>
				<th><?=$LNG_TRANS_CHAR["PW00026"] //상품우선순위?>
					<a href="javascript:goOrderEvent('productOrderDesc');" class="btn_up"><span>▲</span></a>
					<a href="javascript:goOrderEvent('productOrderAsc');" class="btn_down"><span>▼</span></a></th>
				<th><?=$LNG_TRANS_CHAR["PW00122"] //상품출력(웹)?>
					<a href="javascript:goOrderEvent('productWebShowDesc');" class="btn_up"><span>▲</span></a>
					<a href="javascript:goOrderEvent('productWebShowAsc');" class="btn_down"><span>▼</span></a></th>
				<th><?=$LNG_TRANS_CHAR["CW00026"] //등록일?>
					<a href="javascript:goOrderEvent('productRegDateDesc');" class="btn_up"><span>▲</span></a>
					<a href="javascript:goOrderEvent('productRegDateAsc');" class="btn_down"><span>▼</span></a></th>
			</tr>
			<?if ($intTotal == 0){?>
			<tr>
				<td colspan="6"><?=$LNG_TRANS_CHAR["CS00001"]?></td>
			</tr>
			<?	
				/* PHP CODE */
				}else{				
					while($row = mysql_fetch_array($result))		{	
						$row[P_NUM]  = (!$row[P_NUM]) ? $LNG_TRANS_CHAR["PW00019"] : $row[P_NUM];
						$strProdView = 	($row[P_WEB_VIEW] == "Y" || $row[P_MOBILE_VIEW] == "Y") ? "Yes":"No"; 
						
						## 기본 설정
						$strPCode			= $row['P_CODE'];
						$strPName			= $row['P_NAME'];
						$strMoneyIconLeft	= $S_ARY_MONEY_ICON[$S_ST_LNG]["L"];
						$strMoneyIconRight	= $S_ARY_MONEY_ICON[$S_ST_LNG]["R"];
						$strShopName		= $row['ST_NAME'];
						$strProdImageName	= $row['PM_REAL_NAME'];
						$intSalePrice		= getCurToPrice($row['P_SALE_PRICE'], $S_ST_LNG);
						$intStockPrice		= getCurToPrice($row['P_STOCK_PRICE'],$S_ST_LNG);
						$intConsumerPrice	= getCurToPrice($row['P_CONSUMER_PRICE'],$S_ST_LNG);
						$intPoint			= getCurToPrice($row['P_POINT'],$S_ST_LNG);
						$bolDiscountShow	= true;
						$intEvent			= $row['P_EVENT'];
						$strEventInfo		= getProdEventInfo($row,"Y");
						$strEventTitle		= $aryShopEventInfo[$row['P_EVENT']]['TITLE'];
						$strCategory		= $row['P_CATE'];
						$strP_WEB_VIEW		= $row['P_WEB_VIEW'];
						$strP_MOB_VIEW		= $row['P_MOB_VIEW'];

						## 상품출력 설정
						$strWebViewIcon		= "/shopAdmin/himg/common/ico_w_view_N.gif";
						$strMobViewIcon		= "/shopAdmin/himg/common/ico_m_view_N.gif";
						if($strP_WEB_VIEW == "Y") { $strWebViewIcon = "/shopAdmin/himg/common/ico_w_view_Y.gif"; }
						if($strP_MOB_VIEW == "Y") { $strMobViewIcon = "/shopAdmin/himg/common/ico_m_view_Y.gif"; }

						## 입범몰이 없는 경우
						if(!$strShopName) { $strShopName= "본사"; }

						## 상품 이미지가 없는 경우
						if(!$strProdImageName) { $strProdImageName = "/upload/images/prodListNoImage.png"; }

						## 상품공유카테고리리스트
						$productMgr->setP_CODE($strPCode);
						$aryProdShareList	= $productMgr->getProdShareList($db);			
						
						## 할인상품 표시 여부
						if($strEventInfo != "Y")	{ $bolDiscountShow = false; }
						if($intEvent >= 0)			{ $bolDiscountShow = false; }

						$row[P_NUM] = (!$row[P_NUM]) ? $LNG_TRANS_CHAR["PW00019"] : $row[P_NUM];
						$strProdView = 	($row[P_WEB_VIEW] == "Y" || $row[P_MOBILE_VIEW] == "Y") ? "Yes":"No"; 

						// 수량
						$strProdQty = number_format($row[P_QTY]);
//						if ($row['P_QTY'] == 0){
							if ($row['P_STOCK_OUT'] == "Y"){
								$strProdQty = $LNG_TRANS_CHAR["PW00041"];	
							}

							if ($row['P_STOCK_LIMIT'] == "Y"){
								$strProdQty = $LNG_TRANS_CHAR["PW00020"];	
							}
//						}
						
						## 재고 수정 유무
						$strProdQtyReadOnly		= "";
						if($row['P_STOCK_LIMIT'] == "Y" || $row['P_STOCK_LIMIT'] == "Y"):
							$strProdQtyReadOnly = " disabled";
						endif;

						## 수수료
						$intAccPrice	= $intAccRate = 0;
						$intAccRate		= getRoundUp((($row['P_SALE_PRICE'] - $row['P_STOCK_PRICE'])/$row['P_SALE_PRICE']) * 100,0);
						$intAccPrice	= getCurToPrice($row['P_SALE_PRICE'] - $row['P_STOCK_PRICE'],$S_ST_LNG);

						## ceosb 사이트 전용 버튼 설정
						$isCeosb		= false;
						if($S_SHOP_NAME == "ceosb" && $strCategory == "002000000000") { $isCeosb = true; }

				/* PHP CODE */
			?>
			<tr id="trProdInfo_<?=$row['P_CODE']?>">
				<td><input type="checkbox" id="chkNo" name="chkNo[]" value="<?=$row[P_CODE]?>"></td>
				<td><?=$intListNum?></td>
				<td style="width:50px;"><a href="javascript:goOpenWindow('<?=$row[P_CODE]?>')"><img src="<?=$row[PM_REAL_NAME]?>" class="prodPhoto"></a></td>
				<td class="prodListInfo">					
					<ul>
						<li class="title"><?=$row[P_NAME]?></li>
						<li><span><?=$LNG_TRANS_CHAR["PW00021"] //카테고리?>:</span><?=getCateName($row[P_CATE],$strStLng)?></li>
						<li><span><?=$LNG_TRANS_CHAR["PW00176"] //상품번호?>:</span><?=$row[P_CODE]?></li>
						<li><span><?=$LNG_TRANS_CHAR["PW00003"] //상품코드?>:</span><?=$row[P_NUM]?></li>
					</ul>
					<div class="clr"></div>
				</td>
				<?if($bolProdShopShow):?>
				<td><?=$strShopName?></td>
				<?endif;?>
				<td class="txtRight">
					<ul class="prod_price_info">
						<li><?=$LNG_TRANS_CHAR["PW00115"] //판매가?>   : <span><?=$strMoneyIconLeft?> <?=$intSalePrice?> <?=$strMoneyIconRight?></span></li>
						<li><?=$LNG_TRANS_CHAR["PW00037"] //입고가?>   : <span><?=$strMoneyIconLeft?> <?=$intStockPrice?> <?=$strMoneyIconRight?></span></li>
						<li><?=$LNG_TRANS_CHAR["PW00036"] //소비자가?>: <span><?=$strMoneyIconLeft?> <?=$intConsumerPrice?> <?=$strMoneyIconRight?></span></li>
					</ul>
				</td>
				<td>
					<span><?=$strMoneyIconLeft?> <strong><?=getCurToPrice($row['P_COMMISION_PRICE'],$S_ST_LNG)?></strong> <?=$strMoneyIconRight?><?=($row['P_COMMISION_RATE'] > 0) ? "(<strong>".$row['P_COMMISION_RATE']."</strong>%)":"";?>
				</td>
				<td><?=$strProdQty?></td>
				<td><input type="text" id="prodOrder" value="<?=$row['P_ORDER']?>" style="width:80px;text-align:right" ></td>
				<td><p><img src="<?php echo $strWebViewIcon;?>"></p>
					<p><img src="<?php echo $strMobViewIcon;?>"></p></td>
				<td><?=$row['P_REP_DT']?></td>
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
					<select name="viewStatus" id="viewStatus">
						<option value="">:::<?=$LNG_TRANS_CHAR["PW00010"]?>:::</option>
						<?if($a_admin_type != "S"){?><option value="WY">웹 보임</option><?}?>
						<option value="WN">웹 숨김</option>
						<?if($a_admin_type != "S"){?><option value="MY">모바일 보임</option><?}?>
						<option value="MN">모바일 숨김</option>
					</select>
					
					<a class="btn_big" href="javascript:goViewStatusChoick();" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["OW00160"]//선택수정?></strong></a>
					<!--<a class="btn_big" href="javascript:goViewStatusAll();"><strong>일괄수정</strong></a>//-->
					<a class="btn_big" href="javascript:goProdOrderUpdate();" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["OW00161"]//상품우선순위수정?></strong></a>
				</td>
			</tr>
		</table>
	</div>
</div>