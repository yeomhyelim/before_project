<?
#/*====================================================================*/# 
#|작성자	: 박영미(ivetmi@naver.com)									|# 
#|작성일	: 2012-06-14												|# 
#|작성내용	: 주문관리													|# 
#/*====================================================================*/# 
class OrderMgr
{
	
	/********************************** Order List **********************************/
	function getOrderTotal($db)
	{
		$query  = "SELECT								";
		$query .= "    COUNT(*)							";
		$query .= "FROM ".TBL_ORDER_MGR." A				";
		$query .= "LEFT OUTER JOIN ".TBL_MEMBER_MGR." B	";
		$query .= "ON A.M_NO = B.M_NO					";
		$query .= "WHERE A.O_NO IS NOT NULL				";
		$query .= "	AND A.O_STATUS NOT IN ('F','W')		";
		
		$query .= $this->getSearchQry("orderList");
		return $db->getCount($query);
	}

	function getOrderList($db)
	{
		$query  = "SELECT								";
		$query .= "    A.*								";
		$query .= "   ,B.M_ID							";
		$query .= "FROM ".TBL_ORDER_MGR." A				";
		$query .= "LEFT OUTER JOIN ".TBL_MEMBER_MGR." B	";
		$query .= "ON A.M_NO = B.M_NO					";
		$query .= "WHERE A.O_NO IS NOT NULL				";
		$query .= "	AND A.O_STATUS NOT IN ('F','W')		";
		$query .= $this->getSearchQry("orderList");

		$query .= "	ORDER BY A.O_NO DESC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();
		return $db->getExecSql($query);
	}

	function getSearchQry($mode)
	{
		$query = "";
		switch ($mode){
			case "orderList":

				if($this->getO_SELF_WRITE()):
					$query .= " AND A.O_SELF_WRITE = '".$this->getO_SELF_WRITE()."' ";
				endif;
				
				if ($this->getSearchOrderKey() && $this->getSearchOrderName()){
					$query .= " AND A.O_KEY		= '".$this->getSearchOrderKey()."'	";
					$query .= " AND A.O_J_NAME	= '".$this->getSearchOrderName()."'	";
				}
				
				if ($this->getM_NO()){
					$query .= " AND A.M_NO = ".$this->getM_NO();
				}

				if ($this->getSearchOrderStatus()){
					if ($this->getSearchOrderStatus() == "J") {
						$query .= "	AND A.O_STATUS IN ('J','O')";
					} else if ($this->getSearchOrderStatus() == "A"){
						$query .= "	AND A.O_STATUS IN ('A','B')";
					} else if ($this->getSearchOrderStatus() == "I"){
						$query .= "	AND A.O_STATUS IN ('I')";
					} else if ($this->getSearchOrderStatus() == "D"){
						$query .= "	AND A.O_STATUS IN ('D')";
					} else if ($this->getSearchOrderStatus() == "R"){
						$query .= "	AND A.O_STATUS IN ('C','P','R','T')";
					} else if ($this->getSearchOrderStatus() == "E"){
						$query .= "	AND A.O_STATUS IN ('E')";
					} else if ($this->getSearchOrderStatus() == "UI"){
						$query .= "	AND A.O_STATUS IN ('B','I','D')";
					} else if ($this->getSearchOrderStatus() == "B"){
						$query .= "	AND A.O_STATUS IN ('B')";
					} 
				}
				
				if ($this->getSearchSettleType()) :
					// 결제방법
					$query .= "	AND A.O_SETTLE IN ('{$this->getSearchSettleType()}')";
				endif;

				if($this->getSearchMemberType()) :
					// 회원구분
					if($this->getSearchMemberType() == "member"):
						// 회원
						$query .= "	AND A.M_NO > 0";
					elseif($this->getSearchMemberType() == "nonmember"):
						// 비회원
						$query .= "	AND IFNULL(A.M_NO,0) = 0";
					endif;
				endif;

				if ($this->getSearchField() && $this->getSearchKey()){
					$query .= "	AND ";
					switch ($this->getSearchField()){
						case "K":
							$query .= "	A.O_KEY LIKE '%".$this->getSearchKey()."%'		";
						break;
						case "J":
							$query .= "	A.O_J_NAME LIKE '%".$this->getSearchKey()."%'			";
						break;
						case "M":
							$query .= "	B.M_ID LIKE '%".$this->getSearchKey()."%'		";
						break;
						case "B":
							$query .= "	A.O_B_NAME LIKE '%".$this->getSearchKey()."%'		";
						break;
					}
				}
				
				if ($this->getSearchRegStartDt() && $this->getSearchRegEndDt()){
					$query .= "	AND A.O_REG_DT BETWEEN DATE_FORMAT('".mysql_real_escape_string($this->getSearchRegStartDt())."','%Y-%m-%d 00:00:00') ";
					$query .= "	AND DATE_FORMAT('".mysql_real_escape_string($this->getSearchRegEndDt())."','%Y-%m-%d 23:59:59') ";		
				}

				if ($this->getSearchSettleC() || $this->getSearchSettleA() || $this->getSearchSettleT() || $this->getSearchSettleB()){
					
					$strSearchSettle = "";
					if ($this->getSearchSettleC() == "Y") $strSearchSettle .= "'C',";
					if ($this->getSearchSettleA() == "Y") $strSearchSettle .= "'A',";
					if ($this->getSearchSettleT() == "Y") $strSearchSettle .= "'T',";
					if ($this->getSearchSettleB() == "Y") $strSearchSettle .= "'B',";
					
					if ($strSearchSettle){
						$query .= " AND A.O_SETTLE IN (".SUBSTR($strSearchSettle,0,STRLEN($strSearchSettle)-1).")";
					}
				}
			break;
		}

		return $query;
	}
	

	/********************************** Order Cart List **********************************/
	function getOrderShopList($db)
	{
		$query  = "SELECT						";
		$query .= "    A.*						";
		$query .= "	  ,D.SH_COM_NAME			";
		$query .= "FROM ".TBL_SHOP_ORDER." A    ";
		$query .= "JOIN ".TBL_SHOP_MGR." D      ";
		$query .= "ON A.SH_NO = D.SH_NO			";
		$query .= "WHERE A.O_NO IS NOT NULL		";
		
		if ($this->getO_NO())
		{
			$query .= "	AND A.O_NO = ".$this->getO_NO()."	";			
		}
		$query .= " ORDER BY A.SO_NO DESC		";
		
		return $db->getArrayTotal($query);
	}

	function getOrderCartTotal($db)
	{
		$query  = "SELECT														";
		$query .= "    COUNT(*)													";
		$query .= "FROM ".TBL_ORDER_CART." A									";
		$query .= "JOIN ".TBL_PRODUCT_MGR." B									";
		$query .= "ON A.P_CODE = B.P_CODE										";
		$query .= "WHERE A.OC_NO IS NOT NULL									";

		if ($this->getO_NO())
		{
			$query .= "	AND A.O_NO = ".$this->getO_NO()."						";			
		}
		return $db->getCount($query);
	}

	function getOrderCartList($db)
	{
		$query  = "SELECT														";
		$query .= "      A.*													";
		$query .= "		,B.P_NAME												";
		$query .= "     ,C.PM_REAL_NAME											";
		$query .= "		,B.P_STOCK_LIMIT										";
		$query .= "		,B.P_STOCK_OUT											";
		$query .= "		,B.P_EVENT_UNIT											";
		$query .= "		,B.P_EVENT												";
		$query .= "		,B.P_SHOP_NO											";
		$query .= "FROM ".TBL_ORDER_CART." A									";
		$query .= "JOIN ".TBL_PRODUCT_MGR." B									";
		$query .= "ON A.P_CODE = B.P_CODE										";
		$query .= "LEFT OUTER JOIN ".TBL_PRODUCT_IMG." C						";
		$query .= "ON A.P_CODE = C.P_CODE										";
		$query .= "AND C.PM_TYPE = 'list'										";
		$query .= "WHERE A.OC_NO IS NOT NULL									";
		$query .= "	AND B.P_SHOP_NO = ".$this->getSH_NO()."						";

		/*if ($this->getM_NO()){
			$query .= "	AND A.M_NO = ".$this->getM_NO()."						";
		}*/


		if ($this->getO_NO())
		{
			$query .= "	AND A.O_NO = ".$this->getO_NO()."						";			
		}

		if ($this->getOC_LIST_ARY() == "Y"){
			$query .= "ORDER BY A.OC_NO DESC ";	
			return $db->getArrayTotal($query);
		} else {
			$query .= "ORDER BY A.OC_NO DESC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();	
			return $db->getExecSql($query);
		}
	}

	function getOrderCartAddList($db)
	{
		$query  = "SELECT									";
		$query .= "     A.*									";
		$query .= "FROM ".TBL_ORDER_CART_ADD." A			";
		$query .= "WHERE A.OC_NO = ".$this->getOC_NO()."	";
		$query .= "ORDER BY A.OCA_NO DESC					";

		return $db->getArrayTotal($query);
	}


	/********************************** Order Cart View **********************************/
	function getOrderBasketView($db)
	{
		$query  = "SELECT														";
		$query .= "      A.*													";
		$query .= "     ,B.P_OPT												";
		$query .= "     ,B.P_ADD_OPT											";
		$query .= "     ,B.P_QTY												";
		$query .= "     ,B.P_STOCK_OUT											";
		$query .= "     ,B.P_MIN_QTY											";
		$query .= "     ,B.P_MAX_QTY											";
		$query .= "     ,B.P_SALE_PRICE											";
		$query .= "     ,B.P_POINT												";
		$query .= "     ,B.P_POINT_TYPE											";
		$query .= "     ,B.P_POINT_OFF1											";
		$query .= "     ,B.P_POINT_OFF2											";
		$query .= "     ,B.P_NAME												";
		$query .= "     ,B.P_BAESONG_TYPE										";
		$query .= "     ,B.P_BAESONG_PRICE										";
		$query .= "     ,B.P_STOCK_LIMIT										";
		$query .= "     ,B.P_EVENT_UNIT											";
		$query .= "     ,B.P_EVENT												";
		$query .= "     ,B.P_CATE												";
		$query .= "FROM ".TBL_PRODUCT_BASKET." A								";
		$query .= "JOIN ".TBL_PRODUCT_MGR." B									";
		$query .= "ON A.P_CODE = B.P_CODE										";
		$query .= "WHERE A.PB_NO = ".$this->getPB_NO();	

		return $db->getSelect($query);
	}
		
	function getOrderCartView($db)
	{
		$query  = "SELECT														";
		$query .= "      A.*													";
		$query .= "     ,B.P_OPT												";
		$query .= "     ,B.P_ADD_OPT											";
		$query .= "     ,B.P_QTY												";
		$query .= "     ,B.P_STOCK_OUT											";
		$query .= "     ,B.P_MIN_QTY											";
		$query .= "     ,B.P_MAX_QTY											";
		$query .= "     ,B.P_EVENT_UNIT											";
		$query .= "     ,B.P_EVENT												";
		$query .= "FROM ".TBL_ORDER_CART." A									";
		$query .= "JOIN ".TBL_PRODUCT_MGR." B									";
		$query .= "ON A.P_CODE = B.P_CODE										";
		$query .= "WHERE A.OC_NO = ".$this->getOC_NO();	

		return $db->getSelect($query);
	}
	
	/********************************** Order Mgr View **********************************/
	function getOrderView($db)
	{
		$query = "SELECT A.* FROM ".TBL_ORDER_MGR." A WHERE A.O_NO=".$this->getO_NO();
		return $db->getSelect($query);
	}

	/********************************** Order Mgr Insert **********************************/
	function getOrderKey($db)
	{
		$query  = "SELECT                                                       ";
		$query .= "       LPAD(IFNULL(MAX(SUBSTRING(A.O_KEY,14))+1,1),5,0)		";
		$query .= "FROM ".TBL_ORDER_MGR." A                                     ";
		$query .= "WHERE SUBSTRING(A.O_KEY,1,8) = DATE_FORMAT(NOW(),'%Y%m%d');	";
		
		return $db->getCount($query);
	}

	function getOrderDupKey($db)
	{
		$query  = "SELECT               ";
		$query .= "       COUNT(*)		";
		$query .= "FROM ".TBL_ORDER_MGR." A                 ";
		$query .= "WHERE A.O_KEY = '".$this->getO_KEY()."'	";
		
		return $db->getCount($query);
	}
	
	function getOrderNo($db)
	{
		$query  = "SELECT               ";
		$query .= "       O_NO			";
		$query .= "FROM ".TBL_ORDER_MGR." A                 ";
		
		if ($this->getO_APPR_NO()){
			$query .= "WHERE A.O_APPR_NO = '".$this->getO_APPR_NO()."'	";
		} else if ($this->getO_PAYPAL_RECEIVER_ID()){ 
			$query .= "WHERE A.O_PAYPAL_RECEIVER_ID = '".$this->getO_PAYPAL_RECEIVER_ID()."'	";
		} else {
			$query .= "WHERE A.O_KEY = '".$this->getO_KEY()."'	";
		}
		
		return $db->getCount($query);
	}

	function getOrderDupNo($db)
	{
		$query  = "SELECT               ";
		$query .= "       COUNT(*)		";
		$query .= "FROM ".TBL_ORDER_MGR." A                 ";
		$query .= "WHERE A.O_KEY = '".$this->getO_KEY()."'	";
		$query .= "	AND A.O_STATUS = 'W'	";
		
		return $db->getCount($query);
	}
	
	function getOrderInsert($db)
	{
		$query = "CALL SP_ORDER_MGR_I (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getO_KEY();
		$param[]  = $this->getM_NO();
		$param[]  = $this->getO_J_TITLE();
		$param[]  = $this->getO_J_NAME();
		$param[]  = $this->getO_J_PHONE();
		$param[]  = $this->getO_J_HP();
		$param[]  = $this->getO_J_MAIL();
		$param[]  = $this->getO_B_NAME();
		$param[]  = $this->getO_B_PHONE();
		$param[]  = $this->getO_B_HP();
		$param[]  = $this->getO_B_MAIL();
		$param[]  = $this->getO_B_ZIP();
		$param[]  = $this->getO_B_COUNTRY();
		$param[]  = $this->getO_B_ADDR1();
		$param[]  = $this->getO_B_ADDR2();
		$param[]  = $this->getO_B_CITY();
		$param[]  = $this->getO_B_STATE();		
		$param[]  = $this->getO_B_MEMO();
		$param[]  = $this->getO_SETTLE();
		$param[]  = $this->getO_PG();
		$param[]  = $this->getO_BANK_NAME();
		$param[]  = $this->getO_BANK();
		$param[]  = $this->getO_BANK_ACC();
		$param[]  = $this->getO_USE_POINT();
		$param[]  = $this->getO_USE_CUR_POINT();
		$param[]  = $this->getO_USE_COUPON_NUM();
		$param[]  = $this->getO_USE_COUPON();
		$param[]  = $this->getO_USE_CUR_COUPON();
		$param[]  = $this->getO_TOT_QTY();
		$param[]  = $this->getO_TOT_PRICE();
		$param[]  = $this->getO_TOT_CUR_PRICE();
		$param[]  = $this->getO_TOT_DELIVERY_PRICE();
		$param[]  = $this->getO_TOT_DELIVERY_CUR_PRICE();
		$param[]  = $this->getO_TAX_PRICE();
		$param[]  = $this->getO_TAX_CUR_PRICE();
		$param[]  = $this->getO_TOT_MEM_DISCOUNT_PRICE();
		$param[]  = $this->getO_TOT_MEM_DISCOUNT_CUR_PRICE();
		$param[]  = $this->getO_TOT_SPRICE();
		$param[]  = $this->getO_TOT_CUR_SPRICE();
		$param[]  = $this->getO_TOT_MEM_POINT();
		$param[]  = $this->getO_TOT_MEM_CUR_POINT();
		$param[]  = $this->getO_TOT_POINT();
		$param[]  = $this->getO_TOT_CUR_POINT();
		$param[]  = $this->getO_USE_LNG();
		$param[]  = $this->getO_USE_CUR();
		$param[]  = $this->getO_USE_CUR_RATE();
		$param[]  = $this->getO_CASH_YN();
		$param[]  = $this->getO_CASH_AUTH_NO();
		$param[]  = $this->getO_CASH_INFO();
		return $db->executeBindingQuery($query,$param,true);
	}

	function getOrderApprNo($db)
	{
		$query  = "SELECT															";
		$query .= "       LPAD(IFNULL(MAX(SUBSTRING(A.OS_APPR_NO,10))+1,1),5,0)		";
		$query .= "FROM ".TBL_ORDER_SETTLE." A										";
		$query .= "WHERE SUBSTRING(A.OS_APPR_NO,2,9) = DATE_FORMAT(NOW(),'%Y%m%d')	";
		$query .= "	AND A.OS_STATUS = '".$this->getOS_STATUS()."'					";
		return $db->getCount($query);
	}

	function getOrderDupApprNo($db)
	{
		$query  = "SELECT															";
		$query .= "       COUNT(*)													";
		$query .= "FROM ".TBL_ORDER_SETTLE." A										";
		$query .= "WHERE A.OS_APPR_NO = '".$this->getOS_APPR_NO()."'				";
		return $db->getCount($query);
	}
	
	function getOrderCancelNo($db)
	{
		$query  = "SELECT															";
		$query .= "       LPAD(IFNULL(MAX(SUBSTRING(A.O_CEL_NO,10))+1,1),5,0)		";
		$query .= "FROM ".TBL_ORDER_MGR." A											";
		$query .= "WHERE SUBSTRING(A.O_CEL_NO,2,9) = DATE_FORMAT(NOW(),'%Y%m%d')	";
		return $db->getCount($query);
	}

	function getOrderDupCancelNo($db)
	{
		$query  = "SELECT															";
		$query .= "       COUNT(*)													";
		$query .= "FROM ".TBL_ORDER_MGR." A											";
		$query .= "WHERE A.O_CEL_NO = '".$this->getO_CEL_NO()."'					";
		return $db->getCount($query);
	}

	function getOrderSettleInsert($db)
	{
		$query = "CALL SP_ORDER_SETTLE_I (?,?,?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getO_NO();
		$param[]  = $this->getM_NO();
		$param[]  = $this->getOS_TITLE();
		$param[]  = $this->getOS_USE_POINT();
		$param[]  = $this->getOS_USE_COUPON();
		$param[]  = $this->getOS_TOT_PRICE();
		$param[]  = $this->getOS_TOT_DELIVERY_PRICE();
		$param[]  = $this->getOS_TOT_TAX_PRICE();
		$param[]  = $this->getOS_TOT_SPRICE();
		$param[]  = $this->getOS_TOT_POINT();
		$param[]  = $this->getOS_STATUS();
		$param[]  = $this->getOS_SETTLE();
		$param[]  = $this->getOS_APPR_NO();

		return $db->executeBindingQuery($query,$param,true);
	}

	/********************************** Order Mgr Modify **********************************/
	function getOrderStatusUpdate($db)
	{
		$query  = "UPDATE ".TBL_ORDER_MGR." SET O_STATUS = '".$this->getO_STATUS()."'";
		$query .= "	WHERE O_NO = ".$this->getO_NO();
		return $db->getExecSql($query);
	}

	//은행,계좌번호 UPDATE
	function getOrderInputUpdate($db)
	{
		$query  = "UPDATE ".TBL_ORDER_MGR." SET O_BANK = '".$this->getO_BANK()."'";
		$query .= "	,O_BANK_ACC			= '".$this->getO_BANK_ACC()."'";
		$query .= "	,O_BANK_NAME		= '".$this->getO_BANK_NAME()."'";
		$query .= "	,O_BANK_VALID_DT	= '".$this->getO_BANK_VALID_DT()."'";
		$query .= "	WHERE O_NO = ".$this->getO_NO();
		return $db->getExecSql($query);
	}
	
	//승인번호 UPDATE
	function getOrderApprNoUpdate($db)
	{
		$query  = "UPDATE ".TBL_ORDER_MGR." SET O_APPR_NO = '".$this->getO_APPR_NO()."'";
		$query .= "	WHERE O_NO = ".$this->getO_NO();
		return $db->getExecSql($query);		
	}

	//에스크로여부 UPDATE
	function getOrderEscrowUpdate($db)
	{
		$query  = "UPDATE ".TBL_ORDER_MGR." SET O_ESCROW = '".$this->getO_ESCROW()."'";
		$query .= "	WHERE O_NO = ".$this->getO_NO();
		return $db->getExecSql($query);		
	}

	//주문취소 UPDATE
	function getOrderCancelUpdate($db)
	{
		$query  = "UPDATE ".TBL_ORDER_MGR." SET O_CEL_NO = '".$this->getO_CEL_NO()."'";
		$query .= "	,O_CEL_REQ_DT			= NOW() ";
		$query .= "	,O_CEL_REG_DT			= NOW() ";
		$query .= "	,O_STATUS			    = '".$this->getO_STATUS()."'";
		$query .= "	,O_CEL_MEMO			    = '".$this->getO_CEL_MEMO()."'";
		$query .= "	,O_RETURN_BANK			= '".$this->getO_RETURN_BANK()."'";
		$query .= "	,O_RETURN_ACC			= '".$this->getO_RETURN_ACC()."'";
		$query .= "	,O_RETURN_NAME			= '".$this->getO_RETURN_NAME()."'";
		$query .= "	,O_CEL_STATUS			= '".$this->getO_CEL_STATUS()."'";
		$query .= "	WHERE O_NO = ".$this->getO_NO();
		return $db->getExecSql($query);		
	}

	//구매취소시 환불계좌 통보시 UPDATE(2012.08.10)
	function getOrderCancelReturnUpdate($db)
	{
		$query  = "UPDATE ".TBL_ORDER_MGR." SET ";
		$query .= "	 O_STATUS			    = '".$this->getO_STATUS()."'";
		$query .= "	,O_RETURN_BANK			= '".$this->getO_RETURN_BANK()."'";
		$query .= "	,O_RETURN_ACC			= '".$this->getO_RETURN_ACC()."'";
		$query .= "	,O_RETURN_NAME			= '".$this->getO_RETURN_NAME()."'";
		$query .= "	,O_CEL_STATUS			= '".$this->getO_CEL_STATUS()."'";
		$query .= "	WHERE O_NO = ".$this->getO_NO();
		return $db->getExecSql($query);		
	}

	//배송정보 UPDATE
	function getOrderDeliveryUpdate($db)
	{
		$query  = "UPDATE ".TBL_ORDER_MGR." SET O_DELIVERY_COM = '".$this->getO_DELIVERY_COM()."'";
		$query .= "	,O_DELIVERY_NUM			    = '".$this->getO_DELIVERY_NUM()."'";
		$query .= " ,O_STATUS = 'I' ";
		$query .= "	WHERE O_NO = ".$this->getO_NO();
		return $db->getExecSql($query);		
	}

	//주문 적립포인트 지급 유무 UPDATE(취소시 적립된 포인트를 다시 가지고 올때 기본설정이 변경이 되면 다시 못가지고 올 수 있으므로..)
	function getOrderAddPointUpdate($db)
	{
		$query  = "UPDATE ".TBL_ORDER_MGR." SET O_ADD_POINT = '".$this->getO_ADD_POINT()."'";
		$query .= "	WHERE O_NO = ".$this->getO_NO();
		return $db->getExecSql($query);		
	}

	//주문취소시 결제관리테이블 UPDATE
	function getOrderSettleUpdate($db)
	{
		$query = "CALL SP_ORDER_SETTLE_U (?,?,?);";

		$param[]  = $this->getO_NO();
		$param[]  = $this->getOS_APPR_NO();
		$param[]  = $this->getOS_CEL_NO();

		return $db->executeBindingQuery($query,$param,true);
	}

	//주문취소시 주문취소상태 'Y'로 변경
	function getOrderCancelStatusUpdate($db)
	{
		$query  = "UPDATE ".TBL_ORDER_MGR." SET O_CEL_STATUS = '".$this->getO_CEL_STATUS()."'";
		$query .= "	WHERE O_NO = ".$this->getO_NO();
		return $db->getExecSql($query);		
	}


	/********************************** Order Cart Insert Or Update **********************************/
	function getOrderCartInsertPro($db)
	{
		$query = "CALL SP_ORDER_CART_I (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getOC_NO();
		$param[]  = $this->getO_NO();
		$param[]  = $this->getP_CODE();
		$param[]  = $this->getOC_OPT_NO();
		$param[]  = $this->getOC_OPT_NM1();
		$param[]  = $this->getOC_OPT_NM2();
		$param[]  = $this->getOC_OPT_NM3();
		$param[]  = $this->getOC_OPT_NM4();	
		$param[]  = $this->getOC_OPT_NM5();
		$param[]  = $this->getOC_OPT_NM6();
		$param[]  = $this->getOC_OPT_NM7();
		$param[]  = $this->getOC_OPT_NM8();
		$param[]  = $this->getOC_OPT_NM9();
		$param[]  = $this->getOC_OPT_NM10();
		$param[]  = $this->getOC_OPT_ATTR1();
		$param[]  = $this->getOC_OPT_ATTR2();
		$param[]  = $this->getOC_OPT_ATTR3();
		$param[]  = $this->getOC_OPT_ATTR4();
		$param[]  = $this->getOC_OPT_ATTR5();
		$param[]  = $this->getOC_OPT_ATTR6();
		$param[]  = $this->getOC_OPT_ATTR7();
		$param[]  = $this->getOC_OPT_ATTR8();
		$param[]  = $this->getOC_OPT_ATTR9();
		$param[]  = $this->getOC_OPT_ATTR10();
		$param[]  = $this->getOC_QTY();
		$param[]  = $this->getOC_PRICE();
		$param[]  = $this->getOC_CUR_PRICE();
		$param[]  = $this->getOC_POINT();
		$param[]  = $this->getOC_CUR_POINT();
		$param[]  = $this->getOC_DELIVERY_TYPE();
		$param[]  = $this->getOC_DELIVERY_PRICE();
		$param[]  = $this->getOC_DELIVERY_CUR_PRICE();
		$param[]  = $this->getOC_DELIVERY_EXP();
		$param[]  = $this->getOC_OPT_ADD_PRICE();
		$param[]  = $this->getOC_OPT_ADD_CUR_PRICE();
		$param[]  = $this->getOC_REG_DT();

		return $db->executeBindingQuery($query,$param,true);
	}

	function getOrderCartInsert($db)
	{
		$query  = "INSERT INTO ".TBL_ORDER_CART."                    ";
		$query .= "SELECT                                            ";
		$query .= "    ''                                            ";		
		$query .= "    ,".$this->getO_NO();
		$query .= "    ,P_CODE                                       ";
		$query .= "    ,PB_OPT_NO                                    ";
		$query .= "    ,PB_OPT_NM1                                   ";
		$query .= "    ,PB_OPT_NM2                                   ";
		$query .= "    ,PB_OPT_NM3                                   ";
		$query .= "    ,PB_OPT_NM4                                   ";
		$query .= "    ,PB_OPT_NM5                                   ";
		$query .= "    ,PB_OPT_NM6                                   ";
		$query .= "    ,PB_OPT_NM7                                   ";
		$query .= "    ,PB_OPT_NM8                                   ";
		$query .= "    ,PB_OPT_NM9                                   ";
		$query .= "    ,PB_OPT_NM10                                  ";
		$query .= "    ,PB_OPT_ATTR1                                 ";
		$query .= "    ,PB_OPT_ATTR2                                 ";
		$query .= "    ,PB_OPT_ATTR3                                 ";
		$query .= "    ,PB_OPT_ATTR4                                 ";
		$query .= "    ,PB_OPT_ATTR5                                 ";
		$query .= "    ,PB_OPT_ATTR6                                 ";
		$query .= "    ,PB_OPT_ATTR7                                 ";
		$query .= "    ,PB_OPT_ATTR8                                 ";
		$query .= "    ,PB_OPT_ATTR9                                 ";
		$query .= "    ,PB_OPT_ATTR10                                ";
		$query .= "    ,PB_QTY                                       ";
		$query .= "    ,TRUNCATE(CEILING(PB_PRICE*".$this->getO_USE_CUR_RATE()."*100)/100,2)			";
		$query .= "    ,PB_PRICE                                     ";
		$query .= "    ,TRUNCATE(CEILING(PB_POINT*".$this->getO_USE_CUR_RATE()."*100)/100,2)			";
		$query .= "    ,PB_POINT                                     ";
		$query .= "    ,PB_DELIVERY_TYPE							 ";
		$query .= "    ,TRUNCATE(CEILING(PB_DELIVERY_PRICE*".$this->getO_USE_CUR_RATE()."*100)/100,2)   ";
		$query .= "    ,PB_DELIVERY_PRICE							 ";
		$query .= "    ,PB_DELIVERY_EXP								 ";
		$query .= "    ,PB_ADD_OPT_PRICE                             ";
		$query .= "    ,TRUNCATE(CEILING(PB_ADD_OPT_PRICE*".$this->getO_USE_CUR_RATE()."*100)/100,2)	";
		$query .= "    ,NOW()                                        ";
		$query .= "FROM ".TBL_PRODUCT_BASKET."                       ";
		$query .= "WHERE PB_NO = ".$this->getPB_NO();

		return $db->getExecSql($query);
	}

	function getOrderCartAddInsert($db)
	{
		$query  = "INSERT INTO ".TBL_ORDER_CART_ADD." ";
		$query .= "SELECT							";
		$query .= "     ''							";
		$query .= "    ,".$this->getOC_NO();
		$query .= "    ,PBA_OPT_NO					";
		$query .= "    ,PBA_OPT_NM					";
		$query .= "    ,TRUNCATE(CEILING(PBA_OPT_PRICE*".$this->getO_USE_CUR_RATE()."*100)/100,2)	";
		$query .= "    ,PBA_OPT_PRICE				";
		$query .= "    ,PBA_OPT_QTY					";
		$query .= "FROM PRODUCT_BASKET_ADD			";
		$query .= "WHERE PB_NO = ".$this->getPB_NO()."	";
		$query .= "ORDER BY PBA_NO ASC        ";

		return $db->getExecSql($query);

	}


	/* 주문 포인트 INSERT */
	function getOrderPointInsert($db)
	{
		$query = "CALL SP_POINT_MGR_I (?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getM_NO();
		$param[]  = $this->getB_NO();
		$param[]  = $this->getO_NO();
		$param[]  = $this->getPT_TYPE();
		$param[]  = $this->getPT_POINT();
		$param[]  = $this->getPT_MEMO();
		$param[]  = $this->getPT_START_DT();
		$param[]  = $this->getPT_END_DT();
		$param[]  = $this->getPT_REG_IP();
		$param[]  = $this->getPT_ETC();
		$param[]  = $this->getPT_REG_NO();

		return $db->executeBindingQuery($query,$param,true);
	}


	/********************************** Order Delivery Method **********************************/
	function getOrderDelvieryGroupList($db)
	{
		global $S_SITE_LNG;
		
		$query  = "SELECT								";
		$query .= "     DA_NO CODE						";
		$query .= "    ,DA_NAME_".$S_SITE_LNG." NAME	";
		$query .= "FROM ".TBL_SHIPPING."		";
		$query .= "WHERE DA_TYPE = '".$this->getDA_TYPE()."'		";
		$query .= "ORDER BY DA_PRICE ASC		";

		return $db->getArray($query);
	}

	function getOrderDelvieryGroupInfoList($db)
	{
		$query  = "SELECT								";
		$query .= "     *								";
		$query .= "FROM ".TBL_SHIPPING."				";
		$query .= "WHERE DA_TYPE = '".$this->getDA_TYPE()."'		";
		$query .= "ORDER BY DA_PRICE ASC		";
		
		return $db->getArrayTotal($query);
	}

	function getOrderDelvieryInfo($db)
	{
		$query  = "SELECT								";
		$query .= "     DA_PRICE						";
		$query .= "FROM ".TBL_SHIPPING."				";
		$query .= "WHERE DA_NO = ".$this->getDA_NO()."	";
		
		return $db->getCount($query);
	}
	
	function getOrderCountryList($db)
	{
		$query  = "SELECT								";
		$query .= "      CT_CODE						";
		$query .= "     ,CT_AREA						";
		$query .= "FROM ".TBL_COUNTRY."					";
		$query .= "ORDER BY CT_CODE						";
		
		return $db->getArrayTotal($query);
	}

	function getOrderDeliveryWeightMethodList($db)
	{
		$query  = "SELECT                                                       ";
		$query .= "     A.CODE                                                  ";
		$query .= "FROM                                                         ";
		$query .= "(                                                            ";
		$query .= "    SELECT                                                   ";
		$query .= "         DA_MTH CODE                                         ";
		$query .= "        ,MAX(                                                ";
		$query .= "            CASE DA_MTH WHEN 'E' THEN 1                      ";
		$query .= "                        WHEN 'K' THEN 2                      ";
		$query .= "                        WHEN 'R' THEN 3                      ";
		$query .= "                        WHEN 'F' THEN 4 END) RANK            ";
		$query .= "    FROM ".TBL_SHIPPING."                                    ";
		$query .= "    WHERE DA_TYPE	= '".$this->getDA_TYPE()."'				";
		$query .= "        AND DA_AREA	= '".$this->getDA_AREA()."'				";
		$query .= "    GROUP BY DA_MTH                                          ";
		$query .= ") A                                                          ";
		$query .= "ORDER BY A.RANK ASC                                          ";
		
		return $db->getArrayTotal($query);
	}

	function getOrderDeliveryWeightList($db)
	{
		$query  = "SELECT										";
		$query .= "    A.*										";
		$query .= "FROM ".TBL_SHIPPING." A						";
		$query .= "WHERE A.DA_TYPE = 'W'						";
		$query .= "ORDER BY A.DA_AREA,DA_MTH,DA_WEIGHT			";

		return $db->getArrayTotal($query);
	}

	function getOrderDelvieryAreaPrice($db)
	{
		$query  = "SELECT                           ";
		$query .= "    B.DA_PRICE                   ";
		$query .= "FROM ".TBL_COUNTRY." A			";
		$query .= "JOIN ".TBL_SHIPPING." B			";
		$query .= "ON A.CT_AREA = B.DA_AREA			";
		$query .= "WHERE A.CT_CODE		= '".$this->getO_B_COUNTRY()."'";
		$query .= "    AND B.DA_MTH		= '".$this->getO_DELIVERY_COM()."'";
		$query .= "    AND B.DA_WEIGHT	= '".$this->getO_DELIVERY_WEIGHT()."'";

		return $db->getCount($query);

	}

	/********************************** variable **********************************/
	function setO_NO($O_NO){ $this->O_NO = $O_NO; }		
	function getO_NO(){ return $this->O_NO; }		

	function setO_KEY($O_KEY){ $this->O_KEY = $O_KEY; }		
	function getO_KEY(){ return $this->O_KEY; }		

	function setM_NO($M_NO){ $this->M_NO = $M_NO; }		
	function getM_NO(){ return $this->M_NO; }		

	function setO_J_TITLE($O_J_TITLE){ $this->O_J_TITLE = $O_J_TITLE; }		
	function getO_J_TITLE(){ return $this->O_J_TITLE; }		

	function setO_J_NAME($O_J_NAME){ $this->O_J_NAME = $O_J_NAME; }		
	function getO_J_NAME(){ return $this->O_J_NAME; }		

	function setO_J_PHONE($O_J_PHONE){ $this->O_J_PHONE = $O_J_PHONE; }		
	function getO_J_PHONE(){ return $this->O_J_PHONE; }		

	function setO_J_HP($O_J_HP){ $this->O_J_HP = $O_J_HP; }		
	function getO_J_HP(){ return $this->O_J_HP; }		

	function setO_J_MAIL($O_J_MAIL){ $this->O_J_MAIL = $O_J_MAIL; }		
	function getO_J_MAIL(){ return $this->O_J_MAIL; }		

	function setO_B_NAME($O_B_NAME){ $this->O_B_NAME = $O_B_NAME; }		
	function getO_B_NAME(){ return $this->O_B_NAME; }		

	function setO_B_PHONE($O_B_PHONE){ $this->O_B_PHONE = $O_B_PHONE; }		
	function getO_B_PHONE(){ return $this->O_B_PHONE; }		

	function setO_B_HP($O_B_HP){ $this->O_B_HP = $O_B_HP; }		
	function getO_B_HP(){ return $this->O_B_HP; }		

	function setO_B_MAIL($O_B_MAIL){ $this->O_B_MAIL = $O_B_MAIL; }		
	function getO_B_MAIL(){ return $this->O_B_MAIL; }		

	function setO_B_ZIP($O_B_ZIP){ $this->O_B_ZIP = $O_B_ZIP; }		
	function getO_B_ZIP(){ return $this->O_B_ZIP; }		

	function setO_B_COUNTRY($O_B_COUNTRY){ $this->O_B_COUNTRY = $O_B_COUNTRY; }		
	function getO_B_COUNTRY(){ return $this->O_B_COUNTRY; }		

	function setO_B_ADDR1($O_B_ADDR1){ $this->O_B_ADDR1 = $O_B_ADDR1; }		
	function getO_B_ADDR1(){ return $this->O_B_ADDR1; }		

	function setO_B_ADDR2($O_B_ADDR2){ $this->O_B_ADDR2 = $O_B_ADDR2; }		
	function getO_B_ADDR2(){ return $this->O_B_ADDR2; }		

	function setO_B_CITY($O_B_CITY){ $this->O_B_CITY = $O_B_CITY; }		
	function getO_B_CITY(){ return $this->O_B_CITY; }		

	function setO_B_STATE($O_B_STATE){ $this->O_B_STATE = $O_B_STATE; }		
	function getO_B_STATE(){ return $this->O_B_STATE; }	

	function setO_B_MEMO($O_B_MEMO){ $this->O_B_MEMO = $O_B_MEMO; }		
	function getO_B_MEMO(){ return $this->O_B_MEMO; }		

	function setO_PG($O_PG){ $this->O_PG = $O_PG; }		
	function getO_PG(){ return $this->O_PG; }		

	function setO_SETTLE($O_SETTLE){ $this->O_SETTLE = $O_SETTLE; }		
	function getO_SETTLE(){ return $this->O_SETTLE; }		

	function setO_BANK_NAME($O_BANK_NAME){ $this->O_BANK_NAME = $O_BANK_NAME; }		
	function getO_BANK_NAME(){ return $this->O_BANK_NAME; }		

	function setO_BANK($O_BANK){ $this->O_BANK = $O_BANK; }		
	function getO_BANK(){ return $this->O_BANK; }		

	function setO_BANK_ACC($O_BANK_ACC){ $this->O_BANK_ACC = $O_BANK_ACC; }		
	function getO_BANK_ACC(){ return $this->O_BANK_ACC; }	

	function setO_BANK_VALID_DT($O_BANK_VALID_DT){ $this->O_BANK_VALID_DT = $O_BANK_VALID_DT; }		
	function getO_BANK_VALID_DT(){ return $this->O_BANK_VALID_DT; }	

	function setO_USE_POINT($O_USE_POINT){ $this->O_USE_POINT = $O_USE_POINT; }		
	function getO_USE_POINT(){ return $this->O_USE_POINT; }		

	function setO_USE_CUR_POINT($O_USE_CUR_POINT){ $this->O_USE_CUR_POINT = $O_USE_CUR_POINT; }		
	function getO_USE_CUR_POINT(){ return $this->O_USE_CUR_POINT; }		

	function setO_USE_COUPON_NUM($O_USE_COUPON_NUM){ $this->O_USE_COUPON_NUM = $O_USE_COUPON_NUM; }		
	function getO_USE_COUPON_NUM(){ return $this->O_USE_COUPON_NUM; }		

	function setO_USE_COUPON($O_USE_COUPON){ $this->O_USE_COUPON = $O_USE_COUPON; }		
	function getO_USE_COUPON(){ return $this->O_USE_COUPON; }		

	function setO_USE_CUR_COUPON($O_USE_CUR_COUPON){ $this->O_USE_CUR_COUPON = $O_USE_CUR_COUPON; }		
	function getO_USE_CUR_COUPON(){ return $this->O_USE_CUR_COUPON; }		

	function setO_TOT_QTY($O_TOT_QTY){ $this->O_TOT_QTY = $O_TOT_QTY; }		
	function getO_TOT_QTY(){ return $this->O_TOT_QTY; }		

	function setO_TOT_PRICE($O_TOT_PRICE){ $this->O_TOT_PRICE = $O_TOT_PRICE; }		
	function getO_TOT_PRICE(){ return $this->O_TOT_PRICE; }		

	function setO_TOT_CUR_PRICE($O_TOT_CUR_PRICE){ $this->O_TOT_CUR_PRICE = $O_TOT_CUR_PRICE; }		
	function getO_TOT_CUR_PRICE(){ return $this->O_TOT_CUR_PRICE; }		

	function setO_TOT_DELIVERY_PRICE($O_TOT_DELIVERY_PRICE){ $this->O_TOT_DELIVERY_PRICE = $O_TOT_DELIVERY_PRICE; }		
	function getO_TOT_DELIVERY_PRICE(){ return $this->O_TOT_DELIVERY_PRICE; }		

	function setO_TOT_DELIVERY_CUR_PRICE($O_TOT_DELIVERY_CUR_PRICE){ $this->O_TOT_DELIVERY_CUR_PRICE = $O_TOT_DELIVERY_CUR_PRICE; }		
	function getO_TOT_DELIVERY_CUR_PRICE(){ return $this->O_TOT_DELIVERY_CUR_PRICE; }		

	function setO_TAX_PRICE($O_TAX_PRICE){ $this->O_TAX_PRICE = $O_TAX_PRICE; }		
	function getO_TAX_PRICE(){ return $this->O_TAX_PRICE; }		

	function setO_TAX_CUR_PRICE($O_TAX_CUR_PRICE){ $this->O_TAX_CUR_PRICE = $O_TAX_CUR_PRICE; }		
	function getO_TAX_CUR_PRICE(){ return $this->O_TAX_CUR_PRICE; }		

	function setO_TOT_MEM_DISCOUNT_PRICE($O_TOT_MEM_DISCOUNT_PRICE){ $this->O_TOT_MEM_DISCOUNT_PRICE = $O_TOT_MEM_DISCOUNT_PRICE; }		
	function getO_TOT_MEM_DISCOUNT_PRICE(){ return $this->O_TOT_MEM_DISCOUNT_PRICE; }		

	function setO_TOT_MEM_DISCOUNT_CUR_PRICE($O_TOT_MEM_DISCOUNT_CUR_PRICE){ $this->O_TOT_MEM_DISCOUNT_CUR_PRICE = $O_TOT_MEM_DISCOUNT_CUR_PRICE; }		
	function getO_TOT_MEM_DISCOUNT_CUR_PRICE(){ return $this->O_TOT_MEM_DISCOUNT_CUR_PRICE; }		

	function setO_TOT_SPRICE($O_TOT_SPRICE){ $this->O_TOT_SPRICE = $O_TOT_SPRICE; }		
	function getO_TOT_SPRICE(){ return $this->O_TOT_SPRICE; }		
	
	function setO_TOT_CUR_SPRICE($O_TOT_CUR_SPRICE){ $this->O_TOT_CUR_SPRICE = $O_TOT_CUR_SPRICE; }		
	function getO_TOT_CUR_SPRICE(){ return $this->O_TOT_CUR_SPRICE; }		

	function setO_TOT_MEM_POINT($O_TOT_MEM_POINT){ $this->O_TOT_MEM_POINT = $O_TOT_MEM_POINT; }		
	function getO_TOT_MEM_POINT(){ return $this->O_TOT_MEM_POINT; }		

	function setO_TOT_MEM_CUR_POINT($O_TOT_MEM_CUR_POINT){ $this->O_TOT_MEM_CUR_POINT = $O_TOT_MEM_CUR_POINT; }		
	function getO_TOT_MEM_CUR_POINT(){ return $this->O_TOT_MEM_CUR_POINT; }		

	function setO_TOT_POINT($O_TOT_POINT){ $this->O_TOT_POINT = $O_TOT_POINT; }		
	function getO_TOT_POINT(){ return $this->O_TOT_POINT; }		

	function setO_TOT_CUR_POINT($O_TOT_CUR_POINT){ $this->O_TOT_CUR_POINT = $O_TOT_CUR_POINT; }		
	function getO_TOT_CUR_POINT(){ return $this->O_TOT_CUR_POINT; }	

	function setO_APPR_NO($O_APPR_NO){ $this->O_APPR_NO = $O_APPR_NO; }		
	function getO_APPR_NO(){ return $this->O_APPR_NO; }		

	function setO_STATUS($O_STATUS){ $this->O_STATUS = $O_STATUS; }		
	function getO_STATUS(){ return $this->O_STATUS; }		

	function setO_DELIVERY_COM($O_DELIVERY_COM){ $this->O_DELIVERY_COM = $O_DELIVERY_COM; }		
	function getO_DELIVERY_COM(){ return $this->O_DELIVERY_COM; }		

	function setO_DELIVERY_NUM($O_DELIVERY_NUM){ $this->O_DELIVERY_NUM = $O_DELIVERY_NUM; }		
	function getO_DELIVERY_NUM(){ return $this->O_DELIVERY_NUM; }		

	function setO_ESCROW($O_ESCROW){ $this->O_ESCROW = $O_ESCROW; }		
	function getO_ESCROW(){ return $this->O_ESCROW; }

	function setO_ADD_POINT($O_ADD_POINT){ $this->O_ADD_POINT = $O_ADD_POINT; }		
	function getO_ADD_POINT(){ return $this->O_ADD_POINT; }

	function setO_RETURN_BANK($O_RETURN_BANK){ $this->O_RETURN_BANK = $O_RETURN_BANK; }		
	function getO_RETURN_BANK(){ return $this->O_RETURN_BANK; }		

	function setO_RETURN_ACC($O_RETURN_ACC){ $this->O_RETURN_ACC = $O_RETURN_ACC; }		
	function getO_RETURN_ACC(){ return $this->O_RETURN_ACC; }		

	function setO_RETURN_NAME($O_RETURN_NAME){ $this->O_RETURN_NAME = $O_RETURN_NAME; }		
	function getO_RETURN_NAME(){ return $this->O_RETURN_NAME; }		

	function setO_CEL_NO($O_CEL_NO){ $this->O_CEL_NO = $O_CEL_NO; }		
	function getO_CEL_NO(){ return $this->O_CEL_NO; }		

	function setO_CEL_REQ_DT($O_CEL_REQ_DT){ $this->O_CEL_REQ_DT = $O_CEL_REQ_DT; }		
	function getO_CEL_REQ_DT(){ return $this->O_CEL_REQ_DT; }		

	function setO_CEL_REG_DT($O_CEL_REG_DT){ $this->O_CEL_REG_DT = $O_CEL_REG_DT; }		
	function getO_CEL_REG_DT(){ return $this->O_CEL_REG_DT; }		

	function setO_CEL_MEMO($O_CEL_MEMO){ $this->O_CEL_MEMO = $O_CEL_MEMO; }		
	function getO_CEL_MEMO(){ return $this->O_CEL_MEMO; }	

	function setO_CEL_STATUS($O_CEL_STATUS){ $this->O_CEL_STATUS = $O_CEL_STATUS; }		
	function getO_CEL_STATUS(){ return $this->O_CEL_STATUS; }	

	function setO_USE_LNG($O_USE_LNG){ $this->O_USE_LNG = $O_USE_LNG; }		
	function getO_USE_LNG(){ return $this->O_USE_LNG; }		

	function setO_USE_CUR($O_USE_CUR){ $this->O_USE_CUR = $O_USE_CUR; }		
	function getO_USE_CUR(){ return $this->O_USE_CUR; }		

	function setO_USE_CUR_RATE($O_USE_CUR_RATE){ $this->O_USE_CUR_RATE = $O_USE_CUR_RATE; }		
	function getO_USE_CUR_RATE(){ return $this->O_USE_CUR_RATE; }		

	function setO_PAYPAL_TOKEN($PAYPAL_TOKEN){ $this->PAYPAL_TOKEN = $PAYPAL_TOKEN; }		
	function getO_PAYPAL_TOKEN(){ return $this->PAYPAL_TOKEN; }		

	function setO_PAYPAL_RECEIVER_ID($PAYPAL_RECEIVER_ID){ $this->PAYPAL_RECEIVER_ID = $PAYPAL_RECEIVER_ID; }		
	function getO_PAYPAL_RECEIVER_ID(){ return $this->PAYPAL_RECEIVER_ID; }		

	function setO_DELIVERY_METHOD($O_DELIVERY_METHOD){ $this->O_DELIVERY_METHOD = $O_DELIVERY_METHOD; }		
	function getO_DELIVERY_METHOD(){ return $this->O_DELIVERY_METHOD; }		
	
	function setO_DELIVERY_WEIGHT($O_DELIVERY_WEIGHT){ $this->O_DELIVERY_WEIGHT = $O_DELIVERY_WEIGHT; }		
	function getO_DELIVERY_WEIGHT(){ return $this->O_DELIVERY_WEIGHT; }		
	
	function setO_CASH_YN($O_CASH_YN){ $this->O_CASH_YN = $O_CASH_YN; }		
	function getO_CASH_YN(){ return $this->O_CASH_YN; }		

	function setO_CASH_AUTH_NO($O_CASH_AUTH_NO){ $this->O_CASH_AUTH_NO = $O_CASH_AUTH_NO; }		
	function getO_CASH_AUTH_NO(){ return $this->O_CASH_AUTH_NO; }		

	function setO_CASH_INFO($O_CASH_INFO){ $this->O_CASH_INFO = $O_CASH_INFO; }		
	function getO_CASH_INFO(){ return $this->O_CASH_INFO; }		

	function setO_SELF_WRITE($O_SELF_WRITE){ $this->O_SELF_WRITE = $O_SELF_WRITE; }		
	function getO_SELF_WRITE(){ return $this->O_SELF_WRITE; }

	function setO_REG_IP($O_REG_IP){ $this->O_REG_IP = $O_REG_IP; }		
	function getO_REG_IP(){ return $this->O_REG_IP; }		

	function setO_REG_DT($O_REG_DT){ $this->O_REG_DT = $O_REG_DT; }		
	function getO_REG_DT(){ return $this->O_REG_DT; }		


	
	/*--------------------------------------------------------------*/	
	
	
	function setOC_NO($OC_NO){ $this->OC_NO = $OC_NO; }		
	function getOC_NO(){ return $this->OC_NO; }		

	function setP_CODE($P_CODE){ $this->P_CODE = $P_CODE; }		
	function getP_CODE(){ return $this->P_CODE; }		

	function setOC_OPT_NO($OC_OPT_NO){ $this->OC_OPT_NO = $OC_OPT_NO; }		
	function getOC_OPT_NO(){ return $this->OC_OPT_NO; }		

	function setOC_OPT_NM1($OC_OPT_NM1){ $this->OC_OPT_NM1 = $OC_OPT_NM1; }		
	function getOC_OPT_NM1(){ return $this->OC_OPT_NM1; }		

	function setOC_OPT_NM2($OC_OPT_NM2){ $this->OC_OPT_NM2 = $OC_OPT_NM2; }		
	function getOC_OPT_NM2(){ return $this->OC_OPT_NM2; }	
	
	function setOC_OPT_NM3($OC_OPT_NM3){ $this->OC_OPT_NM3 = $OC_OPT_NM3; }		
	function getOC_OPT_NM3(){ return $this->OC_OPT_NM3; }		

	function setOC_OPT_NM4($OC_OPT_NM4){ $this->OC_OPT_NM4 = $OC_OPT_NM4; }		
	function getOC_OPT_NM4(){ return $this->OC_OPT_NM4; }		

	function setOC_OPT_NM5($OC_OPT_NM5){ $this->OC_OPT_NM5 = $OC_OPT_NM5; }		
	function getOC_OPT_NM5(){ return $this->OC_OPT_NM5; }		

	function setOC_OPT_NM6($OC_OPT_NM6){ $this->OC_OPT_NM6 = $OC_OPT_NM6; }		
	function getOC_OPT_NM6(){ return $this->OC_OPT_NM6; }		

	function setOC_OPT_NM7($OC_OPT_NM7){ $this->OC_OPT_NM7 = $OC_OPT_NM7; }		
	function getOC_OPT_NM7(){ return $this->OC_OPT_NM7; }		

	function setOC_OPT_NM8($OC_OPT_NM8){ $this->OC_OPT_NM8 = $OC_OPT_NM8; }		
	function getOC_OPT_NM8(){ return $this->OC_OPT_NM8; }		

	function setOC_OPT_NM9($OC_OPT_NM9){ $this->OC_OPT_NM9 = $OC_OPT_NM9; }		
	function getOC_OPT_NM9(){ return $this->OC_OPT_NM9; }		

	function setOC_OPT_NM10($OC_OPT_NM10){ $this->OC_OPT_NM10 = $OC_OPT_NM10; }		
	function getOC_OPT_NM10(){ return $this->OC_OPT_NM10; }		

	function setOC_OPT_ATTR1($OC_OPT_ATTR1){ $this->OC_OPT_ATTR1 = $OC_OPT_ATTR1; }		
	function getOC_OPT_ATTR1(){ return $this->OC_OPT_ATTR1; }		

	function setOC_OPT_ATTR2($OC_OPT_ATTR2){ $this->OC_OPT_ATTR2 = $OC_OPT_ATTR2; }		
	function getOC_OPT_ATTR2(){ return $this->OC_OPT_ATTR2; }	
	
	function setOC_OPT_ATTR3($OC_OPT_ATTR3){ $this->OC_OPT_ATTR3 = $OC_OPT_ATTR3; }		
	function getOC_OPT_ATTR3(){ return $this->OC_OPT_ATTR3; }		

	function setOC_OPT_ATTR4($OC_OPT_ATTR4){ $this->OC_OPT_ATTR4 = $OC_OPT_ATTR4; }		
	function getOC_OPT_ATTR4(){ return $this->OC_OPT_ATTR4; }		

	function setOC_OPT_ATTR5($OC_OPT_ATTR5){ $this->OC_OPT_ATTR5 = $OC_OPT_ATTR5; }		
	function getOC_OPT_ATTR5(){ return $this->OC_OPT_ATTR5; }		

	function setOC_OPT_ATTR6($OC_OPT_ATTR6){ $this->OC_OPT_ATTR6 = $OC_OPT_ATTR6; }		
	function getOC_OPT_ATTR6(){ return $this->OC_OPT_ATTR6; }		

	function setOC_OPT_ATTR7($OC_OPT_ATTR7){ $this->OC_OPT_ATTR7 = $OC_OPT_ATTR7; }		
	function getOC_OPT_ATTR7(){ return $this->OC_OPT_ATTR7; }		

	function setOC_OPT_ATTR8($OC_OPT_ATTR8){ $this->OC_OPT_ATTR8 = $OC_OPT_ATTR8; }		
	function getOC_OPT_ATTR8(){ return $this->OC_OPT_ATTR8; }		

	function setOC_OPT_ATTR9($OC_OPT_ATTR9){ $this->OC_OPT_ATTR9 = $OC_OPT_ATTR9; }		
	function getOC_OPT_ATTR9(){ return $this->OC_OPT_ATTR9; }		

	function setOC_OPT_ATTR10($OC_OPT_ATTR10){ $this->OC_OPT_ATTR10 = $OC_OPT_ATTR10; }		
	function getOC_OPT_ATTR10(){ return $this->OC_OPT_ATTR10; }		

	function setOC_QTY($OC_QTY){ $this->OC_QTY = $OC_QTY; }		
	function getOC_QTY(){ return $this->OC_QTY; }		

	function setOC_PRICE($OC_PRICE){ $this->OC_PRICE = $OC_PRICE; }		
	function getOC_PRICE(){ return $this->OC_PRICE; }		

	function setOC_CUR_PRICE($OC_CUR_PRICE){ $this->OC_CUR_PRICE = $OC_CUR_PRICE; }		
	function getOC_CUR_PRICE(){ return $this->OC_CUR_PRICE; }		

	function setOC_POINT($OC_POINT){ $this->OC_POINT = $OC_POINT; }		
	function getOC_POINT(){ return $this->OC_POINT; }		

	function setOC_CUR_POINT($OC_CUR_POINT){ $this->OC_CUR_POINT = $OC_CUR_POINT; }		
	function getOC_CUR_POINT(){ return $this->OC_CUR_POINT; }		

	function setOC_DELIVERY_TYPE($OC_DELIVERY_TYPE){ $this->OC_DELIVERY_TYPE = $OC_DELIVERY_TYPE; }		
	function getOC_DELIVERY_TYPE(){ return $this->OC_DELIVERY_TYPE; }		

	function setOC_DELIVERY_PRICE($OC_DELIVERY_PRICE){ $this->OC_DELIVERY_PRICE = $OC_DELIVERY_PRICE; }		
	function getOC_DELIVERY_PRICE(){ return $this->OC_DELIVERY_PRICE; }		

	function setOC_DELIVERY_CUR_PRICE($OC_DELIVERY_CUR_PRICE){ $this->OC_DELIVERY_CUR_PRICE = $OC_DELIVERY_CUR_PRICE; }		
	function getOC_DELIVERY_CUR_PRICE(){ return $this->OC_DELIVERY_CUR_PRICE; }		

	function setOC_DELIVERY_EXP($OC_DELIVERY_EXP){ $this->OC_DELIVERY_EXP = $OC_DELIVERY_EXP; }		
	function getOC_DELIVERY_EXP(){ return $this->OC_DELIVERY_EXP; }		

	function setOC_OPT_ADD_PRICE($OC_OPT_ADD_PRICE){ $this->OC_OPT_ADD_PRICE = $OC_OPT_ADD_PRICE; }		
	function getOC_OPT_ADD_PRICE(){ return $this->OC_OPT_ADD_PRICE; }		

	function setOC_OPT_ADD_CUR_PRICE($OC_OPT_ADD_CUR_PRICE){ $this->OC_OPT_ADD_CUR_PRICE = $OC_OPT_ADD_CUR_PRICE; }		
	function getOC_OPT_ADD_CUR_PRICE(){ return $this->OC_OPT_ADD_CUR_PRICE; }		

	function setOC_REG_DT($OC_REG_DT){ $this->OC_REG_DT = $OC_REG_DT; }		
	function getOC_REG_DT(){ return $this->OC_REG_DT; }		

	function setOC_LIST_ARY($OC_LIST_ARY){ $this->OC_LIST_ARY = $OC_LIST_ARY; }		
	function getOC_LIST_ARY(){ return $this->OC_LIST_ARY; }	
	/*--------------------------------------------------------------*/	
	function setLimitFirst($LIMIT_FIRST){ $this->LIMIT_FIRST = $LIMIT_FIRST; }		
	function getLimitFirst(){ return $this->LIMIT_FIRST; }

	function setPageLine($PAGE_LINE){ $this->PAGE_LINE = $PAGE_LINE; }		
	function getPageLine(){ return $this->PAGE_LINE; }

	function setSearchField($SEARCH_FIELD){ $this->SEARCH_FIELD = $SEARCH_FIELD; }		
	function getSearchField(){ return $this->SEARCH_FIELD; }

	function setSearchKey($SEARCH_KEY){ $this->SEARCH_KEY = $SEARCH_KEY; }		
	function getSearchKey(){ return $this->SEARCH_KEY; }

	function setSearchOrderStatus($SEARCH_ORDER_STATUS){ $this->SEARCH_ORDER_STATUS = $SEARCH_ORDER_STATUS; }		
	function getSearchOrderStatus(){ return $this->SEARCH_ORDER_STATUS; }

	function setSearchSettleType($SEARCH_SETTLE_TYPE){ $this->SEARCH_SETTLE_TYPE = $SEARCH_SETTLE_TYPE; }		
	function getSearchSettleType(){ return $this->SEARCH_SETTLE_TYPE; }

	function setSearchMemberType($SEARCH_MEMBER_TYPE){ $this->SEARCH_MEMBER_TYPE = $SEARCH_MEMBER_TYPE; }							// 회원구분	
	function getSearchMemberType(){ return $this->SEARCH_MEMBER_TYPE; }

	function setSearchDeliveryCom($SEARCH_DELIVERY_COM){ $this->SEARCH_DELIVERY_COM = $SEARCH_DELIVERY_COM; }						// 택배회사
	function getSearchDeliveryCom(){ return $this->SEARCH_DELIVERY_COM; }

	function setSearchOrderKey($SEARCH_ORDER_KEY){ $this->SEARCH_ORDER_KEY = $SEARCH_ORDER_KEY; }		
	function getSearchOrderKey(){ return $this->SEARCH_ORDER_KEY; }

	function setSearchOrderName($SEARCH_ORDER_NAME){ $this->SEARCH_ORDER_NAME = $SEARCH_ORDER_NAME; }		
	function getSearchOrderName(){ return $this->SEARCH_ORDER_NAME; }

	function setSearchRegStartDt($SEARCH_REG_START_DT){ $this->SEARCH_REG_START_DT = $SEARCH_REG_START_DT; }		
	function getSearchRegStartDt(){ return $this->SEARCH_REG_START_DT; }

	function setSearchRegEndDt($SEARCH_REG_END_DT){ $this->SEARCH_REG_END_DT = $SEARCH_REG_END_DT; }		
	function getSearchRegEndDt(){ return $this->SEARCH_REG_END_DT; }

	function setSearchSettleC($SEARCH_SETTLE_C){ $this->SEARCH_SETTLE_C = $SEARCH_SETTLE_C; }		
	function getSearchSettleC(){ return $this->SEARCH_SETTLE_C; }

	function setSearchSettleA($SEARCH_SETTLE_A){ $this->SEARCH_SETTLE_A = $SEARCH_SETTLE_A; }		
	function getSearchSettleA(){ return $this->SEARCH_SETTLE_A; }

	function setSearchSettleT($SEARCH_SETTLE_T){ $this->SEARCH_SETTLE_T = $SEARCH_SETTLE_T; }		
	function getSearchSettleT(){ return $this->SEARCH_SETTLE_T; }

	function setSearchSettleB($SEARCH_SETTLE_B){ $this->SEARCH_SETTLE_B = $SEARCH_SETTLE_B; }		
	function getSearchSettleB(){ return $this->SEARCH_SETTLE_B; }



	/*--------------------------------------------------------------*/	
	function setPB_KEY($PB_KEY){ $this->PB_KEY = $PB_KEY; }		
	function getPB_KEY(){ return $this->PB_KEY; }	

	function setPB_NO($PB_NO){ $this->PB_NO = $PB_NO; }		
	function getPB_NO(){ return $this->PB_NO; }		

	function setPB_ALL_NO($PB_ALL_NO){ $this->PB_ALL_NO = $PB_ALL_NO; }		
	function getPB_ALL_NO(){ return $this->PB_ALL_NO; }	
	
	function setPB_OPT_NO($PB_OPT_NO){ $this->PB_OPT_NO = $PB_OPT_NO; }		
	function getPB_OPT_NO(){ return $this->PB_OPT_NO; }	

	function setPW_NO($PW_NO){ $this->PW_NO = $PW_NO; }		
	function getPW_NO(){ return $this->PW_NO; }		

	function setPW_OPT_NO($PW_OPT_NO){ $this->PW_OPT_NO = $PW_OPT_NO; }		
	function getPW_OPT_NO(){ return $this->PW_OPT_NO; }		

	function setPW_ALL_NO($PW_ALL_NO){ $this->PW_ALL_NO = $PW_ALL_NO; }		
	function getPW_ALL_NO(){ return $this->PW_ALL_NO; }		

	/*--------------------------------------------------------------*/	

	function setOS_NO($OS_NO){ $this->OS_NO = $OS_NO; }		
	function getOS_NO(){ return $this->OS_NO; }		

	function setOS_TITLE($OS_TITLE){ $this->OS_TITLE = $OS_TITLE; }		
	function getOS_TITLE(){ return $this->OS_TITLE; }		

	function setOS_USE_POINT($OS_USE_POINT){ $this->OS_USE_POINT = $OS_USE_POINT; }		
	function getOS_USE_POINT(){ return $this->OS_USE_POINT; }		

	function setOS_USE_COUPON($OS_USE_COUPON){ $this->OS_USE_COUPON = $OS_USE_COUPON; }		
	function getOS_USE_COUPON(){ return $this->OS_USE_COUPON; }		

	function setOS_TOT_PRICE($OS_TOT_PRICE){ $this->OS_TOT_PRICE = $OS_TOT_PRICE; }		
	function getOS_TOT_PRICE(){ return $this->OS_TOT_PRICE; }		

	function setOS_TOT_DELIVERY_PRICE($OS_TOT_DELIVERY_PRICE){ $this->OS_TOT_DELIVERY_PRICE = $OS_TOT_DELIVERY_PRICE; }		
	function getOS_TOT_DELIVERY_PRICE(){ return $this->OS_TOT_DELIVERY_PRICE; }		

	function setOS_TOT_TAX_PRICE($OS_TOT_TAX_PRICE){ $this->OS_TOT_TAX_PRICE = $OS_TOT_TAX_PRICE; }		
	function getOS_TOT_TAX_PRICE(){ return $this->OS_TOT_TAX_PRICE; }		

	function setOS_TOT_SPRICE($OS_TOT_SPRICE){ $this->OS_TOT_SPRICE = $OS_TOT_SPRICE; }		
	function getOS_TOT_SPRICE(){ return $this->OS_TOT_SPRICE; }		

	function setOS_TOT_POINT($OS_TOT_POINT){ $this->OS_TOT_POINT = $OS_TOT_POINT; }		
	function getOS_TOT_POINT(){ return $this->OS_TOT_POINT; }		

	function setOS_STATUS($OS_STATUS){ $this->OS_STATUS = $OS_STATUS; }		
	function getOS_STATUS(){ return $this->OS_STATUS; }		

	function setOS_SETTLE($OS_SETTLE){ $this->OS_SETTLE = $OS_SETTLE; }		
	function getOS_SETTLE(){ return $this->OS_SETTLE; }		

	function setOS_APPR_NO($OS_APPR_NO){ $this->OS_APPR_NO = $OS_APPR_NO; }		
	function getOS_APPR_NO(){ return $this->OS_APPR_NO; }		

	function setOS_APPR_DT($OS_APPR_DT){ $this->OS_APPR_DT = $OS_APPR_DT; }		
	function getOS_APPR_DT(){ return $this->OS_APPR_DT; }		

	function setOS_CEL_NO($OS_CEL_NO){ $this->OS_CEL_NO = $OS_CEL_NO; }		
	function getOS_CEL_NO(){ return $this->OS_CEL_NO; }		

	function setOS_CEL_DT($OS_CEL_DT){ $this->OS_CEL_DT = $OS_CEL_DT; }		
	function getOS_CEL_DT(){ return $this->OS_CEL_DT; }	
	/*--------------------------------------------------------------*/	

	function setPT_NO($PT_NO){ $this->PT_NO = $PT_NO; }		
	function getPT_NO(){ return $this->PT_NO; }		

	function setB_NO($B_NO){ $this->B_NO = $B_NO; }		
	function getB_NO(){ return $this->B_NO; }		

	function setPT_TYPE($PT_TYPE){ $this->PT_TYPE = $PT_TYPE; }		
	function getPT_TYPE(){ return $this->PT_TYPE; }		

	function setPT_POINT($PT_POINT){ $this->PT_POINT = $PT_POINT; }		
	function getPT_POINT(){ return $this->PT_POINT; }		

	function setPT_MEMO($PT_MEMO){ $this->PT_MEMO = $PT_MEMO; }		
	function getPT_MEMO(){ return $this->PT_MEMO; }		

	function setPT_START_DT($PT_START_DT){ $this->PT_START_DT = $PT_START_DT; }		
	function getPT_START_DT(){ return $this->PT_START_DT; }		

	function setPT_END_DT($PT_END_DT){ $this->PT_END_DT = $PT_END_DT; }		
	function getPT_END_DT(){ return $this->PT_END_DT; }		

	function setPT_REG_IP($PT_REG_IP){ $this->PT_REG_IP = $PT_REG_IP; }		
	function getPT_REG_IP(){ return $this->PT_REG_IP; }		

	function setPT_ETC($PT_ETC){ $this->PT_ETC = $PT_ETC; }		
	function getPT_ETC(){ return $this->PT_ETC; }		

	function setPT_REG_NO($PT_REG_NO){ $this->PT_REG_NO = $PT_REG_NO; }		
	function getPT_REG_NO(){ return $this->PT_REG_NO; }		

	function setPT_REG_DT($PT_REG_DT){ $this->PT_REG_DT = $PT_REG_DT; }		
	function getPT_REG_DT(){ return $this->PT_REG_DT; }		

	function setPT_POINT_USE_YEAR($PT_POINT_USE_YEAR){ $this->PT_POINT_USE_YEAR = $PT_POINT_USE_YEAR; }		
	function getPT_POINT_USE_YEAR(){ return $this->PT_POINT_USE_YEAR; }		

	/*--------------------------------------------------------------*/	
	function setCT_CODE($CT_CODE){ $this->CT_CODE = $CT_CODE; }		
	function getCT_CODE(){ return $this->CT_CODE; }		

	function setDA_NO($DA_NO){ $this->DA_NO = $DA_NO; }		
	function getDA_NO(){ return $this->DA_NO; }		

	function setDA_TYPE($DA_TYPE){ $this->DA_TYPE = $DA_TYPE; }		
	function getDA_TYPE(){ return $this->DA_TYPE; }		

	function setDA_NAME($DA_NAME){ $this->DA_NAME = $DA_NAME; }		
	function getDA_NAME(){ return $this->DA_NAME; }		

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

	/*--------------------------------------------------------------*/	
	function setSH_NO($SH_NO){ $this->SH_NO = $SH_NO; }		
	function getSH_NO(){ return $this->SH_NO; }		

}
?>