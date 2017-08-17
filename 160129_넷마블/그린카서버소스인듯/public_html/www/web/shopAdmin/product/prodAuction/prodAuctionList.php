<?
	## 기본 설정
	$aryPageLineList		= array(10, 20, 30, 40, 50, 60, 70, 80, 90, 100, 200);
	$bolProdShopShow		= false;
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
		<h2><?=$LNG_TRANS_CHAR["PW00207"] //경매관리?></h2>
		<div class="clr"></div>
	</div>

	<!-- 검색 -->
	<div class="searchTableWrap">
		<?include "search.skin.inc.php";?>
	</div>

	<!-- 엑셀 다운로드 -->
	<!--<a href="javascript:goProdListExcelMoveEvent()" class="btn_sml"><strong><?=$LNG_TRANS_CHAR["PW00168"] //엑셀 다운로드?></strong></a>//-->

	<!-- 목록수 -->
	<div class="tableList">
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

	<!-- 상품 리스트 -->
	<div>
		<table>
			<colgroup>
				<col style="width:40px;"/>
				<col style="width:60px;"/>
				<col style="width:50px;"/>
				<col/>
				<col style="width:200px;"/>
				<col style="width:180px;"/>
				<col style="width:100px;"/>
				<col style="width:80px;"/>
				<col style="width:80px;"/>
				<col style="width:80px;"/>
			</colgroup>
			<tr>
				<th><input type="checkbox" name="chkAll" value="Y" onclick="javascript:C_getCheckAll(this.checked)"/></th>
				<th><?=$LNG_TRANS_CHAR["CW00009"] //번호?></th>
				<th colspan="2"><?=$LNG_TRANS_CHAR["PW00002"] //상품명?>
					<a href="javascript:goOrderEvent('productNameDesc');" class="btn_up"><span>▲</span></a>
					<a href="javascript:goOrderEvent('productNameAsc');" class="btn_down"><span>▼</span></a></th>
				
				<th><?=$LNG_TRANS_CHAR["PW00208"] //경매기간?>
				<th><?=$LNG_TRANS_CHAR["PW00221"] //경매금액?>
				<th><?=$LNG_TRANS_CHAR["PW00219"] //낙찰정보?>
				<th><?=$LNG_TRANS_CHAR["PW00211"] //경매상태?>
				<th><?=$LNG_TRANS_CHAR["PW00010"] //상품출력?>
					<a href="javascript:goOrderEvent('productWebShowDesc');" class="btn_up"><span>▲</span></a>
					<a href="javascript:goOrderEvent('productWebShowAsc');" class="btn_down"><span>▼</span></a></th>
				<th><?=$LNG_TRANS_CHAR["CW00007"] //관리?></th>
			</tr>
			<?if ($intTotal == 0){?>
			<tr>
				<td colspan="10"><?=$LNG_TRANS_CHAR["CS00001"]?></td>
			</tr>
			<?	
				/* PHP CODE */
				}else{		
					while($row = mysql_fetch_array($result))		{	
						
						## 기본 설정
						$strProdCode		= $row['P_CODE'];
						$strProdName		= $row['P_NAME'];
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
						## 입범몰이 없는 경우
						if(!$strShopName) { $strShopName= "본사"; }

						## 상품 이미지가 없는 경우
						if(!$strProdImageName) { $strProdImageName = "/upload/images/prodListNoImage.png"; }

						$row[P_NUM] = (!$row[P_NUM]) ? $LNG_TRANS_CHAR["PW00019"] : $row[P_NUM];
						
						## 상품출력 설정
						$strWebViewIcon		= "/shopAdmin/himg/common/ico_w_view_N.gif";
						$strMobViewIcon		= "/shopAdmin/himg/common/ico_m_view_N.gif";
						if($strP_WEB_VIEW == "Y") { $strWebViewIcon = "/shopAdmin/himg/common/ico_w_view_Y.gif"; }
						if($strP_MOB_VIEW == "Y") { $strMobViewIcon = "/shopAdmin/himg/common/ico_m_view_Y.gif"; }

						## 경매상태
						$strProdAucStatus	= "";
						switch($row['P_AUC_STATUS']){
							case "1":
								$strProdAucStatus = "경매시작전";
							break;
							case "2":
								$strProdAucStatus = "경매중";
							break;
							case "3":
								$strProdAucStatus = "경매중지";
							break;
							case "4":
								$strProdAucStatus = "경매완료";
							break;
							case "5":
								$strProdAucStatus = "경매종료";
							break;
						}

						$strProdAucApplyMemberName	= "";
						if ($row['M_F_NAME']) $strProdAucApplyMemberName  = $row['M_F_NAME']." ";
						if ($row['M_L_NAME']) $strProdAucApplyMemberName .= $row['M_L_NAME'];


				/* PHP CODE */
			?>
			<tr>
				<td><input type="checkbox" id="chkNo" name="chkNo[]" value="<?=$strProdCode?>"></td>
				<td><?=$intListNum?></td>
				<td><a href="javascript:goOpenWindow('<?=$strProdCode?>')"><img src="<?=$strProdImageName?>" class="prodPhoto"></a></td>
				<td class="prodListInfo">					
					<ul>
						<li class="title"><?=$strProdName?></li>
						<li><span><?=$LNG_TRANS_CHAR["PW00021"] //카테고리?>:</span><?=getCateName($row[P_CATE],$strStLng)?></li>
						<li><span><?=$LNG_TRANS_CHAR["PW00176"] //상품번호?>:</span><?=$row[P_CODE]?></li>
						<li><span><?=$LNG_TRANS_CHAR["PW00003"] //상품코드?>:</span><?=$row[P_NUM]?></li>
					</ul>
					<div class="clr"></div>
				</td>
				<td>
					<ul>
						<li><span><?=$LNG_TRANS_CHAR["CW00073"] //시작일?>:<?=$row['P_AUC_ST_DT']?></li>
						<li><span><?=$LNG_TRANS_CHAR["CW00074"] //종료일?>:<?=$row['P_AUC_END_DT']?></li>
						<?if ($row['P_AUC_SUC_DT']){?>
						<li><span><?=$LNG_TRANS_CHAR["PW00217"] //낙찰일?>:<?=$row['P_AUC_SUC_DT']?></li>
						<?}?>
					</ul>
				</td>
				<td class="txtRight">
					<ul>
						<li>
							<?=$LNG_TRANS_CHAR["PW00209"] //시작가?>:
							<span><?=$strMoneyIconLeft?><?=getCurToPrice($row['P_AUC_ST_PRICE'],$S_ST_LNG)?><?=$strMoneyIconRight?></span>
						</li>
						<li>
							<?=$LNG_TRANS_CHAR["PW00210"] //즉구가?>:
							<span><?=$strMoneyIconLeft?><?=getCurToPrice($row['P_AUC_RIGHT_PRICE'],$S_ST_LNG)?><?=$strMoneyIconRight?></span>
						</li>
						<?if ($row['P_AUC_BEST_PRICE']){?>
						<li>
							<?=$LNG_TRANS_CHAR["PW00218"] //현재가?>:
							<span><?=$strMoneyIconLeft?><?=getCurToPrice($row['P_AUC_BEST_PRICE'],$S_ST_LNG)?><?=$strMoneyIconRight?></span>
						</li>
						<?}?>
					</ul>
				</td>
				<td>
					<ul>
						<li><?=$row['M_MAIL']?></li>
						<li><?=$strProdAucApplyMemberName?></li>
					</ul>
				</td>
				<td>
					<?=$strProdAucStatus?>
				</td>
				<td>
					<p><img src="<?php echo $strWebViewIcon;?>"></p><br>
					<p><img src="<?php echo $strMobViewIcon;?>"></p>
				</td>
				<td>
					<a class="btn_blue_sml" href="javascript:goProdAuctionApplyList('<?=$strProdCode?>');" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["PW00220"] // 경매내역?></strong></a>
					<a class="btn_sml" href="javascript:goProdModify('<?=$strProdCode?>','<?=$strStLng?>');" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00003"] // 수정?></strong></a>					
					</strong></a>
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
	<div style="text-align:left;margin-top:3px;">
	</div>
</div>

<!-- ******** 컨텐츠 ********* -->