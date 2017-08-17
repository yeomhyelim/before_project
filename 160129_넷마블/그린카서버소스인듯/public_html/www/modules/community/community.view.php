<?php
    /**
     * /home/shop_eng/www/modules/community/community.view.php
     * @author eumshop(thav@naver.com)
     * community view class
     * **/

	require_once MALL_HOME . "/modules/view.php";

    class  CommunityView extends View {

		/**
		 * getMessage()
		 * 메시지
		 * **/
		function getMessage() {
			echo "community view class";
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
		 * getButtonLockCode()
		 * 기능별 버튼 사용 유무 정의
		 * **/
		function getButtonLockCode() {
			$this->field['buttonLock']['dataList']		= $this->getButtonLock($this->field, "datalist");
			$this->field['buttonLock']['dataView']		= $this->getButtonLock($this->field, "dataview");
			$this->field['buttonLock']['dataWrite']		= $this->getButtonLockEx($this->field, "datawrite");
			$this->field['buttonLock']['dataModify']	= $this->getButtonLock($this->field, "datawrite");
			$this->field['buttonLock']['dataDelete']	= $this->getButtonLock($this->field, "datadelete");
			$this->field['buttonLock']['dataAnswer']	= $this->getButtonLock($this->field, "dataanswer");
		}

		/**
		 * getButtonLock(&$field, $mode)
		 * 버튼 권한 
		 * 0 : 사용권한이 없음, 버튼 숨김
		 * 1 : 사용권한이 있음, 버튼 표시
		 * 2 : 사용권한이 없음, 버튼 표시
		 **/
		function getButtonLock(&$field, $mode) {
			$use = "0";
			if($field['BOARD_INFO']["bi_{$mode}_use"] == "A"): // 모든회원/비회원
				$use = "1";
			elseif($field['BOARD_INFO']["bi_{$mode}_use"] == "M"): // 회원전용
				if($field['member_login']): // 방문자가 회원인경우.
					foreach($field['BOARD_INFO']["bi_{$mode}_member_auth"] as $key => $val):
						if($field['member_group'] == $val) { $use = "1"; }
					endforeach;
				endif;
			endif;
			if($use != 1 && $_SESSION['member_no']):
				$objAdminMgrModule = new AdminMgrModule($this->db);
				$param = "";
				$param['M_NO'] = $_SESSION['member_no'];
				$intAdminCnt = $objAdminMgrModule->getAdminMgrSelectEx("OP_COUNT", $param);
				if($intAdminCnt) { $use = 1; }
			endif;
			return $use;
		}

		function getButtonLockEx(&$field, $mode) {
			$use = $this->getButtonLock($field, $mode);
			if($use != 1):
				if(is_array($field['BOARD_INFO'])){
					foreach($field['BOARD_INFO']["bi_{$mode}_member_auth"] as $key => $val):
						if($val != "001" && $val != "N"):
							$use = 2;
							break;
						endif;
					endforeach;
				}
			endif;
			return $use;
		}

		/**
		 * getCountTotalEx()
		 * 데이터 전체 개수
		 * **/
		function getCountTotalEx() {
			$param['b_code'] = $this->field['b_code'];
			return $this->module->{"get{$this->name}SelectEx"}("OP_COUNT", $param);
		}

		function getNextSelectEx($param) {
			return $this->module->{"get{$this->name}NextSelectEx"}($param);
		}
		
		function getPrveSelectEx($param) {
			return $this->module->{"get{$this->name}PrveSelectEx"}($param);
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
		function getAuthCheck(&$row) {

			if($row['UB_M_NO'])																						{ $auth['member'] = "1"; }
			elseif($this->field['member_login'] && in_array($this->field['member_type'], array("A", "S")))			{ $auth['member'] = "1"; }	// 관리자 로그인을 했다면 1
			else																									{ $auth['member'] = "0"; }

			if($this->field['member_login'] && $row['UB_M_NO'] && $this->field['member_no'] == $row['UB_M_NO'])		{ $auth['check'] = "1"; }	// 회원이 작성한 글과 로그인 한 회원이 같으면 1
			elseif($this->field['ub_pass'] && $row['UB_PASS'] && $this->field['ub_pass'] == $row['UB_PASS']) 		{ $auth['check'] = "1"; }	// 비회원이 작성한 글과 비밀번호가     같으면 1
			elseif($this->field['b_code'] == $_SESSION['b_code'] && $this->field['ub_no'] == $_SESSION['ub_no'])	{ $auth['check'] = "1"; }	// 세션 정보와 작성한 글의 정보가	   같으면 1
//			elseif($this->field['member_login'] && in_array($this->field['member_type'], array("A", "S")))			{ $auth['check'] = "1"; }	// 관리자 로그인을 했다면 1  /* 2013.04.11 사용자 페이지에서 사용 할 수 없음.*/
			elseif($this->field['member_login'] && $this->field['member_group'] == "001")							{ $auth['check'] = "1"; }	// 관리자 로그인을 했다면 1
			elseif($this->field['member_login'] && $this->field['member_type'] == "S")								{ $auth['check'] = "1"; }	// 관리자 로그인을 했다면 1
			else																									{ $auth['check'] = "0"; }	// 권한이 필요한 경우.

			if($auth['check'] == 0 && $row['UB_ANS_NO'] && $row['UB_ANS_NO'] != $row['UB_NO']):
				$ub_no_bak				= $this->field['ub_no'];
				$this->field['ub_no']	=  $row['UB_ANS_NO'];
				$ansRow = $this->getSelect();
				$this->field['ub_no']	= $ub_no_bak;
				return $this->getAuthCheck($ansRow);	// 재귀호출
			endif;

			return $auth;
		}


		/**
		 * getButtonLockCode()
		 * 기능별 버튼 사용 유무 정의
		 * **/
//		function getButtonLockCode() {
//			
//			function getButtonLock(&$field, $key) {
//				$use = "0";
//
//				if($field['BOARD_INFO']["bi_{$key}_use"] == "A"): // 모든회원/비회원
//					$use = "1";
//				elseif($field['BOARD_INFO']["bi_{$key}_use"] == "M"): // 회원전용
//					if($field['member_login']): // 방문자가 회원인경우.
//						foreach($field['BOARD_INFO']['bi_{$key}_member_auth'] as $key => $val):
//							if($field['member_group'] == $val) { $use = "1"; }
//						endforeach;
//					endif;
//				endif;
//				return $use;
//			}
//
//			function getAnswerLock(&$field, $key) {
//				$use = "0";
//				if($field['BOARD_INFO']['b_skin'] == "answer"):
//				$use = "1";
//				endif;
//				return $use;
//			}
//
//			// 리스트버튼=0, 보기버튼=1, 글쓰기버튼=2, 수정버튼=3, 삭제버튼=4, 답변버튼=5
//			$code  = "";
//			$code .= getButtonLock($this->field, "datalist");
//			$code .= getButtonLock($this->field, "dataview");
//			$code .= getButtonLock($this->field, "datawrite");
//			$code .= getButtonLock($this->field, "datawrite");
//			$code .= getButtonLock($this->field, "datadelete");
//			$code .= getAnswerLock($this->field, "dataanswer");
//
////			$this->field['buttonLock']					= $code; 
//			$this->field['buttonLockEx']['dataList']	= $code[0];
//			$this->field['buttonLockEx']['dataView']	= $code[1];
//			$this->field['buttonLockEx']['dataWrite']	= $code[2];
//			$this->field['buttonLockEx']['dataModify']	= $code[3];
//			$this->field['buttonLockEx']['dataDelete']	= $code[4];
//			$this->field['buttonLockEx']['dataAnswer']	= $code[5];
//			$this->field['buttonLockHelp']				= " 리스트버튼=0, 보기버튼=1, 글쓰기버튼=2, 수정버튼=3, 삭제버튼=4, 답변버튼=5";
//		}


    }
?>
