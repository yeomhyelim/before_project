<?
	## 설정
	$result			= $_REQUEST['result']['DataMgr']['listResult'];
	$list_total		= $_REQUEST['result']['DataMgr']['pageResult']['list_total'];
	$list_num		= $_REQUEST['result']['DataMgr']['pageResult']['list_num'];
?>
<div class="galleryWraper">
	<table>
		<? if($list_total <= 0) : ?>
		<tr>
			<td colspan="5">등록된 내용이 없습니다.</td>
		</tr>
		<? else: 
				for($i=0,$cnt=0;$i<$_REQUEST['BOARD_INFO']['bi_list_default'];$i++):		?>
				<tr>
					<?for($j=0;$j<$_REQUEST['BOARD_INFO']['bi_column_default'];$j++):
						$row	= mysql_fetch_array($result, MYSQL_ASSOC);	
						$cnt++;
						$imgsrc = $row['FL_DIR'] . $row['FL_NAME'];
						$title	= $row['UB_TITLE'];											?>
					<!-- 내용 -->
					<td>
						<div class="listWrap">
							<li style="display:block;"><a href="javascript:goDataViewMoveEvent('<?=$row['UB_NO']?>')"><img src="<?=$imgsrc?>" class="galleryListImg"/></a></li><br>
							<li style="display:block;"><a href="javascript:goDataViewMoveEvent('<?=$row['UB_NO']?>')"><?=$title?></a></li>
						</div>
					</td>
					<!-- 내용 -->
					<?if($list_total<=$cnt) { break; }?>
					<?endfor;?>
				</tr>
		<?			if($list_total<=$cnt) { break; }
				endfor;	
		   endif;				?>
	</table>
</div>
