<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: 심성일													|# 
#|작성일	: 2012-08-23												|# 
#|작성내용	: 메인 디자인 설정 에디터									|# 
#/*====================================================================*/# 

class MaindesignMgr
{
	private $query;
	private $param;


	/********************************** List **********************************/
		function getMaindesignList($db)
		{
			$query  = "SELECT														";
			$query .= "	*															";
			$query .= "FROM ".TBL_DESIGNEDIT."										";

			$query .= "ORDER BY DE_NO ASC											";

			return $db->getExecSql($query);
		}
	

	/********************************** view **********************************/
	function getMaindesignView($db)
	{
		$query  = "SELECT														";
		$query .= "	*															";
		$query .= "FROM ".TBL_DESIGNEDIT."										";
		$query .= "WHERE DE_NO=".$this->getDE_NO()."							";
		return $db->getSelect($query);
	}



	/********************************** Insert **********************************/
	function getMaindesignInsert($db)
	{
		$query = "CALL SP_DESIGN_EDIT_I (?,?,?,?,?,?);";

		$param[]  = $this->getDE_CODE();
		$param[]  = $this->getDE_EDIT_GROUP();
		$param[]  = $this->getDE_EDIT_SECTION();
		$param[]  = $this->getDE_EDIT_TEXT();
		$param[]  = $this->getDE_REG_DT();
		$param[]  = $this->getDE_REG_NO();


		return $db->executeBindingQuery($query,$param,true);
	}


	/********************************** Insert **********************************/
	function getMaindesignUpdate($db)
	{
		$query = "CALL SP_DESIGN_EDIT_U (?,?,?,?,?,?,?);";

		$param[]  = $this->getDE_NO();
		$param[]  = $this->getDE_CODE();
		$param[]  = $this->getDE_EDIT_GROUP();
		$param[]  = $this->getDE_EDIT_SECTION();
		$param[]  = $this->getDE_EDIT_TEXT();
		$param[]  = $this->getDE_MOD_DT();
		$param[]  = $this->getDE_MOD_NO();

		return $db->executeBindingQuery($query,$param,true);
	}


	/********************************** Insert **********************************/
	function getMaindesignDelete($db)
	{
		$query = "CALL SP_DESIGN_EDIT_D (?);";
		$param[]  = $this->getDE_NO();

		return $db->executeBindingQuery($query,$param,true);
	}


	/********************************** variable **********************************/
	function setDE_NO($DE_NO){ $this->DE_NO = $DE_NO; }		
	function getDE_NO(){ return $this->DE_NO; }		

	function setDE_CODE($DE_CODE){ $this->DE_CODE = $DE_CODE; }		
	function getDE_CODE(){ return $this->DE_CODE; }		

	function setDE_EDIT_GROUP($DE_EDIT_GROUP){ $this->DE_EDIT_GROUP = $DE_EDIT_GROUP; }		
	function getDE_EDIT_GROUP(){ return $this->DE_EDIT_GROUP; }		

	function setDE_EDIT_SECTION($DE_EDIT_SECTION){ $this->DE_EDIT_SECTION = $DE_EDIT_SECTION; }		
	function getDE_EDIT_SECTION(){ return $this->DE_EDIT_SECTION; }		

	function setDE_EDIT_TEXT($DE_EDIT_TEXT){ $this->DE_EDIT_TEXT = $DE_EDIT_TEXT; }		
	function getDE_EDIT_TEXT(){ return $this->DE_EDIT_TEXT; }		

	function setDE_REG_DT($DE_REG_DT){ $this->DE_REG_DT = $DE_REG_DT; }		
	function getDE_REG_DT(){ return $this->DE_REG_DT; }		

	function setDE_REG_NO($DE_REG_NO){ $this->DE_REG_NO = $DE_REG_NO; }		
	function getDE_REG_NO(){ return $this->DE_REG_NO; }		

	function setDE_MOD_DT($DE_MOD_DT){ $this->DE_MOD_DT = $DE_MOD_DT; }		
	function getDE_MOD_DT(){ return $this->DE_MOD_DT; }		

	function setDE_MOD_NO($DE_MOD_NO){ $this->DE_MOD_NO = $DE_MOD_NO; }		
	function getDE_MOD_NO(){ return $this->DE_MOD_NO; }		

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