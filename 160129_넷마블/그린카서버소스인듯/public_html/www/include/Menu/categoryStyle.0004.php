
<?
	$cate1		= $_REQUEST['lcate'];
	$cate2		= $_REQUEST['mcate'];
	$cate3		= $_REQUEST['scate'];
	$cate4		= $_REQUEST['fcate'];

	$title		= "";
	$aryCate	= "";

	if($cate1):
		$strLevel = 1;
		foreach($S_ARY_CATE1 as $no => $data):
			if($data['CODE'] == $cate1):
				$cate1No	= $no;
				$title		= $data['NAME'];
			endif;
		endforeach;
		$aryCate	= $S_ARY_CATE2[$cate1No];
	endif;
	if($cate2):
		$strLevel = 2;
		foreach($S_ARY_CATE2[$cate1No] as $no => $data):
			if($data['CODE'] == $cate1.$cate2):
				$cate2No	= $no;
				$title		= $data['NAME'];
			endif;
		endforeach;
		$aryCate	= $S_ARY_CATE3[$cate1No][$cate2No];
	endif;
	if($cate3):
		$strLevel = 3;
		foreach($S_ARY_CATE3[$cate1No][$cate2No] as $no => $data):
			if($data['CODE'] == $cate1.$cate2.$cate3):
				$cate3No	= $no;
				$title		= $data['NAME'];
			endif;
		endforeach;
		$aryCate = $S_ARY_CATE4[$cate1No][$cate2No][$cate3No];
	endif;
	if($cate4):
		$strLevel = 4;
	endif;

	$hrefFmt = "./?menuType=product&mode=list&lcate={$cate1}&mcate={$cate2}&scate={$cate3}&fcate={$cate4}";
	
?>
<ul class="cate1">
	<li class="mn1"><h4><a href="<?=$hrefFmt?>"><?=$title?></a></h4>
		<ul class="cate2">
		<?foreach($aryCate as $key => $data):
			$selected = "";
			$cate[0] = substr($data['CODE'], 0, 3);
			$cate[1] = substr($data['CODE'], 3, 3);
			$cate[2] = substr($data['CODE'], 6, 3);
			$cate[3] = substr($data['CODE'], 9, 3);
			if($cate1 == $cate[0] && $cate2 == $cate[1] && $cate3 == $cate[2] && $cate4 == $cate[3]) { $selected = "selectedNavi"; }
			if($selected) { $selected .= " "; } $selected .= "sub".($key+1);
			$hrefFmt = "./?menuType=product&mode=list&lcate={$cate[0]}&mcate={$cate[1]}&scate={$cate[2]}&fcate={$cate[3]}";
		?>
			<li class="<?=$selected?>"><a href="<?=$hrefFmt?>"><?=$data['NAME']?></a></li>
		<?endforeach;?>
		</ul>
	</li>
</ul>
