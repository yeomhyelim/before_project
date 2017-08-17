<?
#/*====================================================================*/#
#|화일명	: 입점몰관리 												|#
#|작성자	: 홍길동													|#
#|작성일	: 2013-02-12												|#
#|작성내용	: 															|#
#/*====================================================================*/#

class ShopMgr
{
	private $query;
	private $param;

	function getShopSiteListEx($db, $op, $param) {

		$column['OP_LIST']			= "*";
		$column['OP_SELECT']		= "*";

		if(!$op)			{ return; }

		$from	= TBL_SHOP_SITE;
		$query	= "SELECT {$column[$op]} FROM {$from} AS SH";
		$where	= "WHERE SH.SH_NO IS NOT NULL";

		if($param['sh_no']):
			$where	= "{$where} AND SH.SH_NO = {$param['sh_no']}";
		endif;

		if($param['order_by']):
			$order_by	= "ORDER BY {$param['ORDER_BY']}";
		endif;

		if($param['limit']):
			$limit		= "LIMIT {$param['LIMIT']}";
		endif;

		$query = "{$query} {$where} {$order_by} {$limit}";

		return $this->getSelectQuery($db, $query, $op);
	}

	function getShopListEx($db, $op, $param) {

		$column['OP_COUNT']			= "COUNT(*)";
		$column['OP_LIST']			= "SH.SH_NO";
		$column['OP_LIST']			.= " ,SH.SH_TYPE ";
		$column['OP_LIST']			.= " ,SH.SH_COM_TYPE ";
		if($this->getP_LNG())
		{
		//$column['OP_LIST']		.= " ,SI.SH_COM_NUM ";
		$column['OP_LIST']			.= " ,SI.SH_COM_NAME ";
		$column['OP_LIST']			.= " ,SI.SH_COM_REP_NM ";
		//$column['OP_LIST']		.= " ,SI.SH_COM_PHONE ";
		//$column['OP_LIST']		.= " ,SI.SH_COM_FAX ";
		//$column['OP_LIST']		.= " ,SI.SH_COM_MAIL ";
		//$column['OP_LIST']		.= " ,SI.SH_COM_CATEGORY ";
		$column['OP_LIST']			.= " ,SI.SH_COM_ZIP ";
		$column['OP_LIST']			.= " ,SI.SH_COM_ADDR ";
		$column['OP_LIST']			.= " ,SI.SH_COM_ADDR2 ";
		//$column['OP_LIST'] .= " ,SI.SH_COM_COUNTRY ";
		$column['OP_LIST']			.= " ,SI.SH_COM_CITY ";
		$column['OP_LIST']			.= " ,SI.SH_COM_INTRO1 ";
		$column['OP_LIST']			.= " ,SI.SH_COM_INTRO2 ";
		$column['OP_LIST']			.= " ,SI.SH_COM_LOCAL ";
		$column['OP_LIST']			.= " ,SI.SH_COM_SIZE ";
		$column['OP_LIST']			.= " ,SI.SH_COM_CATE ";
		}else{
		//$column['OP_LIST'] .= " ,SH.SH_COM_NUM ";
		$column['OP_LIST']			.= " ,SH.SH_COM_NAME ";
		$column['OP_LIST']			.= " ,SH.SH_COM_REP_NM ";
		//$column['OP_LIST'] .= " ,SH.SH_COM_PHONE ";
		//$column['OP_LIST'] .= " ,SH.SH_COM_FAX ";
		//$column['OP_LIST'] .= " ,SH.SH_COM_MAIL ";
		//$column['OP_LIST'] .= " ,SH.SH_COM_CATEGORY ";
		$column['OP_LIST']			.= " ,SH.SH_COM_ZIP ";
		$column['OP_LIST']			.= " ,SH.SH_COM_ADDR ";
		$column['OP_LIST']			.= " ,SH.SH_COM_ADDR2 ";
		//$column['OP_LIST'] .= " ,SH.SH_COM_COUNTRY ";
		$column['OP_LIST']			.= " ,SH.SH_COM_CITY ";
		$column['OP_LIST']			.= " ,SH.SH_COM_INTRO1 ";
		$column['OP_LIST']			.= " ,SH.SH_COM_INTRO2 ";
		$column['OP_LIST']			.= " ,SH.SH_COM_LOCAL ";
		$column['OP_LIST']			.= " ,SH.SH_COM_SIZE ";
		$column['OP_LIST']			.= " ,SH.SH_COM_CATE ";
		}
		$column['OP_LIST']			.= " ,SH.SH_COM_COUNTRY ";
		$column['OP_LIST']			.= " ,SH.SH_COM_NUM ";
		$column['OP_LIST']			.= " ,SH.SH_COM_PHONE ";
		$column['OP_LIST']			.= " ,SH.SH_COM_FAX ";
		$column['OP_LIST']			.= " ,SH.SH_COM_MAIL ";
		$column['OP_LIST']			.= " ,SH.SH_COM_CATEGORY ";
		$column['OP_LIST']			.= " ,SH.SH_COM_NUM2 ";
		$column['OP_LIST']			.= " ,SH.SH_COM_UPTAE ";
		$column['OP_LIST']			.= " ,SH.SH_COM_UPJONG ";
		$column['OP_LIST']			.= " ,SH.SH_COM_STATE ";
		$column['OP_LIST']			.= " ,SH.SH_COM_FILE1 ";
		$column['OP_LIST']			.= " ,SH.SH_COM_FILE2 ";
		$column['OP_LIST']			.= " ,SH.SH_COM_FILE3 ";
		$column['OP_LIST']			.= " ,SH.SH_COM_FILE4 ";
		$column['OP_LIST']			.= " ,SH.SH_COM_FILE5 ";
		$column['OP_LIST'] 			.= " ,SH.SH_COM_DEPOSIT ";
		$column['OP_LIST'] 			.= " ,SH.SH_COM_BANK ";
		$column['OP_LIST'] 			.= " ,SH.SH_COM_BANK_NUM ";
		$column['OP_LIST'] 			.= " ,SH.SH_COM_ACC_PRICE ";
		$column['OP_LIST'] 			.= " ,SH.SH_COM_ACC_RATE ";
		$column['OP_LIST'] 			.= " ,SH.SH_COM_DELIVERY ";
		$column['OP_LIST'] 			.= " ,SH.SH_COM_DELIVERY_ST_PRICE ";
		$column['OP_LIST'] 			.= " ,SH.SH_COM_DELIVERY_PRICE ";
		$column['OP_LIST'] 			.= " ,SH.SH_COM_DELIVERY_COR ";
		$column['OP_LIST'] 			.= " ,SH.SH_COM_DELIVERY_FOR_COR ";
		$column['OP_LIST'] 			.= " ,SH.SH_COM_DELIVERY_FREE ";
		$column['OP_LIST'] 			.= " ,SH.SH_COM_DEVLIERY_PROD ";
		$column['OP_LIST'] 			.= " ,SH.SH_COM_DELIVERY_AREA ";
		$column['OP_LIST'] 			.= " ,SH.SH_COM_DELIVERY_TEXT ";
		$column['OP_LIST'] 			.= " ,SH.SH_COM_PROD_AUTH ";
		$column['OP_LIST'] 			.= " ,SH.SH_COM_MAIN ";
		$column['OP_LIST'] 			.= " ,SH.SH_APPR ";
		$column['OP_LIST'] 			.= " ,SH.SH_APPR_NO_REASON ";
		$column['OP_LIST'] 			.= " ,SH.SH_COM_SITE ";
		$column['OP_LIST'] 			.= " ,SH.SH_COM_FOUNDED ";
		$column['OP_LIST'] 			.= " ,SH.SH_COM_NUMBER ";
		$column['OP_LIST'] 			.= " ,SH.SH_COM_TOTAL_SALE ";
		$column['OP_LIST'] 			.= " ,SH.SH_COM_RATE ";
		$column['OP_LIST'] 			.= " ,SH.SH_COM_TOTAL_PRODUCTION ";
		$column['OP_LIST'] 			.= " ,SH.SH_COM_COUNTRY1 ";
		$column['OP_LIST'] 			.= " ,SH.SH_COM_COUNTRY2 ";
		$column['OP_LIST'] 			.= " ,SH.SH_COM_COUNTRY3 ";
		$column['OP_LIST'] 			.= " ,SH.SH_COM_COUNTRY4 ";
		$column['OP_LIST'] 			.= " ,SH.SH_COM_COUNTRY5 ";
		$column['OP_LIST'] 			.= " ,SH.SH_COM_COUNTRY6 ";
		$column['OP_LIST'] 			.= " ,SH.SH_COM_COUNTRY7 ";
		$column['OP_LIST'] 			.= " ,SH.SH_COM_COUNTRY8 ";
		$column['OP_LIST'] 			.= " ,SH.SH_COM_COUNTRY9 ";
		$column['OP_LIST'] 			.= " ,SH.SH_COM_COUNTRY10 ";
		$column['OP_LIST'] 			.= " ,SH.SH_COM_COUNTRY11 ";
		$column['OP_LIST'] 			.= " ,SH.SH_COM_COUNTRY12 ";
		$column['OP_LIST'] 			.= " ,SH.SH_COM_COUNTRY13 ";
		$column['OP_LIST'] 			.= " ,SH.SH_COM_COUNTRY14 ";
		$column['OP_LIST'] 			.= " ,SH.SH_COM_RD ";
		$column['OP_LIST'] 			.= " ,SH.SH_COM_CERTIFICATES1 ";
		$column['OP_LIST'] 			.= " ,SH.SH_COM_CERTIFICATES1_FILE ";
		$column['OP_LIST'] 			.= " ,SH.SH_COM_CERTIFICATES2 ";
		$column['OP_LIST'] 			.= " ,SH.SH_COM_CERTIFICATES2_FILE ";
		$column['OP_LIST'] 			.= " ,SH.SH_COM_CERTIFICATES3 ";
		$column['OP_LIST'] 			.= " ,SH.SH_COM_CERTIFICATES3_FILE ";
		$column['OP_LIST'] 			.= " ,SH.SH_COM_CERTIFICATES4 ";
		$column['OP_LIST']			.= " ,SH.SH_COM_CERTIFICATES4_FILE ";
		$column['OP_LIST']			.= " ,SH.SH_COM_CERTIFICATES5 ";
		$column['OP_LIST']			.= " ,SH.SH_COM_CERTIFICATES5_FILE ";
		$column['OP_LIST']			.= " ,SH.SH_COM_CREDIT_GRADE ";
		$column['OP_LIST']			.= " ,SH.SH_COM_SALE_GRADE ";
		$column['OP_LIST']			.= " ,SH.SH_COM_LOCUS_GRADE ";
		$column['OP_LIST']			.= " ,SH.SH_REQUEST_DT ";
		$column['OP_LIST']			.= " ,SH.SH_ADMISSION_DT ";
		$column['OP_LIST']			.= " ,SH.SH_REG_DT ";
		$column['OP_LIST']			.= " ,SH.SH_REG_NO ";
		$column['OP_LIST']			.= " ,SH.SH_MOD_DT ";
		$column['OP_LIST']			.= " ,SH.SH_MOD_NO ";

		$column['OP_LIST']			.= " ,ST.ST_NAME ";
		$column['OP_LIST']			.= " ,ST.ST_NAME_ENG ";
		$column['OP_LIST']			.= " ,ST.ST_TEXT ";
		$column['OP_LIST']			.= " ,ST.ST_MEMO ";
		$column['OP_LIST']			.= " ,ST.ST_LOGO ";
		$column['OP_LIST']			.= " ,ST.ST_IMG ";
		$column['OP_LIST']			.= " ,ST.ST_THUMB_IMG ";


		$column['OP_SELECT']		= $column['OP_LIST'];

		if(!$op)			{ return; }

		if($param['SH_PROD_CNT_COLUML'] == "Y"):
			$columnFrom					= TBL_PRODUCT_MGR;
			$column['OP_LIST']			.= "
									      ,(SELECT COUNT(*) FROM {$columnFrom} WHERE P_SHOP_NO = SH.SH_NO) SH_PROD_CNT
										  ,(SELECT COUNT(*) FROM {$columnFrom} WHERE P_SHOP_NO = SH.SH_NO AND (P_APPR ='N' OR P_APPR ='')) SH_PROD_NO_APPR_CNT
										  ";
		endif;

		$from	= TBL_SHOP_MGR;
		$query	= "SELECT {$column[$op]} FROM {$from} AS SH";
		$where	= "WHERE SH.SH_NO IS NOT NULL";

		if($param['SHOP_SITE_JOIN'] == "Y"):
			$joinFrom = TBL_SHOP_SITE;
			$join1 = "LEFT OUTER JOIN {$joinFrom} AS ST ON ST.SH_NO = SH.SH_NO";
		endif;

		$join2 = " LEFT OUTER JOIN ".TBL_SHOP_INFO_LNG.$this->getP_LNG()." SI          ";
		$join2 .= " ON SH.SH_NO = SI.SH_NO                                     ";


		if($param['SEARCH_QUERY']):
			$where					= "{$where} AND {$param['SEARCH_QUERY']}";
		endif;


		if($param['SH_COM_COUNTRY']):
			$where	= "{$where} AND SH.SH_COM_COUNTRY = '{$param['SH_COM_COUNTRY']}'";
		endif;


		if($param['sh_no']):
			$where	= "{$where} AND SH.SH_NO = {$param['sh_no']}";
		endif;

		if($param['SH_NO_IN']):
			$where	= "{$where} AND SH.SH_NO IN ({$param['SH_NO_IN']})";
		endif;

		if($param['SH_APPR']):
			$where	= "{$where} AND SH.SH_APPR = '{$param['SH_APPR']}'";
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

	function getShopTotal($db)
	{
		$query  = "SELECT							";
		$query .= "     COUNT(*)					";
		$query .= "FROM ".TBL_SHOP_MGR." A			";
		$query .= "LEFT OUTER JOIN ".TBL_SHOP_SITE." B	";
		$query .= "ON A.SH_NO = B.SH_NO					";
		$query .= "	WHERE A.SH_NO IS NOT NULL		";

		if ($this->getSH_NO() > 0){
			$query .= "	AND A.SH_NO = ".$this->getSH_NO()."	";
		}

		if ($this->getSearchField() && $this->getSearchKey()){

			$query .= "	AND ";
			switch ($this->getSearchField()){
				case "I":
					$query .= "	A.SH_COM_NAME LIKE '%".$this->getSearchKey()."%'		";
				break;
				case "N":
					$query .= "	A.SH_COM_REP_NM LIKE '%".$this->getSearchKey()."%'		";
				break;
				case "M":
					$query .= "	A.SH_COM_MAIL LIKE '%".$this->getSearchKey()."%'		";
				break;
				case "S":
					$query .= "	B.ST_NAME LIKE '%".$this->getSearchKey()."%'		";
				break;
				case "P":
					$query .= "	A.SH_COM_NUM LIKE '%".$this->getSearchComNum()."%'		";
				break;
			}
		}

		if ($this->getSearchComAuth()){
			$query .= "	AND A.SH_APPR = '".$this->getSearchComAuth()."'	";
		}
		return $db->getCount($query);
	}


	function getShopList($db)
	{
		$query  = "SELECT							";
		$query .= " A.SH_NO ";
		$query .= " ,A.SH_TYPE ";
		$query .= " ,A.SH_COM_TYPE ";
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
		$query .= " ,SI.SH_COM_ADDR2 ";
		//$query .= " ,SI.SH_COM_COUNTRY ";
		$query .= " ,SI.SH_COM_CITY ";
		$query .= " ,SI.SH_COM_INTRO1 ";
		$query .= " ,SI.SH_COM_INTRO2 ";
		}else{
		//$query .= " ,A.SH_COM_NUM ";
		$query .= " ,A.SH_COM_NAME ";
		$query .= " ,A.SH_COM_REP_NM ";
		//$query .= " ,A.SH_COM_PHONE ";
		//$query .= " ,A.SH_COM_FAX ";
		//$query .= " ,A.SH_COM_MAIL ";
		//$query .= " ,A.SH_COM_CATEGORY ";
		$query .= " ,A.SH_COM_ZIP ";
		$query .= " ,A.SH_COM_ADDR ";
		$query .= " ,A.SH_COM_ADDR2 ";
		//$query .= " ,A.SH_COM_COUNTRY ";
		$query .= " ,A.SH_COM_CITY ";
		$query .= " ,A.SH_COM_INTRO1 ";
		$query .= " ,A.SH_COM_INTRO2 ";
		}
		$query .= " ,A.SH_COM_COUNTRY ";
		$query .= " ,A.SH_COM_PHONE ";
		$query .= " ,A.SH_COM_FAX ";
		$query .= " ,A.SH_COM_MAIL ";
		$query .= " ,A.SH_COM_CATEGORY ";

		$query .= " ,A.SH_COM_NUM ";
		$query .= " ,A.SH_COM_NUM2 ";
		$query .= " ,A.SH_COM_UPTAE ";
		$query .= " ,A.SH_COM_UPJONG ";
		$query .= " ,A.SH_COM_STATE ";
		$query .= " ,A.SH_COM_FILE1 ";
		$query .= " ,A.SH_COM_FILE2 ";
		$query .= " ,A.SH_COM_FILE3 ";
		$query .= " ,A.SH_COM_FILE4 ";
		$query .= " ,A.SH_COM_FILE5 ";
		$query .= " ,A.SH_COM_DEPOSIT ";
		$query .= " ,A.SH_COM_BANK ";
		$query .= " ,A.SH_COM_BANK_NUM ";
		$query .= " ,A.SH_COM_ACC_PRICE ";
		$query .= " ,A.SH_COM_ACC_RATE ";
		$query .= " ,A.SH_COM_DELIVERY ";
		$query .= " ,A.SH_COM_DELIVERY_ST_PRICE ";
		$query .= " ,A.SH_COM_DELIVERY_PRICE ";
		$query .= " ,A.SH_COM_DELIVERY_COR ";
		$query .= " ,A.SH_COM_DELIVERY_FOR_COR ";
		$query .= " ,A.SH_COM_DELIVERY_FREE ";
		$query .= " ,A.SH_COM_DEVLIERY_PROD ";
		$query .= " ,A.SH_COM_DELIVERY_AREA ";
		$query .= " ,A.SH_COM_DELIVERY_TEXT ";
		$query .= " ,A.SH_COM_PROD_AUTH ";
		$query .= " ,A.SH_COM_MAIN ";
		$query .= " ,A.SH_APPR ";
		$query .= " ,A.SH_APPR_NO_REASON ";
		$query .= " ,A.SH_COM_SITE ";
		$query .= " ,A.SH_COM_FOUNDED ";
		$query .= " ,A.SH_COM_NUMBER ";
		$query .= " ,A.SH_COM_TOTAL_SALE ";
		$query .= " ,A.SH_COM_RATE ";
		$query .= " ,A.SH_COM_TOTAL_PRODUCTION ";
		$query .= " ,A.SH_COM_COUNTRY1 ";
		$query .= " ,A.SH_COM_COUNTRY2 ";
		$query .= " ,A.SH_COM_COUNTRY3 ";
		$query .= " ,A.SH_COM_COUNTRY4 ";
		$query .= " ,A.SH_COM_COUNTRY5 ";
		$query .= " ,A.SH_COM_COUNTRY6 ";
		$query .= " ,A.SH_COM_COUNTRY7 ";
		$query .= " ,A.SH_COM_COUNTRY8 ";
		$query .= " ,A.SH_COM_COUNTRY9 ";
		$query .= " ,A.SH_COM_COUNTRY10 ";
		$query .= " ,A.SH_COM_COUNTRY11 ";
		$query .= " ,A.SH_COM_COUNTRY12 ";
		$query .= " ,A.SH_COM_COUNTRY13 ";
		$query .= " ,A.SH_COM_COUNTRY14 ";
		$query .= " ,A.SH_COM_LOCAL ";
		$query .= " ,A.SH_COM_SIZE ";
		$query .= " ,A.SH_COM_RD ";
		$query .= " ,A.SH_COM_CATE ";
		$query .= " ,A.SH_COM_CERTIFICATES1 ";
		$query .= " ,A.SH_COM_CERTIFICATES1_FILE ";
		$query .= " ,A.SH_COM_CERTIFICATES2 ";
		$query .= " ,A.SH_COM_CERTIFICATES2_FILE ";
		$query .= " ,A.SH_COM_CERTIFICATES3 ";
		$query .= " ,A.SH_COM_CERTIFICATES3_FILE ";
		$query .= " ,A.SH_COM_CERTIFICATES4 ";
		$query .= " ,A.SH_COM_CERTIFICATES4_FILE ";
		$query .= " ,A.SH_COM_CERTIFICATES5 ";
		$query .= " ,A.SH_COM_CERTIFICATES5_FILE ";

		$query .= " ,A.SH_COM_CREDIT_GRADE ";
		$query .= " ,A.SH_COM_SALE_GRADE ";
		$query .= " ,A.SH_COM_LOCUS_GRADE ";
		$query .= " ,A.SH_REQUEST_DT ";
		$query .= " ,A.SH_ADMISSION_DT ";
		$query .= " ,A.SH_REG_DT ";
		$query .= " ,A.SH_REG_NO ";
		$query .= " ,A.SH_MOD_DT ";
		$query .= " ,A.SH_MOD_NO ";

		$query .= "		,(SELECT COUNT(*) FROM ".TBL_PRODUCT_MGR." WHERE P_SHOP_NO = A.SH_NO) SH_PROD_CNT	";
		$query .= "FROM ".TBL_SHOP_MGR." A			";
		$query .= "LEFT OUTER JOIN ".TBL_SHOP_SITE." B	";
		$query .= "ON A.SH_NO = B.SH_NO					";

		if($this->getP_LNG()){
		$query .= " LEFT JOIN ".TBL_SHOP_INFO_LNG.$this->getP_LNG()." SI          ";
		$query .= " ON A.SH_NO = SI.SH_NO                                     ";
		}

		$query .= "	WHERE A.SH_NO IS NOT NULL		";

		if ($this->getSH_NO() > 0){
			$query .= "	AND A.SH_NO = ".$this->getSH_NO()."	";
		}

		if ($this->getSearchField() && $this->getSearchKey()){
			$query .= "	AND ";
			switch ($this->getSearchField()){
				case "I":
					$query .= "	A.SH_COM_NAME LIKE '%".$this->getSearchKey()."%'		";
				break;
				case "N":
					$query .= "	A.SH_COM_REP_NM LIKE '%".$this->getSearchKey()."%'		";
				break;
				case "M":
					$query .= "	A.SH_COM_MAIL LIKE '%".$this->getSearchKey()."%'		";
				break;
				case "S":
					$query .= "	B.ST_NAME LIKE '%".$this->getSearchKey()."%'		";
				break;
				case "P":
					$query .= "	A.SH_COM_NUM LIKE '%".$this->getSearchKey()."%'		";
				break;
			}
		}

		if ($this->getSearchComAuth()){
			$query .= "	AND A.SH_APPR = '".$this->getSearchComAuth()."'	";
		}

		if($this->getSH_COM_MAIN()) 
		{
			$query .= " AND A.SH_COM_MAIN = '".$this->getSH_COM_MAIN()."' "; 
		}


		$query .= "ORDER BY A.SH_NO DESC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();

		return $db->getExecSql($query);
	}


	function getShopUserListEx($db, $op, $param) {

		$column['OP_LIST']			= "*";
		$column['OP_SELECT']		= "*";

		if(!$op)			{ return; }

		$from1	= TBL_SHOP_USER;
		$from2	= TBL_MEMBER_MGR;
		$query	= "SELECT {$column[$op]} FROM {$from1} AS SU";
		$where	= "WHERE SU.SU_NO IS NOT NULL";
		$join1	= "LEFT OUTER JOIN {$from2} AS MM ON MM.M_NO = SU.M_NO";

		if($param['sh_no']):
			$where	= "{$where} AND SU.SH_NO = {$param['sh_no']}";
		endif;

		if($param['su_type']):
			$where	= "{$where} AND SU.SU_TYPE = '{$param['su_type']}'";
		endif;

		if($param['order_by']):
			$order_by	= "ORDER BY {$param['ORDER_BY']}";
		endif;

		if($param['limit']):
			$limit		= "LIMIT {$param['LIMIT']}";
		endif;

		$query = "{$query} {$join1} {$where} {$order_by} {$limit}";

		return $this->getSelectQuery($db, $query, $op);
	}

	function getShopUserList($db)
	{
		$query  = "SELECT								";
		$query .= "      A.*							";
		$query .= "		,B.M_ID							";
		$query .= "		,B.M_MAIL						";
		$query .= "		,B.M_PHONE						";
		$query .= "		,B.M_HP							";
		$query .= "		,CONCAT(B.M_F_NAME,' ' ,B.M_L_NAME) M_NAME	";
		$query .= "FROM ".TBL_SHOP_USER." A				";
		$query .= "JOIN ".TBL_MEMBER_MGR." B			";
		$query .= "ON A.M_NO = B.M_NO					";
		$query .= "	WHERE A.SH_NO = ".$this->getSH_NO();
		$query .= " ORDER BY A.SU_NO ASC			";

		return $db->getArrayTotal($query);
	}


	function getShopOrderTotal($db)
	{
		$query  = "SELECT						";
		$query .= "   COUNT(*)					";
		$query .= "FROM ".TBL_SHOP_ORDER." A    ";
		$query .= "JOIN ".TBL_ORDER_MGR." B     ";
		$query .= "ON A.O_NO = B.O_NO			";
		$query .= "LEFT OUTER JOIN ".TBL_MEMBER_MGR." C	";
		$query .= "ON B.M_NO = C.M_NO			";
		$query .= "JOIN ".TBL_SHOP_MGR." D		";
		$query .= "ON A.SH_NO = D.SH_NO			";
		$query .= "WHERE A.O_NO IS NOT NULL		";

		if ($this->getSH_NO() > 0){
			$query .= "	AND A.SH_NO = ".$this->getSH_NO()."	";
		}

		$query .= $this->getShopSearchQry("shopOrderList");

		$query .= "ORDER BY A.SO_NO DESC  ";

		return $db->getCount($query);
	}

	function getShopOrderList($db)
	{
		$query  = "SELECT						";
		$query .= "    A.*						";
		$query .= "	  ,B.*						";
		$query .= "   ,C.M_ID					";
		$query .= "   ,C.M_MAIL					";
		$query .= "   ,D.SH_COM_DELIVERY_COR	";
		$query .= "FROM ".TBL_SHOP_ORDER." A    ";
		$query .= "JOIN ".TBL_ORDER_MGR." B     ";
		$query .= "ON A.O_NO = B.O_NO			";
		$query .= "LEFT OUTER JOIN ".TBL_MEMBER_MGR." C	";
		$query .= "ON B.M_NO = C.M_NO			";
		$query .= "JOIN ".TBL_SHOP_MGR." D     ";
		$query .= "ON A.SH_NO = D.SH_NO			";
		$query .= "WHERE A.O_NO IS NOT NULL		";

		if ($this->getSH_NO() > 0){
			$query .= "	AND A.SH_NO = ".$this->getSH_NO()."	";
		}

		$query .= $this->getShopSearchQry("shopOrderList");

		$query .= "ORDER BY A.SO_NO DESC  ";

		return $db->getExecSql($query);
	}

	function getShopOrderCartList($db)
	{
		$query  = "SELECT														";
		$query .= "      A.*													";
		$query .= "		,AI.P_NAME												";
		$query .= "     ,C.PM_REAL_NAME											";
		$query .= "		,B.P_STOCK_LIMIT										";
		$query .= "		,B.P_STOCK_OUT											";
		$query .= "		,B.P_EVENT_UNIT											";
		$query .= "		,B.P_EVENT												";
		$query .= "FROM ".TBL_ORDER_CART." A									";
		$query .= "JOIN ".TBL_PRODUCT_MGR." B									";
		$query .= "ON A.P_CODE = B.P_CODE										";
		$query .= "JOIN ".TBL_PRODUCT_INFO_LNG.$this->getP_LNG()." AI			";
		$query .= "ON A.P_CODE = AI.P_CODE										";
		$query .= "LEFT OUTER JOIN ".TBL_PRODUCT_IMG." C						";
		$query .= "ON A.P_CODE = C.P_CODE										";
		$query .= "AND C.PM_TYPE = 'list'										";
		$query .= "WHERE A.OC_NO IS NOT NULL									";
		$query .= "	AND A.O_NO = ".$this->getO_NO()."							";
		$query .= "	AND B.P_SHOP_NO = ".$this->getSH_NO()."						";
		$query .= "ORDER BY A.OC_NO DESC ";

		return $db->getArrayTotal($query);
	}

	function getShopOrderCartAddList($db)
	{
		$query  = "SELECT									";
		$query .= "     A.*									";
		$query .= "FROM ".TBL_ORDER_CART_ADD." A			";
		$query .= "WHERE A.OC_NO = ".$this->getOC_NO()."	";
		$query .= "ORDER BY A.OCA_NO DESC					";

		return $db->getArrayTotal($query);
	}

	function getShopSearchQry($mode)
	{
		$query = "";

		if ($mode == "shopOrderList") {
			/*구매상태*/
			if ($this->getSearchOrderStatus()){
				$query .= "	AND A.SO_ORDER_STATUS IN (".$this->getSearchOrderStatus().")";
			}

			/*결제상태*/
			if ($this->getSearchSettleStatus() == "N"){
				$query .= "	AND B.O_STATUS IN ('J','0')";
			}

			if ($this->getSearchSettleStatus() == "Y"){
				$query .= "	AND B.O_STATUS IN ('A')";
			}

			/*배송상태*/
			if ($this->getSearchDeliveryStatus()){
				$query .= "	AND A.SO_DELIVERY_STATUS IN (".$this->getSearchDeliveryStatus().")";
			}

			if($this->getSearchMemberType()) :
				// 회원구분
				if($this->getSearchMemberType() == "member"):
					// 회원
					$query .= "	AND A.M_NO > 0	";
				elseif($this->getSearchMemberType() == "nonmember"):
					// 비회원
					$query .= "	AND IFNULL(A.M_NO,0) = 0	";
				endif;
			endif;

			if ($this->getSearchField() && $this->getSearchKey()){
				$query .= "	AND ";
				switch ($this->getSearchField()){
					case "K":
						$query .= "	B.O_KEY LIKE '%'".$this->getSearchKey()."%'		";
					break;
					case "J":
						$query .= "	B.O_J_NAME LIKE '%'".$this->getSearchKey()."%'	";
					break;
					case "M":
						$query .= "	C.M_ID LIKE '%'".$this->getSearchKey()."%'		";
					break;
					case "B":
						$query .= "	B.O_B_NAME LIKE '%'".$this->getSearchKey()."%'	";
					break;
				}
			}

			if ($this->getSearchRegStartDt() && $this->getSearchRegEndDt()){
				$query .= "	AND B.O_REG_DT BETWEEN DATE_FORMAT('".mysql_real_escape_string($this->getSearchRegStartDt())."','%Y-%m-%d 00:00:00') ";
				$query .= "	AND DATE_FORMAT('".mysql_real_escape_string($this->getSearchRegEndDt())."','%Y-%m-%d 23:59:59') ";
			}
		}

		return $query;
	}

	function getShopOrderAllList($db)
	{
		$query  = "SELECT								";
		$query .= "    A.*								";
		$query .= "FROM ".TBL_SHOP_ORDER." A			";
		$query .= "WHERE A.O_NO IS NOT NULL				";
		$query .= "	AND A.O_NO = ".$this->getO_NO()."	";

		return $db->getArrayTotal($query);
	}

	function getShopPrductCnt($db)
	{
		$query = "SELECT COUNT(*) FROM ".TBL_PRODUCT_MGR." WHERE P_SHOP_NO = ".$this->getSH_NO();
		return $db->getCount($query);
	}
	/********************************** View **********************************/
	function getShopView($db)
	{
		$query  = "SELECT ";
		$query .= " SH.SH_NO ";
		$query .= " ,SH.SH_TYPE ";
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
		$query .= " ,SI.SH_COM_ADDR2 ";
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
		$query .= " ,SH.SH_COM_ADDR2 ";
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
		$query .= " WHERE SH.SH_NO = ".$this->getSH_NO();

		return $db->getSelect($query);
	}

	function getShopLogo($db)
	{
		$query = "SELECT * FROM SHOP_SITE WHERE SH_NO = ".$this->getSH_NO();
		return $db->getSelect($query);
	}

	function getStoreView($db)
	{
		$query = "SELECT * FROM ".TBL_SHOP_SITE." WHERE SH_NO = ".$this->getSH_NO();
		return $db->getSelect($query);
	}

	function getShopUserViewEx($db, $op, $param)
	{
		$column['OP_LIST']		= "*";
		$column['OP_SELECT']	= "*";

		if(!$op)	{ return; }
//		if(!$param) { return; }

		$query	= "SELECT {$column[$op]} FROM ".TBL_SHOP_USER." AS SU";
		$join1	= "LEFT OUTER JOIN ".TBL_MEMBER_MGR." AS MM ON SU.M_NO = MM.M_NO";
		$where	= "WHERE SU.SU_NO IS NOT NULL";

		if($param['SH_NO']):
			$where		= "{$where} AND SU.SH_NO = '{$param['SH_NO']}'";
		endif;

		if($param['SU_TYPE']):
			$where		= "{$where} AND SU.SU_TYPE = '{$param['SU_TYPE']}'";
		endif;

		if($param['ORDER_BY']):
			$order_by	= "ORDER BY {$param['ORDER_BY']}";
		endif;

		if($param['LIMIT']):
			$limit		= "LIMIT {$param['LIMIT']}";
		endif;

		$query = "{$query} {$join1} {$where} {$order_by} {$limit}";

		return $this->getSelectQuery($db, $query, $op);
	}

	function getShopUserView($db)
	{
		$query  = "SELECT											";
		$query .= "     A.*											";
		$query .= "    ,CONCAT(B.M_F_NAME,' ',B.M_L_NAME) M_NAME	";
		$query .= "    ,B.M_ID										";
		$query .= "    ,B.M_PHONE									";
		$query .= "    ,B.M_MAIL									";
		$query .= "    ,B.M_MAILYN									";
		$query .= "	   ,B.M_HP										";
		$query .= "	   ,B.M_SMSYN									";
		$query .= "	   ,B.M_BIRTH									";
		$query .= "	   ,B.M_BIRTH_CAL								";
		$query .= "	   ,B.M_SEX										";
		$query .= "	   ,B.M_REC_ID									";
		$query .= "FROM ".TBL_SHOP_USER." A							";
		$query .= "JOIN ".TBL_MEMBER_MGR." B						";
		$query .= "ON A.M_NO = B.M_NO								";
		$query .= "WHERE A.SU_NO = ".$this->getSU_NO();

		return $db->getSelect($query);
	}

	function getShopUserNo($db)
	{
		$query  = "SELECT											";
		$query .= "     A.SU_NO										";
		$query .= "FROM ".TBL_SHOP_USER." A							";
		$query .= "WHERE A.M_NO = ".$this->getM_NO();

		return $db->getCount($query);
	}

	function getShopOrderView($db)
	{
		$query  = "SELECT											";
		$query .= "     A.*											";
		$query .= "FROM ".TBL_SHOP_ORDER." A						";
		$query .= "WHERE A.SO_NO = ".$this->getSO_NO();

		return $db->getSelect($query);
	}

	// 평균 구하기
	function getShopAverageEx($db, $param) {

		$op						= "OP_SELECT";
		$column['OP_SELECT']	= "SUM(UB.UB_P_GRADE) AS SUM,  COUNT(*) AS COUNT, SUM(UB.UB_P_GRADE) / COUNT(*) AS AVERAGE";

//		if(!$op)	{ return; }
//		if(!$param) { return; }

		$query	= "SELECT {$column[$op]} FROM BOARD_UB_PROD_REVIEW AS UB";
		$join1	= "JOIN  PRODUCT_MGR AS PM ON UB.UB_P_CODE = PM.P_CODE";
		$where	= "WHERE UB.UB_NO IS NOT NULL";

		if($param['P_SHOP_NO']):
			$where		= "{$where} AND PM.P_SHOP_NO = '{$param['P_SHOP_NO']}'";
		endif;

		if($param['ORDER_BY']):
			$order_by	= "ORDER BY {$param['ORDER_BY']}";
		endif;

		if($param['LIMIT']):
			$limit		= "LIMIT {$param['LIMIT']}";
		endif;

		$query = "{$query} {$join1} {$where} {$order_by} {$limit}";

		return $this->getSelectQuery($db, $query, $op);
	}

	/********************************** Insert **********************************/
	function getShopInsert($db)
	{
		$query = "CALL SP_SHOP_MGR_I (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getSH_TYPE();
		$param[]  = $this->getSH_COM_TYPE();
		$param[]  = $this->getSH_COM_NUM();
		$param[]  = $this->getSH_COM_NAME();
		$param[]  = $this->getSH_COM_REP_NM();
		$param[]  = $this->getSH_COM_PHONE();
		$param[]  = $this->getSH_COM_FAX();
		$param[]  = $this->getSH_COM_MAIL();
		$param[]  = $this->getSH_COM_UPTAE();
		$param[]  = $this->getSH_COM_UPJONG();
		$param[]  = $this->getSH_COM_CATEGORY();
		$param[]  = $this->getSH_COM_NUM2();
		$param[]  = $this->getSH_COM_ZIP();
		$param[]  = $this->getSH_COM_ADDR();
		$param[]  = $this->getSH_COM_ADDR2();
		$param[]  = $this->getSH_COM_COUNTRY();
		$param[]  = $this->getSH_COM_FILE1();
		$param[]  = $this->getSH_COM_FILE2();
		$param[]  = $this->getSH_COM_FILE3();
		$param[]  = $this->getSH_COM_FILE4();
		$param[]  = $this->getSH_COM_FILE5();
		$param[]  = $this->getSH_COM_MAIN();
		$param[]  = $this->getSH_APPR();
		$param[]  = $this->getSH_APPR_NO_REASON();
		$param[]  = $this->getSH_COM_CITY();
		$param[]  = $this->getSH_COM_STATE();
		$param[]  = $this->getSH_COM_SITE();
		$param[]  = $this->getSH_COM_FOUNDED();
		$param[]  = $this->getSH_COM_NUMBER();
		$param[]  = $this->getSH_COM_TOTAL_SALE();
		$param[]  = $this->getSH_COM_RATE();
		$param[]  = $this->getSH_COM_TOTAL_PRODUCTION();
		$param[]  = $this->getSH_COM_COUNTRY1();
		$param[]  = $this->getSH_COM_COUNTRY2();
		$param[]  = $this->getSH_COM_COUNTRY3();
		$param[]  = $this->getSH_COM_COUNTRY4();
		$param[]  = $this->getSH_COM_COUNTRY5();
		$param[]  = $this->getSH_COM_COUNTRY6();
		$param[]  = $this->getSH_COM_COUNTRY7();
		$param[]  = $this->getSH_COM_COUNTRY8();
		$param[]  = $this->getSH_COM_COUNTRY9();
		$param[]  = $this->getSH_COM_COUNTRY10();
		$param[]  = $this->getSH_COM_COUNTRY11();
		$param[]  = $this->getSH_COM_COUNTRY12();
		$param[]  = $this->getSH_COM_COUNTRY13();
		$param[]  = $this->getSH_COM_COUNTRY14();
		$param[]  = $this->getSH_COM_LOCAL();
		$param[]  = $this->getSH_COM_SIZE();
		$param[]  = $this->getSH_COM_RD();
		$param[]  = $this->getSH_COM_CATE();
		$param[]  = $this->getSH_COM_CERTIFICATES1();
		$param[]  = $this->getSH_COM_CERTIFICATES1_FILE();
		$param[]  = $this->getSH_COM_CERTIFICATES2();
		$param[]  = $this->getSH_COM_CERTIFICATES2_FILE();
		$param[]  = $this->getSH_COM_CERTIFICATES3();
		$param[]  = $this->getSH_COM_CERTIFICATES3_FILE();
		$param[]  = $this->getSH_COM_CERTIFICATES4();
		$param[]  = $this->getSH_COM_CERTIFICATES4_FILE();
		$param[]  = $this->getSH_COM_CERTIFICATES5();
		$param[]  = $this->getSH_COM_CERTIFICATES5_FILE();
		$param[]  = $this->getSH_COM_INTRO1();
		$param[]  = $this->getSH_COM_INTRO2();

		$param[]  = $this->getSH_REG_NO();

		return $db->executeBindingQuery($query,$param,true);
	}

	function getStoreInsertUpdate($db)
	{
		$query = "CALL SP_SHOP_SITE_IU (?,?,?,?,?,?,?,?);";

		$param[]  = $this->getSH_NO();
		$param[]  = $this->getST_NAME();
		$param[]  = $this->getST_NAME_ENG();
		$param[]  = $this->getST_TEXT();
		$param[]  = $this->getST_MEMO();
		$param[]  = $this->getST_LOGO();
		$param[]  = $this->getST_IMG();
		$param[]  = $this->getST_THUMB_IMG();

		return $db->executeBindingQuery($query,$param,true);
	}

	function getShopUserInsert($db)
	{
		$query = "CALL SP_SHOP_USER_I (?,?,?,?,?);";

		$param[]  = $this->getSH_NO();
		$param[]  = $this->getM_NO();
		$param[]  = $this->getSU_TYPE();
		$param[]  = $this->getSU_MEMO();
		$param[]  = $this->getSU_USE();

		return $db->executeBindingQuery($query,$param,true);
	}
	/********************************** Insert **********************************/


	function getShopUpdate($db)
	{
		$query = "CALL SP_SHOP_MGR_U (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getSH_NO();
		$param[]  = $this->getSH_TYPE();
		$param[]  = $this->getSH_COM_TYPE();
		$param[]  = $this->getSH_COM_NUM();
		$param[]  = $this->getSH_COM_NAME();
		$param[]  = $this->getSH_COM_REP_NM();
		$param[]  = $this->getSH_COM_PHONE();
		$param[]  = $this->getSH_COM_FAX();
		$param[]  = $this->getSH_COM_MAIL();
		$param[]  = $this->getSH_COM_UPTAE();
		$param[]  = $this->getSH_COM_UPJONG();
		$param[]  = $this->getSH_COM_CATEGORY();
		$param[]  = $this->getSH_COM_NUM2();
		$param[]  = $this->getSH_COM_ZIP();
		$param[]  = $this->getSH_COM_ADDR();
		$param[]  = $this->getSH_COM_ADDR2();
		$param[]  = $this->getSH_COM_COUNTRY();		
		$param[]  = $this->getSH_COM_FILE1();
		$param[]  = $this->getSH_COM_FILE2();
		$param[]  = $this->getSH_COM_FILE3();
		$param[]  = $this->getSH_COM_FILE4();
		$param[]  = $this->getSH_COM_FILE5();
		$param[]  = $this->getSH_APPR();
		$param[]  = $this->getSH_COM_CITY();
		$param[]  = $this->getSH_COM_STATE();
		$param[]  = $this->getSH_COM_MAIN();

		$param[]  = $this->getSH_COM_SITE();
		$param[]  = $this->getSH_COM_FOUNDED();
		$param[]  = $this->getSH_COM_NUMBER();
		$param[]  = $this->getSH_COM_TOTAL_SALE();
		$param[]  = $this->getSH_COM_RATE();
		$param[]  = $this->getSH_COM_TOTAL_PRODUCTION();
		$param[]  = $this->getSH_COM_COUNTRY1();
		$param[]  = $this->getSH_COM_COUNTRY2();
		$param[]  = $this->getSH_COM_COUNTRY3();
		$param[]  = $this->getSH_COM_COUNTRY4();
		$param[]  = $this->getSH_COM_COUNTRY5();
		$param[]  = $this->getSH_COM_COUNTRY6();
		$param[]  = $this->getSH_COM_COUNTRY7();
		$param[]  = $this->getSH_COM_COUNTRY8();
		$param[]  = $this->getSH_COM_COUNTRY9();
		$param[]  = $this->getSH_COM_COUNTRY10();
		$param[]  = $this->getSH_COM_COUNTRY11();
		$param[]  = $this->getSH_COM_COUNTRY12();
		$param[]  = $this->getSH_COM_COUNTRY13();
		$param[]  = $this->getSH_COM_COUNTRY14();
		$param[]  = $this->getSH_COM_LOCAL();
		$param[]  = $this->getSH_COM_SIZE();
		$param[]  = $this->getSH_COM_RD();
		$param[]  = $this->getSH_COM_CATE();
		$param[]  = $this->getSH_COM_CERTIFICATES1();
		$param[]  = $this->getSH_COM_CERTIFICATES1_FILE();
		$param[]  = $this->getSH_COM_CERTIFICATES2();
		$param[]  = $this->getSH_COM_CERTIFICATES2_FILE();
		$param[]  = $this->getSH_COM_CERTIFICATES3();
		$param[]  = $this->getSH_COM_CERTIFICATES3_FILE();
		$param[]  = $this->getSH_COM_CERTIFICATES4();
		$param[]  = $this->getSH_COM_CERTIFICATES4_FILE();
		$param[]  = $this->getSH_COM_CERTIFICATES5();
		$param[]  = $this->getSH_COM_CERTIFICATES5_FILE();
		$param[]  = $this->getSH_COM_INTRO1();
		$param[]  = $this->getSH_COM_INTRO2();

		$param[]  = $this->getSH_MOD_NO();

		return $db->executeBindingQuery($query,$param,true);

	}

	function getShopSettingUpdate($db)
	{
		$query = "CALL SP_SHOP_MGR_SU (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getSH_NO();
		$param[]  = $this->getSH_COM_DEPOSIT();
		$param[]  = $this->getSH_COM_BANK();
		$param[]  = $this->getSH_COM_BANK_NUM();
		$param[]  = $this->getSH_COM_ACC_PRICE();
		$param[]  = $this->getSH_COM_ACC_RATE();
		$param[]  = $this->getSH_COM_DELIVERY();
		$param[]  = $this->getSH_COM_DELIVERY_ST_PRICE();
		$param[]  = $this->getSH_COM_DELIVERY_PRICE();
		$param[]  = $this->getSH_COM_DELIVERY_COR();
		$param[]  = $this->getSH_COM_DELIVERY_FOR_COR();
		$param[]  = $this->getSH_COM_DELIVERY_FREE();
		$param[]  = $this->getSH_COM_DEVLIERY_PROD();
		$param[]  = $this->getSH_COM_DELIVERY_AREA();
		$param[]  = $this->getSH_COM_DELIVERY_TEXT();
		$param[]  = $this->getSH_MOD_NO();

		return $db->executeBindingQuery($query,$param,true);
	}

	function getShopUserUpdate($db)
	{
		$query = "CALL SP_SHOP_USER_U (?,?,?,?);";

		$param[]  = $this->getSU_NO();
		$param[]  = $this->getSU_TYPE();
		$param[]  = $this->getSU_MEMO();
		$param[]  = $this->getSU_USE();

		return $db->executeBindingQuery($query,$param,true);
	}

	function getOrderStatusUpdate($db)
	{
		$query  = "UPDATE ".TBL_SHOP_ORDER." SET SO_ORDER_STATUS = '".$this->getSO_ORDER_STATUS()."'";
		$query .= "	WHERE SO_NO = ".$this->getSO_NO();

		return $db->getExecSql($query);
	}

	/**
	 * 작성일 : 2013.06.19
	 * 작성자 : kim hee sung
	 * 내  용 : SHOP_ORDER 입점사 배송정보 변경
	 **/
	function getDeliveryUpdateEx($db, $paramData) {

		if(!$paramData['so_no']) { return; }

		$strTableName					= TBL_SHOP_ORDER;
		$param['SO_DELIVERY_COM']		= $db->getSQLString($paramData['so_delivery_com']);
		$param['SO_DELIVERY_NUM']		= $db->getSQLString($paramData['so_delivery_num']);
		$param['SO_DELIVERY_STATUS']	= $db->getSQLString($paramData['so_delivery_status']);

		if ($paramData['so_delivery_status'] == "D")
		{
			$param['SO_DELIVERY_REG_DT']= $db->getSQLDatetime("NOW()");
		}

		$where							= "SO_NO = {$paramData['so_no']}";

		if($paramData['sh_no']):
			$where						= "{$where} AND SH_NO = {$paramData['sh_no']}";
		endif;

		return $db->getUpdateParam($strTableName, $param, $where);
	}

	function getDeliveryUpdate($db)
	{
		$query  = "UPDATE ".TBL_SHOP_ORDER." SET SO_DELIVERY_COM = '".$this->getSO_DELIVERY_COM()."'";
		$query .= "	,SO_DELIVERY_NUM	= '".$this->getSO_DELIVERY_NUM()."'";
		$query .= " ,SO_DELIVERY_STATUS = '".$this->getSO_DELIVERY_STATUS()."'";

		if ($this->getSO_DELIVERY_STATUS() == "D"){
			$query .= " ,SO_DELIVERY_REG_DT = NOW()	";
		}

		$query .= "	WHERE SO_NO = ".$this->getSO_NO();
		return $db->getExecSql($query);
	}

	function getDeliveryStatusUpdate($db)
	{
		$query  = "UPDATE ".TBL_SHOP_ORDER." SET SO_DELIVERY_STATUS = '".$this->getSO_DELIVERY_STATUS()."'";
		$query .= "	WHERE SO_NO = ".$this->getSO_NO();

		return $db->getExecSql($query);
	}

	function getOrderAllUpdate($db)
	{
		$query  = "UPDATE ".TBL_ORDER_MGR." SET O_STATUS = '".$this->getO_STATUS()."' ";
		$query .= "WHERE O_NO = ".$this->getO_NO();

		return $db->getExecSql($query);
	}

	/**
	 * 작성일 : 2013.06.19
	 * 작성자 : kim hee sung
	 * 내  용 : SHOP_ORDER 입점사 구매상태(SO_ORDER_STATUS) 변경
	 **/
	function getOrderStatusUpdateEx($db, $paramData) {

		if(!$paramData['so_no']) { return; }

		$strTableName					= TBL_SHOP_ORDER;
		$param['SO_ORDER_STATUS']		= $db->getSQLString($paramData['so_order_status']);
		$where							= "SO_NO = {$paramData['so_no']}";
		return $db->getUpdateParam($strTableName, $param, $where);
	}
	/********************************** DELETE **********************************/
	function getShopDelete($db)
	{
		$query = "DELETE FROM ".TBL_SHOP_MGR." WHERE SH_NO=".$this->getSH_NO();

		return $db->getExecSql($query);
	}

	function getShopInfoLngDelete($db)
	{
		$query  = "DELETE FROM ".TBL_SHOP_INFO_LNG.$this->getP_LNG();
		$query .= "	WHERE SH_NO = '".$this->getSH_NO()."'";

		return $db->getExecSql($query);
	}

	function getShopFileDelete($db)
	{
		$query  = "UPDATE ".TBL_SHOP_MGR." SET SH_FILE".$this->getSH_FILE_NO()." = NULL ";
		$query .= "WHERE SH_NO = ".$this->getSH_NO();

		return $db->getExecSql($query);
	}

	function getStoreDelete($db)
	{
		$query = "DELETE FROM ".TBL_SHOP_SITE." WHERE SH_NO=".$this->getSH_NO();

		return $db->getExecSql($query);
	}

	function getStoreFileDelete($db)
	{
		if ($this->getSH_FILE_NO() == "1") {
			$query  = "UPDATE ".TBL_SHOP_SITE." SET ST_LOGO = NULL ";
		} else if ($this->getSH_FILE_NO() == "2"){
			$query  = "UPDATE ".TBL_SHOP_SITE." SET ST_IMG = NULL ";
		} else if ($this->getSH_FILE_NO() == "3") {
			$query  = "UPDATE ".TBL_SHOP_SITE." SET ST_THUMB_IMG = NULL ";
		}
		$query .= "WHERE SH_NO = ".$this->getSH_NO();

		return $db->getExecSql($query);
	}

	function getShopUserDelete($db)
	{
		$query  = "DELETE FROM ".TBL_SHOP_USER."  ";
		$query .= "WHERE SU_NO = ".$this->getSU_NO();

		return $db->getExecSql($query);
	}

	function getShopUserAllDelete($db)
	{
		$query  = "DELETE FROM ".TBL_SHOP_USER."  ";
		$query .= "WHERE SH_NO = ".$this->getSH_NO();

		return $db->getExecSql($query);
	}

	function getShopGrade($db)
	{
		$query = "CALL SP_SHOP_MGR_GRADE_U (?,?,?,?,?,?);";

		$param[]  = $this->getSH_NO();
		$param[]  = $this->getSH_COM_CREDIT_GRADE();
		$param[]  = $this->getSH_COM_SALE_GRADE();
		$param[]  = $this->getSH_COM_LOCUS_GRADE();
		$param[]  = $this->getSH_COM_PROD_AUTH();
		$param[]  = $this->getSH_MOD_NO();

		return $db->executeBindingQuery($query,$param,true);
	}

	//등금평가보기
	function getShopGradePointView($db)
	{
		$query  = "SELECT * FROM SHOP_GRADE_POINT ";
		$query .= " WHERE SH_NO = ".$this->getSH_NO();

		return $db->getSelect($query);
	}

	//등금평가 업데이트
	function getShopGradePointUpdate($db)
	{
		$query  = "UPDATE `SHOP_GRADE_POINT` SET ";
		$query  .= " `SH_INFO_CHECK` = ".$this->getSQLString($this->getSH_INFO_CHECK());
		$query  .= " , `SH_INFO_POINT` = ".$this->getSQLString($this->getSH_INFO_POINT());
		$query  .= " , `SH_PROD_CNT` = ".$this->getSQLString($this->getSH_PROD_CNT());
		$query  .= " , `SH_PROD_POINT` = ".$this->getSQLString($this->getSH_PROD_POINT());
		$query  .= " , `SH_WORK_CHECK` = ".$this->getSQLString($this->getSH_WORK_CHECK());
		$query  .= " , `SH_WORK_POINT` = ".$this->getSQLString($this->getSH_WORK_POINT());
		$query  .= " , `SH_CERTI_CHECK` = ".$this->getSQLString($this->getSH_CERTI_CHECK());
		$query  .= " , `SH_CERTI_POINT` = ".$this->getSQLString($this->getSH_CERTI_POINT());
		$query  .= " , `SH_GRADE_UNTRUTH` = ".$this->getSQLString($this->getSH_GRADE_UNTRUTH());
		$query  .= " , `SH_GRADE_UNTRUTH_POINT` = ".$this->getSQLString($this->getSH_GRADE_UNTRUTH_POINT());
		$query  .= " , `SH_PROD_POINT2` = ".$this->getSQLString($this->getSH_PROD_POINT2());
		$query  .= " , `SH_ORDER_CHECK` = ".$this->getSQLString($this->getSH_ORDER_CHECK());
		$query  .= " , `SH_ORDER_POINT` = ".$this->getSQLString($this->getSH_ORDER_POINT());
		$query  .= " , `SH_GRADE_CHECK` = ".$this->getSQLString($this->getSH_GRADE_CHECK());
		$query  .= " , `SH_GRADE_POINT` = ".$this->getSQLString($this->getSH_GRADE_POINT());
		$query  .= " , `SH_RATING_CHECK` = ".$this->getSQLString($this->getSH_RATING_CHECK());
		$query  .= " , `SH_RATING_POINT` = ".$this->getSQLString($this->getSH_RATING_POINT());
		$query  .= " , `SH_PROD_UNTRUTH` = ".$this->getSQLString($this->getSH_PROD_UNTRUTH());
		$query  .= " , `SH_PROD_UNTRUTH_POINT` = ".$this->getSQLString($this->getSH_PROD_UNTRUTH_POINT());
		$query  .= " , `SH_MOD_DT` = NOW()";
		$query  .= " , `SH_MOD_NO` = ".$this->getSQLString($this->getSH_MOD_NO());

		$query .= " WHERE `SH_NO` = ".$this->getSH_NO();

		return $db->getExecSql($query);
	}

	//등금평가 점수 
	function getShopGradePointInsert($db)
	{
		//if(empty($this->getSH_NO())){ return;}
		$param['SH_NO']						= $this->getSQLString($this->getSH_NO());
		$param['SH_INFO_CHECK']				= $this->getSQLString($this->getSH_INFO_CHECK());
		$param['SH_INFO_POINT']				= $this->getSQLString($this->getSH_INFO_POINT());
		$param['SH_PROD_CNT']				= $this->getSQLString($this->getSH_PROD_CNT());
		$param['SH_PROD_POINT']				= $this->getSQLString($this->getSH_PROD_POINT());
		$param['SH_WORK_CHECK']				= $this->getSQLString($this->getSH_WORK_CHECK());
		$param['SH_WORK_POINT']				= $this->getSQLString($this->getSH_WORK_POINT());
		$param['SH_CERTI_CHECK']			= $this->getSQLString($this->getSH_CERTI_CHECK());
		$param['SH_CERTI_POINT']			= $this->getSQLString($this->getSH_CERTI_POINT());
		$param['SH_GRADE_UNTRUTH']			= $this->getSQLString($this->getSH_GRADE_UNTRUTH());
		$param['SH_GRADE_UNTRUTH_POINT']	= $this->getSQLString($this->getSH_GRADE_UNTRUTH_POINT());
		$param['SH_PROD_POINT2']			= $this->getSQLString($this->getSH_PROD_POINT2());
		$param['SH_ORDER_CHECK']			= $this->getSQLString($this->getSH_ORDER_CHECK());
		$param['SH_ORDER_POINT']			= $this->getSQLString($this->getSH_ORDER_POINT());
		$param['SH_GRADE_CHECK']			= $this->getSQLString($this->getSH_GRADE_CHECK());
		$param['SH_GRADE_POINT']			= $this->getSQLString($this->getSH_GRADE_POINT());
		$param['SH_RATING_CHECK']			= $this->getSQLString($this->getSH_RATING_CHECK());
		$param['SH_RATING_POINT']			= $this->getSQLString($this->getSH_RATING_POINT());
		$param['SH_PROD_UNTRUTH']			= $this->getSQLString($this->getSH_PROD_UNTRUTH());
		$param['SH_PROD_UNTRUTH_POINT']		= $this->getSQLString($this->getSH_PROD_UNTRUTH_POINT());
		$param['SH_REG_DT']					= "NOW()";
		$param['SH_REG_NO']					= $this->getSQLString($this->getSH_REG_NO());
		$param['SH_MOD_DT']					= "NOW()";
		$param['SH_MOD_NO']					= $this->getSQLString($this->getSH_MOD_NO());

		return $db->getInsertParam("SHOP_GRADE_POINT", $param, false);



//			$query = "CALL SP_PRODUCT_INFO_I (?,?,?,?,?,?,?,?,?,?,?);";
//			$param[]  = $this->getP_CODE();
//			$param[]  = $this->getP_LNG();
//			$param[]  = $this->getP_NAME();
//			$param[]  = $this->getP_SEARCH_TEXT();
//			$param[]  = $this->getP_WEB_TEXT();
//			$param[]  = $this->getP_MOB_TEXT();
//			$param[]  = $this->getP_MEMO();
//			$param[]  = $this->getP_DELIVERY_TEXT();
//			$param[]  = $this->getP_RETURN_TEXT();
//			$param[]  = $this->getP_ETC();
//			$param[]  = $this->getP_PRICE_TEXT();
//
//			return $db->executeBindingQuery($query,$param,true);
	}

	function getShopInfoInsert($db)
	{
		//if(empty($this->getSH_NO())){ return;}
		$param['SH_NO']				= $this->getSQLString($this->getSH_NO());
		$param['SH_COM_COUNTRY']	= $this->getSQLString($this->getSH_COM_COUNTRY());
		$param['SH_COM_NAME']		= $this->getSQLString($this->getSH_COM_NAME());
		$param['SH_COM_REP_NM']		= $this->getSQLString($this->getSH_COM_REP_NM());
		$param['SH_COM_PHONE']		= $this->getSQLString($this->getSH_COM_PHONE());
		$param['SH_COM_FAX']		= $this->getSQLString($this->getSH_COM_FAX());
		$param['SH_COM_NUM']		= $this->getSQLString($this->getSH_COM_NUM());
		$param['SH_COM_CATEGORY']	= $this->getSQLString($this->getSH_COM_CATEGORY());
		$param['SH_COM_ZIP']		= $this->getSQLString($this->getSH_COM_ZIP());
		$param['SH_COM_ADDR']		= $this->getSQLString($this->getSH_COM_ADDR());
		$param['SH_COM_ADDR2']		= $this->getSQLString($this->getSH_COM_ADDR2());
		$param['SH_COM_CITY']		= $this->getSQLString($this->getSH_COM_CITY());
		$param['SH_COM_STATE']		= $this->getSQLString($this->getSH_COM_STATE());
		$param['SH_COM_MAIL']		= $this->getSQLString($this->getSH_COM_MAIL());
		$param['SH_COM_INTRO1']		= $this->getSQLString($this->getSH_COM_INTRO1());
		$param['SH_COM_INTRO2']		= $this->getSQLString($this->getSH_COM_INTRO2());
		$param['SH_COM_LOCAL']		= $this->getSQLString($this->getSH_COM_LOCAL());
		$param['SH_COM_SIZE']		= $this->getSQLString($this->getSH_COM_SIZE());
		$param['SH_COM_CATE']		= $this->getSQLString($this->getSH_COM_CATE());

		return $db->getInsertParam("SHOP_INFO_".$this->getP_LNG(), $param, false);



//			$query = "CALL SP_PRODUCT_INFO_I (?,?,?,?,?,?,?,?,?,?,?);";
//			$param[]  = $this->getP_CODE();
//			$param[]  = $this->getP_LNG();
//			$param[]  = $this->getP_NAME();
//			$param[]  = $this->getP_SEARCH_TEXT();
//			$param[]  = $this->getP_WEB_TEXT();
//			$param[]  = $this->getP_MOB_TEXT();
//			$param[]  = $this->getP_MEMO();
//			$param[]  = $this->getP_DELIVERY_TEXT();
//			$param[]  = $this->getP_RETURN_TEXT();
//			$param[]  = $this->getP_ETC();
//			$param[]  = $this->getP_PRICE_TEXT();
//
//			return $db->executeBindingQuery($query,$param,true);
	}

	function getshopInfoUpdate($db)
	{
		if(!$this->getSH_NO()) { return; }

		$param['SH_COM_COUNTRY']	= $this->getSQLString($this->getSH_COM_COUNTRY());
		$param['SH_COM_NAME']		= $this->getSQLString($this->getSH_COM_NAME());
		$param['SH_COM_REP_NM']		= $this->getSQLString($this->getSH_COM_REP_NM());
		$param['SH_COM_PHONE']		= $this->getSQLString($this->getSH_COM_PHONE());
		$param['SH_COM_FAX']		= $this->getSQLString($this->getSH_COM_FAX());
		$param['SH_COM_NUM']		= $this->getSQLString($this->getSH_COM_NUM());
		$param['SH_COM_CATEGORY']	= $this->getSQLString($this->getSH_COM_CATEGORY());
		$param['SH_COM_ZIP']		= $this->getSQLString($this->getSH_COM_ZIP());
		$param['SH_COM_ADDR']		= $this->getSQLString($this->getSH_COM_ADDR());
		$param['SH_COM_ADDR2']		= $this->getSQLString($this->getSH_COM_ADDR2());
		$param['SH_COM_CITY']		= $this->getSQLString($this->getSH_COM_CITY());
		$param['SH_COM_STATE']		= $this->getSQLString($this->getSH_COM_STATE());
		$param['SH_COM_MAIL']		= $this->getSQLString($this->getSH_COM_MAIL());
		$param['SH_COM_INTRO1']		= $this->getSQLString($this->getSH_COM_INTRO1());
		$param['SH_COM_INTRO2']		= $this->getSQLString($this->getSH_COM_INTRO2());
		$param['SH_COM_LOCAL']		= $this->getSQLString($this->getSH_COM_LOCAL());
		$param['SH_COM_SIZE']		= $this->getSQLString($this->getSH_COM_SIZE());
		$param['SH_COM_CATE']		= $this->getSQLString($this->getSH_COM_CATE());

		$where						= " SH_NO = '".$this->getSH_NO()."' ";
		if(!$where)					{ return; }

		return $db->getUpdateParam("SHOP_INFO_".$this->getP_LNG(), $param, $where);


//		$query = "CALL SP_PRODUCT_INFO_U (?,?,?,?,?,?,?,?,?,?,?);";
//
//		$param[]  = $this->getP_CODE();
//		$param[]  = $this->getP_LNG();
//		$param[]  = $this->getP_NAME();
//		$param[]  = $this->getP_SEARCH_TEXT();
//		$param[]  = $this->getP_ETC();
//		$param[]  = $this->getP_WEB_TEXT();
//		$param[]  = $this->getP_MOB_TEXT();
//		$param[]  = $this->getP_MEMO();
//		$param[]  = $this->getP_DELIVERY_TEXT();
//		$param[]  = $this->getP_RETURN_TEXT();
//		$param[]  = $this->getP_PRICE_TEXT();
//		return $db->executeBindingQuery($query,$param,true);
	}

	/**
	 * 작성일 : 2015.04.21
	 * 작성자 : 
	 * 내  용 : 입정사 미승인 이유등록
	 **/
	function getShopNotOk($db)
	{
		$query  = "UPDATE ".TBL_SHOP_MGR." SET SH_APPR_NO_REASON = '".$this->getSH_APPR_NO_REASON()."' , SH_APPR = 'N' ";
		$query .= "WHERE SH_NO = ".$this->getSH_NO();

		return $db->getExecSql($query);
	}

	/**
	 * 작성일 : 2015.04.21
	 * 작성자 : 
	 * 내  용 : 입정사 승인
	 **/
	function getShopOkCheck($db)
	{
		$query  = "UPDATE ".TBL_SHOP_MGR." SET SH_APPR = 'Y' , SH_ADMISSION_DT = NOW()";
		$query .= "	WHERE SH_NO = ".$this->getSH_NO();
	
		return $db->getExecSql($query);
	}

	/**
	 * getSQLString($str)
	 * SQL 문자형으로 형변환	ex) text => "text"
	 * **/
	function getSQLString($str) {
		$str	= addslashes($str);
		return "\"{$str}\"";
	}

	/**
	 * getSQLString($str)
	 * SQL 정수형으로 형변환	ex) "" => 0
	 * **/
	function getSQLInteger($int) {
		if($int) { return $int; }
		return 0;
	}


	/********************************** Member Mail Check **********************************/
	function getShopMailCheck($db)
	{
		$query = "SELECT COUNT(*) FROM ".TBL_SHOP_MGR." WHERE ";
		$query .= " SH_COM_MAIL='".$this->getSH_COM_MAIL()."'";
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
	/********************************** variable **********************************/
	function setSH_NO($SH_NO){ $this->SH_NO = $SH_NO; }
	function getSH_NO(){ return $this->SH_NO; }

	function setSH_TYPE($SH_TYPE){ $this->SH_TYPE = $SH_TYPE; }
	function getSH_TYPE(){ return $this->SH_TYPE; }

	function setSH_COM_TYPE($SH_COM_TYPE){ $this->SH_COM_TYPE = $SH_COM_TYPE; }
	function getSH_COM_TYPE(){ return $this->SH_COM_TYPE; }

	function setSH_COM_NUM($SH_COM_NUM){ $this->SH_COM_NUM = $SH_COM_NUM; }
	function getSH_COM_NUM(){ return $this->SH_COM_NUM; }

	function setSH_COM_NAME($SH_COM_NAME){ $this->SH_COM_NAME = $SH_COM_NAME; }
	function getSH_COM_NAME(){ return $this->SH_COM_NAME; }

	function setSH_COM_REP_NM($SH_COM_REP_NM){ $this->SH_COM_REP_NM = $SH_COM_REP_NM; }
	function getSH_COM_REP_NM(){ return $this->SH_COM_REP_NM; }

	function setSH_COM_PHONE($SH_COM_PHONE){ $this->SH_COM_PHONE = $SH_COM_PHONE; }
	function getSH_COM_PHONE(){ return $this->SH_COM_PHONE; }

	function setSH_COM_FAX($SH_COM_FAX){ $this->SH_COM_FAX = $SH_COM_FAX; }
	function getSH_COM_FAX(){ return $this->SH_COM_FAX; }

	function setSH_COM_MAIL($SH_COM_MAIL){ $this->SH_COM_MAIL = $SH_COM_MAIL; }
	function getSH_COM_MAIL(){ return $this->SH_COM_MAIL; }

	function setSH_COM_UPTAE($SH_COM_UPTAE){ $this->SH_COM_UPTAE = $SH_COM_UPTAE; }
	function getSH_COM_UPTAE(){ return $this->SH_COM_UPTAE; }

	function setSH_COM_UPJONG($SH_COM_UPJONG){ $this->SH_COM_UPJONG = $SH_COM_UPJONG; }
	function getSH_COM_UPJONG(){ return $this->SH_COM_UPJONG; }

	function setSH_COM_CATEGORY($SH_COM_CATEGORY){ $this->SH_COM_CATEGORY = $SH_COM_CATEGORY; }
	function getSH_COM_CATEGORY(){ return $this->SH_COM_CATEGORY; }

	function setSH_COM_NUM2($SH_COM_NUM2){ $this->SH_COM_NUM2 = $SH_COM_NUM2; }
	function getSH_COM_NUM2(){ return $this->SH_COM_NUM2; }

	function setSH_COM_ZIP($SH_COM_ZIP){ $this->SH_COM_ZIP = $SH_COM_ZIP; }
	function getSH_COM_ZIP(){ return $this->SH_COM_ZIP; }

	function setSH_COM_ADDR($SH_COM_ADDR){ $this->SH_COM_ADDR = $SH_COM_ADDR; }
	function getSH_COM_ADDR(){ return $this->SH_COM_ADDR; }

	function setSH_COM_ADDR2($SH_COM_ADDR2){ $this->SH_COM_ADDR2 = $SH_COM_ADDR2; }
	function getSH_COM_ADDR2(){ return $this->SH_COM_ADDR2; }

	function setSH_COM_COUNTRY($SH_COM_COUNTRY){ $this->SH_COM_COUNTRY = $SH_COM_COUNTRY; }
	function getSH_COM_COUNTRY(){ return $this->SH_COM_COUNTRY; }

	function setSH_COM_FILE1($SH_COM_FILE1){ $this->SH_COM_FILE1 = $SH_COM_FILE1; }
	function getSH_COM_FILE1(){ return $this->SH_COM_FILE1; }

	function setSH_COM_FILE2($SH_COM_FILE2){ $this->SH_COM_FILE2 = $SH_COM_FILE2; }
	function getSH_COM_FILE2(){ return $this->SH_COM_FILE2; }

	function setSH_COM_FILE3($SH_COM_FILE3){ $this->SH_COM_FILE3 = $SH_COM_FILE3; }
	function getSH_COM_FILE3(){ return $this->SH_COM_FILE3; }

	function setSH_COM_FILE4($SH_COM_FILE4){ $this->SH_COM_FILE4 = $SH_COM_FILE4; }
	function getSH_COM_FILE4(){ return $this->SH_COM_FILE4; }

	function setSH_COM_FILE5($SH_COM_FILE5){ $this->SH_COM_FILE5 = $SH_COM_FILE5; }
	function getSH_COM_FILE5(){ return $this->SH_COM_FILE5; }

	function setSH_COM_DEPOSIT($SH_COM_DEPOSIT){ $this->SH_COM_DEPOSIT = $SH_COM_DEPOSIT; }
	function getSH_COM_DEPOSIT(){ return $this->SH_COM_DEPOSIT; }

	function setSH_COM_BANK($SH_COM_BANK){ $this->SH_COM_BANK = $SH_COM_BANK; }
	function getSH_COM_BANK(){ return $this->SH_COM_BANK; }

	function setSH_COM_BANK_NUM($SH_COM_BANK_NUM){ $this->SH_COM_BANK_NUM = $SH_COM_BANK_NUM; }
	function getSH_COM_BANK_NUM(){ return $this->SH_COM_BANK_NUM; }

	function setSH_COM_ACC_PRICE($SH_COM_ACC_PRICE){ $this->SH_COM_ACC_PRICE = $SH_COM_ACC_PRICE; }
	function getSH_COM_ACC_PRICE(){ return $this->SH_COM_ACC_PRICE; }

	function setSH_COM_ACC_RATE($SH_COM_ACC_RATE){ $this->SH_COM_ACC_RATE = $SH_COM_ACC_RATE; }
	function getSH_COM_ACC_RATE(){ return $this->SH_COM_ACC_RATE; }

	function setSH_COM_DELIVERY($SH_COM_DELIVERY){ $this->SH_COM_DELIVERY = $SH_COM_DELIVERY; }
	function getSH_COM_DELIVERY(){ return $this->SH_COM_DELIVERY; }

	function setSH_COM_DELIVERY_ST_PRICE($SH_COM_DELIVERY_ST_PRICE){ $this->SH_COM_DELIVERY_ST_PRICE = $SH_COM_DELIVERY_ST_PRICE; }
	function getSH_COM_DELIVERY_ST_PRICE(){ return $this->SH_COM_DELIVERY_ST_PRICE; }

	function setSH_COM_DELIVERY_PRICE($SH_COM_DELIVERY_PRICE){ $this->SH_COM_DELIVERY_PRICE = $SH_COM_DELIVERY_PRICE; }
	function getSH_COM_DELIVERY_PRICE(){ return $this->SH_COM_DELIVERY_PRICE; }

	function setSH_COM_DELIVERY_COR($SH_COM_DELIVERY_COR){ $this->SH_COM_DELIVERY_COR = $SH_COM_DELIVERY_COR; }
	function getSH_COM_DELIVERY_COR(){ return $this->SH_COM_DELIVERY_COR; }

	function setSH_COM_DELIVERY_FOR_COR($SH_COM_DELIVERY_FOR_COR){ $this->SH_COM_DELIVERY_FOR_COR = $SH_COM_DELIVERY_FOR_COR; }
	function getSH_COM_DELIVERY_FOR_COR(){ return $this->SH_COM_DELIVERY_FOR_COR; }

	function setSH_COM_DELIVERY_FREE($SH_COM_DELIVERY_FREE){ $this->SH_COM_DELIVERY_FREE = $SH_COM_DELIVERY_FREE; }
	function getSH_COM_DELIVERY_FREE(){ return $this->SH_COM_DELIVERY_FREE; }

	function setSH_COM_DEVLIERY_PROD($SH_COM_DEVLIERY_PROD){ $this->SH_COM_DEVLIERY_PROD = $SH_COM_DEVLIERY_PROD; }
	function getSH_COM_DEVLIERY_PROD(){ return $this->SH_COM_DEVLIERY_PROD; }

	function setSH_COM_DELIVERY_AREA($SH_COM_DELIVERY_AREA){ $this->SH_COM_DELIVERY_AREA = $SH_COM_DELIVERY_AREA; }
	function getSH_COM_DELIVERY_AREA(){ return $this->SH_COM_DELIVERY_AREA; }

	function setSH_COM_DELIVERY_TEXT($SH_COM_DELIVERY_TEXT){ $this->SH_COM_DELIVERY_TEXT = $SH_COM_DELIVERY_TEXT; }
	function getSH_COM_DELIVERY_TEXT(){ return $this->SH_COM_DELIVERY_TEXT; }

	function setSH_COM_PROD_AUTH($SH_COM_PROD_AUTH){ $this->SH_COM_PROD_AUTH = $SH_COM_PROD_AUTH; }
	function getSH_COM_PROD_AUTH(){ return $this->SH_COM_PROD_AUTH; }

	function setSH_COM_MAIN($SH_COM_MAIN){ $this->SH_COM_MAIN = $SH_COM_MAIN; }
	function getSH_COM_MAIN(){ return $this->SH_COM_MAIN; }

	function setSH_APPR($SH_APPR){ $this->SH_APPR = $SH_APPR; }
	function getSH_APPR(){ return $this->SH_APPR; }

	function setSH_APPR_NO_REASON($SH_APPR_NO_REASON){ $this->SH_APPR_NO_REASON = $SH_APPR_NO_REASON; }
	function getSH_APPR_NO_REASON(){ return $this->SH_APPR_NO_REASON; }



	/*--------------------------------------------------------------*/

	function setSH_COM_SITE($SH_COM_SITE){ $this->SH_COM_SITE = $SH_COM_SITE; }
	function getSH_COM_SITE(){ return $this->SH_COM_SITE; }

	function setSH_COM_FOUNDED($SH_COM_FOUNDED){ $this->SH_COM_FOUNDED = $SH_COM_FOUNDED; }
	function getSH_COM_FOUNDED(){ return $this->SH_COM_FOUNDED; }

	function setSH_COM_NUMBER($SH_COM_NUMBER){ $this->SH_COM_NUMBER = $SH_COM_NUMBER; }
	function getSH_COM_NUMBER(){ return $this->SH_COM_NUMBER; }

	function setSH_COM_TOTAL_SALE($SH_COM_TOTAL_SALE){ $this->SH_COM_TOTAL_SALE = $SH_COM_TOTAL_SALE; }
	function getSH_COM_TOTAL_SALE(){ return $this->SH_COM_TOTAL_SALE; }

	function setSH_COM_RATE($SH_COM_RATE){ $this->SH_COM_RATE = $SH_COM_RATE; }
	function getSH_COM_RATE(){ return $this->SH_COM_RATE; }

	function setSH_COM_TOTAL_PRODUCTION($SH_COM_TOTAL_PRODUCTION){ $this->SH_COM_TOTAL_PRODUCTION = $SH_COM_TOTAL_PRODUCTION; }
	function getSH_COM_TOTAL_PRODUCTION(){ return $this->SH_COM_TOTAL_PRODUCTION; }

	function setSH_COM_COUNTRY1($SH_COM_COUNTRY1){ $this->SH_COM_COUNTRY1 = $SH_COM_COUNTRY1; }
	function getSH_COM_COUNTRY1(){ return $this->SH_COM_COUNTRY1; }

	function setSH_COM_COUNTRY2($SH_COM_COUNTRY2){ $this->SH_COM_COUNTRY2 = $SH_COM_COUNTRY2; }
	function getSH_COM_COUNTRY2(){ return $this->SH_COM_COUNTRY2; }

	function setSH_COM_COUNTRY3($SH_COM_COUNTRY3){ $this->SH_COM_COUNTRY3 = $SH_COM_COUNTRY3; }
	function getSH_COM_COUNTRY3(){ return $this->SH_COM_COUNTRY3; }

	function setSH_COM_COUNTRY4($SH_COM_COUNTRY4){ $this->SH_COM_COUNTRY4 = $SH_COM_COUNTRY4; }
	function getSH_COM_COUNTRY4(){ return $this->SH_COM_COUNTRY4; }

	function setSH_COM_COUNTRY5($SH_COM_COUNTRY5){ $this->SH_COM_COUNTRY5 = $SH_COM_COUNTRY5; }
	function getSH_COM_COUNTRY5(){ return $this->SH_COM_COUNTRY5; }

	function setSH_COM_COUNTRY6($SH_COM_COUNTRY6){ $this->SH_COM_COUNTRY6 = $SH_COM_COUNTRY6; }
	function getSH_COM_COUNTRY6(){ return $this->SH_COM_COUNTRY6; }

	function setSH_COM_COUNTRY7($SH_COM_COUNTRY7){ $this->SH_COM_COUNTRY7 = $SH_COM_COUNTRY7; }
	function getSH_COM_COUNTRY7(){ return $this->SH_COM_COUNTRY7; }

	function setSH_COM_COUNTRY8($SH_COM_COUNTRY8){ $this->SH_COM_COUNTRY8 = $SH_COM_COUNTRY8; }
	function getSH_COM_COUNTRY8(){ return $this->SH_COM_COUNTRY8; }

	function setSH_COM_COUNTRY9($SH_COM_COUNTRY9){ $this->SH_COM_COUNTRY9 = $SH_COM_COUNTRY9; }
	function getSH_COM_COUNTRY9(){ return $this->SH_COM_COUNTRY9; }

	function setSH_COM_COUNTRY10($SH_COM_COUNTRY10){ $this->SH_COM_COUNTRY10 = $SH_COM_COUNTRY10; }
	function getSH_COM_COUNTRY10(){ return $this->SH_COM_COUNTRY10; }

	function setSH_COM_COUNTRY11($SH_COM_COUNTRY11){ $this->SH_COM_COUNTRY11 = $SH_COM_COUNTRY11; }
	function getSH_COM_COUNTRY11(){ return $this->SH_COM_COUNTRY11; }

	function setSH_COM_COUNTRY12($SH_COM_COUNTRY12){ $this->SH_COM_COUNTRY12 = $SH_COM_COUNTRY12; }
	function getSH_COM_COUNTRY12(){ return $this->SH_COM_COUNTRY12; }

	function setSH_COM_COUNTRY13($SH_COM_COUNTRY13){ $this->SH_COM_COUNTRY13 = $SH_COM_COUNTRY13; }
	function getSH_COM_COUNTRY13(){ return $this->SH_COM_COUNTRY13; }

	function setSH_COM_COUNTRY14($SH_COM_COUNTRY14){ $this->SH_COM_COUNTRY14 = $SH_COM_COUNTRY14; }
	function getSH_COM_COUNTRY14(){ return $this->SH_COM_COUNTRY14; }

	function setSH_COM_LOCAL($SH_COM_LOCAL){ $this->SH_COM_LOCAL = $SH_COM_LOCAL; }
	function getSH_COM_LOCAL(){ return $this->SH_COM_LOCAL; }

	function setSH_COM_SIZE($SH_COM_SIZE){ $this->SH_COM_SIZE = $SH_COM_SIZE; }
	function getSH_COM_SIZE(){ return $this->SH_COM_SIZE; }

	function setSH_COM_RD($SH_COM_RD){ $this->SH_COM_RD = $SH_COM_RD; }
	function getSH_COM_RD(){ return $this->SH_COM_RD; }

	function setSH_COM_CATE($SH_COM_CATE){ $this->SH_COM_CATE = $SH_COM_CATE; }
	function getSH_COM_CATE(){ return $this->SH_COM_CATE; }

	function setSH_COM_CERTIFICATES1($SH_COM_CERTIFICATES1){ $this->SH_COM_CERTIFICATES1 = $SH_COM_CERTIFICATES1; }
	function getSH_COM_CERTIFICATES1(){ return $this->SH_COM_CERTIFICATES1; }

	function setSH_COM_CERTIFICATES2($SH_COM_CERTIFICATES2){ $this->SH_COM_CERTIFICATES2 = $SH_COM_CERTIFICATES2; }
	function getSH_COM_CERTIFICATES2(){ return $this->SH_COM_CERTIFICATES2; }

	function setSH_COM_CERTIFICATES3($SH_COM_CERTIFICATES3){ $this->SH_COM_CERTIFICATES3 = $SH_COM_CERTIFICATES3; }
	function getSH_COM_CERTIFICATES3(){ return $this->SH_COM_CERTIFICATES3; }

	function setSH_COM_CERTIFICATES4($SH_COM_CERTIFICATES4){ $this->SH_COM_CERTIFICATES4 = $SH_COM_CERTIFICATES4; }
	function getSH_COM_CERTIFICATES4(){ return $this->SH_COM_CERTIFICATES4; }

	function setSH_COM_CERTIFICATES5($SH_COM_CERTIFICATES5){ $this->SH_COM_CERTIFICATES5 = $SH_COM_CERTIFICATES5; }
	function getSH_COM_CERTIFICATES5(){ return $this->SH_COM_CERTIFICATES5; }

	function setSH_COM_CERTIFICATES1_FILE($SH_COM_CERTIFICATES1_FILE){ $this->SH_COM_CERTIFICATES1_FILE = $SH_COM_CERTIFICATES1_FILE; }
	function getSH_COM_CERTIFICATES1_FILE(){ return $this->SH_COM_CERTIFICATES1_FILE; }

	function setSH_COM_CERTIFICATES2_FILE($SH_COM_CERTIFICATES2_FILE){ $this->SH_COM_CERTIFICATES2_FILE = $SH_COM_CERTIFICATES2_FILE; }
	function getSH_COM_CERTIFICATES2_FILE(){ return $this->SH_COM_CERTIFICATES2_FILE; }

	function setSH_COM_CERTIFICATES3_FILE($SH_COM_CERTIFICATES3_FILE){ $this->SH_COM_CERTIFICATES3_FILE = $SH_COM_CERTIFICATES3_FILE; }
	function getSH_COM_CERTIFICATES3_FILE(){ return $this->SH_COM_CERTIFICATES3_FILE; }

	function setSH_COM_CERTIFICATES4_FILE($SH_COM_CERTIFICATES4_FILE){ $this->SH_COM_CERTIFICATES4_FILE = $SH_COM_CERTIFICATES4_FILE; }
	function getSH_COM_CERTIFICATES4_FILE(){ return $this->SH_COM_CERTIFICATES4_FILE; }

	function setSH_COM_CERTIFICATES5_FILE($SH_COM_CERTIFICATES5_FILE){ $this->SH_COM_CERTIFICATES5_FILE = $SH_COM_CERTIFICATES5_FILE; }
	function getSH_COM_CERTIFICATES5_FILE(){ return $this->SH_COM_CERTIFICATES5_FILE; }

	function setSH_COM_INTRO1($SH_COM_INTRO1){ $this->SH_COM_INTRO1 = $SH_COM_INTRO1; }
	function getSH_COM_INTRO1(){ return $this->SH_COM_INTRO1; }

	function setSH_COM_INTRO2($SH_COM_INTRO2){ $this->SH_COM_INTRO2 = $SH_COM_INTRO2; }
	function getSH_COM_INTRO2(){ return $this->SH_COM_INTRO2; }

	function setSH_COM_CREDIT_GRADE($SH_COM_CREDIT_GRADE){ $this->SH_COM_CREDIT_GRADE = $SH_COM_CREDIT_GRADE; }
	function getSH_COM_CREDIT_GRADE(){ return $this->SH_COM_CREDIT_GRADE; }

	function setSH_COM_SALE_GRADE($SH_COM_SALE_GRADE){ $this->SH_COM_SALE_GRADE = $SH_COM_SALE_GRADE; }
	function getSH_COM_SALE_GRADE(){ return $this->SH_COM_SALE_GRADE; }

	function setSH_COM_LOCUS_GRADE($SH_COM_LOCUS_GRADE){ $this->SH_COM_LOCUS_GRADE = $SH_COM_LOCUS_GRADE; }
	function getSH_COM_LOCUS_GRADE(){ return $this->SH_COM_LOCUS_GRADE; }

	function setSH_REQUEST_DT($SH_REQUEST_DT){ $this->SH_REQUEST_DT = $SH_REQUEST_DT; }
	function getSH_REQUEST_DT(){ return $this->SH_REQUEST_DT; }

	function setSH_ADMISSION_DT($SH_ADMISSION_DT){ $this->SH_ADMISSION_DT = $SH_ADMISSION_DT; }
	function getSH_ADMISSION_DT(){ return $this->SH_ADMISSION_DT; }


	function setSH_COM_CITY($SH_COM_CITY){ $this->SH_COM_CITY = $SH_COM_CITY; }
	function getSH_COM_CITY(){ return $this->SH_COM_CITY; }

	function setSH_COM_STATE($SH_COM_STATE){ $this->SH_COM_STATE = $SH_COM_STATE; }
	function getSH_COM_STATE(){ return $this->SH_COM_STATE; }

	/*---------------------------------등급------------------------------------------------*/

	function setSH_INFO_CHECK($SH_INFO_CHECK){ $this->SH_INFO_CHECK = $SH_INFO_CHECK; }
	function getSH_INFO_CHECK(){ return $this->SH_INFO_CHECK; }

	function setSH_INFO_POINT($SH_INFO_POINT){ $this->SH_INFO_POINT = $SH_INFO_POINT; }
	function getSH_INFO_POINT(){ return $this->SH_INFO_POINT; }

	function setSH_PROD_CNT($SH_PROD_CNT){ $this->SH_PROD_CNT = $SH_PROD_CNT; }
	function getSH_PROD_CNT(){ return $this->SH_PROD_CNT; }

	function setSH_PROD_POINT($SH_PROD_POINT){ $this->SH_PROD_POINT = $SH_PROD_POINT; }
	function getSH_PROD_POINT(){ return $this->SH_PROD_POINT; }

	function setSH_WORK_CHECK($SH_WORK_CHECK){ $this->SH_WORK_CHECK = $SH_WORK_CHECK; }
	function getSH_WORK_CHECK(){ return $this->SH_WORK_CHECK; }

	function setSH_WORK_POINT($SH_WORK_POINT){ $this->SH_WORK_POINT = $SH_WORK_POINT; }
	function getSH_WORK_POINT(){ return $this->SH_WORK_POINT; }

	function setSH_CERTI_CHECK($SH_CERTI_CHECK){ $this->SH_CERTI_CHECK = $SH_CERTI_CHECK; }
	function getSH_CERTI_CHECK(){ return $this->SH_CERTI_CHECK; }

	function setSH_CERTI_POINT($SH_CERTI_POINT){ $this->SH_CERTI_POINT = $SH_CERTI_POINT; }
	function getSH_CERTI_POINT(){ return $this->SH_CERTI_POINT; }

	function setSH_GRADE_UNTRUTH($SH_GRADE_UNTRUTH){ $this->SH_GRADE_UNTRUTH = $SH_GRADE_UNTRUTH; }
	function getSH_GRADE_UNTRUTH(){ return $this->SH_GRADE_UNTRUTH; }

	function setSH_GRADE_UNTRUTH_POINT($SH_GRADE_UNTRUTH_POINT){ $this->SH_GRADE_UNTRUTH_POINT = $SH_GRADE_UNTRUTH_POINT; }
	function getSH_GRADE_UNTRUTH_POINT(){ return $this->SH_GRADE_UNTRUTH_POINT; }

	function setSH_PROD_POINT2($SH_PROD_POINT2){ $this->SH_PROD_POINT2 = $SH_PROD_POINT2; }
	function getSH_PROD_POINT2(){ return $this->SH_PROD_POINT2; }

	function setSH_ORDER_CHECK($SH_ORDER_CHECK){ $this->SH_ORDER_CHECK = $SH_ORDER_CHECK; }
	function getSH_ORDER_CHECK(){ return $this->SH_ORDER_CHECK; }

	function setSH_ORDER_POINT($SH_ORDER_POINT){ $this->SH_ORDER_POINT = $SH_ORDER_POINT; }
	function getSH_ORDER_POINT(){ return $this->SH_ORDER_POINT; }

	function setSH_GRADE_CHECK($SH_GRADE_CHECK){ $this->SH_GRADE_CHECK = $SH_GRADE_CHECK; }
	function getSH_GRADE_CHECK(){ return $this->SH_GRADE_CHECK; }

	function setSH_GRADE_POINT($SH_GRADE_POINT){ $this->SH_GRADE_POINT = $SH_GRADE_POINT; }
	function getSH_GRADE_POINT(){ return $this->SH_GRADE_POINT; }

	function setSH_RATING_CHECK($SH_RATING_CHECK){ $this->SH_RATING_CHECK = $SH_RATING_CHECK; }
	function getSH_RATING_CHECK(){ return $this->SH_RATING_CHECK; }

	function setSH_RATING_POINT($SH_RATING_POINT){ $this->SH_RATING_POINT = $SH_RATING_POINT; }
	function getSH_RATING_POINT(){ return $this->SH_RATING_POINT; }

	function setSH_PROD_UNTRUTH($SH_PROD_UNTRUTH){ $this->SH_PROD_UNTRUTH = $SH_PROD_UNTRUTH; }
	function getSH_PROD_UNTRUTH(){ return $this->SH_PROD_UNTRUTH; }

	function setSH_PROD_UNTRUTH_POINT($SH_PROD_UNTRUTH_POINT){ $this->SH_PROD_UNTRUTH_POINT = $SH_PROD_UNTRUTH_POINT; }
	function getSH_PROD_UNTRUTH_POINT(){ return $this->SH_PROD_UNTRUTH_POINT; }

	/*--------------------------------------------------------------*/

	function setSH_FILE_NO($SH_FILE_NO){ $this->SH_FILE_NO = $SH_FILE_NO; }
	function getSH_FILE_NO(){ return $this->SH_FILE_NO; }

	function setSH_REG_DT($SH_REG_DT){ $this->SH_REG_DT = $SH_REG_DT; }
	function getSH_REG_DT(){ return $this->SH_REG_DT; }

	function setSH_REG_NO($SH_REG_NO){ $this->SH_REG_NO = $SH_REG_NO; }
	function getSH_REG_NO(){ return $this->SH_REG_NO; }

	function setSH_MOD_DT($SH_MOD_DT){ $this->SH_MOD_DT = $SH_MOD_DT; }
	function getSH_MOD_DT(){ return $this->SH_MOD_DT; }

	function setSH_MOD_NO($SH_MOD_NO){ $this->SH_MOD_NO = $SH_MOD_NO; }
	function getSH_MOD_NO(){ return $this->SH_MOD_NO; }

	/*--------------------------------------------------------------*/
	function setLimitFirst($LIMIT_FIRST){ $this->LIMIT_FIRST = $LIMIT_FIRST; }
	function getLimitFirst(){ return $this->LIMIT_FIRST; }

	function setPageLine($PAGE_LINE){ $this->PAGE_LINE = $PAGE_LINE; }
	function getPageLine(){ return $this->PAGE_LINE; }

	function setSearchField($SEARCH_FIELD){ $this->SEARCH_FIELD = $SEARCH_FIELD; }
	function getSearchField(){ return $this->SEARCH_FIELD; }

	function setSearchKey($SEARCH_KEY){ $this->SEARCH_KEY = $SEARCH_KEY; }
	function getSearchKey(){ return $this->SEARCH_KEY; }

	function setSearchMemberType($SEARCH_MEMBER_TYPE){ $this->SEARCH_MEMBER_TYPE = $SEARCH_MEMBER_TYPE; }							// 회원구분
	function getSearchMemberType(){ return $this->SEARCH_MEMBER_TYPE; }

	function setSearchRegStartDt($SEARCH_REG_START_DT){ $this->SEARCH_REG_START_DT = $SEARCH_REG_START_DT; }
	function getSearchRegStartDt(){ return $this->SEARCH_REG_START_DT; }

	function setSearchRegEndDt($SEARCH_REG_END_DT){ $this->SEARCH_REG_END_DT = $SEARCH_REG_END_DT; }
	function getSearchRegEndDt(){ return $this->SEARCH_REG_END_DT; }

	function setSearchComAuth($SEARCH_COM_AUTH){ $this->SEARCH_COM_AUTH = $SEARCH_COM_AUTH; }
	function getSearchComAuth(){ return $this->SEARCH_COM_AUTH; }

	function setSearchOrderStatus($SEARCH_ORDER_STATUS){ $this->SEARCH_ORDER_STATUS = $SEARCH_ORDER_STATUS; }
	function getSearchOrderStatus(){ return $this->SEARCH_ORDER_STATUS; }

	function setSearchSettleStatus($SEARCH_SETTLE_STATUS){ $this->SEARCH_SETTLE_STATUS = $SEARCH_SETTLE_STATUS; }
	function getSearchSettleStatus(){ return $this->SEARCH_SETTLE_STATUS; }

	function setSearchDeliveryStatus($SEARCH_DELIVERY_STATUS){ $this->SEARCH_DELIVERY_STATUS = $SEARCH_DELIVERY_STATUS; }
	function getSearchDeliveryStatus(){ return $this->SEARCH_DELIVERY_STATUS; }

	/*--------------------------------------------------------------*/

	function setST_NAME($ST_NAME){ $this->ST_NAME = $ST_NAME; }
	function getST_NAME(){ return $this->ST_NAME; }

	function setST_NAME_ENG($ST_NAME_ENG){ $this->ST_NAME_ENG = $ST_NAME_ENG; }
	function getST_NAME_ENG(){ return $this->ST_NAME_ENG; }

	function setST_TEXT($ST_TEXT){ $this->ST_TEXT = $ST_TEXT; }
	function getST_TEXT(){ return $this->ST_TEXT; }

	function setST_MEMO($ST_MEMO){ $this->ST_MEMO = $ST_MEMO; }
	function getST_MEMO(){ return $this->ST_MEMO; }

	function setST_LOGO($ST_LOGO){ $this->ST_LOGO = $ST_LOGO; }
	function getST_LOGO(){ return $this->ST_LOGO; }

	function setST_IMG($ST_IMG){ $this->ST_IMG = $ST_IMG; }
	function getST_IMG(){ return $this->ST_IMG; }

	function setST_THUMB_IMG($ST_THUMB_IMG){ $this->ST_THUMB_IMG = $ST_THUMB_IMG; }
	function getST_THUMB_IMG(){ return $this->ST_THUMB_IMG; }

	/*--------------------------------------------------------------*/
	function setSU_NO($SU_NO){ $this->SU_NO = $SU_NO; }
	function getSU_NO(){ return $this->SU_NO; }

	function setM_NO($M_NO){ $this->M_NO = $M_NO; }
	function getM_NO(){ return $this->M_NO; }

	function setSU_TYPE($SU_TYPE){ $this->SU_TYPE = $SU_TYPE; }
	function getSU_TYPE(){ return $this->SU_TYPE; }

	function setSU_MEMO($SU_MEMO){ $this->SU_MEMO = $SU_MEMO; }
	function getSU_MEMO(){ return $this->SU_MEMO; }

	function setSU_USE($SU_USE){ $this->SU_USE = $SU_USE; }
	function getSU_USE(){ return $this->SU_USE; }

	function setSU_REG_DT($SU_REG_DT){ $this->SU_REG_DT = $SU_REG_DT; }
	function getSU_REG_DT(){ return $this->SU_REG_DT; }

	/*--------------------------------------------------------------*/
	function setSO_NO($SO_NO){ $this->SO_NO = $SO_NO; }
	function getSO_NO(){ return $this->SO_NO; }

	function setO_NO($O_NO){ $this->O_NO = $O_NO; }
	function getO_NO(){ return $this->O_NO; }

	function setSO_TOT_SPRICE($SO_TOT_SPRICE){ $this->SO_TOT_SPRICE = $SO_TOT_SPRICE; }
	function getSO_TOT_SPRICE(){ return $this->SO_TOT_SPRICE; }

	function setSO_TOT_CUR_SPRICE($SO_TOT_CUR_SPRICE){ $this->SO_TOT_CUR_SPRICE = $SO_TOT_CUR_SPRICE; }
	function getSO_TOT_CUR_SPRICE(){ return $this->SO_TOT_CUR_SPRICE; }

	function setSO_TOT_APRICE($SO_TOT_APRICE){ $this->SO_TOT_APRICE = $SO_TOT_APRICE; }
	function getSO_TOT_APRICE(){ return $this->SO_TOT_APRICE; }

	function setSO_TOT_CUR_APRICE($SO_TOT_CUR_APRICE){ $this->SO_TOT_CUR_APRICE = $SO_TOT_CUR_APRICE; }
	function getSO_TOT_CUR_APRICE(){ return $this->SO_TOT_CUR_APRICE; }

	function setSO_TOT_DELIVERY_PRICE($SO_TOT_DELIVERY_PRICE){ $this->SO_TOT_DELIVERY_PRICE = $SO_TOT_DELIVERY_PRICE; }
	function getSO_TOT_DELIVERY_PRICE(){ return $this->SO_TOT_DELIVERY_PRICE; }

	function setSO_TOT_CUR_DELIVERY_PRICE($SO_TOT_CUR_DELIVERY_PRICE){ $this->SO_TOT_CUR_DELIVERY_PRICE = $SO_TOT_CUR_DELIVERY_PRICE; }
	function getSO_TOT_CUR_DELIVERY_PRICE(){ return $this->SO_TOT_CUR_DELIVERY_PRICE; }

	function setSO_DELIVERY_COM($SO_DELIVERY_COM){ $this->SO_DELIVERY_COM = $SO_DELIVERY_COM; }
	function getSO_DELIVERY_COM(){ return $this->SO_DELIVERY_COM; }

	function setSO_DELIVERY_NUM($SO_DELIVERY_NUM){ $this->SO_DELIVERY_NUM = $SO_DELIVERY_NUM; }
	function getSO_DELIVERY_NUM(){ return $this->SO_DELIVERY_NUM; }

	function setSO_DELIVERY_STATUS($SO_DELIVERY_STATUS){ $this->SO_DELIVERY_STATUS = $SO_DELIVERY_STATUS; }
	function getSO_DELIVERY_STATUS(){ return $this->SO_DELIVERY_STATUS; }

	function setSO_ORDER_STATUS($SO_ORDER_STATUS){ $this->SO_ORDER_STATUS = $SO_ORDER_STATUS; }
	function getSO_ORDER_STATUS(){ return $this->SO_ORDER_STATUS; }

	function setSO_ACC_STATUS($SO_ACC_STATUS){ $this->SO_ACC_STATUS = $SO_ACC_STATUS; }
	function getSO_ACC_STATUS(){ return $this->SO_ACC_STATUS; }

	function setP_LNG($P_LNG){ $this->P_LNG = $P_LNG; }
	function getP_LNG(){ return $this->P_LNG; }

	function setOC_NO($OC_NO){ $this->OC_NO = $OC_NO; }
	function getOC_NO(){ return $this->OC_NO; }

	function setO_STATUS($O_STATUS){ $this->O_STATUS = $O_STATUS; }
	function getO_STATUS(){ return $this->O_STATUS; }


	/********************************** variable **********************************/


}
?>