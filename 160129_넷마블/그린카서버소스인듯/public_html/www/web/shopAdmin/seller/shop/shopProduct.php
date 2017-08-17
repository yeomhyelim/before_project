<?
	## 스크립트 설정 
	$aryScriptEx[] = "/common/eumEditor2/js/eumEditor2.js";
	$aryScriptEx[] = "./common/js/seller/shop/shopSite.js";

	## 파일 경로 설정
	if($storeRow['ST_LOGO'])		{ 	$st_logo		= "/upload/shop/store_{$storeRow['SH_NO']}/design/{$storeRow['ST_LOGO']}"; }
	if($storeRow['ST_IMG'])			{ 	$st_img			= "/upload/shop/store_{$storeRow['SH_NO']}/design/{$storeRow['ST_IMG']}"; }
	if($storeRow['ST_THUMB_IMG'])	{	$st_thumb_img	= "/upload/shop/store_{$storeRow['SH_NO']}/design/{$storeRow['ST_THUMB_IMG']}"; }

	## 기본 설정
	$aryPageLineList		= array(10, 20, 30, 40, 50, 60, 70, 80, 90, 100, 200);
	$bolProdShopShow		= false;
	$param['P_SHOP_NO'] = $intSH_NO;
	## 쇼핑몰 타입이 입점몰일때 입점사명 표시
	if($S_MALL_TYPE == "M") { $bolProdShopShow = true; }

	$intShNo = $_GET['shopNo'];

	## 관리자 로그인, 영업사원, 관리 입점사가 있는 경우 관리 입점사만 출력한다.
			if($strAdminType == "A" && $strAdminTm == "Y" && $strAdminShopList):
				$param['P_SHOP_NO_IN']			= $strAdminShopList;
			endif;

			## 리스트
			$param['PRODUCT_INFO_LNG_JOIN']		= $S_SITE_LNG;
			$intPage							= $_REQUEST['page'];
			$intTotal							= $productMgr->getProdListEx($db, "OP_COUNT", $param);						// 데이터 전체 개수
//			echo $db->query;
			$intPageLine						= $_REQUEST['pageLine'];
			$intPageLine						= ( $intPageLine )			? $intPageLine	: 10;							// 리스트 개수
			$intPage							= ( $intPage )				? $intPage		: 1;
			$intFirst							= ( $intTotal == 0 )		? 0				: $intPageLine * ( $intPage - 1 );

			$param['ORDER_BY']					= $_GET['order'];
//			$param['ORDER_BY']					= "P.P_CODE DESC";
//			$param['ORDER_BY']					= $strSearchOrderSortCol;													// 정렬 컬럼
//			$param['ORDER_SORT']				= $strSearchOrderSort;														// 정렬 방법

			if( $S_MALL_TYPE == "M"):
			$param['SHOP_SITE_JOIN']			= "Y";
			endif;

			$param['PRODUCT_IMG_JOIN']			= "Y";
			$param['LIMIT']						= "{$intFirst},{$intPageLine}";
			$result								= $productMgr->getProdListEx($db, "OP_LIST", $param);
//			$productMgr->getProdListEx2($db, "OP_LIST", $param);
//			echo $db->query;
			$intPageBlock						= 10;																		// 블럭 개수
			$intListNum							= $intTotal - ( $intPageLine * ( $intPage - 1 ) );							// 번호
			$intTotPage							= ceil( $intTotal / $intPageLine );

			## 페이징 링크 주소
			$queryString	= explode("&", $_SERVER['QUERY_STRING']);
			$linkPage		= "";
			foreach($queryString as $string):
				list($key,$val)		= explode("=", $string);
				if($key == "page")	{ continue; }
				if($linkPage)		{ $linkPage .= "&"; }
				$linkPage		   .= $string;
			endforeach;

			$linkPage		= "./?{$linkPage}&page=";



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

	/* 상품정보 수정 호출*/
	function goProdModify(no,lang)
	{
//		var doc = document.form;
//		doc.prodCode.value = no;
//		doc.prodLang.value = lang;
//
//		C_getMoveUrl("prodModify","get","<?=$PHP_SELF?>");

		var data						= new Object();

		data['menuType']				= "product";
		data['prodCode']				= no;
		data['prodLang']				= lang
		data['mode']					= "prodModify";

		C_getAddLocationUrl(data);
	}

	/* 상품정보 삭제*/
	function goProdDelete(no)
	{
		var doc = document.form;
		doc.prodCode.value = no;

		var x = confirm("<?=$LNG_TRANS_CHAR['CS00007']?>"); //선택한 상품을 삭제하시겠습니까?
		if (x == true)
		{
			C_getAction("prodDelete",'<?=$PHP_SELF?>');
		}
	}

	function goProdAllDelete()
	{
		C_getMultiCheck("prodAllDelete","","삭제하실 데이터를 선택해주세요."); //데이터를 선택해주세요.
	}

	function goProdAllAppr()
	{
		C_getMultiCheck("prodAllAppr","","변경하실 데이터를 선택해주세요."); //데이터를 선택해주세요.
	}

	function goProductAppr(viewSelect,prodCode) {
		
		var val					= $(viewSelect).val();
		//alert(no);
		var data				= new Object();
		//if(!no) {
		//	alert("공통리스트를 선택하세요.");
		//	return;
		//}
		data['menuType']		= "product";
		data['mode']			= "json";
		data['jsonMode']		= "productAppr";
		data['state']			= val;
		data['prodCode']		= prodCode;

		$.ajax({
			url			: "./"
		   ,data		: data
		   ,type		: "POST"
		   ,dataType	: "json"
		   ,success		: function(data) {
				if(data['__STATE__'] == "SUCCESS") {
					var text		= data['DATA']['TEXT'];
					//goProductProdAddTextEvent(text, 1);
//					editorInsertHTML(text,'new_prodWebText_iframe');
				} else {
					alert(data['__MSG__']);
				}
		   }
		});
	}
//-->
</script>
<div id="contentArea">
	<div class="contentTop">
		<h2><?= $LNG_TRANS_CHAR["OW00022"]; //상품정보 ?></h2>
		<div class="clr"></div>
	</div>
	<div class="tabImgWrap mt10">
		<a href="javascript:javascript:goMoveUrl('shopModify','<?=$intSU_NO?>');"><?= $LNG_TRANS_CHAR["BW00006"]; //회사정보 ?></a>
		<a href="javascript:javascript:goMoveUrl('shopProduct','<?=$intSU_NO?>');" class="selected"><?= $LNG_TRANS_CHAR["OW00022"]; //상품정보 ?></a>
		<a href="javascript:javascript:goMoveUrl('shopGrade','<?=$intSU_NO?>');"><?= $LNG_TRANS_CHAR["SW00082"]; //등급 심사 정보 ?></a>
		<a href="javascript:javascript:goMoveUrl('shopSetting','<?=$intSU_NO?>');"><?= $LNG_TRANS_CHAR["SW00083"]; //거래/배송정보 ?></a>
		<a href="javascript:javascript:goMoveUrl('shopUser','<?=$intSU_NO?>');"><?= $LNG_TRANS_CHAR["SW00084"]; //관리자정보 ?></a>
	</div>
	<!-- ******** 컨텐츠 ********* -->
	<div class="tableFormWrap">
		<!--  ****************  -->
		<!--
		<table class="tableForm">
			<tr>
				<th>번호</th>
			</tr>
		</table>
		-->
	</div>
	<table class="tableList">
			<colgroup>
				<col style="width:40px;"/>
				<col style="width:60px;"/>
				<col style="width:50px;"/>
				<col style="width:180px;"/>
				<col style="width:100px;"/>
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
					<a href="javascript:goOrderEvent('productNameAsc');" class="btn_down"><span>▼</span></a>
				</th>
				<th>
					<?= $LNG_TRANS_CHAR["SW00106"]; //상품승인 ?>
				</th>
				<!--th>
					<?=$LNG_TRANS_CHAR["PW00010"] //상품출력?>
					<a href="javascript:goOrderEvent('productWebShowDesc');" class="btn_up"><span>▲</span></a>
					<a href="javascript:goOrderEvent('productWebShowAsc');" class="btn_down"><span>▼</span></a>
				</th-->
				
				<th>
					<?=$LNG_TRANS_CHAR["BW00054"] //판매가?>
					<a href="javascript:goOrderEvent('productSalePriceDesc');" class="btn_up"><span>▲</span></a>
					<a href="javascript:goOrderEvent('productSalePriceAsc');" class="btn_down"><span>▼</span></a>
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
					while($row = mysql_fetch_array($result))
					{
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
						$strP_APPR			= $row['P_APPR'];

						$strP_ORIGIN		= $row['P_ORIGIN'];
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


						<li><span><?=($S_FIX_PROD_BASIC_ITEM_USE=="Y") ? $S_FIX_PROD_BASIC_ITEM[$S_SITE_LNG]['ORIGIN']: $LNG_TRANS_CHAR["PW00005"]; //원산지?>:<?=$aryCountryList[$strP_ORIGIN]?></span></li>

					</ul>
					<div class="clr"></div>
				</td>
				<td>
					<?
					if($a_admin_type == 'A')
					{
					?>
					<select name="pAppr" onChange="javascript:goProductAppr(this,<?=$strPCode?>);">
						<option value="N" <?=(!$strP_APPR || $strP_APPR=='N') ? ' selected ' : '' ;?> ><?= $LNG_TRANS_CHAR["CW00127"]; //미승인 ?></option>
						<option value="Y" <?=($strP_APPR=='Y') ? ' selected ' : '' ;?> ><?= $LNG_TRANS_CHAR["CW00006"]; //승인 ?></option>
					</select>
					<?
					}
					else
					{
						if(!$strP_APPR ||$strP_APPR=='N'){
							echo $LNG_TRANS_CHAR["CW00127"]; //미승인
						}else{
							echo $LNG_TRANS_CHAR["CW00006"]; //승인
						}
					}
					?>
				</td>
				<!--td><p onclick="goProdViewModifyActEvent('<?=$strPCode?>','web');" class="webView"><img src="<?php echo $strWebViewIcon;?>"></p><br>
					<p onclick="goProdViewModifyActEvent('<?=$strPCode?>','mob');" class="mobView"><img src="<?php echo $strMobViewIcon;?>"></p></td-->
				<td class="txtRight">
					<ul class="prod_price_info">
						<li><span><?=$strMoneyIconLeft?> <?=$intSalePrice?><?= $LNG_TRANS_CHAR["SW00107"]; //원 ?></span></li>
					</ul>
				</td>
				<td><?=$strProdQty?></td>
				<td><?=$row[P_REP_DT]?></td>
				<td>
					<?
					//	for($j=0;$j<sizeof($arySiteUseLng);$j++){
					//		if ($arySiteUseLng[$j]){
					//			echo "<a class=\"btn_blue_sml\" href=\"javascript:goProdModify('".$strPCode."','".$arySiteUseLng[$j]."');\"><strong>".$arySiteUseLng[$j]."</strong></a>";
					//		}
					//	}
					?>
					<a class="btn_blue_sml" href="javascript:goProdModify('<?=$strPCode?>','<?=$strStLng?>');" id="menu_auth_m" ><strong><?=$LNG_TRANS_CHAR["CW00003"] // 수정?></strong></a>
					<!--<a class="btn_blue_sml" href="javascript:goProdCopy('<?=$strPCode?>');" id="menu_auth_e1" style="display:none"><strong><?=$LNG_TRANS_CHAR["PW00018"] // 복사?></strong></a>-->
					<a class="btn_sml" href="javascript:goProdDelete('<?=$strPCode?>');" id="menu_auth_d" ><strong><?=$LNG_TRANS_CHAR["CW00004"] // 삭제?></strong></a>
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
		<a class="btn_new_blue" href="javascript:goProdAllDelete();" id="menu_auth_d" ><strong><?=$LNG_TRANS_CHAR["CW00048"]//선택삭제?></strong></a>
		<?
		if($a_admin_type == 'A')
		{
		?>
		<a class="btn_new_blue" href="javascript:goProdAllAppr();" id="menu_auth_m" ><strong>일괄승인</strong></a>
		<?
		}
		?>
		<!--<a class="btn_new_blue" href="javascript:goProdCateUpdate();" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["PW00085"]//카테고리일괄변경?></strong></a>
		<a class="btn_new_blue" href="javascript:goProdShareMultiMoveEvent();" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["PW00175"]//상품공유?></strong></a>
		<?php if($S_MALL_TYPE == "M" && $a_admin_type == "A"):?>
		<a class="btn_new_blue" href="javascript:goProdShopChangeMoveEvent();" id="menu_auth_m" style="display:none"><strong>입점사변경</strong></a>
		<?php endif;?>-->
	</div>
</div>
<!-- ******** 컨텐츠 ********* -->