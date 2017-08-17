<?
#/*====================================================================*/# 
#|작성자	: 박영미(ivetmi@naver.com)									|# 
#|작성일	: 2012-05-11												|# 
#|작성내용	: 로그 및 통계관리											|# 
#/*====================================================================*/# 

class WebLogMgr
{
	private $query;
	private $columnField;
	private $columnData;
	private $insert_id;

	// 작성일 : 2013.07.10
	// 작성자 : kim hee sung
	// 내  용 : 호스트별방문자분석 및 질의어별방문자분석 리스트
	// SELECT  * FROM LOG_REFERER_2013 WHERE DATE_FORMAT(CONCAT(Y,'-', M,'-',D), '%Y-%m-%d')  BETWEEN DATE_FORMAT('2013-05-30', '%Y-%m-%d') AND DATE_FORMAT('2013-06-02', '%Y-%m-%d')
	function getLogRefererList($db, $op, $param) {
		$column['OP_LIST']		= "*, COUNT(*) AS CNT";
		$column['OP_LIST2']		= "*";
		$column['OP_COUNT']		= "*, COUNT(*) AS CNT";
		$column['OP_COUNT2']	= "COUNT(*)";
		$column['OP_SELECT']	= "*, COUNT(*) AS CNT";

		if(!$op)			{ return; }

		$from	= "LOG_REFERER_2013";
		$query	= "SELECT {$column[$op]} FROM {$from} AS LR";
		$where	= "WHERE LR.NO IS NOT NULL";

		if($param['NO']):
			$where = "{$where} AND LR.NO = {$param['NO']}";
		endif;

		if($param['HOST']):
			$where = "{$where} AND LR.HOST = '{$param['HOST']}'";
		endif;

		if($param['HOST_LIKE']):
			$where = "{$where} AND LR.HOST LIKE '{$param['HOST_LIKE']}%'";
		endif;

		if($param['KEYWORD']):
			$where = "{$where} AND LR.KEYWORD = '{$param['KEYWORD']}'";
		endif;

		if($param['KEYWORD_IS_NOT_NULL'] == "Y"):
			$where = "{$where} AND KEYWORD IS NOT NULL AND KEYWORD != ''";
		endif;

		if($param['YMD_START'] && $param['YMD_END']):
			$where = "{$where} AND DATE_FORMAT(CONCAT(Y,'-', M,'-',D), '%Y-%m-%d') BETWEEN DATE_FORMAT('{$param['YMD_START']}', '%Y-%m-%d') AND DATE_FORMAT('{$param['YMD_END']}', '%Y-%m-%d')";
		endif;

		if($param['GROUP_BY']):
			$group_by	= "GROUP BY {$param['GROUP_BY']}";
		endif;

		if($param['ORDER_BY']):
			$order_by	= "ORDER BY {$param['ORDER_BY']}";
		endif;

		if($param['LIMIT']):
			$limit		= "LIMIT {$param['LIMIT']}";
		endif;
		
		$query = "{$query} {$where} {$group_by} {$order_by} {$limit}";

		if($op == "OP_COUNT"):
			$query = "SELECT COUNT(*) FROM ({$query}) AS MAIN_QUERY";
		endif;

		return $this->getSelectQuery($db, $query, $op);
	}

	function getOrderMainStatics($db){
		
		$query  = "SELECT                                                                                                            ";
		$query .= "     SUM(CASE WHEN A.O_STATUS NOT IN ('C','R','T') AND A.O_MONTH = '01' THEN A.O_TOT_SPRICE ELSE 0 END) 01_PRICE1                ";
		$query .= "    ,SUM(CASE WHEN A.O_STATUS NOT IN ('C','R','T') AND A.O_MONTH = '02' THEN A.O_TOT_SPRICE ELSE 0 END) 02_PRICE1                ";
		$query .= "    ,SUM(CASE WHEN A.O_STATUS NOT IN ('C','R','T') AND A.O_MONTH = '03' THEN A.O_TOT_SPRICE ELSE 0 END) 03_PRICE1                ";
		$query .= "    ,SUM(CASE WHEN A.O_STATUS NOT IN ('C','R','T') AND A.O_MONTH = '04' THEN A.O_TOT_SPRICE ELSE 0 END) 04_PRICE1                ";
		$query .= "    ,SUM(CASE WHEN A.O_STATUS NOT IN ('C','R','T') AND A.O_MONTH = '05' THEN A.O_TOT_SPRICE ELSE 0 END) 05_PRICE1                ";
		$query .= "    ,SUM(CASE WHEN A.O_STATUS NOT IN ('C','R','T') AND A.O_MONTH = '06' THEN A.O_TOT_SPRICE ELSE 0 END) 06_PRICE1                ";
		$query .= "    ,SUM(CASE WHEN A.O_STATUS NOT IN ('C','R','T') AND A.O_MONTH = '07' THEN A.O_TOT_SPRICE ELSE 0 END) 07_PRICE1                ";
		$query .= "    ,SUM(CASE WHEN A.O_STATUS NOT IN ('C','R','T') AND A.O_MONTH = '08' THEN A.O_TOT_SPRICE ELSE 0 END) 08_PRICE1                ";
		$query .= "    ,SUM(CASE WHEN A.O_STATUS NOT IN ('C','R','T') AND A.O_MONTH = '09' THEN A.O_TOT_SPRICE ELSE 0 END) 09_PRICE1                ";
		$query .= "    ,SUM(CASE WHEN A.O_STATUS NOT IN ('C','R','T') AND A.O_MONTH = '10' THEN A.O_TOT_SPRICE ELSE 0 END) 10_PRICE1                ";
		$query .= "    ,SUM(CASE WHEN A.O_STATUS NOT IN ('C','R','T') AND A.O_MONTH = '11' THEN A.O_TOT_SPRICE ELSE 0 END) 11_PRICE1                ";
		$query .= "    ,SUM(CASE WHEN A.O_STATUS NOT IN ('C','R','T') AND A.O_MONTH = '12' THEN A.O_TOT_SPRICE ELSE 0 END) 12_PRICE1                ";
		$query .= "    ,SUM(CASE WHEN A.O_STATUS IN ('C','R','T') AND A.O_MONTH = '01' THEN A.O_TOT_SPRICE ELSE 0 END) 01_PRICE2               ";
		$query .= "    ,SUM(CASE WHEN A.O_STATUS IN ('C','R','T') AND A.O_MONTH = '02' THEN A.O_TOT_SPRICE ELSE 0 END) 02_PRICE2               ";
		$query .= "    ,SUM(CASE WHEN A.O_STATUS IN ('C','R','T') AND A.O_MONTH = '03' THEN A.O_TOT_SPRICE ELSE 0 END) 03_PRICE2               ";
		$query .= "    ,SUM(CASE WHEN A.O_STATUS IN ('C','R','T') AND A.O_MONTH = '04' THEN A.O_TOT_SPRICE ELSE 0 END) 04_PRICE2               ";
		$query .= "    ,SUM(CASE WHEN A.O_STATUS IN ('C','R','T') AND A.O_MONTH = '05' THEN A.O_TOT_SPRICE ELSE 0 END) 05_PRICE2               ";
		$query .= "    ,SUM(CASE WHEN A.O_STATUS IN ('C','R','T') AND A.O_MONTH = '06' THEN A.O_TOT_SPRICE ELSE 0 END) 06_PRICE2               ";
		$query .= "    ,SUM(CASE WHEN A.O_STATUS IN ('C','R','T') AND A.O_MONTH = '07' THEN A.O_TOT_SPRICE ELSE 0 END) 07_PRICE2               ";
		$query .= "    ,SUM(CASE WHEN A.O_STATUS IN ('C','R','T') AND A.O_MONTH = '08' THEN A.O_TOT_SPRICE ELSE 0 END) 08_PRICE2               ";
		$query .= "    ,SUM(CASE WHEN A.O_STATUS IN ('C','R','T') AND A.O_MONTH = '09' THEN A.O_TOT_SPRICE ELSE 0 END) 09_PRICE2               ";
		$query .= "    ,SUM(CASE WHEN A.O_STATUS IN ('C','R','T') AND A.O_MONTH = '10' THEN A.O_TOT_SPRICE ELSE 0 END) 10_PRICE2               ";
		$query .= "    ,SUM(CASE WHEN A.O_STATUS IN ('C','R','T') AND A.O_MONTH = '11' THEN A.O_TOT_SPRICE ELSE 0 END) 11_PRICE2               ";
		$query .= "    ,SUM(CASE WHEN A.O_STATUS IN ('C','R','T') AND A.O_MONTH = '12' THEN A.O_TOT_SPRICE ELSE 0 END) 12_PRICE2               ";
		$query .= "                                                                                                                  ";
		$query .= "FROM                                                                                                              ";
		$query .= "(                                                                                                                 ";
		$query .= "    SELECT                                                                                                        ";
		$query .= "         SUBSTRING(A.O_REG_DT,6,2) O_MONTH                                                                        ";
		$query .= "        ,A.O_STATUS                                                                                               ";
		$query .= "        ,SUM(A.O_TOT_SPRICE) O_TOT_SPRICE                                                                         ";
		$query .= "    FROM ".TBL_ORDER_MGR." A                                                                                      ";
		$query .= "    WHERE A.O_STATUS IN ('J','O','A','B','I','D','E','C','R','T')												";
		$query .= "        AND SUBSTRING(A.O_REG_DT,1,4) = SUBSTRING(NOW(),1,4)                                                      ";
		$query .= "    GROUP BY SUBSTRING(A.O_REG_DT,6,2),A.O_STATUS                                                                ";
		$query .= ") A                                                                                                               ";


		return $db->getArrayTotal($query);
	
	}

	function getOrderYearMonthDayList($db,$param)
	{
		$query  = "SELECT                                                                               ";
		$query .= "    A.*                                                                              ";
		$query .= "FROM                                                                                 ";
		$query .= "(                                                                                    ";
		$query .= "    SELECT                                                                           ";
		
		if ($this->getSearchGroupMode() == "M"){
			$query .= "     SUBSTRING(O_REG_DT,1,7)	S_DATE												";
		}

		if ($this->getSearchGroupMode() == "D"){
			$query .= "     SUBSTRING(O_REG_DT,1,10)	S_DATE												";
		}

		$query .= "        ,SUM(A.O_TOT_CUR_SPRICE) S_TOT_SPRICE                                            "; //실결제금액(배송비포함)
		$query .= "        ,SUM(A.O_TOT_CUR_PRICE + A.O_TOT_DELIVERY_CUR_PRICE) S_TOT_PRICE                 "; //총주문금액
		$query .= "        ,SUM(A.O_USE_CUR_POINT) S_TOT_USE_POINT                                          "; //사용포인트
		$query .= "        ,SUM(A.O_USE_CUR_COUPON) S_TOT_COUPON		                                    "; //사용쿠폰금액
		$query .= "        ,SUM(A.O_TOT_CUR_POINT) S_TOT_POINT                                              "; //적립포인트
		$query .= "        ,SUM(A.O_TOT_DELIVERY_CUR_PRICE) S_TOT_DELIVERY_PRICE                            "; //총배송비
		$query .= "        ,SUM(A.O_TOT_MEM_DISCOUNT_CUR_PRICE) S_TOT_MEM_DISCOUNT_PRICE                    "; //총할인금액

			
		if ($this->getSearchShop()){
		
			$query .= "    FROM (															";
			$query .= "			SELECT														";
			$query .= "				 A.O_REG_DT												";
			$query .= "				,A.O_SETTLE												";
			$query .= "             ,A.O_STATUS												";
			$query .= "             ,(B.SO_TOT_CUR_SPRICE) O_TOT_CUR_SPRICE					";
			$query .= "             ,(B.SO_TOT_CUR_SPRICE) O_TOT_CUR_PRICE					";
			$query .= "             ,0 O_USE_CUR_POINT										";
			$query .= "             ,0 O_USE_CUR_COUPON										";	
			$query .= "             ,0 O_TOT_CUR_POINT										";
			$query .= "             ,B.SO_TOT_DELIVERY_CUR_PRICE O_TOT_DELIVERY_CUR_PRICE	";
			$query .= "             ,0 O_TOT_MEM_DISCOUNT_CUR_PRICE							";
			$query .= "             ,A.M_NO													";
			$query .= "         FROM ORDER_MGR A											";
			$query .= "         JOIN SHOP_ORDER B											";
			$query .= "         ON A.O_NO = B.O_NO											";
			if ($this->getSearchShop() == -1) $query .= "         WHERE B.SH_NO  IN (0)		";
			else $query .= "         WHERE B.SH_NO  IN ( ".$this->getSearchShop().")		";

			$query .= "    ) A																";

		} else {
			$query .= "    FROM ".TBL_ORDER_MGR." A                                         ";				
		}

		if ($param['M_CATE'] || $param['M_CATE_LIST'] == "Y"){
			$query .= " JOIN ";
			$query .= " (	 ";
			$query .= "		SELECT M_NO FROM ".TBL_MEMBER_CATE."		";
			$query .= "		WHERE M_NO IS NOT NULL						";
			
			if ($param['M_CATE_LIST'] == "Y"){
				if ($param['M_CATE_LIST_DATA']) {
				
					$strMemberCateQry = str_replace(","," OR ",$param['M_CATE_LIST_DATA']);
					
					$query .= " AND (		";
					$query .= $strMemberCateQry;
					$query .= " )			";
					
				} else {
				
					$query .= " AND C_CODE IN (	";
					$query .= "		SELECT C_CODE FROM ".TBL_MEMBER_CATE." WHERE M_NO = {$param['M_NO']}	";
					$query .= " )				";
				}
			} 
			
			if ($param['M_CATE']){
				$query .= "     AND C_CODE LIKE '{$param['M_CATE']}%'	";
			}

			$query .= "     GROUP BY M_NO								";
			$query .= " ) MC											";
			$query .= " ON A.M_NO = MC.M_NO								";
		}

		$query .= "    WHERE A.O_STATUS = 'E'                                               ";
				
		if ($this->getSearchRegStartDt() && $this->getSearchRegEndDt()){
			$query .= "	AND A.O_REG_DT BETWEEN DATE_FORMAT('".mysql_real_escape_string($this->getSearchRegStartDt())."','%Y-%m-%d 00:00:00') ";
			$query .= "	AND DATE_FORMAT('".mysql_real_escape_string($this->getSearchRegEndDt())."','%Y-%m-%d 23:59:59') ";		
		}

		if ($this->getSearchSettleC() || $this->getSearchSettleA() || $this->getSearchSettleT() || $this->getSearchSettleB() || $this->getSearchSettleY() || $this->getSearchSettleX()){
			
			$strSearchSettle = "";
			if ($this->getSearchSettleC() == "Y") $strSearchSettle .= "'C',";
			if ($this->getSearchSettleA() == "Y") $strSearchSettle .= "'A',";
			if ($this->getSearchSettleT() == "Y") $strSearchSettle .= "'T',";
			if ($this->getSearchSettleB() == "Y") $strSearchSettle .= "'B',";
			if ($this->getSearchSettleY() == "Y") $strSearchSettle .= "'Y',";
			if ($this->getSearchSettleX() == "Y") $strSearchSettle .= "'X',";
			
			if ($strSearchSettle){
				$query .= " AND A.O_SETTLE IN (".SUBSTR($strSearchSettle,0,STRLEN($strSearchSettle)-1).")";
			}
		}
		
		$query .= "    GROUP BY ";
		
		if ($this->getSearchGroupMode() == "M"){
			$query .= "SUBSTRING(O_REG_DT,1,7)	";
		}

		if ($this->getSearchGroupMode() == "D"){
			$query .= "SUBSTRING(O_REG_DT,1,10)	";
		}
		
		
		$query .= ") A                                                                                  ";

		
		return $db->getArrayTotal($query);
	}

	function getOrderYearQuarterList($db,$param)
	{
		$query  = "SELECT                                                                                                                      ";
		$query .= "     SUBSTRING(A.S_DATE,1,4) S_DATE                                                                                         ";
		
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.S_DATE,6,2) IN ('01','02','03') THEN A.S_TOT_SPRICE ELSE 0 END) S_TOT_SPRICE1                 ";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.S_DATE,6,2) IN ('04','05','06') THEN A.S_TOT_SPRICE ELSE 0 END) S_TOT_SPRICE2                 ";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.S_DATE,6,2) IN ('07','08','09') THEN A.S_TOT_SPRICE ELSE 0 END) S_TOT_SPRICE3                 ";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.S_DATE,6,2) IN ('10','11','12') THEN A.S_TOT_SPRICE ELSE 0 END) S_TOT_SPRICE4                 ";

		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.S_DATE,6,2) IN ('01','02','03') THEN A.S_TOT_PRICE ELSE 0 END) S_TOT_PRICE1                 ";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.S_DATE,6,2) IN ('04','05','06') THEN A.S_TOT_PRICE ELSE 0 END) S_TOT_PRICE2                 ";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.S_DATE,6,2) IN ('07','08','09') THEN A.S_TOT_PRICE ELSE 0 END) S_TOT_PRICE3                 ";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.S_DATE,6,2) IN ('10','11','12') THEN A.S_TOT_PRICE ELSE 0 END) S_TOT_PRICE4                 ";

		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.S_DATE,6,2) IN ('01','02','03') THEN A.S_TOT_USE_POINT ELSE 0 END) S_TOT_USE_POINT1                 ";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.S_DATE,6,2) IN ('04','05','06') THEN A.S_TOT_USE_POINT ELSE 0 END) S_TOT_USE_POINT2                 ";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.S_DATE,6,2) IN ('07','08','09') THEN A.S_TOT_USE_POINT ELSE 0 END) S_TOT_USE_POINT3                 ";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.S_DATE,6,2) IN ('10','11','12') THEN A.S_TOT_USE_POINT ELSE 0 END) S_TOT_USE_POINT4                 ";

		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.S_DATE,6,2) IN ('01','02','03') THEN A.S_TOT_COUPON ELSE 0 END) S_TOT_COUPON1                 ";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.S_DATE,6,2) IN ('04','05','06') THEN A.S_TOT_COUPON ELSE 0 END) S_TOT_COUPON2                 ";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.S_DATE,6,2) IN ('07','08','09') THEN A.S_TOT_COUPON ELSE 0 END) S_TOT_COUPON3                 ";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.S_DATE,6,2) IN ('10','11','12') THEN A.S_TOT_COUPON ELSE 0 END) S_TOT_COUPON4                 ";

		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.S_DATE,6,2) IN ('01','02','03') THEN A.S_TOT_COUPON ELSE 0 END) S_TOT_COUPON1                 ";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.S_DATE,6,2) IN ('04','05','06') THEN A.S_TOT_COUPON ELSE 0 END) S_TOT_COUPON2                 ";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.S_DATE,6,2) IN ('07','08','09') THEN A.S_TOT_COUPON ELSE 0 END) S_TOT_COUPON3                 ";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.S_DATE,6,2) IN ('10','11','12') THEN A.S_TOT_COUPON ELSE 0 END) S_TOT_COUPON4                 ";

		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.S_DATE,6,2) IN ('01','02','03') THEN A.S_TOT_POINT ELSE 0 END) S_TOT_POINT1                 ";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.S_DATE,6,2) IN ('04','05','06') THEN A.S_TOT_POINT ELSE 0 END) S_TOT_POINT2                 ";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.S_DATE,6,2) IN ('07','08','09') THEN A.S_TOT_POINT ELSE 0 END) S_TOT_POINT3                 ";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.S_DATE,6,2) IN ('10','11','12') THEN A.S_TOT_POINT ELSE 0 END) S_TOT_POINT4                 ";

		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.S_DATE,6,2) IN ('01','02','03') THEN A.S_TOT_DELIVERY_PRICE ELSE 0 END) S_TOT_DELIVERY_PRICE1                 ";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.S_DATE,6,2) IN ('04','05','06') THEN A.S_TOT_DELIVERY_PRICE ELSE 0 END) S_TOT_DELIVERY_PRICE2                 ";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.S_DATE,6,2) IN ('07','08','09') THEN A.S_TOT_DELIVERY_PRICE ELSE 0 END) S_TOT_DELIVERY_PRICE3                 ";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.S_DATE,6,2) IN ('10','11','12') THEN A.S_TOT_DELIVERY_PRICE ELSE 0 END) S_TOT_DELIVERY_PRICE4                 ";

		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.S_DATE,6,2) IN ('01','02','03') THEN A.S_TOT_MEM_DISCOUNT_PRICE ELSE 0 END) S_TOT_MEM_DISCOUNT_PRICE1                 ";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.S_DATE,6,2) IN ('04','05','06') THEN A.S_TOT_MEM_DISCOUNT_PRICE ELSE 0 END) S_TOT_MEM_DISCOUNT_PRICE2                 ";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.S_DATE,6,2) IN ('07','08','09') THEN A.S_TOT_MEM_DISCOUNT_PRICE ELSE 0 END) S_TOT_MEM_DISCOUNT_PRICE3                 ";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.S_DATE,6,2) IN ('10','11','12') THEN A.S_TOT_MEM_DISCOUNT_PRICE ELSE 0 END) S_TOT_MEM_DISCOUNT_PRICE4                 ";

		$query .= "FROM                                                                                                                        ";
		$query .= "(                                                                                                                           ";
		$query .= "    SELECT                                                                                                                  ";
		$query .= "         SUBSTRING(O_REG_DT,1,7) S_DATE                                                                                     ";
		$query .= "        ,SUM(A.O_TOT_CUR_SPRICE) S_TOT_SPRICE                                                                               ";
		$query .= "        ,SUM(A.O_TOT_CUR_PRICE + A.O_TOT_DELIVERY_CUR_PRICE) S_TOT_PRICE                                                    ";
		$query .= "        ,SUM(A.O_USE_CUR_POINT) S_TOT_USE_POINT                                                                             ";
		$query .= "        ,SUM(A.O_USE_CUR_COUPON) S_TOT_COUPON		                                    "; //사용쿠폰금액
		$query .= "        ,SUM(A.O_TOT_CUR_POINT) S_TOT_POINT                                              ";
		$query .= "        ,SUM(A.O_TOT_DELIVERY_CUR_PRICE) S_TOT_DELIVERY_PRICE                            ";
		$query .= "        ,SUM(A.O_TOT_MEM_DISCOUNT_CUR_PRICE) S_TOT_MEM_DISCOUNT_PRICE                    "; //총할인금액
	
		if ($this->getSearchShop()){
		
			$query .= "    FROM (															";
			$query .= "			SELECT														";
			$query .= "				 A.O_REG_DT												";
			$query .= "				,A.O_SETTLE												";
			$query .= "             ,A.O_STATUS												";
			$query .= "             ,(B.SO_TOT_CUR_SPRICE) O_TOT_CUR_SPRICE					";
			$query .= "             ,(B.SO_TOT_CUR_SPRICE) O_TOT_CUR_PRICE					";
			$query .= "             ,0 O_USE_CUR_POINT										";
			$query .= "             ,0 O_USE_CUR_COUPON										";	
			$query .= "             ,0 O_TOT_CUR_POINT										";
			$query .= "             ,B.SO_TOT_DELIVERY_CUR_PRICE O_TOT_DELIVERY_CUR_PRICE	";
			$query .= "             ,0 O_TOT_MEM_DISCOUNT_CUR_PRICE							";
			$query .= "             ,A.M_NO													";
			$query .= "         FROM ORDER_MGR A											";
			$query .= "         JOIN SHOP_ORDER B											";
			$query .= "         ON A.O_NO = B.O_NO											";
			if ($this->getSearchShop() == -1) $query .= "         WHERE B.SH_NO  IN (0)		";
			else $query .= "         WHERE B.SH_NO  IN ( ".$this->getSearchShop().")		";

			$query .= "    ) A																";

		} else {
			$query .= "    FROM ".TBL_ORDER_MGR." A                                         ";		
		}
		
		
		if ($param['M_CATE'] || $param['M_CATE_LIST'] == "Y"){
			
			$query .= " JOIN ";
			$query .= " (	 ";
			$query .= "		SELECT M_NO FROM ".TBL_MEMBER_CATE."		";
			$query .= "		WHERE M_NO IS NOT NULL						";
			
			if ($param['M_CATE_LIST'] == "Y"){
				if ($param['M_CATE_LIST_DATA']) {
				
					$strMemberCateQry = str_replace(","," OR ",$param['M_CATE_LIST_DATA']);
					
					$query .= " AND (		";
					$query .= $strMemberCateQry;
					$query .= " )			";
					
				} else {

					$query .= " AND C_CODE IN (	";
					$query .= "		SELECT C_CODE FROM ".TBL_MEMBER_CATE." WHERE M_NO = {$param['M_NO']}	";
					$query .= " )				";
				}
			} 
			
			if ($param['M_CATE']){
				$query .= "     AND C_CODE LIKE '{$param['M_CATE']}%'	";
			}

			$query .= "     GROUP BY M_NO								";
			$query .= " ) MC											";
			$query .= " ON A.M_NO = MC.M_NO								";
		}

		$query .= "    WHERE A.O_STATUS = 'E'                                                                                                  ";
		
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
			if ($this->getSearchSettleY() == "Y") $strSearchSettle .= "'Y',";
			if ($this->getSearchSettleX() == "Y") $strSearchSettle .= "'X',";
			
			if ($strSearchSettle){
				$query .= " AND A.O_SETTLE IN (".SUBSTR($strSearchSettle,0,STRLEN($strSearchSettle)-1).")";
			}
		}		
		
		$query .= "    GROUP BY SUBSTRING(O_REG_DT,1,7)                                                                                        ";
		$query .= ") A                                                                                                                         ";
		$query .= "GROUP BY SUBSTRING(A.S_DATE,1,4)                                                                                            ";

		return $db->getArrayTotal($query);
	}
	
	function getOrderProdCateList($db,$param)
	{
		$query   = "SELECT A.* FROM (						";							
		$query  .= "SELECT									";

		if ($this->getSearchGroupMode() == "1"){
			$query .= "     SUBSTRING(B.P_CATE,1,3) CATE_CODE	";
			$query .= "    ,(SELECT CL_NAME FROM ".TBL_CATE_LNG." WHERE C_CODE = SUBSTRING(B.P_CATE,1,3) AND CL_LNG = '".$this->getLogLng()."')  CATE_NAME "; 
		} else if ($this->getSearchGroupMode() == "2"){
			$query .= "     SUBSTRING(B.P_CATE,1,6) CATE_CODE	";
			$query .= "    ,(SELECT CL_NAME FROM ".TBL_CATE_LNG." WHERE C_CODE = SUBSTRING(B.P_CATE,1,6)) AND CL_LNG = '".$this->getLogLng()."' CATE_NAME "; 
		} else if ($this->getSearchGroupMode() == "3"){
			$query .= "     SUBSTRING(B.P_CATE,1,9) CATE_CODE	";
			$query .= "    ,(SELECT CL_NAME FROM ".TBL_CATE_LNG." WHERE C_CODE = SUBSTRING(B.P_CATE,1,9)) AND CL_LNG = '".$this->getLogLng()."' CATE_NAME "; 
		} else if ($this->getSearchGroupMode() == "4"){
			$query .= "     SUBSTRING(B.P_CATE,1,12) CATE_CODE	";
			$query .= "    ,(SELECT CL_NAME FROM ".TBL_CATE_LNG." WHERE C_CODE = SUBSTRING(B.P_CATE,1,12)) AND CL_LNG = '".$this->getLogLng()."' CATE_NAME "; 
		}

		$query .= "    ,SUM(A.P_PRICE) CATE_PRICE			";
		$query .= "    ,SUM(A.P_QTY) CATE_QTY				";
		$query .= "    ,SUM(A.P_CNT) CATE_CNT				";
		$query .= "FROM										";
		$query .= "(										";
		$query .= "    SELECT								";
		$query .= "         A.P_CODE						";
		$query .= "        ,SUM((A.OC_CUR_PRICE * A.OC_QTY) + A.OC_OPT_ADD_CUR_PRICE) P_PRICE		";
		$query .= "        ,SUM(A.OC_QTY) P_QTY				";
		$query .= "        ,COUNT(*) P_CNT					";
		$query .= "    FROM ".TBL_ORDER_CART." A			";
		$query .= "    JOIN ".TBL_ORDER_MGR." B				";
		$query .= "    ON A.O_NO = B.O_NO					";
				
		if ($this->getSearchShop()){
			$query .= "    JOIN ".TBL_PRODUCT_MGR." C		";
			$query .= "    ON A.P_CODE = C.P_CODE			";
		}

		if ($param['M_CATE'] || $param['M_CATE_LIST'] == "Y"){
			$query .= " JOIN ";
			$query .= " (	 ";
			$query .= "		SELECT M_NO FROM ".TBL_MEMBER_CATE."		";
			$query .= "		WHERE M_NO IS NOT NULL						";
			
			if ($param['M_CATE_LIST'] == "Y"){
				
				if ($param['M_CATE_LIST_DATA']) {
				
					$strMemberCateQry = str_replace(","," OR ",$param['M_CATE_LIST_DATA']);
					
					$query .= " AND (		";
					$query .= $strMemberCateQry;
					$query .= " )			";
					
				} else {
				
					$query .= " AND C_CODE IN (	";
					$query .= "		SELECT C_CODE FROM ".TBL_MEMBER_CATE." WHERE M_NO = {$param['M_NO']}	";
					$query .= " )				";
				}				
								
//				$query .= " AND SUBSTRING(C_CODE,1,3) IN (	";
//				$query .= "		SELECT SUBSTRING(C_CODE,1,3) FROM ".TBL_MEMBER_CATE." WHERE M_NO = {$param['M_NO']}	";
//				$query .= " )				";
			} 
			
			if ($param['M_CATE']){
				$query .= "     AND C_CODE LIKE '{$param['M_CATE']}%'	";
			}

			$query .= "     GROUP BY M_NO								";
			$query .= " ) MC											";
			$query .= " ON B.M_NO = MC.M_NO								";
		}
		$query .= "    WHERE B.O_STATUS = 'E'				";
		$query .= "		AND A.OC_ORDER_STATUS = 'E'			";
		if ($this->getSearchRegStartDt() && $this->getSearchRegEndDt()){
			$query .= "	AND B.O_REG_DT BETWEEN DATE_FORMAT('".mysql_real_escape_string($this->getSearchRegStartDt())."','%Y-%m-%d 00:00:00') ";
			$query .= "	AND DATE_FORMAT('".mysql_real_escape_string($this->getSearchRegEndDt())."','%Y-%m-%d 23:59:59') ";		
		}

		if ($this->getSearchShop()){
			if ($this->getSearchShop() == -1) $query .= "         AND C.P_SHOP_NO IN (0)	";
			else $query .= "         AND C.P_SHOP_NO  IN ( ".$this->getSearchShop().")	";
		}

		$query .= "    GROUP BY A.P_CODE                  ";
		$query .= ") A                                    ";
		$query .= "JOIN ".TBL_PRODUCT_MGR." B             ";
		$query .= "ON A.P_CODE = B.P_CODE                 ";
			
		if ($this->getSearchGroupMode() == "1"){
			
			if ($this->getSearchHCode1()){
				$query .= "WHERE SUBSTRING(B.P_CATE,1,3) = '".$this->getSearchHCode1()."'	";
			}
						
			$query .= "GROUP BY SUBSTRING(B.P_CATE,1,3)       ";
		} else if ($this->getSearchGroupMode() == "2"){
			
			$query .= "WHERE SUBSTRING(B.P_CATE,1,6) = '".$this->getSearchHCode1().$this->getSearchHCode2()."'	";
			$query .= "GROUP BY SUBSTRING(B.P_CATE,1,6)       ";
		} else if ($this->getSearchGroupMode() == "3"){
			$query .= "WHERE SUBSTRING(B.P_CATE,1,9) = '".$this->getSearchHCode1().$this->getSearchHCode2().$this->getSearchHCode3()."'	";
			$query .= "GROUP BY SUBSTRING(B.P_CATE,1,9)       ";
		} else if ($this->getSearchGroupMode() == "4"){
			$query .= "WHERE SUBSTRING(B.P_CATE,1,12) = '".$this->getSearchHCode1().$this->getSearchHCode2().$this->getSearchHCode3().$this->getSearchHCode4()."'	";
			$query .= "GROUP BY SUBSTRING(B.P_CATE,1,12)       ";
		}		
		
		$query .= ") A										";


		switch($param["orderBySort"]){

			case "cateNameDesc":
				$query .= "ORDER BY A.CATE_NAME DESC		";
			break;
			case "cateNameAsc":
				$query .= "ORDER BY A.CATE_NAME ASC			";
			break;
			
			case "orderCntDesc":
				$query .= "ORDER BY A.CATE_CNT DESC			";
			break;
			case "orderCntAsc":
				$query .= "ORDER BY A.CATE_CNT ASC			";
			break;
			
			case "orderPriceDesc":
				$query .= "ORDER BY A.CATE_PRICE DESC		";
			break;
			case "orderPriceAsc":
				$query .= "ORDER BY A.CATE_PRICE ASC		";
			break;

			case "orderQtyDesc":
				$query .= "ORDER BY A.CATE_QTY DESC			";
			break;
			case "orderQtyAsc":
				$query .= "ORDER BY A.CATE_QTY ASC			";
			break;

			default:
				$query .= "ORDER BY A.CATE_CODE ASC			";
			break;
		}

		return $db->getArrayTotal($query);
	}
	
	function getOrderProdList($db,$param)
	{
		
		$query  = "SELECT A.*					";
		$query .= "    ,B.PM_REAL_NAME P_IMG_PATH	";
		$query .= "FROM (						";
		$query .= "SELECT                       ";
		$query .= "     A.P_CODE                ";
		$query .= "    ,MAX(C.P_NAME) P_NAME	";
		$query .= "    ,SUM((A.OC_CUR_PRICE * A.OC_QTY) + A.OC_OPT_ADD_CUR_PRICE) P_PRICE	";
		$query .= "    ,SUM(A.OC_QTY) P_QTY     ";
		$query .= "    ,COUNT(*) P_CNT          ";
		$query .= "FROM ".TBL_ORDER_CART." A    ";
		$query .= "JOIN ".TBL_ORDER_MGR." B     ";
		$query .= "ON A.O_NO = B.O_NO           ";
		$query .= "JOIN ".TBL_PRODUCT_INFO_LNG.$this->getLogLng()." C   ";
		$query .= "ON A.P_CODE = C.P_CODE       ";

		if ($this->getSearchShop() || $this->getSearchProductCate()){
			$query .= "    JOIN ".TBL_PRODUCT_MGR." P		";
			$query .= "    ON A.P_CODE = P.P_CODE			";
		}

		if ($param['M_CATE'] || $param['M_CATE_LIST'] == "Y"){
			$query .= " JOIN ";
			$query .= " (	 ";
			$query .= "		SELECT M_NO FROM ".TBL_MEMBER_CATE."		";
			$query .= "		WHERE M_NO IS NOT NULL						";
			
			if ($param['M_CATE_LIST'] == "Y"){
				
				if ($param['M_CATE_LIST_DATA']) {
				
					$strMemberCateQry = str_replace(","," OR ",$param['M_CATE_LIST_DATA']);
					
					$query .= " AND (		";
					$query .= $strMemberCateQry;
					$query .= " )			";
					
				} else {
				
					$query .= " AND C_CODE IN (	";
					$query .= "		SELECT C_CODE FROM ".TBL_MEMBER_CATE." WHERE M_NO = {$param['M_NO']}	";
					$query .= " )				";
				}				
			} 
			
			if ($param['M_CATE']){
				$query .= "     AND C_CODE LIKE '{$param['M_CATE']}%'	";
			}

			$query .= "     GROUP BY M_NO								";
			$query .= " ) MC											";
			$query .= " ON B.M_NO = MC.M_NO								";
		}

		$query .= "WHERE B.O_STATUS = 'E'       ";
		$query .= "	AND A.OC_ORDER_STATUS = 'E'	";
		
		if ($this->getSearchRegStartDt() && $this->getSearchRegEndDt()){
			$query .= "	AND B.O_REG_DT BETWEEN DATE_FORMAT('".mysql_real_escape_string($this->getSearchRegStartDt())."','%Y-%m-%d 00:00:00') ";
			$query .= "	AND DATE_FORMAT('".mysql_real_escape_string($this->getSearchRegEndDt())."','%Y-%m-%d 23:59:59') ";		
		}
		
		if ($this->getSearchProductCate()){
			$query .= " AND P.P_CATE LIKE '".$this->getSearchProductCate()."%'	";
		}
		
		if ($this->getSearchShop()){
			if ($this->getSearchShop() == -1) $query .= "         AND P.P_SHOP_NO IN (0)	";
			else $query .= "         AND P.P_SHOP_NO  IN ( ".$this->getSearchShop().")	";
		}


		$query .= "GROUP BY A.P_CODE            ";
		$query .= ") A							";
		
		$query .= "JOIN ".PRODUCT_IMG." B       ";
		$query .= "ON A.P_CODE = B.P_CODE       ";
		$query .= "AND B.PM_TYPE = 'list'       ";

		switch($param["orderBySort"]){

			case "prodNameDesc":
				$query .= "ORDER BY A.P_NAME DESC		";
			break;
			case "prodNameAsc":
				$query .= "ORDER BY A.P_NAME ASC		";
			break;
			
			case "orderCntDesc":
				$query .= "ORDER BY A.P_CNT DESC		";
			break;
			case "orderCntAsc":
				$query .= "ORDER BY A.P_CNT ASC			";
			break;
			
			case "orderPriceDesc":
				$query .= "ORDER BY A.P_PRICE DESC		";
			break;
			case "orderPriceAsc":
				$query .= "ORDER BY A.P_PRICE ASC		";
			break;

			case "orderQtyDesc":
				$query .= "ORDER BY A.P_QTY DESC		";
			break;
			case "orderQtyAsc":
				$query .= "ORDER BY A.P_QTY ASC			";
			break;

			default:
				$query .= "ORDER BY A.P_PRICE DESC		";
			break;
		}

		//echo $query;
		//exit;
		return $db->getArrayTotal($query);

	}

	function getProductBasketList($db,$param){
		
		$query  = "SELECT A.* FROM (												";
		$query .= "SELECT															";
		$query .= "     A.P_CODE													";
		$query .= "    ,MAX(B.P_NAME) P_NAME										";		
		$query .= "    ,SUM(A.PB_QTY) P_QTY											";
		$query .= "    ,SUM(A.PB_PRICE) P_PRICE										";
		$query .= "    ,SUM(CASE WHEN A.M_NO > 0 THEN 1 ELSE 0 END) P_MEM_CNT		";
		$query .= "    ,SUM(CASE WHEN A.M_NO = 0 THEN 1 ELSE 0 END) P_NON_MEM_CNT	";
		$query .= "    ,MAX(C.PM_REAL_NAME) P_IMG_PATH								";
		$query .= "FROM ".TBL_PRODUCT_BASKET." A									";
		$query .= "JOIN ".TBL_PRODUCT_INFO_LNG.$this->getLogLng()." B										";
		$query .= "ON A.P_CODE = B.P_CODE											";
		$query .= "JOIN ".PRODUCT_IMG." C       ";
		$query .= "ON A.P_CODE = C.P_CODE       ";
		$query .= "AND C.PM_TYPE = 'list'       ";

		if ($this->getSearchShop()){
			$query .= " JOIN ".TBL_PRODUCT_MGR." P	";
			$query .= " ON A.P_CODE = P.P_CODE		";
		}

		if ($param['M_CATE']){
			$query .= " JOIN (";
			$query .= "		SELECT M_NO FROM ".TBL_MEMBER_CATE."		";
			$query .= "     WHERE C_CODE LIKE '{$param['M_CATE']}%'		";
			$query .= "     GROUP BY M_NO								";
			$query .= " ) MC											";
			$query .= " ON A.M_NO = MC.M_NO								";
		}

		$query .= "WHERE A.PB_NO IS NOT NULL										";

		if ($this->getSearchProductCate()){
			$qeury .= " AND B.P_CATE LIKE '".$this->getSearchProductCate()."%'		";
		}
		
		if ($this->getSearchRegStartDt() && $this->getSearchRegEndDt()){
			$query .= "	AND A.PB_REG_DT BETWEEN DATE_FORMAT('".mysql_real_escape_string($this->getSearchRegStartDt())."','%Y-%m-%d 00:00:00') ";
			$query .= "	AND DATE_FORMAT('".mysql_real_escape_string($this->getSearchRegEndDt())."','%Y-%m-%d 23:59:59') ";		
		}

		if ($this->getSearchShop()){
			if ($this->getSearchShop() == -1) $query .= "         AND P.P_SHOP_NO IN (0)	";
			else $query .= "         AND P.P_SHOP_NO  IN ( ".$this->getSearchShop().")		";
		}
			
		$query .= "GROUP BY A.P_CODE                    ";
		$query .= ") A									";


		switch($param["orderBySort"]){

			case "prodNameDesc":
				$query .= "ORDER BY A.P_NAME DESC		";
			break;
			case "prodNameAsc":
				$query .= "ORDER BY A.P_NAME ASC		";
			break;
			
			case "orderPriceDesc":
				$query .= "ORDER BY A.P_PRICE DESC		";
			break;
			case "orderPriceAsc":
				$query .= "ORDER BY A.P_PRICE ASC		";
			break;

			case "orderQtyDesc":
				$query .= "ORDER BY A.P_QTY DESC		";
			break;
			case "orderQtyAsc":
				$query .= "ORDER BY A.P_QTY ASC			";
			break;

			default:
				$query .= "ORDER BY A.P_PRICE DESC		";
			break;
		}

		return $db->getArrayTotal($query);
	}

	function getProductWishList($db,$param){
		
		$query  = "SELECT A.* FROM (												";
		$query .= "SELECT															";
		$query .= "     A.P_CODE													";
		$query .= "    ,MAX(B.P_NAME) P_NAME										";		
		$query .= "    ,SUM(A.PW_QTY) P_QTY											";
		$query .= "    ,SUM(A.PW_PRICE) P_PRICE										";
		$query .= "    ,SUM(CASE WHEN A.M_NO > 0 THEN 1 ELSE 0 END) P_MEM_CNT		";
		$query .= "    ,SUM(CASE WHEN A.M_NO = 0 THEN 1 ELSE 0 END) P_NON_MEM_CNT	";
		$query .= "    ,MAX(C.PM_REAL_NAME) P_IMG_PATH								";
		$query .= "FROM ".TBL_PRODUCT_WISH." A										";
		$query .= "JOIN ".TBL_PRODUCT_INFO_LNG.$this->getLogLng()." B				";
		$query .= "ON A.P_CODE = B.P_CODE											";
		$query .= "JOIN ".PRODUCT_IMG." C       ";
		$query .= "ON A.P_CODE = C.P_CODE       ";
		$query .= "AND C.PM_TYPE = 'list'       ";

		if ($this->getSearchShop()){
			$query .= " JOIN ".TBL_PRODUCT_MGR." P	";
			$query .= " ON A.P_CODE = P.P_CODE		";
		}

		if ($param['M_CATE'] || $param['M_CATE_LIST'] == "Y"){
			$query .= " JOIN ";
			$query .= " (	 ";
			$query .= "		SELECT M_NO FROM ".TBL_MEMBER_CATE."		";
			$query .= "		WHERE M_NO IS NOT NULL						";
			
			if ($param['M_CATE_LIST'] == "Y"){
				if ($param['M_CATE_LIST_DATA']) {
				
					$strMemberCateQry = str_replace(","," OR ",$param['M_CATE_LIST_DATA']);
					
					$query .= " AND (		";
					$query .= $strMemberCateQry;
					$query .= " )			";
					
				} else {
				
					$query .= " AND C_CODE IN (	";
					$query .= "		SELECT C_CODE FROM ".TBL_MEMBER_CATE." WHERE M_NO = {$param['M_NO']}	";
					$query .= " )				";
				}
			} 
			
			if ($param['M_CATE']){
				$query .= "     AND C_CODE LIKE '{$param['M_CATE']}%'	";
			}

			$query .= "     GROUP BY M_NO								";
			$query .= " ) MC											";
			$query .= " ON A.M_NO = MC.M_NO								";
		}

		$query .= "WHERE A.PW_NO IS NOT NULL										";

		if ($this->getSearchProductCate()){
			$qeury .= " AND B.P_CATE LIKE '".$this->getSearchProductCate()."%'		";
		}
		
		if ($this->getSearchRegStartDt() && $this->getSearchRegEndDt()){
			$query .= "	AND A.PW_REG_DT BETWEEN DATE_FORMAT('".mysql_real_escape_string($this->getSearchRegStartDt())."','%Y-%m-%d 00:00:00') ";
			$query .= "	AND DATE_FORMAT('".mysql_real_escape_string($this->getSearchRegEndDt())."','%Y-%m-%d 23:59:59') ";		
		}

		if ($this->getSearchShop()){
			if ($this->getSearchShop() == -1) $query .= "         AND P.P_SHOP_NO IN (0)	";
			else $query .= "         AND P.P_SHOP_NO  IN ( ".$this->getSearchShop().")		";
		}
			
		$query .= "GROUP BY A.P_CODE                    ";
		$query .= ") A									";
		switch($param["orderBySort"]){

			case "prodNameDesc":
				$query .= "ORDER BY A.P_NAME DESC		";
			break;
			case "prodNameAsc":
				$query .= "ORDER BY A.P_NAME ASC		";
			break;
			
			case "orderPriceDesc":
				$query .= "ORDER BY A.P_PRICE DESC		";
			break;
			case "orderPriceAsc":
				$query .= "ORDER BY A.P_PRICE ASC		";
			break;

			case "orderQtyDesc":
				$query .= "ORDER BY A.P_QTY DESC		";
			break;
			case "orderQtyAsc":
				$query .= "ORDER BY A.P_QTY ASC			";
			break;

			default:
				$query .= "ORDER BY A.P_PRICE DESC		";
			break;
		}
		return $db->getArrayTotal($query);
	}

	function getOrderDayList($db,$param)
	{
		$query  = "SELECT                                                                               ";
		
		if ($this->getSearchGroupMode() == "D"){
			$query .= "     SUBSTRING(A.O_REG_DT,1,10) O_REG_DT                                         ";
		} else if ($this->getSearchGroupMode() == "M"){
			$query .= "     SUBSTRING(A.O_REG_DT,1,7) O_REG_DT                                         ";
		}
		
		$query .= "    ,SUM(CASE WHEN A.O_STATUS = 'J' THEN 1 ELSE 0 END) O_STATUS_CNT1                 ";
		$query .= "    ,SUM(CASE WHEN A.O_STATUS = 'J' THEN (IFNULL(A.O_TOT_CUR_PRICE,0) + IFNULL(A.O_TOT_DELIVERY_CUR_PRICE,0)) ELSE 0 END) O_STATUS_PRICE1	";
		$query .= "    ,SUM(CASE WHEN A.O_STATUS = 'A' THEN 1 ELSE 0 END) O_STATUS_CNT2                 ";
		$query .= "    ,SUM(CASE WHEN A.O_STATUS = 'A' THEN (IFNULL(A.O_TOT_CUR_PRICE,0) + IFNULL(A.O_TOT_DELIVERY_CUR_PRICE,0)) ELSE 0 END) O_STATUS_PRICE2	";
		$query .= "    ,SUM(CASE WHEN A.O_STATUS = 'B' THEN 1 ELSE 0 END) O_STATUS_CNT3                 ";
		$query .= "    ,SUM(CASE WHEN A.O_STATUS = 'B' THEN (IFNULL(A.O_TOT_CUR_PRICE,0) + IFNULL(A.O_TOT_DELIVERY_CUR_PRICE,0)) ELSE 0 END) O_STATUS_PRICE3	";
		$query .= "    ,SUM(CASE WHEN A.O_STATUS = 'I' THEN 1 ELSE 0 END) O_STATUS_CNT4                 ";
		$query .= "    ,SUM(CASE WHEN A.O_STATUS = 'I' THEN (IFNULL(A.O_TOT_CUR_PRICE,0) + IFNULL(A.O_TOT_DELIVERY_CUR_PRICE,0)) ELSE 0 END) O_STATUS_PRICE4	";
		$query .= "    ,SUM(CASE WHEN A.O_STATUS = 'D' THEN 1 ELSE 0 END) O_STATUS_CNT5                 ";
		$query .= "    ,SUM(CASE WHEN A.O_STATUS = 'D' THEN (IFNULL(A.O_TOT_CUR_PRICE,0) + IFNULL(A.O_TOT_DELIVERY_CUR_PRICE,0)) ELSE 0 END) O_STATUS_PRICE5	";
		
		if ($this->getSearchShop()){
		$query .= "    ,SUM(CASE WHEN A.SO_ORDER_STATUS = 'E' THEN 1 ELSE 0 END) O_STATUS_CNT6                 ";
		$query .= "    ,SUM(CASE WHEN A.SO_ORDER_STATUS = 'E' THEN (IFNULL(A.O_TOT_CUR_PRICE,0) + IFNULL(A.O_TOT_DELIVERY_CUR_PRICE,0)) ELSE 0 END) O_STATUS_PRICE6	";
		} else {
		$query .= "    ,SUM(CASE WHEN A.O_STATUS = 'E' THEN 1 ELSE 0 END) O_STATUS_CNT6                 ";
		$query .= "    ,SUM(CASE WHEN A.O_STATUS = 'E' THEN (IFNULL(A.O_TOT_CUR_PRICE,0) + IFNULL(A.O_TOT_DELIVERY_CUR_PRICE,0)) ELSE 0 END) O_STATUS_PRICE6	";
		}

		$query .= "    ,SUM(CASE WHEN A.O_STATUS = 'C' THEN 1 ELSE 0 END) O_STATUS_CNT7                 ";
		$query .= "    ,SUM(CASE WHEN A.O_STATUS = 'C' THEN (IFNULL(A.O_TOT_CUR_PRICE,0) + IFNULL(A.O_TOT_DELIVERY_CUR_PRICE,0)) ELSE 0 END) O_STATUS_PRICE7	";

		if ($this->getSearchShop()){
		
			$query .= "    FROM (															";
			$query .= "			SELECT														";
			$query .= "				 A.O_REG_DT												";
			$query .= "				,A.O_SETTLE												";
			$query .= "             ,A.O_STATUS												";
			$query .= "             ,(B.SO_TOT_CUR_SPRICE) O_TOT_CUR_SPRICE					";
			$query .= "             ,(B.SO_TOT_CUR_SPRICE) O_TOT_CUR_PRICE					";
			$query .= "             ,0 O_USE_CUR_POINT										";
			$query .= "             ,0 O_USE_CUR_COUPON										";	
			$query .= "             ,0 O_TOT_CUR_POINT										";
			$query .= "             ,B.SO_TOT_DELIVERY_CUR_PRICE O_TOT_DELIVERY_CUR_PRICE	";
			$query .= "             ,0 O_TOT_MEM_DISCOUNT_CUR_PRICE							";
			$query .= "             ,A.M_NO													";
			$query .= "             ,B.SO_ORDER_STATUS										";
			$query .= "         FROM ORDER_MGR A											";
			$query .= "         JOIN SHOP_ORDER B											";
			$query .= "         ON A.O_NO = B.O_NO											";
			if ($this->getSearchShop() == -1) $query .= "         WHERE B.SH_NO  IN (0)		";
			else $query .= "         WHERE B.SH_NO  IN ( ".$this->getSearchShop().")		";

			$query .= "    ) A																";

		} else {
			$query .= "    FROM ".TBL_ORDER_MGR." A                                         ";				
		}

		if ($param['M_CATE'] || $param['M_CATE_LIST'] == "Y"){
			$query .= " JOIN ";
			$query .= " (	 ";
			$query .= "		SELECT M_NO FROM ".TBL_MEMBER_CATE."		";
			$query .= "		WHERE M_NO IS NOT NULL						";
			
			if ($param['M_CATE_LIST'] == "Y"){
				
				if ($param['M_CATE_LIST_DATA']) {
				
					$strMemberCateQry = str_replace(","," OR ",$param['M_CATE_LIST_DATA']);
					
					$query .= " AND (		";
					$query .= $strMemberCateQry;
					$query .= " )			";
					
				} else {
				
					$query .= " AND C_CODE IN (	";
					$query .= "		SELECT C_CODE FROM ".TBL_MEMBER_CATE." WHERE M_NO = {$param['M_NO']}	";
					$query .= " )				";
				}
			} 
			
			if ($param['M_CATE']){
				$query .= "     AND C_CODE LIKE '{$param['M_CATE']}%'	";
			}

			$query .= "     GROUP BY M_NO								";
			$query .= " ) MC											";
			$query .= " ON A.M_NO = MC.M_NO								";
		}


		$query .= "WHERE A.O_STATUS IN ('J','A','B','I','D','E','C')                                    ";
		
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
			if ($this->getSearchSettleY() == "Y") $strSearchSettle .= "'Y',";
			if ($this->getSearchSettleX() == "Y") $strSearchSettle .= "'X',";
			
			if ($strSearchSettle){
				$query .= " AND A.O_SETTLE IN (".SUBSTR($strSearchSettle,0,STRLEN($strSearchSettle)-1).")	";
			}
		}	
		
		if ($this->getSearchGroupMode() == "D"){
			$query .= "GROUP BY SUBSTRING(A.O_REG_DT,1,10)                                                  ";
		} else if ($this->getSearchGroupMode() == "M"){
			$query .= "GROUP BY SUBSTRING(A.O_REG_DT,1,7)													";
		}
		return $db->getArrayTotal($query);
	}

	function getOrderProdStatusList($db,$param)
	{
		$query  = "SELECT                                                                   ";
		$query .= "     A.*                                                                 ";
		$query .= "    ,BI.P_NAME                                                           ";
		$query .= "    ,B.P_SALE_PRICE                                                      ";
		$query .= "    ,C.PM_REAL_NAME P_IMG_PATH                                           ";
		$query .= "FROM                                                                     ";
		$query .= "(                                                                        ";
		$query .= "    SELECT                                                               ";
		$query .= "         OC.P_CODE                                                       ";
		$query .= "        ,SUM(OC.OC_QTY) O_STATUS_CNT                                           ";
//		$query .= "        ,SUM(OC.OC_CUR_PRICE) O_STATUS_PRICE								"; // 2015.01.07 kim hee sung 금액 * 총수량 = 총금액 <----- 잘못 출력됩니다.
		$query .= "        ,SUM(OC.OC_CUR_PRICE * OC.OC_QTY) O_STATUS_PRICE					"; 
		$query .= "        ,SUM(CASE WHEN A.O_STATUS = 'J' THEN OC.OC_QTY ELSE 0 END) O_STATUS_CNT1	";
		$query .= "        ,SUM(CASE WHEN A.O_STATUS = 'A' THEN OC.OC_QTY ELSE 0 END) O_STATUS_CNT2	";
		$query .= "        ,SUM(CASE WHEN A.O_STATUS = 'B' THEN OC.OC_QTY ELSE 0 END) O_STATUS_CNT3	";
		$query .= "        ,SUM(CASE WHEN A.O_STATUS = 'I' THEN OC.OC_QTY ELSE 0 END) O_STATUS_CNT4	";
		$query .= "        ,SUM(CASE WHEN A.O_STATUS = 'D' THEN OC.OC_QTY ELSE 0 END) O_STATUS_CNT5	";
		$query .= "        ,SUM(CASE WHEN (A.O_STATUS = 'E' AND OC.OC_ORDER_STATUS = 'E') THEN OC.OC_QTY ELSE 0 END) O_STATUS_CNT6	";
		$query .= "        ,SUM(CASE WHEN A.O_STATUS = 'C' THEN OC.OC_QTY ELSE 0 END) O_STATUS_CNT7	";

		$query .= "        ,SUM(CASE WHEN A.O_STATUS = 'J' THEN ((OC.OC_CUR_PRICE * OC.OC_QTY) + OC.OC_OPT_ADD_CUR_PRICE) ELSE 0 END) O_STATUS_PRICE1	";
		$query .= "        ,SUM(CASE WHEN A.O_STATUS = 'A' THEN ((OC.OC_CUR_PRICE * OC.OC_QTY) + OC.OC_OPT_ADD_CUR_PRICE) ELSE 0 END) O_STATUS_PRICE2	";
		$query .= "        ,SUM(CASE WHEN A.O_STATUS = 'B' THEN ((OC.OC_CUR_PRICE * OC.OC_QTY) + OC.OC_OPT_ADD_CUR_PRICE) ELSE 0 END) O_STATUS_PRICE3	";
		$query .= "        ,SUM(CASE WHEN A.O_STATUS = 'I' THEN ((OC.OC_CUR_PRICE * OC.OC_QTY) + OC.OC_OPT_ADD_CUR_PRICE) ELSE 0 END) O_STATUS_PRICE4	";
		$query .= "        ,SUM(CASE WHEN A.O_STATUS = 'D' THEN ((OC.OC_CUR_PRICE * OC.OC_QTY) + OC.OC_OPT_ADD_CUR_PRICE) ELSE 0 END) O_STATUS_PRICE5	";
		$query .= "        ,SUM(CASE WHEN (A.O_STATUS = 'E' AND OC.OC_ORDER_STATUS = 'E') THEN ((OC.OC_CUR_PRICE * OC.OC_QTY) + OC.OC_OPT_ADD_CUR_PRICE) ELSE 0 END) O_STATUS_PRICE6	";
		$query .= "        ,SUM(CASE WHEN A.O_STATUS = 'C' THEN ((OC.OC_CUR_PRICE * OC.OC_QTY) + OC.OC_OPT_ADD_CUR_PRICE) ELSE 0 END) O_STATUS_PRICE7	";
		
		
		$query .= "    FROM ".TBL_ORDER_CART." OC                                           ";
		
		if ($this->getSearchShop()){
		
			$query .= "    JOIN (															";
			$query .= "			SELECT														";
			$query .= "				 A.O_REG_DT												";
			$query .= "				,A.O_SETTLE												";
			$query .= "             ,A.O_STATUS												";
			$query .= "             ,(B.SO_TOT_CUR_SPRICE) O_TOT_CUR_SPRICE					";
			$query .= "             ,(B.SO_TOT_CUR_SPRICE) O_TOT_CUR_PRICE					";
			$query .= "             ,0 O_USE_CUR_POINT										";
			$query .= "             ,0 O_USE_CUR_COUPON										";	
			$query .= "             ,0 O_TOT_CUR_POINT										";
			$query .= "             ,B.SO_TOT_DELIVERY_CUR_PRICE O_TOT_DELIVERY_CUR_PRICE	";
			$query .= "             ,0 O_TOT_MEM_DISCOUNT_CUR_PRICE							";
			$query .= "             ,A.M_NO													";
			$query .= "             ,A.O_NO													";
			$query .= "         FROM ORDER_MGR A											";
			$query .= "         JOIN SHOP_ORDER B											";
			$query .= "         ON A.O_NO = B.O_NO											";
			if ($this->getSearchShop() == -1) $query .= "         WHERE B.SH_NO  IN (0)		";
			else $query .= "         WHERE B.SH_NO IN ( ".$this->getSearchShop().")			";

			$query .= "    ) A																";

		} else {
			$query .= "    JOIN ".TBL_ORDER_MGR." A                                         ";				
		}		
		
		$query .= "    ON OC.O_NO = A.O_NO                                                  ";

		if ($param['M_CATE'] || $param['M_CATE_LIST'] == "Y"){
			$query .= " JOIN ";
			$query .= " (	 ";
			$query .= "		SELECT M_NO FROM ".TBL_MEMBER_CATE."		";
			$query .= "		WHERE M_NO IS NOT NULL						";
			
			if ($param['M_CATE_LIST'] == "Y"){
				if ($param['M_CATE_LIST_DATA']) {
				
					$strMemberCateQry = str_replace(","," OR ",$param['M_CATE_LIST_DATA']);
					
					$query .= " AND (		";
					$query .= $strMemberCateQry;
					$query .= " )			";
					
				} else {
				
					$query .= " AND C_CODE IN (	";
					$query .= "		SELECT C_CODE FROM ".TBL_MEMBER_CATE." WHERE M_NO = {$param['M_NO']}	";
					$query .= " )				";
				}
				
			} 
			
			if ($param['M_CATE']){
				$query .= "     AND C_CODE LIKE '{$param['M_CATE']}%'	";
			}

			$query .= "     GROUP BY M_NO								";
			$query .= " ) MC											";
			$query .= " ON A.M_NO = MC.M_NO								";
		}

		$query .= "    WHERE A.O_STATUS IN ('J','A','B','I','D','E','C')                    ";

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
			if ($this->getSearchSettleY() == "Y") $strSearchSettle .= "'Y',";
			if ($this->getSearchSettleX() == "Y") $strSearchSettle .= "'X',";
						
			if ($strSearchSettle){
				$query .= " AND A.O_SETTLE IN (".SUBSTR($strSearchSettle,0,STRLEN($strSearchSettle)-1).")	";
			}
		}	
		$query .= "    GROUP BY OC.P_CODE                                                   ";
		$query .= ") A                                                                      ";
		$query .= "JOIN ".PRODUCT_MGR." B                                                   ";
		$query .= "ON A.P_CODE = B.P_CODE                                                   ";
		$query .= "JOIN ".TBL_PRODUCT_INFO_LNG.$this->getLogLng()." BI                      ";
		$query .= "ON A.P_CODE = BI.P_CODE                                                  ";
		$query .= "JOIN ".PRODUCT_IMG." C                                                   ";
		$query .= "ON B.P_CODE = C.P_CODE                                                   ";
		$query .= "AND C.PM_TYPE = 'list'                                                   ";
		
		if ($this->getSearchShop()){
			if ($this->getSearchShop() == -1) $query .= " WHERE IFNULL(B.P_SHOP_NO,0) IN (0)	";
			else $query .= " WHERE IFNULL(B.P_SHOP_NO,0)  IN ( ".$this->getSearchShop().")		";
		}

		if ($param['PROD_CATE'] == "Y" && $param['SEARCH_PROD_CATE']){
			$query .= " AND B.P_CATE LIKE  '".$param['SEARCH_PROD_CATE']."%'			";
		}
		
		switch($param["orderBySort"]){

			case "prodNameDesc":
				$query .= "ORDER BY BI.P_NAME DESC							";
			break;
			case "prodNameAsc":
				$query .= "ORDER BY BI.P_NAME ASC							";
			break;
			
			case "prodPriceDesc":
				$query .= "ORDER BY B.P_SALE_PRICE DESC							";
			break;
			case "prodPriceAsc":
				$query .= "ORDER BY B.P_SALE_PRICE ASC							";
			break;
			
			case "totCntDesc":
				$query .= "ORDER BY A.O_STATUS_CNT DESC							";
			break;
			case "totCntAsc":
				$query .= "ORDER BY A.O_STATUS_CNT ASC							";
			break;

			case "totPriceDesc":
				$query .= "ORDER BY A.O_STATUS_PRICE DESC							";
			break;
			case "totPriceAsc":
				$query .= "ORDER BY A.O_STATUS_PRICE ASC							";
			break;

			case "orderCntJDesc":
				$query .= "ORDER BY A.O_STATUS_CNT1 DESC							";
			break;
			case "orderCntJAsc":
				$query .= "ORDER BY A.O_STATUS_CNT1 ASC							";
			break;

			case "orderPriceJDesc":
				$query .= "ORDER BY A.O_STATUS_PRICE1 DESC							";
			break;
			case "orderPriceJAsc":
				$query .= "ORDER BY A.O_STATUS_PRICE1 ASC							";
			break;

			case "orderCntADesc":
				$query .= "ORDER BY A.O_STATUS_CNT2 DESC							";
			break;
			case "orderCntAAsc":
				$query .= "ORDER BY A.O_STATUS_CNT2 ASC							";
			break;

			case "orderPriceADesc":
				$query .= "ORDER BY A.O_STATUS_PRICE2 DESC							";
			break;
			case "orderPriceAAsc":
				$query .= "ORDER BY A.O_STATUS_PRICE2 ASC							";
			break;

			case "orderCntBDesc":
				$query .= "ORDER BY A.O_STATUS_CNT3 DESC							";
			break;
			case "orderCntBAsc":
				$query .= "ORDER BY A.O_STATUS_CNT3 ASC							";
			break;

			case "orderPriceBDesc":
				$query .= "ORDER BY A.O_STATUS_PRICE3 DESC							";
			break;
			case "orderPriceBAsc":
				$query .= "ORDER BY A.O_STATUS_PRICE3 ASC							";
			break;

			case "orderCntIDesc":
				$query .= "ORDER BY A.O_STATUS_CNT4 DESC							";
			break;
			case "orderCntIAsc":
				$query .= "ORDER BY A.O_STATUS_CNT4 ASC							";
			break;

			case "orderPriceIDesc":
				$query .= "ORDER BY A.O_STATUS_PRICE4 DESC							";
			break;
			case "orderPriceIAsc":
				$query .= "ORDER BY A.O_STATUS_PRICE4 ASC							";
			break;

			case "orderCntDDesc":
				$query .= "ORDER BY A.O_STATUS_CNT5 DESC							";
			break;
			case "orderCntDAsc":
				$query .= "ORDER BY A.O_STATUS_CNT5 ASC							";
			break;

			case "orderPriceDDesc":
				$query .= "ORDER BY A.O_STATUS_PRICE5 DESC							";
			break;
			case "orderPriceDAsc":
				$query .= "ORDER BY A.O_STATUS_PRICE5 ASC							";
			break;

			case "orderCntEDesc":
				$query .= "ORDER BY A.O_STATUS_CNT6 DESC							";
			break;
			case "orderCntEAsc":
				$query .= "ORDER BY A.O_STATUS_CNT6 ASC							";
			break;

			case "orderPriceEDesc":
				$query .= "ORDER BY A.O_STATUS_PRICE6 DESC							";
			break;
			case "orderPriceEAsc":
				$query .= "ORDER BY A.O_STATUS_PRICE6 ASC							";
			break;

			case "orderCntCDesc":
				$query .= "ORDER BY A.O_STATUS_CNT7 DESC							";
			break;
			case "orderCntCAsc":
				$query .= "ORDER BY A.O_STATUS_CNT7 ASC							    ";
			break;

			case "orderPriceCDesc":
				$query .= "ORDER BY A.O_STATUS_PRICE7 DESC							";
			break;
			case "orderPriceCAsc":
				$query .= "ORDER BY A.O_STATUS_PRICE7 ASC							";
			break;

			default:
				$query .= "ORDER BY A.O_STATUS_PRICE DESC							";
			break;
		}
		
		
		
		return $db->getArrayTotal($query);
	
	}
	
	function getOrderAgeList($db,$param)
	{
		$query  = "SELECT																																";
		$query .= "     SUBSTRING(A.O_REG_DT,1,10) O_REG_DT																								";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(NOW(),1,4) - SUBSTRING(B.M_BIRTH,1,4) BETWEEN 10 AND 20 THEN 1 ELSE 0 END) M_ORDER_CNT1					";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(NOW(),1,4) - SUBSTRING(B.M_BIRTH,1,4) BETWEEN 10 AND 20 THEN (IFNULL(A.O_TOT_CUR_PRICE,0) + IFNULL(A.O_TOT_DELIVERY_CUR_PRICE,0)) ELSE 0 END) M_ORDER_PRICE1	";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(NOW(),1,4) - SUBSTRING(B.M_BIRTH,1,4) BETWEEN 21 AND 30 THEN 1 ELSE 0 END) M_ORDER_CNT2					";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(NOW(),1,4) - SUBSTRING(B.M_BIRTH,1,4) BETWEEN 21 AND 30 THEN (IFNULL(A.O_TOT_CUR_PRICE,0) + IFNULL(A.O_TOT_DELIVERY_CUR_PRICE,0)) ELSE 0 END) M_ORDER_PRICE2	";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(NOW(),1,4) - SUBSTRING(B.M_BIRTH,1,4) BETWEEN 31 AND 40 THEN 1 ELSE 0 END) M_ORDER_CNT3					";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(NOW(),1,4) - SUBSTRING(B.M_BIRTH,1,4) BETWEEN 31 AND 40 THEN (IFNULL(A.O_TOT_CUR_PRICE,0) + IFNULL(A.O_TOT_DELIVERY_CUR_PRICE,0)) ELSE 0 END) M_ORDER_PRICE3	";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(NOW(),1,4) - SUBSTRING(B.M_BIRTH,1,4) BETWEEN 41 AND 50 THEN 1 ELSE 0 END) M_ORDER_CNT4					";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(NOW(),1,4) - SUBSTRING(B.M_BIRTH,1,4) BETWEEN 41 AND 50 THEN (IFNULL(A.O_TOT_CUR_PRICE,0) + IFNULL(A.O_TOT_DELIVERY_CUR_PRICE,0)) ELSE 0 END) M_ORDER_PRICE4	";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(NOW(),1,4) - SUBSTRING(B.M_BIRTH,1,4) BETWEEN 51 AND 60 THEN 1 ELSE 0 END) M_ORDER_CNT5					";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(NOW(),1,4) - SUBSTRING(B.M_BIRTH,1,4) BETWEEN 51 AND 60 THEN (IFNULL(A.O_TOT_CUR_PRICE,0) + IFNULL(A.O_TOT_DELIVERY_CUR_PRICE,0)) ELSE 0 END) M_ORDER_PRICE5	";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(NOW(),1,4) - SUBSTRING(B.M_BIRTH,1,4) > 60 THEN 1 ELSE 0 END) M_ORDER_CNT6								";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(NOW(),1,4) - SUBSTRING(B.M_BIRTH,1,4) > 60 THEN (IFNULL(A.O_TOT_CUR_PRICE,0) + IFNULL(A.O_TOT_DELIVERY_CUR_PRICE,0)) ELSE 0 END) M_ORDER_PRICE6				";
		
		if ($this->getSearchShop()){
		
			$query .= "    FROM (															";
			$query .= "			SELECT														";
			$query .= "				 A.O_REG_DT												";
			$query .= "				,A.O_SETTLE												";
			$query .= "             ,A.O_STATUS												";
			$query .= "             ,(B.SO_TOT_CUR_SPRICE) O_TOT_CUR_SPRICE					";
			$query .= "             ,(B.SO_TOT_CUR_SPRICE) O_TOT_CUR_PRICE					";
			$query .= "             ,0 O_USE_CUR_POINT										";
			$query .= "             ,0 O_USE_CUR_COUPON										";	
			$query .= "             ,0 O_TOT_CUR_POINT										";
			$query .= "             ,B.SO_TOT_DELIVERY_CUR_PRICE O_TOT_DELIVERY_CUR_PRICE	";
			$query .= "             ,0 O_TOT_MEM_DISCOUNT_CUR_PRICE							";
			$query .= "             ,A.M_NO													";
			$query .= "             ,A.O_NO													";
			$query .= "         FROM ORDER_MGR A											";
			$query .= "         JOIN SHOP_ORDER B											";
			$query .= "         ON A.O_NO = B.O_NO											";
			if ($this->getSearchShop() == -1) $query .= "         WHERE B.SH_NO  IN (0)		";
			else $query .= "         WHERE B.SH_NO IN ( ".$this->getSearchShop().")			";

			$query .= "    ) A																";

		} else {
			$query .= "    FROM ".TBL_ORDER_MGR." A                                         ";				
		}				
		
		$query .= "JOIN ".TBL_MEMBER_MGR." B												";
		$query .= "ON A.M_NO = B.M_NO														";
		
		if ($param['M_CATE'] || $param['M_CATE_LIST'] == "Y"){
			$query .= " JOIN ";
			$query .= " (	 ";
			$query .= "		SELECT M_NO FROM ".TBL_MEMBER_CATE."		";
			$query .= "		WHERE M_NO IS NOT NULL						";
			
			if ($param['M_CATE_LIST'] == "Y"){
				
				if ($param['M_CATE_LIST_DATA']) {
				
					$strMemberCateQry = str_replace(","," OR ",$param['M_CATE_LIST_DATA']);
					
					$query .= " AND (		";
					$query .= $strMemberCateQry;
					$query .= " )			";
					
				} else {
				
					$query .= " AND C_CODE IN (	";
					$query .= "		SELECT C_CODE FROM ".TBL_MEMBER_CATE." WHERE M_NO = {$param['M_NO']}	";
					$query .= " )				";
				}
			} 
			
			if ($param['M_CATE']){
				$query .= "     AND C_CODE LIKE '{$param['M_CATE']}%'	";
			}

			$query .= "     GROUP BY M_NO								";
			$query .= " ) MC											";
			$query .= " ON A.M_NO = MC.M_NO								";
		}

		$query .= "WHERE A.O_STATUS = 'E'													";
		
		if ($this->getSearchRegStartDt() && $this->getSearchRegEndDt()){
			$query .= "	AND A.O_REG_DT BETWEEN DATE_FORMAT('".mysql_real_escape_string($this->getSearchRegStartDt())."','%Y-%m-%d 00:00:00') ";
			$query .= "	AND DATE_FORMAT('".mysql_real_escape_string($this->getSearchRegEndDt())."','%Y-%m-%d 23:59:59') ";		
		}
		
		$query .= "GROUP BY SUBSTRING(A.O_REG_DT,1,10)																									";

		return $db->getArrayTotal($query);
	}

	function getOrderAreaList($db,$param)
	{
		$query  = "SELECT																									";
		$query .= "     SUBSTRING(A.O_REG_DT,1,10) O_REG_DT																	";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.O_B_ADDR1,1,2) = '강원' THEN  1 ELSE 0 END) M_ORDER_CNT1					";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.O_B_ADDR1,1,2) = '강원' THEN  (IFNULL(A.O_TOT_CUR_PRICE,0) + IFNULL(A.O_TOT_DELIVERY_CUR_PRICE,0)) ELSE 0 END) M_ORDER_PRICE1	";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.O_B_ADDR1,1,2) = '경기' THEN  1 ELSE 0 END) M_ORDER_CNT2					";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.O_B_ADDR1,1,2) = '경기' THEN  (IFNULL(A.O_TOT_CUR_PRICE,0) + IFNULL(A.O_TOT_DELIVERY_CUR_PRICE,0)) ELSE 0 END) M_ORDER_PRICE2	";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.O_B_ADDR1,1,2) = '경남' THEN  1 ELSE 0 END) M_ORDER_CNT3					";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.O_B_ADDR1,1,2) = '경남' THEN  (IFNULL(A.O_TOT_CUR_PRICE,0) + IFNULL(A.O_TOT_DELIVERY_CUR_PRICE,0)) ELSE 0 END) M_ORDER_PRICE3	";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.O_B_ADDR1,1,2) = '경북' THEN  1 ELSE 0 END) M_ORDER_CNT4					";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.O_B_ADDR1,1,2) = '경북' THEN  (IFNULL(A.O_TOT_CUR_PRICE,0) + IFNULL(A.O_TOT_DELIVERY_CUR_PRICE,0)) ELSE 0 END) M_ORDER_PRICE4	";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.O_B_ADDR1,1,2) = '광주' THEN  1 ELSE 0 END) M_ORDER_CNT5					";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.O_B_ADDR1,1,2) = '광주' THEN  (IFNULL(A.O_TOT_CUR_PRICE,0) + IFNULL(A.O_TOT_DELIVERY_CUR_PRICE,0)) ELSE 0 END) M_ORDER_PRICE5	";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.O_B_ADDR1,1,2) = '대구' THEN  1 ELSE 0 END) M_ORDER_CNT6					";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.O_B_ADDR1,1,2) = '대구' THEN  (IFNULL(A.O_TOT_CUR_PRICE,0) + IFNULL(A.O_TOT_DELIVERY_CUR_PRICE,0)) ELSE 0 END) M_ORDER_PRICE6	";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.O_B_ADDR1,1,2) = '대전' THEN  1 ELSE 0 END) M_ORDER_CNT7					";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.O_B_ADDR1,1,2) = '대전' THEN  (IFNULL(A.O_TOT_CUR_PRICE,0) + IFNULL(A.O_TOT_DELIVERY_CUR_PRICE,0)) ELSE 0 END) M_ORDER_PRICE7	";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.O_B_ADDR1,1,2) = '부산' THEN  1 ELSE 0 END) M_ORDER_CNT8					";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.O_B_ADDR1,1,2) = '부산' THEN  (IFNULL(A.O_TOT_CUR_PRICE,0) + IFNULL(A.O_TOT_DELIVERY_CUR_PRICE,0)) ELSE 0 END) M_ORDER_PRICE9	";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.O_B_ADDR1,1,2) = '서울' THEN  1 ELSE 0 END) M_ORDER_CNT9					";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.O_B_ADDR1,1,2) = '서울' THEN  (IFNULL(A.O_TOT_CUR_PRICE,0) + IFNULL(A.O_TOT_DELIVERY_CUR_PRICE,0)) ELSE 0 END) M_ORDER_PRICE9	";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.O_B_ADDR1,1,2) = '울산' THEN  1 ELSE 0 END) M_ORDER_CNT10					";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.O_B_ADDR1,1,2) = '울산' THEN  (IFNULL(A.O_TOT_CUR_PRICE,0) + IFNULL(A.O_TOT_DELIVERY_CUR_PRICE,0)) ELSE 0 END) M_ORDER_PRICE10	";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.O_B_ADDR1,1,2) = '인천' THEN  1 ELSE 0 END) M_ORDER_CNT11					";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.O_B_ADDR1,1,2) = '인천' THEN  (IFNULL(A.O_TOT_CUR_PRICE,0) + IFNULL(A.O_TOT_DELIVERY_CUR_PRICE,0)) ELSE 0 END) M_ORDER_PRICE11	";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.O_B_ADDR1,1,2) = '전남' THEN  1 ELSE 0 END) M_ORDER_CNT12					";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.O_B_ADDR1,1,2) = '전남' THEN  (IFNULL(A.O_TOT_CUR_PRICE,0) + IFNULL(A.O_TOT_DELIVERY_CUR_PRICE,0)) ELSE 0 END) M_ORDER_PRICE12	";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.O_B_ADDR1,1,2) = '전북' THEN  1 ELSE 0 END) M_ORDER_CNT13					";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.O_B_ADDR1,1,2) = '전북' THEN  (IFNULL(A.O_TOT_CUR_PRICE,0) + IFNULL(A.O_TOT_DELIVERY_CUR_PRICE,0)) ELSE 0 END) M_ORDER_PRICE13	";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.O_B_ADDR1,1,2) = '제주' THEN  1 ELSE 0 END) M_ORDER_CNT14					";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.O_B_ADDR1,1,2) = '제주' THEN  (IFNULL(A.O_TOT_CUR_PRICE,0) + IFNULL(A.O_TOT_DELIVERY_CUR_PRICE,0)) ELSE 0 END) M_ORDER_PRICE14	";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.O_B_ADDR1,1,2) = '충남' THEN  1 ELSE 0 END) M_ORDER_CNT15					";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.O_B_ADDR1,1,2) = '충남' THEN  (IFNULL(A.O_TOT_CUR_PRICE,0) + IFNULL(A.O_TOT_DELIVERY_CUR_PRICE,0)) ELSE 0 END) M_ORDER_PRICE15	";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.O_B_ADDR1,1,2) = '충북' THEN  1 ELSE 0 END) M_ORDER_CNT16					";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.O_B_ADDR1,1,2) = '충북' THEN  (IFNULL(A.O_TOT_CUR_PRICE,0) + IFNULL(A.O_TOT_DELIVERY_CUR_PRICE,0)) ELSE 0 END) M_ORDER_PRICE16	";
		
		if ($this->getSearchShop()){
		
			$query .= "    FROM (															";
			$query .= "			SELECT														";
			$query .= "				 A.O_REG_DT												";
			$query .= "				,A.O_SETTLE												";
			$query .= "             ,A.O_STATUS												";
			$query .= "             ,(B.SO_TOT_CUR_SPRICE) O_TOT_CUR_SPRICE					";
			$query .= "             ,(B.SO_TOT_CUR_SPRICE) O_TOT_CUR_PRICE					";
			$query .= "             ,0 O_USE_CUR_POINT										";
			$query .= "             ,0 O_USE_CUR_COUPON										";	
			$query .= "             ,0 O_TOT_CUR_POINT										";
			$query .= "             ,B.SO_TOT_DELIVERY_CUR_PRICE O_TOT_DELIVERY_CUR_PRICE	";
			$query .= "             ,0 O_TOT_MEM_DISCOUNT_CUR_PRICE							";
			$query .= "             ,A.M_NO													";
			$query .= "             ,A.O_NO													";
			$query .= "             ,A.O_B_ADDR1											";
			$query .= "         FROM ORDER_MGR A											";
			$query .= "         JOIN SHOP_ORDER B											";
			$query .= "         ON A.O_NO = B.O_NO											";
			if ($this->getSearchShop() == -1) $query .= "         WHERE B.SH_NO  IN (0)		";
			else $query .= "         WHERE B.SH_NO IN ( ".$this->getSearchShop().")			";

			$query .= "    ) A																";

		} else {
			$query .= "    FROM ".TBL_ORDER_MGR." A                                         ";				
		}			
		
		if ($param['M_CATE'] || $param['M_CATE_LIST'] == "Y"){
			$query .= " JOIN ";
			$query .= " (	 ";
			$query .= "		SELECT M_NO FROM ".TBL_MEMBER_CATE."		";
			$query .= "		WHERE M_NO IS NOT NULL						";
			
			if ($param['M_CATE_LIST'] == "Y"){
				
				if ($param['M_CATE_LIST_DATA']) {
				
					$strMemberCateQry = str_replace(","," OR ",$param['M_CATE_LIST_DATA']);
					
					$query .= " AND (		";
					$query .= $strMemberCateQry;
					$query .= " )			";
					
				} else {
				
					$query .= " AND C_CODE IN (	";
					$query .= "		SELECT C_CODE FROM ".TBL_MEMBER_CATE." WHERE M_NO = {$param['M_NO']}	";
					$query .= " )				";
				}
			} 
			
			if ($param['M_CATE']){
				$query .= "     AND C_CODE LIKE '{$param['M_CATE']}%'	";
			}

			$query .= "     GROUP BY M_NO								";
			$query .= " ) MC											";
			$query .= " ON A.M_NO = MC.M_NO								";
		}	

		$query .= "WHERE A.O_STATUS = 'E'																					";

		if ($this->getSearchRegStartDt() && $this->getSearchRegEndDt()){
			$query .= "	AND A.O_REG_DT BETWEEN DATE_FORMAT('".mysql_real_escape_string($this->getSearchRegStartDt())."','%Y-%m-%d 00:00:00') ";
			$query .= "	AND DATE_FORMAT('".mysql_real_escape_string($this->getSearchRegEndDt())."','%Y-%m-%d 23:59:59') ";		
		}

		$query .= "GROUP BY SUBSTRING(A.O_REG_DT,1,10)																		";
		return $db->getArrayTotal($query);

	}
	
	function getOrderSexList($db,$param)
	{
		$query  = "SELECT																						";
		$query .= "     SUBSTRING(A.O_REG_DT,1,10) O_REG_DT														";
		$query .= "    ,SUM(CASE WHEN B.M_SEX IN ('1','M') THEN 1 ELSE 0 END) M_ORDER_CNT1						";
		$query .= "    ,SUM(CASE WHEN B.M_SEX IN ('1','M') THEN (IFNULL(A.O_TOT_CUR_PRICE,0) + IFNULL(A.O_TOT_DELIVERY_CUR_PRICE,0)) ELSE 0 END) M_ORDER_PRICE1		";
		$query .= "    ,SUM(CASE WHEN B.M_SEX IN ('2','W') THEN 1 ELSE 0 END) M_ORDER_CNT2						";
		$query .= "    ,SUM(CASE WHEN B.M_SEX IN ('2','W') THEN (IFNULL(A.O_TOT_CUR_PRICE,0) + IFNULL(A.O_TOT_DELIVERY_CUR_PRICE,0)) ELSE 0 END) M_ORDER_PRICE2		";
		
		if ($this->getSearchShop()){
		
			$query .= "    FROM (															";
			$query .= "			SELECT														";
			$query .= "				 A.O_REG_DT												";
			$query .= "				,A.O_SETTLE												";
			$query .= "             ,A.O_STATUS												";
			$query .= "             ,(B.SO_TOT_CUR_SPRICE) O_TOT_CUR_SPRICE					";
			$query .= "             ,(B.SO_TOT_CUR_SPRICE) O_TOT_CUR_PRICE					";
			$query .= "             ,0 O_USE_CUR_POINT										";
			$query .= "             ,0 O_USE_CUR_COUPON										";	
			$query .= "             ,0 O_TOT_CUR_POINT										";
			$query .= "             ,B.SO_TOT_DELIVERY_CUR_PRICE O_TOT_DELIVERY_CUR_PRICE	";
			$query .= "             ,0 O_TOT_MEM_DISCOUNT_CUR_PRICE							";
			$query .= "             ,A.M_NO													";
			$query .= "             ,A.O_NO													";
			$query .= "             ,A.O_B_ADDR1											";
			$query .= "         FROM ORDER_MGR A											";
			$query .= "         JOIN SHOP_ORDER B											";
			$query .= "         ON A.O_NO = B.O_NO											";
			if ($this->getSearchShop() == -1) $query .= "         WHERE B.SH_NO  IN (0)		";
			else $query .= "         WHERE B.SH_NO IN ( ".$this->getSearchShop().")			";

			$query .= "    ) A																";

		} else {
			$query .= "    FROM ".TBL_ORDER_MGR." A                                         ";				
		}			
						
		$query .= "JOIN ".TBL_MEMBER_MGR." B                                                ";
		$query .= "ON A.M_NO = B.M_NO														";
		
		if ($param['M_CATE'] || $param['M_CATE_LIST'] == "Y"){
			$query .= " JOIN ";
			$query .= " (	 ";
			$query .= "		SELECT M_NO FROM ".TBL_MEMBER_CATE."		";
			$query .= "		WHERE M_NO IS NOT NULL						";
			
			if ($param['M_CATE_LIST'] == "Y"){
				
				if ($param['M_CATE_LIST_DATA']) {
				
					$strMemberCateQry = str_replace(","," OR ",$param['M_CATE_LIST_DATA']);
					
					$query .= " AND (		";
					$query .= $strMemberCateQry;
					$query .= " )			";
					
				} else {
				
					$query .= " AND C_CODE IN (	";
					$query .= "		SELECT C_CODE FROM ".TBL_MEMBER_CATE." WHERE M_NO = {$param['M_NO']}	";
					$query .= " )				";
				}
			} 
			
			if ($param['M_CATE']){
				$query .= "     AND C_CODE LIKE '{$param['M_CATE']}%'	";
			}

			$query .= "     GROUP BY M_NO								";
			$query .= " ) MC											";
			$query .= " ON A.M_NO = MC.M_NO								";
		}			
		
		
		$query .= "WHERE A.O_STATUS = 'E'																		";
		
		if ($this->getSearchRegStartDt() && $this->getSearchRegEndDt()){
			$query .= "	AND A.O_REG_DT BETWEEN DATE_FORMAT('".mysql_real_escape_string($this->getSearchRegStartDt())."','%Y-%m-%d 00:00:00') ";
			$query .= "	AND DATE_FORMAT('".mysql_real_escape_string($this->getSearchRegEndDt())."','%Y-%m-%d 23:59:59') ";		
		}
		
		$query .= "GROUP BY SUBSTRING(A.O_REG_DT,1,10)															";

//		echo $query;
		return $db->getArrayTotal($query);
	}

	function getMemberRegList($db,$param)
	{
		$query  = "SELECT                                   ";
		$query .= "     SUBSTRING(A.M_REG_DT,1,7) M_REG_DT	";
		$query .= "    ,SUM(CASE WHEN IFNULL(A.M_OUT, '') = ''  THEN 1 ELSE 0 END) M_REG_CNT                  ";
		$query .= "    ,SUM(CASE WHEN IFNULL(A.M_OUT, '') = 'Y' THEN 1 ELSE 0 END) M_OUT_CNT                  ";
		$query .= "FROM ".TBL_MEMBER_MGR." A                ";

		if ($param['M_CATE']){
			
			$query .= " JOIN (";
			$query .= "		SELECT M_NO FROM ".TBL_MEMBER_CATE."		";
			$query .= "     WHERE C_CODE LIKE '{$param['M_CATE']}%'		";
			$query .= "     GROUP BY M_NO								";
			$query .= " ) MC											";
			$query .= " ON A.M_NO = MC.M_NO								";
		}		

		$query .= "WHERE A.M_AUTH = 'Y'                     ";

		if ($this->getSearchRegStartDt() && $this->getSearchRegEndDt()){
			$query .= "	AND A.M_REG_DT BETWEEN DATE_FORMAT('".mysql_real_escape_string($this->getSearchRegStartDt())."','%Y-%m-%d 00:00:00') ";
			$query .= "	AND DATE_FORMAT('".mysql_real_escape_string($this->getSearchRegEndDt())."','%Y-%m-%d 23:59:59') ";		
		}

		$query .= "GROUP BY SUBSTRING(A.M_REG_DT,1,7)      ";
		return $db->getArrayTotal($query);
	}


	function getMemberAgeList($db,$param)
	{
		$query  = "SELECT																											";
		$query .= "     SUBSTRING(A.M_REG_DT,1,7) M_REG_DT																			";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(NOW(),1,4) - SUBSTRING(A.M_BIRTH,1,4) BETWEEN 10 AND 20 THEN 1 ELSE 0 END) M_CNT1	";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(NOW(),1,4) - SUBSTRING(A.M_BIRTH,1,4) BETWEEN 21 AND 30 THEN 1 ELSE 0 END) M_CNT2	";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(NOW(),1,4) - SUBSTRING(A.M_BIRTH,1,4) BETWEEN 31 AND 40 THEN 1 ELSE 0 END) M_CNT3	";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(NOW(),1,4) - SUBSTRING(A.M_BIRTH,1,4) BETWEEN 41 AND 50 THEN 1 ELSE 0 END) M_CNT4	";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(NOW(),1,4) - SUBSTRING(A.M_BIRTH,1,4) BETWEEN 51 AND 60 THEN 1 ELSE 0 END) M_CNT5	";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(NOW(),1,4) - SUBSTRING(A.M_BIRTH,1,4) > 60 THEN 1 ELSE 0 END) M_ORDER_CNT6			";
		$query .= "    ,COUNT(*) M_TOTAL_CNT7			";
		$query .= "FROM ".TBL_MEMBER_MGR." A                                                                                        ";
		
		if ($param['M_CATE'] || $param['M_CATE_LIST'] == "Y"){
			$query .= " JOIN ";
			$query .= " (	 ";
			$query .= "		SELECT M_NO FROM ".TBL_MEMBER_CATE."		";
			$query .= "		WHERE M_NO IS NOT NULL						";
			
			if ($param['M_CATE_LIST'] == "Y"){
				
				if ($param['M_CATE_LIST_DATA']) {
				
					$strMemberCateQry = str_replace(","," OR ",$param['M_CATE_LIST_DATA']);
					
					$query .= " AND (		";
					$query .= $strMemberCateQry;
					$query .= " )			";
					
				} else {
				
					$query .= " AND C_CODE IN (	";
					$query .= "		SELECT C_CODE FROM ".TBL_MEMBER_CATE." WHERE M_NO = {$param['M_NO']}	";
					$query .= " )				";
				}
			} 
			
			if ($param['M_CATE']){
				$query .= "     AND C_CODE LIKE '{$param['M_CATE']}%'	";
			}

			$query .= "     GROUP BY M_NO								";
			$query .= " ) MC											";
			$query .= " ON A.M_NO = MC.M_NO								";
		}	
		
		$query .= "WHERE A.M_AUTH = 'Y'	 AND IFNULL(A.M_OUT, '') = ''																							";
		
		if ($this->getSearchRegStartDt() && $this->getSearchRegEndDt()){
			$query .= "	AND A.M_REG_DT BETWEEN DATE_FORMAT('".mysql_real_escape_string($this->getSearchRegStartDt())."','%Y-%m-%d 00:00:00') ";
			$query .= "	AND DATE_FORMAT('".mysql_real_escape_string($this->getSearchRegEndDt())."','%Y-%m-%d 23:59:59') ";		
		}
				
		$query .= "GROUP BY SUBSTRING(A.M_REG_DT,1,7)																				";

		return $db->getArrayTotal($query);
	}

	function getMemberAreaList($db,$param)
	{
		$query  = "SELECT																									";
		$query .= "     SUBSTRING(A.M_REG_DT,1,7) M_REG_DT																	";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.M_ADDR,1,2) = '강원' THEN  1 ELSE 0 END) M_CNT1					";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.M_ADDR,1,2) = '경기' THEN  1 ELSE 0 END) M_CNT2					";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.M_ADDR,1,2) = '경남' THEN  1 ELSE 0 END) M_CNT3					";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.M_ADDR,1,2) = '경북' THEN  1 ELSE 0 END) M_CNT4					";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.M_ADDR,1,2) = '광주' THEN  1 ELSE 0 END) M_CNT5					";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.M_ADDR,1,2) = '대구' THEN  1 ELSE 0 END) M_CNT6					";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.M_ADDR,1,2) = '대전' THEN  1 ELSE 0 END) M_CNT7					";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.M_ADDR,1,2) = '부산' THEN  1 ELSE 0 END) M_CNT8					";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.M_ADDR,1,2) = '서울' THEN  1 ELSE 0 END) M_CNT9					";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.M_ADDR,1,2) = '울산' THEN  1 ELSE 0 END) M_CNT10					";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.M_ADDR,1,2) = '인천' THEN  1 ELSE 0 END) M_CNT11					";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.M_ADDR,1,2) = '전남' THEN  1 ELSE 0 END) M_CNT12					";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.M_ADDR,1,2) = '전북' THEN  1 ELSE 0 END) M_CNT13					";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.M_ADDR,1,2) = '제주' THEN  1 ELSE 0 END) M_CNT14					";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.M_ADDR,1,2) = '충남' THEN  1 ELSE 0 END) M_CNT15					";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.M_ADDR,1,2) = '충북' THEN  1 ELSE 0 END) M_CNT16					";
		$query .= "FROM ".TBL_MEMBER_MGR." A																		";
	
		if ($param['M_CATE'] || $param['M_CATE_LIST'] == "Y"){
			$query .= " JOIN ";
			$query .= " (	 ";
			$query .= "		SELECT M_NO FROM ".TBL_MEMBER_CATE."		";
			$query .= "		WHERE M_NO IS NOT NULL						";
			
			if ($param['M_CATE_LIST'] == "Y"){
				
				if ($param['M_CATE_LIST_DATA']) {
				
					$strMemberCateQry = str_replace(","," OR ",$param['M_CATE_LIST_DATA']);
					
					$query .= " AND (		";
					$query .= $strMemberCateQry;
					$query .= " )			";
					
				} else {
				
					$query .= " AND C_CODE IN (	";
					$query .= "		SELECT C_CODE FROM ".TBL_MEMBER_CATE." WHERE M_NO = {$param['M_NO']}	";
					$query .= " )				";
				}
			} 
			
			if ($param['M_CATE']){
				$query .= "     AND C_CODE LIKE '{$param['M_CATE']}%'	";
			}

			$query .= "     GROUP BY M_NO								";
			$query .= " ) MC											";
			$query .= " ON A.M_NO = MC.M_NO								";
		}		
		
		$query .= "WHERE A.M_AUTH = 'Y'	 AND IFNULL(A.M_OUT, '') = ''																			";

		if ($this->getSearchRegStartDt() && $this->getSearchRegEndDt()){
			$query .= "	AND A.M_REG_DT BETWEEN DATE_FORMAT('".mysql_real_escape_string($this->getSearchRegStartDt())."','%Y-%m-%d 00:00:00') ";
			$query .= "	AND DATE_FORMAT('".mysql_real_escape_string($this->getSearchRegEndDt())."','%Y-%m-%d 23:59:59') ";		
		}
				
		$query .= "GROUP BY SUBSTRING(A.M_REG_DT,1,7)																				";
	
		return $db->getArrayTotal($query);
	
	}

	function getMemberSexList($db,$param)
	{
		$query  = "SELECT																";
		$query .= "     SUBSTRING(A.M_REG_DT,1,7) M_REG_DT								";
		$query .= "    ,SUM(CASE WHEN A.M_SEX IN ('1','F','M') THEN 1 ELSE 0 END) M_CNT1	";
		$query .= "    ,SUM(CASE WHEN A.M_SEX IN ('2','W') THEN 1 ELSE 0 END) M_CNT2	";
		$query .= "    ,SUM(CASE WHEN IFNULL(A.M_SEX, '') = '' THEN 1 ELSE 0 END) M_CNT3	";
		$query .= "    ,COUNT(*) M_CNT4	";
		$query .= "FROM ".TBL_MEMBER_MGR." A											";
		
		if ($param['M_CATE'] || $param['M_CATE_LIST'] == "Y"){
			$query .= " JOIN ";
			$query .= " (	 ";
			$query .= "		SELECT M_NO FROM ".TBL_MEMBER_CATE."		";
			$query .= "		WHERE M_NO IS NOT NULL						";
			
			if ($param['M_CATE_LIST'] == "Y"){
				
				if ($param['M_CATE_LIST_DATA']) {
				
					$strMemberCateQry = str_replace(","," OR ",$param['M_CATE_LIST_DATA']);
					
					$query .= " AND (		";
					$query .= $strMemberCateQry;
					$query .= " )			";
					
				} else {
				
					$query .= " AND C_CODE IN (	";
					$query .= "		SELECT C_CODE FROM ".TBL_MEMBER_CATE." WHERE M_NO = {$param['M_NO']}	";
					$query .= " )				";
				}
			} 
			
			if ($param['M_CATE']){
				$query .= "     AND C_CODE LIKE '{$param['M_CATE']}%'	";
			}

			$query .= "     GROUP BY M_NO								";
			$query .= " ) MC											";
			$query .= " ON A.M_NO = MC.M_NO								";
		}
		$query .= "WHERE A.M_AUTH = 'Y' AND IFNULL(A.M_OUT, '') = ''													";
		
		if ($this->getSearchRegStartDt() && $this->getSearchRegEndDt()){
			$query .= "	AND A.M_REG_DT BETWEEN DATE_FORMAT('".mysql_real_escape_string($this->getSearchRegStartDt())."','%Y-%m-%d 00:00:00') ";
			$query .= "	AND DATE_FORMAT('".mysql_real_escape_string($this->getSearchRegEndDt())."','%Y-%m-%d 23:59:59') ";		
		}

		$query .= "GROUP BY SUBSTRING(A.M_REG_DT,1,7)									";
		return $db->getArrayTotal($query);
	}
	

	function getOrderMemberCateList($db,$param)
	{
		$query  = "SELECT                                                                                                                              ";
		$query .= "     A.C_CODE                                                                                                                       ";
		$query .= "    ,A.C_NAME                                                                                                                       ";
		$query .= "    ,A.C_LEVEL																													   ";
		$query .= "    ,B.O_STATUS_CNT1                                                                                                                ";
		$query .= "    ,B.O_STATUS_PRICE1                                                                                                              ";
		$query .= "    ,B.O_STATUS_CNT2                                                                                                                ";
		$query .= "    ,B.O_STATUS_PRICE2                                                                                                              ";
		$query .= "    ,B.O_STATUS_CNT3                                                                                                                ";
		$query .= "    ,B.O_STATUS_PRICE3                                                                                                              ";
		$query .= "    ,B.O_STATUS_CNT4                                                                                                                ";
		$query .= "    ,B.O_STATUS_PRICE4                                                                                                              ";
		$query .= "    ,B.O_STATUS_CNT5                                                                                                                ";
		$query .= "    ,B.O_STATUS_PRICE5                                                                                                              ";
		$query .= "     ,B.O_STATUS_CNT6                                                                                                               ";
		$query .= "    ,B.O_STATUS_PRICE6                                                                                                              ";
		$query .= "     ,B.O_STATUS_CNT7                                                                                                               ";
		$query .= "    ,B.O_STATUS_PRICE7                                                                                                              ";
		$query .= "FROM MEMBER_CATE_MGR A                                                                                                              ";
		$query .= "LEFT OUTER JOIN                                                                                                                     ";
		$query .= "(                                                                                                                                   ";
		$query .= "    SELECT                                                                                                                          ";
		$query .= "         SUBSTRING(B.C_CODE,1,3) C_CODE                                                                                             ";
		$query .= "        ,SUM(A.O_STATUS_CNT1) O_STATUS_CNT1                                                                                         ";
		$query .= "        ,SUM(A.O_STATUS_PRICE1) O_STATUS_PRICE1                                                                                     ";
		$query .= "        ,SUM(A.O_STATUS_CNT2) O_STATUS_CNT2                                                                                         ";
		$query .= "        ,SUM(A.O_STATUS_PRICE2) O_STATUS_PRICE2                                                                                     ";
		$query .= "        ,SUM(A.O_STATUS_CNT3) O_STATUS_CNT3                                                                                         ";
		$query .= "        ,SUM(A.O_STATUS_PRICE3) O_STATUS_PRICE3                                                                                     ";
		$query .= "        ,SUM(A.O_STATUS_CNT4) O_STATUS_CNT4                                                                                         ";
		$query .= "        ,SUM(A.O_STATUS_PRICE4) O_STATUS_PRICE4                                                                                     ";
		$query .= "        ,SUM(A.O_STATUS_CNT5) O_STATUS_CNT5                                                                                         ";
		$query .= "        ,SUM(A.O_STATUS_PRICE5) O_STATUS_PRICE5                                                                                     ";
		$query .= "        ,SUM(A.O_STATUS_CNT6) O_STATUS_CNT6                                                                                         ";
		$query .= "        ,SUM(A.O_STATUS_PRICE6) O_STATUS_PRICE6                                                                                     ";
		$query .= "        ,SUM(A.O_STATUS_CNT7) O_STATUS_CNT7                                                                                         ";
		$query .= "        ,SUM(A.O_STATUS_PRICE7) O_STATUS_PRICE7                                                                                     ";
		$query .= "    FROM                                                                                                                            ";
		$query .= "    (                                                                                                                               ";
		$query .= "        SELECT                                                                                                                      ";
		$query .= "             A.M_NO                                                                                                                 ";
		$query .= "            ,SUM(CASE WHEN A.O_STATUS = 'J' THEN 1 ELSE 0 END) O_STATUS_CNT1                                                        ";
		$query .= "            ,SUM(CASE WHEN A.O_STATUS = 'J' THEN (IFNULL(A.O_TOT_CUR_PRICE,0) + IFNULL(A.O_TOT_DELIVERY_CUR_PRICE,0)) ELSE 0 END) O_STATUS_PRICE1                                     ";
		$query .= "            ,SUM(CASE WHEN A.O_STATUS = 'A' THEN 1 ELSE 0 END) O_STATUS_CNT2                                                        ";
		$query .= "            ,SUM(CASE WHEN A.O_STATUS = 'A' THEN (IFNULL(A.O_TOT_CUR_PRICE,0) + IFNULL(A.O_TOT_DELIVERY_CUR_PRICE,0)) ELSE 0 END) O_STATUS_PRICE2                                     ";
		$query .= "            ,SUM(CASE WHEN A.O_STATUS = 'B' THEN 1 ELSE 0 END) O_STATUS_CNT3                                                        ";
		$query .= "            ,SUM(CASE WHEN A.O_STATUS = 'B' THEN (IFNULL(A.O_TOT_CUR_PRICE,0) + IFNULL(A.O_TOT_DELIVERY_CUR_PRICE,0)) ELSE 0 END) O_STATUS_PRICE3                                     ";
		$query .= "            ,SUM(CASE WHEN A.O_STATUS = 'I' THEN 1 ELSE 0 END) O_STATUS_CNT4                                                        ";
		$query .= "            ,SUM(CASE WHEN A.O_STATUS = 'I' THEN (IFNULL(A.O_TOT_CUR_PRICE,0) + IFNULL(A.O_TOT_DELIVERY_CUR_PRICE,0)) ELSE 0 END) O_STATUS_PRICE4                                     ";
		$query .= "            ,SUM(CASE WHEN A.O_STATUS = 'D' THEN 1 ELSE 0 END) O_STATUS_CNT5                                                        ";
		$query .= "            ,SUM(CASE WHEN A.O_STATUS = 'D' THEN (IFNULL(A.O_TOT_CUR_PRICE,0) + IFNULL(A.O_TOT_DELIVERY_CUR_PRICE,0)) ELSE 0 END) O_STATUS_PRICE5                                     ";
		$query .= "            ,SUM(CASE WHEN A.O_STATUS = 'E' THEN 1 ELSE 0 END) O_STATUS_CNT6                                                        ";
		$query .= "            ,SUM(CASE WHEN A.O_STATUS = 'E' THEN (IFNULL(A.O_TOT_CUR_PRICE,0) + IFNULL(A.O_TOT_DELIVERY_CUR_PRICE,0)) ELSE 0 END) O_STATUS_PRICE6                                     ";
		$query .= "            ,SUM(CASE WHEN A.O_STATUS IN ('C','R','T') THEN 1 ELSE 0 END) O_STATUS_CNT7                                             ";
		$query .= "            ,SUM(CASE WHEN A.O_STATUS IN ('C','R','T') THEN (IFNULL(A.O_TOT_CUR_PRICE,0) + IFNULL(A.O_TOT_DELIVERY_CUR_PRICE,0)) ELSE 0 END) O_STATUS_PRICE7                          ";
		$query .= "        FROM ORDER_MGR A                                                                                                            ";				
		$query .= "        WHERE A.O_STATUS IN ('J','A','B','I','D','E','C','R','T')                                                                   ";
		
		if ($this->getSearchRegStartDt() && $this->getSearchRegEndDt()){
			$query .= "		AND A.O_REG_DT BETWEEN DATE_FORMAT('".mysql_real_escape_string($this->getSearchRegStartDt())."','%Y-%m-%d 00:00:00') ";
			$query .= "		AND DATE_FORMAT('".mysql_real_escape_string($this->getSearchRegEndDt())."','%Y-%m-%d 23:59:59') ";		
		}
				
		if ($this->getSearchSettleC() || $this->getSearchSettleA() || $this->getSearchSettleT() || $this->getSearchSettleB()){
			
			$strSearchSettle = "";
			if ($this->getSearchSettleC() == "Y") $strSearchSettle .= "'C',";
			if ($this->getSearchSettleA() == "Y") $strSearchSettle .= "'A',";
			if ($this->getSearchSettleT() == "Y") $strSearchSettle .= "'T',";
			if ($this->getSearchSettleB() == "Y") $strSearchSettle .= "'B',";
			if ($this->getSearchSettleY() == "Y") $strSearchSettle .= "'Y',";
			if ($this->getSearchSettleX() == "Y") $strSearchSettle .= "'X',";
			
			if ($strSearchSettle){
				$query .= " AND A.O_SETTLE IN (".SUBSTR($strSearchSettle,0,STRLEN($strSearchSettle)-1).")	";
			}
		}

		$query .= "        GROUP BY A.M_NO                                                                                                             ";
		$query .= "    ) A                                                                                                                             ";
		$query .= "    JOIN MEMBER_CATE B                                                                                                              ";
		$query .= "    ON A.M_NO = B.M_NO                                                                                                              ";
		$query .= "    JOIN MEMBER_CATE_MGR C                                                                                                          ";
		$query .= "    ON B.C_CODE = C.C_CODE                                                                                                          ";
		$query .= "    WHERE C.C_LEVEL = 2                                                                                                             ";
		$query .= "    GROUP BY SUBSTRING(B.C_CODE,1,3)                                                                                                ";

		$query .= "                                                                                                                                    ";
		$query .= "    UNION                                                                                                                           ";
		$query .= "                                                                                                                                    ";
		$query .= "    SELECT                                                                                                                          ";
		$query .= "         C.C_CODE                                                                                                                   ";
		$query .= "        ,SUM(A.O_STATUS_CNT1) O_STATUS_CNT1                                                                                         ";
		$query .= "        ,SUM(A.O_STATUS_PRICE1) O_STATUS_PRICE1                                                                                     ";
		$query .= "        ,SUM(A.O_STATUS_CNT2) O_STATUS_CNT2                                                                                         ";
		$query .= "        ,SUM(A.O_STATUS_PRICE2) O_STATUS_PRICE2                                                                                     ";
		$query .= "        ,SUM(A.O_STATUS_CNT3) O_STATUS_CNT3                                                                                         ";
		$query .= "        ,SUM(A.O_STATUS_PRICE3) O_STATUS_PRICE3                                                                                     ";
		$query .= "        ,SUM(A.O_STATUS_CNT4) O_STATUS_CNT4                                                                                         ";
		$query .= "        ,SUM(A.O_STATUS_PRICE4) O_STATUS_PRICE4                                                                                     ";
		$query .= "        ,SUM(A.O_STATUS_CNT5) O_STATUS_CNT5                                                                                         ";
		$query .= "        ,SUM(A.O_STATUS_PRICE5) O_STATUS_PRICE5                                                                                     ";
		$query .= "        ,SUM(A.O_STATUS_CNT6) O_STATUS_CNT6                                                                                         ";
		$query .= "        ,SUM(A.O_STATUS_PRICE6) O_STATUS_PRICE6                                                                                     ";
		$query .= "        ,SUM(A.O_STATUS_CNT7) O_STATUS_CNT7                                                                                         ";
		$query .= "        ,SUM(A.O_STATUS_PRICE7) O_STATUS_PRICE7                                                                                     ";
		$query .= "    FROM                                                                                                                            ";
		$query .= "    (                                                                                                                               ";
		$query .= "        SELECT                                                                                                                      ";
		$query .= "             A.M_NO                                                                                                                 ";
		$query .= "            ,SUM(CASE WHEN A.O_STATUS = 'J' THEN 1 ELSE 0 END) O_STATUS_CNT1                                                        ";
		$query .= "            ,SUM(CASE WHEN A.O_STATUS = 'J' THEN (IFNULL(A.O_TOT_CUR_PRICE,0) + IFNULL(A.O_TOT_DELIVERY_CUR_PRICE,0)) ELSE 0 END) O_STATUS_PRICE1                                     ";
		$query .= "            ,SUM(CASE WHEN A.O_STATUS = 'A' THEN 1 ELSE 0 END) O_STATUS_CNT2                                                        ";
		$query .= "            ,SUM(CASE WHEN A.O_STATUS = 'A' THEN (IFNULL(A.O_TOT_CUR_PRICE,0) + IFNULL(A.O_TOT_DELIVERY_CUR_PRICE,0)) ELSE 0 END) O_STATUS_PRICE2                                     ";
		$query .= "            ,SUM(CASE WHEN A.O_STATUS = 'B' THEN 1 ELSE 0 END) O_STATUS_CNT3                                                        ";
		$query .= "            ,SUM(CASE WHEN A.O_STATUS = 'B' THEN (IFNULL(A.O_TOT_CUR_PRICE,0) + IFNULL(A.O_TOT_DELIVERY_CUR_PRICE,0)) ELSE 0 END) O_STATUS_PRICE3                                     ";
		$query .= "            ,SUM(CASE WHEN A.O_STATUS = 'I' THEN 1 ELSE 0 END) O_STATUS_CNT4                                                        ";
		$query .= "            ,SUM(CASE WHEN A.O_STATUS = 'I' THEN (IFNULL(A.O_TOT_CUR_PRICE,0) + IFNULL(A.O_TOT_DELIVERY_CUR_PRICE,0)) ELSE 0 END) O_STATUS_PRICE4                                     ";
		$query .= "            ,SUM(CASE WHEN A.O_STATUS = 'D' THEN 1 ELSE 0 END) O_STATUS_CNT5                                                        ";
		$query .= "            ,SUM(CASE WHEN A.O_STATUS = 'D' THEN (IFNULL(A.O_TOT_CUR_PRICE,0) + IFNULL(A.O_TOT_DELIVERY_CUR_PRICE,0)) ELSE 0 END) O_STATUS_PRICE5                                     ";
		$query .= "            ,SUM(CASE WHEN A.O_STATUS = 'E' THEN 1 ELSE 0 END) O_STATUS_CNT6                                                        ";
		$query .= "            ,SUM(CASE WHEN A.O_STATUS = 'E' THEN (IFNULL(A.O_TOT_CUR_PRICE,0) + IFNULL(A.O_TOT_DELIVERY_CUR_PRICE,0)) ELSE 0 END) O_STATUS_PRICE6                                     ";
		$query .= "            ,SUM(CASE WHEN A.O_STATUS IN ('C','R','T') THEN 1 ELSE 0 END) O_STATUS_CNT7                                             ";
		$query .= "            ,SUM(CASE WHEN A.O_STATUS IN ('C','R','T') THEN (IFNULL(A.O_TOT_CUR_PRICE,0) + IFNULL(A.O_TOT_DELIVERY_CUR_PRICE,0)) ELSE 0 END) O_STATUS_PRICE7                          ";		
		$query .= "        FROM ORDER_MGR A                                                                                                            ";
		$query .= "        WHERE A.O_STATUS IN ('J','A','B','I','D','E','C','R','T')                                                                   ";
//		$query .= "            AND A.O_REG_DT BETWEEN DATE_FORMAT('2013-01-01','%Y-%m-%d 00:00:00') AND DATE_FORMAT('2013-12-31','%Y-%m-%d 23:59:59') ";

		if ($this->getSearchRegStartDt() && $this->getSearchRegEndDt()){
			$query .= "		AND A.O_REG_DT BETWEEN DATE_FORMAT('".mysql_real_escape_string($this->getSearchRegStartDt())."','%Y-%m-%d 00:00:00') ";
			$query .= "		AND DATE_FORMAT('".mysql_real_escape_string($this->getSearchRegEndDt())."','%Y-%m-%d 23:59:59') ";		
		}
				
		if ($this->getSearchSettleC() || $this->getSearchSettleA() || $this->getSearchSettleT() || $this->getSearchSettleB()){
			
			$strSearchSettle = "";
			if ($this->getSearchSettleC() == "Y") $strSearchSettle .= "'C',";
			if ($this->getSearchSettleA() == "Y") $strSearchSettle .= "'A',";
			if ($this->getSearchSettleT() == "Y") $strSearchSettle .= "'T',";
			if ($this->getSearchSettleB() == "Y") $strSearchSettle .= "'B',";
			if ($this->getSearchSettleY() == "Y") $strSearchSettle .= "'Y',";
			if ($this->getSearchSettleX() == "Y") $strSearchSettle .= "'X',";
			
			if ($strSearchSettle){
				$query .= " AND A.O_SETTLE IN (".SUBSTR($strSearchSettle,0,STRLEN($strSearchSettle)-1).")	";
			}
		}
		
		$query .= "        GROUP BY A.M_NO                                                                                                             ";
		$query .= "    ) A                                                                                                                             ";
		$query .= "    JOIN MEMBER_CATE B                                                                                                              ";
		$query .= "    ON A.M_NO = B.M_NO                                                                                                              ";
		$query .= "    JOIN MEMBER_CATE_MGR C                                                                                                          ";
		$query .= "    ON B.C_CODE = C.C_CODE                                                                                                          ";
		$query .= "    WHERE C.C_LEVEL = 2                                                                                                             ";
		
		
		$query .= "    GROUP BY C.C_CODE                                                                                                               ";
		$query .= ") B                                                                                                                                 ";
		$query .= "ON A.C_CODE = B.C_CODE                                                                                                              ";
		$query .= "WHERE A.C_LEVEL IN (1,2)                                                                                                            ";
		$query .= "    AND A.C_VIEW = 'Y'                                                                                                              ";
		
		if ($param['M_CATE'] || $param['M_CATE_LIST'] == "Y")
		{	
			if ($param['M_CATE_LIST'] == "Y")
			{
//				if ($param['M_CATE_LIST_DATA']) {
//				
//					$strMemberCateQry = str_replace(","," OR ",$param['M_CATE_LIST_DATA']);
//					$strMemberCateQry = str_replace("C_CODE LIKE","A.C_CODE LIKE ",$strMemberCateQry);
//
//					$query .= " AND (		";
//					$query .= $strMemberCateQry;
//					$query .= " )			";
//					
//				} else {
//				
//					$query .= " AND A.C_CODE IN (	";
//					$query .= "		SELECT C_CODE FROM ".TBL_MEMBER_CATE." WHERE M_NO = {$param['M_NO']}	";
//					$query .= " )				";
//				}

				$query .= " AND SUBSTRING(A.C_CODE,1,3) IN (				";
				$query .= "		SELECT SUBSTRING(C_CODE,1,3) FROM ".TBL_MEMBER_CATE." WHERE M_NO = {$param['M_NO']}	";
				$query .= " )				";
			}

			if ($param['M_CATE']){
				$query .= " AND A.C_CODE LIKE '{$param['M_CATE']}%'	";
			}
		}
				
		$query .= "ORDER BY A.C_CODE ASC                                                                                                               ";
		
		return $db->getArrayTotal($query);

	}

	function getShopList($db,$param = "")
	{
		$query  = "SELECT A.* FROM (					";
		$query .= "SELECT -1 SH_NO,'본사' SH_COM_NAME	";
		$query .= "UNION								";		
		$query .= "SELECT SH_NO,SH_COM_NAME FROM ".TBL_SHOP_MGR;
		$query .= "	WHERE SH_APPR = 'Y'					";
		$query .= ") A									";
		
		if ($param['SHOP_LIST']){
			$query .= " WHERE A.SH_NO IN (".$param['SHOP_LIST'].")	";
		}

		$qeury .= "	ORDER BY A.SH_COM_NAME ASC	";
		return $db->getArray($query);
	}

	function getSelectQuery($db, $query, $op)
	{
		if ( $op == "OP_LIST" ) :
			return $db->getExecSql($query);
		elseif ( $op == "OP_LIST2" ) :
			return $db->getExecSql($query);
		elseif ( $op == "OP_SELECT" ) :
			return $db->getSelect($query);
		elseif ( $op == "OP_COUNT" ) :
			return $db->getCount($query);
		elseif ( $op == "OP_COUNT2" ) :
			return $db->getCount($query);
		elseif ( $op == "OP_ARYLIST" ) :
			return $db->getArray($query);
		elseif ( $op == "OP_ARYTOTAL" ) :
			return $db->getArrayTotal($query);
		else :
			return -100;
		endif;
	}

	/*******************************************************************************/
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

	function setSearchSettleY($SEARCH_SETTLE_Y){ $this->SEARCH_SETTLE_Y = $SEARCH_SETTLE_Y; }		
	function getSearchSettleY(){ return $this->SEARCH_SETTLE_Y; }

	function setSearchSettleX($SEARCH_SETTLE_X){ $this->SEARCH_SETTLE_X = $SEARCH_SETTLE_X; }		
	function getSearchSettleX(){ return $this->SEARCH_SETTLE_X; }

	function setSearchStartYear($SEARCH_START_YEAR){ $this->SEARCH_START_YEAR = $SEARCH_START_YEAR; }		
	function getSearchStartYear(){ return $this->SEARCH_START_YEAR; }

	function setSearchStartMonth($SEARCH_START_MONTH){ $this->SEARCH_START_MONTH = $SEARCH_START_MONTH; }		
	function getSearchStartMonth(){ return $this->SEARCH_START_MONTH; }

	function setSearchStartDay($SEARCH_START_DAY){ $this->SEARCH_START_DAY = $SEARCH_START_DAY; }		
	function getSearchStartDay(){ return $this->SEARCH_START_DAY; }

	function setSearchEndYear($SEARCH_END_YEAR){ $this->SEARCH_END_YEAR = $SEARCH_END_YEAR; }		
	function getSearchEndYear(){ return $this->SEARCH_END_YEAR; }

	function setSearchEndMonth($SEARCH_END_MONTH){ $this->SEARCH_END_MONTH = $SEARCH_END_MONTH; }		
	function getSearchEndMonth(){ return $this->SEARCH_END_MONTH; }

	function setSearchEndDay($SEARCH_END_DAY){ $this->SEARCH_END_DAY = $SEARCH_END_DAY; }		
	function getSearchEndDay(){ return $this->SEARCH_START_DAY; }
	
	function setSearchGroupMode($SEARCH_GROUP_MODE){ $this->SEARCH_GROUP_MODE = $SEARCH_GROUP_MODE; }		
	function getSearchGroupMode(){ return $this->SEARCH_GROUP_MODE; }

	function setSearchHCode1($C_HCODE1){ $this->C_HCODE1 = $C_HCODE1; }		
	function getSearchHCode1(){ return $this->C_HCODE1; }		

	function setSearchHCode2($C_HCODE2){ $this->C_HCODE2 = $C_HCODE2; }		
	function getSearchHCode2(){ return $this->C_HCODE2; }		

	function setSearchHCode3($C_HCODE3){ $this->C_HCODE3 = $C_HCODE3; }		
	function getSearchHCode3(){ return $this->C_HCODE3; }		

	function setSearchHCode4($C_HCODE4){ $this->C_HCODE4 = $C_HCODE4; }		
	function getSearchHCode4(){ return $this->C_HCODE4; }		

	function setSearchProductCate($SEARCH_PRODUCT_CATE){ $this->SEARCH_PRODUCT_CATE = $SEARCH_PRODUCT_CATE; }		
	function getSearchProductCate(){ return $this->SEARCH_PRODUCT_CATE; }

	function setLogLng($LOG_LNG){ $this->LOG_LNG = $LOG_LNG; }		
	function getLogLng(){ return $this->LOG_LNG; }

	function setSearchShop($SEARCH_SHOP){ $this->SEARCH_SHOP = $SEARCH_SHOP; }		
	function getSearchShop(){ return $this->SEARCH_SHOP; }

	/********************************** variable **********************************/

}
?>