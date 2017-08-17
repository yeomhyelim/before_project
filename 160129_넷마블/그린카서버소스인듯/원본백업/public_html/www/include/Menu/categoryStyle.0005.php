<?
	$cateMenu			="";
	$cnt				= 0;
//	$hrefFmt			= "./?menuType=product&mode=list&lcate={$cate1}&mcate={$cate2}&scate={$cate3}&fcate={$cate4}";
	foreach($S_ARY_CATE1 as $no1 => $data1):		
		if($no1 == 0):
			$cateMenu[$cnt]['name']		=  "<ul class='cate1'>\n";
			$cnt++;
		endif;
		if($S_ARY_CATE1[$no1]['SHARE'] == "Y") { continue; } 
		if($S_ARY_CATE1[$no1]['VIEW'] == "N") { continue; } 
		$cate1							= $data1['CODE'];
		$hrefFmt						= "./?menuType=product&mode=list&lcate={$cate1}";
		$cateMenu[$cnt]['name']			=  "  <li class='mn{$no1}'><a href='{$hrefFmt}'>{$data1['NAME']}</a>\n";
		$cnt++;
		if($S_ARY_CATE2 && $S_ARY_CATE2[$no1]):
		foreach($S_ARY_CATE2[$no1] as $no2 => $data2):
			if($no2 == 0):
				$cateMenu[$cnt]['name']		=  "    <ul class='cate2'>\n";
				$cnt++;
			endif;

			if($S_ARY_CATE2[$no1][$no2]['SHARE'] == "Y") { continue; } 
			if($S_ARY_CATE2[$no1][$no2]['VIEW'] == "N") { continue; } 
			$cateMenu[$cnt]['lcate']	=  $data1['CODE'];
			$cate2						=  substr($data2['CODE'], 3);
			$hrefFmt					= "./?menuType=product&mode=list&lcate={$cate1}&mcate={$cate2}";
			$cateMenu[$cnt]['name']		=  "      <li><a href='{$hrefFmt}'>{$data2['NAME']}</a></li>\n";
			$cnt++;

			if($no2+1 == sizeof($S_ARY_CATE2[$no1])):
				$cateMenu[$cnt]['name']		=  "    </ul>\n  </li>\n";
				$cnt++;
			endif;
		endforeach;
		endif;

		if($no1+1 == sizeof($S_ARY_CATE1)):
			$cateMenu[$cnt]['name']		=  "</ul>\n";
			$cnt++;
		endif;
	endforeach;

	foreach($cateMenu as $no => $data):
		echo "{$data['name']}";
	endforeach;
?>