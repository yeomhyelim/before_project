<?
#/*====================================================================*/#
#|작성자	: 박영미(ivetmi@naver.com)									|#
#|작성일	: 2012-05-29												|#
#|작성내용	: 상품등록/수정/삭제										|#
#/*====================================================================*/#
class ProductMgr
{
	private $query;
	private $param;
	
	/********************************** Product List **********************************/

//	SELECT PM.*, PI.* FROM (
//		SELECT PB.P_CODE FROM PRODUCT_BASKET AS PB WHERE PB.M_NO = '4839' GROUP BY PB.P_CODE
//	) AS F_PB
//	LEFT OUTER JOIN PRODUCT_MGR AS PM ON PM.P_CODE = F_PB.P_CODE
//	LEFT OUTER JOIN PRODUCT_IMG AS PI ON PM.P_CODE = PI.P_CODE AND PI.PM_TYPE = 'list'
	function getProdBasketListEx($db, $op, $param) {

		$column['OP_LIST']		= "PM.*, PI.*";

		if($param['PB_KEY'])	{ $fromWhere = "PB.PB_KEY = '{$param['PB_KEY']}'"; }
		if($param['M_NO'])		{ $fromWhere = "PB.M_NO = '{$param['M_NO']}'"; }

		if(!$op)			{ return; }
		if(!$fromWhere)		{ return; }

		$from	= "SELECT PB.P_CODE FROM PRODUCT_BASKET AS PB WHERE {$fromWhere} GROUP BY PB.P_CODE";
		$query	= "SELECT {$column[$op]} FROM ({$from}) AS F_PB";
//		$join1	= "LEFT OUTER JOIN PRODUCT_MGR AS PM ON PM.P_CODE = F_PB.P_CODE"; // 2013.11.27 kim hee sung 상품을 삭제시 null 상품이 발생함.
		$join1	= "JOIN PRODUCT_MGR AS PM ON PM.P_CODE = F_PB.P_CODE";
		$join2	= "LEFT OUTER JOIN ".TBL_PRODUCT_IMG." AS PI ON PM.P_CODE = PI.P_CODE AND PI.PM_TYPE = 'list'";
		$where	= "WHERE PM.P_CODE IS NOT NULL";

		if($param['ORDER_BY']):
			$order_by	= "ORDER BY {$param['ORDER_BY']}";
		endif;

		if($param['LIMIT']):
			$limit		= "LIMIT {$param['LIMIT']}";
		endif;

		$query = "{$query} {$join1} {$join2} {$where} {$order_by} {$limit}";

		return $this->getSelectQuery($db, $query, $op);
	}

//	SELECT PM.*, PC.TOTAL FROM
//	(
//		SELECT OC.P_CODE, COUNT(*) AS TOTAL
//		FROM ORDER_MGR AS OM JOIN ORDER_CART AS OC ON OM.O_NO = OC.O_NO
//		WHERE OM.O_STATUS = 'E'
//		GROUP BY OC.P_CODE
//	) AS  PC
//
//	LEFT OUTER JOIN PRODUCT_MGR AS PM ON PM.P_CODE = PC.P_CODE
	function getProdBestListEx($db, $op, $param) {
		$column['OP_LIST']		= "PM.*, PI.*, PC.TOTAL";

		if(!$op)	{ return; }

		$from	= "SELECT OC.P_CODE, COUNT(*) AS TOTAL FROM ORDER_MGR AS OM JOIN ORDER_CART AS OC ON OM.O_NO = OC.O_NO WHERE OM.O_STATUS = 'E' GROUP BY OC.P_CODE";
		$query	= "SELECT {$column[$op]} FROM ({$from}) AS PC";
		$join1	= "LEFT OUTER JOIN PRODUCT_MGR AS PM ON PM.P_CODE = PC.P_CODE";
		$join2	= "LEFT OUTER JOIN ".TBL_PRODUCT_IMG." AS PI ON PM.P_CODE = PI.P_CODE AND PI.PM_TYPE = 'list'";
		$where	= "WHERE PC.P_CODE IS NOT NULL";

		if($param['P_CATE_LIKE']):
			$where = "{$where} AND PM.P_CATE LIKE ('{$param['P_CATE_LIKE']}%')";
		endif;

		if($param['ORDER_BY']):
			$order_by	= "ORDER BY {$param['ORDER_BY']}";
		endif;

		if($param['LIMIT']):
			$limit		= "LIMIT {$param['LIMIT']}";
		endif;

		$query = "{$query} {$join1} {$join2} {$where} {$order_by} {$limit}";

		return $this->getSelectQuery($db, $query, $op);
	}


	// select * from PRODUCT_MGR LEFT OUTER JOIN PRODUCT_IMG AS PI ON PM.P_CODE = PI.P_CODE AND PI.PM_TYPE = 'list' where P_SHOP_NO = 2  order by rand() limit 0, 5
	function getProdListEx($db, $op, $param) {
		$column['OP_LIST']		= "PM.*,PI.*";
		$column['OP_LIST']		.= " ,SH.SH_TYPE ";
		$column['OP_LIST']		.= " ,SH.SH_COM_TYPE ";
		if($this->getP_LNG())
		{
		//$column['OP_LIST']		.= " ,SI.SH_COM_NUM ";
		$column['OP_LIST']		.= " ,SI.SH_COM_NAME ";
		$column['OP_LIST']		.= " ,SI.SH_COM_REP_NM ";
		//$column['OP_LIST']		.= " ,SI.SH_COM_PHONE ";
		//$column['OP_LIST']		.= " ,SI.SH_COM_FAX ";
		//$column['OP_LIST']		.= " ,SI.SH_COM_MAIL ";
		//$column['OP_LIST']		.= " ,SI.SH_COM_CATEGORY ";
		$column['OP_LIST']		.= " ,SI.SH_COM_ZIP ";
		$column['OP_LIST']		.= " ,SI.SH_COM_ADDR ";
		$column['OP_LIST']		.= " ,SI.SH_COM_ADDR2 ";
		//$column['OP_LIST']		.= " ,SI.SH_COM_COUNTRY ";
		$column['OP_LIST']		.= " ,SI.SH_COM_CITY ";
		$column['OP_LIST']		.= " ,SI.SH_COM_INTRO1 ";
		$column['OP_LIST']		.= " ,SI.SH_COM_INTRO2 ";
		$column['OP_LIST']		.= " ,SI.SH_COM_LOCAL ";
		$column['OP_LIST']		.= " ,SI.SH_COM_SIZE ";
		$column['OP_LIST']		.= " ,SI.SH_COM_CATE ";
		}else{
		//$column['OP_LIST']		.= " ,SH.SH_COM_NUM ";
		$column['OP_LIST']		.= " ,SH.SH_COM_NAME ";
		$column['OP_LIST']		.= " ,SH.SH_COM_REP_NM ";
		//$column['OP_LIST']		.= " ,SH.SH_COM_PHONE ";
		//$column['OP_LIST']		.= " ,SH.SH_COM_FAX ";
		//$column['OP_LIST']		.= " ,SH.SH_COM_MAIL ";
		//$column['OP_LIST']		.= " ,SH.SH_COM_CATEGORY ";
		$column['OP_LIST']		.= " ,SH.SH_COM_ZIP ";
		$column['OP_LIST']		.= " ,SH.SH_COM_ADDR ";
		$column['OP_LIST']		.= " ,SH.SH_COM_ADDR2 ";
		//$column['OP_LIST']		.= " ,SH.SH_COM_COUNTRY ";
		$column['OP_LIST']		.= " ,SH.SH_COM_CITY ";
		$column['OP_LIST']		.= " ,SH.SH_COM_INTRO1 ";
		$column['OP_LIST']		.= " ,SH.SH_COM_INTRO2 ";
		$column['OP_LIST']		.= " ,SH.SH_COM_LOCAL ";
		$column['OP_LIST']		.= " ,SH.SH_COM_SIZE ";
		$column['OP_LIST']		.= " ,SH.SH_COM_CATE ";
		}
		$column['OP_LIST']		.= " ,SH.SH_COM_COUNTRY ";
		$column['OP_LIST']		.= " ,SH.SH_COM_NUM ";
		$column['OP_LIST']		.= " ,SH.SH_COM_PHONE ";
		$column['OP_LIST']		.= " ,SH.SH_COM_FAX ";
		$column['OP_LIST']		.= " ,SH.SH_COM_MAIL ";
		$column['OP_LIST']		.= " ,SH.SH_COM_CATEGORY ";
		$column['OP_LIST']		.= " ,SH.SH_COM_NUM2 ";
		$column['OP_LIST']		.= " ,SH.SH_COM_UPTAE ";
		$column['OP_LIST']		.= " ,SH.SH_COM_UPJONG ";
		$column['OP_LIST']		.= " ,SH.SH_COM_STATE ";
		$column['OP_LIST']		.= " ,SH.SH_COM_FILE1 ";
		$column['OP_LIST']		.= " ,SH.SH_COM_FILE2 ";
		$column['OP_LIST']		.= " ,SH.SH_COM_FILE3 ";
		$column['OP_LIST']		.= " ,SH.SH_COM_FILE4 ";
		$column['OP_LIST']		.= " ,SH.SH_COM_FILE5 ";
		$column['OP_LIST']		.= " ,SH.SH_COM_DEPOSIT ";
		$column['OP_LIST']		.= " ,SH.SH_COM_BANK ";
		$column['OP_LIST']		.= " ,SH.SH_COM_BANK_NUM ";
		$column['OP_LIST']		.= " ,SH.SH_COM_ACC_PRICE ";
		$column['OP_LIST']		.= " ,SH.SH_COM_ACC_RATE ";
		$column['OP_LIST']		.= " ,SH.SH_COM_DELIVERY ";
		$column['OP_LIST']		.= " ,SH.SH_COM_DELIVERY_ST_PRICE ";
		$column['OP_LIST']		.= " ,SH.SH_COM_DELIVERY_PRICE ";
		$column['OP_LIST']		.= " ,SH.SH_COM_DELIVERY_COR ";
		$column['OP_LIST']		.= " ,SH.SH_COM_DELIVERY_FOR_COR ";
		$column['OP_LIST']		.= " ,SH.SH_COM_DELIVERY_FREE ";
		$column['OP_LIST']		.= " ,SH.SH_COM_DEVLIERY_PROD ";
		$column['OP_LIST']		.= " ,SH.SH_COM_DELIVERY_AREA ";
		$column['OP_LIST']		.= " ,SH.SH_COM_DELIVERY_TEXT ";
		$column['OP_LIST']		.= " ,SH.SH_COM_PROD_AUTH ";
		$column['OP_LIST']		.= " ,SH.SH_COM_MAIN ";
		$column['OP_LIST']		.= " ,SH.SH_APPR ";
		$column['OP_LIST']		.= " ,SH.SH_APPR_NO_REASON ";
		$column['OP_LIST']		.= " ,SH.SH_COM_SITE ";
		$column['OP_LIST']		.= " ,SH.SH_COM_FOUNDED ";
		$column['OP_LIST']		.= " ,SH.SH_COM_NUMBER ";
		$column['OP_LIST']		.= " ,SH.SH_COM_TOTAL_SALE ";
		$column['OP_LIST']		.= " ,SH.SH_COM_RATE ";
		$column['OP_LIST']		.= " ,SH.SH_COM_TOTAL_PRODUCTION ";
		$column['OP_LIST']		.= " ,SH.SH_COM_COUNTRY1 ";
		$column['OP_LIST']		.= " ,SH.SH_COM_COUNTRY2 ";
		$column['OP_LIST']		.= " ,SH.SH_COM_COUNTRY3 ";
		$column['OP_LIST']		.= " ,SH.SH_COM_COUNTRY4 ";
		$column['OP_LIST']		.= " ,SH.SH_COM_COUNTRY5 ";
		$column['OP_LIST']		.= " ,SH.SH_COM_COUNTRY6 ";
		$column['OP_LIST']		.= " ,SH.SH_COM_COUNTRY7 ";
		$column['OP_LIST']		.= " ,SH.SH_COM_COUNTRY8 ";
		$column['OP_LIST']		.= " ,SH.SH_COM_COUNTRY9 ";
		$column['OP_LIST']		.= " ,SH.SH_COM_COUNTRY10 ";
		$column['OP_LIST']		.= " ,SH.SH_COM_COUNTRY11 ";
		$column['OP_LIST']		.= " ,SH.SH_COM_COUNTRY12 ";
		$column['OP_LIST']		.= " ,SH.SH_COM_COUNTRY13 ";
		$column['OP_LIST']		.= " ,SH.SH_COM_COUNTRY14 ";
		$column['OP_LIST']		.= " ,SH.SH_COM_RD ";		
		$column['OP_LIST']		.= " ,SH.SH_COM_CERTIFICATES1 ";
		$column['OP_LIST']		.= " ,SH.SH_COM_CERTIFICATES1_FILE ";
		$column['OP_LIST']		.= " ,SH.SH_COM_CERTIFICATES2 ";
		$column['OP_LIST']		.= " ,SH.SH_COM_CERTIFICATES2_FILE ";
		$column['OP_LIST']		.= " ,SH.SH_COM_CERTIFICATES3 ";
		$column['OP_LIST']		.= " ,SH.SH_COM_CERTIFICATES3_FILE ";
		$column['OP_LIST']		.= " ,SH.SH_COM_CERTIFICATES4 ";
		$column['OP_LIST']		.= " ,SH.SH_COM_CERTIFICATES4_FILE ";
		$column['OP_LIST']		.= " ,SH.SH_COM_CERTIFICATES5 ";
		$column['OP_LIST']		.= " ,SH.SH_COM_CERTIFICATES5_FILE ";
		$column['OP_LIST']		.= " ,SH.SH_COM_CREDIT_GRADE ";
		$column['OP_LIST']		.= " ,SH.SH_COM_SALE_GRADE ";
		$column['OP_LIST']		.= " ,SH.SH_COM_LOCUS_GRADE ";
		$column['OP_LIST']		.= " ,SH.SH_REQUEST_DT ";
		$column['OP_LIST']		.= " ,SH.SH_ADMISSION_DT ";
		$column['OP_LIST']		.= " ,SH.SH_REG_DT ";
		$column['OP_LIST']		.= " ,SH.SH_REG_NO ";
		$column['OP_LIST']		.= " ,SH.SH_MOD_DT ";
		$column['OP_LIST']		.= " ,SH.SH_MOD_NO ";

  		$column['OP_COUNT']		= "COUNT(*)";

		if(!$op)	{ return; }
//		if(!$param) { return; }
		$join2					= "";
		if ($param['PROD_INFO_JOIN'] == "Y"){
			$column['OP_LIST']		.= " ,PN.P_NAME P_NAME_LNG ";
			$join2	.= "LEFT OUTER JOIN ".TBL_PRODUCT_INFO_LNG.$param['P_LNG']." AS PN ON PM.P_CODE = PN.P_CODE ";
		}

		$query	= "SELECT {$column[$op]} FROM ".TBL_PRODUCT_MGR." AS PM";
		$join1	= "LEFT OUTER JOIN ".TBL_PRODUCT_IMG." AS PI ON PM.P_CODE = PI.P_CODE AND PI.PM_TYPE = 'list'";
		
		if($param['SHOP_JOIN'] == "Y"):
			$join2	.= " LEFT JOIN ".TBL_SHOP_MGR." AS SH ON PM.P_SHOP_NO = SH.SH_NO ";

			if($this->getP_LNG()){
				$join2 .= " LEFT JOIN ".TBL_SHOP_INFO_LNG.$this->getP_LNG()." SI			";
				$join2 .= " ON PM.P_SHOP_NO = SI.SH_NO			";
			}

		endif;

		$where	= "WHERE PM.P_CODE IS NOT NULL";

		if($param['P_CODE']):
			$where		= "{$where} AND PM.P_CODE = '{$param['P_CODE']}'";
		endif;

		if($param['P_CODE_IN']):
			$where		= "{$where} AND PM.P_CODE IN ({$param['P_CODE_IN']})";
		endif;

		if($param['P_SHOP_NO']):
			$where		= "{$where} AND PM.P_SHOP_NO = '{$param['P_SHOP_NO']}'";
		endif;

		if($param['ORDER_BY']):
			$order_by	= "ORDER BY {$param['ORDER_BY']}";
		endif;

		if($param['LIMIT']):
			$limit		= "LIMIT {$param['LIMIT']}";
		endif;

		$query = "{$query} {$join1} {$join2} {$where} {$order_by} {$limit}";

		return $this->getSelectQuery($db, $query, $op);
	}

	 ## 작성일 : 2013.06.13
	 ## 작성자 : kim hee sung
	 ## 내  용 : 각 카테고리별, 상품 개수를 호출
	 ## 참고사항 : 1차 카테고리만 가능, 2차 3차 4차는 차후 추가 필요함.
	 ##		- SELECT SUBSTR(PM.P_CATE, 1, 3) AS P_CATE, COUNT(*) FROM PRODUCT_MGR AS PM GROUP BY SUBSTR(PM.P_CATE, 1, 3)
	 ## 2013.07.22 2,3,4 차 모두 사용 가능 으로 변경
	 function getProdTotalGroupbyCateEx($db, $op, $param)
	 {
		if(!$param['CATE_SUBSTR']) { $param['CATE_SUBSTR'] = 3; }

		$column['OP_ARYLIST']  = "SUBSTR(PM.P_CATE, 1, {$param['CATE_SUBSTR']}) AS P_CATE, COUNT(*)";

		if(!$op) { return; }
		//  if(!$param) { return; }

		$query		= "SELECT {$column[$op]} FROM ".TBL_PRODUCT_MGR." AS PM";
		$groupBy	= "GROUP BY SUBSTR(PM.P_CATE, 1, {$param['CATE_SUBSTR']})";

		$query		= "{$query} {$groupBy}";
		return $this->getSelectQuery($db, $query, $op);
	 }

	function getProdTotal($db,$search="list",$param="")
	{
		global $S_SITE_LNG;

		$this->setP_LNG($S_SITE_LNG);

		$query  = "SELECT									";
		$query .= "     COUNT(*)							";
		$query .= "FROM (									";
		$query .= $this->getSearchQry("prodListTable",$search);
		$query .= ") A										";

		/* 상품 좋아요 */
		if ($this->getSearchProdLike() == "prodList" || $this->getSearchProdLike() == "myList"){
			if ($this->getSearchProdLike() == "prodList") $query .= "LEFT OUTER ";

			$query .= "JOIN (								";
			$query .= "	SELECT								";
			$query .= "		 P_CODE							";
			$query .= "     ,'Y' P_LIKE_TYPE				";
			$query .= "	FROM ".TBL_MEMBER_PROD_LIKE."		";
			$query .= " WHERE M_NO = ".$this->getM_NO()."	";
			$query .= ") MPL								";
			$query .= "ON A.P_CODE = MPL.P_CODE				";
		}

		/* 경매상품 리스트 */
		if($param){
			if ($param['P_AUC_LIST'] == "Y"){
				$query .= "JOIN ".TBL_PROD_AUCTION." PAU			";
				$query .= "ON A.P_CODE = PAU.P_CODE					";
			}
		}
		$query .= "WHERE A.P_CODE IS NOT NULL					";

		/* 경매상품 리스트 조건 */
		if($param){
			if ($param['P_AUC_LIST'] == "Y"){
				$query .= " AND PAU.P_AUC_STATUS IN ('2','4','5')	";
			}
		}

		return $db->getCount($query);
	}

	function getProdList($db,$search="list",$param="")
	{
		global $S_SITE_LNG;
		$this->setP_LNG($S_SITE_LNG);

		$query  = "SELECT									";
		$query .= "     A.P_CODE							";
		$query .= "    ,A.P_NAME							";
		$query .= "    ,A.P_NUM								";
		$query .= "    ,A.P_CATE							";
		$query .= "    ,A.P_LAUNCH_DT						";
		$query .= "    ,A.P_REP_DT							";
		$query .= "    ,A.P_CONSUMER_PRICE					";
		$query .= "    ,A.P_SALE_PRICE						";

		$query .= "    ,A.P_PRICE_FILTER                    ";
		$query .= "    ,A.P_PRICE_UNIT                      ";
		$query .= "    ,A.P_CAS_NO                          ";
		$query .= "    ,A.P_OTHER_NAMES                     ";
		$query .= "    ,A.P_MIN_QTY                         ";
		$query .= "    ,A.P_SAIL_UNIT                       ";
		$query .= "    ,A.P_OPT								";

		$query .= "    ,A.P_QTY								";
		$query .= "    ,A.P_WEB_VIEW						";
		$query .= "    ,A.P_MOB_VIEW						";
		$query .= "    ,A.P_TYPE							";
		$query .= "    ,A.P_POINT							";
		$query .= "    ,A.P_EVENT_UNIT						";
		$query .= "    ,A.P_EVENT							";
		$query .= "    ,A.P_LIST_ICON						";
		$query .= "    ,A.P_ETC								";
		$query .= "    ,A.P_COLOR							";
		$query .= "    ,A.P_MAKER							";
		$query .= "    ,A.P_ORIGIN							";
		$query .= "    ,A.P_MODEL							";
		$query .= "    ,A.P_PRICE_TEXT						";
		$query .= "    ,A.P_SEARCH_TEXT						";
		$query .= "    ,B.PM_REAL_NAME	AS PM_REAL_NAME 					";
		//$query .= "    ,BB.PM_REAL_NAME	AS PM_REAL_NAME2					";
		$query .= "    ,A.P_REG_DT							";
		$query .= "    ,A.P_POINT_TYPE                      ";
		$query .= "    ,A.P_POINT_OFF1                      ";
		$query .= "    ,A.P_POINT_OFF2                      ";
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
		$query .= "    ,D.PR_NAME AS P_BRAND_NAME			";
		$query .= "    ,A.P_ADD_OPT							";
		$query .= "    ,A.P_BAESONG_TYPE					";
		$query .= "    ,A.P_STOCK_OUT						";
		$query .= "    ,A.P_RESTOCK							";
		$query .= "    ,A.P_STOCK_LIMIT						";
		$query .= "	   ,A.P_MEMO							";
		$query .= "	   ,A.P_SHOP_NO							";

		$query .= "	   ,A.SH_COM_NAME						";
		$query .= "	   ,A.SH_COM_CATEGORY					";
		$query .= "	   ,A.SH_COM_CREDIT_GRADE				";
		$query .= "	   ,A.SH_COM_SALE_GRADE					";
		$query .= "	   ,A.SH_COM_LOCUS_GRADE				";
		$query .= "	   ,A.SH_COM_COUNTRY					";



		if ($this->getSearchProdLike() == "prodList" || $this->getSearchProdLike() == "myList"){
			$query .= " ,IFNULL(MPL.P_LIKE_TYPE,'N') P_LIKE_TYPE ";
		}

		//$query .= "FROM ".TBL_PRODUCT_MGR." A               ";
		$query .= " FROM (									";
		$query .= $this->getSearchQry("prodListTable",$search);
		$query .= " ) A										";


		$query .= " LEFT OUTER JOIN ".TBL_PRODUCT_IMG." B    ";
		$query .= " ON A.P_CODE = B.P_CODE					";

		if($this->getMOBILE_IMG_VIEW() == 'Y')
		{
		$query .= " AND B.PM_TYPE = 'mobile_view'			";
		}
		else
		{
		$query .= " AND B.PM_TYPE = 'list'					";
		}

		$query .= " LEFT OUTER JOIN ".TBL_PRODUCT_IMG." BB    ";
		$query .= " ON A.P_CODE = BB.P_CODE					";

		if($this->getMOBILE_IMG_VIEW() == 'Y')
		{
		$query .= " AND BB.PM_TYPE = 'mobile_main'			";
		}
		else
		{
		$query .= " AND B.PM_TYPE = 'view'					";
		}

		$query .= " LEFT OUTER JOIN ".TBL_PRODUCT_BRAND." D    ";
		$query .= " ON A.P_BRAND = D.PR_NO					";

		if (in_array($this->getSearchSort(), array('BD', 'SD', 'SA'))){
			$query .= " LEFT OUTER JOIN                           ";
			$query .= " (                                         ";
			$query .= "    SELECT                                ";
			$query .= "         A.UB_P_CODE                      ";
			$query .= "        ,SUM(A.UB_P_GRADE) UB_P_GRADE     ";
			$query .= "    FROM BOARD_UB_PROD_REVIEW A           ";
			$query .= "    WHERE A.UB_P_CODE IS NOT NULL         ";
			$query .= "        AND A.UB_P_CODE != ''             ";
			$query .= "    GROUP BY A.UB_P_CODE                  ";
			$query .= " ) U                                       ";
			$query .= " ON A.P_CODE = U.UB_P_CODE                 ";
			$query .= " LEFT OUTER JOIN                           ";
			$query .= " (                                         ";
			$query .= "    SELECT                                ";
			$query .= "         A.P_CODE                         ";
			$query .= "        ,SUM(A.OC_QTY) P_SELL_QTY         ";
			$query .= "    FROM ".TBL_ORDER_CART." A             ";
			$query .= "    JOIN ".TBL_ORDER_MGR." B              ";
			$query .= "    ON A.O_NO = B.O_NO                    ";
			$query .= "    WHERE A.OC_NO IS NOT NULL             ";
			$query .= "        AND B.O_STATUS = 'E'              ";
			$query .= "    GROUP BY A.P_CODE                     ";
			$query .= " ) O                                       ";
			$query .= " ON A.P_CODE = O.P_CODE                    ";
		}

		/* 상품 좋아요 */
		if ($this->getSearchProdLike() == "prodList" || $this->getSearchProdLike() == "myList"){
			if ($this->getSearchProdLike() == "prodList") $query .= "LEFT OUTER ";

			$query .= " JOIN (								";
			$query .= "	SELECT								";
			$query .= "		 P_CODE							";
			$query .= "     ,'Y' P_LIKE_TYPE				";
			$query .= "	FROM ".TBL_MEMBER_PROD_LIKE."		";
			$query .= " WHERE M_NO = ".$this->getM_NO()."	";
			$query .= " ) MPL								";
			$query .= " ON A.P_CODE = MPL.P_CODE				";
		}

		/* 경매상품 리스트 */
		if($param){
			if ($param['P_AUC_LIST'] == "Y"){
				$query .= " JOIN ".TBL_PROD_AUCTION." PAU			";
				$query .= " ON A.P_CODE = PAU.P_CODE					";
			}
		}


		$query .= " WHERE A.P_CODE IS NOT NULL					";

		/* 경매상품 리스트 조건 */
		if($param){
			if ($param['P_AUC_LIST'] == "Y"){
				$query .= " AND PAU.P_AUC_STATUS IN ('2','4','5')	";
			}
		}

		/* 소비자가 없는 경우는 화면에 안보임 처리
		if ($this->getSearchPriceView() == "Y"){
			$query .= " AND A.P_CONSUMER_PRICE > 0 ";
		}*/

//		echo $query;

		if ($this->getSearchSort()){
			switch($this->getSearchSort()){
				case "RA":
					$query .= " ORDER BY A.P_SALE_PRICE ASC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();
				break;
				case "RD":
					$query .= " ORDER BY A.P_SALE_PRICE DESC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();
				break;
				case "NA":
					$query .= " ORDER BY A.P_NAME ASC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();
				break;
				case "ND":
					$query .= " ORDER BY A.P_NAME DESC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();
				break;
				case "PA":
					$query .= " ORDER BY A.P_POINT ASC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();
				break;
				case "PD":
					$query .= " ORDER BY A.P_POINT DESC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();
				break;
				case "MA":
					$query .= " ORDER BY A.P_MAKER ASC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();
				break;
				case "MD":
					$query .= " ORDER BY A.P_MAKER DESC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();
				break;
				case "TD":
					$query .= " ORDER BY A.P_REG_DT DESC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();
				break;
				case "TA":
					$query .= " ORDER BY A.P_REG_DT ASC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();
				break;

				case "BD":
					$query .= " ORDER BY U.UB_P_GRADE DESC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();	//판매리뷰순
				break;

				case "SD":
					$query .= " ORDER BY O.P_SELL_QTY DESC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();	//판매인기순
				break;

				case "SA":
					$query .= " ORDER BY O.P_SELL_QTY ASC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();	//판매인기순
				break;

				default:
					$query .= " ORDER BY A.P_ORDER ASC, A.P_REG_DT DESC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();
				break;
			}
		} else {
			//상품 카테고리별 임의 정렬 추가 kjp 2015.06.17
			if($param){
				if($param['CATE_ORDER_BY'] && $param['SELECT_CATE']){
					array_unshift($param['CATE_ORDER_BY'],$param['SELECT_CATE']);
					$aryCateOrderBy = array_unique($param['CATE_ORDER_BY']);
					$query .= " ORDER BY( CASE SUBSTRING(A.P_CATE,1,3) ";
					$i= 1;
					foreach($aryCateOrderBy as $key => $val)
					{
						$query .= " WHEN '".$val."' THEN ".$i;
						$i++;
					}
					$query .= " ELSE ".$i;
					$query .= " END ) ";
				}else{
					//$query .= " ORDER BY A.P_ORDER ASC, A.P_REG_DT DESC ";
				}
			}
			//print_r($aryCateOrderBy);
			$query .= " ORDER BY A.P_ORDER ASC, A.P_REG_DT DESC ";
			$query .= " LIMIT ".$this->getLimitFirst().",".$this->getPageLine();
		}
//$db->getExecSql($query);
		//print_r( $db);
		//PRINT_R($param['MOBILE_VIEW']);
		//print_r($query);
		//exit;
		return $db->getExecSql($query);
	}

	function getSearchQry($mode,$search)
	{
		global $S_SITE_LNG;
		global $S_PROD_MANY_LANG_VIEW;
		$this->setP_LNG($S_SITE_LNG);

		$query = "";
		switch ($mode){
			case "prodListTable":

				$query .= "SELECT                                                      ";
				$query .= "     A.P_CODE                                               ";
				$query .= "    ,A.P_CATE                                               ";
				$query .= "    ,AI.P_NAME                                              ";
				$query .= "    ,AI.P_ETC                                               ";
				$query .= "    ,B.P_NUM                                                ";
				$query .= "    ,B.P_LAUNCH_DT                                          ";
				$query .= "    ,B.P_REP_DT                                             ";
				$query .= "    ,B.P_CONSUMER_PRICE                                     ";
				$query .= "    ,B.P_SALE_PRICE                                         ";

				$query .= "    ,B.P_PRICE_FILTER                                       ";
				$query .= "    ,B.P_PRICE_UNIT                                         ";
				$query .= "    ,B.P_CAS_NO                                             ";
				$query .= "    ,B.P_OTHER_NAMES                                        ";
				$query .= "    ,B.P_MIN_QTY                                            ";
				$query .= "    ,B.P_SAIL_UNIT                                          ";
				$query .= "    ,B.P_OPT                                                ";

				$query .= "    ,B.P_QTY                                                ";
				if ($S_PROD_MANY_LANG_VIEW == "Y")
				{
					$query .= "    ,AI.P_WEB_VIEW                                      ";
					$query .= "    ,AI.P_MOB_VIEW                                      ";
				}
				else
				{
					$query .= "    ,B.P_WEB_VIEW                                        ";
					$query .= "    ,B.P_MOB_VIEW                                        ";
				}

				$query .= "    ,B.P_TYPE                                              ";
				$query .= "    ,B.P_POINT                                              ";
				$query .= "    ,B.P_EVENT_UNIT                                         ";
				$query .= "    ,B.P_EVENT                                              ";
				$query .= "    ,B.P_LIST_ICON                                          ";
				$query .= "    ,B.P_ICON                                               ";
				$query .= "    ,B.P_BRAND                                              ";
				$query .= "    ,B.P_MAKER                                              ";
				$query .= "    ,B.P_ORIGIN                                             ";
				$query .= "    ,B.P_MODEL                                              ";
				$query .= "    ,AI.P_PRICE_TEXT                                        ";
				$query .= "    ,AI.P_SEARCH_TEXT                                       ";
				$query .= "    ,B.P_COLOR                                              ";
				$query .= "    ,B.P_SIZE                                               ";
				$query .= "    ,B.P_REG_DT                                             ";
				$query .= "    ,B.P_ORDER                                              ";
				$query .= "    ,B.P_POINT_TYPE                                         ";
				$query .= "    ,B.P_POINT_OFF1                                         ";
				$query .= "    ,B.P_POINT_OFF2                                         ";
				$query .= "    ,B.P_ADD_OPT											   ";
				$query .= "    ,B.P_BAESONG_TYPE									   ";
				$query .= "    ,B.P_STOCK_OUT										   ";
				$query .= "    ,B.P_RESTOCK											   ";
				$query .= "    ,B.P_STOCK_LIMIT										   ";
				$query .= "    ,B.P_SHOP_NO                                            ";
				$query .= "	   ,AI.P_MEMO									    	   ";

				$query .= "	   ,SI.SH_COM_NAME						";
				$query .= "	   ,SH.SH_COM_CATEGORY					";
				$query .= "	   ,SH.SH_COM_CREDIT_GRADE				";
				$query .= "	   ,SH.SH_COM_SALE_GRADE				";
				$query .= "	   ,SH.SH_COM_LOCUS_GRADE				";
				$query .= "	   ,SH.SH_COM_COUNTRY					";

				$query .= "FROM                                                        ";
				$query .= "(                                                           ";
				$query .= "    SELECT                                                  ";
				$query .= "         A.P_CODE                                           ";
				$query .= "        ,MAX(A.P_CATE) P_CATE                               ";
				$query .= "    FROM                                                    ";
				$query .= "    (                                                       ";
				$query .= "        SELECT                                              ";
				$query .= "             A.P_CODE                                       ";
				$query .= "            ,A.P_CATE                                       ";
				$query .= "        FROM ".TBL_PRODUCT_MGR." A                          ";
				$query .= "        WHERE A.P_CODE IS NOT NULL						   ";


				if ($this->getSearchLCate())
				{
					$query .= "	AND SUBSTRING(A.P_CATE,1,3) IN (".$this->getSearchLCate().")	";
				}
				else
				{
					if ($this->getSearchHCode1() || $this->getSearchHCode2() || $this->getSearchHCode3() || $this->getSearchHCode4()){
						$query .= "	       AND A.P_CATE LIKE '".$this->getSearchHCode1().$this->getSearchHCode2().$this->getSearchHCode3().$this->getSearchHCode4()."%'	";
					}
				}

				$query .= "                                                            ";
				$query .= "        UNION                                               ";
				$query .= "                                                            ";
				$query .= "        SELECT                                              ";
				$query .= "             A.P_CODE                                       ";
				$query .= "            ,A.PS_P_CATE P_CATE                             ";
				$query .= "        FROM ".TBL_PRODUCT_SHARE." A                        ";
				$query .= "        WHERE A.P_CODE IS NOT NULL						   ";

				if ($this->getSearchLCate())
				{
					$query .= "	AND SUBSTRING(A.PS_P_CATE,1,3) IN (".$this->getSearchLCate().")	";
				}
				else
				{
					if ($this->getSearchHCode1() || $this->getSearchHCode2() || $this->getSearchHCode3() || $this->getSearchHCode4()){
						$query .= "	       AND A.PS_P_CATE LIKE '".$this->getSearchHCode1().$this->getSearchHCode2().$this->getSearchHCode3().$this->getSearchHCode4()."%'	";
					}
				}

				$query .= "    ) A                                                     ";
				$query .= "    GROUP BY A.P_CODE                                       ";
				$query .= ") A                                                         ";
				$query .= "JOIN ".TBL_PRODUCT_MGR." B                                  ";
				$query .= "ON A.P_CODE = B.P_CODE                                      ";
				$query .= "JOIN ".TBL_PRODUCT_INFO_LNG.$this->getP_LNG()." AI          ";
				$query .= "ON A.P_CODE = AI.P_CODE                                     ";



				/* 입점사정보 */
				$query .= "LEFT JOIN ".TBL_SHOP_MGR." SH			";
				$query .= "ON B.P_SHOP_NO = SH.SH_NO			";

				$query .= "LEFT JOIN ".TBL_SHOP_INFO_LNG.$this->getP_LNG()." SI			";
				$query .= "ON B.P_SHOP_NO = SI.SH_NO			";




				$query .= "WHERE A.P_CODE IS NOT NULL                                  ";


				//승인된 상품만 보여지게함 2015.05.27 kjp
				$query .= " AND B.P_APPR = 'Y'		";


				if($this->getP_CATE()):
					$query .= "	AND B.P_CATE LIKE ('{$this->getP_CATE()}%')	";
				endif;

				if($this->getP_BRAND()):
					$query .= "	AND B.P_BRAND = '{$this->getP_BRAND()}'	";
				endif;

				if($this->getP_SHOP_NO()):
					$query .= "	AND B.P_SHOP_NO = '{$this->getP_SHOP_NO()}'	";
				endif;

				if ($this->getSearchField() && $this->getSearchKey()){
					$query .= "	AND ";
					switch ($this->getSearchField()){
						case "N":
							$query .= " ( AI.P_NAME LIKE '%".$this->getSearchKey()."%' OR AI.P_SEARCH_TEXT LIKE '%".$this->getSearchKey()."%')";
						break;
						case "C":
							$query .= "	B.P_NUM LIKE '%".$this->getSearchKey()."%'			";
						break;
						case "M":
							$query .= "	B.P_MAKER LIKE '%".$this->getSearchKey()."%'		";
						break;
						case "O":
							$query .= "	B.P_ORIGIN LIKE '%".$this->getSearchKey()."%'		";
						break;
						case "D":
							$query .= "	B.P_MODEL LIKE '%".$this->getSearchKey()."%'		";
						break;
						case "W":
							$query .= "	B.P_WEIGHT  = ".$this->getSearchKey()."				";
						break;
					}
				}

				if($this->getSearchSubKey())
				{
					$query .= " AND ( AI.P_NAME LIKE '%".$this->getSearchSubKey()."%' OR AI.P_SEARCH_TEXT LIKE '%".$this->getSearchSubKey()."%')";
				}


				// 상품 등록일 검색(고객 등록)
				if ($this->getSearchLaunchStartDt() && $this->getSearchLaunchEndDt()){
					$query .= " AND B.P_LAUNCH_DT BETWEEN DATE_FORMAT('".$this->getSearchLaunchStartDt()."','%Y-%m-%d 00:00:00') ";
					$query .= "					      AND DATE_FORMAT('".$this->getSearchLaunchEndDt()."','%Y-%m-%d 00:00:00') ";
				}

				// 상품 등록일 검색(시스템)
				if ($this->getSearchRepStartDt() && $this->getSearchRepEndDt()){
					$query .= " AND B.P_REP_DT BETWEEN DATE_FORMAT('".$this->getSearchRepStartDt()."','%Y-%m-%d 00:00:00') ";
					$query .= "					   AND DATE_FORMAT('".$this->getSearchRepEndDt()."','%Y-%m-%d 00:00:00') ";
				}


				//상품 언어별 개별 표시로 수정 2015.05.13
				if ($S_PROD_MANY_LANG_VIEW == "Y")
				{
					if($this->getP_WEB_VIEW() == 'Y'){
						$query .= " AND AI.P_WEB_VIEW = 'Y'		";
					}
					if($this->getP_MOB_VIEW() == 'Y'){
						$query .= " AND AI.P_MOB_VIEW = 'Y'		";
					}
				}
				else
				{
					if($this->getP_WEB_VIEW() == 'Y'){
						$query .= " AND B.P_WEB_VIEW = 'Y'		";
					}
					if($this->getP_MOB_VIEW() == 'Y'){
						$query .= " AND B.P_MOB_VIEW = 'Y'		";
					}
				}
				/* // getSearchWebView() 사용안함 2015.05.13
				if ($this->getSearchWebView() == "Y")
				{
					$query .= " AND B.P_WEB_VIEW = 'Y'		";
				}

				if ($this->getSearchMobileView() == "Y")
				{
					$query .= " AND B.P_MOB_VIEW = 'Y'		";
				}
				*/

				if ($this->getSearchIcon1()){
					$query .= "	AND SUBSTRING(B.P_ICON,1,1) = 'Y'	";
				}

				if ($this->getSearchIcon2()){
					$query .= "	AND SUBSTRING(B.P_ICON,3,1) = 'Y'	";
				}

				if ($this->getSearchIcon3() == "Y"){
					$query .= "	AND SUBSTRING(B.P_ICON,5,1) = 'Y'	";
				}

				if ($this->getSearchIcon4() == "Y"){
					$query .= "	AND SUBSTRING(B.P_ICON,7,1) = 'Y'	";
				}

				if ($this->getSearchIcon5() == "Y"){
					$query .= "	AND SUBSTRING(B.P_ICON,9,1) = 'Y'	";
				}

				if ($this->getSearchIcon6() == "Y"){
					$query .= "	AND SUBSTRING(B.P_ICON,11,1) = 'Y'	";
				}

				if ($this->getSearchIcon7() == "Y"){
					$query .= "	AND SUBSTRING(B.P_ICON,13,1) = 'Y'	";
				}

				if ($this->getSearchIcon8() == "Y"){
					$query .= "	AND SUBSTRING(B.P_ICON,15,1) = 'Y'	";
				}

				if ($this->getSearchIcon9() == "Y"){
					$query .= "	AND SUBSTRING(B.P_ICON,17,1) = 'Y'	";
				}



				if ($this->getSearchOrigin()){
					$query .= "	AND B.P_ORIGIN IN (".$this->getSearchOrigin().")";
				}
				if ($this->getSearchPriceFilter()){
					$query .= "	AND B.P_PRICE_FILTER IN (".$this->getSearchPriceFilter().")	";
				}
				/*if ($this->getSearchLCate()){
					$query .= "	AND SUBSTRING(B.P_CATE,1,3) IN (".$this->getSearchLCate().")	";
				}*/


				/* 업체의 타입
				if ($this->getSearchType()){
					$query .= "	AND SH.SH_COM_CATEGORY IN (".$this->getSearchType().")	";
				}
				*/
				/* 제품의 타입. 남덕희 */
				if ($this->getSearchType()){
					$query .= "	AND B.P_TYPE IN (".$this->getSearchType().")	";
				}
				if ($this->getSearchCreditGrade()){
					$query .= "	AND SH.SH_COM_CREDIT_GRADE IN (".$this->getSearchCreditGrade().")	";
				}
				if ($this->getSearchSaleGrade()){
					$query .= "	AND SH.SH_COM_SALE_GRADE IN (".$this->getSearchSaleGrade().")	";
				}
				if ($this->getSearchLocusGrade()){
					$query .= "	AND SH.SH_COM_LOCUS_GRADE IN (".$this->getSearchLocusGrade().")	";
				}



				if ($this->getSearchColor()){
					$aryProdColorList = explode("|",$this->getSearchColor());

					$strProdColorQry = "";
					if (is_array($aryProdColorList)){
						for($i=0;$i<sizeof($aryProdColorList);$i++){
							if ($aryProdColorList[$i] == "Y"){
								$intStep = $i + ($i+1);
								$strProdColorQry .= " SUBSTRING(B.P_COLOR,".$intStep.",1) = 'Y'	OR ";
							}
						}

						$strProdColorQry = SUBSTR($strProdColorQry,0,STRLEN($strProdColorQry)-3);
						if ($strProdColorQry) $query .= " AND (".$strProdColorQry.") ";
					}
				}

				if ($this->getSearchSize()){
					$aryProdSizeList = explode("|",$this->getSearchSize());

					$strProdSizeQry = "";
					if (is_array($aryProdSizeList)){
						for($i=0;$i<sizeof($aryProdSizeList);$i++){
							if ($aryProdSizeList[$i] == "Y"){
								$intStep = $i + ($i+1);
								$strProdSizeQry .= " SUBSTRING(B.P_SIZE,".$intStep.",1) = 'Y'	OR ";
							}
						}

						$strProdSizeQry = SUBSTR($strProdSizeQry,0,STRLEN($strProdSizeQry)-3);
						if ($strProdSizeQry) $query .= " AND (".$strProdSizeQry.") ";
					}
				}

				if ($this->getSearchStartPrice() >= 0 && $this->getSearchEndPrice() > 0){
					$query .= " AND B.P_SALE_PRICE BETWEEN ".$this->getSearchStartPrice()." AND ".$this->getSearchEndPrice()." ";
				}

				if ($this->getSearchListIcon()){
					$query .= " AND B.P_LIST_ICON LIKE  '%".$this->getSearchListIcon()."%' ";
				}

			break;
		}

		return $query;
	}




	/* 관심상품 리스트 */
	function getProdGrpList($db, $op="OP_ARYTOTAL")
	{

		$column['OP_LIST']		= "b.P_CODE, AI.P_NAME, b.P_NUM, b.P_CATE, b.P_LAUNCH_DT, b.P_REP_DT, b.P_CONSUMER_PRICE, b.P_SALE_PRICE,
								   b.P_QTY, b.P_WEB_VIEW, b.P_MOB_VIEW, b.P_POINT, b.P_EVENT_UNIT, b.P_EVENT, b.P_EVENT_UNIT, b.P_LIST_ICON, c.PM_REAL_NAME,
								   b.P_STOCK_OUT
								   ";
		$column['OP_COUNT']		= "COUNT(*)";
		$column['OP_SELECT']	= $column['OP_LIST'];
		$column['OP_ARYLIST']	= $column['OP_LIST'];
		$column['OP_ARYTOTAL']	= $column['OP_LIST'];

		$query = "SELECT %s FROM %s AS a";
		$query = sprintf($query, $column[$op], TBL_PRODUCT_GRP);

		$join1 = "%s JOIN %s AS b ON a.PG_P_CODE = b.P_CODE";
		$query = sprintf($join1, $query, TBL_PRODUCT_MGR);

		$join2 = "%s LEFT OUTER JOIN %s AS c ON b.P_CODE = c.P_CODE AND c.PM_TYPE = 'list'";
		$query = sprintf($join2, $query, TBL_PRODUCT_IMG);

		$join3 = "%s LEFT OUTER JOIN %s AS AI ON b.P_CODE = AI.P_CODE";
		$query = sprintf($join3, $query, TBL_PRODUCT_INFO_LNG.$this->getP_LNG());

		$where = "%s WHERE a.P_CODE = '%s'";
		$query = sprintf($where, $query, $this->getP_CODE());

		if(!$this->getP_CODE()):
			return -100;
		endif;

		if ($this->getSearchWebView()):
			$query = sprintf("%s AND b.P_MOB_VIEW = '%s'", $query, $this->getSearchWebView());
		endif;

		$query .= "	ORDER BY a.PG_P_CODE ASC ";

		 return $this->getSelectQuery($db, $query, $op);
	}

	/* 관심상품 리스트 */
/*--
	function getProdGrpList($db)
	{
		$query  = "SELECT									";
		$query .= "     A.P_CODE							";
		$query .= "    ,AI.P_NAME							";
		$query .= "    ,A.P_NUM								";
		$query .= "    ,A.P_CATE							";
		$query .= "    ,A.P_LAUNCH_DT						";
		$query .= "    ,A.P_REP_DT							";
		$query .= "    ,A.P_CONSUMER_PRICE					";
		$query .= "    ,A.P_SALE_PRICE						";
		$query .= "    ,A.P_QTY								";
		$query .= "    ,A.P_WEB_VIEW						";
		$query .= "    ,A.P_MOB_VIEW						";
		$query .= "    ,A.P_POINT							";
		$query .= "    ,A.P_EVENT_UNIT						";
		$query .= "    ,A.P_EVENT							";
		$query .= "    ,A.P_LIST_ICON						";
		$query .= "    ,B.PM_REAL_NAME						";
		$query .= "FROM ".TBL_PRODUCT_GRP." G				";
		$query .= "JOIN ".TBL_PRODUCT_MGR." A               ";
		$query .= "ON G.PG_P_CODE = A.P_CODE				";
		$query .= "LEFT OUTER JOIN ".TBL_PRODUCT_INFO_LNG.$this->getP_LNG()." AI	";
		$query .= "ON A.P_CODE = AI.P_CODE					";
		$query .= "LEFT OUTER JOIN ".TBL_PRODUCT_IMG." B    ";
		$query .= "ON A.P_CODE = B.P_CODE					";
		$query .= "AND B.PM_TYPE = 'list'					";
		$query .= "WHERE G.P_CODE ='".$this->getP_CODE()."' ";

		if ($this->getSearchWebView() == "Y"){
			$query .= " AND A.P_MOB_VIEW = 'Y'	";
		}

		$query .= "	ORDER BY G.PG_P_CODE ASC		";

		return $db->getArrayTotal($query);
	}
--*/

	/* 상품 브랜드 리스트 */
	function getProdBrandList($db,$op="OP_LIST")
	{
		$column['OP_LIST']		= "a.*";
		$column['OP_COUNT']		= "COUNT(*)";
		$column['OP_SELECT']	= "a.*";
		$column['OP_ARYTOTAL']	= "a.*";

		$query			= "SELECT %s FROM %s AS a WHERE a.PR_NO IS NOT NULL ";
		$query			= sprintf($query, $column[$op], TBL_PRODUCT_BRAND);

		if($this->getPR_NO() && $op == "OP_SELECT") :
			$query = sprintf("%s AND PR_NO = %d", $query, $this->getPR_NO());
		endif;

		$query		= sprintf("%s ORDER BY a.PR_ALIGN ASC", $query);

		if($this->getPageLine()) :
			$query = sprintf("%s LIMIT %d, %d", $query, $this->getLimitFirst(), $this->getPageLine());
		endif;

		return $this->getSelectQuery($db, $query, $op);
	}


	/* 상품 장바구니 번호 */
	function getProdBasketNo($db)
	{
		if ($this->getM_NO()){

			$query  = "SELECT PB_NO							";
			$query .= "FROM ".TBL_PRODUCT_BASKET."			";
			$query .= "WHERE M_NO		=  ".$this->getM_NO();
			$query .= "	AND P_CODE		= '".$this->getP_CODE()."'";
			$query .= "	AND PB_OPT_NO	=  ".$this->getPB_OPT_NO();

		} else {

			$query  = "SELECT PB_NO								";
			$query .= "FROM ".TBL_PRODUCT_BASKET."				";
			$query .= "WHERE PB_KEY	= '".$this->getPB_KEY()."'	";
			$query .= "	AND P_CODE  = '".$this->getP_CODE()."'	";
			$query .= "	AND PB_OPT_NO = ".$this->getPB_OPT_NO();
		}

		return $db->getCount($query);

	}

	/* 메인 상품 관심 목록(카테고리에 해당하는 상품 중 마니 팔린거 */
	function getProdCateSellList($db){
		$query  = "SELECT                             ";
		$query .= "     A.*                           ";
		$query .= "    ,C.PM_REAL_NAME                ";
		$query .= "FROM ".TBL_PRODUCT_MGR." A         ";
		$query .= "JOIN                               ";
		$query .= "(                                  ";
		$query .= "    SELECT                         ";
		$query .= "         B.P_CODE                  ";
		$query .= "        ,COUNT(*) SELL_CNT         ";
		$query .= "    FROM ".TBL_ORDER_MGR." A       ";
		$query .= "    JOIN ".TBL_ORDER_CART." B      ";
		$query .= "    ON A.O_NO = B.O_NO             ";
		$query .= "    WHERE A.O_STATUS = 'E'         ";
		$query .= "    GROUP BY B.P_CODE              ";
		$query .= ") B                                ";
		$query .= "ON A.P_CODE = B.P_CODE             ";
		$query .= "LEFT OUTER JOIN ".TBL_PRODUCT_IMG." C	";
		$query .= "ON A.P_CODE = C.P_CODE             ";
		$query .= "AND C.PM_TYPE = 'list'             ";
		$query .= "WHERE A.P_CODE IS NOT NULL		  ";
		$query .= " AND A.P_WEB_VIEW = 'Y'			  ";

		if ($this->getSearchHCode1()){
			$query .= " AND A.P_CATE LIKE '".$this->getSearchHCode1()."%'	";
		}

		$query .= "ORDER BY B.SELL_CNT DESC LIMIT 0,5";
		//echo $query;
		return $db->getArrayTotal($query);
	}

	function getProdShareCateInfo($db)
	{
		$query  = "SELECT                               ";
		$query .= "    A.P_CATE                         ";
		$query .= "FROM                                 ";
		$query .= "(                                    ";
		$query .= "                                     ";
		$query .= "    SELECT                           ";
		$query .= "        A.P_CATE P_CATE              ";
		$query .= "    FROM ".TBL_PRODUCT_MGR." A       ";
		$query .= "    WHERE A.P_CODE = '".$this->getP_CODE()."'";
		$query .= "                                     ";
		$query .= "    UNION                            ";
		$query .= "                                     ";
		$query .= "    SELECT                           ";
		$query .= "        A.PS_P_CATE P_CATE           ";
		$query .= "    FROM ".TBL_PRODUCT_SHARE." A     ";
		$query .= "    WHERE A.P_CODE = '".$this->getP_CODE()."'";
		$query .= ") A                                  ";
		$query .= "WHERE A.P_CATE != '".$this->getP_CATE()."'   ";
		$query .= "ORDER BY A.P_CATE ASC                ";

		return $db->getArrayTotal($query);
	}

	/********************************** Product View **********************************/
	function getProdView($db){

		$query  = "SELECT									";
		$query .= "     A.*									";
		$query .= "    ,AI.P_NAME							";
		$query .= "    ,AI.P_SEARCH_TEXT					";
		$query .= "    ,AI.P_ETC							";
		$query .= "    ,AI.P_WEB_TEXT						";
		$query .= "    ,AI.P_MOB_TEXT						";
		$query .= "    ,AI.P_MEMO							";
		$query .= "    ,AI.P_DELIVERY_TEXT					";
		$query .= "    ,AI.P_RETURN_TEXT					";
		$query .= "    ,AI.P_PRICE_TEXT						";
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
		$query .= "    ,CASE WHEN A.P_BRAND > 0 THEN (SELECT PR_NAME FROM ".TBL_PRODUCT_BRAND." WHERE PR_NO = A.P_BRAND) ELSE '' END P_BRAND_NAME ";

		if ($this->getSearchProdLike() == "prodList"){
			$query .= " ,MPL.P_LIKE_TYPE					";
		}

		$query .= "FROM ".TBL_PRODUCT_MGR." A               ";
		$query .= "LEFT OUTER JOIN ".TBL_PRODUCT_INFO_LNG.$this->getP_LNG()." AI	";
		$query .= "ON A.P_CODE = AI.P_CODE					";
		$query .= "LEFT OUTER JOIN ".TBL_PRODUCT_IMG." C    ";
		$query .= "ON A.P_CODE = C.P_CODE					";

		if($this->getMOBILE_IMG_VIEW() == 'Y'){
		$query .= "AND C.PM_TYPE = 'mobile_main'					";
		}else{
		$query .= "AND C.PM_TYPE = 'view'					";
		}

		/* 상품 좋아요 */
		if ($this->getSearchProdLike() == "prodList"){
			if ($this->getSearchProdLike() == "prodList") $query .= "LEFT OUTER ";

			$query .= "JOIN (								";
			$query .= "	SELECT								";
			$query .= "		 P_CODE							";
			$query .= "     ,'Y' P_LIKE_TYPE				";
			$query .= "	FROM ".TBL_MEMBER_PROD_LIKE."		";
			$query .= " WHERE M_NO = ".$this->getM_NO()."	";
			$query .= ") MPL								";
			$query .= "ON A.P_CODE = MPL.P_CODE				";
		}

		$query .= "WHERE A.P_CODE = '".$this->getP_CODE()."'	";
//print_r($query);
		return $db->getSelect($query);
	}

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

		if($this->getMOBILE_IMG_VIEW()== 'Y'){
			$query .= "AND C.PM_TYPE = 'mobile_view'					";
		}else{
			$query .= "AND C.PM_TYPE = 'list'					";
		}
		$query .= "WHERE A.P_CODE IS NOT NULL				";
		if ($this->getP_CODE()) {
			$query .= "AND A.P_CODE = '".$this->getP_CODE()."'		";
		} else {
			if ($this->getP_CODE_ALL()){
				$query .= "AND A.P_CODE IN (".$this->getP_CODE_ALL().")	";
			}
		}

		if ($this->getP_WEB_VIEW() == "Y"){
			$query .= " AND A.P_WEB_VIEW = 'Y'	";
		}

//		return $query;
//		return $db->getArrayTotal($query);
		return $db->getExecSql($query);
	}

	/* Json 호출 */
	function getProdInfoJson($db){

		$query  = "SELECT									";
		$query .= "     A.*									";
		$query .= "    ,SUBSTRING(A.P_ICON,1,1) ICON1		";
		$query .= "    ,SUBSTRING(A.P_ICON,3,1) ICON2		";
		$query .= "    ,SUBSTRING(A.P_ICON,5,1) ICON3		";
		$query .= "    ,SUBSTRING(A.P_ICON,7,1) ICON4		";
		$query .= "    ,SUBSTRING(A.P_ICON,9,1) ICON5		";
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
		return $db->getArrayTotal($query);
	}

	function getProdItem($db)
	{
		global $S_SHOP_PROD_ADD_ITEM_VERSION;

		$addColumn = "";
		if ($S_SHOP_PROD_ADD_ITEM_VERSION == "V2.O"){
			$addColumn = ",A.PI_TYPE	";
		}

		$query  = "SELECT B.* ";
		$query .= $addColumn;
		$query .= "FROM ".TBL_PRODUCT_ITEM." A ";
		$query .= "	JOIN ".TBL_PRODUCT_ITEM_LNG.$this->getP_LNG()." B ";
		$query .= " ON A.PI_NO = B.PI_NO		   ";
		$query .= "	WHERE A.P_CODE = '".$this->getP_CODE()."'";
		$query .= " ORDER BY A.PI_NO ASC	";

		return $db->getArrayTotal($query);
	}

	function getProdOpt($db)
	{
		$query  = "SELECT                           ";
		$query .= "     A.PO_NO                     ";

		if ($this->getP_LNG())
		{
			$query .= "    ,B.PO_NAME1                  ";
			$query .= "    ,B.PO_NAME2                  ";
			$query .= "    ,B.PO_NAME3                  ";
			$query .= "    ,B.PO_NAME4                  ";
			$query .= "    ,B.PO_NAME5                  ";
			$query .= "    ,B.PO_NAME6                  ";
			$query .= "    ,B.PO_NAME7                  ";
			$query .= "    ,B.PO_NAME8                  ";
			$query .= "    ,B.PO_NAME9                  ";
			$query .= "    ,B.PO_NAME10                 ";
		}

		$query .= "    ,A.PO_ESS	                ";
		$query .= "    ,A.PO_TYPE	                ";
		$query .= "FROM ".TBL_PRODUCT_OPT." A       ";

		if ($this->getP_LNG())
		{
			$query .= "JOIN ".TBL_PRODUCT_OPT_LNG.$this->getP_LNG()." B		";
			$query .= "ON A.PO_NO = B.PO_NO				";
		}

		$query .= "WHERE A.P_CODE = '".$this->getP_CODE()."'			";
		$query .= "    AND A.PO_TYPE = '".$this->getPO_TYPE()."'        ";
		$query .= "ORDER BY A.PO_NO ASC             ";
//print_r($query);
		return $db->getArrayTotal($query);
	}

	function getProdOptAttr($db)
	{
		$query  =    "SELECT									";
		$query .= "     B.POA_NO								";
		$query .= "    ,C.POA_ATTR1								";
		$query .= "    ,C.POA_ATTR2								";
		$query .= "    ,C.POA_ATTR3								";
		$query .= "    ,C.POA_ATTR4								";
		$query .= "    ,C.POA_ATTR5								";
		$query .= "    ,C.POA_ATTR6								";
		$query .= "    ,C.POA_ATTR7								";
		$query .= "    ,C.POA_ATTR8								";
		$query .= "    ,C.POA_ATTR9								";
		$query .= "    ,C.POA_ATTR10							";
		$query .= "    ,B.POA_SALE_PRICE						";
		$query .= "    ,B.POA_CONSUMER_PRICE					";
		$query .= "    ,B.POA_STOCK_PRICE						";
		$query .= "    ,B.POA_POINT								";
		$query .= "    ,B.POA_STOCK_QTY							";

		if ($this->getP_LNG())
		{
			$query .= "    ,D.PO_NAME1                  ";
			$query .= "    ,D.PO_NAME2                  ";
			$query .= "    ,D.PO_NAME3                  ";
			$query .= "    ,D.PO_NAME4                  ";
			$query .= "    ,D.PO_NAME5                  ";
			$query .= "    ,D.PO_NAME6                  ";
			$query .= "    ,D.PO_NAME7                  ";
			$query .= "    ,D.PO_NAME8                  ";
			$query .= "    ,D.PO_NAME9                  ";
			$query .= "    ,D.PO_NAME10                 ";
		}

		$query .= "FROM ".TBL_PRODUCT_OPT." A					";
		$query .= "LEFT OUTER JOIN ".TBL_PRODUCT_OPT_ATTR." B	";
		$query .= "ON A.PO_NO = B.PO_NO							";
		$query .= " JOIN ".TBL_PRODUCT_OPT_ATTR_LNG.$this->getP_LNG()." C		";
		$query .= " ON B.POA_NO = C.POA_NO					";
		$query .= " JOIN ".TBL_PRODUCT_OPT_LNG.$this->getP_LNG()." D		";
		$query .= " ON A.PO_NO = D.PO_NO					";

		$query .= "WHERE A.P_CODE = '".$this->getP_CODE()."'	";

		if ($this->getPO_NO() > 0) {
			$query .= "    AND B.PO_NO = ".$this->getPO_NO();
		}

		if ($this->getPOA_NO() > 0) {
			$query .= "    AND B.POA_NO = ".$this->getPOA_NO();
		}

		$query .= " ORDER BY B.POA_NO ASC						";

		return $db->getArrayTotal($query);
	}

	function getProdAddOpt($db)
	{

		$query  = "SELECT										";
		$query .= "     B.PAO_NO								";
		$query .= "    ,C.PAO_NAME								";
		$query .= "    ,B.PAO_PRICE								";
		$query .= "FROM ".TBL_PRODUCT_OPT." A					";
		$query .= "LEFT OUTER JOIN ".TBL_PRODUCT_ADD_OPT." B	";
		$query .= "ON A.PO_NO = B.PO_NO							";

		$query .= " LEFT OUTER JOIN ".TBL_PRODUCT_ADD_OPT_LNG.$this->getP_LNG()." C		";
		$query .= " ON B.PAO_NO = C.PAO_NO					";

		$query .= "WHERE A.P_CODE = '".$this->getP_CODE()."'	";

		if ($this->getPO_NO() > 0) {
			$query .= "    AND B.PO_NO = ".$this->getPO_NO()."	";
		}

		if ($this->getPAO_NO() > 0) {
			$query .= "    AND B.PAO_NO = ".$this->getPAO_NO()." ";
		}

		$query .= "ORDER BY B.PAO_NO ASC						";

		return $db->getArrayTotal($query);

	}

	function getProdImgListEx($db, $op="OP_ARYTOTAL", $param)
	{
		$column['OP_LIST']		= "PI.*";
		$column['OP_COUNT']		= "COUNT(*)";
		$column['OP_SELECT']	= "PI.*";
		//$column['OP_ARYLIST']	= "PI.*";
		$column['OP_ARYLIST']	= "PI.PM_TYPE,PI.PM_REAL_NAME";
		$column['OP_ARYTOTAL']	= "PI.*";

		$query	= "SELECT {$column[$op]} FROM PRODUCT_IMG AS PI";
		$where	= "WHERE PI.PM_NO IS NOT NULL";

		if($param['P_CODE']):
			$where		= "{$where} AND PI.P_CODE = '{$param['P_CODE']}'";
		endif;

		if($param['PM_TYPE_IN']):
			if($param['PM_TYPE_IN'] == "view"):
				$pm_type = "PI.PM_TYPE IN ('view', 'view1' , 'view2' , 'view3' , 'view4' , 'view5' , 'view6' , 'view7' , 'view8' , 'view9' , 'view10' , 'view11' , 'view12' , 'view13' , 'view14' , 'view15' , 'view16' , 'view17' , 'view18' , 'view19', 'view20' )";
				$where	 = "{$where} AND {$pm_type}";
			elseif($param['PM_TYPE_IN'] == "large"):
				$pm_type = "PI.PM_TYPE IN ('large', 'large1' , 'large2' , 'large3' , 'large4' , 'large5' , 'large6' , 'large7' , 'large8' , 'large9' , 'large10' , 'large11' , 'large12' , 'large13' , 'large14' , 'large15' , 'large16' , 'large17' , 'large18' , 'large19', 'large20' )";
				$where	 = "{$where} AND {$pm_type}";
			elseif($param['PM_TYPE_IN'] == "movie"):
				$pm_type = "PI.PM_TYPE IN ('movie1')";
				$where	 = "{$where} AND {$pm_type}";
			endif;
		endif;

		if($param['ORDER_BY']):
			$order_by	= "ORDER BY {$param['ORDER_BY']}";
		endif;

		if($param['LIMIT']):
			$limit		= "LIMIT {$param['LIMIT']}";
		endif;

		$query = "{$query} {$where} {$order_by} {$limit}";

		return $this->getSelectQuery($db, $query, $op);
	}

	function getProdImg($db, $op="OP_ARYTOTAL")
	{
		$column['OP_LIST']		= "a.*";
		$column['OP_COUNT']		= "COUNT(*)";
		$column['OP_SELECT']	= "a.*";
		$column['OP_ARYLIST']	= "a.*";
		$column['OP_ARYTOTAL']	= "a.*";

		$query = "SELECT %s FROM %s AS a WHERE a.PM_NO IS NOT NULL";
		$query = sprintf($query, $column[$op], TBL_PRODUCT_IMG);

		if($this->getP_CODE()):
			$query = sprintf("%s AND a.P_CODE = '%s'", $query, $this->getP_CODE());
		endif;

		if($this->getPM_TYPE()):
			$query = sprintf("%s AND a.PM_TYPE LIKE '%%%s%%'", $query, $this->getPM_TYPE());
		endif;

		if($this->getPageLine()) :
			$query = sprintf("%s LIMIT %d, %d", $query, $this->getLimitFirst(), $this->getPageLine());
		endif;

		return $this->getSelectQuery($db, $query, $op);
	}

/*--
	function getProdImg($db)
	{
		$query  = "SELECT                           ";
		$query .= "    A.*                          ";
		$query .= "FROM ".TBL_PRODUCT_IMG." A       ";
		$query .= "WHERE A.P_CODE = '".$this->getP_CODE()."'			";
		$query .= "    AND A.PM_TYPE = '".$this->getPM_TYPE()."'		";

		return $db->getArrayTotal($query);
	}
--*/

	function getProdImgView($db)
	{
		$query  = "SELECT                           ";
		$query .= "    A.*                          ";
		$query .= "FROM ".TBL_PRODUCT_IMG." A       ";
		$query .= "WHERE A.PM_NO = ".$this->getPM_NO();

		return $db->getSelect($query);
	}

	function getProdOptAttrGroup($db)
	{

		$query  = "SELECT												";
		$query .= "     B.POA_ATTR1										";
		$query .= "FROM ".TBL_PRODUCT_OPT_ATTR." A						";
		$query .= "JOIN ".TBL_PRODUCT_OPT_ATTR_LNG.$this->getP_LNG()." B	";
		$query .= "ON A.POA_NO = B.POA_NO								";

		$query .= "WHERE A.PO_NO = ".$this->getPO_NO()."			";
		$query .= "GROUP BY B.POA_ATTR1								";
		$query .= "ORDER BY A.POA_NO ASC							";

		return $db->getArrayTotal($query);
	}

	function getProdOptAttrGroupLimitCount($db)
	{

		$query  = "SELECT										";
		$query .= "    COUNT(*)									";
		$query .= "FROM											";
		$query .= "(											";
		$query .= "    SELECT B.POA_ATTR".$this->getPOA_ATTR_GROUP()." ";
		$query .= "    FROM ".TBL_PRODUCT_OPT_ATTR." A 			";

		$query .= "    JOIN ".TBL_PRODUCT_OPT_ATTR_LNG.$this->getP_LNG()." B			";
		$query .= "    ON A.POA_NO = B.POA_NO							";

		$query .= "    WHERE A.PO_NO = ".$this->getPO_NO()."		";
		$query .= "    GROUP BY B.POA_ATTR".$this->getPOA_ATTR_GROUP();
		$query .= ") A												";

		return $db->getCount($query);
	}

	function getProdOptAttrGroupLimitDetail($db)
	{
		$query  = "SELECT B.POA_ATTR".$this->getPOA_ATTR_GROUP()." AS POA_ATTR FROM ".TBL_PRODUCT_OPT_ATTR."	A ";
		$query .= " JOIN ".TBL_PRODUCT_OPT_ATTR_LNG.$this->getP_LNG()." B			";
		$query .= " ON A.POA_NO = B.POA_NO							";

		$query .= "WHERE A.PO_NO = ".$this->getPO_NO()."		";
		$query .= "GROUP BY B.POA_ATTR".$this->getPOA_ATTR_GROUP()."	";
		$query .= "ORDER BY A.POA_NO";

		return $db->getArrayTotal($query);
	}

	function getProdOptAttrGroupLimitDetailCount($db)
	{
		$query  = "SELECT												";
		$query .= "     COUNT(*)										";
		$query .= "FROM ".TBL_PRODUCT_OPT_ATTR." A							";
		$query .= "JOIN ".TBL_PRODUCT_OPT_ATTR_LNG.$this->getP_LNG()." B	";
		$query .= "ON A.POA_NO = B.POA_NO								";
		$query .= "WHERE A.PO_NO = ".$this->getPO_NO()."				";

		if ($this->getPOA_ATTR1()){
			$query .= " AND B.POA_ATTR1 = '".$this->getPOA_ATTR1()."'	";
		}

		if ($this->getPOA_ATTR2()){
			$query .= " AND B.POA_ATTR2 = '".$this->getPOA_ATTR2()."'	";
		}

		if ($this->getPOA_ATTR3()){
			$query .= " AND B.POA_ATTR3 = '".$this->getPOA_ATTR3()."'	";
		}

		if ($this->getPOA_ATTR4()){
			$query .= " AND B.POA_ATTR4 = '".$this->getPOA_ATTR4()."'	";
		}

		if ($this->getPOA_ATTR5()){
			$query .= " AND B.POA_ATTR5 = '".$this->getPOA_ATTR5()."'	";
		}

		if ($this->getPOA_ATTR6()){
			$query .= " AND B.POA_ATTR6 = '".$this->getPOA_ATTR6()."'	";
		}

		if ($this->getPOA_ATTR7()){
			$query .= " AND B.POA_ATTR7 = '".$this->getPOA_ATTR7()."'	";
		}

		if ($this->getPOA_ATTR8()){
			$query .= " AND B.POA_ATTR8 = '".$this->getPOA_ATTR8()."'	";
		}

		if ($this->getPOA_ATTR9()){
			$query .= " AND B.POA_ATTR9 = '".$this->getPOA_ATTR9()."'	";
		}

		if ($this->getPOA_ATTR10()){
			$query .= " AND B.POA_ATTR10 = '".$this->getPOA_ATTR10()."'	";
		}

		return $db->getCount($query);
	}

	function getProdOptAttrGroupLimitDetailNo($db)
	{
		$query  = "SELECT									";
		$query .= "     A.POA_NO							";
		$query .= "FROM ".TBL_PRODUCT_OPT_ATTR." A			";
		$query .= " JOIN ".TBL_PRODUCT_OPT_ATTR_LNG.$this->getP_LNG()." B			";
		$query .= " ON A.POA_NO = B.POA_NO							";
		$query .= "WHERE A.PO_NO = ".$this->getPO_NO()."			";

		if ($this->getPOA_ATTR1()){
			$query .= " AND B.POA_ATTR1 = '".$this->getPOA_ATTR1()."'	";
		}

		if ($this->getPOA_ATTR2()){
			$query .= " AND B.POA_ATTR2 = '".$this->getPOA_ATTR2()."'	";
		}

		if ($this->getPOA_ATTR3()){
			$query .= " AND B.POA_ATTR3 = '".$this->getPOA_ATTR3()."'	";
		}

		if ($this->getPOA_ATTR4()){
			$query .= " AND B.POA_ATTR4 = '".$this->getPOA_ATTR4()."'	";
		}

		if ($this->getPOA_ATTR5()){
			$query .= " AND B.POA_ATTR5 = '".$this->getPOA_ATTR5()."'	";
		}

		if ($this->getPOA_ATTR6()){
			$query .= " AND B.POA_ATTR6 = '".$this->getPOA_ATTR6()."'	";
		}

		if ($this->getPOA_ATTR7()){
			$query .= " AND B.POA_ATTR7 = '".$this->getPOA_ATTR7()."'	";
		}

		if ($this->getPOA_ATTR8()){
			$query .= " AND B.POA_ATTR8 = '".$this->getPOA_ATTR8()."'	";
		}

		if ($this->getPOA_ATTR9()){
			$query .= " AND B.POA_ATTR9 = '".$this->getPOA_ATTR9()."'	";
		}

		if ($this->getPOA_ATTR10()){
			$query .= " AND B.POA_ATTR10 = '".$this->getPOA_ATTR10()."'	";
		}

		return $db->getCount($query);
	}

	function getProdOptAttrGroupDetail($db)
	{
		$query  = "SELECT														";
		$query .= "     B.POA_ATTR".$this->getPOA_ATTR_GROUP()." AS POA_ATTR ,  ";
		$query .= "     A.POA_STOCK_QTY	";
		$query .= "FROM ".TBL_PRODUCT_OPT_ATTR." A		";

		$query .= " JOIN ".TBL_PRODUCT_OPT_ATTR_LNG.$this->getP_LNG()." B			";
		$query .= " ON A.POA_NO = B.POA_NO							";

		$query .= "WHERE A.PO_NO = ".$this->getPO_NO()."	";

		if ($this->getPOA_ATTR1()){
			$query .= " AND B.POA_ATTR1 = '".$this->getPOA_ATTR1()."'	";
		}

		if ($this->getPOA_ATTR2()){
			$query .= " AND B.POA_ATTR2 = '".$this->getPOA_ATTR2()."'	";
		}

		if ($this->getPOA_ATTR3()){
			$query .= " AND B.POA_ATTR3 = '".$this->getPOA_ATTR3()."'	";
		}

		if ($this->getPOA_ATTR4()){
			$query .= " AND B.POA_ATTR4 = '".$this->getPOA_ATTR4()."'	";
		}

		if ($this->getPOA_ATTR5()){
			$query .= " AND B.POA_ATTR5 = '".$this->getPOA_ATTR5()."'	";
		}

		if ($this->getPOA_ATTR6()){
			$query .= " AND B.POA_ATTR6 = '".$this->getPOA_ATTR6()."'	";
		}

		if ($this->getPOA_ATTR7()){
			$query .= " AND B.POA_ATTR7 = '".$this->getPOA_ATTR7()."'	";
		}

		if ($this->getPOA_ATTR8()){
			$query .= " AND B.POA_ATTR8 = '".$this->getPOA_ATTR8()."'	";
		}

		if ($this->getPOA_ATTR9()){
			$query .= " AND B.POA_ATTR9 = '".$this->getPOA_ATTR9()."'	";
		}

		if ($this->getPOA_ATTR10()){
			$query .= " AND B.POA_ATTR10 = '".$this->getPOA_ATTR10()."'	";
		}


		$query .= "GROUP BY B.POA_ATTR".$this->getPOA_ATTR_GROUP()."	";
		$query .= "ORDER BY A.POA_NO ASC					";

		//echo $query;

		return $db->getArrayTotal($query);
	}



	function getProdOptAttrNo($db)
	{
		$query  = "SELECT								";
		$query .= "     A.POA_NO						";
		$query .= "    ,A.PO_NO							";
		$query .= "    ,A.POA_SALE_PRICE				";
		$query .= "    ,A.POA_CONSUMER_PRICE			";
		$query .= "    ,A.POA_STOCK_PRICE				";
		$query .= "    ,A.POA_POINT						";
		$query .= "    ,A.POA_STOCK_QTY					";
		$query .= "    ,B.POA_ATTR1						";
		$query .= "    ,B.POA_ATTR2						";
		$query .= "    ,B.POA_ATTR3						";
		$query .= "    ,B.POA_ATTR4						";
		$query .= "    ,B.POA_ATTR5						";
		$query .= "    ,B.POA_ATTR6						";
		$query .= "    ,B.POA_ATTR7						";
		$query .= "    ,B.POA_ATTR8						";
		$query .= "    ,B.POA_ATTR9						";
		$query .= "    ,B.POA_ATTR10					";
		$query .= "FROM ".TBL_PRODUCT_OPT_ATTR." A		";

		$query .= " JOIN ".TBL_PRODUCT_OPT_ATTR_LNG.$this->getP_LNG()." B			";
		$query .= " ON A.POA_NO = B.POA_NO							";

		$query .= "WHERE A.PO_NO = ".$this->getPO_NO()."	";

		if ($this->getPOA_ATTR1()){
			$query .= " AND B.POA_ATTR1 = '".$this->getPOA_ATTR1()."'	";
		}

		if ($this->getPOA_ATTR2()){
			$query .= " AND B.POA_ATTR2 = '".$this->getPOA_ATTR2()."'	";
		}

		if ($this->getPOA_ATTR3()){
			$query .= " AND B.POA_ATTR3 = '".$this->getPOA_ATTR3()."'	";
		}

		if ($this->getPOA_ATTR4()){
			$query .= " AND B.POA_ATTR4 = '".$this->getPOA_ATTR4()."'	";
		}

		if ($this->getPOA_ATTR5()){
			$query .= " AND B.POA_ATTR5 = '".$this->getPOA_ATTR5()."'	";
		}

		if ($this->getPOA_ATTR6()){
			$query .= " AND B.POA_ATTR6 = '".$this->getPOA_ATTR6()."'	";
		}

		if ($this->getPOA_ATTR7()){
			$query .= " AND B.POA_ATTR7 = '".$this->getPOA_ATTR7()."'	";
		}

		if ($this->getPOA_ATTR8()){
			$query .= " AND B.POA_ATTR8 = '".$this->getPOA_ATTR8()."'	";
		}

		if ($this->getPOA_ATTR9()){
			$query .= " AND B.POA_ATTR9 = '".$this->getPOA_ATTR9()."'	";
		}

		if ($this->getPOA_ATTR10()){
			$query .= " AND B.POA_ATTR10 = '".$this->getPOA_ATTR10()."'	";
		}

		return $db->getArrayTotal($query);
	}


	function getProdOptAttrGroup1($db)
	{
		$query  = "SELECT								";
		$query .= "     POA_ATTR1						";
		$query .= "FROM ".TBL_PRODUCT_OPT_ATTR."		";
		$query .= "WHERE PO_NO = ".$this->getPO_NO()."	";
		$query .= "GROUP BY POA_ATTR1					";
		$query .= "ORDER BY POA_NO ASC					";

		return $db->getArrayTotal($query);
	}


	function getProdOptAttrGroup2($db)
	{
		$query  = "SELECT								";
		$query .= "      *								";
		$query .= "FROM ".TBL_PRODUCT_OPT_ATTR."		";
		$query .= "WHERE PO_NO = ".$this->getPO_NO()."	";
		$query .= "	AND POA_ATTR1 = '".$this->getPOA_ATTR1()."'	";

		return $db->getArrayTotal($query);
	}

	/* 입점사 1차카테고리별 상품수 */
	function getProdShopCateGroup($db,$search="list")
	{
		$query  = "SELECT										";
		$query .= " COUNT(A.P_CODE) AS P_CATE_COUNT				";
		$query .= " , SUBSTRING(A.P_CATE,1,3) AS P_LCATE		";
		$query .= "FROM (";
		$query .= $this->getSearchQry("prodListTable",$search);
		//.TBL_PRODUCT_MGR."		";
		$query .= ") A											";
		$query .= "	GROUP BY SUBSTRING(A.P_CATE,1,3)			";
		//print_r($query);
		return $db->getArrayTotal($query);
	}

	/* 장바구니 */
	function getProdBasketTotal($db)
	{
		global $S_SITE_LNG;
		global $S_PROD_MANY_LANG_VIEW;
		$this->setP_LNG($S_SITE_LNG);

		$query  = "SELECT									";
		$query .= "     COUNT(*)							";
		$query .= "FROM ".TBL_PRODUCT_BASKET." A			";
		$query .= "JOIN ".TBL_PRODUCT_MGR." B				";
		$query .= "ON A.P_CODE = B.P_CODE					";

		if ($S_PROD_MANY_LANG_VIEW == "Y"){
			$query .= "JOIN ".TBL_PRODUCT_INFO_LNG.$this->getP_LNG()." AI	";
			$query .= "ON A.P_CODE = AI.P_CODE								";
		}
		$query .= "WHERE A.PB_NO IS NOT NULL				";

		if ($S_PROD_MANY_LANG_VIEW == "Y") $query .= "	AND IFNULL(AI.P_WEB_VIEW,'N') = 'Y'		";
		else $query .= "	AND IFNULL(B.P_WEB_VIEW,'N') = 'Y'		";

		if ($this->getM_NO()){
			$query .= "	AND A.M_NO = ".$this->getM_NO()."						";
		} else {
			if (!$this->getPB_ALL_NO()) {
				$query .= "	AND A.PB_KEY = '".$this->getPB_KEY()."'				";
			}
		}

		if ($this->getP_SHOP_NO() > 0){
			$query .= "	AND B.P_SHOP_NO = '".$this->getP_SHOP_NO()."'			";
		}

		if ($this->getPB_ALL_NO()){
			$query .= " AND A.PB_NO IN (".$this->getPB_ALL_NO().") ";
		} else {

			if ($this->getPB_DIRECT() == "Y"){
				$query .= "	AND IFNULL(A.PB_DIRECT,'N') = 'Y'				";
			}else {
				$query .= "	AND IFNULL(A.PB_DIRECT,'N') != 'Y'				";
			}
		}

		return $db->getCount($query);
	}

	function getProdBasketList($db)
	{
		global $S_SITE_LNG;
		global $S_PROD_MANY_LANG_VIEW;

		$this->setP_LNG($S_SITE_LNG);

		$query =    "SELECT									";
		$query .= "     A.*									";
		$query .= "    ,AI.P_NAME							";
		$query .= "    ,B.P_BAESONG_TYPE					";
		$query .= "    ,B.P_BAESONG_PRICE					";
		$query .= "    ,B.P_STOCK_LIMIT						";
		$query .= "    ,B.P_QTY								";
		$query .= "    ,B.P_STOCK_OUT						";
		$query .= "    ,B.P_SALE_PRICE						";
		$query .= "		,B.P_PRICE_FILTER					";
		$query .= "    ,B.P_STOCK_PRICE						";
		$query .= "    ,B.P_OPT								";
		$query .= "    ,B.P_EVENT_UNIT						";
		$query .= "    ,B.P_EVENT							";
		$query .= "    ,B.P_POINT_NO_USE					";
		$query .= "    ,C.PM_REAL_NAME						";
		$query .= "    ,IFNULL(B.P_SHOP_NO,0) P_SHOP_NO		";
		$query .= "    ,B.P_WEIGHT							";
		$query .= "    ,B.P_TAX								";
		$query .= "    ,B.P_MIN_QTY							";
		$query .= "    ,B.P_MAX_QTY							";
		$query .= "    ,B.P_POINT_TYPE						";
		$query .= "    ,B.P_POINT_OFF1						";
		$query .= "    ,B.P_POINT_OFF2						";
		$query .= "    ,B.P_POINT							";
		$query .= "    ,B.P_CATE							";
		$query .= "    ,B.P_REG_DT							";
		$query .= "FROM ".TBL_PRODUCT_BASKET." A			";
		$query .= "JOIN ".TBL_PRODUCT_MGR." B				";
		$query .= "ON A.P_CODE = B.P_CODE					";
		$query .= "JOIN ".TBL_PRODUCT_INFO_LNG.$this->getP_LNG()." AI	";
		$query .= "ON A.P_CODE = AI.P_CODE							";
		$query .= "LEFT OUTER JOIN ".TBL_PRODUCT_IMG." C	";
		$query .= "ON A.P_CODE = C.P_CODE					";
		$query .= "AND C.PM_TYPE = 'list'					";
		$query .= "WHERE A.PB_NO IS NOT NULL				";

		if ($S_PROD_MANY_LANG_VIEW == "Y") $query .= "	AND IFNULL(AI.P_WEB_VIEW,'N') = 'Y'		";
		else $query .= "	AND IFNULL(B.P_WEB_VIEW,'N') = 'Y'		";

		if ($this->getM_NO()){
			$query .= "	AND A.M_NO = ".$this->getM_NO()."						";
		} else {
			if (!$this->getPB_ALL_NO()) {
				$query .= "	AND A.PB_KEY = '".$this->getPB_KEY()."'				";
			}
		}

		if ($this->getP_SHOP_NO() > 0){
			$query .= "	AND B.P_SHOP_NO = '".$this->getP_SHOP_NO()."'			";
		}

		/* 주문서 장바구니 */
		if ($this->getPB_ALL_NO()){
			$query .= " AND A.PB_NO IN (".$this->getPB_ALL_NO().") ";

			if ($this->getPB_ALL_SORT() == "Y"){
				$query .= "ORDER BY B.P_SHOP_NO,A.PB_NO ASC ";
				return $db->getArrayTotal($query);
			} else {
				$query .= "ORDER BY B.P_SHOP_NO,A.PB_NO DESC ";
				return $db->getExecSql($query);
			}

		} else {

			if ($this->getPB_DIRECT() == "Y"){
				$query .= "	AND IFNULL(A.PB_DIRECT,'N') = 'Y'				";
			}else {
				$query .= "	AND IFNULL(A.PB_DIRECT,'N') != 'Y'				";
			}

			$query .= "ORDER BY B.P_SHOP_NO, A.PB_NO DESC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();
			return $db->getExecSql($query);
		}
	}

	function getProdBasketAddList($db)
	{
		$query  = "SELECT									";
		$query .= "     A.*									";
		$query .= "FROM ".TBL_PRODUCT_BASKET_ADD." A		";
		$query .= "WHERE A.PB_NO = ".$this->getPB_NO()."	";
		$query .= "ORDER BY A.PBA_NO DESC					";

		return $db->getArrayTotal($query);
	}

	function getProdBasketItemList($db)
	{
		$query  = "SELECT									";
		$query .= "     A.*									";
		$query .= "FROM PRODUCT_BASKET_ITEM A				";
		$query .= "WHERE A.PB_NO = ".$this->getPB_NO()."	";
		$query .= "ORDER BY A.PBI_NO ASC					";

		return $db->getArrayTotal($query);
	}

	function getProdBasketShopList($db)
	{
		$query  = "SELECT A.*, B.*				";
		$query .= "FROM (						";
		$query .= "	SELECT				                    ";
		$query .= "		IFNULL(B.P_SHOP_NO,0) P_SHOP_NO     ";
		$query .= "    ,COUNT(*) BASKET_CNT                 ";
		$query .= "    ,SUM((A.PB_PRICE * A.PB_QTY) + A.PB_ADD_OPT_PRICE) BASKET_PRICE	";
		$query .= " FROM ".TBL_PRODUCT_BASKET." A			";
		$query .= " JOIN ".TBL_PRODUCT_MGR." B	";
		$query .= "	ON A.P_CODE = B.P_CODE					";
		$query .= "	WHERE A.PB_NO IS NOT NULL                ";


		if ($this->getM_NO()){
			$query .= "	AND A.M_NO = ".$this->getM_NO()."	";

			if ($this->getPB_ALL_NO()) {
				$query .= " AND A.PB_NO IN (".$this->getPB_ALL_NO().")	";
			}

			if ($this->getPB_DIRECT() == "Y"){
				$query .= "	AND IFNULL(A.PB_DIRECT,'N') = 'Y'				";
			} else {
				$query .= "	AND IFNULL(A.PB_DIRECT,'N') != 'Y'				";
			}

		} else {
			if (!$this->getPB_ALL_NO()) {
				$query .= "	AND A.PB_KEY = '".$this->getPB_KEY()."'		";

				if ($this->getPB_DIRECT() == "Y"){
					$query .= "	AND IFNULL(A.PB_DIRECT,'N') = 'Y'				";
				} else {
					$query .= "	AND IFNULL(A.PB_DIRECT,'N') != 'Y'				";
				}
			} else {
				$query .= " AND A.PB_NO IN (".$this->getPB_ALL_NO().")	";
			}
		}
		$query .= " GROUP BY IFNULL(B.P_SHOP_NO,0)          ";
		$query .= ") A										";
		$query .= "LEFT OUTER JOIN ".TBL_SHOP_MGR." B		";
		$query .= "ON A.P_SHOP_NO = B.SH_NO					";
		$result = $db->getExecSql($query);
		while($row = mysql_fetch_array($result)){
			$aryCode[$row[P_SHOP_NO]] = $row;
		}

		return $aryCode;
	}

	/* Wish 리스트 */

	function getProdWishTotal($db)
	{
		global $S_SITE_LNG;
		global $S_PROD_MANY_LANG_VIEW;
		$this->setP_LNG($S_SITE_LNG);

		$query =    "SELECT									";
		$query .= "     COUNT(*)							";
		$query .= "FROM ".TBL_PRODUCT_WISH." A			";
		$query .= "LEFT OUTER JOIN ".TBL_PRODUCT_MGR." B	";
		$query .= "ON A.P_CODE = B.P_CODE					";

		if ($S_PROD_MANY_LANG_VIEW == "Y"){
			$query .= "JOIN ".TBL_PRODUCT_INFO_LNG.$this->getP_LNG()." AI	";
			$query .= "ON A.P_CODE = AI.P_CODE								";
		}

		$query .= "WHERE A.PW_NO IS NOT NULL				";
		if ($S_PROD_MANY_LANG_VIEW == "Y") $query .= "	AND IFNULL(AI.P_WEB_VIEW,'N') = 'Y'		";
		else $query .= "	AND IFNULL(B.P_WEB_VIEW,'N') = 'Y'		";

		if ($this->getM_NO()){
			$query .= "	AND A.M_NO = ".$this->getM_NO()."						";
		}

		if ($this->getPW_ALL_NO()){
			$query .= " AND A.PB_NO IN (".$this->getPW_ALL_NO().") ";
		}


		return $db->getCount($query);
	}

	function getProdWishList($db)
	{
		global $S_SITE_LNG;
		global $S_PROD_MANY_LANG_VIEW;

		$this->setP_LNG($S_SITE_LNG);

		$query =    "SELECT									";
		$query .= "     A.*									";
		$query .= "    ,AI.P_NAME							";
		$query .= "    ,B.P_BAESONG_TYPE					";
		$query .= "    ,B.P_BAESONG_PRICE					";
		$query .= "    ,B.P_EVENT_UNIT						";
		$query .= "    ,B.P_EVENT							";
		$query .= "    ,B.P_MIN_QTY							";
		$query .= "    ,B.P_MAX_QTY							";
		$query .= "    ,C.PM_REAL_NAME						";
		$query .= "FROM ".TBL_PRODUCT_WISH." A				";
		$query .= "LEFT OUTER JOIN ".TBL_PRODUCT_MGR." B	";
		$query .= "ON A.P_CODE = B.P_CODE					";
		$query .= "JOIN ".TBL_PRODUCT_INFO_LNG.$this->getP_LNG()." AI	";
		$query .= "ON A.P_CODE = AI.P_CODE								";
		$query .= "LEFT OUTER JOIN ".TBL_PRODUCT_IMG." C	";
		$query .= "ON A.P_CODE = C.P_CODE					";
		$query .= "AND C.PM_TYPE = 'list'					";
		$query .= "WHERE A.PW_NO IS NOT NULL				";
		if ($S_PROD_MANY_LANG_VIEW == "Y") $query .= "	AND IFNULL(AI.P_WEB_VIEW,'N') = 'Y'		";
		else $query .= "	AND IFNULL(B.P_WEB_VIEW,'N') = 'Y'		";


		if ($this->getM_NO()){
			$query .= "	AND A.M_NO = ".$this->getM_NO()."						";
		}

		if ($this->getPW_ALL_NO()){
			$query .= " AND A.PW_NO IN (".$this->getPW_ALL_NO().") ";

			if ($this->getPW_ALL_SORT() == "Y"){
				$query .= "ORDER BY A.PW_NO ASC ";
				return $db->getArrayTotal($query);
			} else {
				$query .= "ORDER BY A.PW_NO DESC ";
				return $db->getExecSql($query);
			}

		} else {
			$query .= "ORDER BY A.PW_NO DESC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();
			return $db->getExecSql($query);
		}
	}

	function getProdWishAddList($db)
	{
		$query  = "SELECT									";
		$query .= "     A.*									";
		$query .= "FROM ".TBL_PRODUCT_WISH_ADD." A		";
		$query .= "WHERE A.PW_NO = ".$this->getPW_NO()."	";
		$query .= "ORDER BY A.PWA_NO DESC					";

		return $db->getArrayTotal($query);
	}

	function getProdWishItemList($db)
	{
		$query  = "SELECT									";
		$query .= "     A.*									";
		$query .= "FROM PRODUCT_WISH_ITEM A					";
		$query .= "WHERE A.PW_NO = ".$this->getPW_NO()."	";
		$query .= "ORDER BY A.PWI_NO ASC					";

		return $db->getArrayTotal($query);
	}


	/* 상품 브랜드 상세보기 */
	function getProdBrandView($db)
	{
		$query  = "SELECT A.* ";
		$query .= "    ,(SELECT COUNT(*) FROM PRODUCT_MGR WHERE P_BRAND = A.PR_NO) PROD_CNT  ";
		$query .= "FROM ".TBL_PRODUCT_BRAND." A WHERE A.PR_NO IS NOT NULL";

		if($this->getPR_NO()):
			$query = "{$query} AND A.PR_NO = {$this->getPR_NO()}";
		endif;

		return $db->getSelect($query);
	}

	function getProdBrandLngList($db, $op="OP_LIST")
	{
		$query = "SELECT * FROM " . TBL_PRODUCT_BRAND_LNG . " ";
		$where = "";
		$order = "ORDER BY PL_NO DESC ";

		/** where **/
		if($this->getPL_NO()):
			$where .= "AND PL_NO = '{$this->getPL_NO()}' ";
		endif;

		if($this->getPL_PR_NO()):
			$where .= "AND PL_PR_NO = '{$this->getPL_PR_NO()}' ";
		endif;

		if($this->getPL_LNG()):
			$where .= "AND PL_LNG = '{$this->getPL_LNG()}' ";
		endif;

		if($where):
			$query = $query . "WHERE PL_NO IS NOT NULL " . $where;
		endif;
		/** where **/

		if($order):
			$query = $query . $order;
		endif;

		return $this->getSelectQuery($db, $query, $op);
	}
	/* 고객 첫구매 사은품 */
	function getCusGiftList($db)
	{
		global $S_SITE_LNG;

		$query  = "SELECT							";
		$query .= "      A.*						";
		$query .= "		,B.CG_NAME					";
		$query .= "		,B.CG_OPT_NM1				";
		$query .= "		,B.CG_OPT_NM2				";
		$query .= "		,B.CG_OPT_ATTR1				";
		$query .= "		,B.CG_OPT_ATTR2				";
		$query .= "FROM ".TBL_GIFT_MGR." A          ";
		$query .= "JOIN ".TBL_GIFT_LNG." B			";
		$query .= "ON A.CG_NO = B.CG_NO				";
		$query .= "AND B.CG_LNG = '".$S_SITE_LNG."'	";
		$query .= "WHERE A.CG_EACH_USE = 'N'		";
		$query .= "    AND A.CG_FIRST_GIFT IN (".$this->getGIFT_FIRST_TYPE().")	";
		$query .= "    AND A.CG_VIEW = 'Y'			";
		$query .= "    AND (A.CG_STOCK = 'N' OR A.CG_QTY > 0)	";

		if ($this->getGIFT_LIMIT_PRICE() > 0){
			$query .= " AND (						";
			$query .= "		(A.CG_PRICE_TYPE = '1' AND ".$this->getGIFT_LIMIT_PRICE()." BETWEEN A.CG_ST_PRICE AND A.CG_END_PRICE)	";
			$query .= "	 OR							";
			$query .= "		(A.CG_PRICE_TYPE = '2' AND ".$this->getGIFT_LIMIT_PRICE()." >=  A.CG_ST_PRICE)							";
			$query .= "	)							";
		}
		$query .= "ORDER BY A.CG_NO ASC				";

		return $db->getArrayTotal($query);
	}

	function getCusGiftView($db)
	{
		global $S_SITE_LNG;

		$query  = "SELECT							";
		$query .= "      A.*						";
		$query .= "		,B.CG_NAME					";
		$query .= "		,B.CG_OPT_NM1				";
		$query .= "		,B.CG_OPT_NM2				";
		$query .= "		,B.CG_OPT_ATTR1				";
		$query .= "		,B.CG_OPT_ATTR2				";
		$query .= "FROM ".TBL_GIFT_MGR." A          ";
		$query .= "JOIN ".TBL_GIFT_LNG." B			";
		$query .= "ON A.CG_NO = B.CG_NO				";
		$query .= "AND B.CG_LNG = '".$S_SITE_LNG."'	";
		$query .= "WHERE A.CG_NO = ".$this->getGIFT_NO();

		return $db->getSelect($query);
	}

	/* 상품 배송정책(입점사별로) */
	function getProdDeliveryShopInfo($db)
	{
		$query  = "SELECT SH_COM_DELIVERY_TEXT FROM SHOP_MGR ";
		$query .= "	WHERE SH_COM_DELIVERY = 'S' AND SH_NO = ".$this->getP_SHOP_NO();

		return $db->getCount($query);
	}

	/********************************** Insert **********************************/

	/* 장바구니 */
	function getProdBasketInsertUpdate($db)
	{
		$query = "CALL SP_PRODUCT_BASKET_IU (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getPB_KEY();
		$param[]  = $this->getM_NO();
		$param[]  = $this->getP_CODE();
		$param[]  = $this->getPB_OPT_NO();
		$param[]  = $this->getPB_OPT_NM1();
		$param[]  = $this->getPB_OPT_NM2();
		$param[]  = $this->getPB_OPT_NM3();
		$param[]  = $this->getPB_OPT_NM4();
		$param[]  = $this->getPB_OPT_NM5();
		$param[]  = $this->getPB_OPT_NM6();
		$param[]  = $this->getPB_OPT_NM7();
		$param[]  = $this->getPB_OPT_NM8();
		$param[]  = $this->getPB_OPT_NM9();
		$param[]  = $this->getPB_OPT_NM10();

		$param[]  = $this->getPB_OPT_ATTR1();
		$param[]  = $this->getPB_OPT_ATTR2();
		$param[]  = $this->getPB_OPT_ATTR3();
		$param[]  = $this->getPB_OPT_ATTR4();
		$param[]  = $this->getPB_OPT_ATTR5();
		$param[]  = $this->getPB_OPT_ATTR6();
		$param[]  = $this->getPB_OPT_ATTR7();
		$param[]  = $this->getPB_OPT_ATTR8();
		$param[]  = $this->getPB_OPT_ATTR9();
		$param[]  = $this->getPB_OPT_ATTR10();
		$param[]  = $this->getPB_QTY();
		$param[]  = $this->getPB_STOCK_PRICE();
		$param[]  = $this->getPB_PRICE();
		$param[]  = $this->getPB_POINT();
		$param[]  = $this->getPB_DELIVERY_TYPE();
		$param[]  = $this->getPB_DELIVERY_EXP();
		$param[]  = $this->getPB_ADD_OPT_PRICE();
		$param[]  = $this->getPB_DIRECT();

		return $db->executeBindingQuery($query,$param,true);
	}

	function getProdBasketAddOptInsertUpdate($db)
	{
		$query = "CALL SP_PRODUCT_BASKET_ADD_IU (?,?,?,?,?);";

		$param[]  = $this->getPB_NO();
		$param[]  = $this->getPBA_OPT_NO();
		$param[]  = $this->getPBA_OPT_NM();
		$param[]  = $this->getPBA_OPT_PRICE();
		$param[]  = $this->getPBA_OPT_QTY();

		return $db->executeBindingQuery($query,$param,true);
	}

	function getProdBasketQtyUpdate($db)
	{
		$query  = "UPDATE ".TBL_PRODUCT_BASKET." SET PB_QTY = ".$this->getPB_QTY();
		$query .= "	WHERE PB_NO = ".$this->getPB_NO();

		return $db->getExecSql($query);
	}

	function getProdBasketPriceUpdate($db)
	{
		$query  = "UPDATE ".TBL_PRODUCT_BASKET." SET PB_PRICE = ".$this->getPB_PRICE();
		$query .= ",PB_POINT = ".$this->getPB_POINT()."	";
		$query .= ",PB_STOCK_PRICE = ".$this->getPB_STOCK_PRICE()."	";
		$query .= "	WHERE PB_NO = ".$this->getPB_NO();

		return $db->getExecSql($query);
	}

	function getProdBasketDisCountPriceUpdate($db)
	{
		$query  = "UPDATE ".TBL_PRODUCT_BASKET." SET PB_DISCOUNT_PRICE = ".$this->getPB_PRICE();
		$query .= ",PB_DISCOUNT_POINT = ".$this->getPB_POINT()."	";
		$query .= "	WHERE PB_NO = ".$this->getPB_NO();

		return $db->getExecSql($query);
	}

	function getProdBasketLoginUpdate($db)
	{
		$query = "CALL SP_MEMBER_LOGIN_BASKET_U (?,?);";

		$param[]  = $this->getPB_KEY();
		$param[]  = $this->getM_NO();

		return $db->executeBindingQuery($query,$param,true);
	}

	function getProdBasketOrderLoginUpdate($db)
	{
		$query  = "UPDATE ".TBL_PRODUCT_BASKET." SET M_NO = ".$this->getM_NO().", PB_KEY = NULL, PB_DIRECT = 'Y' ";
		$query .= "	WHERE PB_NO = '".$this->getPB_NO()."'" ;
		return $db->getExecSql($query);
	}

	/* WISH 리스트 */
	function getProductWishInsertUpdate($db)
	{
		$query = "CALL SP_PRODUCT_WISH_IU (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getM_NO();
		$param[]  = $this->getP_CODE();
		$param[]  = $this->getPW_OPT_NO();
		$param[]  = $this->getPW_OPT_NM1();
		$param[]  = $this->getPW_OPT_NM2();
		$param[]  = $this->getPW_OPT_NM3();
		$param[]  = $this->getPW_OPT_NM4();
		$param[]  = $this->getPW_OPT_NM5();
		$param[]  = $this->getPW_OPT_NM6();
		$param[]  = $this->getPW_OPT_NM7();
		$param[]  = $this->getPW_OPT_NM8();
		$param[]  = $this->getPW_OPT_NM9();
		$param[]  = $this->getPW_OPT_NM10();
		$param[]  = $this->getPW_OPT_ATTR1();
		$param[]  = $this->getPW_OPT_ATTR2();
		$param[]  = $this->getPW_OPT_ATTR3();
		$param[]  = $this->getPW_OPT_ATTR4();
		$param[]  = $this->getPW_OPT_ATTR5();
		$param[]  = $this->getPW_OPT_ATTR6();
		$param[]  = $this->getPW_OPT_ATTR7();
		$param[]  = $this->getPW_OPT_ATTR8();
		$param[]  = $this->getPW_OPT_ATTR9();
		$param[]  = $this->getPW_OPT_ATTR10();
		$param[]  = $this->getPW_QTY();
		$param[]  = $this->getPW_STOCK_PRICE();
		$param[]  = $this->getPW_PRICE();
		$param[]  = $this->getPW_POINT();
		$param[]  = $this->getPW_DELIVERY_TYPE();
		$param[]  = $this->getPW_DELIVERY_PRICE();
		$param[]  = $this->getPW_DELIVERY_EXP();
		$param[]  = $this->getPW_ADD_OPT_PRICE();

		return $db->executeBindingQuery($query,$param,true);
	}

	function getProductWishAddInsertUpdate($db)
	{
		$query = "CALL SP_PRODUCT_WISH_ADD_IU (?,?,?,?,?);";

		$param[]  = $this->getPW_NO();
		$param[]  = $this->getPWA_OPT_NO();
		$param[]  = $this->getPWA_OPT_NM();
		$param[]  = $this->getPWA_OPT_PRICE();
		$param[]  = $this->getPWA_OPT_QTY();

		return $db->executeBindingQuery($query,$param,true);
	}

	function getProdWishQtyUpdate($db)
	{
		$query  = "UPDATE ".TBL_PRODUCT_WISH." SET PW_QTY = ".$this->getPW_QTY();
		$query .= "	WHERE PW_NO = ".$this->getPW_NO();

		return $db->getExecSql($query);
	}

	function getProdWishPriceUpdate($db)
	{
		$query  = "UPDATE ".TBL_PRODUCT_WISH." SET PW_PRICE = ".$this->getPW_PRICE();
		$query .= ",PW_POINT		= ".$this->getPW_POINT()."	";
		$query .= ",PW_STOCK_PRICE	= ".$this->getPW_STOCK_PRICE()."	";
		$query .= "	WHERE PW_NO		= ".$this->getPW_NO();

		return $db->getExecSql($query);
	}

	/********************************** 제조사/ 목록 **********************************/
	function getProductColGroupList($db)
	{
		$query  = "SELECT ".$this->getColumn()." AS COL FROM ".TBL_PRODUCT_MGR;
		$query .= "	WHERE ".$this->getColumn()." IS NOT NULL ";
		$query .= "	  AND ".$this->getColumn()." != '' ";
		$query .= " GROUP BY ".$this->getColumn();
		return $db->getArrayTotal($query);
	}

	function getProdOptQtyUpdate($db)
	{
		$query  = "UPDATE ".TBL_PRODUCT_OPT_ATTR." SET POA_STOCK_QTY = POA_STOCK_QTY + ".$this->getPOA_STOCK_QTY();
		$query .= "	WHERE POA_NO = ".$this->getPOA_NO();

		return $db->getExecSql($query);
	}

	function getProdStockOptQtyUpdate($db)
	{
		$query  = "UPDATE ".TBL_PRODUCT_OPT_ATTR." SET POA_STOCK_QTY = ".$this->getPOA_STOCK_QTY();

		if ($this->getPOA_NO() > 0) {
			$query .= "	WHERE POA_NO = ".$this->getPOA_NO();
		} else {
			$query .= "	WHERE PO_NO IN (SELECT PO_NO FROM ".TBL_PRODUCT_OPT." WHERE P_CODE = '".$this->getP_CODE()."')";
		}

		return $db->getExecSql($query);
	}

	function getProdQtyUpdate($db)
	{
		$query  = "UPDATE ".TBL_PRODUCT_MGR." SET P_QTY = P_QTY + ".$this->getP_QTY();
		$query .= "	WHERE P_CODE = '".$this->getP_CODE()."'";

		return $db->getExecSql($query);
	}

	function getProdQtyCalc ( $db )
	{
		if ( $this->get_option_type () == 'O' )
		{
			$query  = 'SELECT POA_STOCK_QTY + ' . $this->getPOA_STOCK_QTY() . ' AS PSQ FROM ' . TBL_PRODUCT_OPT_ATTR ;
			$query .= '	WHERE POA_NO = ' . $this->getPOA_NO() ;
		}
		else
		{
			$query  = 'SELECT P_QTY + ' . $this->getP_QTY() . ' AS PSQ FROM ' . TBL_PRODUCT_MGR ;
			$query .= '	WHERE P_CODE = \'' . $this->getP_CODE() . '\'' ;
		}

		return $db->getSelect ( $query ) ;
	}


	function getProdStockQtyUpdate($db)
	{
		$query  = "UPDATE ".TBL_PRODUCT_MGR." SET P_QTY = ".$this->getP_QTY();
		$query .= "	,P_STOCK_OUT	= '".$this->getP_STOCK_OUT()."'";
		$query .= "	,P_RESTOCK		= '".$this->getP_RESTOCK()."'";
		$query .= "	,P_STOCK_LIMIT	= '".$this->getP_STOCK_LIMIT()."'";
		$query .= "	WHERE P_CODE = '".$this->getP_CODE()."'";

		return $db->getExecSql($query);
	}
	/********************************** Modify **********************************/



	/********************************** Delete **********************************/
	function getProductBasketAddDelete($db)
	{
		$query = "DELETE FROM ".TBL_PRODUCT_BASKET_ADD." WHERE PB_NO = ".$this->getPB_NO();
		return $db->getExecSql($query);
	}

	function getProductBasketItemDelete($db)
	{
		$query = "DELETE FROM PRODUCT_BASKET_ITEM WHERE PB_NO = ".$this->getPB_NO();
		return $db->getExecSql($query);
	}

	function getProductBasketDelete($db)
	{
		$query = "DELETE FROM ".TBL_PRODUCT_BASKET." WHERE PB_NO = ".$this->getPB_NO();
		return $db->getExecSql($query);
	}

	/********************************** 카테고리로 등록된 상품 수 확인 **********************************/
	function getProductCateTotal($db)
	{
		$query  = "SELECT COUNT(*) FROM ".TBL_PRODUCT_MGR;
		$query .= "	WHERE P_CATE LIKE '".$this->getP_CATE()."%' ";

		return $db->getCount($query);
	}

	/********************************** Wish 삭제 **********************************/

	function getProductWishAddDelete($db)
	{
		$query = "DELETE FROM ".TBL_PRODUCT_WISH_ADD." WHERE PW_NO = ".$this->getPW_NO();
		return $db->getExecSql($query);
	}

	function getProductWishItemDelete($db)
	{
		$query = "DELETE FROM PRODUCT_WISH_ITEM WHERE PW_NO = ".$this->getPW_NO();
		return $db->getExecSql($query);
	}

	function getProductWishDelete($db)
	{
		$query = "DELETE FROM ".TBL_PRODUCT_WISH." WHERE PW_NO = ".$this->getPW_NO();
		return $db->getExecSql($query);
	}

	/********************************** Wish No **********************************/
	function getProductWishNo($db)
	{
		$query   = "SELECT PW_NO FROM ".TBL_PRODUCT_WISH."			";
		$query  .= "WHERE M_NO			=  ".$this->getM_NO();
		$query  .= "	AND P_CODE		= '".$this->getP_CODE()."'	";
		$query  .= "    AND PW_OPT_NO	=  ".$this->getPW_OPT_NO();
		return $db->getCount($query);
	}

	/********************************** Product Top Search Word **********************************/
	function getProdTopSearchWordInsertUpdate($db)
	{
		$query = "CALL SP_SEARCH_WORD_IU (?);";

		$param[]  = $this->getSearchKey();

		return $db->executeBindingQuery($query,$param,true);
	}

	/********************************** 입점사정보 **********************************/
	function getShopView($db)
	{
		$query  = "SELECT ";
		$query .= " SH.SH_TYPE ";
		$query .= " ,SH.SH_COM_TYPE ";
		if($this->getP_LNG())
		{
		//$query .= " ,SI.SH_COM_NUM ";
		$query .= " ,SI.SH_COM_NAME ";
		$query .= " ,SI.SH_COM_REP_NM ";
		//$query .= " ,SI.SH_COM_PHONE ";
		//$query .= " ,SI.SH_COM_FAX ";
		//$query .= " ,SI.SH_COM_MAIL ";
		//$query .= " ,SI.SH_COM_CATEGORY ";
		$query .= " ,SI.SH_COM_ZIP ";
		$query .= " ,SI.SH_COM_ADDR ";
		//$query .= " ,SI.SH_COM_COUNTRY ";
		$query .= " ,SI.SH_COM_CITY ";
		$query .= " ,SI.SH_COM_INTRO1 ";
		$query .= " ,SI.SH_COM_INTRO2 ";
		$query .= " ,SI.SH_COM_LOCAL ";
		$query .= " ,SI.SH_COM_SIZE ";
		$query .= " ,SI.SH_COM_CATE ";
		}else{
		//$query .= " ,SH.SH_COM_NUM ";
		$query .= " ,SH.SH_COM_NAME ";
		$query .= " ,SH.SH_COM_REP_NM ";
		//$query .= " ,SH.SH_COM_PHONE ";
		//$query .= " ,SH.SH_COM_FAX ";
		//$query .= " ,SH.SH_COM_MAIL ";
		//$query .= " ,SH.SH_COM_CATEGORY ";
		$query .= " ,SH.SH_COM_ZIP ";
		$query .= " ,SH.SH_COM_ADDR ";
		//$query .= " ,SH.SH_COM_COUNTRY ";
		$query .= " ,SH.SH_COM_CITY ";
		$query .= " ,SH.SH_COM_INTRO1 ";
		$query .= " ,SH.SH_COM_INTRO2 ";
		$query .= " ,SH.SH_COM_LOCAL ";
		$query .= " ,SH.SH_COM_SIZE ";
		$query .= " ,SH.SH_COM_CATE ";
		}
		$query .= " ,SH.SH_COM_COUNTRY ";
		$query .= " ,SH.SH_COM_NUM ";
		$query .= " ,SH.SH_COM_PHONE ";
		$query .= " ,SH.SH_COM_FAX ";
		$query .= " ,SH.SH_COM_MAIL ";
		$query .= " ,SH.SH_COM_CATEGORY ";
		$query .= " ,SH.SH_COM_NUM2 ";
		$query .= " ,SH.SH_COM_UPTAE ";
		$query .= " ,SH.SH_COM_UPJONG ";
		$query .= " ,SH.SH_COM_STATE ";
		$query .= " ,SH.SH_COM_FILE1 ";
		$query .= " ,SH.SH_COM_FILE2 ";
		$query .= " ,SH.SH_COM_FILE3 ";
		$query .= " ,SH.SH_COM_FILE4 ";
		$query .= " ,SH.SH_COM_FILE5 ";
		$query .= " ,SH.SH_COM_DEPOSIT ";
		$query .= " ,SH.SH_COM_BANK ";
		$query .= " ,SH.SH_COM_BANK_NUM ";
		$query .= " ,SH.SH_COM_ACC_PRICE ";
		$query .= " ,SH.SH_COM_ACC_RATE ";
		$query .= " ,SH.SH_COM_DELIVERY ";
		$query .= " ,SH.SH_COM_DELIVERY_ST_PRICE ";
		$query .= " ,SH.SH_COM_DELIVERY_PRICE ";
		$query .= " ,SH.SH_COM_DELIVERY_COR ";
		$query .= " ,SH.SH_COM_DELIVERY_FOR_COR ";
		$query .= " ,SH.SH_COM_DELIVERY_FREE ";
		$query .= " ,SH.SH_COM_DEVLIERY_PROD ";
		$query .= " ,SH.SH_COM_DELIVERY_AREA ";
		$query .= " ,SH.SH_COM_DELIVERY_TEXT ";
		$query .= " ,SH.SH_COM_PROD_AUTH ";
		$query .= " ,SH.SH_COM_MAIN ";
		$query .= " ,SH.SH_APPR ";
		$query .= " ,SH.SH_APPR_NO_REASON ";
		$query .= " ,SH.SH_COM_SITE ";
		$query .= " ,SH.SH_COM_FOUNDED ";
		$query .= " ,SH.SH_COM_NUMBER ";
		$query .= " ,SH.SH_COM_TOTAL_SALE ";
		$query .= " ,SH.SH_COM_RATE ";
		$query .= " ,SH.SH_COM_TOTAL_PRODUCTION ";
		$query .= " ,SH.SH_COM_COUNTRY1 ";
		$query .= " ,SH.SH_COM_COUNTRY2 ";
		$query .= " ,SH.SH_COM_COUNTRY3 ";
		$query .= " ,SH.SH_COM_COUNTRY4 ";
		$query .= " ,SH.SH_COM_COUNTRY5 ";
		$query .= " ,SH.SH_COM_COUNTRY6 ";
		$query .= " ,SH.SH_COM_COUNTRY7 ";
		$query .= " ,SH.SH_COM_COUNTRY8 ";
		$query .= " ,SH.SH_COM_COUNTRY9 ";
		$query .= " ,SH.SH_COM_COUNTRY10 ";
		$query .= " ,SH.SH_COM_COUNTRY11 ";
		$query .= " ,SH.SH_COM_COUNTRY12 ";
		$query .= " ,SH.SH_COM_COUNTRY13 ";
		$query .= " ,SH.SH_COM_COUNTRY14 ";
		$query .= " ,SH.SH_COM_RD ";
		$query .= " ,SH.SH_COM_CERTIFICATES1 ";
		$query .= " ,SH.SH_COM_CERTIFICATES1_FILE ";
		$query .= " ,SH.SH_COM_CERTIFICATES2 ";
		$query .= " ,SH.SH_COM_CERTIFICATES2_FILE ";
		$query .= " ,SH.SH_COM_CERTIFICATES3 ";
		$query .= " ,SH.SH_COM_CERTIFICATES3_FILE ";
		$query .= " ,SH.SH_COM_CERTIFICATES4 ";
		$query .= " ,SH.SH_COM_CERTIFICATES4_FILE ";
		$query .= " ,SH.SH_COM_CERTIFICATES5 ";
		$query .= " ,SH.SH_COM_CERTIFICATES5_FILE ";
		$query .= " ,SH.SH_COM_CREDIT_GRADE ";
		$query .= " ,SH.SH_COM_SALE_GRADE ";
		$query .= " ,SH.SH_COM_LOCUS_GRADE ";
		$query .= " ,SH.SH_REQUEST_DT ";
		$query .= " ,SH.SH_ADMISSION_DT ";
		$query .= " ,SH.SH_REG_DT ";
		$query .= " ,SH.SH_REG_NO ";
		$query .= " ,SH.SH_MOD_DT ";
		$query .= " ,SH.SH_MOD_NO ";
		$query .= " FROM ".TBL_SHOP_MGR." SH ";
		if($this->getP_LNG()){
		$query .= " LEFT JOIN ".TBL_SHOP_INFO_LNG.$this->getP_LNG()." SI          ";
		$query .= " ON SH.SH_NO = SI.SH_NO                              ";
		}
		$query .= " WHERE SH.SH_NO = ".$this->getP_SHOP_NO();
		return $db->getSelect($query);
	}

	/********************************** 상품 좋아요  **********************************/
	function getProdLikeList($db,$op,$param)
	{

		$column['OP_COUNT'] = "COUNT(*) ";
		$query  = "SELECT ";
		$query .= $column[$op];
		$query .= "FROM ".TBL_MEMBER_PROD_LIKE." A	";
		$query .= "WHERE A.M_NO IS NOT NULL			";

		if ($param['M_NO']){
			$query .= " AND A.M_NO = ".$param['M_NO']."				";
		}

		if ($param['P_CODE']){
			$query .= " AND A.P_CODE = '".$param['P_CODE']."'	";
		}

		return $this->getSelectQuery($db,$query,$op);
	}

	function getProdLikeUpdateDelete($db,$param)
	{
		if ($param['LIKE_TYPE'] == "Y"){
			$query  = "INSERT INTO ".TBL_MEMBER_PROD_LIKE." (M_NO,P_CODE) VALUES (";
			$query .= $param['M_NO'].",'".$param['P_CODE']."')	";
		}

		if ($param['LIKE_TYPE'] == "N"){
			$query  = "DELETE FROM ".TBL_MEMBER_PROD_LIKE."	";
			$query .= "WHERE M_NO = ".$param['M_NO']."		";
			$query .= "	AND P_CODE = '".$param['P_CODE']."'	";
		}
		return $db->getExecSql($query);
	}

	function getProdLikeAllDelete($db,$param)
	{
		$query  = "DELETE FROM ".TBL_MEMBER_PROD_LIKE."	";
		$query .= "WHERE M_NO = ".$param['M_NO']."		";

		return $db->getExecSql($query);
	}


	/*
	 * 상품대량구매요청 게시판 insert
	 */
	function getProdLargeBuyInsert($db,$param)
	{
		$query  = "INSERT INTO BOARD_UB_PROD_BUY		";
		$query .= "(									";
		$query .= "    UB_NAME,							";
		$query .= "    UB_M_NO,							";
		$query .= "    UB_M_ID,							";
		$query .= "    UB_PASS,							";
		$query .= "    UB_MAIL,							";
		$query .= "    UB_URL,							";
		$query .= "    UB_TITLE,						";
		$query .= "    UB_TEXT,							";
		$query .= "    UB_TEXT_MOBILE,					";
		$query .= "    UB_FUNC,							";
		$query .= "    UB_IP,							";
		$query .= "    UB_READ,							";
		$query .= "    UB_BC_NO,						";
		$query .= "    UB_LNG,							";
		$query .= "    UB_ANS_NO,						";
		$query .= "    UB_ANS_STEP,						";
		$query .= "    UB_ANS_M_NO,						";
		$query .= "    UB_PT_NO,						";
		$query .= "    UB_CI_NO,						";
		$query .= "    UB_WINNER,						";
		$query .= "    UB_P_CODE,						";
		$query .= "    UB_P_GRADE,						";
		$query .= "    UB_REG_DT,						";
		$query .= "    UB_REG_NO,						";
		$query .= "    UB_MOD_DT,						";
		$query .= "    UB_MOD_NO						";
		$query .= ")									";
		$query .= "VALUES								";
		$query .= "(									";
		$query .= "     '".$param['UB_NAME']."'			";
		$query .= "    ,'".$param['UB_M_NO']."'			";
		$query .= "    ,'".$param['UB_M_ID']."'			";
		$query .= "    ,'".$param['UB_PASS']."'			";
		$query .= "    ,'".$param['UB_M_MAIL']."'		";
		$query .= "    ,''								";
		$query .= "    ,'".$param['UB_TITLE']."'		";
		$query .= "    ,'".$param['UB_TEXT']."'			";
		$query .= "    ,'".$param['UB_TEXT']."'			";
		$query .= "    ,'NYNNNNNNNN'					";
		$query .= "    ,'".$param['UB_IP']."'			";
		$query .= "    ,0								";
		$query .= "    ,0								";
		$query .= "    ,'KR'							";
		$query .= "    ,0								";
		$query .= "    ,''								";
		$query .= "    ,'".$param['UB_M_NO']."'			";
		$query .= "    ,0								";
		$query .= "    ,0								";
		$query .= "    ,''								";
		$query .= "    ,'".$param['UB_P_CODE']."'		";
		$query .= "    ,'".$param['UB_P_GRADE']."'      ";
		$query .= "    ,NOW()							";
		$query .= "    ,'".$param['UB_REG_NO']."'		";
		$query .= "    ,NOW()							";
		$query .= "    ,'".$param['UB_REG_NO']."'		";
		$query .= ")									";

		return $db->getExecSql($query);
	}

	/*
	 * 상품대량구매요청 게시판 REPLY UPDATE
	 */
	function getProdLargeBuyReplyUpdate($db,$param)
	{
		$query = "UPDATE BOARD_UB_PROD_BUY SET UB_ANS_NO = {$param['UB_NO']} WHERE UB_NO = {$param['UB_NO']}	";
		return $db->getExecSql($query);
	}

	/*
	 ** 상품 총합의 discount 기능
	 */
	function getProdTotalPriceMaxDiscountRate($db,$param)
	{
		$query  = "SELECT                                           ";
		$query .= "    IFNULL(MIN(SD_RATE),0)                       ";
		$query .= "FROM SITE_DISCOUNT                               ";
		$query .= "WHERE ".$param['PROD_TOTAL_PRICE']." BETWEEN SD_ST_PRICE AND SD_END_PRICE  ";

		return $db->getCount($query);
	}

	function getProdTotalPriceMaxNextDiscountInfo($db,$param)
	{
		$query  = "SELECT * FROM SITE_DISCOUNT											";
		$query .= "WHERE SD_RATE > {$param['PROD_TOTAL_DISCOUNT_RDATE']}				";
		$query .= "ORDER BY SD_RATE ASC LIMIT 1											";

		return $db->getSelect($query);
	}



	/*
	 * 상품장바구니 추가항목 insert
	 */
	function getProdBasketItemInsert($db,$param)
	{
		$query  = "INSERT INTO PRODUCT_BASKET_ITEM		";
		$query .= "(									";
		$query .= "    PB_NO,							";
		$query .= "    PBI_ITEM_NM,						";
		$query .= "    PBI_ITEM_VAL						";
		$query .= ")									";
		$query .= "VALUES								";
		$query .= "(									";
		$query .= "     '".mysql_real_escape_string($param['PB_NO'])."'					";
		$query .= "    ,'".mysql_real_escape_string($param['PBI_ITEM_NM'])."'			";
		$query .= "    ,'".mysql_real_escape_string($param['PBI_ITEM_VAL'])."'			";
		$query .= ")									";

		return $db->getExecSql($query);
	}

	/*
	 * 상품담아두기 추가항목 insert
	 */
	function getProdWishItemInsert($db,$param)
	{
		$query  = "INSERT INTO PRODUCT_WISH_ITEM		";
		$query .= "(									";
		$query .= "    PW_NO,							";
		$query .= "    PWI_ITEM_NM,						";
		$query .= "    PWI_ITEM_VAL						";
		$query .= ")									";
		$query .= "VALUES								";
		$query .= "(									";
		$query .= "     '".mysql_real_escape_string($param['PW_NO'])."'					";
		$query .= "    ,'".mysql_real_escape_string($param['PWI_ITEM_NM'])."'			";
		$query .= "    ,'".mysql_real_escape_string($param['PWI_ITEM_VAL'])."'			";
		$query .= ")									";

		return $db->getExecSql($query);
	}

	function getProdNotifySelectEx($db,$param,$op="OP_SELECT")
	{

		$column['OP_ARYTOTAL'] = "*";
		$column['OP_SELECT'] = "*";
		$column['OP_COUNT'] = "COUNT(*)";

		$query  = "SELECT ".$column[$op]." FROM PRODUCT_NOTIFY_KR WHERE P_CODE = '{$param['P_CODE']}' ";

		if ($param['PN_NAME']){
			$query .= "	AND PN_NAME = '{$param['PN_NAME']}' ";
		}

		if ($param['PN_SORT']){
			$query .= "ORDER BY PN_ORDER ASC	";
		}

		return $this->getSelectQuery($db,$query,$op);
	}

	/*
	 * 상품경매인지 확인
	 */
	function getProdAuctionCount($db,$param){
		$query  = "SELECT COUNT(*) FROM ".TBL_PROD_AUCTION."		";
		$query .= "WHERE NOW() BETWEEN P_AUC_ST_DT AND P_AUC_END_DT	";
		$query .= " AND P_CODE = '".$param['P_CODE']."'				";
		$query .= " AND P_AUC_STATUS IN (2,4,5)						";

		return $db->getCount($query);
	}

	function getProdAuctionView($db,$param){
		$query  = "SELECT PA.*								";
		$query .= " ,M.M_F_NAME								";
		$query .= " ,M.M_L_NAME								";
		$query .= " ,(SELECT COUNT(*) FROM ".TBL_PROD_AUCTION_APPLY." WHERE P_CODE = PA.P_CODE) P_AUC_APPLY_CNT	";
		$query .= " ,M2.M_F_NAME M_SUC_F_NAME 				";
		$query .= " ,M2.M_L_NAME M_SUC_L_NAME				";
		$query .= "FROM ".TBL_PROD_AUCTION." PA				";
		$query .= "LEFT OUTER JOIN ".TBL_MEMBER_MGR." M		";
		$query .= "ON PA.P_AUC_BEST_M_NO = M.M_NO			";
		$query .= "LEFT OUTER JOIN ".TBL_MEMBER_MGR." M2	";
		$query .= "ON PA.P_AUC_SUC_M_NO = M2.M_NO			";
		$query .= "WHERE NOW() BETWEEN PA.P_AUC_ST_DT AND PA.P_AUC_END_DT	";
		$query .= " AND PA.P_CODE = '".$param['P_CODE']."'	";
		$query .= " AND PA.P_AUC_STATUS IN (2,4,5)			";

		return $db->getSelect($query);
	}


	// 카테고리 리스트 가져오기
	function getProductCategoryList ( $db , $lng )
	{
		$lng = empty ( $lng ) ? 'KR' : $lng ;
		$query = 'SELECT A.C_CODE , A.C_LEVEL , B.CL_NAME FROM CATE_MGR AS A LEFT JOIN CATE_LNG AS B ON( A.C_CODE = B.C_CODE AND B.CL_LNG = \'' . $lng . '\' )' ;
		return $db->getArrayTotal( $query ) ;
	}

	// 입점사의 상품 값가져오기 (1개만)
	function getShopProduct ( $db )
	{
		$query	 = "	SELECT PM.P_CODE FROM ".TBL_PRODUCT_MGR." AS PM ";
		$query	.= "	LEFT OUTER JOIN ".TBL_PRODUCT_INFO_LNG.$this->getP_LNG()." AS PN ON PM.P_CODE = PN.P_CODE ";
		$query	.= "	WHERE PM.P_SHOP_NO = ".$this->getP_SHOP_NO()." ";
		$query	.= "		AND PN.P_WEB_VIEW = 'Y'";
		$query	.= "		AND PM.P_APPR = 'Y'";
		$query	.= "	ORDER BY P_CODE DESC";
		$query	.= "	LIMIT 1	" ;

		return $db->getSelect( $query ) ;
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
	/********************************** variable **********************************/

	/***상품리스트전체조건검색용****/
	function searchVarCheck($strVarName, $ary){
		global $_POST,$_REQUEST;
		$k=0;
		$c=0;
		$arySearchVar = array();
		$strSearchLCatecheck ="";
		for($i = 0 ; $i < sizeof($ary); $i++){
			
			$k = $i + 1;
			$strSearchLCatecheck			= $_POST["{$strVarName}{$k}"]				? $_POST["{$strVarName}{$k}"]			: $_REQUEST["{$strVarName}{$k}"];

			if($strSearchLCatecheck){
				//print_r($i);
				if($c > 0){
					$arySearchVar[0] .= ",";
				}
				$arySearchVar[0]			.= "'";
				$arySearchVar[0]			.= $_POST["{$strVarName}{$k}"]				? $_POST["{$strVarName}{$k}"]			: $_REQUEST["{$strVarName}{$k}"];
				$arySearchVar[0]			.= "'";
				$c++;
			}
			$arySearchVar[1][]		= $_POST["{$strVarName}{$k}"]				? $_POST["{$strVarName}{$k}"]			: $_REQUEST["{$strVarName}{$k}"];
			
		}
		return $arySearchVar;
	}


	function set_option_type ( $type ) { $this->option_type = $type ; }
	function get_option_type () { return $this->option_type ; }

	function setP_CODE($P_CODE){ $this->P_CODE = $P_CODE; }
	function getP_CODE(){ return $this->P_CODE; }

	function setP_COPY_CODE($P_COPY_CODE){ $this->P_COPY_CODE = $P_COPY_CODE; }
	function getP_COPY_CODE(){ return $this->P_COPY_CODE; }

	function setP_NAME($P_NAME){ $this->P_NAME = $P_NAME; }
	function getP_NAME(){ return $this->P_NAME; }

	function setP_CATE($P_CATE){ $this->P_CATE = $P_CATE; }
	function getP_CATE(){ return $this->P_CATE; }

	function setP_NUM($P_NUM){ $this->P_NUM = $P_NUM; }
	function getP_NUM(){ return $this->P_NUM; }

	function setP_MAKER($P_MAKER){ $this->P_MAKER = $P_MAKER; }
	function getP_MAKER(){ return $this->P_MAKER; }

	function setP_ORIGIN($P_ORIGIN){ $this->P_ORIGIN = $P_ORIGIN; }
	function getP_ORIGIN(){ return $this->P_ORIGIN; }

	function setP_BRAND($P_BRAND){ $this->P_BRAND = $P_BRAND; }
	function getP_BRAND(){ return $this->P_BRAND; }

	function setP_MODEL($P_MODEL){ $this->P_MODEL = $P_MODEL; }
	function getP_MODEL(){ return $this->P_MODEL; }

	function setP_LAUNCH_DT($P_LAUNCH_DT){ $this->P_LAUNCH_DT = $P_LAUNCH_DT; }
	function getP_LAUNCH_DT(){ return $this->P_LAUNCH_DT; }

	function setP_WEB_VIEW($P_WEB_VIEW){ $this->P_WEB_VIEW = $P_WEB_VIEW; }
	function getP_WEB_VIEW(){ return $this->P_WEB_VIEW; }

	function setP_MOB_VIEW($P_MOB_VIEW){ $this->P_MOB_VIEW = $P_MOB_VIEW; }
	function getP_MOB_VIEW(){ return $this->P_MOB_VIEW; }

	function setP_REP_DT($P_REP_DT){ $this->P_REP_DT = $P_REP_DT; }
	function getP_REP_DT(){ return $this->P_REP_DT; }

	function setP_ORDER($P_ORDER){ $this->P_ORDER = $P_ORDER; }
	function getP_ORDER(){ return $this->P_ORDER; }

	function setP_SALE_PRICE($P_SALE_PRICE){ $this->P_SALE_PRICE = $P_SALE_PRICE; }
	function getP_SALE_PRICE(){ return $this->P_SALE_PRICE; }

	function setP_CONSUMER_PRICE($P_CONSUMER_PRICE){ $this->P_CONSUMER_PRICE = $P_CONSUMER_PRICE; }
	function getP_CONSUMER_PRICE(){ return $this->P_CONSUMER_PRICE; }

	function setP_STOCK_PRICE($P_STOCK_PRICE){ $this->P_STOCK_PRICE = $P_STOCK_PRICE; }
	function getP_STOCK_PRICE(){ return $this->P_STOCK_PRICE; }

	function setP_POINT($P_POINT){ $this->P_POINT = $P_POINT; }
	function getP_POINT(){ return $this->P_POINT; }

	function setP_POINT_TYPE($P_POINT_TYPE){ $this->P_POINT_TYPE = $P_POINT_TYPE; }
	function getP_POINT_TYPE(){ return $this->P_POINT_TYPE; }

	function setP_POINT_OFF1($P_POINT_OFF1){ $this->P_POINT_OFF1 = $P_POINT_OFF1; }
	function getP_POINT_OFF1(){ return $this->P_POINT_OFF1; }

	function setP_POINT_OFF2($P_POINT_OFF2){ $this->P_POINT_OFF2 = $P_POINT_OFF2; }
	function getP_POINT_OFF2(){ return $this->P_POINT_OFF2; }

	function setP_QTY($P_QTY){ $this->P_QTY = $P_QTY; }
	function getP_QTY(){ return $this->P_QTY; }

	function setP_STOCK_OUT($P_STOCK_OUT){ $this->P_STOCK_OUT = $P_STOCK_OUT; }
	function getP_STOCK_OUT(){ return $this->P_STOCK_OUT; }

	function setP_RESTOCK($P_RESTOCK){ $this->P_RESTOCK = $P_RESTOCK; }
	function getP_RESTOCK(){ return $this->P_RESTOCK; }

	function setP_STOCK_LIMIT($P_STOCK_LIMIT){ $this->P_STOCK_LIMIT = $P_STOCK_LIMIT; }
	function getP_STOCK_LIMIT(){ return $this->P_STOCK_LIMIT; }

	function setP_MIN_QTY($P_MIN_QTY){ $this->P_MIN_QTY = $P_MIN_QTY; }
	function getP_MIN_QTY(){ return $this->P_MIN_QTY; }

	function setP_MAX_QTY($P_MAX_QTY){ $this->P_MAX_QTY = $P_MAX_QTY; }
	function getP_MAX_QTY(){ return $this->P_MAX_QTY; }

	function setP_TAX($P_TAX){ $this->P_TAX = $P_TAX; }
	function getP_TAX(){ return $this->P_TAX; }

	function setP_PRICE_TEXT($P_PRICE_TEXT){ $this->P_PRICE_TEXT = $P_PRICE_TEXT; }
	function getP_PRICE_TEXT(){ return $this->P_PRICE_TEXT; }

	function setP_OPT($P_OPT){ $this->P_OPT = $P_OPT; }
	function getP_OPT(){ return $this->P_OPT; }

	function setP_ADD_OPT($P_ADD_OPT){ $this->P_ADD_OPT = $P_ADD_OPT; }
	function getP_ADD_OPT(){ return $this->P_ADD_OPT; }

	function setP_BAESONG_TYPE($P_BAESONG_TYPE){ $this->P_BAESONG_TYPE = $P_BAESONG_TYPE; }
	function getP_BAESONG_TYPE(){ return $this->P_BAESONG_TYPE; }

	function setP_BAESONG_PRICE($P_BAESONG_PRICE){ $this->P_BAESONG_PRICE = $P_BAESONG_PRICE; }
	function getP_BAESONG_PRICE(){ return $this->P_BAESONG_PRICE; }

	function setP_SEARCH_TEXT($P_SEARCH_TEXT){ $this->P_SEARCH_TEXT = $P_SEARCH_TEXT; }
	function getP_SEARCH_TEXT(){ return $this->P_SEARCH_TEXT; }

	function setP_ETC($P_ETC){ $this->P_ETC = $P_ETC; }
	function getP_ETC(){ return $this->P_ETC; }

	function setP_WEB_TEXT($P_WEB_TEXT){ $this->P_WEB_TEXT = $P_WEB_TEXT; }
	function getP_WEB_TEXT(){ return $this->P_WEB_TEXT; }

	function setP_MOB_TEXT($P_MOB_TEXT){ $this->P_MOB_TEXT = $P_MOB_TEXT; }
	function getP_MOB_TEXT(){ return $this->P_MOB_TEXT; }

	function setP_DELIVERY_TEXT($P_DELIVERY_TEXT){ $this->P_DELIVERY_TEXT = $P_DELIVERY_TEXT; }
	function getP_DELIVERY_TEXT(){ return $this->P_DELIVERY_TEXT; }

	function setP_RETURN_TEXT($P_RETURN_TEXT){ $this->P_RETURN_TEXT = $P_RETURN_TEXT; }
	function getP_RETURN_TEXT(){ return $this->P_RETURN_TEXT; }

	function setP_MEMO($P_MEMO){ $this->P_MEMO = $P_MEMO; }
	function getP_MEMO(){ return $this->P_MEMO; }

	function setP_REG_DT($P_REG_DT){ $this->P_REG_DT = $P_REG_DT; }
	function getP_REG_DT(){ return $this->P_REG_DT; }

	function setP_REG_NO($P_REG_NO){ $this->P_REG_NO = $P_REG_NO; }
	function getP_REG_NO(){ return $this->P_REG_NO; }

	function setP_MOD_DT($P_MOD_DT){ $this->P_MOD_DT = $P_MOD_DT; }
	function getP_MOD_DT(){ return $this->P_MOD_DT; }

	function setP_MOD_NO($P_MOD_NO){ $this->P_MOD_NO = $P_MOD_NO; }
	function getP_MOD_NO(){ return $this->P_MOD_NO; }

	function setP_CODE_ALL($P_CODE_ALL){ $this->P_CODE_ALL = $P_CODE_ALL; }
	function getP_CODE_ALL(){ return $this->P_CODE_ALL; }

	function setP_LIST_ICON($P_LIST_ICON){ $this->P_LIST_ICON = $P_LIST_ICON; }
	function getP_LIST_ICON(){ return $this->P_LIST_ICON; }

	function setP_LNG($P_LNG){ $this->P_LNG = $P_LNG; }
	function getP_LNG(){ return $this->P_LNG; }

	function setP_SHOP_NO($P_SHOP_NO){ $this->P_SHOP_NO = $P_SHOP_NO; }
	function getP_SHOP_NO(){ return $this->P_SHOP_NO; }

	function setP_SHOP_PRICE($P_SHOP_PRICE) { $this->P_SHOP_PRICE = $P_SHOP_PRICE; }
	function getP_SHOP_PRICE() { return $this->P_SHOP_PRICE; }

	function setP_SCR($P_SCR){ $this->P_SCR = $P_SCR; }
	function getP_SCR(){ return $this->P_SCR; }

	function setP_WEIGHT($P_WEIGHT){ $this->P_WEIGHT = $P_WEIGHT; }
	function getP_WEIGHT(){ return $this->P_WEIGHT; }

	/*--------------------------------------------------------------*/
	function setPI_NO($PI_NO){ $this->PI_NO = $PI_NO; }
	function getPI_NO(){ return $this->PI_NO; }

	function setPI_LNG($PI_LNG){ $this->PI_LNG = $PI_LNG; }
	function getPI_LNG(){ return $this->PI_LNG; }

	function setPI_NAME($PI_NAME){ $this->PI_NAME = $PI_NAME; }
	function getPI_NAME(){ return $this->PI_NAME; }

	function setPI_TEXT($PI_TEXT){ $this->PI_TEXT = $PI_TEXT; }
	function getPI_TEXT(){ return $this->PI_TEXT; }

	function setPI_ORDER($PI_ORDER){ $this->PI_ORDER = $PI_ORDER; }
	function getPI_ORDER(){ return $this->PI_ORDER; }

	function setPI_NO_ALL($PI_NO_ALL){ $this->PI_NO_ALL = $PI_NO_ALL; }
	function getPI_NO_ALL(){ return $this->PI_NO_ALL; }
	/*--------------------------------------------------------------*/
	function setPO_NO($PO_NO){ $this->PO_NO = $PO_NO; }
	function getPO_NO(){ return $this->PO_NO; }

	function setPO_NAME1($PO_NAME1){ $this->PO_NAME1 = $PO_NAME1; }
	function getPO_NAME1(){ return $this->PO_NAME1; }

	function setPO_NAME2($PO_NAME2){ $this->PO_NAME2 = $PO_NAME2; }
	function getPO_NAME2(){ return $this->PO_NAME2; }

	function setPO_NAME3($PO_NAME3){ $this->PO_NAME3 = $PO_NAME3; }
	function getPO_NAME3(){ return $this->PO_NAME3; }

	function setPO_NAME4($PO_NAME4){ $this->PO_NAME4 = $PO_NAME4; }
	function getPO_NAME4(){ return $this->PO_NAME4; }

	function setPO_NAME5($PO_NAME5){ $this->PO_NAME5 = $PO_NAME5; }
	function getPO_NAME5(){ return $this->PO_NAME5; }

	function setPO_NAME6($PO_NAME6){ $this->PO_NAME6 = $PO_NAME6; }
	function getPO_NAME6(){ return $this->PO_NAME6; }

	function setPO_NAME7($PO_NAME7){ $this->PO_NAME7 = $PO_NAME7; }
	function getPO_NAME7(){ return $this->PO_NAME7; }

	function setPO_NAME8($PO_NAME8){ $this->PO_NAME8 = $PO_NAME8; }
	function getPO_NAME8(){ return $this->PO_NAME8; }

	function setPO_NAME9($PO_NAME9){ $this->PO_NAME9 = $PO_NAME9; }
	function getPO_NAME9(){ return $this->PO_NAME9; }

	function setPO_NAME10($PO_NAME10){ $this->PO_NAME10 = $PO_NAME10; }
	function getPO_NAME10(){ return $this->PO_NAME10; }

	function setPO_TYPE($PO_TYPE){ $this->PO_TYPE = $PO_TYPE; }
	function getPO_TYPE(){ return $this->PO_TYPE; }

	function setPO_ESS($PO_ESS){ $this->PO_ESS = $PO_ESS; }
	function getPO_ESS(){ return $this->PO_ESS; }

	function setPO_NO_ALL($PO_NO_ALL){ $this->PO_NO_ALL = $PO_NO_ALL; }
	function getPO_NO_ALL(){ return $this->PO_NO_ALL; }
	/*--------------------------------------------------------------*/
	function setPOA_NO($POA_NO){ $this->POA_NO = $POA_NO; }
	function getPOA_NO(){ return $this->POA_NO; }

	function setPOA_ATTR1($POA_ATTR1){ $this->POA_ATTR1 = $POA_ATTR1; }
	function getPOA_ATTR1(){ return $this->POA_ATTR1; }

	function setPOA_ATTR2($POA_ATTR2){ $this->POA_ATTR2 = $POA_ATTR2; }
	function getPOA_ATTR2(){ return $this->POA_ATTR2; }

	function setPOA_ATTR3($POA_ATTR3){ $this->POA_ATTR3 = $POA_ATTR3; }
	function getPOA_ATTR3(){ return $this->POA_ATTR3; }

	function setPOA_ATTR4($POA_ATTR4){ $this->POA_ATTR4 = $POA_ATTR4; }
	function getPOA_ATTR4(){ return $this->POA_ATTR4; }

	function setPOA_ATTR5($POA_ATTR5){ $this->POA_ATTR5 = $POA_ATTR5; }
	function getPOA_ATTR5(){ return $this->POA_ATTR5; }

	function setPOA_ATTR6($POA_ATTR6){ $this->POA_ATTR6 = $POA_ATTR6; }
	function getPOA_ATTR6(){ return $this->POA_ATTR6; }

	function setPOA_ATTR7($POA_ATTR7){ $this->POA_ATTR7 = $POA_ATTR7; }
	function getPOA_ATTR7(){ return $this->POA_ATTR7; }

	function setPOA_ATTR8($POA_ATTR8){ $this->POA_ATTR8 = $POA_ATTR8; }
	function getPOA_ATTR8(){ return $this->POA_ATTR8; }

	function setPOA_ATTR9($POA_ATTR9){ $this->POA_ATTR9 = $POA_ATTR9; }
	function getPOA_ATTR9(){ return $this->POA_ATTR9; }

	function setPOA_ATTR10($POA_ATTR10){ $this->POA_ATTR10 = $POA_ATTR10; }
	function getPOA_ATTR10(){ return $this->POA_ATTR10; }

	function setPOA_SALE_PRICE($POA_SALE_PRICE){ $this->POA_SALE_PRICE = $POA_SALE_PRICE; }
	function getPOA_SALE_PRICE(){ return $this->POA_SALE_PRICE; }

	function setPOA_CONSUMER_PRICE($POA_CONSUMER_PRICE){ $this->POA_CONSUMER_PRICE = $POA_CONSUMER_PRICE; }
	function getPOA_CONSUMER_PRICE(){ return $this->POA_CONSUMER_PRICE; }

	function setPOA_STOCK_PRICE($POA_STOCK_PRICE){ $this->POA_STOCK_PRICE = $POA_STOCK_PRICE; }
	function getPOA_STOCK_PRICE(){ return $this->POA_STOCK_PRICE; }

	function setPOA_POINT($POA_POINT){ $this->POA_POINT = $POA_POINT; }
	function getPOA_POINT(){ return $this->POA_POINT; }

	function setPOA_STOCK_QTY($POA_STOCK_QTY){ $this->POA_STOCK_QTY = $POA_STOCK_QTY; }
	function getPOA_STOCK_QTY(){ return $this->POA_STOCK_QTY; }

	function setPOA_NO_ALL($POA_NO_ALL){ $this->POA_NO_ALL = $POA_NO_ALL; }
	function getPOA_NO_ALL(){ return $this->POA_NO_ALL; }

	function setPOA_ATTR_GROUP($POA_ATTR_GROUP){ $this->POA_ATTR_GROUP = $POA_ATTR_GROUP; }
	function getPOA_ATTR_GROUP(){ return $this->POA_ATTR_GROUP; }
	/*--------------------------------------------------------------*/
	function setPAO_NO($PAO_NO){ $this->PAO_NO = $PAO_NO; }
	function getPAO_NO(){ return $this->PAO_NO; }

	function setPAO_NAME($PAO_NAME){ $this->PAO_NAME = $PAO_NAME; }
	function getPAO_NAME(){ return $this->PAO_NAME; }

	function setPAO_PRICE($PAO_PRICE){ $this->PAO_PRICE = $PAO_PRICE; }
	function getPAO_PRICE(){ return $this->PAO_PRICE; }

	function setPAO_NO_ALL($PAO_NO_ALL){ $this->PAO_NO_ALL = $PAO_NO_ALL; }
	function getPAO_NO_ALL(){ return $this->PAO_NO_ALL; }

	/*--------------------------------------------------------------*/
	function setPM_NO($PM_NO){ $this->PM_NO = $PM_NO; }
	function getPM_NO(){ return $this->PM_NO; }

	function setPM_TYPE($PM_TYPE){ $this->PM_TYPE = $PM_TYPE; }
	function getPM_TYPE(){ return $this->PM_TYPE; }

	function setPM_SAVE_NAME($PM_SAVE_NAME){ $this->PM_SAVE_NAME = $PM_SAVE_NAME; }
	function getPM_SAVE_NAME(){ return $this->PM_SAVE_NAME; }

	function setPM_REAL_NAME($PM_REAL_NAME){ $this->PM_REAL_NAME = $PM_REAL_NAME; }
	function getPM_REAL_NAME(){ return $this->PM_REAL_NAME; }

	/*--------------------------------------------------------------*/
	function setPC_NO($PC_NO){ $this->PC_NO = $PC_NO; }
	function getPC_NO(){ return $this->PC_NO; }

	function setPC_TYPE($PC_TYPE){ $this->PC_TYPE = $PC_TYPE; }
	function getPC_TYPE(){ return $this->PC_TYPE; }

	function setPC_USE($PC_USE){ $this->PC_USE = $PC_USE; }
	function getPC_USE(){ return $this->PC_USE; }

	function setPC_IMG($PC_IMG){ $this->PC_IMG = $PC_IMG; }
	function getPC_IMG(){ return $this->PC_IMG; }

	/*--------------------------------------------------------------*/
	function setLimitFirst($LIMIT_FIRST){ $this->LIMIT_FIRST = $LIMIT_FIRST; }
	function getLimitFirst(){ return $this->LIMIT_FIRST; }

	function setPageLine($PAGE_LINE){ $this->PAGE_LINE = $PAGE_LINE; }
	function getPageLine(){ return $this->PAGE_LINE; }

	function setSearchField($SEARCH_FIELD){ $this->SEARCH_FIELD = $SEARCH_FIELD; }
	function getSearchField(){ return $this->SEARCH_FIELD; }

	function setSearchKey($SEARCH_KEY){ $this->SEARCH_KEY = $SEARCH_KEY; }
	function getSearchKey(){ return $this->SEARCH_KEY; }

	function setSearchLaunchStartDt($SEARCH_LAUNCH_START_DT){ $this->SEARCH_LAUNCH_START_DT = $SEARCH_LAUNCH_START_DT; }
	function getSearchLaunchStartDt(){ return $this->SEARCH_LAUNCH_START_DT; }

	function setSearchLaunchEndDt($SEARCH_LAUNCH_END_DT){ $this->SEARCH_LAUNCH_END_DT = $SEARCH_LAUNCH_END_DT; }
	function getSearchLaunchEndDt(){ return $this->SEARCH_LAUNCH_END_DT; }

	function setSearchRepStartDt($SEARCH_REP_START_DT){ $this->SEARCH_REP_START_DT = $SEARCH_REP_START_DT; }
	function getSearchRepStartDt(){ return $this->SEARCH_REP_START_DT; }

	function setSearchRepEndDt($SEARCH_REP_END_DT){ $this->SEARCH_REP_END_DT = $SEARCH_REP_END_DT; }
	function getSearchRepEndDt(){ return $this->SEARCH_REP_END_DT; }

	function setSearchWebView($SEARCH_WEB_VIEW){ $this->SEARCH_WEB_VIEW = $SEARCH_WEB_VIEW; }
	function getSearchWebView(){ return $this->SEARCH_WEB_VIEW; }

	function setSearchMobileView($SEARCH_MOBILE_VIEW){ $this->SEARCH_MOBILE_VIEW = $SEARCH_MOBILE_VIEW; }
	function getSearchMobileView(){ return $this->SEARCH_MOBILE_VIEW; }

	function setSearchHCode1($C_HCODE1){ $this->C_HCODE1 = $C_HCODE1; }
	function getSearchHCode1(){ return $this->C_HCODE1; }

	function setSearchHCode2($C_HCODE2){ $this->C_HCODE2 = $C_HCODE2; }
	function getSearchHCode2(){ return $this->C_HCODE2; }

	function setSearchHCode3($C_HCODE3){ $this->C_HCODE3 = $C_HCODE3; }
	function getSearchHCode3(){ return $this->C_HCODE3; }

	function setSearchHCode4($C_HCODE4){ $this->C_HCODE4 = $C_HCODE4; }
	function getSearchHCode4(){ return $this->C_HCODE4; }

	function setSearchSort($SEARCH_SORT){ $this->SEARCH_SORT = $SEARCH_SORT; }
	function getSearchSort(){ return $this->SEARCH_SORT; }

	function setSearchIcon1($SEARCH_ICON1){ $this->SEARCH_ICON1 = $SEARCH_ICON1; }
	function getSearchIcon1(){ return $this->SEARCH_ICON1; }

	function setSearchIcon2($SEARCH_ICON2){ $this->SEARCH_ICON2 = $SEARCH_ICON2; }
	function getSearchIcon2(){ return $this->SEARCH_ICON2; }

	function setSearchIcon3($SEARCH_ICON3){ $this->SEARCH_ICON3 = $SEARCH_ICON3; }
	function getSearchIcon3(){ return $this->SEARCH_ICON3; }

	function setSearchIcon4($SEARCH_ICON4){ $this->SEARCH_ICON4 = $SEARCH_ICON4; }
	function getSearchIcon4(){ return $this->SEARCH_ICON4; }

	function setSearchIcon5($SEARCH_ICON5){ $this->SEARCH_ICON5 = $SEARCH_ICON5; }
	function getSearchIcon5(){ return $this->SEARCH_ICON5; }

	function setSearchIcon6($SEARCH_ICON6){ $this->SEARCH_ICON6 = $SEARCH_ICON6; }
	function getSearchIcon6(){ return $this->SEARCH_ICON6; }

	function setSearchIcon7($SEARCH_ICON7){ $this->SEARCH_ICON7 = $SEARCH_ICON7; }
	function getSearchIcon7(){ return $this->SEARCH_ICON7; }

	function setSearchIcon8($SEARCH_ICON8){ $this->SEARCH_ICON8 = $SEARCH_ICON8; }
	function getSearchIcon8(){ return $this->SEARCH_ICON8; }

	function setSearchIcon9($SEARCH_ICON9){ $this->SEARCH_ICON9 = $SEARCH_ICON9; }
	function getSearchIcon9(){ return $this->SEARCH_ICON9; }

	function setSearchIcon10($SEARCH_ICON10){ $this->SEARCH_ICON10 = $SEARCH_ICON10; }
	function getSearchIcon10(){ return $this->SEARCH_ICON10; }

	function setColumn($COLUMN){ $this->COLUMN = $COLUMN; }
	function getColumn(){ return $this->COLUMN; }

	function setSearchPriceView($SEARCH_PRICE_VIEW){ $this->SEARCH_PRICE_VIEW = $SEARCH_PRICE_VIEW; }
	function getSearchPriceView(){ return $this->SEARCH_PRICE_VIEW; }

	function setSearchProdShare($SEARCH_PROD_SHARE){ $this->SEARCH_PROD_SHARE = $SEARCH_PROD_SHARE; }
	function getSearchProdShare(){ return $this->SEARCH_PROD_SHARE; }

	function setSearchColor($SEARCH_COLOR){ $this->SEARCH_COLOR = $SEARCH_COLOR; }
	function getSearchColor(){ return $this->SEARCH_COLOR; }

	function setSearchSize($SEARCH_SIZE){ $this->SEARCH_SIZE = $SEARCH_SIZE; }
	function getSearchSize(){ return $this->SEARCH_SIZE; }

	function setSearchStartPrice($SEARCH_START_PRICE){ $this->SEARCH_START_PRICE = $SEARCH_START_PRICE; }
	function getSearchStartPrice(){ return $this->SEARCH_START_PRICE; }

	function setSearchEndPrice($SEARCH_END_PRICE){ $this->SEARCH_END_PRICE = $SEARCH_END_PRICE; }
	function getSearchEndPrice(){ return $this->SEARCH_END_PRICE; }

	function setSearchListIcon($SEARCH_LIST_ICON){ $this->SEARCH_LIST_ICON = $SEARCH_LIST_ICON; }
	function getSearchListIcon(){ return $this->SEARCH_LIST_ICON; }

	function setSearchProdLike($SEARCH_PROD_LIKE){ $this->SEARCH_PROD_LIKE = $SEARCH_PROD_LIKE; }
	function getSearchProdLike(){ return $this->SEARCH_PROD_LIKE; }



	function setSearchOrigin($SEARCH_ORIGIN){ $this->SEARCH_ORIGIN = $SEARCH_ORIGIN; }
	function getSearchOrigin(){ return $this->SEARCH_ORIGIN; }

	function setSearchLCate($SEARCH_LCATE){ $this->SEARCH_LCATE = $SEARCH_LCATE; }
	function getSearchLCate(){ return $this->SEARCH_LCATE; }

	function setSearchType($SEARCH_TYPE){ $this->SEARCH_TYPE = $SEARCH_TYPE; }
	function getSearchType(){ return $this->SEARCH_TYPE; }

	function setSearchPriceFilter($SEARCH_PRICE_FILTER){ $this->SEARCH_PRICE_FILTER = $SEARCH_PRICE_FILTER; }
	function getSearchPriceFilter(){ return $this->SEARCH_PRICE_FILTER; }

	function setSearchCreditGrade($SEARCH_CREDIT_GRADE){ $this->SEARCH_CREDIT_GRADE = $SEARCH_CREDIT_GRADE; }
	function getSearchCreditGrade(){ return $this->SEARCH_CREDIT_GRADE; }

	function setSearchSaleGrade($SEARCH_SALE_GRADE){ $this->SEARCH_SALE_GRADE = $SEARCH_SALE_GRADE; }
	function getSearchSaleGrade(){ return $this->SEARCH_SALE_GRADE; }

	function setSearchLocusGrade($SEARCH_LOCUS_GRADE){ $this->SEARCH_LOCUS_GRADE = $SEARCH_LOCUS_GRADE; }
	function getSearchLocusGrade(){ return $this->SEARCH_LOCUS_GRADE; }

	function setSearchSubKey($SEARCH_SUB_KEY){ $this->SEARCH_SUB_KEY = $SEARCH_SUB_KEY; }
	function getSearchSubKey(){ return $this->SEARCH_SUB_KEY; }


	/*--------------------------------------------------------------*/
	function setPB_NO($PB_NO){ $this->PB_NO = $PB_NO; }
	function getPB_NO(){ return $this->PB_NO; }

	function setPB_KEY($PB_KEY){ $this->PB_KEY = $PB_KEY; }
	function getPB_KEY(){ return $this->PB_KEY; }

	function setM_NO($M_NO){ $this->M_NO = $M_NO; }
	function getM_NO(){ return $this->M_NO; }

	function setPB_OPT_NO($PB_OPT_NO){ $this->PB_OPT_NO = $PB_OPT_NO; }
	function getPB_OPT_NO(){ return $this->PB_OPT_NO; }

	function setPB_OPT_NM1($PB_OPT_NM1){ $this->PB_OPT_NM1 = $PB_OPT_NM1; }
	function getPB_OPT_NM1(){ return $this->PB_OPT_NM1; }

	function setPB_OPT_NM2($PB_OPT_NM2){ $this->PB_OPT_NM2 = $PB_OPT_NM2; }
	function getPB_OPT_NM2(){ return $this->PB_OPT_NM2; }

	function setPB_OPT_NM3($PB_OPT_NM3){ $this->PB_OPT_NM3 = $PB_OPT_NM3; }
	function getPB_OPT_NM3(){ return $this->PB_OPT_NM3; }

	function setPB_OPT_NM4($PB_OPT_NM4){ $this->PB_OPT_NM4 = $PB_OPT_NM4; }
	function getPB_OPT_NM4(){ return $this->PB_OPT_NM4; }

	function setPB_OPT_NM5($PB_OPT_NM5){ $this->PB_OPT_NM5 = $PB_OPT_NM5; }
	function getPB_OPT_NM5(){ return $this->PB_OPT_NM5; }

	function setPB_OPT_NM6($PB_OPT_NM6){ $this->PB_OPT_NM6 = $PB_OPT_NM6; }
	function getPB_OPT_NM6(){ return $this->PB_OPT_NM6; }

	function setPB_OPT_NM7($PB_OPT_NM7){ $this->PB_OPT_NM7 = $PB_OPT_NM7; }
	function getPB_OPT_NM7(){ return $this->PB_OPT_NM7; }

	function setPB_OPT_NM8($PB_OPT_NM8){ $this->PB_OPT_NM8 = $PB_OPT_NM8; }
	function getPB_OPT_NM8(){ return $this->PB_OPT_NM8; }

	function setPB_OPT_NM9($PB_OPT_NM9){ $this->PB_OPT_NM9 = $PB_OPT_NM9; }
	function getPB_OPT_NM9(){ return $this->PB_OPT_NM9; }

	function setPB_OPT_NM10($PB_OPT_NM10){ $this->PB_OPT_NM10 = $PB_OPT_NM10; }
	function getPB_OPT_NM10(){ return $this->PB_OPT_NM10; }

	function setPB_OPT_ATTR1($PB_OPT_ATTR1){ $this->PB_OPT_ATTR1 = $PB_OPT_ATTR1; }
	function getPB_OPT_ATTR1(){ return $this->PB_OPT_ATTR1; }

	function setPB_OPT_ATTR2($PB_OPT_ATTR2){ $this->PB_OPT_ATTR2 = $PB_OPT_ATTR2; }
	function getPB_OPT_ATTR2(){ return $this->PB_OPT_ATTR2; }

	function setPB_OPT_ATTR3($PB_OPT_ATTR3){ $this->PB_OPT_ATTR3 = $PB_OPT_ATTR3; }
	function getPB_OPT_ATTR3(){ return $this->PB_OPT_ATTR3; }

	function setPB_OPT_ATTR4($PB_OPT_ATTR4){ $this->PB_OPT_ATTR4 = $PB_OPT_ATTR4; }
	function getPB_OPT_ATTR4(){ return $this->PB_OPT_ATTR4; }

	function setPB_OPT_ATTR5($PB_OPT_ATTR5){ $this->PB_OPT_ATTR5 = $PB_OPT_ATTR5; }
	function getPB_OPT_ATTR5(){ return $this->PB_OPT_ATTR5; }

	function setPB_OPT_ATTR6($PB_OPT_ATTR6){ $this->PB_OPT_ATTR6 = $PB_OPT_ATTR6; }
	function getPB_OPT_ATTR6(){ return $this->PB_OPT_ATTR6; }

	function setPB_OPT_ATTR7($PB_OPT_ATTR7){ $this->PB_OPT_ATTR7 = $PB_OPT_ATTR7; }
	function getPB_OPT_ATTR7(){ return $this->PB_OPT_ATTR7; }

	function setPB_OPT_ATTR8($PB_OPT_ATTR8){ $this->PB_OPT_ATTR8 = $PB_OPT_ATTR8; }
	function getPB_OPT_ATTR8(){ return $this->PB_OPT_ATTR8; }

	function setPB_OPT_ATTR9($PB_OPT_ATTR9){ $this->PB_OPT_ATTR9 = $PB_OPT_ATTR9; }
	function getPB_OPT_ATTR9(){ return $this->PB_OPT_ATTR9; }

	function setPB_OPT_ATTR10($PB_OPT_ATTR10){ $this->PB_OPT_ATTR10 = $PB_OPT_ATTR10; }
	function getPB_OPT_ATTR10(){ return $this->PB_OPT_ATTR10; }

	function setPB_QTY($PB_QTY){ $this->PB_QTY = $PB_QTY; }
	function getPB_QTY(){ return $this->PB_QTY; }

	function setPB_STOCK_PRICE($PB_STOCK_PRICE){ $this->PB_STOCK_PRICE = $PB_STOCK_PRICE; }
	function getPB_STOCK_PRICE(){ return $this->PB_STOCK_PRICE; }

	function setPB_PRICE($PB_PRICE){ $this->PB_PRICE = $PB_PRICE; }
	function getPB_PRICE(){ return $this->PB_PRICE; }

	function setPB_POINT($PB_POINT){ $this->PB_POINT = $PB_POINT; }
	function getPB_POINT(){ return $this->PB_POINT; }

	function setPB_DELIVERY_TYPE($PB_DELIVERY_TYPE){ $this->PB_DELIVERY_TYPE = $PB_DELIVERY_TYPE; }
	function getPB_DELIVERY_TYPE(){ return $this->PB_DELIVERY_TYPE; }

	function setPB_DELIVERY_PRICE($PB_DELIVERY_PRICE){ $this->PB_DELIVERY_PRICE = $PB_DELIVERY_PRICE; }
	function getPB_DELIVERY_PRICE(){ return $this->PB_DELIVERY_PRICE; }

	function setPB_DELIVERY_EXP($PB_DELIVERY_EXP){ $this->PB_DELIVERY_EXP = $PB_DELIVERY_EXP; }
	function getPB_DELIVERY_EXP(){ return $this->PB_DELIVERY_EXP; }

	function setPB_ADD_OPT_PRICE($PB_ADD_OPT_PRICE){ $this->PB_ADD_OPT_PRICE = $PB_ADD_OPT_PRICE; }
	function getPB_ADD_OPT_PRICE(){ return $this->PB_ADD_OPT_PRICE; }

	function setPB_REG_DT($PB_REG_DT){ $this->PB_REG_DT = $PB_REG_DT; }
	function getPB_REG_DT(){ return $this->PB_REG_DT; }

	function setPB_ALL_NO($PB_ALL_NO){ $this->PB_ALL_NO = $PB_ALL_NO; }
	function getPB_ALL_NO(){ return $this->PB_ALL_NO; }

	function setPB_ALL_SORT($PB_ALL_SORT){ $this->PB_ALL_SORT = $PB_ALL_SORT; }
	function getPB_ALL_SORT(){ return $this->PB_ALL_SORT; }

	function setPB_DIRECT($PB_DIRECT){ $this->PB_DIRECT = $PB_DIRECT; }
	function getPB_DIRECT(){ return $this->PB_DIRECT; }

	/*--------------------------------------------------------------*/
	function setPBA_NO($PBA_NO){ $this->PBA_NO = $PBA_NO; }
	function getPBA_NO(){ return $this->PBA_NO; }

	function setPBA_OPT_NO($PBA_OPT_NO){ $this->PBA_OPT_NO = $PBA_OPT_NO; }
	function getPBA_OPT_NO(){ return $this->PBA_OPT_NO; }

	function setPBA_OPT_NM($PBA_OPT_NM){ $this->PBA_OPT_NM = $PBA_OPT_NM; }
	function getPBA_OPT_NM(){ return $this->PBA_OPT_NM; }

	function setPBA_OPT_PRICE($PBA_OPT_PRICE){ $this->PBA_OPT_PRICE = $PBA_OPT_PRICE; }
	function getPBA_OPT_PRICE(){ return $this->PBA_OPT_PRICE; }

	function setPBA_OPT_QTY($PBA_OPT_QTY){ $this->PBA_OPT_QTY = $PBA_OPT_QTY; }
	function getPBA_OPT_QTY(){ return $this->PBA_OPT_QTY; }

	/*--------------------------------------------------------------*/
	function setPW_NO($PW_NO){ $this->PW_NO = $PW_NO; }
	function getPW_NO(){ return $this->PW_NO; }

	function setPW_OPT_NO($PW_OPT_NO){ $this->PW_OPT_NO = $PW_OPT_NO; }
	function getPW_OPT_NO(){ return $this->PW_OPT_NO; }

	function setPW_OPT_NM1($PW_OPT_NM1){ $this->PW_OPT_NM1 = $PW_OPT_NM1; }
	function getPW_OPT_NM1(){ return $this->PW_OPT_NM1; }

	function setPW_OPT_NM2($PW_OPT_NM2){ $this->PW_OPT_NM2 = $PW_OPT_NM2; }
	function getPW_OPT_NM2(){ return $this->PW_OPT_NM2; }

	function setPW_OPT_NM3($PW_OPT_NM3){ $this->PW_OPT_NM3 = $PW_OPT_NM3; }
	function getPW_OPT_NM3(){ return $this->PW_OPT_NM3; }

	function setPW_OPT_NM4($PW_OPT_NM4){ $this->PW_OPT_NM4 = $PW_OPT_NM4; }
	function getPW_OPT_NM4(){ return $this->PW_OPT_NM4; }

	function setPW_OPT_NM5($PW_OPT_NM5){ $this->PW_OPT_NM5 = $PW_OPT_NM5; }
	function getPW_OPT_NM5(){ return $this->PW_OPT_NM5; }

	function setPW_OPT_NM6($PW_OPT_NM6){ $this->PW_OPT_NM6 = $PW_OPT_NM6; }
	function getPW_OPT_NM6(){ return $this->PW_OPT_NM6; }

	function setPW_OPT_NM7($PW_OPT_NM7){ $this->PW_OPT_NM7 = $PW_OPT_NM7; }
	function getPW_OPT_NM7(){ return $this->PW_OPT_NM7; }

	function setPW_OPT_NM8($PW_OPT_NM8){ $this->PW_OPT_NM8 = $PW_OPT_NM8; }
	function getPW_OPT_NM8(){ return $this->PW_OPT_NM8; }

	function setPW_OPT_NM9($PW_OPT_NM9){ $this->PW_OPT_NM9 = $PW_OPT_NM9; }
	function getPW_OPT_NM9(){ return $this->PW_OPT_NM9; }

	function setPW_OPT_NM10($PW_OPT_NM10){ $this->PW_OPT_NM10 = $PW_OPT_NM10; }
	function getPW_OPT_NM10(){ return $this->PW_OPT_NM10; }

	function setPW_OPT_ATTR1($PW_OPT_ATTR1){ $this->PW_OPT_ATTR1 = $PW_OPT_ATTR1; }
	function getPW_OPT_ATTR1(){ return $this->PW_OPT_ATTR1; }

	function setPW_OPT_ATTR2($PW_OPT_ATTR2){ $this->PW_OPT_ATTR2 = $PW_OPT_ATTR2; }
	function getPW_OPT_ATTR2(){ return $this->PW_OPT_ATTR2; }

	function setPW_OPT_ATTR3($PW_OPT_ATTR3){ $this->PW_OPT_ATTR3 = $PW_OPT_ATTR3; }
	function getPW_OPT_ATTR3(){ return $this->PW_OPT_ATTR3; }

	function setPW_OPT_ATTR4($PW_OPT_ATTR4){ $this->PW_OPT_ATTR4 = $PW_OPT_ATTR4; }
	function getPW_OPT_ATTR4(){ return $this->PW_OPT_ATTR4; }

	function setPW_OPT_ATTR5($PW_OPT_ATTR5){ $this->PW_OPT_ATTR5 = $PW_OPT_ATTR5; }
	function getPW_OPT_ATTR5(){ return $this->PW_OPT_ATTR5; }

	function setPW_OPT_ATTR6($PW_OPT_ATTR6){ $this->PW_OPT_ATTR6 = $PW_OPT_ATTR6; }
	function getPW_OPT_ATTR6(){ return $this->PW_OPT_ATTR6; }

	function setPW_OPT_ATTR7($PW_OPT_ATTR7){ $this->PW_OPT_ATTR7 = $PW_OPT_ATTR7; }
	function getPW_OPT_ATTR7(){ return $this->PW_OPT_ATTR7; }

	function setPW_OPT_ATTR8($PW_OPT_ATTR8){ $this->PW_OPT_ATTR8 = $PW_OPT_ATTR8; }
	function getPW_OPT_ATTR8(){ return $this->PW_OPT_ATTR8; }

	function setPW_OPT_ATTR9($PW_OPT_ATTR9){ $this->PW_OPT_ATTR9 = $PW_OPT_ATTR9; }
	function getPW_OPT_ATTR9(){ return $this->PW_OPT_ATTR9; }

	function setPW_OPT_ATTR10($PW_OPT_ATTR10){ $this->PW_OPT_ATTR10 = $PW_OPT_ATTR10; }
	function getPW_OPT_ATTR10(){ return $this->PW_OPT_ATTR10; }

	function setPW_QTY($PW_QTY){ $this->PW_QTY = $PW_QTY; }
	function getPW_QTY(){ return $this->PW_QTY; }

	function setPW_STOCK_PRICE($PW_STOCK_PRICE){ $this->PW_STOCK_PRICE = $PW_STOCK_PRICE; }
	function getPW_STOCK_PRICE(){ return $this->PW_STOCK_PRICE; }

	function setPW_PRICE($PW_PRICE){ $this->PW_PRICE = $PW_PRICE; }
	function getPW_PRICE(){ return $this->PW_PRICE; }

	function setPW_POINT($PW_POINT){ $this->PW_POINT = $PW_POINT; }
	function getPW_POINT(){ return $this->PW_POINT; }

	function setPW_DELIVERY_TYPE($PW_DELIVERY_TYPE){ $this->PW_DELIVERY_TYPE = $PW_DELIVERY_TYPE; }
	function getPW_DELIVERY_TYPE(){ return $this->PW_DELIVERY_TYPE; }

	function setPW_DELIVERY_PRICE($PW_DELIVERY_PRICE){ $this->PW_DELIVERY_PRICE = $PW_DELIVERY_PRICE; }
	function getPW_DELIVERY_PRICE(){ return $this->PW_DELIVERY_PRICE; }

	function setPW_DELIVERY_EXP($PW_DELIVERY_EXP){ $this->PW_DELIVERY_EXP = $PW_DELIVERY_EXP; }
	function getPW_DELIVERY_EXP(){ return $this->PW_DELIVERY_EXP; }

	function setPW_ADD_OPT_PRICE($PW_ADD_OPT_PRICE){ $this->PW_ADD_OPT_PRICE = $PW_ADD_OPT_PRICE; }
	function getPW_ADD_OPT_PRICE(){ return $this->PW_ADD_OPT_PRICE; }

	function setPW_REG_DT($PW_REG_DT){ $this->PW_REG_DT = $PW_REG_DT; }
	function getPW_REG_DT(){ return $this->PW_REG_DT; }

	function setPW_ALL_NO($PW_ALL_NO){ $this->PW_ALL_NO = $PW_ALL_NO; }
	function getPW_ALL_NO(){ return $this->PW_ALL_NO; }

	function setPW_ALL_SORT($PW_ALL_SORT){ $this->PW_ALL_SORT = $PW_ALL_SORT; }
	function getPW_ALL_SORT(){ return $this->PW_ALL_SORT; }

	/*--------------------------------------------------------------*/

	function setPG_NO($PG_NO){ $this->PG_NO = $PG_NO; }
	function getPG_NO(){ return $this->PG_NO; }

	function setPG_P_CODE($PG_P_CODE){ $this->PG_P_CODE = $PG_P_CODE; }
	function getPG_P_CODE(){ return $this->PG_P_CODE; }

	function setPG_NO_ALL($PG_NO_ALL){ $this->PG_NO_ALL = $PG_NO_ALL; }
	function getPG_NO_ALL(){ return $this->PG_NO_ALL; }

	/*--------------------------------------------------------------*/
	function setPR_NO($PR_NO){ $this->PR_NO = $PR_NO; }
	function getPR_NO(){ return $this->PR_NO; }

	function setPR_NAME($PR_NAME){ $this->PR_NAME = $PR_NAME; }
	function getPR_NAME(){ return $this->PR_NAME; }

	function setPR_TIT_IMG($PR_TIT_IMG){ $this->PR_TIT_IMG = $PR_TIT_IMG; }
	function getPR_TIT_IMG(){ return $this->PR_TIT_IMG; }

	function setPR_LIST_TYPE($PR_LIST_TYPE){ $this->PR_LIST_TYPE = $PR_LIST_TYPE; }
	function getPR_LIST_TYPE(){ return $this->PR_LIST_TYPE; }

	function setPR_LIST_CNT($PR_LIST_CNT){ $this->PR_LIST_CNT = $PR_LIST_CNT; }
	function getPR_LIST_CNT(){ return $this->PR_LIST_CNT; }

	function setPR_LIST_LINE($PR_LIST_LINE){ $this->PR_LIST_LINE = $PR_LIST_LINE; }
	function getPR_LIST_LINE(){ return $this->PR_LIST_LINE; }

	function setPR_REG_DT($PR_REG_DT){ $this->PR_REG_DT = $PR_REG_DT; }
	function getPR_REG_DT(){ return $this->PR_REG_DT; }

	function setPR_REG_NO($PR_REG_NO){ $this->PR_REG_NO = $PR_REG_NO; }
	function getPR_REG_NO(){ return $this->PR_REG_NO; }

	function setPR_MOD_DT($PR_MOD_DT){ $this->PR_MOD_DT = $PR_MOD_DT; }
	function getPR_MOD_DT(){ return $this->PR_MOD_DT; }

	function setPR_MOD_NO($PR_MOD_NO){ $this->PR_MOD_NO = $PR_MOD_NO; }
	function getPR_MOD_NO(){ return $this->PR_MOD_NO; }

	/*--------------------------------------------------------------*/

	function setPWA_NO($PWA_NO){ $this->PWA_NO = $PWA_NO; }
	function getPWA_NO(){ return $this->PWA_NO; }

	function setPWA_OPT_NO($PWA_OPT_NO){ $this->PWA_OPT_NO = $PWA_OPT_NO; }
	function getPWA_OPT_NO(){ return $this->PWA_OPT_NO; }

	function setPWA_OPT_NM($PWA_OPT_NM){ $this->PWA_OPT_NM = $PWA_OPT_NM; }
	function getPWA_OPT_NM(){ return $this->PWA_OPT_NM; }

	function setPWA_OPT_PRICE($PWA_OPT_PRICE){ $this->PWA_OPT_PRICE = $PWA_OPT_PRICE; }
	function getPWA_OPT_PRICE(){ return $this->PWA_OPT_PRICE; }

	function setPWA_OPT_QTY($PWA_OPT_QTY){ $this->PWA_OPT_QTY = $PWA_OPT_QTY; }
	function getPWA_OPT_QTY(){ return $this->PWA_OPT_QTY; }
	/*--------------------------------------------------------------*/

	function setGIFT_FIRST_TYPE($GIFT_FIRST_TYPE){ $this->GIFT_FIRST_TYPE = $GIFT_FIRST_TYPE; }
	function getGIFT_FIRST_TYPE(){ return $this->GIFT_FIRST_TYPE; }

	function setGIFT_NO($GIFT_NO){ $this->GIFT_NO = $GIFT_NO; }
	function getGIFT_NO(){ return $this->GIFT_NO; }

	function setGIFT_OPT($GIFT_OPT){ $this->GIFT_OPT = $GIFT_OPT; }
	function getGIFT_OPT(){ return $this->GIFT_OPT; }

	function setGIFT_LIMIT_PRICE($GIFT_LIMIT_PRICE){ $this->GIFT_LIMIT_PRICE = $GIFT_LIMIT_PRICE; }
	function getGIFT_LIMIT_PRICE(){ return $this->GIFT_LIMIT_PRICE; }

	// 브랜드 관리 다국어
	/*--------------------------------------------------------------*/
	function setPL_NO($PL_NO){ $this->PL_NO = $PL_NO; }
	function getPL_NO(){ return $this->PL_NO; }

	function setPL_PR_NO($PL_PR_NO){ $this->PL_PR_NO = $PL_PR_NO; }
	function getPL_PR_NO(){ return $this->PL_PR_NO; }

	function setPL_LNG($PL_LNG){ $this->PL_LNG = $PL_LNG; }
	function getPL_LNG(){ return $this->PL_LNG; }

	function setPL_PR_HTML($PL_PR_HTML){ $this->PL_PR_HTML = $PL_PR_HTML; }
	function getPL_PR_HTML(){ return $this->PL_PR_HTML; }



	/*        */

	function setMOBILE_IMG_VIEW($MOBILE_IMG_VIEW){ $this->MOBILE_IMG_VIEW = $MOBILE_IMG_VIEW; }
	function getMOBILE_IMG_VIEW(){ return $this->MOBILE_IMG_VIEW; }

	/********************************** variable **********************************/




	/********************************** variable **********************************/
}
?>