<?php
    /**
     * /home/shop_eng/www/modules/module.php
     * @author eumshop(thav@naver.com)
     * module class
     * **/

    class Module {

		var $db;
		var $field;

		/**
		 * getMessage()
		 * 현제 사용중인 class 정보 출력
		 * **/
		function getMessage() {
			echo "module class";
		}

		/**
		 * getSelectQuery(&$query, $op)
		 * $op 형에 따라서 $query 실행
		 * **/
		function getSelectQuery(&$query, $op)
		{
			if ( $op == "OP_LIST" || $op == "OP_ALL_LIST" ) :
				return $this->db->getExecSql($query);
			elseif ( $op == "OP_SELECT" ) :
				return $this->db->getSelect($query);
			elseif ( $op == "OP_COUNT" ) :
				return $this->db->getCount($query);
			elseif ( $op == "OP_ARYLIST" ) :
				return $this->db->getArray($query);
			else :
				return -100;
			endif;
		}

		/**
		 * getSchemaTableSelect(&$db, $tableName)
		 * 테이블 명($tableName)이 존재하는지 체크
		 * 테이블이 있으면 1, 없으면 0
		 * **/
		function getSchemaTableSelect($tableName)
		{
			$intCnt = 0;
			$query	= "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '%s'";
			$query	= sprintf($query, $this->db->db);
			$result	= $this->getSelectQuery($query, "OP_LIST");
			while($row = mysql_fetch_array($result)):
				if(strtoupper($row['TABLE_NAME']) == $tableName)
					$intCnt++;
			endwhile;

			return $intCnt;
		}

		/**
		 * getSchemaProcedureSelect(&$db, $procedureName)
		 * 프로시저 명($procedureName)이 존재하는지 체크
		 * 프로시저가 있으면 1, 없으면 0
		 * **/
		function getSchemaProcedureSelect($procedureName)
		{
			$intCnt = 0;
			$query	= "SELECT ROUTINE_NAME FROM INFORMATION_SCHEMA.ROUTINES WHERE ROUTINE_SCHEMA = '%s'";
			$query	= sprintf($query, $this->db->db);
			$result	= $this->getSelectQuery($query, "OP_LIST");
			while($row = mysql_fetch_array($result)):
				if(strtoupper($row['ROUTINE_NAME']) == $procedureName)
					$intCnt++;
			endwhile;

			return $intCnt;
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

    }
?>
