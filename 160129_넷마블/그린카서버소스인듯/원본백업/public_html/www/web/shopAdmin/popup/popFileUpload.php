<?
	## 설정
//	require_once "{$S_DOCUMENT_ROOT}www/classes/file/file.handler.class.php";
//	$file		= new FileHandler();
	$ftp_home	= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/upload/images";

//	$aryFileList = $file->fileList($ftp_home);
	$fileList	= scandir($ftp_home) or die("scandir failed");

?>
<? include "./include/header.inc.php"?>
<script language="javascript" type="text/javascript" src="../common/js/jquery.form.js"></script>
<script language="javascript" type="text/javascript" src="/common/js/common3.js"></script>
<script type="text/javascript" charset="utf-8">
	
	var G_PHP_SELF		= "./";

	/* 이벤트 정의 */
	//function goAttachedfileFtpFileUploadAct()			{	goFileAct("ftpFileUpload");				}		// 커뮤니티 펌부파일 파일업로드
	function goAttachedfileFtpFileUploadActEvent()		{	goAttachedfileFtpFileUploadAct();		}		// 커뮤니티 펌부파일 파일업로드
	function goAttachedfileFtpFileDeleteActEvent(name)	{	goAttachedfileFtpFileDeleteAct(name);	}
//	function goAttachedfileFtpFileDeleteAct()			{	goFileAct("ftpFileDelete");	}
	function goAttachedfileClose()						{	self.close(); }

	function ftpFileUploadCallBack(obj) {

		if(obj.mode){
			// 파일 업로드가 되었다면.
			for(var i in obj.data){
				var ext     = getFileExtension(obj.data[i]);
				    ext		= ext.toLowerCase();
				var code	="<li class='icon_"+ext+"'><span>"+obj.data[i]+"</span><a href=\"javascript:goAttachedfileFtpFileDeleteActEvent('"+obj.data[i]+"')\" class='imgDel'>X</a></li>";
				var check	= "";
				$("ul[id=ftpList]").find("li > span").each(function() {
					if($(this).text() == obj.data[i]) {
						check = "Y";
					}
				});
				if(check!="Y"){
					$("ul[id=ftpList]").append(code);	
				}
			}
			$("input[type=file]").val("");
			location.reload();
		}
	}

	function goAttachedfileFtpFileUploadAct() {

		/** 파일 체크 **/
		var fileCheck	= "";
		var intCnt		= 0;
		$("input[type=file]").each(function() {
			if($(this).val()){
				intCnt++;
				var fileName = getFileName($(this).val());
				$("ul[id=ftpList]").find("li > span").each(function() {
					if($(this).text() == fileName) {
						var  x = confirm(fileName + " 중복 파일이 있습니다. 계속 작업하시겠습니까?");
						if (x != true) {
							fileCheck = "Y";
							return false;
						}
					}
				});
			}
		});

		if(fileCheck == "" && intCnt > 0) {
//			goFileAct("ftpFileUpload");	
			goFileActJson("ftpFileUpload", "ftpFileUploadCallBack");
		}
	}

	function goAttachedfileFtpFileDeleteAct(name) {

		var  x = confirm("삭제하시겠습니까?");
		if (x != true) {
			return;
		}

		$("input[name=deleteFile]").val(name);
//		goFileAct("ftpFileDelete");
		goFileActJson("ftpFileDelete", "ftpFileDeleteCallBack");
	}

	function ftpFileDeleteCallBack(obj) {
		if(obj.mode){
			// 파일 삭제가 되었다면.
			$("ul[id=ftpList]").find("li > span").each(function() {
				if($(this).text() == obj.data) {
					$(this).parent().remove();
				}
			});
			location.reload();
		}
	}

	function getFileName(filePath){  
		var lastIndex	= -1;
		var extension	= "";
			lastIndex	= filePath.lastIndexOf('\\');

		if(lastIndex != -1){	extension = filePath.substring( lastIndex+1, filePath.len );
		}else{					extension = "";		}

		return extension;
	}

	function getFileExtension(filePath){  
		var lastIndex	= -1;
		var extension	= "";
			lastIndex	= filePath.lastIndexOf('.');

		if(lastIndex != -1){	extension = filePath.substring( lastIndex+1, filePath.len );
		}else{					extension = "";		}

		return extension;
	}
</script>

<form name="form" id="form" method="post" enctype="multipart/form-data">
<input type="hidden" name="menuType" id="menuType" value="layout">
<input type="hidden" name="mode" id="mode" value="ftpFileUpload">
<input type="hidden" name="act" id="act" value="">
<input type="hidden" name="page" id="page" value="">
<input type="hidden" name="deleteFile" id="deleteFile" value="">
<div class="ftpWrapper">
	<dl>
			<dd class="cateTree"></dd>
			<dd class="imgList">
				<div class="imgListWrap">
					<ul id="ftpList">
						<?foreach ($fileList as $file):?>
						<?if(!is_file("$ftp_home/$file") || $file == '.' || $file == '..') { continue; }
						  $fileinfo = pathinfo("$ftp_home/$file");
						  $ext = $fileinfo['extension'];			?>
						<li class="icon_<?=strtolower($ext)?>"><span><?=$file?></span> <a href="javascript:goAttachedfileFtpFileDeleteActEvent('<?=$file?>')" class="imgDel">X</a></li>
						<?endforeach;?>
					</ul>
				</div>
			</dd>
			<dd class="fileUpload">
				<ul>
					<li><input type="file" name="file[]"/></li>
					<li><input type="file" name="file[]"/></li>
					<li><input type="file" name="file[]"/></li>
					<li><input type="file" name="file[]"/></li>
					<li><input type="file" name="file[]"/></li>
					<li><input type="file" name="file[]"/></li>
					<li><input type="file" name="file[]"/></li>
					<li><input type="file" name="file[]"/></li>
					<li><input type="file" name="file[]"/></li>
					<li><input type="file" name="file[]"/></li>
					<li><a href="javascript:goAttachedfileFtpFileUploadActEvent();" class="btn_blue_big"><strong>업로드</strong></a></li>
				</ul>
			</dd>
	</dl>
</div>


</form>