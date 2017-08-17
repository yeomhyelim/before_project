<?
	## 작성일		: 2013.06.12
	## 작성자		: kim hee sung
	## 내  용		: 메시지를 전달하거나 받는 모듈 작성
	##				  (문자 보내기, 쪽지 보내기, 메일 보내기)
	## 참고사항		: 쪽지 보내기 기능만 가능(팝업 모드)

	require_once MALL_CONF_LIB."ProductMgr.php";	
	require_once MALL_CONF_LIB."MemberPaperMgr.php";	
	require_once MALL_CONF_LIB."ShopMgr.php";	

	$memberPaperMgr		= new MemberPaperMgr();
	$productMgr			= new ProductMgr();
	$shopMgr			= new ShopMgr();

	switch ($strAct) :

		case "paperMailForMinishop":
			## 체크
			if(!$g_member_no):
				// 회원이 아닌 경우
				echo "사용 권한이 없습니다.(001)";
				exit;
			endif;
			if(!$_POST['title'] || !$_POST['text']):
				// 제목이 없는 경우
				echo "등록된 내용이 없습니다.(002)";
				exit;
			endif;
			if(!$_POST['name'] || !$_POST['mail']):
				// 제목이 없는 경우
				echo "등록된 내용이 없습니다.(003)";
				exit;
			endif;

			## 입점몰 사용자 정보
			$param						= "";
			$param['SH_NO']				= $_POST['sh_no'];
			$param['SU_TYPE']			= "A";
			$shopUserRow				= $shopMgr->getShopUserViewEx($db, "OP_SELECT", $param);

			if(!$shopUserRow['M_NO']):
				// 회원 정보가 없는 경우
				echo "회원 정보가 없습니다.(004)";
				exit;
			endif;

			
			$fromName	= $shopUserRow['M_F_NAME']; if($shopUserRow['M_L_NAME']) { $toName = "{$toName} {$shopUserRow['M_L_NAME']}"; }	// 보내는사람 이름
			$fromMail	= $shopUserRow['M_MAIL'];		// 보내는사람 이메일
			$toName		= $_POST['name'];				// 받는사람 이름
			$toMail		= $_POST['mail'];				// 받는사람 이메일
			$title		= $_POST['title'];
			$text		= $_POST['text'];
			$text		= str_replace("\r","<br>", $text);
			$re			= sendMail($toName,$toMail,$title,$text,"Y",$fromName,$fromMail,"UTF-8");

			if($re == 1):
				// 성공
				goClose("메일을 보냈습니다.");
				exit;
			else:
				// 실패
				echo "메일을 보낼수 없습니다.(005)";
				exit;
			endif;
		break;

		case "paperWriteForMinishop":
			## 설명
			## 팝업모드에서 사용 가능합니다.
			## 쪽지 전송이 성공적으로 이루어 지면, 팝업은 자동으로 종료(닫기)됩니다.

			## 체크
			if(!$g_member_no):
				// 회원이 아닌 경우
				echo "사용 권한이 없습니다.(001)";
				exit;
			endif;
			if(!$_POST['sh_no']):
				// 입점몰 정보가 없는 경우
				echo "사용 권한이 없습니다.(002)";
				exit;		
			endif;
			if(!$_POST['mp_title'] || !$_POST['mp_text']):
				// 제목이 없는 경우
				echo "등록된 내용이 없습니다.(003)";
				exit;
			endif;

			## 입점몰 사용자 정보
			$param						= "";
			$param['SH_NO']				= $_POST['sh_no'];
			$param['SU_TYPE']			= "A";
			$shopUserRow				= $shopMgr->getShopUserViewEx($db, "OP_SELECT", $param);

			if(!$shopUserRow['M_NO']):
				// 회원 정보가 없는 경우
				echo "회원 정보가 없습니다.(004)";
				exit;
			endif;

			## 쪽지 등록
			$param						= "";
			$param['MP_PP_NO']			= 0;
			$param['MP_TO_M_NO']		= $shopUserRow['M_NO'];
			$param['MP_FROM_M_NO']		= $g_member_no;
			$param['MP_TITLE']			= $_POST['mp_title'];
			$param['MP_TEXT']			= $_POST['mp_text'];
			$param['MP_DEL_YN']			= "N";
			$re							= $memberPaperMgr->getMemberPaperInsertEx($db, $param);

			if($re == 1):
				// 성공
				goClose("등록되었습니다.");
				exit;
			else:
				// 실패
				echo "쪽지를 보낼수 없습니다.(005)";
				exit;
			endif;

		break;

	endswitch;

	$db->disConnect();

	goUrl($strMsg,$strUrl);
?>