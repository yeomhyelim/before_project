<div class="subNaviWrap">
	<ul>
	<?
		if ( is_array( $S_ARY_CATE1 ) ) :
			for( $intTopMnNo = 0; $intTopMnNo < sizeof( $S_ARY_CATE1 ); $intTopMnNo++ ) :
				$strTopMenuMouseOver		= $strTopMenuMouseOut = "";
				if ( $S_ARY_CATE1[$intTopMnNo][IMG2] ) :
					$strTopMenuMouseOver	= "onmouseover=\"cateMouseOverOut(this,'".$S_ARY_CATE1[$intTopMnNo][IMG2]."')\"";
					$strTopMenuMouseOut		= "onmouseout=\"cateMouseOverOut(this,'".$S_ARY_CATE1[$intTopMnNo][IMG1]."')\"";
				endif;

				if ($S_ARY_CATE1[$intTopMnNo][IMG1] ) :
					$strTopMenu  = "<img src=\"".$S_ARY_CATE1[$intTopMnNo][IMG1]."\" "; 
					$strTopMenu .= $strTopMenuMouseOver." ".$strTopMenuMouseOut.">";
				else :
					$strTopMenu = $S_ARY_CATE1[$intTopMnNo][CATE_NAME];
				endif;

				echo "<li><a href=\"./?menuType=product&mode=list&lcate=".$S_ARY_CATE1[$intTopMnNo][CATE_CODE]."\" class=\"mn1\">".$strTopMenu."</a></li>";
			endfor;
		endif;
	?>
	</ul>
</div>
