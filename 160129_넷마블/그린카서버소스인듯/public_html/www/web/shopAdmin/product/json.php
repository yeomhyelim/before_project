<?
	$result_array = array();
	
	$strJsonMode		= $_POST["jsonMode"]		? $_POST["jsonMode"]		: $_REQUEST["jsonMode"];
	
	/* 페이지 분류 */
	$aryIncludeFolder = array(   "prodBrandImgDelete"	=> "brand"
								,"cateLevelList"		=> "product"
								,"cateUpdateProdList"	=> "product"
								,"popProdList"			=> "product"
								,"prodOrderUpdate"		=> "product"
								,"popProdRelated"		=> "product"
								,"productRelatedList"	=> "product"
								,"productViewModify"	=> "product"
								,'prodShopModify'		=> "product"
								,"productNotifyCommLoad"=> "product"
								,"productAppr"			=> "product"
								
								,"cateProdShareInfo"	=> "cate"
								,"popCateShareList"		=> "cate"
								,"prodGrpInfo"			=> "prodGrp"
								,"scrapingInfo"			=> ""
								,"selectShopList"		=> ""
								,"scrapingRunFile"		=> ""
								,"scrapingRun"			=> ""
								,"checkTheBackground"	=> ""
								,"userSaveDB"			=> ""
								,"stockTotQty"			=> "prodStock"
								,"optStockUpdate"		=> "prodStock"
								,"choiceStockStatusUpdateVersion2.0" => "prodStock"
								,"productSiteCommLoad"	=> "product"

								,"popPlanProdList"		=> "prodPlan"

								,"ceosbInterviewWrite"	=> "ceosbInterview"
								,"ceosbInterviewModify"	=> "ceosbInterview"
								,"ceosbInterviewDelete"	=> "ceosbInterview"
							 );



	/* 페이지 분류 */
	if($strAct)		{ include "{$strIncludePath}{$aryIncludeFolder[$strAct]}/json.inc.php"; }
	else			{ include "{$strIncludePath}{$aryIncludeFolder[$strJsonMode]}/json.inc.php"; }

	$db->disConnect();

	if(in_array($strAct, array("ceosbInterviewWrite", "ceosbInterviewModify", "ceosbInterviewDelete", "productRelatedList"))):
		if(!$result):
			$result = print_r($_POST, true);
		endif;
		echo json_encode($result);
		exit;
	endif;
?>