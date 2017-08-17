<?
	## STEP 1.
	## 미니샵 사용 유무 체크
	$minishopUse = $PRODUCT_VIEW_MINISHOP_USE;				// 미니샵 사용 하는 경우 코드 수행
	if(!$prodRow['P_SHOP_NO']) { $minishopUse = "N"; }		// 미니샵 회원이 아닌 경우.

	if($minishopUse == "Y"):

		## STEP 2.
		## 상점 정보
		require_once MALL_CONF_LIB."ShopMgr.php";
		$shopMgr				= new ShopMgr();
		$shopMgr->setSH_NO($prodRow['P_SHOP_NO']);
		$storeRow				= $shopMgr->getStoreView($db);

		## STEP 3.
		## 구매만족도
		$param					= "";
		$param['P_SHOP_NO']		= $prodRow['P_SHOP_NO'];
		$averageRow				= $shopMgr->getShopAverageEx($db, $param);

		## STEP 3.
		## 상점 상품 5개 랜덤 리스트
		$param					= "";
		$param['P_SHOP_NO']		= $prodRow['P_SHOP_NO'];
		$param['ORDER_BY']		= "rand()";
		$param['LIMIT']			= "0,5";
		$shopProduct_result = $productMgr->getProdListEx($db, "OP_LIST", $param);

		include "prodView.minishop.skin.html.php";

	endif;

?>