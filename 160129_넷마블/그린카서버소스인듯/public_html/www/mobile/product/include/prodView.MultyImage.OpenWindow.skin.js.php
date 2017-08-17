<script type="text/javascript">
<!--
	$(document).ready(function(){

		/*-- 이벤트 --*/
		onPageLoad();
		$("img[id=selectImageClickEvent]").mouseover( function() { selectImage(this); });					// 다중이미지 마우스 오버
	});

	/*-- 이벤트 --*/

	/*-- 이벤트 정의 --*/
	function onPageLoad() {
		selectImage($("#selectImageClickEvent"));
	}

	function selectImage(data) {
		// 다중이미지 클릭하면 메인 상품이미지 이미지 변경
		var strSelectImage = $(data).attr("src");	
		$("#selectImage").attr("src", strSelectImage);
	}

	/*-- 기능 함수 --*/
	function goClose() {
		parent.goClose();
	}

//-->
</script>


