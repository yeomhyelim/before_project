<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2013-11-10												|# 
#|작성내용	: 커뮤니티 댓글 모듈 클레스									|# 
#/*====================================================================*/# 

require_once "Module.php";

class BoardCommentModule extends Module2
{

		function getBoardCommentSelectEx($op, $param) 
		{
			## column 설정
			$aryColumn[] = "CM.*";

			## 검색(텍스트)
			if($param['searchKey']):
				$arySearchText['title']				= "CM.CM_TEXT LIKE ('%{$param['searchKey']}%')";
				$temp								= $arySearchText[$param['searchField']];
				if(!$temp):
					foreach($arySearchText as $key => $data):
						if($temp) { $temp = "{$temp} OR"; }
						$temp = "{$temp} {$data}";
					endforeach;
					$temp		= "( {$temp} )";
				endif;
				$aryWhere1[] = $temp;
			endif;

			## where 설정
			$aryWhere1 = "";
			if($param['CM_NO']) { $aryWhere1[] = "CM.CM_NO = {$param['CM_NO']}"; }
			if($param['CM_UB_NO']) { $aryWhere1[] = "CM.CM_UB_NO = {$param['CM_UB_NO']}"; }
			if($param['CM_ANS_NO']) { $aryWhere1[] = "CM.CM_ANS_NO = '{$param['CM_ANS_NO']}'"; }
			
			## order by 설정
			$aryOrderBy['noAsc']			= "CM.CM_NO ASC";
			$aryOrderBy['noDesc']			= "CM.CM_NO DESC";
			$aryOrderBy['newAsc']			= "CM.CM_ANS_NO ASC, CM.CM_ANS_DEPTH ASC, CM.CM_ANS_STEP ASC"; // 최신글이 아래, 최신 답변글이 아래
			$strOrderBy						= $aryOrderBy[$param['ORDER_BY']];

			## limit 설정
			if($param['LIMIT']):
				list($param['LIMIT_START'], $param['LIMIT_END']) = explode(",", $param['LIMIT']);
			endif;
			if($param['LIMIT_END']):
				if(!$param['LIMIT_START']) { $param['LIMIT_START'] = 0; }
				$strLimit					= "{$param['LIMIT_START']},{$param['LIMIT_END']}";
			endif;

			## join 설정
			if($param['JOIN_M'] == "Y"):
				$aryColumn[]		= "CONCAT(IFNULL(M.M_F_NAME,''),'',IFNULL(M.M_L_NAME,'')) AS M_NAME";

				$aryJoin['JOIN_M']  = "    LEFT OUTER JOIN												          ";
				$aryJoin['JOIN_M'] .= "        MEMBER_MGR AS M	    										      ";
				$aryJoin['JOIN_M'] .= "        ON									 							  ";
				$aryJoin['JOIN_M'] .= "        M.M_NO = CM.CM_M_NO	  			 					          ";
			endif;

			if($param['JOIN_MA'] == "Y"):
				$aryColumn[]		= "MA.M_PHOTO";

				$aryJoin['JOIN_MA']  = "    LEFT OUTER JOIN														      ";
				$aryJoin['JOIN_MA'] .= "        MEMBER_ADD AS MA	    										      ";
				$aryJoin['JOIN_MA'] .= "    ON									 									  ";
				$aryJoin['JOIN_MA'] .= "        MA.M_NO = CM.CM_M_NO	  									          ";
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

			$SQL =    "SELECT {$strColumn}                                  ";
//			$SQL .= "       CM.*,                                           ";
			$SQL .= "  FROM                                                 ";
			$SQL .= "       BOARD_CM_{$param['B_CODE']} AS CM               ";
			$SQL .= "   {$aryJoin['JOIN_M']}							    ";
			$SQL .= "   {$aryJoin['JOIN_MA']}							    ";
			$SQL .= " {$strWhere1}										    ";
//			$SQL .= "ORDER BY CM.CM_NO DESC                                 ";
			$SQL .= " {$strOrderBy}										    ";
//			$SQL .= "LIMIT 0,30                                             ";
			$SQL .= " {$strLimit}										    ";

			## 결과
			return $this->getSelectQuery($SQL, $op);
		}

		function getBoardCommentInsertEx($param)
		{
			## 체크
			if(!$param['B_CODE'])	{ return; }
			if(!$param['CM_UB_NO']) { return; }

			$paramData						= "";
//			$paramData['CM_NO']				= $this->db->getSQLInteger($param['CM_NO']);
			$paramData['CM_UB_NO']			= $this->db->getSQLInteger($param['CM_UB_NO']);
			$paramData['CM_NAME']			= $this->db->getSQLString($param['CM_NAME']);
			$paramData['CM_M_NO']			= $this->db->getSQLInteger($param['CM_M_NO']);
			$paramData['CM_M_ID']			= $this->db->getSQLString($param['CM_M_ID']);
			//$paramData['CM_PASS']			= $this->db->getSQLString($param['CM_PASS']);
			$paramData['CM_MAIL']			= $this->db->getSQLString($param['CM_MAIL']);
			$paramData['CM_TITLE']			= $this->db->getSQLString($param['CM_TITLE']);
			$paramData['CM_TEXT']			= $this->db->getSQLString($param['CM_TEXT']);
			$paramData['CM_FUNC']			= $this->db->getSQLString($param['CM_FUNC']);
			$paramData['CM_IP']				= $this->db->getSQLString($param['CM_IP']);
			$paramData['CM_READ']			= $this->db->getSQLInteger($param['CM_READ']);
			//$paramData['CM_ANS_NO']			= $this->db->getSQLInteger($param['CM_ANS_NO']);
			//$paramData['CM_ANS_DEPTH']		= $this->db->getSQLInteger($param['CM_ANS_DEPTH']);
			//$paramData['CM_ANS_STEP']		= $this->db->getSQLString($param['CM_ANS_STEP']);
			//$paramData['CM_ANS_M_NO']		= $this->db->getSQLInteger($param['CM_ANS_M_NO']);
			$paramData['CM_PT_NO']			= $this->db->getSQLInteger($param['CM_PT_NO']);
			$paramData['CM_CI_NO']			= $this->db->getSQLInteger($param['CM_CI_NO']);
			$paramData['CM_WINNER']			= $this->db->getSQLString($param['CM_WINNER']);
			//$paramData['CM_DEL']			= $this->db->getSQLString($param['CM_DEL']);//필드없음
			$paramData['CM_REG_DT']			= $this->db->getSQLDatetime($param['CM_REG_DT']);
			$paramData['CM_REG_NO']			= $this->db->getSQLInteger($param['CM_REG_NO']);
			$paramData['CM_MOD_DT']			= $this->db->getSQLDatetime($param['CM_MOD_DT']);
			$paramData['CM_MOD_NO']			= $this->db->getSQLInteger($param['CM_MOD_NO']);

			return $this->db->getInsertParam("BOARD_CM_{$param['B_CODE']}", $paramData);
		}


		function getBoardCommentUpdateEx($param)
		{
			## 체크
			if(!$param['B_CODE'])	{ return; }
			if(!$param['CM_NO'])	{ return; }

			$paramData						= "";
//			$paramData['CM_NO']				= $this->db->getSQLInteger($param['CM_NO']);
//			$paramData['CM_UB_NO']			= $this->db->getSQLInteger($param['CM_UB_NO']);
			$paramData['CM_NAME']			= $this->db->getSQLString($param['CM_NAME']);
//			$paramData['CM_M_NO']			= $this->db->getSQLInteger($param['CM_M_NO']);
//			$paramData['CM_M_ID']			= $this->db->getSQLString($param['CM_M_ID']);
			$paramData['CM_PASS']			= $this->db->getSQLString($param['CM_PASS']);
			$paramData['CM_MAIL']			= $this->db->getSQLString($param['CM_MAIL']);
			$paramData['CM_TITLE']			= $this->db->getSQLString($param['CM_TITLE']);
			$paramData['CM_TEXT']			= $this->db->getSQLString($param['CM_TEXT']);
			$paramData['CM_FUNC']			= $this->db->getSQLString($param['CM_FUNC']);
			$paramData['CM_IP']				= $this->db->getSQLString($param['CM_IP']);
			$paramData['CM_READ']			= $this->db->getSQLInteger($param['CM_READ']);
			$paramData['CM_ANS_NO']			= $this->db->getSQLInteger($param['CM_ANS_NO']);
			$paramData['CM_ANS_DEPTH']		= $this->db->getSQLInteger($param['CM_ANS_DEPTH']);
			$paramData['CM_ANS_STEP']		= $this->db->getSQLString($param['CM_ANS_STEP']);
			$paramData['CM_ANS_M_NO']		= $this->db->getSQLInteger($param['CM_ANS_M_NO']);
			$paramData['CM_PT_NO']			= $this->db->getSQLInteger($param['CM_PT_NO']);
			$paramData['CM_CI_NO']			= $this->db->getSQLInteger($param['CM_CI_NO']);
			$paramData['CM_WINNER']			= $this->db->getSQLString($param['CM_WINNER']);
			$paramData['CM_DEL']			= $this->db->getSQLString($param['CM_DEL']);
//			$paramData['CM_REG_DT']			= $this->db->getSQLDatetime($param['CM_REG_DT']);
//			$paramData['CM_REG_NO']			= $this->db->getSQLInteger($param['CM_REG_NO']);
			$paramData['CM_MOD_DT']			= $this->db->getSQLDatetime($param['CM_MOD_DT']);
			$paramData['CM_MOD_NO']			= $this->db->getSQLInteger($param['CM_MOD_NO']);

			if($param['CM_NO']):
				$bCode				= $this->db->getSQLInteger($param['CM_NO']);
				$where				= "CM_NO = {$bCode}";
			endif;
			
			if(!$where)					{ return; }

			return $this->db->getUpdateParam("BOARD_CM_{$param['B_CODE']}", $paramData, $where);	

		}

		function getBoardCommentAnsUpdateEx($param)
		{
			## 체크
			if(!trim($param['B_CODE'])) { return; }
			if(!trim($param['CM_NO'])) { return; }

			$paramData						= "";
			$paramData['CM_ANS_NO']			= $this->db->getSQLInteger($param['CM_ANS_NO']);
			$paramData['CM_ANS_DEPTH']		= $this->db->getSQLInteger($param['CM_ANS_DEPTH']);
			$paramData['CM_ANS_STEP']		= $this->db->getSQLString($param['CM_ANS_STEP']);
			$paramData['CM_ANS_M_NO']		= $this->db->getSQLInteger($param['CM_ANS_M_NO']);

			if($param['CM_NO']):
				$ubNo				= $this->db->getSQLInteger($param['CM_NO']);
				$where				= "CM_NO = {$ubNo}";
			endif;
			
			if(!$where)					{ return; }

			return $this->db->getUpdateParam("BOARD_CM_{$param['B_CODE']}", $paramData, $where);	

		}

		function getBoardCommentTextUpdateEx($param)
		{
			## 체크
			if(!trim($param['B_CODE'])) { return; }
			if(!trim($param['CM_NO'])) { return; }

			$paramData						= "";
			$paramData['CM_TEXT']			= $this->db->getSQLString($param['CM_TEXT']);
			$paramData['CM_MOD_DT']			= $this->db->getSQLDatetime($param['CM_MOD_DT']);
			$paramData['CM_MOD_NO']			= $this->db->getSQLInteger($param['CM_MOD_NO']);

			if($param['CM_NO']):
				$ubNo				= $this->db->getSQLInteger($param['CM_NO']);
				$where				= "CM_NO = {$ubNo}";
			endif;
			
			if(!$where)					{ return; }

			return $this->db->getUpdateParam("BOARD_CM_{$param['B_CODE']}", $paramData, $where);	

		}

		function getBoardCommentDelUpdateEx($param)
		{
			## 체크
			if(!trim($param['B_CODE'])) { return; }
			if(!trim($param['CM_NO'])) { return; }

			$paramData						= "";
			$paramData['CM_DEL']			= $this->db->getSQLString($param['CM_DEL']);
			$paramData['CM_MOD_DT']			= $this->db->getSQLDatetime($param['CM_MOD_DT']);
			$paramData['CM_MOD_NO']			= $this->db->getSQLInteger($param['CM_MOD_NO']);

			if($param['CM_NO']):
				$ubNo				= $this->db->getSQLInteger($param['CM_NO']);
				$where				= "CM_NO = {$ubNo}";
			endif;
			
			if(!$where)					{ return; }

			return $this->db->getUpdateParam("BOARD_CM_{$param['B_CODE']}", $paramData, $where);	

		}

		function getBoardCommentDeleteEx($param)
		{
			## 체크
			if(!$param['B_CODE']) { return; }

			$where					= "";
			
			if($param['CM_NO']):
				$no				= $this->db->getSQLInteger($param['CM_NO']);
				$where				= "CM_NO = {$no}";
			endif;
			
			if(!$where)				{ return; }

			return $this->db->getDelete("BOARD_CM_{$param['B_CODE']}", $where);
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