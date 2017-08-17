<?php
    /**
     * /home/shop_eng/www/classes/client/clientInfo.class.php
     * @author eumshop(thav@naver.com)
     * client info class
	 * $client = new ClientInfo();	
     * **/

	class ClientInfo {

		function __construct() {

		}

		function getMessage() {
			echo "client info class";
		}

		/**
		 * ClientInfo::getClientIP()
		 * 클라이언트 아이피 호출
		 * **/
		static function getClientIP() {
			$clientIP = $_SERVER['REMOTE_ADDR'];

			if($_SERVER['HTTP_X_FORWARDED_FOR']) :
				$clientIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
			endif;

			return $clientIP;
		}

	}

