<?php
	/**
	 * eumshop app - productLocation
	 *
	 * 상품 카테고리를 LOCATION 형태로 표시됩니다. (eX, home > 메뉴1 > 메뉴2 )
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource
	 * @manual		&mode=productLocation&location=HOME;cate1&lcate=001&mcate=&scate=&fcate=
	 * @history
	 *				2013.12.25 kim hee sung - 개발 완료
	 */

	/**
	 * app id.
	 */
	$intAppID					= $intAppID + 1; 
	$strAppID					= "PRODUCT_LOCATION_{$intAppID}";
//	$strAppID					= "APP_ID_{$intAppID}";

	/**
	 * 기본 설정
	 */
	$strSelectCate1					= $_GET['lcate'];
	$strSelectCate2					= $_GET['mcate'];
	$strSelectCate3					= $_GET['scate'];
	$strSelectCate4					= $_GET['fcate'];
	$intPrNo						= $_GET['pr_no'];
	$strAppCate1					= $EUMSHOP_APP_INFO['cate1'];
	$strAppCate2					= $EUMSHOP_APP_INFO['cate2'];
	$strAppCate3					= $EUMSHOP_APP_INFO['cate3'];
	$strAppCate4					= $EUMSHOP_APP_INFO['cate4'];
	$strLang						= $EUMSHOP_APP_INFO['lang'];
	if($strLang && $S_SITE_LNG && strtolower($S_SITE_LNG) != $strLang) { return; }
	if($strAppCate1) { $strSelectCate1 = $strAppCate1; }
	if($strAppCate2) { $strSelectCate2 = $strAppCate2; }
	if($strAppCate3) { $strSelectCate3 = $strAppCate3; }
	if($strAppCate4) { $strSelectCate4 = $strAppCate4; }

	/**
	 * 카테고리별 저장할 변수 초기화.
	 */
	$aryCate1						= "";
	$aryCate2						= "";
	$aryCate3						= "";
	$aryCate4						= "";

	/**
	 * 화면에 출력할 location 설정 및 배열화.
	 */
	if($EUMSHOP_APP_INFO['location'])	{ $strAppLocation	= $EUMSHOP_APP_INFO['location'];		}
	if(!$strAppLocation)				{ $strAppLocation	= "cate1;cate2;cate3;cate4";			}
	$aryAppLocation					= explode(";", $strAppLocation);

	## 브랜드 설정
	include_once MALL_SHOP . "/conf/prodBrand.conf.inc.php";
	$strBrandName = $PROD_BRAND[$intPrNo]['PR_NAME'];

	/**
	 * 상품 카테고리 정보 불러오기
	 */
	include_once MALL_SHOP . "/conf/category.{$S_SITE_LNG_PATH}.inc.php";

	## 1차 카테고리 정의
	if($strSelectCate1):
		foreach($S_ARY_CATE1 as $key1 => $data1):
			
			## 기본 설정
			$strCode			= $data1['CODE'];
			$strCate1			= substr($strCode, 0, 3);
			$strCate2			= substr($strCode, 3, 3);
			$strCate3			= substr($strCode, 6, 3);
			$strCate4			= substr($strCode, 9, 3);
			
			## 선택된 카테고리가 아니면 continue
			if($strCate1 != $strSelectCate1) { continue; }

			## 사용 데이터 만들기
			$aryCate1			= $data1;
			
			break;
		endforeach;
	endif;
	

	## 2차 카테고리 정의
	if($strSelectCate2):
		foreach($S_ARY_CATE2[$key1] as $key2 => $data2):
			
			## 기본 설정
			$strCode			= $data2['CODE'];
			$strCate1			= substr($strCode, 0, 3);
			$strCate2			= substr($strCode, 3, 3);
			$strCate3			= substr($strCode, 6, 3);
			$strCate4			= substr($strCode, 9, 3);
			
			## 선택된 카테고리가 아니면 continue
			if($strCate1 != $strSelectCate1) { continue; }
			if($strCate2 != $strSelectCate2) { continue; }

			## 사용 데이터 만들기
			$aryCate2			= $data2;
			
			break;
		endforeach;
	endif;

	## 3차 카테고리 정의
	if($strSelectCate3):
		foreach($S_ARY_CATE3[$key1][$key2] as $key3 => $data3):
			
			## 기본 설정
			$strCode			= $data3['CODE'];
			$strCate1			= substr($strCode, 0, 3);
			$strCate2			= substr($strCode, 3, 3);
			$strCate3			= substr($strCode, 6, 3);
			$strCate4			= substr($strCode, 9, 3);
			
			## 선택된 카테고리가 아니면 continue
			if($strCate1 != $strSelectCate1) { continue; }
			if($strCate2 != $strSelectCate2) { continue; }
			if($strCate3 != $strSelectCate3) { continue; }

			## 사용 데이터 만들기
			$aryCate3			= $data3;
			
			break;
		endforeach;
	endif;

	## 4차 카테고리 정의
	if($strSelectCate4):
		foreach($S_ARY_CATE4[$key1][$key2][$key3] as $key4 => $data4):
			
			## 기본 설정
			$strCode			= $data4['CODE'];
			$strCate1			= substr($strCode, 0, 3);
			$strCate2			= substr($strCode, 3, 3);
			$strCate3			= substr($strCode, 6, 3);
			$strCate4			= substr($strCode, 9, 3);
				
			## 선택된 카테고리가 아니면 continue
			if($strCate1 != $strSelectCate1) { continue; }
			if($strCate2 != $strSelectCate2) { continue; }
			if($strCate3 != $strSelectCate3) { continue; }
			if($strCate4 != $strSelectCate4) { continue; }

			## 사용 데이터 만들기
			$aryCate4			= $data4;
	
			break;
		endforeach;
	endif;

	## 출력 개수 구하기
	$intIdx						= 0;
	$intIdxMax					= 0;
	foreach($aryAppLocation as $key => $data):
		$strName			= $data;
		$strNameLower		= strtolower($strName);
		if($strName == "cate1") { $strName	= $aryCate1['NAME']; }
		if($strName == "cate2") { $strName	= $aryCate2['NAME']; }
		if($strName == "cate3") { $strName	= $aryCate3['NAME']; }
		if($strName == "cate4") { $strName	= $aryCate4['NAME']; }
		if($strNameLower == "brandname") { $strName = $strBrandName; }
		if(!$strName) { continue; }
		$intIdxMax++;						
	endforeach;
?>

<!-- product location html code (<?php echo $strAppID?>) -->
<div id="<?php echo $strAppID?>" class="productLocationWrap">
	<ul>
	<?foreach($aryAppLocation as $key => $data):
		$strName			=  $data;
		$strNameLower		= strtolower($strName);
		if($strName == "cate1") { $strName	= $aryCate1['NAME']; }
		if($strName == "cate2") { $strName	= $aryCate2['NAME']; }
		if($strName == "cate3") { $strName	= $aryCate3['NAME']; }
		if($strName == "cate4") { $strName	= $aryCate4['NAME']; }	
		if($strNameLower == "brandname") { $strName = $strBrandName; }
		if(!$strName) { continue; }
		$intIdx++;	
		if($intIdxMax == $intIdx) { $strEndClass = " end"; }		?>
		<li class="location location-id-<?=$intIdx?><?=$strEndClass?>"><strong><?=$strName?></strong></li>
	<?endforeach;?>
	</ul>
	<div class="clr"></div>
</div>
<!-- product location html code (<?php echo $strAppID?>) -->