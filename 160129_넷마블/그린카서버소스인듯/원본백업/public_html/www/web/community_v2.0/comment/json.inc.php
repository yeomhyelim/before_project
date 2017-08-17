<?php

	switch($strAct):

	case "commentReplyData":
		// 댓글 정보 전달

		## 모듈 설정
		$objBoardComment				= new BoardCommentModule($db);

		## 기본 설정
		$strBCode						= $_POST['b_code'];
		$intCmNo						= $_POST['cm_no'];

		## 기본 설정 체크
		if(!$strBCode):
			$result['__STATE__']	= "NO_CODE";
			$result['__MSG__']		= $LNG_TRANS_CHAR["MS00138"]; // 커뮤니티 정보가 없습니다.
			break;
		endif;
		if(!$intCmNo):
			$result['__STATE__']	= "NO_CM_NO";
			$result['__MSG__']		= $LNG_TRANS_CHAR["MS00137"]; // 댓글 정보가 없습니다.
			break;
		endif;

		## 댓글 원글 정보 구하기
		$param							= "";
		$param['B_CODE']				= $strBCode;
		$param['CM_NO']					= $intCmNo;
		$aryCommentRow					= $objBoardComment->getBoardCommentSelectEx("OP_SELECT", $param);
		$strCM_TEXT						= $aryCommentRow['CM_TEXT'];

		## 체크
		if(!$aryCommentRow):
			$result['__STATE__']	= "NO_COMMENT_ROW";
			$result['__MSG__']		= $LNG_TRANS_CHAR["MS00140"]; // 댓글 정보가 없습니다.(원글)
			break;
		endif;

		## 전달 데이터 만들기
		$aryResultData['CM_TEXT']			= $strCM_TEXT;

		## 마무리
		$result['__STATE__']				= "SUCCESS";
		$result['__DATA__']					= $aryResultData;		

	break;
	
	case "commentReplyWrite":
		// 댓글 리플 등록

		## 모듈 설정
		$objMemberMgrModule				= new MemberMgrModule($db);
		$objBoardComment				= new BoardCommentModule($db);

		## 기본 설정
		$strBCode						= $_POST['b_code'];
		$intUbNo						= $_POST['ub_no'];
		$intCmNo						= $_POST['cm_no'];
		$strCommentName					= $_POST['commentName'];
		$strCommentEmail				= $_POST['commentEmail'];
		$strCommentPassword				= $_POST['commentPassword'];
		$strCommentText					= $_POST['commentText'];
		$strCommentRegDate				= "NOW()";
		$strCommentModDate				= "NOW()";	
		$strCommentFunc					= "NNNNNNNNNN";
		$strCommentIP					= ClientInfo::getClientIP();
		$intMemberNo					= $_SESSION['member_no'];
		$strMemberGroup					= $_SESSION['member_group'];
		
		## 기본 설정 체크
		if(!$strBCode):
			$result['__STATE__']	= "NO_CODE";
			$result['__MSG__']		= $LNG_TRANS_CHAR["MS00138"]; // 커뮤니티 정보가 없습니다.
			break;
		endif;
		if(!$intUbNo):
			$result['__STATE__']	= "NO_UB_NO";
			$result['__MSG__']		= $LNG_TRANS_CHAR["MS00138"]; // 게시글 정보가 없습니다.
			break;
		endif;
		if(!$intCmNo):
			$result['__STATE__']	= "NO_CM_NO";
			$result['__MSG__']		= $LNG_TRANS_CHAR["MS00137"]; // 댓글 정보가 없습니다.
			break;
		endif;
		if(!$strCommentText):
			$result['__STATE__']	= "NO_COMMENT_TEXT";
			$result['__MSG__']		= $LNG_TRANS_CHAR["MS00139"]; // 내용이 없습니다.
			break;
		endif;
		if(!$intMemberNo):
			$result['__STATE__']	= "NO_MEMBER";
			$result['__MSG__']		= $LNG_TRANS_CHAR["MS00112"]; // 로그인이 필요합니다.
			break;			
		endif;

		## 설정 파일 설정
		include_once MALL_SHOP . "/conf/community/board.{$strBCode}.info.php";
		$aryBoardInfo = $BOARD_INFO[$strBCode];
		$strBI_COMMENT_USE = $aryBoardInfo['bi_comment_use'];
		$aryBI_COMMENT_MEMBER_AUTH = $aryBoardInfo['bi_comment_member_auth'];

		## 댓글 쓰기 권한 설정
		if($strBI_COMMENT_USE != 'A' && !in_array($strMemberGroup, $aryBI_COMMENT_MEMBER_AUTH)): // BI_COMMENT_USE(A:모든회원), 권한이 있는 회원그룹
			$result['__STATE__']	= "NO_WRITE_AUTH";
			$result['__MSG__']		= "권한이 없습니다.";
			break;	
		endif;

		## 댓글 원글 정보 불러오기
		$param							= "";
		$param['B_CODE']				= $strBCode;
		$param['CM_NO']					= $intCmNo;
		$aryCommentRow					= $objBoardComment->getBoardCommentSelectEx("OP_SELECT", $param);
		$intCM_M_NO						= $aryCommentRow['CM_M_NO'];
		$intCM_ANS_DEPTH				= $aryCommentRow['CM_ANS_DEPTH'];

		## 체크
		if(!$aryCommentRow):
			$result['__STATE__']	= "NO_COMMENT_ROW";
			$result['__MSG__']		= $LNG_TRANS_CHAR["MS00140"]; // 댓글 정보가 없습니다.(원글)
			break;
		endif;
		$intCommentAnsDepth				= $intCM_ANS_DEPTH + 1;

		## 댓글 개수 구하기
		$param							= "";
		$param['B_CODE']				= $strBCode;
		$param['CM_UB_NO']				= $intUbNo;
		$param['CM_ANS_NO']				= $intCmNo;
		$intCommentAnsStep				= $objBoardComment->getBoardCommentSelectEx("OP_COUNT", $param);

		## 체크
		if(!$intCommentAnsStep && $intCommentAnsStep <= 0):
			$result['__STATE__']		= "NO_ANS_STEP";
			$result['__MSG__']			= $LNG_TRANS_CHAR["MS00141"]; // 리플을 등록할 수 없습니다. 관리자에게 문의하세요.
			break;
		endif;
		$intCommentAnsStep++;

		## 회원 정보 불러오기
		$param							= "";
		$param['M_NO']					= $intMemberNo;
		$aryMemberRow					= $objMemberMgrModule->getMemberMgrSelectEx("OP_SELECT", $param);
		$strM_NAME						= $aryMemberRow['M_NAME'];
		$strM_ID						= $aryMemberRow['M_ID'];
		$strM_MAIL						= $aryMemberRow['M_MAIL'];
//		$result							= print_r($aryMemberRow, true);
//		break;

		## 체크
		if(!$aryMemberRow):
			$result['__STATE__']	= "NO_MEMBER_INFO";
			$result['__MSG__']		= $LNG_TRANS_CHAR["MS00142"]; // 회원 정보를 찾을수 없습니다. 관리자에게 문의하세요.
			break;			
		endif;

		## 회원 정보가 있는 경우
		if($aryMemberRow):
			$strCommentName = $strM_NAME;
			$strCommentMemberID = $strM_ID;
			$strCommentEmail = $strM_MAIL;
		endif;

		## 데이터 등록
		$param							= "";
		$param['B_CODE']				= $strBCode;
//		$param['CM_NO']					= "";
		$param['CM_UB_NO']				= $intUbNo;
		$param['CM_NAME']				= $strCommentName;
		$param['CM_M_NO']				= $intMemberNo;
		$param['CM_M_ID']				= $strCommentMemberID;
//		$param['CM_PASS']				= $strCommentPassword;
		$param['CM_MAIL']				= $strCommentEmail;
		$param['CM_TITLE']				= $strCommentTitle;
		$param['CM_TEXT']				= $strCommentText;
		$param['CM_FUNC']				= $strCommentFunc;
		$param['CM_IP']					= $strCommentIP;
		$param['CM_READ']				= $intCommentRead;
		$param['CM_BC_NO']				= $intCommentBcNo;
//		$param['CM_ANS_NO']				= $intCmNo;
//		$param['CM_ANS_DEPTH']			= $intCommentAnsDepth;
//		$param['CM_ANS_STEP']			= $intCommentAnsStep;
//		$param['CM_ANS_M_NO']			= $intCommentAnsMemberNo;
		$param['CM_PT_NO']				= $intCommentEventPointNo;
		$param['CM_CI_NO']				= $intCommentEventCouponNo;
		$param['CM_WINNER']				= $strCommentEventWinner;
		$param['CM_REG_DT']				= $strCommentRegDate;
		$param['CM_REG_NO']				= $intMemberNo;
		$param['CM_MOD_DT']				= $strCommentModDate;
		$param['CM_MOD_NO']				= $intMemberNo;
		$intCommentNo					= $objBoardComment->getBoardCommentInsertEx($param);

		## 체크
		if(!$intCommentNo && $intCommentNo <= 0):
			$result['__STATE__']	= "NO_WRITE";
			$result['__MSG__']		= $LNG_TRANS_CHAR["MS00143"]; // 댓글을 등록할 수 없습니다. 관리자에게 문의하세요.
			break;
		endif;

		## 댓글 정보 업데이트
		$param							= "";
		$param['B_CODE']				= $strBCode;
		$param['CM_NO']					= $intCommentNo;
		$param['CM_ANS_NO']				= $intCmNo;
		$param['CM_ANS_DEPTH']			= $intCommentAnsDepth;
		$param['CM_ANS_STEP']			= $intCommentAnsStep;
		$param['CM_ANS_M_NO']			= $intCM_M_NO;
		$re								= $objBoardComment->getBoardCommentAnsUpdateEx($param);

		## 마무리
		$result['__STATE__']			= "SUCCESS";

	break;

	case "commentList":
		// 댓글 리스트

		## 모듈 설정.
		$objBoardComment				= new BoardCommentModule($db);

		## 기본설정
		$strBCode						= $_POST['b_code'];
		$intUbNo						= $_POST['ub_no'];
		$intPage						= $_POST['page'];
		$intPageLine					= $_POST['pageLine'];
		$strOrderBy						= $_POST['orderBy'];
		$strImageDir					= "/upload/member/";
		$intMemberNo					= $_SESSION['member_no'];
		$strMemberGroup					= $_SESSION['member_group'];

		## 기본 설정 체크
		if(!$strBCode):
			$result['__STATE__']	= "NO_CODE";
			$result['__MSG__']		= $LNG_TRANS_CHAR["MS00138"]; // 커뮤니티 정보가 없습니다.
			break;
		endif;
		if(!$intUbNo):
			$result['__STATE__']	= "NO_UB_NO";
			$result['__MSG__']		= $LNG_TRANS_CHAR["MS00138"]; // 커뮤니티 정보가 없습니다.
			break;
		endif;

		## 설정 파일 설정
		include_once MALL_SHOP . "/conf/community/board.{$strBCode}.info.php";
		$aryBoardInfo = $BOARD_INFO[$strBCode];
		$strBI_COMMENT_USE = $aryBoardInfo['bi_comment_use'];
		$aryBI_COMMENT_MEMBER_AUTH = $aryBoardInfo['bi_comment_member_auth'];

		## 댓글 쓰기 권한 설정
		$isWriteAuth = false;
		$isWriteBtnShow = false;
		if($strBI_COMMENT_USE == 'A' || in_array($strMemberGroup, $aryBI_COMMENT_MEMBER_AUTH)): // BI_COMMENT_USE(A:모든회원), 권한이 있는 회원그룹
			$isWriteAuth = true;
			$isWriteBtnShow = true;	
		endif;

		## 데이터 불러오기
		$param								= "";
		$param['B_CODE']					= $strBCode;
		$param['CM_UB_NO']					= $intUbNo;
		$intTotal							= $objBoardComment->getBoardCommentSelectEx("OP_COUNT", $param);			// 데이터 전체 개수 
		$intPageLine						= ( $intPageLine )		? $intPageLine	: 10;								// 리스트 개수 
		$intPage							= ( $intPage )			? $intPage		: 1;
		$intFirst							= ( $intTotal == 0 )	? 0				: $intPageLine * ( $intPage - 1 );
	
		$param['JOIN_M']					= "Y";
		$param['JOIN_MA']					= "Y";
		$param['ORDER_BY']					= $strOrderBy;
		$param['LIMIT']						= "{$intFirst},{$intPageLine}";
		$resDataResult						= $objBoardComment->getBoardCommentSelectEx("OP_LIST", $param);
		$intPageBlock						= 10;																		// 블럭 개수 
		$intListNum							= $intTotal - ( $intPageLine * ( $intPage - 1 ) );							// 번호
		$intTotPage							= ceil( $intTotal / $intPageLine );

		## paging 설정
		$intPage			= $intPage;									// 현재 페이지
		$intTotPage			= $intTotPage;								// 전체 페이지 수
		$intTotBlock		= ceil($intTotPage / $intPageBlock);		// 전체 블럭 수
		$intBlock			= ceil($intPage / $intPageBlock);			// 현재 블럭
		$intPrevBlock		= (($intBlock - 2) * $intPageBlock) + 1;	// 이전 블럭
		$intNextBlock		= ($intBlock * $intPageBlock) + 1;			// 다음 블럭
		$intFirstBlock		= (($intBlock - 1) * $intPageBlock) + 1;	// 현재 블럭 시작 시저
		$intLastBlock		= $intBlock * $intPageBlock;				// 현재 블럭 종료 시점
		if($intFirstBlock <= 0) { $intFirstBlock	= 1; }
		if($intPrevBlock  <= 0) { $intPrevBlock		= 1; }
		if($intNextBlock >= $intTotPage) { $intNextBlock	= $intTotPage; }
		if($intLastBlock >= $intTotPage) { $intLastBlock	= $intTotPage; }

		## 페이지 시작/마지막 번호 설정
		$intFirstNo			= ($intPage <= 1) ? $intPage : (($intPage - 1) * $intPageLine);
		$intLastNo			= $intPage * $intPageLine;
		if(!$intFirstNo) { $intFirstNo = ""; }
		if($intLastNo > $intTotal) { $intLastNo = $intTotal; }

		## 전달 데이터 만들기
		$aryResultData				= "";
		$i							= 0;
		if($intTotal):
			while($row = mysql_fetch_array($resDataResult)):

				## 기본설정
				$intCM_NO = $row['CM_NO'];
				$intCM_M_NO = $row['CM_M_NO'];
				$strCM_NAME = $row['CM_NAME'];
				$strCM_M_ID = $row['CM_M_ID'];
				$strCM_TEXT = $row['CM_TEXT'];
				$intCM_ANS_DEPTH = $row['CM_ANS_DEPTH'];
				$strCM_REG_DT = $row['CM_REG_DT'];
				$strCM_DEL = $row['CM_DEL'];
				$strM_PHOTO = $row['M_PHOTO'];
				
				## 작성자 설정
				$strName = $LNG_TRANS_CHAR["MW00113"]; // 방문객
				if($strName) { $strName = $strCM_NAME; }

				## 작성일 설정
				$strCM_REG_DT = date("Y-m-d H:i", strtotime($strCM_REG_DT));

				## 리플 설정
				$strReplyClass = "";
				if($intCM_ANS_DEPTH > 1) { $strReplyClass = " comtListWrap"; }

				## 사진 설정
				$strPhotoFile = "/himg/community/comment/img_user.jpg";
				if($strM_PHOTO) { $strPhotoFile = $strImageDir . $strM_PHOTO; }

				## 자신글만 수정,삭제 버튼이 보입니다.
				$isModifyBtnShow = false; // 수정 버튼
				$isDeleteBtnShow = false; // 삭제 버튼
				if($intMemberNo && $intCM_M_NO && $intMemberNo == $intCM_M_NO):
					$isModifyBtnShow = true;
					$isDeleteBtnShow = true;
				endif;

				## 내용 설정
				$strCM_TEXT = strConvertCut($strCM_TEXT);

				## 데이터 만들기					
				$aryResultData[$i]['CM_NO']				= $intCM_NO;
				$aryResultData[$i]['CM_NAME']			= $strName;
				$aryResultData[$i]['CM_M_ID']			= $strCM_M_ID;
				$aryResultData[$i]['CM_TEXT']			= $strCM_TEXT;
				$aryResultData[$i]['CM_ANS_DEPTH']		= $intCM_ANS_DEPTH;
				$aryResultData[$i]['CM_REG_DT']			= $strCM_REG_DT;
				$aryResultData[$i]['CM_DEL']			= $strCM_DEL;
				$aryResultData[$i]['REPLY_CLASS']		= $strReplyClass;
				$aryResultData[$i]['M_PHOTO']			= $strPhotoFile;
				$aryResultData[$i]['MODIFY_BTN_SHOW']	= $isModifyBtnShow;
				$aryResultData[$i]['DELETE_BTN_SHOW']	= $isDeleteBtnShow;
				$aryResultData[$i]['WRITE_BTN_SHOW']	= $isWriteBtnShow;
				$aryResultData[$i]['WRITE_AUTH']		= $isWriteAuth;
				$i++;
			endwhile;
		endif;

		## 전달 페이지 만들기
		$aryPage							= "";
		$aryPage['total']					= $intTotal;
		$aryPage['listNum']					= $intListNum;
		$aryPage['page']					= $intPage;
		$aryPage['prevBlock']				= $intPrevBlock;
		$aryPage['nextBlock']				= $intNextBlock;
		$aryPage['firstBlock']				= $intFirstBlock;
		$aryPage['lastBlock']				= $intLastBlock;
		$aryPage['firstNo']					= $intFirstNo;
		$aryPage['lastNo']					= $intLastNo;

		## 마무리
		$result['__STATE__']				= "SUCCESS";
		$result['__DATA__']					= $aryResultData;
		$result['__PAGE__']					= $aryPage;

	break;
	
	case "commentWrite":
		// 댓글 등록
		// 비회원은 지원하지 않습니다.
		// 개발이 필요한 경우, 추가하시기 바랍니다.
		
		## 모듈 설정
		$objBoardComment				= new BoardCommentModule($db);
		$objMemberMgrModule				= new MemberMgrModule($db);

		## 기본 설정
		$strBCode						= $_POST['b_code'];
		$intUbNo						= $_POST['ub_no'];
		$intPageLine					= $_POST['pageLine'];
		$strCommentName					= $_POST['commentName'];
		$strCommentEmail				= $_POST['commentEmail'];
		$strCommentPassword				= $_POST['commentPassword'];
		$strCommentText					= $_POST['commentText'];
		$strCommentRegDate				= "NOW()";
		$strCommentModDate				= "NOW()";
		$strCommentFunc					= "NNNNNNNNNN";
		$strCommentIP					= ClientInfo::getClientIP();
		$intMemberNo					= $_SESSION['member_no'];
		$strMemberGroup					= $_SESSION['member_group'];

		## 언어 설정
		$strLang						= $S_SITE_LNG;
		if(!$strLang) { $strLang = $S_ST_LNG; }
		$strLangLower					= strtolower($strLang);
		
		## 기본 설정 체크
		if(!$strBCode):
			$result['__STATE__']	= "NO_CODE";
			$result['__MSG__']		= $LNG_TRANS_CHAR["MS00138"]; // 커뮤니티 정보가 없습니다.
			break;
		endif;
		if(!$intUbNo):
			$result['__STATE__']	= "NO_UB_NO";
			$result['__MSG__']		= $LNG_TRANS_CHAR["MS00138"]; // 커뮤니티 정보가 없습니다.
			break;
		endif;
		if(!$strCommentText):
			$result['__STATE__']	= "NO_COMMENT_TEXT";
			$result['__MSG__']		= $LNG_TRANS_CHAR["MS00139"]; // 내용이 없습니다.
			break;
		endif;
		if(!$intMemberNo):
			$result['__STATE__']	= "NO_MEMBER";
			$result['__MSG__']		= $LNG_TRANS_CHAR["MS00112"]; // 로그인이 필요합니다.
			break;			
		endif;

		## 설정 파일 설정
		if($S_COMMUNITY_VERSION == "V2.0"):
			include_once MALL_SHOP . "/conf/community/{$strLangLower}/board.{$strBCode}.info.php";
			$aryBoardInfo = $BOARD_INFO[$strBCode];
			$strBI_COMMENT_USE = $aryBoardInfo['BI_COMMENT_USE'];
			$aryBI_COMMENT_MEMBER_AUTH = $aryBoardInfo['BI_COMMENT_MEMBER_AUTH'];
		else:
			include_once MALL_SHOP . "/conf/community/board.{$strBCode}.info.php";
			$aryBoardInfo = $BOARD_INFO[$strBCode];
			$strBI_COMMENT_USE = $aryBoardInfo['bi_comment_use'];
			$aryBI_COMMENT_MEMBER_AUTH = $aryBoardInfo['bi_comment_member_auth'];
		endif;

		## 댓글 쓰기 권한 설정
		if($strBI_COMMENT_USE != 'A' && !in_array($strMemberGroup, $aryBI_COMMENT_MEMBER_AUTH)): // BI_COMMENT_USE(A:모든회원), 권한이 있는 회원그룹
			$result['__STATE__']	= "NO_WRITE_AUTH";
			$result['__MSG__']		= $LNG_TRANS_CHAR["MS00134"]; // 권한이 없습니다.
			break;	
		endif;

		## 회원 정보 불러오기
		$param							= "";
		$param['M_NO']					= $intMemberNo;
		$aryMemberRow					= $objMemberMgrModule->getMemberMgrSelectEx("OP_SELECT", $param);
		$strM_NAME						= $aryMemberRow['M_NAME'];
		$strM_ID						= $aryMemberRow['M_ID'];
		$strM_MAIL						= $aryMemberRow['M_MAIL'];
//		$result							= print_r($aryMemberRow, true);
//		break;

		## 체크
		if(!$aryMemberRow):
			$result['__STATE__']	= "NO_MEMBER_INFO";
			$result['__MSG__']		= $LNG_TRANS_CHAR["MS00142"]; // 회원 정보를 찾을수 없습니다. 관리자에게 문의하세요.
			break;			
		endif;

		## 회원 정보가 있는 경우
		if($aryMemberRow):
			$strCommentName = $strM_NAME;
			$strCommentMemberID = $strM_ID;
			$strCommentEmail = $strM_MAIL;
		endif;

		## 데이터 등록
		$param							= "";
		$param['B_CODE']				= $strBCode;
//		$param['CM_NO']					= "";
		$param['CM_UB_NO']				= $intUbNo;
		$param['CM_NAME']				= $strCommentName;
		$param['CM_M_NO']				= $intMemberNo;
		$param['CM_M_ID']				= $strCommentMemberID;
//		$param['CM_PASS']				= $strCommentPassword;
		$param['CM_MAIL']				= $strCommentEmail;
		$param['CM_TITLE']				= $strCommentTitle;
		$param['CM_TEXT']				= $strCommentText;
		$param['CM_FUNC']				= $strCommentFunc;
		$param['CM_IP']					= $strCommentIP;
		$param['CM_READ']				= $intCommentRead;
		$param['CM_BC_NO']				= $intCommentBcNo;
//		$param['CM_ANS_NO']				= $intCommentAnsNo;
//		$param['CM_ANS_DEPTH']			= $intCommentAnsDepth;
//		$param['CM_ANS_STEP']			= $strCommentAnsStep;
//		$param['CM_ANS_M_NO']			= $intCommentAnsMemberNo;
		$param['CM_PT_NO']				= $intCommentEventPointNo;
		$param['CM_CI_NO']				= $intCommentEventCouponNo;
		$param['CM_WINNER']				= $strCommentEventWinner;
		$param['CM_REG_DT']				= $strCommentRegDate;
		$param['CM_REG_NO']				= $intMemberNo;
		$param['CM_MOD_DT']				= $strCommentModDate;
		$param['CM_MOD_NO']				= $intMemberNo;
		$intCommentNo					= $objBoardComment->getBoardCommentInsertEx($param);
//		$result = $db->query;
//		break;

		## 체크
		if(!$intCommentNo && $intCommentNo <= 0):
			$result['__STATE__']	= "NO_WRITE";
			$result['__MSG__']		= $LNG_TRANS_CHAR["MS00143"]; // 댓글을 등록할 수 없습니다. 관리자에게 문의하세요.
			break;
		endif;

		## 댓글 정보 업데이트
		$param							= "";
		$param['B_CODE']				= $strBCode;
		$param['CM_NO']					= $intCommentNo;
		$param['CM_ANS_NO']				= $intCommentNo;
		$param['CM_ANS_DEPTH']			= 1;
		$param['CM_ANS_STEP']			= 1;
		$param['CM_ANS_M_NO']			= $intCommentMemberNo;
		$re								= $objBoardComment->getBoardCommentAnsUpdateEx($param);

		## 마지막 페이지 구하기
		$param							= "";
		$param['B_CODE']				= $strBCode;
		$param['CM_UB_NO']				= $intUbNo;
		$intTotal						= $objBoardComment->getBoardCommentSelectEx("OP_COUNT", $param);			// 데이터 전체 개수 
		$intTotPage						= ceil( $intTotal / $intPageLine );

		## 전달 데이터 만들기
		$aryResultData['endPage']		= $intTotPage;

		## 마무리
		$result['__STATE__']			= "SUCCESS";
		$result['__DATA__']				= $aryResultData;	

	break;

	case "commentModify":
		// 댓글 수정

		## 모듈 설정
		$objBoardComment				= new BoardCommentModule($db);

		## 기본 설정
		$strBCode						= $_POST['b_code'];
		$intCmNo						= $_POST['cm_no'];
		$strCommentText					= $_POST['commentText'];
		$strCommentModDate				= "NOW()";
		$intMemberNo					= $_SESSION['member_no'];

		## 기본 설정 체크
		if(!$strBCode):
			$result['__STATE__']	= "NO_CODE";
			$result['__MSG__']		= $LNG_TRANS_CHAR["MS00138"]; // 커뮤니티 정보가 없습니다.
			break;
		endif;
		if(!$intCmNo):
			$result['__STATE__']	= "NO_CM_NO";
			$result['__MSG__']		= $LNG_TRANS_CHAR["MS00137"]; // 댓글 정보가 없습니다.
			break;
		endif;
		if(!$strCommentText):
			$result['__STATE__']	= "NO_COMMENT_TEXT";
			$result['__MSG__']		= $LNG_TRANS_CHAR["MS00139"]; // 내용이 없습니다.
			break;
		endif;
		if(!$intMemberNo):
			$result['__STATE__']	= "NO_MEMBER";
			$result['__MSG__']		= $LNG_TRANS_CHAR["MS00112"]; // 로그인이 필요합니다.
			break;			
		endif;

		## 수정할 데이터 불러오기
		$param							= "";
		$param['B_CODE']				= $strBCode;
		$param['CM_NO']					= $intCmNo;
		$aryCommentRow					= $objBoardComment->getBoardCommentSelectEx("OP_SELECT", $param);
		$intCM_M_NO						= $aryCommentRow['CM_M_NO'];

		## 체크
		if(!$aryCommentRow):
			$result['__STATE__']	= "NO_COMMENT_ROW";
			$result['__MSG__']		= $LNG_TRANS_CHAR["MS00137"]; // 댓글 정보가 없습니다.
			break;
		endif;
		if(!$intCM_M_NO):
			$result['__STATE__']	= "NO_M_NO";
			$result['__MSG__']		= $LNG_TRANS_CHAR["MS00144"]; // 비회원글은 수정을 지원하지 않습니다. 관리자에게 문의하세요.
			break;
		endif;
		if($intCM_M_NO != $intMemberNo):
			$result['__STATE__']	= "DIFF_MEMBER";
			$result['__MSG__']		= $LNG_TRANS_CHAR["MS00145"]; // 작성자만 수정 할수있습니다.
			break;
		endif;

		## 데이터 등록
		$param							= "";
		$param['B_CODE']				= $strBCode;
		$param['CM_NO']					= $intCmNo;
		$param['CM_TEXT']				= $strCommentText;
		$param['CM_MOD_DT']				= $strCommentModDate;
		$param['CM_MOD_NO']				= $strCommentModMemberNo;
		$re								= $objBoardComment->getBoardCommentTextUpdateEx($param);

		## 체크
		if(!$re):
			$result['__STATE__']	= "NO_COMMENT_MODIFY";
			$result['__MSG__']		= $LNG_TRANS_CHAR["MS00146"]; // 수정 할수없습니다. 관리자에게 문의하세요.
			break;
		endif;


		## 전달 데이터 만들기
//		$aryResultData['CM_TEXT']			= strConvertCut($strCommentText); 2014.07.30 kim hee sung 사용시. ' 사용을 하면 &quot; 형태로 출력이 됨.
		$aryResultData['CM_TEXT']			= nl2br($strCommentText);

		## 마무리
		$result['__STATE__']				= "SUCCESS";
		$result['__DATA__']					= $aryResultData;	

	break;

	case "commentDelete":
		// 댓글 삭제
		// 댓글 삭제는 CM_DEL 값을 Y로 변경합니다.
		// 댓글에 리플이 달린경우 문제의 소지가 있기 때문에 우선 이렇게 처리합니다.

		## 모듈 설정
		$objBoardComment				= new BoardCommentModule($db);
		$objMemberMgrModule				= new MemberMgrModule($db);

		## 기본 설정
		$strBCode						= $_POST['b_code'];
		$intCmNo						= $_POST['cm_no'];
		$strCommentModDate				= "NOW()";
		$intMemberNo					= $_SESSION['member_no'];

		## 기본 설정 체크
		if(!$strBCode):
			$result['__STATE__']	= "NO_CODE";
			$result['__MSG__']		= $LNG_TRANS_CHAR["MS00138"]; // 커뮤니티 정보가 없습니다.
			break;
		endif;
		if(!$intCmNo):
			$result['__STATE__']	= "NO_CM_NO";
			$result['__MSG__']		= $LNG_TRANS_CHAR["MS00137"]; // 댓글 정보가 없습니다.
			break;
		endif;
		if(!$intMemberNo):
			$result['__STATE__']	= "NO_MEMBER";
			$result['__MSG__']		= $LNG_TRANS_CHAR["MS00112"]; // 로그인이 필요합니다.
			break;			
		endif;

		## 삭제할 데이터 불러오기
		$param							= "";
		$param['B_CODE']				= $strBCode;
		$param['CM_NO']					= $intCmNo;
		$aryCommentRow					= $objBoardComment->getBoardCommentSelectEx("OP_SELECT", $param);
		$intCM_M_NO						= $aryCommentRow['CM_M_NO'];

		## 체크
		if(!$aryCommentRow):
			$result['__STATE__']	= "NO_COMMENT_ROW";
			$result['__MSG__']		= $LNG_TRANS_CHAR["MS00137"]; // 댓글 정보가 없습니다.
			break;
		endif;
		if(!$intCM_M_NO):
			$result['__STATE__']	= "NO_M_NO";
			$result['__MSG__']		= $LNG_TRANS_CHAR["MS00147"]; // 비회원글은 삭제를 지원하지 않습니다. 관리자에게 문의하세요.
			break;
		endif;
		if($intCM_M_NO != $intMemberNo):
			$result['__STATE__']	= "DIFF_MEMBER";
			$result['__MSG__']		= $LNG_TRANS_CHAR["MS00148"]; // 작성자만 삭제 할수있습니다.
			break;
		endif;

		## 데이터 등록
		$param							= "";
		$param['B_CODE']				= $strBCode;
		$param['CM_NO']					= $intCmNo;
		$param['CM_DEL']				= "Y";
		$param['CM_MOD_DT']				= $strCommentModDate;
		$param['CM_MOD_NO']				= $strCommentModMemberNo;
		$re								= $objBoardComment->getBoardCommentDelUpdateEx($param);
		
		## 체크
		if(!$re):
			$result['__STATE__']	= "NO_COMMENT_MODIFY";
			$result['__MSG__']		= $LNG_TRANS_CHAR["MS00149"]; // 삭제 할수없습니다. 관리자에게 문의하세요.
			break;
		endif;

		## 마무리
		$result['__STATE__']				= "SUCCESS";
	break;

	endswitch;

