<?
	#/*====================================================================*/# 
	#|화일명	: contentList.php / contentWrite.php / contentModify.php	|# 
	#|작성자	: 홍길동													|# 
	#|작성일	: 2012-08-20												|# 
	#|작성내용	: 컨텐츠 추가 등록관리 프로그램								|# 
	#/*====================================================================*/# 

	class ContentMgr
	{
		private $query;
		private $param;

		/********************************** List **********************************/

		function getContentList($db, $op="OP_LIST") {
			
			$column['OP_LIST']		= "*";
			$column['OP_COUNT']		= "COUNT(*)";
			$column['OP_SELECT']	= "*";

			$query = "SELECT {$column[$op]} FROM " . TBL_CONTENT . " ";
			$where = "";

			/** where **/
			if($this->getCP_LNG()):
				$where .= "AND CP_LNG = '{$this->getCP_LNG()}' ";
			endif;

			if($this->getCP_NO()):
				$where .= "AND CP_NO = '{$this->getCP_NO()}' ";
			endif;
			
			if($this->getCP_GROUP()):
				$where .= "AND CP_GROUP = '{$this->getCP_GROUP()}' ";
			endif;

			if($where):
				$query = $query . "WHERE CP_NO IS NOT NULL " . $where;
			endif;
			/** where **/

			if($order):
				$query .= "ORDER BY CP_GROUP DESC ";
			endif;
			
			$limitFirst = $this->getLimitFirst(); if(!$limitFirst) { $limitFirst = 0; }
			$pageLine   = $this->getPageLine();

			if($pageLine):
				$query .= "	LIMIT {$limitFirst},{$pageLine}";
			endif;

			return $this->getSelectQuery($query, $db, $op);
		}

// 2013.04.24 old source
//		function getContentList($db)
//		{
//			## SELECT * FROM CONTENT WHERE CP_LNG = 'KR' ORDER BY CP_GROUP DESC
//
//			$query  = "SELECT														";
//			$query .= "	*															";
//			$query .= "FROM ".TBL_CONTENT."											";
//
//			if($this->getSearchStatusY()=="Y"){
//				$where = "'Y'														";
//			}
//
//			if($this->getSearchStatusN()=="N"){
//				if ($where) $where .= ",";
//				$where .= "'N'														";
//			}
//			
//			if($where){
//				$query .= "WHERE CP_PAGE_VIEW IN (".$where.")						";
//			}
//
//			if($this->getSearchKey()){
//				if(!$wh){
//					$query .= "WHERE CP_PAGE_NAME LIKE '%".mysql_real_escape_string($this->getSearchKey())."%'	";
//				}else{
//					$query .= "AND CP_PAGE_NAME LIKE '%".mysql_real_escape_string($this->getSearchKey())."%'		";
//				}
//			}
//
//			$query .= "ORDER BY CP_NO DESC	LIMIT ".$this->getLimitFirst().",".$this->getPageLine();
//
//			return $db->getExecSql($query);
//		}

// 2013.05.31 old source
//		function getContentTotal($db)
//		{
//			$query  = "SELECT														";
//			$query .= "	COUNT(*)													";
//			$query .= "FROM ".TBL_CONTENT."											";
//			
//			if($this->getSearchStatusY()=="Y"){
//				$where = "'Y'														";
//			}
//
//			if($this->getSearchStatusN()=="N"){
//				if ($where) $where .= ",";
//				$where .= "'N'														";
//			}
//			
//			if($where){
//				$query .= "WHERE CP_PAGE_VIEW IN (".$where.")						";
//			}
//
//			if($this->getSearchKey()){
//				if(!$wh){
//					$query .= "WHERE CP_PAGE_NAME LIKE '%".mysql_real_escape_string($this->getSearchKey())."%'	";
//				}else{
//					$query .= "AND CP_PAGE_NAME LIKE '%".($this->getSearchKey())."%'		";
//				}
//			}
//
//			$limitFirst = $this->getLimitFirst(); if(!$limitFirst) { $limitFirst = 0; }
//			$pageLine   = $this->getPageLine();
//
//			if($pageLine):
//				$query .= "	LIMIT {$limitFirst},{$pageLine}";
//			endif;
//
//			return $db->getCount($query);
//		}

		/********************************** view **********************************/
		function getContentView($db)
		{
			return $this->getContentList($db, "OP_SELECT");
//			$query  = "SELECT														";
//			$query .= "	*															";
//			$query .= "FROM ".TBL_CONTENT."											";
//			$query .= "WHERE CP_NO=".$this->getCP_NO()."							";
//			return $db->getSelect($query);
		}



		/********************************** Insert **********************************/
		function getContentInsert($db)
		{
			$query = "CALL SP_CONTENT_I (?,?,?,?,?,?,?,?);";

			$param[]  = $this->getCP_GROUP();
			$param[]  = $this->getCP_LNG();
			$param[]  = $this->getCP_PAGE_NAME();
			$param[]  = $this->getCP_PAGE_URL();
			$param[]  = $this->getCP_PAGE_TEXT();
			$param[]  = $this->getCP_PAGE_VIEW();
			$param[]  = $this->getCP_REG_DT();
			$param[]  = $this->getCP_REG_NO();

			return $db->executeBindingQuery($query,$param,true);
		}


		/********************************** Udate **********************************/
		function getContentUpdate($db)
		{
			$query = "CALL SP_CONTENT_U (?,?,?,?,?,?,?,?,?);";

			$param[]  = $this->getCP_NO();
			$param[]  = $this->getCP_GROUP();
			$param[]  = $this->getCP_LNG();
			$param[]  = $this->getCP_PAGE_NAME();
			$param[]  = $this->getCP_PAGE_URL();
			$param[]  = $this->getCP_PAGE_TEXT();
			$param[]  = $this->getCP_PAGE_VIEW();
			$param[]  = $this->getCP_MOD_DT();
			$param[]  = $this->getCP_MOD_NO();

			return $db->executeBindingQuery($query,$param,true);
		}

		function getContentGroupUpdate($db)
		{
			$cp_group				= $this->getCP_GROUP();
			$param['CP_GROUP']		= $this->getSQLInteger($cp_group);
			$where					= "CP_NO = {$this->getCP_NO()}";
			return $db->getUpdateParam(TBL_CONTENT, $param, $where);
		}

		/********************************** delete **********************************/
		function getContentDelete($db)
		{
			return $db->getDelete(TBL_CONTENT," CP_GROUP=".mysql_real_escape_string($this->getCP_GROUP()));
// 다국어 버전으로 변경
//			return $db->getDelete(TBL_CONTENT," CP_NO=".mysql_real_escape_string($this->getCP_NO()));
		}


		/********************************** function **********************************/

		/**
		 * getSelectQuery($query, $op)
		 * $op 형에 따라서 $query 실행
		 * **/
		function getSelectQuery($query, $db, $op)
		{
			if ( $op == "OP_LIST" || $op == "OP_ALL_LIST" ) :
				return $db->getExecSql($query);
			elseif ( $op == "OP_SELECT" ) :
				return $db->getSelect($query);
			elseif ( $op == "OP_COUNT" ) :
				return $db->getCount($query);
			elseif ( $op == "OP_ARYLIST" ) :
				return $db->getArray($query);
			else :
				return -100;
			endif;
		}

		/**
		 * getSQLString($str)
		 * SQL 문자형으로 형변환	ex) text => "text"
		 * **/		
		function getSQLString($str) {
			$str	= addslashes($str);
			return "\"{$str}\"";
		}

		/**
		 * getSQLString($str)
		 * SQL 정수형으로 형변환	ex) "" => 0
		 * **/		
		function getSQLInteger($int) {
			if($int) { return $int; }
			return 0;
		}

		/**
		 * getSQLString($str)
		 * SQL 년월일시분초 형변환	ex) 
		 * **/	
		function getSQLDatetime($str) {
			$str = date("Y-m-d H:i:s", strtotime($str));
			return "\"{$str}\"";
		}

		/********************************** variable **********************************/
		// 컨텐츠
		function setCP_NO($CP_NO){ $this->CP_NO = $CP_NO; }		
		function getCP_NO(){ return $this->CP_NO; }		

		function setCP_GROUP($CP_GROUP){ $this->CP_GROUP = $CP_GROUP; }		
		function getCP_GROUP(){ return $this->CP_GROUP; }		

		function setCP_LNG($CP_LNG){ $this->CP_LNG = $CP_LNG; }		
		function getCP_LNG(){ return $this->CP_LNG; }	

		function setCP_PAGE_NAME($CP_PAGE_NAME){ $this->CP_PAGE_NAME = $CP_PAGE_NAME; }		
		function getCP_PAGE_NAME(){ return $this->CP_PAGE_NAME; }		

		function setCP_PAGE_URL($CP_PAGE_URL){ $this->CP_PAGE_URL = $CP_PAGE_URL; }		
		function getCP_PAGE_URL(){ return $this->CP_PAGE_URL; }		

		function setCP_PAGE_TEXT($CP_PAGE_TEXT){ $this->CP_PAGE_TEXT = $CP_PAGE_TEXT; }		
		function getCP_PAGE_TEXT(){ return $this->CP_PAGE_TEXT; }		

		function setCP_PAGE_VIEW($CP_PAGE_VIEW){ $this->CP_PAGE_VIEW = $CP_PAGE_VIEW; }		
		function getCP_PAGE_VIEW(){ return $this->CP_PAGE_VIEW; }		

		function setCP_REG_DT($CP_REG_DT){ $this->CP_REG_DT = $CP_REG_DT; }		
		function getCP_REG_DT(){ return $this->CP_REG_DT; }		

		function setCP_REG_NO($CP_REG_NO){ $this->CP_REG_NO = $CP_REG_NO; }		
		function getCP_REG_NO(){ return $this->CP_REG_NO; }		

		function setCP_MOD_DT($CP_MOD_DT){ $this->CP_MOD_DT = $CP_MOD_DT; }		
		function getCP_MOD_DT(){ return $this->CP_MOD_DT; }		

		function setCP_MOD_NO($CP_MOD_NO){ $this->CP_MOD_NO = $CP_MOD_NO; }		
		function getCP_MOD_NO(){ return $this->CP_MOD_NO; }		

		function setPageLine($PAGELINE){ $this->PAGELINE = $PAGELINE; }		
		function getPageLine(){ return $this->PAGELINE; }

		function setLimitFirst($LIMITFIRST){ $this->LIMITFIRST = $LIMITFIRST; }
		function getLimitFirst(){ return $this->LIMITFIRST; }

		function setSearchStatusY($SEARCHSTATUSY){ $this->SEARCHSTATUSY = $SEARCHSTATUSY; }
		function getSearchStatusY(){ return $this->SEARCHSTATUSY; }

		function setSearchStatusN($SEARCHSTATUSN){ $this->SEARCHSTATUSN = $SEARCHSTATUSN; }
		function getSearchStatusN(){ return $this->SEARCHSTATUSN; }

		function setSearchKey($SEARCHKEY){ $this->SEARCHKEY = $SEARCHKEY; }
		function getSearchKey(){ return $this->SEARCHKEY; }

		/********************************** variable **********************************/
	}
?>