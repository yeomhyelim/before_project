<?
	if (is_array($aryTopMenu)){
		for($intTopMnNo = 0;$intTopMnNo<sizeof($aryTopMenu);$intTopMnNo++){
			
			$strTopMenuMouseOver = $strTopMenuMouseOut = "";
			if ($aryTopMenu[$intTopMnNo][CATE_IMG2]){
				$strTopMenuMouseOver = "onmouseover=\"cateMouseOverOut(this,'/upload/category/".$aryTopMenu[$intTopMnNo][CATE_IMG2]."')\"";
				$strTopMenuMouseOut = "onmouseout=\"cateMouseOverOut(this,'/upload/category/".$aryTopMenu[$intTopMnNo][CATE_IMG1]."')\"";
			}

			if ($aryTopMenu[$intTopMnNo][CATE_IMG1]){
				$strTopMenu  = "<img src=\"/upload/category/".$aryTopMenu[$intTopMnNo][CATE_IMG1]."\" "; 
				$strTopMenu .= $strTopMenuMouseOver." ".$strTopMenuMouseOut.">";
			} else {
				$strTopMenu = $aryTopMenu[$intTopMnNo][CATE_NAME];
			}

			echo "<a href=\"./?menuType=product&mode=list&lcate=".$aryTopMenu[$intTopMnNo][CATE_CODE]."\" class=\"mn1\">".$strTopMenu."</a>";
		}
	}
?>