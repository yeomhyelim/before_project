<?
	## 설정
	$dataSelectRow					= $_REQUEST['result']['DataMgr'];
	$attachedfileViewListResult		= $_REQUEST['result']['AttachedfileMgr'];
?>
	
	<table>
		<?if($_REQUEST['BOARD_INFO']['bi_category_use']=="Y"): // 카테고리 사용?>
		<tr>
			<th>카테고리</th>
			<td><? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/category/include.1.0/combobox.view.inc.skin.php" ?></td>
		</tr>
		<?endif;?>
		<tr>
			<th>작성일</th>
			<td>
				<?=date("Y-m-d H:i:d", strtotime($dataSelectRow['UB_REG_DT']))?>
			</td>
		</tr>
		<tr>
			<th>작성자 (아이디)</th>
			<td>
				<?=$dataSelectRow['UB_NAME']?> <?if($dataSelectRow['UB_M_ID']):?>(<?=$dataSelectRow['UB_M_ID']?>)<?endif;?>
			</td>
		</tr>
		<?if($dataSelectRow['UB_MAIL']):?>
		<tr>
			<th>이메일</th>
			<td>
				<?=$dataSelectRow['UB_MAIL']?>
			</td>
		</tr>
		<?endif;?>
		<?if($_REQUEST['BOARD_INFO']['bi_userfield_use'] == "Y"): // 추가 필드 사용 할 때?>
		<? include "userfield.view.skin.php" ?>
		<?endif;?>
		<?if($dataSelectRow['UB_URL'] && $dataSelectRow['UB_URL'] != "http://"):?>
		<tr>
			<th>링크</th>
			<td>
				<a href="<?=$dataSelectRow['UB_URL']?>" target="_blank"><?=$dataSelectRow['UB_URL']?></a>
			</td>
		</tr>
		<?endif;?>
		<tr>
			<th>제목</th>
			<td>
				<?if($dataSelectRow['UB_FUNC']['UB_FUNC_NOTICE']=="Y"):?>
				[공지사항]
				<?endif;?>
				<?=stripslashes($dataSelectRow['UB_TITLE'])?>

				<?if($dataSelectRow['UB_FUNC']['UB_FUNC_LOCK']=="Y"):?>
				[비밀글]
				<?endif;?>
				<?if($dataSelectRow['UB_FUNC']['UB_FUNC_ICON']=="Y"):?>
				[아이콘]
				<?endif;?>
			</td>
		</tr>
		<?if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][4]!="N"): // 평점(점수)?>
		<tr>
			<th>평점</th>
			<td>
				<?=$dataSelectRow['UB_P_GRADE']?>
			</td>
		</tr>
		<?endif;?>
		<tr>
			<th>내용</th>
			<td>
				<?if($_REQUEST['BOARD_INFO']['bi_datawrite_form'] == "higheditor_full"):?>
					<?=strConvertCut($dataSelectRow['UB_TEXT'],0,"Y")?>
				<?else:?>
					<?=strConvertCut($dataSelectRow['UB_TEXT'],0,"N")?>
				<?endif;?>
			</td>
		</tr>
		<tr>
			<th>아이피</th>
			<td>
				<?=$dataSelectRow['UB_IP']?>
			</td>
		</tr>
		<?if($_REQUEST['list_total']['AttachedfileMgr']):?>
		<tr>
			<th>첨부파일</th>
			<td colspan="5">
				<ul>
				<? while($row = mysql_fetch_array($attachedfileViewListResult)) : ?>
				<li><img src="<?=$row['FL_DIR'].$row['FL_NAME']?>" style="width:50px;height:50px" /></li>
				<? endwhile; ?>
				</ul>
			</td>
		</tr>
		<?endif;?>
	</table>
