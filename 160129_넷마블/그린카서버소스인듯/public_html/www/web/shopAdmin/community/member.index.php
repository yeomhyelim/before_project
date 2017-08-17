<?
	## STEP 1.
	## 백업
	$postBack			= $_POST;
	$requestBack		= $_REQUEST;
	$strModeBak			= $strMode;
	$strMenuTypeBak		= $strMenuType;
	$includeFileBak		= $includeFile;

	## STEP 2.
	## b_code 별 설정 백업
	if(in_array($b_code, "PROD_REVIEW", "PROD_QNA")):
	$strProdCode		= $_REQUEST['prodCode'];
	endif;

	## STEP 3
	## 설정
	$strMode					= "";
	$strMenuType				= "community";
	$_POST						= "";
	$_REQUEST					= "";
	$_REQUEST['mode']			= "";
	$_REQUEST['act']			= "";
	$_REQUEST['menuType']		= "community";
	$_REQUEST['b_code']			= $b_code;
	$_REQUEST['ub_m_no']		= $ub_m_no;
	$_REQUEST['myTarget']		= "member";
//	$_REQUEST['includeFile']	= "widget";

	include "{$S_DOCUMENT_ROOT}www/web/shopAdmin/community/index.php";

	## STEP 10
	## 복구
	$_POST				= $postBack;
	$_REQUEST			= $requestBack;
	$strMode			= $strModeBak;
	$strMenuType		= $strMenuTypeBak;
	$includeFile		= $includeFileBak;
?>
