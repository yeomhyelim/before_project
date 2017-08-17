<script type="text/javascript">
<!--
	$(document).ready(function(){

		/*-- 이벤트 --*/
		onPageLoad();
		$("#allCheck").bind("click", function()		{ allCheckClickEvent(this); });	//체크박스 전체 선택

	});

	/*-- 이벤트 --*/
	function goSearch()							{ goMove("postPaperShot"); }		// 검색
	function postPaperShotSendActClickEvent()	{ goAct('postPaperShotSend'); }		//  쪽지보내기
	function postPaperViewMoveClickEvent()		{ goMove('postPaperView'); }		// 취소


	/*-- 이벤트 정의 --*/
	function onPageLoad() {

	}




	/*-- 기능 함수 --*/
	function goSelectMove(mode, no) {
		// 이동
		document.form.pm_no.value = no;
		goMove(mode);
	}

	function goMove(mode) {
		// 이동
		C_getMoveUrl(mode,"get","<?=$PHP_SELF?>");
	}

	function goSelectAct(mode, no) {
		// 액션
		document.form.pm_no.value = no;
		goAct(mode);
	}

	function goAct(mode) {
		// 액션
		C_getAction(mode,"<?=$PHP_SELF?>");
	}
	
	function allCheckClickEvent(data) {
		if($(data).attr("checked") == "checked"){
			$("input[name^=selfCheck]").each(function() {
				$(this).attr("checked",true);
			});
		}else{
			$("input[name^=selfCheck]").each(function() {
				$(this).attr("checked",false);
			});
		}
	}

//-->
</script>