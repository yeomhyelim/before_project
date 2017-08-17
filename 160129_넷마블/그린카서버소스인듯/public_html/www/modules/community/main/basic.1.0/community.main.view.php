<?php
    /**
     * /home/shop_eng/www/modules/community/main/basic.1.0/community.main.view.php
     * @author eumshop(thav@naver.com)
     * community main view class (basic.1.0)
	 * $mainView = new CommunityMainView($db, $_REQUEST);
     * **/

	require_once MALL_HOME . "/modules/community/data/basic.1.0/community.data.view.php";
	require_once MALL_HOME . "/modules/community/event/basic.1.0/community.event.view.php";
	require_once MALL_HOME . "/modules/community/community.view.php";

    class CommunityMainView extends CommunityView {

		## 기본 함수. 

		/**
		 * __construct(&$db, &$field)
		 * 생성자
		 * **/
		function __construct(&$db, &$field) {
			$this->db		= &$db;
			$this->field	= &$field;
		}

		/**
		 * getMessage()
		 * 메시지
		 * **/
		function getMessage() {
			echo "community main view class (basic.1.0)";
		}

		/**
		 * getMainProcess()
		 * 쓰기 프로세스
		 * **/
		function getMainProcess() {

			function build_sorter($a, $b) {
				if ($a['bi_admin_main_sort'] == $b['bi_admin_main_sort']) {
					return 0;
				}
				if(!$a['bi_admin_main_sort']){
					$a['bi_admin_main_sort'] = 0;
				}
				if(!$b['bi_admin_main_sort']){
					$b['bi_admin_main_sort'] = 0;
				}
				return ($a['bi_admin_main_sort'] < $b['bi_admin_main_sort']) ? -1 : 1;
			}


			## STEP 1.
			## 설정
			include "{$this->field['S_DOCUMENT_ROOT']}{$this->field['S_SHOP_HOME']}/conf/community/boardList.info.php";
			$dataView	= new CommunityDataView($this->db, $this->field);
			$eventView	= new CommunityEventView($this->db, $this->field);

			## STEP 2.
			## 정렬
			foreach($BOARD_LIST as $b_code => $data):
				include "{$this->field['S_DOCUMENT_ROOT']}{$this->field['S_SHOP_HOME']}/conf/community/board.{$b_code}.info.php";	
				$BOARD_LIST[$b_code]['b_code']					= $b_code;
				$BOARD_LIST[$b_code]['b_kind']					= $BOARD_INFO[$b_code]['b_kind'];
				$BOARD_LIST[$b_code]['bi_admin_main_show']		= $BOARD_INFO[$b_code]['bi_admin_main_show'];
				$BOARD_LIST[$b_code]['bi_admin_main_sort']		= $BOARD_INFO[$b_code]['bi_admin_main_sort'];
			endforeach;
			usort($BOARD_LIST, "build_sorter");

			## STEP 2.
			## 데이터 불러오기
			foreach($BOARD_LIST as $no => $data):

				## board 종류 설정
				$b_code						= $data['b_code'];
				$b_kind						= $data['b_kind'];
				if($b_kind == "talk") { continue; };
				$param['b_code']			= $b_code;
				$param['page_line']			= 5;
				$param['answer_no']			= true;
				$param['ub_func_notice']	= "N";
				$param['cm_cnt_use']		= "";
				$param['orderby']			= "UB_REG_DT DESC";

				/** 2013.05.09 코멘트 개수 **/
				if($BOARD_INFO[$b_code]['bi_comment_use']!="N"):
				$param['cm_cnt_use']		= "Y";
				endif;
				/** 2013.05.09 코멘트 개수 **/

				if($b_kind):
					$listResult					= ${"{$b_kind}View"}->getListEx("OP_LIST", $param);	// 데이타
					$totalResult				= ${"{$b_kind}View"}->getCountEx($param);			// 개수
					$dataMgr[$b_code]			= $listResult;
					$count[$b_code]				= $totalResult;
				endif;

			endforeach;


			## STEP 3.
			## DataMgr에 등록.
			$this->field['result']['DataMgr']		= $dataMgr;
			$this->field['result']['count']			= $count;
			$this->field['result']['board_info']	= $BOARD_INFO;
		}



    }
?>