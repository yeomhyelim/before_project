
<input type="hidden" name="bi_group" value="<?= $strBI_GROUP ?>" />
<input type="hidden" name="bi_image_cate" value="<?= $strBI_IMAGE_CATE ?>" />

<div class="contentTop">
	<h2>버튼 및 아이콘 관리</h2>
</div>
<br>
<!-- ******** 컨텐츠 ********* -->
<? include "./include/tab_imglist.inc.php"?>
<div class="tableForm mt20">
	<table>
		<tr>
			<th>이미지그룹</th>
			<td><?= $designRow['DM_DESIGN_TITLE'] ?> <a href="javascript:goImageGroupPopup('<?= $strBI_IMAGE_CATE ?>')" class="btn_sml"><span>디자인선택</span></a></td>
		</tr>
		<tr>
			<th>디렉토리</th>
			<td>/board/_skin/default/kr/</td>
		</tr>
	</table>
</div>

<div class="imageListTable">
	<table>
		<tr>
			<?	$cnt = 1;
				while($row = mysql_fetch_array($result)){
					if($row['BI_IMAGE_FILE_1']) :
						$strBI_IMAGE_FILE_1 = "<img src='"  . "/upload/designbtnimg/" . $row['BI_IMAGE_FILE_1'] . "' />";
					endif;
					if($cnt%6 == "0") echo "<tr>";
			?>
					<td>
						<div>
							<?=$strBI_IMAGE_FILE_1?>
							<ul>
								<li>[<?=$row[BI_IMAGE_GUBUN]?>] <a href="javascript:goMoveUrl('imgStyle2Modify', <?= $row['BI_NO'] ?>)">수정</a></span></li>
							</ul>
						</div>
					</td>
			<? 
				//echo $cnt%6;
				if($cnt%6 == "5") echo "</tr>";	
				$cnt++;
					}//while ?>
		
	</table>
</div>
	
	<br><a href="javascript:goMoveUrl('imgStyle2Write','')">등록</a>
	
	
	
	
	
	