<?
	# 탑 이미지 파일 생성
	# topMakeFile.php
?>


<?
	
	$designSetMgr->setC_LEVEL(1);
	$designSetMgr->setC_HCODE("");
	$designSetMgr->setC_VIEW_YN("");
	$aryCate01 = $designSetMgr->getCateLevelAry($db);
	
	$strConfCateList = "";
	if (is_array($aryCate01)):
		foreach($aryCate01 as $cate01):
			echo $cate01['CATE_CODE'];

		endforeach;

	endif;

?>