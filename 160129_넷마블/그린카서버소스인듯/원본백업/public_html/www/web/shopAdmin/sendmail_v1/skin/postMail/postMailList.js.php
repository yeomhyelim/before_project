<script type="text/javascript">
<!--
	$(document).ready(function(){

		/*-- 이벤트 --*/
		onPageLoad();
		$("#allCheck").bind("click", function()		{ allCheckClickEvent(this); });	//체크박스 전체 선택

	});

	/*-- 이벤트 --*/
	function postMailWriteMoveClickEvent(no)		{ goSelectMove('postMailWrite', no); }			// 신규등록
	function postMailViewMoveClickEvent(no)			{ goSelectMove('postMailView', no); }			// 상세보기
	function postMailDeleteActClickEvent(no)		{ postMailDeleteAct('postMailDelete', no) }		// 삭제
	function postMailLogListMoveClickEvent(no)		{ goSelectMove('postMailLogList', no); }		// 발송내역
	
	/*-- 이벤트 정의 --*/
	function onPageLoad() {

	}

	function postMailDeleteAct(mode, no) {
		// 삭제
		x = confirm("선택하신 메일 내용을 삭제하시겠습니까?"); 
		if(x==true) {
			goSelectAct(mode, no);
		}		
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