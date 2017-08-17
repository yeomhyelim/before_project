<?
#/*====================================================================*/# 
#|작성자	: 박영미(ivetmi@naver.com)									|# 
#|작성일	: 2014-01-08												|# 
#|작성내용	: 주문관리													|# 
#/*====================================================================*/# 
class OrderMgr
{
	
	/********************************** Order Mgr View **********************************/
	function getOrderView($db, $param)
	{
		$query  = "SELECT A.*,B.M_GROUP						";
		$query .= "FROM ".TBL_ORDER_MGR." A					";
		$query .= "LEFT OUTER JOIN ".TBL_MEMBER_MGR." B		";
		$query .= "ON A.M_NO = B.M_NO						";
		$query .= "WHERE A.O_NO=".$param["O_NO"];
		
		return $db->getSelect($query);
	}	
}
?>