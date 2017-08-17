<?
	## 설정
	$result			= $_REQUEST['result']['DataMgr']['listResult'];
	$list_total		= $_REQUEST['result']['DataMgr']['pageResult']['list_total'];
	$list_num		= $_REQUEST['result']['DataMgr']['pageResult']['list_num'];
	$intListCnt		= $_REQUEST['BOARD_INFO']['bi_list_default'];
	$intWidthCnt	= $_REQUEST['BOARD_INFO']['bi_column_default'];
	$intTitleCnt	= $_REQUEST['BOARD_INFO']['bi_datalist_title_len'];


?>
<div class="galleryWraper">
	<table class="bbsListTable">
		<?php if(!$list_total):?>
		<tr>
			<td colspan="5">등록된 내용이 없습니다.</td>
		</tr>
		<?php else:?>
		<?php for($i=0;$i<$intListCnt;$i++):?>
		<tr>
			<?php for($j=0;$j<$intWidthCnt;$j++):
			
					## 기본 설정
					$row = mysql_fetch_array($result, MYSQL_ASSOC);
					$intUB_NO = $row['UB_NO'];
					$strFL_DIR = $row['FL_DIR'];
					$strFL_NAME = $row['FL_NAME'];
					$strUB_TITLE = $row['UB_TITLE'];

					## 이미지 설정
					$strImageSrc = "{$strFL_DIR}{$strFL_NAME}";

					## 제목 설정
					$strTitle  = strHanCutUtf2($strUB_TITLE, $intTitleCnt, 'N');

					## endList class 설정
					$strEndListClass = "";
					if($intWidthCnt == ($j+1)) { $strEndListClass = "endList"; }

			?>
			<td class="<?php echo $strEndListClass;?>">
				<?php if($row):?>
				<div class="listWrap">
					<li style="display:block;"><a href="javascript:goDataViewMoveEvent('<?php echo $intUB_NO;?>')"><img src="<?php echo $strImageSrc;?>" class="galleryListImg"/></a></li><br>
					<li style="display:block;"><a href="javascript:goDataViewMoveEvent('<?php echo $intUB_NO;?>')"><?php echo $strTitle;?></a></li>
				</div>
				<?php endif;?>
			</td>
			<?php endfor;?>
		</tr>
		<?php if(!$row) { break; }?>
		<?php endfor;?>
		<?php endif;?>
	</table>
</div>
