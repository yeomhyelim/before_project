<?php
	/**
	 * eumshop app - brandList - sliderSkin
	 *
	 * 상품 브랜드 리스트 스라이더 기능 추가
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/www/web/app/brandList/brandList.sliderSkin.php
	 * @manual		menuType=app&mode=brandList&skin=sliderSkin&itemCnt=4&moveCnt=1&pageLine=100&orderBy=sortAsc&show=name
	 * @history
	 *				2014.05.14 kim hee sung - 개발 완료
	 */

	/**
	 * app id
	 */
	if(!$strAppID):
		$intAppID				= $intAppID + 1; 
		$strAppID				= "BRAND_LIST_{$intAppID}";
	endif;

	/**
	 * script 설정
	 **/
	$aryScript[] = "/common/js/app/brandList/brandList.sliderSkin.js";
	$aryScript[] = "/common/jquery-jcarousel/jquery.jcarousel.js";
	$aryScriptEx[] = "/common/js/app/brandList/brandList.sliderSkin.js";
	$aryScriptEx[] = "/common/jquery-jcarousel/jquery.jcarousel.js";

	/**
	 * 모듈 설정
	 */
	$objProductBrandModule		= new ProductBrandModule($db);

	/**
	 * 기본 설정
	 */
	$intAppPageLine				= $EUMSHOP_APP_INFO['pageLine'];
	$strAppOrderBy				= $EUMSHOP_APP_INFO['orderBy'];	
	$intAppPage					= $EUMSHOP_APP_INFO['page'];	
	$intAppItemCnt				= $EUMSHOP_APP_INFO['itemCnt'];
	$intAppMoveCnt				= $EUMSHOP_APP_INFO['moveCnt'];
	$strShow					= $EUMSHOP_APP_INFO['show']; // name or image or name;image
	if(!$strShow) {$strShow = "image"; }
	if(!$intAppItemCnt) { $intAppItemCnt = 3; }
	if(!$intAppMoveCnt) { $intAppMoveCnt = $intAppItemCnt; }
	$aryShow					= explode(";", $strShow);

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
<!-- eumshop app - brandList - sliderSkin (<?php echo $strAppID?>) -->
<script>
	G_APP_PARAM['<?php echo $strAppID;?>']							= new Object();
	G_APP_PARAM['<?php echo $strAppID;?>']['MODE']					= "<?php echo $strAppMode;?>";
	G_APP_PARAM['<?php echo $strAppID;?>']['SKIN']					= "<?php echo $strAppSkin;?>"; 
	G_APP_PARAM['<?php echo $strAppID;?>']['ITEM_CNT']				= "<?php echo $intAppItemCnt;?>";
	G_APP_PARAM['<?php echo $strAppID;?>']['MOVE_CNT']				= "<?php echo $intAppMoveCnt;?>";
</script>
<div id="<?php echo $strAppID?>">
	<div class="jcarousel">
		<?php if($resAppResult):?>
		<ul class="<?php echo $strAppStyle;?>">
		<?php while($row = mysql_fetch_array($resAppResult)):
			## 기본설정
			$intPR_NO			= $row['PR_NO'];
			$strPR_NAME			= $row['PR_NAME'];
			$intPR_LIST_IMG		= $row['PR_LIST_IMG'];

			## 이미지가 없을때
			if(!$intPR_LIST_IMG) { continue; } ?>
			<li>
				<?php if(in_array("image", $aryShow)):?>
				<a href="./?menuType=product&mode=brandList&pr_no=<?php echo $intPR_NO?>"><img src="<?php echo $intPR_LIST_IMG;?>"></a>
				<?php endif;?>
				<?php if(in_array("name", $aryShow)):?>
				<a href="./?menuType=product&mode=brandList&pr_no=<?php echo $intPR_NO?>"><?php echo $strPR_NAME;?></a>
				<?php endif;?>
			</li>
		<?php endwhile;?>
		</ul>
		<a href="#" class="jcarousel-control-prev">&lsaquo;</a>
		<a href="#" class="jcarousel-control-next">&rsaquo;</a>
		<p class="jcarousel-pagination"></p>
	</div>
	<?php endif;?>
</div>
<!-- eumshop app - brandList - sliderSkin (<?php echo $strAppID?>) -->