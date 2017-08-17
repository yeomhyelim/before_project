<?
#/*====================================================================*/#
#|작성자	: 박영미(ivetmi@naver.com)									|#
#|작성일	: 2014-01-01												|#
#|작성내용	: 주문관리(입점몰 버전)										|#
#/*====================================================================*/#
class ShopOrderMgr
{

	/********************************** Order List **********************************/
	function getOrderListEx($db, $op, $param)
	{
		$column['OP_LIST']				= "	 O.*
											,CONCAT(IFNULL(M.M_F_NAME,''),
											        CASE WHEN IFNULL(M.M_F_NAME,'') != '' THEN ' ' ELSE '' END,
		                                            IFNULL(M.M_L_NAME,'')) M_NAME
											,M.M_ID
											,OME.MEMO_CNT
											,DES_DECRYPT(UNHEX(O.O_SHIPPING_NO),'EUMSHOP_ENCRYPT_KEY') O_SHIPPING_NO2
		";
		$column['OP_SELECT']			= "*";
		$column['OP_COUNT']				= "COUNT(*)";
		if(!$op)			{ return; }

		/** 쿼리 start **/
		$join1  = "SELECT																	";
		$join1 .= $column[$op];
		$join1 .= "																			";
		$join1 .= "FROM ".TBL_ORDER_MGR." O													";
		$join1 .= "LEFT OUTER JOIN ".TBL_MEMBER_MGR." M										";
		$join1 .= "ON O.M_NO = M.M_NO														";

		/** 배송상태/구매확정/취소/반품/교환/환불 **/
		$join2	= "";
		if ($param['searchOrderStatus'] || $param['searchDeliveryCom'] || ($param['searchField'] == "deliveryNum" && $param['searchKey'])){

			$join2  = "JOIN																		";
			$join2 .= "(																		";
			$join2 .= "    SELECT																";
			$join2 .= "         OC.O_NO															";
			$join2 .= "    FROM ".TBL_ORDER_CART." OC											";
			$join2 .= "	   WHERE OC.OC_NO IS NOT NULL											";

			switch ($param['searchOrderStatus']){
				case "B":
				case "I":
				case "D":
					$join2 .= "AND OC.OC_DELIVERY_STATUS = '".$param['searchOrderStatus']."'				"; //배송준비중/배송중/배송완료
				break;
				case "C":
				case "T":
					$join2 .= "AND SUBSTRING(OC.OC_ORDER_STATUS,1,1) = '".$param['searchOrderStatus']."'	"; //취소/환불/구매완료
				break;

				case "E":
					$join2 .= "AND SUBSTRING(OC.OC_ORDER_STATUS,1,1) = '".$param['searchOrderStatus']."'	"; //취소/환불/구매완료
				break;

				case "R":
					$join2 .= "AND SUBSTRING(OC.OC_ORDER_STATUS,1,1) IN ('S','R')							"; //반품/교환
				break;
			}

			// 배송 회사 검색
			if($param['searchDeliveryCom']):
				$join2 .= "AND OC.OC_DELIVERY_COM = '{$param['searchDeliveryCom']}'	";
			endif;

			// 배송 번호 검색
			if ($param['searchField'] == "deliveryNum" && $param['searchKey']){
				$join2 .= "AND OC.OC_DELIVERY_NUM LIKE ('%{$param['searchKey']}%')	";	// 배송번호
			}

			$join2 .= "    GROUP BY OC.O_NO												";
			$join2 .= ") OC																";
			$join2 .= "ON OC.O_NO = O.O_NO												";
		}

		/** 입점사별 주문리스트 **/
		$join3 = "";
		if (($param['searchShopNo'] || $param['searchShopList']) || ($param['searchField'] == "shopName" && $param['searchKey'])){

			$join3 .= "JOIN ".TBL_SHOP_ORDER." SO	";
			$join3 .= "ON O.O_NO = SO.O_NO			";

		}

		/** 회원소속검색 **/
		$join4 = "";
		if($param['searchMemberCateList'] || $param['searchMemberCate']):
			$where4 = "WHERE";
			if (is_array($param['searchMemberCateList'])){

				$where4 .= "(";
				foreach($param['searchMemberCateList'] as $cateKey => $cateVal){
					$where4 .= " C_CODE LIKE '".$cateVal."%' /";
				}
				$where4 .= ")";

				$where4 = " ".str_replace("/","OR",substr($where4,0,strlen($where4)-2)).")";
			}

			if ($param['searchMemberCate']){
				if (is_array($param['searchMemberCateList'])) $where4 .= " AND ";
				$where4 .= " C_CODE LIKE '".$param['searchMemberCate']."%'	";
			}

			$join4 .= "JOIN (					";
			$join4 .= "SELECT                   ";
			$join4 .= "    M_NO                 ";
			$join4 .= "FROM ".TBL_MEMBER_CATE." ";
			$join4 .= $where4;
			$join4 .= "GROUP BY M_NO            ";
			$join4 .= ") MC ON MC.M_NO = O.M_NO	";
		endif;

		/** 메모 **/
		if($param['searchOrderMemo']):
			if($param['searchOrderMemo'] == "justList") { $param['searchOrderMemo'] = ""; }
			$where5 = "WHERE AD_TEMP1 = '{$param['searchOrderMemo']}'";
		endif;

		$join5  = "LEFT OUTER JOIN (	";
		$join5 .= "	SELECT IFNULL(AD_TEMP2,0) O_NO,COUNT(*) MEMO_CNT FROM BOARD_AD_USER_REPORT {$where5} GROUP BY IFNULL(AD_TEMP2,0)) OME ";
		$join5 .= "ON O.O_NO = OME.O_NO	";

		/** SEARCH START */
		$searchField['orderNum']			= "O.O_KEY			LIKE ('%{$param['searchKey']}%')";		// 주문번호
		$searchField['orderName']			= "O.O_J_NAME		LIKE ('%{$param['searchKey']}%')";		// 주문자 이름
		$searchField['orderId']				= "M.M_ID			LIKE ('%{$param['searchKey']}%')";		// 주문자 아이디
		$searchField['orderMail']			= "O.O_J_MAIL		LIKE ('%{$param['searchKey']}%')";		// 주문자 이메일
		$searchField['orderHp']				= "O.O_J_HP			LIKE ('%{$param['searchKey']}%')";		// 주문자 핸드폰
//		$searchField['shopName']			= "SH.SH_COM_NAME	LIKE ('%{$param['searchKey']}%')";		// 입점사명
		$searchField['member']				= "O.M_NO > 0";
		$searchField['nonmember']			= "O.M_NO = 0";
		$searchField['orderDeliveryName']	= "O.O_B_NAME		LIKE ('%{$param['searchKey']}%')";	// 받는사람
		$searchField['orderDeliveryHp']		= "O.O_B_HP			LIKE ('%{$param['searchKey']}%')";	// 받는사람 핸드폰

		/** where **/
		$where  = "WHERE O.O_NO IS NOT NULL                                                ";
		$where .= "    AND O.O_STATUS NOT IN ('F','W')                                     ";

		if($param['o_status_not_in']):
			$where	= "{$where} AND O.O_STATUS NOT IN ({$param['o_status_not_in']})			";
		endif;

		// 키워드 검색
		$field  = $searchField[$param['searchField']];
		if($field && $param['searchKey']):
			$where	= "{$where} AND {$field}";
		endif;

		// 회원/비회원 검색
//		$field  = $searchField[$param['searchMemberType']];
//		if($field):
//			$where	= "{$where} AND {$field}";
//		endif;

		## 그룹
		if($param['M_GROUP_IN']):
			$where		= "{$where} AND M.M_GROUP IN ({$param['M_GROUP_IN']})";
		endif;

		// 결제 방법 검색
		if($param['searchSettleType']):
			$temp				= explode(",", $param['searchSettleType']);
			$searchSettleType	= "";
			foreach($temp as $value):
				if($searchSettleType) { $searchSettleType .= ","; }
				$searchSettleType .= "'{$value}'";
			endforeach;
			$where	= "{$where} AND O.O_SETTLE IN ({$searchSettleType})";
		endif;

		// 주문일자 검색
		if($param['searchRegStartDt'] || $param['searchRegEndDt']):
			$start	= $param['searchRegStartDt'];
			$end	= $param['searchRegEndDt'];
			if(!$start) { $start	= "1971-01-01";		}
			if(!$end)	{ $end		= date("Y-m-d");	}
			$start	= "DATE_FORMAT('{$start}','%Y-%m-%d 00:00:00')";
			$end	= "DATE_FORMAT('{$end}','%Y-%m-%d 23:59:59')";
			$where	= "{$where} AND O.O_REG_DT BETWEEN {$start} AND {$end}";
		endif;


		//입점사별 리스트
		if ($param['searchShopNo']) $where = "{$where} AND SO.SH_NO = ".$param['searchShopNo']." ";
		if ($param['searchShopList']) $where = "{$where} AND SO.SH_NO IN (".$param['searchShopList'].") ";

		//주문상태 검색
		if ($param['searchOrderStatus']){
			switch ($param['searchOrderStatus']){
				case "J":
					$where = "{$where} AND O.O_STATUS IN ('J','O')	";
				break;
				case "A":
					$where = "{$where} AND O.O_STATUS IN ('A')	";
				break;
			}
		}

		if ($param['searchOrderMemo']){
			$where = "{$where} AND OME.MEMO_CNT > 0	";
		}

		if($param['order_by']):
			$order_by	= "ORDER BY {$param['order_by']}";
		endif;

		if($param['limit']):
			$limit		= "LIMIT {$param['limit']}";
		endif;

		$query = "{$join1} {$join2} {$join3} {$join4} {$join5} {$where} {$order_by} {$limit}";

		return $this->getSelectQuery($db, $query, $op);
	}

	/********************************** Order List **********************************/

	/********************************** Delivery List **********************************/
	function getOrderDeliveryListEx($db, $op, $param)
	{
		$column['OP_LIST']				= "	 O.*
											,CONCAT(IFNULL(M.M_F_NAME,''),
											        CASE WHEN IFNULL(M.M_F_NAME,'') != '' THEN ' ' ELSE '' END,
		                                            IFNULL(M.M_L_NAME,'')) M_NAME
											,M.M_ID
											,OC.*
											,OME.MEMO_CNT
		";
		$column['OP_SELECT']			= "*";
		$column['OP_COUNT']				= "COUNT(*)";
		if(!$op)			{ return; }

		/** 쿼리 start **/
		$join1  = "SELECT																	";
		$join1 .= $column[$op];
		$join1 .= "																			";
		$join1 .= "FROM 																	";
		$join1 .= "(																		";
		$join1 .= "    SELECT																";
		$join1 .= "         OC.O_NO															";
		$join1 .= "        ,IFNULL(P.P_SHOP_NO,0) P_SHOP_NO									";
		$join1 .= "        ,COUNT(*) P_SHOP_CNT												";
		$join1 .= "    FROM ".TBL_ORDER_CART." OC											";
		$join1 .= "    LEFT OUTER JOIN ".PRODUCT_MGR." P									";
		$join1 .= "    ON OC.P_CODE = P.P_CODE													";
		$join1 .= "	   WHERE OC.OC_NO IS NOT NULL												";
		$join1 .= "         AND SUBSTRING(IFNULL(OC.OC_ORDER_STATUS,''),1,1) NOT IN ('C','S','R','T','E')	";
		$join1 .= "			AND OC.OC_DELIVERY_STATUS = '".$param['searchOrderStatus']."'	"; //배송준비중/배송중/배송완료

		if ($param['searchOrderStatus'] == "D"){
			$join1 .= "		AND IFNULL(OC.OC_ORDER_STATUS,'') = ''							";
		}

		// 배송 회사 검색
		if($param['searchDeliveryCom']):
			$join1 .= "	AND OC.OC_DELIVERY_COM = '{$param['searchDeliveryCom']}'		";
		endif;

		// 배송 번호 검색
		if ($param['searchField'] == "deliveryNum" && $param['searchKey']){
			$join1 .= "AND OC.OC_DELIVERY_NUM LIKE ('%{$param['searchKey']}%')	";	// 배송번호
		}

		$join1 .= "    GROUP BY OC.O_NO,IFNULL(P.P_SHOP_NO,0)								";
		$join1 .= ") OC																		";
		$join1 .= "JOIN ".ORDER_MGR." O														";
		$join1 .= "ON OC.O_NO = O.O_NO														";
		$join1 .= "LEFT OUTER JOIN ".TBL_MEMBER_MGR." M										";
		$join1 .= "ON O.M_NO = M.M_NO														";

		if ($param['shopMallType'] != "R") {
			$join1 .= "LEFT OUTER JOIN ".TBL_SHOP_ORDER." SO								";
			$join1 .= "ON OC.O_NO = SO.O_NO													";
			$join1 .= "AND OC.P_SHOP_NO = SO.SH_NO											";
		}

		/** 회원소속검색 **/
		$join4 = "";
		if($param['searchMemberCateList'] || $param['searchMemberCate']):
			$where4 = "WHERE";
			if (is_array($param['searchMemberCateList'])){

				$where4 .= "(";
				foreach($param['searchMemberCateList'] as $cateKey => $cateVal){
					$where4 .= " C_CODE LIKE '".$cateVal."%' /";
				}
				$where4 .= ")";

				$where4 = " ".str_replace("/","OR",substr($where4,0,strlen($where4)-2)).")";
			}

			if ($param['searchMemberCate']){
				if (is_array($param['searchMemberCateList'])) $where4 .= " AND ";
				$where4 .= " C_CODE LIKE '".$param['searchMemberCate']."%'	";
			}

			$join4 .= "JOIN (					";
			$join4 .= "SELECT                   ";
			$join4 .= "    M_NO                 ";
			$join4 .= "FROM ".TBL_MEMBER_CATE." ";
			$join4 .= $where4;
			$join4 .= "GROUP BY M_NO            ";
			$join4 .= ") MC ON MC.M_NO = O.M_NO	";
		endif;

		/** 메모 **/
		if($param['searchOrderMemo']):
			if($param['searchOrderMemo'] == "justList") { $param['searchOrderMemo'] = ""; }
			$where5 = "WHERE AD_TEMP1 = '{$param['searchOrderMemo']}'";
		endif;

		$join5  = "LEFT OUTER JOIN (	";
		$join5 .= "	SELECT IFNULL(AD_TEMP2,0) O_NO,COUNT(*) MEMO_CNT FROM BOARD_AD_USER_REPORT {$where5} GROUP BY IFNULL(AD_TEMP2,0)) OME ";
		$join5 .= "ON O.O_NO = OME.O_NO	";


		/** SEARCH START */
		$searchField['orderNum']			= "O.O_KEY			LIKE ('%{$param['searchKey']}%')";	// 주문번호
		$searchField['orderName']			= "O.O_J_NAME		LIKE ('%{$param['searchKey']}%')";	// 주문자 이름
		$searchField['orderId']				= "M.M_ID			LIKE ('%{$param['searchKey']}%')";	// 주문자 아이디
		$searchField['orderMail']			= "O.O_J_MAIL		LIKE ('%{$param['searchKey']}%')";	// 주문자 이메일
		$searchField['orderHp']				= "O.O_J_HP			LIKE ('%{$param['searchKey']}%')";	// 주문자 핸드폰
		$searchField['orderDeliveryName']	= "O.O_B_NAME		LIKE ('%{$param['searchKey']}%')";	// 받는사람
		$searchField['orderDeliveryHp']		= "O.O_B_HP			LIKE ('%{$param['searchKey']}%')";	// 받는사람 핸드폰
		$searchField['member']			= "O.M_NO > 0";
		$searchField['nonmember']		= "O.M_NO = 0";

		/** where **/
		$where  = "WHERE OC.O_NO IS NOT NULL                                               ";
		$where .= "    AND O.O_STATUS NOT IN ('F','W','C','R','T','J','O')				   ";


		if($param['o_status_not_in']):
			$where	= "{$where} AND O.O_STATUS NOT IN ({$param['o_status_not_in']})			";
		endif;

		// 키워드 검색
		$field  = $searchField[$param['searchField']];
		if($field && $param['searchKey']):
			$where	= "{$where} AND {$field}";
		endif;

		// 회원/비회원 검색
		$field  = $searchField[$param['searchMemberType']];
		if($field):
			$where	= "{$where} AND {$field}";
		endif;

		// 결제 방법 검색
		if($param['searchSettleType']):
			$temp				= explode(",", $param['searchSettleType']);
			$searchSettleType	= "";
			foreach($temp as $value):
				if($searchSettleType) { $searchSettleType .= ","; }
				$searchSettleType .= "'{$value}'";
			endforeach;
			$where	= "{$where} AND O.O_SETTLE IN ({$searchSettleType})";
		endif;

		// 주문일자 검색
		if($param['searchRegStartDt'] || $param['searchRegEndDt']):
			$start	= $param['searchRegStartDt'];
			$end	= $param['searchRegEndDt'];
			if(!$start) { $start	= "1971-01-01";		}
			if(!$end)	{ $end		= date("Y-m-d");	}
			$start	= "DATE_FORMAT('{$start}','%Y-%m-%d 00:00:00')";
			$end	= "DATE_FORMAT('{$end}','%Y-%m-%d 23:59:59')";
			$where	= "{$where} AND O.O_REG_DT BETWEEN {$start} AND {$end}";
		endif;


		//입점사별 리스트
		if ($param['searchShopNo']) $where = "{$where} AND OC.P_SHOP_NO = ".$param['searchShopNo']." ";
		if ($param['searchShopList']) $where = "{$where} AND OC.P_SHOP_NO IN (".$param['searchShopList'].") ";

		if ($param['searchOrderMemo']){
			$where = "{$where} AND OME.MEMO_CNT > 0	";
		}

		if($param['order_by']):
			$order_by	= "ORDER BY {$param['order_by']}";
		endif;

		if($param['limit']):
			$limit		= "LIMIT {$param['limit']}";
		endif;

		$query = "{$join1} {$join2} {$join3} {$join4} {$join5} {$where} {$order_by} {$limit}";


		return $this->getSelectQuery($db, $query, $op);
	}

	/********************************** Delivery List **********************************/



	/********************************** 주문 입점사별 상품 갯수 **********************************/
	function getOrderCartShopInfo($db,$param)
	{
		$query  = "SELECT A.*, B.*,C.*,IFNULL(D.ST_NAME,'본사') ST_NAME					";
		$query .= "FROM (											";
		$query .= "	SELECT											";
		$query .= "		IFNULL(B.P_SHOP_NO,0) P_SHOP_NO             ";
		$query .= "    ,COUNT(*) CART_CNT       ";
		$query .= " FROM ".TBL_ORDER_CART." A	";
		$query .= " JOIN ".TBL_PRODUCT_MGR." B	";
		$query .= "	ON A.P_CODE = B.P_CODE		";
		$query .= "	WHERE A.O_NO = ".$param['O_NO']."		";

		if ($param['O_SHOP_NO'] >= 0){
			$query .= " AND IFNULL(B.P_SHOP_NO,0) = ".$param['O_SHOP_NO'];
		}

		if (in_array($param['OC_DELIVERY_STATUS'],array("B","I","D"))){
			$query .= " AND IFNULL(A.OC_DELIVERY_STATUS,'') = '{$param['OC_DELIVERY_STATUS']}'	";
			$query .= " AND SUBSTRING(IFNULL(A.OC_ORDER_STATUS,''),1,1) = ''					";
		}

		$query .= " GROUP BY IFNULL(B.P_SHOP_NO,0)          ";
		$query .= ") A										";
		$query .= "LEFT OUTER JOIN ".TBL_SHOP_MGR." B		";
		$query .= "ON A.P_SHOP_NO = B.SH_NO					";
		$query .= "LEFT OUTER JOIN ".TBL_SHOP_ORDER." C		";
		$query .= "ON A.P_SHOP_NO = C.SH_NO					";
		$query .= "AND C.O_NO = ".$param['O_NO']."			";
		$query .= "LEFT OUTER JOIN ".TBL_SHOP_SITE." D		";
		$query .= "ON A.P_SHOP_NO = D.SH_NO					";
		$query .= "AND C.O_NO = ".$param['O_NO']."			";

		$result = $db->getExecSql($query);
		while($row = mysql_fetch_array($result)){
			$aryCode[$row[P_SHOP_NO]] = $row;
		}

		return $aryCode;
	}

	function getOrderCartNoList($db,$param)
	{
		$query  = " SELECT														";
		$query .= "		A.OC_NO													";
		$query .= " FROM ".TBL_ORDER_CART." A	";
		$query .= " JOIN ".TBL_PRODUCT_MGR." B	";
		$query .= "	ON A.P_CODE = B.P_CODE		";
		$query .= "	WHERE A.O_NO = ".$param['O_NO']."		";

		if ($param["O_SHOP_NO"] > 0){
			$query .= " AND IFNULL(B.P_SHOP_NO,0) = ".$param['O_SHOP_NO'];
		}

		return $db->getArrayTotal($query);
	}

	/********************************** 주문 상품별 리스트 **********************************/
	function getOrderCartList($db,$op,$param)
	{
		$query  = "SELECT														";

		if ($op == "OP_COUNT") {
			$query .= " COUNT(*)												";
		} else {
			$query .= "      A.*												";
			$query .= "		,B.P_STOCK_LIMIT									";
			$query .= "		,B.P_STOCK_OUT										";
			$query .= "		,B.P_EVENT_UNIT										";
			$query .= "		,B.P_EVENT											";
			$query .= "		,B.P_TAX											";
			$query .= "		,IFNULL(B.P_SHOP_NO,0) P_SHOP_NO					";
//			$query .= "		,C.SOC_STATUS										";
//			$query .= "		,C.SOC_C_STATUS										";
			$query .= "		,AI.P_NAME											";
			$query .= "     ,PIM.PM_REAL_NAME									";
//			$query .= "		,C.SOC_D_STATUS										";
//			$query .= "		,C.SOC_D_COM										";
//			$query .= "		,C.SOC_D_NUM										";
//			$query .= "		,C.SOC_C_REQ_DT										";
//			$query .= "		,C.SOC_C_REG_DT										";
//			$query .= "		,C.SOC_S_STATUS										";
//			$query .= "		,C.SOC_R_STATUS										";
//			$query .= "		,C.SOC_T_STATUS										";
//			$query .= "		,C.SOC_NO											";
		}
		$query .= "FROM ".TBL_ORDER_CART." A									";
		$query .= "LEFT OUTER JOIN ".TBL_PRODUCT_MGR." B						";
		$query .= "ON A.P_CODE = B.P_CODE										";
//		$query .= "LEFT OUTER JOIN ".TBL_SHOP_ORDER_CART." C					";
//		$query .= "ON A.OC_NO = C.OC_NO											";
		$query .= "LEFT OUTER JOIN ".TBL_PRODUCT_INFO_LNG.$param["O_USE_LNG"]." AI	";
		$query .= "ON B.P_CODE = AI.P_CODE										";
		$query .= "LEFT OUTER JOIN ".TBL_PRODUCT_IMG." PIM                      ";
		$query .= "ON B.P_CODE = PIM.P_CODE                                     ";
		$query .= "AND PIM.PM_TYPE = 'list'                                     ";
		$query .= "WHERE A.OC_NO IS NOT NULL									";

		if ($param["OC_NO"]){
			$query .= " AND A.OC_NO = ".$param["OC_NO"]."						";
		}

		if ($param["IN_OC_NO"]){
			$query .= " AND A.OC_NO IN (".$param["IN_OC_NO"].")					";
		}

		if ($param["NOT_OC_NO"]){
			$query .= " AND A.OC_NO NOT IN (".$param["NOT_OC_NO"].")			";
		}

		if ($param["O_NO"]){
			$query .= " AND A.O_NO = ".$param["O_NO"]."	";
		}

		if ($param["O_SHOP_NO"] >= 0){
			$query .= " AND IFNULL(B.P_SHOP_NO,0) = ".$param["O_SHOP_NO"]."		";
		}

		if ($param["OC_DELIVERY_STATUS"]){
			$query .= " AND IFNULL(A.OC_DELIVERY_STATUS,'') = '".$param["OC_DELIVERY_STATUS"]."'				";
		}

		if ($param["OC_ORDER_STATUS_NOT_IN"]){
			$query .= " AND IFNULL(A.OC_ORDER_STATUS,'') NOT IN (".$param["OC_ORDER_STATUS_NOT_IN"].")			";
		}
//
//		if ($param["SOC_D_COM"] && $param["SOC_D_NUM"]){
//			$query .= " AND C.SOC_D_COM = '".$param["SOC_D_COM"]."'	";
//			$query .= " AND C.SOC_D_NUM = '".$param["SOC_D_NUM"]."'	";
//		}

		$query .= "ORDER BY B.P_SHOP_NO ASC,A.OC_NO ASC ";

		return $this->getSelectQuery($db, $query, $op);
	}

	function getOrderCartAddList($db,$op,$param)
	{
		$query  = "SELECT									";
		$query .= "     A.*									";
		$query .= "FROM ".TBL_ORDER_CART_ADD." A			";
		$query .= "WHERE A.OC_NO = ".$param['OC_NO']."		";
		$query .= "ORDER BY A.OCA_NO DESC					";

		return $this->getSelectQuery($db, $query, $op);
	}

	function getOrderGiftList($db,$param)
	{
		global $S_SITE_LNG;

		$query  = "SELECT A.*					";
		$query .= "	,B.CG_STOCK					";
		$query .= "	,B.CG_QTY					";
		$query .= "	,B.CG_FILE					";
		$query .= " ,C.CG_NAME					";
		$query .= "FROM ".TBL_ORDER_GIFT." A	";
		$query .= "JOIN ".TBL_GIFT_MGR." B		";
		$query .= "ON A.CG_NO = B.CG_NO			";
		$query .= "JOIN ".TBL_GIFT_LNG." C				";
		$query .= "ON B.CG_NO = C.CG_NO					";
		$query .= "AND C.CG_LNG = '".$S_SITE_LNG."'		";
		$query .= "WHERE A.O_NO = ".$param['O_NO']."	";
		$query .= "ORDER BY A.OG_NO ASC			";

		return $db->getArrayTotal($query);
	}

	function getOrderHistoryList($db,$op,$param)
	{

		$column['OP_LIST']		= "A.*		";
		$column['OP_ARYTOTAL']	= "	 A.*
									,B.M_ID
									,CONCAT(IFNULL(B.M_F_NAME,''),IFNULL(B.M_L_NAME,'')) M_NAME
		";
		$column['OP_COUNT']		= "COUNT(*)	";

		$query  = "SELECT								";
		$query .= $column[$op];
		$query .= "FROM ".TBL_HISTORY_MGR." A			";
		$query .= "JOIN ".TBL_MEMBER_MGR." B			";
		$query .= "ON A.H_REG_NO = B.M_NO				";
		$query .= "WHERE A.H_TAB = 'ORDER_MGR'			";
		$query .= "    AND A.H_KEY = ".$param["o_no"]."	";
		$query .= "ORDER BY A.H_NO DESC					";

		if($param['limit']):
			$query	.= "LIMIT {$param['limit']}			";
		endif;

		return $this->getSelectQuery($db, $query, $op);
	}

	/********************************** 주문번호 구하기 **********************************/
	function getOrderNo($db,$param)
	{
		if ($param["OC_NO"]){
			$query  = "SELECT							";
			$query .= "    OC.O_NO						";
			$query .= "FROM ".TBL_ORDER_CART." OC		";
			$query .= "WHERE OC.OC_NO = ".$param["OC_NO"];
		}

		if ($param["SO_NO"]){
			$query  = "SELECT							";
			$query .= "    O_NO							";
			$query .= "FROM ".TBL_SHOP_ORDER."			";
			$query .= "WHERE SO_NO = ".$param["SO_NO"];
		}

		return $db->getCount($query);
	}

	/********************************** 주문 상품별 SHOP_NO 구하기 **********************************/
//	function getOrderShopNo($db,$param)
//	{
//		$query  = "SELECT									";
//		$query .= "    IFNULL(P.P_SHOP_NO,0) SH_NO			";
//		$query .= "FROM ".TBL_ORDER_CART." OC               ";
//		$query .= "JOIN ".TBL_PRODUCT_MGR." P               ";
//		$query .= "ON OC.P_CODE = P.P_CODE					";
//		$query .= "WHERE OC.OC_NO = ".$param['OC_NO'];
//
//		return $db->getCount($query);
//	}

	function getOrderShopCnt($db,$param)
	{
		$query  = "SELECT								";
		$query .= "COUNT(*)								";
		$query .= "FROM ".TBL_SHOP_ORDER."				";
		$query .= "WHERE O_NO = ".$param["O_NO"]."		";
		$query .= "GROUP BY O_NO						";

		return $db->getCount($query);
	}



	/********************************** 주문에 해당하는 배송정보의 첫번째 정보 **********************************/
	function getOrderDeliverInfo($db,$op,$param)
	{
		$query  = "SELECT									";
		$query .= "     A.OC_DELIVERY_COM					";
		$query .= "    ,A.OC_DELIVERY_NUM					";
		$query .= "FROM ".TBL_ORDER_CART." A				";
		$query .= "WHERE A.O_NO = ".$param['O_NO'];
		$query .= "    AND A.OC_DELIVERY_STATUS = 'D'		";
		$query .= "ORDER BY A.OC_NO ASC LIMIT 0,1			";

		return $this->getSelectQuery($db, $query, $op);
	}

	/********************************** Update **********************************/

	/********************************** 주문 상품별 주문상태 UPDATE **********************************/
	function getOrderCartStatusUpdate($db,$param)
	{
		$query  = "UPDATE ".TBL_ORDER_CART."						";
		$query .= "SET OC_MOD_NO	= ".$param["OC_MOD_NO"];
		$query .= "	,OC_MOD_DT		= NOW()							";

		if (in_array($param["OC_DELIVERY_STATUS"],array("B","I","D"))){
			$query .= ",OC_DELIVERY_STATUS= '".$param["OC_DELIVERY_STATUS"]."'	";
		}

		if ($param["OC_DELIVERY_COM"]){
			$query .= ",OC_DELIVERY_COM= '".$param["OC_DELIVERY_COM"]."'		";
		}

		if ($param["OC_DELIVERY_NUM"]){
			$query .= ",OC_DELIVERY_NUM= '".$param["OC_DELIVERY_NUM"]."'		";
		}

		if ($param["OC_DELIVERY_ST_DT"]){
			$query .= ",OC_DELIVERY_ST_DT= NOW()								";
		}

		if ($param["OC_DELIVERY_END_DT"]){
			$query .= ",OC_DELIVERY_END_DT= NOW()								";
		}

		if ($param["OC_ORDER_STATUS"]){
			$query .= ",OC_ORDER_STATUS= '".$param["OC_ORDER_STATUS"]."'		";
		}

		if ($param["OC_E_REG_DT"] == "Y"){
			$query .= ",OC_E_REG_DT= NOW()			";
		}

		$query .= " WHERE OC_NO		= ".$param["OC_NO"];

		return $db->getExecSql($query);
	}

	/************* 주문 상품별 주문상태 취소/반품/교환/환불 UPDATE *************/
	function getOrderCartReturnUpdate($db,$param)
	{

		$query  = "UPDATE ".TBL_ORDER_CART."								";
		$query .= "SET OC_ORDER_STATUS	= '".$param["OC_ORDER_STATUS"]."'	";

		if (substr($param["OC_ORDER_STATUS"],1,1) == "1"){
			$query .= "	,OC_".substr($param["OC_ORDER_STATUS"],0,1)."_REQ_DT	= NOW()  ";

		} else {
			$query .= "	,OC_".substr($param["OC_ORDER_STATUS"],0,1)."_REG_DT	= NOW()  ";
		}

		$query .= "	,OC_MOD_DT		= NOW()        ";
		$query .= " ,OC_MOD_NO		= ".$param["OC_MOD_NO"];

		if ($param["OC_UPDATE_TYPE"] == "All"){
			$query .= "  WHERE O_NO		= ".$param["O_NO"];
		} else {
			$query .= " WHERE OC_NO		= ".$param["OC_NO"];
		}

		return $db->getExecSql($query);
	}

	/************* 입점사 주문 상태 UPDATE *************/
	function goOrderShopStatusUpdate($db,$param)
	{
		$query  = "UPDATE ".TBL_SHOP_ORDER." SET SO_ORDER_STATUS = '".$param["SO_ORDER_STATUS"]."' ";
		$query .= "WHERE O_NO = '".$param["O_NO"]."'	";
		return $db->getExecSql($query);
	}

	/************* 주문 주문상태 UPDATE *************/
	function getOrderStatusAllUpdate($db,$param)
	{
		$query = "CALL SP_ORDER_CART_P (?,?,?,?);";

		$param2[]  = $param['O_NO'];
		$param2[]  = $param['OC_NO'];
		$param2[]  = $param['OC_REG_NO'];

		if ($param['OC_UPDATE_TYPE'] == "P") $param2[] = "P";
		else $param2[] = "";

		return $db->executeBindingQuery($query,$param2,true);
	}

	/* 입점몰 해외주문시 구매완료 상태 프로세스 */
	function getShopOrderStatusAllProcessUpdate($db,$param)
	{
		$query = "CALL SP_SHOP_ORDER_STATUS_FOR_P (?,?,?);";

		$param2[]  = $param['o_no'];
		$param2[]  = $param['o_status'];
		$param2[]  = $param['o_reg_no'];

		return $db->executeBindingQuery($query,$param2,true);
	}

	/* 입점몰 주문 HISTORY */
	function getOrderStatusHistoryUpdate($db,$param)
	{
		$query = "CALL SP_HISTORY_MGR_I (?,?,?,?,?,?,?,?);";

		$param2[]  = $param['m_no'];
		$param2[]  = $param['h_tab'];
		$param2[]  = $param['h_key'];
		$param2[]  = $param['h_code'];
		$param2[]  = $param['h_memo'];
		$param2[]  = $param['h_text'];
		$param2[]  = $param['h_reg_no'];
		$param2[]  = $param['h_adm_no'];

		return $db->executeBindingQuery($query,$param2,true);
	}

	/* 부분취소시 주문정보 update */
	function getOrderPartCancelMasterUpdate($db,$param)
	{
		$query = "UPDATE ORDER_MGR SET
			 O_USE_POINT					= '".$param["o_use_point"]."'
			,O_USE_CUR_POINT				= '".$param["o_use_cur_point"]."'
			,O_USE_COUPON					= '".$param["o_use_coupon"]."'
			,O_USE_CUR_COUPON				= '".$param["o_use_cur_coupon"]."'
			,O_TOT_QTY						= '".$param["o_tot_qty"]."'
			,O_TOT_PRICE					= '".$param["o_tot_price"]."'
			,O_TOT_CUR_PRICE				= '".$param["o_tot_cur_price"]."'
			,O_TOT_DELIVERY_PRICE			= '".$param["o_tot_delivery_price"]."'
			,O_TOT_DELIVERY_CUR_PRICE		= '".$param["o_tot_delivery_cur_price"]."'
			,O_TAX_PRICE					= '".$param["o_tax_price"]."'
			,O_TAX_CUR_PRICE				= '".$param["o_tax_cur_price"]."'
			,O_TOT_MEM_DISCOUNT_PRICE		= '".$param["o_tot_mem_discount_price"]."'
			,O_TOT_MEM_DISCOUNT_CUR_PRICE	= '".$param["o_tot_mem_discount_cur_price"]."'
			,O_TOT_SPRICE					= '".$param["o_tot_sprice"]."'
			,O_TOT_CUR_SPRICE				= '".$param["o_tot_cur_sprice"]."'
			,O_TOT_MEM_POINT				= '".$param["o_tot_mem_point"]."'
			,O_TOT_MEM_CUR_POINT			= '".$param["o_tot_mem_cur_point"]."'
			,O_TOT_POINT					= '".$param["o_tot_point"]."'
			,O_TOT_CUR_POINT				= '".$param["o_tot_cur_point"]."'
			WHERE O_NO = ".$param["o_no"];

		return $db->getExecSql($query);
	}

	function getOrderPartCancelMasterSettleUpdate($db,$param)
	{
		$query = "UPDATE ".TBL_ORDER_SETTLE." SET
			 OS_USE_POINT				= '".$param["o_use_cur_point"]."'
			,OS_USE_COUPON				= '".$param["o_use_cur_coupon"]."'
			,OS_TOT_PRICE				= '".$param["o_tot_cur_price"]."'
			,OS_TOT_DELIVERY_PRICE		= '".$param["o_tot_delivery_cur_price"]."'
			,OS_TOT_TAX_PRICE			= '".$param["o_tax_cur_price"]."'
			,OS_TOT_SPRICE				= '".$param["o_tot_cur_sprice"]."'
			,OS_TOT_POINT				= '".$param["o_tot_point"]."'
		WHERE O_NO = ".$param['o_no'];
		return $db->getExecSql($query);
	}

	function getOrderPartCancelReturnUpdate($db,$param)
	{
		$query  = "UPDATE ".TBL_ORDER_MGR." SET ";
		$query .= "	 O_RETURN_BANK			= '".$param["returnBank"]."'";
		$query .= "	,O_RETURN_ACC			= '".$param["returnAcc"]."'";
		$query .= "	,O_RETURN_NAME			= '".$param["returnName"]."'";
		$query .= "	WHERE O_NO = ".$param['o_no'];
		return $db->getExecSql($query);
	}



	/********************************** Function **********************************/
	function getSelectQuery($db, $query, $op)
	{
		if ( $op == "OP_LIST" ) :
			return $db->getExecSql($query);
		elseif ( $op == "OP_SELECT" ) :
			return $db->getSelect($query);
		elseif ( $op == "OP_COUNT" ) :
			return $db->getCount($query);
		elseif ( $op == "OP_ARYLIST" ) :
			return $db->getArray($query);
		elseif ( $op == "OP_ARYTOTAL" ) :
			return $db->getArrayTotal($query);
		elseif ( $op == "OP_RESULT" ) :
			return $db->getResult($query);
		else :
			return -100;
		endif;
	}


}
?>