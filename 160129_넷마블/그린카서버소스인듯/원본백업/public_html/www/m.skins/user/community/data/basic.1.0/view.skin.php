
<?
	## 설정
	$dataSelectRow					= $_REQUEST['result']['DataMgr'];
	$attachedfileViewListResult		= $_REQUEST['result']['AttachedfileMgr'];
	##이름, 아이디 숨김 처림.
	$intHidden						= $_REQUEST['BOARD_INFO']['bi_datalist_writer_hidden'];
	if($intHidden  && ($_REQUEST['member_group'] != "001")):
	   $dataSelectRow['UB_NAME']	= mb_substr($dataSelectRow['UB_NAME'], 0, $intHidden, "UTF-8");
	   for($i=0;$i<3;$i++) { $dataSelectRow['UB_NAME'] .= "*"; }
	   $dataSelectRow['UB_M_ID']	= mb_substr($dataSelectRow['UB_M_ID'], 0, $intHidden, "UTF-8");
	   for($i=0;$i<3;$i++) { $dataSelectRow['UB_M_ID'] .= "*"; }
	endif;
	## 작성자 사용

	if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'] == "Y"):
		if($_REQUEST['BOARD_INFO']['bi_datalist_writer_show'][0]=="Y" || $_REQUEST['BOARD_INFO']['bi_datalist_writer_show'][1]=="Y"):
			$userNameUse = "";
		endif;		
	endif;

	## 2013.04.18 첨부파일 설정
	$attachedCnt = 0;
	for($i=0;$i<$_REQUEST['BOARD_INFO']['bi_attachedfile_use'];$i++):
		$key = $_REQUEST['BOARD_INFO']['bi_attachedfile_key'][$i];
		if(in_array($key, array("listImage", "image"))) { continue; }
		$attachedCnt++;
	endfor;

	## 2013.04.18 UB_TEXT 모바일용으로 변경
	if($dataSelectRow['UB_TEXT_MOBILE']):
		$dataSelectRow['UB_TEXT'] = $dataSelectRow['UB_TEXT_MOBILE'];
	endif;
?>
<div class="snsViewContainer">
	<div class="snsWrap">
		<?if($_REQUEST['BOARD_INFO']['bi_dataview_twitter_use']=="Y"):?>
		<?$url = "http://{$S_HTTP_HOST}{$S_REQUEST_URI}";?>
			<a href="javascript:goTwitter('<?=stripslashes($row['UB_TITLE'])?>', '<?=$url?>')"><img src="/himg/icon_new_cacaotalk.png" class="snsIconImg"/></a>
		<?endif;?>
		<?if($_REQUEST['BOARD_INFO']['bi_dataview_twitter_use']=="Y"):?>
		<?$url = "http://{$S_HTTP_HOST}{$S_REQUEST_URI}";?>
			<a href="javascript:goTwitter('<?=stripslashes($row['UB_TITLE'])?>', '<?=$url?>')"><img src="/himg/icon_new_cacaostory.png" class="snsIconImg"/></a>
		<?endif;?>
		<?if($_REQUEST['BOARD_INFO']['bi_dataview_facebook_use']=="Y"):?>
			<a href="javascript:goFacebook('<?=$url?>', '<?=$S_SITE_URL.$S_WEB_LOGO_IMG?>', '<?=$S_SITE_KNAME?>', '<?=stripslashes($row['UB_TITLE'])?>', '')"><img src="/himg/icon_new_facebook.png" class="snsIconImg"/></a>
		<?endif;?>
		<?if($_REQUEST['BOARD_INFO']['bi_dataview_twitter_use']=="Y"):?>
		<?$url = "http://{$S_HTTP_HOST}{$S_REQUEST_URI}";?>
			<a href="javascript:goTwitter('<?=stripslashes($row['UB_TITLE'])?>', '<?=$url?>')"><img src="/himg/icon_new_twitter.png" class="snsIconImg"/></a>
		<?endif;?>
	</div>
</div>

	<table>		
		<tr>
			<th class="boardTit" colspan="4">
				<?=stripslashes($dataSelectRow['UB_TITLE'])?>
			</th>
		</tr>
		<tr>
			<?if(!$userNameUse): // 작성자 사용 ?>
				<th><?=$LNG_TRANS_CHAR["CW00053"] //작성자?></th>
			<?else:?>
				<th><?=$LNG_TRANS_CHAR["CW00054"] //작성일?></th>
			<?endif;?>
			<td>
				<?if($_REQUEST['BOARD_INFO']['bi_datalist_writer_show'][0]=="Y"):?>
					<?=$dataSelectRow['UB_NAME'] //작성자(성명)?>
				<?endif;?>
				<?if($_REQUEST['BOARD_INFO']['bi_datalist_writer_show'][1]=="Y"):?>
					<?=$dataSelectRow['UB_M_ID'] //작성자(아이디)?> 
				<?endif;?>
				<span class="txtDate">(<?=date("Y-m-d H:i:d", strtotime($dataSelectRow['UB_REG_DT']))?>)</span>
			</td>
			<th><?=$LNG_TRANS_CHAR["CW00055"] //조회수?></th>
			<td>
				<?=NUMBER_FORMAT($dataSelectRow['UB_READ'])?>
			</td>
		</tr>
		<?if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][4]!="N"): // 평점(점수)?>
			<tr>
				<th>평점</th>
				<td colspan="5">
					<?=$dataSelectRow['UB_P_GRADE']?>
				</td>
			</tr>
			<?endif;?>
		<?if($_REQUEST['fieldLock'][5]): // 이메일 영역?>
		<tr>
			<th><?=$LNG_TRANS_CHAR["MW00010"] //이메일?></th>
			<td colspan="8">
				<?=$dataSelectRow['UB_MAIL']?>
			</td>
		</tr>
		<?endif;?>
		<?if($_REQUEST['fieldLock'][6]): // 아이피 영역?>
		<tr>
			<th>IP</th>
			<td  colspan="8">
				<?=$dataSelectRow['UB_IP']?>
			</td>
		</tr>
		<?endif;?>
		<?if($attachedCnt > 0 && $_REQUEST['list_total']['AttachedfileMgr']):?>
		<tr>
			<th><?=$LNG_TRANS_CHAR["CW00058"] //첨부파일?></th>
			<td colspan="8">
				<ul>
				<? while($row = mysql_fetch_array($attachedfileViewListResult)) : 
					if(in_array($row['FL_KEY'], array("listImage", "image"))) { continue; } /** 2013.04.18 첨부파일이 리스트 이미지 or 이미지 인 경우 출력 안함. **/	?>
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


