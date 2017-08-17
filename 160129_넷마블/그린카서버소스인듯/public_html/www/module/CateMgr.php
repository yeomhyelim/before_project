<?
#/*====================================================================*/# 
#|작성자	: 박영미(ivetmi@naver.com)									|# 
#|작성일	: 2012-05-11												|# 
#|작성내용	: 쇼핑몰 상품 카테고리 관리 및 아이콘 관리					|# 
#/*====================================================================*/# 

class CateMgr
{
	private $query;
	private $param;


	/*#################################### 레벨별 카테고리 불러오기 ####################################*/
	function getCateLevelAry($db)
	{
		$query  = "SELECT                                                 ";
		
		if ($this->getC_LEVEL()){
			switch ($this->getC_LEVEL()){
				case 1:
					$query .= "	SUBSTRING(A.C_CODE,1,3) CATE_CODE		";
				break;
				case 2:
					$query .= "	SUBSTRING(A.C_CODE,4,6) CATE_CODE		";
				break;
				case 3:
					$query .= "	SUBSTRING(A.C_CODE,7,9) CATE_CODE		";
				break;
				case 4:
					$query .= "	SUBSTRING(A.C_CODE,10,12) CATE_CODE		";
				break;
			}
		}
		$query .= "    ,B.CL_NAME CATE_NAME									";
		$query .= "    ,A.C_GROUP CATE_GROUP								";
		$query .= "    ,(SELECT G_NAME FROM ".TBL_MEMBER_GROUP." WHERE G_CODE = A.C_GROUP) CATE_GROUP_NM ";
		$query .= "    ,A.C_LOW_YN CATE_LOW_YN								";
//		$query .= "    ,A.C_VIEW_YN CATE_VIEW_YN							";
		$query .= "    ,B.CL_VIEW_YN CATE_VIEW_YN							";
		$query .= "    ,A.C_ORDER CATE_ORDER								";
		$query .= "    ,A.C_HCODE CATE_HCODE								";
		$query .= "    ,A.C_SHARE CATE_SHARE								";
		$query .= "    ,B.CL_IMG1 CATE_IMG1									";
		$query .= "    ,B.CL_IMG2 CATE_IMG2									";
		$query .= "    ,B.CL_LNG CATE_LNG									";
		$query .= "FROM ".TBL_CATE_MGR." A									";
		$query .= "LEFT OUTER JOIN ".TBL_CATE_LNG." B						";
		$query .= "ON A.C_CODE = B.C_CODE									";
		$query .= "AND B.CL_LNG = '".$this->getCL_LNG()."'					";
		$query .= "WHERE A.C_CODE IS NOT NULL								";
		
		if ($this->getC_LEVEL()){
			$query .= "	AND A.C_LEVEL = ".$this->getC_LEVEL()."				";
		}

		if ($this->getC_HCODE()){
			if ($this->getC_LEVEL() > 1){
				switch ($this->getC_LEVEL()){
					case 2:
						$query .= "	AND SUBSTRING(A.C_CODE,1,3) = '".$this->getC_HCODE()."'";
					break;
					case 3:
						$query .= "	AND SUBSTRING(A.C_CODE,1,6) = '".$this->getC_HCODE()."'";
					break;
					case 4:
						$query .= "	AND SUBSTRING(A.C_CODE,1,9) = '".$this->getC_HCODE()."'";
					break;
				}
			}
		}
		
		if ($this->getC_VIEW_YN() == "Y"){
			$query .= "	AND A.C_VIEW_YN = 'Y'	";
		}

		/* 관리자에서 수정되면 적용되는 부분은 이부분임 */
		if ($this->getCL_VIEW_YN() == "Y"){
			$query .= "	AND B.CL_VIEW_YN = 'Y'	";
		}

		if ($this->getC_TYPE() == "P"){
			$query .= "	AND IFNULL(A.C_TYPE,'') = 'P'	";
		} else {
			$query .= "	AND IFNULL(A.C_TYPE,'') = ''	";
		}

		$query .= "ORDER BY A.C_ORDER,A.C_CODE  ";
		//echo $query;exit;
		return $db->getArrayTotal($query);
	}

	function getProdDisplayList($db)
	{
		$query  = "SELECT * FROM ".TBL_ICON_MGR." WHERE IC_TYPE = '".$this->getIC_TYPE()."'";
		//$query .= "	AND IC_USE = 'Y' ";
		$query .= " ORDER BY IC_NO ASC ";

		return $db->getArrayTotal($query);
	}
	
	/* 가상카테고리 리스트 */
	function getCateShareList($db)
	{
		$query  = "SELECT							";
		$query .= "		S.P_CODE					";
		$query .= "	   ,S.PS_NO						";
		$query .= "    ,AI.P_NAME					";
		$query .= "    ,A.P_NUM						";
		$query .= "    ,A.P_CATE					";
		$query .= "    ,A.P_LAUNCH_DT				";
		$query .= "    ,A.P_REP_DT					";
		$query .= "    ,A.P_CONSUMER_PRICE			";
		$query .= "    ,A.P_SALE_PRICE				";
		$query .= "    ,A.P_QTY						";
		$query .= "    ,A.P_WEB_VIEW				";
		$query .= "    ,A.P_MOB_VIEW				";
		$query .= "    ,A.P_POINT					";
		$query .= "    ,A.P_EVENT_UNIT				";
		$query .= "    ,A.P_EVENT					";
		$query .= "    ,A.P_LIST_ICON				";
		$query .= "    ,B.PM_REAL_NAME				";
		$query .= "FROM ".TBL_PRODUCT_SHARE." S		";
		$query .= "JOIN ".TBL_PRODUCT_MGR." A		";
		$query .= "ON S.P_CODE = A.P_CODE			";
		$query .= "LEFT OUTER JOIN ".TBL_PRODUCT_INFO_LNG.$this->getCL_LNG()." AI	";
		$query .= "ON A.P_CODE = AI.P_CODE					";		
		$query .= "LEFT OUTER JOIN ".TBL_PRODUCT_IMG." B    ";
		$query .= "ON A.P_CODE = B.P_CODE					";
		$query .= "AND B.PM_TYPE = 'list'					";
		$query .= "WHERE S.PS_P_CATE = '".$this->getC_CODE()."'	";
		$query .= "ORDER BY S.P_CODE ASC			";
		
		return $db->getArrayTotal($query);
	}

	/*#################################### 카테고리 코드 ####################################*/
	function getCateCode($db)
	{
		if ($this->getC_LEVEL() == 1){

			$query  = "SELECT													";
			$query .= "    LPAD(IFNULL(MAX(SUBSTRING(A.C_CODE,1,3))+1,1),3,0)	";
			$query .= "FROM ".TBL_CATE_MGR." A                                  ";
			$query .= "WHERE A.C_LEVEL = ".$this->getC_LEVEL();

		} else if ($this->getC_LEVEL() == 2) {
			
			$query  = "SELECT																		";
			$query .= "    CONCAT('".$this->getC_HCODE()."',LPAD(IFNULL(MAX(SUBSTRING(A.C_CODE,4,6))+1,1),3,0))	";
			$query .= "FROM ".TBL_CATE_MGR." A                                  ";
			$query .= "WHERE SUBSTRING(A.C_CODE,1,3) = '".$this->getC_HCODE()."'	";
			$query .= "	AND A.C_LEVEL = ".$this->getC_LEVEL();

		} else if ($this->getC_LEVEL() == 3) {
			
			$query  = "SELECT																		";
			$query .= "    CONCAT('".$this->getC_HCODE()."',LPAD(IFNULL(MAX(SUBSTRING(A.C_CODE,7,9))+1,1),3,0))	";
			$query .= "FROM ".TBL_CATE_MGR." A														";
			$query .= "WHERE SUBSTRING(A.C_CODE,1,6) = '".$this->getC_HCODE()."'					";
			$query .= "	AND A.C_LEVEL = ".$this->getC_LEVEL();
		
		} else if ($this->getC_LEVEL() == 4) {

			$query  = "SELECT																		";
			$query .= "    CONCAT('".$this->getC_HCODE()."',LPAD(IFNULL(MAX(SUBSTRING(A.C_CODE,10,12))+1,1),3,0))	";
			$query .= "FROM ".TBL_CATE_MGR." A														";
			$query .= "WHERE SUBSTRING(A.C_CODE,1,9) = '".$this->getC_HCODE()."'					";
			$query .= "	AND A.C_LEVEL = ".$this->getC_LEVEL();
		
		}

		return $db->getCount($query);
	}
	/*#################################### 카테고리 View ####################################*/
	function getView($db)
	{
		$query  = "SELECT A.*,B.* FROM ".TBL_CATE_MGR." A	";
		$query .= "LEFT OUTER JOIN ".TBL_CATE_LNG." B		";
		$query .= "ON A.C_CODE = B.C_CODE					";
		$query .= "AND B.CL_LNG = '".$this->getCL_LNG()."'	";
		$query .= "WHERE A.C_CODE = '".$this->getC_CODE()."'";
		
		return $db->getSelect($query);
	}

	function getCateLevelName($db)
	{
		$query  = "SELECT B.CL_NAME FROM ".TBL_CATE_MGR." A	";
		$query .= "LEFT OUTER JOIN ".TBL_CATE_LNG." B		";
		$query .= "ON A.C_CODE = B.C_CODE					";
		$query .= "AND B.CL_LNG = '".$this->getCL_LNG()."'	";
		$query .= "WHERE A.C_CODE = '".$this->getC_CODE()."'";
		
		return $db->getCount($query);
	}

	function getProdIconView($db)
	{
		$query = "SELECT A.* FROM ".TBL_ICON_MGR." A WHERE A.IC_NO = '".$this->getIC_NO()."'";
		return $db->getSelect($query);
	}
	
	/* 쿠폰에서 카테고리 정보 알기 */
	function getCouponView($db)
	{
		$query  = "SELECT A.*,B.* FROM ".TBL_CATE_MGR." A	";
		$query .= "LEFT OUTER JOIN ".TBL_CATE_LNG." B		";
		$query .= "ON A.C_CODE = B.C_CODE					";
		$query .= "AND B.CL_LNG = '".$this->getCL_LNG()."'	";
		$query .= "WHERE RPAD(A.C_CODE,12,0) = '".$this->getC_CODE()."'";

		return $db->getSelect($query);
	}


	/*#################################### 카테고리 등록하기 ####################################*/
	function getInsert($db)
	{
		$query = "CALL SP_CATE_MGR_I (?,?,?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getC_CODE();
		$param[]  = $this->getC_LEVEL();
		$param[]  = $this->getC_LOW_YN();
		$param[]  = $this->getC_HCODE();
		$param[]  = $this->getC_GROUP();
		$param[]  = $this->getC_ORDER();
		$param[]  = $this->getC_VIEW_YN();
		$param[]  = $this->getCL_LNG();
		$param[]  = $this->getCL_NAME();
		$param[]  = $this->getCL_IMG1();
		$param[]  = $this->getCL_IMG2();
		$param[]  = $this->getC_SHARE();
		$param[]  = $this->getC_REG_NO();

		return $db->executeBindingQuery($query,$param,true);
	}


	function getCateLngInsert($db)
	{
		$query = "CALL SP_CATE_LNG_I (?,?,?,?,?,?);";

		$param[]  = $this->getC_CODE();
		$param[]  = $this->getCL_LNG();
		$param[]  = $this->getCL_NAME();
		$param[]  = $this->getCL_IMG1();
		$param[]  = $this->getCL_IMG2();
		$param[]  = $this->getC_VIEW_YN();
		
		return $db->executeBindingQuery($query,$param,true);
	}

	function getProdIconInsert($db)
	{
		$query  = "INSERT INTO ".TBL_ICON_MGR." (IC_TYPE,IC_CODE,IC_NAME,IC_IMG,IC_USE,IC_REG_DT,IC_REG_NO) VALUES (";
		$query .= " '".mysql_real_escape_string($this->getIC_TYPE())."'";
		$query .= ",'".mysql_real_escape_string($this->getIC_CODE())."'";
		$query .= ",'".mysql_real_escape_string($this->getIC_NAME())."'";
		$query .= ",'".mysql_real_escape_string($this->getIC_IMG())."'";
		$query .= ",'".mysql_real_escape_string($this->getIC_USE())."'";
		$query .= ",now()";
		$query .= ",'".mysql_real_escape_string($this->getIC_REG_NO())."'";		
		$query .= ")";


		return $db->getExecSql($query);

	}	


	/********************************** Modify **********************************/
	function getUpdate($db)
	{
		$query = "CALL SP_CATE_MGR_U (?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getC_CODE();
		$param[]  = $this->getCL_LNG();
		$param[]  = $this->getCL_NAME();
		$param[]  = $this->getC_GROUP();
		$param[]  = $this->getC_ORDER();
		$param[]  = $this->getC_VIEW_YN();
		$param[]  = $this->getCL_IMG1();
		$param[]  = $this->getCL_IMG2();
		$param[]  = $this->getC_SHARE();
		$param[]  = $this->getC_MOD_NO();

		return $db->executeBindingQuery($query,$param,true);
	}

	function getProdDisplayUpdate($db)
	{		
		$query  = "UPDATE ".TBL_ICON_MGR." SET ";
		$query .= "   IC_NAME	= '".mysql_real_escape_string($this->getIC_NAME())."'";
		$query .= "  ,IC_USE	= '".mysql_real_escape_string($this->getIC_USE())."'";
		$query .= "	WHERE IC_NO = ".mysql_real_escape_string($this->getIC_NO());
		
		return $db->getExecSql($query);
	}

	function getProdIconUpdate($db)
	{		
		$query  = "UPDATE ".TBL_ICON_MGR." SET ";
		$query .= "   IC_IMG	= '".mysql_real_escape_string($this->getIC_IMG())."'";
		$query .= "  ,IC_USE	= '".mysql_real_escape_string($this->getIC_USE())."'";
		$query .= "	WHERE IC_NO = ".mysql_real_escape_string($this->getIC_NO());
		
		return $db->getExecSql($query);
	}
	
	function getCatePlanUpdate($db){
		$query  = "UPDATE ".TBL_CATE_MGR." SET C_TYPE ='".mysql_real_escape_string($this->getC_TYPE())."'";
		$query .= " WHERE C_CODE = '".mysql_real_escape_string($this->getC_CODE())."'	";
	
		return $db->getExecSql($query);
	}
	/********************************** Delete **********************************/
	function getDelete($db)
	{
		$query = "CALL SP_CATE_MGR_D (?);";
		$param[]  = $this->getC_CODE();

		return $db->executeBindingQuery($query,$param,true);
	}

	function getProdIconDelete($db)
	{
		$query = "DELETE FROM ".TBL_ICON_MGR." WHERE IC_NO = ".mysql_real_escape_string($this->getIC_NO());
		
		return $db->getExecSql($query);
	}

	/********************************** 하위 카테고리 확인 **********************************/
	function getLowCount($db)
	{
		$query = "SELECT COUNT(*) FROM ".TBL_CATE_MGR." WHERE C_HCODE LIKE '".$this->getC_HCODE()."%'";

		if ($this->getC_TYPE()){
			$query .= " AND C_TYPE = '".$this->getC_TYPE()."'	";
		}

		return $db->getCount($query);
	}


	/********************************** variable **********************************/
	function setC_CODE($C_CODE){ $this->C_CODE = $C_CODE; }		
	function getC_CODE(){ return $this->C_CODE; }		

	function setC_NAME($C_NAME){ $this->C_NAME = $C_NAME; }		
	function getC_NAME(){ return $this->C_NAME; }		

	function setC_LEVEL($C_LEVEL){ $this->C_LEVEL = $C_LEVEL; }		
	function getC_LEVEL(){ return $this->C_LEVEL; }		

	function setC_LOW_YN($C_LOW_YN){ $this->C_LOW_YN = $C_LOW_YN; }		
	function getC_LOW_YN(){ return $this->C_LOW_YN; }		

	function setC_HCODE($C_HCODE){ $this->C_HCODE = $C_HCODE; }		
	function getC_HCODE(){ return $this->C_HCODE; }		

	function setC_GROUP($C_GROUP){ $this->C_GROUP = $C_GROUP; }		
	function getC_GROUP(){ return $this->C_GROUP; }		

	function setC_ORDER($C_ORDER){ $this->C_ORDER = $C_ORDER; }		
	function getC_ORDER(){ return $this->C_ORDER; }		

	function setC_VIEW_YN($C_VIEW_YN){ $this->C_VIEW_YN = $C_VIEW_YN; }		
	function getC_VIEW_YN(){ return $this->C_VIEW_YN; }		

	function setC_HCODE1($C_HCODE1){ $this->C_HCODE1 = $C_HCODE1; }		
	function getC_HCODE1(){ return $this->C_HCODE1; }		

	function setC_HCODE2($C_HCODE2){ $this->C_HCODE2 = $C_HCODE2; }		
	function getC_HCODE2(){ return $this->C_HCODE2; }		

	function setC_HCODE3($C_HCODE3){ $this->C_HCODE3 = $C_HCODE3; }		
	function getC_HCODE3(){ return $this->C_HCODE3; }		

	function setC_HCODE4($C_HCODE4){ $this->C_HCODE4 = $C_HCODE4; }		
	function getC_HCODE4(){ return $this->C_HCODE4; }		

	function setC_IMG1($C_IMG1){ $this->C_IMG1 = $C_IMG1; }		
	function getC_IMG1(){ return $this->C_IMG1; }		

	function setC_IMG2($C_IMG2){ $this->C_IMG2 = $C_IMG2; }		
	function getC_IMG2(){ return $this->C_IMG2; }

	function setC_SHARE($C_SHARE){ $this->C_SHARE = $C_SHARE; }		
	function getC_SHARE(){ return $this->C_SHARE; }

	function setC_TYPE($C_TYPE){ $this->C_TYPE = $C_TYPE; }		
	function getC_TYPE(){ return $this->C_TYPE; }

	function setC_REG_DT($C_REG_DT){ $this->C_REG_DT = $C_REG_DT; }		
	function getC_REG_DT(){ return $this->C_REG_DT; }		

	function setC_REG_NO($C_REG_NO){ $this->C_REG_NO = $C_REG_NO; }		
	function getC_REG_NO(){ return $this->C_REG_NO; }		

	function setC_MOD_DT($C_MOD_DT){ $this->C_MOD_DT = $C_MOD_DT; }		
	function getC_MOD_DT(){ return $this->C_MOD_DT; }		

	function setC_MOD_NO($C_MOD_NO){ $this->C_MOD_NO = $C_MOD_NO; }		
	function getC_MOD_NO(){ return $this->C_MOD_NO; }		


	function setIC_NO($IC_NO){ $this->IC_NO = $IC_NO; }		
	function getIC_NO(){ return $this->IC_NO; }		

	function setIC_TYPE($IC_TYPE){ $this->IC_TYPE = $IC_TYPE; }		
	function getIC_TYPE(){ return $this->IC_TYPE; }		

	function setIC_CODE($IC_CODE){ $this->IC_CODE = $IC_CODE; }		
	function getIC_CODE(){ return $this->IC_CODE; }		

	function setIC_NAME($IC_NAME){ $this->IC_NAME = $IC_NAME; }		
	function getIC_NAME(){ return $this->IC_NAME; }		

	function setIC_IMG($IC_IMG){ $this->IC_IMG = $IC_IMG; }		
	function getIC_IMG(){ return $this->IC_IMG; }		

	function setIC_USE($IC_USE){ $this->IC_USE = $IC_USE; }		
	function getIC_USE(){ return $this->IC_USE; }		

	function setIC_REG_DT($IC_REG_DT){ $this->IC_REG_DT = $IC_REG_DT; }		
	function getIC_REG_DT(){ return $this->IC_REG_DT; }		

	function setIC_REG_NO($IC_REG_NO){ $this->IC_REG_NO = $IC_REG_NO; }		
	function getIC_REG_NO(){ return $this->IC_REG_NO; }		

	function setIC_MOD_DT($IC_MOD_DT){ $this->IC_MOD_DT = $IC_MOD_DT; }		
	function getIC_MOD_DT(){ return $this->IC_MOD_DT; }		

	function setIC_MOD_NO($IC_MOD_NO){ $this->IC_MOD_NO = $IC_MOD_NO; }		
	function getIC_MOD_NO(){ return $this->IC_MOD_NO; }		

	function setCL_NO($CL_NO){ $this->CL_NO = $CL_NO; }		
	function getCL_NO(){ return $this->CL_NO; }		

	function setCL_LNG($CL_LNG){ $this->CL_LNG = $CL_LNG; }		
	function getCL_LNG(){ return $this->CL_LNG; }		

	function setCL_NAME($CL_NAME){ $this->CL_NAME = $CL_NAME; }		
	function getCL_NAME(){ return $this->CL_NAME; }		

	function setCL_IMG1($CL_IMG1){ $this->CL_IMG1 = $CL_IMG1; }		
	function getCL_IMG1(){ return $this->CL_IMG1; }		

	function setCL_IMG2($CL_IMG2){ $this->CL_IMG2 = $CL_IMG2; }		
	function getCL_IMG2(){ return $this->CL_IMG2; }		

	function setCL_VIEW_YN($CL_VIEW_YN){ $this->CL_VIEW_YN = $CL_VIEW_YN; }		
	function getCL_VIEW_YN(){ return $this->CL_VIEW_YN; }	
	/*--------------------------------------------------------------*/	
	
	
	/********************************** variable **********************************/


}
?>