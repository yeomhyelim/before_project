<script type="text/javascript">
<!--
	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";

	$(document).ready(function(){
		C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");


	});

	/* 이벤트 정의 */
	function goKrTabPageMove() { goTabPage("<?=$strMode?>", "KR"); }
	function goUsTabPageMove() { goTabPage("<?=$strMode?>", "US"); }
	function goJpTabPageMove() { goTabPage("<?=$strMode?>", "JP"); }
	function goCnTabPageMove() { goTabPage("<?=$strMode?>", "CN"); }
	function goIdTabPageMove() { goTabPage("<?=$strMode?>", "ID"); }
	function goFrTabPageMove() { goTabPage("<?=$strMode?>", "FR"); }

	/* 함수 정의 */
	function goTabPage(mode, lng) {
		location.href = "./?menuType=product&mode="+mode+"&lang="+lng;
	}

	/* 카테고리 리스트에서 국가 선택시 */	
	function goSelectLang()
	{
		var strMode = $("#mode").val();
		
		document.form.method = "post";
		C_getMoveUrl(strMode,"get","<?=$PHP_SELF?>");
	}

	function goCateWrite(level,code)
	{
		if (C_isNull(level)){
			level = "";
		}

		if (C_isNull(code)){
			code = "";
		}

		$.smartPop.open({  bodyClose: false, width: 800, height: 500, url: './?menuType=product&mode=popCateWrite&cateType=<?=$strCateType?>&cateLevel='+level+"&cateCode="+code, closeImg: {width:23, height:23, src:'/shopAdmin/himg/common/btn_pop_close.png'} });
	}

	function goCateModify(cateCode)
	{
		$.smartPop.open({  bodyClose: false, width: 800, height: 500, url: './?menuType=product&mode=popCateModify&lang=<?=$strStLng?>&cateType=<?=$strCateType?>&cateCode='+cateCode, closeImg: {width:23, height:23, src:'/shopAdmin/himg/common/btn_pop_close.png'} });
	}

	function goCateDelete(cateCode){
		var doc = document.form;
		doc.cateCode.value = cateCode;

		var x = confirm("<?=$LNG_TRANS_CHAR['CS00007']?>"); //선택하신 데이타를 삭제하시겠습니까?
		if (x == true)
		{
			C_getAction("cateDelete",'<?=$PHP_SELF?>');
		}
	}

	/* 카테고리 목록에서 가상카테고리 상품설정 */
	function goCateShare(level,no)
	{
		$.smartPop.open({  bodyClose: false, width: 850, height: 500, url: './?menuType=product&mode=popCateShareList&cateCode='+no+"&cateLevel="+level, closeImg: {width:23, height:23, src:'/shopAdmin/himg/common/btn_pop_close.png'} });
	}

	function goPopClose()
	{		
		$.smartPop.close();
	}

	function cateMouseOverOut(obj,img)
	{
		obj.src = img;
	}

	function goExcel(mode,type)
	{
		var data				= new Object();	
		data['menuType']		= "product";
		data['mode']			= "excel";
		data['act']				= mode;
		data['cateType']		= type;
		C_getAddLocationUrl(data);
	}
//-->
</script>