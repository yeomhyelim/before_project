<?
	# 브랜드 상품 리스트 / 탑이미지 
	# brandList.topImage.index.inc.php
?>


<?
	$strUse				= $S_BRAND_LIST_TOP_USE_OP;	

	$intPR_NO			= $_POST["pr_no"]			? $_POST["pr_no"]			: $_REQUEST["pr_no"];

	if($strUse == "A"):
		// 모든 상품페이지에 한개의 이미지만 적용 : A
		$strImg		= $S_BRAND_LIST_TOP_IMG;
		$strHtml	= $S_BRAND_LIST_TOP_HTML;

		if($strImg) :
			$strImg = sprintf("<img src='%s'/>", $strImg);
			echo $strImg;
		endif;
		
		if($strHtml):
			include $strHtml;
		endif;

	elseif($strUse == "B"):
		// 카테고리별 이미지 업로드 적용 : B
		$strPageCate	= $strSearchHCode1.$strSearchHCode2.$strSearchHCode3.$strSearchHCode4;
		$strImg			= $S_ARY_CATE_IMG[$strPageCate]['TOP_IMG'];
		$strHtml		= $S_ARY_CATE_HTML[$strPageCate]['TOP_HTML'];

		if($strImg) :
			$strImg = sprintf("<img src='%s'/>", $strImg);
			echo $strImg;
		endif;

		echo $strHtml;
	endif;

?>