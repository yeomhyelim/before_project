<?php
    /**
     * /home/shop_eng/www/modules/point/point.controller.php
     * @author eumshop(thav@naver.com)
     * point controller class
     * **/

	require_once MALL_HOME . "/modules/controller.php";

    class  PointController extends Controller {

		function getMessage() {
			echo "point controller class";
		}
		/**
		 * getPointUpdate()
		 * 포인트 업데이트
		 * **/
		function getPointUpdate() {
			return $this->module->{"get{$this->name}PointUpdate"}();
		}
    }
?>
