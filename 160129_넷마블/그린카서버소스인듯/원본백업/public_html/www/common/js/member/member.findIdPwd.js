	// 한국어 아이디 찾기
	function goMemberFindIdPwdKoreaIdFindEvent() {

		var objTarget = $('#koreaId');
		var objLanguage = objScriptData['LANGUAGE'];
		var strFirstName = objTarget.find('[name=firstName]').val();
		//var strPhone = objTarget.find('[name=phone]').val();
		var strEmail1 = objTarget.find('[name=pwdEmail1]').val();
		var strEmail2 = objTarget.find('[name=pwdEmail2]').val();

		if(!strFirstName) {
			alert(objLanguage['MS00052']); // 이름을 입력하세요.
			objTarget.find('[name=firstName]').focus();
			return;
		}

		//if(!strPhone) {
		//	alert(objLanguage['MS00054']); // 연락처를 입력하세요.
		//	objTarget.find('[name=phone]').focus();
		//	return;
		//}

		var data			= new Object();
		data['menuType']	= "member";
		data['mode']		= "json";
		data['act']			= "findKoreaId";
		data['firstName']	= strFirstName;
		//data['phone']		= strPhone;
		data['email1']		= strEmail1;
		data['email2']		= strEmail2;

		$.ajax({
			url			: "./"
		   ,data		: data
		   ,type		: "POST"
		   ,dataType	: "json"
		   ,success		: function(data){
				if(data['__STATE__'] == "SUCCESS") {

					var strMsg = data['__MSG__'];
					alert(strMsg);

				} else {
					var strMsg = data['__MSG__'];
					if(!strMsg) { strMsg = data; }
					alert(strMsg);
				}										
			}	
		});

	}

	// 한국어 이메일 찾기
	function goMemberFindIdPwdKoreaEmailFindEvent() {

		var objTarget = $('#koreaEmail');
		var objLanguage = objScriptData['LANGUAGE'];
		var strFirstName = objTarget.find('[name=firstName]').val();
		//var strPhone = objTarget.find('[name=phone]').val();
		var strEmail1 = objTarget.find('[name=pwdEmail1]').val();
		var strEmail2 = objTarget.find('[name=pwdEmail2]').val();

		if(!strFirstName) {
			alert(objLanguage['MS00052']); // 이름을 입력하세요.
			objTarget.find('[name=firstName]').focus();
			return;
		}

		//if(!strPhone) {
		//	alert(objLanguage['MS00054']); // 연락처를 입력하세요.
		//	objTarget.find('[name=phone]').focus();
		//	return;
		//}

		if(!strEmail1) {
			alert(objLanguage['MS00055']); // 이메일을 입력하세요.
			objTarget.find('[name=pwdEmail1]').focus();
			return;
		}
		
		if(!strEmail2) {
			alert(objLanguage['MS00055']); // 이메일을 입력하세요.
			objTarget.find('[name=pwdEmail2]').focus();
			return;
		}

		var data			= new Object();
		data['menuType']	= "member";
		data['mode']		= "json";
		data['act']			= "findKoreaEmail";
		data['firstName']	= strFirstName;
		//data['phone']		= strPhone;
		data['email1']		= strEmail1;
		data['email2']		= strEmail2;

		$.ajax({
			url			: "./"
		   ,data		: data
		   ,type		: "POST"
		   ,dataType	: "json"
		   ,success		: function(data){
				if(data['__STATE__'] == "SUCCESS") {

					var strMsg = data['__MSG__'];
					alert(strMsg);

				} else {
					var strMsg = data['__MSG__'];
					if(!strMsg) { strMsg = data; }
					alert(strMsg);
				}										
			}	
		});
	}

	// 다국어 이메일 찾기
	function goMemberFindIdPwdGlobalEmailFindEvent() {

		var objTarget = $('#globalEmail');
		var objLanguage = objScriptData['LANGUAGE'];
		var strFirstName = objTarget.find('[name=firstName]').val();
		var strLastName = objTarget.find('[name=lastName]').val();
		//var strPhone = objTarget.find('[name=phone]').val();
		var strEmail1 = objTarget.find('[name=pwdEmail1]').val();
		var strEmail2 = objTarget.find('[name=pwdEmail2]').val();

		if(!strFirstName) {
			alert(objLanguage['MS00052']); // 이름을 입력하세요.
			objTarget.find('[name=firstName]').focus();
			return;
		}

		if(!strLastName) {
			alert(objLanguage['MS00053']); // 성을 입력하세요.
			objTarget.find('[name=lastName]').focus();
			return;
		}

		//if(!strPhone) {
		//	alert(objLanguage['MS00054']); // 연락처를 입력하세요.
		//	objTarget.find('[name=phone]').focus();
		//	return;
		//}

		if(!strEmail1) {
			alert(objLanguage['MS00055']); // 이메일을 입력하세요.
			objTarget.find('[name=pwdEmail1]').focus();
			return;
		}
		
		if(!strEmail2) {
			alert(objLanguage['MS00055']); // 이메일을 입력하세요.
			objTarget.find('[name=pwdEmail2]').focus();
			return;
		}

		var data			= new Object();
		data['menuType']	= "member";
		data['mode']		= "json";
		data['act']			= "findGlobalEmail";
		data['firstName']	= strFirstName;
		data['lastName']	= strLastName;
		//data['phone']		= strPhone;
		data['email1']		= strEmail1;
		data['email2']		= strEmail2;

		$.ajax({
			url			: "./"
		   ,data		: data
		   ,type		: "POST"
		   ,dataType	: "json"
		   ,success		: function(data){
				if(data['__STATE__'] == "SUCCESS") {

					var strMsg = data['__MSG__'];
					alert(strMsg);

				} else {
					var strMsg = data['__MSG__'];
					if(!strMsg) { strMsg = data; }
					alert(strMsg);
				}										
			}	
		});

	}

		// 다국어 아이디 찾기
	function goMemberFindIdPwdGlobalIdFindEvent() {

		var objTarget = $('#globalId');
		var objLanguage = objScriptData['LANGUAGE'];
		var strFirstName = objTarget.find('[name=firstName]').val();
		var strLastName = objTarget.find('[name=lastName]').val();
		//var strPhone = objTarget.find('[name=phone]').val();
		var strEmail1 = objTarget.find('[name=pwdEmail1]').val();
		var strEmail2 = objTarget.find('[name=pwdEmail2]').val();

		if(!strFirstName) {
			alert(objLanguage['MS00052']); // 이름을 입력하세요.
			objTarget.find('[name=firstName]').focus();
			return;
		}
		if(!strLastName) {
			alert(objLanguage['MS00053']); // 성을 입력하세요.
			objTarget.find('[name=lastName]').focus();
			return;
		}

		//if(!strPhone) {
		//	alert(objLanguage['MS00054']); // 연락처를 입력하세요.
		//	objTarget.find('[name=phone]').focus();
		//	return;
		//}

		var data			= new Object();
		data['menuType']	= "member";
		data['mode']		= "json";
		data['act']			= "findGlobalId";
		data['firstName']	= strFirstName;
		data['lastName']	= strLastName;
		//data['phone']		= strPhone;
		data['email1']		= strEmail1;
		data['email2']		= strEmail2;

		$.ajax({
			url			: "./"
		   ,data		: data
		   ,type		: "POST"
		   ,dataType	: "json"
		   ,success		: function(data){
				if(data['__STATE__'] == "SUCCESS") {

					var strMsg = data['__MSG__'];
					alert(strMsg);

				} else {
					var strMsg = data['__MSG__'];
					if(!strMsg) { strMsg = data; }
					alert(strMsg);
				}										
			}	
		});

	}

	// 한국어 비밀번호 찾기
	function goMemberFindIdPwdKoreaPwdFindEvent() {

		// 기본 설정
		var objTarget = $('#koreaPwd');
		var objLanguage = objScriptData['LANGUAGE'];
		var strFirstName = objTarget.find('[name=pwdFirstName]').val();
		var strEmail1 = objTarget.find('[name=pwdEmail1]').val();
		var strEmail2 = objTarget.find('[name=pwdEmail2]').val();

		if(!strFirstName) {
			alert(objLanguage['MS00052']); // 이름을 입력하세요.
			objTarget.find('[name=pwdFirstName]').focus();
			return;
		}

		if(!strEmail1) {
			alert(objLanguage['MS00055']); // 이메일을 입력하세요.
			objTarget.find('[name=pwdEmail1]').focus();
			return;
		}
		
		if(!strEmail2) {
			alert(objLanguage['MS00055']); // 이메일을 입력하세요.
			objTarget.find('[name=pwdEmail2]').focus();
			return;
		}

		// 로딩 시작
		objTarget.find('.loginBtn').hide();
		objTarget.find('.loading').show();

		var data			= new Object();
		data['menuType']	= "member";
		data['mode']		= "json";
		data['act']			= "findKoreaPwd";
		data['firstName']	= strFirstName;
		data['email1']		= strEmail1;
		data['email2']		= strEmail2;

		$.ajax({
			url			: "./"
		   ,data		: data
		   ,type		: "POST"
		   ,dataType	: "json"
		   ,success		: function(data){
				if(data['__STATE__'] == "SUCCESS") {

					var strMsg = data['__MSG__'];
					alert(strMsg);

				} else {
					var strMsg = data['__MSG__'];
					if(!strMsg) { strMsg = data; }
					alert(strMsg);
				}										
			}
		   ,complete	: function() {

				// 로딩 종료
				objTarget.find('.loginBtn').show();
				objTarget.find('.loading').hide();
		   }
		});
	}

	// 다국어 비밀번호 찾기
	function goMemberFindIdPwdGlobalPwdFindEvent() {

		var objTarget = $('#globalPwd');
		var objLanguage = objScriptData['LANGUAGE'];
		var strFirstName = objTarget.find('[name=pwdFirstName]').val();
		var strLastName = objTarget.find('[name=pwdLastName]').val();
		var strEmail1 = objTarget.find('[name=pwdEmail1]').val();
		var strEmail2 = objTarget.find('[name=pwdEmail2]').val();

		if(!strFirstName) {
			alert(objLanguage['MS00052']); // 이름을 입력하세요.
			objTarget.find('[name=pwdFirstName]').focus();
			return;
		}

		if(!strLastName) {
			alert(objLanguage['MS00053']); // 성을 입력하세요.
			objTarget.find('[name=pwdLastName]').focus();
			return;
		}

		if(!strEmail1) {
			alert(objLanguage['MS00055']); // 이메일을 입력하세요.
			objTarget.find('[name=pwdEmail1]').focus();
			return;
		}
		
		if(!strEmail2) {
			alert(objLanguage['MS00055']); // 이메일을 입력하세요.
			objTarget.find('[name=pwdEmail2]').focus();
			return;
		}

		// 로딩 시작
		objTarget.find('.loginBtn').hide();
		objTarget.find('.loading').show();

		var data			= new Object();
		data['menuType']	= "member";
		data['mode']		= "json";
		data['act']			= "findGlobalPwd";
		data['firstName']	= strFirstName;
		data['lastName']	= strLastName;
		data['email1']		= strEmail1;
		data['email2']		= strEmail2;

		$.ajax({
			url			: "./"
		   ,data		: data
		   ,type		: "POST"
		   ,dataType	: "json"
		   ,success		: function(data){
				if(data['__STATE__'] == "SUCCESS") {

					var strMsg = data['__MSG__'];
					alert(strMsg);

				} else {
					var strMsg = data['__MSG__'];
					if(!strMsg) { strMsg = data; }
					alert(strMsg);
				}										
			}
		   ,complete	: function() {

				// 로딩 종료
				objTarget.find('.loginBtn').show();
				objTarget.find('.loading').hide();
		   }	
		});
	}