<?
#/*====================================================================*/# 
#|작성자	: 김희성(thav@naver.com)									|# 
#|작성일	: 2013-01-17												|# 
#|작성내용	: 쪽지발송관리 												|# 
#/*====================================================================*/# 

class PostPaperMgr
{
		public $field;

		function getMessage()
		{
			echo "쪽지발송관리(PostPaperMgr)";
		}

		/********************************** Select **********************************/
		function getPostPaperSelect($db,$op="OP_LIST") 
		{
			$column['OP_LIST']		= "a.*";
			$column['OP_COUNT']		= "COUNT(*)";
			$column['OP_SELECT']	= "a.*";

			$query			= "SELECT %s FROM %s AS a WHERE a.PP_NO IS NOT NULL ";
			$query			= sprintf($query, $column[$op], TBL_POST_PAPER);

			if($this->getPP_NO() && $op == "OP_SELECT") :
				$query = sprintf("%s AND PP_NO = %d", $query, $this->getPP_NO());
			endif;
			
			$query		= sprintf("%s ORDER BY a.PP_NO DESC", $query);

			if($this->getPageLine()) :
				$query = sprintf("%s LIMIT %d, %d", $query, $this->getLimitFirst(), $this->getPageLine());
			endif;

			return $this->getSelectQuery($db, $query, $op);
		}

		/********************************** Insert **********************************/
		function getPostPaperInsertEx($db, $param)
		{
			$query = "CALL SP_POST_PAPER_I (?,?,?,?,?,?,?,?,?);";

			$param[]  = $param['PP_NO'];
			$param[]  = $param['PP_M_ID'];
			$param[]  = $param['PP_TITLE'];
			$param[]  = $param['PP_TEXT'];
			$param[]  = $param['PP_TOTAL_CNT'];
			$param[]  = $param['PP_REG_DT'];
			$param[]  = $param['PP_REG_NO'];
			$param[]  = $param['PP_MOD_DT'];
			$param[]  = $param['PP_MOD_NO'];

			return $db->executeBindingQuery($query,$param,true);
		}

		function getPostPaperInsert($db)
		{
			$query = "CALL SP_POST_PAPER_I (?,?,?,?,?,?,?,?,?);";

			$param[]  = $this->getPP_NO();
			$param[]  = $this->getPP_M_ID();
			$param[]  = $this->getPP_TITLE();
			$param[]  = $this->getPP_TEXT();
			$param[]  = $this->getPP_TOTAL_CNT();
			$param[]  = $this->getPP_REG_DT();
			$param[]  = $this->getPP_REG_NO();
			$param[]  = $this->getPP_MOD_DT();
			$param[]  = $this->getPP_MOD_NO();

			return $db->executeBindingQuery($query,$param,true);
		}

		/********************************** Update **********************************/
		function getPostPaperUpdate($db)
		{
			$query = "CALL SP_POST_PAPER_U (?,?,?,?,?,?,?,?,?);";

			$param[]  = $this->getPP_NO();
			$param[]  = $this->getPP_M_ID();
			$param[]  = $this->getPP_TITLE();
			$param[]  = $this->getPP_TEXT();
			$param[]  = $this->getPP_TOTAL_CNT();
			$param[]  = $this->getPP_REG_DT();
			$param[]  = $this->getPP_REG_NO();
			$param[]  = $this->getPP_MOD_DT();
			$param[]  = $this->getPP_MOD_NO();

			return $db->executeBindingQuery($query,$param,true);
		}

		/********************************* Delete ***********************************/
		function getPostPaperDelete($db)
		{
			$query = "CALL SP_POST_PAPER_D (?);";
			$param[]  = $this->getPP_NO();

			return $db->executeBindingQuery($query,$param,true);
		}

		/********************************* create table query ***********************/
		function getPostPaperCreate($db) 
		{

		}
		/********************************** drop table query ****************************/
		/*		주의!! 테이블 삭제 후, 복구 불가!! 신중하게 사용 할것!!					*/
		/********************************************************************************/


		/********************************* Function ********************************/	
		// 쿼리 선택
		function getSelectQuery($db, $query, $op)
		{
			if ( $op == "OP_LIST" ) :
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

		/********************************** variable **********************************/
		/* POST_PAPER */
		function setPP_NO($PP_NO){ $this->PP_NO = $PP_NO; }		
		function getPP_NO(){ return $this->PP_NO; }		

		function setPP_M_ID($PP_M_ID){ $this->PP_M_ID = $PP_M_ID; }		
		function getPP_M_ID(){ return $this->PP_M_ID; }		

		function setPP_TITLE($PP_TITLE){ $this->PP_TITLE = $PP_TITLE; }		
		function getPP_TITLE(){ return $this->PP_TITLE; }		

		function setPP_TEXT($PP_TEXT){ $this->PP_TEXT = $PP_TEXT; }		
		function getPP_TEXT(){ return $this->PP_TEXT; }		

		function setPP_TOTAL_CNT($PP_TOTAL_CNT){ $this->PP_TOTAL_CNT = $PP_TOTAL_CNT; }		
		function getPP_TOTAL_CNT(){ return $this->PP_TOTAL_CNT; }		

		function setPP_REG_DT($PP_REG_DT){ $this->PP_REG_DT = $PP_REG_DT; }		
		function getPP_REG_DT(){ return $this->PP_REG_DT; }		

		function setPP_REG_NO($PP_REG_NO){ $this->PP_REG_NO = $PP_REG_NO; }		
		function getPP_REG_NO(){ return $this->PP_REG_NO; }		

		function setPP_MOD_DT($PP_MOD_DT){ $this->PP_MOD_DT = $PP_MOD_DT; }		
		function getPP_MOD_DT(){ return $this->PP_MOD_DT; }		

		function setPP_MOD_NO($PP_MOD_NO){ $this->PP_MOD_NO = $PP_MOD_NO; }		
		function getPP_MOD_NO(){ return $this->PP_MOD_NO; }	
		/* POST_PAPER */

		/* PUBLIC */
		function setPageLine($PAGELINE){ $this->PAGELINE = $PAGELINE; }
		function getPageLine(){ return $this->PAGELINE; }
		
		function setLimitFirst($LIMITFIRST){ $this->LIMITFIRST = $LIMITFIRST; }
		function getLimitFirst(){ return $this->LIMITFIRST; }
		
		function setSearchKey($SEARCHKEY){ $this->SEARCHKEY = $SEARCHKEY; }
		function getSearchKey(){ return $this->SEARCHKEY; }
		/* PUBLIC */
	}


?>