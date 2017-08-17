<?php
	/**
	 * 작성일		: 2014.04.22
	 * 작성자		: kim hee sung
	 * 내  용		: 상품 카테고리를 ul, li 테그로 감싸고 메뉴형태로 만듭니다.
	 * 참고사항		: 수정을 원하시는 경우 반드시 주석을 작성해주시기 바랍니다.
	 *				  개발 규칙이 있으므로 반드시 개발자에게 문의 바랍니다.
	 * 태그사용업	: menuType=app&mode=productCateMenu&skin=basicSkin&lcate=001&mcate=&scate=&fcate=
	 **/

	/**
	 * 스크립트 설정
	 */
//	$aryScriptEx[]				= "/common/js/tinybox.js";
//	$aryScriptEx[]				= "/common/js/app/productCateMenu/productCateMenu.js";
	$aryScriptEx[]				= "/common/js/app/productCateMenu/productCateMenuBasicSkin.js";
	
	/**
	 * app id
	 */
	if(!$strAppID):
		$intAppID				= $intAppID + 1; 
		$strAppID				= "PRODUCT_CATE_MENU_{$intAppID}";
	endif;

	## 기본 설정
	$strAppSelectCate1			= $EUMSHOP_APP_INFO['lcate'];
	$strAppSelectCate2			= $EUMSHOP_APP_INFO['mcate'];
	$strAppSelectCate3			= $EUMSHOP_APP_INFO['scate'];
	$strAppSelectCate4			= $EUMSHOP_APP_INFO['fcate'];
	if($strAppSelectCate1 == "get") { $strAppSelectCate1 = $_GET['lcate']; }
	if($strAppSelectCate2 == "get") { $strAppSelectCate2 = $_GET['mcate']; }
	if($strAppSelectCate3 == "get") { $strAppSelectCate3 = $_GET['scate']; }
	if($strAppSelectCate4 == "get") { $strAppSelectCate4 = $_GET['fcate']; }
	$strAppSelectCate			= $strAppSelectCate1 . $strAppSelectCate2 . $strAppSelectCate3 . $strAppSelectCate4;

	## 카테고리 정보 불러오기
	include_once SHOP_HOME . "/conf/category.{$S_SITE_LNG_PATH}.inc.php";
?>
<style>
/**
	#<?php echo $strAppID;?> .cate2-wrap {display:none}
	#<?php echo $strAppID;?> .cate1-li-selected .cate2-wrap {display:block}
**/
</style>
<script>
	G_APP_PARAM['<?php echo $strAppID;?>']					= new Object();
	G_APP_PARAM['<?php echo $strAppID;?>']['MODE']			= "<?php echo $strAppMode;?>";
	G_APP_PARAM['<?php echo $strAppID;?>']['SKIN']			= "<?php echo $strAppSkin;?>";
	G_APP_PARAM['<?php echo $strAppID;?>']['SELECT_CATE']	= "<?php echo $strAppSelectCate;?>";
	G_APP_PARAM['<?php echo $strAppID;?>']['S_ARY_CATE1']	= <?php echo json_encode($S_ARY_CATE1);?>;
	G_APP_PARAM['<?php echo $strAppID;?>']['S_ARY_CATE2']	= <?php echo json_encode($S_ARY_CATE2);?>;
	G_APP_PARAM['<?php echo $strAppID;?>']['S_ARY_CATE3']	= <?php echo json_encode($S_ARY_CATE3);?>;
	G_APP_PARAM['<?php echo $strAppID;?>']['S_ARY_CATE4']	= <?php echo json_encode($S_ARY_CATE4);?>;
</script>
<div id="<?php echo $strAppID;?>"></div>