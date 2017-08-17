<?
#/*====================================================================*/#
#|화일명	: 이음샴관리자만사용										|#
#|작성자	: 박영미(ivetmi@naver.com)									|#
#|작성일	: 2013-04-02												|#
#|작성내용	: 배송비율등록												|#
#/*====================================================================*/#

class EumMgr
{
	private $query;
	private $param;
	
	/********************************** List **********************************/
	function getDeliveryList($db,$opt,$param="") {		
		
		$query  = "SELECT                                ";
		$query .= $this->getSearcyQry($opt);
		$query .= "FROM ".TBL_SHIPPING." A                   ";
		$query .= "WHERE A.DA_NO IS NOT NULL AND A.DA_TYPE = 'W'		";
					
		if ($this->getSearchDeliveryMth()){
			$query .= "	AND A.DA_MTH = '".mysql_real_escape_string($this->getSearchDeliveryMth())."'	";
		}

		if ($this->getSearchCountryZone()){
			$query .= "	AND A.DA_AREA = '".mysql_real_escape_string($this->getSearchCountryZone())."'	";
		}

		//검색어
		if ($this->getSearchField() && $this->getSearchKey()) {			
			$strSearchField = ""; 
			switch($this->getSearchField()){
				case "T":
					$strSearchField = "B.M_F_NAME	";
				break;
				case "I":
					$strSearchField = "B.M_ID	";
				break;
			}
			
			if ($strSearchField)
				$query .=" AND ".$strSearchField." LIKE '%".mysql_real_escape_string($this->getSearchKey())."%'";
		}
		
		if ($param['DELIVERY_FOR_COM_IN']){
			$query .= " AND A.DA_MTH IN (".$param['DELIVERY_FOR_COM_IN'].")	";
		}

		if ($opt == "deliveryList"){
			$query .= "ORDER BY A.DA_MTH,A.DA_AREA,A.DA_WEIGHT LIMIT ".$this->getLimitFirst().",".$this->getPageLine();
			return $db->getExecSql($query);
		} else {
			return $db->getCount($query);
		}
		
	}

	function getSearcyQry($opt)
	{
		$query = "";
		switch($opt){
			case "deliveryList":
				$query .= " A.* ";
			break;
			case "deliveryCount":
			case "countryCount":
			case "countryStateCount":
				$query .= " COUNT(*) ";
			break;
			case "countryList":
				$query .= "     A.*						";
				$query .= "    ,B.CT_NAME_KR			";
			break;

			case "countryStateList":
				$query .= "     A.*						";
				$query .= "    ,B.CT_NAME_KR			";
			break;

		}

		return $query;
	}
	
	function getDeliveryInsert($db){
		
		$array = array(
			 "DA_NO"		=> ""
			,"DA_TYPE"		=> $this->getDA_TYPE()
			,"DA_AREA"		=> $this->getDA_AREA()
			,"DA_WEIGHT"	=> $this->getDA_WEIGHT()
			,"DA_MTH"		=> $this->getDA_MTH()
			,"DA_PRICE"		=> $this->getDA_PRICE()
			,"DA_REG_NO"	=> $this->getDA_REG_NO()
			,"DA_REG_DT"	=> "NOW()"
		);
		
		return $db->getInsert(TBL_SHIPPING,$array,false);
	}

	function getDeliveryUpdate($db){
		
		$array = array(
			 "DA_TYPE"		=> $this->getDA_TYPE()
			,"DA_AREA"		=> $this->getDA_AREA()
			,"DA_WEIGHT"	=> $this->getDA_WEIGHT()
			,"DA_MTH"		=> $this->getDA_MTH()
			,"DA_PRICE"		=> $this->getDA_PRICE()
			,"DA_MOD_NO"	=> $this->getDA_REG_NO()
			,"DA_MOD_DT"	=> "NOW()"
		);
		
		return $db->getUpdate(TBL_SHIPPING,$array," DA_NO = ".$this->getDA_NO());
	}
	
	function getDeliveryDelete($db){
		
		return $db->getDelete(TBL_SHIPPING," DA_NO = ".$this->getDA_NO());
	}
	/********************************************************************************/	
	function getCountryList($db, $opt, $param = ""){
		$query  =    "SELECT					";
		$query .= $this->getSearcyQry($opt);
		$query .= "FROM ".TBL_COUNTRY_ZONE." A  ";
		$query .= "JOIN ".TBL_COUNTRY." B		";
		$query .= "ON A.CT_CODE = B.CT_CODE		";
		$query .= "WHERE A.CZ_NO IS NOT NULL	";

		if ($this->getSearchDeliveryMth()){
			$query .= "	AND A.CZ_MTH = '".mysql_real_escape_string($this->getSearchDeliveryMth())."'	";
		}

		if ($this->getSearchCountryZone()){
			$query .= "	AND A.CZ_ZONE = '".mysql_real_escape_string($this->getSearchCountryZone())."'	";
		}

		if ($param['DELIVERY_FOR_COM_IN']){
			$query .= " AND A.CZ_MTH IN (".$param['DELIVERY_FOR_COM_IN'].")	";
		}

		
		if ($opt == "countryList"){
			$query .= "ORDER BY A.CZ_ZONE LIMIT ".$this->getLimitFirst().",".$this->getPageLine();
			return $db->getExecSql($query);
		} else {
			return $db->getCount($query);
		}
	}
	
	function getCountrySelectList($db){
//		$query = "SELECT CT_CODE,CT_NAME_KR FROM ".TBL_COUNTRY." WHERE CT_CODE IS NOT NULL ORDER BY CT_CODE";
		$query = "SELECT CT_CODE,CT_NAME_KR FROM ".TBL_COUNTRY." WHERE CT_CODE IS NOT NULL ORDER BY CT_NAME_KR";
		return $db->getArray($query);
	}

	function getDeliveryMthZoneSelectList($db)
	{
		$query  = "SELECT					";
		$query .= "	 DA_AREA CODE			";
		$query .= "	,DA_AREA NAME			";	
		$query .= "FROM ".TBL_SHIPPING."	";
		$query .= "WHERE DA_TYPE = 'W'		";
		
		if ($this->getSearchDeliveryMth()){
			$query .= "	AND DA_MTH = '".mysql_real_escape_string($this->getSearchDeliveryMth())."'	";
		}
		
		$query .= "GROUP BY DA_AREA";

		return $db->getArray($query);
	}

	function getCountryZoneInsert($db){
		
		$array = array(
			 "CZ_NO"		=> ""
			,"CT_CODE"		=> $this->getCT_CODE()
			,"CZ_MTH"		=> $this->getCZ_MTH()
			,"CZ_ZONE"		=> $this->getCZ_ZONE()
		);
		
		return $db->getInsert(TBL_COUNTRY_ZONE,$array,false);
	}

	function getCountryZoneUpdate($db){
		
		$array = array(
			 "CT_CODE"		=> $this->getCT_CODE()
			,"CZ_MTH"		=> $this->getCZ_MTH()
			,"CZ_ZONE"		=> $this->getCZ_ZONE()
		);
		
		return $db->getUpdate(TBL_COUNTRY_ZONE,$array," CZ_NO = ".$this->getCZ_NO());
	}
	
	function getCountryZoneDelete($db){
		
		return $db->getDelete(TBL_COUNTRY_ZONE," CZ_NO = ".$this->getCZ_NO());
	}


	/********************************************************************************/	
	function getCountryStateList($db, $opt){
		$query  = "SELECT					";
		$query .= $this->getSearcyQry($opt);
		$query .= "FROM ".TBL_COUNTRY_STATE." A  ";
		$query .= "JOIN ".TBL_COUNTRY." B		";
		$query .= "ON A.CT_CODE = B.CT_CODE		";
		$query .= "WHERE A.CS_NO IS NOT NULL	";


		if ($this->getSearchCountryCode()){
			$query .= "	AND A.CT_CODE = '".mysql_real_escape_string($this->getSearchCountryCode())."'	";
		}
		
		if ($opt == "countryStateList"){
			$query .= "ORDER BY A.CS_NAME ";
			return $db->getExecSql($query);
		} else {
			return $db->getCount($query);
		}
	}
	
	function getCountryStateCount($db,$param)
	{
		$query  = "SELECT										";
		$query .= "    COUNT(*)									";
		$query .= "FROM ".TBL_COUNTRY_STATE."					";
		$query .= "WHERE CT_CODE	= '".$param["ct_code"]."'	";
		$query .= "    AND CS_CODE	= '".$param["cs_code"]."'	";
		$query .= "    AND CS_AREA	= '".$param["cs_area"]."'	";
		
		return $db->getCount($query);
	}

	function getCountryStateWrite($db,$param)
	{
		$query  = "INSERT INTO  ".TBL_COUNTRY_STATE."";
		$query .= "(								";
		$query .= "     CS_NO						";
		$query .= "    ,CT_CODE						";
		$query .= "    ,CS_CODE						";
		$query .= "    ,CS_NAME						";
		$query .= "    ,CS_AREA						";
		$query .= "    ,CS_REG_NO					";
		$query .= "    ,CS_REG_DT					";
		$query .= ")								";
		$query .= "VALUES							";
		$query .= "(								";
		$query .= "     ''							";
		$query .= "    ,'".$param["ct_code"]."'		";
		$query .= "    ,'".$param["cs_code"]."'		";
		$query .= "    ,'".$param["cs_name"]."'		";
		$query .= "    ,'".$param["cs_area"]."'		";
		$query .= "    ,'".$param["cs_reg_no"]."'	";
		$query .= "    ,NOW()						";
		$query .= ");								";
		
		return $db->getExecSql($query);
	}
	
	function getCountryStateModify($db,$param)
	{
		$query  = "UPDATE ".TBL_COUNTRY_STATE." SET				";
		$query .= "      CT_CODE     = '".$param["ct_code"]."'	";
		$query .= "    , CS_CODE     = '".$param["cs_code"]."'	";
		$query .= "    , CS_NAME     = '".$param["cs_code"]."'	";
		$query .= "    , CS_AREA     = '".$param["cs_area"]."'	";
		$query .= "    , CS_MOD_NO	 = '".$param["cs_reg_no"]."'";
		$query .= "    , CS_MOD_DT	 = NOW()        ";
		$query .= "WHERE CS_NO		 = ".$param["cs_no"];

		return $db->getExecSql($query);
	}

	function getCountryStateDelete($db,$param)
	{
		$query = "DELETE FROM ".TBL_COUNTRY_STATE." WHERE CS_NO = ".$param["cs_no"];
		return $db->getExecSql($query);
	}

	/********************************** variable **********************************/
	function setDA_NO($DA_NO){ $this->DA_NO = $DA_NO; }		
	function getDA_NO(){ return $this->DA_NO; }		

	function setDA_TYPE($DA_TYPE){ $this->DA_TYPE = $DA_TYPE; }		
	function getDA_TYPE(){ return $this->DA_TYPE; }		

	function setDA_NAME_KR($DA_NAME_KR){ $this->DA_NAME_KR = $DA_NAME_KR; }		
	function getDA_NAME_KR(){ return $this->DA_NAME_KR; }		

	function setDA_NAME_US($DA_NAME_US){ $this->DA_NAME_US = $DA_NAME_US; }		
	function getDA_NAME_US(){ return $this->DA_NAME_US; }		

	function setDA_NAME_CN($DA_NAME_CN){ $this->DA_NAME_CN = $DA_NAME_CN; }		
	function getDA_NAME_CN(){ return $this->DA_NAME_CN; }		

	function setDA_NAME_JP($DA_NAME_JP){ $this->DA_NAME_JP = $DA_NAME_JP; }		
	function getDA_NAME_JP(){ return $this->DA_NAME_JP; }		

	function setDA_NAME_ID($DA_NAME_ID){ $this->DA_NAME_ID = $DA_NAME_ID; }		
	function getDA_NAME_ID(){ return $this->DA_NAME_ID; }		

	function setDA_NAME_FR($DA_NAME_FR){ $this->DA_NAME_FR = $DA_NAME_FR; }		
	function getDA_NAME_FR(){ return $this->DA_NAME_FR; }		

	function setDA_AREA($DA_AREA){ $this->DA_AREA = $DA_AREA; }		
	function getDA_AREA(){ return $this->DA_AREA; }		

	function setDA_WEIGHT($DA_WEIGHT){ $this->DA_WEIGHT = $DA_WEIGHT; }		
	function getDA_WEIGHT(){ return $this->DA_WEIGHT; }		

	function setDA_MTH($DA_MTH){ $this->DA_MTH = $DA_MTH; }		
	function getDA_MTH(){ return $this->DA_MTH; }		

	function setDA_PRICE($DA_PRICE){ $this->DA_PRICE = $DA_PRICE; }		
	function getDA_PRICE(){ return $this->DA_PRICE; }		

	function setDA_REG_NO($DA_REG_NO){ $this->DA_REG_NO = $DA_REG_NO; }		
	function getDA_REG_NO(){ return $this->DA_REG_NO; }		

	function setDA_REG_DT($DA_REG_DT){ $this->DA_REG_DT = $DA_REG_DT; }		
	function getDA_REG_DT(){ return $this->DA_REG_DT; }		

	function setDA_MOD_NO($DA_MOD_NO){ $this->DA_MOD_NO = $DA_MOD_NO; }		
	function getDA_MOD_NO(){ return $this->DA_MOD_NO; }		

	function setDA_MOD_DT($DA_MOD_DT){ $this->DA_MOD_DT = $DA_MOD_DT; }		
	function getDA_MOD_DT(){ return $this->DA_MOD_DT; }		


	function setCZ_NO($CZ_NO){ $this->CZ_NO = $CZ_NO; }		
	function getCZ_NO(){ return $this->CZ_NO; }		

	function setCT_CODE($CT_CODE){ $this->CT_CODE = $CT_CODE; }		
	function getCT_CODE(){ return $this->CT_CODE; }		

	function setCZ_MTH($CZ_MTH){ $this->CZ_MTH = $CZ_MTH; }		
	function getCZ_MTH(){ return $this->CZ_MTH; }		

	function setCZ_ZONE($CZ_ZONE){ $this->CZ_ZONE = $CZ_ZONE; }		
	function getCZ_ZONE(){ return $this->CZ_ZONE; }		


	/**공통**/
	function setLimitFirst($LIMIT_FIRST){ $this->LIMIT_FIRST = $LIMIT_FIRST; }		
	function getLimitFirst(){ return $this->LIMIT_FIRST; }

	function setPageLine($PAGE_LINE){ $this->PAGE_LINE = $PAGE_LINE; }		
	function getPageLine(){ return $this->PAGE_LINE; }

	function setSearchField($SEARCH_FIELD){ $this->SEARCH_FIELD = $SEARCH_FIELD; }		
	function getSearchField(){ return $this->SEARCH_FIELD; }

	function setSearchKey($SEARCH_KEY){ $this->SEARCH_KEY = $SEARCH_KEY; }		
	function getSearchKey(){ return $this->SEARCH_KEY; }
	
	function setSearchDeliveryMth($SEARCH_DELIVERY_MTH){ $this->SEARCH_DELIVERY_MTH = $SEARCH_DELIVERY_MTH; }		
	function getSearchDeliveryMth(){ return $this->SEARCH_DELIVERY_MTH; }
	
	function setSearchCountryZone($SEARCH_COUNTRY_ZONE){ $this->SEARCH_COUNTRY_ZONE = $SEARCH_COUNTRY_ZONE; }		
	function getSearchCountryZone(){ return $this->SEARCH_COUNTRY_ZONE; }

	function setSearchCountryCode($SEARCH_COUNTRY_CODE){ $this->SEARCH_COUNTRY_CODE = $SEARCH_COUNTRY_CODE; }		
	function getSearchCountryCode(){ return $this->SEARCH_COUNTRY_CODE; }

	/********************************** variable **********************************/
}
?>