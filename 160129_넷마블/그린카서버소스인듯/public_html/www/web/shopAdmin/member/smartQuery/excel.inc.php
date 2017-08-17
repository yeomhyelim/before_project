<?
	
	switch($strAct){
		case "dataEditExcel":

			## STEP 1. 
			## 검색 컬럼이 없으면 break.
//			if(!$_POST['de_select'] && !$_POST['de_where']) { break; }

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

//			$query		.= "LIMIT 0, 5 ";
			$result		 = $db->getExecSql("SET @RANK := 0, @PREV := ''");
			$result		 = $db->getExecSqlNoErrorMsg($query);
//			echo $query;

			/** 총개수 **/
			$resultTotal							= $db->getExecSqlNoErrorMsg($query_total);
			$total									= mysql_fetch_array($resultTotal);
			$intTotal								= $total[0];

			## 설정
			$de_select = explode(",", $_POST['de_select']);
			foreach($de_select as $key => $column):
				$column				= explode(".",$column);
				$de_select[$key]	= trim($column[1]);
			endforeach;
			$de_select_name = explode(",", $_POST['de_select_name']);
			foreach($de_select_name as $key => $column):
				$de_select_name[$key]	= trim($column);
			endforeach;
			
			$dnfile				= date("Y-m-d", time());
			$strExcelFileName	= iconv("utf-8","euc-kr", $dnfile);

		break;
	}
?>