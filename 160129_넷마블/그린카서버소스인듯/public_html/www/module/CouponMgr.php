<?
#/*====================================================================*/# 
#|작성자	: 박영미(ivetmi@naver.com)									|# 
#|작성일	: 2013-01-29												|# 
#|작성내용	: 쿠폰 생성 관리			 								|# 
#/*====================================================================*/# 

class CouponMgr
{
	private $query;
	private $param;

	/********************************** List **********************************/
	function getCouponTotal($db)
	{
		$query  = "SELECT							";
		$query .= "     COUNT(*)					";
		$query .= "FROM ".TBL_COUPON_MGR." A		";
		$query .= "WHERE A.CU_NO IS NOT NULL		";
		
		if ($this->getSearchField() && $this->getSearchKey()){

			$query .= "	AND ";
			switch ($this->getSearchField()){
				case "N":
					$query .= "	A.CU_NAME LIKE '%".$this->getSearchKey()."%'			";
				break;
			}
		}
		
		/* 쿠폰 종류 */
		if ($this->getSearchCouponIssue()){
			$query .= " AND A.CU_ISSUE = '".$this->getSearchCouponIssue()."'	";
		}

		/* 쿠폰 사용유무 */
		if ($this->getSearchCouponUse()){
			$query .= " AND A.CU_USEYN = '".$this->getSearchCouponUse()."'	";
		}

		/* 등록일 */
		if ($this->getSearchRegStartDt() && $this->getSearchRegEndDt()){
			$query .= " AND (A.CU_PERIOD != '1' OR (";
			$query .= "		 A.CU_PERIOD = 1 AND A.CU_REG_DT BETWEEN DATE_FORMAT('".$this->getSearchRegStartDt()."','%Y-%m-%d 00:00:00') ";
			$query .= "					      AND DATE_FORMAT('".$this->getSearchRegEndDt()."','%Y-%m-%d 23:59:59')) ";
			$query .= ")	";
		}

		return $db->getCount($query);
	}


	function getCouponList($db)
	{
		$query  = "SELECT							";
		$query .= "      A.*							";
		$query .= "		,(SELECT COUNT(*) FROM ".TBL_COUPON_ISSUE." WHERE CU_NO = A.CU_NO) COUPON_ISSUE_CNT	";
		$query .= "FROM ".TBL_COUPON_MGR." A		";
		$query .= "WHERE A.CU_NO IS NOT NULL		";		
		
		/* 쿠폰 종류 */
		if ($this->getSearchCouponIssue()){
			$query .= " AND A.CU_ISSUE = '".$this->getSearchCouponIssue()."'	";
		}

		/* 쿠폰 사용유무 */
		if ($this->getSearchCouponUse()){
			$query .= " AND A.CU_USEYN = '".$this->getSearchCouponUse()."'	";
		}

		if ($this->getSearchRegStartDt() && $this->getSearchRegEndDt()){
			$query .= "AND (A.CU_PERIOD != '1' OR (";
			$query .= "		 A.CU_PERIOD = 1 AND A.CU_REG_DT BETWEEN DATE_FORMAT('".$this->getSearchRegStartDt()."','%Y-%m-%d 00:00:00') ";
			$query .= "					      AND DATE_FORMAT('".$this->getSearchRegEndDt()."','%Y-%m-%d 23:59:59')) ";
			$query .= ")	";
		}

		$query .= "ORDER BY CU_NO DESC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();	
		
		return $db->getExecSql($query);
	}


	function getCouponIssueTotal($db)
	{
		$query  = "SELECT							";
		$query .= "     COUNT(*)					";
		$query .= "FROM ".TBL_COUPON_ISSUE." A		";
		$query .= "WHERE A.CI_NO IS NOT NULL		";

		if ($this->getCU_NO()){
			$query .= "	AND A.CU_NO = ".$this->getCU_NO();
		}

		if ($this->getM_NO()){
			$query .= "	AND A.M_NO = ".$this->getM_NO();
		}

		return $db->getCount($query);
	}


	function getCouponIssueList($db)
	{
		$query  = "SELECT											";
		$query .= "     A.*											";
		$query .= "    ,B.M_ID										";
		$query .= "    ,B.M_MAIL									";
		$query .= "    ,CONCAT(B.M_F_NAME,' ',B.M_L_NAME) M_NAME	";
		$query .= "    ,B.M_PHONE									";
		$query .= "    ,C.CU_NAME									";
		$query .= "FROM ".TBL_COUPON_ISSUE." A                      ";
		$query .= "LEFT OUTER JOIN ".TBL_MEMBER_MGR." B             ";
		$query .= "ON A.M_NO = B.M_NO								";
		$query .= "JOIN ".TBL_COUPON_MGR." C			            ";
		$query .= "ON A.CU_NO = C.CU_NO								";
		$query .= "WHERE A.CI_NO IS NOT NULL						";

		if ($this->getCU_NO()){
			$query .= "	AND A.CU_NO = ".$this->getCU_NO()."			";
		}

		if ($this->getM_NO()){
			$query .= "	AND A.M_NO = ".$this->getM_NO()."			";
		}

		$query .= "ORDER BY A.CI_NO ASC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();				
		
		return $db->getExecSql($query);
	}
	/********************************** View **********************************/
	function getCouponView($db)
	{
		$query = "SELECT * FROM ".TBL_COUPON_MGR." WHERE CU_NO = ".$this->getCU_NO();

		return $db->getSelect($query);
	}
	
	function getCouponApplyList($db){
		
		$query  = "SELECT * FROM ".TBL_COUPON_APPLY." WHERE CU_NO = ".$this->getCU_NO();		
		$query .= "	ORDER BY CUA_NO ASC	";

		return $db->getArrayTotal($query);
	}

	function getCouponCodeDupCnt($db)
	{
		$query  = "SELECT Count(*) FROM ".TBL_COUPON_ISSUE." WHERE CU_NO = ".$this->getCU_NO();		
		$query .= "	AND CI_CODE = '".$this->getCI_CODE()."'	";

		return $db->getCount($query);
	}

	/********************************** Insert **********************************/
	function getInsert($db)
	{
		$query = "CALL SP_COUPON_MGR_I (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getCU_NAME();
		$param[]  = $this->getCU_TEXT();
		$param[]  = $this->getCU_TYPE();
		$param[]  = $this->getCU_ISSUE();
		$param[]  = $this->getCU_PRICE();
		$param[]  = $this->getCU_PRICE_OFF();
		$param[]  = $this->getCU_USE();
		$param[]  = $this->getCU_IMG_MTH();
		$param[]  = $this->getCU_IMG_PATH();
		$param[]  = $this->getCU_PERIOD();
		$param[]  = $this->getCU_START_DT();
		$param[]  = $this->getCU_END_DT();
		$param[]  = $this->getCU_USE_DAY();
		$param[]  = $this->getCU_LIMIT_PRICE();
		$param[]  = $this->getCU_LIMIT_SETTLE();
		$param[]  = $this->getCU_LIMIT_MEMBER();
		$param[]  = $this->getCU_USEYN();
		$param[]  = $this->getCU_CNT();
		$param[]  = $this->getCU_REG_NO();

		return $db->executeBindingQuery($query,$param,true);
	}

	function getApplyInsert($db)
	{
		$query = "CALL SP_COUPON_APPLY_IU (?,?,?);";

		$param[]  = $this->getCU_NO();
		$param[]  = $this->getCU_USE();
		$param[]  = $this->getCUA_CODE();

		return $db->executeBindingQuery($query,$param,true);
	}

	function getIssueInsert($db)
	{
		$query = "CALL SP_COUPON_ISSUE_I (?,?,?,?,?,?,?);";

		if (!$this->getCI_USE_O_NO()) $this->setCI_USE_O_NO(0);
		
		$param[]  = $this->getM_NO();
		$param[]  = $this->getCU_NO();
		$param[]  = "0";
		$param[]  = $this->getCI_CODE();
		$param[]  = "";
		$param[]  = $this->getCI_USE_O_NO();
		$param[]  = $this->getCI_REG_NO();
		
		return $db->executeBindingQuery($query,$param,true);
	}

	/********************************** Update **********************************/
	function getUpdate($db)
	{
		$query = "CALL SP_COUPON_MGR_U (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getCU_NO();
		$param[]  = $this->getCU_NAME();
		$param[]  = $this->getCU_TEXT();
		$param[]  = $this->getCU_TYPE();
		$param[]  = $this->getCU_ISSUE();
		$param[]  = $this->getCU_PRICE();
		$param[]  = $this->getCU_PRICE_OFF();
		$param[]  = $this->getCU_USE();
		$param[]  = $this->getCU_IMG_MTH();
		$param[]  = $this->getCU_IMG_PATH();
		$param[]  = $this->getCU_PERIOD();
		$param[]  = $this->getCU_START_DT();
		$param[]  = $this->getCU_END_DT();
		$param[]  = $this->getCU_USE_DAY();
		$param[]  = $this->getCU_LIMIT_PRICE();
		$param[]  = $this->getCU_LIMIT_SETTLE();
		$param[]  = $this->getCU_LIMIT_MEMBER();
		$param[]  = $this->getCU_USEYN();
		$param[]  = $this->getCU_MOD_NO();

		return $db->executeBindingQuery($query,$param,true);
	}
	
	function getCouponImgUpdate($db)
	{
		$query = "UPDATE ".TBL_COUPON_MGR." SET CU_IMG_PATH = '' WHERE CU_NO = ".$this->getCU_NO();
		return $db->getExecSql($query);
	}

	function getCouponIssueUpdate($db,$param)
	{
		$query = "UPDATE ".TBL_COUPON_ISSUE." SET ";

		if ($param['CU_PERIOD'] == "1")
		{
			$query .= "  CI_START_DT	= DATE_FORMAT('".$param['CU_START_DT']."','%Y-%m-%d 00:00:00')";
			$query .= " ,CI_END_DT		= DATE_FORMAT('".$param['CU_END_DT']."','%Y-%m-%d 00:00:00')";
		}
		
		if ($param['CU_PERIOD'] == "2")
		{
			$query .= "  CI_START_DT	= NOW()";
			$query .= " ,CI_END_DT		= DATE_ADD(NOW(),INTERVAL ".$param['CU_USE_DAY']." DAY)";
		}

		if ($param['CU_PERIOD'] == "3")
		{
			$query .= "  CI_START_DT	= NOW()";
			$query .= " ,CI_END_DT		= DATE_FORMAT('2999-12-31 23:59:59','%Y-%m-%d 23:59:59')";
		}

		$query .= "	WHERE CU_NO = ".$param['CU_NO'];
		$query .= "		AND IFNULL(CI_USE,'N') != 'Y'	";
		return $db->getExecSql($query);
	}

	/********************************** 쿠폰 사용여부 확인 **********************************/
	function getCouponIsUse($db)
	{
		$query  = "SELECT COUNT(*) FROM ".TBL_COUPON_ISSUE;
		$query .= "	WHERE CU_NO = ".$this->getCU_NO();
		$query .= "		AND CI_USE = 'Y'	";

		return $db->getCount($query);
	}

	/********************************** Delete **********************************/
	function getDelete($db)
	{
		$query = "CALL SP_COUPON_MGR_D (?);";
		$param[]  = $this->getCU_NO();

		return $db->executeBindingQuery($query,$param,true);
	}

	function getCouponApplyDelete($db)
	{
		$query = "DELETE FROM ".TBL_COUPON_APPLY." WHERE CU_NO = ".$this->getCU_NO();
		return $db->getExecSql($query);
	}

	function getCouponApplyAllDelete($db)
	{
		$query = "DELETE FROM ".TBL_COUPON_APPLY." WHERE CU_NO = ".$this->getCU_NO();
		
		if ($this->getCU_USE() == "2"){
			$query .= " AND CUA_TYPE = 'C' ";
			if ($this->getCUA_NO_ALL()) {
				$query .= "	AND CUA_CODE NOT IN (".$this->getCUA_NO_ALL().")	";
			}
		}

		if ($this->getCU_USE() == "3"){
			$query .= " AND CUA_TYPE = 'P' ";
			if ($this->getCUA_NO_ALL()) {
				$query .= "	AND CUA_CODE NOT IN (".$this->getCUA_NO_ALL().")	";
			}
		}
		
		return $db->getExecSql($query);
	}

	function getCouponIssueDelete($db)
	{
		$query = "DELETE FROM ".TBL_COUPON_ISSUE;
		
		if ($this->getCI_NO()){
			$query .= " WHERE CI_NO = ".$this->getCI_NO();
		}

		if ($this->getCU_NO()){
			$query .= " WHERE CU_NO = ".$this->getCU_NO();
		}
		
		return $db->getExecSql($query);
	}

	function getCouponIssueDateUpdate($db)
	{
		$query  = "UPDATE ".TBL_COUPON_ISSUE." SET CI_END_DT = DATE_FORMAT('2999','%Y-%m-%d 23:59:59') ";
		$query .= "WHERE CU_NO = ".$this->getCU_NO()." AND IFNULL(CI_USE,'N') = 'N' ";

		return $db->getExecSql($query);
	}


	/********************************** variable **********************************/
	function setCU_NO($CU_NO){ $this->CU_NO = $CU_NO; }		
	function getCU_NO(){ return $this->CU_NO; }		

	function setCU_NAME($CU_NAME){ $this->CU_NAME = $CU_NAME; }		
	function getCU_NAME(){ return $this->CU_NAME; }		

	function setCU_TEXT($CU_TEXT){ $this->CU_TEXT = $CU_TEXT; }		
	function getCU_TEXT(){ return $this->CU_TEXT; }		

	function setCU_TYPE($CU_TYPE){ $this->CU_TYPE = $CU_TYPE; }		
	function getCU_TYPE(){ return $this->CU_TYPE; }		

	function setCU_ISSUE($CU_ISSUE){ $this->CU_ISSUE = $CU_ISSUE; }		
	function getCU_ISSUE(){ return $this->CU_ISSUE; }		

	function setCU_PRICE($CU_PRICE){ $this->CU_PRICE = $CU_PRICE; }		
	function getCU_PRICE(){ return $this->CU_PRICE; }		

	function setCU_PRICE_OFF($CU_PRICE_OFF){ $this->CU_PRICE_OFF = $CU_PRICE_OFF; }		
	function getCU_PRICE_OFF(){ return $this->CU_PRICE_OFF; }		

	function setCU_USE($CU_USE){ $this->CU_USE = $CU_USE; }		
	function getCU_USE(){ return $this->CU_USE; }		

	function setCU_IMG_MTH($CU_IMG_MTH){ $this->CU_IMG_MTH = $CU_IMG_MTH; }		
	function getCU_IMG_MTH(){ return $this->CU_IMG_MTH; }		

	function setCU_IMG_PATH($CU_IMG_PATH){ $this->CU_IMG_PATH = $CU_IMG_PATH; }		
	function getCU_IMG_PATH(){ return $this->CU_IMG_PATH; }		

	function setCU_PERIOD($CU_PERIOD){ $this->CU_PERIOD = $CU_PERIOD; }		
	function getCU_PERIOD(){ return $this->CU_PERIOD; }		

	function setCU_START_DT($CU_START_DT){ $this->CU_START_DT = $CU_START_DT; }		
	function getCU_START_DT(){ return $this->CU_START_DT; }		

	function setCU_END_DT($CU_END_DT){ $this->CU_END_DT = $CU_END_DT; }		
	function getCU_END_DT(){ return $this->CU_END_DT; }		

	function setCU_USE_DAY($CU_USE_DAY){ $this->CU_USE_DAY = $CU_USE_DAY; }		
	function getCU_USE_DAY(){ return $this->CU_USE_DAY; }		

	function setCU_LIMIT_PRICE($CU_LIMIT_PRICE){ $this->CU_LIMIT_PRICE = $CU_LIMIT_PRICE; }		
	function getCU_LIMIT_PRICE(){ return $this->CU_LIMIT_PRICE; }		

	function setCU_LIMIT_SETTLE($CU_LIMIT_SETTLE){ $this->CU_LIMIT_SETTLE = $CU_LIMIT_SETTLE; }		
	function getCU_LIMIT_SETTLE(){ return $this->CU_LIMIT_SETTLE; }		

	function setCU_LIMIT_MEMBER($CU_LIMIT_MEMBER){ $this->CU_LIMIT_MEMBER = $CU_LIMIT_MEMBER; }		
	function getCU_LIMIT_MEMBER(){ return $this->CU_LIMIT_MEMBER; }		

	function setCU_USEYN($CU_USEYN){ $this->CU_USEYN = $CU_USEYN; }		
	function getCU_USEYN(){ return $this->CU_USEYN; }		

	function setCU_CNT($CU_CNT){ $this->CU_CNT = $CU_CNT; }		
	function getCU_CNT(){ return $this->CU_CNT; }		

	function setCU_REG_DT($CU_REG_DT){ $this->CU_REG_DT = $CU_REG_DT; }		
	function getCU_REG_DT(){ return $this->CU_REG_DT; }		

	function setCU_REG_NO($CU_REG_NO){ $this->CU_REG_NO = $CU_REG_NO; }		
	function getCU_REG_NO(){ return $this->CU_REG_NO; }		

	function setCU_MOD_DT($CU_MOD_DT){ $this->CU_MOD_DT = $CU_MOD_DT; }		
	function getCU_MOD_DT(){ return $this->CU_MOD_DT; }		

	function setCU_MOD_NO($CU_MOD_NO){ $this->CU_MOD_NO = $CU_MOD_NO; }		
	function getCU_MOD_NO(){ return $this->CU_MOD_NO; }		

	/*********************************************************************************/

	function setCUA_NO($CUA_NO){ $this->CUA_NO = $CUA_NO; }		
	function getCUA_NO(){ return $this->CUA_NO; }		

	function setCUA_TYPE($CUA_TYPE){ $this->CUA_TYPE = $CUA_TYPE; }		
	function getCUA_TYPE(){ return $this->CUA_TYPE; }		

	function setCUA_PROD_CATE($CUA_PROD_CATE){ $this->CUA_PROD_CATE = $CUA_PROD_CATE; }		
	function getCUA_PROD_CATE(){ return $this->CUA_PROD_CATE; }		

	function setCUA_PROD_CODE($CUA_PROD_CODE){ $this->CUA_PROD_CODE = $CUA_PROD_CODE; }		
	function getCUA_PROD_CODE(){ return $this->CUA_PROD_CODE; }		

	function setCUA_CODE($CUA_CODE){ $this->CUA_CODE = $CUA_CODE; }		
	function getCUA_CODE(){ return $this->CUA_CODE; }		

	function setCUA_NO_ALL($CUA_NO_ALL){ $this->CUA_NO_ALL = $CUA_NO_ALL; }		
	function getCUA_NO_ALL(){ return $this->CUA_NO_ALL; }		

	/*--------------------------------------------------------------*/	
	function setLimitFirst($LIMIT_FIRST){ $this->LIMIT_FIRST = $LIMIT_FIRST; }		
	function getLimitFirst(){ return $this->LIMIT_FIRST; }

	function setPageLine($PAGE_LINE){ $this->PAGE_LINE = $PAGE_LINE; }		
	function getPageLine(){ return $this->PAGE_LINE; }

	function setSearchField($SEARCH_FIELD){ $this->SEARCH_FIELD = $SEARCH_FIELD; }		
	function getSearchField(){ return $this->SEARCH_FIELD; }

	function setSearchKey($SEARCH_KEY){ $this->SEARCH_KEY = $SEARCH_KEY; }		
	function getSearchKey(){ return $this->SEARCH_KEY; }

	function setSearchRegStartDt($SEARCH_REG_START_DT){ $this->SEARCH_REG_START_DT = $SEARCH_REG_START_DT; }		
	function getSearchRegStartDt(){ return $this->SEARCH_REG_START_DT; }

	function setSearchRegEndDt($SEARCH_REG_END_DT){ $this->SEARCH_REG_END_DT = $SEARCH_REG_END_DT; }		
	function getSearchRegEndDt(){ return $this->SEARCH_REG_END_DT; }

	function setSearchCouponIssue($SEARCH_COUPON_ISSUE){ $this->SEARCH_COUPON_ISSUE = $SEARCH_COUPON_ISSUE; }		
	function getSearchCouponIssue(){ return $this->SEARCH_COUPON_ISSUE; }

	function setSearchCouponUse($SEARCH_COUPON_USE){ $this->SEARCH_COUPON_USE = $SEARCH_COUPON_USE; }		
	function getSearchCouponUse(){ return $this->SEARCH_COUPON_USE; }

	/*--------------------------------------------------------------*/	
	function setCI_NO($CI_NO){ $this->CI_NO = $CI_NO; }		
	function getCI_NO(){ return $this->CI_NO; }		

	function setM_NO($M_NO){ $this->M_NO = $M_NO; }		
	function getM_NO(){ return $this->M_NO; }		
	
	function setO_NO($O_NO){ $this->O_NO = $O_NO; }		
	function getO_NO(){ return $this->O_NO; }		

	function setCI_CODE($CI_CODE){ $this->CI_CODE = $CI_CODE; }		
	function getCI_CODE(){ return $this->CI_CODE; }		

	function setCI_START_DT($CI_START_DT){ $this->CI_START_DT = $CI_START_DT; }		
	function getCI_START_DT(){ return $this->CI_START_DT; }		

	function setCI_END_DT($CI_END_DT){ $this->CI_END_DT = $CI_END_DT; }		
	function getCI_END_DT(){ return $this->CI_END_DT; }		

	function setCI_USE($CI_USE){ $this->CI_USE = $CI_USE; }		
	function getCI_USE(){ return $this->CI_USE; }		

	function setCI_USE_DT($CI_USE_DT){ $this->CI_USE_DT = $CI_USE_DT; }		
	function getCI_USE_DT(){ return $this->CI_USE_DT; }		

	function setCI_USE_O_NO($CI_USE_O_NO){ $this->CI_USE_O_NO = $CI_USE_O_NO; }		
	function getCI_USE_O_NO(){ return $this->CI_USE_O_NO; }		

	function setCI_REG_DT($CI_REG_DT){ $this->CI_REG_DT = $CI_REG_DT; }		
	function getCI_REG_DT(){ return $this->CI_REG_DT; }		

	function setCI_REG_NO($CI_REG_NO){ $this->CI_REG_NO = $CI_REG_NO; }		
	function getCI_REG_NO(){ return $this->CI_REG_NO; }	
	/********************************** variable **********************************/


}
?>