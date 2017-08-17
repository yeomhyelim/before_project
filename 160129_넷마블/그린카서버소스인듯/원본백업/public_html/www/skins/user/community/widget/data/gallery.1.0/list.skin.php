<?
	## 리스트 정보
	$result			= $_REQUEST['result']['DataMgr']['listResult'];
	$list_total		= $_REQUEST['result']['DataMgr']['pageResult']['list_total'];
//	$list_num		= $_REQUEST['result']['DataMgr']['pageResult']['list_num'];

	## 설정 정보
	$b_code			= $_REQUEST['BOARD_INFO']['b_code'];

	## 가로, 세로 개수 설정
	$intWidthCnt	= $_REQUEST['BOARD_INFO']['bi_widget_column_default'];
	$intHeightCnt	= $_REQUEST['BOARD_INFO']['bi_widget_list_default'];
	if($list_total < ($intWidthCnt*$intHeightCnt)):
		$intHeightCnt	= ceil($list_total / $intHeightCnt);
	endif;

?>
<?if($list_total > 0): // 내용이 있는 경우 실행?>
<table>
	<?for($i=0;$i<$intHeightCnt;$i++):?>
	<tr>
		<?for($j=0;$j<$intWidthCnt;$j++):
			$row = mysql_fetch_array($result);

			## 이미지
			$img = "";
			if($row['FL_NAME']){ $img = "{$row['FL_DIR']}{$row['FL_NAME']}"; }

		?>
		<td>
			<?if($row):?>
			<div class="PhotoListWrap">
				<ul>
					<li class="photoImg"><img src="<?=$img?>" class="listImg"></li>
					<li class="title"><a href="./?menuType=community&mode=dataView&b_code=<?=$b_code?>&ub_no=<?=$row['UB_NO']?>"><?=$row['UB_TITLE']?></a></li>
				</ul>
			</div>
			<?endif;?>
		</td>
		<?endfor;?>
	<tr>
	<?endfor;?>
</table>
<?endif;?>