<script type="text/javascript">
<!--
	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";

	$(document).ready(function(){
		C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");
	});

	/* 브랜드 담당자 검색 */
	function goSearchBrandManager()
	{
		var left		= (screen.availWidth-500) / 2;
		var top			= (screen.availHeight-400) / 2;;
		var siteUrl		= "./?menuType=product&mode=popBrandManagerSearch";
		var siteName	= "브랜드 담당자 검색";
		var siteOption	= "width=500 height=400 left = "+left+" top="+top;
		window.open(siteUrl, siteName, siteOption);
	}

	function returnSearchBrandManager(no, name, phone, id)
	{
		$("input[name=pr_m_id]").val(id);
		$("input[name=pr_m_no]").val(no);
	}

	/* 상품 브랜드 관리*/
	function goMoveUrl(mode,no)
	{
		if (!C_isNull(no))
		{
			document.form.brandNo.value = no;
		}
		C_getMoveUrl(mode,"get","<?=$PHP_SELF?>"); 
	}
	
	function goDelete(no)
	{
		document.form.brandNo.value = no;
		
		var x = confirm("<?=$LNG_TRANS_CHAR['CS00007']?>");
		if (x == true)
		{
			C_getAction("prodBrandDelete","<?=$PHP_SELF?>");	
		}
	}
	
	function goAct(mode)
	{
		if(!C_chkInput("pr_name",true,"<?=$LNG_TRANS_CHAR['PW00025']?>",true)) return; //브랜드명
		
		document.form.encoding = "multipart/form-data";
		C_getAction(mode,"<?=$PHP_SELF?>");				
	}

	/* 브랜드관리 이미지 삭제 */
	function goDeleteImg(delImgType)
	{
		var url	= "./?menuType=product&mode=json&jsonMode=prodBrandImgDelete&brandNo=<?=$intPR_NO?>&pr_img_type=" + delImgType;
		C_AjaxPost("BRAND_IMG_DELETE", url,"","post");	
	}

	function goAjaxRet(name,result){
		if (name == "BRAND_IMG_DELETE") {
			var data = eval(result);
			alert(data[0].MSG);
			if(data[0].RET == "Y"){
				$("btn[id="+data[0].PR_IMG_TYPE+"]").css({'display':'none'});
			}
		}
	}
//-->
</script>