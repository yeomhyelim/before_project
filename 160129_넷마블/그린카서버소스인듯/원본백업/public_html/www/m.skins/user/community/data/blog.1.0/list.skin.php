<?
	## 설정
	$result			= $_REQUEST['result']['DataMgr']['listResult'];
	$list_total		= $_REQUEST['result']['DataMgr']['pageResult']['list_total'];
	$list_num		= $_REQUEST['result']['DataMgr']['pageResult']['list_num'];
?>
	<? if($list_total <= 0) : ?>
		<table>
			<tr>
				<td class="noData">등록된 내용이 없습니다.</td>
			</tr>	
		</table>
	<? else: 
			while($row = mysql_fetch_array($result)) :
	?>
		<div class="blogListWrap">
			<div class="titWrap">
					<span class="title"><?=stripslashes($row['UB_TITLE'])?></span>
					<span class="date"><?=date("Y.m.d", strtotime($row['UB_REG_DT']));?></span>
			</div>
			<div class="contentWrap">
					<?=stripslashes($row['UB_TEXT'])?>
					<!-- SNS ICON -->
					<div class="snsIconWrap">
							<?if($_REQUEST['BOARD_INFO']['bi_dataview_twitter_use']=="Y"):?>
							<?$url = "http://{$S_HTTP_HOST}{$S_REQUEST_URI}";?>
								<a href="javascript:goTwitter('<?=stripslashes($row['UB_TITLE'])?>', '<?=$url?>')"><img src="/himg/board/A0001/icon_black_twitter.gif"></a>
							<?endif;?>
							<?if($_REQUEST['BOARD_INFO']['bi_dataview_facebook_use']=="Y"):?>
								<a href="javascript:goFacebook('<?=$url?>', '<?=$S_SITE_URL.$S_WEB_LOGO_IMG?>', '<?=$S_SITE_KNAME?>', '<?=stripslashes($row['UB_TITLE'])?>', '')"><img src="/himg/board/A0001/icon_black_facebook.gif"></a>
							<?endif;?>
					</div>
					<!-- SNS ICON -->
			</div>
			
		</div>

		<div class="btnRight">
			<?if($_REQUEST['buttonLock']['dataModify']):	// 수정 권한이 있는 경우.?>
			<a class="btn_big" href="javascript:goDataModifyMove2('<?=$row['UB_NO']?>');"    id="menu_auth_w" style=""><strong>수정</strong></a>
			<?endif;?>
			<?if($_REQUEST['buttonLock']['dataDelete']):	// 삭제 권한이 있는 경우.?>
			<a class="btn_big" href="javascript:goDataDeleteAct2Event('<?=$row['UB_M_NO']?>','<?=$row['UB_NO']?>');" id="menu_auth_w" style=""><strong>삭제</strong></a>
			<?endif;?>
		</div>
	<? endwhile; 
	   endif; ?>

