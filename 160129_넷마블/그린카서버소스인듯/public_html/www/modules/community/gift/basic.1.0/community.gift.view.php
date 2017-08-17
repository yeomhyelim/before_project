<?php
    /**
     * /home/shop_eng/www/modules/gift/event/basic.1.0/community.gift.view.php
     * @author eumshop(thav@naver.com)
     * community gift view class (basic.1.0)
	 * $dataView = new CommunityGiftView($db, $_REQUEST);
     * **/

	require_once MALL_HOME . "/modules/community/community.view.php";
	require_once MALL_HOME . "/modules/community/gift/basic.1.0/community.gift.module.php";

    class CommunityGiftView extends CommunityView {

		/**
		 * __construct(&$db, &$field)
		 * 생성자
		 * **/
		function __construct(&$db, &$field) {
			$this->module	= new CommunityGiftModule($db, $field);
			$this->name		="GiftMgr";
			$this->db		= &$db;	
			$this->field	= &$field;
		}

		/**
		 * getMessage()
		 * 메시지
		 * **/
		function getMessage() {
			echo "community gift view class (basic.1.0)";
		}
    }
?>