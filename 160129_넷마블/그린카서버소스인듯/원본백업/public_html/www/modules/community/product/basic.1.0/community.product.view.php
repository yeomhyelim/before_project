<?php
    /**
     * /home/shop_eng/www/modules/community/product/basic.1.0/community.product.view.php
     * @author eumshop(thav@naver.com)
     * community product view class (basic.1.0)
	 * $productView = new CommunityProductView($db, $_REQUEST);
     * **/
	require_once MALL_HOME . "/modules/community/comment/basic.1.0/community.comment.view.php";
	require_once MALL_HOME . "/modules/community/attachedfile/basic.1.0/community.attachedfile.view.php";
	require_once MALL_HOME . "/modules/community/userfield/basic.1.0/community.userfield.view.php";
	require_once MALL_HOME . "/modules/community/eventInfo/basic.1.0/community.eventInfo.view.php";

	require_once MALL_HOME . "/modules/community/community.view.php";
	require_once MALL_HOME . "/modules/community/product/basic.1.0/community.product.module.php";

    class CommunityProductView extends CommunityView {

		## 기본 함수. 

		/**
		 * __construct(&$db, &$field)
		 * 생성자
		 * **/
		function __construct(&$db, &$field) {
			$this->module	= new CommunityProductModule($db, $field);
			$this->name		="ProductMgr";
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
			echo "community product view class (basic.1.0)";
		}

		/**
		 * getListProcess()
		 * 리스트 프로세스
		 * **/
		function getListProcess() {
			## STEP 1.
			## 데이터 리스트
			$this->field['result']['DataMgr']		= $this->getListEx();

			##STEP 2.
			## 포인트 & 쿠폰
			$this->field['result']['pointSet']		= $this->getPointEx("w");
			$this->field['result']['couponSet']		= $this->getCouponEx("w");

			##STEP 3.
			## json 호출시 설정
			if($this->field['act'] == "json"):
				$listResult = $this->field['result']['DataMgr']['listResult'];
				while($row = mysql_fetch_array($listResult, MYSQL_ASSOC)):
					$result[] = $row;
				endwhile;
				$this->field['result']['DataMgr']['listResult'] = $result;
			endif;
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
			## 코멘트 필드
			$commentView								= new CommunityCommentView($this->db, $this->field);
			$this->field['result']['CommentMgr']		= $commentView->getList();

			## STEP 4.
			## 첨부파일 필드
			$attachedfileView							= new CommunityAttachedfileView($this->db, $this->field);
			$this->field['result']['AttachedfileMgr']	= $attachedfileView->getList();

			##STEP 5.
			## 포인트 & 쿠폰
			$this->field['result']['pointSet']		= $this->getPointEx("c");
			$this->field['result']['couponSet']		= $this->getCouponEx("c");
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
		/**
		 * getListEx()
		 * 데이터 리스트
		 * **/
		function getListEx() {

			## STEP 1.
			## 리스트 만들기
			$param['ub_p_code']		= $this->field['prodCode'];  
			$param['b_code']		= $this->field['b_code'];
			$param['orderby']		= "SUBSTRING(UB_FUNC,1,1) DESC, UB_ANS_NO DESC, UB_ANS_STEP ASC";
			$param['page_line']		= $this->field['BOARD_INFO']['bi_list_default'];
			$param['page']			= $this->field['page'];
			$param['limit_first']	= $this->field['limit_first'];
//			$listResult				= $this->module->getDataMgrSelectEx("OP_LIST", $param);
			$listResult				= parent::getListEx("OP_LIST", $param);


			## STEP 2.
			## 페이지 만들기
			$pageParam['list_default']	= $this->field['BOARD_INFO']['bi_list_default'];
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
		 * getDataAuthCheck()
		 * 자신의 데이터(글) 인지 체크
		 * **/
		function getDataAuthCheck() {
			$selectRow					= $this->getSelect();
			$auth						= $this->getAuthCheck($selectRow);
			$this->field['dataAuth']	= $auth;
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

		## 수행 함수. 


		/**
		 * getList()
		 * 데이터 리스트
		 * **/
		function getList() {

			## STEP 1.
			## 기본 설정
//			$this->field['orderby']		= "ub_no desc";
			if($this->field['prodCode']):
				$this->field['ub_p_code'] = $this->field['prodCode'];
			else:
				if($this->field['S_PAGE_AREA']=="userPage"):
					$this->field['ub_m_no']	= $this->field['member_no'];
				endif;
			endif;

			$this->field['orderby']		= "SUBSTRING(UB_FUNC,1,1) DESC, UB_ANS_NO DESC, UB_ANS_STEP ASC";
			$this->field['ub_table']	= "BOARD_UB_{$this->field['b_code']}";
			$this->field['fl_table']	= "BOARD_FL_{$this->field['b_code']}";
			$this->field['page_line']	= $this->field['BOARD_INFO']['bi_list_default'];

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
			## JSON 요청시
			if($this->field['mode'] == "json"):
				$result						= null;
				$result['mode']				= 1;
				$result['list_num']			= $this->field['list_num'];
				while($row = mysql_fetch_array($listRow)) :
					$row['UB_REG_DT']	= date("Y-m-d", strtotime($row['UB_REG_DT']));
					$row['UB_FUNC']		= $this->getUB_FUNC_DECODER($row);
					$row['LOCK']		= $this->getLockAuthCheck($row);

				   $intHidden		= $this->field['BOARD_INFO']['bi_datalist_writer_hidden'];
				   if($intHidden):
					   $row['UB_NAME']	= mb_substr($row['UB_NAME'], 0, $intHidden, "UTF-8");
					   $row['UB_NAME']	= str_pad($row['UB_NAME'], ($intHidden+3), "*");
					   $row['UB_M_ID']	= mb_substr($row['UB_M_ID'], 0, $intHidden, "UTF-8");
					   $row['UB_M_ID']	= str_pad($row['UB_M_ID'], ($intHidden+3), "*");
				   endif;

					$result['data'][]	= $row;
				endwhile;
				$this->field['result']		= $result;
				return;
			endif;

			## STEP 6.
			## return
			return $listRow;
		}

		/**
		 * getIconList()
		 * (아이콘 사용하는) 데이터 리스트
		 * **/
		function getIconList() {
			## STEP 1.
			## 기본 설정
//			$this->field['orderby']			= "ub_no desc";
			$this->field['ub_func_icon']	= "Y";
			$this->field['orderby']			= "UB_ANS_NO DESC, UB_ANS_STEP ASC";
			$this->field['ub_table']		= "BOARD_UB_{$this->field['b_code']}";
			$this->field['fl_table']		= "BOARD_FL_{$this->field['b_code']}";
			$this->field['page_line']		= $this->field['BOARD_INFO']['bi_list_default'];

			## STEP 2.
			## 게시판 종류별 설정
			if($this->field['BOARD_INFO']['b_kind'] == "gallery"):
				$this->field['page_line']	= $this->field['BOARD_INFO']['bi_list_default'] * $this->field['BOARD_INFO']['bi_column_default'];
			endif;

			## STEP 3.
			## query 실행
			$listRow					= parent::getList();

			## STEP 5.
			## return
			return $listRow;
		}

		/**
		 * getView()
		 * 데이터 보기
		 * **/
		function getView() {

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

			$auth						= $this->getAuthCheck($selectRow);
			$this->field['dataAuth']	= $auth;

			## STEP 2.
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

			## STEP 3.
			## 해당 글, 버튼 체크
			$this->field['buttonLock']['dataModify']	=  getButtonAuth($this->field, $selectRow, "dataModify");
			$this->field['buttonLock']['dataDelete']	=  getButtonAuth($this->field, $selectRow, "dataDelete");

			## STEP 1.
			## 조회수 1증가.
			$this->getReadUpdate();

			$_SESSION['b_code']		= "";
			$_SESSION['ub_no']		= "";


			## STEP 5
			## 필드락 임시...
			$this->field['fieldLock'] = "000000";
			return $selectRow;
		}

		/**
		 * getWrite()
		 * 데이터 쓰기
		 * **/
		function getWrite() {	
		//	print_r($_SESSION);
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
			$dataSelectRow					=  $this->getSelect();

			## STEP 3.
			## 데이터 전달
			return $dataSelectRow;
		}

//		/**
//		 * getModify()
//		 * 데이터 수정
//		 * **/
//		function getModify() {
//
//			## STEP 1.
//			## 수정 권한 체크 함수
//			function getModifyAuth(&$field, &$row, $key) {
//				if(!$field['buttonLock'][$key]) { return; }							// 0:사용 권한이 없다면
//				if(!$row['UB_M_NO']):												// 0:비회원이 작성한 글인 경우
//					if($field['b_code'] == $_SESSION['b_code'] &&					
//					   $field['ub_no'] == $_SESSION['ub_no']) { return 1; }			// 1:수정가능
//					else { return 2; };												// 2:비밀번호 폼으로 이동 
//				endif;	
//				if(!$field['member_login']) { return; }								// 0:로그인을 하지 않은 경우
//				if($field['member_no'] != $row['UB_M_NO']) { return; }				// 0:로그인 한 회원과 작성된 글의 회원이 다른 경우.
//				return 1;															// 1:수정가능
//			}
//
//			## STEP 2.
//			## 데이터 로드
//			$dataSelectRow					=  $this->getSelect();
//		
//			## STEP 3.
//			## 권한 체크
//			$re								= getModifyAuth($this->field, $dataSelectRow, "dataModify");
//			if(!$re):
//				echo "수정 권한이 없습니다.";
//				exit;			
//			elseif($re == 2):
//				$this->field['includeFile'] = "password";
//				$this->field['mode']		= "dataMPassword";
//				return;
//			endif;
//
//			## STEP 4.
//			## 페이지 설정
////			$lock = $this->getLockCheck($dataSelectRow);
////			if($lock == "111"):
////				echo "비밀글입니다. 다른 회원이 작성한 글입니다.";
////				exit;
////			elseif($lock == "110"):	
////				$this->field['modeBack']	= $this->field['mode'];
////				$this->field['mode']		= "dataPassword";
//////				echo "비밀글입니다. 비회원이 작성한 글입니다.";
//////				exit;
////			endif;
//
//			return $dataSelectRow;
//		}

		/**
		 * getSelect()
		 * 데이터 정보
		 * **/
		function getSelect() {
			$this->field['ub_table']	= "BOARD_UB_{$this->field['b_code']}";
			$this->field['fl_table']	= "BOARD_FL_{$this->field['b_code']}";
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
		 * getButtonAuth()
		 * 버튼 설정
		 * **/
	//	function getButtonAuth() {
	//		$aryButtonList										= array( "datawrite", "datamodify", "datalist", "dataview", "datadelete" );
	//		$this->field['BOARD_INFO']['bi_datamodify_use']		= $this->field['BOARD_INFO']['bi_datawrite_use'];
//
//			foreach($aryButtonList as $key) :
//				$this->field['BOARD_INFO']['bi_'.$key.'_use']	= $this->getButtonAuthFunc($key);
//			endforeach;
//		}

		/**
		 * getButtonAuthFunc($key)
		 * 버튼 설정 함수
		 * **/
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

		/**
		 * getPageInfo()
		 * 페이징 설정
		 * **/
		function getPageInfo() {		
			$this->field['list_default'][$this->name]		= $this->field['BOARD_INFO']['bi_list_default'];
			$this->field['page_default'][$this->name]		= $this->field['BOARD_INFO']['bi_page_default'];
			$this->field['link'][$this->name]				= "./?menuType={$this->field['menuType']}&mode={$this->field['mode']}&b_code={$this->field['b_code']}&page=";
			parent::getPageInfo();
		}


		## FUNCTION()
		## 함수 모음

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
////			elseif($this->field['member_login'] && in_array($this->field['member_type'], array("A", "S")))			{ $auth['check'] = "1"; }	// 관리자 로그인을 했다면 1  /* 2013.04.11 사용자 페이지에서 사용 할 수 없음.*/
//			elseif($this->field['member_login'] && $this->field['member_group'] == "001")							{ $auth['check'] = "1"; }	// 관리자 로그인을 했다면 1
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

		
		function getLockAuthCheck(&$row) {
			$aryFunc	= $this->getUB_FUNC_DECODER($row);
			$auth		= $this->getAuthCheck($row);

			if($auth['UB_FUNC_LOCK']=="N"):
				$auth['check']	= "1";				
			endif;

			return $auth;
		}


		/**
		 * getLockCheck(&$row)
		 * 볼수있는 글이면 return "000", 볼수 없는 글이면 return "11X"
		 * **/		
//		function getLockCheck(&$row) {
//
//			## STEP 1.
//			## 설정
//			$ub_func	= $this->getUB_FUNC_DECODER($row);
//			$lock_use	= $this->field['BOARD_INFO']['bi_datawrite_lock_use'];
//			$code		= "";
//
//			## STEP 2.
//			## 비밀글 사용 유무 체크(사용자선택=C.무조건=E,사용안함=N or '')
//			if     ($lock_use == "E") { $code .= "1"; }
//			else if($lock_use == "C") { $code .= ($ub_func['UB_FUNC_LOCK'] == "Y") ? "1" : "0"; }
//			else                      { $code .= "0"; }
//
//			if($code == "0")		  { return "000"; }
//
//			## STEP 3.
//			## 권한 체크(작성자와 로그인 회원이 같으면 0, 다르면 1 or 비회원이 작성한 글과 비밀번호가     같으면 0, 다르면 1)
//			if($this->field['member_login'] && $row['UB_M_NO'] && $this->field['member_no'] == $row['UB_M_NO'])		{ $code .= "0"; }
//			elseif($this->field['ub_pass'] && $row['UB_PASS'] && $this->field['ub_pass'] == $row['UB_PASS']) 		{ $code .= "0"; }
//			else																									{ $code .= "1"; }
//
//			if($code == "10")		  { return "000"; }
//
//			## STEP 4.
//			## 작성자 체크(회원 1, 비회원 0)
//			if($row['UB_M_NO']) { $code .= "1"; }
//			else				{ $code .= "0"; }			
//
//			return $code;
//		}

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

		function getReadUpdate() {
			$this->field['ub_table']	= "BOARD_UB_{$this->field['b_code']}";
			parent::getReadUpdate();
		}

    }
?>