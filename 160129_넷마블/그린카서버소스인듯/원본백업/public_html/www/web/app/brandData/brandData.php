<?php
	/**
	 * eumshop app - brandData 
	 *
	 * 상품 브랜드 리스트 출력 앱입니다.
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/www/web/app/brandData/brandData.php
	 * @manual		mode=brandData&key=브랜드설명&pr_no=1
	 * @history
	 *				2014.05.30 kim hee sung - 개발 완료
	 */

	/**
	 * app id
	 */
	if(!$strAppID):
		$intAppID				= $intAppID + 1; 
		$strAppID				= "BRAND_DATA_{$intAppID}";
	endif;


	/**
	 * 기본 정보
	 */
	$strAppKey					= $EUMSHOP_APP_INFO['key'];

	switch($strAppKey):

	case "브랜드설명":

		## 모듈 설정
		$objProductBrandModule = new ProductBrandModule($db);

		## 기본설정
		$intAppPR_NO			= $EUMSHOP_APP_INFO['pr_no'];
		if($intAppPR_NO == "get") { $intAppPR_NO = $_GET['pr_no']; }
		if(!is_numeric($intAppPR_NO)) { $intAppPR_NO = $_GET[$intAppPR_NO]; }
		if(!$intAppPR_NO) { break; }

		## 데이터 불어오기
		$param = "";
		$param['PR_NO'] = $intAppPR_NO;
		$param['JOIN_PBL'] = "Y";
		$aryAppRow = $objProductBrandModule->getProductBrandSelectEx("OP_SELECT", $param);
		$strAppPL_PR_HTML = $aryAppRow['PL_PR_HTML'];
		if(!$aryAppRow) { break; }

		echo $strAppPL_PR_HTML;

	break;

	endswitch;

