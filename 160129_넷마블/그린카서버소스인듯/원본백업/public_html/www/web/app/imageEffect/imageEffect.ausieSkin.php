<?php
	/**
	 * eumshop app - imageEffect - ausieSkin
	 *
	 * 이미지에 마우스가 들어가면, 선택된 이미지가 변합니다.
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/home/shop_eng/www/web/app/imageEffect/imageEffect.ausieSkin.php
	 * @manual		menuType=app&mode=imageEffect&skin=ausieSkin
	 * @history
	 *				2014.05.13 kim hee sung - 개발 완료
	 */

	/**
	 * app id
	 */
	if(!$strAppID):
		$intAppID				= $intAppID + 1; 
		$strAppID				= "IMAGE_EFFECT_{$intAppID}";
	endif;

	/**
	 * script 설정
	 **/
	$aryScript[] = "/common/js/app/imageEffect/imageEffect.ausieSkin.js";
	$aryScriptEx[] = "/common/js/app/imageEffect/imageEffect.ausieSkin.js";


?>
<!-- eumshop app - imageEffect - ausieSkin (<?php echo $strAppID?>) -->
<?php if($strMenuType == "app"):?>
<style>
	#<?php echo $strAppID?> ul {width:300px}
	#<?php echo $strAppID?> .item {width:100px;height:100px;position:relative;overflow:hidden;float:left;}
	#<?php echo $strAppID?> .item img {width:100px;height:100px;border:1px solid;}
	#<?php echo $strAppID?> .item-up {width:100px;height:100px;position:absolute;top:-100px;-ms-filter:alpha(opacity=0);filter:alpha(opacity=0);-moz-opacity:0.0;opacity:0.0;}
	#<?php echo $strAppID?> .item-down {width:100px;height:100px;position:absolute;top:100px;-ms-filter:alpha(opacity=0);filter:alpha(opacity=0);-moz-opacity:0.0;opacity:0.0;}
	#<?php echo $strAppID?> .item-left {width:100px;height:100px;position:absolute;left:100px;-ms-filter:alpha(opacity=0);filter:alpha(opacity=0);-moz-opacity:0.0;opacity:0.0;}
	#<?php echo $strAppID?> .item-right {width:100px;height:100px;position:absolute;left:-100px;-ms-filter:alpha(opacity=0);filter:alpha(opacity=0);-moz-opacity:0.0;opacity:0.0;}
</style>
<?php endif;?>
<script>
	G_APP_PARAM['<?php echo $strAppID;?>']							= new Object();
	G_APP_PARAM['<?php echo $strAppID;?>']['MODE']					= "<?php echo $strAppMode;?>";
	G_APP_PARAM['<?php echo $strAppID;?>']['SKIN']					= "<?php echo $strAppSkin;?>"; 
</script>
<?php if($strMenuType == "app"):?>
<div id="<?php echo $strAppID?>">
	<ul>
		<li class="item no-1" t="no-2" effect="item-right" src="http://demo2.eumshop.co.kr/upload/product/20130619/prodImg2/2013061900004.jpg" href="http://www.naver.com"><img src="http://demo2.eumshop.co.kr/upload/product/20130619/prodImg2/2013061900004.jpg"></li>
		<li class="item no-2" t="no-5" effect="item-down" src="http://demo2.eumshop.co.kr/upload/product/20130619/prodImg2/2013061900004.jpg" href="http://www.eumshop.com"><img src="http://demo2.eumshop.co.kr/upload/product/20130619/prodImg2/2013061900002.jpg"></li>
		<li class="item no-3" t="no-2" effect="item-left" src="http://demo2.eumshop.co.kr/upload/product/20130619/prodImg2/2013061900004.jpg" href="http://demo2.eumshop.co.kr"><img src="http://demo2.eumshop.co.kr/upload/product/20130619/prodImg2/2013061900001.jpg"></li>
		<li class="item no-4" t="no-1" effect="item-right" src="http://demo2.eumshop.co.kr/upload/product/20130619/prodImg2/2013061900004.jpg" href="http://demo1.eumshop.co.kr"><img src="http://sstatic.naver.net/search/img3/h1_naver2.png"></li>
		<li class="item no-5" t="no-2" effect="item-up" src="http://demo2.eumshop.co.kr/upload/product/20130619/prodImg2/2013061900004.jpg" href="http://demo3.eumshop.co.kr"><img src="http://www.eumshop.com/images/common/logo_eumshop.png"></li>
		<li class="item no-6" t="no-3" effect="item-up" src="http://demo2.eumshop.co.kr/upload/product/20130619/prodImg2/2013061900004.jpg" href="http://demo4.eumshop.co.kr"><img src="http://demo2.eumshop.co.kr/upload/layout/20140510184510.jpg"></li>
	</li>
</div>
<?php endif;?>
<!-- eumshop app - imageEffect - ausieSkin (<?php echo $strAppID?>) -->