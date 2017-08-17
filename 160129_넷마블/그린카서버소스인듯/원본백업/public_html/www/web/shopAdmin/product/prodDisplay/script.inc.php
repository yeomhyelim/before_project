<script type="text/javascript">
<!--
	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";

	$(document).ready(function(){
		C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");
	});
		
	function goProdDisplay(){
		
		document.form.encoding = "multipart/form-data";
		C_getAction("prodDisplaySave","<?=$PHP_SELF?>");				
	}

	function goProdIconAdd()
	{
		var objCopyRow = $("#tabIconList tr:eq(0)").clone();
		objCopyRow.find('img').remove();
		objCopyRow.find('[name^=iconNo]').val('');
		objCopyRow.find('[name^=iconName]').val('사용자정의');
		objCopyRow.find('a.btn_sml').html('<strong>삭제</strong>');
		objCopyRow.find('a.btn_sml').attr('href','javascript:void(0);');
		objCopyRow.find('a.btn_sml').attr('onclick','goProdIconAddDel(this);');
		$("#tabIconList").append(objCopyRow);
	}

	function goProdIconAddDel(myThis)
	{
		$(myThis).parent().parent().remove();
	}
// 2015.03.04 kim hee sung
// 신규아이콘 생성 오류
//	function goProdIconAdd()
//	{
//		var objCopyRow = $("#tabIconList tr:eq(0)").clone();
//		var intTrCnt = $("#tabIconList tr").length;
//		
//		objCopyRow.find("input[type^=text]").val("");
//		objCopyRow.find("input[type^=hidden]").val("");
//		
//		objCopyRow.find("td:eq(0)").html("");
//		objCopyRow.find("td:eq(2)").html("");
//
//		$("#tabIconList").append(objCopyRow);
//	}

	function goProdIconDel(obj)
	{		
		if ($("#tabIconList tr").length > 7)
		{
			$("#tabIconList tr:last").remove();
		}	
	}

	function goProdIconDel(no)
	{
		var x = confirm("<?=$LNG_TRANS_CHAR['CS00007']?>"); //선택하신 아이콘을 삭제하시겠습니까?
		if (x == true)
		{
			$("#prodIconNo").val(no);
			C_getAction("prodIconDel","<?=$PHP_SELF?>");
		}
	}

	function goProdIconRecovery(no)
	{
		var x = confirm("<?=$LNG_TRANS_CHAR['CS00008']?>"); //선택하신 아이콘을 복원하시겠습니까?
		if (x == true)
		{
			$("#prodIconNo").val(no);
			C_getAction("prodIconRecovery","<?=$PHP_SELF?>");
		}
	}
//-->
</script>