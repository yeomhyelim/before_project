<?php
	/**
	 * eumshop app - login
	 *
	 * 로그인 폼입니다.
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource
	 * @manual		&mode=login
	 * @history
	 *				2013.12.30 kim hee sung - 개발 완료
	 */

	/**
	 * app id
	 */
	$intAppID					= $intAppID + 1;
	$strAppID					= "POPUP_{$intAppID}";
//	$strAppID					= "APP_ID_{$intAppID}";

	/**
	 * 모듈 설정
	 */
	$objPopupMgrModule			= new PopupMgrModule($db);

	/**
	 * 기본 설정
	 */
	$intPoNo					= $_GET['po_no'];
	$strDefaultDir				= SHOP_HOME . "/upload/popup";
	$strWebDir					= "/upload/popup";

	/**
	 * 기본 설정 체크
	 */
	if(!$intPoNo) { exit; }

	/**
	 * 데이터 불러오기
	 */
	$aryParam							= "";
	$aryParam['PO_NO']					= $intPoNo;
	$aryPopupRow						= $objPopupMgrModule->getPopupMgrSelectEx("OP_SELECT", $aryParam);
	$strPoFile							= $aryPopupRow['PO_FILE'];
	$strPoLink							= $aryPopupRow['PO_LINK'];
	$strPoLinkType						= $aryPopupRow['PO_LINK_TYPE'];

	 /**
	  * 이미지 설정
	  */
	$strImageFile						= $strPoFile;
	if($strImageFile) { $strImageFile	= "{$strWebDir}/{$strImageFile}"; }

	## 해더 include
	include MALL_HOME . "/include/header.inc.php";
?>
<body>
<?if($strImageFile):?>
	<?if($strPoLinkType):?><a href="<?=$strPoLink?>" target="<?=$strPoLinkType?>"><?endif;?>
	<img src="<?=$strImageFile?>">
	<?if($strPoLinkType):?></a><?endif;?>
	<div class="closeBar">
		<a href="javascript:goPopupCloseActEvent('<?=$intPoNo?>')"><?=$LNG_TRANS_CHAR["CW00076"];//오늘 하루 이 창을 열지 않음?></a>
		<a href="javascript:self.close();">X</a>
	</div>
<?endif;?>
</body>
</html>
