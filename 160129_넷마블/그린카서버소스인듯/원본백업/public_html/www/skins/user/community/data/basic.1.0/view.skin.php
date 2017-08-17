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

	## SNS 설정
	$strSnsImg = $S_SITE_URL.$S_WEB_LOGO_IMG;
	while($row = mysql_fetch_array($attachedfileViewListResult)) : 
		if($row['FL_KEY'] == "listImage" && $row['FL_NAME']):
			$strSnsImg = $S_SITE_URL.$row['FL_DIR'].$row['FL_NAME'];
		endif;
	endwhile;
	mysql_data_seek($attachedfileViewListResult,0);

	## 2013.04.18 첨부파일 설정
	$attachedCnt = 0;
	for($i=0;$i<$_REQUEST['BOARD_INFO']['bi_attachedfile_use'];$i++):
		$key = $_REQUEST['BOARD_INFO']['bi_attachedfile_key'][$i];
		if(in_array($key, array("listImage", "image","bigImage"))) { continue; }
		$attachedCnt++;
	endfor;	

	## 리스트 이미지 사용 유무 설정
	$listImgUse		= $COMMUNITY_VIEW_OP[$_REQUEST['b_code']]['LIST_IMG_SHOW'];

	## 웹 글 필드 설정
	$web_text_field_use = "";
	if($dataSelectRow['UB_TEXT']) { $web_text_field_use = "Y"; }

	## 웹 내용 설정
// 2014.05.26 kim hee sung 한중관 사이트에서 깨지는 현상이 있어서 아래와 같이 변경함.
//	if($web_text_field_use == "Y"):
//		$type = "N";
////		if($dataSelectRow['UB_M_NO'] != 1) { $type = "N"; }
////		if($_REQUEST['BOARD_INFO']['bi_datawrite_form'] == "higheditor_full") { $type = "N"; }
//
//		if(substr_count($dataSelectRow['UB_TEXT'], "<P>") > 0)				{ $type = "Y"; }
//		if(substr_count($dataSelectRow['UB_TEXT'], "<p>") > 0)				{ $type = "Y"; }
//		if(substr_count($dataSelectRow['UB_TEXT'], "<DIV>") > 0)			{ $type = "Y"; }
//		if(substr_count($dataSelectRow['UB_TEXT'], "<div>") > 0)				{ $type = "Y"; }
//		if(substr_count($dataSelectRow['UB_TEXT'], "&nbsp;") > 0)			{ $type = "Y"; }
//		if(substr_count($dataSelectRow['UB_TEXT'], "<img") > 0)				{ $type = "Y"; }
//		if(substr_count($dataSelectRow['UB_TEXT'], "<embed ") > 0)		{ $type = "Y"; }
//
//		$web_text = strConvertCut($dataSelectRow['UB_TEXT'],0,$type);
//	endif;
//
//	if($_REQUEST['BOARD_INFO']['bi_datawrite_form'] == "textWrite"):
//		$web_text			= strConvertCut($dataSelectRow['UB_TEXT'],0,"N");
//		$mobile_text		= strConvertCut($dataSelectRow['UB_TEXT_MOBILE'],0,"N");
//	else:
//		$web_text			= strConvertCut($dataSelectRow['UB_TEXT'],0,"Y");
//		$mobile_text		= strConvertCut($dataSelectRow['UB_TEXT_MOBILE'],0,"Y");
//	endif;

	$type = "N";
	if(substr_count($dataSelectRow['UB_TEXT'], "<P") > 0)			{ $type = "Y"; }
	if(substr_count($dataSelectRow['UB_TEXT'], "<br") > 0)			{ $type = "Y"; }
	if(substr_count($dataSelectRow['UB_TEXT'], "<p") > 0)			{ $type = "Y"; }
	if(substr_count($dataSelectRow['UB_TEXT'], "<DIV") > 0)			{ $type = "Y"; }
	if(substr_count($dataSelectRow['UB_TEXT'], "<div") > 0)			{ $type = "Y"; }
	if(substr_count($dataSelectRow['UB_TEXT'], "&nbsp;") > 0)		{ $type = "Y"; }
	if(substr_count($dataSelectRow['UB_TEXT'], "<img") > 0)			{ $type = "Y"; }
	if(substr_count($dataSelectRow['UB_TEXT'], "<IMG") > 0)			{ $type = "Y"; }
	if(substr_count($dataSelectRow['UB_TEXT'], "<embed ") > 0)		{ $type = "Y"; }
	if(substr_count($dataSelectRow['UB_TEXT'], "<EMBED ") > 0)		{ $type = "Y"; }

	$web_text			= strConvertCut($dataSelectRow['UB_TEXT'],0,$type);
	$mobile_text		= strConvertCut($dataSelectRow['UB_TEXT_MOBILE'],0,$type);


?>
	<table class="tableForm">	
		<tr>
			<th class="boardTit" colspan="8">
				<?=stripslashes($dataSelectRow['UB_TITLE'])?>
			</th>
		</tr>
		<tr class="writerInfo">
			<?if(!$userNameUse): // 작성자 사용 ?>
				<th class="name"><?=$LNG_TRANS_CHAR["CW00053"] //작성자?></th>
			<?else:?>
				<th><?=$LNG_TRANS_CHAR["CW00054"] //작성일?></th>
			<?endif;?>
			<td class="writerVal">
				<?if($_REQUEST['BOARD_INFO']['bi_datalist_writer_show'][0]=="Y"):?>
					<?=$dataSelectRow['UB_NAME'] //작성자(성명)?>
				<?endif;?>
				<?if($_REQUEST['BOARD_INFO']['bi_datalist_writer_show'][1]=="Y"):?>
					<?=$dataSelectRow['UB_M_ID'] //작성자(아이디)?> 
				<?endif;?>
				<span class="txtDate"><?=date("Y-m-d H:i:d", strtotime($dataSelectRow['UB_REG_DT']))?></span>
			</td>
			<th class="read"><?=$LNG_TRANS_CHAR["CW00055"] //조회수?></th>
			<td class="readCnt">
				<?=NUMBER_FORMAT($dataSelectRow['UB_READ'])?>
			</td>
		</tr>
		<?if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][4] && $_REQUEST['BOARD_INFO']['bi_datalist_field_use'][4]!="N"): // 평점(점수)?>
			<tr>
				<th><?=$LNG_TRANS_CHAR["CW00056"] //평점?></th>
				<td colspan="5" style="text-align:left">
					<img src="/himg/board/icon/icon_star_<?=$dataSelectRow['UB_P_GRADE']?>.png"/>
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
					if(!in_array($row['FL_KEY'], array("listImage", "image", "file"))) { continue; } /** 2013.04.18 첨부파일이 리스트 이미지 or 이미지 인 경우 출력 안함. **/
				?>
				<?if($row['FL_KEY'] == "file"):?>
				<li><a href="javascript:goDataDownloadMoveEvent('<?=$_REQUEST['b_code']?>','<?=$row['FL_NO']?>')"><?=$row['FL_NAME']?></a></li>
				<?else:?>
				<li><img src="<?=$row['FL_DIR'].$row['FL_NAME']?>" style="width:50px;height:50px" /></li>
				<?endif;?>
				<? endwhile; 
				   mysql_data_seek($attachedfileViewListResult,0); ?>
				</ul>
			</td>
		</tr>
		<?endif;?>
		<?if($_REQUEST['BOARD_INFO']['bi_userfield_use'] == "Y"): // 추가 필드 사용 할 때?>
		<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/user/community/data/basic.1.0/userfield.view.skin.php" ?>
		<?endif;?>
	</table>

	<div class="viewContentArea">
		<div class="community-view-image">
		<?while($row = mysql_fetch_array($attachedfileViewListResult)):
			if(($_REQUEST['BOARD_INFO']['b_skin'] != "gallery") && $row['FL_KEY'] !== "image") { continue; } /** 2013.04.18 첨부파일이 리스트 이미지 or 이미지 인 경우 출력 안함. **/	
			if($row['FL_KEY'] == "listImage" && $listImgUse != "Y") { continue; } /** 2013.08.13 kim hee sung 리스트 이미지를 뷰페이지에서 표시 할지 설정 **/	?>
				<img src="<?=$row['FL_DIR'].$row['FL_NAME']?>"/><br>
		<?endwhile;?>
		</div>
		<?=$web_text?>
	</div>
<div class="snsIcoWrap">
	<?if($_REQUEST['BOARD_INFO']['bi_dataview_twitter_use']=="Y"):?>
		<?$url = "http://{$S_HTTP_HOST}{$S_REQUEST_URI}";?>
		<a href="javascript:goTwitter('<?=stripslashes($dataSelectRow['UB_TITLE'])?>', '<?=$url?>')"><img src="/upload/images/icon_twitter.png" alt="Twitter"></a>
	<?endif;?>
		<?if($_REQUEST['BOARD_INFO']['bi_dataview_facebook_use']=="Y"):?>
		<a href="javascript:goFacebook('<?=$url?>', '<?=$strSnsImg?>', '<?=$S_SITE_KNAME?>', '<?=stripslashes($dataSelectRow['UB_TITLE'])?>', '')"><img src="/upload/images/icon_facebook.png" alt="Facebook"></a>
	<?endif;?>
</div>