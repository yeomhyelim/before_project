<?

	/* 페이지 분류 */
	$aryIncludeFolder = array(   "cateWrite"				=> "cate"
								,"cateModify"				=> "cate"
								,"cateDelete"				=> "cate"
								,"prodWrite"				=> "product"
								,"prodModify"				=> "product"
								,"prodDelete"				=> "product"
								,"prodAllDelete"			=> "product"
								,"prodShareInsert"			=> "product"
								,"prodShareMultiInsert"		=> "product"
								,"prodShareDelete"			=> "product"
								,"prodShareSave"			=> "product"
								,"prodImgDel"				=> "product"
								,"prodCopy"					=> "product"
								,"prodAllUpdate"			=> "product"
								,"prodCateUpdate"			=> "product"
								,"prodGrpSave"				=> "prodGrp"
								
								,"prodBrandWrite"			=> "brand"
								,"prodBrandModify"			=> "brand"
								,"prodBrandDelete"			=> "brand"
								
								,"prodTempAuthDelete"		=> "scraping"
								,"prodTempNonDelete"		=> "scraping"
								,"prodTempAllDelete"		=> "scraping"
								
								,"prodDisplaySave"			=> "prodDisplay"
								,"prodIconDel"				=> "prodDisplay"
								,"prodIconRecovery"			=> "prodDisplay"

								,"autoStockUpdate"			=> "prodStock"
								,"choiceStockStatusUpdate"	=> "prodStock"
								,"allStockStatusUpdate"		=> "prodStock"
								,"choiceStockViewStatusUpdate"	=> "prodStock"
								,"autoViewUpdate"			=> "prodStock"
								,"choiceViewStatusUpdate"	=> "prodView"
								,"allViewStatusUpdate"		=> "prodView"

								,"autoRecUpdate"			=> "prodRec"
								,"choiceRecUpdate"			=> "prodRec"
								,"allRecUpdate"				=> "prodRec"
								,"choiceRecUpdate2"			=> "prodRec"

								,"prodAtOneTimeWrite"		=> "prodAtOneTime"
								
								,"prodEventWrite"			=> "prodEvent"
								,"prodEventModify"			=> "prodEvent"
								,"prodEventDelete"			=> "prodEvent"
								,"prodEventCateAllReg"		=> "prodEvent"
								,"prodEventProductReg"		=> "prodEvent"
								,"prodEventProductDelete"	=> "prodEvent"

								,"giftSetting"				=> "gift"
								,"giftWrite"				=> "gift"
								,"giftModify"				=> "gift"
								,"giftFileDel"				=> "gift"
								,"giftDelete"				=> "gift"
								,"prodGiftCateAllReg"		=> "gift"
								,"prodGiftProductReg"		=> "gift"
								,"prodGiftProductDelete"	=> "gift"

								,"prodPlanWrite"			=> "prodPlan"
								,"prodPlanModify"			=> "prodPlan"
								,"prodPlanDelete"			=> "prodPlan"

								,"prodAuctionApplySucess"	=> "prodAuction"
								,"prodAuctionWrite"			=> "product"
								,"prodAuctionModify"		=> "product"

							 );
	/* 페이지 분류 */


	include $strIncludePath.$aryIncludeFolder[$strAct]."/act.inc.php";
	goUrl($strMsg,$strUrl);
?>