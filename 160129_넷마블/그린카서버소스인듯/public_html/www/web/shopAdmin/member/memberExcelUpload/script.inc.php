<script type="text/javascript">
<!--
	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";

	$(document).ready(function(){
		C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");
	});
	

	function goMemberInsertWrite()
	{	
		var strExcelFile = document.form.excelFile.value;
		if (C_isNull(strExcelFile)){
			alert("<?=$LNG_TRANS_CHAR['CS00022']?>"); //엑셀파일을 업로드해주세요.
			return;
		}

		if (!C_isNull(strExcelFile))
		{
			if(!strExcelFile.toLowerCase().match(/(.xls)/)) { 
				alert("<?=$LNG_TRANS_CHAR['CS00021']?>"); //확장자 xls 엑실파일만 업로드하실 수 있습니다.
				return;
			}
		}
				
		document.form.encoding = "multipart/form-data";
		C_getAction("memberInsertWrite","<?=$PHP_SELF?>");
	}

	function goMemberInsertExcelDown(gb){
		if (gb == "kor")
		{
			location.href = "./?menuType=popup&mode=download&gb=member_kor_insert";
		}
	}
//-->
</script>