<?php
    /**
     * /home/shop_eng/www/modules/category/group/basic.1.0/community.category.view.php
     * @author eumshop(thav@naver.com)
     * community category view class (basic.1.0)
     * **/

	require_once MALL_HOME . "/modules/community/community.view.php";
	require_once MALL_HOME . "/modules/community/category/basic.1.0/community.category.module.php";

    class CommunityCategoryView extends CommunityView {

		/**
		 * __construct(&$db, &$field)
		 * 생성자
		 * **/
		function __construct(&$db, &$field) {
			$this->module	= new CommunityCategoryModule($db, $field);
			$this->name		="CategoryMgr";
			$this->field	= &$field;
		}

		/**
		 * getMessage()
		 * 메시지
		 * **/
		function getMessage() {
			echo "community category view class (basic.1.0)";
		}

		/**
		 * getUploadWebPath()
		 * 업로드 파일 웹 경로
		 * **/
		function getUploadWebPath() {
		}

		/**
		 * getList()
		 * 데이터 리스트
		 * **/
		function getList() {
			$f_spath							= "/upload/community/category/";
			$this->field['bc_image_1_wpath']	= $f_spath;
			$this->field['bc_image_2_wpath']	= $f_spath;
			$this->field['bc_b_code']			= $this->field['b_code'];
			$this->field['orderby']				= "BC_SORT desc";
			$result =  parent::getList();

			return $result;
		}

		function getAryList() {
		}

		/**
		 * getSelect()
		 * 데이터 정보
		 * **/
		function getSelect() {	

			## STEP 1.
			## 데이터 체크
			if(!$this->field['bc_no']) { return; }

			## STEP 2.
			## 설정
			$f_spath							= "/upload/community/category/";
			$this->field['bc_image_1_wpath']	= $f_spath;
			$this->field['bc_image_2_wpath']	= $f_spath;
			
			## STEP 3.
			## 데이터 가져오기
			return parent::getSelect();
		}


    }
?>