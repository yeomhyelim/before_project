<?
	## 파일 리스트
	$dir		= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/htmlTag/kr";
	require_once MALL_HOME . "/classes/file/file.handler.class.php";
	$file		= new FileHandler();
	$fileList	= $file->fileList($dir);

	## 데이터
	if(is_file("{$dir}/{$_GET['fileName']}")):
		$fileContents = file_get_contents("{$dir}/{$_GET['fileName']}");
	endif;
?>

<script type="text/javascript">
<!--
	function goHtmlEditModifyMoveEvent(fileName)	{ goHtmlEditModifyMove(fileName);	}
	function goHtmlEditMakeFileMoveEvent()			{ goHtmlEditMakeFileMove();			}

	function goHtmlEditMakeFileMove() {
		var lang	= $("input[name=lang]").val();
		var href	= "./?menuType=layoutNew&mode=popHtmlMakeFile&lang=" + lang;
		window.open(href, "", "width=600px,height=100px");
	}

	function goHtmlEditModifyMove(fileName) {
		var data			= new Array(5);
		data['fileName']	= fileName;
		C_getAddLocationUrl(data);
	}
//-->
</script>

<div class="contentTop">
	<h2>HTML 편집기</h2>
</div>

<?include "./include/tab_language.inc.php"?>

<div class="tableForm" style="margin-top:10px;">
	<a class="btn_blue_sml" href="javascript:goHtmlEditMakeFileMoveEvent();"><strong>파일 생성</strong></a>
	<table>
		<tr>
			<td style="width:150px">
			<?foreach($fileList as $key => $fileName):?>
			<a href="javascript:goHtmlEditModifyMoveEvent('<?=$fileName?>')"><?=$fileName?></a><br>
			<?endforeach;?>
			</td>
			<td><textarea style="width:100%;height:400px" data-textarea-tab-key-no-move><?=$fileContents?></textarea></td>
		</tr>
	</table>
</div>