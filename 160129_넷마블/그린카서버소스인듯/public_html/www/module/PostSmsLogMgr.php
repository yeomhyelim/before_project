<?
#/*====================================================================*/# 
#|작성자	: 김희성(thav@naver.com										|# 
#|작성일	: 2013-01-21												|# 
#|작성내용	: 문자발송로그 												|# 
#/*====================================================================*/# 

/* 문자 보내기 */
// PL_SEND_RESULT 옵션 (sendMailResult)
//	0		:		발송실패
//	1		:		문자전달 (to em_tran)
//	9		:		받는사람 이름 없음.
//	8		:		받는사람 연락처 없음.
//	7		:		보내는사람 이름 없음.
//	6		:		보내는사람 연락처 없음.
//	5		:		머니 부족
//	4		:		언어
//  11		:		수신 거부

class PostSmsLogMgr
{
		public $field;

		function getMessage()
		{
			echo "문자발송관리(PostSmsMgr)";
		}
		
		/********************************** Select **********************************/
		function getPostSmsLogSelect($db,$op="OP_LIST") 
		{
			$column['OP_LIST']		= "a.*";
			$column['OP_COUNT']		= "COUNT(*)";
			$column['OP_SELECT']	= "a.*";

			$query			= "SELECT %s FROM %s AS a WHERE a.PL_NO IS NOT NULL ";
			$query			= sprintf($query, $column[$op], TBL_POST_SMS_LOG);

			if($this->getPL_NO()) :
				$query = sprintf("%s AND PL_NO = %d", $query, $this->getPL_NO());
			endif;
	
			if($this->getPL_PS_NO()) :
				$query = sprintf("%s AND PL_PS_NO = %d", $query, $this->getPL_PS_NO());
			endif;

			if($this->getPL_SEND_RESULT() == "2"){
				$query = sprintf("%s AND PL_SEND_RESULT = '2' ", $query);			
			}
			
			$query		= sprintf("%s ORDER BY a.PL_NO DESC", $query);

			if($this->getPageLine()) :
				$query = sprintf("%s LIMIT %d, %d", $query, $this->getLimitFirst(), $this->getPageLine());
			endif;	
			
			return $this->getSelectQuery($db, $query, $op);
		}

		function getPostSmsLogDup($db){

			$query  = "SELECT COUNT(*) FROM ".TBL_POST_SMS_LOG;
			$query .= "	WHERE PL_PS_NO			= ".$this->getPL_PS_NO();
			$query .= "		AND PL_TO_M_NO		= ".$this->getPL_TO_M_NO();
			$query .= "		AND PL_TO_M_NAME	= '".$this->getPL_TO_M_NAME()."'";
			$query .= "		AND PL_TO_M_HP		= '".$this->getPL_TO_M_NO()."'";

			return $db->getCount($query);
		}

		/********************************** Insert **********************************/
		function getPostSmsLogInsert($db)
		{
			$query = "CALL SP_POST_SMS_LOG_I (?,?,?,?,?,?,?,?,?,?,?,?,?,?);";

			$param[]  = $this->getPL_NO();
			$param[]  = $this->getPL_PS_NO();
			$param[]  = $this->getPL_TO_M_NO();
			$param[]  = $this->getPL_TO_M_HP();
			$param[]  = $this->getPL_TO_M_NAME();
			$param[]  = $this->getPL_FROM_M_NO();
			$param[]  = $this->getPL_FROM_M_HP();
			$param[]  = $this->getPL_FROM_M_NAME();
			$param[]  = $this->getPL_TEXT();
			$param[]  = $this->getPL_IP();
			$param[]  = $this->getPL_SEND_DATE();
			$param[]  = $this->getPL_SEND_RESULT();
			$param[]  = $this->getPL_REG_DT();
			$param[]  = $this->getPL_REG_NO();

			return $db->executeBindingQuery($query,$param,true);
		}

		/********************************** Update **********************************/
		function getPostSmsLogUpdate($db)
		{
			$query  = "UPDATE ".TBL_POST_SMS_LOG." SET   ";
			$query .= "     PL_FROM_M_NO	= " .$this->getPL_FROM_M_NO();
			$query .= "    ,PL_FROM_M_NAME	= '".$this->getPL_FROM_M_NAME()."'		";
			$query .= "    ,PL_FROM_M_HP	= '".$this->getPL_FROM_M_HP()."'		";
			$query .= "    ,PL_IP			= '".$this->getPL_IP()."'				";
			$query .= "    ,PL_SEND_DATE	= NOW()									";
			$query .= "    ,PL_SEND_RESULT  =  '".$this->getPL_SEND_RESULT()."'		";
			$query .= "    ,PL_TEXT			=  '".$this->getPL_TEXT()."'			";
			$query .= "WHERE PL_NO =  ".$this->getPL_NO();
			
			return $db->getExecSql($query);
		}

		/********************************* Delete ***********************************/
		function getPostSmsLogDelete($db)
		{

		}

		/********************************* create table query ***********************/
		function getPostSmsLogCreate($db) 
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
		function setPL_NO($PL_NO){ $this->PL_NO = $PL_NO; }		
		function getPL_NO(){ return $this->PL_NO; }		

		function setPL_PS_NO($PL_PS_NO){ $this->PL_PS_NO = $PL_PS_NO; }		
		function getPL_PS_NO(){ return $this->PL_PS_NO; }		

		function setPL_TO_M_NO($PL_TO_M_NO){ $this->PL_TO_M_NO = $PL_TO_M_NO; }		
		function getPL_TO_M_NO(){ return $this->PL_TO_M_NO; }		

		function setPL_TO_M_HP($PL_TO_M_HP){ $this->PL_TO_M_HP = $PL_TO_M_HP; }		
		function getPL_TO_M_HP(){ return $this->PL_TO_M_HP; }		

		function setPL_TO_M_NAME($PL_TO_M_NAME){ $this->PL_TO_M_NAME = $PL_TO_M_NAME; }		
		function getPL_TO_M_NAME(){ return $this->PL_TO_M_NAME; }		

		function setPL_FROM_M_NO($PL_FROM_M_NO){ $this->PL_FROM_M_NO = $PL_FROM_M_NO; }		
		function getPL_FROM_M_NO(){ return $this->PL_FROM_M_NO; }		

		function setPL_FROM_M_HP($PL_FROM_M_HP){ $this->PL_FROM_M_HP = $PL_FROM_M_HP; }		
		function getPL_FROM_M_HP(){ return $this->PL_FROM_M_HP; }		

		function setPL_FROM_M_NAME($PL_FROM_M_NAME){ $this->PL_FROM_M_NAME = $PL_FROM_M_NAME; }		
		function getPL_FROM_M_NAME(){ return $this->PL_FROM_M_NAME; }		

		function setPL_TEXT($PL_TEXT){ $this->PL_TEXT = $PL_TEXT; }		
		function getPL_TEXT(){ return $this->PL_TEXT; }		

		function setPL_IP($PL_IP){ $this->PL_IP = $PL_IP; }		
		function getPL_IP(){ return $this->PL_IP; }		

		function setPL_SEND_DATE($PL_SEND_DATE){ $this->PL_SEND_DATE = $PL_SEND_DATE; }		
		function getPL_SEND_DATE(){ return $this->PL_SEND_DATE; }		

		function setPL_SEND_RESULT($PL_SEND_RESULT){ $this->PL_SEND_RESULT = $PL_SEND_RESULT; }		
		function getPL_SEND_RESULT(){ return $this->PL_SEND_RESULT; }		

		function setPL_REG_DT($PL_REG_DT){ $this->PL_REG_DT = $PL_REG_DT; }		
		function getPL_REG_DT(){ return $this->PL_REG_DT; }		

		function setPL_REG_NO($PL_REG_NO){ $this->PL_REG_NO = $PL_REG_NO; }		
		function getPL_REG_NO(){ return $this->PL_REG_NO; }	

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