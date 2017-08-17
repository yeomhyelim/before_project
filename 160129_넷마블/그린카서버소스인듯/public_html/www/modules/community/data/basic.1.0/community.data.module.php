<?php
    /**
     * /home/shop_eng/www/modules/community/data/basic.1.0/community.data.module.php
     * @author eumshop(thav@naver.com)
     * community data module class (basic.1.0)
	 * 2013.04.09 이후 ****Ex($param) 함수 형으로 변경하여 작업중...
     * **/

	require_once MALL_HOME . "/modules/community/community.module.php";

    class CommunityDataModule extends CommunityModule {
		
		function __construct(&$db, &$field) {
			$this->db		= &$db;
			$this->field	= &$field;
		}

		function getMessage() {
			echo "community data module class (basic.1.0)";
		}
		
		## 구매회원확인
		function getDataMgrProductSelectEx($op="OP_LIST",$param)
		{
			$column['OP_LIST']					= "*";
			$column['OP_COUNT']					= "COUNT(*)";
			$column['OP_SELECT']				= "*";
			
			$query  = "SELECT ".$column[$op]."					";
			$query .= "FROM ORDER_CART oc						";
			$query .= "JOIN ORDER_MGR o							";
			$query .= "ON oc.O_NO = o.O_NO						";

			if ($param['prod_cate_not_in']){
				$query .= "JOIN PRODUCT_MGR p					";
				$query .= "ON p.P_CODE = oc.P_CODE				";
			}
			$query .= "WHERE o.O_NO IS NOT NULL					";

			if ($param['product_download'] == "Y"){
				$query .= "	AND o.O_STATUS NOT IN ('J','O','C','R','T')			";

				if ($param['prod_cate_not_in']){

					$aryProdCateNotIn		= $param['prod_cate_not_in'];
					$strProdCateNotInList	= "";
					foreach($aryProdCateNotIn as $key => $val) {
						$strProdCateNotInList .= "'".$val."',";
					}

					$strProdCateNotInList = substr($strProdCateNotInList,0,strlen($strProdCateNotInList)-1);

					$query .= "    AND SUBSTRING(p.P_CATE,1,3) NOT IN (".$strProdCateNotInList.")	";
				}

			} else {
				$query .= "	AND o.O_STATUS IN ('D','E')			";
			}

			if($param['ub_p_code']): // 상품코드
				$query = sprintf("%s AND oc.P_CODE = '%s'", $query, $param['ub_p_code']);
			endif;

			if($param['ub_m_no'] && $param['ub_m_no'] > 0): // 회원번호
				$query = sprintf("%s AND o.M_NO = '%s'", $query, $param['ub_m_no']);
			endif;
			
			return $this->getSelectQuery($query, $op);
		}

//		SELECT UB.UB_NO, UB.UB_P_CODE, PM.P_SHOP_NO FROM BOARD_UB_PROD_QNA  AS UB
//		LEFT OUTER JOIN PRODUCT_MGR AS PM ON UB.UB_P_CODE = PM.P_CODE
//		WHERE PM.P_SHOP_NO = 1

//		SELECT * FROM BOARD_UB_PROD_REVIEW AS UB
//		LEFT OUTER JOIN PRODUCT_MGR AS PM ON PM.P_CODE = UB_P_CODE 
//		WHERE PM.P_SHOP_NO = 4
		function getDataMgrSelectEx($op="OP_LIST", $param)
		{
			$column['OP_LIST']					= "*";
			$column['OP_COUNT']					= "COUNT(*)";
			$column['OP_SELECT']				= "*";

			if($param['file_count_use'] == "Y"):
				$column1						= "(SELECT COUNT(*) FROM BOARD_FL_{$param['b_code']} WHERE FL_UB_NO = a.UB_NO) FILE_CNT";
				$column['OP_LIST']				= "*, {$column1}";
			endif;
			
			$query								= "SELECT {$column[$op]} FROM BOARD_UB_{$param['b_code']} AS a";

			if($param['bi_attachedfile_use'] > 0):		// 첨부 파일이 있는 경우.
				$join = "%s LEFT OUTER JOIN %s AS b ON a.UB_NO = b.FL_UB_NO AND b.FL_KEY = 'listImage'";
				$query = sprintf($join, $query, "BOARD_FL_{$param['b_code']}");			
			endif;

			if($param['bi_userfield_use'] == "Y"):		// 사용자 필드 사용하는 경우
				$join = "%s LEFT OUTER JOIN %s AS c ON a.UB_NO = c.AD_UB_NO";
				$query = sprintf($join, $query, "BOARD_AD_{$param['b_code']}");	
			endif;

			if($param['join_type'] == "regNo"):
				$query	= "{$query} LEFT OUTER JOIN MEMBER_MGR AS m ON a.UB_REG_NO = m.M_NO";
				
			else:
				$join	= "%s LEFT OUTER JOIN MEMBER_MGR AS m ON a.UB_M_NO = m.M_NO";
				$query	= sprintf($join, $query);
			endif;

			if($param['product_mgr_use'] == "Y"):
				$query	= "{$query} LEFT OUTER JOIN PRODUCT_MGR AS PM ON PM.P_CODE = a.UB_P_CODE";
			endif;	
			    
			if($param['product_img_use'] == "Y"):
				$query	= "{$query} LEFT OUTER JOIN PRODUCT_IMG AS PG ON a.UB_P_CODE = PG.P_CODE AND PG.PM_TYPE = 'list'";
			endif;

			/** 2013.05.09 코멘트 개수 **/
			if($param['cm_cnt_use'] == "Y"):
				$join	= "%s LEFT OUTER JOIN (SELECT CM_UB_NO, COUNT(CM_UB_NO) CMT_CNT FROM %s GROUP BY CM_UB_NO) AS cm ON a.UB_NO = cm.CM_UB_NO";
				$query	= sprintf($join, $query, "BOARD_CM_{$param['b_code']}");
			endif;
			/** 2013.05.09 코멘트 개수 **/

			$where = "%s WHERE a.UB_NO IS NOT NULL";
			$query = sprintf($where, $query);

			if($param['ub_bc_no']): // 카테고리
				$query = sprintf("%s AND a.UB_BC_NO = '%s'", $query, $param['ub_bc_no']);
			endif;

			if($param['ub_p_code']): // 상품코드
				$query = sprintf("%s AND a.UB_P_CODE = '%s'", $query, $param['ub_p_code']);
			endif;

			if($param['ub_m_no']): // 회원번호
				$query = sprintf("%s AND a.UB_M_NO = '%s'", $query, $param['ub_m_no']);
			endif;
		
			if($param['ub_no'] && $op == "OP_SELECT"):
				$query = sprintf("%s AND a.UB_NO = '%s'", $query, $param['ub_no']);
			endif;

			if($param['ub_lng']): // 작성 언어
				$query = sprintf("%s AND a.UB_LNG = '%s'", $query, $param['ub_lng']);
			endif;

			if($param['ub_no_list']):
				$query = sprintf("%s AND a.UB_NO in (%s)", $query, $param['ub_no_list']);
			endif;


			if($param['search_ub_reg_dt_op'] == "TODAY"):
				$query = sprintf("%s AND a.UB_REG_DT > curdate()", $query);
			endif;

			if($param['ub_func_notice']):
				$query = sprintf("%s AND SUBSTR(a.UB_FUNC ,1, 1) = '%s'", $query, $param['ub_func_notice']);	
			endif;

			if($param['ub_func_icon']):
				$query = sprintf("%s AND SUBSTR(a.UB_FUNC ,3, 1) = '%s'", $query, $param['ub_func_icon']);	
			endif;

			if($param['ub_func_icon_widget']):
				$query = sprintf("%s AND SUBSTR(a.UB_FUNC ,4, 1) = '%s'", $query, $param['ub_func_icon_widget']);	
			endif;

			if($param['answer_no']):
				$query = sprintf("%s AND a.UB_ANS_STEP = ''", $query);	
			endif;

			if($param['p_shop_no']):
				$query = "$query AND PM.P_SHOP_NO = {$param['p_shop_no']}";
			endif;

			if($param['ub_shop_no']):
				$query = sprintf("%s AND a.UB_SHOP_NO = %s", $query, $param['ub_shop_no']);
			endif;

			if($param['only_question'] == "Y"):
				// 질문글만 가져오기
				$query = "{$query} AND a.UB_ANS_NO = a.UB_NO";
			endif;

			## 2013.04.16 - myTarget 이 mypage 인 경우 자신이 작성한 글만 가져온다.
			if($param['ub_m_no'] && $param['myTarget'] == "mypage"): 
				$query = sprintf("%s OR a.UB_ANS_NO IN (SELECT UB_NO FROM %s WHERE UB_M_NO = %d)", $query, "BOARD_UB_{$param['b_code']}", $param['ub_m_no']); 
			endif;

			## 2013.04.08 - 위젯은 답변 출력 안함으로 변경
			if($this->field['BOARD_INFO']['bi_dataanswer_use']=="N" || $param['myTarget'] == "widget"):
				// 답변 사용 하지 않는 경우.
				$query = sprintf("%s AND ( UB_ANS_STEP = '' OR UB_ANS_STEP = 0 )", $query);
			endif;

			## 2014.05.19 - kim hee sung, 사용자필드 temp1
			if($param['ad_temp1']):
				if($param['ad_temp1_null']):
					$query			 = "{$query} AND (c.AD_TEMP1 = '{$param['ad_temp1']}' OR c.AD_TEMP1 IS NULL OR c.AD_TEMP1 = '')";
				else:
					$query			 = "{$query} AND c.AD_TEMP1 = '{$param['ad_temp1']}'";
				endif;
			endif;

			## 작성일자 종료일자 검색
			if($param['searchRegDTStart'] || $param['searchRegDTEnd']):
				if(!$param['searchRegDTStart']) { $param['searchRegDTStart']	= "1900-12-08";		}
				if(!$param['searchRegDTEnd'])	{ $param['searchRegDTEnd']		= "2200-12-08";;	}

				$param['searchRegDTStart']		= mysql_real_escape_string($param['searchRegDTStart']);
				$param['searchRegDTEnd']		= mysql_real_escape_string($param['searchRegDTEnd']);
				$query		= "{$query} AND UB_REG_DT BETWEEN DATE_FORMAT('{$param['searchRegDTStart']}','%Y-%m-%d 00:00:00') AND DATE_FORMAT('{$param['searchRegDTEnd']}','%Y-%m-%d 23:59:59')";
			endif;

			if($param['searchKey'] || $param['searchVal']):
				// 검색
				$searchVal		= $param['searchVal']; 
				$searchKey		= $param['searchKey']; 
				$searchKeyOp	= array(	"title"			=> "UB_TITLE LIKE ('%%{$searchVal}%%')",				
											"text"			=> "UB_TEXT LIKE ('%%{$searchVal}%%')",
											"title_text"	=> "UB_TITLE LIKE ('%%{$searchVal}%%') OR UB_TEXT LIKE ('%%{$searchVal}%%')", 
											"name"			=> "UB_NAME LIKE ('%%{$searchVal}%%')", 
											"id"			=> "UB_M_ID LIKE ('%%{$searchVal}%%')"			);

				$search		= $searchKeyOp[$searchKey];
				if(!$search):
					foreach($searchKeyOp as $key => $data):
						if($search) { $search		= "{$search} OR"; }
						$search						= "{$search} {$data}";
					endforeach;
					$search							= "( {$search} )";
					
				endif;

				$query	= sprintf("%s AND %s", $query, $search);
			endif;

			if($param['orderby']) :
				$query = sprintf("%s ORDER BY %s", $query, $param['orderby']); 
			endif;

			if($param['page_line']) :
				$query = sprintf("%s LIMIT %d, %d", $query, $param['limit_first'], $param['page_line']);
			endif;

//			 SUBSTR(UB_FUNC,3,1) = "Y"
//			echo $query;
			return $this->getSelectQuery($query, $op);
		}


		// $this->field['BOARD_INFO']['bi_attachedfile_use']
		function getDataMgrSelect($op="OP_LIST")
		{
			$column['OP_LIST']		= "*";
			$column['OP_COUNT']		= "COUNT(*)";
			$column['OP_SELECT']	= "*";

			$query = "SELECT %s FROM %s AS a ";
			$query = sprintf($query, $column[$op], "BOARD_UB_{$this->field['b_code']}");

			if($this->field['BOARD_INFO']['bi_attachedfile_use'] > 0):		// 첨부 파일이 있는 경우.
				$join = "%s LEFT OUTER JOIN %s AS b ON a.UB_NO = b.FL_UB_NO AND b.FL_KEY = 'listImage'";
				$query = sprintf($join, $query, "BOARD_FL_{$this->field['b_code']}");			
			endif;

			if($this->field['BOARD_INFO']['bi_userfield_use'] == "Y"):		// 사용자 필드 사용하는 경우
				$join = "%s LEFT OUTER JOIN %s AS c ON a.UB_NO = c.AD_UB_NO";
				$query = sprintf($join, $query, "BOARD_AD_{$this->field['b_code']}");	
			endif;

			$where = "%s WHERE a.UB_NO IS NOT NULL";
			$query = sprintf($where, $query);

			if($this->field['ub_bc_no']): // 카테고리
				$query = sprintf("%s AND a.UB_BC_NO = '%s'", $query, $this->field['ub_bc_no']);
			endif;

			if($this->field['ub_no'] && $op == "OP_SELECT"):
				$query = sprintf("%s AND a.UB_NO = '%s'", $query, $this->field['ub_no']);
			endif;

			if($this->field['search_ub_reg_dt_op'] == "TODAY"):
				$query = sprintf("%s AND a.UB_REG_DT > curdate()", $query);
			endif;

			if($this->field['ub_func_icon']):
				$query = sprintf("%s AND SUBSTR(a.UB_FUNC ,3, 1) = '%s'", $query, $this->field['ub_func_icon']);	
			endif;

			## 2013.04.08 - 위젯은 답변 출력 안함으로 변경
			if($this->field['BOARD_INFO']['bi_dataanswer_use']=="N" || $this->field['myTarget'] == "widget"):
				// 답변 사용 하지 않는 경우.
				$query = sprintf("%s AND UB_ANS_STEP = ''", $query);
			endif;

			if($this->field['searchKey'] && $this->field['searchVal']):
				// 검색
				$searchVal		= $this->field['searchVal']; 
				$searchKey		= $this->field['searchKey']; 
				$searchKeyOp	= array(	"title"			=> "UB_TITLE LIKE ('%%{$searchVal}%%')",				
											"text"			=> "UB_TEXT LIKE ('%%{$searchVal}%%')",
											"title_text"	=> "UB_TITLE LIKE ('%%{$searchVal}%%') OR UB_TEXT LIKE ('%%{$searchVal}%%')", 
											"name"			=> "UB_NAME LIKE ('%%{$searchVal}%%')", 
											"id"			=> "UB_M_ID LIKE ('%%{$searchVal}%%')"			);
				
				$search		= $searchKeyOp[$searchKey];
				if($search):
					$query	= sprintf("%s AND %s", $query, $search);
				endif;
			endif;

			if($this->field['orderby']) :
				$query = sprintf("%s ORDER BY %s", $query, $this->field['orderby']); 
			endif;

			if($this->field['page_line']) :
				$query = sprintf("%s LIMIT %d, %d", $query, $this->field['limit_first'], $this->field['page_line']);
			endif;

		
//			 SUBSTR(UB_FUNC,3,1) = "Y"

			return $this->getSelectQuery($query, $op);
		}

		function getDataMgrAnsStepMaxSelect()
		{
			$query = "SELECT MAX(UB_ANS_STEP) as UB_ANS_STEP FROM %s";
			$where = "%s WHERE UB_ANS_NO = %s AND UB_ANS_STEP LIKE '%s%%'";
			
			$query = sprintf($query, $this->field['ub_table']);
			$query = sprintf($where, $query, $this->field['ub_ans_no'], $this->field['ub_ans_step']);

			return $this->getSelectQuery($query, "OP_SELECT");
		}

		function getDataMgrNextSelectEx($param) {

			$table = "BOARD_UB_{$param['b_code']}";

			$query = "SELECT * FROM {$table} AS a WHERE a.UB_ANS_STEP = '' AND a.UB_NO > {$param['ub_no']}";

			if($param['ub_m_no']): // 회원번호
				$query = sprintf("%s AND a.UB_M_NO = '%s'", $query, $param['ub_m_no']);
			endif;

			if($param['orderby']) :
				$query = sprintf("%s ORDER BY %s", $query, $param['orderby']); 
			endif;

			if($param['page_line']) :
				$query = sprintf("%s LIMIT %d, %d", $query, $param['limit_first'], $param['page_line']);
			endif;

			return $this->getSelectQuery($query, "OP_SELECT");
		}

		function getDataMgrPrveSelectEx($param) {

			$table = "BOARD_UB_{$param['b_code']}";

			$query = "SELECT * FROM {$table} AS a WHERE a.UB_ANS_STEP = '' AND UB_NO < {$param['ub_no']}";

			if($param['ub_m_no']): // 회원번호
				$query = sprintf("%s AND a.UB_M_NO = '%s'", $query, $param['ub_m_no']);
			endif;

			if($param['orderby']) :
				$query = sprintf("%s ORDER BY %s", $query, $param['orderby']); 
			endif;

			if($param['page_line']) :
				$query = sprintf("%s LIMIT %d, %d", $query, $param['limit_first'], $param['page_line']);
			endif;

			return $this->getSelectQuery($query, "OP_SELECT");
		}

		// SELECT COUNT(*) AS TOTAL, SUM(CASE WHEN  UB_REG_DT > CURDATE() THEN 1 ELSE 0 END) AS TODAY FROM BOARD_UB_NOTICE
		function getDataMgrCountEx($param) {
			
			$table = "BOARD_UB_{$param['b_code']}";

			$query = "SELECT COUNT(*) AS TOTAL, SUM(CASE WHEN  UB_REG_DT > CURDATE() THEN 1 ELSE 0 END) AS TODAY FROM {$table} WHERE UB_NO IS NOT NULL ";
			
			if($param['ub_func_icon']):
				$query = "{$query} AND SUBSTR(UB_FUNC ,3, 1) = '{$param['ub_func_icon']}'";
			endif;

			if($param['answer_no']):
				$query = "{$query} AND UB_ANS_STEP = ''";	
			endif;

			return $this->getSelectQuery($query, "OP_SELECT");
		}

		/********************************** count **********************************/

		/********************************** Insert **********************************/
		function getDataMgrInsert()
		{	
//			$param['UB_NO']			= $this->field['ub_no'];
			$param['UB_NAME']		= $this->getSQLString($this->field['ub_name']);
			$param['UB_M_NO']		= $this->getSQLString($this->field['ub_m_no']);
			$param['UB_M_ID']		= $this->getSQLString($this->field['ub_m_id']);
			$param['UB_PASS']		= $this->getSQLString($this->field['ub_pass']);
			$param['UB_MAIL']		= $this->getSQLString($this->field['ub_mail']);
			$param['UB_URL']		= $this->getSQLString($this->field['ub_url']);
			$param['UB_TITLE']		= $this->getSQLString($this->field['ub_title']);
			$param['UB_TEXT']		= $this->getSQLString($this->field['ub_text']);
			$param['UB_TEXT_MOBILE']= $this->getSQLString($this->field['ub_text_mobile']);
			$param['UB_FUNC']		= $this->getSQLString($this->field['ub_func']);
			$param['UB_IP']			= $this->getSQLString($this->field['ub_ip']);
			$param['UB_READ']		= $this->getSQLInteger($this->field['ub_read']);
			$param['UB_BC_NO']		= $this->getSQLInteger($this->field['ub_bc_no']);	
			$param['UB_LNG']		= $this->getSQLString($this->field['ub_lng']);
			$param['UB_ANS_NO']		= $this->getSQLInteger($this->field['ub_ans_no']);	
			$param['UB_ANS_STEP']	= $this->getSQLString($this->field['ub_ans_step']);	
			$param['UB_ANS_M_NO']	= $this->getSQLInteger($this->field['ub_ans_m_no']);	
			$param['UB_P_CODE']		= $this->getSQLString($this->field['ub_p_code']);	
			$param['UB_P_GRADE']	= $this->getSQLInteger($this->field['ub_p_grade']);	
			if($this->field['ub_table'] == "BOARD_UB_S_REQ") { $param['UB_SHOP_NO'] = $this->getSQLInteger($this->field['ub_shop_no']); }
			$param['UB_REG_DT']		= "NOW()";
//			$param['UB_REG_DT']		= $this->getSQLDatetime($this->field['ub_reg_dt']);
			$param['UB_REG_NO']		= $this->getSQLInteger($this->field['ub_reg_no']);
			$param['UB_MOD_DT']		= "NOW()";
//			$param['UB_MOD_DT']		= $this->getSQLDatetime($this->field['ub_mod_dt']);
			$param['UB_MOD_NO']		= $this->getSQLInteger($this->field['ub_mod_no']);
			
			return $this->db->getInsertParam($this->field['ub_table'],$param);
		}

		function getDataMgrInsertEx($paramData)
		{	
//			$param['UB_NO']			= $this->field['ub_no'];
			$param['UB_NAME']		= $this->getSQLString($paramData['ub_name']);
			$param['UB_M_NO']		= $this->getSQLString($paramData['ub_m_no']);
			$param['UB_M_ID']		= $this->getSQLString($paramData['ub_m_id']);
			$param['UB_PASS']		= $this->getSQLString($paramData['ub_pass']);
			$param['UB_MAIL']		= $this->getSQLString($paramData['ub_mail']);
			$param['UB_URL']		= $this->getSQLString($paramData['ub_url']);
			$param['UB_TITLE']		= $this->getSQLString($paramData['ub_title']);
			$param['UB_TEXT']		= $this->getSQLString($paramData['ub_text']);
			$param['UB_TEXT_MOBILE']= $this->getSQLString($paramData['ub_text_mobile']);
			$param['UB_FUNC']		= $this->getSQLString($paramData['ub_func']);
			$param['UB_IP']			= $this->getSQLString($paramData['ub_ip']);
			$param['UB_READ']		= $this->getSQLInteger($paramData['ub_read']);
			$param['UB_BC_NO']		= $this->getSQLInteger($paramData['ub_bc_no']);	
			$param['UB_LNG']		= $this->getSQLString($paramData['ub_lng']);
			$param['UB_ANS_NO']		= $this->getSQLInteger($paramData['ub_ans_no']);	
			$param['UB_ANS_STEP']	= $this->getSQLString($paramData['ub_ans_step']);	
			$param['UB_ANS_M_NO']	= $this->getSQLInteger($paramData['ub_ans_m_no']);	
			$param['UB_P_CODE']		= $this->getSQLString($paramData['ub_p_code']);	
			$param['UB_P_GRADE']	= $this->getSQLInteger($paramData['ub_p_grade']);
			if($paramData['b_code'] == "S_REQ") { $param['UB_SHOP_NO'] = $this->getSQLInteger($paramData['ub_shop_no']); }
			$param['UB_REG_DT']		= "NOW()";
//			$param['UB_REG_DT']		= $this->getSQLDatetime($paramData['ub_reg_dt']);
			$param['UB_REG_NO']		= $this->getSQLInteger($paramData['ub_reg_no']);
			$param['UB_MOD_DT']		= "NOW()";
//			$param['UB_MOD_DT']		= $this->getSQLDatetime($paramData['ub_mod_dt']);
			$param['UB_MOD_NO']		= $this->getSQLInteger($paramData['ub_mod_no']);

			return $this->db->getInsertParam("BOARD_UB_{$paramData['b_code']}",$param);
		}
		/********************************** Insert Select ***************************/

		function getDataMgrInsertSelect($param)
		{
			$query = "INSERT IGNORE INTO BOARD_UB_{$param['b_code_insert']} (
						UB_NAME,
						UB_M_NO,
						UB_M_ID,
						UB_PASS,
						UB_MAIL,
						UB_URL,
						UB_TITLE,
						UB_TEXT,
						UB_TEXT_MOBILE,
						UB_FUNC,
						UB_IP,
						UB_READ,
						UB_BC_NO,
						UB_LNG,
						UB_ANS_NO,
						UB_ANS_STEP,
						UB_ANS_M_NO,
						UB_PT_NO,
						UB_CI_NO,
						UB_WINNER,
						UB_P_GRADE,
						UB_REG_DT,
						UB_REG_NO,
						UB_MOD_DT,
						UB_MOD_NO		)
					SELECT 
						UB_NAME,
						UB_M_NO,
						UB_M_ID,
						UB_PASS,
						UB_MAIL,
						UB_URL,
						UB_TITLE,
						UB_TEXT, 
						UB_TEXT_MOBILE,
						UB_FUNC,
						UB_IP,
						UB_READ,
						UB_BC_NO,
						UB_LNG,
						UB_ANS_NO,
						UB_ANS_STEP,
						UB_ANS_M_NO,
						UB_PT_NO,
						UB_CI_NO,
						UB_WINNER,
						UB_P_GRADE,
						UB_REG_DT,
						UB_REG_NO,
						UB_MOD_DT,
						UB_MOD_NO		
					FROM BOARD_UB_{$param['b_code_select']} ";
			
			if(!$param['b_code_insert']) { return; }
			if(!$param['b_code_select']) { return; }
			
			$where = "";
			
			if($param['ub_no_list']):
				if($where) { $where .= "AND "; }
				$where .= "UB_NO IN ({$param['ub_no_list']}) ";
			endif;

			if(!$where) { return; }

			$query .= "WHERE {$where}";

			return $this->db->getExecSql($query);

		}

		/********************************** Update **********************************/
		function getDataMgrUpdate()
		{
//			$param['UB_NO']			= $this->field['ub_no'];
//			$param['UB_M_NO']		= $this->getSQLString($this->field['ub_m_no']);
//			$param['UB_READ']		= $this->getSQLInteger($this->field['ub_read']);
//			$param['UB_REG_DT']		= "NOW()";
//			$param['UB_REG_NO']		= $this->getSQLInteger($this->field['ub_reg_no']);
//			$param['UB_ANS_NO']		= $this->getSQLInteger($this->field['ub_ans_no']);	
//			$param['UB_ANS_STEP']	= $this->getSQLString($this->field['ub_ans_step']);	
//			$param['UB_ANS_M_NO']	= $this->getSQLInteger($this->field['ub_ans_m_no']);	
			
			if($this->field['S_PAGE_AREA'] == "adminPage"):
			$param['UB_M_ID']		= $this->getSQLString($this->field['ub_m_id']);
			endif;
			$param['UB_NAME']		= $this->getSQLString($this->field['ub_name']);
			$param['UB_PASS']		= $this->getSQLString($this->field['ub_pass']);
			$param['UB_MAIL']		= $this->getSQLString($this->field['ub_mail']);
			$param['UB_URL']		= $this->getSQLString($this->field['ub_url']);
			$param['UB_TITLE']		= $this->getSQLString($this->field['ub_title']);
			$param['UB_TEXT']		= $this->getSQLString($this->field['ub_text']);
			$param['UB_TEXT_MOBILE']= $this->getSQLString($this->field['ub_text_mobile']);
			$param['UB_FUNC']		= $this->getSQLString($this->field['ub_func']);
			$param['UB_IP']			= $this->getSQLString($this->field['ub_ip']);
			$param['UB_BC_NO']		= $this->getSQLInteger($this->field['ub_bc_no']);
			$param['UB_LNG']		= $this->getSQLString($this->field['ub_lng']);
			$param['UB_P_GRADE']	= $this->getSQLInteger($this->field['ub_p_grade']);	
//			$param['UB_MOD_DT']		= "NOW()";
			$param['UB_MOD_DT']		= $this->getSQLDatetime($this->field['ub_reg_dt']);
			$param['UB_MOD_NO']		= $this->getSQLInteger($this->field['ub_mod_no']);
//			$param['UB_REG_DT']		= "NOW()";
			$param['UB_REG_DT']		= $this->getSQLDatetime($this->field['ub_reg_dt']);

			$where					= "UB_NO = {$this->field['ub_no']}";
	
			return $this->db->getUpdateParam($this->field['ub_table'], $param, $where);
		}

		function getPointUpdateEx($paramData) {
			$strTableName			= "BOARD_UB_{$paramData['b_code']}";
			$param['UB_PT_NO']		= $this->getSQLInteger($paramData['ub_pt_no']);
			$param['UB_WINNER']		= $this->getSQLString($paramData['ub_winner']);
			
			$where					= "UB_NO = {$paramData['ub_no']}";
			return $this->db->getUpdateParam($strTableName, $param, $where);
		}

		function getCouponUpdateEx($paramData) {
			$strTableName			= "BOARD_UB_{$paramData['b_code']}";
			$param['UB_CI_NO']		= $this->getSQLInteger($paramData['ub_ci_no']);
			$param['UB_WINNER']		= $this->getSQLString($paramData['ub_winner']);
			
			$where					= "UB_NO = {$paramData['ub_no']}";
			return $this->db->getUpdateParam($strTableName, $param, $where);
		}

		function getDataMgrAnsNoUpdate()
		{
			$field = "UB_ANS_NO = {$this->field['ub_ans_no']}";
			$where = "WHERE  UB_NO = {$this->field['ub_no']}";
			
			return $this->db->getUpdateSql($this->field['ub_table'], $field, $where);
		}

		function getDataMgrAnsNoUpdateEx($paramData)
		{
			$field = "UB_ANS_NO = {$paramData['ub_ans_no']}";
			$where = "WHERE  UB_NO = {$paramData['ub_no']}";
			
			return $this->db->getUpdateSql("BOARD_UB_{$paramData['b_code']}", $field, $where);
		}

		function getDataMgrReadUpdate()
		{
			if(!$this->field['ub_no']) { return; }

			$field = "UB_READ = UB_READ + 1";
			$where = "WHERE  UB_NO = {$this->field['ub_no']}";
			
			return $this->db->getUpdateSql("BOARD_UB_{$this->field['b_code']}", $field, $where);
		}

		/********************************** Delete **********************************/
		function getDataMgrDelete(&$db)
		{
			$where					= "UB_NO = {$this->field['ub_no']}";
			
			if($this->field['ub_ans_no'] && $this->field['ub_ans_no']):
				$where				= "UB_ANS_NO = {$this->field['ub_ans_no']} AND UB_ANS_STEP LIKE '{$this->field['ub_ans_step']}%'";
			endif;

			$this->db->getDelete($this->field['ub_table'], $where);
		}

		/********************************** Create **********************************/
		function getDataMgrCreateTable() {

			## 기본설정
			$strTable = $this->field['ub_table'];
			$strUB_SHOP_NO_COLUMN = "";
			if($strTable == "S_REQ") { $strUB_SHOP_NO_COLUMN = "`UB_SHOP_NO` int(11) default NULL COMMENT '샵번호(입점몰번호)',"; }

			$query = "CREATE TABLE `{$strTable}` (
					  `UB_NO` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '번호',
					  `UB_NAME` varchar(20) DEFAULT NULL COMMENT '이름',
					  `UB_M_NO` bigint(20) DEFAULT NULL COMMENT '회원번호',
					  `UB_M_ID` varchar(20) DEFAULT NULL COMMENT '아이디',
					  `UB_PASS` varchar(100) DEFAULT NULL COMMENT '비밀번호',
					  `UB_MAIL` varchar(50) DEFAULT NULL COMMENT '이메일',
					  `UB_URL` varchar(200) DEFAULT NULL COMMENT '웹주소',
					  `UB_TITLE` varchar(200) DEFAULT NULL COMMENT '제목',
					  `UB_TEXT` text COMMENT '내용',
					  `UB_TEXT_MOBILE` text COMMENT '내용(모바일)',
					  `UB_FUNC` varchar(20) DEFAULT '0000000000' COMMENT '기능(공지글, 비밀글..)',
					  `UB_IP` varchar(20) DEFAULT NULL COMMENT 'IP',
					  `UB_READ` int(11) DEFAULT '0' COMMENT '조회수',
					  `UB_BC_NO` bigint(20) DEFAULT '0' COMMENT '카테고리 번호',
					  `UB_LNG` varchar(2) DEFAULT NULL COMMENT '작성 언어',
					  `UB_ANS_NO` bigint(20) default NULL COMMENT '계층형-최상위글 번호',
					  `UB_ANS_STEP` varbinary(100) default NULL COMMENT '계층형-답변모양',
					  `UB_ANS_M_NO` bigint(20) default NULL COMMENT '계층형-원글 회원 ID',
					  `UB_PT_NO` bigint(20) default NULL COMMENT '이벤트-포인트 번호',
					  `UB_CI_NO` bigint(20) default NULL COMMENT '이벤트-쿠폰 번호',
					  `UB_WINNER` varchar(1) default NULL COMMENT '이벤트-담청자',
					  `UB_P_CODE` varchar(20) default NULL COMMENT '상품-코드',
					  `UB_P_GRADE` smallint(6) default NULL COMMENT '상품-평점', {$strUB_SHOP_NO_COLUMN}
					  `UB_REG_DT` datetime DEFAULT NULL COMMENT '작성일',
					  `UB_REG_NO` bigint(20) DEFAULT NULL COMMENT '작성자',
					  `UB_MOD_DT` datetime DEFAULT NULL COMMENT '수정일',
					  `UB_MOD_NO` bigint(20) DEFAULT NULL COMMENT '수정자',
					  PRIMARY KEY (`UB_NO`),
					  KEY `IDX_P_CODE` (`UB_P_CODE`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='{$this->field['b_name']}';";
					
			return $this->db->getExecSql($query);
		}

		function getDataMgrCreateProcedure_I() {
		}

		function getDataMgrCreateProcedure_U() {
		}

		function getDataMgrCreateProcedure_D() {
		}

		/********************************** drop table query ****************************/
		/*		주의!! 테이블 삭제 후, 복구 불가!! 신중하게 사용 할것!!					*/
		/********************************************************************************/
		function getDataMgrDropTable(&$param) {
			$query = "DROP TABLE {$param['tableName']};";
			return $this->db->getExecSql($query);
		}

		function getDataMgrDropProcedure_I() {
		}

		function getDataMgrDropProcedure_U() {
		}

		function getDataMgrDropProcedure_D() {
		}
    }
?>
