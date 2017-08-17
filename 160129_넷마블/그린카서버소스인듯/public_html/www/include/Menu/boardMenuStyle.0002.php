<?
	$strBPath = "{$_REQUEST['S_DOCUMENT_ROOT']}{$_REQUEST['S_SHOP_HOME']}/conf/community/boardList.info.php";
	$strGPath = "{$_REQUEST['S_DOCUMENT_ROOT']}{$_REQUEST['S_SHOP_HOME']}/conf/community/groupList.info.php";

	if(is_file($strBPath) && is_file($strGPath)):
		include $strBPath;
		include $strGPath;
		foreach($GROUP_LIST as $groupKey => $groupList):
			if($groupList['bg_name'] == $s):
				$group = $groupKey;
				break;
			endif;
		endforeach;

		if($group):
			foreach($BOARD_LIST as $boardKey => $boardList):
				if($boardList['b_bg_no'] == $groupKey):
					$aryMenu[$boardKey] = $boardList['b_name'];
				endif;
			endforeach;
		endif;
	endif;
?>

<?if(is_array($aryMenu)):?>
<ul>
	<? foreach($aryMenu as $key => $val): ?>
		<li><a href="./?menuType=community&mode=dataList&b_code=<?=$key?>"><?=$val?></a></li>
	<? endforeach;?>
</ul>
<?endif;?>