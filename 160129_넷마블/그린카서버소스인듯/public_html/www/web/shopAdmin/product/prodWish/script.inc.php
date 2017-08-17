<script type="text/javascript">
<!--
	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";

	$(document).ready(function(){
		C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");
	});


	function goOpenWindow(pcode) 
	{
		var strParam = "../?menuType=product&mode=view&act=list&prodCode=" + pcode;
		C_openWindow( strParam, "<?=$LNG_TRANS_CHAR['PW00001']?>", 1024, 768);
	}
//-->
</script>