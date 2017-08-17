<?php
	## script 설정
	$aryScriptEx[] = "../common/js/jquery-1.8.24-ui.min.js";
	$aryScriptEx[] = "./common/js/jqueryFileTree/jqueryFileTree.js";
	$aryScriptEx[] = "./common/js/codemirror-4.0/lib/codemirror.js";
	$aryScriptEx[] = "./common/js/codemirror-4.0/mode/xml/xml.js";
	$aryScriptEx[] = "./common/js/codemirror-4.0/addon/display/fullscreen.js";
	$aryScriptEx[] = "./common/js/layoutM/htmlModify.js";


?>
<link rel="stylesheet" href="../common/jquery-ui-1.10.4.custom/css/ui-lightness/jquery-ui-1.10.4.custom.css"/>
<link rel="stylesheet" href="./common/js/jqueryFileTree/jqueryFileTree.css"/>
<link rel="stylesheet" href="./common/js/codemirror-4.0/lib/codemirror.css" />
<link rel="stylesheet" href="./common/js/codemirror-4.0/theme/cobalt.css" />
<link rel="stylesheet" href="./common/js/codemirror-4.0/addon/display/fullscreen.css">
<input type="text" id="file">
<div id="contentArea">
	<div class="contentTop">
		<h2>모바일 편집기</h2>
	</div>
	<?php include "./include/tab_language.inc.php"?>
	<div class="" style="margin-top:10px;">
		<div class="my-fullscreen" style="background:#fff;">
			<a class="btn_blue_sml" href="javascript:goLayoutMHtmlModifyActEvent();"><strong>저장</strong></a>
			<a class="btn_blue_sml" href="javascript:goLayoutMHtmlMakeFolderMoveEvent();"><strong>폴더추가</strong></a>
			<a class="btn_blue_sml" href="javascript:goHtmlEditMakeFileMoveEvent();"><strong>파일추가</strong></a>
			<a class="btn_blue_sml" href="javascript:goHtmlEditMakeFileMoveEvent();"><strong>새이름 저장</strong></a>
			<a class="btn_blue_sml" href="javascript:goLayoutMHtmlModifyFullScreenEvent();"><strong>전체 화면(F11)</strong></a>
			<select id="bakList" onChange="goLayoutMHtmlBakFileReadEvent()">
				<option value="">이전 기록</option>
			</select>
		</div>
		<table summary="모바일 편집기" width="100%">
			<caption>모바일 편집기</caption>
			<colgroup>
				<col width="200px"/>
				<col width=""/>
			</colgroup>
			<tbody>
				<tr>
					<td style="vertical-align:top;">
						<div class="htmlBrowser"></div>
					</td>
					<td>
						<textarea id="code"></textarea>
					</td>			
				</tr>
			</tbody>
		</table>	
	</div>
	<div class="dialog" title="폴더추가">
		<div class="folderBrowser"></div>
		<div>
			<p>저장경로:<input type="text" id="dirName" readOnly style="width:100px"></p>
			<p>파일이름:<input type="text" id="fileName" style="width:100px"></p>
			<a href="#;">생성</a>
		</div>
	</div>
</div>

