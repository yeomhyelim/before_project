<?
	require_once MALL_CONF_LIB."ProductMgr.php";

	require_once MALL_CONF_LIB."PopupMgr.php";

	require_once MALL_PROD_FUNC;

	require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/conf/product.inc.php";
	$productMgr = new ProductMgr();
	$popupMgr = new PopupMgr();

	if(is_file("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/shop.manual.inc.php")):
		require_once "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/shop.manual.inc.php";
	endif;

	$strSearchField			= $_POST["searchField"]			? $_POST["searchField"]			: $_REQUEST["searchField"];
	$strSearchKey			= $_POST["searchKey"]			? $_POST["searchKey"]			: $_REQUEST["searchKey"];
	$intPage				= $_POST["page"]				? $_POST["page"]				: $_REQUEST["page"];
	$productMgr->setP_LNG($S_SITE_LNG);

	switch ($strMode)
	{
		case "list":
// 필요없는 부분 인듯 주석처리(속도테스트:2013.10.31)
//			$productMgr->setSearchHCode1("");
//			$productMgr->setSearchHCode2("");
//			$productMgr->setSearchHCode3("");
//			$productMgr->setSearchHCode4("");
//
//			$productMgr->setSearchField("");
//			$productMgr->setSearchKey("");
//			$productMgr->setSearchWebView("Y");
//			$productMgr->setSearchSort("");
//			$productMgr->setSearchIcon1("Y");
//			$productMgr->setSearchIcon2("");
//
//			$productMgr->setLimitFirst(0);
//			$productMgr->setPageLine($D_PRODUCT_MAIN_NEW_LW * $D_PRODUCT_MAIN_NEW_LH);
//			$intProdNewCnt = $productMgr->getProdTotal($db);
//			$retProdNew = $productMgr->getProdList($db);
//
//			$productMgr->setSearchIcon1("");
//			$productMgr->setSearchIcon2("Y");
//			$productMgr->setPageLine($D_PRODUCT_MAIN_BEST_LW * $D_PRODUCT_MAIN_BEST_LH);
//			$intProdHotCnt = $productMgr->getProdTotal($db);
//			$retProdHot = $productMgr->getProdList($db);

			$aryMainPopList = $popupMgr->getMainPopup($db);

		break;
	}
?>

<script type="text/javascript">
<!--
	$(document).ready(function(){
		<?
			if (is_array($aryMainPopList)):
				$cnt = sizeof($aryMainPopList);
				for ($i=0;$i<$cnt;$i++):
					$strTmpImg		= WEB_UPLOAD_PATH."/popup/".$aryMainPopList[$i][PO_FILE];
					$aryImgSize		= imgViewSize($strTmpImg,'',0);
					$intImgWidth	= $aryImgSize[width];
					$intImgHeight	= $aryImgSize[height] + 25;		?>

		if (C_GetCookie("pop_<?=$aryMainPopList[$i][PO_NO]?>") != "done") {
			var url		= "./?menuType=etc&mode=popInfo&no=<?=$aryMainPopList[$i][PO_NO]?>";
			var name	= "pop_<?=$aryMainPopList[$i][PO_NO]?>";
			var option	= "width=<?=$intImgWidth?>px,height=<?=$intImgHeight?>px,left=<?=$aryMainPopList[$i][PO_LEFT]?>,top=<?=$aryMainPopList[$i][PO_TOP]?>,scrollbars=auto,resizable=no";
			window.open(url, name, option);
		}

		<?		endfor;
			endif;
		?>


	});


	function goProdView(no)
	{
		<?php if($isPriceHide && !$S_PRICE_SHOW_VIEW):?>
		if(!strMemberLogin) {
			alert('<?php echo $LNG_TRANS_CHAR["MS00112"]; // 로그인이 필요합니다.?>');
			return;
		} else {
			alert('<?php echo $LNG_TRANS_CHAR["MS00130"]; // 권한이 없습니다.?>');
			return;
		}
		<?php endif;?>

			var url				= "./?menuType=product&mode=view&prodCode="+no;
			location.href		= url;

// 2013.11.05 kim hee sung form 사용 안하고 페이지 이동하기
//		var doc = document.form;
//
//		doc.prodCode.value = no;
//		doc.menuType.value = "product";
//		doc.mode.value = "view";
//		doc.method = "get";
//		doc.action = "<?=$PHP_SELF?>";
//		doc.submit();
	}



//-->
</script>
<?
//장바구니 기능
if ($S_PROD_ADD_CART_USE == "Y")
{

	## 다국어 언어별 문장 설정
	$aryAddCartLanguage				= "";
	$aryAddCartLanguage['OS00013']	= $LNG_TRANS_CHAR['OS00013'];
	$aryAddCartLanguage['PW00010']	= $LNG_TRANS_CHAR['PW00010'];
	$aryAddCartLanguage['PW00009']	= $LNG_TRANS_CHAR['PW00009'];
	$aryAddCartLanguage['OS00029']	= $LNG_TRANS_CHAR['OS00029'];

	$aryAddCartLanguage['CW00034']	= $LNG_TRANS_CHAR['CW00034'];
	$aryLanguage['CW00001']			= $LNG_TRANS_CHAR['CW00001'];

	## 화페단위표시
	$arrSiteCurUnitMark				= getCurUnitMark();
	$strSiteCurUintLeftMark			= $arrSiteCurUnitMark["L"];
	$strSiteCurUintRightMark		= $arrSiteCurUnitMark["R"];

?>
<script>
<?
	for($i=1;$i<=5;$i++){

		if (${"S_MAIN_BEST_LIST{$i}_DESIGN"}){

			$strAppID				= ${"S_MAIN_BEST_LIST{$i}_DESIGN"}."_{$i}";

?>
	G_APP_PARAM['<?php echo $strAppID;?>']							= new Object();
	G_APP_PARAM['<?php echo $strAppID;?>']['LANGUAGE']				= <?php echo json_encode($aryAddCartLanguage);?>;

	G_APP_PARAM['<?php echo $strAppID;?>']['PRODUCT_OPT']			=  new Object();
	G_APP_PARAM['<?php echo $strAppID;?>']['PRODUCT_OPT_ATTR']		=  new Object();
	G_APP_PARAM['<?php echo $strAppID;?>']['PRODUCT_ROW']			=  new Object();
	G_APP_PARAM['<?php echo $strAppID;?>']['SITE_CUR']				=  "<?php echo $S_SITE_CUR?>";
	G_APP_PARAM['<?php echo $strAppID;?>']['SITE_LNG_USD_YN']		=  "<?php echo $S_ARY_CUR[$S_SITE_LNG]['USD'][2]?>";
	G_APP_PARAM['<?php echo $strAppID;?>']['SITE_CUR_MARK1']		=  "<?php echo $strSiteCurUintLeftMark?>";
	G_APP_PARAM['<?php echo $strAppID;?>']['SITE_CUR_MARK2']		=  "<?php echo $strSiteCurUintRightMark?>";
	G_APP_PARAM['<?php echo $strAppID;?>']['PRODUCT_ADD_OPT']		=  new Object();
	G_APP_PARAM['<?php echo $strAppID;?>']['PRODUCT_ADD_OPT_ATTR']	=  new Object();

<?
		}
	}
?>
</script>
<script language="javascript" type="text/javascript" src="/common/js/product/product.addCart.js"></script>
<?}?>