<?
#/*====================================================================*/# 
#|작성자	: 박영미(ivetmi@naver.com)									|# 
#|작성일	: 2012-06-04												|# 
#|작성내용	: 팝업관리													|# 
#/*====================================================================*/# 
class PopupMgr
{
	private $query;
	private $param;


	/********************************** List Total **********************************/
	function getPopupListEx($db, $op, $param) 
	{
		$column['OP_LIST']			= "*";
		$column['OP_COUNT']			= "COUNT(*)";
		$column['OP_SELECT']		= "*";

		if(!$op)			{ return; }

		$from	= TBL_POPUP;
		$query	= "SELECT {$column[$op]} FROM {$from} AS PO";
		$where	= "WHERE PO.PO_NO IS NOT NULL";

		if($param['PO_NO']):
			$where = "{$where} AND PO.PO_NO = {$param['PO_NO']}";
		endif;

		if($param['PO_VIEW']):
			$where = "{$where} AND PO.PO_VIEW = '{$param['PO_VIEW']}'";
		endif;

		if($param['STATE'] == "USEING"):
			$where = "{$where} AND (TO_DAYS(PO.PO_START_DT) <= TO_DAYS(NOW()) AND TO_DAYS(PO.PO_END_DT) >= TO_DAYS(NOW()))";
		endif;

		if($param['ORDER_BY']):
			$order_by	= "ORDER BY {$param['ORDER_BY']}";
		endif;

		if($param['LIMIT']):
			$limit		= "LIMIT {$param['LIMIT']}";
		endif;
		
		$query = "{$query} {$where} {$order_by} {$limit}";

		return $this->getSelectQuery($db, $query, $op);
	}

	function getTotal($db) {		
		
		$query  = " SELECT COUNT(*) FROM ".TBL_POPUP." A		";
		$query .= " WHERE A.P_NO IS NOT NULL					";		

		if ($this->getSearchStatusY() && $this->getSearchStatusN()){
		} else {
			if ($this->getSearchStatusY()){
					$query .=" AND A.PO_END_DT > NOW() ";
			}

			if ($this->getSearchStatusN()){
					$query .=" AND A.PO_END_DT < NOW() ";
			}
		}

		if ($this->getSearchKey()) {
				$query .=" AND A.PO_TITLE LIKE '%".mysql_real_escape_string($this->getSearchKey())."%'";
		}
		return $db->getCount($query);
	}

	/********************************** List **********************************/
	function getList($db) {
		
		$query  = " SELECT *";
		$query .= "		,CASE WHEN NOW() BETWEEN PO_START_DT AND PO_END_DT THEN 'Y' ELSE 'N' END PO_STATUS ";
		$query .= "FROM ".TBL_POPUP." A				";
		$query .= " WHERE A.P_NO IS NOT NULL		";		

		if ($this->getSearchStatusY() && $this->getSearchStatusN()){
		} else {
			if ($this->getSearchStatusY()){
					$query .=" AND A.PO_END_DT > NOW() ";
			}

			if ($this->getSearchStatusN()){
					$query .=" AND A.PO_END_DT < NOW() ";
			}
		}

		if ($this->getSearchKey()) {
				$query .=" AND A.PO_TITLE LIKE '%".mysql_real_escape_string($this->getSearchKey())."%'";
		}
		$query  .= " ORDER BY A.P_NO DESC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();
		return $result = $db->getExecSql($query);
	}



	function getMainPopup($db)
	{
		$query  = "SELECT															";
		$query .= "	A.*																";
		$query .= "FROM ".TBL_POPUP." A	WHERE 1 = 1									";

		if ($this->getPO_NO()){
			$query .= " AND A.PO_NO = '".mysql_real_escape_string($this->getPO_NO())."'		";
		} else {

			if ($this->getP_NO()){
				$query .= " AND A.P_NO = '".mysql_real_escape_string($this->getP_NO())."'	";
			}
	
			$query .= "AND NOW() BETWEEN A.PO_START_DT AND A.PO_END_DT		";
			$query .= "AND A.PO_VIEW = 'Y'			";
			$query .= "ORDER BY A.PO_NO ASC			";
		}

		return $db->getArrayTotal($query);
	}

	/********************************** View **********************************/
	function getView($db)
	{		
		$query  = " SELECT A.*							";
		$query .= " FROM ".TBL_POPUP." A					";
		$query .= "	WHERE A.PO_NO = '".mysql_real_escape_string($this->getPO_NO())."'";		
			
		return $db->getSelect($query);
	}
	/********************************** Insert **********************************/
	function getPopupInsertEx($db, $paramData) 
	{
//			$param['PO_NO']			= $db->getSQLInteger($paramData['po_no']);
			$param['PO_TYPE']		= $db->getSQLString($paramData['PO_TYPE']);
			$param['P_NO']			= $db->getSQLInteger($paramData['P_NO']);
			$param['PO_LINK']		= $db->getSQLString($paramData['PO_LINK']);
			$param['PO_TITLE']		= $db->getSQLString($paramData['PO_TITLE']);
			$param['PO_LEFT']		= $db->getSQLString($paramData['PO_LEFT']);
			$param['PO_TOP']		= $db->getSQLString($paramData['PO_TOP']);
			$param['PO_FILE']		= $db->getSQLString($paramData['PO_FILE']);
			$param['PO_START_DT']	= $db->getSQLDatetime($paramData['PO_START_DT']);
			$param['PO_END_DT']		= $db->getSQLDatetime($paramData['PO_END_DT']);
			$param['PO_VIEW']		= $db->getSQLString($paramData['PO_VIEW']);
			$param['PO_REG_DT']		= "NOW()";
			return $db->getInsertParam(TBL_POPUP,$param);
	}

	function getInsert($db)
	{
		$query = "CALL SP_POPUP_I (?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getPO_TYPE();
		$param[]  = $this->getP_NO();
		$param[]  = $this->getPO_LINK();
		$param[]  = $this->getPO_TITLE();
		$param[]  = $this->getPO_LEFT();
		$param[]  = $this->getPO_TOP();
		$param[]  = $this->getPO_FILE();
		$param[]  = $this->getPO_START_DT();
		$param[]  = $this->getPO_END_DT();
		$param[]  = $this->getPO_VIEW();

		return $db->executeBindingQuery($query,$param,true);
	}


	/********************************** Insert **********************************/
	function getPopupUpdateEx($db, $paramData) 
	{
		if(!$paramData['PO_NO']) { return; }

//		$param['PO_NO']			= $db->getSQLInteger($paramData['PO_NO']);
		$param['PO_TYPE']		= $db->getSQLString($paramData['PO_TYPE']);
		$param['P_NO']			= $db->getSQLInteger($paramData['P_NO']);
		$param['PO_LINK']		= $db->getSQLString($paramData['PO_LINK']);
		$param['PO_TITLE']		= $db->getSQLString($paramData['PO_TITLE']);
		$param['PO_LEFT']		= $db->getSQLString($paramData['PO_LEFT']);
		$param['PO_TOP']		= $db->getSQLString($paramData['PO_TOP']);
		$param['PO_FILE']		= $db->getSQLString($paramData['PO_FILE']);
		$param['PO_START_DT']	= $db->getSQLDatetime($paramData['PO_START_DT']);
		$param['PO_END_DT']		= $db->getSQLDatetime($paramData['PO_END_DT']);
		$param['PO_VIEW']		= $db->getSQLString($paramData['PO_VIEW']);
//		$param['PO_REG_DT']		= "NOW()";

		if($paramData['PO_NO']):
			$where				= "PO_NO = {$paramData['PO_NO']}";
		endif;
		
		if(!$where) { return; }

		return $db->getUpdateParam(TBL_POPUP,$param, $where);		
	}

	function getUpdate($db)
	{
		$query = "CALL SP_POPUP_U (?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getPO_NO();
		$param[]  = $this->getPO_TYPE();
		$param[]  = $this->getP_NO();
		$param[]  = $this->getPO_LINK();
		$param[]  = $this->getPO_TITLE();
		$param[]  = $this->getPO_LEFT();
		$param[]  = $this->getPO_TOP();
		$param[]  = $this->getPO_FILE();
		$param[]  = $this->getPO_START_DT();
		$param[]  = $this->getPO_END_DT();
		$param[]  = $this->getPO_VIEW();

		return $db->executeBindingQuery($query,$param,true);
	}


	/********************************** Delete **********************************/
	function gePopuptDeleteEx($db, $param)
	{
		$where			= "";
		if($param['PO_NO']):
			$where			= "{$where} AND PO_NO = {$param['PO_NO']}";
		endif;

		if($where):
			$where			= "PO_NO IS NOT NULL {$where}";
		endif;

		if(!$where) { return; }

		$db->getDelete(TBL_POPUP, $where);
	}

	function getDelete($db)
	{
		return $db->getDelete(TBL_POPUP," PO_NO=".mysql_real_escape_string($this->getPO_NO()));
	}


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
		elseif ( $op == "OP_ARYTOTAL" ) :
			return $db->getArrayTotal($query);
		else :
			return -100;
		endif;
	}

	/********************************** variable **********************************/
	function setPO_NO($PO_NO){ $this->PO_NO = $PO_NO; }		
	function getPO_NO(){ return $this->PO_NO; }		

	function setPO_TYPE($PO_TYPE){ $this->PO_TYPE = $PO_TYPE; }		
	function getPO_TYPE(){ return $this->PO_TYPE; }		

	function setPO_GUBUN($PO_GUBUN){ $this->PO_GUBUN = $PO_GUBUN; }		
	function getPO_GUBUN(){ return $this->PO_GUBUN; }		

	function setP_NO($P_NO){ $this->P_NO = $P_NO; }		
	function getP_NO(){ return $this->P_NO; }		

	function setPO_LINK($PO_LINK){ $this->PO_LINK = $PO_LINK; }		
	function getPO_LINK(){ return $this->PO_LINK; }		

	function setPO_TITLE($PO_TITLE){ $this->PO_TITLE = $PO_TITLE; }		
	function getPO_TITLE(){ return $this->PO_TITLE; }		

	function setPO_LEFT($PO_LEFT){ $this->PO_LEFT = $PO_LEFT; }		
	function getPO_LEFT(){ return $this->PO_LEFT; }		

	function setPO_TOP($PO_TOP){ $this->PO_TOP = $PO_TOP; }		
	function getPO_TOP(){ return $this->PO_TOP; }		

	function setPO_FILE($PO_FILE){ $this->PO_FILE = $PO_FILE; }		
	function getPO_FILE(){ return $this->PO_FILE; }		

	function setPO_START_DT($PO_START_DT){ $this->PO_START_DT = $PO_START_DT; }		
	function getPO_START_DT(){ return $this->PO_START_DT; }		

	function setPO_END_DT($PO_END_DT){ $this->PO_END_DT = $PO_END_DT; }		
	function getPO_END_DT(){ return $this->PO_END_DT; }		

	function setPO_VIEW($PO_VIEW){ $this->PO_VIEW = $PO_VIEW; }		
	function getPO_VIEW(){ return $this->PO_VIEW; }		

	function setPO_REG_DT($PO_REG_DT){ $this->PO_REG_DT = $PO_REG_DT; }		
	function getPO_REG_DT(){ return $this->PO_REG_DT; }		

	function setLimitFirst($LIMIT_FIRST){ $this->LIMIT_FIRST = $LIMIT_FIRST; }		
	function getLimitFirst(){ return $this->LIMIT_FIRST; }

	function setPageLine($PAGE_LINE){ $this->PAGE_LINE = $PAGE_LINE; }		
	function getPageLine(){ return $this->PAGE_LINE; }

	function setSearchStatusY($SearchStatusY){ $this->SearchStatusY = $SearchStatusY; }		
	function getSearchStatusY(){ return $this->SearchStatusY; }

	function setSearchStatusN($SearchStatusN){ $this->SearchStatusN = $SearchStatusN; }		
	function getSearchStatusN(){ return $this->SearchStatusN; }

	function setSearchKey($SEARCH_KEY){ $this->SEARCH_KEY = $SEARCH_KEY; }		
	function getSearchKey(){ return $this->SEARCH_KEY; }


	/********************************** variable **********************************/


}
?>