<?php
    /**
     * /home/shop_eng/www/modules/community/event/basic.1.0/community.event.view.php
     * @author eumshop(thav@naver.com)
     * community event view class (basic.1.0)
	 * $dataView = new CommunityEventView($db, $_REQUEST);
     * **/
	require_once MALL_HOME . "/modules/community/eventComment/basic.1.0/community.eventComment.view.php";
	require_once MALL_HOME . "/modules/community/attachedfile/basic.1.0/community.attachedfile.view.php";
	require_once MALL_HOME . "/modules/community/userfield/basic.1.0/community.userfield.view.php";
	require_once MALL_HOME . "/modules/community/eventInfo/basic.1.0/community.eventInfo.view.php";
	require_once MALL_HOME . "/modules/community/gift/basic.1.0/community.gift.view.php";

	require_once MALL_HOME . "/modules/community/community.view.php";
	require_once MALL_HOME . "/modules/community/event/basic.1.0/community.event.module.php";

    class CommunityEventView extends CommunityView {

		## 기본 함수. 

		/**
		 * __construct(&$db, &$field)
		 * 생성자
		 * **/
		function __construct(&$db, &$field) {
			$this->module	= new CommunityEventModule($db, $field);
			$this->name		="DataMgr";
			$this->db		= &$db;
			$this->field	= &$field;
			$this->getSessionInfo();
			$this->getButtonLockCode();		// 신규
//			$this->getButtonAuth();
		}

		/**
		 * getMessage()
		 * 메시지
		 * **/
		function getMessage() {
			echo "community event view class (basic.1.0)";
		}

		/**
		 * getWriteProcess()
		 * 쓰기 프로세스
		 * **/
		function getWriteProcess() {
			## STEP 5.
			## 이벤트 - 쿠폰/포인트 설정
			$param									= "";
			$param['be_b_code']						= $this->field['b_code'];
			$param['be_ub_no']						= 0; 
			$eventInfoView							= new CommunityEventInfoView($this->db, $this->field);
			$result									= $eventInfoView->getListNoPageEx("OP_ARYLIST", $param);
			$this->field['result']['EventInfoMgr']	= $result;

			## STEP 5.
			## 이벤트 - 쿠폰/포인트
			$param									= "";
			$param['gm_b_code']						= $this->field['b_code'];
			$param['gm_ub_no']						= -1; 
			$giftView								= new CommunityGiftView($this->db, $this->field);
			$result									= $giftView->getListNoPageEx("OP_LIST", $param);
			$this->field['result']['GiftMgr']		= $result;
			$this->field['result']['gm_ub_no']		= $param['gm_ub_no'];
		}

		/**
		 * getModifyProcess()
		 * 수정 프로세스
		 * **/
		function getModifyProcess() {

			## STEP 1.
			## 권한 체크
			$this->getDataAuthCheck();
			if(!$this->field['dataAuth']['check']):
				$this->field['mode']			= "dataPassword";
				$this->field['act']				= "";
				$this->field['password_mode']	= "dataModify";
				$this->field['password_act']	= "goDataLocation";
				return;
			endif;

			## STEP 2.
			## 데이터 
			$this->field['result']['DataMgr']			= $this->getSelect();

			## STEP 3.
			## 사용자 필드
			$userfieldView								= new CommunityUserfieldView($this->db, $this->field);
			$this->field['result']['UserfieldMgr']		= $userfieldView->getView();

			## STEP 4.
			## 첨부파일 필드
			$attachedfileView							= new CommunityAttachedfileView($this->db, $this->field);
			$this->field['result']['AttachedfileMgr']	= $attachedfileView->getList();

			## STEP 5.
			## 이벤트 - 쿠폰/포인트 설정
			$param									= "";
			$param['be_b_code']						= $this->field['b_code'];
			$param['be_ub_no']						= $this->field['ub_no']; 
			$eventInfoView							= new CommunityEventInfoView($this->db, $this->field);
			$cnt									= $eventInfoView->getListNoPageEx("OP_COUNT", $param);
			if($cnt<=0) { $param['be_ub_no'] = 0; }
			$result									= $eventInfoView->getListNoPageEx("OP_ARYLIST", $param);
			$this->field['result']['EventInfoMgr']	= $result;

			## STEP 5.
			## 이벤트 - 쿠폰/포인트
			$param									= "";
			$param['gm_b_code']						= $this->field['b_code'];
			$param['gm_ub_no']						= $this->field['ub_no']; 
			$giftView								= new CommunityGiftView($this->db, $this->field);
			$cnt									= $giftView->getListNoPageEx("OP_COUNT", $param);
			if($cnt<=0) { $param['gm_ub_no'] = -1; }
			$result									= $giftView->getListNoPageEx("OP_LIST", $param);
			$this->field['result']['GiftMgr']		= $result;
			$this->field['result']['gm_ub_no']		= $param['gm_ub_no'];
		}

		/**
		 * getListProcess()
		 * 리스트 프로세스
		 * **/
		function getListProcess() {

			## STEP 1.
			## 데이터 리스트
			$this->field['result']['DataMgr']		= $this->getListExMake();

			##STEP 2.
			## 포인트 & 쿠폰
			$this->field['result']['pointSet']		= $this->getPointEx("w");
			$this->field['result']['couponSet']		= $this->getCouponEx("w");
		}

		/**
		 * getViewProcess()
		 * 뷰 프로세스
		 * **/
		function getViewProcess() {

			## STEP 1.
			## 데이터 뷰
			$this->field['result']['DataMgr']			= $this->getView();

			## STEP 2.
			## 사용자 필드
			$userfieldView								= new CommunityUserfieldView($this->db, $this->field);
			$this->field['result']['UserfieldMgr']		= $userfieldView->getView();

			## STEP 3.
			## 첨부파일 필드
			$attachedfileView							= new CommunityAttachedfileView($this->db, $this->field);
			$this->field['result']['AttachedfileMgr']	= $attachedfileView->getList();

			## STEP 4.
			## 코멘트 필드
			## 2013.05.22 코멘트(참여자) 페이지 분리
//			if(in_array($this->field['BOARD_INFO']['bi_comment_use'], array("A","M"))):
//				$this->field['cm_ub_no']							= $this->field['ub_no'];
//				$commentView										= new CommunityEventCommentView($this->db, $this->field);
//				$this->field['result']['EventCommentMgr']			= $commentView->getListEx();
//
//				if($this->field['S_PAGE_AREA'] == "adminPage"):
//					// 이벤트 종류
//					$this->field['result']['CommentMgrEventType']	= $commentView->getEventTypeSelect();
//
//				endif;
//			endif;
//
//			## STEP 5.
//			## 이벤트 설정 정보
//			$eventInfoView											= new CommunityEventInfoView($this->db, $this->field);
//			$this->field['result']['EventInfoMgr']					= $eventInfoView->getAryListEx();	
//
//			##STEP 5.
//			## 포인트 & 쿠폰
//			$this->field['result']['pointSet']		= $this->getPointEx("c");
//			$this->field['result']['couponSet']		= $this->getCouponEx("c");
			
			## STEP 5.
			## 이벤트 - 쿠폰/포인트 설정
			if($this->field['S_SHOP_HOME'] == "demo1"):
			$param									= "";
			$param['be_b_code']						= $this->field['b_code'];
			$param['be_ub_no']						= $this->field['ub_no']; 
			$eventInfoView							= new CommunityEventInfoView($this->db, $this->field);
			$cnt									= $eventInfoView->getListNoPageEx("OP_COUNT", $param);
			if($cnt<=0) { $param['be_ub_no'] = 0; }
			$result									= $eventInfoView->getListNoPageEx("OP_ARYLIST", $param);
			$this->field['result']['EventInfoMgr']	= $result;
			endif;

			## STEP 5.
			## 이벤트 - 쿠폰/포인트
			if($this->field['S_SHOP_HOME'] == "demo1"):
			$param									= "";
			$param['gm_b_code']						= $this->field['b_code'];
			$param['gm_ub_no']						= $this->field['ub_no']; 
			$giftView								= new CommunityGiftView($this->db, $this->field);
			$cnt									= $giftView->getListNoPageEx("OP_COUNT", $param);
			if($cnt<=0) { $param['gm_ub_no'] = -1; }
			$result									= $giftView->getListNoPageEx("OP_LIST", $param);
			$this->field['result']['GiftMgr']		= $result;
			$this->field['result']['gm_ub_no']		= $param['gm_ub_no'];
			endif;
		}

		/**
		 * getPointEx()
		 * 포인트 설정
		 * **/
		function getPointEx($where) {
			$pointSet['where']						= $where;
			$pointSet["bi_point_use"]				= $this->field['BOARD_INFO']["bi_point_{$where}_use"];
			$pointSet["bi_point_give"]				= $this->field['BOARD_INFO']["bi_point_{$where}_give"];
			$pointSet["bi_point_mark"]				= $this->field['BOARD_INFO']["bi_point_{$where}_mark"];
			$pointSet["bi_point_multi_max"]			= $this->field['BOARD_INFO']["bi_point_{$where}_multi_max"];
			$pointSet["bi_point_multi_count"]		= $this->field['BOARD_INFO']["bi_point_{$where}_multi_count"];
			$pointSet["bi_point_multi_title"]		= $this->field['BOARD_INFO']["bi_point_{$where}_multi_title"];
			$pointSet["bi_point_multi_point"]		= $this->field['BOARD_INFO']["bi_point_{$where}_multi_point"];
			return $pointSet;
		}

		/**
		 * getCouponEx()
		 * 쿠폰 설정
		 * **/
		function getCouponEx($where) {
			$couponSet['where']						= $where;
			$couponSet["bi_coupon_use"]				= $this->field['BOARD_INFO']["bi_coupon_{$where}_use"];
			$couponSet["bi_coupon_give"]			= $this->field['BOARD_INFO']["bi_coupon_{$where}_give"];
			$couponSet["bi_coupon_mark"]			= $this->field['BOARD_INFO']["bi_coupon_{$where}_mark"];
			$couponSet["bi_coupon_multi_max"]		= $this->field['BOARD_INFO']["bi_coupon_{$where}_multi_max"];
			$couponSet["bi_coupon_multi_count"]		= $this->field['BOARD_INFO']["bi_coupon_{$where}_multi_count"];
			$couponSet["bi_coupon_multi_title"]		= $this->field['BOARD_INFO']["bi_coupon_{$where}_multi_title"];
			$couponSet["bi_coupon_multi_coupon"]	= $this->field['BOARD_INFO']["bi_coupon_{$where}_multi_coupon"];
			return $couponSet;
		}

		/**
		 * getListEx()
		 * 데이터 리스트
		 * **/
		function getListExMake() {

			## STEP 1.
			## 페이지 라인 개수 설정
			if($this->field['S_PAGE_AREA'] == "adminPage"):
				// 관리자 설정
				if(!$this->field['page_line'] && $_COOKIE['community_page_line']):
					$this->field['page_line'] = $_COOKIE['community_page_line'];
				endif;
				if($this->field['page_line']):
					setcookie('community_page_line',$this->field['page_line'],time()+3600,'/');
					$param['page_line'] = $this->field['page_line'];
				endif;
			endif;
			if(!$param['page_line']):
				$param['page_line']	= $this->field['BOARD_INFO']['bi_list_default'];
			endif;

			## STEP 1.
			## 리스트 만들기
			$param['b_code']		= $this->field['b_code'];
			$param['ub_bc_no']		= $this->field['ub_bc_no'];
//			$param['orderby']		= "SUBSTRING(UB_FUNC,1,1) DESC, UB_ANS_NO DESC, UB_ANS_STEP ASC";
			$param['orderby']		= "SUBSTRING(UB_FUNC,1,1) DESC,UB_NO DESC";
//			$param['page_line']		= $this->field['BOARD_INFO']['bi_list_default'];
			$param['myTarget']		= $this->field['myTarget'];
			$param['ub_m_no']		= $this->field['member_no'];
			if($this->field['member_group'] == "001") { $param['ub_m_no'] = ""; } /* 관리자 로그인 일때 */
			if($this->field['myTarget'] == "widget") { $param['page_line'] = $this->field['BOARD_INFO']['bi_widget_list_default']; } /* 위젯 사용할때 */
			$param['device']		= $this->field['device'];
			$param['pageArea']		= $this->field['S_PAGE_AREA'];
			$param['searchKey']		= $this->field['searchKey'];
			$param['searchVal']		= $this->field['searchVal'];
			$param['page']			= $this->field['page'];
			$param['limit_first']	= $this->field['limit_first'];
			$param['bi_attachedfile_use']	= $this->field['BOARD_INFO']['bi_attachedfile_use'];
			$param['bi_userfield_use']		= $this->field['BOARD_INFO']['bi_userfield_use'];
//			$listResult				= $this->module->getDataMgrSelectEx("OP_LIST", $param);
			$listResult				= parent::getListEx("OP_LIST", $param);

			## STEP 2.
			## 페이지 만들기
//			$pageParam['list_default']	= $this->field['BOARD_INFO']['bi_list_default'];
			$pageParam['list_default']	= $param['page_line'];
			$pageParam['page_default']	= $this->field['BOARD_INFO']['bi_page_default'];
			$pageParam['page_line']		= $param['page_line'];
			$pageParam['list_total']	= $param['list_total'];
			$pageParam['page']			= $param['page'];
			$pageParam['limit_first']	= $param['limit_first'];
			$pageParam['list_num']		= $param['list_num'];
			$pageParam['link']			= "./?menuType={$this->field['menuType']}&mode={$this->field['mode']}&b_code={$this->field['b_code']}&page=";
			$pageResult					= parent::getPageInfoEx($pageParam);

			return array("listResult" => $listResult, "pageResult" => $pageResult);
		}



		/**
		 * getCountTotalEx()
		 * 데이터 전체 개수
		 * 2013.04.10 커뮤니티 통합(상속 부분) 영역으로 변경
		 * **/
//		function getCountTotalEx() {
//			$param['b_code'] = $this->field['b_code'];
//			return $this->module->{"get{$this->name}SelectEx"}("OP_COUNT", $param);
//		}

		function getSelectEx($param) {
			if(is_array($param)) { return parent::getSelectEx($param); }
		}

		## 수행 함수. 

		/**
		 * getList()
		 * 데이터 리스트
		 * **/
		function getList() {

			## STEP 1.
			## 기본 설정
			$this->field['orderby']		= "substring(ub_func,1,1) desc,ub_no desc";
			$this->field['page_line']	= $this->field['BOARD_INFO']['bi_list_default'];
			if ($this->field['myTarget'] == "widget"):
				$this->field['page_line']	= $this->field['BOARD_INFO']['bi_widget_list_default'];
			endif;


			## STEP 2.
			## 게시판 종류별 설정
			if($this->field['BOARD_INFO']['b_kind'] == "gallery"):
				$this->field['page_line']	= $this->field['BOARD_INFO']['bi_list_default'] * $this->field['BOARD_INFO']['bi_column_default'];
			endif;

			## STEP 3.
			## query 실행
			$listRow					= parent::getList();

			## STEP 4.
			## 페이징 실행
			$this->getPageInfo();

			## STEP 5.
			## return
			return $listRow;
		}

		/**
		 * getView()
		 * 데이터 보기
		 * **/
		function getView() {

			## STEP 1.
			## 버튼 권한 체크 함수
			function getButtonAuth(&$field, &$row, $key) {
				if(!$field['buttonLock'][$key]) { return 0; }					// 사용 권한이 없다면
				if(!$row['UB_M_NO']) { return 1; }								// 비회원이 작성한 글인 경우
				if(!$field['member_login']) { return 0; }						// 로그인을 하지 않은 경우
				if($field['member_no'] != $row['UB_M_NO']) { return 0; }		// 로그인 한 회원과 작성된 글의 회원이 다른 경우.

				return 1;						
			}

			## STEP 1.
			## 데이터 로드
			$selectRow					= $this->getSelect();
			$lock						= $selectRow['UB_FUNC']['UB_FUNC_LOCK'];

			## STEP 2.
			## 권한 체크
			$auth						= $this->getAuthCheck($selectRow);
			$this->field['dataAuth']	= $auth;

			## STEP 3.
			## 권한 체크
			if($lock == "Y"):
				if(!$this->field['dataAuth']['check']):
					$this->field['mode']			= "dataPassword";
					$this->field['act']				= "";
					$this->field['password_mode']	= "dataView";
					$this->field['password_act']	= "goDataLocation";
					return;
				endif;
			else:
//				$this->field['dataAuth']['member']	= $this->field['dataAuth']['member'];
				$this->field['dataAuth']['check']	= "1";
			endif;

			## STEP 4.
			## 해당 글, 버튼 체크
			$this->field['buttonLock']['dataModify']	=  getButtonAuth($this->field, $selectRow, "dataModify");
			$this->field['buttonLock']['dataDelete']	=  getButtonAuth($this->field, $selectRow, "dataDelete");

			## STEP 5.
			## 조회수 1증가.
			parent::getReadUpdate();

			$_SESSION['b_code']		= "";
			$_SESSION['ub_no']		= "";

			return $selectRow;
		}

		/**
		 * getWrite()
		 * 데이터 쓰기
		 * **/
		function getWrite() {			
		}

		/**
		 * getModify()
		 * 데이터 수정
		 * **/
		function getModify() {

			## STEP 1.
			## 권한 체크
			if(!$this->field['dataAuth']['check']):
				$this->field['mode']			= "dataPassword";
				$this->field['act']				= "";
				$this->field['password_mode']	= "dataModify";
				$this->field['password_act']	= "goDataLocation";
				return;
			endif;

			## STEP 2.
			## 데이터 로드
			$dataSelectRow						=  $this->getSelect();

			## STEP 3.
			## 데이터 전달			
			return $dataSelectRow;
		}

		/**
		 * getSelect()
		 * 데이터 정보
		 * **/
		function getSelect() {
//			$this->field['ub_table']	= "BOARD_UB_{$this->field['b_code']}";
//			$this->field['fl_table']	= "BOARD_FL_{$this->field['b_code']}";
			$selectRow					= parent::getSelect();	
			$aryFunc					= $this->getUB_FUNC_DECODER($selectRow);
			$selectRow['UB_FUNC']		= $aryFunc;

			if($this->field['buttonLock'][3]):
				if($selectRow['UB_M_NO']==0):
					$this->field['buttonLock'][3] = 2;	// 비회원 버튼
					$this->field['buttonLock'][4] = 2;	// 비회원 버튼
				endif;
			endif;

			return $selectRow;
		}

		/**
		 * getPageInfo()
		 * 페이징 설정
		 * **/
		function getPageInfo() {		
			$this->field['list_default']		= $this->field['BOARD_INFO']['bi_list_default'];
			$this->field['page_default']		= $this->field['BOARD_INFO']['bi_page_default'];
			$this->field['link']				= "./?menuType={$this->field['menuType']}&mode={$this->field['mode']}&b_code={$this->field['b_code']}&page=";
			parent::getPageInfo();
		}

//		/**
//		 * getButtonAuth()
//		 * 버튼 설정
//		 * **/
//		function getButtonAuth() {
//			$aryButtonList										= array( "datawrite", "datamodify", "datalist", "dataview", "datadelete" );
//			$this->field['BOARD_INFO']['bi_datamodify_use']		= $this->field['BOARD_INFO']['bi_datawrite_use'];
//
//			foreach($aryButtonList as $key) :
//				$this->field['BOARD_INFO']['bi_'.$key.'_use']	= $this->getButtonAuthFunc($key);
//			endforeach;
//		}
//
//		/**
//		 * getButtonAuthFunc($key)
//		 * 버튼 설정 함수
//		 * **/
//		function getButtonAuthFunc($key) {
//
//			$aryButtonList = array( "datawrite"		=> "DataWrite", 
//									"datamodify"	=> "DataModify",
//									"datalist"		=> "DataList",
//									"dataview"		=> "DataView",	
//									"datadelete"	=> "DataDelete",			);
//
//			if($this->field['BOARD_INFO']['bi_'.$key.'_use'] == "Y"):
//				$auth				= $aryButtonList[$key];
//				if($this->field['BOARD_INFO']['bi_'.$key.'_nonmember_use'] != "Y"):
//					// 비회원 사용 N인 경우.
//					if(!$_SESSION['ADMIN_LOGIN'] && !$_SESSION['member_login']):
//						// 비회원인 경우.
//						$auth		= "PERMISSION_NO";
//					endif;
//				endif;
//			endif;
//
//			return $auth;
//		}




		## FUNCTION()
		## 함수 모음


//		/**
//		 * getLockCheck(&$row)
//		 * 볼수있는 글이면 return "000", 볼수 없는 글이면 return "11X"
//		 * **/		
//		function getLockCheck(&$row) {
//			$lock_use	= $this->field['BOARD_INFO']['bi_datawrite_lock_use'];
//			$code		= "";
//
//			// 작성된 글이 비밀글이면 1, 아니면 0
//			if     ($lock_use == "E") { $code .= "1"; }
//			else if($lock_use == "C") { $code .= ($row['UB_FUNC']['UB_FUNC_LOCK'] == "Y") ? "1" : "0"; }
//			else                      { $code .= "0"; }
//
//			if($code == "0")		  { return "000"; }
//
//			// 회원이 작성한 글과 로그인 한 회원이 같으면 0, 다르면 1		or
//			// 비회원이 작성한 글과 비밀번호가     같으면 0, 다르면 1
//			if($this->field['member_login'] && $row['UB_M_NO'] && $this->field['member_no'] == $row['UB_M_NO'])		{ $code .= "0"; }
//			elseif($this->field['ub_pass'] && $row['UB_PASS'] && $this->field['ub_pass'] == $row['UB_PASS']) 		{ $code .= "0"; }
//			else																									{ $code .= "1"; }
//
//			if($code == "10")		  { return "000"; }
//
//			// 회원이 작성한 글이면 1, 아니면 0
//			if($row['UB_M_NO']) { $code .= "1"; }
//			else				{ $code .= "0"; }			
//
//			return $code;
//		}



		function getLockAuthCheck(&$row) {
			$aryFunc	= $this->getUB_FUNC_DECODER($row);
			$auth		= $this->getAuthCheck($row);

			if($auth['UB_FUNC_LOCK']=="N"):
				$auth['check']	= "1";				
			endif;

			return $auth;
		}


		## 
		## 권한 함수 모음
		## 

		/**
		 * getDataAuthCheck()
		 * 자신의 데이터(글) 인지 체크
		 * 2013.03.25 버전
		 * **/
		function getDataAuthCheck() {
			$selectRow					= $this->getSelect();
			$auth						= $this->getAuthCheck($selectRow);
			$this->field['dataAuth']	= $auth;
		}

		/**
		 * getUB_FUNC_DECODER()
		 * 기능 함수
		 * **/
		function getUB_FUNC_DECODER(&$row) {

			$data['UB_FUNC_NOTICE']			= $row['UB_FUNC'][0];
			$data['UB_FUNC_LOCK']			= $row['UB_FUNC'][1];
			$data['UB_FUNC_ICON']			= $row['UB_FUNC'][2];
			$data['UB_FUNC_ICON_WIDGET']	= $row['UB_FUNC'][3];
			$data['UB_FUNC_WEBUSE']			= $row['UB_FUNC'][4];
			$data['UB_FUNC_MOBILEUSE']		= $row['UB_FUNC'][5];
			return $data;
		}

		/**
		 * getAuthCheck(&$row)
		 * $auth['member']	= 0		=> 비회원
		 * $auth['member']	= 1		=>   회원
		 * $auth['check']	= 0		=> 권한 없음
		 * $auth['check']	= 1		=> 권한 있음
		 * 2013.03.25 버전
		 * 2013.04.11 community.view.php 으로 이동
		 * **/	
//		function getAuthCheck(&$row) {
//
//			if($row['UB_M_NO'])																						{ $auth['member'] = "1"; }
//			elseif($this->field['member_login'] && in_array($this->field['member_type'], array("A", "S")))			{ $auth['member'] = "1"; }	// 관리자 로그인을 했다면 1
//			else																									{ $auth['member'] = "0"; }
//
//			if($this->field['member_login'] && $row['UB_M_NO'] && $this->field['member_no'] == $row['UB_M_NO'])		{ $auth['check'] = "1"; }	// 회원이 작성한 글과 로그인 한 회원이 같으면 1
//			elseif($this->field['ub_pass'] && $row['UB_PASS'] && $this->field['ub_pass'] == $row['UB_PASS']) 		{ $auth['check'] = "1"; }	// 비회원이 작성한 글과 비밀번호가     같으면 1
//			elseif($this->field['b_code'] == $_SESSION['b_code'] && $this->field['ub_no'] == $_SESSION['ub_no'])	{ $auth['check'] = "1"; }	// 세션 정보와 작성한 글의 정보가	   같으면 1
//			elseif($this->field['member_login'] && in_array($this->field['member_type'], array("A", "S")))			{ $auth['check'] = "1"; }	// 관리자 로그인을 했다면 1
//			else																									{ $auth['check'] = "0"; }	// 권한이 필요한 경우.
//	
//			if($auth['check'] == 0 && $row['UB_ANS_NO'] && $row['UB_ANS_NO'] != $row['UB_NO']):
//				$ub_no_bak				= $this->field['ub_no'];
//				$this->field['ub_no']	=  $row['UB_ANS_NO'];
//				$ansRow = $this->getSelect();
//				$this->field['ub_no']	= $ub_no_bak;
//				return $this->getAuthCheck($ansRow);	// 재귀호출
//			endif;
//
//			return $auth;
//		}
		
    }
?>