<?
#/*====================================================================*/#
#|작성자	: kim hee sung(thav@naver.com)								|#
#|작성일	: 2012-06-21												|#
#|작성내용	: 주문관리(입점몰 버전)										|#
#/*====================================================================*/#
class ShopOrderMgr
{

	/********************************** Order List **********************************/

//	SELECT
//		 A.SO_NO								-- 입점사 주문관리번호(주문번호)
//		,A.O_NO									-- 주문관리번호
//		,B.O_KEY								-- 주문키
//		,B.O_REG_DT								-- 등록일
//		,C.ST_NAME_ENG							-- 입점몰 영문 이름
//		,C.ST_NAME								-- 입점몰 한글 이름
//		,A.SO_TOT_CUR_SPRICE					-- 통화총판매금액
//		,A.SO_TOT_DELIVERY_CUR_PRICE			-- 통화총배송비
//		,D.SH_COM_DELIVERY_COR					-- 국내택배업체
//		,D.SH_COM_DELIVERY_FOR_COR				-- 해외택배업체
//		,A.SO_DELIVERY_COM						-- 배송회사
//		,A.SO_DELIVERY_NUM						-- 배송번호
//		,B.O_STATUS								-- 결제상태
//		,A.SO_DELIVERY_STATUS					-- 배송상태
//		,A.SO_ORDER_STATUS						-- 구매상태
//		,A.SO_TOT_PROD_CNT						-- 입점사주문상품수
//		,A.SH_NO								-- 입점사번호
//	FROM SHOP_ORDER A
//	JOIN ORDER_MGR B
//	ON A.O_NO = B.O_NO
//	LEFT OUTER JOIN SHOP_SITE C
//	ON A.SH_NO = C.SH_NO
//	LEFT OUTER JOIN SHOP_MGR D
//	ON A.SH_NO = D.SH_NO
//	WHERE B.O_STATUS = 'A'
//	 AND A.SO_DELIVERY_STATUS IN ('B','I','D')
//
//	ORDER BY B.O_NO DESC
	function getDeliveryListEx($db, $op, $param) {
		$column['OP_LIST']				=	"A.SO_NO
											,A.O_NO
											,B.M_NO
											,B.O_KEY
											,B.O_REG_DT
											,C.ST_NAME_ENG
											,C.ST_NAME
											,A.SO_TOT_CUR_SPRICE
											,A.SO_TOT_DELIVERY_CUR_PRICE
											,D.SH_COM_DELIVERY_COR
											,D.SH_COM_DELIVERY_FOR_COR
											,A.SO_DELIVERY_COM
											,A.SO_DELIVERY_NUM
											,B.O_STATUS
											,A.SO_DELIVERY_STATUS
											,A.SO_ORDER_STATUS
											,A.SO_TOT_PROD_CNT
											,A.SH_NO
											,B.O_J_NAME
											,B.O_J_PHONE
											,B.O_J_HP
											,B.O_B_NAME
											,B.O_B_PHONE
											,B.O_B_HP
											,B.O_B_ZIP
											,B.O_B_ADDR1
											,B.O_B_ADDR2
											,B.O_B_COUNTRY
											,B.O_B_CITY
											,B.O_B_STATE
											,B.O_B_MEMO
											,B.O_APPR_DT
											";

		$column['OP_COUNT']				= "COUNT(*)";

		$searchField['orderNum']			= "B.O_KEY		LIKE ('%{$param['searchKey']}%')";	// 주문번호
		$searchField['orderName']			= "B.O_J_NAME	LIKE ('%{$param['searchKey']}%')";	// 주문자 이름
		$searchField['orderId']				= "E.M_ID		LIKE ('%{$param['searchKey']}%')";	// 주문자 아이디
		$searchField['orderIdMail']			= "B.O_J_MAIL	LIKE ('%{$param['searchKey']}%')";	// 주문자 이메일
		$searchField['orderHp']				= "B.O_J_HP	LIKE ('%{$param['searchKey']}%')";	// 주문자 핸드폰
		$searchField['member']				= "B.M_NO > 0";
		$searchField['nonmember']			= "B.M_NO = 0";
		$searchField['deliveryNum']			= "A.SO_DELIVERY_NUM LIKE ('%{$param['searchKey']}%')";	// 배송번호
		$searchField['orderDeliveryName']	= "TRIM(REPLACE(B.O_B_NAME,' ',''))	LIKE ('%{$param['searchKey']}%')";	// 배송지 받는 사람
		$searchField['orderDeliveryHp']		= "B.O_B_HP	LIKE ('%{$param['searchKey']}%')";	// 배송지 받는사람 핸드폰

		if(!$op)			{ return; }

		$select1	= "SELECT {$column[$op]} FROM SHOP_ORDER AS A";
		$join1		= "JOIN ORDER_MGR B	ON A.O_NO = B.O_NO";
		$join2		= "LEFT OUTER JOIN SHOP_SITE C ON A.SH_NO = C.SH_NO";
		$join3		= "LEFT OUTER JOIN SHOP_MGR D ON A.SH_NO = D.SH_NO";
		$join4		= "LEFT OUTER JOIN MEMBER_MGR E ON B.M_NO = E.M_NO";

		## 회원소속검색
		if($param['M_CATE']):

			$join5Where = "WHERE";
			if (is_array($param['M_CATE'])){

				$join5Where .= "(";
				foreach($param['M_CATE'] as $cateKey => $cateVal){
					$join5Where .= " C_CODE LIKE '".$cateVal."%' /";
				}
				$join5Where .= ")";

				$join5Where = " ".str_replace("/","OR",substr($join5Where,0,strlen($join5Where)-2)).")";
			} else {
				$join5Where .= " C_CODE LIKE '".$param['M_CATE']."%'	";
			}

			$join5From  = "SELECT                   ";
			$join5From .= "    M_NO                 ";
			$join5From .= "FROM ".TBL_MEMBER_CATE." ";
			$join5From .= $join5Where;
			$join5From .= "GROUP BY M_NO            ";

			$join5		= "JOIN ({$join5From}) AS MC ON MC.M_NO = B.M_NO";

		endif;

		$where1		= "WHERE A.O_NO IS NOT NULL";
		$where1	   .= "	AND B.O_STATUS NOT IN ('F','W')				  ";

		// 구매상태(상점별)
		if($param['so_order_status_in']):
			$temp				= explode(",", $param['so_order_status_in']);
			$data				= "";
			foreach($temp as $value):
				if($data) { $data .= ","; }
				$data .= "'{$value}'";
			endforeach;

			if($param['so_order_status_null'] == "Y"):
				// 결제상태
				if($param['so_delivery_status_in']):
					if($param['o_status']):

						$temp2				= explode(",", $param['o_status']);
						$data2				= "";
						foreach($temp2 as $value2):
							if($data2) { $data2 .= ","; }
							$data2 .= "'{$value2}'";
						endforeach;

						$where1 = "{$where1} AND (B.O_STATUS IN ({$data2}) ";
					endif;

					$where1	.= "AND (A.SO_ORDER_STATUS IN ({$data}) OR  IFNULL(A.SO_ORDER_STATUS,'') = '') ";

					if($param['o_status']):
						$where1 = "{$where1})  ";
					endif;
				else:
					$where1	.= "AND (A.SO_ORDER_STATUS IN ('{$param['so_delivery_status_in']}')) ";
				endif;

			else:
				// 결제상태
				if($param['o_status']):
					$where1 = "{$where1} AND (B.O_STATUS = '{$param['o_status']}' OR B.O_STATUS IS NULL)";
				endif;

				$where1	= "{$where1} AND A.SO_ORDER_STATUS IN ({$data})";
			endif;
			$temp	= "";
			$data	= "";
		else:
			// 구매상태 값이 널인 경우 가져 오기
			if($param['so_order_status_null'] == "Y"):
				$where1 = "{$where1} AND (A.SO_ORDER_STATUS IS NULL OR A.SO_ORDER_STATUS = '')";
			endif;
		endif;

		// 배송상태
		if($param['so_delivery_status_in']):
			$temp				= explode(",", $param['so_delivery_status_in']);
			$data				= "";
			foreach($temp as $value):
				if($data) { $data .= ","; }
				$data .= "'{$value}'";
			endforeach;
			if($param['so_delivery_status_null'] == "Y"):
				if ($data == "'B'"){
					$where1	= "{$where1} AND (A.SO_DELIVERY_STATUS IN ({$data}) OR  A.SO_DELIVERY_STATUS IS NULL OR A.SO_DELIVERY_STATUS = '')";
				} else {
					$where1	= "{$where1} AND (A.SO_DELIVERY_STATUS IN ({$data}) AND B.O_STATUS IN ('A','I','D'))";
				}
			else:
				$where1	= "{$where1} AND A.SO_DELIVERY_STATUS IN ({$data})";
			endif;
			$temp	= "";
			$data	= "";
		else:
			// 배송상태 값이 널인 경우 가져 오기
			if($param['so_delivery_status_null'] == "Y"):
				$where1 = "{$where1} AND (A.SO_DELIVERY_STATUS IS NULL OR A.SO_DELIVERY_STATUS = '')";
			endif;
		endif;

		// 입점몰
		if($param['sh_no']):
			$where1	= "{$where1} AND A.SH_NO IN ({$param['sh_no']})";
		endif;

		// 키워드 검색
		$field  = $searchField[$param['searchField']];
		if($field && $param['searchKey']):
			$where1	= "{$where1} AND {$field}";
		endif;

		// 회원/비회원 검색
		$field  = $searchField[$param['searchMemberType']];
		if($field):
			$where1	= "{$where1} AND {$field}";
		endif;

		// 결제 방법 검색
		if($param['searchSettleType']):
			$temp				= explode(",", $param['searchSettleType']);
			$searchSettleType	= "";
			foreach($temp as $value):
				if($searchSettleType) { $searchSettleType .= ","; }
				$searchSettleType .= "'{$value}'";
			endforeach;
			$where1	= "{$where1} AND B.O_SETTLE IN ({$searchSettleType})";
		endif;

		// 주문일자 검색
		if($param['searchRegStartDt'] || $param['searchRegEndDt']):
			$start	= $param['searchRegStartDt'];
			$end	= $param['searchRegEndDt'];
			if(!$start) { $start	= "1971-01-01";		}
			if(!$end)	{ $end		= date("Y-m-d");	}
			$start	= "DATE_FORMAT('{$start}','%Y-%m-%d 00:00:00')";
			$end	= "DATE_FORMAT('{$end}','%Y-%m-%d 23:59:59')";
			$where1	= "{$where1} AND B.O_REG_DT BETWEEN {$start} AND {$end}";
		endif;

		// 배송 상태 검색
		if($param['searchDeliveryStatus']):
			$where1	= "{$where1} AND A.SO_DELIVERY_STATUS = '{$param['searchDeliveryStatus']}'";
		endif;

		// 배송 회사 검색
		if($param['searchDeliveryCom']):
			$where1	= "{$where1} AND A.SO_DELIVERY_COM = '{$param['searchDeliveryCom']}'";
		endif;

		// 정렬
		if($param['order_by']):
			$order_by	= "ORDER BY {$param['order_by']}";
		endif;

		// 리밋
		if($param['limit']):
			$limit		= "LIMIT {$param['limit']}";
		endif;

		$query = "{$select1} {$join1} {$join2} {$join3} {$join4} {$join5} {$where1} {$order_by} {$limit}";
		//echo $query."<Br>";

		return $this->getSelectQuery($db, $query, $op);
	}

//	SELECT A.* ,C.SHOP_CNT FROM ORDER_MGR A
//	LEFT OUTER JOIN MEMBER_MGR B ON A.M_NO = B.M_NO LEFT OUTER JOIN
//	( SELECT SO.O_NO, COUNT(*) SHOP_CNT FROM SHOP_ORDER SO GROUP BY SO.O_NO ) C ON A.O_NO = C.O_NO
//	WHERE A.O_NO IS NOT NULL	AND A.O_STATUS NOT IN ('F','W')
	function getOrderListEx($db, $op, $param)
	{
		$column['OP_LIST']				= "A.* , B.*,CONCAT(IFNULL(B.M_F_NAME,''),IFNULL(B.M_L_NAME,'')) M_NAME
										  ,(SELECT COUNT(*) FROM SHOP_ORDER WHERE O_NO = A.O_NO) SHOP_CNT
										  ,OME.MEMO_CNT
										  ";
		$column['OP_SELECT']			= "*";
		$column['OP_COUNT']				= "COUNT(*)";

		$searchField['orderNum']			= "A.O_KEY		LIKE ('%{$param['searchKey']}%')";	// 주문번호
		$searchField['orderName']			= "A.O_J_NAME	LIKE ('%{$param['searchKey']}%')";	// 주문자 이름
		$searchField['orderId']				= "B.M_ID		LIKE ('%{$param['searchKey']}%')";	// 주문자 아이디
		$searchField['orderIdMail']			= "A.O_J_MAIL	LIKE ('%{$param['searchKey']}%')";	// 주문자 이메일
		$searchField['orderHp']				= "A.O_J_HP	LIKE ('%{$param['searchKey']}%')";	// 주문자 핸드폰
		$searchField['member']				= "A.M_NO > 0";
		$searchField['nonmember']			= "A.M_NO = 0";
		$searchField['orderDeliveryName']	= "TRIM(REPLACE(A.O_B_NAME,' ',''))	LIKE ('%{$param['searchKey']}%')";	// 배송지 받는 사람
		$searchField['orderDeliveryHp']		= "A.O_B_HP	LIKE ('%{$param['searchKey']}%')";	// 배송지 받는사람 핸드폰

		if(!$op)			{ return; }
//		if(!$param)			{ return; }

//		$select = "SELECT SO.O_NO, COUNT(*) SHOP_CNT FROM SHOP_ORDER SO GROUP BY SO.O_NO";

		//주문상태 검색
		if ($param['searchOrderStatus']){
			switch ($param['searchOrderStatus']){
				case "C":
					$where2 = "WHERE SOC.SOC_STATUS IN ('C')		"; //취소
				break;

				case "R":
					$where2 = "WHERE SOC.SOC_STATUS IN ('S','R')	"; //반품/교환
				break;

				case "T":
					$where2 = "WHERE SOC.SOC_STATUS IN ('T')		"; //환불
				break;

				case "E":

					if ($param['searchShopNo'] || $param['searchShopList']) {
						$where2 = "WHERE SOC.SOC_STATUS IN ('E')	"; //구매완료
					}
				break;
			}

			if ($param['searchShopNo'] || $param['searchShopList']){
				if ($param['searchShopNo']) $where2 .= " AND IFNULL(P.P_SHOP_NO,0) = ".$param['searchShopNo']." ";
				if ($param['searchShopList']) $where2 .= " AND IFNULL(P.P_SHOP_NO,0) IN (".$param['searchShopList'].") ";
			}
		}

/*		$select = "
			SELECT
				 SO.O_NO
				,COUNT(*) SHOP_CNT
			FROM SHOP_ORDER SO
			";

		if ($where2) $select .= "JOIN ";
		else $select .= "LEFT OUTER JOIN ";


		$select .= "
			(
				SELECT
					 OC.O_NO
				FROM SHOP_ORDER_CART SOC
				JOIN ORDER_CART OC
				ON SOC.OC_NO = OC.OC_NO
				".$where2."
				GROUP BY OC.O_NO
			) SOC
			ON SO.O_NO = SOC.O_NO
			WHERE SO.SO_NO IS NOT NULL
			".$where3."
			GROUP BY SO.O_NO";

		$shop_select = " LEFT OUTER JOIN ({$select}) C	";
		if ($where2 || $where3) $shop_select = " JOIN ({$select}) C	";
*/

		$select  = "
				SELECT
					 OC.O_NO
				FROM SHOP_ORDER_CART SOC
				JOIN ORDER_CART OC
				ON SOC.OC_NO = OC.OC_NO
				JOIN PRODUCT_MGR P
				ON OC.P_CODE = P.P_CODE
				";
		if ($where2) $select .= $where2;

		$select .= "
				GROUP BY OC.O_NO";

		//$shop_select = " LEFT OUTER JOIN ({$select}) C	";
		if ($where2) $shop_select = " JOIN ({$select}) C ON A.O_NO = C.O_NO";


		$from	= "FROM ".TBL_ORDER_MGR." AS A ";
//		if ($param['searchShopNo'] || $param['searchShopList']){
			$from	 .= "
				JOIN (
					SELECT
						O.O_NO
					FROM ORDER_MGR O
					JOIN SHOP_ORDER SO
					ON O.O_NO = SO.O_NO
					WHERE O.O_NO IS NOT NULL ";

					if ($param['searchShopNo']) $from .= " AND SO.SH_NO = ".$param['searchShopNo']." ";
					if ($param['searchShopList']) $from .= " AND SO.SH_NO IN (".$param['searchShopList'].") ";

					/* 배송중/배송완료 */
					if ($param['searchDeliveryStatus']){
						if ($param['searchDeliveryStatus'] != "B"){
							$from .= " AND SO.SO_DELIVERY_STATUS ='".$param['searchDeliveryStatus']."'	";
							$from .= " AND (SO.SO_ORDER_STATUS IN ('J','A') OR IFNULL(SO.SO_ORDER_STATUS,'') = '')
									   AND O.O_STATUS IN ('A','I','D')					";

						} else {

							$from .= " AND O.O_STATUS IN ('A','B','I','D','E')	";
							$from .= " AND (SO.SO_ORDER_STATUS IN ('J','A') OR IFNULL(SO.SO_ORDER_STATUS,'') = '')	";
							$from .= " AND (SO.SO_DELIVERY_STATUS IN ('B') OR SO.SO_DELIVERY_STATUS IS NULL OR SO.SO_DELIVERY_STATUS = '')	";
						}
					}

					//본사 주문상태 검색(구매확정 쿼리가 늦어서 구매확정 상태일때는 마스터 테이블에서 조건을 담)
					if (!$param['searchShopNo'] && !$param['searchShopList']) {
						if ($param['searchOrderStatus'] && $param['searchOrderStatus'] == "E"){
							$from .= " AND O.O_STATUS = 'E'			";
						}
					}

			$from .= "GROUP BY O.O_NO		";
			$from .= ") AO	";
			$from .= "ON A.O_NO = AO.O_NO	";
//		}

		$query	= "SELECT {$column[$op]}			";
		$query .= $from;

		$join1	= "LEFT OUTER JOIN MEMBER_MGR B		";
		$join1 .= "ON A.M_NO = B.M_NO				";
		$join1 .= $shop_select;
		//$join1 .= "ON A.O_NO = C.O_NO				";

		$where	= "WHERE A.O_NO IS NOT NULL			";
		$where .= "	AND A.O_STATUS NOT IN ('F','W')	";

		if($param['o_no']):
			$where	= "{$where} AND A.O_NO = {$param['o_no']}";
		endif;

		if($param['o_status_not_in']):
			$where	= "{$where} AND A.O_STATUS NOT IN ({$param['o_status_not_in']})";
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
			$where	= "{$where} AND A.O_SETTLE IN ({$searchSettleType})";
		endif;

		// 주문일자 검색
		if($param['searchRegStartDt'] || $param['searchRegEndDt']):
			$start	= $param['searchRegStartDt'];
			$end	= $param['searchRegEndDt'];
			if(!$start) { $start	= "1971-01-01";		}
			if(!$end)	{ $end		= date("Y-m-d");	}
			$start	= "DATE_FORMAT('{$start}','%Y-%m-%d 00:00:00')";
			$end	= "DATE_FORMAT('{$end}','%Y-%m-%d 23:59:59')";
			$where	= "{$where} AND A.O_REG_DT BETWEEN {$start} AND {$end}";
		endif;

		//주문상태 검색
		if ($param['searchOrderStatus']){
			switch ($param['searchOrderStatus']){
				case "J":
					$where = "{$where} AND A.O_STATUS IN ('J','O')	";
				break;
			}
		}

//		if ($param['searchDeliveryStatus']){
//			if ($param['searchDeliveryStatus'] == "B"){
//				$where = "{$where} AND A.O_STATUS IN ('A','B','I','D','E')	";
//
//				if ($param['searchShopNo'] || $param['searchShopList']){
//					$where = "{$where} AND (A.SO_ORDER_STATUS IN ('J','A') OR IFNULL(A.SO_ORDER_STATUS,'') = '')	";
//					$where = "{$where} AND (A.SO_DELIVERY_STATUS IN ('B') OR A.SO_DELIVERY_STATUS IS NULL OR A.SO_DELIVERY_STATUS = '')	";
//				}
//			}
//		}

		//메모가 등록된 주문 검색
// 2013.12.16 kim hee sung 메모 상태에 따라서 개수가 달라지도록 변경
		if ($param['searchOrderMemo']){
			$where = "{$where} AND OME.MEMO_CNT > 0	";
		}

		## 회원소속검색(부관리자일때 자기가 속한 소속만 보이도록 처리)
		if($param['M_CATE']):

			$join2Where			= "";

			if(!is_array($param['M_CATE'])) {
					$temp					= $param['M_CATE'];
					$param['M_CATE']		= "";
					$param['M_CATE'][]		= $temp;
			}

			foreach($param['M_CATE'] as $key => $data):
				if($join2Where) { $join2Where .= " OR"; }
				$join2Where		= "{$join2Where} MC2.C_CODE LIKE ('{$data}%')";
			endforeach;

			if($join2Where) { $join2Where = "AND ({$join2Where})"; }

			if($param['SEARCH_CATE']):
				$join2Where = "{$join2Where} AND C_CODE LIKE '{$param['SEARCH_CATE']}%'";
			endif;

			$join2Query			= "SELECT MC2.M_NO FROM MEMBER_CATE AS MC2 WHERE MC2.M_NO IS NOT NULL {$join2Where} GROUP BY MC2.M_NO";
			$join2				= "JOIN ({$join2Query}) AS MC ON MC.M_NO = A.M_NO";

		endif;

		## 회원소속검색
// 2013.12.20 kim hee sung 소스 정리.
//		if($param['M_CATE']):
//			$join2Where = "WHERE";
//			if (is_array($param['M_CATE'])){
//
//				$join2Where .= "(";
//				foreach($param['M_CATE'] as $cateKey => $cateVal){
//					$join2Where .= " C_CODE LIKE '".$cateVal."%' /";
//				}
//				$join2Where .= ")";
//
//				$join2Where = " ".str_replace("/","OR",substr($join2Where,0,strlen($join2Where)-2)).")";
//			} else {
//				$join2Where .= " C_CODE LIKE '".$param['M_CATE']."%'	";
//			}
//
//			$join2From  = "SELECT                   ";
//			$join2From .= "    M_NO                 ";
//			$join2From .= "FROM ".TBL_MEMBER_CATE." ";
//			$join2From .= $join2Where;
//			$join2From .= "GROUP BY M_NO            ";
//
//			$join2		= "JOIN ({$join2From}) AS MC ON MC.M_NO = A.M_NO";
//
//		endif;

		## 메모 검색
		if($param['searchOrderMemo']):
			if($param['searchOrderMemo'] == "justList") { $param['searchOrderMemo'] = ""; }
			$join3Where = "WHERE AD_TEMP1 = '{$param['searchOrderMemo']}'";
		endif;

		$join3From  = "SELECT IFNULL(AD_TEMP2,0) O_NO ,COUNT(*) MEMO_CNT FROM BOARD_AD_USER_REPORT {$join3Where} GROUP BY IFNULL(AD_TEMP2,0) ";
		$join3		= "LEFT OUTER JOIN ({$join3From}) AS OME ON OME.O_NO = A.O_NO ";



		if($param['order_by']):
			$order_by	= "ORDER BY {$param['order_by']}";
		endif;

		if($param['limit']):
			$limit		= "LIMIT {$param['limit']}";
		endif;

		$query = "{$query} {$join1} {$join2} {$join3} {$where} {$order_by} {$limit}";
//		echo $query;

		return $this->getSelectQuery($db, $query, $op);
	}

//	SELECT SO.SH_NO, SS.ST_NAME, SS.ST_NAME_ENG, SO.SO_TOT_PRICE, SO.SO_TOT_CUR_PRICE, SO.SO_TOT_SPRICE,
//	SO.SO_TOT_CUR_SPRICE, SO.SO_TOT_APRICE, SO.SO_TOT_APRICE, SO.SO_TOT_DELIVERY_PRICE, SO.SO_TOT_DELIVERY_CUR_PRICE,
//	SO.SO_DELIVERY_COM, SO.SO_DELIVERY_NUM, SO.SO_DELIVERY_STATUS, SO.SO_ORDER_STATUS, SO.SO_EXCHANGE_STATUS,
//	SO.SO_ACC_STATUS, SO.SO_ACC_DATE
//	FROM SHOP_ORDER SO
//	LEFT OUTER JOIN SHOP_SITE SS ON SO.SH_NO = SS.SH_NO
//	WHERE SO.O_NO = 19 ORDER BY SO.SH_NO ASC
	function getShopOrderListEx($db, $op, $param)
	{
		$column['OP_LIST']		= "SO.SO_NO, SO.SH_NO, SS.ST_NAME, SS.ST_NAME_ENG, SO.SO_TOT_PRICE, SO.SO_TOT_CUR_PRICE, SO.SO_TOT_SPRICE,
								   SO.SO_TOT_CUR_SPRICE, SO.SO_TOT_APRICE, SO.SO_TOT_APRICE, SO.SO_TOT_DELIVERY_PRICE, SO.SO_TOT_DELIVERY_CUR_PRICE,
								   SO.SO_DELIVERY_COM, SO.SO_DELIVERY_NUM, SO.SO_DELIVERY_STATUS, SO.SO_ORDER_STATUS, SO.SO_EXCHANGE_STATUS,
								   SO.SO_ACC_STATUS, SO.SO_ACC_DATE, SM.SH_COM_DELIVERY_COR,SO.SO_TOT_PROD_CNT,SM.SH_COM_DELIVERY_PRICE";

		$column['OP_ARYTOTAL']		= "SO.SO_NO, SO.SH_NO, SS.ST_NAME, SS.ST_NAME_ENG, SO.SO_TOT_PRICE, SO.SO_TOT_CUR_PRICE, SO.SO_TOT_SPRICE,
								   SO.SO_TOT_CUR_SPRICE, SO.SO_TOT_APRICE, SO.SO_TOT_APRICE, SO.SO_TOT_DELIVERY_PRICE, SO.SO_TOT_DELIVERY_CUR_PRICE,
								   SO.SO_DELIVERY_COM, SO.SO_DELIVERY_NUM, SO.SO_DELIVERY_STATUS, SO.SO_ORDER_STATUS, SO.SO_EXCHANGE_STATUS,
								   SO.SO_ACC_STATUS, SO.SO_ACC_DATE, SM.SH_COM_DELIVERY_COR,SO.SO_TOT_PROD_CNT,SM.SH_COM_DELIVERY_PRICE";


		$column['OP_SELECT']	= "*";
		$column['OP_COUNT']		= "COUNT(*)";

		$searchField['deliveryNum']		= "SO.SO_DELIVERY_NUM		LIKE ('%{$param['searchKey']}%')";	// 배송번호
		$searchField['shopName']		= "SS.ST_NAME	LIKE ('%{$param['searchKey']}%')";	// 입점사 명

		if(!$op)			{ return; }
//		if(!$param)			{ return; }

		$from	= TBL_SHOP_ORDER;
		$query	= "SELECT {$column[$op]} FROM {$from} AS SO";
		$join1	= "LEFT OUTER JOIN SHOP_SITE SS ON SO.SH_NO = SS.SH_NO";
		$join2	= "LEFT OUTER JOIN SHOP_MGR SM ON SO.SH_NO = SM.SH_NO";
		$where	= "WHERE SO.O_NO IS NOT NULL";

		if ($param['searchShopNo']){
			$where = " {$where} AND SO.SH_NO IN ( {$param['searchShopNo']} )";
		}

		if($param['so_no']):
			$where = "{$where} AND SO.SO_NO = {$param['so_no']}";
		endif;

		if($param['o_no']):
			$where	= "{$where} AND SO.O_NO = {$param['o_no']}";
		endif;

		$field  = $searchField[$param['searchField']];
		if($field && $param['searchKey']):
			$where	= "{$where} AND {$field}";
		endif;

		// 배송 번호 검색
		$field  = $searchField[$param['searchField']];
		if($field && $param['searchKey']):
			$where	= "{$where} AND {$field}";
		endif;

		// 배송 상태 검색
		if($param['searchDeliveryStatus']):
			if ($param['searchDeliveryStatus'] != "B"){
				$where	= "{$where} AND SO_DELIVERY_STATUS = '{$param['searchDeliveryStatus']}'";
			}
		endif;

		// 배송 회사 검색
		if($param['searchDeliveryCom']):
			$where	= "{$where} AND SO_DELIVERY_COM = '{$param['searchDeliveryCom']}'";
		endif;

		if($param['order_by']):
			$order_by	= "ORDER BY {$param['order_by']}";
		endif;

		if($param['limit']):
			$limit		= "LIMIT {$param['limit']}";
		endif;

		$query = "{$query} {$join1} {$join2} {$where} {$order_by} {$limit}";

		return $this->getSelectQuery($db, $query, $op);
	}

//	SELECT OC.OC_NO, OC.P_CODE, PI.P_NAME, OC.OC_QTY
//	FROM ORDER_CART OC
//	JOIN PRODUCT_MGR P ON OC.P_CODE = P.P_CODE
//	JOIN PRODUCT_INFO_KR PI ON P.P_CODE = PI.P_CODE
//	LEFT OUTER JOIN PRODUCT_IMG AS PM ON PM.P_CODE = P.P_CODE AND PM.PM_TYPE = 'list'
//	WHERE OC.O_NO = 19 AND P.P_SHOP_NO = 12 ORDER BY OC.OC_NO ASC
	function getOrderCartListEx($db, $op, $param)
	{
		$column['OP_LIST']		= "OC.OC_NO, OC.OC_CUR_PRICE, OC.OC_DELIVERY_CUR_PRICE, OC.OC_DELIVERY_TYPE, OC.P_CODE, OC.OC_QTY, PI.P_NAME, PM.PM_REAL_NAME
									,SOC.SOC_STATUS
									,SOC.SOC_C_STATUS
									,SOC.SOC_C_REQ_DT
									,SOC.SOC_C_REG_DT
									,SOC.SOC_S_STATUS
									,SOC.SOC_S_REQ_DT
									,SOC.SOC_S_REG_DT
									,SOC.SOC_R_STATUS
									,SOC.SOC_R_REQ_DT
									,SOC.SOC_R_REG_DT
									,P.P_BAESONG_TYPE
									,P.P_BAESONG_PRICE
									,OC.OC_OPT_ATTR1
									,OC.OC_OPT_ATTR2
									,OC.OC_OPT_ATTR3
									,OC.OC_OPT_ATTR4
									,OC.OC_OPT_ATTR5
									,OC.OC_OPT_ATTR6
									,OC.OC_OPT_ATTR6
									,OC.OC_OPT_ATTR8
									,OC.OC_OPT_ATTR9
									,OC.OC_OPT_ATTR10
									,OC.OC_STOCK_CUR_PRICE

		";
		$column['OP_ARYTOTAL']		= "OC.OC_NO, OC.OC_CUR_PRICE, OC.OC_DELIVERY_CUR_PRICE, OC.OC_DELIVERY_TYPE, OC.P_CODE, OC.OC_QTY, PI.P_NAME, PM.PM_REAL_NAME
									,SOC.SOC_STATUS
									,SOC.SOC_C_STATUS
									,SOC.SOC_C_REQ_DT
									,SOC.SOC_C_REG_DT
									,SOC.SOC_S_STATUS
									,SOC.SOC_S_REQ_DT
									,SOC.SOC_S_REG_DT
									,SOC.SOC_R_STATUS
									,SOC.SOC_R_REQ_DT
									,SOC.SOC_R_REG_DT
									,P.P_BAESONG_TYPE
									,P.P_BAESONG_PRICE
									,OC.OC_OPT_ATTR1
									,OC.OC_OPT_ATTR2
									,OC.OC_OPT_ATTR3
									,OC.OC_OPT_ATTR4
									,OC.OC_OPT_ATTR5
									,OC.OC_OPT_ATTR6
									,OC.OC_OPT_ATTR6
									,OC.OC_OPT_ATTR8
									,OC.OC_OPT_ATTR9
									,OC.OC_OPT_ATTR10
									,OC.OC_STOCK_CUR_PRICE
		";

		$column['OP_SELECT']	= "*";
		$column['OP_COUNT']		= "COUNT(*)";


		if(!$op)			{ return; }
//		if(!$param)			{ return; }

		$from	= TBL_ORDER_CART;
		$query	= "SELECT {$column[$op]} FROM {$from} AS OC";
		$join1	= "JOIN PRODUCT_MGR P ON OC.P_CODE = P.P_CODE";
		$join2	= "JOIN PRODUCT_INFO_KR PI ON P.P_CODE = PI.P_CODE";
		$join3	= "LEFT OUTER JOIN PRODUCT_IMG AS PM ON PM.P_CODE = P.P_CODE AND PM.PM_TYPE = 'list'";
		$join4  = "LEFT OUTER JOIN SHOP_ORDER_CART SOC ON OC.OC_NO = SOC.OC_NO	";
		$where	= "WHERE OC.O_NO IS NOT NULL";

		if($param['o_no']):
			$where	= "{$where} AND OC.O_NO = {$param['o_no']}";
		endif;

		if($param['p_shop_no'] !== null && $param['p_shop_no'] !== ""):
			$where	= "{$where} AND IFNULL(P.P_SHOP_NO,0) = {$param['p_shop_no']}";
		endif;

		if ($param["in_soc_status"]){
			$where	= "{$where} AND SOC.SOC_STATUS IN ({$param['in_soc_status']})";
		}

		if ($param['product_all'] == "N"){
			$where	= "{$where} AND IFNULL(SOC.SOC_STATUS,'') NOT IN ('C','S','R','T')	";
		}

		if($param['order_by']):
			$order_by	= "ORDER BY {$param['order_by']}";
		endif;

		if($param['limit']):
			$limit		= "LIMIT {$param['limit']}";
		endif;

		$query = "{$query} {$join1} {$join2} {$join3} {$join4} {$where} {$order_by} {$limit}";



		return $this->getSelectQuery($db, $query, $op);
	}


	function getOrderCartAddList($db,$param)
	{
		$query  = "SELECT									";
		$query .= "     A.*									";
		$query .= "FROM ".TBL_ORDER_CART_ADD." A			";
		$query .= "WHERE A.OC_NO = ".$param['oc_no']."		";
		$query .= "ORDER BY A.OCA_NO DESC					";

		return $db->getArrayTotal($query);
	}

	function getOrderNo($db,$param)
	{
		if ($param["oc_no"]){
			$query  = "SELECT							";
			$query .= "    OC.O_NO						";
			$query .= "FROM ".TBL_SHOP_ORDER_CART." SOC	";
			$query .= "JOIN ".TBL_ORDER_CART." OC	    ";
			$query .= "ON SOC.OC_NO = OC.OC_NO			";
			$query .= "WHERE SOC.OC_NO = ".$param["oc_no"];
		}

		if ($param["so_no"]){
			$query  = "SELECT							";
			$query .= "    O_NO							";
			$query .= "FROM ".TBL_SHOP_ORDER."			";
			$query .= "WHERE SO_NO = ".$param["so_no"];
		}

		return $db->getCount($query);
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

	function getOrderCartList($db,$param)
	{
		$query  = "SELECT														";
		$query .= "      A.*													";
		$query .= "		,B.P_STOCK_LIMIT										";
		$query .= "		,B.P_STOCK_OUT											";
		$query .= "		,B.P_EVENT_UNIT											";
		$query .= "		,B.P_EVENT												";
		$query .= "		,IFNULL(B.P_SHOP_NO,0) P_SHOP_NO						";
		$query .= "		,C.SOC_STATUS											";
		$query .= "		,C.SOC_C_STATUS											";
		$query .= "		,AI.P_NAME												";
		$query .= "     ,PIM.PM_REAL_NAME										";
		$query .= "FROM ".TBL_ORDER_CART." A									";
		$query .= "JOIN ".TBL_PRODUCT_MGR." B									";
		$query .= "ON A.P_CODE = B.P_CODE										";
		$query .= "LEFT OUTER JOIN ".TBL_SHOP_ORDER_CART." C					";
		$query .= "ON A.OC_NO = C.OC_NO											";
		$query .= "JOIN ".TBL_PRODUCT_INFO_LNG.$param["o_use_lng"]." AI			";
		$query .= "ON B.P_CODE = AI.P_CODE										";
		$query .= "LEFT OUTER JOIN ".TBL_PRODUCT_IMG." PIM                      ";
		$query .= "ON B.P_CODE = PIM.P_CODE                                     ";
		$query .= "AND PIM.PM_TYPE = 'list'                                     ";
		$query .= "WHERE A.OC_NO IS NOT NULL									";

		if ($param["oc_no"]){
			$query .= " AND A.OC_NO = ".$param["oc_no"]."						";
		}

		if ($param["in_oc_no"]){
			$query .= " AND A.OC_NO IN (".$param["in_oc_no"].")					";
		}

		if ($param["not_oc_no"]){
			$query .= " AND A.OC_NO NOT IN (".$param["not_oc_no"].")			";
		}

		if ($param["o_no"]){
			$query .= " AND A.O_NO = ".$param["o_no"]."	";
		}

		if ($param["shop_no"] >= 0){
			$query .= " AND IFNULL(B.P_SHOP_NO,0) = ".$param["shop_no"]."		";
		}

		$query .= "ORDER BY A.OC_NO ASC ";

		if ($param["op"] == "result") return $db->getResult($query);
		else return $db->getArrayTotal($query);
	}

	function getOrderCartCnt($db,$param)
	{
		$query	= "SELECT COUNT(*) FROM ".TBL_ORDER_CART." A ";
		if ($param["in_soc_status"]) {
			$query .= "LEFT OUTER JOIN ".TBL_SHOP_ORDER_CART." B ";
			$query .= "ON A.OC_NO = B.OC_NO						 ";
		}

//		if ($param['p_shop_no']	> 0){
			$query .= "JOIN ".TBL_PRODUCT_MGR." P	";
			$query .= "ON P.P_CODE = A.P_CODE		";
//		}


		$query .= "WHERE O_NO = ".$param["o_no"];

		if ($param['p_shop_no']	> 0){
			$query .= " AND P.P_SHOP_NO	 = ".$param['p_shop_no'];
		}

		if ($param["in_soc_status"]) {
			$query .= " AND B.SOC_STATUS IN (".$param["in_soc_status"].") ";
		}
		return $db->getCount($query);
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
		else :
			return -100;
		endif;
	}

	/********************************** Update **********************************/
	/*###### 입점몰 구매확정 UPDATE */
	function getOrderMallCerityUpdate($db,$param)
	{
		$intCnt = $db->getCount("SELECT COUNT(*) FROM ".TBL_SHOP_ORDER_CART." WHERE OC_NO = ".$param["oc_no"]);

		if ($intCnt == 0)
		{
			$query  = "INSERT INTO ".TBL_SHOP_ORDER_CART." ";
			$query .= "(                            ";
			$query .= "     OC_NO                   ";
			$query .= "    ,SOC_STATUS              ";
			$query .= "    ,SOC_REG_DT              ";
			$query .= "    ,SOC_REG_NO              ";
			$query .= ") VALUES (                   ";
			$query .= "     ".$param["oc_no"]."     ";
			$query .= "    ,'".$param["oc_status1"]."'";
			$query .= "    ,NOW()                   ";
			$query .= "    ,".$param["oc_reg_no"]." ";
			$query .= ");                           ";

			return $db->getExecSql($query);

		} else {

			$query  = "UPDATE SHOP_ORDER_CART							";
			$query .= "SET  SOC_STATUS	= '".$param["oc_status1"]."'	";
			$query .= "	,SOC_MOD_DT		= NOW()        ";
			$query .= " ,SOC_MOD_NO		= ".$param["oc_reg_no"];
			$query .= " WHERE OC_NO		= ".$param["oc_no"];

			return $db->getExecSql($query);
		}
	}


	/*###### 입점몰 반품/교환/환불 UPDATE */
	function getOrderMallReturnUpdate($db,$param)
	{
		$row = $db->getCount("SELECT * FROM ".TBL_SHOP_ORDER_CART." WHERE OC_NO = ".$param["oc_no"]);

		$strOrderReturnStatus1 = $param["oc_status1"];
		$strOrderReturnStatus2 = $param["oc_status2"];

		if (!$row)
		{
			$query  = "INSERT INTO ".TBL_SHOP_ORDER_CART." ";
			$query .= "(                            ";
			$query .= "     OC_NO                   ";
			$query .= "    ,SOC_STATUS              ";
			$query .= "    ,SOC_".$strOrderReturnStatus1."_STATUS  ";
			$query .= "    ,SOC_".$strOrderReturnStatus1."_REQ_DT  ";
			$query .= "    ,SOC_".$strOrderReturnStatus1."_REG_DT  ";
			$query .= "    ,SOC_REG_DT              ";
			$query .= "    ,SOC_REG_NO              ";
			$query .= ") VALUES (                   ";
			$query .= "     ".$param["oc_no"]."     ";
			$query .= "    ,'".$strOrderReturnStatus1."'";
			$query .= "    ,'".$strOrderReturnStatus2."'";
			$query .= "    ,NOW()                   ";
			$query .= "    ,NOW()                   ";
			$query .= "    ,NOW()                   ";
			$query .= "    ,".$param["oc_reg_no"]." ";
			$query .= ");                           ";

			return $db->getExecSql($query);

		} else {

			$query  = "UPDATE SHOP_ORDER_CART							";
			$query .= "SET  SOC_STATUS	= '".$strOrderReturnStatus1."'	";
			$query .= "	,SOC_".$strOrderReturnStatus1."_STATUS		= '".$strOrderReturnStatus2."'        ";

			if (!$row['SOC_'.$strOrderReturnStatus1.'_REQ_DT']){
				$query .= "	,SOC_".$strOrderReturnStatus1."_REQ_DT	= NOW()        ";
			}
			$query .= "	,SOC_".$strOrderReturnStatus1."_REG_DT		= NOW()        ";
			$query .= "	,SOC_MOD_DT		= NOW()        ";
			$query .= " ,SOC_MOD_NO		= ".$param["oc_reg_no"];
			$query .= " WHERE OC_NO		= ".$param["oc_no"];

			return $db->getExecSql($query);
		}
	}

	function getOrderStatusAllUpdate($db,$param)
	{
		$query = "CALL SP_SHOP_ORDER_CART_IU (?,?,?,?);";

		$param2[]  = $param['oc_no'];
		$param2[]  = $param['so_no'];
		$param2[]  = $param['update_type'];
		$param2[]  = $param['reg_no'];

		return $db->executeBindingQuery($query,$param2,true);
	}

	/* 입점몰 주문 상태 프로세스 */
	function getOrderStatusAllProcessUpdate($db,$param)
	{
		$query = "CALL SP_SHOP_ORDER_STATUS_P (?,?,?);";

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

	function getOrderSettleUpdate($db,$param){
		$query  = "UPDATE ".TBL_ORDER_MGR." SET ";
		$query .= "	 O_SETTLE	= '".$param["settle"]."'";
		$query .= "	WHERE O_NO	= ".$param['o_no'];
		return $db->getExecSql($query);
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

	/* 결제완료시 배송상태를 배송준비중으로 변경 */
	function getOrderAccStatusUpdate($db,$param)
	{
		$query  = "UPDATE ".TBL_SHOP_ORDER." SET SO_ORDER_STATUS = '".$param['o_status']."'";

		if ($param['so_delivery_status']){
			$query .= " , SO_DELIVERY_STATUS = '".$param['so_delivery_status']."'	";
		}

		$query .= "	WHERE O_NO = ".$param['o_no'];
		return $db->getExecSql($query);
	}

	/********************************** View **********************************/

	function getShopOrderCartView($db,$param)
	{
		global $S_SITE_LNG;

		$query  = "SELECT														";
		$query .= "      A.*													";
		$query .= "		,AI.P_NAME												";
		$query .= "     ,C.PM_REAL_NAME											";
		$query .= "		,B.P_STOCK_LIMIT										";
		$query .= "		,B.P_STOCK_OUT											";
		$query .= "		,B.P_EVENT_UNIT											";
		$query .= "		,B.P_EVENT												";
		$query .= "		,IFNULL(B.P_SHOP_NO,0) P_SHOP_NO						";
		$query .= "		,SOC.*													";
		$query .= "		,O.O_KEY												";
		$query .= "		,SM.ST_NAME												";
		$query .= "		,SM.ST_NAME_ENG											";
		$query .= "		,SM.SH_NO												";
		$query .= "FROM ".TBL_ORDER_CART." A									";
		$query .= "JOIN ".TBL_PRODUCT_MGR." B									";
		$query .= "ON A.P_CODE = B.P_CODE										";
		$query .= "JOIN ".TBL_PRODUCT_INFO_LNG.$S_SITE_LNG." AI			";
		$query .= "ON B.P_CODE = AI.P_CODE										";
		$query .= "LEFT OUTER JOIN ".TBL_PRODUCT_IMG." C						";
		$query .= "ON A.P_CODE = C.P_CODE										";
		$query .= "AND C.PM_TYPE = 'list'										";
		$query .= "LEFT OUTER JOIN ".TBL_SHOP_ORDER_CART." SOC					";
		$query .= "ON A.OC_NO = SOC.OC_NO										";
		$query .= "JOIN ".TBL_ORDER_MGR." O										";
		$query .= "ON A.O_NO = O.O_NO											";
		$query .= "LEFT OUTER JOIN ".TBL_SHOP_SITE." SM							";
		$query .= "ON IFNULL(B.P_SHOP_NO,0) = SM.SH_NO							";
		$query .= "WHERE A.OC_NO = ".$param["oc_no"];

		return $db->getSelect($query);
	}

	function getShopOrderView($db,$param)
	{
		$query  = "SELECT                       ";
		$query .= "     SO.*	                ";
		$query .= "    ,SI.ST_NAME              ";
		$query .= "    ,SI.ST_NAME_ENG          ";
		$query .= "FROM ".TBL_SHOP_ORDER." SO   ";
		$query .= "LEFT OUTER JOIN ".TBL_SHOP_SITE." SI	";
		$query .= "ON IFNULL(SO.SH_NO,0) = SI.SH_NO       ";
		$query .= "WHERE SO.SO_NO = ".$param["so_no"];

		return $db->getSelect($query);
	}

	function getOrderShopCnt($db,$param)
	{
		$query  = "SELECT								";
		$query .= "COUNT(*)								";
		$query .= "FROM ".TBL_SHOP_ORDER."				";
		$query .= "WHERE O_NO = ".$param["o_no"]."		";
		$query .= "GROUP BY O_NO						";

		return $db->getCount($query);
	}


	/*********************************version2.0 추가된 부분 *********************************/
	function getOrderCartListVer2($db,$op="OP_LIST",$param)
	{
		$query  = "SELECT      A.*												";
		$query .= "		,IFNULL(B.P_SHOP_NO,0) P_SHOP_NO						";
		$query .= "	    ,B.P_TAX												";
		$query .= "FROM ".TBL_ORDER_CART." A									";
		$query .= "JOIN ".TBL_PRODUCT_MGR." B									";
		$query .= "ON A.P_CODE = B.P_CODE										";
		$query .= "WHERE A.OC_NO IS NOT NULL									";

		if ($param["IN_OC_NO"]){
			$query .= " AND A.OC_NO IN (".$param["IN_OC_NO"].")					";
		}

		if ($param["NOT_OC_NO"]){
			$query .= " AND A.OC_NO NOT IN (".$param["NOT_OC_NO"].")			";
		}

		if ($param["O_NO"]){
			$query .= " AND A.O_NO = ".$param["O_NO"]."	";
		}

		if ($param["OC_DELIVERY_STATUS"]){
			$query .= " AND A.OC_DELIVERY_STATUS = '".$param["OC_DELIVERY_STATUS"]."'	";
		}

		if ($param["OC_ORDER_STATUS"]){
			$query .= " AND A.OC_ORDER_STATUS = '".$param["OC_ORDER_STATUS"]."'	";
		}
		$query .= "ORDER BY A.OC_NO ASC ";
		return $this->getSelectQuery($db,$query,$op);
	}

	/********************************** 주문 상품별 주문상태 UPDATE **********************************/
	function getOrderCartStatusUpdate($db,$param)
	{
		$query  = "UPDATE ".TBL_ORDER_CART."						";
		$query .= "SET OC_MOD_NO	= ".$param["OC_MOD_NO"];
		$query .= "	,OC_MOD_DT		= NOW()							";

		if ($param["OC_ORDER_STATUS"]){
			$query .= ",OC_ORDER_STATUS= '".$param["OC_ORDER_STATUS"]."'		";
		}

		if (in_array(substr($param["OC_ORDER_STATUS"],0,1),array("C","S","R","T"))){
			if (substr($param["OC_ORDER_STATUS"],1,1) == "1"){
				$query .= "	,OC_".substr($param["OC_ORDER_STATUS"],0,1)."_REQ_DT	= NOW()  ";

			} else {
				$query .= "	,OC_".substr($param["OC_ORDER_STATUS"],0,1)."_REG_DT	= NOW()  ";
			}
		}

		if ($param["OC_E_REG_DT"] == "Y"){
			$query .= ",OC_E_REG_DT= NOW()			";
		}

		$query .= " WHERE OC_NO		= ".$param["OC_NO"];

		return $db->getExecSql($query);
	}

	function getOrderStatusAllUpdateVer2($db,$param)
	{
		$query = "CALL SP_ORDER_CART_P (?,?,?,?);";

		$param2[]	= $param['O_NO'];
		$param2[]	= $param['OC_NO'];
		$param2[]	= $param['OC_REG_NO'];

		if ($param['OC_UPDATE_TYPE'] == "P") $param2[] = "P";
		else $param2[] = "";

		return $db->executeBindingQuery($query,$param2,true);
	}


}
?>