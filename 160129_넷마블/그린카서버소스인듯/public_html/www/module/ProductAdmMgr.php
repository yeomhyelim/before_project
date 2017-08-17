<?
#/*====================================================================*/#
#|작성자	: 박영미(ivetmi@naver.com)									|#
#|작성일	: 2012-05-29												|#
#|작성내용	: 상품등록/수정/삭제										|#
#/*====================================================================*/#
class ProductAdmMgr
{
	private $query;
	private $param;

	/********************************** Product Code **********************************/
	function getProductCode($db)
	{
		$query  =    "SELECT                                                                                    ";
		$query .= "      CONCAT(DATE_FORMAT(NOW(),'%Y%m%d'),LPAD(IFNULL(MAX(SUBSTRING(A.P_CODE,9))+1,1),5,0))	";
		$query .= "FROM ".TBL_PRODUCT_MGR." A                                                                   ";
		$query .= "WHERE SUBSTRING(A.P_CODE,1,8) = DATE_FORMAT(NOW(),'%Y%m%d');									";

		return $db->getCount($query);
	}

	/********************************** Product List **********************************/
	function getProdTotal($db)
	{
		global $S_MALL_TYPE;

		$query  = "SELECT									";
		$query .= "     COUNT(*)							";
		$query .= "FROM (									";
		$query .= $this->getSearchQry("prodListTable");
		$query .= ") A										";

		$query .= "LEFT OUTER JOIN ".TBL_PRODUCT_IMG." B    ";
		$query .= "ON A.P_CODE = B.P_CODE					";
		$query .= "AND B.PM_TYPE = 'list'					";
		$query .= "WHERE A.P_CODE IS NOT NULL				";

		//echo $query;exit;
		return $db->getCount($query);
	}

	function getSearchQry($mode)
	{
		global $S_MALL_TYPE;

		$query = "";
		switch ($mode){
			case "prodListTable":

				$query .= "SELECT                                       ";
				$query .= "     A.P_CODE                                ";
				$query .= "    ,AI.P_NAME                               ";
				$query .= "    ,B.P_NUM									";
				$query .= "    ,B.P_CATE                                ";
				$query .= "    ,B.P_LAUNCH_DT                           ";
				$query .= "    ,B.P_REP_DT                              ";
				$query .= "    ,B.P_CONSUMER_PRICE                      ";
				$query .= "    ,B.P_SALE_PRICE                          ";
				$query .= "    ,B.P_PRICE_FILTER                        ";
				$query .= "    ,B.P_PRICE_UNIT                          ";
				$query .= "    ,B.P_CAS_NO                              ";
				$query .= "    ,B.P_OTHER_NAMES                         ";
				$query .= "    ,B.P_MIN_QTY                             ";
				$query .= "    ,B.P_QTY                                 ";
				$query .= "    ,B.P_WEB_VIEW                            ";
				$query .= "    ,B.P_MOB_VIEW                            ";
				$query .= "    ,B.P_APPR						        ";
				$query .= "    ,B.P_POINT                               ";
				$query .= "    ,B.P_EVENT_UNIT                          ";
				$query .= "    ,B.P_EVENT                               ";
				$query .= "    ,B.P_LIST_ICON                           ";
				$query .= "    ,B.P_ICON                                ";
				$query .= "    ,B.P_BRAND                               ";
				$query .= "    ,B.P_MAKER                               ";
				$query .= "    ,B.P_ORIGIN                              ";
				$query .= "    ,B.P_MODEL                               ";
				$query .= "    ,B.P_COLOR                               ";
				$query .= "    ,B.P_SIZE                                ";
				$query .= "    ,B.P_REG_DT                              ";
				$query .= "    ,B.P_ORDER                               ";
				$query .= "    ,SUBSTRING(B.P_ICON,1,1) ICON1			";
				$query .= "    ,SUBSTRING(B.P_ICON,3,1) ICON2			";
				$query .= "    ,SUBSTRING(B.P_ICON,5,1) ICON3			";
				$query .= "    ,SUBSTRING(B.P_ICON,7,1) ICON4			";
				$query .= "    ,SUBSTRING(B.P_ICON,9,1) ICON5			";
				$query .= "    ,SUBSTRING(B.P_ICON,11,1) ICON6			";
				$query .= "    ,SUBSTRING(B.P_ICON,13,1) ICON7			";
				$query .= "    ,SUBSTRING(B.P_ICON,15,1) ICON8			";
				$query .= "    ,SUBSTRING(B.P_ICON,17,1) ICON9			";
				$query .= "    ,SUBSTRING(B.P_ICON,19,1) ICON10			";
				$query .= "    ,B.P_SHOP_NO								";

				if($S_MALL_TYPE == "M"):
					$query .= ",E.ST_NAME								";
				endif;

				$query .= "FROM                                         ";
				$query .= "(                                            ";
				$query .= "    SELECT                                   ";
				$query .= "         A.P_CODE                            ";
				$query .= "        ,MAX(A.P_CATE) P_CATE                ";
				$query .= "    FROM                                     ";
				$query .= "    (                                        ";
				$query .= "        SELECT                               ";
				$query .= "             A.P_CODE                        ";
				$query .= "            ,A.P_CATE                        ";
				$query .= "        FROM ".TBL_PRODUCT_MGR." A           ";
				$query .= "        WHERE A.P_CODE IS NOT NULL			";

				if ($this->getSearchHCode1() || $this->getSearchHCode2() || $this->getSearchHCode3() || $this->getSearchHCode4()){
					$query .= "	       AND A.P_CATE LIKE '".$this->getSearchHCode1().$this->getSearchHCode2().$this->getSearchHCode3().$this->getSearchHCode4()."%'	";
				}

				$query .= "                                              ";
				$query .= "        UNION                                 ";
				$query .= "                                              ";
				$query .= "        SELECT                                ";
				$query .= "             A.P_CODE                         ";
				$query .= "            ,A.PS_P_CATE P_CATE               ";
				$query .= "        FROM ".TBL_PRODUCT_SHARE." A          ";
				$query .= "        WHERE A.P_CODE IS NOT NULL			 ";

				if ($this->getSearchHCode1() || $this->getSearchHCode2() || $this->getSearchHCode3() || $this->getSearchHCode4()){
					$query .= "	       AND A.PS_P_CATE LIKE '".$this->getSearchHCode1().$this->getSearchHCode2().$this->getSearchHCode3().$this->getSearchHCode4()."%'	";
				}

				$query .= "    ) A                                                     ";
				$query .= "    GROUP BY A.P_CODE                                       ";
				$query .= ") A                                                         ";
				$query .= "JOIN ".TBL_PRODUCT_MGR." B                                  ";
				$query .= "ON A.P_CODE = B.P_CODE                                      ";
				$query .= "JOIN ".TBL_PRODUCT_INFO_LNG.$this->getP_LNG()." AI          ";
				$query .= "ON A.P_CODE = AI.P_CODE                                     ";

				if($S_MALL_TYPE == "M"):
					$query .= "LEFT OUTER JOIN ".TBL_SHOP_SITE." AS E	";		// 2013.06.19 kim hee sung 입점몰 관련 부분 추가
					$query .= "ON E.SH_NO = B.P_SHOP_NO					";		// 2013.06.19 kim hee sung 입점몰 관련 부분 추가
				endif;
				$query .= "WHERE A.P_CODE IS NOT NULL                                  ";

				if ($this->getSearchField() && $this->getSearchKey()){
					$query .= "	AND ";
					switch ($this->getSearchField()){
						case "N":
							$query .= "	AI.P_NAME LIKE '%".$this->getSearchKey()."%'		";
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
						case "P":
							$query .= "	A.P_CODE LIKE '%".$this->getSearchKey()."%'		";
						break;

					}
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

				if ($this->getSearchWebView() == "Y"){
					$query .= " AND B.P_WEB_VIEW = 'Y'		";
				}

				if ($this->getSearchMobileView() == "Y"){
					$query .= " AND B.P_MOB_VIEW = 'Y'		";
				}

				if ($this->getSearchIcon1() || $this->getSearchIcon2() || $this->getSearchIcon3() || $this->getSearchIcon4() || $this->getSearchIcon5() || $this->getSearchIcon6() || $this->getSearchIcon7() || $this->getSearchIcon8() || $this->getSearchIcon9() || $this->getSearchIcon10()){

					$query .= " AND (";
					$strSearchIconCnt = 0;
					if ($this->getSearchIcon1()){
						$strSearchIconCnt++;
						$query .= "	SUBSTRING(B.P_ICON,1,1) = 'Y'	";
					}

					if ($this->getSearchIcon2()){
						if ($strSearchIconCnt > 0 ) $query .= " OR ";
						$query .= "	SUBSTRING(B.P_ICON,3,1) = 'Y'	";
						$strSearchIconCnt++;
					}

					if ($this->getSearchIcon3()){
						if ($strSearchIconCnt > 0 ) $query .= " OR ";
						$query .= "	SUBSTRING(B.P_ICON,5,1) = 'Y'	";
						$strSearchIconCnt++;
					}

					if ($this->getSearchIcon4()){
						if ($strSearchIconCnt > 0 ) $query .= " OR ";
						$query .= "	SUBSTRING(B.P_ICON,7,1) = 'Y'	";
						$strSearchIconCnt++;
					}

					if ($this->getSearchIcon5()){
						if ($strSearchIconCnt > 0 ) $query .= " OR ";
						$query .= "	SUBSTRING(B.P_ICON,9,1) = 'Y'	";
						$strSearchIconCnt++;
					}

					if ($this->getSearchIcon6() == "Y"){
						if ($strSearchIconCnt > 0 ) $query .= " OR ";
						$query .= "	SUBSTRING(B.P_ICON,11,1) = 'Y'	";
						$strSearchIconCnt++;
					}

					if ($this->getSearchIcon7() == "Y"){
						if ($strSearchIconCnt > 0 ) $query .= " OR ";
						$query .= "	SUBSTRING(B.P_ICON,13,1) = 'Y'	";
						$strSearchIconCnt++;
					}

					if ($this->getSearchIcon8() == "Y"){
						if ($strSearchIconCnt > 0 ) $query .= " OR ";
						$query .= "	SUBSTRING(B.P_ICON,15,1) = 'Y'	";
						$strSearchIconCnt++;
					}

					if ($this->getSearchIcon9() == "Y"){
						if ($strSearchIconCnt > 0 ) $query .= " OR ";
						$query .= "	SUBSTRING(B.P_ICON,17,1) = 'Y'	";
						$strSearchIconCnt++;
					}

					if ($this->getSearchIcon10() == "Y"){
						if ($strSearchIconCnt > 0 ) $query .= " OR ";
						$query .= "	SUBSTRING(B.P_ICON,19,1) = 'Y'	";
						$strSearchIconCnt++;
					}

					$query .= " ) ";
				}

				/* 소비자가 없는 경우는 화면에 안보임 처리
				if ($this->getSearchPriceView() == "Y"){
					$query .= " AND A.P_CONSUMER_PRICE > 0 ";
				}*/

				if ($this->getSearchStock1() == "Y"){
					$query .= " AND B.P_STOCK_OUT = 'Y'	";
				}

				if ($this->getSearchStock2() == "Y"){
					$query .= " AND B.P_RESTOCK = 'Y'	";
				}

				if ($this->getSearchStock3() == "Y"){
					$query .= " AND B.P_STOCK_LIMIT = 'Y'	";
				}

				if ($this->getSearchEvent() > 0)
				{
					$query .= " AND B.P_EVENT = ".$this->getSearchEvent()."	";
				}

				if($S_MALL_TYPE == "M"): // 쇼핑몰 타입이 입점몰일때 사용
					if ($this->getSearchShopNo() > 0 && $this->getSearchShopNo() != "0"){
						$query .= " AND B.P_SHOP_NO IN ( ".$this->getSearchShopNo().") ";
					}
				endif;

				if($this->getSearchProdBrand()):
					$query .= " AND B.P_BRAND = '".$this->getSearchProdBrand()."'	";
				endif;

			break;
		}

		return $query;
	}

	function getProdListEx($db, $op, $param)
	{
		$column['OP_LIST']		= "  P.*		";
		$column['OP_SELECT']	= "*";
  		$column['OP_COUNT']		= "COUNT(*)";

		## query(4) 영역

		## where5
		$where5			= "WHERE P5.P_CODE IS NOT NULL";

		## from5
		$from5			= TBL_PRODUCT_SHARE;
		$from5			= "FROM {$from5} AS P5";

		## select5
		$select5		= "SELECT P5.P_CODE, P5.PS_P_CATE AS P_CATE";

		## where4
		$where4			= "WHERE P4.P_CODE IS NOT NULL";

		## from4
		$from4			= TBL_PRODUCT_MGR;
		$from4			= "FROM {$from4} AS P4";

		## select4
		$select4		= "SELECT P4.P_CODE, P4.P_CATE";

		## query4
		$query4			= "{$select4} {$from4} {$where4} UNION {$select5} {$from5} {$where5}";

		## query(3) 영역

		## groupby3
		$groupby3		= "GROUP BY P3.P_CODE";

		## from3
		$from3			= "FROM ({$query4}) AS P3";

		## select3
		$select3		= "SELECT P3.P_CODE, MAX(P3.P_CATE) AS P_CATE";

		## where3
		## 카테고리
		$where3			= "	WHERE P3.P_CODE IS NOT NULL			";
		if($param['P_CATE_LIKE']):
//			$param['P_CATE']	= str_pad($param['P_CATE'], 12, "0");
			$where3				= "{$where3} AND P3.P_CATE LIKE '{$param['P_CATE_LIKE']}%'";
		endif;

		## query3
		$query3			= "{$select3} {$from3} {$where3} {$groupby3}";

		## query(2) 영역

		## where2
		$where2			= "WHERE P2.P_CODE IS NOT NULL";

		## where 조건 만들기
		{
			## 검색어
			if($param['searchKey']):
				$arySearchField['name']			= "PM2_2.P_NAME LIKE ('%{$param['searchKey']}%')"; // 상품명
				$arySearchField['code']			= "(P2_1.P_CODE LIKE ('%{$param['searchKey']}%') OR P2_1.P_NUM LIKE ('%{$param['searchKey']}%'))";// 상품코드
				$arySearchField['maker']		= "P2_1.P_MAKER LIKE ('%{$param['searchKey']}%')"; // 제조사
				$arySearchField['orgin']		= "P2_1.P_ORIGIN LIKE ('%{$param['searchKey']}%')"; // 원산지
				$arySearchField['brand']		= "P2_1.P_MODEL LIKE ('%{$param['searchKey']}%')"; // 모델명
				$arySearchField['search']		= "P2_1.P_SEARCH_TEXT LIKE ('%{$param['searchKey']}%')"; // 검색어
				$arySearchField['memo']			= "P2_1.P_MEMO LIKE ('%{$param['searchKey']}%')"; // 메모

				$strSearchQuery					= "";
				foreach($arySearchField as $key => $val):
					if($strSearchQuery) { $strSearchQuery .= " OR "; }
					$strSearchQuery				.= $val;
				endforeach;
				if($arySearchField[$param['searchField']]) { $strSearchQuery = $arySearchField[$param['searchField']]; }

				$where2		= "{$where2} AND ({$strSearchQuery})";
			endif;

			## 카테고리
//			if($param['P_CATE_LIKE']):
//	//			$param['P_CATE']	= str_pad($param['P_CATE'], 12, "0");
//	//			$where2				= "{$where2} AND P2.P_CATE LIKE '{$param['P_CATE_LIKE']}%'";
//			endif;

			## 상품출시일
			if($param['P_LAUNCH_DT_BETWEEN'][0] && $param['P_LAUNCH_DT_BETWEEN'][1]):
				$param['P_LAUNCH_DT_BETWEEN'][0]		= mysql_real_escape_string($param['P_LAUNCH_DT_BETWEEN'][0]);
				$param['P_LAUNCH_DT_BETWEEN'][1]		= mysql_real_escape_string($param['P_LAUNCH_DT_BETWEEN'][1]);
				$where2		= "{$where2} AND P2_1.P_LAUNCH_DT BETWEEN DATE_FORMAT('{$param['P_LAUNCH_DT_BETWEEN'][0]}','%Y-%m-%d 00:00:00') AND DATE_FORMAT('{$param['P_LAUNCH_DT_BETWEEN'][1]}','%Y-%m-%d 23:59:59')";
			endif;

			## 상품등록일
			if($param['P_REP_DT_BETWEEN'][0] && $param['P_REP_DT_BETWEEN'][1]):
				$param['P_REP_DT_BETWEEN'][0]		= mysql_real_escape_string($param['P_REP_DT_BETWEEN'][0]);
				$param['P_REP_DT_BETWEEN'][1]		= mysql_real_escape_string($param['P_REP_DT_BETWEEN'][1]);
				$where2		= "{$where2} AND P2_1.P_REP_DT BETWEEN DATE_FORMAT('{$param['P_REP_DT_BETWEEN'][0]}','%Y-%m-%d 00:00:00') AND DATE_FORMAT('{$param['P_REP_DT_BETWEEN'][1]}','%Y-%m-%d 23:59:59')";
			endif;

			## 브랜드
			if($param['P_BRAND']):
				$where2		= "{$where2} AND P2_1.P_BRAND = '{$param['P_BRAND']}'";
			endif;

			## 상품출력(웹)
			if($param['P_WEB_VIEW']):
				$web_view_where = "P2_1.P_WEB_VIEW = '{$param['P_WEB_VIEW']}'";
				if ($param['prodManyLangViewUse'] == "Y"){
					$web_view_where = "PM2_2.P_WEB_VIEW = '{$param['P_WEB_VIEW']}'";
				}

				$where2		= "{$where2} AND {$web_view_where}";
			endif;

			## 상품출력(모바일)
			if($param['P_MOB_VIEW']):
				$mob_view_where = "P2_1.P_MOB_VIEW = '{$param['P_MOB_VIEW']}'";
				if ($param['prodManyLangViewUse'] == "Y"){
					$mob_view_where = "PM2_2.P_MOB_VIEW = '{$param['P_MOB_VIEW']}'";
				}

				$where2		= "{$where2} AND {$mob_view_where}";
			endif;

			## 메인, 서브진열관리
			if($param['P_ICON']):
				$aryIconSubStringStartPoint = array(1 => 1, 2 => 3, 3 => 5, 4 => 7, 5 => 9, 6 => 11, 7 => 13, 8 => 15, 9 => 17, 10 => 19);
				$temp		= "";
				foreach($param['P_ICON'] as $key => $data):
					if($aryIconSubStringStartPoint[$data]):
						if($temp) { $temp .= " OR "; }
						$temp   .= "SUBSTRING(P_ICON, {$aryIconSubStringStartPoint[$data]}, 1) = 'Y'";
					endif;
				endforeach;
				$temp		= "($temp)";
				$where2		= "{$where2} AND {$temp}";
			endif;

			## 입점자
			if($param['P_SHOP_NO'] || $param['P_SHOP_NO'] == "0"):
				$where2		= "{$where2} AND P2_1.P_SHOP_NO = '{$param['P_SHOP_NO']}'";
			endif;

			if($param['P_SHOP_NO_IN']):
				$where2		= "{$where2} AND P2_1.P_SHOP_NO IN ({$param['P_SHOP_NO_IN']})";
			endif;

			if($param['P_CODE']):
				$where2		= "{$where2} AND P2_1.P_CODE = '{$param['P_CODE']}'";
			endif;

			if($param['P_CODE_IN']):
				$where2		= "{$where2} AND P2_1.P_CODE IN ({$param['P_CODE_IN']})";
			endif;

			if($param['searchStock1'] == "Y"):
				$where2		= "{$where2} AND P2_1.P_STOCK_OUT = 'Y' ";
			endif;

			if($param['searchStock2'] == "Y"):
				$where2		= "{$where2} AND P2_1.P_RESTOCK = 'Y' ";
			endif;

			if($param['searchStock3'] == "Y"):
				$where2		= "{$where2} AND P2_1.P_STOCK_LIMIT = 'Y' ";
			endif;
		}

		## join2_2
		$join2_2From	= "PRODUCT_INFO_{$param['PRODUCT_INFO_LNG_JOIN']}";
		$join2_2		= "JOIN {$join2_2From} AS PM2_2 ON PM2_2.P_CODE = P2.P_CODE";

		## join2_1
		$join2_1From	= TBL_PRODUCT_MGR;
		$join2_1		= "JOIN {$join2_1From} AS P2_1 ON P2_1.P_CODE = P2.P_CODE";

		## from2
		$from2			= "FROM ({$query3}) AS P2";

		## select2
		$select2			 = "SELECT ";
		$select2			.= "P2.P_CODE
							   ,PM2_2.P_NAME
							   ,P2_1.P_CATE
							   ,P2_1.P_NUM
							   ,P2_1.P_MAKER
							   ,P2_1.P_ORIGIN
							   ,P2_1.P_BRAND
							   ,P2_1.P_MODEL
							   ,P2_1.P_LAUNCH_DT
							   ,P2_1.P_REP_DT
							   ,P2_1.P_ORDER
							   ,P2_1.P_SALE_PRICE
							   ,P2_1.P_CONSUMER_PRICE
							   ,P2_1.P_STOCK_PRICE
							   ,P2_1.P_POINT
							   ,P2_1.P_POINT_TYPE
							   ,P2_1.P_POINT_OFF1
							   ,P2_1.P_POINT_OFF2
							   ,P2_1.P_QTY
							   ,P2_1.P_STOCK_OUT
							   ,P2_1.P_RESTOCK
							   ,P2_1.P_STOCK_LIMIT
							   ,P2_1.P_MIN_QTY
							   ,P2_1.P_MAX_QTY
							   ,P2_1.P_TAX
							   ,PM2_2.P_PRICE_TEXT
							   ,P2_1.P_OPT
							   ,P2_1.P_ADD_OPT
							   ,P2_1.P_BAESONG_TYPE
							   ,P2_1.P_BAESONG_PRICE
							   ,P2_1.P_BAESONG_QTY
							   ,PM2_2.P_SEARCH_TEXT
							   ,PM2_2.P_ETC
							   ,PM2_2.P_WEB_TEXT
							   ,PM2_2.P_MOB_TEXT
							   ,PM2_2.P_MEMO
							   ,PM2_2.P_DELIVERY_TEXT
							   ,PM2_2.P_RETURN_TEXT
							   ,P2_1.P_EVENT_UNIT
							   ,P2_1.P_EVENT
							   ,P2_1.P_LIST_ICON
							   ,P2_1.P_LIST_ICON_VIEW
							   ,P2_1.P_LIST_ICON_ST
							   ,P2_1.P_LIST_ICON_ET
							   ,P2_1.P_WEIGHT
							   ,P2_1.P_ST_SIZE
							   ,P2_1.P_SHOP_NO
							   ,P2_1.P_SCR
							   ,P2_1.P_ICON
							   ,P2_1.P_PARENT_CODE
							   ,P2_1.P_COLOR
							   ,P2_1.P_SIZE
							   ,P2_1.P_POINT_NO_USE
							   ,P2_1.P_REG_DT
							   ,P2_1.P_REG_NO
							   ,P2_1.P_MOD_DT
							   ,P2_1.P_MOD_NO

							   ,(IFNULL(P2_1.P_SALE_PRICE,0) - IFNULL(P2_1.P_STOCK_PRICE,0)) P_COMMISION_PRICE
							   ,TRUNCATE(CEILING(((IFNULL(P2_1.P_SALE_PRICE,0) - IFNULL(P2_1.P_STOCK_PRICE,0)) / IFNULL(P2_1.P_SALE_PRICE,0)) * 100),0) P_COMMISION_RATE

								,P2_1.P_APPR
							   ";

		## 상품다국어출력여부에 따라 상품보임여부 컬럼 테이블이 달라짐
		$select2_view	= "	   ,P2_1.P_WEB_VIEW
							   ,P2_1.P_MOB_VIEW

						  ";

		if ($param['prodManyLangViewUse'] == "Y"){
			$select2_view	= ",PM2_2.P_WEB_VIEW
							   ,PM2_2.P_MOB_VIEW
						      ";
		}
		$select2		.= $select2_view;


		## query2
		$query2			= "{$select2} {$from2} {$join2_1} {$join2_2} {$where2}";

		## query(1) 영역

		## limit1
		if($param['LIMIT']):
			$limit1		= "LIMIT {$param['LIMIT']}";
		endif;

		## order_by1
		if($param['ORDER_BY']):
			$aryOrder['productNameDesc']			= "P.P_NAME DESC";
			$aryOrder['productNameAsc']				= "P.P_NAME ASC";
			$aryOrder['productOrderDesc']			= "P.P_ORDER DESC";
			$aryOrder['productOrderAsc']			= "P.P_ORDER ASC";
			$aryOrder['productWebShowDesc']			= "P.P_WEB_VIEW DESC";
			$aryOrder['productWebShowAsc']			= "P.P_WEB_VIEW ASC";
			$aryOrder['productShopNoDesc']			= "P.P_SHOP_NO DESC";
			$aryOrder['productShopNoAsc']			= "P.P_SHOP_NO ASC";
			$aryOrder['productRegDateDesc']			= "P.P_REG_DT DESC";
			$aryOrder['productRegDateAsc']			= "P.P_REG_DT ASC";
			$aryOrder['productSalePriceDesc']		= "P.P_SALE_PRICE DESC";
			$aryOrder['productSalePriceAsc']		= "P.P_SALE_PRICE ASC";
			$aryOrder['productQtyDesc']				= "P.P_QTY DESC";
			$aryOrder['productQtyAsc']				= "P.P_QTY ASC";
			$aryOrder['productCommisionRateDesc']	= "P.P_COMMISION_RATE DESC";
			$aryOrder['productCommisionRateAsc']	= "P.P_COMMISION_RATE ASC";
			$aryOrder['productPointDesc']			= "P.P_POINT DESC";
			$aryOrder['productPointAsc']			= "P.P_POINT ASC";
			$strOrder								= $aryOrder[$param['ORDER_BY']];
			if($strOrder) { $order_by1				= "ORDER BY {$strOrder}";				}
			else		  { $order_by1				= "ORDER BY {$param['ORDER_BY']}";		}


		else:
			$order_by1	= "ORDER BY P.P_CODE DESC";
		endif;

		## where1
		$where1 = "WHERE P.P_CODE IS NOT NULL";

		## join1_2
		if($param['SHOP_SITE_JOIN']):
			$column['OP_LIST']	   .= ", ST.ST_NAME
									";

			$join1_2From			= TBL_SHOP_SITE;
			$join1_2				= "LEFT OUTER JOIN {$join1_2From} AS ST ON ST.SH_NO = P.P_SHOP_NO";

		endif;

		## join1_1
		if($param['PRODUCT_IMG_JOIN']):
			$column['OP_LIST']	   .= " , PM.PM_SAVE_NAME
										, PM.PM_REAL_NAME		";
			$join1_1From			= TBL_PRODUCT_IMG;
			$join1_1				= "LEFT OUTER JOIN {$join1_1From} AS PM ON PM.P_CODE = P.P_CODE AND PM.PM_TYPE = 'list'";
		endif;

		## from1
		$from1		= "FROM ({$query2}) AS P";

		## select1
		$select1	= "SELECT {$column[$op]}";

		## query1
		$query1		= "{$select1} {$from1} {$join1_1} {$join1_2} {$where1} {$order_by1} {$limit1}";
	//	echo $query1;
//print_r($query1);
//exit;
		return $this->getSelectQuery($db, $query1, $op);
	}

// 2013.09.06 kim hee sung union 추가 하기 전 소스
//	function getProdListEx2($db, $op, $param) {
//		$column['OP_LIST']		= "P.*";
//		$column['OP_SELECT']	= "*";
//  		$column['OP_COUNT']		= "COUNT(*)";
//
//		if($param['PRODUCT_INFO_LNG_JOIN']):
//			$column['OP_LIST']	 = "P.P_CODE, AI.P_NAME, P.P_CATE, P.P_NUM, P.P_MAKER, P.P_ORIGIN, P.P_BRAND, P.P_MODEL, P.P_LAUNCH_DT, P.P_WEB_VIEW, P.P_MOB_VIEW, P.P_REP_DT, ";
//			$column['OP_LIST']	.= "P.P_ORDER, P.P_SALE_PRICE, P.P_CONSUMER_PRICE, P.P_STOCK_PRICE, P.P_POINT, P.P_POINT_TYPE, P.P_POINT_OFF1, P.P_POINT_OFF2, P.P_QTY, P.P_STOCK_OUT, ";
//			$column['OP_LIST']	.= "P.P_RESTOCK, P.P_STOCK_LIMIT, P.P_MIN_QTY, P.P_MAX_QTY, P.P_TAX, AI.P_PRICE_TEXT, P.P_OPT, P.P_ADD_OPT, P.P_BAESONG_TYPE, P.P_BAESONG_PRICE, P.P_BAESONG_QTY, ";
//			$column['OP_LIST']	.= "AI.P_SEARCH_TEXT, AI.P_ETC, AI.P_WEB_TEXT, AI.P_MOB_TEXT, AI.P_MEMO, AI.P_DELIVERY_TEXT, AI.P_RETURN_TEXT, P.P_EVENT_UNIT, P.P_EVENT, P.P_LIST_ICON, P.P_LIST_ICON_VIEW, ";
//			$column['OP_LIST']	.= "P.P_LIST_ICON_ST, P.P_LIST_ICON_ET, P.P_WEIGHT, P.P_ST_SIZE, P.P_SHOP_NO, P.P_SCR, P.P_ICON, P.P_PARENT_CODE, P.P_COLOR, P.P_SIZE, P.P_POINT_NO_USE, ";
//			$column['OP_LIST']	.= "P.P_REG_DT, P.P_REG_NO, P.P_MOD_DT, P.P_MOD_NO ";
//		endif;
//
//		if(!$op)	{ return; }
//
//
//		if($param['PRODUCT_IMG_JOIN']):
//			$column['OP_LIST']	   .= ", PM.PM_SAVE_NAME, PM.PM_REAL_NAME";
//			$join1From				= TBL_PRODUCT_IMG;
//			$join1					= "LEFT OUTER JOIN {$join1From} AS PM ON PM.P_CODE = P.P_CODE AND PM.PM_TYPE = 'list'";
//		endif;
//
//		if($param['PRODUCT_INFO_LNG_JOIN']):
//			$join2From		= "PRODUCT_INFO_{$param['PRODUCT_INFO_LNG_JOIN']}";
//			$join2			= "LEFT OUTER JOIN {$join2From} AS AI ON AI.P_CODE = P.P_CODE";
//		endif;
//
//		if($param['SHOP_SITE_JOIN']):
//			$column['OP_LIST']	   .= ", ST.ST_NAME";
//			$join3From				= TBL_SHOP_SITE;
//			$join3					= "LEFT OUTER JOIN {$join3From} AS ST ON ST.SH_NO = P.P_SHOP_NO";
//		endif;
//
//		$where	= "WHERE P.P_CODE IS NOT NULL";
//
//		## 검색어
//		if($param['searchKey']):
//			$arySearchField['name']			= "P.P_NAME LIKE ('%{$param['searchKey']}%')"; // 상품명
//			$arySearchField['code']			= "(P.P_CODE LIKE ('%{$param['searchKey']}%') OR P.P_NUM LIKE ('%{$param['searchKey']}%'))";// 상품코드
//			$arySearchField['maker']		= "P.P_MAKER LIKE ('%{$param['searchKey']}%')"; // 제조사
//			$arySearchField['orgin']		= "P.P_ORIGIN LIKE ('%{$param['searchKey']}%')"; // 원산지
//			$arySearchField['brand']		= "P.P_MODEL LIKE ('%{$param['searchKey']}%')"; // 모델명
//			$arySearchField['search']		= "P.P_SEARCH_TEXT LIKE ('%{$param['searchKey']}%')"; // 검색어
//			$arySearchField['memo']			= "P.P_MEMO LIKE ('%{$param['searchKey']}%')"; // 메모
//
//			$strSearchQuery					= "";
//			foreach($arySearchField as $key => $val):
//				if($strSearchQuery) { $strSearchQuery .= " OR "; }
//				$strSearchQuery				.= $val;
//			endforeach;
//			if($arySearchField[$param['searchField']]) { $strSearchQuery = $arySearchField[$param['searchField']]; }
//
//			$where		= "{$where} AND {$strSearchQuery}";
//		endif;
//
//		## 카테고리
//		if($param['P_CATE_LIKE']):
////			$param['P_CATE']	= str_pad($param['P_CATE'], 12, "0");
//			$where				= "{$where} AND P.P_CATE LIKE '{$param['P_CATE_LIKE']}%'";
//		endif;
//
//		## 상품출시일
//		if($param['P_LAUNCH_DT_BETWEEN'][0] && $param['P_LAUNCH_DT_BETWEEN'][1]):
//			$param['P_LAUNCH_DT_BETWEEN'][0]		= mysql_real_escape_string($param['P_LAUNCH_DT_BETWEEN'][0]);
//			$param['P_LAUNCH_DT_BETWEEN'][1]		= mysql_real_escape_string($param['P_LAUNCH_DT_BETWEEN'][1]);
//			$where		= "{$where} AND P.P_LAUNCH_DT BETWEEN DATE_FORMAT('{$param['P_LAUNCH_DT_BETWEEN'][0]}','%Y-%m-%d 00:00:00') AND DATE_FORMAT('{$param['P_LAUNCH_DT_BETWEEN'][1]}','%Y-%m-%d 23:59:59')";
//		endif;
//
//		## 상품등록일
//		if($param['P_REP_DT_BETWEEN'][0] && $param['P_REP_DT_BETWEEN'][1]):
//			$param['P_REP_DT_BETWEEN'][0]		= mysql_real_escape_string($param['P_REP_DT_BETWEEN'][0]);
//			$param['P_REP_DT_BETWEEN'][1]		= mysql_real_escape_string($param['P_REP_DT_BETWEEN'][1]);
//			$where		= "{$where} AND P.P_REP_DT BETWEEN DATE_FORMAT('{$param['P_REP_DT_BETWEEN'][0]}','%Y-%m-%d 00:00:00') AND DATE_FORMAT('{$param['P_REP_DT_BETWEEN'][1]}','%Y-%m-%d 23:59:59')";
//		endif;
//
//		## 브랜드
//		if($param['P_BRAND']):
//			$where		= "{$where} AND P.P_BRAND = '{$param['P_BRAND']}'";
//		endif;
//
//		## 상품출력(웹)
//		if($param['P_WEB_VIEW']):
//			$where		= "{$where} AND P.P_WEB_VIEW = '{$param['P_WEB_VIEW']}'";
//		endif;
//
//		## 상품출력(모바일)
//		if($param['P_MOB_VIEW']):
//			$where		= "{$where} AND P.P_MOB_VIEW = '{$param['P_MOB_VIEW']}'";
//		endif;
//
//		## 메인, 서브진열관리
//		if($param['P_ICON']):
//			$aryIconSubStringStartPoint = array(1 => 1, 2 => 3, 3 => 5, 4 => 7, 5 => 9, 6 => 11, 7 => 13, 8 => 15, 9 => 17, 10 => 19);
//			$temp		= "";
//			foreach($param['P_ICON'] as $key => $data):
//				if($aryIconSubStringStartPoint[$data]):
//					if($temp) { $temp .= " OR "; }
//					$temp   .= "SUBSTRING(P_ICON, {$aryIconSubStringStartPoint[$data]}, 1) = 'Y'";
//				endif;
//			endforeach;
//			$temp		= "($temp)";
//			$where		= "{$where} AND {$temp}";
//		endif;
//
//		## 입점자
//		if($param['P_SHOP_NO']):
//			$where		= "{$where} AND P.P_SHOP_NO = '{$param['P_SHOP_NO']}'";
//		endif;
//
//		if($param['P_CODE']):
//			$where		= "{$where} AND P.P_CODE = '{$param['P_CODE']}'";
//		endif;
//
//		if($param['P_CODE_IN']):
//			$where		= "{$where} AND P.P_CODE IN ({$param['P_CODE_IN']})";
//		endif;
//
//		if($param['ORDER_BY']):
//			$order_by	= "ORDER BY {$param['ORDER_BY']}";
//		endif;
//
//		if($param['LIMIT']):
//			$limit		= "LIMIT {$param['LIMIT']}";
//		endif;
//
//		$from	= TBL_PRODUCT_MGR;
//		$query	= "SELECT {$column[$op]} FROM {$from} AS P";
//		$query = "{$query} {$join1} {$join2} {$join3} {$where} {$order_by} {$limit}";
//
//		return $this->getSelectQuery($db, $query, $op);
//	}

	function getProdList($db)
	{
		global $S_MALL_TYPE;

		$query  = "SELECT									";
		$query .= "     A.*									";
		$query .= "    ,B.PM_REAL_NAME						";

//		if($S_MALL_TYPE == "M"): // 쇼핑몰 타입이 입점몰일때 사용
//			$query .= ",E.ST_NAME							";
//		endif;

		$query .= "FROM (									";
		$query .= $this->getSearchQry("prodListTable");
		$query .= ") A										";

//		if($S_MALL_TYPE == "M"): // 쇼핑몰 타입이 입점몰일때 사용
//			$query .= "LEFT OUTER JOIN ".TBL_SHOP_SITE." AS E	";		// 2013.06.19 kim hee sung 입점몰 관련 부분 추가
//			$query .= "ON E.SH_NO = A.P_SHOP_NO					";		// 2013.06.19 kim hee sung 입점몰 관련 부분 추가
//		endif;

		$query .= "LEFT OUTER JOIN ".TBL_PRODUCT_IMG." B    ";
		$query .= "ON A.P_CODE = B.P_CODE					";
		$query .= "AND B.PM_TYPE = 'list'					";
		$query .= "WHERE A.P_CODE IS NOT NULL				";

//		echo $query;

		if ($this->getSearchSort()){
			switch($this->getSearchSort()){
				case "RA":
					$query .= "ORDER BY A.P_SALE_PRICE ASC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();
				break;
				case "RD":
					$query .= "ORDER BY A.P_SALE_PRICE DESC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();
				break;
				case "NA":
					$query .= "ORDER BY A.P_NAME ASC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();
				break;
				case "ND":
					$query .= "ORDER BY A.P_NAME DESC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();
				break;
				case "PA":
					$query .= "ORDER BY A.P_POINT ASC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();
				break;
				case "PD":
					$query .= "ORDER BY A.P_POINT DESC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();
				break;
				case "MA":
					$query .= "ORDER BY A.P_MAKER ASC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();
				break;
				case "MD":
					$query .= "ORDER BY A.P_MAKER DESC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();
				break;
				case "OA":
					$query .= "ORDER BY A.P_ORDER ASC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();
				break;
				case "OD":
					$query .= "ORDER BY A.P_ORDER DESC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();
				break;
				case "VA":
					$query .= "ORDER BY A.P_WEB_VIEW ASC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();
				break;
				case "VD":
					$query .= "ORDER BY A.P_WEB_VIEW DESC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();
				break;
				default:
					$query .= "ORDER BY A.P_CODE DESC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();
				break;
			}
		} else {
			$query .= "ORDER BY A.P_CODE DESC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();
		}

		return $db->getExecSql($query);
	}

	/* 관심상품 리스트 */
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

	/* 상품 Wish/Cart 리스트 */
	function getProdWishCartTotal($db)
	{

		global $S_USE_LNG;
		global $S_PROD_MANY_LANG_VIEW;

		## 다국어출력사용유무
		$aryUseLng = $prodManyLngJoin = $prodManyLngColumn = $prodManyLngWebSearch = $prodManyLngMobSearch = "";
		if ($S_PROD_MANY_LANG_VIEW == "Y") {
			$aryUseLng = explode("/",$S_USE_LNG);

			foreach($aryUseLng as $lngKey => $lngVal){
				$prodManyLngJoin .= "LEFT OUTER JOIN ".TBL_PRODUCT_INFO_LNG.$lngVal." A{$lngVal}		";
				$prodManyLngJoin .= "ON A.P_CODE = A{$lngVal}.P_CODE									";

				if ($prodManyLngWebSearch) $prodManyLngWebSearch .= " OR ";
				if ($prodManyLngMobSearch) $prodManyLngMobSearch .= " OR ";
				if ($this->getSearchWebView() && $this->getSearchWebView() != "A"){ $prodManyLngWebSearch .= " A{$lngVal}.P_WEB_VIEW = '".$this->getSearchWebView()."'";}
				if ($this->getSearchMobileView() == "Y"){ $prodManyLngMobSearch .= " A{$lngVal}.P_MOB_VIEW ";}

			}
		}

		$query  = "SELECT                                   ";
		$query .= "     COUNT(*)                            ";
		$query .= "FROM                                                                 ";
		$query .= "(                                                                    ";
		$query .= "    SELECT                                                           ";
		$query .= "         P_CODE                                                      ";
		$query .= "        ,SUM(CASE WHEN GB = 'B' THEN P_CNT ELSE 0 END) B_CNT         ";
		$query .= "        ,SUM(CASE WHEN GB = 'B' THEN P_QTY ELSE 0 END) B_QTY         ";
		$query .= "        ,SUM(CASE WHEN GB = 'B' THEN P_MEM_CNT ELSE 0 END) P_MEM_CNT	";
		$query .= "        ,SUM(CASE WHEN GB = 'W' THEN P_CNT ELSE 0 END) W_CNT         ";
		$query .= "        ,SUM(CASE WHEN GB = 'W' THEN P_QTY ELSE 0 END) W_QTY         ";
		$query .= "        ,SUM(CASE WHEN GB = 'W' THEN P_MEM_CNT ELSE 0 END) W_MEM_CNT	";
		$query .= "    FROM                                                             ";
		$query .= "    (                                                                ";
		$query .= "        SELECT                                                       ";
		$query .= "             'B' GB                                                  ";
		$query .= "            ,P_CODE                                                  ";
		$query .= "            ,COUNT(*) P_CNT                                          ";
		$query .= "            ,SUM(PB_QTY) P_QTY                                       ";
		$query .= "            ,SUM(CASE WHEN M_NO > 0 THEN 1 ELSE 0 END) P_MEM_CNT     ";
		$query .= "        FROM ".TBL_PRODUCT_BASKET."                                  ";
		$query .= "        GROUP BY P_CODE                                              ";
		$query .= "                                                                     ";
		$query .= "        UNION                                                        ";
		$query .= "                                                                     ";
		$query .= "        SELECT                                                       ";
		$query .= "             'W' GB                                                  ";
		$query .= "            ,P_CODE                                                  ";
		$query .= "            ,COUNT(*) P_CNT                                          ";
		$query .= "            ,SUM(PW_QTY) P_QTY                                       ";
		$query .= "            ,SUM(CASE WHEN M_NO > 0 THEN 1 ELSE 0 END) P_MEM_CNT     ";
		$query .= "        FROM ".TBL_PRODUCT_WISH."                                    ";
		$query .= "        GROUP BY P_CODE                                              ";
		$query .= "    ) A                                                              ";
		$query .= "    GROUP BY P_CODE                                                  ";
		$query .= ") W                                                                  ";
		$query .= "JOIN ".TBL_PRODUCT_MGR." A                                           ";
		$query .= "ON W.P_CODE = A.P_CODE                                               ";
		$query .= "LEFT OUTER JOIN ".TBL_PRODUCT_INFO_LNG.$this->getP_LNG()." AI		";
		$query .= "ON A.P_CODE = AI.P_CODE					";

		$query .= "LEFT OUTER JOIN ".TBL_PRODUCT_IMG." B    ";
		$query .= "ON A.P_CODE = B.P_CODE					";
		$query .= "AND B.PM_TYPE = 'list'					";
		$query .= $prodManyLngJoin;

		$query .= "WHERE A.P_CODE IS NOT NULL				";

		if ($this->getSearchHCode1() || $this->getSearchHCode2() || $this->getSearchHCode3() || $this->getSearchHCode4()){
			$query .= "	AND A.P_CATE LIKE '".$this->getSearchHCode1().$this->getSearchHCode2().$this->getSearchHCode3().$this->getSearchHCode4()."%'	";
		}

		if ($this->getSearchField() && $this->getSearchKey()){
			$query .= "	AND ";
			switch ($this->getSearchField()){
				case "N":
					$query .= "	AI.P_NAME LIKE '%".$this->getSearchKey()."%'		";
				break;
				case "C":
					$query .= "	A.P_NUM LIKE '%".$this->getSearchKey()."%'			";
				break;
				case "M":
					$query .= "	A.P_MAKER LIKE '%".$this->getSearchKey()."%'		";
				break;
				case "O":
					$query .= "	A.P_ORIGIN LIKE '%".$this->getSearchKey()."%'		";
				break;
			}
		}

		if ($this->getSearchLaunchStartDt() && $this->getSearchLaunchEndDt()){
			$query .= " AND A.P_LAUNCH_DT BETWEEN DATE_FORMAT('".$this->getSearchLaunchStartDt()."','%Y-%m-%d 00:00:00') ";
			$query .= "					      AND DATE_FORMAT('".$this->getSearchLaunchEndDt()."','%Y-%m-%d 00:00:00') ";
		}

		if ($this->getSearchRepStartDt() && $this->getSearchRepEndDt()){
			$query .= " AND A.P_REP_DT BETWEEN DATE_FORMAT('".$this->getSearchRepStartDt()."','%Y-%m-%d 00:00:00') ";
			$query .= "					   AND DATE_FORMAT('".$this->getSearchRepEndDt()."','%Y-%m-%d 00:00:00') ";
		}

		if ($this->getSearchWebView()){
			if ($prodManyLngWebSearch && $S_PROD_MANY_LANG_VIEW == "Y") $query .= " AND (".$prodManyLngWebSearch.") ";
			else $query .= " AND A.P_WEB_VIEW = '".$this->getSearchWebView()."'		";
		}

		if ($this->getSearchMobileView() == "Y"){
			if ($prodManyLngMobSearch) $query .= " AND (".$prodManyLngMobSearch.") ";
			else $query .= " AND A.P_MOB_VIEW = 'Y'		";
		}


		return $db->getCount($query);
	}

	function getProdWishCartList($db)
	{
		global $S_USE_LNG;
		global $S_PROD_MANY_LANG_VIEW;

		## 다국어출력사용유무
		$aryUseLng = $prodManyLngJoin = $prodManyLngColumn = $prodManyLngWebSearch = $prodManyLngMobSearch = "";
		if ($S_PROD_MANY_LANG_VIEW == "Y") {
			$aryUseLng = explode("/",$S_USE_LNG);
			foreach($aryUseLng as $lngKey => $lngVal){

				$prodManyLngColumn .= " ,A{$lngVal}.P_WEB_VIEW AS P_WEB_VIEW_{$lngVal}
										,A{$lngVal}.P_MOB_VIEW AS P_MOB_VIEW_{$lngVal}
										";
				$prodManyLngJoin .= "LEFT OUTER JOIN ".TBL_PRODUCT_INFO_LNG.$lngVal." A{$lngVal}		";
				$prodManyLngJoin .= "ON A.P_CODE = A{$lngVal}.P_CODE									";

				if ($prodManyLngWebSearch) $prodManyLngWebSearch .= " OR ";
				if ($prodManyLngMobSearch) $prodManyLngMobSearch .= " OR ";
				if ($this->getSearchWebView() && $this->getSearchWebView() != "A"){ $prodManyLngWebSearch .= " A{$lngVal}.P_WEB_VIEW = '".$this->getSearchWebView()."'";}
				if ($this->getSearchMobileView() == "Y"){ $prodManyLngMobSearch .= " A{$lngVal}.P_MOB_VIEW ";}
			}
		}

		$query  = "SELECT                                   ";
		$query .= "     W.*                                 ";
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

		$query .= $prodManyLngColumn;
		$query .= "FROM                                                                 ";
		$query .= "(                                                                    ";
		$query .= "    SELECT                                                           ";
		$query .= "         P_CODE                                                      ";
		$query .= "        ,SUM(CASE WHEN GB = 'B' THEN P_CNT ELSE 0 END) B_CNT         ";
		$query .= "        ,SUM(CASE WHEN GB = 'B' THEN P_QTY ELSE 0 END) B_QTY         ";
		$query .= "        ,SUM(CASE WHEN GB = 'B' THEN P_MEM_CNT ELSE 0 END) B_MEM_CNT	";
		$query .= "        ,SUM(CASE WHEN GB = 'W' THEN P_CNT ELSE 0 END) W_CNT         ";
		$query .= "        ,SUM(CASE WHEN GB = 'W' THEN P_QTY ELSE 0 END) W_QTY         ";
		$query .= "        ,SUM(CASE WHEN GB = 'W' THEN P_MEM_CNT ELSE 0 END) W_MEM_CNT	";
		$query .= "    FROM                                                             ";
		$query .= "    (                                                                ";
		$query .= "        SELECT                                                       ";
		$query .= "             'B' GB                                                  ";
		$query .= "            ,P_CODE                                                  ";
		$query .= "            ,COUNT(*) P_CNT                                          ";
		$query .= "            ,SUM(PB_QTY) P_QTY                                       ";
		$query .= "            ,SUM(CASE WHEN M_NO > 0 THEN 1 ELSE 0 END) P_MEM_CNT     ";
		$query .= "        FROM PRODUCT_BASKET                                          ";
		$query .= "        GROUP BY P_CODE                                              ";
		$query .= "                                                                     ";
		$query .= "        UNION                                                        ";
		$query .= "                                                                     ";
		$query .= "        SELECT                                                       ";
		$query .= "             'W' GB                                                  ";
		$query .= "            ,P_CODE                                                  ";
		$query .= "            ,COUNT(*) P_CNT                                          ";
		$query .= "            ,SUM(PW_QTY) P_QTY                                       ";
		$query .= "            ,SUM(CASE WHEN M_NO > 0 THEN 1 ELSE 0 END) P_MEM_CNT     ";
		$query .= "        FROM ".TBL_PRODUCT_WISH."                                    ";
		$query .= "        GROUP BY P_CODE                                              ";
		$query .= "    ) A                                                              ";
		$query .= "    GROUP BY P_CODE                                                  ";
		$query .= ") W                                                                  ";
		$query .= "JOIN PRODUCT_MGR A                                                   ";
		$query .= "ON W.P_CODE = A.P_CODE                                               ";
		$query .= "LEFT OUTER JOIN ".TBL_PRODUCT_INFO_LNG.$this->getP_LNG()." AI		";
		$query .= "ON A.P_CODE = AI.P_CODE					";

		$query .= "LEFT OUTER JOIN ".TBL_PRODUCT_IMG." B    ";
		$query .= "ON A.P_CODE = B.P_CODE					";
		$query .= "AND B.PM_TYPE = 'list'					";
		$query .= $prodManyLngJoin;

		$query .= "WHERE A.P_CODE IS NOT NULL				";

		if ($this->getSearchHCode1() || $this->getSearchHCode2() || $this->getSearchHCode3() || $this->getSearchHCode4()){
			$query .= "	AND A.P_CATE LIKE '".$this->getSearchHCode1().$this->getSearchHCode2().$this->getSearchHCode3().$this->getSearchHCode4()."%'	";
		}

		if ($this->getSearchField() && $this->getSearchKey()){
			$query .= "	AND ";
			switch ($this->getSearchField()){
				case "N":
					$query .= "	AI.P_NAME LIKE '%".$this->getSearchKey()."%'		";
				break;
				case "C":
					$query .= "	A.P_NUM LIKE '%".$this->getSearchKey()."%'			";
				break;
				case "M":
					$query .= "	A.P_MAKER LIKE '%".$this->getSearchKey()."%'		";
				break;
				case "O":
					$query .= "	A.P_ORIGIN LIKE '%".$this->getSearchKey()."%'		";
				break;
			}
		}

		if ($this->getSearchLaunchStartDt() && $this->getSearchLaunchEndDt()){
			$query .= " AND A.P_LAUNCH_DT BETWEEN DATE_FORMAT('".$this->getSearchLaunchStartDt()."','%Y-%m-%d 00:00:00') ";
			$query .= "					      AND DATE_FORMAT('".$this->getSearchLaunchEndDt()."','%Y-%m-%d 00:00:00') ";
		}

		if ($this->getSearchRepStartDt() && $this->getSearchRepEndDt()){
			$query .= " AND A.P_REP_DT BETWEEN DATE_FORMAT('".$this->getSearchRepStartDt()."','%Y-%m-%d 00:00:00') ";
			$query .= "					   AND DATE_FORMAT('".$this->getSearchRepEndDt()."','%Y-%m-%d 00:00:00') ";
		}

		if ($this->getSearchWebView() == "Y"){
			if ($prodManyLngWebSearch && $S_PROD_MANY_LANG_VIEW == "Y") $query .= " AND (".$prodManyLngWebSearch.") ";
			else $query .= " AND A.P_WEB_VIEW = 'Y'		";
		}

		if ($this->getSearchMobileView() == "Y"){
			if ($prodManyLngMobSearch) $query .= " AND (".$prodManyLngMobSearch.") ";
			else $query .= " AND A.P_MOB_VIEW = 'Y'		";
		}


		switch($this->getSearchSortCol()){
			case "PN":	//상품명
				$query .= "ORDER BY AI.P_NAME ";
			break;
			case "PQ":	//상품수량
				$query .= "ORDER BY A.P_QTY  ";
			break;
			case "CQ":	//WISH
				$query .= "ORDER BY W.B_QTY  ";
			break;
			case "CP":	//WISH
				$query .= "ORDER BY W.B_CNT  ";
			break;
			case "CM":	//WISH
				$query .= "ORDER BY W.B_MEM_CNT  ";
			break;
			case "WQ":	//CART
				$query .= "ORDER BY W.W_QTY  ";
			break;
			case "WP":	//CART
				$query .= "ORDER BY W.W_CNT  ";
			break;
			case "WM":	//CART
				$query .= "ORDER BY W.W_MEM_CNT  ";
			break;

			default:
				$query .= "ORDER BY A.P_CODE ";
			break;
		}
		$query .= $this->getSearchSort() ." LIMIT ".$this->getLimitFirst().",".$this->getPageLine();

		return $db->getExecSql($query);
	}

	function getProdGrpDupCount($db)
	{
		$query  = "SELECT									";
		$query .= "     COUNT(*)							";
		$query .= "FROM ".TBL_PRODUCT_GRP." G				";
		$query .= "WHERE G.P_CODE ='".$this->getP_CODE()."' ";
		$query .= "	AND G.PG_P_CODE ='".$this->getPG_P_CODE()."' ";

		return $db->getCount($query);
	}

	function getProdGrpNo($db)
	{
		$query  = "SELECT									";
		$query .= "     G.PG_NO								";
		$query .= "FROM ".TBL_PRODUCT_GRP." G				";
		$query .= "WHERE G.P_CODE ='".$this->getP_CODE()."' ";
		$query .= "	AND G.PG_P_CODE ='".$this->getPG_P_CODE()."' ";

		return $db->getCount($query);
	}

	/* 상품 브랜드 리스트 */
//	function getProdBrandList($db)
//	{
//		$query  = "SELECT                                                                    ";
//		$query .= "     A.*                                                                  ";
//		$query .= "    ,(SELECT COUNT(*) FROM PRODUCT_MGR WHERE P_BRAND = A.PR_NO) PROD_CNT  ";
//		$query .= "FROM ".TBL_PRODUCT_BRAND." A                                              ";
//		$query .= "ORDER BY A.PR_NAME                                                        ";
//
//		return $db->getArrayTotal($query);
//
//	}

	/* 상품 브랜드 리스트 */
	function getProdBrandList($db, $op="OP_LIST")
	{
		$column['OP_LIST']		= "a.*, b.M_ID AS PR_M_ID";
		$column['OP_COUNT']		= "COUNT(*)";
		$column['OP_SELECT']	= "a.*, b.M_ID AS PR_M_ID";
		$column['OP_ARYTOTAL']	= "a.PR_NO, a.PR_NAME";

		$query		= "SELECT %s FROM %s AS a ";
		$query		= sprintf($query, $column[$op], TBL_PRODUCT_BRAND);

		$join1		= "%s LEFT OUTER JOIN %s AS b ON a.PR_M_NO = b.M_NO";
		$query		= sprintf($join1, $query, TBL_MEMBER_MGR);

		$where		= "%s WHERE a.PR_NO IS NOT NULL ";
		$query		= sprintf($where, $query);

		if($this->getPR_NO() && $op == "OP_SELECT") :
			$query = sprintf("%s AND PR_NO = %d", $query, $this->getPR_NO());
		endif;

		$query		= sprintf("%s ORDER BY a.PR_ALIGN ASC", $query);

		if($this->getPageLine()) :
			$query = sprintf("%s LIMIT %d, %d", $query, $this->getLimitFirst(), $this->getPageLine());
		endif;

		return $this->getSelectQuery($db, $query, $op);
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
			$query .= "WHERE PB_KEY	= '".$this->GetPB_KEY()."'	";
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

	/* 상품 사은품 리스트 */
	function getProdGiftTotal($db)
	{
		$query  = "SELECT									";
		$query .= "     COUNT(*)							";
		$query .= "FROM ".TBL_PRODUCT_GIFT." G				";
		$query .= "JOIN ".TBL_PRODUCT_MGR." A               ";
		$query .= "ON G.P_CODE = A.P_CODE				";
		$query .= "LEFT OUTER JOIN ".TBL_PRODUCT_INFO_LNG.$this->getP_LNG()." AI	";
		$query .= "ON A.P_CODE = AI.P_CODE					";
		$query .= "WHERE A.P_CODE IS NOT NULL				";
		$query .= "	AND G.CG_NO = ".$this->getCG_NO()."		";

		return $db->getCount($query);
	}

	function getProdGiftList($db)
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
		$query .= "FROM ".TBL_PRODUCT_GIFT." G				";
		$query .= "JOIN ".TBL_PRODUCT_MGR." A               ";
		$query .= "ON G.P_CODE = A.P_CODE				";
		$query .= "LEFT OUTER JOIN ".TBL_PRODUCT_INFO_LNG.$this->getP_LNG()." AI	";
		$query .= "ON A.P_CODE = AI.P_CODE					";
		$query .= "LEFT OUTER JOIN ".TBL_PRODUCT_IMG." B    ";
		$query .= "ON A.P_CODE = B.P_CODE					";
		$query .= "AND B.PM_TYPE = 'list'					";
		$query .= "WHERE A.P_CODE IS NOT NULL				";
		$query .= "	AND G.CG_NO = ".$this->getCG_NO()."		";

		$query .= "ORDER BY A.P_CODE DESC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();
		return $db->getExecSql($query);
	}

	/* 공유카테고리 설정 */
	function getProdShareDupCount($db)
	{
		$query  = "SELECT COUNT(*) FROM ".TBL_PRODUCT_SHARE."	";
		$query .= "WHERE P_CODE = '".$this->getP_CODE()."'		";
    	$query .= "AND PS_P_CATE = '".$this->getP_CATE()."'		";

		return $db->getCount($query);
	}

	/* 공유카테고리 리스트 */
	function getProdShareList($db)
	{
		$query  = "SELECT * FROM ".TBL_PRODUCT_SHARE."			";
		$query .= "WHERE P_CODE = '".$this->getP_CODE()."'		";
		$query .= "ORDER BY PS_NO ASC							";

		return $db->getArrayTotal($query);
	}

	/* 공유카테고리 번호 */
	function getProdShareNo($db)
	{
		$query  = "SELECT PS_NO FROM ".TBL_PRODUCT_SHARE."		";
		$query .= "WHERE P_CODE = '".$this->getP_CODE()."'		";
    	$query .= "AND PS_P_CATE = '".$this->getP_CATE()."'		";

		return $db->getCount($query);
	}

	/* 상품 옵션 총 재고 수 */
	function getProdOptTotQty($db)
	{
		$query  = "SELECT                           ";
		$query .= "    SUM(POA_STOCK_QTY) TOT_QTY   ";
		$query .= "FROM ".TBL_PRODUCT_OPT_ATTR."    ";
		$query .= "WHERE PO_NO IN (SELECT PO_NO FROM ".TBL_PRODUCT_OPT." WHERE P_CODE = '".$this->getP_CODE()."')";

		return $db->getCount($query);
	}


	/* 사이트 할인 설정 리스트 */
	function getSiteEventList($db)
	{
		if ($this->getSE_LIST_GUBUN() == "1") {
			$query  = "SELECT                                          ";
			$query .= "    A.*                                         ";
			$query .= "	  ,(SELECT COUNT(*) FROM ".TBL_PRODUCT_MGR." WHERE P_EVENT = A.SE_NO) PROD_CNT	";
			$query .= "FROM ".TBL_SITE_EVENT." A                       ";
			$query .= "WHERE SE_TYPE = 'G'                             ";
			$query .= "    AND SE_START_DT > NOW()	                   ";
		}

		if ($this->getSE_LIST_GUBUN() == "2") {
			$query .= "SELECT                                          ";
			$query .= "    A.*                                         ";
			$query .= "	  ,(SELECT COUNT(*) FROM ".TBL_PRODUCT_MGR." WHERE P_EVENT = A.SE_NO) PROD_CNT	";
			$query .= "FROM ".TBL_SITE_EVENT." A                       ";
			$query .= "WHERE SE_TYPE = 'N'                             ";
			$query .= "                                                ";
			$query .= "UNION                                           ";
			$query .= "                                                ";
			$query .= "SELECT                                          ";
			$query .= "    A.*                                         ";
			$query .= "	  ,(SELECT COUNT(*) FROM ".TBL_PRODUCT_MGR." WHERE P_EVENT = A.SE_NO) PROD_CNT	";
			$query .= "FROM ".TBL_SITE_EVENT." A                       ";
			$query .= "WHERE SE_TYPE = 'G'                             ";
			$query .= "    AND NOW() BETWEEN SE_START_DT AND SE_END_DT ";
		}

		if ($this->getSE_LIST_GUBUN() == "3") {
			$query .= "SELECT                                          ";
			$query .= "    A.*                                         ";
			$query .= "	  ,(SELECT COUNT(*) FROM ".TBL_PRODUCT_MGR." WHERE P_EVENT = A.SE_NO) PROD_CNT	";
			$query .= "FROM ".TBL_SITE_EVENT." A                       ";
			$query .= "WHERE SE_TYPE = 'G'                             ";
			$query .= "    AND SE_END_DT < NOW()                       ";
		}

		$query .= " ORDER BY SE_TYPE DESC, SE_NO DESC				   ";

		return $db->getArrayTotal($query);
	}


	/* 고객사은품 리스트 */
	function getGiftTotal($db)
	{
		$query  = "SELECT									";
		$query .= "     COUNT(*)							";
		$query .= "FROM ".TBL_GIFT_MGR." A	                ";
		$query .= "JOIN ".TBL_GIFT_LNG." B					";
		$query .= "ON A.CG_NO = B.CG_NO						";
		$query .= "AND B.CG_LNG = '".mysql_real_escape_string($this->getCG_LNG())."'	";
		$query .= "WHERE A.CG_NO IS NOT NULL				";

		if ($this->getSearchField() && $this->getSearchKey()){
			$query .= "	AND ";
			switch ($this->getSearchField()){
				case "N":
					$query .= "	B.CG_NAME LIKE '%".$this->getSearchKey()."%'		";
				break;
			}
		}

		return $db->getCount($query);
	}

	function getGiftList($db)
	{
		$query  = "SELECT									";
		$query .= "      A.*								";
		$query .= "		,(SELECT COUNT(*) FROM ".TBL_PRODUCT_GIFT." WHERE CG_NO = A.CG_NO) PROD_CNT	";
		$query .= "		,B.CG_NAME							";
		$query .= "FROM ".TBL_GIFT_MGR." A	                ";
		$query .= "JOIN ".TBL_GIFT_LNG." B					";
		$query .= "ON A.CG_NO = B.CG_NO						";
		$query .= "AND B.CG_LNG = '".mysql_real_escape_string($this->getCG_LNG())."'	";
		$query .= "WHERE A.CG_NO IS NOT NULL				";

		if ($this->getSearchField() && $this->getSearchKey()){
			$query .= "	AND ";
			switch ($this->getSearchField()){
				case "N":
					$query .= "	B.CG_NAME LIKE '%".$this->getSearchKey()."%'		";
				break;
			}
		}

		return $db->getExecSql($query);
	}

	function getProdBrandNo($db){
		$query = "SELECT PR_NO FROM ".TBL_PRODUCT_BRAND." WHERE Lower(PR_NAME) = Lower('".$this->getPR_NAME()."');";
		return $db->getCount($query);
	}

	/********************************** Product View **********************************/
	function getProdView($db){

		global $S_PROD_MANY_LANG_VIEW;
		global $S_PRODUCT_AUCTION_USE;

		## 경매관리 사용여부
		$auctionJoin = $auctionColumn = "";
		if ($S_PRODUCT_AUCTION_USE == "Y"){
			$auctionColumn	.= ",PAU.P_AUC_ST_DT			";
			$auctionColumn	.= ",PAU.P_AUC_END_DT			";
			$auctionColumn	.= ",PAU.P_AUC_ST_PRICE			";
			$auctionColumn	.= ",PAU.P_AUC_RIGHT_PRICE		";
			$auctionColumn	.= ",PAU.P_AUC_STATUS			";

			$auctionJoin	.= "LEFT OUTER JOIN PRODUCT_AUCTION PAU ";
			$auctionJoin	.= "ON A.P_CODE = PAU.P_CODE			";
		}

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
		/*$query .= "    ,B.ICON1								";
		$query .= "    ,B.ICON2								";
		$query .= "    ,B.ICON3								";
		$query .= "    ,B.ICON4								";
		$query .= "    ,B.ICON5								";
		$query .= "    ,B.ICON6								";
		$query .= "    ,B.ICON7								";
		$query .= "    ,B.ICON8								";
		$query .= "    ,B.ICON9								";
		$query .= "    ,B.ICON10							";*/
		$query .= "    ,C.PM_REAL_NAME						";
		$query .= "    ,D.PM_REAL_NAME PROD_LIST_IMG		";
		//$query .= "    ,(SELECT PR_NAME FROM ".TBL_PRODUCT_BRAND." WHERE PR_NO = A.P_BRAND) AS P_BRAND_NAME ";

		if ($S_PROD_MANY_LANG_VIEW == "Y"){
			$query .= "    ,AI.P_WEB_VIEW AS P_WEB_VIEW_".$this->getP_LNG()."	";
			$query .= "    ,AI.P_MOB_VIEW AS P_MOB_VIEW_".$this->getP_LNG()."	";
		}

		$query .= $auctionColumn;
		$query .= "FROM ".TBL_PRODUCT_MGR." A               ";
		$query .= "LEFT OUTER JOIN ".TBL_PRODUCT_INFO_LNG.$this->getP_LNG()." AI	";
		$query .= "ON A.P_CODE = AI.P_CODE					";

		//$query .= "LEFT OUTER JOIN ".VIEW_PRODUCT_ICON." B	";
		//$query .= "ON A.P_CODE = B.P_CODE					";
		$query .= "LEFT OUTER JOIN ".TBL_PRODUCT_IMG." C    ";
		$query .= "ON A.P_CODE = C.P_CODE					";
		$query .= "AND C.PM_TYPE = 'view'					";
		$query .= "LEFT OUTER JOIN ".TBL_PRODUCT_IMG." D    ";
		$query .= "ON A.P_CODE = D.P_CODE					";
		$query .= "AND D.PM_TYPE = 'list'					";

		$query .= $auctionJoin;

		$query .= "WHERE A.P_CODE = '".$this->getP_CODE()."'	";

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
		//$query .= "    ,B.ICON1								";
		//$query .= "    ,B.ICON2								";
		//$query .= "    ,B.ICON3								";
		//$query .= "    ,B.ICON4								";
		//$query .= "    ,B.ICON5								";
		$query .= "    ,C.PM_REAL_NAME						";
		$query .= "FROM ".TBL_PRODUCT_MGR." A               ";
		//$query .= "LEFT OUTER JOIN ".VIEW_PRODUCT_ICON." B	";
		//$query .= "ON A.P_CODE = B.P_CODE					";
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
		$query .= "    ,AI.P_NAME	P_NAME2					";
		$query .= "FROM ".TBL_PRODUCT_MGR." A               ";
		$query .= "LEFT OUTER JOIN ".TBL_PRODUCT_INFO_LNG.$this->getP_LNG()." AI	";
		$query .= "ON A.P_CODE = AI.P_CODE					";
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

	function getProdItemEx($db, $op, $param)
	{
		$column['OP_LIST']		= "*";
		$column['OP_SELECT']	= "*";
  		$column['OP_COUNT']		= "COUNT(*)";

		if(!$op)	{ return; }

		$from	= TBL_PRODUCT_ITEM;
		$query	= "SELECT {$column[$op]} FROM {$from} AS PI";
		$where	= "WHERE PI.PI_NO IS NOT NULL";

		if($param['PRODUCT_ITEM_LNG_JOIN']):
			$join1From		= "PRODUCT_ITEM_{$param['PRODUCT_ITEM_LNG_JOIN']}";
			$join1			= "JOIN {$join1From} AS PI_LNG ON PI_LNG.PI_NO = PI.PI_NO";
		endif;

		if($param['PI_NO']):
			$where			= "{$where} AND PI.PI_NO = {$param['PI_NO']}";
		endif;

		if($param['P_CODE']):
			$where			= "{$where} AND PI.P_CODE = '{$param['P_CODE']}'";
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

	function getProdItem($db)
	{
		global $S_SHOP_PROD_ADD_ITEM_VERSION;

		$addColumn = "";
		if ($S_SHOP_PROD_ADD_ITEM_VERSION == "V2.O"){
			$addColumn = ",A.PI_TYPE	";
		}

		if ($this->getP_LNG()){
			$query  = "SELECT B.* ";
			$query .= $addColumn;
			$query .= "FROM ".TBL_PRODUCT_ITEM." A ";
			$query .= "	JOIN ".TBL_PRODUCT_ITEM_LNG.$this->getP_LNG()." B ";
			$query .= " ON A.PI_NO = B.PI_NO		   ";
			$query .= "	WHERE A.P_CODE = '".$this->getP_CODE()."'";

			if ($this->getPI_NO() > 0){
				$query .= " AND A.PI_NO  = ".$this->getPI_NO();
			}

			$query .= " ORDER BY A.PI_NO ASC	";
		} else {
			$query  = "SELECT A.* ";
			$query .= $addColumn;
			$query .= "FROM ".TBL_PRODUCT_ITEM." A ";
			$query .= "	WHERE A.P_CODE = '".$this->getP_CODE()."'";
			$query .= " ORDER BY A.PI_NO ASC	";
		}

		return $db->getArrayTotal($query);
	}

	function getProdOptEx($db, $op, $param)
	{
		$column['OP_LIST']		= "*";
		$column['OP_SELECT']	= "*";
  		$column['OP_COUNT']		= "COUNT(*)";

		if(!$op)	{ return; }

		$from	= TBL_PRODUCT_OPT;
		$query	= "SELECT {$column[$op]} FROM {$from} AS PO";
		$where	= "WHERE PO.PO_NO IS NOT NULL";

		if($param['PRODUCT_OPT_LNG_JOIN']):
			$join1From		= "PRODUCT_OPT_{$param['PRODUCT_OPT_LNG_JOIN']}";
			$join1			= "JOIN {$join1From} AS PO_LNG ON PO_LNG.PO_NO = PO.PO_NO";
		endif;

		if($param['PO_NO']):
			$where			= "{$where} AND PO.PO_NO = {$param['PO_NO']}";
		endif;

		if($param['P_CODE']):
			$where			= "{$where} AND PO.P_CODE = '{$param['P_CODE']}'";
		endif;

		if($param['PO_TYPE']):
			$where			= "{$where} AND PO.PO_TYPE = '{$param['PO_TYPE']}'";
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

		/* 2013.03.28 수정 */
		if ($this->getPO_NO() > 0) {
			$query .= "    AND A.PO_NO = ".$this->getPO_NO();
		}

		$query .= " ORDER BY A.PO_NO ASC             ";

		return $db->getArrayTotal($query);
	}

	function getProdOptAttrEx($db, $op, $param)
	{
		$column['OP_LIST']		= "*";
		$column['OP_SELECT']	= "*";
  		$column['OP_COUNT']		= "COUNT(*)";
		$column['OP_ARYTOTAL']	= "*";

		if(!$op)	{ return; }

		$from	= TBL_PRODUCT_OPT_ATTR;
		$query	= "SELECT {$column[$op]} FROM {$from} AS POA";
		$where	= "WHERE POA.POA_NO IS NOT NULL";

		if($param['PRODUCT_OPT_ATTR_LNG_JOIN']):
			$join1From		= "PRODUCT_OPT_ATTR_{$param['PRODUCT_OPT_ATTR_LNG_JOIN']}";
			$join1			= "JOIN {$join1From} AS POA_LNG ON POA_LNG.POA_NO = POA.POA_NO";
		endif;

		if($param['POA_NO']):
			$where			= "{$where} AND POA.POA_NO = {$param['POA_NO']}";
		endif;

		if($param['PO_NO']):
			$where			= "{$where} AND POA.PO_NO = '{$param['PO_NO']}'";
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

	function getProdOptAttr($db)
	{
		$query  =    "SELECT									";
		$query .= "     B.POA_NO								";

		if ($this->getP_LNG()){

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
		}

		$query .= "    ,B.POA_SALE_PRICE						";
		$query .= "    ,B.POA_CONSUMER_PRICE					";
		$query .= "    ,B.POA_STOCK_PRICE						";
		$query .= "    ,B.POA_POINT								";
		$query .= "    ,B.POA_STOCK_QTY							";
		$query .= "FROM ".TBL_PRODUCT_OPT." A					";
		$query .= "LEFT OUTER JOIN ".TBL_PRODUCT_OPT_ATTR." B	";
		$query .= "ON A.PO_NO = B.PO_NO							";

		if ($this->getP_LNG()){
			$query .= " JOIN ".TBL_PRODUCT_OPT_ATTR_LNG.$this->getP_LNG()." C		";
			$query .= " ON B.POA_NO = C.POA_NO					";
		}

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


	function getProdAddOptEx($db, $op, $param)
	{
		$column['OP_LIST']		= "*";
		$column['OP_SELECT']	= "*";
  		$column['OP_COUNT']		= "COUNT(*)";

		if(!$op)	{ return; }

		$from	= TBL_PRODUCT_ADD_OPT;
		$query	= "SELECT {$column[$op]} FROM {$from} AS PAO";
		$where	= "WHERE PAO.PAO_NO IS NOT NULL";

		if($param['PRODUCT_ADD_OPT_LNG_JOIN']):
			$join1From		= "PRODUCT_ADD_OPT_{$param['PRODUCT_ADD_OPT_LNG_JOIN']}";
			$join1			= "JOIN {$join1From} AS PAO_LNG ON PAO_LNG.PAO_NO = PAO.PAO_NO";
		endif;

		if($param['PAO_NO']):
			$where			= "{$where} AND PAOPO.PAO_NO = {$param['PAO_NO']}";
		endif;

		if($param['PO_NO']):
			$where			= "{$where} AND PAO.PO_NO = {$param['PO_NO']}";
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

	function getProdAddOpt($db)
	{

		$query  = "SELECT										";
		$query .= "     B.PAO_NO								";

		if ($this->getP_LNG()){
			$query .= "    ,C.PAO_NAME							";
		}

		$query .= "    ,B.PAO_PRICE								";
		$query .= "FROM ".TBL_PRODUCT_OPT." A					";
		$query .= "LEFT OUTER JOIN ".TBL_PRODUCT_ADD_OPT." B	";
		$query .= "ON A.PO_NO = B.PO_NO							";

		if ($this->getP_LNG()){
			$query .= " LEFT OUTER JOIN ".TBL_PRODUCT_ADD_OPT_LNG.$this->getP_LNG()." C		";
			$query .= " ON B.PAO_NO = C.PAO_NO					";
		}

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

	function getProdImgEx($db, $op, $param)
	{
		$column['OP_LIST']		= "*";
		$column['OP_SELECT']	= "*";
  		$column['OP_COUNT']		= "COUNT(*)";
		$column['OP_ARYTOTAL']	= "*";

		if(!$op)	{ return; }

		$from	= TBL_PRODUCT_IMG;
		$query	= "SELECT {$column[$op]} FROM {$from} AS PM";
		$where	= "WHERE PM.PM_NO IS NOT NULL";

		if($param['PM_NO']):
			$where			= "{$where} AND PM.PM_NO = {$param['PM_NO']}";
		endif;

		if($param['P_CODE']):
			$where			= "{$where} AND PM.P_CODE = '{$param['P_CODE']}'";
		endif;

		if($param['PM_TYPE']):
			$where			= "{$where} AND PM.PM_TYPE = '{$param['PM_TYPE']}'";
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

	function getProdImg($db)
	{
		$query  = "SELECT                           ";
		$query .= "    A.*                          ";
		$query .= "FROM ".TBL_PRODUCT_IMG." A       ";
		$query .= "WHERE A.P_CODE = '".$this->getP_CODE()."'			";
		$query .= "    AND A.PM_TYPE = '".$this->getPM_TYPE()."'		";

		return $db->getArrayTotal($query);
	}

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
		$query .= "     B.POA_ATTR".$this->getPOA_ATTR_GROUP()." AS POA_ATTR	";
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


	/* 장바구니 */
	function getProdBasketTotal($db)
	{
		$query =    "SELECT									";
		$query .= "     COUNT(*)							";
		$query .= "FROM ".TBL_PRODUCT_BASKET." A			";
		$query .= "LEFT OUTER JOIN ".TBL_PRODUCT_MGR." B	";
		$query .= "ON A.P_CODE = B.P_CODE					";
		$query .= "WHERE A.PB_NO IS NOT NULL				";

		if ($this->getM_NO()){
			$query .= "	AND A.M_NO = ".$this->getM_NO()."						";
		} else {
			$query .= "	AND A.PB_KEY = '".$this->getPB_KEY()."'					";
		}

		if ($this->getPB_ALL_NO()){
			$query .= " AND A.PB_NO IN (".$this->getPB_ALL_NO().") ";
		}

		return $db->getCount($query);
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

	/* Wish 리스트 */

	function getProdWishTotal($db)
	{
		$query =    "SELECT									";
		$query .= "     COUNT(*)							";
		$query .= "FROM ".TBL_PRODUCT_WISH." A			";
		$query .= "LEFT OUTER JOIN ".TBL_PRODUCT_MGR." B	";
		$query .= "ON A.P_CODE = B.P_CODE					";
		$query .= "WHERE A.PW_NO IS NOT NULL				";

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
		$query =    "SELECT									";
		$query .= "     A.*									";
		$query .= "    ,B.P_NAME							";
		$query .= "    ,B.P_BAESONG_TYPE					";
		$query .= "    ,B.P_BAESONG_PRICE					";
		$query .= "    ,B.P_EVENT_UNIT						";
		$query .= "    ,B.P_EVENT							";
		$query .= "    ,C.PM_REAL_NAME						";
		$query .= "FROM ".TBL_PRODUCT_WISH." A			";
		$query .= "LEFT OUTER JOIN ".TBL_PRODUCT_MGR." B	";
		$query .= "ON A.P_CODE = B.P_CODE					";
		$query .= "LEFT OUTER JOIN ".TBL_PRODUCT_IMG." C	";
		$query .= "ON A.P_CODE = C.P_CODE					";
		$query .= "AND C.PM_TYPE = 'list'					";
		$query .= "WHERE A.PW_NO IS NOT NULL				";

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

	/* 상품 브랜드 상세보기 */
	function getProdBrandView($db)
	{
		$query  = "SELECT A.* ";
		$query .= "    ,(SELECT COUNT(*) FROM PRODUCT_MGR WHERE P_BRAND = A.PR_NO) PROD_CNT  ";
		$query .= "FROM ".TBL_PRODUCT_BRAND." A WHERE A.PR_NO = ".$this->getPR_NO();

		return $db->getSelect($query);
	}

	/* 사이트 이벤트 상세보기 */
	function getSiteEventView($db)
	{
		$query  = "SELECT                                          ";
		$query .= "    A.*                                         ";
		$query .= "FROM ".TBL_SITE_EVENT." A                       ";
		$query .= "WHERE SE_NO = ".$this->getSE_NO();

		return $db->getSelect($query);
	}

	/* 사은품 상세보기 */
	function getGiftView($db)
	{
		$query  = "SELECT                                          ";
		$query .= "    A.*                                         ";
		$query .= "FROM ".TBL_GIFT_MGR." A						   ";
		$query .= "WHERE CG_NO = ".$this->getCG_NO();

		return $db->getSelect($query);
	}


	function getGiftLngList($db)
	{
		$query  = "SELECT                                          ";
		$query .= "    A.*                                         ";
		$query .= "FROM ".TBL_GIFT_LNG." A						   ";
		$query .= "WHERE CG_NO = ".$this->getCG_NO();

		return $db->getArrayTotal($query);
	}

	function getShopList($db,$param = "")
	{
		$query .= "SELECT SH_NO,SH_COM_NAME FROM ".TBL_SHOP_MGR;
		$query .= "	WHERE SH_APPR = 'Y'					";

		if ($param['SHOP_LIST']){
			$query .= " WHERE A.SH_NO IN (".$param['SHOP_LIST'].")	";
		}

		$qeury .= "	ORDER BY A.SH_NO ASC	";
		return $db->getArray($query);
	}

	function getProdOrderCount($db){
		$query  = "SELECT COUNT(*) FROM			";
		$query .= TBL_ORDER_MGR." A				";
		$query .= "JOIN ".TBL_ORDER_CART." B	";
		$query .= "ON A.O_NO = B.O_NO			";
		$query .= "	WHERE A.O_STATUS NOT IN ('F','W')";
		$query .= "		AND B.P_CODE = '".$this->getP_CODE()."'	";

		return $db->getCount($query);
	}
	/********************************** Insert **********************************/
	function getProdInsert($db)
	{
		$query = "CALL SP_PRODUCT_MGR_I (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getP_CODE();
		$param[]  = $this->getP_NAME();
		$param[]  = $this->getP_CATE();
		$param[]  = $this->getP_NUM();
		$param[]  = $this->getP_MAKER();
		$param[]  = $this->getP_ORIGIN();
		$param[]  = $this->getP_BRAND();
		$param[]  = $this->getP_MODEL();
		$param[]  = $this->getP_LAUNCH_DT();
		$param[]  = $this->getP_WEB_VIEW();
		$param[]  = $this->getP_MOB_VIEW();
		$param[]  = $this->getP_APPR();
		$param[]  = $this->getP_REP_DT();
		$param[]  = $this->getP_ORDER();
		$param[]  = $this->getP_SALE_PRICE();
		$param[]  = $this->getP_CONSUMER_PRICE();
		$param[]  = $this->getP_STOCK_PRICE();
		$param[]  = $this->getP_PRICE_FILTER();
		$param[]  = $this->getP_PRICE_UNIT();
		$param[]  = $this->getP_CAS_NO();
		$param[]  = $this->getP_OTHER_NAMES();
		$param[]  = $this->getP_TYPE();
		$param[]  = $this->getP_POINT();
		$param[]  = $this->getP_POINT_TYPE();
		$param[]  = $this->getP_POINT_OFF1();
		$param[]  = $this->getP_POINT_OFF2();
		$param[]  = $this->getP_QTY();
		$param[]  = $this->getP_STOCK_OUT();
		$param[]  = $this->getP_RESTOCK();
		$param[]  = $this->getP_STOCK_LIMIT();
		$param[]  = $this->getP_MIN_QTY();
		$param[]  = $this->getP_MAX_QTY();
		$param[]  = $this->getP_SAIL_UNIT();
		$param[]  = $this->getP_TAX();
		$param[]  = $this->getP_OPT();
		$param[]  = $this->getP_ADD_OPT();
		$param[]  = $this->getP_BAESONG_TYPE();
		$param[]  = $this->getP_BAESONG_PRICE();
		$param[]  = $this->getP_SCR();
		$param[]  = $this->getP_SHOP_NO();
	//	$param[]  = $this->getP_SHOP_PRICE();
		$param[]  = $this->getP_WEIGHT();
		$param[]  = $this->getP_ST_SIZE();
		$param[]  = $this->getP_LIST_ICON_VIEW();
		$param[]  = $this->getP_LIST_ICON_ST();
		$param[]  = $this->getP_LIST_ICON_ET();
		$param[]  = 0;

		return $db->executeBindingQuery($query,$param,true);
	}

	function getProdInfoInsert($db)
	{

		$param['P_CODE']			= $this->getSQLString($this->getP_CODE());
		$param['P_NAME']			= $this->getSQLString($this->getP_NAME());
		$param['P_SEARCH_TEXT']		= $this->getSQLString($this->getP_SEARCH_TEXT());
		$param['P_WEB_TEXT']		= $this->getSQLString($this->getP_WEB_TEXT());
		$param['P_MOB_TEXT']		= $this->getSQLString($this->getP_MOB_TEXT());
		$param['P_MEMO']			= $this->getSQLString($this->getP_MEMO());
		$param['P_DELIVERY_TEXT']	= $this->getSQLString($this->getP_DELIVERY_TEXT());
		$param['P_RETURN_TEXT']		= $this->getSQLString($this->getP_RETURN_TEXT());
		$param['P_ETC']				= $this->getSQLString($this->getP_ETC());
		$param['P_PRICE_TEXT']		= $this->getSQLString($this->getP_PRICE_TEXT());
		$param['P_WEB_VIEW']		= $this->getSQLString($this->getP_WEB_VIEW());
		$param['P_MOB_VIEW']		= $this->getSQLString($this->getP_MOB_VIEW());

		return $db->getInsertParam("PRODUCT_INFO_".$this->getP_LNG(), $param, false);

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

	function getProdItemInsert($db,$paramCopyData = "")
	{
		global $S_SHOP_PROD_ADD_ITEM_VERSION;
		$query = "CALL SP_PRODUCT_ITEM_I (?,?);";

		if ($paramCopyData['MODE'] == "COPY") $param[]  = $this->getP_COPY_CODE();
		else $param[]  = $this->getP_CODE();

		$param[]  = $this->getPI_ORDER();

		if ($S_SHOP_PROD_ADD_ITEM_VERSION == "V2.O"){
			$query = "CALL SP_PRODUCT_ITEM_I (?,?,?);";
			$param[]  = $paramCopyData['PI_TYPE'];
		}

		return $db->executeBindingQuery($query,$param,true);
	}

	function getProdItemCopyInsert($db)
	{
		$query = "CALL SP_PRODUCT_ITEM_I (?,?);";

		$param[]  = $this->getP_COPY_CODE();
		$param[]  = $this->getPI_ORDER();

		return $db->executeBindingQuery($query,$param,true);
	}

	function getProdItemLngInsert($db)
	{
		$param['PI_NO']			= $this->getSQLInteger($this->getPI_NO());
		$param['PI_NAME']		= $this->getSQLString($this->getPI_NAME());
		$param['PI_TEXT']		= $this->getSQLString($this->getPI_TEXT());

		return $db->getInsertParam("PRODUCT_ITEM_".$this->getPI_LNG(), $param, false);

//		$query = "CALL SP_PRODUCT_ITEM_LNG_I (?,?,?,?);";
//
//		$param[]  = $this->getPI_NO();
//		$param[]  = $this->getPI_LNG();
//		$param[]  = $this->getPI_NAME();
//		$param[]  = $this->getPI_TEXT();
//
//		return $db->executeBindingQuery($query,$param,true);
	}

	function getProdOptInsert($db,$paramCopyData = "")
	{
		$query = "CALL SP_PRODUCT_OPT_I (?,?,?);";

		if ($paramCopyData['MODE'] == "COPY") $param[]  = $this->getP_COPY_CODE();
		else $param[]  = $this->getP_CODE();

		$param[]  = $this->getPO_TYPE();
		$param[]  = $this->getPO_ESS();

		return $db->executeBindingQuery($query,$param,true);
	}

	function getProdOptLngInsert($db)
	{
		$param['PO_NO']				= $this->getSQLInteger($this->getPO_NO());
		$param['PO_NAME1']			= $this->getSQLString($this->getPO_NAME1());
		$param['PO_NAME2']			= $this->getSQLString($this->getPO_NAME2());
		$param['PO_NAME3']			= $this->getSQLString($this->getPO_NAME3());
		$param['PO_NAME4']			= $this->getSQLString($this->getPO_NAME4());
		$param['PO_NAME5']			= $this->getSQLString($this->getPO_NAME5());
		$param['PO_NAME6']			= $this->getSQLString($this->getPO_NAME6());
		$param['PO_NAME7']			= $this->getSQLString($this->getPO_NAME7());
		$param['PO_NAME8']			= $this->getSQLString($this->getPO_NAME8());
		$param['PO_NAME9']			= $this->getSQLString($this->getPO_NAME9());
		$param['PO_NAME10']			= $this->getSQLString($this->getPO_NAME10());

		return $db->getInsertParam("PRODUCT_OPT_".$this->getP_LNG(), $param, false);

//		$query = "CALL SP_PRODUCT_OPT_LNG_I (?,?,?,?,?,?,?,?,?,?,?,?);";
//
//		$param[]  = $this->getP_LNG();
//		$param[]  = $this->getPO_NO();
//		$param[]  = $this->getPO_NAME1();
//		$param[]  = $this->getPO_NAME2();
//		$param[]  = $this->getPO_NAME3();
//		$param[]  = $this->getPO_NAME4();
//		$param[]  = $this->getPO_NAME5();
//		$param[]  = $this->getPO_NAME6();
//		$param[]  = $this->getPO_NAME7();
//		$param[]  = $this->getPO_NAME8();
//		$param[]  = $this->getPO_NAME9();
//		$param[]  = $this->getPO_NAME10();
//
//		return $db->executeBindingQuery($query,$param,true);
	}

	function getProdCopyItemInsert($db)
	{
		$query = "CALL SP_PRODUCT_ITEM_COPY_I (?,?,?);";

		$param[]  = $this->getP_CODE();
		$param[]  = $this->getP_COPY_CODE();
		$param[]  = $this->getPI_NO();

		return $db->executeBindingQuery($query,$param,true);
	}

	function getProdCopyOptInsert($db)
	{
		$query = "CALL SP_PRODUCT_OPT_I (?,?,?);";

		$param[]  = $this->getP_COPY_CODE();
		$param[]  = $this->getPO_TYPE();
		$param[]  = $this->getPO_ESS();

		return $db->executeBindingQuery($query,$param,true);
	}


	function getProdOptAttrInsert($db)
	{
		$query = "CALL SP_PRODUCT_OPT_ATTR_I (?,?,?,?,?,?);";

		$param[]  = $this->getPO_NO();
		$param[]  = $this->getPOA_SALE_PRICE();
		$param[]  = $this->getPOA_CONSUMER_PRICE();
		$param[]  = $this->getPOA_STOCK_PRICE();
		$param[]  = $this->getPOA_POINT();
		$param[]  = $this->getPOA_STOCK_QTY();

		return $db->executeBindingQuery($query,$param,true);
	}

	function getProdOptAttrLngInsert($db)
	{
		$param['POA_NO']			= $this->getSQLInteger($this->getPOA_NO());
		$param['POA_ATTR1']			= $this->getSQLString($this->getPOA_ATTR1());
		$param['POA_ATTR2']			= $this->getSQLString($this->getPOA_ATTR2());
		$param['POA_ATTR3']			= $this->getSQLString($this->getPOA_ATTR3());
		$param['POA_ATTR4']			= $this->getSQLString($this->getPOA_ATTR4());
		$param['POA_ATTR5']			= $this->getSQLString($this->getPOA_ATTR5());
		$param['POA_ATTR6']			= $this->getSQLString($this->getPOA_ATTR6());
		$param['POA_ATTR7']			= $this->getSQLString($this->getPOA_ATTR7());
		$param['POA_ATTR8']			= $this->getSQLString($this->getPOA_ATTR8());
		$param['POA_ATTR9']			= $this->getSQLString($this->getPOA_ATTR9());
		$param['POA_ATTR10']		= $this->getSQLString($this->getPOA_ATTR10());

		return $db->getInsertParam("PRODUCT_OPT_ATTR_".$this->getP_LNG(), $param, false);

//		$query = "CALL SP_PRODUCT_OPT_ATTR_LNG_I (?,?,?,?,?,?,?,?,?,?,?,?);";
//
//		$param[]  = $this->getP_LNG();
//		$param[]  = $this->getPOA_NO();
//		$param[]  = $this->getPOA_ATTR1();
//		$param[]  = $this->getPOA_ATTR2();
//		$param[]  = $this->getPOA_ATTR3();
//		$param[]  = $this->getPOA_ATTR4();
//		$param[]  = $this->getPOA_ATTR5();
//		$param[]  = $this->getPOA_ATTR6();
//		$param[]  = $this->getPOA_ATTR7();
//		$param[]  = $this->getPOA_ATTR8();
//		$param[]  = $this->getPOA_ATTR9();
//		$param[]  = $this->getPOA_ATTR10();
//
//		return $db->executeBindingQuery($query,$param,true);
	}

	function getProdAddOptInsert($db)
	{
		$query = "CALL SP_PRODUCT_ADD_OPT_I (?,?);";

		$param[]  = $this->getPO_NO();
		$param[]  = $this->getPAO_PRICE();

		return $db->executeBindingQuery($query,$param,true);
	}

	function getProdAddOptLngInsert($db)
	{
		$param['PAO_NO']		= $this->getSQLInteger($this->getPAO_NO());
		$param['PAO_NAME']		= $this->getSQLString($this->getPAO_NAME());

		return $db->getInsertParam("PRODUCT_ADD_OPT_".$this->getP_LNG(), $param, false);

//		$query = "CALL SP_PRODUCT_ADD_OPT_LNG_I (?,?,?);";
//
//		$param[]  = $this->getP_LNG();
//		$param[]  = $this->getPAO_NO();
//		$param[]  = $this->getPAO_NAME();
//
//		return $db->executeBindingQuery($query,$param,true);
	}

	function getProdImgInsert($db)
	{
		$query = "CALL SP_PRODUCT_IMG_I (?,?,?,?);";

		$param[]  = $this->getP_CODE();
		$param[]  = $this->getPM_TYPE();
		$param[]  = $this->getPM_SAVE_NAME();
		$param[]  = $this->getPM_REAL_NAME();

		return $db->executeBindingQuery($query,$param,true);
	}

	function getProdImgInsertEx($db, $paramData)
	{
		$query = "CALL SP_PRODUCT_IMG_I (?,?,?,?);";

		$param[]  = $paramData['P_CODE'];
		$param[]  = $paramData['PM_TYPE'];
		$param[]  = $paramData['PM_SAVE_NAME'];
		$param[]  = $paramData['PM_REAL_NAME'];

		return $db->executeBindingQuery($query,$param,true);
	}

	function getProdCopyImgInsert($db)
	{
		$query = "CALL SP_PRODUCT_IMG_I (?,?,?,?);";

		$param[]  = $this->getP_COPY_CODE();
		$param[]  = $this->getPM_TYPE();
		$param[]  = $this->getPM_SAVE_NAME();
		$param[]  = $this->getPM_REAL_NAME();

		return $db->executeBindingQuery($query,$param,true);
	}

	function getProdIconInsert($db)
	{
		$query = "CALL SP_PRODUCT_ICON_I (?,?,?,?);";

		$param[]  = $this->getP_CODE();
		$param[]  = $this->getPC_TYPE();
		$param[]  = $this->getPC_USE();
		$param[]  = $this->getPC_IMG();

		return $db->executeBindingQuery($query,$param,true);
	}

	function getProdGrpInsert($db)
	{
		$query = "CALL SP_PRODUCT_GROUP_I (?,?);";

		$param[]  = $this->getP_CODE();
		$param[]  = $this->getPG_P_CODE();

		return $db->executeBindingQuery($query,$param,true);
	}


	function getProdBrandInsert($db)
	{
		$query = "CALL SP_PRODUCT_BRAND_I (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getPR_NO();
		$param[]  = $this->getPR_NAME();
		$param[]  = $this->getPR_LIST_IMG();
		$param[]  = $this->getPR_TITLE_IMG();
		$param[]  = $this->getPR_VIEW_IMG();
		$param[]  = $this->getPR_ADD_IMG();
		$param[]  = $this->getPR_COMMENT();
		$param[]  = $this->getPR_HTML();
		$param[]  = $this->getPR_TMP1();
		$param[]  = $this->getPR_TMP2();
		$param[]  = $this->getPR_TMP3();
		$param[]  = $this->getPR_M_NO();
		$param[]  = $this->getPR_ALIGN();
		$param[]  = $this->getPR_REG_DT();
		$param[]  = $this->getPR_REG_NO();
		$param[]  = $this->getPR_MOD_DT();
		$param[]  = $this->getPR_MOD_NO();

		return $db->executeBindingQuery($query,$param,true);
	}

	function getProdBrandLngInsert($db)
	{
			$param['PL_PR_NO']		= $this->getSQLInteger($this->getPL_PR_NO());
			$param['PL_LNG']		= $this->getSQLString($this->getPL_LNG());
			$param['PL_PR_HTML']	= $this->getSQLString($this->getPL_PR_HTML());

			return $db->getInsertParam(TBL_PRODUCT_BRAND_LNG, $param);
	}

	function getProdImgUpdateEx($db, $paramData)
	{
//		$param['PM_NO']			= $db->getSQLInteger($paramData['PM_NO']);
		$param['PM_SAVE_NAME']	= $db->getSQLString($paramData['PM_SAVE_NAME']);
		$param['PM_REAL_NAME']	= $db->getSQLString($paramData['PM_REAL_NAME']);

		if(!$paramData['P_CODE'] || !$paramData['PM_TYPE']) { return; }

		$p_code				= $db->getSQLString($paramData['P_CODE']);
		$p_type				= $db->getSQLString($paramData['PM_TYPE']);
		$where				= "PM_NO = {$p_code} AND PM_TYPE = {$p_type}";

		if(!$where)					{ return; }

		return $db->getUpdateParam("TBL_PRODUCT_IMG",$param, $where);
	}


	function getProdBrandLngUpdate($db)
	{
			$param['PL_PR_HTML']	= $this->getSQLString($this->getPL_PR_HTML());

			$where					= "PL_PR_NO = {$this->getPL_PR_NO()} AND PL_LNG = '{$this->getPL_LNG()}'";

			return $db->getUpdateParam(TBL_PRODUCT_BRAND_LNG, $param, $where);
	}

	function getProdBrandLngDelete($db)
	{
		$where					= "PL_PR_NO = {$this->getPL_PR_NO()}";

		$db->getDelete(TBL_PRODUCT_BRAND_LNG, $where);
	}

	// 상품 브랜드 특정 컬럼 업데이트
	function getProdBrandSelfUpdate($db, $key, $value, $intPR_NO)
	{
		$query = "UPDATE %s SET %s = '%s' WHERE PR_NO = %d";
		$query = sprintf($query, TBL_PRODUCT_BRAND, $key, $value, $intPR_NO);
		return $db->getExecSql($query);
	}

	/* 공유카테고리 설정 */
	function getProdShareInsert($db)
	{
		$query = "CALL SP_PRODUCT_SHARE_I (?,?);";

		$param[]  = $this->getP_CODE();
		$param[]  = $this->getP_CATE();

		return $db->executeBindingQuery($query,$param,true);
	}

	/* 사이트 이벤트 설정 */
	function getProdEventInsert($db)
	{
		$query = "CALL SP_SITE_EVENT_I (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getSE_TYPE();
		$param[]  = $this->getSE_TITLE();
		$param[]  = $this->getSE_DAY_TIME();
		$param[]  = $this->getSE_DAY_TYPE();
		$param[]  = $this->getSE_DAY();
		$param[]  = $this->getSE_START_DT();
		$param[]  = $this->getSE_END_DT();
		$param[]  = $this->getSE_PRICE();
		$param[]  = $this->getSE_PRICE_TYPE();
		$param[]  = $this->getSE_PRICE_OFF();
		$param[]  = $this->getSE_SELL_AUTH();
		$param[]  = $this->getSE_GIVE_POINT();
		$param[]  = $this->getSE_COUPON_USE();
		$param[]  = $this->getSE_DISCOUNT_USE();
		$param[]  = $this->getSE_MSG();
		$param[]  = $this->getSE_PRICE_MARK();
		$param[]  = $this->getSE_PRICE_TEXT();
		$param[]  = $this->getSE_REG_NO();
		return $db->executeBindingQuery($query,$param,true);
	}

	/* 고객사은품 등록 */
	function getGiftInsert($db)
	{
		$query = "CALL SP_CUS_GIFT_MGR_I (?,?,?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getCG_EACH_USE();
		$param[]  = $this->getCG_FIRST_GIFT();
		$param[]  = $this->getCG_QTY_USE();
		$param[]  = $this->getCG_ST_PRICE();
		$param[]  = $this->getCG_END_PRICE();
		$param[]  = $this->getCG_PRICE_TYPE();
		$param[]  = $this->getCG_STOCK();
		$param[]  = $this->getCG_QTY();
		$param[]  = $this->getCG_LIMIT();
		$param[]  = $this->getCG_LIMIT_QTY();
		$param[]  = $this->getCG_FILE();
		$param[]  = $this->getCG_VIEW();
		$param[]  = $this->getCG_REG_NO();

		return $db->executeBindingQuery($query,$param,true);
	}

	function getGiftLngInsert($db)
	{
		$query = "CALL SP_CUS_GIFT_LNG_I (?,?,?,?,?,?,?);";

		$param[]  = $this->getCG_NO();
		$param[]  = $this->getCG_LNG();
		$param[]  = $this->getCG_NAME();
		$param[]  = $this->getCG_OPT_NM1();
		$param[]  = $this->getCG_OPT_NM2();
		$param[]  = $this->getCG_OPT_ATTR1();
		$param[]  = $this->getCG_OPT_ATTR2();

		return $db->executeBindingQuery($query,$param,true);
	}

	/********************************** Modify **********************************/
	function getProdUpdate($db)
	{
		$query = "CALL SP_PRODUCT_MGR_U (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getP_CODE();
		$param[]  = $this->getP_NAME();
		$param[]  = $this->getP_CATE();
		$param[]  = $this->getP_NUM();
		$param[]  = $this->getP_MAKER();
		$param[]  = $this->getP_ORIGIN();
		$param[]  = $this->getP_BRAND();
		$param[]  = $this->getP_MODEL();
		$param[]  = $this->getP_LAUNCH_DT();
		$param[]  = $this->getP_WEB_VIEW();
		$param[]  = $this->getP_MOB_VIEW();
		$param[]  = $this->getP_REP_DT();
		$param[]  = $this->getP_ORDER();
		$param[]  = $this->getP_SALE_PRICE();
		$param[]  = $this->getP_CONSUMER_PRICE();
		$param[]  = $this->getP_STOCK_PRICE();
		$param[]  = $this->getP_PRICE_FILTER();
		$param[]  = $this->getP_PRICE_UNIT();
		$param[]  = $this->getP_CAS_NO();
		$param[]  = $this->getP_OTHER_NAMES();
		$param[]  = $this->getP_TYPE();
		$param[]  = $this->getP_POINT();
		$param[]  = $this->getP_POINT_TYPE();
		$param[]  = $this->getP_POINT_OFF1();
		$param[]  = $this->getP_POINT_OFF2();
		$param[]  = $this->getP_QTY();
		$param[]  = $this->getP_STOCK_OUT();
		$param[]  = $this->getP_RESTOCK();
		$param[]  = $this->getP_STOCK_LIMIT();
		$param[]  = $this->getP_MIN_QTY();
		$param[]  = $this->getP_MAX_QTY();
		$param[]  = $this->getP_SAIL_UNIT();
		$param[]  = $this->getP_TAX();
		$param[]  = $this->getP_OPT();
		$param[]  = $this->getP_ADD_OPT();
		$param[]  = $this->getP_BAESONG_TYPE();
		$param[]  = $this->getP_BAESONG_PRICE();
		$param[]  = $this->getP_WEIGHT();
		$param[]  = $this->getP_ST_SIZE();
		$param[]  = $this->getP_LIST_ICON_VIEW();
		$param[]  = $this->getP_LIST_ICON_ST();
		$param[]  = $this->getP_LIST_ICON_ET();
		$param[]  = $this->getP_MOD_NO();

		return $db->executeBindingQuery($query,$param,true);

	}

	function getProdPriceTextUpdate($db) {

		$query  = "UPDATE ".TBL_PRODUCT_MGR." SET ";
		$query .= "P_PRICE_TEXT		= '{$this->getP_PRICE_TEXT()}' ";
		$query .= "WHERE P_CODE		= '".$this->getP_CODE()."'	";

		$db->getExecSql($query);
	}

	function getProdAllUpdate($db)
	{
		$query  = "UPDATE ".TBL_PRODUCT_MGR." SET ";
		$query .= "	 P_SALE_PRICE		= ".$this->getP_SALE_PRICE();
		$query .= "	,P_CONSUMER_PRICE	= ".$this->getP_CONSUMER_PRICE();
		$query .= "	,P_STOCK_PRICE		= ".$this->getP_STOCK_PRICE();
		$query .= "	,P_POINT			= ".$this->getP_POINT();
		$query .= "	,P_QTY				= ".$this->getP_QTY();
		$query .= " WHERE P_CODE		= '".$this->getP_CODE()."'	";

		$db->getExecSql($query);
	}

	//상품승인처리 2015.05.27 kjp
	function getProdApprUpdate($db)
	{
		$query  = "UPDATE ".TBL_PRODUCT_MGR." SET ";
		$query .= "	 P_APPR		= '".$this->getP_APPR()."'";
		$query .= " WHERE P_CODE		= '".$this->getP_CODE()."'	";
		$db->getExecSql($query);
	}


	function getProdInfoUpdate($db)
	{
		if(!$this->getP_CODE()) { return; }

		$param['P_CODE']			= $this->getSQLString($this->getP_CODE());
		$param['P_NAME']			= $this->getSQLString($this->getP_NAME());
		$param['P_SEARCH_TEXT']		= $this->getSQLString($this->getP_SEARCH_TEXT());
		$param['P_WEB_TEXT']		= $this->getSQLString($this->getP_WEB_TEXT());
		$param['P_MOB_TEXT']		= $this->getSQLString($this->getP_MOB_TEXT());
		$param['P_MEMO']			= $this->getSQLString($this->getP_MEMO());
		$param['P_DELIVERY_TEXT']	= $this->getSQLString($this->getP_DELIVERY_TEXT());
		$param['P_RETURN_TEXT']		= $this->getSQLString($this->getP_RETURN_TEXT());
		$param['P_ETC']				= $this->getSQLString($this->getP_ETC());
		$param['P_PRICE_TEXT']		= $this->getSQLString($this->getP_PRICE_TEXT());
		$param['P_WEB_VIEW']		= $this->getSQLString($this->getP_WEB_VIEW());
		$param['P_MOB_VIEW']		= $this->getSQLString($this->getP_MOB_VIEW());

		$where						= "P_CODE = '".$this->getP_CODE()."' ";
		if(!$where)					{ return; }

		return $db->getUpdateParam("PRODUCT_INFO_".$this->getP_LNG(), $param, $where);


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


	function getProdItemUpdate($db,$paramData = "")
	{
		global $S_SHOP_PROD_ADD_ITEM_VERSION;

		$param['PI_ORDER']		= $this->getSQLInteger($this->getPI_ORDER());

		if ($S_SHOP_PROD_ADD_ITEM_VERSION == "V2.O"){
			$param['PI_TYPE']  = $this->getSQLString($paramData['PI_TYPE']);
		}

		$where					= "PI_NO = ".$this->getPI_NO()." ";
		$result					= $db->getUpdateParam("PRODUCT_ITEM", $param, $where);
		if ($result){

			$param				= "";
			$param['PI_NAME']	= $this->getSQLString($this->getPI_NAME());
			$param['PI_TEXT']	= $this->getSQLString($this->getPI_TEXT());
			$where				= "PI_NO = ".$this->getPI_NO()." ";
			$result				= $db->getUpdateParam("PRODUCT_ITEM_".$this->getPI_LNG(), $param, $where);
		}

		return $result;

//		$query = "CALL SP_PRODUCT_ITEM_U (?,?,?,?,?,?);";
//
//		$param[]  = $this->getPI_NO();
//		$param[]  = $this->getP_CODE();
//		$param[]  = $this->getPI_LNG();
//		$param[]  = $this->getPI_NAME();
//		$param[]  = $this->getPI_TEXT();
//		$param[]  = $this->getPI_ORDER();
//
//		return $db->executeBindingQuery($query,$param,true);
	}

	function getProdOptUpdate($db)
	{
		$param['PO_ESS']		= $this->getSQLString($this->getPO_ESS());
		$where					= "PO_NO = ".$this->getPO_NO()." ";
		$result					= $db->getUpdateParam("PRODUCT_OPT", $param, $where);
		if ($result){

			$param				= "";
			$param['PO_NAME1']	= $this->getSQLString($this->getPO_NAME1());
			$param['PO_NAME2']	= $this->getSQLString($this->getPO_NAME2());
			$param['PO_NAME3']	= $this->getSQLString($this->getPO_NAME3());
			$param['PO_NAME4']	= $this->getSQLString($this->getPO_NAME4());
			$param['PO_NAME5']	= $this->getSQLString($this->getPO_NAME5());
			$param['PO_NAME6']	= $this->getSQLString($this->getPO_NAME6());
			$param['PO_NAME7']	= $this->getSQLString($this->getPO_NAME7());
			$param['PO_NAME8']	= $this->getSQLString($this->getPO_NAME8());
			$param['PO_NAME9']	= $this->getSQLString($this->getPO_NAME9());
			$param['PO_NAME10']	= $this->getSQLString($this->getPO_NAME10());
			$where				= "PO_NO = ".$this->getPO_NO()." ";

			$result				= $db->getUpdateParam("PRODUCT_OPT_".$this->getP_LNG(), $param, $where);
		}

		return $result;

//		$query = "CALL SP_PRODUCT_OPT_U (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
//
//		$param[]  = $this->getP_LNG();
//		$param[]  = $this->getPO_NO();
//		$param[]  = $this->getP_CODE();
//		$param[]  = $this->getPO_NAME1();
//		$param[]  = $this->getPO_NAME2();
//		$param[]  = $this->getPO_NAME3();
//		$param[]  = $this->getPO_NAME4();
//		$param[]  = $this->getPO_NAME5();
//		$param[]  = $this->getPO_NAME6();
//		$param[]  = $this->getPO_NAME7();
//		$param[]  = $this->getPO_NAME8();
//		$param[]  = $this->getPO_NAME9();
//		$param[]  = $this->getPO_NAME10();
//		$param[]  = $this->getPO_TYPE();
//		$param[]  = $this->getPO_ESS();
//
//		return $db->executeBindingQuery($query,$param,true);
	}

	function getProdOptAttrUpdate($db)
	{
		$param['POA_SALE_PRICE']		= $this->getSQLInteger($this->getPOA_SALE_PRICE());
		$param['POA_CONSUMER_PRICE']	= $this->getSQLInteger($this->getPOA_CONSUMER_PRICE());
		$param['POA_STOCK_PRICE']		= $this->getSQLInteger($this->getPOA_STOCK_PRICE());
		$param['POA_POINT']				= $this->getSQLInteger($this->getPOA_POINT());
		$param['POA_STOCK_QTY']			= $this->getSQLInteger($this->getPOA_STOCK_QTY());
		$where							= "POA_NO = ".$this->getPOA_NO()." ";
		$result							= $db->getUpdateParam("PRODUCT_OPT_ATTR", $param, $where);

		if ($result){

			$param					= "";
			$param['POA_ATTR1']		= $this->getSQLString($this->getPOA_ATTR1());
			$param['POA_ATTR2']		= $this->getSQLString($this->getPOA_ATTR2());
			$param['POA_ATTR3']		= $this->getSQLString($this->getPOA_ATTR3());
			$param['POA_ATTR4']		= $this->getSQLString($this->getPOA_ATTR4());
			$param['POA_ATTR5']		= $this->getSQLString($this->getPOA_ATTR5());
			$param['POA_ATTR6']		= $this->getSQLString($this->getPOA_ATTR6());
			$param['POA_ATTR7']		= $this->getSQLString($this->getPOA_ATTR7());
			$param['POA_ATTR8']		= $this->getSQLString($this->getPOA_ATTR8());
			$param['POA_ATTR9']		= $this->getSQLString($this->getPOA_ATTR9());
			$param['POA_ATTR10']	= $this->getSQLString($this->getPOA_ATTR10());
			$where					= "POA_NO = ".$this->getPOA_NO()." ";
			$result					= $db->getUpdateParam("PRODUCT_OPT_ATTR_".$this->getP_LNG(), $param, $where);
		}

		return $result;

//		$query = "CALL SP_PRODUCT_OPT_ATTR_U (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
//
//		$param[]  = $this->getP_LNG();
//		$param[]  = $this->getPOA_NO();
//		$param[]  = $this->getPO_NO();
//		$param[]  = $this->getPOA_ATTR1();
//		$param[]  = $this->getPOA_ATTR2();
//		$param[]  = $this->getPOA_ATTR3();
//		$param[]  = $this->getPOA_ATTR4();
//		$param[]  = $this->getPOA_ATTR5();
//		$param[]  = $this->getPOA_ATTR6();
//		$param[]  = $this->getPOA_ATTR7();
//		$param[]  = $this->getPOA_ATTR8();
//		$param[]  = $this->getPOA_ATTR9();
//		$param[]  = $this->getPOA_ATTR10();
//		$param[]  = $this->getPOA_SALE_PRICE();
//		$param[]  = $this->getPOA_CONSUMER_PRICE();
//		$param[]  = $this->getPOA_STOCK_PRICE();
//		$param[]  = $this->getPOA_POINT();
//		$param[]  = $this->getPOA_STOCK_QTY();
//
//		return $db->executeBindingQuery($query,$param,true);
	}

	function getProdAddOptUpdate($db)
	{
		$param['PAO_PRICE']		= $this->getSQLInteger($this->getPAO_PRICE());
		$where					= "PAO_NO = ".$this->getPAO_NO()." ";
		$result					= $db->getUpdateParam("PRODUCT_ADD_OPT", $param, $where);

		if ($result)
		{
			$query				= "SELECT COUNT(*) FROM PRODUCT_ADD_OPT_".$this->getP_LNG()." WHERE PAO_NO = ".$this->getPAO_NO();
			$intCount			= $db->getCount($query);

			if ($intCount > 0){
				$param				= "";
				$param['PAO_NAME']	= $this->getSQLString($this->getPAO_NAME());
				$where				= "PAO_NO = ".$this->getPAO_NO()." ";
				$result				= $db->getUpdateParam("PRODUCT_ADD_OPT_".$this->getP_LNG(), $param, $where);
			} else {
				$param				= "";
				$param['PAO_NO']	= $this->getSQLInteger($this->getPAO_NO());
				$param['PAO_NAME']	= $this->getSQLString($this->getPAO_NAME());
				$result				= $db->getInsertParam("PRODUCT_ADD_OPT_".$this->getP_LNG(), $param);
			}
		}
		return $result;

//		$query = "CALL SP_PRODUCT_ADD_OPT_U (?,?,?,?,?);";
//		$param[]  = $this->getP_LNG();
//		$param[]  = $this->getPAO_NO();
//		$param[]  = $this->getPO_NO();
//		$param[]  = $this->getPAO_NAME();
//		$param[]  = $this->getPAO_PRICE();
//
//		return $db->executeBindingQuery($query,$param,true);
	}


	function getProdIconUpdate($db)
	{
		$query = "CALL SP_PRODUCT_ICON_U (?,?,?,?);";

		$param[]  = $this->getP_CODE();
		$param[]  = $this->getPC_TYPE();
		$param[]  = $this->getPC_USE();
		$param[]  = $this->getPC_IMG();

		return $db->executeBindingQuery($query,$param,true);
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

	function getProdStockQtyUpdate($db)
	{
		$query  = "UPDATE ".TBL_PRODUCT_MGR." SET P_QTY = ".$this->getP_QTY();
		$query .= "	,P_STOCK_OUT	= '".$this->getP_STOCK_OUT()."'";
		$query .= "	,P_RESTOCK		= '".$this->getP_RESTOCK()."'";
		$query .= "	,P_STOCK_LIMIT	= '".$this->getP_STOCK_LIMIT()."'";
		$query .= "	WHERE P_CODE = '".$this->getP_CODE()."'";

		return $db->getExecSql($query);
	}

	function getProdStockStatusOUpdate($db)
	{
		$query  = "UPDATE ".TBL_PRODUCT_MGR." SET ";
		if ($this->getP_STOCK_OUT() == "Y") {
			$query .= "P_STOCK_OUT	= '".$this->getP_STOCK_OUT()."'";
			$query .= ",P_RESTOCK	= 'N'";
			$query .= ",P_STOCK_LIMIT = 'N'";
			$query .= ",P_QTY = 0 ";
		}
		if ($this->getP_RESTOCK() == "Y") {
			$query .= "P_RESTOCK	= '".$this->getP_RESTOCK()."'";
			$query .= ",P_STOCK_OUT	= 'N'";
			$query .= ",P_STOCK_LIMIT = 'N'";
		}
		if ($this->getP_STOCK_LIMIT() == "Y") {
			$query .= "P_STOCK_LIMIT	= '".$this->getP_STOCK_LIMIT()."'";
			$query .= ",P_QTY = 0 ";
			$query .= ",P_STOCK_OUT	= 'N'";
			$query .= ",P_RESTOCK = 'N'";
		}
		$query .= "	WHERE P_CODE = '".$this->getP_CODE()."'";

		return $db->getExecSql($query);
	}

	function getProdViewStatusUpdate($db)
	{
		global $a_admin_no;
		$query  = "UPDATE ".TBL_PRODUCT_MGR." SET P_WEB_VIEW = '".$this->getP_WEB_VIEW()."'";
		$query .= " ,P_MOD_DT = NOW()	";
		$query .= " ,P_MOD_NO = '".$a_admin_no."'	";
		$query .= "	WHERE P_CODE = '".$this->getP_CODE()."'";
		return $db->getExecSql($query);
	}

	function getProdMobileViewStatusUpdate($db)
	{
		global $a_admin_no;
		$query  = "UPDATE ".TBL_PRODUCT_MGR." SET P_MOB_VIEW = '".$this->getP_MOB_VIEW()."'";
		$query .= " ,P_MOD_DT = NOW()	";
		$query .= " ,P_MOD_NO = '".$a_admin_no."'	";
		$query .= "	WHERE P_CODE = '".$this->getP_CODE()."'";
		return $db->getExecSql($query);
	}

	function getProdBrandUpdate($db)
	{
		$query = "CALL SP_PRODUCT_BRAND_U (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getPR_NO();
		$param[]  = $this->getPR_NAME();
		$param[]  = $this->getPR_LIST_IMG();
		$param[]  = $this->getPR_TITLE_IMG();
		$param[]  = $this->getPR_VIEW_IMG();
		$param[]  = $this->getPR_ADD_IMG();
		$param[]  = $this->getPR_COMMENT();
		$param[]  = $this->getPR_HTML();
		$param[]  = $this->getPR_TMP1();
		$param[]  = $this->getPR_TMP2();
		$param[]  = $this->getPR_TMP3();
		$param[]  = $this->getPR_M_NO();
		$param[]  = $this->getPR_ALIGN();
		$param[]  = $this->getPR_REG_DT();
		$param[]  = $this->getPR_REG_NO();
		$param[]  = $this->getPR_MOD_DT();
		$param[]  = $this->getPR_MOD_NO();

		return $db->executeBindingQuery($query,$param,true);
	}

	function getProdListIconUpdate($db)
	{
		$query  = "UPDATE ".TBL_PRODUCT_MGR." SET P_LIST_ICON = '".mysql_real_escape_string($this->getP_LIST_ICON())."'";
		$query .= "	WHERE P_CODE = '".$this->getP_CODE()."'";

		return $db->getExecSql($query);
	}

	function getProdDisplayIconUpdate($db)
	{
		$query  = "UPDATE ".TBL_PRODUCT_MGR." SET ";
		$query .= "	 P_ICON = '".mysql_real_escape_string($this->getP_ICON())."'";
		$query .= "	WHERE P_CODE = '".$this->getP_CODE()."'";

		return $db->getExecSql($query);
	}

	function getProdCateUpdate($db)
	{
		$query  = "UPDATE ".TBL_PRODUCT_MGR." SET ";
		$query .= "	 P_CATE = '".mysql_real_escape_string($this->getP_CATE())."'";
		$query .= "	WHERE P_CODE = '".$this->getP_CODE()."'";

		return $db->getExecSql($query);
	}

	/* 사이트 이벤트 설정 */
	function getProdEventUpdate($db)
	{
		$query = "CALL SP_SITE_EVENT_U (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getSE_NO();
		$param[]  = $this->getSE_TYPE();
		$param[]  = $this->getSE_TITLE();
		$param[]  = $this->getSE_DAY_TIME();
		$param[]  = $this->getSE_DAY_TYPE();
		$param[]  = $this->getSE_DAY();
		$param[]  = $this->getSE_START_DT();
		$param[]  = $this->getSE_END_DT();
		$param[]  = $this->getSE_PRICE();
		$param[]  = $this->getSE_PRICE_TYPE();
		$param[]  = $this->getSE_PRICE_OFF();
		$param[]  = $this->getSE_SELL_AUTH();
		$param[]  = $this->getSE_GIVE_POINT();
		$param[]  = $this->getSE_COUPON_USE();
		$param[]  = $this->getSE_DISCOUNT_USE();
		$param[]  = $this->getSE_MSG();
		$param[]  = $this->getSE_PRICE_MARK();
		$param[]  = $this->getSE_PRICE_TEXT();
		$param[]  = $this->getSE_MOD_NO();

		return $db->executeBindingQuery($query,$param,true);
	}

	/* 사이트 이벤트 상품 설정 */
	function getProdEventProdApply($db)
	{
		$query  = "UPDATE ".TBL_PRODUCT_MGR." SET ";
		$query .= "	 P_EVENT = '".mysql_real_escape_string($this->getP_EVENT())."'";
		$query .= "	WHERE P_CODE = '".$this->getP_CODE()."'";

		return $db->getExecSql($query);
	}

	/* 사은품 수정 */
	function getGiftUpdate($db)
	{
		$query = "CALL SP_CUS_GIFT_MGR_U (?,?,?,?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getCG_NO();
		$param[]  = $this->getCG_EACH_USE();
		$param[]  = $this->getCG_FIRST_GIFT();
		$param[]  = $this->getCG_QTY_USE();
		$param[]  = $this->getCG_ST_PRICE();
		$param[]  = $this->getCG_END_PRICE();
		$param[]  = $this->getCG_PRICE_TYPE();
		$param[]  = $this->getCG_STOCK();
		$param[]  = $this->getCG_QTY();
		$param[]  = $this->getCG_LIMIT();
		$param[]  = $this->getCG_LIMIT_QTY();
		$param[]  = $this->getCG_FILE();
		$param[]  = $this->getCG_VIEW();
		$param[]  = $this->getCG_MOD_NO();

		return $db->executeBindingQuery($query,$param,true);
	}

	function getGiftLngUpdate($db)
	{
		$query = "CALL SP_CUS_GIFT_LNG_U (?,?,?,?,?,?,?);";

		$param[]  = $this->getCG_NO();
		$param[]  = $this->getCG_LNG();
		$param[]  = $this->getCG_NAME();
		$param[]  = $this->getCG_OPT_NM1();
		$param[]  = $this->getCG_OPT_NM2();
		$param[]  = $this->getCG_OPT_ATTR1();
		$param[]  = $this->getCG_OPT_ATTR2();

		return $db->executeBindingQuery($query,$param,true);
	}

	function getGiftFileUpdate($db)
	{
		$query = "UPDATE ".TBL_GIFT_MGR." SET CG_FILE = NULL WHERE CG_NO = ".$this->getCG_NO();
		return $db->getExecSql($query);
	}

	function getProdGiftProdApply($db)
	{
		$query = "CALL SP_CUS_GIFT_PROD_A (?,?);";

		$param[]  = $this->getCG_NO();
		$param[]  = $this->getP_CODE();

		return $db->executeBindingQuery($query,$param,true);
	}


	/* 상품 컬러 update */
	function getProdColorUpdate($db)
	{
		$query = "UPDATE ".TBL_PRODUCT_MGR." SET P_COLOR = '".$this->getP_COLOR()."' WHERE P_CODE = '".$this->getP_CODE()."'";
		return $db->getExecSql($query);
	}

	function getProdSizeUpdate($db)
	{
		$query = "UPDATE ".TBL_PRODUCT_MGR." SET P_SIZE = '".$this->getP_SIZE()."' WHERE P_CODE = '".$this->getP_CODE()."'";
		return $db->getExecSql($query);
	}

	/* 상품포인트 사용불가 update */
	function getProdPointNoUseUpdate($db)
	{
		$query = "UPDATE ".TBL_PRODUCT_MGR." SET P_POINT_NO_USE = '".$this->getP_POINT_NO_USE()."' WHERE P_CODE = '".$this->getP_CODE()."'";
		return $db->getExecSql($query);
	}

	/********************************** Delete **********************************/
	function getProdDelete($db)
	{
		$query  = "DELETE FROM ".TBL_PRODUCT_MGR;
		$query .= "	WHERE P_CODE = '".$this->getP_CODE()."'";

		return $db->getExecSql($query);
	}

	function getProdInfoLngDelete($db)
	{
		$query  = "DELETE FROM ".TBL_PRODUCT_INFO_LNG.$this->getP_LNG();
		$query .= "	WHERE P_CODE = '".$this->getP_CODE()."'";

		return $db->getExecSql($query);
	}

	function getProdItemLngDelete($db)
	{

		$query  = "DELETE FROM ".TBL_PRODUCT_ITEM_LNG.$this->getPI_LNG();
		$query .= "	WHERE PI_NO IN ( ";
		$query .= "		SELECT PI_NO FROM ".TBL_PRODUCT_ITEM." WHERE P_CODE = '".$this->getP_CODE()."'";

		if ($this->getPI_NO_ALL()){
			$query .= "			AND PI_NO NOT IN (".$this->getPI_NO_ALL().")";
		}
		$query .= "		) ";

		$db->getExecSql($query);

		return true;
	}

	function getProdItemAllDelete($db)
	{
		$query  = "DELETE FROM ".TBL_PRODUCT_ITEM;
		$query .= "	WHERE P_CODE = '".$this->getP_CODE()."'";

		if ($this->getPI_NO_ALL()){
			$query .= "		AND PI_NO NOT IN (".$this->getPI_NO_ALL().")";
		}

		return $db->getExecSql($query);
	}

	function getProdOptAllDelete($db)
	{
		$query  = "DELETE FROM ".TBL_PRODUCT_OPT;
		$query .= "	WHERE P_CODE = '".$this->getP_CODE()."'";
		$query .= "		AND PO_TYPE = '".$this->getPO_TYPE()."'";

		if ($this->getPO_NO_ALL()){
			$query .= "		AND PO_NO NOT IN (".$this->getPO_NO_ALL().")";
		}

		return $db->getExecSql($query);
	}

	function getProdOptLangAllDelete($db)
	{
		$query  = "DELETE FROM ".TBL_PRODUCT_OPT_LNG.$this->getP_LNG();
		$query .= "	WHERE PO_NO IN ( ";
		$query .= "		SELECT PO_NO FROM ".TBL_PRODUCT_OPT." WHERE P_CODE = '".$this->getP_CODE()."'";
		$query .= "     AND PO_TYPE = '".$this->getPO_TYPE()."'";

		if ($this->getPO_NO_ALL()){
			$query .= "			AND PO_NO NOT IN (".$this->getPO_NO_ALL().")";
		}
		$query .= "		) ";

		$db->getExecSql($query);
		return true;
	}

	function getProdOptAttrAllDelete($db)
	{
		$query  = "DELETE FROM ".TBL_PRODUCT_OPT_ATTR;
		$query .= "	WHERE PO_NO = ".$this->getPO_NO()." ";

		if ($this->getPOA_NO_ALL()){
			$query .= "		AND POA_NO NOT IN (".$this->getPOA_NO_ALL().")";
		}

		return $db->getExecSql($query);
	}

	function getProdOptAttrLangAllDelete($db)
	{
		$query  = "DELETE FROM ".TBL_PRODUCT_OPT_ATTR_LNG.$this->getP_LNG();
		$query .= "	WHERE POA_NO IN ( ";
		$query .= "		SELECT POA_NO FROM ".TBL_PRODUCT_OPT_ATTR." WHERE PO_NO = ".$this->getPO_NO();
		if ($this->getPOA_NO_ALL()){
			$query .= "			AND POA_NO NOT IN (".$this->getPOA_NO_ALL().")";
		}
		$query .= "		) ";

		$db->getExecSql($query);

		return true;
	}

	function getProdAddOptAllDelete($db)
	{
		$query  = "DELETE FROM ".TBL_PRODUCT_ADD_OPT;
		$query .= "	WHERE PO_NO = ".$this->getPO_NO()." ";

		if ($this->getPAO_NO_ALL()){
			$query .= "		AND PAO_NO NOT IN (".$this->getPAO_NO_ALL().")";
		}

		return $db->getExecSql($query);
	}

	function getProdAddOptAttrLangAllDelete($db)
	{
		$query  = "DELETE FROM ".TBL_PRODUCT_ADD_OPT_LNG.$this->getP_LNG();
		$query .= "	WHERE PAO_NO IN ( ";
		$query .= "		SELECT PAO_NO FROM ".TBL_PRODUCT_ADD_OPT." WHERE PO_NO = ".$this->getPO_NO();
		if ($this->getPAO_NO_ALL()){
			$query .= "			AND PAO_NO NOT IN (".$this->getPAO_NO_ALL().")";
		}
		$query .= "		) ";

		$db->getExecSql($query);

		return true;
	}


	function getProdImgDelete($db)
	{
		$query = "DELETE FROM ".TBL_PRODUCT_IMG." WHERE PM_NO = ".$this->getPM_NO();
		return $db->getExecSql($query);
	}

	function getProdImgAllDelete($db)
	{
		$query = "DELETE FROM ".TBL_PRODUCT_IMG." WHERE PC_CODE = '".$this->getPC_CODE()."'";
		return $db->getExecSql($query);
	}

	function getProdIconAllDelete($db)
	{
		$query = "DELETE FROM ".TBL_PRODUCT_ICON." WHERE P_CODE = '".$this->getP_CODE()."'";
		return $db->getExecSql($query);
	}

	function getProdGrpAllDelete($db)
	{
		$query  = "DELETE FROM ".TBL_PRODUCT_GRP;
		$query .= "	WHERE P_CODE = '".$this->getP_CODE()."' ";

		if ($this->getPG_NO_ALL()){
			$query .= "		AND PG_NO NOT IN (".$this->getPG_NO_ALL().")";
		}

		return $db->getExecSql($query);
	}


	function getProductBasketAddDelete($db)
	{
		$query = "DELETE FROM ".TBL_PRODUCT_BASKET_ADD." WHERE PB_NO = ".$this->getPB_NO();
		return $db->getExecSql($query);
	}

	function getProductBasketDelete($db)
	{
		$query = "DELETE FROM ".TBL_PRODUCT_BASKET." WHERE PB_NO = ".$this->getPB_NO();
		return $db->getExecSql($query);
	}

	function getProdBrandDelete($db)
	{
		$query = "CALL SP_PRODUCT_BRAND_D (?);";
		$param[]  = $this->getPR_NO();

		return $db->executeBindingQuery($query,$param,true);
	}

	/* 공유 카테고리 상품 삭제 */
	function getProdShareAllDelete($db)
	{
		$query  = "DELETE FROM ".TBL_PRODUCT_SHARE;
		$query .= "	WHERE PS_NO IS NOT NULL	";

		if ($this->getPS_NO_ALL()){
			$query .= "		AND PS_NO NOT IN (".$this->getPS_NO_ALL().")";
		}

		return $db->getExecSql($query);
	}


	/* 사이트 이벤트 설정 삭제 */
	function getProdEventDelete($db)
	{
		$query = "CALL SP_SITE_EVENT_D (?);";
		$param[]  = $this->getSE_NO();

		return $db->executeBindingQuery($query,$param,true);
	}

	/* 사이트 이벤트 설정 상품 삭제 */
	function getProdEventProductDelete($db)
	{
		$query = "UPDATE ".TBL_PRODUCT_MGR." SET P_EVENT = NULL WHERE P_CODE = '".$this->getP_CODE()."'";
		return $db->getExecSql($query);
	}

	function getProdEventProductAllDelete($db)
	{
		$query = "UPDATE ".TBL_PRODUCT_MGR." SET P_EVENT = NULL WHERE P_EVENT = '".$this->getSE_NO()."'";
		return $db->getExecSql($query);
	}

	/* 사은품 삭제 */
	function getGiftDelete($db)
	{
		$query = "CALL SP_CUS_GIFT_MGR_D (?);";
		$param[]  = $this->getCG_NO();

		return $db->executeBindingQuery($query,$param,true);
	}

	/* 사은품 설정 상품 삭제 */
	function getProdGitfProductDelete($db)
	{
		$query  = "DELETE FROM  ".TBL_PRODUCT_GIFT." WHERE P_CODE = '".$this->getP_CODE()."'";
		$query .= "	AND CG_NO = ".$this->getCG_NO();

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

	function getProductWishDelete($db)
	{
		$query = "DELETE FROM ".TBL_PRODUCT_WISH." WHERE PW_NO = ".$this->getPW_NO();
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

	/********************************** Wish No **********************************/
	function getProductWishNo($db)
	{
		$query   = "SELECT PW_NO FROM ".TBL_PRODUCT_WISH."			";
		$query  .= "WHERE M_NO			=  ".$this->getM_NO();
		$query  .= "	AND P_CODE		= '".$this->getP_CODE()."'	";
		$query  .= "    AND PW_OPT_NO	=  ".$this->getPW_OPT_NO();
		return $db->getCount($query);
	}

	/********************************** Product Copy **********************************/
	function getProdCopyInsert2($db)
	{
		$query  = "INSERT INTO PRODUCT_MGR                             ";
		$query .= "    (                                               ";
		$query .= "       P_CODE                                       ";
		$query .= "      ,P_NAME                                       ";
		$query .= "      ,P_CATE                                       ";
		$query .= "      ,P_NUM                                        ";
		$query .= "      ,P_MAKER                                      ";
		$query .= "      ,P_ORIGIN                                     ";
		$query .= "      ,P_BRAND                                      ";
		$query .= "      ,P_MODEL                                      ";
		$query .= "      ,P_LAUNCH_DT                                  ";
		$query .= "      ,P_WEB_VIEW                                   ";
		$query .= "      ,P_MOB_VIEW                                   ";
		$query .= "      ,P_REP_DT                                     ";
		$query .= "      ,P_ORDER                                      ";
		$query .= "      ,P_SALE_PRICE                                 ";
		$query .= "      ,P_CONSUMER_PRICE                             ";
		$query .= "      ,P_STOCK_PRICE                                ";
		$query .= "      ,P_PRICE_FILTER                               ";
		$query .= "      ,P_OTHER_NAMES                                ";
		$query .= "      ,P_TYPE		                               ";
		$query .= "      ,P_POINT                                      ";
		$query .= "      ,P_POINT_TYPE                                 ";
		$query .= "      ,P_POINT_OFF1                                 ";
		$query .= "      ,P_POINT_OFF2                                 ";
		$query .= "      ,P_QTY                                        ";
		$query .= "      ,P_STOCK_OUT                                  ";
		$query .= "      ,P_RESTOCK                                    ";
		$query .= "      ,P_STOCK_LIMIT                                ";
		$query .= "      ,P_MIN_QTY                                    ";
		$query .= "      ,P_MAX_QTY                                    ";
		$query .= "      ,P_TAX                                        ";
		$query .= "      ,P_PRICE_TEXT                                 ";
		$query .= "      ,P_OPT                                        ";
		$query .= "      ,P_ADD_OPT                                    ";
		$query .= "      ,P_BAESONG_TYPE                               ";
		$query .= "      ,P_BAESONG_PRICE                              ";
		$query .= "      ,P_BAESONG_QTY                                ";
		$query .= "      ,P_WEIGHT                                     ";
		$query .= "      ,P_SHOP_NO                                    ";
		$query .= "      ,P_POINT_NO_USE                               ";
		$query .= "      ,P_COLOR									   ";
		$query .= "      ,P_SIZE									   ";
		$query .= "      ,P_REG_DT                                     ";
		$query .= "      ,P_REG_NO                                     ";
		$query .= "    )                                               ";
		$query .= "    SELECT                                          ";
		$query .= "       '".$this->getP_COPY_CODE()."'                ";
		$query .= "      ,P_NAME                                       ";
		$query .= "      ,'".$this->getP_CATE()."'                     ";
		$query .= "      ,''                                           ";
		$query .= "      ,P_MAKER                                      ";
		$query .= "      ,P_ORIGIN                                     ";
		$query .= "      ,P_BRAND                                      ";
		$query .= "      ,P_MODEL                                      ";
		$query .= "      ,DATE_FORMAT(P_LAUNCH_DT,'%Y-%m-%d 00:00:00')";
		$query .= "      ,P_WEB_VIEW                                   ";
		$query .= "      ,P_MOB_VIEW                                   ";
		$query .= "      ,DATE_FORMAT(P_REP_DT,'%Y-%m-%d 00:00:00')    ";
		$query .= "      ,P_ORDER                                      ";
		$query .= "      ,P_SALE_PRICE                                 ";
		$query .= "      ,P_CONSUMER_PRICE                             ";
		$query .= "      ,P_STOCK_PRICE                                ";
		$query .= "      ,P_PRICE_FILTER                               ";
		$query .= "      ,P_OTHER_NAMES                                ";
		$query .= "      ,P_TYPE		                               ";
		$query .= "      ,P_POINT                                      ";
		$query .= "      ,P_POINT_TYPE                                 ";
		$query .= "      ,P_POINT_OFF1                                 ";
		$query .= "      ,P_POINT_OFF2                                 ";
		$query .= "      ,P_QTY                                        ";
		$query .= "      ,P_STOCK_OUT                                  ";
		$query .= "      ,P_RESTOCK                                    ";
		$query .= "      ,P_STOCK_LIMIT                                ";
		$query .= "      ,P_MIN_QTY                                    ";
		$query .= "      ,P_MAX_QTY                                    ";
		$query .= "      ,P_TAX                                        ";
		$query .= "      ,P_PRICE_TEXT                                 ";
		$query .= "      ,P_OPT                                        ";
		$query .= "      ,P_ADD_OPT                                    ";
		$query .= "      ,P_BAESONG_TYPE                               ";
		$query .= "      ,P_BAESONG_PRICE                              ";
		$query .= "      ,P_BAESONG_QTY                                ";
		$query .= "      ,P_WEIGHT                                     ";
		$query .= "      ,P_SHOP_NO                                    ";
		$query .= "      ,P_POINT_NO_USE                               ";
		$query .= "      ,P_COLOR									   ";
		$query .= "      ,P_SIZE									   ";
		$query .= "      ,NOW()                                        ";
		$query .= "      ,".$this->getP_REG_NO()."                     ";
		$query .= "    FROM PRODUCT_MGR                                ";
		$query .= "    WHERE P_CODE = '".$this->getP_CODE()."'		   ";
		//echo $query;exit;
		return $db->getExecSql($query);
	}

	function getProdInfoSelectEx($db)
	{
		$query = "SELECT * FROM ".TBL_PRODUCT_INFO_LNG.$this->getP_LNG()." WHERE P_CODE = '".$this->getP_CODE()."'	";
		return $db->getSelect($query);
	}

	function getProdCopyInsert($db)
	{
		$query = "CALL SP_PRODUCT_MGR_COPY_I (?,?,?,?);";

		$param[]  = $this->getP_CODE();
		$param[]  = $this->getP_CATE();
		$param[]  = $this->getP_COPY_CODE();
		$param[]  = $this->getP_REG_NO();

		return $db->executeBindingQuery($query,$param,true);
	}

	/********************************** Product Top Search Word **********************************/
	function getProdTopSearchWordInsertUpdate($db)
	{
		$query = "CALL SP_SEARCH_WORD_IU (?);";

		$param[]  = $this->getSearchKey();

		return $db->executeBindingQuery($query,$param,true);
	}

	/********************************** Product Share Delete **********************************/
	function getProdShareDelete($db)
	{
		$query = "CALL SP_PRODUCT_SHARE_D (?);";

		$param[]  = $this->getPS_NO();
		return $db->executeBindingQuery($query,$param,true);
	}

	/********************************** Product Info View Update **********************************/
	function getProdInfoViewUpdate($db)
	{
		if(!$this->getP_CODE()) { return; }

		$param['P_CODE']			= $this->getSQLString($this->getP_CODE());
		$param['P_WEB_VIEW']		= $this->getSQLString($this->getP_WEB_VIEW());
		$param['P_MOB_VIEW']		= $this->getSQLString($this->getP_MOB_VIEW());

		$where						= "P_CODE = '".$this->getP_CODE()."' ";
		if(!$where)					{ return; }

		return $db->getUpdateParam("PRODUCT_INFO_".$this->getP_LNG(), $param, $where);
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

	function getProdNotifyInsertUpdate($db,$param)
	{
		$query = "CALL SP_PRODUCT_NOTIFY_IU (?,?,?,?,?);";

		$paramData[]			= $param['P_CODE'];
		$paramData[]			= $param['PN_CODE'];
		$paramData[]			= $param['PN_NAME'];
		$paramData[]			= $param['PN_TEXT'];
		$paramData[]			= $param['PN_ORDER'];
		return $db->executeBindingQuery($query,$paramData,true);
	}

	function getProdNotifyDelete($db,$param)
	{
		$query  = "DELETE FROM PRODUCT_NOTIFY_KR WHERE P_CODE = '{$param['P_CODE']}'";

		if ( ! empty ( $param['PN_CODE'] ) )
			$query .= ' AND PN_CODE NOT IN (' . $param['PN_CODE'] . ')' ;

		if ($param['PN_NO_NOT_IN']){
			$query .= " AND PN_NO NOT IN ({$param['PN_NO_NOT_IN']})	";
		}
		return $db->getExecSql($query);
	}

	/********************************** Product Auction Insert **********************************/
	function getProdAucInsert($db,$param)
	{
		if(!$param['P_CODE']) { return; }

		$param['P_CODE']				= $this->getSQLString($param['P_CODE']);
		$param['P_AUC_ST_DT']			= $this->getSQLDatetime($param['P_AUC_ST_DT']);
		$param['P_AUC_END_DT']			= $this->getSQLDatetime($param['P_AUC_END_DT']);
		$param['P_AUC_ST_PRICE']		= $this->getSQLInteger($param['P_AUC_ST_PRICE']);
		$param['P_AUC_RIGHT_PRICE']		= $this->getSQLInteger($param['P_AUC_RIGHT_PRICE']);
		$param['P_AUC_STATUS']			= $this->getSQLInteger($param['P_AUC_STATUS']);
		return $db->getInsertParam("PRODUCT_AUCTION", $param, false);
	}

	function getProdAucUpdate($db,$param)
	{
		if(!$param['P_CODE']) { return; }

		$param['P_AUC_ST_DT']			= $this->getSQLDatetime($param['P_AUC_ST_DT']);
		$param['P_AUC_END_DT']			= $this->getSQLDatetime($param['P_AUC_END_DT']);
		$param['P_AUC_ST_PRICE']		= $this->getSQLInteger($param['P_AUC_ST_PRICE']);
		$param['P_AUC_RIGHT_PRICE']		= $this->getSQLInteger($param['P_AUC_RIGHT_PRICE']);
		$param['P_AUC_STATUS']			= $this->getSQLInteger($param['P_AUC_STATUS']);

		$where							= "P_CODE = '".$param['P_CODE']."' ";
		if(!$where)					{ return; }

		return $db->getUpdateParam("PRODUCT_AUCTION", $param, $where);
	}


	// 카테고리 리스트 가져오기
	function getProductCategoryList ( $db , $lng )
	{
		$lng = empty ( $lng ) ? 'KR' : $lng ;
		$query = 'SELECT A.C_CODE , A.C_LEVEL , B.CL_NAME FROM CATE_MGR AS A LEFT JOIN CATE_LNG AS B ON( A.C_CODE = B.C_CODE AND B.CL_LNG = \'' . $lng . '\' )' ;
		return $db->getArrayTotal( $query ) ;
	}


	/********************************* Function ********************************/
	// 쿼리 선택
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

	/**
	 * getSQLString($str)
	 * SQL 년월일시분초 형변환	ex)
	 * **/
	function getSQLDatetime($str) {
		$str = date("Y-m-d H:i:s", strtotime($str));
		return "\"{$str}\"";
	}

	/********************************** variable **********************************/
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

	function setP_LIST_ICON_VIEW($P_LIST_ICON_VIEW){ $this->P_LIST_ICON_VIEW = $P_LIST_ICON_VIEW; }
	function getP_LIST_ICON_VIEW(){ return $this->P_LIST_ICON_VIEW; }

	function setP_LIST_ICON_ST($P_LIST_ICON_ST){ $this->P_LIST_ICON_ST = $P_LIST_ICON_ST; }
	function getP_LIST_ICON_ST(){ return $this->P_LIST_ICON_ST; }

	function setP_LIST_ICON_ET($P_LIST_ICON_ET){ $this->P_LIST_ICON_ET = $P_LIST_ICON_ET; }
	function getP_LIST_ICON_ET(){ return $this->P_LIST_ICON_ET; }




	function setP_PRICE_FILTER($P_PRICE_FILTER){ $this->P_PRICE_FILTER = $P_PRICE_FILTER; }
	function getP_PRICE_FILTER(){ return $this->P_PRICE_FILTER; }

	function setP_PRICE_UNIT($P_PRICE_UNIT){ $this->P_PRICE_UNIT = $P_PRICE_UNIT; }
	function getP_PRICE_UNIT(){ return $this->P_PRICE_UNIT; }

	function setP_CAS_NO($P_CAS_NO){ $this->P_CAS_NO = $P_CAS_NO; }
	function getP_CAS_NO(){ return $this->P_CAS_NO; }

	function setP_OTHER_NAMES($P_OTHER_NAMES){ $this->P_OTHER_NAMES = $P_OTHER_NAMES; }
	function getP_OTHER_NAMES(){ return $this->P_OTHER_NAMES; }

	function setP_SAIL_UNIT($P_SAIL_UNIT){ $this->P_SAIL_UNIT = $P_SAIL_UNIT; }
	function getP_SAIL_UNIT(){ return $this->P_SAIL_UNIT; }




	function setP_ICON($P_ICON){ $this->P_ICON = $P_ICON; }
	function getP_ICON(){ return $this->P_ICON; }

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

	function setP_ST_SIZE($P_ST_SIZE){ $this->P_ST_SIZE = $P_ST_SIZE; }
	function getP_ST_SIZE(){ return $this->P_ST_SIZE; }

	function setP_COLOR($P_COLOR){ $this->P_COLOR = $P_COLOR; }
	function getP_COLOR(){ return $this->P_COLOR; }

	function setP_SIZE($P_SIZE){ $this->P_SIZE = $P_SIZE; }
	function getP_SIZE(){ return $this->P_SIZE; }

	function setP_EVENT($P_EVENT){ $this->P_EVENT = $P_EVENT; }
	function getP_EVENT(){ return $this->P_EVENT; }

	function setP_POINT_NO_USE($P_POINT_NO_USE){ $this->P_POINT_NO_USE = $P_POINT_NO_USE; }
	function getP_POINT_NO_USE(){ return $this->P_POINT_NO_USE; }

	function setP_APPR($P_APPR){ $this->P_APPR = $P_APPR; }
	function getP_APPR(){ return $this->P_APPR; }

	function setP_TYPE($P_TYPE){ $this->P_TYPE = $P_TYPE; }
	function getP_TYPE(){ return $this->P_TYPE; }

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

	function setSearchStock1($SEARCH_STOCK1){ $this->SEARCH_STOCK1 = $SEARCH_STOCK1; }
	function getSearchStock1(){ return $this->SEARCH_STOCK1; }

	function setSearchStock2($SEARCH_STOCK2){ $this->SEARCH_STOCK2 = $SEARCH_STOCK2; }
	function getSearchStock2(){ return $this->SEARCH_STOCK2; }

	function setSearchStock3($SEARCH_STOCK3){ $this->SEARCH_STOCK3 = $SEARCH_STOCK3; }
	function getSearchStock3(){ return $this->SEARCH_STOCK3; }

	function setSearchEvent($SEARCH_EVENT){ $this->SEARCH_EVENT = $SEARCH_EVENT; }
	function getSearchEvent(){ return $this->SEARCH_EVENT; }

	function setSearchShopNo($SEARCH_SHOP_NO){ $this->SEARCH_SHOP_NO = $SEARCH_SHOP_NO; }
	function getSearchShopNo(){ return $this->SEARCH_SHOP_NO; }

	function setSearchColor($SEARCH_COLOR){ $this->SEARCH_COLOR = $SEARCH_COLOR; }
	function getSearchColor(){ return $this->SEARCH_COLOR; }

	function setSearchProdBrand($SEARCH_PROD_BRAND){ $this->SEARCH_PROD_BRAND = $SEARCH_PROD_BRAND; }
	function getSearchProdBrand(){ return $this->SEARCH_PROD_BRAND; }

	function setSearchSortCol($SEARCH_SORT_COL){ $this->SEARCH_SORT_COL = $SEARCH_SORT_COL; }
	function getSearchSortCol(){ return $this->SEARCH_SORT_COL; }

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
	// 브랜드 관리
	function setPR_NO($PR_NO){ $this->PR_NO = $PR_NO; }
	function getPR_NO(){ return $this->PR_NO; }

	function setPR_NAME($PR_NAME){ $this->PR_NAME = $PR_NAME; }
	function getPR_NAME(){ return $this->PR_NAME; }

	function setPR_LIST_IMG($PR_LIST_IMG){ $this->PR_LIST_IMG = $PR_LIST_IMG; }
	function getPR_LIST_IMG(){ return $this->PR_LIST_IMG; }

	function setPR_TITLE_IMG($PR_TITLE_IMG){ $this->PR_TITLE_IMG = $PR_TITLE_IMG; }
	function getPR_TITLE_IMG(){ return $this->PR_TITLE_IMG; }

	function setPR_VIEW_IMG($PR_VIEW_IMG){ $this->PR_VIEW_IMG = $PR_VIEW_IMG; }
	function getPR_VIEW_IMG(){ return $this->PR_VIEW_IMG; }

	function setPR_ADD_IMG($PR_ADD_IMG){ $this->PR_ADD_IMG = $PR_ADD_IMG; }
	function getPR_ADD_IMG(){ return $this->PR_ADD_IMG; }

	function setPR_COMMENT($PR_COMMENT){ $this->PR_COMMENT = $PR_COMMENT; }
	function getPR_COMMENT(){ return $this->PR_COMMENT; }

	function setPR_HTML($PR_HTML){ $this->PR_HTML = $PR_HTML; }
	function getPR_HTML(){ return $this->PR_HTML; }

	function setPR_TMP1($PR_TMP1){ $this->PR_TMP1 = $PR_TMP1; }
	function getPR_TMP1(){ return $this->PR_TMP1; }

	function setPR_TMP2($PR_TMP2){ $this->PR_TMP2 = $PR_TMP2; }
	function getPR_TMP2(){ return $this->PR_TMP2; }

	function setPR_TMP3($PR_TMP3){ $this->PR_TMP3 = $PR_TMP3; }
	function getPR_TMP3(){ return $this->PR_TMP3; }

	function setPR_M_NO($PR_M_NO){ $this->PR_M_NO = $PR_M_NO; }
	function getPR_M_NO(){ return $this->PR_M_NO; }

	function setPR_ALIGN($PR_ALIGN){ $this->PR_ALIGN = $PR_ALIGN; }
	function getPR_ALIGN(){ return $this->PR_ALIGN; }

	function setPR_REG_DT($PR_REG_DT){ $this->PR_REG_DT = $PR_REG_DT; }
	function getPR_REG_DT(){ return $this->PR_REG_DT; }

	function setPR_REG_NO($PR_REG_NO){ $this->PR_REG_NO = $PR_REG_NO; }
	function getPR_REG_NO(){ return $this->PR_REG_NO; }

	function setPR_MOD_DT($PR_MOD_DT){ $this->PR_MOD_DT = $PR_MOD_DT; }
	function getPR_MOD_DT(){ return $this->PR_MOD_DT; }

	function setPR_MOD_NO($PR_MOD_NO){ $this->PR_MOD_NO = $PR_MOD_NO; }
	function getPR_MOD_NO(){ return $this->PR_MOD_NO; }

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

	/*--------------------------------------------------------------*/
	function setPS_NO($PS_NO){ $this->PS_NO = $PS_NO; }
	function getPS_NO(){ return $this->PS_NO; }

	function setPS_NO_ALL($PS_NO_ALL){ $this->PS_NO_ALL = $PS_NO_ALL; }
	function getPS_NO_ALL(){ return $this->PS_NO_ALL; }


	/*--------------------------------------------------------------*/
	function setSE_NO($SE_NO){ $this->SE_NO = $SE_NO; }
	function getSE_NO(){ return $this->SE_NO; }

	function setSE_TYPE($SE_TYPE){ $this->SE_TYPE = $SE_TYPE; }
	function getSE_TYPE(){ return $this->SE_TYPE; }

	function setSE_TITLE($SE_TITLE){ $this->SE_TITLE = $SE_TITLE; }
	function getSE_TITLE(){ return $this->SE_TITLE; }

	function setSE_DAY_TIME($SE_DAY_TIME){ $this->SE_DAY_TIME = $SE_DAY_TIME; }
	function getSE_DAY_TIME(){ return $this->SE_DAY_TIME; }

	function setSE_DAY_TYPE($SE_DAY_TYPE){ $this->SE_DAY_TYPE = $SE_DAY_TYPE; }
	function getSE_DAY_TYPE(){ return $this->SE_DAY_TYPE; }

	function setSE_DAY($SE_DAY){ $this->SE_DAY = $SE_DAY; }
	function getSE_DAY(){ return $this->SE_DAY; }

	function setSE_START_DT($SE_START_DT){ $this->SE_START_DT = $SE_START_DT; }
	function getSE_START_DT(){ return $this->SE_START_DT; }

	function setSE_END_DT($SE_END_DT){ $this->SE_END_DT = $SE_END_DT; }
	function getSE_END_DT(){ return $this->SE_END_DT; }

	function setSE_PRICE($SE_PRICE){ $this->SE_PRICE = $SE_PRICE; }
	function getSE_PRICE(){ return $this->SE_PRICE; }

	function setSE_PRICE_TYPE($SE_PRICE_TYPE){ $this->SE_PRICE_TYPE = $SE_PRICE_TYPE; }
	function getSE_PRICE_TYPE(){ return $this->SE_PRICE_TYPE; }

	function setSE_PRICE_OFF($SE_PRICE_OFF){ $this->SE_PRICE_OFF = $SE_PRICE_OFF; }
	function getSE_PRICE_OFF(){ return $this->SE_PRICE_OFF; }

	function setSE_SELL_AUTH($SE_SELL_AUTH){ $this->SE_SELL_AUTH = $SE_SELL_AUTH; }
	function getSE_SELL_AUTH(){ return $this->SE_SELL_AUTH; }

	function setSE_GIVE_POINT($SE_GIVE_POINT){ $this->SE_GIVE_POINT = $SE_GIVE_POINT; }
	function getSE_GIVE_POINT(){ return $this->SE_GIVE_POINT; }

	function setSE_COUPON_USE($SE_COUPON_USE){ $this->SE_COUPON_USE = $SE_COUPON_USE; }
	function getSE_COUPON_USE(){ return $this->SE_COUPON_USE; }

	function setSE_DISCOUNT_USE($SE_DISCOUNT_USE){ $this->SE_DISCOUNT_USE = $SE_DISCOUNT_USE; }
	function getSE_DISCOUNT_USE(){ return $this->SE_DISCOUNT_USE; }

	function setSE_MSG($SE_MSG){ $this->SE_MSG = $SE_MSG; }
	function getSE_MSG(){ return $this->SE_MSG; }

	function setSE_PRICE_MARK($SE_PRICE_MARK){ $this->SE_PRICE_MARK = $SE_PRICE_MARK; }
	function getSE_PRICE_MARK(){ return $this->SE_PRICE_MARK; }

	function setSE_PRICE_TEXT($SE_PRICE_TEXT){ $this->SE_PRICE_TEXT = $SE_PRICE_TEXT; }
	function getSE_PRICE_TEXT(){ return $this->SE_PRICE_TEXT; }


	function setSE_REG_DT($SE_REG_DT){ $this->SE_REG_DT = $SE_REG_DT; }
	function getSE_REG_DT(){ return $this->SE_REG_DT; }

	function setSE_REG_NO($SE_REG_NO){ $this->SE_REG_NO = $SE_REG_NO; }
	function getSE_REG_NO(){ return $this->SE_REG_NO; }

	function setSE_MOD_DT($SE_MOD_DT){ $this->SE_MOD_DT = $SE_MOD_DT; }
	function getSE_MOD_DT(){ return $this->SE_MOD_DT; }

	function setSE_MOD_NO($SE_MOD_NO){ $this->SE_MOD_NO = $SE_MOD_NO; }
	function getSE_MOD_NO(){ return $this->SE_MOD_NO; }

	function setSE_LIST_GUBUN($SE_LIST_GUBUN){ $this->SE_LIST_GUBUN = $SE_LIST_GUBUN; }
	function getSE_LIST_GUBUN(){ return $this->SE_LIST_GUBUN; }

	/*--------------------------------------------------------------*/
	function setCG_NO($CG_NO){ $this->CG_NO = $CG_NO; }
	function getCG_NO(){ return $this->CG_NO; }

	function setCG_EACH_USE($CG_EACH_USE){ $this->CG_EACH_USE = $CG_EACH_USE; }
	function getCG_EACH_USE(){ return $this->CG_EACH_USE; }

	function setCG_FIRST_GIFT($CG_FIRST_GIFT){ $this->CG_FIRST_GIFT = $CG_FIRST_GIFT; }
	function getCG_FIRST_GIFT(){ return $this->CG_FIRST_GIFT; }

	function setCG_QTY_USE($CG_QTY_USE){ $this->CG_QTY_USE = $CG_QTY_USE; }
	function getCG_QTY_USE(){ return $this->CG_QTY_USE; }

	function setCG_ST_PRICE($CG_ST_PRICE){ $this->CG_ST_PRICE = $CG_ST_PRICE; }
	function getCG_ST_PRICE(){ return $this->CG_ST_PRICE; }

	function setCG_END_PRICE($CG_END_PRICE){ $this->CG_END_PRICE = $CG_END_PRICE; }
	function getCG_END_PRICE(){ return $this->CG_END_PRICE; }

	function setCG_PRICE_TYPE($CG_PRICE_TYPE){ $this->CG_PRICE_TYPE = $CG_PRICE_TYPE; }
	function getCG_PRICE_TYPE(){ return $this->CG_PRICE_TYPE; }

	function setCG_STOCK($CG_STOCK){ $this->CG_STOCK = $CG_STOCK; }
	function getCG_STOCK(){ return $this->CG_STOCK; }

	function setCG_QTY($CG_QTY){ $this->CG_QTY = $CG_QTY; }
	function getCG_QTY(){ return $this->CG_QTY; }

	function setCG_LIMIT($CG_LIMIT){ $this->CG_LIMIT = $CG_LIMIT; }
	function getCG_LIMIT(){ return $this->CG_LIMIT; }

	function setCG_LIMIT_QTY($CG_LIMIT_QTY){ $this->CG_LIMIT_QTY = $CG_LIMIT_QTY; }
	function getCG_LIMIT_QTY(){ return $this->CG_LIMIT_QTY; }

	function setCG_FILE($CG_FILE){ $this->CG_FILE = $CG_FILE; }
	function getCG_FILE(){ return $this->CG_FILE; }

	function setCG_VIEW($CG_VIEW){ $this->CG_VIEW = $CG_VIEW; }
	function getCG_VIEW(){ return $this->CG_VIEW; }

	function setCG_LNG($CG_LNG){ $this->CG_LNG = $CG_LNG; }
	function getCG_LNG(){ return $this->CG_LNG; }

	function setCG_NAME($CG_NAME){ $this->CG_NAME = $CG_NAME; }
	function getCG_NAME(){ return $this->CG_NAME; }

	function setCG_OPT_NM1($CG_OPT_NM1){ $this->CG_OPT_NM1 = $CG_OPT_NM1; }
	function getCG_OPT_NM1(){ return $this->CG_OPT_NM1; }

	function setCG_OPT_NM2($CG_OPT_NM2){ $this->CG_OPT_NM2 = $CG_OPT_NM2; }
	function getCG_OPT_NM2(){ return $this->CG_OPT_NM2; }

	function setCG_OPT_ATTR1($CG_OPT_ATTR1){ $this->CG_OPT_ATTR1 = $CG_OPT_ATTR1; }
	function getCG_OPT_ATTR1(){ return $this->CG_OPT_ATTR1; }

	function setCG_OPT_ATTR2($CG_OPT_ATTR2){ $this->CG_OPT_ATTR2 = $CG_OPT_ATTR2; }
	function getCG_OPT_ATTR2(){ return $this->CG_OPT_ATTR2; }

	function setCG_REG_DT($CG_REG_DT){ $this->CG_REG_DT = $CG_REG_DT; }
	function getCG_REG_DT(){ return $this->CG_REG_DT; }

	function setCG_REG_NO($CG_REG_NO){ $this->CG_REG_NO = $CG_REG_NO; }
	function getCG_REG_NO(){ return $this->CG_REG_NO; }

	function setCG_MOD_DT($CG_MOD_DT){ $this->CG_MOD_DT = $CG_MOD_DT; }
	function getCG_MOD_DT(){ return $this->CG_MOD_DT; }

	function setCG_MOD_NO($CG_MOD_NO){ $this->CG_MOD_NO = $CG_MOD_NO; }
	function getCG_MOD_NO(){ return $this->CG_MOD_NO; }


	/********************************** variable **********************************/
}
?>