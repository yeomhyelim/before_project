<?

	/* 정의 */
	$strShowType		= $S_PRODUCT_VIEW_BEST_LIST1_USE;

	if(in_array($strShowType, array("A","B","C"))) :
		// 다중이미지
		/* 정의 */
		$intWSize 			= $S_PRODUCT_VIEW_BEST_LIST1_SIZE_W;
		$intHSize			= $S_PRODUCT_VIEW_BEST_LIST1_SIZE_H;
		$intWList 			= $S_PRODUCT_VIEW_BEST_LIST1_VIEW_W;
		$intHList			= $S_PRODUCT_VIEW_BEST_LIST1_VIEW_H;

		include "prodView.detailInfo.default.{$strShowType}.skin.html.php";
	else:

		include "prodView.detailInfo.default.skin.html.php";

	endif;

?>