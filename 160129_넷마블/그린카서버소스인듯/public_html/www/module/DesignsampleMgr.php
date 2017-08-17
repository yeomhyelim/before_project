<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: 심성일													|# 
#|작성일	: 2012-08-24												|# 
#|작성내용	: 샘플 디자인 관리											|# 
#/*====================================================================*/# 

class DesignsampleMgr
{
	private $query;
	private $param;

	/********************************** List **********************************/
		function getDesignsampleList($db)
		{
			$query  = "SELECT																	";
			$query .= "	*																		";
			$query .= "FROM ".TBL_DESIGN."													";
			$query .= "WHERE DM_NO  IS NOT NULL											";

			// 디자인 타입
			if ( $this->getDM_DESIGN_TYPE() ) {
				$query .= "AND DM_DESIGN_TYPE  = '" . $this->getDM_DESIGN_TYPE() . "'					";
			}
			
			// 디자인 그룹
			if ( $this->getDM_DESIGN_GROUP() ) {
				$query .= "AND DM_DESIGN_GROUP  = '" . $this->getDM_DESIGN_GROUP() . "'				";
			}

//			if ( $this->getSearchKey() ) {
//				$query .= "AND DM_DESIGN_TITLE  LIKE '%".mysql_real_escape_string($this->getSearchKey())."%'					";
//			}

//			$query .= "ORDER BY DM_NO DESC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();
			
//			return $query;
			return $db->getExecSql($query);
		}

		function getDesignsampleTotal($db)
		{
			$query  = "SELECT														";
			$query .= "	COUNT(*)													";
			$query .= "FROM ".TBL_DESIGN."										";
			$query .= "WHERE DM_NO  IS NOT NULL								";
			
			// 디자인 타입
			if ( $this->getDM_DESIGN_TYPE() ) {
				$query .= "AND DM_DESIGN_TYPE  = '" . $this->getDM_DESIGN_TYPE() . "'					";
			}
				
			// 디자인 그룹
			if ( $this->getDM_DESIGN_GROUP() ) {
				$query .= "AND DM_DESIGN_GROUP  = '" . $this->getDM_DESIGN_GROUP() . "'				";
			}
			
//			if($this->getSearchKey()){
//				if(!$wh){
//					$query .= "WHERE DM_DESIGN_TITLE LIKE '%".mysql_real_escape_string($this->getSearchKey())."%'	";
//				}else{
//					$query .= "AND DM_DESIGN_TITLE LIKE '%".($this->getSearchKey())."%'		";
//				}
//			}

			return $db->getCount($query);
		}

		/********************************** view **********************************/
		function getDesignsampleView($db)
		{
			$query  = "SELECT														";
			$query .= "	*															";
			$query .= "FROM ".TBL_DESIGN."											";
			$query .= "WHERE DM_NO=".$this->getDM_NO()."							";
			return $db->getSelect($query);
		}


	/********************************** Insert **********************************/
	function getDesignsampleInsert($db)
	{
		$query = "CALL SP_DESIGN_MGR_I (?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getDM_DESIGN_PAGE();
		$param[]  = $this->getDM_DESIGN_GROUP();
		$param[]  = $this->getDM_DESIGN_TYPE();
		$param[]  = $this->getDM_DESIGN_CODE();
		$param[]  = $this->getDM_DESIGN_TITLE();
		$param[]  = $this->getDM_DESIGN_TXT();
		$param[]  = $this->getDM_SAMPLE_LINK();
		$param[]  = $this->getDM_SAMPLE_IMAGE_1();
		$param[]  = $this->getDM_SAMPLE_IMAGE_2();
		$param[]  = $this->getDM_REG_DT();
		$param[]  = $this->getDM_REG_NO();


		return $db->executeBindingQuery($query,$param,true);
	}


	/********************************** Insert **********************************/
	function getDesignsampleUpdate($db)
	{
		$query = "CALL SP_DESIGN_MGR_U (?,?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getDM_NO();
		$param[]  = $this->getDM_DESIGN_PAGE();
		$param[]  = $this->getDM_DESIGN_GROUP();
		$param[]  = $this->getDM_DESIGN_TYPE();
		$param[]  = $this->getDM_DESIGN_CODE();
		$param[]  = $this->getDM_DESIGN_TITLE();
		$param[]  = $this->getDM_DESIGN_TXT();
		$param[]  = $this->getDM_SAMPLE_LINK();
		$param[]  = $this->getDM_SAMPLE_IMAGE_1();
		$param[]  = $this->getDM_SAMPLE_IMAGE_2();
		$param[]  = $this->getDM_MOD_DT();
		$param[]  = $this->getDM_MOD_NO();

		return $db->executeBindingQuery($query,$param,true);
	}


	/********************************** Insert **********************************/
	function getDesignsampleDelete($db)
	{
		$query = "CALL SP_DESIGN_MGR_D (?);";
		$param[]  = $this->getDM_NO();

		return $db->executeBindingQuery($query,$param,true);
	}


	/********************************** variable **********************************/
	function setDM_NO($DM_NO){ $this->DM_NO = $DM_NO; }		
	function getDM_NO(){ return $this->DM_NO; }		

	function setDM_DESIGN_PAGE($DM_DESIGN_PAGE){ $this->DM_DESIGN_PAGE = $DM_DESIGN_PAGE; }		
	function getDM_DESIGN_PAGE(){ return $this->DM_DESIGN_PAGE; }		

	function setDM_DESIGN_GROUP($DM_DESIGN_GROUP){ $this->DM_DESIGN_GROUP = $DM_DESIGN_GROUP; }		
	function getDM_DESIGN_GROUP(){ return $this->DM_DESIGN_GROUP; }	

	function setDM_DESIGN_TYPE($DM_DESIGN_TYPE){ $this->DM_DESIGN_TYPE = $DM_DESIGN_TYPE; }		
	function getDM_DESIGN_TYPE(){ return $this->DM_DESIGN_TYPE; }		

	function setDM_DESIGN_CODE($DM_DESIGN_CODE){ $this->DM_DESIGN_CODE = $DM_DESIGN_CODE; }		
	function getDM_DESIGN_CODE(){ return $this->DM_DESIGN_CODE; }		

	function setDM_DESIGN_TITLE($DM_DESIGN_TITLE){ $this->DM_DESIGN_TITLE = $DM_DESIGN_TITLE; }		
	function getDM_DESIGN_TITLE(){ return $this->DM_DESIGN_TITLE; }		

	function setDM_DESIGN_TXT($DM_DESIGN_TXT){ $this->DM_DESIGN_TXT = $DM_DESIGN_TXT; }		
	function getDM_DESIGN_TXT(){ return $this->DM_DESIGN_TXT; }		

	function setDM_SAMPLE_LINK($DM_SAMPLE_LINK){ $this->DM_SAMPLE_LINK = $DM_SAMPLE_LINK; }		
	function getDM_SAMPLE_LINK(){ return $this->DM_SAMPLE_LINK; }		

	function setDM_SAMPLE_IMAGE_1($DM_SAMPLE_IMAGE_1){ $this->DM_SAMPLE_IMAGE_1 = $DM_SAMPLE_IMAGE_1; }		
	function getDM_SAMPLE_IMAGE_1(){ return $this->DM_SAMPLE_IMAGE_1; }		

	function setDM_SAMPLE_IMAGE_2($DM_SAMPLE_IMAGE_2){ $this->DM_SAMPLE_IMAGE_2 = $DM_SAMPLE_IMAGE_2; }		
	function getDM_SAMPLE_IMAGE_2(){ return $this->DM_SAMPLE_IMAGE_2; }		

	function setDM_REG_DT($DM_REG_DT){ $this->DM_REG_DT = $DM_REG_DT; }		
	function getDM_REG_DT(){ return $this->DM_REG_DT; }		

	function setDM_REG_NO($DM_REG_NO){ $this->DM_REG_NO = $DM_REG_NO; }		
	function getDM_REG_NO(){ return $this->DM_REG_NO; }		

	function setDM_MOD_DT($DM_MOD_DT){ $this->DM_MOD_DT = $DM_MOD_DT; }		
	function getDM_MOD_DT(){ return $this->DM_MOD_DT; }		

	function setDM_MOD_NO($DM_MOD_NO){ $this->DM_MOD_NO = $DM_MOD_NO; }		
	function getDM_MOD_NO(){ return $this->DM_MOD_NO; }		

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