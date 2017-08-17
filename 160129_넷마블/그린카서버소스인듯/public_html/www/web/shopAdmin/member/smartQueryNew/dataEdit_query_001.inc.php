<?
	$query_data		= "SET @RANK := 0, @PREV := '';";
	$result			= $db->getExecSql($query_data);

	$query_data		= "	
						SELECT

						{__MAIN_COLUMN__}   

						FROM MEMBER_MGR A                                                                                           
						LEFT OUTER JOIN MEMBER_ADD B                                                                                
						ON A.M_NO = B.M_NO                                                                                          
						LEFT OUTER JOIN                                                                                             
						(                                                                                                           
							SELECT                                                                                                  
								 A.M_NO                                                                                             
								 {__JOIN_COLUMN__}                      
							FROM                                                                                                    
							(                                                                                                       
								SELECT MF_NO, @PREV := M_NO AS M_NO, @RANK RANK FROM (                                              
									SELECT A.* FROM MEMBER_FAMILY A JOIN MEMBER_MGR B ON A.M_NO = B.M_NO                                                                     
									ORDER BY A.M_NO, A.MF_NO ASC                                                                       
								) AS TB                                                                                             
								WHERE IF(M_NO = @PREV, @RANK := @RANK + 1, @RANK := 1) <= 5                                       
							) A                                                                                                     
							JOIN MEMBER_FAMILY B                                                                                    
							ON A.MF_NO = B.MF_NO                                                                                    
							GROUP BY A.M_NO                                                                                         
						) C                                                                                                         
						ON A.M_NO = C.M_NO  
								
						{__JOIN_DATA__}
						
						{__MAIN_WHERE__}

						{__MAIN_ORDER__}


						";

	$query_join_data_1	= "

							LEFT OUTER JOIN 
							(
								SELECT
								  A.M_NO
								 ,COUNT(A.O_NO) O_BUY_CNT
								FROM ORDER_MGR A
								
								{__JOIN_WHERE__}
								
								GROUP BY A.M_NO
							) O
							ON A.M_NO = O.M_NO
													
						";

	$query_join_data_2 = "
							LEFT OUTER JOIN 
							(
								SELECT
								  A.M_NO
								 ,COUNT(A.O_NO) O_BUY_CNT
								 ,SUM(A.O_TOT_SPRICE) O_BUY_PRICE
								FROM ORDER_CART B
								JOIN ORDER_MGR A
								ON A.O_NO = B.O_NO

								{__JOIN_WHERE__}

								GROUP BY A.M_NO
							) O
							ON A.M_NO = O.M_NO
						"; // 상품코드 포함.

	$join_data			 = "";
	for($i=1;$i<=3;$i++):
		$join_data		.=	" 		
								,MAX(CASE WHEN A.RANK = {$i} THEN B.MF_NAME ELSE NULL END) MF_NAME_{$i}                                  
								,MAX(CASE WHEN A.RANK = {$i} THEN B.MF_NAME_YET ELSE NULL END) MF_NAME_YET_{$i}                           
								,MAX(CASE WHEN A.RANK = {$i} THEN B.MF_DAY ELSE NULL END) MF_DAY_{$i}                                     
								,MAX(CASE WHEN A.RANK = {$i} THEN B.MF_INFO ELSE NULL END) MF_INFO_{$i}                                   
								,MAX(CASE WHEN A.RANK = {$i} THEN B.MF_SEX ELSE NULL END) MF_SEX_{$i}                                     
								,MAX(CASE WHEN A.RANK = {$i} THEN B.MF_FEED ELSE NULL END) MF_FEED_{$i}                                   
								,MAX(CASE WHEN A.RANK = {$i} THEN B.MF_FEED_NAME ELSE NULL END) MF_FEED_NAME_{$i}                         
								,MAX(CASE WHEN A.RANK = {$i} THEN B.MF_HOSP ELSE NULL END) MF_HOSP_{$i}                                   
								,MAX(CASE WHEN A.RANK = {$i} THEN B.MF_HOSP_YET ELSE NULL END) MF_HOSP_YET_{$i}	";
	endfor;

	$where_join = "";
	if($strDE_WHERE_JOIN):

		if($strDE_WHERE_JOIN) { $strDE_WHERE_JOIN = "WHERE {$strDE_WHERE_JOIN}"; }

		if(eregi("B.P_CODE", $strDE_WHERE_JOIN)):
			$where_join = str_replace("{__JOIN_WHERE__}", $strDE_WHERE_JOIN, $query_join_data_2);
		else:
			$where_join = str_replace("{__JOIN_WHERE__}", $strDE_WHERE_JOIN, $query_join_data_1);
		endif;
	endif;

	if($strDE_WHERE) { $strDE_WHERE = "WHERE {$strDE_WHERE}"; }
	if($strDE_ORDER) { $strDE_ORDER = "ORDER BY {$strDE_ORDER}"; }

	$query_data			 = str_replace("{__MAIN_COLUMN__}" , $strDE_SELECT , $query_data);
	$query_data			 = str_replace("{__JOIN_COLUMN__}" , $join_data    , $query_data);
	$query_data			 = str_replace("{__JOIN_DATA__}"   , $where_join   , $query_data);
	$query_data			 = str_replace("{__MAIN_WHERE__}"  , $strDE_WHERE  , $query_data);
	$query_data			 = str_replace("{__MAIN_ORDER__}"  , $strDE_ORDER  , $query_data);

	echo $query_data;
?>

