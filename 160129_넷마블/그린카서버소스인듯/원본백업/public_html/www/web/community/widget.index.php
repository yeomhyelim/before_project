<?
	## STEP 1.
	## 백업
	$postBack			= $_POST;
	$requestBack		= $_REQUEST;
	$strModeBak			= $strMode;
	$strMenuTypeBak		= $strMenuType;
	$includeFileBak		= $includeFile;
	$ub_bc_no			= $_REQUEST['ub_bc_no'];

	## STEP 2.
	## b_code 별 설정 백업
	if(in_array($b_code, array("PROD_REVIEW", "PROD_QNA"))):
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
	$_REQUEST['myTarget']		= "widget";
	$_REQUEST['includeFile']	= "widget";
	$_REQUEST['ub_bc_no']		= $ub_bc_no;

	## STEP 2.
	## b_code 별 설정 복구
	if(in_array($b_code, array("PROD_REVIEW", "PROD_QNA"))):
	$_REQUEST['prodCode']		= $strProdCode;
	endif;
	
	include "{$S_DOCUMENT_ROOT}www/web/community/index.php";

	## STEP 10
	## 복구
	$_POST				= $postBack;
	$_REQUEST			= $requestBack;
	$strMode			= $strModeBak;
	$strMenuType		= $strMenuTypeBak;
	$includeFile		= $includeFileBak;
?>
