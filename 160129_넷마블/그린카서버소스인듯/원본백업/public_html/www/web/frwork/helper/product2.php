<?
	require_once MALL_CONF_LIB."CateMgr.php";
	require_once MALL_CONF_LIB."ProductMgr.php";
	require_once MALL_CONF_LIB."OrderMgr.php";
	require_once MALL_CONF_LIB."MemberMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";

	require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/conf/site_skin_product.conf.inc.php";
	require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/conf/product.inc.php";
	require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/conf/order.inc.php";

	/*상품함수관련*/
	require_once MALL_PROD_FUNC;

	if(is_file("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/shop.manual.inc.php")):
		require_once "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/shop.manual.inc.php";
	endif;	

	$cateMgr		= new CateMgr();		
	$productMgr		= new ProductMgr();
	$orderMgr		= new OrderMgr();
	$memberMgr		= new MemberMgr();
	$siteMgr		= new SiteMgr();


	$strP_CODE				= $_POST["prodCode"]			? $_POST["prodCode"]			: $_REQUEST["prodCode"];

	$strSearchField			= $_POST["searchField"]			? $_POST["searchField"]			: $_REQUEST["searchField"];
	$strSearchKey			= $_POST["searchKey"]			? $_POST["searchKey"]			: $_REQUEST["searchKey"];
	$intPage				= $_POST["page"]				? $_POST["page"]				: $_REQUEST["page"];


	$strSearchHCode1		= $_POST["lcate"]				? $_POST["lcate"]				: $_REQUEST["lcate"];
	$strSearchHCode2		= $_POST["mcate"]				? $_POST["mcate"]				: $_REQUEST["mcate"];
	$strSearchHCode3		= $_POST["scate"]				? $_POST["scate"]				: $_REQUEST["scate"];
	$strSearchHCode4		= $_POST["fcate"]				? $_POST["fcate"]				: $_REQUEST["fcate"];
	$strSearchProdShare		= $_POST["lcateShare"]			? $_POST["lcateShare"]			: $_REQUEST["lcateShare"];

	$strSearchSort			= $_POST["sort"]				? $_POST["sort"]				: $_REQUEST["sort"];
	$strSearchIcon1			= $_POST["searchIcon1"]			? $_POST["searchIcon1"]			: $_REQUEST["searchIcon1"];
	$strSearchIcon2			= $_POST["searchIcon2"]			? $_POST["searchIcon2"]			: $_REQUEST["searchIcon2"];
	$strSearchIcon3			= $_POST["searchIcon3"]			? $_POST["searchIcon3"]			: $_REQUEST["searchIcon3"];
	$strSearchIcon4			= $_POST["searchIcon4"]			? $_POST["searchIcon4"]			: $_REQUEST["searchIcon4"];
	$strSearchIcon5			= $_POST["searchIcon5"]			? $_POST["searchIcon5"]			: $_REQUEST["searchIcon5"];
	$strSearchIcon6			= $_POST["searchIcon6"]			? $_POST["searchIcon6"]			: $_REQUEST["searchIcon6"];
	$strSearchIcon7			= $_POST["searchIcon7"]			? $_POST["searchIcon7"]			: $_REQUEST["searchIcon7"];
	$strSearchIcon8			= $_POST["searchIcon8"]			? $_POST["searchIcon8"]			: $_REQUEST["searchIcon8"];
	$strSearchIcon9			= $_POST["searchIcon9"]			? $_POST["searchIcon9"]			: $_REQUEST["searchIcon9"];
	$strSearchIcon10		= $_POST["searchIcon10"]		? $_POST["searchIcon10"]		: $_REQUEST["searchIcon10"];
	$strSearchColor			= $_POST["searchColor"]			? $_POST["searchColor"]			: $_REQUEST["searchColor"];
	$strSearchSize			= $_POST["searchSize"]			? $_POST["searchSize"]			: $_REQUEST["searchSize"];

	$strSearchStartPrice	= $_POST["searchStartPrice"]	? $_POST["searchStartPrice"]	: $_REQUEST["searchStartPrice"];
	$strSearchEndPrice		= $_POST["searchEndPrice"]		? $_POST["searchEndPrice"]		: $_REQUEST["searchEndPrice"];

	$strSearchListIcon		= $_POST["searchListIcon"]		? $_POST["searchListIcon"]		: $_REQUEST["searchListIcon"];

	$strSearchBrand			= $_POST["searchBrand"]			? $_POST["searchBrand"]			: $_REQUEST["searchBrand"];

	$productMgr->setP_LNG($S_SITE_LNG);
	$cateMgr->setCL_LNG($S_SITE_LNG);

	switch ($strMode)
	{
		case "paperWrite":
		
		break;

		case "list":
		case "search":

			$productMgr->setSearchHCode1($strSearchHCode1);
			$productMgr->setSearchHCode2($strSearchHCode2);
			$productMgr->setSearchHCode3($strSearchHCode3);
			$productMgr->setSearchHCode4($strSearchHCode4);
			$productMgr->setSearchProdShare($strSearchProdShare);

			$productMgr->setSearchField($strSearchField);
			$productMgr->setSearchKey($strSearchKey);

			if ($strDevice == "m") $productMgr->setSearchMobileView("Y");
			else $productMgr->setSearchWebView("Y");

			//$productMgr->setSearchWebView("Y");
			$productMgr->setSearchPriceView("Y");
			$productMgr->setSearchSort($strSearchSort);
			$productMgr->setSearchIcon1($strSearchIcon1);
			$productMgr->setSearchIcon2($strSearchIcon2);
			$productMgr->setSearchIcon3($strSearchIcon3);
			$productMgr->setSearchIcon4($strSearchIcon4);
			$productMgr->setSearchIcon5($strSearchIcon5);
			$productMgr->setSearchIcon6($strSearchIcon6);
			$productMgr->setSearchIcon7($strSearchIcon7);
			$productMgr->setSearchIcon8($strSearchIcon8);
			$productMgr->setSearchIcon9($strSearchIcon9);
			$productMgr->setSearchIcon10($strSearchIcon10);

			$productMgr->setSearchColor($strSearchColor);
			$productMgr->setSearchSize($strSearchSize);

			$productMgr->setSearchStartPrice(getPriceToCur($strSearchStartPrice));
			$productMgr->setSearchEndPrice(getPriceToCur($strSearchEndPrice));

			$productMgr->setSearchListIcon($strSearchListIcon);
/*
			$intPageBlock		= 10;
			$intPageLine		= ($S_PRODUCT_LIST_IVW * $S_PRODUCT_LIST_IVH);
			$intPageDesignLine	= $S_PRODUCT_LIST_IVW;

			$productMgr->setPageLine($intPageLine);
	
			if ($strSearchProdShare == "Y") $intTotal	= $productMgr->getProdShareTotal($db);
			else $intTotal	= $productMgr->getProdTotal($db);
			$intTotPage	= ceil($intTotal / $productMgr->getPageLine());
				
			if(!$intPage)	$intPage =1;

			if ($intTotal==0) {
				$intFirst	= 1;
				$intLast	= 0;			
			} else {
				$intFirst	= $intPageLine *($intPage -1);
				$intLast	= $intPageLine * $intPage;
			}
			$productMgr->setLimitFirst($intFirst);
			if ($strSearchProdShare == "Y") $result = $productMgr->getProdShareList($db);
			else $result = $productMgr->getProdList($db);
			$intListNum = $intTotal - ($intPageLine *($intPage-1));		
*/
			
			$linkPage  = "?menuType=$strMenuType&mode=$strMode&lcate=$strSearchHCode1&mcate=$strSearchHCode2";
			$linkPage .= "&scate=$strSearchHCode3&fcate=$strSearchHCode4&lcateShare=$strSearchProdShare";
			$linkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
			$linkPage .= "&searchIcon6=$strSearchIcon6&searchIcon7=$strSearchIcon7&searchIcon8=$strSearchIcon8";
			$linkPage .= "&sort=$strSearchSort&searchColor=$strSearchColor&searchSize=$strSearchSize";
			$linkPage .= "&searchStartPrice=$strSearchStartPrice&searchEndPrice=$strSearchEndPrice&searchListIcon=$strSearchListIcon";
			$linkPage .= "&searchBrand=$strSearchBrand&page=";
			
			/* 상품 카테고리별 추천 목록 */
			//$productMgr->setSearchIcon6("Y");
			//$productMgr->setLimitFirst(0);
			//$productMgr->setPageLine($D_PRODUCT_LIST_REC_LW * $D_PRODUCT_LIST_REC_LH);
			//$aryProdRecList = $productMgr->getProdSubList($db);
			
			/* 카테고리명 */
			if ($strSearchHCode1){
				$cateMgr->setC_CODE($strSearchHCode1);
				$strSearchHCodeName1 = $cateMgr->getCateLevelName($db);
	
				//카테고리별 관련 상품
				//$aryProdCateSellList = $productMgr->getProdCateSellList($db);
			}

			if($strSearchHCode2):
				$cateMgr->setC_CODE($strSearchHCode1.$strSearchHCode2);
				$strSearchHCodeName2 = $cateMgr->getCateLevelName($db);
			endif;

			if($strSearchHCode3):
				$cateMgr->setC_CODE($strSearchHCode1.$strSearchHCode2.$strSearchHCode3);
				$strSearchHCodeName3 = $cateMgr->getCateLevelName($db);
			endif;

			if($strSearchHCode4):
				$cateMgr->setC_CODE($strSearchHCode1.$strSearchHCode2.$strSearchHCode3.$strSearchHCode4);
				$strSearchHCodeName4 = $cateMgr->getCateLevelName($db);
			endif;
			
			/* 추천 상품 관련하여 */
			$cateMgr->setIC_TYPE("SUB");
			$aryProdSubList = $cateMgr->getProdDisplayList($db);


			// 카테고리
//			$strP_CATE			= $strSearchHCode1;
//			if ($strSearchHCode2) $strP_CATE .= $strSearchHCode2;
//			else $strP_CATE .= "000";
			
//			if ($strSearchHCode3) $strP_CATE .= $strSearchHCode3;
//			else $strP_CATE .= "000";
			
//			if ($strSearchHCode4) $strP_CATE .= $strSearchHCode4;
//			else $strP_CATE .= "000";
			
//			$designMgr->setTI_CATE_CODE($strP_CATE);
			// 카테고리

//			$topImage 				= $designMgr->getDesignTopImageView($db);
//			$strTopImageFileName = $topImage['TI_TOP_IMAGE'];
			
			
			// 추천 상품 관련하여
//			$designMgr->setPV_PAGE("subpage");
//			$subPageResult = $designMgr->getProdPageList($db);			
		break;

		case "view":
			
			$productMgr->setP_CODE($strP_CODE);
			
			/* 좋아요 */
			if ($S_FIX_PRODUCT_LIST_LIKE_USE == "Y"){
				if ($g_member_no && $g_member_login){
					$productMgr->setM_NO($g_member_no);
					$productMgr->setSearchProdLike("prodList");
				}
			}
			$prodRow = $productMgr->getProdView($db);

			## 카테고리 설정
			$_GET['lcate'] = substr($prodRow['P_CATE'], 0, 3);
			$_GET['mcate'] = substr($prodRow['P_CATE'], 3, 3);
			$_GET['scate'] = substr($prodRow['P_CATE'], 6, 3);
			$_GET['fcate'] = substr($prodRow['P_CATE'], 9, 3);
			if($_GET['lcate'] == "000") { $_GET['lcate'] = ""; }
			if($_GET['mcate'] == "000") { $_GET['mcate'] = ""; }
			if($_GET['scate'] == "000") { $_GET['scate'] = ""; }
			if($_GET['fcate'] == "000") { $_GET['fcate'] = ""; }

			/* edit 변수 지정 */
			$_EDIT['lcate'] = substr($prodRow['P_CATE'], 0, 3);
			$_EDIT['mcate'] = substr($prodRow['P_CATE'], 3, 3);
			$_EDIT['scate'] = substr($prodRow['P_CATE'], 6, 3);
			$_EDIT['fcate'] = substr($prodRow['P_CATE'], 9, 3);

			/* VIEW 이미지 리스트 */
			$productMgr->setPM_TYPE("view");
			$prodImgRow = $productMgr->getProdImg($db);		

			/* 카테고리 위치 표시 */
			if (!$strSearchHCode1) $strSearchHCode1 = substr($prodRow['P_CATE'], 0, 3);
			if (!$strSearchHCode2) $strSearchHCode2 = substr($prodRow['P_CATE'], 3, 3);
			if (!$strSearchHCode3) $strSearchHCode3 = substr($prodRow['P_CATE'], 6, 3);
			if (!$strSearchHCode4) $strSearchHCode4 = substr($prodRow['P_CATE'], 9, 3);

			$cateMgr->setC_CODE($strSearchHCode1);
			$strSearchHCodeName1 = $cateMgr->getCateLevelName($db);

			$cateMgr->setC_CODE($strSearchHCode1.$strSearchHCode2);
			$strSearchHCodeName2 = $cateMgr->getCateLevelName($db);

			$cateMgr->setC_CODE($strSearchHCode1.$strSearchHCode2.$strSearchHCode3);
			$strSearchHCodeName3 = $cateMgr->getCateLevelName($db);

			$cateMgr->setC_CODE($strSearchHCode1.$strSearchHCode2.$strSearchHCode3.$strSearchHCode4);
			$strSearchHCodeName4 = $cateMgr->getCateLevelName($db);
			
			/* 적립금 */
			$strProdSaleTotalPrice					= "";
			$strProdSaleTotalPriceLeftMark			= "";
			$strProdSaleTotalPriceRightMark			= "";

			$strProdSaleOrgTotalPrice				= "";
			$strProdSaleTotalOrgPriceLeftMark		= ""; 
			$strProdSaleTotalOrgPriceRightMark		= "";

			if ($prodRow[P_EVENT] > 0 && getProdEventInfo($prodRow) == "Y") $intProdSalePrice = $prodRow['P_SALE_PRICE'];
			else $intProdSalePrice	= getProdDiscountPrice($prodRow,"2");

			$strProdSaleTotalPrice				= getFormatPrice($intProdSalePrice * $prodRow['P_MIN_QTY'],2);
			$strProdSaleTotalPriceLeftMark		= $strMoneyIconL;
			$strProdSaleTotalPriceRightMark		= $strMoneyIconR;
			
			if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){
				
				$strProdSaleOrgTotalPrice			= getFormatPrice($intProdSalePrice * $prodRow['P_MIN_QTY'],2);
				$strProdSaleTotalOrgPriceLeftMark	= $S_SITE_CUR_MARK1;
				$strProdSaleTotalOrgPriceRightMark	= "";

				if ($prodRow[P_EVENT] > 0 && getProdEventInfo($prodRow) == "Y") $intProdSalePrice = getCurToPriceSave($prodRow['P_SALE_PRICE'],'US');
				else $intProdSalePrice	= getProdDiscountPrice($prodRow,"2",0,"US");
				
				$strProdSaleTotalPrice				= getFormatPrice($intProdSalePrice * $prodRow['P_MIN_QTY'],2,"USD");
				$strProdSaleTotalPriceLeftMark		= getCurMark('USD');
				$strProdSaleTotalPriceRightMark		= "";
			}
			$intProdPoint = getProdPoint($intProdSalePrice, $prodRow[P_POINT], $prodRow[P_POINT_TYPE], $prodRow[P_POINT_OFF1], $prodRow[P_POINT_OFF2]);
			
			/* 상품 항목 설명 */
			$aryProdItem = $productMgr->getProdItem($db);

			/* 상품 옵션 */
			$productMgr->setPO_TYPE("O");
			$aryProdOpt = $productMgr->getProdOpt($db);

			if (is_array($aryProdOpt)){
				for($i=0;$i<sizeof($aryProdOpt);$i++){
					if ($aryProdOpt[$i][PO_NO] > 0){
						$productMgr->setPO_NO($aryProdOpt[$i][PO_NO]);

						/* 다중가격사용안함.다중가격분리형 */
						$aryProdOpt[$i]["OPT_ATTR1"] = $productMgr->getProdOptAttrGroup($db);

						
						
						/* 다중각격분리형 */
						$aryProdOpt[$i]["OPT_ATTR_ALL"] = $productMgr->getProdOptAttr($db);

		
					}
				}
			}

			/* 상품 추가 옵션*/
			if ($prodRow[P_ADD_OPT] == "Y"){
				$productMgr->setPO_TYPE("A");
				$aryProdAddOpt = $productMgr->getProdOpt($db);
				if (is_array($aryProdAddOpt)){
					for($i=0;$i<sizeof($aryProdAddOpt);$i++){
						if ($aryProdAddOpt[$i][PO_NO] > 0){
							$productMgr->setPO_NO($aryProdAddOpt[$i][PO_NO]);

							$aryProdAddOpt[$i][OPT_ATTR] = $productMgr->getProdAddOpt($db);
						}
					}
				}
			}

			/* 관심상품 나열 */
			$aryProdGrpList = $productMgr->getProdGrpList($db);

			/* 카테고리명 */
			if ($strSearchHCode1){
				//카테고리별 관련 상품
				$productMgr->setSearchHCode1($strSearchHCode1);
				$aryProdCateSellList = $productMgr->getProdCateSellList($db);
			}

			/* 배송관련/반품관련 */
			$siteMgr->setS_COL("S_PROD_DELIVERY_{$S_SITE_LNG}");
			$strProdDeliveryText = $siteMgr->getOneColText($db);
			if ($prodRow['P_SHOP_NO'] > 0){
				$productMgr->setP_SHOP_NO($prodRow['P_SHOP_NO']);
				$strProdDeliveryTextTemp = $productMgr->getProdDeliveryShopInfo($db);
				if($strProdDeliveryTextTemp) { $strProdDeliveryText = $strProdDeliveryTextTemp; }
			}

			$siteMgr->setS_COL("S_PROD_RETURN_{$S_SITE_LNG}");
			$strProdReturnText = $siteMgr->getOneColText($db);
			
			/* 공유카테고리 */
			$productMgr->setP_CATE($prodRow[P_CATE]);
			$aryProdShareCateInfo = $productMgr->getProdShareCateInfo($db);

			/* 입점사 상품일때 입점사 배송정보로 보여준다 */
			if ($prodRow['P_SHOP_NO'] > 0){
				$productMgr->setP_SHOP_NO($prodRow['P_SHOP_NO']);
				$prodShopInfo = $productMgr->getShopView($db);
			}

			

		break;

		case "brandList":
			$intPR_NO  = $_POST["pr_no"]			? $_POST["pr_no"]			: $_REQUEST["pr_no"];

			$linkPage  = "?menuType=$strMenuType&mode=$strMode&lcate=$strSearchHCode1&mcate=$strSearchHCode2";
			$linkPage .= "&scate=$strSearchHCode3&fcate=$strSearchHCode4&lcateShare=$strSearchProdShare";
			$linkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
			$linkPage .= "&searchIcon6=$strSearchIcon6&searchIcon7=$strSearchIcon7&searchIcon8=$strSearchIcon8";
			$linkPage .= "&sort=$strSearchSort&searchColor=$strSearchColor&searchSize=$strSearchSize";
			$linkPage .= "&searchStartPrice=$strSearchStartPrice&searchEndPrice=$strSearchEndPrice&pr_no=$intPR_NO";
			$linkPage .= "&SearchBrand=$strSearchBrand&page=";		
		break;
	}


?>
<script type="text/javascript">
<!--
	var intMemberNo				= "<?=$g_member_no?>";
	
	var aryProdOpt				= "";									//json
	var aryProdOptName			= new Array(11);
	var aryProdOptAttr2			= "";									//json
	var aryProdOptAttr			= "";									//json
	var aryProdAddOpt			= "";
	var aryProdAddOptAttr		= "";
	var strProdOptType			= "";									//상품옵션종류
	var strProdCode				= "";
	var aryProdOptList			= "";									//js
	var aryProdAddOptList		= ""; 
	var strProdAddOptYN			= "N";
	var strProdStockLimit		= "N";									//재고관리함(무제한체크안됨)
	var strProdAllDiscountUse	= "<?=$S_ALL_DISCOUNT_USE?>";			//통합수량할인 사용유무(2014.01.02)
	var aryProdAllDiscount		= "";									//통합수량할인 배열(2014.01.02)
	
	var intProdQty				= 0;
	var strCartDivId			= 0;									//cartDivid(2013.05.24)
	<?if ($strMode == "view"){?>
		strProdOptType			= "<?=$prodRow[P_OPT]?>";				//상품옵션종류
		strProdCode				= "<?=$strP_CODE?>";					//상품코드
		intProdQty				= "<?=$prodRow[P_QTY]?>";				//상품재고
		strProdStockLimit   =	 "<?=$prodRow[P_STOCK_LIMIT]?>";
	<?}?>

	$(document).ready(function(){
		
		<?if ($strMode == "view"){?>
		
			strProdAddOptYN = "<?=$prodRow[P_ADD_OPT]?>"; //추가옵션사용유무

			/* 통합수량할인 사용유무 및 */
			<?if ($S_ALL_DISCOUNT_USE == "Y"){?>
			$.getJSON("./?menuType=product&mode=json&act=prodAllDiscount&prodCode="+strProdCode,function(data){	
				aryProdAllDiscount = data;			
			});
			<?}?>
			
			/* 다중가격사용(일체형)*/
			$.getJSON("./?menuType=product&mode=json&act=prodOptAttr&prodCode=<?=$strP_CODE?>",function(data){	
				aryProdOptAttr = data;			
			});
			
			/* 다중옵션사용 */
			$.getJSON("./?menuType=product&mode=json&act=prodOpt&prodCode=<?=$strP_CODE?>",function(data){	
				aryProdOpt = data;
			});

			<?if (is_array($aryProdOpt)){
				?>
				aryProdOptList = new Array(<?=sizeof($aryProdOpt)?>);
				<?
				for($i=0;$i<sizeof($aryProdOpt);$i++){
					?>
					aryProdOptList[<?=$i?>] = <?=$aryProdOpt[$i][PO_NO]?>;
					<?
				}
			  }?>
		
			/* 추가옵션사용 */
			if (strProdAddOptYN == "Y")
			{
				$.getJSON("./?menuType=product&mode=json&act=prodAddOpt&prodCode=<?=$strP_CODE?>",function(data){	
					aryProdAddOpt = data;			
				});

				$.getJSON("./?menuType=product&mode=json&act=prodAddOptAttr&prodCode=<?=$strP_CODE?>",function(data){	
					aryProdAddOptAttr = data;			
				});

				<?if (is_array($aryProdAddOpt)){
					?>
					aryProdAddOptList = new Array(<?=sizeof($aryProdAddOpt)?>);
					<?
					for($i=0;$i<sizeof($aryProdAddOpt);$i++){
						?>
						aryProdAddOptList[<?=$i?>] = <?=$aryProdAddOpt[$i][PO_NO]?>;
						<?
					}
				  }?>
			}

			/* 상품 장바구니 담기시 추가 2013.05.24*/
			$("#btnProdCartOptDel").live("click",function(){
				
				var intCartNo = $(this).parent().parent().parent().parent().find('input[name="cartOptNo[]"]').val();

				$(this).parent().parent().remove();
				
				if($("#divCartOptAttr_"+intCartNo).find("tr").length == 0 || C_isNull($("#divCartOptAttr_"+intCartNo).find('input[name="cartOptNo[]"]').val())){
					$("#divCartOptAttr_"+intCartNo).remove();
				}
				
				goSelectProdOptTotalHtml();
			});

			$("#0_cartQty").live("blur",function(){
				goProdViewQtyChange(0,"",1);
			});
			/* 상품 장바구니 담기시 추가 2013.05.24*/
		<?}?>

	});

	function goSearchSort(gb) {

		var data			= new Object();

		data["sort"]		= gb;

		C_getAddLocationUrl(data);
	}

// 2014.01.10 kim hee sung - old style
//	function goSearchSort(gb)
//	{
//		var doc = document.form;
//
//		doc.sort.value = gb;
//		doc.method = "get";
//		doc.action = "<?=$PHP_SELF?>";
//		doc.submit();
//	}

	/* 소스 정리중 ... */
	function goProdView(no)
	{
		<?if($strDevice=="m" || $strDevice=="mobile"){?>
		location.href = "./?menuType=product&mode=view&prodCode="+no;
		<?}else{?>
		var doc 				= document.form;

		doc.prodCode.value 	= no;
		doc.mode.value 		= "view";
		doc.method 			= "get";
		doc.action 				= "<?=$PHP_SELF?>";
		doc.submit();
		<?}?>
	}
	/* 소스 정리중 ... */	

	/* 필수사항 체크(2013.05.24) */
	function goNecsssaryCheck()
	{		
		var intProdOptErrCnt= 0;
		var intProdOptEssCnt = 0;

		var intProdAddOptErrCnt = 0;
		var intProdAddOptEssCnt = 0;

		var intProdEssCnt	= 0;
		
		/* 필수사항 체크 여부 */
		if (!C_isNull(aryProdOptList) && aryProdOptList.length > 0)
		{							
			for(var i=0;i<aryProdOptList.length;i++){
			
				var intPO_NO = aryProdOptList[i];
				var strProdOptEssYN = aryProdOpt[intPO_NO].PO_ESS;
				
				if (strProdOptEssYN == "Y"){
					intProdOptEssCnt++;
				}
			}
		}

		if (strProdAddOptYN == "Y")
		{
			if (!C_isNull(aryProdAddOptList) && aryProdAddOptList.length > 0)
			{
				for(var i=0;i<aryProdAddOptList.length;i++){
					
					var intPO_NO = aryProdAddOptList[i];
					var strProdAddOptEssYN = aryProdAddOpt[intPO_NO].PO_ESS;
					
					if (strProdAddOptEssYN == "Y") intProdAddOptEssCnt++;
				}
			}
		}
						
		$('div[id^="divCartOptAttr_"]').each(function(j){
			
			intProdOptErrCnt = 0;
			intProdAddOptErrCnt = 0;
			var aryCartOptNo = $(this).attr("id").split("_");
			var intCartOptNo= aryCartOptNo[1];
						
			$(this).find('input[name="cartOptNo[]"]').each(function(k){
				if ($(this).val() > 0)
				{
					intProdOptErrCnt++;
				};
			});
			
			$(this).find('input[name^="'+intCartOptNo+'cartAddOptNo_no_"]').each(function(k){
				if (!C_isNull($(this).val()))
				{
					intProdAddOptErrCnt++;
				}
			});
			
			if (intProdOptErrCnt != intProdOptEssCnt || intProdAddOptErrCnt < intProdAddOptEssCnt  )
			{
				intProdEssCnt++;
			}
		});
		
		
		/*품절여부확인*/
		if (("<?=$prodRow[P_STOCK_OUT]?>" == "Y") || ("<?=$prodRow[P_QTY]?>" == 0 && "<?=$prodRow[P_STOCK_LIMIT]?>" != "Y"))
		{
			alert("<?=$LNG_TRANS_CHAR['OS00028']?>"); //선택한 상품은 이미 품절된 상품입니다.
			return false;
		}

		if ($('div[id^="divCartOptAttr_"]').length == 0)intProdEssCnt++; //->옵션선택을 하나도 하지 않았을때...
		if (intProdEssCnt > 0)
		{			
			alert("<?=$LNG_TRANS_CHAR['PS00009']?>"); //추가옵션을 하나 이상 선택해주세요.
			return false;
		}

		/*
		var intCartQty = $("#cartQty").val();	
		if (intCartQty == 0)
		{
			alert("<?=$LNG_TRANS_CHAR['OS00005']?>"); //구매수량은 0 이상 입력하셔야 합니다.
			return false;
		}
				
		if (strProdStockLimit == "N" || C_isNull(strProdStockLimit))
		{
		
			var intProdMinQty = (C_isNull("<?=$prodRow[P_MIN_QTY]?>"))? 0 : "<?=$prodRow[P_MIN_QTY]?>";

			if (intProdQty > 0 && intCartQty < intProdMinQty)
			{
				alert("<?=$LNG_TRANS_CHAR['OS00069']?>"); //구매수량은 최소구매수량으로 입력하셔야 합니다.
				return false;
			}
		}
		*/

		<?
		//입력항목사용체크
		if ($S_FIX_PROD_BASIC_ITEM_USE != "Y"){
			if (is_array($aryProdItem)){
				for($i=0;$i<sizeof($aryProdItem);$i++){
					$strProdItemName		= $aryProdItem[$i][PI_NAME];
					$strProdItemType		= (!$aryProdItem[$i][PI_TYPE]) ? "B":$aryProdItem[$i][PI_TYPE];
					$strProdItemId			= "cartAddItem".$aryProdItem[$i][PI_NO];
					$strProdItemErrMsg		= callLangTrans($LNG_TRANS_CHAR["PS00023"],array($strProdItemName));
					if ($strProdItemType != "B"){
						if ($strProdItemType == "C")
						{
							?>
							if ($("input:checkbox[id=<?=$strProdItemId?>]:checked").length == 0)
							{
								alert("<?=$strProdItemErrMsg?>");
								return false;
							}
							<?
						}
						else if ($strProdItemType == "S")
						{
							?>
							if ($("select[name=<?=$strProdItemId?>]") == ""){
								alert("<?=$strProdItemErrMsg?>");
								return false;
							}
							<?
						}
						else if ($strProdItemType == "R")
						{
							?>
							if ($("input:radio[id=<?=$strProdItemId?>]:checked").length == 0){
								alert("<?=$strProdItemErrMsg?>");
								return false;
							}
							<?
						}
						else{
							?>
							if ($("#<?=$strProdItemId?>").val() == ""){
								alert("<?=$strProdItemErrMsg?>");
								return false;
							}
							<?
						}
					}
				}
			}
		}
		?>
		return true;
	}

	/* 장바구니 담기(2013.05.24) */
	function goCart()
	{
		/* 필수사항 체크 여부 */
		if (!goNecsssaryCheck()) return;
		
		var doc = document.form;		
		doc.menuType.value = "product";
		doc.mode.value = "json";
		doc.act.value = "cart";
		doc.method = "post";

<?if($S_SHOP_HOME == "demo2"){?>
//		doc.submit();
<?}?>
		
		var formData = $("#form").serialize();
		C_AjaxPost("cart","./index.php",formData,"post");
	}
	
	/* 바로 주문하기(2013.05.24) */
	function goCartOrder()
	{
		/* 필수사항 체크 여부 */
		if (!goNecsssaryCheck()) return;

		var doc = document.form;
		doc.menuType.value = "product";	
		doc.mode.value = "json";
		doc.act.value = "cartOrder";
		doc.method = "post";
		
//		if ("<?=$S_SHOP_HOME?>" == "demo2")
//		{
//			doc.submit();
//			return;
//		}
		var formData = $("#form").serialize();
		C_AjaxPost("cartOrder","./index.php",formData,"post");
	}

	/* wish(2013.05.24) */
	function goWish()
	{
		if (C_isNull(intMemberNo))
		{
//			alert("<?=$LNG_TRANS_CHAR['OS00014']?>"); //로그인을 하신 후 이용하세요.
			var doc = document.form;
			doc.menuType.value = "member";
			doc.mode.value = "login";
			doc.submit();
			return;
		}
		
		/* 필수사항 체크 여부 */
		if (!goNecsssaryCheck()) return;
		
		var doc = document.form;
		doc.menuType.value = "product";		
		doc.mode.value = "json";
		doc.act.value = "cartWish";
		doc.method = "post";
		//doc.submit();
	
		var formData = $("#form").serialize();
		C_AjaxPost("cartWish","./index.php",formData,"post");		
	}
		
	/* 상품 리스트 이동*/
	function goProdList()
	{
		var doc = document.form;		
		doc.mode.value = "list";
		doc.submit();
	}

	/* 옵션 선택(2013.05.24) */
	function goSelectProdOpt(selObj,sort)
	{		
		var intCartQty			= $("#cartQty").val();		
		var arySelProdOpt		= selObj.split("_");
		var intProdOptNo		= arySelProdOpt[1];  //옵션번호
		var intNextSort			= sort + 1;			 //옵션다음순서
		
		if ($("#"+selObj+" option").length == 1)
		{	
			if (aryProdOpt[intProdOptNo].PO_ESS == "Y")
			{
				alert("<?=$LNG_TRANS_CHAR['PS00009']?>"); //위의 필수선택 정보를 선택해주세요.
				return;
			}
		}
		
/*		if (C_isNull($("#"+selObj).val()))
		{
			$("#realPayPriceText").html(C_toNumberFormatString('<?=$prodRow[P_SALE_PRICE]?>',false)+"원");
			return;
		}
*/		
		aryProdOptName[1]	= aryProdOpt[intProdOptNo].PO_NAME1;
		aryProdOptName[2]	= aryProdOpt[intProdOptNo].PO_NAME2;
		aryProdOptName[3]	= aryProdOpt[intProdOptNo].PO_NAME3;
		aryProdOptName[4]	= aryProdOpt[intProdOptNo].PO_NAME4;
		aryProdOptName[5]	= aryProdOpt[intProdOptNo].PO_NAME5;
		aryProdOptName[6]	= aryProdOpt[intProdOptNo].PO_NAME6;
		aryProdOptName[7]	= aryProdOpt[intProdOptNo].PO_NAME7;
		aryProdOptName[8]	= aryProdOpt[intProdOptNo].PO_NAME8;
		aryProdOptName[9]	= aryProdOpt[intProdOptNo].PO_NAME9;
		aryProdOptName[10]	= aryProdOpt[intProdOptNo].PO_NAME10;
	
		var aryProdOptAttrVal = new Array(11);
		var intProdOptCnt  = 0;
		for(var i=1;i<=10;i++){
			if (aryProdOptName[i])
			{
				intProdOptCnt++;
				var strProdAttrVal = $("#cartOpt"+i+"_"+intProdOptNo+" option:selected").val();
				if (C_isNull(strProdAttrVal))
				{
					strProdAttrVal = "";
				}

				if (i < intNextSort)
				{
					aryProdOptAttrVal[i] = strProdAttrVal;
				} else {
					aryProdOptAttrVal[i] = "";
				}
			} else {
				aryProdOptAttrVal[i] = "";
			}
		}

		var strJsonParam = "&optNo="+intProdOptNo;
		strJsonParam += "&optAttr1="+encodeURIComponent(aryProdOptAttrVal[1]);
		strJsonParam += "&optAttr2="+encodeURIComponent(aryProdOptAttrVal[2]);
		strJsonParam += "&optAttr3="+encodeURIComponent(aryProdOptAttrVal[3]);
		strJsonParam += "&optAttr4="+encodeURIComponent(aryProdOptAttrVal[4]);
		strJsonParam += "&optAttr5="+encodeURIComponent(aryProdOptAttrVal[5]);
		strJsonParam += "&optAttr6="+encodeURIComponent(aryProdOptAttrVal[6]);
		strJsonParam += "&optAttr7="+encodeURIComponent(aryProdOptAttrVal[7]);
		strJsonParam += "&optAttr8="+encodeURIComponent(aryProdOptAttrVal[8]);
		strJsonParam += "&optAttr9="+encodeURIComponent(aryProdOptAttrVal[9]);
		strJsonParam += "&optAttr10="+encodeURIComponent(aryProdOptAttrVal[10]);
		strJsonParam += "&optAttrSort="+intNextSort;
		if (strProdOptType != "2")
		{
			if (!C_isNull(aryProdOptName[intNextSort]))
			{
				$.getJSON("./?menuType=product&mode=json&act=prodOptAttr2"+strJsonParam,function(data){	
					
					$("#cartOpt"+intNextSort+"_"+intProdOptNo).empty().data('options'); 

					var strSelectIndexText = ":: <?=$LNG_TRANS_CHAR['PW00010']?> ::"; //선택
					if (aryProdOpt[intProdOptNo].PO_ESS == "Y")
					{
						strSelectIndexText = ":: <?=$LNG_TRANS_CHAR['PW00009']?> ::"; //(필수) 선택
					}
					$("#cartOpt"+intNextSort+"_"+intProdOptNo).append("<option value=''>"+strSelectIndexText+"</option>");

					for(var i=0;i<data[intProdOptNo][intNextSort].length;i++){
						$("#cartOpt"+intNextSort+"_"+intProdOptNo).append("<option value='"+data[intProdOptNo][intNextSort][i].POA_ATTR+"'>"+data[intProdOptNo][intNextSort][i].POA_ATTR+"</option>");
					}
				})
				
				return;
			} else {

				/* 옵션 마지막 선택 */
				if (intProdOptCnt == sort)
				{
					
					if (!C_isNull(intProdOptNo))
					{
						$.getJSON("./?menuType=product&mode=json&act=prodOptAttrNo"+strJsonParam,function(data){	
						
							if ("<?=$prodRow[P_STOCK_LIMIT]?>" != "Y"){
								if ("<?=$prodRow[P_STOCK_OUT]?>" != "Y" && "<?=$prodRow[P_QTY]?> > 0"){
									if (parseInt(data[0].POA_STOCK_QTY) < $("#cartQty").val())
									{
										alert("<?=$LNG_TRANS_CHAR['OS00029']?>"); //상품의 재고량("+data[0].POA_STOCK_QTY+"개)보다 구매수량이 많습니다.
										return;
									}
								}
							}

							//if (strProdOptType != "1"){
								
								var strProdOptVal		= "";
								for(var k=1;k<=intProdOptCnt;k++){

									if (k == 1) strProdOptVal += aryProdOpt[data[0].PO_NO].PO_NAME1+":"+data[0].POA_ATTR1;
									if (k == 2) strProdOptVal += aryProdOpt[data[0].PO_NO].PO_NAME2+":"+data[0].POA_ATTR2;
									if (k == 3) strProdOptVal += aryProdOpt[data[0].PO_NO].PO_NAME3+":"+data[0].POA_ATTR3;
									if (k == 4) strProdOptVal += aryProdOpt[data[0].PO_NO].PO_NAME4+":"+data[0].POA_ATTR4;
									if (k == 5) strProdOptVal += aryProdOpt[data[0].PO_NO].PO_NAME5+":"+data[0].POA_ATTR5;
									if (k == 6) strProdOptVal += aryProdOpt[data[0].PO_NO].PO_NAME6+":"+data[0].POA_ATTR6;
									if (k == 7) strProdOptVal += aryProdOpt[data[0].PO_NO].PO_NAME7+":"+data[0].POA_ATTR7;
									if (k == 8) strProdOptVal += aryProdOpt[data[0].PO_NO].PO_NAME8+":"+data[0].POA_ATTR8;
									if (k == 9) strProdOptVal += aryProdOpt[data[0].PO_NO].PO_NAME9+":"+data[0].POA_ATTR9;
									if (k == 10) strProdOptVal += aryProdOpt[data[0].PO_NO].PO_NAME10+":"+data[0].POA_ATTR10;
									
									if (k != intProdOptCnt) strProdOptVal += "<br>";
								}
							//}
							//strProdOptVal = aryProdOpt[data[0].PO_NO].PO_NAME1+":"+strProdOptVal;
							var intProdOptPrice2 = "";
							<?if($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){?>
							var intProdOptPrice = "<?if ($prodRow[P_EVENT] > 0 && getProdEventInfo($prodRow) == 'Y'){?><?=getProdDiscountPrice($prodRow)?><?}else{?><?=getCurToPrice($prodRow[P_SALE_PRICE],'US')?><?}?>";
								intProdOptPrice2 = "<?if ($prodRow[P_EVENT] > 0 && getProdEventInfo($prodRow) == 'Y'){?><?=getProdDiscountPrice($prodRow)?><?}else{?><?=getCurToPrice($prodRow[P_SALE_PRICE])?><?}?>";
							<?}else{?>
							var intProdOptPrice = "<?if ($prodRow[P_EVENT] > 0 && getProdEventInfo($prodRow) == 'Y'){?><?=getProdDiscountPrice($prodRow)?><?}else{?><?=getCurToPrice($prodRow[P_SALE_PRICE])?><?}?>";
							<?}?>
							if (strProdOptType != "1"){ 
								<?if($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){?>
								intProdOptPrice  = data[0].POA_SALE_PRICE_USD;
								intProdOptPrice2 = data[0].POA_SALE_PRICE;
								<?}else{?>
								intProdOptPrice = data[0].POA_SALE_PRICE;
								<?}?>

							}
							
							goSelectProdOptHtml(data[0].POA_NO,strProdOptVal,intProdOptPrice,intProdOptPrice2);
						});
					}
				}
			}
		} else {
			
			/* 일체형 수량 체크*/
			var intProdOptAttrNo = $("#"+selObj+" option:selected").val();	
			if ("<?=$prodRow[P_STOCK_LIMIT]?>" != "Y"){
				if ("<?=$prodRow[P_STOCK_OUT]?>" != "Y" && "<?=$prodRow[P_QTY]?> > 0"){
					if (parseInt(aryProdOptAttr[intProdOptAttrNo].POA_STOCK_QTY) < $("#cartQty").val())
					{
						alert("<?=$LNG_TRANS_CHAR['OS00029']?>");
						return;
					}
				}
			}

			/* 스크립트 호출 */
			var strProdOptValHtml = "<input type=\"text\" name=\""+intProdOptNo+"_cartOptVal1\" value=\""+aryProdOptAttr[intProdOptAttrNo].POA_ATTR1+"\">";
			<?if($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){?>
			goSelectProdOptHtml(intProdOptAttrNo,aryProdOptAttr[intProdOptAttrNo].POA_ATTR1,aryProdOptAttr[intProdOptAttrNo].POA_SALE_PRICE_USD,aryProdOptAttr[intProdOptAttrNo].POA_SALE_PRICE);
			<?}else{?>
			goSelectProdOptHtml(intProdOptAttrNo,aryProdOptAttr[intProdOptAttrNo].POA_ATTR1,aryProdOptAttr[intProdOptAttrNo].POA_SALE_PRICE,0);
			<?}?>
		}
	}

	/* 상품 옵션 클릭시 담기(2013.05.24) */
	function goSelectProdOptHtml(optNo,optVal,optPrice,optPrice2)
	{
		/* 옵션 중복체크 */
		var intCartOptNoDupCnt = 0;
		$('input[name="cartOptNo[]"]').each(function(i){
			if ($(this).val() == optNo)
			{
				intCartOptNoDupCnt++;
			};
		});

		if (intCartOptNoDupCnt > 0)
		{
			strCartDivId = "divCartOptAttr_"+optNo;
			return;
		}
		/* 옵션 중복체크 */

		/* 추가옵션 재정리 */
		if (strProdAddOptYN == "Y" && optNo>0)
		{
			if (!C_isNull(aryProdAddOptList) && aryProdAddOptList.length > 0)
			{
				for(var i=0;i<aryProdAddOptList.length;i++){
					$("#cartAddOpt_"+aryProdAddOptList[i]).val("");
				}
			}
		}
		/* 추가옵션 재정리 */

		var strUpCountImg		= "<img src=\"../himg/product/A0001/btn_prod_cnt_up.gif\"/>";
		var strDownCountImg		= "<img src=\"../himg/product/A0001/btn_prod_cnt_down.gif\"/>";
		var strProdCartDelImg	= "<img src=\"../himg/product/A0001/btn_opt_del.gif\"/>";
		if ("<?=$strDevice?>" == "m")
		{
			strUpCountImg		= "<span>▲</span>";
			strDownCountImg		= "<span>▼</span>";
			strProdCartDelImg	= "[x]";
		}
		
		var strSelectProdOptHtml = "<div id=\"divCartOptAttr_"+optNo+"\" class=\"optionWrap\"><table>";		
		strSelectProdOptHtml += "<tr>";

		if (!C_isNull(optNo))
		{
			strSelectProdOptHtml += "<input type=\"hidden\" name=\"cartOptNo[]\" value=\""+optNo+"\">";
			strSelectProdOptHtml += "<input type=\"hidden\" name=\""+optNo+"_cartOptPrice\" id=\""+optNo+"_cartOptPrice\" value=\""+optPrice+"\">";
			strSelectProdOptHtml += "<input type=\"hidden\" name=\""+optNo+"_cartOptOrgPrice\" id=\""+optNo+"_cartOptOrgPrice\" value=\""+optPrice2+"\">";
		}

		strSelectProdOptHtml += "    <td class=\"optTit\">"+optVal+"</td>";
		strSelectProdOptHtml += "    <td class=\"optCnt\">";
		
		strSelectProdOptHtml += "        <ul class=\"cntInputWrap\">";
		strSelectProdOptHtml += "            <li>";
		strSelectProdOptHtml += "                <input type=\"input\" id=\""+optNo+"_cartQty\" name=\""+optNo+"_cartQty\" value=\"<?=$prodRow[P_MIN_QTY]?>\" class=\"cntInputForm _w30\"/> ";
		strSelectProdOptHtml += "            </li>";
		strSelectProdOptHtml += "            <li class=\"btnCntUpDown\">";
		strSelectProdOptHtml += "                <a href=\"javascript:goProdViewQtyChange("+optNo+",'up',1);\">"+strUpCountImg+"</a>";
		strSelectProdOptHtml += "                <a href=\"javascript:goProdViewQtyChange("+optNo+",'down',1);\">"+strDownCountImg+"</a>";
		strSelectProdOptHtml += "            </li>";
		strSelectProdOptHtml += "        </ul>";
		strSelectProdOptHtml += "    </td>";
		
		<?if($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){?>
		strSelectProdOptHtml += "    <td class=\"optPrice\"><?=getCurMark('USD')?> <strong id=\""+optNo+"_cartOptPriceMark\">"+optPrice+"</strong><?=getCurMark2('USD')?>(<?=$S_SITE_CUR_MARK1?><span id=\""+optNo+"_cartOptOrgPriceMark\">"+optPrice2+"</span>)</td>";
		<?}else{?>

		strSelectProdOptHtml += "    <td class=\"optPrice\"><?=getCurMark()?> <strong id=\""+optNo+"_cartOptPriceMark\">"+optPrice+"</strong><?=getCurMark2()?></td>";
		<?}?>
		strSelectProdOptHtml += "    <td class=\"mngProd\"><a id=\"btnProdCartOptDel\">"+strProdCartDelImg+"</a></td>";
		strSelectProdOptHtml += "</tr>";
		strSelectProdOptHtml += "</table></div>";

		$("#divSelectOpt").append(strSelectProdOptHtml);
		$("#"+optNo+"_cartOptPriceMark").formatCurrency({symbol: ''<?=($S_SITE_CUR=='KRW' || $S_SITE_CUR=='JPY' || $S_SITE_CUR=='RUB')?",roundToDecimalPlace:0":"";?>});
		$("#"+optNo+"_cartOptPrice").formatCurrency({symbol: ''<?=($S_SITE_CUR=='KRW' || $S_SITE_CUR=='JPY' || $S_SITE_CUR=='RUB')?",roundToDecimalPlace:0":"";?>});
	
		$("#"+optNo+"_cartQty").live("blur",function(){
			goProdViewQtyChange(optNo,"",1);
		});
		
		strCartDivId = $('div[id^="divCartOptAttr_"]').filter(":last").attr("id");
		goSelectProdOptTotalHtml();
	}
	
	/* 총 상품금액 표시 */
	function goSelectProdOptTotalHtml()
	{
		var intCartOptPriceTotal	= 0;
		var intCartOptOrgPriceTotal = 0;
		$('div[id^="divCartOptAttr_"]').each(function(i){
			var intCartOptNo				= 0;	//옵션번호
			var intCartOptPrice				= 0;	//옵션가격
			var intCartOptQty				= 0;	//옵션수량
			var intCartOptDiscountPrice		= 0;	//옵션별할인가격
			var intCartOptDiscountUsdPrice	= 0;	//옵션별할인가격(USD)
			var intCartOptDiscountRate		= 0;	//옵션별할인가격(%)
			var intCartAddOptPrice			= 0;	//추가옵션가격
			var intCartOptOrgPrice			= 0;	//옵션별가격(USD)
			var intCartAddOptOrgPrice		= 0;	//추가옵션별가격(USD)

			$(this).find('input[name="cartOptNo[]"]').each(function(j){
				intCartOptNo			= $(this).val();
				intCartOptQty			= parseInt($("#"+intCartOptNo+"_cartQty").val());

				/* 통합수량할인 사용유무에 따라서 가격 할인금액에 따라 discount start(2014.01.02)*/
				if (strProdAllDiscountUse == "Y")
				{
					for(var jj = 0;jj<aryProdAllDiscount.length;jj++){
						
						var intDiscountMinQty	= parseInt(aryProdAllDiscount[jj].MIN_QTY);																//최소수량
						var intDiscountMaxQty	= parseInt((aryProdAllDiscount[jj].MAX_QTY) ? aryProdAllDiscount[jj].MAX_QTY : 999999999999);				//최대수량
						//var intDiscountPrice	= aryProdAllDiscount[jj].DISCOUNT_PRICE;														//할인가격
						//var intDiscountUsdPrice	= aryProdAllDiscount[jj].DISCOUNT_USD_PRICE;													//할인가격(USD)
						var intDiscountRate		= aryProdAllDiscount[jj].DISCOUNT_RATE;

						if (intCartOptQty >= intDiscountMinQty && intCartOptQty <= intDiscountMaxQty)
						{
							//intCartOptDiscountPrice		= intDiscountPrice;
							//intCartOptDiscountUsdPrice	= intDiscountUsdPrice;
							intCartOptDiscountRate			= parseInt(intDiscountRate);
							break;
						}
					}
				}
				/* 통합수량할인 사용유무에 따라서 가격 할인금액에 따라 discount end(2014.01.02)*/
				
				if (intCartOptDiscountRate > 0)
				{	

					var intCartOptDiscountPos	= 2;
					<? if ($S_SITE_CUR=='KRW' || $S_SITE_CUR=='JPY' || $S_SITE_CUR=='RUB'){?>
						intCartOptDiscountPos	= 0;
					<?}?>

					intCartOptDiscountPrice		=  C_getCeiling(parseFloat(C_removeComma($("#"+intCartOptNo+"_cartOptPrice").val(),true)) * (intCartOptDiscountRate/100),intCartOptDiscountPos);
					intCartOptDiscountUsdPrice	=  C_getCeiling(parseFloat(C_removeComma($("#"+intCartOptNo+"_cartOptOrgPrice").val(),true)) * (intCartOptDiscountRate/100),intCartOptDiscountPos);
				}

				intCartOptPrice			= intCartOptQty * (parseFloat(C_removeComma($("#"+intCartOptNo+"_cartOptPrice").val(),true)) - intCartOptDiscountPrice);
				intCartOptPriceTotal   += intCartOptPrice;
				
				<?if($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){?>
				intCartOptOrgPrice		 = intCartOptQty * (parseFloat(C_removeComma($("#"+intCartOptNo+"_cartOptOrgPrice").val(),true)) - intCartOptDiscountUsdPrice);
				intCartOptOrgPriceTotal += intCartOptOrgPrice;
				<?}?>
			});
			
			$(this).find('input[name^="'+intCartOptNo+'cartAddOptNo_no_"]').each(function(k){
				
				var aryCartAddOptNo  = $(this).attr("id").split("_");
				var aryCartAddOptNo2 = aryCartAddOptNo[2].split("[]");
				var intCartAddOptNo	= aryCartAddOptNo2[0];

				intCartAddOptPrice	+= parseInt($("input[name^='"+intCartOptNo+"cartAddOptNo_qty_']").eq(k).val()) * parseFloat(C_removeComma($("input[name^='"+intCartOptNo+"cartAddOptNo_price_']").eq(k).val(),true));

				intCartAddOptOrgPrice += parseInt($("input[name^='"+intCartOptNo+"cartAddOptNo_qty_']").eq(k).val()) * parseFloat(C_removeComma($("input[name^='"+intCartOptNo+"cartAddOptNoOrg_price_']").eq(k).val(),true));
				
			});
			
			var intCartPrice		= intCartOptPrice + intCartAddOptPrice;
			var intCartOrgPrice		= intCartOptOrgPrice + intCartAddOptOrgPrice;			
	
			intCartOptPriceTotal += intCartAddOptPrice;
			intCartOptOrgPriceTotal += intCartAddOptOrgPrice;

			$(this).find("tr:eq(0) > td:eq(2) > strong").text(intCartPrice);
			$(this).find("tr:eq(0) > td:eq(2) > strong").formatCurrency({symbol: ''<?=($S_SITE_CUR=='KRW' || $S_SITE_CUR=='JPY' || $S_SITE_CUR=='RUB')?",roundToDecimalPlace:0":"";?>});

			$(this).find("tr:eq(0) > td:eq(2) > span").text(intCartOrgPrice);
			$(this).find("tr:eq(0) > td:eq(2) > span").formatCurrency({symbol: ''<?=($S_SITE_CUR=='KRW' || $S_SITE_CUR=='JPY' || $S_SITE_CUR=='RUB')?",roundToDecimalPlace:0":"";?>});

		});
				
		var strSelectProdOptTotalPriceHtml	= "";
		$("#divSelectOptTotalPrice").html("");
		if (intCartOptPriceTotal > 0)
		{
			<?if($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){?>
			strSelectProdOptTotalPriceHtml += "<?=$LNG_TRANS_CHAR['PW00042'];?>:<strong class=\"totalPriceTxt\"><?=getCurMark('USD')?></strong>  <strong id=\"cartOptTotalPrice\" class=\"totalPrice\">"+intCartOptPriceTotal+"</strong><strong class=\"totalPriceTxt\"><?=getCurMark2('USD')?></strong>";
			strSelectProdOptTotalPriceHtml += "<span class=\"totalPriceBold\">(<?=$S_SITE_CUR_MARK1?><span id=\"cartOptOrgTotalPrice\">"+intCartOptOrgPriceTotal+"</span>)</span>";
			<?}else{?>
			strSelectProdOptTotalPriceHtml += "<?=$LNG_TRANS_CHAR['PW00042'];?>:<strong class=\"totalPriceTxt\"><?=getCurMark()?></strong>  <strong id=\"cartOptTotalPrice\" class=\"totalPrice\">"+intCartOptPriceTotal+"</strong><strong class=\"totalPriceTxt\"><?=getCurMark2()?></strong>";
			<?}?>
			
			$("#divSelectOptTotalPrice").html(strSelectProdOptTotalPriceHtml);
			$("#cartOptTotalPrice").formatCurrency({symbol: ''<?=($S_SITE_CUR=='KRW' || $S_SITE_CUR=='JPY' || $S_SITE_CUR=='RUB')?",roundToDecimalPlace:0":"";?>});
			$("#cartOptOrgTotalPrice").formatCurrency({symbol: ''<?=($S_SITE_CUR=='KRW' || $S_SITE_CUR=='JPY' || $S_SITE_CUR=='RUB')?",roundToDecimalPlace:0":"";?>});

		} else {
			$('select[id^="cartOpt"]').val("");
			$('select[id^="cartAddOpt"]').val("");
		}
	}

	function goSelectProdAddOpt(selObj,no){
		
		if (strProdAddOptYN == "Y")
		{			
			/* 옵션 필수사항 체크 */
			var intProdOptEssCnt = 0;
			var intProdOptErrCnt = 0; 
			if (!C_isNull(aryProdOptList) && aryProdOptList.length > 0)
			{							
				for(var i=0;i<aryProdOptList.length;i++){
				
					var intPO_NO = aryProdOptList[i];
					var strProdOptEssYN = aryProdOpt[intPO_NO].PO_ESS;
					
					if (strProdOptEssYN == "Y"){
						intProdOptEssCnt++;
					}

					$('div[id^="divCartOptAttr_"]').each(function(j){
						intProdOptErrCnt = 0;
						$(this).find('input[name="cartOptNo[]"]').each(function(k){
							if ($(this).val() > 0)
							{
								intProdOptErrCnt++;
							};
						});
					});
				}
				
				if (intProdOptEssCnt != intProdOptErrCnt)
				{
					if (!C_isNull(aryProdAddOptList) && aryProdAddOptList.length > 0)
					{
						$("#cartAddOpt_"+no).val("");
					}
					alert("<?=$LNG_TRANS_CHAR['PS00009']?>"); //추가옵션을 하나 이상 선택해주세요.
					return;
				}
			}
			/* 옵션 필수사항 체크 */
			
			if (!C_isNull(aryProdAddOptList) && aryProdAddOptList.length > 0)
			{
				var intProdAddOptEssCnt = 0;
				for(var i=0;i<aryProdAddOptList.length;i++){
					
					var intPO_NO = aryProdAddOptList[i];
					var strProdAddOptEssYN = aryProdAddOpt[intPO_NO].PO_ESS;
					
					//if (strProdAddOptEssYN == "Y")
					//{
						if ($("#cartAddOpt_"+intPO_NO+" option:selected").val() && intPO_NO == no)
						{	
							var intPAO_NO	= $("#cartAddOpt_"+intPO_NO+" option:selected").val();
							var strPAO_TEXT = $("#cartAddOpt_"+intPO_NO+" option:selected").text();	
							
							
							if ($('div[id^="divCartOptAttr_"]').length == 0)
							{
								goSelectProdOptHtml(0,"구매수량","<?if ($prodRow[P_EVENT] > 0 && getProdEventInfo($prodRow) == 'Y'){?><?=getCurToPrice($prodRow[P_SALE_PRICE])?><?}else{?><?=getProdDiscountPrice($prodRow)?><?}?>");
							}
							
							if (!strCartDivId)
							{
								strCartDivId = $('div[id^="divCartOptAttr_"]').filter(":last").attr("id");
							}
							
							$('div[id^="divCartOptAttr_"]').each(function(i){
								
								var aryCartOptNo = $(this).attr("id").split("_");
								var intCartOptNo= aryCartOptNo[1];
								var intCartAddOptIsCnt = 0;
								
								$(this).find("input[name^='"+intCartOptNo+"cartAddOptNo_no_"+intPO_NO+"[]']").each(function(n){
									
									if ($(this).val() == intPAO_NO)
									{
										intCartAddOptIsCnt++;
									}
								});
								
								if (strCartDivId == $(this).attr("id") && intCartAddOptIsCnt == 0)
								{
									var strUpCountImg		= "<img src=\"../himg/product/A0001/btn_prod_cnt_up.gif\"/>";
									var strDownCountImg		= "<img src=\"../himg/product/A0001/btn_prod_cnt_down.gif\"/>";
									var strProdCartDelImg	= "<img src=\"../himg/product/A0001/btn_opt_del.gif\"/>";

									if ("<?=$strDevice?>" == "m")
									{
										strUpCountImg		= "<span>▲</span>";
										strDownCountImg		= "<span>▼</span>";
										strProdCartDelImg	= "[x]";
									}

									var strSelectProdOptHtml = "";		
									strSelectProdOptHtml += "<tr>";

									strSelectProdOptHtml += "<input type=\"hidden\" name=\""+intCartOptNo+"cartAddOptNo_no_"+intPO_NO+"[]\"  id=\""+intCartOptNo+"cartAddOptNo_no_"+intPO_NO+"[]\" value=\""+intPAO_NO+"\">";
									
									<?if($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){?>
									strSelectProdOptHtml += "<input type=\"hidden\" name=\""+intCartOptNo+"cartAddOptNo_price_"+intPO_NO+"[]\" id=\""+intCartOptNo+"cartAddOptNo_price_"+intPO_NO+"[]\" value=\""+aryProdAddOptAttr[intPAO_NO].PAO_PRICE_USD+"\">";

									strSelectProdOptHtml += "<input type=\"hidden\" name=\""+intCartOptNo+"cartAddOptNoOrg_price_"+intPO_NO+"[]\" id=\""+intCartOptNo+"cartAddOptNoOrg_price_"+intPO_NO+"[]\" value=\""+aryProdAddOptAttr[intPAO_NO].PAO_PRICE+"\">";
									<?}else{?>
									strSelectProdOptHtml += "<input type=\"hidden\" name=\""+intCartOptNo+"cartAddOptNo_price_"+intPO_NO+"[]\" id=\""+intCartOptNo+"cartAddOptNo_price_"+intPO_NO+"[]\" value=\""+aryProdAddOptAttr[intPAO_NO].PAO_PRICE+"\">";

									strSelectProdOptHtml += "<input type=\"hidden\" name=\""+intCartOptNo+"cartAddOptNoOrg_price_"+intPO_NO+"[]\" id=\""+intCartOptNo+"cartAddOptNoOrg_price_"+intPO_NO+"[]\" value=\"0\">";
									<?}?>

									strSelectProdOptHtml += "    <td class=\"optTit\">"+strPAO_TEXT+"</td>";
									strSelectProdOptHtml += "    <td class=\"optCnt\">";
									
									strSelectProdOptHtml += "        <ul class=\"cntInputWrap\">";
									strSelectProdOptHtml += "            <li>";
									strSelectProdOptHtml += "                <input type=\"input\" id=\""+intCartOptNo+"cartAddOptNo_qty_"+intPO_NO+"[]\" name=\""+intCartOptNo+"cartAddOptNo_qty_"+intPO_NO+"[]\" value=\"<?=$prodRow[P_MIN_QTY]?>\" class=\"cntInputForm _w30\"/> ";
									strSelectProdOptHtml += "            </li>";
									strSelectProdOptHtml += "            <li class=\"btnCntUpDown\">";
									strSelectProdOptHtml += "                <a href=\"javascript:goProdViewQtyChange("+intPO_NO+",'add_up',1,"+intCartOptNo+","+intPAO_NO+");\">"+strUpCountImg+"</a>";
									strSelectProdOptHtml += "                <a href=\"javascript:goProdViewQtyChange("+intPO_NO+",'add_down',1,"+intCartOptNo+","+intPAO_NO+");\">"+strDownCountImg+"</a>";
									strSelectProdOptHtml += "            </li>";
									strSelectProdOptHtml += "        </ul>";
									
									strSelectProdOptHtml += "    </td>";
									
									strSelectProdOptHtml += "    <td class=\"mngProd\"><a id=\"btnProdCartOptDel\">"+strProdCartDelImg+"</a></td>";
									strSelectProdOptHtml += "</tr>";
									
									$(this).find("table:eq(0)").append(strSelectProdOptHtml);
								
									$("input[id^='"+intCartOptNo+"cartAddOptNo_price_"+intPO_NO+"']").formatCurrency({symbol: ''<?=($S_SITE_CUR=='KRW' || $S_SITE_CUR=='JPY' || $S_SITE_CUR=='RUB')?",roundToDecimalPlace:0":"";?>});
								
									$(this).find("input[id='"+intCartOptNo+"cartAddOptNo_qty_"+intPO_NO+"[]']").live("blur",function(){
										goProdViewQtyChange(intPO_NO,"add",1,intCartOptNo,intPAO_NO);
									});

									/* rowspan */
									if($(this).find("tr:eq(0) > td:eq(2)").attr("rowspan")){
										$(this).find("tr:eq(0) > td:eq(2)").attr("rowspan","");
									}
									
									if ($(this).find("tr").length > 1)
									{
										$(this).find("tr:eq(0) > td:eq(2)").attr("rowspan",$(this).find("tr").length );
									}
									/* rowspan */
								}
							});
							
							goSelectProdOptTotalHtml();
						}	
					//}
				}
			}
		}
	}
	
	/* 상품 옵션 클릭시 담기(2013.05.24) */

	/* 상품 상세 보기에서 up,down */
	function goProdViewQtyChange(optNo,type,prodMinQty,cartNo,cartAddOptNo)
	{
		if (C_isNull(cartNo)) cartNo = 0;
		if (C_isNull(cartAddOptNo)) cartAddOptNo = 0;
		
		if (type == "add_up" || type == "add_down" || type == "add")
		{
			var intAddOptPos = 0;
			$("#divCartOptAttr_"+cartNo).find('input[name^="'+cartNo+'cartAddOptNo_no_"]').each(function(k){
				
				if ($(this).val() == cartAddOptNo)
				{
					intAddOptPos = k;
				}
				/*if ($(this).attr("id") == cartNo+"cartAddOptNo_no_"+optNo+"[]")
				{
					intAddOptPos = k;
				}*/
			});
			
			intProdQty = parseInt($("#divCartOptAttr_"+cartNo).find("input[name^='"+cartNo+"cartAddOptNo_qty_']").eq(intAddOptPos).val());
			//var intProdQty = parseInt($("#divCartOptAttr_"+cartNo).find("input[name='"+cartNo+"cartAddOptNo_qty_"+optNo+"[]'").val());
		} else {
			var intProdQty = parseInt($("#"+optNo+"_cartQty").val());
		}
		
		if ((optNo > 0 || !C_isNull(type)) && (type != "add"))
		{
			if (type == "up" || type == "add_up")
			{
				intProdQty++;
			} else if (type != ""){
				intProdQty--;
			}
		}

		if (intProdQty < prodMinQty)
		{
			intProdQty = prodMinQty;
		}

		if (type != "add_up" && type != "add_down" && type != "add") {
			$("#"+optNo+"_cartQty").val(intProdQty);
			var intCartOptPrice = intProdQty * parseFloat(C_removeComma($("#"+optNo+"_cartOptPrice").val(),true));
			$("#"+optNo+"_cartOptPriceMark").text(intCartOptPrice);
			$("#"+optNo+"_cartOptPriceMark").formatCurrency({symbol: ''<?=($S_SITE_CUR=='KRW' || $S_SITE_CUR=='JPY')?",roundToDecimalPlace:0":"";?>});
			$("#"+optNo+"_cartOptPrice").formatCurrency({symbol: ''<?=($S_SITE_CUR=='KRW' || $S_SITE_CUR=='JPY')?",roundToDecimalPlace:0":"";?>});		
		} else {
			
			$("#divCartOptAttr_"+cartNo).find("input[name^='"+cartNo+"cartAddOptNo_qty_']").eq(intAddOptPos).val(intProdQty);

			//$("#"+cartNo+"cartAddOptNo_qty_"+optNo).val(intProdQty);
		
		}
		
		goSelectProdOptTotalHtml();
	}


	function goAjaxRet(name,result) {
		
		var doc = document.form;
		var data = eval(result);

		if (name == "cartOrder")
		{
			if (data[0].RET == "Y")
			{
				$("#divSelectOpt").append(data[0].HTML);
				
				<?if ($g_member_no){?>
				doc.menuType.value = "order";
				doc.mode.value = "order";
				doc.submit();
				<?}else{?>
				doc.menuType.value = "member";
				doc.mode.value = "login";
				doc.submit();
				<?}?>
			} else {
				alert(data[0].MSG);
				return;
			}
		}
		else if (name == "cartWish")
		{
			if (data[0].RET == "Y")
			{
				var x = confirm("<?=$LNG_TRANS_CHAR['PS00016']?>"); //담아두기 페이지로 이동하시겠습니까?
				if (x == true)
				{
					doc.menuType.value = "order";
					doc.mode.value = "cart";
					doc.submit();
				}
			} else {
				alert(data[0].MSG);
				return;
			}

		}
		else if (name == "cart")
		{
			if (data[0].RET == "Y")
			{
				if ("<?=$S_FIX_PRODUCT_CART_POP_USE?>" == "Y")
				{
					
					$("#divCartPopup").html(data[0].POP_HTML);
					$("#divCartPopup").css("display","");
					
					if ("<?=$S_FIX_ORDER_TOTAL_DISCOUNT_USE?>" == "Y"){
						$("#divOrderTotalDiscountWrap").css("display","");
						$("#divOrderTotalDiscount").html(data[0].ORDER_TOTAL_DISCOUNT_HTML);
					}
					
					$("#divCartPopup").trigger('mouseleave');
					
				} else {
				
					var x = confirm("<?=$LNG_TRANS_CHAR['OS00013']?>"); //장바구니 페이지로 이동하시겠습니까?
					if (x == true)
					{
						doc.menuType.value = "order";
						doc.mode.value = "cart";
						doc.submit();
					}
				}
			} else {
				alert(data[0].MSG);
				return;
			}
		}
		else if (name == "popCartDel")
		{
			/* 팝업 장바구니에서 상품 삭제 */
			$("#divCartPopup").html(data[0].POP_HTML);
			$("#divCartPopup").css("display","");
		}

		else if (name == "prodLikeUpdate")
		{
			/* 좋아요 상품 */
			if (data[0].RET == "Y"){
				var prodLikeObj = $("#span_"+data[0].P_CODE);
				prodLikeObj.removeClass("ico_like");
				prodLikeObj.removeClass("ico_likeH");
				if (data[0].LIKE_TYPE == "Y") {
					prodLikeObj.addClass("ico_likeH");
				} else {
					prodLikeObj.addClass("ico_like");
				}
				return;
			} else {

				if (data[0].MSG == 'NO_MEMBER_LOGIN')
				{
					alert("<?=$LNG_TRANS_CHAR['OS00014']?>");
					return;
				}

				if (data[0].MSG == 'QUERY_ERROR')
				{
					alert("<?=$LNG_TRANS_CHAR['MS00029']?>");
					return;
				}
			}
		}
	}
	/* ----------------- 2013.05.24 ------------------------ */

	/* 작은 이미지 클릭시, 큰이미지로 변경 */
	/* 달링카 상품 메인 페이지 */
	function goChagneImage(url) {
		$("#mainImage").attr("src", url);
	}

	/* 문자상담하기 버튼 클릭시 문자 전송*/
	function goSendSMS() {
		var hp = document.form.hp1.value + "-"  + document.form.hp2.value + "-" + document.form.hp3.value;
		var strJsonParam = "menuType=<?=$strMenuType?>&mode=json&act=sendSMS&hp=" + hp;
		
		$.ajax({				
			type:"POST",
			url:"./index.php",
			data :strJsonParam,
			dataType:"json", 
			success:function(data){	
				alert(data[0].RET);
			}
		});
	}






	/* 2012.08.04 -- KIM HEE-SUNG -- REVIEW Function */



	function goScriptClick(pCode, bCode, page, bNo, act)
	{
		mode = "";
		switch (bCode) {
		case "<?=$D_PRODUCT_BCODE_01?>":
			mode = "prodReview";
		break;
		case "<?=$D_PRODUCT_BCODE_02?>":
			mode = "prodQA";
		break;		
		}

		switch (act) {
		case "write":
			url = "./?menuType=board&mode="+mode+"&act=write&pCode="+pCode+"&bCode="+bCode+"&page="+page;
			C_openWindow(url, "글쓰기", 700, 550);
		break;
		case "modify":
			url = "./?menuType=etc&mode="+mode+"&act=modify&bNo="+bNo+"&bCode="+bCode+"&pCode="+pCode+"&page="+page;
			C_openWindow(url, "글쓰기", 700, 550);
		break;
		case "delete":
			url = "./?menuType=board&mode=json&act=divDelete&bNo="+bNo+"&bCode="+bCode+"&pCode="+pCode+"&page="+page;
			goDel(pCode, bCode, page, bNo, url);
		break;
		case "load":
			url = "./?menuType=board&mode=json&act=divModify&pCode="+pCode+"&bCode="+bCode+"&page="+page+"&bNo="+bNo;
			goLoad(bCode, url);
		break;
		case "read":
			$("tr[id^=trReviewContent]").css("display","none");
			$("tr[id^=trReviewButton]").css("display","none");
			$("#trReviewContent_"+bNo).css("display","block");
			$("#trReviewButton_"+bNo).css("display","block");
		break;
		}
	}

	/* REVIEW Data Delete */
	function goDel(pCode, bCode, page, bNo, url)
	{
		var x = confirm("선택한  이용 후기를 삭제하시겠습니까?");
		if (x == true)
		{
			if (window.XMLHttpRequest)
			{
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			}
			else
			{
				// code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}

			xmlhttp.onreadystatechange=function()
			{
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					//$("#"+"REVIEW").html(xmlhttp.responseText);
					if(xmlhttp.responseText)
					{
						alert(xmlhttp.responseText);
						return;
					}

					goScriptClick(pCode, bCode, page, bNo, "load")
				}
			}

			xmlhttp.open("GET",url,true);
			xmlhttp.send();
		}
	}

	/* REVIEW ReLoad Data */
	function goLoad(divID, url)
	{
		if (window.XMLHttpRequest)
		{
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp = new XMLHttpRequest();
		}
		else
		{
			// code for IE6, IE5
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}

		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				$("#"+divID).html(xmlhttp.responseText);
			}
		}

		//alert(linkPage);
		xmlhttp.open("GET", url, true);
		xmlhttp.send();	
	}

	function goMsg()
	{
		alert("비밀글은 작성자만 조회할 수 있습니다.");
	}

	/* 2012.08.04 -- KIM HEE-SUNG -- REVIEW Function */


	/* 2012.10.20 -- KIM HEE-SUNG -- BBS Function ( NEW ) */
	function goTR_Delete(bCode) {
		modal_window();
	}


	/* 상품 색상/컬러 검색 */
	function goProdSorting(gb,val){
		var intCount		= 0;
		var strVal			= ""; 
		var strObjNm		= "";
		var strObjALinkNm	= "";
		var aryObjList		= "";
		var strSelectedVal  = "";
		
		if (gb == "color")
		{
			strObjNm = "searchColor";
			intCount = "<?=sizeof($S_ARY_PROD_COLOR)?>";
			strObjALinkNm = "aLinkProdSearchColor";
		}

		if (gb == "size")
		{
			strObjNm = "searchSize";
			intCount = "<?=sizeof($S_ARY_PROD_SIZE)?>";
			strObjALinkNm = "aLinkProdSearchSize";
		}
		
		aryObjList = $("#"+strObjNm).val().split("|");
		for(var i=0; i<intCount; i++){

			if (i == val)
			{
				strVal += ($("#"+strObjALinkNm+i).attr("class") == "selected") ? "N|":"Y|";
			} else{
				strVal += ($("#"+strObjALinkNm+i).attr("class") == "selected") ? "Y|":"N|";
			}
		}
		$("#"+strObjNm).val(strVal);

		var doc = document.form;
		doc.method = "get";
		doc.action = "<?=$PHP_SELF?>";
		doc.submit();
	}
	
	/* 상품상세보기에서 장바구니 담기 클릭시 팝업창에서 주문하기/삭제하기/닫기 */
	function goPopCartJumun()
	{
		var intCheckCnt	= 0;
		var data		= new Array($("input[id^=popCartNo]").length * 5);
		
		$("input[id^=popCartNo]").each(function(i){
			if ($(this).is(":checked")) {
				data["cartNo["+i+"]"] = $(this).val();
				intCheckCnt++;
			}
		});
		
		if (intCheckCnt == 0)
		{
			alert("<?=$LNG_TRANS_CHAR['OS00019']?>"); //주문하실 상품을 선택해주세요.
			return;
		}

		data['menuType']	= "order";
		data['mode']		= "act";
		data['act']			= "order1";
		if (C_isNull(intMemberNo))
		{
			data['menuType']	= "member";
			data['mode']		= "login";
			data['act']			= "";
		}
			
		C_getSelfAction(data);
	}

	function goPopCartDel(no)
	{
		var intCheckCnt	= 0;
		var data		= new Array($("input[id^=popCartNo]").length * 5);
		
		if (!C_isNull(no))
		{
			data["cartNo[0]"]	= no;
			intCheckCnt			= 1;

		} else {
			$("input[id^=popCartNo]").each(function(i){
				if ($(this).is(":checked")) {
					data["cartNo["+i+"]"] = $(this).val();
					intCheckCnt++;
				}
			});
		}
		
		if (intCheckCnt == 0)
		{
			alert("<?=$LNG_TRANS_CHAR['OS00018']?>"); //삭제하실 상품을 선택해주세요.
			return;
		}

		var x = confirm("<?=$LNG_TRANS_CHAR['OS00017']?>"); //선택한 상품을 삭제하시겠습니까?
		if (x == true)
		{
			data['menuType']	= "product";
			data['mode']		= "json";
			data['act']			= "cartDel";	
			C_getJsonAjaxAction("popCartDel","./index.php",data);
		}
	}

	function goPopCartClose()
	{
		$("#divCartPopup").trigger('mouseenter');
		$("#divCartPopup").css("display","none");
	}
	
	/* 상품 좋아요 */
	function goProdLikeUpdate(prodCode){
		if (C_isNull(intMemberNo))
		{
			alert("<?=$LNG_TRANS_CHAR['OS00014']?>");
			return;
		}

		var data			= new Array();
		
		data['prodCode']	= prodCode
		data['menuType']	= "product";
		data['mode']		= "json";
		data['act']			= "prodLikeUpdate";	

		//C_getSelfAction(data);
		C_getJsonAjaxAction("prodLikeUpdate","./index.php",data);
	}
	
	/* 대량구매버튼 링크 */
	function goCartBluk(prodCode)
	{
		window.open('?menuType=etc&mode=popProdLargeBuy&prodCode='+prodCode,'new','width=650px,height=450px,top=300px,left=400px,menubar=no,location=no,scrollbars=yes,status=no,resizable=no');

	}

		
	/* 수량 update */
	function goPopCartQtyUpMinus(gb1,gb2,no)
	{
		var inputObj = gb1+"Qty"+no;
		var intQty = parseInt($("#"+inputObj).val());
		intQty = intQty + (1 * gb2);
		
		if (intQty <= 0)
		{
			alert("<?=$LNG_TRANS_CHAR['OS00005']?>"); //수량은 '0'보다 커야 합니다.
			return;
		}

		$("#"+inputObj).val(intQty);
		var strJsonParam = "cartQty&cartNo="+no+"&qty="+intQty+"&type=popCart";	
		
		$.getJSON("./?menuType=order&mode=json&act="+strJsonParam,function(data){	
			
			if(data[0].RET == "N") { 
				alert(data[0].MSG);
				return;
			}

			if ("<?=$S_FIX_PRODUCT_CART_POP_USE?>" == "Y")
			{
				$("#divCartPopup").html(data[0].POP_HTML);
				$("#divCartPopup").css("display","");
				
				if ("<?=$S_FIX_ORDER_TOTAL_DISCOUNT_USE?>" == "Y"){
					$("#divOrderTotalDiscount").html(data[0].ORDER_TOTAL_DISCOUNT_HTML);
				}
			}
		})
	}
//-->
</script>
