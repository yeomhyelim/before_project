<?php
    /**
     * /home/shop_eng/www/modules/community/data/basic.1.0/community.data.controller.php
     * @author eumshop(thav@naver.com)
     * community data controller class (basic.1.0)
     * **/

	require_once MALL_HOME . "/modules/point/data/basic.1.0/point.data.controller.php";
	require_once MALL_HOME . "/modules/coupon/data/basic.1.0/coupon.data.controller.php";
	require_once MALL_HOME . "/modules/coupon/issue/basic.1.0/coupon.issue.controller.php";
	require_once MALL_HOME . "/modules/member/data/basic.1.0/member.data.controller.php";

	require_once MALL_HOME . "/modules/community/comment/basic.1.0/community.comment.view.php";
	require_once MALL_HOME . "/modules/community/attachedfile/basic.1.0/community.attachedfile.view.php";
	require_once MALL_HOME . "/modules/community/userfield/basic.1.0/community.userfield.view.php";
	require_once MALL_HOME . "/modules/community/eventInfo/basic.1.0/community.eventInfo.view.php";
	
	require_once MALL_HOME . "/modules/community/data/basic.1.0/community.data.view.php";
	require_once MALL_HOME . "/modules/community/event/basic.1.0/community.event.view.php";
	require_once MALL_HOME . "/modules/community/talk/basic.1.0/community.talk.view.php";
	require_once MALL_HOME . "/modules/community/product/basic.1.0/community.product.view.php";
	require_once MALL_HOME . "/modules/community/mypage/basic.1.0/community.mypage.view.php";

	require_once MALL_HOME . "/modules/community/community.controller.php";
	require_once MALL_HOME . "/modules/community/data/basic.1.0/community.data.module.php";

	require_once MALL_HOME . "/modules/community/board/basic.1.0/community.board.view.php";

	require_once MALL_HOME . "/classes/file/file.handler.class.php";
// 	require_once MALL_HOME . "/classes/client/client.info.class.php";

    class CommunityDataController extends CommunityController {

		/**
		 * __construct(&$db, &$field)
		 * 생성자
		 * **/
		function __construct(&$db, &$field) {
			$this->module	= new CommunityDataModule($db, $field);
			$this->name		="DataMgr";
			$this->db		= &$db;
			$this->field	= &$field;
			$this->getSessionInfo();
		}

		/**
		 * getMessage()
		 * 메시지
		 * **/
		function getMessage() {
			echo "community data controller class (basic.1.0)";
		}

		/**
		 * getWriteProcess()
		 * 커뮤니티 글 등록 프로세스
		 * **/
		function getWriteProcess() {

			## STEP 1.
			## 커뮤니티 글 등록
			$this->getWrite();	

			## STEP 2.
			## 커뮤니티 추가(사용자) 필드 글 등록
			$userfieldController	= new CommunityUserfieldController($this->db, $this->field);
			$userfieldController->getWrite();	

			## STEP 3.
			## 첨부파일 등록 및 업로드
			$attachedfileController	= new CommunityAttachedfileController($this->db, $this->field);
			$attachedfileController->getWrite();
			
			## STEP 4.
			## 포인트 지급(자동 옵션인 경우)
			if($this->field['BOARD_INFO']['bi_point_use'] == "Y" && $this->field['BOARD_INFO']['bi_point_w_use'] == "Y" && $this->field['BOARD_INFO']['bi_point_w_give'] == "A"):
				$param['give_type'] = $this->field['BOARD_INFO']['bi_point_w_give'];
				$pointGive			= new PointGive($this->db, $this->field);
				$pointGive->getDataView($this->getCommunityView());
				$pointGive->getDataController($this->getCommunityController());
//				$pointGive->getPointProcess($param);
			endif;
			
			## STEP 5.
			## 쿠폰 지급(자동 옵션인 경우)
			if($this->field['BOARD_INFO']['bi_point_use'] == "Y" && $this->field['BOARD_INFO']['bi_coupon_w_use'] == "Y" && $this->field['BOARD_INFO']['bi_coupon_w_give'] == "A"):
				$param['give_type'] = $this->field['BOARD_INFO']['bi_coupon_w_give'];
				$couponGive			= new CouponGive($this->db, $this->field);
				$couponGive->getDataView($this->getCommunityView());
				$couponGive->getDataController($this->getCommunityController());
				$couponGive->getCouponProcess($param);
			endif;


			## 2014.03.15 kim hee sung 내용 추가
			## SMS 관련 부분
			if($this->field['member_no'] && $this->field['b_code'] == "MY_QNA"):

				## 모듈 설정
				$objSms						= new SmsInfo($this->db);
				$objMemberMgrModule			= new MemberMgrModule($this->db);

				## SMS 정보 불러오기
				$strSmsCode					= "027";
				$param						= "";
				$param['{{고객명}}']		= $this->field['ub_name'];
				$param['{{게시판}}']		= $this->field['BOARD_INFO']['b_name'];
				$aryInfo					= $objSms->getSmsInfo($strSmsCode, $param);	
			endif;

			## SMS 발송을 승인한 경우
			if($aryInfo['SM_AUTO'] == "Y"):

				## 회원 정보 불러오기
				$param						= "";
				$param['M_NO']				= $this->field['member_no'];
				$aryMemberInfo				= $objMemberMgrModule->getMemberMgrSelectEx("OP_SELECT", $param);

				## 연락처 체크
				$strPhone					= $aryInfo['S_COM_HP'];
				if($strPhone):
					## 문자 전송
					$param						= "";
					$param['phone']				= $strPhone;
					$param['callBack']			= $aryMemberInfo['M_HP'];
					$param['msg']				= $aryInfo['SM_TEXT'];
					$param['siteName']			= $aryInfo['SITE_NAME'];
					$objSms->goSendSms($param);
				endif;
			endif;

		}

		/**
		 * getModifyProcess()
		 * 커뮤니티 글 수정 프로세스
		 * **/
		function getModifyProcess() {

			## STEP 1.
			## 수정
			$this->getModify();

			## STEP 2.
			## 사용자 필드
			$userfieldController	= new CommunityUserfieldController($this->db, $this->field);
			$userfieldController->getModify();	

			## STEP 3.
			## 첨부파일
			$attachedfileController	= new CommunityAttachedfileController($this->db, $this->field);
			$attachedfileController->getModify();
		}

		/**
		 * getPointGiveProcess()
		 * (관리자 페이지에서)포인트 지급 프로세스
		 * **/
		function getPointGiveProcess() {
			## STEP 1.
			## 체크박스에 체크된 게시글에 포인트 지급
			$param['give_type'] = $this->field['BOARD_INFO']['bi_point_w_give'];
			$this->getPointGiveKindEx($param);		
		}

		/**
		 * getCouponGiveProcess()
		 *(관리자 페이지에서)쿠폰 지급 프로세스
		 * **/
		function getCouponGiveProcess() {
			## STEP 1.
			## 체크박스에 체크된 게시글에 쿠폰 지급
			$param['give_type'] = $this->field['BOARD_INFO']['bi_coupon_w_give'];
			$this->getCouponGiveKindEx($param);		
		}

		/**
		 * getDataTransferProcess()
		 *(관리자 페이지에서)데이터 이동 프로세스
		 * **/
		function getDataTransferProcess() {
			
			## STEP 1.
			## 설정
			if(!is_array($this->field['check'])):
				echo "관리자에게 문의하세요.";
				exit;
			endif;

			## STEP 2.
			## 이동할 테이블 정보
			$boardView			= new CommunityBoardView($this->db, $this->field);
			$param['b_code']	= $this->field['b_code_transfer'];
			$boardInfoTransfer	= $boardView->getSelectEx($param);

			## STEP 3.
			## 체크
			## 게시판 종류가 틀리면 데이터 이동 할 수 없음.
			if($this->field['BOARD_INFO']['b_kind'] != $boardInfoTransfer['B_KIND']):
				echo "해당 게시판으로 데이터를 이동할 수 없습니다.";
				exit;
			endif;

			## STEP 4.
			## 체크
			## 데이터 이동
			$ub_no_list = "";
			foreach($this->field['check'] as $ub_no):
				if($ub_no_list) { $ub_no_list .= ","; }
				$ub_no_list .= $ub_no;
			endforeach;
			$dataView				= $this->getCommunityController($this->db, $this->field);
			$param['b_code_insert']	= $this->field['b_code_transfer'];
			$param['b_code_select']	= $this->field['b_code'];
			$param['ub_no_list']	= $ub_no_list;
			
			/** 커뮤니티 테이블 **/
			$dataView->getInsertSelect($param);
		}

		function getPointGiveKindEx($paramData) {
			if($paramData['give_type'] == "A"):
				// 자동 포인트 지급
				$param['list']	= array($this->field['ub_no']);
				$param['memo']	= "커뮤니티 글 작성 포인트 지급(BOARD_UB_{$this->field['b_code']})";;
				$param['point'] = $this->field['BOARD_INFO']['bi_point_w_mark'];	
				$this->getPointGiveEx($param);
			elseif($paramData['give_type'] == "M"):
				// 수동 포인트 지급
				$param['list']	= $this->field['check'];
				$param['memo']	= "커뮤니티 글 작성 포인트 지급(BOARD_UB_{$this->field['b_code']})";;
				$param['point'] = $this->field['BOARD_INFO']['bi_point_w_mark'];	
				$this->getPointGiveEx($param);
			elseif($paramData['give_type'] == "T"):
				// 다중 포인트 지급
				$param['list']	= $this->field['check'];
				$no				= $this->field['bi_point_w_multi_no'];
				$param['count'] = $this->field['BOARD_INFO']['bi_point_w_multi_count'][$no];
				$param['memo']	= $this->field['BOARD_INFO']['bi_point_w_multi_title'][$no];
				$param['point'] = $this->field['BOARD_INFO']['bi_point_w_multi_point'][$no];	
				$this->getPointGiveEx($param);
			else:
				echo "포인트를 발급 할 수 없습니다.";
				return;
			endif;
		}

		function getCouponGiveKindEx($paramData) {
			if($paramData['give_type'] == "A"):
				// 자동 포인트 지급
				$param['list']		= array($this->field['ub_no']);
				$param['memo']		= "커뮤니티 글 작성 쿠폰 지급(BOARD_UB_{$this->field['b_code']})";;
				$param['coupon']	= $this->field['BOARD_INFO']['bi_coupon_w_coupon'];	
				$this->getCouponGiveEx($param);
			elseif($paramData['give_type'] == "M"):
				// 수동 포인트 지급
				$param['list']		= $this->field['check'];
				$param['memo']		= "커뮤니티 글 작성 쿠폰 지급(BOARD_UB_{$this->field['b_code']})";;
				$param['coupon']	= $this->field['BOARD_INFO']['bi_coupon_w_coupon'];	
				$this->getCouponGiveEx($param);
			elseif($paramData['give_type'] == "T"):
				// 다중 포인트 지급
				$param['list']		= $this->field['check'];
				$no					= $this->field['bi_coupon_w_multi_no'];
				$param['count']		= $this->field['BOARD_INFO']['bi_coupon_w_multi_count'][$no];
				$param['memo']		= $this->field['BOARD_INFO']['bi_coupon_w_multi_title'][$no];
				$param['coupon']	= $this->field['BOARD_INFO']['bi_coupon_w_multi_coupon'][$no];	
				$this->getCouponGiveEx($param);
			else:
				echo "포인트를 발급 할 수 없습니다.";
				return;
			endif;	
		}

		function getCouponGiveEx($paramData) {
			$dataView						= $this->getCommunityView();
			$client							= new ClientInfo();	
			$couponIssueController			= new CouponIssueController($this->db, $this->field);
			$couponDataController			= new CouponDataController($this->db, $this->field);
			$memberController				= new MemberDataController($this->db, $this->field);

			foreach($paramData['list'] as $ub_no):
				## STEP 1.
				## 커뮤니티 데이터 가져오기
				$dataParam['b_code']			= $this->field['b_code'];
				$dataParam['ub_no']				= $ub_no;
//				$dataView						= $this->getCommunityView();
				$dataSelectRow					= $dataView->getSelectEx($dataParam);
				if($dataSelectRow['UB_CI_NO']):
					// 이미 발급된 게시글
//					continue;
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
				$couponParam['m_no']			= $dataSelectRow['UB_M_NO'];
				$couponParam['cu_no']			= $cu_no;
				$couponParam['b_no']			= $ub_no;
				$couponParam['ci_code']			= $cl_code;
				$couponParam['ci_memo']			= $paramData['memo'];
				$couponParam['ci_reg_no']		= $this->field['member_no'];	
				$ub_ci_no						= $couponIssueController->getWriteEx($couponParam);	

				/* 커뮤니티 작성 글에 쿠폰 번호 업데이트 */
				$dataParam2						= "";
				$dataParam2['b_code']			= $this->field['b_code'];
				$dataParam2['ub_no']			= $ub_no;
				$dataParam2['ub_ci_no']			= $ub_ci_no;
				$dataParam2['ub_winner']		= "Y";
				$this->getCouponUpdateEx($dataParam2);
			endforeach;
		}


		/**
		 * getPointGiveEx()
		 * 포인트 지급
		 * 발급 개수 지정이 안됨.(추후 작업)
		 * **/
		function getPointGiveEx($paramData) {
			$dataView						= $this->getCommunityView();
			$client							= new ClientInfo();	
			$pointDataController			= new PointDataController($this->db, $this->field);
			$memberController				= new MemberDataController($this->db, $this->field);

			foreach($paramData['list'] as $ub_no):
				## STEP 1.
				## 커뮤니티 데이터 가져오기
				$dataParam['b_code']			= $this->field['b_code'];
				$dataParam['ub_no']				= $ub_no;
//				$dataView						= $this->getCommunityView();
				$dataSelectRow					= $dataView->getSelectEx($dataParam);
				if($dataSelectRow['UB_PT_NO']):
					// 이미 발급된 게시글
//					continue;
				endif;

				## STEP 2.
				## 포인트 지급 체크 1회 이상 지급 안됨.
				## 2013.04.09 커뮤니티 글인 경우 1회 이상 지급 안됨으로 설졍할 경우, 1회성 포인트 지급으로 끝나기 때문에 사용 못함.

				## STEP 3.
				## 포인트 지급
				$pointParam['m_no']				= $dataSelectRow['UB_M_NO'];
				$pointParam['b_no']				= $dataSelectRow['UB_NO'];
				$pointParam['o_no']				= 0;
				$pointParam['pt_type']			= "004";
//				$pointParam['pt_point']			= $this->field['BOARD_INFO']['bi_point_w_mark']; 
				$pointParam['pt_point']			= $paramData['point'];
//				$pointParam['pt_memo']			= "커뮤니티 글 작성 포인트 지급(BOARD_UB_{$this->field['b_code']})";
				$pointParam['pt_memo']			= $paramData['memo'];
				$pointParam['pt_etc']			= "{$this->field['BOARD_INFO']['bi_point_w_give']},{$this->field['b_code']},{$ub_no}";	// 지급방식, 테이블 명, 게시글 번호
				$pointParam['pt_start_dt']		= date("Y-m-d");
				$pointParam['pt_end_dt']		= date("Y-m-d");
//				$client							= new ClientInfo();		
				$pointParam['pt_reg_ip']		= $client->getClientIP();
				$pointParam['pt_reg_no']		= $this->field['member_no'];
//				$pointDataController			= new PointDataController($this->db, $this->field);
				$ub_pt_no						= $pointDataController->getWriteEx($pointParam);

				## STEP 3.
				## 회원 테이블에 포인트 지급(업데이트)
				$memberPointParam['m_point']	= $this->field['BOARD_INFO']['bi_point_w_mark'];
				$memberPointParam['m_no']		= $dataSelectRow['UB_M_NO'];
//				$memberController				= new MemberDataController($this->module->db, $this->field);
				$memberController->getPointUpdateEx($memberPointParam);

				/* 커뮤니티 작성 글에 포인트 번호 업데이트 */
				$dataParam2						= "";
				$dataParam2['b_code']			= $this->field['b_code'];
				$dataParam2['ub_no']			= $ub_no;
				$dataParam2['ub_pt_no']			= $ub_pt_no;
				$dataParam2['ub_winner']		= "Y";
				$this->getPointUpdateEx($dataParam2);
			endforeach;
		}

		/**
		 * getPointUpdateEx($paramData)
		 * 포인트 지급 업데이트
		 * **/
		function getPointUpdateEx($paramData) {
			return $this->module->{"get{$this->name}PointUpdateEx"}($paramData);
		}

		/**
		 * getCouponUpdateEx($paramData)
		 * 쿠폰 지급 업데이트
		 * **/
		function getCouponUpdateEx($paramData) {
			return $this->module->{"get{$this->name}CouponUpdateEx"}($paramData);
		}

		/**
		 * getDeleteAuthCheck()
		 * 데이터 삭제 권한 체크
		 * **/
		function getDataAuthCheck() {
			## STEP 1.
			## 회원 정보 로드
			$selectRow					= $this->getSelect();
			$auth						= $this->getAuthCheck($selectRow);
			$this->field['dataAuth']	= $auth;
		}

		/**
		 * getSelect()
		 * 데이터 정보
		 * **/
		function getSelect() {
			$this->field['ub_table']	= "BOARD_UB_{$this->field['b_code']}";
			$selectRow					= parent::getSelect();	
			$aryFunc					= $this->getUB_FUNC_DECODER($selectRow);
			$selectRow['UB_FUNC']		= $aryFunc;
			return $selectRow;
		}

		/**
		 * getWrite()
		 * 데이터 등록
		 * **/
		function getWrite() {

			$strUbLng = $this->field['ub_lng'];
			if(!$strUbLng) { $strUbLng = $this->field['S_SITE_LNG']; }

			if(!$this->field['member_login']):
				// 비회원
				if((!$this->field['ub_pass']) || ($this->field['ub_pass'] != $this->field['ub_pass1'])):
					// 비밀번호가 없거나 비밀번호가 틀리게 입력된 경우.
					$this->field['act'] = "dataWriteX";
					return;
				endif;
			else:
				// 회원
				if(!$this->field['ub_name']):
					$this->field['ub_name']	= $this->field['member_name'];				// 이름
				endif;

				$this->field['ub_m_id']		= $this->field['member_id'];				// 아이디
				if(!$this->field['ub_mail']):
					$this->field['ub_mail']	= $this->field['member_mail'];				// 이메일
				endif;
			endif;

			$client						= new ClientInfo();	
			$this->field['ub_ip']		= $client->getClientIP();					// 아이피
			$this->field['ub_table']	= "BOARD_UB_{$this->field['b_code']}";		// 테이블 명
			$this->field['fl_table']	= "BOARD_FL_{$this->field['b_code']}";		// 테이블 명
			$this->field['ub_m_no']		= $this->field['member_no'];				// 작성자
			$this->field['ub_reg_no']	= $this->field['member_no'];				// 작성자
			$this->field['ub_mod_no']	= $this->field['member_no'];				// 수정자
			$this->field['ub_func']		= $this->getUB_FUNC_ENCODER();				// 기능함수
			$this->field['ub_ans_no']	= "UB_NO";
			$this->field['ub_ans_step']	= "";
			$this->field['ub_ans_m_no']	= $this->field['member_no'];				// 작성자
			$this->field['ub_lng']		= $strUbLng;
			$this->field['ub_shop_no']	= $this->field['shop_no'];
			$this->field['ub_no']		= parent::getWrite();
			parent::getAnsNoUpdate();

		}

		/**
		 * getAnswer()
		 * 데이터 답변 등록
		 * **/		
		function getAnswer() {

			## STEP 1.
			## 작성 권한 체크
			if((!$this->field['member_login']) && ($this->field['ub_pass'] != $this->field['ub_pass1'])):
				// 비회원으로 작성된 글, 비밀번호가 일치하지 않는 경우 저장 불가.
				return;
			endif;

			## STEP 2.
			## 답변 상위글 정보 가져오기
			$this->field['ub_table']			= "BOARD_UB_{$this->field['b_code']}";		// 테이블 명
			$this->field['fl_table']			= "BOARD_FL_{$this->field['b_code']}";		// 테이블 명
			$selectRow							= parent::getSelect();

			## 데이터 설정
			$ansMemberNo						= $selectRow['UB_ANS_M_NO'];
			$shopNo								= $selectRow['UB_SHOP_NO'];

			## STEP 3.
			## 답변 최대 값 구하기.
			$this->field['ub_ans_no']			= $selectRow['UB_ANS_NO'];
			$this->field['ub_ans_step']			= $selectRow['UB_ANS_STEP'];
			$ansDescSelectRow					= parent::getAnsStepMaxSelect();
		

			if($ansDescSelectRow['UB_ANS_STEP'] == $this->field['ub_ans_step']):
				$ub_ans_step = "100";
				if($this->field['ub_ans_step']):
					$ub_ans_step = "{$this->field['ub_ans_step']},{$ub_ans_step}";
				endif;
			else:
				$ub_ans_step = "100";
				if($ansDescSelectRow['UB_ANS_STEP']):
					$ub_ans_stepTemp				= explode(",", $ansDescSelectRow['UB_ANS_STEP']);
					$intStep						= sizeof($ub_ans_stepTemp)-1;
					$ub_ans_stepTemp[$intStep]		= $ub_ans_stepTemp[$intStep]+1;
					$ub_ans_step					= implode(",", $ub_ans_stepTemp);
				endif;
			endif;

			## STEP 4.
			## 답변 등록
			$client						= new ClientInfo();	
			$this->field['ub_ip']		= $client->getClientIP();					// 아이피
			$this->field['ub_table']	= "BOARD_UB_{$this->field['b_code']}";		// 테이블 명
			$this->field['ub_m_no']		= $this->field['member_no'];				// 작성자
			$this->field['ub_m_id']		= $this->field['member_id'];				// 작성자
			$this->field['ub_mail']		= $this->field['member_mail'];				// 작성자
			$this->field['ub_reg_no']	= $this->field['member_no'];				// 작성자
			$this->field['ub_mod_no']	= $this->field['member_no'];				// 수정자
			$this->field['ub_lng']		= $selectRow['UB_LNG'];						// 글 작성자 언어
			$this->field['ub_func']		= $this->getUB_FUNC_ENCODER();				// 기능함수
			$this->field['ub_ans_step']	= $ub_ans_step;
			$this->field['ub_ans_m_no']	= $ansMemberNo;
			$this->field['ub_shop_no']  = $shopNo;									// 입점사 번호
			$this->field['ub_no']		= parent::getWrite();

			## 2014.03.15 kim hee sung 내용 추가
			## SMS 관련 부분
			if($this->field['member_no']):

				## 모듈 설정
				$objSms						= new SmsInfo($this->db);
				$objMemberMgrModule			= new MemberMgrModule($this->db);

				## SMS 정보 불러오기
				$strSmsCode					= ($this->field['b_code'] == "MY_QNA") ? "026" : "028";
				$param						= "";
				$param['{{고객명}}']		= $this->field['ub_name'];
				$param['{{게시판}}']		= $this->field['BOARD_INFO']['b_name'];
				$aryInfo					= $objSms->getSmsInfo($strSmsCode, $param);	
			endif;

			## SMS 발송을 승인한 경우
			if($this->field['member_id'] == "master" && $aryInfo['SM_AUTO'] == "Y"):

				## 회원 정보 불러오기
				$param						= "";
				$param['M_NO']				= $ansMemberNo;
				$aryMemberInfo				= $objMemberMgrModule->getMemberMgrSelectEx("OP_SELECT", $param);

				## 연락처 체크
				$strPhone					= $aryMemberInfo['M_HP'];
				if($strPhone):
					## 문자 전송
					$param						= "";
					$param['phone']				=$strPhone;
					$param['callBack']			= $aryInfo['COM_PHONE'];
					$param['msg']				= $aryInfo['SM_TEXT'];
					$param['siteName']			= $aryInfo['SITE_NAME'];
					$objSms->goSendSms($param);
				endif;
			endif;

			return 1;
		}

		/**
		 * getModify()
		 * 데이터 수정
		 * **/
		function getModify() {

			$strUbLng = $this->field['ub_lng'];
			if(!$strUbLng) { $strUbLng = $this->field['S_SITE_LNG']; }
	

			## 권한 체크(비회원)
			if(!$this->field['member_login']):
				if($this->field['b_code'] != $_SESSION['b_code'] || $this->field['ub_no'] != $_SESSION['ub_no']):
					// 비회원이 비밀번호 체크한 게시글과 같은 게시글인지 체크.
					$this->field['act']				= "{$this->field['act']}X"; 
					return;
				endif;
				if($this->field['ub_pass'] != $this->field['ub_pass1']):
					// 비회원으로 작성된 글, 비밀번호가 일치하지 않는 경우 저장 불가.
					$this->field['act']				= "{$this->field['act']}R"; 
					return;
				endif;
			endif;
			## S_REQ 테이블 권한 설정
			if($this->field['b_code'] == "S_REQ"):
				
				## 모듈 설정
				$objBoardDataModule = new BoardDataModule($this->db);
				
				## 데이터 불러오기
				$param				= "";
				$param['B_CODE']	= $this->field['b_code'];
				$param['UB_NO']		= $this->field['ub_no'];
				$aryRow				= $objBoardDataModule->getBoardDataSelectEx("OP_SELECT", $param);

				## 유효성 체크
				if(!$aryRow):
					$this->field['act'] = "noData";
					return;
				endif;
				if($aryRow['UB_SHOP_NO'] != $this->field['shop_no']):
					$this->field['act'] = "diffShopNo";
					return;
				endif;
				if($aryRow['UB_M_NO'] != $this->field['member_no']):
					$this->field['act'] = "diffMember";
					return;
				endif;
			endif;
//			$lock				= $this->getLockCheck($selectRow);

			## 설정.
			$client						= new ClientInfo();	
			$this->field['ub_ip']		= $client->getClientIP();					// 아이피
			$this->field['ub_table']	= "BOARD_UB_{$this->field['b_code']}";		// 테이블 명
			$this->field['ub_mod_no']	= $this->field['member_no'];				// 수정자
			$this->field['ub_func']		= $this->getUB_FUNC_ENCODER();				// 기능함수
			$this->field['ub_lng']		= $strUbLng;								// 작성 언어
			
			## 2013.07.15 kim hee sung 관리자는 작성일을 변경 할 수 있음 으로 변경
			if(!$this->field['ub_reg_dt']) { $this->field['ub_reg_dt'] = date("Y-m-d H:i:d"); } // 작성일
			$this->field['ub_mod_dt']	= $this->field['ub_reg_dt'];

			## 수정.
			return parent::getModify();	
		}


		/**
		 * getDelete()
		 * 데이터 삭제
		 * **/
		function getDelete() {	

			## 권한 체크
			if(!$this->field['dataAuth']['check']):
				$this->field['mode']			= "dataPassword";
				$this->field['act']				= "";
				$this->field['password_mode']	= "dataDelete";
				$this->field['password_act']	= "goAct";
				return;
			endif;
			## S_REQ 테이블 권한 설정
			if($this->field['b_code'] == "S_REQ"):
				
				## 모듈 설정
				$objBoardDataModule = new BoardDataModule($this->db);
				
				## 데이터 불러오기
				$param				= "";
				$param['B_CODE']	= $this->field['b_code'];
				$param['UB_NO']		= $this->field['ub_no'];
				$aryRow				= $objBoardDataModule->getBoardDataSelectEx("OP_SELECT", $param);

				## 유효성 체크
				if(!$aryRow):
					$this->field['act'] = "noData";
					return;
				endif;
				if($aryRow['UB_SHOP_NO'] != $this->field['shop_no']):
					$this->field['act'] = "diffShopNo";
					return;
				endif;
				if($aryRow['UB_M_NO'] != $this->field['member_no']):
					$this->field['act'] = "diffMember";
					return;
				endif;
			endif;

			$result							= parent::getDelete();	
		

			## JSON 요청시
			## 2013.04.16 /* json 오류 발생으로 변경
//			if($this->field['mode'] == "json"):
//				$result						= null;
//				$result['mode']				= $resultMode;
//				$result['data']				= $result;
//			endif;
			if($this->field['mode'] == "json"):
				$resultJson['mode']			= 1; 
				$this->field['result']		= $resultJson;
			endif;
		}

		/**
		 * getDeleteMulti()
		 * 데이터 다중 삭제
		 * **/
		function getDeleteMulti() {

			## STEP 1.
			## 권한 체크(관리자 그룹만 삭제 가능)
			if($this->field['member_group'] != "001") { return; }

			## STEP 2.
			## 데이터 삭제
			foreach($this->field['check'] as $ub_no):
				$this->field['ub_no']			= $ub_no;
				$selectRow						= $this->getSelect();
				$this->field['ub_ans_no']		= $selectRow['UB_ANS_NO'];
				$this->field['ub_ans_step']		= $selectRow['UB_ANS_STEP'];
				$result							= parent::getDelete();
			endforeach;

			## STEP 3.
			## JSON 요청시
			if($this->field['mode'] == "json"):
			endif;

			## STEP 4.
			## return
			$this->field['result']				= $result;
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
			if($selectRow['UB_PASS'] == $this->field['ub_pass']):
				$resultMode				= 1; 
				$_SESSION['b_code']		= $this->field['b_code'];
				$_SESSION['ub_no']		= $this->field['ub_no'];
			elseif($selectRow['UB_ANS_NO'] != $selectRow['UB_NO']):
				$ub_no_bak				= $this->field['ub_no'];
				$this->field['ub_no']	= $selectRow['UB_ANS_NO'];
				$ansRow					= $this->getSelect();
				$this->field['ub_no']	= $ub_no_bak;
				if($ansRow['UB_PASS'] == $this->field['ub_pass']):
					$resultMode				= 1; 
					$_SESSION['b_code']		= $this->field['b_code'];
					$_SESSION['ub_no']		= $this->field['ub_no'];
				endif;
			endif;

			##STEP 3.
			## JSON 요청시
			if($this->field['mode'] == "json"):
				$result						= null;
				$result['mode']				= $resultMode;
				$result['data']				= null;
				$this->field['result']		= $result;
			endif;
		}

		/**
		 * getPassword()
		 * 작성된 글의 비밀번호와 사용자가 입력한 비밀번호가 같은지 체크
		 * **/
//		function getPassword() {
//			
//			## STEP 1.
//			## 삭제모드인경우.
//			if($this->field['act'] == "dataDPassword"):
//				$this->getDelete();	
//				return;
//			endif;
//
//			## STEP 2.
//			## 게시글 SELECT
//			$selectRow			= $this->getSelect();		
//			$resultMode			= 0;
//
//			## STEP 3.
//			## 비밀번호 체크
//			if($selectRow['UB_PASS'] == $this->field['ub_pass']):
//				$resultMode				= 1; 
//				$_SESSION['b_code']		= $this->field['b_code'];
//				$_SESSION['ub_no']		= $this->field['ub_no'];
//			else : 
//				$this->field['act']		= "{$this->field['act']}X"; 
//				$_SESSION['b_code']		= "";
//				$_SESSION['ub_no']		= "";
//			endif;
//
//			##STEP 4.
//			## JSON 요청시
//			if($this->field['mode'] == "json"):
//				$result						= null;
//				$result['mode']				= $resultMode;
//				$result['data']				= null;
//			endif;
//
//			$this->field['result']			= $result;
//		}

		/** 
		 * getCreateTable()
		 * 테이블 생성
		 * **/
		function getCreateTable() {
			if(!$this->field['b_code']) { return; }
			$strTableName				= $this->field['b_code'];
			$this->field['ub_table']	= "BOARD_UB_{$strTableName}";
			$intTableCnt				= $this->module->getSchemaTableSelect($this->field['tableName']);

			if($intTableCnt == 0) :	// 테이블이 없으면 실행
				return parent::getCreateTable();		
			endif;
		}

		/**
		 * getCreateProcedure()
		 * 프로시저 생성
		 * **/
		function getCreateProcedure() {
			$intProcedureCnt = $this->module->getSchemaProcedureSelect("SP_BOARD_UB_I");
			if($intProcedureCnt == 0) : // 프로시저가 없으면 실행
				parent::getCreateProcedure("I");	
			endif;
			$intProcedureCnt = $this->module->getSchemaProcedureSelect("SP_BOARD_UB_U");
			if($intProcedureCnt == 0) : // 프로시저가 없으면 실행
				parent::getCreateProcedure("U");	
			endif;
			$intProcedureCnt = $this->module->getSchemaProcedureSelect("SP_BOARD_UB_D");
			if($intProcedureCnt == 0) : // 프로시저가 없으면 실행
				parent::getCreateProcedure("D");	
			endif;
		}

		/**
		 * getDropProcedure()
		 * 프로시저 삭제
		 * **/
		function getDropProcedure() {
			parent::getDropProcedure("I");
			parent::getDropProcedure("U");	
			parent::getDropProcedure("D");	
		}


		## 함수 모음 ##


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
//			if($auth['check'] == 0 && $row['UB_ANS_NO'] != $row['UB_NO']):
//				$ub_no_bak				= $this->field['ub_no'];
//				$this->field['ub_no']	=  $row['UB_ANS_NO'];
//				$ansRow = $this->getSelect();
//				$this->field['ub_no']	= $ub_no_bak;
//				return $this->getAuthCheck($ansRow);	// 재귀호출
//			endif;
//
//			return $auth;
//		}


//		/**
//		 * getAuthCheck(&$row)
//		 * $auth['member']	= 0		=> 비회원
//		 * $auth['member']	= 1		=>   회원
//		 * $auth['check']	= 0		=> 권한 없음
//		 * $auth['check']	= 1		=> 권한 있음
//		 * **/	
//		function getAuthCheck(&$row) {
//			
//			if($row['UB_M_NO']) { $auth['member'] = "1"; }
//			else				{ $auth['member'] = "0"; }
//
//			if($this->field['member_login'] && $row['UB_M_NO'] && $this->field['member_no'] == $row['UB_M_NO'])		{ $auth['check'] = "1"; }	// 회원이 작성한 글과 로그인 한 회원이 같으면 0
//			elseif($this->field['ub_pass'] && $row['UB_PASS'] && $this->field['ub_pass'] == $row['UB_PASS']) 		{ $auth['check'] = "1"; }	// 비회원이 작성한 글과 비밀번호가     같으면 0
//			else																									{ $auth['check'] = "0"; }	// 권한이 필요한 경우.
//
//			return $auth;
//		}


		/**
		 * getLockCheck(&$row)
		 * 볼수있는 글이면 return "000", 볼수 없는 글이면 return "11X"
		 * **/		
		function getLockCheck(&$row) {
////			$lock_use	= $this->field['BOARD_INFO']['bi_datawrite_lock_use'];
////			$code		= "";
////
////			// 작성된 글이 비밀글이면 1, 아니면 0
////			if     ($lock_use == "E") { $code .= "1"; }
////			else if($lock_use == "C") { $code .= ($row['UB_FUNC']['UB_FUNC_LOCK'] == "Y") ? "1" : "0"; }
////			else                      { $code .= "0"; }
////			echo $lock_use;
////			if($code == "0")		  { return "000"; }
//
//			$code		= "1";
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
		}

		/**
		 * getUB_FUNC_ENCODER()
		 * 기능 함수
		 * **/
		function getUB_FUNC_ENCODER() {
			
			if(!$this->field['ub_func_notice'])			{ $this->field['ub_func_notice']		= "N"; }
			if(!$this->field['ub_func_lock'])			{ $this->field['ub_func_lock']			= "N"; }
			if(!$this->field['ub_func_icon'])			{ $this->field['ub_func_icon']			= "N"; }
			if(!$this->field['ub_func_icon_widget'])	{ $this->field['ub_func_icon_widget']	= "N"; }

			$ub_func  = "";
			$ub_func .= $this->field['ub_func_notice'];				// 공지글 (사용:Y, 사용안함:N);
			$ub_func .= $this->field['ub_func_lock'];				// 비밀글 (사용:Y, 사용안함:N);
			$ub_func .= $this->field['ub_func_icon'];				// 아이콘 (사용:Y, 사용안함:N);
			$ub_func .= $this->field['ub_func_icon_widget'];		// 위젯글 (사용:Y, 사용안함:N);
			$ub_func .= "N";
			$ub_func .= "N";
			$ub_func .= "N";
			$ub_func .= "N";
			$ub_func .= "N";
			$ub_func .= "N";

			return $ub_func;
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

			return $data;
		}

		/**
		 * getDropTable()
		 * 테이블 삭제
		 * 2013.04.10 커뮤니티 통합(상속 부분) 영역으로 변경
		 * **/
//		function getDropTable() {
//			$tableName		= "BOARD_UB_{$this->field['b_code']}";
//			$intTableCnt	= $this->module->getSchemaTableSelect($tableName);
//			if($intTableCnt > 0) : // 테이블이 있으면 실행
//				$param['tableName'] = $tableName;
//				return parent::getDropTable($param);	
//			endif;
//		}
    }
?>