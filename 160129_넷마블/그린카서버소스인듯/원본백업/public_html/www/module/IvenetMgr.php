<?
#/*====================================================================*/# 
#|화일명	: 일정관리													|# 
#|작성자	: 박영미													|# 
#|작성일	: 2013-03-19												|# 
#|작성내용	: 															|# 
#/*====================================================================*/# 

class IvenetMgr
{
	private $query;
	private $columnField;
	private $columnData;
	private $insert_id;


	/********************************** List **********************************/
	function getCalList($db){
		$query  = "SELECT                                          ";
		$query .= "     A.*                                        ";
		$query .= "    ,B.AD_TEMP1                                 ";
		$query .= "    ,B.AD_TEMP2                                 ";
		$query .= "    ,B.AD_TEMP3                                 ";
		$query .= "    ,B.AD_TEMP4                                 ";
		$query .= "FROM BOARD_UB_CLASS A                           ";
		$query .= "JOIN BOARD_AD_CLASS B                           ";
		$query .= "ON A.UB_NO = B.AD_UB_NO                         ";
		$query .= "WHERE SUBSTRING(B.AD_TEMP2,1,7) = '".$this->getSearchDate()."'	";
		
		return $db->getArrayTotal($query);
	}
	

	function getOrderMyList($db)
	{
		$query  = "SELECT								";
		$query .= "    A.*								";
		$query .= "   ,B.M_ID							";
		$query .= "   ,(SELECT SUM(OC_QTY) FROM ".TBL_ORDER_CART." WHERE O_NO = A.O_NO) O_PROD_QTY ";
		$query .= "FROM ".TBL_ORDER_MGR." A				";
		$query .= "LEFT OUTER JOIN ".TBL_MEMBER_MGR." B	";
		$query .= "ON A.M_NO = B.M_NO					";
		$query .= "WHERE A.O_NO IS NOT NULL				";
		$query .= "	AND A.O_STATUS NOT IN ('F','W')		";

		if ($this->getM_NO()){
			$query .= " AND A.M_NO = ".$this->getM_NO();
		}
	
		$query .= "	ORDER BY A.O_NO DESC LIMIT 0,5		";
		return $db->getArrayTotal($query);
	}
	
	function getReqMyList($db)
	{
		$query  = "SELECT						";
		$query .= "    A.*						";
		$query .= "FROM BOARD_UB_MY_QNA A		";
		$query .= "WHERE A.UB_NO IS NOT NULL	";	
		$query .= " AND IFNULL(A.UB_ANS_STEP,0) = 0 ";
		
		if ($this->getM_NO()){
			$query .= " AND A.UB_M_NO = ".$this->getM_NO();
		}
		
		$query .= " ORDER BY A.UB_NO DESC  LIMIT 0,5  ";
		return $db->getArrayTotal($query);

	}
	/********************************** variable **********************************/
	function setSearchDate($SEARCH_DATE){ $this->SEARCH_DATE = $SEARCH_DATE; }		
	function getSearchDate(){ return $this->SEARCH_DATE; }		

	function setM_NO($M_NO){ $this->M_NO = $M_NO; }		
	function getM_NO(){ return $this->M_NO; }		
	/********************************** variable **********************************/


}
?>