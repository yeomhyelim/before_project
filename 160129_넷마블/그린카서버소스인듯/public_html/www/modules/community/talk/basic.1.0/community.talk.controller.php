<?php
    /**
     * /home/shop_eng/www/modules/community/talk/basic.1.0/community.data.controller.php
     * @author eumshop(thav@naver.com)
     * community talk controller class (basic.1.0)
     * **/

	require_once MALL_HOME . "/modules/community/community.controller.php";
	require_once MALL_HOME . "/modules/community/talk/basic.1.0/community.talk.module.php";

	require_once MALL_HOME . "/classes/file/file.handler.class.php";
 //	require_once MALL_HOME . "/classes/client/client.info.class.php";

    class CommunityTalkController extends CommunityController {

		/**
		 * __construct(&$db, &$field)
		 * 생성자
		 * **/
		function __construct(&$db, &$field) {
			$this->module	= new CommunityTalkModule($db, $field);
			$this->name		="TalkMgr";
			$this->db		= &$db;
			$this->field	= &$field;
			$this->getSessionInfo();
		}

		/**
		 * getMessage()
		 * 메시지
		 * **/
		function getMessage() {
			echo "community talk controller class (basic.1.0)";
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
				$pointGive->getPointProcess($param);
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
		 * getCountTotalEx()
		 * 데이터 전체 개수
		 * **/
		function getCountTotalEx() {
			$param['b_code'] = $this->field['b_code'];
			return $this->module->getTalkMgrSelectEx("OP_COUNT", $param);
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
	
			if(!$this->field['member_login']):
				// 비회원
				if((!$this->field['ub_pass']) || ($this->field['ub_pass'] != $this->field['ub_pass1'])):
					// 비밀번호가 없거나 비밀번호가 틀리게 입력된 경우.
					$this->field['act'] = "dataWriteX";
					return;
				endif;
			else:
				// 회원
				$this->field['ub_name']		= $this->field['member_name'];				// 이름
				$this->field['ub_m_id']		= $this->field['member_id'];				// 아이디
				$this->field['ub_mail']		= $this->field['member_mail'];				// 이메일
			endif;

			$client						= new ClientInfo();	
			$this->field['ub_ip']		= $client->getClientIP();					// 아이피
			$this->field['ub_table']	= "BOARD_UB_{$this->field['b_code']}";		// 테이블 명
			$this->field['fl_table']	= "BOARD_FL_{$this->field['b_code']}";
			$this->field['ub_m_no']		= $this->field['member_no'];				// 작성자
			$this->field['ub_reg_no']	= $this->field['member_no'];				// 작성자
			$this->field['ub_mod_no']	= $this->field['member_no'];				// 수정자
			$this->field['ub_func']		= $this->getUB_FUNC_ENCODER();				// 기능함수
			$ub_no						= parent::getWrite();	
			
			if($ub_no < 0):
				// 등록 실패
				$result['mode']			= null;
				$result['data']			= null;
			else:
				// 등록 성공
				$this->field['ub_no']	= $ub_no;			
				$arySelectRow			= parent::getSelect();	
				$result['mode']			= 1;
				$result['data']			= $arySelectRow;
			endif;

			$this->field['result']		= $result;
			return;
		}

		/**
		 * getModify()
		 * 데이터 수정
		 * **/
		function getModify() {
			if(!$this->field['member_login']):
				// 비회원
				if(!$this->field['ub_pass_check']):
					// 비밀번호가 입력되지 않았을 때.
					$this->field['act'] = "dataModifyX";
					return;
				endif;

			else:
				// 회원
				$this->field['ub_table']		= "BOARD_UB_{$this->field['b_code']}";
				$this->field['fl_table']		= "BOARD_FL_{$this->field['b_code']}";
				$arySelectRow					= parent::getSelect();	
				if($arySelectRow['UB_M_NO'] == $this->field['member_no']):
					// 작성자 회원 번호와 로그인 회원 번호가 같은 경우. 내용 삭제.
					$client						= new ClientInfo();	
					$this->field['ub_ip']		= $client->getClientIP();		// 아이피
					$this->field['ub_name']		= $arySelectRow['UB_NAME'];
					$this->field['ub_pass']		= $arySelectRow['UB_PASS'];
					$this->field['ub_mail']		= $arySelectRow['UB_MAIL'];
					$this->field['ub_talk']		= $this->field['ub_talk_modify'];
					$re							= parent::getModify();	
					$result['mode']				= 1;
					$result['data']				= parent::getSelect();	
				else:
					/// 작성자 회원 번호와 로그인 회원 번호가 다른 경우. 삭제 불가.
					$result['mode']				= null;
					$result['data']				= null;
				endif;
			endif;

			$this->field['result']				= $result;
			return;
		}

//		function getModify() {
//			$client							= new ClientInfo();	
//
//			$this->field['ub_name']			= $this->field['ub_name_modify'];
//			$this->field['ub_pass']			= $this->field['ub_pass_modify'];
//			$this->field['ub_mail']			= $this->field['ub_mail_modify'];
//			$this->field['ub_talk']			= $this->field['ub_talk_modify'];
//			
//			$this->field['ub_ip']			= $client->getClientIP();		// 아이피
//			$this->field['ub_table']		= "BOARD_UB_{$this->field['b_code']}";
//			$this->field['fl_table']		= "BOARD_FL_{$this->field['b_code']}";
//
//			$re								= parent::getModify();	
//			$arySelectRow					= parent::getSelect();	
//			if($re && is_array($arySelectRow)) :
//				$result['mode'] = 1;
//				$result['data'] = $arySelectRow;
//			else:
//				$result['mode'] = null;
//				$result['data'] = null;
//			endif;
//
//			return $result;
//		}

		/**
		 * getDelete()
		 * 데이터 삭제
		 * **/
		function getDelete() {

			if(!$this->field['member_login']):
				// 비회원
				if(!$this->field['ub_pass_check']):
					// 비밀번호가 입력되지 않았을 때.
					$this->field['act'] = "dataDeleteX";
					return;
				endif;

			else:
				// 회원
				$this->field['ub_table']		= "BOARD_UB_{$this->field['b_code']}";
				$this->field['fl_table']		= "BOARD_FL_{$this->field['b_code']}";
				$arySelectRow					= parent::getSelect();	
				if($arySelectRow['UB_M_NO'] == $this->field['member_no']):
					// 작성자 회원 번호와 로그인 회원 번호가 같은 경우. 내용 삭제.
					$re							= parent::getDelete();	
					$result['mode']				= 1;
					$result['data']				= $arySelectRow;
				else:
					/// 작성자 회원 번호와 로그인 회원 번호가 다른 경우. 삭제 불가.
					$result['mode']				= null;
					$result['data']				= null;
				endif;
			endif;

			$this->field['result']				= $result;
			return;
		}

		/**
		 * getPassword()
		 * 작성된 글의 비밀번호와 사용자가 입력한 비밀번호가 같은지 체크
		 * **/
		function getPassword() {
		}

		/** 
		 * getCreateTable()
		 * 테이블 생성
		 * **/
		function getCreateTable() {
			if(!$this->field['b_code']) { return; }
			$strTableName				= strtoupper($this->field['b_code']);
			$this->field['tableName']	= "BOARD_UB_{$strTableName}";
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
		}

		/**
		 * getDropProcedure()
		 * 프로시저 삭제
		 * **/
		function getDropProcedure() {
		}

		/**
		 * getSelectForModify()
		 * 수정을 위한 데이터 정보 호출
		 * **/
		function getSelectForModify() {
			$this->field['ub_pass']		= $this->field['ub_pass_check'];
			$this->field['ub_table']	= "BOARD_UB_{$this->field['b_code']}";
			$this->field['fl_table']	= "BOARD_FL_{$this->field['b_code']}";
			$arySelectRow				= parent::getSelect();	

			if(is_array($arySelectRow)):
				$arySelectRow['UB_TALK']	= stripslashes($arySelectRow['UB_TALK']);
				$resert['mode'] = 1;
				$resert['data'] = $arySelectRow;
			else:
				$resert['mode'] = null;
				$resert['data'] = null;
			endif;

			return $resert;
		}

		## 함수 모음 ##

		/**
		 * getLockCheck(&$row)
		 * 볼수있는 글이면 return "000", 볼수 없는 글이면 return "11X"
		 * **/		
		function getLockCheck(&$row) {
		}

		/**
		 * getUB_FUNC_ENCODER()
		 * 기능 함수
		 * **/
		function getUB_FUNC_ENCODER() {
			
			if(!$this->field['ub_func_notice']) { $this->field['ub_func_notice']	= "N"; }
			if(!$this->field['ub_func_lock'])   { $this->field['ub_func_lock']		= "N"; }

			$ub_func  = "";
			$ub_func .= $this->field['ub_func_notice'];		// 공지글 (사용:Y, 사용안함:N);
			$ub_func .= $this->field['ub_func_lock'];		// 비밀글 (사용:Y, 사용안함:N);
			$ub_func .= "N";
			$ub_func .= "N";
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

			$data['UB_FUNC_NOTICE']		= $row['UB_FUNC'][0];
			$data['UB_FUNC_LOCK']		= $row['UB_FUNC'][1];

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
    }
?>