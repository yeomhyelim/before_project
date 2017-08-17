<script type="text/javascript">
<!--
	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";
	var intProdIconChkCount = 0;

	$(document).ready(function(){
		C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");
		
		for(var i=1;i<=10;i++){
			$("input[id^=chkIcon"+i+"]").click(function(){ 
				if ($(this).is(":checked"))
				{
					intProdIconChkCount++;
				}
			});
		}
	});


	function goOpenWindow(pcode) 
	{
		var strParam = "../?menuType=product&mode=view&act=list&prodCode=" + pcode;
		C_openWindow( strParam, "<?=$LNG_TRANS_CHAR['PW00001']?>", 1024, 768);
	}

	/* 선택없이 클릭으로 입력한 추천 상태 변경 */
	function goAutoRecUpdate()
	{
		var x = confirm("추천 상태를 변경하시겠습니까?");
		if (x == true)
		{
			C_getCheckAll(true);
			C_getAction("autoRecUpdate","<?=$PHP_SELF?>");
		}
	}
	
	/*v2.0 */
	function goProdRecUpdateAct(recItem,recStatus){
		var data		= new Object();
		var intCnt		= 0;

		$(":checkbox[id=chkNo]:checked").each(function(){	
			data['chkNo['+intCnt+']'] = $(this).val();
			intCnt++;
		});


		data['menuType']	= "product";
		data['mode']		= "act";
		data['act']			= "choiceRecUpdate2"
		data['recItemList'] = recItem;
		data['recStatus']	= recStatus;
	
		C_getSelfAction(data);
	}


	function goRecChoick()
	{
		if (intProdIconChkCount == 0)
		{
			alert("변경하실 추천 상태를 선택해주세요.");
			return;
		}

		var doc			= document.form;		
		var strChkVal	= C_getCheckedCode(doc["chkNo[]"]);

		if (C_isNull(strChkVal))
		{
			alert("<?=$LNG_TRANS_CHAR['CS00017']?>"); //데이터를 선택해주세요.
			return;
		}
		C_getAction("choiceRecUpdate","<?=$PHP_SELF?>");
	}

	function goRecAll()
	{
		if (intProdIconChkCount == 0)
		{
			alert("변경하실 추천 상태를 선택해주세요.");
			return;
		}

		var x = confirm("검색된 전체 상품을 변경하시겠습니까?");
		if (x == true)
		{
			C_getAction("allRecUpdate","<?=$PHP_SELF?>");
		}
	}

	function goRecClear() {
		var doc			= document.form;		
		var strChkVal	= C_getCheckedCode(doc["chkNo[]"]);

		if (C_isNull(strChkVal))
		{
			alert("<?=$LNG_TRANS_CHAR['CS00017']?>"); //데이터를 선택해주세요.
			return;
		}
		C_getAction("choiceRecUpdate","<?=$PHP_SELF?>");
	}


	/* 선택수정 항목설정(v2.0)*/
	function goRecUpdate()
	{
		var strChkVal	= C_getCheckedCode(document.form["chkNo[]"]);
		if (C_isNull(strChkVal))
		{
			alert("<?=$LNG_TRANS_CHAR['CS00017']?>"); //데이터를 선택해주세요.
			return;
		}
				
		$.smartPop.open({  bodyClose: false, width: 550, height: 150, url: './?menuType=product&mode=popProdRecUpdate', closeImg: {width:23, height:23, src:'/shopAdmin/himg/common/btn_pop_close.png'} });
	}


	function goPopClose()
	{		
		$.smartPop.close();
	}
	
//-->
</script>