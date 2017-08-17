<?

//	## STEP 1.
//	## includeFile 설정
//	$mode		= $_REQUEST['mode'];
//
//	if($_REQUEST['mode']=="dataMPassword")		{ $mode = "dataPassword"; }
//	elseif($_REQUEST['mode']=="dataDPassword")	{ $mode = "dataPassword"; }

	## 페이지 권한 함수
	## 리스트, 보기, 글쓰기, 수정, 삭제, 답변
	function getPageLock() {

		global $db;

		## STEP 1.
		## 체크할 페이지 설정
		$aryCheckPageList = array("dataList", "dataView", "dataWrite", "dataModify", "dataDelete", "dataAnswer");
		if(!in_array($_REQUEST['mode'], $aryCheckPageList)) { return 1; }

		## STEP 2.
		## 페이지 체크
		$use	= "0";
		$key	= strtolower($_REQUEST['mode']); 

		if($_REQUEST['BOARD_INFO']["bi_{$key}_use"] == "A"): // 모든회원/비회원
			$use = "1";
		elseif($_REQUEST['BOARD_INFO']["bi_{$key}_use"] == "M"): // 회원전용
			if($_REQUEST['member_login']): // 방문자가 회원인경우.
				foreach($_REQUEST['BOARD_INFO']["bi_{$key}_member_auth"] as $key => $val):
					if($_REQUEST['member_group'] == $val) { $use = "1"; }
				endforeach;
			endif;
		endif;
		if($use != 1 && $_SESSION['member_no']):
			$objAdminMgrModule = new AdminMgrModule($db);
			$param = "";
			$param['M_NO'] = $_SESSION['member_no'];
			$intAdminCnt = $objAdminMgrModule->getAdminMgrSelectEx("OP_COUNT", $param);
			if($intAdminCnt) { $use = 1; }
		endif;
		return $use;
	}

	function getCommunityView() {
		global $db;
		if     ($_REQUEST['BOARD_INFO']['b_kind'] == "data")	{ return  new CommunityDataView($db,  $_REQUEST);			}
		else if($_REQUEST['BOARD_INFO']['b_kind'] == "event")	{ return  new CommunityEventView($db, $_REQUEST);			}
		else if($_REQUEST['BOARD_INFO']['b_kind'] == "talk")	{ return  new CommunityTalkView($db, $_REQUEST);			}
		else if($_REQUEST['BOARD_INFO']['b_kind'] == "product")	{ return  new CommunityProductView($db, $_REQUEST);			}
		else if($_REQUEST['BOARD_INFO']['b_kind'] == "mypage")	{ return  new CommunityMypageView($db, $_REQUEST);			}
	}
?>