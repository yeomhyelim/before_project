<?
	## 설정
	$dataSelectRow					= $_REQUEST['result']['DataMgr'];
	$attachedfileViewListResult		= $_REQUEST['result']['AttachedfileMgr'];
?>
	<table>
		<tr>
			<th>작성일</th>
			<td>
				<?=date("Y-m-d H:i:d", strtotime($dataSelectRow['UB_REG_DT']))?>
			</td>
		</tr>
		<tr>
			<th>작성자 (아이디)</th>
			<td>
				<?=$dataSelectRow['UB_NAME']?> (<?=$dataSelectRow['UB_M_ID']?>)
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
			<th>내용</th>
			<td>
				<?=stripslashes($dataSelectRow['UB_TALK'])?>
			</td>
		</tr>
		<tr>
			<th>아이피</th>
			<td>
				<?=$dataSelectRow['UB_IP']?>
			</td>
		</tr>
		<?if($attachedfileViewListResult):?>
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

