<?php
    /**
     * /home/shop_eng/www/classes/community/pointGive.func.class.php
     * @author eumshop(thav@naver.com)
     * 커뮤니티 글 작성시 포인트 지급
     * **/

//	require_once MALL_HOME . "/classes/client/client.info.class.php";
	require_once MALL_HOME . "/modules/point/data/basic.1.0/point.data.controller.php";
	require_once MALL_HOME . "/modules/member/data/basic.1.0/member.data.controller.php";

    class PointGive  {

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
			echo "커뮤니티 글 작성시 포인트 지급";
		}

		/**
		 * getPointProcess($paramData)
		 * 포인트 발급
		 * **/
		function getPointProcess($paramData) {

			## STEP 1.
			## 포인트 발급
			$this->getPointGiveKindEx($paramData);			
		}

		function getPointGiveKindEx($paramData) {
			if($paramData['give_type'] == "A"):
				// 자동 포인트 지급
				$param['list']	= array($this->field['ub_no']);
				$param['memo']	= "커뮤니티 글 작성 포인트 지급(BOARD_UB_{$this->field['b_code']})";;
				$param['point'] = $this->field['BOARD_INFO']['bi_point_w_mark'];	
				$this->getPointGiveEx($param);
			elseif($paramData['give_type'] == "M"):
				// 수동 포인트 지급
				$param['list']	= $this->field['check'];
				$param['memo']	= "커뮤니티 글 작성 포인트 지급(BOARD_UB_{$this->field['b_code']})";;
				$param['point'] = $this->field['BOARD_INFO']['bi_point_w_mark'];	
				$this->getPointGiveEx($param);
			elseif($paramData['give_type'] == "T"):
				// 다중 포인트 지급
				$param['list']	= $this->field['check'];
				$no				= $this->field['bi_point_w_multi_no'];
				$param['count'] = $this->field['BOARD_INFO']['bi_point_w_multi_count'][$no];
				$param['memo']	= $this->field['BOARD_INFO']['bi_point_w_multi_title'][$no];
				$param['point'] = $this->field['BOARD_INFO']['bi_point_w_multi_point'][$no];	
				$this->getPointGiveEx($param);
			else:
				echo "포인트를 발급 할 수 없습니다.";
				return;
			endif;
		}

		/**
		 * getPointGiveEx()
		 * 포인트 지급
		 * 발급 개수 지정이 안됨.(추후 작업)
		 * **/
		function getPointGiveEx($paramData) {
			$client							= new ClientInfo();	
			$pointDataController			= new PointDataController($this->db, $this->field);
			$memberController				= new MemberDataController($this->db, $this->field);

			foreach($paramData['list'] as $ub_no):
				## STEP 1.
				## 커뮤니티 데이터 가져오기
				$dataParam['b_code']			= $this->field['b_code'];
				$dataParam['ub_no']				= $ub_no;
//				$dataView						= $this->getCommunityView();
				$dataSelectRow					= $this->dataView->getSelectEx($dataParam);

				if($dataSelectRow['UB_PT_NO']):
					// 이미 발급된 게시글
//					continue;
				endif;

				## STEP 2.
				## 포인트 지급 체크 1회 이상 지급 안됨.
				## 2013.04.09 커뮤니티 글인 경우 1회 이상 지급 안됨으로 설졍할 경우, 1회성 포인트 지급으로 끝나기 때문에 사용 못함.

				## STEP 3.
				## 포인트 지급
				$pointParam['m_no']				= $dataSelectRow['UB_M_NO'];
				$pointParam['b_no']				= $dataSelectRow['UB_NO'];
				$pointParam['o_no']				= 0;
				$pointParam['pt_type']			= "004";
//				$pointParam['pt_point']			= $this->field['BOARD_INFO']['bi_point_w_mark']; 
				$pointParam['pt_point']			= $paramData['point'];
//				$pointParam['pt_memo']			= "커뮤니티 글 작성 포인트 지급(BOARD_UB_{$this->field['b_code']})";
				$pointParam['pt_memo']			= $paramData['memo'];
				$pointParam['pt_etc']			= "{$this->field['BOARD_INFO']['bi_point_w_give']},{$this->field['b_code']},{$ub_no}";	// 지급방식, 테이블 명, 게시글 번호
				$pointParam['pt_start_dt']		= date("Y-m-d");
				$pointParam['pt_end_dt']		= date("Y-m-d");
//				$client							= new ClientInfo();		
				$pointParam['pt_reg_ip']		= $client->getClientIP();
				$pointParam['pt_reg_no']		= $this->field['member_no'];
//				$pointDataController			= new PointDataController($this->db, $this->field);
				$ub_pt_no						= $pointDataController->getWriteEx($pointParam);

				## STEP 3.
				## 회원 테이블에 포인트 지급(업데이트)
				$memberPointParam['m_point']	= $this->field['BOARD_INFO']['bi_point_w_mark'];
				$memberPointParam['m_no']		= $dataSelectRow['UB_M_NO'];
//				$memberController				= new MemberDataController($this->module->db, $this->field);
				$memberController->getPointUpdateEx($memberPointParam);

				/* 커뮤니티 작성 글에 포인트 번호 업데이트 */
				$dataParam2						= "";
				$dataParam2['b_code']			= $this->field['b_code'];
				$dataParam2['ub_no']			= $ub_no;
				$dataParam2['ub_pt_no']			= $ub_pt_no;
				$dataParam2['ub_winner']		= "Y";
				$this->dataController->getPointUpdateEx($dataParam2);
			endforeach;
		}
    }
?>