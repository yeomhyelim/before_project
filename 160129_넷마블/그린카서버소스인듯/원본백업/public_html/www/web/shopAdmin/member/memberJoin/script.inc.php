<script type="text/javascript">
<!--
	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";

	$(document).ready(function(){
		C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");	
	});

	function goSettingModify()
	{
		C_getAction("settingModify","<?=$PHP_SELF?>");
	}
	
	/* 회원가입항목 저장*/
	function goJoinItemSave()
	{
		C_getAction("joinItemSave","<?=$PHP_SELF?>");
	}
//-->
</script>