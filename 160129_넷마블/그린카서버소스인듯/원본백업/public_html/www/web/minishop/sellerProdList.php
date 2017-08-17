<?
	## 상품 리스트
	if(!$productMgr):
		require_once MALL_PROD_FUNC;
		require_once MALL_CONF_LIB."ProductMgr.php";
		$productMgr				= new ProductMgr();
		require_once "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/site_skin_product.conf.inc.php";
	endif;

	## 미니몰 전용 상품 리스트
	$intProductShopNo = $_REQUEST['sh_no'];

	## 페이징 링크 주소
	$intPage		= $_REQUEST['page'];
	$strSearchSort	= $_REQUEST['sort'];
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
	<?include "top.inc.php"; ?>

	<!-- start: contentArea -->
	<div id="minishopContentArea">		
		<div id="minishopContentWrap">
			<div class="minishopBestProdWrap">
				<h3>Best Goods</h3>
				<div class="prodList">
				<? include "{$S_DOCUMENT_ROOT}www/web/product/include/prodList.index.inc.php"; // 상품 리스트 ?>
				</div>
			</div>
		</div>
	</div>
	<!-- end: contentArea -->