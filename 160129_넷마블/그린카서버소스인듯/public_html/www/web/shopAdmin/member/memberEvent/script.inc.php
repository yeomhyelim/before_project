<script type="text/javascript">
<!--
	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";

	$(document).ready(function(){
		C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");	
	});

	/* 회원생일/기념일 저장*/
	function goMemberEventSave()
	{
		C_getAction("memberEvent","<?=$PHP_SELF?>");
	}

//-->
</script>