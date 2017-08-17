<?include "{$S_DOCUMENT_ROOT}www/include/header.inc.php"?>
<script type="text/javascript">
<!--
	$(document).ready(function(){


	});

	function goPaperWriteActEvent() { goPaperWriteActEvent(); }

	function goPaperWriteActEvent() {
		if(!C_chkInput("pp_title",true,"제목",true)) { return; }
		if(!C_chkInput("pp_text",true,"내용",true)) { return; }
		C_getAction("paperWrite","<?=$PHP_SELF?>");
	}
//-->
</script>

<form name="form" method="post" id="form">
<input type="hidden" name="menuType" value="product">
<input type="hidden" name="mode" value="">
<input type="hidden" name="act" value="">

제목 : <input type="text" name="pp_title" id="pp_title"/>
내용 : <textarea name="pp_text" id="pp_text"></textarea>
<a href="javascript:goPaperWriteActEvent()"> 등록 </a>
<a href="javascript:self.close()"> 취소 </a>
</form>
