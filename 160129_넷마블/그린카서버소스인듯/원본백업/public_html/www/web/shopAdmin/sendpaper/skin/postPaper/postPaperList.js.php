<script type="text/javascript">
<!--
	$(document).ready(function(){

		/*-- 이벤트 --*/
		onPageLoad();
		$("#allCheck").bind("click", function()		{ allCheckClickEvent(this); });	//체크박스 전체 선택

	});

	/*-- 이벤트 --*/
	function postPaperWriteMoveClickEvent()			{ goMove('postPaperWrite'); }					// 신규등록(이동)
	function postPaperViewClickEvent(no)			{ goSelectMove('postPaperView',no); }			// 내용보기
	function postPaperLogListMoveClickEvent(no)		{ goSelectMove('postPaperLogList', no); }		// 발송내역(액션)
	function postPaperDeleteActClickEvent(no)		{ postPaperDeleteAct("postPaperDelete", no); }	// 삭제(액션)


	/*-- 이벤트 정의 --*/
	function onPageLoad() {

	}

	function postPaperDeleteAct(mode, no) {
		// 삭제
		x = confirm("선택하신 쪽지 내용을 삭제하시겠습니까?"); 
		if(x==true) {
			goSelectAct(mode, no);
		}		
	}


	/*-- 기능 함수 --*/
	function goSelectMove(mode, no) {
		// 이동
		document.form.pp_no.value = no;
		goMove(mode);
	}

	function goMove(mode) {
		// 이동
		C_getMoveUrl(mode,"get","<?=$PHP_SELF?>");
	}

	function goSelectAct(mode, no) {
		// 액션
		document.form.pp_no.value = no;
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