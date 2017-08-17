<?
	## 작성일		: 2013.06.14
	## 작성자		: kim hee sung
	## 내  용		: 2차 카테고리 기본, 마우스 오버시 3차 카테고리 출력
	##				  2차 카테고리 클릭시, 해당 3차 카테고리 기본 출력
?>
<script type="text/javascript">
<!--
	$(document).ready(function(){
		$("li#cate2Btn").each(function(){	
			$(this).hover(
				function() {
					$(this).find("ul").css({'display':''});
				}, 
				function() {
					$(this).find("ul").css({'display':'none'});
				}
			);
		});
	});
//-->
</script>
<?
		## STEP 1.
		## 설정
		include_once "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/category.{$S_SITE_LNG_PATH}.inc.php";

		$cate1		= $_REQUEST['lcate'];
		$cate2		= $_REQUEST['mcate'];
		$cate3		= $_REQUEST['scate'];
		$cate4		= $_REQUEST['fcate'];

		if(!$cate1) { $cate1 = "001"; }

		foreach($S_ARY_CATE1 as $no1 => $data1):
			if($data1['CODE'] == $cate1) { break; }
		endforeach;
		
		$size2	= sizeof($S_ARY_CATE2[$no1]);
		$cnt2	= 0;
		foreach($S_ARY_CATE2[$no1] as $no2 => $data2):
			// 2차 카테고리
			$cnt2++;
			$lcate		= $cate1;
			$mcate		= substr($data2['CODE'], 3, 3);
			$scate		= "";
			$fcate		= "";
			$cate2Btn	= ""; if($cate2 != $mcate) { $cate2Btn = " id='cate2Btn'"; }
			$textCate	= $data2['NAME'];
			if($data2['IMG1']) { $textCate = "<img src='{$data2['IMG1']}'>"; }
			if($data2['IMG1'] && $data2['IMG2'] ) { $textCate = "<img src='{$data2['IMG1']}' overImg='{$data2['IMG2']}'>"; }
			$hrefFmt = "./?menuType=product&mode=list&lcate={$lcate}&mcate={$mcate}&scate={$scate}&fcate={$fcate}";
			if($cnt2 == 1) { echo "<ul>\n"; }
			echo "  <li{$cate2Btn}><a href='{$hrefFmt}'>{$textCate}</a>\n";

			$size3	= sizeof($S_ARY_CATE3[$no1][$no2]);
			$cnt3	= 0;
			foreach($S_ARY_CATE3[$no1][$no2] as $no3 => $data3):
				// 3차 카테고리
				$cnt3++;
				$lcate		= $cate1;
				$mcate		= substr($data3['CODE'], 3, 3);
				$scate		= substr($data3['CODE'], 6, 3);
				$fcate		= "";
				$style		= ""; if($cate2 != $mcate) { $style = " style='display:none'"; }
				$textCate	= $data3['NAME'];
				if($data3['IMG1']) { $textCate = "<img src='{$data3['IMG1']}'>"; }
				if($data3['IMG1'] && $data3['IMG2'] ) { $textCate = "<img src='{$data3['IMG1']}' overImg='{$data3['IMG2']}'>"; }
				$hrefFmt = "./?menuType=product&mode=list&lcate={$lcate}&mcate={$mcate}&scate={$scate}&fcate={$fcate}";
				if($cnt3 == 1) { echo "    <ul{$style}>\n"; }
				echo "      <li><a href='{$hrefFmt}'>{$textCate}</a></li>\n";
				if($cnt3 == $size3) { echo "    </ul>\n"; }
			endforeach;
			
			echo "  </li>\n";
			if($cnt2 == $size2) { echo "</ul>\n"; }
		endforeach;
	
?>


		