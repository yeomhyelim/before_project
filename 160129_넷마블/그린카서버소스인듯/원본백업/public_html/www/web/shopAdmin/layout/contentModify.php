<?php
	## 스크립트 설정 
	$aryScriptEx[] = "/common/eumEditor2/js/eumEditor2.js";
	$aryScriptEx[] = "./common/js/layout/contentModify.js";



?>
<div class="contentTop">
	<h2><?=$LNG_TRANS_CHAR["BW00100"] //추가페이지 관리?></h2>
	<div class="clr"></div>
</div>


<!-- 언어 선택 탭 -->
	<?include "./include/tab_language.inc.php";?>
<!-- 언어 선택 탭-->

<!-- ******** 컨텐츠 ********* -->
<div class="tableFormWrap">
	<table class="tableForm">
		<colgroup>
			<col/>
			<col/>
		</colgroup>
		<!--tr>
			<th>메뉴그룹</th>
			<td>
				<select id="cp_group" name="cp_group">
					<option>모든그룹 접근 권한</option>
				</select>
			</td>
		</tr -->
		<tr>
			<th><?=$LNG_TRANS_CHAR["CW00064"] //페이지명?></th>
			<td><input type="text" name="cp_page_name" id="cp_page_name" <?=$nBox?>  value="<?=$row[CP_PAGE_NAME]?>" style="width:600px;"/></td>
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["BW00103"] //이미지업로드?></th>
			<td>
				<a href="javascript:goFTPFileUploadMoveEvent()" class="btn_blue_sml"><span><?=$LNG_TRANS_CHAR["BW00102"] //FTP 파일 업로드?></span></a>
				<div class="helpTxt">
					* <?=$LNG_TRANS_CHAR["BS00066"] //추가페이지에 사용되는 이미지를 FTP를 이용해 업로드 하세요.?><br/>
					* <?=$LNG_TRANS_CHAR["BS00067"] //업로드된 이미지 경로는 "<strong>/upload/images/</strong>" 입니다.?>
				</div>
			</td>
		</tr>
		<!--tr>
			<th>링크</th>
			<td><input type="text" name="cp_page_url" id="cp_page_url" <?=$nBox?>  style="width:500px;"  value="<?=$row[CP_PAGE_URL]?>"/> <a href="#" class="btn_sml ml10"><span>링크복사</span></a></td>
		</tr -->
		<tr>
			<th><?=$LNG_TRANS_CHAR["CW00065"] //내용?></th><!--higheditor_full-->
			<td>
				<?php include MALL_SHOP . "/common/eumEditor2/editor1.php";?>
				<textarea name="cp_page_text" style="display:none"><?=$row[CP_PAGE_TEXT]?></textarea>
			</td>
		</tr>
	</table>
	
	<div class="buttonWrap">
		<a class="btn_blue_big" href="javascript:void(0);" onclick="goLayoutContentModifyActEvent();" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00016"] //추가 컨텐츠 저장?></strong></a>
		<a class="btn_big" href="javascript:goMoveUrl('contentList');"><strong><?=$LNG_TRANS_CHAR["CW00001"] //목록?></strong></a>
	</div>
</div><!-- tableForm -->
