<script type="text/javascript">
<!--
	$(document).ready(function(){

		/*-- 이벤트 --*/
		onPageLoad();
		$("#allCheck").bind("click", function()		{ allCheckClickEvent(this); });	//체크박스 전체 선택

		/** textarea 최대 길이 설정 **/
		$('textarea[maxlen]').live('keyup change', function() {  
			var str			= $(this).val(); 
			var str_len		= C_getByteLength(str);
			var mx			= parseInt($(this).attr('maxlen'));
			$("#textByte").text(str_len + "/" + mx);
			if (str_len >= mx) {  
				$("#textByte").text(str_len + "/" + mx);
				$(this).val(str.substr(0, str.length-2));
				alert(mx+" byte 까지 등록가능합니다.");
				return false;  
			}
		});
	});

	/*-- 이벤트 --*/
	function postSmsWriteActClickEvent()			{ goAct('postSmsWrite'); }						// 신규등록(액션)
	function postSmsModifyActClickEvent()			{ goAct("postSmsModify"); }						// 수정(액션)
	function postSmsShotSendActClickEvent()			{ goAct('postSmsShotSend'); }					// 대량문자(액션)
	function postSmsDeleteActClickEvent(no)			{ postMailDeleteAct("postSmsDelete", no); }		// 삭제(액션)
	function postSmsSelectScriptClickEvent(no)		{ postSmsModifyMode(no); }						// 선택(스크랩트 실행)
	function postSmsCancelScriptClickEvent()		{ postSmsWriteMode(); }							// 취소(스크랩트 실행)
	function postSmsLogListMoveClickEvent(no)		{ goSelectMove('postSmsLogList', no); }			// 신규등록(액션)
	function goSearch()								{ goMove("postSmsMemberList"); }				// 맴버검색


	/*-- 이벤트 정의 --*/
	function onPageLoad() {
		postSmsModifyMode($("#ps_no").attr("value"));	
	}

	function postMailDeleteAct(mode, no) {
		// 삭제
		x = confirm("선택하신 문자 내용을 삭제하시겠습니까?"); 
		if(x==true) {
			goSelectAct(mode, no);
		}		
	}

	function postSmsModifyMode(no) {
		// 수정 모드
		if(no) {
			var ps_text = "#ps_text_" + no;
			$("#ps_text").text($(ps_text).text());
			$("#ps_no").attr("value", no);
			$("#btn_postSms_insert").css({'display':'none'});
			$("#btn_postSms_Modify").css({'display':''});
			$("#btn_postSms_Cancel").css({'display':''});
		}
	}

	function postSmsWriteMode() {
		// 신규등록 모드
		var no		= $("#ps_no").attr("value");
		var ps_text = "#ps_text_" + no;
		$("#ps_text").text("");
		$("#ps_no").attr("value", "");
		$("#btn_postSms_insert").css({'display':''});
		$("#btn_postSms_Modify").css({'display':'none'});
		$("#btn_postSms_Cancel").css({'display':'none'});

	}

	/*-- 기능 함수 --*/
	function goSelectMove(mode, no) {
		// 이동
		document.form.ps_no.value = no;
		goMove(mode);
	}

	function goMove(mode) {
		// 이동
		C_getMoveUrl(mode,"get","<?=$PHP_SELF?>");
	}

	function goSelectAct(mode, no) {
		// 액션
		document.form.ps_no.value = no;
		goAct(mode);
	}

	function goAct(mode) {
		// 액션
		C_getAction(mode,"<?=$PHP_SELF?>");
	}
	
	function allCheckClickEvent(data) {
		if($(data).attr("checked") == "checked"){
			$("input[name^=chkNo]").each(function() {
				$(this).attr("checked",true);
			});
		}else{
			$("input[name^=chkNo]").each(function() {
				$(this).attr("checked",false);
			});
		}
	}

//-->
</script>