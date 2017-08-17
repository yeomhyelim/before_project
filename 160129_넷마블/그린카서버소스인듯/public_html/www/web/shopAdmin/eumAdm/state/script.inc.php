<script type="text/javascript">
<!--
	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";

	$(document).ready(function(){
		C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");

		
		
	});
	
	function goAct(mode,no){

		if (mode == "countryStateWrite" || mode == "countryStateModify")
		{
			var strCountryStateCode		= "countryStateCode";
			var strCountryStateName		= "countryStateCode";
			var strCountryStateArea		= "countryStateArea";
			
			if (!C_isNull(no))
			{
				strCountryStateCode		= "countryStateCode_"+no;
				strCountryStateName		= "countryStateCode_"+no;
				strCountryStateArea		= "countryStateArea_"+no;
				
				$("#no").val(no);
			}
			
			if(!C_chkInput(strCountryStateCode,true,"주코드",true)) return; //주
			if(!C_chkInput(strCountryStateName,true,"주이름",true)) return; //주명
		}

		if (mode == "countryStateDelete")
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