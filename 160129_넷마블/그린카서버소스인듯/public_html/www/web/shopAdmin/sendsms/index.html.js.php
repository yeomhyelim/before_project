<script type="text/javascript">
<!--

	$(document).ready(function() {
	
		C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");
	
	});


	/* 버튼 이벤트 */
	function goMoveUrl(mode,no)
	{
		switch (mode)
		{
		case "smsModify":
	
			C_getAction(mode,"<?=$PHP_SELF?>")

		break;

		case "smsUseType":

			C_getAction(mode,"<?=$PHP_SELF?>")

		break;
		}
	}

//-->
</script>