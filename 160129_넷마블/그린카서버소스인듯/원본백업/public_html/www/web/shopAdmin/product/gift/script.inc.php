<script type="text/javascript">
<!--
	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";

	$(document).ready(function(){
		C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");
			
		$('input[name=eventStartDt]').simpleDatepicker();
		$('input[name=eventEndDt]').simpleDatepicker();
	
		$("#each_use").live("click",function(){
			
			$("input[id^=first_gift]").attr("disabled", false);
			$("input[id^=qty_use]").attr("disabled", false);
			$("input[id^=startPrice]").attr("disabled", false);

			$("input[id^=startPrice]").attr("disabled", false);
			$("input[id^=endPrice]").attr("disabled", false);
			$("input[id^=price_type]").attr("disabled", false);

			$("input[id^=stock_use]").eq(1).attr("disabled", false);
			$("input[id^=qty]").attr("disabled", false);

			$("input[id^=limit_use]").eq(1).attr("disabled", false);
			$("input[id^=limit_qty]").attr("disabled", false);

			$("input[id^=opt_nm1_]").attr("disabled", false);
			$("input[id^=opt_attr1_]").attr("disabled", false);

			$("input[id^=opt_nm2_]").attr("disabled", false);
			$("input[id^=opt_attr2_]").attr("disabled", false);

			if ($(this).val() == "Y")
			{
				$("input[id^=first_gift]").attr("disabled", true);
				$("input[id^=qty_use]").attr("disabled", true);
				$("input[id^=startPrice]").attr("disabled", true);

				$("input[id^=startPrice]").attr("disabled", true);
				$("input[id^=endPrice]").attr("disabled", true);
				$("input[id^=price_type]").attr("disabled", true);

				$("input[id^=stock_use]").eq(1).attr("disabled", true);
				$("input[id^=qty]").attr("disabled", true);

				$("input[id^=limit_use]").eq(1).attr("disabled", true);
				$("input[id^=limit_qty]").attr("disabled", true);

				$("input[id^=opt_nm1_]").attr("disabled", true);
				$("input[id^=opt_attr1_]").attr("disabled", true);

				$("input[id^=opt_nm2_]").attr("disabled", true);
				$("input[id^=opt_attr2_]").attr("disabled", true);
			}			
		});		
	});
	
	function goPopClose()
	{		
		$.smartPop.close();
	}

	function goModify(no,lng)
	{
		$.smartPop.open({  bodyClose: false, width: 600, height: 300, url: './?menuType=product&mode=popGiftModify&no='+no+"&giftLng="+lng, closeImg: {width:23, height:23, src:'/shopAdmin/himg/common/btn_pop_close.png'} });
	}
	
	function goDelete(no)
	{
		var x = confirm("<?=$LNG_TRANS_CHAR['PS00035']?> <?=$LNG_TRANS_CHAR['CS00007']?>"); //데이터를 삭제하시겠습니까?
		if (x == true)
		{
			document.form.no.value = no;
			C_getAction("giftDelete",'<?=$PHP_SELF?>');
		}
	}
	function goAct(mode)
	{
		if (mode == "giftWrite")
		{
			if(!C_chkInput("name",true,"<?=$LNG_TRANS_CHAR['PW00145']?>",true)) return; //사은품명
			document.form.encoding = "multipart/form-data";
		}
		
		C_getAction(mode,'<?=$PHP_SELF?>');
	}

	function goProdSearch(no)
	{
		$.smartPop.open({  bodyClose: false, width: 600, height: 500, url: './?menuType=product&mode=popGiftProdSearch&no='+no, closeImg: {width:23, height:23, src:'/shopAdmin/himg/common/btn_pop_close.png'} });
	}

	function goProdView(no)
	{
		$.smartPop.open({  bodyClose: false, width: 600, height: 500, url: './?menuType=product&mode=popProdGiftList&no='+no, closeImg: {width:23, height:23, src:'/shopAdmin/himg/common/btn_pop_close.png'} });
	}
//-->
</script>

