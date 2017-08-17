<?php
    /**
     * /home/shop_eng/www/modules/community/mypage/basic.1.0/community.mypage.controller.php
     * @author eumshop(thav@naver.com)
     * community mypage controller class (basic.1.0)
     * **/

	require_once MALL_HOME . "/modules/community/community.controller.php";
	require_once MALL_HOME . "/modules/community/mypage/basic.1.0/community.mypage.module.php";

	require_once MALL_HOME . "/classes/file/file.handler.class.php";
 //	require_once MALL_HOME . "/classes/client/client.info.class.php";

    class CommunityMypageController extends CommunityController {

		/**
		 * __construct(&$db, &$field)
		 * 생성자
		 * **/
		function __construct(&$db, &$field) {
			$this->module	= new CommunityMypageModule($db, $field);
			$this->name		="MypageMgr";
			$this->db		= &$db;
			$this->field	= &$field;
			$this->getSessionInfo();
		}

		/**
		 * getMessage()
		 * 메시지
		 * **/
		function getMessage() {
			echo "community mypage controller class (basic.1.0)";
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
		 * getDataAuthCheck()
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
				$this->field['ub_mail']		= $this->field['member_mail'];				// 이메일
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
			$this->field['ub_no']		= parent::getWrite();
										  parent::getAnsNoUpdate();

			##STEP 4.
			## JSON 요청시
			if($this->field['mode'] == "json"):
				$result						= null;
				$result['mode']				= 1;
				$result['data']['ub_no']	= $this->field['ub_no'];
				$result['data']['ub_title']	= $this->field['ub_title'];
				$result['data']['ub_text']	= $this->field['ub_text'];
			else:
				$result						= $re;
			endif;

			$this->field['result']			= $result;
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
			$this->field['ub_reg_no']	= $this->field['member_no'];				// 작성자
			$this->field['ub_mod_no']	= $this->field['member_no'];				// 수정자
			$this->field['ub_func']		= $this->getUB_FUNC_ENCODER();				// 기능함수
			$this->field['ub_ans_step']	= $ub_ans_step;
		
			$this->field['ub_no']		= parent::getWrite();
			return 1;
		}

		/**
		 * getModify()
		 * 데이터 수정
		 * **/
		function getModify() {
			## STEP 1.
			## (보안)권한 체크.
			if(!$this->field['member_login']):
				// 비회원 루트
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
			$lock				= $this->getLockCheck($selectRow);

			## STEP 2.
			## 설정.
			$client						= new ClientInfo();	
			$this->field['ub_ip']		= $client->getClientIP();					// 아이피
			$this->field['ub_table']	= "BOARD_UB_{$this->field['b_code']}";		// 테이블 명
			$this->field['ub_mod_no']	= $this->field['member_no'];				// 수정자
			$this->field['ub_func']		= $this->getUB_FUNC_ENCODER();				// 기능함수
			
			## STEP 3.
			## 수정.
			return parent::getModify();	
		}


		/**
		 * getDelete()
		 * 데이터 삭제
		 * **/
		function getDelete() {	

			## STEP 1.
			## 권한 체크
			if(!$this->field['dataAuth']['check']):
				$this->field['mode']			= "dataPassword";
				$this->field['act']				= "";
				$this->field['password_mode']	= "dataDelete";
				$this->field['password_act']	= "goAct";
				return;
			endif;

			$re								= parent::getDelete();	

			##STEP 4.
			## JSON 요청시
			if($this->field['mode'] == "json"):
				$result						= null;
				$result['mode']				= 1;
				$result['data']['ub_no']	= $this->field['ub_no'];
				$this->field['result']		= $result;
			else:
				$result						= $re;
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
			if($selectRow['UB_PASS'] == $this->field['ub_pass']):
				$resultMode				= 1; 
				$_SESSION['b_code']		= $this->field['b_code'];
				$_SESSION['ub_no']		= $this->field['ub_no'];
			else : 
				$resultMode				= 0;
				$_SESSION['b_code']		= "";
				$_SESSION['ub_no']		= "";
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
			
			if(!$this->field['ub_func_notice']) { $this->field['ub_func_notice']	= "N"; }
			if(!$this->field['ub_func_lock'])   { $this->field['ub_func_lock']		= "N"; }
			if(!$this->field['ub_func_icon'])   { $this->field['ub_func_icon']		= "N"; }

			$ub_func  = "";
			$ub_func .= $this->field['ub_func_notice'];		// 공지글 (사용:Y, 사용안함:N);
			$ub_func .= $this->field['ub_func_lock'];		// 비밀글 (사용:Y, 사용안함:N);
			$ub_func .= $this->field['ub_func_icon'];		// 아이콘 (사용:Y, 사용안함:N);
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
			$data['UB_FUNC_ICON']		= $row['UB_FUNC'][2];

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