<?
#/*====================================================================*/# 
#|작성자	: 박영미(ivetmi@naver.com)									|# 
#|작성일	: 2012-05-11												|# 
#|작성내용	: 메일발송관리 												|# 
#/*====================================================================*/# 

class PostMailMgr
{
		public $field;

		function getMessage()
		{
			echo "메일발송관리(PostMailMgr)";
		}
		/********************************** Select **********************************/
		function getPostMailSelect($db,$op="OP_LIST") 
		{
			$column['OP_LIST']		= "a.*";
			$column['OP_COUNT']		= "COUNT(*)";
			$column['OP_SELECT']	= "a.*";

			$query			= "SELECT %s FROM %s AS a WHERE a.PM_NO IS NOT NULL ";
			$query			= sprintf($query, $column[$op], TBL_POST_MAIL);

			if($this->getPM_NO()) :
				$query = sprintf("%s AND PM_NO = %d", $query, $this->getPM_NO());
			endif;
			$query .= " ORDER BY a.PM_NO DESC ";
			if($this->getPageLine()) :
				$query = sprintf("%s LIMIT %d, %d", $query, $this->getLimitFirst(), $this->getPageLine());
			endif;

			return $this->getSelectQuery($db, $query, $op);
		}



		/********************************** Insert **********************************/
		function getPostMailInsert($db)
		{
			$query = "CALL SP_POST_MAIL_I (?,?,?,?);";

			$param[]  = $this->getPM_TITLE();
			$param[]  = $this->getPM_TEXT();
			$param[]  = $this->getPM_REG_NO();
			$param[]  = $this->getPM_MOD_NO();

			return $db->executeBindingQuery($query,$param,true);
		}

		/********************************** Update **********************************/
		function getPostMailUpdate($db)
		{
			$query = "CALL SP_POST_MAIL_U (?,?,?,?);";

			$param[]  = $this->getPM_NO();
			$param[]  = $this->getPM_TITLE();
			$param[]  = $this->getPM_TEXT();
			$param[]  = $this->getPM_MOD_NO();

			return $db->executeBindingQuery($query,$param,true);
		}

		function getPostMailCntUpdate($db)
		{
			$query = "UPDATE ".TBL_POST_MAIL." SET PM_TOTAL_CNT = PM_TOTAL_CNT + ".$this->getPM_TOTAL_CNT()." WHERE PM_NO = ".$this->getPM_NO();
			return $db->getExecSql($query);
		}


		/********************************* Delete ***********************************/
		function getPostMailDelete($db)
		{
			$query = "CALL SP_POST_MAIL_D (?);";
			$param[]  = $this->getPM_NO();

			return $db->executeBindingQuery($query,$param,true);
		}

		/********************************* create table query ***********************/
		function getPostMailCreate($db) 
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
		function setPM_NO($PM_NO){ $this->PM_NO = $PM_NO; }		
		function getPM_NO(){ return $this->PM_NO; }		

		function setPM_TITLE($PM_TITLE){ $this->PM_TITLE = $PM_TITLE; }		
		function getPM_TITLE(){ return $this->PM_TITLE; }		

		function setPM_TEXT($PM_TEXT){ $this->PM_TEXT = $PM_TEXT; }		
		function getPM_TEXT(){ return $this->PM_TEXT; }		

		function setPM_TOTAL_CNT($PM_TOTAL_CNT){ $this->PM_TOTAL_CNT = $PM_TOTAL_CNT; }		
		function getPM_TOTAL_CNT(){ return $this->PM_TOTAL_CNT; }		

		function setPM_REG_DT($PM_REG_DT){ $this->PM_REG_DT = $PM_REG_DT; }		
		function getPM_REG_DT(){ return $this->PM_REG_DT; }		

		function setPM_REG_NO($PM_REG_NO){ $this->PM_REG_NO = $PM_REG_NO; }		
		function getPM_REG_NO(){ return $this->PM_REG_NO; }		

		function setPM_MOD_DT($PM_MOD_DT){ $this->PM_MOD_DT = $PM_MOD_DT; }		
		function getPM_MOD_DT(){ return $this->PM_MOD_DT; }		

		function setPM_MOD_NO($PM_MOD_NO){ $this->PM_MOD_NO = $PM_MOD_NO; }		
		function getPM_MOD_NO(){ return $this->PM_MOD_NO; }	

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