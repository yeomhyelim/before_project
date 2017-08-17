<?
	// 이미지(플래시 파일) 파일 로드
	// 모바일( BI_IMAGE_FILE_2 ) 은 플래시 사용 할 수 없음.
	if($row['BI_IMAGE_FILE_1']) :
		if($row['BI_ATATCH_TYPE'] == "I"):
			$strBI_IMAGE_FILE_1 = "<img src='"  . "/upload/subbtnimg/" . $row['BI_IMAGE_FILE_1'] . "' style=\"width:200px;height:50px\" />";
		elseif($row['BI_ATATCH_TYPE'] == "F"):
			$strBI_IMAGE_FILE_1 = sprintf("<script type=\"text/javascript\">insertFlash(\"/upload/subbtnimg/%s\", '174', '76', \"#FFFFFF\", \"\");</script>", $row['BI_IMAGE_FILE_1']);
		endif; 
	endif;
	if($row['BI_IMAGE_FILE_2']) :
		$strBI_IMAGE_FILE_2 = "<img src='"  . "/upload/subbtnimg/" . $row['BI_IMAGE_FILE_2'] . "' style=\"width:200px;height:50px\" />";
	endif;	

?>
<input type="hidden" name="bi_image_file_1" value="<?= $row['BI_IMAGE_FILE_1'] ?>" />
<input type="hidden" name="bi_image_file_2" value="<?= $row['BI_IMAGE_FILE_2'] ?>" />
<div class="contentTop">
	<h2>버튼 및 아이콘 관리</h2>
</div>
<br/>
<!-- ******** 컨텐츠 ********* -->
<? include "./include/tab_imglist.inc.php"?>
<div class="tableForm mt20">
	<table>
		<tr>
			<th rowspan="2">WEB용 로고</th>
			<td>
					<input type="radio" name="bi_atatch_type" value="I" <?= $row['BI_ATATCH_TYPE'] == "I" ? "checked" : "" ?>/>이미지 
					<input type="radio" name="bi_atatch_type" value="F" <?= $row['BI_ATATCH_TYPE'] != "I" ? "checked" : "" ?> style="margin-left:10px;"/>플래시
			</td>
		</tr>
		<tr>
			<td>
				<input type="file" name="bi_image_file_1_new"  <?=$nBox?> style="height:22px;"/>
				<div class="attachImg"><?= $strBI_IMAGE_FILE_1 ?></div>
				<div class="helpTxtGray mt10">
					* 이미지(플래시 포함)의 크기는 가로 최대 <strong>450pixel</strong> 세로 최대 <strong>200pixel</strong> 입니다.<br/>
					* <strong>gif, jpg, png</strong>형식의 이미지파일을 사용하실 수 있습니다.
				</div>
			</td>
		</tr>
		<tr>
			<th>MOBILE용 로고</th>
			<td>
				<input type="file" name="bi_image_file_2_new"  <?=$nBox?> style="height:22px;"/>
				<div class="attachImg"><?= $strBI_IMAGE_FILE_2 ?></div>
				<div class="helpTxtGray mt10">
					* 이미지의 크기는 가로 최대 <strong>300pixel</strong> 세로 최대 <strong>100pixel</strong> 입니다.<br/>
					* <strong>gif, jpg, png</strong> 형식의 이미지파일을 사용하실 수 있습니다.<br/>
					* 모바일용 로고는 플래시 파일을 사용할 수 없습니다.
				</div>
			</td>
		</tr>
	</table>
	<div class="buttonWrap">
		<a class="btn_blue_big" href="javascript:goLogoModifyAct('logoModify');" id="menu_auth_m"><strong>설정 저장</strong></a>
	</div>