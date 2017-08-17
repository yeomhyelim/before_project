<?
	switch($strMode){
		case "dataEdit":
			// 회원간편검색

			## STEP 1. 
			## 검색 컬럼이 없으면 break.
			if(!$_POST['de_select'] && !$_POST['de_where']) { break; }

			## STEP 2.
			## 설정 파일 불러오기
			include_once "dataEdit_{$_POST['num']}.inc.php";
			include_once "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/dataEdit/dataEdit_{$_POST['num']}.inc.php";

			
			## STEP 3
			## 설정
			require_once MALL_CONF_LIB."DataEditMgr.php";
			$dataEditModule = new DataEditModule($db, $_POST);

			## STEP 4.
			## 쿼리 만들기
			if(!$_POST['de_select']) { break; }
//			$query		= "SELECT {$_POST['de_select']} FROM MEMBER_MGR AS a LEFT OUTER JOIN MEMBER_ADD AS b ON a.M_NO = b.M_NO ";
//			$query		= sprintf($query_data, $_POST['de_select']); /** 2013.05.02 문자열크키가 큰경우 실행 안되는 버그 있음. **/
			$query		= $query_data;
			
			if($_POST['de_where_join']) :
//				if($_POST['de_where_join'] == "{code_1}"):
//					$where_join			= "WHERE A.O_STATUS = 'E'"; 
//				else:
//					$where_join			= "WHERE {$_POST['de_where_join']}"; 
//				endif;
				
				$where_join			= "WHERE {$_POST['de_where_join']}"; 

				if(eregi("B.P_CODE", $where_join)):
					$where_join			= str_replace("{de_where_join}", $where_join, $query_join_data2);
				else:
					$where_join			= str_replace("{de_where_join}", $where_join, $query_join_data1);
				endif;
			endif;
			$query		= str_replace("{query_join_data}", $where_join, $query);

			if($_POST['de_where']) { $where	 = "WHERE {$_POST['de_where']}"; }
			$query		= str_replace("{de_where}", $where, $query);

			if($_POST['de_order']) { $order	 = "ORDER BY {$_POST['de_order']}"; }
			$query		 = str_replace("{de_order}", $order, $query);
	
			$query_total = str_replace("{de_select}", "COUNT(*)", $query); 
			$query		 = str_replace("{de_select}", $_POST['de_select'], $query);
	
			$result		 = $db->getExecSql("SET @RANK := 0, @PREV := ''");

			/* 데이터 리스트 */
			/** 총개수 **/
			$resultTotal							= $db->getExecSqlNoErrorMsg($query_total);
			$total									= mysql_fetch_array($resultTotal);
			$intTotal								= $total[0];

			$intPageLine							= ( $intPageLine )			? $intPageLine	: 10;							// 리스트 개수 
			$intPage								= ( $_POST['page'] )		? $_POST['page']: 1;
			$intFirst								= ( $intTotal == 0 )		? 0				: $intPageLine * ( $intPage - 1 );


			$query		.= "LIMIT {$intFirst}, {$intPageLine} ";

			$result									= $db->getExecSqlNoErrorMsg($query);
//			echo $db->query;
			$intPageBlock							= 10;																		// 블럭 개수 
			$intListNum								= $intTotal - ( $intPageLine * ( $intPage - 1 ) );							// 번호
			$intTotPage								= ceil( $intTotal / $intPageLine );
			/* 데이터 리스트 */	

			## STEP 5.
			## 상품 코드 정보 가져오기
			require_once MALL_CONF_LIB."ProductAdmMgr.php";
			$productMgr = new ProductAdmMgr();
			$productMgr->setP_LNG($strAdmSiteLng);
			$productMgr->setP_CODE($_POST['p_code']);
			$prodRow = $productMgr->getProdView($db);

			## STEP 6.
			## 로드 메시지
			if(!$_POST['page']):
			$scriptLoadMsg = "검색완료 되었습니다.";
			endif;
		break;
	}
?>