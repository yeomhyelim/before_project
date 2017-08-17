<?php
	/**
	 * eumshop app - shopMain - defaultSkin
	 *
	 * 입점사 메인 페이지 입니다.
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/home/shop_eng/www/web/app/shopMain/shopMain.defaultSkin.php
	 * @manual		menuType=app&mode=shopMain&skin=defaultSkin
	 * @history
	 */

	## app ID
	if(!$strAppID):
		$intAppID = $intAppID + 1;
		$strAppID = "SELLER_MAIN{$intAppID}";
	endif;

	## 모듈 설정
	$objShopSiteModule = new ShopMgrModule($db);

	require_once MALL_CONF_LIB."ProductMgr.php";
	$productMgr		= new ProductMgr();
	$productMgr -> setP_LNG($strLang);
	## 스크립트 설정
	$aryScriptEx[] = "/common/js/app/shopMain/shopMain.defaultSkin.js";

	## 기본설정
	$intAppPageLine = $EUMSHOP_APP_INFO['pageLine'];
	$strAppHtml = $EUMSHOP_APP_INFO['html'];
	$strLang = $S_SITE_LNG;
	$strLangLower = strtolower($strLang);

	
	## 임점사 리스트 불러오기
	$param								= "";
	$param['SH_APPR']					= "Y";
	$param['SH_COM_MAIN']					= "Y";

	$intAppTotal						= $objShopSiteModule->getShopMgrSelectEx("OP_COUNT", $param);					// 데이터 전체 개수
	$intAppPageLine						= ( $intAppPageLine )		? $intAppPageLine	: 10000;						// 리스트 개수
	$intAppPage							= ( $intAppPage )			? $intAppPage		: 1;
	$intAppFirst						= ( $intAppTotal == 0 )		? 0					: $intAppPageLine * ( $intAppPage - 1 );

	$param['LIMIT_END']					= "10";
	$param['JOIN_MM']					= "Y";
	$param['ORDER_BY']					= "noDesc";
	
	$resAppResult						= $objShopSiteModule->getShopMgrSelectEx("OP_LIST", $param);
	$intAppPageBlock					= $strAppPageBlock;																// 블럭 개수
	$intAppListNum						= $intAppTotal - ( $intAppPageLine * ( $intAppPage - 1 ) );						// 번호
	$intAppTotPage						= ceil( $intAppTotal / $intAppPageLine );
//	echo $db->query;

	## paging 설정
	$intAppPage				= $intAppPage;									// 현재 페이지
	$intAppTotPage			= $intAppTotPage;								// 전체 페이지 수
	@$intAppTotBlock			= ceil($intAppTotPage / $intAppPageBlock);		// 전체 블럭 수
	@$intAppBlock			= ceil($intAppPage / $intAppPageBlock);			// 현재 블럭
	$intAppPrevBlock		= (($intAppBlock - 2) * $intAppPageBlock) + 1;	// 이전 블럭
	$intAppNextBlock		= ($intAppBlock * $intAppPageBlock) + 1;		// 다음 블럭
	$intAppFirstBlock		= (($intAppBlock - 1) * $intAppPageBlock) + 1;	// 현재 블럭 시작 시저
	$intAppLastBlock		= $intAppBlock * $intAppPageBlock;				// 현재 블럭 종료 시점

	if($intAppFirstBlock <= 0) { $intAppFirstBlock	= 1; }
	if($intAppPrevBlock  <= 0) { $intAppPrevBlock	= 1; }
	if($intAppNextBlock >= $intAppTotPage) { $intAppNextBlock	= $intAppTotPage; }
	if($intAppLastBlock >= $intAppTotPage) { $intAppLastBlock	= $intAppTotPage; }

	## 페이지 시작/마지막 번호 설정
	$intAppFirstNo			= ($intAppPage <= 1) ? $intAppPage : (($intAppPage - 1) * $intAppPageLine);
	$intAppLastNo			= $intAppPage * $intAppPageLine;
	if(!$intAppFirstNo) { $intAppFirstNo = ""; }
	if($intAppLastNo > $intAppTotal) { $intAppLastNo = $intAppTotal; }

	## 다국어 언어별 문장 설정
	$aryLanguage			= "";
//	$aryLanguage['OS00013']	= $LNG_TRANS_CHAR['OS00013'];

	## script data 만들기
	$aryAppParam = "";
	$aryAppParam['MODE'] = $strAppMode;
	$aryAppParam['SKIN'] = $strAppSkin;
	$aryAppParam['PAGE'] = $intAppPage;
	$aryAppParam['LANGUAGE'] = $aryLanguage;
	$aryScriptData['APP'][$strAppID] = $aryAppParam;

	## html 코드 사용 여부 설정
	if($strAppHtml == "N") { return; }

	//입점사의 type, 국가, 등급관련 설정 2015.05.14
	include_once sprintf( "%s/www/include/shopCom.conf.inc.php", $S_DOCUMENT_ROOT);
?>
<?php
	$resShopMainResult = $resAppResult;

	if(!$intAppTotal) { return; }
?>
<div id="<?php echo $strAppID?>" class="prodListWrap">
	<?php if($strAppTitleShow != "Y" && $strAppTitle):?>
		<!--h2><?php// echo $strAppTitle;?></h2-->
	<?php endif;?>
	<ul id="<?php echo $strAppID?>_ul">
			<?php $i = 1; ?>
			<?php while($row = mysql_fetch_array($resShopMainResult)):

					## 기본 설정
					$intSH_NO				= $row['SH_NO'];
					$strSH_COM_NAME			= $row['SH_COM_NAME'];//회사명
					$strSH_COM_CATEGORY		= $row['SH_COM_CATEGORY'];//type
					
					// 20150714 모바일 메인 Type 노출 방법 추가
					$strSH_COM_TYPE = $aryTypeM[$strSH_COM_CATEGORY];


					$strSH_COM_CREDIT_GRADE_IMG	= $aryCreditGradeImg[$row['SH_COM_CREDIT_GRADE']];
					$strSH_COM_SALE_GRADE_IMG	= $arySaleGradeImg[$row['SH_COM_SALE_GRADE']];
					$strSH_COM_LOCUS_GRADE_IMG	= $aryLocusGradeImg[$row['SH_COM_LOCUS_GRADE']];
				
					$productMgr->setP_SHOP_NO($intSH_NO);
					$productCode = $productMgr -> getShopProduct($db);

					if($productCode[P_CODE]){
						$strProdView = "javascript:goProdComView('".$productCode[P_CODE]."');";
					}else{
						$strProdView = "#";
					}

					## 이미지 설정
					$strSH_FILE5 = "/upload/shop/no_image.jpg";
					//if($strST_LOGO) { $strLogFile = "{$strLogDir}/{$strST_LOGO}"; }
					if($row['SH_COM_FILE4']) {	$strSH_FILE4	= "/upload/shop/file4/{$row['SH_COM_FILE4']}";}


					## 입점사명 설정
					$strTitle = $strST_NAME;
					if($strLang != "KR") { $strTitle = $strST_NAME_ENG; }

					## endClass 설정
					$strEndClass = "";
					if($i == 3) { $strEndClass = " endBrandBox"; }

					## 증가
					$i++;
			?>
			<li>
				<a href="<?=$strProdView?>">
				<div class="productInfoWrap">
					<div class="prodListImg">
						<img src="<?=$strSH_FILE4?>" class="listProdImg"><!--상품이미지-->
					</div>
					<div class="prodInfoSum">
						<dl>
							<!--색상-->
							<!--브렌드-->								
							<dd class="title"><span><?=$strSH_COM_NAME?></span></dd><!--회사명-->
							<dd class="prodInfo">
								<ul class="info">
									<li><span class="tit">제조사</span><strong><?=$strSH_COM_TYPE;?></strong></li>
									<li class="shopIcoWrap">
										<img src="<?=$strSH_COM_CREDIT_GRADE_IMG;?>">
										<img src="<?=$strSH_COM_SALE_GRADE_IMG?>">
										<img src="<?=$strSH_COM_LOCUS_GRADE_IMG?>">
									</li>
								</ul>									
							</dd>							
							<div class="clr"></div>
						</dl>
					</div>
					<div class="clr"></div>
				</div>
				</a>
			</li>

			<!--div class="bestBrandBox<?php echo $strEndClass;?>">
				<div class="infoWrap">
					<ul>
						<li class="brandImg"><img src="<?php echo $strLogFile;?>" alt="brand Img" /></li>
						<li class="brandTit"><a href="./?menuType=shop&mode=shopProdList&sh_no=<?php echo $intSH_NO;?>"><?php echo $strTitle;?></a></li>
					</ul>
				</div>
				<div class="brandProdImg"><a href="./?menuType=shop&mode=shopProdList&sh_no=<?php echo $intSH_NO;?>"><img src="<?php echo $strShopFile;?>" alt="brand Prod Img" class="prodImg" /></a></div>
				<div class="brandProdImgList">
					<ul>
						<?php while($prodRow = mysql_fetch_array($resProductResult)):

								## 기본 설정
								$strP_CODE = $prodRow['P_CODE'];
								$strPM_REAL_NAME = $prodRow['PM_REAL_NAME'];

								## 이미지 설정
								if(!$strPM_REAL_NAME) { $strPM_REAL_NAME = "/upload/product/20120821/prodImg2/2012082100006.jpg"; }

						?>
						<li><a href="./?menuType=product&mode=view&sh_no=<?php echo $intSH_NO;?>&prodCode=<?php echo $strP_CODE;?>"><img src="<?php echo $strPM_REAL_NAME;?>" alt="brand Prod Img" class="prodImg" /></a></li>
						<?php endwhile;?>
						<li class="itemBox"><a href="./?menuType=product&mode=list&sh_no=<?php echo $intSH_NO;?>"><p class="txt_sky"><?php echo $strProductTotal;?></p> Items</a></li>
					</ul>
				</div>
			</div-->
			<?php endwhile;?>
			</ul>
			<div class="clr"></div>
</div>			
<script>
$(document).ready(function() {
	$('#<?php echo $strAppID?>_ul').bxSlider({
		minSlides: 3,
		maxSlides: 3,
		moveSlides: 1,
		slideWidth: 400,
		slideMargin: 5,
		pause: 3000,
		pager: false,
		auto: false,
		infiniteLoop: false,
		controls:true //전 후 콘트롤 보이기 안보이기
	});
});
</script>
<!-- eumshop app - shopMain - mobileBestSkin (<?php echo $strAppID?>) -->			