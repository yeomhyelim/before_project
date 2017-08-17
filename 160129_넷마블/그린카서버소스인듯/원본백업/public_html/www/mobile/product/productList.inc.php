<?
	/**** 탑 이미지 ****/
//	include "include/prodList.topImage.index.inc.php";

	/**** 서브 카테고리 ****/
	include "include/prodList.subCate.index.inc.php";

	/**** 베스트 상품 ****/
	if($strMode != "search"): 
		$no = 1; include "include/sub.bestList.index.inc.php"; 
//		$no = 2; include "include/sub.bestList.index.inc.php"; 
//		$no = 3; include "include/sub.bestList.index.inc.php"; 
//		$no = 4; include "include/sub.bestList.index.inc.php"; 
//		$no = 5; include "include/sub.bestList.index.inc.php"; 
	endif; 

	/**** 상품 리스트 ****/
	include "include/prodList.index.inc.php";

?>