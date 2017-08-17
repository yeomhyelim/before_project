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

	$productMgr->setP_LNG($S_SITE_LNG);
	$cateMgr->setCL_LNG($S_SITE_LNG);

	
	switch ($strMode)
	{
		case "list":
		case "search":

			$productMgr->setSearchHCode1($strSearchHCode1);
			$productMgr->setSearchHCode2($strSearchHCode2);
			$productMgr->setSearchHCode3($strSearchHCode3);
			$productMgr->setSearchHCode4($strSearchHCode4);
			$productMgr->setSearchProdShare($strSearchProdShare);

			$productMgr->setSearchField($strSearchField);
			$productMgr->setSearchKey($strSearchKey);
			$productMgr->setSearchWebView("Y");
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
			$linkPage .= "&searchStartPrice=$strSearchStartPrice&searchEndPrice=$strSearchEndPrice&page=";
			
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
			$prodRow = $productMgr->getProdView($db);

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
			$intProdPoint = getProdPoint($prodRow[P_SALE_PRICE], $prodRow[P_POINT], $prodRow[P_POINT_TYPE], $prodRow[P_POINT_OFF1], $prodRow[P_POINT_OFF2]);
			
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
			$siteMgr->setS_COL("S_PROD_DELIVERY");
			$strProdDeliveryText = $siteMgr->getOneColText($db);

			$siteMgr->setS_COL("S_PROD_RETURN");
			$strProdReturnText = $siteMgr->getOneColText($db);

			/* 공유카테고리 */
			$productMgr->setP_CATE($prodRow[P_CATE]);
			$aryProdShareCateInfo = $productMgr->getProdShareCateInfo($db);

		break;
	}


?>
<script type="text/javascript">
<!--
	var intMemberNo			= "<?=$g_member_no?>";
	
	var aryProdOpt			= ""; //json
	var aryProdOptName		= new Array(11);
	var aryProdOptAttr2		= ""; //json
	var aryProdOptAttr		= ""; //json
	var aryProdAddOpt		= "";
	var aryProdAddOptAttr	= "";
	var strProdOptType		= ""; //상품옵션종류
	var strProdCode			= "";
	var aryProdOptList		= ""; //js
	var aryProdAddOptList	= ""; 
	var strProdAddOptYN		= "N";
	var strProdStockLimit   = "N"; //재고관리함(무제한체크암됨)
	
	var intProdQty		= 0;

	<?if ($strMode == "view"){?>
		strProdOptType		= "<?=$prodRow[P_OPT]?>";	//상품옵션종류
		strProdCode			= "<?=$strP_CODE?>";		//상품코드
		intProdQty			= "<?=$prodRow[P_QTY]?>";	//상품재고
		strProdStockLimit   = "<?=$prodRow[P_STOCK_LIMIT]?>";
	<?}?>

	$(document).ready(function(){
		
		
		<?if ($strMode == "view"){?>
			
			strProdAddOptYN = "<?=$prodRow[P_ADD_OPT]?>"; //추가옵션사용유무

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
		<?}?>
	});

	function goSearchSort(gb)
	{
		var doc = document.form;

		doc.sort.value = gb;
		doc.method = "get";
		doc.action = "<?=$PHP_SELF?>";
		doc.submit();
	}

	/* 소스 정리중 ... */
	function goProdView(no)
	{
		var doc 				= document.form;

		doc.prodCode.value 	= no;
		doc.mode.value 		= "view";
		doc.method 			= "get";
		doc.action 				= "<?=$PHP_SELF?>";
		doc.submit();
	}
	/* 소스 정리중 ... */	

	/* 필수사항 체크 */
	function goNecsssaryCheck()
	{		
		/* 필수사항 체크 여부 */
		if (!C_isNull(aryProdOptList) && aryProdOptList.length > 0)
		{
			for(var i=0;i<aryProdOptList.length;i++){
				
				var intPO_NO = aryProdOptList[i];
				var strProdOptEssYN = aryProdOpt[intPO_NO].PO_ESS;
				
				aryProdOptName[1]	= aryProdOpt[intPO_NO].PO_NAME1;
				aryProdOptName[2]	= aryProdOpt[intPO_NO].PO_NAME2;
				aryProdOptName[3]	= aryProdOpt[intPO_NO].PO_NAME3;
				aryProdOptName[4]	= aryProdOpt[intPO_NO].PO_NAME4;
				aryProdOptName[5]	= aryProdOpt[intPO_NO].PO_NAME5;
				aryProdOptName[6]	= aryProdOpt[intPO_NO].PO_NAME6;
				aryProdOptName[7]	= aryProdOpt[intPO_NO].PO_NAME7;
				aryProdOptName[8]	= aryProdOpt[intPO_NO].PO_NAME8;
				aryProdOptName[9]	= aryProdOpt[intPO_NO].PO_NAME9;
				aryProdOptName[10]	= aryProdOpt[intPO_NO].PO_NAME10;

				if (strProdOptEssYN == "Y"){
					
					for(var i=1;i<=10;i++){
						if (aryProdOptName[i])
						{
							if (!$("#cartOpt"+i+"_"+intPO_NO+" option:selected").val())
							{
								alert("<?=$LNG_TRANS_CHAR['PS00009']?>"); //추가옵션을 하나 이상 선택해주세요.
								return false;
							}
							
							/* 다중가격일체형일때 한번만 체크 */
							if (strProdOptType == "2" && i == 1)
							{
								break;
							}
						}
					}
				}
			}
		}
		
		/* 추가옵션 필수사항 체크  여부*/
		if (strProdAddOptYN == "Y")
		{
			if (!C_isNull(aryProdAddOptList) && aryProdAddOptList.length > 0)
			{
				for(var i=0;i<aryProdAddOptList.length;i++){
					
					var intPO_NO = aryProdAddOptList[i];
					var strProdAddOptEssYN = aryProdAddOpt[intPO_NO].PO_ESS;
					
					if (strProdAddOptEssYN == "Y")
					{
						if (!$("#cartAddOpt_"+intPO_NO+" option:selected").val())
						{
							alert("<?=$LNG_TRANS_CHAR['PS00009']?>"); //추가옵션을 하나 이상 선택해주세요.
							return false;
						}	
					}
				}
			}
		}
		
		/*품절여부확인*/
		if ("<?=$prodRow[P_STOCK_OUT]?>" == "Y")
		{
			alert("<?=$LNG_TRANS_CHAR['OS00028']?>"); //선택한 상품은 이미 품절된 상품입니다.
			return false;
		}
						
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

		return true;
	}

	/* 장바구니 담기 */
	function goCart()
	{
		
		/* 필수사항 체크 여부 */
		if (!goNecsssaryCheck()) return;
		
		var doc = document.form;		
		doc.mode.value = "act";
		doc.act.value = "cart";		
		doc.submit();
	}
	
	/* 바로 주문하기 */
	function goCartOrder()
	{
		/* 필수사항 체크 여부 */
		if (!goNecsssaryCheck()) return;

		var doc = document.form;		
		doc.mode.value = "act";
		doc.act.value = "cartOrder";
		doc.submit();
	}

	/* wish */
	function goWish()
	{
		if (C_isNull(intMemberNo))
		{
			alert("<?=$LNG_TRANS_CHAR['OS00014']?>"); //로그인을 하신 후 이용하세요.
			return;
		}
		
		/* 필수사항 체크 여부 */
		if (!goNecsssaryCheck()) return;
		
		var doc = document.form;		
		doc.mode.value = "act";
		doc.act.value = "cartWish";
		doc.submit();
	}
	
	/* 상품 리스트 이동*/
	function goProdList()
	{
		var doc = document.form;		
		doc.mode.value = "list";
		doc.submit();
	}

	/* 옵션 선택 */
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
		
		if (C_isNull($("#"+selObj).val()))
		{
			$("#realPayPriceText").html(C_toNumberFormatString('<?=$prodRow[P_SALE_PRICE]?>',false)+"원");
			return;
		}
		
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
		strJsonParam += "&optAttr1="+encodeURI(aryProdOptAttrVal[1]);
		strJsonParam += "&optAttr2="+encodeURI(aryProdOptAttrVal[2]);
		strJsonParam += "&optAttr3="+encodeURI(aryProdOptAttrVal[3]);
		strJsonParam += "&optAttr4="+encodeURI(aryProdOptAttrVal[4]);
		strJsonParam += "&optAttr5="+encodeURI(aryProdOptAttrVal[5]);
		strJsonParam += "&optAttr6="+encodeURI(aryProdOptAttrVal[6]);
		strJsonParam += "&optAttr7="+encodeURI(aryProdOptAttrVal[7]);
		strJsonParam += "&optAttr8="+encodeURI(aryProdOptAttrVal[8]);
		strJsonParam += "&optAttr9="+encodeURI(aryProdOptAttrVal[9]);
		strJsonParam += "&optAttr10="+encodeURI(aryProdOptAttrVal[10]);
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

							if (strProdOptType != "1"){
								$("#realPayPriceText").html(C_toNumberFormatString(data[0].POA_SALE_PRICE,2)+"");
								<?if ($prodRow[P_EVENT_UNIT] && $prodRow[P_EVENT]){?>
								$("#realPayPriceTaxText").html(C_toNumberFormatString(data[0].POA_SALE_PRICE_TAX,2));
								<?}?>
							}
						})
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

			$("#realPayPriceText").html("<?=getCurMark()?> "+C_toNumberFormatString(aryProdOptAttr[intProdOptAttrNo].POA_SALE_PRICE,2)+"");
			<?if ($prodRow[P_EVENT_UNIT] && $prodRow[P_EVENT]){?>
			$("#realPayPriceTaxText").html(C_toNumberFormatString(aryProdOptAttr[intProdOptAttrNo].POA_SALE_PRICE_TAX,2)+"");
			<?}?>
			
		}

	}

	/* 상품 상세 보기에서 up,down */
	function goProdViewQtyChange(type,prodMinQty)
	{
		var intProdQty = parseInt($("#cartQty").val());
		if (type == "up" )
		{
			intProdQty++;
		} else {
			intProdQty--;
		}

		if (intProdQty < prodMinQty)
		{
			intProdQty = prodMinQty;
		}
		$("#cartQty").val(intProdQty);
	}

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

	function goAjaxRet(name,result) {
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

//-->
</script>
