<script type="text/javascript">
<!--

	$(document).ready(function() {
	
	
	});


	function goPostPaperWriteCancelEvent()	{ goPostPaperWriteCancel(); }
	function gpPostPaperWriteActEvent()		{ gpPostPaperWriteAct();	}

	function gpPostPaperWriteAct() {
		if(C_dataEmptyCheck()){ return false; }
		C_getAction("postPaperWrite","<?=$PHP_SELF?>");
	}

	function goPostPaperWriteCancel() {
		var myTarget = $("input#myTarget").val();
		if(myTarget == "pop"){
			self.close();
			return;
		} else {
		}
	}
//-->
</script>