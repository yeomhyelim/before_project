<?
	## 설정
	$result			= $_REQUEST['result']['DataMgr']['listResult'];
	$list_total		= $_REQUEST['result']['DataMgr']['pageResult']['list_total'];
	$list_num		= $_REQUEST['result']['DataMgr']['pageResult']['list_num'];

	## 첨부 파일 정보
	$attachedfileView					= new CommunityAttachedfileView($db, $_REQUEST);

	if(!$COMMUNITY_LIST_OP[$_REQUEST['b_code']]['CONTENT_LEN']) { $COMMUNITY_LIST_OP[$_REQUEST['b_code']]['CONTENT_LEN'] = 0; }
?>
	<? if($list_total <= 0) : ?>
		<table>
			<tr>
				<td class="noData">등록된 내용이 없습니다.</td>
			</tr>	
		</table>
	<? else: 
			while($row = mysql_fetch_array($result)) :
			/** 리스트 이미지 처리 **/
			if($row['FL_NAME']):
				$listImg = "{$row['FL_DIR']}{$row['FL_NAME']}";
				$listImg = "<div class='listImg'><img src='{$listImg}'/></div>";
			endif;

			// 첨부파일
			$param = "";
			$param['b_code']	= $_REQUEST['b_code'];
			$param['fl_ub_no']	= $row['UB_NO'];
			$imgResult			= $attachedfileView->getListNoPageEx("OP_LIST", $param);

	?>
		<div class="blogListWrap">
			<div class="titWrap">
					<span class="title"><?=stripslashes($row['UB_TITLE'])?></span>
					<span class="date"><?=date("Y.m.d", strtotime($row['UB_REG_DT']));?></span>
					<div class="clr"></div>
			</div>
			<div class="blogContentData">
					<?=$listImg?>
					<?while($imgRow = mysql_fetch_array($imgResult)):?>
						<?if(in_array($imgRow['FL_KEY'], array("image"))):?>
							<img src="<?=$imgRow['FL_DIR'].$imgRow['FL_NAME']?>">
						<?endif;?>
					<?endwhile;?>
					<div class="viewDetail">
						<?if($_REQUEST['BOARD_INFO']['bi_datawrite_form'] == "higheditor_full"):?>
							<?=strConvertCut($row['UB_TEXT'],$COMMUNITY_LIST_OP[$_REQUEST['b_code']]['CONTENT_LEN'],"Y")?>
						<?else:?>
							<?=strConvertCut($row['UB_TEXT'],$COMMUNITY_LIST_OP[$_REQUEST['b_code']]['CONTENT_LEN'],"N")?>
						<?endif;?>
					</div>
					
					<!-- SNS ICON -->
					<div class="snsIconWrap">
						<?if($_REQUEST['BOARD_INFO']['bi_dataview_twitter_use']=="Y"):?>
						<?$url = "http://{$S_HTTP_HOST}{$S_REQUEST_URI}";?>
							<a href="javascript:goTwitter('<?=stripslashes($row['UB_TITLE'])?>', '<?=$url?>')"><img src="/upload/images/icon_twitter.png"></a>
						<?endif;?>
						<?if($_REQUEST['BOARD_INFO']['bi_dataview_facebook_use']=="Y"):?>
							<a href="javascript:goFacebook('<?=$url?>', '<?=$S_SITE_URL.$S_WEB_LOGO_IMG?>', '<?=$S_SITE_KNAME?>', '<?=stripslashes($row['UB_TITLE'])?>', '')"><img src="/upload/images/icon_facebook.png"></a>
						<?endif;?>
						<?if($COMMUNITY_LIST_OP[$_REQUEST['b_code']]['VIEW']=="Y"):?>
							<a href="javascript:goDataViewMoveEvent('<?=$row['UB_NO']?>')"><img src="/upload/images/btn_blog_more.png"></a>
						<?endif;?>
					</div>
					<!-- SNS ICON -->
			</div>
		</div>

		<div class="btnRight">
			<?if($_REQUEST['buttonLock']['dataModify']):	// 수정 권한이 있는 경우.?>
			<a href="javascript:goDataModifyMove2Event('<?=$row['UB_NO']?>');"    id="menu_auth_w" class="btn_board_modify"><strong><?=$LNG_TRANS_CHAR["OW00072"] //수정?></strong></a>
			<?endif;?>
			<?if($_REQUEST['buttonLock']['dataDelete']):	// 삭제 권한이 있는 경우.?>
			<a href="javascript:goDataDeleteAct2Event('<?=$row['UB_M_NO']?>','<?=$row['UB_NO']?>');" id="menu_auth_w" class="btn_board_delete"><strong><?=$LNG_TRANS_CHAR["CW00036"] //삭제?></strong></a>
			<?endif;?>
		</div>
	<? endwhile; 
	   endif; ?>

