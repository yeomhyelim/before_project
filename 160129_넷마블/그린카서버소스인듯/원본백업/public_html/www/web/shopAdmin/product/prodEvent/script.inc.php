<script type="text/javascript">
<!--
	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";

	$(document).ready(function(){
		C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");
			
		$('input[name=eventStartDt]').simpleDatepicker();
		$('input[name=eventEndDt]').simpleDatepicker();
	
		$("#type").live("click",function(){
			
			$("#divDiscountPeriodN").css("display", "none");
			$("#divDiscountPeriodG").css("display", "none");
			
			$("#divDiscountPeriod"+$(this).val()).css("display", "block");			
		});		
	});
	
	function goPopClose()
	{		
		$.smartPop.close();
	}

	function goModify(no)
	{
		$.smartPop.open({  bodyClose: false, width: 600, height: 300, url: './?menuType=product&mode=popProdEvent&no='+no, closeImg: {width:23, height:23, src:'/shopAdmin/himg/common/btn_pop_close.png'} });
	}
	
	function goDelete(no)
	{
		var x = confirm("<?=$LNG_TRANS_CHAR['PS00035']?> <?=$LNG_TRANS_CHAR['CS00007']?>"); //데이터를 삭제하시겠습니까?
		if (x == true)
		{
			document.form.no.value = no;
			C_getAction("prodEventDelete",'<?=$PHP_SELF?>');
		}
	}
	function goAct(mode)
	{
		if(!C_chkInput("title",true,"<?=$LNG_TRANS_CHAR['PW00127']?>",true)) return; //할인제목
		if(!C_chkInput("price",true,"<?=$LNG_TRANS_CHAR['PW00128']?>",true)) return; //할인방식

		C_getAction(mode,'<?=$PHP_SELF?>');
	}

	function goProdSearch(no)
	{
		$.smartPop.open({  bodyClose: false, width: 600, height: 500, url: './?menuType=product&mode=popProdSearch&no='+no, closeImg: {width:23, height:23, src:'/shopAdmin/himg/common/btn_pop_close.png'} });
	}

	function goProdView(no)
	{
		$.smartPop.open({  bodyClose: false, width: 600, height: 500, url: './?menuType=product&mode=popProdEventList&no='+no, closeImg: {width:23, height:23, src:'/shopAdmin/himg/common/btn_pop_close.png'} });
	}
//-->
</script>

