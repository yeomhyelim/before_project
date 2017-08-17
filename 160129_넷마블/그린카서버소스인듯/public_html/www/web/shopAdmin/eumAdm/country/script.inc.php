<script type="text/javascript">
<!--
	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";

	$(document).ready(function(){
		C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");

		
		
	});
	
	function goAct(mode,no){

		if (mode == "countryZoneWrite" || mode == "countryZoneModify")
		{
			var strCountryCode		= "countryCode";
			var strCountryZone		= "countryZone";
			
			if (!C_isNull(no))
			{
				strCountryCode		= "countryCode_"+no;
				strCountryZone		= "countryZone_"+no;		
				
				$("#no").val(no);
			}
			
			if(!C_chkInput(strCountryCode,true,"국가",true)) return; //국가
			if(!C_chkInput(strCountryZone,true,"ZONE",true)) return; //ZONE

		}

		if (mode == "countryZoneDelete")
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