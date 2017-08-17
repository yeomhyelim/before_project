<?php
    /**
     * /home/shop_eng/www/modules/community/gift/basic.1.0/community.gift.controller.php
     * @author eumshop(thav@naver.com)
     * community gift controller class (basic.1.0)
     * **/

	require_once MALL_HOME . "/modules/community/community.controller.php";
	require_once MALL_HOME . "/modules/community/gift/basic.1.0/community.gift.module.php";

	require_once MALL_HOME . "/classes/file/file.handler.class.php";
// 	require_once MALL_HOME . "/classes/client/client.info.class.php";

    class CommunityGiftController extends CommunityController {

		/**
		 * __construct(&$db, &$field)
		 * 생성자
		 * **/
		function __construct(&$db, &$field) {
			$this->module	= new CommunityGiftModule($db, $field);
			$this->name		="GiftMgr";
			$this->field	= &$field;
			$this->db		= &$db;
		}

		/**
		 * getMessage()
		 * 메시지
		 * **/
		function getMessage() {
			echo "community gift controller class (basic.1.0)";
		}
    }
?>