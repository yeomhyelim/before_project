<?php
    /**
     * /home/shop_eng/www/modules/community/board/basic.1.0/community.board.view.php
     * @author eumshop(thav@naver.com)
     * community board view class (basic.1.0)
	 * $boardView = new CommunityBoardView($db, $_REQUEST);
     * **/

	require_once MALL_HOME . "/modules/community/community.view.php";
	require_once MALL_HOME . "/modules/community/board/basic.1.0/community.board.module.php";

    class CommunityBoardView extends CommunityView {

		## 기본 함수. 

		/**
		 * __construct(&$db, &$field)
		 * 생성자
		 * **/
		function __construct(&$db, &$field) {
			$this->module	= new CommunityBoardModule($db, $field);
			$this->name		="BoardMgr";
			$this->field	= &$field;
		}

		/**
		 * getMessage()
		 * 메시지
		 * **/
		function getMessage() {
			echo "community basic board view class";
		}

		## 수행 함수. 

		/**
		 * getList()
		 * 데이터 리스트
		 * **/
		function getList() {
			
			## STEP 1.
			## 설정					
			$this->field['b_code']		= "";
			$this->field['b_use']		= ($this->field['b_use']) ? $this->field['b_use'] : "Y";
			$this->field['orderby']		= "a.B_REG_DT DESC";

			## STEP 2.
			## 실행
			$listRow					= parent::getList();

			## STEP 3.
			## 페이징 실행
			$this->getPageInfo();

			## STEP 4.
			## return
			return $listRow;
		}

		/**
		 * getScriptFilePath()
		 * 스크립트 파일 경로
		 * **/
//		function getScriptFilePath() {
//			return "{$this->field['S_DOCUMENT_ROOT']}{$this->field['S_SHOP_HOME']}/layout/board/{$this->field['b_code']}/script.html.php";
//		}

		/**
		 * getPageInfo()
		 * 페이징 설정
		 * **/
		function getPageInfo() {		
			$this->field['list_default'][$this->name]		= 10;
			$this->field['page_default'][$this->name]		= 10;
			$this->field['link'][$this->name]				= "./?menuType={$this->field['menuType']}&mode={$this->field['mode']}&b_code={$this->field['b_code']}&page=";
			parent::getPageInfo();
		}
    }
?>