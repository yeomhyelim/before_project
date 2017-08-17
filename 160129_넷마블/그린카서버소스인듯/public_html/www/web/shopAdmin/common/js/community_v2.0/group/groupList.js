
	// 그룹 생성
	function goCommunityGroupListWriteActEvent() {
		
		// 기본 설정
		var strName		= $("input[name=bg_name]").val();
		var strLang		= $("input[name=lang]").val();

		// 체크
		if(!strName) {
			alert("그룹명을 입력하세요.");
			$("input[name=bg_name]").focus();
			return;
		}
		if(!strLang) {
			alert("선택된 언어가 없습니다. 관리자에게 문의하세요.");
			return;
		}

		// 설정
		$("[name=act]").val("groupWrite");

		// 전달
		$('#formData').ajaxForm({
			beforeSubmit :	function() {

			},
			success		 :  function(data) {
					data =  $.parseJSON(data);
					if(data['__STATE__'] == "SUCCESS") {
						location.reload();
					} else {
						alert(data);
					}
			   }
		}); 

		$('#formData').submit();
	}

	// 그룹 수정
	function goCommunityGroupListModifyActEvent() {

		// 기본 설정
		var strName		= $("input[name=bg_name]").val();
		var strLang		= $("input[name=lang]").val();

		// 체크
		if(!strName) {
			alert("그룹명을 입력하세요.");
			$("input[name=bg_name]").focus();
			return;
		}
		if(!strLang) {
			alert("선택된 언어가 없습니다. 관리자에게 문의하세요.");
			return;
		}

		// 설정
		$("[name=act]").val("groupModify");

		// 전달
		$('#formData').ajaxForm({
			beforeSubmit :	function() {
			},
			success		 :  function(data) {
					data =  $.parseJSON(data);
					if(data['__STATE__'] == "SUCCESS") {
						location.reload();
					} else {
						var strMsg = data['__MSG__'];
						if(!strMsg) { strMsg = data; }
						alert(strMsg);
					}
			   }
		}); 

		$('#formData').submit();

	}

	// 그룹 수정 정보 불러오기
	function goCommunityGroupListModifyMoveEvent(intBG_NO) {

		// 기본 설정
		var strLang		= $('input[name=lang]').val();

		// 체크
		if(!strLang) {
			alert('선택된 언어가 없습니다. 관리자에게 문의하세요.');
			return;
		}

		// 수정할 데이터 가져오기
		var data = new Object();
		data['menuType'] = 'community_v2.0';
		data['mode'] = 'json';
		data['act'] = 'groupData';
		data['lang'] = strLang;
		data['bg_no'] = intBG_NO;

		$.ajax({
			url			: './'
		   ,data		: data
		   ,type		: 'POST'
		   ,dataType	: 'json'
		   ,success		: function(data) {	
								if(data['__STATE__'] == 'SUCCESS') {

									// 기본 설정
									var objTarget = $('.tableFormWrap');
									var objRow = data['__DATA__'];
									var intBG_NO = objRow['BG_NO'];
									var strBG_NAME = objRow['BG_NAME'];
									var strBG_FILE1 = objRow['BG_FILE1'];
									var strBG_FILE2 = objRow['BG_FILE2'];
									var strBG_MENU_USE = objRow['BG_MENU_USE'];
									var intBG_SORT = objRow['BG_SORT'];

									// 수정 데이터 그리기
									objTarget.find('.groupTitle').text('커뮤니티 그룹 수정');
									objTarget.find('[name=bg_no]').val(intBG_NO);
									objTarget.find('[name=bg_name]').val(strBG_NAME);
									objTarget.find('[name=bg_sort]').val(intBG_SORT);
									objTarget.find('[name=bg_menu_use][value=' + strBG_MENU_USE + ']').attr('checked', true);
									
									if(strBG_FILE1) { objTarget.find('.bg_file1_del').show(); } else { objTarget.find('.bg_file1_del').hide(); }
									if(strBG_FILE2) { objTarget.find('.bg_file2_del').show(); } else { objTarget.find('.bg_file2_del').hide(); }

									// 버튼 처리
									objTarget.find('.btnWrite').hide();
									objTarget.find('.btnModify').show();
									objTarget.find('.btnCancel').show();
									objTarget.find('.btnFile').hide();


								} else {
									alert(data);
								}
						   }
		});
	}

	// 커뮤니티 그룹 삭제
	function goCommunityGroupListDeleteMoveEvent(intBG_NO) {

		// 기본 설정
		var strLang		= $('input[name=lang]').val();

		// 체크
		if(!strLang) {
			alert('선택된 언어가 없습니다. 관리자에게 문의하세요.');
			return;
		}

		// 다시한번 더 물어고기
		var x = confirm("삭제하시겠습니까?");
		if(!x) { return; }

		// 수정할 데이터 가져오기
		var data = new Object();
		data['menuType'] = 'community_v2.0';
		data['mode'] = 'json';
		data['act'] = 'groupDelete';
		data['bg_no'] = intBG_NO;
		data['lang'] = strLang;

		$.ajax({
			url			: './'
		   ,data		: data
		   ,type		: 'POST'
		   ,dataType	: 'json'
		   ,success		: function(data) {	
					if(data['__STATE__'] == 'SUCCESS') {
			
						location.reload();

					} else {
						alert(data);
					}
			   }
		});


	}

	// 커뮤니티 그룹 파일 생성
	function goCommunityGroupListFileActEvent() {

		// 기본 설정
		var strLang		= $('input[name=lang]').val();

		// 체크
		if(!strLang) {
			alert('선택된 언어가 없습니다. 관리자에게 문의하세요.');
			return;
		}

		// 다시한번 더 물어고기
		var x = confirm("그룹 리스트를 파일로 생성하시겠습니까?");
		if(!x) { return; }

		// 수정할 데이터 가져오기
		var data = new Object();
		data['menuType'] = 'community_v2.0';
		data['mode'] = 'json';
		data['act'] = 'groupFileMake';
		data['lang'] = strLang;

		$.ajax({
			url			: './'
		   ,data		: data
		   ,type		: 'POST'
		   ,dataType	: 'json'
		   ,success		: function(data) {	
					if(data['__STATE__'] == 'SUCCESS') {
			
						alert('생성되었습니다.');

					} else {
						alert(data);
					}
			   }
		});
	}

	// 커뉴니티 그룹 수정 취소
	function goCommunityGroupListCancelActEvent() {

		// 기본 설정
		var objTarget = $('.tableForm');

		// 수정 데이터 그리기
		objTarget.find('.groupTitle').text('커뮤니티 그룹 등록');
		objTarget.find('[name=bg_no]').val('');
		objTarget.find('[name=bg_name]').val('');
		objTarget.find('[name=bg_sort]').val('');
		objTarget.find('[name=bg_menu_use][value=Y]').attr('checked', true);

		objTarget.find('[name=bg_file1]').val('');
		objTarget.find('[name=bg_file2]').val('');
		objTarget.find('.bg_file1_del').hide();
		objTarget.find('.bg_file2_del').hide();

		// 버튼 처리
		objTarget.find('.btnWrite').show();
		objTarget.find('.btnModify').hide();
		objTarget.find('.btnCancel').hide();
		objTarget.find('.btnFile').show();

	}