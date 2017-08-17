<?php
    /**
     * /home/shop_eng/www/modules/community/eventComment/basic.1.0/community.eventComment.view.php
     * @author eumshop(thav@naver.com)
     * community event comment view class (basic.1.0)
	 * $dataView = new CommunityEventCommentView($db, $_REQUEST);
     * **/

	require_once MALL_HOME . "/modules/community/community.view.php";
	require_once MALL_HOME . "/modules/community/eventComment/basic.1.0/community.eventComment.module.php";
	require_once MALL_HOME . "/modules/community/eventInfo/basic.1.0/community.eventInfo.view.php";
	require_once MALL_HOME . "/modules/community/gift/basic.1.0/community.gift.view.php";

    class CommunityEventCommentView extends CommunityView {

		/**
		 * __construct(&$db, &$field)
		 * 생성자
		 * **/
		function __construct(&$db, &$field) {
			$this->module	= new CommunityEventCommentModule($db, $field);
			$this->name		="EventCommentMgr";
			$this->db		= &$db;
			$this->field	= &$field;
		}

		/**
		 * getMessage()
		 * 메시지
		 * **/
		function getMessage() {
			echo "community event comment view class (basic.1.0)";
		}

		/**
		 * getExcelDownProcess()
		 * 댓글 엑셀 다운로드 프로세스
		 * **/
		function getExcelDownProcess(){
			## STEP 1.
			## 리스트 만들기
			$param['cm_ub_no']		= $this->field['ub_no'];
			$param['b_code']		= $this->field['b_code'];
			$param['cm_bc_no']		= $this->field['cm_bc_no'];
			$param['orderby']		= "SUBSTRING(a.CM_FUNC,1,1) DESC, a.CM_ANS_NO DESC, a.CM_ANS_STEP ASC";
//			$param['page_line']		= $this->field['BOARD_INFO']['bi_list_default'];
			$param['myTarget']		= $this->field['myTarget'];
			$param['cm_m_no']		= $this->field['member_no'];
//			if($this->field['myTarget'] == "widget") { $param['page_line'] = $this->field['BOARD_INFO']['bi_widget_list_default']; } /* 위젯 사용할때 */
			$param['searchKey']		= $this->field['searchKey'];
			$param['searchVal']		= $this->field['searchVal'];
//			$param['page']			= $this->field['page'];
//			$param['limit_first']	= $this->field['limit_first'];
			$param['cm_event_type']	= $this->field['cm_event_type'];	// 이벤트 타입
//			$listResult				= $this->module->getDataMgrSelectEx("OP_LIST", $param);
//			$listResult				= parent::getListNoPageEx("OP_LIST", $param);
			//echo $this->db->query;
			
			$this->field['result']['CommentMgrCount']	= parent::getListNoPageEx("OP_COUNT", $param);
			$this->field['result']['CommentMgr']		= parent::getListNoPageEx("OP_LIST", $param);
		}
		
		/**
		 * getListProcess()
		 * 리스트 프로세스
		 * **/
		function getListProcess() {

			## STEP 4.
			## 코멘트 필드
			$this->field['cm_ub_no']							= $this->field['ub_no'];
			$this->field['result']['EventCommentMgr']			= $this->getListEx();
			$this->field['result']['CommentMgrEventType']		= $this->getEventTypeSelect();

			## STEP 5.
			## 이벤트 설정 정보
			$eventInfoView											= new CommunityEventInfoView($this->db, $this->field);
			$this->field['result']['EventInfoMgr']					= $eventInfoView->getAryListEx();	

			## STEP 6.
			## 이벤트 - 쿠폰/포인트
			$param									= "";
			$param['gm_b_code']						= $this->field['b_code'];
			$param['gm_ub_no']						= $this->field['ub_no']; 
			$giftView								= new CommunityGiftView($this->db, $this->field);
			$cnt									= $giftView->getListNoPageEx("OP_COUNT", $param);
			if($cnt<=0) { $param['gm_ub_no'] = -1; }
			$result									= $giftView->getListNoPageEx("OP_LIST", $param);
			$this->field['result']['GiftMgr']		= $result;


//			## STEP 1.
//			## 데이터 리스트
//			$this->field['result']['EventCommentMgr']	= $this->getListEx();
//
//			##STEP 2.
//			## 포인트 & 쿠폰
//			$this->field['result']['pointSet']		= $this->getPointEx("c");
//			$this->field['result']['couponSet']		= $this->getCouponEx("c");
		}



		/**
		 * getListEx()
		 * 데이터 리스트
		 * **/
		function getListEx() {

			## STEP 1.
			## 리스트 만들기
			$param['cm_ub_no']		= $this->field['cm_ub_no'];
			$param['b_code']		= $this->field['b_code'];
			$param['cm_bc_no']		= $this->field['cm_bc_no'];
			$param['orderby']		= "SUBSTRING(a.CM_FUNC,1,1) DESC, a.CM_ANS_NO DESC, a.CM_ANS_STEP ASC";
			$param['page_line']		= $this->field['BOARD_INFO']['bi_list_default'];
			$param['myTarget']		= $this->field['myTarget'];
			$param['cm_m_no']		= $this->field['member_no'];
			if($this->field['myTarget'] == "widget") { $param['page_line'] = $this->field['BOARD_INFO']['bi_widget_list_default']; } /* 위젯 사용할때 */
			$param['searchKey']		= $this->field['searchKey'];
			$param['searchVal']		= $this->field['searchVal'];
			$param['page']			= $this->field['page'];
			$param['limit_first']	= $this->field['limit_first'];
			$param['cm_event_type']	= $this->field['cm_event_type'];	// 이벤트 타입
//			$listResult				= $this->module->getDataMgrSelectEx("OP_LIST", $param);
			$listResult				= parent::getListEx("OP_LIST", $param);
//			echo $this->db->query;

			## STEP 2.
			## 페이지 만들기
			$pageParam['list_default']	= $this->field['BOARD_INFO']['bi_list_default'];
			$pageParam['page_default']	= $this->field['BOARD_INFO']['bi_page_default'];
			$pageParam['page_line']		= $param['page_line'];
			$pageParam['list_total']	= $param['list_total'];
			$pageParam['page']			= $param['page'];
			$pageParam['limit_first']	= $param['limit_first'];
			$pageParam['list_num']		= $param['list_num'];
			$pageParam['link']			= "./?menuType={$this->field['menuType']}&mode={$this->field['mode']}&b_code={$this->field['b_code']}&ub_no={$this->field['ub_no']}&myTarget={$this->field['myTarget']}&cm_event_type={$this->field['cm_event_type']}&page=";
			$pageResult					= parent::getPageInfoEx($pageParam);
			
			return array("listResult" => $listResult, "pageResult" => $pageResult);
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

		function getSelectEx($param) {
			if(is_array($param)) { return parent::getSelectEx($param); }
		}

		/**
		 * getEventTypeSelect()
		 * 이벤트 종류 
		 * **/
		function getEventTypeSelect() {
			return $this->module->getEventCommentMgrCmEventTypeSelect(); 
		}

		/**
		 * getUploadWebPath()
		 * 업로드 파일 웹 경로
		 * **/
		function getUploadWebPath() {
		}

		/**
		 * getPointCount()
		 * 포인트 발급 횟수
		 * **/
		function getPointCount() {
			return $this->module->getEventCommentMgrPointCount();
		}

		/**
		 * getCouponCount()
		 * 쿠폰 발급 횟수
		 * **/
		function getCouponCount() {
			return $this->module->getEventCommentMgrCouponCount();
		}
		
		function getJoinCountEx($param) {
			return $this->module->getEventCommentMgrJoinCountEx($param);
		}

		/**
		 * getList()
		 * 데이터 리스트
		 * **/
		function getList() {

			## STEP 1.
			## 권한 체크
//			if(!$this->field['dataAuth']['check']) { return; }
			if($this->field['BOARD_INFO']['bi_comment_use'] == "N") { return; } 

			## STEP 2.
			## 쓰기 권한 체크
			$auth = 0;
			if($this->field['BOARD_INFO']['bi_comment_use'] == "A") { $auth = 1; }
			else if($this->field['BOARD_INFO']['bi_comment_use'] == "M") {
				if($this->field['member_group']):
					if(in_array($this->field['member_group'], $this->field['BOARD_INFO']['bi_comment_member_auth'])){ $auth = 1; }
				endif;
			}
			$this->field['comment_write_auth'] = $auth;
		

			## STEP 2.
			## 설정
			$this->field['cm_ub_no']	= $this->field['ub_no'];
			$this->field['orderby']		= "cm_no desc";

			## STEP 3.
			## 리스트
			$result = parent::getList();

			## STEP 4.
			## 페이징 실행
			$this->getPageInfo();

			return $result;
		}

		/**
		 * getPageInfo()
		 * 페이징 설정
		 * **/
		function getPageInfo() {		
			$this->field['list_default'][$this->name]		= 10;
			$this->field['page_default'][$this->name]		= 10;
			$this->field['link'][$this->name]				= "./?menuType={$this->field['menuType']}&mode={$this->field['mode']}&b_code={$this->field['b_code']}&ub_no={$this->field['ub_no']}&page=";
			parent::getPageInfo();
		}

		/**
		 * getSelect()
		 * 데이터 정보
		 * **/
		function getSelect() {
			return parent::getSelect();
		}
		
		/**
		 * getWrite()
		 * 데이터 쓰기
		 * **/
		function getWrite() {	
		//	print_r($_SESSION);
		}

		/**
		 * getCM_FUNC_DECODER()
		 * 기능 함수
		 * **/
		function getCM_FUNC_DECODER(&$row) {

			$data['CM_FUNC_NOTICE']		= $row['CM_FUNC'][0];
			$data['CM_FUNC_LOCK']		= $row['CM_FUNC'][1];
			$data['CM_FUNC_ICON']		= $row['CM_FUNC'][2];

			return $data;
		}

		/**
		 * getAuthCheck(&$row)
		 * $auth['member']	= 0		=> 비회원
		 * $auth['member']	= 1		=>   회원
		 * $auth['check']	= 0		=> 권한 없음
		 * $auth['check']	= 1		=> 권한 있음
		 * 2013.04.11 community.view.php 으로 이동
		 * **/	
//		function getAuthCheck(&$row) {
//
//			if($row['CM_M_NO']) { $auth['member'] = "1"; }
//			else				{ $auth['member'] = "0"; }
//
//			if($this->field['member_login'] && $row['CM_M_NO'] && $this->field['member_no'] == $row['CM_M_NO'])		{ $auth['check'] = "1"; }	// 회원이 작성한 글과 로그인 한 회원이 같으면 1
//			elseif($this->field['cm_pass'] && $row['CM_PASS'] && $this->field['cm_pass'] == $row['CM_PASS']) 		{ $auth['check'] = "1"; }	// 비회원이 작성한 글과 비밀번호가     같으면 1
//			elseif($this->field['b_code'] == $_SESSION['b_code'] && $this->field['cm_no'] == $_SESSION['cm_no'])	{ $auth['check'] = "1"; }	// 세션 정보와 작성한 글의 정보가	   같으면 1
//			else																									{ $auth['check'] = "0"; }	// 권한이 필요한 경우.
//
//			return $auth;
//		}

		
		function getLockAuthCheck(&$row) {
			$aryFunc	= $this->getCM_FUNC_DECODER($row);
			$auth		= $this->getAuthCheck($row);

			if($auth['CM_FUNC_LOCK']=="N"):
				$auth['check']	= "1";				
			endif;

			return $auth;
		}
    }
?>