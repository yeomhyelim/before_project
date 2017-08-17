<?php
	/**
	 * eumshop app - productCateMenu - selectSkin
	 *
	 * select box 카테고리
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/www/web/app/productCateMenu/productCateMenu.selectSkin.php
	 * @manual		http://demo2.eumshop.co.kr/kr/?menuType=app&mode=productCateMenu&skin=styleFixed4Skin&selectCate=002
	 * @tag			<!--?name=카테고리선택&mode=productCateMenu&skin=selectSkin-->
	 * @tag			<!--?name=카테고리선택&mode=productCateMenu&skin=selectSkin&show=YYYY&home=홈&title=1차 카테고리;2차 카테고리;3차 카테고리;4차 카테고리-->
	 * @history
	 *				2015.02.17 kim hee sung - 개발 완료
	 */

	## appID 설정
	if(!$strAppID):
		$intAppID				= $intAppID + 1; 
		$strAppID				= "PRODUCT_CATE_MENU_{$intAppID}";
	endif;

	## 카테고리 정보 불러오기
	include_once MALL_SHOP . "/conf/category.menu.{$S_SITE_LNG_PATH}.inc.php";

	## 기본설정
	$strCate1 = $_GET['lcate'];
	$strCate2 = $_GET['mcate'];
	$strCate3 = $_GET['scate'];
	$strCate4 = $_GET['fcate'];
	$strAppTitle = $EUMSHOP_APP_INFO['title'];
	$strAppShow = $EUMSHOP_APP_INFO['show'];
	$strAppHome = $EUMSHOP_APP_INFO['home'];
	list($strAppTitle1, $strAppTitle2, $strAppTitle3, $strAppTitle4) = explode(';', $strAppTitle);
	if(!$strAppTitle1) $strAppTitle1 = '1차 카테고리';
	if(!$strAppTitle2) $strAppTitle2 = '2차 카테고리';
	if(!$strAppTitle3) $strAppTitle3 = '3차 카테고리';
	if(!$strAppTitle4) $strAppTitle4 = '4차 카테고리';

	## 카테고리 출력유무 설정
	$isCate1Show = true;
	$isCate2Show = false;
	$isCate3Show = false;
	$isCate4Show = false;
	if($strAppShow[0] == 'Y') $isCate1Show = true;
	if($strAppShow[1] == 'Y' || $strCate1) $isCate2Show = true;
	if($strAppShow[2] == 'Y' || ($strCate1 && $strCate2)) $isCate3Show = true;
	if($strAppShow[3] == 'Y' || ($strCate1 && $strCate2 && $strCate3)) $isCate4Show = true;

	## 출력할 카테고리 설정
	$aryCate1List = $S_CATE_MENU1;
	$aryCate2List = '';
	$aryCate3List = '';
	$aryCate4List = '';
	if($strCate1) $aryCate2List = $S_CATE_MENU2[$strCate1];
	if($strCate1 && $strCate2) $aryCate3List = $S_CATE_MENU3[$strCate1][$strCate2];
	if($strCate1 && $strCate2 && $strCate3) $aryCate4List = $S_CATE_MENU4[$strCate1][$strCate2][$strCate3];
	
	## 스크립트 설정
	$aryScriptEx[]				= "/common/js/app/productCateMenu/productCateMenu.selectSkin.js";


	## script data 만들기
	$aryAppParam = "";
	$aryAppParam['MODE'] = $strAppMode;
	$aryAppParam['SKIN'] = $strAppSkin;
	$aryScriptData['APP'][$strAppID] = $aryAppParam;

?>
<!-- eumshop app - productCateMenu - selectSkin (<?php echo $strAppID?>) -->
<div id="<?php echo $strAppID;?>">
	<ul class="selectCateUl">
		<?php if($strAppHome):?>
		<li class="selectHome">
			<?php echo $strAppHome;?>
		</li>
		<?php endif;?>
		<?php if($isCate1Show):?>
		<li class="selectCateLi selectCateLi1">
			<select name="selectCate1" class="selectCate selectCate1">
				<option value=""><?php echo $strAppTitle1;?></option>
				<?php if($aryCate1List):?>
				<?php foreach($aryCate1List as $key1 => $cate1):?>
				<option value="<?php echo $key1;?>"<?php if($strCate1==$key1){echo " selected";}?>><?php echo $cate1['NAME'];?></option>
				<?php endforeach;?>
				<?php endif;?>
			</select>
		</li>
		<?php endif;?>
		<?php if($isCate2Show):?>
		<li class="selectCateLi selectCateLi2">
			<select name="selectCate2" class="selectCate selectCate2">
				<option value=""><?php echo $strAppTitle2;?></option>
				<?php if($aryCate2List):?>
				<?php foreach($aryCate2List as $key2 => $cate2):?>
				<option value="<?php echo $key2;?>"<?php if($strCate2==$key2){echo " selected";}?>><?php echo $cate2['NAME'];?></option>
				<?php endforeach;?>
				<?php endif;?>
			</select>
		</li>
		<?php endif;?>
		<?php if($isCate3Show):?>
		<li class="selectCateLi selectCateLi3">
			<select name="selectCate3" class="selectCate selectCate3">
				<option value=""><?php echo $strAppTitle3;?></option>
				<?php if($aryCate3List):?>
				<?php foreach($aryCate3List as $key3 => $cate3):?>
				<option value="<?php echo $key3;?>"<?php if($strCate3==$key3){echo " selected";}?>><?php echo $cate3['NAME'];?></option>
				<?php endforeach;?>
				<?php endif;?>
			</select>
		</li>
		<?php endif;?>
		<?php if($isCate4Show):?>
		<li class="selectCateLi selectCateLi4">
			<select name="selectCate4" class="selectCate selectCate4">
				<option value=""><?php echo $strAppTitle4;?></option>
				<?php if($aryCate4List):?>
				<?php foreach($aryCate4List as $key4 => $cate4):?>
				<option value="<?php echo $key4;?>"<?php if($strCate4==$key4){echo " selected";}?>><?php echo $cate4['NAME'];?></option>
				<?php endforeach;?>
				<?php endif;?>
			</select>
		</li>
		<?php endif;?>
	</ul>
	<div class="clr"></div>
</div>
<!-- eumshop app - productCateMenu - selectSkin (<?php echo $strAppID?>) -->