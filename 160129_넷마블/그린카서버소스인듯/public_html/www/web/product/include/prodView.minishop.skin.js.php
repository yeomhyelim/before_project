<script type="text/javascript">
<!--
	$(document).ready(function(){

		
	});

	function goPaperWriteMoveEvent() { goPaperWriteMove(); }
	function goMailWriteMoveEvent()  { goMailWriteMove(); }

	function goPaperWriteMove() {
		if(strMemberLogin == 1) {
			var prodCode	= $("input[name=prodCode]").val(); 
			var sh_no		= $("input[name=sh_no]").val(); 
			var href		= "./?menuType=message&mode=popPaperWriteForMinishop&sh_no="+sh_no+"&prodCode=" + prodCode;
			window.open(href,"","width=500px,height=500px");
		} else {
			alert("<?=$LNG_TRANS_CHAR['OS00014']?>");
		}
	}

	function goMailWriteMove() {
		if(strMemberLogin == 1) {
			var prodCode	= $("input[name=prodCode]").val(); 
			var sh_no		= $("input[name=sh_no]").val(); 
			var href		= "./?menuType=message&mode=popMailWriteForMinishop&sh_no="+sh_no+"&prodCode=" + prodCode;
			window.open(href,"","width=500px,height=500px");
		} else {
			alert("<?=$LNG_TRANS_CHAR['OS00014']?>");
		}
	}
//-->
</script>


