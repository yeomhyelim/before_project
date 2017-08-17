<?
	//editor 파일 업로드 시작
	$column = "high_attachImage";

	$upload		= $_POST["editor_upload"]	? $_POST["editor_upload"]			: $_REQUEST["editor_upload"];
	$ifrmObjId	= $_POST["ifrmObjId"]		? $_POST["ifrmObjId"]		: $_REQUEST["ifrmObjId"];
	

	if(!is_dir( WEB_UPLOAD_PATH . $upload ))
	{
		@mkdir( WEB_UPLOAD_PATH . $upload ,0707);
		@chmod( WEB_UPLOAD_PATH . $upload ,0707);				
	}

	$upload		= $upload."/".date("Ymd");
	
	if ($_FILES[$column][name]) {

		$filename = $_FILES[$column][name];
		$tmpname  = $_FILES[$column][tmp_name];
		$filesize = $_FILES[$column][size];
		$filetype = $_FILES[$column][type];
	
		$number = date("YmdHis");		//파일명 숫자로 변경
	
		/*디렉토리생성유무*/
//		$makeDirName = WEB_UPLOAD_PATH . "/editor/" . date("Ymd");	
		$makeDirName		= WEB_UPLOAD_PATH . $upload;
		
		$editerDirName		= sprintf("../upload%s", $upload); 
		if(!is_dir($makeDirName))
		{
			@mkdir($makeDirName,0707);
			@chmod($makeDirName,0707);				
		}
		/*디렉토리생성유무*/
		
		$fres = $fh->doUpload("$number",$makeDirName,$filename,$tmpname,$filesize,$filetype);
		
		if(!$fres) {
			echo($filename."이미지 파일이 등록되지 않았습니다.");
		} else {
			$file_name = $fres[file_real_name];
			echo "이미지 파일이 등록 되었습니다.";
	?>
	<script type="text/javascript" language="javascript">
//	alert("<?=$ifrmObjId?>");
	parent.editorExec('insertimage', false, '<?=$editerDirName?>/<?=$file_name?>', '<?=$ifrmObjId?>');
	</script>
<?
	}
	} else {
		echo("이미지 파일이 등록되지 않았습니다.");
	}
//editor 파일 업로드 종료
?>

