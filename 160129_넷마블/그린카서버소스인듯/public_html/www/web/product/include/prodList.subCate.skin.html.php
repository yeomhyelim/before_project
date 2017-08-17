<?
	# 상품리스트 / 선택 카테고리 사용 (S)
	# prodList.subCate.skin.S.html.php

	## 상품 개수 표시
	if($PRODUCT_SUBMENU_PRODUCT_COUNT_USE == "Y"):
		require_once MALL_CONF_LIB."ProductMgr.php";
		$productMgr				= new ProductMgr();
		$param					= "";
		$param['CATE_SUBSTR']	= "6";
		$aryCate2Total			= $productMgr->getProdTotalGroupbyCateEx($db, "OP_ARYLIST", $param);
	endif;

?>
<?
	if(is_array($aryCate1List)):	
		$strImgSrc1		= "<img src='%s' />";
		$strImgSrc2		= "<img src='%s' onmouseout=\"cateMouseOverOut(this,'%s');\" onmouseover=\"cateMouseOverOut(this,'%s');\"/>";
		$strPageHref	= "<a href='?menuType=product&mode=list&lcate=%s&mcate=%s&scate=%s&fcate=%s'%s>%s</a>";
		echo "<div class=\"prodSubCateWrap\"><ul>";
		foreach($aryCate1List as $cateList1):
			// 1차 카테고리 출력
			$lcate = $cateList1['CATE_CODE'];
			echo "<li>";
			if($strCate1Mode == "I"):	
				if($cateList1['CATE_IMG1']):
					if($cateList1['CATE_IMG2']):
						$cateList1['CATE_NAME'] = sprintf($strImgSrc2, $cateList1['CATE_IMG1'], $cateList1['CATE_IMG2'], $cateList1['CATE_IMG1']);
					else:
						$cateList1['CATE_NAME'] = sprintf($strImgSrc1, $cateList1['CATE_IMG1']);
					endif;
				endif;
			endif;
			$selected	= ($strSearchHCode1 == $lcate) ? " class=\"selected\"" : "";
			echo sprintf($strPageHref, $lcate, $mcate, $scate, $fcate, $selected, $cateList1['CATE_NAME']);
			if(is_array($aryCate2List)):
				foreach($aryCate2List as $cateList2):
					// 2차 카테고리 출력
					if($lcate == $cateList2['CATE_HCODE']):
						$mcate = $cateList2['CATE_CODE'];
						echo "<li>";
						if($strCate2Mode == "I"):	
							if($cateList2['CATE_IMG1']):
								if($cateList2['CATE_IMG2']):
									$cateList2['CATE_NAME'] = sprintf($strImgSrc2, $cateList2['CATE_IMG1'], $cateList2['CATE_IMG2'], $cateList2['CATE_IMG1']);
								else:
									$cateList2['CATE_NAME'] = sprintf($strImgSrc1, $cateList2['CATE_IMG1']);
								endif;
							endif;
						endif;
						$selected	= ($strSearchHCode2 == $mcate) ? " class=\"selected\"" : "";
						echo sprintf($strPageHref, $lcate, $mcate, $scate, $fcate, $selected, $cateList2['CATE_NAME']);
						echo "</li>";
					endif;
				endforeach;
			endif;
			echo "</li>";
		endforeach;
		echo "</ul></div>";
	elseif(is_array($aryCate2List)):
		if($strSearchHCode1):
			$lcate				= $strSearchHCode1;
			$strImgSrc1			= "<img src='%s' />";
			$strImgSrc2			= "<img src='%s' onmouseout=\"cateMouseOverOut(this,'%s');\" onmouseover=\"cateMouseOverOut(this,'%s');\"/>";
			$strPageHref		= "<a href='?menuType=product&mode=list&lcate=%s&mcate=%s&scate=%s&fcate=%s'%s>%s%s</a>";
		//	print_r($aryCate2List);
			$lastCateList2		= "";
			$isCateList2		= "N";
			foreach($aryCate2List as $cateList2):
				if($lcate == $cateList2['CATE_HCODE']):
					$lastCateList2	= $cateList2;
					$isCateList2	= "Y";
				endif;
			endforeach;
			if ($isCateList2 == "Y"){echo "<div class=\"prodSubCateWrap\"><ul>";}
			foreach($aryCate2List as $cateList2):
				// 2차 카테고리 출력
				if($lcate == $cateList2['CATE_HCODE']):
					$mcate = $cateList2['CATE_CODE'];
					echo "<li>";
					if($strCate2Mode == "I"):	
						if($cateList2['CATE_IMG1']):
							if($cateList2['CATE_IMG2']):
								$cateList2['CATE_NAME'] = sprintf($strImgSrc2, $cateList2['CATE_IMG1'], $cateList2['CATE_IMG2'], $cateList2['CATE_IMG1']);
							else:
								$cateList2['CATE_NAME'] = sprintf($strImgSrc1, $cateList2['CATE_IMG1']);
							endif;
						endif;
					endif;
					$selected	= ($strSearchHCode2 == $mcate) ? " class=\"selected\"" : "";
					if($lastCateList2['CATE_CODE'] == $cateList2['CATE_CODE']):
						if($selected)	{ $selected = " class=\"selected endNav\""; }
						else			{ $selected = " class=\"endNav\""; }
					endif;					
					$cateCodeCnt	= "";
					if($PRODUCT_SUBMENU_PRODUCT_COUNT_USE == "Y"):
						// 카테고리별 상품 개수 사용 하는 경우.
						$cateCode		= $lcate.$mcate.$scate.$fcate;
						$cateCodeCnt	= "(<span class='cntProd'>{$aryCate2Total[$cateCode]}</span>)";
					endif;
					echo sprintf($strPageHref, $lcate, $mcate, $scate, $fcate, $selected, $cateList2['CATE_NAME'], $cateCodeCnt);
					echo "</li>";
				endif;
			endforeach;
			if ($isCateList2 == "Y"){ echo "</ul></div>";}
		endif;
	elseif(is_array($aryCate3List)):
		// 3차 카테고리 출력

		$strHtml = "";
		$strCate1 = $_GET['lcate'];
		$strCate2 = $_GET['mcate'];
		$strCate3 = $_GET['scate'];
		$strCate4 = $_GET['fcate'];
		foreach($aryCate3List as $cateList3):
			
			## 기본 설정
			$strCATE_CODE = $cateList3['CATE_CODE'];
			$strCATE_VIEW_YN = $cateList3['CATE_VIEW_YN'];
			$strCATE_NAME = $cateList3['CATE_NAME'];
			$strCATE_SHARE = $cateList3['CATE_SHARE'];
			$strCATE_IMG1= $cateList3['CATE_IMG1'];
			$strCATE_IMG2 = $cateList3['CATE_IMG2'];
			$strCATE_HCODE = $cateList3['CATE_HCODE'];
			$strHCate1 = substr($strCATE_HCODE, 0, 3);
			$strHCate2 = substr($strCATE_HCODE, 3, 3);

			## 체크
			if($strHCate1 != $strCate1) { continue; }
			if($strHCate2 != $strCate2) { continue; }
			if($strCATE_VIEW_YN != "Y") { continue; } // 출력여부
			if($strCATE_SHARE == "Y") { continue; } // 쉐어카테고리 여부

			## 메뉴명설정
			$strMenu = $strCATE_NAME;
			if($strCATE_IMG1) { $strMenu = "<img src='{$strCATE_IMG1}' />"; }
			if($strCATE_IMG1 && $strCATE_IMG2) { $strMenu = "<img src='{$strCATE_IMG1}' onmouseout=\"cateMouseOverOut(this,'{$strCATE_IMG2}');\" onmouseover=\"cateMouseOverOut(this,'{$strCATE_IMG1}');\"/>"; }
			
			## 링크 설정
			$strMenu = "<a href='?menuType=product&mode=list&lcate={$strCate1}&mcate={$strCate2}&scate={$strCATE_CODE}'>{$strMenu }</a>";

			## 만들기
			$strHtml .= "<li>{$strMenu}</li>";

		endforeach;

		## 출력
		echo "<div class='prodSubCateWrap'><ul>{$strHtml}</ul></div>";

	elseif(is_array($aryCate4List)):
		if($strSearchHCode1):
			$lcate			= $strSearchHCode1;
			$strImgSrc1		= "<img src='%s' />";
			$strImgSrc2		= "<img src='%s' onmouseout=\"cateMouseOverOut(this,'%s');\" onmouseover=\"cateMouseOverOut(this,'%s');\"/>";
			$strPageHref	= "<a href='?menuType=product&mode=list&lcate=%s&mcate=%s&scate=%s&fcate=%s'%s>%s</a>";
			echo "<div class=\"prodSubCateWrap\"><ul>";
			$mcate = substr($cate3,3,3);
			$scate = $cate3;
			
			foreach($aryCate4List as $cateList4):
				// 4차 카테고리 출력
				if($scate == $cateList4['CATE_HCODE']):
					$fcate = $cateList4['CATE_CODE'];
					echo "<li>";
					if($strCate4Mode == "I"):	
						if($cateList4['CATE_IMG1']):
							if($cateList4['CATE_IMG2']):
								$cateList4['CATE_NAME'] = sprintf($strImgSrc2, $cateList4['CATE_IMG1'], $cateList4['CATE_IMG2'], $cateList4['CATE_IMG1']);
							else:
								$cateList4['CATE_NAME'] = sprintf($strImgSrc1, $cateList4['CATE_IMG1']);
							endif;
						endif;
					endif;
					$selected	= ($strSearchHCode4 == $fcate) ? " class=\"selected\"" : "";
					
					echo sprintf($strPageHref, $lcate, $mcate, substr($scate,6), $fcate, $selected, $cateList4['CATE_NAME']);
					echo "</li>";
				endif;
			endforeach;
			echo "</ul></div><div class=\"clr\"></div>";
		endif;
	endif;



?>