
	// 시작 세팅
	$(function() {

		// SMS 설정(사용/사용안함)
		$("input[name=bi_sms_use]").change(function() {
			var objTarget = $(".smsInfo");
			var strSmsUse = $(this).val();
			if(strSmsUse == "Y") { objTarget.show(); }
			else { objTarget.hide(); }
		});

		// 게시판 종류에 따라서, 모록수 설정 스타일 변경
		$('input[name=b_kind_skin]').change(function() {
			var strVal = $(this).val();
			
			if(strVal == "data_gallery") {
				$(".listCntColumn").show();
				$(".listCntLine").show();
			} else {
				$(".listCntColumn").hide();
				$(".listCntLine").show();
			}
		});

		// 첨부파일 개수 변경
		$('select[name=bi_attachedfile_use]').change(function() {
			
			var intCnt = $(this).val();

			$("tr[id=attachedfile_name_field]").each(function(i) {
				if(i<intCnt) { $(this).css("display",""); }
				else{ $(this).css("display","none"); }
			});
			$("tr[id=attachedfile_key_field]").each(function(i) {
				if(i<intCnt) { $(this).css("display",""); }
				else{ $(this).css("display","none"); }
			});
		});


	});

	// 리스트 페이지로 이동
	function goCommunityBoardModifyBasicListMoveEvent() {

		var data = new Object();
		data['mode'] = 'boardList';
		data['b_code'] = '';
		C_getAddLocationUrl(data);

	}

	// 기본설정 수정
	function goCommunityBoardModifyBasicModifyActEvent() {

		// 기본설정
		var objTarget =$("#form");
		var strBName = objTarget.find('[name=b_name]').val();
		var strBCode = objTarget.find('[name=b_code]').val();

		// 체크
		if(!strBCode) {
			alert("게시판 코드가 없습니다.");
			return;
		}
		if(!strBName) {
			alert("게시판 이름은 필수 항목입니다.");
			$('[name=b_name]').focus();
			return;
		}

		// 연락처 설정
		var strSmsHpList = "";
		$("select[id=sms_hp_list] option").each(function() {
			var strSmsHpTemp = $(this).val();
			if(strSmsHpList) { strSmsHpList = strSmsHpList + ","; }
			strSmsHpList = strSmsHpList + strSmsHpTemp;
		});
		$("input[name=bi_sms_hp_list]").val(strSmsHpList);


		// 이동 경로 설정
		objTarget.find("input[name=mode]").val("json");
		objTarget.find("input[name=act]").val("boardModifyBasic");
		
		var data = objTarget.serializeArray();

		// 데이터 전달
		
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
									var strMsg = data['__MSG__'];
									if(!strMsg) { strMsg = data; }
									alert(data);
								}
						   }
		});

	}

	// sms 연락처 추가
	function goCommunityBoardModifyBasicSmsInsert() {
		
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
	function goCommunityBoardModifyBasicSmsDelete() {

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