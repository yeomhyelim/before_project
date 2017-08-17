<script type="text/javascript">
<!--

	$(document).ready(function() {
	
	
	});


	function goSendPaperWriteCancelEvent()	{ goSendPaperWriteCancel(); }
	function goSendPaperWriteActEvent()		{ goSendPaperWriteAct();	}

	function goSendPaperWriteAct() {

		if(C_dataEmptyCheck()){ return false; }
		C_getAction("sendPaperWrite","<?=$PHP_SELF?>");
	}

	function goSendPaperWriteCancel() {
		var myTarget = $("input#myTarget").val();
		if(myTarget == "pop"){
			self.close();
			return;
		} else {
		}
	}
//-->
</script>