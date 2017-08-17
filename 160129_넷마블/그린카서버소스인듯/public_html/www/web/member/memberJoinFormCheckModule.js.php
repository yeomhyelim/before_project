<script type="text/javascript">
<!--
	$(document).ready(function(){
		<?if ($S_SITE_LNG == "KR" && $phoneCheck == "Y"){?>
		var newYear = new Date(); 
		newYear = new Date(newYear.getFullYear() + 1, 1 - 1, 1); 
		$('#defaultCountdown').countdown({until: newYear}); 
		 
		$('#removeCountdown').toggle(function() { 
				$(this).text('Re-attach'); 
				$('#defaultCountdown').countdown('destroy'); 
			}, 
			function() { 
				$(this).text('Remove'); 
				$('#defaultCountdown').countdown({until: newYear}); 
			} 
		);
		<?}?>
	});

	function goMemberPhoneKeyRequestEvent()		{ goMemberPhoneKeyRequest();		} 
	function goMemberPhoneKeyCheckEvent()		{ goMemberPhoneKeyCheck();			} 
	function goMemberPhoneKeyCheckOkEvent()		{ goMemberPhoneKeyCheckOk();		}

	function goMemberPhoneKeyRequest() {

		var hp1 = $("select[name=hp1]").val();
		var hp2 = $("input[name=hp2]").val();
		var hp3 = $("input[name=hp3]").val();

		if(!hp1){
			alert("휴대폰 번호를 입력하세요.");
			$("select[name=hp1]").focus();
			return false;
		}
		if(!hp2){
			alert("휴대폰 번호를 입력하세요.");
			$("input[name=hp2]").focus();
			return false;
		}
		if(!hp3){
			alert("휴대폰 번호를 입력하세요.");
			$("input[name=hp3]").focus();
			return false;
		}

		var doc = document.form;
		doc.mode.value = "act";
		doc.act.value = "memberDelete";
		
		var hp = hp1 + "-" + hp2 + "-" + hp3;
		var url = "menuType=member&mode=act&act=memberPhoneKeyRequest&hp="+hp;

//		C_getAction("memberPhoneKeyRequest","<?=$PHP_SELF?>");
		C_AjaxPost("memberPhoneKeyRequest","./index.php", url,"post");
	}

	function goMemberPhoneKeyCheck() {
		var key = $("input[name=phoneKey]").val();
		if(!key){
			alert("인증키를 입력하세요.");
			$("input[name=phoneKey]").focus();
			return false;
		}
		var hp1 = $("select[name=hp1]").val();
		var hp2 = $("input[name=hp2]").val();
		var hp3 = $("input[name=hp3]").val();

		var mode		= "memberPhoneKeyCheck";
		var hp			= hp1 + "-" + hp2 + "-" + hp3;
		var phoneKey	= $("input[name=phoneKey]").val();
		
		var url = "menuType=member&mode=act&act=memberPhoneKeyCheck&phoneKey="+phoneKey+"&hp="+hp;
		
		C_AjaxPost("memberPhoneKeyCheck","./index.php", url,"post");
	}

	function goMemberPhoneKeyCheckOk() {
		opener.goMemberPhoneKeyCallBack(document.form);
		self.close();
	}

	function goMemberPhoneKeyCallBack(form) {
		var key = form.key.value;

		if(key){
			$("span[id=memberPhoneKey]").html("휴대폰인증완료");
			$("input[name=phoneKey]").val(key);
			$("select[name=hp1]").attr("readOnly",true);
			$("input[name=hp2]").attr("readOnly",true);
			$("input[name=hp3]").attr("readOnly",true);
		}
	}

/** 2013.05.22 소스 중복 **/ 
//	function goAjaxRet(name,result){
//		var data = eval(result);
//		if(name == "memberPhoneKeyRequest") {
//			if(data[0]['RET'] == "START"){
//				// 인증키 등록 대기 시작
//				$("input[name=phoneKey]").css({'display':''});
//				$("#memberPhoneKeyCheck").css({'display':''});
//				goStart();
//			}
//		}else if(name == "memberPhoneKeyCheck") {
//			if(data[0]['RET'] == "WRONG"){
//				alert("인증키가 일치하지않습니다.");
//			}else if(data[0]['RET'] == "CORRECT"){
//		//		$("span[id=memberPhoneKeyRequest]").html("휴대폰 인증 완료!!");
//				$("span[id=memberPhoneKeyRequest]").html("");
//				$("input[name=phoneKey]").css({'display':'none'});
//				$("#memberPhoneKeyCheck").remove();
//				$("#memberPhoneKeyCountDown").remove();
//				$("select[name=hp1]").attr("disabled",true);
//				$("input[name=hp2]").attr("disabled",true);
//				$("input[name=hp3]").attr("disabled",true);
//				alert("인증되었습니다.");
//			}
//		}else if(name == "memberPhoneKeyExpire") {
//			if(data[0]['RET'] == "EXPIRE") {
//				alert("인증키 만료되었습니다. 다시요청하시기 바랍니다.");
//			}
//		}
//	}

	function goStart() {
		var currentDate		= new Date();
		var value			= 3 * 60 * 1000 + currentDate.valueOf();
		$('#memberPhoneKeyCountDown').countdown(value, callback);
	}

	var m = "";
	var s = "";
	function callback(event) {
		switch(event.type) {
			case "seconds":
				s = event.value; 
			break;
			case "minutes":
				m = event.value;
			break;
			case "hours":
			case "days":
			case "weeks":
			case "daysLeft":
			break;
			case "finished":
				$("#memberPhoneKeyCountDown").html("");
				$("#memberPhoneKeyCheck").css({'display':'none'});
				$("input[name=phoneKey]").css({'display':'none'});

				var url = "menuType=member&mode=act&act=memberPhoneKeyExpire";
				C_AjaxPost("memberPhoneKeyExpire","./index.php", url,"post");
				return false;
			break;
		}
		$("#memberPhoneKeyCountDown").html(m + "분" + s + "초");
	}
//-->
</script>