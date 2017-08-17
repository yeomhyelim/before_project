<?
#/*====================================================================*/# 
#|화일명	: ProductList.module.php									|# 
#|작성자	: Park Young-MI												|# 
#|작성일	: 2014-01-29												|# 
#|작성내용	: 상품리스트 모듈(사용자)									|# 
#/*====================================================================*/# 

require_once "Module.php";

class ProductListModule extends Module2
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
			    ,P.P_REP_DT                                                            
			    ,P.P_CONSUMER_PRICE                                                    
			    ,P.P_SALE_PRICE                                                        
			    ,P.P_QTY                                                              
			    ,P.P_WEB_VIEW                                                          
			    ,P.P_MOB_VIEW                                                         
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
			    ,P.P_ORDER                  ";
			
			
			$fromWhere		= "WHERE P.P_CODE IS NOT NULL	";

			//승인된 상품만 보여지게 2015.05.27 kjp
			$fromWhere	  .= "AND P.P_APPR = 'Y'		";


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
			
			## 6.상품웹보임
			if ($param['P_WEB_VIEW'] == "Y"){
				## 6.1 다국어 출력여부
				if ($param['P_MANY_LNG_VIEW'] == "Y") $fromWhere .= "AND PI.P_WEB_VIEW = 'Y'		";
				else $fromWhere	  .= "AND P.P_WEB_VIEW = 'Y'		";
			}

			## 7.상품모바일보임
			if ($param['P_MOB_VIEW'] == "Y"){
				$fromWhere	  .= "AND P.P_MOB_VIEW = 'Y'		";
			}

			## 8.상품아이콘검색
			if ($param['P_ICON']){
				$fromWhere	  .= "AND P.P_ICON = '".$param['P_ICON']."'			";
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
					case "N":
						$fromWhere .= " ( PI.P_NAME LIKE '%".mysql_real_escape_string($param['P_SEARCH_KEY'])."%' OR PI.P_SEARCH_TEXT LIKE '%".mysql_real_escape_string($param['P_SEARCH_KEY'])."%')";
					break;
					case "C":
						$fromWhere .= "	P.P_NUM LIKE '%".mysql_real_escape_string($param['P_SEARCH_KEY'])."%'			";
					break;
					case "M":
						$fromWhere .= "	P.P_MAKER LIKE '%".mysql_real_escape_string($param['P_SEARCH_KEY'])."%'		";
					break;
					case "O":
						$fromWhere .= "	P.P_ORIGIN LIKE '%".mysql_real_escape_string($param['P_SEARCH_KEY'])."%'		";
					break;
					case "D":
						$fromWhere .= "	P.P_MODEL LIKE '%".mysql_real_escape_string($param['P_SEARCH_KEY'])."%'		";
					break;
					case "W":
						$fromWhere .= "	P.P_WEIGHT  = ".mysql_real_escape_string($param['P_SEARCH_KEY'])."				";
					break;
				}
			}

			## 14.상품좋아요
			$prodLikeJoin = "";
			if ($param['P_PROD_LIKE'] == "prodList" || $param['P_PROD_LIKE'] == "myList"){
				##1. 컬럼 추가
				$fromColumn    .= " ,IFNULL(PML.P_LIKE_TYPE,'N') P_LIKE_TYPE			";
				
				##2. JOIN절 정의
				if ($param['P_PROD_LIKE'] == "prodList") $prodLikeJoin .= "LEFT OUTER	";
			
				$prodLikeJoin .= "JOIN (								";
				$prodLikeJoin .= "	SELECT								";
				$prodLikeJoin .= "		 P_CODE							";
				$prodLikeJoin .= "     ,'Y' P_LIKE_TYPE					";
				$prodLikeJoin .= "	FROM MEMBER_PROD_LIKE				";
				$prodLikeJoin .= " WHERE M_NO = ".$param['M_NO']."		";
				$prodLikeJoin .= ") PML									";
				$prodLikeJoin .= "ON P.P_CODE = PML.P_CODE				";
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

					case "BD":
						$fromSort .= "ORDER BY PBD.UB_P_GRADE DESC ";	//판매인기도순
					break;

					case "SD":
						$fromSort .= "ORDER BY PSD.P_SELL_QTY DESC ";	//누적판매도순
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

			## 18. 상품리뷰 사용 및 판매인기도순(정렬)
			$prodReviewJoin = $prodSellJoin = "";
			if ($param['P_REVIEW_SHOW'] == "Y")
			{
				$fromColumn    .= ",PBD.UB_P_GRADE AS P_GRADE						";
				$fromColumn    .= ",PBD.UB_P_GRADE_CNT AS P_GRADE_CNT				";

				$prodReviewJoin .= "LEFT OUTER JOIN									";
				$prodReviewJoin .= "(												";
				$prodReviewJoin .= "    SELECT										";
				$prodReviewJoin .= "         A.UB_P_CODE							";
				$prodReviewJoin .= "        ,SUM(A.UB_P_GRADE) UB_P_GRADE			";
				$prodReviewJoin .= "        ,COUNT(A.UB_P_GRADE) UB_P_GRADE_CNT     ";
				$prodReviewJoin .= "    FROM BOARD_UB_PROD_REVIEW A					";
				$prodReviewJoin .= "    WHERE A.UB_P_CODE IS NOT NULL				";
				$prodReviewJoin .= "        AND A.UB_P_CODE != ''					";
				$prodReviewJoin .= "    GROUP BY A.UB_P_CODE						";
				$prodReviewJoin .= ") PBD											";
				$prodReviewJoin .= "ON P.P_CODE = PBD.UB_P_CODE						";
			}

			## 19. 상품정렬(누적사용순사용)
			if ($param['P_ORDER_SHOW'] == "Y")
			{
				$prodSellJoin .= "LEFT OUTER JOIN                           ";
				$prodSellJoin .= "(                                         ";
				$prodSellJoin .= "    SELECT                                ";
				$prodSellJoin .= "         A.P_CODE                         ";
				$prodSellJoin .= "        ,SUM(A.OC_QTY) P_SELL_QTY         ";
				$prodSellJoin .= "    FROM ORDER_CART A						";
				$prodSellJoin .= "    JOIN ORDER_MGR B						";
				$prodSellJoin .= "    ON A.O_NO = B.O_NO                    ";
				$prodSellJoin .= "    WHERE A.OC_NO IS NOT NULL             ";
				$prodSellJoin .= "        AND B.O_STATUS = 'E'              ";
				$prodSellJoin .= "    GROUP BY A.P_CODE                     ";
				$prodSellJoin .= ") PSD                                     ";
				$prodSellJoin .= "ON P.P_CODE = PSD.P_CODE                  ";	
			}

			## 20.추가상품검색
			$prodAddSearchJoin	= "";
			if ($param['P_ADD_SEARCH_SHOW'] == "Y"){
				
				$prodAddSearchJoin .= "LEFT OUTER JOIN PRODUCT_SEARCH PSER	";
				$prodAddSearchJoin .= "ON P.P_CODE = PSER.PS_P_CODE			";

				$strAddSearchWhere  = "";
				for($i=1;$i<=10;$i++){
					$strAddSearchKey = $param['P_ADD_SEARCH'.$i];
					if ($strAddSearchKey) {
						$arrAddSearchKey	= explode(",",$strAddSearchKey);
						foreach($arrAddSearchKey as $key => $val){
							if($strAddSearchWhere) { $strAddSearchWhere .= " AND "; }
							$strAddSearchWhere .= " PSER.PS_PROD_SEARCH_".$i." LIKE '%".$val."%'";
						}
					}
				}
				
				
				if ($strAddSearchWhere){
					//$strAddSearchWhere = substr($strAddSearchWhere,0,strlen($strAddSearchWhere)-4);
					$fromWhere		   .= " AND (".$strAddSearchWhere.")		";
				}
			}

			##21.상품옵션수사용
			$prodOptJoin = "";
			if ($param['P_OPT_SHOW'] == "Y"){
				$fromColumn	 .= ",IFNULL(POPT.P_OPT_CNT,0) P_OPT_CNT			";

				$prodOptJoin .= "LEFT OUTER JOIN (			";
				$prodOptJoin .= "	SELECT 					";
				$prodOptJoin .= "		 P_CODE				";
				$prodOptJoin .= "		,COUNT(*) P_OPT_CNT ";
				$prodOptJoin .= "	FROM PRODUCT_OPT		";
				$prodOptJoin .= "	GROUP BY P_CODE			";
				$prodOptJoin .= ") POPT						";
				$prodOptJoin .= "ON P.P_CODE = POPT.P_CODE	";
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
			
			##3.상품좋아요
			$query .= $prodLikeJoin;
			
			##4.상품리뷰 사용 및 판매인기도순(정렬)
			$query .= $prodReviewJoin;

			##5.상품정렬(누적사용순사용)
			$query .= $prodSellJoin;
			
			##6.상품이미지
			$query .= $prodImgJoin;
			
			##7.상품브랜드
			$query .= $prodBrandJoin;

			##8.상품추가검색
			$query .= $prodAddSearchJoin;

			##9.상품옵션수
			$query .= $prodOptJoin;

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
//			if ($param["LIMIT"]){
//				$query .= "LIMIT ".$param["LIMIT"];
//			}
//
//			if ($param["LIMIT"] && $param["LIMIT_LINE"]){
//				$query .= ",".$param["LIMIT_LINE"];
//			}

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