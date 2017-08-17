<?php
    /**
     * /home/shop_eng/www/modules/community/eventComment/basic.1.0/community.eventComment.controller.php
     * @author eumshop(thav@naver.com)
     * community eventComment controller class (basic.1.0)
     * **/
	require_once MALL_HOME . "/modules/community/eventInfo/basic.1.0/community.eventInfo.view.php";
	require_once MALL_HOME . "/modules/community/event/basic.1.0/community.event.view.php";
	require_once MALL_HOME . "/modules/point/data/basic.1.0/point.data.controller.php";
	require_once MALL_HOME . "/modules/point/data/basic.1.0/point.data.view.php";
	require_once MALL_HOME . "/modules/coupon/data/basic.1.0/coupon.data.controller.php";
	require_once MALL_HOME . "/modules/coupon/issue/basic.1.0/coupon.issue.controller.php";
	require_once MALL_HOME . "/modules/community/gift/basic.1.0/community.gift.view.php";
	require_once MALL_HOME . "/modules/member/data/basic.1.0/member.data.controller.php";
	require_once MALL_HOME . "/modules/community/community.controller.php";
	require_once MALL_HOME . "/modules/community/eventComment/basic.1.0/community.eventComment.module.php";
	require_once MALL_HOME . "/modules/community/eventComment/basic.1.0/community.eventComment.view.php";

	require_once MALL_HOME . "/classes/file/file.handler.class.php";
 //	require_once MALL_HOME . "/classes/client/client.info.class.php";
	require_once MALL_HOME . "/classes/string/string.func.class.php";

    class CommunityEventCommentController extends CommunityController {

		/**
		 * __construct(&$db, &$field)
		 * 생성자
		 * **/
		function __construct(&$db, &$field) {
			$this->module	= new CommunityEventCommentModule($db, $field);
			$this->name		="EventCommentMgr";
			$this->db		= &$db;
			$this->field	= &$field;
			$this->getSessionInfo();
		}

		/**
		 * geDeleteMultiProcess()
		 * 커뮤니티 코멘트 삭제
		 * **/
		function geDeleteMultiProcess() {
			
			## STEP 1.
			## 선언
			$commentView		= new CommunityEventCommentView($this->db, $this->field);

			## STEP 2.
			## 커뮤니티 코멘트 삭제
			$check = $this->field['check'];
			foreach($check as $cm_no):
				## STEP 2-1.
				## 커뮤니티 데이터 가져오기
				$param['b_code']				= $this->field['b_code'];
				$param['cm_no']					= $cm_no;
				$dataSelectRow					= $commentView->getSelectEx($param);

				if($dataSelectRow['CM_PT_NO'] || $dataSelectRow['CM_CI_NO']) { continue; } /** 포인트/쿠폰 발급 이력이 있으면 삭제 못함. **/

				## STEP 2-2.
				## 삭제
				parent::getDeleteEx($param);
			endforeach;
		}
		
		/**
		 * getCouponCancelProcess()
		 * 커뮤니티 코멘트 쿠폰 발급 취소
		 * **/
		function getCouponCancelProcess() {
			## STEP 1.
			## 쿠폰 설정 정보 불러오기.
			$eventInfoView			= new CommunityEventInfoView($this->db, $this->field);
			$eventInfoResult		= $eventInfoView->getAryListEx();

			## STEP 2.
			## 쿠폰 발급 취소.
			$param['list']			= $this->field['check'];
			$param['memo']			= "커뮤니티 쿠폰 발급 취소(BOARD_CM_{$this->field['b_code']})";;
			$param['point']			= $giftViewRow['GM_DATA'];
			$param['gm_no']			= $giftViewRow['GM_NO'];
			$param['b_code']		= $this->field['b_code'];
			$this->getCouponCancelEx($param);	
		}

		/**
		 * getPointCancelProcess()
		 * 커뮤니티 코멘트 포인트 발급 취소
		 * **/
		function getPointCancelProcess() {

			## STEP 1.
			## 포인트 설정 정보 불러오기.
			$eventInfoView			= new CommunityEventInfoView($this->db, $this->field);
			$eventInfoResult		= $eventInfoView->getAryListEx();

			## STEP 2.
			## 포인트 발급 취소.
			$param['list']			= $this->field['check'];
			$param['memo']			= "커뮤니티 포인트 발급 취소(BOARD_CM_{$this->field['b_code']})";;
			$param['point']			= $giftViewRow['GM_DATA'];
			$param['gm_no']			= $giftViewRow['GM_NO'];
			$param['b_code']		= $this->field['b_code'];
			$this->getPointCancelEx($param);	
		}


		/**
		 * getWriteProcess()
		 * 커뮤니티 댓글 등록 프로세스
		 * **/
		function getWriteProcess() {
			## STEP 1.
			## 커뮤니티 댓글 등록
			$this->getWrite();	

			## STEP 4.
			## 포인트 지급(자동 옵션인 경우)
			if($this->field['BOARD_INFO']['bi_point_use'] == "Y" && $this->field['BOARD_INFO']['bi_point_c_use'] == "Y" && $this->field['BOARD_INFO']['bi_point_c_give'] == "A"):
				$param['give_type'] = $this->field['BOARD_INFO']['bi_point_c_give'];
				$this->getPointGiveKindEx($param);	
			endif;

			## STEP 5.
			## 쿠폰 지급(자동 옵션인 경우)
			if($this->field['BOARD_INFO']['bi_point_use'] == "Y" && $this->field['BOARD_INFO']['bi_coupon_c_use'] == "Y" && $this->field['BOARD_INFO']['bi_coupon_c_give'] == "A"):
				$param['give_type'] = $this->field['BOARD_INFO']['bi_coupon_c_give'];
				$this->getCouponGiveKindEx($param);	
			endif;
		}


		/**
		 * getCouponGiveProcess()
		 * (관리자 페이지에서)쿠폰 지급 프로세스
		 * **/
		function getCouponGiveProcess() {
	
			## STEP 1.
			## 쿠폰 설정 정보 불러오기.
			$eventInfoView			= new CommunityEventInfoView($this->db, $this->field);
			$eventInfoResult		= $eventInfoView->getAryListEx();

			## STEP 2.
			## 쿠폰 발급 유무 체크
			if($eventInfoResult['BI_COUPON_C_USE'] != "Y"):
				echo "관리자에게 문의하세요. 커뮤니티 게시판에 쿠폰 지급 설정이 off 되어 있습니다.";
				exit;
			endif;


			## STEP 3.
			## 쿠폰 설정 정보 가져오기.
			$param['gm_no']					= $this->field['cm_coupon_gm_no'];
			$giftView						= new CommunityGiftView($this->db, $this->field);
			$giftViewRow					= $giftView->getSelectEx($param);

			## STEP 4.
			## 포인트 지급.
			$param['list']		= $this->field['check'];
			$param['count']		= $giftViewRow['GM_MAX'];
			$param['memo']		= $giftViewRow['GM_TITLE'];
			$param['coupon']	= $giftViewRow['GM_DATA'];
			$param['gm_no']		= $giftViewRow['GM_NO'];
			$param['b_code']	= $this->field['b_code'];
			$this->getCouponGiveEx($param);	
			
//			## STEP 1.
//			## 체크박스에 체크된 게시글에 쿠폰 지급
//			$param['give_type'] = $this->field['BOARD_INFO']['bi_coupon_c_give'];
//			$this->getCouponGiveKindEx($param);		
		}

		/**
		 * getPointGiveProcess()
		 * (관리자 페이지에서)포인트 지급 프로세스
		 * **/
		function getPointGiveProcess() {

			## STEP 1.
			## 포인트 설정 정보 불러오기.
			$eventInfoView			= new CommunityEventInfoView($this->db, $this->field);
			$eventInfoResult		= $eventInfoView->getAryListEx();
			
			## STEP 2.
			## 포인트 발급 유무 체크
			if($eventInfoResult['BI_POINT_C_USE'] != "Y"):
				echo "관리자에게 문의하세요. 커뮤니티 게시판에 포인트 지급 설정이 off 되어 있습니다.";
				exit;
			endif;

			## STEP 3.
			## 쿠폰 설정 정보 가져오기.
			$param['gm_no']					= $this->field['cm_point_gm_no'];
			$giftView						= new CommunityGiftView($this->db, $this->field);
			$giftViewRow					= $giftView->getSelectEx($param);

			## STEP 4.
			## 포인트 지급.
			$param['list']		= $this->field['check'];
			$param['count']		= $giftViewRow['GM_MAX'];
			$param['memo']		= $giftViewRow['GM_TITLE'];
			$param['point']		= $giftViewRow['GM_DATA'];
			$param['gm_no']		= $giftViewRow['GM_NO'];
			$param['b_code']	= $this->field['b_code'];
			$this->getPointGiveEx($param);	


//			## STEP 2.
//			## 포인트 지급.
//			$give_type = $eventInfoResult['BI_POINT_C_GIVE'];
//			if($give_type == "M"):
//				// 수동 포인트 지급
//				$param['list']	= $this->field['check'];
//				$param['memo']	= "커뮤니티 댓글 작성 포인트 지급(BOARD_CM_{$this->field['b_code']})";;
//				$param['point'] = $giftViewRow['GM_DATA'];
//				$param['gm_no']	= $giftViewRow['GM_NO'];
//				$this->getPointGiveEx($param);	
//			elseif($give_type == "T"):
//				// 차등 포인트 지급
//				
//				/** 인원수 체크 **/
//				$checkCnt	= sizeof($_POST['check']);
////				$multiNo	= $this->field['bi_point_c_multi_no'];
//				$multiMax	= $giftViewRow['GM_MAX'];
//				if($checkCnt > $multiMax):
//					echo "인원수 초과!!";
//					exit;
//				endif;
//
//				/** 포인트 발급 **/
//				$param['list']		= $this->field['check'];
//				$param['count']		= $giftViewRow['GM_MAX'];
//				$param['memo']		= $giftViewRow['GM_TITLE'];
//				$param['point']		= $giftViewRow['GM_DATA'];
//				$param['gm_no']		= $giftViewRow['GM_NO'];
//				$this->getPointGiveEx($param);		
//			endif;
		}



		function getPointGiveKindEx($paramData) {
			if($paramData['give_type'] == "A"):
				// 자동 포인트 지급
				$param['list']	= array($this->field['cm_no']);
				$param['memo']	= "커뮤니티 댓글 작성 포인트 지급(BOARD_CM_{$this->field['b_code']})";;
				$param['point'] = $this->field['BOARD_INFO']['bi_point_c_mark'];	
				$this->getPointGiveEx($param);
			elseif($paramData['give_type'] == "M"):
				// 수동 포인트 지급
				$param['list']	= $this->field['check'];
				$param['memo']	= "커뮤니티 댓글 작성 포인트 지급(BOARD_CM_{$this->field['b_code']})";;
				$param['point'] = $this->field['BOARD_INFO']['bi_point_c_mark'];	
				$this->getPointGiveEx($param);
			elseif($paramData['give_type'] == "T"):
				// 다중 포인트 지급
				$param['list']	= $this->field['check'];
				$no				= $this->field['bi_point_c_multi_no'];
				$param['count'] = $this->field['BOARD_INFO']['bi_point_c_multi_count'][$no];
				$param['memo']	= $this->field['BOARD_INFO']['bi_point_c_multi_title'][$no];
				$param['point'] = $this->field['BOARD_INFO']['bi_point_c_multi_point'][$no];	
				$this->getPointGiveEx($param);
			else:
				echo "포인트를 발급 할 수 없습니다.";
				return;
			endif;
		}

		function getCouponGiveKindEx($paramData) {
			if($paramData['give_type'] == "A"):
				// 자동 포인트 지급
				$param['list']		= array($this->field['cm_no']);
				$param['memo']		= "커뮤니티 글 작성 쿠폰 지급(BOARD_CM_{$this->field['b_code']})";;
				$param['coupon']	= $this->field['BOARD_INFO']['bi_coupon_c_coupon'];	
				$this->getCouponGiveEx($param);
			elseif($paramData['give_type'] == "M"):
				// 수동 포인트 지급
				$param['list']		= $this->field['check'];
				$param['memo']		= "커뮤니티 글 작성 쿠폰 지급(BOARD_CM_{$this->field['b_code']})";;
				$param['coupon']	= $this->field['BOARD_INFO']['bi_coupon_c_coupon'];	
				$this->getCouponGiveEx($param);
			elseif($paramData['give_type'] == "T"):
				// 다중 포인트 지급
				$param['list']		= $this->field['check'];
				$no					= $this->field['bi_coupon_c_multi_no'];
				$param['count']		= $this->field['BOARD_INFO']['bi_coupon_c_multi_count'][$no];
				$param['memo']		= $this->field['BOARD_INFO']['bi_coupon_c_multi_title'][$no];
				$param['coupon']	= $this->field['BOARD_INFO']['bi_coupon_c_multi_coupon'][$no];	
				$this->getCouponGiveEx($param);
			else:
				echo "포인트를 발급 할 수 없습니다.";
				return;
			endif;	
		}

		/**
		 * getCouponGiveEx($paramData)
		 * 쿠폰 지급
		 * 발급 개수 지정이 안됨.(추후 작업)
		 * **/
		function getCouponGiveEx($paramData) {
			$commentView					= new CommunityEventCommentView($this->db, $this->field);
			$client							= new ClientInfo();	
			$couponIssueController			= new CouponIssueController($this->db, $this->field);
			$couponDataController			= new CouponDataController($this->db, $this->field);
			$memberController				= new MemberDataController($this->db, $this->field);

			foreach($paramData['list'] as $cm_no):
				## STEP 1.
				## 커뮤니티 데이터 가져오기
				$dataParam['b_code']			= $this->field['b_code'];
				$dataParam['ub_no']				= $ub_no;
//				$commentView					= new CommunityCommentView($this->db, $this->field);
				$dataSelectRow					= $commentView->getSelectEx($dataParam);
				if($dataSelectRow['CM_CI_NO']):
					// 이미 발급된 게시글
					continue;
				endif;

				## STEP 2.
				## 쿠폰 지급 체크 1회 이상 지급 안됨.
				## 2013.04.09 커뮤니티 글인 경우 1회 이상 지급 안됨으로 설졍할 경우, 1회성 쿠폰 지급으로 끝나기 때문에 사용 못함.

				## STEP 3.
				## 쿠폰 번호 생성			
				$cu_no							= $paramData['coupon'];
//				$couponIssueController			= new CouponIssueController($this->db, $this->field);
				$cl_code						= $couponIssueController->getMakeCiCode($cu_no);
				if(!$cl_code):
					echo  "쿠폰 번호를 받아올수 없습니다. 오류 처리..";
					exit;
				endif;

				## STEP 4.
				## 쿠폰 지급
				$couponParam['m_no']			= $dataSelectRow['CM_M_NO'];
				$couponParam['cu_no']			= $cu_no;
				$couponParam['b_no']			= $ub_no;
				$couponParam['ci_code']			= $cl_code;
				$couponParam['ci_memo']			= $paramData['memo'];
				$couponParam['ci_reg_no']		= $this->field['member_no'];	
				$cm_ci_no						= $couponIssueController->getWriteEx($couponParam);	

				/* 커뮤니티 작성 글에 쿠폰 번호 업데이트 */
				$dataParam2						= "";
				$dataParam2['b_code']			= $this->field['b_code'];
				$dataParam2['cm_no']			= $cm_no;
				$dataParam2['cm_ci_no']			= $cm_ci_no;
				$dataParam2['cm_coupon_gm_no']	= $paramData['gm_no'];
				$dataParam2['cm_winner']		= "Y";
				$this->getCouponUpdateEx($dataParam2);
			endforeach;
		}

		function getCouponCancelEx($paramData) {
			$commentView					= new CommunityEventCommentView($this->db, $this->field);
			$client							= new ClientInfo();	
			$couponIssueController			= new CouponIssueController($this->db, $this->field);
			$couponDataController			= new CouponDataController($this->db, $this->field);
			$memberController				= new MemberDataController($this->db, $this->field);


			foreach($paramData['list'] as $cm_no):
				## STEP 1.
				## 커뮤니티 데이터 가져오기
				$dataParam['b_code']			= $this->field['b_code'];
				$dataParam['ub_no']				= $ub_no;
				$dataSelectRow					= $commentView->getSelectEx($dataParam);
				if(!$dataSelectRow['CM_CI_NO']):
					// 발급된 쿠폰이 없습니다.
//					continue;
				endif;

				## STEP 2.
				## 쿠폰 발급 정보 삭제(쿠폰 테이블)
				$param							= "";
				$param['ci_no']					= $dataSelectRow['CM_CI_NO'];
				$cl_code						= $couponIssueController->getDeleteEx($param);

				## STEP 3.
				## 쿠폰 발급 정보 삭제(코멘트 테이블)
				$dataParam2						= "";
				$dataParam2['b_code']			= $this->field['b_code'];
				$dataParam2['cm_no']			= $cm_no;
				$dataParam2['cm_ci_no']			= "";
				$dataParam2['cm_coupon_gm_no']	= "";
				$dataParam2['cm_winner']		= ($dataSelectRow['CM_PT_NO']) ? "Y" : "N";
				$this->getCouponUpdateEx($dataParam2);
			endforeach;
		}

		/**
		 * getPointCancelEx($paramData)
		 * 포인트 발급 취소
		 * **/
		function getPointCancelEx($paramData) {
			$commentView					= new CommunityEventCommentView($this->db, $this->field);
			$pointDataView					= new PointDataView($this->db, $this->field);
			$client							= new ClientInfo();	
			$pointDataController			= new PointDataController($this->db, $this->field);
			$memberController				= new MemberDataController($this->db, $this->field);

			foreach($paramData['list'] as $cm_no):
				## STEP 1.
				## 커뮤니티 데이터 가져오기
				$dataParam['b_code']			= $paramData['b_code'];
				$dataParam['cm_no']				= $cm_no;
				$dataSelectRow					= $commentView->getSelectEx($dataParam);

				## STEP 2.
				## 포인트 발급이 된 회원인지 체크
				if(!$dataSelectRow['CM_PT_NO']):
//					echo "포인트 발급 정보가 없는 회원입니다.(확인)";
//					exit;
					continue;
				endif;

				## STEP 4.
				## 발급된 포인트 정보 가져오기.
				$param							= "";
				$param['pt_no']					= $dataSelectRow['CM_PT_NO'];
				$pointDataViewRow				= $pointDataView->getSelectEx($param);
				
				## STEP 5.
				## 포인트 지급
				$pointParam['m_no']				= $dataSelectRow['CM_M_NO'];
				$pointParam['b_no']				= $dataSelectRow['CM_NO'];
				$pointParam['o_no']				= 0;
				$pointParam['pt_type']			= "005";													// (005 : 이벤트포인트차감)
				$pointParam['pt_point']			= -($pointDataViewRow['PT_POINT']);
				$pointParam['pt_memo']			= $paramData['memo'];
				$pointParam['pt_etc']			= $pointDataViewRow['PT_ETC'];								// 지급방식, 테이블 명, 댓글 번호
				$pointParam['pt_start_dt']		= date("Y-m-d");
//				$pointParam['pt_end_dt']		= date("Y-m-d"); /** 2013.05.28 소멸 일자 변경 **/
				$pointParam['pt_end_dt']		= date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")+$S_POINT_USE_YEAR));			
				$pointParam['pt_reg_ip']		= $client->getClientIP();
				$pointParam['pt_reg_no']		= $this->field['member_no'];
				$cm_pt_no						= $pointDataController->getWriteEx($pointParam);

				## STEP 3.
				## 회원 테이블에 포인트 지급(업데이트)
				$memberPointParam['m_point']	= -($pointDataViewRow['PT_POINT']);
				$memberPointParam['m_no']		= $dataSelectRow['CM_M_NO'];
				$memberController->getPointUpdateEx($memberPointParam);

				/* 커뮤니티 작성 글에 포인트 번호 업데이트 */
				$dataParam2						= "";
				$dataParam2['b_code']			= $this->field['b_code'];
				$dataParam2['cm_no']			= $cm_no;
				$dataParam2['cm_pt_no']			= "";
				$dataParam2['cm_point_gm_no']	= "";
				$dataParam2['cm_winner']		= ($dataSelectRow['CM_CI_NO']) ? "Y" : "N";
				$this->getPointUpdateEx($dataParam2);
			endforeach;
		}

		/**
		 * getPointGiveEx()
		 * 포인트 지급
		 * 발급 개수 지정이 안됨.(추후 작업)
		 * **/
		function getPointGiveEx($paramData) {
			$commentView					= new CommunityEventCommentView($this->db, $this->field);
			$client							= new ClientInfo();	
			$pointDataController			= new PointDataController($this->db, $this->field);
			$memberController				= new MemberDataController($this->db, $this->field);

			foreach($paramData['list'] as $cm_no):
				## STEP 1.
				## 커뮤니티 데이터 가져오기
				$dataParam['b_code']			= $paramData['b_code'];
				$dataParam['cm_no']				= $cm_no;
//				$commentView					= $this->CommunityCommentView();
				$dataSelectRow					= $commentView->getSelectEx($dataParam);

				if($dataSelectRow['CM_PT_NO']):
					// 이미 발급된 게시글
					continue;
				endif;

				## STEP 2.
				## 포인트 지급 체크 1회 이상 지급 안됨.
				## 2013.04.09 커뮤니티 글인 경우 1회 이상 지급 안됨으로 설졍할 경우, 1회성 포인트 지급으로 끝나기 때문에 사용 못함.

				## STEP 3.
				## 포인트 지급
				$pointParam['m_no']				= $dataSelectRow['CM_M_NO'];
				$pointParam['b_no']				= $dataSelectRow['CM_NO'];
				$pointParam['o_no']				= 0;
				$pointParam['pt_type']			= "004";
//				$pointParam['pt_point']			= $this->field['BOARD_INFO']['bi_point_w_mark']; 
				$pointParam['pt_point']			= $paramData['point'];
//				$pointParam['pt_memo']			= "커뮤니티 글 작성 포인트 지급(BOARD_CM_{$this->field['b_code']})";
				$pointParam['pt_memo']			= $paramData['memo'];
				$pointParam['pt_etc']			= "{$this->field['BOARD_INFO']['bi_point_c_give']},{$this->field['b_code']},{$cm_no}";	// 지급방식, 테이블 명, 댓글 번호
				$pointParam['pt_start_dt']		= date("Y-m-d");
//				$pointParam['pt_end_dt']		= date("Y-m-d"); /** 2013.05.28 소멸 일자 변경 **/
				$pointParam['pt_end_dt']		= date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")+$S_POINT_USE_YEAR));			
//				$client							= new ClientInfo();		
				$pointParam['pt_reg_ip']		= $client->getClientIP();
				$pointParam['pt_reg_no']		= $this->field['member_no'];
//				$pointDataController			= new PointDataController($this->db, $this->field);
				$cm_pt_no						= $pointDataController->getWriteEx($pointParam);

				## STEP 3.
				## 회원 테이블에 포인트 지급(업데이트)
				$memberPointParam['m_point']	= $paramData['point'];
				$memberPointParam['m_no']		= $dataSelectRow['CM_M_NO'];
//				$memberController				= new MemberDataController($this->module->db, $this->field);
				$memberController->getPointUpdateEx($memberPointParam);

				/* 커뮤니티 작성 글에 포인트 번호 업데이트 */
				$dataParam2						= "";
				$dataParam2['b_code']			= $this->field['b_code'];
				$dataParam2['cm_no']			= $cm_no;
				$dataParam2['cm_pt_no']			= $cm_pt_no;
				$dataParam2['cm_point_gm_no']	= $paramData['gm_no'];
				$dataParam2['cm_winner']		= "Y";
				$this->getPointUpdateEx($dataParam2);
			endforeach;
		}

		/**
		 * getPointUpdateEx($paramData)
		 * 포인트 지급 업데이트
		 * **/
		function getPointUpdateEx($paramData) {
			return $this->module->getPointUpdateEx($paramData);
		}

		/**
		 * getCouponUpdateEx($paramData)
		 * 쿠폰 지급 업데이트
		 * **/
		function getCouponUpdateEx($paramData) {
			return $this->module->getCouponUpdateEx($paramData);
		}

		/**
		 * getDataAuthCheck()
		 * 데이터 권한 체크
		 * **/
		function getDataAuthCheck() {
			## STEP 1.
			## 회원 정보 로드
			$selectRow					= $this->getSelect();
			$selectRow['name']			= $this->name;
			$auth						= $this->getAuthCheck($selectRow);
			$this->field['dataAuth']	= $auth;
		}

		/**
		 * getAuthCheck(&$row)
		 * $auth['member']	= 0		=> 비회원
		 * $auth['member']	= 1		=>   회원
		 * $auth['check']	= 0		=> 권한 없음
		 * $auth['check']	= 1		=> 권한 있음
		 * 2013.03.25 버전
		 * 2013.04.11 community.view.php 으로 이동
		 * 2013.04.17 comment 는 table 컬럼명이 틀려서 다시 복구
		 * **/	
		function getAuthCheck(&$row) {
			
			if($row['CM_M_NO'])																						{ $auth['member'] = "1"; } // 회원글
//			elseif($this->field['member_login'] && in_array($this->field['member_type'], array("A", "S")))			{ $auth['member'] = "1"; } // 관리자 로그인을 했다면 1
			else																									{ $auth['member'] = "0"; } // 비회원 글

			if($this->field['member_login'] && $row['CM_M_NO'] && $this->field['member_no'] == $row['CM_M_NO'])					{ $auth['check'] = "1"; }	// 회원이 작성한 글과 로그인 한 회원이 같으면 1
			elseif($this->field['cm_pass'] && $row['CM_PASS'] && $this->field['cm_pass'] == $row['CM_PASS']) 					{ $auth['check'] = "1"; }	// 비회원이 작성한 글과 비밀번호가     같으면 1
			elseif($this->field['cm_pass_check'] && $row['CM_PASS'] && $this->field['cm_pass_check'] == $row['CM_PASS']) 		{ $auth['check'] = "1"; }	// 비회원이 작성한 글과 비밀번호가     같으면 1
			elseif($this->field['b_code'] == $_SESSION['b_code'] && $this->field['cm_no'] == $_SESSION['cm_no'])				{ $auth['check'] = "1"; }	// 세션 정보와 작성한 글의 정보가	   같으면 1
//			elseif($this->field['member_login'] && in_array($this->field['member_type'], array("A", "S")))						{ $auth['check'] = "1"; }	// 관리자 로그인을 했다면 1
			elseif($this->field['member_login'] && $this->field['member_group'] == "001")										{ $auth['check'] = "1"; }	// 관리자 로그인을 했다면 1
			else																												{ $auth['check'] = "0"; }	// 권한이 필요한 경우.

			if($auth['check'] == 0 && $row['UB_ANS_NO'] != $row['UB_NO']):
				$ub_no_bak				= $this->field['ub_no'];
				$this->field['ub_no']	=  $row['UB_ANS_NO'];
				$ansRow = $this->getSelect();
				$this->field['ub_no']	= $ub_no_bak;
				return $this->getAuthCheck($ansRow);	// 재귀호출
			endif;

			return $auth;
		}

//		/**
//		 * getAuthCheck(&$row)
//		 * $auth['member']	= 0		=> 비회원
//		 * $auth['member']	= 1		=>   회원
//		 * $auth['check']	= 0		=> 권한 없음
//		 * $auth['check']	= 1		=> 권한 있음
//		 * **/	
//		function getAuthCheck(&$row) {
//			
//			if($row['CM_M_NO']) { $auth['member'] = "1"; }
//			else				{ $auth['member'] = "0"; }
//
//			if($this->field['member_login'] && $row['CM_M_NO'] && $this->field['member_no'] == $row['CM_M_NO'])					{ $auth['check'] = "1"; }	// 회원이 작성한 글과 로그인 한 회원이 같으면 0
//			elseif($this->field['cm_pass'] && $row['CM_PASS'] && $this->field['cm_pass'] == $row['CM_PASS']) 					{ $auth['check'] = "1"; }	// 비회원이 작성한 글과 비밀번호가     같으면 0
//			elseif($this->field['cm_pass_check'] && $row['CM_PASS'] && $this->field['cm_pass_check'] == $row['CM_PASS']) 		{ $auth['check'] = "1"; }	// 비회원이 작성한 글과 비밀번호가     같으면 0
//			else																												{ $auth['check'] = "0"; }	// 권한이 필요한 경우.
//
//			return $auth;
//		}

		/**
		 * getMessage()
		 * 메시지
		 * **/
		function getMessage() {
			echo "community event comment controller class (basic.1.0)";
		}

		/**
		 * getUploadServerPath()
		 * 업로드 경로
		 * **/
		function getUploadServerPath() {
		}

		/**
		 * getWrite()
		 * 데이터 등록
		 * **/
		function getWrite() {

			## STEP 1.
			## 회원 정보 설정
			if($this->field['member_login']):
				// 회원
				if(!$this->field['cm_name']):
					$this->field['cm_name']	= $this->field['member_name'];				// 이름
				endif;

				$this->field['cm_m_id']		= $this->field['member_id'];				// 아이디
				$this->field['cm_mail']		= $this->field['member_mail'];				// 이메일
			endif;

			## STEP 2.
			## 설정
			$client						= new ClientInfo();	
			$this->field['cm_ub_no']	= $this->field['ub_no'];
			$this->field['cm_ip']		= $client->getClientIP();					// 아이피
			$this->field['cm_func']		= $this->getCM_FUNC_ENCODER();				// 기능함수
			$this->field['cm_m_no']		= $this->field['member_no'];				// 작성자
			$this->field['cm_reg_no']	= $this->field['member_no'];				// 작성자
			$this->field['cm_mod_no']	= $this->field['member_no'];				// 수정자
			$this->field['cm_ans_no']	= "CM_NO";
			$this->field['ub_ans_step']	= "";

			## STEP 3.
			## 기록
			$this->field['cm_no']		=  parent::getWrite();	
			parent::getAnsNoUpdate();

			## STEP 4.
			## 포인트 지급
			## 조건1. 회원인 경우 지급
			if($this->field['member_login']):
				$this->getPointGive();	
			endif;

			##STEP 4.
			## JSON 요청시
			if($this->field['mode'] == "json"):
				$string						= new StringFunc();
				$result						= null;
				$result['mode']				= 1;
				$result['data']['cm_no']	= $this->field['cm_no'];
				$result['data']['cm_name']	= $this->field['cm_name'];
				$result['data']['cm_m_id']	= $this->field['cm_m_id'];
				$result['data']['cm_mail']	= $this->field['cm_mail'];
				$result['data']['cm_func']	= $this->field['cm_func'];
				$result['data']['cm_m_no']	= $this->field['cm_m_no'];
				$result['data']['cm_title']	= $this->field['cm_title'];
				$result['data']['cm_text']	= $string->strConvertCut($this->field['cm_text'],0, "N");
			else:
				$result						= $re;
			endif;

			$this->field['result']			= $result;
		}

		/**
		 * getModify()
		 * 데이터 수정
		 * **/
		function getModify() {
			## STEP 1.
			## 권한 체크
			if(!$this->field['dataAuth']['check']):
				if($this->field['mode'] == "json"):
					$result						= null;
					$result['mode']				= 0;
					$result['data']['cm_no']	= $this->field['cm_no'];
					$this->field['result']		= $result;
					return;
				endif;
				$this->field['mode']			= "dataPassword";
				$this->field['act']				= "";
				$this->field['password_mode']	= "dataDelete";
				$this->field['password_act']	= "goAct";
				return;
			endif;


			## STEP 2.
			## 회원 정보 설정
			if($this->field['member_login']):
				// 회원
				if(!$this->field['cm_name']):
					$this->field['cm_name']	= $this->field['member_name'];				// 이름
				endif;

				$this->field['cm_m_id']		= $this->field['member_id'];				// 아이디
				$this->field['cm_mail']		= $this->field['member_mail'];				// 이메일
			endif;

			## STEP 3.
			## 설정
			$client							= new ClientInfo();			
			$this->field['cm_ip']			= $client->getClientIP();					// 아이피
			$this->field['cm_mod_no']		= $this->field['member_no'];				// 수정자
	//		$this->field['cm_mail']			= $this->field['member_mail'];				// 이메일
			$this->field['cm_func']			= $this->getCM_FUNC_ENCODER();				// 기능함수
			if($this->field['cm_text_modify']):
				$this->field['cm_text'] = $this->field['cm_text_modify'];
				$this->field['cm_name'] = $this->field['cm_name_modify'];
				$this->field['cm_pass'] = $this->field['cm_pass_modify'];
			endif;

			## STEP 4.
			## 데이터 불러오기
			$selectRow						= $this->getSelect();
			$this->field['cm_name']			= $selectRow['CM_NAME'];
			$this->field['cm_m_no']			= $selectRow['CM_M_NO'];


			## STEP 5.
			## 수정
			$re								= parent::getModify();

			##STEP 6.
			## JSON 요청시
			if($this->field['mode'] == "json"):
				$string						= new StringFunc();
				$result						= null;
				$result['mode']				= 1;
				$result['data']['cm_no']	= $this->field['cm_no'];
				$result['data']['cm_name']	= $this->field['cm_name'];
				$result['data']['cm_m_id']	= $this->field['cm_m_id'];
				$result['data']['cm_mail']	= $this->field['cm_mail'];
				$result['data']['cm_func']	= $this->field['cm_func'];
				$result['data']['cm_m_no']	= $this->field['cm_m_no'];
				$result['data']['cm_title']	= $this->field['cm_title'];
				$result['data']['cm_text']	= $string->strConvertCut($this->field['cm_text'],0, "N");
			else:
				$result						= $re;
			endif;

			$this->field['result']			= $result;
		}

		/**
		 * getDelete()
		 * 데이터 삭제
		 * **/
		function getDelete() {

			## STEP 1.
			## 권한 체크
			if(!$this->field['dataAuth']['check']):
				if($this->field['mode'] == "json"):
					$result						= null;
					$result['mode']				= 0;
					$result['data']['cm_no']	= $this->field['cm_no'];
					$this->field['result']		= $result;
					return;
				endif;
				$this->field['mode']			= "dataPassword";
				$this->field['act']				= "";
				$this->field['password_mode']	= "dataDelete";
				$this->field['password_act']	= "goAct";
				return;
			endif;
			
			if($this->field["cm_pass_check"]):
				$this->field["cm_pass"] = $this->field["cm_pass_check"];
			endif;

			## STEP 2.
			## 데이터 가져오기
//			$selectRow			= $this->getSelect();
//			$resultMode			= 1;

			## STEP 2.
			## 포인트 반환.
			$this->getPointReturn();

			## STEP 3.
			## 삭제
			$re					= parent::getDelete("OP_CM_NO");	

			##STEP 4.
			## JSON 요청시
			if($this->field['mode'] == "json"):
				$result						= null;
				$result['mode']				= $re;
				$result['data']['cm_no']	= $this->field['cm_no'];
			else:
				$result						= $re;
			endif;

			$this->field['result']			= $result;

		}

		/**
		 * getDeleteUB()
		 * 데이터 삭제(커뮤니티 글 삭제시, 관련 코멘트 내용 모두 삭제)
		 * **/
		function getDeleteToUB_NO() {

			## STEP 1.
			## 권한 체크
			if(!$this->field['dataAuth']['check']) { return; }

			## STEP 1.
			## 코멘트 사용 유무 체크
			if(!is_array($this->field['BOARD_INFO']['bi_comment_use'], array("B","S"))) {	return;		}
	
			## STEP 2.
			## 관련 코멘트 내용 모두 삭제
			$this->field['cm_table']		= "BOARD_CM_{$this->field['b_code']}";
			$this->field['cm_ub_no']		= $this->field['ub_no'];
			
			return parent::getDelete("OP_CM_UB_NO");
		}

		/**
		 * getPassword()
		 * 작성된 글의 비밀번호와 사용자가 입력한 비밀번호가 같은지 체크
		 * Json mode 만 사용 가능
		 * **/
		function getPassword() {
	
			## STEP 1.
			## 게시글 SELECT
			$selectRow			= $this->getSelect();

			## STEP 2.
			## 비밀번호 체크
			$resultMode					= 0;
			$_SESSION['b_code']			= "";
			$_SESSION['ub_no']			= "";
			if($selectRow['CM_PASS'] == $this->field['cm_pass_check']):
				$resultMode				= 1; 
				$_SESSION['b_code']		= $this->field['b_code'];
				$_SESSION['cm_no']		= $selectRow['CM_NO'];
			endif;

			##STEP 3.
			## JSON 요청시
			if($this->field['mode'] == "json"):
				$result						= null;
				$result['mode']				= $resultMode;
				$result['data']['cm_no']	= $selectRow['CM_NO'];
				$result['data']['cm_name']	= $selectRow['CM_NAME'];
				$result['data']['cm_m_id']	= $selectRow['CM_M_ID'];
				$result['data']['cm_mail']	= $selectRow['CM_MAIL'];
				$result['data']['cm_func']	= $selectRow['CM_FUNC'];
				$result['data']['cm_m_no']	= $selectRow['CM_M_NO'];
				$result['data']['cm_title']	= $selectRow['CM_TITLE'];
				$result['data']['cm_text']	= $selectRow['CM_TEXT'];
				$this->field['result']		= $result;
			endif;
		}

		/**
		 * getSelect()
		 * 데이터 정보
		 * **/
		function getSelect() {
			$this->field['cm_table']	= "BOARD_CM_{$this->field['b_code']}";
			$selectRow					= parent::getSelect();	
			$aryFunc					= $this->getCM_FUNC_DECODER($selectRow);
			$selectRow['CM_FUNC']		= $aryFunc;
			return $selectRow;
		}

		function getModifyEdit() {
			## STEP 1.
			## 권한 체크
			if(!$this->field['dataAuth']['check']):
				if($this->field['mode'] == "json"):
					$result						= null;
					$result['mode']				= 0;
					$result['data']['cm_no']	= $this->field['cm_no'];
					$this->field['result']		= $result;
					return;
				endif;
				$this->field['mode']			= "dataPassword";
				$this->field['act']				= "";
				$this->field['password_mode']	= "dataDelete";
				$this->field['password_act']	= "goAct";
				return;
			endif;


			## STEP 2.
			## 데이터 불러오기
			$selectRow					= $this->getSelect();

			##STEP 3.
			## JSON 요청시
			if($this->field['mode'] == "json"):
				$result						= null;
				$result['mode']				= 1;
				$result['data']['cm_no']	= $selectRow['CM_NO'];
				$result['data']['cm_name']	= $selectRow['CM_NAME'];
				$result['data']['cm_m_id']	= $selectRow['CM_M_ID'];
				$result['data']['cm_mail']	= $selectRow['CM_MAIL'];
				$result['data']['cm_func']	= $selectRow['CM_FUNC'];
				$result['data']['cm_m_no']	= $selectRow['CM_M_NO'];
				$result['data']['cm_title']	= $selectRow['CM_TITLE'];
				$result['data']['cm_text']	= $selectRow['CM_TEXT'];
			else:
				$result						= $selectRow;
			endif;

			$this->field['result']			= $result;
		}

		/**
		 * getSelectForModify()
		 * 수정을 위한 데이터 정보 호출
		 * **/
		function getSelectForModify() {
			$this->field['cm_pass']		= $this->field['cm_pass_check'];
			$this->field['cm_table']	= "BOARD_CM_{$this->field['b_code']}";
			$arySelectRow				= parent::getSelect();	
			if(is_array($arySelectRow)):
				$resert['mode'] = 1;
				$resert['data'] = $arySelectRow;
			else:
				$resert['mode'] = null;
				$resert['data'] = null;
			endif;

			return $resert;
		}

		/** 
		 * getCreateTable()
		 * 테이블 생성
		 * **/
		function getCreateTable() {
			if(!$this->field['b_code'])					{ return; }
			if($this->field['bi_comment_use'] == "N")	{ return; }

			$strTableName				= strtoupper($this->field['b_code']);
			$this->field['tableName']	= "BOARD_CM_{$strTableName}";
			$intTableCnt				= $this->module->getSchemaTableSelect($this->field['tableName']);

			if($intTableCnt == 0) :	// 테이블이 없으면 실행
				return parent::getCreateTable();		
			endif;
		}

		/**
		 * getDropTable()
		 * 테이블 삭제
		 * 2013.04.10 커뮤니티 통합(상속 부분) 영역으로 변경
		 * **/
//		function getDropTable() {
//			$tableName		= "BOARD_CM_{$this->field['b_code']}";
//			$intTableCnt	= $this->module->getSchemaTableSelect($tableName);
//			if($intTableCnt > 0) : // 테이블이 있으면 실행
//				$param['tableName'] = $tableName;
//				return parent::getDropTable($param);	
//			endif;
//		}

		/**
		 * getCreateProcedure()
		 * 프로시저 생성
		 * **/
		function getCreateProcedure() {
		}

		/**
		 * getDropProcedure()
		 * 프로시저 삭제
		 * **/
		function getDropProcedure() {
		}

		/**
		 * getPointReturn()
		 * 포인트 반환
		 * **/
		function getPointReturn() {
			## STEP 1.
			## 사용 유무 체크
			if(!$this->field['member_login']) { return; }						// 비회원 포인트 지급 불가.
			$eventInfoView					= new CommunityEventInfoView($this->module->db, $this->field);
			$boardEventInfoAry				= $eventInfoView->getAryList();	
			if($boardEventInfoAry['BI_POINT_C_USE'] != "Y") { return; }			// 포인트 발급 사용 안할때.

			$eventView						= new CommunityEventView($this->module->db, $this->field);
			$commentView					= new CommunityEventCommentView($this->module->db, $this->field);
			$pointDataController			= new PointDataController($this->module->db, $this->field);
			$memberController				= new MemberDataController($this->module->db, $this->field);
			$client							= new ClientInfo();		

			$eventSelectRow					= $eventView->getSelect();	

			if(!is_array($this->field['check'])):
				$this->field['check'] = array($this->field['cm_no']);
			endif;

			## STEP 4.
			## 쓰기(insert)
//			$this->field['m_no']
//			$this->field['b_no']
			$this->field['o_no']			= 0;
			$this->field['pt_type']			= "005";
//			$this->field['pt_point']		= $pt_point;
			$this->field['pt_memo']			= "댓글 포인트 반환({$eventSelectRow['UB_TITLE']}) 파일 삭제";
			$this->field['pt_start_dt']		= date("Y-m-d");
//			$this->field['pt_end_dt']		= date("Y-m-d"); /** 2013.05.28 소멸 일자 변경 **/
			$this->field['pt_end_dt']		= date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")+$S_POINT_USE_YEAR));			
			$this->field['pt_reg_ip']		= $client->getClientIP();
//			$this->field['pt_etc']
			$this->field['pt_reg_no']		= $this->field['member_no'];	

			foreach($this->field['check'] as $cm_no):
				$this->field['cm_no']	= $cm_no;
				$commentSelectRow		= $commentView->getSelect();
				if(!$commentSelectRow['CM_PT_NO'] || $commentSelectRow['CM_PT_NO'] < 0) { continue; }		// 발급 내역이 없으면 종료.
				
				$this->field['m_no']		= $commentSelectRow['CM_M_NO'];
				$this->field['b_no']		= $commentSelectRow['CM_NO'];	
				$this->field['pt_point']	= "-{$commentSelectRow['PT_POINT']}";
				$this->field['pt_etc']		= "{$boardEventInfoAry['BI_POINT_C_GIVE']},{$this->field['b_code']},{$this->field['ub_no']},{$this->field['cm_no']}";	// 지급방식, 테이블 명, 게시글 번호, 댓글 번호
				$cm_pt_no					= $pointDataController->getWrite();	

				/* 회원 테이블에 포인트 업데이트 */
				$this->field['m_point']		= "-{$commentSelectRow['PT_POINT']}";
				$this->field['m_no']		= $commentSelectRow['CM_M_NO'];
				$memberController->getPointUpdate();
			endforeach;

		}

		/**
		 * getPointMGive()
		 * 포인트 지급
		 * **/
		function getPointGive() {

			## STEP 1.
			## 사용 유무 체크
			if(!$this->field['member_login']) { return; }						// 비회원 포인트 지급 불가.
			$eventInfoView					= new CommunityEventInfoView($this->module->db, $this->field);
			$boardEventInfoAry				= $eventInfoView->getAryList();	
			if($boardEventInfoAry['BI_POINT_C_USE'] != "Y") { return; }			// 포인트 발급 사용 안할때.
			if($boardEventInfoAry['BI_POINT_C_GIVE'] != "A" && $this->field['S_PAGE_AREA'] == "userPage") { return; }	// 포인트 자동 발급이 아닐때, 사용자 페이지에서 들어왔을 때, 발급 불가
			if($boardEventInfoAry['BI_POINT_C_GIVE'] == "A" && $this->field['S_PAGE_AREA'] == "adminPage") { return; }	// 포인트 자동 발급이면서 , 관리자 페이지에서 접속 했을 때, 발급  불가

			## STEP 2.
			## 선언
			$eventView						= new CommunityEventView($this->module->db, $this->field);
			$commentView					= new CommunityEventCommentView($this->module->db, $this->field);
			$pointDataController			= new PointDataController($this->module->db, $this->field);
			$memberController				= new MemberDataController($this->module->db, $this->field);
			$client							= new ClientInfo();		
			$eventSelectRow					= $eventView->getSelect();	

			/* 자동(A), 수동(M) = 고정값, 차등(T) = 멀티 포인트 */
			$pt_point						= $boardEventInfoAry['BI_POINT_C_MARK'];
			if($boardEventInfoAry['BI_POINT_C_GIVE'] == "T"):
				$no							= $this->field['bi_point_c_multi_no'];
				$pt_point					= $boardEventInfoAry["BI_POINT_C_MULTI_POINT_{$no}"];
			endif;

			## STEP 4.
			## 쓰기(insert)
//			$this->field['m_no']
//			$this->field['b_no']
			$this->field['o_no']			= 0;
			$this->field['pt_type']			= "004";
			$this->field['pt_point']		= $pt_point;
			$this->field['pt_memo']			= "댓글 포인트 지급({$eventSelectRow['UB_TITLE']})";
			$this->field['pt_start_dt']		= date("Y-m-d");
//			$this->field['pt_end_dt']		= date("Y-m-d"); /** 2013.05.28 소멸 일자 변경 **/
			$this->field['pt_end_dt']		= date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")+$S_POINT_USE_YEAR));	
			$this->field['pt_reg_ip']		= $client->getClientIP();
//			$this->field['pt_etc']
			$this->field['pt_reg_no']		= $this->field['member_no'];			
			
			if(!is_array($this->field['check'])):
				$this->field['check'] = array($this->field['cm_no']);
			endif;

			foreach($this->field['check'] as $cm_no):
				$this->field['cm_no']	= $cm_no;
				$commentSelectRow		= $commentView->getSelect();

				// 포인트 지급 체크 1회 이상 지급 안됨.
				$this->field['cm_m_no']		= $commentSelectRow['CM_M_NO'];
				$this->field['cm_ub_no']	= $this->field['ub_no'];
				if($commentView->getPointCount() > 0) { continue; }

				$this->field['m_no']	= $commentSelectRow['CM_M_NO'];
				$this->field['b_no']	= $commentSelectRow['CM_NO'];
				$this->field['pt_etc']	= "{$boardEventInfoAry['BI_POINT_C_GIVE']},{$this->field['b_code']},{$this->field['ub_no']},{$this->field['cm_no']}";	// 지급방식, 테이블 명, 게시글 번호, 댓글 번호
				$cm_pt_no				= $pointDataController->getWrite();	

				/* 회원 테이블에 포인트 업데이트 */
				$this->field['m_point']	= $pt_point;
				$this->field['m_no']	= $commentSelectRow['CM_M_NO'];
				$memberController->getPointUpdate();

				/* 댓글에 포인트 번호 업데이트 */
				$this->field['cm_pt_no']		= $cm_pt_no;
				$this->field['cm_winner']		= "Y";
				$this->getPointUpdate();
			endforeach;
		}

		/**
		 * getCouponGive()
		 * 쿠폰 지급
		 * **/
		function getCouponGive() {

			## STEP 1.
			## 사용 유무 체크
			if(!$this->field['member_login']) { return; }						// 비회원 포인트 지급 불가.
			$eventInfoView					= new CommunityEventInfoView($this->module->db, $this->field);
			$boardEventInfoAry				= $eventInfoView->getAryList();	
			if($boardEventInfoAry['BI_COUPON_C_USE'] != "Y") { return; }			// 포인트 발급 사용 안할때.
			if($boardEventInfoAry['BI_COUPON_C_GIVE'] != "A" && $this->field['S_PAGE_AREA'] == "userPage") { return; }	// 포인트 자동 발급이 아닐때, 사용자 페이지에서 들어왔을 때, 발급 불가
			if($boardEventInfoAry['BI_COUPON_C_GIVE'] == "A" && $this->field['S_PAGE_AREA'] == "adminPage") { return; }	// 포인트 자동 발급이면서 , 관리자 페이지에서 접속 했을 때, 발급  불가

			## STEP 2.
			## 선언
			$eventView						= new CommunityEventView($this->module->db, $this->field);
			$commentView					= new ommunityEventCommentView($this->module->db, $this->field);
			$couponDataController			= new CouponDataController($this->module->db, $this->field);
			$couponIssueController			= new CouponIssueController($this->module->db, $this->field);
			$memberController				= new MemberDataController($this->module->db, $this->field);
			$client							= new ClientInfo();		
			$eventSelectRow					= $eventView->getSelect();	
		
			## STEP 3.
			## 쿠폰 번호 생성			
			$cu_no							= $this->field['bi_coupon_c_coupon'];
			$cl_code						= $couponIssueController->getMakeCiCode($cu_no);
			if(!$cl_code):
				echo  "쿠폰 번호를 받아올수 없습니다. 오류 처리..";
				exit;
			endif;

			## STEP 4.
			## 쓰기(insert)
			$this->field['m_no']				= "";
//			$this->field['b_no']				= "";
			$this->field['cu_no']				= $cu_no;
			$this->field['ci_code']				= $cl_code;
			$this->field['ci_reg_no']			= $this->field['member_no'];		
			
			$this->field['cm_ub_no']			= $this->field['ub_no'];

			if(!is_array($this->field['check'])):
				$this->field['check'] = array($this->field['cm_no']);
			endif;

			foreach($this->field['check'] as $cm_no):
				$this->field['cm_no']	= $cm_no;
				$commentSelectRow		= $commentView->getSelect();

				// 포인트 지급 체크 1회 이상 지급 안됨.
				$this->field['cm_m_no']		= $commentSelectRow['CM_M_NO'];
				if($commentView->getCouponCount() > 0) { continue; }

				$this->field['b_no']	= $cm_no;
				$this->field['m_no']	= $commentSelectRow['CM_M_NO'];

				$this->field['ci_memo']	= "{$boardEventInfoAry['BI_COUPON_C_GIVE']},{$this->field['b_code']},{$this->field['ub_no']},{$this->field['cm_no']}";	// 지급방식, 테이블 명, 게시글 번호, 댓글 번호
				$cm_ci_no				= $couponIssueController->getWrite();	

				/* 댓글에 쿠폰 번호 업데이트 */
				$this->field['cm_ci_no']		= $cm_ci_no;
				$this->field['cm_winner']		= "Y";
				$this->getCouponUpdate();
				
			endforeach;

		}

		function getPointUpdate() {
			return parent::getPointUpdate();
		}

		function getCouponUpdate() {
			return parent::getCouponUpdate();
		}

		## 함수 모음 ##
		
		/**
		 * getCM_FUNC_ENCODER()
		 * 기능 함수
		 * **/
		function getCM_FUNC_ENCODER() {
			
			if(!$this->field['cm_func_notice']) { $this->field['cm_func_notice']	= "N"; }
			if(!$this->field['cm_func_lock'])   { $this->field['cm_func_lock']		= "N"; }

			$cm_func  = "";
			$cm_func .= $this->field['cm_func_notice'];		// 공지글 (사용:Y, 사용안함:N);
			$cm_func .= $this->field['cm_func_lock'];		// 비밀글 (사용:Y, 사용안함:N);
			$cm_func .= "N";
			$cm_func .= "N";
			$cm_func .= "N";
			$cm_func .= "N";
			$cm_func .= "N";
			$cm_func .= "N";
			$cm_func .= "N";
			$cm_func .= "N";

			return $cm_func;
		}

		/**
		 * getUpFileUpload()
		 * 파일 저장
		 * **/
		function getUpFileUpload() {
		}

		/**
		 * getCM_FUNC_DECODER()
		 * 기능 함수
		 * **/
		function getCM_FUNC_DECODER(&$row) {

			$data['CM_FUNC_NOTICE']		= $row['UB_FUNC'][0];
			$data['CM_FUNC_LOCK']		= $row['UB_FUNC'][1];

			return $data;
		}
    }
?>