<?php
	/**
	 * eumshop app - productCateMenu - styleWaved1Skin
	 *
	 * 카테고리 출력
	 * 조건1) 상품 카테고리 설정에 따라서 유동적으로 변경
	 * 조건2) 1차 카테고리까지 있으면 출력 안함.
	 * 조건3) 2차 카테고리까지 있으면 출력 안함.
	 * 조건4) 3차 카테고리까지 있으면 1차 카테고리 서택 => 출력 안함, 2차 카테고리 선택 => 3차 카테고리 출력, 3차 카테고리 선택 => 3차 카테고리 출력
	 * 조건5) 4차 카테고리까지 있는면 1차 카테고리 서택 => 출력 안함, 2차 카테고리 선태 => 출력 안함, 3차 카테고리 선택 => 4차 카테고리 출력, 4차 카테고리 선택 => 4차 카테고리 출력
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/www/web/app/productCateMenu/productCateMenu.styleWaved1Skin.php
	 * @manual		menuType=app&mode=productCateMenu&skin=styleWaved1Skin&selectCate=001005001001
	 * @history
	 *				2014.06.07 kim hee sung - 개발 완료
	 */

	## 모듈 설정
	$objProductMgrModule		= new ProductMgrModule($db);

	## 카테고리 정보 불러오기
	include_once MALL_SHOP . "/conf/category.menu.{$S_SITE_LNG_PATH}.inc.php";

	## 스크립트 설정
	$aryScriptEx[]				= "/common/js/app/productCateMenu/productCateMenu.styleWaved1Skin.js";

	## appID 설정
	if(!$strAppID):
		$intAppID				= $intAppID + 1; 
		$strAppID				= "PRODUCT_CATE_MENU_{$intAppID}";
	endif;

	## 기본 설정
	$aryCateList				= "";
	$strAppSelectCate			= $EUMSHOP_APP_INFO['selectCate'];
	$strAppSelectCate1			= substr($strAppSelectCate, 0, 3);
	$strAppSelectCate2			= substr($strAppSelectCate, 3, 3);
	$strAppSelectCate3			= substr($strAppSelectCate, 6, 3);
	$strAppSelectCate4			= substr($strAppSelectCate, 9, 3);
	if($strAppSelectCate1 == "000") { $strAppSelectCate1 = ""; }
	if($strAppSelectCate2 == "000") { $strAppSelectCate2 = ""; }
	if($strAppSelectCate3 == "000") { $strAppSelectCate3 = ""; }
	if($strAppSelectCate4 == "000") { $strAppSelectCate4 = ""; }
	if(!$strAppSelectCate1) { return; }
	if(!$strAppSelectCate2) { return; }

	## 3차 카테고리가 존재하는지 체크
	$isCate = false;
	if($S_CATE_MENU3 && $S_CATE_MENU3[$strAppSelectCate1] && $S_CATE_MENU3[$strAppSelectCate1][$strAppSelectCate2]) { $isCate = true; }
	if(!$isCate) {return; }
	$aryCateList = $S_CATE_MENU3[$strAppSelectCate1][$strAppSelectCate2];

	## 4차 카테고리가 존재하는지 체크
	$isCate = false;
	foreach($aryCateList as $key => $data):
		if($S_CATE_MENU4 && $S_CATE_MENU4[$strAppSelectCate1] && $S_CATE_MENU4[$strAppSelectCate1][$strAppSelectCate2] &&  $S_CATE_MENU4[$strAppSelectCate1][$strAppSelectCate2][$key]):
			$isCate = true;
			break;
		endif;
	endforeach;
	if($isCate):
		if(!$strAppSelectCate3) { return; }
		$aryCateList = $S_CATE_MENU4[$strAppSelectCate1][$strAppSelectCate2][$key];
	endif;
?>
<!-- eumshop app - productCateMenu - styleWaved1Skin (<?php echo $strAppID?>) -->
<div id="<?php echo $strAppID;?>">
	<div class="cate-wrap">
		<ul class="cateList">
			<?php foreach($aryCateList as $key => $data):
			
					## 기본설정
					$strOnClass = "";
					$strCODE = $data['CODE'];
					$strNAME = $data['NAME'];
					$strIMG1 = $data['IMG1'];
					$strIMG2 = $data['IMG2'];
					$strCate1 = substr($strCODE, 0, 3);
					$strCate2 = substr($strCODE, 3, 3);
					$strCate3 = substr($strCODE, 6, 3);
					$strCate4 = substr($strCODE, 9, 3);
					if($strCate1 == "000") { $strCate1 = ""; }
					if($strCate2 == "000") { $strCate2 = ""; }
					if($strCate3 == "000") { $strCate3 = ""; }
					if($strCate4 == "000") { $strCate4 = ""; }

					## 선택된 카테고리 설정
					if($strAppSelectCate1 == $strCate1 && $strAppSelectCate2 == $strCate2 && $strAppSelectCate3 == $strCate3 && $strAppSelectCate4 == $strCate4):
						$strOnClass = " on"; 
					endif;

					$param['P_CATE_LIKE'] = $strCate1 . $strCate2 . $strCate3 . $strCate4;
					$intProdCnt = $objProductMgrModule->getProductMgrSelectEx("OP_COUNT", $param);

			?>
			<li class="cate<?php echo $strOnClass;?>">
				<a href="#;" onClick="goProductCateMenuStyleWaved1SkinListMoveEvent('<?php echo $strCate1;?>','<?php echo $strCate2;?>','<?php echo $strCate3;?>','<?php echo $strCate4;?>')">
					<?php echo $strNAME;?><span>(<?php echo $intProdCnt;?>)</span>
				</a>
			</li>
			<?php endforeach;?>
		</ul>
		<div class="clr"></div>
	</div>
</div>
<!-- eumshop app - productCateMenu - styleWaved1Skin (<?php echo $strAppID?>) -->