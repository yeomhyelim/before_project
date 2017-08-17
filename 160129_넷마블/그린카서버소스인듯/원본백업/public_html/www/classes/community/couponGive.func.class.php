<?php
    /**
     * /home/shop_eng/www/classes/community/couponGive.func.class.php
     * @author eumshop(thav@naver.com)
     * 커뮤니티 글 작성시 쿠폰 지급
     * **/

	require_once MALL_HOME . "/classes/client/client.info.class.php";
	require_once MALL_HOME . "/modules/coupon/data/basic.1.0/coupon.data.controller.php";
	require_once MALL_HOME . "/modules/coupon/issue/basic.1.0/coupon.issue.controller.php";
	require_once MALL_HOME . "/modules/member/data/basic.1.0/member.data.controller.php";

    class CouponGive  {

		var $db;
		var	$field;
		var $dataView;
		var $dataController;

		/**
		 * __construct(&$db, &$field)
		 * 생성자
		 * **/
		function __construct(&$db, &$field) {
			$this->db		= &$db;
			$this->field	= &$field;
		}

		function getDataView(&$obj) {
			$this->dataView = &$obj;
		}
		
		function getDataController(&$obj) {
			$this->dataController = &$obj;
		}

		/**
		 * getMessage()
		 * 메시지
		 * **/
		function getMessage() {
			echo "커뮤니티 글 작성시 쿠폰 지급";
		}

		/**
		 * getPointProcess($paramData)
		 * 포인트 발급
		 * **/
		function getCouponProcess($paramData) {

			## STEP 1.
			## 포인트 발급
			$this->getCouponGiveKindEx($paramData);			
		}

		function getCouponGiveKindEx($paramData) {
			if($paramData['give_type'] == "A"):
				// 자동 포인트 지급
				$param['list']	= array($this->field['ub_no']);
				$param['memo']	= "커뮤니티 글 작성 포인트 지급(BOARD_UB_{$this->field['b_code']})";;
				$param['point'] = $this->field['BOARD_INFO']['bi_point_w_mark'];	
				$this->getCouponGiveEx($param);
			elseif($paramData['give_type'] == "M"):
				// 수동 포인트 지급
				$param['list']	= $this->field['check'];
				$param['memo']	= "커뮤니티 글 작성 포인트 지급(BOARD_UB_{$this->field['b_code']})";;
				$param['point'] = $this->field['BOARD_INFO']['bi_point_w_mark'];	
				$this->getCouponGiveEx($param);
			elseif($paramData['give_type'] == "T"):
				// 다중 포인트 지급
				$param['list']	= $this->field['check'];
				$no				= $this->field['bi_point_w_multi_no'];
				$param['count'] = $this->field['BOARD_INFO']['bi_point_w_multi_count'][$no];
				$param['memo']	= $this->field['BOARD_INFO']['bi_point_w_multi_title'][$no];
				$param['point'] = $this->field['BOARD_INFO']['bi_point_w_multi_point'][$no];	
				$this->getCouponGiveEx($param);
			else:
				echo "포인트를 발급 할 수 없습니다.";
				return;
			endif;
		}

		/**
		 * getCouponGiveEx()
		 * 포인트 지급
		 * 발급 개수 지정이 안됨.(추후 작업)
		 * **/
		function getCouponGiveEx($paramData) {
			$client							= new ClientInfo();	
			$couponIssueController			= new CouponIssueController($this->db, $this->field);
			$couponDataController			= new CouponDataController($this->db, $this->field);
			$memberController				= new MemberDataController($this->db, $this->field);

			foreach($paramData['list'] as $ub_no):
				## STEP 1.
				## 커뮤니티 데이터 가져오기
				$dataParam['b_code']			= $this->field['b_code'];
				$dataParam['ub_no']				= $ub_no;
//				$dataView						= $this->getCommunityView();
				$dataSelectRow					= $this->dataView->getSelectEx($dataParam);
				if($dataSelectRow['UB_CI_NO']):
					// 이미 발급된 게시글
//					continue;
				endif;

				## STEP 2.
				## 쿠폰 지급 체크 1회 이상 지급 안됨.
				## 2013.04.09 커뮤니티 글인 경우 1회 이상 지급 안됨으로 설졍할 경우, 1회성 쿠폰 지급으로 끝나기 때문에 사용 못함.

				## STEP 3.
				## 쿠폰 번호 생성			
				$cu_no							= $paramData['coupon'];
//				$couponIssueController			= new CouponIssueController($this->db, $this->field);
				$cl_code						= $couponIssueController->getMakeCiCode($cu_no);
				if(!$cl_code):
					echo  "쿠폰 번호를 받아올수 없습니다. 오류 처리..";
					exit;
				endif;

				## STEP 4.
				## 쿠폰 지급
				$couponParam['m_no']			= $dataSelectRow['UB_M_NO'];
				$couponParam['cu_no']			= $cu_no;
				$couponParam['b_no']			= $ub_no;
				$couponParam['ci_code']			= $cl_code;
				$couponParam['ci_memo']			= $paramData['memo'];
				$couponParam['ci_reg_no']		= $this->field['member_no'];	
				$ub_ci_no						= $couponIssueController->getWriteEx($couponParam);	

				/* 커뮤니티 작성 글에 쿠폰 번호 업데이트 */
				$dataParam2						= "";
				$dataParam2['b_code']			= $this->field['b_code'];
				$dataParam2['ub_no']			= $ub_no;
				$dataParam2['ub_ci_no']			= $ub_ci_no;
				$dataParam2['ub_winner']		= "Y";
				$this->dataController->getCouponUpdateEx($dataParam2);
			endforeach;
		}
    }
?>