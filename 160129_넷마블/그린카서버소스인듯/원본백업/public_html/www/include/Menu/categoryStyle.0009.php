<?
	## 작성일 : 2013.08.18
	## 작성자 : kim hee sung
	## 내  용 : 1차 카테고리 선택시 2차 ,3차 카테고리 표시
	##			2차 카테고리 선택시 2차, 3차 카테고리 표시
	##			3차 카테고리 선택시 3차, 4차 카테고리 표시
	##			4차 카테고리 선택시 3차, 3차 카테고리 표시
	## 2014.06.11 kim hee sung - 상품 개수 출력 부분 수정

	## 모듈 설정
	$objProductMgrModule		= new ProductMgrModule($db);

	## 선택된 카테고리 정보
	$cate['lcate']	= $_REQUEST['lcate'];
	$cate['mcate']	= $_REQUEST['mcate'];
	$cate['scate']	= $_REQUEST['scate'];
	$cate['fcate']	= $_REQUEST['fcate'];	

	## 초기화
	$cateKey		= "";
	$sumCode		= "";
	$hrefFmt		= "./?menuType=product&mode=list&lcate=%s&mcate=%s&scate=%s&fcate=%s";
	$category		= $cate['lcate'] . $cate['mcate'] . $cate['scate'] . $cate['fcate'];

	## 선택된 카테고리 배열 키값 정의
	foreach($cate as $name => $code):
		$aryCate	= "";
		$sumCode   .= $code;

		if($name == "lcate")		{ $aryCate	= $S_ARY_CATE1; }
		else if($name == "mcate")	{ $aryCate	= $S_ARY_CATE2[$cateKey['lcate']]; }
		else if($name == "scate")	{ $aryCate	= $S_ARY_CATE3[$cateKey['lcate']][$cateKey['mcate']]; }
		else if($name == "fcate")	{ $aryCate	= $S_ARY_CATE4[$cateKey['lcate']][$cateKey['mcate']][$cateKey['scate']]; }

		foreach($aryCate as $key => $data):
			if($data['CODE'] == $sumCode):
				$cateKey[$name] = $key;
			endif;
		endforeach;
	endforeach;

	## 카테고리 선택에 따른 정보 설정
	if(!$cate['scate']):
		// 2차 3차
		$myCate1 = $S_ARY_CATE2[$cateKey['lcate']];
		$myCate2 = $S_ARY_CATE3[$cateKey['lcate']];
	else:
		// 3차 4차
		$myCate1 = $S_ARY_CATE3[$cateKey['lcate']][$cateKey['mcate']];
		$myCate2 = $S_ARY_CATE4[$cateKey['lcate']][$cateKey['mcate']];
	endif;


?>

<?if(sizeof($myCate1) > 0):?>
<ul class="cate1">
	<?foreach($myCate1 as $key1 => $data1):
		if($myCate1[$key1]['SHARE'] == "Y") { continue; }
		if($myCate1[$key1]['VIEW'] == "N") { continue; }
		$class = "";
				
		## 상품 개수 구하기
		$param = "";
		$param['LNG'] = $S_SITE_LNG;
		$param['UNION_ALL'] = "Y";
		$param['P_WEB_VIEW'] = "Y";
		$param['P_CATE_LIKE'] = $data1['CODE'];
		$intProdCnt = $objProductMgrModule->getProductMgrSelectEx("OP_COUNT", $param);

	  if(substr($category, 0, strlen($data1['CODE'])) == $data1['CODE']) { $class = "selected"; }
	  $href = sprintf($hrefFmt, substr($data1['CODE'], 0, 3), substr($data1['CODE'], 3, 3), substr($data1['CODE'], 6, 3), substr($data1['CODE'], 9, 3));?>
	<li><a href="<?=$href?>" class="<?=$class?> cate_1"><?=$data1['NAME']?><span class="cate_1_cnt">(<?=$intProdCnt?>)</span></a>
		<?if(sizeof($myCate2[$key1]) > 0):?>
		<ul class="cate2">
			<?foreach($myCate2[$key1] as $key2 => $data2):
				if($myCate2[$key1][$key2]['SHARE'] == "Y") { continue; }
				if($myCate2[$key1][$key2]['VIEW'] == "N") { continue; }
				$class = "";

				## 상품 개수 구하기
				$param = "";
				$param['LNG'] = $S_SITE_LNG;
				$param['P_WEB_VIEW'] = "Y";
				$param['UNION_ALL'] = "Y";
				$param['P_CATE_LIKE'] = $data2['CODE'];
				$intProdCnt = $objProductMgrModule->getProductMgrSelectEx("OP_COUNT", $param);

				if(substr($category, 0, strlen($data2['CODE'])) == $data2['CODE']) { $class = "selected"; }
				$href = sprintf($hrefFmt, substr($data2['CODE'], 0, 3), substr($data2['CODE'], 3, 3), substr($data2['CODE'], 6, 3), substr($data2['CODE'], 9, 3));?>
			<li class="cateList_2_<?=$key2?>"><a href="<?=$href?>" class="<?=$class?>"><?=$data2['NAME']?><span>(<?=$intProdCnt?>)</span></a></li>
			<?endforeach;?>
		</ul>
		<?endif;?>
		<div class="clr"></div>
	</li>
	<?endforeach;?>
</ul>
<?endif;?>