<div id="contentArea">
	<div class="contentTop">
		<h2>상점 상품목록</h2>
		<div class="clr"></div>
	</div>
	<div class="tabImgWrap mt10">
		<a href="javascript:javascript:goMoveUrl('shopModify','<?=$intSH_NO?>');">기본정보</a>	
		<a href="javascript:javascript:goMoveUrl('shopSite','<?=$intSH_NO?>');"  >상점정보</a>	
		<a href="javascript:javascript:goMoveUrl('shopSetting','<?=$intSH_NO?>');">설정정보</a>
		<a href="javascript:javascript:goMoveUrl('shopUser','<?=$intSH_NO?>');">사용자정보</a>
		<a href="javascript:javascript:goMoveUrl('shopProdList','<?=$intSH_NO?>');"  class="selected">상품정보</a>
		<a href="javascript:javascript:goMoveUrl('shopOrderList','<?=$intSH_NO?>');">주문정보</a>	
	</div>
	<!-- 언어 선택 탭 -->
	<?include "./include/tab_language.inc.php";?>
	<!-- 언어 선택 탭-->

	<!-- ******** 컨텐츠 ********* -->
	<div class="searchTableWrap">
		<div class="searchFormWrap">
			<select name="searchField" id="searchField">
				<option value="N" <?=($strSearchField=="N")?"selected":"";?>><?=$LNG_TRANS_CHAR["PW00002"] //상품명?></option>
				<option value="C" <?=($strSearchField=="C")?"selected":"";?>><?=$LNG_TRANS_CHAR["PW00003"] //상품코드?></option>
				<option value="M" <?=($strSearchField=="M")?"selected":"";?>><?=$LNG_TRANS_CHAR["PW00004"] //제조사?></option>
				<option value="O" <?=($strSearchField=="O")?"selected":"";?>><?=$LNG_TRANS_CHAR["PW00005"] //원산지?></option>
				<option value="D" <?=($strSearchField=="D")?"selected":"";?>><?=$LNG_TRANS_CHAR["PW00006"] //모델명?></option>
			</select>
			<input type="text" id="searchKey" name="searchKey" <?=$nBox?> value="<?=$strSearchKey?>"/>
			<a class="btn_blue_big" href="javascript:goSearch('prodList');"><strong><?=$LNG_TRANS_CHAR["CW00027"] //검색?></strong></a>
		</div><!-- searchFormWrap -->

		<table>
			<tr>
				<th><?=$LNG_TRANS_CHAR["CW00027"] //카테고리선택?></th>
				<td>
					<select id="searchCateHCode1" name="searchCateHCode1">
						<option value=""><?=$LNG_TRANS_CHAR["PW00013"] //1차 카테고리 선택?></option>
					</select>
					<select id="searchCateHCode2" name="searchCateHCode2" >
						<option value=""><?=$LNG_TRANS_CHAR["PW00014"] //2차 카테고리 선택?></option>
					</select>
					<select id="searchCateHCode3" name="searchCateHCode3" >
						<option value=""><?=$LNG_TRANS_CHAR["PW00015"] //3차 카테고리 선택?></option>
					</select>
					<select id="searchCateHCode4" name="searchCateHCode4">
						<option value=""><?=$LNG_TRANS_CHAR["PW00016"] //4차 카테고리 선택?></option>
					</select>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00008"] //상품출시일?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:100px;" id="searchLaunchStartDt" name="searchLaunchStartDt" maxlength="10"/>
					~
					<input type="text" <?=$nBox?>  style="width:100px;" id="searchLaunchEndDt" name="searchLaunchEndDt" maxlength="10"/>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00009"] //상품등록일?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:100px;" id="searchRepStartDt" name="searchRepStartDt" maxlength="10"/>
					~
					<input type="text" <?=$nBox?>  style="width:100px;" id="searchRepEndDt" name="searchRepEndDt" maxlength="10"/>
					<span class="searchWrapImg">
						<a class="btn_sml" href="javascript:C_getSearchDay('T','<?=$strMode?>','','searchRepStartDt','searchRepEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00017"]?></strong></a>
						<a class="btn_sml" href="javascript:C_getSearchDay('1','<?=$strMode?>','','searchRepStartDt','searchRepEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00018"]?></strong></a>
						<a class="btn_sml" href="javascript:C_getSearchDay('2','<?=$strMode?>','','searchRepStartDt','searchRepEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00019"]?></strong></a>
						<a class="btn_sml" href="javascript:C_getSearchDay('1M','<?=$strMode?>','','searchRepStartDt','searchRepEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00020"]?></strong></a>
						<a class="btn_sml" href="javascript:C_getSearchDay('2M','<?=$strMode?>','','searchRepStartDt','searchRepEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00021"]?></strong></a>
						<a class="btn_sml" href="./?menuType=product&mode=prodList"><strong><?=$LNG_TRANS_CHAR["CW00022"]?></strong></a>
					</span>
				</td>
			</tr>
			<?if (is_array($aryProdBrandList)){?>
			<tr>
				<th>브랜드</th>
				<td>
					<?=drawSelectBoxMoreQuery("searchProdBrand",$aryProdBrandList,$selected=$strSearchProdBrand,"","","",$LNG_TRANS_CHAR["PW00025"],"N","PR_NO","PR_NAME")?>
				</td>
			</tr>
			<?}?>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00010"] //상품출력?></th>
				<td>
					<input type="checkbox" id="searchWebView" name="searchWebView" value="Y"><?=$LNG_TRANS_CHAR["PW00011"] //웹?>
					<input type="checkbox" id="searchMobileView" name="searchMobileView" value="Y"><?=$LNG_TRANS_CHAR["PW00012"] //모바일?>
				</td>
			</tr>
			<?if (is_array($$aryProdMainDisplayList)){?>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00027"] //메인 진열정보?></th>
				<td>
					<?for($i=0;$i<sizeof($aryProdMainDisplayList);$i++){
						if ($aryProdMainDisplayList[$i][IC_USE] == "Y"){
							$strSearchIconName = "searchIcon".($i+1);
							$strSearchIconChecked = (${"strSearchIcon".($i+1)} == "Y") ? "checked":""; 
						?>
						<input type="checkbox" id="<?=$strSearchIconName?>" name="<?=$strSearchIconName?>" value="Y" <?=$strSearchIconChecked?>><?=$aryProdMainDisplayList[$i][IC_NAME]?>
					<?}}?>
				</td>
			</tr>
			<?}?>
			<?if (is_array($$aryProdSubDisplayList)){?>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00028"] //서브 진열정보?></th>
				<td>
					<?for($i=0;$i<sizeof($aryProdSubDisplayList);$i++){
						if ($aryProdSubDisplayList[$i][IC_USE] == "Y"){
							$strSearchIconName = "searchIcon".($i+6);
							$strSearchIconChecked = (${"strSearchIcon".($i+6)} == "Y") ? "checked":""; 
						?>
						<input type="checkbox" id="<?=$strSearchIconName?>" name="<?=$strSearchIconName?>" value="Y" <?=$strSearchIconChecked?>><?=$aryProdSubDisplayList[$i][IC_NAME]?>
					<?}}?>
				</td>
			</tr>
			<?}?>
		</table>
	</div>
	<div class="tableList">
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

	<div class="tableList">
		<table>
			<colgroup>
				<col style="width:60px;"/>
				<col/>
				<col/>
				<col style="width:60px;"/>
				<col style="width:150px;"/>
				<col style="width:80px;"/>
				<col style="width:50px;"/>				
				<col style="width:150px;"/>
				<col style="width:150px;"/>
			</colgroup>
			<tr>
				<th><?=$LNG_TRANS_CHAR["CW00009"] //번호?></th>
				<th colspan="2"><?=$LNG_TRANS_CHAR["PW00002"] //상품명?></th>
				<th><?=$LNG_TRANS_CHAR["PW00010"] //상품출력?></th>
				<th><?=$LNG_TRANS_CHAR["BW00054"] //판매가?></th>
				<th><?=$LNG_TRANS_CHAR["CW00034"] //포인트?></th>
				<th><?=$LNG_TRANS_CHAR["PW00017"] //재고?></th>
				<th><?=$LNG_TRANS_CHAR["CW00026"] //등록일?></th>
			</tr>
			<?if ($intTotal == 0){?>
			<tr>
				<td colspan="8"><?=$LNG_TRANS_CHAR["CS00001"]?></td>
			</tr>
			<?	
				/* PHP CODE */
				}else{				
					while($row = mysql_fetch_array($result))		{	
						$row[P_NUM] = (!$row[P_NUM]) ? $LNG_TRANS_CHAR["PW00019"] : $row[P_NUM];
						$strProdView = 	($row[P_WEB_VIEW] == "Y" || $row[P_MOBILE_VIEW] == "Y") ? "Yes":"No"; 

						/* 상품공유카테고리리스트 */
						$productMgr->setP_CODE($row[P_CODE]);
						$aryProdShareList  = $productMgr->getProdShareList($db);

						// 입점몰명이 없는 경우.
						if(!$row['ST_NAME']) { $row['ST_NAME'] = "본사"; }

						// 수량
						$strProdQty = number_format($row[P_QTY]);
						if ($row['P_QTY'] == 0){
							if ($row['P_STOCK_OUT'] == "Y"){
								$strProdQty = $LNG_TRANS_CHAR["PW00041"];	
							}

							if ($row['P_STOCK_LIMIT'] == "Y"){
								$strProdQty = $LNG_TRANS_CHAR["PW00020"];	
							}
						} 

				/* PHP CODE */
			?>
			<tr>
				<td><?=$intListNum?></td>
				<td style="width:50px;"><a href="javascript:goOpenWindow('<?=$row[P_CODE]?>')"><img src="..<?=$row[PM_REAL_NAME]?>" class="prodPhoto"></a></td>
				<td class="prodListInfo">					
					<ul>
						<li class="title"><?=$row[P_NAME]?></li>
						<li><span><?=$LNG_TRANS_CHAR["PW00021"] //카테고리?>:</span><?=getCateName($row[P_CATE],$strStLng)?></li>
						<li><span><?=$LNG_TRANS_CHAR["PW00003"] //상품코드?>:</span><?=$row[P_NUM]?></li>
						<li>
							<span>상품공유:</span><a class="btn_sml" href="javascript:goProdShare('<?=$row[P_CODE]?>');"><strong>설정</strong></a><br>
							<div id="divProdShareHtml_<?=$row[P_CODE]?>">
							<?
							if (is_array($aryProdShareList)){
								for($j=0;$j<sizeof($aryProdShareList);$j++){
									echo "<span></span>/".getCateName($aryProdShareList[$j][PS_P_CATE],$strStLng);
									
									if ($j != sizeof($aryProdShareList) - 1) echo "<BR>";
								}
							}
							?>
							</div>
						</li>
						<?
							if ($row[P_EVENT] > 0 && getProdEventInfo($row,"Y") == "Y"){
						?>
						<li>
							<span>할인상품:</span><?=$aryShopEventInfo[$row[P_EVENT]]["TITLE"]?>
						</li>
							<?							
							}	
						?>
					
					</ul>
					<div class="clr"></div>
				</td>
				<td><?=$strProdView?></td>
				<td><?=$S_ARY_MONEY_ICON[$strProdLng]["L"]?> <input type="input" name="sale_price_<?=$row[P_CODE]?>" id="sale_price_<?=$row[P_CODE]?>" value="<?=getCurToPrice($row[P_SALE_PRICE],$strProdLng)?>" <?=$priceBox?>/> <?=$S_ARY_MONEY_ICON[$strProdLng]["R"]?></td>
				<td><input type="input" name="point_<?=$row[P_CODE]?>" id="point_<?=$row[P_CODE]?>" value="<?=getCurToPrice($row[P_POINT],$strProdLng)?>" <?=$priceBox?> style="width:50px;"/> P</td>
				<td><input type="input" name="stock_<?=$row[P_CODE]?>" id="stock_<?=$row[P_CODE]?>" value="<?=$strProdQty?>" <?=$nBox?> style="width:40px;text-align:right;"/> </td>
				<td><?=$row[P_REP_DT]?></td>
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