<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2013-11-03												|# 
#|작성내용	: 회원 그룹 모듈 클레스									|# 
#/*====================================================================*/# 

require_once "Module.php";

class MemberGroupMgrModule extends Module2
{
		function getMemberGroupMgrSelectEx($op, $param)
		{
			$column['OP_LIST']		= "G.*";
			$column['OP_SELECT']	= "*";
			$column['OP_COUNT']		= "COUNT(*)";
			$column['OP_ARYTOTAL']	= "*";

			## query(1) 영역
			
			## limit1
			if($param['LIMIT']):
				$limit1			= "LIMIT {$param['LIMIT']}";
			endif;		
			
			## order_by1
			if($param['ORDER_BY']):
				$order_by1		= "ORDER BY {$param['ORDER_BY']}";
			else:
				## default
				$order_by1		= "ORDER BY G.G_CODE ASC";
			endif;

			## where1
			$where1				= "WHERE G.G_CODE IS NOT NULL";

			if($param['G_CODE']):
				$where1			= "{$where1} AND G.G_CODE = '{$param['G_CODE']}'";
			endif;

			if($param['G_NAME']):
				$where1			= "{$where1} AND G.G_NAME = '{$param['G_NAME']}'";
			endif;

			## from1
			$from1				= "FROM MEMBER_GROUP_MGR AS G";

			## select1
			$select1			= "SELECT {$column[$op]}";
			
			## query1
			$query1				= "{$select1} {$from1} {$join1_1} {$join1_2} {$where1} {$order_by1} {$limit1}";
		//	echo $query1;

			return $this->getSelectQuery($query1, $op);
		}

		function getMemberGroupMgrInsertEx($param)
		{

		}

		function getMemberGroupMgrUpdateEx($param)
		{

		}
		
		function getMemberGroupMgrMinBuyPriceUpdateEx($param)
		{
			## 기본 설정
			$intG_MIN_BUY_PRICE = $param['G_MIN_BUY_PRICE'];
			$strG_CODE = $param['G_CODE'];

			## 체크
			if(!$strG_CODE) { return; }

			## 수정 데이터
			$paramData							= "";
			$paramData['G_MIN_BUY_PRICE']		= $this->db->getSQLInteger($intG_MIN_BUY_PRICE);

			## where
			$where = "G_CODE = '{$strG_CODE}'";

			return $this->db->getUpdateParam("MEMBER_GROUP_MGR", $paramData, $where);
		}

		function getMemberGroupMgrDeleteEx($param)
		{

		}

		// 테이블 업데이트
		function getMemberGroupMgrAlter()
		{
			if(!$this->db->getIsColumn('MEMBER_GROUP_MGR', 'G_MIN_BUY_PRICE')):
				$SQL = "ALTER TABLE MEMBER_GROUP_MGR ADD COLUMN G_MIN_BUY_PRICE DECIMAL(18,2) COMMENT '최소구매금액' AFTER G_LEVEL";
				$re = $this->db->getExecSql($SQL);
				if($re != 1)
					echo 'MEMBER_GROUP_MGR - G_MIN_BUY_PRICE 컬럼 업데이트 오류';
			endif;
		}

		function getSelectQuery($query, $op)
		{
			if ( $op == "OP_LIST" ) :
				return $this->db->getExecSql($query);
			elseif ( $op == "OP_SELECT" ) :
				return $this->db->getSelect($query);
			elseif ( $op == "OP_COUNT" ) :
				return $this->db->getCount($query);
			elseif ( $op == "OP_ARYLIST" ) :
				return $this->db->getArray($query);
			elseif ( $op == "OP_ARYTOTAL" ) :
				return $this->db->getArrayTotal($query);
			else :
				return -100;
			endif;
		}	
}