<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2013-10-23												|# 
#|작성내용	: 상품 모듈 클레스											|# 
#/*====================================================================*/# 

require_once "Module.php";

class ProductMgrModule extends Module2
{
//		function getProductMgrSelectEx($op, $param)
//		{
//			$column['OP_LIST']		= "P.*";
//			$column['OP_SELECT']	= "*";
//			$column['OP_COUNT']		= "COUNT(*)";
//			$column['OP_ARYTOTAL']	= "*";
//
//			## query(1) 영역
//			
//			## limit1
//			if($param['LIMIT']):
//				$limit1		= "LIMIT {$param['LIMIT']}";
//			endif;		
//			
//			## order_by1
//			if($param['ORDER_BY']):
//				$order_by1	= "ORDER BY {$param['ORDER_BY']}";
//			else:
//				## default
//				$order_by1	= "ORDER BY P.P_CODE ASC";
//			endif;
//
//			## where1
//			$where1 = "WHERE P.P_CODE IS NOT NULL";
//
//			if($param['P_CODE']):
//				$where1 = "{$where1} AND P.P_CODE = {$param['P_CODE']}";
//			endif;
//
//			if($param['P_CATE']):
//				$where1 = "{$where1} AND P.P_CATE = '{$param['P_CATE']}'";
//			endif;
//
//			if($param['P_CATE_LIKE_R']):
//				$where1 = "{$where1} AND P.P_CATE LIKE('{$param['P_CATE']}%')";
//			endif;
//
//			## from1
//			$from1						= "FROM PRODUCT_MGR AS P";
//
//			## select1
//			$select1	= "SELECT {$column[$op]}";
//			
//			## query1
//			$query1		= "{$select1} {$from1} {$join1_1} {$join1_2} {$where1} {$order_by1} {$limit1}";
//		//	echo $query1;
//
//			return $this->getSelectQuery($query1, $op);
//		}

		function getProductMgrSelectEx($op, $param) 
		{
			$aryColumn				= $this->getProductMgrColumn();
			$column['OP_LIST']		= "*";
			$column['OP_SELECT']	= "*";
			$column['OP_ARYTOTAL']	= "*";
			$column['OP_COUNT']		= "COUNT(*)";	
			$where1					= "";
			$where10				= "";

			## 체크
			if(!$param['LNG']) { return; }		

			## limit1 old style
			if($param['LIMIT']):
				$limit1			= "LIMIT {$param['LIMIT']}";
			endif;
			
			## limit1
			if($param['LIMIT_END']):
				if(!$param['LIMIT_START']) { $param['LIMIT_START'] = 0; }
				$limit1			= "LIMIT {$param['LIMIT_START']},{$param['LIMIT_END']}";
			endif;		

			## order_by1
			if($param['ORDER_BY']):
//				$order_by1		= "ORDER BY {$param['ORDER_BY']}";
				$aryOrder['productNameDesc']		= "PM.P_NAME DESC";
				$aryOrder['productNameAsc']			= "PM.P_NAME ASC";
				$aryOrder['productOrderDesc']		= "PM.P_ORDER DESC";
				$aryOrder['productOrderAsc']		= "PM.P_ORDER ASC";
				$aryOrder['productWebShowDesc']		= "PM.P_WEB_VIEW DESC";
				$aryOrder['productWebShowAsc']		= "PM.P_WEB_VIEW ASC";
				$aryOrder['productShopNoDesc']		= "PM.P_SHOP_NO DESC";
				$aryOrder['productShopNoAsc']		= "PM.P_SHOP_NO ASC";
				$aryOrder['productRegDateDesc']		= "PM.P_REG_DT DESC";
				$aryOrder['productRegDateAsc']		= "PM.P_REG_DT ASC";
				$aryOrder['productSalePriceDesc']	= "PM.P_SALE_PRICE DESC";
				$aryOrder['productSalePriceDesc']	= "PM.P_SALE_PRICE ASC";
				$aryOrder['productQtyDesc']			= "PM.P_QTY DESC";
				$aryOrder['productQtyAsc']			= "PM.P_QTY ASC";
				$strOrder							= $aryOrder[$param['ORDER_BY']];
				if($strOrder) { $order_by1			= "ORDER BY {$strOrder}";				}
				else		  { $order_by1			= "ORDER BY {$param['ORDER_BY']}";		}
			else:
				## default
				$order_by1		= "ORDER BY PM.P_ORDER ASC, PM.P_CODE DESC";
			endif;


		


			## 메인, 서브진열관리
			if($param['P_ICON']):
				$aryIconSubStringStartPoint = array(1 => 1, 2 => 3, 3 => 5, 4 => 7, 5 => 9, 6 => 11, 7 => 13, 8 => 15, 9 => 17, 10 => 19);
				$temp		= "";
				foreach($param['P_ICON'] as $key => $data):
					if(!$data) { continue; }
					if($aryIconSubStringStartPoint[$data]):
						if($temp) { $temp .= " OR "; }
						$temp   .= "SUBSTRING(PM1.P_ICON, {$aryIconSubStringStartPoint[$data]}, 1) = 'Y'";
					endif;
				endforeach;
				if($temp):
					$temp		= "($temp)";
					if($where1) {  $where1 = "{$where1} AND ";	}
					if($where2) {  $where2 = "{$where2} AND ";	}
					$where1		= $temp;
					$where2		= $temp;
				endif;
			endif;


			if($where1) {  $where1 = "{$where1} AND ";	}
			if($where2) {  $where2 = "{$where2} AND ";	}
			$where1		= "{$where1} PM1.P_APPR = 'Y'";
			$where2		= "{$where2} PM1.P_APPR = 'Y'";

			## 상품코드
			if($param['P_CODE']):
				if($where1) {  $where1 = "{$where1} AND ";	}
				if($where2) {  $where2 = "{$where2} AND ";	}
				$where1		= "{$where1} PM1.P_CODE = '{$param['P_CODE']}'";
				$where2		= "{$where2} PM1.P_CODE = '{$param['P_CODE']}'";
			endif;

			## 상품 브렌드
			if($param['P_BRAND']):
				if($where1) {  $where1 = "{$where1} AND ";	}
				if($where2) {  $where2 = "{$where2} AND ";	}
				$where1		= "{$where1} PM1.P_BRAND = '{$param['P_BRAND']}'";
				$where2		= "{$where2} PM1.P_BRAND = '{$param['P_BRAND']}'";
			endif;

			## 상품출력(웹)
			if($param['P_WEB_VIEW']):
				## 다국어출력
				if ($param['P_MANY_LNG_VIEW'] == "Y") {
					$where10[]	= "AI.P_WEB_VIEW = '{$param['P_WEB_VIEW']}'";
				} else {
					if($where1) {  $where1 = "{$where1} AND ";	}
					if($where2) {  $where2 = "{$where2} AND ";	}

					$where1		= "{$where1} PM1.P_WEB_VIEW = '{$param['P_WEB_VIEW']}'";
					$where2		= "{$where2} PM1.P_WEB_VIEW = '{$param['P_WEB_VIEW']}'";
				}
			endif;
			
			## 상품출력(모바일)
			if($param['P_MOB_VIEW']):
				if($where1) {  $where1 = "{$where1} AND ";	}
				if($where2) {  $where2 = "{$where2} AND ";	}
				$where1		= "{$where1} PM1.P_MOB_VIEW = '{$param['P_MOB_VIEW']}'";
				$where2		= "{$where2} PM1.P_MOB_VIEW = '{$param['P_MOB_VIEW']}'";
			endif;

			## 카테고리
			if($param['P_CATE']):
				if($where1) {  $where1 = "{$where1} AND ";	}
				if($where2) {  $where2 = "{$where2} AND ";	}
				$where1				= "{$where1} PM1.P_CATE = '{$param['P_CATE']}'";
				$where2				= "{$where2} PM1.P_CATE = '{$param['P_CATE']}'";
			endif;

			## 카테고리
			if($param['P_CATE_LIKE']):
				if($where1) {  $where1 = "{$where1} AND ";	}
				if($where2) {  $where2 = "{$where2} AND ";	}
				$where1				= "{$where1} PM1.P_CATE LIKE '{$param['P_CATE_LIKE']}%'";
				$where2				= "{$where2} PS.PS_P_CATE LIKE '{$param['P_CATE_LIKE']}%'";
			endif;

			## 사이즈
			if($param['P_SIZE']):
				$aryTemp1			= "";
				$aryTemp2			= "";
				$aryPSize			= explode("|", $param['P_SIZE']);
				foreach($aryPSize as $key => $data):
					if($data != "Y") { continue; }
					$aryTemp1[]		= "SUBSTRING(PM1.P_SIZE,{$key},1) = 'Y'";
					$aryTemp2[]		= "SUBSTRING(PM1.P_SIZE,{$key},1) = 'Y'";
				endforeach;
				$aryTemp1			= implode(" OR ", $aryTemp1);
				$aryTemp2			= implode(" OR ", $aryTemp2);

				if($where1) {  $where1 = "{$where1} AND ";	}
				if($where2) {  $where2 = "{$where2} AND ";	}
				$where1				= "{$where1} ({$aryTemp1})";
				$where2				= "{$where2} ({$aryTemp2})";
			endif;

			## 색상
			if($param['P_COLOR']):
				$aryTemp1			= "";
				$aryTemp2			= "";
				$aryPColor			= explode("|", $param['P_COLOR']);
				foreach($aryPColor as $key => $data):
					if($data != "Y") { continue; }
					$aryTemp1[]		= "SUBSTRING(PM1.P_COLOR,{$key},1) = 'Y'";
					$aryTemp2[]		= "SUBSTRING(PM1.P_COLOR,{$key},1) = 'Y'";
				endforeach;
				$aryTemp1			= implode(" OR ", $aryTemp1);
				$aryTemp2			= implode(" OR ", $aryTemp2);

				if($where1) {  $where1 = "{$where1} AND ";	}
				if($where2) {  $where2 = "{$where2} AND ";	}
				$where1				= "{$where1} ({$aryTemp1})";
				$where2				= "{$where2} ({$aryTemp2})";
			endif;

			## 검색어
			if($param['searchKey']):
				$arySearchField['name']			= "AI.P_NAME LIKE ('{$param['searchKey']}')"; // 상품명
				$arySearchField['code']			= "(PM.P_CODE LIKE ('{$param['searchKey']}') OR PM.P_NUM LIKE ('{$param['searchKey']}'))";// 상품코드
				$arySearchField['maker']		= "PM.P_MAKER LIKE ('{$param['searchKey']}')"; // 제조사
				$arySearchField['orgin']		= "PM.P_ORIGIN LIKE ('{$param['searchKey']}')"; // 원산지
				$arySearchField['brand']		= "PM.P_MODEL LIKE ('{$param['searchKey']}')"; // 모델명
				$arySearchField['search']		= "AI.P_SEARCH_TEXT LIKE ('{$param['searchKey']}')"; // 검색어
				$arySearchField['memo']			= "AI.P_MEMO LIKE ('{$param['searchKey']}')"; // 메모

				$strSearchQuery					= "";
				foreach($arySearchField as $key => $val):
					if($strSearchQuery) { $strSearchQuery .= " OR "; }
					$strSearchQuery				.= $val;
				endforeach;
				if($arySearchField[$param['searchField']]) { $strSearchQuery = $arySearchField[$param['searchField']]; }

				$where10[]	= "({$strSearchQuery})";
			endif;

			if($param['LNG'] && $param['PRODUCT_INFO_JOIN'] == "Y"):
				$aryColumn['P_SEARCH_TEXT']		= "AI.P_SEARCH_TEXT";
				$aryColumn['P_ETC']				= "AI.P_ETC";
				$aryColumn['P_WEB_TEXT']		= "AI.P_WEB_TEXT";
				$aryColumn['P_MOB_TEXT']		= "AI.P_MOB_TEXT";
				$aryColumn['P_MEMO']			= "AI.P_MEMO";
				$aryColumn['P_DELIVERY_TEXT']	= "AI.P_DELIVERY_TEXT";
				$aryColumn['P_RETURN_TEXT']		= "AI.P_RETURN_TEXT";
				$aryColumn['P_PRICE_TEXT']		= "AI.P_PRICE_TEXT";
//				$aryColumn['P_CODE']			= "AI.P_CODE";
				$aryColumn['P_NAME']			= "AI.P_NAME";
				$join1							= "JOIN PRODUCT_INFO_{$param['LNG']} AI ON AI.P_CODE = PM.P_CODE";
			endif;

			if($param['PRODUCT_IMG_JOIN'] == "Y"):
			
				if(!$param['PM_TYPE']) { $param['PM_TYPE'] = "list"; }

				$aryColumn['PM_SAVE_NAME']		= "PI.PM_SAVE_NAME";
				$aryColumn['PM_REAL_NAME']		= "PI.PM_REAL_NAME";
				$aryColumn['PM_TYPE']			= "PI.PM_TYPE";
				$join2							= "LEFT OUTER JOIN PRODUCT_IMG PI ON PI.P_CODE = PM.P_CODE AND PI.PM_TYPE = '{$param['PM_TYPE']}'";
			endif;

			if($param['PRODUCT_IMG_JOIN2'] == "Y"):
			
				if(!$param['PM_TYPE2']) { $param['PM_TYPE2'] = "main"; }

//				$aryColumn['PM_SAVE_NAME2']		= "PI2.PM_SAVE_NAME AS PM_SAVE_NAME2";
				$aryColumn['PM_REAL_NAME2']		= "PI2.PM_REAL_NAME AS PM_REAL_NAME2";
//				$aryColumn['PM_TYPE2']			= "PI2.PM_TYPE AS PM_TYPE2";
				$join2_1						= "LEFT OUTER JOIN PRODUCT_IMG AS PI2 ON PI2.P_CODE = PM.P_CODE AND PI2.PM_TYPE = '{$param['PM_TYPE2']}'";
			endif;
			
/*
			//웅진에서만 사용 2015.05.21
			if(!$param['PM_TYPE']) { $param['PM_TYPE'] = "view"; }

			$aryColumn['PM_SAVE_NAME']		= "PI.PM_SAVE_NAME";
			$aryColumn['PM_REAL_NAME']		= "PI.PM_REAL_NAME";
			$aryColumn['PM_TYPE']			= "PI.PM_TYPE";
			$join2							= "LEFT OUTER JOIN PRODUCT_IMG PI ON PI.P_CODE = PM.P_CODE AND PI.PM_TYPE = '{$param['PM_TYPE']}'";
*/

			## 내가 좋아하는 상품 선택
			if($param['MPL_JOIN'] == "Y" && $param['M_NO']):
				$join3				= "JOIN ( SELECT P_CODE ,'Y' P_LIKE_TYPE FROM MEMBER_PROD_LIKE WHERE M_NO = {$param['M_NO']} ) MPL ON PM.P_CODE = MPL.P_CODE";
			endif;

			## 상품 평가 정보 
			if($param['UBJ_JOIN'] == "Y"):
				$aryColumn[]		= "IFNULL(UBJ.UB_P_GRADE, 0) AS P_GRADE";
				$aryColumn[]		= "IFNULL(UBJ.UB_P_GRADE_CNT, 0) AS P_GRADE_CNT";
				$join4				= "LEFT JOIN (SELECT UB.UB_P_CODE, SUM(UB.UB_P_GRADE) AS UB_P_GRADE, COUNT(*) AS UB_P_GRADE_CNT FROM BOARD_UB_PROD_REVIEW AS UB GROUP BY UB.UB_P_CODE ) AS UBJ ON UBJ.UB_P_CODE = PM.P_CODE";
			endif;

			## 상품 브랜드 설정
			if($param['PBR_JOIN'] == "Y"):

				$aryColumn[]		= "PBR.PR_NAME AS P_BRAND_NAME";
				$join5				= "LEFT OUTER JOIN PRODUCT_BRAND PBR ON PM.P_BRAND = PBR.PR_NO";
			endif;
			
			//입점사명 추가 2015.05.14
			$aryColumn[]		= " SI.SH_COM_NAME AS SH_COM_NAME ";
			$join6				= " LEFT JOIN SHOP_MGR AS SH ON PM.P_SHOP_NO = SH.SH_NO ";
			$join6				.= " LEFT JOIN SHOP_INFO_".$param['LNG']." AS SI ON PM.P_SHOP_NO = SI.SH_NO ";

			if($where1) { $where1 = "WHERE {$where1}"; }
			if($where2) { $where2 = "WHERE {$where2}"; }
			$query1				= "SELECT PM1.* FROM PRODUCT_MGR AS PM1 {$where1}";
			$query2				= "SELECT PM1.* FROM PRODUCT_SHARE AS PS JOIN PRODUCT_MGR AS PM1 ON PM1.P_CODE = PS.P_CODE  {$where2}";

			$column['OP_LIST']		= implode(", ", $aryColumn);
			$column['OP_SELECT']	= implode(", ", $aryColumn);
			$column['OP_ARYTOTAL']	= implode(", ", $aryColumn);
			if($where10) { $where10 = "WHERE " .  implode(" AND ", $where10); } 

			$union = "UNION";
			if($param['UNION_ALL'] == "Y") { $union = "UNION ALL"; }
			$query					= "SELECT {$column[$op]} FROM ( {$query1} {$union} {$query2} ) AS PM {$join1} {$join2} {$join2_1} {$join3} {$join4} {$join5} {$join6} {$where10} {$order_by1} {$limit1}";

			//echo "<!--{$query}-->";
			//PRINT_R($query);
			//$this->getSelectQuery($query, $op);
			//PRINT_R($this);
			return $this->getSelectQuery($query, $op);
		}

// 2013.12.13 kim hee sung 속도가 느림 old style
//		function getProductMgrSelectEx2($op, $param)
//		{
//			$column['OP_LIST']		= "P.*";
//			$column['OP_SELECT']	= "*";
//			$column['OP_COUNT']		= "COUNT(*)";
//
//			## 기본 체크
//			if(!$param['PRODUCT_INFO_LNG_JOIN']) { return; }
//
//			## query(4) 영역
//
//			## where5
//			$where5			= "WHERE P5.P_CODE IS NOT NULL";
//
//			## from5
//			$from5			= "PRODUCT_SHARE";
//			$from5			= "FROM {$from5} AS P5";
//
//			## select5
//			$select5		= "SELECT P5.P_CODE, P5.PS_P_CATE AS P_CATE";
//			
//			## where4
//			$where4			= "WHERE P4.P_CODE IS NOT NULL";
//
//			## from4
//			$from4			= "PRODUCT_MGR";
//			$from4			= "FROM {$from4} AS P4";
//
//			## select4
//			$select4		= "SELECT P4.P_CODE, P4.P_CATE";
//			
//			## query4
//			$query4			= "{$select4} {$from4} {$where4} UNION {$select5} {$from5} {$where5}";
//
//			## query(3) 영역
//
//			## groupby3
//			$groupby3		= "GROUP BY P3.P_CODE";
//
//			## from3
//			$from3			= "FROM ({$query4}) AS P3";
//
//			## select3
//			$select3		= "SELECT P3.P_CODE, MAX(P3.P_CATE) AS P_CATE";
//
//			## query3
//			$query3			= "{$select3} {$from3} {$groupby3}";
//
//			## query(2) 영역
//
//			## where2
//			$where2			= "WHERE P2.P_CODE IS NOT NULL";
//
//			## where 조건 만들기
//			{
//				## 검색어
//				if($param['searchKey']):
//					$arySearchField['name']			= "PM2_2.P_NAME LIKE ('%{$param['searchKey']}%')"; // 상품명
//					$arySearchField['code']			= "(P2_1.P_CODE LIKE ('%{$param['searchKey']}%') OR P2_1.P_NUM LIKE ('%{$param['searchKey']}%'))";// 상품코드
//					$arySearchField['maker']		= "P2_1.P_MAKER LIKE ('%{$param['searchKey']}%')"; // 제조사
//					$arySearchField['orgin']		= "P2_1.P_ORIGIN LIKE ('%{$param['searchKey']}%')"; // 원산지
//					$arySearchField['brand']		= "P2_1.P_MODEL LIKE ('%{$param['searchKey']}%')"; // 모델명
//					$arySearchField['search']		= "P2_1.P_SEARCH_TEXT LIKE ('%{$param['searchKey']}%')"; // 검색어
//					$arySearchField['memo']			= "P2_1.P_MEMO LIKE ('%{$param['searchKey']}%')"; // 메모
//
//					$strSearchQuery					= "";
//					foreach($arySearchField as $key => $val):
//						if($strSearchQuery) { $strSearchQuery .= " OR "; }
//						$strSearchQuery				.= $val;
//					endforeach;
//					if($arySearchField[$param['searchField']]) { $strSearchQuery = $arySearchField[$param['searchField']]; }
//
//					$where2		= "{$where2} AND ({$strSearchQuery})";
//				endif;
//
//				## 카테고리
//				if($param['P_CATE']):
//					$where2				= "{$where2} AND P2.P_CATE = '{$param['P_CATE']}'";
//				endif;
//
//				## 카테고리
//				if($param['P_CATE_LIKE']):
//		//			$param['P_CATE']	= str_pad($param['P_CATE'], 12, "0");
//					$where2				= "{$where2} AND P2.P_CATE LIKE '{$param['P_CATE_LIKE']}%'";
//				endif;
//
//				## 상품출시일
//				if($param['P_LAUNCH_DT_BETWEEN']):
//					if($param['P_LAUNCH_DT_BETWEEN'][0] && $param['P_LAUNCH_DT_BETWEEN'][1]):
//						$param['P_LAUNCH_DT_BETWEEN'][0]		= mysql_real_escape_string($param['P_LAUNCH_DT_BETWEEN'][0]);
//						$param['P_LAUNCH_DT_BETWEEN'][1]		= mysql_real_escape_string($param['P_LAUNCH_DT_BETWEEN'][1]);
//						$where2		= "{$where2} AND P2_1.P_LAUNCH_DT BETWEEN DATE_FORMAT('{$param['P_LAUNCH_DT_BETWEEN'][0]}','%Y-%m-%d 00:00:00') AND DATE_FORMAT('{$param['P_LAUNCH_DT_BETWEEN'][1]}','%Y-%m-%d 23:59:59')";
//					endif;
//				endif;
//
//				## 상품등록일
//				if($param['P_REP_DT_BETWEEN']):
//					if($param['P_REP_DT_BETWEEN'][0] && $param['P_REP_DT_BETWEEN'][1]):
//						$param['P_REP_DT_BETWEEN'][0]		= mysql_real_escape_string($param['P_REP_DT_BETWEEN'][0]);
//						$param['P_REP_DT_BETWEEN'][1]		= mysql_real_escape_string($param['P_REP_DT_BETWEEN'][1]);
//						$where2		= "{$where2} AND P2_1.P_REP_DT BETWEEN DATE_FORMAT('{$param['P_REP_DT_BETWEEN'][0]}','%Y-%m-%d 00:00:00') AND DATE_FORMAT('{$param['P_REP_DT_BETWEEN'][1]}','%Y-%m-%d 23:59:59')";
//					endif;
//				endif;
//
//				## 브랜드
//				if($param['P_BRAND']):
//					$where2		= "{$where2} AND P2_1.P_BRAND = '{$param['P_BRAND']}'";
//				endif;
//
//				## 상품출력(웹)
//				if($param['P_WEB_VIEW']):
//					$where2		= "{$where2} AND P2_1.P_WEB_VIEW = '{$param['P_WEB_VIEW']}'";
//				endif;
//
//				## 상품출력(모바일)
//				if($param['P_MOB_VIEW']):
//					$where2		= "{$where2} AND P2_1.P_MOB_VIEW = '{$param['P_MOB_VIEW']}'";
//				endif;
//
//				## 메인, 서브진열관리
//				if($param['P_ICON']):
//					$aryIconSubStringStartPoint = array(1 => 1, 2 => 3, 3 => 5, 4 => 7, 5 => 9, 6 => 11, 7 => 13, 8 => 15, 9 => 17, 10 => 19);
//					$temp		= "";
//					foreach($param['P_ICON'] as $key => $data):
//						if(!$data) { continue; }
//						if($aryIconSubStringStartPoint[$data]):
//							if($temp) { $temp .= " OR "; }
//							$temp   .= "SUBSTRING(P_ICON, {$aryIconSubStringStartPoint[$data]}, 1) = 'Y'";
//						endif;
//					endforeach;
//					if($temp):
//						$temp		= "($temp)";
//						$where2		= "{$where2} AND {$temp}";
//					endif;
//				endif;
//
//				## 입점자
//				if($param['P_SHOP_NO'] || $param['P_SHOP_NO'] == "0"):
//					$where2		= "{$where2} AND P2_1.P_SHOP_NO = '{$param['P_SHOP_NO']}'";
//				endif;
//
//				if($param['P_SHOP_NO_IN']):
//					$where2		= "{$where2} AND P2_1.P_SHOP_NO IN ({$param['P_SHOP_NO_IN']})";
//				endif;
//
//				if($param['P_CODE']):
//					$where2		= "{$where2} AND P2_1.P_CODE = '{$param['P_CODE']}'";
//				endif;
//			
//				if($param['P_CODE_IN']):
//					$where2		= "{$where2} AND P2_1.P_CODE IN ({$param['P_CODE_IN']})";
//				endif;
//			}
//
//			## join2_2
//			$join2_2From	= "PRODUCT_INFO_{$param['PRODUCT_INFO_LNG_JOIN']}";
//			$join2_2		= "JOIN {$join2_2From} AS PM2_2 ON PM2_2.P_CODE = P2.P_CODE";
//
//			## join2_1
//			$join2_1From	= "PRODUCT_MGR";
//			$join2_1		= "JOIN {$join2_1From} AS P2_1 ON P2_1.P_CODE = P2.P_CODE";
//
//			## from2
//			$from2			= "FROM ({$query3}) AS P2";
//
//			## select2
//			$select2			 = "SELECT ";
//			$select2			.= "P2.P_CODE 
//								   ,PM2_2.P_NAME
//								   ,P2_1.P_CATE
//								   ,P2_1.P_NUM
//								   ,P2_1.P_MAKER
//								   ,P2_1.P_ORIGIN
//								   ,P2_1.P_BRAND
//								   ,P2_1.P_MODEL
//								   ,P2_1.P_LAUNCH_DT
//								   ,P2_1.P_WEB_VIEW
//								   ,P2_1.P_MOB_VIEW
//								   ,P2_1.P_REP_DT
//								   ,P2_1.P_ORDER
//								   ,P2_1.P_SALE_PRICE
//								   ,P2_1.P_CONSUMER_PRICE
//								   ,P2_1.P_STOCK_PRICE
//								   ,P2_1.P_POINT
//								   ,P2_1.P_POINT_TYPE
//								   ,P2_1.P_POINT_OFF1
//								   ,P2_1.P_POINT_OFF2
//								   ,P2_1.P_QTY
//								   ,P2_1.P_STOCK_OUT
//								   ,P2_1.P_RESTOCK
//								   ,P2_1.P_STOCK_LIMIT
//								   ,P2_1.P_MIN_QTY
//								   ,P2_1.P_MAX_QTY
//								   ,P2_1.P_TAX
//								   ,PM2_2.P_PRICE_TEXT
//								   ,P2_1.P_OPT
//								   ,P2_1.P_ADD_OPT
//								   ,P2_1.P_BAESONG_TYPE
//								   ,P2_1.P_BAESONG_PRICE
//								   ,P2_1.P_BAESONG_QTY
//								   ,PM2_2.P_SEARCH_TEXT
//								   ,PM2_2.P_ETC
//								   ,PM2_2.P_WEB_TEXT
//								   ,PM2_2.P_MOB_TEXT
//								   ,PM2_2.P_MEMO
//								   ,PM2_2.P_DELIVERY_TEXT
//								   ,PM2_2.P_RETURN_TEXT
//								   ,P2_1.P_EVENT_UNIT
//								   ,P2_1.P_EVENT
//								   ,P2_1.P_LIST_ICON
//								   ,P2_1.P_LIST_ICON_VIEW
//								   ,P2_1.P_LIST_ICON_ST
//								   ,P2_1.P_LIST_ICON_ET
//								   ,P2_1.P_WEIGHT
//								   ,P2_1.P_ST_SIZE
//								   ,P2_1.P_SHOP_NO
//								   ,P2_1.P_SCR
//								   ,P2_1.P_ICON
//								   ,P2_1.P_PARENT_CODE
//								   ,P2_1.P_COLOR
//								   ,P2_1.P_SIZE
//								   ,P2_1.P_POINT_NO_USE
//								   ,P2_1.P_REG_DT
//								   ,P2_1.P_REG_NO
//								   ,P2_1.P_MOD_DT
//								   ,P2_1.P_MOD_NO ";
//
//
//			## query2
//			$query2			= "{$select2} {$from2} {$join2_1} {$join2_2} {$where2}";
//
//			## query(1) 영역
//			
//			## limit1
//			if($param['LIMIT']):
//				$limit1		= "LIMIT {$param['LIMIT']}";
//			endif;		
//
//			## order_by1
//			if($param['ORDER_BY']):
//				$aryOrder['productNameDesc']		= "P.P_NAME DESC";
//				$aryOrder['productNameAsc']			= "P.P_NAME ASC";
//				$aryOrder['productOrderDesc']		= "P.P_ORDER DESC";
//				$aryOrder['productOrderAsc']		= "P.P_ORDER ASC";
//				$aryOrder['productWebShowDesc']		= "P.P_WEB_VIEW DESC";
//				$aryOrder['productWebShowAsc']		= "P.P_WEB_VIEW ASC";
//				$aryOrder['productShopNoDesc']		= "P.P_SHOP_NO DESC";
//				$aryOrder['productShopNoAsc']		= "P.P_SHOP_NO ASC";
//				$aryOrder['productRegDateDesc']		= "P.P_REG_DT DESC";
//				$aryOrder['productRegDateAsc']		= "P.P_REG_DT ASC";
//				$aryOrder['productSalePriceDesc']	= "P.P_SALE_PRICE DESC";
//				$aryOrder['productSalePriceDesc']	= "P.P_SALE_PRICE ASC";
//				$aryOrder['productQtyDesc']			= "P.P_QTY DESC";
//				$aryOrder['productQtyAsc']			= "P.P_QTY ASC";
//				$strOrder							= $aryOrder[$param['ORDER_BY']];
//				if($strOrder) { $order_by1			= "ORDER BY {$strOrder}";				}
//				else		  { $order_by1			= "ORDER BY {$param['ORDER_BY']}";		}
//
//
//			else:
//				$order_by1	= "ORDER BY P.P_CODE DESC";
//			endif;
//
//			## where1
//			$where1 = "WHERE P.P_CODE IS NOT NULL";
//
//			## join1_2
//			if($param['SHOP_SITE_JOIN']):
//				$column['OP_LIST']	   .= ", ST.ST_NAME
//										   , SM.SH_COM_ACC_PRICE
//										   , SM.SH_COM_ACC_RATE
//										";
//
//				$join1_2From			= "SHOP_SITE";
//				$join1_2				= "LEFT OUTER JOIN {$join1_2From} AS ST ON ST.SH_NO = P.P_SHOP_NO";
//				$join1_3From			= "SHOP_MGR";
//				$join1_3				= "LEFT OUTER JOIN {$join1_3From} AS SM ON SM.SH_NO = P.P_SHOP_NO";
//
//			endif;
//
//			## join1_1
//			if($param['PRODUCT_IMG_JOIN']):
//				$column['OP_LIST']	   .= " , PM.PM_SAVE_NAME
//											, PM.PM_REAL_NAME		";
//				$join1_1From			= "PRODUCT_IMG";
//				$join1_1				= "LEFT OUTER JOIN {$join1_1From} AS PM ON PM.P_CODE = P.P_CODE AND PM.PM_TYPE = 'list'";
//			endif;
//
//			## from1
//			$from1		= "FROM ({$query2}) AS P";
//
//			## select1
//			$select1	= "SELECT {$column[$op]}";
//			
//			## query1
//			$query1		= "{$select1} {$from1} {$join1_1} {$join1_2} {$join1_3} {$where1} {$order_by1} {$limit1}";
//		//	echo $query1;
//
//			return $this->getSelectQuery($query1, $op);
//		}

		function getProductMgrInsertEx($param)
		{

		}

		function getProductMgrUpdateEx($param)
		{
			## 체크
			if(!$param['P_CODE'])	{ return; }

			$paramData							= "";
//			$paramData['P_CODE']				= $this->db->getSQLString($param['P_CODE']);
			$paramData['P_NAME']				= $this->db->getSQLString($param['P_NAME']);
			$paramData['P_CATE']				= $this->db->getSQLString($param['P_CATE']);
			$paramData['P_NUM']					= $this->db->getSQLString($param['P_NUM']);
			$paramData['P_MAKER']				= $this->db->getSQLString($param['P_MAKER']);
			$paramData['P_ORIGIN']				= $this->db->getSQLString($param['P_ORIGIN']);
			$paramData['P_BRAND']				= $this->db->getSQLString($param['P_BRAND']);
			$paramData['P_MODEL']				= $this->db->getSQLString($param['P_MODEL']);
			$paramData['P_LAUNCH_DT']			= $this->db->getSQLDatetime($param['P_LAUNCH_DT']);
			$paramData['P_WEB_VIEW']			= $this->db->getSQLString($param['P_WEB_VIEW']);
			$paramData['P_MOB_VIEW']			= $this->db->getSQLString($param['P_MOB_VIEW']);
			$paramData['P_REP_DT']				= $this->db->getSQLDatetime($param['P_REP_DT']);
			$paramData['P_ORDER']				= $this->db->getSQLInteger($param['P_ORDER']);
			$paramData['P_SALE_PRICE']			= $this->db->getSQLInteger($param['P_SALE_PRICE']);
			$paramData['P_CONSUMER_PRICE']		= $this->db->getSQLInteger($param['P_CONSUMER_PRICE']);
			$paramData['P_STOCK_PRICE']			= $this->db->getSQLInteger($param['P_STOCK_PRICE']);
			$paramData['P_POINT']				= $this->db->getSQLInteger($param['P_POINT']);
			$paramData['P_POINT_TYPE']			= $this->db->getSQLString($param['P_POINT_TYPE']);
			$paramData['P_POINT_OFF1']			= $this->db->getSQLString($param['P_POINT_OFF1']);
			$paramData['P_POINT_OFF2']			= $this->db->getSQLString($param['P_POINT_OFF2']);
			$paramData['P_QTY']					= $this->db->getSQLInteger($param['P_QTY']);
			$paramData['P_STOCK_OUT']			= $this->db->getSQLString($param['P_STOCK_OUT']);
			$paramData['P_RESTOCK']				= $this->db->getSQLString($param['P_RESTOCK']);
			$paramData['P_STOCK_LIMIT']			= $this->db->getSQLString($param['P_STOCK_LIMIT']);
			$paramData['P_MIN_QTY']				= $this->db->getSQLInteger($param['P_MIN_QTY']);
			$paramData['P_MAX_QTY']				= $this->db->getSQLInteger($param['P_MAX_QTY']);
			$paramData['P_TAX']					= $this->db->getSQLString($param['P_STOCK_OUT']);
			$paramData['P_PRICE_TEXT']			= $this->db->getSQLString($param['P_TAX']);
			$paramData['P_OPT']					= $this->db->getSQLString($param['P_OPT']);
			$paramData['P_ADD_OPT']				= $this->db->getSQLString($param['P_ADD_OPT']);
			$paramData['P_BAESONG_TYPE']		= $this->db->getSQLString($param['P_BAESONG_TYPE']);
			$paramData['P_BAESONG_PRICE']		= $this->db->getSQLInteger($param['P_BAESONG_PRICE']);
			$paramData['P_BAESONG_QTY']			= $this->db->getSQLInteger($param['P_BAESONG_QTY']);
			$paramData['P_SEARCH_TEXT']			= $this->db->getSQLString($param['P_SEARCH_TEXT']);
			$paramData['P_ETC']					= $this->db->getSQLString($param['P_ETC']);
			$paramData['P_WEB_TEXT']			= $this->db->getSQLString($param['P_WEB_TEXT']);
			$paramData['P_MOB_TEXT']			= $this->db->getSQLString($param['P_MOB_TEXT']);
			$paramData['P_MEMO']				= $this->db->getSQLString($param['P_MEMO']);
			$paramData['P_DELIVERY_TEXT']		= $this->db->getSQLString($param['P_DELIVERY_TEXT']);
			$paramData['P_RETURN_TEXT']			= $this->db->getSQLString($param['P_RETURN_TEXT']);
			$paramData['P_EVENT_UNIT']			= $this->db->getSQLString($param['P_EVENT_UNIT']);
			$paramData['P_EVENT']				= $this->db->getSQLInteger($param['P_EVENT']);
			$paramData['P_LIST_ICON']			= $this->db->getSQLString($param['P_LIST_ICON']);
			$paramData['P_LIST_ICON_VIEW']		= $this->db->getSQLString($param['P_LIST_ICON_VIEW']);
			$paramData['P_LIST_ICON_ST']		= $this->db->getSQLDatetime($param['P_LIST_ICON_ST']);
			$paramData['P_LIST_ICON_ET']		= $this->db->getSQLDatetime($param['P_LIST_ICON_ET']);
			$paramData['P_WEIGHT']				= $this->db->getSQLInteger($param['P_WEIGHT']);
			$paramData['P_ST_SIZE']				= $this->db->getSQLString($param['P_ST_SIZE']);
			$paramData['P_SHOP_NO']				= $this->db->getSQLInteger($param['P_SHOP_NO']);
			$paramData['P_SCR']					= $this->db->getSQLString($param['P_SCR']);
			$paramData['P_PARENT_CODE']			= $this->db->getSQLString($param['P_PARENT_CODE']);
			$paramData['P_COLOR']				= $this->db->getSQLString($param['P_COLOR']);
			$paramData['P_SIZE']				= $this->db->getSQLString($param['P_SIZE']);
			$paramData['P_POINT_NO_USE']		= $this->db->getSQLString($param['P_POINT_NO_USE']);
			$paramData['P_REG_DT']				= $this->db->getSQLDatetime($param['P_REG_DT']);
			$paramData['P_REG_NO']				= $this->db->getSQLInteger($param['P_REG_NO']);
			$paramData['P_MOD_DT']				= $this->db->getSQLDatetime($param['P_MOD_DT']);
			$paramData['P_MOD_NO']				= $this->db->getSQLInteger($param['P_MOD_NO']);

			if($param['P_CODE']):
				$pCode				= $this->db->getSQLInteger($param['P_CODE']);
				$where				= "P_CODE = {$pCode}";
			endif;
			
			if(!$where)					{ return; }

			return $this->db->getUpdateParam("PRODUCT_MGR", $paramData, $where);
		}

		// 상품출력 변경
		function getProductMgrViewUpdateEx($param)
		{
			## 기본 설정
			$strPCode = $param['P_CODE'];

			## 체크
			if(!$strPCode) { return; }

			## 수정 데이터
			$paramData							= "";
			$paramData['P_WEB_VIEW']			= $this->db->getSQLString($param['P_WEB_VIEW']);
			$paramData['P_MOB_VIEW']			= $this->db->getSQLString($param['P_MOB_VIEW']);

			## where
			$where = "P_CODE = '{$strPCode}'";

			return $this->db->getUpdateParam("PRODUCT_MGR", $paramData, $where);
		}

		// 우선순위 변경
		function getProductMgrOrderUpdateEx($param)
		{
			## 체크
			if(!$param['P_CODE'])	{ return; }

			$paramData							= "";
			$paramData['P_ORDER']				= $this->db->getSQLInteger($param['P_ORDER']);
			$paramData['P_MOD_DT']				= $this->db->getSQLDatetime($param['P_MOD_DT']);
			$paramData['P_MOD_NO']				= $this->db->getSQLInteger($param['P_MOD_NO']);

			if($param['P_CODE']):
				$pCode							= $this->db->getSQLInteger($param['P_CODE']);
				$where							= "P_CODE = {$pCode}";
			endif;
			
			if(!$where)					{ return; }

			return $this->db->getUpdateParam("PRODUCT_MGR", $paramData, $where);
		}

		// 입점사 변경
		function getProductMgrShopUpdateEx($param)
		{
			## 체크
			if(!$param['P_CODE'])	{ return; }

			$paramData							= "";
			$paramData['P_SHOP_NO']				= $this->db->getSQLInteger($param['P_SHOP_NO']);
			$paramData['P_MOD_DT']				= $this->db->getSQLDatetime($param['P_MOD_DT']);
			$paramData['P_MOD_NO']				= $this->db->getSQLInteger($param['P_MOD_NO']);

			if($param['P_CODE']):
				$pCode							= $this->db->getSQLInteger($param['P_CODE']);
				$where							= "P_CODE = {$pCode}";
			endif;
			
			if(!$where)					{ return; }

			return $this->db->getUpdateParam("PRODUCT_MGR", $paramData, $where);
		}

		// 상품 수량 변경
		function getProductMgrQTYSumUpdateEx($param)
		{
			## 기본 설정
			$strP_CODE = $param['P_CODE'];
			$intP_QTY = $param['P_QTY'];

			## 체크
			if(!$strP_CODE) { return; }

			## 수정 데이터
			$paramData							= "";
			$paramData['P_QTY']					= "IFNULL(P_QTY, 0) + {$intP_QTY}";

			## where
			$where = "P_CODE = '{$strP_CODE}'";

			return $this->db->getUpdateParam("PRODUCT_MGR", $paramData, $where);		
		}

		function getProductMgrDeleteEx($param)
		{

		}

		function getSelectQuery($query, $op)
		{
			if ( $op == "OP_LIST" ) :
				return $this->db->getExecSql($query);
			elseif ( $op == "OP_SELECT" ) :
				return $this->db->getSelect($query);
			elseif ( $op == "OP_COUNT" ) :
				return $this->db->getCount($query);
			elseif ( $op == "OP_ARYLIST" ) :
				return $this->db->getArray($query);
			elseif ( $op == "OP_ARYTOTAL" ) :
				return $this->db->getArrayTotal($query);
			else :
				return -100;
			endif;
		}	

		function getProductMgrColumn() {
		   $column['P_PRICE_UNIT']			= "PM.P_PRICE_UNIT";
		   $column['P_NAME']				= "PM.P_NAME";
		   $column['P_CODE']				= "PM.P_CODE";
		   $column['P_ORDER']				= "PM.P_ORDER";
		   $column['P_POINT']				= "PM.P_POINT";
		   $column['P_QTY']					= "PM.P_QTY";
		   $column['P_MIN_QTY']				= "PM.P_MIN_QTY";
		   $column['P_MAX_QTY']				= "PM.P_MAX_QTY";
		   $column['P_SHOP_NO']				= "PM.P_SHOP_NO";
		   $column['P_REG_NO']				= "PM.P_REG_NO";
		   $column['P_MOD_NO']				= "PM.P_MOD_NO";
		   $column['P_LAUNCH_DT']			= "PM.P_LAUNCH_DT";
		   $column['P_REP_DT']				= "PM.P_REP_DT";
		   $column['P_LIST_ICON_ST']		= "PM.P_LIST_ICON_ST";
		   $column['P_LIST_ICON_ET']		= "PM.P_LIST_ICON_ET";
		   $column['P_REG_DT']				= "PM.P_REG_DT";
		   $column['P_MOD_DT']				= "PM.P_MOD_DT";
		   $column['P_BAESONG_PRICE']		= "PM.P_BAESONG_PRICE";
		   $column['P_SALE_PRICE']			= "PM.P_SALE_PRICE";
		   $column['P_CONSUMER_PRICE']		= "PM.P_CONSUMER_PRICE";
		   $column['P_STOCK_PRICE']			= "PM.P_STOCK_PRICE";
		   $column['P_BAESONG_QTY']			= "PM.P_BAESONG_QTY";
		   $column['P_EVENT']				= "PM.P_EVENT";
		   $column['P_WEIGHT']				= "PM.P_WEIGHT";
		   $column['P_SEARCH_TEXT']			= "PM.P_SEARCH_TEXT";
		   $column['P_ETC']					= "PM.P_ETC";
		   $column['P_WEB_TEXT']			= "PM.P_WEB_TEXT";
		   $column['P_MOB_TEXT']			= "PM.P_MOB_TEXT";
		   $column['P_MEMO']				= "PM.P_MEMO";
		   $column['P_DELIVERY_TEXT']		= "PM.P_DELIVERY_TEXT";
		   $column['P_RETURN_TEXT']			= "PM.P_RETURN_TEXT";
		   $column['P_WEB_VIEW']			= "PM.P_WEB_VIEW";
		   $column['P_MOB_VIEW']			= "PM.P_MOB_VIEW";
		   $column['P_TYPE']			= "PM.P_TYPE";
		   $column['P_PRICE_FILTER']			= "PM.P_PRICE_FILTER";
		   $column['P_POINT_TYPE']			= "PM.P_POINT_TYPE";
		   $column['P_POINT_OFF1']			= "PM.P_POINT_OFF1";
		   $column['P_POINT_OFF2']			= "PM.P_POINT_OFF2";
		   $column['P_STOCK_OUT']			= "PM.P_STOCK_OUT";
		   $column['P_RESTOCK']				= "PM.P_RESTOCK";
		   $column['P_STOCK_LIMIT']			= "PM.P_STOCK_LIMIT";
		   $column['P_TAX']					= "PM.P_TAX";
		   $column['P_OPT']					= "PM.P_OPT";
		   $column['P_ADD_OPT']				= "PM.P_ADD_OPT";
		   $column['P_BAESONG_TYPE']		= "PM.P_BAESONG_TYPE";
		   $column['P_EVENT_UNIT']			= "PM.P_EVENT_UNIT";
		   $column['P_LIST_ICON_VIEW']		= "PM.P_LIST_ICON_VIEW";
		   $column['P_SCR']					= "PM.P_SCR";
		   $column['P_NAME']				= "PM.P_POINT_NO_USE";
		   $column['P_ST_SIZE']				= "PM.P_ST_SIZE";
		   $column['P_LIST_ICON']			= "PM.P_LIST_ICON";
		   $column['P_COLOR']				= "PM.P_COLOR";
		   $column['P_SIZE']				= "PM.P_SIZE";
		   $column['P_CATE']				= "PM.P_CATE";
		   $column['P_NUM']					= "PM.P_NUM";
		   $column['P_ICON']				= "PM.P_ICON";
		   $column['P_PARENT_CODE']			= "PM.P_PARENT_CODE";
		   $column['P_MAKER']				= "PM.P_MAKER";
		   $column['P_ORIGIN']				= "PM.P_ORIGIN";
		   $column['P_BRAND']				= "PM.P_BRAND";
		   $column['P_MODEL']				= "PM.P_MODEL";
		   $column['P_PRICE_TEXT']			= "PM.P_PRICE_TEXT";

		   return $column;
		}
}