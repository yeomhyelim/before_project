<?
#/*============================================================================================*/# 
#|화일명	: 																					|# 
#|작성자	: 심성일																			|# 
#|작성일	: 2012-08-20																		|# 
#|작성내용	: main/sub page 추천상품 진열방식정의와 상품리스트/상세페이지 디자인, Function 결정	|# 
#/*============================================================================================*/# 

class ProdpageMgr
{
	private $query;
	private $param;

	/********************************** List **********************************/
	function getProdpageList($db)
	{
		$query  = "SELECT														";
		$query .= "	*															";
		$query .= "FROM ".TBL_PRODPAGE_MGR."									";
		$query .= "WHERE PV_NO IS NOT NULL									";
//		$query .= "AND PV_USE = 'Y'													";
		
		if($this->getPV_PAGE()) {
			$query .= "AND PV_PAGE = '" . $this->getPV_PAGE() . "'				";
		}

		$query .= "ORDER BY PV_NO ASC	";

		return $db->getExecSql($query);
	}

	function getProdpageTotal($db)
	{
		$query  = "SELECT																	";
		$query .= "COUNT(*)																";
		$query .= "FROM ".TBL_PRODPAGE_MGR."								";
		$query .= "WHERE PV_NO IS NOT NULL									";
//		$query .= "AND PV_USE = 'Y'													";		

		if($this->getPV_PAGE()) {
			$query .= "AND PV_PAGE = '" . $this->getPV_PAGE() . "'				";
		}

		return $db->getCount($query);
	}

	/********************************** view **********************************/
	function getProdpageView($db)
	{
		$query  = "SELECT														";
		$query .= "	*															";
		$query .= "FROM ".TBL_PRODPAGE_MGR."									";
		$query .= "WHERE PV_NO=".$this->getPV_NO()."							";
		return $db->getSelect($query);
	}


	/********************************** Insert **********************************/
	function getProdpageInsert($db)
	{
		$query = "CALL SP_DESIGN_PRODPAGE_MGR_I (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getPV_CODE();
		$param[]  = $this->getPV_PAGE();
		$param[]  = $this->getPV_MODUL_TYPE();
		$param[]  = $this->getPV_DESIGN_NO();
		$param[]  = $this->getPV_MODUL_NAME();
		$param[]  = $this->getPV_IMAGE_FILE();
		$param[]  = $this->getPV_IMAGE_SIZE_W();
		$param[]  = $this->getPV_IMAGE_SIZE_H();
		$param[]  = $this->getPV_IMAGE_CNT_W();
		$param[]  = $this->getPV_IMAGE_CNT_H();
		$param[]  = $this->getPV_MODUL_TEXT();
		$param[]  = $this->getPV_LIST_CATE();
		$param[]  = $this->getPV_VIEW_FUNCTION();
		$param[]  = $this->getPV_USE();
		$param[]  = $this->getPV_ORDER();
		$param[]  = $this->getPV_REG_DT();
		$param[]  = $this->getPV_REG_NO();

		return $db->executeBindingQuery($query,$param,true);
	}


	/********************************** Insert **********************************/
	function getProdpageUpdate($db)
	{
		$query = "CALL SP_DESIGN_PRODPAGE_MGR_U (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
		
		$param[]  = $this->getPV_NO();
		$param[]  = $this->getPV_CODE();
		$param[]  = $this->getPV_PAGE();
		$param[]  = $this->getPV_MODUL_TYPE();
		$param[]  = $this->getPV_DESIGN_NO();
		$param[]  = $this->getPV_MODUL_NAME();
		$param[]  = $this->getPV_IMAGE_FILE();
		$param[]  = $this->getPV_IMAGE_SIZE_W();
		$param[]  = $this->getPV_IMAGE_SIZE_H();
		$param[]  = $this->getPV_IMAGE_CNT_W();
		$param[]  = $this->getPV_IMAGE_CNT_H();
		$param[]  = $this->getPV_MODUL_TEXT();
		$param[]  = $this->getPV_LIST_CATE();
		$param[]  = $this->getPV_VIEW_FUNCTION();
		$param[]  = $this->getPV_USE();
		$param[]  = $this->getPV_ORDER();
		$param[]  = $this->getPV_MOD_DT();
		$param[]  = $this->getPV_MOD_NO();

		return $db->executeBindingQuery($query,$param,true);
	}




	/********************************** variable **********************************/
	function setPV_NO($PV_NO){ $this->PV_NO = $PV_NO; }		
	function getPV_NO(){ return $this->PV_NO; }	
	
	function setPV_CODE($PV_CODE){ $this->PV_CODE = $PV_CODE; }		
	function getPV_CODE(){ return $this->PV_CODE; }	

	function setPV_PAGE($PV_PAGE){ $this->PV_PAGE = $PV_PAGE; }		
	function getPV_PAGE(){ return $this->PV_PAGE; }		

	function setPV_MODUL_TYPE($PV_MODUL_TYPE){ $this->PV_MODUL_TYPE = $PV_MODUL_TYPE; }		
	function getPV_MODUL_TYPE(){ return $this->PV_MODUL_TYPE; }		

	function setPV_DESIGN_NO($PV_DESIGN_NO){ $this->PV_DESIGN_NO = $PV_DESIGN_NO; }		
	function getPV_DESIGN_NO(){ return $this->PV_DESIGN_NO; }		

	function setPV_MODUL_NAME($PV_MODUL_NAME){ $this->PV_MODUL_NAME = $PV_MODUL_NAME; }		
	function getPV_MODUL_NAME(){ return $this->PV_MODUL_NAME; }		

	function setPV_IMAGE_FILE($PV_IMAGE_FILE){ $this->PV_IMAGE_FILE = $PV_IMAGE_FILE; }		
	function getPV_IMAGE_FILE(){ return $this->PV_IMAGE_FILE; }		

	function setPV_IMAGE_SIZE_W($PV_IMAGE_SIZE_W){ $this->PV_IMAGE_SIZE_W = $PV_IMAGE_SIZE_W; }		
	function getPV_IMAGE_SIZE_W(){ return $this->PV_IMAGE_SIZE_W; }		

	function setPV_IMAGE_SIZE_H($PV_IMAGE_SIZE_H){ $this->PV_IMAGE_SIZE_H = $PV_IMAGE_SIZE_H; }		
	function getPV_IMAGE_SIZE_H(){ return $this->PV_IMAGE_SIZE_H; }		

	function setPV_IMAGE_CNT_W($PV_IMAGE_CNT_W){ $this->PV_IMAGE_CNT_W = $PV_IMAGE_CNT_W; }		
	function getPV_IMAGE_CNT_W(){ return $this->PV_IMAGE_CNT_W; }		

	function setPV_IMAGE_CNT_H($PV_IMAGE_CNT_H){ $this->PV_IMAGE_CNT_H = $PV_IMAGE_CNT_H; }		
	function getPV_IMAGE_CNT_H(){ return $this->PV_IMAGE_CNT_H; }		

	function setPV_MODUL_TEXT($PV_MODUL_TEXT){ $this->PV_MODUL_TEXT = $PV_MODUL_TEXT; }		
	function getPV_MODUL_TEXT(){ return $this->PV_MODUL_TEXT; }		

	function setPV_LIST_CATE($PV_LIST_CATE){ $this->PV_LIST_CATE = $PV_LIST_CATE; }		
	function getPV_LIST_CATE(){ return $this->PV_LIST_CATE; }		

	function setPV_VIEW_FUNCTION($PV_VIEW_FUNCTION){ $this->PV_VIEW_FUNCTION = $PV_VIEW_FUNCTION; }		
	function getPV_VIEW_FUNCTION(){ return $this->PV_VIEW_FUNCTION; }		

	function setPV_USE($PV_USE){ $this->PV_USE = $PV_USE; }		
	function getPV_USE(){ return $this->PV_USE; }

	function setPV_ORDER($PV_ORDER){ $this->PV_ORDER = $PV_ORDER; }		
	function getPV_ORDER(){ return $this->PV_ORDER; }		

	function setPV_REG_DT($PV_REG_DT){ $this->PV_REG_DT = $PV_REG_DT; }		
	function getPV_REG_DT(){ return $this->PV_REG_DT; }		

	function setPV_REG_NO($PV_REG_NO){ $this->PV_REG_NO = $PV_REG_NO; }		
	function getPV_REG_NO(){ return $this->PV_REG_NO; }		

	function setPV_MOD_DT($PV_MOD_DT){ $this->PV_MOD_DT = $PV_MOD_DT; }		
	function getPV_MOD_DT(){ return $this->PV_MOD_DT; }		

	function setPV_MOD_NO($PV_MOD_NO){ $this->PV_MOD_NO = $PV_MOD_NO; }		
	function getPV_MOD_NO(){ return $this->PV_MOD_NO; }		



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