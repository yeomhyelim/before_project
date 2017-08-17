<?
	## 기본 설정
	$aryPageLineList		= array(10, 20, 30, 40, 50, 60, 70, 80, 90, 100, 200);
	$bolProdShopShow		= false;

	## 쇼핑몰 타입이 입점몰일때 입점사명 표시
	if($S_MALL_TYPE == "M") { $bolProdShopShow = true; }

	$intShNo = $_GET['shopNo'];

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

		// 판매가, 포인트 값 변경시 이벤트
		$('input[name^=consumer_price]').on('change', function(e) {
			var strName = $(this).attr('name');
			var strPCode = strName.replace("consumer_price_", "");
			goProdChangeData(strPCode);
		});
		$('input[name^=sale_price]').on('change', function(e) {
			var strName = $(this).attr('name');
			var strPCode = strName.replace("sale_price_", "");
			goProdChangeData(strPCode);
		});
		$('input[name^=stock_price]').on('change', function(e) {
			var strName = $(this).attr('name');
			var strPCode = strName.replace("stock_price_", "");
			goProdChangeData(strPCode);
		});
		$('input[name^=point]').on('change', function(e) {
			var strName = $(this).attr('name');
			var strPCode = strName.replace("point_", "");
			goProdChangeData(strPCode);
		});
		$('input[name^=qty_]').on('change', function(e) {
			var strName = $(this).attr('name');
			var strPCode = strName.replace("qty_", "");
			goProdChangeData(strPCode);
		});

		// 체크박스 선택 유무에 따라서 class 변경
		$('[name^=chkNo]').change(function() {
			var strCheck = $(this).attr('checked');
			var strPCode = $(this).val();

			if(strCheck) { 	$('tr[idx=' + strPCode + ']').addClass('selected');	 }
			else { $('tr[idx=' + strPCode + ']').removeClass('selected'); }
		});

	});

	// 판매가, 포인트 값 변경시 이벤트(공통)
	function goProdChangeData(strPCode) {
		// 체크박스 체크
		$('tr[idx=' + strPCode + ']').find('[name^=chkNo]').attr('checked', true);

		// class 추가
		$('tr[idx=' + strPCode + ']').addClass('selected');
	}

	// 상품출력 변경
	function goProdViewModifyActEvent(strPCode, strViewMode) {

		// 기본설정
		var strLang = $('[name=lang]').val();

		// 전달
		var data = new Object();
		data['menuType'] = 'product';
		data['mode'] = 'json';
		data['act'] = 'productViewModify';
		data['prodCode'] = strPCode;
		data['viewMode'] = strViewMode;
		data['lang'] = strLang;

		$.ajax({
			url			: "./"
		   ,data		: data
		   ,type		: "POST"
		   ,dataType	: "json"
		   ,success		: function(data) {

				if(data['__STATE__'] == "SUCCESS") {

					var objData = data['__DATA__'];
					var strWebView = objData['P_WEB_VIEW'];
					var strMobView = objData['P_MOB_VIEW'];
					var strWebImage = '/shopAdmin/himg/common/ico_w_view_' + strWebView + '.gif';
					var strMobImage = '/shopAdmin/himg/common/ico_m_view_' + strMobView + '.gif';
					$('tr[idx=' + strPCode + ']').find('.webView img').attr('src', strWebImage);
					$('tr[idx=' + strPCode + ']').find('.mobView img').attr('src', strMobImage);
				} else {
					var strMsg	= data['__MSG__'];
					if(!strMsg) { strMsg = data; }
					alert(strMsg);
				}

		    }
		});

	}

	// 입점사 변경
	function goProdShopChangeMoveEvent() {
		
		// 선택된 상품이 있는지 체크
		if($('[input[name^=chkNo]:checked').length <= 0) {
			alert('선택된 상품이 없습니다.');
			return;
		}

		// 레이어 팝업
		var strUrl = './?menuType=product&mode=popProdShopModify';
		$.smartPop.open({  bodyClose: false, width: 600, height: 300, url: strUrl, closeImg: {width:23, height:23} });

	}

//-->
</script>
<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["PW00001"] //상품관리?></h2>
		<div class="clr"></div>
	</div>

	<!-- 언어탭 -->
	<?include "./include/tab_language.inc.php";?>

	<!-- 검색 -->
	<div class="searchTableWrap">
		<?include "search.skin.inc.php";?>
	</div>

	<br>

	<!-- 엑셀 다운로드 -->


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

	<!-- 목록수 -->
	<div class="tableListWrap">
	<!-- 상품 리스트 -->
		<table class="tableList">
			<colgroup>
				<col style="width:40px;"/>
				<col style="width:60px;"/>
				<col style="width:50px;"/>
				<col/>
				<?if($bolProdShopShow):?>
					<col style="width:150px;"/>
				<?endif;?>
				<col style="width:80px;"/>
				<col style="width:200px;"/>
				<col style="width:80px;"/>
				<col style="width:80px;"/>
				<col style="width:70px;"/>
				<col style="width:150px;"/>
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
						<a href="javascript:goOrderEvent('productShopNoAsc');" class="btn_down"><span>▼</span></a>
					</th>
				<?endif;?>

					<th>
						<?=$LNG_TRANS_CHAR["PW00010"] //상품출력?>
						<a href="javascript:goOrderEvent('productWebShowDesc');" class="btn_up"><span>▲</span></a>
						<a href="javascript:goOrderEvent('productWebShowAsc');" class="btn_down"><span>▼</span></a>
					</th>
					<th>
						<?=$LNG_TRANS_CHAR["BW00054"] //판매가?>
						<a href="javascript:goOrderEvent('productSalePriceDesc');" class="btn_up"><span>▲</span></a>
						<a href="javascript:goOrderEvent('productSalePriceAsc');" class="btn_down"><span>▼</span></a>
					</th>
					<th><?=$LNG_TRANS_CHAR["OW00099"] //수수료?>
						<a href="javascript:goOrderEvent('productCommisionRateDesc');" class="btn_up"><span>▲</span></a>
						<a href="javascript:goOrderEvent('productCommisionRateAsc');" class="btn_down"><span>▼</span></a>
					</th>

					<th>
						<?=$LNG_TRANS_CHAR["CW00034"] //포인트?>
						<a href="javascript:goOrderEvent('productPointDesc');" class="btn_up"><span>▲</span></a>
						<a href="javascript:goOrderEvent('productPointAsc');" class="btn_down"><span>▼</span></a>
					</th>
					<th>
						<?=$LNG_TRANS_CHAR["PW00017"] //재고?>
						<a href="javascript:goOrderEvent('productQtyDesc');" class="btn_up"><span>▲</span></a>
						<a href="javascript:goOrderEvent('productQtyAsc');" class="btn_down"><span>▼</span></a>
					</th>
					<th>
						<?=$LNG_TRANS_CHAR["CW00026"] //등록일?>
						<a href="javascript:goOrderEvent('productRegDateDesc');" class="btn_up"><span>▲</span></a>
						<a href="javascript:goOrderEvent('productRegDateAsc');" class="btn_down"><span>▼</span></a>
					</th>
					<th><?=$LNG_TRANS_CHAR["CW00007"] //관리?></th>
			</tr>
			<?if ($intTotal == 0){?>
			<tr>
				<td colspan="12"><?=$LNG_TRANS_CHAR["CS00001"]?></td>
			</tr>
			<?
				/* PHP CODE */
				}else{
					while($row = mysql_fetch_array($result))		{

						## 기본 설정
						$strSh_Number		= $row['P_SHOP_NO'];
						$result2			= getShopNameInc($strSh_Number);
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
//						$strProdView = 	($row[P_WEB_VIEW] == "Y" || $row[P_MOBILE_VIEW] == "Y") ? "<img src=\"/shopAdmin/himg/common/ico_w_view_Y.gif\">":"<img src=\"/shopAdmin/himg/common/ico_w_view_N.gif\">";

						## 상품출력 설정
						$strWebViewIcon		= "/shopAdmin/himg/common/ico_w_view_N.gif";
						$strMobViewIcon		= "/shopAdmin/himg/common/ico_m_view_N.gif";
						if($strP_WEB_VIEW == "Y") { $strWebViewIcon = "/shopAdmin/himg/common/ico_w_view_Y.gif"; }
						if($strP_MOB_VIEW == "Y") { $strMobViewIcon = "/shopAdmin/himg/common/ico_m_view_Y.gif"; }

						// 수량
						$strProdQty = number_format($row[P_QTY]);
//						if ($row['P_QTY'] == 0){
							if ($row['P_STOCK_OUT'] == "Y"){
								$strProdQty = $LNG_TRANS_CHAR["PW00041"]; // 품절
							}

							if ($row['P_STOCK_LIMIT'] == "Y"){
								$strProdQty = $LNG_TRANS_CHAR["PW00043"]; //무제한
							}
//						}

						## 재고 수정 유무
						$strProdQtyReadOnly		= "";
						if($row['P_STOCK_LIMIT'] == "Y" || $row['P_STOCK_OUT'] == "Y"):
							$strProdQtyReadOnly = " disabled";
						endif;

						## 수수료
						//$intAccPrice	= $intAccRate = 0;
						//$intAccRate		= getRoundUp((($row['P_SALE_PRICE'] - $row['P_STOCK_PRICE'])/$row['P_SALE_PRICE']) * 100,0);
						//$intAccPrice	= getCurToPrice($row['P_SALE_PRICE'] - $row['P_STOCK_PRICE'],$S_ST_LNG);

						## ceosb 사이트 전용 버튼 설정
						$isCeosb				= false;
						if($S_SHOP_NAME == "ceosb" && $strCategory == "002000000000") { $isCeosb = true; }

				/* PHP CODE */
			?>
			<tr idx="<?=$strPCode?>">
				<td><input type="checkbox" id="chkNo" name="chkNo[]" value="<?=$strPCode?>"></td>
				<td><?=$intListNum?></td>
				<td><a href="javascript:goOpenWindow('<?=$strPCode?>')"><img src="<?=$strProdImageName?>" class="prodPhoto"></a></td>
				<td class="prodListInfo">
					<ul>
						<li class="title"><?=$strPName?>
										  <?if($isCeosb):?>
										  <a class="btn_sml" href="javascript:C_getPopup('/<?=$S_SITE_LNG_PATH?>/?menuType=html&mode=userProductAuditList&pCode=<?=$strPCode?>', '800', '600');"><strong>발급리스트</strong></a>
										  <?endif;?></li>
						<li><span><?=$LNG_TRANS_CHAR["PW00021"] //카테고리?>:</span><?=getCateName($row[P_CATE],$strStLng)?></li>
						<li><span><?=$LNG_TRANS_CHAR["PW00176"] //상품번호?>:</span><?=$row[P_CODE]?></li>
						<li><span><?=$LNG_TRANS_CHAR["PW00003"] //상품코드?>:</span><?=$row[P_NUM]?></li>
						<li>
							<span><?=$LNG_TRANS_CHAR["PW00175"]//상품공유?>:</span><a class="btn_sml" href="javascript:goProdShare('<?=$strPCode?>');" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["SW00025"] //설정?></strong></a><br>
							<div id="divProdShareHtml_<?=$strPCode?>">
							<?if($aryProdShareList && is_array($aryProdShareList)):
								$strTag						= "";
								foreach($aryProdShareList as $intKey => $aryData):
									$strProdShareCateName	= getCateName($aryProdShareList[$j][PS_P_CATE],$strStLng);
									if($strTag)	{ $strTag  .= "<br>"; }
									$strTag				   .= "<span></span>/{$strProdShareCateName}";
								endforeach;
							  endif;?>
							</div>
						</li>
						<?if($bolDiscountShow):?>
						<li><span>할인상품:</span><?=$strEventTitle?></li>
						<?endif;?>
					</ul>
					<div class="clr"></div>
				</td>
				<?if($bolProdShopShow):?>
				<td><?echo $result2['SH_COM_NAME'];?></td>
				<?endif;?>
				<td><p onclick="goProdViewModifyActEvent('<?=$strPCode?>','web');" class="webView"><img src="<?php echo $strWebViewIcon;?>"></p><br>
					<p onclick="goProdViewModifyActEvent('<?=$strPCode?>','mob');" class="mobView"><img src="<?php echo $strMobViewIcon;?>"></p></td>
				<td class="txtRight">
					<ul class="prod_price_info">
						<!--li><?=$LNG_TRANS_CHAR["PW00036"] //소비자가?> : <span><?=$strMoneyIconLeft?> <input type="input" name="consumer_price_<?=$strPCode?>" id="sale_price_<?=$strPCode?>" value="<?=$intConsumerPrice?>" <?=$priceBox2?>/> <?=$strMoneyIconRight?></span></li-->
						<li><?=$LNG_TRANS_CHAR["PW00115"] //판매가?>   : <span><?=$strMoneyIconLeft?> <input type="input" name="sale_price_<?=$strPCode?>" id="sale_price_<?=$strPCode?>" value="<?=$intSalePrice?>" <?=$priceBox?>/> <?=$strMoneyIconRight?></span></li>
						<!--li><?=$LNG_TRANS_CHAR["PW00037"] //입고가?>   : <span><?=$strMoneyIconLeft?> <input type="input" name="stock_price_<?=$strPCode?>" id="sale_price_<?=$strPCode?>" value="<?=$intStockPrice?>" <?=$priceBox2?>/> <?=$strMoneyIconRight?></span></li-->
					</ul>
				</td>
				<td>
					<span><?=$strMoneyIconLeft?> <strong><?=getCurToPrice($row['P_COMMISION_PRICE'],$S_ST_LNG)?></strong> <?=$strMoneyIconRight?><?=($row['P_COMMISION_RATE'] > 0) ? "(<strong>".$row['P_COMMISION_RATE']."</strong>%)":"";?>
				</td>
				<td><input type="input" name="point_<?=$strPCode?>" id="point_<?=$strPCode?>" value="<?=$intPoint?>" <?=$priceBox?> style="width:50px;"/> P</td>
				<td><input type="input" name="qty_<?=$strPCode?>" id="qty_<?=$strPCode?>" value="<?=$strProdQty?>" <?=$nBox?> style="width:40px;text-align:right;"<?=$strProdQtyReadOnly?>/></td>
				<td><?=$row[P_REP_DT]?></td>
				<td>
					<?
					//	for($j=0;$j<sizeof($arySiteUseLng);$j++){
					//		if ($arySiteUseLng[$j]){
					//			echo "<a class=\"btn_blue_sml\" href=\"javascript:goProdModify('".$strPCode."','".$arySiteUseLng[$j]."');\"><strong>".$arySiteUseLng[$j]."</strong></a>";
					//		}
					//	}
					?>
					<a class="btn_blue_sml" href="javascript:goProdModify('<?=$strPCode?>','<?=$strStLng?>');" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00003"] // 수정?></strong></a>
					<a class="btn_blue_sml" href="javascript:goProdCopy('<?=$strPCode?>');" id="menu_auth_e1" style="display:none"><strong><?=$LNG_TRANS_CHAR["PW00018"] // 복사?></strong></a>
					<a class="btn_sml" href="javascript:goProdDelete('<?=$strPCode?>');" id="menu_auth_d" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00004"] // 삭제?></strong></a>
				</td>
			</tr>
			<?
					$intListNum--;
				}
			}
			?>
		</table>

	<div class="paginate">
		<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?>
	</div>
	<div class="buttonBoxWrap">
		<a class="btn_new_blue" href="javascript:goProdAllDelete();" id="menu_auth_d" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00048"]//선택삭제?></strong></a>
		<?if ($S_ST_LNG == $strProdLng){?>
		<a class="btn_new_blue" href="javascript:goProdAllUpdate();" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["PW00124"]//일괄변경?></strong></a>
		<?}?>
		<a class="btn_new_blue" href="javascript:goProdCateUpdate();" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["PW00085"]//카테고리일괄변경?></strong></a>
		<a class="btn_new_blue" href="javascript:goProdShareMultiMoveEvent();" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["PW00175"]//상품공유?></strong></a>
		<?php if($S_MALL_TYPE == "M" && $a_admin_type == "A"):?>
		<a class="btn_new_blue" href="javascript:goProdShopChangeMoveEvent();" id="menu_auth_m" style="display:none"><strong>입점사변경</strong></a>
		<?php endif;?>
	</div>
</div>
<?php echo $S_SITE_TYPE;?>
<!-- ******** 컨텐츠 ********* -->