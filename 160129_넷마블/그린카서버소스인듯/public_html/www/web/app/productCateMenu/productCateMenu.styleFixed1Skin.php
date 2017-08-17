<?php
	/**
	 * eumshop app - productCateMenu - styleFixed1Skin
	 *
	 * 1차 카테고리 기본 표시, 1차 카테고리 클릭을 하면, 2차 카테고리 표시
	 * 펼침/닫김 슬라이드 형태로 작동.
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/www/web/app/productCateMenu/productCateMenu.styleFixed1Skin.php
	 * @manual		menuType=app&mode=productCateMenu&skin=styleFixed1Skin
	 * @history
	 *				2014.06.07 kim hee sung - 개발 완료
	 */

	## 카테고리 정보 불러오기
	include_once MALL_SHOP . "/conf/category.{$S_SITE_LNG_PATH}.inc.php";

	## 스크립트 설정
	$aryScriptEx[]				= "/common/js/app/productCateMenu/productCateMenu.styleFixed1Skin.js";

	## appID 설정
	if(!$strAppID):
		$intAppID				= $intAppID + 1; 
		$strAppID				= "PRODUCT_CATE_MENU_{$intAppID}";
	endif;

	## 기본 설정
	$strAppSelectCate			= $EUMSHOP_APP_INFO['selectCate'];
	$strAppSelectCate1			= substr($strAppSelectCate, 0, 3);
	$strAppSelectCate2			= substr($strAppSelectCate, 3, 3);
	$strAppSelectCate3			= substr($strAppSelectCate, 6, 3);
	$strAppSelectCate4			= substr($strAppSelectCate, 9, 3);


?>
<!-- eumshop app - productCateMenu - styleFixed1Skin (<?php echo $strAppID?>) -->
<div id="<?php echo $strAppID;?>">
	<div class="cate1-wrap">
		<ul class="cateList">
		<?php foreach($S_ARY_CATE1 as $key1 => $data1):

				## 기본설정
				$strCODE = $data1['CODE'];
				$strNAME = $data1['NAME'];
				$strSHARE = $data1['SHARE'];
				$strVIEW= $data1['VIEW'];
				$intLOW_CNT = $data1['LOW_CNT'];
				$strOnClass = "";
				$strHideClass = " hide";

				if($strSHARE == "Y") { continue; }
				if($strVIEW != "Y") { continue; }
				if($strAppSelectCate1 == $strCODE):
					$strOnClass = " on"; 
					$strHideClass = "";
				endif;
		?>
			<li class="cate1<?php echo $strOnClass;?>">
				<a href="#;" onClick="goProductCateMenuStyleFixed1SkinShowEvent('<?php echo $strAppID;?>', this)"><span><?php echo $strNAME;?></span></a>
				<?php if($intLOW_CNT):?>
				<div class="cate2-wrap<?php echo $strHideClass;?>">
					<ul class="cate2">
					<?php foreach($S_ARY_CATE2[$key1] as $key2 => $data2):

							## 기본설정
							$strCODE = $data2['CODE'];
							$strNAME = $data2['NAME'];
							$strSHARE = $data2['SHARE'];
							$strVIEW= $data2['VIEW'];
							$intLOW_CNT = $data2['LOW_CNT'];
							$strOnClass = "";
							$strCODE1 = substr($strCODE, 0, 3);
							$strCODE2 = substr($strCODE, 3, 3);

							if($strSHARE == "Y") { continue; }
							if($strVIEW != "Y") { continue; }
							if($strAppSelectCate1 == $strCODE1 && $strAppSelectCate2 == $strCODE2) { $strOnClass = " on"; }
					?>
						<li class="<?php echo $strOnClass;?>">
							<a href="javascript:goProductCateMenuStyleFixed1SkinListMoveEvent('<?php echo $strCODE1;?>','<?php echo $strCODE2;?>','','')"><span><?php echo $strNAME;?></span></a>
						</li>
					<?php endforeach;?>
					</ul>
				</div>
				<?php endif;?>
			</li>
		<?php endforeach;?>
		</ul>
	</div>
</div>
<!-- eumshop app - productCateMenu - styleFixed1Skin (<?php echo $strAppID?>) -->