<?
	require_once MALL_PROD_FUNC;

	/* 관리자 Top 메뉴 권한 설정 */
	$strTopMenuCode = "004";
	/* 관리자 Top 메뉴 권한 설정 */

	/* 사용언어 셋팅 */
	$arySiteUseLng = explode("/",$S_USE_LNG);
	for($i=0;$i<sizeof($arySiteUseLng);$i++){
		if ($arySiteUseLng[$i]){
			$S_ARY_USE_COUNTRY[$arySiteUseLng[$i]] = $S_ARY_COUNTRY[$arySiteUseLng[$i]];
		}
	}
	$strStLng	= ($strStLng) ? $strStLng : $strAdmSiteLng;
	$strProdLng	= $strStLng; /** 2013.07.08 kim hee sung, strProdLng 가 정의된곳이 없음.. 추후, strStLng 로 변경 해야 할듯.. */
	/* 사용언어 셋팅 */

	/* 페이지 분류 */
	$aryIncludeFolder = array(   "cateList"					=> "cate"
								,"popCateWrite"				=> "cate"
								,"popCateModify"			=> "cate"
								,"popCateShareList"			=> "cate"
								,"catePlanList"				=> "cate"			//기획전카테고리
								,"prodList"					=> "product"
								,"prodModify"				=> "product"
								,"prodWrite"				=> "product"
								,"popProdCopy"				=> "product"
								,"popProdShare"				=> "product"
								,"popProdCateUpdate"		=> "product"
								,"popProdRelated"			=> "product"		// 관련상품 등록
								,"popProdShopModify"		=> "product"		// 입점사 변경 폼
								,"popProdAppr"				=> "product"

								,"prodDisplay"				=> "prodDisplay"
								,"prodGrpList"				=> "prodGrp"
								,"popProdGrpList"			=> "prodGrp"
								,"prodBrandList"			=> "brand"
								,"prodBrandWrite"			=> "brand"
								,"prodBrandModify"			=> "brand"
								,"popBrandManagerSearch"	=> "brand"
								,"scraping"					=> "scraping"
								,"scripingAllList"			=> "scraping"
								,"scrapingNonList"			=> "scraping"
								,"scrapingAuthList"			=> "scraping"
								,"prodStockList"			=> "prodStock"
								,"popProdOptStock"			=> "prodStock"
								,"popProdStockUpdate"		=> "prodStock"
								,"prodViewList"				=> "prodView"
								,"prodWishList"				=> "prodWish"
								,"prodRecList"				=> "prodRec"
								,"popProdRecUpdate"			=> "prodRec"
								,"prodAtOneTimeWrite"		=> "prodAtOneTime"

								,"prodEvent"				=> "prodEvent"
								,"popProdEvent"				=> "prodEvent"
								,"popProdSearch"			=> "prodEvent"
								,"popProdEventList"			=> "prodEvent"

								,"gift"						=> "gift"
								,"popGiftModify"			=> "gift"
								,"popGiftProdSearch"		=> "gift"
								,"popProdGiftList"			=> "gift"

								,"prodPlanList"				=> "prodPlan"
								,"prodPlanWrite"			=> "prodPlan"
								,"prodPlanModify"			=> "prodPlan"
								,"popPlanProdSearch"		=> "prodPlan"

								,"ceosbInterviewList"		=> "ceosbInterview"
								,"ceosbInterviewWrite"		=> "ceosbInterview"
								,"ceosbInterviewView"		=> "ceosbInterview"
								,"ceosbInterviewModify"		=> "ceosbInterview"

								,"prodAuctionList"			=> "prodAuction"
								,"popProdAuctionApplyList"	=> "prodAuction"
								,"prodAuctionWrite"			=> "product"
								,"prodAuctionModify"		=> "product"


							 );

	## 화면업그레이드 버전관리
	$strProductVersion						= "v1.0";
	if ($S_PROD_MANY_LANG_VIEW == "Y") $strProductVersion  = "v2.0";

	/* 페이지 분류 */
	/*##################################### Act Page 이동 #####################################*/
	if ($strMode == "act" || $strMode == "json" || SUBSTR($strMode,0,3) == "pop" || $strMode == "excel"){

		if (SUBSTR($strMode,0,3) == "pop") include $strIncludePath.$aryIncludeFolder[$strMode]."/".$strMode.".php";
		else include $strIncludePath.$strMode.".php";
		exit;
	}
	/*##################################### Act Page 이동 #####################################*/

	## 스크립트 리스트 설정
	$script									= "";
	$script['any'][]						= "./common/js/common2.js";
	$script['ceosbInterviewWrite'][]		= "/common/eumEditor/highgardenEditor.js";
	$script['ceosbInterviewWrite'][]		= "/common/js/jquery.form.js";
	$script['ceosbInterviewWrite'][]		= "./common/js/ceosbInterview/ceosbInterviewWrite.js";
	$script['ceosbInterviewList'][]			= "./common/js/ceosbInterview/ceosbInterviewList.js";
	$script['ceosbInterviewView'][]			= "./common/js/ceosbInterview/ceosbInterviewView.js";
	$script['ceosbInterviewModify'][]		= "/common/eumEditor/highgardenEditor.js";
	$script['ceosbInterviewModify'][]		= "./common/js/ceosbInterview/ceosbInterviewModify.js";
	$aryScript								= $script['any'];
	if($script[$strMode] && $script['any']):
		$aryScript							= array_merge($aryScript, $script[$strMode]);
	elseif($script[$strMode]):
		$aryScript							= $script[$strMode];
	endif;

	include $strIncludePath.$aryIncludeFolder[$strMode]."/helper.inc.php";
?>
<? include "./include/header.inc.php"?>
<?
	include $strIncludePath.$aryIncludeFolder[$strMode]."/script.inc.php";

	if (!$includeFile){
		$includeFile = $strIncludePath.$aryIncludeFolder[$strMode]."/".$strMode.".php";
	}
?>
</script>
<!-- ******************** TopArea ********************** -->
	<? include "./include/top.inc.php"?>
<!-- ******************** TopArea ********************** -->
	<div id="contentArea">
		<table style="width:100%;">
			<tr>
				<td class="leftWrap">
					<!-- ******************** leftArea ********************** -->
						<?include "./include/left.inc.php"?>
					<!-- ******************** leftArea ********************** -->
				</td>
				<td class="contentWrap">
					<div class="bodyTopLine"></div>
					<!-- ******************** contentsArea ********************** -->
						<div class="layoutWrap">
						<form name="form" id="form">
						<input type="hidden" name="menuType" value="<?=$strMenuType?>">
						<input type="hidden" name="mode" id="mode" value="<?=$strMode?>">
						<input type="hidden" name="act" value="<?=$strMode?>">
						<input type="hidden" name="jsonMode" value="">
						<input type="hidden" name="policyLng" value="<?=$_REQUEST['policyLng']?>">
							<?
							if(is_file($strIncludePath.$aryIncludeFolder[$strMode]."/param.inc.php")){
							include $strIncludePath.$aryIncludeFolder[$strMode]."/param.inc.php";
							}
								include $includeFile;
							?>
						</form>
						</div>
					<!-- ******************** contentsArea ********************** -->
				</td>
			</tr>
		</table>
	</div>
<!-- ******************** footerArea ********************** -->
	<?include "./include/bottom.inc.php"?>
<!-- ******************** footerArea ********************** -->
</body>
</html>