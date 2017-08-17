<?
#/*====================================================================*/# 
#|작성자	: 김희성(thav@naver.com)									|# 
#|작성일	: 2013-01-17												|# 
#|작성내용	: 문자발송관리 												|# 
#/*====================================================================*/# 

class PostSmsMgr
{
		public $field;

		function getMessage()
		{
			echo "문자발송관리(PostSmsMgr)";
		}

		/********************************** Select **********************************/
		function getPostSmsSelect($db,$op="OP_LIST") 
		{
			$column['OP_LIST']		= "a.*";
			$column['OP_COUNT']		= "COUNT(*)";
			$column['OP_SELECT']	= "a.*";

			$query			= "SELECT %s FROM %s AS a WHERE a.PS_NO IS NOT NULL ";
			$query			= sprintf($query, $column[$op], TBL_POST_SMS);

			if($this->getPS_NO() && $op == "OP_SELECT") :
				$query = sprintf("%s AND PS_NO = %d", $query, $this->getPS_NO());
			endif;
			
			$query		= sprintf("%s ORDER BY a.PS_NO DESC", $query);

			if($this->getPageLine()) :
				$query = sprintf("%s LIMIT %d, %d", $query, $this->getLimitFirst(), $this->getPageLine());
			endif;

			return $this->getSelectQuery($db, $query, $op);
		}

		/********************************** Insert **********************************/
		function getPostSmsInsert($db)
		{
			$query = "CALL SP_POST_SMS_I (?,?,?,?,?,?,?);";

			$param[]  = $this->getPS_NO();
			$param[]  = $this->getPS_TEXT();
			$param[]  = $this->getPS_TOTAL_CNT();
			$param[]  = $this->getPS_REG_DT();
			$param[]  = $this->getPS_REG_NO();
			$param[]  = $this->getPS_MOD_DT();
			$param[]  = $this->getPS_MOD_NO();

			return $db->executeBindingQuery($query,$param,true);
		}

		/********************************** Update **********************************/
		function getPostSmsUpdate($db)
		{
			$query = "CALL SP_POST_SMS_U (?,?,?,?,?,?,?);";

			$param[]  = $this->getPS_NO();
			$param[]  = $this->getPS_TEXT();
			$param[]  = $this->getPS_TOTAL_CNT();
			$param[]  = $this->getPS_REG_DT();
			$param[]  = $this->getPS_REG_NO();
			$param[]  = $this->getPS_MOD_DT();
			$param[]  = $this->getPS_MOD_NO();

			return $db->executeBindingQuery($query,$param,true);
		}

		function getPostSmsCntUpdate($db)
		{
			$query = "UPDATE ".TBL_POST_SMS." SET PS_TOTAL_CNT = PS_TOTAL_CNT + ".$this->getPS_TOTAL_CNT()." WHERE PS_NO = ".$this->getPS_NO();
			return $db->getExecSql($query);
		}
		/********************************* Delete ***********************************/
		function getPostSmsDelete($db)
		{
			$query = "CALL SP_POST_SMS_D (?);";
			$param[]  = $this->getPS_NO();

			return $db->executeBindingQuery($query,$param,true);
		}

		/********************************* create table query ***********************/
		function getPostSmsCreate($db) 
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
		/* POST_SMS */
		function setPS_NO($PS_NO){ $this->PS_NO = $PS_NO; }		
		function getPS_NO(){ return $this->PS_NO; }		

		function setPS_TEXT($PS_TEXT){ $this->PS_TEXT = $PS_TEXT; }		
		function getPS_TEXT(){ return $this->PS_TEXT; }		

		function setPS_TOTAL_CNT($PS_TOTAL_CNT){ $this->PS_TOTAL_CNT = $PS_TOTAL_CNT; }		
		function getPS_TOTAL_CNT(){ return $this->PS_TOTAL_CNT; }		

		function setPS_REG_DT($PS_REG_DT){ $this->PS_REG_DT = $PS_REG_DT; }		
		function getPS_REG_DT(){ return $this->PS_REG_DT; }		

		function setPS_REG_NO($PS_REG_NO){ $this->PS_REG_NO = $PS_REG_NO; }		
		function getPS_REG_NO(){ return $this->PS_REG_NO; }		

		function setPS_MOD_DT($PS_MOD_DT){ $this->PS_MOD_DT = $PS_MOD_DT; }		
		function getPS_MOD_DT(){ return $this->PS_MOD_DT; }		

		function setPS_MOD_NO($PS_MOD_NO){ $this->PS_MOD_NO = $PS_MOD_NO; }		
		function getPS_MOD_NO(){ return $this->PS_MOD_NO; }
		/* POST_SMS */

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