<?php
    /**
     * /home/shop_eng/www/modules/eventInfo/event/basic.1.0/community.eventInfo.view.php
     * @author eumshop(thav@naver.com)
     * community eventInfo view class (basic.1.0)
	 * $dataView = new CommunityEventInfoView($db, $_REQUEST);
     * **/

	require_once MALL_HOME . "/modules/community/community.view.php";
	require_once MALL_HOME . "/modules/community/eventInfo/basic.1.0/community.eventInfo.module.php";

    class CommunityEventInfoView extends CommunityView {

		## 기본 함수. 

		/**
		 * __construct(&$db, &$field)
		 * 생성자
		 * **/
		function __construct(&$db, &$field) {
			$this->module	= new CommunityEventInfoModule($db, $field);
			$this->name		="EventInfoMgr";
			$this->db		= &$db;	
			$this->field	= &$field;
		}

		/**
		 * getMessage()
		 * 메시지
		 * **/
		function getMessage() {
			echo "community eventInfo view class (basic.1.0)";
		}

		## 수행 함수. 

		/**
		 * getList()
		 * 데이터 리스트
		 * **/
		function getList($op = "OP_LIST") {
		}

		function getAryListEx() {
			## STEP 1.
			## 사용 유무
			if($this->field['BOARD_INFO']['b_kind'] != "event") { return; } 
//			if($this->field['BOARD_INFO']['bi_point_c_use'] != "Y" && $this->field['BOARD_INFO']['bi_coupon_c_use'] != "Y") { return; }

			$param['be_b_code']	= $this->field['be_b_code'];
			$param['be_ub_no']	= $this->field['ub_no'];
			$result				= $this->module->getEventInfoMgrSelectEx("OP_ARYLIST", $param);

			if($this->field['BOARD_INFO']['bi_point_c_use'] != "Y"):
				$result['BI_POINT_C_USE'] = $this->field['BOARD_INFO']['bi_point_c_use'];
			endif;
			
			if($this->field['BOARD_INFO']['bi_coupon_c_use'] != "Y"):
				$result['BI_COUPON_C_USE'] = $this->field['BOARD_INFO']['bi_coupon_c_use'];
			endif;

			return $result;
		}

		function getAryList() {
			## STEP 1.
			## 사용 유무
			if($this->field['BOARD_INFO']['b_kind'] != "event") { return; }
			if($this->field['BOARD_INFO']['bi_point_c_use'] != "Y" && $this->field['BOARD_INFO']['bi_coupon_c_use'] != "Y") { return; }

			$this->field['be_b_code']	= $this->field['b_code'];
			$this->field['be_ub_no']	= $this->field['ub_no'];
			return parent::getList("OP_ARYLIST");
		}

    }
?>