<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: 심성일													|# 
#|작성일	: 2012-08-23												|# 
#|작성내용	: 서브페이지 상단영역 이미지 관리							|# 
#/*====================================================================*/# 

class SubtopMgr
{
	private $query;
	private $param;

		/********************************** List **********************************/
		function getSubtopList($db)
		{
			$query  = "SELECT														";
			$query .= "	*															";
			$query .= "FROM ".TBL_SUBTOP_IMG."										";


			if($this->getSearchKey()){
				if(!$wh){
					$query .= "WHERE TI_CATE_CODE LIKE '%".mysql_real_escape_string($this->getSearchKey())."%'	";
				}else{
					$query .= "AND TI_CATE_CODE LIKE '%".mysql_real_escape_string($this->getSearchKey())."%'	";
				}
			}

			$query .= "ORDER BY TI_NO DESC	LIMIT ".$this->getLimitFirst().",".$this->getPageLine();

			return $db->getExecSql($query);
		}

		function getSubtopTotal($db)
		{
			$query  = "SELECT														";
			$query .= "	COUNT(*)													";
			$query .= "FROM ".TBL_SUBTOP_IMG."										";
			

			if($this->getSearchKey()){
				if(!$wh){
					$query .= "WHERE TI_CATE_CODE LIKE '%".mysql_real_escape_string($this->getSearchKey())."%'	";
				}else{
					$query .= "AND TI_CATE_CODE LIKE '%".($this->getSearchKey())."%'		";
				}
			}

			return $db->getCount($query);
		}


	/********************************** Insert **********************************/
	function getSubtopInsert($db)
	{
		$query = "CALL SP_DESIGN_TOP_IMAGES_I (?,?,?,?,?,?,?);";

		$param[]  = $this->getTI_CATE_CODE();
		$param[]  = $this->getTI_TOP_IMAGE();
		$param[]  = $this->getTI_LEFT_IMAGE();
		$param[]  = $this->getTI_HTML_TOP();
		$param[]  = $this->getTI_HTML_BOTTOM();
		$param[]  = $this->getTI_REG_DT();
		$param[]  = $this->getTI_REG_NO();


		return $db->executeBindingQuery($query,$param,true);
	}


	/********************************** Insert **********************************/
	function getSubtopUpdate($db)
	{
		$query = "CALL SP_DESIGN_TOP_IMAGES_U (?,?,?,?,?,?,?,?);";

		$param[]  = $this->getTI_NO();
		$param[]  = $this->getTI_CATE_CODE();
		$param[]  = $this->getTI_TOP_IMAGE();
		$param[]  = $this->getTI_LEFT_IMAGE();
		$param[]  = $this->getTI_HTML_TOP();
		$param[]  = $this->getTI_HTML_BOTTOM();
		$param[]  = $this->getTI_MOD_DT();
		$param[]  = $this->getTI_MOD_NO();

		return $db->executeBindingQuery($query,$param,true);
	}


	/********************************** Insert **********************************/
	function getSubtopDelete($db)
	{
		$query = "CALL SP_DESIGN_TOP_IMAGES_D (?);";
		$param[]  = $this->getTI_NO();

		return $db->executeBindingQuery($query,$param,true);
	}


	/********************************** variable **********************************/
	function setTI_NO($TI_NO){ $this->TI_NO = $TI_NO; }		
	function getTI_NO(){ return $this->TI_NO; }		

	function setTI_CATE_CODE($TI_CATE_CODE){ $this->TI_CATE_CODE = $TI_CATE_CODE; }		
	function getTI_CATE_CODE(){ return $this->TI_CATE_CODE; }		

	function setTI_TOP_IMAGE($TI_TOP_IMAGE){ $this->TI_TOP_IMAGE = $TI_TOP_IMAGE; }		
	function getTI_TOP_IMAGE(){ return $this->TI_TOP_IMAGE; }		

	function setTI_LEFT_IMAGE($TI_LEFT_IMAGE){ $this->TI_LEFT_IMAGE = $TI_LEFT_IMAGE; }		
	function getTI_LEFT_IMAGE(){ return $this->TI_LEFT_IMAGE; }		

	function setTI_HTML_TOP($TI_HTML_TOP){ $this->TI_HTML_TOP = $TI_HTML_TOP; }		
	function getTI_HTML_TOP(){ return $this->TI_HTML_TOP; }		

	function setTI_HTML_BOTTOM($TI_HTML_BOTTOM){ $this->TI_HTML_BOTTOM = $TI_HTML_BOTTOM; }		
	function getTI_HTML_BOTTOM(){ return $this->TI_HTML_BOTTOM; }		

	function setTI_REG_DT($TI_REG_DT){ $this->TI_REG_DT = $TI_REG_DT; }		
	function getTI_REG_DT(){ return $this->TI_REG_DT; }		

	function setTI_REG_NO($TI_REG_NO){ $this->TI_REG_NO = $TI_REG_NO; }		
	function getTI_REG_NO(){ return $this->TI_REG_NO; }		

	function setTI_MOD_DT($TI_MOD_DT){ $this->TI_MOD_DT = $TI_MOD_DT; }		
	function getTI_MOD_DT(){ return $this->TI_MOD_DT; }		

	function setTI_MOD_NO($TI_MOD_NO){ $this->TI_MOD_NO = $TI_MOD_NO; }		
	function getTI_MOD_NO(){ return $this->TI_MOD_NO; }		



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