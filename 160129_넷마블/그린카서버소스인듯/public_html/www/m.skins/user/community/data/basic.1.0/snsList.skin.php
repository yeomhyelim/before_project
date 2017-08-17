	<div class="snsWrap">
		<?if($_REQUEST['BOARD_INFO']['bi_dataview_twitter_use']=="Y"):?>
		<?$url = "http://{$S_HTTP_HOST}{$S_REQUEST_URI}";?>
			<a href="javascript:goKakaoTalk('<?=stripslashes($_REQUEST['BOARD_INFO']['b_name'])?>', '<?=$url?>')"><img src="/himg/icon_new_cacaotalk.png" class="snsIconImg"/></a>
		<?endif;?>
		<!--<?if($_REQUEST['BOARD_INFO']['bi_dataview_twitter_use']=="Y"):?>
		<?$url = "http://{$S_HTTP_HOST}{$S_REQUEST_URI}";?>
			<a href="javascript:goKakaoStory('<?=stripslashes($_REQUEST['BOARD_INFO']['b_name'])?>', '<?=$url?>')"><img src="/himg/icon_new_cacaostory.png" class="snsIconImg"/></a>
		<?endif;?>//-->
		<?if($_REQUEST['BOARD_INFO']['bi_dataview_facebook_use']=="Y"):?>
			<a href="javascript:goFacebook('<?=$url?>', '<?=$S_SITE_URL.$S_WEB_LOGO_IMG?>', '<?=$S_SITE_KNAME?>', '<?=stripslashes($row['UB_TITLE'])?>', '')"><img src="/himg/icon_new_facebook.png" class="snsIconImg"/></a>
		<?endif;?>
		<?if($_REQUEST['BOARD_INFO']['bi_dataview_twitter_use']=="Y"):?>
		<?$url = "http://{$S_HTTP_HOST}{$S_REQUEST_URI}";?>
			<a href="javascript:goTwitter('<?=stripslashes($_REQUEST['BOARD_INFO']['b_name'])?>', '<?=$url?>')"><img src="/himg/icon_new_twitter.png" class="snsIconImg"/></a>
		<?endif;?>
	</div>
