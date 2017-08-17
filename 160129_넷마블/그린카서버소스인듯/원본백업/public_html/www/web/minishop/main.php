<?
	## 상품 리스트
	if(!$productMgr):
		require_once MALL_PROD_FUNC;
		require_once MALL_CONF_LIB."ProductMgr.php";
		$productMgr				= new ProductMgr();
		require_once "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/site_skin_product.conf.inc.php";
		$no						= 1;
	endif;

	## 미니몰 전용 상품 리스트
	$intProductShopNo = $_REQUEST['sh_no'];
?>
	<?include "top.inc.php"; ?>

	<!-- start: contentArea -->
	<div id="minishopContentArea">		
		<div id="minishopContentWrap">
			<div class="miniBannerWrap">
				<?if($shopMainImg):?>
				<img src="<?=$shopMainImg?>"/>
				<?endif;?>
			</div>

			<div class="minishopBestProdWrap">
				<h3>Best Goods</h3>
				<div class="prodList">
				<? include "{$S_DOCUMENT_ROOT}www/web/product/include/bestList.index.inc.php"; // 상품 리스트 ?>
				</div>
			</div>
		</div>
	</div>
	<!-- end: contentArea -->