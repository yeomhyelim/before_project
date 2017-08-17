<script type="text/javascript">
<!--
	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";

	$(document).ready(function(){
		C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");		
	});


	function goPopClose()
	{		
		$.smartPop.close();
	}


	/* 상품정보 수정 호출*/
	function goProdModify(no,lang)
	{
		var data						= new Array(5);
		
		data['prodCode']				= no;
		data['prodLang']				= lang
		data['mode']					= "prodAuctionModify";
	
		C_getAddLocationUrl(data);
	}

	/* 상품정보 삭제*/
	function goProdDelete(no)
	{
		var doc = document.form;
		doc.prodCode.value = no;

		var x = confirm("<?=$LNG_TRANS_CHAR['CS00007']?>"); //선택한 상품을 삭제하시겠습니까?
		if (x == true)
		{
			C_getAction("prodDelete",'<?=$PHP_SELF?>');
		}
	}
	/* 상품복사 */
	function goProdCopy(no)
	{
		$.smartPop.open({  bodyClose: false, width: 700, height: 500, url: './?menuType=product&mode=popProdCopy&prodCode='+no, closeImg: {width:23, height:23} });
	}


	
	function goProdAuctionApplyList(prodCode){
		$.smartPop.open({  bodyClose: false, width: 700, height: 500, url: './?menuType=product&mode=popProdAuctionApplyList&prodCode='+prodCode, closeImg: {width:23, height:23} });

	}

//-->
</script>

