<?php
    /**
     * /home/shop_eng/www/modules/point/data/basic.1.0/point.data.view.php
     * @author eumshop(thav@naver.com)
     * point data view class (basic.1.0)
	 * $pointDataView = new PointDataView($db, $_REQUEST);
     * **/

	require_once MALL_HOME . "/modules/point/point.view.php";
	require_once MALL_HOME . "/modules/point/data/basic.1.0/point.data.module.php";

    class PointDataView extends PointView {

		/**
		 * __construct(&$db, &$field)
		 * 생성자
		 * **/
		function __construct(&$db, &$field) {
			$this->module	= new PointDataModule($db, $field);
			$this->name		="PointMgr";
			$this->db		= &$db;	
			$this->field	= &$field;
		}

		/**
		 * getMessage()
		 * 메시지
		 * **/
		function getMessage() {
			echo "point data view class (basic.1.0)";
		}


    }
?>