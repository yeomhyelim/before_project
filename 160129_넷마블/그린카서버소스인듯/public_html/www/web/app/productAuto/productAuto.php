<?php
	/**
	 * eumshop app - productAuto
	 *
	 * 스크롤을 내리면 자동으로 상품이 로드됩니다. 
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource
	 * @manual		&mode=productAuto
	 * @history
	 *				2014.01.23 kim hee sung - 개발 1차 테스트 완료(개발 미완료)
	 *										  디자인태그 개발에 필요한 내용을 확인하기 위해 우선적으로 1차 개발만 진행한 상태입니다.
	 */

	/**
	 * app id.
	 */
	$intAppID					= $intAppID + 1; 
	$strAppID					= "PRODUCT_AUTO_{$intAppID}";
//	$strAppID					= "APP_ID_{$intAppID}";


	## 모듈 설정
	$objProductMgr				= new ProductMgrModule($db);
	

	## 상품 정보 불러오기
	$aryParam							= "";
	$aryParam['LIMIT_END']				= 10;
	$aryParam['LNG']					= $S_SITE_LNG;
	$aryParam['PRODUCT_IMG_JOIN']		= "Y";
	$resProductList						= $objProductMgr->getProductMgrSelectEx("OP_LIST", $aryParam);

?>
<!-- product auto scrolling html code (<?php echo $strAppID?>) -->
<div id="<?php echo $strAppID?>" class="productAutoWrap">
<?if($resProductList):?>
<ul>
<?while($row = mysql_fetch_array($resProductList)):
	$strImg		= $row['PM_REAL_NAME'];			?>

<li><img src="<?=$strImg?>" style="width:200px;height:300px"></li>

<?endwhile;?>
</ul>
<?endif;?>
</div>
<!-- product auto scrolling html code (<?php echo $strAppID?>) -->




