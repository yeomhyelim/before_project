<?php
    /**
     * /home/shop_eng/www/modules/community/attachedfile/basic.1.0/community.attachedfile.view.php
     * @author eumshop(thav@naver.com)
     * community attachedfile view class (basic.1.0)
	 * $attachedfileView = new AttachedfileAttachedfileView($db, $_REQUEST);
     * **/

	require_once MALL_HOME . "/modules/community/community.view.php";
	require_once MALL_HOME . "/modules/community/attachedfile/basic.1.0/community.attachedfile.module.php";

    class CommunityAttachedfileView extends CommunityView {

		## 기본 함수. 

		/**
		 * __construct(&$db, &$field)
		 * 생성자
		 * **/
		function __construct(&$db, &$field) {
			$this->module	= new CommunityAttachedfileModule($db, $field);
			$this->name		="AttachedfileMgr";
			$this->field	= &$field;
//			$this->getButtonAuth();
//			$this->getSessionInfo();
		}

		/**
		 * getMessage()
		 * 메시지
		 * **/
		function getMessage() {
			echo "community attachedfile view class (basic.1.0)";
		}

		## 수행 함수. 

		/**
		 * getList()
		 * 데이터 리스트
		 * **/
		function getList($op = "OP_LIST") {

			## STEP 1.
			## 권한 체크
// 2013.08.13 kim hee sung 관리자 페이지에서 커뮤니티 뷰페이지 상품이 안나왔음.
//			if(!$this->field['dataAuth']['check']) { return; }

			## STEP 1.
			## 사용 유무
			if(!$this->field['BOARD_INFO']['bi_attachedfile_use']) { return; }

			## STEP 2.
			## 설정
			$this->field['fl_table']	= "BOARD_FL_{$this->field['b_code']}";		// 테이블 명
			$this->field['fl_ub_no']	= $this->field['ub_no'];
			$this->field['orderby']		= "fl_no asc";

			## STEP 3.
			## 리스트
			$result = parent::getList();		

			return $result;
		}

		## FUNCTION()
		## 함수 모음


		/**
		 * getLockCheck(&$row)
		 * 볼수있는 글이면 return "000", 볼수 없는 글이면 return "11X"
		 * **/		
		function getLockCheck(&$row) {
		}

		/**
		 * getUB_FUNC_DECODER()
		 * 기능 함수
		 * **/
		function getUB_FUNC_DECODER(&$row) {
		}

    }
?>