<?php
	/**
	 * eumshop app - productCateMenu - styleFixed4Skin
	 *
	 * 하위 카테고리 출력
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/www/web/app/productCateMenu/productCateMenu.styleFixed4Skin.php
	 * @manual		http://demo2.eumshop.co.kr/kr/?menuType=app&mode=productCateMenu&skin=styleFixed4Skin&selectCate=002
	 * @tag			<!--?name=하위카테고리출력&mode=productCateMenu&skin=styleFixed4Skin&selectCate=002-->
	 * @tag			<!--?name=하위카테고리출력&mode=productCateMenu&skin=styleFixed4Skin-->
	 * @history
	 *				2014.06.07 kim hee sung - 개발 완료
	 */

	## appID 설정
	if(!$strAppID):
		$intAppID				= $intAppID + 1; 
		$strAppID				= "PRODUCT_CATE_MENU_{$intAppID}";
	endif;

	## 모듈 설정
	$objProductMgrModule		= new ProductMgrModule($db);

	## 카테고리 정보 불러오기
	include_once MALL_SHOP . "/conf/category.menu.{$S_SITE_LNG_PATH}.inc.php";

	## 스크립트 설정
	$aryScriptEx[]				= "/common/js/app/productCateMenu/productCateMenu.styleFixed4Skin.js";

	## 기본 설정
	$strAppSelectCate			= $EUMSHOP_APP_INFO['selectCate'];
	$strCate1							= $_GET['lcate'];
	$strCate2							= $_GET['mcate'];
	$strCate3							= $_GET['scate'];
	$strCate4							= $_GET['fcate'];

	## 카테고리 설정
	if(!$strAppSelectCate) { $strAppSelectCate = "{$strCate1}{$strCate2}{$strCate3}{$strCate4}"; }
	$strAppSelectCate1			= substr($strAppSelectCate, 0, 3);
	$strAppSelectCate2			= substr($strAppSelectCate, 3, 3);
	$strAppSelectCate3			= substr($strAppSelectCate, 6, 3);
	$strAppSelectCate4			= substr($strAppSelectCate, 9, 3);

	## 출력 카테고리 설정
	$aryCateList = "";
	if($strAppSelectCate1 && $strAppSelectCate2 && $strAppSelectCate3 && $strAppSelectCate4) { return; }
	else if($strAppSelectCate1 && $strAppSelectCate2 && $strAppSelectCate3) { $aryCateList = $S_CATE_MENU4[$strAppSelectCate1][$strAppSelectCate2][$strAppSelectCate3]; }
	else if($strAppSelectCate1 && $strAppSelectCate2) { $aryCateList = $S_CATE_MENU3[$strAppSelectCate1][$strAppSelectCate2]; }
	else if($strAppSelectCate1) { $aryCateList = $S_CATE_MENU2[$strAppSelectCate1]; }

	## 체크
	if(!$aryCateList) { return; }

?>
<!-- eumshop app - productCateMenu - styleFixed4Skin (<?php echo $strAppID?>) -->
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
				
					$param['LNG'] = $S_SITE_LNG;
					$param['P_CATE_LIKE'] = $strCate1 . $strCate2 . $strCate3 . $strCate4;
					$intProdCnt = $objProductMgrModule->getProductMgrSelectEx("OP_COUNT", $param);
					if(!$intProdCnt) { $intProdCnt = 0; }

			?>
			<li class="cate<?php echo $strOnClass;?>">
				<a href="./?menuType=product&mode=list&lcate=<?php echo $strCate1;?>&mcate=<?php echo $strCate2;?>&scate=<?php echo $strCate3;?>&fcate=<?php echo $strCate4;?>" onClick="goProductCateMenuStyleWaved1SkinListMoveEvent('<?php echo $strCate1;?>','<?php echo $strCate2;?>','<?php echo $strCate3;?>','<?php echo $strCate4;?>')">
					<?php echo $strNAME;?><span>(<?php echo $intProdCnt;?>)</span>
				</a>
			</li>
			<?php endforeach;?>
		</ul>
		<div class="clr"></div>
	</div>
</div>
<!-- eumshop app - productCateMenu - styleFixed4Skin (<?php echo $strAppID?>) -->