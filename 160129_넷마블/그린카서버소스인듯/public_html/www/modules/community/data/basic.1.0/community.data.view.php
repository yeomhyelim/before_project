<?php
    /**
     * /home/shop_eng/www/modules/community/data/basic.1.0/community.data.view.php
     * @author eumshop(thav@naver.com)
     * community data view class (basic.1.0)
	 * $dataView = new CommunityDataView($db, $_REQUEST);
     * **/
	require_once MALL_HOME . "/modules/community/comment/basic.1.0/community.comment.view.php";
	require_once MALL_HOME . "/modules/community/attachedfile/basic.1.0/community.attachedfile.view.php";
	require_once MALL_HOME . "/modules/community/userfield/basic.1.0/community.userfield.view.php";
	require_once MALL_HOME . "/modules/community/eventInfo/basic.1.0/community.eventInfo.view.php";

	require_once MALL_HOME . "/modules/community/community.view.php";
	require_once MALL_HOME . "/modules/community/data/basic.1.0/community.data.module.php";

    class CommunityDataView extends CommunityView {

		## 기본 함수. 

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
			$this->getButtonLockCode();		// 신규
//			$this->getButtonAuth();
		}

		/**
		 * getMessage()
		 * 메시지
		 * **/
		function getMessage() {
			echo "community data view class (basic.1.0)";
		}
		
		/**
		 * getListProcess()
		 * 리스트 프로세스
		 * **/
		function getListProcess() {

			## STEP 1.
			## 데이터 리스트
			if($this->field['S_SHOP_HOME'] == "demo2"):
				## 2013.07.27
				## kim hee sung
				## 소스 정리
//				$param									= "";
//				$param['b_code']						= $this->field['b_code'];
//				$this->field['result']['DataMgr']		= $this->module->getDataMgrSelectEx("OP_LIST", $param);

				$this->field['result']['DataMgr']		= $this->getListExMake();
			
				//echo $this->field['b_code'];
			else:
				$this->field['result']['DataMgr']		= $this->getListExMake();
			endif;

			##STEP 2.
			## 포인트 & 쿠폰
			$this->field['result']['pointSet']		= $this->getPointEx("w");
			$this->field['result']['couponSet']		= $this->getCouponEx("w");

			##STEP 3.
			## 구매한 상품인지 확인
//			if($this->field['S_SHOP_HOME'] == "demo2"):
				if ($this->field['b_code'] == "PROD_REVIEW"){
					$this->field['result']['member_product_order_cnt'] = 0;
					if ($this->field['member_no'] && $this->field['member_no'] > 0){
						
						$param['ub_p_code']					= $this->field['ub_p_code'];
						$param['ub_m_no']					= $this->field['member_no'];
						$param['product_download']			= $this->field['S_FIX_PROD_LIST_USER_FLAG']; //다운로드 상품일 경우
						$param['prod_cate_not_in']			= $this->field['S_FIX_PROD_VIEW_MOVIE_CATE_NOT_LIST']; //다운로드 상품 카테고리가 아닐 경우	
						$this->field['result']['member_product_order_cnt'] = parent::getProductSelectEx("OP_COUNT",$param);
					}	
				}
//			endif;
		}

		/**
		 * getWriteProcess()
		 * 쓰기 프로세스
		 * **/
		function getWriteProcess() {

		}

		/**
		 * getModifyProcess()
		 * 수정 프로세스
		 * **/
		function getModifyProcess() {

			## STEP 1.
			## 권한 체크
			if($this->field['S_SHOP_HOME'] != "demo2" && $this->field['S_PAGE_AREA'] != "adminPage"):
				$this->getDataAuthCheck();
				if(!$this->field['dataAuth']['check']):
					$this->field['mode']			= "dataPassword";
					$this->field['act']				= "";
					$this->field['password_mode']	= "dataModify";
					$this->field['password_act']	= "goDataLocation";
					return;
				endif;
			endif;

			## STEP 2.
			## 데이터 
			if($this->field['S_SHOP_HOME'] == "demo2"):

				## 데이터 뷰
				$param								= "";
				$param['b_code']					= $this->field['b_code'];
				$param['ub_no']						= $this->field['ub_no'];

				## 2103.07.25 kim hee sung, 입점몰 로그인 한 경우, PROD_QNA, PROD_REVIEW 는 해당 입점몰 관련 글만 표시
				if($this->field['member_type'] == "S"):
					if(in_array($this->field['b_code'], array("PROD_QNA","PROD_REVIEW"))):
						$param['product_mgr_use']	= "Y";
						$param['p_shop_no']			= $this->field['member_shop_no'];
					endif;
				endif;

				$this->field['result']['DataMgr']		= $this->module->getDataMgrSelectEx("OP_SELECT", $param);
			else:
			$this->field['result']['DataMgr']			= $this->getSelect();
			endif;

			## STEP 3.
			## 사용자 필드
			$userfieldView								= new CommunityUserfieldView($this->db, $this->field);
			$this->field['result']['UserfieldMgr']		= $userfieldView->getView();

			## STEP 4.
			## 첨부파일 필드
			$attachedfileView							= new CommunityAttachedfileView($this->db, $this->field);
			$this->field['result']['AttachedfileMgr']	= $attachedfileView->getList();
		}



		/**
		 * getViewProcess()
		 * 뷰 프로세스
		 * **/
		function getViewProcess() {

			## 2013.07.25 kim hee sung 소스 정리
			if($this->field['S_SHOP_HOME'] == "demo2"):

				## 데이터 뷰
				$param								= "";
				$param['b_code']					= $this->field['b_code'];
				$param['ub_no']						= $this->field['ub_no'];

				## 2103.07.25 kim hee sung, 입점몰 로그인 한 경우, PROD_QNA, PROD_REVIEW 는 해당 입점몰 관련 글만 표시
				if($this->field['member_type'] == "S"):
					if(in_array($this->field['b_code'], array("PROD_QNA","PROD_REVIEW"))):
						$param['product_mgr_use']	= "Y";
						$param['p_shop_no']			= $this->field['member_shop_no'];
					endif;
				endif;

				$this->field['result']['DataMgr']	= $this->module->getDataMgrSelectEx("OP_SELECT", $param);

				## 조회수 1증가.
				parent::getReadUpdate();
			else:
				## STEP 1.
				## 데이터 뷰
				$this->field['result']['DataMgr']			= $this->getView();
			endif;


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
			if(in_array($this->field['BOARD_INFO']['bi_comment_use'], array("A","M"))):
			$this->field['cm_ub_no']					= $this->field['ub_no'];
			$commentView								= new CommunityCommentView($this->db, $this->field);
			$this->field['result']['CommentMgr']		= $commentView->getListEx();
			endif;

			##STEP 5.
			## 포인트 & 쿠폰
			$this->field['result']['pointSet']		= $this->getPointEx("c");
			$this->field['result']['couponSet']		= $this->getCouponEx("c");

			##STEP 6.
			## 이전글 & 다음글
			$param['myTarget']		= $this->field['myTarget'];
			if($this->field['myTarget'] == "mypage"):
			$param['ub_m_no']		= $this->field['member_no'];
			endif;
			$param['b_code']		= $this->field['b_code'];
			$param['ub_no']			= $this->field['ub_no'];
			$param['limit_first']	= 0;
			$param['page_line']		= 1;

			## 2014.07.24 KIM HEE SUNG, 다음글
			$param['orderby']		= "SUBSTRING(UB_FUNC,1,1) DESC, a.UB_ANS_NO ASC";
			$this->field['result']['DataMgr']['nextRow'] = $this->getNextSelectEx($param);
			
			## 2014.07.24 KIM HEE SUNG, 이전글
			$param['orderby']		= "SUBSTRING(UB_FUNC,1,1) DESC, a.UB_ANS_NO DESC";
			$this->field['result']['DataMgr']['prveRow'] = $this->getPrveSelectEx($param);	
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
				$param['page_line']				= $this->field['BOARD_INFO']['bi_list_default'];
				if($this->field['myTarget']):
					$param['page_line']			= $this->field['BOARD_INFO']['bi_widget_list_default'];
				endif;
			endif;


			## STEP 2.
			## 리스트 만들기
			$param['b_code']		= $this->field['b_code'];
			$param['ub_bc_no']		= $this->field['ub_bc_no'];
			$param['ub_p_code']		= $this->field['ub_p_code'];
			$param['orderby']		= "SUBSTRING(UB_FUNC,1,1) DESC, UB_ANS_NO DESC, UB_ANS_STEP ASC";
			if($this->field['myTarget'] == "widget" && $this->field['BOARD_INFO']['bi_widget_icon_use']=="Y"): /* 위젯글 사용할때 */
			$param['orderby']		= "SUBSTRING(UB_FUNC,1,1) DESC, SUBSTRING(UB_FUNC,4,1) DESC, UB_ANS_NO DESC, UB_ANS_STEP ASC";
			endif;

			## 2103.07.25 kim hee sung, 입점몰 로그인 한 경우, PROD_QNA, PROD_REVIEW 는 해당 입점몰 관련 글만 표시
			if($this->field['member_type'] == "S"):
				if(in_array($this->field['b_code'], array("PROD_QNA","PROD_REVIEW"))):
					$param['product_mgr_use']	= "Y";
					$param['p_shop_no']			= $this->field['member_shop_no'];
				endif;
			endif;

			## 2014.04.28 kim hee sung, S_REQ 테이블은 입점사의 경우, 입접사 별로 리스트를 출력합니다.
			if($this->field['member_type'] == "S"):
				if(in_array($this->field['b_code'], array("S_REQ"))):
					$param['ub_shop_no']			= $this->field['member_shop_no'];
				endif;
			endif;

			## 2013.07.18 kim hee sung, 고미 사이트 요청으로 정렬 기능 추가, 단 답변글이 있는경우 깨짐
			$dataListOrderBy		= $this->field['BOARD_INFO']['bi_datalist_orderby'];
			if($dataListOrderBy):
				$defaultOrderBy['reg_dt_asc']	= "SUBSTRING(UB_FUNC,1,1) DESC, UB_REG_DT ASC";
				$defaultOrderBy['reg_dt_desc']	= "SUBSTRING(UB_FUNC,1,1) DESC, UB_REG_DT DESC";
				$param['orderby']				= $defaultOrderBy[$dataListOrderBy];
			endif;

			## 2014.05.19 kim hee sung,  USER_REPORT 에서 카테고리, 결과검색 추가
			if($this->field['b_code'] == "USER_REPORT"):
				$param['ad_temp1_null']	= ($this->field['BOARD_INFO']["bi_ad_temp1_kind_default"] == $this->field['searchResultState']) ? "Y" : "";
				$param['ad_temp1'] = $this->field['searchResultState'];
				$param['ub_bc_no'] = $this->field['searchCategoryState'];
			endif;

			if($this->field['myTarget'] == "widget"):
			$param['ub_func_notice'] = "N";
			endif;
			$param['myTarget']		= $this->field['myTarget'];			
			if($this->field['myTarget'] == "mypage"): 
			$param['ub_m_no']		= $this->field['member_no'];
			else:
			$param['ub_lng']		= $this->field['S_SITE_LNG'];
			endif;
			if($this->field['myTarget'] == "skin"): 
			$param['ub_m_no']		= $this->field['ub_m_no'];
			else:
			if($this->field['member_group'] == "001") { $param['ub_m_no'] = ""; } /* 관리자 로그인 일때 */
			endif;			
			/** 2013.05.09 코멘트 개수 **/
			if($this->field['BOARD_INFO']['bi_comment_use']!="N"):
				$param['cm_cnt_use']		= "Y";
			endif;	
			/** 2013.05.09 코멘트 개수 **/
			/** 2013.07-02 첨부파일 개수 **/
			if($this->field['BOARD_INFO']['bi_attachedfile_use']):
				$param['file_count_use']	= "Y";
			endif;
			/** 2013.07-02 첨부파일 개수 **/
			/** 2013.07.04 리뷰 페이지는 상품 페이지 표시 **/
			/** 2013.07.09 관리자 페이지 상품 QNA 포함 **/
			if($this->field['b_code'] == "PROD_REVIEW" || $this->field['b_code'] == "PROD_QNA"):
				$param['product_img_use']	= "Y";
			endif;
			/** 2013.07.04 리뷰 페이지는 상품 페이지 표시 **/
			if($this->field['myTarget'] == "widget"){ 
				// 위젯 사용시 위젯 설정을 따라간다.
				$intWidthCnt		= $this->field['BOARD_INFO']['bi_widget_column_default'];
				$intHeightCnt		= $this->field['BOARD_INFO']['bi_widget_list_default'];
				if($intWidthCnt)					{ $paramp['page_line'] = $intWidthCnt;						}
				if($intHeightCnt)					{ $paramp['page_line'] = $intHeightCnt;						}
				if($intWidthCnt && $intHeightCnt)	{ $paramp['page_line'] = $intWidthCnt * $intHeightCnt;		}
			} 

			$param['searchKey']				= $this->field['searchKey'];
			$param['searchVal']				= $this->field['searchVal'];
			$param['searchRegDTStart']		= $this->field['searchRegStartDt'];
			$param['searchRegDTEnd']		= $this->field['searchRegEndDt'];
			$param['page']					= $this->field['page'];
			$param['limit_first']			= $this->field['limit_first'];

			$param['bi_attachedfile_use']	= $this->field['BOARD_INFO']['bi_attachedfile_use'];
			$param['bi_userfield_use']		= $this->field['BOARD_INFO']['bi_userfield_use'];

//			$listResult				= $this->module->getDataMgrSelectEx("OP_LIST", $param);
			$listResult				= parent::getListEx("OP_LIST", $param);
//			echo $this->db->query;
	
			## STEP 3.
			## 페이징 링크 주소
			$queryString	= explode("&", $_SERVER['QUERY_STRING']);
			$linkPage		= "";
			foreach($queryString as $string):
				list($key,$val)		= explode("=", $string);
				if($key == "page")	{ continue; }
				if($linkPage)		{ $linkPage .= "&"; }
				$linkPage		   .= $string;
			endforeach;
			$linkPage		= "./?{$linkPage}&page=";


			## STEP 2.
			## 페이지 만들기
//			$pageParam['list_default']	= $this->field['BOARD_INFO']['bi_list_default'];
			$pageParam['list_default']	= $param['page_line'];
			$pageParam['page_default']	= $this->field['BOARD_INFO']['bi_page_default'];
			if($this->field['myTarget'] == "widget"):
			$pageParam['list_default']	= $this->field['BOARD_INFO']['bi_widget_list_default'];
			$pageParam['page_default']	= $this->field['BOARD_INFO']['bi_widget_page_default'];
			endif;
			$pageParam['page_line']		= $param['page_line'];
			$pageParam['list_total']	= $param['list_total'];
			$pageParam['page']			= $param['page'];
			$pageParam['limit_first']	= $param['limit_first'];
			$pageParam['list_num']		= $param['list_num'];
//			$pageParam['link']			= "./?menuType={$this->field['menuType']}&mode={$this->field['mode']}&b_code={$this->field['b_code']}&ub_bc_no={$this->field['ub_bc_no']}&myTarget={$this->field['myTarget']}&page=";
			$pageParam['link']			= $linkPage;
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
		function getList($op = "OP_LIST") {

			## STEP 1.
			## 기본 설정
//			$this->field['orderby']		= "ub_no desc";
			$this->field['orderby']		= "SUBSTRING(UB_FUNC,1,1) DESC, UB_ANS_NO DESC, UB_ANS_STEP ASC";
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
			$this->field['list_default'][$this->name]		= $this->field['BOARD_INFO']['bi_list_default'];
			$this->field['page_default'][$this->name]		= $this->field['BOARD_INFO']['bi_page_default'];
			$this->field['link'][$this->name]				= "./?menuType={$this->field['menuType']}&mode={$this->field['mode']}&b_code={$this->field['b_code']}&myTarget={$this->field['myTarget']}&page=";
			parent::getPageInfo();
		}


		## FUNCTION()
		## 함수 모음



		
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
		 * 2013.04.20 커뮤니티 공동 모듈로 이동
		 * **/
//		function getUB_FUNC_DECODER(&$row) {
//
//			$data['UB_FUNC_NOTICE']		= $row['UB_FUNC'][0];
//			$data['UB_FUNC_LOCK']		= $row['UB_FUNC'][1];
//			$data['UB_FUNC_ICON']		= $row['UB_FUNC'][2];
//
//			return $data;
//		}




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
		 * getMainList()
		 * 모든 종류의 게시판 리스트
		 * **/
//		function getMainList() {
//			$boardList		= "{$this->field['S_DOCUMENT_ROOT']}{$this->field['S_SHOP_HOME']}/conf/community/boardList.info.php";
//			if(!is_file($boardList)) { return; }
//			include $boardList	;
//
//			$listResult						= "";
//			$this->field['b_use']			= "Y";
//			$intCnt							= 0;
//			foreach($BOARD_LIST as $boardCode => $boardData):
//				$this->field['orderby']					= "UB_ANS_NO DESC, UB_ANS_STEP ASC";
//				$this->field['ub_table']				= "BOARD_UB_{$boardCode}";
//				$this->field['fl_table']				= "BOARD_FL_{$boardCode}";
//				$this->field['page_line']				= 5;
//				$this->field['search_ub_reg_dt_op']		= "";
//				$listResult[$intCnt]					= parent::getList();
//				$list_total[$intCnt]					= $this->field['list_total'];
//				$list_total[$intCnt]					= ($list_total[$intCnt]) ? $list_total[$intCnt] : 0;
//				$list_bcode[$intCnt]					= $boardCode;
//
//				/* 오늘 건수 */
//				$this->field['search_ub_reg_dt_op']		= "TODAY";
//				$list_today[$intCnt]					= parent::getTotal();
//				$list_today[$intCnt]					= ($list_today[$intCnt]) ? $list_today[$intCnt] : 0;
//
//				$intCnt++;
//			endforeach;
//			
//			$this->field['result']['b_code']		= $list_bcode;
//			$this->field['result']['data']			= $listResult;
//			$this->field['result']['list_total']	= $list_total;
//			$this->field['result']['list_today']	= $list_today;
//		}

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
//			$this->field['ub_table']		= "BOARD_UB_{$this->field['b_code']}";
//			$this->field['fl_table']		= "BOARD_FL_{$this->field['b_code']}";
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
    }
?>