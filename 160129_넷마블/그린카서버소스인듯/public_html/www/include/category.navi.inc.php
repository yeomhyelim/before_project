
<?

	$strNaviHtml = "";
	if (IS_ARRAY($S_ARY_CATE1)){
		
		for($i = 0;$i < sizeof($S_ARY_CATE1); $i++){
			$strMainNaviUlStyle = "";
			if ($i == 0) $strMainNaviUlStyle = "style=\"border-top:none;\"";
			$strNaviHtml .= "<ul ".$strMainNaviUlStyle.">";
			$strNaviHtml .= "<li class=\"cateDepth1\">".$S_ARY_CATE1[$i][NAME]."</li>";
			
			if (IS_ARRAY($S_ARY_CATE2[$i])){
				for($j=0;$j<sizeof($S_ARY_CATE2[$i]);$j++){
					$strSpanHtml = "";
					if ($j % 2 == 0) $strSpanHtml = " <span>|</span> ";
					$strNaviHtml .= "<li>";

					$strNaviHtml .= "<a href=\"./?menuType=product&mode=list&lcate=".$S_ARY_CATE1[$i][CODE]."&mcate=".substr($S_ARY_CATE2[$i][$j][CODE],3,3)."\">";
					$strNaviHtml .= $S_ARY_CATE2[$i][$j][NAME]."</a>".$strSpanHtml;
					if ($j % 2 == 1) $strNaviHtml ."</li>";
				}
				if ($j % 2 == 1) $strNaviHtml ."</li>";
			}
			
			$strNaviHtml .= "</ul>";		
		}
	}
	
	//$strNaviHtml = "<div id=\"subLeftNavi\"><div class=\"subCategory\"><img src=\"/himg/navi/tit_category.gif\"/>".$strNaviHtml."<div></div>";
?>
<?=$strNaviHtml?>
<div class="clear"></div>