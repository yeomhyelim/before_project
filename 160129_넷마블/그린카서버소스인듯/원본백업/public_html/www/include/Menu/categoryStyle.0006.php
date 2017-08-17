<?
	if($S_PRODUCT_SUB_CATE_USE == "Y"): // 디자인리, 카테고리 사용하는 경우 

		## STEP 1.
		## 상품 관련 글래스 선언
		require_once MALL_CONF_LIB."ProductMgr.php";
		$productMgr		= new ProductMgr();

		## STEP 1.
		## 설정
		include_once "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/category.{$S_SITE_LNG_PATH}.inc.php";
		
		$lcate = $_REQUEST['lcate'];
		$mcate = $_REQUEST['mcate'];
		$scate = "";
		$fcate = "";

		$key1 = 0;
		$key2 = 0;

		## STEP 2.
		## 1차 카테고리 정보
		$cate1Cnt = sizeof($S_ARY_CATE1);
		for($i=0;$i<$cate1Cnt;$i++):
			if(!$lcate) { $lcate = $S_ARY_CATE1[$i]['CODE']; }
			if($S_ARY_CATE1[$i]['CODE'] != $lcate) { continue; }	
			$key1	= $i;
			break;
		endfor;

		## STEP 3.
		## 2차 카테고리 정보
		$cate2Cnt = sizeof($S_ARY_CATE2[$key1]);
		for($j=0;$j<$cate2Cnt;$j++):
			if(!$mcate) { $mcate = substr($S_ARY_CATE2[$key1][$j]['CODE'], 3, 6); }
			if($S_ARY_CATE2[$key1][$j]['CODE'] != $lcate.$mcate) { continue; }	
			$key2 = $j;
			break;
		endfor;

		## STEP 4.
		## 3차 카테고리 정보

		$cate3Cnt = sizeof($S_ARY_CATE3[$key1][$key2]);
		for($k=0;$k<$cate3Cnt;$k++):
			$scate		= substr($S_ARY_CATE3[$key1][$key2][$k]['CODE'], 6, 9);
			$href		= "./?menuType=product&mode=list&lcate={$lcate}&mcate={$mcate}&scate={$scate}&fcate={$fcate}";
			$productMgr->setP_CATE("{$lcate}{$mcate}{$scate}{$fcate}");
			$prodCnt	= $productMgr->getProductCateTotal($db); 
			if($k==0):
				echo "<div class='prodSubTopNavi'>\n";
				echo "  <ul>\n";
			endif;
			echo "    <li><a href='{$href}'>{$S_ARY_CATE3[$key1][$key2][$k]['NAME']}<span>({$prodCnt})</span></a></li>\n";
			if($k==($cate3Cnt-1)):
				echo "  </ul>\n";
				echo "</div>\n";
			endif;
		endfor;

	endif;
?>

