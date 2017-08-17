<?php
    /**
     * /home/shop_eng/www/modules/community/boardInfo/basic.1.0/community.boardInfo.view.php
     * @author eumshop(thav@naver.com)
     * community boardInfo view class (basic.1.0)
     * **/

	require_once MALL_HOME . "/modules/community/community.view.php";
	require_once MALL_HOME . "/modules/community/boardInfo/basic.1.0/community.boardInfo.module.php";
	require_once MALL_HOME . "/modules/community/gift/basic.1.0/community.gift.view.php";

    class CommunityBoardInfoView extends CommunityView {

		function __construct(&$db, &$field) {
			$this->module	= new CommunityBoardInfoModule($db, $field);
			$this->name		="BoardInfoMgr";
			$this->field	= &$field;
			$this->db		= &$db;
		}

		function getMessage() {
			echo "community boardInfo view class (basic.1.0)";
		}

		function getAryList() {
			$this->field['ba_b_code'] = $this->field['b_code'];
			return parent::getList("OP_ARYLIST");
		}

		function getModifyPoint() {

			## STEP 1.
			## 선언
			$giftView = new CommunityGiftView($this->db, $this->field);

			## STEP 2.
			## 포인트/쿠폰 설정 리스트
			$param['gm_b_code']					= $this->field['b_code'];
			$param['gm_ub_no']					= -1; 
			$result								= $giftView->getListNoPageEx("OP_LIST", $param);
//			echo $this->db->query;;
			$this->field['result']['GiftMgr']	= $result;

			## STEP 3.
			## 커뮤니티 설정 리스트
			$param['ba_b_code']							= $this->field['b_code'];
			$this->field['result']['BoardInfoMgr']		= $this->getListNoPageEx("OP_ARYLIST", $param);
		}

		function getStopList() {
		}

		function getScriptFilePath() {
		}

		/**
		 * getReadScriptFile()
		 * 커뮤니티 스크립트 불러오기
		 * **/	
		function getReadScriptFile() {
		}
    }
?>