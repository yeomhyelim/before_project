<?php
	## pName 설정
	$strP_NAME_URL = $prodRow['P_NAME'];
	$strP_NAME_URL = str_replace("\"","&quot;",$strP_NAME_URL);
?>
<link rel="stylesheet" href="../common/css/jquery.smartPop.css" />
<script language="javascript" type="text/javascript" src="../common/js/jquery.smartPop.js"></script>
<script type="text/javascript">
<!--
	$(document).ready(function(){

		/*-- 이벤트 --*/
		onPageLoad();
		$("img[id=selectImageClickEvent]").bind("click", function() { imageShowOpenWindow(this); });		// 다중이미지 클릭
		$("img[id=selectImageClickEvent]").mouseover( function() { selectImage(this); });					// 다중이미지 마우스 오버
		$("img[id=selectImageOverEvent]").mouseover( function() { selectImage(this); });					// 다중이미지 마우스 오버
		$("#zoomImgClickEvent").bind("click", function() { imageShowOpenWindow(this); });					// 줌이미지 클릭
	});

	/*-- 이벤트 --*/

	/*-- 이벤트 정의 --*/
	function onPageLoad() {
		selectImage($("#selectImageClickEvent"));
	}

	function selectImage(data) {
		
		// 다중이미지 클릭하면 메인 상품이미지 이미지 변경
		var strSelectImage	= $(data).attr("zImg");	
		$("#selectImage").attr("src", strSelectImage);
	}

	function imageShowOpenWindow(data) {
		// 오픈윈도우
		<? if($strOpenWinUse == "Y") : ?>
		var strUrl = "./?menuType=product&mode=open&openUrl=prodView.MultyImage&prodCode=<?=$strPCode?>&p_name="+encodeURIComponent("<?=$strP_NAME_URL?>");
		$.smartPop.open({  bodyClose: true, width: 800, height: 700, url: strUrl });
		<? endif; ?>
	}

	/*-- 기능 함수 --*/
	function goClose() {
		$.smartPop.close();
	}

//-->
</script>
