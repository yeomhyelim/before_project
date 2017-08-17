<?

	if($boardMgr):
		$boardMgr->setB_GRP_NO($intBG_NO_EX);
		$boardListResult	= $boardMgr->getBoardList($db);
		if(is_array($boardListResult)):
			echo "<ul>";
			$strAHref			= "<li><a href=\"./?menuType=board&mode=list&bCode=%s\"%s>%s</a></li>";
			foreach($boardListResult as $row):
				$selectedNavi = ($row['B_CODE'] == $strB_CODE) ? " class=\"selectedNavi\"" : "";
				echo sprintf($strAHref, $row['B_CODE'], $selectedNavi, $row['B_TITLE']);	
			endforeach;
			echo "</ul>";
		endif;
	endif;
?>