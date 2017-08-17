<?
#/*====================================================================*/# 
#|화일명	: ProductAdmList.module.php									|# 
#|작성자	: Park Young-MI												|# 
#|작성일	: 2014-01-29												|# 
#|작성내용	: 상품리스트 모듈(관리자)									|# 
#/*====================================================================*/# 

require_once "Module.php";

class ProductAdmListModule extends Module2
{
		function getProductListSelectEx($op, $param) 
		{
			## 주 COLUMN 정의
			$fromColumn				= "
				 P.P_CODE                                                              
			    ,P.P_CATE                                                              
			    ,PI.P_NAME
			    ,PI.P_ETC
			    ,P.P_NUM
			    ,P.P_LAUNCH_DT
			    ,DATE_FORMAT(P.P_REP_DT, '%Y-%m-%d') P_REP_DT
			    ,P.P_CONSUMER_PRICE
			    ,P.P_SALE_PRICE
			    ,P.P_QTY
			    ,P.P_POINT
			    ,P.P_EVENT_UNIT
			    ,P.P_EVENT
			    ,P.P_LIST_ICON
			    ,P.P_ICON
			    ,P.P_BRAND
			    ,P.P_MAKER
			    ,P.P_ORIGIN
			    ,P.P_MODEL
			    ,PI.P_PRICE_TEXT
			    ,PI.P_SEARCH_TEXT
			    ,P.P_COLOR
			    ,P.P_SIZE
			    ,P.P_REG_DT
			    ,P.P_ORDER
			    ,P.P_POINT_TYPE
			    ,P.P_POINT_OFF1
			    ,P.P_POINT_OFF2
			    ,P.P_ADD_OPT
			    ,IFNULL(P.P_SHOP_NO,0) P_SHOP_NO
			    ,P.P_REG_DT
				,P.P_STOCK_LIMIT
				,P.P_STOCK_OUT
				,P.P_RESTOCK
				,P.P_PRICE_FILTER
				,(IFNULL(P.P_SALE_PRICE,0) - IFNULL(P.P_STOCK_PRICE,0)) P_COMMISION_PRICE
				,TRUNCATE(CEILING(((IFNULL(P.P_SALE_PRICE,0) - IFNULL(P.P_STOCK_PRICE,0)) / IFNULL(P.P_SALE_PRICE,0)) * 100),0) P_COMMISION_RATE
				,SUBSTRING(P.P_ICON,1,1) ICON1
				,SUBSTRING(P.P_ICON,3,1) ICON2
				,SUBSTRING(P.P_ICON,5,1) ICON3
				,SUBSTRING(P.P_ICON,7,1) ICON4
				,SUBSTRING(P.P_ICON,9,1) ICON5
				,SUBSTRING(P.P_ICON,11,1) ICON6
				,SUBSTRING(P.P_ICON,13,1) ICON7
				,SUBSTRING(P.P_ICON,15,1) ICON8
				,SUBSTRING(P.P_ICON,17,1) ICON9
				,SUBSTRING(P.P_ICON,19,1) ICON10
				";
			
			## 다국어출력여부 사용
			$fromViewColumn = ",P.P_WEB_VIEW
								,P.P_MOB_VIEW ";
			
			if ($param['P_MANY_LNG_VIEW'] == "Y"){
				$fromViewColumn .= ",PI.P_WEB_VIEW
									,PI.P_MOB_VIEW ";
			}
			$fromColumn .= $fromViewColumn;
			
			$fromWhere		= "WHERE P.P_CODE IS NOT NULL	";
			## 1.카테고리 검색
			$prodShareJoin	= "";
			if ($param["P_CATE"]){
				
				## 1. JOIN절 정의
				$prodShareJoin  = "LEFT OUTER JOIN                                                            ";
				$prodShareJoin .= "(                                                                          ";
				$prodShareJoin .= "    SELECT                                                                 ";
				$prodShareJoin .= "        P_CODE                                                             ";
				$prodShareJoin .= "        ,'Y' P_SHARE_YN                                                    ";
				$prodShareJoin .= "    FROM PRODUCT_SHARE                                                     ";
				$prodShareJoin .= "    WHERE PS_P_CATE LIKE '".mysql_real_escape_string($param['P_CATE'])."%' ";
				$prodShareJoin .= "    GROUP BY P_CODE                                                        ";
				$prodShareJoin .= ") PS                                                                       ";
				$prodShareJoin .= "ON P.P_CODE = PS.P_CODE                                                    ";
				
				## 2. 카테고리 검색 정의
				$fromWhere	   .= "AND (P.P_CATE LIKE '".mysql_real_escape_string($param['P_CATE'])."%' OR PS.P_SHARE_YN = 'Y')	";
			}

			## 2.브랜드 검색
			if ($param['P_BRAND']){
				$fromWhere	   .= "AND P.P_BRAND  = '".mysql_real_escape_string($param['P_BRAND'])."'				";
			}

			## 3.입점사 검색
			if ($param['P_SHOP_NO']){
				$fromWhere	   .= "AND IFNULL(P.P_SHOP_NO,0)  = ".mysql_real_escape_string($param['P_SHOP_NO'])."	";
			}
			
			## 4.상품출시일 검색(사용자)
			if ($param['P_LAUNCH_START_DT'] && $param['P_LAUNCH_END_DT']){
				$fromWhere	  .= "AND P.P_LAUNCH_DT BETWEEN DATE_FORMAT('".$param['P_LAUNCH_START_DT']."','%Y-%m-%d 00:00:00') ";
				$fromWhere    .= "					      AND DATE_FORMAT('".$param['P_LAUNCH_END_DT']."','%Y-%m-%d 23:59:59')  ";
			}

			## 5.상품등록일 검색(사용자)
			if ($param['P_REP_START_DT'] && $param['P_REP_END_DT']){
				$fromWhere	  .= "AND P.P_REP_DT BETWEEN DATE_FORMAT('".$param['P_REP_START_DT']."','%Y-%m-%d 00:00:00')		";
				$fromWhere    .= "					      AND DATE_FORMAT('".$param['P_REP_END_DT']."','%Y-%m-%d 23:59:59')		";
			}
			
			## 6.상품보임
			if ($param['P_VIEW']){
				$fromViewWhere					= "";
				$fromViewWhere['webYes']		= "P.P_WEB_VIEW = 'Y'";
				$fromViewWhere['webNo']			= "P.P_WEB_VIEW = 'N'";
				$fromViewWhere['mobileYes']		= "P.P_MOB_VIEW = 'Y'";
				$fromViewWhere['mobileNo']		= "P.P_MOB_VIEW = 'N'";
				$fromViewWhere['webMobileYes']	= "(P.P_WEB_VIEW = 'Y' AND P.P_MOB_VIEW = 'Y')";
				$fromViewWhere['webMobileNo']	= "(P.P_WEB_VIEW = 'N' AND P.P_MOB_VIEW = 'N')";
				
				## 다국어출력검색일때
				if ($param['P_MANY_LNG_VIEW'] == "Y"){
					$fromViewWhere						= "";
					foreach($param['P_USE_LNG'] as $key => $lngVal){
						$temp							= "";
						if ($key > 0) { $temp .= " OR ";}

						$fromViewWhere['webYes']		.= $temp."P{$lngVal}.P_WEB_VIEW = 'Y'";
						$fromViewWhere['webNo']			.= $temp."P{$lngVal}.P_WEB_VIEW = 'N'";
						$fromViewWhere['mobileYes']		.= $temp."P{$lngVal}.P_MOB_VIEW = 'Y'";
						$fromViewWhere['mobileNo']		.= $temp."P{$lngVal}.P_MOB_VIEW = 'N'";
						$fromViewWhere['webMobileYes']	.= $temp."(P{$lngVal}.P_WEB_VIEW = 'Y' AND P{$lngVal}.P_MOB_VIEW = 'Y')";
						$fromViewWhere['webMobileNo']	.= $temp."(P{$lngVal}.P_WEB_VIEW = 'N' AND P{$lngVal}.P_MOB_VIEW = 'N')";
					}
				}

				$fromWhere .= "AND (".$fromViewWhere[$param['P_VIEW']].")";
			}

			## 7.1 품절여부
			if ($param['P_STOCK_OUT'] == "Y"){
				$fromWhere	  .= "AND P.P_STOCK_OUT = 'Y'		";
			}
			## 7.2 재입고
			if ($param['P_RESTOCK'] == "Y"){
				$fromWhere	  .= "AND P.P_RESTOCK = 'Y'			";
			}
			## 7.3 무제한
			if ($param['P_STOCK_LIMIT'] == "Y"){
				$fromWhere	  .= "AND P.P_STOCK_LIMIT = 'Y'		";
			}
			
			## 8.상품아이콘검색
			if ($param['P_ICON']){
				$aryIconSubStringStartPoint = array(1 => 1, 2 => 3, 3 => 5, 4 => 7, 5 => 9, 6 => 11, 7 => 13, 8 => 15, 9 => 17, 10 => 19);
				$temp		= "";
				foreach($param['P_ICON'] as $key => $data):
					if($aryIconSubStringStartPoint[$data]):
						if($temp) { $temp .= " OR "; }
						$temp   .= "SUBSTRING(P_ICON, {$aryIconSubStringStartPoint[$data]}, 1) = 'Y'";
					endif;
				endforeach;
				$temp		   = "($temp)";
				$fromWhere	  .= "AND {$temp}	";
			}

			## 9.상품컬러검색
			if ($param['P_COLOR']){
				$fromWhere	  .= "AND P.P_COLOR = '".$param['P_COLOR']."'		";
			}

			## 10.상품사이즈검색
			if ($param['P_SIZE']){
				$fromWhere	  .= "AND P.P_SIZE = '".$param['P_SIZE']."'			";
			}

			## 11.가격검색
			if ($param['P_START_PRICE'] && $param['P_END_PRICE']){
				$fromWhere	  .= "AND P.P_SALE_PRICE BETWEEN ".$param['P_START_PRICE']." AND ".$param['P_END_PRICE']."			";
			}
			
			## 12.상품리스트아이콘
			if ($param['P_LIST_ICON']){
				$fromWhere	  .= "AND P.P_LIST_ICON LIKE  '%".mysql_real_escape_string($param['P_LIST_ICON'])."%'				";
			}

			## 13.상품검색
			if ($param['P_SEARCH_KEY'] && $param['P_SEARCH_FIELD']){
				$fromWhere    .= "	AND ";
				switch ($param['P_SEARCH_FIELD']){
					case "name":
						$fromWhere .= " PI.P_NAME LIKE '%".mysql_real_escape_string($param['P_SEARCH_KEY'])."%' ";
					break;
					case "code":
						$fromWhere .= "	(P.P_CODE LIKE '%".mysql_real_escape_string($param['P_SEARCH_KEY'])."%' OR P.P_NUM LIKE '%".mysql_real_escape_string($param['P_SEARCH_KEY'])."%')			";
					break;
					case "maker":
						$fromWhere .= "	P.P_MAKER LIKE '%".mysql_real_escape_string($param['P_SEARCH_KEY'])."%'		";
					break;
					case "orgin":
						$fromWhere .= "	P.P_ORIGIN LIKE '%".mysql_real_escape_string($param['P_SEARCH_KEY'])."%'		";
					break;
					case "model":
						$fromWhere .= "	P.P_MODEL LIKE '%".mysql_real_escape_string($param['P_SEARCH_KEY'])."%'		";
					break;
					case "search":
						$fromWhere .= "	PI.P_SEARCH_TEXT LIKE '%".mysql_real_escape_string($param['P_SEARCH_KEY'])."%'		";
					break;
					case "memo":
						$fromWhere .= "	PI.P_MEMO LIKE '%".mysql_real_escape_string($param['P_SEARCH_KEY'])."%'		";
					break;
					case "weight":
						$fromWhere .= "	P.P_WEIGHT  = ".mysql_real_escape_string($param['P_SEARCH_KEY'])."				";
					break;
					case "all":
						$fromWhere .= " (PI.P_NAME LIKE '%".mysql_real_escape_string($param['P_SEARCH_KEY'])."%' ";
						$fromWhere .= "	OR (P.P_CODE LIKE '%".mysql_real_escape_string($param['P_SEARCH_KEY'])."%' OR P.P_NUM LIKE '%".mysql_real_escape_string($param['P_SEARCH_KEY'])."%')			";
						$fromWhere .= "	OR P.P_MAKER LIKE '%".mysql_real_escape_string($param['P_SEARCH_KEY'])."%'		";
						$fromWhere .= "	OR P.P_ORIGIN LIKE '%".mysql_real_escape_string($param['P_SEARCH_KEY'])."%'		";
						$fromWhere .= "	OR P.P_MODEL LIKE '%".mysql_real_escape_string($param['P_SEARCH_KEY'])."%'		";
						$fromWhere .= "	OR PI.P_SEARCH_TEXT LIKE '%".mysql_real_escape_string($param['P_SEARCH_KEY'])."%'		";
						$fromWhere .= "	OR PI.P_MEMO LIKE '%".mysql_real_escape_string($param['P_SEARCH_KEY'])."%')		";
					break;
				}
			}

			
			## 15.상품정렬
			$fromSort = "";
			if ($param['P_SEARCH_SORT']){
				switch($param['P_SEARCH_SORT']){
					case "RA":
						$fromSort .= "ORDER BY P.P_SALE_PRICE ASC ";	
					break;
					case "RD":
						$fromSort .= "ORDER BY P.P_SALE_PRICE DESC ";
					break;
					case "NA":
						$fromSort .= "ORDER BY PI.P_NAME ASC ";
					break;
					case "ND":
						$fromSort .= "ORDER BY PI.P_NAME DESC ";	
					break;
					case "PA":
						$fromSort .= "ORDER BY P.P_POINT ASC ";
					break;
					case "PD":
						$fromSort .= "ORDER BY P.P_POINT DESC ";	
					break;
					case "MA":
						$fromSort .= "ORDER BY P.P_MAKER ASC ";	
					break;
					case "MD":
						$fromSort .= "ORDER BY P.P_MAKER DESC ";
					break;
					case "TD":
						$fromSort .= "ORDER BY P.P_REG_DT DESC ";
					break;
					case "TA":
						$fromSort .= "ORDER BY P.P_REG_DT ASC ";
					break;

					case "PQD":
						$fromSort .= "ORDER BY P.P_QTY DESC ";	//재고
					break;
					case "PQA":
						$fromSort .= "ORDER BY P.P_QTY ASC ";	//재고
					break;

					case "PVD":
						$fromSort .= "ORDER BY P.P_WEB_VIEW DESC, P.P_MOB_VIEW DSSC ";	//상품출력
					break;
					case "PVA":
						$fromSort .= "ORDER BY P.P_WEB_VIEW ASC, P.P_MOB_VIEW ASC ";	
					break;

					case "PCRD":
						$fromSort .= "ORDER BY P.P_COMMISION_RATE DESC ";	//수수료
					break;
					case "PCRD":
						$fromSort .= "ORDER BY P.P_COMMISION_RATE ASC ";	//수수료
					break;
					
					case "SD":
						$fromSort .= "ORDER BY PS.SH_COM_NAME DESC ";	//입점사별
					break;
					case "SA":
						$fromSort .= "ORDER BY PS.SH_COM_NAME ASC ";	//입점사별
					break;

					case "PSD":
						$fromSort .= "ORDER BY P.P_ORDER DESC ";	//우선순위
					break;
					case "PSA":
						$fromSort .= "ORDER BY P.P_ORDER ASC ";	//우선순위
					break;
					
					case "PAU":
						$fromSort .= "ORDER BY PAU.P_AUC_END_DT DESC ";	//우선순위
					break;

					default:
						$fromSort .= "ORDER BY P.P_ORDER ASC,P.P_CODE DESC ";
					break;
				}
			}

			## 16.상품이미지 정보 주기
			$prodImgJoin = "";
			if ($param['P_IMG_SHOW'] == "Y"){
				$fromColumn .= ",PIMG.PM_REAL_NAME					"; 
				
				$prodImgJoin .= "LEFT OUTER JOIN PRODUCT_IMG PIMG	";
				$prodImgJoin .= "ON P.P_CODE = PIMG.P_CODE			";
				$prodImgJoin .= "AND PIMG.PM_TYPE = 'list'			";
			}

			## 17.상품브랜드 정보 주기
			$prodBrandJoin = "";
			if ($param['P_BRAND_SHOW'] == "Y"){
				$fromColumn    .= ",PBR.PR_NAME AS P_BRAND_NAME			"; 
				
				$prodBrandJoin .= "LEFT OUTER JOIN PRODUCT_BRAND PBR	";
				$prodBrandJoin .= "ON P.P_BRAND = PBR.PR_NO				";
			}

			
			## 18.상품입점사정보 정보 주기
			$prodShopInfoJoin = "";
			if ($param['P_SHOP_SITE_SHOW'] == "Y"){
				
				$prodShopInfoJoin .= "LEFT OUTER JOIN SHOP_MGR PS	";
				$prodShopInfoJoin .= "ON P.P_SHOP_NO = PS.SH_NO		";
				
				if($param["P_LNG"]){
					$fromColumn .= " ,SI.SH_COM_NAME						"; 
				$prodShopInfoJoin .= "LEFT OUTER JOIN SHOP_INFO_".$param["P_LNG"]." SI	";
				$prodShopInfoJoin .= "ON P.P_SHOP_NO = SI.SH_NO		";
				}else{
					$fromColumn .= " ,PS.SH_COM_NAME						"; 
				}
			}

			
			## 19.상품출력정보언어별 모두 보여주기
			$prodManyLngJoin		= "";
			//if ($param['P_MANY_LNG_VIEW_SHOW'] == "Y"){
			if ($param['P_MANY_LNG_VIEW'] == "Y"){
				foreach($param['P_USE_LNG'] as $key => $lngVal){
					$fromColumn		 .= ",P{$lngVal}.P_WEB_VIEW AS P_WEB_VIEW_{$lngVal}		";
					$fromColumn		 .= ",P{$lngVal}.P_MOB_VIEW AS P_MOB_VIEW_{$lngVal}		";

					$prodManyLngJoin .= "LEFT OUTER JOIN PRODUCT_INFO_{$lngVal} P{$lngVal}	";
					$prodManyLngJoin .= "ON P.P_CODE = P{$lngVal}.P_CODE					";
				}
			}

			## 20.상품경매관리 정보 보이기
			$prodAuctionJoin = "";
			if ($param['P_AUCTION_SHOW'] == "Y"){
				$fromColumn .= ",PAU.P_AUC_ST_DT							";
				$fromColumn .= ",PAU.P_AUC_END_DT							";
				$fromColumn .= ",PAU.P_AUC_SUC_DT							";
				$fromColumn .= ",PAU.P_AUC_ST_PRICE							";
				$fromColumn .= ",PAU.P_AUC_RIGHT_PRICE						";
				$fromColumn .= ",PAU.P_AUC_BEST_PRICE						";
				$fromColumn .= ",PAU.P_AUC_SUC_PRICE						";
				$fromColumn .= ",PAU.P_AUC_SUC_M_NO							";
				$fromColumn .= ",PAU.P_AUC_STATUS							";
				$fromColumn .= ",PAUM.M_F_NAME								";
				$fromColumn .= ",PAUM.M_L_NAME								";
				$fromColumn .= ",PAUM.M_MAIL								";
				$prodAuctionJoin .= "JOIN PRODUCT_AUCTION PAU				";
				$prodAuctionJoin .= "ON P.P_CODE = PAU.P_CODE				";
				$prodAuctionJoin .= "LEFT OUTER JOIN MEMBER_MGR PAUM		";
				$prodAuctionJoin .= "ON PAU.P_AUC_SUC_M_NO = PAUM.M_NO		";

				
				## 경매기간 검색
				if ($param['P_AUC_START_DT'] && $param['P_AUC_END_DT']){
					$fromWhere	  .= "AND (PAU.P_AUC_ST_DT  >= DATE_FORMAT('".$param['P_AUC_START_DT']."','%Y-%m-%d 00:00:00')		";
					$fromWhere    .= "	   AND PAU.P_AUC_END_DT <= DATE_FORMAT('".$param['P_AUC_END_DT']."','%Y-%m-%d 23:59:59'))	";
				}

				## 경매상태검색
				if ($param['P_AUC_STATUS']){
					$fromWhere	  .= "AND PAU.P_AUC_STATUS  = '".$param['P_AUC_STATUS']."'		";
				}
			}
	
			$column['OP_LIST']		= $fromColumn;
			$column['OP_SELECT']	= $fromColumn;
			$column['OP_COUNT']		= "COUNT(*)";
			$column['OP_ARYTOTAL']	= $fromColumn;

			## query 정의
			##1.주 테이블
			$query  = "SELECT                                                                     ";
			$query .= $column[$op];
			$query .= "FROM PRODUCT_MGR P		                                                  ";
			$query .= "JOIN PRODUCT_INFO_".$param["P_LNG"]." PI                                   ";
			$query .= "ON P.P_CODE = PI.P_CODE                                                    ";
			
			##2.상품공유
			$query .= $prodShareJoin;
						
			##3.상품이미지
			$query .= $prodImgJoin;
			
			##4.상품브랜드
			$query .= $prodBrandJoin;

			##5.상품입점사정보
			$query .= $prodShopInfoJoin;

			##6.상품출력정보언어별
			$query .= $prodManyLngJoin;
			
			##7.상품경매관리
			$query .= $prodAuctionJoin;

			##91.검색
			$query .= $fromWhere;
			
			##92.정렬
			if (!$fromSort) $fromSort = "ORDER BY P.P_ORDER ASC,P.P_CODE DESC					";
			$query .= $fromSort;

			##92.limit
			if($param["LIMIT_LINE"]):
				if(!$param["LIMIT"]) { $param["LIMIT"] = 0; }
				$query .= "LIMIT {$param['LIMIT']}, {$param['LIMIT_LINE']}";
			endif;
			//PRINT_R($query);
			return $this->getSelectQuery($query, $op);
		}



		/* 상품 브랜드 리스트 */
		function getProductBrandListSelectEx($op,$param) 
		{
			$column['OP_LIST']		= "  P.P_BRAND
										,MAX(PBL.PL_PR_NAME) P_BRAND_NAME
			";

			$column['OP_SELECT']		= "  P.P_BRAND
										,MAX(PBL.PL_PR_NAME) P_BRAND_NAME
			";

			$column['OP_ARYTOTAL']		= "  P.P_BRAND
										,MAX(PBL.PL_PR_NAME) P_BRAND_NAME
			";

			$column['OP_COUNT']		= "COUNT(*)";

			$where					= "";
			if ($param['P_SHOP_NO'] > 0){
				$where			   .= " AND P.P_BRAND = {$param['P_SHOP_NO']}	";
			}

			$query  = "SELECT									";
			$query .= $column[$op];
			$query .= "FROM PRODUCT_MGR P						";
			$query .= "JOIN PRODUCT_BRAND_LNG PBL				";
			$query .= "ON P.P_BRAND = PBL.PL_PR_NO				";
			$query .= "WHERE P.P_CODE IS NOT NULL				";
			$query .= $where;
			$query .= "GROUP BY P.P_BRAND						";
		
			return $this->getSelectQuery($query, $op);
		}

		function getProductDisplayListSelectEx($op,$param)
		{
			$query  = "SELECT * FROM ".TBL_ICON_MGR." WHERE IC_TYPE = '".$param['IC_TYPE']."'";
			$query .= " ORDER BY IC_NO ASC ";

			return $this->getSelectQuery($query, $op);
		}

		function getProductShopList($op,$param = "")
		{
			$query  = "SELECT A.* FROM (					";
			$query .= "SELECT 0 SH_NO,'본사' SH_COM_NAME	";
			$query .= "UNION								";
			$query .= "SELECT SH_NO,SH_COM_NAME FROM ".TBL_SHOP_MGR;
			$query .= "	WHERE SH_APPR = 'Y'					";
			$query .= ") A									";
			
			if ($param['SHOP_LIST']){
				$query .= " WHERE A.SH_NO IN (".$param['SHOP_LIST'].")	";
			}

			$qeury .= "	ORDER BY A.SH_COM_NAME ASC	";
			return $this->getSelectQuery($query, $op);
		}

			/* 공유카테고리 리스트 */
		function getProductShareListSelectEx($op,$param = "")
		{
			if(!$param) { $param = array();}
			$query  = "SELECT * FROM ".TBL_PRODUCT_SHARE."			";
			$query .= "WHERE P_CODE = '".$param['P_CODE']."'		";
			$query .= "ORDER BY PS_NO ASC							";
			
			return $this->getSelectQuery($query, $op);
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
}
?>