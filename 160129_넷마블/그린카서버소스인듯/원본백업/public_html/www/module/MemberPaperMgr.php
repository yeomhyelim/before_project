<?
#/*====================================================================*/# 
#|작성자	: 김희성(thav@naver.com)									|# 
#|작성일	: 2013-01-22												|# 
#|작성내용	: 회원족지관리												|#
#/*====================================================================*/# 

class MemberPaperMgr
{
		public $field;

		function getMessage()
		{
			echo "회원족지관리(MemberPaperMgr)";
		}
		/********************************** Select **********************************/
		function getMemberPaperSelectEx($db,$op="OP_LIST", $param) 
		{
			$column['OP_LIST']			 = "MP.*";
			$column['OP_LIST']			.= ", MM1.M_NO as TO_M_NO, MM1.M_F_NAME as TO_M_F_NAME, MM1.M_L_NAME as TO_M_L_NAME, MM1.M_ID as TO_M_ID, MM1.M_MAIL as TO_M_MAIL";
			$column['OP_LIST']			.= ", MM2.M_NO as FROM_M_NO, MM2.M_F_NAME as FROM_M_F_NAME, MM2.M_L_NAME as FROM_M_L_NAME, MM2.M_ID as FROM_M_ID, MM2.M_MAIL as FROM_M_MAIL";
			$column['OP_COUNT']			 = "COUNT(*)";
			$column['OP_SELECT']		 = "MP.*";
			$column['OP_SELECT']		.= ", MM1.M_NO as TO_M_NO, MM1.M_F_NAME as TO_M_F_NAME, MM1.M_L_NAME as TO_M_L_NAME, MM1.M_ID as TO_M_ID, MM1.M_MAIL as TO_M_MAIL";
			$column['OP_SELECT']		.= ", MM2.M_NO as FROM_M_NO, MM2.M_F_NAME as FROM_M_F_NAME, MM2.M_L_NAME as FROM_M_L_NAME, MM2.M_ID as FROM_M_ID, MM2.M_MAIL as FROM_M_MAIL";
			$column['OP_ARRY_TOTAL']	 = "MP.*";
			$column['OP_ARRY_TOTAL']	.= ", MM1.M_NO as TO_M_NO, MM1.M_F_NAME as TO_M_F_NAME, MM1.M_L_NAME as TO_M_L_NAME, MM1.M_ID as TO_M_ID, MM1.M_MAIL as TO_M_MAIL";
			$column['OP_ARRY_TOTAL']	.= ", MM2.M_NO as FROM_M_NO, MM2.M_F_NAME as FROM_M_F_NAME, MM2.M_L_NAME as FROM_M_L_NAME, MM2.M_ID as FROM_M_ID, MM2.M_MAIL as FROM_M_MAIL";

			if(!$op)	{ return; }
	//		if(!$param) { return; }

			$query	= "SELECT {$column[$op]} FROM ".TBL_MEMBER_PAPER." AS MP";
			$join1	= "LEFT OUTER JOIN ".TBL_MEMBER_MGR." AS MM1 ON MM1.M_NO = MP.MP_TO_M_NO";
			$join2	= "LEFT OUTER JOIN ".TBL_MEMBER_MGR." AS MM2 ON MM2.M_NO = MP.MP_FROM_M_NO";
			$where	= "WHERE MP.MP_NO IS NOT NULL";

			if($param['MP_NO']):
				$where		= "{$where} AND MP.MP_NO = '{$param['MP_NO']}'";
			endif;

			if($param['MP_NO_IN']):
				$where		= "{$where} AND MP.MP_NO IN ({$param['MP_NO_IN']})";
			endif;

			if($param['MP_TO_M_NO']):
				$where		= "{$where} AND MP.MP_TO_M_NO = '{$param['MP_TO_M_NO']}'";
			endif;

			if($param['MP_DEL_YN']):
				$where		= "{$where} AND MP.MP_DEL_YN = '{$param['MP_DEL_YN']}'";
			endif;

			if($param['ORDER_BY']):
				$order_by	= "ORDER BY {$param['ORDER_BY']}";
			endif;

			if($param['LIMIT']):
				$limit		= "LIMIT {$param['LIMIT']}";
			endif;

			$query = "{$query} {$join1} {$join2} {$where} {$order_by} {$limit}";

			return $this->getSelectQuery($db, $query, $op);
		}

		function getMemberPaperSelect($db,$op="OP_LIST") 
		{
			$column['OP_LIST']		= "a.*, b.M_F_NAME as TO_M_F_NAME, b.M_L_NAME as TO_M_L_NAME, c.M_F_NAME as FROM_M_F_NAME, c.M_L_NAME as FROM_M_L_NAME	";
			$column['OP_COUNT']		= "COUNT(*)";
			$column['OP_SELECT']	= "a.*";

			$query			= "SELECT %s FROM %s AS a";
			$query			= sprintf($query, $column[$op], TBL_MEMBER_PAPER);

			$queryJoin1		= "%s LEFT OUTER JOIN %s AS b ON b.M_ID = a.MP_TO_M_ID";
			$queryJoin2		= "%s LEFT OUTER JOIN %s AS c ON c.M_ID = a.MP_FROM_M_ID";
			
			$query			= sprintf($queryJoin1, $query, TBL_MEMBER_MGR);
			$query			= sprintf($queryJoin2, $query, TBL_MEMBER_MGR);

			$queryWhere		= "%s WHERE a.MP_NO IS NOT NULL ";
			$query			= sprintf($queryWhere, $query);

			if($this->getMP_NO()) :
				$query = sprintf("%s AND MP_NO = %d", $query, $this->getMP_NO());
			endif;

			if($this->getMP_PP_NO()) : 
				$query = sprintf("%s AND MP_PP_NO = %d", $query, $this->getMP_PP_NO());
			endif;
			
			if($this->getPageLine()) :
				$query = sprintf("%s LIMIT %d, %d", $query, $this->getLimitFirst(), $this->getPageLine());
			endif;

			return $this->getSelectQuery($db, $query, $op);
		}



		/********************************** Insert **********************************/
		function getMemberPaperInsertEx($db, $paramData)
		{
			$query = "CALL SP_MEMBER_PAPER_I (?,?,?,?,?,?,?,?,?,?);";

			$param[]  = $paramData['MP_NO'];
			$param[]  = $paramData['MP_PP_NO'];
			$param[]  = $paramData['MP_TO_M_NO'];
			$param[]  = $paramData['MP_FROM_M_NO'];
			$param[]  = $paramData['MP_TITLE'];
			$param[]  = $paramData['MP_TEXT'];
			$param[]  = $paramData['MP_CHECK_DT'];
			$param[]  = $paramData['MP_DEL_YN'];
			$param[]  = $paramData['MP_REG_NO'];
			$param[]  = $paramData['MP_REG_DT'];

			return $db->executeBindingQuery($query,$param,true);
		}


		function getMemberPaperInsert($db)
		{
			$query = "CALL SP_MEMBER_PAPER_I (?,?,?,?,?,?,?,?,?,?);";

			$param[]  = $this->getMP_NO();
			$param[]  = $this->getMP_PP_NO();
			$param[]  = $this->getMP_TO_M_ID();
			$param[]  = $this->getMP_FROM_M_ID();
			$param[]  = $this->getMP_TITLE();
			$param[]  = $this->getMP_TEXT();
			$param[]  = $this->getMP_CHECK_DT();
			$param[]  = $this->getMP_DEL_YN();
			$param[]  = $this->getMP_REG_NO();
			$param[]  = $this->getMP_REG_DT();

			return $db->executeBindingQuery($query,$param,true);
		}

		/********************************** Update **********************************/
		function getPostMailUpdate($db)
		{

		}

		function getMemberPaperDeleteUpdate($db, $param)
		{
			if(!$param['MP_NO']) { return; }
			$query = "UPDATE ".TBL_MEMBER_PAPER." SET MP_DEL_YN = 'Y' WHERE MP_NO = {$param['MP_NO']}";
			return $db->getExecSql($query);
		}

		/********************************* Delete ***********************************/


		function getMemberPaperDelete($db, $param)
		{
			


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
			elseif ( $op == "OP_ARRY_TOTAL" ) :
				return $db->getArrayTotal($query);
			else :
				return -100;
			endif;
		}

		/********************************** variable **********************************/
		function setMP_NO($MP_NO){ $this->MP_NO = $MP_NO; }		
		function getMP_NO(){ return $this->MP_NO; }		

		function setMP_PP_NO($MP_PP_NO){ $this->MP_PP_NO = $MP_PP_NO; }		
		function getMP_PP_NO(){ return $this->MP_PP_NO; }		

		function setMP_TO_M_ID($MP_TO_M_ID){ $this->MP_TO_M_ID = $MP_TO_M_ID; }		
		function getMP_TO_M_ID(){ return $this->MP_TO_M_ID; }		

		function setMP_FROM_M_ID($MP_FROM_M_ID){ $this->MP_FROM_M_ID = $MP_FROM_M_ID; }		
		function getMP_FROM_M_ID(){ return $this->MP_FROM_M_ID; }		

		function setMP_TITLE($MP_TITLE){ $this->MP_TITLE = $MP_TITLE; }		
		function getMP_TITLE(){ return $this->MP_TITLE; }		

		function setMP_TEXT($MP_TEXT){ $this->MP_TEXT = $MP_TEXT; }		
		function getMP_TEXT(){ return $this->MP_TEXT; }		

		function setMP_CHECK_DT($MP_CHECK_DT){ $this->MP_CHECK_DT = $MP_CHECK_DT; }		
		function getMP_CHECK_DT(){ return $this->MP_CHECK_DT; }		

		function setMP_DEL_YN($MP_DEL_YN){ $this->MP_DEL_YN = $MP_DEL_YN; }		
		function getMP_DEL_YN(){ return $this->MP_DEL_YN; }		

		function setMP_REG_NO($MP_REG_NO){ $this->MP_REG_NO = $MP_REG_NO; }		
		function getMP_REG_NO(){ return $this->MP_REG_NO; }		

		function setMP_REG_DT($MP_REG_DT){ $this->MP_REG_DT = $MP_REG_DT; }		
		function getMP_REG_DT(){ return $this->MP_REG_DT; }	

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