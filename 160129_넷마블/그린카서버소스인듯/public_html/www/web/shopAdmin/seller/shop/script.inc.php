<script type="text/javascript">
<!--
	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";

	$(document).ready(function(){
		C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");

		<?if ($strMode == "shopSetting"){?>
		$("#com_delivery").live("click",function(){
			var strShopDeliveryType = $(this).val();
			$("#trStoreDelivery").css("display","none");
			if (strShopDeliveryType == "S")
			{
				$("#trStoreDelivery").css("display","block");
			}
		});
	
		<?}?>

		<?if ($strMode == "shopProdList"){?>
			$('input[name=searchLaunchStartDt]').simpleDatepicker();
			$('input[name=searchLaunchEndDt]').simpleDatepicker();
			$('input[name=searchRepStartDt]').simpleDatepicker();
			$('input[name=searchRepEndDt]').simpleDatepicker();

			callCateList(1,"","","searchCateHCode1","<?=$strSearchHCode1?>");
		
			<?if ($strSearchHCode1){?>
			callCateList(2,"<?=$strSearchHCode1?>","","searchCateHCode2","<?=$strSearchHCode2?>");
			<?}?>
			<?if ($strSearchHCode2){?>
			callCateList(3,"<?=$strSearchHCode1.$strSearchHCode2?>","","searchCateHCode3","<?=$strSearchHCode3?>");
			<?}?>
			<?if ($strSearchHCode3){?>
			callCateList(4,"<?=$strSearchHCode1.$strSearchHCode2.$strSearchHCode3?>","","searchCateHCode4","<?=$strSearchHCode4?>");
			<?}?>

			$("#searchCateHCode1").change(function() {			
				if ($(this).val())
				{
					callCateList(2,$(this).val(),"","searchCateHCode2","");
				}
			});

			$("#searchCateHCode2").change(function() {			
				if ($(this).val())
				{
					strHCode = $("#searchCateHCode1 option:selected").val()+$(this).val();
					callCateList(3,strHCode,"","searchCateHCode3","");
				}
			});

			$("#searchCateHCode3").change(function() {			
				if ($(this).val())
				{
					strHCode = $("#searchCateHCode1 option:selected").val()+$("#searchCateHCode2 option:selected").val()+$(this).val();
					callCateList(4,strHCode,"","searchCateHCode4","");
				}
			});
		<?}?>
	});

	function goIdChk() {
		var doc		= document.form;
		var strId	= doc.id.value;

		if(!C_chkInput("id",true,"ID",true)) return;

		if ($("#id").val().length < 4 || $("#id").val().length > 12)
		{
			alert("<?=$LNG_TRANS_CHAR['MS00016']?>"); //"아이디는 영문, 숫자 중 4자 이상 12자리 이하 사용  가능합니다."
			doc.id.focus();
			return;
		}
				
		$.getJSON("./?menuType=member&mode=json&act=idChk&id="+strId,function(data){	

			alert(data[0].MSG);

			if (data[0].RET == "N") {
				doc.id.value = "";
				doc.id.focus();
				return;
			
			} else {
				strIdChkFlag = "Y";
			}
		});
	}

	function goSearch(mode)
	{
		C_getMoveUrl(mode,"get","<?=$PHP_SELF?>"); 
	}

	function goMoveUrl(mode,no)
	{
		if (!C_isNull(no))
		{
			
			if (mode == "shopUserModify")
			{
				document.form.shopUserNo.value = no;	
			} else {
				document.form.shopNo.value = no;
			}
			
		}
		C_getMoveUrl(mode,"get","<?=$PHP_SELF?>"); 
	}
	
	function goDelete(no)
	{
		document.form.shopNo.value = no;
		
		var x = confirm("<?=$LNG_TRANS_CHAR['CS00007']?>");
		if (x == true)
		{
			C_getAction("shopDelete","<?=$PHP_SELF?>");	
		}
	}
	
	function goAct(mode)
	{
		if (mode == "shopWrite" || mode == "shopModify")
		{
			if(!C_chkInput("com_name",true,"<?=$LNG_TRANS_CHAR['SW00004']?>",true)) return; //회사명
			if(!C_chkInput("com_mail",true,"<?=$LNG_TRANS_CHAR['SW00009']?>",true)) return; //대표메일

			if($("#com_certificates1_file").val()){
				if(!C_chkInput("com_certificates1",true,"1번파일의 인증서명을 입력해주세요",true)) return;
			}
			if($("#com_certificates2_file").val()){
				if(!C_chkInput("com_certificates2",true,"2번파일의 인증서명을 입력해주세요",true)) return;
			}
			if($("#com_certificates3_file").val()){
				if(!C_chkInput("com_certificates3",true,"3번파일의 인증서명을 입력해주세요",true)) return;
			}
			if($("#com_certificates4_file").val()){
				if(!C_chkInput("com_certificates4",true,"4번파일의 인증서명을 입력해주세요",true)) return;
			}
			if($("#com_certificates5_file").val()){
				if(!C_chkInput("com_certificates5",true,"5번파일의 인증서명을 입력해주세요",true)) return;
			}

		}
		
		document.form.encoding = "multipart/form-data";
		C_getAction(mode,"<?=$PHP_SELF?>");				
	}

	/* SHOP 이미지 삭제 */
	function goFileDel(mode,no,type)
	{
		var x = confirm("<?=$LNG_TRANS_CHAR['CS00020']?>");
		if (x == true)
		{
			document.form.shopNo.value = no;
			document.form.shopFileNo.value = type;
			C_getAction(mode,"<?=$PHP_SELF?>");	
		}
	}

	/* 우편번호 찾기 */
	function goZip(num)
	{
		
		window.open('?menuType=popup&mode=address2&num=' + num,'new','width=600px,height=670px,top=300px,left=400px,toolbar=no,directories=no,scrollbars=no,resizable=no,status=no,menubar=no,location=no');
		
		//var href = "?menuType=popup&mode=address&num="+num;
		//window.open(href,'new','width=520px,height=450px,top=300px,left=400px,menubar=no,location=no,scrollbars=yes,status=no,resizable=no');
	}

	function goShopUserList(no)
	{
		$.smartPop.open({  bodyClose: false, width: 600, height: 300, url: './?menuType=seller&mode=popShopUserList&no='+no, closeImg: {width:23, height:23, src:'/shopAdmin/himg/common/btn_pop_close.png'} });
	}

	/* 관리자 찾기 */
	function goAdminFind()
	{
		C_openWindow("./?menuType=popup&mode=adminFind", "SearchMember", "500", "500");
	}

	function setMenuUse(chkObj,mn_level)
	{
		var intMN_NO	= chkObj.value;
		var chk_val		= chkObj.checked;		
		var menuObj		= document.form["mn_no[]"];
		var strJsonUrl = "./?menuType=basic&mode=json&act=authChk&mn_no="+intMN_NO+"&mn_level="+mn_level+"&m_no="+document.form.m_no.value;

//		document.write(strJsonUrl);
		$.getJSON(strJsonUrl,function(data){
			if (data[0].CNT > 0)
			{
				for(var n=0;n<data.length;n++){
					if (menuObj.length>0){
				
						for (k=0; k<menuObj.length; k++){
							
							if (menuObj[k].value == data[n].MN_NO)
							{
								menuObj[k].checked = chk_val;

								if (chk_val == true) menuObj[k].checked = true;
								else menuObj[k].checked = false;
								break;
							}
						}
					}
				}
			}
		});
	}

	function goShopUserDelete(no)
	{
		document.form.shopUserNo.value = no;
		
		var x = confirm("<?=$LNG_TRANS_CHAR['CS00007']?>");
		if (x == true)
		{
			C_getAction("shopUserDelete","<?=$PHP_SELF?>");	
		}
	}
	
	/* 회원 가입 */
	var strIdChkFlag		= "N";
	var strNickNameChkFlag	= "N";
	function goJoin()
	{
		var doc			= document.form;
		
		<?if ($S_MEM_CERITY == "1"){?>
			<?if ($S_JOIN_ID["USE"] == "Y" && $S_JOIN_ID["JOIN"] == "Y" && $S_JOIN_ID["NES"] == "Y"){?>
				<?if (!$S_JOIN_ID["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ID["GRADE"])){?>
			if(!C_chkInput("id",true,"<?=$LNG_TRANS_CHAR['MW00095']?>",true)) return; //아이디

			if ($("#id").val().length < 4 || $("#id").val().length > 12)
			{
				alert("<?=$LNG_TRANS_CHAR['MS00019']?>"); //아이디는 영문, 숫자 중 4자 이상 12자리 이하 사용  가능합니다.
				doc.id.focus();
				return;
			}

			if (strIdChkFlag == "N")
			{
				alert("<?=$LNG_TRANS_CHAR['MS00017']?>"); //아이디 중복체크를 해주세요.
				return;
			}
				<?}?>
			<?}?>

			<?if ($S_JOIN_NAME["USE"] == "Y" && $S_JOIN_NAME["JOIN"] == "Y" && $S_JOIN_NAME["NES"] == "Y"){?>
				<?if (!$S_JOIN_NAME["GRADE"] || in_array($strMemberJoinType,$S_JOIN_NAME["GRADE"])){?>

			if(!C_chkInput("name",true,"<?=$LNG_TRANS_CHAR['MW00097']?>",true)) return; //이름
				<?}?>
			<?}?>
		<?}else{?>
			<?if ($S_JOIN_NAME["USE"] == "Y" && $S_JOIN_NAME["JOIN"] == "Y" && $S_JOIN_NAME["NES"] == "Y"){?>
				<?if (!$S_JOIN_NAME["GRADE"] || in_array($strMemberJoinType,$S_JOIN_NAME["GRADE"])){?>
			if(!C_chkInput("f_name",true,"<?=$LNG_TRANS_CHAR['MW00096']?>",true)) return; //성
			if(!C_chkInput("l_name",true,"<?=$LNG_TRANS_CHAR['MW00097']?>",true)) return; //이름
				<?}?>
			<?}?>
		<?}?>

		<?if ($S_JOIN_PASS["USE"] == "Y" && $S_JOIN_PASS["JOIN"] == "Y" && $S_JOIN_PASS["NES"] == "Y"){?>
			<?if (!$S_JOIN_PASS["GRADE"] || in_array($strMemberJoinType,$S_JOIN_PASS["GRADE"])){?>

		if(!C_chkInput("pwd1",true,"<?=$LNG_TRANS_CHAR['MW00011']?>",true)) return; //비밀번호
		//if(!C_chkInput("pwd2",true,"<?=$LNG_TRANS_CHAR['MW00011']?>",true)) return; //비밀번호

		/*if ($("#pwd1").val() != $("#pwd2").val()) 
		{
			alert("<?=$LNG_TRANS_CHAR['MS00018']?>"); //입력하신 비밀번호가 일치하지 않습니다.
			doc.pwd2.value = "";
			doc.pwd2.focus();
			return;
		}*/

		if ($("#pwd1").val().length < 4 || $("#pwd1").val().length > 16)
		{
			alert("<?=$LNG_TRANS_CHAR['MS00019']?>"); //비밀번호는 영문, 숫자, 특수문자 중 4자 이상 16자리 이하 사용 가능합니다.
			doc.pwd1.value = "";
			doc.pwd2.value = "";
			doc.pwd1.focus();
			return;
		}
			<?}?>
		<?}?>
			

		<?if ($S_JOIN_NICKNAME["USE"] == "Y" && $S_JOIN_NICKNAME["JOIN"] == "Y" && $S_JOIN_NICKNAME["NES"] == "Y"){?>
			<?if (!$S_JOIN_NICKNAME["GRADE"] || in_array($strMemberJoinType,$S_JOIN_NICKNAME["GRADE"])){?>
		if(!C_chkInput("nickname",true,"<?=$LNG_TRANS_CHAR['MW00071']?>",true)) return; //

		if ($("#nickname").val().length < 4 || $("#nickname").val().length > 16)
		{
			alert("<?=$LNG_TRANS_CHAR['MS00072'] // 닉네임은 한글, 영문, 숫자 중 4자 이상 16자리 이하 사용 가능합니다.?>");
			doc.nickname.value = "";
			doc.nickname.focus();
			return;
		}

		if (C_containsChars($("#nickname").val())) {
			alert("<?=$LNG_TRANS_CHAR['MS00073'] // 닉네임 필드에는 특수 문자를 사용할 수 없습니다.?>");
			doc.nickname.value = "";
			doc.nickname.focus();
			return;;
		}

//		if (strNickNameChkFlag == "N")
//		{
//			alert("<?=$LNG_TRANS_CHAR['MS00074'] // 닉네임 중복체크를 해주세요.?>");
//			return;
//		}
			<?}?>
		<?}?>
			
		<?if ($S_JOIN_BIRTH["USE"] == "Y" && $S_JOIN_BIRTH["JOIN"] == "Y" && $S_JOIN_BIRTH["NES"] == "Y"){?>
			<?if (!$S_JOIN_BIRTH["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BIRTH["GRADE"])){?>
		if(!C_chkInput("birth1",true,"<?=$LNG_TRANS_CHAR['MW00012']?>",true)) return; //생년월일
		if(!C_chkInput("birth2",true,"<?=$LNG_TRANS_CHAR['MW00012']?>",true)) return; //생년월일
		if(!C_chkInput("birth3",true,"<?=$LNG_TRANS_CHAR['MW00012']?>",true)) return; //생년월일
			<?}?>
		<?}?>

		<?if ($S_JOIN_SEX["USE"] == "Y" && $S_JOIN_SEX["JOIN"] == "Y" && $S_JOIN_SEX["NES"] == "Y"){?>
			<?if (!$S_JOIN_SEX["GRADE"] || in_array($strMemberJoinType,$S_JOIN_SEX["GRADE"])){?>
		var strSex = $(":radio[name='sex']:checked").val();
		if (!strSex)
		{
			alert("<?=$LNG_TRANS_CHAR['MS00075']?>"); //성별을 선택해주세요.
			return;
		}
			<?}?>
		<?}?>
		
		<?if ($S_JOIN_MAIL["USE"] == "Y" && $S_JOIN_MAIL["JOIN"] == "Y" && $S_JOIN_MAIL["NES"] == "Y"){?>
			<?if (!$S_JOIN_MAIL["GRADE"] || in_array($strMemberJoinType,$S_JOIN_MAIL["GRADE"])){?>

		if(!C_chkInput("mail",true,"<?=$LNG_TRANS_CHAR['MW00003']?>",true)) return; //이메일

		if (!C_isValidEmail(doc.mail.value)) {
			alert("<?=$LNG_TRANS_CHAR['MS00020']?>"); //올바른 이메일 주소가 아닙니다.
			doc.mail.focus();
			return;
		}
			<?}?>
		<?}?>

//핸드폰
		<?if ($S_JOIN_HP["USE"] == "Y" && $S_JOIN_HP["JOIN"] == "Y" && $S_JOIN_HP["NES"] == "Y"){?>
			<?if (!$S_JOIN_HP["GRADE"] || in_array($strMemberJoinType,$S_JOIN_HP["GRADE"])){?>
				<?if ($S_SITE_LNG != "KR"){?>
					if(!C_chkInput("hp1",true,"<?=$LNG_TRANS_CHAR['MW00016']?>",true)) return; //핸드폰
				<?}else{?>
					if(!C_chkInput("hp2",true,"<?=$LNG_TRANS_CHAR['MW00016']?>",true)) return; //핸드폰
					if(!C_chkInput("hp3",true,"<?=$LNG_TRANS_CHAR['MW00016']?>",true)) return;
				<?}?>
			<?}?>
		<?}?>

		//전화번호
		<?if ($S_JOIN_PHONE["USE"] == "Y" && $S_JOIN_PHONE["JOIN"] == "Y" && $S_JOIN_PHONE["NES"] == "Y"){?>
			<?if (!$S_JOIN_PHONE["GRADE"] || in_array($strMemberJoinType,$S_JOIN_PHONE["GRADE"])){?>
				<?if ($S_SITE_LNG != "KR"){?>
					if(!C_chkInput("phone1",true,"<?=$LNG_TRANS_CHAR['MW00010']?>",true)) return; 
				<?}else{?>
					if(!C_chkInput("phone2",true,"<?=$LNG_TRANS_CHAR['MW00010']?>",true)) return;
					if(!C_chkInput("phone3",true,"<?=$LNG_TRANS_CHAR['MW00010']?>",true)) return;
				<?}?>
			<?}?>
		<?}?>

		//Fax
		<?if ($S_JOIN_FAX["USE"] == "Y" && $S_JOIN_FAX["JOIN"] == "Y" && $S_JOIN_FAX["NES"] == "Y"){?>
			<?if (!$S_JOIN_FAX["GRADE"] || in_array($strMemberJoinType,$S_JOIN_FAX["GRADE"])){?>
				<?if ($S_SITE_LNG != "KR"){?>
					if(!C_chkInput("fax1",true,"<?=$LNG_TRANS_CHAR['MW00074']?>",true)) return; 
				<?}else{?>
					if(!C_chkInput("fax2",true,"<?=$LNG_TRANS_CHAR['MW00074']?>",true)) return;
					if(!C_chkInput("fax3",true,"<?=$LNG_TRANS_CHAR['MW00074']?>",true)) return;
				<?}?>
			<?}?>
		<?}?>

		//주소		
		<?if ($S_JOIN_ADDR["USE"] == "Y" && $S_JOIN_ADDR["JOIN"] == "Y" && $S_JOIN_ADDR["NES"] == "Y"){?>
			<?if (!$S_JOIN_ADDR["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADDR["GRADE"])){?>
				<?if ($S_SITE_LNG == "KR"){?>
				if(!C_chkInput("zip1",true,"<?=$LNG_TRANS_CHAR['MW00078']?>",true)) return;
				if(!C_chkInput("zip2",true,"<?=$LNG_TRANS_CHAR['MW00078']?>",true)) return;
				if(!C_chkInput("addr1",true,"<?=$LNG_TRANS_CHAR['MW00019']?>",true)) return;
				if(!C_chkInput("addr2",true,"<?=$LNG_TRANS_CHAR['MW00079']?>",true)) return;
				<?} else {?>
				var strCountry	= $("#country option:selected").val();
				if (C_isNull(strCountry))
				{
					alert("<?=$LNG_TRANS_CHAR['MS00021']?>"); //국가를 선택해주세요.
					return;
				}	

				if(!C_chkInput("addr1",true,"<?=$LNG_TRANS_CHAR['MW00019']?>",true)) return;
				if(!C_chkInput("addr2",true,"<?=$LNG_TRANS_CHAR['MW00079']?>",true)) return;
				if(!C_chkInput("city",true,"<?=$LNG_TRANS_CHAR['MW00076']?>",true)) return;
				if(!C_chkInput("zip1",true,"<?=$LNG_TRANS_CHAR['MW00078']?>",true)) return;
				<?}?>
			<?}?>
		<?}?>

		//사진
		<?if ($S_JOIN_PHOTO["USE"] == "Y" && $S_JOIN_PHOTO["JOIN"] == "Y" && $S_JOIN_PHOTO["NES"] == "Y"){?>
			<?if (!$S_JOIN_PHOTO["GRADE"] || in_array($strMemberJoinType,$S_JOIN_PHOTO["GRADE"])){?>
			if(!C_chkInput("photo",true,"<?=$LNG_TRANS_CHAR['MW00080'] // 사진?>",true)) return;
			<?}?>
		<?}?>

		//추천인
		<?if ($S_JOIN_REC["USE"] == "Y" && $S_JOIN_REC["JOIN"] == "Y" && $S_JOIN_REC["NES"] == "Y"){?>
			<?if (!$S_JOIN_REC["GRADE"] || in_array($strMemberJoinType,$S_JOIN_REC["GRADE"])){?>
			if(!C_chkInput("rec_id",true,"<?=$LNG_TRANS_CHAR['MW00070']?>",true)) return;
			<?}?>
		<?}?>

		//회사명
		<?if ($S_JOIN_COM["USE"] == "Y" && $S_JOIN_COM["JOIN"] == "Y" && $S_JOIN_COM["NES"] == "Y"){?>
			<?if (!$S_JOIN_COM["GRADE"] || in_array($strMemberJoinType,$S_JOIN_COM["GRADE"])){?>
			if(!C_chkInput("com_nm",true,"<?=$LNG_TRANS_CHAR['MW00081']?>",true)) return;
			<?}?>
		<?}?>
		
		//상호명
		<?if ($S_JOIN_BUSI_INFO["USE"] == "Y"){?>
		<?if ($S_JOIN_BUSI_NM["USE"] == "Y" && $S_JOIN_BUSI_NM["JOIN"] == "Y" && $S_JOIN_BUSI_NM["NES"] == "Y"){?>
			<?if (!$S_JOIN_BUSI_NM["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BUSI_NM["GRADE"])){?>
			if(!C_chkInput("busi_nm",true,"<?=$LNG_TRANS_CHAR['MW00083']?>",true)) return;
			<?}?>
		<?}?>
		
		//사업자번호
		<?if ($S_JOIN_BUSI_NUM["USE"] == "Y" && $S_JOIN_BUSI_NUM["JOIN"] == "Y" && $S_JOIN_BUSI_NUM["NES"] == "Y"){?>
			<?if (!$S_JOIN_BUSI_NUM["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BUSI_NUM["GRADE"])){?>
			if(!C_chkInput("busi_num1",true,"<?=$LNG_TRANS_CHAR['MW00084']?>",true)) return;
			if(!C_chkInput("busi_num2",true,"<?=$LNG_TRANS_CHAR['MW00084']?>",true)) return;
			if(!C_chkInput("busi_num3",true,"<?=$LNG_TRANS_CHAR['MW00084']?>",true)) return;
			<?}?>
		<?}?>


		//업종
		<?if ($S_JOIN_BUSI_UPJONG["USE"] == "Y" && $S_JOIN_BUSI_UPJONG["JOIN"] == "Y" && $S_JOIN_BUSI_UPJONG["NES"] == "Y"){?>
			<?if (!$S_JOIN_BUSI_UPJONG["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BUSI_UPJONG["GRADE"])){?>
			if(!C_chkInput("busi_upj",true,"<?=$LNG_TRANS_CHAR['MW00085']?>",true)) return;
			<?}?>
		<?}?>
		
		//업태
		<?if ($S_JOIN_BUSI_UPTAE["USE"] == "Y" && $S_JOIN_BUSI_UPTAE["JOIN"] == "Y" && $S_JOIN_BUSI_UPTAE["NES"] == "Y"){?>
			<?if (!$S_JOIN_BUSI_UPTAE["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BUSI_UPTAE["GRADE"])){?>
			if(!C_chkInput("busi_ute",true,"<?=$LNG_TRANS_CHAR['MW00086']?>",true)) return;
			<?}?>
		<?}?>

		//주소
		<?if ($S_JOIN_BUSI_ADDR["USE"] == "Y" && $S_JOIN_BUSI_ADDR["JOIN"] == "Y" && $S_JOIN_BUSI_ADDR["NES"] == "Y"){?>
			<?if (!$S_JOIN_BUSI_ADDR["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BUSI_ADDR["GRADE"])){?>
			if(!C_chkInput("busi_zip1",true,"<?=$LNG_TRANS_CHAR['MW00078']?>",true)) return;
			if(!C_chkInput("busi_zip2",true,"<?=$LNG_TRANS_CHAR['MW00078']?>",true)) return;
			if(!C_chkInput("busi_addr1",true,"<?=$LNG_TRANS_CHAR['MW00019']?>",true)) return;
			if(!C_chkInput("busi_addr2",true,"<?=$LNG_TRANS_CHAR['MW00079']?>",true)) return;
			<?}?>
		<?}?>
		<?}?>

		//결혼여부
		<?if ($S_JOIN_ADD_WED["USE"] == "Y" && $S_JOIN_ADD_WED["JOIN"] == "Y" && $S_JOIN_BUSI_ADDR["NES"] == "Y"){?>
			<?if (!$S_JOIN_ADD_WED["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADD_WED["GRADE"])){?>
			var strWed = $(":radio[name='weddingYN']:checked").val();
			if (!strWed)
			{
				alert("<?=$LNG_TRANS_CHAR['MS00022']?>"); //결혼여부를 선택해주세요.
				return;
			}
			<?}?>
		<?}?>
		
		//결혼기념일
		<?if ($S_JOIN_ADD_WED_DAY["USE"] == "Y" && $S_JOIN_ADD_WED_DAY["JOIN"] == "Y" && $S_JOIN_ADD_WED_DAY["NES"] == "Y"){?>
			<?if (!$S_JOIN_ADD_WED_DAY["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADD_WED_DAY["GRADE"])){?>
			if(!C_chkInput("weddingDay1",true,"<?=$LNG_TRANS_CHAR['MW00088']?>",true)) return;
			if(!C_chkInput("weddingDay2",true,"<?=$LNG_TRANS_CHAR['MW00088']?>",true)) return;
			if(!C_chkInput("weddingDay3",true,"<?=$LNG_TRANS_CHAR['MW00088']?>",true)) return;
			<?}?>
		<?}?>
		
		//자녀
		<?if ($S_JOIN_ADD_CHILD["USE"] == "Y" && $S_JOIN_ADD_CHILD["JOIN"] == "Y" && $S_JOIN_ADD_CHILD["NES"] == "Y"){?>
			<?if (!$S_JOIN_ADD_CHILD["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADD_CHILD["GRADE"])){?>
			if(!C_chkInput("child",true,"<?=$LNG_TRANS_CHAR['MW00089']?>",true)) return;
			<?}?>
		<?}?>
		
		//직업
		<?if ($S_JOIN_ADD_JOB["USE"] == "Y" && $S_JOIN_ADD_JOB["JOIN"] == "Y" && $S_JOIN_ADD_JOB["NES"] == "Y"){?>
			<?if (!$S_JOIN_ADD_JOB["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADD_JOB["GRADE"])){?>
			<?}?>
		<?}?>

		//관심분야
		<?if ($S_JOIN_ADD_CONCERN["USE"] == "Y" && $S_JOIN_ADD_CONCERN["JOIN"] == "Y" && $S_JOIN_ADD_CONCERN["NES"] == "Y"){?>
			<?if (!$S_JOIN_ADD_CONCERN["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADD_CONCERN["GRADE"])){?>
				<?if ($S_JOIN_ADD_CONCERN["TYPE"] == "T"){?>
				if(!C_chkInput("concern",true,"<?=$LNG_TRANS_CHAR['MW00091']?>",true)) return;
				<?} else if ($S_JOIN_ADD_CONCERN["TYPE"] == "R"){?>
				
				var strConcern = $(":radio[name='concern']:checked").val();
				if (!strConcern)
				{
					alert("<?=$LNG_TRANS_CHAR['MS00023']?>"); //관신분야를 선택해주세요.
					return;
				}
				<?} else if ($S_JOIN_ADD_CONCERN["TYPE"] == "C"){?>
				var strConcern = $(":checkbox[name='concern']:checked").val();
				if (!strConcern)
				{
					alert("<?=$LNG_TRANS_CHAR['MS00023']?>"); //관신분야를 선택해주세요.
					return;
				}
				<?} else if ($S_JOIN_ADD_CONCERN["TYPE"] == "S"){?>
				
				var strConcern	= $("#concern option:selected").val();
				if (C_isNull(strConcern))
				{
					alert("<?=$LNG_TRANS_CHAR['MS00023']?>"); //관신분야를 선택해주세요.
					return;
				}
				<?}?>
			<?}?>
		<?}?>

		<?if ($S_JOIN_ADD_TEXT["USE"] == "Y" && $S_JOIN_ADD_TEXT["JOIN"] == "Y" && $S_JOIN_ADD_TEXT["NES"] == "Y"){?>
			<?if (!$S_JOIN_ADD_TEXT["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADD_TEXT["GRADE"])){?>
			if(!C_chkInput("memo",true,"<?=$LNG_TRANS_CHAR['MW00092']?>",true)) return;
			<?}?>
		<?}?>

		<?if ($S_JOIN_TMP_1["USE"] == "Y" && $S_JOIN_TMP_1["JOIN"] == "Y" && $S_JOIN_TMP_1["NES"] == "Y"){?>
			<?if (!$S_JOIN_TMP_1["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TMP_1["GRADE"])){?>
			if(!C_chkInput("tmp1",true,"<?=$S_JOIN_TMP_1['NAME'.$S_SITE_LNG]?>",true)) return;
			<?}?>
		<?}?>

		<?if ($S_JOIN_TMP_2["USE"] == "Y" && $S_JOIN_TMP_2["JOIN"] == "Y" && $S_JOIN_TMP_2["NES"] == "Y"){?>
			<?if (!$S_JOIN_TMP_2["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TMP_2["GRADE"])){?>
			if(!C_chkInput("tmp2",true,"<?=$S_JOIN_TMP_2['NAME'.$S_SITE_LNG]?>",true)) return;
			<?}?>
		<?}?>
				
		<?if ($S_JOIN_TMP_3["USE"] == "Y" && $S_JOIN_TMP_3["JOIN"] == "Y" && $S_JOIN_TMP_3["NES"] == "Y"){?>
			<?if (!$S_JOIN_TMP_3["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TMP_3["GRADE"])){?>
			if(!C_chkInput("tmp3",true,"<?=$S_JOIN_TMP_3['NAME'.$S_SITE_LNG]?>",true)) return;
			<?}?>
		<?}?>

		<?if ($S_JOIN_TMP_4["USE"] == "Y" && $S_JOIN_TMP_4["JOIN"] == "Y" && $S_JOIN_TMP_4["NES"] == "Y"){?>
			<?if (!$S_JOIN_TMP_4["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TMP_4["GRADE"])){?>
			if(!C_chkInput("tmp4",true,"<?=$S_JOIN_TMP_4['NAME'.$S_SITE_LNG]?>",true)) return;
			<?}?>
		<?}?>

		<?if ($S_JOIN_TMP_5["USE"] == "Y" && $S_JOIN_TMP_5["JOIN"] == "Y" && $S_JOIN_TMP_5["NES"] == "Y"){?>
			<?if (!$S_JOIN_TMP_5["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TMP_5["GRADE"])){?>
			if(!C_chkInput("tmp5",true,"<?=$S_JOIN_TMP_5['NAME'.$S_SITE_LNG]?>",true)) return;
			<?}?>
		<?}?>
		
		if($("#com_certificates1_file").val()){
			if(!C_chkInput("com_certificates1",true,"1번파일의 인증서명을 입력해주세요",true)) return;
		}
		if($("#com_certificates2_file").val()){
			if(!C_chkInput("com_certificates2",true,"2번파일의 인증서명을 입력해주세요",true)) return;
		}
		if($("#com_certificates3_file").val()){
			if(!C_chkInput("com_certificates3",true,"3번파일의 인증서명을 입력해주세요",true)) return;
		}
		if($("#com_certificates4_file").val()){
			if(!C_chkInput("com_certificates4",true,"4번파일의 인증서명을 입력해주세요",true)) return;
		}
		if($("#com_certificates5_file").val()){
			if(!C_chkInput("com_certificates5",true,"5번파일의 인증서명을 입력해주세요",true)) return;
		}

		document.form.encoding = "multipart/form-data";
		C_getAction("shopUserWrite","<?=$PHP_SELF?>");
	}
	
	function callCateList(cateLevel,cateHCode,cateView,cateObj,cateSelected)
	{
//		alert(cateSelected);
		var strJsonParam = "menuType=product&mode=json&jsonMode=cateLevelList";
		strJsonParam += "&cateLevel="+cateLevel+"&cateHCode="+cateHCode+"&cateView="+cateView+"&cateLng=<?=$strStLng?>";
		
		$.ajax({				
			type:"POST",
			url:"./index.php",
			data :strJsonParam,
			dataType:"json", 
			success:function(data){	
				var strCateSelectedText = "";
				if (cateLevel == "1")
				{
					strCateSelectedText = "<?=$LNG_TRANS_CHAR['PW00013']?>";
				} else if (cateLevel == "2")
				{
					strCateSelectedText = "<?=$LNG_TRANS_CHAR['PW00014']?>";
				} else if (cateLevel == "3")
				{
					strCateSelectedText = "<?=$LNG_TRANS_CHAR['PW00015']?>";
				} else if (cateLevel == "4")
				{
					strCateSelectedText = "<?=$LNG_TRANS_CHAR['PW00016']?>";
				}

				$("#"+cateObj).html("<option value=''>"+strCateSelectedText+"</option>");
				for(var i=0;i<data.length;i++){
					var strCateSelected = "";
					if (data[i].CATE_CODE == cateSelected)
					{
						strCateSelected = "selected";
					}
					$("#"+cateObj).append("<option value='"+data[i].CATE_CODE+"' "+strCateSelected+">"+data[i].CATE_NAME+"</option>");
				}
			}
		});
	}
//-->
</script>