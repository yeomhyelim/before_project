<script type="text/javascript">
<!--
	$(document).ready(function(){

		/*-- 이벤트 --*/
		onPageLoad();
	});

	/*-- 이벤트 --*/
	function postMailModifyMoveClickEvent()			{ goMove('postMailModify'); }			// 수정
	function postMailTestSendMoveClickEvent()		{ goMove('postMailTestSend'); }			// 테스트 메일 보내기
	function postMailShotMoveClickEvent()			{ goMove('postMailShot'); }				// 대량 메일 보내기
	function postMailListMoveClickEvent()			{ goSelectMove('postMailList',''); }	// 목록

	/*-- 이벤트 정의 --*/
	function onPageLoad() {

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
//-->
</script>