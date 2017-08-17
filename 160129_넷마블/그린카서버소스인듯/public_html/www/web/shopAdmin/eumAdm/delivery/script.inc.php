<script type="text/javascript">
<!--
	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";

	$(document).ready(function(){
		C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");
		$("#deliveryZone").focus();
	});
	
	function goAct(mode,no){

		if (mode == "deliveryWrite" || mode == "deliveryModify")
		{
			var strDeliveryZone		= "deliveryZone";
			var strDeliveryWeight	= "deliveryWeight";
			var strDeliveryPrice	= "deliveryPrice";

			if (!C_isNull(no))
			{
				strDeliveryZone		= "deliveryZone_"+no;
				strDeliveryWeight	= "deliveryWeight_"+no;
				strDeliveryPrice	= "deliveryPrice_"+no;				
				
				$("#no").val(no);
			}
			
			if(!C_chkInput(strDeliveryZone,true,"지역",true)) return; //지역
			if(!C_chkInput(strDeliveryWeight,true,"무게",true)) return; //무게
			if(!C_chkInput(strDeliveryPrice,true,"금액",true)) return; //금액

		}

		if (mode == "deliveryDelete")
		{
			var x = confirm("선택한 데이터를 삭제하시겠습니까?");
			if (x != true)
			{
				return;
			}

			$("#no").val(no);
		}
		
		C_getAction(mode,"<?=$PHP_SELF?>");
	}
//-->
</script>