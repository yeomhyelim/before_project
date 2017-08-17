<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2013-11-10												|# 
#|작성내용	: 커뮤니티 데이터 모듈 클레스								|# 
#/*====================================================================*/# 

require_once "Module.php";

class BoardDataModule extends Module2
{
		## 답변글 ANS_STEP 다음값 구하기.
		function getBoardDataAnsStepNextSelectEx($param)
		{
			## 기본 설정
			$strB_CODE = $param['B_CODE'];
			$intUB_ANS_NO = $param['UB_ANS_NO'];
			$intUB_ANS_DEPTH = $param['UB_ANS_DEPTH'];
			$strUB_ANS_STEP = $param['UB_ANS_STEP'];

			## 체크
			if(!$strB_CODE) { return; }
			if(!$intUB_ANS_NO) { return; }
			if(!$intUB_ANS_DEPTH) { return; }

			## 쿼리문
			$SQL  = " SELECT																		";
			$SQL .= "       MAX(UB.UB_ANS_STEP) AS MAX_ANS_STEP										";
			$SQL .= " FROM																			";
			$SQL .= "       BOARD_UB_{$strB_CODE} AS UB												";
			$SQL .= " WHERE																			";
			$SQL .= "      UB.UB_ANS_NO = {$intUB_ANS_NO} AND UB.UB_ANS_DEPTH = {$intUB_ANS_DEPTH}	";
			$SQL .= "	   AND UB.UB_ANS_STEP LIKE ('{$strUB_ANS_STEP}%')								";

			## 쿼리 실행
			$aryDataRow = $this->getSelectQuery($SQL, "OP_SELECT");	
			$strMAX_ANS_STEP = $aryDataRow['MAX_ANS_STEP'];

			$strAnsStepTail = "100";
			if($strMAX_ANS_STEP):
				$aryMaxAnsStep = explode(",", $strMAX_ANS_STEP);
				$strAnsStepTail = array_pop($aryMaxAnsStep) + 1;
			endif;

			if($strUB_ANS_STEP) { $strUB_ANS_STEP .= ","; }

			return $strUB_ANS_STEP . $strAnsStepTail;
		}


		function getBoardDataSelectEx2($op, $param)
		{
			## 체크
			if(!$param['B_CODE']) { return; }

			## column 설정
			$aryColumn[] = "UB.*";

			## 검색(텍스트)
			## 기본 설정
			$aryWhere1 = ""; 
			$arySearchKey = $param['searchKey'];
			$strSearchVal = $param['searchVal'];
		
			## 공백 제거
			$strSearchVal = trim($strSearchVal);

			## search query 설정
			$arySearchText['title'] = "UB.UB_TITLE LIKE ('%{$strSearchVal}%')";
			$arySearchText['text'] = "UB.UB_TEXT LIKE ('%{$strSearchVal}%')";
			$arySearchText['name'] = "UB.UB_NAME LIKE ('%{$strSearchVal}%')";
			$arySearchText['id'] = "UB.UB_M_ID LIKE ('%{$strSearchVal}%')";
			if($strSearchVal):
				$arySearchQuery = "";
				if($arySearchKey && !is_array($arySearchKey)) { $arySearchKey = array($arySearchKey); }
				if($arySearchKey):
					foreach($arySearchKey as $key => $data):
						$temp = $arySearchText[$data];
						if(!$temp) { continue; }
						$arySearchQuery[] = $temp;
					endforeach;
				endif;
				if(!$arySearchQuery):
					foreach($arySearchText as $key => $data):
						$arySearchQuery[] = $data;
					endforeach;
				endif;
				$strSearchQuery = implode(" OR ", $arySearchQuery);
				$strSearchQuery = "( {$strSearchQuery} )";
				$aryWhere1[] = $strSearchQuery;
			endif;

			## 검색(가입일)
			$strSearchRegDTStart = $param['searchRegDTStart'];
			$strSearchRegDTEnd = $param['searchRegDTEnd'];
			if($strSearchRegDTStart || $strSearchRegDTEnd):
				if(!$strSearchRegDTStart) { $strSearchRegDTStart = "1900-12-08"; }
				if(!$strSearchRegDTEnd)	{ $strSearchRegDTEnd = "2200-12-08"; }

				$strSearchRegDTStart = mysql_real_escape_string($strSearchRegDTStart);
				$strSearchRegDTEnd = mysql_real_escape_string($strSearchRegDTEnd);
				$aryWhere1[] = "UB.UB_REG_DT BETWEEN DATE_FORMAT('{$strSearchRegDTStart}','%Y-%m-%d 00:00:00') AND DATE_FORMAT('{$strSearchRegDTEnd}','%Y-%m-%d 23:59:59')";
			endif;

			## where 설정
			if($param['UB_NO']) { $aryWhere1[] = "UB.UB_NO = {$param['UB_NO']}"; }
			if($param['UB_M_NO']) { $aryWhere1[] = "UB.UB_M_NO = {$param['UB_M_NO']}"; }
			if($param['UB_ANS_NO']) { $aryWhere1[] = "UB.UB_ANS_NO = {$param['UB_ANS_NO']}"; }
			if($param['UB_ANS_DEPTH']) { $aryWhere1[] = "UB.UB_ANS_DEPTH = {$param['UB_ANS_DEPTH']}"; }
			if($param['UB_BC_NO']) { $aryWhere1[] = "UB.UB_BC_NO = {$param['UB_BC_NO']}"; }
			if($param['UB_NAME']) { $aryWhere1[] = "UB.UB_NAME = '{$param['UB_NAME']}'"; }
			if($param['UB_TITLE']) { $aryWhere1[] = "UB.UB_TITLE = '{$param['UB_TITLE']}'"; }
			if($param['UB_P_CODE']) { $aryWhere1[] = "UB.UB_P_CODE = '{$param['UB_P_CODE']}'"; }
			if($param['UB_LNG']) { $aryWhere1[] = "UB.UB_LNG = '{$param['UB_LNG']}'"; }
			if($param['UB_ANS_STEP_LIKE_R']) { $aryWhere1[] = "UB.UB_ANS_STEP LIKE('{$param['UB_ANS_STEP_LIKE_R']}%')"; }
			if($param['UB_ANS_STEP_LIKE']) { $aryWhere1[] = "UB.UB_ANS_STEP LIKE('{$param['UB_ANS_STEP_LIKE']}')"; }
			if($param['UB_NO_LAB']) { $aryWhere1[] = "UB.UB_NO < {$param['UB_NO_LAB']}"; }
			if($param['UB_NO_RAB']) { $aryWhere1[] = "UB.UB_NO > {$param['UB_NO_RAB']}"; }
			if($param['UB_DEL_NOT']) { $aryWhere1[] = "UB.UB_DEL <> '{$param['UB_DEL_NOT']}'"; }
			if($param['UB_DEL']) { $aryWhere1[] = "UB.UB_DEL = '{$param['UB_DEL']}'"; }
			if($param['UB_ANS_M_NO']) { $aryWhere1[] = "UB.UB_ANS_M_NO = {$param['UB_ANS_M_NO']}"; }

			if($param['UB_SHOP_NO']) { $aryWhere1[] = "UB.UB_SHOP_NO = {$param['UB_SHOP_NO']}"; }


			if($param['UB_LNG_IN']):
				$strTemp = $param['UB_LNG_IN'];
				if(!is_array($strTemp)) { $strTemp = array($strTemp); }
				$strTemp = implode("','", $strTemp);

			//	$aryWhere1[] = "IFNULL(UB.UB_LNG, '--') IN ('{$strTemp}')";
			endif;

			## join 설정
			if($param['JOIN_FL'] == "Y"):
				$aryColumn[] = "FL.*";

				$aryJoin['JOIN_FL']  = "    LEFT OUTER JOIN											          ";
				$aryJoin['JOIN_FL'] .= "        BOARD_FL_{$param['B_CODE']} AS FL	    					  ";
				$aryJoin['JOIN_FL'] .= "    ON																  ";
				$aryJoin['JOIN_FL'] .= "        FL.FL_UB_NO = UB.UB_NO AND FL.FL_KEY = 'listImage' 		      ";
			endif;

			if($param['JOIN_MM'] == "Y"):
				$aryColumn[] = "MM.*";
				$aryColumn[] = "CONCAT(MM.M_F_NAME,' ',IFNULL(MM.M_L_NAME,'')) AS MM_NAME";

				$aryJoin['JOIN_MM']  = "    LEFT OUTER JOIN													  ";
				$aryJoin['JOIN_MM'] .= "        MEMBER_MGR AS MM 	    								      ";
				$aryJoin['JOIN_MM'] .= "    ON																  ";
				$aryJoin['JOIN_MM'] .= "        MM.M_NO = UB.UB_M_NO 			 					          ";
			endif;

			if($param['JOIN_M'] == "Y"):
				$aryColumn[] = "M.M_F_NAME AS REG_M_F_NAME, M.M_L_NAME AS REG_M_L_NAME, M.M_ID AS REG_M_ID";

				$aryJoin['JOIN_M']  = "    LEFT OUTER JOIN												  ";
				$aryJoin['JOIN_M'] .= "        MEMBER_MGR AS M	 	    				  		          ";
				$aryJoin['JOIN_M'] .= "    ON															  ";
				$aryJoin['JOIN_M'] .= "        M.M_NO = UB.UB_REG_NO	 					              ";
			endif;

			if($param['JOIN_PM'] == "Y"):
				$aryColumn[] = "PM.PM_REAL_NAME";

				$aryJoin['JOIN_PM']  = "    LEFT OUTER JOIN													  ";
				$aryJoin['JOIN_PM'] .= "        PRODUCT_IMG AS PM 	    								      ";
				$aryJoin['JOIN_PM'] .= "    ON																  ";
				$aryJoin['JOIN_PM'] .= "        PM.P_CODE = UB.UB_P_CODE AND PM.PM_TYPE = 'list'	          ";
			endif;

			//상품 추가. 2015.08.31 남덕희
			if($param['JOIN_PRO_MGR'] == "Y"):
				$aryColumn[] = "PRO_MGR.*";

				$aryJoin['JOIN_PRO_MGR']  = "    LEFT OUTER JOIN													  ";
				$aryJoin['JOIN_PRO_MGR'] .= "        PRODUCT_MGR AS PRO_MGR 	    								      ";
				$aryJoin['JOIN_PRO_MGR'] .= "    ON																  ";
				$aryJoin['JOIN_PRO_MGR'] .= "        PRO_MGR.P_CODE = UB.UB_P_CODE 	          ";
			endif;

			if($param['JOIN_AD'] == "Y"):
				$aryColumn[] = "AD.*";

				$aryJoin['JOIN_AD']  = "    LEFT OUTER JOIN													  ";
				$aryJoin['JOIN_AD'] .= "        BOARD_AD_{$param['B_CODE']} AS AD 	    				      ";
				$aryJoin['JOIN_AD'] .= "    ON																  ";
				$aryJoin['JOIN_AD'] .= "        AD.AD_UB_NO = UB.UB_NO	 					                  ";

				if($param['AD_TEMP1']):
					if($param['AD_TEMP1_NULL']):
						$aryWhere1[] = "(AD.AD_TEMP1 = '{$param['AD_TEMP1']}' OR AD.AD_TEMP1 IS NULL OR AD.AD_TEMP1 = '')";
					else:
						$aryWhere1[] = "AD.AD_TEMP1 = '{$param['AD_TEMP1']}'";
					endif;
				endif;

				if($param['AD_TEMP2']):
					$aryWhere1[] = "AD.AD_TEMP2 = '{$param['AD_TEMP2']}'";
				endif;

				if($param['JOIN_OM'] == "Y"):
					$aryColumn[] = "OM.O_KEY";

					$aryJoin['JOIN_OM']  = "    LEFT OUTER JOIN												  ";
					$aryJoin['JOIN_OM'] .= "        ORDER_MGR AS OM 	    							      ";
					$aryJoin['JOIN_OM'] .= "    ON															  ";
					$aryJoin['JOIN_OM'] .= "        OM.O_NO = AD.AD_TEMP2	 					              ";
				endif;
			endif;

			if($param['JOIN_BC'] == "Y"):
				$aryColumn[] = "BC.*";

				$aryJoin['JOIN_BC']  = "    LEFT OUTER JOIN												  ";
				$aryJoin['JOIN_BC'] .= "        BOARD_CATEGORY AS BC 	    						      ";
				$aryJoin['JOIN_BC'] .= "    ON															  ";
				$aryJoin['JOIN_BC'] .= "        BC.BC_NO = UB.UB_BC_NO	 					              ";
			endif;


			## order by 설정
			$aryOrderBy['reg_dt_asc']		= "SUBSTRING(UB_FUNC,1,1) DESC, UB.UB_REG_DT ASC";
			$aryOrderBy['reg_dt_desc']		= "SUBSTRING(UB_FUNC,1,1) DESC, UB.UB_REG_DT DESC";
			$aryOrderBy['defaultDesc']		= "SUBSTRING(UB_FUNC,1,1) DESC, UB.UB_ANS_NO DESC, UB.UB_ANS_STEP ASC";
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
//			$SQL .= "       UB.*,                                                       ";
//			$SQL .= "       FL.*,                                                       ";
//			$SQL .= "       CONCAT(MM.M_F_NAME,' ',IFNULL(MM.M_L_NAME,'')) AS MM_NAME,  ";
//			$SQL .= "       MM.M_ID AS MM_ID,                                           ";
//			$SQL .= "       MM.M_NICK_NAME AS MM_NICK_NAME                              ";
			$SQL .= "  FROM                                                             ";
			$SQL .= "       BOARD_UB_{$param['B_CODE']} AS UB                           ";
//			$SQL .= "   LEFT OUTER JOIN                                                 ";
//			$SQL .= "       BOARD_FL_TEST001 AS FL                                      ";
//			$SQL .= "       ON                                                          ";
//			$SQL .= "       FL.FL_UB_NO = UB.UB_NO AND FL.FL_KEY = 'listImage'          ";
//			$SQL .= "   LEFT OUTER JOIN                                                 ";
//			$SQL .= "       MEMBER_MGR AS MM                                            ";
//			$SQL .= "       ON                                                          ";
//			$SQL .= "       MM.M_NO = UB.UB_M_NO                                        ";
			$SQL .= " {$aryJoin['JOIN_FL']}								    			";
			$SQL .= " {$aryJoin['JOIN_MM']}								    			";
			$SQL .= " {$aryJoin['JOIN_M']}								    			";
			$SQL .= " {$aryJoin['JOIN_PM']}								    			";
			$SQL .= " {$aryJoin['JOIN_PRO_MGR']}						    			";
			$SQL .= " {$aryJoin['JOIN_AD']}								    			";
			$SQL .= " {$aryJoin['JOIN_OM']}								    			";
			$SQL .= " {$aryJoin['JOIN_BC']}								    			";
//			$SQL .= " WHERE                                                             ";
//			$SQL .= "       UB.UB_NO IS NOT NULL AND UB.UB_LNG = 'KR'                   ";
			$SQL .= " {$strWhere1}										                ";
//			$SQL .= " ORDER BY                                                          ";
//			$SQL .= "       UB.UB_ANS_NO DESC,                                          ";
//			$SQL .= "       UB.UB_ANS_STEP ASC                                          ";
			$SQL .= " {$strOrderBy}									                    ";
//			$SQL .= "LIMIT 0,30                                                         ";
			$SQL .= " {$strLimit}										                ";
			//echo $SQL;exit;
			//SELECT UB.*,MM.*,CONCAT(MM.M_F_NAME,' ',IFNULL(MM.M_L_NAME,'')) AS MM_NAME FROM BOARD_UB_NOTICE AS UB LEFT OUTER JOIN	MEMBER_MGR AS MM ON	MM.M_NO = UB.UB_M_NO WHERE UB.UB_NO = 229 AND IFNULL(UB.UB_LNG, '--') IN ('--','US')
			## 결과
			return $this->getSelectQuery($SQL, $op);	
		}	


		function getBoardDataSelectEx($op, $param)
		{
			$column['OP_LIST']		= "UB.*";
			$column['OP_SELECT']	= "*";
			$column['OP_COUNT']		= "COUNT(*)";
			$column['OP_ARYTOTAL']	= "*";

			## 체크
			if(!$param['B_CODE']) { return; }

			## query(1) 영역
			
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
				$order_by1		= "ORDER BY {$param['ORDER_BY']}";
			else:
				## default
				$order_by1		= "ORDER BY UB.UB_ANS_NO DESC, UB.UB_ANS_STEP ASC";
			endif;

			## where1
			$where1				= "WHERE UB.UB_NO IS NOT NULL";

			if($param['UB_NO']):
				$where1			= "{$where1} AND UB.UB_NO = {$param['UB_NO']}";
			endif;

			if($param['UB_M_NO']):
				$where1			= "{$where1} AND UB.UB_M_NO = {$param['UB_M_NO']}";
			endif;

			if($param['UB_NAME']):
				$where1			= "{$where1} AND UB.UB_NAME = '{$param['UB_NAME']}'";
			endif;

			if($param['UB_TITLE']):
				$where1			= "{$where1} AND UB.UB_TITLE = '{$param['UB_TITLE']}'";
			endif;

			if($param['UB_ANS_NO']):
				$where1			= "{$where1} AND UB.UB_ANS_NO = {$param['UB_ANS_NO']}";
			endif;

			if($param['UB_ANS_M_NO']):
				$where1			= "{$where1} AND UB.UB_ANS_M_NO = {$param['UB_ANS_M_NO']}";
			endif;

			if($param['UB_ANS_STEP_LIKE_R']):
				$where1			= "{$where1} AND UB.UB_ANS_STEP LIKE('{$param['UB_ANS_STEP_LIKE_R']}%')";
			endif;

			if($param['UB_P_CODE']):
				$where1			= "{$where1} AND UB.UB_P_CODE = '{$param['UB_P_CODE']}'";
			endif;

			if($param['UB_BC_NO']):
				$where1			= "{$where1} AND UB.UB_BC_NO = '{$param['UB_BC_NO']}'";
			endif;

			if($param['UB_LNG']):
				$where1			= "{$where1} AND UB.UB_LNG = '{$param['UB_LNG']}'";
			endif;

			if($param['UB_DEL_NOT']):
				$where1			= "{$where1} AND UB.UB_DEL <> '{$param['UB_DEL_NOT']}'";
			endif;

			//샵번호(입점몰번호) 기능 추가. 남덕희
			if($param['UB_SHOP_NO']):
				$where1			= "{$where1} AND UB.UB_SHOP_NO = '{$param['UB_SHOP_NO']}'";
			endif;


			## 검색(텍스트)
			$strSearchField							= $param['searchField'];
			$searchKey								= $param['searchKey'];
			if($searchKey):
				$arySearchText['title']				= "UB.UB_TITLE LIKE ('%{$searchKey}%')";
				$arySearchText['text']				= "UB.UB_TEXT LIKE ('%{$searchKey}%')";
				$temp								= $arySearchText[$strSearchField];

				if(!$temp):
					foreach($arySearchText as $key => $data):
						if($temp) { $temp			= "{$temp} OR"; }
						$temp						= "{$temp} {$data}";
					endforeach;
					$temp							= "( {$temp} )";
				endif;

				$where1								= "{$where1} AND {$temp}";
			endif;

			## 검색(가입일)
			if($param['searchRegDTStart'] || $param['searchRegDTEnd']):
				if(!$param['searchRegDTStart']) { $param['searchRegDTStart']	= "1900-12-08";		}
				if(!$param['searchRegDTEnd'])	{ $param['searchRegDTEnd']		= "2200-12-08";;	}

				$param['searchRegDTStart']		= mysql_real_escape_string($param['searchRegDTStart']);
				$param['searchRegDTEnd']		= mysql_real_escape_string($param['searchRegDTEnd']);
				$where1		= "{$where1} AND UB.UB_REG_DT BETWEEN DATE_FORMAT('{$param['searchRegDTStart']}','%Y-%m-%d 00:00:00') AND DATE_FORMAT('{$param['searchRegDTEnd']}','%Y-%m-%d 23:59:59')";
			endif;

			if($param['PRODUCT_IMG_JOIN']):
				$column['OP_LIST']		.= ", PM.*";
				$join1_1				 = "LEFT OUTER JOIN PRODUCT_IMG AS PM ON UB.UB_P_CODE = PM.P_CODE AND PM.PM_TYPE = 'list'";
			endif;

			if($param['BOARD_AD_JOIN']):
				$column['OP_LIST']		.= ", AD.*";
				$join1_2				 = "LEFT OUTER JOIN BOARD_AD_{$param['B_CODE']} AS AD ON AD.AD_UB_NO = UB.UB_NO";

				if($param['AD_TEMP1']):
					if($param['AD_TEMP1_NULL']):
						$where1			 = "{$where1} AND (AD.AD_TEMP1 = '{$param['AD_TEMP1']}' OR AD.AD_TEMP1 IS NULL OR AD.AD_TEMP1 = '')";
					else:
						$where1			 = "{$where1} AND AD.AD_TEMP1 = '{$param['AD_TEMP1']}'";
					endif;
				endif;

				if($param['AD_TEMP2']):
					$where1			 = "{$where1} AND AD.AD_TEMP2 = '{$param['AD_TEMP2']}'";
				endif;
			endif;

			if($param['BOARD_FL_JOIN']):
				$column['OP_LIST']		.= ", FL.*";
				$join1_3				 = "LEFT OUTER JOIN BOARD_FL_{$param['B_CODE']} AS FL ON FL.FL_UB_NO = UB.UB_NO AND FL.FL_KEY = 'listImage'";
			endif;

			if($param['BOARD_CATEGORY_JOIN']):
				$column['OP_LIST']		.= ", BC.*";
				$join1_4				 = "LEFT OUTER JOIN BOARD_CATEGORY AS BC ON BC.BC_NO = UB.UB_BC_NO";
			endif;

			if($param['ORDER_MGR_JOIN']):
				$column['OP_LIST']		.= ", OM.O_KEY ";
				$join1_5				 = "LEFT OUTER JOIN ORDER_MGR AS OM ON OM.O_NO = AD.AD_TEMP2";
			endif;

			if($param['MEMBER_MGR_UB_REG_NO_JOIN']):
				$column['OP_LIST']		.= ", M.M_F_NAME AS REG_M_F_NAME, M.M_L_NAME AS REG_M_L_NAME, M.M_ID AS REG_M_ID ";
				$join10_1				 = "LEFT OUTER JOIN MEMBER_MGR AS M ON M.M_NO = UB.UB_REG_NO";
			endif;

			if($param['MM_JOIN']):
				$column['OP_LIST']		.= ", CONCAT(MM.M_F_NAME,' ',IFNULL(MM.M_L_NAME,'')) AS MM_NAME, MM.M_ID AS MM_ID, MM.M_NICK_NAME AS MM_NICK_NAME";
				$join10_2				 = "LEFT OUTER JOIN MEMBER_MGR AS MM ON MM.M_NO = UB.UB_M_NO";
			endif;

			## from1
			$from1				= "FROM BOARD_UB_{$param['B_CODE']} AS UB";

			## select1
			$column['OP_SELECT']	= $column['OP_LIST'];
			$select1				= "SELECT {$column[$op]}";
			
			## query1
			$query1				= "{$select1} {$from1} {$join1_1} {$join1_2} {$join1_3} {$join1_4} {$join1_5} {$join10_1} {$join10_2} {$where1} {$order_by1} {$limit1}";


			return $this->getSelectQuery($query1, $op);
		}


		function getBoardDataAnsStepMaxSelect($param) 
		{
	
			## 기본 설정
			$op						= "OP_SELECT";

			## 기본 데이터 체크
			if(!$param['B_CODE']):
				return;
			endif;

			$column['OP_SELECT']	= "MAX(UB.UB_ANS_STEP) AS UB_ANS_STEP";

			## where1
			$where1					= "WHERE UB.UB_NO IS NOT NULL";

			if($param['UB_ANS_NO']):
				$where1				= "{$where1} AND UB.UB_ANS_NO = {$param['UB_ANS_NO']}";
			endif;

			if($param['UB_ANS_STEP_LIKE_R']):
				$where1				= "{$where1} AND UB.UB_ANS_STEP LIKE ('{$param['UB_ANS_STEP_LIKE_R']}%%')";
			endif;

			## from1
			$from1					= "FROM BOARD_UB_{$param['B_CODE']} AS UB";

			## select1
			$select1				= "SELECT {$column[$op]}";

			## query1
			$query1					= "{$select1} {$from1} {$join1_1} {$join1_2} {$where1} {$order_by1} {$limit1}";

			$re						= $this->getSelectQuery($query1, $op);

			return $re['UB_ANS_STEP'];
		}

		## 카테고리별 리스트 개수 리스트 만들기
		function geBoardDataCateCntSelectEx($param)
		{

			## 기본 설정
			$aryWhere1 = ""; 
			$strBCode = $param['B_CODE'];
			$strTableName = "BOARD_UB_{$strBCode} AS UB";

			## 체크
			if(!$strBCode) { break; }

			## where 설정
			if($param['UB_P_CODE']) { $aryWhere1[] = "UB.UB_P_CODE = '{$param['UB_P_CODE']}'"; }
			if($param['UB_DEL']) { $aryWhere1[] = "UB.UB_DEL = '{$param['UB_DEL']}'"; }
			if($param['UB_DEL_NOT']) { $aryWhere1[] = "UB.UB_DEL <> '{$param['UB_DEL_NOT']}'"; }

			## 쿼리 만들기
			if($aryWhere1) { $strWhere1 = "WHERE " .  implode(" AND ", $aryWhere1); } 

			$SQL  = "SELECT                                               ";
			$SQL .= "       UB.UB_BC_NO,                                  ";
			$SQL .= "       COUNT(*) AS CNT                               ";
			$SQL .= "FROM                                                 ";
			$SQL .= "       {$strTableName}	                              ";
			$SQL .= "{$strWhere1}										  ";
			$SQL .= "GROUP BY                                             ";
			$SQL .= "      UB.UB_BC_NO                                    ";

			$aryList =  $this->getSelectQuery($SQL, "OP_ARYTOTAL");
			if(!$aryList) { return; }

			## 카테고리별 개수 만들기
			$aryCateCnt = "";
			foreach($aryList as $key => $row):
				
				## 기본설정
				$intUB_BC_NO = $row['UB_BC_NO'];
				$intCNT = $row['CNT'];

				## 체크
				if(!$intUB_BC_NO) { $intUB_BC_NO = 0; }
				
				## 데이터 만들기
				$aryCateCnt[$intUB_BC_NO] = $intCNT;

				## 전체 개수 구하기
				$intTotal = $intTotal + $intCNT;
				
			endforeach;

			$aryCateCnt['total'] = $intTotal;

			return $aryCateCnt;
		}

		function getBoardDataInsertEx($param)
		{
			## 체크
			if(!$param['B_CODE']) { return; }

			$paramData						= "";
//			$paramData['UB_NO']				= $this->db->getSQLInteger($param['UB_NO']);
			$paramData['UB_NAME']			= $this->db->getSQLString($param['UB_NAME']);
			$paramData['UB_M_NO']			= $this->db->getSQLInteger($param['UB_M_NO']);
			$paramData['UB_M_ID']			= $this->db->getSQLString($param['UB_M_ID']);
			$paramData['UB_PASS']			= $this->db->getSQLString($param['UB_PASS']);
			$paramData['UB_MAIL']			= $this->db->getSQLString($param['UB_MAIL']);
			$paramData['UB_URL']			= $this->db->getSQLString($param['UB_URL']);
			$paramData['UB_TITLE']			= $this->db->getSQLString($param['UB_TITLE']);
			$paramData['UB_TEXT']			= $this->db->getSQLString($param['UB_TEXT']);
			$paramData['UB_TEXT_MOBILE']	= $this->db->getSQLString($param['UB_TEXT_MOBILE']);
			$paramData['UB_FUNC']			= $this->db->getSQLString($param['UB_FUNC']);
			$paramData['UB_IP']				= $this->db->getSQLString($param['UB_IP']);
			$paramData['UB_READ']			= $this->db->getSQLInteger($param['UB_READ']);
			$paramData['UB_BC_NO']			= $this->db->getSQLInteger($param['UB_BC_NO']);
			$paramData['UB_LNG']			= $this->db->getSQLString($param['UB_LNG']);
			$paramData['UB_ANS_NO']			= $this->db->getSQLInteger($param['UB_ANS_NO']);
			$paramData['UB_ANS_STEP']		= $this->db->getSQLString($param['UB_ANS_STEP']);
			$paramData['UB_ANS_M_NO']		= $this->db->getSQLInteger($param['UB_ANS_M_NO']);
			$paramData['UB_PT_NO']			= $this->db->getSQLInteger($param['UB_PT_NO']);
			$paramData['UB_CI_NO']			= $this->db->getSQLInteger($param['UB_CI_NO']);
			$paramData['UB_WINNER']			= $this->db->getSQLString($param['UB_WINNER']);
			$paramData['UB_P_CODE']			= $this->db->getSQLString($param['UB_P_CODE']);
			$paramData['UB_P_GRADE']		= $this->db->getSQLInteger($param['UB_P_GRADE']);
			$paramData['UB_REG_DT']			= $this->db->getSQLDatetime($param['UB_REG_DT']);
			$paramData['UB_REG_NO']			= $this->db->getSQLInteger($param['UB_REG_NO']);
			$paramData['UB_MOD_DT']			= $this->db->getSQLDatetime($param['UB_MOD_DT']);
			$paramData['UB_MOD_NO']			= $this->db->getSQLInteger($param['UB_MOD_NO']);

			if($param['UB_SHOP_NO'])
			{
				$paramData['UB_SHOP_NO']		= $this->db->getSQLInteger($param['UB_SHOP_NO']);
			}
			

			return $this->db->getInsertParam("BOARD_UB_{$param['B_CODE']}", $paramData);
		}

		function getBoardDataAnsUpdateEx2($param)
		{
			## 체크
			if(!$param['B_CODE']) { return; }

			$paramData						= "";
			$paramData['UB_ANS_NO']			= $this->db->getSQLInteger($param['UB_ANS_NO']);
			$paramData['UB_ANS_DEPTH']		= $this->db->getSQLInteger($param['UB_ANS_DEPTH']);
			$paramData['UB_ANS_STEP']		= $this->db->getSQLString($param['UB_ANS_STEP']);
			$paramData['UB_ANS_M_NO']		= $this->db->getSQLInteger($param['UB_ANS_M_NO']);

			if($param['UB_NO']):
				$ubNo				= $this->db->getSQLInteger($param['UB_NO']);
				$where				= "UB_NO = {$ubNo}";
			endif;
			
			if(!$where)					{ return; }

			return $this->db->getUpdateParam("BOARD_UB_{$param['B_CODE']}", $paramData, $where);	

		}

		function getBoardDataAnsUpdateEx($param)
		{
			## 체크
			if(!$param['B_CODE']) { return; }

			$paramData						= "";
			$paramData['UB_ANS_NO']			= $this->db->getSQLInteger($param['UB_ANS_NO']);
			$paramData['UB_ANS_STEP']		= $this->db->getSQLString($param['UB_ANS_STEP']);
			$paramData['UB_ANS_M_NO']		= $this->db->getSQLInteger($param['UB_ANS_M_NO']);

			if($param['UB_NO']):
				$ubNo				= $this->db->getSQLInteger($param['UB_NO']);
				$where				= "UB_NO = {$ubNo}";
			endif;
			
			if(!$where)					{ return; }

			return $this->db->getUpdateParam("BOARD_UB_{$param['B_CODE']}", $paramData, $where);	

		}

		function getBoardDataReadUpdateEx($param)
		{
			## 체크
			if(!$param['B_CODE']) { return; }

			$paramData						= "";
			$paramData['UB_READ']			= "UB_READ + 1";

			if($param['UB_NO']):
				$ubNo				= $this->db->getSQLInteger($param['UB_NO']);
				$where				= "UB_NO = {$ubNo}";
			endif;
			
			if(!$where)					{ return; }

			return $this->db->getUpdateParam("BOARD_UB_{$param['B_CODE']}", $paramData, $where);	

		}

		function getBoardDataUpdateEx($param)
		{
			## 체크
			if(!$param['B_CODE']) { return; }
			if(!$param['UB_NO']) { return; }

			$paramData						= "";
//			$paramData['UB_NO']				= $this->db->getSQLInteger($param['UB_NO']);
			$paramData['UB_NAME']			= $this->db->getSQLString($param['UB_NAME']);
			$paramData['UB_M_NO']			= $this->db->getSQLInteger($param['UB_M_NO']);
			$paramData['UB_M_ID']			= $this->db->getSQLString($param['UB_M_ID']);
			$paramData['UB_PASS']			= $this->db->getSQLString($param['UB_PASS']);
			$paramData['UB_MAIL']			= $this->db->getSQLString($param['UB_MAIL']);
			$paramData['UB_URL']			= $this->db->getSQLString($param['UB_URL']);
			$paramData['UB_TITLE']			= $this->db->getSQLString($param['UB_TITLE']);
			$paramData['UB_TEXT']			= $this->db->getSQLString($param['UB_TEXT']);
			$paramData['UB_TEXT_MOBILE']	= $this->db->getSQLString($param['UB_TEXT_MOBILE']);
			$paramData['UB_FUNC']			= $this->db->getSQLString($param['UB_FUNC']);
			$paramData['UB_IP']				= $this->db->getSQLString($param['UB_IP']);
			$paramData['UB_READ']			= $this->db->getSQLInteger($param['UB_READ']);
			$paramData['UB_BC_NO']			= $this->db->getSQLInteger($param['UB_BC_NO']);
			$paramData['UB_LNG']			= $this->db->getSQLString($param['UB_LNG']);
			$paramData['UB_ANS_NO']			= $this->db->getSQLInteger($param['UB_ANS_NO']);
			$paramData['UB_ANS_STEP']		= $this->db->getSQLString($param['UB_ANS_STEP']);
			$paramData['UB_ANS_M_NO']		= $this->db->getSQLInteger($param['UB_ANS_M_NO']);
			$paramData['UB_PT_NO']			= $this->db->getSQLInteger($param['UB_PT_NO']);
			$paramData['UB_CI_NO']			= $this->db->getSQLInteger($param['UB_CI_NO']);
			$paramData['UB_WINNER']			= $this->db->getSQLString($param['UB_WINNER']);
			$paramData['UB_P_CODE']			= $this->db->getSQLString($param['UB_P_CODE']);
			$paramData['UB_P_GRADE']		= $this->db->getSQLInteger($param['UB_P_GRADE']);
//			$paramData['UB_REG_DT']			= $this->db->getSQLDatetime($param['UB_REG_DT']);
//			$paramData['UB_REG_NO']			= $this->db->getSQLInteger($param['UB_REG_NO']);
			$paramData['UB_MOD_DT']			= $this->db->getSQLDatetime($param['UB_MOD_DT']);
			$paramData['UB_MOD_NO']			= $this->db->getSQLInteger($param['UB_MOD_NO']);

			if($param['UB_NO']):
				$ubNo				= $this->db->getSQLInteger($param['UB_NO']);
				$where				= "UB_NO = {$ubNo}";
			endif;
			
			if(!$where)					{ return; }

			return $this->db->getUpdateParam("BOARD_UB_{$param['B_CODE']}", $paramData, $where);	

		}

		function getBoardDataReportUpdateEx($param) 
		{
			## 체크
			if(!$param['B_CODE']) { return; }
			if(!$param['UB_NO']) { return; }

			$paramData						= "";
			$paramData['UB_TEXT']			= $this->db->getSQLString($param['UB_TEXT']);
			$paramData['UB_BC_NO']			= $this->db->getSQLInteger($param['UB_BC_NO']);
			$paramData['UB_MOD_DT']			= $this->db->getSQLDatetime($param['UB_MOD_DT']);
			$paramData['UB_MOD_NO']			= $this->db->getSQLInteger($param['UB_MOD_NO']);

			if($param['UB_NO']):
				$ubNo				= $this->db->getSQLInteger($param['UB_NO']);
				$where				= "UB_NO = {$ubNo}";
			endif;
			
			if(!$where)					{ return; }

			return $this->db->getUpdateParam("BOARD_UB_{$param['B_CODE']}", $paramData, $where);	
		}

		function getBoardDataDelUpdateEx($param) 
		{
			## 체크
			if(!$param['B_CODE']) { return; }
			if(!$param['UB_NO']) { return; }

			$paramData						= "";
//			$paramData['B_CODE']			= $this->db->getSQLString($param['B_CODE']);
//			$paramData['UB_NO']				= $this->db->getSQLInteger($param['UB_NO']);
			$paramData['UB_DEL']			= $this->db->getSQLString($param['UB_DEL']);
			$paramData['UB_MOD_DT']			= $this->db->getSQLDatetime($param['UB_MOD_DT']);
			$paramData['UB_MOD_NO']			= $this->db->getSQLInteger($param['UB_MOD_NO']);

			if($param['UB_NO']):
				$ubNo				= $this->db->getSQLInteger($param['UB_NO']);
				$where				= "UB_NO = {$ubNo}";
			endif;
			
			if(!$where)					{ return; }

			return $this->db->getUpdateParam("BOARD_UB_{$param['B_CODE']}", $paramData, $where);	
		}

		function getBoardDataDeleteEx($param)
		{
			## 체크
			if(!$param['B_CODE']) { return; }

			$where					= "";
			
			if($param['UB_NO']):
				$bgNo				= $this->db->getSQLInteger($param['UB_NO']);
				$where				= "UB_NO = {$bgNo}";
			endif;
			
			if(!$where)				{ return; }

			return $this->db->getDelete("BOARD_UB_{$param['B_CODE']}", $where);
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