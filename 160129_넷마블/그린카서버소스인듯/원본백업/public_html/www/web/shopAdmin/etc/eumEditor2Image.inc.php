<?php

	## json 처리 부분
	if($strMode == "json"):

		## 2014.08.28
		## kim hee sung
		## 다음 에디터 json 처리 부분입니다.

		switch($strAct):

		case "eumEditor2Image":
			// 이미지 업로드

			## 기본설정
			$strEditorDir = $_POST['editorDir'];
			$aryFile = $_FILES['file'];
			$strWebDir = "/upload/eumEditor2/{$strEditorDir}/" . date("Ym");
			$strFullDir = MALL_SHOP . $strWebDir;		

			## 체크
			if(!$aryFile):
				$result['__STATE__'] = "NO_FILE";
				$result['__MSG__'] = "업로드 파일이 없습니다.";
				break;	
			endif;
			if(!$strEditorDir):
				$result['__STATE__'] = "NO_DIR";
				$result['__MSG__'] = "업로드 경로 설정이 없습니다.";
				break;	
			endif;
			if($strEditorDir[0] == "/" || $strEditorDir[0] == "."):
				$result['__STATE__'] = "WRONG_DIR";
				$result['__MSG__'] = "형식이 잘못된 경로입니다.";
				break;	
			endif;
			if(eregi("\.", $strEditorDir)):
				$result['__STATE__'] = "WARNING_DIR";
				$result['__MSG__'] = "금지된 주소 형식입니다.";
				break;	
			endif;

			if (!getAllowImgFileExt($aryFile['name'])){
				$result['__STATE__'] = "WARNING_DIR";
				$result['__MSG__'] = 'Only Image File Upload';
				break;
			}

			//3,145,728 = 3M 업로드 제한. 남덕희
			$uploadLimit = 3145728;
			if($aryFile['size'] > $uploadLimit ):
				$result['__STATE__'] = "WARNING_DIR";
				$result['__MSG__'] = callLangTrans($LNG_TRANS_CHAR["BS00089"],array('3M'));//{{단어1}} 이상 업로드 할 수 없습니다.
				break;
			endif;

			## 파일설정
			$strName = $aryFile['name'];
			$strType = $aryFile['type'];
			$strTmpName = $aryFile['tmp_name'];
			$strError = $aryFile['error'];
			$intSize = $aryFile['size'];

			## 체크
			if(!$strName):
				$result['__STATE__'] = "NO_FILE";
				$result['__MSG__'] = "예상치 못한 오류가 발생했습니다. 잠시후에 다시 작성하세요.";
				break;	
			endif;
			if($strError):
				$result['__STATE__'] = "NO_FILE";
				$result['__MSG__'] = "예상치 못한 오류가 발생했습니다. 잠시후에 다시 작성하세요.";
				break;	
			endif;

			## 폴더 생성
			if(!FileDevice::makeFolder($strFullDir)):
				$result['__STATE__'] = "NO_DIR";
				$result['__MSG__'] = "디렉토리를 생성 할 수 없습니다. 관리자에게 문의하세요.";
				break;
			endif;

			## 유니크한 파일명 만들기
			$strSaveFileName = time() . "_%s_@_{$strName}";
			$strSaveFileName = FileDevice::getUniqueFileName($strFullDir, $strSaveFileName);
			if(!$strSaveFileName):
				$result['__STATE__'] = "NO_FILE_NAME";
				$result['__MSG__'] = "업로드 할 수 없습니다. 관리자에게 문의하세요.";
				break;	
			endif;

			## 파일 업로드
			$re = FileDevice::upload("file", "{$strFullDir}/{$strSaveFileName}");

			## 전달 데이터 만들기
			$aryReturnData['imageurl'] = "{$strWebDir}/{$strSaveFileName}";
			$aryReturnData['filename'] = $strName;
			$aryReturnData['filesize'] = $intSize;
			$aryReturnData['imagealign'] = "C";
			$aryReturnData['originalurl'] = "{$strWebDir}/{$strSaveFileName}";
			$aryReturnData['thumburl'] = "{$strWebDir}/{$strSaveFileName}";
			$aryReturnData['attachurl'] = "{$strWebDir}/{$strSaveFileName}";
			$aryReturnData['filemime'] =  FileDevice::my_mime_content_type($strName);
			
			## 마무리
			$result['__STATE__'] = "SUCCESS";
			$result['__DATA__'] = $aryReturnData;
		break;

		endswitch;


		## 체크
		if(!$result) { $result = print_r($_POST, true); }

		## 출력
		echo json_encode($result);

		exit;

	endif;


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>이미지 첨부</title> 
<script src="/common/js/jquery-1.7.2.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/common/js/jquery.form.js" type="text/javascript" charset="utf-8"></script>
<script src="/common/eumEditor2/js/popup.js" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" href="/common/eumEditor2/css/popup.css" type="text/css"  charset="utf-8"/>
<script type="text/javascript">
// <![CDATA[

	function done() {

		// 기본설정
		var objTarget = $('form[name=imageForm]');
		var strFile = objTarget.find('[name=file]').val();

		// 체크
		if(!strFile) {
			alert('파일을 선택하세요.');
			return;
		}

		// 데이터 전달
		objTarget.ajaxForm({
			beforeSubmit :	function() {
			},
			success		 :  function(data) {
				data =  $.parseJSON(data);
				if(data['__STATE__'] == "SUCCESS") {
				
					// 기본 설정
					var objData = data['__DATA__'];
					var filename = objData['filename'];
					var filesize = objData['filesize'];
//					var imagealign = objData['imagealign'];
					var imageurl = objData['imageurl'];
					var originalurl = objData['originalurl'];
					var thumburl = objData['thumburl'];

					var _mockdata = {
						'imageurl': imageurl,
						'filename': filename,
						'filesize': filesize,
//						'imagealign': imagealign, 
						'originalurl': originalurl,
						'thumburl': thumburl
					};

					execAttach(_mockdata);
					
					closeWindow();

				} else {
					var strMsg = data['__MSG__'];
					if(!strMsg) { strMsg = data; }
					alert(strMsg);
				}
		   }
		}); 

		objTarget.submit();

	}

	function initUploader(){

		// 부모창 체크
	    var _opener = PopupUtil.getOpener();
	    if (!_opener) {
	        alert('잘못된 경로로 접근하셨습니다.');
	        return;
	    }
		// 기본설정
		var idx = _opener.Editor.initialConfig.initializedId;
		var eumEditor2Conf = null;

		// 디렉토리 설정
		     if(idx == '1') { eumEditor2Conf = _opener.eumEditor2Conf1; }
		else if(idx == '2') { eumEditor2Conf = _opener.eumEditor2Conf2; }
		else {
			alert('파일을 첨부팔수 없습니다. config를 먼저 선언해주시기 바랍니다.');
			return;
		}
		var strDir = eumEditor2Conf['dir'];
		if(!strDir) {
			alert('업로드할 디렉토리를 먼저 작성해주세요.');
			return;
		}

		// 기본 설정
		var objTarget  = $('[name=imageForm]');
	    objTarget.find('[name=editorDir]').val(strDir);

	    var _attacher = getAttacher('image', _opener);
	    registerAction(_attacher);
	}

// ]]>
</script>
</head>
<body onload="initUploader();">
<div class="wrapper">
	<div class="header">
		<h1>사진 첨부</h1>
	</div>	
	<div class="body">
	<form name="imageForm" method="post" enctype="multipart/form-data" action="./">
	<input type="hidden" name="menuType" value="etc"/>
	<input type="hidden" name="mode" value="json"/>
	<input type="hidden" name="act" value="eumEditor2Image"/>
	<input type="hidden" name="editorDir"/>
		<dl class="alert">
		    <dt>사진 첨부 확인</dt>
		    <dd><input type="file" name="file"></dd>
			<dd>&nbsp;</dd>
			<dd>사진은 한 건 당 3MB 이하의 크기만 등록 가능합니다.</dd>
		</dl>
	</form>
	</div>
	<div class="footer">
		<p><a href="javascript:void(0);" onclick="closeWindow();" title="닫기" class="close">닫기</a></p>
		<ul>
			<li class="submit"><a href="javascript:void(0);" onclick="done();" title="등록" class="btnlink">등록</a> </li>
			<li class="cancel"><a href="javascript:void(0);" onclick="closeWindow();" title="취소" class="btnlink">취소</a></li>
		</ul>
	</div>
</div>
</body>
</html>