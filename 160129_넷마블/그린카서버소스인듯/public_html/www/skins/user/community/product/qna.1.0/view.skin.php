	<table>		
		<tr>
			<th class="boardTit" colspan="6">
				<?=stripslashes($dataSelectRow['UB_TITLE'])?>
			</th>
		</tr>
		<tr>
			<th>작성자 </th>
			<td>
				<?=$dataSelectRow['UB_NAME']?> 
				<?if($dataSelectRow['UB_M_ID']) { echo "({$dataSelectRow['UB_M_ID']})"; }
				  else { echo "(비회원)"; } ?>
			</td>
			<th>작성일</th>
			<td>
				<?=date("Y-m-d H:i:d", strtotime($dataSelectRow['UB_REG_DT']))?>
			</td>
			<th>조회수</th>
			<td>
				<?=$dataSelectRow['UB_READ']?>
			</td>
		</tr>
		<?if($_REQUEST['fieldLock'][5]): // 이메일 영역?>
		<tr>
			<th>이메일</th>
			<td colspan="5">
				<?=$dataSelectRow['UB_MAIL']?>
			</td>
		</tr>
		<?endif;?>
		<?if($_REQUEST['fieldLock'][6]): // 아이피 영역?>
		<tr>
			<th>아이피</th>
			<td  colspan="5">
				<?=$dataSelectRow['UB_IP']?>
			</td>
		</tr>
		<?endif;?>
		<?if($_REQUEST['list_total']['AttachedfileMgr']):?>
		<tr>
			<th>첨부파일		</th>
			<td colspan="5">
				<ul>
				<? while($row = mysql_fetch_array($attachedfileViewListResult)) : ?>
				<li><img src="<?=$row['FL_DIR'].$row['FL_NAME']?>" style="width:50px;height:50px" /></li>
				<? endwhile; ?>
				</ul>
			</td>
		</tr>
		<?endif;?>
		<?if($_REQUEST['BOARD_INFO']['bi_userfield_use'] == "Y"): // 추가 필드 사용 할 때?>
		<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/user/community/data/basic.1.0/userfield.view.skin.php" ?>
		<?endif;?>
	</table>

	<div class="viewContentArea">
		<?if($_REQUEST['BOARD_INFO']['bi_datawrite_form'] == "higheditor_full"):?>
			<?=strConvertCut($dataSelectRow['UB_TEXT'],0,"Y")?>
		<?else:?>
			<?=strConvertCut($dataSelectRow['UB_TEXT'],0,"N")?>
		<?endif;?>
	</div>

	<?if($_REQUEST['BOARD_INFO']['bi_dataview_twitter_use']=="Y"):?>
	<?$url = "http://{$S_HTTP_HOST}{$S_REQUEST_URI}";?>
	<a href="javascript:goTwitter('<?=stripslashes($row['UB_TITLE'])?>', '<?=$url?>')"><img src="/himg/board/A0001/icon_black_twitter.gif"></a>
	<?endif;?>
	<?if($_REQUEST['BOARD_INFO']['bi_dataview_facebook_use']=="Y"):?>
	<a href="javascript:goFacebook('<?=$url?>', '<?=$S_SITE_URL.$S_WEB_LOGO_IMG?>', '<?=$S_SITE_KNAME?>', '<?=stripslashes($row['UB_TITLE'])?>', '')"><img src="/himg/board/A0001/icon_black_facebook.gif"></a>
	<?endif;?>
