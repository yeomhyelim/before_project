<?php
	/**
	 * eumshop app - brandList - defaultSkin
	 *
	 * 상품 브랜드 리스트를 불러옵니다.
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/www/web/app/brandList/brandList.defaultSkin.php
	 * @manual		menuType=app&mode=brandList&pageLine=100&orderBy=sortAsc&show=title
	 * @tag			<!--?name=브랜드리스트&&mode=brandList&pageLine=100&orderBy=sortAsc&show=title-->
	 * @history
	 *				2014.04.22 kim hee sung - 개발 완료
	 */

	/**
	 * app id
	 */
	if(!$strAppID):
		$intAppID				= $intAppID + 1; 
		$strAppID				= "BRAND_LIST_{$intAppID}";
	endif;

	/**
	 * 모듈 설정
	 */
	$objProductBrandModule		= new ProductBrandModule($db);

	/**
	 * script 설정
	 **/
	$aryScriptEx[] = "/common/js/app/brandList/brandList.defaultSkin.js";

	/**
	 * 기본 설정
	 */
	$intAppPageLine				= $EUMSHOP_APP_INFO['pageLine'];
	$strAppOrderBy				= $EUMSHOP_APP_INFO['orderBy'];	
	$intAppPage					= $EUMSHOP_APP_INFO['page'];	
	$strShow					= $EUMSHOP_APP_INFO['show']; // name or image or name;image
	$intAppEnd					= $EUMSHOP_APP_INFO['end'];
	if(!$strShow) {$strShow = "image"; }
//	$intAppPNameCut				= $EUMSHOP_APP_INFO['pNameCut'];
//	$strAppLinkType				= $EUMSHOP_APP_INFO['linkType'];
//	$strAppStyle				= $EUMSHOP_APP_INFO['style'];
//	$strAppMouseHoverEvent		= $EUMSHOP_APP_INFO['mouseHoverEvent'];
//	$strAppLang					= $EUMSHOP_APP_INFO['lang'];
//	$strAppSearchKey			= $EUMSHOP_APP_INFO['searchKey'];
//	if(!$intAppPNameCut) { $intAppPNameCut = 1000; }
//	if(!$strAppLinkType) { $strAppLinkType = "self"; } // tiny or self
//	if(!$strAppStyle) { $strAppStyle = "prodList"; } // prod or prodList
//	if(!$strAppMouseHoverEvent) { $strAppMouseHoverEvent = "Y"; } // Y or N
//	if(!$strAppLang) { $strAppLang = $S_SITE_LNG; }
//	if($strAppSearchKey) { $strSearchKeyParam = "%{$strAppSearchKey}%"; }
	$aryShow					= explode(";", $strShow);

	## 금액 단위 설정
	$strMoneyIconLeft			= $S_ARY_MONEY_ICON[$strAppLang]["L"];
	$strMoneyIconRight			= $S_ARY_MONEY_ICON[$strAppLang]["R"];

	/**
	 * 데이터 불러오기
	 */
	$param								= "";
	$param['LNG']						= $strAppLang;
	$param['PRODUCT_INFO_JOIN']			= "Y";
	$param['PRODUCT_IMG_JOIN']			= "Y";
	$param['searchKey']					= $strSearchKeyParam;
	$intAppTotal						= $objProductBrandModule->getProductBrandSelectEx("OP_COUNT", $param);				// 데이터 전체 개수 
	$intAppPageLine						= ( $intAppPageLine )		? $intAppPageLine	: 10;								// 리스트 개수 
	$intAppPage							= ( $intAppPage )			? $intAppPage		: 1;
	$intAppFirst						= ( $intAppTotal == 0 )		? 0					: $intAppPageLine * ( $intAppPage - 1 );

	$param['ORDER_BY']					= $strAppOrderBy;
	$param['LIMIT']						= "{$intAppFirst},{$intAppPageLine}";
	$resAppResult						= $objProductBrandModule->getProductBrandSelectEx("OP_LIST", $param);
	$intAppPageBlock					= 10;																				// 블럭 개수 
	$intAppListNum						= $intAppTotal - ( $intAppPageLine * ( $intAppPage - 1 ) );							// 번호
	$intAppTotPage						= ceil( $intAppTotal / $intAppPageLine );
//	echo $db->query;

	/**
	 * paging 설정
	 */
	$intAppPage				= $intAppPage;									// 현재 페이지
	$intAppTotPage			= $intAppTotPage;								// 전체 페이지 수
	$intAppTotBlock			= ceil($intAppTotPage / $intAppPageBlock);		// 전체 블럭 수
	$intAppBlock			= ceil($intAppPage / $intAppPageBlock);			// 현재 블럭
	$intAppPrevBlock		= (($intAppBlock - 2) * $intAppPageBlock) + 1;	// 이전 블럭
	$intAppNextBlock		= ($intAppBlock * $intAppPageBlock) + 1;		// 다음 블럭
	$intAppFirstBlock		= (($intAppBlock - 1) * $intAppPageBlock) + 1;	// 현재 블럭 시작 시저
	$intAppLastBlock		= $intAppBlock * $intAppPageBlock;				// 현재 블럭 종료 시점
	if($intAppFirstBlock <= 0) { $intAppFirstBlock	= 1; }
	if($intAppPrevBlock  <= 0) { $intAppPrevBlock		= 1; }
	if($intAppNextBlock >= $intAppTotPage) { $intAppNextBlock	= $intAppTotPage; }
	if($intAppLastBlock >= $intAppTotPage) { $intAppLastBlock	= $intAppTotPage; }
?>
<!-- eumshop app - brandList - default (<?php echo $strAppID?>) -->
<script>
</script>
<div id="<?php echo $strAppID?>">
<?php if($resAppResult):?>
<ul class="<?php echo $strAppStyle;?>">
<?php $intCnt = 0;?>
<?php while($row = mysql_fetch_array($resAppResult)):
	## 기본설정
	$intPR_NO			= $row['PR_NO'];
	$strPR_NAME			= $row['PR_NAME'];
	$intPR_LIST_IMG		= $row['PR_LIST_IMG'];

	## end class 붙이기
	$strClass = "";
	if(($intCnt+1) % $intAppEnd == 0) { $strClass .= " listEnd"; }

	## 이미지가 없을때
	if(!$intPR_LIST_IMG) { $strClass .= ' noImage'; }
	
	if($strClass) { $strClass = " class='{$strClass}'"; }

	?>
	<li<?php echo $strClass;?> onclick="goBrandListDefaultSkinMoveEvent('<?php echo $strAppID?>', <?php echo $intPR_NO;?>)">
		<?php if(in_array("image", $aryShow)):?>
		<span class="brandImg"><img src="<?php echo $intPR_LIST_IMG;?>"></span>
		<?php endif;?>
		<?php if(in_array("name", $aryShow)):?>
		<span class="brandName"><?php echo $strPR_NAME;?></span>
		<?php endif;?>
	</li>
<?php $intCnt++;?>
<?php endwhile;?>
</ul>
<div class="clr"></div>
<?php if($intAppTotal && $strAppMoreType == "nextView"):?>
<a href="javascript:goProductListRelatedSkinListMoveEvent('<?php echo $strAppID?>','2')" class="nextList" id="nextList" style="">더보기</a>
<div class="loading" style="display:none">
	<img src="/upload/images/loader.gif">
</div>
<?php endif;?>
<?php endif;?>
</div>
<!-- eumshop app - brandList - default (<?php echo $strAppID?>) -->