

	// 커뮤니티 카테고리 옵션 수정
	function goCommunityBoardModifyCategoryInfoModifyActEvent() {

		// 기본설정
		var objTarget =$("#form");
		var strBCode = objTarget.find('[name=b_code]').val();

		// 체크
		if(!strBCode) {
			alert("게시판 코드가 없습니다.");
			return;
		}

		// 이동 경로 설정
		objTarget.find("input[name=mode]").val("json");
		objTarget.find("input[name=act]").val("boardModifyCategory");
		
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

	// 리스트 페이지로 이동
	function goCommunityBoardModifyCategoryListMoveEvent() {

		var data = new Object();
		data['mode'] = 'boardList';
		data['b_code'] = '';
		C_getAddLocationUrl(data);
		
	}

	// 커뮤니티 카테고리 등록
	function goCommunityBoardModifyCategoryWriteActEvent() {

		// 기본설정
		var objTarget =$("#formWrite");
		var strBCode = objTarget.find('[name=b_code]').val();
		var strBcName = objTarget.find('[name=bc_name]').val();

		// 체크
		if(!strBCode) {
			alert("게시판 코드가 없습니다.");
			return;
		}
		if(!strBcName) {
			alert("카테고리 이름을 입력하세요.");
			objTarget.find('[name=bc_name]').focus();
			return;
		}

		// 이동 경로 설정
		objTarget.find("input[name=mode]").val("json");
		objTarget.find("input[name=act]").val("categoryWrite");
	
		// 데이터 전달
		objTarget.ajaxForm({
			beforeSubmit :	function() {
			},
			success		 :  function(data) {
				data =  $.parseJSON(data);
				if(data['__STATE__'] == "SUCCESS") {
					
					alert("등록되었습니다.");
					location.reload();

				} else {
					var strMsg = data['__MSG__'];
					if(!strMsg) { strMsg = data; }
					alert(strMsg);
				}
		   }
		}); 

		objTarget.submit();

	}

	// 커뮤니티 카테고리 수정 페이지 이동
	function goCommunityBoardModifyCategoryModifyMoveEvent(strBCode, strLang, intBcNo) {

		// 기본설정	
		var data = new Object();
		data['menuType'] = 'community_v2.0';
		data['mode'] = 'json';
		data['act'] = 'categorySelect';
		data['b_code'] = strBCode;
		data['lang'] = strLang;
		data['bc_no'] = intBcNo;

		// 데이터 전달
		$.ajax({
			url			: "./"
		   ,data		: data
		   ,type		: "POST"
		   ,dataType	: "json"
		   ,success		: function(data) {	
								if(data['__STATE__'] == "SUCCESS") {
									
									// 그리기
									goCommunityBoardModifyCategoryModifyDrawEvent(data);
									
								} else {
									var strMsg = data['__MSG__'];
									if(!strMsg) { strMsg = data; }
									alert(data);
								}
						   }
		});
	}

	// 수정폼 그리기
	function goCommunityBoardModifyCategoryModifyDrawEvent(data) {

		// 기본설정
		var objTarget = $('#formWrite');
		var objData = data['__DATA__'];
		var strBCL_NAME = objData['BCL_NAME'];
		var intBC_NO = objData['BC_NO'];
		var intBC_SORT = objData['BC_SORT'];
		var strIMAGE_FILE1 = objData['IMAGE_FILE1'];
		var strIMAGE_FILE2 = objData['IMAGE_FILE2'];
		var strHtml1 = "";
		var strHtml2 = "";
		var strHtml3 = "";
		
		// 변경
		objTarget.find('h3').html('커뮤니티 카테고리 수정');
		objTarget.find('[name=bc_name]').val(strBCL_NAME);
		objTarget.find('[name=bc_sort]').val(intBC_SORT);
		objTarget.find('[name=bc_no]').val(intBC_NO);

		


		// 이미지1 그리기
		if(strIMAGE_FILE1) {
			
			strHtml1 = '<div id="imageFile1">' + 
							'<img src="' + strIMAGE_FILE1 + '" style="width:100px">' + 
							'<input type="checkbox" name="del_list[]" value="bc_image_1"> 삭제' + 
					   '</div>';
		}

		// 이미지2 그리기
		if(strIMAGE_FILE2) {
			
			strHtml2 = '<div id="imageFile2">' + 
							'<img src="' + strIMAGE_FILE2 + '" style="width:100px">' + 
							'<input type="checkbox" name="del_list[]" value="bc_image_2"> 삭제' + 
					   '</div>';
		}

		// 기존 내용 삭제
		objTarget.find('#imageFile1').remove();
		objTarget.find('#imageFile2').remove();

		// 추가
		objTarget.find('[name=bc_image_1]').after(strHtml1);
		objTarget.find('[name=bc_image_2]').after(strHtml2);

		// 버튼 그리기
		strHtml3 = '<a class="btn_big" href="javascript:void(0);" onclick="goCommunityBoardModifyCategoryModifyActEvent();" id="menu_auth_m" style=""><strong>카테고리 수정</strong></a>\n' + 
				   '<a class="btn_big" href="javascript:void(0);" onclick="goCommunityBoardModifyCategoryWriteDrawEvent();" id="menu_auth_m" style=""><strong>취소</strong></a>' ;

		// 버튼 변경
		objTarget.find('.button').html(strHtml3);

	}

	// 쓰기폼 그리기
	function goCommunityBoardModifyCategoryWriteDrawEvent() {

		// 기본설정
		var objTarget = $('#formWrite');
		objTarget.find('h3').html('커뮤니티 카테고리 등록');
		objTarget.find('[name=bc_name]').val('');
		objTarget.find('[name=bc_sort]').val('');
		objTarget.find('[name=bc_no]').val('');
		objTarget.find('#imageFile1').remove();
		objTarget.find('#imageFile2').remove();
		var strHtml3 = "";

		// 버튼 그리기
		strHtml3 = '<a class="btn_big" href="javascript:void(0);" onclick="goCommunityBoardModifyCategoryWriteActEvent();" id="menu_auth_m" style=""><strong>카테고리 등록</strong></a>' ;

		// 버튼 변경
		objTarget.find('.button').html(strHtml3);
	}

	// 커뮤니티 카테고리 수정
	function goCommunityBoardModifyCategoryModifyActEvent() {

		// 기본설정
		var objTarget =$("#formWrite");
		var strBCode = objTarget.find('[name=b_code]').val();
		var strBcName = objTarget.find('[name=bc_name]').val();
		var strBcNo = objTarget.find('[name=bc_no]').val();

		// 체크
		if(!strBCode) {
			alert("게시판 코드가 없습니다.");
			return;
		}
		if(!strBcNo) {
			alert("카테고리 번호가 없습니다.");
			return;
		}
		if(!strBcName) {
			alert("카테고리 이름을 입력하세요.");
			objTarget.find('[name=bc_name]').focus();
			return;
		}

		// 이동 경로 설정
		objTarget.find("input[name=mode]").val("json");
		objTarget.find("input[name=act]").val("categoryModify");
	
		// 데이터 전달
		objTarget.ajaxForm({
			beforeSubmit :	function() {
			},
			success		 :  function(data) {
				data =  $.parseJSON(data);
				if(data['__STATE__'] == "SUCCESS") {
					
//					alert("수정되었습니다.");
					location.reload();

				} else {
					var strMsg = data['__MSG__'];
					if(!strMsg) { strMsg = data; }
					alert(data);
				}
		   }
		}); 

		objTarget.submit();
		
	}

	// 커뮤니티 카테고리 삭제
	function goCommunityBoardModifyCategoryDeleteActEvent(strBCode, strLang, intBcNo) {
		
		// 한번더 물어보기
		var x = confirm("모든 언어에 등록된 내용이 삭제됩니다.\n정말로 삭제하시겠습니까?");
		if(!x) { return; }

		// 기본설정	
		var data = new Object();
		data['menuType'] = 'community_v2.0';
		data['mode'] = 'json';
		data['act'] = 'categoryDelete';
		data['b_code'] = strBCode;
		data['lang'] = strLang;
		data['bc_no'] = intBcNo;

		// 데이터 전달
		$.ajax({
			url			: "./"
		   ,data		: data
		   ,type		: "POST"
		   ,dataType	: "json"
		   ,success		: function(data) {	
								if(data['__STATE__'] == "SUCCESS") {
									
//									alert("삭제되었습니다.");
									location.reload();
									
								} else {
									var strMsg = data['__MSG__'];
									if(!strMsg) { strMsg = data; }
									alert(data);
								}
						   }
		});

	}