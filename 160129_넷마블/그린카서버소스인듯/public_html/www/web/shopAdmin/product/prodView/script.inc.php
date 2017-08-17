<script type="text/javascript">
<!--
	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";

	$(document).ready(function(){
		C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");
	});


	function goOpenWindow(pcode) 
	{
		var strParam = "../<?=strtolower($S_ST_LNG)?>/?menuType=product&mode=view&act=list&prodCode=" + pcode;
		C_openWindow( strParam, "<?=$LNG_TRANS_CHAR['PW00001']?>", 1024, 768);
	}

	/* 선택없이 클릭으로 입력한 출력정보 변경 v2.0 */
	function goAutoViewUpdate()
	{
		var x = confirm("<?=$LNG_TRANS_CHAR['PS00048']?>"); //변경된 상품출력정보를 변경하시겠습니까?
		if (x == true)
		{
			var doc = document.form;
			C_getCheckAll(true);
			C_getAction("autoViewUpdate","<?=$PHP_SELF?>");
		}
	}
	
	/* 출력정보변경 v1.0 */
	function goViewStatusChoick()
	{
		var strViewStatus = $("#viewStatus option:selected").val();
		
		if (C_isNull(strViewStatus))
		{
			alert("변경하실 출력상태를 선택해주세요.");
			return;
		}

		var doc			= document.form;		
		var strChkVal	= C_getCheckedCode(doc["chkNo[]"]);

		if (C_isNull(strChkVal))
		{
			alert("<?=$LNG_TRANS_CHAR['CS00017']?>"); //데이터를 선택해주세요.
			return;
		}


		C_getAction("choiceViewStatusUpdate","<?=$PHP_SELF?>");
	}

	function goViewStatusAll()
	{
		
		var strViewStatus = $("#viewStatus option:selected").val();
		
		if (C_isNull(strViewStatus))
		{
			alert("변경하실 출력상태를 선택해주세요.");
			return;
		}

		var x = confirm("검색된 전체 상품 출력 상태를 변경하시겠습니까?");
		if (x == true)
		{
			C_getAction("allViewStatusUpdate","<?=$PHP_SELF?>");
		}
	}
	
	function goProdOrderUpdate()
	{
		var data		= new Object();
		var x			= confirm("상품우선순위를 변경하시겠습니까?");
		if(!x) { return; }
		
		var intCnt		= 0;
		$("tr[id^=trProdInfo]").each(function(){
			
			var strProdCode				= $(this).find("input[id=chkNo]").val();
			data["chkNo["+intCnt+"]"]	= strProdCode;
			data['order_'+strProdCode]	= $(this).find("input[id=prodOrder]").val();
			intCnt++;
		});

		data['menuType']		= "product";
		data['mode']			= "json";
		data['jsonMode']		= "prodOrderUpdate"; 
		C_getSelfAction(data);
		return;
		$.ajax({
			url			: "./"
		   ,data		: data
		   ,type		: "POST"
		   ,dataType	: "json"
		   ,success		: function(data) {	
								if(data['__STATE__'] == "SUCCESS") {
									alert("수정되었습니다.");
									location.reload();
								} else {
									alert(data);
								}
						   }
		});
	}

	function goOrderEvent(order) {
		
		var data			= new Array();
		
		data['order']		= order;

		C_getAddLocationUrl(data);
	}
//-->
</script>