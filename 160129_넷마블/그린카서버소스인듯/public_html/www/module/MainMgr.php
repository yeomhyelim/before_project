<?
#/*====================================================================*/# 
#|작성자	: 박영미(ivetmi@naver.com)									|# 
#|작성일	: 2013-04-05												|# 
#|작성내용	: 메인관리													|# 
#/*====================================================================*/# 
class MainMgr
{
	private $query;
	private $param;
	
	/********************************** Product List **********************************/
	function getProdInfo($db){

		$query  = "SELECT									";
		$query .= "     A.*									";
		$query .= "    ,SUBSTRING(A.P_ICON,1,1) ICON1		";
		$query .= "    ,SUBSTRING(A.P_ICON,3,1) ICON2		";
		$query .= "    ,SUBSTRING(A.P_ICON,5,1) ICON3		";
		$query .= "    ,SUBSTRING(A.P_ICON,7,1) ICON4		";
		$query .= "    ,SUBSTRING(A.P_ICON,9,1) ICON5		";
		$query .= "    ,SUBSTRING(A.P_ICON,11,1) ICON6		";
		$query .= "    ,SUBSTRING(A.P_ICON,13,1) ICON7		";
		$query .= "    ,SUBSTRING(A.P_ICON,15,1) ICON8		";
		$query .= "    ,SUBSTRING(A.P_ICON,17,1) ICON9		";
		$query .= "    ,SUBSTRING(A.P_ICON,19,1) ICON10		";		
		$query .= "    ,C.PM_REAL_NAME						";
		$query .= "FROM ".TBL_PRODUCT_MGR." A               ";
		$query .= "LEFT OUTER JOIN ".TBL_PRODUCT_IMG." C    ";
		$query .= "ON A.P_CODE = C.P_CODE					";
		$query .= "AND C.PM_TYPE = 'list'					";
		
		if ($this->getP_CODE()) {
			$query .= "WHERE A.P_CODE = '".$this->getP_CODE()."'		";
		} else {
			if ($this->getP_CODE_ALL()){
				$query .= "WHERE A.P_CODE IN (".$this->getP_CODE_ALL().")	";
			}
		}
		return $db->getExecSql($query);
	}
	
	/********************************** Member List **********************************/
	function getMemberFamilyList($db)
	{
		$query  = "SELECT *									";
		$query .= "FROM ".TBL_MEMBER_FAMILY." A				";
		$query .= "WHERE A.M_NO = '".$this->getM_NO()."'	";
		$query .= "ORDER BY A.MF_NO ASC						";

		return $db->getArrayTotal($query);
	}

	/********************************** variable **********************************/
	function setP_CODE($P_CODE){ $this->P_CODE = $P_CODE; }		
	function getP_CODE(){ return $this->P_CODE; }		

	function setP_CODE_ALL($P_CODE_ALL){ $this->P_CODE_ALL = $P_CODE_ALL; }		
	function getP_CODE_ALL(){ return $this->P_CODE_ALL; }	

	function setM_NO($M_NO){ $this->M_NO = $M_NO; }		
	function getM_NO(){ return $this->M_NO; }	
	/********************************** variable **********************************/


}
?>