<?php
    /**
     * /home/shop_eng/www/modules/community/menu/basic.1.0/community.menu.view.php
     * @author eumshop(thav@naver.com)
     * community menu view class (basic.1.0)
     * **/
	
	require_once MALL_HOME . "/modules/community/community.view.php";
//	require_once MALL_HOME . "/modules/community/menu/basic.1.0/community.menu.module.php";

    class CommunityMenuView extends CommunityView {

		/**
		 * __construct(&$db, &$field)
		 * 생성자
		 * **/
		function __construct(&$db, &$field) {
//			$this->module	= new CommunityMenuModule($db, $field);
//			$this->name		="MenuMgr";
			$this->field	= &$field;
		}

		/**
		 * getMessage()
		 * 메시지
		 * **/
		function getMessage() {
			echo "community menu view class (basic.1.0)";
		}

		/**
		 * getDataMenuList()
		 * 데이터 리스트
		 * **/
		function getDataMenuList() {
			$groupListFileName = "{$this->field['S_DOCUMENT_ROOT']}{$this->field['S_SHOP_HOME']}/conf/community/groupList.info.php";
			$boardListFileName = "{$this->field['S_DOCUMENT_ROOT']}{$this->field['S_SHOP_HOME']}/conf/community/boardList.info.php";
			
			if(!is_file($groupListFileName)) { return; }
			if(!is_file($boardListFileName)) { return; }

			$group = $this->field['group'];

			include $groupListFileName;
			include $boardListFileName;

		// $GROUP_LIST[$group]
		//	print_r($BOARD_LIST);

			foreach($BOARD_LIST as $boardList):
				if($boardList['b_bg_no'] == $group):
					echo "A";
				endif;
			endforeach;
		}

    }
?>