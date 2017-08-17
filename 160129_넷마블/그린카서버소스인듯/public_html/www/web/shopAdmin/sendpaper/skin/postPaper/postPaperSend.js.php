<script type="text/javascript">
<!--
	$(document).ready(function(){

		/*-- 이벤트 --*/
		onPageLoad();
	});

	/*-- 이벤트 --*/
	function postPaperSendParentGoClickEvent()	{ goPostPaperSendParentGo(); }						// 보내기
	function postPaperCloseClickEvent()			{ goPopClose(); }									// 팝업닫기

	/*-- 이벤트 정의 --*/
	function onPageLoad() {

	}

	function goPostPaperSendParentGo() {

		if(!C_chkInput("pp_title",true,"제목",true)) return;
		if(!C_chkInput("pp_text",true,"내용",true)) return;

		var title	= $("input[name=pp_title]").val();
		var text	= $("textarea[name=pp_text]").val();

		parent.goPostPaperSendPopEvent(title, text);
		goPopClose();
	}


	/*-- 기능 함수 --*/
	function goSelectMove(mode, no) {
		// 이동
		document.form.pm_no.value = no;
		C_getMoveUrl(mode,"get","<?=$PHP_SELF?>");
	}

	function goMove(mode) {
		// 이동
		C_getMoveUrl(mode,"get","<?=$PHP_SELF?>");
	}

	function goAct(mode) {
		// 액션
		C_getAction(mode,"<?=$PHP_SELF?>");
	}

	function goPopClose() {
		// 팝업 닫기
		parent.goPopClose();
	}
//-->
</script>