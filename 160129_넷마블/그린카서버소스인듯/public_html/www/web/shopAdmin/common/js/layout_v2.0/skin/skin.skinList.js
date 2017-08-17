
	$(function() {

		goLayoutSkinListSkinViewMoveEvent();
		goLayoutSkinListSkinListMoveEvent();

	});

	// 선택된 스킨 정보 불러오기
	function goLayoutSkinListSkinViewMoveEvent() {
		
		// 기본설정
		var strSkinCodeSelect = objScriptData['SKIN_CODE_SELECT'];
		var strUrl = 'http://www.eumshop.co.kr/api/json/project.skin.json.php?act=skinView&smCode=' + strSkinCodeSelect + '&callback=?';
		// 체크
		if(!strSkinCodeSelect) { return; }

		// 호출
		$.getJSON(strUrl, function(data) {
				if(data['__STATE__'] == 'SUCCESS') {
					
					goLayoutSkinViewDraw(data);

				} else {
					var strMsg	= data['__MSG__'];
					if(!strMsg) { strMsg = data; }
					alert(strMsg);
				}
		});

	}

	// 선택스킨 그리기
	function goLayoutSkinViewDraw(data) {

		// 기본설정
		var aryData						= data['__DATA__'];	
		var objTarget					= $(".selectedSkinWrap");
		var key							= 0;
		var intSM_NO					= aryData[key]['SM_NO'];
		var strSM_CODE					= aryData[key]['SM_CODE'];
		var strSM_TITLE					= aryData[key]['SM_TITLE'];
		var intSM_CATE1					= aryData[key]['SM_CATE1'];
		var intSM_CATE2					= aryData[key]['SM_CATE2'];
		var intSM_CATE3					= aryData[key]['SM_CATE3'];
		var strSM_TEXT1					= aryData[key]['SM_TEXT1'];
		var strSM_PRICE1				= aryData[key]['SM_PRICE1'];
		var strSM_PRICE2				= aryData[key]['SM_PRICE2'];
		var strSM_DEVICE				= aryData[key]['SM_DEVICE'];
		var strSM_DEVICE_NAME			= aryData[key]['SM_DEVICE_NAME'];
		var strSM_STATE_NAME			= aryData[key]['SM_STATE_NAME'];
		var strSM_MOD_DT				= aryData[key]['SM_MOD_DT'];
		var strIMAGE_URL				= aryData[key]['IMAGE_URL'];
		var strHtml						= "";

		// 기존에 등록된 데이터 삭제
		objTarget.html('');

		strHtml							= 
												'<div class="selectedSkinList">' + 
												'<div class="thumbImg"><img src="' + strIMAGE_URL + '"></div>' + 
												'<div class="onTitle"><div class="noWrap"> 3</div><ul><li class="title">현재 적용 스킨</li>' +
												'<li>현재 적용된 스킨은 <strong>' + strSM_CODE + '</strong> 입니다.</li>' +
												'<li>운영중 쇼핑몰 이라면 스킨 변경은 시중하게 결정해서 변경하세요.</li></ul><div class="clr"></div></div>' +
												'<div class="clr"></div>' +
												'</div>';

		objTarget.append(strHtml);
	}


	// 리스트 불러오기
	function goLayoutSkinListSkinListMoveEvent(intPage) {
		
		// 체크 
		if(!intPage) { intPage = ''; }

		// 기본 설정
		var strUrl = 'http://www.eumshop.co.kr/api/json/project.skin.json.php?act=skinList&page=' + intPage + '&callback=?';
//		var strUrl = 'http://www.eumshop.co.kr/api/json/project.skin.json.php?act=skinList&page=' + intPage;

		// 호출
		$.getJSON(strUrl, function(data) {
				if(data['__STATE__'] == 'SUCCESS') {
					
					goLayoutSkinListDraw(data);
					goLayoutSkinListPagingDraw(data);

				} else {
					var strMsg	= data['__MSG__'];
					if(!strMsg) { strMsg = data; }
					alert(strMsg);
				}
		});

	}

	// 리스트 그리기
	function goLayoutSkinListDraw(data) {

		// 기본설정
		var aryData			= data['__DATA__'];	
		var aryPage			= data['__PAGE__'];	
		var intPage			= Number(aryPage['page']);
		var intPageNext		= intPage + 1;
		var objTarget		= $(".skinListWrap");

		// 기존에 등록된 데이터 삭제
		objTarget.html('');

		// 그리기
		if(aryPage['total'] && aryPage['listNum'] > 0) {
			for(var key in aryData) {

				// 기본설정
				var intSM_NO					= aryData[key]['SM_NO'];
				var strSM_CODE					= aryData[key]['SM_CODE'];
				var strSM_TITLE					= aryData[key]['SM_TITLE'];
				var intSM_CATE1					= aryData[key]['SM_CATE1'];
				var intSM_CATE2					= aryData[key]['SM_CATE2'];
				var intSM_CATE3					= aryData[key]['SM_CATE3'];
				var strSM_TEXT1					= aryData[key]['SM_TEXT1'];
				var strSM_PRICE1				= aryData[key]['SM_PRICE1'];
				var strSM_PRICE2				= aryData[key]['SM_PRICE2'];
				var strSM_DEVICE				= aryData[key]['SM_DEVICE'];
				var strSM_DEVICE_NAME			= aryData[key]['SM_DEVICE_NAME'];
				var strSM_STATE_NAME			= aryData[key]['SM_STATE_NAME'];
				var strSM_MOD_DT				= aryData[key]['SM_MOD_DT'];
				var strIMAGE_URL				= aryData[key]['IMAGE_URL'];
				var strSM_SOURCE_DIR			= aryData[key]['SM_SOURCE_DIR'];
				var strHtml						= "";

				strHtml							= '<div class="skinList">' + 
														'<div class="skinInfo">' + 
														'<p><input type="radio" name="smCode" value="' + strSM_CODE + '">' + strSM_TITLE + '</p>' + 
														'</div>' + 
														'<div class="thumbImg"><img src="' + strIMAGE_URL + '"></div>' + 														
														'</div>';

				objTarget.append(strHtml);

			}
		}

	}

	// 페이징 그리기
	function goLayoutSkinListPagingDraw(data) {

		var aryPage			= data['__PAGE__'];	
		var intPage			= Number(aryPage['page']);
		var intPageNext		= intPage + 1;
		var objTarget		= $(".paginate");

		var strHtml					= "";
		var strPageHtml				= '';
		var strClass				= '';
		var strPrevHtml				= '<a href="javascript:goLayoutSkinListSkinListMoveEvent(\'' + aryPage['prevBlock'] + '\')" class="btn_board_prev"><span>이전</span></a>\n';
		var strNextHtml				= '<a href="javascript:goLayoutSkinListSkinListMoveEvent(\'' + aryPage['nextBlock'] + '\')" class="btn_board_next"><span>다음</span></a>\n';

		objTarget.html("");

		for(var i = aryPage['firstBlock'];i <= aryPage['lastBlock']; i++) {
			strClass						= 'pageCnt';
			if(aryPage['page'] == i) { strClass		= 'chkPage'; }
			strPageHtml				= strPageHtml + '<a href="javascript:goLayoutSkinListSkinListMoveEvent(\'' + i + '\')"><strong><span class="' + strClass + '">' + i + '</span></strong></a>\n';
		}

		strHtml			= strPrevHtml + strPageHtml + strNextHtml;

		objTarget.append(strHtml);
	}

	// 스킨설정
	function goLayoutSkinListSkinModifyActEvent() {

		// 기본설정
		var strSmCode = $('[name=smCode]:checked').val();

		// 체크
		if(!strSmCode) {
			alert("스킨을 선택하세요.");
			return;
		}

		// 한번더 물어보기
		var x = confirm("정말로 변경하시겠습니까?");
		if(!x) { return; }

		// 스킨 변경하기
		var data = new Object();
		data['menuType'] = 'layout_v2.0';
		data['mode'] = 'json';
		data['act'] = 'skinModify';
		data['smCode'] = strSmCode;

		$.ajax({
			url			: './'
		   ,data		: data
		   ,type		: 'POST'
		   ,dataType	: 'json'
		   ,success		: function(data) {	
								if(data['__STATE__'] == 'SUCCESS') {
									alert("신규 스킨이 적용되었습니다.");
									location.reload();
								} else {
									var strMsg	= data['__MSG__'];
									if(!strMsg) { strMsg = data; }
									alert(strMsg);
								}
						   }
		});
		
	}

	// 스킨복구
	function goLayoutSkinListSkinRestoreActEvent() {

		// 기본설정
		var strSkinBak = $('[name=skinBak]').val();

		// 체크
		if(!strSkinBak) {
			alert("백업데이터를 선택하세요.");
			return;
		}

		// 한번더 물어보기
		var x = confirm("현재 적용된 데이터는 삭제됩니다. 정말로 복구하시겠습니까?");
		if(!x) { return; }

		// 스킨 변경하기
		var data = new Object();
		data['menuType'] = 'layout_v2.0';
		data['mode'] = 'json';
		data['act'] = 'skinRestore';
		data['skinBak'] = strSkinBak;

		$.ajax({
			url			: './'
		   ,data		: data
		   ,type		: 'POST'
		   ,dataType	: 'json'
		   ,success		: function(data) {	
								if(data['__STATE__'] == 'SUCCESS') {
//									$('[name=skinBak]').find('[value=' + strSkinBak + ']').remove();
									alert("복구가 완료되었습니다.");
									location.reload();
								} else {
									var strMsg	= data['__MSG__'];
									if(!strMsg) { strMsg = data; }
									alert(strMsg);
								}
						   }
		});

	}