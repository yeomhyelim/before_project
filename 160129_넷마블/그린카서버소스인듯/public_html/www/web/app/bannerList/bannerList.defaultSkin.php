<?php
	/**
	 * eumshop app - bannerList - defaultSkin
	 *
	 * 움직이는 배너
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/www/web/app/bannerList/bannerList.defaultSkin.php
	 * @manual		&mode=bannerList&skin=defaultSkin&group=19
	 * @history
	 *				2014.06.11 kim hee sung - 개발 완료
	 */

	## app id
	if(!$strAppID):
		$intAppID				= $intAppID + 1; 
		$strAppID				= "BANNER_LIST_{$intAppID}";
	endif;

	## 모듈 설정
	$objAdvertiseMgrModule = new AdvertiseMgrModule($db);
	$objBannerMgrModule = new BannerMgrModule($db);

	## 기본 설정
	$intAppGroupNo				= $EUMSHOP_APP_INFO['group'];
	$strAppLang					= $EUMSHOP_APP_INFO['lang'];
	$strAppBannerDir			= "/upload/banner";
	if(!$intAppGroupNo) { return; }
	if(!$strAppLang) { $strAppLang = $S_SITE_LNG; }

	## 배너그룹 정보 불러오기
	$param = "";
	$param['A_NO'] = $intAppGroupNo;
	$aryBannerGroupList = $objAdvertiseMgrModule->getAdvertiseMgrSelectEx("OP_SELECT", $param);
	$strAppUse = $aryBannerGroupList['A_USE'];
	if(!$aryBannerGroupList) { return; }
	if($strAppUse != "Y") { return; }

	## 데이터 가져오기
	$param = "";
	$param['A_NO'] = $intAppGroupNo;
	$aryBannerList = $objBannerMgrModule->getBannerMgrSelectEx("OP_ARYTOTAL", $param);
	if(!$aryBannerList) { return; }


?>
<!-- eumshop app - bannerList - defaultSkin (<?php echo $strAppID?>) -->
<div id="<?php echo $strAppID?>">
	<ul>
		<?php foreach($aryBannerList as $key => $data):
				## 기본설정
				$isLink = "";
				$strTarget = "";
				$strB_FILE = $data["B_FILE_{$strAppLang}"];
				$strB_LINK_URL = $data["B_LINK_URL_{$strAppLang}"];
				$strB_LINK_TYPE = $data['B_LINK_TYPE']; // 1:새창에서열기, 2:현재창에거열기, 3:팝업으로 열기(지원안됨), 4:링크없음
				if($strB_FILE) { $strB_FILE = "{$strAppBannerDir}/{$strB_FILE}"; }
				if($strB_LINK_TYPE == 1) { $strTarget="_blank"; }
				if($strB_LINK_TYPE == 3) { $strTarget="_blank"; }
				if(in_array($strB_LINK_TYPE, array(1,2,3))) { $isLink = true; }

		?>
		<li><?php if($isLink):?><a href="<?php echo $strB_LINK_URL;?>" target="<?php echo $strTarget;?>"><?php endif;?><img src="<?php echo $strB_FILE;?>"><?php if($isLink):?></a><?php endif;?></li>
		<?php endforeach;?>
	</ul>
	<div class="clr"></div>
</div>
<!-- eumshop app - bannerList - defaultSkin (<?php echo $strAppID?>) -->