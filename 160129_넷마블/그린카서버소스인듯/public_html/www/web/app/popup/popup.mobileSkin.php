<?php
	/**
	 * eumshop app - popup - defaultSkin
	 *
	 * 팝업창 실행하기
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/www/web/app/popup/popup.defaultSkin.php
	 * @manual		menuType=app&mode=popup
	 * @history
	 *				2013.12.30 kim hee sung - 개발 완료
	 */

	## app id
	if(!$strAppID):
		$intAppID				= $intAppID + 1;
		$strAppID				= "POPUP_{$intAppID}";
	endif;

	## 모듈 설정
	$objPopupMgrModule					= new PopupMgrModule($db);

	## 스크립트 설정
	$aryScriptEx[]						= "/common/js/app/popup/popup.defaultSkin.js";

	## 기본 설정
	$strDefaultDir						= MALL_SHOP . "/upload/popup";
	$strWebDir							= "/upload/popup";

	## 데이터 불러오기
	$aryParam							= "";
	$aryParam['PO_USE']					= "Y";
	$aryParam['PO_LANG_LIKE']			= $S_SITE_LNG;
	$aryParam['START_END_BETTEN']		= "Y";

	/*
	2015.03.18 bdcho
	:팝업창 구분(웹/모바일)
	;모바일 여부 추가
	{{
	*/	
	$aryParam['IS_MOBILE']				= "Y";
	/*
	}}
	2015.03.18 bdcho
	:팝업창 구분(웹/모바일)
	*/

	$aryPopup							= $objPopupMgrModule->getPopupMgrSelectEx("OP_ARYTOTAL", $aryParam);
?>
<!-- eumshop app - popup - defaultSkine (<?php echo $strAppID?>) -->
<script>
	G_APP_PARAM['<?php echo $strAppID;?>']							= new Object();
	G_APP_PARAM['<?php echo $strAppID;?>']['MODE']					= "<?php echo $strAppMode;?>";
	G_APP_PARAM['<?php echo $strAppID;?>']['SKIN']					= "<?php echo $strAppSkin;?>";
</script>
<div id="<?php echo $strAppID?>">
<?php
	foreach($aryPopup as $key => $data):

		## 기본 설정
		$intPoNo		= $data['PO_NO'];
		$strPoTitle		= $data['PO_TITLE'];
		$strPoStyle		= $data['PO_STYLE'];
		$strPoFile		= $data['PO_FILE'];
		$intPoTop		= $data['PO_TOP'];
		$intPoLeft		= $data['PO_LEFT'];
		$strPoLink		= $data['PO_LINK'];
		$strPoLinkType	= $data['PO_LINK_TYPE'];

		## 이미지 설정
		$strImageFile						= $strPoFile;
		if($strImageFile) { $strImageFile	= "{$strWebDir}/{$strImageFile}"; }

		## 쿠키 체크
		if($_COOKIE["POPUP_{$intPoNo}"]) { continue; }

		## 이미지 사이즈 설정
		list($width, $height)	= getimagesize("{$strDefaultDir}/{$strPoFile}");

		## href 설정
		$strHref				= "./?menuType=app&mode=popup&act=popupView&po_no={$intPoNo}";
?>
<?php if($strPoStyle == "layer"): // 레이어팝업?>
	<div id="dialog_<?=$intPoNo?>" title="<?=$strPoTitle?>" width="<?=$width?>" height="<?=$height?>" top="<?=$intPoTop?>" left="<?=$intPoLeft?>">
		<?if($strImageFile):?>
			<?if($strPoLinkType):?><a href="<?=$strPoLink?>" target="<?=$strPoLinkType?>"><?endif;?>
			<img src="<?=$strImageFile?>">
			<?if($strPoLinkType):?></a><?endif;?>
			<div class="closeBar">
				<a href="javascript:goPopupDefaultSkinCloseActEvent('<?php echo $strAppID;?>','<?php echo $intPoNo;?>', true)"><?=$LNG_TRANS_CHAR["CW00050"];//오늘하루 열지 않음?></a>
				<a href="javascript:goPopupDefaultSkinCloseActEvent('<?php echo $strAppID;?>','<?php echo $intPoNo;?>', false)">X</a>
			</div>
		<?endif;?>
	</div>
<?php else: // 일반팝업?>
<script>window.open("<?=$strHref?>","<?=$strPoTitle?>","width=<?=$width+25?>,height=<?=$height+25?>,left=<?=intPoLeft?>,top=<?=$intPoTop?>");</script>
<?php endif;?>
<?php endforeach;?>
</div>
<!-- eumshop app - popup - defaultSkin (<?php echo $strAppID?>) -->

