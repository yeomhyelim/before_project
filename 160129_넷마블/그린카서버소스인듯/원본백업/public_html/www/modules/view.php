<?php
    /**
     * /home/shop_eng/www/modules/view.php
     * @author eumshop(thav@naver.com)
     * view class
     * **/
	
	class View {

		var $db;
		var $name;
		var	$field;
		var $module;
		
		function getMessage() {
			echo "view class";
		}

		function getTotal() {
			// 데이터 전체 개수
			return $this->module->{"get{$this->name}Select"}( "OP_COUNT" );
		}

		function getTotalEx($param) {
			// 데이터 전체 개수
			return $this->module->{"get{$this->name}SelectEx"}( "OP_COUNT", $param );
		}

		function getSelect(){
			// 선택 데이터
			return $this->module->{"get{$this->name}Select"}( "OP_SELECT" );
		}

		function getSelectEx($param){
			// 선택 데이터
			return $this->module->{"get{$this->name}SelectEx"}( "OP_SELECT", $param );
		}

		/**
		 * getListNoPage($op = "OP_LIST")
		 * 리스트 데이터(단, 페이지 나눔 없음
		 * **/
		function getListNoPage($op = "OP_LIST") {
			return $this->module->{"get{$this->name}Select"}($op);
		}

		/**
		 * getListNoPageEx($op = "OP_LIST", $param)
		 * 리스트 데이터(단, 페이지 나눔 없음)
		 * **/
		function getListNoPageEx($op = "OP_LIST", $param) {
			return $this->module->{"get{$this->name}SelectEx"}($op, $param);
		}

		function getListEx($op, &$param) {
			// 전체 데이터 개수
			$param['list_total']			= $this->module->{"get{$this->name}SelectEx"}( "OP_COUNT", $param);

			// 현재 출력 페이지
			if(!$param['page'] || $param['page'] <= 0):
				$param['page']		= 1; 
			endif;

			// 리스트 출력 개수
			if(!$param['page_line']):
				$param['page_line']	= 10;
			endif;

			// 리스트 시작 시점
			if(!$param['limit_first']):
				$param['limit_first'] = 0;
			endif;
			$param['limit_first']		= $param['page_line'] * ( $param['page'] - 1 );
	
			// 리스트 번호
			$param['list_num']		= $param['list_total'] - ( $param['page_line'] * ( $param['page'] - 1 ) );

			return $this->module->{"get{$this->name}SelectEx"}($op, $param);
		}

		function getCountEx(&$param) {
			return $this->module->{"get{$this->name}CountEx"}($param);
		}

		/**
		 * getList($op = "OP_LIST")
		 * 리스트 데이터
		 * **/
		function getList($op = "OP_LIST") {

			// 전체 데이터 개수
			$this->field['list_total'][$this->name]		= $this->module->{"get{$this->name}Select"}( "OP_COUNT" );

			// 현재 출력 페이지
			if(!$this->field['page'] || $this->field['page'] <= 0):
				$this->field['page']		= 1; 
			endif;

			// 리스트 출력 개수
			if(!$this->field['page_line']):
				$this->field['page_line']	= 10;
			endif;

			// 리스트 시작 시점
			if(!$this->field['limit_first']):
				$this->field['limit_first'] = 0;
			endif;
			$this->field['limit_first']		= $this->field['page_line'] * ( $this->field['page'] - 1 );
	
			// 리스트 번호
			$this->field['list_num'][$this->name]	= $this->field['list_total'][$this->name] - ( $this->field['page_line'] * ( $this->field['page'] - 1 ) );

			return $this->module->{"get{$this->name}Select"}($op);
		}

		/**
		 * getSessionInfo()
		 * 관리자, 일반 회원 로그인 통합
		 * **/
		function getSessionInfo() {
			if($_SESSION['ADMIN_LOGIN']):
				// 관리자로 로그인 된경우.
				$this->field['member_login']		= $_SESSION['ADMIN_LOGIN'];
				$this->field['member_id']			= $_SESSION['ADMIN_ID'];
				$this->field['member_mail']			= $_SESSION['ADMIN_MAIL'];
				$this->field['member_name']			= $_SESSION['ADMIN_NAME'];
				$this->field['member_level']		= $_SESSION['ADMIN_LEVEL'];
				$this->field['member_group']		= $_SESSION['ADMIN_GROUP'];
				$this->field['member_type']			= $_SESSION['ADMIN_TYPE'];
				$this->field['member_no']			= $_SESSION['ADMIN_NO'];
				$this->field['member_shop_no']		= $_SESSION["ADMIN_SHOP_NO"];
			elseif($_SESSION['member_login']):
				// 일반 회원으로 로그인 된경우.
				$this->field['member_login']		= $_SESSION['member_login'];
				$this->field['member_id']			= $_SESSION['member_id'];
				$this->field['member_mail']			= $_SESSION['member_email'];
				$this->field['member_name']			= $_SESSION['member_last_name'] . $_SESSION['member_name'];
				$this->field['member_level']		= $_SESSION['member_level'];
				$this->field['member_group']		= $_SESSION['member_group'];
				$this->field['member_no']			= $_SESSION['member_no'];
				$this->field['member_nickname']		= $_SESSION['member_nickname'];
			endif;
		}

		/**
		 * getPageInfoEx()
		 * 2013.04.09 결과값 리턴 형태로 변경
		 * 페이징
		 * **/	
		function getPageInfoEx(&$param) {
			if(!$param['list_default'])		{ $param['list_default']	= 10; }			// 한 페이지에 표시 할 리스트 수
			if(!$param['page_default'])		{ $param['page_default']	= 10; }			// 한 페이지에 표시 할 페이지 수
			if(!$param['page'])				{ $param['page']			= 0;  }			// 현재 페이지

			$list_default		= $param['list_default'];
			$page_default		= $param['page_default'];
			$page				= $param['page'];
			$list_total			= $param['list_total'];									// 리스트 총 개수	

			$block				= ceil($page	   / $page_default);					// 현재 블럭	
			$page_total			= ceil($list_total / $list_default);					// 페이지 총 개수
			$block_total		= ceil($page_total / $page_default);					// 블럭   총 개수	
			
			if($block==0) { $block = 1; }

			$last_page			= $block      * $page_default;							// 마지막 시점 페이지
			$first_page			= $last_page  - $page_default + 1;						// 시작   시점 페이지
			$prev_page			= $first_page - 1;										// 뒤 페이지

			if($last_page>=$page_total):
				$last_page		= $page_total;											// 마지막 시점 페이지
				$front_page		= $page_total;											// 앞 페이지
			else:
				$last_page		= $last_page;											// 마지막 시점 페이지
				$front_page		= $last_page + 1;										// 앞 페이지
			endif;
	
			if(!$last_page) { $last_page = 1; }

			$param['prev_page']		= $prev_page;										// 뒤 페이지
			$param['first_page']	= $first_page;										// 시작 시점 페이지
			$param['last_page']		= $last_page;										// 마지막 시점 페이지
			$param['page_total']	= $page_total;										// 페이지 총 개수
			$param['front_page']	= $front_page;										// 앞 페이지

			return $param;
		}

		/**
		 * getPageInfo()
		 * 페이징
		 * **/	
		function getPageInfo() {
			if(!$this->field['list_default'][$this->name]) { $this->field['list_default'][$this->name]	= 10; }	// 한 페이지에 표시 할 리스트 수
			if(!$this->field['page_default'][$this->name]) { $this->field['page_default'][$this->name]	= 10; }	// 한 페이지에 표시 할 페이지 수
			if(!$this->field['page'][$this->name])		   { $this->field['page'][$this->name]			= 0;  }	// 현재 페이지

			$list_default		= $this->field['list_default'][$this->name];
			$page_default		= $this->field['page_default'][$this->name];
			$page				= $this->field['page'][$this->name];
			$list_total			= $this->field['list_total'][$this->name];				// 리스트 총 개수	

			$block				= ceil($page	   / $page_default);					// 현재 블럭	
			$page_total			= ceil($list_total / $list_default);					// 페이지 총 개수
			$block_total		= ceil($page_total / $page_default);					// 블럭   총 개수	
			
			if($block==0) { $block = 1; }

			$last_page			= $block      * $page_default;							// 마지막 시점 페이지
			$first_page			= $last_page  - $page_default + 1;						// 시작   시점 페이지
			$prev_page			= $first_page - 1;										// 뒤 페이지
				
			if($last_page>=$page_total):
				$last_page		= $page_total;											// 마지막 시점 페이지
				$front_page		= $page_total;											// 앞 페이지
			else:
				$last_page		= $last_page;											// 마지막 시점 페이지
				$front_page		= $last_page + 1;										// 앞 페이지
			endif;

			$this->field['prev_page'][$this->name]	= $prev_page;						// 뒤 페이지
			$this->field['first_page'][$this->name]	= $first_page;						// 시작 시점 페이지
			$this->field['last_page'][$this->name]	= $last_page;						// 마지막 시점 페이지
			$this->field['page_total'][$this->name]	= $page_total;						// 페이지 총 개수
			$this->field['front_page'][$this->name]	= $front_page;						// 앞 페이지
		}

		/**
		 * getReadUpdate()
		 * 조회수 1증가.
		 * **/	
		function getReadUpdate() {
			return $this->module->{"get{$this->name}ReadUpdate"}( "OP_COUNT" );
		}

		function getSchemaTableSelect($tableName) {
			return $this->module->getSchemaTableSelect($tableName);
		}


		/**
		 * getProductSelectEx()
		 * 회원이 구매한 상품인지 확인.
		 * **/
		function getProductSelectEx($op, &$param){
			return $this->module->{"get{$this->name}ProductSelectEx"}($op, $param);
		}

    }
?>
