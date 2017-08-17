<?

	/**** 탑 이미지 ****/
	if($PRODUCT_CATEGORY_TAG_USE != "Y"):
		echo "<div class=\"prodtopImgWrap\">";
		include "include/prodList.topImage.index.inc.php";
		echo "</div>";
	endif;

	/**** 베스트 상품 ****/
	if($strMode != "search"):
		$no = 1; include "include/sub.bestList.index.inc.php";
		$no = 2; include "include/sub.bestList.index.inc.php";
		$no = 3; include "include/sub.bestList.index.inc.php";
		$no = 4; include "include/sub.bestList.index.inc.php";
		$no = 5; include "include/sub.bestList.index.inc.php";
	endif;

	/**** 서브 카테고리 ****/
	if($IS_PRODUCT_SUBCATE_UNUSE != "Y"):
	include "include/prodList.subCate.index.inc.php";
	endif;

	/**** 상품 리스트 ****/
	include "include/prodList.index.inc.php";

	/**** infinite scroll ****/
	if ( isset ( $S_SHOP_MORE_VIEW_USE ) && ! empty ( $S_SHOP_MORE_VIEW_USE ) ) :
		include "include/prodList.infinitescroll.js.php";
	endif;

?>