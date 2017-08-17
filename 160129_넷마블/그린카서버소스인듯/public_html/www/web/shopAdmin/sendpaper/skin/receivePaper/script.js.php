<script type="text/javascript">
<!--

	$(document).ready(function() {
	
	
	});


	function goSendPaperWriteMoveEvent()			{ goSendPaperWriteMove();				}
	function goSendPaperWriteMultiMoveEvent()		{ goSendPaperWriteMultiMove();			}
	function goReceivePaperListMoveEvent()			{ goReceivePaperListMove();				} 
	function goReceivePaperDeleteActEvent()			{ goReceivePaperDeleteAct();			}
	function goReceivePaperMultiDeleteActEvent()	{ goReceivePaperMultiDeleteAct();		}

	function goSendPaperWriteMultiMove() {
		var cnt = $("input#selfCheck:checked").length;
		if(cnt <= 0) {
			alert("쪽지를 먼저 선택해주세요.");
			return false;
		}

		var mp_no = "";
		$("input#selfCheck:checked").each(function() {
			if(mp_no) { mp_no = mp_no + ","; }
			mp_no = mp_no + $(this).val();
		});
		var href	= "./?menuType=sendpaper&mode=sendPaperMultiWrite&myTarget=pop&mp_no=" + mp_no;
		window.open(href,"","width=800px,height=600px");
	}

	function goReceivePaperDeleteAct() {
		var x = confirm("삭제하시겠습니까?");
		if (x == true) {
			C_getAction("receivePaperDelete","<?=$PHP_SELF?>");
		}
	}

	function goReceivePaperListMove() {
		var page		= $("input[name=page]").val();
		var href		= "./?menuType=sendpaper&mode=receivePaperList&page=" + page;
		location.href	= href;
	}

	function goSendPaperWriteMove() {
		var mp_no	= $("input#mp_no").val();
		var href	= "./?menuType=sendpaper&mode=sendPaperWrite&myTarget=pop&mp_no=" + mp_no;
		window.open(href,"","width=800px,height=600px");
	}

	function goReceivePaperMultiDeleteAct() {
		var cnt = $("input#selfCheck:checked").length;
		if(cnt <= 0) {
			alert("쪽지를 먼저 선택해주세요.");
			return false;
		}
		var x = confirm("삭제하시겠습니까?");
		if (x == true) {
			C_getAction("receivePaperMultiDelete","<?=$PHP_SELF?>");
		}
	}
//-->
</script>