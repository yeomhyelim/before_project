<?
	require_once MALL_CONF_LIB."ProductMgr.php";
	require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/conf/site_skin_product.conf.inc.php";

	$productMgr			= new ProductMgr();

	$strP_CODE			= $_POST["prodCode"]			? $_POST["prodCode"]			: $_REQUEST["prodCode"];
	$strP_NAME			= $_POST["p_name"]				? $_POST["p_name"]				: $_REQUEST["p_name"];

	/* 정의 */
	$strPCode			= $strP_CODE;
	$strZPosition		= $S_PRODUCT_IMG_ZOOM_POSITION;
	$strShowType		= $S_PRODUCT_VIEW_IMAGE_SHOW_TYPE;
	$intVPopSizeW		= $S_PRODUCT_VIEW_PISW;
	$intVPopSizeH		= $S_PRODUCT_VIEW_PISH;
	$intMSizeW 			= $S_PRODUCT_IMG_ZOOM_SIZE_W;
	$intMSizeH			= $S_PRODUCT_IMG_ZOOM_SIZE_H;
	$intMListW 			= $S_PRODUCT_IMG_ZOOM_VIEW_W;
	$intMListH			= $S_PRODUCT_IMG_ZOOM_VIEW_H;
	$strZoomPosition	= $S_PRODUCT_IMG_ZOOM_POSITION;

## 2013.04.05  링크 오류 수정
//	$intVSizeW			= $S_PRODUCT_VIEW_ISW;
//	$intVSizeH			= $S_PRODUCT_VIEW_ISH;
//	$intMSizeW 			= $S_PRODUCT_IMG_MULTY_SIZE_W;
//	$intMSizeH			= $S_PRODUCT_IMG_MULTY_SIZE_H;
//	$intMListW 			= $S_PRODUCT_IMG_MULTY_VIEW_W;
//	$intMListH			= $S_PRODUCT_IMG_MULTY_VIEW_H;

	/* 상품 호출 개수 */
	$intPageLine 		= $intMSizeW * $intMSizeH;

// 2013.07.10 kim hee sung 모바일 이미지가 있는경우 버그 있음
//	$productMgr->setP_CODE($strPCode);
//	$productMgr->setPM_TYPE("view");
//	$productMgr->setPageLine($intPageLine);
//	$intMTotal	 		= $productMgr->getProdImg($db, "OP_COUNT");	
//	$aryMResult 		= $productMgr->getProdImg($db, "OP_LIST");
//	$productMgr->setPM_TYPE("large");
//	$aryZResult			= $productMgr->getProdImg($db, "OP_ARYLIST");

	$param					= "";
	$param['P_CODE']		= $strPCode;
	$param['PM_TYPE_IN']	= "view";
	$intMTotal	 			= $productMgr->getProdImgListEx($db, "OP_COUNT", $param);	
	
	$param					= "";
	$param['P_CODE']		= $strPCode;
	$param['PM_TYPE_IN']	= "view";
	$param['LIMIT']			= "0, {$intPageLine}";
	$aryMResult 			= $productMgr->getProdImgListEx($db, "OP_LIST", $param);	

	$param					= "";
	$param['P_CODE']		= $strPCode;
	$param['PM_TYPE_IN']	= "large";
	$aryZResult				= $productMgr->getProdImgListEx($db, "OP_ARYLIST", $param);

	// 스킨
	if($intMTotal == 0) :
		echo "<div class=\"noListWrap\">";
		echo $LNG_TRANS_CHAR["PS00001"]; //"등록된 상품이 없습니다.";	// 차후 페이지 제작
		echo "</div>";
	else :
		include "prodView.MultyImage.OpenWindow.skin.html.php";
	endif;

?>