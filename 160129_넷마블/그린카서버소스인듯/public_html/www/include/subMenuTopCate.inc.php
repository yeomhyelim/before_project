<?
	$strSubMenuTopImg = "";
	if ($strMenuType == "product") :
		if ($S_PRODUCT_SUB_CATE_USE != "N") :
			if( $S_PRODUCT_SUB_CATE_VIEW >= 1 ) :
				if (IS_ARRAY($S_ARY_CATE1)) :
					for($i = 0;$i < sizeof($S_ARY_CATE1); $i++):
						if($S_ARY_CATE1[$i]['CODE'] == $strSearchHCode1) :
							echo sprintf("<a href=\"./?menuType=product&mode=list&lcate=%s&mcate=\">%s</a>", $S_ARY_CATE1[$i][CODE], $S_ARY_CATE1[$i]['NAME']);
							if( $S_PRODUCT_SUB_CATE_VIEW >= 2 ) :
								if (IS_ARRAY($S_ARY_CATE2[$i])):
									echo " => ";	
									for($j=0;$j<sizeof($S_ARY_CATE2[$i]);$j++) :
										echo sprintf("<a href=\"./?menuType=product&mode=list&lcate=%s&mcate=%s\">%s</a>", $S_ARY_CATE1[$i][CODE], substr($S_ARY_CATE2[$i][$j][CODE],3,3), $S_ARY_CATE2[$i][$j]['NAME']);
										echo (($j + 1) < sizeof($S_ARY_CATE2[$i])) ? " | " : "";
									endfor;
								endif;
							endif;
						endif;
					endfor;
				endif;
			endif;
		endif;
	endif;
?>

