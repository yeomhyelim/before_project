<?
#/*====================================================================*/# 
#|작성자	: 박영미(ivetmi@naver.com)									|# 
#|작성일	: 2012-06-05												|# 
#|작성내용	: 배너관리													|# 
#/*====================================================================*/# 

class BannerMgr
{
	private $query;
	private $param;

	/********************************** insert **********************************/
	function getAdvertiseList($db)
	{
		$query  = "SELECT												";
		$query .= "	*													";
		$query .= "FROM ".TBL_ADVERTISE."								";

		if($this->getSearchStatusY()=="Y"){
			$where = "'Y'												";
		}

		if($this->getSearchStatusN()=="N"){
			if ($where) $where .= ",";
			$where .= "'N'												";
		}
		
		if($where){
			$query .= "WHERE A_USE IN (".$where.")						";
		}

		if($this->getSearchKey()){
			if(!$wh){
				$query .= "WHERE A_NAME LIKE '%".mysql_real_escape_string($this->getSearchKey())."%'	";
			}else{
				$query .= "AND A_NAME LIKE '%".mysql_real_escape_string($this->getSearchKey())."%'		";
			}
		}

		$query .= "ORDER BY A_NO DESC	LIMIT ".$this->getLimitFirst().",".$this->getPageLine();

		return $db->getExecSql($query);
	}

	function getAdvertiseListAll($db)
	{
		$query = "SELECT * FROM ".TBL_ADVERTISE." ";

		return $db->getExecSql($query);
	}

	/********************************** view **********************************/
	/* 광고관리 */
	function getAdvertiseView($db)
	{
		$query  = "SELECT															";
		$query .= "	*																";
		$query .= "FROM ".TBL_ADVERTISE."											";
		$query .= "WHERE A_NO=".$this->getA_NO()."									";

		return $db->getSelect($query);
	}

	/********************************** total **********************************/
	/* 광고관리 */
	function getAdvertiseTotal($db)
	{
		$query  = "SELECT												";
		$query .= "	COUNT(*)											";
		$query .= "FROM ".TBL_ADVERTISE."								";
		
		if($this->getSearchStatusY()=="Y"){
			$where = "'Y'												";
		}

		if($this->getSearchStatusN()=="N"){
			if ($where) $where .= ",";
			$where .= "'N'												";
		}
		
		if($where){
			$query .= "WHERE A_USE IN (".$where.")						";
		}

		if($this->getSearchKey()){
			if(!$wh){
				$query .= "WHERE A_NAME LIKE '%".mysql_real_escape_string($this->getSearchKey())."%'	";
			}else{
				$query .= "AND A_NAME LIKE '%".($this->getSearchKey())."%'		";
			}
		}

		return $db->getCount($query);
	}


	/********************************** insert **********************************/
	/* 광고관리 */
	function getAdvertiseInsert($db)
	{
//		$query = "CALL SP_ADVERTISE_I (?,?,?,?,?,?,?,?,?,?,?,?,?);";
		$query = "CALL SP_ADVERTISE_I (?,?,?,?,?,?,?,?,?,?,?);";
	
//		$param[]  = $this->getA_NO();
		$param[]  = $this->getA_NAME();
		$param[]  = $this->getA_TAG();
		$param[]  = $this->getA_LOCA();
		$param[]  = $this->getA_TABLE_W();
		$param[]  = $this->getA_TABLE_H();
		$param[]  = $this->getA_SIZE_W();
		$param[]  = $this->getA_SIZE_H();
		$param[]  = $this->getA_MARGIN_W();
		$param[]  = $this->getA_MARGIN_H();
		$param[]  = $this->getA_USE();
		$param[]  = $this->getA_REG_DT();
//		$param[]  = $this->getA_REG_NO();
//		$param[]  = $this->getA_MOD_DT();
//		$param[]  = $this->getA_MOD_NO();

		return $db->executeBindingQuery($query,$param,true);
	}


	/********************************** update **********************************/
	/* 광고관리 */
	function getAdvertiseUpdate($db)
	{
		$query = "CALL SP_ADVERTISE_U (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getA_NO();
		$param[]  = $this->getA_NAME();
		$param[]  = $this->getA_TAG();
		$param[]  = $this->getA_LOCA();
		$param[]  = $this->getA_TABLE_W();
		$param[]  = $this->getA_TABLE_H();
		$param[]  = $this->getA_SIZE_W();
		$param[]  = $this->getA_SIZE_H();
		$param[]  = $this->getA_MARGIN_W();
		$param[]  = $this->getA_MARGIN_H();
		$param[]  = $this->getA_USE();
		$param[]  = $this->getA_REG_DT();
		$param[]  = $this->getA_REG_NO();
		$param[]  = $this->getA_MOD_DT();
		$param[]  = $this->getA_MOD_NO();
		

		return $db->executeBindingQuery($query,$param,true);
	}

	/********************************** delete **********************************/
	/* 광고관리 */
	function getAdvertiseDelete($db)
	{
		return $db->getDelete(TBL_ADVERTISE," A_NO=".mysql_real_escape_string($this->getA_NO()));
	}

	/********************************** total **********************************/
	function getTotal($db)
	{
		$query  = "SELECT												";
		$query .= "	COUNT(*)											";
		$query .= "FROM ".TBL_BANNER." AS A								";
			
		$where  = "";
		if ($this->getSearchStatusY()=="Y" && $this->getSearchStatusN()=="N"){
		} else {
			if($this->getSearchStatusY()=="Y") { $where .= "'Y'"; }
			
			if($this->getSearchStatusN()=="N") :
				$where .= "'N'";
			endif;
		}

		if($where) { $where = "AND A.B_VIEW IN ({$where}) "; }

		if($this->getSearchKey()):
			$temp  = mysql_real_escape_string($this->getSearchKey());
			$where .= "AND A.B_TITLE LIKE '{$temp}%%' ";
		endif;

		if($this->getA_NO()):
			$where .= "AND A.A_NO = {$this->getA_NO()} ";
		endif;

		if($where):
			$query .= "WHERE A.B_NO IS NOT NULL " . $where;
		endif;

		/** 2013.04.29 old style 
		if($this->getSearchStatusY()=="Y"){
			$where = "'Y'												";
		}

		if($this->getSearchStatusN()=="N"){
			if ($where) $where .= ",";
			$where .= "'N'												";
		}
		
		if($where){
			$query .= "WHERE B_VIEW IN (".$where.")						";
		}

		if($this->getSearchKey()){
			if(!$wh){
				$query .= "WHERE B_TITLE LIKE '%".mysql_real_escape_string($this->getSearchKey())."%'	";
			}else{
				$query .= "AND B_TITLE LIKE '%".($this->getSearchKey())."%'		";
			}
		}
		**/

		return $db->getCount($query);
	}

	/********************************** list **********************************/
	function getList($db)
	{
		$query  = "SELECT												";
		$query .= "	A.*, B.A_NO, B.A_NAME 								";
		$query .= "FROM ".TBL_BANNER." A 								";
		$query .= "LEFT OUTER JOIN  ".TBL_ADVERTISE." B 				";
		$query .= "ON A.A_NO = B.A_NO									";

		$where  = "";
		if ($this->getSearchStatusY()=="Y" && $this->getSearchStatusN()=="N"){
		} else {
			if($this->getSearchStatusY()=="Y") { $where .= "'Y'"; }
			
			if($this->getSearchStatusN()=="N") :
				$where .= "'N'";
			endif;
		}
		
		if($where) { $where = "AND A.B_VIEW IN ({$where}) "; }

		if($this->getSearchKey()):
			$temp  = mysql_real_escape_string($this->getSearchKey());
			$where .= "AND A.B_TITLE LIKE '{$temp}%%' ";
		endif;

		if($this->getA_NO()):
			$where .= "AND A.A_NO = {$this->getA_NO()} ";
		endif;

		if($where):
			$query .= "WHERE A.B_NO IS NOT NULL " . $where;
		endif;


		/** 2013.04.29 old style 
		if($this->getSearchStatusY()=="Y"){
			$where = "'Y'												";
		}

		if($this->getSearchStatusN()=="N"){
			if ($where) $where .= ",";
			$where .= "'N'												";
		}
		
		if($where){
			$query .= "WHERE A.B_VIEW IN (".$where.")						";
		}

		if($this->getSearchKey()){
			if(!$wh){
				$query .= "WHERE A.B_TITLE LIKE '%".mysql_real_escape_string($this->getSearchKey())."%'	";
			}else{
				$query .= "AND A.B_TITLE LIKE '%".mysql_real_escape_string($this->getSearchKey())."%'		";
			}
		}
		**/

		$query .= "ORDER BY A.B_NO DESC	LIMIT ".$this->getLimitFirst().",".$this->getPageLine();

		return $db->getExecSql($query);
	}

	function getBannerListForAdvertise($db)
	{
		$intA_NO	= $this->getA_NO();
		$intLIMIT	= $this->getPageLine();

		$query = "SELECT * FROM BANNER WHERE A_NO = $intA_NO AND B_VIEW <> 'N' LIMIT $intLIMIT";

		return $db->getExecSql($query);
	}

	/********************************** View **********************************/
	function getView($db)
	{
		$query  = "SELECT															";
		$query .= "	*																";
		$query .= "FROM ".TBL_BANNER."												";
		$query .= "WHERE B_NO=".$this->getB_NO()."									";

		return $db->getSelect($query);
	}

	/********************************** Insert **********************************/
	function getInsert($db)
	{
		$query = "CALL SP_BANNER_I (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getA_NO();
		$param[]  = $this->getB_TITLE();
		$param[]  = $this->getB_VIEW();
		$param[]  = $this->getB_TYPE();
		$param[]  = $this->getB_START_DT();
		$param[]  = $this->getB_END_DT();
		$param[]  = $this->getB_LINK_URL();
		$param[]  = $this->getB_LINK_URL_KR();
		$param[]  = $this->getB_LINK_URL_US();
		$param[]  = $this->getB_LINK_URL_JP();
		$param[]  = $this->getB_LINK_URL_CN();
		$param[]  = $this->getB_LINK_URL_ID();
		$param[]  = $this->getB_LINK_URL_RU();
		$param[]  = $this->getB_LINK_URL_FR();
		$param[]  = $this->getB_LINK_URL_ES();
		$param[]  = $this->getB_LINK_URL_TW();
		$param[]  = $this->getB_LINK_TYPE();
		$param[]  = $this->getB_FILE();
		$param[]  = $this->getB_FILE_KR();
		$param[]  = $this->getB_FILE_US();
		$param[]  = $this->getB_FILE_JP();
		$param[]  = $this->getB_FILE_CN();
		$param[]  = $this->getB_FILE_ID();
		$param[]  = $this->getB_FILE_RU();
		$param[]  = $this->getB_FILE_FR();
		$param[]  = $this->getB_FILE_ES();
		$param[]  = $this->getB_FILE_TW();
		$param[]  = $this->getB_WIDTH();
		$param[]  = $this->getB_HEIGHT();

		return $db->executeBindingQuery($query,$param,true);
	}


	/********************************** update **********************************/
	function getUpdate($db)
	{
		$query = "CALL SP_BANNER_U (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getB_NO();
		$param[]  = $this->getA_NO();
		$param[]  = $this->getB_TITLE();
		$param[]  = $this->getB_VIEW();
		$param[]  = $this->getB_TYPE();
		$param[]  = $this->getB_START_DT();
		$param[]  = $this->getB_END_DT();
		$param[]  = $this->getB_LINK_URL();
		$param[]  = $this->getB_LINK_URL_KR();
		$param[]  = $this->getB_LINK_URL_US();
		$param[]  = $this->getB_LINK_URL_JP();
		$param[]  = $this->getB_LINK_URL_CN();
		$param[]  = $this->getB_LINK_URL_ID();
		$param[]  = $this->getB_LINK_URL_RU();
		$param[]  = $this->getB_LINK_URL_FR();
		$param[]  = $this->getB_LINK_URL_ES();
		$param[]  = $this->getB_LINK_URL_TW();
		$param[]  = $this->getB_LINK_TYPE();
		$param[]  = $this->getB_FILE();
		$param[]  = $this->getB_FILE_KR();
		$param[]  = $this->getB_FILE_US();
		$param[]  = $this->getB_FILE_JP();
		$param[]  = $this->getB_FILE_CN();
		$param[]  = $this->getB_FILE_ID();
		$param[]  = $this->getB_FILE_RU();
		$param[]  = $this->getB_FILE_FR();
		$param[]  = $this->getB_FILE_ES();
		$param[]  = $this->getB_FILE_TW();
		$param[]  = $this->getB_WIDTH();
		$param[]  = $this->getB_HEIGHT();

		return $db->executeBindingQuery($query,$param,true);
	}


	/********************************** delete **********************************/
	function getDelete($db)
	{
		return $db->getDelete(TBL_BANNER," B_NO=".mysql_real_escape_string($this->getB_NO()));
	}






	/********************************** variable **********************************/
	function setB_NO($B_NO){ $this->B_NO = $B_NO; }		
	function getB_NO(){ return $this->B_NO; }	
		
	function setB_TITLE($B_TITLE){ $this->B_TITLE = $B_TITLE; }		
	function getB_TITLE(){ return $this->B_TITLE; }		

	function setB_VIEW($B_VIEW){ $this->B_VIEW = $B_VIEW; }		
	function getB_VIEW(){ return $this->B_VIEW; }		

	function setB_TYPE($B_TYPE){ $this->B_TYPE = $B_TYPE; }		
	function getB_TYPE(){ return $this->B_TYPE; }		

	function setB_START_DT($B_START_DT){ $this->B_START_DT = $B_START_DT; }		
	function getB_START_DT(){ return $this->B_START_DT; }		

	function setB_END_DT($B_END_DT){ $this->B_END_DT = $B_END_DT; }		
	function getB_END_DT(){ return $this->B_END_DT; }		

	function setB_LINK_URL($B_LINK_URL){ $this->B_LINK_URL = $B_LINK_URL; }		
	function getB_LINK_URL(){ return $this->B_LINK_URL; }		

	/** 2013.05.20 다국어 버전 추가 **/
	function setB_LINK_URL_KR($B_LINK_URL_KR){ $this->B_LINK_URL_KR = $B_LINK_URL_KR; }		
	function getB_LINK_URL_KR(){ return $this->B_LINK_URL_KR; }		

	function setB_LINK_URL_US($B_LINK_URL_US){ $this->B_LINK_URL_US = $B_LINK_URL_US; }		
	function getB_LINK_URL_US(){ return $this->B_LINK_URL_US; }		

	function setB_LINK_URL_JP($B_LINK_URL_JP){ $this->B_LINK_URL_JP = $B_LINK_URL_JP; }		
	function getB_LINK_URL_JP(){ return $this->B_LINK_URL_JP; }		

	function setB_LINK_URL_CN($B_LINK_URL_CN){ $this->B_LINK_URL_CN = $B_LINK_URL_CN; }		
	function getB_LINK_URL_CN(){ return $this->B_LINK_URL_CN; }		

	function setB_LINK_URL_ID($B_LINK_URL_ID){ $this->B_LINK_URL_ID = $B_LINK_URL_ID; }		
	function getB_LINK_URL_ID(){ return $this->B_LINK_URL_ID; }		

	function setB_LINK_URL_RU($B_LINK_URL_RU){ $this->B_LINK_URL_RU = $B_LINK_URL_RU; }		
	function getB_LINK_URL_RU(){ return $this->B_LINK_URL_RU; }		

	function setB_LINK_URL_FR($B_LINK_URL_FR){ $this->B_LINK_URL_FR = $B_LINK_URL_FR; }		
	function getB_LINK_URL_FR(){ return $this->B_LINK_URL_FR; }		

	function setB_LINK_URL_ES($B_LINK_URL_ES){ $this->B_LINK_URL_ES = $B_LINK_URL_ES; }		
	function getB_LINK_URL_ES(){ return $this->B_LINK_URL_ES; }		

	function setB_LINK_URL_TW($B_LINK_URL_TW){ $this->B_LINK_URL_TW = $B_LINK_URL_TW; }		
	function getB_LINK_URL_TW(){ return $this->B_LINK_URL_TW; }		
	
	/** 2013.05.20 다국어 버전 추가 **/

	function setB_LINK_TYPE($B_LINK_TYPE){ $this->B_LINK_TYPE = $B_LINK_TYPE; }		
	function getB_LINK_TYPE(){ return $this->B_LINK_TYPE; }		

	function setB_FILE($B_FILE){ $this->B_FILE = $B_FILE; }		
	function getB_FILE(){ return $this->B_FILE; }		

	/** 2013.04.27 다국어 버전 추가 **/
	function setB_FILE_KR($B_FILE_KR){ $this->B_FILE_KR = $B_FILE_KR; }		
	function getB_FILE_KR(){ return $this->B_FILE_KR; }		

	function setB_FILE_US($B_FILE_US){ $this->B_FILE_US = $B_FILE_US; }		
	function getB_FILE_US(){ return $this->B_FILE_US; }		

	function setB_FILE_JP($B_FILE_JP){ $this->B_FILE_JP = $B_FILE_JP; }		
	function getB_FILE_JP(){ return $this->B_FILE_JP; }		

	function setB_FILE_CN($B_FILE_CN){ $this->B_FILE_CN = $B_FILE_CN; }		
	function getB_FILE_CN(){ return $this->B_FILE_CN; }		

	function setB_FILE_ID($B_FILE_ID){ $this->B_FILE_ID = $B_FILE_ID; }		
	function getB_FILE_ID(){ return $this->B_FILE_ID; }		

	function setB_FILE_RU($B_FILE_RU){ $this->B_FILE_RU = $B_FILE_RU; }		
	function getB_FILE_RU(){ return $this->B_FILE_RU; }		

	function setB_FILE_FR($B_FILE_FR){ $this->B_FILE_FR = $B_FILE_FR; }		
	function getB_FILE_FR(){ return $this->B_FILE_FR; }		

	function setB_FILE_ES($B_FILE_ES){ $this->B_FILE_ES = $B_FILE_ES; }		
	function getB_FILE_ES(){ return $this->B_FILE_ES; }		

	function setB_FILE_TW($B_FILE_TW){ $this->B_FILE_TW = $B_FILE_TW; }		
	function getB_FILE_TW(){ return $this->B_FILE_TW; }		
	
	function setB_WIDTH($B_WIDTH){ $this->B_WIDTH = $B_WIDTH; }		
	function getB_WIDTH(){ return $this->B_WIDTH; }		

	function setB_HEIGHT($B_HEIGHT){ $this->B_HEIGHT = $B_HEIGHT; }		
	function getB_HEIGHT(){ return $this->B_HEIGHT; }		

	function setB_REG_DT($B_REG_DT){ $this->B_REG_DT = $B_REG_DT; }		
	function getB_REG_DT(){ return $this->B_REG_DT; }		

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

	function setLng($Lng){ $this->Lng = $Lng; }		
	function getLng(){ return $this->Lng; }	
	/******************************************************************************/
	/* 광고관리 */

	function setA_NO($A_NO){ $this->A_NO = $A_NO; }		
	function getA_NO(){ return $this->A_NO; }		

	function setA_NAME($A_NAME){ $this->A_NAME = $A_NAME; }		
	function getA_NAME(){ return $this->A_NAME; }		

	function setA_TAG($A_TAG){ $this->A_TAG = $A_TAG; }		
	function getA_TAG(){ return $this->A_TAG; }		

	function setA_LOCA($A_LOCA){ $this->A_LOCA = $A_LOCA; }		
	function getA_LOCA(){ return $this->A_LOCA; }		

	function setA_TABLE_W($A_TABLE_W){ $this->A_TABLE_W = $A_TABLE_W; }		
	function getA_TABLE_W(){ return $this->A_TABLE_W; }		

	function setA_TABLE_H($A_TABLE_H){ $this->A_TABLE_H = $A_TABLE_H; }		
	function getA_TABLE_H(){ return $this->A_TABLE_H; }		

	function setA_SIZE_W($A_SIZE_W){ $this->A_SIZE_W = $A_SIZE_W; }		
	function getA_SIZE_W(){ return $this->A_SIZE_W; }		

	function setA_SIZE_H($A_SIZE_H){ $this->A_SIZE_H = $A_SIZE_H; }		
	function getA_SIZE_H(){ return $this->A_SIZE_H; }		

	function setA_MARGIN_W($A_MARGIN_W){ $this->A_MARGIN_W = $A_MARGIN_W; }		
	function getA_MARGIN_W(){ return $this->A_MARGIN_W; }		

	function setA_MARGIN_H($A_MARGIN_H){ $this->A_MARGIN_H = $A_MARGIN_H; }		
	function getA_MARGIN_H(){ return $this->A_MARGIN_H; }	

	function setA_USE($A_USE){ $this->A_USE = $A_USE; }		
	function getA_USE(){ return $this->A_USE; }		

	function setA_REG_DT($A_REG_DT){ $this->A_REG_DT = $A_REG_DT; }		
	function getA_REG_DT(){ return $this->A_REG_DT; }		

	function setA_REG_NO($A_REG_NO){ $this->A_REG_NO = $A_REG_NO; }		
	function getA_REG_NO(){ return $this->A_REG_NO; }		

	function setA_MOD_DT($A_MOD_DT){ $this->A_MOD_DT = $A_MOD_DT; }		
	function getA_MOD_DT(){ return $this->A_MOD_DT; }		

	function setA_MOD_NO($A_MOD_NO){ $this->A_MOD_NO = $A_MOD_NO; }		
	function getA_MOD_NO(){ return $this->A_MOD_NO; }	
/********************************** variable **********************************/

}
?>