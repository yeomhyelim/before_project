<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: 심성일													|# 
#|작성일	: 2012-08-23												|# 
#|작성내용	: 사이트 기본레이아웃 및 디자인 스킨 설정					|# 
#/*====================================================================*/# 

class DesignfirstMgr
{
	private $query;
	private $param;


	/********************************** view **********************************/
	function getDesignfirstView($db)
	{
		$query  = "SELECT																		";
		$query .= "	*																			";
		$query .= "FROM ".TBL_LAYOUT."												";
		$query .= "WHERE DL_NO=1														";
		return $db->getSelect($query);
	}

	/********************************** Insert **********************************/
	function getDesignfirstInsert($db)
	{
		$query = "CALL SP_DESIGN_LAYOUT_I (?,?,?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getDL_CODE();
		$param[]  = $this->getDL_DESIGN_CODE();
		$param[]  = $this->getDL_BG_TYPE();
		$param[]  = $this->getDL_BG_COLOR();
		$param[]  = $this->getDL_BG_IMAGE();
		$param[]  = $this->getDL_BG_IMG_DIR_H();
		$param[]  = $this->getDL_BG_IMG_DIR_V();
		$param[]  = $this->getDL_BG_REPEAT();
		$param[]  = $this->getDL_BG_ALIGN();
		$param[]  = $this->getDL_FIRST_PAGE();
		$param[]  = $this->getDL_FIRST_USE();
		$param[]  = $this->getDL_REG_DT();
		$param[]  = $this->getDL_REG_NO();

		return $db->executeBindingQuery($query,$param,true);
	}


	/********************************** Insert **********************************/
	function getDesignfirstUpdate($db)
	{
		// 디자인 관리 / 첫화면 설정
		$query = "CALL SP_DESIGN_LAYOUT_U (?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getDL_NO();
		$param[]  = $this->getDL_BG_TYPE();
		$param[]  = $this->getDL_BG_COLOR();
		$param[]  = $this->getDL_BG_IMAGE();
		$param[]  = $this->getDL_BG_IMG_DIR_H();
		$param[]  = $this->getDL_BG_IMG_DIR_V();
		$param[]  = $this->getDL_BG_REPEAT();
		$param[]  = $this->getDL_BG_ALIGN();
		$param[]  = $this->getDL_FIRST_PAGE();
		$param[]  = $this->getDL_FIRST_USE();
		$param[]  = $this->getDL_MOD_NO();

		return $db->executeBindingQuery($query,$param,true);
	}



	/********************************** variable **********************************/
	function setDL_NO($DL_NO){ $this->DL_NO = $DL_NO; }		
	function getDL_NO(){ return $this->DL_NO; }		

	function setDL_CODE($DL_CODE){ $this->DL_CODE = $DL_CODE; }		
	function getDL_CODE(){ return $this->DL_CODE; }		

	function setDL_DESIGN_CODE($DL_DESIGN_CODE){ $this->DL_DESIGN_CODE = $DL_DESIGN_CODE; }		
	function getDL_DESIGN_CODE(){ return $this->DL_DESIGN_CODE; }		

	function setDL_BG_TYPE($DL_BG_TYPE){ $this->DL_BG_TYPE = $DL_BG_TYPE; }		
	function getDL_BG_TYPE(){ return $this->DL_BG_TYPE; }		

	function setDL_BG_COLOR($DL_BG_COLOR){ $this->DL_BG_COLOR = $DL_BG_COLOR; }		
	function getDL_BG_COLOR(){ return $this->DL_BG_COLOR; }		

	function setDL_BG_IMAGE($DL_BG_IMAGE){ $this->DL_BG_IMAGE = $DL_BG_IMAGE; }		
	function getDL_BG_IMAGE(){ return $this->DL_BG_IMAGE; }		

	function setDL_BG_IMG_DIR_H($DL_BG_IMG_DIR_H){ $this->DL_BG_IMG_DIR_H = $DL_BG_IMG_DIR_H; }		
	function getDL_BG_IMG_DIR_H(){ return $this->DL_BG_IMG_DIR_H; }		

	function setDL_BG_IMG_DIR_V($DL_BG_IMG_DIR_V){ $this->DL_BG_IMG_DIR_V = $DL_BG_IMG_DIR_V; }		
	function getDL_BG_IMG_DIR_V(){ return $this->DL_BG_IMG_DIR_V; }		

	function setDL_BG_REPEAT($DL_BG_REPEAT){ $this->DL_BG_REPEAT = $DL_BG_REPEAT; }		
	function getDL_BG_REPEAT(){ return $this->DL_BG_REPEAT; }		

	function setDL_BG_ALIGN($DL_BG_ALIGN){ $this->DL_BG_ALIGN = $DL_BG_ALIGN; }		
	function getDL_BG_ALIGN(){ return $this->DL_BG_ALIGN; }		

	function setDL_FIRST_PAGE($DL_FIRST_PAGE){ $this->DL_FIRST_PAGE = $DL_FIRST_PAGE; }		
	function getDL_FIRST_PAGE(){ return $this->DL_FIRST_PAGE; }		

	function setDL_FIRST_USE($DL_FIRST_USE){ $this->DL_FIRST_USE = $DL_FIRST_USE; }		
	function getDL_FIRST_USE(){ return $this->DL_FIRST_USE; }		


	function setDL_REG_DT($DL_REG_DT){ $this->DL_REG_DT = $DL_REG_DT; }		
	function getDL_REG_DT(){ return $this->DL_REG_DT; }		

	function setDL_REG_NO($DL_REG_NO){ $this->DL_REG_NO = $DL_REG_NO; }		
	function getDL_REG_NO(){ return $this->DL_REG_NO; }		

	function setDL_MOD_DT($DL_MOD_DT){ $this->DL_MOD_DT = $DL_MOD_DT; }		
	function getDL_MOD_DT(){ return $this->DL_MOD_DT; }		

	function setDL_MOD_NO($DL_MOD_NO){ $this->DL_MOD_NO = $DL_MOD_NO; }		
	function getDL_MOD_NO(){ return $this->DL_MOD_NO; }		

	/********************************** variable **********************************/


}
?>