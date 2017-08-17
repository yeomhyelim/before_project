<script type="text/javascript">
<!--
	$(document).ready(function(){

	});
	
	function goZip(num)
	{
		window.open('./?menuType=etc&mode=address2&num=' + num,'new','width=600px,height=670px,top=300px,left=400px,toolbar=no,directories=no,scrollbars=no,resizable=no,status=no,menubar=no,location=no');
	}
	
	function goShopApplyRegAct()
	{
		document.form.encoding = "multipart/form-data";
		C_getAction('shopApplyReg',"<?=$PHP_SELF?>");				
	}

	function comContryCheck(){
		var strComCountry = $("#com_country option:selected").val();
		if(strComCountry == "KR"){
			$(".krView").show();
		}else{
			$(".krView").hide();
		}
	}


	/*파일추가*/
	var count = 2;
	function Addinput(){
		if(count < 6){
			var addStr ="";
			addStr += "<div>";
			addStr += "<input type=\"text\"";
			addStr += " id=\"com_certificates" + count + "\"";
			addStr += " name=\"com_certificates" + count + "\"";
			addStr += " value=\"\">";
			addStr += " <input type=\"file\"";
			//addStr += strInputBoxStyle;
			addStr += " id=\"com_certificates" + count + "_file\"";
			addStr += " name=\"com_certificates"+ count +"_file\"/>";
			addStr += "</div>";
			$("#dynamic_table").append(addStr);
			count++;
		}
	}

	function goShopApplyDetailView(){
		$("#detailInput1").show();
		$("#detailInput2").show();
		//goLayoutPopCloseEvent();
	}
	function goShopApplyDetailNo(){
		//$("#btnCheck").attr("href","javascript:goShopApplyRegAct()");
			//goLayoutPopCloseEvent();
			goShopApplyRegAct();

	}

	//
	function goShopApplyRegCheck() {
		
		var strComCountry = $("#com_country option:selected").val();

		if(strComCountry == "KR"){
			strSiteJsLng = 'KR';
		}else if(strComCountry == "US"){
			strSiteJsLng = 'US';
		}else if(strComCountry == "CN"){
			strSiteJsLng = 'CN';
		}else{
			strSiteJsLng = '';
		}

		if(strSiteJsLng == 'KR' || strComCountry == 'KR') {

			if(!C_chkInput("com_name",true,"<?=$LNG_TRANS_CHAR['SW00004']?>",true)) return; //회사명
			if(!C_chkInput("com_rep_nm",true,"<?=$LNG_TRANS_CHAR['SW00006']?>",true)) return; //대표자
			if(!C_chkInput("com_phone1",true,"<?=$LNG_TRANS_CHAR['SW00007']?>",true)) return; //대표전화
			if(!C_chkInput("com_phone2",true,"<?=$LNG_TRANS_CHAR['SW00007']?>",true)) return; //대표전화
			if(!C_chkInput("com_phone3",true,"<?=$LNG_TRANS_CHAR['SW00007']?>",true)) return; //대표전화
			if(!C_chkInput("com_fax1",true,"<?=$LNG_TRANS_CHAR['SW00008']?>",true)) return; //대표팩스
			if(!C_chkInput("com_fax2",true,"<?=$LNG_TRANS_CHAR['SW00008']?>",true)) return; //대표팩스
			if(!C_chkInput("com_fax3",true,"<?=$LNG_TRANS_CHAR['SW00008']?>",true)) return; //대표팩스
			if(!C_chkInput("com_mail",true,"<?=$LNG_TRANS_CHAR['SW00009']?>",true)) return; //대표메일		
			if(!C_chkInput("com_num1_1",true,"<?=$LNG_TRANS_CHAR['SW00012']?>",true)) return; //사업자번호
			if(!C_chkInput("com_num1_2",true,"<?=$LNG_TRANS_CHAR['SW00012']?>",true)) return; //사업자번호
			if(!C_chkInput("com_num1_3",true,"<?=$LNG_TRANS_CHAR['SW00012']?>",true)) return; //사업자번호
			if(!C_chkInput("com_zip1",true,"<?=$LNG_TRANS_CHAR['SW00014']?>",true)) return; //우편번호
			if(!C_chkInput("com_zip2",true,"<?=$LNG_TRANS_CHAR['SW00014']?>",true)) return; //우편번호
			if(!C_chkInput("com_addr",true,"<?=$LNG_TRANS_CHAR['SW00015']?>",true)) return; //주소
			//if(!C_chkInput("com_file2",true,"통장사본",true)) return; //통장사본
			//if(!C_chkInput("com_file3",true,"사업자등록사본",true)) return; //사업자등록사본

		} else if(strComCountry == 'US') {

			if(!C_chkInput("com_name",true,"<?=$LNG_TRANS_CHAR['SW00004']?>",true)) return; //회사명
			if(!C_chkInput("com_rep_nm",true,"<?=$LNG_TRANS_CHAR['SW00006']?>",true)) return; //대표자
			if(!C_chkInput("com_phone",true,"<?=$LNG_TRANS_CHAR['SW00007']?>",true)) return; //대표전화
			if(!C_chkInput("com_mail",true,"<?=$LNG_TRANS_CHAR['SW00009']?>",true)) return; //대표메일		
			//if(!C_chkInput("com_num1_1",true,"<?=$LNG_TRANS_CHAR['SW00012']?>",true)) return; //사업자번호
			//if(!C_chkInput("com_zip1",true,"<?=$LNG_TRANS_CHAR['SW00014']?>",true)) return; //우편번호

			if(!C_chkInput("com_state_2",true,"<?=$LNG_TRANS_CHAR['OW00042'] //State?>",true)) return; //주
			if(!C_chkInput("com_city",true,"<?=$LNG_TRANS_CHAR['OW00041'] //City?>",true)) return; //도시
			if(!C_chkInput("com_addr",true,"<?=$LNG_TRANS_CHAR['SW00015']?>",true)) return; //주소
		}else{
			if(!C_chkInput("com_name",true,"<?=$LNG_TRANS_CHAR['SW00004']?>",true)) return; //회사명
			if(!C_chkInput("com_rep_nm",true,"<?=$LNG_TRANS_CHAR['SW00006']?>",true)) return; //대표자
			if(!C_chkInput("com_phone",true,"<?=$LNG_TRANS_CHAR['SW00007']?>",true)) return; //대표전화
			if(!C_chkInput("com_fax",true,"<?=$LNG_TRANS_CHAR['SW00008']?>",true)) return; //대표팩스
			if(!C_chkInput("com_mail",true,"<?=$LNG_TRANS_CHAR['SW00009']?>",true)) return; //대표메일		
			//if(!C_chkInput("com_num1_1",true,"<?=$LNG_TRANS_CHAR['SW00012']?>",true)) return; //사업자번호
			//if(!C_chkInput("com_zip1",true,"<?=$LNG_TRANS_CHAR['SW00014']?>",true)) return; //우편번호

			if(!C_chkInput("com_state_1",true,"<?=$LNG_TRANS_CHAR['OW00042'] //State?>",true)) return; //주
			if(!C_chkInput("com_city",true,"<?=$LNG_TRANS_CHAR['OW00041'] //City?>",true)) return; //도시
			if(!C_chkInput("com_addr",true,"<?=$LNG_TRANS_CHAR['SW00015']?>",true)) return; //주소
		}


		//var strHtml = "";
		//	strHtml += "<div style=\"width:500px;margin:0 auto;\">";
		//	strHtml += "<div class=\"popUpWrap\">";
		//	strHtml += "	<div class=\"titleWrap\">";
		//	strHtml += "		<h1>추가정보를 등록해 주세요.</h1>";
		//	strHtml += "		<a href=\"javascript:goLayoutPopCloseEvent();\" class=\"btnClose\">X</a>";
		//	strHtml += "	</div>";
		//	strHtml += "	<div class=\"popContentWrap centerContent\">";
		//	strHtml += "		<img src=\"/upload/images/ico_pop_1.gif\">";
		//	strHtml += "		<p>";
		//	strHtml += "			세부정보 및 회사소개 정보를 추가로 등록하시면<br>";
		//	strHtml += "			<strong>특별한 입점혜택</strong>을 드립니다.";
		//	strHtml += "		</p>";
		//	strHtml += "		<p class=\"chkTxt\">등록하시겠습니까?</p>";
		//	strHtml += "	</div>";
		//	strHtml += "	<div class=\"popBtnWrap\">	";
		//	strHtml += "		<a href=\"javascript:goShopApplyDetailView();\" class=\"btn_ok\">예</a>";
		//	strHtml += "		<a href=\"javascript:goShopApplyDetailNo();\" class=\"btn_no\">아니오</a>";
		//	strHtml += "	</div>";
		//	strHtml += "</div>";
		//	strHtml += "</div>";

		//$.smartPop.open({	html: strHtml,
		//					bodyClose: false,
		//					width: 512,
		//					height: 391,
		//});
		var strApplyRegEventAlert = "";
		strApplyRegEventAlert += "<?= $LNG_TRANS_CHAR['OS00093']; ?> \n";
		strApplyRegEventAlert += "<?= $LNG_TRANS_CHAR['OS00094']; ?> \n";
		//strApplyRegEventAlert += "특별한 입점혜택을 드립니다. \n";
		strApplyRegEventAlert += "<?= $LNG_TRANS_CHAR['OS00095']; ?>";
		if(confirm(strApplyRegEventAlert))
		{
			goShopApplyDetailView();
		}
		else
		{
			goShopApplyDetailNo();
		}
		
	}

	// 팝업 닫고 다시 로드
	function goLayoutPopCloseEvent() {

		$.smartPop.close();

	}


//-->
</script>