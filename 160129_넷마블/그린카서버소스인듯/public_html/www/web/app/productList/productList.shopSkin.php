<?php
	/**
	 * eumshop app - productList - shopSkin
	 *
	 * 상품리스트 - 입점사스킨입니다.
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/www/web/app/productList/productList.shopSkin.php
	 * @manual		menuType=app&mode=productList&skin=shopSkin
	 * @history
	 *				2014.08.18 kim hee sung - 개발 완료
	 */

	## app id
	if(!$strAppID):
		$intAppID				= $intAppID + 1; 
		$strAppID				= "PRODUCT_LIST_{$intAppID}";
	endif;

	## 기본설정
	$intShNo = $_GET['sh_no'];

	## 체크
	if(!$intShNo) { return; }

	## 모듈 설정
	$objShopSiteModule = new ShopSiteModule($db);

	## 상점정보 불러오기
	$param = "";
	$param['SH_NO'] = $intShNo;
	$aryShopRow = $objShopSiteModule->getShopSiteSelectEx("OP_SELECT", $param);
	if(!$aryShopRow) { return; }

	## 탑베너
	$strST_THUMB_IMG = $aryShopRow['ST_THUMB_IMG'];
	if($strST_THUMB_IMG) { $strST_THUMB_IMG = "/upload/shop/store_{$intShNo}/design/{$strST_THUMB_IMG}"; }

	## 설명 설정
	$strST_MEMO = $aryShopRow['ST_MEMO'];
?>

<link rel="stylesheet" type="text/css" href="/common/css/product/product_0001.css"/>
<?php if($strST_THUMB_IMG):?>
<div class="thumbImg">
	<img src="<?php echo $strST_THUMB_IMG;?>">
</div>
<?php endif;?>
<?php if($strST_MEMO):?>
<div class="memo">
<?php echo $strST_MEMO;?>
</div>
<?php endif;?>
<div class="listTopSortWrap">
	<h3><strong class="cate_tit"> <span class="product-list-name" appID="<?php echo $strAppID;?>"></span></strong> <?=callLangTrans($LNG_TRANS_CHAR['PS00013'],array("<span class='product-list-total' appID='{$strAppID}'></span>"))?></h3>
	<div class="sortBtn">
		<span class="txt">
			<?=$LNG_TRANS_CHAR["PW00026"]//제조사?><a href="javascript:goSearchSort('RA');"><img src="/himg/product/A0001/kr/btn_sort_down.gif"></a><a href="javascript:goSearchSort('RD');"><img src="/himg/product/A0001/kr/btn_sort_up.gif"></a>
		</span>
		<span class="txt">
			<?=$LNG_TRANS_CHAR["OW00058"]//상품명?><a href="javascript:goSearchSort('NA');"><img src="/himg/product/A0001/kr/btn_sort_down.gif"></a><a href="javascript:goSearchSort('ND');"><img src="/himg/product/A0001/kr/btn_sort_up.gif"></a> 
		</span>
		<span class="txt">
			<?=$LNG_TRANS_CHAR["PW00008"]//적립금?><a href="javascript:goSearchSort('PA');"><img src="/himg/product/A0001/kr/btn_sort_down.gif"></a><a href="javascript:goSearchSort('PD');"><img src="/himg/product/A0001/kr/btn_sort_up.gif"></a>
		</span>
		<span class="txt">
			<?=$LNG_TRANS_CHAR["PW00004"]//판매가격?><a href="javascript:goSearchSort('RA');"><img src="/himg/product/A0001/kr/btn_sort_down.gif"></a><a href="javascript:goSearchSort('RD');"><img src="/himg/product/A0001/kr/btn_sort_up.gif"></a> 
		</span>
	</div>
	<div class="clr"></div>
</div>

<?
$EUMSHOP_APP_INFO = "";
$EUMSHOP_APP_INFO['name'] = "상품리스트";
$EUMSHOP_APP_INFO['mode'] = "productList";
$EUMSHOP_APP_INFO['appID'] = $strAppID;
include "{$S_DOCUMENT_ROOT}www/web/app/index.php";
?>

<div id="pagenate">
	<span class="product-list-paginate" appID="<?php echo $strAppID;?>"></span>
</div>