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
	 *				2014.08.18 kim hee sung - 개발 완료
	 */

	## app ID
	if(!$strAppID):
		$intAppID = $intAppID + 1;
		$strAppID = "SELLER_MAIN{$intAppID}";
	endif;

	## 모듈 설정
	$objShopSiteModule = new ShopSiteModule($db);

	## 스크립트 설정
	$aryScriptEx[] = "/common/js/app/shopMain/shopMain.defaultSkin.js";

	## 기본설정
	$intAppPageLine = $EUMSHOP_APP_INFO['pageLine'];
	$strAppHtml = $EUMSHOP_APP_INFO['html'];
	$strLang = $S_SITE_LNG;
	$strLangLower = strtolower($strLang);

	## 임점사 리스트 불러오기
	$param								= "";
	$intAppTotal						= $objShopSiteModule->getShopSiteSelectEx("OP_COUNT", $param);					// 데이터 전체 개수
	$intAppPageLine						= ( $intAppPageLine )		? $intAppPageLine	: 10000;						// 리스트 개수
	$intAppPage							= ( $intAppPage )			? $intAppPage		: 1;
	$intAppFirst						= ( $intAppTotal == 0 )		? 0					: $intAppPageLine * ( $intAppPage - 1 );

	$param['JOIN_MM']					= "Y";
	$param['ORDER_BY']					= "noAsc";
	$param['LIMIT']						= "{$intAppFirst},{$intAppPageLine}";
	$resAppResult						= $objShopSiteModule->getShopSiteSelectEx("OP_LIST", $param);
	$intAppPageBlock					= $strAppPageBlock;																	// 블럭 개수
	$intAppListNum						= $intAppTotal - ( $intAppPageLine * ( $intAppPage - 1 ) );							// 번호
	$intAppTotPage						= ceil( $intAppTotal / $intAppPageLine );
//	echo $db->query;

	## paging 설정
	$intAppPage				= $intAppPage;									// 현재 페이지
	$intAppTotPage			= $intAppTotPage;								// 전체 페이지 수
	$intAppTotBlock			= ceil($intAppTotPage / $intAppPageBlock);		// 전체 블럭 수
	$intAppBlock			= ceil($intAppPage / $intAppPageBlock);			// 현재 블럭
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
?>
<?php

	## 입점사 정보 불러오기
	$EUMSHOP_APP_INFO = "";
	$EUMSHOP_APP_INFO['name'] = "입점사정보";
	$EUMSHOP_APP_INFO['mode'] = "shopMain";
	$EUMSHOP_APP_INFO['pageLine'] = 3;
	$EUMSHOP_APP_INFO['html'] = "N";
	include "{$S_DOCUMENT_ROOT}www/web/app/index.php";
	$resShopMainResult = $resAppResult;

	if(!$intAppTotal) { return; }
?>
			<?php $i = 1; ?>
			<?php while($row = mysql_fetch_array($resShopMainResult)):

					## 기본 설정
					$intSH_NO = $row['SH_NO'];
					$strST_NAME = $row['ST_NAME'];
					$strST_NAME_ENG = $row['ST_NAME_ENG'];
					$strST_LOGO = $row['ST_LOGO'];
					$strST_IMG = $row['ST_IMG'];
					$strLogDir = "/upload/shop/store_{$intSH_NO}/design";

					## 이미지 설정
					$strLogFile = "/upload/shop/no_image.jpg";
					if($strST_LOGO) { $strLogFile = "{$strLogDir}/{$strST_LOGO}"; }

					$strShopFile = "/upload/shop/no_image.jpg";
					if($strST_IMG) { $strShopFile = "{$strLogDir}/{$strST_IMG}"; }

					## 입점사명 설정
					$strTitle = $strST_NAME;
					if($strLang != "KR") { $strTitle = $strST_NAME_ENG; }

					## 상품 리스트
					$EUMSHOP_APP_INFO = "";
					$EUMSHOP_APP_INFO['name'] = "입점사 상품 리스트";
					$EUMSHOP_APP_INFO['mode'] = "productList";
					$EUMSHOP_APP_INFO['pageLine'] = 2;
					$EUMSHOP_APP_INFO['sh_no'] = $intSH_NO;
					$EUMSHOP_APP_INFO['html'] = "N";
					$EUMSHOP_APP_INFO['get'] = "N";
					include "{$S_DOCUMENT_ROOT}www/web/app/index.php";
					$intProductTotal = $intAppTotal;
					$resProductResult = $resAppResult;

					## 상품개수 설정
					$strProductTotal = number_format($intProductTotal);

					## endClass 설정
					$strEndClass = "";
					if($i == 3) { $strEndClass = " endBrandBox"; }

					## 증가
					$i++;

			?>
			<div class="bestBrandBox<?php echo $strEndClass;?>">
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
			</div>
			<?php endwhile;?>

			<div class="clr"></div>