<?
	require_once "../config.inc.php";	
	require_once "../config/shop.inc.php";
	
	require_once MALL_CONF_MYSQL;
	require_once MALL_CONF_FILE;
	require_once MALL_COMM_LIB;
	require_once MALL_CONF_SESS;
	
	//editor 파일 업로드 시작
	$column = "high_attachImage";

	$upload		= $_POST["editor_upload"]	? $_POST["editor_upload"]			: $_REQUEST["editor_upload"];
	$ifrmObjId	= $_POST["ifrmObjId"]		? $_POST["ifrmObjId"]		: $_REQUEST["ifrmObjId"];
	
	echo $upload.":".$ifrmObjId;
	exit;
	if ($_FILES[$column][name]) {

		$filename = $_FILES[$column][name];
		$tmpname  = $_FILES[$column][tmp_name];
		$filesize = $_FILES[$column][size];
		$filetype = $_FILES[$column][type];
	
		$number = date("YmdHis");		//파일명 숫자로 변경
	
		$fres = $fh->doUpload("$number","../..".$upload,$filename,$tmpname,$filesize,$filetype);
		

		if(!$fres) {
			echo("이미지 파일이 등록되지 않았습니다.");
		} else {
			
			
			$file_name = $fres[file_real_name];

			echo "이미지 파일이 등록 되었습니다.";
	?>
	<script type="text/javascript" language="javascript">
	parent.editorExec('insertimage', false, '<?=$upload?>/<?=$file_name?>', '<?=$ifrmObjId?>');
	</script>
<?
	}
	} else {
		echo("이미지 파일이 등록되지 않았습니다.");
	}
//editor 파일 업로드 종료
?>

