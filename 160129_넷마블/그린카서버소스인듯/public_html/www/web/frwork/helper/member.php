<?
	require_once MALL_CONF_LIB."MemberMgr.php";
	require_once MALL_CONF_LIB."ProductMgr.php";
//	require_once MALL_CONF_LIB."SmsMgr.php";

	require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/conf/member.inc.php";
	require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/conf/site_skin_member.conf.inc.php";

	$memberMgr	= new MemberMgr();
	$productMgr = new ProductMgr();
//	$smsMgr		= new SmsMgr();

	$strM_ID			= $_POST["id"]				? $_POST["id"]				: $_REQUEST["id"];

	$aryCartNo			= $_POST["cartNo"]			? $_POST["cartNo"]			: $_REQUEST["cartNo"];

	$strReturnMenu		= $_POST["returnMenu"]		? $_POST["returnMenu"]		: $_REQUEST["returnMenu"];
	$strReturnMode		= $_POST["returnMode"]		? $_POST["returnMode"]		: $_REQUEST["returnMode"];
	$strReturnParam		= $_POST["returnParam"]		? $_POST["returnParam"]		: $_REQUEST["returnParam"];

	/* 레이어 팝업에서 로그인일때 */
	$strLayerClickType	= $_POST["clickType"]		? $_POST["clickType"]		: $_REQUEST["clickType"];

	## 회원가입 타입
	## 2014.07.22 kim hee sung
	## 회원가입 종류가 있는 경우 해당하는 conf 파일을 호줄합니다.
	## 대기
//	$strMemberConf = MALL_SHOP . "/conf/member.inc.php";
//	if($strJoinKind) { $strMemberConf = MALL_SHOP . "/conf/member.{$strJoinKind}.inc.php"; }
//	require_once $strMemberConf;

	switch ($strMode)
	{
		case "join1":

			$settingRow = $memberMgr->getSettingView($db);

			if ($S_SITE_LNG == "KR"){
				if ($settingRow[J_JUMIN] == "Y"){
					include MALL_HOME."/web/frwork/cerity/member.nameCheck.inc.php";
				}

				if ($settingRow[J_IPIN] == "Y"){
					include MALL_HOME."/web/frwork/cerity/member.ipinCheck.inc.php";
				}
			}
		break;
		case "joinForm":

			/* 회원가입항목 코드 */
			$strMemberJoinType = $_REQUEST["joinType"];

			$settingRow = $memberMgr->getSettingView($db);

			if ($S_SITE_LNG == "KR"){

				if ($settingRow[J_JUMIN] == "Y" || $settingRow[J_IPIN] == "Y"){

					$strRequestEncType	= $_POST["enc_type"];

					if (!$strRequestEncType){
						/* NAME CHECK */
						$strRequestName		= $_POST["sRequestName"];
						$strRequestNo		= $_POST["sRequestNO"];
						$strRequestSafeId	= $_POST["sSafeId"];

						$strBirth1			= (SUBSTR($strRequestSafeId,6,1) == "1" || SUBSTR($strRequestSafeId,6,1) == "2") ? "19":"20";
						$strBirth1		   .= SUBSTR($strRequestSafeId,0,2);	// 생년월일 (YYYYMMDD)
						$strBirth2			= SUBSTR($strRequestSafeId,2,2);	// 생년월일 (YYYYMMDD)
						$strBirth3			= SUBSTR($strRequestSafeId,4,2);	// 생년월일 (YYYYMMDD)

						$strSex				= (SUBSTR($strRequestSafeId,6,1) == "2" || SUBSTR($strRequestSafeId,6,1) == "4") ? "W":"M";	// 성별 코드 (개발 가이드 참조)
						/* NAME CHECK */

						if ($_SESSION['REQ_SEQ'] != $strRequestNo){
							goErrMsg("요청번호가 불일치 합니다. 다시 시도해주세요.");
							exit;
						}
					}

					if ($strRequestEncType == "I"){
						include MALL_HOME."/web/frwork/cerity/nice.ipinCheck.result.php";
					}

					if (!$strRequestSafeId){
						goErrMsg("회원가입 인증을 받지 않으셨습니다.");
						exit;
					}

				}
			}

			$aryHp		= getCommCodeList("HP");
			$aryPhone	= getCommCodeList("PHONE");
			$aryJob		= getCommCodeList("JOB");
			$aryConcern	= getCommCodeList("CONCERN");

			/* 국가 리스트 */
			if ($S_SITE_LNG != "KR"){
				$aryCountryList		= getCountryList();
				$aryCountryState	= getCommCodeList("STATE","");
			}

			/** 휴대폰 인증 모듈(사용 가능 여부 체크) **/

			## STEP 1.
			## 휴대폰 인증 모듈(세션 초기화)
			$_SESSION['SESS_MEMBER_JOIN_MODE']		= "";
//			$_SESSION['SESS_MEMBER_JOIN_CNT']		= "";
//			$_SESSION['SESS_MEMBER_JOIN_TIME']		= "";
			$_SESSION['SESS_MEMBER_JOIN_KEY']		= "";
			$phoneCheck								= "Y";

			## STEP 2.
			## 휴대폰 인증 모듈(사용 유무 체크)
//			require_once MALL_CONF_LIB."MemberMgr.php";
//			$memberMgr		= new MemberMgr();
			$settingRow		= $memberMgr->getSettingView($db);
			if($settingRow['J_PHONE'] != "Y") { $phoneCheck = ""; }

			## STEP 3.
			## 휴대폰 인증 모듈(한국어 사이트 체크).
			if($S_SITE_LNG != "KR") { $phoneCheck = ""; }

			## STEP 4.
			## 휴대폰 인증 모듈(문자 발송 가능 건수 체크)
			require_once "{$S_DOCUMENT_ROOT}www/classes/sms/sms.func.class.php";
			$smsFunc		= new SmsFunc();
			$smsMoney		= $smsFunc->getSmsMoneySelect($db); // 머니 체크
			if($smsMoney['VAL'] <= 0) { $phoneCheck = ""; }

			/** 휴대폰 인증 모듈(사용 가능 여부 체크) **/

			/* 회원등급목록 */
			$aryMemberGroup = $memberMgr -> getGroupList($db);

		break;

		case "joinEnd":

			/* 회원가입항목 코드 */
			$strMemberJoinType = $_REQUEST["joinType"];

			if (!$strM_ID){
				goErrMsg($LNG_TRANS_CHAR["MS00022"]); //입력하신 정보와 일치하는 회원정보가 없습니다.
				exit;
			}

			if ($S_MEM_CERITY == "1") {
				$memberMgr->setM_ID($strM_ID);
				if ($_SESSION["SESS_MEMBER_JOIN_ID"] != $strM_ID){
					goErrMsg($LNG_TRANS_CHAR["MS00022"]); //입력하신 정보와 일치하는 회원정보가 없습니다.
					exit;
				}
			}
			else {
				$memberMgr->setM_MAIL($strM_ID);
				if ($_SESSION["SESS_MEMBER_JOIN_ID"] != $strM_ID){
					goErrMsg($LNG_TRANS_CHAR["MS00022"]); //입력하신 정보와 일치하는 회원정보가 없습니다.
				}
			}

			$row = $memberMgr->getMemberInfo($db);

			$aryJob		= getCommCodeList("JOB");
			$aryConcern	= getCommCodeList("CONCERN");

			$aryJoinConcern = explode(",",$row[M_CONCERN]);
			$strConcern = "";
			if ($row[M_CONCERN] && is_array($aryJoinConcern)){

				for($i=0;$i<sizeof($aryJoinConcern);$i++){
					$strConcern .= $aryConcern[$aryJoinConcern[$i]].",";
				}
//				echo substr($strConcern,0,strlen($strConcern)-1);
			}

			$strJob = $aryJob[$row[M_JOB]];

			/* 국가 리스트 */
			if ($S_SITE_LNG != "KR"){
				$aryCountryList		= getCountryList();
				$aryCountryState	= getCommCodeList("STATE","");
			}

			/* 가족 관계 리스트 */
			if ($S_MEM_FAMILY == "Y"){
				$memberMgr->setM_NO($row[M_NO]);
				$aryMemberFamilyList = $memberMgr->getMemberFamilyList($db);
			}
		break;

		case "login":

			if ($g_member_no)
			{
				goUrl("","./");
				exit;
			}

			$strInputCartHtml = "";
			if (is_array($aryCartNo)){
				for($i=0;$i<sizeof($aryCartNo);$i++){
					$strInputCartHtml .= "<input type=\"hidden\" name=\"cartNo[]\" value=\"".$aryCartNo[$i]."\">";
				}
			}

			$strAutoLoginId = $_COOKIE["COOKIE_AUTO_LOGIN"] ? $_COOKIE["COOKIE_AUTO_LOGIN"] : "";

		break;

		case "findIdPwd":

			if ($g_member_no)
			{
				goUrl("","./");
				exit;
			}

//			$smsMgr->setCC_NAME("비밀번호 찾기(고객용)");
//			$arySmsRow	= $smsMgr->getSmsText($db);			// SMS 문자 메시지

			## 2013.04.19 SMS 정보
			$smsConfFile = "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/smsInfo.conf.inc.php";
			if(is_file($smsConfFile)):
				require_once $smsConfFile;
			endif;
		break;

		case "family":
			/* 가족 관계 리스트 */
			if ($S_MEM_FAMILY == "Y"){
				$memberMgr->setM_NO($g_member_no);
				$aryMemberFamilyList = $memberMgr->getMemberFamilyList($db);

			}

		break;
	}
?>
<script type="text/javascript">
<!--
	var strIdChkFlag		= "N";
	var strNickNameChkFlag	= "N";
	$(document).ready(function(){

		<?if ($strMode == "joinForm"){?>
		$('#id').alphanumeric();
		$("#id").css("ime-mode", "disabled");

		$('#pwd1').alphanumeric({allow:"!,*&^%$#@~;`-+:?/<>{}[]\\=."});
		$("#pwd1").css("ime-mode", "disabled");

		$('#pwd2').alphanumeric({allow:"!,*&^%$#@~;`-+:?/<>{}[]\\=."});
		$("#pwd2").css("ime-mode", "disabled");

		$('#birth1').numeric();
		$("#birth1").css("ime-mode", "disabled");

		$('#birth2').numeric();
		$("#birth2").css("ime-mode", "disabled");

		$('#birth3').numeric();
		$("#birth3").css("ime-mode", "disabled");

		$('#hp2').numeric();
		$("#hp2").css("ime-mode", "disabled");

		$('#hp3').numeric();
		$("#hp3").css("ime-mode", "disabled");

		$('#phone2').numeric();
		$("#phone2").css("ime-mode", "disabled");

		$('#phone3').numeric();
		$("#phone3").css("ime-mode", "disabled");

		$('#weddingDay1').numeric();
		$("#weddingDay1").css("ime-mode", "disabled");

		$('#weddingDay2').numeric();
		$("#weddingDay2").css("ime-mode", "disabled");

		$('#weddingDay3').numeric();
		$("#weddingDay3").css("ime-mode", "disabled");


		$("#mail").bind("blur", function() {
			if ($(this).val())
			{
				$.getJSON("./?menuType=member&mode=json&act=mailChk&mail="+$(this).val(),function(data){
					if (data[0].RET == "N")
					{
						alert(data[0].MSG);
						$("#mail").val("");
						return;
					}
				});
			}
		});

		<?if ($S_SITE_LNG != "KR"){?>
		$("#country").change(function(){
			var strVal	= $("#country option:selected").val();

			$("#divState1").css("display","block");
			$("#divState2").css("display","none");
			if (strVal == "US")
			{
				$("#divState1").css("display","none");
				$("#divState2").css("display","block");
			}
		});
		<?}?>
		<?}?>

		<?if ($strMode == "login"){?>
		$('#login_id').alphanumeric({allow:"-@."});
		$("#login_id").css("ime-mode", "disabled");

		$('#login_pwd').alphanumeric({allow:"!,*&^%$#@~;`-+:?/<>{}[]\\=."});
		$("#login_pwd").css("ime-mode", "disabled");

		<?php if($strAutoLoginId):?>
		$("#login_pwd").focus();
		<?php else:?>
		$("#login_id").focus();
		<?php endif;?>

		<?}?>



	});

	/* 약관 체크 */
	<?if ($strMode == "join1" && $settingRow[J_IPIN] == "Y"){?>
	window.name ="Parent_window";
	<?}?>
	function goAllCheck(){
		
		var strAgreement = $(":checkbox[name='agreement']:checked").val();
		
		if(strAgreement){
			$('input[name="policyYN"]:radio[value="Y"]').prop('checked',true);
			$('input[name="personYN"]:radio[value="Y"]').prop('checked',true);
		}else{
			$('input[name="policyYN"]:radio[value="N"]').prop('checked',true);
			$('input[name="personYN"]:radio[value="N"]').prop('checked',true);
		}
	}
	
	function goJoinAgree()
	{
		var strPolicyYN = $(":radio[name='policyYN']:checked").val();
		var strPersonYN = $(":radio[name='personYN']:checked").val();

		if (strPolicyYN == "N")
		{
			alert("<?=$LNG_TRANS_CHAR['MS00014']?>"); //"가입약관 동의를 선택해주세요."
			return;
		}

		if (strPersonYN == "N")
		{
			alert("<?=$LNG_TRANS_CHAR['MS00015']?>"); //"개인정보 동의를 선택해주세요."
			return;
		}

		<?if ($S_SITE_LNG == "KR" && $settingRow[J_JUMIN] == "Y" || $settingRow[J_IPIN] == "Y"){?>
		var strMemCerityMth = $(":radio[name='memCerityMth']:checked").val();

		if (strMemCerityMth == "N")
		{
			window.open('', 'popup', 'width=450, height=350, toolbar=no,directories=no,scrollbars=no,resizable=no,status=no,menubar=no,top=0,left=0');
			<?if ($strDevice == "m"){?>
			document.frm_main.action = "https://cert.namecheck.co.kr/NiceID/NiceID_mobile/mCertnc_input.asp";
			<?}else{?>
			document.frm_main.action = "https://cert.namecheck.co.kr/NiceID/certnc_input.asp";
			<?}?>
			document.frm_main.target = "popup";
			document.frm_main.submit();
		}

		if (strMemCerityMth == "I")
		{
			window.open('', 'popupIPIN2', 'width=450, height=550, top=100, left=100, fullscreen=no, menubar=no, status=no, toolbar=no, titlebar=yes, location=no, scrollbar=no');
			document.form_ipin.target = "popupIPIN2";
			document.form_ipin.action = "https://cert.vno.co.kr/ipin.cb";
			document.form_ipin.submit();
		}

		return;
		<?}?>
		location.href = "./?menuType=member&mode=joinForm&target=<?=$strPageTarget?>";
	}

	/* 아이디 체크 */
	function goIdChk()
	{
		var doc		= document.form;
		var strId	= doc.id.value;

		if(!C_chkInput("id",true,"<?=$LNG_TRANS_CHAR['MS00003']?>",true)) return;

		if ($("#id").val().length < 4 || $("#id").val().length > 12)
		{
			alert("<?=$LNG_TRANS_CHAR['MS00003']?>"); //"아이디는 영문, 숫자 중 4자 이상 12자리 이하 사용  가능합니다."
			doc.id.focus();
			return;
		}

		$.getJSON("./?menuType=member&mode=json&act=idChk&id="+strId,function(data){

			alert(data[0].MSG);
			if (data[0].RET == "N")
			{
				doc.id.value = "";
				doc.id.focus();
				return;

			} else {
				strIdChkFlag = "Y";
			}
		});
	}

	/* 닉네임 체크 */
	function goNickNameChk()
	{
		var doc			= document.form;
		var strNickName	= doc.nickname.value;


		if(!C_chkInput("nickname",true,"닉네임",true)) return;

		if ($("#nickname").val().length < 4 || $("#nickname").val().length > 16)
		{
			alert("<?=$LNG_TRANS_CHAR['MS00006']?>"); //닉네임은 한글, 영문, 숫자 중 4자 이상 16자리 이하 사용 가능합니다.
			doc.nickname.value = "";
			doc.nickname.focus();
			return;
		}

		/*if (C_containsChars(strNickName)) {
			alert("닉네임 필드에는 특수 문자를 사용할 수 없습니다.");
			doc.nickname.value = "";
			doc.nickname.focus();
			return;;
		}*/


		$.getJSON("./?menuType=member&mode=json&act=nickNameChk&nickname="+strNickName,function(data){
			alert(data[0].MSG);
			if (data[0].RET == "N")
			{
				doc.id.value = "";
				doc.id.focus();
				return;

			} else {
				strNickNameChkFlag = "Y";
			}
		});
	}

	/* 우편번호 찾기 */
	function goZip(num)
	{
		window.open('?menuType=etc&mode=address2&num=' + num,'new','width=600px,height=670px,top=300px,left=400px,toolbar=no,directories=no,scrollbars=no,resizable=no,status=no,menubar=no,location=no');

//		window.open('?menuType=etc&mode=address&num=' + num,'new','width=520px,height=450px,top=300px,left=400px,menubar=no,location=no,scrollbars=yes,status=no,resizable=no,toolbar=no');
	}

	/* 회원 아이디 찾기 */
	function goSearchId()
	{

		var doc			= document.form;
		var strLName	= doc.searchId_L_Name.value;

		var strMail1	= doc.searchId_Mail1.value;
		var strMail2	= doc.searchId_Mail2.value;

		if(!C_chkInput("searchId_L_Name",true,"<?=$LNG_TRANS_CHAR['MW00004']?>",true)) return; //이름
		if(!C_chkInput("searchId_Mail1",true,"<?=$LNG_TRANS_CHAR['MW00010']?>",true)) return; //이메일
		if(!C_chkInput("searchId_Mail2",true,"<?=$LNG_TRANS_CHAR['MW00010']?>",true)) return; //이메일
		var href = "./?menuType=member&mode=json&act=searchId&searchId_L_Name="+encodeURIComponent(strLName)+"&searchId_Mail1="+strMail1+"&searchId_Mail2="+strMail2;

		<?if($S_SITE_LNG != "KR"):?>
		var strFName	= doc.searchId_F_Name.value;
		if(!C_chkInput("searchId_F_Name",true,"<?=$LNG_TRANS_CHAR['MW00004']?>",true)) return; //성
		href = href + "&searchId_F_Name="+encodeURIComponent(strFName);
		<?endif;?>

//		location.href = href;
//		return;

		$.getJSON(href, function(data){

			alert(data[0].MSG);

			doc.searchId_L_Name.value = "";
			doc.searchId_Mail1.value = "";
			doc.searchId_Mail2.value = "";

			<?if($S_SITE_LNG != "KR"):?>
			doc.searchId_F_Name.value;
		<?endif;?>
		});
	}


	function goSearchPwdType(myThis, type)
	{

		// add class on
		$(myThis).parent().find('a').removeClass('on');
		$(myThis).addClass('on');


		var doc			= document.form;

		doc.searchPass_Type.value = type;
		$("#searchPwd").css("display","none");
		$("#searchPwdSms").css("display","none");
		$("#"+type).css("display","block");

		doc.searchPass_Id.value = "";
		doc.searchPass_Id.focus();
		doc.searchPass_Name.value = "";
		doc.searchPass_Mail1.value = "";
		doc.searchPass_Mail2.value = "";
		doc.searchPass_Hp1.value = "";
		doc.searchPass_Hp2.value = "";
		doc.searchPass_Hp3.value = "";


	}

	/* 회원 가입 */
	function goJoin()
	{
		var doc			= document.form;

		<?if ($S_MEM_CERITY == "1"){?>
			<?if ($S_JOIN_ID["USE"] == "Y" && $S_JOIN_ID["JOIN"] == "Y" && $S_JOIN_ID["NES"] == "Y"){?>
				<?if (!$S_JOIN_ID["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ID["GRADE"])){?>
			if(!C_chkInput("id",true,"ID",true)) return;

			if ($("#id").val().length < 4 || $("#id").val().length > 12)
			{
				alert("<?=$LNG_TRANS_CHAR['MS00003']?>"); //아이디는 영문, 숫자 중 4자 이상 12자리 이하 사용  가능합니다.
				doc.id.focus();
				return;
			}

			if (strIdChkFlag == "N")
			{
				alert("<?=$LNG_TRANS_CHAR['MS00013']?>"); //아이디 중복체크를 해주세요.
				return;
			}
				<?}?>
			<?}?>

			<?if ($S_JOIN_NAME["USE"] == "Y" && $S_JOIN_NAME["JOIN"] == "Y" && $S_JOIN_NAME["NES"] == "Y"){?>
				<?if (!$S_JOIN_NAME["GRADE"] || in_array($strMemberJoinType,$S_JOIN_NAME["GRADE"])){?>

			if(!C_chkInput("l_name",true,"<?=$LNG_TRANS_CHAR['MW00004']?>",true)) return; //이름
				<?}?>
			<?}?>
		<?}else{?>
			<?if ($S_JOIN_NAME["USE"] == "Y" && $S_JOIN_NAME["JOIN"] == "Y" && $S_JOIN_NAME["NES"] == "Y"){?>
				<?if (!$S_JOIN_NAME["GRADE"] || in_array($strMemberJoinType,$S_JOIN_NAME["GRADE"])){?>
					<?if($S_SITE_LNG != "KR"): // 다국어 일때만?>
			if(!C_chkInput("f_name",true,"<?=$LNG_TRANS_CHAR['MW00012']?>",true)) return; //성
					<?endif;?>
			if(!C_chkInput("l_name",true,"<?=$LNG_TRANS_CHAR['MW00004']?>",true)) return; //이름
				<?}?>
			<?}?>
		<?}?>

		<?if ($S_JOIN_PASS["USE"] == "Y" && $S_JOIN_PASS["JOIN"] == "Y" && $S_JOIN_PASS["NES"] == "Y"){?>
			<?if (!$S_JOIN_PASS["GRADE"] || in_array($strMemberJoinType,$S_JOIN_PASS["GRADE"])){?>

		if(!C_chkInput("pwd1",true,"<?=$LNG_TRANS_CHAR['MW00002']?>",true)) return; //비밀번호
		if(!C_chkInput("pwd2",true,"<?=$LNG_TRANS_CHAR['MW00002']?>",true)) return; //비밀번호

		if ($("#pwd1").val() != $("#pwd2").val())
		{
			alert("<?=$LNG_TRANS_CHAR['MS00011']?>"); //입력하신 비밀번호가 일치하지 않습니다.
			doc.pwd2.value = "";
			doc.pwd2.focus();
			return;
		}

		if ($("#pwd1").val().length < 4 || $("#pwd1").val().length > 16)
		{
			alert("<?=$LNG_TRANS_CHAR['MS00006']?>"); //비밀번호는 영문, 숫자, 특수문자 중 4자 이상 16자리 이하 사용 가능합니다.
			doc.pwd1.value = "";
			doc.pwd2.value = "";
			doc.pwd1.focus();
			return;
		}
			<?}?>
		<?}?>

		<?if ($S_JOIN_NICKNAME["USE"] == "Y" && $S_JOIN_NICKNAME["JOIN"] == "Y" && $S_JOIN_NICKNAME["NES"] == "Y"){?>
			<?if (!$S_JOIN_NICKNAME["GRADE"] || in_array($strMemberJoinType,$S_JOIN_NICKNAME["GRADE"])){?>
		if(!C_chkInput("nickname",true,"닉네임",true)) return;

		if ($("#nickname").val().length < 4 || $("#nickname").val().length > 16)
		{
			alert("닉네임은 한글, 영문, 숫자 중 4자 이상 16자리 이하 사용 가능합니다.");
			doc.nickname.value = "";
			doc.nickname.focus();
			return;
		}

		if (C_containsChars($("#nickname").val())) {
			alert("닉네임 필드에는 특수 문자를 사용할 수 없습니다.");
			doc.nickname.value = "";
			doc.nickname.focus();
			return;;
		}

		if (strNickNameChkFlag == "N")
		{
			alert("닉네임 중복체크를 해주세요.");
			return;
		}
			<?}?>
		<?}?>

		<?if ($S_JOIN_BIRTH["USE"] == "Y" && $S_JOIN_BIRTH["JOIN"] == "Y" && $S_JOIN_BIRTH["NES"] == "Y"){?>
			<?if (!$S_JOIN_BIRTH["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BIRTH["GRADE"])){?>
		if(!C_chkInput("birth1",true,"<?=$LNG_TRANS_CHAR['MW00006']?>",true)) return; //생년월일
		if(!C_chkInput("birth2",true,"<?=$LNG_TRANS_CHAR['MW00006']?>",true)) return; //생년월일
		if(!C_chkInput("birth3",true,"<?=$LNG_TRANS_CHAR['MW00006']?>",true)) return; //생년월일
			<?}?>
		<?}?>

		<?if ($S_JOIN_SEX["USE"] == "Y" && $S_JOIN_SEX["JOIN"] == "Y" && $S_JOIN_SEX["NES"] == "Y"){?>
			<?if (!$S_JOIN_SEX["GRADE"] || in_array($strMemberJoinType,$S_JOIN_SEX["GRADE"])){?>
		var strSex = $(":radio[name='sex']:checked").val();
		if (!strSex)
		{
			alert("<?=$LNG_TRANS_CHAR['MS00010']?>"); //성별을 선택해주세요.
			return;
		}
			<?}?>
		<?}?>

		<?if ($S_JOIN_MAIL["USE"] == "Y" && $S_JOIN_MAIL["JOIN"] == "Y" && $S_JOIN_MAIL["NES"] == "Y"){?>
			<?if (!$S_JOIN_MAIL["GRADE"] || in_array($strMemberJoinType,$S_JOIN_MAIL["GRADE"])){?>

		if(!C_chkInput("mail",true,"<?=$LNG_TRANS_CHAR['MW00010']?>",true)) return; //이메일

		if (!C_isValidEmail(doc.mail.value)) {
			alert("<?=$LNG_TRANS_CHAR['MS00009']?>"); //올바른 이메일 주소가 아닙니다.
			doc.mail.focus();
			return;
		}
			<?}?>
		<?}?>

		//핸드폰
		<?/*if ($S_JOIN_HP["USE"] == "Y" && $S_JOIN_HP["JOIN"] == "Y" && $S_JOIN_HP["NES"] == "Y"){?>
			<?if (!$S_JOIN_HP["GRADE"] || in_array($strMemberJoinType,$S_JOIN_HP["GRADE"])){?>
				<?if ($S_SITE_LNG != "KR"){?>
					if(!C_chkInput("hp1",true,"<?=$LNG_TRANS_CHAR['MW00008']?>",true)) return; //핸드폰
				<?}else{?>
					if(!C_chkInput("hp2",true,"<?=$LNG_TRANS_CHAR['MW00008']?>",true)) return; //핸드폰
					if(!C_chkInput("hp3",true,"<?=$LNG_TRANS_CHAR['MW00008']?>",true)) return;
				<?}?>
			<?}?>
		<?}*/?>
		//전화번호
		<?if ($S_JOIN_PHONE["USE"] == "Y" && $S_JOIN_PHONE["JOIN"] == "Y" && $S_JOIN_PHONE["NES"] == "Y"){?>
			<?if (!$S_JOIN_PHONE["GRADE"] || in_array($strMemberJoinType,$S_JOIN_PHONE["GRADE"])){?>
				if(doc.memberGroup.value == "<?=$aryMemberGroup[2][G_CODE]?>"){
				<?if ($S_SITE_LNG != "KR"){?>
					if(!C_chkInput("phone1",true,"<?=$LNG_TRANS_CHAR['MW00009']?>",true)) return;
				<?}else{?>
					if(!C_chkInput("phone2",true,"<?=$LNG_TRANS_CHAR['MW00009']?>",true)) return;
					if(!C_chkInput("phone3",true,"<?=$LNG_TRANS_CHAR['MW00009']?>",true)) return;
				<?}?>
				}	
			<?}?>
		<?}?>

		//Fax
		<?if ($S_JOIN_FAX["USE"] == "Y" && $S_JOIN_FAX["JOIN"] == "Y" && $S_JOIN_FAX["NES"] == "Y"){?>
			<?if (!$S_JOIN_FAX["GRADE"] || in_array($strMemberJoinType,$S_JOIN_FAX["GRADE"])){?>
				<?if ($S_SITE_LNG != "KR"){?>
					if(!C_chkInput("fax1",true,"<?=$LNG_TRANS_CHAR['MW00017']?>",true)) return;
				<?}else{?>
					if(!C_chkInput("fax2",true,"<?=$LNG_TRANS_CHAR['MW00017']?>",true)) return;
					if(!C_chkInput("fax3",true,"<?=$LNG_TRANS_CHAR['MW00017']?>",true)) return;
				<?}?>
			<?}?>
		<?}?>

		//이메일
		<?if ($S_MEM_CERITY == "1"){?>
			<?if ($S_JOIN_MAIL["USE"] == "Y" && $S_JOIN_MAIL["JOIN"] == "Y" && $S_JOIN_MAIL["NES"] == "Y"){?>
				<?if (!$S_JOIN_MAIL["GRADE"] || in_array($strMemberJoinType,$S_JOIN_MAIL["GRADE"])){?>
					if(!C_chkInput("mail",true,"<?=$LNG_TRANS_CHAR['OW00011']?>",true)) return; //이메일

					if (!C_isValidEmail(doc.mail.value)) {
						alert("<?=$LNG_TRANS_CHAR['MS00009']?>"); //올바른 이메일 주소가 아닙니다.
						doc.mail.focus();
						return;
					}
				<?}?>
			<?}?>
		<?}?>
		//주소
		<?if ($S_JOIN_ADDR["USE"] == "Y" && $S_JOIN_ADDR["JOIN"] == "Y" && $S_JOIN_ADDR["NES"] == "Y"){?>
			<?if (!$S_JOIN_ADDR["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADDR["GRADE"])){?>
				<?if ($S_SITE_LNG == "KR"){?>
				if(!C_chkInput("zip1",true,"<?=$LNG_TRANS_CHAR['MW00014']?>",true)) return;
				if(!C_chkInput("zip2",true,"<?=$LNG_TRANS_CHAR['MW00014']?>",true)) return;
				if(!C_chkInput("addr1",true,"<?=$LNG_TRANS_CHAR['MW00011']?>",true)) return;
				if(!C_chkInput("addr2",true,"<?=$LNG_TRANS_CHAR['MW00013']?>",true)) return;
				<?} else {?>
				var strCountry	= $("#country option:selected").val();
				if (C_isNull(strCountry))
				{
					alert("<?=$LNG_TRANS_CHAR['MS00030']?>"); //국가를 선택해주세요.
					return;
				}

				if(!C_chkInput("addr1",true,"<?=$LNG_TRANS_CHAR['MW00011']?>",true)) return;
				if(!C_chkInput("addr2",true,"<?=$LNG_TRANS_CHAR['MW00013']?>",true)) return;
				if(!C_chkInput("city",true,"<?=$LNG_TRANS_CHAR['MW00022']?>",true)) return;
				if(!C_chkInput("zip1",true,"<?=$LNG_TRANS_CHAR['MW00014']?>",true)) return;
				<?}?>
			<?}?>
		<?}?>

		//사진
		<?if ($S_JOIN_PHOTO["USE"] == "Y" && $S_JOIN_PHOTO["JOIN"] == "Y" && $S_JOIN_PHOTO["NES"] == "Y"){?>
			<?if (!$S_JOIN_PHOTO["GRADE"] || in_array($strMemberJoinType,$S_JOIN_PHOTO["GRADE"])){?>
			if(!C_chkInput("photo",true,"<?=$LNG_TRANS_CHAR['MW00018']?>",true)) return;
			<?}?>
		<?}?>

		//추천인
		<?if ($S_JOIN_REC["USE"] == "Y" && $S_JOIN_REC["JOIN"] == "Y" ){?>
			<? if ( $S_MEM_CERITY == 2 ) : ?>
			if ( $('#rec_id').length > 0 && $('#rec_id').val() != '' && ! C_isValidEmail ( $('#rec_id').val() ) )
			{
				alert("<?=$LNG_TRANS_CHAR['MS00009']?>"); //올바른 이메일 주소가 아닙니다.
				$('#rec_id').focus();
				return;
			}
			<? endif ; ?>
			<?if ( $S_JOIN_REC["NES"] == "Y" && ( !$S_JOIN_REC["GRADE"] || in_array($strMemberJoinType,$S_JOIN_REC["GRADE"] ))){?>
			if(!C_chkInput("rec_id",true,"<?=$LNG_TRANS_CHAR['MW00019']?>",true)) return;
			<?}?>
		<?}?>

		//회사명
		<?if ($S_JOIN_COM["USE"] == "Y" && $S_JOIN_COM["JOIN"] == "Y" && $S_JOIN_COM["NES"] == "Y"){?>
			<?if (!$S_JOIN_COM["GRADE"] || in_array($strMemberJoinType,$S_JOIN_COM["GRADE"])){?>
			if(!C_chkInput("com_nm",true,"<?=$LNG_TRANS_CHAR['MW00020']?>",true)) return;
			<?}?>
		<?}?>

		//상호명
		<?if ($S_JOIN_BUSI_INFO["USE"] == "Y"){?>
		<?if ($S_JOIN_BUSI_NM["USE"] == "Y" && $S_JOIN_BUSI_NM["JOIN"] == "Y" && $S_JOIN_BUSI_NM["NES"] == "Y"){?>
			<?if (!$S_JOIN_BUSI_NM["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BUSI_NM["GRADE"])){?>
			if(doc.memberGroup.value == "<?=$aryMemberGroup[2][G_CODE]?>"){
				if(!C_chkInput("busi_nm",true,"<?=$LNG_TRANS_CHAR['MW00032']?>",true)) return;
			}
			<?}?>
		<?}?>

		//사업자번호
		<?if ($S_JOIN_BUSI_NUM["USE"] == "Y" && $S_JOIN_BUSI_NUM["JOIN"] == "Y" && $S_JOIN_BUSI_NUM["NES"] == "Y"){?>
			<?if (!$S_JOIN_BUSI_NUM["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BUSI_NUM["GRADE"])){?>
			if(doc.memberGroup.value == "<?=$aryMemberGroup[2][G_CODE]?>"){
			if(!C_chkInput("busi_num1",true,"<?=$LNG_TRANS_CHAR['MW00033']?>",true)) return;
			if(!C_chkInput("busi_num2",true,"<?=$LNG_TRANS_CHAR['MW00033']?>",true)) return;
			if(!C_chkInput("busi_num3",true,"<?=$LNG_TRANS_CHAR['MW00033']?>",true)) return;
			}
			<?}?>
		<?}?>


		//업종
		<?if ($S_JOIN_BUSI_UPJONG["USE"] == "Y" && $S_JOIN_BUSI_UPJONG["JOIN"] == "Y" && $S_JOIN_BUSI_UPJONG["NES"] == "Y"){?>
			<?if (!$S_JOIN_BUSI_UPJONG["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BUSI_UPJONG["GRADE"])){?>
			if(!C_chkInput("busi_upj",true,"<?=$LNG_TRANS_CHAR['MW00034']?>",true)) return;
			<?}?>
		<?}?>

		//업태
		<?if ($S_JOIN_BUSI_UPTAE["USE"] == "Y" && $S_JOIN_BUSI_UPTAE["JOIN"] == "Y" && $S_JOIN_BUSI_UPTAE["NES"] == "Y"){?>
			<?if (!$S_JOIN_BUSI_UPTAE["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BUSI_UPTAE["GRADE"])){?>
			if(!C_chkInput("busi_ute",true,"<?=$LNG_TRANS_CHAR['MW00035']?>",true)) return;
			<?}?>
		<?}?>

		//주소
		<?if ($S_JOIN_BUSI_ADDR["USE"] == "Y" && $S_JOIN_BUSI_ADDR["JOIN"] == "Y" && $S_JOIN_BUSI_ADDR["NES"] == "Y"){?>
			<?if (!$S_JOIN_BUSI_ADDR["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BUSI_ADDR["GRADE"])){?>
			if(!C_chkInput("busi_zip1",true,"<?=$LNG_TRANS_CHAR['MW00014']?>",true)) return;
			if(!C_chkInput("busi_zip2",true,"<?=$LNG_TRANS_CHAR['MW00014']?>",true)) return;
			if(!C_chkInput("busi_addr1",true,"<?=$LNG_TRANS_CHAR['MW00011']?>",true)) return;
			if(!C_chkInput("busi_addr2",true,"<?=$LNG_TRANS_CHAR['MW00013']?>",true)) return;
			<?}?>
		<?}?>
		<?}?>

		//결혼여부
		<?if ($S_JOIN_ADD_WED["USE"] == "Y" && $S_JOIN_ADD_WED["JOIN"] == "Y" && $S_JOIN_BUSI_ADDR["NES"] == "Y"){?>
			<?if (!$S_JOIN_ADD_WED["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADD_WED["GRADE"])){?>
			var strWed = $(":radio[name='weddingYN']:checked").val();
			if (!strWed)
			{
				alert("<?=$LNG_TRANS_CHAR['MS00031']?>"); //결혼여부를 선택해주세요.
				return;
			}
			<?}?>
		<?}?>

		//결혼기념일
		<?if ($S_JOIN_ADD_WED_DAY["USE"] == "Y" && $S_JOIN_ADD_WED_DAY["JOIN"] == "Y" && $S_JOIN_ADD_WED_DAY["NES"] == "Y"){?>
			<?if (!$S_JOIN_ADD_WED_DAY["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADD_WED_DAY["GRADE"])){?>
			if(!C_chkInput("weddingDay1",true,"<?=$LNG_TRANS_CHAR['MW00025']?>",true)) return;
			if(!C_chkInput("weddingDay2",true,"<?=$LNG_TRANS_CHAR['MW00025']?>",true)) return;
			if(!C_chkInput("weddingDay3",true,"<?=$LNG_TRANS_CHAR['MW00025']?>",true)) return;
			<?}?>
		<?}?>

		//자녀
		<?if ($S_JOIN_ADD_CHILD["USE"] == "Y" && $S_JOIN_ADD_CHILD["JOIN"] == "Y" && $S_JOIN_ADD_CHILD["NES"] == "Y"){?>
			<?if (!$S_JOIN_ADD_CHILD["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADD_CHILD["GRADE"])){?>
			if(!C_chkInput("child",true,"<?=$LNG_TRANS_CHAR['MW00026']?>",true)) return;
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
				if(!C_chkInput("concern",true,"<?=$LNG_TRANS_CHAR['MW00028']?>",true)) return;
				<?} else if ($S_JOIN_ADD_CONCERN["TYPE"] == "R"){?>

				var strConcern = $(":radio[name='concern']:checked").val();
				if (!strConcern)
				{
					alert("<?=$LNG_TRANS_CHAR['MS00032']?>"); //관신분야를 선택해주세요.
					return;
				}
				<?} else if ($S_JOIN_ADD_CONCERN["TYPE"] == "C"){?>
				var strConcern = $(":checkbox[name='concern']:checked").val();
				if (!strConcern)
				{
					alert("<?=$LNG_TRANS_CHAR['MS00032']?>"); //관신분야를 선택해주세요.
					return;
				}
				<?} else if ($S_JOIN_ADD_CONCERN["TYPE"] == "S"){?>

				var strConcern	= $("#concern option:selected").val();
				if (C_isNull(strConcern))
				{
					alert("<?=$LNG_TRANS_CHAR['MS00032']?>"); //관신분야를 선택해주세요.
					return;
				}
				<?}?>
			<?}?>
		<?}?>

		<?if ($S_JOIN_ADD_TEXT["USE"] == "Y" && $S_JOIN_ADD_TEXT["JOIN"] == "Y" && $S_JOIN_ADD_TEXT["NES"] == "Y"){?>
			<?if (!$S_JOIN_ADD_TEXT["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADD_TEXT["GRADE"])){?>
			if(!C_chkInput("memo",true,"<?=$LNG_TRANS_CHAR['MW00029']?>",true)) return;
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

		<?if($phoneCheck == "Y"): /* 휴대폰 인증 */ ?>
		var disHp1 = $("select[name=hp1]").attr("disabled");
		var disHp2 = $("input[name=hp2]").attr("disabled");
		var disHp3 = $("input[name=hp3]").attr("disabled");
		if(!disHp1 || !disHp2 || !disHp3) {
			alert("휴대폰 인증이 필요합니다.");
			return;
		}

		$("select[name=hp1]").attr("disabled",false);
		$("input[name=hp2]").attr("disabled",false);
		$("input[name=hp3]").attr("disabled",false);
		<?endif;?>


		document.form.encoding = "multipart/form-data";
		C_getAction("join","<?=$PHP_SELF?>");
	}

	/* 로그인 */
	function goLogin()
	{
		
		// 테스트
		//$("#errMsg").html("테스트입니다.");
		
		<?if ($S_MEM_CERITY == "1"){?>
		if(!C_chkInput("login_id",true,"<?=$LNG_TRANS_CHAR['MW00001']?>",true)) return; //아이디
		<?}?>
		<?if ($S_MEM_CERITY == "2"){?>
		if(!C_chkInput("login_id",true,"<?=$LNG_TRANS_CHAR['MW00010']?>",true)) return; //이메일
		<?}?>
		if(!C_chkInput("login_pwd",true,"<?=$LNG_TRANS_CHAR['MW00002']?>",true)) return; //비밀번호

		<?if ($S_MAIN_LAYERPOP_LOGIN_USE == "Y" && $strDevice != "m"){	// 레이어 팝업 사용할 때 ?>
		var doc = document.form;
		doc.menuType.value = "member";
		doc.mode.value = "act";
		doc.act.value = "login";
		var formData = $("#form").serialize();
		C_AjaxPost("login","./index.php",formData,"post");
		<?}else{?>
			//로그인처리
// 				C_getAction("login","<?=$PHP_SELF?>");	
				
//				if(checkDevice()){
//					//alert("web인가?");
//				}else{		
					// 모바일인지 체크	
					var filter = "win16|win32|win64|mac";
					if( navigator.platform  ){
						if( filter.indexOf(navigator.platform.toLowerCase())<0 ){
								try{
									if(fnCheckiPhone()){ //아이폰

											//console.log("getUserAgent() ::"+getUserAgent());
											//console.log("checkDevice() ::"+checkDevice());
											if( fnUserAgent() ){
												var url = "/";
										 		window.location = "snTec://login?URL="+url+"§†M_ID="+$("#login_id").val()+"§†API_URL=http://222.122.20.23/mobileApi.php";
										 		return;
											}
										 	
								 	}else{//안드로이드
								 		window.SNT.setLogin($("#login_id").val());
								 	}
								 	
								 	
								} catch(err) {}
						}
					}	
//				}
				
				C_getAction("login","<?=$PHP_SELF?>");
				
			
		<?}?>
	}
	
	// ios에서 자바스크립트 호출해서 처리
	function return_orgFile() {

		C_getAction("login","<?=$PHP_SELF?>");
		
	}
	

	// vewView 접속 여부 체크
	function checkDevice() {
	 var isView=(/(darwin|cfnetwork)/i).test(navigator.userAgent);
	
	 if( isView ) return true;
	 else return false;
	}
	
	/* 비회원 주문 */
	function goNonMemberOrder()
	{

		<?if($S_MAIN_LAYERPOP_LOGIN_USE == "Y" && $strDevice != "m"){?>

		var strOrderChkVal = C_getCheckedCode(parent.document.form["cartNo[]"]);
		if (C_isNull(strOrderChkVal))
		{
			alert("<?=$LNG_TRANS_CHAR['OS00024']?>"); //"주문하실 상품이 존재하지 않습니다."
			return;
		}

		var doc = parent.document.form;
		doc.menuType.value = "order";
		doc.mode.value = "order";
		doc.basketDirect.value = "Y";
		doc.method = "post";
		doc.action = "<?=$PHP_SELF?>";
		doc.submit();

		<?}else{?>
		var doc = document.form;
		doc.menuType.value = "order";
		doc.mode.value = "order";
		doc.basketDirect.value = "Y";
		doc.method = "post";
		doc.action = "<?=$PHP_SELF?>";
		doc.submit();
		<?}?>
	}

	/* Ajax 결과 */
	function goAjaxRet(name,result){

		if (name == "buyNonList")
		{
			var doc = document.form;
			var data = eval(result);

			if (data[0].RET == "Y"){
				parent.goLayerPopClose("./?menuType=mypage&mode=buyNonList&searchOrderName="+$("#searchOrderName").val()+"&searchOrderKey="+$("#searchOrderKey").val(),"");
			} else {
				$("#searchOrderName").val("주문자");
				$("#searchOrderKey").val("주문번호");
				alert("<?=$LNG_TRANS_CHAR['OS00007']?>"); //주문자 및 주문번호에 해당하는 주문내역이 존재하지 않습니다.
				return;
			}
		}

		if (name == "login")
		{
			var doc = document.form;
			var data = eval(result);

			if (data[0].RET == "Y"){
				parent.goLayerPopClose(data[0].URL,data[0].TYPE);
			} else {
				alert(data[0].MSG);
				$("#login_id").val("");
				$("#login_pwd").val("");
				$("#login_id").focus();
				return;
			}
		}

		if(name == "memberPhoneKeyRequest") {
			var data = eval(result);
			console.log(data);
			if(data[0]['RET'] == "START"){
				// 인증키 등록 대기 시작
				$("input[name=phoneKey]").css({'display':''});
				$("#memberPhoneKeyCheck").css({'display':''});
				$("div[id=memberPhoneKeyMsg]").css({'display':'none'});
				goStart();
			}else if(data[0]['RET'] == "OVER") {
				alert("문자 발송 가능 건수를 초과하였습니다. 잠시 후 다시 시도해 주세요");
			}
		}else if(name == "memberPhoneKeyCheck") {
			var data = eval(result);
			if(data[0]['RET'] == "WRONG"){
				alert("잘못된 인증번호 입니다.인증번호를 확인한 후 다시 입력해 주세요");
			}else if(data[0]['RET'] == "CORRECT"){
		//		$("span[id=memberPhoneKeyRequest]").html("휴대폰 인증 완료!!");
				$("span[id=memberPhoneKeyRequest]").html("");
				$("input[name=phoneKey]").css({'display':'none'});
				$("#memberPhoneKeyCheck").remove();
				$("#memberPhoneKeyCountDown").remove();
				$("select[name=hp1]").attr("disabled",true);
				$("input[name=hp2]").attr("disabled",true);
				$("input[name=hp3]").attr("disabled",true);
				alert("인증되었습니다.");
			}
		}else if(name == "memberPhoneKeyExpire") {
			var data = eval(result);
			if(data[0]['RET'] == "EXPIRE") {
				$("div[id=memberPhoneKeyMsg]").css({'display':''});
				alert("입력 시간을 초과 하였습니다.휴대폰 인증이 취소 되었습니다.");
			}
		}
	}

	/* 비회원 주문 검색하기 */
	function goNonOrderSearch()
	{

		var doc = document.form;

		if(!C_chkInput("searchOrderName",true,"<?=$LNG_TRANS_CHAR['OW00015']?>",true)) return; //주문자
		if(!C_chkInput("searchOrderKey",true,"<?=$LNG_TRANS_CHAR['OW00057']?>",true)) return; //주문번호

		<?if($S_MAIN_LAYERPOP_LOGIN_USE == "Y" && $strDevice != "m"){?>
		doc.menuType.value = "mypage";
		doc.mode.value = "json";
		doc.act.value = "buyNonList";
		var formData = $("#form").serialize();
		C_AjaxPost("buyNonList","./index.php",formData,"post");

		<?}else{?>
		doc.menuType.value = "mypage";
		doc.mode.value = "buyNonList";
		doc.method = "post";
		doc.action = "<?=$PHP_SELF?>";
		doc.submit();
		<?}?>
	}

	/* 페이스북 로그인 */
// 2014.08.21 kim hee sung 임시 대기
//	function goFacebookLogin()
//	{
//		var oldToken = FB.getAccessToken();
//		var width = $(document).width();
//		var height = $(document).height();
//
//		$("div#indicatorLayer").css({width:width,height:height}).show();
//
//		FB.login(function(response) {
////			if(response.authResponse && response.authResponse.accessToken != oldToken) {
//			if(response.authResponse) {
//				var objData = new Object();
//				objData['menuType'] = 'member';
//				objData['mode'] = 'json';
//				objData['act'] = 'facebook';
//				$.post("./", objData, function (data) {
//					console.log(data);
//
////					if (data[0].RET == "Y")
////					{
////						$("div#indicatorLayer").hide();
////						alert("<?=$LNG_TRANS_CHAR['MS00024']?>"); //"페이스북으로 로그인 되었습니다."
////						location.href = "./index.php";
////					} else {
////						$("div#indicatorLayer").hide();
////						alert("페이스북에 로그인 할 수없습니다.");
////					}
//				});
//			} else {
//				$("div#indicatorLayer").hide();
//				alert("페이스북에 로그인 할 수없습니다.");
//			}
//
//		}, { scope: 'email,publish_stream,user_likes' });
//	}
//
// 2014.06.12 kim hee sung old style
	function goFacebookLogin()
	{
		$.getJSON("./?menuType=member&mode=json&act=facebook",function(data){
			if (data[0].RET == "Y")
			{
				alert("<?=$LNG_TRANS_CHAR['MS00024']?>"); //"페이스북으로 로그인 되었습니다."
				location.href = "./index.php";
			} else {
				var isOpen = window.open('?menuType=etc&mode=facebook','new','width=450px,height=260px,top=300px,left=400px,menubar=no,location=no,scrollbars=yes,status=no,resizable=no');
				if (isOpen == null)
				{
					alert("Please allow popups in your browser");
				}
 			}
		});
	}

	function goSearchPwd()
	{
		var doc			= document.form;
		var strId		= "";
		var strLName	= "";
		var strMail1	= "";
		var strMail2	= "";
		var strHp1		= "";
		var strHp2		= "";
		var strHp3		= "";
		var strAce		= "";
		var urlFNmae	= "";

		<?if ($S_MEM_CERITY == "1"){?>
		strId		= doc.searchPass_Id.value;
		strLName	= doc.searchPass_L_Name.value;
		strMail1	= doc.searchPass_Mail1.value;
		strMail2	= doc.searchPass_Mail2.value;
		strHp1		= doc.searchPass_Hp1.value;
		strHp2		= doc.searchPass_Hp2.value;
		strHp3		= doc.searchPass_Hp3.value;
		strAce		= doc.searchPass_Type.value;

		if(!C_chkInput("searchPass_Id",true,"<?=$LNG_TRANS_CHAR['MW00001']?>",true)) return; //아이디
		if(!C_chkInput("searchPass_L_Name",true,"<?=$LNG_TRANS_CHAR['MW00004']?>",true)) return; //이름

		if(strAce == "searchPwd")
		{
			if(!C_chkInput("searchPass_Mail1",true,"<?=$LNG_TRANS_CHAR['MW00010']?>",true)) return; //이메일
			if(!C_chkInput("searchPass_Mail2",true,"<?=$LNG_TRANS_CHAR['MW00010']?>",true)) return; //이메일
		}
		else if(strAce == "searchPwdSms")
		{
			if(!C_chkInput("searchPass_Hp1",true,"<?=$LNG_TRANS_CHAR['MW00008']?>",true)) return; //휴대폰
			if(!C_chkInput("searchPass_Hp2",true,"<?=$LNG_TRANS_CHAR['MW00008']?>",true)) return; //휴대폰
			if(!C_chkInput("searchPass_Hp3",true,"<?=$LNG_TRANS_CHAR['MW00008']?>",true)) return; //휴대폰
		}
		else
		{
			return;
		}
		<?}?>
		<?if ($S_MEM_CERITY == "2"){?>
			<?if($S_MEMBER_PWD_FIND_ID_USE != "Y"){ //이름으로 찾을때?>
		strLName	= doc.searchPass_L_Name.value;
		strMail1	= doc.searchPass_Mail1.value;
		strMail2	= doc.searchPass_Mail2.value;
		strAce      = "searchPwd";
		if(!C_chkInput("searchPass_L_Name",true,"<?=$LNG_TRANS_CHAR['MW00004']?>",true)) return; //이름
		if(!C_chkInput("searchPass_Mail1",true,"<?=$LNG_TRANS_CHAR['MW00010']?>",true)) return; //이메일
		if(!C_chkInput("searchPass_Mail2",true,"<?=$LNG_TRANS_CHAR['MW00010']?>",true)) return; //이메일

			<?}else{?>
		strId		= doc.searchPass_Id.value;
		strMail1	= doc.searchPass_Mail1.value;
		strMail2	= doc.searchPass_Mail2.value;
		strAce      = "searchPwd";
		if(!C_chkInput("searchPass_Id",true,"<?=$LNG_TRANS_CHAR['MW00001']?>",true)) return; //아이디
		if(!C_chkInput("searchPass_Mail1",true,"<?=$LNG_TRANS_CHAR['MW00010']?>",true)) return; //이메일
		if(!C_chkInput("searchPass_Mail2",true,"<?=$LNG_TRANS_CHAR['MW00010']?>",true)) return; //이메일
			<?}?>
		<?}?>

		<?if($S_SITE_LNG != "KR"):?>
		strFName		= doc.searchPass_F_Name.value;
		if(!C_chkInput("searchPass_F_Name",true,"<?=$LNG_TRANS_CHAR['MW00004']?>",true)) return; //성
		urlFNmae		= urlFNmae + "&searchPass_F_Name="+encodeURIComponent(strFName);
		<?endif;?>

		var url			= "./?menuType=member&mode=json&act="+strAce+"&searchPass_Id="+strId+"&searchPass_L_Name="+encodeURIComponent(strLName);
		    url         = url + "&searchPass_Mail1="+strMail1+"&searchPass_Mail2="+strMail2;
			url         = url + "&searchPass_Hp1="+strHp1+"&searchPass_Hp2="+strHp2+"&searchPass_Hp3="+strHp3+urlFNmae;

		<?if($S_SHOP_ID == "tablelife"){?>
//		location.href = url;
//		return;
		<?}?>

		$.getJSON(url,function(data){
			alert(data[0].MSG);
			<?if ($S_MEM_CERITY == "1"){?>
			doc.searchPass_Id.value = "";
			doc.searchPass_Id.focus();
			doc.searchPass_Hp1.value = "";
			doc.searchPass_Hp2.value = "";
			doc.searchPass_Hp3.value = "";
			<?}?>
			<?if($S_MEMBER_PWD_FIND_ID_USE != "Y"){ //이름으로 찾을때?>
			doc.searchPass_L_Name.value = "";
			doc.searchPass_Mail1.value = "";
			doc.searchPass_Mail2.value = "";
			<?}else{?>
			doc.searchPass_Id.value = "";
			doc.searchPass_Mail1.value = "";
			doc.searchPass_Mail2.value = "";
			<?}?>
		});
	}

	// 이메일 찾기
	function goMemberFindIdPwdFindEmailActEvent() {

		// 기본 설정
		var strFindIDName = $("[name=findIDName]").val();
		var strFindIDHp1 = $("[name=findIDHp1]").val();
		var strFindIDHp2 = $("[name=findIDHp2]").val();
		var strFindIDHp3 = $("[name=findIDHp3]").val();

		// 기본 체크
		if(!strFindIDName) {
			alert("성명을 입력하세요.");
			$("[name=findIDName]").focus();
			return;
		}
		if(!strFindIDHp2) {
			alert("휴대폰 번호를 입력하세요.");
			$("[name=findIDHp2]").focus();
			return;
		}
		if(!strFindIDHp3) {
			alert("휴대폰 번호를 입력하세요.");
			$("[name=findIDHp3]").focus();
			return;
		}

		// 이메일 체크
		var data					= new Object();
		data['menuType']			= "member";
		data['mode']				= "json";
		data['act']					= "findEmail";
		data['name']				= strFindIDName;
		data['hp1']					= strFindIDHp1;
		data['hp2']					= strFindIDHp2;
		data['hp3']					= strFindIDHp3;
		$.ajax({
			url			: "./"
		   ,data		: data
		   ,type		: "POST"
		   ,dataType	: "json"
		   ,success		: function(data){

			   if(data['__STATE__'] == "SUCCESS") {
				   var strEMail = data['__DATA__']['email'];
				   alert("고객님의 이메일은 " + strEMail + " 입니다.");
			   } else {
				   if(data['__MSG__']) { alert(data['__MSG__']); }
				   else { console.log(data); }
			   }
		   }
		});
	}
	function memberGradeCheck()
	{
		var doc			= document.form;
		var ch = doc.memberGroup[1].checked;
		if(	ch )
		{
			$(".comView").show();
		}
		else
		{
			$(".comView").hide();
		}
	}
//-->
</script>
<? include_once "{$S_DOCUMENT_ROOT}www/web/member/memberJoinFormCheckModule.js.php"; ?>