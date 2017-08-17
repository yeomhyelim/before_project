<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2014-08-26												|# 
#|작성내용	: 디자인 설정 관리 모듈 클레스								|# 
#/*====================================================================*/# 

require_once "Module.php";

class DesignSetModule extends Module2
{
	
		function getDesignSetSelectEx($op, $param)
		{
			## 체크

			## column 설정
			$aryColumn[] = "DS.*";

			## 검색(텍스트)
			## 기본 설정
			$aryWhere1 = ""; 

			## 공백 제거

			## search query 설정

			## 검색(가입일)

			## where 설정
			if($param['DS_NO']) { $aryWhere1[] = "DS.DS_NO = {$param['DS_NO']}"; }
			if($param['DS_TYPE']) { $aryWhere1[] = "DS.DS_TYPE = '{$param['DS_TYPE']}'"; }
			if($param['DS_CODE']) { $aryWhere1[] = "DS.DS_CODE = '{$param['DS_CODE']}'"; }
			if($param['DS_VAL']) { $aryWhere1[] = "DS.DS_VAL = '{$param['DS_VAL']}'"; }

			## join 설정

			## order by 설정
			$aryOrderBy['dsNoAsc']			= "DS.DS_NO ASC";
			$aryOrderBy['dsNoDesc']			= "DS.DS_NO DESC";
			$strOrderBy						= $aryOrderBy[$param['ORDER_BY']];

			## limit 설정
			if($param['LIMIT']):
				list($param['LIMIT_START'], $param['LIMIT_END']) = explode(",", $param['LIMIT']);
			endif;
			if($param['LIMIT_END']):
				if(!$param['LIMIT_START']) { $param['LIMIT_START'] = 0; }
				$strLimit					= "{$param['LIMIT_START']},{$param['LIMIT_END']}";
			endif;
			
			## 쿼리 만들기
			if($aryColumn) { $strColumn = implode(",", $aryColumn); } 
			if($op == "OP_COUNT") { $strColumn = "COUNT(*)"; }
			if(!$strColumn) { $strColumn = "*"; }
			if($aryWhere1) { $strWhere1 = "WHERE " .  implode(" AND ", $aryWhere1); } 
//			if($aryWhere2) { $strWhere2 = "WHERE " .  implode(" AND ", $aryWhere2); } 
//			if($aryWhere3) { $strWhere3 = "WHERE " .  implode(" AND ", $aryWhere3); } 
			if($strOrderBy) { $strOrderBy = "ORDER BY {$strOrderBy}"; }
			if($strLimit) { $strLimit = "LIMIT {$strLimit}"; }

			$SQL  = " SELECT {$strColumn}                                               ";
			$SQL .= " FROM                                                              ";
			$SQL .= "       DESIGN_SET AS DS					                        ";
			$SQL .= " {$strWhere1}										                ";
			$SQL .= " {$strOrderBy}									                    ";
			$SQL .= " {$strLimit}										                ";

			## 결과
			return $this->getSelectQuery($SQL, $op);	
		}	

		function getDesignSetInsertEx($param)
		{
			## 체크
			if(!$param['DS_TYPE']) { return; }
			if(!$param['DS_CODE']) { return; }

			$paramData						= "";
//			$paramData['DS_NO']				= $this->db->getSQLInteger($param['DS_NO']);
			$paramData['DS_TYPE']			= $this->db->getSQLString($param['DS_TYPE']);
			$paramData['DS_CODE']			= $this->db->getSQLString($param['DS_CODE']);
			$paramData['DS_VAL']			= $this->db->getSQLString($param['DS_VAL']);
			$paramData['DS_REG_DT']			= $this->db->getSQLDatetime($param['DS_REG_DT']);
			$paramData['DS_REG_NO']			= $this->db->getSQLInteger($param['DS_REG_NO']);
			$paramData['DS_MOD_DT']			= $this->db->getSQLDatetime($param['DS_MOD_DT']);
			$paramData['DS_MOD_NO']			= $this->db->getSQLInteger($param['DS_MOD_NO']);

			return $this->db->getInsertParam("DESIGN_SET", $paramData);
		}


		function getDesignSetUpdateEx($param)
		{	
			## 기본설정
			$intDS_NO = $param['DS_NO'];

			## 유효성 체크
			if(!$intDS_NO) { return; }
			
			## 데이터 만들기
			$paramData						= "";
//			$paramData['DS_NO']				= $this->db->getSQLInteger($param['DS_NO']);
//			$paramData['DS_TYPE']			= $this->db->getSQLString($param['DS_TYPE']);
//			$paramData['DS_CODE']			= $this->db->getSQLString($param['DS_CODE']);
			$paramData['DS_VAL']			= $this->db->getSQLString($param['DS_VAL']);
//			$paramData['DS_REG_DT']			= $this->db->getSQLDatetime($param['DS_REG_DT']);
//			$paramData['DS_REG_NO']			= $this->db->getSQLInteger($param['DS_REG_NO']);
			$paramData['DS_MOD_DT']			= $this->db->getSQLDatetime($param['DS_MOD_DT']);
			$paramData['DS_MOD_NO']			= $this->db->getSQLInteger($param['DS_MOD_NO']);

			## where 만들기
			$where = "DS_NO = {$intDS_NO}";

			return $this->db->getUpdateParam("DESIGN_SET", $paramData, $where);	
		}


		function getDesignSetDeleteEx($param)
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
}