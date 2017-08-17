<?php
	/**
	 * eumshop app - setData
	 *
	 * 요청된 데이터 정보를 출력합니다.
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource
	 * @manual		&mode=setData&key=상품개수
	 * @history
	 *				2014.01.07 kim hee sung - 개발 완료

	/**
	 * app id
	 */
	$intAppID					= $intAppID + 1; 
	$strAppID					= "SET_DATA_{$intAppID}";
//	$strAppID					= "APP_ID_{$intAppID}";

	/**
	 * 기본 정보
	 */
	$strKey						= $EUMSHOP_APP_INFO['key'];
	$strOp1						= $EUMSHOP_APP_INFO['op1'];
	$strOp2						= $EUMSHOP_APP_INFO['op2'];
	$strOp3						= $EUMSHOP_APP_INFO['op3'];

	switch($strKey):

	case "장바구니상품총금액":
		## 2014.12.18 kim hee sung
		## 언어별, 옵션별, 택배 기타 등등 테스트을 안했습니다.
		## 오류가 발생할때 마다 체크하면서 업데이트가 필요합니다.

		## 모듈 설정
		require_once MALL_PROD_FUNC;
		require_once MALL_CONF_LIB . "ProductMgr.php";
		$productMgr = new ProductMgr();

		## 기본설정
		$intMemberNo = $g_member_no;
		$strCartPriKey =  $g_cart_prikey;

		## 기본 금액 설정
		$strPriceLeftMark			= getCurMark();
		$strPriceRightMark			= getCurMark2();
		$strProdCartPriceTotalText	= getFormatPrice(0, 2);
		$strProdCartPriceTotalText	= "{$strPriceLeftMark}{$strProdCartPriceTotalText}{$strPriceRightMark}";

		## 체크
		if(!$intMemberNo && !$strCartPriKey):
			echo $strProdCartPriceTotalText;
			break;
		endif;

		## 장바구니 데이터 불러오기
		$productMgr->setM_NO($g_member_no);
		$productMgr->setPB_KEY($strCartPriKey);
		$intProdCartTotal = $productMgr->getProdBasketTotal($db);
		$productMgr->setLimitFirst(0);
		$productMgr->setPageLine($intProdCartTotal);
		$prodCartResult = $productMgr->getProdBasketList($db);
		if(!$intProdCartTotal):
			echo $strProdCartPriceTotalText;
			break;
		endif;
		

		## 총금액 계산
		$intCartPriceTotal = 0;
		while($prodCartItem = mysql_fetch_array($prodCartResult)):
			## 상품 총 합계(금액 * 수량)
			$intCartPrice					= ($prodCartItem['PB_PRICE'] * $prodCartItem['PB_QTY']) + $prodCartItem['PB_ADD_OPT_PRICE'];
			$intCartPriceTotal			   += $intCartPrice;
		endwhile;

		## 총상품금액(현재통화)
		$strProdCartPriceTotalText		= getFormatPrice($intCartPriceTotal,2);
		$strProdCartPriceTotalText		= "{$strPriceLeftMark}{$strProdCartPriceTotalText}{$strPriceRightMark}";

		## 출력
		echo $strProdCartPriceTotalText;
	break;

	case "최근본상품총금액":

		## 기본설정
		$strLang					= $S_SITE_LNG;
		$aryProdToday				= explode("/",$g_prod_today);
		$intTotalSalePrice			= 0;
		foreach($aryProdToday as $key => $prodToday) :
			$productMgr->setP_LNG($strLang);
			$productMgr->setP_CODE($prodToday);
			$prodQuickRow = $productMgr->getProdView($db);
			$strP_WEB_VIEW = $prodQuickRow['P_WEB_VIEW'];
			$intP_SALE_PRICE = $prodQuickRow['P_SALE_PRICE'];
			if($strP_WEB_VIEW != "Y") { continue; }
			$intTotalSalePrice = $intTotalSalePrice + $intP_SALE_PRICE;
		endforeach;

		echo $intTotalSalePrice;		

	break;

	case "장바구니개수":

		echo getShoppingBagCount();		

	break;

 	case "담아두기개수":

		echo getSavedItemsCount();		

	break;

	case "상품개수":

		/**
		 * 모듈 설정
		 */
		$objProductMgr					= new ProductMgrModule($db);

		/**
		 * 현재 선택된 상품 카테고리 파라미터 값 설정.
		 */
		$strSelectCate1					= $_GET['lcate'];
		$strSelectCate2					= $_GET['mcate'];
		$strSelectCate3					= $_GET['scate'];
		$strSelectCate4					= $_GET['fcate'];
		$intMemberNo					= $_SESSION['member_no'];

		/**
		 * 상품 개수 불러오기
		 */
		$aryParam						= "";
		$aryParam['LNG']				= $S_SITE_LNG;
		$aryParam['P_WEB_VIEW']			= "Y";
		$aryParam['PRODUCT_INFO_JOIN']	= "Y";
		$aryParam['MPL_JOIN']			= ($strOp1 == "myList") ? "Y" : "";
		$aryParam['M_NO']				= $g_member_no;
		$aryParam['P_SIZE']				= $strOp2;
		$aryParam['P_COLOR']			= $strOp3;
		$aryParam['P_CATE_LIKE']		= $strSelectCate1 . $strSelectCate2 . $strSelectCate3 . $strSelectCate4;
		$intAppTotal					= $objProductMgr->getProductMgrSelectEx("OP_COUNT", $aryParam);
// echo $db->query;
		echo $intAppTotal;
	break;

	case "변수":
		foreach($EUMSHOP_APP_INFO as $key => $data):
			if(in_array($key, array("mode","key"))) { continue; }
			${"{$key}"} = $data;
		endforeach;
	break;

	case "다국어변수":
		
	
		foreach($EUMSHOP_APP_INFO as $key => $data):
			if(in_array($key, array("menuType","mode","key"))) { continue; }
			list($lng, $key) = explode(":", $key);
			$lng = strtoupper($lng);
			if($S_SITE_LNG != $lng) { continue; }
			${"{$key}"} = $data;
		endforeach;

	break;

	endswitch;
