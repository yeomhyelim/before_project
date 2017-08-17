<?php
    /**
     * /home/shop_eng/www/modules/community/group/basic.1.0/community.group.view.php
     * @author eumshop(thav@naver.com)
     * community group view class (basic.1.0)
     * **/

	require_once MALL_HOME . "/modules/community/community.view.php";
	require_once MALL_HOME . "/modules/community/group/basic.1.0/community.group.module.php";

    class CommunityGroupView extends CommunityView {

		/**
		 * __construct(&$db, &$field)
		 * 생성자
		 * **/
		function __construct(&$db, &$field) {
			$this->module	= new CommunityGroupModule($db, $field);
			$this->name		="GroupMgr";
			$this->field	= &$field;
		}

		/**
		 * getMessage()
		 * 메시지
		 * **/
		function getMessage() {
			echo "community group view class (basic.1.0)";
		}

		/**
		 * getUploadWebPath()
		 * 업로드 파일 웹 경로
		 * **/
		function getUploadWebPath() {
			$f_spath		= "/upload/community/group/";
			return $f_spath;
		}

		/**
		 * getList()
		 * 데이터 리스트
		 * **/
		function getList() {
			$this->field['bg_file1_wpath']	= $this->getUploadWebPath();
			$this->field['bg_file2_wpath']	= $this->getUploadWebPath();
			$this->field['orderby']			= "bg_no desc";
			return parent::getList();
		}

		function getAryList() {
			$this->field['orderby']			= "bg_no desc";
			return parent::getList('OP_ARYLIST');
		}

		/**
		 * getSelect()
		 * 데이터 정보
		 * **/
		function getSelect() {
			$this->field['bg_file1_wpath']	= $this->getUploadWebPath();
			$this->field['bg_file2_wpath']	= $this->getUploadWebPath();
			return parent::getSelect();		
		}


    }
?>