<?
	# 상품 리스트 / 탑이미지 
	# prodList.topImage.index.inc.php
	## 2013.04.26 다국어 형식으로 변경
	require_once "{$S_DOCUMENT_ROOT}www/classes/image/image.func.class.php";
	$imageFunc				= new ImageFunc();
	$cateWebImgPath			= "/upload/layout/product/top/";
	$cateWebTagPath			= "/layout/topHtml/";
	$policyLng				= strtolower($_REQUEST['policyLng']);
	$s_st_lng				= strtolower($S_ST_LNG);

	if(!$policyLng) { $policyLng = $S_SITE_LNG_PATH; }


?>

<div class="prodTopImgWrap">
	<?
		$strUse			= $S_PRODUCT_TOP_USE_OP;	
		
		if($strUse == "A"):
			// 모든 상품페이지에 한개의 이미지만 적용 : A
			$strImg		= $S_PRODUCT_TOP_IMG;
			$strHtml	= $S_PRODUCT_HTML_IMG;

			if($strImg) :
				$strImg = sprintf("<img src='%s'/>", $strImg);
				echo $strImg;
			endif;
			
			echo $strHtml;

		elseif($strUse == "B"):
			// 카테고리별 이미지 업로드 적용 : B
			$strPageCate = "";
			if($S_PRODUCT_TOP_CAT_OP >= 1):
				$strPageCate	.= $strSearchHCode1; 
				$strImg			 = $S_ARY_CATE_IMG[$strPageCate]['TOP_IMG'];
				$strHtml		 = $S_ARY_CATE_HTML[$strPageCate]['TOP_HTML'];
				$tempHtml		 = "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}{$cateWebTagPath}%s/{$strHtml}";
				if(is_file(sprintf($tempHtml, $policyLng))):
					$strHtml = sprintf($tempHtml, $policyLng);
				elseif(is_file(sprintf($tempHtml, $s_st_lng))):
					$strHtml = sprintf($tempHtml, $s_st_lng);
				else:
					$strHtml = "";
				endif;


				/** 2013.04.26 다국어 버전 추가 **/
				$imgPath		= "{$cateWebImgPath}{$policyLng}/{$strImg}";
				$ext			= $imageFunc->getFindImage("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}{$imgPath}");
				$strImg			= "{$cateWebImgPath}{$s_st_lng}/{$strImg}";
				if($ext):
					$fileInfo	= $imageFunc->getPathInfo($imgPath);
					$strImg		= "{$fileInfo['dirname']}/{$fileInfo['name']}.{$ext}";
				endif;	
				/** 2013.04.26 다국어 버전 추가 **/

				if(is_file("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}{$strImg}")){ $strImgTag = sprintf("<img src='%s'/>", $strImg); }
			endif;

			if($S_PRODUCT_TOP_CAT_OP >= 2):
				$strPageCate	.= $strSearchHCode2;
				$strImg			 = $S_ARY_CATE_IMG[$strPageCate]['TOP_IMG'];
				$strHtml		 = $S_ARY_CATE_HTML[$strPageCate]['TOP_HTML'];
				$tempHtml		 = "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}{$cateWebTagPath}%s/{$strHtml}";
				if(is_file(sprintf($tempHtml, $policyLng))):
					$strHtml = sprintf($tempHtml, $policyLng);
				elseif(is_file(sprintf($tempHtml, $s_st_lng))):
					$strHtml = sprintf($tempHtml, $s_st_lng);
				else:
					$strHtml = "";
				endif;

				/** 2013.04.26 다국어 버전 추가 **/
				$imgPath		= "{$cateWebImgPath}{$policyLng}/{$strImg}";
				$ext			= $imageFunc->getFindImage("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}{$imgPath}");
				$strImg			= "{$cateWebImgPath}{$s_st_lng}/{$strImg}";
				if($ext):
					$fileInfo	= $imageFunc->getPathInfo($imgPath);
					$strImg		= "{$fileInfo['dirname']}/{$fileInfo['name']}.{$ext}";
				endif;		
				/** 2013.04.26 다국어 버전 추가 **/

				if(is_file("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}{$strImg}")){ $strImgTag = sprintf("<img src='%s'/>", $strImg); }
			endif;

			if($S_PRODUCT_TOP_CAT_OP >= 3):
				$strPageCate	.= $strSearchHCode3; 
				$strImg			 = $S_ARY_CATE_IMG[$strPageCate]['TOP_IMG'];
				$strHtml		 = $S_ARY_CATE_HTML[$strPageCate]['TOP_HTML'];
				$tempHtml		 = "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}{$cateWebTagPath}%s/{$strHtml}";
				if(is_file(sprintf($tempHtml, $policyLng))):
					$strHtml = sprintf($tempHtml, $policyLng);
				elseif(is_file(sprintf($tempHtml, $s_st_lng))):
					$strHtml = sprintf($tempHtml, $s_st_lng);
				else:
					$strHtml = "";
				endif;


				/** 2013.04.26 다국어 버전 추가 **/
				$imgPath		= "{$cateWebImgPath}{$policyLng}/{$strImg}";
				$ext			= $imageFunc->getFindImage("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}{$imgPath}");
				$strImg			= "{$cateWebImgPath}{$s_st_lng}/{$strImg}";
				if($ext):
					$fileInfo	= $imageFunc->getPathInfo($imgPath);
					$strImg		= "{$fileInfo['dirname']}/{$fileInfo['name']}.{$ext}";
				endif;	
				/** 2013.04.26 다국어 버전 추가 **/

				if(is_file("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}{$strImg}")){ $strImgTag = sprintf("<img src='%s'/>", $strImg); }
			endif;

			if($S_PRODUCT_TOP_CAT_OP >= 4):
				$strPageCate	.= $strSearchHCode4; 
				$strImg			 = $S_ARY_CATE_IMG[$strPageCate]['TOP_IMG'];
				$strHtml		 = $S_ARY_CATE_HTML[$strPageCate]['TOP_HTML'];
				$tempHtml		 = "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}{$cateWebTagPath}%s/{$strHtml}";
				if(is_file(sprintf($tempHtml, $policyLng))):
					$strHtml = sprintf($tempHtml, $policyLng);
				elseif(is_file(sprintf($tempHtml, $s_st_lng))):
					$strHtml = sprintf($tempHtml, $s_st_lng);
				else:
					$strHtml = "";
				endif;


				/** 2013.04.26 다국어 버전 추가 **/
				$imgPath		= "{$cateWebImgPath}{$policyLng}/{$strImg}";
				$ext			= $imageFunc->getFindImage("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}{$imgPath}");
				$strImg			= "{$cateWebImgPath}{$s_st_lng}/{$strImg}";
				if($ext):
					$fileInfo	= $imageFunc->getPathInfo($imgPath);
					$strImg		= "{$fileInfo['dirname']}/{$fileInfo['name']}.{$ext}";
				endif;	
				/** 2013.04.26 다국어 버전 추가 **/

				if(is_file("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}{$strImg}")){ $strImgTag = sprintf("<img src='%s'/>", $strImg); }
			endif;
			
			if($strImgTag) :
				echo $strImgTag;
			endif;

			if($strHtml):
				include $strHtml;
			endif;
		endif;

	?>
</div>