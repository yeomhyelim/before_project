<?php
    /**
     * /home/shop_eng/www/modules/community/eventInfo/basic.1.0/community.eventInfo.controller.php
     * @author eumshop(thav@naver.com)
     * community eventInfo controller class (basic.1.0)
     * **/

	require_once MALL_HOME . "/modules/community/community.controller.php";
	require_once MALL_HOME . "/modules/community/eventInfo/basic.1.0/community.eventInfo.module.php";

	require_once MALL_HOME . "/classes/file/file.handler.class.php";
 //	require_once MALL_HOME . "/classes/client/client.info.class.php";

    class CommunityEventInfoController extends CommunityController {

		/**
		 * __construct(&$db, &$field)
		 * 생성자
		 * **/
		function __construct(&$db, &$field) {
			$this->module	= new CommunityEventInfoModule($db, $field);
			$this->name		="EventInfoMgr";
			$this->field	= &$field;
			$this->getSessionInfo();
		}

		/**
		 * getMessage()
		 * 메시지
		 * **/
		function getMessage() {
			echo "community eventInfo controller class (basic.1.0)";
		}

		/**
		 * getBoardEventInfoKeyDefine($act)
		 * 커뮤니티 이벤트 $act 호출에 따른 info 정보
		 * **/
		function getBoardEventInfoKeyDefine($act) {

			$aryBoardEventInfo['dataModify']			= 	array(	
//																	"BI_POINT_USE"					=> "포인트사용(사용=Y, 사용안함=N)",
																	"BI_POINT_W_USE"				=> "글쓰기시 포인트지급(사용=Y, 사용안함=N)",
																	"BI_POINT_W_GIVE"				=> "글쓰기시 포인트지급방법(자동=A, 수동=M)",
//																	"BI_POINT_W_MARK"				=> "글쓰기시 포인트",
																	"BI_COUPON_W_USE"				=> "글쓰기시 쿠폰지급사용(사용=Y, 사용안함=N)",
																	"BI_COUPON_W_GIVE"				=> "글쓰기시 쿠폰지급방법(자동=A, 수동=M)",
//																	"BI_COUPON_W_MARK"				=> "글쓰기시 쿠폰",
																	"BI_POINT_C_USE"				=> "댓글 포인트지급사용(사용=Y, 사용안함=N)",
																	"BI_POINT_C_GIVE"				=> "댓글 포인트지급방법(자동=A, 수동=M)",
///																	"BI_POINT_C_MARK"				=> "댓글 포인트",
																	"BI_COUPON_C_USE"				=> "댓글 쿠폰지급사용(사용=Y, 사용안함=N)",
																	"BI_COUPON_C_GIVE"				=> "댓글 쿠폰지급방법(자동=A, 수동=M)",
//																	"BI_COUPON_C_MARK"				=> "댓글 쿠폰",
//																	"BI_COUPON_C_COUPON"			=> "댓글 쿠폰 번호",
//																	"BI_POINT_W_MULTI_COUNT"		=> "글쓰기 차등 포인트 지급 개수",
//																	"BI_POINT_W_MULTI_TITLE"		=> "글쓰기 차등 포인트 제목",
//																	"BI_POINT_W_MULTI_POINT"		=> "글쓰기 차등 포인트 포인트",
//																	"BI_POINT_W_MULTI_MAX"			=> "글쓰기 차등 포인트 컬럼 수",	
//																	"BI_COUPON_W_MULTI_COUNT"		=> "글쓰기 차등 쿠폰 지급 개수",
//																	"BI_COUPON_W_MULTI_TITLE"		=> "글쓰기 차등 쿠폼 제목",
//																	"BI_COUPON_W_MULTI_COUPON"		=> "글쓰기 차등 쿠폰 포인트",
//																	"BI_COUPON_W_MULTI_MAX"			=> "글쓰기 차등 쿠폰 포인트",
//																	"BI_POINT_C_MULTI_COUNT"		=> "댓글 글쓰기 차등 포인트 지급 개수",
//																	"BI_POINT_C_MULTI_TITLE"		=> "댓글 글쓰기 차등 포인트 제목",
//																	"BI_POINT_C_MULTI_POINT"		=> "댓글 글쓰기 차등 포인트 포인트",
//																	"BI_POINT_C_MULTI_MAX"			=> "댓글 글쓰기 차등 포인트 컬럼 수",
//																	"BI_COUPON_C_MULTI_COUNT"		=> "댓글 글쓰기 차등 쿠폰 지급 개수",
//																	"BI_COUPON_C_MULTI_TITLE"		=> "댓글 글쓰기 차등 쿠폼 제목",
//																	"BI_COUPON_C_MULTI_COUPON"		=> "댓글 글쓰기 차등 쿠폰 포인트",
//																	"BI_COUPON_C_MULTI_MAX"			=> "댓글 글쓰기 차등 쿠폰 포인트",							
																	);


			return ($act) ? $aryBoardEventInfo[$act] : $aryBoardEventInfo;
		}

		/**
		 * getSelect()
		 * 데이터 정보
		 * **/
		function getSelect() {
		}

		/**
		 * getWrite()
		 * 데이터 등록
		 * **/
		function getWrite() {
			
			## STEP 1.
			## 사용 유무
			if($this->field['BOARD_INFO']['b_kind'] != "event") { return; }
			if($this->field['bi_point_c_use'] != "Y" && $this->field['bi_coupon_c_use'] != "Y") { return; }

			## STEP 1.
			## 설정

			## STEP 2.
			##  설정 정보 DB에 등록
			$aryBoardEventInfoSet		= $this->getBoardEventInfoKeyDefine();

			foreach($aryBoardEventInfoSet as $act => $set):
				foreach($set as $key => $comment):
					$field = $this->field[strtolower($key)];
					if(is_array($field)):
						foreach($field as $fieldKey => $fieldVal):
							$this->field['be_b_code']	= $this->field['b_code'];
							$this->field['be_ub_no']	= $this->field['ub_no'];
							$this->field['be_key']		= "{$key}_{$fieldKey}" ;
							$this->field['be_val']		= $fieldVal;
							$this->field['be_comment']	= $comment;
							parent::getWriteModify();
						endforeach;
					else:
						$this->field['be_b_code']	= $this->field['b_code'];
						$this->field['be_ub_no']	= $this->field['ub_no'];
						$this->field['be_key']		= $key;
						$this->field['be_val']		= $field;
						$this->field['be_comment']	= $comment;
						parent::getWriteModify();
					endif;
				endforeach;	
			endforeach;
		}
		/**
		 * getModify()
		 * 데이터 수정
		 * **/
		function getModify() {
		}

		/**
		 * getWriteModify()
		 * 데이터 등록&수정
		 * **/
		function getWriteModify() {

			## STEP 1.
			## 사용 유무
			if($this->field['BOARD_INFO']['b_kind'] != "event") { return; }
			if($this->field['bi_point_c_use'] != "Y" && $this->field['bi_coupon_c_use'] != "Y") { return; }

			## STEP 2.
			## 데이터 기록
			$aryBoardEventInfoSet		= $this->getBoardEventInfoKeyDefine("dataModify");

			if(is_array($aryBoardEventInfoSet)):
				foreach($aryBoardEventInfoSet as $key => $comment):
					$field = $this->field[strtolower($key)];
					if(is_array($field)):
						foreach($field as $fieldKey => $fieldVal):
							$this->field['be_b_code']	= $this->field['b_code'];
							$this->field['be_ub_no']	= $this->field['ub_no'];
							$this->field['be_key']		= "{$key}_{$fieldKey}" ;
							$this->field['be_val']		= $fieldVal;
							$this->field['be_comment']	= $comment;
							parent::getWriteModify();
						endforeach;
					else:
						$this->field['be_b_code']		= $this->field['b_code'];
						$this->field['be_ub_no']		= $this->field['ub_no'];
						$this->field['be_key']			= $key;
						$this->field['be_val']			= $field;
						$this->field['be_comment']		= $comment;
						parent::getWriteModify();
					endif;
				endforeach;
			endif;
		}

		/**
		 * getDelete()
		 * 데이터 삭제
		 * **/
		function getDelete() {
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
		}

		/**
		 * getUB_FUNC_DECODER()
		 * 기능 함수
		 * **/
		function getUB_FUNC_DECODER(&$row) {
		}
    }
?>