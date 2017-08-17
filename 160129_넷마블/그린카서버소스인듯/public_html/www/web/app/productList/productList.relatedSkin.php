<?php
	/**
	 * eumshop app - productList - relatedSkin
	 *
	 * 관리자 페이지 전용으로 제작됨
	 * json 실행되는 부분이 /shopAdmin/product/ 폴더의 json 에서 처리함.
	 * 상품 리스트를 불러옵니다.
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/www/web/app/productList/productList.relatedSkin.php
	 * @manual		menuType=app&mode=productList&skin=relatedSkin
	 * @history
	 *				2014.04.16 kim hee sung - 개발 완료
	 */

	/**
	 * app id
	 */
	if(!$strAppID):
		$intAppID				= $intAppID + 1; 
		$strAppID				= "PRODUCT_LIST_{$intAppID}";
	endif;

	/**
	 * 모듈 설정
	 */
	require_once MALL_HOME . "/config/product.func.php";
	$objProductMgrModule		= new ProductMgrModule($db);

	/**
	 * 스크립트 설정
	 */
//	$aryScriptEx[]				= "/common/js/tinybox.js";
	$aryScriptEx[]				= "/common/js/app/productList/productList.js";
	$aryScriptEx[]				= "/common/js/app/productList/productListRelatedSkin.js";

	/**
	 * 기본 설정
	 */
	$intAppPageLine				= $EUMSHOP_APP_INFO['pageLine'];
	$strAppOrderBy				= $EUMSHOP_APP_INFO['orderBy'];	
	$intAppPage					= $EUMSHOP_APP_INFO['page'];	
	$intAppPNameCut				= $EUMSHOP_APP_INFO['pNameCut'];
	$strAppLinkType				= $EUMSHOP_APP_INFO['linkType'];
	$strAppStyle				= $EUMSHOP_APP_INFO['style'];
	$strAppMouseHoverEvent		= $EUMSHOP_APP_INFO['mouseHoverEvent'];
	$strAppLang					= $EUMSHOP_APP_INFO['lang'];
	$strAppSearchKey			= $EUMSHOP_APP_INFO['searchKey'];
	if(!$intAppPNameCut) { $intAppPNameCut = 1000; }
	if(!$strAppLinkType) { $strAppLinkType = "self"; } // tiny or self
	if(!$strAppStyle) { $strAppStyle = "prodList"; } // prod or prodList
	if(!$strAppMouseHoverEvent) { $strAppMouseHoverEvent = "Y"; } // Y or N
	if(!$strAppLang) { $strAppLang = $S_SITE_LNG; }
	if($strAppSearchKey) { $strSearchKeyParam = "%{$strAppSearchKey}%"; }

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
	$intAppTotal						= $objProductMgrModule->getProductMgrSelectEx("OP_COUNT", $param);					// 데이터 전체 개수 
	$intAppPageLine						= ( $intAppPageLine )		? $intAppPageLine	: 10;								// 리스트 개수 
	$intAppPage							= ( $intAppPage )			? $intAppPage		: 1;
	$intAppFirst						= ( $intAppTotal == 0 )		? 0					: $intAppPageLine * ( $intAppPage - 1 );

	$param['ORDER_BY']					= $strAppOrderBy;
	$param['LIMIT']						= "{$intAppFirst},{$intAppPageLine}";
	$resAppResult						= $objProductMgrModule->getProductMgrSelectEx("OP_LIST", $param);
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
<!-- eumshop app - productList - sortListSkin (<?php echo $strAppID?>) -->
<script>
	G_APP_PARAM['<?php echo $strAppID;?>']							= new Object();
	G_APP_PARAM['<?php echo $strAppID;?>']['MODE']					= "<?php echo $strAppMode;?>";
	G_APP_PARAM['<?php echo $strAppID;?>']['SKIN']					= "<?php echo $strAppSkin;?>"; 
	G_APP_PARAM['<?php echo $strAppID;?>']['LINK_TYPE']				= "<?php echo $strAppLinkType;?>"; 
	G_APP_PARAM['<?php echo $strAppID;?>']['STYLE']					= "<?php echo $strAppStyle;?>"; 
	G_APP_PARAM['<?php echo $strAppID;?>']['MOUSE_HOVER_EVENT']		= "<?php echo $strAppMouseHoverEvent;?>"; 
	G_APP_PARAM['<?php echo $strAppID;?>']['PAGE_LINE']				= "<?php echo $intAppPageLine;?>";
	G_APP_PARAM['<?php echo $strAppID;?>']['ORDER_BY']				= "<?php echo $strAppOrderBy;?>";
	G_APP_PARAM['<?php echo $strAppID;?>']['P_NAME_CUT']			= "<?php echo $intAppPNameCut;?>";
	G_APP_PARAM['<?php echo $strAppID;?>']['LANG']					= "<?php echo $strAppLang;?>";
	G_APP_PARAM['<?php echo $strAppID;?>']['SEARCH_KEY']			= "<?php echo $strAppSearchKey;?>";
</script>
<div id="<?php echo $strAppID?>">
<?php if($resAppResult):?>
<ul class="<?php echo $strAppStyle;?>">

<?php while($row = mysql_fetch_array($resAppResult)):
	## 기본설정
	$strP_CODE			= $row['P_CODE'];
	$strP_NAME			= $row['P_NAME'];
	$intP_SALE_PRICE	= $row['P_SALE_PRICE'];
	$strPM_REAL_NAME	= $row['PM_REAL_NAME'];

	## 상품명 설정
	$strP_NAME			= strHanCutUtf($strP_NAME, $intAppPNameCut);

	## 판매 금액 설정
	$intP_SALE_PRICE	= getCurToPrice($intP_SALE_PRICE, $S_ST_LNG);
	$intP_SALE_PRICE	= "{$strMoneyIconLeft}{$intP_SALE_PRICE}{$strMoneyIconRight}";

//	## 이미지 체크
	if(!$strPM_REAL_NAME) { $strPM_REAL_NAME = "/himg/product/A0001/no_img.gif"; }		?>
	<li>
		<dl id="p_code_<?php echo $strP_CODE;?>" class="prodlist">
			<dt>
				<input type="checkbox" id="prodSelect" value="<?php echo $strP_CODE;?>">
				<img id="pm_real_name" src="<?php echo $strPM_REAL_NAME;?>" style="width:70px;height:70px">
			</dt>
			<dd id="p_code"><?php echo $strP_CODE;?></dd>
			<dd id="p_name"><?php echo $strP_NAME;?></dd>
			<dd id="p_sale_price"><?php echo $intP_SALE_PRICE;?></dd>
		</dl>
	</li>
<?php endwhile;?>
	<div class="clr"></div>
</ul>
<div class="clr"></div>
<a href="javascript:goProductListRelatedSkinListMoveEvent('<?php echo $strAppID?>','2')" class="nextList" id="nextList" style="">더보기</a>
<div class="loading" style="display:none">
	<img src="/upload/images/loader.gif">
</div>
<?php endif;?>
</div>
<!-- eumshop app - productList - sortListSkin (<?php echo $strAppID?>) -->

