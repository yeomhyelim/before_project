<?php
    /**
     * /home/shop_eng/www/modules/community/event/basic.1.0/community.data.controller.php
     * @author eumshop(thav@naver.com)
     * community data controller class (basic.1.0)
     * **/

	require_once MALL_HOME . "/modules/community/attachedfile/basic.1.0/community.attachedfile.controller.php";
	require_once MALL_HOME . "/modules/community/eventComment/basic.1.0/community.eventComment.controller.php";
	require_once MALL_HOME . "/modules/community/eventInfo/basic.1.0/community.eventInfo.controller.php";
	require_once MALL_HOME . "/modules/community/userfield/basic.1.0/community.userfield.controller.php";
	require_once MALL_HOME . "/modules/community/gift/basic.1.0/community.gift.controller.php";
	require_once MALL_HOME . "/classes/file/file.handler.class.php";
 //	require_once MALL_HOME . "/classes/client/client.info.class.php";

	/** 필수 **/
	require_once MALL_HOME . "/modules/community/community.controller.php";
	require_once MALL_HOME . "/modules/community/event/basic.1.0/community.event.module.php";
	
    class CommunityEventController extends CommunityController {

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
		}

		/**
		 * getMessage()
		 * 메시지
		 * **/
		function getMessage() {
			echo "community data controller class (basic.1.0)";
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

			## STEP 4.
			## 이벤트 정보
			$eventInfoController	= new CommunityEventInfoController($this->db, $this->field);
			$eventInfoController->getWriteModify();

			## STEP 5.
			## 이벤트 지급 정보
			$giftController = new CommunityGiftController($this->db, $this->field);
			$aryList		= array("bi_point_c","bi_coupon_c");
			$aryType		= array("bi_point_w" => "point","bi_coupon_w" => "coupon","bi_point_c" => "point","bi_coupon_c" => "coupon");
			$aryArea		= array("bi_point_w" => "data","bi_coupon_w" => "data","bi_point_c" => "comment","bi_coupon_c" => "comment");


			foreach($aryList as $list):

				/** 자동포인트지급 or 수동포인트지급 **/
				$param					= "";
				$param['gm_no']			= $this->field["{$list}_no"];
				$param['gm_b_code']		= $this->field["b_code"];
				$param['gm_ub_no']		= $this->field['ub_no'];
				$param['gm_type']		= $aryType[$list];
				$param['gm_area']		= $aryArea[$list];
				$param['gm_use']		= $this->field["{$list}_use"];
				$param['gm_give_type']	= "A";
				$param['gm_max']		= $this->field["{$list}_count"];
				$param['gm_title']		= $this->field["{$list}_title"];
				$param['gm_data']		= $this->field["{$list}_data"];
				if($param['gm_no'])  { $giftController->getModifyEx($param);		}
				else				 { $giftController->getWriteEx($param);			}

				/** 멀티차등포인트지급 **/
				$sizeCnt = sizeof($this->field["{$list}_multi_count"]);
				for($i=0;$i<$sizeCnt;$i++):
					$param					= "";
					$param['gm_no']			= $this->field["{$list}_multi_no"][$i];
					$param['gm_b_code']		= $this->field["b_code"];
					$param['gm_ub_no']		= $this->field['ub_no'];
					$param['gm_type']		= $aryType[$list];
					$param['gm_area']		= $aryArea[$list];
					$param['gm_use']		= $this->field["{$list}_use"];
					$param['gm_give_type']	= "T";
					$param['gm_max']		= $this->field["{$list}_multi_count"][$i];
					$param['gm_title']		= $this->field["{$list}_multi_title"][$i];
					$param['gm_data']		= $this->field["{$list}_multi_point"][$i];
					if($param['gm_no']) { $giftController->getModifyEx($param);		}
					else				{ $giftController->getWriteEx($param);		}
				endfor;

			endforeach;

			## STEP 6.
			## 커뮤니티 포인트/쿠폰 옵션 삭제
			$deleteList			= $this->field['point_coupon_delete_list'];
			if($deleteList):
				$aryDeleteList  =	explode(",", $deleteList);
				foreach($aryDeleteList as $gm_no):
					$param['gm_no'] = $gm_no;
					$giftController->getDeleteEx($param);
				endforeach;
			endif;	

		}

		/**
		 * getCountTotalEx()
		 * 데이터 전체 개수
		 * **/
		function getCountTotalEx() {
			$param['b_code'] = $this->field['b_code'];
			return $this->module->getDataMgrSelectEx("OP_COUNT", $param);
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

			$client							= new ClientInfo();	
			$this->field['ub_ip']			= $client->getClientIP();						// 아이피
			$this->field['ub_table']		= "BOARD_UB_{$this->field['b_code']}";			// 테이블 명
			$this->field['ub_m_no']			= $this->field['member_no'];					// 작성자
			$this->field['ub_reg_no']		= $this->field['member_no'];					// 작성자
			$this->field['ub_mod_no']		= $this->field['member_no'];					// 수정자
			$this->field['ub_func']			= $this->getUB_FUNC_ENCODER();					// 기능함수
			$this->field['ub_no']			= parent::getWrite();

			## STEP 5.
			## 이벤트 지급 정보
			$giftController = new CommunityGiftController($this->db, $this->field);
			$aryList		= array("bi_point_c","bi_coupon_c");
			$aryType		= array("bi_point_w" => "point","bi_coupon_w" => "coupon","bi_point_c" => "point","bi_coupon_c" => "coupon");
			$aryArea		= array("bi_point_w" => "data","bi_coupon_w" => "data","bi_point_c" => "comment","bi_coupon_c" => "comment");


			foreach($aryList as $list):

				/** 자동포인트지급 or 수동포인트지급 **/
				$param					= "";
				$param['gm_no']			= $this->field["{$list}_no"];
				$param['gm_b_code']		= $this->field["b_code"];
				$param['gm_ub_no']		= $this->field['ub_no'];
				$param['gm_type']		= $aryType[$list];
				$param['gm_area']		= $aryArea[$list];
				$param['gm_use']		= $this->field["{$list}_use"];
				$param['gm_give_type']	= "A";
				$param['gm_max']		= $this->field["{$list}_count"];
				$param['gm_title']		= $this->field["{$list}_title"];
				$param['gm_data']		= $this->field["{$list}_data"];
				$giftController->getWriteEx($param);

				/** 멀티차등포인트지급 **/
				$sizeCnt = sizeof($this->field["{$list}_multi_count"]);
				for($i=0;$i<$sizeCnt;$i++):
					$param					= "";
					$param['gm_no']			= $this->field["{$list}_multi_no"][$i];
					$param['gm_b_code']		= $this->field["b_code"];
					$param['gm_ub_no']		= $this->field['ub_no'];
					$param['gm_type']		= $aryType[$list];
					$param['gm_area']		= $aryArea[$list];
					$param['gm_use']		= $this->field["{$list}_use"];
					$param['gm_give_type']	= "T";
					$param['gm_max']		= $this->field["{$list}_multi_count"][$i];
					$param['gm_title']		= $this->field["{$list}_multi_title"][$i];
					$param['gm_data']		= $this->field["{$list}_multi_point"][$i];
					$giftController->getWriteEx($param);
				endfor;

			endforeach;

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


			$client						= new ClientInfo();	
			$this->field['ub_ip']		= $client->getClientIP();					// 아이피
			$this->field['ub_table']	= "BOARD_UB_{$this->field['b_code']}";		// 테이블 명
			$this->field['ub_mod_no']	= $this->field['member_no'];				// 수정자
			$this->field['ub_func']		= $this->getUB_FUNC_ENCODER();				// 기능함수

			parent::getModify();	
		}

		/**
		 * getDelete()
		 * 데이터 삭제
		 * **/
		function getDelete() {	

			## STEP 1.
			## 설정
			$commentView					= new CommunityEventCommentView($this->db, $this->field);
		
			/** 댓글 체크  **/
			$param['b_code']				= $this->field['b_code'];
			$param['cm_ub_no']				= $this->field['ub_no'];
			$commentCount					= $commentView->getTotalEx($param);			
			if($commentCount > 0) { return; } /** 댓글이 존제하면 삭제 안됨. **/

			## STEP 1.
			## 회원 정보 로드
			$dataSelectRow		=  $this->getSelect();
		
			## STEP 2.
			## 페이지 설정
			$lock = $this->getLockCheck($dataSelectRow);
			if($lock == "111"):
				echo "비밀글입니다. 다른 회원이 작성한 글입니다.";
				exit;
			elseif($lock == "110"):	
				$this->field['modeBack']	= $this->field['mode'];
				$this->field['mode']		= "dataPassword";
				echo "비밀글입니다. 비회원이 작성한 글입니다.";
				exit;
			endif;

			return parent::getDelete();	
		}

		/**
		 * getDeleteMulti()
		 * 데이터 다중 삭제
		 * **/
		function getDeleteMulti() {

			## STEP 1.
			## 설정
			$commentView	= new CommunityEventCommentView($this->db, $this->field);

			## STEP 1.
			## 권한 체크(관리자 그룹만 삭제 가능)
			if($this->field['member_group'] != "001") { return; }

			## STEP 2.
			## 데이터 삭제
			foreach($this->field['check'] as $ub_no):
				/** 댓글 체크  **/
				$param['b_code']				= $this->field['b_code'];
				$param['cm_ub_no']				= $ub_no;
				$commentCount					= $commentView->getTotalEx($param);			
				if($commentCount > 0) { continue; } /** 댓글이 존제하면 삭제 안됨. **/

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
		 * **/
		function getPassword() {
			
			$selectRow					= $this->getSelect();		

			$resert['mode'] = null;
			$resert['data'] = null;

			if($selectRow['UB_PASS'] == $this->field['ub_pass']):
				// 비밀번호가 일치하면,
				$resert['mode']		= 1;
				$resert['data']		= null;
			endif;

			return $resert;
		}

		/** 
		 * getCreateTable()
		 * 테이블 생성
		 * **/
		function getCreateTable() {
			if(!$this->field['b_code']) { return; }
			$strTableName				= strtoupper($this->field['b_code']);
			$this->field['ub_table']	= "BOARD_UB_{$strTableName}";
			$intTableCnt				= $this->module->getSchemaTableSelect($this->field['ub_table']);

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
		 * getLockCheck(&$row)
		 * 볼수있는 글이면 return "000", 볼수 없는 글이면 return "11X"
		 * **/		
		function getLockCheck(&$row) {
//			$lock_use	= $this->field['BOARD_INFO']['bi_datawrite_lock_use'];
//			$code		= "";
//
//			// 작성된 글이 비밀글이면 1, 아니면 0
//			if     ($lock_use == "E") { $code .= "1"; }
//			else if($lock_use == "C") { $code .= ($row['UB_FUNC']['UB_FUNC_LOCK'] == "Y") ? "1" : "0"; }
//			else                      { $code .= "0"; }
//			echo $lock_use;
//			if($code == "0")		  { return "000"; }

			$code		= "1";

			// 회원이 작성한 글과 로그인 한 회원이 같으면 0, 다르면 1		or
			// 비회원이 작성한 글과 비밀번호가     같으면 0, 다르면 1
			if($this->field['member_login'] && $row['UB_M_NO'] && $this->field['member_no'] == $row['UB_M_NO'])		{ $code .= "0"; }
			elseif($this->field['ub_pass'] && $row['UB_PASS'] && $this->field['ub_pass'] == $row['UB_PASS']) 		{ $code .= "0"; }
			else																									{ $code .= "1"; }

			if($code == "10")		  { return "000"; }

			// 회원이 작성한 글이면 1, 아니면 0
			if($row['UB_M_NO']) { $code .= "1"; }
			else				{ $code .= "0"; }			

			return $code;
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
			if(!$this->field['ub_func_webUse'])			{ $this->field['ub_func_webUse']		= "N"; }
			if(!$this->field['ub_func_mobileUse'])		{ $this->field['ub_func_mobileUse']		= "N"; }

			$ub_func  = "";
			$ub_func .= $this->field['ub_func_notice'];			// 공지글 (사용:Y, 사용안함:N);
			$ub_func .= $this->field['ub_func_lock'];			// 비밀글 (사용:Y, 사용안함:N);
			$ub_func .= $this->field['ub_func_icon'];			// 아이콘 (사용:Y, 사용안함:N);
			$ub_func .= $this->field['ub_func_icon_widget'];	// 위젯추천 (사용:Y, 사용안함:N);
			$ub_func .= $this->field['ub_func_webUse'];			// 웹사용 (사용:Y, 사용안함:N);
			$ub_func .= $this->field['ub_func_mobileUse'];		// 모바일사용 (사용:Y, 사용안함:N);
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

			$data['UB_FUNC_NOTICE']				= $row['UB_FUNC'][0];
			$data['UB_FUNC_LOCK']				= $row['UB_FUNC'][1];
			$data['UB_FUNC_ICON']				= $row['UB_FUNC'][2];
			$data['UB_FUNC_ICON_WIDGET']		= $row['UB_FUNC'][3];
			$data['UB_FUNC_WEBUSE']				= $row['UB_FUNC'][4];
			$data['UB_FUNC_MOBILEUSE']			= $row['UB_FUNC'][5];

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