	/**
	 *
	 * communityCommentList - defaultSkin - script 파일
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev YoungMi Park, HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2014, Eumshop, Inc.
	 * @license		http://www.eumshop.co.kr/user_guide/license.html
	 * @link		http://www.eumshop.co.kr
	 * @since		Version 1.0
	 * @filesource	/common/js/app/communityCommentList/communityCommentList.defaultSkin.js
	 * @manual		
	 * @history
	 *				2014.06.13 Kim Hee-Sung - 개발 완료
	 */


	// 페이지 첫 시작시 실행
	function goCommunityCommentListDefaultSkinReadyMoveEvent(strAppID) {
		
		// 언어 설정
		var objLanguage	= G_APP_PARAM[strAppID]['LANGUAGE'];

		// 전체 개수
		var intTotal = G_APP_PARAM[strAppID]['TOTAL'];
		$('[appID=' + strAppID + '].list-total').html(intTotal);

		// 상품 시작 번호
		var intNoFirst = G_APP_PARAM[strAppID]['NO_FIRST'];
		$('[appID=' + strAppID + '].list-no-first').html(intNoFirst);

		// 상품 마지막 번호
		var intNoLast = G_APP_PARAM[strAppID]['NO_LAST'];
		$('[appID=' + strAppID + '].list-no-last').html(intNoLast);

		// 페이지 만들기
		var intPage = G_APP_PARAM[strAppID]['PAGE'];
		var intPrevBlock = G_APP_PARAM[strAppID]['PREV_BLOCK'];
		var intNextBlock = G_APP_PARAM[strAppID]['NEXT_BLOCK'];
		var intFirstBlock = G_APP_PARAM[strAppID]['FIRST_BLOCK'];
		var intLastBlock = G_APP_PARAM[strAppID]['LAST_BLOCK'];
		var strHtml = '';

		strHtml = '<a href="javascript:goCommunityCommentListDefaultSkinListMoveEvent(\'' + strAppID + '\', \'' + intPrevBlock + '\')" class="btn_board_prev"><span>' + objLanguage['MW00052'] + '</span></a>';
		for(var i=intFirstBlock;i<=intLastBlock;i++) {
			var strClassSelect = 'pageCnt';
			if(i == intPage) { strClassSelect = 'chkPage'; }
			strHtml = strHtml + '<a href="javascript:goCommunityCommentListDefaultSkinListMoveEvent(\'' + strAppID + '\', \'' + i + '\')" class="' + strClassSelect + '"><strong><span>' + i + '</span></strong></a>';
		}
		strHtml = strHtml + '<a href="javascript:goCommunityCommentListDefaultSkinListMoveEvent(\'' + strAppID + '\', \'' + intNextBlock + '\')" class="btn_board_next"><span>' + objLanguage['MW00043'] + '</span></a>';
		$('[appID=' + strAppID + '].list-paginate').html(strHtml);


		// 정렬
		var strSORT = G_APP_PARAM[strAppID]['SORT'];
		var strHtml = '';
		strHtml = '<select onChange="goCommentListDefaultSkinSortChangeMoveEvent(this)">' + 
						'<option value="TD">' + objLanguage['PW00033'] + '</option>' + 
						'<option value="BD">' + objLanguage['PW00030'] + '</option>' + 
						'<option value="SD">' + objLanguage['PW00031'] + '</option>' + 
						'<option value="RA">' + objLanguage['PW00034'] + '</option>' + 
						'<option value="RD">' + objLanguage['PW00035'] + '</option>' + 
				  '</select>';
		$('[appID=' + strAppID + '].list-sort').html(strHtml);
		if(strSORT) { $('[appID=' + strAppID + '].list-sort').find('select option[value=' + strSORT + ']').attr("selected", true); }

		// 출력개수
		var strPageLine = G_APP_PARAM[strAppID]['PAGE_LINE'];
		var objPageLineOption = G_APP_PARAM[strAppID]['PAGE_LINE_OPTION'];
		var strHtml = '';

		for(var i in objPageLineOption) {
			strHtml += '<option value="' + objPageLineOption[i] + '">' + objPageLineOption[i] + '</option>';
		}
		strHtml = '<select onChange="goCommentListDefaultSkinPageLineChangeMoveEvent(\'' + strAppID + '\', this)">' + 
						strHtml + 
				  '</select>';

		$('[appID=' + strAppID + '].list-pageline').html(strHtml);
		if(strPageLine) { $('[appID=' + strAppID + '].list-pageline').find('select option[value=' + strPageLine + ']').attr("selected", true); }

		// 댓글창 닫기 초기 설정
		var strDisplay = C_GetCookie('COMMUNITY_COMMENT_LIST_DISPLAY');
		if(strDisplay == 'none') {
			$('[appID=' + strAppID + '].list-paginate').hide();	
			$('[appID=' + strAppID + '].list-close').each(function() {
				var strToggleText1 = $(this).attr("toggleText");
				var strToggleText2 = $(this).text();

				// 텍스트 변경
				if(strToggleText1) {
					$(this).attr('toggleText', strToggleText2);
					$(this).text(strToggleText1);
				} 
			});
		}

		// 댓글창 닫기
		$('[appID=' + strAppID + '].list-close').click(function() {

			$('#' + strAppID).find('.comtListForm').slideToggle('slow', function() {
				
				// 기본 설정
				var strDisplay = $(this).css('display');

				$('[appID=' + strAppID + '].list-close').each(function() {
					var strToggleText1 = $(this).attr("toggleText");
					var strToggleText2 = $(this).text();

					// 텍스트 변경
					if(strToggleText1) {
						$(this).attr('toggleText', strToggleText2);
						$(this).text(strToggleText1);
					} 
				});
				
				 // 세션 저장
				C_SetCookie('COMMUNITY_COMMENT_LIST_DISPLAY', strDisplay);

			});
			$('[appID=' + strAppID + '].list-paginate').toggle();
		});

		// 새로고침
		$('[appID=' + strAppID + '].list-refresh').click(function() {

			// 기본 설정
			var intPage = G_APP_PARAM[strAppID]['PAGE'];

			// 내가 작성한 리스트 페이지 불러오기
			goCommunityCommentListDefaultSkinListMoveEvent(strAppID, intPage);

		});

		// 댓글쓰기폼으로 이동
		$('[appID=' + strAppID + '].comment-write-link').click(function() {
			$('[appID=' + strAppID + '].comment-write-form').find('[name=commentText]').focus();
		});

		// 댓글쓰기폼 그리기
		var strHtml = "";
		var intMemberNo = G_APP_PARAM[strAppID]['MEMBER_NO'];
		var strWriteAuth = G_APP_PARAM[strAppID]['WRITE_AUTH'];
		var strReadonly = "";
		var strCommentText = "";
		var strEvent = "";
		if(!intMemberNo) { 
			strReadonly = " readonly";
			strCommentText = objLanguage['MS00112']; // 로그인이 필요합니다.
			strEvent = ' onclick="goCommunitListDefaultSkinLoginMoveEvent();"';
		} else if(!strWriteAuth) {
			strReadonly = " readonly";
			strCommentText = objLanguage['MS00130']; // 사용 권한이 없습니다.
		}
		strHtml		=	'<textarea name="commentText" class="comtWriteForm"' + strReadonly + strEvent + '>' + strCommentText + '</textarea>' + 
						'<a href="javascript:goCommunityCommentListDefaultSkinWriteActEvent(\'' + strAppID + '\')" class="comtWriteOk">' + objLanguage['MW00112'] + '</a>' + 
						'<div class="clr"></div>';
		$('[appID=' + strAppID + '].comment-write-form').html(strHtml);
	}

	// 출력개수 변경
	function goCommentListDefaultSkinPageLineChangeMoveEvent(strAppID, myThis) {

		// 기본 설정
		var strPageLine = $(myThis).val();
		
		// 출력개수 변경
		G_APP_PARAM[strAppID]['PAGE_LINE'] = strPageLine;

		// 리스트 불러오기
		goCommunityCommentListDefaultSkinListMoveEvent(strAppID, 1);

		// 2개 이상의 selectbox 인경우 사용함.
		 $('[appID=' + strAppID + '].list-pageline').find('select option[value=' + strPageLine + ']').attr("selected", true);

		 // 세션 저장
		 C_SetCookie('COMMUNITY_COMMENT_LIST_PAGE_LINE', strPageLine);
	}


	// 댓글 리스트 
	function goCommunityCommentListDefaultSkinListMoveEvent(strAppID, intPage) {

		// 기본 설정
		var objTarget			= $('#' + strAppID);
		var strSkin				= G_APP_PARAM[strAppID]['SKIN'];
		var intPageLine			= G_APP_PARAM[strAppID]['PAGE_LINE'];
		var strOrderBy			= G_APP_PARAM[strAppID]['ORDER_BY'];
		var isLock				= G_APP_PARAM[strAppID]['LOCK'];
		var strBCode			= G_APP_PARAM[strAppID]['B_CODE'];
		var intUbNo				= G_APP_PARAM[strAppID]['UB_NO'];

		// 잠겨있을때 종료
		if(isLock)	{ return; }
		else		{ G_APP_PARAM[strAppID]['LOCK'] = true; }

		// 이전 리스트 삭제
		objTarget.find('.comtListForm').html('');

		// 로딩 보이기
		objTarget.find(".loading").show();

		// 유효성 체크
		if(!intPage) { intPage = 1; }

		// 데이터 전달
		var data			= new Object();
		data['menuType']	= "community_v2.0";
		data['mode']		= "json";
		data['act']			= "commentList";
		data['page']		= intPage;
		data['pageLine']	= intPageLine;
		data['b_code']		= strBCode;
		data['ub_no']		= intUbNo;
		data['orderBy']		= strOrderBy;

		$.ajax({
			url			: "./"
		   ,data		: data
		   ,type		: "POST"
		   ,dataType	: "json"
		   ,success		: function(data) {	
				
				if(data['__STATE__'] == "SUCCESS") {

					 //페이지 그리기
					 goCommunityCommentListDefaultSkinListDraw(strAppID, data);
					 goCommunityCommentListDefaultSkinPagingDraw(strAppID, data);

				} else {
					var strMsg		= data['__MSG__'];
					if(!strMsg) { strMsg = data; }
					console.log(strMsg);
				}

		    }
			,complete:function(xhr, status) {
				
				// 잠김 풀기
				G_APP_PARAM[strAppID]['LOCK']	= false;

				// 로딩 숨기기
				objTarget.find(".loading").hide();
			}
		});


	}

	// 댓글 리스트 그리기
	function goCommunityCommentListDefaultSkinListDraw(strAppID, data) {
		
		// 언어 설정
		var objLanguage		= G_APP_PARAM[strAppID]['LANGUAGE'];

		// 기본 설정
		var objTarget		= $("#" + strAppID).find('.comtListForm');
		var aryData			= data['__DATA__'];	
		var aryPage			= data['__PAGE__'];	
		var intPage			= Number(aryPage['page']);
		var strBCode		= G_APP_PARAM[strAppID]['B_CODE'];
		
		// 페이지 설정
		G_APP_PARAM[strAppID]['PAGE']	= intPage;

		for(var key in aryData) {
			var intCM_NO					= aryData[key]['CM_NO'];
			var strCM_NAME					= aryData[key]['CM_NAME'];
			var strCM_TEXT					= aryData[key]['CM_TEXT'];
			var intCM_ANS_DEPTH				= aryData[key]['CM_ANS_DEPTH'];
			var strCM_REG_DT				= aryData[key]['CM_REG_DT'];
			var strCM_DEL					= aryData[key]['CM_DEL'];
			var strREPLY_CLASS				= aryData[key]['REPLY_CLASS'];
			var strM_PHOTO					= aryData[key]['M_PHOTO'];
			var strMODIFY_BTN_SHOW			= aryData[key]['MODIFY_BTN_SHOW'];
			var strDELETE_BTN_SHOW			= aryData[key]['DELETE_BTN_SHOW'];
			var strWRITE_BTN_SHOW			= aryData[key]['WRITE_BTN_SHOW'];
			var strWRITE_AUTH				= aryData[key]['WRITE_AUTH'];

			var strHtml						= '';
			var strBtnRightWrapHtml			= '';
			var strBtnComtWriteHtml			= '';
			var strBtnComtModifyHtml		= '';
			var strBtnComtDeleteHtml		= '';
			
			if(intCM_ANS_DEPTH == 1 && strWRITE_BTN_SHOW) {
				strBtnRightWrapHtml			=	'<!-- div class="btnRightWrap">\n' + 
													'<a href="#" class="btnLike">추천 <span>0</span></a>\n' + 
													'<a href="#" class="btnBad">반대 <span>0</span></a>\n' + 
												'</div //-->\n';
				strBtnComtWriteHtml			=	'<a href="javascript:goCommunityCommentListDefaultSkinReplyWriteMoveEvent(\'' + strAppID + '\', \'' + intCM_NO + '\')" class="btnComtWrite">' + objLanguage['MW00114'] + '</a>\n'; // 댓글
			}

			// 수정버튼
			if(strMODIFY_BTN_SHOW) {
				strBtnComtModifyHtml		=	'<a href="javascript:goCommunityCommentListDefaultSkinModifyMoveEvent(\'' + strAppID + '\', \'' + intCM_NO + '\')" class="btnModify">' + objLanguage['OW00072'] + '</a>\n'; // 수정
			}

			// 삭제버튼
			if(strDELETE_BTN_SHOW) {
				strBtnComtDeleteHtml		=	'<a href="javascript:goCommunityCommentListDefaultSkinDeleteActEvent(\'' + strAppID + '\', \'' + intCM_NO + '\')" class="btnDelete">' + objLanguage['CW00036'] + '</a>\n'; // 삭제
			}
			
			if(strCM_DEL == "Y") {
				strHtml						=	'<div idx="' + intCM_NO + '">\n' + 
													'<!-- 댓글 삭제 -->\n' + 
													'<div class="comtViewWrap' + strREPLY_CLASS + '">\n' + 
														'<p>' + objLanguage['MS00112'] + '</p>\n' + // 삭제된 글입니다.
													'</div><!--// comtViewWrap-->\n' + 
													'<!-- 댓글 삭제 -->\n' +
												'</div>\n';
			} else {

				strHtml						=	'<div idx="' + intCM_NO + '">\n' + 
													'<!-- 댓글 보기 -->\n' + 
													'<div class="comtViewWrap' + strREPLY_CLASS + '">\n' + 
														'<div class="imgBox"><img src="' + strM_PHOTO + '" alt="프로필 사진" class="userImg"/></div>\n' + 
														'<div class="comtBox">\n' + 
															'<div class="info"><span class="userId">' + strCM_NAME + '</span> <span class="date">' + strCM_REG_DT + '</span></div>\n' + 
															'<div class="comt">' + strCM_TEXT + '</div>\n' + 
															'<div class="btnWrap">\n' + 
																'<div class="btnLeftWrap">\n' + 
																	strBtnComtWriteHtml + 
																	strBtnComtModifyHtml + 
																	strBtnComtDeleteHtml + 
																'</div>\n' + 
																strBtnRightWrapHtml + 
																'<div class="clr"></div>\n' + 
															'</div>\n' + 
															'<div class="clr"></div>\n' + 
														'</div>\n' + 
														'<div class="clr"></div>\n' + 
													'</div><!--// comtViewWrap-->\n' + 
													'<!-- 댓글 보기 -->\n' +
												'</div>\n';

			}

			objTarget.append(strHtml);
		}
	
	}

	// 페이징 그리기
	function goCommunityCommentListDefaultSkinPagingDraw(strAppID, data) {

		// 언어 설정
		var objLanguage	= G_APP_PARAM[strAppID]['LANGUAGE'];

		// 페이지 만들기
		var aryPage	 = data['__PAGE__'];	
		var intPage = Number(aryPage['page']);
		var intPrevBlock = aryPage['prevBlock'];
		var intNextBlock = aryPage['nextBlock'];
		var intFirstBlock = aryPage['firstBlock'];
		var intLastBlock = aryPage['lastBlock'];
		var strHtml = '';

		strHtml = '<a href="javascript:goCommunityCommentListDefaultSkinListMoveEvent(\'' + strAppID + '\', \'' + intPrevBlock + '\')" class="btn_board_prev"><span>' + objLanguage['MW00052'] + '</span></a>';
		for(var i=intFirstBlock;i<=intLastBlock;i++) {
			var strClassSelect = 'pageCnt';
			if(i == intPage) { strClassSelect = 'chkPage'; }
			strHtml = strHtml + '<a href="javascript:goCommunityCommentListDefaultSkinListMoveEvent(\'' + strAppID + '\', \'' + i + '\')" class="' + strClassSelect + '"><strong><span>' + i + '</span></strong></a>';
		}
		strHtml = strHtml + '<a href="javascript:goCommunityCommentListDefaultSkinListMoveEvent(\'' + strAppID + '\', \'' + intNextBlock + '\')" class="btn_board_next"><span>' + objLanguage['MW00043'] + '</span></a>';
		$('[appID=' + strAppID + '].list-paginate').html(strHtml);

		// 상품 시작 번호
		var intNoFirst = aryPage['firstNo'];
		$('[appID=' + strAppID + '].list-no-first').html(intNoFirst);

		// 상품 마지막 번호
		var intNoLast = aryPage['lastNo'];
		$('[appID=' + strAppID + '].list-no-last').html(intNoLast);
	}

	// 댓글 작성
	function goCommunityCommentListDefaultSkinWriteActEvent(strAppID) {

		// 언어 설정
		var objLanguage		= G_APP_PARAM[strAppID]['LANGUAGE'];

		// 기본 설정
		var objTarget = $('#' + strAppID);
		var objTargetCommentText = $('[appID=' + strAppID + '].comment-write-form');
		var strCommentText = objTargetCommentText.find('[name=commentText]').val();
		var intPageLine = G_APP_PARAM[strAppID]['PAGE_LINE'];
		var strBCode = G_APP_PARAM[strAppID]['B_CODE'];
		var intUbNo = G_APP_PARAM[strAppID]['UB_NO'];
		var intMemberNo = G_APP_PARAM[strAppID]['MEMBER_NO'];
		var strWriteAuth = G_APP_PARAM[strAppID]['WRITE_AUTH'];
		
		// 체크
		if(!strCommentText) {
			alert(objLanguage['MS00132']); // 댓글을 입력하세요.
			objTargetCommentText.find('[name=commentText]').focus();
			return;
		}
		if(!strBCode) {
			alert(objLanguage['MS00133']); // 게시판 정보가 없습니다. 관리자에게 문의하세요.
			return;
		}
		if(!intUbNo) {
			alert(objLanguage['MS00133']); // 게시글 정보가 없습니다. 관리자에게 문의하세요.
			return;
		}
		if(!intMemberNo) {
			alert(objLanguage['MS00112']); // 로그인이 필요합니다.
			goCommunitListDefaultSkinLoginMoveEvent();
			return;
		}
		if(!strWriteAuth) {
			alert(objLanguage['MS00134']); // 권한이 없습니다.
			return;
		}

		var data			= new Object();
		data['menuType']	= "community_v2.0";
		data['mode']		= "json";
		data['act']			= "commentWrite";
		data['pageLine']	= intPageLine;
		data['b_code']		= strBCode;
		data['ub_no']		= intUbNo;
		data['commentText']	= strCommentText;

		$.ajax({
			url			: "./"
		   ,data		: data
		   ,type		: "POST"
		   ,dataType	: "json"
		   ,success		: function(data) {	
								if(data['__STATE__'] == 'SUCCESS') {
									
									// 기본 설정
									var intPage = data['__DATA__']['endPage'];

									// 내가 작성한 리스트 페이지 불러오기
									goCommunityCommentListDefaultSkinListMoveEvent(strAppID, intPage);

									// 글쓰기 폼 초기화
									objTargetCommentText.find('[name=commentText]').val('');

								} else if(data['__STATE__'] == 'NO_MEMBER') {
									
									// 체크
									var x = confirm(objLanguage['MS00132']); // 로그인 페이지로 이동하시겠습니까?
									if(!x) { return; }

									// 이동
									goCommunitListDefaultSkinLoginMoveEvent();

								} else {
									if(data['__MSG__']) { alert(data['__MSG__']); }
									else				{ alert(data); }
								}
						   }
		});

	}


	// 댓글 리플 작성
	function goCommunityCommentListDefaultSkinReplyWriteMoveEvent(strAppID, intCmNo) {
		
		// 언어 설정
		var objLanguage		= G_APP_PARAM[strAppID]['LANGUAGE'];

		// 기본 설정
		var objTarget = $('#' + strAppID).find('[idx=' + intCmNo + ']');
		var strHtml = "";

		// 폼 체크
		if(objTarget.find('.comtWriteWrap').length > 0) {
			objTarget.find('.comtWriteWrap').remove();
			objTarget.find('.btnComtWrite').text(objLanguage['MW00114']); // 댓글
			return;
		}

		// 그리기
		strHtml = '<div class="comtWriteWrap comtWriteBox">' + 	
						'<textarea name="commentReplyWriteText" class="comtWriteForm"></textarea>' + 
						'<a href="javascript:goCommunityCommentListDefaultSkinReplyWriteActEvent(\'' + strAppID + '\', \'' + intCmNo + '\')" class="comtWriteOk">' + objLanguage['MW00112'] + '</a>' + // 등록
						'<div class="clr"></div>' + 
				  '</div>';

		// 출력
		objTarget.append(strHtml);
		objTarget.find('.btnComtWrite').text(objLanguage['MW00044']); // 취소
		objTarget.find('[name=commentReplyWriteText]').focus();

	}

	// 댓글 리플 작성 액션
	function goCommunityCommentListDefaultSkinReplyWriteActEvent(strAppID, intCmNo) {

		// 언어 설정
		var objLanguage		= G_APP_PARAM[strAppID]['LANGUAGE'];

		// 기본 설정
		var objTarget = $('#' + strAppID).find('[idx=' + intCmNo + ']');
		var strCommentText = objTarget.find('[name=commentReplyWriteText]').val();
		var strBCode = G_APP_PARAM[strAppID]['B_CODE'];
		var intUbNo = G_APP_PARAM[strAppID]['UB_NO'];
		var intPage = G_APP_PARAM[strAppID]['PAGE'];

		// 체크
		if(!strCommentText) {
			alert(objLanguage['MS00132']); // 댓글을 입력하세요.
			objTarget.find('[name=commentReplyWriteText]').focus();
			return;
		}
		if(!strBCode) {
			alert(objLanguage['MS00133']); // 게시판 정보가 없습니다. 관리자에게 문의하세요.
			return;
		}
		if(!intUbNo) {
			alert(objLanguage['MS00133']); // 게시글 정보가 없습니다. 관리자에게 문의하세요.
			return;
		}

		var data			= new Object();
		data['menuType']	= "community_v2.0";
		data['mode']		= "json";
		data['act']			= "commentReplyWrite";
		data['b_code']		= strBCode;
		data['ub_no']		= intUbNo;
		data['cm_no']		= intCmNo;
		data['commentText']	= strCommentText;

		$.ajax({
			url			: "./"
		   ,data		: data
		   ,type		: "POST"
		   ,dataType	: "json"
		   ,success		: function(data) {	
								if(data['__STATE__'] == "SUCCESS") {
									
									// 리스트 그리기
									goCommunityCommentListDefaultSkinListMoveEvent(strAppID, intPage);

								} else {
									if(data['__MSG__']) { alert(data['__MSG__']); }
									else				{ alert(data); }
								}
						   }
		});
	}

	// 댓글 수정
	function goCommunityCommentListDefaultSkinModifyMoveEvent(strAppID, intCmNo) {

		// 언어 설정
		var objLanguage		= G_APP_PARAM[strAppID]['LANGUAGE'];

		// 기본 설정
		var strBCode = G_APP_PARAM[strAppID]['B_CODE'];

		// 체크
		if(!strBCode) {
			alert(objLanguage['MS00133']); // 게시글 정보가 없습니다. 관리자에게 문의하세요.
			return;
		}

		var data			= new Object();
		data['menuType']	= "community_v2.0";
		data['mode']		= "json";
		data['act']			= "commentReplyData";
		data['b_code']		= strBCode;
		data['cm_no']		= intCmNo;

		$.ajax({
			url			: "./"
		   ,data		: data
		   ,type		: "POST"
		   ,dataType	: "json"
		   ,success		: function(data) {	
			   console.log(data);
								if(data['__STATE__'] == "SUCCESS") {

									// 기본 설정
									var objTarget = $('#' + strAppID).find('[idx=' + intCmNo + ']');
									var strHtml = "";
									var strCM_TEXT = data['__DATA__']['CM_TEXT'];

									// 폼 체크
									if(objTarget.find('.comtModifyWrap').length > 0) {
										objTarget.find('.comtModifyWrap').remove();
										objTarget.find('.btnModify').text(objLanguage['OW00072']); // 수정
										return;
									}

									// 그리기
									strHtml = '<div class="comtModifyWrap comtModifyBox">' + 	
													'<textarea name="commentModifyText" class="comtModifyForm">' + strCM_TEXT + '</textarea>' + 
													'<a href="javascript:goCommunityCommentListDefaultSkinModifyActEvent(\'' + strAppID + '\', \'' + intCmNo + '\')" class="comtModifyOk">' + objLanguage['OW00072'] + '</a>' + // 수정
													'<div class="clr"></div>' + 
											  '</div>';

									// 출력
									objTarget.append(strHtml);
									objTarget.find('.btnModify').text(objLanguage['MW00044']); // 취소
									objTarget.find('[name=commentModifyText]').focus();
		
								} else {
									if(data['__MSG__']) { alert(data['__MSG__']); }
									else				{ alert(data); }
								}
						   }
		});
	}

	// 댓글 수정 액션
	function goCommunityCommentListDefaultSkinModifyActEvent(strAppID, intCmNo) {

		// 언어 설정
		var objLanguage		= G_APP_PARAM[strAppID]['LANGUAGE'];

		// 기본 설정
		var objTarget = $('#' + strAppID).find('[idx=' + intCmNo + ']');
		var strCommentText = objTarget.find('[name=commentModifyText]').val();
		var strBCode = G_APP_PARAM[strAppID]['B_CODE'];

		// 체크
		if(!strCommentText) {
			alert(objLanguage['MS00132']); // 댓글을 입력하세요.
			objTarget.find('[name=commentModifyText]').focus();
			return;
		}
		if(!strBCode) {
			alert(objLanguage['MS00133']); // 게시판 정보가 없습니다. 관리자에게 문의하세요.
			return;
		}

		var data			= new Object();
		data['menuType']	= "community_v2.0";
		data['mode']		= "json";
		data['act']			= "commentModify";
		data['b_code']		= strBCode;
		data['cm_no']		= intCmNo;
		data['commentText']	= strCommentText;

		$.ajax({
			url			: "./"
		   ,data		: data
		   ,type		: "POST"
		   ,dataType	: "json"
		   ,success		: function(data) {	
								if(data['__STATE__'] == "SUCCESS") {
									
									// 기본 설정
									var strCM_TEXT = data['__DATA__']['CM_TEXT'];

									// 내용 변경
									objTarget.find('.comt').text(strCM_TEXT);
									objTarget.find('.comtModifyWrap').remove();
									objTarget.find('.btnModify').text(objLanguage['OW00072']); // 수정
									
								} else {
									if(data['__MSG__']) { alert(data['__MSG__']); }
									else				{ alert(data); }
								}
						   }
		});

	}

	// 댓글 삭제 액션
	function goCommunityCommentListDefaultSkinDeleteActEvent(strAppID, intCmNo) {

		// 언어 설정
		var objLanguage		= G_APP_PARAM[strAppID]['LANGUAGE'];

		// 기본 설정
		var objTarget = $('#' + strAppID).find('[idx=' + intCmNo + ']');
		var strBCode = G_APP_PARAM[strAppID]['B_CODE'];

		// 체크
		var x = confirm(objLanguage['PS00018']); // 삭제하시겠습니까?
		if(!x) { return; }

		var data			= new Object();
		data['menuType']	= "community_v2.0";
		data['mode']		= "json";
		data['act']			= "commentDelete";
		data['b_code']		= strBCode;
		data['cm_no']		= intCmNo;

		$.ajax({
			url			: "./"
		   ,data		: data
		   ,type		: "POST"
		   ,dataType	: "json"
		   ,success		: function(data) {	
				if(data['__STATE__'] == "SUCCESS") {
					
					// 내용변경
					objTarget.find('.comtViewWrap').html('<p>' + objLanguage['MS00131'] + '</p>'); // 삭제된 글입니다.

				} else {
					if(data['__MSG__']) { alert(data['__MSG__']); }
					else				{ alert(data); }
				}
		   }
		});
		

	}

	// 로그인 페이지로 이동
	function goCommunitListDefaultSkinLoginMoveEvent() {

		location.href = './?menuType=member&mode=login';

	}