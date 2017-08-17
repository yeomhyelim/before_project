
	$(function() {
		
		// SMS 설정(사용/사용안함)
		$("input[name=bi_sms_use]").change(function() {
			var objTarget = $(".smsInfo");
			var strSmsUse = $(this).val();
			if(strSmsUse == "Y") { objTarget.show(); }
			else { objTarget.hide(); }
		});

	});

	// sms 연락처 추가
	function goCommunityBoardWriteSmsInsert() {
		
		// 기본 설정
		var strSmsHp1 = $("input[id=sms_hp_1]").val();
		var strSmsHp2 = $("input[id=sms_hp_2]").val();
		var strSmsHp3 = $("input[id=sms_hp_3]").val();
		var strSmsHp  = strSmsHp1 + '-' + strSmsHp2 + '-' + strSmsHp3;
		if(!strSmsHp1) {
			alert("연락처를 입력하세요.");
			$("input[id=sms_hp_1]").focus();
			return;
		}
		if(!strSmsHp2) {
			alert("연락처를 입력하세요.");
			$("input[id=sms_hp_2]").focus();
			return;
		}
		if(!strSmsHp3) {
			alert("연락처를 입력하세요.");
			$("input[id=sms_hp_3]").focus();
			return;
		}
		
		// 중복 체크
		$("select[id=sms_hp_list] option").each(function() {
			var strSmsHpTemp = $(this).val();
			if(strSmsHp == strSmsHpTemp) { strSmsHp = ""; }
		});
		
		// 체크
		if(!strSmsHp) {
			alert("이미 등록된 연락처 입니다.");
			return;
		}
		if($("select[id=sms_hp_list] option").length >= 5) {
			alert("5개 이상 등록할 수 없습니다.");
			return;
		}
	
		// 추가
		$("select[id=sms_hp_list]").append('<option value="' + strSmsHp + '">' + strSmsHp + '</option>');

		// 기존 데이터 삭제
		$("input[id=sms_hp_1]").val('').focus();
		$("input[id=sms_hp_2]").val('');
		$("input[id=sms_hp_3]").val('');
	}

	// sms 연락처 삭제
	function goCommunityBoardWriteSmsDelete() {

		// 체크
		if($("select[id=sms_hp_list] option").length <= 0) {
			alert("삭제할 연락처가 없습니다.");
			return;
		}

		if($("select[id=sms_hp_list] option:selected").length <= 0) {
			alert("삭제할 연락처를 선택하세요.");
			return;
		}

		// 삭제
		$("select[id=sms_hp_list] option:selected").each(function() {
			$(this).remove();
		});

	}

	// 커뮤니티 수정 취소
	function goCommunityBoardModifyCancelMoveEvent() {
	
		// 기본 설정
		var data = new Object();
		data['mode'] = "boardList";

		// 이동
		C_getAddLocationUrl(data);
	}

	// 커뮤니티 수정
	function goCommunityBoardModifyActEvent() {
		
		// 연락처 설정
		var strSmsHpList = "";
		$("select[id=sms_hp_list] option").each(function() {
			var strSmsHpTemp = $(this).val();
			if(strSmsHpList) { strSmsHpList = strSmsHpList + ","; }
			strSmsHpList = strSmsHpList + strSmsHpTemp;
		});
		$("input[name=bi_sms_hp_list]").val(strSmsHpList);

		// 수정
		goAct("boardModifyBasic");
	}